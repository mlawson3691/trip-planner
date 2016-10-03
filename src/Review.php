<?php
class Review
{
    private $description;
    private $rating;
    private $trip_id;
    private $id;

    function __construct($description, $rating, $trip_id, $id = null)
    {
        $this->description = $description;
        $this->rating = $rating;
        $this->trip_id = $trip_id;
        $this->id = $id;
    }

// Standard Functions
    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO reviews (description, rating, trip_id) VALUES ('{$this->description}', {$this->rating}, {$this->trip_id});");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_description, $new_rating)
    {
        $GLOBALS['DB']->exec("UPDATE reviews SET description = '{$new_description}', rating = {$new_rating} WHERE id = {$this->getId()};");
        $this->setDescription($new_description);
        $this->setRating($new_rating);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM reviews WHERE id = {$this->getId()};");
    }

// Static Functions
    static function findById($search_id)
    {
        $returned_reviews = Review::getAll();
        $review = null;
        foreach($returned_reviews as $returned_review) {
            if ($returned_review->getId() == $search_id) {
                $review = $returned_review;
                break;
            }
        }
        return $review;
    }

    static function getAll()
    {
        $returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews;");
        $reviews = array();
        foreach($returned_reviews as $review) {
            $description = $review['description'];
            $rating = $review['rating'];
            $trip_id = $review['trip_id'];
            $id = $review['id'];
            $new_review = new Review($description, $rating, $trip_id, $id);
            array_push($reviews, $new_review);
        }
        return $reviews;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM reviews;");
    }

// Setters and getters
    function getId()
    {
        return $this->id;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($new_description)
    {
        $this->description = $new_description;
    }

    function getRating()
    {
        return $this->rating;
    }

    function setRating($new_rating)
    {
        $this->rating = $new_rating;
    }

    function getTripId()
    {
        return $this->trip_id;
    }

    function setTripId($new_trip_id)
    {
        $this->trip_id = $new_trip_id;
    }
}
?>
