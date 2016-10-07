<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once 'src/Review.php';
    require_once 'src/Trip.php';

    $server = 'mysql:host=localhost:8889;dbname=trip_planner_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ReviewTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Review::deleteAll();
            Trip::deleteAll();
        }

        function test_getId()
        {
            $title = "Best trip";
            $description = "Yay!";
            $rating = 10;
            $trip_id = 1;
            $new_review = new Review($title, $description, $rating, $trip_id);
            $new_review->save();

            $output = $new_review->getId();

            $this->assertEquals(true, is_numeric($output));
        }

        function test_getTitle()
        {
            $title = "Best trip";
            $description = "Yay!";
            $rating = 10;
            $trip_id = 1;
            $new_review = new Review($title, $description, $rating, $trip_id);
            $new_review->save();

            $output = $new_review->getTitle();

            $this->assertEquals($title, $output);
        }

        function test_setTitle()
        {
            $title = "Best trip";
            $description = "Yay!";
            $rating = 10;
            $trip_id = 1;
            $new_review = new Review($title, $description, $rating, $trip_id);
            $new_review->save();

            $new_title = "Not so fun";
            $new_review->setTitle($new_title);

            $output = $new_review->getTitle();

            $this->assertEquals($new_title, $output);
        }

        function test_save()
        {
            $title = "Best trip";
            $description = "Yay!";
            $rating = 10;
            $trip_id = 1;
            $new_review = new Review($title, $description, $rating, $trip_id);
            $new_review->save();

            $output = Review::getAll();

            $this->assertEquals([$new_review], $output);
        }

        function test_getAll()
        {
            $title = "Best trip";
            $description = "Yay!";
            $rating = 10;
            $trip_id = 1;
            $new_review = new Review($title, $description, $rating, $trip_id);
            $new_review->save();

            $output = Review::getAll();

            $this->assertEquals([$new_review], $output);
        }

        function test_deleteAll()
        {
            $title = "Best trip";
            $description = "Yay!";
            $rating = 10;
            $trip_id = 1;
            $new_review = new Review($title, $description, $rating, $trip_id);
            $new_review->save();

            $title2 = "Worst trip";
            $description2 = "Boo!";
            $rating2 = 1;
            $trip_id2 = 1;
            $new_review2 = new Review($title2, $description2, $rating2, $trip_id2);
            $new_review2->save();

            $output = Review::getAll();

            $this->assertEquals([$new_review, $new_review2], $output);
        }

        function test_findById()
        {
            $title = "Best trip";
            $description = "Yay!";
            $rating = 10;
            $trip_id = 1;
            $new_review = new Review($title, $description, $rating, $trip_id);
            $new_review->save();

            $output = Review::findById($new_review->getId());

            $this->assertEquals($new_review, $output);
        }

        function test_update()
        {
            $title = "Best trip";
            $description = "Yay!";
            $rating = 10;
            $trip_id = 1;
            $new_review = new Review($title, $description, $rating, $trip_id);
            $new_review->save();
            $new_rating = 5;

            $new_review->update($title, $description, $new_rating);
            $output = $new_review->getRating();

            $this->assertEquals($new_rating, $output);
        }

        function test_delete()
        {
            $title = "Best trip";
            $description = "Yay!";
            $rating = 10;
            $trip_id = 1;
            $new_review = new Review($title, $description, $rating, $trip_id);
            $new_review->save();

            $title2 = "Worst trip";
            $description2 = "Boo!";
            $rating2 = 1;
            $trip_id2 = 1;
            $new_review2 = new Review($title2, $description2, $rating2, $trip_id2);
            $new_review2->save();

            $new_review->delete();
            $output = Review::getAll();

            $this->assertEquals([$new_review2], $output);
        }
    }
?>
