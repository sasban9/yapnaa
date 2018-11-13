<?php 
require_once('controller/admin_controller.php');
$control	=	new admin();

function calculate_profile($group_subgroup_result){
	
	foreach($group_subgroup_result as $key4 => $value4){
		
		if($key4 == 'Customer Satisfaction Index'){
			$cscounter 				= 0;
			if(!empty($value4['Service'][0]['weightage'])){
				$cscounter  		= $cscounter + $value4['Service'][0]['weightage'];
			}
			if(!empty($value4['Service'][1]['weightage'])){
				$cscounter  		= $cscounter + $value4['Service'][1]['weightage'];
			}
			if(!empty($value4['Product'][0]['weightage'])){
				$cscounter  		= $cscounter + $value4['Product'][0]['weightage'];
			}
			if(!empty($value4['Product'][1]['weightage'])){
				$cscounter  		= $cscounter + $value4['Product'][1]['weightage'];
			}
			
			if($cscounter >= 13){
				$cs_customer_stats 	= 'High';
			}
			if($cscounter <= 12){
				$cs_customer_stats 	= 'Low';
			}
		}
		
		if($key4 == 'Customer Brand Engagement Index'){
			//echo "<br><pre>"; print_r($value4);	
			$cbecounter = 0;
			if(!empty($value4['Recall'][0]['weightage'])){
				$cbecounter  		= $cbecounter + $value4['Recall'][0]['weightage'];
			}
			if(!empty($value4['Recall'][1]['weightage'])){
				$cbecounter  		= $cbecounter + $value4['Recall'][1]['weightage'];
			}
			if(!empty($value4['Loyalty'][0]['weightage'])){
				$cbecounter  		= $cbecounter + $value4['Loyalty'][0]['weightage'];
			}
			if(!empty($value4['Loyalty'][1]['weightage'])){
				$cbecounter 		= $cbecounter + $value4['Loyalty'][1]['weightage'];
			}
			
			if($cbecounter >= 13){
				$cbe_customer_stats = 'High';
			}
			if($cbecounter <= 12){
				$cbe_customer_stats = 'Low';
			}
			
		}
		
		if($key4 == 'Customer Referal Value Index'){
			//echo "<br><pre>"; print_r($value4);
			$crvcounter 			= 0;
			if(!empty($value4['Potential'][0]['weightage'])){
				$crvcounter  		= $crvcounter + $value4['Potential'][0]['weightage'];
			}
			if(!empty($value4['Potential'][1]['weightage'])){
				$crvcounter  		= $crvcounter + $value4['Potential'][1]['weightage'];
			}
			if(!empty($value4['Interest'][0]['weightage'])){
				$crvcounter  		= $crvcounter + $value4['Interest'][0]['weightage'];
			}
			if(!empty($value4['Interest'][1]['weightage'])){
				$crvcounter  		= $crvcounter + $value4['Interest'][1]['weightage'];
			}
			if($crvcounter >= 13){
				$crv_customer_stats = 'High';
			}
			if($crvcounter <= 12){
				$crv_customer_stats = 'Low';
			}
		}
		
	}	
	
	//echo $cs_customer_stats; echo 'suman'; echo $cbe_customer_stats; echo 'kumar'; echo $crv_customer_stats;
	
	if($cs_customer_stats == 'High'){
		if($cs_customer_stats == 'High' && $cbe_customer_stats == 'High'){
			$selling_customer_category 		= 'True Loyalists';
			$selling_target_engagement_level= 'None';
		}
		if($cs_customer_stats == 'High' && $cbe_customer_stats == 'Low'){
			$selling_customer_category 		= 'Acquaintences';
			$selling_target_engagement_level= 'True Loyalists';
		}
		if($cs_customer_stats == 'Low' && $cbe_customer_stats == 'Low'){
			$selling_customer_category 		= 'Strangers';
			$selling_target_engagement_level= 'Acquaintences';
		}
		if($cs_customer_stats == 'Low' && $cbe_customer_stats == 'High'){
			$selling_customer_category 		= 'Poor Patrons';
			$selling_target_engagement_level= 'Strangers';
		}
	}
	
	if($cs_customer_stats == 'Low'){
		if($cbe_customer_stats == 'High' && $crv_customer_stats == 'High'){
			$selling_customer_category		= 'Enthusiasts';
			$digital_customer_category 		= 'Enthusiasts';
			$digital_target_engagement_level= 'None';
		}
		if($cbe_customer_stats == 'High' && $crv_customer_stats == 'Low'){
			$selling_customer_category 		= 'Admirers';
			$digital_customer_category 		= 'Admirers';
			$digital_target_engagement_level= 'Enthusiasts';
		}
		if($cbe_customer_stats == 'Low' && $crv_customer_stats == 'Low'){
			$selling_customer_category 		= 'Benchwarmers';
			$digital_customer_category 		= 'Benchwarmers';
			$digital_target_engagement_level= 'Admirers';
		}
		if($cbe_customer_stats == 'Low' && $crv_customer_stats == 'High'){
			$selling_customer_category 		= 'Opportunists';
			$digital_customer_category 		= 'Opportunists';
			$digital_target_engagement_level= 'Benchwarmers';
		}
	}	
			
	$response_array		= array('selling_customer_category' 		=> $selling_customer_category,
								'selling_target_engagement_level' 	=> $selling_target_engagement_level,
								'digital_customer_category' 		=> $digital_customer_category,
								'digital_target_engagement_level' 	=> $digital_target_engagement_level,
								'life_time_value'					=> $cs_customer_stats,
								'brand_value'						=> $cbe_customer_stats,
								'referral_value'					=> $crv_customer_stats,
								);	
							
	return $response_array;		
	
}


?>