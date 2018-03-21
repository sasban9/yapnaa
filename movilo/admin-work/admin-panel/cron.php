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
	if(isset($_REQUEST['schedulecampaign'])){
	
	$schedulecampaign=$_REQUEST['schedulecampaign'];
		$_list = $control->schedule_campaign($schedulecampaign);		
		 
	}
?>
