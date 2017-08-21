<?php 
 class vendor_controller	{
	
	function __construct(){
		global $obj_model; 
		$this->model	=	& $obj_model; 
		date_default_timezone_set('Asia/Kolkata'); 
		global $date; 
		$date			=	date('Y-m-d H:i:s');
		$this->date		=	& $date; 
		
	}
	
	
	
	function vendor_login()
	{
	// print_r($_POST);exit;
		$table           	= 	 table();
		$table_name     	=	 $table['tb3'];
		$b_store_mobile_no	=	 addcslashes($_POST['vendor_mobile_no'], "'");
		$b_store_password	=	 md5($_POST['vendor_password']); 
		$fields		    	= 	 '*';
		// $condition		  	= 	 'b_store_password    = ' . "'" . $b_store_password . "'" . ' AND b_store_mobile_no = ' . "'" . $b_store_mobile_no . "'";
		$condition		  	= 	 'b_store_password    = ' . "'" . $b_store_password . "'" . ' AND b_store_email = ' . "'" . $b_store_mobile_no . "'";
		$arr_result_test 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);
		$b_store_email		=	$arr_result_test['b_store_email'];
		$vendor_mobile_no	=	$arr_result_test['b_store_mobile_no'];
		$b_store_id			=	$arr_result_test['b_store_id'];
		// echo'<pre>';
		// print_r($arr_result_test['b_store_id']);die;
		
		
		if($arr_result_test){
				// $condition		  	= 	 'b_store_password    = ' . "'" . $b_store_password . "'" . ' AND b_store_mobile_no = ' . "'" . $b_store_mobile_no . "'". ' AND b_store_mobile_no_verified = 1';
				// $condition		  	= 	 'b_store_password    = ' . "'" . $b_store_password . "'" . ' AND b_store_email = ' . "'" . $b_store_mobile_no . "'". ' AND b_store_mobile_no_verified = 1';
				$condition		  	= 	 'b_store_password    = ' . "'" . $b_store_password . "'" . ' AND b_store_email = ' . "'" . $b_store_mobile_no . "'". ' AND b_store_email_verified = 1';
				$arr_result_test 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);  
				if($arr_result_test['b_store_email_verified']==1){ 
					$arr_result_test['message'] = 'Success';
					return $arr_result_test; 
				}elseif($arr_result_test['b_store_email_verified']==0){
				
					
					//Vendor verification code sms
					$vendor_reg_otp				=   rand(100000,999999);  
					$_SESSION['vendor_reg_otp']	=	$vendor_reg_otp	;  
					
					$set_array			=	array(
												'b_store_reg_otp'=> $vendor_reg_otp
											); 
					$condition 			=	"b_store_id	=	'".$b_store_id."'";				
					$result				=	$this->model->update($table_name,$set_array,$condition);
					 
					// $msg=urlencode("Use OTP:".$vendor_reg_otp." for mobile number verification.\n."); 
					// $url="".$vendor_mobile_no."&text=".$msg."&priority=ndnd&stype=normal"; 
					// $ch = curl_init();
					// curl_setopt( $ch, CURLOPT_URL, $url );
					// curl_setopt( $ch, CURLOPT_POST, true );
					// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
					// curl_exec($ch);  
					// $res		=	array("otp"=>$vendor_reg_otp,"mobile_no"=>$vendor_mobile_no,"message"=>"Not verifed");		
					$res		=	array("otp"=>$vendor_reg_otp,"mobile_no"=>$b_store_email,"message"=>"Not verifed");	


						
				// E-Mail To User
				$to 			= 	$b_store_email;
				$subject		=	"Account verification code.";
				$message		=	'<html>
										<body>
											<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
												<p>OTP:,<strong>' . $vendor_reg_otp . '</strong></p> 
											</table>
										</body>
									</html>';
		
				
				$headers1 		= 	"MIME-Version: 1.0" . "\r\n";
						
				$headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
				
				$headers1 		.= 	"From:admin@gmail.com\r\n";
				
				if (mail($to, $subject, $message, $headers1)) {
					return $arr_result_test=$res; 
				}		
				
				
					return $arr_result_test=$res; 
				} 
		}else{ 
			$res		=	array("message"=>"Invalid");		
			return $arr_result_test=$res; 
		}
	}
	
	
	
	
	
	
	
	
	
	function vendor_otp_check()
	{
	// print_r($_POST);exit;
		$table           	= 	 table();
		$table_name     	=	 $table['tb3'];
		$b_store_reg_otp	=	 addcslashes($_POST['OTP'], "'"); 
		$b_store_mobile_no	=	 addcslashes($_POST['confirm_mobile'], "'");
		$fields		    	= 	 '*';
		// $condition		  	= 	 'b_store_reg_otp    = ' . "'" . $b_store_reg_otp . "'" . ' AND b_store_mobile_no = ' . "'" . $b_store_mobile_no. "'";
		$condition		  	= 	 'b_store_reg_otp    = ' . "'" . $b_store_reg_otp . "'" . ' AND b_store_email = ' . "'" . $b_store_mobile_no. "'";
		$arr_result_test 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition); 
		// echo'<pre>';
		// print_r($arr_result_test);die;
		// return $arr_result_test;die;
		
		if($arr_result_test){
				 
					$set_array			=	array(
												'b_store_reg_otp'		=> '',
												'b_store_email_verified'=> '1'
												// 'b_store_mobile_no_verified'=> '1'
											); 
					// $condition		  	= 	 'b_store_reg_otp    = ' . "'" . $b_store_reg_otp . "'" . ' AND b_store_mobile_no = ' . "'" . $b_store_mobile_no. "'";
					$condition		  	= 	 'b_store_reg_otp    = ' . "'" . $b_store_reg_otp . "'" . ' AND b_store_email = ' . "'" . $b_store_mobile_no. "'";
					$result				=	$this->model->update($table_name,$set_array,$condition);
					 
					// $msg=urlencode("Use OTP:".$vendor_reg_otp." for mobile number verification.\n."); 
					// $url="".$vendor_mobile_no."&text=".$msg."&priority=ndnd&stype=normal"; 
					// $ch = curl_init();
					// curl_setopt( $ch, CURLOPT_URL, $url );
					// curl_setopt( $ch, CURLOPT_POST, true );
					// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
					// curl_exec($ch); 
					return $result; 
				} else{ 
						return $arr_result_test='Invalid'; 
				}
	}
	
	
	
	
	
	
	
	
	//forgot password
	function vendor_forgot_password()
	{
	// print_r($_POST);exit;
		$table           	= 	 table();
		$table_name     	=	 $table['tb3'];
		$b_store_mobile_no	=	 addcslashes($_POST['forgot_vendor_mobile_no'], "'"); 
		$fields		    	= 	 '*';
		// $condition		  	= 	'b_store_mobile_no = ' . "'" . $b_store_mobile_no . "'";
		$condition		  	= 	'b_store_email = ' . "'" . $b_store_mobile_no . "'";
		$arr_result_test 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);
		$b_store_email		=	$arr_result_test['b_store_email'];
		$vendor_mobile_no	=	$arr_result_test['b_store_mobile_no'];
		$b_store_id			=	$arr_result_test['b_store_id'];
		// echo'<pre>';
		// print_r($arr_result_test['b_store_id']);die;
		
		
		if($arr_result_test){ 
			//Vendor verification code sms
			$vendor_forgot_otp				=   rand(100000,999999);  
			$_SESSION['vendor_forgot_otp']	=	$vendor_forgot_otp	;  
			
			$set_array			=	array(
										'b_store_forgot_password_otp'=> $vendor_forgot_otp
									); 
			$condition 			=	"b_store_id	=	'".$b_store_id."'";				
			$result				=	$this->model->update($table_name,$set_array,$condition);
			 
			// $msg=urlencode("Use OTP:".$vendor_reg_otp." for mobile number verification.\n."); 
			// $url="".$vendor_mobile_no."&text=".$msg."&priority=ndnd&stype=normal"; 
			// $ch = curl_init();
			// curl_setopt( $ch, CURLOPT_URL, $url );
			// curl_setopt( $ch, CURLOPT_POST, true );
			// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
			// curl_exec($ch);  
			$res		=	array("otp"=>$vendor_forgot_otp,"mobile_no"=>$b_store_email,"message"=>"Success");	


			// E-Mail To User
				$to 			= 	$b_store_email;
				$subject		=	"Account verification code.";
				$message		=	'<html>
										<body>
											<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
												<p>OTP:,<strong>' . $vendor_forgot_otp . '</strong></p> 
											</table>
										</body>
									</html>';
		
				
				$headers1 		= 	"MIME-Version: 1.0" . "\r\n";
						
				$headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
				
				$headers1 		.= 	"From:admin@gmail.com\r\n";
				
				if (mail($to, $subject, $message, $headers1)) {
					return $arr_result_test=$res; 
				}		
				
				
				
			return $arr_result_test=$res;  
		}else{ 
			$res		=	array("message"=>"Invalid");		
			return $arr_result_test=$res; 
		}
	}
	
	
	
	
	
	
	function vendor_forgot_OTP_check()
	{
	// print_r($_POST);exit;
		$table           	= 	 table();
		$table_name     	=	 $table['tb3'];
		$b_store_forgot_otp	=	 addcslashes($_POST['forgot_OTP'], "'"); 
		$b_store_mobile_no	=	 addcslashes($_POST['confirm_mobile'], "'");
		$fields		    	= 	 '*';
		$condition		  	= 	 'b_store_forgot_password_otp    = ' . "'" . $b_store_forgot_otp . "'" . ' AND b_store_email = ' . "'" . $b_store_mobile_no. "'";
		$arr_result_test 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition); 
		// echo'<pre>';
		// print_r($arr_result_test);die;
		// return $arr_result_test;die;
		
		if($arr_result_test){
				 
					$set_array			=	array(
												'b_store_forgot_password_otp'=> '', 
											); 
					$condition		  	= 	 'b_store_email = ' . "'" . $b_store_mobile_no. "'";
					$result				=	$this->model->update($table_name,$set_array,$condition);  
					
					$res				=	array("mobile_no"=>$b_store_mobile_no,"message"=>"Success");	
					return $res;
				} else{ 
						return $arr_result_test='Invalid'; 
				}
	}
	
	
	
	
	
	
	function vendor_reset_password()
	{
	// print_r($_POST);exit;
		$table           	= 	 table();
		$table_name     	=	 $table['tb3'];
		$b_store_password	=	 addcslashes($_POST['reset_password'], "'"); 
		$b_store_mobile_no	=	 addcslashes($_POST['reset_confirm_mobile'], "'");
		$fields		    	= 	 '*';
		$condition		  	= 	 'b_store_email = ' . "'" . $b_store_mobile_no. "'";
		$arr_result_test 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition); 
		// echo'<pre>';
		// print_r($arr_result_test);die;
		// return $arr_result_test;die;
		
		if($arr_result_test){
				 
					$set_array			=	array(
												'b_store_password'=> md5($b_store_password), 
											); 
					$condition		  	= 	 'b_store_email = ' . "'" . $b_store_mobile_no. "'";
					$result				=	$this->model->update($table_name,$set_array,$condition);  
					
					$res				=	array("mobile_no"=>$b_store_mobile_no,"message"=>"Success");	
					return $res;
				} else{ 
						return $arr_result_test='Invalid'; 
				}
	}
	
	
	
	
	 
	
	/*Last Login Time date update*/
	function admin_logout($b_store_id)
	{
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb3'];
		$set_array			=	array(
									'b_store_last_login'=> $this->date
								);
		// echo'<pre>';print_r($set_array);exit;
		$condition 			=	"b_store_id	=	'".$b_store_id."'";				
		$result				=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}	
	
	
	
		 
	
	function get_main_category_list()
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb1']; 
		$fields	     		=	 '*'; 
		$orderby	     	=	 'mc_id'; 
		$condition	     	=	 'mc_status	=	1 || mc_status	=	0'; 
		$arr_result			= 	 $this->model->get_details_condition_orderby($table_name,$fields,$condition,$orderby);
		// print_r($arr_result_test);exit;
		return $arr_result;
	}
	
	
	
	 
	function get_sub_category_by_mc_id($id)
	{
		
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb2'];  
		$fields		    	= 	 '*';
		$condition			= 	'sc_ref_mc_id    = ' . "'" . $id . "'" . ' AND sc_status = 1'; 
		$arr_result		 	= 	 $this->model->get_all_details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		return $arr_result;
	}
	
	
	
	 
	
	function business_store_registration()
	{
	// print_r($_POST);exit;
		$table           	= 	 table();
		$table_name     	=	 $table['tb3'];
		$b_store_mobile_no	=	 addcslashes($_POST['reg_b_store_mobile_no'], "'"); 
		$reg_b_store_email	=	 addcslashes($_POST['reg_b_store_email'], "'"); 
		$fields		    	= 	 '*';
		$condition		  	= 	 'b_store_email = ' . "'" . $reg_b_store_email . "'";
		$arr_result_test 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition); 
		// echo'<pre>';
		// print_r($arr_result_test['b_store_id']);die;
		
		
		if(empty($arr_result_test)){ 
					
			//Vendor verification code sms
			$vendor_reg_otp				=   rand(100000,999999);  
			$_SESSION['vendor_reg_otp']	=	$vendor_reg_otp	;  
			$mc_id						=	$_POST['mc_id'];  
			$sub_category_id			=	$_POST['sub_category_id'];  
			$reg_store_name				=	$_POST['reg_store_name'];  
			$reg_b_store_owner_name		=	$_POST['reg_b_store_owner_name'];  
			$reg_b_store_mobile_no		=	$_POST['reg_b_store_mobile_no'];  
			$reg_b_store_password		=	$_POST['reg_b_store_password'];  
			$reg_b_store_email			=	$_POST['reg_b_store_email'];  
			
			$set_array			=	array(
										'b_store_mc_id'						=> $mc_id,
										'b_store_sc_id'						=> $sub_category_id,
										'b_store_name'						=> $reg_store_name,
										'b_store_owner_name'				=> $reg_b_store_owner_name,
										'b_store_mobile_no'					=> $reg_b_store_mobile_no,
										'b_store_password'					=> md5($reg_b_store_password),
										'b_store_reg_otp'					=> $vendor_reg_otp,
										'b_store_email'						=> $reg_b_store_email,
										'b_store_registration_date'			=>	$this->date,     
									); 
									
			// print_r($set_array);exit;						
									
			$result				=	$this->model->insert($table_name,$set_array);						
									
			$mc_id				=	$result; 
			$set_array			=	array(
										'b_store_unique_id'		=> "BSV".$result
									); 
			$condition 			=	"b_store_id	='".$result."'";				
			$result				=	$this->model->update($table_name,$set_array,$condition);
			 
			// $msg=urlencode("Use OTP:".$vendor_reg_otp." for mobile number verification.\n."); 
			// $url="".$vendor_mobile_no."&text=".$msg."&priority=ndnd&stype=normal"; 
			// $ch = curl_init();
			// curl_setopt( $ch, CURLOPT_URL, $url );
			// curl_setopt( $ch, CURLOPT_POST, true );
			// curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true ); 
			// curl_exec($ch);  
			
			
			
			$res		=	array("otp"=>$vendor_reg_otp,"mobile_no"=>$b_store_mobile_no,"message"=>"Success");	



			
			
			// E-Mail To User
			$to 			= 	$reg_b_store_email;
			$subject		=	"OTP Verification.";
			$message		=	'<html>
									<body>
										<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
											<p>OTP:,<strong>' . $vendor_reg_otp . '</strong></p> 
										</table>
									</body>
								</html>';
	
			
            $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
					
            $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
            $headers1 		.= 	"From:admin@gmail.com\r\n";
            
            if (mail($to, $subject, $message, $headers1)) {
				return  $arr_result_test=$res; 
            }			
						
			return $arr_result_test=$res; 
				 
		}else{ 
			$res		=	array("message"=>"Already registered");		
			return $arr_result_test=$res; 
		}
	}
	
	
	
	
	/* get_user_details_by_id update*/
	function get_store_details_by_id($storeid)
	{
		$table           	= 	table(); 
		$table_name     	=	 $table['tb3'];  
		$fields		    	= 	 '*';
		$condition		  	= 	 'b_store_id    = ' . "'" . $storeid . "'";
		$arr_result_test 	= 	 $this->model->get_store_details_by_id($table_name, $fields, $condition);
		return $arr_result_test;
	}
	
	
	
	
	/* update_business_store update*/
	function update_business_store()
	{
		$table           				= 	table();
		$table_name     				=	$table['tb3']; 
		$b_store_id						=	$_POST['store_id']; 
		$b_store_name					=	$_POST['store_name'];  
		$b_store_owner_name				=	$_POST['store_owner_name'];  
		$b_store_mobile_no				=	$_POST['store_mobile_no'];  
		$b_store_landline				=	$_POST['store_landline_no'];  
		$b_store_email					=	$_POST['store_email'];  
		$b_store_description			=	$_POST['store_description'];  
		$b_store_address1				=	$_POST['store_address'];   
		$b_store_address2				=	$_POST['store_address2']; 
		$b_store_area					=	$_POST['store_area']; 
		$b_store_landmark				=	$_POST['store_landmark']; 
		$b_store_city					=	$_POST['store_city']; 
		$b_store_state					=	$_POST['store_state']; 
		$b_store_country				=	$_POST['store_country']; 
		$b_store_zip					=	$_POST['store_zip']; 
		$b_store_mobile_no_verified		=	$_POST['store_mobile_verified'];  
		$b_store_email_verified			=	$_POST['store_email_verified'];  
		$b_store_has_delivery			=	$_POST['store_delivery'];  
		$b_store_mc_id					=	$_POST['mc_id'];  
		$b_store_sc_id					=	$_POST['sub_category_id'];   
		$b_store_document_prof			=	$_POST['store_document'];  
		$b_store_lat					=	$_POST['store_latitude'];  
		$b_store_long					=	$_POST['store_longitude'];  
		$b_store_working_days			=	implode(",",$_POST['store_working_days']);   
		$b_store_working_hours_from_time=	$_POST['store_working_hours_from_time'];  
		$b_store_working_hours_end_time	=	$_POST['store_working_hours_end_time'];  
		$b_store_priority				=	$_POST['store_priority1'];   
		$store_class					=	$_POST['store_class'];   
		
		
			if(!empty($_FILES['b_store_image']['tmp_name']))
				{  
					$filename = basename($_FILES['b_store_image']['name']);
					$ext = substr($filename, strrpos($filename, '.') + 1); 
					$target = "../../admin/admin-views/images/business_stores/"; 
					//Determine the path to which we want to save this file
					$now = new DateTime();
					$times = $now->getTimestamp();
					$newname = $target.$times.'.'.$ext;      
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['b_store_image']['tmp_name'],$newname))) {
							$b_store_image    =    $times.'.'.$ext; 
							
						}else{
							$message    =    "Could not move the file!";
						}
					}

				}	
		
		$set_array			=	array(  
									'b_store_name' 						=> $b_store_name,
									'b_store_owner_name' 				=> $b_store_owner_name,
									'b_store_email' 					=> $b_store_email, 
									'b_store_description'				=> $b_store_description, 
									'b_store_mobile_no'					=> $b_store_mobile_no,   
									'b_store_landline'					=> $b_store_landline,    
									'b_store_address1'					=> $b_store_address1,       
									'b_store_address2'					=> $b_store_address2,       
									'b_store_area'						=> $b_store_area,       
									'b_store_landmark'					=> $b_store_landmark,       
									'b_store_city'						=> $b_store_city,       
									'b_store_state'						=> $b_store_state,       
									'b_store_country'					=> $b_store_country,           
									'b_store_zip'						=> $b_store_zip,       
									'b_store_mobile_no_verified'		=> $b_store_mobile_no_verified,      
									'b_store_email_verified'			=> $b_store_email_verified,     
									'b_store_has_delivery'				=> $b_store_has_delivery,     
									'b_store_mc_id'						=> $b_store_mc_id,     
									'b_store_sc_id'						=> $b_store_sc_id,      
									'b_store_document_prof'				=> $b_store_document_prof,      
									'b_store_lat'						=> $b_store_lat,      
									'b_store_long'						=> $b_store_long,      
									'b_store_working_days'				=> $b_store_working_days,      
									'b_store_working_hours_from_time'	=> $b_store_working_hours_from_time,      
									'b_store_working_hours_end_time'	=> $b_store_working_hours_end_time,   
									'b_store_priority'					=> $b_store_priority,   
									'b_store_image'						=> $b_store_image 
								);
		// echo '<pre>';print_r($set_array);exit;
		$condition 			=	"b_store_id	='".$b_store_id."'";				
		$result				=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	function add_upload_product($store_id){
		
		$filename = $this->file_upload();
		$file = fopen($filename,"r");
		$products = array();
		
		while(!feof($file)){
			$products[] = fgetcsv($file);
		}
		fclose($file);
		//echo '<pre>';
		//print_r(count($products));
	    //echo '</pre>';
		//die();
		$table           	= 	 table();
		$table_name     	=	 $table['tb4']; 
		$fields		    	= 	 '*';
		$orderby		  	= 	 'p_id';//print_r($products);die;
		//echo "2 <br>";
		for($i=1;$i<count($products);$i++){
			
			$barcode =	trim($products[$i][8]);
			if(empty($barcode) || empty($products[$i][1]) || empty($products[$i][4]) || empty($products[$i][0])){
				continue;
			}

			//if(empty($products[$i][1])){
				//continue;
			//}
			$condition		  	= 	 "p_b_store_id    = " . "'" . $store_id."' and p_product_barcode_no = ".$barcode;
			
			$arr_result_test 	= 	 $this->model->get_details_condition_orderby($table_name,$fields,$condition,$orderby);
			//$p_title = mysql_real_escape_string($products[$i][2]);

			$con =	connection();
			//mysqli_real_escape_string($products[$i][1])
			$set_array	=	array(
								'p_b_store_id'						=> abs($store_id),
								'p_product_title'					=> mysqli_real_escape_string($con,$products[$i][1]),
								'p_brand_id'						=> $products[$i][2],
								'p_MRP'								=> $products[$i][4],
								'p_manufacturer'					=> $products[$i][9],
								'p_discount_price'					=> $products[$i][6],
								'p_expiry_date'						=> $products[$i][3],
								'p_discount_percentage'				=> $products[$i][7],
								'p_product_barcode_no'				=> $barcode,
								'p_SKU'								=> $products[$i][0],
								'p_small_image'						=> $products[$i][10],
								'p_large_image'						=> $products[$i][11],
								'p_short_description'				=> $products[$i][12],
								'p_product_description'				=> $products[$i][13],
								'p_status'							=> 1,
								'p_c_date'							=> $this->date 
							); 

			//$ttt[] =$set_array;
			//$result				=	$this->model->insert($table_name,$set_array);
			  //echo '<pre>';
			  //print_r($arr_result_test);
			  //echo '</pre>';
			if($arr_result_test){
				if($barcode){
					//$bar_code = $barcode; 
					$condition 			=	"p_product_barcode_no = '".$barcode.'"';				
					$result				=	$this->model->update($table_name,$set_array,$condition);	
					//echo '<pre>';
			  		//print_r($result);
			  		//echo '</pre>';
				}else{
					$result				=	$this->model->insert($table_name,$set_array);
				}
			}
			else{
				$result				=	$this->model->insert($table_name,$set_array);  
			}
			
			
			
		}
		//echo '<pre>';
		//print_r(count($ttt));
		//echo '</pre>';
		if($result){
			return 1;
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
				$target = "/var/www/html/NoQ/csv/"; 
				//Determine the path to which we want to save this file
				$newname = $target.$times.'-'.$filename;
				$newname1 = $times.'-'.$filename;
				// echo $newname;exit;
				//Check if the file with the same name is already exists on the server
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['file_name']['tmp_name'],$newname))) {
							 $add_icon=$newname1;
							 return $newname;
						}else{
								$message	=	"Could not move the file!";
								return $message;
						}
					}
					else return "error";
			}
	}
