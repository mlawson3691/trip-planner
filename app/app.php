<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Activity.php";
    require_once __DIR__."/../src/City.php";
    require_once __DIR__."/../src/Review.php";
    require_once __DIR__."/../src/Trip.php";
    require_once __DIR__."/../src/User.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    session_start();
    if (empty($_SESSION['current_user'])) {
        $_SESSION['current_user'] = null;
    }

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=trip_planner';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

// home page
    $app->get('/', function() use ($app) {
        return $app['twig']->render('index.html.twig', array('alert' => null));
    });

// leads to individual city page
    $app->get('/city/{id}', function($id) use ($app) {
        $city = City::findById($id);
        return $app['twig']->render('city.html.twig', array('city' => $city));
    });

// leads to browse (by state) page
    $app->get('/browse', function() use ($app) {
        $states = City::getStates();
        return $app['twig']->render('browse.html.twig', array('states' => $states, 'cities' => null));
    });

// appends all cities to right column when state is clicked
    $app->get('/citiesByState/{state}', function($state) use ($app) {
        $cities = City::citiesInState($state);
        return $app['twig']->render('browse.html.twig', array('states' => $states, 'cities' => $cities));
    });

// view trip page
    $app->get('/trip/{id}', function($id) use ($app) {
        $trip = Trip::findById($id);
        $review = $trip->getReview();
        $user = User::findById($trip->getUserId());
        $activities = $trip->getActivities();
        $cities = $trip->getCities();
        return $app['twig']->render('trip.html.twig', array('trip' => $trip, 'review' => $review, 'user' => $user, 'activities' => $activities, 'trip_cities' => $cities, 'alert' => null, 'current_user' => $_SESSION['current_user'], 'all_cities' => City::getAll()));
    });

