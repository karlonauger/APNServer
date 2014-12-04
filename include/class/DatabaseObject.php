<?php
require_once 'Database.php';

/**
* Parent database class
*/
abstract class DatabaseObject
{
	private $objectID; //Value of the primary key

	public function __construct($objectID)
	{
		$this->objectID = $objectID;
	}

	/**
	 * The table name in the database
	 */  
  abstract protected function tableName();

	/**
	 * The primary key of the table
	 */  
  abstract protected function objectIDName();

  /**
   * Fetch the data for this object
   */
  abstract public function fetchData();

  /**
   * Update the database with the changes from this object
   */
  abstract public function commit();
  
  	/**
	 * returns the object ID
	 */
	public function getID()
  	{
        return $this->objectID;
    }

	/**
	 * Cleanse the data (prevent injection ect.)
	 */
	public function sterilize(&$data)
	{
		// Use the built-in escape_string on the database
		$data = Database::getDB()->escape_string($data);
	}

	/**
	*  Fix numeric data
	*/
	public static function fixNum(&$input, $min = null, $max = null, $round = 1)
    {
    	$round = 1/$round;
        if (is_NaN($input)) 
        {
            $input = 0;
        }
        $input = round($input * $round) / $round;
        if (isset($min) && $input < $min)
        {
        	$input = $min;
        }
        if (isset($max) && $input > $max)
        {
        	$input = $max;
        }
    }

	/**
	 * Get a formatted date
	 */
	public static function getDate()
	{
		date_default_timezone_set('America/New_York');
		return date("Y-m-d H:i:s");
	}

	/**
	 * Fetch the row data from the table
	 *
	 * @return The row
	 */
	protected function fetchObjectData()
	{
		if(isset($this->objectID))
		{
			$result = Database::getDB()->query("SELECT * FROM `{$this->tableName()}` WHERE `{$this->objectIDName()}` = '{$this->objectID}'") or die(Database::getDB()->error);
			if ($row = $result->fetch_assoc())
			{
			    $result->close();
				return $row;
			}
		}
		else
		{
			trigger_error("Call to fetchObjectData() with no objectID set.", E_USER_WARNING);
		}
		return null;
	}

	/**
	 * Update a table with the object data
	 *
	 * @param $data An array of columnName => value.
	 */
	protected function update($data)
	{
		$query = "UPDATE `{$this->tableName()}` SET ";
		$isFirstItem = true;
		foreach($data as $column => $value)
		{
			if(isset($value))
			{
				if($isFirstItem)
				{
					$isFirstItem = false;
				}
				else
				{
					$query .= ", ";
				}
				$this->sterilize($value);
				$query .= "`$column` = '$value'";
			}
		}
		if(!$isFirstItem)
		{
			$query .= "WHERE `{$this->objectIDName()}` = '{$this->objectID}'";
			Database::getDB()->query($query) or die(Database::getDB()->error);
		}
		else
		{
			trigger_error("Could not update database. All member variables are null.", E_USER_WARNING);
		}
	}

	/**
	 * Insert a new row in the table using the object data
	 *
	 * @param $data An array of columnName => value.
	 * @return The id of the newly inserted row
	 */
	protected function insert($data, $copy = false)
	{
		$query = "INSERT INTO `{$this->tableName()}` SET ";
		$isFirstItem = true;
		foreach($data as $column => $value)
		{
			if(isset($value))
			{
				if($isFirstItem)
				{
					$isFirstItem = false;
				}
				else
				{
					$query .= ", ";
				}
				$this->sterilize($value);
				$query .= "`$column` = '$value'";
			}
		}
		if(!$isFirstItem)
		{
			Database::getDB()->query($query) or $this->fail();
			//return the newly inserted row's id
			if ($copy == false)
			{//only overwright if not making a copy
				$this->objectID = Database::getDB()->insert_id;
			}
			else
			{
				return Database::getDB()->insert_id;
			}
		}
		else
		{
			trigger_error("Could not insert into database. All member variables are null.", E_USER_WARNING);
		}
		return $this->objectID;
	}

	/**
	 * Copy a row and make updates
	 *
	 * @param array $what_to_update Array of keys and values to update in the process.
	 * @param array $what_to_ignore Array of column names you wish to not include in
	 *                              the copy query. Useful for auto_increment columns.
	 * @return new row id or false
	 */
	public function copyRow($what_to_update = array(), $what_to_ignore = array())
	{
		$row = $this->fetchObjectData();
	    // Make sure the row exists.
	    if (! empty($row[$this->objectIDName()])) 
	    {
	        // Build data array with coppied data and updates 
	        // Skip ignored fields
	        $data = null;
	        foreach ($row as $name => $value) 
	        {
	            if (! in_array($name, $what_to_ignore)) 
	            {
	                if (array_key_exists($name,$what_to_update)) 
	                {
	                    if (! empty($what_to_update[$name])) 
	                    {
	                        $data[$name] = $what_to_update[$name];
	                    }
	                } 
	                else 
	                {
	                    $data[$name] = $value;
	                }
	            }
	        }
	        return $this->insert($data, true);
	    } 
	    else 
	    {
	        return false;
	    }
	}

	/**
	 * Delete the object from the table
	 *
	 * @return 
	 */
	public function delete()
	{
		if(isset($this->objectID))
		{
			$delete = Database::getDB()->query("DELETE FROM `{$this->tableName()}` WHERE `{$this->objectIDName()}` = '{$this->objectID}'") or die(Database::getDB()->error);
			//echo("deleted: ".$this->objectID.":".mysql_affected_rows());
		}
		else
		{
			trigger_error("Call to delete() with no objectID set.", E_USER_WARNING);
		}
		return null;
	}

	private function fail()
	{
	    $errorStr = Database::getDB()->error;

	    echo '<p>MySQL error: <code>' . $errorStr . '</code></p>';
	    echo '<pre>';
	    debug_print_backtrace();
	    echo '</pre>';

	    exit();
	}

	/**
	 * Get an object's array of children
	 *
	 * @param $childName The name of the table and Class of the child object
	 * @param $childIDName The name of the id column for the child
	 * @return the object array
	 */
	protected function getObjectArray($childTableName, $childIDName, $foreignKeyIDName = null, $childClassName = null, $orderBy = null)
	{
		if (!isset($foreignKeyIDName))
		{	//If the foreignKeyIDName is not set, just assume it's the same as the objectIDName
			$foreignKeyIDName = $this->objectIDName;
		}
		if (!isset($childClassName))
		{	//If the childClassName is not set, just assume it's the same as the childTableName
			$childClassName = $childTableName;
		}
		$result = Database::getDB()->query("SELECT * FROM `$childTableName` WHERE `$foreignKeyIDName` = '{$this->objectID}'" . ((!empty($orderBy)) ? " ORDER BY {$orderBy}" : "")) or die(Database::getDB()->error);
		$objectArray = array();
		while($row = $result->fetch_assoc())
		{
			$objectArray[] = new $childClassName($row[$childIDName]);
		}
		$result->close();
		return $objectArray;
	}
}
?>