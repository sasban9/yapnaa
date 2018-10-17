<?php

require_once("model/model.php");
$obj_model	= new model; 

class helper{
	
	function __construct(){
		global $obj_model;
		global $tb;
		$this->model	= & $obj_model;
	}
	
	
	// if($_GET['transaction_related']){	
		// echo "suman"; die;
		//$followuptype	= $_REQUEST['followuptype'];
		//$list 			= $control->followup_cron($followuptype); 
	// }
	
	
	
	function send_transaction_sms($phone){
		$number 		= array($phone);
		print_r($number); die;
		$message 		= 'Hello';
		//$this->send_bulk_sms($number,$message);
	}
	
	
	function send_bulk_sms($user_numbers,$message){ 
		date_default_timezone_set('Asia/Kolkata');
		$today 			= date("Y-m-d H:i:s");
		if($user_numbers){
			for($i=0;$i<count($user_numbers);$i++){
				if($user_numbers[$i]){
					$ch = curl_init();
				    $url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_numbers[$i])."&message=".urlencode("".$message."");
					
					curl_setopt( $ch,CURLOPT_URL, $url );
					curl_setopt( $ch,CURLOPT_POST, false ); 
					curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
					$result = curl_exec($ch );
					curl_close( $ch );
				}
			}	
		}		
		else{
			return 0;
		}
	}
	
	
	
	
}


?>