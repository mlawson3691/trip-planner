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
        return $app['twig']->render('index.html.twig');
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
        return $app['twig']->render('trip.html.twig', array('review' => $review, 'user' => $user));
    });

// search results
    $app->post('/search_results', function() use ($app) {
        $search_results = City::search($_POST['search_input']);
        return $app['twig']->render('search_results.html.twig', array('results' => $search_results));
    });

// signup page
    $app->get('/sign_up', function() use ($app) {
        return $app['twig']->render('sign_up.html.twig');
    });

// submit sign up form
    $app->post('/sign_up', function() use ($app) {
        $username = $_POST['username'];
        $password = sha1($_POST['password']);
        $new_user = new User($username, $password);
        $new_user->save();
        $_SESSION['current_user'] = $new_user;
        return $app['twig']->render('user_dashboard.html.twig', array('user' => $new_user));
    });

// submit login form
    $app->post('/login', function() use ($app) {
        $username = $_POST['username'];
        $password = sha1($_POST['password']);
        $valid = User::verifyLogin($username, $password);
        if ($valid == false) {
            return $app->redirect('/');
        }
        return $app['twig']->render('user_dashboard.html.twig', array('user' => $_SESSION['current_user']));
    });

// log out
    $app->get('/logout', function() use ($app) {
        $_SESSION['current_user'] = null;
        return $app->redirect('/');
    });

// past trips in dashboard
    $app->get('/past_trips/{id}', function($id) use ($app) {
        $user = User::findById($id);
        $trips = $user->getTrips();
        return $app['twig']->render('past_trips.html.twig', array('user' => $user, 'trips' => $trips));
    });

// pending user trips
    $app->get('/pending_trips/{id}', function($id) use ($app) {
    $user = User::findById($id);
    $trips = $user->getTrips();
    return $app['twig']->render('pending_trips.html.twig', array('user' => $user, 'trips' => $trips));
    });

// new trip
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
    return $app->redirect('/pending_trips/' . $id);
    });

    return $app;

?>
