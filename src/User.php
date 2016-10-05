<?php
    class User
    {
        private $username;
        private $password;
        private $name;
        private $bio;
        private $location;
        private $id;

        function __construct($username, $password, $name, $bio, $location, $id = null)
        {
            $this->username = $username;
            $this->password = $password;
            $this->name = $name;
            $this->bio = $bio;
            $this->location = $location;
            $this->id = $id;
        }

        function setUsername($new_username)
        {
            $this->username = $new_username;
        }

        function getUsername()
        {
            return $this->username;
        }

        function setPassword($new_password)
        {
            $this->password = $new_password;
        }

        function getPassword()
        {
            return $this->password;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setBio($new_bio)
        {
            $this->bio = $new_bio;
        }

        function getBio()
        {
            return $this->bio;
        }

        function setLocation($new_location)
        {
            $this->location = $new_location;
        }

        function getLocation()
        {
            return $this->location;
        }

        function getId()
        {
            return $this->id;
        }

        function getTrips()
        {
            $returned_trips = $GLOBALS['DB']->query ("SELECT * FROM trips WHERE user_id = {$this->getId()} ORDER BY id DESC;");
            $trips = array();
            foreach($returned_trips as $trip) {
                $name = $trip['name'];
                $user_id = $trip['user_id'];
                $complete = $trip['complete'];
                $description = $trip['description'];
                $id = $trip['id'];
                $new_trip = new Trip($name, $user_id, $complete, $description, $id);
                array_push($trips, $new_trip);
            }
            return $trips;
        }

        function getPendingTrips()
        {
            $all_trips = $this->getTrips();
            $trips = array();
            foreach($all_trips as $trip) {
                if($trip->getComplete() == 0) {
                    array_push($trips, $trip);
                }
            }
            return $trips;
        }

        function getPastTrips()
        {
            $all_trips = $this->getTrips();
            $trips = array();
            foreach($all_trips as $trip) {
                if($trip->getComplete() == 1) {
                    array_push($trips, $trip);
                }
            }
            return $trips;
        }

        function update($new_name, $new_location, $new_bio)
        {
            $GLOBALS['DB']->exec("UPDATE SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("UPDATE SET location = '{$new_location}' WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("UPDATE SET bio = '{$new_bio}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
            $this->setLocation($new_location);
            $this->setBio($new_bio);
        }

        // function updatePassword ($old_password, $new_password)
        // {
        //     if(password_verify($old_password, $this->getPassword())) {
        //         $GLOBALS['DB']->exec("UPDATE SET password = '{$new_password}' WHERE id = {$this->getId()};");
        //         $this->setPassword(password_hash($new_password, PASSWORD_DEFAULT));
        //     }
        // }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM users WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM trips WHERE user_id = {$this->getId()};");

        }

        function save()
        {
            $all_users = User::getAll();
            $unique = true;
            foreach($all_users as $user) {
                if (strtolower($user->getUsername()) == strtolower($this->getUsername())) {
                    $unique = false;
                    return false;
                }
            }
            if ($unique == true) {
                $GLOBALS['DB']->exec("INSERT INTO users (username, password, name, bio, location) VALUES ('{$this->getUsername()}', '{$this->getPassword()}', '{$this->getName()}', '{$this->getBio()}', '{$this->getLocation()}');");
                $this->id = $GLOBALS['DB']->lastInsertId();
                return true;
            }
        }

        static function verifyLogin($username, $password)
        {
            $all_users = User::getAll();
            $found_user = null;
            foreach($all_users as $user) {
                if ($user->getUsername() === $username && password_verify($password, $user->getPassword())) {
                    $found_user = $user;
                    break;
                }
            }
            if ($found_user !== null) {
                $_SESSION['current_user'] = $found_user;
                return $found_user;
            } else {
                return false;
            }
        }

        static function getAll()
        {
            $returned_users = $GLOBALS['DB']->query("SELECT * FROM users;");
            $users = array();
            foreach($returned_users as $user) {
                $username = $user['username'];
                $password = $user['password'];
                $name = $user['name'];
                $bio= $user['bio'];
                $location= $user['location'];
                $id = $user['id'];
                $new_user = new User($username, $password, $name, $bio, $location, $id);
                array_push($users, $new_user);
            }
            return $users;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM users;");
        }

        static function findById($search_id)
        {
            $returned_users = User::getAll();
            $user = null;
            foreach($returned_users as $returned_user) {
                if ($returned_user->getId() == $search_id) {
                    $user = $returned_user;
                    break;
                }
            }
            return $user;
        }
    }

?>
