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

// from review title to trip page
    $app->get('/trip/{id}', function($id) use ($app) {
        $review = Review::findById($id);
        $trip = Trip::findById($review->getTripId());
        $user = User::findById($trip->getUserId());
        $activities = $trip->getActivities();
        $cities = $trip->getCities();
        return $app['twig']->render('trip.html.twig', array('review' => $review, 'user' => $user, 'activities' => $activities, 'cities' => $cities, 'alert' => null));
    });

// add activity to trip
    $app->post('/trip/{id}', function($id) use ($app) {
        $name = $_POST['name'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $trip_id = $id;
        $new_activity = new Activity($name, $date, $description, $trip_id);
        $new_activity->save();
        $review = Review::findById($id);
        $trip = Trip::findById($review->getTripId());
        $user = User::findById($trip->getUserId());
        $activities = $trip->getActivities();
        $cities = $trip->getCities();

        return $app['twig']->render('trip.html.twig', array('review' => $review, 'user' => $user, 'activities' => $activities, 'cities' => $cities, 'alert' => 'add_activity'));
    });

// update activity for trip
    $app->patch('/trip/{id}', function($id) use ($app) {
        $name = $_POST['name'];
        $date = $_POST['date'];
        $description = $_POST['description'];
        $trip_id = $id;
        $new_activity->update($name, $date, $description);
        $review = Review::findById($id);
        $trip = Trip::findById($review->getTripId());
        $user = User::findById($trip->getUserId());
        $activities = $trip->getActivities();
        $cities = $trip->getCities();

        return $app['twig']->render('trip.html.twig', array('review' => $review, 'user' => $user, 'activities' => $activities, 'cities' => $cities, 'alert' => 'update_activity'));
    });

// delete activity for trip
    $app->delete('/trip/{id}', function($id) use ($app) {
        $found_activity = Activity::findById($_POST['activity_id']);
        $found_activity->delete();
        $review = Review::findById($id);
        $trip = Trip::findById($review->getTripId());
        $user = User::findById($trip->getUserId());
        $activities = $trip->getActivities();
        $cities = $trip->getCities();

        return $app['twig']->render('trip.html.twig', array('review' => $review, 'user' => $user, 'activities' => $activities, 'cities' => $cities, 'alert' => 'delete_activity'));
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
            return $app['twig']->render('user.html.twig', array('user' => $new_user, 'alert' => 'login-success'));
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
        return $app['twig']->render('user.html.twig', array('user' => $_SESSION['current_user'], 'alert' => 'login-success'));
    });

// log out
    $app->get('/logout', function() use ($app) {
        $_SESSION['current_user'] = null;
        return $app['twig']->render('index.html.twig', array('alert' => 'logout'));
    });
    return $app;
?>
