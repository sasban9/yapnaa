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
	
	// Get get_brand List
	$get_brand = $control->get_brand();
	// print_r($get_brand);
	
	
	// Get Sub Categories List
	$get_category = $control->get_category();
	// echo'<pre>';print_r($get_category);
	
	
	
	
	$id				  =		$_REQUEST['id'];
	$get_brand_product_by_id  = 	$control->get_brand_product_by_id($id);
	// echo'<pre>';
	// print_r($get_brand_product_by_id);exit;
	
	if(isset($_POST['update']))
	{
		$update_brand_product	=	$control->update_brand_product();
		// print_r($update_brand_product);exit;
		if($update_brand_product==1)
		{
				echo '<script>alert("Brand product updated successfully.")</script>';
				echo '<script>window.location.assign("brand-products.php")</script>';
		}else{
			echo '<script>alert("This brand products category already exist.")</script>';
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
              
			  
		<div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
										<div class="media-body ">
										   <h2>Brand Product List</h2>
										   <div class="row m-t-sm">
												<div class="col-lg-12">
													<div class="panel blank-panel">
														<div class="panel-heading">
															<div class="panel-options">
																<ul class="nav nav-tabs">
																	<li class="active"><a href="#tab-1" data-toggle="tab">Edit Brand Product</a></li>
																</ul>
															</div>
														</div>

														<div class="panel-body">

															<div class="tab-content">
																<div class="tab-pane active" id="tab-1">
																	  <form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																				
																			<input type="hidden" class="form-control" value="<?php echo $get_brand_product_by_id[0]['product_id'];?>" name="id" required>	
																			
																			
																				<div class="form-group"><label class="col-sm-2 control-label">Select Brand Name:</label>
																				<div class="col-sm-10">
																					<select id="brdnadid" class="maincls form-control" name="brdnadid" required>
																						<option value="<?php echo $get_brand_product_by_id[0]['brand_id'];?>"><?php echo $get_brand_product_by_id[0]['brand_name'];?>
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
																						<option value="<?php echo $get_brand_product_by_id[0]['brand_id'];?>"><?php echo $get_brand_product_by_id[0]['p_category_name'];?>
																						</option>
																						<?php for($i=0;$i<count($get_category);$i++){?>
																						<option value="<?php echo $get_category[$i]['p_category_id'];?>">
																							<?php echo $get_category[$i]['p_category_name'];?>
																						</option>
																						<?php }?>
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


<script>

var _validFileExtensions = [".jpg",".png",".gif",".jpeg"];
var _validFileExtensions1 = ["*.jpg","*.png","*.gif","*.jpeg"];    
function ValidateSingleInput(oInput) {
	if (oInput.type == "file") {
	var size = oInput.files[0].size;
		if(size >= 5242880)
				{
				alert("The File Size Is More Than 5MB. Please Choose A File Of Size 5MB or Less.");
				oInput.value = "";
				}
		var sFileName = oInput.value;
		 if (sFileName.length > 0) {
			var blnValid = false;
			for (var j = 0; j < _validFileExtensions.length; j++) {
				var sCurExtension = _validFileExtensions[j];
				if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
					blnValid = true;
					break;
				}
			}
			 
			if (!blnValid) {
				alert("Sorry, " + sFileName + " file type is invalid. Allowed extensions are: " + _validFileExtensions1.join(", "));
				oInput.value = "";
				return false;
			}
		}
	}
	return true;
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
