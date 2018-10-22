<?php 
$file = fopen("/var/www/html/Movtesting.txt","w");
fwrite($file,json_encode($_REQUEST));
fclose($file);
//print_r($_POST);die;
// User Registration
if(!empty($_POST['reg_submit'])){
	//echo "hello";exit;
	$arr_user_reg_info		= 	$obj_search->user_resgitartion();
	// print_r($arr_user_reg_info);exit;
	if($arr_user_reg_info){
		//$arr_user_reg_info['msg'] 	=	'Success';
		//$arr_user_reg_info_msg['otp'] 	=	$arr_user_reg_info;
		print_r(json_encode($arr_user_reg_info));
	}else{
		//print_r($user_add_product);
		//die();
		// $arr_user_reg_info['msg'] 	=	'Email-Id or contact number already registered or App key - Secret key mismatch.';
		$arr_user_reg_info['msg'] 	=	'failure';
		print_r(json_encode($arr_user_reg_info));
	}
}


/*=============================================================================================*/

// User app open
if(!empty($_POST['user_app_launch'])){
	$user_app_launch			= 	$obj_search->user_app_launch();
	// print_r($arr_user_reg_otp_verification);exit;
	if($user_app_launch){
		$arr_success_msg['msg']  = 'success';
		print_r(json_encode($arr_success_msg));
	}else{
		// $arr_success_msg['msg']  = 'Wrong OTP or App key - Secret key mismatch.';
		$arr_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_success_msg));
	}
}

if(!empty($_REQUEST['send_email'])){
	$user_app_launch			= 	$obj_search->send_welcome_email("jitesh@jjbytes.com");
}

/*=============================================================================================*/

// User registartion OTP verification
if(!empty($_POST['reg_otp'])){
	$arr_user_reg_otp_verification			= 	$obj_search->user_reg_otp_verification();
	// print_r($arr_user_reg_otp_verification);exit;
	if($arr_user_reg_otp_verification){
		print_r(json_encode($arr_user_reg_otp_verification));
	}else{
		// $arr_success_msg['msg']  = 'Wrong OTP or App key - Secret key mismatch.';
		$arr_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_success_msg));
	}
}




/*=============================================================================================*/



// Resend User registartion OTP 
if(!empty($_POST['resend_otp_phone_no'])){
	$arr_user_reg_resend_otp_phone_no			= 	$obj_search->user_reg_resend_otp_phone_no();
	// print_r($arr_user_reg_otp_verification);exit;
	if($arr_user_reg_resend_otp_phone_no){
		$arr_user_reg_resend_otp_phone_no_msg['msg'] 	=	'Success';
		$arr_user_reg_resend_otp_phone_no_msg['otp'] 	=	$arr_user_reg_resend_otp_phone_no;
		print_r(json_encode($arr_user_reg_resend_otp_phone_no_msg));
	}else{
		// $arr_success_msg['msg']  = 'Wrong OTP or App key - Secret key mismatch.';
		$arr_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_success_msg));
	}
}





/*=============================================================================================*/



// User Login
if(!empty($_POST['login_submit'])){
	$arr_user_login		= 	$obj_search->user_login();
	//print_r($arr_user_login);exit;
	if($arr_user_login){ 
		/*$data					=	array();
		$data['user_details']	=	$arr_user_login;
		$data['msg']			=	'success';*/
		print_r(json_encode($arr_user_login));
		
		// $arr_user_login[0]['msg']	=	'success';
		// print_r(json_encode($arr_user_login));
	}else{
		// $arr_success_msg['msg']  = 'Incorrect Username or Password.';
		$arr_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_success_msg));
	}
}
// Agent Login
if(!empty($_POST['admin_fcm_token'])){ 
	$arr_user_login		= 	$obj_search->agent_login();
	//print_r($arr_user_login);exit;
	if($arr_user_login){ 
		/*$data					=	array();
		$data['user_details']	=	$arr_user_login;
		$data['msg']			=	'success';*/
		print_r(json_encode($arr_user_login));
		
		// $arr_user_login[0]['msg']	=	'success';
		// print_r(json_encode($arr_user_login));
	}else{
		// $arr_success_msg['msg']  = 'Incorrect Username or Password.';
		$arr_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_success_msg));
	}
}

	



/*=============================================================================================*/



// User Forgot Password
if(!empty($_POST['forgot_password_submit'])){
	$arr_forgot_password			= 	$obj_search->forgot_password();
	// print_r($arr_forgot_password);exit;
	if($arr_forgot_password){
		$arr_user_reg_info_msg['msg'] 	=	'Success';
		$arr_user_reg_info_msg['otp'] 	=	$arr_forgot_password;
		print_r(json_encode($arr_user_reg_info_msg));
	}else{
		// $arr_success_msg['msg']  = 'You have not registered with us.';
		$arr_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_success_msg));
	}
}


