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
		$my_date = date('d-m-Y H:i', strtotime($date));
		//echo $my_date."--".$number;
		$get_amc_list = $control->zerob_appointment_sms($id,$my_date,$number,$comment);
		echo 1;
		exit;
	}
	if(isset($_REQUEST['expiryDate'])){
		$date = $_REQUEST['expiryDate'];
		$number = $_REQUEST['number'];
		$id = $_REQUEST['id'];
		$comment = $_REQUEST['comment'];
		//echo $my_date."--".$number;
		$get_amc_list = $control->zerob_appointment_expiry_sms($id,$date,$number,$comment);
		echo 1;
		exit;
	}
	if(isset($_REQUEST['notInterested'])){
		$id = $_REQUEST['id'];
		$comment = $_REQUEST['comment'];
		$get_amc_list = $control->updateStatus($id,$comment,2);
		echo 1;
		exit;
	}
	if(isset($_REQUEST['callBack'])){
		$id = $_REQUEST['id'];
		$comment = $_REQUEST['comment'];
		$get_amc_list = $control->updateStatus($id,$comment,1);
		echo 1;
		exit;
	}
	if(isset($_REQUEST['general'])){
		$number = array($_REQUEST['number']);
		$id = array($_REQUEST['id']);
		$comment =	$_REQUEST['comment'];
		$message = 'Thank you for your time. Now maintaining your home appliances is easy. Download the Yapnaa app http://bit.ly/YapnaaForAndroid';
		$get_amc_list = $control->send_user_sms($number,$message,$id,$comment);
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
