<?php
include "../gcm/GCMPushMessage.php";

function send_push($key,$device,$message,$author,$title){

	$an = new GCMPushMessage($key);
	$devices = $device;

	$ar = array();
	$ar['message'] = $message;
	$ar['author'] = $author;
	$ar['title'] = $title;
	$an->setDevices($devices);
	$message = "";
	$response = $an->send($message,$ar);

	return $response;

//	$an = new GCMPushMessage("AIzaSyAL_U7vjf5hXDHVESU04tJtEldBRaVaEIY");
//	$devices = "APA91bE65g_vCaZ2lLxW2JzIXyoKqXzdrsBcUqwUBdpK02GHxQVic-uTATHu6kthptXP1OpRkVf1lbxHAyIrbdxNGuK0NnrSB7GQDSpBNzvfo8CT7ZoPQsSJe-C_YIFUDHAyotr7_A2v";

//	$ar = array();
//	$ar['message'] = "Um novo chamado na sua região!";
//	$ar['author'] = "Bradesco";
//	$ar['title'] = "DMP Brasil";
//	$an->setDevices($devices);
//	$message = "";
//	$response = $an->send($message,$ar);
	//echo "\n$response\n";
	//print_r($message);
}
?>
