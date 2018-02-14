<?php 
require_once(__DIR__.'/'.'movilo/controller/user_controller.php');
$obj_user = new users;
if(isset($_REQUEST['service_req'])){
		$user = $_REQUEST['user'];
		$cust_name = $_REQUEST['custName'];
		$brand_info = $_REQUEST['brandInfo'];
		$brand = $_REQUEST['brand'];
		$issue = $_REQUEST['issue'];
		$cust_phone = $_REQUEST['custPhone'];
		
		
		$obj_user->save_request_raise($user,$cust_name,$brand_info,$brand,$issue,$cust_phone);
		echo 1;
		exit;
	}
if(isset($_REQUEST['socialmediatweet'])){
		$user = $_REQUEST['user'];		
		$msg = $_REQUEST['msg'];
		$userType = $_REQUEST['userType'];		
		$obj_user->social_media_post($user,$msg,$userType);
		echo 1;
		exit;
	}
if(isset($_REQUEST['socialmediaface'])){
		$user = $_REQUEST['user'];		
		$msg = $_REQUEST['msg'];
		$userType = $_REQUEST['userType'];
		
		
		$obj_user->social_media_post($user,$msg,$userType);
		echo 1;
		exit;
	}
	if(isset($_REQUEST['news_later'])){
		$name = $_REQUEST['name'];		
		$email = $_REQUEST['email'];
		$obj_user->news_later_subscribe($name,$email);
		echo 1;
		exit;
	}
?>