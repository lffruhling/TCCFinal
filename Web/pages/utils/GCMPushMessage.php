<?php
/*
	Class to send push notifications using Google Cloud Messaging for Android
	Example usage
	-----------------------
	$an = new GCMPushMessage($apiKey);
	$an->setDevices($devices);
	$response = $an->send($message);
	-----------------------
	
	$apiKey Your GCM api key
	$devices An array or string of registered device tokens
	$message The mesasge you want to push out
	@author Matt Grundy
	Adapted from the code available at:
	http://stackoverflow.com/questions/11242743/gcm-with-php-google-cloud-messaging
*/
class GCMPushMessage {
	var $url = 'https://android.googleapis.com/gcm/send';
	var $serverApiKey = "AIzaSyAjckR92JtbxglBU7D_zcUAkN0wJ8nrxAc";
	var $devices = array("e9h4DoKcW4I:APA91bHqF0fdWlKAwiEhdJVBfvKNvza7DqeEZ-as6BaUhPs5QsHHwf9WrLpfZ61Q0bF4IWp2-aUGkDnfF_Y7HSOUKTAQ5rTVjpfB2xv3eGcAxZY-T-x58g8vY0MKHjOoSfHx991ARQQ9");
	
	/*
		Constructor
		@param $apiKeyIn the server API key
	*/
	function GCMPushMessage($apiKeyIn){
		$this->serverApiKey = $apiKeyIn;
	}
	/*
		Set the devices to send to
		@param $deviceIds array of device tokens to send to
	*/
	function setDevices($deviceIds){
	
		if(is_array($deviceIds)){
			$this->devices = $deviceIds;
		} else {
			$this->devices = array($deviceIds);
		}
	
	}
	/*
		Send the message to the device
		@param $message The message to send
		@param $data Array of data to accompany the message
	*/
	function send($message, $data = false){
		
		if(!is_array($this->devices) || count($this->devices) == 0){
			$this->error("No devices set");
		}
		
		if(strlen($this->serverApiKey) < 8){
			$this->error("Server API Key not set");
		}
		
		$fields = array(
			'registration_ids'  => $this->devices,
			'data'              => array( "message" => $message ),
		);
		
		if(is_array($data)){
			foreach ($data as $key => $value) {
				$fields['data'][$key] = $value;
			}
		}
		$headers = array( 
			'Authorization: key=' . $this->serverApiKey,
			'Content-Type: application/json'
		);
		// Open connection
		$ch = curl_init();
		
		// Set the url, number of POST vars, POST data
		curl_setopt( $ch, CURLOPT_URL, $this->url );
		
		curl_setopt( $ch, CURLOPT_POST, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		
		curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $fields ) );
		
		// Avoids problem with https certificate
		curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
		
		// Execute post
		$result = curl_exec($ch);
		
		// Close connection
		curl_close($ch);
		
		return $result;
	}
	
	function error($msg){
		echo "Android send notification failed with error:";
		echo "\t" . $msg;
		exit(1);
	}
}