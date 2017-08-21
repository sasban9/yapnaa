<?php 
 $file = fopen("/var/www/html/user.txt","w");
fwrite($file,json_encode($_REQUEST));
fclose($file);
//APK version Check
if(!empty($_POST['apk_check'])){  
	$apk_version_check				= 	$user_controller->apk_version_check();  
	// print_r($apk_version_check[0]['app_version_no']);exit;
	if($apk_version_check){  
		$data['msg']						=	'success'; 
		$data['version_details']			=	$apk_version_check[0]['app_version_no']; 
		print_r(json_encode($data)); 
	} else{
		$data['msg']						=	'no_version_found';  
		print_r(json_encode($data)); 
	}
}

 
 /*=============================================================================================*/
 
 
 
// User Registration
if(!empty($_POST['reg_mobile'])){ 
	$arr_user_reg_info		= 	$user_controller->user_resgitartion();
	// print_r($arr_user_reg_info);exit;
	if($arr_user_reg_info!='blocked'){
		$arr_user_reg_info_msg['msg'] 			=	'success';
		$arr_user_reg_info_msg['user_details'] 	=	$arr_user_reg_info;
		print_r(json_encode($arr_user_reg_info_msg));
	}elseif($arr_user_reg_info=='blocked'){
		$arr_user_reg_info_msg['msg'] 		=	'success';
		$arr_user_reg_info_msg['msg'] 	=	$arr_user_reg_info;
		print_r(json_encode($arr_user_reg_info_msg));
	}else{
		// $arr_user_reg_info['msg'] 	=	'Email-Id or contact number already registered or App key - Secret key mismatch.';
		$arr_user_reg_info['msg'] 	=	'failure';
		print_r(json_encode($arr_user_reg_info));
	}
}
 
 /*=============================================================================================*/
 
 
// User logout
if(!empty($_POST['user_logout_id'])){
	$arr_user_logout				= 	$user_controller->user_logout();
	// print_r($arr_user_logout);exit;
	if($arr_user_logout){
		$arr_success_msg['msg']  = 'success';
		print_r(json_encode($arr_success_msg));
	}else{
		$arr_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_success_msg));
	}
}



 
/*=============================================================================================*/



// User GCM ID Update
if(!empty($_POST['gcm_user_id'])){
	$user_gcm_id_update				= 	$user_controller->user_gcm_id_update();
	// print_r($arr_user_logout);exit;
	if($user_gcm_id_update){
		$arr_success_msg['msg']  = 'success';
		print_r(json_encode($arr_success_msg));
	}else{
		$user_gcm_id_update['msg']  = 'session expired';
		print_r(json_encode($user_gcm_id_update));
	}
}
 
/*=============================================================================================*/



// User Profile Pic Update
if(!empty($_POST['pic_user_id'])){
	$user_profile_pic_update				= 	$user_controller->user_profile_pic_update();
	// print_r($arr_user_logout);exit;
	if($user_profile_pic_update){
		$arr_success_msg['msg']  = 'success';
		print_r(json_encode($arr_success_msg));
	}else{
		$user_gcm_id_update['msg']  = 'failure';
		print_r(json_encode($user_gcm_id_update));
	}
}


/*=============================================================================================*/

// User Profile   Update
if(!empty($_POST['up_user_id'])){
	$user_profile_pic_update				= 	$user_controller->user_profile_update();
	// print_r($arr_user_logout);exit;
	if($user_profile_pic_update){
		$arr_success_msg['msg']			  = 'success';
		$arr_success_msg['user_details']  = $user_profile_pic_update;
		print_r(json_encode($arr_success_msg));
	}else{
		$user_gcm_id_update['msg']  = 'session expired';
		print_r(json_encode($user_gcm_id_update));
	}
}




?>