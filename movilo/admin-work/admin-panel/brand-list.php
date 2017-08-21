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
	
	
	// Get Sub Categories List
	$get_brand = $control->get_brand();
	// print_r($get_brand);
	
	if(isset($_POST['brand']))
	{
		$res = $control->add_brand();
		if(!empty($res))
		{
				echo '<script>alert("Brand added successfully.")</script>';
				echo '<script>window.location.assign("brand-list.php")</script>';
		}
	}
	
	
	
	//Deactive
	if(isset($_POST['deactive']))
	{	
		$del_brand	=	$control->deactive_brand();
		// print_r($update_main_category);exit;
		if(!empty($del_brand)){
			echo '<script>alert("Brand deactivated successfully.")</script>';
			echo '<script>window.location.assign("brand-list.php")</script>';
		}
	}
	
	
	
	//Active
	if(isset($_POST['active']))
	{	
		$del_brand	=	$control->active_brand();
		// print_r($update_main_category);exit;
		if(!empty($del_brand)){
			echo '<script>alert("Brand activated successfully.")</script>';
			echo '<script>window.location.assign("brand-list.php")</script>';
		}
	}
	
	
	
	//delete
	if(isset($_POST['delete']))
	{	
		$del_brand	=	$control->del_brand();
		// print_r($update_main_category);exit;
		if(!empty($del_brand)){
			echo '<script>alert("Brand deleted successfully.")</script>';
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
              
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-10">
				<h2>Brand  List</h2>
				<ol class="breadcrumb">
					<li>
						<a href="index.php">Home</a>
					</li>
					<li class="active">
						<strong>Brand  List</strong>
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
										<div class="media-body">
										   <div class="row m-t-sm">
												<div class="col-lg-12">
													<div class="panel blank-panel">
														<div class="panel-heading">
															<div class="panel-options">
																<ul class="nav nav-tabs">
																	<li class="active"><a href="#tab-1" data-toggle="tab"> Brand List</a></li>
																	<li class=""><a href="#tab-2" data-toggle="tab">Add Brand</a></li>
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
																				<th>Brand Name</th>
																				<th>Brand Icon</th>
																				<th>Priority </th>
																				<th>Edit</th>
																				<th>Delete</th>
																			
																			
																		</tr>
																		</thead>
																		<tbody>
																		<?php $j=1;?>
																		<?php for($i=0;$i<count($get_brand);$i++){ ?>
																			<tr>
																				<td><?php echo  $j; ?></td>
																				<td><?php echo $get_brand[$i]['brand_name']; ?></td>
																				<td><img src="<?php echo "../../brand-icon/".$get_brand[$i]['brand_icon']; ?>" style="height:40px"></td> 
																				
																				<td><?php echo $get_brand[$i]['brand_priority']; ?></td>
																				
																				<td><a href="brand-list-edit.php?id=<?php echo $get_brand[$i]['brand_id'];?>" class="pull-left" ><button class="edit_profile btn btn-info"><i class="fa fa-edit"></i> Edit</button></a></td>
																				
																				<?php if($get_brand[$i]['brand_status']==1){?>
																				<td>
																					<form id="form" method="POST">
																							<input type="hidden" class="form-control" value="<?php echo $get_brand[$i]['brand_id']?>" name="id" required>	
																						<input id="submit" onclick="return confirm('Are you sure you want to deactivate this brand?');" type="submit" name="deactive" class="delete_profile btn btn-danger" value="Deactivate">
																					</form>
																				</td>
																				<?php } else{ ?>
																				<td>
																					<form id="form" method="POST">
																							<input type="hidden" class="form-control" value="<?php echo $get_brand[$i]['brand_id']?>" name="id" required>	
																						<input id="submit" onclick="return confirm('Are you sure you want to activate this brand?');" type="submit" name="active" class="delete_profile btn btn-success" value="Activate">
																					</form>
																				</td><?php } ?>
																			</tr>
																		<?php $j++; } ?>
																		</tbody>
																	</table>  
																</div>
															
																<div class="tab-pane" id="tab-2">
																		<form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																				<div class="form-group"><label class="col-sm-2 control-label">Brand Name:</label>
																					<div class="col-sm-10">
																					<input type="text" class="form-control" name="brand" id="brand" required>	
																					</div>
																				</div>
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Brand Icon:</label>
																					<div class="col-sm-10">
																						<input type="file" class="form-control" name="icon" id="icon" required onchange="ValidateSingleInput(this);">	
																					</div>
																				</div>
																				
																				
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Priority:</label>
																					<div class="col-sm-10">
																						<select id="priority" class="form-control" name="priority" required>
																							<option value="">Select Priority Option</option>
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
