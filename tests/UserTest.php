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
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = 1;
            $new_user = new User($username, $password, $id);

            //Act
            $result = $new_user->getUsername();

            //Assert
            $this->assertEquals($username, $result);
        }

        function test_getPassword()
        {
            //Arrange
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = 1;
            $new_user = new User($username, $password, $id);

            //Act
            $result = $new_user->getPassword();

            //Assert
            $this->assertEquals($password, $result);
        }

        function test_getId()
        {
            //Arrange
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = 1;
            $new_user = new User($username, $password, $id);

            //Act
            $result = $new_user->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_setUsername()
        {
            //Arrange
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = 1;
            $new_user = new User($username, $password, $id);

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
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = 1;
            $new_user = new User($username, $password, $id);

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
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();

            //Act
            $result = User::getAll();

            //Assert
            $this->assertEquals([$new_user], $result);
        }

        function test_saveDuplicates()
        {
            //Arrange
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = null;
            $new_user = new User($username, $password, $id);
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
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();

            $username2 = "fhhsdfkweh";
            $password2 = "vndsjkahfkl";
            $id2 = null;
            $new_user2 = new User($username2, $password2, $id2);
            $new_user2->save();

            //Act
            $result = User::getAll();

            //Assert
            $this->assertEquals([$new_user, $new_user2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();

            $username2 = "fhhsdfkweh";
            $password2 = "vndsjkahfkl";
            $id2 = null;
            $new_user2 = new User($username2, $password2, $id2);
            $new_user2->save();

            //Act
            User::deleteAll();
            $result = User::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_update_username()
        {
            //Arrange
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();

            //Act
            $new_username = "sfsdfdsfd";
            $new_password = "sfsdefdsxcfd";
            $new_user->update($new_username, $new_password);
            $result = $new_user->getUsername();

            //Assert
            $this->assertEquals($new_username, $result);
        }

        function test_update_password()
        {
            //Arrange
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();

            //Act
            $new_username = "sfsdfdsfd";
            $new_password = "sfsdefdsxcfd";
            $new_user->update($new_username, $new_password);
            $result = $new_user->getPassword();

            //Assert
            $this->assertEquals($new_password, $result);
        }

        function test_delete()
        {
            //Arrange
            $username = "Honeymoon";
            $password = "Otgg354";
            $id = null;
            $new_user = new User($username, $password, $id);
            $new_user->save();

            $username2 = "fhhsdfkweh";
            $password2 = "vndsjkahfkl";
            $id2 = null;
            $new_user2 = new User($username2, $password2, $id2);
            $new_user2->save();

            //Act
            $new_user->delete();
            $result = User::getAll();

            //Assert
            $this->assertEquals([$new_user2], $result);
        }

        function test_getTrips()
        {
            $username = "Honeymoon";
            $password = "Otgg354";
            $new_user = new User($username, $password);
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

            $this->assertEquals([$new_trip, $new_trip2], $result);
        }

    }
?>
