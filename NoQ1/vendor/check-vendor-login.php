<?php
session_start();
require_once("../config/tab_config.php");
require_once("../config/config.php");
require_once("../model/model.php"); 
$obj_model	=	new model();
require_once('../controller/vendor_controller.php'); 
$vendor_controller	=	new vendor_controller();

 // Store Login
if(isset($_POST['vendor_mobile_no'])){  
	$vendor_login = $vendor_controller->vendor_login();
	// print_r($vendor_login['message']);exit; 
	if($vendor_login['message']=="Invalid"){
		print_r(json_encode($vendor_login));
	}elseif($vendor_login['message']=="Not verifed"){
		print_r(json_encode($vendor_login));
	}else{  
		$_SESSION['b_store_id']	=	$vendor_login['b_store_id'];
		print_r(json_encode($vendor_login));
	} 
}



  
 //Vendor verification OTP check in Login
if(isset($_POST['OTP'])){   
	$vendor_otp_check = $vendor_controller->vendor_otp_check();
	// print_r(json_encode($vendor_otp_check));die;
	if($vendor_otp_check=="Invalid"){
		print_r(json_encode($vendor_otp_check));
	} else{ 
		$_SESSION['b_store_id']	=	$vendor_otp_check['b_store_id'];
		print_r(json_encode($vendor_otp_check));
	} 
}



 
 //Forgot Password sending OTP
 
if(isset($_POST['forgot_vendor_mobile_no'])){  
// echo $_POST['forgot_vendor_mobile_no'];exit;
	$vendor_forgot_password = $vendor_controller->vendor_forgot_password();
	// print_r($vendor_login['message']);exit; 
	if($vendor_forgot_password['message']=="Invalid"){
		print_r(json_encode($vendor_forgot_password));
	}else{  
		print_r(json_encode($vendor_forgot_password));
	} 
}



  
 //Forgot Password OTP check
if(isset($_POST['forgot_OTP'])){   
	$vendor_forgot_OTP_check = $vendor_controller->vendor_forgot_OTP_check();
	// print_r(json_encode($vendor_forgot_OTP_check));die;
	if($vendor_forgot_OTP_check=="Invalid"){
		print_r(json_encode($vendor_forgot_OTP_check));
	} else{  
		print_r(json_encode($vendor_forgot_OTP_check));
	} 
}

 
 //Forgot Password reset
if(isset($_POST['reset_password'])){   
	$vendor_reset_password = $vendor_controller->vendor_reset_password();
	// print_r(json_encode($vendor_forgot_OTP_check));die;
	if($vendor_reset_password=="Invalid"){
		print_r(json_encode($vendor_reset_password));
	} else{  
		print_r(json_encode($vendor_reset_password));
	} 
}



  
 //Store registartion
if(isset($_POST['reg_b_store_mobile_no'])){   
	$business_store_registration = $vendor_controller->business_store_registration();
	// print_r(json_encode($business_store_registration));die;
	if($business_store_registration=="Already registered"){
		print_r(json_encode($business_store_registration));
	} else{  
		print_r(json_encode($business_store_registration));
	} 
}
?>