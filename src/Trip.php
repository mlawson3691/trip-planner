<?php
    class Trip
    {
        private $name;
        private $user_id;
        private $complete;
        private $description;
        private $id;

        function __construct($name, $user_id, $complete = 0, $description="", $id = null)
        {
            $this->name = $name;
            $this->user_id = $user_id;
            $this->complete = $complete;
            $this->description = $description;
            $this->id = $id;
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

        function getComplete()
        {
            return $this->complete;
        }

        function addCity($city_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO cities_trips (city_id, trip_id) VALUES ({$city_id}, {$this->getId()});");
        }

        function removeCity($city_id)
        {
            $GLOBALS['DB']->exec("DELETE FROM cities_trips WHERE city_id = {$city_id} AND trip_id = {$this->getId()}");
        }

        function completeTrip()
        {
            $GLOBALS['DB']->exec("UPDATE trips SET complete = 1 WHERE id = {$this->getId()};");
            $this->complete = 1;
        }

        function getCities()
        {
            $returned_cities = $GLOBALS['DB']->query ("SELECT cities.* FROM trips
                JOIN cities_trips ON (cities_trips.trip_id = trips.id)
                JOIN cities ON (cities.id = cities_trips.city_id)
                WHERE trips.id = {$this->getId()};");
            $cities = array();
            foreach($returned_cities as $city) {
                $name = $city['name'];
                $state = $city['state'];
                $id = $city['id'];
                $new_city = new City($name, $state, $id);
                array_push($cities, $new_city);
            }
            return $cities;
        }

        function getActivities()
        {
            $returned_activities = $GLOBALS['DB']->query("SELECT * FROM activities
                WHERE trip_id = {$this->getId()} ORDER BY date ASC;");
            $activities = array();
            foreach($returned_activities as $activity) {
                $name = $activity['name'];
                $date = $activity['date'];
                $trip_id = $activity['trip_id'];
                $description = $activity['description'];
                $id = $activity['id'];
                $new_activity = new Activity($name, $date, $trip_id, $description, $id);
                array_push($activities, $new_activity);
            }
            return $activities;
        }

        function getReview()
        {
            $returned_reviews = Review::getAll();
            $review = null;
            foreach($returned_reviews as $returned_review) {
                if ($returned_review->getTripId() == $this->getId()) {
                    $review = $returned_review;
                    break;
                }
            }
            return $review;
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
            $GLOBALS['DB']->exec("DELETE FROM cities_trips WHERE trip_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM activities WHERE trip_id = {$this->getId()}");
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO trips (name, description, user_id, complete) VALUES ('{$this->getName()}', '{$this->getDescription()}', {$this->getUserId()}, {$this->getComplete()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_trips = $GLOBALS['DB']->query("SELECT * FROM trips;");
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

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM trips;");
        }

        static function findById($search_id)
        {
            $returned_trips = Trip::getAll();
            $trip = null;
            foreach($returned_trips as $returned_trip) {
                if ($returned_trip->getId() == $search_id) {
                    $trip = $returned_trip;
                    break;
                }
            }
            return $trip;
        }

    }

?>
