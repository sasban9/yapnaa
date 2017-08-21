<?php 
 
class common_controller	{
	
	function __construct(){
		global $obj_model; 
		$this->model	=	& $obj_model; 
		date_default_timezone_set('Asia/Kolkata'); 
		global $date; 
		$date			=	date('Y-m-d H:i:s');
		$this->date		=	& $date; 
		
	}  
	
	
	 
	// business category list home apge
	function business_category_list()
    {
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
        $user_id			           	 = 	$_POST['bs_user_id'];  
        $user_token_key				     = 	$_POST['bs_token'];   
        $user_latitude				     = 	$_POST['bs_latitude'];   
        $user_longitude				     = 	$_POST['bs_longitude'];   
		
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);   
		// print_r($arr_result);exit; 
		
		
		if($arr_result){	 
			$result      	 			 = 	$this->model->business_category_list($user_latitude, $user_longitude);   
		// print_r($result);exit; 
			$cat = array();
			$stores = array();
			$categories = array();
			$data = array();$i=0;
				foreach($result as $row){
					$stores = array();
					$categories = array();
						// print_r($row['b_store_description']);exit; 
					if(array_key_exists($row['sc_id'],$cat)){
						$store["b_store_id"]			=	$row['b_store_id'];
						$store["b_store_unique_id"]		=	$row['b_store_unique_id'];
						$store["b_store_name"]			=	$row['b_store_name'];
						$store["b_store_description"]	=	$row['b_store_description'];
						$store["b_store_business_type"]	=	$row['b_store_business_type'];
						$store["b_store_image"]			=	$row['b_store_image'];
						//$cat[$row->sc_id][]  = $store;
						 // print_r($store);exit;  
						array_push($cat[$row['sc_id']],$store);
					}
					else{
						$categories["sc_id"] 			= $row['sc_id'];
						$categories["sc_title"]			= $row['sc_title'];
						$categories["sc_image"] 		= $row['sc_image'];
						$categories["sc_priority"] 		= $row['sc_priority'];
						$categories["sc_priority"] 		= $row['sc_priority'];
						
						$store["b_store_id"]			=	$row['b_store_id'];
						$store["b_store_unique_id"]		=	$row['b_store_unique_id'];
						$store["b_store_name"]			=	$row['b_store_name'];
						$store["b_store_description"]	=	$row['b_store_description'];
						$store["b_store_business_type"]	=	$row['b_store_business_type'];
						$store["b_store_image"]			=	$row['b_store_image'];
						
						$categories["store_details"]	= array();
						$data[]		=		$categories;
						$cat[$row['sc_id']]	=	array();
						$cat[$row['sc_id']][]  = $store;
					}
				}
				// print_r($store);exit;  
				$result = array();
				foreach($data as $row){
					$stores = $cat[$row["sc_id"]];
					//echo gettype($stores);
					$row["store_details"]	=	$stores;
					$result[]	=	$row;
				}
			// print_r(($result));exit; 
			if(!empty($result)){
				return $result; 
			}else{
					return $arr_result='no records found';
			}	
		}else{
			return $arr_result='session expired';
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
				//$target = "/var/www/html/NoQ/images/"; 
				$target = "view/images/user_profile/"; 
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
							 //return $newname;
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
	
	
	
	
	//feching all main categories
	function get_user_profile()
    {
		
        $table           				 = 	table();
        $get_p_token          	 = 	$_POST['get_p_token'];
        $get_p_user_id          	 = 	$_POST['get_p_user_id'];
		
		$table_log_in    				    = 	$table['tb7'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_token_id    =$get_p_token and 	user_id = $get_p_user_id";
        $arr_log_in      	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		//print_r($arr_log_in);exit;
		
		if($arr_log_in){
			$table		    				 = 	$table['tb7'];
			$fields							 = '*';
			$condition		 				 = 	"user_id    = $get_p_user_id";
			$arr_log_in       				 = 	$this->model->get_Details_condition($table, $fields, $condition);
			//print_r($arr_log_in );
			return $arr_log_in;
		}else{
			return $arr_log_in='';
		}
    }
	

/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
			
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	 


// Update user profile
	function update_user_profile()
    {
        $table           					 = 	table(); 
        $up_p_token_key				   		= 	$_POST['up_p_token_key'];
        $up_p_user_id			   		 	= 	$_POST['up_p_user_id'];
        $up_p_address1				   	 	= 	$_POST['up_p_address1'];
        $up_p_address2				   	 	= 	$_POST['up_p_address2'];
        $up_p_area				   	 		= 	$_POST['up_p_area'];
        $up_p_landmark				   	 	= 	$_POST['up_p_landmark'];
        $up_p_pincode				   		= 	$_POST['up_p_pincode']; 
        $up_p_city				   			= 	$_POST['up_p_city']; 
        $up_p_state				   			= 	$_POST['up_p_state']; 
        $up_p_country				   		= 	$_POST['up_p_country']; 
        $up_p_first_name			   		= 	$_POST['up_p_first_name']; 
        $up_p_last_name				   		= 	$_POST['up_p_last_name']; 
        $up_p_dob				   			= 	$_POST['up_p_dob']; 
        $up_p_gender				   		= 	$_POST['up_p_gender']; 
		$up_p_pic							=	$this->file_upload();
		
		$table_log_in    				    = 	$table['tb7'];
        $fields_log_in   				    = 	'*'; 
        $condition_log_in				    =  "user_token_id    =$up_p_token_key and 	user_id = $up_p_user_id";
        $arr_log_in      	 			  = 	$this->model->get_Details_condition($table_log_in, $fields_log_in, $condition_log_in);
		//print_r($arr_log_in);exit;
		
		$fields			   				 = 	'*';
		$condition_get				 	 = 	 'user_id    = ' . "'" . $up_p_user_id . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_log_in, $fields, $condition_get);   
		
		if($arr_result){  
				 $fields_reg = array( 
								'user_first_name'				=> $up_p_first_name,
								'user_last_name'				=> $up_p_last_name,
								'user_dob'						=> $up_p_dob,
								'user_gender'					=> $up_p_gender,
								'user_address1'					=> $up_p_address1,
								'user_address2'					=> $up_p_address2,
								'user_area'						=> $up_p_area,
								'user_landmark'					=> $up_p_landmark,
								'user_zip_code'					=> $up_p_pincode,
								'user_city' 					=> $up_p_city,
								'user_state' 					=> $up_p_state,
								'user_country' 					=> $up_p_country,
								'user_profile_pic' 				=> $up_p_pic
							);
				
			// print_r($fields_reg);exit;
            $table_log_in = $table['tb7'];
            $condition     = 'user_id = ' . "'" . $up_p_user_id . "'";
			$arr_log_in    = $this->model->update($table_log_in, $fields_reg, $condition); 

			
			//print_r($arr_result);
			//die();
			return $arr_result;
		}  else{
			return $arr_result='';
		}
    }
	
	
	
	
	

/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
	
	
	//Get Store Ticket details 
	function get_store_tickets_details()
    {
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
		$table_slider		    		 = 	$table['tb12'];
        $tc_store_id		           	 = 	$_POST['tc_store_id'];  
        $user_id			           	 = 	$_POST['tc_user_id'];  
        $user_token_key				     = 	$_POST['tc_user_token'];   
		
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);   
		 //print_r($arr_result);exit; 
		
		
		if($arr_result){	 
			$table		    			 = 	$table['tb8'];
			$fields						 =	'*';
			$orderby					 =  'st_id';
			$condition					 =  'st_status = 1'.' and st_store_ref_id	 = ' . "'" . $tc_store_id . "'";  ;
			$arr_result      	 		 = 	$this->model->get_details_condition_orderby_asc($table,$fields,$condition,$orderby);
			
			 
			$fields						 =	'bsslider_img'; 
			$condition					 =  'bsslider_c_status = 1'.' and bsslider_ref_store_id	 = ' . "'" . $tc_store_id . "'";  ;
			$arr_result1      	 		 = 	$this->model->get_row_details_condition($table_slider,$fields,$condition);
			
			$res						=	array();
			$res['tickets']				=	$arr_result;
			$res['slider']				=	$arr_result1;
			
			 //print_r($res);exit; 
			 
			if(!empty($res)){
				return $res; 
			}else{
					return $arr_result='no records found';
			}	
		}else{
			return $arr_result='session expired';
		} 
		
		
	}
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/		
	
	
	
	
	//Get Store Ticket details 
	function get_single_tickets_details()
    {
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
		$table_slider		    		 = 	$table['tb12'];
        $tc_store_id		           	 = 	$_POST['stc_store_id'];  
        $user_id			           	 = 	$_POST['stc_user_id'];  
        $user_token_key				     = 	$_POST['stc_user_token'];   
        $ticket_id				     	 = 	$_POST['stc_ticket_id'];   
		
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);   
		//print_r($arr_result);exit; 
		
		
		
