<?php

if(isset($_POST['value']))
{
	require_once('../model/model.php');
	$obj_model	=new model;
	require_once('../config/tab_config.php');
}else{
	require_once('model/model.php');
	$obj_model	=new model;
	require_once('config/tab_config.php');
}



class users
{
    function __construct()
    {
        global $obj_model;
        global $tb;
        $this->model =& $obj_model;
    }
    
    
    
	// user registartion
    function user_resgitartion()
    {
		$keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		// print_r($keys[0]);
		// print_r($keys[1]);
        $table 					= table();
		date_default_timezone_set('Asia/Kolkata');
        $user_name 					=	$_POST['user_name'];
        $user_address 				= 	$_POST['user_address'];
        $user_phone 				= 	$_POST['user_phone'];
        $user_email_id 				= 	$_POST['user_email_id'];
        $user_city           		= 	$_POST['user_city'];
        // $user_pin		    		= 	($_POST["user_pin"]);
        $user_pin		    		= 	md5($_POST["user_pin"]);
        $user_area_pincode			= 	$_POST["user_area_pincode"];
        $user_gcm_id      			= 	$_POST['user_gcm_id'];
        $user_login_device_type		= 	$_POST['user_login_device_type'];
        $app_key	      			= 	$_POST['app_key'];
        $app_secret      			= 	$_POST['app_secret'];
        $user_created_date 			= 	date('Y-m-d h:i:s');
        $user_last_login 			= 	date('Y-m-d h:i:s');
        $user_reg_verification_otp	= rand(1000,9999);
        $user_token					= rand(1000,9999999);
		
		if(($keys[0]==$app_key) && ($keys[1]==$app_secret)){
			$res	=	1;
		}else{
			$res	=	0;
		}
		
		
		
		
        if ($res==1) {
            $table           = table();
            $table_user      = $table['tb1'];
            $fields_user     = '*';
            // $condition_user  = 'user_phone    = ' . "'" . $user_phone . "'" . ' OR user_email_id = ' . "'" . $user_email_id . "'";
            $condition_user  = 'user_phone    = ' . "'" . $user_phone . "'";
            $arr_result_test = $this->model->get_Details_condition($table_user, $fields_user, $condition_user);
            // print_r($arr_result_test);exit;
           
        }else{
			$arr_result_test=1;
		}
          // print_r($arr_result_test);exit;
        if (empty($arr_result_test)) {
          
            $fields_reg = array(
                'user_name' 				=> $user_name,
                'user_address' 				=> $user_address,
                'user_phone' 				=> $user_phone,
                'user_email_id' 			=> $user_email_id,
                'user_city' 				=> $user_city,
                'user_pin' 					=> $user_pin,
                'user_area_pincode' 		=> $user_area_pincode,
                'user_token' 				=> $user_token,
                'user_gcm_id' 				=> $user_gcm_id,
                'user_login_device'			=> $user_login_device_type,
                'user_reg_verification_otp'	=> $user_reg_verification_otp,
                'user_created_date' 		=> $user_created_date,
                'user_last_login' 			=> $user_last_login
            );
            
            // print_r($fields_reg);exit;
			
            $table_log_in = $table['tb1'];
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
			
			// E-Mail To User
			// $to 			= 	$user_email_id;
			// $subject		=	"Registration done succesfully.";
			// $message		=	'<html>
									// <body>
										// <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
											// <p>Hi,<strong>' . $user_full_name . '</strong></p>
											// <p> Thank you for registring with us.</p>
											// <p>OTP: <strong>' . $user_reg_verification_otp . '</strong></p>
										// </table>
									// </body>
								// </html>';
	
			
            // $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
					
            // $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
            // $headers1 		.= 	"From:admin@gmail.com\r\n";
            
            // if (mail($to, $subject, $message, $headers1)) {
				// return $user_reg_verification_otp;
            // }			return $fields_reg;
			
			
			
			
			$ch = curl_init();
			$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_phone)."&message=".urlencode("".$user_reg_verification_otp ." - Use this OTP for mobile number verification.\n.");
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch ); 
			
			return $user_reg_verification_otp;
			
            
        }
    }
    
	
/*-----------------------------------------------------------------------------------------------------------------------*/
	
	
	
	// User Regsistration OTP verification
	function user_reg_otp_verification()
    {
        $keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		$table           				 = 	table();
        $reg_otp			           	 = 	$_POST['reg_otp'];
        $app_key	      				 = 	$_POST['reg_app_key'];
        $app_secret      				 = 	$_POST['reg_app_secret'];
        $table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'user_reg_verification_otp    = '.$reg_otp;
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		 // print_r($arr_log_in);exit;
		
		if(($keys[0]==$app_key) && ($keys[1]==$app_secret)){
			 $res	=	1;
		}else{
			 $res	=	0;
		}
		
		
		
		if($res==1){
			date_default_timezone_set('Asia/Kolkata');
			$user_last_login 			= 	date('Y-m-d h:i:s');
            $set_array     = array(
                'user_last_login' 			=> $user_last_login,
                'user_reg_verification_otp' => 0,
                'user_status' 				=> 1
            );
            $condition     = 'user_reg_verification_otp = ' . "'" . $reg_otp . "'";
            $arr_log_in1    = $this->model->update($table_log_in, $set_array, $condition);
			return $arr_log_in;
			
		}
		else{
			return $arr_log_in="";
		}
		
    }
	
	
	
	
/*-----------------------------------------------------------------------------------------------------------------------*/
	
	
	
	
	// User Regsistration OTP resend
	function user_reg_resend_otp_phone_no()
    {
        $keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		$table           				 = 	table();
        $resend_otp_phone_no           	 = 	$_POST['resend_otp_phone_no'];
        $app_key	      				 = 	$_POST['resend_otp_app_key'];
        $app_secret      				 = 	$_POST['resend_otp_app_secret'];
        $table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'user_phone    = '.$resend_otp_phone_no;
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		 // print_r($arr_log_in);exit;
		 
		$user_name	=	$arr_log_in[0]['user_name'];
		$user_email	=	$arr_log_in[0]['user_email_id'];
		
		if(($keys[0]==$app_key) && ($keys[1]==$app_secret)){
			 $res	=	1;
		}else{
			 $res	=	0;
		}
		
		
		
		if($res==1){
			$user_reg_verification_otp	= rand(1000,9999);
            $set_array     = array(
                'user_reg_verification_otp' => $user_reg_verification_otp
            );
            $condition     = 'user_phone = ' . "'" . $resend_otp_phone_no . "'";
            $arr_log_in1    = $this->model->update($table_log_in, $set_array, $condition);
			
			
			
			// $to 			= 	$user_email;
			// $subject		=	"Registration done succesfully.";
			// $message		=	'<html>
									// <body>
										// <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
											// <p>Hi,<strong>' . $user_name . '</strong></p> 
											// <p>OTP: <strong>' . $user_reg_verification_otp . '</strong></p>
										// </table>
									// </body>
								// </html>';
	
			
            // $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
					
            // $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
            // $headers1 		.= 	"From:admin@gmail.com\r\n";
            
            // if (mail($to, $subject, $message, $headers1)) {
				// return $user_reg_verification_otp;
            // }
			
			$ch = curl_init();
			// $url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1nimbus&password=demo123&sender=ARPITA&sendto=".urlencode($resend_otp_phone_no)."&message=".urlencode("Use OTP:".$user_reg_verification_otp ."for reset your password.\n.");
			$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($resend_otp_phone_no)."&message=".urlencode("".$user_reg_verification_otp ." - Use this OTP for mobile number verification.\n.");
				
				
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch ); 
			
			
			
			return $user_reg_verification_otp;
			
		}
		else{
			return $arr_log_in="";
		}
		
    }
	
	
	
	
