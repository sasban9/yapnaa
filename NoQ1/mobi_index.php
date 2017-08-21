<?php
//print_r($_POST);
	require_once("model/model.php"); 
	$obj_model	=	new model;

	require_once("config/tab_config.php");
	$table 		= table();

 
	include('controller/common_controller.php');
	$common_controller = new common_controller;
	
	include('controller/user_controller.php');
	$user_controller = new users;
	
	require_once("config/config.php");
	global $obj_search;

	if(isset($_GET['page'])){
		$url_id	=	$_GET['page'];
	}
	if(empty($url_id)){
		require_once('andriodapi/index.php');
	} 
	//$page 	=	'index';
	require_once('andriodapi/'.$url_id.'.php');
	
  
?>
