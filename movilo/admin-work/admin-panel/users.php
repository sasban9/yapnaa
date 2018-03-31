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
	$control	=	new admin();
	
	
	if($ar_id ==3 || $ar_id ==4){
		echo '<script>alert("You do not have enough credential.")</script>';
		echo '<script>window.location.assign("index.php")</script>';
	}
	// Get Sub Categories List
	if(isset($_POST['filterSubmit'])){
		$get_user_list = $control->get_filtered_user_list($_POST['filter']);
	}
	else{
		$get_user_list = $control->get_user_list();
	}
	
	
	// echo  '<pre>';
	// print_r($get_user_list);
	
	//user_acitve
	if(isset($_POST['active']))
	{	
		$user_acitve	=	$control->user_acitve();
		// print_r($update_main_category);exit;
		if(!empty($user_acitve)){
			echo '<script>alert("User activated successfully.")</script>';
			echo '<script>window.location.assign("users.php")</script>';
		}
	}
	if(isset($_POST['add_user']))
	{
		$res = $control->add_user();
		if(!empty($res))
		{
				echo '<script>alert("User added successfully.")</script>';
				echo '<script>window.location.assign("users.php")</script>';
		}else{
			echo '<script>alert("User already exist.")</script>';
			echo '<script>window.location.assign("users.php")</script>';
		}
	}
	
	//user_block
	if(isset($_POST['block']))
	{	
		$user_block	=	$control->user_block();
		// print_r($update_main_category);exit;
		if(!empty($user_block)){
			echo '<script>alert("User blocked successfully.")</script>';
			echo '<script>window.location.assign("users.php")</script>';
		}
	}
	
	if(isset($_POST['submit']))
	{	
		$name = $_POST['user_name'];
		$name = $_POST['user_email'];
		$name = $_POST['user_mobile'];
		$user_block	=	$control->user_block();
		
		// print_r($update_main_category);exit;
		if(!empty($user_block)){
			echo '<script>alert("User blocked successfully.")</script>';
			echo '<script>window.location.assign("users.php")</script>';
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
                    <h2>User List</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li class="active">
                            <strong>User List</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
			<div>
				<form method="post" action="">
					<select name="filter">
						<option value="0">All</option>
						<option value="1">Zero B Customers</option>
						<option value="2">livpure Customers</option>
						<option value="3">General Customers</option>
					
					</select>
					<input type="submit" class="btn btn-info" name="filterSubmit" value="Filter">
				</form>
			</div>
<!--          
		  
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
					<thead>
					<tr>
							<th>S.No</th>
							<th>Email </th>
							<th>Phone No</th>
							<th>City</th>
							<th>Pincode</th>
							<th>Address</th>
							<th>Action</th>
						
						
					</tr>
					</thead>
					<tbody>
					<?php $j=1;?>
					<?php 
					$numbers = array_column($get_user_list,"user_phone");
					for($i=0;$i<count($get_user_list);$i++){ ?>
						<tr>
							<td><?php echo  $j; ?></td>
							<td><a href="user-details.php?id=<?php echo $get_user_list[$i]['user_id']; ?>"><?php echo $get_user_list[$i]['user_email_id']; ?></a></td>
							<td><a href="user-details.php?id=<?php echo $get_user_list[$i]['user_id']; ?>"><?php echo $get_user_list[$i]['user_phone']; ?></td>
							<td><?php echo $get_user_list[$i]['user_city']; ?></a></td>
							<td><?php echo $get_user_list[$i]['user_area_pincode']; ?></td>
							<td><?php echo $get_user_list[$i]['user_address']; ?></td>
							
							<td>
								<?php if($get_user_list[$i]['user_status']==1) {?>
								
									<form id="form" method="POST">
										<input type="hidden" class="form-control" value="<?php echo $get_user_list[$i]['user_id']?>" name="id" required>	
										<input id="submit" onclick="return confirm('Are you sure you want to activate this user?');" type="submit" name="block" class="delete_profile btn btn-danger" value="Block">
									</form>
								<?php } else { ?>
									<form id="form" method="POST">
										<input type="hidden" class="form-control" value="<?php echo 		$get_user_list[$i]['user_id']?>" name="id" required>	
										<input id="submit" onclick="return confirm('Are you sure you want to activate this user?');" type="submit" name="active" class="delete_profile btn btn-info" value="Activate">
									</form>
									<?php } ?>
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
        
-->
               
			   
	
		
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
																	<li class="active"><a href="#tab-1" data-toggle="tab"> Users List</a></li>
																	<li class=""><a href="#tab-2" data-toggle="tab">Add Users</a></li>
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
							<th>Name</th>
							<th>Email </th>
							<th>Phone No</th>
							<th>City</th>
							
							<th>Address</th>
							<th>Action</th>
						
						
					</tr>
					</thead>
					<tbody>
					<?php $j=1;?>
					<?php for($i=0;$i<count($get_user_list);$i++){ ?>
						<tr>
							<td><?php echo  $j; ?></td>
							<td><a href="user-details.php?id=<?php echo $get_user_list[$i]['user_id']; ?>"><?php echo $get_user_list[$i]['user_name']; ?></a></td>
							<td><a href="user-details.php?id=<?php echo $get_user_list[$i]['user_id']; ?>"><?php echo $get_user_list[$i]['user_email_id']; ?></a></td>
							<td><a href="user-details.php?id=<?php echo $get_user_list[$i]['user_id']; ?>"><?php echo $get_user_list[$i]['user_phone']; ?></td>
							<td><?php echo $get_user_list[$i]['user_city']; ?></a></td>
							
							<td><?php echo $get_user_list[$i]['user_address']; ?></td>
							
							<td>
								<?php if($get_user_list[$i]['user_status']==1) {?>
								
									<form id="form" method="POST">
										<input type="hidden" class="form-control" value="<?php echo $get_user_list[$i]['user_id']?>" name="id" required>	
										<input id="submit" onclick="return confirm('Are you sure you want to activate this user?');" type="submit" name="block" class="delete_profile btn btn-danger" value="Block">
									</form>
								<?php } else { ?>
									<form id="form" method="POST">
										<input type="hidden" class="form-control" value="<?php echo 		$get_user_list[$i]['user_id']?>" name="id" required>	
										<input id="submit" onclick="return confirm('Are you sure you want to activate this user?');" type="submit" name="active" class="delete_profile btn btn-info" value="Activate">
									</form>
									<?php } ?>
							</td>
							
						</tr>
					<?php $j++; } ?>
					</tbody>
				</table> 
						                                    <button type="button" class="btn btn-success" name="sendAllSubmit" id="sendAllSubmit">
																<i class="fa fa-envelope"></i> Send SMS for All
															</button>										
															</div>
															
																<div class="tab-pane" id="tab-2">
																		<form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																				
																			<div class="form-group">
																				<label class="col-sm-2 control-label">User Name:</label>
																				<div class="col-sm-10">
																					<input type="text" placeholder="Enter a name" name="user_name" class="maincls form-control"  maxlength="60"required/>
																				</div>
																			</div>	
																			<div class="form-group">
																				<label class="col-sm-2 control-label">Email ID:</label>
																				<div class="col-sm-10">
																					<input type="text" placeholder="Enter user email id" name="user_email"  class="maincls form-control"  maxlength="60"/>
																				</div>
																			</div>	
																			<div class="form-group">
																				<label class="col-sm-2 control-label">Mobile Number:</label>
																				<div class="col-sm-10">
																					<input type="number" placeholder="Enter user mobile" name="user_mobile"  class="maincls form-control"  maxlength="10" required/>
																				</div>
																			</div>
																			
																				
																				<input id="add_user" onclick="myFunction()" type="submit" name="add_user" class="btn btn-info pull-right"  value="Add">
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
		<div class="row">
				
		</div>
          		   
			   
			   
			   
			   
			   
<?php include "footer.php";?>

    <!-- Mainly scripts 
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>-->
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                responsive: true,
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });

			$("#sendAllSubmit").click(function(){
				localStorage.setItem('numbers','<?php echo implode(",",array_values($numbers));?>');
				location.href = "send-sms.php";
			});

        });

	
    </script>
</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/table_data_tables.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:53:35 GMT -->
</html>

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
