<?php
session_start(); 

if(isset($_SESSION['admin_email_id'])){
	
	$admin_email_id		= $_SESSION['admin_email_id'];
	$admin_name			= $_SESSION['admin_name'];
	$admin_last_login	= $_SESSION['admin_last_login'];
    $ar_id  	        = $_SESSION['ar_id'];
	require_once('controller/admin_controller.php');
	$control			= new admin();	
	
	$brand_customer_id 	= $_GET['brand_customer_id'];
	$user_phone 		= $_GET['user_phone'];
	$user_id 			= $_GET['user_id'];
	
	// Brand Details
	$brand_details 		= $control->get_brand_details_of_customer($_GET['customer_type'],$user_id);
	$flname				= explode(" ",$brand_details['CUSTOMER_NAME']);
	$brand_details['flname'] = substr($flname[0],0,1)."".substr($flname[1],0,1);
	
	$get_qa_ids 		= $control->get_question_ids_of_customer($_GET['customer_type'],$user_id);
	
	// Question and Answers
	$get_qa_data		= $control->get_qa_data($_GET['customer_type'],$user_id);
	//echo "<br><pre>"; print_r($get_qa_data);die;
	$parent_group_result = array();
	foreach ($get_qa_data as $key1 => $value1) {
		$parent_group 	= $value1['parent_group_level'];
		if (!isset($parent_group_result[$parent_group])){ 
			$parent_group_result[$parent_group] = array();
		}
		$parent_group_result[$parent_group][] = $value1;
	}
	$group_subgroup_result = array();
	foreach($parent_group_result as $key2 => $value2){
		foreach($value2 as $key3 => $value3){
			$sub_parent_group 	= $value3['group_level'];
			if (!isset($group_subgroup_result[$key2][$sub_parent_group])){ 
				$group_subgroup_result[$key2][$sub_parent_group] = array();
			}
			$group_subgroup_result[$key2][$sub_parent_group][] = $value3;
		}
	}
	$final_arr 		= array();
	foreach($group_subgroup_result as $key => $value){
		foreach($value as $key1 => $value1){
			foreach($value1 as $key2 => $value2){
				$questions 		= $value2['questions'];
				$final_arr[$key][$key1][$questions][] = $value2;
			}
		}	
	}
	
	// Profile Things
	$answer_weightage		= $control->get_answer_weightage_of_customer($_GET['customer_type'],$user_id);
	$parent_group_level		= array();
	if(!empty($answer_weightage)){
		foreach ($answer_weightage as $key4 => $value4) {
			$parent_group_res 		= $value4['parent_group_level'];
			/* if (!isset($parent_group_level[$parent_group])){ 
				$parent_group_level[$parent_group_res] 	= array();
			} */
			$parent_group_level[$parent_group_res][] 	= $value4;
		}
	}
	
	include 'profile_calculation1.php';
	if(!empty($parent_group_level)){
		$profile_cal 		= calculate_profile($parent_group_level); 	
		if(!empty($profile_cal)){
			$selling_customer_category			= $profile_cal['selling_customer_category'];
			$selling_target_engagement_level	= $profile_cal['selling_target_engagement_level'];
			$digital_customer_category			= $profile_cal['digital_customer_category'];
			$digital_target_engagement_level	= $profile_cal['digital_target_engagement_level'];
			$life_time_value					= $profile_cal['life_time_value'];
			$brand_value						= $profile_cal['brand_value'];
			$referral_value						= $profile_cal['referral_value'];
		}
	}
	
	$timeline_data 			= $control->get_timeline_detail_of_customer($_GET['customer_type'],$user_id);
	
	// Fetching Data for Profile Modal
	$profile_popup_data 	= $control->get_profile_popup_data($_GET['customer_type'],$user_id);	
	$question_array 		= array(2,3,5,6,7,8,11,12,13,14,15,16,17);
	$profile_data_popup  	= array();
	$profile_data_modal  	= array();
	foreach($profile_popup_data as $key => $value){
		$profile_data_popup[$value['id']] = $value['answer_type']; 
	}
	$missing 				= array_diff_key(array_flip($question_array), $profile_data_popup);
	if(!empty($missing)){
		$missingarray 		= array_fill_keys(array_keys($missing), 'No answer');
		$profile_data_modal = $profile_data_popup+$missingarray;
	}
	//echo "<br><pre>"; print_r($profile_data_modal);die;
	
	
	// Response Actions Starts Here	
	if(isset($_POST['editAMCSubmit'])){
		if(empty($_POST['brand_customer_id'])){
			$_POST['brand_customer_id'] = '';
		}
		
		$brand_name 			= array('', 'livpure', 'zerob_consol1','livpure_tn_kl','bluestar_b2b','bluestar_b2c');
		$brand_name 			= $brand_name[$_POST['brand_id']];
		
		// Update Status In Brand Table
		$set_array_brand		= array('status' => $_POST['status'],'updated_on' => date('Y-m-d') );
		if(!empty($_POST['req_service_date'])|| !empty($_POST['req_amc_date']) || !empty($_POST['req_upgrade_date']) || !empty($_POST['req_consumable_date'])){
			
			$set_array_brand['req_service_date']	= $_POST['req_service_date'];
			$set_array_brand['req_amc_date']		= $_POST['req_amc_date'];
			$set_array_brand['req_upgrade_date']	= $_POST['req_upgrade_date'];
			$set_array_brand['req_consumable_date']	= $_POST['req_consumable_date'];
			
		}else if(!empty($_POST['req_follow_up_date'])){
			$set_array_brand['req_follow_up_date']	= $_POST['req_follow_up_date'];
			
		}else if(!empty($_POST['req_pm_service_date'])){
			$set_array_brand['req_pm_service_date']	= $_POST['req_pm_service_date'];
			
		}else if(!empty($_POST['last_call_comment'])){
			$set_array_brand['last_call_comment']	= $_POST['last_call_comment'];
			
		}else if(!empty($_POST['not_interested_reason'])){
			$set_array_brand['not_interested_reason'] = $_POST['not_interested_reason'];
			
		}else{
			$set_array_brand 						= $set_array_brand;
		}
		
		if(!empty($_POST['not_interested_reason'])){
			$sliced_arr 		= array_slice($_POST, 0, -16, true);
		}else{
			$sliced_arr 		= array_slice($_POST, 0, -15, true);
		}	
		$sliced_arr_values   	= array_values($sliced_arr);
		$sliced_arr_keys   		= array_keys($sliced_arr);
		
		foreach($sliced_arr as $key=>$value){
			if(empty(array_search($key,$get_qa_ids)) &&  array_search($key,$get_qa_ids) <= -1){
				//echo "insert loop - ".$value."<br>";die;
				$data['question_id']	= $key;
				$data['answer_id']		= $value;
				$data['user_id']		= $_POST['user_id'];
				$data['brand_id']		= $_POST['brand_id'];
				$data['created_date']  	= date('Y-m-d H:i:s');
				$data['updated_date']  	= date('Y-m-d H:i:s');
				
				$response 				= $control->insert_q_a($data); 
			}
			
			else{
				//echo "update loop - ".$value."<br>";die;
				$data['question_id']	= $key;
				$data['answer_id']		= $value;
				$data['user_id']		= $_POST['user_id'];
				$data['brand_id']		= $_POST['brand_id'];
				$data['updated_date']  	= date('Y-m-d H:i:s');
				
				$response 				= $control->update_q_a($data,$_POST['user_id']);
			}
		}
		$response1  				= $control->update_status_in_brand($brand_name,$set_array_brand,$_POST['user_id']);
				
		// Update In Timeline AND Profile History
		if($response1 == 1){
			$time_line_data 		= array(
										'tm_brand_user_id' 		=> $_POST['user_id'],
										'tm_brand_customer_id'  => $_POST['brand_customer_id'],
										'tm_brand_name'   		=> $brand_name,
										'tm_brand_user_phone'   => $_POST['user_phone'],
										'tm_brand_id'   		=> $_POST['brand_id'],
										'tm_interaction'		=> 'Call By Agent',
										'tm_interaction_type'	=> 1,
										'tm_created_date'		=> date('Y-m-d')
										);								
			$timeline_response 		= $control->insert_timeline_data($time_line_data);
			
			
			$answer_weightage		= $control->get_answer_weightage_of_customer($_GET['customer_type'],$user_id);
			$parent_group_level		= array();
			if(!empty($answer_weightage)){
				foreach ($answer_weightage as $key4 => $value4) {
					$parent_group_res 		= $value4['parent_group_level'];
					$parent_group_level[$parent_group_res][] 	= $value4;
				}
			}
			
			$existing_profile_status	= $control->get_existing_profile_status_of_customer($brand_name,$user_id);
			$existing_category  	 	= $existing_profile_status['profile_type'];
			$profile_cal 				= calculate_profile($parent_group_level); 
			$selling_customer_category	= $profile_cal['selling_customer_category'];
			
			$time_line_data 			= array(
												'tm_brand_user_id' 		=> $_POST['user_id'],
												'tm_brand_customer_id'  => $_POST['brand_customer_id'],
												'tm_brand_name'   		=> $brand_name,
												'tm_brand_user_phone'   => $_POST['user_phone'],
												'tm_brand_id'   		=> $_POST['brand_id'],
												'tm_movement_from'		=> $existing_category,
												'tm_movement_to'		=> $selling_customer_category,
												'tm_created_date'		=> date('Y-m-d')
												);
			
			if(($_POST['status'] == 16 || $_POST['status'] == 17 || $_POST['status'] == 18)){
				$message 				= 'Sorry to hear that you have bad feedback on your product. We will try to serve best for you';
				$msg_response 			= $control->send_lifecycle_sms($brand_details['PHONE1'],$message);
				
				if($_POST['status'] == 16){
					$time_line_data['tm_interaction']		= 'AMC Related Escalation';
					$time_line_data['tm_interaction_type']	= 10;
					$time_line_data['tm_agent_comment']		= $_POST['last_call_comment'];
					$time_line_data['tm_transaction_type']	= 'User has given escalation message about AMC';
					$timeline_response 						= $control->insert_timeline_data($time_line_data);
				}
				if($_POST['status'] == 17){
					$time_line_data['tm_interaction']		= 'Product Upgrade Escalation';
					$time_line_data['tm_interaction_type']	= 11;
					$time_line_data['tm_agent_comment']		= $_POST['last_call_comment'];
					$time_line_data['tm_transaction_type']	= 'User has given escalation message about product upgrade';
					$timeline_response 						= $control->insert_timeline_data($time_line_data);
				}
				if($_POST['status'] == 18){
					$time_line_data['tm_interaction']		= 'Product Upgrade Escalation';
					$time_line_data['tm_interaction_type']	= 11;
					$time_line_data['tm_agent_comment']		= $_POST['last_call_comment'];
					$time_line_data['tm_transaction_type']	= 'User has given escalation message about service provider';
					$timeline_response 						= $control->insert_timeline_data($time_line_data);
				}
			}
			
			if($_POST['status'] == 10){
				$message 			= 'Sorry to hear that you have changed your product. To maintain the product use Yapnaa.';
				$msg_response 		= $control->send_lifecycle_sms($brand_details['PHONE1'],$message);
				
				$time_line_data['tm_interaction']		= 'Product Change';
				$time_line_data['tm_interaction_type']	= 4;
				$time_line_data['tm_transaction_type']	= 'Customer changed the product';
				$timeline_response 						= $control->insert_timeline_data($time_line_data);	
			}
			
			if($_POST['status'] == 1){ // Need to be add after sattus updated
				$time_line_data['tm_interaction']		= 'Callback';
				$time_line_data['tm_interaction_type']	= 2;
				$time_line_data['tm_transaction_date']	= $_POST['req_follow_up_date'];
				$time_line_data['tm_transaction_type']	= 'Customer has given follow up date on '.$_POST['req_follow_up_date'].'';
				$timeline_response 						= $control->insert_timeline_data($time_line_data);
			}
			
			if($_POST['status'] == 2){
				$time_line_data['tm_interaction']		= 'Not interested';
				$time_line_data['tm_interaction_type']	= 3;
				$time_line_data['tm_transaction_type']	= 'Customer is not interested in service';
				$timeline_response 						= $control->insert_timeline_data($time_line_data);
			}
			
			if($_POST['status'] == 11){ 
				$time_line_data['tm_interaction']		= 'Change Service Provider';
				$time_line_data['tm_interaction_type']	= 5;
				$time_line_data['tm_transaction_type']	= 'Customer wants to change the service provider';
				$timeline_response 						= $control->insert_timeline_data($time_line_data);
			}
			
			if($_POST['status'] == 12){ 
				$time_line_data['tm_interaction']		= 'No Response';
				$time_line_data['tm_interaction_type']	= 6;
				$time_line_data['tm_transaction_type']	= 'No response from customer';
				$timeline_response 						= $control->insert_timeline_data($time_line_data);
			}
			
			if($_POST['status'] == 13){
				$time_line_data['tm_interaction']		= 'Not reachable';
				$time_line_data['tm_interaction_type']	= 7;
				$time_line_data['tm_transaction_type']	= 'Customer is not reachable';
				$timeline_response 						= $control->insert_timeline_data($time_line_data);
			}
			
			if($_POST['status'] == 14){ 
				$time_line_data['tm_interaction']		= 'To be contacted';
				$time_line_data['tm_interaction_type']	= 8;
				$time_line_data['tm_transaction_date']	= $_POST['req_follow_up_date'];
				$time_line_data['tm_transaction_type']	= 'Customer has given follow up date on '.$_POST['req_follow_up_date'].'';
				$timeline_response 						= $control->insert_timeline_data($time_line_data);
			}
			
			if($_POST['status'] == 15){
				if(!empty($_POST['req_service_date']) ){
					$time_line_data['tm_interaction']		= 'Interested in Service';
					$time_line_data['tm_interaction_type']	= 9;
					$time_line_data['tm_agent_comment']		= $_POST['req_service_date'];
					$time_line_data['tm_transaction_type']	= 'Service request received of '.$_POST['req_service_date'].'';
					$timeline_response 	= $control->insert_timeline_data($time_line_data);
				}
				if(!empty($_POST['req_amc_date']) ){
					$time_line_data['tm_interaction']		= 'Interested in Service';
					$time_line_data['tm_interaction_type']	= 9;
					$time_line_data['tm_agent_comment']		= $_POST['req_amc_date'];
					$time_line_data['tm_transaction_type']	= 'AMC date request raised on '.$_POST['req_amc_date'].'';
					$timeline_response 	= $control->insert_timeline_data($time_line_data);
				}
				if(!empty($_POST['req_upgrade_date']) ){
					$time_line_data['tm_interaction']		= 'Interested in Service';
					$time_line_data['tm_interaction_type']	= 9;
					$time_line_data['tm_agent_comment']		= $_POST['req_upgrade_date'];
					$time_line_data['tm_transaction_type']	= 'Upgrade date rquest raised on '.$_POST['req_upgrade_date'].'';
					$timeline_response 	= $control->insert_timeline_data($time_line_data);
				}
				if(!empty($_POST['req_consumable_date']) ){
					$time_line_data['tm_interaction']		= 'Interested in Service';
					$time_line_data['tm_interaction_type']	= 9;
					$time_line_data['tm_agent_comment']		= $_POST['req_consumable_date'];
					$time_line_data['tm_transaction_type']	= 'Consumable date request on '.$_POST['req_consumable_date'].'';
					$timeline_response 	= $control->insert_timeline_data($time_line_data);
				}
			}
			
			if($_POST['status'] == 19){ // Need to be add after sattus updated
				$time_line_data['tm_interaction']		= 'PM Service Enqiry';
				$time_line_data['tm_interaction_type']	= 21;
				$time_line_data['tm_transaction_date']	= $_POST['req_pm_service_date'];
				$time_line_data['tm_transaction_type']	= 'Customer has given pm service enquiry date on '.$_POST['req_pm_service_date'].'';
				$timeline_response 						= $control->insert_timeline_data($time_line_data);
			}
			
			if($_POST['status'] == 20){
				$time_line_data['tm_interaction']		= 'Wrong Number';
				$time_line_data['tm_interaction_type']	= 22;
				$time_line_data['tm_transaction_type']	= 'We got wrong number of this customer';
				$timeline_response 						= $control->insert_timeline_data($time_line_data);
			}
			
			foreach($sliced_arr as $key1=>$value1){
				$pfl_data 							= array();
				$pfl_data['ph_qid']					= $key1;
				$pfl_data['ph_answer']				= $value1;
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
				//$pfl_data['ph_weightage']			= $value_split[1]; // We can write Procedure here
				$pfl_data1[] 						= $pfl_data;	
				$ph_response						= $control->insert_profile_history($pfl_data);
			}
			
			// Update Profile-Type in Brand Table
			$set_array_brand 	= array('profile_type' => $selling_customer_category,'email' => $_POST['email']);
			$response2  		= $control->updateProfileInBrand($brand_name,$set_array_brand,$_POST['brand_customer_id'],$_POST['user_id']);
			
			// Update Call Status = 1 in daily_call_schedule table
			$updated_data    	= array('status' => 1, 'updated_date' => date('Y-m-d H:i:s'));
			$call_status 	 	= $control->updateCallStatusInDailyCallSchedule($updated_data,$_POST['call_id']);
			
			// Success SMS will go to this customer
			if($brand_details['status'] == 0){
				if(!empty($_POST['user_phone'])){
					$message 				= 'Thank you for interacting with Yapnaa.</br>Yapnaa : Single point for all brand support.</br>Website : <a href="www.yapnaa.com">Yapnaa</a></br>Mobile App : <a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en_IN">Yapnaa Mobile</a>';
					$send_success_sms		= $control->send_lifecycle_sms($_POST['user_phone'],$message); 
				}
			}
			
		}
		
		if($response || $response1 == 1){
			$_POST = array();
			echo "<script>alert('Updated successfully');</script>";
			echo "<meta http-equiv='refresh' content='0'>";
		}
		else{
			$_POST = array();
			echo "<script>alert('Something went wrong');</script>";
		}
		
	}
	
	
	// Update AMC datas
	if(isset($_POST['addAMCSubmit'])){
		//echo "<br><pre>"; print_r($_POST);
		if(empty($_POST['newAMCStart'])){
			$_POST['newAMCStart'] 	= '';
		}
		if(empty($_POST['newAMCEnd'])){
			$_POST['newAMCEnd'] 	= '';
		}
		
		$brand_name 				= array('', 'livpure', 'zerob_consol1','livpure_tn_kl','bluestar_b2b','bluestar_b2c');
		$table 						= $brand_name[$_GET['customer_type']];
		
		$get_amc_list 				= $control->updateAmcData($table,$_SESSION['admin_email_id'],$_POST['newAMCStart'],$_POST['newAMCEnd'],$_POST['userid'],$_POST['comments'],$_POST['closedBy'],$_POST['transaction_status']);
		
		$existing_profile_status	= $control->get_existing_profile_status_of_customer($table,$_POST['userid']);
		$existing_category  	 	= $existing_profile_status['profile_type'];
		
		$time_line_data 			= array(
											'tm_brand_user_id' 		=> $_POST['userid'],
											'tm_brand_customer_id'  => $_GET['brand_customer_id'],
											'tm_brand_name'   		=> $table,
											'tm_brand_user_phone'   => $_GET['user_phone'],
											'tm_brand_id'   		=> $_GET['customer_type'],
											'tm_movement_from'		=> $existing_category,
											'tm_movement_to'		=> $existing_category,
											'tm_created_date'		=> date('Y-m-d'),
											);		
		
		if($get_amc_list && !empty($_POST['newAMCStart']) ){
			$time_line_data['tm_interaction'] 		= 'AMC update';
			$time_line_data['tm_interaction_type'] 	= 18;
			$time_line_data['tm_transaction_date'] 	= $_POST['newAMCStart'];
			$time_line_data['tm_transaction_type'] 	= 'Customer has given AMC startdate of '.$_POST['newAMCStart'].'';
			$timeline_response 						= $control->insert_timeline_data($time_line_data);
		}
		
		if($get_amc_list && !empty($_POST['closedBy']) && $_POST['closedBy'] == 'Yapnaa'){
			$time_line_data['tm_interaction'] 		= 'Purchased With Yapnaa';
			$time_line_data['tm_interaction_type'] 	= 19;
			$time_line_data['tm_transaction_type'] 	= 'Customer purchased with Yapnaa';
			$timeline_response 						= $control->insert_timeline_data($time_line_data);
		}
		
		if($get_amc_list && !empty($_POST['closedBy']) && $_POST['closedBy'] == 'Others'){
			$time_line_data['tm_interaction'] 		= 'Purchased With Brand';
			$time_line_data['tm_interaction_type'] 	= 20;
			$time_line_data['tm_transaction_type'] 	= 'Customer purchased with its Brand';
			$timeline_response 						= $control->insert_timeline_data($time_line_data);
		}	
		
		if($get_amc_list){
			$_POST = array();
			echo "<script>alert('Updated successfully');</script>";
			echo "<meta http-equiv='refresh' content='0'>";
		}
		else{
			$_POST = array();
			echo "<script>alert('Something went wrong');</script>";
		}
	}	
	
		
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
		
		.modal-answers {
			color: #ff6010;
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
											<?php foreach($final_arr as $key => $value){ ?>
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
																	<h3><?php echo $key2; ?></h3>
																</div>
																<div class="col-lg-12">
																	<div class="row">
																		<?php for($i=0;$i<count($value2);$i++) { ?>
																			<div class="col-md-6">
																				<div class="form-check">
																					<label>
																						<input type="radio" value="<?php echo $value2[$i]['answer_id']; ?>" name="<?php echo $value2[$i]['question_id'];?>" <?php 
																				echo !empty($value2[$i]["answer_given"])?(($value2[$i]["answer_given"]==$value2[$i]["answer_id"])?"checked":""):"";
																				?> > 
																						<span id="" class="label-text"><?php echo $value2[$i]['answer_type']; ?></span>
																						<input type="hidden" value="<?php echo $value2[$i]['answer_weightage']; ?>" name="">
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
										<input type="hidden" name="call_id" value="<?php echo $_GET['call_id'];?>" />
										
										<div class="row" style="float:right;margin-top: -35%;margin-right: 8%;width:20%">
											<label for="sel1">Email:</label>
											<input type="email" class="form-control" name="email" value="<?php echo $brand_details['email'];?>" />
										</div>
										
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
													<option value="20" <?php if($brand_details['status'] == 20){echo 'Selected';} ?>>Wrong Number</option>
													<option value="15" <?php if($brand_details['status'] == 15){echo 'Selected';} ?>>Interested in Service</option>
													<option value="19" <?php if($brand_details['status'] == 19){echo 'Selected';} ?>>PM Service Enquiry</option>
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
										
										<div class="row" id="pm_enquiry_service_status" style="float:right;margin-top: -24%;margin-right: 4%;">
											<div class="form-check">
												<input type="checkbox" class="form-check-input" id="interested_pm_service">
												<label class="form-check-label" for="interested_pm_service">PM Service Enquiry</label>
												<div class="inline" style="margin-left: 30px;">
													<input type="date" class="form-control" name="req_pm_service_date" id="pm_service_date">
												</div>
											</div>
										</div>
										
										<div class="row" id="not_interested_service_status" style="float:right;margin-top: -24%;margin-right: 9%;">
											<label>Reason of Not interested in service</label>
											<div class="form-check">
												<label>
													<input type="radio" value="1" name="not_interested_reason" <?php 
														echo !empty($brand_details['not_interested_reason'])?(($brand_details['not_interested_reason']==1)?"checked":""):"";
														?> >
													<span id="sansq1" class="label-text">Dissatisfied with service</span>
												</label>
											</div>
											<div class="form-check">
												<label>
													<input type="radio" value="2" name="not_interested_reason" <?php 
														echo !empty($brand_details['not_interested_reason'])?(($brand_details['not_interested_reason']==2)?"checked":""):"";
														?> >
													<span id="sansq1" class="label-text">Unreliable support after taking contract</span>
												</label>
											</div>
											<div class="form-check">
												<label>
													<input type="radio" value="3" name="not_interested_reason" <?php 
														echo !empty($brand_details['not_interested_reason'])?(($brand_details['not_interested_reason']==3)?"checked":""):"";
														?> >
													<span id="sansq1" class="label-text">Technician do not respond</span>
												</label>
											</div>	
											<div class="form-check">
												<label>
													<input type="radio" value="4" name="not_interested_reason" <?php 
														echo !empty($brand_details['not_interested_reason'])?(($brand_details['not_interested_reason']==4)?"checked":""):"";
														?> >
													<span id="sansq1" class="label-text">Price high</span>
												</label>
											</div>
											<div class="form-check">
												<label>
													<input type="radio" value="5" name="not_interested_reason" <?php 
														echo !empty($brand_details['not_interested_reason'])?(($brand_details['not_interested_reason']==5)?"checked":""):"";
														?> >
													<span id="sansq1" class="label-text">No value for money</span>
												</label>
											</div>
											<div class="form-check">
												<label>
													<input type="radio" value="6" name="not_interested_reason" <?php 
														echo !empty($brand_details['not_interested_reason'])?(($brand_details['not_interested_reason']==6)?"checked":""):"";
														?> >
													<span id="sansq1" class="label-text">Escalation but problem exist</span>
												</label>
											</div>
											<div class="form-check">
												<label>
													<input type="radio" value="7" name="not_interested_reason" <?php 
														echo !empty($brand_details['not_interested_reason'])?(($brand_details['not_interested_reason']==7)?"checked":""):"";
														?> >
													<span id="sansq1" class="label-text">Will decide later</span>
												</label>
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
															<i class="fa fa-plus-circle" onclick="showProfileHistory(<?php echo $timeline_data[$i]['tm_id'];?>,<?php echo $timeline_data[$i]['tm_brand_user_id'];?>,'<?php echo $timeline_data[$i]['tm_brand_id'];?>');" aria-hidden="true"></i>
														</div>
													<?php } ?>
													
													<span class="lt-arrow" style="left: 446px;">&#10510;</span>
													
													<div class="vertical-timeline-content vertical-timeline-lt bg-green" style="margin-left: 117px;">
														<span class="span-style-lt" style="font-size: 15px;"><?php echo $timeline_data[$i]['tm_interaction']; ?></span>
													</div>
													<div class="vertical-timeline-content-lt" style="width: 220px;">
														<h4><?php echo $timeline_data[$i]['tm_transaction_type']; ?></h4>
													</div>
												</div>
												
											<?php } else { ?>
											
												<div class="vertical-timeline-block v-t-rt dis-in-flex" style="margin-right: 130px;">
													<div class="vertical-timeline-icon mg-lt-85">
														<span class="v-t-i-date"><?php echo $timeline_data[$i]['tm_created_date']; ?></span>
													</div>	
													
													<?php if($timeline_data[$i]['tm_movement_from'] != $timeline_data[$i]['tm_movement_to']) { ?>
														<div class="vertical-timeline-icon" style="margin-top: 52px;">
															<i class="fa fa-plus-circle" onclick="showProfileHistory(<?php echo $timeline_data[$i]['tm_id'];?>,<?php echo $timeline_data[$i]['tm_brand_user_id'];?>,'<?php echo $timeline_data[$i]['tm_brand_id'];?>');" aria-hidden="true"></i>
														</div>
													<?php } ?>
													
													<span class="rt-arrow">&#8674;</span>
													
													<div class="vertical-timeline-content vertical-timeline-rt bg-yellow" style="width: 110px;">
														<span class="span-style-lt" style="font-size: 15px;"><?php echo $timeline_data[$i]['tm_interaction']; ?></span>
													</div>
													<div class="vertical-timeline-content-rt" style="width: 220px;">
														<h4><?php echo $timeline_data[$i]['tm_transaction_type']; ?></h4>
																													
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
											
											<div class="row" style="">
												<div class="col-lg-3"><label>Select Status</label></div>
												<div class="col-lg-3">
													<div class="form-group">
														<select class="form-control" name="transaction_status" id="transaction_status">
															<option value="0">Select</option>
															<option value="1" <?php if($brand_details['transaction_status'] == 1){echo 'Selected';} ?> >Service Request Open</option>
															<option value="2" <?php if($brand_details['transaction_status'] == 2){echo 'Selected';} ?>>Service Request Close</option>
															<option value="3" <?php if($brand_details['transaction_status'] == 3){echo 'Selected';} ?>>AMC Request Open</option>
															<option value="4" <?php if($brand_details['transaction_status'] == 4){echo 'Selected';} ?>>AMC Request Close</option>
															<option value="5" <?php if($brand_details['transaction_status'] == 5){echo 'Selected';} ?>>Escalation Request Open</option>
															<option value="6" <?php if($brand_details['transaction_status'] == 6){echo 'Selected';} ?>>Escalation Request Close</option>
															<option value="7" <?php if($brand_details['transaction_status'] == 7){echo 'Selected';} ?>>Upgrade Request Open</option>
															<option value="8" <?php if($brand_details['transaction_status'] == 8){echo 'Selected';} ?>>Upgrade Request Close</option>
														</select>
													</div>
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
	
	<!-- Profile Modal -->
	
	<div class="modal fade" id="profiledetails" role="dialog" style="">
		<div class="modal-dialog" style="width: 75%;margin-top:10px;">
			<div class="modal-content" style="height: 1100px;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="clear" style="clear: both;"></div>
					<div class="row">
						<div class="col-lg-4" style="">
							<div class="row" style="">
								<h3 class="modal-title text-left" style="padding-left:15px;">Customer Category : <?php echo $selling_customer_category; ?></h3>
							</div>
							<div class="row" style="">	
								<h3 class="modal-title text-left" style="padding-left:15px;">Customer Status : 
									<?php 
										if($brand_details['status'] == 0){
											echo 'Fresh/Not called';
										} 
										if($brand_details['status'] == 1){
											echo 'Callback';
										}
										if($brand_details['status'] == 2){
											echo 'Not Interested in Service';
										}
										if($brand_details['status'] == 3){
											echo 'Appointment set';
										}
										if($brand_details['status'] == 4){
											echo 'Registered in app';
										}
										if($brand_details['status'] == 5){
											echo 'App SMS sent';
										}
										if($brand_details['status'] == 6){
											echo 'Expiry SMS sent';
										}
										if($brand_details['status'] == 7){
											echo 'AMC Renewed';
										}
										if($brand_details['status'] == 8){
											echo 'Paid service';
										}
										if($brand_details['status'] == 9){
											echo 'Upgrade';
										}
										if($brand_details['status'] == 10){
											echo 'Change Product';
										}
										if($brand_details['status'] == 11){
											echo 'Change Service Provider';
										}
										if($brand_details['status'] == 12){
											echo 'No Response';
										}
										if($brand_details['status'] == 13){
											echo 'Not reachable';
										}
										if($brand_details['status'] == 14){
											echo 'To be contacted';
										}
										if($brand_details['status'] == 15){
											echo 'Interested in Service';
										}
										if($brand_details['status'] == 16){
											echo 'AMC Escalation';
										}
										if($brand_details['status'] == 17){
											echo 'Product Escalation';
										}
										if($brand_details['status'] == 18){
											echo 'Service Escalation';
										}
									?>
								</h3>
							</div>	
						</div>
						<div class="col-lg-4">
							<div class="row">	
								<h4 class="modal-title" style="padding-left: 20px;">Profile Details</h4>
							</div>	
						</div>
						<div class="col-lg-4">
							<div class="row">	
								<h3 class="modal-title" style="padding-left: 10px;"> Name : <?php if(!empty($brand_details['CUSTOMER_NAME'])){echo $brand_details['CUSTOMER_NAME'];} ?></h3>
							</div>
								
						</div>
					</div>
				</div>
				
				<div class="modal-body">
				
					<div class="row" style="margin-top: -17px;">
						<div class="col-lg-4" style="border-right: 1px solid #e5e5e5;">
							<div class="row">
								<h2 style="display:inline;color:#ff6010;font-weight:400;font-size:13px;">Customer Categoty</h2>
								<p style="display: inline;margin-left: 4px;color: #9acd32;font-size: 13px;"><?php echo $selling_customer_category; ?></p>
							</div>
						</div>
						
						<div class="col-lg-4" style="border-right: 1px solid #e5e5e5;padding-left: 29px;">
							<div class="row">
								<h2 style="display: inline;color:#ff6010;font-weight:400;font-size:13px;">Target Customer</h2>
								<p style="display: inline;margin-left: 4px;color: #9acd32;font-size: 13px;"><?php echo $selling_target_engagement_level; ?></p>
							</div>
						</div>
						
						<div class="col-lg-4" style="padding-left: 29px;">
							<div class="row">
								<h2 style="display: inline;color:#ff6010;font-weight:400;font-size:13px;">Yapnaa Loyalty Points</h2>
								<p style="display: inline;margin-left: 4px;color: #9acd32;font-size: 13px;">0</p>
							</div>
						</div>
					</div>
					
					<hr/ style="border: solid 1px dimgrey;margin-left: -30px;margin-right: -30px;margin-top: 10px;">
					
					<div class="row" style="margin-top: -20px;">
						<div class="col-lg-4" style="border-right: 1px solid #e5e5e5;">
							
							<div class="row" style="margin-top: 5%;">
								<div class="col-lg-5">
									<h4 style="color:#23c6c8;font-weight: 400;font-size: 12px;margin-left:-14%">Contact Details</h4>
								</div>
								<div class="col-lg-7" style="margin-left: -15%;margin-top: 2%;">
									<div style="display:table;">
										<label>Name: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php if(!empty($brand_details['CUSTOMER_NAME'])){echo $brand_details['CUSTOMER_NAME'];} ?></p>
									</div>
									<div style="display:table;">
										<label>Mobile: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php if(!empty($brand_details['PHONE1'])){echo $brand_details['PHONE1'];} else{echo "No Phone";} ?></p>
									</div>
									<div style="display:table;">
										<label>Email: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php if(!empty($brand_details['email'])){echo $brand_details['email'];} else{echo "No Email";} ?></p>
									</div>
									<div style="display:table;">
										<label>Address: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php if(!empty($brand_details['CUSTOMER_AREA'])){echo $brand_details['CUSTOMER_AREA'];} else{echo "No Address";} ?></p>
									</div>
								</div>
							</div>
							
							<div class="row" style="margin-top: 5%;">
								<div class="col-lg-5">
									<h4 style="color:#23c6c8;font-weight: 400;font-size: 12px;margin-left:-14%">Satisfaction</h4>
								</div>
								<div class="col-lg-7" style="margin-left: -15%;margin-top: 2%;">
									
									<div style="display:-webkit-inline-box;">
										<label>Response time: </label> <p class="modal-answers" style="display:-webkit-inline-box;word-wrap: break-word;"><?php echo $profile_data_modal[2]; ?></p>
									</div>
									<div style="display:-webkit-inline-box;">
										<label>Quality of Service: </label> <p class="modal-answers" style="display:-webkit-inline-box;word-wrap: break-word;"><?php echo $profile_data_modal[3]; ?></p>
									</div>
									<div style="display:-webkit-inline-box;">
										<label>Brand Cummunication: </label> <p class="modal-answers" style="display:-webkit-inline-box;word-wrap: break-word;"><?php echo $profile_data_modal[5]; ?></p>
									</div>
									<div style="display:-webkit-inline-box;">
										<label>Overall Product Experience: </label> <p class="modal-answers" style="display:-webkit-inline-box;word-wrap: break-word;"><?php echo $profile_data_modal[6]; ?></p>
									</div>
									
								</div>
							</div>
							
							<div class="row" style="margin-top: 5%;">
								<div class="col-lg-5">
									<h4 style="color:#23c6c8;font-weight: 400;font-size: 12px;margin-left:-14%">Purchases</h4>
								</div>
								<div class="col-lg-7" style="margin-left: -15%;margin-top: 2%;">
									<div style="display:table;">
										<label>Installation Date: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php if(!empty($brand_details['INSTALLATION_DATE'])){echo $brand_details['INSTALLATION_DATE'];} else {echo 'N/A';} ?></p>
									</div>
									<div style="display:table;">
										<label>Last Service: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php if(!empty($brand_details['last_service_date'])){echo $brand_details['last_service_date'];} else {echo 'N/A';} ?></p>
									</div>
									<div style="display:table;">
										<label>AMC Due Date: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php if(!empty($brand_details['req_amc_date'])){echo $brand_details['req_amc_date'];} else {echo 'N/A';} ?></p>
									</div>
									<div style="display:table;">
										<label>3rd party Service: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php if(!empty($brand_details['CONTRACT_BY'])){echo $brand_details['CONTRACT_BY'];} else {echo 'N/A';} ?></p>
									</div>
								</div>
							</div>
							
						</div>
													
						<div class="col-lg-4" style="border-right:1px solid #e5e5e5;padding-left: 29px;">					
							<div class="row" style="margin-top: 5%;">
								<div class="col-lg-5">
									<h4 style="color:#23c6c8;font-weight: 400;font-size: 12px;margin-left:-14%">Recall</h4>
								</div>
								<div class="col-lg-7" style="margin-left: -15%;margin-top: 2%;">
									<div style="display:table;">
										<label>Awareness: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php echo $profile_data_modal[7]; ?></p>
									</div>
									<div style="display:table;">
										<label>Familiar with offerings: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php echo $profile_data_modal[8]; ?></p>
									</div>
								</div>
							</div>
							
							<div class="row" style="margin-top: 20%;">
								<div class="col-lg-5">
									<h4 style="color:#23c6c8;font-weight: 400;font-size: 12px;margin-left:-14%">Brand Loyalty</h4>
								</div>
								<div class="col-lg-7" style="margin-left: -15%;margin-top: 2%;">
									<div style="display:table;">
										<label>Refer: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php echo $profile_data_modal[11]; ?></p>
									</div>
									<div style="display:table;">
										<label>Purchase intent: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php echo $profile_data_modal[12]; ?></p>
									</div>
								</div>
							</div>
							
							<div class="row" style="margin-top: 48%;">
								<div class="col-lg-5">
									<h4 style="color:#23c6c8;font-weight: 400;font-size: 12px;margin-left:-14%">Additional insight</h4>
								</div>
								<div class="col-lg-7" style="margin-left: -7%;margin-top: 2%;">
									<div style="display:table;">
										<label>Upgrade: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php echo $profile_data_modal[13]; ?></p>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-4" style="padding-left: 29px;">
							<div class="row" style="margin-top: 5%;">
								<div class="col-lg-5">
									<h4 style="color:#23c6c8;font-weight: 400;font-size: 12px;margin-left:-14%">Referral</h4>
								</div>
								<div class="col-lg-7" style="margin-left: -15%;margin-top: 2%;">
									<div style="display:table;">
										<label>Shares opinion: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php echo $profile_data_modal[14]; ?></p>
									</div>
									<div style="display:table;">
										<label>Influence: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php echo $profile_data_modal[15]; ?></p>
									</div>
									<div style="display:table;">
										<label>Referral interest: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php echo $profile_data_modal[16]; ?></p>
									</div>
									<div style="display:table;">
										<label>Provides Feedback: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php echo $profile_data_modal[17]; ?></p>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					
					<hr/ style="border: solid 1px dimgrey;margin-left: -30px;margin-right: -30px;">
					
					<div class="row">
						<div class="col-lg-4" style="border-right: 1px solid #e5e5e5;">
							<div class="row" style="margin-top: -5%;">
								<h2 style="display:inline;color:#ff6010;font-weight: 400;font-size: 13px;">Life Time Value</h2>
								<p class="modal-answers" style="display:inline;margin-left: 4px;color: #9acd32;font-size: 13px;"><?php echo $life_time_value; ?></p>
							</div>
						</div>
						
						<div class="col-lg-4" style="border-right: 1px solid #e5e5e5;padding-left: 29px;">
							<div class="row" style="margin-top: -5%;">
								<h2 style="display: inline;color:#ff6010;font-weight: 400;font-size: 13px;">Brand Value</h2>
								<p class="modal-answers" style="display: inline;margin-left: 4px;color: #9acd32;font-size: 13px;"><?php echo $brand_value; ?></p>
							</div>
						</div>
						
						<div class="col-lg-4" style="padding-left: 29px;">
							<div class="row" style="margin-top: -5%;">
								<h2 style="display: inline;color:#ff6010;font-weight: 400;font-size: 13px;">Referral Value</h2>
								<p class="modal-answers" style="display: inline;margin-left: 4px;color: #9acd32;font-size: 13px;"><?php echo $referral_value; ?></p>
							</div>
						</div>
					</div>
					
					<hr/ style="border: solid 1px dimgrey;margin-left: -30px;margin-right: -30px;margin-top:8px;">
					
					<div class="row" style="margin-top: -20px;">
						<div class="col-lg-4" style="border-right: 1px solid #e5e5e5;">
							<div class="row" style="margin-top: 3%;">
								<div class="col-lg-5">
									<h4 style="color:#23c6c8;font-weight: 400;font-size: 12px;margin-left:-14%">Transaction</h4>
								</div>
								<div class="col-lg-7" style="margin-left: -15%;margin-top: 2%;">
									<div style="display:table;">
										<label>Service Request: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;"><?php if(!empty($brand_details['req_service_date'])){echo $brand_details['req_service_date'];} else {echo 'N/A';} ?></p>
									</div>
									<div style="display:table;">
										<label>Status: </label> 
										<p class="modal-answers" style="display:table-cell;">
											<?php 
												if($brand_details['transaction_status'] == 0){
													echo 'N/A';
												} 
												if($brand_details['transaction_status'] == 1){
													echo 'Service Request Open';
												}
												if($brand_details['transaction_status'] == 2){
													echo 'Service Request Close';
												}
												if($brand_details['transaction_status'] == 3){
													echo 'AMC Request Open';
												}
												if($brand_details['transaction_status'] == 4){
													echo 'AMC Request Close';
												}
												if($brand_details['transaction_status'] == 5){
													echo 'Escalation Request Open';
												}
												if($brand_details['transaction_status'] == 6){
													echo 'Escalation Request Close';
												}
												if($brand_details['transaction_status'] == 7){
													echo 'Upgrade Request Open';
												}
												if($brand_details['transaction_status'] == 8){
													echo 'Upgrade Request Close';
												}
											?>
										</p>
									</div>
									<div style="display:table-cell;">
										<label>Escalations: </label> <p class="modal-answers" style="display:table-cell;"><?php if($brand_details['status'] == 16){echo 'Yes';} else {echo 'No';} ?></p>
									</div>
									<div style="display:table;">
										<label>AMC Enquiry: </label> <p class="modal-answers" style="display:table-cell;"><?php if(!empty($brand_details['req_amc_date'])){echo $brand_details['req_amc_date'];} else {echo 'N/A';} ?></p>
									</div>
									<div style="display:table;">
										<label>New Product Enquiry: </label> <p class="modal-answers" style="display:table-cell;">N/A</p>
									</div>
									<div style="display:table-cell;">
										<label>New Product Installation: </label> <p class="modal-answers" style="display:table-cell;">N/A</p>
									</div>
									<div style="display:table;">
										<label>Information Request: </label> <p class="modal-answers" style="display:table-cell;">N/A</p>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-4" style="border-right: 1px solid #e5e5e5;padding-left: 29px;">
							<div class="row" style="margin-top: 3%;">
								<div class="col-lg-5">
									<h4 style="color:#23c6c8;font-weight: 400;font-size: 12px;margin-left:-14%">Yapnaa Activities</h4>
								</div>
								<div class="col-lg-7" style="margin-left: -10%;margin-top: 2%;">
									<div style="display:table;">
										<label>Last Action: </label> <p class="modal-answers" style="display:table-cell;word-wrap: break-word;padding-left:5px;">N/A</p>
									</div>
									<div style="display:table;">
										<label>Next Action: </label> <p class="modal-answers" style="display:table-cell;">N/A</p>
									</div>
									<div style="display:table-cell;">
										<label>Call count: </label> <p class="modal-answers" style="display:table-cell;">N/A</p>
									</div>
									<div style="display:table;">
										<label>SMS count: </label> <p class="modal-answers" style="display:table-cell;">N/A</p>
									</div>
									<div style="display:table;">
										<label>Email count: </label> <p class="modal-answers" style="display:table-cell;">N/A</p>
									</div>
									<div style="display:table-cell;">
										<label>Enquiry: </label> <p class="modal-answers" style="display:table-cell;">N/A</p>
									</div>
									<div style="display:table;">
										<label>Escalation: </label> <p class="modal-answers" style="display:table-cell;">N/A</p>
									</div>
									<div style="display:table;">
										<label>Yapnaa registered: </label> <p class="modal-answers" style="display:table-cell;">N/A</p>
									</div>
								</div>
							</div>
						</div>
						
						<div class="col-lg-4" style="padding-left: 29px;">
							<div class="row" style="margin-top: 3%;">
								<div class="col-lg-5">
									<h4 style="color:#23c6c8;font-weight: 400;font-size: 12px;margin-left:-14%">Other Products</h4>
								</div>
								<div class="col-lg-7" style="margin-left: -10%;margin-top: 2%;">
									<div style="display:table;">
										<label></label> <p style="display:table-cell;"></p>
									</div>
									<div style="display:table;">
										<label></label> <p style="display:table-cell;"></p>
									</div>
									<div style="display:table;">
										<label></label> <p style="display:table-cell;"></p>
									</div>
									<div style="display:table;">
										<label></label> <p style="display:table-cell;"></p>
									</div>
									<div style="display:table;">
										<label></label> <p style="display:table-cell;"></p>
									</div>
									<div style="display:table;">
										<label></label> <p style="display:table-cell;"></p>
									</div><div style="display:table;">
										<label></label> <p style="display:table-cell;"></p>
									</div>
									<div style="display:table;">
										<label></label> <p style="display:table-cell;"></p>
									</div>
									<div style="display:table;">
										<label></label> <p style="display:table-cell;"></p>
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<hr/ style="border: solid 1px dimgrey;margin-left: -30px;margin-right: -30px;">
					
					<div class="row" style="">
						<div class="col-lg-8" style="">
							<div class="form-group">
								<label for="comment">Customer Comment:</label>
								<textarea class="form-control" rows="3" name="customer_comment" id="customer_comment"><?php if(!empty($brand_details['customer_comment'])){echo $brand_details['customer_comment'];} ?></textarea>
							</div>
						</div>
						<div class="col-lg-8" style="">
							<div class="form-group">
								<label for="comment">Customer Social Activities:</label>
								<textarea class="form-control" rows="3" name="customer_social_activities" id="customer_social_activities"><?php if(!empty($brand_details['customer_social_activities'])){echo $brand_details['customer_social_activities'];} ?></textarea>
							</div>
						</div>
						<div class="col-lg-4" style="margin-top:3%;">
							<button type="button" class="btn btn-success" style="background-color:#5cb85c;border-color:#5cb85c" id="customer_comment_button">SUBMIT</button>
							<div style="margin-top:10px;color:#dd4e4e;"><span id="comment_msg"></span></div>
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
	
		$('#customer_comment_button').on('click',function(event) {
			var customer_comment  			= $('#customer_comment').val();
			var customer_social_activities  = $('#customer_social_activities').val();
			var brand_name					= '<?php echo $_GET['customer_type'];?>';
			var user_id						= '<?php echo $_GET['user_id'];?>';
			var brand_customer_id			= '<?php echo $_GET['brand_customer_id'];?>';
			
			$.ajax({
				type: 'POST',
				dataType: "json",
				url: 'smsActions.php?saveCustomerComment=submit',
				data: "customer_comment="+customer_comment+'&customer_social_activities='+customer_social_activities+'&brand_name='+brand_name+'&user_id='+user_id+'&brand_customer_id='+brand_customer_id,
				
				success: function (response) {
					if(response == true){
						$('#comment_msg').html('Customer Comment Updated Successfully');
						$('#comment_msg').show();
						$('#comment_msg').fadeOut(7000);
						location.reload();
					}
				}
			});
			event.preventDefault();
		});
	
	</script>
	
	<script>
	
		$( document ).ready(function() {
			
			var selected_status		= <?php echo $brand_details['status'];?>;
			var req_service_date  	= "<?php echo $brand_details['req_service_date'];?>";
			var req_amc_date  		= "<?php echo $brand_details['req_amc_date'];?>";
			var req_upgrade_date  	= "<?php echo $brand_details['req_upgrade_date'];?>";
			var req_consumable_date = "<?php echo $brand_details['req_consumable_date'];?>";
			var req_follow_up_date  = "<?php echo $brand_details['req_follow_up_date'];?>";
			var last_call_comment  	= "<?php echo $brand_details['last_call_comment'];?>";
			var req_pm_service_date = "<?php echo $brand_details['req_pm_service_date'];?>";
			var not_interested_reason 	= "<?php echo $brand_details['not_interested_reason'];?>";
			
			if(selected_status == 0){
				document.getElementById('interested_service_status').style.visibility = "hidden";
				document.getElementById('service_date').style.visibility = "hidden";   
				document.getElementById('amc_date').style.visibility = "hidden";   
				document.getElementById('upgrade_date').style.visibility = "hidden";   
				document.getElementById('consumable_date').style.visibility = "hidden"; 
			}
			
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
			
			// For PM Service request date
			if(selected_status == 19){
				document.getElementById('pm_enquiry_service_status').style.visibility   = "visible";
				if(req_pm_service_date != ""){
					document.getElementById("interested_pm_service").checked 			= true;
					document.getElementById('pm_service_date').value = "<?php echo $brand_details['req_pm_service_date'];?>";
				}
			}else{
				document.getElementById('pm_enquiry_service_status').style.visibility   = "hidden";
				document.getElementById('pm_service_date').style.visibility 			= "hidden"; 
			}
			
			// Not interested service 
			if(selected_status == 2){
				document.getElementById('not_interested_service_status').style.visibility   = "visible";
			}else{
				document.getElementById('not_interested_service_status').style.visibility   = "hidden";
			}
			
			
			$("#question_answer_form").on('change', '#status', function(e){
				e.preventDefault(); 
				//var conceptName 	= $(this).children(":selected").text();
				var selected_value  = $(this).val();
				//alert(selected_value);
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
				
				if(selected_value == 19){
					document.getElementById('pm_enquiry_service_status').style.visibility   = "visible";
				}else{
					document.getElementById('pm_enquiry_service_status').style.visibility   = "hidden";
				}
				
				if(selected_value == 2){
					document.getElementById('not_interested_service_status').style.visibility   = "visible";
				}else{
					document.getElementById('not_interested_service_status').style.visibility   = "hidden";
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
				
				if($("#interested_pm_service").prop('checked') == true){
					document.getElementById('pm_service_date').style.visibility = "visible";
				}else{
					document.getElementById('pm_service_date').style.visibility = "hidden";
				}
				
			});
			
		});		
			
	</script>
	
	
	<script>
	
		function showProfileHistory(tm_id,tm_brand_user_id,tm_brand_id){
			$.ajax({
				url:"smsActions.php?show_profile_history=submit",
				type:"POST",
				data:{tm_id:tm_id,tm_brand_user_id:tm_brand_user_id,tm_brand_name:tm_brand_id},
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
