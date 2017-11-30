<!DOCTYPE html>
<html>
<?php
session_start(); 
if(isset($_SESSION['admin_email_id']))
{
	 $admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];

	require_once('controller/admin_controller.php');
	$control	=	new admin();
	
	$banner_id = $_GET['bann_id'];
	// Get Sub Categories List
	$get_banner_list	=	$control->get_banner_by_id($banner_id);  
	 //echo'<pre>';print_r($get_banner_list[0]['banner_title']);

//}		

   if(isset($_POST['update'])){
   		$add_banner	=	$control->add_banner_edit($banner_id);  
		// echo'<pre>';print_r($add_banner);exit;
		if($add_banner==1){	 
			echo '<script>alert("Banner Updated successfully.")</script>';
			echo '<script>window.location.assign("add-banner.php")</script>';
		}

   }													
	
?>
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
															
														</div>

														<div class="panel-body">

															<div class="tab-content">
														
															<div class="tab-pane active">
																		<form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner Title: </label>
																					<div class="col-sm-10">
																					<input type="text" class="form-control" name="banner_title"  value="<?php echo $get_banner_list[0]['banner_title']; ?>" data-required="true">    
																					</div>
																				</div>
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner Img:</label>
																					<div class="col-sm-10">
																						<input type="file" class="form-control" name="banner_image" id="icon"  onchange="ValidateSingleInput(this);"  value="<?php echo $get_banner_list[0]['banner_img']; ?>">	
																					</div>
																					<div class="form-group ">
																					
																					<?php

                                                                                    if($get_banner_list[0]['banner_img']){

                                                                                     	   echo '<center><img  src="../../banner-images/'.$get_banner_list[0]['banner_img'].'" width=200px height="100px"></center>';
                                                                                    }

																					?>
																					
																					</div>
																				</div>
																				 
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner Priority:</label>
																					<div class="col-sm-10">
																						<select id="banner_priority" class="form-control" name="banner_priority" required value="<?php echo $get_banner_list[0]['banner_priority']; ?>">
																							<option value="">Select Priority Option</option>
																							<option value="1" <?php if($get_banner_list[0]['banner_priority'] == 1) { echo 'selected'; } ?>>1</option>
																							<option value="2" <?php if($get_banner_list[0]['banner_priority'] == 2) { echo 'selected'; } ?>>2</option>
																							<option value="3" <?php if($get_banner_list[0]['banner_priority'] == 3) { echo 'selected'; } ?>>3</option>
																							<option value="4" <?php if($get_banner_list[0]['banner_priority'] == 4) { echo 'selected'; } ?>>4</option>
																							<option value="5" <?php if($get_banner_list[0]['banner_priority'] == 5) { echo 'selected'; } ?>>5</option>
																							<option value="6" <?php if($get_banner_list[0]['banner_priority'] == 6) { echo 'selected'; } ?>>6</option>
																							<option value="7" <?php if($get_banner_list[0]['banner_priority'] == 7) { echo 'selected'; } ?>>7</option>
																							<option value="8" <?php if($get_banner_list[0]['banner_priority'] == 8) { echo 'selected'; } ?>>8</option>
																							<option value="9" <?php if($get_banner_list[0]['banner_priority'] == 9) { echo 'selected'; } ?>>9</option>
																							<option value="10" <?php if($get_banner_list[0]['banner_priority'] == 10) { echo 'selected'; } ?>>10</option>
																						</select> 
																					</div>
																				</div>
																				
																				 
																				 	
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner For:</label>
																					<div class="col-sm-10">
																						<select class="form-control" name="banner_for" value="<?php echo $get_banner_list[0]['banner_for']; ?>">
																							<option value="">Select Option</option>
																							<option value="1" <?php if($get_banner_list[0]['banner_for']==1) { echo 'selected'; } ?>>Application</option>
																							<option value="2" <?php if($get_banner_list[0]['banner_for']==2) { echo 'selected'; } ?>>Website</option> 
																						</select> 
																					</div>
																				</div>
																				 	
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner URL:</label>
																					<div class="col-sm-10">
																							<input type="url" class="form-control" name="banner_url" value="<?php echo $get_banner_list[0]['banner_url']; ?>" data-required="false">    
																					</div>
																				</div>
																				
																				
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Banner Screen For:</label>
																					<div class="col-sm-10">
																						<select class="form-control" name="banner_screens_for" value="<?php echo $get_banner_list[0]['banner_screens_for']; ?>" required>
																							<option value="">Select Option</option>
																							<option value="1" <?php if($get_banner_list[0]['banner_screens_for']==1) { echo 'selected'; } ?>>Home Screen</option>
																							<option value="2" <?php if($get_banner_list[0]['banner_screens_for']==2) { echo 'selected'; } ?>>AMC Screen</option> 
																						</select> 
																					</div>
																				</div>
																				
																				<input id="submit"  type="submit" name="update" class="btn btn-info pull-right"  value="Update">
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
<?php } ?>



