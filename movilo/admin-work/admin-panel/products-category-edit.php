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
	
	
	$id							  =		$_REQUEST['id'];
	$get_product_category_by_id  = 	$control->get_product_category_by_id($id);
	// echo'<pre>';
	// print_r($get_product_category_by_id);exit;
	
	if(isset($_POST['update']))
	{
		$update_category	=	$control->update_category();
	// echo'<pre>';
// print_r($update_category);exit;
		if(!empty($update_category))
		{
				echo '<script>alert("Products category updated successfully.")</script>';
				echo '<script>window.location.assign("products-category.php")</script>';
		}else{
			echo '<script>alert("This products category already exist.")</script>';
			echo '<script>window.location.assign("products-category.php")</script>';
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
										   <h2>Edit Product Category List</h2>
										   <div class="row m-t-sm">
												<div class="col-lg-12">
													<div class="panel blank-panel">
														<div class="panel-heading">
															<div class="panel-options">
																<ul class="nav nav-tabs">
																	<li class="active"><a href="#tab-1" data-toggle="tab">Edit Product Category</a></li>
																</ul>
															</div>
														</div>

														<div class="panel-body">

															<div class="tab-content">
																<div class="tab-pane active" id="tab-1">
																	  <form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																				<div class="form-group"><label class="col-sm-2 control-label">Category Name:</label>
																					<div class="col-sm-10">
																					<input type="hidden" class="form-control" value="<?php echo $get_product_category_by_id[0]['p_category_id'];?>" name="id" required>	
																					
																					
																					<input type="text" class="form-control" name="p_category_name" id="brand" value="<?php echo $get_product_category_by_id[0]['p_category_name'];?>" required>	
																					</div>
																				</div>
																				
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Category Small Icon:</label>
																					<div class="col-sm-10">
																						<img src="<?php echo "../../product-icon/".$get_product_category_by_id[0]['p_category_icon_small']; ?>" style="height:80px">
																					</div>
																				</div>
																					
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Category Small Icon:</label>
																					<div class="col-sm-10">
																						<input type="file" class="form-control" name="icon" id="icon"  onchange="ValidateSingleInput(this);">	
																					</div>
																				</div>	
																					
																				
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Category Medium Icon:</label>
																					<div class="col-sm-10">
																						<img src="<?php echo "../../product-icon/".$get_product_category_by_id[0]['p_category_icon_medium']; ?>" style="height:80px">
																					</div>
																				</div>
																					
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Category Medium Icon:</label>
																					<div class="col-sm-10">
																						<input type="file" class="form-control" name="icon2" id="icon2"  onchange="ValidateSingleInput(this);">	
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
