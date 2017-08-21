<?php
// if the user is logged in, unset the session
error_reporting(E_ALL);
session_start();
require_once("../../config/tab_config.php");
require_once("../../config/config.php");

require_once("../../model/model.php"); 
$obj_model	=	new model();
require_once('../../controller/admin_controller.php'); 
$admin_controller	=	new admin();

if (isset($_SESSION['ad_email_id'])) {
$ad_id			=	$_SESSION['ad_id'];
$logout_val		=	$admin_controller->admin_logout($ad_id);
// print($logout_val);exit;
unset($_SESSION['ad_id']);
unset($_SESSION['ad_name']);
unset($_SESSION['ad_email_id']);
unset($_SESSION['ad_mobile_no']);
unset($_SESSION['ad_role_id']);
unset($_SESSION['ad_registration_date']);
unset($_SESSION['ad_last_login']);
unset($_SESSION['ad_status']);
unset($_SESSION['ad_rest_ref_id']);
unset($_SESSION['ad_profile_img']); 
if(!empty($logout_val)){
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=../index.php">';
session_destroy();
}
}

?>