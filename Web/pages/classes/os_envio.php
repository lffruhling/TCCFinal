<?php


// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'AIzaSyAjckR92JtbxglBU7D_zcUAkN0wJ8nrxAc' );
 

$registrationIds = array("e9h4DoKcW4I:APA91bHqF0fdWlKAwiEhdJVBfvKNvza7DqeEZ-as6BaUhPs5QsHHwf9WrLpfZ61Q0bF4IWp2-aUGkDnfF_Y7HSOUKTAQ5rTVjpfB2xv3eGcAxZY-T-x58g8vY0MKHjOoSfHx991ARQQ9" );

// prep the bundle
$msg = array
(
    'message'       => 'Existe uma Nova Os cadastrada para voc�',
    'title'         => 'Nova Os',
    'subtitle'      => 'Nova os Cadastrada',
    'tickerText'    => 'Ticker text here...Ticker text here...Ticker text here',
    'vibrate'   => 1,
    'sound'     => 1
);

$fields = array
(
    'registration_ids'  => $registrationIds,
    'data'              => $msg
);

$headers = array
(
    'Authorization: key=' . API_ACCESS_KEY,
    'Content-Type: application/json'
);

$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
$result = curl_exec($ch );
curl_close( $ch );

echo $result;
?>