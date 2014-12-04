<?php
/**
* Database Class
*/
class Database
{
	private static $db;

	/**
	 * Get the mysqli database object. Initialize if needed.
	 */	
	public static function getDB()
	{
		if(!isset(self::$db))
		{
			require_once '/usr/local/uvm-inc/kgauger.inc';
			define("HOST", "webdb.uvm.edu"); // The host you want to connect to.
			define("USER", $DB_INFO['writer']['username']); // The database username.
			define("PASSWORD", $DB_INFO['writer']['password']); // The database password. 
			define("DATABASE", "KGAUGER_BARRETOWNFOREST"); // The database name.

			self::$db = new mysqli(HOST, USER, PASSWORD, DATABASE);
		}
		return self::$db;
	}
}
?>