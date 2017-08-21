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
	$id	=$_REQUEST['id'];
	$srm_request_list_particular_details = $control->srm_request_list_particular_details($id);
	// echo  '<pre>';
	// print_r($srm_request_list_particular_details);
	
	
	
	$get_particular_user_product_details = $control->get_particular_user_product_details($srm_request_list_particular_details[0]['srm_product_id']);
	// echo  '<pre>';
	// print_r($get_particular_user_product_details);
	
	
	$get_particular_user_details = $control->get_particular_user_details($srm_request_list_particular_details[0]['srm_user_id']);
	// $get_particular_user_product_list = $control->get_particular_user_product_list($srm_request_list_particular_details[0]['srm_user_id']);
	
	
	//Generate MVQ
	if(isset($_POST['submit']))
	{	
		$srm_request_mvq_convert	=	$control->srm_request_mvq_convert();
		// print_r($update_main_category);exit;
		if(!empty($srm_request_mvq_convert)){
			echo '<script>alert("MVQ generated succefully.")</script>';?>
			 <script>
				var id	=<?php echo $id;?>;
				// alert(id);
				window.location.assign("srm-request-details.php?id="+id);
			</script>
	<?php	
		}
	}
	
	
	
	
		//Take Action 
	if(isset($_POST['take_action_submit']))
	{	
		$srm_request_take_action	=	$control->srm_request_take_action();
		// print_r($update_main_category);exit;
		if(!empty($srm_request_take_action)){
			echo '<script>alert("Action taken succefully.")</script>';?>
			 <script>
				var id	=<?php echo $id;?>;
				// alert(id);
				window.location.assign("srm-request-details.php?id="+id);
			</script>
	<?php	
		}
	}
	
	
	
	//Assign Engineer
	if(isset($_POST['assign_engineer']))
	{	
		$srm_request_mvq_convert	=	$control->srm_request_assign_engineer();
		// print_r($update_main_category);exit;
		if(!empty($srm_request_mvq_convert)){
			echo '<script>alert("Service Engineer Assigned Succefully.")</script>';?>
			 <script>
				var id	=<?php echo $id;?>;
				// alert(id);
				window.location.assign("srm-request-details.php?id="+id);
			</script>
	<?php	
		}
	}
	
	
	
	
	if(isset($_POST['close_ticket']))
	{	
		$srm_ticket_close	=	$control->srm_ticket_close();
		// print_r($update_main_category);exit;
		if(!empty($srm_ticket_close)){
			echo '<script>alert("Action taken succefully.")</script>';?>
			 <script>
				var id	=<?php echo $id;?>;
				// alert(id);
				window.location.assign("srm-request-details.php?id="+id);
			</script>
	<?php	
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
                    <h2>SRM Request Details</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="srm-requests.php">SRM Request List</a>
                        </li>
                        <li class="active">
                            <strong>SRM Request Details</strong>
                        </li>
                    </ol>
                </div>
            </div>
			
				<!-- <?php //if($srm_request_list_particular_details[0]['srm_status']==0){?>
					<div class="row wrapper border-bottom white-bg page-heading">
						<div class="col-lg-10"><br/>
								
								<span data-toggle="modal" data-target="#mvqpopup" class="btn btn-primary">Convert into MVQ</span>
						</div>
					</div>
			
			<?php// } else { ?>
					<div class="row wrapper border-bottom white-bg page-heading">
						<div class="col-lg-10"><br/>
								
								<span data-toggle="modal" data-target="#mvqpopup" class="btn btn-success">Close SRM Request</span>
						</div>
					</div>
					<?php //} ?>-->
			
			

			
			
					<div class="row wrapper border-bottom white-bg page-heading">
						<div class="col-lg-10"><br/>
						<?php if($srm_request_list_particular_details[0]['srm_status']==0){?>
							Status : <span  class="btn btn-warning  btn-rounded">Open</span>
						<?php } elseif($srm_request_list_particular_details[0]['srm_status']==2){ ?>
							Status : <span  class="btn btn-success btn-rounded">In Progress</span>
						<?php } elseif($srm_request_list_particular_details[0]['srm_status']==3){ ?>
							Status : <span  class="btn btn-info btn-rounded">Assignining Service Engineer</span>
						<?php } elseif($srm_request_list_particular_details[0]['srm_status']==4){ ?>
							Status : <span  class="btn btn-success btn-rounded">Service Engineer Assigned Succesfully</span>
						<?php } elseif($srm_request_list_particular_details[0]['srm_status']==5){ ?>
							Status : <span  class="btn btn-success btn-rounded">Cancelled Ticket</span> 
						<?php } elseif($srm_request_list_particular_details[0]['srm_status']==6){ ?>
							Status : <span  class="btn btn-success btn-rounded">Ticket Closed </span>
						<?php } elseif($srm_request_list_particular_details[0]['srm_status']==7){ ?>
							Status : <span  class="btn btn-success btn-rounded">Completed Ticket</span>
						<?php } ?> 
						</div>
					</div>
					
					
			
			
						<div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-title">
                                        <h5>User and product details</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="ibox-content">
                                        <div class="row">
                                            <div class="col-lg-6">
												<h5>User details</h5>
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
											
											
											
											
											
                                            <div class="col-lg-6">
                                               <table class="table table-striped table-bordered table-hover dataTables-example" >
													<tr>
														<td><p>Product Name</p></td>
														<td> <p> <a href="user-product-details.php?id=<?php echo $get_particular_user_product_details[0]['product_id']; ?>" target="_blank"><?php echo $get_particular_user_product_details[0]['p_category_name'];?></a></p></td>
													</tr>  
													<tr>
														<td><p>Brand Name</p></td>
														<td> <p> <?php echo $get_particular_user_product_details[0]['brand_name'];?></p></td>
													</tr> 
												</table>
                                            </div>
											 
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
						
						
						
						
						
		
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					 
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>History</h5>
								<div class="ibox-tools">
									<a class="collapse-link">
										<i class="fa fa-chevron-up"></i>
									</a>
								</div>
							</div>
							<div class="ibox-content">
							<div class="wrapper wrapper-content">
								<div class="row animated fadeInRight">
									<div class="col-lg-12">
									<div class="ibox float-e-margins">
											<div id="vertical-timeline" class="vertical-container dark-timeline center-orientation">
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon navy-bg">
														<i class="fa fa-calendar"></i>
													</div>

													<div class="vertical-timeline-content">
														<h5>User Queries</h5>
														
														
														
														<?php $questions	=	explode(',',$srm_request_list_particular_details[0]['srm_questions']);  
														 $srm_answers	=	explode(',',$srm_request_list_particular_details[0]['srm_answers']);  
														$j=	1;
														 
															for($i=0;$i<(count($questions));$i++){    
																if($questions[$i]!=''){ 
																  $q_list		=	 $questions[$i];  
																  $a_list		=	 $srm_answers[$i];  
																// $options			=	(str_split($a_list));
																// $options_count	=	count($options);
																// echo  '<pre>';
																// print_r($options);
			   																
																$get_result = $control->get_srm_que_ans_details($q_list,$a_list);
																// echo  '<pre>';
																// print_r($get_result);
																// echo   $get_result[0]['srm_question_id'];
																// echo   $get_result[0]['srm_question_bp_id'];?>
														<p><b>Q- <?php echo $j;?> )</b> 
															<a href="view-questions.php?id=<?php echo $get_result[0]['srm_question_id'];?>" target="_balnk"><?php
																echo   $get_result[0]['srm_questions'].' ('.$get_result[0]['srm_question_type'].')';?></a>
														</p>		
														<p><b>Ans - </b> 
																<?php
																if( $get_result[0]['srm_question_opt1']){
																	echo   $get_result[0]['srm_question_opt1'].'<br/>';
																}
																if( $get_result[0]['srm_question_opt2']){
																	echo   '<span style="margin-left:18%">'.$get_result[0]['srm_question_opt2'].'</span><br/>';
																}
																if( $get_result[0]['srm_question_opt3']){
																		echo   '<span style="margin-left:18%">'.$get_result[0]['srm_question_opt3'].'</span><br/>';
																}
																if( $get_result[0]['srm_question_opt4']){
																	echo   '<span style="margin-left:18%">'.$get_result[0]['srm_question_opt4'].'</span>';
																} ?>
																<hr/>
															<?php	$j++;
																} else {
																	echo "<span style='color:blue'>No Faq's</span>";
																}	 	
															
															} 	
																
														?>  
														<p><b>User Notes:</b></p>
														<?php echo $srm_request_list_particular_details[0]['srm_user_notes'];?>
														
														<span class="vertical-date">
															Requested date <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_user_generated_date'];?></small>
														</span>
													</div>
												</div>
												
												
												
												
												
												
			
												<!-- MVQ generate Pop Up-->
												<div class="modal fade" id="mvqpopup" role="dialog">
													<div class="modal-dialog  modal-sm">
													  <div class="modal-content">
														<div class="modal-header">
														  <button type="button" class="close" data-dismiss="modal">&times;</button>
														  <h4 class="modal-title">Generate MVQ</h4>
														</div>
														<div class="modal-body">
														<form id="form" method="POST">
															 <div class="form-group has-success">
																<label class="control-label">Notes:</label>
																<input type="hidden" class="form-control" name="srm_id" id="srm_id" value="<?php echo $id;?>" required>	
																<input type="hidden" class="form-control" name="mvq_admin_name" id="mvq_admin_name" value="<?php echo $admin_name;?>" required>	
																
																<input type="hidden" class="form-control" name="mvq_admin_phone_no" id="mvq_admin_phone_no" value="<?php echo $admin_phone_no;?>" required>	 
																<textarea   class="form-control" name="mvq_execative_notes" id="mvq_execative_notes" required></textarea>
																<br/>
																<label class="control-label">Status:</label>
																<select  class="form-control" name="srm_status" required>
																	<option value="">Choose Option</option>
																	<option value="2">In Progress</option> 
																	<option value="3">Assign Engineer</option>
																	<option value="5">Cancel Ticket</option>
																	<option value="6">Close Ticket</option>
																</select><br/>
																<input id="submit"   type="submit" name="submit" class="btn btn-primary pull-left"  value="Generate MVQ">
															</div>
														</form>
														</div>
													  </div>
													</div>
												</div>
											   
												
												<?php if($srm_request_list_particular_details[0]['srm_status']==0) { ?>
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														<h2>Convert Into MVQ</h2>
														<a data-toggle="modal" data-target="#mvqpopup" class="btn btn-sm btn-success"> Generate MVQ </a>
														<span class="vertical-date">
															Today <br/>
															<small><?php echo date('d-m-Y');?></small>
														</span>
													</div>
												</div>
												
												<?php } else { ?>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon yellow-bg">
														<i class="fa fa-phone"></i>
													</div>

													<div class="vertical-timeline-content">
														<h2>MVQ No : <?php echo $srm_request_list_particular_details[0]['srm_MVQ_no'];?></h2>
														<p>Executive Notes: <?php echo $srm_request_list_particular_details[0]['srm_MVQ_execative_notes'];?></p>
														<p>Executive Name: <?php echo $srm_request_list_particular_details[0]['srm_MVQ_execative_name'];?></p>
														<p>Executive Phone: <?php echo $srm_request_list_particular_details[0]['srm_MVQ_execative_number'];?></p>
														<span class="vertical-date"> MVQ Generate Date <br/><small><?php echo $srm_request_list_particular_details[0]['srm_MVQ_no_generated_date'];?></small></span>
													</div>
												</div>
												
												
												
												
												
												<!-- Take Action Pop Up-->
												<div class="modal fade" id="takeactioninprogress" role="dialog">
													<div class="modal-dialog  modal-sm">
													  <div class="modal-content">
														<div class="modal-header">
														  <button type="button" class="close" data-dismiss="modal">&times;</button>
														  <h4 class="modal-title">Take Action</h4>
														</div>
														<div class="modal-body">
														<form id="form" method="POST">
															 <div class="form-group has-success">
															  <label class="control-label">Notes:</label>
																<input type="hidden" class="form-control" name="srm_id" id="srm_id" value="<?php echo $id;?>" required>	
																<input type="hidden" class="form-control" name="mvq_admin_name" id="mvq_admin_name" value="<?php echo $admin_name;?>" required>	
																
																<input type="hidden" class="form-control" name="mvq_admin_phone_no" id="mvq_admin_phone_no" value="<?php echo $admin_phone_no;?>" required>	 
																
																<textarea   class="form-control" name="mvq_execative_notes" id="mvq_execative_notes" required></textarea>
																<br/> 
																<label class="control-label">Status:</label>
																<select  class="form-control" name="srm_status" required>
																	<option value="">Choose Option</option>
																	<!--<option value="2">In Progress</option>--> 
																	<option value="23">Assign Engineer</option>
																	<option value="25">Cancel Ticket</option>
																	<option value="26">Close Ticket</option>
																</select><br/>
																<input id="submit"   type="submit" name="take_action_submit" class="btn btn-primary pull-left"  value="Take Action">
															</div>
														</form>
														</div>
													  </div>
													</div>
												</div>

												
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==2) { ?>
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content">
														<h4>In Progress</h4>
														<a data-toggle="modal" data-target="#takeactioninprogress" class="btn btn-sm btn-info">Take Action</a>
														<span class="vertical-date">
															Today <br/>
															<small><?php echo date('d-m-Y');?></small>
														</span>
													</div> 
												</div>
												
												<?php } ?> 
												
												
												
												
												
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==3) { ?>
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content">
														<h4>Assign Service Engineer</h4>
														<a data-toggle="modal" data-target="#assignengineer" class="btn btn-sm btn-info">Assign Service Engineer</a>
														<a data-toggle="modal" data-target="#takeactioninprogress3" class="btn btn-sm btn-info" style="float:right">Take Action</a>
														<span class="vertical-date">
															Today <br/>
															<small><?php echo date('d-m-Y');?></small>
														</span>
													</div> 
												</div>
												
												
												
												
												
												
												
												
												<!-- Take Action Pop Up-->
												<div class="modal fade" id="takeactioninprogress3" role="dialog">
													<div class="modal-dialog  modal-sm">
													  <div class="modal-content">
														<div class="modal-header">
														  <button type="button" class="close" data-dismiss="modal">&times;</button>
														  <h4 class="modal-title">Take Action</h4>
														</div>
														<div class="modal-body">
														<form id="form" method="POST">
															 <div class="form-group has-success">
															  <label class="control-label">Notes:</label>
																<input type="hidden" class="form-control" name="srm_id" id="srm_id" value="<?php echo $id;?>" required>	
																<input type="hidden" class="form-control" name="mvq_admin_name" id="mvq_admin_name" value="<?php echo $admin_name;?>" required>	
																
																<input type="hidden" class="form-control" name="mvq_admin_phone_no" id="mvq_admin_phone_no" value="<?php echo $admin_phone_no;?>" required>	 
																
																<textarea   class="form-control" name="mvq_execative_notes" id="mvq_execative_notes" required></textarea>
																<br/> 
																<label class="control-label">Status:</label>
																<select  class="form-control" name="srm_status" required>
																	<option value="">Choose Option</option>
																	<!--<option value="2">In Progress</option>
																	<option value="23">Assign Engineer</option>--> 
																	<option value="5">Cancel Ticket</option>
																	<option value="6">Close Ticket</option>
																</select><br/>
																<input id="submit"   type="submit" name="take_action_submit" class="btn btn-primary pull-left"  value="Take Action">
															</div>
														</form>
														</div>
													  </div>
													</div>
												</div>

												
												
												<?php } ?>

			
											<!-- Assign Engineer Pop Up-->
											<div class="modal fade" id="assignengineer" role="dialog">
												<div class="modal-dialog modal-lg">
												  <div class="modal-content">
													<div class="modal-header">
													  <button type="button" class="close" data-dismiss="modal">&times;</button>
													  <h4 class="modal-title">Assign Service Engineer</h4>
													</div>
													<div class="modal-body">
													<form id="form" method="POST">
														 <div class="form-group has-success">
															<input type="hidden" class="form-control" name="srm_id" id="srm_id" value="<?php echo $id;?>" required>	
															
															<input type="hidden" class="form-control" name="srm_SE_assigner_name" id="srm_SE_assigner_name" value="<?php echo $admin_name;?>" required>
															
															
															<input type="hidden" class="form-control" name="srm_status" id="srm_SE_assigner_name" value="34" required>
																
																
															<input type="hidden" class="form-control" name="srm_SE_assigner_phone" id="srm_SE_assigner_phone" value="<?php echo $admin_phone_no;?>" required>	
															
															
															
															
															<label class="control-label">Service Engineer Name:</label>
															<input type="text" class="form-control" name="se_name" id="se_name" placeholder="Service Engineer Name"required>	
															<br/>
															
															<label class="control-label">Service Engineer Phone No:</label>
															<input type="text" class="form-control" name="se_phone" id="se_phone" placeholder="Service Engineer Phone No" maxlength="10" required>
															<br/>
															
															
															<label class="control-label">Brand Ticket No:</label>
															<input type="text" class="form-control" name="brand_ticket_no" id="brand_ticket_no" placeholder="Brand Ticket No" required>
															<br/>
															
																
															<label class="control-label">Service Engineer Notes:</label>
															<textarea   class="form-control" name="se_notes" id="se_notes" placeholder="Service Engineer Notes" required> </textarea>
															<br/>
															
															<label class="control-label">Service Engineer Visiting Date:</label>
															<input type="text" class="form-control" name="se_visiting_date" id="se_visiting_date" placeholder="Service Engineer Visiting Date" required>
															<br/>
															
															<label class="control-label">Priority:</label>
															<select  class="form-control" name="priority" id="priority">
																<option value="">Choose An Option</option>
																<option value="4-Hours">P-0</option>
																<option value="1-Day">P-1</option>
																<option value="2-Days">P-2</option>
																<option value="3-Days">P-3</option>
																<option value="4-Days">P-4</option>
															</select><br/>
															<input id="submit"   type="submit" name="assign_engineer" class="btn btn-primary pull-left"  value="Assign Engineer">
														</div>
													</form>
													</div>
												  </div>
												</div>
											</div>
											
											
											
											
											
											<?php  if($srm_request_list_particular_details[0]['srm_status']==5) { ?>
											<div class="vertical-timeline-block">
												<div class="vertical-timeline-icon lazur-bg">
													<i class="fa fa-user"></i>
												</div>
												<div class="vertical-timeline-content">
													<h4>Service has been cancelled</h4> 
													<span class="vertical-date">
														Cancelled Date <br/>
													<small><?php echo $srm_request_list_particular_details[0]['srm_MVQ_no_generated_date'];?></small>
													</span>
												</div> 
											</div>
											
											<?php } ?>

											
											
											
											
											<?php if($srm_request_list_particular_details[0]['srm_status']==6){?>
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon navy-bg">
														<i class="fa fa-comments"></i>
													</div>

													<div class="vertical-timeline-content">
														<h4>SRM Request Closed</h4> 
														<span style="color:red"> Waiting for user feed back </span> <br/> 
														<span class="vertical-date"> SRM Request Closed <br/><small>
														<?php echo $srm_request_list_particular_details[0]['srm_TC_no_generated_date'];?></small></span>
													</div>
												</div>
												
												<?php } ?>
												
											
											
											
											
											
												
													
												<?php if($srm_request_list_particular_details[0]['srm_status']==7){?> 
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-tag"></i>
													</div>
													<div class="vertical-timeline-content">
														<h4>Service Completed</h4>
														<h5>User feedback</h5>
														<span>  
														User Rating:  <?php echo $srm_request_list_particular_details[0]['srm_complete_rating'];?><br/> 
														User Comments:  <?php echo $srm_request_list_particular_details[0]['srm_complete_comment'];?><br/> 
														</span>														
														<span class="vertical-date">
															Completed Date <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_complete_date'];?></small>
														</span>
													</div> 
												</div>
												
												<?php } ?>
											 
												
												
												
												
												
												<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==23) { ?>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<p>Action Notes: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_notes'];?></p>
														<p>Action Taken By: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_name'];?></p>
														<p>Executive Phone: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_phone_no'];?></p>
														
														<span class="vertical-date">
															Action Taken On <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div> 
												</div>
												
												
												
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Assign Service Engineer</h4>
														<a data-toggle="modal" data-target="#assignengineer1" class="btn btn-sm btn-info" style="float:left">Assign Service Engineer</a>
														
														<a data-toggle="modal" data-target="#takeactioninprogress1" class="btn btn-sm btn-info">Take Action</a>
														<span class="vertical-date">
															Today <br/>
															<small><?php echo date('d-m-Y');?></small>
														</span>
													</div>
													
													
												
												<!-- Take Action Pop Up-->
												<div class="modal fade" id="takeactioninprogress1" role="dialog">
													<div class="modal-dialog  modal-sm">
													  <div class="modal-content">
														<div class="modal-header">
														  <button type="button" class="close" data-dismiss="modal">&times;</button>
														  <h4 class="modal-title">Take Action</h4>
														</div>
														<div class="modal-body">
														<form id="form" method="POST">
															 <div class="form-group has-success">
															  <label class="control-label">Notes:</label>
																<input type="hidden" class="form-control" name="srm_id" id="srm_id" value="<?php echo $id;?>" required>	
																<input type="hidden" class="form-control" name="mvq_admin_name" id="mvq_admin_name" value="<?php echo $admin_name;?>" required>	
																
																<input type="hidden" class="form-control" name="mvq_admin_phone_no" id="mvq_admin_phone_no" value="<?php echo $admin_phone_no;?>" required>	 
																
																<textarea   class="form-control" name="mvq_execative_notes" id="mvq_execative_notes" required></textarea>
																<br/> 
																<label class="control-label">Status:</label>
																<select  class="form-control" name="srm_status" required>
																	<option value="">Choose Option</option>
																	<!--<option value="2">In Progress</option>
																	<option value="23">Assign Engineer</option>--> 
																	<option value="25">Cancel Ticket</option>
																	<option value="26">Close Ticket</option>
																</select><br/>
																<input id="submit"   type="submit" name="take_action_submit" class="btn btn-primary pull-left"  value="Take Action">
															</div>
														</form>
														</div>
													  </div>
													</div>
												</div>

												
												
												
												
												</div>
												
												

												<?php } ?>

			
											<!-- In Progress Assign Engineer Pop Up-->
											<div class="modal fade" id="assignengineer1" role="dialog">
												<div class="modal-dialog modal-lg">
												  <div class="modal-content">
													<div class="modal-header">
													  <button type="button" class="close" data-dismiss="modal">&times;</button>
													  <h4 class="modal-title">Assign Service Engineer</h4>
													</div>
													<div class="modal-body">
													<form id="form" method="POST">
														 <div class="form-group has-success">
															<input type="hidden" class="form-control" name="srm_id" id="srm_id" value="<?php echo $id;?>" required>	
															
															<input type="hidden" class="form-control" name="srm_SE_assigner_name" id="srm_SE_assigner_name" value="<?php echo $admin_name;?>" required>
															
															
															
															<input type="hidden" class="form-control" name="srm_status" id="srm_SE_assigner_name" value="244" required>
															
															
															
															<input type="hidden" class="form-control" name="srm_SE_assigner_phone" id="srm_SE_assigner_phone" value="<?php echo $admin_phone_no;?>" required>	
															
															
															
															
															<label class="control-label">Service Engineer Name:</label>
															<input type="text" class="form-control" name="se_name" id="se_name" placeholder="Service Engineer Name"required>	
															<br/>
															
															<label class="control-label">Service Engineer Phone No:</label>
															<input type="text" class="form-control" name="se_phone" id="se_phone" placeholder="Service Engineer Phone No" maxlength="10" required>
															<br/>
															
															
															<label class="control-label">Brand Ticket No:</label>
															<input type="text" class="form-control" name="brand_ticket_no" id="brand_ticket_no" placeholder="Brand Ticket No" required>
															<br/>
															
																
															<label class="control-label">Service Engineer Notes:</label>
															<textarea   class="form-control" name="se_notes" id="se_notes" placeholder="Service Engineer Notes" required> </textarea>
															<br/>
															
															<label class="control-label">Service Engineer Visiting Date:</label>
															<input type="text" class="form-control" name="se_visiting_date" id="se_visiting_date" placeholder="Service Engineer Visiting Date" required>
															<br/>
															
															<label class="control-label">Priority:</label>
															<select  class="form-control" name="priority" id="priority">
																<option value="">Choose An Option</option>
																<option value="4-Hours">P-0</option>
																<option value="1-Day">P-1</option>
																<option value="2-Days">P-2</option>
																<option value="3-Days">P-3</option>
																<option value="4-Days">P-4</option>
															</select><br/>
															<input id="submit"   type="submit" name="assign_engineer" class="btn btn-primary pull-left"  value="Assign Engineer">
														</div>
													</form>
													</div>
												  </div>
												</div>
											</div>
											
											
											
											
											
											
												
												
												
												<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==24) { ?>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<p>Action Notes: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_notes'];?></p>
														<p>Action Taken By: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_name'];?></p>
														<p>Executive Phone: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_phone_no'];?></p>
														
														<span class="vertical-date">
															Action Taken On <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div> 
												</div>
												
												
												
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Service Engineer Assigned </h4>
														<p>Brand Ticket No : <?php echo $srm_request_list_particular_details[0]['srm_brand_tocket_no'];?></p>
														<p>SE Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_name'];?></p>
														<p>SE Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_number'];?></p>
														<p>SE Notes: <?php echo $srm_request_list_particular_details[0]['srm_SE_notes'];?></p>
														<p>SE Visiting Date: <?php echo $srm_request_list_particular_details[0]['srm_SE_visit_date'];?></p>
														<p>Date of Assign: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigned_date'];?></p>
														<p>SE Assigner Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_name'];?></p>
														<p>SE Assigner Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_phone'];?></p>
														<p>Priority: <?php echo $srm_request_list_particular_details[0]['srm_priority'];?></p>
													</div>
												</div>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-tag"></i>
													</div>
													<div class="vertical-timeline-content">
														<h4>Take Action</h4>
														<a data-toggle="modal" data-target="#takeactioninprogress2" class="btn btn-sm btn-info">Take Action</a>
														<span class="vertical-date">
															Today <br/>
															<small><?php echo date('d-m-Y');?></small>
														</span>
													</div> 
												</div>
												
												 
												
												<!-- Take Action Pop Up-->
												<div class="modal fade" id="takeactioninprogress2" role="dialog">
													<div class="modal-dialog  modal-sm">
													  <div class="modal-content">
														<div class="modal-header">
														  <button type="button" class="close" data-dismiss="modal">&times;</button>
														  <h4 class="modal-title">Take Action</h4>
														</div>
														<div class="modal-body">
														<form id="form" method="POST">
															 <div class="form-group has-success">
															  <label class="control-label">Notes:</label>
																<input type="hidden" class="form-control" name="srm_id" id="srm_id" value="<?php echo $id;?>" required>	
																<input type="hidden" class="form-control" name="mvq_admin_name" id="mvq_admin_name" value="<?php echo $admin_name;?>" required>	
																
																<input type="hidden" class="form-control" name="mvq_admin_phone_no" id="mvq_admin_phone_no" value="<?php echo $admin_phone_no;?>" required>	 
																
																<textarea   class="form-control" name="mvq_execative_notes" id="mvq_execative_notes" required></textarea>
																<br/> 
																<label class="control-label">Status:</label>
																<select  class="form-control" name="srm_status" required>
																	<option value="">Choose Option</option>
																	<!--<option value="2">In Progress</option> 
																	<option value="23">Assign Engineer</option>--> 
																	<option value="245">Cancel Ticket</option>
																	<option value="246">Close Ticket</option>
																</select><br/>
																<input id="submit"   type="submit" name="take_action_submit" class="btn btn-primary pull-left"  value="Take Action">
															</div>
														</form>
														</div>
													  </div>
													</div>
												</div>

												  

												<?php } ?>
											
											
											
											
											
											
											
											<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==25) { ?>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<p>Action Notes: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_notes'];?></p>
														<p>Action Taken By: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_name'];?></p>
														<p>Executive Phone: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_phone_no'];?></p>
														
														<span class="vertical-date">
															Action Taken On <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div> 
												</div>
												
												
												
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Service has been cancelled</h4> 
														<span class="vertical-date">
															Cancelled Date <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div>
												</div>
												
												

												<?php } ?>
												
												
												
												
												
												
												
												
											
											
											<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==26) { ?>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<p>Action Notes: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_notes'];?></p>
														<p>Action Taken By: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_name'];?></p>
														<p>Executive Phone: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_phone_no'];?></p>
														
														<span class="vertical-date">
															Action Taken On <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div> 
												</div>
												
												
												
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													
													<div class="vertical-timeline-content">
														<h4>SRM Request Closed</h4> 
														<span style="color:red"> Waiting for user feed back </span>  <br/> 
														</span>
														<span class="vertical-date"> SRM Request Closed <br/><small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small></span>
													</div>
												</div>
												
												

												<?php } ?>
												
												
												
												
												
											
												
												
												
												<!---In Progress Complte---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==27) { ?>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<p>Action Notes: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_notes'];?></p>
														<p>Action Taken By: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_name'];?></p>
														<p>Executive Phone: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_phone_no'];?></p>
														
														<span class="vertical-date">
															Action Taken On <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div> 
												</div>
												
												
												
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>User feedback</h4>
														<span> Notes:  <?php echo $srm_request_list_particular_details[0]['srm_complete_rating'];?><br/>
														User Rating:  <?php echo $srm_request_list_particular_details[0]['srm_complete_rating'];?><br/> 
														User Comments:  <?php echo $srm_request_list_particular_details[0]['srm_complete_comment'];?><br/> 
														</span>														
														<span class="vertical-date">
															Completed Date <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_complete_date'];?></small>
														</span>
													</div>
												</div>
												  
												  

												<?php } ?>



												
											
												
												
												
												
												
												
												
												<!---Assigned 34---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==34) { ?>
												
												 
												
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Service Engineer Assigned </h4>
														<p>Brand Ticket No : <?php echo $srm_request_list_particular_details[0]['srm_brand_tocket_no'];?></p>
														<p>SE Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_name'];?></p>
														<p>SE Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_number'];?></p>
														<p>SE Notes: <?php echo $srm_request_list_particular_details[0]['srm_SE_notes'];?></p>
														<p>SE Visiting Date: <?php echo $srm_request_list_particular_details[0]['srm_SE_visit_date'];?></p>
														<p>Date of Assign: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigned_date'];?></p>
														<p>SE Assigner Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_name'];?></p>
														<p>SE Assigner Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_phone'];?></p>
														<p>Priority: <?php echo $srm_request_list_particular_details[0]['srm_priority'];?></p>
													</div>
												</div>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-tag"></i>
													</div>
													<div class="vertical-timeline-content">
														<h4>Take Action</h4>
														<a data-toggle="modal" data-target="#takeactioninprogress2" class="btn btn-sm btn-info" style="float:left">Take Action</a>
														<span class="vertical-date">
															Today <br/>
															<small><?php echo date('d-m-Y');?></small>
														</span>
													</div> 
												</div>
												
												 
												
												<!-- Take Action Pop Up-->
												<div class="modal fade" id="takeactioninprogress2" role="dialog">
													<div class="modal-dialog  modal-sm">
													  <div class="modal-content">
														<div class="modal-header">
														  <button type="button" class="close" data-dismiss="modal">&times;</button>
														  <h4 class="modal-title">Take Action</h4>
														</div>
														<div class="modal-body">
														<form id="form" method="POST">
															 <div class="form-group has-success">
																<label class="control-label">Notes:</label>
																<input type="hidden" class="form-control" name="srm_id" id="srm_id" value="<?php echo $id;?>" required>	
																<input type="hidden" class="form-control" name="mvq_admin_name" id="mvq_admin_name" value="<?php echo $admin_name;?>" required>	
																
																<input type="hidden" class="form-control" name="mvq_admin_phone_no" id="mvq_admin_phone_no" value="<?php echo $admin_phone_no;?>" required>	 
																<textarea   class="form-control" name="close_ticket_execative_notes" id="close_ticket_execative_notes" required></textarea>
																<br/>
																 
																 <label class="control-label">Status:</label>
																<select  class="form-control" name="srm_status" required>
																	<option value="">Choose Option</option>
																	<!--<option value="2">In Progress</option> 
																	<option value="23">Assign Engineer</option>--> 
																	<option value="35">Cancel Ticket</option>
																	<option value="36">Close Ticket</option>
																</select><br/>
																<input id="submit"   type="submit" name="close_ticket" class="btn btn-success pull-left"  value="Take Action">
															</div>
														</form>
													
													 
														</div>
													  </div>
													</div>
												</div>

												  

												<?php } ?>
											
											
											
											
											
											
											
											
											
												
												<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==35) { ?>
												 
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Service Engineer Assigned </h4>
														<p>Brand Ticket No : <?php echo $srm_request_list_particular_details[0]['srm_brand_tocket_no'];?></p>
														<p>SE Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_name'];?></p>
														<p>SE Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_number'];?></p>
														<p>SE Notes: <?php echo $srm_request_list_particular_details[0]['srm_SE_notes'];?></p>
														<p>SE Visiting Date: <?php echo $srm_request_list_particular_details[0]['srm_SE_visit_date'];?></p>
														<p>Date of Assign: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigned_date'];?></p>
														<p>SE Assigner Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_name'];?></p>
														<p>SE Assigner Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_phone'];?></p>
														<p>Priority: <?php echo $srm_request_list_particular_details[0]['srm_priority'];?></p>
													</div>
												</div>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-tag"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<h4>Service has been cancelled</h4> 
														<span class="vertical-date">
															Cancelled Date <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div>
												</div> 

												<?php } ?>
											
											
											
											
											
											
											
											
											
											
												
												<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==36) { ?>
												 
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Service Engineer Assigned </h4>
														<p>Brand Ticket No : <?php echo $srm_request_list_particular_details[0]['srm_brand_tocket_no'];?></p>
														<p>SE Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_name'];?></p>
														<p>SE Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_number'];?></p>
														<p>SE Notes: <?php echo $srm_request_list_particular_details[0]['srm_SE_notes'];?></p>
														<p>SE Visiting Date: <?php echo $srm_request_list_particular_details[0]['srm_SE_visit_date'];?></p>
														<p>Date of Assign: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigned_date'];?></p>
														<p>SE Assigner Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_name'];?></p>
														<p>SE Assigner Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_phone'];?></p>
														<p>Priority: <?php echo $srm_request_list_particular_details[0]['srm_priority'];?></p>
													</div>
												</div>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-tag"></i>
													</div>
													 
													<div class="vertical-timeline-content">
														<h4>SRM Request Closed</h4> 
														<span style="color:red"> Waiting for user feed back </span> <br/>
														<span> Executive Notes: <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_notes'];?><br/>
														Executive Phone:  <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_number'];?><br/>
														Executive Name:  <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_name'];?><br/> 
														</span>
														<span class="vertical-date"> SRM Request Closed <br/><small>
														<?php echo $srm_request_list_particular_details[0]['srm_TC_no_generated_date'];?></small></span>
													</div>
												</div> 

												<?php } ?>
											
											
												
												
												
												
												
												
												<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==37) { ?> 
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Service Engineer Assigned </h4>
														<p>Brand Ticket No : <?php echo $srm_request_list_particular_details[0]['srm_brand_tocket_no'];?></p>
														<p>SE Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_name'];?></p>
														<p>SE Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_number'];?></p>
														<p>SE Notes: <?php echo $srm_request_list_particular_details[0]['srm_SE_notes'];?></p>
														<p>SE Visiting Date: <?php echo $srm_request_list_particular_details[0]['srm_SE_visit_date'];?></p>
														<p>Date of Assign: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigned_date'];?></p>
														<p>SE Assigner Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_name'];?></p>
														<p>SE Assigner Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_phone'];?></p>
														<p>Priority: <?php echo $srm_request_list_particular_details[0]['srm_priority'];?></p>
													</div>
												</div>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-tag"></i>
													</div>
													 
													 
													<div class="vertical-timeline-content">
														<h4>SRM Request Closed</h4>  
														<span> Executive Notes: <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_notes'];?><br/>
														Executive Phone:  <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_number'];?><br/>
														Executive Name:  <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_name'];?><br/> 
														</span>
														<span class="vertical-date"> SRM Request Closed <br/><small>
														<?php echo $srm_request_list_particular_details[0]['srm_TC_no_generated_date'];?></small></span>
													</div>
												</div> 
												
												
												
												
													
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														<h4>Service Completed</h4>
														<h5>User feedback</h5>
														<span> Is Engineer On Time ? : <?php echo $srm_request_list_particular_details[0]['srm_complete_eng_on_time'];?><br/>
														Eng Time Spent:  <?php echo $srm_request_list_particular_details[0]['srm_complete_eng_time_spent'];?><br/>
														User Rating:  <?php echo $srm_request_list_particular_details[0]['srm_complete_rating'];?><br/> 
														User Comments:  <?php echo $srm_request_list_particular_details[0]['srm_complete_comment'];?><br/> 
														</span>														
														<span class="vertical-date">
															Completed Date <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_complete_date'];?></small>
														</span>
													</div>
												</div>
												  
												  
												  
												<?php } ?>
											
											
											
											
											
												
											
											
											
												
												
												<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==244) { ?>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<p>Action Notes: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_notes'];?></p>
														<p>Action Taken By: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_name'];?></p>
														<p>Executive Phone: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_phone_no'];?></p>
														
														<span class="vertical-date">
															Action Taken On <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div> 
												</div>
												
												
												
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Service Engineer Assigned </h4>
														<p>Brand Ticket No : <?php echo $srm_request_list_particular_details[0]['srm_brand_tocket_no'];?></p>
														<p>SE Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_name'];?></p>
														<p>SE Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_number'];?></p>
														<p>SE Notes: <?php echo $srm_request_list_particular_details[0]['srm_SE_notes'];?></p>
														<p>SE Visiting Date: <?php echo $srm_request_list_particular_details[0]['srm_SE_visit_date'];?></p>
														<p>Date of Assign: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigned_date'];?></p>
														<p>SE Assigner Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_name'];?></p>
														<p>SE Assigner Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_phone'];?></p>
														<p>Priority: <?php echo $srm_request_list_particular_details[0]['srm_priority'];?></p>
													</div>
												</div>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-tag"></i>
													</div>
													<div class="vertical-timeline-content">
														<h4>Take Action</h4>
														<a data-toggle="modal" data-target="#takeactioninprogress2" class="btn btn-sm btn-info">Take Action</a>
														<span class="vertical-date">
															Today <br/>
															<small><?php echo date('d-m-Y');?></small>
														</span>
													</div> 
												</div>
												
												 
												
												<!-- Take Action Pop Up-->
												<div class="modal fade" id="takeactioninprogress2" role="dialog">
													<div class="modal-dialog  modal-sm">
													  <div class="modal-content">
														<div class="modal-header">
														  <button type="button" class="close" data-dismiss="modal">&times;</button>
														  <h4 class="modal-title">Take Action</h4>
														</div>
														<div class="modal-body">
														<form id="form" method="POST">
															 <div class="form-group has-success">
																<label class="control-label">Notes:</label>
																<input type="hidden" class="form-control" name="srm_id" id="srm_id" value="<?php echo $id;?>" required>	
																<input type="hidden" class="form-control" name="mvq_admin_name" id="mvq_admin_name" value="<?php echo $admin_name;?>" required>	
																
																<input type="hidden" class="form-control" name="mvq_admin_phone_no" id="mvq_admin_phone_no" value="<?php echo $admin_phone_no;?>" required>	 
																<textarea   class="form-control" name="close_ticket_execative_notes" id="close_ticket_execative_notes" required></textarea>
																<br/>
																 
																 <label class="control-label">Status:</label>
																<select  class="form-control" name="srm_status" required>
																	<option value="">Choose Option</option>
																	<!--<option value="2">In Progress</option> 
																	<option value="23">Assign Engineer</option>--> 
																	<option value="245">Cancel Ticket</option>
																	<option value="246">Close Ticket</option>
																</select><br/>
																<input id="submit"   type="submit" name="close_ticket" class="btn btn-success pull-left"  value="Take Action">
															</div>
														</form>
													
													 
														</div>
													  </div>
													</div>
												</div>

												  

												<?php } ?>
											
											
											
											
											
											
											
												
												<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==245) { ?>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<p>Action Notes: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_notes'];?></p>
														<p>Action Taken By: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_name'];?></p>
														<p>Executive Phone: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_phone_no'];?></p>
														
														<span class="vertical-date">
															Action Taken On <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div> 
												</div>
												
												
												
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Service Engineer Assigned </h4>
														<p>Brand Ticket No : <?php echo $srm_request_list_particular_details[0]['srm_brand_tocket_no'];?></p>
														<p>SE Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_name'];?></p>
														<p>SE Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_number'];?></p>
														<p>SE Notes: <?php echo $srm_request_list_particular_details[0]['srm_SE_notes'];?></p>
														<p>SE Visiting Date: <?php echo $srm_request_list_particular_details[0]['srm_SE_visit_date'];?></p>
														<p>Date of Assign: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigned_date'];?></p>
														<p>SE Assigner Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_name'];?></p>
														<p>SE Assigner Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_phone'];?></p>
														<p>Priority: <?php echo $srm_request_list_particular_details[0]['srm_priority'];?></p>
													</div>
												</div>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-tag"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<h4>Service has been cancelled</h4> 
														<span class="vertical-date">
															Cancelled Date <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div>
												</div> 

												<?php } ?>
											
											
											
											
											
											
											
											
											
												
												<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==246) { ?>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<p>Action Notes: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_notes'];?></p>
														<p>Action Taken By: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_name'];?></p>
														<p>Executive Phone: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_phone_no'];?></p>
														
														<span class="vertical-date">
															Action Taken On <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div> 
												</div>
												
												
												
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Service Engineer Assigned </h4>
														<p>Brand Ticket No : <?php echo $srm_request_list_particular_details[0]['srm_brand_tocket_no'];?></p>
														<p>SE Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_name'];?></p>
														<p>SE Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_number'];?></p>
														<p>SE Notes: <?php echo $srm_request_list_particular_details[0]['srm_SE_notes'];?></p>
														<p>SE Visiting Date: <?php echo $srm_request_list_particular_details[0]['srm_SE_visit_date'];?></p>
														<p>Date of Assign: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigned_date'];?></p>
														<p>SE Assigner Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_name'];?></p>
														<p>SE Assigner Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_phone'];?></p>
														<p>Priority: <?php echo $srm_request_list_particular_details[0]['srm_priority'];?></p>
													</div>
												</div>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-tag"></i>
													</div>
													 
													<div class="vertical-timeline-content">
														<h4>SRM Request Closed</h4> 
														<span style="color:red"> Waiting for user feed back </span> <br/>
														<span> Executive Notes: <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_notes'];?><br/>
														Executive Phone:  <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_number'];?><br/>
														Executive Name:  <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_name'];?><br/> 
														</span>
														<span class="vertical-date"> SRM Request Closed <br/><small>
														<?php echo $srm_request_list_particular_details[0]['srm_TC_no_generated_date'];?></small></span>
													</div>
												</div> 

												<?php } ?>
											
											
												
												
												
												
												
												<!---In Progress---->
												
												<?php  if($srm_request_list_particular_details[0]['srm_status']==247) { ?>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-user"></i>
													</div>
													<div class="vertical-timeline-content"> 
														<p>Action Notes: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_notes'];?></p>
														<p>Action Taken By: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_name'];?></p>
														<p>Executive Phone: <?php echo $srm_request_list_particular_details[0]['srm_take_action_E_phone_no'];?></p>
														
														<span class="vertical-date">
															Action Taken On <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_take_action_c_date'];?></small>
														</span>
													</div> 
												</div>
												
												
												
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														 
														<h4>Service Engineer Assigned </h4>
														<p>Brand Ticket No : <?php echo $srm_request_list_particular_details[0]['srm_brand_tocket_no'];?></p>
														<p>SE Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_name'];?></p>
														<p>SE Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_number'];?></p>
														<p>SE Notes: <?php echo $srm_request_list_particular_details[0]['srm_SE_notes'];?></p>
														<p>SE Visiting Date: <?php echo $srm_request_list_particular_details[0]['srm_SE_visit_date'];?></p>
														<p>Date of Assign: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigned_date'];?></p>
														<p>SE Assigner Name: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_name'];?></p>
														<p>SE Assigner Phone No: <?php echo $srm_request_list_particular_details[0]['srm_SE_assigner_phone'];?></p>
														<p>Priority: <?php echo $srm_request_list_particular_details[0]['srm_priority'];?></p>
													</div>
												</div>
												
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon lazur-bg">
														<i class="fa fa-tag"></i>
													</div>
													 
													 
													<div class="vertical-timeline-content">
														<h4>SRM Request Closed</h4>  
														<span> Executive Notes: <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_notes'];?><br/>
														Executive Phone:  <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_number'];?><br/>
														Executive Name:  <?php echo $srm_request_list_particular_details[0]['srm_TC_execative_name'];?><br/> 
														</span>
														<span class="vertical-date"> SRM Request Closed <br/><small>
														<?php echo $srm_request_list_particular_details[0]['srm_TC_no_generated_date'];?></small></span>
													</div>
												</div> 
												
												
												
												
													
												<div class="vertical-timeline-block">
													<div class="vertical-timeline-icon blue-bg">
														<i class="fa fa-file-text"></i>
													</div>

													<div class="vertical-timeline-content">
														<h4>Service Completed</h4>
														<h5>User feedback</h5>
														<span> Is Engineer On Time ? : <?php echo $srm_request_list_particular_details[0]['srm_complete_eng_on_time'];?><br/>
														Eng Time Spent:  <?php echo $srm_request_list_particular_details[0]['srm_complete_eng_time_spent'];?><br/>
														User Rating:  <?php echo $srm_request_list_particular_details[0]['srm_complete_rating'];?><br/> 
														User Comments:  <?php echo $srm_request_list_particular_details[0]['srm_complete_comment'];?><br/> 
														</span>														
														<span class="vertical-date">
															Completed Date <br/>
															<small><?php echo $srm_request_list_particular_details[0]['srm_complete_date'];?></small>
														</span>
													</div>
												</div>
												  
												  
												  
												<?php } ?>
											
											
											
												
												<?php } ?>
												 
												
												
												
												 
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
