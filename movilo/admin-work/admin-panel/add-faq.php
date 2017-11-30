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
	
	
	
	// Get get_brand_product List
	$get_faq_list = $control->get_faq_list();
	// echo '<pre>';
	// print_r($get_faq_list);
	
	if(isset($_POST['submit']))
	{
		$res = $control->add_faq();
		if(!empty($res))
		{
				echo '<script>alert("Brand product FAQs added successfully.")</script>';
				echo '<script>window.location.assign("add-faq.php")</script>';
		}
	}
	
	
	//delete
	if(isset($_POST['delete']))
	{	
		$del_brand_product	=	$control->del_brand_product();
		// print_r($update_main_category);exit;
		if(!empty($del_brand_product)){
			echo '<script>alert("Brand deleted successfully.")</script>';
			echo '<script>window.location.assign("add-faq.php")</script>';
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
              
			  
		<div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
										<div class="media-body ">
										   <h2>Brand Products FAQ List</h2>
										   <div class="row m-t-sm">
												<div class="col-lg-12">
													<div class="panel blank-panel">
														<div class="panel-heading">
															<div class="panel-options">
																<ul class="nav nav-tabs">
																	<li class="active"><a href="#tab-1" data-toggle="tab"> Brand Product FAQ List</a></li>
																	<li class=""><a href="#tab-2" data-toggle="tab">Add Brand Product FAQ</a></li>
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
																				<th>Brand Product  Name</th> 
																		</tr>
																		</thead>
																		<tbody>
																		<?php $j=1;?>
																		<?php for($i=0;$i<count($get_faq_list);$i++){ ?>
																			<tr>
																				<td><?php echo  $j; ?></td>
																				<td><?php echo $get_faq_list[$i]['brand_name']; ?></td>
																				<td><a href="add-faq-details.php?id=<?php echo $get_faq_list[$i]['product_id']; ?>"><?php echo $get_faq_list[$i]['p_category_name']; ?></a></td>
																			</tr>
																		<?php $j++; } ?>
																		</tbody>
																	</table>  	
																</div>
																
																
																
															
																<div class="tab-pane" id="tab-2">
																		<form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																				
																			<div class="form-group has-success"><label class="col-sm-2 control-label">Select Brand Name:</label>
																				<div class="col-sm-10">
																					<select id="brdnadid" class="maincls form-control" name="brdnadid" required>
																						<option value="">Select An Option
																						</option>
																						<?php for($i=0;$i<count($get_brand);$i++){?>
																						<option value="<?php echo $get_brand[$i]['brand_id'];?>">
																							<?php echo $get_brand[$i]['brand_name'];?>
																						</option>
																						<?php }?>
																					</select>
																				</div>
																			</div>
																			
																			
																			
																			<div class="form-group has-success"><label class="col-sm-2 control-label">Select Product:</label>
																				<div class="col-sm-10">
																					<select id="bp_id" class="maincls form-control" name="bp_id" required>
																						<option value="">Select Product
																						</option>
																					</select>
																				</div>
																			</div>
																			
																				
																			<div class="form-group has-success">
																				<label class="col-sm-2 control-label">Question 1:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="faq[]" id="faq-1" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label ">Opt 1:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt1[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 2:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt2[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 3:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt3[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 4:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt4[]" id="brand_product_name" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-error"><label class="col-sm-2 control-label">Multi / Single Select:</label>
																				<div class="col-sm-10">
																					<select id="brdnadid" class="maincls form-control" name="type[]" required>
																						<option value="">Select An Option</option>
																						<option value="Multi">Multi Select</option>
																						<option value="Single">Single Select</option>
																					</select>
																				</div>
																			</div>
																			
																			
																			
																			
																			
																			
																			
																			
																			
																			
																				
																			<div class="form-group has-success">
																				<label class="col-sm-2 control-label">Question 2:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="faq[]" id="faq-1" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label ">Opt 1:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt1[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 2:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt2[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 3:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt3[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 4:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt4[]" id="brand_product_name" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-error"><label class="col-sm-2 control-label">Multi / Single Select:</label>
																				<div class="col-sm-10">
																					<select id="brdnadid" class="maincls form-control" name="type[]" required>
																						<option value="">Select An Option</option>
																						<option value="Multi">Multi Select</option>
																						<option value="Single">Single Select</option>
																					</select>
																				</div>
																			</div>
																			
																			
																			
																			
																				
																			<div class="form-group has-success">
																				<label class="col-sm-2 control-label">Question 3:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="faq[]" id="faq-1" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label ">Opt 1:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt1[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 2:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt2[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 3:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt3[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 4:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt4[]" id="brand_product_name" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-error"><label class="col-sm-2 control-label">Multi / Single Select:</label>
																				<div class="col-sm-10">
																					<select id="brdnadid" class="maincls form-control" name="type[]" required>
																						<option value="">Select An Option</option>
																						<option value="Multi">Multi Select</option>
																						<option value="Single">Single Select</option>
																					</select>
																				</div>
																			</div>
																			
																			
																			
																			
																			
																			
																				
																			<div class="form-group has-success">
																				<label class="col-sm-2 control-label">Question 4:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="faq[]" id="faq-1" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label ">Opt 1:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt1[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 2:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt2[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 3:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt3[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 4:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt4[]" id="brand_product_name" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-error"><label class="col-sm-2 control-label">Multi / Single Select:</label>
																				<div class="col-sm-10">
																					<select id="brdnadid" class="maincls form-control" name="type[]" required>
																						<option value="">Select An Option</option>
																						<option value="Multi">Multi Select</option>
																						<option value="Single">Single Select</option>
																					</select>
																				</div>
																			</div>
																			
																			
																			
																			
																			
																			
																				
																			<div class="form-group has-success">
																				<label class="col-sm-2 control-label">Question 5:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="faq[]" id="faq-1" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label ">Opt 1:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt1[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 2:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt2[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 3:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt3[]" id="brand_product_name" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 4:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt4[]" id="brand_product_name" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-error"><label class="col-sm-2 control-label">Multi / Single Select:</label>
																				<div class="col-sm-10">
																					<select id="brdnadid" class="maincls form-control" name="type[]" required>
																						<option value="">Select An Option</option>
																						<option value="Multi">Multi Select</option>
																						<option value="Single">Single Select</option>
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
<script>
$( "#brdnadid" ).change(function() {
			var val = $(this).val();
		 // alert(val);exit;
			// alert(val); 
				$.ajax({
				  type: 'POST',
				  url: "get-products.php",
				  //data: 'id='+val,
				  data: {id: val},
				  success: function(data){
					  // alert(data);
					$('#bp_id').html(data);
					// document.location.href = 'booking.php';
				  }
				});		 
   
			
	   });
	   
</script>
		   
		   
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
