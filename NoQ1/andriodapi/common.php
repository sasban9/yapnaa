<?php   
$file = fopen("/var/www/html/test.txt","w");
fwrite($file,json_encode($_REQUEST));
fclose($file);


// business category list home apge
if(!empty($_POST['bs_user_id'])){
	$business_category_list					= 	$common_controller->business_category_list();  
	// print_r($business_category_list);exit;
	if($business_category_list=='session expired'){
		$add_to_cart_dish1['msg']  = 'session expired';
		print_r(json_encode($add_to_cart_dish1)); 
	}else{
		$data									=	array(); 
		$data['msg']							=	'success';
		$data['business_category_list']			=	$business_category_list;
		print_r(json_encode($data));
	}
}

/*=============================================================================================*/


//print_r($_POST);die;
//Edit user profile   
if(!empty($_POST['get_p_token'])){
	$update_user_profile				= 	$common_controller->get_user_profile();
	// print_r($update_user_product);exit;
	if($update_user_profile){ 
		$data						=	array(); 
		$data['profile_details']	=	$update_user_profile[0]; 
		$data['msg']				=	'success';
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}
}



/*=============================================================================================*/


/*=============================================================================================*/



//Edit user profile   
if(!empty($_POST['up_p_token_key'])){
	$update_user_profile				= 	$common_controller->update_user_profile();
	// print_r($update_user_product);exit;
	if($update_user_profile){ 
		$data					=	array(); 
		$data['msg']			=	'success';
		$data['profile_details']=	$update_user_profile;
		print_r(json_encode($data));
	}else{
		$arr_success_msg['msg']  = 'Token key expire';
		print_r(json_encode($arr_success_msg));
	}
}



/*=============================================================================================*/

/*=============================================================================================*/

  
// Get Tickets list
if(!empty($_POST['tc_user_id'])){
	$get_store_tickets_details					= 	$common_controller->get_store_tickets_details();  
	// print_r($get_store_tickets_details);exit;
	if($get_store_tickets_details=='session expired'){
		$add_to_cart_dish1['msg']  = 'session expired';
		print_r(json_encode($add_to_cart_dish1)); 
	}else{
		$data									=	array(); 
		$data['msg']							=	'success';
		$data['ticket_details']					=	$get_store_tickets_details;
		print_r(json_encode($data));
	}
}


/*=============================================================================================*/

  
// Get Single Tickets 
if(!empty($_POST['stc_ticket_id'])){
	//echo "data:";die;
	$get_store_tickets_details					= 	$common_controller->get_single_tickets_details();  
	//echo "data:";print_r($get_store_tickets_details);die;
	if($get_store_tickets_details=='session expired'){
		$add_to_cart_dish1['msg']  = 'session expired';
		print_r(json_encode($add_to_cart_dish1)); 
	}
	else if($get_store_tickets_details=='No records found'){
		$add_to_cart_dish1['msg']  = 'No records found';
		print_r(json_encode($add_to_cart_dish1)); 
	}
	else{
		$data									=	array(); 
		$data['msg']							=	'success';
		$data['ticket_details']					=	$get_store_tickets_details;
		print_r(json_encode($data));
	}
}
 

/*=============================================================================================*/

  
// Get Store Tickets Details
if(!empty($_POST['tax_user_id'])){
	$get_store_service_tax_details					= 	$common_controller->get_store_service_tax_details();  
	// print_r($get_store_tickets_details);exit;
	if($get_store_service_tax_details=='session expired'){
		$add_to_cart_dish1['msg']  = 'session expired';
		print_r(json_encode($add_to_cart_dish1)); 
	}else{
		$data									=	array(); 
		$data['msg']							=	'success';
		$data['service_tax']					=	$get_store_service_tax_details;
		print_r(json_encode($data));
	}
}









/*=============================================================================================*/


// orders to tickets cart
if(!empty($_POST['atc_tic_user_id'])){ 
	$ordering_ticket					= 	$common_controller->ordering_ticket();  
	// print_r($ordering_ticket);exit;
	if($ordering_ticket==false){
		$data					=	array(); 
		$data['msg']			=	'something went wrong';
		print_r(json_encode($data));
	}elseif($ordering_ticket=='session expired'){
		
		$data					=	array(); 
		$data['msg']			=	'session expired';
		print_r(json_encode($data));
	}elseif($ordering_ticket){
		
		$data					=	array(); 
		$data['msg']			=	'success';
		$data['order_id']			=	$ordering_ticket;
		print_r(json_encode($data)); 
	}
}





/*=============================================================================================*/


