<?php
// API access key from Google API's Console
define( 'API_ACCESS_KEY', 'AIzaSyCdKmh8V0icBG2x2kE2ymk_Afp6fuvDTp8' );
$registrationIds = array( "APA91bE2ONGRPx3XZ29rhHtg2ILszi8tg7D0-RhETfXHSzSXptGOBEhb6CNmdhTQSXzrbX2OqiqOPiWx2jN0brNbAyjZTZy8dAuxtfxbC2UvJs7MmEQF5pS2CpHoVows7TEoSXnH_V1P" );
// prep the bundle
$msg = array
(
	'service' 	=> 'here is a message. message', 
);
$fields = array
(
	'registration_ids' 	=> $registrationIds,
	'data'			=> $msg
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