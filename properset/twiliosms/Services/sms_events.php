<?php
// Install the library via PEAR or download the .zip file to your project folder.
// This line loads the library
require('./Twilio.php');

$account_sid = 'AC480dccb774418b704ca7b7b7c0e6c29a'; 
$auth_token = 'd0b891d8debed995fbb03438561b5dd5'; 
$client = new Services_Twilio($account_sid, $auth_token); 
$to_number = "+".urldecode($_GET['number']);
$rand = urldecode($_GET['rand']);
 
$message = $client->account->messages->create(array( 
	'To' => $to_number, 
	'From' => "+16603334054", 
	'Body' => $rand,   
));

print_r($message->account_sid);
?>