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
		$number = $_REQUEST['number'];
		$brandId = $_REQUEST['brandId'];
		$brandName = $_REQUEST['brandName'];
		$_list = $control->insertStatus($userQst,$answer,$number,$brandId,$brandName);
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
	//$get_amc_list = $control->get_zerob_list($search);
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
