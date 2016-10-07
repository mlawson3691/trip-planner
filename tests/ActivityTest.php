<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Activity.php';
    require_once 'src/Trip.php';

    $server = 'mysql:host=localhost:8889;dbname=trip_planner_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ActivityTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Activity::deleteAll();
            Trip::deleteAll();
        }

        function test_getId()
        {
            $name = "Mall";
            $date = "10/02/2016";
            $trip_id = 1;
            $descrition = "Shopping spree";
            $new_activity = new Activity($name, $date, $trip_id, $descrition);
            $new_activity->save();

            $output = $new_activity->getId();

            $this->assertEquals(true, is_numeric($output));
        }

        function test_save()
        {
            $name = "Mall";
            $date = "10/02/2016";
            $trip_id = 1;
            $descrition = "Shopping spree";
            $new_activity = new Activity($name, $date, $trip_id, $descrition);
            $new_activity->save();

            $output = Activity::getAll();

            $this->assertEquals([$new_activity], $output);
        }

        function test_getAll()
        {
            $name = "Mall";
            $date = "10/02/2016";
            $trip_id = 1;
            $descrition = "Shopping spree";
            $new_activity = new Activity($name, $date, $trip_id, $descrition);
            $new_activity->save();

            $output = Activity::getAll();

            $this->assertEquals([$new_activity], $output);
        }

        function test_deleteAll()
        {
            $name = "Mall";
            $date = "10/02/2016";
            $trip_id = 1;
            $descrition = "Shopping spree";
            $new_activity = new Activity($name, $date, $trip_id, $descrition);
            $new_activity->save();

            Activity::deleteAll();
            $output = Activity::getAll();

            $this->assertEquals([], $output);
        }

        function test_delete()
        {
            $name = "Mall";
            $date = "10/02/2016";
            $trip_id = 1;
            $descrition = "Shopping spree";
            $new_activity = new Activity($name, $date, $trip_id, $descrition);
            $new_activity->save();

            $name2 = "Mall";
            $date2 = "10/02/2016";
            $trip_id2 = 1;
            $descrition2 = "Shopping spree";
            $new_activity2 = new Activity($name2, $date2, $trip_id2, $descrition2);
            $new_activity2->save();

            $new_activity->delete();
            $output = Activity::getAll();

            $this->assertEquals([$new_activity2], $output);
        }

        function test_findById()
        {
            $name = "Mall";
            $date = "10/02/2016";
            $trip_id = 1;
            $descrition = "Shopping spree";
            $new_activity = new Activity($name, $date, $trip_id, $descrition);
            $new_activity->save();

            $output = Activity::findById($new_activity->getId());

            $this->assertEquals($new_activity, $output);
        }

        function test_update()
        {
            $name = "Mall";
            $date = "10/02/2016";
            $trip_id = 1;
            $descrition = "Shopping spree";
            $new_activity = new Activity($name, $date, $trip_id, $descrition);
            $new_activity->save();
            $new_name = "Pioneer Mall";

            $new_activity->update($new_name, $date, $descrition);

            $this->assertEquals('Pioneer Mall', $new_activity->getName());
        }

        function test_cleanUp()
        {
            $name = "Biggy's Mall";
            $date = "10/02/2016";
            $trip_id = 1;
            $descrition = "Shopping spree";
            $new_activity = new Activity($name, $date, $trip_id, $descrition);
            $new_activity->save();

            $new_activity->setName(Activity::cleanUp($name));
            $output = $new_activity->getName(); 

            $this->assertEquals('Biggys Mall', $output);
        }
    }

?>
