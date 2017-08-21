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
	$srm_request_list = $control->srm_request_list();
	// echo  '<pre>';
	// print_r($srm_request_list);
	
	//Generate MVQ
	if(isset($_POST['submit']))
	{	
		$srm_request_mvq_convert	=	$control->srm_request_mvq_convert();
		// print_r($update_main_category);exit;
		if(!empty($srm_request_mvq_convert)){
			echo '<script>alert("MVQ generated succefully.")</script>';
			echo '<script>window.location.assign("srm-requests.php")</script>';
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
				<h2>SRM Request List</h2>
				<ol class="breadcrumb">
					<li>
						<a href="index.php">Home</a>
					</li>
					<li class="active">
						<strong>SRM Request List</strong>
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
																	<!--<li class="active"><a href="#tab-1" data-toggle="tab"> SRM Request List </a></li>-->
																	<li><input id="submit" onclick="return confirm('Are you sure you want to generate SRM request?');" type="submit" name="block" class="btn btn-primary" value="Add New SRM Request"  data-toggle="modal" data-target="#generate_SRM"></li>
																</ul>
															</div>
														</div>
														
														
														 <!-- generate_SRM POP Up -->
														  <div class="modal fade" id="generate_SRM" role="dialog">
															<div class="modal-dialog  modal-sm">
															  <div class="modal-content" style="height: 200px;">
																<div class="modal-header">
																  <button type="button" class="close" data-dismiss="modal">&times;</button>
																  <h4 class="modal-title">Generate MVQ</h4>
																</div>
																<div class="modal-body">
																<form id="form" method="POST" action="generate-srm-for-user.php" id="srm_form">
																	 <div class="form-group has-success">  
																		<label class="control-label">User Phone:</label>
																			<input type="number" class="form-control" name="user_phone" id="user_phone" placeholder="User Phone No" required    style="position: absolute;    z-index: 9999999999;width:80%" autofocus>	<br/>
																			
																			<input id="submit"   type="submit" name="submit" class="btn btn-primary pull-left"  value="Proced To Continue" style=" z-index: 9999999999;position: absolute; margin-top:50px" >
																	</div>
																</form>
																</div>
															  </div>
															</div>
														</div>

														
														
														
														
														
														
														
														<div class="panel-body">

															<div class="tab-content">
																<div class="tab-pane active" id="tab-1">
																	  <table class="table table-striped table-bordered table-hover dataTables-example" >
																		<thead>
																		<tr>
																				<th>S.No</th>
																				<th>Email </th>
																				<th>Phone No</th>
																				<th>Installation</th>
																				<th>City</th>
																				<th>Pincode</th>
																				<th>Address</th>
																				<th>Product Name</th> 
																				<th>Brand Name</th> 
																				<th>View</th>
																				<th>Action</th>
																			
																			
																		</tr>
																		</thead>
																		<tbody>
																		<?php $j=1;?>
																		<?php for($i=0;$i<count($srm_request_list);$i++){ ?>
																			<tr>
																				<td><?php echo  $j; ?></td>
																				<td><a href="user-details.php?id=<?php echo $srm_request_list[$i]['srm_user_id']; ?>" target="_blank"><?php echo $srm_request_list[$i]['user_email_id']; ?></a></td>
																				<td><?php echo $srm_request_list[$i]['user_phone']; ?></td>
																				<td><?php if( $srm_request_list[$i]['srm_installation']){echo $srm_request_list[$i]['srm_installation'].' ('.$srm_request_list[$i]['srm_installation_date'].')'; 
																				}else{
																					echo "No";
																				}?></td> 
																				<td><?php echo $srm_request_list[$i]['user_city']; ?></td>
																				<td><?php echo $srm_request_list[$i]['user_area_pincode']; ?></td>
																				<td><?php echo $srm_request_list[$i]['user_address']; ?></td>
																				<td><?php echo $srm_request_list[$i]['p_category_name']; ?></td>
																				<td><a href="user-product-details.php?id=<?php echo $srm_request_list[$i]['srm_product_id']; ?>" target="_blank"><?php echo $srm_request_list[$i]['brand_name']; ?><a></td> 
																				<td><a href="srm-request-details.php?id=<?php echo $srm_request_list[$i]['srm_id']; ?>">View Details</a></td>
																				<td>
																					<?php if($srm_request_list[$i]['srm_status']==0) {?>
																							<span class="btn btn-primary"> Open</span>
																					<?php }else if($srm_request_list[$i]['srm_status']==2){?>
																							<span class="btn btn-info" >In Progress</span>
																					<?php }else if($srm_request_list[$i]['srm_status']==3){?>
																					<span class="btn btn-info" >Assignining Engineer </span>
																					<?php }else if($srm_request_list[$i]['srm_status']==4){?>
																					<span class="btn btn-success" >SE Assigned</span>
																					<?php }else if($srm_request_list[$i]['srm_status']==5){?>
																					<span class="btn btn-danger" >Service Cancelled</span>
																					<?php }else if($srm_request_list[$i]['srm_status']==6){?>
																					<span class="btn btn-warning" >Ticket Closed</span>
																					<?php }else if($srm_request_list[$i]['srm_status']==7){?>
																					<span class="btn btn-success" >Service Completed</span>
																					<?php }  else{ ?>
																						<span class="btn btn-success" >Completed</span>
																					<?php }?>
																				</td>
																				
																			</tr>
																		<?php $j++; } ?>
																		</tbody>
																	</table>  
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
<script type="text/javascript"
src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript"
src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript">
$(function() {
	var availableTags = <?php include('get_user_list.php'); ?>;
	$("#user_phone").autocomplete({
		source: availableTags,
		autoFocus:true
	});
	
	
});

  
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
