<?php
session_start();

	global $obj_search;
	include('controller/user_controller.php');
    $obj_search = new users;
	
?>
