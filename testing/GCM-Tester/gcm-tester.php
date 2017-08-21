<?php
		 
		if ($pushMessage) {		
	  
			$gcmRegIds = array("APA91bE2ONGRPx3XZ29rhHtg2ILszi8tg7D0-RhETfXHSzSXptGOBEhb6CNmdhTQSXzrbX2OqiqOPiWx2jN0brNbAyjZTZy8dAuxtfxbC2UvJs7MmEQF5pS2CpHoVows7TEoSXnH_V1P");
			
			$pushMessage['service'] = "hello";	
			$pushMessage['booking_id'] = "gm";	
			$message = array("msg" => $pushMessage); 
			$pushStatus =   sendMessageThroughGCM($gcmRegIds, $message);
		}		
		
		
		
	function sendMessageThroughGCM($gcmRegIds, $message) { 
		//Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $gcmRegIds,
            'data' => $message
        );
		// echo '<pre>';print_r($fields); 
		// Update your Google Cloud Messaging API Key
		//asif hello
		// define("GOOGLE_API_KEY", "AIzaSyCGxfkv_z6Miz1q-dJr1foyCUNNTwwOdM0");  
		define("GOOGLE_API_KEY", "AIzaSyCdKmh8V0icBG2x2kE2ymk_Afp6fuvDTp8");   // Server Key
	


        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);				
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
		print_r($result); 
        curl_close($ch);
        return $result ;
    }
?>
 
