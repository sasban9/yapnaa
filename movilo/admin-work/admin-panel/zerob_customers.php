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
	
	if(isset($_POST['search']) || !empty($_POST['search'])){
		$search = $_POST['search'];
		$filter = $_POST['filter'];
		
		$fromDate = date_format(date_create($_POST['fromDate']),"Y-m-d G:H:i");
		$toDate = date_format(date_create($_POST['toDate']),"Y-m-d G:H:i");
		//echo $date1;exit;
		$get_amc_list = $control->get_zerob_list($search,$filter,$fromDate,$toDate);
	}
	/*else{
		$get_amc_list = $control->get_zerob_list("");
	}*/
	
	// Get Sub Categories List
	
	// echo  '<pre>';
	// print_r($get_amc_list);
	
	 
	
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
                    <h2>ZeroB Customer List</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li class="active">
                            <strong>ZeroB Customer</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
           

		<div class="wrapper wrapper-content animated fadeInRight">
			<div class="row">
				<form id="form" method="POST" enctype="multipart/form-data">
				<!--div class="col-lg-2">
					<input type="submit" id="submit"  class="btn btn-info pull-right"  name="none" style="visibility:hidden;">
				</div-->
                <div class="col-lg-3">
					<label>Search Keyword</label>
					<input type="text" id="searchBox" class="maincls form-control"  maxlength="60" name="search" placeholder="Enter name, number or area">
				</div>
                <div class="col-lg-2">
					<label>Filter By</label>
					<select id="filterBy" class="form-control" name="filter">
						<option value="0">Filter</option>
						<option value="1" style="background-color:yellow">Call Back</option>
						<option value="2"  style="background-color:red;color:white;">Not Interested</option>
						<option value="3" style="background-color:green;color:white;">Appointment Set</option>
						<option value="5"  style="background-color:#23c6c8;color:white;">General SMS Sent</option>
						<option value="6"  style="background-color:red;color:white;">Expiry SMS Sent</option>
						<option value="7"  style="background-color:orange;color:white;">Yapnaa Registered</option>
					</select>
				</div>
				<div class="col-lg-2">
					<label>From</label>
					<input type="date" class="form-control" id="fromDate" name="fromDate">
				</div>
				<div class="col-lg-2">
					<label>To</label>
					<input type="date" class="form-control"  id="toDate" name="toDate">
				</div>
				<div class="col-lg-2"  style="margin-left:-9%;">
					<input type="submit" id="submit"  class="btn btn-info pull-right" value="Search"  name="submit" >
				</div>
				<div class="col-lg-2">
					<input type="submit" id="submit"  class="btn btn-info pull-right"  name="none" style="visibility:hidden;">
				</div>
				</form>
			</div>
		</div> 
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
					<thead>
					<tr>
							<th>ZeroB ID</th>
							<th>Phone </th>
							<th>Name</th>
							<th>AMC From & To</th>
							<th>Last Call</th>
							<th>Last Action</th>
							<th>Action</th> 
						
						
					</tr>
					</thead>
					<tbody>
					<?php $j=1;?>
					<?php for($i=0;$i<count($get_amc_list);$i++){ 
								
							date_default_timezone_set('Asia/Kolkata');
	
							$date = new DateTime("now");
							$date1 = strtotime(date_format(date_create($get_amc_list[$i]['last_called']),"d-m-Y"));
							$date2 = strtotime(date_format($date,"d-m-Y")); 
							$diff = date_diff(date_create($date),date_create($get_amc_list[$i]['last_called']));
							
							//echo "<br>".$date1."--".$date2."--".$diff."<br>";
							$datediff= (int)round(($date2 - $date1)/3600/24,0);
							//echo "Days".$datediff;
					?>
						<tr>
							<td <?php 
									if($get_amc_list[$i]['users'] != null || !empty($get_amc_list[$i]['users'])){
											echo 'style="background-color:orange;color:white;font-style:bold;"><i class="fa fa-thumbs-o-up" style="margin-right:3%;"></i>Yapnaa Registered';
										}
									
									else{
											
											switch($get_amc_list[$i]['status']){
										
												case 1:
												//Asked to call back
													if(!$datediff <= 15){
														echo 'style="background-color:yellow;color:black;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													}
												break;
												
												case 2:
												//AMC Renewal
													if(!$datediff <= 15){
														echo 'style="background-color:red;color:white;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													}
												break;
												
												case 3:
												//Appointment set
													if(!$datediff <= 15){
														echo 'style="background-color:green;color:white;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													}
												break;
												
												case 4:
												//Registered in App
													if(!$datediff <= 15){
														echo 'style="background-color:orange;color:white;font-style:bold;"><i class="fa fa-thumbs-o-up" style="margin-right:3%;"></i>Yapnaa Registered';
													}
												break;
												
												case 5:
												//Default sms sent
												break;
												
												case 6:
												//AMC Expiry SMS sent
													if(!$datediff <= 15){
														echo 'style="background-color:yellow;color:black;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													}
												break;
												
												default:
													echo $get_amc_list[$i]['CUSTOMERID'];
												break;
											}
											/*if($datediff <= 15){ 
												echo "style='background-color:#23c6c8;color:white;'>";
											}*/
											//echo $get_amc_list[$i]['CUSTOMERID']; 
										}
										
									
									
									
									?>
									
							</td>
							<td><?php echo $get_amc_list[$i]['PHONE1']; ?></a></td>
							<td><?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?></td>
							<td><?php echo (empty($get_amc_list[$i]['CONTRACT_FROM']) && empty($get_amc_list[$i]['CONTRACT_TO'])) ? '-' :($get_amc_list[$i]['CONTRACT_FROM']." to ".$get_amc_list[$i]['CONTRACT_TO']); ?></td>
							<td><?php echo ($get_amc_list[$i]['last_called'] == '0000-00-00 00:00:00') ? '-' : $get_amc_list[$i]['last_called']; ?></td> 
							<td><?php
							if($get_amc_list[$i]['users'] == null || empty($get_amc_list[$i]['users'])){
								switch($get_amc_list[$i]['status']){
									
									case 1:
										echo "Call back";
									break;
									case 2:
										echo "Not interested";
									break;
									case 3:
										echo "Appointment set";
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
									
									default:
										echo "-";
									break;
								}
							}
							else{
								echo "Registered in App";
							}
								
							
							?></td> 
							<td><?php if(!($datediff <= 15)){ ?>  <button type="button" class="btn btn-info pull-right actionBox" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-id="<?php echo $get_amc_list[$i]['id']; ?>" data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-toggle="modal" data-target="#myAction">Action Box</button><?php }?></td>   
							 
						</tr>
					<?php $j++; } ?>
					</tbody>
				</table>  

                    </div>
                </div>
            </div>
            </div>
        </div>
        
  <!-- Modal -->
  <div class="modal fade" id="myAction" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal-title">Do something!</h4>
        </div>
        <div class="modal-body">
          <div class="row">
				<div class="col-lg-4"> 
					<label>Appointment Time</label>
				</div>
				<div class="col-lg-5"> 
					<input type="datetime-local"  class="maincls form-control" id="appDate"  name="bdaytime"/>
				</div>
				<div class="col-lg-3"> 
					<button type="button" class="btn btn-success" id="appSMS">
								<i class="fa fa-calendar" style="margin-right:3%;"></i>Send SMS &nbsp;</button>
				</div>
			</div>
          <div class="row" style="margin-top:2%;">
				<div class="col-lg-4"> 
					<label>AMC Expiry Msg</label>
				</div>
				<div class="col-lg-4"> 
					<input type="date"  class="maincls form-control" id="amcExp"  name="amcexp"/>
				</div>
				<div class="col-lg-3"> 
					<button type="button" class="btn btn-success" id="expirySMS">
								<i class="fa fa-calendar" style="margin-right:3%;"></i>Send Reminder &nbsp;</button>
				</div>
			</div>
		<div class="row"  style="margin-top:2%;">
			<i class="fa fa-comments" style="margin-right:1%;"></i><label>Customers Comments:</label></br>
				<textarea rows="5" cols="70" id="comments" class="maincls form-control" ></textarea>
		</div>
		 <div class="row" style="margin-top:2%;">
			<div class="col-lg-5"> 
				<button type="button" class="btn btn-danger" data-toggle="modal" id="noInsterest" data-target="#myAction">
							<i class="fa fa-microphone-slash" style="margin-right:3%;"></i>Customer Not Interested</button>
			</div>
			
				<div class="col-lg-5"> 
				<button type="button" class="btn btn-warning" id="general" data-toggle="modal" data-target="#myAction">
									<i class="fa fa-bullhorn" style="margin-right:3%;"></i>Send AMC General message</button>
			</div>
		   </div>
        </div>
        <div class="modal-footer">
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myAction">
							<i class="fa fa-mail-reply" style="margin-right:3%;"></i>Call customer back, later</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
               
<?php include "footer.php";?>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                responsive: true,
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });

			$(".actionBox").click(function(){
				sessionStorage.id = $(this).attr('data-id');
				sessionStorage.name = $(this).attr('data-name');
				sessionStorage.mobile = $(this).attr('data-mobile');
				sessionStorage.expiry = $(this).attr('data-expiry');
				var now = new Date(sessionStorage.expiry);
				
				var day = ("0" + now.getDate()).slice(-2);
				var month = ("0" + (now.getMonth() + 1)).slice(-2);

				var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
				
				//$('#datePicker').val(today);
				
				if(sessionStorage.expiry){
					$("#amcExp").val(today);
				}
				$("#modal-title").html("Customer Name: "+sessionStorage.name);
			});
			
			$("#appSMS").click(function(){
				var date = $("#appDate").val();
				if(date == ''){
					alert("Appointment Date and time is not entered!");
				}
				else{
					$.ajax({
						url:"smsActions.php?appointmentDate="+date,
						type:"POST",
						data:{id:sessionStorage.id,number:sessionStorage.mobile,comment:$("#comments").val()},
						success:function(response){
							console.log(response);
							if(response){
								alert("SMS sent successfully.");
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					});
				}
			});
			
			$("#expirySMS").click(function(){
				var date = $("#amcExp").val();
				if(date == ''){
					alert("Expiry Date is not entered!");
				}
				else{
					$.ajax({
						url:"smsActions.php?expiryDate="+date,
						type:"POST",
						data:{id:sessionStorage.id,number:sessionStorage.mobile},
						success:function(response){
							console.log(response);
							if(response){
								alert("SMS sent successfully.");
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					});
				}
			});
			
			$("#noInsterest").click(function(){
				if($("#comments").val() == ''){
					alert("Enter comments first!");
				}
				else{
					$.ajax({
						url:"smsActions.php?notInterested=submit",
						type:"POST",
						data:{id:sessionStorage.id,comment:$("#comments").val()},
						success:function(response){
							console.log(response);
							if(response){
								alert("Comment updated successfully.");
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					});
				}
			});
			
			$("#general").click(function(){ 
					$.ajax({
						url:"smsActions.php?general=submit",
						type:"POST",
						data:{id:sessionStorage.id,number:sessionStorage.mobile,comment:$("#comments").val()},
						success:function(response){
							console.log(response);
							if(response){
								alert("SMS sent successfully.");
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					});
				
			});

        });


    </script>
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