		if($arr_result){
			$table_name	    				 = 	$table['tb10'];
			$fields			   				 = 	'*';
			$condition				 		 = 	 'ticket_order_user_id    = ' . "'" . $user_id . "'".' and ticket_order_id	 = ' . "'" . $ticket_id . "'";  
			$data      	 			 = 	$this->model->get_user_ticket_details_app($table_name, $fields, $condition);    
			//print_r($data);die;
			if($data){
				$table_name	    				 = 	$table['tb11'];
				$fields			   				 = 	'*';
				$condition				 		 = 	 'ticket_item_order_user_id    = ' . "'" . $user_id . "'".' and ticket_item_master_ref_id	 = ' . "'" . $ticket_id . "'";  
				$row      	 			 = 	$this->model->get_user_ticket_items_details_app($table_name, $fields, $condition);    
				$data[0]["ticket_item_details"] = $row;
				//print_r($row);exit;
			}
			else{
				return "No records found"; 
			}
			return $data[0]; 
		}else{
			return $arr_result='session expired';  
		}
		
		
		
	}
	
	
	
	
	
	//Get Store Service Tax Details
	function get_store_service_tax_details()
    {
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
        $tc_store_id		           	 = 	$_POST['tax_store_id'];  
        $user_id			           	 = 	$_POST['tax_user_id'];  
        $user_token_key				     = 	$_POST['tax_user_token'];   
		
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);   
		// print_r($arr_result);exit; 
		
		
		if($arr_result){	 
			$table		    			 = 	$table['tb9'];
			$fields						 =	'* ';
			$orderby					 =  'store_tax_id';
			$condition					 =  'store_tax_status = 1'.' and store_tax_store_ref_id	 = ' . "'" . $tc_store_id . "'";  ;
			$arr_result      	 		 = 	$this->model->get_details_condition_orderby($table,$fields,$condition,$orderby);
			// print_r($arr_result);exit; 
			 
			if(!empty($arr_result)){
				return $arr_result; 
			}else{
					return $arr_result='no records found';
			}	
		}else{
			return $arr_result='session expired';
		} 
		
		
	}
	
	
	
	
	
	
	
	
	
	function ordering_ticket()
	{
		$table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
        $user_id				         = 	$_POST['atc_tic_user_id'];   //atc= add to cart tickets
        $user_token_key			         = 	$_POST['atc_tic_user_token'];    
        $atc_tic_store_id		         = 	$_POST['atc_tic_store_id'];    
        $atc_tic_id			         	 = 	$_POST['atc_tic_id'];   
        $atc_tic_type			         = 	$_POST['atc_tic_type'];   
        $atc_tic_qty		           	 = 	$_POST['atc_tic_qty'];      
        $atc_tic_per_price         	 	 = 	$_POST['atc_tic_per_price'];     
        $atc_tic_total_price	         = 	$_POST['atc_tic_total_price'];  
        $atc_tic_tax_ratio		         = 	$_POST['atc_tic_tax_ratio'];  
        $atc_tic_tax_amt	 	    	 = 	$_POST['atc_tic_tax_amt'];  
        $atc_tic_total_amt	 	    	 = 	$_POST['atc_tic_total_amt'];  
        $atc_tic_grand_total	    	 = 	$_POST['atc_tic_grand_total'];  
        $atc_tic_order_by		    	 = 	$_POST['atc_tic_order_by'];  
        $atc_tic_payment_mode	    	 = 	$_POST['atc_tic_payment_mode'];  
        $atc_tic_trans_id		    	 = 	$_POST['atc_tic_trans_id'];  
        $atc_tic_trans_msg		    	 = 	$_POST['atc_tic_trans_msg'];  
		
		
	 	$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);    
		//print_r($_POST);exit; 
		if($arr_result){	 
			$type						 = explode(",",$_POST['atc_tic_type']);  
			// print_r(count($type));exit; 
			    
				$fields_reg = array(
						'ticket_order_store_ref_id' 		=> $atc_tic_store_id,  
						'ticket_order_user_id' 				=> $user_id,     
						'ticket_order_total'				=> $atc_tic_total_price, 
						
						'ticket_order_service_tax_ratio'	=> $atc_tic_tax_ratio,  
						'ticket_order_service_tax_amt' 		=> $atc_tic_tax_amt,  
						'ticket_order_total'				=> $atc_tic_total_amt,    
						'ticket_order_grand_total'			=> $atc_tic_grand_total,     
						'ticket_order_by'					=> $atc_tic_order_by,    
						'ticket_order_booking_datetime'		=> $this->date,   
						'ticket_order_payment_mode'			=> $atc_tic_payment_mode,    
						'ticket_order_payment_status'		=> 1,    
						'ticket_order_tracking_number'		=> rand(10000,99999),    
						'ticket_order_status'				=> 1,      
						'ticket_order_transcation_id'		=> $atc_tic_trans_id,      
						'ticket_order_transcation_msg'		=> $atc_tic_trans_msg,      
						'ticket_order_no_items'				=> count($type),      
					);
					
					// print_r($fields_reg);exit; 
					
				$table_name	       = 	$table['tb10'];
				$arr_result_test   = $this->model->insert($table_name, $fields_reg);
				
				
				if($arr_result_test){
					$type								 = explode(",",$_POST['atc_tic_type']);  
					$atc_tic_qty						 = explode(",",$_POST['atc_tic_qty']);  
					$atc_tic_per_price					 = explode(",",$_POST['atc_tic_per_price']);  
					$atc_tic_total_price				 = explode(",",$_POST['atc_tic_total_price']);  
					 
					for($i=0;$i<count($type);$i++){
						$fields_reg = array(
								'ticket_item_master_ref_id' 			=> $arr_result_test,  
								'ticket_item_order_user_id'				=> $user_id,     
								'ticket_item_order_item_qty'			=> $atc_tic_qty[$i], 
								'ticket_item_order_ticket_cat_ref_id'	=> $type[$i],  
								'ticket_item_order_per_ticket_price'	=> $atc_tic_per_price[$i],  
								'ticket_item_order_cart_price'			=> $atc_tic_total_price[$i],
								'ticket_item_order_ticket_id'			=> $type[$i], 								
								'ticket_item_order_status'				=> 1,     
								'ticket_item_order_created_date'		=> $this->date 
							);
						$table_name	    				 = 	$table['tb11'];
						$arr_result   = $this->model->insert($table_name, $fields_reg);	
					}
					return $arr_result_test; 
				}else{
					return $arr_result_test="something went wrong";
				}
		 
		}else{
			return "session expired"; 
		} 
		
	
	}
	
	
	
	
	
	
	
	
		
			
	function get_mytickets_orders()
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb7'];  
		$user_id			= 	 $_POST['mytic_user_id'];  
        $user_token_key	    = 	$_POST['mytic_token'];    
		
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);    
		// print_r($arr_result);exit; 
		
		if($arr_result){	 
			$table		     	=	 $table['tb10'];  
			$fields				= 	 "*"; 
			$condition		  	= 	 'ticket_order_user_id    = ' . "'" . $user_id . "'";
			if(isset($_POST['mytic_order_id'])){
				$condition		  	= 	 "ticket_order_user_id    = '" . $user_id . "' and ticket_order_id   =  '".$_POST['mytic_order_id']."'";
			}
			
			$orderby			=	'ticket_order_id';
			$arr_result_test 	= 	 $this->model->get_details_condition_orderby($table,$fields,$condition,$orderby);
			// print_r($arr_result_test);exit; 
			if($arr_result_test){
				return $arr_result_test; 
			}else{
					return $arr_result_test='no records found'; 
			}
		}else{
			return $arr_result='session expired'; 
		}
	}
	
	
	
	
	
	
	function add_to_cart_dish()
	{
		$file = fopen("/var/www/html/addtocart.txt","w");
		fwrite($file,json_encode($_REQUEST));
		$table           				 = 	table();
        $user_id				         = 	$_POST['atc_user_id'];   //atc= add to cart
        $atc_barcode_id			         = 	$_POST['atc_barcode_id'];     
        $atc_added_by		 	    	 = 	$_POST['atc_added_by'];   
        $store_id 	    		 		 = 	$_POST['atc_store_id'];   
        $user_token_key 	    		 = 	$_POST['atc_token']; 
		
        $table_name	    				 = 	$table['tb7'];
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);    
		// print_r($arr_result);exit;
		
		if($arr_result){
		
			$table_name	    	= $table['tb5'];
			$table_product 	  	= $table['tb4'];  
			$fields		    	= '*';
			$condition		  	='p_product_barcode_no = '."'".trim($atc_barcode_id)."'".' and p_b_store_id = '.trim($store_id);
			$arr_result_test 	= $this->model->get_row_details_condition($table_product, $fields, $condition);
			//print_r($arr_result_test);exit; 	

			if($arr_result_test){ 
				$fields		    	= 	 '*';
				$condition		  	= 	 "user_cart_p_bar_code_id    = '". $atc_barcode_id."' and user_cart_store_ref_id='".$store_id."' and user_cart_user_ref_id    = '".$user_id."'";
				$arr_result_cart 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);
				//print_r($arr_result_cart);exit; 	
			  
				if(empty($arr_result_cart)){
						$fields_reg = array(
								'user_cart_store_ref_id' 		=> $arr_result_test['p_b_store_id'],  
								'user_cart_user_ref_id' 		=> $user_id,  
								'user_cart_p_bar_code_id'		=> $arr_result_test['p_product_barcode_no'], 
								'user_cart_ref_p_id'			=> $arr_result_test['p_id'], 
								'user_cart_qty'					=> 1, 
								'user_cart_p_price'				=> $arr_result_test['p_MRP'],   //100
								'user_cart_discount' 			=> $arr_result_test['p_discount_price'],  //100
								'user_cart_discount_price'		=> $arr_result_test['p_discount_price'],   //90
								'user_cart_price' 				=> $arr_result_test['p_MRP']	-	$arr_result_test['p_discount_price'],   //90
								'user_cart_item_status'			=> 1,    
								'user_cart_items_added_by'		=> 1,      
							); 
							// print_r($fields_reg);exit; 
						$arr_result	   = $this->model->insert($table_name, $fields_reg); 
				
				}else{
						$fields_reg = array(  
								'user_cart_qty'					=> $arr_result_cart['user_cart_qty']+1,  
								'user_cart_discount_price'		=> $arr_result_cart['user_cart_discount_price']+$arr_result_cart['user_cart_discount_price'],   
								'user_cart_price' 				=> $arr_result_cart['user_cart_price']*$arr_result_cart['user_cart_qty']*2,    
						); 
						// print_r($fields_reg);exit; 
						$condition 	=	"user_cart_id	=	'".$arr_result_cart['user_cart_id']."'";				
						$arr_result	=	$this->model->update($table_name,$fields_reg,$condition);  echo 2;
				}
				
				/*From here Hemas editing unedited*/
				if($arr_result){
					/*$set_array = array(
						'p_SKU' 		=> $arr_result_test['p_SKU']-1 
					); 
					
					
					//print_r($set_array);exit; 
					$condition 	=	"p_id	=	'".$arr_result_test['p_id']."'";				
					$result	=	$this->model->update($table_product,$set_array,$condition); 
					*/
					$fields				= 	 "uc.user_cart_id,uc.user_cart_qty,uc.user_cart_p_price,sp.p_product_title"; 
					$condition		  	= 	 'uc.user_cart_p_bar_code_id = sp.p_product_barcode_no and user_cart_user_ref_id    = ' . "'" . $user_id . "'  and sp.p_b_store_id = '".$store_id."'";
					//$arr_result_test 	= 	 $this->model->add_to_cart_user_cart_details($table_name, $fields, $condition);
					$tables 			= 	'store_products sp, user_cart uc';
					$arr_result_test 	= 	 $this->model->get_cart_details($tables, $fields, $condition);
					//print_r($arr_result_test );echo "<br>bla";
					
					
				$file = fopen("/var/www/html/3.txt","w");
				fwrite($file,json_encode($arr_result_test));
				fclose($file);
				
					return $arr_result_test; 
				}
				

				return $arr_result_test; 
			}else{
				return $arr_result_test='No item found'; 
			}	
		}else{
			return $arr_result='session expired';  
		}
	}
	
	
			
	function user_cart_details()
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb5'];  
		$user_id			= 	 $_POST['user_c_id']; 
		$store_id			= 	 $_POST['user_c_store_id']; 
		$fields				= 	 "*"; 
		$condition		  	= 	 "user_cart_user_ref_id = ".$user_id;//." and user_cart_store_ref_id = $store_id";
		//echo $condition; die;
		$arr_result_test 	= 	 $this->model->user_cart_details($table_name, $fields, $condition);
		//print_r($arr_result_test );die;
		return $arr_result_test; 
	}
	
	
	
	 
	function update_user_cart_items()
	{
		
		$table           				 = 	table();
        $table_name	    				 = 	$table['tb5'];
        $up_atc_u_id			         = 	$_POST['up_atc_u_id'];   //atc= add to cart 
        $up_atc_cart_id		       		 = 	$_POST['up_atc_cart_id'];    
		
		$fields		    	= 	 '*';
		$condition		  	= 	 'user_cart_id    = ' . "'" . $up_atc_cart_id. "'";
		$arr_result_cart 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);
		//print_r($arr_result_cart);exit; 	
		  
		  
		if($arr_result_cart){
		
			$table_product 	  	=	 $table['tb5'];  
			$fields		    	= 	 '*';
			//$condition		  	= 	 'p_product_barcode_no    = ' . "'" .$arr_result_cart['user_cart_p_bar_code_id']. "'";
			//$arr_result_test 	= 	 $this->model->get_row_details_condition($table_product, $fields, $condition);
			  // print_r($arr_result_test);exit;  
			  
				/*$set_array = array(
					'p_SKU' 		=> $arr_result_test['p_SKU'] + $arr_result_cart['user_cart_qty'] 
				); */
				$set_array = array(
					'user_cart_qty' 		=> $up_atc_u_id 
				); 
				//print_r($set_array);exit; 
				/*$condition 	=	"p_id	=	'".$arr_result_test['p_id']."'";				
				$result	=	$this->model->update($table_product,$set_array,$condition); 
				if($result){ */
					$condition		                 =	"user_cart_id	=	'$up_atc_cart_id'";
					$result	=	$this->model->update($table_product,$set_array,$condition);
					return $up_atc_cart_id;   
				//} 
		}   
		
	}
	
	
	function delete_user_cart_items()
	{
		$table           				 = 	table();
        $table_name	    				 = 	$table['tb5'];
        $del_atc_u_id			         = 	$_POST['del_atc_u_id'];   //atc= add to cart 
        $del_atc_cart_id		         = 	$_POST['del_atc_cart_id'];    
		
		$fields		    	= 	 '*';
		$condition		  	= 	 'user_cart_id    = ' . "'" . $del_atc_cart_id. "'";
		$arr_result_cart 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);
		  // print_r($arr_result_cart['user_cart_qty']);exit; 	
		  
		  
		if($arr_result_cart){
		
			$table_product 	  	=	 $table['tb5'];  
			//$fields		    	= 	 '*';
			//$condition		  	= 	 'p_product_barcode_no    = ' . "'" .$arr_result_cart['user_cart_p_bar_code_id']. "'";
			//$arr_result_test 	= 	 $this->model->get_row_details_condition($table_product, $fields, $condition);
			  // print_r($arr_result_test);exit;  
			  
				/*$set_array = array(
					'p_SKU' 		=> $arr_result_test['p_SKU'] + $arr_result_cart['user_cart_qty'] 
				); */
				
				// print_r($set_array);exit; 
				//$condition 	=	"p_id	=	'".$arr_result_test['p_id']."'";				
				//$result	=	$this->model->update($table_product,$set_array,$condition); 
				//if($result){ 
					$condition		                 =	"user_cart_id	=	'$del_atc_cart_id'";
					$result							 =	$this->model->delete_row_data($table_name,$condition); 
					return $del_atc_cart_id;   
				//} 
		}   
		
	}
	
	
	

	
	
	function delete_user_cart_empty()
	{
		$table           				 = 	table();
        $table_name	    				 = 	$table['tb5'];
		$table_product 	  				 =	 $table['tb4'];  
        $del_cart_u_id			         = 	$_POST['del_cart_u_id'];   //atc= add to cart 
		
	 	$fields		    	= 	 '*';
		$condition		  	= 	 'user_cart_user_ref_id    = ' . "'" . $del_cart_u_id. "'";
		$arr_result_cart 	= 	 $this->model->user_cart_details($table_name, $fields, $condition);
		for($i=0;$i<count($arr_result_cart);$i++){ 
			$set_array = array(
				'p_SKU' 		=> $arr_result_cart[$i]['p_SKU'] + $arr_result_cart[$i]['user_cart_qty'] 
			); 
			// print_r($set_array);exit; 
			$condition 	=	"p_id	=	'".$arr_result_cart[$i]['p_id']."'";				
			$result	=	$this->model->update($table_product,$set_array,$condition); 
			if($result){ 
				$condition 						 =	"user_cart_id	=	'".$arr_result_cart[$i]['user_cart_id']."'";	 
				$result							 =	$this->model->delete_row_data($table_name,$condition);  
			} 
		}
		return $result;		
	 
	}
	
	
	
	
	
	
	
	
	
	
	
