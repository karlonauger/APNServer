<?php
require_once 'include/cred/kgauger.inc';
require_once 'include/func/response.php';
require_once 'include/class/User.php';
require_once 'include/class/Event.php';
require_once 'include/class/Lookup.php';

// Vars
$message = $_POST['message']; // Get message
$errorString = "";
// Get array if all users
$lookup = new Lookup();
$userArray = $lookup->getAllUsers();

/* Origin Authentication */
/*
	if($_SERVER['HTTP_ORIGIN'] != "http://www.uvm.edu")
	{
		$errorString .= "Posts only aloud from 'http://www.uvm.edu'";
	}
	else
	{
		//code to execute...
	}
*/

if(is_null($userArray))
{
	$errorString .= "Sorry, there are NO USERS to send the notification to :(";
}
else
{
	$SSLContext = stream_context_create();
	stream_context_set_option($SSLContext, 'ssl', 'local_cert', 'include/cred/BarreTownForestCK.pem');
	stream_context_set_option($SSLContext, 'ssl', 'passphrase', $SSL_INFO['passphrase']);
	// Open a connection to the APNS server
	$connection = stream_socket_client(
		'ssl://gateway.sandbox.push.apple.com:2195', $error, // connect to the sandbox server
		$errorStr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $SSLContext);

	if (!$connection) 
	{
		$errorString .= "Failed to connect: ".$error." ".$errorStr.PHP_EOL;
	}
	else
	{
		//echo 'Connected to APNS'.PHP_EOL;
		//echo 'Sending Message: "'.$message.'"'.PHP_EOL;
		foreach ($userArray as $key => $user) 
		{
			// Get and increment badgeCount by 1
			$user->setBadgeCount($user->getBadgeCount() + 1);
			$user->commit();
			$badgeCount = $user->getBadgeCount();

			// Create the payload body
			$body['aps'] = array(
				'badge' => $badgeCount,
				'alert' => $message,
				'sound' => 'default'
			);
			$payload = json_encode($body); // Encode the payload as JSON

			$deviceToken = $user->getDeviceToken();
			$notification = chr(0).pack('n', 32).pack('H*', $deviceToken).pack('n', strlen($payload)).$payload; // Build the binary notification
			// Send it to the server
			$result = fwrite($connection, $notification, strlen($notification)); 
			if (!$result)
			{
				$errorString .= 'Message not delivered'.PHP_EOL;
			}
			else
			{
				$returnArray[$user->getID()] = array(
					'return' => 'Message successfully delivered',
					'Device ID' => $user->getDeviceID(),
					'Device Token' => $user->getDeviceToken()
				);
			}
		}
		// Close the connection to the server
		fclose($connection);
	}
}

$returnArray['errors'] = $errorString;
//return results array as a JSON
$returnJson = json_encode($returnArray);
echo $returnJson;
?>