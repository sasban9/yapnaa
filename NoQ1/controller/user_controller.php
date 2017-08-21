<?php 
class users
{
    function __construct()
    {
        global $obj_model; 
        $this->model =& $obj_model;
		date_default_timezone_set('Asia/Kolkata'); 
		global $date; 
		$date			=	date('Y-m-d H:i:s');
		$this->date		=	& $date; 
    }
    
    
	
	//APK version Check
	function apk_version_check()
	{
		$table           				 = 	table();
        $table_name	    				 = 	$table['tb6'];   		
		$fields			   				 = 	'app_version_no';
		$condition						 = 	'app_version_status    = 1';
		$orderby						 =	'app_version_id';
		$arr_result      	 			 = 	$this->model->get_details_condition_orderby($table_name,$fields,$condition,$orderby); 
		// print_r($arr_result);exit; 		
		return $arr_result;
		 
		
	}
//=======================================================================================================================/

//Checkout user login

function checkout_user_login(){
	
//echo 'check';
//die();
	 $keys = array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		$table           				 = 	table();
        $cuser_phone			         = 	$_POST['cu_user_mobile'];
        // $user_pin			         = 	($_POST['user_login_pin']);	
        $cuser_pin			        	 = 	md5($_POST['cu_user_password']);
		
        $cuser_gcm			        	 =  $_POST['cu_gcm_id'];
        $capp_key	      				 = 	$_POST['clogin_app_key'];
        $capp_secret      				 = 	$_POST['clogin_app_secret'];
        //$cuser_login_device_type		 = 	$_POST['cuser_login_device_type'];
        $ctable_log_in    				 = 	$table['tb15'];
			
        $cfields_log_in   				 = 	'*';
        $ck_condition_log_in		     = 	"cu_user_password    = '" . $cuser_pin . "' and cu_user_mobile=" . $cuser_phone;
        $carr_log_in      	 			 = 	$this->model->get_Details_condition($ctable_log_in, $cfields_log_in, $ck_condition_log_in);
		
		
		
		if(($keys[0]==$capp_key) && ($keys[1]==$capp_secret)){
			$res	=	1;
		}else{
			$res	=	0;
		}

		
		//if($res==1){
		if($carr_log_in){	
			date_default_timezone_set('Asia/Kolkata');
			$user_last_login 			= 	date('Y-m-d H:i:s');
			$cuser_token				=   rand(1000,9999999);
			
            $cset_array     = array(
                'cu_gcm_id' 			=> $cuser_gcm,
				'cu_token' 				=> $cuser_token,
				'cu_user_updated' 		=> $user_last_login
            );
            $ck_condition     					=	'cu_user_mobile = ' . "'" . $cuser_phone . "'";
            $carr_log_in1   					 = 	$this->model->update($ctable_log_in, $cset_array, $ck_condition);
			$cfields_log_in   				 = 	'*';
			$ckcondition_log_in				 = 	"cu_user_password    = '". $cuser_pin . "' and cu_user_mobile = '" . $cuser_phone ."'";
			
			$carr_log_in      	 			 = 	$this->model->get_Details_condition($ctable_log_in, $cfields_log_in, $ckcondition_log_in);
			 // print_r($arr_log_in);exit;
			return $carr_log_in[0];
			
		}
		else{
			return $carr_log_in="";
		}
	

	}	
	/*
	function get_cu_update_status_app(){
		echo 'fghh';
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
		print_r($arr_result);
		die();
        if($arr_result){
			return $arr_result;
		}else{
			return $arr_result='session expired';  
		}		
	
	}
	*/
//======================================================================================================================	
    
	
	
