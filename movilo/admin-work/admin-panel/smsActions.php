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