/*=============================================================================================*/



// User registartion OTP verification
if(!empty($_POST['forgot_otp'])){
	$arr_user_forgot_otp_verification		= 	$obj_search->user_forgot_otp_verification();
	// print_r($arr_user_reg_otp_verification);exit;
	if($arr_user_forgot_otp_verification){
		print_r(json_encode($arr_user_forgot_otp_verification));
	}else{
		// $arr_success_msg['msg']  = 'Wrong OTP or App key - Secret key mismatch.';
		$arr_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_success_msg));
	}
}




/*=============================================================================================*/

// User change password
if(!empty($_POST['user_change_pin'])){
	$arr_user_change_password				= 	$obj_search->user_change_pin();
	// print_r($arr_user_change_password);exit;
	if($arr_user_change_password){
		$arr_success_msg['msg']  = 'Success';
		print_r(json_encode($arr_success_msg));
	}else{
		$arr_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_success_msg));
	}
}






/*=============================================================================================*/



// User logout
if(!empty($_POST['user_logout_id'])){
	$arr_user_logout				= 	$obj_search->user_logout();
	// print_r($arr_user_logout);exit;
	if($arr_user_logout){
		$arr_success_msg['msg']  = 'success';
		print_r(json_encode($arr_success_msg));
	}else{
		$arr_success_msg['msg']  = 'failure';
		print_r(json_encode($arr_success_msg));
	}
}


/*=============================Check if user has added that product=======================================*/



// User Add Product
if(!empty($_POST['user_product_check'])){
	$user_product_check				= 	$obj_search->user_product_check();
	// print_r($user_add_product);exit;
	$arr_success_msg['prod_added'] = 0;
	if($user_product_check==1){ 
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}elseif($user_product_check==2){
		$arr_success_msg['msg']  = 'success';
		$arr_success_msg['prod_added'] = 1;
		print_r(json_encode($arr_success_msg));
	}else{
		$arr_success_msg['msg']  = 'success';
		print_r(json_encode($arr_success_msg));
	}
}





/*=============================================================================================*/
/*=============================CREATE A SR WITHOUT ADDING PRODUCT================================================================*/



// User Add Product
if(!empty($_POST['user_sr_product'])){
	$user_add_product				= 	$obj_search->user_sr_product();
	// print_r($user_add_product);exit;
	if($user_add_product==1){ 
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}elseif($user_add_product==2){
		$arr_success_msg['msg']  = 'This serial number is already exist or failure';
		print_r(json_encode($arr_success_msg));
	}else{
		$arr_success_msg['msg']  = 'success';
		print_r(json_encode($arr_success_msg));
	}
}





/*=============================================================================================*/



/*=============================================================================================*/



// User Add Product
if(!empty($_POST['user_add_product'])){
	$user_add_product				= 	$obj_search->user_add_product();
	// print_r($user_add_product);exit;
	if($user_add_product==1){ 
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}elseif($user_add_product==2){
		$arr_success_msg['msg']  = 'This serial number is already exist or failure';
		print_r(json_encode($arr_success_msg));
	}else{
		$arr_success_msg['msg']  = 'success';
		$arr_success_msg['user_product_id']  = $_POST['user_product_id'];
		$arr_success_msg['product_type_id']  = $_POST['add_product_product_id'];
		print_r(json_encode($arr_success_msg));
	}
}





/*=============================================================================================*/



// User View Product List
if(!empty($_POST['user_product_list_user_id'])){
	$user_product_list				= 	$obj_search->user_product_list();
	//print_r($user_product_list);die;
	if($user_product_list){
		foreach($user_product_list as $key => $value){
			if($value['up_title'] == null){
				$user_product_list[$key]['up_title'] = "";
			}
			if($value['up_warranty_end_date'] == null){
				$user_product_list[$key]['up_warranty_end_date'] = "-";
			}
			if($value['up_guarantee_end_date'] == null){
				$user_product_list[$key]['up_guarantee_end_date'] = "-";
			}
		}
	
		$arr_user_reg_info_msg['msg'] 			=	'Success';
		$arr_user_reg_info_msg['myproductsD'] 	=	$user_product_list;
		print_r(json_encode($arr_user_reg_info_msg));
	
	}else{
		$arr_success_msg['msg']  = 'No records found';
		print_r(json_encode($arr_success_msg));
	}
}