/*-----------------------------------------------------------------------------------------------------------------------*/



	
	// User Login
	function user_login()
    {
        $keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		$table           				 = 	table();
        $user_phone			           	 = 	$_POST['user_login_mobile'];
        // $user_pin			        	 = 	($_POST['user_login_pin']);
        $user_pin			        	 = 	md5($_POST['user_login_pin']);
        $user_gcm			        	 =  $_POST['user_login_gcm'];
        $app_key	      				 = 	$_POST['login_app_key'];
        $app_secret      				 = 	$_POST['login_app_secret'];
        $user_login_device_type			 = 	$_POST['user_login_device_type'];
        $table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'user_pin    = ' . "'" . $user_pin . "'" . ' and user_phone = ' . "'" . $user_phone . "'" . ' and user_status = 1';
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		 // print_r($arr_log_in);exit;
		
		if(($keys[0]==$app_key) && ($keys[1]==$app_secret)){
			$res	=	1;
		}else{
			$res	=	0;
		}
		
		
		
		if($res==1){
			date_default_timezone_set('Asia/Kolkata');
			$user_last_login 			= 	date('Y-m-d h:i:s');
			$user_token					=   rand(1000,9999999);
			
            $set_array     = array(
                'user_gcm_id' 				=> $user_gcm,
				'user_token' 				=> $user_token,
                'user_last_login' 			=> $user_last_login,
                'user_login_device' 		=> $user_login_device_type, 
            );
            $condition     					=	'user_phone = ' . "'" . $user_phone . "'";
            $arr_log_in1   					 = 	$this->model->update($table_log_in, $set_array, $condition);
			$fields_log_in   				 = 	'*';
			$condition_log_in				 = 	'user_pin    = ' . "'" . $user_pin . "'" . ' and user_phone = ' . "'" . $user_phone . "'" . ' and user_status = 1';
			$arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			 // print_r($arr_log_in);exit;
			return $arr_log_in;
			
		}
		else{
			return $arr_log_in="";
		}
		
    }
	
	
/*-----------------------------------------------------------------------------------------------------------------------*/




	
	// User Forgot Password
    function forgot_password()
    {
        $keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		$table            			= 	table();
        $table_log_in     			= 	$table['tb1'];
        $forgot_password_phone      = 	$_POST['forgot_password_phone'];
        $app_key	      			= 	$_POST['forgot_app_key'];
        $app_secret      			= 	$_POST['forgot_app_secret'];
        $fields_log_in   			= 	'*';
        $condition_log_in 			= 	'user_phone = ' . "'" . $forgot_password_phone . "'";
        $arr_log_in       			= 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
        // print_r($arr_log_in);exit;
       
        if(($keys[0]==$app_key) && ($keys[1]==$app_secret)){
			 $res	=	1;
		}else{
			 $res	=	0;
		}
		
		
		
		if ($res==1 && $arr_log_in) {
		
			$user_email_id            	= $arr_log_in[0]['user_email_id'];
			$user_name		       		= $arr_log_in[0]['user_name'];
			$user_pin       			= $arr_log_in[0]['user_pin'];
			$f_otp						= rand(1000,9999);
			
			// E-Mail To User
			// $to 			= 	$user_email_id;
			// $subject		=	"Password of Movilo.";
			// $message		=	'<html>
									// <body>
										// <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
											// <p>Hi,<strong>' . $user_name . '</strong></p>
											// <p>here is your password on your request .</p>
											// <p>OTP: <strong>' . $f_otp . '</strong></p>
										// </table>
									// </body>
								// </html>';
	
			
            // $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
					
            // $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
            // $headers1 		.= 	"From:admin@gmail.com\r\n";
            
            // if (mail($to, $subject, $message, $headers1)) {
				 // $set_array     = array(
					// 'user_forgot_otp' => $f_otp
				// );
				// $condition     = 'user_email_id = ' . "'" . $user_email_id . "'";
				// $arr_log_in1    = $this->model->update($table_log_in, $set_array, $condition);
				// return $f_otp;
            // }
			// return $arr_log_in;
			
			
			
				$set_array     = array(
					'user_forgot_otp' => $f_otp
				);
				$condition     = 'user_email_id = ' . "'" . $user_email_id . "'";
				$arr_log_in1    = $this->model->update($table_log_in, $set_array, $condition);
				
				$ch = curl_init(); 
				$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($forgot_password_phone)."&message=".urlencode("".$f_otp ." - Use this OTP to reset your password.\n.");
				curl_setopt( $ch,CURLOPT_URL, $url );
				curl_setopt( $ch,CURLOPT_POST, false ); 
				curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
				$result = curl_exec($ch );
				curl_close( $ch ); 
				 
				 return $f_otp;
				 
				 
				 
				 
        }else{
			return $arr_log_in=='';
		}
        }
       
	   
/*-----------------------------------------------------------------------------------------------------------------------*/	


	
	// User Regsistration OTP verification
	function user_forgot_otp_verification()
    {
        $keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		$table           				 = 	table();
        $forgot_otp			           	 = 	$_POST['forgot_otp'];
        $app_key	      				 = 	$_POST['forgot_otp_app_key'];
        $app_secret      				 = 	$_POST['forgot_otp_app_secret'];
        $table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'user_forgot_otp    = '.$forgot_otp;
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		 // print_r($arr_log_in);exit;
		
		if(($keys[0]==$app_key) && ($keys[1]==$app_secret)){
			 $res	=	1;
		}else{
			 $res	=	0;
		}
		
		
		
		if($res==1){
            $set_array     = array(
                'user_forgot_otp' => 0,
            );
            $condition     = 'user_forgot_otp = ' . "'" . $forgot_otp . "'";
            $arr_log_in1    = $this->model->update($table_log_in, $set_array, $condition);
			return $arr_log_in;
			
		}
		else{
			return $arr_log_in="";
		}
		
    }
	
	
	
	
/*-----------------------------------------------------------------------------------------------------------------------*/



	// User Logout
	function user_logout()
    {
        $table           				 = 	table();
        $user_logout_token_key         	 = 	$_POST['user_logout_token_key'];
        $user_logout_id		           	 = 	$_POST['user_logout_id'];
		date_default_timezone_set('Asia/Kolkata');
		$user_last_logout 			= 	date('Y-m-d h:i:s');
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        // $condition_log_in				 = 	'user_token    = '.$user_logout_token_key .' and user_id='.$user_logout_id;
        $condition_log_in				 = 	'user_id='.$user_logout_id;
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);exit;
		if($arr_log_in){
			$user_gcm	   				 = '';	
			$user_token	   				 = '';	
			$set_array     = array(
				'user_gcm_id'		 		=> $user_gcm,
				'user_token'				=> $user_token,
				'user_last_logout'			=> $user_last_logout,
				'user_login_device'			=> '',
			);
			
			
			
			
			$condition     = 	'user_id    = ' . "'" . $user_logout_id . "'";
			$arr_log_in    = $this->model->update($table_log_in, $set_array, $condition);
			return $arr_log_in;
		}else{
			// echo "hello";
			return $arr_log_in='';
		}
    }
	
	
