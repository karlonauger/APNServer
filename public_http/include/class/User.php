<?php
require_once 'DatabaseObject.php';
require_once 'EventUser.php';

class User extends DatabaseObject
{
    //Members
    private $deviceID = null;
    private $deviceToken = null;
    private $name = "";
    private $email = "";
    private $badgeCount = 0;
    private $isAdmin = 0;//false

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
      return "User";
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
            $this->deviceID = $row["deviceID"];
            $this->deviceToken = $row["deviceToken"];
            $this->name = $row["name"];
            $this->email = $row["email"];
            $this->badgeCount = $row["badgeCount"];
            $this->isAdmin = $row["isAdmin"];
        }
    }

    /**
     * Update the database with the changes from this object
     */
    public function commit()
    {
        $data = array(
            "deviceID" => $this->deviceID,
            "deviceToken" => $this->deviceToken,
            "name" => $this->name,
            "email" => $this->email,
            "badgeCount" => $this->badgeCount,
            "isAdmin" => $this->isAdmin
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
    public function getDeviceID(){
        return $this->deviceID;
    }

    public function setDeviceID($deviceID){
        $this->deviceID = $deviceID;
    }

    public function getDeviceToken(){
        return $this->deviceToken;
    }

    public function setDeviceToken($deviceToken){
        $this->deviceToken = $deviceToken;
    }

    public function getName(){
        return $this->name;
    }

    public function setName($name){
        $this->name = $name;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }

    public function getBadgeCount(){
        return $this->badgeCount;
    }

    public function setBadgeCount($badgeCount){
        $badgeCount = min($badgeCount, 10); // keep badges below 10
        $this->badgeCount = $badgeCount;
    }

    public function getIsAdmin(){
        if($this->isAdmin == 1)
        {
            return true;
        }
        return false;
    }

    public function setIsAdmin($isAdmin){
        $this->isAdmin = 0;
        if($isAdmin)
        {
            $this->isAdmin = 1;
        }
    }
}
?>