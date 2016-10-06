<?php
class Review
{
    private $title;
    private $description;
    private $rating;
    private $trip_id;
    private $id;

    function __construct($title, $description, $rating, $trip_id, $id = null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->rating = $rating;
        $this->trip_id = $trip_id;
        $this->id = $id;
    }

// Standard Functions
    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO reviews (title, description, rating, trip_id) VALUES ('{$this->title}', '{$this->description}', {$this->rating}, {$this->trip_id});");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_title, $new_description, $new_rating)
    {
        $GLOBALS['DB']->exec("UPDATE reviews SET title = '{$new_title}', description = '{$new_description}', rating = {$new_rating} WHERE id = {$this->getId()};");
        $this->setTitle($new_title);
        $this->setDescription($new_description);
        $this->setRating($new_rating);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM reviews WHERE id = {$this->getId()};");
    }

    function getUsername()
    {
        $trip = Trip::findById($this->getTripId());
        $user = User::findById($trip->getUserId());
        return $user->getUserName();
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
            $title = $review['title'];
            $description = $review['description'];
            $rating = $review['rating'];
            $trip_id = $review['trip_id'];
            $id = $review['id'];
            $new_review = new Review($title, $description, $rating, $trip_id, $id);
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

    function setTitle($new_title)
    {
        $this->title = $new_title;
    }

    function getTitle()
    {
        return $this->title;
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
