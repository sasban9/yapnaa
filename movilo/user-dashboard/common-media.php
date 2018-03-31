<?php
require_once('../controller/user_controller.php');
$obj_user = new users;

if(isset($_GET['logout'])){
	
	 $brands_list=$obj_user->logout();     
}
if(isset($_REQUEST['brandcat'])){
	
	$p_category_id=$_POST['p_category_id'];
	$brand_product_list=$obj_user->brand_product_list_by_category_dashboard($p_category_id); 
   
   echo json_encode($brand_product_list);  
}
if(isset($_REQUEST['productdetails'])){
	
	$user_id=$_POST['user_id'];
	$up_product_id=$_POST['up_product_id'];
	$productdetailsuser=$obj_user->user_product_list_dashboard_paticular($user_id,$up_product_id); 
   
   echo json_encode($productdetailsuser);  
}
if(isset($_REQUEST['addproduct'])){
	
	$brands=$_POST['brandId'];
	$dateInstallation=$_POST['dateInstallation'];
	$bId=$_POST['bId'];
	$product_user_id=$_POST['uId'];
	$savepdt=$obj_user->add_product($bId,$product_user_id,$brands,$dateInstallation); 
                            
   return $savepdt; 
}
if(isset($_REQUEST['deleteProduct'])){
	
	$del_user_id=$_POST['del_user_id'];
	$del_up_id=$_POST['del_up_id'];
	
	$deletedpdt=$obj_user->deleteProduct($del_up_id,$del_user_id); 
                            
   return $deletedpdt; 
}
if(isset($_REQUEST['facebook'])){
	
	$fbId=$_POST['fbId'];
	
	
	$fblogindetails=$obj_user->fblogin($fbId); 
                            
   echo json_encode($fblogindetails); 
}
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
?>