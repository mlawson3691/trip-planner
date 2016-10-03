<?php
class Activity
{
    private $name;
    private $date;
    private $description;
    private $trip_id;
    private $id;

    function __construct($name, $date, $trip_id, $description = "", $id = null)
    {
        $this->name = $name;
        $this->date = $date;
        $this->description = $description;
        $this->trip_id = $trip_id;
        $this->id = $id;
    }
// Standard Functions
    function save()
    {
        $GLOBALS['DB']->exec("INSERT INTO activities (name, date, description, trip_id) VALUES ('{$this->name}', '{$this->date}', '{$this->description}', {$this->trip_id});");
        $this->id = $GLOBALS['DB']->lastInsertId();
    }

    function update($new_name, $new_date, $new_description)
    {
        $GLOBALS['DB']->exec("UPDATE activities SET name = '{$new_name}', date = '{$new_date}', description = '{$new_description}' WHERE id = {$this->getId()};");
        $this->setName($new_name);
        $this->setDate($new_date);
        $this->setDescription($new_description);
    }

    function delete()
    {
        $GLOBALS['DB']->exec("DELETE FROM activities WHERE id = {$this->getId()};");
    }


// Static Functions
    static function findById($search_id)
    {
        $returned_activities = Activity::getAll();
        $activity = null;
        foreach($returned_activities as $returned_activity) {
            if ($returned_activity->getId() == $search_id) {
                $activity = $returned_activity;
                break;
            }
        }
        return $activity;
    }

    static function getAll()
    {
        $returned_activities = $GLOBALS['DB']->query("SELECT * FROM activities;");
        $activities = array();
        foreach($returned_activities as $activity)
        {
            $name = $activity['name'];
            $date = $activity['date'];
            $description = $activity['description'];
            $trip_id = $activity['trip_id'];
            $id = $activity['id'];
            $new_activity = new Activity($name, $date, $trip_id, $description, $id);
            array_push($activities, $new_activity);
        }
        return $activities;
    }

    static function deleteAll()
    {
        $GLOBALS['DB']->exec("DELETE FROM activities;");
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
