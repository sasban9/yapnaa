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
	
	
	// Get get_particular_user_details
	$id	=$_REQUEST['id'];
	$get_particular_user_details = $control->get_particular_user_details($id);
	// echo  '<pre>';
	// print_r($get_particular_user_details);
	
	
	
	
	// Get User product List
	$get_particular_user_product_list = $control->get_particular_user_product_list($id);
	// echo  '<pre>';
	// print_r($get_particular_user_product_list);
	
	
	
	
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
                    <h2>Profile</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="users.php">Users List</a>
                        </li>
                        <li class="active">
                            <strong>Profile</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
        <div class="wrapper wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-md-4">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Profile Detail</h5>
                        </div>
                        <div>
                            <div class="ibox-content no-padding border-left-right">
                                <img alt="image" class="img-responsive" src="img/profile.png" style="margin-left: 30%;height:100px">
                            </div>
                            <div class="ibox-content profile-content">
                                <p><i class="fa fa-user"></i>
									<?php if($get_particular_user_details[0]['user_name']){
										echo $get_particular_user_details[0]['user_name'];
										}else{
											echo 'Anonymous';
										};?>
								</p>
													
                                <p><i class="fa fa-mobile"></i> <?php echo $get_particular_user_details[0]['user_phone'];?></p>
                                <p><i class="fa fa-envelope-o"></i> <?php echo $get_particular_user_details[0]['user_email_id'];?></p>
                                <p><i class="fa fa-globe"></i> <?php echo  $get_particular_user_details[0]['user_address'].', '.$get_particular_user_details[0]['user_city'];?></p>
                                <p><i class="fa fa-map-marker"></i> <?php echo $get_particular_user_details[0]['user_area_pincode'];?></p>
                               
							   <?php if(!empty($get_particular_user_details[0]['user_lat'])){?>
								<p><i class="fa fa-globe"></i> <?php echo $get_particular_user_details[0]['user_lat'].','.$get_particular_user_details[0]['user_lang'];?></p>
								<?php  }?>
                                <p><i class="fa fa-clock-o"></i> <?php echo $get_particular_user_details[0]['user_created_date'];?> (Profile Created Date)</p>
                                <p><i class="fa fa-sign-out"></i> <?php echo $get_particular_user_details[0]['user_last_login'];?> (Last Login)</p>
								
                                
                            </div>
                    </div>
                </div>
                    </div>
                <div class="col-md-8">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Product List</h5>
                        </div>
                        <div class="ibox-content">

                            <div>
                                <div class="feed-activity-list">

                                    <div class="tab-content">
										<div class="tab-pane active" id="tab-1">
											  <table class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
												<tr>
														<th>S.No</th>
														<th>Product Name  </th>
														<th>Brand Name </th>
														<th>Serial No</th>
														<th>Action</th>
													
													
												</tr>
												</thead>
												<tbody>
												<?php $j=1;?>
												<?php for($i=0;$i<count($get_particular_user_product_list);$i++){ ?>
													<tr>
														<td><?php echo  $j; ?></td>
														<td><a href="user-product-details.php?id=<?php echo $get_particular_user_product_list[$i]['up_id']; ?>" target="_blank"><?php echo $get_particular_user_product_list[$i]['p_category_name']; ?></a></td>
														<td><?php echo $get_particular_user_product_list[$i]['brand_name']; ?></td>
														<td><?php echo $get_particular_user_product_list[$i]['up_serial_no']; ?></td>
														<td><?php if( $get_particular_user_product_list[$i]['up_user_status']==1){
																echo "<span style='color:green'> In List </span>";}else{
																echo "<span style='color:red'> Deleted </span>";} ?></td>
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