// add activity to trip
    $app->post('/trip/{id}', function($id) use ($app) {
        $trip = Trip::findById($id);
        $name = $_POST['name'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $trip_id = $trip->getId();
        $new_activity = new Activity($name, $date, $trip_id, $description);
        $new_activity->save();

        $review = $trip->getReview();
        $user = User::findById($trip->getUserId());
        $activities = $trip->getActivities();
        $cities = $trip->getCities();

        return $app['twig']->render('trip.html.twig', array('trip' => $trip, 'review' => $review, 'user' => $user, 'activities' => $activities, 'trip_cities' => $cities, 'alert' => 'add_activity', 'current_user' => $_SESSION['current_user'], 'all_cities' => City::getAll()));
    });

// update activity for trip
    $app->patch('/trip/{id}/{activity_id}', function($id, $activity_id) use ($app) {
        $name = $_POST['name'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $trip_id = $id;
        $new_activity = Activity::findById($activity_id);
        $new_activity->update($name, $date, $description);
        $trip = Trip::findById($id);
        $review = $trip->getReview();
        $user = User::findById($trip->getUserId());
        $activities = $trip->getActivities();
        $cities = $trip->getCities();

        return $app['twig']->render('trip.html.twig', array('trip' => $trip, 'review' => $review, 'user' => $user, 'activities' => $activities, 'trip_cities' => $cities, 'alert' => 'update_activity', 'current_user' => $_SESSION['current_user'], 'all_cities' => City::getAll()));
    });

// delete activity for trip
    $app->delete('/trip/{id}', function($id) use ($app) {
        $found_activity = Activity::findById($_POST['activity_id']);
        $found_activity->delete();
        $trip = Trip::findById($id);
        $review = $trip->getReview();
        $user = User::findById($trip->getUserId());
        $activities = $trip->getActivities();
        $cities = $trip->getCities();

        return $app['twig']->render('trip.html.twig', array('trip' => $trip, 'review' => $review, 'user' => $user, 'activities' => $activities, 'trip_cities' => $cities, 'alert' => 'delete_activity', 'current_user' => $_SESSION['current_user'], 'all_cities' => City::getAll()));
    });

// add city to trip
    $app->post('/trip/city/{id}', function($id) use ($app) {
        $trip = Trip::findById($id);
        $trip->addCity($_POST['city_id']);
        $review = $trip->getReview();
        $user = User::findById($trip->getUserId());
        $activities = $trip->getActivities();
        $cities = $trip->getCities();

        return $app['twig']->render('trip.html.twig', array('trip' => $trip, 'review' => $review, 'user' => $user, 'activities' => $activities, 'trip_cities' => $cities, 'alert' => 'add_city', 'current_user' => $_SESSION['current_user'], 'all_cities' => City::getAll()));
    });

    $app->post('/trip/new_city/{id}', function($id) use ($app) {
        $name = $_POST['name'];
        $state = $_POST['state'];
        $new_city = new City($name, $state);
        $new_city->save();
        $trip = Trip::findById($id);
        $trip->addCity($new_city->getId());
        $review = $trip->getReview();
        $user = User::findById($trip->getUserId());
        $activities = $trip->getActivities();
        $cities = $trip->getCities();

        return $app['twig']->render('trip.html.twig', array('trip' => $trip, 'review' => $review, 'user' => $user, 'activities' => $activities, 'trip_cities' => $cities, 'alert' => 'add_city', 'current_user' => $_SESSION['current_user'], 'all_cities' => City::getAll()));
    });
// search results
    $app->post('/search_results', function() use ($app) {
        $search_results = City::search($_POST['search_input']);
        return $app['twig']->render('search_results.html.twig', array('results' => $search_results));
    });

// signup page
    $app->get('/sign_up', function() use ($app) {
        return $app['twig']->render('sign_up.html.twig', array('alert' => null));
    });

// submit sign up form
    $app->post('/sign_up', function() use ($app) {
        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $new_user = new User($username, $password);
        $valid = $new_user->save();
        if ($valid == true) {
            $_SESSION['current_user'] = $new_user;
            return $app['twig']->render('user_dashboard.html.twig', array('user' => $new_user, 'alert' => 'login-success'));
        } else {
            return $app['twig']->render('sign_up.html.twig', array('alert' => 'signup'));
        }
    });

// submit login form
    $app->post('/login', function() use ($app) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $valid = User::verifyLogin($username, $password);
        if ($valid == false) {
            return $app['twig']->render('index.html.twig', array('alert' => 'login'));
        }
        return $app['twig']->render('user_dashboard.html.twig', array('user' => $_SESSION['current_user'], 'alert' => 'login-success'));
    });

// log out
    $app->get('/logout', function() use ($app) {
        $_SESSION['current_user'] = null;
        return $app['twig']->render('index.html.twig', array('alert' => 'logout'));
    });

// past trips in dashboard
    $app->get('/past_trips/{id}', function($id) use ($app) {
        $user = User::findById($id);
        $trips = $user->getPastTrips($user->getTrips());
        return $app['twig']->render('past_trips.html.twig', array('user' => $user, 'trips' => $trips));
    });

// pending user trips
    $app->get('/pending_trips/{id}', function($id) use ($app) {
        $user = User::findById($id);
        $trips = $user->getPendingTrips($user->getTrips());
        return $app['twig']->render('pending_trips.html.twig', array('user' => $user, 'trips' => $trips));
    });

// new trip page
    $app->get('/new_trip/{id}', function($id) use ($app) {
        $user = User::findById($id);
        return $app['twig']->render('new_trip.html.twig', array('user' => $user));
    });

// add new trip
    $app->post('/new_trip/{id}', function($id) use ($app) {
        $user = User::findById($id);
        $name = $_POST['purpose'];
        $user_id = $user->getId();
        $description = $_POST['description'];
        $new_trip = new Trip($name, $user_id, 0, $description);
        $new_trip->save();
        return $app['twig']->render('trip.html.twig', array('trip' => $new_trip, 'review' => null, 'user' => $user, 'activities' => null, 'trip_cities' => null, 'alert' => null, 'current_user' => $_SESSION['current_user'], 'all_cities' => City::getAll()));
    });


    return $app;

?>
