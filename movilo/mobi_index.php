<?php

	global $obj_search;
	global $obj_common;
	include('controller/user_controller.php');
        $obj_search = new users;
	


	if(isset($_GET['page'])){
		$url_id	=	$_GET['page'];
	}
	if(empty($url_id)){
		require_once('andriod/index.php');
	} 
	//$page 	=	'index';
	require_once('andriod/'.$url_id.'.php');
	
  
?>
