<!DOCTYPE html>
<html lang="en">
<?php
session_start();
 
if(isset($_SESSION['admin_email_id']))
{
	 $admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];
	 $ar_role_name  	= $_SESSION['ar_role_name'];
	 $admin_phone_no  	= $_SESSION['admin_phone_no'];
	 $ar_id  	        = $_SESSION['ar_id'];
	 
	
	require_once('controller/admin_controller.php');
	$control				= new admin();
	
	$telecaller_list 		= $control->get_telecaller_list();
	//print_r($telecaller_list); die;
	
	if(isset($_POST['admin_name']) || !empty($_POST['admin_name'])){
		$_POST 					 = array_slice($_POST, 0, -1, true);
		$_POST['admin_password'] = md5($_POST['admin_password']);
		$_POST['admin_last_login'] = null;
		$_POST['admin_phone_no'] = 0;
		$_POST['admin_address'] = null;
		
		$save_data_resp	    	 = $control->add_telecaller($_POST);
		if(!empty($save_data_resp)){
			$page = $_SERVER['PHP_SELF'];
			$sec = "3";
			header("Refresh: $sec; url=$page");
		}
	}
	 
?>

<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:49:42 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="images/Yapnaa_logo-96x96.png">
    <title>Movilo | Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
       <?php include "header.php";?>
    </div>
                
	<div class="row  border-bottom white-bg dashboard-header">
		<form id="form" method="POST" enctype="multipart/form-data">		
			
			<div class="row">
				<div class="col-lg-2 new" >
					<label>Name</label>
					<input type="text" name="admin_name" id="admin_name" value="" />
				</div>
				
				<div class="col-lg-2 new" >
					<label>Email</label>
					<input type="text" name="admin_email_id" id="admin_email_id" value="" />
				</div>
				
				<div class="col-lg-2 new" >
					<label>Password</label>
					<input type="text" name="admin_password" id="admin_password" value="" />
				</div>
				<input type="hidden" name="admin_role_id" id="admin_role_id" value="3" />
				
				<div class="col-lg-2" style="margin-top: 23px;">
					<input type="submit" class="btn btn-info " value="Save"  name="submit" >
				</div>
			</div>	
			
		</form>
	</div>
		
	<div class="wrapper wrapper-content animated fadeInRight" style="margin-top: -30px;">
		<div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th>Yapnaa ID</th>
									<th>Name</th>
									<th>Email</th>
									<th>Action</th>
								</tr>
							</thead>
							
							<tbody>
								<?php for($i=0; $i < count($telecaller_list); $i++){?>
									<tr>
										<td><?php echo $telecaller_list[$i]['admin_id'];?></td>
										<td><?php echo $telecaller_list[$i]['admin_name'];?></td>
										<td><?php echo $telecaller_list[$i]['admin_email_id'];?></td>
										<td></td> 
									</tr>
								<?php } ?>
								
							</tbody>
						</table>  
                    </div>
                </div>
            </div>
        </div>
    </div>

               
<?php include "footer.php";?>

<?php
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
