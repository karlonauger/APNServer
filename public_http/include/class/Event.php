<?php
require_once 'DatabaseObject.php';
require_once 'EventUser.php';

class Event extends DatabaseObject
{
    //Members
    private $name = "";
    private $time = null;
    private $location = "";
    private $description = "";

    public function __construct($objectID = null)
    {
        parent::__construct($objectID);

        if(isset($objectID))
        {
            //Get a specific object
            $this->fetchData();
        }
        else
        {
            //Create a new object. Set the create Timestamp.
            //$this->createTS = parent::getDate();
        }
    }
    
    /**
     * The table name in the database
     */  
    protected function tableName()
    {
      return "Event";
    }

    /**
     * The primary key of the table
     */  
    protected function objectIDName()
    {
      return "ID";
    }

    /**
     * Fetch the data for this object
     */
    public function fetchData()
    {
        $row = parent::fetchObjectData();
        if (isset($row))
        {
            $this->name = $row["name"];
            $this->time = $row["time"];
            $this->location = $row["location"];
            $this->description = $row["description"];
        }
    }

    /**
     * Update the database with the changes from this object
     */
    public function commit()
    {
        $data = array(
            "name" => $this->name,
            "time" => $this->time,
            "location" => $this->location,
            "description" => $this->description
        );

        $objectID = $this->getID();
        if(isset($objectID))
        {
            //This object has already been inserted to the database. Just update.
            $this->update($data);
        }
        else
        {
            //This object has not been inserted to the database. Insert it.
            parent::insert($data);
        }
    }

    //Member getters and setters
    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getTime(){
        return $this->time;
    }

    public function setTime($time){
        $this->time = $time;
    }

    public function getLocation(){
        return $this->location;
    }

    public function setLocation($location){
        $this->location = $location;
    }

    public function getDescription(){
        return $this->description;
    }

    public function setDescription($description){
        $this->description = $description;
    }
}
?>