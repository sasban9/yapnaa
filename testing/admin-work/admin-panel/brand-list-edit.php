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
	
	
	$id				  =		$_REQUEST['id'];
	$get_brand_by_id  = 	$control->get_brand_by_id($id);
	// echo'<pre>';
	// print_r($get_brand_by_id);exit;
	
	if(isset($_POST['update']))
	{
		$update_brand	=	$control->update_brand();
		// print_r($update_main_category);exit;
		if(!empty($update_brand)){
			echo '<script>alert("Brand updated successfully.")</script>';
			echo '<script>window.location.assign("brand-list.php")</script>';
		}
	}
	
	
?>
<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:49:42 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
              
			  
		<div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
										<div class="media-body ">
										   <h2>Edit Brand List</h2>
										   <div class="row m-t-sm">
												<div class="col-lg-12">
													<div class="panel blank-panel">
														<div class="panel-heading">
															<div class="panel-options">
																<ul class="nav nav-tabs">
																	<li class="active"><a href="#tab-1" data-toggle="tab">Edit Brand</a></li>
																</ul>
															</div>
														</div>

														<div class="panel-body">

															<div class="tab-content">
																<div class="tab-pane active" id="tab-1">
																	  <form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																				<div class="form-group"><label class="col-sm-2 control-label">Brand Name:</label>
																					<div class="col-sm-10">
																					<input type="hidden" class="form-control" value="<?php echo $get_brand_by_id[0]['brand_id'];?>" name="id" required>	 
																					<input type="text" class="form-control" name="brand" id="brand" value="<?php echo $get_brand_by_id[0]['brand_name'];?>" required>	
																					</div>
																				</div>
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Brand Icon:</label>
																					<div class="col-sm-10">
																						<img src="<?php echo "../../brand-icon/".$get_brand_by_id[0]['brand_icon']; ?>" style="height:80px">
																					</div>
																				</div>
																				
																				
																				
																					
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Brand Icon:</label>
																					<div class="col-sm-10">
																						<input type="file" class="form-control" name="icon" id="icon"  onchange="ValidateSingleInput(this);">	
																					</div>
																				</div>	
																					
																				<div class="form-group">	
																				<label class="col-sm-2 control-label">Priority:</label>
																				<div class="col-sm-10">
																					<select id="priority" class="maincls form-control" name="priority" required>
																						<option value="<?php echo $get_brand_by_id[0]['brand_priority'];?>"><?php echo $get_brand_by_id[0]['brand_priority'];?></option>
																						<option value="1">1</option>
																						<option value="2">2</option>
																						<option value="3">3</option>
																						<option value="4">4</option>
																						<option value="5">5</option>
																						<option value="6">6</option>
																						<option value="7">7</option>
																						<option value="8">8</option>
																						<option value="9">9</option>
																						<option value="10">10</option>
																					</select>
																				</div>
																			</div>
																			
																				
																					
																				<input id="submit" onclick="myFunction()" type="submit" name="update" class="btn btn-info pull-right"  value="Update">
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
	
var add_cat = $("#brand").val();
if ($.trim(add_cat) === '')
{
alert("Please Enter Brand Name.");
$('#brand').val('');
$('#brand').focus();
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
