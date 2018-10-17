<?php
require_once('controller/admin_controller.php');
	$control	=	new admin();
	
	
	
	if(isset($_REQUEST['followuptype'])){	
		$followuptype=$_REQUEST['followuptype'];
		$_list = $control->followup_cron($followuptype); 
	}
	
	if(isset($_REQUEST['conversionopp'])){		
		$conversionopp=$_REQUEST['conversionopp'];
		$_list = $control->conversion_oppertunity($conversionopp); 
	}
	
	if(isset($_REQUEST['amcupgrade'])){		
		$amcupgrade=$_REQUEST['amcupgrade'];
		$_list = $control->amcupgrade($amcupgrade); 
	}
	
	if(isset($_REQUEST['schedulecampaign1'])){
		$schedulecampaign=$_REQUEST['schedulecampaign1'];
		$_list = $control->schedule_campaign1($schedulecampaign);
	}
	
	if(isset($_REQUEST['schedulecampaign2'])){
		$schedulecampaign=$_REQUEST['schedulecampaign2'];
		$_list = $control->schedule_campaign2($schedulecampaign);
	}
	
	if(isset($_REQUEST['schedulecampaign3'])){
		$schedulecampaign=$_REQUEST['schedulecampaign3'];
		$_list = $control->schedule_campaign3($schedulecampaign);
	}
	
	if(isset($_REQUEST['schedulecampaign4'])){
		$schedulecampaign=$_REQUEST['schedulecampaign4'];
		$_list = $control->schedule_campaign4($schedulecampaign);
	}
	
	if(isset($_REQUEST['cust_type1'])){
		$cust_type=$_REQUEST['cust_type1'];
		$control->update_customer_type1($cust_type);
	}
	
	if(isset($_REQUEST['cust_type2'])){
		$cust_type=$_REQUEST['cust_type2'];
		$control->update_customer_type2($cust_type);
	}
	
	if(isset($_REQUEST['cust_type3'])){
		$cust_type=$_REQUEST['cust_type3'];
		$control->update_customer_type3($cust_type);
	}
	
	if(isset($_REQUEST['cust_type4'])){
		$cust_type=$_REQUEST['cust_type4'];
		$control->update_customer_type4($cust_type);
	}
	
	
	// Suman New Cron for Transaction lifecycle
	
	// Cron for Transaction lifecycle
	if(isset($_REQUEST['transaction_lifecycle'])){
		$customer_type		= $_REQUEST['transaction_lifecycle'];
		$control->transaction_lifecycle($customer_type);	
	}
	
	// Cron for Productchange lifecycle
	if(isset($_REQUEST['productchange_lifecycle'])){
		$customer_type		= $_REQUEST['productchange_lifecycle'];
		$control->productchange_lifecycle($customer_type);
	}
	
	// Cron for Escalation lifecycle
	if(isset($_REQUEST['escalation_lifecycle'])){
		$customer_type		= $_REQUEST['escalation_lifecycle'];
		$control->escalation_lifecycle($customer_type);
	}
	
	// Cron for AMC after 120 days of AMC start days
	if(isset($_REQUEST['amc_message'])){
		$customer_type		= $_REQUEST['amc_message'];
		$control->amc_message($customer_type);
	}
	
	
	// Cron for welcome sms to all customer after uploaded data and who are not updated anything in brand
	if(isset($_REQUEST['promotional_welcome_sms'])){
		$customer_type 		= $_REQUEST['promotional_welcome_sms'];
		$control->promotional_welcome_sms($customer_type);
	}
	
	
	// Cron for livepure amc
	if(isset($_REQUEST['amc_cron'])){
		$customer_type 		= $_REQUEST['amc_cron'];
		$control->amc_cron($customer_type);
	}
	

	
		
?>
 