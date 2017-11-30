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
	$get_banner_list	=	$control->get_banner_list();  
	// echo'<pre>';print_r($get_category);
	
		
	/*add_banner form submission*/
	if(isset($_POST['submit']))
	{   
		$add_banner	=	$control->add_banner();  
		// echo'<pre>';print_r($add_banner);exit;
		if($add_banner==1){	 
			echo '<script>alert("Banner added successfully.")</script>';
			echo '<script>window.location.assign("add-banner.php")</script>';
		}elseif($add_banner==2){
			echo '<script>alert("Banner Title already added.")</script>';
			echo '<script>window.location.assign("add-banner.php")</script>';
		}else{
			echo '<script>alert("Something went wrong.")</script>';
			echo '<script>window.location.assign("add-banner.php")</script>';
		}
	}

	
	
		//Deactive
	if(isset($_POST['deactive']))
	{	
		$deactive_main_category	=	$control->deactive_banner();
		// print_r($update_main_category);exit;
		if(!empty($deactive_main_category)){
			echo '<script>alert("Banner deactivated successfully.")</script>';
			echo '<script>window.location.assign("add-banner.php")</script>';
		}
	}



	//Active
	if(isset($_POST['activate']))
	{	
		$activate_main_category	=	$control->activate_banner();
		// print_r($update_main_category);exit;
		if(!empty($activate_main_category)){
			echo '<script>alert("Banner activated successfully.")</script>';
			echo '<script>window.location.assign("add-banner.php")</script>';
		} 
	}


	//Edit
	if(isset($_POST['edit']))
	{	

		//echo '<table>';
		//echo '<tr>';
		//echo '<td>'.$_POST['banner_id'].'</td>';
		//echo '</tr>';
		//echo '</table>';
		 $banner_id = $_POST['id'];
        echo '<script>window.location.assign("add-edit.php?bann_id='.$banner_id.'")</script>';

        /*
		$activate_main_category	=	$control->edit_banner();
		// print_r($update_main_category);exit;
		if(!empty($activate_main_category)){
			echo '<script>alert("Banner Updated successfully.")</script>';
			echo '<script>window.location.assign("add-banner.php")</script>';
		} 
		*/
	}

	//delete
	if(isset($_POST['delete']))
	{	
		$delete_main_category	=	$control->delete_banner();
		// print_r($update_main_category);exit;
		if(!empty($delete_main_category)){
			echo '<script>alert("Banner deleted successfully.")</script>';
			echo '<script>window.location.assign("add-banner.php")</script>';
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
				<h2>Product Category  List</h2>
				<ol class="breadcrumb">
					<li>
						<a href="index.php">Home</a>
					</li>
					<li class="active">
						<strong>Product Category  List</strong>
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
																	<li class="active"><a href="#tab-1" data-toggle="tab">Banner For Home Screen </a></li>
																	<li><a href="#tab-3" data-toggle="tab">Banner For AMC Screen</a></li>
																	<li class=""><a href="#tab-2" data-toggle="tab">Add Banners  </a></li>
																</ul>
															</div>
														</div>

														<div class="panel-body">

															<div class="tab-content">
																<div class="tab-pane active" id="tab-1">
																	 <table class="table table-striped m-b-none" id="mc_table">
																		<thead>
																		  <tr>
																			<th width="20%">Sl.No</th>
																			<th width="20%">Banner Title</th>
																			<th width="25%">Banner  Priority</th>
																			<th width="25%">Banner For</th>
																			<th width="25%">Banner Screen</th>
																			<th width="25%">Img</th>
																		<!--	<th width="15%">Edit</th>-->
																			<th width="25%">Action</th>
																			<th width="15%">Edit</th>
																			<th width="15%">Delete</th>
																		  </tr>
																		</thead>
																		<tbody>
																		<?php $j=1;?>
																		<?php for($i=0;$i<count($get_banner_list);$i++){ ?>
																			<?php if($get_banner_list[$i]['banner_screens_for']==1){ ?>
																			<tr>
																				<td><?php echo  $j; ?></td> 
																				
																				<td><?php echo $get_banner_list[$i]['banner_title']; ?></td>
																				<td><?php echo $get_banner_list[$i]['banner_priority']; ?></td>
																				<td><?php if($get_banner_list[$i]['banner_for']==1){
																						echo "Application";
																					}else{
																						echo "Website";
																					} ?>
																				</td>
																				
																				
																				<td><?php if($get_banner_list[$i]['banner_screens_for']==1){
																						echo "Home Screen";
																					}elseif($get_banner_list[$i]['banner_screens_for']==2){
																						echo "AMC Screen";
																					}else{
																						echo "All";
																					} ?>
																				</td>
																				
																				
																				<td><img src="../../banner-images/<?php echo$get_banner_list[$i]['banner_img'];?>" class="img-circle" style="height:100px;width:100px"></td> 
																				
																				
																				
																				
																				<!--<td><a href="brand-list-edit.php?id=<?php echo $get_banner_list[$i]['banner_id'];?>" class="pull-left" ><button class="edit_profile btn btn-info"><i class="fa fa-edit"></i> Edit</button></a></td>-->
																				
																				
																				
																				<?php if($get_banner_list[$i]['banner_status']==1){?>
																				<td>
																					<form id="form" method="POST">
																						<input type="hidden" class="form-control" value="<?php echo $get_banner_list[$i]['banner_id']?>" name="id" required>	
																						<button type="submit" name="deactive" class="btn btn-danger btn-s-xs" onclick="return confirm('Are you sure you want to deactivate this item?');" ><i class="fa fa-ban"></i> Deactivate</button>  
																					</form>
																				</td>
																				<?php } else{ ?>
																				<td>
																					<form id="form" method="POST">
																						<input type="hidden" class="form-control" value="<?php echo $get_banner_list[$i]['banner_id']?>" name="id" required>	
																						<button type="submit" name="activate" class="btn btn-success btn-s-xs" onclick="return confirm('Are you sure you want to activate this item?');" ><i class="fa fa-check"></i> Activate</button>   
																					</form>
																				</td><?php } ?> 
																				 
																				<td>
																					<form id="form" method="POST">
																						<input type="hidden" class="form-control" value="<?php echo $get_banner_list[$i]['banner_id']?>" name="id" required>	
																						<button type="submit" name="edit" class="btn">Edit</button> 
																					</form>
																				</td> 
																				<td>
																					<form id="form" method="POST">
																						<input type="hidden" class="form-control" value="<?php echo $get_banner_list[$i]['banner_id']?>" name="id" required>	
																						<input type="hidden" class="form-control" value="<?php echo $get_banner_list[$i]['banner_img']?>" name="banner_img" required>	
																						<button type="submit" name="delete" class="btn btn-danger btn-s-xs" onclick="return confirm('Are you sure you want to delte this item?');"><i class="fa fa-times"></i> Delete</button> 
																					</form>
																				</td> 
																				
																				
																			</tr>
																		<?php $j++; } }?>
																		</tbody>
																	  </table>
																</div>
															
															
															
															
																<div class="tab-pane" id="tab-3">
																	 <table class="table table-striped m-b-none" id="mc_table">
																		<thead>
																		  <tr>
																			<th width="20%">Sl.No</th>
																			<th width="20%">Banner Title</th>
																			<th width="25%">Banner  Priority</th>
																			<th width="25%">Banner For</th>
																			<th width="25%">Banner Screen</th>
																			<th width="25%">Img</th>
																			<!--<th width="15%">Edit</th>-->
																			<th width="25%">Action</th>
																			<th width="15%">Delete</th>
																		  </tr>
																		</thead>
																		<tbody>
																		<?php $j=1;?>
																		<?php for($i=0;$i<count($get_banner_list);$i++){ ?>
																			<?php if($get_banner_list[$i]['banner_screens_for']==2){ ?>
																			<tr>
																				<td><?php echo  $j; ?></td> 
																				
																				<td><?php echo $get_banner_list[$i]['banner_title']; ?></td>
																				<td><?php echo $get_banner_list[$i]['banner_priority']; ?></td>
																				<td><?php if($get_banner_list[$i]['banner_for']==1){
																						echo "Application";
																					}else{
																						echo "Website";
																					} ?>
																				</td>
																				
																				
																				<td><?php if($get_banner_list[$i]['banner_screens_for']==1){
																						echo "Home Screen";
																					}elseif($get_banner_list[$i]['banner_screens_for']==2){
																						echo "AMC Screen";
																					}else{
																						echo "All";
																					} ?>
																				</td>
																				
																				
																				<td><img src="../../banner-images/<?php echo$get_banner_list[$i]['banner_img'];?>" class="img-circle" style="height:100px;width:100px"></td> 
																				
																				
																				
																				
																				<!--<td><a href="brand-list-edit.php?id=<?php echo $get_banner_list[$i]['banner_id'];?>" class="pull-left" ><button class="edit_profile btn btn-info"><i class="fa fa-edit"></i> Edit</button></a></td>-->
																				
																				
																				
																				<?php if($get_banner_list[$i]['banner_status']==1){?>
																				<td>
																					<form id="form" method="POST">
																						<input type="hidden" class="form-control" value="<?php echo $get_banner_list[$i]['banner_id']?>" name="id" required>	
																						<button type="submit" name="deactive" class="btn btn-danger btn-s-xs" onclick="return confirm('Are you sure you want to deactivate this item?');" ><i class="fa fa-ban"></i> Deactivate</button>  
																					</form>
																				</td>
																				<?php } else{ ?>
																				<td>
																					<form id="form" method="POST">
																						<input type="hidden" class="form-control" value="<?php echo $get_banner_list[$i]['banner_id']?>" name="id" required>	
																						<button type="submit" name="activate" class="btn btn-success btn-s-xs" onclick="return confirm('Are you sure you want to activate this item?');" ><i class="fa fa-check"></i> Activate</button>   
																					</form>
																				</td><?php } ?> 
																				 
																				 
																				<td>
																					<form id="form" method="POST">
																						<input type="hidden" class="form-control" value="<?php echo $get_banner_list[$i]['banner_id']?>" name="id" required>	
																						<input type="hidden" class="form-control" value="<?php echo $get_banner_list[$i]['banner_img']?>" name="banner_img" required>	
																						<button type="submit" name="delete" class="btn btn-danger btn-s-xs" onclick="return confirm('Are you sure you want to delte this item?');"><i class="fa fa-times"></i> Delete</button> 
																					</form>
																				</td> 
																				
																				
																			</tr>
																		<?php $j++; } }?>
																		</tbody>
																	  </table>
																</div>
																
																
																
																
																
																<div class="tab-pane" id="tab-2">
																		<form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																				<div class="form-group"><label class="col-sm-2 control-label">Banner Title: </label>
																					<div class="col-sm-10">
																					<input type="text" class="form-control" name="banner_title" placeholder="Enter Banner Title" data-required="true">    
																					</div>
																				</div>
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner Img:</label>
																					<div class="col-sm-10">
																						<input type="file" class="form-control" name="banner_image" id="icon" required onchange="ValidateSingleInput(this);">	
																					</div>
																				</div>
																				 
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner Priority:</label>
																					<div class="col-sm-10">
																						<select id="banner_priority" class="form-control" name="banner_priority" required>
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
																				
																				 
																				 	
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner For:</label>
																					<div class="col-sm-10">
																						<select class="form-control" name="banner_for">
																							<option value="">Select Option</option>
																							<option value="1">Application</option>
																							<option value="2">Website</option> 
																						</select> 
																					</div>
																				</div>
																				 	
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner URL:</label>
																					<div class="col-sm-10">
																							<input type="url" class="form-control" name="banner_url" placeholder="Enter Banner URL" data-required="false">    
																					</div>
																				</div>
																				
																				
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner Screen For:</label>
																					<div class="col-sm-10">
																						<select class="form-control" name="banner_screens_for" required>
																							<option value="">Select Option</option>
																							<option value="1">Home Screen</option>
																							<option value="2">AMC Screen</option> 
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
	
// var add_cat = $("#category").val();
// if ($.trim(add_cat) === '')
// {
// alert("Please Enter Category Name.");
// $('#category').val('');
// $('#category').focus();
 // return false;
// }


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
