<?php 

	// User Registration
if(!empty($_REQUEST['serial_no'])){
// echo$_REQUEST['serial_no'];exit;
	$arr_user_reg_info		= 	$obj_search->brand_api_check();
	// print_r($arr_user_reg_info);exit;
	if($arr_user_reg_info){
		echo json_encode($arr_user_reg_info);
		// return (json_encode($arr_user_reg_info));
		// echo "hello vajid";
	}else{
		//return 0;
		echo "0";
	}
}

	
?>