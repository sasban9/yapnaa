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
	
	// Get get_brand List
	$get_brand = $control->get_brand();
	// print_r($get_brand);
	
	
	
	// Get get_brand_product List
	$get_brand_product = $control->get_brand_product();
	// echo '<pre>';
	// print_r($get_brand_product);
	
	
	
	// Get Sub Categories List
	$get_category = $control->get_category();
	// echo'<pre>';print_r($get_category);
	
	
	
	
	if(isset($_POST['submit']))
	{
		$res = $control->add_brand_product();
		if(!empty($res))
		{
				echo '<script>alert("Brand product added successfully.")</script>';
				echo '<script>window.location.assign("brand-products.php")</script>';
		}else{
			echo '<script>alert("This brand products category already exist.")</script>';
			echo '<script>window.location.assign("brand-products.php")</script>';
		}
	}
	
	
	
	
	//Deactive
	if(isset($_POST['deactive']))
	{	
		$del_brand	=	$control->deactive_brand_products();
		// print_r($update_main_category);exit;
		if(!empty($del_brand)){
			echo '<script>alert("Brand product deactivated successfully.")</script>';
			echo '<script>window.location.assign("brand-products.php")</script>';
		}
	}
	
	
	
	//Active
	if(isset($_POST['active']))
	{	
		$del_brand	=	$control->active_brand_products();
		// print_r($update_main_category);exit;
		if(!empty($del_brand)){
			echo '<script>alert("Brand product activated successfully.")</script>';
			echo '<script>window.location.assign("brand-products.php")</script>';
		}
	}
	
	
	
	
	//delete
	if(isset($_POST['delete']))
	{	
		$del_brand_product	=	$control->del_brand_product();
		// print_r($update_main_category);exit;
		if(!empty($del_brand_product)){
			echo '<script>alert("Brand deleted successfully.")</script>';
			echo '<script>window.location.assign("brand-products.php")</script>';
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
				<h2>Brand Products List</h2>
				<ol class="breadcrumb">
					<li>
						<a href="index.php">Home</a>
					</li>
					<li class="active">
						<strong>Brand Products List</strong>
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
																	<li class="active"><a href="#tab-1" data-toggle="tab"> Brand Product List</a></li>
																	<li class=""><a href="#tab-2" data-toggle="tab">Add Brand Product</a></li>
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
																				<th>Brand Product Name</th>
																				<th>Product Icon</th>
																				<th>Edit</th>
																				<th>Delete</th>
																			
																			
																		</tr>
																		</thead>
																		<tbody>
																		<?php $j=1;?>
																		<?php for($i=0;$i<count($get_brand_product);$i++){ ?>
																			<tr>
																				<td><?php echo  $j; ?></td>
																				<td><?php echo $get_brand_product[$i]['brand_name']; ?></td>
																				<td><?php echo $get_brand_product[$i]['p_category_name']; ?></td>
																				<td><img src="<?php echo "../../product-icon/".$get_brand_product[$i]['p_category_icon_small']; ?>" style="height:40px"></td>
																				<td><a href="brand-products-edit.php?id=<?php echo $get_brand_product[$i]['product_id'];?>" class="pull-left" ><button class="edit_profile btn btn-info"><i class="fa fa-edit"></i> Edit</button></a></td>
																				
																				<?php if($get_brand_product[$i]['product_status']==1){?>
																				<td>
																					<form id="form" method="POST">
																							<input type="hidden" class="form-control" value="<?php echo $get_brand_product[$i]['product_id']?>" name="id" required>	
																						<input id="submit" onclick="return confirm('Are you sure you want to deactivate this brand product?');" type="submit" name="deactive" class="delete_profile btn btn-danger" value="Deactivate">
																					</form>
																				</td>
																				<?php } else{ ?>
																				<td>
																					<form id="form" method="POST">
																							<input type="hidden" class="form-control" value="<?php echo $get_brand_product[$i]['product_id']?>" name="id" required>	
																						<input id="submit" onclick="return confirm('Are you sure you want to activate this brand product?');" type="submit" name="active" class="delete_profile btn btn-success" value="Activate">
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
																				
																				<div class="form-group"><label class="col-sm-2 control-label">Select Brand Name:</label>
																				<div class="col-sm-10">
																					<select id="brdnadid" class="maincls form-control" name="brdnadid" required>
																						<option value="">Select brand
																						</option>
																						<?php for($i=0;$i<count($get_brand);$i++){?>
																						<option value="<?php echo $get_brand[$i]['brand_id'];?>">
																							<?php echo $get_brand[$i]['brand_name'];?>
																						</option>
																						<?php }?>
																					</select>
																				</div>
																			</div>
																			
																			
																				
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Brand Product Name:</label>
																					<div class="col-sm-10">
																						<select id="brand_product_name" class="maincls form-control" name="brand_product_name" required>
																						<option value="">Select product
																						</option>
																						<?php for($i=0;$i<count($get_category);$i++){?>
																						<option value="<?php echo $get_category[$i]['p_category_id'];?>">
																							<?php echo $get_category[$i]['p_category_name'];?>
																						</option>
																						<?php }?>
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
	
var add_cat = $("#brdnadid").val();
if ($.trim(add_cat) === '')
{
alert("Please Select Brand Name.");
$('#brdnadid').val('');
$('#brdnadid').focus();
 return false;
}

	
var add_cat = $("#brand_product_name").val();
if ($.trim(add_cat) === '')
{
alert("Please Enter Brand Product.");
$('#brand_product_name').val('');
$('#brand_product_name').focus();
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
