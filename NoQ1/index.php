<?php
session_start();
require_once("model/model.php"); 
$obj_model	=	new model;

require_once("config/tab_config.php");
$table 		= table();

include('controller/admin_controller.php');
$admin_controller = new admin;


include('controller/user_controller.php');
$user_controller = new users;


include('controller/vendor_controller.php');
$vendor_controller = new vendor_controller;



include('controller/web_common_controller.php');
$web_common_controller = new web_common_controller;



require_once("config/config.php"); 


 
if(isset($_GET['page'])){
	$url_id	=	$_GET['page'];
}
// echo $url_id;exit;
if(empty($url_id)){
	require_once('view/index.php');
} else{
	require_once('view/'.$url_id.'.php');
}

?>
