<?php
session_start(); 
if(isset($_SESSION['admin_email_id']))
{
	 $admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];

	require_once('controller/admin_controller.php');
	$control	=	new admin();
	
	
	
	$get_user_list = $control->get_user_list();
	
	
	
	// $id = $_POST['keyword']; 
	// $get_user_list = $control->get_user_phone_list($id);

	
	 for($i=0;$i<count($get_user_list);$i++){ 
	  $dname_list[] = $get_user_list[$i]['user_phone']; 
	 
	 }
	 
	  echo json_encode($dname_list);
	 
}
else
{
?>
<script>
  window.location.assign("../index.php")
</script>
<?php
}
?>