/*=============================================================================================*/

if(!empty($_POST['digilocker'])){//print_r($_POST);die;
	$user_add_digilocker				= 	$obj_search->upload_digilocker();
	// print_r($user_add_product);exit;
	if($user_add_digilocker==1){ 
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}else{
		$arr_success_msg['msg']  = 'File added to your digilocker successfully';
		print_r(json_encode($arr_success_msg));
	}
}
	
if(!empty($_POST['digilocker_list'])){//print_r($_POST);die;
	$user_add_digilocker_list				= 	$obj_search->user_digilocker_list();
	// print_r($user_add_product);exit;
	if($user_add_digilocker==1){ 
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}else{
		$arr_success_msg['msg']  = 'success';
		$arr_success_msg['data']  = $user_add_digilocker_list;
		print_r(json_encode($arr_success_msg));
	}
}	

// User Add Product
if(!empty($_POST['user_particular_product_list_id'])){
	$user_particular_product_list				= 	$obj_search->user_particular_product_list();
	//print_r($user_product_list);die;
	if($user_particular_product_list){
		// $arr_success_msg['msg']  = 'success';
		$arr_user_reg_info_msg['msg'] 				=	'Success';
		$arr_user_reg_info_msg['my_particular_p'] 	=	$user_particular_product_list;
		print_r(json_encode($arr_user_reg_info_msg)); 
		// print_r(json_encode($user_particular_product_list));
	}else{
		$arr_success_msg['msg']  = 'No records found';
		print_r(json_encode($arr_success_msg));
	}
}




/*=============================================================================================*/



// SRM Question list
if(!empty($_POST['user_srm_user_token_key'])){
	$user_srm_question_list				= 	$obj_search->user_srm_question_list();
	// print_r($user_srm_question_list);exit;
	if($user_srm_question_list==1){
		$arr_success_msg['msg']  = 'No records found';
		print_r(json_encode($arr_success_msg)); 
	}elseif($user_srm_question_list==2){
		$arr_success_msg['msg']  = 'Token key expired';
		print_r(json_encode($arr_success_msg));
	}else{
		$data = array();
		$data["srq"] = $user_srm_question_list;
		$data['msg']  = 'success';
		//$user_srm_question_list['msg']  = 'success';
		//print_r(json_encode($user_srm_question_list));
		print_r(json_encode($data));
		
	}
}

/*=============================================================================================*/



// SRM Question list
if(!empty($_POST['user_srm_ans_user_token_key'])){
	$user_srm_question_answers				= 	$obj_search->user_srm_question_answers();
	// print_r($user_srm_question_answers);exit;
	if($user_srm_question_answers){
		$arr_success_msg['msg']  = 'success';
		print_r(json_encode($arr_success_msg));
	}else{
		// $arr_success_msg['msg']  = 'No records found';
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}
}



/*=============================================================================================*/



// User SRM List 
if(!empty($_POST['user_srm_list_user_token_key'])){//echo "HEre";die;
	$user_srm_list				= 	$obj_search->user_srm_list();
	//print_r($user_srm_list);die;
	// print_r($user_srm_question_answers);exit;
	
	if($user_srm_list==1){
		$arr_success_msg['msg']  = 'No records found';
		print_r(json_encode($arr_success_msg)); 
	}elseif($user_srm_list==2){
		$arr_success_msg['msg']  = 'Token key expired';
		print_r(json_encode($arr_success_msg));
	}else{
		$data					=	array();
		$data['user_details']	=	$user_srm_list;
		$data['msg']			=	'success';
		print_r(json_encode($data));
		
	}
	
	
	// if($user_srm_list){ 
		// $data					=	array();
		// $data['user_details']	=	$user_srm_list;
		// $data['msg']			=	'success';
		// print_r(json_encode($data));
	// }else{
		// $arr_success_msg['msg']  = 'No records found';
		// print_r(json_encode($arr_success_msg));
	// }
}






/*=============================================================================================*/



/// User Particular SRM Details   
if(!empty($_POST['srm_details_user_token_key'])){
	$srm__details_user_token_key				= 	$obj_search->srm_details_particular_product();
	// print_r($brand_list);exit;
	if($srm__details_user_token_key){ 
		$data					=	array();
		$data['user_details']	=	$srm__details_user_token_key;
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'No records found';
		print_r(json_encode($arr_success_msg));
	}
}



/*=============================================================================================*/



// Brand List 
if(!empty($_POST['brand_user_token_key'])){
	$brand_list				= 	$obj_search->brand_list();
	// print_r($brand_list);exit;
	if($brand_list){ 
		$data					=	array();
		$data['user_details']	=	$brand_list;
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'No records found';
		print_r(json_encode($arr_success_msg));
	}
}






