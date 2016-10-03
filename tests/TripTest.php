<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/Trip.php";
    require_once "src/City.php";

    $server = 'mysql:host=localhost;dbname=trip_planner_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class TripTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Trip::deleteAll();
            City::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = 1;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);

            //Act
            $result = $new_trip->getName();

            //Assert
            $this->assertEquals($name, $result);
        }
        
        function test_getDescription()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = 1;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);

            //Act
            $result = $new_trip->getDescription();

            //Assert
            $this->assertEquals($description, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = 1;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);

            //Act
            $result = $new_trip->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_getUserId()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = 1;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);

            //Act
            $result = $new_trip->getUserId();

            //Assert
            $this->assertEquals(2, $result);
        }

        function test_getReviewId()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = 1;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);

            //Act
            $result = $new_trip->getReviewId();

            //Assert
            $this->assertEquals(3, $result);
        }

        function test_setName()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = 1;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);

            //Act
            $new_name = "DivorceMoon";
            $new_trip->setName($new_name);
            $result = $new_trip->getName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_setDescription()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = 1;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);

            //Act
            $new_description = "DivorceMoon";
            $new_trip->setDescription($new_description);
            $result = $new_trip->getDescription();

            //Assert
            $this->assertEquals($new_description, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = null;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);
            $new_trip->save();

            //Act
            $result = Trip::getAll();

            //Assert
            $this->assertEquals([$new_trip], $result);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = null;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);
            $new_trip->save();

            $name2 = "Honeymoon";
            $description2 = "Our honeymoon trip";
            $id2 = null;
            $user_id2 = 2;
            $review_id2 = 3;
            $new_trip2 = new Trip($name2, $user_id2, $review_id2, $description2, $id2);
            $new_trip2->save();

            //Act
            $result = Trip::getAll();

            //Assert
            $this->assertEquals([$new_trip, $new_trip2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = null;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);
            $new_trip->save();

            $name2 = "Honeymoon";
            $description2 = "Our honeymoon trip";
            $id2 = null;
            $user_id2 = 2;
            $review_id2 = 3;
            $new_trip2 = new Trip($name2, $user_id2, $review_id2, $description2, $id2);
            $new_trip2->save();

            //Act
            Trip::deleteAll();
            $result = Trip::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_update()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = 1;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);
            $new_trip->save();

            //Act
            $new_name = "DivorceMoon";
            $new_description = "DivorceMoon";
            $new_trip->update($new_name, $new_description);
            $result = $new_trip->getName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_update_description()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = 1;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);
            $new_trip->save();

            //Act
            $new_name = "DivorceMoon";
            $new_description = "DivorceMoon";
            $new_trip->update($new_name, $new_description);
            $result = $new_trip->getDescription();

            //Assert
            $this->assertEquals($new_description, $result);
        }

        function test_delete()
        {
            //Arrange
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = null;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);
            $new_trip->save();

            $name2 = "Honeymoon";
            $description2 = "Our honeymoon trip";
            $id2 = null;
            $user_id2 = 2;
            $review_id2 = 3;
            $new_trip2 = new Trip($name2, $user_id2, $review_id2, $description2, $id2);
            $new_trip2->save();

            //Act
            $new_trip->delete();
            $result = Trip::getAll();

            //Assert
            $this->assertEquals([$new_trip2], $result);
        }

        function test_getCities()
        {
            $name = "Honeymoon";
            $description = "Our honeymoon trip";
            $id = null;
            $user_id = 2;
            $review_id = 3;
            $new_trip = new Trip($name, $user_id, $review_id, $description, $id);
            $new_trip->save();

            $city_name = "Los Angeles";
            $state = "California";
            $new_city = new City($city_name, $state, $id);
            $new_city->save();

            $city_name2 = "New York City";
            $state2 = "New York";
            $new_city2 = new City($city_name2, $state2, $id);
            $new_city2->save();

            $new_trip->addCity($new_city);
            $new_trip->addCity($new_city2);

            $result = $new_trip->getCities();

            $this->assertEquals([$new_city, $new_city2], $result);
        }

    }
?>
