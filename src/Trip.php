<?php
    class Trip
    {
        private $name;
        private $description;
        private $id;
        private $user_id;
        private $review_id;

        function __construct($name, $description, $id = null, $user_id, $review_id)
        {
            $this->name = $name;
            $this->id = $id;
            $this->description = $description;
            $this->user_id = $user_id;
            $this->review_id = $review_id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function setDescription($new_description)
        {
            $this->description = $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getId()
        {
            return $this->id;
        }

        function getUserId()
        {
            return $this->user_id;
        }

        function getReviewId()
        {
            return $this->review_id;
        }

        function update($new_name, $new_description)
        {
            $GLOBALS['DB']->exec("UPDATE SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("UPDATE SET description = '{$new_description}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
            $this->setDescription($new_description);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM trips WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM cities_trips WHERE id = {$this->getId()};");

        }
        
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO trips (name, description, user_id, review_id) VALUES ('{$this->getName()}', '{$this->getDescription()}', {$this->getUserId()}, {$this->getReviewId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_trips = $GLOBALS['DB']->query("SELECT * FROM trips;");
            $trips = array();
            foreach($returned_trips as $trip) {
                $name = $trip['name'];
                $description = $trip['description'];
                $id = $trip['id'];
                $user_id = $trip['user_id'];
                $review_id = $trip['review_id'];
                $new_trip = new Trip($name, $description, $id, $user_id, $review_id);
                array_push($trips, $new_trip);
            }
            return $trips;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM trips;");
        }

    }

?>
