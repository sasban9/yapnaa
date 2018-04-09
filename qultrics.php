<?php
if(isset($_REQUEST['getResponseFile'])){
//define path to save file
$file_location	=	"";
$survey_id		=	$_REQUEST["survey_id"];
////Create a file at qualtrics

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://aptozen.co1.qualtrics.com/API/v3/responseexports",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => '{"format":"csv","surveyId":"'.$survey_id.'"}',
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache",
    "content-type: application/json",
    "postman-token: 7ac9111e-8d4e-5b04-3457-f2a36de2c291",
    "x-api-token: ZFlMRTLrJNchu9REhTuQTVknv76unqP3AD3Vq15c"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} 
else {
	 
	$response = (array)json_decode($response);
	$result = (array)$response["result"];
	
	$file_export_id = $result["id"];
	////File created, the result ID to be sent in the below API to obtain the file in zip format

	///Code to download and store the zip file in a location

	$curl = curl_init();

	$fp = fopen($file_location."qualtrics.zip", "w");

	curl_setopt_array($curl, array(
		  CURLOPT_URL => "https://aptozen.co1.qualtrics.com/API/v3/responseexports/".$file_export_id."/file",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_FILE => $fp,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "GET",
		  CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"x-api-token: ZFlMRTLrJNchu9REhTuQTVknv76unqP3AD3Vq15c"
		  ),
		));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
		echo "cURL Error #:" . $err;
		} 
		else {
		  echo "File downloaded successfully";
		}
	}
}
?>
<!DOCTYPE HTML>
<html>
<body>
	<form action="" method="POST">
		<div>	
			<label>Enter Survey ID  Eg:SV_3ZYfVCUd6a8RRlj</label>
		</div>
		<div>	
			<input type="text" name="survey_id">
		</div>
		<input type="submit" name="getResponseFile" value="Submit">
	</form>