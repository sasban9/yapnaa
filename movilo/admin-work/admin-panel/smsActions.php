<?php
session_start(); 
if(isset($_SESSION['admin_email_id'])){
	$admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];

	require_once('controller/admin_controller.php');
	$control	=	new admin();
	//echo "welcome";
	if(isset($_REQUEST['appointmentDate'])){
		$date = $_REQUEST['appointmentDate'];
		$number = $_REQUEST['number'];
		$id = $_REQUEST['id'];
		$comment = $_REQUEST['comment'];
		$custType = $_REQUEST['custType'];
		$my_date = date('d-m-Y H:i', strtotime($date));
		//echo $my_date."--".$number;
		$get_amc_list = $control->zerob_appointment_sms($id,$my_date,$number,$comment,$custType);
		echo 1;
		exit;
	}
	if(isset($_REQUEST['amcDateSave'])){
		$id = $_REQUEST['id'];
		$amcExpDate = $_REQUEST['amcExpDate'];
		$amcServiceDate = $_REQUEST['amcServiceDate'];
		$ls_ser_date = $_REQUEST['ls_ser_date'];
		
		$custType = $_REQUEST['custType'];
		
		//echo $my_date."--".$number;
		$update_amc = $control->update_amc_dates($id,$amcExpDate,$amcServiceDate,$custType,$ls_ser_date);
		echo 1;
		exit;
	}
	if(isset($_REQUEST['expiryDate'])){
		$custType = $_REQUEST['custType'];
		$date = $_REQUEST['expiryDate'];
		$number = $_REQUEST['number'];
		$id = $_REQUEST['id'];
		$comment = $_REQUEST['comment'];
		//echo $my_date."--".$number;
		$get_amc_list = $control->zerob_appointment_expiry_sms($id,$date,$number,$comment,$custType);
		echo 1;
		exit;
	}
	if(isset($_REQUEST['notInterested'])){
		$custType = $_REQUEST['custType'];
		$id = $_REQUEST['id'];
		$comment = $_REQUEST['comment'];
		$get_amc_list = $control->updateStatus($id,$comment,2,$custType);
		echo 1;
		exit;
	}
	
	if(isset($_REQUEST['custResponse'])){
		//print_r($_REQUEST);
		//print_r($_POST);die;		
		$custType = $_REQUEST['custType'];
		$userQst = $_REQUEST['userQst'];
		$answer = $_REQUEST['answer'];
		
		if(!empty($_REQUEST['amc_requested_date'])){
		$amc_requested_date = date('Y-m-d h:i' , strtotime($_REQUEST['amc_requested_date']));
		}
		else{
		$amc_requested_date ='';	
		}
		if(!empty($_REQUEST['follow_up_date'])){
		$follow_up_date = date('Y-m-d h:i' , strtotime($_REQUEST['follow_up_date']));
		}
		else{
		$follow_up_date ='';	
		}
		if(!empty($_REQUEST['wish_upgrade_date'])){
		$wish_upgrade_date = date('Y-m-d h:i' , strtotime($_REQUEST['wish_upgrade_date']));
		}
		else{
		$wish_upgrade_date ='';	
		}
		if(!empty($_REQUEST['service_requested_date'])){
		$service_requested_date = date('Y-m-d h:i' , strtotime($_REQUEST['service_requested_date']));  
        }
		else{
		$service_requested_date ='';	
		}		
		
		$number = $_REQUEST['number'];
		$callbackCust = $_REQUEST['callbackCust'];
		$brandId = $_REQUEST['brandId'];
		$brandName = $_REQUEST['brandName'];
		$customerid = $_REQUEST['customerid'];
		$customername = $_REQUEST['customername'];
		$_list = $control->insertStatus($callbackCust,$userQst,$answer,$number,$brandId,$brandName,$customerid,$customername,$service_requested_date,$amc_requested_date,$follow_up_date,$wish_upgrade_date);
		echo 1;
		exit;
	}
	
	if(isset($_REQUEST['callBack'])){
		$custType = $_REQUEST['custType'];
		$id = $_REQUEST['id'];
		$comment = $_REQUEST['comment'];
		$get_amc_list = $control->updateStatus($id,$comment,1,$custType);
		echo 1;
		exit;
	}
	if(isset($_REQUEST['general'])){
		$custType = $_REQUEST['custType'];
		$number = array($_REQUEST['number']);
		$id = array($_REQUEST['id']);
		$comment =	$_REQUEST['comment'];
		$message = 'Thank you for your time. Now maintaining your home appliances is easy. Download the Yapnaa app http://bit.ly/YapnaaForAndroid';
		$get_amc_list = $control->send_user_sms($number,$message,$id,$comment,$custType);
		echo 1;
		exit;
	}
	if(isset($_REQUEST['highlyengaged'])){
		$custType = $_REQUEST['customer_type'];
		$fromDate = $_REQUEST['fromDate'];
		$toDate = $_REQUEST['toDate'];		
		$get_result = $control->highlyengaged_customer($custType,$fromDate,$toDate);		
		echo json_encode($get_result);
		exit;
	}
	if(isset($_REQUEST['engaged'])){
		$fromDate = $_REQUEST['fromDate'];
		$toDate = $_REQUEST['toDate'];	
		$custType = $_REQUEST['customer_type'];
		$get_result = $control->engaged_customer($custType,$fromDate,$toDate);
		echo json_encode($get_result);
		exit;
	}
	if(isset($_REQUEST['partialyengaged'])){
		$custType = $_REQUEST['customer_type'];
		$fromDate = $_REQUEST['fromDate'];
		$toDate = $_REQUEST['toDate'];	
		$get_result = $control->partialy_engaged_customer($custType,$fromDate,$toDate);
		echo json_encode($get_result);
		exit;
	}
	if(isset($_REQUEST['disengaged'])){
		$custType = $_REQUEST['customer_type'];
		$fromDate = $_REQUEST['fromDate'];
		$toDate = $_REQUEST['toDate'];	
		$get_result = $control->disengaged_customer($custType,$fromDate,$toDate);
		echo json_encode($get_result);
		exit;
	}
	if(isset($_REQUEST['notattempted'])){
		$custType = $_REQUEST['customer_type'];
		$fromDate = $_REQUEST['fromDate'];
		$toDate = $_REQUEST['toDate'];	
		$get_result = $control->notattempted_customer($custType,$fromDate,$toDate);
		echo json_encode($get_result);
		exit;
	}
	if(isset($_REQUEST['question'])){
		$custType = $_REQUEST['customer_type'];		
		$question = $control->user_question_select();
		echo json_encode($question);
		exit;
	}
	if(isset($_REQUEST['answer'])){
		$custType = $_REQUEST['customer_type'];			
	    $answer = $control->user_answer_select();
		echo json_encode($answer);
		exit;
	}
	if(isset($_REQUEST['customerSavedResponce'])){
		$custType = $_REQUEST['customer_type'];			
		$phone_no = $_REQUEST['phone_no'];			
	    $res = $control->user_responce_based_on_phone($custType,$phone_no);
		echo json_encode($res);
		exit;
	}
	if(isset($_REQUEST['sendSms'])){
		$number = $_REQUEST['number'];			
		$brandName = $_REQUEST['brandName'];			
		$customername = $_REQUEST['customername'];			
	    //send sms	
		$text="Hello ".ucfirst($customername).",\nThank you for taking time to share your feedback on $brandName service.\nVisit https://www.yapnaa.com for any brand/product support.";	
		$userphone=array($number);				
		$control->send_bulk_sms($userphone,$text);
		echo 1;
		exit;
	}
	
	
	if(isset($_REQUEST['custResponseOne'])){	
		$custType = $_REQUEST['custType'];
		$userQst = $_REQUEST['userQst'];
		$answer = $_REQUEST['answer'];
		
		if(!empty($_REQUEST['amc_requested_date'])){
		$amc_requested_date = date('Y-m-d h:i' , strtotime($_REQUEST['amc_requested_date']));
		}
		else{
		$amc_requested_date ='';	
		}
		if(!empty($_REQUEST['follow_up_date'])){
		$follow_up_date = date('Y-m-d h:i' , strtotime($_REQUEST['follow_up_date']));
		}
		else{
		$follow_up_date ='';	
		}
		if(!empty($_REQUEST['wish_upgrade_date'])){
		$wish_upgrade_date = date('Y-m-d h:i' , strtotime($_REQUEST['wish_upgrade_date']));
		}
		else{
		$wish_upgrade_date ='';	
		}
		if(!empty($_REQUEST['service_requested_date'])){
		$service_requested_date = date('Y-m-d h:i' , strtotime($_REQUEST['service_requested_date']));  
        }
		else{
		$service_requested_date ='';	
		}		
		
		$number = $_REQUEST['number'];
		$callbackCust = $_REQUEST['callbackCust'];
		$brandId = $_REQUEST['brandId'];
		$brandName = $_REQUEST['brandName'];
		$customerid = $_REQUEST['customerid'];
		$customername = $_REQUEST['customername'];
		$_list = $control->insertStatus($callbackCust,$userQst,$answer,$number,$brandId,$brandName,$customerid,$customername,$service_requested_date,$amc_requested_date,$follow_up_date,$wish_upgrade_date);
		echo 1;
		exit;
	}
	
	
	/* Code By Suman */
	if(isset($_REQUEST['showProfileHistory'])){
		//print_r($_POST);die;
		$get_pfl_hist_data		= $control->get_profile_history_data($_POST['tm_brand_name'],$_POST['tm_brand_user_id'],$_POST['tm_id']);
		
		$parent_group_result 	= array();
		foreach ($get_pfl_hist_data as $key1 => $value1) {
			$parent_group 		= $value1['qa_parent_group_level'];
			if (!isset($parent_group_result[$parent_group])){ 
				$parent_group_result[$parent_group] = array();
			}
			$parent_group_result[$parent_group][] = $value1;
		}
		$group_subgroup_result  = array();
		foreach($parent_group_result as $key2 => $value2){
			foreach($value2 as $key3 => $value3){
				$sub_parent_group 	= $value3['qa_group_level'];
				if (!isset($group_subgroup_result[$key2][$sub_parent_group])){ 
					$group_subgroup_result[$key2][$sub_parent_group] = array();
				}
				$group_subgroup_result[$key2][$sub_parent_group][] = $value3;
			}
		}
		
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
		
		$data_arr 				= array(
										'selling_customer_category' 		=> $selling_customer_category,
										'digital_customer_category' 		=> $digital_customer_category,
										'selling_target_engagement_level' 	=> $selling_target_engagement_level,
										'digital_target_engagement_level' 	=> $digital_target_engagement_level,
										
										'customer_name' 					=> $group_subgroup_result['Customer Satisfaction Index']['Service'][1]['ph_customer_name'],
										
										'customer_email' 					=> $group_subgroup_result['Customer Satisfaction Index']['Service'][1]['ph_email'],
										
										'customer_address' 					=> $group_subgroup_result['Customer Satisfaction Index']['Service'][1]['ph_customer_area'],
										
										'response_time' 					=> $group_subgroup_result['Customer Satisfaction Index']['Service'][0][$group_subgroup_result['Customer Satisfaction Index']['Service'][0]['answer_weightage']],
										
										'quality_of_service' 				=> $group_subgroup_result['Customer Satisfaction Index']['Service'][1][$group_subgroup_result['Customer Satisfaction Index']['Service'][1]['answer_weightage']],
										
										'brand_communication' 				=> $group_subgroup_result['Customer Satisfaction Index']['Product'][0][$group_subgroup_result['Customer Satisfaction Index']['Product'][0]['answer_weightage']],
										
										'overall_product_experience' 		=> $group_subgroup_result['Customer Satisfaction Index']['Product'][1][$group_subgroup_result['Customer Satisfaction Index']['Product'][1]['answer_weightage']],
										
										'awareness' 						=> $group_subgroup_result['Customer Brand Engagement Index']['Recall'][0][$group_subgroup_result['Customer Brand Engagement Index']['Recall'][0]['answer_weightage']],
										
										'familiar_with_offerings' 			=> $group_subgroup_result['Customer Brand Engagement Index']['Recall'][1][$group_subgroup_result['Customer Brand Engagement Index']['Recall'][1]['answer_weightage']],
										
										'refer' 							=> $group_subgroup_result['Customer Brand Engagement Index']['Loyalty'][0][$group_subgroup_result['Customer Brand Engagement Index']['Loyalty'][0]['answer_weightage']],
										
										'purchase_intent' 					=> $group_subgroup_result['Customer Brand Engagement Index']['Loyalty'][1][$group_subgroup_result['Customer Brand Engagement Index']['Loyalty'][1]['answer_weightage']],
										
										'upgrade' 							=> $group_subgroup_result['Customer Brand Engagement Index']['Additional Information'][1][$group_subgroup_result['Customer Brand Engagement Index']['Additional Information'][1]['answer_weightage']],
										);
		//print_r($data_arr);die;
		
		echo json_encode($data_arr);
		exit;
	}
		
	
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