//get store details by qrcode 
	function business_category_list_on_qr_code()
    {
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
        $qr_store_id		           	 = 	$_POST['qr_store_id'];  
        $user_id			           	 = 	$_POST['qr_u_id'];  
        $user_token_key				     = 	$_POST['qr_user_token'];   
		
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);   
		// print_r($arr_result);exit; 
		
		
		if($arr_result){	 
			$table		    			 = 	$table['tb3'];
			$fields						 =	'*';
			$orderby					 =  'b_store_id';
			$condition					 =  'b_store_status = 1'.' and b_store_unique_id	 = ' . "'" . $qr_store_id . "'";  ;
			$arr_result      	 		 = 	$this->model->get_details_condition_orderby($table,$fields,$condition,$orderby);
			// print_r($arr_result);exit; 
			 
			if(!empty($arr_result)){
				return $arr_result; 
			}else{
					return $arr_result='no records found';
			}	
		}else{
			return $arr_result='session expired';
		} 
		
		
	}
	
	
	
	
	function getting_distance($slat,$slong,$ulat,$ulong){
		// $slat=12.9478654;
		// $slong=77.4589847;
		// $ulat=12.908001;
		// $ulong=77.6449093;
		//$geocode=file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=12.9478654,77.4589847&destinations=12.908001,77.6449093&mode=driving&language=en-EN&sensor=false&key=AIzaSyCVjLmrEblR9NUr_FenCVmO8mwrdO9pOO8");
		$geocode=file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$slat.",".$slong."&destinations=".$ulat.",".$ulong."&mode=driving&language=en-EN&sensor=false&key=AIzaSyCVjLmrEblR9NUr_FenCVmO8mwrdO9pOO8");
		//$geocode=file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?origins=$slat,$slong&destinations=$ulat,$ulong&mode=driving&language=en-EN&sensor=false&key=AIzaSyCVjLmrEblR9NUr_FenCVmO8mwrdO9pOO8");
		
		$output= json_decode($geocode);
		//echo '<pre>';
		//print_r($output);
		//echo '</pre>';
		//echo $output[0]->distance;
		//print_r($output->rows[0]->elements[0]->distance->text);
		$out = $output->rows[0]->elements[0]->distance->text;
		return $out;
	}
	
	
 
 //get store list by category id 
	function business_category_list_by_category_id()
    {
		
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
        $qr_store_id		           	 = 	$_POST['sc_store_id'];  
        $user_id			           	 = 	$_POST['sc_u_id'];  
        $user_latitude			         = 	$_POST['sc_latitude'];  
        $user_longitude			         = 	$_POST['sc_longitude'];  
        $user_token_key				     = 	$_POST['sc_user_token'];   
		
		$fields			   				 = 	'*';
		$condition				 		 = 	'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);   
	
		if($arr_result){
			/*
            $table1		    			 = 	$table['tb3'];
            $fields1                      =  'b_store_lat,b_store_long';
            $condition1					 =  'b_store_sc_id in ('.$qr_store_id.')';
            $result1 					 = 	$this->model->get_Details_condition($table1,$fields1,$condition1);
		    $store_lat                   =  $result1[0]['b_store_lat'];
		    $store_long                  =  $result1[0]['b_store_long'];
		    */
		    $table		    			 = 	$table['tb3'];
			//3956 6371
			$fields						 =	"* ,  ROUND(3956  * 2 * ASIN(SQRT( POWER(SIN(('".$user_latitude."' - b_store_lat) * pi()/180 / 2), 2) +COS('".$user_latitude."'* pi()/180) * COS(b_store_lat * pi()/180) * POWER(SIN(('".$user_longitude."' -b_store_long) * pi()/180 / 2), 2) )),2) as distance ";
			$orderby					 =  'distance';
			$condition					 =  'b_store_status =1 and b_store_sc_id in ('. $qr_store_id .')'; 
			$arr_result = 	$this->model->get_details_condition_orderby_asc($table,$fields,$condition,$orderby);
			
		    
		    
			/*
			$distance = $this->getting_distance($store_lat,$store_long,$user_latitude,$user_longitude);
			$table		    			 = 	$table['tb3'];
			$fields						 =	"*,'".$distance."' as distance ;
			$orderby					 =  'b_store_id';
			$condition					 =  'b_store_status =1 and b_store_sc_id in ('. $qr_store_id .')'; 
			$arr_result = 	$this->model->get_details_condition_orderby_asc($table,$fields,$condition,$orderby);
			$arr_result['distance']=$distance;
			*/
			
			for($i=0;$i<count($arr_result);$i++){
				$arr_result[$i]['distance'] = $this->getting_distance($arr_result[$i]['b_store_lat'],$arr_result[$i]['b_store_long'],$user_latitude,$user_longitude);
			}
			
			if(!empty($arr_result)){
				return $arr_result;			
			}else{
					return $arr_result='no records found';
			}	
		}else{
			return $arr_result='session expired';
		} 
		
		
	}
	
	
	
	
	
	
	
	
	 
	// business_store_search_by_name
	function business_store_search_by_name()
    {
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
        $user_id			           	 = 	$_POST['search_user_id'];  
        $user_token_key				     = 	$_POST['search_token'];   
        $user_lat					     = 	$_POST['search_lat'];   
        $user_long				    	 = 	$_POST['search_long'];   
        $keyword						= 	$_POST['search_keyword'];   
		
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);   
		// print_r($arr_result);exit; 
		
		
		if($arr_result){	 
			$table_name	    			 = 	$table['tb3'];
			$fields			   			 = 	'b_store_id,b_store_name,b_store_business_type';
			$condition				 	 = 	'b_store_status    = 1 and b_store_name like "%'.$keyword.'%"';  
			$orderby					 =	'b_store_id';
			$result      	 			 = 	$this->model->business_search_list($user_lat, $user_long, $condition);
			// print_r(($result));exit; 
			if(!empty($result)){
				return $result; 
			}else{
					return $arr_result='no records found';
			}	
		}else{
			return $arr_result='session expired';
		} 
		
		
	}
	
	
	function coupon_exists($c_code){
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb16'];  
		$fields		    	= 	'*';
		$condition			= 	'coup_code="'.$c_code.'"'; 
		$arr_result		 	= 	 $this->model->get_Details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		//$result  = count($arr_result);
		return $arr_result;
	}
	
	
	function checkout_order()
	{
		$table           				 = 	table();
        $cout_u_id		         		 = 	$_POST['cout_u_id'];  
        $cout_token_key		      	     = 	$_POST['cout_token_key'];  
        $cout_amt_before_coupon   	     = 	$_POST['cout_amt_before_coupon'];  
        $cout_coupon_code		         = 	$_POST['cout_coupon_code'];   
        $cout_coupon_amt			     = 	$_POST['cout_coupon_amt'];   
        $cout_coupon_id		         	 = 	$_POST['cout_coupon_id'];   
        $cout_amt_aft_coupon		     = 	$_POST['cout_amt_aft_coupon'];   
        $cout_tax_id		         	 = 	$_POST['cout_tax_id'];   
        $cout_tax_amount		         = 	$_POST['cout_tax_amount'];   
        $cout_total_with_tax		     = 	$_POST['cout_total_with_tax'];      
        $cout_grand_total		         = 	$_POST['cout_grand_total'];   
        $cout_payment_mode		         = 	$_POST['cout_payment_mode'];    
        $cout_by		    		     = 	$_POST['cout_by'];    
		$payment_status			         = 	"Pending"; 

		$coup_count = $this->coupon_exists($cout_coupon_code);
		//print_r($coup_count);
		//die();
		//print_r(count($coup_count));
		//print_r($coup_count[0]['coup_amount']);
		$coup_code_count = count($coup_count);

		//die();
		
		
		 
		
		
		$today 			= date("dmY");
		$rand 			= strtoupper(substr(uniqid(sha1(time())),0,4));
		$unique 		= $today . $rand;


		$table_user    		=	 $table['tb7'];  
		$fields			    = 	'*';
		$condition			= 	 'user_id    = ' . "'" . $cout_u_id . "'".' and user_token_id	 = ' . "'" . $cout_token_key . "'";  
		$arr_result      	= 	$this->model->get_row_details_condition($table_user, $fields, $condition);   
		  // print_r($arr_result);exit; 
		
		if($arr_result){     
		
		   if($coup_code_count>0){

			
				$table_user    		=	 $table['tb5'];  
				$fields			    = 	 '*';
				$condition			= 	 'user_cart_user_ref_id    = ' . "'" . $cout_u_id . "'";  
				$arr_result      	= 	 $this->model->get_all_details_condition($table_user, $fields, $condition);   
				 //print_r($arr_result);exit; 
				$cout_no_items		=	count($arr_result);
				$cout_store_id		=	$arr_result[0]['user_cart_store_ref_id'];
				//$cout_u_id          =   $arr_result[0]['user_cart_user_ref_id'];
		 		
		 		/*
				$arr_input	=	array(
								'order_store_ref_id'			=>	$cout_store_id,
								'order_user_ref_id'				=>	$cout_u_id, 
								'order_service_tax_id'			=>	$cout_tax_id,
								'order_service_tax_amt'			=>	$cout_tax_amount,
								'order_amt_with_tax'			=>	$cout_total_with_tax, 
								'order_payment_mode'			=>	$cout_payment_mode,
								'order_payment_status'			=>	$payment_status, 
								'order_tracking_number'			=>	$unique,
								'order_status'					=>	1, 
								'order_created_date'			=>	$this->date, 
								'order_by'						=>	$cout_by, 
								'order_no_of_items'				=>	$cout_no_items, 
								'order_coupon_code'				=>	$cout_coupon_code,
								'order_amt_before_coupon'		=>	$cout_amt_before_coupon,
								'order_coupon_ref_id'			=>	$cout_coupon_id,
								'order_coupon_amt'				=>	$cout_coupon_amt,
								'order_amt_after_coupon'		=>	$cout_amt_aft_coupon,
								'order_grand_total'				=>	$cout_grand_total,
								);

				*/
				if($coup_count[0]['coup_type'] ==1){
					$cout_amt_aft_coupon = (($cout_amt_before_coupon)-(($cout_amt_before_coupon)*($coup_count[0]['coup_amount'])/100));
				}else if($coup_count[0]['coup_type'] ==2){
					$cout_amt_aft_coupon = (($cout_amt_before_coupon)-($coup_count[0]['coup_amount']));
				}
				$arr_input	=	array(
								'order_store_ref_id'			=>	$cout_store_id,
								'order_user_ref_id'				=>	trim($cout_u_id), 
								'order_service_tax_id'			=>	$cout_tax_id,
								'order_service_tax_amt'			=>	$cout_tax_amount,
								'order_amt_with_tax'			=>	$cout_total_with_tax, 
								'order_payment_mode'			=>	$cout_payment_mode,
								'order_payment_status'			=>	$payment_status, 
								'order_tracking_number'			=>	$unique,
								'order_status'					=>	1, 
								'order_created_date'			=>	$this->date, 
								'order_by'						=>	$cout_by, 
								'order_no_of_items'				=>	$cout_no_items, 
								'order_coupon_code'				=>	$cout_coupon_code,
								'order_amt_before_coupon'		=>	$cout_amt_before_coupon,
								'order_coupon_ref_id'			=>	$coup_count[0]['coup_id'],
								'order_coupon_amt'				=>	$coup_count[0]['coup_amount'],
								'order_amt_after_coupon'		=>	$cout_amt_aft_coupon,
								'order_grand_total'				=>	$cout_amt_aft_coupon,
								'order_coupon_type'				=>	$coup_count[0]['coup_type']
								);

				// echo'<pre>';print_r($arr_input);exit;
				
				$table_name	    	= 	$table['tb13']; 
				$result				=	$this->model->insert($table_name,$arr_input);
				if($result){
					$result_order		=	array('result'=>$result,'fields'=>$arr_input);
				}
				
				$last_inserted_id	=	$result;		
				 
				 
				 
				// echo'<pre>';print_r($arr_result);exit;
				for($i=0;$i<count($arr_result);$i++){
				
						 $cout_user_id					=	 $arr_result[$i]['user_cart_user_ref_id']; 
						 $cout_store_id					=	 $arr_result[$i]['user_cart_store_ref_id']; 
						 $cout_bar_code					=	 $arr_result[$i]['user_cart_p_bar_code_id']; 
						 $cout_bar_code_id				=	 $arr_result[$i]['user_cart_ref_p_id']; 
						 $cout_cart_qty					=	 $arr_result[$i]['user_cart_qty'];
						 $cout_item_price				=	 $arr_result[$i]['user_cart_p_price'];
						 $cout_item_discount_price		=	 $arr_result[$i]['user_cart_discount'];
						 $cout_item_discount_total		=	 $arr_result[$i]['user_cart_discount_price'];
						 $cout_cart_total				=	 $arr_result[$i]['user_cart_price'];  
						 
						 $arr_input	=	array(
								'item_order_ref_id'				=>	$last_inserted_id,
								'item_order_ref_user_id'		=>	$cout_user_id,
								'item_order_ref_store_id'		=>	$cout_store_id,
								'item_order_item_bar_code'		=>	$cout_bar_code,
								'item_order_item_ref_id'		=>	$cout_bar_code_id,
								'item_order_item_qty'			=>	$cout_cart_qty,   
								'item_order_item_per_price'		=>	$cout_item_price,
								'item_order_discount_per_item'	=>	$cout_item_discount_price,
								'item_order_discount_amt'		=>	$cout_item_discount_total, 
								'item_order_total_amt'			=>	$cout_cart_total, 
								'item_order_created_date'		=>	$this->date, 
								);
									// echo'<pre>';print_r($arr_input); 	
						$table_name	    	    = 	$table['tb14']; 
						$result					=	$this->model->insert($table_name,$arr_input); 
						$table_name     		=	$table['tb5'];   
						$condition				=	"user_cart_user_ref_id	=	'$cout_user_id'";
						//$del_result				=	$this->model->delete_row_data($table_name,$condition); 	 
				}

			}else{
				$result_order = "no_coup";
			}
			return $result_order;  
			 
		}else{
			return $arr_result_test="Session expired"; 
		}	
			
	}
	function update_fcm_token()
	{
		$table           				= 	table();
        $user_id				        = 	$_POST['user_fcm_user_id'];    
        $user_fcm_id				    = 	$_POST['user_fcm_id'];    
        $user_fcm_token 	    		= 	$_POST['user_fcm_user_token'];   
        $user_fcm_device				= 	$_POST['user_fcm_device'];     
        
        

		$table_name	    				 = 	$table['tb7'];
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_fcm_token . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition); 

		if($arr_result){
			$table_name	    			= 	$table['tb7'];
			$set_array					=	array('user_gcm_id'=>$user_fcm_id,'user_reg_by'=>$user_fcm_device);
			$arr_result      	 		= 	$this->model->update($table_name,$set_array,$condition);
			if($arr_result){
				return $arr_result=1; 
			}
			else{
				return "Token not updated";
			}
		}else{
			return $arr_result='session expired';  
		}
	}
	
	function transcation_update_order()
	{
		$table           				 = 	table();
        $user_id				         = 	$_POST['up_user_id'];    
        $user_token_key 	    		 = 	$_POST['up_token'];   
        $up_order_id			         = 	$_POST['up_order_id'];     
        $up_trans_id			         = 	$_POST['up_trans_id'];     
        $up_trans_res			         = 	$_POST['up_trans_res'];     
        $up_trans_type			         = 	$_POST['up_trans_type'];     
		
		
		
		
        $table_name	    				 = 	$table['tb7'];
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);    
		//print_r($arr_result);exit;
		
		if($arr_result){
			$payment_status			         = 	"Success";   
			$table_name	    				 = 	$table['tb13']; 
			$fields_reg = array(
					'order_transaction_id' 			=> $up_trans_id,  
					'order_transaction_date' 		=> $this->date,  
					'order_transaction_response'	=> $up_trans_res, 
					'order_transaction_type'		=> $up_trans_type, 
					'order_payment_status'			=> $up_trans_res,
					'order_status'					=> 2 
				); 
	 
			$condition 	=	"order_id	=	'".$up_order_id."'";				
			$arr_result	=	$this->model->update($table_name,$fields_reg,$condition); 
			return $arr_result;  
				 
		}else{
			return $arr_result='session expired';  
		}
	}
	
	
	
	 
	 
	 
	 
	 
	 /*
	 
	function get_cu_order_details_app(){
		$table           				 = 	table();
        $cuser_id				         = 	$_POST['cu_id'];    
        $cuser_token_key 	    		 = 	$_POST['cu_token'];
        $cu_store_id 					 = $_POST['cu_user_store_id']; 		
        //$order_id	 		    		 = 	$_POST['geto_order_id'];    
		 
		 
		 
        $table_name	    				 = 	$table['tb15'];
		$fields			   				 = 	'*';
		$condition				 		 = 	 'cu_id    = '.$cuser_id.' and cu_token= ' . "'" . $cuser_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);    
		//print_r($arr_result);
		//die();
		
		if($arr_result){
			$table_name	    				 = 	$table['tb13'];
			$fields			   				 = 	'*';
			$condition				 		 = 	 'order_store_ref_id = ' .$cu_store_id.' and order_status<>3 and order_status<>4';  
			$result      	 			 = 	$this->model->get_user_order_details_app($table_name, $fields, $condition);    
	
			//print_r($result);exit;
			$cat = array();
			$stores = array();
			$categories = array();
			$data = array();$i=0;
			
			
			foreach($result as $row){
					$stores = array();
					$categories = array();
						// print_r($row['b_store_description']);exit; 
					if(array_key_exists($row['order_id'],$cat)){
						$store["order_id"]						=	$row['order_id']; 
						//$cat[$row->sc_id][]  = $store;
						 // print_r($store);exit;  
						array_push($cat[$row['order_id']],$store);
					}
					else{
						$categories["order_id"] 			= $row['order_id']; 
						$categories["order_id"]						=	$row['order_id'];
						$categories["order_store_ref_id"]			=	$row['order_store_ref_id'];
						$categories["order_user_ref_id"]				=	$row['order_user_ref_id'];
						$categories["order_service_tax_id"]			=	$row['order_service_tax_id'];
						$categories["order_service_tax_amt"]			=	$row['order_service_tax_amt'];
						$categories["order_amt_with_tax"]			=	$row['order_amt_with_tax'];
						$categories["order_grand_total"]				=	$row['order_grand_total'];
						$categories["order_payment_mode"]			=	$row['order_payment_mode'];
						$categories["order_payment_status"]			=	$row['order_payment_status'];
						$categories["order_tracking_number"]			=	$row['order_tracking_number'];
						$categories["order_created_date"]			=	$row['order_created_date'];
						$categories["order_by"]						=	$row['order_by'];
						$categories["order_no_of_items"]				=	$row['order_no_of_items'];
						$categories["order_transaction_id"]			=	$row['order_transaction_id'];
						$categories["order_transaction_date"]		=	$row['order_transaction_date'];
						$categories["order_transaction_response"]	=	$row['order_transaction_response'];
						$categories["order_transaction_type"]		=	$row['order_transaction_type'];
						$categories["order_coupon_code"]				=	$row['order_coupon_code'];
						$categories["order_amt_before_coupon"]		=	$row['order_amt_before_coupon'];
						$categories["order_coupon_ref_id"]			=	$row['order_coupon_ref_id'];
						$categories["order_coupon_amt"]				=	$row['order_coupon_amt'];
						$categories["order_amt_after_coupon"]		=	$row['order_amt_after_coupon']; 
						
						
						$store["item_id"]							=	$row['item_id'];
						$store["item_order_ref_id"]					=	$row['item_order_ref_id'];
						$store["item_order_ref_user_id"]			=	$row['item_order_ref_user_id'];
						$store["item_order_ref_store_id"]			=	$row['item_order_ref_store_id'];
						$store["item_order_item_bar_code"]			=	$row['item_order_item_bar_code'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["p_product_title"]					=	$row['p_product_title'];
						$store["p_brand_id"]						=	$row['p_brand_id'];
						
						$categories["item_details"]	= array();
						$data[]		=		$categories;
						$cat[$row['order_id']]	=	array();
						$cat[$row['order_id']][]  = $store;
					}
				}
				// print_r($store);exit;
				
				
				$result = array();
				foreach($data as $row){
					$stores = $cat[$row["order_id"]];
					//echo gettype($stores);
					$row["item_details"]	=	$stores;
					$result[]	=	$row;
				}
				
			// print_r($arr_result);exit;
			return $result; 
		}else{
			return $arr_result='session expired';  
		}
		 
	}
	*/
	function get_cu_update_status_app(){
		
		
		$table         		 = 	table();
		$order_id 			= $_POST['get_order_id'];
		$order_user_id	 	= $_POST['geto_user_id'];   
		$order_store_ref_id     = $_POST['get_user_store_id'];
		$table_name                = $table['tb13'];
		$order_status_value = $_POST['get_order_status'];
		$fields     = array(
                'order_status' 	=> $order_status_value
            );
		
		$condition                 ='order_id = '.$order_id.'  and order_store_ref_id	 ='.$order_store_ref_id; 
		$arr_result      	 	= 	$this->model->update($table_name, $fields, $condition);
		
		if($arr_result==1){
			$result = 'success';
		}else{
			$result='session expired';
		}
		
	}
	/*
	function get_cu_update_status_app(){
		echo 'fghh';
		die();
		$table         		 = 	table();
		$order_id 			= $_POST['get_order_id'];
		$order_user_id	 	= $_POST['geto_user_id'];    
		
		//$order_id	 		= $_POST['geto_order_id'];
		$order_store_ref_id     = $_POST['get_user_store_id'];
		$table_name                = $table['tb13'];
		$order_status            = $_POST['get_order_status'];
		$fields                    ='order_status = '.$order_status,
		$condition                 =' order_id = '.$order_id.' and  order_user_ref_id    = ' .$order_user_id .' and order_store_ref_id	 = ' .$order_store_ref_id; 
		$arr_result      	 			 = 	$this->model->update($table_name, $fields, $condition);
		//print_r($arr_result);
		//die();
        if($arr_result){
			return $arr_result;
		}else{
			return $arr_result='session expired';  
		}		
	
	}
	*/
	
	/*function get_cuser_order_details_app()
	{
		$table           				 = 	table();
        $store_id				         = 	$_POST['geto_store_id'];    
        $user_id				         = 	$_POST['geto_user_id'];    
        $user_token_key 	    		 = 	$_POST['geto_token'];    
        $order_id	 		    		 = 	$_POST['geto_order_id'];    
		 
		
        $table_name	    				 = 	$table['tb15'];
		$fields			   				 = 	'*';
		$condition				 		 = 	 'cu_id    = ' . "'" . $user_id . "'".' and cu_token	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);    
			//print_r($arr_result);exit;
		
		if($arr_result){
			$table_name	    				 = 	$table['tb13'];
			$fields			   				 = 	'*';
			$condition				 		 = 	 'order_store_ref_id    = ' . "'" . $store_id . "'".' and order_id	 = ' . "'" . $order_id . "'";  
			$result      	 			 = 	$this->model->get_user_order_details_app($table_name, $fields, $condition);    
			
			//print_r($result);exit;
			$cat = array();
			$stores = array();
			$categories = array();
			$data = array();$i=0;
			
			
			foreach($result as $row){
					$stores = array();
					$categories = array();
						// print_r($row['b_store_description']);exit; 
					if(array_key_exists($row['order_id'],$cat)){
						$store["order_id"]						=	$row['order_id']; 
						//$cat[$row->sc_id][]  = $store;
						 // print_r($store);exit;  
						array_push($cat[$row['order_id']],$store);
					}
					else{
						$categories["order_id"] 			= $row['order_id']; 
						$categories["order_id"]						=	$row['order_id'];
						$categories["order_store_ref_id"]			=	$row['order_store_ref_id'];
						$categories["order_user_ref_id"]				=	$row['order_user_ref_id'];
						$categories["order_service_tax_id"]			=	$row['order_service_tax_id'];
						$categories["order_service_tax_amt"]			=	$row['order_service_tax_amt'];
						$categories["order_amt_with_tax"]			=	$row['order_amt_with_tax'];
						$categories["order_grand_total"]				=	$row['order_grand_total'];
						$categories["order_payment_mode"]			=	$row['order_payment_mode'];
						$categories["order_payment_status"]			=	$row['order_payment_status'];
						$categories["order_tracking_number"]			=	$row['order_tracking_number'];
						$categories["order_created_date"]			=	$row['order_created_date'];
						$categories["order_by"]						=	$row['order_by'];
						$categories["order_no_of_items"]				=	$row['order_no_of_items'];
						$categories["order_transaction_id"]			=	$row['order_transaction_id'];
						$categories["order_transaction_date"]		=	$row['order_transaction_date'];
						$categories["order_transaction_response"]	=	$row['order_transaction_response'];
						$categories["order_transaction_type"]		=	$row['order_transaction_type'];
						$categories["order_coupon_code"]				=	$row['order_coupon_code'];
						$categories["order_amt_before_coupon"]		=	$row['order_amt_before_coupon'];
						$categories["order_coupon_ref_id"]			=	$row['order_coupon_ref_id'];
						$categories["order_coupon_amt"]				=	$row['order_coupon_amt'];
						$categories["order_amt_after_coupon"]		=	$row['order_amt_after_coupon']; 
						
						$categories["order_cust_name"]				=	$row['user_first_name']; 
						$categories["order_mobile"]					=	$row['user_mobile_no']; 
						
						
						$store["item_id"]							=	$row['item_id'];
						$store["item_order_ref_id"]					=	$row['item_order_ref_id'];
						$store["item_order_ref_user_id"]			=	$row['item_order_ref_user_id'];
						$store["item_order_ref_store_id"]			=	$row['item_order_ref_store_id'];
						$store["item_order_item_bar_code"]			=	$row['item_order_item_bar_code'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["p_product_title"]					=	$row['p_product_title'];
						$store["p_brand_id"]						=	$row['p_brand_id'];
						
						$categories["item_details"]	= array();
						$data[]		=		$categories;
						$cat[$row['order_id']]	=	array();
						$cat[$row['order_id']][]  = $store;
					}
				}
				//print_r($store);//exit;
				
				
				$result = array();
				foreach($data as $row){
					$stores = $cat[$row["order_id"]];
					//echo gettype($stores);
					$row["item_details"]	=	$stores;
					$result[]	=	$row;
				}
				
			//print_r($arr_result);//exit;
			return $result; 
		}else{
			return $arr_result='session expired';  
		}
	}*/
	
	
	
	function get_user_order_details_app()
	{
		$table           				 = 	table();
        $user_id				         = 	$_POST['geto_user_id'];    
        $user_token_key 	    		 = 	$_POST['geto_token'];    
        $order_id	 		    		 = 	$_POST['geto_order_id'];    
		 
		 
		 
        $table_name	    				 = 	$table['tb7'];
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);    
		// print_r($arr_result);exit;
		
		if($arr_result){
			$table_name	    				 = 	$table['tb13'];
			$fields			   				 = 	'*';
			$condition				 		 = 	 'order_user_ref_id    = ' . "'" . $user_id . "'".' and order_id	 = ' . "'" . $order_id . "'";  
			$data      	 			 = 	$this->model->get_user_order_details_app($table_name, $fields, $condition);    
			
			
			//print_r($result);exit;
			/*$cat = array();
			$stores = array();
			$categories = array();
			$data = array();$i=0;*/
			
			$result = array();
				foreach($data as $row){
					//print_r($row);
					//$stores = $cat[$row["order_id"]];
					//echo gettype($stores);
					$fields			   				 = 	'*';
					$condition				 		 = 	 'item_order_ref_user_id    = ' . "'" . $user_id . "'".' and item_order_ref_id	 = ' . "'" . $row["order_id"] . "'";  
					$item_result      	 			 = 	$this->model->get_user_order_items_details_app($table_name, $fields, $condition);    
					//print_r($item_result);
					$row["item_details"]	=	$item_result;
					$result[]	=	$row;
				}
			/*foreach($result as $row){
					$stores = array();
					$categories = array();
					echo "Here - ".$row['order_id'].'<br>';
						// print_r($row['b_store_description']);exit; 
					if(array_key_exists($row['order_id'],$cat)){echo "1";
						$store["order_id"]						=	$row['order_id']; 
						//$cat[$row->sc_id][]  = $store;
						 // print_r($store);exit;  
						array_push($cat[$row['order_id']],$store);
					}
					else{echo "2<br>";
						$categories["order_id"] 			= $row['order_id']; 
						$categories["order_id"]						=	$row['order_id'];
						$categories["order_store_ref_id"]			=	$row['order_store_ref_id'];
						$categories["order_user_ref_id"]			=	$row['order_user_ref_id'];
						$categories["order_service_tax_id"]			=	$row['order_service_tax_id'];
						$categories["order_service_tax_amt"]		=	$row['order_service_tax_amt'];
						$categories["order_amt_with_tax"]			=	$row['order_amt_with_tax'];
						$categories["order_grand_total"]			=	$row['order_grand_total'];
						$categories["order_payment_mode"]			=	$row['order_payment_mode'];
						$categories["order_payment_status"]			=	$row['order_payment_status'];
						$categories["order_tracking_number"]			=	$row['order_tracking_number'];
						$categories["order_created_date"]			=	$row['order_created_date'];
						$categories["order_by"]						=	$row['order_by'];
						$categories["order_no_of_items"]				=	$row['order_no_of_items'];
						$categories["order_transaction_id"]			=	$row['order_transaction_id'];
						$categories["order_transaction_date"]		=	$row['order_transaction_date'];
						$categories["order_transaction_response"]	=	$row['order_transaction_response'];
						$categories["order_transaction_type"]		=	$row['order_transaction_type'];
						$categories["order_coupon_code"]				=	$row['order_coupon_code'];
						$categories["order_amt_before_coupon"]		=	$row['order_amt_before_coupon'];
						$categories["order_coupon_ref_id"]			=	$row['order_coupon_ref_id'];
						$categories["order_coupon_amt"]				=	$row['order_coupon_amt'];
						$categories["order_amt_after_coupon"]		=	$row['order_amt_after_coupon']; 
						
						
						$store["item_id"]							=	$row['item_id'];
						$store["item_order_ref_id"]					=	$row['item_order_ref_id'];
						$store["item_order_ref_user_id"]			=	$row['item_order_ref_user_id'];
						$store["item_order_ref_store_id"]			=	$row['item_order_ref_store_id'];
						$store["item_order_item_bar_code"]			=	$row['item_order_item_bar_code'];
						$store["item_order_item_per_price"]			=	$row['item_order_item_per_price'];
						$store["item_order_item_qty"]			=	$row['item_order_item_qty'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["p_product_title"]					=	$row['p_product_title'];
						$store["p_brand_id"]						=	$row['p_brand_id'];
						
						$categories["item_details"]	= array();
						$data[]		=		$categories;
						$cat[$row['order_id']]	=	array();
						$cat[$row['order_id']][]  = $store;
					}
				}*/
				// print_r($store);exit;
				
				
				/*$result = array();
				foreach($data as $row){
					$stores = $cat[$row["order_id"]];
					//echo gettype($stores);
					$row["item_details"]	=	$stores;
					$result[]	=	$row;
				}*/
				
			// print_r($arr_result);exit;
			return $result; 
		}else{
			return $arr_result='session expired';  
		}
	}
	
	function get_cuser_order_details_app()
	{
		$table           				 = 	table();
        $store_id				         = 	$_POST['geto_store_id'];    
        $user_id				         = 	$_POST['geto_user_id'];    
        $user_token_key 	    		 = 	$_POST['geto_token'];    
        $order_id	 		    		 = 	$_POST['geto_order_id'];    
		 
		
        $table_name	    				 = 	$table['tb15'];
		$fields			   				 = 	'*';
		$condition				 		 = 	 'cu_id    = ' . "'" . $user_id . "'".' and cu_token	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);    
			//print_r($arr_result);exit;
		
		if($arr_result){
			$table_name	    				 = 	$table['tb13'];
			$fields			   				 = 	'*';
			$condition				 		 = 	 'order_store_ref_id    = ' . "'" . $store_id . "'".' and order_id	 = ' . "'" . $order_id . "'";  
			$data      	 			 = 	$this->model->get_user_order_details_app($table_name, $fields, $condition);    
			
			//print_r($result);exit;
			/*$cat = array();
			$stores = array();
			$categories = array();
			$data = array();$i=0;
			*/
			
			$result = array();
				foreach($data as $row){
					//print_r($row);
					//$stores = $cat[$row["order_id"]];
					//echo gettype($stores);
					$fields			   				 = 	'*';
					$condition				 		 = 	 '  item_order_ref_id	 = ' . "'" . $row["order_id"] . "'";  
					$item_result      	 			 = 	$this->model->get_user_order_items_details_app($table_name, $fields, $condition);    
					//print_r($item_result);
					$row["item_details"]	=	$item_result;
					$result[]	=	$row;
				}
			/*foreach($result as $row){
					$stores = array();
					$categories = array();
					echo "Here - ".$row['order_id'].'<br>';
						// print_r($row['b_store_description']);exit; 
					if(array_key_exists($row['order_id'],$cat)){echo "1";
						$store["order_id"]						=	$row['order_id']; 
						//$cat[$row->sc_id][]  = $store;
						 // print_r($store);exit;  
						array_push($cat[$row['order_id']],$store);
					}
					else{echo "2<br>";
						$categories["order_id"] 			= $row['order_id']; 
						$categories["order_id"]						=	$row['order_id'];
						$categories["order_store_ref_id"]			=	$row['order_store_ref_id'];
						$categories["order_user_ref_id"]			=	$row['order_user_ref_id'];
						$categories["order_service_tax_id"]			=	$row['order_service_tax_id'];
						$categories["order_service_tax_amt"]		=	$row['order_service_tax_amt'];
						$categories["order_amt_with_tax"]			=	$row['order_amt_with_tax'];
						$categories["order_grand_total"]			=	$row['order_grand_total'];
						$categories["order_payment_mode"]			=	$row['order_payment_mode'];
						$categories["order_payment_status"]			=	$row['order_payment_status'];
						$categories["order_tracking_number"]			=	$row['order_tracking_number'];
						$categories["order_created_date"]			=	$row['order_created_date'];
						$categories["order_by"]						=	$row['order_by'];
						$categories["order_no_of_items"]				=	$row['order_no_of_items'];
						$categories["order_transaction_id"]			=	$row['order_transaction_id'];
						$categories["order_transaction_date"]		=	$row['order_transaction_date'];
						$categories["order_transaction_response"]	=	$row['order_transaction_response'];
						$categories["order_transaction_type"]		=	$row['order_transaction_type'];
						$categories["order_coupon_code"]				=	$row['order_coupon_code'];
						$categories["order_amt_before_coupon"]		=	$row['order_amt_before_coupon'];
						$categories["order_coupon_ref_id"]			=	$row['order_coupon_ref_id'];
						$categories["order_coupon_amt"]				=	$row['order_coupon_amt'];
						$categories["order_amt_after_coupon"]		=	$row['order_amt_after_coupon']; 
						
						
						$store["item_id"]							=	$row['item_id'];
						$store["item_order_ref_id"]					=	$row['item_order_ref_id'];
						$store["item_order_ref_user_id"]			=	$row['item_order_ref_user_id'];
						$store["item_order_ref_store_id"]			=	$row['item_order_ref_store_id'];
						$store["item_order_item_bar_code"]			=	$row['item_order_item_bar_code'];
						$store["item_order_item_per_price"]			=	$row['item_order_item_per_price'];
						$store["item_order_item_qty"]			=	$row['item_order_item_qty'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["p_product_title"]					=	$row['p_product_title'];
						$store["p_brand_id"]						=	$row['p_brand_id'];
						
						$categories["item_details"]	= array();
						$data[]		=		$categories;
						$cat[$row['order_id']]	=	array();
						$cat[$row['order_id']][]  = $store;
					}
				}*/
				// print_r($store);exit;
				
				
				/*$result = array();
				foreach($data as $row){
					$stores = $cat[$row["order_id"]];
					//echo gettype($stores);
					$row["item_details"]	=	$stores;
					$result[]	=	$row;
				}*/
				
			// print_r($arr_result);exit;
			return $result; 
		}else{
			return $arr_result='session expired';  
		}
	}
	
	//checkout user order list
	function get_cuser_order_history_app()
	{
	
		$table           				 = 	table();
        //$user_id				         = 	$_POST['h_user_id'];    
        //$user_token_key 	    		 = 	$_POST['h_token'];        
		
        $cuser_id				         = 	$_POST['cu_id'];    
        $cuser_token_key 	    		 = 	$_POST['cu_token'];
        $cu_store_id 					 = $_POST['cu_user_store_id']; 
		 
		 
        //$table_name	    				 = 	$table['tb7'];
		$table_name	    				 = 	$table['tb15'];
		$fields			   				 = 	'*';
		//$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		//$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);
		$condition				 		 = 	 'cu_id    = '.$cuser_id.' and cu_token= ' . "'" . $cuser_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);    	
		// print_r($arr_result);exit;
		
		if($arr_result){
			$table_name	    				 = 	$table['tb13'];
			$fields			   				 = 	'*';
			//$condition				 		 = 	 'order_user_ref_id    = ' . "'" . $user_id . "'";
			//$result      	 			 = 	$this->model->get_user_order_details_app($table_name, $fields, $condition); 
			$condition				 		 = 	 'order_store_ref_id = ' .$cu_store_id.' and order_status<>3 and order_status<>4';  
			$result      	 			 = 	$this->model->get_checkout_order_details_app($table_name, $fields, $condition);    
		
			
			//print_r($result);exit;
			$cat = array();
			$stores = array();
			$categories = array();
			$data = array();$i=0;
			
			
			foreach($result as $row){
					$stores = array();
					$categories = array();
						// print_r($row['b_store_description']);exit; 
					if(array_key_exists($row['order_id'],$cat)){
						$store["order_id"]						=	$row['order_id']; 
						//$cat[$row->sc_id][]  = $store;
						 // print_r($store);exit;  
						array_push($cat[$row['order_id']],$store);
					}
					else{
						$categories["order_id"] 			= $row['order_id']; 
						$categories["order_id"]						=	$row['order_id'];
						$categories["order_store_ref_id"]			=	$row['order_store_ref_id'];
						$categories["order_user_ref_id"]				=	$row['order_user_ref_id'];
						$categories["order_service_tax_id"]			=	$row['order_service_tax_id'];
						$categories["order_service_tax_amt"]			=	$row['order_service_tax_amt'];
						$categories["order_amt_with_tax"]			=	$row['order_amt_with_tax'];
						$categories["order_grand_total"]				=	$row['order_grand_total'];
						$categories["order_payment_mode"]			=	$row['order_payment_mode'];
						$categories["order_payment_status"]			=	$row['order_payment_status'];
						$categories["order_tracking_number"]			=	$row['order_tracking_number'];
						$categories["order_created_date"]			=	$row['order_created_date'];
						$categories["order_by"]						=	$row['order_by'];
						$categories["order_no_of_items"]				=	$row['order_no_of_items'];
						$categories["order_transaction_id"]			=	$row['order_transaction_id'];
						$categories["order_transaction_date"]		=	$row['order_transaction_date'];
						$categories["order_transaction_response"]	=	$row['order_transaction_response'];
						$categories["order_transaction_type"]		=	$row['order_transaction_type'];
						$categories["order_coupon_code"]				=	$row['order_coupon_code'];
						$categories["order_amt_before_coupon"]		=	$row['order_amt_before_coupon'];
						$categories["order_coupon_ref_id"]			=	$row['order_coupon_ref_id'];
						$categories["order_coupon_amt"]				=	$row['order_coupon_amt'];
						$categories["order_amt_after_coupon"]		=	$row['order_amt_after_coupon']; 
						$categories["user_first_name"]				=	$row['user_first_name']; 
						$categories["user_last_name"]		=	$row['user_last_name']; 
						$categories["user_mobile_no"]		=	$row['user_mobile_no']; 
						
						
						$store["item_id"]							=	$row['item_id'];
						$store["item_order_ref_id"]					=	$row['item_order_ref_id'];
						$store["item_order_ref_user_id"]			=	$row['item_order_ref_user_id'];
						$store["item_order_ref_store_id"]			=	$row['item_order_ref_store_id'];
						$store["item_order_item_bar_code"]			=	$row['item_order_item_bar_code'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["p_product_title"]					=	$row['p_product_title'];
						$store["p_brand_id"]						=	$row['p_brand_id'];
						
						$categories["item_details"]	= array();
						$data[]		=		$categories;
						$cat[$row['order_id']]	=	array();
						$cat[$row['order_id']][]  = $store;
					}
				}
				// print_r($store);exit;
				
				
				$result = array();
				foreach($data as $row){
					$stores = $cat[$row["order_id"]];
					//echo gettype($stores);
					$row["item_details"]	=	$stores;
					$result[]	=	$row;
				}
				
			// print_r($arr_result);exit;
			return $result; 
		}else{
			return $arr_result='session expired';  
		}
	}
	
	
	
