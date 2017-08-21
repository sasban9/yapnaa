<?php
// if the user is logged in, unset the session
error_reporting(E_ALL);
session_start();
require_once('controller/admin_controller.php');
$control	=	new admin();


if (isset($_SESSION['admin_email_id'])) {
$email=$_SESSION['admin_email_id'];
$logout_val	=	$control->admin_logout($email);
// print($logout_val);exit;
unset($_SESSION['email']);
unset($_SESSION['last_login']);
unset($_SESSION['admin_name']);
if(!empty($logout_val)){
echo '<META HTTP-EQUIV="Refresh" Content="0; URL=index.php">';
session_destroy();
}
}

?>