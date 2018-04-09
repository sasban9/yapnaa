<?php 
$page_access_token="EAAVLijsBhncBAKzPunqrAwuQ3e4q8DDoJFAsQ2V9Y0B91Ku644WS1AhqrSdTd6sVgGINvZA9T4NtIOvPZCDbhd4WZAKZAaEwBlrLuXPqBpYS5qMIBZBtZCMZAxKr0kYFcc5POracI06V7IuZB9ZAkzUgnHns9qtmU9AtiEscXMvlwtWbZC2Don5Mbw6ZA6P01r7AWkZD";
$permissions="publish_actions,manage_pages,publish_pages,ADMINISTER,EDIT_PROFILE,CREATE_CONTENT,MODERATE_CONTENT,CREATE_ADS,BASIC_ADMIN";
$data['message'] = "my message";


$data['access_token'] = $page_access_token;
$data['scope'] = $permissions; //page token from 2nd step
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, 'https://graph.facebook.com/164147900869563/feed');
curl_setopt($ch, CURLOPT_VERBOSE, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_POST, 1);


$resp = curl_exec($ch);

curl_close($ch);
$data_resp = json_decode($resp);

print_r($data_resp);
?>