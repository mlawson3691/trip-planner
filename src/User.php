<?php
    class User
    {
        private $username;
        private $password;
        private $id;

        function __construct($username, $password, $id = null)
        {
            $this->username = $username;
            $this->password = $password;
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

        function getId()
        {
            return $this->id;
        }

        function getTrips()
        {
            $returned_trips = $GLOBALS['DB']->query ("SELECT * FROM trips WHERE user_id = {$this->getId()};");
            $trips = array();
            foreach($returned_trips as $trip) {
                $name = $trip['name'];
                $description = $trip['description'];
                $id = $trip['id'];
                $user_id = $trip['user_id'];
                $new_trip = new Trip($name, $user_id, $description, $id);
                array_push($trips, $new_trip);
            }
            return $trips;
        }

        function update($new_username, $new_password)
        {
            $GLOBALS['DB']->exec("UPDATE SET username = '{$new_username}' WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("UPDATE SET password = '{$new_password}' WHERE id = {$this->getId()};");
            $this->setUsername($new_username);
            $this->setPassword($new_password);
        }

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
                $GLOBALS['DB']->exec("INSERT INTO users (username, password) VALUES ('{$this->getUsername()}', '{$this->getPassword()}');");
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
                $id = $user['id'];
                $new_user = new User($username, $password, $id);
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
