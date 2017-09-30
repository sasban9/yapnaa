<?php 

//Banner FOr Home screen
if(!empty($_POST['banner_for'])){ 

	$get_banner_images		= 	$obj_search->get_banner_home_screen_images(); 
	
	if($get_banner_images){
		$data					=	array();
		$data['banner_imgs']	=	$get_banner_images;
		$data['msg']			=	'success';
		print_r(json_encode($data));
		
		
		// $get_banner_images['msg'] 	=	'Success'; 
		// print_r(json_encode($get_banner_images));
	}else{
		// $arr_user_reg_info['msg'] 	=	'Email-Id or contact number already registered or App key - Secret key mismatch.';
		$get_banner_images['msg'] 	=	'failure';
		print_r(json_encode($get_banner_images));
	}
	 
}





//Banner FOr AMC screen
if(!empty($_POST['banner_for_amc'])){ 

	$get_banner_images				= 	$obj_search->get_banner_amc_screen_images(); 
	
	if($get_banner_images){
		$data					=	array();
		$data['banner_imgs']	=	$get_banner_images;
		$data['msg']			=	'success';
		print_r(json_encode($data));
		
		
		// $get_banner_images['msg'] 	=	'Success'; 
		// print_r(json_encode($get_banner_images));
	}else{
		// $arr_user_reg_info['msg'] 	=	'Email-Id or contact number already registered or App key - Secret key mismatch.';
		$get_banner_images['msg'] 	=	'failure';
		print_r(json_encode($get_banner_images));
	}
	 
}






//feching  barnd_list
if(!empty($_POST['brand_user_token_key'])){
	$arr_barnd_list	=	$obj_search->barnd_list();
	if($arr_barnd_list){
		print_r(json_encode($arr_barnd_list));
	}else{
		$arr_user_reg_info['msg'] 	=	'No records found';
		print_r(json_encode($arr_user_reg_info));
	}
}




//Category List 
if(!empty($_POST['category_user_token_key'])){
	$category_list	=	$obj_search->category_list();
	// print_r(json_encode($category_list));exit;
	if($category_list==1){
		$arr_user_reg_info_msg['msg'] 	=	'No records found';
		print_r(json_encode($arr_user_reg_info_msg));
		// print_r(json_encode($category_list));
	}elseif($category_list==2){
		$arr_user_reg_info_msg['msg'] 	=	'Token key expired';
		print_r(json_encode($arr_user_reg_info_msg));
	}else{ 
		$arr_user_reg_info_msg['msg'] 	=	'Success';
		$arr_user_reg_info_msg['details'] 	=	$category_list;
		print_r(json_encode($arr_user_reg_info_msg)); 
	}
}



//Products List  
if(!empty($_POST['brand_product_user_token_key'])){
	$brand_product_list	=	$obj_search->brand_product_list();
	if($brand_product_list){
		print_r(json_encode($brand_product_list));
	}else{
		$arr_user_reg_info['msg'] 	=	'No records found';
		print_r(json_encode($arr_user_reg_info));
	}
}





//Products List  
if(!empty($_POST['brand_p_user_token_key'])){
	$brand_product_list_by_category	=	$obj_search->brand_product_list_by_category();
	// print_r($brand_product_list_by_category );
	if($brand_product_list_by_category){
		print_r(json_encode($brand_product_list_by_category));
	}else{
		$arr_user_reg_info['msg'] 	=	'No records found';
		print_r(json_encode($arr_user_reg_info));
	}
}





//Products List  
if(!empty($_POST['brand_p_list_t_key'])){
	$brand_p_list_by_brand_id	=	$obj_search->brand_p_list_by_brand_id();
	// print_r($brand_p_list_by_brand_id );
	if($brand_p_list_by_brand_id==2){ 
		$arr_user_reg_info['msg'] 	=	'Token key expired';
		print_r(json_encode($arr_user_reg_info));
	}elseif($brand_p_list_by_brand_id==1){
		$arr_user_reg_info['msg'] 	=	'No records found';
		print_r(json_encode($arr_user_reg_info)); 
	}elseif($brand_p_list_by_brand_id){ 
		$data						=	array();
		$data['product_details']	=	$brand_p_list_by_brand_id;
		$data['msg']				=	'success';
		print_r(json_encode($data)); 
	}
}






//Particular Products 
if(!empty($_POST['p_id'])){
	$particluar_product = $obj_search->particluar_product();
	print_r(json_encode($particluar_product));
}




//Particular Products  Gender
if(!empty($_POST['gednder'])){
	$particluar_product_gender = $obj_search->particluar_product_gender();
	print_r(json_encode($particluar_product_gender));
}




//Particular Products Type
if(!empty($_POST['type'])){
	$particluar_product_type = $obj_search->particluar_product_type();
	print_r(json_encode($particluar_product_type));
}




//Get Store Details
if(!empty($_POST['store'])){
	$store			=	$_POST['store'];
	$arr_store_details	=	$obj_search->store_details();
	print_r(json_encode($arr_store_details));
}




//Delete User Product
if(!empty($_POST['del_up_id'])){
	$delete_user_product	=	$obj_search->delete_user_product();
	// print_r($brand_p_list_by_brand_id );
	if($delete_user_product){ 
		$data						=	array(); 
		$data['msg']				=	'success';
		print_r(json_encode($data)); 
	}else {
		$arr_user_reg_info['msg'] 	=	'Token key expired';
		print_r(json_encode($arr_user_reg_info));
	} 
}





//amc_price_list
if(!empty($_POST['amc_price_list'])){
	$amc_price_list	=	$obj_search->amc_price_list();
	// print_r($amc_price_list);
	if($amc_price_list==1) {
		$arr_user_reg_info['msg'] 	=	'Token key expired';
		print_r(json_encode($arr_user_reg_info));
	}elseif($amc_price_list==2) {
		$arr_user_reg_info['msg'] 	=	'No records found';
		print_r(json_encode($arr_user_reg_info));
	} else { 
		$data								=	array(); 
		$data['msg']						=	'success';
		$data['amc_price_details']			=	$amc_price_list;
		print_r(json_encode($data)); 
	}
}




//APK Versoin Check
if(!empty($_POST['apk_version'])){
	$apk_version_check	=	$obj_search->apk_version_check();
	//print_r($apk_version_check);
	if($apk_version_check){ 
		$data								=	array(); 
		$data['msg']						=	'success'; 
		print_r(json_encode($data)); 
	}else {
		$arr_user_reg_info['msg'] 	=	'Older version';
		print_r(json_encode($arr_user_reg_info));
	} 
}



?>