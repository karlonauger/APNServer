<?php
require_once 'include/class/User.php';
require_once 'include/class/Event.php';
require_once 'include/class/Lookup.php';

$deviceID = $_POST['device_id'];
$deviceToken = $_POST['device_token'];

$lookup = new Lookup();
$user = $lookup->getUserByDeviceID($deviceID);

if(is_null($user))
{
	$user = new User();
	$user->setDeviceID($deviceID);
	echo "\n\tNew User Added!".PHP_EOL;
}
$user->setDeviceToken($deviceToken);
$user->setBadgeCount(0);
$user->commit();

echo "\tUserID: ".$user->getID().PHP_EOL;
echo "\tDeviceID: ".$user->getDeviceID().PHP_EOL;
echo "\tDeviceToken: ".$user->getDeviceToken().PHP_EOL;
?>