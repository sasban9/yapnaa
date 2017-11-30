<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
if(isset($_SESSION['admin_email_id']))
{
	 $admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];

	require_once('controller/admin_controller.php');
	$control	=	new admin();
	
	
	 
	// Get get_amc_price_list List
	$get_apk_version = $control->get_apk_version();
	// echo '<pre>';
	// print_r($get_apk_version); 
	
	 
	if(isset($_POST['submit']))
	{
		$res = $control->add_apk_version();
		if(!empty($res))
		{
				echo '<script>alert("APK version added successfully.")</script>';
				echo '<script>window.location.assign("apk-version-update.php")</script>';
		} 
	}
	
	
	
	
	//Deactive
	if(isset($_POST['deactive']))
	{	
		$del_brand	=	$control->deactive_apk_version();
		// print_r($update_main_category);exit;
		if(!empty($del_brand)){
			echo '<script>alert("APK version deactivated successfully.")</script>';
			echo '<script>window.location.assign("apk-version-update.php")</script>';
		}
	}
	
	
	
	//Active
	if(isset($_POST['active']))
	{	
		$del_brand	=	$control->active_apk_version();
		// print_r($update_main_category);exit;
		if(!empty($del_brand)){
			echo '<script>alert("APK version activated successfully.")</script>';
			echo '<script>window.location.assign("apk-version-update.php")</script>';
		}
	}
	
	
	
	
	//delete
	if(isset($_POST['delete']))
	{	
		$del_brand_product	=	$control->del_apk_version();
		// print_r($update_main_category);exit;
		if(!empty($del_brand_product)){
			echo '<script>alert("APK version deleted successfully.")</script>';
			echo '<script>window.location.assign("apk-version-update.php")</script>';
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
              
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-10">
				<h2>APK Version List</h2>
				<ol class="breadcrumb">
					<li>
						<a href="index.php">Home</a>
					</li>
					<li class="active">
						<strong>APK Version List</strong>
					</li>
				</ol>
			</div>
			<div class="col-lg-2">

			</div>
		</div>	  
		
		
		
		
		<div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
										<div class="media-body ">
										   <div class="row m-t-sm">
												<div class="col-lg-12">
													<div class="panel blank-panel">
														<div class="panel-heading">
															<div class="panel-options">
																<ul class="nav nav-tabs">
																	<li class="active"><a href="#tab-1" data-toggle="tab"> APK Versions List</a></li>
																	<li class=""><a href="#tab-2" data-toggle="tab">Add APK Version</a></li>
																</ul>
															</div>
														</div>

														<div class="panel-body">

															<div class="tab-content">
																<div class="tab-pane active" id="tab-1">
																	  <table class="table table-striped table-bordered table-hover dataTables-example" >
																		<thead>
																		<tr>
																				<th>S.No</th>
																				<th>APK Version Name</th> 
																				<th>Action</th> 
																				<th>Delete</th>
																			
																			
																		</tr>
																		</thead>
																		<tbody>
																		<?php $j=1;?>
																		<?php for($i=0;$i<count($get_apk_version);$i++){ ?>
																			<tr>
																				<td><?php echo  $j; ?></td>
																				<td><?php echo $get_apk_version[$i]['apk_version_name']; ?></td>  
																				<?php if($get_apk_version[$i]['apk_version_status']==1){?>
																				<td>
																					<form id="form" method="POST">
																							<input type="hidden" class="form-control" value="<?php echo $get_apk_version[$i]['apk_version_id']?>" name="id" required>	
																						<input id="submit" onclick="return confirm('Are you sure you want to deactivate this APK version?');" type="submit" name="deactive" class="delete_profile btn btn-danger" value="Deactivate">
																					</form>
																				</td>
																				<?php } else{ ?>
																				<td>
																					<form id="form" method="POST">
																							<input type="hidden" class="form-control" value="<?php echo $get_apk_version[$i]['apk_version_id']?>" name="id" required>	
																						<input id="submit" onclick="return confirm('Are you sure you want to activate this APK version?');" type="submit" name="active" class="delete_profile btn btn-success" value="Activate">
																					</form>
																				</td><?php } ?>
																				
																				
																				
																				<td>
																					<form id="form" method="POST">
																							<input type="hidden" class="form-control" value="<?php echo $get_apk_version[$i]['apk_version_id']?>" name="id" required>	
																						<input id="submit" onclick="return confirm('Are you sure you want to delete this APK version?');" type="submit" name="delete" class="delete_profile btn btn-danger" value="Delete">
																					</form>
																				</td>
																				
																				
																				
																				
																			</tr>
																		<?php $j++; } ?>
																		</tbody>
																	</table>  
																</div>
															
																<div class="tab-pane" id="tab-2">
																		<form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																				 
																				<div class="form-group">
																					<label class="col-sm-2 control-label">APK Version Name:</label>
																					<div class="col-sm-10">
																					<input type="text" class="form-control" name="v_name" id="v_name" required>	
																					</div>
																				</div>
																				 
																				
																				
																				<input id="submit" onclick="myFunction()" type="submit" name="submit" class="btn btn-info pull-right"  value="Add">
																			</fieldset>
																	</form>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
		
                
               
<?php include "footer.php";?>

<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script>

function myFunction() {
	
var add_cat = $("#v_name").val();
if ($.trim(add_cat) === '')
{
alert("Please Eneter Version Name.");
$('#v_name').val('');
$('#v_name').focus();
 return false;
}
 


}
</script>


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