//}
	
	
	
	
	
	function get_user_order_history_app()
	{
		$table           				 = 	table();
        $user_id				         = 	$_POST['h_user_id'];    
        $user_token_key 	    		 = 	$_POST['h_token'];        
		 
		 
		 
        $table_name	    				 = 	$table['tb7'];
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);    
		// print_r($arr_result);exit;
		
		if($arr_result){
			$table_name	    				 = 	$table['tb13'];
			$fields			   				 = 	'*';
			$condition				 		 = 	 'order_user_ref_id    = ' . "'" . $user_id . "'";
			$result      	 			 = 	$this->model->get_user_order_details_app($table_name, $fields, $condition);    
			
			//echo "<pre>";print_r($result);exit;
			$cat = array();
			$stores = array();
			$categories = array();
			$data = array();$i=0;
			
			
			foreach($result as $row){
					$stores = array();
					$categories = array();
						// print_r($row['b_store_description']);exit; 
					if(array_key_exists($row['order_id'],$cat)){
						$store["order_id"]						=	$row['order_id']; 
						//$cat[$row->sc_id][]  = $store;
						 // print_r($store);exit;  
						array_push($cat[$row['order_id']],$store);
					}
					else{
						$categories["order_id"] 			= $row['order_id']; 
						$categories["order_id"]						=	$row['order_id'];
						$categories["order_store_ref_id"]			=	$row['order_store_ref_id'];
						$categories["order_user_ref_id"]				=	$row['order_user_ref_id'];
						$categories["order_service_tax_id"]			=	$row['order_service_tax_id'];
						$categories["order_service_tax_amt"]			=	$row['order_service_tax_amt'];
						$categories["order_amt_with_tax"]			=	$row['order_amt_with_tax'];
						$categories["order_grand_total"]				=	$row['order_grand_total'];
						$categories["order_payment_mode"]			=	$row['order_payment_mode'];
						$categories["order_payment_status"]			=	$row['order_payment_status'];
						$categories["order_tracking_number"]			=	$row['order_tracking_number'];
						$categories["order_created_date"]			=	$row['order_created_date'];
						$categories["order_by"]						=	$row['order_by'];
						$categories["order_no_of_items"]				=	$row['order_no_of_items'];
						$categories["order_transaction_id"]			=	$row['order_transaction_id'];
						$categories["order_transaction_date"]		=	$row['order_transaction_date'];
						$categories["order_transaction_response"]	=	$row['order_transaction_response'];
						$categories["order_transaction_type"]		=	$row['order_transaction_type'];
						$categories["order_coupon_code"]				=	$row['order_coupon_code'];
						$categories["order_amt_before_coupon"]		=	$row['order_amt_before_coupon'];
						$categories["order_coupon_ref_id"]			=	$row['order_coupon_ref_id'];
						$categories["order_coupon_amt"]				=	$row['order_coupon_amt'];
						$categories["order_amt_after_coupon"]		=	$row['order_amt_after_coupon']; 
						
						$categories["order_store_image"]			=	$row['b_store_image']; 
						$categories["order_store_id"]				=	$row['b_store_id']; 
						$categories["order_store_unique_id"]		=	$row['b_store_unique_id']; 
						$categories["order_store_name"]				=	$row['b_store_name']; 
						$categories["order_store_address1"]			=	$row['b_store_address1']; 
						$categories["order_store_address2"]			=	$row['b_store_address2']; 
						$categories["order_store_area"]				=	$row['b_store_area']; 
						$categories["order_store_city"]				=	$row['b_store_city']; 
						$categories["order_store_zip"]				=	$row['b_store_zip']; 
						
						
						$store["item_id"]							=	$row['item_id'];
						$store["item_order_ref_id"]					=	$row['item_order_ref_id'];
						$store["item_order_ref_user_id"]			=	$row['item_order_ref_user_id'];
						$store["item_order_ref_store_id"]			=	$row['item_order_ref_store_id'];
						$store["item_order_item_bar_code"]			=	$row['item_order_item_bar_code'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["item_order_item_ref_id"]			=	$row['item_order_item_ref_id'];
						$store["p_product_title"]					=	$row['p_product_title'];
						$store["p_brand_id"]						=	$row['p_brand_id'];
						
						$categories["item_details"]	= array();
						$data[]		=		$categories;
						$cat[$row['order_id']]	=	array();
						$cat[$row['order_id']][]  = $store;
					}
				}
				// print_r($store);exit;
				
				
				$result = array();
				foreach($data as $row){
					$stores = $cat[$row["order_id"]];
					//echo gettype($stores);
					$row["item_details"]	=	$stores;
					$result[]	=	$row;
				}
				
			// print_r($arr_result);exit;
			return $result; 
		}else{
			return $arr_result='session expired';  
		}
	}
	
	
}

?>