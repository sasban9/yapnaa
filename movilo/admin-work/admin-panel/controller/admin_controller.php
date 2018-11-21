<?php 
require 'PHPMailerAutoload.php';  
require_once("model/model.php");

include 'encryption_decryption.php';

$obj_model	=new	model; 

//Controller to perform all admin functions
class admin	{
	
	function __construct(){
		global $obj_model;
		global $tb;
		$this->model=& $obj_model;

	}
	function user_responce_based_on_phone($custType,$phone_no){
		/* switch($cust_type){
			case 1:
		    $table		=	'livpure';
            break;
			case 2:
		    $table		=	'zerob_consol1';
            break;			
		}  */
	$responce=	$this->model->data_query("SELECT  yq.questions,um.qst_id,um.answer,um.user_phone FROM user_question_aws_mapping um left join yapnaa_questions yq on um.qst_id=yq.id  where um.user_phone=$phone_no");
	return $responce;
	}
	function update_customer_type($cust_type){
		switch($cust_type){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		
		$highlyengaged		=	$this->model->data_query("SELECT *, 
		(SELECT date FROM user_question_aws_mapping WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS date 
		FROM $table zc where zc.phone1 in
		(select user_phone from user_question_aws_mapping where qst_id=3  and answer='Yes')
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='Yes')
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12  and answer='Yes') 
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='Yes')" 
			);
		//print_r($highlyengaged);exit;  
		foreach($highlyengaged as $cust_type1)
		{
			    $condition_highly="CUSTOMERID='".$cust_type1['CUSTOMERID']."'";
				$array_update_highly=array('last_called'=>$cust_type1['date'],'customet_type'=>1);
				$this->model->update($table,$array_update_highly,$condition_highly);
			
		}
		$engaged		=	$this->model->data_query("SELECT *,
			(SELECT date FROM user_question_aws_mapping WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS date FROM $table zc where 
			zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='Yes') 
			and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='Yes')
			and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='Yes') 
			and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  
			and  answer='No')");
        foreach($engaged as $cust_type2)
		{
			    $condition_engaged="CUSTOMERID='".$cust_type2['CUSTOMERID']."'";			   
				$array_update_engaged=array('last_called'=>$cust_type2['date'],'customet_type'=>2);
				$this->model->update($table,$array_update_engaged,$condition_engaged);
			
		} 
        $partiallyengaged = $this->model->data_query("SELECT *,
			(SELECT date FROM user_question_aws_mapping WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS date FROM $table zc WHERE zc.phone1 IN 
(SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =3 AND answer = 'Yes' )
AND zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =4 AND answer = 'Yes' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer in('No') )
AND zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =12 AND answer = 'No')");
       foreach($partiallyengaged as $cust_type3)
		{
			    $condition_partialy="CUSTOMERID='".$cust_type3['CUSTOMERID']."'";			  
				$array_update_partialy=array('last_called'=>$cust_type3['date'],'customet_type'=>3);
				$this->model->update($table,$array_update_partialy,$condition_partialy);
			
		}
      $Disinterested = $this->model->data_query("SELECT *, (SELECT date FROM user_question_aws_mapping WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS date
								FROM $table zc where 
					(
					(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No') 
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No') 
					and 
					zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No')
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No')
					) 
					or  
					(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='Yes') 
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No') 
					and 
					zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No')
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No')
					) 
					or
					(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No') 
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No') 
					and 
					zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No')
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='Yes')
					)
					)
   ");
       foreach($Disinterested as $cust_type4)
		{
			    $condition_disinterested="CUSTOMERID='".$cust_type4['CUSTOMERID']."'";			    
				$array_update_disinterested=array('last_called'=>$cust_type4['date'],'customet_type'=>4);
				$this->model->update($table,$array_update_disinterested,$condition_disinterested);
			
		}
	}
	function highlyengaged_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1	='Livpure';
			$brand_img	="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highlyengaged1		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3  and answer='Yes' $condition ) 
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='Yes' $condition )
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12  and answer='Yes' $condition ) 
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='Yes' $condition )");
		return $highlyengaged1;
	}
	function periodic_update_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$periodic_update		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=14  and answer='Yes' $condition ) 
		");
		return $periodic_update;
	}
	function periodic_feedback_to_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$periodic_feedback		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=15  and answer='Yes' $condition ) 
		");
		return $periodic_feedback;
	}
	function attempt_to_gather_knowledge_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$attempt_to_gather_knowledge		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=13  and answer='Yes' $condition ) 
		");
		return $attempt_to_gather_knowledge;
	}
	function willingness_to_refer_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$willingness_to_refer		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12  and answer='Yes' $condition ) 
		");
		return $willingness_to_refer;
	}
	function get_support_on_time_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$get_support_on_time		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=11  and answer='Yes' $condition ) 
		");
		return $get_support_on_time;
	}
	function made_right_choice_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$made_right_choice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=10  and answer='Yes' $condition ) 
		");
		return $made_right_choice;
	}
	function share_positive_experience_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$share_positive_experience		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=9  and answer='Yes' $condition ) 
		");
		return $share_positive_experience;
	}
	function disengaged_under_AMC_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$disengaged_under_AMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=4 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='Yes' $condition ) 
		");
		return $disengaged_under_AMC;
	}
	function poor_service_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   } 
		$poor_service		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=4 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=8  and answer='Poor service experience' $condition ) 
		");
		return $poor_service;
	}
	function negative_expirence_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   } 
		$negativeexpirence		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=4 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=8  and answer='Negative product experience' $condition ) 
		");
		return $negativeexpirence;
	}
	function will_call_when_required_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   } 
		$will_call_when_required		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=4 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=8  and answer='Will call when service needed' $condition ) 
		");
		return $will_call_when_required;
	}
	function service_not_required_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   } 
		$service_not_required		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where zc.customet_type=4 and  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=8  and answer='Service not required' $condition ) 
		");
		return $service_not_required;
	}
	function highly_engaged_last_paid_service_6month_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   } 
		$highly_engaged_last_paid_service_6month		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=1  and answer='Less than 6 months' $condition ) 
		");
		return $highly_engaged_last_paid_service_6month;
	}
	function highly_engaged_last_paid_service_1year_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){ 
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   } 
		$highly_engaged_last_paid_service_1year		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=1  and answer='Less than 1 year' $condition ) 
		");
		return $highly_engaged_last_paid_service_1year;
	}
	function highly_engaged_under_AMC_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_under_AMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='Yes' $condition ) 
		");
		return $highly_engaged_under_AMC;
	}
	function highly_engaged_under_AMC_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_under_AMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='No' $condition ) 
		");
		return $highly_engaged_under_AMC;
	}
	function highly_engaged_withtimeline_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_withtimeline		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3  and answer='Yes' $condition ) 
		");
		return $highly_engaged_withtimeline;
	}
	function highly_engaged_withtimeline_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_withtimeline		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3  and answer='No' $condition ) 
		");
		return $highly_engaged_withtimeline;
	}
	function highly_engaged_withquality_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_withquality		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='Yes' $condition ) 
		");
		return $highly_engaged_withquality;
	}
	function highly_engaged_withquality_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_withquality		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='No' $condition ) 
		");
		return $highly_engaged_withquality;
	}
	function highly_engaged_feedbackservice_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_feedbackservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=5  and answer='Yes' $condition ) 
		");
		return $highly_engaged_feedbackservice;
	}
	function highly_engaged_feedbackservice_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_feedbackservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=5  and answer='No' $condition ) 
		");
		return $highly_engaged_feedbackservice;
	}
	function highly_engaged_requiredservice_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_requiredservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=17  and answer='Yes' $condition ) 
		");
		return $highly_engaged_requiredservice;
	}
	function highly_engaged_requiredservice_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_requiredservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=17  and answer='No' $condition ) 
		");
		return $highly_engaged_requiredservice;
	}
	function highly_engaged_requestAMC_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_requestAMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=19  and answer='Yes' $condition ) 
		");
		return $highly_engaged_requestAMC;
	}
	function highly_engaged_requestAMC_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_requestAMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=19  and answer='No' $condition ) 
		");
		return $highly_engaged_requestAMC;
	}
	function highly_engaged_wishUpgrade_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_wishUpgrade		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=21  and answer='Yes' $condition ) 
		");
		return $highly_engaged_wishUpgrade;
	}
	function highly_engaged_wishUpgrade_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$highly_engaged_wishUpgrade		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=1 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=21  and answer='No' $condition ) 
		");
		return $highly_engaged_wishUpgrade;
	}
	
	function engaged_last_paid_service_6month_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   } 
		$engaged_last_paid_service_6month		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=1  and answer='Less than 6 months' $condition ) 
		");
		return $engaged_last_paid_service_6month;
	}
	function engaged_last_paid_service_1year_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){ 
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   } 
		$engaged_last_paid_service_1year		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=1  and answer='Less than 1 year' $condition ) 
		");
		return $engaged_last_paid_service_1year;
	}
	function engaged_under_AMC_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_under_AMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='Yes' $condition ) 
		");
		return $engaged_under_AMC;
	}
	function engaged_under_AMC_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_under_AMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='No' $condition ) 
		");
		return $engaged_under_AMC;
	}
	function engaged_withtimeline_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_withtimeline		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3  and answer='Yes' $condition ) 
		");
		return $engaged_withtimeline;
	}
	function engaged_withtimeline_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_withtimeline		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3  and answer='No' $condition ) 
		");
		return $engaged_withtimeline;
	}
	function engaged_withquality_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_withquality		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='Yes' $condition ) 
		");
		return $engaged_withquality;
	}
	function engaged_withquality_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_withquality		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='No' $condition ) 
		");
		return $engaged_withquality;
	}
	function engaged_feedbackservice_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_feedbackservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=5  and answer='Yes' $condition ) 
		");
		return $engaged_feedbackservice;
	}
	function engaged_feedbackservice_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_feedbackservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=5  and answer='No' $condition ) 
		");
		return $engaged_feedbackservice;
	}
	function engaged_requiredservice_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_requiredservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=17  and answer='Yes' $condition ) 
		");
		return $engaged_requiredservice;
	}
	function engaged_requiredservice_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_requiredservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=17  and answer='No' $condition ) 
		");
		return $engaged_requiredservice;
	}
	
	function engaged_requestAMC_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_requestAMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=19  and answer='Yes' $condition ) 
		");
		return $engaged_requestAMC;
	}
	function engaged_requestAMC_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_requestAMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=19  and answer='No' $condition ) 
		");
		return $engaged_requestAMC;
	}
	function engaged_wishUpgrade_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_wishUpgrade		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=21  and answer='Yes' $condition ) 
		");
		return $engaged_wishUpgrade;
	}
	function engaged_wishUpgrade_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged_wishUpgrade		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=2 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=21  and answer='No' $condition ) 
		");
		return $engaged_wishUpgrade;
	}
	  
		function partialy_engaged_last_paid_service_6month_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   } 
		$partialy_engaged_last_paid_service_6month		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=1  and answer='Less than 6 months' $condition ) 
		");
		return $partialy_engaged_last_paid_service_6month;
	}
	function partialy_engaged_last_paid_service_1year_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){ 
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1'; 
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   } 
		$partialy_engaged_last_paid_service_1year		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and  
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=1  and answer='Less than 1 year' $condition ) 
		");
		return $partialy_engaged_last_paid_service_1year;
	}
	function partialy_engaged_under_AMC_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_under_AMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='Yes' $condition ) 
		");
		return $partialy_engaged_under_AMC;
	}
	function partialy_engaged_under_AMC_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_under_AMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='No' $condition ) 
		");
		return $partialy_engaged_under_AMC;
	}
	function partialy_engaged_withtimeline_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_withtimeline		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3  and answer='Yes' $condition ) 
		");
		return $partialy_engaged_withtimeline;
	}
	function partialy_engaged_withtimeline_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_withtimeline		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3  and answer='No' $condition ) 
		");
		return $partialy_engaged_withtimeline;
	}
	function partialy_engaged_withquality_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_withquality		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='Yes' $condition ) 
		");
		return $partialy_engaged_withquality;
	}
	function partialy_engaged_withquality_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_withquality		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='No' $condition ) 
		");
		return $partialy_engaged_withquality;
	}
	function partialy_engaged_feedbackservice_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_feedbackservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=5  and answer='Yes' $condition ) 
		");
		return $partialy_engaged_feedbackservice;
	}
	function partialy_engaged_feedbackservice_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_feedbackservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=5  and answer='No' $condition ) 
		");
		return $partialy_engaged_feedbackservice;
	}
	function partialy_engaged_requiredservice_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_requiredservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=17  and answer='Yes' $condition ) 
		");
		return $partialy_engaged_requiredservice;
	}
	function partialy_engaged_requiredservice_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_requiredservice		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=17  and answer='No' $condition ) 
		");
		return $partialy_engaged_requiredservice;
	}
	function partialy_engaged_requestAMC_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_requestAMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=19  and answer='Yes' $condition ) 
		");
		return $partialy_engaged_requestAMC;
	}
	function partialy_engaged_requestAMC_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_requestAMC		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=19  and answer='No' $condition ) 
		");
		return $partialy_engaged_requestAMC;
	}
	function partialy_engaged_wishUpgrade_customer_yes($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_wishUpgrade		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=21  and answer='Yes' $condition ) 
		");
		return $partialy_engaged_wishUpgrade;
	}   
	function partialy_engaged_wishUpgrade_customer_no($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partialy_engaged_wishUpgrade		=	$this->model->data_query("SELECT count(*) as users FROM $table zc where  zc.customet_type=3 and
		zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=21  and answer='No' $condition ) 
		");
		return $partialy_engaged_wishUpgrade;
	}   
	
	function engaged_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$engaged1		=	$this->model->data_query("SELECT count(*) as users  FROM $table  zc WHERE 
(zc.phone1
IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =3 AND answer =  'Yes' $condition ) AND zc.phone1 IN (
SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =4 AND answer =  'Yes' $condition ) AND zc.phone1
IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =12
AND answer =  'Yes' $condition ) AND  zc.phone1 IN (
SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =2
AND answer =  'No' $condition))");
       return $engaged1;
	}
	function partialy_engaged_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$partiallyengaged1 = $this->model->data_query("SELECT count(*) as users  FROM $table zc
WHERE  
zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =3 AND answer =  'Yes' $condition
 )AND zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =4 AND answer =  'Yes' $condition
 )and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  
			and answer in('No') $condition )AND zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping
WHERE qst_id =12 AND answer =  'No' $condition
 )");
       return $partiallyengaged1;
	}
	function disengaged_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		}
       if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }		
		$Disinterested1 = $this->model->data_query("SELECT count(*) as users 
FROM $table zc where    
((zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No' $condition ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' $condition ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' $condition )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No' $condition )) 
or(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='Yes' $condition ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' $condition ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' $condition )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No' $condition )) 
or(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No' $condition ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' $condition ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' $condition )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='Yes'  $condition)
))
   ");
       return $Disinterested1;
	}
	function notattempted_customer($schedulecampaign,$fromDate,$toDate){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			 
		}
       if($fromDate !='' && $toDate !='')
	   {		   
		$condition="and date(date) between date('".$fromDate."') and date('".$toDate."')";
	   }
	   else
	   {
		$condition="";   
	   }
		$notattempted = $this->model->data_query("SELECT count(*) as users FROM $table zc where 
		zc.phone1 not in (select user_phone from user_question_aws_mapping where zc.phone1=user_question_aws_mapping.user_phone $condition)");
       return $notattempted;
	}
	function schedule_campaign1($schedulecampaign){
		//echo "here";exit;
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		$highlyengaged1		=	$this->model->data_query("SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 
		GROUP by zc.CUSTOMERID) AS users FROM $table zc where (zc.highly_engaged in ('') or(zc.highly_engaged in (2) and CURDATE( ) >= DATE( DATE_ADD( updated_on, INTERVAL 14 DAY ) )))   
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3  and answer='Yes') 
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='Yes' )
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12  and answer='Yes' ) 
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='Yes' )");
		$highlyengaged2		=	$this->model->data_query("SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 
		GROUP by zc.CUSTOMERID) AS users FROM $table zc where zc.highly_engaged in ('',1) and CURDATE() >= DATE( DATE_ADD(updated_on, INTERVAL 14 DAY ) ) 
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3  and answer='Yes') 
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='Yes' )
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12  and answer='Yes' ) 
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='Yes' )");
        if($highlyengaged1 !=NULL){
		$highlyengaged=$highlyengaged1; 
		   
         }
		 else if($highlyengaged2 !=NULL){
			 $highlyengaged=$highlyengaged2;
			
		 }
		
		$count=0;
		//echo '<pre>';print_r($highlyengaged);die;//print_r($highlyengaged);print_r($Engaged);print_r($partiallyengaged);die;	
		foreach($highlyengaged as $customer_info){
			$userphone= $customer_info['PHONE1'];
			$username= $customer_info['CUSTOMER_NAME'];
			$email= $customer_info['email'];
			$custid= $customer_info['CUSTOMERID'];
			$highly_engaged= $customer_info['highly_engaged'];
			
			//check customer after 15 days			
			$check15days		=	$this->model->data_query("SELECT user_phone FROM user_question_aws_mapping
WHERE user_phone =$userphone AND CURDATE( ) >= DATE( DATE_ADD( DATE, INTERVAL 14 DAY ) ) ");
            if(($check15days !=NULL) && (($highly_engaged ==2) || ($highly_engaged ==''))){
               $count=1;
			    $brandresult	=	$this->model->update($table,array('highly_engaged'=>$count,'updated_on'=>date('Y-m-d h:i:s')),
				"CUSTOMERID='".$custid."'");
				 if($email !=''){
				$brand_img="yapnaa-new-logo.png";		   
				$text="<p style='font-weight:lighter;'>Dear $username,</p>"." 
						<p style='text-align:left;font-weight:normal;'>Now you can manage and secure all your home appliances and connect with brands for any support in the easiest way!
						</p>
 
							<br><p style='text-align:center'>   
							<a href='http://bit.ly/yapnaa-website'>
							<input type='button' 
							style='width:33%;font-weight:normal;background-color:#fc7f2b;border-radius:20px;color:#fff;font:inherit;line-height:3;font-size:14px;border:none' value='Know More'/></a></p>

							<p style='text-align:center;font-family:arial,sans-serif;'>
							<a href='http://bit.ly/YapnaaForAndroid'>
							<img src='https://yapnaa.com/images/1-Yapnaa.gif' alt='Yapnaa' height='60%' width='60%'>
							 </a>
							</p> 
							";
				$subject="One app to secure all your appliances";
				
				$this->sendmail_phpmailer($text,$subject,$email,$brand_img);
				      }				
					else{
	                     $text="Dear ".ucfirst($username).",\nNow you can manage and secure all your home appliances and connect with brands for any support in the easiest way!
 http://bit.ly/YapnaaForAndroid";	
						 $userphone=array($userphone);				
						$this->send_bulk_sms($userphone,$text);
					}
			}
            
			//check customer after 30 days			
			$check30days		=	$this->model->data_query("SELECT user_phone FROM user_question_aws_mapping
WHERE user_phone =$userphone AND CURDATE( ) >= DATE( DATE_ADD( DATE, INTERVAL 29 DAY ) ) ");
            if(($check30days !=NULL) && (($highly_engaged ==1) || ($highly_engaged ==''))){
				 $count=2;
				  $brandresult	=	$this->model->update($table,array('highly_engaged'=>$count,'updated_on'=>date('Y-m-d h:i:s')),
				"CUSTOMERID='".$custid."'");
				if($email !=''){
				$brand_img="yapnaa-new-logo.png";	 		
				$text="<p style='font-weight:lighter;'>Dear ".ucfirst($username).",</p> 
<p style='text-align:left;font-weight:normal;line-height:3'>Yapnaa is your after sales companion to manage your home appliances and connect with brands directly for any service support.http://bit.ly/yapnaa-website.</p>
  
<p style='text-align:center'>   
<a href='http://bit.ly/YapnaaForAndroid'>
<input type='button' 
style='width:33%;font-weight:normal;background-color:#fc7f2b;border-radius:20px;color:#fff;font:inherit;line-height:3;font-size:14px;border:none' value='Download app'/></a></p>

<p style='text-align:center;font-family:arial,sans-serif;'>
<a href='http://bit.ly/YapnaaForAndroid'>
<img src='https://yapnaa.com/images/yapnaa-after_scal.jpg' alt='Yapnaa' height='100%' width='100%'> 
 </a>
</p> ";
				$subject="After Sales companion for all your appliances";
				
				$this->sendmail_phpmailer($text,$subject,$email,$brand_img);
				      }				
					else{
	                     $text="Dear ".ucfirst($username).",\nYapnaa is your after sales companion to manage your home appliances and connect with brands directly for any service support.http://bit.ly/yapnaa-website";	
						 $userphone=array($userphone);				
						$this->send_bulk_sms($userphone,$text);
					}
			}
			
		}
       return true;
		
	}
	function schedule_campaign2($schedulecampaign){
		//echo"here";
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		}
		$Engaged1  = $this->model->data_query("SELECT * , (SELECT user_phone FROM users WHERE user_phone = zc.phone1
or user_phone = zc.phone2 GROUP BY zc.CUSTOMERID) AS users FROM $table  zc WHERE (zc.engaged in ('') or (zc.engaged in (2) and CURDATE() >= DATE( DATE_ADD(updated_on, INTERVAL 14 DAY ) )))  and
(zc.phone1
IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =3 AND answer =  'Yes' ) AND zc.phone1 IN (
SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =4 AND answer =  'Yes'  ) AND zc.phone1
IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =12
AND answer =  'Yes' ) AND  zc.phone1 IN (
SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =2
AND answer =  'No'))");

         $Engaged2  = $this->model->data_query("SELECT * , (SELECT user_phone FROM users WHERE user_phone = zc.phone1
or user_phone = zc.phone2 GROUP BY zc.CUSTOMERID) AS users FROM $table  zc WHERE    zc.engaged in ('',1)   and CURDATE() >= DATE( DATE_ADD(updated_on, INTERVAL 14 DAY ) ) and
(zc.phone1
IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =3 AND answer =  'Yes' ) AND zc.phone1 IN (
SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =4 AND answer =  'Yes'  ) AND zc.phone1
IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =12
AND answer =  'Yes' ) AND  zc.phone1 IN (
SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =2
AND answer =  'No' ))");
          if($Engaged1 !=NULL){
		$Engaged=$Engaged1; 
		   
         }
		 else if($Engaged2 !=NULL){
			 $Engaged=$Engaged2;
			 
		 }
		
        $count=0;
		//echo '<pre>';print_r($Engaged);die;//print_r($highlyengaged);print_r($Engaged);print_r($partiallyengaged);die;	
		foreach($Engaged as $customer_info){
							
			$userphone= $customer_info['PHONE1'];
			$username= $customer_info['CUSTOMER_NAME'];
			$email= $customer_info['email'];
			$custid= $customer_info['CUSTOMERID'];
			$engaged= $customer_info['engaged'];
			//check customer after 15 days			
			$check15days		=	$this->model->data_query("SELECT user_phone FROM user_question_aws_mapping
WHERE user_phone =$userphone AND CURDATE( ) >= DATE( DATE_ADD( DATE, INTERVAL 14 DAY ) ) ");
            if(($check15days !=NULL) && (($engaged ==2)|| ($engaged ==''))){				 
				$count=1;
				$brandresult	=	$this->model->update($table,array('engaged'=>$count,'updated_on'=>date('Y-m-d h:i:s')),
				"CUSTOMERID='".$custid."'"); 
				if($email !=''){
				$text="<p style='font-weight:lighter;'>Dear $username,</p>"." 
<p style='text-align:left;font-weight:normal;'>Get annual maintenance contract to ensure that your water filter works efficiently!</p>

<br><p style='text-align:center'>  
<a href='http://bit.ly/livpure_amc'>
<input type='button' 
style='width:33%;font-weight:normal;background-color:#442c8b;border-radius:20px;color:#fff;font:inherit;line-height:2;font-size:14px;border:none' value='Enquire to Know
'/></a></p><br>

<p style='text-align:center;font-family:arial,sans-serif;'>Why it is important to take AMC from Livpure for your RO Water Purifier? 
</p>
<p style='font-family:arial,sans-serif;font-weight:normal;text-align:left;'>

<ul>
<li style='font-weight:normal;line-height:3;'>Ensures uninterrupted supply of Pure & Safe Water</li>
<li style='font-weight:normal;line-height:3;'>Periodic Maintenance, Cleaning of Filters, Replacement of Consumables to avoid Break-down.</li>
<li style='font-weight:normal;line-height:3;'>1 year comprehensive warranty</li>
<li style='font-weight:normal;line-height:3;'>No Service Charges for any Break-Down Spare Parts</li>
<li style='font-weight:normal;line-height:3;'>Assurance of genuine Livpure Spare Parts</li>
<li style='font-weight:normal;line-height:3;'>Free Replacement of Electrical/Electronic Parts in case of Failure</li>
<li style='font-weight:normal;line-height:3;'>Service by Verified, Certified & Trained Company Engineers</li>
 </ul> 
</p>
<p style='text-align:center'> 
<a href='http://bit.ly/livpure_amc'>
<input type='button' 
style='width:50%;font-weight:normal;background-color:#fc7f2b;border-radius:20px;color:#fff;font:inherit;line-height:2.5;font-size:14px;border:none' value='Avail AMC Service Today'/></a></p>
";
				$subject="Secure your water purifier with AMC";  
                $this->sendmail_phpmailer($text,$subject,$email,$brand_img);
				}else{
				 $text="Dear ".ucfirst($username).",\nGet annual maintenance contract to ensure that your water filter works efficiently
http://bit.ly/livpure_amc";	
                 $userphone=array($userphone);				
				$this->send_bulk_sms($userphone,$text);
				}
			}
            
			//check customer after 30 days			
			$check30days		=	$this->model->data_query("SELECT user_phone FROM user_question_aws_mapping
WHERE user_phone =$userphone AND CURDATE( ) >= DATE( DATE_ADD( DATE, INTERVAL 29 DAY ) ) ");
            if(($check30days !=NULL) && (($engaged ==1)|| ($engaged ==''))){
				$count=2;
				 $brandresult	=	$this->model->update($table,array('engaged'=>$count,'updated_on'=>date('Y-m-d h:i:s')),
				"CUSTOMERID='".$custid."'"); 
				if($email !=''){
				$brand_img="yapnaa-new-logo.png";	
				$text="<p style='font-weight:lighter;'>Dear $username,</p>"." 
<p style='text-align:left;font-weight:normal;'>Now you can manage and secure all your home appliances and connect with brands for any support in the easiest way!
</p>
 
<br><p style='text-align:center'>   
<a href='http://bit.ly/yapnaa-website'>
<input type='button' 
style='width:33%;font-weight:normal;background-color:#fc7f2b;border-radius:20px;color:#fff;font:inherit;line-height:3;font-size:14px;border:none' value='Know More'/></a></p>

<p style='text-align:center;font-family:arial,sans-serif;'>
<a href='http://bit.ly/YapnaaForAndroid'>
<img src='https://yapnaa.com/images/1-Yapnaa.gif' alt='Yapnaa' height='60%' width='60%'>
 </a>
</p> 
";
				$subject="One app to secure all your appliances";
				$this->sendmail_phpmailer($text,$subject,$email,$brand_img);
				}else{
			    $text="Dear ".ucfirst($username).",\nNow you can manage and secure all your home appliances and connect with brands for any support in the easiest way!
http://bit.ly/YapnaaForAndroid";	
                $userphone=array($userphone);				
				$this->send_bulk_sms($userphone,$text);
				}
			} 
			 
		}
       return true;
		
	}
	function schedule_campaign3($schedulecampaign){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		}
		 $partiallyengaged1 = $this->model->data_query("SELECT * , (SELECT user_phone FROM users
WHERE user_phone = zc.phone1 OR user_phone = zc.phone2 GROUP BY zc.CUSTOMERID) AS users FROM $table zc
WHERE  (zc.partialy_engaged in ('') or (zc.partialy_engaged in(2) and CURDATE() >= DATE( DATE_ADD(updated_on, INTERVAL 14 DAY ))))   and
zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =3 AND answer =  'Yes'
 )AND zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =4 AND answer =  'Yes'
 )and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  
			and answer in('No') )AND zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping
