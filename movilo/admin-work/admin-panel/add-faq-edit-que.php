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
	$id			  = $_REQUEST['id'];	
	$get_faq_list = $control->get_faq_list_details_edit($id);
	// echo '<pre>';
	// print_r($get_faq_list);
	
	
	if(isset($_POST['update']))
	{
		$res = $control->update_faq();
		if(!empty($res))
		{
				echo '<script>alert("Brand product FAQ updated successfully.")</script>';
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
										   <h2>Edit Brand Products FAQ List</h2>
										   <div class="row m-t-sm">
												<div class="col-lg-12">
													<div class="panel blank-panel"> 

														<div class="panel-body">

															<div class="tab-content">
																 
															
																<div class="tab-pane active" id="tab-1">
																		<form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																	 
																			<input type="hidden" class="form-control" name="id" id="faq-1" value="<?php echo $get_faq_list[0]['srm_question_id'];?>" required>	


																			
																			<div class="form-group has-success">
																				<label class="col-sm-2 control-label">Question:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="faq" id="faq-1" value="<?php echo $get_faq_list[0]['srm_questions'];?>" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label ">Opt 1:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt1" id="brand_product_name" value="<?php echo $get_faq_list[0]['srm_question_opt1'];?>" required>	
																				</div>
																			</div>

																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 2:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt2" id="brand_product_name" value="<?php echo $get_faq_list[0]['srm_question_opt2'];?>" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 3:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt3" id="brand_product_name" value="<?php echo $get_faq_list[0]['srm_question_opt3'];?>" required>	
																				</div>
																			</div>

																			
																			<div class="form-group has-warning">
																				<label class="col-sm-2 control-label">Opt 4:</label>
																				<div class="col-sm-10">
																					<input type="text" class="form-control" name="opt4" id="brand_product_name" value="<?php echo $get_faq_list[0]['srm_question_opt4'];?>" required>	
																				</div>
																			</div>
																			
																			
																			<div class="form-group has-error"><label class="col-sm-2 control-label">Multi / Single Select:</label>
																				<div class="col-sm-10">
																					<select id="type" class="maincls form-control" name="type" required>
																						<option value="<?php echo $get_faq_list[0]['srm_question_type'];?>"><?php echo $get_faq_list[0]['srm_question_type'];?></option>
																						<option value="Multi">Multi Select</option>
																						<option value="Single">Single Select</option>
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