/*----------------------------------------------------------------------------------------------------------------------*/	
    
    /* User  update his password*/
    function user_change_pin()
    {
        $keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		$table      					 =  table();
        $table_log_in 					 =  $table['tb1'];
        $user_change_pass_phone  	     =  $_POST['user_change_pass_phone'];
        // $user_change_pin				 =  $_POST['user_change_pin'];
		$user_change_pin     		 =  md5($_POST['user_change_pin']);
        $app_key	      				 = 	$_POST['user_change_app_key'];
        $app_secret      				 = 	$_POST['user_change_app_secret'];
		
		
		$fields_log_in				=	'*';
		$condition_log_in 			= 	'user_phone    = ' . "'" . $user_change_pass_phone . "'";
        $arr_log_in       			= 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
        // print_r($arr_log_in);exit;
		
		if($arr_log_in){
			if(($keys[0]==$app_key) && ($keys[1]==$app_secret)){
				 $res	=	1;
			}else{
				 $res	=	0;
			}
			
			
			
			if($res==1){
				$set_array     = array(
					'user_pin' 			=>	$user_change_pin,
					'user_forgot_otp' 	=>	0
				);
				$condition     = 'user_phone = ' . "'" . $user_change_pass_phone . "'";
				$arr_log_in    = $this->model->update($table_log_in, $set_array, $condition);
				return $arr_log_in;
				
			}
			else{
				return $arr_log_in="";
			}
		}else{
			return $arr_log_in="";
		}
    }
    