/*----------------------------------------------------------------------------------------------------------------------*/		

	
	 
	function add_store_product()
	{ 
		$table           	= 	 table();
		$table_name     	=	 $table['tb4'];
		  
		$p_b_store_id					=	$_POST['p_b_store_id'];  
		$p_product_title				=	$_POST['p_product_title'];  
		$p_brand_id						=	$_POST['p_brand_id'];  
		$p_MRP							=	$_POST['p_MRP'];  
		$p_discount						=	$_POST['p_discount'];  
		$p_discount_price				=	$_POST['p_discount_price'];  
		$p_product_description			=	$_POST['p_product_description'];  
		$p_short_description			=	$_POST['p_short_description'];  
		$p_product_barcode_no			=	$_POST['p_product_barcode_no'];  
		$p_SKU							=	$_POST['p_SKU'];  
		
		$set_array			=	array(
									'p_b_store_id'						=> $p_b_store_id,
									'p_product_title'					=> $p_product_title,
									'p_brand_id'						=> $p_brand_id,
									'p_MRP'								=> $p_MRP,
									'p_discount_percentage'				=> $p_discount,
									'p_discount_price'					=> $p_discount_price,
									'p_product_description'				=> $p_product_description,
									'p_short_description'				=> $p_short_description,
									'p_product_barcode_no'				=> $p_product_barcode_no,
									'p_SKU'								=> $p_SKU,
									'p_status'							=> 1,
									'p_c_date'							=> $this->date,     
								); 
								
		// print_r($set_array);exit;						
								
		$result				=	$this->model->insert($table_name,$set_array);  	
		return $result;  
	}
	
	
	function add_store_checkout_user()
	{ 
		$table           	= 	 table();
		$table_name     	=	"store_checkout_users";
		  
		$cu_store_id					=	$_POST['cu_store_id'];  
		$cu_security_name				=	$_POST['cu_security_name'];  
		$cu_mobile						=	$_POST['cu_mobile'];  
		$cu_email						=	$_POST['cu_email'];  
		$cu_passowrd					=	md5($_POST['cu_passowrd']);  
		
		$set_array			=	array(
									'cu_user_store_id'			=> $cu_store_id,
									'cu_user_name'				=> $cu_security_name,
									'cu_user_mobile'			=> $cu_mobile,
									'cu_user_email'				=> $cu_email,
									'cu_user_password'			=> $cu_passowrd,
									'cu_user_updated'			=> $this->date, 
									'cu_user_status'			=> 1
								); 
								
		// print_r($set_array);exit;						
								
		$result				=	$this->model->insert($table_name,$set_array);  	
		return $result;  
	}
	
	
	//Get business store product list
	function get_business_store_product_list($store_id)
	{ 
		$table           	= 	 table();
		$table_name     	=	 $table['tb4']; 
		$fields		    	= 	 '*';
		$condition		  	= 	 'p_b_store_id    = ' . "'" . $store_id."'";
		$orderby		  	= 	 'p_id';
		$arr_result_test 	= 	 $this->model->get_details_condition_orderby($table_name,$fields,$condition,$orderby);
		return $arr_result_test;  
		
	}
	
	function get_business_store_checkout_users_list($store_id)
	{ 
	//echo $store_id;die;
		$table           	= 	 table();
		$table_name     	=	 "store_checkout_users
"; 
		$fields		    	= 	 '*';
		$condition		  	= 	 'cu_user_store_id    = ' . "'" . $store_id."'";
		$orderby		  	= 	 'cu_id';
		$arr_result_test 	= 	 $this->model->get_details_condition_orderby($table_name,$fields,$condition,$orderby);
		return $arr_result_test;  
		
	}
	
	
				
	function user_cart_details_admin($b_store_id)
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb5'];   
		$fields				= 	 "*"; 
		$condition		  	= 	 'user_cart_store_ref_id    = ' . "'" . $b_store_id . "'";
		$arr_result_test 	= 	 $this->model->user_cart_details_admin($table_name, $fields, $condition);
		return $arr_result_test; 
	}
	
	
	
	
	//add tickets
	
	function add_tickets()
	{ 
		$table           	= 	 table();
		$table_name     	=	 $table['tb8'];
		  
		$st_store_ref_id					=	$_POST['st_store_ref_id'];  
		$st_ticket_title					=	$_POST['st_ticket_title'];  
		$st_ticket_price					=	$_POST['st_ticket_price'];  
		$st_short_description				=	$_POST['st_short_description'];  
		$st_ticket_sku						=	$_POST['st_ticket_sku'];   
		
		$set_array			=	array(
									'st_store_ref_id'					=> $st_store_ref_id,
									'st_ticket_title'					=> $st_ticket_title,
									'st_ticket_price'					=> $st_ticket_price,
									'st_short_description'				=> $st_short_description,
									'st_ticket_sku'						=> $st_ticket_sku, 
									'st_status'							=> 1, 
									'st_c_date'							=> $this->date,     
								); 
								
		 //print_r($set_array); 					
		//die();						
		$result				=	$this->model->insert($table_name,$set_array);  	
		return $result;  
	}
	
	
	
	
	
	//Get business store product list
	function get_tickets_list($store_id)
	{ 
		$table           	= 	 table();
		$table_name     	=	 $table['tb8']; 
		$fields		    	= 	 '*';
		$condition		  	= 	 'st_store_ref_id    = ' . "'" . $store_id."'";
		$orderby		  	= 	 'st_id';
		$arr_result_test 	= 	 $this->model->get_details_condition_orderby($table_name,$fields,$condition,$orderby);
		return $arr_result_test;  
		
	}
	
	
	
	
	
	
	
	
	//add Store Service Tax 
	function add_store_service_tax()
	{ 
		$table           	= 	 table();
		$table_name     	=	 $table['tb9'];
		  
		$store_tax_title					=	$_POST['store_tax_title'];  
		$store_tax_percenatage				=	$_POST['store_tax_percenatage'];  
		$store_tax_store_ref_id				=	$_POST['store_tax_store_ref_id'];  
		$store_tax_description				=	$_POST['store_tax_description'];  
		$st_ticket_sku						=	$_POST['st_ticket_sku'];   
		
		$set_array			=	array(
									'store_tax_title'					=> $store_tax_title,
									'store_tax_percenatage'				=> $store_tax_percenatage,
									'store_tax_store_ref_id'			=> $store_tax_store_ref_id,
									'store_tax_description'				=> $store_tax_description, 
									'store_tax_status'					=> 1, 
									'store_tax_c_date'					=> $this->date,     
								); 
								
		// print_r($set_array); 					
								
		$result				=	$this->model->insert($table_name,$set_array);  	
		return $result;  
	}
	
	
	
	
	
	
	//Get Store Service Tax Deatils
	function get_service_tax_list($store_id)
	{ 
		$table           	= 	 table();
		$table_name     	=	 $table['tb9']; 
		$fields		    	= 	 '*';
		$condition		  	= 	 'store_tax_store_ref_id    = ' . "'" . $store_id."'";
		$orderby		  	= 	 'store_tax_id';
		$arr_result_test 	= 	 $this->model->get_details_condition_orderby($table_name,$fields,$condition,$orderby);
		return $arr_result_test;  
		
	}
	
	
	
	//Get add_slider_img
	function add_slider_img()
	{ 
		$table           	= 	 table();
		$table_name     	=	 $table['tb12']; 
		$store_ref_id     	=	 $_POST['store_tax_store_ref_id']; 
	 
		if(!empty($_FILES['b_store_slider_image']['tmp_name']))
		{  
			$filename = basename($_FILES['b_store_slider_image']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1); 
			$target = "../../admin/admin-views/images/store_slider_img/"; 
			//Determine the path to which we want to save this file
			$now = new DateTime();
			$times = $now->getTimestamp();
			$newname = $target.$times.'.'.$ext;  	 
			if (!file_exists($newname)) {
			//Attempt to move the uploaded file to it's new place
				if ((move_uploaded_file($_FILES['b_store_slider_image']['tmp_name'],$newname))) {
					$file_name	=	$times.'.'.$ext;
				}else{
					$message	=	"Could not move the file!";
				}
			}
			
		}
		$arr_input	=	array (
						'bsslider_img'					=>	$file_name, 
						'bsslider_ref_store_id'			=>	$store_ref_id,  
						'bsslider_c_date'				=>	$this->date, 
						'bsslider_c_status'				=>	1, 
						);
		// echo'<pre>';print_r($arr_input);exit;
		$result				=	$this->model->insert($table_name,$arr_input);
		return $result=1;
		
	}
	
	
	
	
		
	//Get get_slider_img_list
	function get_slider_img_list($store_id)
	{ 
		$table           	= 	 table();
		$table_name     	=	 $table['tb12']; 
		$fields		    	= 	 '*';
		$condition		  	= 	 'bsslider_ref_store_id    = ' . "'" . $store_id."'";
		$orderby		  	= 	 'bsslider_id';
		$arr_result_test 	= 	 $this->model->get_details_condition_orderby($table_name,$fields,$condition,$orderby);
		return $arr_result_test;  
		
	}
	
	
	
	/* deactive_business_store update*/
	function deactive_slider_img()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb12']; 
		$mc_id				=	$_POST['id']; 
		$set_array			=	array(
									'bsslider_c_status'		=> 	0
								);
		// print_r($set_array);exit;
		$condition 			=	"bsslider_id	='".$mc_id."'";				
		$result				=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	
		
		
	
	/* activate_business_store update*/
	function activate_slider_img()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb12']; 
		$mc_id				=	$_POST['id']; 
		$set_array			=	array(
									'bsslider_c_status'		=> 1
								);
		// print_r($set_array);exit;
		$condition 			=	"bsslider_id	='".$mc_id."'";				
		$result				=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	 
	
	
	
					
	function ticket_order_list($b_store_id)
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb10'];   
		$fields				= 	 "*"; 
		$condition		  	= 	 'ticket_order_store_ref_id    = ' . "'" . $b_store_id . "'";
		$arr_result_test 	= 	 $this->model->ticket_order_list($table_name, $fields, $condition);
		return $arr_result_test; 
	}
	
	
	
	
	/* deactive_ticket update*/
	function deactive_ticket()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb8']; 
		$mc_id				=	$_POST['id']; 
		$set_array			=	array(
									'st_status'		=> 	0
								);
		// print_r($set_array);exit;
		$condition 			=	"st_id	='".$mc_id."'";				
		$result				=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	
		
		
	
	/* activate_ticket update*/
	function activate_ticket()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb8']; 
		$mc_id				=	$_POST['id']; 
		$set_array			=	array(
									'st_status'		=> 1
								);
		// print_r($set_array);exit;
		$condition 			=	"st_id	='".$mc_id."'";				
		$result				=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	 
	
	
	 	
				
	function get_order_list_by_store_id($b_store_id)
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb13'];    
		$fields		    	= 	 '*';
		$condition		  	= 	 'order_store_ref_id    = ' . "'" . $b_store_id . "'";
		$orderby		  	= 	 'order_id';
		$arr_result_test 	= 	 $this->model->get_order_list_by_store_id($table_name,$fields,$condition,$orderby); 
		return $arr_result_test; 
	}
	
	
		
	
	 	
				
	function get_order_list_details_by_id($order_id)
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb13'];    
		$fields		    	= 	 '*';
		//$condition		  	= 	 'o.order_id    = ' .$order_id;
		$condition		  	= 	 $order_id;
		$orderby		  	= 	 'order_id';
		$arr_result_test 	= 	 $this->model->get_order_list_details_by_id($table_name,$fields,$condition,$orderby); 
		return $arr_result_test; 
	}
	
	
	
	
}

?>