	// user registartion
    function user_resgitartion()
    {   
        $user_mobile_no				= 	$_POST['reg_mobile']; 
        $reg_fb_acc_id				= 	$_POST['reg_fb_acc_id']; 
        $reg_country_code			= 	$_POST['reg_country_code']; 
        $reg_login_by				= 	$_POST['reg_login_by'];
        $reg_by						= 	$_POST['reg_by'];
		
		//check user already exist or not
		$table          			= table();
		$table_name    			  	= $table['tb7'];
		$fields					    = '*';
		$condition_user 			=  'user_mobile_no = ' . "'" . $user_mobile_no . "'";
		$arr_result_test 			= $this->model->get_all_details_condition($table_name, $fields, $condition_user);
		// print_r($arr_result_test);exit;
        if (empty($arr_result_test)) {
          
            $fields_reg = array( 
                'user_mobile_no' 				=> $user_mobile_no, 
                'user_registration_date' 		=> $this->date, 
                'user_last_login' 				=> $this->date, 
                'user_fb_account_id'	 		=> $reg_fb_acc_id, 
                'user_country_code'	 			=> $reg_country_code, 
                'user_login_device'	 			=> $reg_login_by, 
                'user_reg_by'		 			=> $reg_by, 
				'user_mobile_no_verified'		=> 1,
                'user_token_id'		 			=> rand(100000,9999999), 
                'user_status' 					=> 1,
            ); 
            // print_r($fields_reg);exit;
			 
            $arr_result   = $this->model->insert($table_name, $fields_reg);
			
			//To Get updated Result
			$fields					    =  '*';
			$condition_user 			=  'user_id = ' . "'" . $arr_result . "'";
			$arr_result_test 			=  $this->model->get_row_details_condition($table_name, $fields, $condition_user);
			// print_r($fields_reg);exit;
			return $arr_result_test; 
        }else{ 
			if($arr_result_test[0]['user_status']==1){
				  $set_array     = array(
										'user_last_login' 			=> $this->date,  
										'user_login_device'			=> $reg_login_by, 
										'user_token_id'		 		=> rand(100000,9999999), 
										); 
				$condition 					=  'user_id    = ' . "'" . $arr_result_test[0]['user_id'] . "'";
				$update_user    			=  $this->model->update($table_name, $set_array, $condition);
				
				
				//To Get updated Result
				$fields					    =  '*';
				$condition_user 			=  'user_id = ' . "'" . $arr_result_test[0]['user_id']  . "'";
				$arr_result_test 			=  $this->model->get_row_details_condition($table_name, $fields, $condition_user);
				// print_r($arr_result_test);exit;
				 
				return $arr_result_test;  
			}else{
				return $arr_result_test="User Blocked";
			}
		}
    }
    
	 
/*----------------------------------------------------------------------------------------------------------------------*/	

	// User Logout
	function user_logout()
    {
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
        $user_id			           	 = 	$_POST['user_logout_id'];   
		$fields			   				 = 	'*';
		$condition				 		 = 	'user_id	 = ' . "'" . $user_id . "'"; 
		$arr_result      	 			 = 	$this->model->get_all_details_condition($table_name, $fields, $condition);   
		// print_r($arr_result);exit; 
		
		if($arr_result){  
			$set_array    				=  array( 
												'user_gcm_id' 			=> '', 
												'user_login_device' 	=> '0', 
												);
			$condition 					=  'user_id   	 = ' . "'" . $user_id . "'";
			// print_r($set_array);exit;;
			$arr_update_last_login		=  $this->model->update($table_name, $set_array, $condition); 
			return $arr_update_last_login;
		}else{
			return $arr_result='';
		} 
	}
	
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/	

	// User GCM ID Update
	function user_gcm_id_update()
    {
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
        $user_id			           	 = 	$_POST['gcm_user_id'];   
        $user_token_key		           	 = 	$_POST['gcm_token_key'];   
        $user_gcm_key		           	 = 	$_POST['gcm_key'];   
		$fields			   				 = 	'*';
		$condition				 		 = 	'user_id	 = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_all_details_condition($table_name, $fields, $condition);   
		// print_r($arr_result);exit; 
		
		if($arr_result){  
			$set_array    				=  array(
												'user_gcm_id' 	=> $user_gcm_key
												);
			$condition 					=  'user_id   	 = ' . "'" . $user_id . "'";
			// print_r($set_array);exit;;
			$arr_update_last_login		=  $this->model->update($table_name, $set_array, $condition); 
			return $arr_update_last_login;
		}else{
			return $arr_result='';
		} 
	}
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/	

