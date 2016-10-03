<?php
class Activity
{
    private $name;
    private $date;
    private $description;
    private $trip_id;
    private $id;

    function __construct($name, $date, $description, $trip_id, $id = null)
    {
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
        $this->trip_id = $trip_id;
        $this->id = $id;
    }
// Setters and getters
    function getName()
    {
        return $this->name;
    }

    function setName($new_name)
    {
        $this->name = $new_name;
    }

    function getDate()
    {
        return $this->date;
    }

    function setDate($new_date)
    {
        $this->date = $new_date;
    }

    function getDescription()
    {
        return $this->description;
    }

    function setDescription($new_description)
    {
        $this->description = $new_description;
    }

    function getTripId()
    {
        return $this->trip_id;
    }

    function getId()
    {
        return $this->id;
    }
}
?>