// Get my tickets orders
if(!empty($_POST['mytic_user_id'])){ 
	$get_mytickets_orders					= 	$common_controller->get_mytickets_orders();  
	// print_r($get_mytickets_orders);exit;
	if($get_mytickets_orders=='no records found'){
		$data					=	array(); 
		$data['msg']			=	'something went wrong';
		print_r(json_encode($data));
	}elseif($get_mytickets_orders=='session expired'){
		$data					=	array(); 
		$data['msg']			=	'session expired';
		print_r(json_encode($data));
	}else{
		$data								=	array(); 
		$data['msg']						=	'success';
		$data['my_ticket_orders']			=	$get_mytickets_orders;
		print_r(json_encode($data)); 
	}
}






/*=============================================================================================*/


 

// Add to cart
if(!empty($_POST['add_to_cart'])){
	$add_to_cart_dish					= 	$common_controller->add_to_cart_dish();  
	//print_r($add_to_cart_dish);exit;
	if($add_to_cart_dish=='No item found'){
		$add_to_cart_dish1['msg']  = 'No item found';
		print_r(json_encode($add_to_cart_dish1)); 
	}elseif($add_to_cart_dish=='session expired'){
		$add_to_cart_dish1['msg']  = 'session expired';
		print_r(json_encode($add_to_cart_dish1));  
	}else{
		$data					=	array(); 
		$data['msg']			=	'success';
		$data['cart_details']	=	$add_to_cart_dish;
		$file = fopen("/var/www/html/4.txt","w");
				fwrite($file,json_encode($data));
				fclose($file);
		echo json_encode($data);exit;
	}
	exit;
}




/*=============================================================================================*/

// User Added cart details
if(!empty($_POST['user_cart_details'])){ 
	$user_cart_details					= 	$common_controller->user_cart_details();
	if($user_cart_details){
		$data					=	array(); 
		$data['msg']			=	'success';
		$data['cart_details']	=	$user_cart_details;
		print_r(json_encode($data));
	}else{
		$data					=	array(); 
		$data['msg']			=	'cart is empty'; 
		print_r(json_encode($data));
	}
		
} 

/*=============================================================================================*/



//Updating items from the cart
if(!empty($_POST['up_atc_u_id'])){
	
	$file = fopen("/var/www/html/updatecart.txt","w");
	fwrite($file,json_encode($_REQUEST));
	fclose($file);
	$update_user_cart_dish					= 	$common_controller->update_user_cart_items();  
	// print_r($update_user_cart_dish);exit;
	if(!$update_user_cart_dish){
		$add_to_cart_dish1['msg']  = "fails";
		print_r(json_encode($add_to_cart_dish1)); 
	}else{
		$data					=	array(); 
		$data['msg']			=	'success';
		$data['cart_id']		=	$update_user_cart_dish;
		print_r(json_encode($data));
	}
}


/*=============================================================================================*/

/*=============================================================================================*/



//Deleteing items from the cart
if(!empty($_POST['del_atc_u_id'])){
	$delete_user_cart_dish					= 	$common_controller->delete_user_cart_items();  
	// print_r($update_user_cart_dish);exit;
	if(!$delete_user_cart_dish){
		$add_to_cart_dish1['msg']  = "fails";
		print_r(json_encode($add_to_cart_dish1)); 
	}else{
		$data					=	array(); 
		$data['msg']			=	'success';
		$data['cart_id']		=	$delete_user_cart_dish;
		print_r(json_encode($data));
	}
}


/*=============================================================================================*/



//Deleteing whole cart
if(!empty($_POST['del_cart_u_id'])){
	$delete_user_cart_dish					= 	$common_controller->delete_user_cart_empty();  
	// print_r($update_user_cart_dish);exit;
	if($delete_user_cart_dish!=1){
		$add_to_cart_dish1['msg']  = "fails";
		print_r(json_encode($add_to_cart_dish1)); 
	}else{
		$data					=	array(); 
		$data['msg']			=	'success';
		print_r(json_encode($data));
	}
}

 
 /*=============================================================================================*/



//get store details by qrcode 
if(!empty($_POST['qr_u_id'])){
	$business_category_list_on_qr_code					= 	$common_controller->business_category_list_on_qr_code();  
	// print_r($business_category_list_on_qr_code);exit;
	if($business_category_list_on_qr_code=='session expired'){
		$add_to_cart_dish1['msg']  = 'session expired';
		print_r(json_encode($add_to_cart_dish1)); 
	}elseif($business_category_list_on_qr_code=='no records found'){
		$add_to_cart_dish1['msg']  = 'no records found';
		print_r(json_encode($add_to_cart_dish1));  
	}else{
		$data									=	array(); 
		$data['msg']							=	'success';
		$data['business_store_details']			=	$business_category_list_on_qr_code[0];
		print_r(json_encode($data));
	}
}

 
 
 
 
 
 /*=============================================================================================*/


 
 //get store list by category id 
