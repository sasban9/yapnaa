<?php

if(isset($_POST['value']))
{
	require_once(__DIR__.'/'.'../model/model.php');
	$obj_model	=new model;
	require_once(__DIR__.'/'.'../config/tab_config.php');
}else{
	require_once(__DIR__.'/'.'../model/model.php');
	$obj_model	=new model;
	require_once(__DIR__.'/'.'../config/tab_config.php');
} 



class users 
{
	
    function __construct()
    {
		//parent::__construct();
        global $obj_model;
        global $tb;
        $this->model =& $obj_model;
		
    }
  function	news_later_subscribe($name,$email){
		  $fields_reg = array(
					'name' 				=> $name,
					'emailid' 			=> $email,
					'datetime'         =>date('Y-m-d h:i:s')
				);
		$table_log_in = 'news_later';
		  $condition_log_in				 = 	'name= '.$reg_otp.' and emailid='.$email;
		  $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, '*', $condition_log_in);
          if($arr_log_in ==NULL)
		  {
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
			return true;
		  }else{
			  return false;
		  }
	}
   function n_yapnaa_send_mail(){
	   $name=$_POST['name'];
	   $email=$_POST['email'];
	   $subject1=$_POST['subject'];
	   $message1=$_POST['message'];
	  $to = "info@yapnaa.com";
$subject = "$subject1";

$message = "
<html>
<head>
<title>Yapnaa</title>
</head>
<body>

<table>
<tr>
<p>$message1</p>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: '.$email."\r\n";

	   if(mail($to, $subject, $message,$headers)){
		   echo '<script>alert("Message sent successfully !")</script>';	
		    echo '<script>window.location.assign("contact-us.php")</script>';
	   }else{
		   echo '<script>alert("Error ! message could not sent")</script>';	
		    echo '<script>window.location.assign("contact-us.php")</script>';
	   }
   }
  function n_sms_send_withotp($user_mobile,$user_reg_verification_otp){
	       $ch = curl_init();
			// $url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1nimbus&password=demo123&sender=ARPITA&sendto=".urlencode($resend_otp_phone_no)."&message=".urlencode("Use OTP:".$user_reg_verification_otp ."for reset your password.\n.");
			 $url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_mobile)."&message=".urlencode("".$user_reg_verification_otp ." - Use this OTP for mobile number verification.\n.");
			//echo $url;exit;	
				
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch );
			return true;
  }	  
  function  n_yapnaa_otp_verification(){
	      $reg_otp                       = $_POST['d_otp'];
	      $table_log_in                  = 'users';
		  $fields_log_in   				 = 	'*';
          $condition_log_in				 = 	'user_reg_verification_otp    = '.$reg_otp;
          $arr_log_in1      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
	      if($arr_log_in1 !=NULL){
			
			$user_last_login 			= 	date('Y-m-d h:i:s');
            $set_array     = array(
                'user_last_login' 			=> $user_last_login,
                'user_reg_verification_otp' => 0,
                'user_status' 				=> 1
            );
            $condition     = 'user_reg_verification_otp = ' . "'" . $reg_otp . "'";
            $arr_log_in    = $this->model->update($table_log_in, $set_array, $condition);
			$_SESSION['user_name']		=  $arr_log_in1[0]['user_name'];
			
			echo '<script>alert("Successfully Logged in !")</script>';  
		header("Location:/movilo/user-dashboard/dashboard.php?vals=".urlencode(serialize($arr_log_in1)));
		 
		  }else{
			 echo '<script>alert("Error ! wrong OTP")</script>';	 
			 echo '<script>window.location.assign("login.php")</script>'; 
		  }
	  
  }
   function  n_yapnaa_resendotp_verification($user_mobile){
	   $table_log_in                 ='users';
	   $user_reg_verification_otp    = rand(1000,9999);
	   
	   $set_array = array(
                
				'user_reg_verification_otp' =>$user_reg_verification_otp 
            );
	   $condition     = 'user_phone = '.$user_mobile;	
	   $arr_log_in    = $this->model->update($table_log_in, $set_array, $condition);
		$ch = curl_init();
			// $url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1nimbus&password=demo123&sender=ARPITA&sendto=".urlencode($resend_otp_phone_no)."&message=".urlencode("Use OTP:".$user_reg_verification_otp ."for reset your password.\n.");
			 $url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_mobile)."&message=".urlencode("".$user_reg_verification_otp ." - Use this OTP for mobile number verification.\n.");
			//echo $url;exit;	
				
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch );
		echo '<script>window.location.assign("otp_verification.php")</script>';
   }
  function  n_yapnaa_forgot_password(){
	      $d_mobile                      = $_POST['d_mobile'];
		  $user_reg_verification_otp    = rand(1000,9999);
	      $table_log_in                  = 'users';
		  $fields_log_in   				 = 	'*';
          $condition_log_in				 = 	'user_phone    = '.$d_mobile;
          $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		  session_start();
		  $_SESSION['user_mobile']		=  $d_mobile;
		  
	      if($arr_log_in !=NULL){			
		    echo '<script>window.location.assign("forgotpass_verification.php")</script>';
		  }else{
			 echo '<script>alert("Error ! The mobile number is not registered")</script>';	 
			 echo '<script>window.location.assign("login.php")</script>'; 
		  }
	  
  }
  function  n_yapnaa_forgot_password_save($user_mobile,$pwd){
	      //echo $pwd;exit;
	      $d_mobile                      = $user_mobile;
		  $table_log_in                  = 'users';
		  $pwd= md5($pwd);
		  $user_reg_verification_otp    = rand(1000,9999);
	       $set_array = array(
                'user_pin' 			        => $pwd,
				'user_reg_verification_otp' =>$user_reg_verification_otp
            );
	      $condition     = 'user_phone = '.$d_mobile;	
	      $arr_log_in    = $this->model->update($table_log_in, $set_array, $condition);
		  $this->n_sms_send_withotp($d_mobile,$user_reg_verification_otp);
	      if($arr_log_in !=NULL){			
		    echo '<script>window.location.assign("otp_verification.php")</script>';
		  }else{
			 echo '<script>window.location.assign("login.php")</script>'; 
		  }
	  
  }
    //new yapnaa login website
	function n_yapnaa_signup(){	
         session_start();	
		$mob= $_POST['d_mobile'];
		$pwd= md5($_POST['d_password']);
        $user_reg_verification_otp    = rand(1000,9999);		
		$fields_reg = array(
                'user_phone' 				=> $mob,
                'user_pin' 			        => $pwd,
                'user_created_date'         =>date('Y-m-d h:i:s'),
				//'user_status'               =>1,
				'user_modified_date'        =>date('Y-m-d h:i:s'),
				//'user_last_login'           =>date('Y-m-d h:i:s'),
                //'launch_created_date' 		=> date('Y-m-d h:i:s'),
				'user_reg_verification_otp' =>$user_reg_verification_otp 
            );
            
            // print_r($fields_reg);exit;
			
            $table_log_in = 'users';
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
		  
		   $_SESSION['user_mobile']		=  $mob;
	        $ch = curl_init();
			// $url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1nimbus&password=demo123&sender=ARPITA&sendto=".urlencode($resend_otp_phone_no)."&message=".urlencode("Use OTP:".$user_reg_verification_otp ."for reset your password.\n.");
			$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($mob)."&message=".urlencode("".$user_reg_verification_otp ." - Use this OTP for mobile number verification.\n.");
				
				
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch );
		echo '<script>window.location.assign("otp_verification.php")</script>';
	}
	function n_yapnaa_login(){
		session_start();
		$mob= $_POST['d_mobile'];
		$pwd= md5($_POST['d_password']);
		$fields_user='*';
		$table_user='users';
		$condition_user='user_phone ='.$mob.' AND user_pin="'.$pwd.'"';
		$user_info = $this->model->get_Details_condition($table_user, $fields_user, $condition_user);
		
		//echo '<pre>';print_r($user_info);
		
		if($user_info !=NULL){
		echo '<script>alert("Successfully Logged in !")</script>'; 
		header("Location:/movilo/user-dashboard/dashboard.php?vals=".urlencode(serialize($user_info)));
		 
		}else{
		echo '<script>alert("Error ! Please provide correct credentials")</script>';	
		echo '<script>window.location.assign("login.php")</script>';	
		}
	}
	function fblogin($fbId){
		$fields_user='*';
		$table_user='users';
		$condition_user='user_social_id=$fbId';
		$user_info = $this->model->get_Details_condition($table_user, $fields_user, $condition_user);
		
		//echo '<pre>';print_r($user_info);
		
		return $user_info;
	}
	
	//logout
	function logout(){
		
		// remove all session variables
		session_unset(); 
		// destroy the session 
		session_destroy();  
		echo '<script>alert("Logout succesfully")</script>';	
		echo '<script>window.location.assign("../../login.php")</script>';
	}
	
	
    //save service request
	function save_request_raise($user,$cust_name,$brand_info,$brand,$issue,$cust_phone){
		$fields_reg = array(
                'loggedin_user' 				=> $user,
                'customer_name' 			    => $cust_name,
                'customer_phone'                =>$cust_phone,
				'product_type'                  =>$brand_info,
				'brand_name'                    =>$brand,
				'issue_type'                    =>$issue,
				'datetime'                      =>date('Y-m-d h:i:s')
				
            );
            
            // print_r($fields_reg);exit;
			
            $table_log_in = 'service_request_raise';
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
			if($arr_result){
				return 1;
			  }
			  else{
				return 0;
			}
	}
    //save social media post
    function social_media_post($user,$msg,$userType){
     $fields_reg = array(
                'customer_name' 				=> $user,
                'social_message' 			    => $msg,
                'type'                           =>$userType,				
				'date'                          =>date('Y-m-d h:i:s')
				
            );
            
            // print_r($fields_reg);exit;
			
            $table_log_in = 'direct_escalation_brand';
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
			if($arr_result){
				return 1;
			  }
			  else{
				return 0;
			}
        
}
   //search result
   public function search_result($search_query){
		$fields_user='*';
		$table_user='brands';
		$condition_user='brand_name like "%'.$search_query.'%"';
		$arr_result11 = $this->model->get_Details_condition($table_user, $fields_user, $condition_user);
		 
			header("Location:yapnaa_search.php?vals=" . urlencode(serialize($arr_result11)));

      }

	// user registartion
    function user_app_launch()
    {
		//print_r($_POST);die;
		date_default_timezone_set('Asia/Kolkata');
        $user_phone 			= 	$_POST['user_phone'];
        $user_email_id 			= 	$_POST['user_email_id'];
        $user_gcm_id      		= 	$_POST['user_gcm_id'];
        $user_device_model		= 	$_POST['user_device_model'];
        $user_device_version	= 	$_POST['user_device_version'];
        $user_device_name		= 	$_POST['user_device_name'];
        $user_device_level		= 	$_POST['user_device_level'];
        $user_imei				= 	$_POST['user_imei'];
        $user_created_date 			= 	date('Y-m-d h:i:s');
          
            $fields_reg = array(
                'launch_no' 				=> $user_phone,
                'launch_email' 			=> $user_email_id,
                'launch_gcm_id' 				=> $user_gcm_id,
                'launch_device_model'			=> $user_device_model,
                'launch_device_version'			=> $user_device_version,
                'launch_device_name'			=> $user_device_name,
                'launch_device_level'			=> $user_device_level,
                'launch_IMEI' 					=> $user_imei,
                'launch_created_date' 		=> $user_created_date,
            );
            
            // print_r($fields_reg);exit;
			
            $table_log_in = 'launch_data_capture';
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
		return $arr_result;
    }
    
	
