<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
    require_once "src/User.php";
    require_once "src/Trip.php";
    require_once "src/City.php";

    $server = 'mysql:host=localhost;dbname=trip_planner_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class UserTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            User::deleteAll();
            Trip::deleteAll();
            City::deleteAll();
        }

        function test_getUsername()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);

            //Act
            $result = $new_user->getUsername();

            //Assert
            $this->assertEquals($username, $result);
        }

        function test_getPassword()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);

            //Act
            $result = $new_user->getPassword();

            //Assert
            $this->assertEquals($password, $result);
        }

        function test_getId()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);

            //Act
            $result = $new_user->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_setUsername()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);

            //Act
            $new_username = "AK";
            $new_user->setUsername($new_username);
            $result = $new_user->getUsername();

            //Assert
            $this->assertEquals($new_username, $result);
        }

        function test_setPassword()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);

            //Act
            $new_password = "Khuy343";
            $new_user->setPassword($new_password);
            $result = $new_user->getPassword();

            //Assert
            $this->assertEquals($new_password, $result);
        }

        function test_save()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);
            $new_user->save();

            //Act
            $result = User::getAll();

            //Assert
            $this->assertEquals([$new_user], $result);
        }

        function test_saveDuplicates()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);
            $new_user->save();
            $new_user->save();

            //Act
            $result = User::getAll();

            //Assert
            $this->assertEquals([$new_user], $result);
        }

        function test_getAll()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);
            $new_user->save();

            $username2 = "dgretre";
            $password2 = "afderrrr33";
            $name2 = "Otgdfd";
            $bio2 = "Lorem ipdctetur adipisicing elit.";
            $location2 = "Pidfsrgh";
            $id2 = 2;
            $new_user2 = new User($username2, $password2, $name2, $bio2,  $location2, $id2);
            $new_user2->save();

            //Act
            $result = User::getAll();

            //Assert
            $this->assertEquals([$new_user, $new_user2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);
            $new_user->save();

            $username2 = "OttisG7778";
            $password2 = "afdewr3233";
            $name2 = "Ottis Grand";
            $bio2 = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location2 = "Pittsburgh";
            $id2 = 2;
            $new_user2 = new User($username2, $password2, $name2, $bio2,  $location2, $id2);
            $new_user2->save();

            //Act
            User::deleteAll();
            $result = User::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_update_name()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);
            $new_user->save();

            //Act
            $new_name = "sfsdfdsfd";
            $new_user->update($new_name, $bio, $location);
            $result = $new_user->getName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        // function test_update_password()
        // {
        //     //Arrange
        //     $username = "OttisG7778";
        //     $password = "afdewr3233";
        //     $name = "Ottis Grand";
        //     $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
        //     $location = "Pittsburgh";
        //     $id = 1;
        //     $new_user = new User($username, $password, $name, $bio,  $location, $id);
        //     $new_user->save();
        //
        //     //Act
        //     $new_password = "sfsdefdsxcfd";
        //     $new_user->updatePassword($password, $new_password);
        //     $result = $new_user->getPassword();
        //
        //     //Assert
        //     $this->assertEquals($new_password, $result);
        // }

        function test_delete()
        {
            //Arrange
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);
            $new_user->save();

            $username2 = ";lkajsd;flkajsdf";
            $password2 = "afdewr3233";
            $name2 = "Ottis Grand";
            $bio2 = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location2 = "Pittsburgh";
            $id2 = 2;
            $new_user2 = new User($username2, $password2, $name2, $bio2,  $location2, $id2);
            $new_user2->save();

            //Act
            $new_user->delete();
            $result = User::getAll();

            //Assert
            $this->assertEquals([$new_user2], $result);
        }

        function test_getTrips()
        {
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);
            $new_user->save();

            $name = "Honeymoon";
            $user_id = $new_user->getId();
            $complete = 0;
            $description = "Our honeymoon trip";
            $new_trip = new Trip($name, $user_id, $complete, $description);
            $new_trip->save();

            $name2 = "Honeymoon";
            $user_id2 = $new_user->getId();
            $complete = 0;
            $description2 = "Our beautiful trip";
            $new_trip2 = new Trip($name2, $user_id2, $complete, $description2);
            $new_trip2->save();


            $result = $new_user->getTrips();

            $this->assertEquals([$new_trip2, $new_trip], $result);
        }

        function test_getPendingTrips()
        {
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);
            $new_user->save();

            $name = "Honeymoon";
            $user_id = $new_user->getId();
            $complete = 0;
            $description = "Our honeymoon trip";
            $new_trip = new Trip($name, $user_id, $complete, $description);
            $new_trip->save();

            $name2 = "Honeymoon";
            $user_id2 = $new_user->getId();
            $complete2 = 0;
            $description2 = "Our beautiful trip";
            $new_trip2 = new Trip($name2, $user_id2, $complete2, $description2);
            $new_trip2->save();

            $name3 = "Honeymoon";
            $user_id3 = $new_user->getId();
            $complete3 = 1;
            $description3 = "Our beautiful trip";
            $new_trip3 = new Trip($name3, $user_id3, $complete3, $description3);
            $new_trip3->save();

            $all_trips = $new_user->getTrips();
            $result = $new_user->getPendingTrips($all_trips);

            $this->assertEquals([$new_trip2, $new_trip], $result);
        }

        function test_getPastTrips()
        {
            $username = "OttisG7778";
            $password = "afdewr3233";
            $name = "Ottis Grand";
            $bio = "Lorem ipsum dolor sit amet, consectetur adipisicing elit.";
            $location = "Pittsburgh";
            $id = 1;
            $new_user = new User($username, $password, $name, $bio,  $location, $id);
            $new_user->save();

            $name = "Honeymoon";
            $user_id = $new_user->getId();
            $complete = 1;
            $description = "Our honeymoon trip";
            $new_trip = new Trip($name, $user_id, $complete, $description);
            $new_trip->save();

            $name2 = "Honeymoon";
            $user_id2 = $new_user->getId();
            $complete2 = 0;
            $description2 = "Our beautiful trip";
            $new_trip2 = new Trip($name2, $user_id2, $complete2, $description2);
            $new_trip2->save();

            $name3 = "Honeymoon";
            $user_id3 = $new_user->getId();
            $complete3 = 1;
            $description3 = "Our beautiful trip";
            $new_trip3 = new Trip($name3, $user_id3, $complete3, $description3);
            $new_trip3->save();

            $all_trips = $new_user->getTrips();
            $result = $new_user->getPastTrips($all_trips);

            $this->assertEquals([$new_trip3, $new_trip], $result);
        }


    }
?>