if(!empty($_POST['sc_u_id'])){ 
	
	$business_category_list_by_category_id					= 	$common_controller->business_category_list_by_category_id();  
	// print_r($business_category_list_by_category_id);exit;
	if($business_category_list_by_category_id=='session expired'){
		$add_to_cart_dish1['msg']  = 'session expired';
		print_r(json_encode($add_to_cart_dish1)); 
	}elseif($business_category_list_by_category_id=='no records found'){
		$add_to_cart_dish1['msg']  = 'no records found';
		print_r(json_encode($add_to_cart_dish1));  
	}else{
		$data									=	array(); 
		$data['msg']							=	'success';
		$data['business_store_details']			=	$business_category_list_by_category_id;
		print_r(json_encode($data));
	}
}


 
 /*=============================================================================================*/


 

// business store Search
if(!empty($_POST['search_user_id'])){
	$business_store_search_by_name					= 	$common_controller->business_store_search_by_name();  
	// print_r($business_category_list);exit;
	if($business_store_search_by_name=='session expired'){
		$add_to_cart_dish1['msg']  = 'session expired';
		print_r(json_encode($add_to_cart_dish1)); 
	}else{
		$data									=	array(); 
		$data['msg']							=	'success';
		$data['business_store_list']			=	$business_store_search_by_name;
		print_r(json_encode($data));
	}
}


/*========================================================================================================*/




// Check Out order
if(!empty($_POST['cout_u_id'])){ 
    $checkout_order                    =     $common_controller->checkout_order();  
      // print_r($checkout_order);exit;
    if($checkout_order=="Session expired"){
		$checkout_order1['msg']  = 'Session expired';
		print_r(json_encode($checkout_order1)); 
	}else if($checkout_order=="no_coup"){
		$data					=	array();
		$data['msg']			=	'Coupon is not exists';
		print_r(json_encode($data)); 
	}else{
		$data					=	array(); 
		$data['msg']			=	'success';
		$data['order_id']		=	$checkout_order;
		print_r(json_encode($data));
	}
}





// business category list home apge
if(!empty($_POST['up_user_id'])){
	$transcation_update_order					= 	$common_controller->transcation_update_order();  
	//print_r($transcation_update_order);exit;
	if($transcation_update_order == 1 ){
		$data									=	array(); 
		$data['msg']							=	'success'; 
		print_r(json_encode($data));
	}
	else if($transcation_update_order == "session expired"){ 
		$add_to_cart_dish1['msg']  = 'session expired';
		print_r(json_encode($add_to_cart_dish1)); 
	}else{
		$data									=	array(); 
		$data['msg']							=	'Order not found'; 
		print_r(json_encode($data));
	}
}



// business category list home apge
if(!empty($_POST['user_fcm_id'])){
	$update_fcm_token					= 	$common_controller->update_fcm_token();  
	//print_r($transcation_update_order);exit;
	if($update_fcm_token == 1 ){
		$data									=	array(); 
		$data['msg']							=	'success'; 
		print_r(json_encode($data));
	}
	else if($update_fcm_token == "session expired"){ 
		$add_to_cart_dish1['msg']  = 'session expired';
		print_r(json_encode($add_to_cart_dish1)); 
	}else{
		$data									=	array(); 
		$data['msg']							=	'User not found'; 
		print_r(json_encode($data));
	}
}




// business category list home apge
if(!empty($_POST['geto_user_id'])){
	$get_user_order_details					= 	$common_controller->get_user_order_details_app();  
	// print_r($get_user_order_details);exit;
	if($get_user_order_details=='session expired'){
			$add_to_cart_dish1['msg']  = 'session expired';
			print_r(json_encode($add_to_cart_dish1)); 
		}elseif(empty($get_user_order_details)){
			$add_to_cart_dish1['msg']  = 'No records found';
			print_r(json_encode($add_to_cart_dish1));  
		}else{
			$data									=	array(); 
			$data['msg']							=	'success';
			$data['order_list']			=	$get_user_order_details;
			print_r(json_encode($data));
		}
}








// business category list home apge
if(!empty($_POST['h_user_id'])){
	$get_user_order_details					= 	$common_controller->get_user_order_history_app();  
	// print_r($get_user_order_details);exit;
	if($get_user_order_details=='session expired'){
			$add_to_cart_dish1['msg']  = 'session expired';
			print_r(json_encode($add_to_cart_dish1)); 
		}elseif(empty($get_user_order_details)){
			$add_to_cart_dish1['msg']  = 'No records found';
			print_r(json_encode($add_to_cart_dish1));  
		}else{
			$data									=	array(); 
			$data['msg']							=	'success';
			$data['order_list']			=	$get_user_order_details;
			print_r(json_encode($data));
		}
}

?>