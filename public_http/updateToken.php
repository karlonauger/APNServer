<?php
require_once 'include/class/User.php';
require_once 'include/class/Event.php';
require_once 'include/class/Lookup.php';

$deviceID = $_POST['device_id'];
$updateArray = $_POST;
unset($updateArray['device_id']); // Do not update the Device ID

// Find User by Device ID
$lookup = new Lookup();
$user = $lookup->getUserByDeviceID($deviceID);

if(isset($user))
{
	echo "Found User! ";
}
else
{
	$user = new User();
	$user->setDeviceID($deviceID);
	echo "New User Created! ";
}
echo "Device ID: ".$user->getDeviceID().PHP_EOL;

// set all other parameters
foreach ($updateArray as $parm => $value) 
{
	// Remove bad characters
	$removeChars = array(" ", "_", "-", "<", ">", ".");
	$parm = str_replace($removeChars, "", $parm);
	$setMethod = "set".$parm;
	$getMethod = "get".$parm;
	
	if(!method_exists($user, $setMethod))
	{
		echo "Warning! '".$parm."' is not a valid parameter".PHP_EOL;
	}
	else
	{
		// Set Update
		$user->$setMethod($value);
		echo "Saved: '".$parm."'";
		// Verify Update
		if(method_exists($user, $setMethod))
		{
			echo " => '".$user->$getMethod()."'";
		}
		echo PHP_EOL;
	}
}
$user->getBadgeCount(0);
// commit updates
$user->commit();

echo "Complete. UserID: ".$user->getID().PHP_EOL;
?>