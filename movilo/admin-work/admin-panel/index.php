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
	 
	 //echo  $ar_id  	= $_SESSION['ar_id'];
	require_once('controller/admin_controller.php');
	$control	=	new admin();
	 
	$get_user_list = $control->get_user_list();
	$get_brand = $control->get_brand();
	$get_brand_product = $control->get_brand_product();
	$get_category = $control->get_category();
	// echo '<pre>';print_r($get_brand_product);
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
                <div class="row  border-bottom white-bg dashboard-header">

                     <div class="col-sm-12">
                        <h2>Welcome <?php echo ucfirst($admin_name);?> </h2>
						<div class="statistic-box">
							<p>
								Admin Name: <?php echo $admin_email_id;?>
							</p>
							<p>
								Phone No: <?php echo $admin_phone_no;?>
							</p>
							<p>
							   Last Login: <?php echo $admin_last_login;?>
							</p>
                        </div>
                    </div>
				</div>
				
				
				 <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                        <div class="row">
							<div class="col-lg-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
										<div class="media-body ">
										    <h2>Brands</h2>
											<table class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
												<tr>
														<th>S.No</th>
														<th>Brand Name</th>
													
													
												</tr>
												</thead>
												<tbody>
												<?php for($i=0;$i<count($get_brand);$i++){ ?>
													<tr>
														<td><?php echo $i+1; ?></td>
														<td><?php echo $get_brand[$i]['brand_name']; ?></td>
													</tr>
												<?php } ?>
												</tbody>
												<tr>
													<td colspan="3"><a href="brand-list.php"><button class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Show More</button></a></td>
												</tr>
											</table> 
										</div>
                                    </div>
                                </div>
                            </div>
							
							
                            <div class="col-lg-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
										<div class="media-body ">
										   <h2>Brand Product List</h2>
											<table class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
												<tr>
														<th>S.No</th>
														<th>Brand </th>
														<th>Brand Product</th>
													
													
												</tr>
												</thead>
												<tbody>
												<?php 
												if(count($get_user_list)>=6){
													$k=6;
												}else{
													$k=count($get_user_list)-1;
												}
												
												for($i=0;$i<$k;$i++){ ?>
													<tr>
														<td><?php echo $i+1; ?></td>
														<td><?php echo $get_brand_product[$i]['brand_name']; ?></td>
														<td><?php echo $get_brand_product[$i]['p_category_name']; ?></td>
													</tr>
												<?php } ?>
												</tbody>
												<tr>
													<td colspan="3"><a href="brand-products.php"><button class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Show More</button></a></td>
												</tr>
											</table> 
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

		
		
		
        <div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                        <div class="row">
						
						
							  <div class="col-lg-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
										<div class="media-body ">
										   <h2>Category List</h2>
											<table class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
												<tr>
														<th>S.No</th>
														<th>Brand </th>
														<th>Brand Product</th>
													
													
												</tr>
												</thead>
												<tbody>
												<?php 
												if(count($get_category)>=6){
													$k=6;
												}else{
													$k=count($get_category)-1;
												}
												$j=1;
												for($i=0;$i<$k;$i++){ ?>
													<tr>
														<td><?php echo  $j; ?></td>
														<td><?php echo $get_category[$i]['p_category_name']; ?></td>
														<td><img src="<?php echo "../../product-icon/".$get_category[$i]['p_category_icon_small']; ?>" style="height:40px"></td>
													</tr>
												<?php $j++;} ?>
												</tbody>
												<tr>
													<td colspan="3"><a href="brand-products.php"><button class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Show More</button></a></td>
												</tr>
											</table> 
										</div>
                                    </div>
                                </div>
                            </div>
							
							
							
							
							
                            <div class="col-lg-6">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>Registartions</h5>
                                        <div class="ibox-tools">
                                            <span class="label label-warning-light"> No of Reg User: <?php echo count($get_user_list);?></span>
                                           </div>
                                    </div>
                                    <div class="ibox-content">

                                         <div class="feed-activity-list">
											<?php 
											if(count($get_user_list)>=6){
												$j=6;
											}else{
												$j=count($get_user_list);
											}
											
											for($i=0;$i<$j;$i++){ ?>
											<div class="feed-element">
												<!--<a href="user_view.php?id=<?php echo $get_user_list[$i]['user_id'];?>" class="pull-left">
													<img alt="image" class="img-circle" src="<?php echo '../../user_profile/'.$get_user_list[$i]['image'];?>">
												</a>-->
												<div class="media-body ">
													<small class="pull-right"><i class="fa fa-calendar"></i> <?php echo $get_user_list[$i]['user_created_date']; ?> </small>
													<a href="get_user_list.php?id=<?php echo $get_user_list[$i]['user_id'];?>" class="pull-left"> <i class="fa fa-user"></i> <strong> <?php echo $get_user_list[$i]['user_name'];?> </strong> </a><br>
													<small class="text-muted"><i class="fa fa-mobile"></i>  <?php echo $get_user_list[$i]['user_phone']; ?> <i class="fa fa-envelope-o"></i>  <?php echo $get_user_list[$i]['user_email_id']; ?> </small><br>
													<small class="text-muted"><i class="fa fa-map-marker"></i> <?php echo $get_user_list[$i]['user_address']; ?> </small>

												</div>
										</div>
										<?php }?>
										</div>
										<a href="users.php"><button class="btn btn-primary btn-block m-t"><i class="fa fa-arrow-down"></i> Show More</button></a>

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
