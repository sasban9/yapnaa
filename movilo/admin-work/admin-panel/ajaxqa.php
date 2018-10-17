<?php
session_start(); 

if(isset($_SESSION['admin_email_id'])){
	
	$admin_email_id		= $_SESSION['admin_email_id'];
	$admin_name			= $_SESSION['admin_name'];
	$admin_last_login	= $_SESSION['admin_last_login'];
    $ar_id  	        = $_SESSION['ar_id'];
	require_once('controller/admin_controller.php');
	$control			= new admin();	
	
	require_once('helper/sms_helper.php');
	$helper 			= new helper();
	
	$brand_customer_id 	= $_GET['brand_customer_id'];
	$user_phone 		= $_GET['user_phone'];
	$user_id 			= $_GET['user_id'];
	
	$getQA 				= $control->getQA($_GET['customer_type'],$user_id);
	$get_qa_ids 		= $control->get_qa_ids_of_customer($_GET['customer_type'],$user_id);
	$brand_details 		= $control->get_brand_details_of_customer($_GET['customer_type'],$user_id);
	$timeline_data 		= $control->get_timeline_detail_of_customer($_GET['customer_type'],$user_id);
	
	$flname				= explode(" ",$brand_details['CUSTOMER_NAME']);
	$brand_details['flname'] = substr($flname[0],0,1)."".substr($flname[1],0,1);

	//echo "<br><pre>"; print_r($timeline_data);die;
	
	$parent_group_result = array();
	foreach ($getQA as $key1 => $value1) {
		$parent_group 	= $value1['qa_parent_group_level'];
		if (!isset($parent_group_result[$parent_group])){ 
			$parent_group_result[$parent_group] = array();
		}
		$parent_group_result[$parent_group][] = $value1;
	}
	
	$group_subgroup_result = array();
	foreach($parent_group_result as $key2 => $value2){
		foreach($value2 as $key3 => $value3){
			$sub_parent_group 	= $value3['qa_group_level'];
			if (!isset($group_subgroup_result[$key2][$sub_parent_group])){ 
				$group_subgroup_result[$key2][$sub_parent_group] = array();
			}
			$group_subgroup_result[$key2][$sub_parent_group][] = $value3;
		}
	}

	// Profile Things
	
	include 'profile_calculation.php';
	if(!empty($group_subgroup_result)){
		$profile_cal 							= calculate_profile($group_subgroup_result); 
		if(!empty($profile_cal)){
			$selling_customer_category			= $profile_cal['selling_customer_category'];
			$selling_target_engagement_level	= $profile_cal['selling_target_engagement_level'];
			$digital_customer_category			= $profile_cal['digital_customer_category'];
			$digital_target_engagement_level	= $profile_cal['digital_target_engagement_level'];
		}
	}
	
	// Response Actions Starts Here	
	if(isset($_POST['editAMCSubmit'])){
		//echo "<br><pre>";print_r($_POST);
					
		switch($_POST['brand_id']) {
			case 1:
			$brand_name	= 'livpure';
			break;
			case 2:
			$brand_name	= 'zerob_consol1';
			break;
			case 3:
			$brand_name	= 'livpure_tn_kl';
			break;
			case 4:
			$brand_name	= 'bluestar_b2b';
			break;
			case 5:
			$brand_name	= 'bluestar_b2c';
			break;
		}
		
		$data 					= array(
										'tm_brand_user_id' 		=> $_POST['user_id'],
										'tm_brand_customer_id'  => $_POST['brand_customer_id'],
										'tm_brand_name'   		=> $brand_name,
										'tm_brand_user_phone'   => $_POST['user_phone'],
										'tm_brand_id'   		=> $_POST['brand_id'],
										'tm_interaction'		=> 'Call By Agent',
										'tm_interaction_type'	=> 1,
										'tm_created_date'		=> date('Y-m-d')
										);
		// For adding call by agent to timeline table								
		$timeline_response 		= $control->insert_timeline_data($data);
		
		if(empty($_POST['brand_customer_id'])){
			$_POST['brand_customer_id'] = '';
		}
				
		if(!empty($_POST['req_service_date'])|| !empty($_POST['req_amc_date']) || !empty($_POST['req_upgrade_date']) || !empty($_POST['req_consumable_date'])){
	 
			$set_array_brand	=	array(
											'status'             => 15,
											'req_service_date'   => $_POST['req_service_date'],
											'req_amc_date'       => $_POST['req_amc_date'],
											'req_upgrade_date'   => $_POST['req_upgrade_date'],
											'req_consumable_date'=> $_POST['req_consumable_date'],
											'updated_on' 		 => date('Y-m-d')
										 );
							
		}else if(!empty($_POST['req_follow_up_date'])){
			$set_array_brand	=	array(
											'status'             => $_POST['status'],
											'req_follow_up_date' => $_POST['req_follow_up_date'],
											'updated_on' 		 => date('Y-m-d')
										 );
		}else if(!empty($_POST['last_call_comment'])){
			$set_array_brand	=	array(
											'status'             => $_POST['status'],
											'last_call_comment' => $_POST['last_call_comment'],
											'updated_on' 		 => date('Y-m-d')
										 );
		}else{
			$set_array_brand 	= array('status' =>$_POST['status'],'updated_on' => date('Y-m-d'));
		}
		
		$sliced_arr 	= array_slice($_POST, 0, -12, true);
		$insert_data	= "";
		$sql 			= "";
		$data1 			= array();
		
		foreach($sliced_arr as $key=>$value){
			
			if(empty(array_search($key,$get_qa_ids)) &&  array_search($key,$get_qa_ids) <= -1){
				//echo "insert loop - ".$value."<br>";
				$data 						= array();
				$value_split				= explode("_",$value);
				$data['qid']				= end(explode("_",$key));
				$data['answer']				= $value_split[0];
				$data['weightage']			= $value_split[1];
				$data['user_id']			= $_POST['user_id'];
				$data['brand_id']			= $_POST['brand_id'];
				$data['user_phone']			= $_POST['user_phone'];
				$data['brand_customer_id']  = $_POST['brand_customer_id'];
				$data['brand_name']  		= $brand_name;
				$data['created_date']  		= date('Y-m-d H:i:s');
				
				$data1[] 					= $data;
				//echo "<br><pre>";print_r($data);
				// For adding question and answer of customer
				$response 	= $control->insertQA($data,$insert_data,$sql,$_POST['user_phone']); 
				$response1  = $control->updateStatusInBrand($brand_name,$set_array_brand,$_POST['brand_customer_id'],$_POST['user_id']);
				
			}
				
			// Update Question Answer Data		
			else{
				//echo "update loop - ".$value."<br>";
				$value_split 				= explode("_",$value);
				$data['qid']				= end(explode("_",$key));
				$data['answer']				= $value_split[0];
				$data['weightage']			= $value_split[1];
				$data['user_id']			= $_POST['user_id'];
				$data['brand_id']			= $_POST['brand_id'];
				$data['user_phone']			= $_POST['user_phone'];
				$data['brand_customer_id']  = $_POST['brand_customer_id'];
				$data['brand_name']  		= $brand_name;
				$data['updated_date']  		= date('Y-m-d H:i:s');
				
				$data1[] 					= $data;
				//echo "<br><pre>";print_r($data1); die;
				// For updating question and answer of customer
				$response 	= $control->updateQA($data,$insert_data,$_POST['user_id']);
				$response1  = $control->updateStatusInBrand($brand_name,$set_array_brand,$_POST['brand_customer_id'],$_POST['user_id']);
				
			}	
			 
		}
		
		if($response1 == 1){
			// Profile Things
			$getQA 				= $control->getQA($_GET['customer_type'],$user_id);
			$parent_group_result = array();
			foreach ($getQA as $key1 => $value1) {
				$parent_group 	= $value1['qa_parent_group_level'];
				if (!isset($parent_group_result[$parent_group])){ 
					$parent_group_result[$parent_group] = array();
				}
				$parent_group_result[$parent_group][] = $value1;
			}
			$group_subgroup_result = array();
			foreach($parent_group_result as $key2 => $value2){
				foreach($value2 as $key3 => $value3){
					$sub_parent_group 	= $value3['qa_group_level'];
					if (!isset($group_subgroup_result[$key2][$sub_parent_group])){ 
						$group_subgroup_result[$key2][$sub_parent_group] = array();
					}
					$group_subgroup_result[$key2][$sub_parent_group][] = $value3;
				}
			}
				
			$existing_profile_status		 	= $control->get_existing_profile_status_of_customer($brand_name,$user_id);
			$existing_category  	 			= $existing_profile_status['profile_type'];
			$profile_cal 						= calculate_profile($group_subgroup_result); 
			$selling_customer_category			= $profile_cal['selling_customer_category'];
			
			if(($_POST['status'] == 16 || $_POST['status'] == 17 || $_POST['status'] == 18)){
				$message 			= 'Sorry to hear that you have bad feedback on your product. We will try to serve best for you';
				$msg_response 		= $control->send_lifecycle_sms($brand_details['PHONE1'],$message);
				
				if($_POST['status'] == 16){
					$data 				= array(
												'tm_brand_user_id' 		=> $_POST['user_id'],
												'tm_brand_customer_id'  => $_POST['brand_customer_id'],
												'tm_brand_name'   		=> $brand_name,
												'tm_brand_user_phone'   => $_POST['user_phone'],
												'tm_brand_id'   		=> $_POST['brand_id'],
												'tm_interaction'		=> 'AMC Related Escalation',
												'tm_interaction_type'	=> 10,
												'tm_agent_comment'		=> $_POST['last_call_comment'],
												'tm_movement_from'		=> $existing_category,
												'tm_movement_to'		=> $selling_customer_category,
												'tm_created_date'		=> date('Y-m-d')
												);
					$timeline_response 	= $control->insert_timeline_data($data);
					
					foreach($sliced_arr as $key1=>$value1){
						$pfl_data 							= array();
						$value_split						= explode("_",$value1);
						$pfl_data['ph_qid']					= end(explode("_",$key1));
						$pfl_data['ph_answer']				= $value_split[0];
						$pfl_data['ph_weightage']			= $value_split[1];
						$pfl_data['ph_timeline_id']			= $timeline_response;
						$pfl_data['ph_user_id']				= $_POST['user_id'];
						$pfl_data['ph_brand_id']			= $_POST['brand_id'];
						$pfl_data['ph_user_phone']			= $_POST['user_phone'];
						$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
						$pfl_data['ph_brand_name']  		= $brand_name;
						$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
						$pfl_data['ph_email']				= $brand_details['email'];
						$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
						$pfl_data1[] 						= $pfl_data;	
						
						$ph_response						= $control->insert_profile_history($pfl_data);
					}
					
				}
				if($_POST['status'] == 17){
					$data 				= array(
												'tm_brand_user_id' 		=> $_POST['user_id'],
												'tm_brand_customer_id'  => $_POST['brand_customer_id'],
												'tm_brand_name'   		=> $brand_name,
												'tm_brand_user_phone'   => $_POST['user_phone'],
												'tm_brand_id'   		=> $_POST['brand_id'],
												'tm_interaction'		=> 'Product Upgrade Escalation',
												'tm_interaction_type'	=> 11,
												'tm_agent_comment'		=> $_POST['last_call_comment'],
												'tm_movement_from'		=> $existing_category,
												'tm_movement_to'		=> $selling_customer_category,
												'tm_created_date'		=> date('Y-m-d')
												);
					$timeline_response 	= $control->insert_timeline_data($data);
					
					foreach($sliced_arr as $key1=>$value1){
						$pfl_data 							= array();
						$value_split						= explode("_",$value1);
						$pfl_data['ph_qid']					= end(explode("_",$key1));
						$pfl_data['ph_answer']				= $value_split[0];
						$pfl_data['ph_weightage']			= $value_split[1];
						$pfl_data['ph_timeline_id']			= $timeline_response;
						$pfl_data['ph_user_id']				= $_POST['user_id'];
						$pfl_data['ph_brand_id']			= $_POST['brand_id'];
						$pfl_data['ph_user_phone']			= $_POST['user_phone'];
						$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
						$pfl_data['ph_brand_name']  		= $brand_name;
						$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
						$pfl_data['ph_email']				= $brand_details['email'];
						$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
						$pfl_data1[] 						= $pfl_data;	
						
						$ph_response						= $control->insert_profile_history($pfl_data);
					}
					
				}
				if($_POST['status'] == 18){
					$data 				= array(
												'tm_brand_user_id' 		=> $_POST['user_id'],
												'tm_brand_customer_id'  => $_POST['brand_customer_id'],
												'tm_brand_name'   		=> $brand_name,
												'tm_brand_user_phone'   => $_POST['user_phone'],
												'tm_brand_id'   		=> $_POST['brand_id'],
												'tm_interaction'		=> 'Service Provider Escalation',
												'tm_interaction_type'	=> 12,
												'tm_agent_comment'		=> $_POST['last_call_comment'],
												'tm_movement_from'		=> $existing_category,
												'tm_movement_to'		=> $selling_customer_category,
												'tm_created_date'		=> date('Y-m-d')
												);
					$timeline_response 	= $control->insert_timeline_data($data);
					
					foreach($sliced_arr as $key1=>$value1){
						$pfl_data 							= array();
						$value_split						= explode("_",$value1);
						$pfl_data['ph_qid']					= end(explode("_",$key1));
						$pfl_data['ph_answer']				= $value_split[0];
						$pfl_data['ph_weightage']			= $value_split[1];
						$pfl_data['ph_timeline_id']			= $timeline_response;
						$pfl_data['ph_user_id']				= $_POST['user_id'];
						$pfl_data['ph_brand_id']			= $_POST['brand_id'];
						$pfl_data['ph_user_phone']			= $_POST['user_phone'];
						$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
						$pfl_data['ph_brand_name']  		= $brand_name;
						$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
						$pfl_data['ph_email']				= $brand_details['email'];
						$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
						$pfl_data1[] 						= $pfl_data;	
						
						$ph_response						= $control->insert_profile_history($pfl_data);
					}
					
				}
			
			}
			
			if($_POST['status'] == 10){
				$message 			= 'Sorry to hear that you have changed your product. To maintain the product use Yapnaa.';
				$msg_response 		= $control->send_lifecycle_sms($brand_details['PHONE1'],$message);
				
				$data 				= array(
											'tm_brand_user_id' 		=> $_POST['user_id'],
											'tm_brand_customer_id'  => $_POST['brand_customer_id'],
											'tm_brand_name'   		=> $brand_name,
											'tm_brand_user_phone'   => $_POST['user_phone'],
											'tm_brand_id'   		=> $_POST['brand_id'],
											'tm_interaction'		=> 'Change Product',
											'tm_interaction_type'	=> 4,
											'tm_movement_from'		=> $existing_category,
											'tm_movement_to'		=> $selling_customer_category,
											'tm_created_date'		=> date('Y-m-d')
											);
				$timeline_response 	= $control->insert_timeline_data($data);
				
				foreach($sliced_arr as $key1=>$value1){
					$pfl_data 							= array();
					$value_split						= explode("_",$value1);
					$pfl_data['ph_qid']					= end(explode("_",$key1));
					$pfl_data['ph_answer']				= $value_split[0];
					$pfl_data['ph_weightage']			= $value_split[1];
					$pfl_data['ph_timeline_id']			= $timeline_response;
					$pfl_data['ph_user_id']				= $_POST['user_id'];
					$pfl_data['ph_brand_id']			= $_POST['brand_id'];
					$pfl_data['ph_user_phone']			= $_POST['user_phone'];
					$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
					$pfl_data['ph_brand_name']  		= $brand_name;
					$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
					$pfl_data['ph_email']				= $brand_details['email'];
					$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
					$pfl_data1[] 						= $pfl_data;	
					
					$ph_response						= $control->insert_profile_history($pfl_data);
				}
					
			}
			
			if($_POST['status'] == 1){ // Need to be add after sattus updated
				$data 				= array(
											'tm_brand_user_id' 		=> $_POST['user_id'],
											'tm_brand_customer_id'  => $_POST['brand_customer_id'],
											'tm_brand_name'   		=> $brand_name,
											'tm_brand_user_phone'   => $_POST['user_phone'],
											'tm_brand_id'   		=> $_POST['brand_id'],
											'tm_interaction'		=> 'Callback',
											'tm_interaction_type'	=> 2,
											'tm_transaction_date'	=> $_POST['req_follow_up_date'],
											'tm_transaction_type'	=> 'Follow up date',
											'tm_movement_from'		=> $existing_category,
											'tm_movement_to'		=> $selling_customer_category,
											'tm_created_date'		=> date('Y-m-d')
											);
				$timeline_response 	= $control->insert_timeline_data($data);
				
				foreach($sliced_arr as $key1=>$value1){
					$pfl_data 							= array();
					$value_split						= explode("_",$value1);
					$pfl_data['ph_qid']					= end(explode("_",$key1));
					$pfl_data['ph_answer']				= $value_split[0];
					$pfl_data['ph_weightage']			= $value_split[1];
					$pfl_data['ph_timeline_id']			= $timeline_response;
					$pfl_data['ph_user_id']				= $_POST['user_id'];
					$pfl_data['ph_brand_id']			= $_POST['brand_id'];
					$pfl_data['ph_user_phone']			= $_POST['user_phone'];
					$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
					$pfl_data['ph_brand_name']  		= $brand_name;
					$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
					$pfl_data['ph_email']				= $brand_details['email'];
					$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
					$pfl_data1[] 						= $pfl_data;	
					
					$ph_response						= $control->insert_profile_history($pfl_data);
				}
				
			}
			
			if($_POST['status'] == 2){
				$data 				= array(
											'tm_brand_user_id' 		=> $_POST['user_id'],
											'tm_brand_customer_id'  => $_POST['brand_customer_id'],
											'tm_brand_name'   		=> $brand_name,
											'tm_brand_user_phone'   => $_POST['user_phone'],
											'tm_brand_id'   		=> $_POST['brand_id'],
											'tm_interaction'		=> 'Not interested in Service',
											'tm_interaction_type'	=> 3,
											'tm_movement_from'		=> $existing_category,
											'tm_movement_to'		=> $selling_customer_category,
											'tm_created_date'		=> date('Y-m-d')
											);
				$timeline_response 	= $control->insert_timeline_data($data);
				
				foreach($sliced_arr as $key1=>$value1){
					$pfl_data 							= array();
					$value_split						= explode("_",$value1);
					$pfl_data['ph_qid']					= end(explode("_",$key1));
					$pfl_data['ph_answer']				= $value_split[0];
					$pfl_data['ph_weightage']			= $value_split[1];
					$pfl_data['ph_timeline_id']			= $timeline_response;
					$pfl_data['ph_user_id']				= $_POST['user_id'];
					$pfl_data['ph_brand_id']			= $_POST['brand_id'];
					$pfl_data['ph_user_phone']			= $_POST['user_phone'];
					$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
					$pfl_data['ph_brand_name']  		= $brand_name;
					$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
					$pfl_data['ph_email']				= $brand_details['email'];
					$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
					$pfl_data1[] 						= $pfl_data;	
					
					$ph_response						= $control->insert_profile_history($pfl_data);
				}
				
			}
			
			if($_POST['status'] == 11){ 
				$data 				= array(
											'tm_brand_user_id' 		=> $_POST['user_id'],
											'tm_brand_customer_id'  => $_POST['brand_customer_id'],
											'tm_brand_name'   		=> $brand_name,
											'tm_brand_user_phone'   => $_POST['user_phone'],
											'tm_brand_id'   		=> $_POST['brand_id'],
											'tm_interaction'		=> 'Change Service Provider',
											'tm_interaction_type'	=> 5,
											'tm_movement_from'		=> $existing_category,
											'tm_movement_to'		=> $selling_customer_category,
											'tm_created_date'		=> date('Y-m-d')
											);
				$timeline_response 	= $control->insert_timeline_data($data);
				
				foreach($sliced_arr as $key1=>$value1){
					$pfl_data 							= array();
					$value_split						= explode("_",$value1);
					$pfl_data['ph_qid']					= end(explode("_",$key1));
					$pfl_data['ph_answer']				= $value_split[0];
					$pfl_data['ph_weightage']			= $value_split[1];
					$pfl_data['ph_timeline_id']			= $timeline_response;
					$pfl_data['ph_user_id']				= $_POST['user_id'];
					$pfl_data['ph_brand_id']			= $_POST['brand_id'];
					$pfl_data['ph_user_phone']			= $_POST['user_phone'];
					$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
					$pfl_data['ph_brand_name']  		= $brand_name;
					$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
					$pfl_data['ph_email']				= $brand_details['email'];
					$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
					$pfl_data1[] 						= $pfl_data;	
					
					$ph_response						= $control->insert_profile_history($pfl_data);
				}
				
			}
			
			if($_POST['status'] == 12){ 
				$data 				= array(
											'tm_brand_user_id' 		=> $_POST['user_id'],
											'tm_brand_customer_id'  => $_POST['brand_customer_id'],
											'tm_brand_name'   		=> $brand_name,
											'tm_brand_user_phone'   => $_POST['user_phone'],
											'tm_brand_id'   		=> $_POST['brand_id'],
											'tm_interaction'		=> 'No Response',
											'tm_interaction_type'	=> 6,
											'tm_movement_from'		=> $existing_category,
											'tm_movement_to'		=> $selling_customer_category,
											'tm_created_date'		=> date('Y-m-d')
											);
				$timeline_response 	= $control->insert_timeline_data($data);
				
				foreach($sliced_arr as $key1=>$value1){
					$pfl_data 							= array();
					$value_split						= explode("_",$value1);
					$pfl_data['ph_qid']					= end(explode("_",$key1));
					$pfl_data['ph_answer']				= $value_split[0];
					$pfl_data['ph_weightage']			= $value_split[1];
					$pfl_data['ph_timeline_id']			= $timeline_response;
					$pfl_data['ph_user_id']				= $_POST['user_id'];
					$pfl_data['ph_brand_id']			= $_POST['brand_id'];
					$pfl_data['ph_user_phone']			= $_POST['user_phone'];
					$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
					$pfl_data['ph_brand_name']  		= $brand_name;
					$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
					$pfl_data['ph_email']				= $brand_details['email'];
					$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
					$pfl_data1[] 						= $pfl_data;	
					
					$ph_response						= $control->insert_profile_history($pfl_data);
				}
				
			}
			
			if($_POST['status'] == 13){
				$data 				= array(
											'tm_brand_user_id' 		=> $_POST['user_id'],
											'tm_brand_customer_id'  => $_POST['brand_customer_id'],
											'tm_brand_name'   		=> $brand_name,
											'tm_brand_user_phone'   => $_POST['user_phone'],
											'tm_brand_id'   		=> $_POST['brand_id'],
											'tm_interaction'		=> 'Not reachable',
											'tm_interaction_type'	=> 7,
											'tm_movement_from'		=> $existing_category,
											'tm_movement_to'		=> $selling_customer_category,
											'tm_created_date'		=> date('Y-m-d')
											);
				$timeline_response 	= $control->insert_timeline_data($data);
				
				foreach($sliced_arr as $key1=>$value1){
					$pfl_data 							= array();
					$value_split						= explode("_",$value1);
					$pfl_data['ph_qid']					= end(explode("_",$key1));
					$pfl_data['ph_answer']				= $value_split[0];
					$pfl_data['ph_weightage']			= $value_split[1];
					$pfl_data['ph_timeline_id']			= $timeline_response;
					$pfl_data['ph_user_id']				= $_POST['user_id'];
					$pfl_data['ph_brand_id']			= $_POST['brand_id'];
					$pfl_data['ph_user_phone']			= $_POST['user_phone'];
					$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
					$pfl_data['ph_brand_name']  		= $brand_name;
					$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
					$pfl_data['ph_email']				= $brand_details['email'];
					$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
					$pfl_data1[] 						= $pfl_data;	
					
					$ph_response						= $control->insert_profile_history($pfl_data);
				}
				
			}
			
			if($_POST['status'] == 14){ 
				$data 				= array(
											'tm_brand_user_id' 		=> $_POST['user_id'],
											'tm_brand_customer_id'  => $_POST['brand_customer_id'],
											'tm_brand_name'   		=> $brand_name,
											'tm_brand_user_phone'   => $_POST['user_phone'],
											'tm_brand_id'   		=> $_POST['brand_id'],
											'tm_interaction'		=> 'To be contacted',
											'tm_interaction_type'	=> 8,
											'tm_transaction_date'	=> $_POST['req_follow_up_date'],
											'tm_transaction_type'	=> 'Follow up date',
											'tm_movement_from'		=> $existing_category,
											'tm_movement_to'		=> $selling_customer_category,
											'tm_created_date'		=> date('Y-m-d')
											);
				$timeline_response 	= $control->insert_timeline_data($data);
				
				foreach($sliced_arr as $key1=>$value1){
					$pfl_data 							= array();
					$value_split						= explode("_",$value1);
					$pfl_data['ph_qid']					= end(explode("_",$key1));
					$pfl_data['ph_answer']				= $value_split[0];
					$pfl_data['ph_weightage']			= $value_split[1];
					$pfl_data['ph_timeline_id']			= $timeline_response;
					$pfl_data['ph_user_id']				= $_POST['user_id'];
					$pfl_data['ph_brand_id']			= $_POST['brand_id'];
					$pfl_data['ph_user_phone']			= $_POST['user_phone'];
					$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
					$pfl_data['ph_brand_name']  		= $brand_name;
					$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
					$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
					$pfl_data['ph_email']				= $brand_details['email'];
					$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
					$pfl_data1[] 						= $pfl_data;	
					
					$ph_response						= $control->insert_profile_history($pfl_data);
				}
				
			}
			
			if($_POST['status'] == 15){
				if(!empty($_POST['req_service_date']) ){
					$data 				= array(
												'tm_brand_user_id' 		=> $_POST['user_id'],
												'tm_brand_customer_id'  => $_POST['brand_customer_id'],
												'tm_brand_name'   		=> $brand_name,
												'tm_brand_user_phone'   => $_POST['user_phone'],
												'tm_brand_id'   		=> $_POST['brand_id'],
												'tm_interaction'		=> 'Interested in Service',
												'tm_interaction_type'	=> 9,
												'tm_transaction_date'	=> $_POST['req_service_date'],
												'tm_transaction_type'	=> 'Service Date Request',
												'tm_movement_from'		=> $existing_category,
												'tm_movement_to'		=> $selling_customer_category,
												'tm_created_date'		=> date('Y-m-d')
												);
					$timeline_response 	= $control->insert_timeline_data($data);						
					
					foreach($sliced_arr as $key1=>$value1){
						$pfl_data 							= array();
						$value_split						= explode("_",$value1);
						$pfl_data['ph_qid']					= end(explode("_",$key1));
						$pfl_data['ph_answer']				= $value_split[0];
						$pfl_data['ph_weightage']			= $value_split[1];
						$pfl_data['ph_timeline_id']			= $timeline_response;
						$pfl_data['ph_user_id']				= $_POST['user_id'];
						$pfl_data['ph_brand_id']			= $_POST['brand_id'];
						$pfl_data['ph_user_phone']			= $_POST['user_phone'];
						$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
						$pfl_data['ph_brand_name']  		= $brand_name;
						$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
						$pfl_data['ph_email']				= $brand_details['email'];
						$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
						$pfl_data1[] 						= $pfl_data;	
						
						$ph_response						= $control->insert_profile_history($pfl_data);
					}
				
				}
				if(!empty($_POST['req_amc_date']) ){
					$data 				= array(
												'tm_brand_user_id' 		=> $_POST['user_id'],
												'tm_brand_customer_id'  => $_POST['brand_customer_id'],
												'tm_brand_name'   		=> $brand_name,
												'tm_brand_user_phone'   => $_POST['user_phone'],
												'tm_brand_id'   		=> $_POST['brand_id'],
												'tm_interaction'		=> 'Interested in Service',
												'tm_interaction_type'	=> 9,
												'tm_transaction_date'	=> $_POST['req_amc_date'],
												'tm_transaction_type'	=> 'AMC Date Request',
												'tm_movement_from'		=> $existing_category,
												'tm_movement_to'		=> $selling_customer_category,
												'tm_created_date'		=> date('Y-m-d')
												);
					$timeline_response 	= $control->insert_timeline_data($data);
					
					foreach($sliced_arr as $key1=>$value1){
						$pfl_data 							= array();
						$value_split						= explode("_",$value1);
						$pfl_data['ph_qid']					= end(explode("_",$key1));
						$pfl_data['ph_answer']				= $value_split[0];
						$pfl_data['ph_weightage']			= $value_split[1];
						$pfl_data['ph_timeline_id']			= $timeline_response;
						$pfl_data['ph_user_id']				= $_POST['user_id'];
						$pfl_data['ph_brand_id']			= $_POST['brand_id'];
						$pfl_data['ph_user_phone']			= $_POST['user_phone'];
						$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
						$pfl_data['ph_brand_name']  		= $brand_name;
						$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
						$pfl_data['ph_email']				= $brand_details['email'];
						$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
						$pfl_data1[] 						= $pfl_data;	
						
						$ph_response						= $control->insert_profile_history($pfl_data);
					}
				
				}
				if(!empty($_POST['req_upgrade_date']) ){
					$data 				= array(
												'tm_brand_user_id' 		=> $_POST['user_id'],
												'tm_brand_customer_id'  => $_POST['brand_customer_id'],
												'tm_brand_name'   		=> $brand_name,
												'tm_brand_user_phone'   => $_POST['user_phone'],
												'tm_brand_id'   		=> $_POST['brand_id'],
												'tm_interaction'		=> 'Interested in Service',
												'tm_interaction_type'	=> 9,
												'tm_transaction_date'	=> $_POST['req_upgrade_date'],
												'tm_transaction_type'	=> 'Upgrade Date Rquest',
												'tm_movement_from'		=> $existing_category,
												'tm_movement_to'		=> $selling_customer_category,
												'tm_created_date'		=> date('Y-m-d')
												);
					$timeline_response 	= $control->insert_timeline_data($data);
					
					foreach($sliced_arr as $key1=>$value1){
						$pfl_data 							= array();
						$value_split						= explode("_",$value1);
						$pfl_data['ph_qid']					= end(explode("_",$key1));
						$pfl_data['ph_answer']				= $value_split[0];
						$pfl_data['ph_weightage']			= $value_split[1];
						$pfl_data['ph_timeline_id']			= $timeline_response;
						$pfl_data['ph_user_id']				= $_POST['user_id'];
						$pfl_data['ph_brand_id']			= $_POST['brand_id'];
						$pfl_data['ph_user_phone']			= $_POST['user_phone'];
						$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
						$pfl_data['ph_brand_name']  		= $brand_name;
						$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
						$pfl_data['ph_email']				= $brand_details['email'];
						$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
						$pfl_data1[] 						= $pfl_data;	
						
						$ph_response						= $control->insert_profile_history($pfl_data);
					}
				
				}
				if(!empty($_POST['req_consumable_date']) ){
					$data 				= array(
												'tm_brand_user_id' 		=> $_POST['user_id'],
												'tm_brand_customer_id'  => $_POST['brand_customer_id'],
												'tm_brand_name'   		=> $brand_name,
												'tm_brand_user_phone'   => $_POST['user_phone'],
												'tm_brand_id'   		=> $_POST['brand_id'],
												'tm_interaction'		=> 'Interested in Service',
												'tm_interaction_type'	=> 9,
												'tm_transaction_date'	=> $_POST['req_consumable_date'],
												'tm_transaction_type'	=> 'Consumable Date Request',
												'tm_movement_from'		=> $existing_category,
												'tm_movement_to'		=> $selling_customer_category,
												'tm_created_date'		=> date('Y-m-d')
												);		
					$timeline_response 	= $control->insert_timeline_data($data);
					
					foreach($sliced_arr as $key1=>$value1){
						$pfl_data 							= array();
						$value_split						= explode("_",$value1);
						$pfl_data['ph_qid']					= end(explode("_",$key1));
						$pfl_data['ph_answer']				= $value_split[0];
						$pfl_data['ph_weightage']			= $value_split[1];
						$pfl_data['ph_timeline_id']			= $timeline_response;
						$pfl_data['ph_user_id']				= $_POST['user_id'];
						$pfl_data['ph_brand_id']			= $_POST['brand_id'];
						$pfl_data['ph_user_phone']			= $_POST['user_phone'];
						$pfl_data['ph_brand_customer_id']  	= $_POST['brand_customer_id'];
						$pfl_data['ph_brand_name']  		= $brand_name;
						$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
						$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
						$pfl_data['ph_email']				= $brand_details['email'];
						$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
						$pfl_data1[] 						= $pfl_data;	
						
						$ph_response						= $control->insert_profile_history($pfl_data);
					}
				
				}
			}
			
			// Update Profile-Type in Brand Table
			$set_array_brand = array('profile_type' => $selling_customer_category);
			$response2  = $control->updateProfileInBrand($brand_name,$set_array_brand,$_POST['brand_customer_id'],$_POST['user_id']);
		
		}

		if($response || $response1 == 1){
			$_POST = array();
			echo "<script>alert('Updated successfully');</script>";
		}
		else{
			$_POST = array();
			echo "<script>alert('Something went wrong');</script>";
		}
		
	}
		
	// Update AMC datas
	if(isset($_POST['addAMCSubmit'])){
		//echo "<br><pre>";print_r($_POST);die;
		if(empty($_POST['newAMCStart'])){
			$_POST['newAMCStart'] 	= '';
		}
		if(empty($_POST['newAMCEnd'])){
			$_POST['newAMCEnd'] 	= '';
		}
		/*if($_POST['closedBy'] == 'Yapnaa'){
			$helper_response		= $helper->send_transaction_sms($_GET['user_phone']);
		}*/
		switch($_GET['customer_type']){
			case 1:
			$table='livpure';
			break;
			case 2:
			$table='zerob_consol1';
			break;
			case 3:
			$table='livpure_tn_kl';
			break;
			case 4:
			$table='bluestar_b2b';
			break;
			case 5:
			$table='bluestar_b2c';
			break;
		}
		
		$get_amc_list 			= $control->updateAmcData($table,$_SESSION['admin_email_id'],$_POST['newAMCStart'],$_POST['newAMCEnd'],$_POST['userid'],$_POST['comments'],$_POST['closedBy']);
		
		$existing_profile_status		 	= $control->get_existing_profile_status_of_customer($table,$_POST['userid']);
		$existing_category  	 			= $existing_profile_status['profile_type'];
		
		if($get_amc_list && !empty($_POST['newAMCStart']) ){
			$data 				= array(
										'tm_brand_user_id' 		=> $_POST['userid'],
										'tm_brand_customer_id'  => $_GET['brand_customer_id'],
										'tm_brand_name'   		=> $table,
										'tm_brand_user_phone'   => $_GET['user_phone'],
										'tm_brand_id'   		=> $_GET['customer_type'],
										'tm_interaction'		=> 'AMC update',
										'tm_interaction_type'	=> 18,
										'tm_transaction_date'	=> $_POST['newAMCStart'],
										'tm_transaction_type'	=> 'AMC Start Date',
										'tm_movement_from'		=> $existing_category,
										'tm_movement_to'		=> $existing_category,
										'tm_created_date'		=> date('Y-m-d')
										);
			$timeline_response 	= $control->insert_timeline_data($data);
		}
		
		if($get_amc_list && !empty($_POST['closedBy']) && $_POST['closedBy'] == 'Yapnaa'){
			$data 				= array(
										'tm_brand_user_id' 		=> $_POST['userid'],
										'tm_brand_customer_id'  => $_GET['brand_customer_id'],
										'tm_brand_name'   		=> $table,
										'tm_brand_user_phone'   => $_GET['user_phone'],
										'tm_brand_id'   		=> $_GET['customer_type'],
										'tm_interaction'		=> 'Purchased With yapnaa',
										'tm_interaction_type'	=> 19,
										'tm_movement_from'		=> $existing_category,
										'tm_movement_to'		=> $existing_category,
										'tm_created_date'		=> date('Y-m-d')
										);
			$timeline_response 	= $control->insert_timeline_data($data);
		}
		
		if($get_amc_list && !empty($_POST['closedBy']) && $_POST['closedBy'] == 'Others'){
			$data 				= array(
										'tm_brand_user_id' 		=> $_POST['userid'],
										'tm_brand_customer_id'  => $_GET['brand_customer_id'],
										'tm_brand_name'   		=> $table,
										'tm_brand_user_phone'   => $_GET['user_phone'],
										'tm_brand_id'   		=> $_GET['customer_type'],
										'tm_interaction'		=> 'Purchased with Brand',
										'tm_interaction_type'	=> 20,
										'tm_movement_from'		=> $existing_category,
										'tm_movement_to'		=> $existing_category,
										'tm_created_date'		=> date('Y-m-d')
										);
			$timeline_response 	= $control->insert_timeline_data($data);
		}	
		
		if($get_amc_list){
			$_POST = array();
			echo "<script>alert('Updated successfully');</script>";
		}
		else{
			$_POST = array();
			echo "<script>alert('Something went wrong');</script>";
		}
	}	
	
	$std_comments = $control->get_standard_comments();
	
?>


<!--  NEW DESIGN BY SUMAN  -->

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movilo | Dashboard</title>
	
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="css/plugins/iCheck/custom.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	<!-- <link href="css/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css" rel="stylesheet"> -->
	<link href="css/custom.css" rel="stylesheet">

	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
	
	<style>

		h3 {font-size: 12px;}
		
		body {font-size: 11px;}
		
		.b-t {margin-top: 0px;}
		
		.form-check-input {
			margin: 4px 0 0;
			line-height: normal;
			display: inline !important;
		}
		
		.form-check {
			margin-top: 10px;
		}
		
	</style>
	
</head>

<body>
	<div class="animated fadeInRight">
		<div class="row">
			<div class="col-lg-12" style="padding-left: 0px;padding-right: 0px;">
				<div class="ibox float-e-margins">
				
					<div class="ibox-title" style="background: #243747;border-color: #243747;">
						<div class="container-fluid">
							<h5><span class="ibox-title-logo"> <?php if(!empty($brand_details['flname'])){echo $brand_details['flname'];} ?> </span> <?php if(!empty($brand_details['CUSTOMER_NAME'])){echo $brand_details['CUSTOMER_NAME'];} ?></h5>	
							<div class="brand-logo">
								<!-- <img src="images/brand-logo.svg" class="img-wdth" alt="Kiwi standing on oval"/> -->
								<div class="ibox-tools">
									<a class="collapse-link">Customer details <i class="fa fa-chevron-up"></i></a>
								</div>
							</div>							
						</div>						
					</div>

					<div class="ibox-content" style="background: rgb(47, 64, 80);border-color: rgb(47, 64, 80);padding: 45px;">
						<div class="container">
							<div class="row">
								<div class="col-lg-8 col-sm-8">
									<div class="row">
										<div class="col-sm-6">
											<div class="row dis-in-flex">
												<div class="col-1 col-lg-1"><i class="fa fa-tag ibox-icon"></i></div>
												<div class="col-11 col-lg-11 col-sm-11 col-xs-11">
													<h3 class="m-t-none m-b"> <?php if(!empty($brand_details['PRODUCT'])){echo $brand_details['PRODUCT'];} else{echo "No Product";} ?> </h3>
												</div>														
											</div>
										</div>									
										<div class="col-sm-6">
											<div class="row dis-in-flex">
												<div class="col-lg-1"><i class="fa fa-phone ibox-icon"></i></div>
												<div class="col-lg-11">
													<h3 class="m-t-none m-b"><?php if(!empty($brand_details['PHONE1'])){echo $brand_details['PHONE1'];} else{echo "No Phone";} ?></h3>
												</div>														
											</div>											
										</div>									
									</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="row dis-in-flex">
												<div class="col-lg-1"><i class="fa  fa-address-card-o ibox-icon"></i></div>
												<div class="col-lg-11">
													<h3 class="m-t-none m-b"> <?php if(!empty($brand_details['PRODUCT_SLNO'])){echo $brand_details['PRODUCT_SLNO'];} else{echo "No Product";} ?></h3>
												</div>														
											</div>											
										</div>									
										<div class="col-sm-6">
											<div class="row dis-in-flex">
												<div class="col-lg-1"><i class="fa fa-envelope-o ibox-icon"></i></div>
												<div class="col-lg-11">
													<h3 class="m-t-none m-b"> <?php if(!empty($brand_details['email'])){echo $brand_details['email'];} else{echo "No Email";} ?></h3>
												</div>														
											</div>
										</div>									
									</div>									
								</div>
								
								<div class="col-lg-4 col-sm-4">
									<div class="row">
										<div class="col-sm-6">
											<div class="row dis-in-flex">
												<div class="col-lg-1"><i class="fa fa-map-marker ibox-icon"></i></div>
												<div class="col-lg-11">
													<h3 class="m-t-none m-b"> <?php if(!empty($brand_details['CUSTOMER_AREA'])){echo $brand_details['CUSTOMER_AREA'];} else{echo "No Address";} ?></h3>
												</div>														
											</div>											
										</div>
									</div>	
									<div class="row">	
										<div class="col-sm-6">
											<div class="row dis-in-flex" data-toggle="modal" data-target="#profiledetails">
												<div class="col-lg-1"><i class="fa fa-user-circle" style="color: white;font-size: 20px;" ></i>
												</div>
												<div class="col-lg-11">
													<h3 class="m-t-none m-b">Profile</h3>
												</div>
											</div>
										</div>
									</div>	
								</div>	
								
							</div>
						</div>
					</div>
				
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<!-- Nav tabs -->
				<div class="card">
					<ul class="nav nav-tabs" role="tablist">
						<li role="presentation" class="active pd-t-13 pd-rt-10"><a href="#responses" aria-controls="responses" role="tab" data-toggle="tab">Responses</a></li>
						<li role="presentation" class=" pd-t-13 pd-rt-10"><a href="#timeline" aria-controls="timeline" role="tab" data-toggle="tab">Timeline</a></li>
						<li role="presentation" class=" pd-t-13"><a href="#addamc" aria-controls="timeline" role="tab" data-toggle="tab">Transaction</a></li>
					</ul>
					<!-- Tab panes -->
					<div class="tab-content">
						
						<div role="tabpanel" class="tab-pane active" id="responses">										
							<div class="row">
								<div class="col-lg-12">
									<form action="" name="question_answer_form" id="question_answer_form" method="POST">
										<div class="row">
											<?php foreach($group_subgroup_result as $key => $value){ ?>
												<div class="col-lg-4 col-sm-4 b-r">
													
													<div class="row">
														<div class="col-2 col-lg-2 col-md-2 col-sm-2 col-xs-2">
															<img src="images/customer-satisfaction.svg" class="img-responsive" alt="cust"/>
														</div>
														<div class="col-10 col-lg-10 col-md-10 col-sm-10 col-xs-10">
															<h3><?php echo $key; ?></h3>
														</div>														
													</div>
													
													<?php foreach($value as $key1 => $value1){ ?>
															
														<div class="col-lg-12" style="margin-top: 35px;">
															<label class="question-tag"><?php echo $key1; ?></label>
														</div>
														
														<?php foreach($value1 as $key2 => $value2){ ?>
														
														<div class="row b-t">
															<div class="col-lg-12">	
																<h3><?php echo $key2+1;?><?php echo ".";?> <?php echo $value2['qa_question'] ?></h3>
															</div>
															<div class="col-lg-12">
																<div class="row">
																	<?php if(!empty($value2['qa_answer1'])) { ?>
																	<div class="col-md-6">
																		<div class="form-check">
																			<label>
																				<input type="radio" value="answer1_<?php echo $value2['qa_answer1_weightage'];?>" name="qid_<?php echo $value2['qa_id'];?>"
																				<?php 
																				echo !empty($value2["answer_weightage"])?(($value2["answer_weightage"]=="qa_answer1")?"checked":""):"";
																				?> > 
																				<span id="sansq1" class="label-text"><?php echo $value2['qa_answer1']; ?></span>
																			</label>
																		</div>														
																	</div>
																	<?php } ?>
																	
																	<?php if(!empty($value2['qa_answer2'])) { ?>
																	<div class="col-md-6">
																		<div class="form-check">
																			<label>
																				<input type="radio" value="answer2_<?php echo $value2['qa_answer2_weightage'];?>" name="qid_<?php echo $value2['qa_id'];?>"
																				<?php 
																				echo !empty($value2["answer_weightage"])?(($value2["answer_weightage"]=="qa_answer2")?"checked":""):"";
																				?> > 
																				<span id="sansq1" class="label-text"><?php echo $value2['qa_answer2']; ?></span>
																			</label>
																		</div>														
																	</div>
																	<?php } ?>
																	
																	<?php if(!empty($value2['qa_answer3'])) { ?>
																	<div class="col-md-6">
																		<div class="form-check">
																			<label>
																				<input type="radio" value="answer3_<?php echo $value2['qa_answer3_weightage'];?>" name="qid_<?php echo $value2['qa_id'];?>"
																				<?php 
																				echo !empty($value2["answer_weightage"])?(($value2["answer_weightage"]=="qa_answer3")?"checked":""):"";
																				?> > 
																				<span id="sansq1" class="label-text"><?php echo $value2['qa_answer3']; ?></span>
																			</label>
																		</div>														
																	</div>
																	<?php } ?>
																	
																	<?php if(!empty($value2['qa_answer4'])) { ?>
																	<div class="col-md-6">
																		<div class="form-check">
																			<label>
																				<input type="radio" value="answer4_<?php echo $value2['qa_answer4_weightage'];?>" name="qid_<?php echo $value2['qa_id'];?>"
																				<?php 
																				echo !empty($value2["answer_weightage"])?(($value2["answer_weightage"]=="qa_answer4")?"checked":""):"";
																				?> > 
																				<span id="sansq1" class="label-text"><?php echo $value2['qa_answer4']; ?></span>
																			</label>
																		</div>														
																	</div>
																	<?php } ?>
																	
																	<?php if(!empty($value2['qa_answer5'])) { ?>
																	<div class="col-md-6">
																		<div class="form-check">
																			<label>
																				<input type="radio" value="answer5_<?php echo $value2['qa_answer5_weightage'];?>" name="qid_<?php echo $value2['qa_id'];?>"
																				<?php 
																				echo !empty($value2["answer_weightage"])?(($value2["answer_weightage"]=="qa_answer5")?"checked":""):"";
																				?> > 
																				<span id="sansq1" class="label-text"><?php echo $value2['qa_answer5']; ?></span>
																			</label>
																		</div>														
																	</div>
																	<?php } ?>
																																
																</div>
															</div>														
														</div>
														
														<?php } ?>
														
													<?php } ?>
													
												</div>
											<?php } ?>
										</div>
										
										<input type="hidden" name="brand_id" value="<?php echo $_GET['customer_type'];?>" />
										<input type="hidden" name="user_phone" value="<?php echo $_GET['user_phone'];?>" />
										<input type="hidden" name="user_id" value="<?php echo $_GET['user_id'];?>" />
										<input type="hidden" name="brand_customer_id" value="<?php echo $_GET['brand_customer_id'];?>" />
									
										<div class="row" style="float:right;margin-top: -30%;margin-right: 11%;">
											<div class="form-group">
												<label for="sel1">Select Status:</label>
												<select class="form-control" name="status" id="status">
													<option value="0">Select</option>
													<option value="1" <?php if($brand_details['status'] == 1){echo 'Selected';} ?> >Callback</option>
													<option value="2" <?php if($brand_details['status'] == 2){echo 'Selected';} ?>>Not interested in Service</option>
													<option value="10" <?php if($brand_details['status'] == 10){echo 'Selected';} ?>>Change Product</option>
													<option value="11" <?php if($brand_details['status'] == 11){echo 'Selected';} ?>>Change Service Provider</option>
													<option value="12" <?php if($brand_details['status'] == 12){echo 'Selected';} ?>>No Response</option>
													<option value="13" <?php if($brand_details['status'] == 13){echo 'Selected';} ?>>Not reachable</option>
													<option value="14" <?php if($brand_details['status'] == 14){echo 'Selected';} ?>>To be contacted</option>
													<option value="15" <?php if($brand_details['status'] == 15){echo 'Selected';} ?>>Interested in Service</option>
													<option value="16" <?php if($brand_details['status'] == 16){echo 'Selected';} ?>>AMC Escalation</option>
													<option value="17" <?php if($brand_details['status'] == 17){echo 'Selected';} ?>>Product Escalation</option>
													<option value="18" <?php if($brand_details['status'] == 18){echo 'Selected';} ?>>Service Escalation</option>
												</select>
											</div>
										</div>
										
										<div class="row" id="interested_service_status" style="float:right;margin-top: -24%;margin-right: 9%;">
											
											<div class="form-check">
												<input type="checkbox" class="form-check-input" id="interested_service">
												<label class="form-check-label" for="interested_service">Service</label>
												<div class="inline" style="margin-left: 30px;">
													<input type="date" class="form-control" name="req_service_date" id="service_date">
												</div>
											</div>
											<div class="form-check">
												<input type="checkbox" class="form-check-input" id="interested_amc">
												<label class="form-check-label" for="interested_amc">AMC</label>
												<div class="inline" style="margin-left: 43px;">
													<input type="date" class="form-control" name="req_amc_date" id="amc_date">
												</div>
											</div>
											<div class="form-check">
												<input type="checkbox" class="form-check-input" id="interested_upgrade">
												<label class="form-check-label" for="interested_upgrade">Upgrade</label>
												<div class="inline" style="margin-left: 22px;">
													<input type="date" class="form-control" name="req_upgrade_date" id="upgrade_date">
												</div>
											</div>
											<div class="form-check">
												<input type="checkbox" class="form-check-input" id="interested_consumable">
												<label class="form-check-label" for="interested_consumable">Consumable</label>
												<div class="inline">
													<input type="date" class="form-control" name="req_consumable_date" id="consumable_date">
												</div>
											</div>
											
										</div>
										
										<div class="row" id="callback_service_status" style="float:right;margin-top: -24%;margin-right: 9%;">
											<div class="form-check">
												<input type="checkbox" class="form-check-input" id="interested_followup">
												<label class="form-check-label" for="interested_followup">Follow Up</label>
												<div class="inline" style="margin-left: 30px;">
													<input type="date" class="form-control" name="req_follow_up_date" id="follow_up_date">
												</div>
											</div>
										</div>
										
										<div class="row" id="escalation_service_status" style="float:right;margin-top: -24%;margin-right: 9%;width: 273px;">
											<div class="form-check">
												<label class="form-check-label" for="interested_followup">Comment</label>
												<textarea class="form-control" rows="5" name="last_call_comment" id="comment"></textarea>
											</div>
										</div>
										
										<div class="row text-center" style="margin-top: 20px;margin-bottom: 20px;">
											<input type="submit" id="editAMCSubmit" name="editAMCSubmit" class="btn btn-info" value="Save">	
										</div>
										
									</form>	
								</div>
						
							</div>								
						</div>
																		
						<div class="tab-pane ibox-content" id="timeline">
							<div class="ibox-content" id="ibox-content">
								<div id="vertical-timeline"  class="vertical-container dark-timeline center-orientation">
									<?php if(!empty($timeline_data)) { ?>
										<?php for($i=0;$i<count($timeline_data);$i++){ ?>
										
											<?php if($i%2 == 0) {?>
												
												<div class="vertical-timeline-block dis-in-flex pd-l-5">
													<div class="vertical-timeline-icon">
														<span class="v-t-i-date"><?php echo $timeline_data[$i]['tm_created_date']; ?></span>
													</div>
													
													<?php if($timeline_data[$i]['tm_movement_from'] != $timeline_data[$i]['tm_movement_to']) { ?>
														<div class="vertical-timeline-icon" style="margin-top: 52px;">
															<i class="fa fa-plus-circle" onclick="showProfileHistory(<?php echo $timeline_data[$i]['tm_id'];?>,<?php echo $timeline_data[$i]['tm_brand_user_id'];?>,'<?php echo $timeline_data[$i]['tm_brand_name'];?>');" aria-hidden="true"></i>
														</div>
													<?php } ?>
													
													<span class="lt-arrow" style="left: 446px;">&#10510;</span>
													
													<div class="vertical-timeline-content vertical-timeline-lt bg-green">
														<span class="span-style-lt" style="font-size: 15px;"><?php echo $timeline_data[$i]['tm_interaction']; ?></span>
													</div>
													<div class="vertical-timeline-content-lt">
														<h2><?php echo $timeline_data[$i]['tm_transaction_type']; ?></h2>
														<p style="clear: both;float: left;">Profile from <?php echo $timeline_data[$i]['tm_movement_from']; ?> to <?php echo $timeline_data[$i]['tm_movement_to']; ?></p>
													</div>
												</div>
												
											<?php } else { ?>
											
												<div class="vertical-timeline-block v-t-rt dis-in-flex" style="margin-right: 10px;">
													<div class="vertical-timeline-icon mg-lt-85">
														<span class="v-t-i-date"><?php echo $timeline_data[$i]['tm_created_date']; ?></span>
													</div>	
													
													<?php if($timeline_data[$i]['tm_movement_from'] != $timeline_data[$i]['tm_movement_to']) { ?>
														<div class="vertical-timeline-icon" style="margin-top: 52px;">
															<i class="fa fa-plus-circle" onclick="showProfileHistory(<?php echo $timeline_data[$i]['tm_id'];?>,<?php echo $timeline_data[$i]['tm_brand_user_id'];?>,'<?php echo $timeline_data[$i]['tm_brand_name'];?>');" aria-hidden="true"></i>
														</div>
													<?php } ?>
													
													<span class="rt-arrow">&#8674;</span>
													
													<div class="vertical-timeline-content vertical-timeline-rt bg-yellow" style="width: 110px;">
														<span class="span-style-lt" style="font-size: 15px;"><?php echo $timeline_data[$i]['tm_interaction']; ?></span>
													</div>
													<div class="vertical-timeline-content-rt" style="width: 340px;">
														<h2><?php echo $timeline_data[$i]['tm_transaction_type']; ?></h2>
														<p>Profile from <?php echo $timeline_data[$i]['tm_movement_from']; ?> to <?php echo $timeline_data[$i]['tm_movement_to']; ?></p>																	
													</div>										
												</div>
												
											<?php } ?>
									
										<?php } ?>
									<?php } ?>											
								</div>
							</div>
						</div>
						
						
						<div role="tabpanel" class="tab-pane" id="addamc">										
							<div class="row">
								<form action="" name="add_amc_form" id="add_amc_form" method="POST">
									<div class="row">
										<div class="col-lg-10 col-sm-10" style="margin-left: 8%;">
												
											<div class="row" style="margin-top:5%;margin-bottom:5%;">
												<div class="col-lg-3"><label>New AMC date</label></div>
												<div class="col-lg-3"> 
													<input type="date" class="maincls form-control" id="newAMCStart"  name="newAMCStart" value="<?php if($brand_details['status'] == 7 && !empty($brand_details['CONTRACT_FROM']) ){echo $brand_details['CONTRACT_FROM'];} ?>" />
												</div>
												<div class="col-lg-1"> <label>To</label></div>
												<div class="col-lg-3">
													<input type="date" class="maincls form-control" id="newAMCEnd"  name="newAMCEnd" value="<?php if($brand_details['status'] == 7 && !empty($brand_details['CONTRACT_TO']) ){echo $brand_details['CONTRACT_TO'];} ?>" />
												</div>
											</div>
											
											<div class="row" style="margin-top:5%;margin-bottom:5%;">
												<label>Deal closed by?</label>
												<div class="form-check">
													<label>
														<input type="radio" value="Yapnaa" name="closedBy" 
														<?php 
														echo !empty($brand_details['CONTRACT_BY'])?(($brand_details['CONTRACT_BY']=="Yapnaa")?"checked":""):"";
														?> >
														<span id="sansq1" class="label-text">Yapnaa</span>
													</label>
												</div>
												<div class="form-check">
													<label>
														<input type="radio" value="Others" name="closedBy"
														<?php 
														echo !empty($brand_details['CONTRACT_BY'])?(($brand_details['CONTRACT_BY']=="Others")?"checked":""):"";
														?> >
														<span id="sansq2" class="label-text">By Brand</span>
													</label>
												</div>
												
												<!-- <input type="radio" name="closedBy" value="Yapnaa" checked>Yapnaa
												<input type="radio" name="closedBy" value="Others" >3rd Party -->
												
											</div>
												
											<div class="row" style="margin-top:2%;">
												<i class="fa fa-comments" style="margin-right:1%;"></i><label>Customers Comments:</label></br>
												<textarea rows="5" cols="70" id="comments" name="comments" class="maincls form-control" style="width:82%;" ></textarea>
											</div>
											
											<input type="hidden" class="maincls form-control" id="userid"  name="userid" value="<?php echo $_GET['user_id'];?>" />
											
										</div>
									</div>
									
									<div class="row text-center" style="margin-top: 20px;margin-bottom: 20px;">
										<input type="submit" id="addAMCSubmit" name="addAMCSubmit" class="btn btn-info" value="Save">	
									</div>
									
								</form>	
						
							</div>								
						</div>
						
					</div>
				</div>
			</div>
		</div>
		
	</div>
	
	<!-- Modal -->
	
	<div class="modal fade" id="profiledetails" role="dialog">
		<div class="modal-dialog" style="width: 75%;margin-top:10px;">
			<div class="modal-content" style="height: 770px;">
				<div class="modal-header text-center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title" style="float:left;margin-right: -13%;margin-top: -1%;"> Category : <?php echo $selling_customer_category; ?></h3>
					<h3 class="modal-title" style="float:left;margin-right: -13%;margin-top: 1%;"> Loyality : <?php echo $digital_customer_category; ?></h3>
					<h4 class="modal-title">Profile Details</h4>
					<h3 class="modal-title" style="float:right;margin-right: 5%;margin-top: -2%;"> Name : <?php if(!empty($brand_details['CUSTOMER_NAME'])){echo $brand_details['CUSTOMER_NAME'];} ?></h3>
				</div>
				
				<div class="modal-body">
					<div class="row">
					
						<div class="col-lg-6" style="border-right: 1px solid #e5e5e5;">			
							<h2 style="color:#ff6010;font-weight: 400;font-size: 19px;">Customer Categoty</h2>
							<div>
								<h3 style="display: inline;">Customer Profile:</h3>
								<p style="display: inline;margin-left: 4px;color: #9acd32;font-size: 15px;"><?php echo $selling_customer_category; ?></p>
							</div>
							<div style="margin-top: 6px;display:none;">
								<h3 style="display: inline;">Digital Engagement:</h3>
								<p style="display: inline;margin-left: 4px;"><?php echo $digital_customer_category; ?></p>
							</div>
							
							<h4 style="color:#23c6c8;font-weight: 400;margin-top: 3%;">Contact Details</h4>
							<div><label>Name: </label> <p style="display:inline;"><?php if(!empty($brand_details['CUSTOMER_NAME'])){echo $brand_details['CUSTOMER_NAME'];} ?></p></div>
							<div><label>Mobile: </label> <p style="display:inline;"><?php if(!empty($brand_details['PHONE1'])){echo $brand_details['PHONE1'];} else{echo "No Phone";} ?></p></div>
							<div><label>Email: </label> <p style="display:inline;"><?php if(!empty($brand_details['email'])){echo $brand_details['email'];} else{echo "No Email";} ?></p></div>
							<div><label>Address: </label> <p style="display:inline;"><?php if(!empty($brand_details['CUSTOMER_AREA'])){echo $brand_details['CUSTOMER_AREA'];} else{echo "No Address";} ?></p></div>
							
							</br>
							
							<h4 style="color:#23c6c8;font-weight: 400;">Satisfaction</h4>
							<div>
								<label>Response time: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Satisfaction Index']['Service'][0]['answer_weightage'])){echo $group_subgroup_result['Customer Satisfaction Index']['Service'][0][$group_subgroup_result['Customer Satisfaction Index']['Service'][0]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							<div>
								<label>Quality of Service: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Satisfaction Index']['Service'][1]['answer_weightage'])){echo $group_subgroup_result['Customer Satisfaction Index']['Service'][1][$group_subgroup_result['Customer Satisfaction Index']['Service'][1]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							<div>
								<label>Brand Cummunication : </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Satisfaction Index']['Product'][0]['answer_weightage'])){echo $group_subgroup_result['Customer Satisfaction Index']['Product'][0][$group_subgroup_result['Customer Satisfaction Index']['Product'][0]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							<div>
								<label>Overall Product Experience: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Satisfaction Index']['Product'][1]['answer_weightage'])){echo $group_subgroup_result['Customer Satisfaction Index']['Product'][1][$group_subgroup_result['Customer Satisfaction Index']['Product'][1]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							
							</br>
							
							<h4 style="color:#23c6c8;font-weight: 400;">Purchases</h4>
							<div>
								<label>Installation Date: </label> <p style="display:inline;"><?php if(!empty($brand_details['INSTALLATION_DATE'])){echo $brand_details['INSTALLATION_DATE'];} else {echo 'N/A';} ?></p>
							</div>
							<div>
								<label>Last Service: </label> <p style="display:inline;"><?php if(!empty($brand_details['last_service_date'])){echo $brand_details['last_service_date'];} else {echo 'N/A';} ?></p>
							</div>
							<div>
								<label>AMC Due Date : </label> <p style="display:inline;"><?php if(!empty($brand_details['req_amc_date'])){echo $brand_details['req_amc_date'];} else {echo 'N/A';} ?></p>
							</div>
							<div>
								<label>3rd party Service: </label> <p style="display:inline;"><?php if(!empty($brand_details['CONTRACT_BY'])){echo $brand_details['CONTRACT_BY'];} else {echo 'N/A';} ?></p>
							</div>
							
							</br>
							
							<h2 style="color:#ff6010;font-weight: 400;font-size: 19px;">Life Time Value</h2>
							<div><label>Service Request: </label> <p style="display:inline;">N/A</p></div>
							<div><label>Status: </label> <p style="display:inline;">N/A</p></div>
							<div><label>Escalations: </label> <p style="display:inline;">N/A</p></div>
							<div><label>AMC Enquiry: </label> <p style="display:inline;">N/A</p></div>
							<div><label>New Product Enquiry: </label> <p style="display:inline;">N/A</p></div>
							<div><label>New Product Installation: </label> <p style="display:inline;">N/A</p></div>
							<div><label>Information Request: </label> <p style="display:inline;">N/A</p></div>
							
						</div>
						
						<div class="col-lg-6" style="padding-left: 29px;">			
							<h2 style="color:#ff6010;font-weight: 400;font-size: 19px;">Target Customer Elevation</h2>
							<div>
								<h3 style="display: inline;">Customer Profile:</h3>
								<p style="display: inline;margin-left: 4px;color: #9acd32;font-size: 15px;"><?php echo $selling_target_engagement_level; ?></p>
							</div>
							<div style="margin-top: 6px;display:none;">
								<h3 style="display: inline;">Digital Engagement:</h3>
								<p style="display: inline;margin-left: 4px;"><?php echo $digital_target_engagement_level; ?></p>
							</div>
							
							<h4 style="color:#23c6c8;font-weight: 400;margin-top: 3%;">Recall</h4>
							<div>
								<label>Awareness: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Brand Engagement Index']['Recall'][0]['answer_weightage'])){echo $group_subgroup_result['Customer Brand Engagement Index']['Recall'][0][$group_subgroup_result['Customer Brand Engagement Index']['Recall'][0]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							<div>
								<label>Familiar with offerings: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Brand Engagement Index']['Recall'][1]['answer_weightage'])){echo $group_subgroup_result['Customer Brand Engagement Index']['Recall'][1][$group_subgroup_result['Customer Brand Engagement Index']['Recall'][1]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							
							</br>
							
							<h4 style="color:#23c6c8;font-weight: 400;">Brand loyalty</h4>
							<div>
								<label>Refer: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Brand Engagement Index']['Loyalty'][0]['answer_weightage'])){echo $group_subgroup_result['Customer Brand Engagement Index']['Loyalty'][0][$group_subgroup_result['Customer Brand Engagement Index']['Loyalty'][0]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							<div>
								<label>Purchase intent: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Brand Engagement Index']['Loyalty'][1]['answer_weightage'])){echo $group_subgroup_result['Customer Brand Engagement Index']['Loyalty'][1][$group_subgroup_result['Customer Brand Engagement Index']['Loyalty'][1]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							
							</br>
							
							<h4 style="color:#23c6c8;font-weight: 400;">Additional insight</h4>
							<div>
								<label>Upgrade: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Brand Engagement Index']['Additional Information'][1]['answer_weightage'])){echo $group_subgroup_result['Customer Brand Engagement Index']['Additional Information'][1][$group_subgroup_result['Customer Brand Engagement Index']['Additional Information'][1]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							
							</br>
							
							<h2 style="color:#ff6010;font-weight: 400;font-size: 19px;">Brand Value</h2>
							<div><label>Last Action: </label> <p style="display:inline;">N/A</p></div>
							<div><label>Next Action: </label> <p style="display:inline;">N/A</p></div>
							<div><label>Call count: </label> <p style="display:inline;">N/A</p></div>
							<div><label>SMS count: </label> <p style="display:inline;">N/A</p></div>
							<div><label>Email count: </label> <p style="display:inline;">N/A</p></div>
							<div><label>Enquiry: </label> <p style="display:inline;">N/A</p></div>
							<div><label>Escalation: </label> <p style="display:inline;">N/A</p></div>
							<div><label>Yapnaa registered: </label> <p style="display:inline;">N/A</p></div>
							
						</div>
						
						<div class="col-lg-4" style="padding-left: 29px; display:none;">
							<h2 style="color:#ff6010;font-weight: 400;font-size: 19px;">Yapnaa Loyalty Points</h2><h3></h3>
							
							<h4 style="color:#23c6c8;font-weight: 400;">Referral</h4>
							<div>
								<label>Shares opinion: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Referal Value Index']['Potential'][0]['answer_weightage'])){echo $group_subgroup_result['Customer Referal Value Index']['Potential'][0][$group_subgroup_result['Customer Referal Value Index']['Potential'][0]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							<div>
								<label>Influence: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Referal Value Index']['Potential'][1]['answer_weightage'])){echo $group_subgroup_result['Customer Referal Value Index']['Potential'][1][$group_subgroup_result['Customer Referal Value Index']['Potential'][1]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							<div>
								<label>Referral interest: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Referal Value Index']['Interest'][0]['answer_weightage'])){echo $group_subgroup_result['Customer Referal Value Index']['Interest'][0][$group_subgroup_result['Customer Referal Value Index']['Interest'][0]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
							<div>
								<label>Provides Feedback: </label> <p style="display:inline;"><?php if(!empty($group_subgroup_result['Customer Referal Value Index']['Interest'][1]['answer_weightage'])){echo $group_subgroup_result['Customer Referal Value Index']['Interest'][1][$group_subgroup_result['Customer Referal Value Index']['Interest'][1]['answer_weightage']];} else{echo "No Answer Given";} ?></p>
							</div>
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
	
	<!-- Modal End -->
	
	<!-- Ajax Modal -->
	
	<div class="modal fade" id="profile_history_details" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="width: 75%;margin-top:10px;">
			<div class="modal-content" style="height: 410px;">
				<div class="modal-header text-center">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title" style="float:left;margin-right: -13%;margin-top: -1%;"> Category : <p style="display: inline;" id="category"></p></h3>
					<h3 class="modal-title" style="float:left;margin-right: -13%;margin-top: 1%;"> Loyality : <p style="display: inline;" id="loyality"></h3>
					<h4 class="modal-title">Profile Details</h4>
					<h3 class="modal-title" style="float:right;margin-right: 5%;margin-top: -2%;"> Name : <p style="display: inline;" id="name"></h3>
				</div>
				
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-6" style="border-right: 1px solid #e5e5e5;">			
							<h2 style="color:#ff6010;font-weight: 400;font-size: 19px;">Customer Categoty</h2>
							<div>
								<h3 style="display: inline;">Customer Profile:</h3>
								<p style="display: inline;margin-left: 4px;color: #9acd32;font-size: 15px;" id="customer_profile"></p>
							</div>
							
							<h4 style="color:#23c6c8;font-weight: 400;margin-top: 3%;">Contact Details</h4>
							<div><label>Name: </label> <p style="display:inline;" id="cd_name"></p></div>
							<div><label>Email: </label> <p style="display:inline;" id="email"></p></div>
							<div><label>Address: </label> <p style="display:inline;" id="address"></p></div>
							
							</br>
							
							<h4 style="color:#23c6c8;font-weight: 400;">Satisfaction</h4>
							<div>
								<label>Response time: </label> <p style="display:inline;" id="response_time"></p>
							</div>
							<div>
								<label>Quality of Service: </label> <p style="display:inline;" id="quality_of_service"></p>
							</div>
							<div>
								<label>Brand Cummunication : </label> <p style="display:inline;" id="brand_communication"></p>
							</div>
							<div>
								<label>Overall Product Experience: </label> <p style="display:inline;" id="overall_product_experience"></p>
							</div>
							
						</div>
						
						<div class="col-lg-6" style="padding-left: 29px;">			
							<h2 style="color:#ff6010;font-weight: 400;font-size: 19px;">Target Customer Elevation</h2>
							<div>
								<h3 style="display: inline;">Customer Profile:</h3>
								<p style="display: inline;margin-left: 4px;color: #9acd32;font-size: 15px;" id="target_customer_profile"></p>
							</div>
							
							<h4 style="color:#23c6c8;font-weight: 400;margin-top: 3%;">Recall</h4>
							<div>
								<label>Awareness: </label> <p style="display:inline;" id="awareness"></p>
							</div>
							<div>
								<label>Familiar with offerings: </label> <p style="display:inline;" id="familiar_with_offerings"></p>
							</div>
							
							</br>
							
							<h4 style="color:#23c6c8;font-weight: 400;">Brand loyalty</h4>
							<div>
								<label>Refer: </label> <p style="display:inline;" id="refer"></p>
							</div>
							<div>
								<label>Purchase intent: </label> <p style="display:inline;" id="purchase_intent"></p>
							</div>
							
							</br>
							
							<h4 style="color:#23c6c8;font-weight: 400;">Additional insight</h4>
							<div>
								<label>Upgrade: </label> <p style="display:inline;" id="upgrade"> </p>
							</div>
							
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
	</div>
	
	<!-- Ajax Modal Ends here -->
		
	<!-- Mainly scripts -->
	<script src="js/jquery-2.1.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
	<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

	<!-- Peity -->
	<script src="js/plugins/peity/jquery.peity.min.js"></script>

	<!-- Custom and plugin javascript -->
	<script src="js/inspinia.js"></script>
	<script src="js/plugins/pace/pace.min.js"></script>

	<!-- Peity -->
	<script src="js/demo/peity-demo.js"></script>
	
	<script>
	
		$( document ).ready(function() {
			
			var selected_status		= <?php echo $brand_details['status'];?>;
			var req_service_date  	= "<?php echo $brand_details['req_service_date'];?>";
			var req_amc_date  		= "<?php echo $brand_details['req_amc_date'];?>";
			var req_upgrade_date  	= "<?php echo $brand_details['req_upgrade_date'];?>";
			var req_consumable_date = "<?php echo $brand_details['req_consumable_date'];?>";
			var req_follow_up_date  = "<?php echo $brand_details['req_follow_up_date'];?>";
			var last_call_comment  	= "<?php echo $brand_details['last_call_comment'];?>";
			
			if(selected_status == 15){
				document.getElementById('interested_service_status').style.visibility = "visible";
				
				if(req_service_date != ""){
					document.getElementById("interested_service").checked = true;
					document.getElementById('service_date').value = "<?php echo $brand_details['req_service_date'];?>";
				}
				if(req_amc_date != ""){
					document.getElementById("interested_amc").checked = true;
					document.getElementById('amc_date').value = "<?php echo $brand_details['req_amc_date'];?>";
				}
				if(req_upgrade_date != ""){
					document.getElementById("interested_upgrade").checked = true;
					document.getElementById('upgrade_date').value = "<?php echo $brand_details['req_upgrade_date'];?>";
				}
				if(req_consumable_date != ""){
					document.getElementById("interested_consumable").checked = true;
					document.getElementById('consumable_date').value = "<?php echo $brand_details['req_consumable_date'];?>";
				}
			}else{
				document.getElementById('interested_service_status').style.visibility = "hidden";
				document.getElementById('service_date').style.visibility = "hidden";   
				document.getElementById('amc_date').style.visibility = "hidden";   
				document.getElementById('upgrade_date').style.visibility = "hidden";   
				document.getElementById('consumable_date').style.visibility = "hidden"; 
			}
			
			
			if(selected_status == 16 || selected_status == 17 || selected_status == 18){
				document.getElementById('escalation_service_status').style.visibility = "visible"; 
				if(last_call_comment != ""){
					document.getElementById('comment').value = "<?php echo $brand_details['last_call_comment'];?>";
				}
			}else{
				document.getElementById('escalation_service_status').style.visibility = "hidden"; 
			}
			
			// For followup date
			if(selected_status == 1 || selected_status == 14){
				document.getElementById('callback_service_status').style.visibility   = "visible";
				if(req_follow_up_date != ""){
					document.getElementById("interested_followup").checked = true;
					document.getElementById('follow_up_date').value = "<?php echo $brand_details['req_follow_up_date'];?>";
				}
			}else{
				document.getElementById('callback_service_status').style.visibility   = "hidden";
				document.getElementById('follow_up_date').style.visibility 			  = "hidden"; 
			}
		  
			
			$("#question_answer_form").on('change', '#status', function(e){
				
				e.preventDefault(); 
				//var conceptName 	= $(this).children(":selected").text();
				var selected_value  = $(this).val();
				if(selected_value == 15){
					document.getElementById('interested_service_status').style.visibility = "visible";
				}else{
					document.getElementById('interested_service_status').style.visibility = "hidden";
				}
				
				if(selected_value == 1 || selected_value == 14){
					document.getElementById('callback_service_status').style.visibility   = "visible";
				}else{
					document.getElementById('callback_service_status').style.visibility   = "hidden";
				}
				
				if(selected_value == 16 || selected_value == 17 || selected_value == 18){
					document.getElementById('escalation_service_status').style.visibility   = "visible";
				}else{
					document.getElementById('escalation_service_status').style.visibility   = "hidden";
				}
				
			});
			
			
			$('.form-check-input').on('click',function(){
				
				if($("#interested_service").prop('checked') == true){
					document.getElementById('service_date').style.visibility = "visible";
				}else{
					document.getElementById('service_date').style.visibility = "hidden";
				}
				
				if($("#interested_amc").prop('checked') == true){
					document.getElementById('amc_date').style.visibility = "visible";
				}else{
					document.getElementById('amc_date').style.visibility = "hidden";
				}
				
				if($("#interested_upgrade").prop('checked') == true){
					document.getElementById('upgrade_date').style.visibility = "visible";
				}else{
					document.getElementById('upgrade_date').style.visibility = "hidden";
				}
				
				if($("#interested_consumable").prop('checked') == true){
					document.getElementById('consumable_date').style.visibility = "visible";
				}else{
					document.getElementById('consumable_date').style.visibility = "hidden";
				}
				
				if($("#interested_followup").prop('checked') == true){
					document.getElementById('follow_up_date').style.visibility = "visible";
				}else{
					document.getElementById('follow_up_date').style.visibility = "hidden";
				}
				
			});
			
		});		
		
	
	</script>
	
	
	<script>
	
		function showProfileHistory(tm_id,tm_brand_user_id,tm_brand_name){
			//alert(tm_id);
			$.ajax({
				url:"smsActions.php?showProfileHistory=submit",
				type:"POST",
				data:{tm_id:tm_id,tm_brand_user_id:tm_brand_user_id,tm_brand_name:tm_brand_name},
				dataType:"json",
				success:function(response){
					console.log(response);
					$("#category").html(response.selling_customer_category);
					$("#loyality").html(response.digital_customer_category);
					$("#name").html(response.customer_name);
					$("#customer_profile").html(response.selling_customer_category);
					$("#cd_name").html(response.customer_name);
					$("#email").html(response.customer_email);
					$("#address").html(response.customer_address);
					
					$("#response_time").html(response.response_time);
					$("#quality_of_service").html(response.quality_of_service);
					$("#brand_communication").html(response.brand_communication);
					$("#overall_product_experience").html(response.overall_product_experience);
					
					$("#target_customer_profile").html(response.selling_target_engagement_level);
					
					$("#awareness").html(response.awareness);
					$("#familiar_with_offerings").html(response.familiar_with_offerings);
					$("#refer").html(response.refer);
					$("#purchase_intent").html(response.purchase_intent);
					$("#upgrade").html(response.upgrade);
										
					$("#profile_history_details").modal('show');
					
				},
				error:function(error){
					//alert(JSON.stringify(error));
				}
			});
		}
	
	</script>
	

</body>

</html>







<?php
}
else
{
?>
<script>
  window.location.assign("../index.php")
</script>
<?php
}
?>
