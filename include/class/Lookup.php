<?php
require_once("Database.php");
require_once("User.php");
require_once("Event.php");

class Lookup
{
    /**
     * Get a single object by a property
     * @param $tableName The name of the table
     * @param $primaryIDName The colomn name of the primary id
     * @param $propertyName The colomn name of the property
     * @param $propertyValue The value of the property to find
     * @param $className The name of the class to create the object from
     * @return an object with that property
     */
    private static function getObjectByProperty($tableName, $primaryIDName, $propertyName, $propertyValue, $className = null)
    {
        if (!isset($className))
        {	//If the className is not set, just assume it's the same as the tableName
            $className = $tableName;
        }

        $propertyValue = Database::getDB()->escape_string($propertyValue);
        $result = Database::getDB()->query("SELECT `$primaryIDName`, `$propertyName` FROM `$tableName` WHERE `$propertyName` = '$propertyValue'") or die(Database::getDB()->error);
        if($row = $result->fetch_assoc())
        {
            return new $className($row[$primaryIDName]);
        }
        else
        {
            error_log("Could not find $tableName with $propertyName $propertyValue.");
        }
        return null;
    }

    /**
     * Get all the objects from a table
     * @param $tableName The name of the table
     * @param $primaryIDName The colomn name of the primary id
     * @param $className The name of the class to create the object from
     * @param $sortBy The column and direction to sort by
     * @return An array of all objects
     */
    private static function getAllObjectsFromTable($tableName, $primaryIDName, $className = null, $sortBy = null)
    {
        if (!isset($className))
        {	//If the className is not set, just assume it's the same as the tableName
            $className = $tableName;
        }

        $sql = "SELECT `{$primaryIDName}` FROM `{$tableName}`";
        if ($sortBy != null)
        {
            $sql .= " ORDER BY {$sortBy}";
        }

        $result = Database::getDB()->query($sql) or die(Database::getDB()->error);
        $objectArray = array();
        while($row = $result->fetch_assoc())
        {
            $objectArray[] = new $className($row["$primaryIDName"]);
        }
        return $objectArray;
    }

    /**
     * Get a User by deviceID
     * @param $deviceID The deviceID to use
     * @return A user with that deviceID
     */
    public static function getUserByDeviceID($deviceID)
    {
        return self::getObjectByProperty("User", "ID", "deviceID", $deviceID);
    }

    /**
     * Get a User by name
     * @param $name The user name to use
     * @return A user with that name
     */
    public static function getUserByName($name)
    {
        return self::getObjectByProperty("User", "ID", "name", $name);
    }

    /**
     * Get a User by email
     * @param $email The email to use
     * @return A user with that email
     */
    public static function getUserByEmail($email)
    {
        return self::getObjectByProperty("User", "ID", "email", $email);
    }

    /**
     * Get all the users
     * @return An array of all users
     */
    public static function getAllUsers()
    {
        return self::getAllObjectsFromTable("User", "ID", "User", "deviceID");
    }
}
?>