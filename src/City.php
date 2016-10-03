<?php
Class City
{
    private $name;
    private $state;
    private $id;

    function __construct($name, $state, $id = null)
    {
        $this->name = $name;
        $this->state = $state;
        $this->id = $id;
    }
// standard Functions
    function getAllReviews()
    {
        $returned_reviews = $GLOBALS['DB']->query("SELECT reviews.* FROM cities
        JOIN cities_trips ON (cities_trips.city_id = cities.id)
        JOIN trips ON (trips.id = cities_trips.trip_id)
        JOIN reviews ON (reviews.id = trips.review_id)
        WHERE cities.id = {$this->getId()};");

        $reviews = array();
        foreach ($returned_reviews as $review) {
            $description = $review['description'];
            $rating = $review['rating'];
            $trip_id = $review['trip_id'];
            $id = $review['id'];
            $new_review = new Review($description, $rating, $trip_id, $id);
            array_push($reviews, $new_review);
        }
        return $reviews;
    }

    function update($new_name, $new_state)
    {
        $GLOBALS['DB']->exec("UPDATE cities SET name = '{$new_name}', state = '{$new_state}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
        $this->setState($new_state);
    }

    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO cities (name, state) VALUES ('{$this->name}', '{$this->state}');");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

// static functions
    static function getAll()
    {
        $returned_cities = $GLOBALS['DB']->query("SELECT * FROM cities;");
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

    static function findById($search_id)
    {
        $returned_cities = City::getAll();
        $city = null;
        foreach($returned_cities as $returned_city) {
            if ($returned_city->getId() == $search_id) {
                $city = $returned_city;
                break;
            }
        }
        return $city;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM cities");
    }

// getters and Setters
    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = $new_name;
    }

    function getState()
    {
        return $this->state;
    }

    function setState($new_state)
    {
        $this->state = $new_state;
    }

}
?>
