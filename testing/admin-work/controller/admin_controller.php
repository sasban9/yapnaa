<?php 

require_once("model/model.php");
$obj_model	=new	model;


class admin	{
	
	function __construct(){
		global $obj_model;
		global $tb;
		$this->model=& $obj_model;
	}
	
	
	function admin_login_val($admin_email_id,$admin_password)
	{
		$result	=	$this->model->admin_login_val($admin_email_id,$admin_password);
		return $result;
	}
	
	/*Last Login Time date update*/
	function admin_logout($admin_email_id)
	{
		$table		=	'admin_login';
		date_default_timezone_set('Asia/Kolkata');
		$date	=	date("l jS \of F Y h:i:s A");
		$set_array	=	array(
						'admin_last_login'=> $date
						);
		$condition 	=	"admin_email_id='".$admin_email_id."'";				
		$result	=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
}

?>