<?php

include "../classes/mysql.php";
include "../utils/utils.php";

$db = new MySQL();

//Getting api key
$api_key = $_POST['apikey'];

//Getting registration token we have to make it as array
//$reg_token = array($_POST['regtoken']);

//Getting the message
$message = $_POST['message'];
$id_tec = $_POST['id_tec'];

if($db->conecta()){

    $resultado = $db->retorna_token($id_tec);

    $reg_token = array($resultado);
}

$db->desconecta();


$msg = array
(
    'message' => $message,
    'title' => 'Meu Gerente',
    'subtitle' => 'Android Push Notification using GCM Demo',
    'tickerText' => 'Ticker text here...Ticker text here...Ticker text here',
    'vibrate' => 1,
    'sound' => 1,
    'largeIcon' => 'large_icon',
    'smallIcon' => 'small_icon'
);

//Creating a new array fileds and adding the msg array and registration token array here
$fields = array
(
    'registration_ids' => $reg_token,
    'data' => $msg
);

//Adding the api key in one more array header
$headers = array
(
    'Authorization: key=' . $api_key,
    'Content-Type: application/json'
);

//Using curl to perform http request
$ch = curl_init();
curl_setopt( $ch,CURLOPT_URL, 'https://android.googleapis.com/gcm/send' );
curl_setopt( $ch,CURLOPT_POST, true );
curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );

//Getting the result
$result = curl_exec($ch );
curl_close( $ch );

?>