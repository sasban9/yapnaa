<?php
$file = fopen("/var/www/html/checkout.txt","w");
fwrite($file,json_encode($_REQUEST));
fclose($file);
/*=============================================================================================*/

//echo 'dddd';

//echo 'hi';
//$arr_check_user_login		= 	$user_controller->checkout_user_login();
//print_r($arr_check_user_login);
// Checkout user Login

if($_POST['check_user_submit']){
	//echo 'hello';
	$arr_check_user_login		= 	$user_controller->checkout_user_login();
	// print_r($arr_user_login);exit;
	if($arr_check_user_login){ 
		$data					=	array();
		$data['cu_details']	=	$arr_check_user_login;
		$data['msg']			=	'success';
		print_r(json_encode($data));
		
		// $arr_user_login[0]['msg']	=	'success';
		// print_r(json_encode($arr_user_login));
	}else{
		// $arr_success_msg['msg']  = 'Incorrect Username or Password.';
		$arr_check_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_check_success_msg));
	}
}





// order list before checkout
if($_POST['checkout_order_list']){
	//echo 'ddddist';
	//die();
	//$get_user_order_details		= 	$common_controller->get_cu_order_details_app();  
	$get_user_order_details		= 	$common_controller->get_cuser_order_history_app();  
	
	// print_r($get_user_order_details);exit;
	if($get_user_order_details=='session expired'){
			$add_to_cart_dish1['msg']  = 'session expired';
			print_r(json_encode($add_to_cart_dish1)); 
		}elseif(empty($get_user_order_details)){
			$add_to_cart_dish1['msg']  = 'No records found';
			print_r(json_encode($add_to_cart_dish1));  
		}else{
			$data						=	array(); 
			$data['msg']				=	'success';
			$data['order_list']			=	$get_user_order_details;
			print_r(json_encode($data));
		}
}

if($_POST['checkout_order_details']){
	//echo 'ddddist';
	//die();
	//$get_user_order_details		= 	$common_controller->get_cu_order_details_app();  
	$get_user_order_details		= 	$common_controller->get_cuser_order_details_app();  
	
	// print_r($get_user_order_details);exit;
	if($get_user_order_details=='session expired'){
			$add_to_cart_dish1['msg']  = 'session expired';
			print_r(json_encode($add_to_cart_dish1)); 
		}elseif(empty($get_user_order_details)){
			$add_to_cart_dish1['msg']  = 'No records found';
			print_r(json_encode($add_to_cart_dish1));  
		}else{
			$data						=	array(); 
			$data['msg']				=	'success';
			$data['order_list']			=	$get_user_order_details;
			print_r(json_encode($data));
		}
}


if($_POST['checkout_user_update_status']){
	
	$get_cu_update_status	= 	$common_controller->get_cu_update_status_app();  
	// print_r($get_cu_update_status);exit;
	if($get_cu_update_status=='session expired'){
			$add_to_update_status['msg']  = 'session expired';
			print_r(json_encode($add_to_update_status)); 
		  
		}else if($get_cu_update_status='success'){
			$data									=	array(); 
			$data['msg']							=	'successfully updated';
			//$data['order_update']			=	$get_cu_update_status;
			print_r(json_encode($data));
		}
		/*
		elseif(empty($get_cu_update_status)){
			$add_to_update_status['msg']  = 'No records found';
			print_r(json_encode($add_to_update_status));
		}
		*/
}

//*/
/*=============================================================================================*/



?>