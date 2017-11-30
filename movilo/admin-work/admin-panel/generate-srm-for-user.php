<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
if(isset($_SESSION['admin_email_id']))
{
	 $admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];
	 $admin_phone_no	= $_SESSION['admin_phone_no'];

	require_once('controller/admin_controller.php');
	$control	=	new admin();
	
	
	// Get get_particular_user_details
	$id	=$_REQUEST['user_phone']; 
	if($id){
		$id								=	 $_REQUEST['user_phone']; 
		$get_user_details 				=	 $control->get_user_details($id);
		$_SESSION['srm_user_id']		=	 $get_user_details[0]['user_id']; 
	}else{
		echo  $_SESSION['srm_user_id'];  
	}
	 
	 
	 
		
 
	 
	// Get User product List
	$get_particular_user_product_list = $control->get_particular_user_product_list($_SESSION['srm_user_id']);
	// echo  '<pre>';
	// print_r($get_particular_user_product_list);

	
	
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
										   <h2>Generate SRM For User - <b><?php echo  $id;?> (ID: <?php echo  $get_user_details[0]['user_id'];?>)</b></h2>
										   <div class="row m-t-sm">
												<div class="col-lg-12">
													<div class="panel blank-panel">
														<div class="panel-heading">
															<div class="panel-options">
																<ul class="nav nav-tabs">
																	<li class="active"><a href="#tab-1" data-toggle="tab">Generate SRM</a></li> 
																</ul>
															</div>
														</div>

														<div class="panel-body">

															<div class="tab-content">
																<div class="tab-pane active" id="tab-1"> 
															 	 
																		<form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																			
																			
																			
																			<input type="h" value="<?php echo $get_user_details[0]['user_id'];?>" id="id" name="id">   																			
																			<div class="form-group has-success"><label class="col-sm-2 control-label">Select User Product:</label>
																				<div class="col-sm-10">
																					<select id="brdnadid" class="maincls form-control" name="brdnadid" required>
																						<option value="">Select An Option
																						</option>
																						<?php for($i=0;$i<count($get_particular_user_product_list);$i++){?>
																						<option value="<?php echo $get_particular_user_product_list[$i]['up_product_id'];?>">
																							<?php echo $get_particular_user_product_list[$i]['p_category_name'];?>
																						</option>
																						<?php }?>
																					</select>
																				</div>
																			</div>
																			
																			
																			
																			<div id="questions">
																			</div>
																			 
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
			var val		 = $(this).val();
			var user_id	 = <?php echo $_SESSION['srm_user_id']?>;
		 // alert(val);exit;
			// alert(val); 
				$.ajax({
				  type: 'POST',
				  url: "get-user-srm-question-list.php",
				  //data: 'id='+val,
				  data: {id: val,user_id:user_id},
				  success: function(data){
					// alert(data);
					$('#questions').html(data);
					// document.location.href = 'booking.php';
				  }
				});		 
   
			
	   });
	   
</script>
		   

 	    
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