/*-----------------------------------------------------------------------------------------------------------------------*/
	
	
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
			//print_r($arr_result_test);	echo "here";die;
           if($arr_result_test){
			   if($arr_result_test[0]['user_reg_verification_otp']>0){
				   $msg ='OTP verification Pending';
			   }
			   else{
				   $msg ='This mobile number is already registered with Yapnaa';
			   }
			   $arr = array('msg'=>$msg,'otp'=>$arr_result_test[0]['user_reg_verification_otp'],'data'=>$arr_result_test);
			   return $arr;
		   }
           
        }else{
			$arr_result_test=1;
		}
        //print_r($arr_result_test);exit;
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
			$user_name                          =$user_name;
		    $user_phone                         =$user_phone;
			$subject	                        ="New User";
			$this->send_email($user_name,$user_phone,$subject);
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
			
			/********************************************
				// E-Mail To User
			//$to 			= 	$user_email_id;
			$to 			= 	'hema.jjbytes@gmail.com';
			$subject		=	"Registration done succesfully.";
			 $message		=	'<html>
									<body>
										<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
											<p>From YAPNAA,
											<strong>' . $user_full_name . '</strong></p>
											<p> New User has joined in YAPNAA.</p>
										</table>
									</body>
								</html>';
	
			
            $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
					
            $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
            $headers1 		.= 	"From:yapnaa@gmail.com\r\n";
            
            mail($to, $subject, $message, $headers1);
            
            if (mail($to, $subject, $message, $headers1)) {
				// return $user_reg_verification_otp;
            }			return $fields_reg;
			

			*******************************************/
			
			$ch = curl_init();
			$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_phone)."&message=".urlencode("".$user_reg_verification_otp ." - Use this OTP for mobile number verification.\n.");
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch ); 
			
			return $arr = array('otp'=>$user_reg_verification_otp,'msg'=>'success');
			
            
        }
		else{
			$arr = array('msg'=>"Mobile number already registered",'otp'=>$arr_result_test[0]['user_reg_verification_otp'],'data'=>$arr_result_test);
			return $arr;
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
			return array("data"=>$arr_log_in,"msg"=>"success");
			
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
	
	
function checkout_user_login(){
	
	 $keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		$table           				 = 	table();
        $cuser_phone			         = 	$_POST['cu_user_mobile'];
        // $user_pin			         = 	($_POST['user_login_pin']);
        $cuser_pin			        	 = 	md5($_POST['cu_user_password']);
		$cuser_email			         = 	$_POST['cu_user_email'];
        $cuser_gcm			        	 =  $_POST['user_login_gcm'];
        $capp_key	      				 = 	$_POST['clogin_app_key'];
        $capp_secret      				 = 	$_POST['clogin_app_secret'];
        $cuser_login_device_type		 = 	$_POST['cuser_login_device_type'];
        $ctable_log_in    				 = 	$table['tb15'];
        $cfields_log_in   				 = 	'*';
        $ck_condition_log_in		     = 	'cu_user_password    = ' . "'" . $cuser_pin . "'" . ' and cu_user_email = ' . "'" . $cuser_email . "'" . '';
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($ctable_log_in, $cfields_log_in, $ck_condition_log_in);
		 // print_r($arr_log_in);exit;
		
		if(($keys[0]==$capp_key) && ($keys[1]==$capp_secret)){
			$res	=	1;
		}else{
			$res	=	0;
		}
		
		
		
		if($res==1){
			date_default_timezone_set('Asia/Kolkata');
			$user_last_login 			= 	date('Y-m-d h:i:s');
			$cuser_token				=   rand(1000,9999999);
			
            $cset_array     = array(
                'cuser_gcm_id' 			=> $cuser_gcm,
				'cu_token' 				=> $cuser_token,
				'cu_user_updated' 		=> $user_last_login
            );
            $ck_condition     					=	'user_phone = ' . "'" . $cuser_phone . "'";
            $carr_log_in1   					 = 	$this->model->update($ctable_log_in, $cset_array, $ck_condition);
			$cfields_log_in   				 = 	'*';
			$ckcondition_log_in				 = 	'user_pin    = ' . "'" . $cuser_pin . "'" . ' and user_phone = ' . "'" . $cuser_phone . "'" . ' and user_status = 1';
			$carr_log_in      	 			 = 	$this->model->get_Details_condition($ctable_log_in, $cfields_log_in, $ckcondition_log_in);
			 // print_r($arr_log_in);exit;
			return $carr_log_in;
			
		}
		else{
			return $carr_log_in="";
		}
	
}	
	
/*-----------------------------------------------------------------------------------------------------------------------*/


	function send_welcome_email($to){
		$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!--<![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  
	     <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <!--[if (gte mso 9)|(IE)]>
      <style type="text/css">
         table {border-collapse: collapse !important;}
      </style>
      <![endif]-->
   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
   

   
   
   
   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
      <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
            <tr>
               <td width="100%">
                  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
                     <!--[if (gte mso 9)|(IE)]>
                     <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
                        <tr>
                           <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                              <![endif]--> 
                              <!-- ======= start main body ======= -->
                              <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
                                 <tr>
                                    <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                                       <!-- ======= start header ======= -->
                                       <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
                                          <tr>
                                             <td>
                                                <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                   <tbody>
                                                      <tr>
                                                         <td align="center">
                                                            <center>
                                                               <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
                                                                  <tbody>
                                                                     <tr>
                                                                        <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
                                                                           <!-- ======= start header ======= -->
                                                                           <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                              <tr>
                                                                                 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
                                                                                    <!--[if (gte mso 9)|(IE)]>
                                                                                    <table width="100%" style="border-spacing:0" >
                                                                                       <tr>
                                                                                          <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
                                                                                                <table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
                                                                                                   <tr>
                                                                                                      <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="http://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
                                                                                                   </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                          <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
                                                                                                <table width="100%" style="border-spacing:0" bgcolor="#ffffff">
                                                                                                   <tr>
                                                                                                      <td>
                                                                                                         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
                                                                                                            <tr>
                                                                                                               <td height="20">&nbsp;</td>
                                                                                                            </tr>
                                                                                                         </table>
                                                                                                      </td>
                                                                                                   </tr>
                                                                                                  <tr>
                            <td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
                                <tbody><tr>
                                  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="http://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                        <td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                        <td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="http://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                     <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                      </tr>
                                    </tbody></table></td>
                                </tr>
                              </tbody></table></td>
                          </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                       </tr>
                                                                                    </table>
                                                                                    <![endif]-->
                                                                                 </td>
                                                                              </tr>
                                                                              <tr >
                                                                                 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                                                    <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                                                       <tr>
                                                                                          <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                                                       </tr>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                              <tr>
                                                                              </tr>
                                                                           </table>
                                                                        </td>
                                                                     </tr>
                                                                  </tbody>
                                                               </table>
                                                            </center>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end header ======= --> 
                                       <!-- ======= start hero article ======= -->
                                       <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="" style="padding-bottom:2%; padding-top:2%;">
                                                <p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>Dear Customer,</b></p>
												<br>
                                                <p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Warm welcome from yapnna team. Thank you for choosing Yapnaa as your after sales companion</p>
                                                
                                               
												<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">You can now connect to respective brands, schedule services, monitor warranty, store bills and get reminded on warranty expiry in advance.
                                                </p>
												<br>
                                                <p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sincerely,</b></p>
                                                <p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Vineet Srivastava</b></p>
                                                <p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Founder.Yapnna</p>
                                                <!-- START BUTTON -->
                                                <!-- END BUTTON -->
                                             </td>
                                          </tr>
                                       </table>
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end hero article ======= --> 
                                       <center >
                                          <table bgcolor="#FFFFFF" width="100%">
                                             <tr>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td> &nbsp &nbsp <img src="http://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp www.yapnna.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td><img src="http://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp help@yapnna.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td><img src="http://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp +91 98452 856419</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                             </tr>
                                          </table>
                                       </center>
                                       <!-- ======= start divider ======= -->
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end divider ======= --> 

                                    </td>
                                 </tr>
                              </table>
                              <!--[if (gte mso 9)|(IE)]>
                           </td>
                        </tr>
                     </table>
                     <![endif]--> 
					 
					 
					                                        <!-- ======= start footer ======= -->
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
                                                   <tr>
                                                      <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Networks Pvt. Ltd</b></font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After Sales Companion</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                  
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end footer ======= -->
                  </div>
               </td>
            </tr>
         </table>
      </center>
   </body>
</html>

			';
			
		$headers 				= 'MIME-Version: 1.0'. "\r\n";
		$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
		$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
		$subject	=	"Warm welcome to Yapnaa";
		// Mail it
		mail($to, $subject, $message,$headers);
	}

	
	// User Login
	function user_login()
    {
		$table           				 = 	table();
		//$table 					= table();
		$table_log_in    				 = 	$table['tb1'];
		$fields_log_in   				 = 	'*';
		$user_social_id           	= 	isset($_POST['user_social_id'])?$_POST['user_social_id']:"";

		//If social media login
		if(isset($_POST["user_login_type"])> 0 && $_POST["user_login_type"] > 0){ 
			//Check if the user is already registered in yapnaa
			$condition_log_in				= 	"user_social_id = ".$user_social_id;
			
			if(isset($_POST['user_email_id']) && !empty($_POST['user_email_id'])){
				$condition_log_in			= 	"user_social_id = ".$user_social_id." or user_email_id = '".$_POST['user_email_id']."'";
				//echo $condition_log_in;die;
			}
			if(isset($_POST['user_phone']) && !empty($_POST['user_phone'])){
				$condition_log_in			= 	"user_social_id = ".$user_social_id." or user_phone = ".$_POST['user_phone'];
				//echo $condition_log_in;die;
			}
			
			//echo $condition_log_in;die;
			$arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			
			//print_r($arr_log_in);die;
		
		
				date_default_timezone_set('Asia/Kolkata');
				$user_address 				= 	$_POST['user_address'];
				$user_phone 				= 	isset($_POST['user_phone'])?$_POST['user_phone']:"";
				
				$user_name           		= 	isset($_POST['user_name'])?$_POST['user_name']:"";
				$user_social_id           	= 	isset($_POST['user_social_id'])?$_POST['user_social_id']:"";
				$user_profile_pic           = 	isset($_POST['user_profile_pic'])?$_POST['user_profile_pic']:"";
				$user_gender          		 = 	isset($_POST['user_gender'])?$_POST['user_gender']:"";
				$user_email_id          		 = 	isset($_POST['user_email_id'])?$_POST['user_email_id']:"";
				$user_city           		= 	$_POST['user_city'];
				// $user_pin		    		= 	($_POST["user_pin"]);
				//$user_pin		    		= 	md5($_POST["user_pin"]);
				$user_area_pincode			= 	$_POST["user_area_pincode"];
				$user_gcm_id      			= 	$_POST['user_gcm_id'];
				$user_login_device		= 	$_POST['user_login_device_type'];
				$app_key	      			= 	$_POST['app_key'];
				$app_secret      			= 	$_POST['app_secret'];
				$user_created_date 			= 	date('Y-m-d h:i:s');
				$user_last_login 			= 	date('Y-m-d h:i:s');
				$user_reg_verification_otp	= rand(1000,9999);
				$user_token					= rand(1000,9999999);
				
				
				
				
				$fields_reg	=	array(
									"user_login_device"	=>		$user_login_device,	
									"user_name"					=>		$user_name,	
									"user_address"				=>		$user_address,	
									"user_phone"				=>		$user_phone,	
									"user_email_id"				=>		$user_email_id,	
									"user_social_id"			=>		$user_social_id,	
									"user_profile_pic"			=>		$user_profile_pic,	
									"user_gender"				=>		$user_gender,	
									"user_city"					=>		$user_city,	
									"user_area_pincode"			=>		$user_area_pincode,	
									"user_gcm_id"				=>		$user_gcm_id,		
									"user_created_date"			=>		$user_created_date,	
									"user_last_login"			=>		$user_last_login,	
									"user_login_type"			=>		$user_login_type,	
									"user_status"				=>		1,	
									"user_token"				=>		$user_token	
				
								);
								
			if(empty($arr_log_in )){
				
				//print_r($fields_reg);die;
				$table_log_in = $table['tb1'];
				$arr_result   = $this->model->insert($table_log_in, $fields_reg);
				
				$condition_log_in				 = 	"user_id = ".$arr_result;
				$arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
				
						// print_r($arr_log_in[0]);die;	
							
						///E-Mail To User
						$return=	$this->send_welcome_email($user_email_id);
						//echo $return." - "; print_r($arr_log_in[0]);die;
				$arr =  array('user_details'=>$arr_log_in[0],'msg'=>'success');
				return $arr;
			}
			else{
				//If already exists, then update data and return the data
				if(!isset($_POST['user_name']) || empty($_POST['user_name'])){
					unset($fields_reg['user_name']);
				}
				if(!isset($_POST['user_address']) || empty($_POST['user_address'])){
					unset($fields_reg['user_address']);
				}
				if(!isset($_POST['user_email_id']) || empty($_POST['user_email_id'])){
					unset($fields_reg['user_email_id']);
				}
				if(!isset($_POST['user_phone']) || empty($_POST['user_phone'])){
					unset($fields_reg['user_phone']);
				}
				if(!isset($_POST['user_profile_pic']) || empty($_POST['user_profile_pic'])){
					unset($fields_reg['user_profile_pic']);
				}
				if(!isset($_POST['user_area_pincode']) || empty($_POST['user_area_pincode'])){
					unset($fields_reg['user_area_pincode']);
				}
				if(!isset($_POST['user_gender']) || empty($_POST['user_gender'])){
					unset($fields_reg['user_gender']);
				}
				
				$condition_log_in				= 	"user_id = ".$arr_log_in[0]["user_id"];
				$update_result      	 		= 	$this->model->update('users',$fields_reg,$condition_log_in);
				$arr_log_in      	 			= 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
				$arr =  array('user_details'=>$arr_log_in[0],'msg'=>'success');
				return $arr;
			}
		}
		else{
			$keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
			
			$user_phone			           	 = 	$_POST['user_login_mobile'];
			// $user_pin			         = 	($_POST['user_login_pin']);
			$user_pin			        	 = 	md5($_POST['user_login_pin']);
			$user_gcm			        	 =  $_POST['user_login_gcm'];
			$app_key	      				 = 	$_POST['login_app_key'];
			$app_secret      				 = 	$_POST['login_app_secret'];
			$user_login_device_type			 = 	$_POST['user_login_device_type'];
			
			$condition_log_in				 = 	"user_phone = ".$user_phone;
			$arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			//print_r($arr_log_in);exit;
			if(!empty($arr_log_in) && $arr_log_in[0]['user_reg_verification_otp']>0   ){
				//$arr_log_in['otp'] = $arr_log_in[0]['user_reg_verification_otp'];
				$arr =  array('otp'=>$arr_log_in[0]['user_reg_verification_otp'],'user_details'=>$arr_log_in,'msg'=>'OTP verification pending');
				return $arr;
				//return "verification pending";
			}
			
			$condition_log_in				 = 	'user_pin    = ' . "'" . $user_pin . "'" . ' and user_phone = ' . "'" . $user_phone . "'" . ' and user_status = 1';
			$arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			//print_r($arr_log_in);exit;
			
			if(($keys[0]==$app_key) && ($keys[1]==$app_secret)){
				$res	=	1;
			}else{
				$res	=	0;
			}
			
			
			
			if($arr_log_in){
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
				//print_r($arr_log_in);exit;
				$arr =  array('user_details'=>$arr_log_in,'msg'=>'success');
				return $arr;
			}
			else{
				return $arr_log_in="";
			}
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
                'user_reg_verification_otp' => 0,
                'user_status' => 1
            );
            $condition     = 'user_forgot_otp = ' . "'" . $forgot_otp . "'";
            $arr_log_in1    = $this->model->update($table_log_in, $set_array, $condition);
			return array("data"=>$arr_log_in,"msg"=>"success");
			
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
	
	
	function brand_product_list_by_category_dashboard($p_category_id)
    {
		$brand_p_category_id		     = 	$p_category_id;
		$table           				 = 	table();
		$table		    				 = 	$table['tb3'];
		$fields							 =  'brand_name,product_id,p_category_name,brand_id';
		$condition		 				 = 	'product_status    =1 and product_name='.$brand_p_category_id;
		$arr_log_in       				 = 	$this->model->brand_product_list_by_category($table, $fields, $condition);
		// print_r($arr_log_in ); 
		return $arr_log_in;
	}		
	 
	 
	 
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
	
	
    //get all categories product
	function get_product_cat_list(){
		$table           				 = 	table();
		$table_name	    				 = 	$table['tb5'];
		$fields_log_in   				 = 	'*';
		$condition_log_in				 = 	'p_category_status    = 1';
		$order_by						 = 	'p_category_priority';
		$arr_log_in      	 			 = 	$this->model->get_Details_condition_order_by($table_name, $fields_log_in, $condition_log_in,$order_by);	
		
		return $arr_log_in;
	}
	
	
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
	//index.php
    function brand_category_list()
    {
		$table_log_in    				 = 	'product_category_list';
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'1';
		$cat_array                       = 	$this->model->get_Details_condition($table_log_in, $fields_log_in,$condition_log_in);
		return $cat_array;
	}
	//index.php
	function n_brand_list()
    {
		$table_log_in    				 = 	'brands';
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	'1';
		$brand_array                     = 	$this->model->get_Details_condition($table_log_in, $fields_log_in,$condition_log_in);
		return $brand_array;
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
	
	
	//Check if user has added that product already
	function user_product_check()
    {
    	$file = fopen("/var/www/html/Movtest.txt","w");
		fwrite($file,json_encode($_REQUEST));
		fclose($file);
    	/*
    	echo 'hello';
    	$to= 'hema.jjbytes@gmail.com';
				$subject		=	'Registration22.';
				$message        =	'content222';
	            mail($to, $subject, $message);
    	die();
    	*/
        $table           				 = 	table();
		date_default_timezone_set('Asia/Kolkata');
        $add_product_user_token_key   	 = 	$_POST['user_token_key'];
        $add_product_user_id		   	 = 	$_POST['user_id'];
        $add_product_product_id		  	 = 	$_POST['product_id'];
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        // $condition_log_in				 = 	'user_token    = '.$add_product_user_token_key;
        $condition_log_in				 =  "user_token    =$add_product_user_token_key and user_id= $add_product_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		
		
		$device_type				     =	$arr_log_in[0]['user_login_device']; 
		$user_gcm_id				 	 =	$arr_log_in[0]['user_gcm_id']; 
		
		
		if($arr_log_in){
			
			$table_log_in    				 = 	$table['tb4'];
			$fields_log_in   				 = 	'*';
			$condition_log_in				 =  "up_product_id    =$add_product_product_id and up_user_id= $add_product_user_id";
			$arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			
			if($arr_log_in){
				return $arr_result1=2;
			}
			else{
				return $arr_result1=3;
			}
			
		}else{
			return $arr_log_in=1;
		}
    }
	
	
	//Raise an SR without adding a product
	function user_sr_product()
    {
    	$file = fopen("/var/www/html/Movtest.txt","w");
		fwrite($file,json_encode($_REQUEST));
		fclose($file);
    	
        $table           				 = 	table();
		date_default_timezone_set('Asia/Kolkata');
        $sr_user_token_key   	 = 	$_POST['sr_user_token_key'];
        $sr_user_id		   		 = 	$_POST['sr_user_id'];
        $sr_product_id		  	 = 	$_POST['sr_product_id'];
        $prod_added		  	 	= 	$_POST['sr_prod_added'];
        $sr_issue		  	 	= 	$_POST['sr_issue'];
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        // $condition_log_in				 = 	'user_token    = '.$add_product_user_token_key;
        $condition_log_in				 =  "user_token    =$sr_user_token_key and user_id= $sr_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		
		
		$device_type				     =	$arr_log_in[0]['user_login_device']; 
		$user_gcm_id				 	 =	$arr_log_in[0]['user_gcm_id']; 
		
		
		if($arr_log_in){
			if($prod_added>0){
				$table_log_in    				 = 	$table['tb4'];
				$fields_log_in   				 = 	'*';
				$condition_log_in				 =  "up_product_id    =$sr_product_id and up_user_id= $sr_user_id";
				$arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
				$sr_product_id = $arr_log_in[0]['up_product_id'];  
			}
			else{
				$fields_reg = array(
									'up_user_id' 						=> $sr_user_id,
									'up_product_id'						=> $sr_product_id,
									'up_dealer_name'					=> "",
									'up_serial_no' 						=> "",
									'up_created_date' 					=> date('Y-m-d h:i:s'),
									'up_serial_no_image'				=> ""
								);
								
				$table_log_in = $table['tb4']; 
				$new_product_id   = $this->model->insert($table_log_in, $fields_reg);
				
			}
			//raise service request
			
			$srm_c_date 					 = 	date('Y-m-d H:i:s');
			$fields_reg = array(
								'srm_user_id' 				=> $sr_user_id,  
								'srm_product_id'			=> $sr_product_id,
								'srm_user_notes'			=> $sr_issue,
								'srm_c_date' 				=> $srm_c_date,
								'srm_user_generated_date'	=> $srm_c_date,
								'srm_installation'			=> "",
								'srm_installation_date'		=> "",
							); 
			 //print_r($fields_reg);exit;
			$table_log_in = $table['tb8'];
			$sr_product_id   = $this->model->insert($table_log_in, $fields_reg);
				
			if($sr_product_id){
				return $arr_result1=3;
			}
			else{ 
				return $arr_result1=2;
			}
			
		}else{
			return $arr_log_in=1;
		}
    } 
	 
	//add product for dashboard
     function add_product($bId,$product_user_id,$brands,$dateInstallation)
    {
		//echo $product_user_id;
		
    	
        $table           				 = 	table();
		date_default_timezone_set('Asia/Kolkata');
       
        $add_product_user_serial_no   	 = 	'';
        $add_product_user_brand_id   	 = 	$bId;
        $add_product_user_id		   	 = 	$product_user_id;
        $add_product_user_dealer_name  	 = 	'';
        $add_product_product_id		  	 = 	$brands;
        $add_product_installation	  	 = 	'';
        $add_product_instal_date	  	 = 	$dateInstallation;
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        
        $condition_log_in				 =  "user_id= $add_product_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		
		
		$device_type				     =	$arr_log_in[0]['user_login_device']; 
		$user_gcm_id				 	 =	$arr_log_in[0]['user_gcm_id']; 
		
		
		if($arr_log_in){
			//echo here;die;
			
					 $fields_reg = array(
									'up_user_id' 						=> $add_product_user_id,
									'up_product_id'						=> $add_product_product_id,
									'up_dealer_name'					=> $add_product_user_dealer_name,
									'up_owner_purchase_date' 			=> $add_product_instal_date,
									'up_serial_no' 						=> $add_product_user_serial_no,
									'up_created_date' 					=> date('Y-m-d h:i:s'),
									'up_serial_no_image'				=> $add_icon
								);
								
				$table_log_in = $table['tb4'];
				$arr_result1   = $this->model->insert($table_log_in, $fields_reg);
				 $add_product_product_id = $arr_result1;
				
				//print_r($arr_result1);die;
				if($arr_result1){
					
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
			
			return $arr_result1=3;
			
			
		}else{
			return $arr_log_in=1;
		}
    }
	 
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
		
		
		if($arr_log_in){
			
			
					 $fields_reg = array(
									'up_user_id' 						=> $add_product_user_id,
									'up_product_id'						=> $add_product_product_id,
									'up_dealer_name'					=> $add_product_user_dealer_name,
									'up_serial_no' 						=> $add_product_user_serial_no,
									'up_created_date' 					=> date('Y-m-d h:i:s'),
									'up_serial_no_image'				=> $add_icon
								);
								
				$table_log_in = $table['tb4'];
				$arr_result1   = $this->model->insert($table_log_in, $fields_reg);
				$_POST['user_product_id'] = $arr_result1;
				
				//print_r($arr_result1);die;
				if($arr_result1){
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
			
			return $arr_result1=3;
			
			
		}else{
			return $arr_log_in=1;
		}
    }
	

	/*********************************************************************************************************************************/	
    function upload_digilocker_dashboard($dl_product_type_id,$dl_user_id,$dl_doc_type,$dl_product_id,$dl_doc_name){
		//echo "here";die;
        $table           				 = 	table();
		date_default_timezone_set('Asia/Kolkata');
        
        $dl_product_type_id   			 = 	$dl_product_type_id;
        $dl_user_id   					 = 	$dl_user_id;
        $dl_document				   	 = 	$this->file_upload();
        $dl_doc_type					 = 	$dl_doc_type;
        $dl_product_id				  	 = 	$dl_product_id;
        $dl_doc_name				  	 = 	$dl_doc_name;
        $dl_updated_time				 = 	 date('Y-m-d h:i:s');
       
		/* print_r($_FILES);
		echo $dl_document;
		die; */
	   
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        // $condition_log_in				 = 	'user_token    = '.$add_product_user_token_key;
        $condition_log_in				 =  "user_id= $dl_user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		
		//print_r($arr_log_in);exit;
		
		$device_type				     =	$arr_log_in[0]['user_login_device']; 
		$user_gcm_id				 	 =	$arr_log_in[0]['user_gcm_id']; 
		
		
		
		 //print_r($arr_log_in);exit;
		if($arr_log_in){//print_r($arr_log_in);exit;
			//$table_log_in    				 = 	"users_digilocker";
				
			$fields_reg = array(
								'dl_product_type_id'		=> $dl_product_type_id,
								'dl_user_id'				=> $dl_user_id,
								'dl_document'				=> $dl_document,
								'dl_doc_type' 				=> $dl_doc_type,
								'dl_product_id' 			=> $dl_product_id,
								'dl_doc_name' 			    => $dl_doc_name,
								'dl_updated_time'			=> $dl_updated_time
							);
			
			// print_r($fields_reg);exit;
            $table_log_in = "users_digilocker";
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
			if($arr_result){
				$_POST=array();
			}
			echo "<script>alert('You have added digilocker!')</script>";
			echo "<script>window.location.assign('digi-locker-product-details.php?cat=$dl_product_type_id&user=$dl_user_id')</script>";
			
			
		}else{
			return $arr_log_in=1;
		}
    }
	function upload_digilocker(){
		
        $table           				 = 	table();
		date_default_timezone_set('Asia/Kolkata');
        $dl_user_token_key   	 = 	$_POST['dl_user_token_key'];
        $dl_product_type_id   			 = 	$_POST['dl_product_type_id'];
        $dl_user_id   					 = 	$_POST['dl_user_id'];
        $dl_document				   	 = 	$this->file_upload();
        $dl_doc_type					 = 	$_POST['dl_doc_type'];
        $dl_product_id				  	 = 	$_POST['dl_product_id'];
        $dl_doc_name				  	 = 	$_POST['dl_doc_name'];
        $dl_updated_time				 = 	 date('Y-m-d h:i:s');
       
		/*print_r($_FILES);
		echo $dl_document;
		die;*/
	   
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
								'dl_doc_name' 			    => $dl_doc_name,
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
				$target = $_SERVER['DOCUMENT_ROOT']."/movilo/digilocker_images/"; 
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

	
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	function user_product_list_dashboard($user_product_list_user_id)
    {
        $table           				 = 	table();
        
        $user_product_list_user_id		 = 	$user_product_list_user_id;
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_id= $user_product_list_user_id";
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
	function user_product_list_dashboard_paticular($user_id,$up_product_id)
    {
        $table           				 = 	table();  
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_id= $user_id";
        $arr_log_in      	 			 = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		//print_r($arr_log_in );die;
		if($arr_log_in){
			$table		    				 = 	$table['tb4'];
			$fields							 =  '*';
			$condition		 				 = 	"up_user_id    =$user_id and up_user_status =1 and up_product_id=$up_product_id";
			$arr_log_in       				 = 	$this->model->user_product_list($table, $fields, $condition);
			//print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }

	
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
	function user_digilocker_list_dashboard($dl_product_type_id,$dl_user_id)
    {
        $table           				 = 	table();
        
        $digilocker_user_id				 = 	$dl_user_id;
        $dl_product_type_id		 		 = 	$dl_product_type_id;
		
		$table_log_in    				 = 	$table['tb1'];
        $fields_log_in   				 = 	'*';
        $condition_log_in				 = 	"user_id= $digilocker_user_id";
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
		//print_r($arr_log_in); exit;
		
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
			$user_name                          =$arr_log_in[0]['user_name'];
		    $user_phone                         =$arr_log_in[0]['user_phone'];
			$subject	=	"Service Requested";
			$this->send_email($user_name,$user_phone,$subject);
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
		
		if($arr_log_in){
			$table		    				 = 	$table['tb8'];
			$fields							 =  '*';
			$condition		 				 = 	'srm_user_id    ='.$user_srm__list_user_id;
			$arr_log_in       				 = 	$this->model->user_srm_list($table, $fields, $condition);
			//print_r($arr_log_in );die;
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
	function resend_otp(){
		$up_p_mobile	=	$_POST['up_p_mobile'];
		$user_reg_verification_otp	= rand(1000,9999);
		$ch = curl_init();
		$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($up_p_mobile)."&message=".urlencode("".$user_reg_verification_otp ." - Use this OTP for mobile number verification.\n.");
		curl_setopt( $ch,CURLOPT_URL, $url );
		curl_setopt( $ch,CURLOPT_POST, false ); 
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
		$result = curl_exec($ch );
		curl_close( $ch ); 
		return	$user_reg_verification_otp;
	}
	
	//Merge profile 
	function merge_user_profile()
    {
        $table           					 = 	table(); 
        $up_m_token_key				   		= 	$_POST['up_m_token_key'];
        $up_m_user_id			   		 	= 	$_POST['up_m_user_id'];
        $up_m_mobile					   	= 	$_POST['up_m_mobile']; 
		
		$table_log_in    				    = 	$table['tb1'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_token    =$up_m_token_key and user_id= $up_m_user_id";
        $arr_log_in      	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		
		if($arr_log_in ){
			$table_log_in    				    = 	$table['tb1'];
			$fields_log_in   				    = 	'*'; 
			$condition_log_in				    =  "user_phone   = $up_m_mobile and user_id != $up_m_user_id";
			$arr_log_in1  	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
			// print_r($arr_log_in);exit;
			
			
			if(!empty($arr_log_in1) && !empty($arr_log_in)){
				return true;
			}
			else{
				$table_log_in = $table['tb1'];
				$fields_reg = array("user_phone"=>$up_m_mobile);
				$condition     = 'user_id = ' . "'" . $up_m_user_id . "'";
				if($fields_reg){$arr_log_in    = $this->model->update($table_log_in, $fields_reg, $condition); }
				return true;
			}
		}
		
		else{
			return false;
		}
	}		
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	 


// Update user profile
	function update_user_profile()
    {
		//print_r($_POST);die;
        $table           					 = 	table(); 
        $up_p_token_key				   		= 	$_POST['up_p_token_key'];
        $up_p_user_id			   		 	= 	$_POST['up_p_user_id'];
        $up_p_address				   	 	= 	$_POST['up_p_address'];
        $up_p_pincode				   		= 	$_POST['up_p_pincode']; 
        $up_p_name					   		= 	$_POST['up_p_name']; 
        $up_p_mobile					   	= 	$_POST['up_p_mobile']; 
        $up_p_email					   		= 	$_POST['up_p_email']; 
		
		$table_log_in    				    = 	$table['tb1'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_token    =$up_p_token_key and user_id= $up_p_user_id";
        $arr_log_in      	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		// print_r($arr_log_in);exit;
		
		
		if($arr_log_in){ 
			
			$fields_reg = array();
			
			if(isset($up_p_address) && !empty($up_p_address)){$fields_reg['user_address']	=	$up_p_address;}
			if(isset($up_p_pincode) && !empty($up_p_pincode)){$fields_reg['user_area_pincode']	=	$up_p_pincode;}
			if(isset($up_p_name) && !empty($up_p_name)){$fields_reg['user_name']	=	$up_p_name;}
			if(isset($up_p_email) && !empty($up_p_email)){$fields_reg['user_email_id']	=	$up_p_email;}
			
			
			
			//print_r($arr_log_in  );die;
			
			if(isset($_POST['up_p_mobile'])){
				$fields_reg['user_phone'] = "";
				$user_reg_verification_otp	= rand(1000,9999);
				$ch = curl_init();
				$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($up_p_mobile)."&message=".urlencode("".$user_reg_verification_otp ." - Use this OTP for mobile number verification.\n.");
				curl_setopt( $ch,CURLOPT_URL, $url );
				curl_setopt( $ch,CURLOPT_POST, false ); 
				curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
				curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
				$result = curl_exec($ch );
				curl_close( $ch ); 
				//print_r($result  );die;
				$table_log_in = $table['tb1'];
				$condition     = 'user_id = ' . "'" . $up_p_user_id . "'";
				if($fields_reg){$arr_log_in    = $this->model->update($table_log_in, $fields_reg, $condition); }
				
				return $arr = array('otp'=>$user_reg_verification_otp,'msg'=>'success');
			}
				 
				
			// print_r($fields_reg);exit;
            $table_log_in = $table['tb1'];
            $condition     = 'user_id = ' . "'" . $up_p_user_id . "'";
			if($fields_reg){$arr_log_in    = $this->model->update($table_log_in, $fields_reg, $condition); }
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
		$user_name                          =$arr_log_in[0]['user_name'];
		$user_phone                         =$arr_log_in[0]['user_phone'];
		//print_r($arr_log_in);exit;
		
		
		if($arr_log_in){  
				 $fields_reg = array(  
								'amc_req_user_id'					=> $amc_user_id,
								'amc_req_product_id' 				=> $amc_user_p_id
							);
				
			// print_r($fields_reg);exit;  
            $table_log_in = $table['tb10'];
            $arr_result   = $this->model->insert($table_log_in, $fields_reg); 
			$subject	=	"AMC Requested";
			$this->send_email($user_name,$user_phone,$subject);
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
	/*Delete Usee Added Product Dashboard*/
	function deleteProduct($del_up_id,$del_user_id)
	{
		$table           	= 	table();
		$table_name     	=	$table['tb4']; 
		$del_up_id			=	$del_up_id;
		$del_user_id		= 	$del_user_id;
       
		
		
		$table_log_in    				    = 	$table['tb1'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_id= $del_user_id";
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
			
		//print_r($fields_reg);exit; 
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
	
	function send_email($user_name,$user_phone,$subject){
		$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!--<![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  
	     <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <!--[if (gte mso 9)|(IE)]>
      <style type="text/css">
         table {border-collapse: collapse !important;}
      </style>
      <![endif]-->
   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
   

   
   
   
   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
      <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
            <tr>
               <td width="100%">
                  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
                     <!--[if (gte mso 9)|(IE)]>
                     <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
                        <tr>
                           <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                              <![endif]--> 
                              <!-- ======= start main body ======= -->
                              <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
                                 <tr>
                                    <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                                       <!-- ======= start header ======= -->
                                       <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
                                          <tr>
                                             <td>
                                                <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                   <tbody>
                                                      <tr>
                                                         <td align="center">
                                                            <center>
                                                               <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
                                                                  <tbody>
                                                                     <tr>
                                                                        <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
                                                                           <!-- ======= start header ======= -->
                                                                           <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                              <tr>
                                                                                 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
                                                                                    <!--[if (gte mso 9)|(IE)]>
                                                                                    <table width="100%" style="border-spacing:0" >
                                                                                       <tr>
                                                                                          <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
                                                                                                <table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
                                                                                                   <tr>
                                                                                                      <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="http://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
                                                                                                   </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                          <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
                                                                                                <table width="100%" style="border-spacing:0" bgcolor="#ffffff">
                                                                                                   <tr>
                                                                                                      <td>
                                                                                                         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
                                                                                                            <tr>
                                                                                                               <td height="20">&nbsp;</td>
                                                                                                            </tr>
                                                                                                         </table>
                                                                                                      </td>
                                                                                                   </tr>
                                                                                                  <tr>
                            <td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
                                <tbody><tr>
                                  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="http://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                        <td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                        <td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="http://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                     <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                      </tr>
                                    </tbody></table></td>
                                </tr>
                              </tbody></table></td>
                          </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                       </tr>
                                                                                    </table>
                                                                                    <![endif]-->
                                                                                 </td>
                                                                              </tr>
                                                                              <tr >
                                                                                 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                                                    <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                                                       <tr>
                                                                                          <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                                                       </tr>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                              <tr>
                                                                              </tr>
                                                                           </table>
                                                                        </td>
                                                                     </tr>
                                                                  </tbody>
                                                               </table>
                                                            </center>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end header ======= --> 
                                       <!-- ======= start hero article ======= -->
                                       <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="" style="padding-bottom:2%; padding-top:2%;">
                                                <p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>User name:'.$user_name.'</b></p>
												<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>User mobile number:'.$user_phone.'</b></p>
                                                <!-- START BUTTON -->
                                                <!-- END BUTTON -->
                                             </td>
                                          </tr>
                                       </table>
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end hero article ======= --> 
                                       <center >
                                          <table bgcolor="#FFFFFF" width="100%">
                                             <tr>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td>  <img src="http://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> www.yapnaa.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td><img src="http://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> help@yapnaa.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td><img src="http://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b>  +91 98452 856419</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                             </tr>
                                          </table>
                                       </center>
                                       <!-- ======= start divider ======= -->
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end divider ======= --> 

                                    </td>
                                 </tr>
                              </table>
                              <!--[if (gte mso 9)|(IE)]>
                           </td>
                        </tr>
                     </table>
                     <![endif]--> 
					 
					 
					                                        <!-- ======= start footer ======= -->
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
                                                   <tr>
                                                      <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Networks Pvt. Ltd</b></font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After Sales Companion</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                  
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end footer ======= -->
                  </div>
               </td>
            </tr>
         </table>
      </center>
   </body>
</html>

			';
			
		$headers 				= 'MIME-Version: 1.0'. "\r\n";
		$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
		$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
		//$to                  = "ranjan.jjbyte@gmail"; 
		$to                  = "sriramm@moviloglobal.com"; 
		//echo $subject;die;
		
		// Mail it
		mail($to, $subject, $message,$headers);
	}
	
}
?>
 
