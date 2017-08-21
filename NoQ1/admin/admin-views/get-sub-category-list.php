<?php
require_once("../../config/tab_config.php");
require_once("../../config/config.php");

require_once("../../model/model.php"); 
$obj_model	=	new model();
require_once('../../controller/admin_controller.php'); 
$admin_controller	=	new admin();



if(isset($_POST['id'])){
	$id		=	$_POST['id'];  
	// Get get_brand List
	$get_sub_category_by_mc_id = $admin_controller->get_sub_category_by_mc_id($id);
	// print(count($get_city_list));exit;
	// echo '<pre>';print_r($get_sub_category_by_mc_id);
	echo "<option value =''>Select Sub Category </option>";
	foreach($get_sub_category_by_mc_id as $val){
		 $sc_id			=	$val['sc_id'];
		 $sc_title		=	$val['sc_title'];
		 
		echo "<option value ='$sc_id'>$sc_title</option>";
	}
	
	
	
}

?>