	// User Profile Pic Update
	function user_profile_pic_update()
    {
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb8'];
        $user_id			           	 = 	$_POST['pic_user_id'];   
        $user_gcm_key		           	 = 	$_POST['pic_key'];   
        $pic_name	 		           	 = 	$_POST['pic_name'];   

		
		$fields			   				 = 	'*';
		$condition				 		 = 	'user_id	 = ' . "'" . $user_id . "'"; 
		$arr_result      	 			 = 	$this->model->get_all_details_condition($table_name, $fields, $condition);   
		// print_r($arr_result);exit; 
		
		if($arr_result){  
		 
		
			if(!empty($_FILES['pic_image']['tmp_name']))
			{  
				$filename = basename($_FILES['pic_image']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1); 
				$target = "view/images/user_profile/"; 
				//Determine the path to which we want to save this file
				$now = new DateTime();
				$times = $now->getTimestamp();
				$newname = $target.$times.'.'.$ext;  	 
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['pic_image']['tmp_name'],$newname))) {
						$file_name	=	$times.'.'.$ext;
					}else{
						$message	=	"Could not move the file!";
					}
				}
				
			}
			
			
			$user_img		= 'view/images/user_profile/'.$pic_name; 
			unlink($user_img);
			
			$set_array    				=  array(
												'user_profile_pic' 	=> $file_name
												);
												
			$condition 					=  'user_id   	 = ' . "'" . $user_id . "'"; 
			$arr_update_last_login		=  $this->model->update($table_name, $set_array, $condition); 
			return $arr_update_last_login;
		}else{
			return $arr_result='';
		} 
	}
	
	
	
	
	
	
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/	

	// User Profile   Update
	function user_profile_update()
    {
        $table           				 = 	table();
        $table_name	    				 = 	$table['tb7'];
        $user_id			           	 = 	$_POST['up_user_id'];  
        $user_token_key				     = 	$_POST['up_token'];   
		$user_first_name				 =	$_POST['up_fname'];  
		$user_last_name					 =	$_POST['up_lname'];  
		$user_email_id					 =	$_POST['up_email_id'];  
        $user_address1					 = 	$_POST['up_address1'];
        $user_address2					 = 	$_POST['up_address2'];
        $user_area						 = 	$_POST['up_area'];
        $user_landmark					 = 	$_POST['up_landmark'];
        $user_country					 = 	$_POST['up_country'];
        $user_state						 = 	$_POST['up_state'];
        $user_city						 = 	$_POST['up_city'];
        $user_zip_code					 = 	$_POST['up_zip_code']; 
        $user_gendor					 = 	$_POST['up_gendor']; 
        $user_dob					     = 	$_POST['up_dob']; 
		

		
		$fields			   				 = 	'*';
		$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
		$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);   
		// print_r($arr_result);exit; 
		
		if($arr_result){  
		 // print_r($arr_result);exit; 
			
			$file_name	=	'';
		 	if(!empty($_FILES['pic_image']['tmp_name']))
			{  
				$filename = basename($_FILES['pic_image']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1); 
				$target = "view/images/user_profile/"; 
				//Determine the path to which we want to save this file
				$now = new DateTime();
				$times = $now->getTimestamp();
				$newname = $target.$times.'.'.$ext;  	 
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['pic_image']['tmp_name'],$newname))) {
						$file_name	=	$times.'.'.$ext;
					}else{
						$message	=	"Could not move the file!";
					}
				} 
				$pic_name	=	$arr_result['user_profile_pic'];
				if($pic_name!=''){
					$user_img		= 'view/images/user_profile/'.$pic_name; 
					unlink($user_img);
				}
				
			}else{
				$file_name	=	$arr_result['user_profile_pic']; 
			}
						
			
			
		    $fields_reg = array(
								'user_first_name' 				=> $user_first_name, 
								'user_last_name' 				=> $user_last_name, 
								'user_email_id' 				=> $user_email_id, 
								'user_address1' 				=> $user_address1,
								'user_address2' 				=> $user_address2,
								'user_area' 					=> $user_area,
								'user_landmark' 				=> $user_landmark,
								'user_country' 					=> $user_country,
								'user_state' 					=> $user_state,
								'user_city' 					=> $user_city,
								'user_zip_code' 				=> $user_zip_code,    
								'user_gender' 					=> $user_gendor,    
								'user_dob' 						=> $user_dob,    
								'user_profile_pic' 				=> $newname
							);									
			// print_r($fields_reg);exit;
			$condition 					=  'user_id   	 = ' . "'" . $user_id . "'";
			$arr_update_last_login		=  $this->model->update($table_name, $fields_reg, $condition); 
			
			
			$fields			   				 = 	'*';
			$condition				 		 = 	 'user_id    = ' . "'" . $user_id . "'".' and user_token_id	 = ' . "'" . $user_token_key . "'";  
			$arr_result      	 			 = 	$this->model->get_row_details_condition($table_name, $fields, $condition);   
			//print_r($arr_result);
			//die();
		
			return $arr_result;
		}else{
			return $arr_result='';
		} 
	}
	
	
	
	
}	

?>
 