WHERE qst_id =12 AND answer =  'No'
 )"); 
         $partiallyengaged2 = $this->model->data_query("SELECT * , (SELECT user_phone FROM users
WHERE user_phone = zc.phone1 OR user_phone = zc.phone2 GROUP BY zc.CUSTOMERID) AS users FROM $table zc
WHERE  zc.partialy_engaged in ('',1)   and CURDATE() >= DATE( DATE_ADD(updated_on, INTERVAL 14 DAY ) ) and
zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =3 AND answer =  'Yes'
 )AND zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =4 AND answer =  'Yes'
 )and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  
			and answer in('No') )AND zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping
WHERE qst_id =12 AND answer =  'No'
 )"); 
         if($partiallyengaged1 !=NULL){
		$partiallyengaged=$partiallyengaged1; 
		   
         }
		 else if($partiallyengaged2 !=NULL){
			 $partiallyengaged=$partiallyengaged2;
			 
		 }
		
		$count=0;
		//echo '<pre>';print_r($partiallyengaged);die;//print_r($highlyengaged);print_r($Engaged);print_r($partiallyengaged);die;	
		foreach($partiallyengaged as $customer_info){
			//echo "here2";
			$userphone= $customer_info['PHONE1'];
			$username= $customer_info['CUSTOMER_NAME'];
			$email= $customer_info['email'];
			$custid= $customer_info['CUSTOMERID'];
			$partialy_engaged= $customer_info['partialy_engaged'];
			//check customer after 15 days			
			$check15days		=	$this->model->data_query("SELECT user_phone FROM user_question_aws_mapping
WHERE user_phone =$userphone AND CURDATE( ) >= DATE( DATE_ADD( DATE, INTERVAL 14 DAY ) ) ");
            if(($check15days !=NULL) && (($partialy_engaged =='') || ($partialy_engaged ==2))){
				$count=1;
                 $brandresult	=	$this->model->update($table,array('partialy_engaged'=>$count,'updated_on'=>date('Y-m-d h:i:s')),
				"CUSTOMERID='".$custid."'"); 
				if($email !=''){   
$text="<p style='font-weight:lighter;'>Dear $username,</p>"." 
<p style='text-align:left;font-weight:normal;'>Get annual maintenance contract to ensure that your water filter works efficiently!</p>

<br><p style='text-align:center'>  
<a href='http://bit.ly/livpure_amc'>
<input type='button' 
style='width:33%;font-weight:normal;background-color:#442c8b;border-radius:20px;color:#fff;font:inherit;line-height:2;font-size:14px;border:none' value='Enquire to Know
'/></a></p><br>

<p style='text-align:center;font-family:arial,sans-serif;'>Why it is important to take AMC from Livpure for your RO Water Purifier? 
</p>
<p style='font-family:arial,sans-serif;font-weight:normal;text-align:left;'>

<ul>
<li style='font-weight:normal;line-height:3;'>Ensures uninterrupted supply of Pure & Safe Water</li>
<li style='font-weight:normal;line-height:3;'>Periodic Maintenance, Cleaning of Filters, Replacement of Consumables to avoid Break-down.</li>
<li style='font-weight:normal;line-height:3;'>1 year comprehensive warranty</li>
<li style='font-weight:normal;line-height:3;'>No Service Charges for any Break-Down Spare Parts</li>
<li style='font-weight:normal;line-height:3;'>Assurance of genuine Livpure Spare Parts</li>
<li style='font-weight:normal;line-height:3;'>Free Replacement of Electrical/Electronic Parts in case of Failure</li>
<li style='font-weight:normal;line-height:3;'>Service by Verified, Certified & Trained Company Engineers</li>
 </ul> 
</p>
<p style='text-align:center'> 
<a href='http://bit.ly/livpure_amc'>
<input type='button' 
style='width:50%;font-weight:normal;background-color:#fc7f2b;border-radius:20px;color:#fff;font:inherit;line-height:2.5;font-size:14px;border:none' value='Avail AMC Service Today'/></a></p>
";
				$subject="Secure your water purifier with AMC"; 
               				
				$this->sendmail_phpmailer($text,$subject,$email,$brand_img);
				}else{
                $text="Dear ".ucfirst($username).",\nGet annual maintenance contract to ensure that your water filter works efficiently. Know why it is important http://bit.ly/livpure_amc
";	
                 $userphone=array($userphone);				
				$this->send_bulk_sms($userphone,$text);
				}
			}
            
			//check customer after 30 days			
			$check30days		=	$this->model->data_query("SELECT user_phone FROM user_question_aws_mapping
WHERE user_phone =$userphone AND CURDATE( ) >= DATE( DATE_ADD( DATE, INTERVAL 29 DAY ) ) ");
            if(($check30days !=NULL)  && (($partialy_engaged =='') || ($partialy_engaged ==1))){
				$count=2;
                $brandresult	=	$this->model->update($table,array('partialy_engaged'=>$count,'updated_on'=>date('Y-m-d h:i:s')),
				"CUSTOMERID='".$custid."'");				
				if($email !=''){
				$brand_img="yapnaa-new-logo.png";	
				$text="<p style='font-weight:lighter;'>Dear $username,</p>"." 
<p style='text-align:left;font-weight:normal;'>Now you can manage and secure all your home appliances and connect with brands for any support in the easiest way!
</p>
 
<br><p style='text-align:center'>   
<a href='http://bit.ly/yapnaa-website'>
<input type='button' 
style='width:33%;font-weight:normal;background-color:#fc7f2b;border-radius:20px;color:#fff;font:inherit;line-height:3;font-size:14px;border:none' value='Know More'/></a></p>

<p style='text-align:center;font-family:arial,sans-serif;'>
<a href='http://bit.ly/YapnaaForAndroid'>
<img src='https://yapnaa.com/images/1-Yapnaa.gif' alt='Yapnaa' height='60%' width='60%'>
 </a>
</p> 
";
				$subject="One app to secure all your appliances";   
                $this->sendmail_phpmailer($text,$subject,$email,$brand_img);
				}else{
			    $text="Dear ".ucfirst($username).",\nNow you can manage and secure all your home appliances and connect with brands for any support in the easiest way!
http://bit.ly/YapnaaForAndroid";	
                $userphone=array($userphone);				
				$this->send_bulk_sms($userphone,$text);
				}
			}
			 
		}
       return true;
		
	}
	function schedule_campaign4($schedulecampaign){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		}  
		 $Disinterested1 = $this->model->data_query("SELECT *, 
(SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users 
FROM $table zc where (zc.disinterested in ('') or (zc.disinterested in(4) and CURDATE() >= DATE( DATE_ADD(updated_on, INTERVAL 7 DAY ) )))  and   
((zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No' )) 
or(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='Yes' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No' )) 
or(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='Yes' )
))
   ");
       $Disinterested2 = $this->model->data_query("SELECT *, 
(SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users 
FROM $table zc where zc.disinterested  in ('',1)  and CURDATE() >= DATE( DATE_ADD(updated_on, INTERVAL 7 DAY ) ) and  
((zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No' )) 
or(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='Yes' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No' )) 
or(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='Yes' )
))
   ");
       $Disinterested3 = $this->model->data_query("SELECT *, 
(SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users 
FROM $table zc where  zc.disinterested  in ('',2)  and CURDATE() >= DATE( DATE_ADD(updated_on, INTERVAL 7 DAY ) ) and
((zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No' )) 
or(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='Yes' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No' )) 
or(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='Yes' )
))
   ");
      $Disinterested4 = $this->model->data_query("SELECT *, 
(SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users 
FROM $table zc where   zc.disinterested  in ('',3)  and CURDATE() >= DATE( DATE_ADD(updated_on, INTERVAL 7 DAY ) ) and 
((zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No' )) 
or(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='Yes' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No' )) 
or(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No' ) 
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='Yes' )
))
   ");   if($Disinterested1 !=NULL){
		$Disinterested=$Disinterested1; 
		   
         }
		 else if($Disinterested2 !=NULL){
			 $Disinterested=$Disinterested2;
			
		 }
		  else if($Disinterested3 !=NULL){
			 $Disinterested=$Disinterested3;
			 
		 } 
		  else if($Disinterested4 !=NULL){
			 $Disinterested=$Disinterested4;
			  
		 }
		
		//echo '<pre>';print_r($Disinterested);die;//print_r($highlyengaged);print_r($Engaged);print_r($partiallyengaged);die;	
		foreach($Disinterested as $customer_info){
            $userphone= $customer_info['PHONE1'];
			$username= $customer_info['CUSTOMER_NAME'];
			$email= $customer_info['email'];
			$custid= $customer_info['CUSTOMERID'];
			$disinterested_count= $customer_info['disinterested']; 
			//check customer after 15 days			
			$check7days		=	$this->model->data_query("SELECT user_phone FROM user_question_aws_mapping
WHERE user_phone =$userphone AND CURDATE() >= DATE( DATE_ADD(date, INTERVAL 7 DAY ) ) ");
            $check14days		=	$this->model->data_query("SELECT user_phone FROM user_question_aws_mapping
WHERE user_phone =$userphone AND CURDATE() >= DATE( DATE_ADD( date, INTERVAL 14 DAY ) ) ");
            $check21days		=	$this->model->data_query("SELECT user_phone FROM user_question_aws_mapping
WHERE user_phone =$userphone AND CURDATE() >= DATE( DATE_ADD( date, INTERVAL 21 DAY ) ) ");
            $check30days		=	$this->model->data_query("SELECT user_phone FROM user_question_aws_mapping
WHERE user_phone =$userphone AND CURDATE() >= DATE( DATE_ADD( date, INTERVAL 29 DAY ) ) ");
            
           
				//echo "here";exit;
					if(($check30days !=NULL) && (($disinterested_count ==3) || ($disinterested_count ==''))){
					    $count=4;
						$brandresult	=	$this->model->update($table,array('disinterested'=>$count,'updated_on'=>date('Y-m-d h:i:s')),
				"CUSTOMERID='".$custid."'");
						$brand_img="yapnaa-new-logo.png";
						if($email !=''){
						$text="<p style='font-weight:lighter;'>Dear ".ucfirst($username).",</p> 
<p style='text-align:left;font-weight:normal;'>Get annual maintenance contract to ensure that your water filter works efficiently!</p>

<br><p style='text-align:center'>  
<a href='http://bit.ly/livpure_amc'>
<input type='button' 
style='width:33%;font-weight:normal;background-color:#442c8b;border-radius:20px;color:#fff;font:inherit;line-height:2;font-size:14px;border:none' value='Enquire to Know
'/></a></p><br>

<p style='text-align:center;font-family:arial,sans-serif;'>Why it is important to take AMC from Livpure for your RO Water Purifier? 
</p>
<p style='font-family:arial,sans-serif;font-weight:normal;text-align:left;'>

<ul>
<li style='font-weight:normal;line-height:3;'>Ensures uninterrupted supply of Pure & Safe Water</li>
<li style='font-weight:normal;line-height:3;'>Periodic Maintenance, Cleaning of Filters, Replacement of Consumables to avoid Break-down.</li>
<li style='font-weight:normal;line-height:3;'>1 year comprehensive warranty</li>
<li style='font-weight:normal;line-height:3;'>No Service Charges for any Break-Down Spare Parts</li>
<li style='font-weight:normal;line-height:3;'>Assurance of genuine Livpure Spare Parts</li>
<li style='font-weight:normal;line-height:3;'>Free Replacement of Electrical/Electronic Parts in case of Failure</li>
<li style='font-weight:normal;line-height:3;'>Service by Verified, Certified & Trained Company Engineers</li>
 </ul> 
</p>
<p style='text-align:center'> 
<a href='http://bit.ly/livpure_amc'>
<input type='button' 
style='width:50%;font-weight:normal;background-color:#fc7f2b;border-radius:20px;color:#fff;font:inherit;line-height:2.5;font-size:14px;border:none' value='Avail AMC Service Today'/></a></p>
";
				$subject="Secure your water purifier with AMC";
				
				$this->sendmail_phpmailer($text,$subject,$email,$brand_img);
				      }				
					else{
	                     $text="Dear ".ucfirst($username).",\nGet annual maintenance contract to ensure that your water filter works efficiently. Know why it is important http://bit.ly/livpure_amc
		";	
						 $userphone=array($userphone);				
						$this->send_bulk_sms($userphone,$text);
					}
					}
					if(($check21days !=NULL)&& (($disinterested_count ==2) || ($disinterested_count ==''))){
						$count=3;
						$brandresult	=	$this->model->update($table,array('disinterested'=>$count,'updated_on'=>date('Y-m-d h:i:s')),
				"CUSTOMERID='".$custid."'");
						$brand_img="yapnaa-new-logo.png";
							if($email !=''){
				$text="<p style='font-weight:lighter;'>Dear ".ucfirst($username).",</p> 
<p style='text-align:left;font-weight:normal;'>Don’t compromise on the water quality in your house. Get a free water testing by Livpure experts.
</p>
  
<br><p style='text-align:center'>   
<a href='http://bit.ly/livpure-watertest'>
<input type='button' 
style='width:33%;font-weight:normal;background-color:#fc7f2b;border-radius:20px;color:#fff;font:inherit;line-height:3;font-size:14px;border:none' value='Book a Free Demo'/></a></p>

<p style='text-align:center;font-family:arial,sans-serif;'>
<a href='http://bit.ly/YapnaaForAndroid'>
<img src='https://yapnaa.com/images/livpure_water.jpg' alt='Yapnaa' height='60%' width='60%'>
 </a>
</p> ";
				$subject="Get a free water testing from Livpure";
				
				$this->sendmail_phpmailer($text,$subject,$email,$brand_img);
				      }				
					else{
	                     $text="Dear ".ucfirst($username).",\nDon’t compromise on the water quality in your house. Get a free water testing by Livpure experts.
http://bit.ly/livpure-watertest";	
						 $userphone=array($userphone);				
						$this->send_bulk_sms($userphone,$text);
					}
				   }	
					if(($check14days !=NULL) && (($disinterested_count ==1) || ($disinterested_count ==''))){
						$count=2;
						$brandresult	=	$this->model->update($table,array('disinterested'=>$count,'updated_on'=>date('Y-m-d h:i:s')),
				"CUSTOMERID='".$custid."'");
						if($email !=''){
				$brand_img="yapnaa-new-logo.png";	 		
				$text="<p style='font-weight:lighter;'>Dear ".ucfirst($username).",</p> 
<p style='text-align:left;font-weight:normal;line-height:3'>Yapnaa is your after sales companion to manage your home appliances and connect with brands directly for any service support.http://bit.ly/yapnaa-website.</p>
  
<p style='text-align:center'>   
<a href='http://bit.ly/YapnaaForAndroid'>
<input type='button' 
style='width:33%;font-weight:normal;background-color:#fc7f2b;border-radius:20px;color:#fff;font:inherit;line-height:3;font-size:14px;border:none' value='Download app'/></a></p>

<p style='text-align:center;font-family:arial,sans-serif;'>
<a href='http://bit.ly/YapnaaForAndroid'>
<img src='https://yapnaa.com/images/yapnaa-after_scal.jpg' alt='Yapnaa' height='100%' width='100%'> 
 </a>
</p> ";
				$subject="After Sales companion for all your appliances";
				
				$this->sendmail_phpmailer($text,$subject,$email,$brand_img);
				      }				
					else{
	                     $text="Dear ".ucfirst($username).",\nYapnaa is your after sales companion to manage your home appliances and connect with brands directly for any service support.http://bit.ly/yapnaa-website.";	
						 $userphone=array($userphone);				
						$this->send_bulk_sms($userphone,$text);
					}
					}
					
					if(($check7days !=NULL) && (($disinterested_count ==4) || ($disinterested_count =='')) ){
						$count=1;
						$brandresult	=	$this->model->update($table,array('disinterested'=>$count,'updated_on'=>date('Y-m-d h:i:s')),
				"CUSTOMERID='".$custid."'");
				       if($email !=''){
				$brand_img="yapnaa-new-logo.png";		   
				$text="<p style='font-weight:lighter;'>Dear $username,</p>"." 
<p style='text-align:left;font-weight:normal;'>Now you can manage and secure all your home appliances and connect with brands for any support in the easiest way!
</p>
 
<br><p style='text-align:center'>   
<a href='http://bit.ly/yapnaa-website'>
<input type='button' 
style='width:33%;font-weight:normal;background-color:#fc7f2b;border-radius:20px;color:#fff;font:inherit;line-height:3;font-size:14px;border:none' value='Know More'/></a></p>

<p style='text-align:center;font-family:arial,sans-serif;'>
<a href='http://bit.ly/YapnaaForAndroid'>
<img src='https://yapnaa.com/images/1-Yapnaa.gif' alt='Yapnaa' height='60%' width='60%'>
 </a>
</p> 
";
				$subject="One app to secure all your appliances";
				
				$this->sendmail_phpmailer($text,$subject,$email,$brand_img);
				      }				
					else{
	                     $text="Dear ".ucfirst($username).",\nNow you can manage and secure all your home appliances and connect with brands for any support in the easiest way!
http://bit.ly/YapnaaForAndroid";	
						 $userphone=array($userphone);				
						$this->send_bulk_sms($userphone,$text);
					}
				}
		      
			}
		
       return true;
		
	}
	function schedule_campaign5($schedulecampaign){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
       	
		$result = $this->model->data_query("SELECT *  FROM $table br WHERE br.status in(7,8,9) "); 
		for($i=0;$i<count($result); $i++)
		{
			$userphone[]= $result[$i]['PHONE1'];
		
		}		
		$text="Looking for a home manager that can monitor your appliances, secure your documents, remind you on warranty and can raise service request for your products directly with brand? Then visit yapnaa.com to know more.";	
	
		$this->send_bulk_sms($userphone,$text);
		return true;
	}
	function schedule_campaign6($schedulecampaign){
		switch($schedulecampaign){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
       	
		$result = $this->model->data_query("SELECT *  FROM $table br WHERE br.status in(7,8,9) "); 
		for($i=0;$i<count($result); $i++)
		{
			$userphone[]= $result[$i]['PHONE1'];
		
		}		
		$text="Manage and secure your home appliances and connect directly with brands for any support and service http://bit.ly/YapnaaForAndroid";	
		$this->send_bulk_sms($userphone,$text);
		return true;
	} 
	function update_customer_type1($cust_type){
		switch($cust_type){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		
		$highlyengaged		=	$this->model->data_query("SELECT *, 
		(SELECT date FROM user_question_aws_mapping WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS date 
		FROM $table zc where zc.phone1 in
		(select user_phone from user_question_aws_mapping where qst_id=3  and answer='Yes')
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4  and answer='Yes')
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12  and answer='Yes') 
		and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  and answer='Yes')" 
			);
		//print_r($highlyengaged);exit;  
		foreach($highlyengaged as $cust_type1)
		{
			    $condition_highly="CUSTOMERID='".$cust_type1['CUSTOMERID']."'";
				$array_update_highly=array('last_called'=>$cust_type1['date'],'customet_type'=>1);
				$this->model->update($table,$array_update_highly,$condition_highly);
			
		}
	}
	function update_customer_type2($cust_type){
		switch($cust_type){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
		$engaged		=	$this->model->data_query("SELECT *,
			(SELECT date FROM user_question_aws_mapping WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS date FROM $table zc where 
			zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='Yes') 
			and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='Yes')
			and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='Yes') 
			and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2  
			and  answer='No')");
        foreach($engaged as $cust_type2)
		{
			    $condition_engaged="CUSTOMERID='".$cust_type2['CUSTOMERID']."'";			   
				$array_update_engaged=array('last_called'=>$cust_type2['date'],'customet_type'=>2);
				$this->model->update($table,$array_update_engaged,$condition_engaged);
			
		}
	}	
      function update_customer_type3($cust_type){
        switch($cust_type){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 		  
        $partiallyengaged = $this->model->data_query("SELECT *,
			(SELECT date FROM user_question_aws_mapping WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS date FROM $table zc WHERE zc.phone1 IN 
(SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =3 AND answer = 'Yes' )
AND zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =4 AND answer = 'Yes' )
and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer in('No') )
AND zc.phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =12 AND answer = 'No')");
       foreach($partiallyengaged as $cust_type3)
		{
			    $condition_partialy="CUSTOMERID='".$cust_type3['CUSTOMERID']."'";			  
				$array_update_partialy=array('last_called'=>$cust_type3['date'],'customet_type'=>3);
				$this->model->update($table,$array_update_partialy,$condition_partialy);
			
		}
	  }
	  function update_customer_type4($cust_type){
		  switch($cust_type){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
			$brand_img="logo_livpure_yapnaa.png";
			
			
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            $brand_img="logo_livpure_yapnaa.png";			
            break;			
		} 
      $Disinterested = $this->model->data_query("SELECT *, (SELECT date FROM user_question_aws_mapping WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS date
								FROM $table zc where 
					(
					(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No') 
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No') 
					and 
					zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No')
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No')
					) 
					or  
					(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='Yes') 
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No') 
					and 
					zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No')
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='No')
					) 
					or
					(zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=2 and answer='No') 
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=3 and answer='No') 
					and 
					zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=4 and answer='No')
					and zc.phone1 in (select user_phone from user_question_aws_mapping where qst_id=12 and answer='Yes')
					)
					)
   ");
       foreach($Disinterested as $cust_type4)
		{
			    $condition_disinterested="CUSTOMERID='".$cust_type4['CUSTOMERID']."'";			    
				$array_update_disinterested=array('last_called'=>$cust_type4['date'],'customet_type'=>4);
				$this->model->update($table,$array_update_disinterested,$condition_disinterested);
			
		}
	} 
	function user_question_select(){
		
		$table		=	'yapnaa_questions';	
		$fields		=	'*';
		$condition 	=	"1";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		$quest_arr	=	array();
	/* 	foreach($result as $ques){
			
			$qust_id=	$ques['id'];
			$result		=	$this->model->data_query("SELECT y.* FROM yapnaa_answers y LEFT JOIN yap_mapping m ON y.id = m.answer_id WHERE m.question_id =$qust_id");
			$ques["answers"]	=	$result;
			$quest_arr[]	=	$ques;
		} */
		
		//echo '<pre>'.print_r($result);die;
		return $result;
	}
	function followup_cron($followuptype){
		switch($followuptype){
			case 1:
		    $table		=	'livpure';
			$titlename1='Livpure';
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename1='Zero B';
            break;			
		}
		
		$fields		=	'*';
		$condition 	=	"STATUS =3 and followup_mail ='' AND DATE(req_follow_up_date) = DATE_ADD(CURDATE(),INTERVAL 1 
DAY)";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		
		foreach($result as  $key => $value ){
          $followupcustID []=$value['CUSTOMERID'];
		$datacustomer .="<tr style='height:25px'>
		<td style='border: 1px solid black;'>".date('d-m-Y h:i:s')."</td>
			 <td style='border: 1px solid black;'>".$value['CUSTOMERID']."</td>
			 <td style='border: 1px solid black;'>".$value['CUSTOMER_NAME']."</td>
			 <td style='border: 1px solid black;'>".$value['PHONE1']."</td>
			 <td style='border: 1px solid black;'>".date('d-m-Y h:i:s',strtotime($value['req_follow_up_date']))."</td></tr>";
			 
			
		}
		 
		$to = "sriramm@moviloglobal.com";
        //$to = "ranjan.jjbyte@gmail.com";
		$subject = "Follow Up Customers of $titlename1";
		$message = "
<html>
<head>
<title>Follow Up Customers</title>
</head>
<body>
<p>Hi,You have some follow up customers as below:-</p>
<table style='border: 1px solid black; border-collapse: collapse;'>
<tr style='height:25px'>
<th style='border: 1px solid black;width: 120px;'>Mail Date</th>
<th style='border: 1px solid black;width: 120px;'>Customer Id</th>
<th style='border: 1px solid black;width: 120px;'>Name</th>
<th style='border: 1px solid black;width: 120px;'>Phone Number</th>
<th style='border: 1px solid black;width: 120px;'>Enquiry Date</th>
</tr>
$datacustomer
</table>
</body>
</html>
";
		 
		 
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: info@yapnaa.com" . "\r\n" .
		"CC: harshal.jjbytes@gmail.com";
		
		 //$headers .= "From: info@yapnaa.com" . "\r\n";
        		
        
		if($followupcustID !=NULL){
		mail($to,$subject,$message,$headers); 
		}
		
		for($i=0;$i<count($followupcustID);$i++){
        $condition="CUSTOMERID='".$followupcustID[$i]."'"; 
        $set_array	=	array(                  
							'followup_mail'=>	1
							);
			
        $mailstatus	=	$this->model->update($table,$set_array,$condition);
		}
		return true;
	}
	function conversion_oppertunity($conversionopp){  
		switch($conversionopp){
			case 1:
		    $table		=	'livpure';
			$titlename2='Livpure';
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename2='Zero B';
            break;			
		}
		
		$fields		=	'*';
		$condition1 	=	"STATUS =3 and mail_status_service ='' AND DATE(req_service_date) >= CURDATE() ";
		$condition2 	=	"STATUS =3 and mail_status_amc ='' AND DATE(req_amc_date) >= CURDATE() ";	
		$condition3 	=	"STATUS =3 and mail_status_upgrade ='' AND DATE(req_upgrade_date)  >= CURDATE() ";				
		$condition4 	=	"mail_status_escalation ='' and phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =23 AND answer =  'Yes' AND DATE( DATE ) >= CURDATE( ))";				
		$result1	=	$this->model->get_Details_condition($table,$fields,$condition1);
		$result2	=	$this->model->get_Details_condition($table,$fields,$condition2);
		$result3	=	$this->model->get_Details_condition($table,$fields,$condition3);
		$result4	=	$this->model->get_Details_condition($table,$fields,$condition4);
		
		foreach($result1 as  $key1 => $value1 ){
             $serviceCustID[]=$value1['CUSTOMERID'];
			 $datacustomer1 .="<tr style='height:25px'>
			 <td style='border: 1px solid black;'>".date('d-m-Y h:i:s')."</td>
			 <td style='border: 1px solid black;'>".$value1['CUSTOMERID']."</td>
			 <td style='border: 1px solid black;'>".$value1['CUSTOMER_NAME']."</td>
			 <td style='border: 1px solid black;'>".$value1['PHONE1']."</td>
			 <td style='border: 1px solid black;'>".date('d-m-Y h:i:s',strtotime($value1['req_service_date']))."</td></tr>";
			
		}
		foreach($result2 as  $key2 => $value2 ){
			$amcCustID[]=$value2['CUSTOMERID'];
             $datacustomer2 .="<tr style='height:25px'>
			 <td style='border: 1px solid black;'>".date('d-m-Y h:i:s')."</td>
			 <td style='border: 1px solid black;'>".$value2['CUSTOMERID']."</td>
			 <td style='border: 1px solid black;'>".$value2['CUSTOMER_NAME']."</td>
			 <td style='border: 1px solid black;'>".$value2['PHONE1']."</td>
			  <td style='border: 1px solid black;'>".date('d-m-Y h:i:s',strtotime($value2['req_amc_date']))."</td></tr>";
			
		}
		foreach($result3 as  $key3 => $value3 ){
            $upgradeCustID[]=$value3['CUSTOMERID'];
       		$datacustomer3 .="<tr style='height:25px'>
			<td style='border: 1px solid black;'>".date('d-m-Y h:i:s')."</td>
			 <td style='border: 1px solid black;'>".$value3['CUSTOMERID']."</td>
			 <td style='border: 1px solid black;'>".$value3['CUSTOMER_NAME']."</td>
			 <td style='border: 1px solid black;'>".$value3['PHONE1']."</td>
			 <td style='border: 1px solid black;'>".date('d-m-Y h:i:s',strtotime($value3['req_upgrade_date']))."</td></tr>";
			
		}
		foreach($result4 as  $key4 => $value4 ){
            $escalCustID[]=$value4['CUSTOMERID'];
    		$datacustomer4 .="<tr style='height:25px'>
			<td style='border: 1px solid black;'>".date('d-m-Y h:i:s')."</td>
			 <td style='border: 1px solid black;'>".$value4['CUSTOMERID']."</td>
			 <td style='border: 1px solid black;'>".$value4['CUSTOMER_NAME']."</td>
			 <td style='border: 1px solid black;'>".$value4['PHONE1']."</td>
			 <td style='border: 1px solid black;'>".''."</td></tr>";
			
		}
		 
		$to = "sriramm@moviloglobal.com";  
		//$to = "ranjan.jjbyte@gmail.com"; 
		
		$subject = "Conversion Opportunity of $titlename2";
		$message = "
<html>
<head>
<title>Service Request Customers</title>
</head>
<body>
<h3>Service Request :-</h3>
<table style='border: 1px solid black; border-collapse: collapse;'>
<tr style='height:25px'>
<th style='border: 1px solid black;width: 120px;'>Mail Date</th>
<th style='border: 1px solid black;width: 120px;'>Customer Id</th>
<th style='border: 1px solid black;width: 120px;'>Name</th>
<th style='border: 1px solid black;width: 120px;'>Phone Number</th>
<th style='border: 1px solid black;width: 120px;'>Enquiry Date</th>
</tr>
$datacustomer1
</table>
</body>
</html>
";
$message .= "
<html>
<head>
<title>AMC Enquiry Customers</title>
</head>
<body>
<h3>AMC Enquiry :-</h3>
<table style='border: 1px solid black; border-collapse: collapse;'>
<tr style='height:25px'>
<th style='border: 1px solid black;width: 120px;'>Mail Date</th>
<th style='border: 1px solid black;width: 120px;'>Customer Id</th>
<th style='border: 1px solid black;width: 120px;'>Name</th>
<th style='border: 1px solid black;width: 120px;'>Phone Number</th>
<th style='border: 1px solid black;width: 120px;'>Enquiry Date</th>
</tr>
$datacustomer2
</table>
</body>
</html>
";
$message .= "
<html>
<head>
<title>Upgrade Enquiry  Customers</title>
</head>
<body>
<h3>Upgrade Enquiry :-</h3>
<table style='border: 1px solid black; border-collapse: collapse;'>
<tr style='height:25px'>
<th style='border: 1px solid black;width: 120px;'>Mail Date</th>
<th style='border: 1px solid black;width: 120px;'>Customer Id</th>
<th style='border: 1px solid black;width: 120px;'>Name</th>
<th style='border: 1px solid black;width: 120px;'>Phone Number</th>
<th style='border: 1px solid black;width: 120px;'>Enquiry Date</th>
</tr>
$datacustomer3
</table>
</body>
</html>
";
$message .= "
<html>
<head>
<title>Escalation  Customers</title>
</head>
<body>
<h3>Escalation :-</h3>
<table style='border: 1px solid black; border-collapse: collapse;'>
<tr style='height:25px'>
<th style='border: 1px solid black;width: 120px;'>Mail Date</th>
<th style='border: 1px solid black;width: 120px;'>Customer Id</th>
<th style='border: 1px solid black;width: 120px;'>Name</th>
<th style='border: 1px solid black;width: 120px;'>Phone Number</th>
<th style='border: 1px solid black;width: 120px;'>Enquiry Date</th>
</tr>
$datacustomer4
</table>
</body>
</html>
";
		
		 
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: info@yapnaa.com" . "\r\n";
        		
		if($serviceCustID !=NULL || $amcCustID !=NULL || $upgradeCustID !=NULL || $escalCustID !=NULL){
		mail($to,$subject,$message,$headers); 
		}
		
		
		for($i=0;$i<count($serviceCustID);$i++){
		
			$condition_sevice="CUSTOMERID='".$serviceCustID[$i]."'"; 
			$set_array	=	array(                  
								'mail_status_service'=>	2
								);
				
			$mailstatus	=	$this->model->update($table,$set_array,$condition_sevice);
			
		}
        for($i=0;$i<count($amcCustID);$i++){
			
        $condition_amc="CUSTOMERID='".$amcCustID[$i]."'"; 
        $set_array	=	array(                  
							'mail_status_amc'=>	3
							);
			
        $mailstatus	=	$this->model->update($table,$set_array,$condition_amc);
			
		}
        for($i=0;$i<count($upgradeCustID);$i++){
			
        $condition_upgrade="CUSTOMERID='".$upgradeCustID[$i]."'"; 
        $set_array	=	array(                  
							'mail_status_upgrade'=>	4
							);
			
        $mailstatus	=	$this->model->update($table,$set_array,$condition_upgrade);
			
		}		
        for($i=0;$i<count($escalCustID);$i++){
			
        $condition_escal="CUSTOMERID='".$escalCustID[$i]."'"; 
        $set_array	=	array(                  
							'mail_status_escalation'=>	5
							);
			
        $mailstatus	=	$this->model->update($table,$set_array,$condition_escal);
			
		}		
		return true;
	}
	
	function amcupgrade($amcupgrade){  
		switch($amcupgrade){
			case 1:
		    $table		=	'livpure';
			$titlename='Livpure';
            break;
			case 2:
		    $table		=	'zerob_consol1';
			$titlename='Zero B';
            break;			
		}
		
		$fields		=	'*';
		$condition1 	=	"note_for_amc ='' AND phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =18 AND answer =  'Yes' AND DATE( DATE ) <= CURDATE( ))";
		$condition2 	=	"note_for_upgrade ='' AND phone1 IN (SELECT user_phone FROM user_question_aws_mapping WHERE qst_id =20 AND answer =  'Yes' AND DATE( DATE ) <= CURDATE( )) ";	
					
		$result1	=	$this->model->get_Details_condition($table,$fields,$condition1);
		$result2	=	$this->model->get_Details_condition($table,$fields,$condition2);
		
		
		foreach($result1 as  $key1 => $value1 ){
            $noteAmcCustID[]=$value1['CUSTOMERID'];
    		$datacustomer1 .="<tr style='height:25px'><td style='border: 1px solid black;'>".date('d-m-Y h:i:s')."</td>
			 <td style='border: 1px solid black;'>".$value1['CUSTOMERID']."</td>
			 <td style='border: 1px solid black;'>".$value1['CUSTOMER_NAME']."</td>
			 <td style='border: 1px solid black;'>".$value1['PHONE1']."</td>
			 <td style='border: 1px solid black;'>".''."</td></tr>";
			
		}
		foreach($result2 as  $key2 => $value2 ){
			$noteUpgradeCustID[]=$value2['CUSTOMERID'];
			 $datacustomer2 .="<tr style='height:25px'><td style='border: 1px solid black;'>".date('d-m-Y h:i:s')."</td>
			 <td style='border: 1px solid black;'>".$value2['CUSTOMERID']."</td>
			 <td style='border: 1px solid black;'>".$value2['CUSTOMER_NAME']."</td>
			 <td style='border: 1px solid black;'>".$value2['PHONE1']."</td>
			 <td style='border: 1px solid black;'>".''."</td></tr>";
		}
		 
		
		$to = "sriramm@moviloglobal.com"; 
		//$to = "ranjan.jjbyte@gmail.com";
		$subject = "AMC and Upgrade Offers Customer of $titlename";
		$message = "
<html>
<head>
<title>Note for AMC Details</title>
</head>
<body>
<h3>Note for AMC Details Customers :-</h3>
<table style='border: 1px solid black; border-collapse: collapse;'>
<tr style='height:25px'>
<th style='border: 1px solid black;width: 120px;'>Mail Date</th>
<th style='border: 1px solid black;width: 120px;'>Customer Id</th>
<th style='border: 1px solid black;width: 120px;'>Name</th>
<th style='border: 1px solid black;width: 120px;'>Phone Number</th>
<th style='border: 1px solid black;width: 120px;'>Enquiry Date</th>
</tr>
$datacustomer1
</table>
</body>
</html>
";
$message .= "
<html>
<head>
<title>Note for Upgrade Offers</title>
</head>
<body>
<h3>Note for Upgrade Offers Customers :-</h3>
<table style='border: 1px solid black; border-collapse: collapse;'>
<tr style='height:25px'>
<th style='border: 1px solid black;width: 120px;'>Mail Date</th>
<th style='border: 1px solid black;width: 120px;'>Customer Id</th>
<th style='border: 1px solid black;width: 120px;'>Name</th>
<th style='border: 1px solid black;width: 120px;'>Phone Number</th>
<th style='border: 1px solid black;width: 120px;'>Enquiry Date</th>
</tr>
$datacustomer2
</table>
</body>
</html>
";

		
		 
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: info@yapnaa.com" . "\r\n" .
		"CC: harshal.jjbytes@gmail.com";
         		
        //$headers .= "From: info@yapnaa.com" . "\r\n";
		if($noteAmcCustID !=NULL || $noteUpgradeCustID !=NULL){ 
		mail($to,$subject,$message,$headers); 
		}
		
		
		for($i=0;$i<count($noteAmcCustID);$i++){
        $condition_amc_details="CUSTOMERID='".$noteAmcCustID[$i]."'";  
        $set_array	=	array(                  
							'note_for_amc'=>	6
							);
			
        $mailstatus	=	$this->model->update($table,$set_array,$condition_amc_details);
		}
		for($i=0;$i<count($noteUpgradeCustID);$i++){
        $condition_upgrade_details="CUSTOMERID='".$noteUpgradeCustID[$i]."'"; 
        $set_array	=	array(                  
							'note_for_upgrade'=>	7
							);
			
        $mailstatus	=	$this->model->update($table,$set_array,$condition_upgrade_details);
		}
		//echo '<pre>';print_r($result);die;
		
		return true;
	} 
	 
 function insertStatus($callbackCust,$userQst,$answer,$number,$brandId,$brandName,$customerid,$customername,$service_requested_date,$amc_requested_date,$follow_up_date,$wish_upgrade_date){  
	date_default_timezone_set('Asia/Kolkata');
	   $table		=	'user_question_aws_mapping';
	   $sql="SELECT * FROM $table y where y.user_phone=$number and y.qst_id=$userQst";
	  
	   $check_duplicate		=	$this->model->data_query($sql);
	   
	    $condition_brand="PHONE1=$number";
	  
	    if(!empty($service_requested_date)|| !empty($amc_requested_date) || !empty($wish_upgrade_date) || !empty($follow_up_date) ||  !empty($callbackCust)){
	 
			$set_array_brand	=	array(
		                    'status'                        =>3,
		                    'req_service_date'              =>$service_requested_date,
		                    'req_amc_date'                  =>$amc_requested_date,
		                    'req_upgrade_date'              =>$wish_upgrade_date,
		                    'req_follow_up_date'            =>$follow_up_date,
							'last_call_comment'            => $callbackCust,
							'highly_engaged'               =>'',
							'partialy_engaged'              =>'',
							'engaged'                       =>''
							);
							
		}else{
			$set_array_brand	=	array('status' => 0 );
		}	
 		
		switch( $brandId) {
			case 1:
			$brandtable='livpure';
			break;
			case 2:
			$brandtable='zerob_consol1';
			break;
			case 3:
			$brandtable='livpure_tn_kl';
			break;
			case 4:
			$brandtable='bluestar_b2b';
			break;
			case 5:
			$brandtable='bluestar_b2c';
			break;
		}
		   	
		$brandresult	=	$this->model->update($brandtable,$set_array_brand,$condition_brand);
			   
        if($check_duplicate !=NULL){
			if($userQst==2 || $userQst==3 || $userQst==4 || $userQst==12){
				if($answer=='Not sure' || $answer=='Sometimes'){
					$answer='No';
				}
			}
			$condition="user_phone=$number and qst_id=$userQst";			
			$condition_brand="PHONE1=$number";			
			$set_array	=	array(
		                   
							'answer'				        =>	$answer,							
							'date'                          =>date('Y-m-d h:i:s')
							);
			
			$result	=	$this->model->update($table,$set_array,$condition);			
		}	
		
		else{ 
		    if($userQst==2 || $userQst==3 || $userQst==4 || $userQst==12){
				if($answer=='Not sure' || $answer=='Sometimes'){
					$answer='No';
				}
			} 
			
			$arr_input	=	array(
			               
							'qst_id'				        =>	$userQst,							
							'user_phone'			        =>	$number,
							'answer'				        =>	$answer,
							'brand_name'				    =>	$brandName,
							'brand_id'                      =>  $brandId,
							'date'                          =>  date('Y-m-d h:i:s')
							);
			
			$result		=	$this->model->insert($table,$arr_input);
			
		}
		
		//external update for schedulcampain 
		$sql1="SELECT * FROM $table y where y.user_phone=$number and y.qst_id=2";	   
	    $check_forupdate1		=	$this->model->data_query($sql1);
		if($check_forupdate1 == NULL){
			$arr_input1	=	array(
			               
							'qst_id'				        =>	2,							
							'user_phone'			        =>	$number,
							'answer'				        =>	'No',
							'brand_name'				    =>	$brandName,
							'brand_id'                      =>  $brandId,
							'date'                          =>date('Y-m-d h:i:s')
							);
			
			$this->model->insert($table,$arr_input1);
		}
		
		$sql2					= "SELECT * FROM $table y where y.user_phone=$number and y.qst_id=3";
	    $check_forupdate2		= $this->model->data_query($sql2);		
		if($check_forupdate2 == NULL){
			$arr_input2	=	array(
			               
							'qst_id'				        =>	3,							
							'user_phone'			        =>	$number,
							'answer'				        =>	'No',
							'brand_name'				    =>	$brandName,
							'brand_id'                      =>  $brandId,
							'date'                          =>date('Y-m-d h:i:s')
							);
			
			$this->model->insert($table,$arr_input2);
		}
		
		$sql3="SELECT * FROM $table y where y.user_phone=$number and y.qst_id=4";
	    $check_forupdate3		=	$this->model->data_query($sql3);
		if($check_forupdate3 ==NULL){
			$arr_input3	=	array(
			               
							'qst_id'				        =>	4,							
							'user_phone'			        =>	$number,
							'answer'				        =>	'No',
							'brand_name'				    =>	$brandName,
							'brand_id'                      =>  $brandId,
							'date'                          =>date('Y-m-d h:i:s')
							);
			
			$this->model->insert($table,$arr_input3);
		}
		
		
		$sql4="SELECT * FROM $table y where y.user_phone=$number and y.qst_id=12";
	    $check_forupdate4		=	$this->model->data_query($sql4);
		if($check_forupdate4 ==NULL){
			$arr_input4	=	array(
			               
							'qst_id'				        =>	12,							
							'user_phone'			        =>	$number,
							'answer'				        =>	'No',
							'brand_name'				    =>	$brandName,
							'brand_id'                      =>  $brandId,
							'date'                          =>date('Y-m-d h:i:s')
							);
			
			$this->model->insert($table,$arr_input4);
		}
	
		return $result;
	
	}

	
	function insertStatus1
	($email,$comments,$userQst,$answer,$number,$brandId,$brandName,$customerid,$customername){  
	date_default_timezone_set('Asia/Kolkata');
	   $table		=	'user_question_aws_mapping';
	   if($brandId ==1){
	   $brandtable  =	'livpure';  
	   }
	   else{
	   $brandtable  =	''; 	     
	   }
	   $sql="SELECT * FROM $table y where y.user_phone=$number and y.qst_id=$userQst";	  
	   $check_duplicate		=	$this->model->data_query($sql);
	   
	   $brand_sql="SELECT * FROM $brandtable l where l.PHONE1=$number";	  
	   $check_duplicate_brand		=	$this->model->data_query($brand_sql);
	   if($check_duplicate_brand !=NULL)
	   {
	   $condition_brand="PHONE1=$number";
			   if(!empty($email)){
			   $set_array_brand	=	array(
									 'last_call_comment'            => $comments,
									 'email'                        =>$email,
									 'highly_engaged'               =>'',
									 'partialy_engaged'             =>'',
									 'engaged'                      =>'',
									 'disinterested'                =>''
									);
			   }else{
				   $set_array_brand	=	array(
									 'last_call_comment'            => $comments,							 
									 'highly_engaged'               =>'',
									 'partialy_engaged'             =>'',
									 'engaged'                      =>'',
									 'disinterested'                =>''
									); 
			   }
	   $brandresult	=	$this->model->update($brandtable,$set_array_brand,$condition_brand);
	   }else{
	   $datacustomer ="<tr style='height:25px'>
	         <td style='border: 1px solid black;'>".$customername."</td>
			 <td style='border: 1px solid black;'>".$number."</td>
			 <td style='border: 1px solid black;'>".$email."</td>
			 <td style='border: 1px solid black;'>".$comments."</td>			 
			 </tr>";
		$to = "info@yapnaa.com";        
		$subject = "Customers of $brandtable";
		$message = "
<html>
<head>
<title>Customers of $brandtable</title>
</head>
<body>
<p>Hi,You have a customers of $brandtable:-</p>
<table style='border: 1px solid black; border-collapse: collapse;'>
<tr style='height:25px'>
<th style='border: 1px solid black;width: 120px;'>Name</th>
<th style='border: 1px solid black;width: 120px;'>Phone</th>
<th style='border: 1px solid black;width: 120px;'>Email</th>
<th style='border: 1px solid black;width: 120px;'>Comments</th>
</tr>
$datacustomer
</table>
</body>
</html>
";
		 
		 
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: harshal.jjbytes@gmail.com" . "\r\n" ;		
		mail($to,$subject,$message,$headers);	
       	
	   }		   
	   
          if($check_duplicate !=NULL)
		{
			
           $condition="user_phone=$number and qst_id=$userQst";			
		   $set_array	=	array(
							'answer'				        =>	$answer,							
							'date'                          =>date('Y-m-d h:i:s')
							);
			$result	=	$this->model->update($table,$set_array,$condition);
			
				
				if($result){
					return $result;
				}
					
		}
		else{  
			
			$arr_input	=	array(
							'qst_id'				        =>	$userQst,							
							'user_phone'			        =>	$number,
							'answer'				        =>	$answer,
							'brand_name'				    =>	$brandName,
							'brand_id'                      =>  $brandId,
							'date'                          =>date('Y-m-d h:i:s')
							);
			$result		=	$this->model->insert($table,$arr_input);
			 
				if($result){
					
					return true;
				} 
			
		}
			
	
	}
	function user_answer_select(){
		/* $user_answer= array();
		$table		=	'yapnaa_questions';	
		$fields		=	'*';
		$condition 	=	"1";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition); */
		//foreach($result as $ques){
		//$qust_id=	$ques['id'];
		//$result		=	$this->model->data_query("SELECT y.* FROM yapnaa_answers y LEFT JOIN yap_mapping m ON y.id = m.answer_id WHERE m.question_id =$qust_id");
		$result		=	$this->model->data_query("SELECT * FROM yapnaa_answers WHERE 1");
        // array_push($user_answer,$result);
		//}
		//echo '<pre>';print_r($user_answer);die;
		return $result; 
	}
	function add_user(){
		date_default_timezone_set('Asia/Kolkata');
		$user_name						=	$_POST['user_name'];
		$user_email				        =	$_POST['user_email'];
		$user_pin					    =	rand(100, 9999);;
		$user_mobile					=	$_POST['user_mobile'];
		$user_created_date		        =	date("l jS \of F Y h:i:s A");
		$table							=	'users';		
		$fields		=	'*';
		$condition 	=	"user_phone='".$user_mobile."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		// echo'<pre>';print_r($result);exit;
		if(empty($result)){
			$arr_input	=	array(
							'user_name'				        =>	$user_name,
							'user_email_id'					=>	$user_email,
							'user_created_date'			    =>	$user_created_date,
							'user_phone'				    =>	$user_mobile,
							'user_pin'				        =>	md5($user_pin),
							'user_login_type'               =>0,
							'user_address'                  =>'',
							'user_city'                     =>'',
							'user_area_pincode'             =>0,
							'user_gcm_id'                   =>'',
							'user_last_login'               =>'',
							'user_reg_verification_otp'     =>0,
							'user_forgot_otp'               =>0,
							'user_token'					=>rand(1000,9999999),
							'user_status'                   =>1
							);
			$result		=	$this->model->insert($table,$arr_input);
			$message    =   "<p>Dear Customer,</p><p>Please download the Yapnaa App and login with the following credentials.</p><p>Username: ".$user_mobile."</p><p>Password: ".$user_pin.".</p><p>Link:-\n\n <a href='https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en'>Yapnaa</a></p>";
			$sm_message    =   "Dear Customer,\n\nPlease download the Yapnaa App and login with the following credentials.\n\nUsername: ".$user_mobile."\nPassword: ".$user_pin.".\n\nLink:-\nhttps://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en";
			$subject    =   "Welcome to Yapnaa";
			$to         =   $user_email;
			$this->send_email($message,$subject,$to);
			$this->send_sms_to_new_user($user_mobile,$sm_message);
			return $result;
			
		
		}else{
			return $result='';
		}
	}
	function send_yapnaa_capability(){
		$table		=	'users';
		$fields		=	'*';
		$condition 	=	"CURDATE()=date(user_created_date)+3";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		$message    =   "<p>Dear Customer,</p><p>Now maintaining your home appliances is easy.</p><p>Read More</p><p>Link:-\n\n <a href='https://yapnaa.com/yapnaa_capability.php'>Yapnaa</a></p>";
			$sm_message    =   "Dear Customer,\n\nNow maintaining your home appliances is easy.\n\nRead More\n\nLink:-\nhttps://yapnaa.com/yapnaa_capability.php";
			$subject    =   "Yapnaa Capabilites";
		foreach($result as $row){
			$user_mobile         =   $row['user_phone'];
			$to                  =   $row['user_email_id'];
			$this->send_email($message,$subject,$to);
			$this->send_sms_to_new_user($user_mobile,$sm_message);
			}
	}
	function AMCExpiry_7_Days(){
		$sql =	"SELECT * FROM  `zerob_consol1` WHERE DATE(  `CONTRACT_TO` ) = DATE_ADD( CURDATE( ) , INTERVAL 7 DAY ) ";
		$result		=	$this->model->data_query($sql);	
				
		foreach($result as $row){
			$d 				= 	new DateTime($row['CONTRACT_TO']);
			$expiry_date	=	$d->format('d-M-Y');
			$name 			=	!empty($row['CUSTOMER_NAME'])?$row['CUSTOMER_NAME']:"User";
			//print_r($row);echo "exp<br>".$expiry_date;die;
			$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		   <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			  <!--[if !mso]><!-->
			  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
			  <!--<![endif]-->
			  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
			  
				 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
			  <!--[if (gte mso 9)|(IE)]>
			  <style type="text/css">
				 table {border-collapse: collapse !important;}
			  </style>
			  <![endif]-->
		   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
		   

		   
		   
		   
		   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
			  <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
				 <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
					<tr>
					   <td width="100%">
						  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
							 <!--[if (gte mso 9)|(IE)]>
							 <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
								<tr>
								   <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
									  <![endif]--> 
									  <!-- ======= start main body ======= -->
									  <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
										 <tr>
											<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
											   <!-- ======= start header ======= -->
											   <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
												  <tr>
													 <td>
														<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
														   <tbody>
															  <tr>
																 <td align="center">
																	<center>
																	   <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
																		  <tbody>
																			 <tr>
																				<td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
																				   <!-- ======= start header ======= -->
																				   <table cellpadding="0" cellspacing="0" border="0" width="100%">
																					  <tr>
																						 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
																							<!--[if (gte mso 9)|(IE)]>
																							<table width="100%" style="border-spacing:0" >
																							   <tr>
																								  <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
																										<table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
																										   <tr>
																											  <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="https://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
																										   </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																								  <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
																										<table width="100%" style="border-spacing:0" bgcolor="#ffffff">
																										   <tr>
																											  <td>
																												 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
																													<tr>
																													   <td height="20">&nbsp;</td>
																													</tr>
																												 </table>
																											  </td>
																										   </tr>
																										  <tr>
									<td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
										<tbody><tr>
										  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
											  <tbody><tr>
												<td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="https://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="https://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											 <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											  </tr>
											</tbody></table></td>
										</tr>
									  </tbody></table></td>
								  </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																							   </tr>
																							</table>
																							<![endif]-->
																						 </td>
																					  </tr>
																					  <tr >
																						 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
																							<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
																							   <tr>
																								  <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																							   </tr>
																							</table>
																						 </td>
																					  </tr>
																					  <tr>
																					  </tr>
																				   </table>
																				</td>
																			 </tr>
																		  </tbody>
																	   </table>
																	</center>
																 </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end header ======= --> 
											   <!-- ======= start hero article ======= -->
											   <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="" style="padding-bottom:2%; padding-top:2%;">
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>Dear '.$name.',</b></p>														
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Warm welcome from Yapnaa team.</p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">AMC on your Zero B water filter expires on '.$expiry_date.', kindly contact Yapnaa to renew your contract and continue to enjoy and avail the service benefits under AMC.</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sincerely,</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sriram M.</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Support.Yapnna</p>
														<!-- START BUTTON -->
														<!-- END BUTTON -->
													 </td>
												  </tr>
											   </table>
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center">&nbsp;</td>
												  </tr>
											   </table>
											   <!-- ======= end hero article ======= --> 
											   <center >
												  <table bgcolor="#FFFFFF" width="100%">
													 <tr>
														<td>
														   <table>
															  <tr>
																 <td> &nbsp; &nbsp; <img src="https://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; www.yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="https://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; help@yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="https://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; +91 98452 856419</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
													 </tr>
												  </table>
											   </center>
											   <!-- ======= start divider ======= -->
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;"> &nbsp; </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center"> &nbsp; </td>
												  </tr>
											   </table>
											   <!-- ======= end divider ======= --> 

											</td>
										 </tr>
									  </table>
									  <!--[if (gte mso 9)|(IE)]>
								   </td>
								</tr>
							 </table>
							 <![endif]--> 
							 
							 
																	<!-- ======= start footer ======= -->
											   <table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
														   <tr>
															  <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"> &nbsp; </td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Networks Pvt. Ltd.</b></font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After Sales Companion</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														  
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end footer ======= -->
						  </div>
					   </td>
					</tr>
				 </table>
			  </center>
		   </body>
		</html>

					';
					
				$headers 				= 'MIME-Version: 1.0'. "\r\n";
				$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
				$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
				$headers 			.= 'bcc: sriramm@moviloglobal.com'. "\r\n";
				$subject	=	"AMC Expiry for your ZeroB Water Filter";
				// Mail it
				mail($row['email'], $subject, $message,$headers);
			$sms_message	=	'AMC for your ZeroB Water Filter expires on '.$expiry_date.', Dowload Yapnaa App from http://bit.ly/YapnaaForAndroid and renew your AMC';
			$user_numbers	=	array();
			if(isset($row['PHONE1']) && !empty($row['PHONE1'])){
				$user_numbers[]	=	$row['PHONE1'];
			}
			if(isset($row['PHONE2']) && !empty($row['PHONE2'])){
				$user_numbers[]	=	$row['PHONE2'];
			}
			$this->send_bulk_sms($user_numbers,$sms_message);
				
		}
	}
	
	function AMC_Due_Remainder_Last(){
		$sql =	"SELECT * FROM  `zerob_consol1` WHERE DATE(  `CONTRACT_TO` ) = DATE_ADD( CURDATE( ) , INTERVAL 3 MONTH  ) ";
		$result		=	$this->model->data_query($sql);	
				
		foreach($result as $row){
			$d 				= 	new DateTime($row['CONTRACT_TO']);
			$expiry_date	=	$d->format('d-M-Y');
			$name 			=	!empty($row['CUSTOMER_NAME'])?$row['CUSTOMER_NAME']:"User";
			//print_r($row);echo "exp<br>".$expiry_date;die;
			$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		   <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			  <!--[if !mso]><!-->
			  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
			  <!--<![endif]-->
			  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
			  
				 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
			  <!--[if (gte mso 9)|(IE)]>
			  <style type="text/css">
				 table {border-collapse: collapse !important;}
			  </style>
			  <![endif]-->
		   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
		   

		   
		   
		   
		   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
			  <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
				 <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
					<tr>
					   <td width="100%">
						  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
							 <!--[if (gte mso 9)|(IE)]>
							 <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
								<tr>
								   <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
									  <![endif]--> 
									  <!-- ======= start main body ======= -->
									  <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
										 <tr>
											<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
											   <!-- ======= start header ======= -->
											   <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
												  <tr>
													 <td>
														<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
														   <tbody>
															  <tr>
																 <td align="center">
																	<center>
																	   <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
																		  <tbody>
																			 <tr>
																				<td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
																				   <!-- ======= start header ======= -->
																				   <table cellpadding="0" cellspacing="0" border="0" width="100%">
																					  <tr>
																						 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
																							<!--[if (gte mso 9)|(IE)]>
																							<table width="100%" style="border-spacing:0" >
																							   <tr>
																								  <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
																										<table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
																										   <tr>
																											  <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="https://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
																										   </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																								  <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
																										<table width="100%" style="border-spacing:0" bgcolor="#ffffff">
																										   <tr>
																											  <td>
																												 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
																													<tr>
																													   <td height="20">&nbsp;</td>
																													</tr>
																												 </table>
																											  </td>
																										   </tr>
																										  <tr>
									<td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
										<tbody><tr>
										  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
											  <tbody><tr>
												<td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="https://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="https://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											 <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											  </tr>
											</tbody></table></td>
										</tr>
									  </tbody></table></td>
								  </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																							   </tr>
																							</table>
																							<![endif]-->
																						 </td>
																					  </tr>
																					  <tr >
																						 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
																							<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
																							   <tr>
																								  <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																							   </tr>
																							</table>
																						 </td>
																					  </tr>
																					  <tr>
																					  </tr>
																				   </table>
																				</td>
																			 </tr>
																		  </tbody>
																	   </table>
																	</center>
																 </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end header ======= --> 
											   <!-- ======= start hero article ======= -->
											   <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="" style="padding-bottom:2%; padding-top:2%;">
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>Dear '.$name.',</b></p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Warm welcome from yapnna team.</p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">AMC for your ZeroB Water Filter expires on '.$expiry_date.', Please contact yapnaa to renew your AMC and continue to enjoy service benefits.</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">
														</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sincerely,</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sriram M.</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Support.Yapnna</p>
														<!-- START BUTTON -->
														<!-- END BUTTON -->
													 </td>
												  </tr>
											   </table>
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center">&nbsp;</td>
												  </tr>
											   </table>
											   <!-- ======= end hero article ======= --> 
											   <center >
												  <table bgcolor="#FFFFFF" width="100%">
													 <tr>
														<td>
														   <table>
															  <tr>
																 <td> &nbsp; &nbsp; <img src="https://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; www.yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="https://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; help@yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="https://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; +91 98452 856419</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
													 </tr>
												  </table>
											   </center>
											   <!-- ======= start divider ======= -->
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;"> &nbsp; </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center"> &nbsp; </td>
												  </tr>
											   </table>
											   <!-- ======= end divider ======= --> 

											</td>
										 </tr>
									  </table>
									  <!--[if (gte mso 9)|(IE)]>
								   </td>
								</tr>
							 </table>
							 <![endif]--> 
							 
							 
																	<!-- ======= start footer ======= -->
											   <table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
														   <tr>
															  <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"> &nbsp; </td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Networks Pvt. Ltd.</b></font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After Sales Companion</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														  
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end footer ======= -->
						  </div>
					   </td>
					</tr>
				 </table>
			  </center>
		   </body>
		</html>

					';
					
				$headers 				= 'MIME-Version: 1.0'. "\r\n";
				$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
				$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
				$headers 			.= 'bcc: sriramm@moviloglobal.com'. "\r\n";
				$subject	=	"AMC Expiry for your ZeroB Water Filter";
				// Mail it
				mail($row['email'], $subject, $message,$headers);
			$sms_message	=	'AMC for your ZeroB Water Filter expires on '.$expiry_date.', Dowload Yapnaa App from http://bit.ly/YapnaaForAndroid and renew your AMC';
			$user_numbers	=	array();
			if(isset($row['PHONE1']) && !empty($row['PHONE1'])){
				$user_numbers[]	=	$row['PHONE1'];
			}
			if(isset($row['PHONE2']) && !empty($row['PHONE2'])){
				$user_numbers[]	=	$row['PHONE2'];
			}
			$this->send_bulk_sms($user_numbers,$sms_message);
				
		}
	}
	function AMC_Due_Remainder_Second(){
		$sql =	"SELECT * FROM  `zerob_consol1` WHERE DATE(  `CONTRACT_TO` ) = DATE_ADD( CURDATE( ) , INTERVAL 6 MONTH  ) ";
		$result		=	$this->model->data_query($sql);	
				
		foreach($result as $row){
			$d 				= 	new DateTime($row['CONTRACT_TO']);
			$expiry_date	=	$d->format('d-M-Y');
			$name 			=	!empty($row['CUSTOMER_NAME'])?$row['CUSTOMER_NAME']:"User";
			//print_r($row);echo "exp<br>".$expiry_date;die;
			$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		   <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			  <!--[if !mso]><!-->
			  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
			  <!--<![endif]-->
			  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
			  
				 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
			  <!--[if (gte mso 9)|(IE)]>
			  <style type="text/css">
				 table {border-collapse: collapse !important;}
			  </style>
			  <![endif]-->
		   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
		   

		   
		   
		   
		   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
			  <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
				 <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
					<tr>
					   <td width="100%">
						  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
							 <!--[if (gte mso 9)|(IE)]>
							 <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
								<tr>
								   <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
									  <![endif]--> 
									  <!-- ======= start main body ======= -->
									  <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
										 <tr>
											<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
											   <!-- ======= start header ======= -->
											   <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
												  <tr>
													 <td>
														<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
														   <tbody>
															  <tr>
																 <td align="center">
																	<center>
																	   <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
																		  <tbody>
																			 <tr>
																				<td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
																				   <!-- ======= start header ======= -->
																				   <table cellpadding="0" cellspacing="0" border="0" width="100%">
																					  <tr>
																						 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
																							<!--[if (gte mso 9)|(IE)]>
																							<table width="100%" style="border-spacing:0" >
																							   <tr>
																								  <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
																										<table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
																										   <tr>
																											  <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="https://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
																										   </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																								  <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
																										<table width="100%" style="border-spacing:0" bgcolor="#ffffff">
																										   <tr>
																											  <td>
																												 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
																													<tr>
																													   <td height="20">&nbsp;</td>
																													</tr>
																												 </table>
																											  </td>
																										   </tr>
																										  <tr>
									<td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
										<tbody><tr>
										  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
											  <tbody><tr>
												<td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="https://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="https://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											 <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											  </tr>
											</tbody></table></td>
										</tr>
									  </tbody></table></td>
								  </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																							   </tr>
																							</table>
																							<![endif]-->
																						 </td>
																					  </tr>
																					  <tr >
																						 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
																							<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
																							   <tr>
																								  <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																							   </tr>
																							</table>
																						 </td>
																					  </tr>
																					  <tr>
																					  </tr>
																				   </table>
																				</td>
																			 </tr>
																		  </tbody>
																	   </table>
																	</center>
																 </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end header ======= --> 
											   <!-- ======= start hero article ======= -->
											   <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="" style="padding-bottom:2%; padding-top:2%;">
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>Dear '.$name.',</b></p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Warm welcome from yapnna team.</p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">AMC for your ZeroB Water Filter expires on '.$expiry_date.', Please contact yapnaa to renew your AMC and continue to enjoy service benefits.</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">
														</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sincerely,</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sriram M.</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Support.Yapnna</p>
														<!-- START BUTTON -->
														<!-- END BUTTON -->
													 </td>
												  </tr>
											   </table>
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center">&nbsp;</td>
												  </tr>
											   </table>
											   <!-- ======= end hero article ======= --> 
											   <center >
												  <table bgcolor="#FFFFFF" width="100%">
													 <tr>
														<td>
														   <table>
															  <tr>
																 <td> &nbsp; &nbsp; <img src="https://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; www.yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="https://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; help@yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="https://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; +91 98452 856419</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
													 </tr>
												  </table>
											   </center>
											   <!-- ======= start divider ======= -->
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;"> &nbsp; </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center"> &nbsp; </td>
												  </tr>
											   </table>
											   <!-- ======= end divider ======= --> 

											</td>
										 </tr>
									  </table>
									  <!--[if (gte mso 9)|(IE)]>
								   </td>
								</tr>
							 </table>
							 <![endif]--> 
							 
							 
																	<!-- ======= start footer ======= -->
											   <table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
														   <tr>
															  <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"> &nbsp; </td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Networks Pvt. Ltd.</b></font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After Sales Companion</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														  
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end footer ======= -->
						  </div>
					   </td>
					</tr>
				 </table>
			  </center>
		   </body>
		</html>

					';
					
				$headers 				= 'MIME-Version: 1.0'. "\r\n";
				$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
				$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
				$headers 			.= 'bcc: sriramm@moviloglobal.com'. "\r\n";
				$subject	=	"AMC Expiry for your ZeroB Water Filter";
				// Mail it
				mail($row['email'], $subject, $message,$headers);
			$sms_message	=	'AMC for your ZeroB Water Filter expires on '.$expiry_date.', Dowload Yapnaa App from http://bit.ly/YapnaaForAndroid and renew your AMC';
			$user_numbers	=	array();
			if(isset($row['PHONE1']) && !empty($row['PHONE1'])){
				$user_numbers[]	=	$row['PHONE1'];
			}
			if(isset($row['PHONE2']) && !empty($row['PHONE2'])){
				$user_numbers[]	=	$row['PHONE2'];
			}
			$this->send_bulk_sms($user_numbers,$sms_message);
				
		}
	}
	function AMC_Due_Remainder_First(){
		$sql =	"SELECT * FROM  `zerob_consol1` WHERE DATE(  `CONTRACT_TO` ) = DATE_ADD( CURDATE( ) , INTERVAL 9 MONTH  ) ";
		$result		=	$this->model->data_query($sql);	
				
		foreach($result as $row){
			$d 				= 	new DateTime($row['CONTRACT_TO']);
			$expiry_date	=	$d->format('d-M-Y');
			$name 			=	!empty($row['CUSTOMER_NAME'])?$row['CUSTOMER_NAME']:"User";
			//print_r($row);echo "exp<br>".$expiry_date;die;
			$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		   <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			  <!--[if !mso]><!-->
			  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
			  <!--<![endif]-->
			  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
			  
				 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
			  <!--[if (gte mso 9)|(IE)]>
			  <style type="text/css">
				 table {border-collapse: collapse !important;}
			  </style>
			  <![endif]-->
		   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
		   

		   
		   
		   
		   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
			  <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
				 <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
					<tr>
					   <td width="100%">
						  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
							 <!--[if (gte mso 9)|(IE)]>
							 <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
								<tr>
								   <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
									  <![endif]--> 
									  <!-- ======= start main body ======= -->
									  <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
										 <tr>
											<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
											   <!-- ======= start header ======= -->
											   <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
												  <tr>
													 <td>
														<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
														   <tbody>
															  <tr>
																 <td align="center">
																	<center>
																	   <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
																		  <tbody>
																			 <tr>
																				<td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
																				   <!-- ======= start header ======= -->
																				   <table cellpadding="0" cellspacing="0" border="0" width="100%">
																					  <tr>
																						 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
																							<!--[if (gte mso 9)|(IE)]>
																							<table width="100%" style="border-spacing:0" >
																							   <tr>
																								  <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
																										<table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
																										   <tr>
																											  <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="https://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
																										   </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																								  <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
																										<table width="100%" style="border-spacing:0" bgcolor="#ffffff">
																										   <tr>
																											  <td>
																												 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
																													<tr>
																													   <td height="20">&nbsp;</td>
																													</tr>
																												 </table>
																											  </td>
																										   </tr>
																										  <tr>
									<td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
										<tbody><tr>
										  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
											  <tbody><tr>
												<td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="https://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="https://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											 <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											  </tr>
											</tbody></table></td>
										</tr>
									  </tbody></table></td>
								  </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																							   </tr>
																							</table>
																							<![endif]-->
																						 </td>
																					  </tr>
																					  <tr >
																						 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
																							<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
																							   <tr>
																								  <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																							   </tr>
																							</table>
																						 </td>
																					  </tr>
																					  <tr>
																					  </tr>
																				   </table>
																				</td>
																			 </tr>
																		  </tbody>
																	   </table>
																	</center>
																 </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end header ======= --> 
											   <!-- ======= start hero article ======= -->
											   <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="" style="padding-bottom:2%; padding-top:2%;">
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>Dear '.$name.',</b></p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Warm welcome from yapnna team.</p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">AMC for your ZeroB Water Filter expires on '.$expiry_date.', Please contact yapnaa to renew your AMC and continue to enjoy service benefits.</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">
														</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sincerely,</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sriram M.</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Support.Yapnna</p>
														<!-- START BUTTON -->
														<!-- END BUTTON -->
													 </td>
												  </tr>
											   </table>
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center">&nbsp;</td>
												  </tr>
											   </table>
											   <!-- ======= end hero article ======= --> 
											   <center >
												  <table bgcolor="#FFFFFF" width="100%">
													 <tr>
														<td>
														   <table>
															  <tr>
																 <td> &nbsp; &nbsp; <img src="https://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; www.yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="https://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; help@yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="https://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; +91 98452 856419</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
													 </tr>
												  </table>
											   </center>
											   <!-- ======= start divider ======= -->
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;"> &nbsp; </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center"> &nbsp; </td>
												  </tr>
											   </table>
											   <!-- ======= end divider ======= --> 

											</td>
										 </tr>
									  </table>
									  <!--[if (gte mso 9)|(IE)]>
								   </td>
								</tr>
							 </table>
							 <![endif]--> 
							 
							 
																	<!-- ======= start footer ======= -->
											   <table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
														   <tr>
															  <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"> &nbsp; </td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Networks Pvt. Ltd.</b></font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After Sales Companion</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														  
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end footer ======= -->
						  </div>
					   </td>
					</tr>
				 </table>
			  </center>
		   </body>
		</html>

					';
					
				$headers 				= 'MIME-Version: 1.0'. "\r\n";
				$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
				$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
				$headers 			.= 'bcc: sriramm@moviloglobal.com'. "\r\n";
				$subject	=	"AMC Expiry for your ZeroB Water Filter";
				// Mail it
				mail($row['email'], $subject, $message,$headers);
			$sms_message	=	'AMC for your ZeroB Water Filter expires on '.$expiry_date.', Dowload Yapnaa App from http://bit.ly/YapnaaForAndroid and renew your AMC';
			$user_numbers	=	array();
			if(isset($row['PHONE1']) && !empty($row['PHONE1'])){
				$user_numbers[]	=	$row['PHONE1'];
			}
			if(isset($row['PHONE2']) && !empty($row['PHONE2'])){
				$user_numbers[]	=	$row['PHONE2'];
			}
			$this->send_bulk_sms($user_numbers,$sms_message);
				
		}
	}
	function admin_login_val($admin_email_id,$admin_password)
	{
		
		$result	=	$this->model->admin_login_val($admin_email_id,$admin_password);
		return $result;
	}
	
	// Admin Password Update
	function admin_password_update($email_id,$password)
	{
		$table		=	'admin_login';
		$set_array	=	array(
						'admin_password'=> $password
						);
		$condition 	=	"admin_email_id='".$email_id."'";				
		$result	=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	/*Last Login Time date update*/
	function admin_logout($admin_email_id)
	{
		$table		=	'admin_login';
		date_default_timezone_set('Asia/Kolkata');
		$date	=	date("F Y h:i:s A");
		$set_array	=	array(
						'admin_last_login'=> $date
						);
		$condition 	=	"admin_email_id='".$admin_email_id."'";				
		$result	=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
		
	
	
	/*Add the faq*/
	function add_faq()
	{
		date_default_timezone_set('Asia/Kolkata');
		$brdnadid				=	$_POST['brdnadid'];
		$bp_id					=	$_POST['bp_id'];
		$faq					=	$_POST['faq'];
		$opt1					=	$_POST['opt1'];
		$opt2					=	$_POST['opt2'];
		$opt3					=	$_POST['opt2'];
		$opt4					=	$_POST['opt4'];
		$type					=	$_POST['type'];
		$j						=	1;
		for($i=0; $i<count($faq);$i++){
			$srm_question_c_date		=	date("Y-m-d H:i:s");
			$table						=	'srm_questions';

			$arr_input	=	array(
							'srm_question_bp_id'			=>	$bp_id,
							'srm_questions'					=>	$faq[$i],
							'srm_question_opt1'				=>	$opt1[$i],
							'srm_question_opt2'				=>  $opt2[$i],
							'srm_question_opt3'				=>	$opt3[$i],
							'srm_question_opt4'				=>	$opt4[$i],
							'srm_question_type'				=>	$type[$i],
							'srm_question_c_date'			=>	$srm_question_c_date,
							'srm_questions_nos'				=>	$j,
							);
			$result		=	$this->model->insert($table,$arr_input);
			$j++;
		}
		
			return $result;
	}
	
	
	
	
	//Get Faq Information by id
	function get_faq_list()
	{
		$table		=	'srm_questions';	
		$result		=	$this->model->get_faq_list($table);
		return $result;
	}
	
	
	
	//Get Faq deatils Information by id
	function get_faq_list_details($id)
	{
		$table		=	'srm_questions';	
		$condition	=	"srm_question_bp_id	=	$id";
		$result		=	$this->model->get_faq_list_details($table,$condition);
		return $result;
	}
	
	
		
	//Get Faq deatils Information by id
	function get_faq_list_details_edit($id)
	{
		$table		=	'srm_questions';	
		$condition	=	"srm_question_id	=	$id";
		$result		=	$this->model->get_faq_list_details_edit($table,$condition);
		return $result;
	}
	
	
	
	
		/* update_brand update*/
	function update_faq()
	{
		$table		=	'srm_questions';
		$srm_q_id	=	$_POST['id'];
		$faq		=	$_POST['faq'];
		$opt1		=	$_POST['opt1'];
		$opt2		=	$_POST['opt2'];
		$opt3		=	$_POST['opt3'];
		$opt4		=	$_POST['opt4'];
		$type		=	$_POST['type'];
		$set_array	=	array(
						'srm_questions'		=> $faq,
						'srm_question_opt1'	=> $opt1,
						'srm_question_opt2'	=> $opt2,
						'srm_question_opt3'	=> $opt3,
						'srm_question_opt4'	=> $opt4, 
						'srm_question_type'	=> $type, 
						);
		$condition 	=	"srm_question_id='".$srm_q_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	function sent_notifications($user_gcm_arr,$message,$subject){
		
		
        
        $url = 'https://android.googleapis.com/gcm/send';
		
        $fields = array(
		            'registration_ids' => $user_gcm_arr,
		            'data' => array("title" => $subject, "message"=> $message,"id"=>"")
		        );
				
		define("GOOGLE_API_KEY", "AIzaSyDfjQepXPy2GltXwE5ob-h8vw1o5w3pzls"); 
		       
	   $headers = array(
		            'Authorization: key='.GOOGLE_API_KEY,
		            'Content-Type: application/json'
		        );

		$ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		$result = curl_exec($ch);
		curl_close($ch);
		       
		        if ($result === FALSE) {
		            die('Curl failed: ' . curl_error($ch));
		        }
				else{
					curl_close($ch);
					return $result;
				} 
	}
	
	function get_standard_comments()
	{
		$table="yapnaa_standard_amc_comment";
		$result		=	$this->model->get_Detail_all($table);
		return $result;
	}
	
	function updateAMC($table,$upgarde_product_message,$paid_service_message,$upgarde_product_date,$paid_service_close_date,$paid_service,$upgarde_product,$admin_id,$start,$expire,$custID,$comments,$closedBy,$phone1,$phone2,$cust_name,$cust_email)
	{
		//echo '<script>alert('$_GET['customer_type']')</script>';
		if($paid_service==1){
			$set_array	=	array(
							'amc_updated_by'		=> $admin_id,							
							'CONTRACT_BY'		    => $closedBy,
							'last_call_comment'	    => $comments,
							'action_taken_by'	    => $admin_name,
							'action_taken_by_id'    => $ar_id,
							'CUSTOMER_NAME'         => $cust_name,
							'PHONE1'                => $phone1,
							'email'                 => $cust_email,
							'status'			    =>	"8",
							'req_service_date'  =>	$paid_service_close_date
						);
			$condition 	=	"CUSTOMERID='".$custID."'";				
			$this->model->update($table,$set_array,$condition);	
             $number = array($phone1);
			$message = 'Hello '.ucfirst($cust_name).'!'.$paid_service_message;
			$this->send_bulk_sms($number,$message);
			return 1;		
		}
		if($upgarde_product==1){
			$set_array	=	array(
							'amc_updated_by'		=> $admin_id,							
							'CONTRACT_BY'		    => $closedBy,
							'last_call_comment'	    => $comments,
							'action_taken_by'	    => $admin_name,
							'action_taken_by_id'    => $ar_id,
							'CUSTOMER_NAME'         => $cust_name,
							'PHONE1'                => $phone1,
							'email'                 => $cust_email,
							'status'			    =>	"9",
							'req_upgrade_date'  =>	$upgarde_product_date
						);
						//print_r($set_array);exit;
			$condition 	=	"CUSTOMERID='".$custID."'";				
			$this->model->update($table,$set_array,$condition);
			 $number = array($phone1);
			$message = 'Hello '.ucfirst($cust_name).'!'.$upgarde_product_message;
			$this->send_bulk_sms($number,$message);
			return 1;
		}
		$google_feedback_link="https://goo.gl/forms/D1HvGtyi68EVl11l2";
		
		$admin_name		= $_SESSION['admin_name'];
		$ar_id  	        = $_SESSION['ar_id'];
		if($expire !=NULL && $start !=NULL ){
			$set_array	=	array(
							'amc_updated_by'		=> $admin_id,
							'CONTRACT_TO'		    => $expire,
							'CONTRACT_FROM'		    => $start,
							'CONTRACT_BY'		    => $closedBy,
							'last_call_comment'	    => $comments,
							'action_taken_by'	    => $admin_name,
							'action_taken_by_id'    => $ar_id,
							'CUSTOMER_NAME'         => $cust_name,
							'PHONE1'                => $phone1,
							'email'                 => $cust_email,
							'status'			    =>	"7"
						);
		}
		else{
			$set_array	=	array(
						'amc_updated_by'		=> $admin_id,
						'CONTRACT_BY'		    => $closedBy,
						'last_call_comment'	    => $comments,
						'action_taken_by'	    => $admin_name,
						'action_taken_by_id'    => $ar_id,
						'CUSTOMER_NAME'         => $cust_name,
						'PHONE1'                => $phone1,
						'email'                 => $cust_email,
						'status'			    =>	"7"
					);	
		}
		$condition 	=	"CUSTOMERID='".$custID."'";				
		$update_zerob_result		= $this->model->update($table,$set_array,$condition);
		//echo $expire.'<br>'.$start;exit;
		 $number = array($phone1);
		$message = 'Dear Subscriber, your AMC for '.ucfirst($table).' water purifier has been renewed from '.$expire.' to '.$start.' . Thank you for connecting with yapnaa.com.';
		$this->send_bulk_sms($number,$message);
		
		$table1		=	'users';
		$condition 	=	"user_phone=".$phone1." OR user_phone=".$phone2;	
	    $fields		=	'*';
				
		$result1	=	$this->model->get_Details_condition($table1,$fields,$condition);		
		
		if($result1){
		   
			$sql 		= "SELECT * FROM `users_products` up WHERE `up_product_id` =1 AND up.up_user_id =  ".$result1[0]['user_id']." order by up_created_date asc";
			
			$result		=	$this->model->data_query($sql);
		
			if($result){
				//If the  water filter is added, update the AMC date and send notification
				$table2			=	"users_products";
				$set_array		=	array('up_warranty_start_date' => $start,'up_warranty_end_date'=>$expire,'up_amc_from_date'  => $start,'up_amc_to_date' =>$expire);
				$condition		=	"up_id = ".$result[0]['up_id'];
				$update_result	=	$this->model->update($table2,$set_array,$condition);
				
				$username=$result1[0]['user_name'];
				if($username !=NULL){
					$condition_msg="<p>Hi $username,</p><p>Greetings from Yapnaa!</p>";
					$condition_msg1="Hi $username,\nGreetings from Yapnaa!\n";
				}
				else{
					$condition_msg="<p>Greetings from Yapnaa!</p>";	
					$condition_msg1="Greetings from Yapnaa!\n";	
				}
				$message = $condition_msg."<p>Thank you for signing up AMC, kindly share your feedback on our services in the following link :-<a href='".$google_feedback_link."' >Click me</a></p>";
				$message1 = $condition_msg1."Thank you for signing up AMC, kindly share your feedback on our services in the following link :-\n".$google_feedback_link."";
				$subject = "AMC for your ".ucfirst($table)." Water Filter has been updated";
				
				$not_status = $this->sent_notifications(array($result1[0]['user_gcm_id']),$message1,$subject);
				//print_r($not_status);die;
				$to=$result1[0]['user_email_id'];
				$this->send_email($message,$subject,$to);
				return 1;
			}
			else{
				
				$condition 			=	"CUSTOMERID='".$custID."'";				
				$zerob_result		=	$this->model->get_Details_condition($table,'*',$condition);
				
				//Add product and send notification
				$prod_details	=		array(
											"up_user_id"				=>		$result1[0]['user_id'],
											"up_product_id"				=>		1,
											"up_amc_from_date"			=>		$start,
											"up_amc_to_date"			=>		$expire,
											"up_warranty_start_date"	=>		$start,
											"up_warranty_end_date"		=>		$expire,
											"up_serial_no"				=>		$zerob_result[0]['PRODUCT_SLNO'],
											"up_date_of_purchase"		=>		$zerob_result[0]['INSTALLATION_DATE'],
											"up_amc"					=>		"Yes",
											"up_product_title"			=>		ucfirst($table)." Water Filter"
								);
				//echo "Here";die;
				$prod_id	=	$this->add_user_product($prod_details);
				$username=$result1[0]['user_name'];
				if($username !=NULL){
					$condition_msg="<p>Hi $username,</p><p>Greetings from Yapnaa!</p>";
					$condition_msg1="Hi $username,\nGreetings from Yapnaa!\n";
				}
				else{
					$condition_msg="<p>Greetings from Yapnaa!</p>";	
					$condition_msg="Greetings from Yapnaa!\n";	
				}
				$message = $condition_msg."<p>Thank you for signing up AMC, kindly share your feedback on our services in the following link :-<a href='".$google_feedback_link."' >Click me</a></p>";
				$message1 = $condition_msg1."Thank you for signing up AMC, kindly share your feedback on our services in the following link :-\n".$google_feedback_link."";
				$subject	=	"AMC for your ".ucfirst($table)." Water Filter has been updated";
				
				$not_status = $this->sent_notifications(array($result1[0]['user_gcm_id']),$message1,$subject);
				$to=$result1[0]['user_email_id'];
				$this->send_email($message,$subject,$to);
				return 1;
			}
		}
		else{
			 $number = array($phone1);
			$message = 'AMC for your '.ucfirst($table).' Water Filter has been updated. Download the Yapnaa app http://bit.ly/YapnaaForAndroid to maintain services, AMC and bills for your electronic products.';
			$get_amc_list = $this->send_bulk_sms($number,$message);
			return 1;
		}
		return 0;
	}
	
	function add_user_product($prod_deatils){
		$table		=	"users_products";//print_r($prod_deatils);die;
		$result		=	$this->model->insert($table,$prod_deatils);
		if($result){
			return $result;
		}
		return 0;
	}
	
		/*Delete the faq*/
	function del_faq()
	{
		$table		=	'srm_questions';
		$srm_q_id	=	$_POST['id'];
		$condition	=	"srm_question_id='$srm_q_id'";
		$res		=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	/*Add the add_brand*/
	function add_brand()
	{
		date_default_timezone_set('Asia/Kolkata');
		$brand					=	$_POST['brand'];
		$priority				=	$_POST['priority'];
		$brand_created_date		=	date("l jS \of F Y h:i:s A");
		$table					=	'brands';
		$add_icon				=	'';
		if(!empty($_FILES['icon']['tmp_name']))
			{ 
				// echo "hi";exit;
				$filename = basename($_FILES['icon']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				$now = new DateTime();
				$times = $now->getTimestamp();
				$target = "../../brand-icon/"; 
				//Determine the path to which we want to save this file
				$newname = $target.$times.'-'.$filename;
				$newname1 = $times.'-'.$filename;
				//echo $newname;exit;
				//Check if the file with the same name is already exists on the server
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['icon']['tmp_name'],$newname))) {
							$add_icon=$newname1;
						}else{
							$message	=	"Could not move the file!";
						}
					} 
			}
		
		$arr_input	=	array(
						'brand_name'				=>	$brand,
						'brand_created_date'		=>	$brand_created_date,
						'brand_icon'				=>	$add_icon,
						'brand_priority'			=>	$priority,
						'brand_status'				=>	1
						);
		$result		=	$this->model->insert($table,$arr_input);
		return $result;
	}
	
	
	
	
	
	
	
	
	//Get brands  Information by id
	function get_brand()
	{
		$table		=	'brands';	
		// $order_by	=	'brand_priority';	
		$fields		=	'*';
		$condition 	=	"brand_status='1'";				
		$result		=	$this->model->get_Details_condition($table,$fields,$condition);
		// $result	=	$this->model->get_Detail_all_order_by($table,$order_by);
		return $result;
	}
	
	
	
	
	
	/*Delete the brands*/
	function del_brand()
	{
		$table		=	'brands';
		$brand_id	=	$_POST['id'];
		$condition	=	"brand_id='$brand_id'";
		$res		=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	
	//Get brand  Information by id
	function get_brand_by_id($id)
	{
		$table		=	'brands';
		$fields		=	'*';
		$condition 	=	"brand_id='".$id."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		return $result;
	}
	function updateStatus($id,$comment,$status,$custType){
		date_default_timezone_set('Asia/Kolkata');
		$admin_name		= $_SESSION['admin_name'];
		$ar_id  	        = $_SESSION['ar_id'];
		$today = date("Y-m-d H:i:s");
		/*$user_table		    =	'users';
		$user_condition 	=	"user_phone='".$number."'";	
		$user_fields		=	'*';
				
		$user_result1	=	$this->model->get_Details_condition($user_table,$user_fields,$user_condition);	
		if($user_result1 !=NULL)
		{*/
		$set_array = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>$status,
						'last_sms_sent'=>'',
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id
					);
		if($custType==2)
		{			
		$table		=	'zerob_consol1';
		}
		if($custType==1){
		$table		=	'livpure';	
		}
		if($custType==3){
		$table		=	'livpure_tn_kl';	
		}
		$condition 	=	"id='".$id."'";	
	    $fields		=	'*';
				
		$result1	=	$this->model->get_Details_condition($table,$fields,$condition);				
		if($result1 !=NULL)
		{
		$result	=	$this->model->update($table,$set_array,$condition);
		}
		else
		{
			$set_array1 = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>$status,
						'last_sms_sent'=>'',
						'id'=>$id,
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id
					);
			$result	=	$this->model->insert($table,$set_array1);
		}
			if($result){
				return 1;
			 }
			 else{
				return 0;
			}
		/*}
		else{
			return 0;
		}*/
	}
	function update_amc_dates($id,$amcExpDate,$amcServiceDate,$custType,$ls_ser_date){
		date_default_timezone_set('Asia/Kolkata');
		$set_array = array(
						
						'CONTRACT_TO'=>$amcExpDate,
						'next_service_date'=>$amcServiceDate,
						'last_service_date'=>$ls_ser_date
						
					);
		if($custType==2)
		{			
		$table		=	'zerob_consol1';
		}
		if($custType==1){
		$table		=	'livpure';	
		}
		if($custType==3){
		$table		=	'livpure_tn_kl';	
		}
		$condition 	=	"id='".$id."'";	
	    $fields		=	'*';
				
		$result1	=	$this->model->get_Details_condition($table,$fields,$condition);				
		if($result1 !=NULL)
		{
		$result	=	$this->model->update($table,$set_array,$condition);
		}
		
			if($result){
				return 1;
			 }
			 else{
				return 0;
			}
		/*}
		else{
			return 0;
		}*/
	}
	function zerob_appointment_sms($id,$apptDate,$number,$comment,$custType){ 
		date_default_timezone_set('Asia/Kolkata');
		$today = date("Y-m-d H:i:s");
		$message	=	"Thanks for confirming your appointment​ for Water filter. We look forward to seeing you on ​".$apptDate;
		$user_number = array($number);
		$admin_name		= $_SESSION['admin_name'];
		  $ar_id  	        = $_SESSION['ar_id'];
		$this->send_user_sms($user_number,$message,$id,$comment);
		
		$time = strtotime($apptDate);
		$newformat = date('Y-m-d H:i:S',$time);
		
		$set_array = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>3,
						'last_sms_sent'=>$message,
						'amc_appointment_datetime'=>$newformat,
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id
					);
		if($custType==2)
		{			
		$table		=	'zerob_consol1';
		}
		else{
		$table		=	'livpure';
		}
		$condition 	=	"id='".$id."'";	
		$fields		=	'*';
				
		$result1	=	$this->model->get_Details_condition($table,$fields,$condition);		
		if($result1 !=NULL)
		{
			$result	=	$this->model->update($table,$set_array,$condition);
		}
		else
		{
			$set_array1 = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>3,
						'last_sms_sent'=>$message,
						'id'=>$id,
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id
					);
			$result	=	$this->model->insert($table,$set_array1);
		}
			if($result){
				return 1;
			  }
			  else{
				return 0;
			}
		/*}
		else{
			return 0;
		}*/
	}
	function zerob_appointment_expiry_sms($id,$apptDate,$number,$comment,$custType){ 
		date_default_timezone_set('Asia/Kolkata');
		$today = date("Y-m-d H:i:s");
		$message	=	"AMC for your ZeroB product is expiring on ​".$apptDate.". Register with Yapnaa and renew your AMC. http://bit.ly/YapnaaForAndroid";
		$user_number = array($number);
		$admin_name		= $_SESSION['admin_name'];
		 $ar_id  	        = $_SESSION['ar_id'];
		/*$user_table		    =	'users';
		$user_condition 	=	"user_phone='".$number."'";	
		$user_fields		=	'*';
				
		$user_result1	=	$this->model->get_Details_condition($user_table,$user_fields,$user_condition);	
		if($user_result1 !=NULL)
		{*/
		$this->send_user_sms($user_number,$message,$id,$comment);
		
		$set_array = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>6,
						'last_sms_sent'=>$message,
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id 
					);
		if($custType==2)
		{			
		$table		=	'zerob_consol1';
		}
		else{
		$table		=	'livpure';	
		}
		$condition 	=	"id='".$id."'";	
        $fields		=	'*';
		
		$result1	=	$this->model->get_Details_condition($table,$fields,$condition);		
		if($result1 !=NULL)
		{
		$result	=	$this->model->update($table,$set_array,$condition);
		}
		else
		{
			$set_array1 = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>3,
						'last_sms_sent'=>$message,
						'id'=>$id,
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id 
					);
			$result	=	$this->model->insert($table,$set_array1);
		}
			if($result){
				return 1;
			 }
			 else{
				return 0;
			}
		/*}
		else{
			return 0;
		}*/
	}
	
	function send_user_sms($user_numbers,$message,$id,$comment="",$custType){ 
		date_default_timezone_set('Asia/Kolkata');
		$today = date("Y-m-d H:i:s");
		$admin_name		= $_SESSION['admin_name'];
		 $ar_id  	        = $_SESSION['ar_id'];
		if($user_numbers){
			
			for($i=0;$i<count($user_numbers);$i++){
				if($user_numbers[$i]){
                  	//$get_user_list = $control->get_user_sms($user_sms[2],$subject,$message);
		              	$user_phone = $user_numbers[$i];
						$desc = $message;
						//$user_phone 				= 	$_POST['mobile'];
						//$desc 						= 	$_POST['desc'];
						$ch = curl_init();
						$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_phone)."&message=".urlencode("".$desc ."");
						curl_setopt( $ch,CURLOPT_URL, $url );
						curl_setopt( $ch,CURLOPT_POST, false ); 
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
						$result = curl_exec($ch );
						curl_close( $ch ); 
						/*if($ch){
							return 1;
						}*/
						/*$user_table		    =	'users';
						$user_condition 	=	"user_phone='".$number."'";	
						$user_fields		=	'*';
								
						$user_result1	=	$this->model->get_Details_condition($user_table,$user_fields,$user_condition);	
						if($user_result1 !=NULL)
						{*/
								$set_array = array(
								'last_called'=>$today,
								'last_call_comment'=>$comment,
								'status'=>5,
								'last_sms_sent'=>$message,
								'action_taken_by'=>$admin_name,
								'action_taken_by_id'=> $ar_id 
							);
							if($custType==2){	
							$table		=	'zerob_consol1';
							}
							else{
							$table		=	'livpure';	
							}
							$condition 	=	"id='".$id[$i]."'";	
                            $fields		=	'*';							
							$result1	=	$this->model->get_Details_condition($table,$fields,$condition);		
								if($result1 !=NULL)
								{
								$result	=	$this->model->update($table,$set_array,$condition);
								}
								else
								{
									$set_array1 = array(
												'last_called'=>$today,
												'last_call_comment'=>$comment,
												'status'=>5,
												'last_sms_sent'=>$message,
												'action_taken_by'=>$admin_name,
								                'action_taken_by_id'=> $ar_id,
												'id'=>$id[$i]
											);
									$result	=	$this->model->insert($table,$set_array1);
								}
						//}
				}
			}	
		}		
		else{
			return 0;
		}
	}
	function send_sms_to_new_user($user_numbers,$message){ 
		date_default_timezone_set('Asia/Kolkata');
	
	   if($user_numbers){
	
			
			$ch = curl_init();
			$url = 'http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto='.urlencode($user_numbers).'&message='.urlencode($message);
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch );  
						
			
		}		
		
	}
	
	
	function get_user_sms($user_list,$subject,$message){
		//print_r($user_list);
		//die();
		for($i=0;$i<count($user_list);$i++){
              $user_sms = explode("|",$user_list[$i]);
              //print_r($user_sms);
              	if($user_sms[2]){
                  	//$get_user_list = $control->get_user_sms($user_sms[2],$subject,$message);
		              	$user_phone = $user_sms[2];
						$desc = $message;
						//$user_phone 				= 	$_POST['mobile'];
						//$desc 						= 	$_POST['desc'];
						$ch = curl_init();
						$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_phone)."&message=".urlencode("".$desc ."");
						curl_setopt( $ch,CURLOPT_URL, $url );
						curl_setopt( $ch,CURLOPT_POST, false ); 
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
						$result = curl_exec($ch );
						curl_close( $ch ); 

			        }
			   }
		
		 
		//if($result){
			//echo '1';
			//echo '<script>alert("sms sent successfully.")</script>';
		//}
		echo '<script>alert("sms sent successfully.")</script>';	   
		echo '<script>window.location.assign("user_notifications.php")</script>';
			 
	}

	function get_user_mail($user_list,$subject,$message){

		//echo 'tt';
		/*
		$to= 'hema.jjbytes@gmail.com';
				$subject		=	'testing';
				$message        =	'test';
	            mail($to, $subject, $message);
		*/

	    for($i=0;$i<count($user_list);$i++){
            $user_mail = explode("|",$user_list[$i]);
              //print_r($user_mail);
              //die();
	          if($user_mail[1]){
	              	$to 			= 	$user_mail[1];
					$subject		=	$subject;
					$message		=	'<html>
					<body>
					 <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
					<p>Hi,<strong>' . $user_full_name . '</strong></p>
					<p>'.$message.'</p>
				
					</table>
					</body>
					</html>';
				
						
			        $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
			        $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
			        $headers1 		.= 	"From:admin@gmail.com\r\n";
			        //mail($to, $subject, $message, $headers1);
			        if(mail($to, $subject, $message, $headers1)){
			        	$res =  "1";
			        }
	          }
        } 

      
    	if($res ==1){
          	echo '<script>alert("Mail sent successfully.")</script>';
          	echo '<script>window.location.assign("user_notifications.php")</script>';
      	}
          

        //echo '<script>alert("Mail sent successfully.")</script>';
        //echo '<script>window.location.assign("user_notifications.php")</script>';
		/*
		$to 			= 	"hema.jjbytes@gmail.com";
		$subject		=	$subject;
		$message		=	'<html>
		<body>
		 <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
		<p>Hi,<strong>' . $user_full_name . '</strong></p>
		<p>'.$message.'</p>
	
		</table>
		</body>
		</html>';
	
			
        $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
					
        $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
        $headers1 		.= 	"From:admin@gmail.com\r\n";
            mail($to, $subject, $message, $headers1);

        //if (mail($to, $subject, $message, $headers1)) {
				// return $user_reg_verification_otp;
        //}			//return $fields_reg;

        */
	} 

	function sent_noti_user($user_list,$message,$subject){
		
		for($i=0;$i<count($user_list);$i++){
            $user_gcm = explode("|",$user_list[$i]);
              //print_r($user_mail[1]);
              //die();
            if($user_gcm[3]){
                //$gcm = $this->sendMessageThroughGCM($user_gcm[3],$message);
            	$url = 'https://android.googleapis.com/gcm/send';
		        $fields = array(
		            'registration_ids' => array($user_gcm[3]),
		            'data' => array("title" => $subject, "message"=> $message,"id"=>"")
		        );
				/*echo '<pre>';print_r($fields);
				exit;*/	
				// Update your Google Cloud Messaging API Key 
				define("GOOGLE_API_KEY", "AIzaSyDfjQepXPy2GltXwE5ob-h8vw1o5w3pzls"); 
		        $headers = array(
		            'Authorization: key='.GOOGLE_API_KEY,
		            'Content-Type: application/json'
		        );
		        $ch = curl_init();
		        curl_setopt($ch, CURLOPT_URL, $url);
		        curl_setopt($ch, CURLOPT_POST, true);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		        $result = curl_exec($ch);
		        curl_close($ch);

		        print_r($result);
		       				
		        if ($result === FALSE) {
		            die('Curl failed: ' . curl_error($ch));
		        }
				// print_r($result);  exit;
		        curl_close($ch);
		        
		        

            }
			//return $result ;
        }
        echo '<script>alert('.$result.')</script>';

        //echo '<script>alert("Notification sent successfully.")</script>';
        //echo '<script>window.location.assign("user_notifications.php")</script>';	
	}
	
	/* update_brand update*/
	function update_brand()
	{
		$table		=	'brands';
		$brand_id	=	$_POST['id'];
		$brand		=	$_POST['brand'];
		$priority	=	$_POST['priority'];
		
		
		if(!empty($_FILES['icon']['tmp_name']))
		{ 
			// echo "hi";exit;
			$filename = basename($_FILES['icon']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$now = new DateTime();
			$times = $now->getTimestamp();
			$target = "../../brand-icon/"; 
			//Determine the path to which we want to save this file
			$newname = $target.$times.'-'.$filename;
			$newname1 = $times.'-'.$filename;
			//echo $newname;exit;
			//Check if the file with the same name is already exists on the server
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['icon']['tmp_name'],$newname))) {
						$add_icon=$newname1;
					}else{
						$message	=	"Could not move the file!";
					}
				}
		

		$set_array	=	array(
						'brand_name'		=> $brand,
						'brand_icon'		=> $add_icon,
						'brand_priority'	=> $priority,
						);

						
		}else{ 
		
			$set_array	=	array(
							'brand_name'		=> $brand,
							'brand_priority'	=> $priority,
							);
			
		}
		
		$condition 	=	"brand_id='".$brand_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
		
	}
	
	
	
	
	/* deactive_brand update*/
	function deactive_brand()
	{
		$table		=	'brands';
		$brand_id	=	$_POST['id']; 
		$set_array	=	array(
						'brand_status'=> 0
						);
		$condition 	=	"brand_id='".$brand_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
		
	/* active_brand update*/
	function active_brand()
	{
		$table		=	'brands';
		$brand_id	=	$_POST['id']; 
		$set_array	=	array(
						'brand_status'=> 1
						);
		$condition 	=	"brand_id='".$brand_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	/*Add the Category*/
	function add_category()
	{
		date_default_timezone_set('Asia/Kolkata');
		$category					=	$_POST['category'];
		$priority					=	$_POST['priority'];
		
		
		
		
		$table		=	'product_category_list';
		$fields		=	'*';
		$condition 	=	"p_category_name='".$category."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		
		if(empty($result)){
		
			if(!empty($_FILES['icon']['tmp_name']))
			{ 
				// echo "hi";exit;
				$filename = basename($_FILES['icon']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				$now = new DateTime();
				$times = $now->getTimestamp();
				$target = "../../product-icon/"; 
				//Determine the path to which we want to save this file
				$newname = $target.$times.'-'.$filename;
				$newname1 = $times.'-'.$filename;
				//echo $newname;exit;
				//Check if the file with the same name is already exists on the server
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['icon']['tmp_name'],$newname))) {
							$add_icon=$newname1;
						}else{
							$message	=	"Could not move the file!";
						}
					}
				
			}
			
			
			if(!empty($_FILES['icon2']['tmp_name']))
			{ 
				// echo "hi";exit;
				$filename = basename($_FILES['icon2']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				$now = new DateTime();
				$times = $now->getTimestamp();
				$target = "../../product-icon/"; 
				//Determine the path to which we want to save this file
				$newname = $target.$times.'-'.$filename;
				$newname1 = $times.'-'.$filename;
				//echo $newname;exit;
				//Check if the file with the same name is already exists on the server
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['icon2']['tmp_name'],$newname))) {
							$medium_icon=$newname1;
						}else{
							$message	=	"Could not move the file!";
						}
					}
				
			}
			
			
			$category_created_date		=	date("l jS \of F Y h:i:s A");
			$table						=	'product_category_list';
			
			
			$arr_input	=	array(
								'p_category_name'				=>	$category,
								'p_category_c_date'				=>	$category_created_date,
								'p_category_icon_small'			=>	$add_icon,
								'p_category_icon_medium'		=>	$medium_icon,
								'p_category_priority'			=>	$priority,
							);
			$result		=	$this->model->insert($table,$arr_input);
			return $result;
		}else{
			return $result='';
		}
	}
	
	
	
	
	
	
	//Get Category
	function get_category()
	{
		$table		=	'product_category_list';	
		$oredr_by	=	'p_category_priority';	
		$fields		=	'*';
		// $condition 	=	"p_category_status='1'";				
		// $result		=	$this->model->get_Details_condition($table,$fields,$condition);
		$result	=	$this->model->get_Detail_all_order_by($table,$oredr_by);
		return $result;
	}
	
	
	
	
	
	
	
	
	/*Delete the Category*/
	function del_category()
	{
		$table			=	'product_category_list';
		$p_category_id	=	$_POST['id'];
		$condition		=	"p_category_id='$p_category_id'";
		$res			=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	
	
	
	//Get Category  Information by id
	function get_product_category_by_id($id)
	{
		$table		=	'product_category_list';
		$fields		=	'*';
		$condition 	=	"p_category_id='".$id."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		return $result;
	}
	
	
	
	
	
	/* Category update*/
	function update_category()
	{
			
		$table				=	'product_category_list';
		$p_category_id		=	$_POST['id'];
		$p_category_name	=	$_POST['p_category_name'];
	
		
		if(!empty($_FILES['icon']['tmp_name']))
				{ 
					// echo "hi";exit;
					$filename = basename($_FILES['icon']['name']);
					$ext = substr($filename, strrpos($filename, '.') + 1);
					$now = new DateTime();
					$times = $now->getTimestamp();
					$target = "../../product-icon/"; 
					//Determine the path to which we want to save this file
					$newname = $target.$times.'-'.$filename;
					$newname1 = $times.'-'.$filename;
					//echo $newname;exit;
					//Check if the file with the same name is already exists on the server
						if (!file_exists($newname)) {
						//Attempt to move the uploaded file to it's new place
							if ((move_uploaded_file($_FILES['icon']['tmp_name'],$newname))) {
								$add_icon=$newname1;
							}else{
								$message	=	"Could not move the file!";
							}
						}
						
						
						$condition 			=	"p_category_name='".$p_category_name."'";				
						$result				=	$this->model->get_Details_condition($table,$fields,$condition);
						if(empty($result)){
							$set_array	=	array(
									'p_category_name'				=>	$p_category_name,
									'p_category_icon_small'			=>	$add_icon,
									);
							$condition 			=	"p_category_id='".$p_category_id."'";				
							$result				=	$this->model->update($table,$set_array,$condition);
							// echo '<pre>';print_r($set_array);exit;
							return $result;
						}else{
							$set_array	=	array(
									'p_category_icon_small'			=>	$add_icon,
									);
							$condition 			=	"p_category_id='".$p_category_id."'";				
							$result				=	$this->model->update($table,$set_array,$condition);
							// echo '<pre>';print_r($set_array);exit;
							return $result;
						
						}
				}else{
				// echo "hello";exit;
					$fields				='*';
					$condition 			=	"p_category_name='".$p_category_name."'";				
					$result				=	$this->model->get_Details_condition($table,$fields,$condition);
					// echo '<pre>';print_r($result);exit;
					if(empty($result)){
							$set_array	=	array(
								'p_category_name'				=>	$p_category_name,
								);
							$condition 			=	"p_category_id='".$p_category_id."'";				
							$result				=	$this->model->update($table,$set_array,$condition);
							// echo '<pre>';print_r($set_array);exit;
							return $result;
						}else{
							return $result='';
						
						}
						
				}
				
				
		
	}
	
	
	
	
	
	
	/* deactive_category update*/
	function deactive_category()
	{
		$table			=	'product_category_list';
		$p_category_id	=	$_POST['id']; 
		$set_array		=	array(
							'p_category_status'=> 0
							);
		$condition 		=	"p_category_id='".$p_category_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	/* active_category update*/
	function active_category()
	{
		$table			=	'product_category_list';
		$p_category_id	=	$_POST['id']; 
		$set_array		=	array(
							'p_category_status'=> 1
							);
		$condition 		=	"p_category_id='".$p_category_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	
	/*Add the add_brand_product*/
	function add_brand_product()
	{
		date_default_timezone_set('Asia/Kolkata');
		$brdnadid						=	$_POST['brdnadid'];
		$brand_product_name				=	$_POST['brand_product_name'];
		$brand_product_created_date		=	date("l jS \of F Y h:i:s A");
		$table							=	'brand_products';
		
		
		$add_icon='';
		
		
		$fields		=	'*';
		$condition 	=	"product_name='".$brand_product_name."' and product_brand_id='".$brdnadid."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		// echo'<pre>';print_r($result);exit;
		if(empty($result)){
			$arr_input	=	array(
							'product_brand_id'				=>	$brdnadid,
							'product_name'					=>	$brand_product_name,
							'product_created_date'			=>	$brand_product_created_date,
							'product_status'				=>	1
							);
			$result		=	$this->model->insert($table,$arr_input);
			return $result;
			
		
		}else{
			return $result='';
		}
		
	}
	
	
	
			
	//Get get_brand_product 
	function get_brand_product()
	{
		$table		=	'brand_products';
		$result	=	$this->model->get_brand_product($table);
		return $result;
	}
	
	
	
	//Get brand  Information by id
	function get_brand_product_by_id($id)
	{
		$table		=	'brand_products';
		$fields		=	'*';
		$condition 	=	"product_id='".$id."'";				
		$result	=	$this->model->get_brand_by_id($table,$fields,$condition);
		return $result;
	}
	
	
	
	
	
	
	/* update_brand_product update*/
	function update_brand_product()
	{
		
		$id								=	$_POST['id'];
		$brdnadid						=	$_POST['brdnadid'];
		$brand_product_name				=	$_POST['brand_product_name'];
		$table							=	'brand_products';
		
		
		$add_icon='';
		
		$fields		=	'*';
		$condition 	=	"product_name='".$brand_product_name."' and product_brand_id='".$brdnadid."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		// echo'<pre>';print_r($result);exit;
		if(empty($result)){ 
					$set_array	=	array(
									'product_brand_id'				=>	$brdnadid,
									'product_name'					=>	$brand_product_name,
									'product_status'				=>	1
									);
				$condition 	=	"product_id='".$id."'";				
				$result		=	$this->model->update($table,$set_array,$condition);
				return $result;
				
		}else{
			return $result='';
		}
	}
	
	
	
	
	
	
	/* deactive_brand_products update*/
	function deactive_brand_products()
	{
		$table		=	'brand_products';
		$product_id	=	$_POST['id']; 
		$set_array	=	array(
						'product_status'=> 0
						);
		$condition 	=	"product_id='".$product_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
		
	/* active_brand_products update*/
	function active_brand_products()
	{
		$table		=	'brand_products';
		$product_id	=	$_POST['id']; 
		$set_array	=	array(
						'product_status'=> 1
						);
		$condition 	=	"product_id='".$product_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
		
	/*Delete the brands*/
	function del_brand_product()
	{
		$table		=	'brand_products';
		$product_id	=	$_POST['id'];
		$condition	=	"product_id='$product_id'";
		$res		=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
		//Get get_user_list 
	function get_user_list()
	{
		
		$table		    =	'users';
		$order_by       =   'user_id';
		return $result	=	$this->model->get_Detail_all_order_by_desc($table,$order_by);
	}
		//Get get_filtered_user_list 
	function get_filtered_user_list($filter)
	{ 
		$table		=	'users';
		$fields		=	'*';
		if($filter == 0){
			 
		}
		else if($fil){
			$condition	=	'';
		}
				
	
		switch($filter){
			
			case 0:
			    $order_by       =   'user_id';
				return $result	=	$this->model->get_Detail_all_order_by_desc($table,$order_by);
			break;
			case 1:
				$condition		=	'user_phone IN ( SELECT phone1 FROM zerob_consol1 ) OR user_phone  IN ( SELECT phone2 FROM zerob_consol1 ) order by user_id desc';
				return $result	=	$this->model->get_Details_condition($table,$fields,$condition);
			break;
			
			case 2:
				$condition		=	'user_phone IN ( SELECT phone1 FROM livpure ) OR user_phone  IN ( SELECT phone2 FROM livpure ) order by user_id desc';
				return $result	=	$this->model->get_Details_condition($table,$fields,$condition);
			break;
			case 3:
				$condition		=	'user_phone NOT IN ( SELECT phone1 FROM zerob_consol1 ) OR user_phone NOT  IN ( SELECT phone2 FROM zerob_consol1 ) OR user_phone NOT IN ( SELECT phone1 FROM livpure ) OR user_phone NOT IN ( SELECT phone2 FROM livpure ) order by user_id desc';
				return $result	=	$this->model->get_Details_condition($table,$fields,$condition);
			break;
		}
		//$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		return $result;
	}
	
	function get_user_added_products()
	{
		$table		=	'users_products';
		$result	=	$this->model->get_Detail_user_added_products($table);
		return $result;
	}
	
	
	
	
	// Get get_particular_user_details
	function get_particular_user_details($id)
	{
		$table		=	'users';
		$fields		=	'*';
		$condition 	=	"user_id='".$id."'";		
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		return $result;
	}
	
	
	
	
	// Get User product List
	function get_particular_user_product_list($id)
	{
		
		$table		=	'users_products';
		$fields		=	'*';
		$condition 	=	"up.up_user_id='".$id."'";		
		$result	=	$this->model->get_particular_user_product_list($table,$fields,$condition);
		return $result;
		//print_r($result);
	}
	
	
	
	
	// Get User product List
	function get_particular_user_product_details($id)
	{
		$table		=	'brand_products';
		$fields		=	'*';
		$condition 	=	"product_id='".$id."'";		
		$result	=	$this->model->get_particular_user_product_details($table,$fields,$condition);
		return $result;
	}
	
	
	
	
	
	
	
	/* user_block update*/
	function user_block()
	{
		
		$user_id			=	$_POST['id'];
		$user_status		=	0;
		$table				=	'users';
		$set_array	=	array(
							'user_id'						=>	$user_id,
							'user_status'					=>	$user_status
							);
							
		// print_r($set_array);	exit;				
		$condition 			=	"user_id='".$user_id."'";				
		$result				=	$this->model->update($table,$set_array,$condition);
		return $result;
		
	}
	
	
    
	// user registartion
    function user_resgitartion($name,$mobile,$email)
    {

		$keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		// print_r($keys[0]);
		// print_r($keys[1]);
		$pin = rand(1000,9999);
        $table 					= table();
		date_default_timezone_set('Asia/Kolkata');
        $user_name 					=	$name;
        $user_address 				= 	"";
        $user_phone 				= 	$mobile;
        $user_email_id 				= 	$email;
        $user_city           		= 	"";
        $user_pin		    		= 	md5($pin);
        $user_area_pincode			= 	"";
        $user_gcm_id      			= 	"";
        $user_login_device_type		= 	"";
        $app_key	      			= 	$_POST['app_key'];
        $app_secret      			= 	$_POST['app_secret'];
        $user_created_date 			= 	date('Y-m-d h:i:s');
        $user_last_login 			= 	date('Y-m-d h:i:s');
        $user_reg_verification_otp	= "";
        $user_token					= "";
		
		if(($keys[0]==$app_key) && ($keys[1]==$app_secret)){
			$res	=	1;
		}else{
			$res	=	0;
		}
		
		
		
		
        if ($res==1) {
            $table           = table();
            $table_user      = $table['tb1'];
            $fields_user     = '*';
            // $condition_user  = 'user_phone    = ' . "'" . $user_phone . "'" . ' OR user_email_id = ' . "'" . $user_email_id . "'";
            $condition_user  = 'user_phone    = ' . "'" . $user_phone . "'";
            $arr_result_test = $this->model->get_Details_condition($table_user, $fields_user, $condition_user);
            // print_r($arr_result_test);exit;
           
        }else{
			$arr_result_test=1;
		}
          // print_r($arr_result_test);exit;
        if (empty($arr_result_test)) {
          
            $fields_reg = array(
                'user_name' 				=> $user_name,
                'user_address' 				=> $user_address,
                'user_phone' 				=> $user_phone,
                'user_email_id' 			=> $user_email_id,
                'user_city' 				=> $user_city,
                'user_pin' 					=> $user_pin,
                'user_area_pincode' 		=> $user_area_pincode,
                'user_token' 				=> $user_token,
                'user_gcm_id' 				=> $user_gcm_id,
                'user_login_device'			=> $user_login_device_type,
                'user_reg_verification_otp'	=> $user_reg_verification_otp,
                'user_created_date' 		=> $user_created_date,
                'user_last_login' 			=> $user_last_login
            );
            
            // print_r($fields_reg);exit;
			
            $table_log_in = $table['tb1'];
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
			
			
			
			$ch = curl_init();
			$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_phone)."&message=You have been registered to Yapnaa, Use your mobile number with ".urlencode("".$user_reg_verification_otp ." as password.\n.");
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch ); 
			
			return $user_reg_verification_otp;
			
            
        }
    }
    
	
	/* user_block update*/
	function user_acitve()
	{
		
		$user_id			=	$_POST['id'];
		$user_status		=	1;
		$table				=	'users';
		$set_array	=	array(
							'user_id'						=>	$user_id,
							'user_status'					=>	$user_status
							);
							
		// print_r($set_array);	exit;				
		$condition 			=	"user_id='".$user_id."'";				
		$result				=	$this->model->update($table,$set_array,$condition);
		return $result;
		
	}
	
	
	
	//Get brand  Information by id
	function get_brand_product_list($id)
	{
		$table		=	'brand_products';
		$fields		=	'*';
		$condition 	=	"product_brand_id='".$id."'";		
		$result	=	$this->model->get_brand_product_list($table,$fields,$condition);
		return $result;
	}
	
	
	
	//SRM Request List
	function srm_request_list()
	{
		$table		=	'SRM';
		$result	=	$this->model->srm_request_list($table);
		return $result;
	}
	
	
	//SRM Request List
	function srm_request_list_particular_details($id)
	{
		$table		=	'SRM';
		$fields		=	'*';
		$condition 	=	"srm_id='".$id."'";		
		$result	=	$this->model->srm_request_list_particular_details($table,$fields,$condition);
		return $result;
	}
	
	function my_test()
	{
		echo "here";
	}
	
	
	function srm_request_mvq_convert()
	{
		
		$srm_id					=	$_POST['srm_id'];
		$mvq_admin_name			=	$_POST['mvq_admin_name'];
		$mvq_admin_phone_no		=	$_POST['mvq_admin_phone_no'];
		$mvq_execative_notes	=	$_POST['mvq_execative_notes'];
		$srm_status				=	$_POST['srm_status'];
		date_default_timezone_set('Asia/Kolkata');
		$MVQ_no_generated_date	=	date('Y-m-d h:i:s');
		$MVQ_No					=	rand(1000, 99999);
		$table					=	'SRM';
		$set_array	=	array(
							'srm_MVQ_no'					=>	$MVQ_No,	
							'srm_MVQ_execative_notes'		=>	$mvq_execative_notes,	
							'srm_MVQ_execative_number'		=>	$mvq_admin_phone_no,	
							'srm_MVQ_execative_name'		=>	$mvq_admin_name,	
							'srm_MVQ_no_generated_date'		=>	$MVQ_no_generated_date,
							'srm_status'					=>	$srm_status,
							);
							
		// echo '<pre>';print_r($set_array);	exit;			
 
		$condition 			=	"srm_id='".$srm_id."'";				
		$result				=	$this->model->update($table,$set_array,$condition);
		
		if($result){ 
			
			//get usr id
			$fields			=	'*';
			$condition 		=	"srm_id='".$srm_id."'";		
			$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
			$user_id		=	$result[0]['srm_user_id'];
			
			
			//get user gcm and device type
			$table_user		=	'users';
			$fields			=	'*';
			$condition 		=	"user_id='".$user_id."'";		
			$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
			$device_type	=	$result[0]['user_login_device']; 
			$user_gcm_id	=	$result[0]['user_gcm_id']; 
			// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
			// echo'<pre>';print_r($result);exit;
			
			
			
			if($srm_status==2){
			 
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}

			}elseif($srm_status==3){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"Assigning-Engineer";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
			
			}elseif($srm_status==5){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"Ticket-cancelled";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
			
			}elseif($srm_status==6){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
			
			}else{
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	'Ticket has been closed';
					$pushMessage['message']			 = 	"MVQ No Generated Successfully";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
			
			
			}
			
			
			if($device_type=='IOS'){ 
				return $result;
			}	
			
			
			
			
		}
		
	}
	
	
	
	
	
	
	
	function srm_request_take_action()
	{
		/* $myfile = fopen("/var/www/html/apiparam.txt", "a") or die("Unable to open file!");
		$txt = "\r\n" . date('d-m-Y H:i') . ":  " . $this->uri->segment(3) . "/" . $this->uri->segment(4);
		$txt.= "\r\n" . json_encode($_POST); //$new_url.'  -  '.json_encode($_POST)." ".json_encode($_FILES);
		$txt.= "\r\n" . json_encode($_FILES); //$new_url.'  -  '.json_encode($_POST)." ".json_encode($_FILES);
		fwrite($myfile, $txt);
		fclose($myfile); */
		$srm_id						=	$_POST['srm_id'];
		$srm_take_action_E_name		=	$_POST['mvq_admin_name'];
		$srm_take_action_E_phone_no	=	$_POST['mvq_admin_phone_no'];
		$srm_take_action_E_notes	=	$_POST['mvq_execative_notes'];
		$srm_status					=	$_POST['srm_status'];
		date_default_timezone_set('Asia/Kolkata');
		$srm_take_action_c_date	=	date('Y-m-d h:i:s'); 
		$table					=	'SRM';
		$set_array	=	array( 
							'srm_take_action_E_notes'		=>	$srm_take_action_E_notes,	
							'srm_take_action_E_phone_no'	=>	$srm_take_action_E_phone_no,	
							'srm_take_action_E_name'		=>	$srm_take_action_E_name,	
							'srm_take_action_c_date'		=>	$srm_take_action_c_date,
							'srm_status'					=>	$srm_status,
							);
							
		// echo '<pre>';print_r($set_array);	exit;			
 
		$condition 			=	"srm_id='".$srm_id."'";				
		$result				=	$this->model->update($table,$set_array,$condition);
		
		if($result){ 
			
			//get usr id
			$fields			=	'*';
			$condition 		=	"srm_id='".$srm_id."'";		
			$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
			$user_id		=	$result[0]['srm_user_id'];
			$MVQ_No			=	$result[0]['srm_MVQ_no'];
			
			
			//get user gcm and device type
			$table_user		=	'users';
			$fields			=	'*';
			$condition 		=	"user_id='".$user_id."'";		
			$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
			$device_type	=	$result[0]['user_login_device']; 
			$user_gcm_id	=	$result[0]['user_gcm_id']; 
			$user_email_id	=	$result[0]['user_email_id']; 
			$user_name   	=	$result[0]['user_name']; 
			// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
			// echo'<pre>';print_r($result);exit;
			
			
			
			if($srm_status==23){
			 
				if($device_type=='Android'){   
						$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
						$pushMessage['SRM_id']			 = 	$srm_id;
						$pushMessage['status']			 = 	$srm_status;
						//In-Progress-Assigning-Engineer
						$pushMessage['message']			 = 	"In-Progress-AE";
							if (isset($user_gcm_id) && isset($pushMessage)) {		
							$gcmRegIds  = array($user_gcm_id); 
							$message = array("msg" => $pushMessage);	
							$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
							// echo'<pre>';print_r($message);exit;  
							}
						return $result;
					}
					
				
				if($device_type=='IOS'){ 
					return $result;
				}	

				
			}elseif($srm_status==25){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					//In-Progress-Ticket-cancelled
					$pushMessage['message']			 = 	"In-Progress-TC";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				
				if($device_type=='IOS'){ 
					return $result;
				}	
			
			
			
			}elseif($srm_status==26){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						
						}
					$google_feedback_link  ="https://goo.gl/forms/D1HvGtyi68EVl11l2";
					 $message = "<p>Thank you for taking service from Yapnaa, kindly share your feedback on our services in the following link :-<a href='".$google_feedback_link."' >Click me</a></p>";
					 $to=$user_email_id;
					 $subject="Yapnaa";
					$this->send_email($message,$subject,$to);	
					
					return $result;
				}
				
				if($device_type=='IOS'){ 
				    $google_feedback_link  ="https://goo.gl/forms/D1HvGtyi68EVl11l2";
					$message = "<p>Thank you for taking service from Yapnaa, kindly share your feedback on our services in the following link :-<a href='".$google_feedback_link."' >Click me</a></p>";
					$to=$user_email_id;
					$subject="Yapnaa";
					$this->send_email($message,$subject,$to);
					
					return $result;
				}	
              
			
			}elseif($srm_status==5){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					//In-Progress-Ticket-cancelled
					$pushMessage['message']			 = 	"In-Progress-TC";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				
				if($device_type=='IOS'){ 
					return $result;
				}	
			
			
			
			}elseif($srm_status==6){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						
						}
					$google_feedback_link  ="https://goo.gl/forms/D1HvGtyi68EVl11l2";
					$message = "<p>Thank you for taking service from Yapnaa, kindly share your feedback on our services in the following link :-<a href='".$google_feedback_link."' >Click me</a></p>";
					$to=$user_email_id;
					$subject="Yapnaa";
					$this->send_email($message,$subject,$to);	
					return $result;
				}
				
				if($device_type=='IOS'){ 
				    $google_feedback_link  ="https://goo.gl/forms/D1HvGtyi68EVl11l2";
					$message = "<p>Thank you for taking service from Yapnaa, kindly share your feedback on our services in the following link :-<a href='".$google_feedback_link."' >Click me</a></p>";
					$to=$user_email_id;
					$subject="Yapnaa";
					$this->send_email($message,$subject,$to);
					return $result;
				}	

			
			}elseif($srm_status==245){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-ASE-TC";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	

			
			}elseif($srm_status==246){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-ASE-Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	

			
			}else{
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	'In-Progress-Ticket has been closed';
					$pushMessage['message']			 = 	"MVQ No Generated Successfully";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	
 
			
			}
			 
			
		}
		
	}
	
	
	
	
	function srm_request_assign_engineer()
	{
		$srm_id					=	$_POST['srm_id'];
		$brand_ticket_no		=	$_POST['brand_ticket_no'];
		$se_name				=	$_POST['se_name'];
		$se_phone				=	$_POST['se_phone'];
		$se_notes				=	$_POST['se_notes'];
		$se_visiting_date		=	$_POST['se_visiting_date'];
		$priority				=	$_POST['priority'];
		$srm_SE_assigner_name	=	$_POST['srm_SE_assigner_name'];
		$srm_SE_assigner_phone	=	$_POST['srm_SE_assigner_phone'];
		$srm_status				=	$_POST['srm_status'];
		date_default_timezone_set('Asia/Kolkata');
		$se_assigned_date		=	date('Y-m-d h:i:s');
		$table					=	'SRM';
		$set_array	=	array(
							'srm_brand_ticket_no'			=>	$brand_ticket_no,	
							'srm_SE_name'					=>	$se_name,	
							'srm_SE_number'					=>	$se_phone,	
							'srm_SE_notes'					=>	$se_notes,	
							'srm_SE_visit_date'				=>	$se_visiting_date,	
							'srm_priority'					=>	$priority,
							'srm_SE_assigner_name'			=>	$srm_SE_assigner_name,
							'srm_SE_assigner_phone'			=>	$srm_SE_assigner_phone,
							'srm_status'					=>	$srm_status,
							'srm_SE_assigned_date'			=>	$se_assigned_date,
							);
							
		// echo '<pre>';print_r($set_array);	exit;				
		$condition 			=	"srm_id='".$srm_id."'";				
		$result				=	$this->model->update($table,$set_array,$condition);
		// echo '<pre>';print_r($set_array);	exit;	
		if($result){ 
			
			//get usr id
			$fields			=	'*';
			$condition 		=	"srm_id='".$srm_id."'";		
			$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
			$user_id		=	$result[0]['srm_user_id'];
			$MVQ_No			=	$result[0]['srm_MVQ_no'];
			
			
			//get user gcm and device type
			$table_user		=	'users';
			$fields			=	'*';
			$condition 		=	"user_id='".$user_id."'";		
			$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
			$device_type	=	$result[0]['user_login_device']; 
			$user_gcm_id	=	$result[0]['user_gcm_id']; 
			// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
			// echo'<pre>';print_r($result);exit;
			
			
			
			if($srm_status==244){
			
				if($device_type=='Android'){    
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-SE-Assigned";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
					
				if($device_type=='IOS'){ 
					return $result;
				}	

			}
			
			
		if($srm_status==34){
			
				if($device_type=='Android'){    
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"SE-Assigned";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
					
				if($device_type=='IOS'){ 
					return $result;
				}	

			}
			
			
			
			
			
			
		}
		
	}
	
	
	
	
	
	function srm_ticket_close()
	{
		
		$srm_id					=	$_POST['srm_id'];
		$TC_admin_name			=	$_POST['mvq_admin_name'];
		$TC_admin_phone_no		=	$_POST['mvq_admin_phone_no'];
		$TC_execative_notes		=	$_POST['close_ticket_execative_notes']; 
		$srm_status				=	$_POST['srm_status']; 
		date_default_timezone_set('Asia/Kolkata');
		$TC_generated_date		=	date('Y-m-d h:i:s'); 
		$table					=	'SRM';
		
		
		if($srm_status==246) {
			$set_array	=	array( 
								'srm_TC_execative_notes'		=>	$TC_execative_notes,	
								'srm_TC_execative_number'		=>	$TC_admin_phone_no,	
								'srm_TC_execative_name'			=>	$TC_admin_name,	
								'srm_TC_no_generated_date'		=>	$TC_generated_date,
								'srm_status'					=>	$srm_status,
								);
								
			// echo '<pre>';print_r($set_array);	exit;			
	 
			$condition 			=	"srm_id='".$srm_id."'";				
			$result				=	$this->model->update($table,$set_array,$condition);
			
			if($result){ 
				
				//get usr id
				$fields			=	'*';
				$condition 		=	"srm_id='".$srm_id."'";		
				$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
				$user_id		=	$result[0]['srm_user_id'];
				$MVQ_No			=	$result[0]['srm_MVQ_no'];
				
				
				//get user gcm and device type
				$table_user		=	'users';
				$fields			=	'*';
				$condition 		=	"user_id='".$user_id."'";		
				$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
				$device_type	=	$result[0]['user_login_device']; 
				$user_gcm_id	=	$result[0]['user_gcm_id']; 
				// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
				// echo'<pre>';print_r($result);exit;
				
				
				
				
				if($device_type=='Android'){    
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status; 
					$pushMessage['message']			 = 	"In-Progress-ASE-Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}

				
				
				
				if($device_type=='IOS'){ 
					return $result;
				}	
				
				
				
				
			}
			
		}
		
		
		
		
		if($srm_status==245) {
			$set_array	=	array( 
							'srm_take_action_E_notes'		=>	$srm_take_action_E_notes,	
							'srm_take_action_E_phone_no'	=>	$srm_take_action_E_phone_no,	
							'srm_take_action_E_name'		=>	$srm_take_action_E_name,	
							'srm_take_action_c_date'		=>	$srm_take_action_c_date,
							'srm_status'					=>	$srm_status,
							);
								
			// echo '<pre>';print_r($set_array);	exit;			
	 
			$condition 			=	"srm_id='".$srm_id."'";				
			$result				=	$this->model->update($table,$set_array,$condition);
			
			if($result){ 
				
				//get usr id
				$fields			=	'*';
				$condition 		=	"srm_id='".$srm_id."'";		
				$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
				$user_id		=	$result[0]['srm_user_id'];
				$MVQ_No			=	$result[0]['srm_MVQ_no'];
				
				
				//get user gcm and device type
				$table_user		=	'users';
				$fields			=	'*';
				$condition 		=	"user_id='".$user_id."'";		
				$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
				$device_type	=	$result[0]['user_login_device']; 
				$user_gcm_id	=	$result[0]['user_gcm_id']; 
				// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
				// echo'<pre>';print_r($result);exit;
				
				
				
				
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-ASE-TC";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	
				
				
				
			}
			
		}
		
		
		
		
		
		
		
		
		
		
		if($srm_status==35) {
			$set_array	=	array( 
							'srm_take_action_E_notes'		=>	$srm_take_action_E_notes,	
							'srm_take_action_E_phone_no'	=>	$srm_take_action_E_phone_no,	
							'srm_take_action_E_name'		=>	$srm_take_action_E_name,	
							'srm_take_action_c_date'		=>	$srm_take_action_c_date,
							'srm_status'					=>	$srm_status,
							);
								
			// echo '<pre>';print_r($set_array);	exit;			
	 
			$condition 			=	"srm_id='".$srm_id."'";				
			$result				=	$this->model->update($table,$set_array,$condition);
			
			if($result){ 
				
				//get usr id
				$fields			=	'*';
				$condition 		=	"srm_id='".$srm_id."'";		
				$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
				$user_id		=	$result[0]['srm_user_id'];
				$MVQ_No			=	$result[0]['srm_MVQ_no'];
				
				
				//get user gcm and device type
				$table_user		=	'users';
				$fields			=	'*';
				$condition 		=	"user_id='".$user_id."'";		
				$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
				$device_type	=	$result[0]['user_login_device']; 
				$user_gcm_id	=	$result[0]['user_gcm_id']; 
				// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
				// echo'<pre>';print_r($result);exit;
				
				
				
				
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"ASE-TC";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	
				
				
				
			}
			
		}
		
		
		
		
		
		if($srm_status==36) {
			$set_array	=	array( 
								'srm_TC_execative_notes'		=>	$TC_execative_notes,	
								'srm_TC_execative_number'		=>	$TC_admin_phone_no,	
								'srm_TC_execative_name'			=>	$TC_admin_name,	
								'srm_TC_no_generated_date'		=>	$TC_generated_date,
								'srm_status'					=>	$srm_status,
								);
								
			// echo '<pre>';print_r($set_array);	exit;			
	 
			$condition 			=	"srm_id='".$srm_id."'";				
			$result				=	$this->model->update($table,$set_array,$condition);
			
			if($result){ 
				
				//get usr id
				$fields			=	'*';
				$condition 		=	"srm_id='".$srm_id."'";		
				$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
				$user_id		=	$result[0]['srm_user_id'];
				$MVQ_No			=	$result[0]['srm_MVQ_no'];
				
				
				//get user gcm and device type
				$table_user		=	'users';
				$fields			=	'*';
				$condition 		=	"user_id='".$user_id."'";		
				$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
				$device_type	=	$result[0]['user_login_device']; 
				$user_gcm_id	=	$result[0]['user_gcm_id']; 
				// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
				// echo'<pre>';print_r($result);exit;
				
				
				
				
				if($device_type=='Android'){    
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status; 
					$pushMessage['message']			 = 	"ASE-Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}

				
				
				
				if($device_type=='IOS'){ 
					return $result;
				}	
				
				
				
				
			}
			
		}
		
		
		
		
		
	}
	
	
	
	
	function get_srm_que_ans_details($q_list,$a_list)
	{  
		switch($a_list){
					case 1:
							$table		=	'srm_questions';
							$fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt1,srm_question_type';
							$condition 	=	"srm_question_id='".$q_list."'";		
							$result	=	$this->model->get_Details_condition($table,$fields,$condition);
							 
					break;		
					case 2:
							$table		=	'srm_questions';
							// $fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt1,srm_question_opt2,srm_question_type';
							
							$fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt2,srm_question_type';
							$condition 	=	"srm_question_id='".$q_list."'";		
							$result	=	$this->model->get_Details_condition($table,$fields,$condition);
							
					break;
					case 3:
							$table		=	'srm_questions';
							// $fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt1,srm_question_opt2,srm_question_opt3,srm_question_type';
							
							$fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt3,srm_question_type';
							$condition 	=	"srm_question_id='".$q_list."'";		
							$result	=	$this->model->get_Details_condition($table,$fields,$condition);
							
					break;		
					case 4:
							$table		=	'srm_questions';
							// $fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt1,srm_question_opt2,srm_question_opt3,srm_question_opt4,srm_question_type';
							
							$fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt4,srm_question_type';
							$condition 	=	"srm_question_id='".$q_list."'";		
							$result	=	$this->model->get_Details_condition($table,$fields,$condition);
							
		 
		            break;
		 
		 
		}
		return $result; 
	}
	
	
	
	function get_user_phone_list($id)
	{  
		$table		=	'users'; 
		$fields		=	'*'; 		
		$result	=	$this->model->get_user_phone_list($table,$fields,$id);
		return $result; 
							
							
	}
	
	
	//Get user details
	function get_user_details($id)
	{  
		$table		=	'users';  
		$fields		=	'*';
		$condition 	=	"user_phone='".$id."'";		
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		return $result; 
							
							
	}
	
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// SRM Question list
	function user_srm_question_list($id)
    {
        $table						   	 =	'srm_questions';  
        $fields			   				 = 	'*'; 
		$condition		 				 = 	'srm_question_bp_id    ='.$id;
		$arr_log_in       				 = 	$this->model->user_srm_question_list($table, $fields, $condition);
		return $arr_log_in;
		// print_r($arr_log_in );

    }
	
	
	
			
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// SRM Question Answers
	function user_srm_question_answers($user_id,$p_id,$que,$ans)
    {
        $table	=	'SRM';  
		date_default_timezone_set('Asia/Kolkata');
		$srm_c_date 					 = 	date('Y-m-d h:i:s');
		$fields_reg = array(
					'srm_user_id' 				=> $user_id,
					'srm_questions' 			=> trim($que, ","),
					'srm_answers' 				=> trim($ans, ","),
					// 'srm_user_notes'			=> $user_srm_ans_notes,
					'srm_user_generated_date'   => $srm_c_date,
					'srm_product_id'			=> $p_id,
					'srm_c_date' 				=> $srm_c_date
				); 
				// print_r($fields_reg);exit; 
		$arr_result   = $this->model->insert($table, $fields_reg);
		return $arr_result; 

    }
	
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// SRM Question list
	function get_amc_list($id)
    {
        $table						   	 =	'amc_requests';   
		$arr_log_in       				 = 	$this->model->get_amc_list($table, $fields, $condition);
		return $arr_log_in;
		// print_r($arr_log_in );

    }
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/	

		
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// SEARCH Customer
	function get_zerob_list($action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate)
    {
		//echo $tag." == filter: ".$filter." == from: ".$fromDate." == to: ".$toDate;
		$arr_log_in       				 = 	$this->model->get_zerob_list($action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate);
		return $arr_log_in;
		// print_r($arr_log_in );

    }
	
	
	// SEARCH Customer
	function get_brand_list($filterByAttempt,$action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$filterByBrand,$yapnaaIdfm,$yapnaaIdto)
    {
		$arr_log_in=array();
		if($_GET['customer_type']==1){
			$table='livpure';
			$arr_log_in       			 = 	$this->model->get_brand_cust_list($filterByAttempt,$action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		
		}
        		
		if($_GET['customer_type']==2){
			$table='zerob_consol1';
			$arr_log_in       			 = 	$this->model->get_brand_cust_list($filterByAttempt,$action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		
		}
		
		if($_GET['customer_type']==3){
			$table='livpure_tn_kl';
			$arr_log_in       			 = 	$this->model->get_brand_cust_list($filterByAttempt,$action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		
		}
		
		if($_GET['customer_type']==4){
			$table='bluestar_b2b';
			$arr_log_in       			 = 	$this->model->get_brand_cust_list($filterByAttempt,$action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		
		}
		if($_GET['customer_type']==5){
			$table='bluestar_b2c';
			$arr_log_in       			 = 	$this->model->get_brand_cust_list($filterByAttempt,$action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		
		}
		return $arr_log_in;

    }
	
	function get_brand_list1111111($filterByAttempt,$action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$filterByBrand,$yapnaaIdfm,$yapnaaIdto)
    {
		$arr_log_in=array();
		
			$table='livpure';
		
		
		$arr_log_in       				 = 	$this->model->get_brand_cust_list($filterByAttempt,$action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		
		
		
		return $arr_log_in;
		

    }
	// SEARCH Customer
	
	 function download_zerob_list($action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate)
    {
		$tag          = $_POST['tag'];
		$filter           = $_POST['filter'];
	  $fromDate           = $_POST['fromDate'];
		$toDate           = $_POST['toDate'];
		$amc_fromDate     = $_POST['amc_fromDate'];
		$amc_toDate       = $_POST['amc_toDate'];
		$arr_log_in       				 = 	$this->model->download_zerob_list($action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate);
		$this->download_csv_results($arr_log_in,"yapnaa.csv");
		
		exit;

    } 
	// SEARCH Customer
	
	 function download_brand_list($filterByAttempt,$action_taken_by,$param,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto)
    {
		$tag          = $_POST['tag'];
		$filter           = $_POST['filter'];
	  $fromDate           = $_POST['fromDate'];
		$toDate           = $_POST['toDate'];
		$amc_fromDate     = $_POST['amc_fromDate'];
		$amc_toDate       = $_POST['amc_toDate'];
		$arr_log_in=array();
		if($_GET['customer_type']==1){
			$table='livpure';
		$arr_log_in       				 = 	$this->model->download_brand_list($filterByAttempt,$action_taken_by,$param,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		}
		if($_GET['customer_type']==2){
			$table='zerob_consol1';
		$arr_log_in       				 = 	$this->model->download_brand_list($filterByAttempt,$action_taken_by,$param,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		}
		$this->download_csv_results($arr_log_in,"yapnaa.csv");
		if($_GET['customer_type']==3){
			$table='livpure_tn_kl';
		$arr_log_in       				 = 	$this->model->download_brand_list($filterByAttempt,$action_taken_by,$param,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		}
		exit;

    } 
	function download_csv_results($results, $name = NULL)
	{
		if( ! $name)
		{
			$name = md5(uniqid() . microtime(TRUE) . mt_rand()). '.csv';
		}

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename='. $name);
		header('Pragma: no-cache');
		header("Expires: 0");

		$outstream = fopen("php://output", "w");
        
		foreach($results as $result)
		{
			fputcsv($outstream, $result);
		}

		fclose($outstream);
	}
	
		
/*----------------------------------------------------------------------------------------------------------------------*/			
	function add_banner()
	{ 
		$table_name  	  		=	 'banner_images';
		$banner_title			=	($_POST['banner_title']);
		$banner_created_by		=	($_POST['banner_created_by']); 
		$banner_priority		=	($_POST['banner_priority']); 
		$banner_for				=	($_POST['banner_for']); 
		$banner_screens_for		=	($_POST['banner_screens_for']); 
		$banner_url = ($_POST['banner_url']);
		
		$fields		    	= 	 'banner_title';
		$condition		  	= 	 'banner_title    = ' . "'" . $banner_title . "'";
		$arr_result		 	= 	 $this->model->get_Details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		
		if(empty($arr_result)){ 
			//Main category file to move in to folder
			if(!empty($_FILES['banner_image']['tmp_name']))
			{  
				$filename = basename($_FILES['banner_image']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1); 
				$target = "../../banner-images/"; 
				//Determine the path to which we want to save this file
				$now = new DateTime();
				$times = $now->getTimestamp();
				$newname = $target.$times.$mc_title.'.'.$ext;  	
				// $newname = $target.$mc_title.'.'.$ext;   
				// $newname = $target.$times.$mc_title.'.'.$ext;   
				//Check if the file with the same name is already exists on the server
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['banner_image']['tmp_name'],$newname))) {
						$banner_image	=	$times.$mc_title.'.'.$ext;
					}else{
						$message	=	"Could not move the file!";
					}
				}
				
			}
			 
			$arr_input	=	array(
							'banner_title'					=>	$banner_title,
							'banner_img'					=>	$banner_image, 
							'banner_c_date'					=>	$this->date, 
							'banner_priority'				=>	$banner_priority,
							'banner_status'					=>	1,
							'banner_for'					=>	$banner_for,
							'banner_screens_for'			=>	$banner_screens_for,
							'banner_url'                    =>	$banner_url
							);
			// echo'<pre>';print_r($arr_input);exit;
			$result				=	$this->model->insert($table_name,$arr_input);
			return $result=1;
		}else{
			return $result=2;
		}
	}

	function add_banner_edit($banner_id)
	{ 
		$table_name  	  		=	 'banner_images';
		$banner_title			=	($_POST['banner_title']);
		$banner_created_by		=	($_POST['banner_created_by']); 
		$banner_priority		=	($_POST['banner_priority']); 
		$banner_for				=	($_POST['banner_for']); 
		$banner_screens_for		=	($_POST['banner_screens_for']); 
		$banner_url = ($_POST['banner_url']);
		/*
		$fields		    	= 	 'banner_title';
		$condition		  	= 	 'banner_title    = ' . "'" . $banner_title . "'";
		$arr_result		 	= 	 $this->model->get_Details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		*/
		//if(empty($arr_result)){ 
			//Main category file to move in to folder
			if(!empty($_FILES['banner_image']['tmp_name']))
			{  
				$filename = basename($_FILES['banner_image']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1); 
				$target = "../../banner-images/"; 
				//Determine the path to which we want to save this file
				$now = new DateTime();
				$times = $now->getTimestamp();
				$newname = $target.$times.$mc_title.'.'.$ext;  	
				// $newname = $target.$mc_title.'.'.$ext;   
				// $newname = $target.$times.$mc_title.'.'.$ext;   
				//Check if the file with the same name is already exists on the server
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['banner_image']['tmp_name'],$newname))) {
						$banner_image	=	$times.$mc_title.'.'.$ext;
					}else{
						$message	=	"Could not move the file!";
					}
				}
				
			}
			if(!empty($_FILES['banner_image']['tmp_name']))
			{   
					$arr_input	=	array(
							'banner_title'					=>	$banner_title,
							'banner_img'					=>	$banner_image, 
							'banner_c_date'					=>	$this->date, 
							'banner_priority'				=>	$banner_priority,
							'banner_status'					=>	1,
							'banner_for'					=>	$banner_for,
							'banner_screens_for'			=>	$banner_screens_for,
							'banner_url'                    =>	$banner_url
							);
			}else{
				$arr_input	=	array(
							'banner_title'					=>	$banner_title,
							'banner_c_date'					=>	$this->date, 
							'banner_priority'				=>	$banner_priority,
							'banner_status'					=>	1,
							'banner_for'					=>	$banner_for,
							'banner_screens_for'			=>	$banner_screens_for,
							'banner_url'                    =>	$banner_url
							);
			}
			// echo'<pre>';print_r($arr_input);exit;
			//$result				=	$this->model->insert($table_name,$arr_input);
			$condition 	=	"banner_id	='".$banner_id."'";				
			$result		=	$this->model->update($table_name,$arr_input,$condition);
			return $result=1;
		//}else{
			//return $result=2;
		//}
	}
	

/*----------------------------------------------------------------------------------------------------------------------*/	

	function get_banner_by_id($bid)
	{
		$table_name =	 'banner_images';
		$fields     =	 "*"; 
		$id    		=	 $bid;  
		$arr_result	= 	 $this->model->get_details_by_id($table_name,$fields,$id);
		// print_r($arr_result_test);exit;
		return $arr_result;
	}
	
	
/*----------------------------------------------------------------------------------------------------------------------*/	

		function get_banner_list()
	{
		$table_name  	  	=	 'banner_images';
		$fields     		=	 "*"; 
		$orderby    		=	 "banner_priority";  
		$arr_result			= 	 $this->model->get_details_orderby($table_name,$fields,$orderby);
		// print_r($arr_result_test);exit;
		return $arr_result;
	}
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/	


	/* deactive_banner update*/
	function deactive_banner()
	{
		$table_name  	  	=	 'banner_images';
		$banner_id			=	$_POST['id']; 
		$set_array			=	array(
									'banner_status'		=> 	0
								);
		// print_r($set_array);exit;
		$condition 	=	"banner_id	='".$banner_id."'";				
		$result		=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/	
	
	
	/* activate_banner update*/
	function activate_banner()
	{
		$table_name  	  	=	 'banner_images';
		$banner_id			=	$_POST['id']; 
		$set_array			=	array(
									'banner_status'		=> 1
								);
		// print_r($set_array);exit;
		$condition 	=	"banner_id	='".$banner_id."'";				
		$result		=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
/*----------------------------------------------------------------------------------------------------------------------*/	
	
	
	/* Edit update*/
	function edit_banner()
	{
		$table_name  	  	=	 'banner_images';
		$banner_id			=	$_POST['id']; 
		$set_array			=	array(
									'banner_status'		=> 1
								);
		// print_r($set_array);exit;
		$condition 	=	"banner_id	='".$banner_id."'";				
		$result		=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
		
		
/*----------------------------------------------------------------------------------------------------------------------*/	

	
	/*Delete the delete_banner*/
	function delete_banner()
	{
		$table_name  	  	=	 'banner_images';
		$banner_id			=	$_POST['id']; 
		$banner_img			=	$_POST['banner_img']; 
		$target 			= 	"../../view/images/banner-images/".$_POST['banner_img'];
		unlink($mc_image);
		$condition			=	"banner_id='$banner_id'";
		$res				=	$this->model->delete_row_data($table_name,$condition);
		return $res;;
	}
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/	

	
	
	
	/*Add the add_amc_price*/
	function add_amc_price()
	{
		date_default_timezone_set('Asia/Kolkata');
		$brdnadid						=	$_POST['brdnadid'];
		$brand_product_name				=	$_POST['brand_product_name'];
		$pname							=	$_POST['pname'];
		$servicecharge					=	$_POST['servicecharge'];
		$amccost						=	$_POST['amccost'];
		$acmccost						=	$_POST['acmccost']; 
		$table							=	'amc_price_list';
		
	  
		$arr_input	=	array(
						'amc_price_brand_id'				=>	$brdnadid,
						'amc_price_brand_name'				=>	$brand_product_name,
						'amc_price_p_name'					=>	$pname,
						'amc_price_service_charge'			=>	$servicecharge,
						'amc_price_amc_cost'				=>	$amccost,
						'amc_price_acmc_cost'				=>	$acmccost,
						'amc_pricelist_status'				=>	1  
						);
		// echo'<pre>';print_r($arr_input);exit;
		$result		=	$this->model->insert($table,$arr_input);
		return $result;
		
		
		 
		
	}
	
	
	
	
				
	//Get get_amc_price_list 
	function get_amc_price_list()
	{
		$table		=	'amc_price_list';
		$result	=	$this->model->get_amc_price_list($table);
		return $result;
	}

	
	
	
	
	
	
	/* deactive_amc_price update*/
	function deactive_amc_price()
	{
		$table			=	'amc_price_list';
		$amc_price_id	=	$_POST['id']; 
		$set_array		=	array(
							'amc_pricelist_status'=> 0
							);
		$condition 		=	"amc_price_id='".$amc_price_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	/* active_amc_price update*/
	function active_amc_price()
	{
		$table			=	'amc_price_list';
		$amc_price_id	=	$_POST['id']; 
		$set_array		=	array(
							'amc_pricelist_status'=> 1
							);
		$condition 		=	"amc_price_id='".$amc_price_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
		/*Delete the del_amc_price*/
	function del_amc_price()
	{
		$table			=	'amc_price_list';
		$amc_price_id	=	$_POST['id'];
		$condition		=	"amc_price_id='$amc_price_id'";
		$res			=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/	

	
	
	
	/*Add the add_apk_version*/
	function add_apk_version()
	{ 
		$v_name							=	$_POST['v_name'];  
		$table							=	'apk_version';
		
		$set_array		=	array(
							'apk_version_status'=> 0
							);
		$condition 		=	"apk_version_status=0 or apk_version_status=1";				
		$result			=	$this->model->update($table,$set_array,$condition);
		
		if($result){
			$arr_input	=	array(	
							'apk_version_name'					=>	$v_name, 
							'apk_version_status'				=>	1  
							);
			// echo'<pre>';print_r($arr_input);exit;
			$result		=	$this->model->insert($table,$arr_input);
			return $result;
			
		}
		 
		
	}
	
	
	
	
	
	/*Add the add_apk_version*/
	function get_apk_version()
	{   
		$table		=	'apk_version';
		$fields		=	'*';
		$orderby	=	'apk_version_id';
		$result		=	$this->model->get_details_orderby_desc($table,$fields,$orderby);
		return $result;
			
		 
	}
	
	
	
	
	
	
	
	
	
	/* deactive_apk_version update*/
	function deactive_apk_version()
	{
		$table			=	'apk_version';
		$apk_version_id	=	$_POST['id']; 
		$set_array		=	array(
							'apk_version_status'=> 0
							);
		$condition 		=	"apk_version_id='".$apk_version_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	/* active_apk_version update*/
	function active_apk_version()
	{
		$table			=	'apk_version';
		$apk_version_id	=	$_POST['id']; 
		$set_array		=	array(
							'apk_version_status'=> 1
							);
		$condition 		=	"apk_version_id='".$apk_version_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
		/*Delete the del_apk_version*/
	function del_apk_version()
	{
		$table			=	'apk_version';
		$apk_version_id	=	$_POST['id'];
		$condition		=	"apk_version_id='$apk_version_id'";
		$res			=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	
	
	//send sms
	function send_sms()
	{
		$table			=	'apk_version';
		$apk_version_id	=	$_POST['id'];
		$condition		=	"apk_version_id='$apk_version_id'";
		$res			=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/	

		
	
	// GCM Notification to user
	function sendMessageThroughGCM($gcmRegIds, $message) { 
		//Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $gcmRegIds,
            'data' => $message
        );
		// echo '<pre>';print_r($fields);exit;	
		// Update your Google Cloud Messaging API Key 
		define("GOOGLE_API_KEY", "AIzaSyAInPAdZ7X6YThaHkkQvWhWp3c8qePWOtI"); 	//user server key
	


        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);				
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
		// print_r($result);  exit;
        curl_close($ch);
        return $result ;
    }
	
	function send_email($text,$subject,$to){
		$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!--<![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  
	     <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <!--[if (gte mso 9)|(IE)]>
      <style type="text/css">
         table {border-collapse: collapse !important;}
      </style>
      <![endif]-->
   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
   

   
   
   
   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
      <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
            <tr>
               <td width="100%">
                  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
                     <!--[if (gte mso 9)|(IE)]>
                     <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
                        <tr>
                           <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                              <![endif]--> 
                              <!-- ======= start main body ======= -->
                              <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
                                 <tr>
                                    <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                                       <!-- ======= start header ======= -->
                                       <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
                                          <tr>
                                             <td>
                                                <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                   <tbody>
                                                      <tr>
                                                         <td align="center">
                                                            <center>
                                                               <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
                                                                  <tbody>
                                                                     <tr>
                                                                        <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
                                                                           <!-- ======= start header ======= -->
                                                                           <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                              <tr>
                                                                                 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
                                                                                    <!--[if (gte mso 9)|(IE)]>
                                                                                    <table width="100%" style="border-spacing:0" >
                                                                                       <tr>
                                                                                          <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
                                                                                                <table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
                                                                                                   <tr>
                                                                                                      <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="https://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
                                                                                                   </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                          <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
                                                                                                <table width="100%" style="border-spacing:0" bgcolor="#ffffff">
                                                                                                   <tr>
                                                                                                      <td>
                                                                                                         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
                                                                                                            <tr>
                                                                                                               <td height="20">&nbsp;</td>
                                                                                                            </tr>
                                                                                                         </table>
                                                                                                      </td>
                                                                                                   </tr>
                                                                                                  <tr>
                            <td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
                                <tbody><tr>
                                  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="https://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                        <td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                        <td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="https://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                     <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                      </tr>
                                    </tbody></table></td>
                                </tr>
                              </tbody></table></td>
                          </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                       </tr>
                                                                                    </table>
                                                                                    <![endif]-->
                                                                                 </td>
                                                                              </tr>
                                                                              <tr >
                                                                                 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                                                    <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                                                       <tr>
                                                                                          <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                                                       </tr>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                              <tr>
                                                                              </tr>
                                                                           </table>
                                                                        </td>
                                                                     </tr>
                                                                  </tbody>
                                                               </table>
                                                            </center>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end header ======= --> 
                                       <!-- ======= start hero article ======= -->
                                       <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="" style="padding-bottom:2%; padding-top:2%;">
                                                
												<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>'.$text.'</b></p>
                                                <!-- START BUTTON -->
                                                <!-- END BUTTON -->
                                             </td>
                                          </tr>
                                       </table>
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end hero article ======= --> 
                                       <center >
                                          <table bgcolor="#FFFFFF" width="100%">
                                             <tr>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td> <a href="https://yapnaa.com"><img src="https://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></a></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> yapnaa.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td><a href="https://info@yapnaa.com"><img src="https://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></a></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> info@yapnaa.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td><img src="https://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b>  +91 98452 856419</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                             </tr>
                                          </table>
                                       </center>
                                       <!-- ======= start divider ======= -->
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end divider ======= --> 

                                    </td>
                                 </tr>
                              </table>
                              <!--[if (gte mso 9)|(IE)]>
                           </td>
                        </tr>
                     </table>
                     <![endif]--> 
					 
					 
					                                        <!-- ======= start footer ======= -->
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
                                                   <tr>
                                                      <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Networks Pvt. Ltd</b></font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After Sales Companion</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                  
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end footer ======= -->
                  </div>
               </td>
            </tr>
         </table>
      </center>
   </body>
</html>

			';
			
		$headers 				= 'MIME-Version: 1.0'. "\r\n";
		$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
		$headers 			.= 'From: Yapnaa Admin <info@yapnaa.com>'. "\r\n";
		//$headers            .= 'Cc: ranjan.jjbyte@gmail.com ' . "\r\n";
		//echo $subject;die;
		// Mail it
		mail($to, $subject, $message,$headers);
		
	}
	function send_schedulecapaign_email($text,$subject,$to,$brand_img){
		 echo "tt";
		$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!--<![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  
	     <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <!--[if (gte mso 9)|(IE)]>
      <style type="text/css">
         table {border-collapse: collapse !important;}
      </style>
      <![endif]-->
   
   

   
   
   
   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
      <span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">*|MC_PREVIEW_TEXT|*</span>
	  
	  <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
            <tr>
               <td width="100%">
                  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
                     <!--[if (gte mso 9)|(IE)]>
                     <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
                        <tr>
                           <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                              <![endif]--> 
                              <!-- ======= start main body ======= -->
                              <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
                                 <tr>
                                    <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                                       <!-- ======= start header ======= -->
                                       <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
                                          <tr>
                                             <td>
                                                <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                   <tbody>
                                                      <tr>
                                                         <td align="center">
                                                            <center>
                                                               <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
                                                                  <tbody>
                                                                     <tr>
                                                                        <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
                                                                           <!-- ======= start header ======= -->
                                                                           <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                              <tr>
                                                                                 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
                                                                                    <!--[if (gte mso 9)|(IE)]>
                                                                                    <table width="100%" style="border-spacing:0" >
                                                                                       <tr>
                                                                                          <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
																							  <div class="row">
                                                                                             <div class="column" style="width:100%;max-width:170px;display:inline-block;vertical-align:top;">
                                                                                                 <table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
                                                                                                   <tr>
                                                                                                      <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="https://yapnaa.com/images/yapnaa-new-logo.png"  alt="" style="border-width:0; max-width:170px;height:auto; display:block" /></a></td>
                            
							
																								   </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                          <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
                                                                                                <table width="100%" style="border-spacing:0" bgcolor="#ffffff">
                                                                                                   <tr>
                                                                                                      <td>
                                                                                                         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
                                                                                                            <tr>
                                                                                                               <td height="20">&nbsp;</td>
                                                                                                            </tr>
                                                                                                         </table>
                                                                                                      </td>
                                                                                                   </tr>
                                                                                                  <tr>
                            <td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
                                <tbody><tr>
                                  <td width="100%" align="center" valign="top" >
								  <img src="https://yapnaa.com/images/livpure-logo.png"  alt="" style="border-width:0; max-width:170px;height:auto; display:block" />
								  </td>
                                </tr>
                              </tbody></table></td>
                          </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                       </tr>
                                                                                    </table>
                                                                                    <![endif]-->
                                                                                 </td>
                                                                              </tr>
                                                                              <tr >
                                                                                 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                                                    <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                                                       <tr>
                                                                                          <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                                                       </tr>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                              <tr>
                                                                              </tr>
                                                                           </table>
                                                                        </td>
                                                                     </tr>
                                                                  </tbody>
                                                               </table>
                                                            </center>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end header ======= --> 
                                       <!-- ======= start hero article ======= -->
                                       <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="" style="padding-bottom:2%; padding-top:2%;">
                                                
												<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>'.$text.'</b></p>
                                                <!-- START BUTTON -->
                                                <!-- END BUTTON -->
                                             </td>
                                          </tr>
                                       </table>
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end hero article ======= --> 
                                       <center >
                                          <table bgcolor="#FFFFFF" width="100%">
                                             <tr>
											 
											 <td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
												<td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>

											 
											 <td>
                                                   <table>
                                                      <tr>
                                                         <td><a href="https://info@yapnaa.com"><img src="https://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></a></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> info@yapnaa.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
												<td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
												<td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td> <a href="https://yapnaa.com"><img src="https://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></a></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b>yapnaa.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
												<td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>

                                                <td>
												<table width="150" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td width="32" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="https://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="30" height="30" border="0" style="border-width:0; max-width:30px;height:auto; display:block; max-height:30px"></a></td>
                                        <td width="32" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="30" height="30" border="0" style="border-width:0; max-width:30px;height:auto; display:block; max-height:30px"></a></td>
                                        <td width="32" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="https://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="30" height="30" border="0" style="border-width:0; max-width:30px;height:auto; display:block; max-height:30px"></a></td>
                                     <td width="32" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="30" height="30" border="0" style="border-width:0; max-width:30px;height:auto; display:block; max-height:30px"></a></td>
                                      </tr>
                                    </tbody></table>
                                                   <!--table>
                                                      <tr>
                                                         <td><img src="https://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b>  +91 98452 856419</b></p>
                                                         </td>
                                                      </tr>
                                                   </table-->
                                                </td>
                                             </tr>
                                          </table>
                                       </center>
                                       <!-- ======= start divider ======= -->
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end divider ======= --> 

                                    </td>
                                 </tr>
                              </table>
                              <!--[if (gte mso 9)|(IE)]>
                           </td>
                        </tr>
                     </table>
                     <![endif]--> 
					 
					 
					                                        <!-- ======= start footer ======= -->
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
                                                   <tr>
                                                      <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright © 2018</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Networks Pvt. Ltd</b></font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After Sales Companion</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                  
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end footer ======= -->
                  </div>
               </td>
            </tr>
         </table>
      </center>
   </body>
</html>

			';
		  $headers .= "MIME-Version: 1.0" . "\r\n";
		  $headers .= "Content-type: text/html; charset=iso-8859-1" . "\r\n";
		  $headers .= "X-Priority: 3" . "\r\n";
		  $headers .= "X-Mailer: PHP". phpversion() ."\r\n" ;
		
		  $headers .= "Reply-To: Yapnaa  <info@yapnaa.com>" . "\r\n";  
		  $headers .= "Return-Path: Yapnaa  <info@yapnaa.com>" . "\r\n"; 
		  $headers .= "From: Yapnaa  <info@yapnaa.com>" . "\r\n";
  
		  $headers .= "Organization: Yapnaa" . "\r\n";
		  
		//echo $subject;die;
		// Mail it
		mail($to, $subject, $message,$headers);
		
	}
	function send_email111($subject,$to,$customerid,$customername,$number){
		$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!--<![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  
	     <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <!--[if (gte mso 9)|(IE)]>
      <style type="text/css">
         table {border-collapse: collapse !important;}
      </style>
      <![endif]-->
   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
   

   <style>
   td img{
    display: block;
    margin-left: auto;
    margin-right: auto;

}
   </style>
   
   
   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
      <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
            <tr>
               <td width="100%">
                  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
                     <!--[if (gte mso 9)|(IE)]>
                     <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
                        <tr>
                           <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                              <![endif]--> 
                              <!-- ======= start main body ======= -->
                              <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
                                 <tr>
                                    <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                                       <!-- ======= start header ======= -->
                                       <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
                                          <tr>
                                             <td>
                                                <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                   <tbody>
                                                      <tr>
                                                         <td align="center">
                                                            <center>
                                                               <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
                                                                  <tbody>
                                                                     <tr>
                                                                        <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
                                                                           <!-- ======= start header ======= -->
                                                                           <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                              <tr>
                                                                                 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
                                                                                    <!--[if (gte mso 9)|(IE)]>
                                                                                    <table width="100%" style="border-spacing:0" >
                                                                                       <tr>
                                                                                          <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
                                                                                                <table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
                                                                                                   <tr>
																								   <td></td>
                                                                                                      <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="center"><a href="#" target="_blank"><img src="https://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
                                                               <td></td>                                    </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                            
                                                                                 </td>
                                                                              </tr>
                                                                              <tr >
                                                                                 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                                                    <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                                                       <tr>
                                                                                          <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                                                       </tr>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                              <tr>
                                                                              </tr>
                                                                           </table>
                                                                        </td>
                                                                     </tr>
                                                                  </tbody>
                                                               </table>
                                                            </center>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end header ======= --> 
                                       <!-- ======= start hero article ======= -->
                                       <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td  style="text-align:center;"> 
                                                
												
												<p style="text-align:center;color:#666666; font-size:21px;  font-family: "Montserrat", sans-serif;""><b>'.$subject.'</b></p>
												
                                               
                                             </td>
                                          </tr>
										  <tr><td style="padding-bottom:2%; padding-top:2%;">
										  
											<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;""><b>ID:'.$customerid.'</b></p>
											<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;""><b>Name:'.$customername.'</b></p>
											<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;""><b>Number:'.$number.'</b></p>
										   <!-- START BUTTON -->
                                                <!-- END BUTTON -->
										  </td></tr>
                                       </table>
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end hero article ======= --> 
                                      
   </body>
</html>
			';
			
		$headers 				= 'MIME-Version: 1.0'. "\r\n";
		$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
		$headers 			.= 'From: Yapnaa Admin <info@yapnaa.com>'. "\r\n";
		//$headers            .= 'Cc: ranjan.jjbyte@gmail.com ' . "\r\n";  
		//echo $subject;die;
		// Mail it
		//$message=json_encode($message); 
		
		mail($to, $subject, $message,$headers);
		
	}
	
	function sendmail_phpmailer($text,$subject,$email,$brand_img)
	{ 
		//Create a new PHPMailer instance
    $mail = new PHPMailer;   
    //$mail->isSMTP();
// change this to 0 if the site is going live
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com'; 
    $mail->Port = 587; 
    $mail->SMTPSecure = 'tls';

 //use SMTP authentication
    $mail->SMTPAuth = true;
//Username to use for SMTP authentication
    $mail->Username = "info@yapnaa.com";
    $mail->Password = "vineet123";
    $mail->setFrom('info@yapnaa.com', 'Yapnaa');
    $mail->addReplyTo('info@yapnaa.com', 'Yapnaa');
    $mail->addAddress($email);
    $mail->Subject = $subject;
    // $message is gotten from the form
	
	$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!--<![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  
	     <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <!--[if (gte mso 9)|(IE)]>
      <style type="text/css">
         table {border-collapse: collapse !important;}
      </style>
      <![endif]-->
   
   

   
   
   
   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
      <span class="mcnPreviewText" style="display:none; font-size:0px; line-height:0px; max-height:0px; max-width:0px; opacity:0; overflow:hidden; visibility:hidden; mso-hide:all;">*|MC_PREVIEW_TEXT|*</span>
	  
	  <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
            <tr>
               <td width="100%">
                  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
                     <!--[if (gte mso 9)|(IE)]>
                     <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
                        <tr>
                           <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                              <![endif]--> 
                              <!-- ======= start main body ======= -->
                              <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
                                 <tr>
                                    <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                                       <!-- ======= start header ======= -->
                                       <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
                                          <tr>
                                             <td>
                                                <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                   <tbody>
                                                      <tr>
                                                         <td align="center">
                                                            <center>
                                                               <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
                                                                  <tbody>
                                                                     <tr>
                                                                        <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
                                                                           <!-- ======= start header ======= -->
                                                                           <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                              <tr>
                                                                                 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
                                                                                    <!--[if (gte mso 9)|(IE)]>
                                                                                    <table width="100%" style="border-spacing:0" >
                                                                                       <tr>
                                                                                          <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
																							  <div class="row">
                                                                                             <div class="column" style="width:100%;max-width:170px;display:inline-block;vertical-align:top;">
                                                                                                 <table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
                                                                                                   <tr>
                                                                                                      <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="https://yapnaa.com/images/yapnaa-new-logo.png"  alt="" style="border-width:0; max-width:170px;height:auto; display:block" /></a></td>
                            
							
																								   </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                          <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
                                                                                                <table width="100%" style="border-spacing:0" bgcolor="#ffffff">
                                                                                                   <tr>
                                                                                                      <td>
                                                                                                         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
                                                                                                            <tr>
                                                                                                               <td height="20">&nbsp;</td>
                                                                                                            </tr>
                                                                                                         </table>
                                                                                                      </td>
                                                                                                   </tr>
                                                                                                  <tr>
                            <td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
                                <tbody><tr>
                                  <td width="100%" align="center" valign="top" >
								  <img src="https://yapnaa.com/images/livpure-logo.png"  alt="" style="border-width:0; max-width:170px;height:auto; display:block" />
								  </td> 
                                </tr>
                              </tbody></table></td>
                          </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                       </tr>
                                                                                    </table>
                                                                                    <![endif]-->
                                                                                 </td>
                                                                              </tr>
                                                                              <tr >
                                                                                 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                                                    <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                                                       <tr>
                                                                                          <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                                                       </tr>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                              <tr>
                                                                              </tr>
                                                                           </table>
                                                                        </td>
                                                                     </tr>
                                                                  </tbody>
                                                               </table>
                                                            </center>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end header ======= --> 
                                       <!-- ======= start hero article ======= -->
                                       <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="" style="padding-bottom:2%; padding-top:2%;">
                                                
												<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>'.$text.'</b></p>
                                                <!-- START BUTTON -->
                                                <!-- END BUTTON -->
                                             </td>
                                          </tr>
                                       </table>
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end hero article ======= --> 
                                       <center >
                                          <table bgcolor="#FFFFFF" width="100%">
                                             <tr>
											 
											 <td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
												<td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>

											 
											 <td>
                                                   <table>
                                                      <tr>
                                                         <td><a href="https://info@yapnaa.com"><img src="https://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></a></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> info@yapnaa.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
												<td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
												<td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td> <a href="https://yapnaa.com"><img src="https://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></a></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b>yapnaa.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
												<td>
                                                   <table>
                                                      <tr>
                                                         <td> </td>
                                                         <td>
                                                           
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>

                                                <td>
												<table width="150" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td width="32" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="https://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="30" height="30" border="0" style="border-width:0; max-width:30px;height:auto; display:block; max-height:30px"></a></td>
                                        <td width="32" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="30" height="30" border="0" style="border-width:0; max-width:30px;height:auto; display:block; max-height:30px"></a></td>
                                        <td width="32" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="https://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="30" height="30" border="0" style="border-width:0; max-width:30px;height:auto; display:block; max-height:30px"></a></td>
                                     <td width="32" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="https://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="30" height="30" border="0" style="border-width:0; max-width:30px;height:auto; display:block; max-height:30px"></a></td>
                                      </tr>
                                    </tbody></table>
                                                   <!--table>
                                                      <tr>
                                                         <td><img src="https://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b>  +91 98452 856419</b></p>
                                                         </td>
                                                      </tr>
                                                   </table-->
                                                </td>
                                             </tr>
                                          </table>
                                       </center>
                                       <!-- ======= start divider ======= -->
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end divider ======= --> 

                                    </td>
                                 </tr>
                              </table>
                              <!--[if (gte mso 9)|(IE)]>
                           </td>
                        </tr>
                     </table>
                     <![endif]--> 
					 
					 
					                                        <!-- ======= start footer ======= -->
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
                                                   <tr>
                                                      <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright © 2018</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Networks Pvt. Ltd</b></font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After Sales Companion</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                  
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end footer ======= -->
                  </div>
               </td>
            </tr>
         </table>
      </center>
   </body>
</html>

			';
	$filteredmessage = "This is the yapnaamessage";
    $mail->msgHTML($message);
	$mail->AltBody = $filteredmessage;
    if (!$mail->send()) {
        echo "We are extremely sorry to inform you that your message
could not be delivered,please try again.";
    } else {
        echo "Your message was successfully delivered,you would be contacted shortly.";
        }
	}
	
	
	
	
	/* By Suman */
	
	function get_city_from_brand(){
		$sql 		=	"SELECT DISTINCT CUSTOMER_AREA FROM  `livpure` ";
		$result		=	$this->model->data_query($sql);	
		return $result;
	}
	
	function getDataFromMasterTableByCondition($brandname,$total,$status){
		$result		= $this->model->getDataFromMasterTableByCondition($brandname,$total,$status);
		if($result){
			return $result;
		}else{
			return array();
		}	
	}	
	
	
	/* function setCustomerListToTable($value,$value1){
		$table		= 'daily_call_schedule_2';
		$arr_input	= array(
							'brandname'				=> $value['brandname'],
							'admin_id'				=> $value['admin_id'],
							'customer_id'			=> $value1['id'],
							'status'				=> 0,  
							'created_date'			=> date('Y-m-d H:i:s'),
							'updated_date'			=> date('Y-m-d H:i:s'),
							'tag'					=> $value1['tag']	
						);
		//echo "<br><pre>"; print_r($arr_input); die;				
		$result		=	$this->model->insert($table,$arr_input);
		return $result;
	} */
	
	function setCustomerListToTable($value,$get_customer_list){
		$table		= 'daily_call_schedule_2';
		foreach($get_customer_list as $key1 => $value1){
			$arr_input	= array(
							'brandname'				=> $value['brandname'],
							'admin_id'				=> $value['admin_id'],
							'customer_id'			=> $value1['id'],
							'status'				=> 0,  
							'created_date'			=> date('Y-m-d H:i:s'),
							'updated_date'			=> date('Y-m-d H:i:s'),
							'tag'					=> $value1['tag']	
						);
						
			//echo "<br><pre>";print_r($arr_input);die;		
			$result		=	$this->model->insert($table,$arr_input);			
		}
		return $result;
	}
	
	
	function get_brand_name($admin_id){
		$result		= $this->model->get_brand_name($admin_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	function get_amc_list_from_brand_and_call($search,$fromDate,$toDate,$admin_id,$join_table_name){
		$result		= $this->model->get_amc_list_from_brand_and_call($search,$fromDate,$toDate,$admin_id,$join_table_name);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	function get_filtered_amc_list_from_brand_and_call($search,$fromDate,$toDate,$admin_id,$join_table_name){
		$result		= $this->model->get_filtered_amc_list_from_brand_and_call($search,$fromDate,$toDate,$admin_id,$join_table_name);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	
	function getQA($customer_type,$user_id){
		switch($_GET['customer_type']){
			case 1:
			$brand	='livpure';
			break;
			case 2:
			$brand	='zerob_consol1';
			break;
			case 3:
			$brand	='livpure_tn_kl';
			break;
			case 4:
			$brand	='bluestar_b2b';
			break;
			case 5:
			$brand	='bluestar_b2c';
			break;
		}
		
		$result 	= $this->model->get_q_a($brand,$user_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	
	function insertQA($data1,$insert_data,$sql,$user_phone){
		$result		= $this->model->insert_data_query($data1,$insert_data,$sql,$user_phone);
		return $result; 
	}
	
	function updateQA($data1,$insert_data,$user_id){
		$result		= $this->model->update_data_query($data1,$insert_data,$user_id);
		return $result; 
	}
	
	function updateStatusInBrand($table,$update_data,$brand_customer_id,$user_id){
		$condition		= "id = '".$user_id."' AND CUSTOMERID = '".$brand_customer_id."'";			   
		$result 		= $this->model->update($table,$update_data,$condition);
		return $result; 
	}
	
	function updateProfileInBrand($table,$update_data,$brand_customer_id,$user_id){
		$condition		= "id = '".$user_id."' AND CUSTOMERID = '".$brand_customer_id."'";			   
		$result 		= $this->model->update($table,$update_data,$condition);
		return $result; 
	}
	
	function getQAdata($brand_customer_id,$user_phone){
		$result				= $this->model->get_qa_data($brand_customer_id,$user_phone);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	function get_qa_ids_of_customer($customer_type,$user_id){
		$result 			= $this->model->get_qa_ids_of_customer($customer_type,$user_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	function get_brand_details_of_customer($customer_type,$user_id){
		$result 			= $this->model->get_brand_details_of_customer($customer_type,$user_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	// Delete Question and Answer Data by Userid
	function delete_QA_data_by_userid($customer_type,$user_id){
		$result 			= $this->model->delete_QA_data_by_userid($customer_type,$user_id);
		return $result;
	}
		
	// Update AMC Status 
	function updateAmcData($table,$admin_id,$start,$expire,$userid,$comments,$closedBy,$transaction_status){
		$admin_name				= 	$_SESSION['admin_name'];
		$ar_id  	       	 	= 	$_SESSION['ar_id'];
		
		if($expire !=NULL && $start !=NULL ){
			$set_array			= 	array(
										'amc_updated_by'		=> $admin_id,
										'CONTRACT_TO'		    => $expire,
										'CONTRACT_FROM'		    => $start,
										'CONTRACT_BY'		    => $closedBy,
										'last_call_comment'	    => $comments,
										'action_taken_by'	    => $admin_name,
										'action_taken_by_id'    => $ar_id,
										'status'			    => "7",
										'transaction_status'	=> $transaction_status,
										'updated_on'			=> date('Y-m-d')
									);
		}
		
		else{
			$set_array			=	array(
										'amc_updated_by'		=> $admin_id,
										'CONTRACT_BY'		    => $closedBy,
										'last_call_comment'	    => $comments,
										'action_taken_by'	    => $admin_name,
										'action_taken_by_id'    => $ar_id,
										'status'			    =>	"0",
										'transaction_status'	=> $transaction_status,
										'updated_on'			=> date('Y-m-d')
									);	
		}
		
		$condition 				= 	"id='".$userid."'";				
		$update_zerob_result	= 	$this->model->update($table,$set_array,$condition);
		
		return 1;	
	}
	
	
	function updateCustomerCommentInBrand($table,$update_data,$brand_customer_id,$user_id){
		$condition		= "id = '".$user_id."' ";			   
		$result 		= $this->model->update($table,$update_data,$condition);
		return $result; 
	}
	
	
	/* LIFE CYCLE PROCESS STARTS HERE */
	
	// Transaction Lifecycle
	function transaction_lifecycle($customer_type){
		switch($customer_type){
			case 1:
		    $table			= 'livpure';
			$titlename1		= 'Livpure';
			$brand_img		= "logo_livpure_yapnaa.png";
            break;
			
			case 2:
		    $table			= 'zerob_consol1';
			$titlename1		= 'Zero B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;	

			case 3:
		    $table			= 'livpure_tn_kl';
			$titlename1		= 'Livpure TN';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 4:
		    $table			= 'bluestar_b2b';
			$titlename1		= 'Bluestar B2B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 5:
		    $table			= 'bluestar_b2c';
			$titlename1		= 'Bluestar B2C';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
		} 
       	
		$result 					= $this->model->transaction_lifecycle($table);
		
		$userphone 					= array();
		$user_detail 				= array();
		if(!empty($result)){
			for($i=0;$i<count($result); $i++){
				$userphone['phone'] = $result[$i]['PHONE1'];
				$userphone['url'] 	= 'Hi User please give feedback in the below url'." ".$this->get_tiny_url('http://13.126.160.18/landing-transaction.php?customer_type='. $customer_type.'&brand_customer_id='.$result[$i]['CUSTOMERID'].'&user_phone='.$result[$i]["PHONE1"].'&user_id='.$result[$i]["id"].' ');
				$userphone['id'] 	= $result[$i]['id'];
				$userphone['CUSTOMERID'] 	= $result[$i]['CUSTOMERID'];
				$userphone['profile_type'] 	= $result[$i]['profile_type'];
				
				$user_detail[] 		= $userphone;
			}	
		}
		
		$data 						= array();
		foreach($user_detail as $key => $value){
			$this->send_lifecycle_sms($value['phone'],$value['url']);
			$data 					= array(
										'tm_brand_user_id' 		=> $value['id'],
										'tm_brand_customer_id'  => $value['CUSTOMERID'],
										'tm_brand_name'   		=> $table,
										'tm_brand_user_phone'   => $value['phone'],
										'tm_brand_id'   		=> $customer_type,
										'tm_interaction'		=> 'SMS',
										'tm_interaction_type'	=> 13,
										'tm_transaction_type'	=> 'SMS sent for transaction lifecycle',
										'tm_movement_from'		=> $value['profile_type'],
										'tm_movement_to'		=> $value['profile_type'],
										'tm_created_date'		=> date('Y-m-d')
										);
			$timeline_response 		= $this->insert_timeline_data($data);							
		}
		
		// Promotional Message afetr 30 days
		$feedback_result 	= $this->model->promotional_message();
		$feedabckphone		= array();	
		if(!empty($feedback_result)){
			foreach($feedback_result as $key1 => $value1){
				$feedabckphone[] = $value1['tm_brand_user_phone'];
			}
		}
		$text_message 		= "Hi thanks for giving feedback in yapnaa";
		$this->send_bulk_sms($feedabckphone,$text_message);
		
		return true;
	}

	
	// Function for going yapnaa promotional message afetr 7 days for change product
	function productchange_lifecycle($customer_type){
		switch($customer_type){
			case 1:
		    $table			= 'livpure';
			$titlename1		= 'Livpure';
			$brand_img		= "logo_livpure_yapnaa.png";
            break;
			
			case 2:
		    $table			= 'zerob_consol1';
			$titlename1		= 'Zero B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;	

			case 3:
		    $table			= 'livpure_tn_kl';
			$titlename1		= 'Livpure TN';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 4:
		    $table			= 'bluestar_b2b';
			$titlename1		= 'Bluestar B2B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 5:
		    $table			= 'bluestar_b2c';
			$titlename1		= 'Bluestar B2C';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
		} 
       	
		$result 				= $this->model->productchange_lifecycle($table);
		
		if(!empty($result)){
			for($i=0;$i<count($result); $i++){
				$userphone[] 	= $result[$i]['PHONE1'];
			}	
		}
		
		$text 					= "Hi thanks for giving feedback in yapnaa";
		$this->send_bulk_sms($userphone,$text);
		
		$data 					= array();
		if(!empty($result)){
			foreach($result as $key => $value){
				$data 				= array(
											'tm_brand_user_id' 		=> $value['id'],
											'tm_brand_customer_id'  => $value['CUSTOMERID'],
											'tm_brand_name'   		=> $table,
											'tm_brand_user_phone'   => $value['PHONE1'],
											'tm_brand_id'   		=> $customer_type,
											'tm_interaction'		=> 'SMS',
											'tm_interaction_type'	=> 13,
											'tm_transaction_type'	=> 'SMS sent for product change lifecycle',
											'tm_movement_from'		=> $value['profile_type'],
											'tm_movement_to'		=> $value['profile_type'],
											'tm_created_date'		=> date('Y-m-d')
											);						
				$timeline_response 	= $this->insert_timeline_data($data);
			}
		}
		return true;
	}
	
	// Function for escalation lifecycle
	function escalation_lifecycle($customer_type){
		switch($customer_type){
			case 1:
		    $table			= 'livpure';
			$titlename1		= 'Livpure';
			$brand_img		= "logo_livpure_yapnaa.png";
            break;
			
			case 2:
		    $table			= 'zerob_consol1';
			$titlename1		= 'Zero B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;	

			case 3:
		    $table			= 'livpure_tn_kl';
			$titlename1		= 'Livpure TN';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 4:
		    $table			= 'bluestar_b2b';
			$titlename1		= 'Bluestar B2B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 5:
		    $table			= 'bluestar_b2c';
			$titlename1		= 'Bluestar B2C';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
		} 
       	
		$result 		= $this->model->escalation_lifecycle($table);
		
		// Follow up mail to brand
		$to             = "spandag30@gmail.com"; 	
		$subject 		= "Follow up mail in escalation";
		if(!empty($result)){
			foreach($result as $key => $value) {
				$message 	= 	"
									<html>
										<head>
											<title>Yapnaa</title>
										</head>
										
										<body>
											<table style='border:1px solid'>
												<tr style='border:1px solid'>
													<td style='border:1px solid'>This Email is regarding escalation of </td>
												</tr style='border:1px solid'>
												<tr style='border:1px solid'>
													<table class='table table-striped table-bordered table-hover'>
													
														<thead>
															<tr>
																<th>Customer Name</th>
																<th>Customer Phone</th> 
															</tr>
														</thead>
														
														<tbody>
															<tr>
																<td>".$value['CUSTOMER_NAME']."</td>
																<td>".$value['PHONE1']."</td> 
															</tr>
														</tbody>
														
													</table>
												</tr style='border:1px solid'>
											</table>
										</body>
									</html>
								";
				
				
			}
		}
		
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";   
		mail($to, $subject, $message,$headers);
		
		$data 						= array();
		if(!empty($result)){
			foreach($result as $key1 => $value1) {
				$data 				= array(
											'tm_brand_user_id' 		=> $value1['id'],
											'tm_brand_customer_id'  => $value1['CUSTOMERID'],
											'tm_brand_name'   		=> $table,
											'tm_brand_user_phone'   => $value1['PHONE1'],
											'tm_brand_id'   		=> $customer_type,
											'tm_interaction'		=> 'SMS',
											'tm_interaction_type'	=> 16,
											'tm_transaction_type'	=> 'SMS sent for escalation lifecycle',
											'tm_movement_from'		=> $value['profile_type'],
											'tm_movement_to'		=> $value['profile_type'],
											'tm_created_date'		=> date('Y-m-d')
											);						
				$timeline_response 	= $this->insert_timeline_data($data);
			}
		}
		
		return true;
		
	}
	
	
	function amc_message($customer_type){
		switch($customer_type){
			case 1:
		    $table			= 'livpure';
			$titlename1		= 'Livpure';
			$brand_img		= "logo_livpure_yapnaa.png";
            break;
			
			case 2:
		    $table			= 'zerob_consol1';
			$titlename1		= 'Zero B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;	

			case 3:
		    $table			= 'livpure_tn_kl';
			$titlename1		= 'Livpure TN';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 4:
		    $table			= 'bluestar_b2b';
			$titlename1		= 'Bluestar B2B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 5:
		    $table			= 'bluestar_b2c';
			$titlename1		= 'Bluestar B2C';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
		} 
       	
		$result 				= $this->model->amc_message($table);
		
		$userphone 				= array();
		$user_detail 			= array();
		if(!empty($result)){
			for($i=0;$i<count($result); $i++){
				$userphone['phone'] = $result[$i]['PHONE1'];
				$userphone['url'] 	= 'Hi '.$result[$i]["CUSTOMER_NAME"].', please give feedback in the below url'." ".$this->get_tiny_url('http://13.126.160.18/landing-amc-message.php?customer_type='. $customer_type.'&brand_customer_id='.$result[$i]['CUSTOMERID'].'&user_phone='.$result[$i]["PHONE1"].'&user_id='.$result[$i]["id"].' ');
				
				$user_detail[] 		= $userphone;
			}	
		}
		
		foreach($user_detail as $key => $value){
			$this->send_lifecycle_sms($value['phone'],$value['url']);
		}
		return true;
		
	}

	// Function for inserting data into timeline table
	function insert_timeline_data($data){
		$table 			= 'timeline';
		$arr_result   	= $this->model->insert($table, $data);
		
		if($arr_result){
			return $arr_result;
		}
		else{
			return 0;
		}
	}

	// Function for inserting data into timeline_profile table
	function insert_timeline_profile_data($data){
		$table 			= 'timeline_profile';
		$arr_result   	= $this->model->insert($table, $data);
		
		if($arr_result){
			return $arr_result;
		}
		else{
			return 0;
		}
	}	
	
	// function for inserting data in profile history
	function insert_profile_history($data){
		$table 			= 'profile_history';
		$arr_result   	= $this->model->insert($table, $data);
		
		if($arr_result){
			return $arr_result;
		}
		else{
			return 0;
		}
	}	
		
	// function for get data from timeline table from userid and brandId
	function get_timeline_detail_of_customer($customer_type,$user_id){
		$result 			= $this->model->get_timeline_detail_of_customer($customer_type,$user_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	
	// function for getting existing_profile_status_of_customer
	function get_existing_profile_status_of_customer($brand_name,$user_id){
		$result 	= $this->model->get_existing_profile_status_of_customer($brand_name,$user_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	
	// Profile history data for a customer
	function get_profile_history_data($brand,$user_id,$tm_id){
		$result 	= $this->model->get_profile_history_data($brand,$user_id,$tm_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	
	// Update call status afetr calling in daily_call_schedule table
	function updateCallStatusInDailyCallSchedule($update_data,$call_id){
		$condition		= "id = '".$call_id."' ";			   
		$result 		= $this->model->update('daily_call_schedule_2',$update_data,$condition);
		return $result;
	}
		
	// Welcome Promotional message
	function promotional_welcome_sms($customer_type){
		
		switch($customer_type){
			case 1:
		    $table			= 'livpure';
			$titlename1		= 'Livpure';
			$brand_img		= "logo_livpure_yapnaa.png";
            break;
			
			case 2:
		    $table			= 'zerob_consol1';
			$titlename1		= 'Zero B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;	

			case 3:
		    $table			= 'livpure_tn_kl';
			$titlename1		= 'Livpure TN';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 4:
		    $table			= 'bluestar_b2b';
			$titlename1		= 'Bluestar B2B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 5:
		    $table			= 'bluestar_b2c';
			$titlename1		= 'Bluestar B2C';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
		} 
       	
		//include 'encryption_decryption.php';
		$result 					= $this->model->promotional_welcome_sms($table);
		//print_r($result); die;
		$userphone 					= array();
		$user_detail 				= array();
		if(!empty($result)){
			for($i=0;$i<count($result); $i++){
				$userphone['phone'] = $result[$i]['PHONE1'];
				
				//$userphone['url'] 	= 'Dear '.$result[$i]['CUSTOMER_NAME'].' please give your valueable feedback in the below url'." ".$this->get_tiny_url('http://13.126.160.18/promotional-feedback.php?customer_type='. $customer_type.'&brand_customer_id='.$result[$i]['CUSTOMERID'].'&user_phone='.$result[$i]["PHONE1"].'&user_id='.$result[$i]["id"].' ');
				
				$userphone['url'] 	= 'Dear '.$result[$i]['CUSTOMER_NAME'].' please give your valueable feedback in the below url'." ".$this->get_tiny_url('http://13.126.160.18/promotional-feedback.php?hash='. encryptIt($customer_type."|".$result[$i]["id"]).' ');
				
				
				$userphone['id'] 	= $result[$i]['id'];
				$userphone['CUSTOMERID'] 	= $result[$i]['CUSTOMERID'];
				$userphone['profile_type'] 	= $result[$i]['profile_type'];
				
				$user_detail[] 		= $userphone;
			}	
			print_r($user_detail);die;
			foreach($user_detail as $key => $value){
				$this->send_lifecycle_sms($value['phone'],$value['url']);
			}
			return true;
		}
	}
	
	// Livpure AMC 
	function amc_cron($customer_type){
		switch($customer_type){
			case 1:
		    $table			= 'livpure';
			$titlename1		= 'Livpure';
			$brand_img		= "logo_livpure_yapnaa.png";
            break;
			
			case 2:
		    $table			= 'zerob_consol1';
			$titlename1		= 'Zero B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;	

			case 3:
		    $table			= 'livpure_tn_kl';
			$titlename1		= 'Livpure TN';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 4:
		    $table			= 'bluestar_b2b';
			$titlename1		= 'Bluestar B2B';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
			case 5:
		    $table			= 'bluestar_b2c';
			$titlename1		= 'Bluestar B2C';
            $brand_img		= "logo_livpure_yapnaa.png";			
            break;
			
		} 
       	
		$result 					= $this->model->amc_cron($table);
		
		$userphone 					= array();
		$user_detail 				= array();
		if(!empty($result)){
			for($i=0;$i<count($result); $i++){
				$userphone['phone'] = $result[$i]['PHONE1'];
				$userphone['url'] 	= 'Dear '.$result[$i]['CUSTOMER_NAME'].' please give your valueable feedback in the below url'." ".$this->get_tiny_url('http://13.126.160.18/amc-cron.php?customer_type='. $customer_type.'&brand_customer_id='.$result[$i]['CUSTOMERID'].'&user_phone='.$result[$i]["PHONE1"].'&user_id='.$result[$i]["id"].' ');
				$userphone['id'] 	= $result[$i]['id'];
				$userphone['CUSTOMERID'] 	= $result[$i]['CUSTOMERID'];
				$userphone['profile_type'] 	= $result[$i]['profile_type'];
				
				$user_detail[] 		= $userphone;
			}	
			
			foreach($user_detail as $key => $value){
				$this->send_lifecycle_sms($value['phone'],$value['url']);
			}
			return true;
		}
	}	
	
	
	// Promotional Message For Yapnaa After 30 Days
	/* function promotional_message(){
		$this->send_bulk_sms($value['phone'],$value['url']);
	} */
	
	
	//gets the data from a URL  
	function get_tiny_url($url)  {  
		$ch 		= curl_init();  
		$timeout 	= 5;  
		curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
		$data 		= curl_exec($ch);  
		curl_close($ch);  
		return $data;  
	}
		
	function send_lifecycle_sms($user_numbers,$message){ 
		date_default_timezone_set('Asia/Kolkata');
		$today = date("Y-m-d H:i:s");
		if($user_numbers){
			$ch = curl_init();
			$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_numbers)."&message=".urlencode("".$message."");
			
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch );	
		}		
		else{
			return 0;
		}
	}
	
	
	function send_bulk_sms($user_numbers,$message){ 
		date_default_timezone_set('Asia/Kolkata');
		$today = date("Y-m-d H:i:s");
		if($user_numbers){
			for($i=0;$i<count($user_numbers);$i++){
				if($user_numbers[$i]){
					$ch = curl_init();
				    $url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_numbers[$i])."&message=".urlencode("".$message."");
					
					curl_setopt( $ch,CURLOPT_URL, $url );
					curl_setopt( $ch,CURLOPT_POST, false ); 
					curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
					$result = curl_exec($ch );
					curl_close( $ch );
				}
			}	
		}		
		else{
			return 0;
		}
	}
	
	
	// Dashboard For pie chart
	function get_dashboard_data_by_brand_status($table){
		$result 	= $this->model->get_dashboard_data_by_brand_status($table);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	function get_dashboard_data_by_brand_profile_type($table){
		$result 	= $this->model->get_dashboard_data_by_brand_profile_type($table);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	function get_dashboard_data_by_brand_not_interested($table){
		$result 	= $this->model->get_dashboard_data_by_brand_not_interested($table);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	
	// By Suman and for telecaller
	function add_telecaller($arr_input){
		$table		= 'admin_login';
		$result		= $this->model->insert($table,$arr_input);
		return $result;
	}
	
	function get_telecaller_list(){
		$result 	= $this->model->get_telecaller_list();
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	
	// New Customer Question Answer Logic
	function get_qa_data($customer_type,$user_id){
		switch($customer_type){
			case 1:
			$brand	='livpure';
			break;
			case 2:
			$brand	='zerob_consol1';
			break;
			case 3:
			$brand	='livpure_tn_kl';
			break;
			case 4:
			$brand	='bluestar_b2b';
			break;
			case 5:
			$brand	='bluestar_b2c';
			break;
		}
		$brand   	= 1;
		$result 	= $this->model->get_qa_data($brand,$user_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	
	// New Table Design By Saswata AND Suman
	function insert_q_a($data){
		$table 			= 'customer_question_answer_1';
		$arr_result   	= $this->model->insert($table, $data);
		
		if($arr_result){
			return $arr_result;
		}
		else{
			return 0;
		}
	}
	
	function update_q_a($data,$user_id){
		$result		= $this->model->update_q_a($data,$user_id);
		return $result; 
	}
	
	function get_question_ids_of_customer($brand_id,$user_id){
		$result 			= $this->model->get_question_ids_of_customer($brand_id,$user_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	function get_answer_weightage_of_customer($brand_id,$user_id){
		$result 			= $this->model->get_answer_weightage_of_customer($brand_id,$user_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	function update_status_in_brand($table,$update_data,$user_id){
		$condition		= "id = '".$user_id."' ";			   
		$result 		= $this->model->update($table,$update_data,$condition);
		return $result; 
	}
	
	// Profile history data for a customer
	function show_profile_history($brand,$user_id,$tm_id){
		$result 	= $this->model->show_profile_history($brand,$user_id,$tm_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	function get_profile_popup_data($brand,$user_id){
		$result 	= $this->model->get_profile_popup_data($brand,$user_id);
		if($result){
			return $result;
		}else{
			return array();
		}
	}
	
	
	
		
}

?>