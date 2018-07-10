<?php
// Install the library via PEAR or download the .zip file to your project folder.
// This line loads the library
require('./Twilio.php');

$account_sid = 'AC3c5afa521270a0efa87d28a6c2d4bd37'; 
$auth_token = '21dced8ba83a13e5fcd206aa7bad5776'; 
$client = new Services_Twilio($account_sid, $auth_token); 
$to_number = "+".urldecode($_GET['number']);
$rand = $_GET['otp'];
$text = "Your Properset verfication code is :".$rand;
 
$message = $client->account->messages->create(array( 
	'To' => $to_number, 
	'From' => "+19562474169", 
	'Body' => $text,   
));

print_r($message->account_sid);
?>