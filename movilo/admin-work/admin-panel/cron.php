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
?>
 