/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
	
	
	//feching all main categories
	function barnd_list()
    {
        $table           				 = 	table();
        $brand_user_token_key          	 = 	$_POST['brand_user_token_key'];
		
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'user_token    = '.$brand_user_token_key;
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		
		if($arr_log_in){
			$table		    				 = 	$table['tb2'];
			$fields							 = '*';
			$condition		 				 = 	'brand_status    =1';
			$arr_log_in       				 = 	$this->model->get_Details_condition($table, $fields, $condition);
			// print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }
	

/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
		 
	 
	 
	 
	//feching all brand_product_list
	function brand_product_list()
    {
        $table           				 = 	table();
        $brand_product_user_token_key    = 	$_POST['brand_product_user_token_key'];
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'user_token    = '.$brand_product_user_token_key;
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		
		if($arr_log_in){
			$table		    				 = 	$table['tb3'];
			$fields							 =  '*';
			$condition		 				 = 	'product_status    =1';
			$arr_log_in       				 = 	$this->model->brand_product_list($table, $fields, $condition);
			// print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }
	
	
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
		 
	 
	 
	 
	//feching all brand_product_list
	function brand_product_list_by_category()
    {
        $table           				 = 	table();
        $brand_p_user_token_key		     = 	$_POST['brand_p_user_token_key'];
        $brand_p_category_id		     = 	$_POST['brand_p_category_id'];
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'user_token    = '.$brand_p_user_token_key;
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		
		if($arr_log_in){
			$table		    				 = 	$table['tb3'];
			$fields							 =  '*';
			$condition		 				 = 	'product_status    =1 and product_name='.$brand_p_category_id;
			$arr_log_in       				 = 	$this->model->brand_product_list_by_category($table, $fields, $condition);
			// print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }

	
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
		 
	 
	 
	 
	//feching particular brand_product_list
	function brand_p_list_by_brand_id()
    {
        $table           				 = 	table();
        $brand_p_list_t_key			     = 	$_POST['brand_p_list_t_key'];
        $brand_p_b_id				     = 	$_POST['brand_p_b_id'];
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'user_token    = '.$brand_p_list_t_key;
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in );exit;
		if($arr_log_in){
			$table		    				 = 	$table['tb3'];
			$fields							 =  '*';
			$condition		 				 = 	'product_status    =1 and product_brand_id='.$brand_p_b_id;
			$arr_log_in       				 = 	$this->model->brand_product_list_by_category($table, $fields, $condition);
			if($arr_log_in){ 
				return $arr_log_in;
			}else{
				return $arr_log_in=1;
			}
		}else{
			return $arr_log_in=2;
		}
    }

/*----------------------------------------------------------------------------------------------------------------------*/		
	
	

	
	
	//feching all main categories
	function category_list()
    {
        $table           				 = 	table();
        $category_user_token_key         = 	$_POST['category_user_token_key'];
		
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'user_token    = '.$category_user_token_key;
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);
		if($arr_log_in){
			$table_name	    				 = 	$table['tb5'];
			$fields_log_in   				 = 	'*';
			$condition_log_in				 = 	'p_category_status    = 1';
			$order_by						 = 	'p_category_priority';
			$arr_log_in      	 			 = 	$this->model->get_Details_condition_order_by($table_name, $fields_log_in, $condition_log_in,$order_by);
			// print_r($arr_log_in );
			if($arr_log_in){
				return $arr_log_in;
			}else{
				return $arr_log_in=1;
			}
		}else{
			return $arr_log_in=2;
		}
    }
	

/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
		 
		 
	 
	 
	//feching all Sub categories
	function sub_category()
    {
        $table           				 = 	table();
        $maincat_id			           	 = 	$_POST['maincat_id'];
        $table_log_in    				 = 	$table['tb3'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'sub_category_ref_main_id    = ' . "'" . $maincat_id . "'";
        $arr_log_in      	 			 = 	$this->model->get_sub_category_list($table_log_in, $fields_log_in, $condition_log_in);
        return $arr_log_in;
    }
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	 
	 
	 
	//Adding user product
	function user_add_product()
    {
        $table           				 = 	table();
		date_default_timezone_set('Asia/Kolkata');
        $add_product_user_token_key   	 = 	$_POST['add_product_user_token_key'];
        $add_product_user_serial_no   	 = 	$_POST['add_product_user_serial_no'];
        $add_product_user_brand_id   	 = 	$_POST['add_product_user_brand_id'];
        $add_product_user_id		   	 = 	$_POST['add_product_user_id'];
        $add_product_user_dealer_name  	 = 	$_POST['add_product_user_dealer_name'];
        $add_product_product_id		  	 = 	$_POST['add_product_product_id'];
        $add_product_installation	  	 = 	$_POST['add_product_installation'];
        $add_product_instal_date	  	 = 	$_POST['add_product_instal_date'];
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        // $condition_log_in				 = 	'user_token    = '.$add_product_user_token_key;
        $condition_log_in				 =  "user_token    =$add_product_user_token_key and user_id= $add_product_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		
		
		$device_type				     =	$arr_log_in[0]['user_login_device']; 
		$user_gcm_id				 	 =	$arr_log_in[0]['user_gcm_id']; 
		
		
		
		// print_r($arr_log_in);exit;
		if($arr_log_in){
			$table_log_in    				 = 	$table['tb4'];
			$fields_log_in   				 = 	'*';
			$condition_log_in				 = 	"up_serial_no    = '$add_product_user_serial_no'";
			$arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			// print_r($arr_log_in);exit;
			if($arr_log_in){
				// $arr_result[]		=	"This serial number already exist";
				return $arr_result=2;
			}else{
				$headers = array("Content-Type:multipart/form-data"); 
				$url='http://www.automobi.in/movilo/brand-api/mobi_index.php?page=user&serial_no='.$add_product_user_serial_no;
				$ch = curl_init();
			    curl_setopt($ch, CURLOPT_URL, $url);
			    curl_setopt($ch, CURLOPT_POST, true);
			    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			    curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
			    curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
			    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			    // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
			    $result = curl_exec($ch);	
				// $info = curl_getinfo($ch);
				// print_r($info);
			    if ($result === FALSE) {
				   die('Curl failed: ' . curl_error($ch));
				}
				curl_close($ch);
				// var_dump(curl_getinfo($ch,CURLINFO_HEADER_OUT));
				// print_r($result);
				
				
				
				
				if(!empty($_FILES['serial_no_img']['tmp_name']))
			{ 
				// echo "hi";exit;
				$filename = basename($_FILES['serial_no_img']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				$now = new DateTime();
				$times = $now->getTimestamp();
				$target = "./serial-no-images/"; 
				//Determine the path to which we want to save this file
				$newname = $target.$times.'-'.$filename;
				$newname1 = $times.'-'.$filename;
				// echo $newname;exit;
				//Check if the file with the same name is already exists on the server
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['serial_no_img']['tmp_name'],$newname))) {
							 $add_icon=$newname1;
						}else{
								$message	=	"Could not move the file!";
						}
					}
				
			}
			
				
				if($result!='0'){
						$new_arr = json_decode($result);
						foreach ($new_arr as $trend)  
						{         
							  $bp_serial_no					=	 $trend->bp_serial_no;    
							  $bp_id_invoice_copy			=	 $trend->bp_id_invoice_copy;    
							  $bp_id_invoice_no				=	 $trend->bp_id_invoice_no;    
							  $bp_id_manual					=	 $trend->bp_id_manual;    
							  $bp_id_guarantee_document		=	 $trend->bp_id_guarantee_document;    
							  $bp_id_warranty_document		=	 $trend->bp_id_warranty_document;    
							  $bp_id_user_email				=	 $trend->bp_id_user_email;    
							  $bp_id_user_address			=	 $trend->bp_id_user_address;    
							  $bp_id_purchase_date			=	 $trend->bp_id_purchase_date;    
							  $bp_id_purchase_city			=	 $trend->bp_id_purchase_city;    
							  $bp_id_purchase_pincode		=	 $trend->bp_id_purchase_pincode;    
							  $bp_id_retailer_name			=	 $trend->bp_id_retailer_name;    
							  $bp_id_retailer_code			=	 $trend->bp_id_retailer_code;    
							  $bp_id_retailer_number		=	 $trend->bp_id_retailer_number;    
							  $bp_id_warranty_start_date	=	 $trend->bp_id_warranty_start_date;    
							  $bp_id_warranty_end_date		=	 $trend->bp_id_warranty_end_date;    
							  $bp_id_guarantee_start_date	=	 $trend->bp_id_guarantee_start_date;    
							  $bp_id_image					=	 $trend->bp_id_image;    
							  $bp_id_guarantee_end_date		=	 $trend->bp_id_guarantee_end_date;    
						} 
						
						
						 date_default_timezone_set('Asia/Kolkata');
						  $fields_reg = array(
								'up_user_id' 						=> $add_product_user_id,
								'up_product_id'						=> $add_product_product_id,
								'up_dealer_name'					=> $add_product_user_dealer_name,
								'up_serial_no' 						=> $bp_serial_no,
								'up_owner_invoice_copy' 			=> $bp_id_invoice_copy,
								'up_owner_invoice_no' 				=> $bp_id_invoice_no,
								'up_owner_manual' 					=> $bp_id_manual,
								'up_owner_guarantee_document' 		=> $bp_id_guarantee_document,
								'up_owner_warranty_document' 		=> $bp_id_warranty_document,
								'up_owner_email' 					=> $bp_id_user_email,
								'up_owner_address' 					=> $bp_id_user_address,
								'up_owner_purchase_date' 			=> $bp_id_purchase_date,
								'up_owner_purchase_city' 			=> $bp_id_purchase_city,
								'up_owner_purchase_pincode'			=> $bp_id_purchase_pincode,
								'up_owner_retailer_name' 			=> $bp_id_retailer_name,
								'up_owner_retailer_code' 			=> $bp_id_retailer_code,
								'up_owner_retailer_number' 			=> $bp_id_retailer_number,
								'up_owner_warranty_start_date' 		=> $bp_id_warranty_start_date,
								'up_owner_warranty_end_date' 		=> $bp_id_warranty_end_date,
								'up_owner_guarantee_start_date' 	=> $bp_id_guarantee_start_date,
								'up_owner_guarantee_end_date' 		=> $bp_id_guarantee_end_date,
								'up_owner_image' 					=> $bp_id_image,
								'up_created_date' 					=> date('Y-m-d h:i:s'),
								'up_serial_no_image'				=> $add_icon
							);
					
					// print_r($fields_reg);exit;
			}else{
				 $fields_reg = array(
								'up_user_id' 						=> $add_product_user_id,
								'up_product_id'						=> $add_product_product_id,
								'up_dealer_name'					=> $add_product_user_dealer_name,
								'up_serial_no' 						=> $add_product_user_serial_no,
								'up_created_date' 					=> date('Y-m-d h:i:s'),
								'up_serial_no_image'				=> $add_icon
							);
			}
			// print_r($fields_reg);exit;
            $table_log_in = $table['tb4'];
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
			if($arr_result){
				if( $add_product_installation=='Yes'){
					$srm_c_date 					 = 	date('Y-m-d H:i:s');
					$fields_reg = array(
							'srm_user_id' 				=> $add_product_user_id,  
							'srm_product_id'			=> $add_product_product_id,
							'srm_user_notes'			=> 'Requested for insatllaion',
							'srm_c_date' 				=> $srm_c_date,
							'srm_user_generated_date'	=> $srm_c_date,
							'srm_installation'			=> $add_product_installation,
							'srm_installation_date'		=> $add_product_instal_date,
						); 
						// print_r($fields_reg);exit;
					$table_log_in = $table['tb8'];
					$arr_result   = $this->model->insert($table_log_in, $fields_reg);
					  
					if($device_type=='Android'){    
						$pushMessage['SRM_id']			 = 	$arr_result;
						$pushMessage['message']			 = 	"Service request for insatllation";
							if (isset($user_gcm_id) && isset($pushMessage)) {		
							$gcmRegIds  = array($user_gcm_id); 
							$message = array("msg" => $pushMessage);	
							$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
							// echo'<pre>';print_r($message); 
							}
						return $result;
					}
 
					
					
					if($device_type=='IOS'){ 
						return $result;
					}	
					
					
					
					
				}
			}
			// print_r($arr_result);exit;
			return $arr_result;
			
			}
		}else{
			return $arr_log_in=1;
		}
    }
	/*********************************************************************************************************************************/	

	function upload_digilocker(){
		
        $table           				 = 	table();
		date_default_timezone_set('Asia/Kolkata');
        $dl_user_token_key   	 = 	$_POST['dl_user_token_key'];
        $dl_product_type_id   			 = 	$_POST['dl_product_type_id'];
        $dl_user_id   					 = 	$_POST['dl_user_id'];
        $dl_document				   	 = 	$this->file_upload();
        $dl_doc_type					 = 	$_POST['dl_doc_type'];
        $dl_product_id				  	 = 	$_POST['dl_product_id'];
        $dl_updated_time				 = 	 date('Y-m-d h:i:s');
       
		
	   
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        // $condition_log_in				 = 	'user_token    = '.$add_product_user_token_key;
        $condition_log_in				 =  "user_token    =$dl_user_token_key and user_id= $dl_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		
		//print_r($arr_log_in);exit;
		
		$device_type				     =	$arr_log_in[0]['user_login_device']; 
		$user_gcm_id				 	 =	$arr_log_in[0]['user_gcm_id']; 
		
		
		
		// print_r($arr_log_in);exit;
		if($arr_log_in){//print_r($arr_log_in);exit;
			//$table_log_in    				 = 	"users_digilocker";
				
			$fields_reg = array(
								'dl_product_type_id'		=> $dl_product_type_id,
								'dl_user_id'				=> $dl_user_id,
								'dl_document'				=> $dl_document,
								'dl_doc_type' 				=> $dl_doc_type,
								'dl_product_id' 			=> $dl_product_id,
								'dl_updated_time'			=> $dl_updated_time
							);
			
			// print_r($fields_reg);exit;
            $table_log_in = "users_digilocker";
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
			
			return $arr_result;
			
		}else{
			return $arr_log_in=1;
		}
    }
		
	
	/*********************************************************************************************************************************/	
	//upload files
	function file_upload(){
		
			if(!empty($_FILES['file_name']['name']))
			{ 
				// echo "hi";exit;
				$filename = basename($_FILES['file_name']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				$now = new DateTime();
				$times = $now->getTimestamp();
				$target = "/var/www/html/testing/digilocker_images/"; 
				//Determine the path to which we want to save this file
				$newname = $target.$times.'-'.$filename;
				$newname1 = $times.'-'.$filename;
				// echo $newname;exit;
				//Check if the file with the same name is already exists on the server
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['file_name']['tmp_name'],$newname))) {
							 $add_icon=$newname1;
							 return $newname1;
						}else{
								$message	=	"Could not move the file!";
								return $message;
						}
					}
					else return "error";
			}
	}
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	//feching User Product List
	function user_product_list()
    {
        $table           				 = 	table();
        $user_product_list_token_key     = 	$_POST['user_product_list_token_key'];
        $user_product_list_user_id		 = 	$_POST['user_product_list_user_id'];
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_token    =$user_product_list_token_key and user_id= $user_product_list_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in );
		if($arr_log_in){
			$table		    				 = 	$table['tb4'];
			$fields							 =  '*';
			$condition		 				 = 	"up_user_id    =$user_product_list_user_id and up_user_status =1";
			$arr_log_in       				 = 	$this->model->user_product_list($table, $fields, $condition);
			// print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	//feching User digilocker  List
	function user_digilocker_list()
    {
        $table           				 = 	table();
        $dl_user_token_key     			 = 	$_POST['dl_user_token_key'];
        $digilocker_user_id				 = 	$_POST['dl_user_id'];
        $dl_product_type_id		 		 = 	$_POST['dl_product_type_id'];
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_token    =$dl_user_token_key and user_id= $digilocker_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		//print_r($arr_log_in );
		if($arr_log_in){
			$table		    				 =  "users_digilocker";
			$fields							 =  '*';
			$condition		 				 = 	"dl_user_id    =$digilocker_user_id and dl_product_type_id=$dl_product_type_id";
			$arr_log_in       				 = 	$this->model->get_Details_condition($table, $fields, $condition);
			//print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	//feching User Particular Product List
	function user_particular_product_list()
    {
        $table           				 = 	table();
        $user_product_list_token_key     = 	$_POST['user_particular_product_list_token_key'];
        $user_particular_product_list_id = 	$_POST['user_particular_product_list_id'];
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_token    =$user_product_list_token_key";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in );
		if($arr_log_in){
			$table		    				 = 	$table['tb4'];
			$fields							 =  '*';
			$condition		 				 = 	'up_id    ='.$user_particular_product_list_id;
			$arr_log_in       				 = 	$this->model->user_product_list($table, $fields, $condition);
			// print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// SRM Question list
	function user_srm_question_list()
    {
        $table           				 = 	table();
        $user_srm_user_token_key	     = 	$_POST['user_srm_user_token_key'];
        $user_srm_user_id				 = 	$_POST['user_srm_user_id'];
        $user_srm_bp_id					 = 	$_POST['user_srm_bp_id'];
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_token    =$user_srm_user_token_key and user_id=  $user_srm_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in );exit;
		if($arr_log_in){
			$table		    				 = 	$table['tb6'];
			$fields							 =  '*';
			$condition		 				 = 	'srm_question_bp_id    ='.$user_srm_bp_id;
			$arr_log_in       				 = 	$this->model->user_srm_question_list($table, $fields, $condition);
			// print_r($arr_log_in );
			if($arr_log_in){
				return $arr_log_in;
			}else{
				return $arr_log_in=1;
			}
		}else{
			return $arr_log_in=2;
		}
    }
	
	
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// SRM user answered list
	function user_srm_question_answers()
    {
        $table           				 = 	table();
        $user_srm_ans_user_token_key     = 	$_POST['user_srm_ans_user_token_key'];
        $user_srm_ans_user_id			 = 	$_POST['user_srm_ans_user_id'];
        $user_srm_ans_que				 = 	$_POST['user_srm_ans_que'];
		// print_r($_POST['user_srm_ans_que']);
		// echo (count($user_srm_ans_que));exit;
		for($i=0;$i<(count($user_srm_ans_que));$i++){
			if($user_srm_ans_que[$i]==''){
				$que	.=	'0,';
			}else{
				$que	.=	$user_srm_ans_que[$i].',';
			} 
		}
		$que	=	trim($que, ",");


		
        $user_srm_ans					 = 	$_POST['user_srm_ans'];  
		for($i=0;$i<(count($user_srm_ans));$i++){
			if($user_srm_ans[$i]==''){
				$ans	.=	'0,';
			}else{
				$ans	.=	$user_srm_ans[$i].',';
			}
		}
		$ans	=	trim($ans, ","); 
		
		
        $user_srm_ans_notes				 = 	$_POST['user_srm_ans_notes'];
        $user_srm_ans_product_id		 = 	$_POST['user_srm_ans_product_id'];
		date_default_timezone_set('Asia/Kolkata');
		$srm_c_date 					 = 	date('Y-m-d H:i:s');
				
		$table_log_in    				 = 	$table['tb1'];
		$table1						     = 	$table['tb7'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_token    =$user_srm_ans_user_token_key and user_id=  $user_srm_ans_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in); exit;
		
		if($arr_log_in){ 
		
			$fields_reg = array(
					'srm_user_id' 				=> $user_srm_ans_user_id,
					'srm_questions' 			=> $que,
					'srm_answers' 				=> $ans,
					'srm_user_notes'			=> $user_srm_ans_notes,
					'srm_product_id'			=> $user_srm_ans_product_id,
					'srm_c_date' 				=> $srm_c_date,
					'srm_user_generated_date'	=> $srm_c_date,
				); 
				// print_r($fields_reg);exit;
			$table_log_in = $table['tb8'];
			$arr_result   = $this->model->insert($table_log_in, $fields_reg);
			return $arr_result;
		}else{ 
			return $arr_result='';
		}
		 
    }
	
	
	
	
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// User SRM list
	function user_srm_list()
    {
        $table           				 = 	table();
        $user_srm_user_token_key	     = 	$_POST['user_srm_list_user_token_key'];
        $user_srm__list_user_id			 = 	$_POST['user_srm__list_user_id']; 
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_token    =$user_srm_user_token_key and user_id=  $user_srm__list_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in );exit;
		if($arr_log_in){
			$table		    				 = 	$table['tb8'];
			$fields							 =  '*';
			$condition		 				 = 	'srm_user_id    ='.$user_srm__list_user_id;
			$arr_log_in       				 = 	$this->model->user_srm_list($table, $fields, $condition);
			// print_r($arr_log_in );
			if($arr_log_in ){
				return $arr_log_in;
			}else{
				return $arr_log_in=1;
			}
		}else{
			return $arr_log_in=2;
		}
    }
	
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// Brand list
	function brand_list()
    {
        $table           				 = 	table();
        $brand_user_token_key		     = 	$_POST['brand_user_token_key'];
        $brand_user_id					 = 	$_POST['brand_user_id']; 
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_token    =$brand_user_token_key and user_id=  $brand_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in );exit;
		if($arr_log_in){
			$table		    				 = 	$table['tb2']; 
			$order_by						 =	'brand_priority';
			$fields						 =	'*';
			$condition						 =	'brand_status	=	1';
			$arr_log_in       				 = 	$this->model->get_details_condition_orderby_asc($table,$fields,$condition,$order_by);
			// $arr_log_in       				 = 	$this->model->get_Detail_all_order_by($table,$order_by);
			// print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }
	
	
	
	
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// Product List depends on Brand  
	function product_list_depends_brand()
    {
        $table           				 = 	table();
        $product_user_token_key		     = 	$_POST['product_user_token_key'];
        $product_user_id				 = 	$_POST['product_user_id']; 
        $brand_id						 = 	$_POST['brand_id']; 
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_token    =$product_user_token_key and user_id=  $product_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in );exit;
		if($arr_log_in){
			$table		    				 = 	$table['tb3'];
			$fields							 =  '*'; 
			$condition_log_in				 = 	"product_brand_id    =$brand_id";
			$arr_log_in       				 = 	$this->model->product_list_depends_brand($table, $fields, $condition_log_in);
			// print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }
	
	
	

	
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// User Particular SRM Details  
	function srm_details_particular_product()
    {
        $table           				 = 	table();
        $srm_details_user_token_key	     = 	$_POST['srm_details_user_token_key'];
        $srm_details__user_id			 = 	$_POST['srm_details__user_id']; 
        $srm_id						 	 = 	$_POST['srm_id']; 
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_token    =$srm_details_user_token_key and user_id=  $srm_details__user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in );exit;
		if($arr_log_in){
			$table		    				 = 	$table['tb8'];
			$fields							 =  '*'; 
			$condition_log_in				 = 	"srm_id    =$srm_id";
			$arr_log_in       				 = 	$this->model->srm_details_particular_product($table, $fields, $condition_log_in);
			// print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }
		
		
	 
	
/*----------------------------------------------------------------------------------------------------------------------*/		
	


// Complete SRM Ticket request  
	function srm_ticket_complete()
    {
        $table           				 = 	table();
		date_default_timezone_set('Asia/Kolkata'); 
        $srm_complete_token_key		   	 = 	$_POST['srm_complete_token_key'];
        $srm_complete_eng_on_time   	 = 	$_POST['srm_complete_eng_on_time'];
        $srm_complete_eng_time_spent   	 = 	$_POST['srm_complete_eng_time_spent'];
        $srm_complete_rating		   	 = 	$_POST['srm_complete_rating'];
        $srm_complete_comment		  	 = 	$_POST['srm_complete_comment']; 
        $srm_complete_user_id		  	 = 	$_POST['srm_complete_user_id']; 
        $srm_complete_srm_id		  	 = 	$_POST['srm_complete_srm_id']; 
        $srm_complete_srm_status		 = 	$_POST['srm_complete_srm_status']; 
		
		if($srm_complete_srm_status==6){
			$srm_complete_srm_status	=	7; 
		}elseif($srm_complete_srm_status==26){
			$srm_complete_srm_status	=	27;  
		}elseif($srm_complete_srm_status==246){
			$srm_complete_srm_status	=	247;  
		}elseif($srm_complete_srm_status==36){
			$srm_complete_srm_status	=	37;  
		}else{
			$srm_complete_srm_status	=	7;  
		}
		
		
		
        $srm_complete_date			  	 = 	date('Y-m-d h:i:s'); 
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        // $condition_log_in				 = 	'user_token    = '.$add_product_user_token_key;
        $condition_log_in				 =  "user_token    =$srm_complete_token_key and user_id= $srm_complete_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);exit;
		if($arr_log_in){  
				 $fields_reg = array( 
								'srm_complete_eng_on_time'			=> $srm_complete_eng_on_time,
								'srm_complete_eng_time_spent'		=> $srm_complete_eng_time_spent,
								'srm_complete_rating' 				=> $srm_complete_rating,
								'srm_complete_comment'				=> $srm_complete_comment,
								'srm_complete_date'					=> $srm_complete_date,
								'srm_status'						=> $srm_complete_srm_status
							);
				
			// print_r($fields_reg);exit;
            $table_log_in = $table['tb8'];
            $condition     = 'srm_id = ' . "'" . $srm_complete_srm_id . "'";
			$arr_log_in    = $this->model->update($table_log_in, $fields_reg, $condition);
			if($arr_log_in){ 
			
			//get usr id
			$fields			=	'*';
			$condition 		=	"srm_id='".$srm_complete_srm_id."'";		
			$result			=	$this->model->get_Details_condition($table_log_in,$fields,$condition); 
			$user_id		=	$result[0]['srm_user_id'];
			// print_r($result);exit;
			
			//get user gcm and device type
			$table_user		=	$table['tb1'];
			$fields			=	'*';
			$condition 		=	"user_id='".$user_id."'";		
			$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
			$device_type	=	$result[0]['user_login_device']; 
			$user_gcm_id	=	$result[0]['user_gcm_id']; 
			// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
			// echo'<pre>';print_r($result);exit;
			
			
			
			
			if($device_type=='Android'){    
				$pushMessage['SRM_id']			 = 	$srm_complete_srm_id;
				$pushMessage['message']			 = 	"Service Completed Successfully";
					if (isset($user_gcm_id) && isset($pushMessage)) {		
					$gcmRegIds  = array($user_gcm_id); 
					$message = array("msg" => $pushMessage);	
					$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
					// echo'<pre>';print_r($message); 
					}
				return $result;
			}

			
			
			
			if($device_type=='IOS'){ 
				return $result;
			}	
			
			
			
			
		}
			
			}  else{
			return $arr_log_in='';
		}
    }
	
	
	
	
	

/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	 

// cancel SRM Ticket request  
	function srm_ticket_cancel()
    {
        $table           				 = 	table();
		date_default_timezone_set('Asia/Kolkata'); 
        $srm_cancel_token_key		  	 = 	$_POST['srm_cancel_token_key'];  
        $srm_cancel_user_id			  	 = 	$_POST['srm_cancel_user_id'];  
        $srm_cancel_srm_id		  		 = 	$_POST['srm_cancel_srm_id']; 
        $srm_cancel_srm_status			 = 	$_POST['srm_cancel_srm_status']; 
		
		
		
		
        $srm_cancel_date			  	 = 	date('Y-m-d h:i:s'); 
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        // $condition_log_in				 = 	'user_token    = '.$add_product_user_token_key;
        $condition_log_in				 =  "user_token    =$srm_cancel_token_key and user_id= $srm_cancel_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		$user_name						 =	$arr_log_in[0]['user_name'].' (user)';
		$user_phone						 =	$arr_log_in[0]['user_phone'].' (user)';
		// print_r($arr_log_in);exit;
		if($arr_log_in){  
		
			if($srm_cancel_srm_status==0){ 
				
				$MVQ_no_generated_date	=	date('Y-m-d h:i:s');
				$MVQ_No					=	rand(1000, 99999);
				$mvq_admin_name			=	$_POST['mvq_admin_name'];
				$mvq_admin_phone_no		=	$_POST['mvq_admin_phone_no'];
				
				if($srm_cancel_srm_status==0  || $srm_cancel_srm_status == 3){
		
					$srm_cancel_srm_status	=	5; 
					
				}elseif($srm_cancel_srm_status == 2 || $srm_cancel_srm_status == 23 || $srm_cancel_srm_status==24){
				
					$srm_cancel_srm_status	=	25;  
					
				}elseif($srm_cancel_srm_status == 244){
				
					$srm_cancel_srm_status	=	245; 
					
				}elseif($srm_cancel_srm_status == 3 ||$srm_cancel_srm_status == 34){
				
					$srm_cancel_srm_status	=	35;  
					
				}else{
				
					$srm_cancel_srm_status	=	5;  
					
				}
					 $fields_reg = array(  
									'srm_MVQ_no'					=>	$MVQ_No,	 
									'srm_MVQ_execative_number'		=>	$user_phone,	
									'srm_MVQ_execative_name'		=>	$user_name,	
									'srm_MVQ_no_generated_date'		=>	$MVQ_no_generated_date,
									'srm_status'					=>	$srm_cancel_srm_status,
									'srm_MVQ_execative_notes'		=>	'NA',
								);
			}else{
			
				if($srm_cancel_srm_status==0  || $srm_cancel_srm_status == 3){
		
					$srm_cancel_srm_status	=	5; 
					
				}elseif($srm_cancel_srm_status == 2 || $srm_cancel_srm_status == 23 || $srm_cancel_srm_status==24){
				
					$srm_cancel_srm_status	=	25;  
					
				}elseif($srm_cancel_srm_status == 244){
				
					$srm_cancel_srm_status	=	245; 
					
				}elseif($srm_cancel_srm_status == 3 ||$srm_cancel_srm_status == 34){
				
					$srm_cancel_srm_status	=	35;  
					
				}else{
				
					$srm_cancel_srm_status	=	5;  
					
				}
				

				 $fields_reg = array(   
									'srm_status'					=>	$srm_cancel_srm_status,
								);
			}	
			
			
			// print_r($fields_reg);exit;
            $table_log_in = $table['tb8'];
            $condition     = 'srm_id = ' . "'" . $srm_cancel_srm_id . "'";
			$arr_log_in    = $this->model->update($table_log_in, $fields_reg, $condition);
				if($arr_log_in){ 
				
				//get usr id
				$fields			=	'*';
				$condition 		=	"srm_id='".$srm_cancel_srm_id."'";		
				$result			=	$this->model->get_Details_condition($table_log_in,$fields,$condition); 
				$user_id		=	$result[0]['srm_user_id'];
				$MVQ_No			=	$result[0]['srm_MVQ_no'];
				// print_r($result);exit;
				
				//get user gcm and device type
				$table_user		=	$table['tb1'];
				$fields			=	'*';
				$condition 		=	"user_id='".$user_id."'";		
				$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
				$device_type	=	$result[0]['user_login_device']; 
				$user_gcm_id	=	$result[0]['user_gcm_id']; 
				// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
				// echo'<pre>';print_r($result);exit;
				
				
				
				
				if($device_type=='Android'){    
					$pushMessage['SRM_id']			 = 	$srm_cancel_srm_id;
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['status']			 = 	$srm_cancel_srm_status;
					$pushMessage['message']			 = 	"Ticket-cancelled";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message); 
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	
				
			
			
				
			}
			
			}  else{
			return $arr_log_in='';
		}
    }
	
	
	
	
	

/*----------------------------------------------------------------------------------------------------------------------*/		
	



// Complete SRM Ticket request  
	function update_user_product()
    {
        $table           					 = 	table();
		date_default_timezone_set('Asia/Kolkata'); 
        $user_product_token_key		   		= 	$_POST['user_p_token_key'];
        $user_product_user_id   		 	= 	$_POST['user_p_user_id'];
        $user_product_address		   	 	= 	$_POST['user_p_address'];
        $user_product_title			   		= 	$_POST['user_p_title'];
        $user_product_warranty_start_date	= 	$_POST['user_p_warranty_s_date']; 
        $user_product_warranty_end_date	 	= 	$_POST['user_p_warranty_e_date']; 
        $user_product_guarantee_start_date	=	$_POST['user_p_guarantee_s_date']; 
        $user_product_guarantee_end_date	=	$_POST['user_p_guarantee_e_date']; 
        $user_product_id					=	$_POST['user_p_id'];  
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        // $condition_log_in				 = 	'user_token    = '.$add_product_user_token_key;
        $condition_log_in				 =  "user_token    =$user_product_token_key and user_id= $user_product_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);exit;
		if($arr_log_in){  
				 $fields_reg = array( 
								'up_location'						=> $user_product_address,
								'up_title'							=> $user_product_title,
								'up_warranty_start_date' 			=> $user_product_warranty_start_date,
								'up_warranty_end_date'				=> $user_product_warranty_end_date,
								'up_guarantee_start_date'			=> $user_product_guarantee_start_date,
								'up_guarantee_end_date'				=> $user_product_guarantee_end_date
							);
				
			// print_r($fields_reg);exit;
            $table_log_in = $table['tb4'];
            $condition     = 'up_id = ' . "'" . $user_product_id . "'";
			$arr_log_in    = $this->model->update($table_log_in, $fields_reg, $condition); 
			return $arr_log_in;
		}  else{
			return $arr_log_in='';
		}
    }
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	 


// Update user profile
	function update_user_profile()
    {
        $table           					 = 	table(); 
        $up_p_token_key				   		= 	$_POST['up_p_token_key'];
        $up_p_user_id			   		 	= 	$_POST['up_p_user_id'];
        $up_p_address				   	 	= 	$_POST['up_p_address'];
        $up_p_pincode				   		= 	$_POST['up_p_pincode']; 
        $up_p_name					   		= 	$_POST['up_p_name']; 
		
		$table_log_in    				    = 	$table['tb1'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_token    =$up_p_token_key and user_id= $up_p_user_id";
        $arr_log_in      	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);exit;
		
		
		if($arr_log_in){  
				 $fields_reg = array( 
								'user_address'						=> $up_p_address,
								'user_area_pincode'					=> $up_p_pincode,
								'user_name' 						=> $up_p_name
							);
				
			// print_r($fields_reg);exit;
            $table_log_in = $table['tb1'];
            $condition     = 'user_id = ' . "'" . $up_p_user_id . "'";
			$arr_log_in    = $this->model->update($table_log_in, $fields_reg, $condition); 
			return $arr_log_in;
		}  else{
			return $arr_log_in='';
		}
    }
	
	
	
	
	

/*----------------------------------------------------------------------------------------------------------------------*/		
	
	 


// User Feedback
	function user_feedback()
    {
        $table           					 = 	table(); 
        $fb_token_key				   		= 	$_POST['fb_token_key'];
        $fb_user_id				   		 	= 	$_POST['fb_user_id'];
        $fb_rating					   	 	= 	$_POST['fb_rating'];
        $fb_message					   		= 	$_POST['fb_message']; 
		
		$table_log_in    				    = 	$table['tb1'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_token    =$fb_token_key and user_id= $fb_user_id";
        $arr_log_in      	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);exit;
		
		
		if($arr_log_in){  
				 $fields_reg = array( 
								'fb_rating'							=> $fb_rating,
								'fb_message'						=> $fb_message,
								'fb_user_id' 						=> $fb_user_id
							);
				
			// print_r($fields_reg);exit;  
            $table_log_in = $table['tb9'];
            $arr_result   = $this->model->insert($table_log_in, $fields_reg); 
			return $arr_result;
		}  else{
			return $arr_log_in='';
		}
    }
	
		
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	 


// User AMC Request
	function user_amc_request()
    {
        $table                              = 	table(); 
        $amc_token_key				   		= 	$_POST['amc_token_key'];
        $amc_user_id			   		 	= 	$_POST['amc_user_id'];
        $amc_user_p_id				   	 	= 	$_POST['amc_user_p_id']; 
		
		
		$table_log_in    				    = 	$table['tb1'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_token    =$amc_token_key and user_id= $amc_user_id";
        $arr_log_in      	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);exit;
		
		
		if($arr_log_in){  
				 $fields_reg = array(  
								'amc_req_user_id'					=> $amc_user_id,
								'amc_req_product_id' 				=> $amc_user_p_id
							);
				
			// print_r($fields_reg);exit;  
            $table_log_in = $table['tb10'];
            $arr_result   = $this->model->insert($table_log_in, $fields_reg); 
			return $arr_result;
		}  else{
			return $arr_log_in='';
		}
    }
	
		
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
	
	function get_banner_home_screen_images()
	{
		$table           				 = 	table();
        $table_name	    				 = 	$table['tb11'];
        $banner_for			           	 = 	$_POST['banner_for'];    
		$fields			   				 = 	'*';
		$condition						 = 	'banner_for    = ' . "'" . $banner_for . "'" . ' AND banner_status = 1'. ' AND banner_screens_for = 1 or banner_screens_for = 3';
		$orderby						 =	'banner_priority';
		$arr_result      	 			 = 	$this->model->get_banner_images($table_name, $fields, $condition,$orderby); 
		// print_r($arr_result);exit; 		
		return $arr_result;
		 
		
	}
	
	 
			
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
	
	function get_banner_amc_screen_images()
	{
		$table           				 = 	table();
        $table_name	    				 = 	$table['tb11'];
        $banner_for			           	 = 	$_POST['banner_for_amc'];    
		$fields			   				 = 	'*';
		$condition						 = 	'banner_for    = ' . "'" . $banner_for . "'" . ' AND banner_status = 1'. ' AND banner_screens_for = 2 or banner_screens_for = 3';
		$orderby						 =	'banner_priority';
		$arr_result      	 			 = 	$this->model->get_banner_images($table_name, $fields, $condition,$orderby); 
		// print_r($arr_result);exit; 		
		return $arr_result;
		 
		
	}
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	 


// User AMC Request
	function user_product_history()
    {
        $table                              = 	table(); 
        $history_u_token_key		   		= 	$_POST['history_u_token_key'];
        $history_user_id		   		 	= 	$_POST['history_user_id'];
        $history_user_p_id			   	 	= 	$_POST['history_user_p_id']; 
		
		
		$table_log_in    				    = 	$table['tb1'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_token    =$history_u_token_key and user_id= $history_user_id";
        $arr_log_in      	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);exit;
		
		
		if($arr_log_in){  
		
			$table_log_in    				    = 	$table['tb4'];
			$fields_log_in   				    = 	'up_product_id,up_id,up_created_date'; 
			$condition_log_in				    =  "up_id    =$history_user_p_id";
			$arr_log_in01      	 			  	= 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			$up_id								=	$arr_log_in01[0]['up_product_id'];
			// print_r($arr_log_in[0]['up_id']);exit;
			$arr_log_in				=	array();
			$arr_log_in['P_Added']	=	$arr_log_in01;
			
			$table_log_in    				    = 	$table['tb8'];
			$fields_log_in   				    = 	'srm_id,srm_c_date'; 
			$condition_log_in				    =  "srm_product_id    =$up_id and srm_user_id	=	$history_user_id";
			$arr_log_in11      	 			  	= 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			
			$arr_log_in1 =	array();
			$arr_log_in1['SRM']	=	$arr_log_in11;
			
			
			
			$table_log_in    				    = 	$table['tb10'];
			$fields_log_in   				    = 	'amc_req_user_id,amc_req_c_date'; 
			$condition_log_in				    =  "	amc_req_product_id    =$history_user_p_id and amc_req_user_id	=	$history_user_id";
			$arr_log_in22      	 			  	= 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			// print_r($arr_log_in22);exit;
			$arr_log_in2	=	array();
			$arr_log_in2['AMC']	=	$arr_log_in22;
			
			
			$array_history	=	array();
			$array_history	=	array_merge($arr_log_in,$arr_log_in1);
			
			$history	=	array();
			
			$history	=	array_merge($array_history,$arr_log_in2); 
			$history['msg']	=	'Success';
			// print_r($history);exit;
			return $history;
		}
    }
	
		
		 

	/*Delete Usee Added Product*/
	function delete_user_product()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb4']; 
		$del_up_id			=	$_POST['del_up_id'];
		$del_user_id		= 	$_POST['del_user_id'];
        $del_u_token_key	= 	$_POST['del_u_token_key']; 
		
		
		$table_log_in    				    = 	$table['tb1'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_token    =$del_u_token_key and user_id= $del_user_id";
        $arr_log_in      	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);exit;
		
		
		if($arr_log_in){   
			$condition			=	"up_id='$del_up_id'";
			$res				=	$this->model->delete_row_data($table_name,$condition);
			return $res;
		}else{
			return $arr_log_in='';
		}
		
		
	}
	

	
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	 


// User amc_price_list
	function amc_price_list()
    {
        $table                              = 	table(); 
        $amc_token_key				   		= 	$_POST['amc_price_token_key'];
        $amc_user_id			   		 	= 	$_POST['amc_price_user_id']; 
        $amc_price_p_id				   	 	= 	$_POST['amc_price_user_p_id']; 
		
		
		$table_log_in    				    = 	$table['tb1'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_token    =$amc_token_key and user_id= $amc_user_id";
        $arr_log_in      	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);exit;
		
		
		if($arr_log_in){  
		
		
			$table_log_in    				    = 	$table['tb3'];
			$fields_log_in   				    = 	'*'; 
			$condition_log_in				    =  "product_id= $amc_price_p_id";
			$arr_log_in      	 			    = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			$product_brand_id					=	$arr_log_in[0]['product_brand_id'];
			$product_name						=	$arr_log_in[0]['product_name'];
			 
			
			$amc_price_table			    = 	$table['tb12'];
			$fields		  				    = 	'*'; 
			$condition					    =  "amc_price_brand_id    =$product_brand_id and amc_price_brand_name= $product_name and amc_pricelist_status =1";
			$arr_result    	 			  = 	$this->model->get_amc_price_list($amc_price_table, $fields, $condition);	 
			if($arr_result){
				return $arr_result;
			}else{
				return $arr_result=2;
			}
		}  else{
			return $arr_log_in=1;
		}
    }
	
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	 


// APK version check
	function apk_version_check()
    {
        $table                          = 	table(); 
        $apk_version				   	= 	$_POST['apk_version'];  
		$amc_price_table			    = 	$table['tb13'];
		$fields		  				    = 	'*'; 
		$condition					    =  "apk_version_name    =$apk_version and apk_version_status= 1";
		$arr_result    	 				= 	$this->model->get_Details_condition($amc_price_table, $fields, $condition);	 
		return $arr_result;
	 
    }
	

/*----------------------------------------------------------------------------------------------------------------------*/		
	
	 


// Update user GCM
	function update_user_gcm()
    {
        $table           					= 	table();  
        $up_p_user_id			   		 	= 	$_POST['gcm_user_id'];  
        $gcm_user				   		 	= 	$_POST['gcm_user'];  
		$table_log_in    				    = 	$table['tb1'];
       
			 $fields_reg = array( 
							'user_gcm_id'						=> $gcm_user, 
						);
			
		// print_r($fields_reg);exit; 
		$condition     = 'user_id = ' . "'" . $up_p_user_id . "'";
		$arr_log_in    = $this->model->update($table_log_in, $fields_reg, $condition); 
		return $arr_log_in; 
    }
	
	
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
	
	
	
	// GCM Notification to user
	function sendMessageThroughGCM($gcmRegIds, $message) { 
		//Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $gcmRegIds,
            'data' => $message
        );
		// echo '<pre>';print_r($fields);exit;	
		// Update your Google Cloud Messaging API Key 
		// define("GOOGLE_API_KEY", "AIzaSyCdKmh8V0icBG2x2kE2ymk_Afp6fuvDTp8"); 	//user server key
		define("GOOGLE_API_KEY", "AIzaSyAInPAdZ7X6YThaHkkQvWhWp3c8qePWOtI"); 	//user server key
	


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
		// print_r($result);  exit;
        curl_close($ch);
        return $result ;
    }
	
}
?>
 
