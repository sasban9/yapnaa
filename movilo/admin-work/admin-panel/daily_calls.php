<?php
session_start();
 
if(isset($_SESSION['admin_email_id'])){
	$admin_email_id		= $_SESSION['admin_email_id'];
	$admin_name			= $_SESSION['admin_name'];
	$admin_last_login	= $_SESSION['admin_last_login'];
    $ar_id  	        = $_SESSION['ar_id'];
	require_once('controller/admin_controller.php');
	$control			= new admin();	
	
	//echo '<br><pre>'.print_r($_SESSION);
	
	$fromDate	     	= date('Y-m-d');
	$todate 			= date('Y-m-d');
	$admin_id 			= $_SESSION['admin_id'];
	
	$get_brand_name		= $control->get_brand_name($admin_id);
	//print_r($get_brand_name);
	$join_table_name    = $get_brand_name['brandname'];
	
	if(isset($_POST['editAMCSubmit'])){
		//print_r($_POST);die;
		$paid_service				= $_POST['paid_service'];
		$upgarde_product			= $_POST['upgarde_product'];
		$paid_service_close_date	= $_POST['paid_service_close_date'];
		$upgarde_product_date		= $_POST['upgarde_product_date'];
		$paid_service_message		= $_POST['paid_service_message'];
		$upgarde_product_message	= $_POST['upgarde_product_message'];
		switch($_GET['customer_type']){
			case 1:
			$table='livpure';
			break;
			case 2:
			$table='zerob_consol1';
			break;
			case 3:
			$table='livpure_tn_kl';
			break;
			case 4:
			$table='bluestar_b2b';
			break;
			case 5:
			$table='bluestar_b2c';
			break;
		}
		
		$get_amc_list = $control->updateAMC($table,$upgarde_product_message,$paid_service_message,$upgarde_product_date,$paid_service_close_date,$paid_service,$upgarde_product,$_SESSION['admin_email_id'],$_POST['newAMCStart'],$_POST['newAMCEnd'],$_POST['custID'],$_POST['comments'],$_POST['closedBy'],$_POST['phone1'],$_POST['phone2'],$_POST['cust_name'],$_POST['cust_email']);
		
		if($get_amc_list){
			$_POST = array();
			echo "<script>alert('Updated successfully');</script>";
		}
		else{
			$_POST = array();
			echo "<script>alert('Something went wrong');</script>";
		}
	}
	
	if(isset($_POST['search']) || !empty($_POST['search'])){
		$search 		= $_POST['search'];
		
		if(isset($_POST['fromDate']) && !empty($_POST['fromDate'])){
			$fromDate 	= date_format(date_create($_POST['fromDate']),"Y-m-d H:i:s");
		}
		else{
			$fromDate 	= "";
		}
		if(isset($_POST['toDate']) && !empty($_POST['toDate'])){
			$toDate 	= date_format(date_create($_POST['toDate'].' 23:59:59'),"Y-m-d H:i:s");
		}
		else{
			$toDate		= "";
		}
		
		for($i=0;$i<count($get_brand_name);$i++){
			$get_amc_list 	= $control->get_filtered_amc_list_from_brand_and_call($search,$fromDate,$toDate,$admin_id,$get_brand_name);
		}//die;
		
	}
	
	else{
		foreach($get_brand_name as $key => $value){
			$result			= $control->get_amc_list_from_brand_and_call('',$fromDate,$toDate,$admin_id,$value);
			$result1[] 		= $result;
			$get_amc_list 	= array_reduce($result1, 'array_merge', array());	
		}
	}
	//echo "<br><pre>"; print_r($get_amc_list); die;
	$std_comments = $control->get_standard_comments(); 
	
?>


<style>

.modal{
	width:124%;
	min-width:124%;
}

.modal-dialog {
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
}

.table-striped{
	font-size:13px;
}

.datebrand{
	left: 1167.86px !important;
}

</style>

<!DOCTYPE html>
<html>

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
	<link href="css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
</head>

<body>
    <div id="wrapper">
       <?php include "header.php";?>
	</div>

	<div class="row wrapper border-bottom white-bg page-heading">	
		<div class="col-lg-10">
			<h2>Customer List</h2>
			<ol class="breadcrumb">
				<li><a href="index.php">Home</a></li>
				<li class="active"><strong><?php echo $customer; ?> Customer</strong></li>
			</ol>
		</div>
		<div class="col-lg-2"></div>
	</div>
           

	<div class="wrapper wrapper-content animated fadeInRight">		               
		<div class="row">		
			<form id="form" method="POST" enctype="multipart/form-data">
                <div class="col-lg-3">
					<label>Search Keyword</label>
					<input type="text" id="searchBox" class="maincls form-control" value="<?php echo($_POST['search']==0)?$_POST['search']:"";?>"  maxlength="60" name="search" placeholder="Enter name, number or area">
				</div>
				<div class="col-lg-2 "  > 
					<label class="new">Updated From</label>
					<input type="date" class="form-control" id="fromDate" name="fromDate" value="<?php echo(isset($_POST['fromDate']))?$_POST['fromDate']:"";?>">
				</div>
				<div class="col-lg-2"  >
					<label class="new">Updated To</label>
					<input type="date" class="form-control"  id="toDate" name="toDate" value="<?php echo(isset($_POST['toDate']))?$_POST['toDate']:"";?>">
				</div>
				<div class="col-lg-2"  style="margin-top: 23px;">
					<input type="submit" class="btn btn-info" value="Search" name="submit" >
				</div>
			</form>	
		</div>		
	</div> 
	
    <div class="wrapper wrapper-content animated fadeInRight" style="margin-top: -30px;">
		<div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
						<form action="send-sms.php" method="POST">
							<table class="table table-striped table-bordered table-hover dataTables-example" >
								<thead>
									<tr>
										<th><!--input type="checkbox" name="" id="selectAll" /--></th>
										<th>Yapnaa ID</th>
										<th>BRAND ID</th>
										<th>BRAND NAME</th>
										<th>Phone </th>
										<th>Name</th>
										<th>AMC From & To</th>
										<th>Last Call</th>
										<th>Last Action</th>
										<th>Last Comment/SMS</th>
										<th>Action</th>
									</tr>
								</thead>
								
								<tbody>
									<?php $j=1;?>
									<?php //echo '<pre>';print_r($get_amc_list);exit;
									if(!empty($get_amc_list)){
										$numbers 		= array_column($get_amc_list,"PHONE1");//print_r($numbers);die;
										$qust_map['qst'] = array_column($get_amc_list,"qust_map");
									}
									
									$qust_map 			= json_encode( $qust_map ); //convert array to a JSON string
									$qust_map 			= htmlspecialchars( $qust_map, ENT_QUOTES );
									
									for($i=0;$i<count($get_amc_list);$i++){ 
											
										date_default_timezone_set('Asia/Kolkata');
										$date 			= new DateTime();
										$lastdatecall 	= $get_amc_list[$i]['last_called'];
										$lastdatecall1 	= new DateTime($lastdatecall);
										$diff			= $date->diff($lastdatecall1);
										
										//$diff = date_diff(date_create($date),date_create($get_amc_list[$i]['last_called']));
																		
										$date1 		= strtotime(date_format(date_create($get_amc_list[$i]['last_called']),"d-m-Y"));
										$date2 		= strtotime(date_format($date,"d-m-Y"));
										
										$datediff	= (int)round(($date2 - $date1)/3600/24,0);
										
										if(!empty($get_amc_list[$i]['qust_map'])){
											$qust_map1	= $get_amc_list[$i]['qust_map'];
										}
										if(!empty($get_amc_list[$i]['PHONE1'])){
											$PHONE1		= $get_amc_list[$i]['PHONE1'];
										}
										
									?>
									<tr>
										<td><input  type="checkbox" name="sms[]" value="<?php echo $get_amc_list[$i]['PHONE1'];?>" /></td>
										<td><?php echo $get_amc_list[$i]['id'];?></td>
										<td><?php echo $get_amc_list[$i]['CUSTOMERID'];?></td>
										<td><?php echo $get_amc_list[$i]['brandname'];?></td>
										<td><?php echo $get_amc_list[$i]['PHONE1']; ?></a></td>
										<td><?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?></td>
										<td><?php echo (empty($get_amc_list[$i]['CONTRACT_FROM']) && empty($get_amc_list[$i]['CONTRACT_TO'])) ? '-' :($get_amc_list[$i]['CONTRACT_FROM']." to ".$get_amc_list[$i]['CONTRACT_TO']); ?></td>
										<td><?php echo ($get_amc_list[$i]['last_called'] == '0000-00-00 00:00:00') ? '-' : $get_amc_list[$i]['last_called']; ?></td> 
										<td>
										<?php
											switch($get_amc_list[$i]['status']){
												
												case 1:
													echo "Call back";
												break;
												case 2:
													echo "Not interested";
												break;
												case 3:
													
													if($get_amc_list[$i]['req_service_date'] !=NULL)
													{
													$time = strtotime($get_amc_list[$i]['req_service_date']);
													echo "Service Appointment - ".date('d-m-Y H:i',$time);
													}
													else if($get_amc_list[$i]['req_amc_date'] !=NULL)
													{
													$time = strtotime($get_amc_list[$i]['req_amc_date']);
													echo "AMC Appointment - ".date('d-m-Y H:i',$time);
													}
													else if($get_amc_list[$i]['req_upgrade_date'] !=NULL)
													{
													$time = strtotime($get_amc_list[$i]['req_upgrade_date']);
													echo "Upgrade Appointment - ".date('d-m-Y H:i',$time);
													}
													else if($get_amc_list[$i]['req_follow_up_date'] !=NULL)
													{
													$time = strtotime($get_amc_list[$i]['req_follow_up_date']);
													echo "Follow up Appointment - ".date('d-m-Y H:i',$time);
													}
													else{
													$time = strtotime($get_amc_list[$i]['amc_appointment_datetime']);
													echo "Appointment set - ".date('d-m-Y H:i',$time);
													}
												break;
												case 4:
													echo "Registered in App";
												break;
												case 6:
													echo "AMC Expiry SMS sent";
												break;
												case 5:
													echo "General SMS sent";
												break;
												case 7:
													echo "AMC renewed";
												break;
												case 8:
												$time = strtotime($get_amc_list[$i]['req_service_date']);										
													echo "Paid service closed -".date('d-m-Y H:i',$time);
												break;
												case 9:
												$time = strtotime($get_amc_list[$i]['req_upgrade_date']);										
													echo "Upgrade offer -".date('d-m-Y H:i',$time); 
												break;
												default:
													echo "-";
												break;
											}
										
										?>
										</td> 
										<td><?php echo empty($get_amc_list[$i]['last_call_comment'])?$get_amc_list[$i]['last_sms_sent']:$get_amc_list[$i]['last_call_comment']; ?></td>
										<td>
										
											<!-- <button type="button" style="margin-right:2px;" class="btn btn-info pull-right actionBox" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-mobile2="<?phpecho $get_amc_list[$i]['PHONE2']; ?>" data-id="<?php echo $get_amc_list[$i]['id']; ?>" data-contract="<?php echo $get_amc_list[$i]['CONTRACT_FROM']; ?>" data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-customerid="<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>" data-email="<?php echo $get_amc_list[$i]['email']; ?>" data-toggle="modal" data-target="#editAMC" title="Edit AMC Details"><i class="fa fa-pencil"></i></button> -->
											
											<?php  
												if($get_amc_list[$i]['brandname'] == 'livpure'){
													$_GET['customer_type'] 		= 1;
												}else if($get_amc_list[$i]['brandname'] == 'zerob_consol1'){
													$_GET['customer_type'] 		= 2;
												}else if($get_amc_list[$i]['brandname'] == 'livpure_tn_kl'){
													$_GET['customer_type'] 		= 3;
												}else if($get_amc_list[$i]['brandname'] == 'bluestar_b2b'){
													$_GET['customer_type'] 		= 4;
												}else if($get_amc_list[$i]['brandname'] == 'bluestar_b2c'){
													$_GET['customer_type'] 		= 5;
												}
												
											?>
											
											<button type="button" style="margin-right:2px; width:38px" class="custdatam btn btn-info pull-right actionBox" onclick="window.open('ajaxqa.php?customer_type=<?php echo $_GET['customer_type']?>&brand_customer_id=<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>&user_phone=<?php echo $get_amc_list[$i]['PHONE1']; ?>&user_id=<?php echo $get_amc_list[$i]['id']; ?>')"><i class="fa fa-ellipsis-v"></i></button>
											
										</td>   
										 
									</tr>
									<?php $j++; } ?>
								</tbody>
							
							</table>  
						
							<div class="row">
								<button type="submit" class="btn btn-success" id="sendSMSSubmit" name="sendSMSSubmit">
									<i class="fa fa-envelope"></i> Send SMS for Selected
								</button>
								<button type="button" class="btn btn-success" name="sendAllSubmit" id="sendAllSubmit">
									<i class="fa fa-envelope"></i> Send SMS for All
								</button>
								<?php if($ar_id==1 || $ar_id==2){?>
								<button type="button" class="btn btn-success" data-toggle="modal" data-target="#csv_yapana" name="csv_upl" id="csv_upl">
									 UPLOAD 
								</button> 
								<?php }?>
							</div>
						</form>
                    </div>
                </div>
            </div>
            </div>
        </div>

		<!-- Modal -->
		<div class="modal fade" id="editAMC" role="dialog" style="left: -135px;">
			<div class="modal-dialog  modal-lg">
			  <!-- Modal content-->
			  <div class="modal-content">
				 <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title" id="modal-title">Update Customer Status</h4>
				 </div>
				 <div class="modal-body">
					<div class="row" style="margin-top:2%;">
					   <div class="col-lg-5"></div>
					   <div class="col-lg-5"></div>
					</div>
					<div class="row">
					   <div class="col-lg-3"><label>Current AMC Duration:</label></div>
					   <div class="col-lg-4"><label id="currentAMC"></label></div>
					</div>
					<div class="line line-dashed line-lg pull-in"></div>
					<form action="" method="POST" id="amcform">
					   <div class="row" style="margin-top:5%;margin-bottom:5%;">
						  <div class="col-lg-3"><label>New AMC date</label></div>
						  <div class="col-lg-3"> 
							 <input type="date"  class="maincls form-control" id="newAMCStart"  name="newAMCStart" />
						  </div>
						  <div class="col-lg-1"><label>to</label></div>
						  <div class="col-lg-3"> 
							 <input type="date"  class="maincls form-control" id="newAMCEnd"  name="newAMCEnd" />
						  </div>
						  <div class="col-lg-1" hidden> 
							 <input type="text"   class="maincls form-control" id="custID"  name="custID" />
							 <input type="text"   class="maincls form-control" id="phone2"  name="phone2" />
						  </div>
					   </div>
					   <div class="row" style="margin-top:5%;margin-bottom:5%;">
						  <div class="col-sm-3" ><b>Paid Service feedback:</b></div>
						  <div class="col-sm-1" ><input type="checkbox" name="paid_service" value="1"></div>
						  <div class="col-sm-3" ><input type="date"  class="maincls form-control" id="paid_service_close_date"  name="paid_service_close_date" /></div>
						  <div class="col-sm-3" ><textarea rows="6" cols="50"  class="form-control" id="paid_service_message"  name="paid_service_message">How was your experience with the Livpure service done recently? Share your feedback http://bit.ly/lvpure-care.</textarea></div>
					   </div>
					   <div class="row" style="margin-top:5%;margin-bottom:5%;">
						  <div class="col-sm-3" ><b>Upgrade product:</b></div>
						  <div class="col-sm-1" ><input type="checkbox" name="upgarde_product" value="1"></div>
						  <div class="col-sm-3" ><input type="date"  class="maincls form-control" id="upgarde_product_date"  name="upgarde_product_date" /></div>
						  <div class="col-sm-3" >
							 <textarea rows="6" cols="50" class="form-control" id="upgarde_product_message"  name="upgarde_product_message">Thank you for choosing Livpure. Let us know your experience after upgrading to a new model. <bitly link></textarea>
						  </div>
					   </div>
					   <div class="row" style="margin-top:5%;margin-bottom:5%;">
						  <label>Deal closed by?</label>
						  <input type="radio" name="closedBy" value="Yapnaa" checked>Yapnaa
						  <input type="radio" name="closedBy" value="Others" >3rd Party
					   </div>
					   <div class="row" style="margin-top:5%;margin-bottom:5%;">
						  <div class="col-lg-3" > 
							 <label>Name</label>
							 <input type="text"   class="maincls form-control" id="cust_name"  name="cust_name" />
						  </div>
						  <div class="col-lg-3" > 
							 <label>Phone Number</label>
							 <input type="text"   class="maincls form-control" id="phone1"  name="phone1" />
						  </div>
						  <div class="col-lg-3" > 
							 <label>Customer Email Id</label>
							 <input type="text"   class="maincls form-control" id="cust_email"  name="cust_email" />
						  </div>
					   </div>
					   <div class="row"  style="margin-top:2%;">
						  <i class="fa fa-comments" style="margin-right:1%;"></i><label>Customers Comments:</label></br>
						  <textarea rows="5" cols="70" id="comments" name="comments" class="maincls form-control" ></textarea>
					   </div>
					</form>	
					
				 </div>
				 
				 <div class="modal-footer">
					<input type="submit" id="editAMCSubmit" name="editAMCSubmit" class="btn btn-info pull left" data-toggle="modal" data-target="#myAction">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				 </div>
				 
			  </div>
			</div>
		</div>  


<?php include "footer.php";?>
<script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>
	<script type="text/javascript" src="js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
	<script type="text/javascript">
		$(".form_datetime").datetimepicker({
			format: "dd-mm-yyyy hh:ii",
			linkField: "mirror_field",
			linkFormat: "yyyy-mm-dd hh:ii"
		});
	</script> 
	<link rel="stylesheet" href="css/jquery.simple-dtpicker.css">
    <script src="js/jquery.simple-dtpicker.js"></script>
    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>
	
	<script>
			$('input[type=radio][name=17]').on('change', function() {
				 if($(this).val()=='Yes') {
					 $('.service_requested').show();
					 $(function(){
						var now  = new Date();
						now.setDate(now.getDate() + 2)
						now.setHours(8);
						now.setMinutes(0);
						now.setMilliseconds(0);

						$('*[name=service_requested_date]').appendDtpicker({
						"closeOnSelected": true,
						"current": new Date(now),	
						"dateFormat": "DD-MM-YYYY hh:mm",
						"futureOnly": true
						});
					});
				 }
				 else{
					 $('.service_requested').hide();
				 }
					 
			});
			
			$('input[type=radio][name=19]').on('change', function() {
				 if($(this).val()=='Yes') {
					 $('.amc_requested').show();
					 $(function(){
						var now  = new Date();
						now.setDate(now.getDate() + 2)
						now.setHours(8);
						now.setMinutes(0);
						now.setMilliseconds(0);

						$('*[name=amc_requested_date]').appendDtpicker({
						"closeOnSelected": true,
						"current": new Date(now),	
						"dateFormat": "DD-MM-YYYY hh:mm",
						"futureOnly": true
						});
					});
				 }
				 else{
					 $('.amc_requested').hide();
				 }
					 
			});
			
			$('input[type=radio][name=21]').on('change', function() {
				 if($(this).val()=='Yes') {
					 $('.wish_upgrade').show();
					 $(function(){
						var now  = new Date();
						now.setDate(now.getDate() + 2)
						now.setHours(8);
						now.setMinutes(0);
						now.setMilliseconds(0);

						$('*[name=wish_upgrade_date]').appendDtpicker({
						"closeOnSelected": true,
						"current": new Date(now),	
						"dateFormat": "DD-MM-YYYY hh:mm",
						"futureOnly": true
						});
					});
				 }
				 else{
					 $('.wish_upgrade').hide();
				 }
					 
			});
			
			$('input[type=radio][name=24]').on('change', function() {
				 if($(this).val()=='Yes') {
					 $('.follow_up').show();
					  $(function(){
						var now  = new Date();
						now.setDate(now.getDate() + 2)
						now.setHours(8);
						now.setMinutes(0);
						now.setMilliseconds(0);

						$('*[name=follow_up_date]').appendDtpicker({
						"closeOnSelected": true,
						"current": new Date(now),	
						"dateFormat": "DD-MM-YYYY hh:mm", 
						"futureOnly": true
						});
					});
				 }
				 else{
					 $('.follow_up').hide();
				 }
					 
			});
			
		    $('input[type=radio][name=newFilterCheck]').on('change', function() {
				 switch($(this).val()) {
					 case 'New Filter':
						$('.old').hide();
						$('.new').show();
						
						 break;
					 case 'Old Filter':
					   
						$('.old').show();
						$('.new').hide();   
						 break;
				 }
			});
			
			$('input[type="checkbox"][name="engaged_status"]').change(function() {
				 if(this.checked) {
					$('.engaged_status').show();
				 }
				 else{
					 $('.engaged_status').hide();
				 }
			 });
			
			$("#selectAll").click(function(){
				if($(this).attr('checked') != 'checked'){
					$("input[type='checkbox']").attr('checked', true);
				}
				else{
					$("input[type='checkbox']").attr('checked', false);
				}
				
			});
			
			$("#sendSMSSubmit").click(function(){
				
				var row = [];
                $.each($("input[name='sms[]']:checked"), function() {
					row.push($(this).val());
				});
				
			
				var energy = row.join();
				
				localStorage.setItem('numbers',energy);
				
				location.href = "send-sms.php";
			}); 
			
			$("#sendAllSubmit").click(function(){
				
				localStorage.setItem('numbers','<?php echo implode(",",array_values($numbers));?>');
				location.href = "send-sms.php";
			});
			
			var custmobile;
			var idcust;
			var namecust; 
            var custType= <?php echo $_GET['customer_type'];?>;
			//var brandName=(custType==2)?'Zero B':'Livpure';
			switch(custType){
				case 2:
				var brandName='Zero B';
				break;
				case 1:
				var brandName='Livpure - KA';
				break;
				case 3:
				var brandName='Livpure - TN/KL';
				break;
			}
			
	</script>
	
    <!-- Page-Level Scripts -->
    
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
 