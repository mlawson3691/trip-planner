<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/City.php';
    require_once 'src/Review.php';
    require_once 'src/Trip.php';

    $server = 'mysql:host=localhost;dbname=trip_planner_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CityTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            City::deleteAll();
            Review::deleteAll();
            Trip::deleteAll();
        }

        function test_getId()
        {
            $name = "Portland";
            $state = "Oregon";
            $new_city = new City($name, $state);
            $new_city->save();

            $output = $new_city->getId();

            $this->assertEquals(true, is_numeric($output));
        }

        function test_save()
        {
            $name = "Portland";
            $state = "Oregon";
            $new_city = new City($name, $state);
            $new_city->save();

            $output = City::getAll();

            $this->assertEquals([$new_city], $output);
        }

        function test_saveDuplicates()
        {
            $name = "Portland";
            $state = "Oregon";
            $new_city = new City($name, $state);
            $new_city->save();
            $new_city->save();

            $output = City::getAll();

            $this->assertEquals([$new_city], $output);
        }

        function test_getAll()
        {
            $name = "Portland";
            $state = "Oregon";
            $new_city = new City($name, $state);
            $new_city->save();

            $name2 = "Seattle";
            $state2 = "Washington";
            $new_city2 = new City($name2, $state2);
            $new_city2->save();

            $output = City::getAll();

            $this->assertEquals([$new_city, $new_city2], $output);
        }

        function test_deleteAll()
        {
            $name = "Portland";
            $state = "Oregon";
            $new_city = new City($name, $state);
            $new_city->save();

            City::deleteAll();
            $output = City::getAll();

            $this->assertEquals([], $output);
        }

        function test_findById()
        {
            $name = "Portland";
            $state = "Oregon";
            $new_city = new City($name, $state);
            $new_city->save();

            $output = City::findById($new_city->getId());

            $this->assertEquals($new_city, $output);
        }

        function test_update()
        {
            $name = "Portland";
            $state = "Oregon";
            $new_city = new City($name, $state);
            $new_city->save();
            $new_name = "Beaverton";

            $new_city->update($new_name, $state);

            $this->assertEquals('Beaverton', $new_city->getName());
        }

        function test_getReviews()
        {
            $name = "Portland";
            $state = "Oregon";
            $new_city = new City($name, $state);
            $new_city->save();

            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $user_id = 2;
            $new_trip = new Trip($name, $user_id, $description);
            $new_trip->save();
            $new_trip->addCity($new_city->getId());

            $title = "Best trip ever";
            $description = "Yay!";
            $rating = 10;
            $trip_id = $new_trip->getId();
            $new_review = new Review($title, $description, $rating, $trip_id);
            $new_review->save();

            $output = $new_city->getReviews();

            $this->assertEquals([$new_review], $output);
        }

        function test_search()
        {
            $name = "Portland";
            $state = "Oregon";
            $new_city = new City($name, $state);
            $new_city->save();

            $name2 = "Seattle";
            $state2 = "Washington";
            $new_city2 = new City($name2, $state2);
            $new_city2->save();
            $search_input = 'port';

            $output = City::search($search_input);

            $this->assertEquals([$new_city], $output);
        }
    }
?>