/*=============================================================================================*/



// Product List depends on Brand  
if(!empty($_POST['product_user_token_key'])){
	$brand_list				= 	$obj_search->product_list_depends_brand();
	// print_r($brand_list);exit;
	if($brand_list){ 
		$data					=	array();
		$data['user_details']	=	$brand_list;
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'No records found';
		print_r(json_encode($arr_success_msg));
	}
}



/*=============================================================================================*/



// Complete SRM Ticket request  
if(!empty($_POST['srm_complete_token_key'])){
	$srm_ticket_complete				= 	$obj_search->srm_ticket_complete();
	// print_r($brand_list);exit;
	if($srm_ticket_complete){ 
		$data					=	array(); 
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'No records found';
		print_r(json_encode($arr_success_msg));
	}
}




/*=============================================================================================*/



//Edit Product   
if(!empty($_POST['user_p_token_key'])){
	$update_user_product				= 	$obj_search->update_user_product();
	// print_r($update_user_product);exit;
	if($update_user_product){ 
		$data					=	array(); 
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}
}



/*=============================================================================================*/



//Edit user profile   
if(!empty($_POST['resend_otp'])){
	$update_user_profile				= 	$obj_search->resend_otp();
	// print_r($update_user_product);exit;
	if($update_user_profile){ 
		$data					=	array(); 
		$data['msg']			=	'success';
		$data['otp']			=	$update_user_profile;
		print_r(json_encode($data));
	}
	else{
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}
}



/*=============================================================================================*/



//Edit user profile   
if(!empty($_POST['up_p_token_key'])){
	$update_user_profile				= 	$obj_search->update_user_profile();
	//print_r($update_user_profile);exit;
	if($update_user_profile && !isset($update_user_profile['otp'])){ 
		$data					=	array(); 
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}
	if($update_user_profile && isset($update_user_profile['otp'])){ 
		$data					=	$update_user_profile;
		//$data['msg']			=	'success';
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}
}


/*=============================================================================================*/



//User profile   merge
if(!empty($_POST['up_m_token_key'])){
	$update_user_profile				= 	$obj_search->merge_user_profile();
	// print_r($update_user_product);exit;
	if($update_user_profile ){ 
		$data					=	array(); 
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}
	else{
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}
}



/*=============================================================================================*/



//Feedback
if(!empty($_POST['fb_token_key'])){
	$user_feedback				= 	$obj_search->user_feedback();
	// print_r($update_user_product);exit;
	if($user_feedback){ 
		$data					=	array(); 
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'No records found';
		print_r(json_encode($arr_success_msg));
	}
}




/*=============================================================================================*/

// User AMC Request
if(!empty($_POST['amc_token_key'])){
	$user_amc_request				= 	$obj_search->user_amc_request();
	// print_r($update_user_product);exit;
	if($user_amc_request){ 
		$data					=	array(); 
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}
}




/*=============================================================================================*/



// Cancel SRM Ticket request  
if(!empty($_POST['srm_cancel_token_key'])){
// echo $_POST['srm_cancel_token_key'];exit;
	$srm_ticket_cancel				= 	$obj_search->srm_ticket_cancel();
	// print_r($brand_list);exit;
	if($srm_ticket_cancel){ 
		$data					=	array(); 
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}
}




/*=============================================================================================*/



// Product Histroy  
if(!empty($_POST['history_u_token_key'])){ 
	$product_history				= 	$obj_search->user_product_history();
	// print_r($product_history);exit;
	if($product_history){ 
		$data						=	array(); 
		$data['msg']				=	'success';
		$data['hsitory_details']	=	$product_history;
		print_r(json_encode($product_history));
	}else{
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}
}




/*=============================================================================================*/



//Edit user profile   
if(!empty($_POST['gcm_user_id'])){
	$update_user_gcm				= 	$obj_search->update_user_gcm();
	// print_r($update_user_product);exit;
	if($update_user_gcm){ 
		$data					=	array(); 
		$data['msg']			=	'success';
		print_r(json_encode($data));
	} 
}

/* BY Suman */	

//API for Delete Digilocker-Id
if(!empty($_POST['delete_digilocker_file'])){
	$user_add_digilocker		= 	$obj_search->delete_digilocker_file();
	if($user_add_digilocker==0){ 
		$arr_success_msg['msg'] = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}else{
		$arr_success_msg['msg'] = 'File Deleted successfully';
		print_r(json_encode($arr_success_msg));
	}
}


?>