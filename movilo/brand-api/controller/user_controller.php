<?php

if(isset($_POST['value']))
{
	require_once('../model/model.php');
	$obj_model	=new model;
	require_once('../config/tab_config.php');
}else{
	require_once('model/model.php');
	$obj_model	=new model;
	require_once('config/tab_config.php');
}



class users
{
    function __construct()
    {
        global $obj_model;
        global $tb;
        $this->model =& $obj_model;
    }
    
    
    
	// user registartion
    function brand_api_check()
    {
        $table 			 =  table();
        $serial_no 		 =	$_REQUEST['serial_no'];
		$table_user      =  $table['tb1'];
		$fields_user     =  '*';
		$condition_user  =  'bp_serial_no    = ' . "'" . $serial_no . "'";
		$arr_result_test =  $this->model->get_Details_condition($table_user, $fields_user, $condition_user);
		return $arr_result_test;
		// print_r($arr_result_test);exit;
          
    }
    
	
/*-----------------------------------------------------------------------------------------------------------------------*/
	
	
	 
}
?>
 
