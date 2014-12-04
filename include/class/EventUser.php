<?php
require_once 'DatabaseObject.php';

class EventUser extends DatabaseObject
{
    //Members
    private $eventID = null;
    private $userID = null;
    private $isModerator = 0;

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
      return "Event_User";
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
            $this->userID = $row["userID"];
            $this->eventID = $row["eventID"];
            $this->isModerator = $row["isModerator"];
        }
    }

    /**
     * Update the database with the changes from this object
     */
    public function commit()
    {
        $data = array(
            "userID" => $this->userID,
            "eventID" => $this->eventID,
            "isModerator" => $this->isModerator
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
    public function getUserID(){
        return $this->userID;
    }

    public function setUserID($userID){
        $this->userID = $userID;
    }

    public function getEventID(){
        return $this->eventID;
    }

    public function setEventID($eventID){
        $this->eventID = $eventID;
    }

    public function getIsModerator(){
        if($this->isModerator == 1)
        {
            return true;
        }
        return false;
    }

    public function setIsModerator($isModerator){
        $this->isModerator = 0;
        if($isModerator)
        {
            $this->isModerator = 1;
        }
    }
}
?>