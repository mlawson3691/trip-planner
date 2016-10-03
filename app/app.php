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

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=trip_planner';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

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

    //appends all cities in selected state to right column
    $app->get('/citiesByState/{state}', function($state) use ($app) {
        $cities = City::citiesInState($state);
        return $app['twig']->render('browse.html.twig', array('states' => $states, 'cities' => $cities));
    });

    return $app;
?>
