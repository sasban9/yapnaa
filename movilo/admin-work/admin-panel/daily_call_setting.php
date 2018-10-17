<?php

session_start();
 
if(isset($_SESSION['admin_email_id'])) {
	$admin_email_id			= $_SESSION['admin_email_id'];
	$admin_name				= $_SESSION['admin_name'];
	$admin_last_login		= $_SESSION['admin_last_login'];
    $ar_id  	        	= $_SESSION['ar_id'];
    $admin_id  	        	= $_SESSION['admin_id'];
	require_once('controller/admin_controller.php');
	$control				= new admin();
	//echo "<br><pre>";print_r($_SESSION);exit;
	
	/* if(isset($_REQUEST['getCityFromBrand'])){
		$get_amc_list = $control->get_city_from_brand();
		print_r($get_amc_list);die;
	} */
	
	if(isset($_POST['brandname']) || !empty($_POST['brandname'])){
		//echo "<br><pre>";print_r($_POST);die;
		$inp 		= file_get_contents('daily_call_schedule.json');
		$tempArray  = json_decode($inp,true);
		if(!empty($tempArray)){
			$adminid = explode('_',$_POST['agentname']);
			$_POST['admin_id'] 	= $adminid[1];
			
			array_push($tempArray, $_POST);
			$jsonData   		= json_encode($tempArray);
			file_put_contents('daily_call_schedule.json', $jsonData);
		}
		else{
			$adminid = explode('_',$_POST['agentname']);
			$_POST['admin_id'] 	= $adminid[1];
			
			$jsonData   		= json_encode($_POST);
			file_put_contents('daily_call_schedule.json', $jsonData);
		}
		
	}
	
	//Now from direct url . Later have to add in CRON OR a refresh button
	//http://13.126.160.18/movilo/admin-work/admin-panel/daily_call_setting.php?getCallAgencyData=1
	
	if($_GET['getCallAgencyData']){
		$str 						= file_get_contents('daily_call_schedule.json');
		$data 						= json_decode($str,true);
		foreach($data as $key => $value){
			$total 					= $value['number']; 
			$get_customer_list 		= $control->getDataFromMasterTableByCondition($value['brandname'],$total);
			foreach($get_customer_list as $key1 => $value1){
				//For Inserting Data
				$set_customer_list 	= $control->setCustomerListToTable($value,$value1);
			}
		}	
	}
	
	
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
			<h2>Call Agency Distribution</h2>
			<ol class="breadcrumb">
				<li><a href="index.php">Home</a></li>
				<li class="active"><strong>Call Agency</strong></li>
			</ol>
		</div>
    </div>

	<div class="wrapper wrapper-content animated fadeInRight">
		<form id="form" method="POST" enctype="multipart/form-data">		
			
			<div class="row">
				<div class="col-lg-2 new" >
					<label>Brand</label>
					<select id="brandname" class="form-control" name="brandname">
						<option value="">SELECT</option>
						<option value="livpure">Livepure KA</option>
						<option value="livpure_tn_kl">Livepure TN</option>
						<option value="zerob_consol1">Zero B KA</option>
						<option value="bluestar_b2b">Bluestar B2B</option>
						<option value="bluestar_b2c">Bluestar B2C</option>
					</select>
				</div>
				
				<input type="hidden" name="admin_id" id="admin_id" value="<?php echo $admin_id; ?>" />
				
				<div class="col-lg-2 new" >
					<label>City</label>
					<input type="text" class="form-control" value="" id="city" name="city" placeholder="Enter City">
				</div>
			
				<div class="col-lg-2 new" >
					<label>Agent</label>
					<select id="agentname" class="form-control" name="agentname">
						<option value="">SELECT</option>
						<option value="Jalaja_7">Jalaja</option>
						<option value="Sowmya_10">Sowmya</option>
						<option value="Anusha_11">Anusha</option>
						<option value="Caller1_15">Caller1</option>
						<option value="Caller2_16">Caller2</option>
						<option value="Caller3_17">Caller3</option>
					</select>
				</div>
				
				<div class="col-lg-2 new" >
					<label>Status</label>
					<select id="agentname" class="form-control" name="status">
						<option value="">SELECT</option>
						<option value="Newdata">Newdata</option>
						<option value="Escalation Related">Escalation Related</option>
						<option value="No response">No response</option>
						<option value="Not Reachable">Not Reachable</option>
						<option value="Callback">Callback</option>
						<option value="Not interested">Not interested</option>
						<option value="By installation date">By installation date</option>
					</select>
				</div>
				
				<div class="col-lg-2 new" >
					<label>Number</label>
					<input type="number" class="form-control" value="" id="number" name="number" placeholder="Enter number">
				</div>

				<div class="col-lg-2" style="margin-top: 23px;">
					<input type="submit" class="btn btn-info " value="Save"  name="submit" >
				</div>
			</div>	
			
			<!-- <div class="row" style="margin-top: 20px;">
				<div class="col-lg-2 new" >
					<label>Not Reachable</label>
					<input type="number" class="form-control" value="" id="notreachable" name="notreachable" placeholder="Enter number">
				</div>
			
				<div class="col-lg-2 new" >
					<label>Call Back</label>
					<input type="number" class="form-control" value="" id="callback" name="callback" placeholder="Enter number">
				</div>
				
				<div class="col-lg-2 new" >
					<label>Collect Feedback</label>
					<input type="number" class="form-control" value="" id="collectfeedback" name="collectfeedback" placeholder="Enter number">
				</div>
				
				<div class="col-lg-2 new" >
					<label>Called By Agent</label>
					<input type="number" class="form-control" value="" id="calledbyagent" name="calledbyagent" placeholder="Enter number">
				</div>
				
				<div class="col-lg-2 new" >
					<label>Escalate Feedback</label>
					<input type="number" class="form-control" value="" id="escalatefeedback" name="escalatefeedback" placeholder="Enter number">
				</div>
				
				<div class="col-lg-2" style="margin-top: 23px;">
					<input type="submit" class="btn btn-info " value="Save"  name="submit" >
				</div>
			</div> -->
			
		</form>
	</div>
	
	<div class="row">
		<div class="col-lg-2 new" >
			<input type="button" onClick="parent.location='/movilo/admin-work/admin-panel/daily_call_setting.php?getCallAgencyData=1'" class="btn btn-info " value="Refresh"  name="Refresh" >
		</div>
	</div>
		   
<?php include "footer.php";?>

	<script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>
	
	<script>
		/* $("#brandname").on('change',function(){
			var selectedBrand 	= $("#brandname").val();
			$.ajax({
				url:"call_agencies.php?getCityFromBrand",
				type:"POST",
				data:{selectedBrand:selectedBrand},
				success:function(response){
					
				} 
			});
		}); */
	
	</script>	
    
</body>

</html>

<?php } else { ?>

<script>
  window.location.assign("../index.php")
</script>

<?php } ?>


<?php 

//$sql 		= "SELECT ".$value['brandname'].".id FROM ".$value['brandname']." WHERE ".$value['brandname'].".status != 3 LIMIT ".$total." ";
			
/* INSERT INTO userondeviceontime (SELECT '', DATE(ud.Pdatetime) as UdatDate,HOUR(ud.Ptime) as UdtTime,ud.Deviceid as UdtDeviceid,count(ud.Pid) as UdtUser FROM stafanduser ud WHERE DATE(ud.Pdatetime) BETWEEN '2018-03-05' AND '2018-03-05' AND HOUR(ud.Ptime) BETWEEN 10 AND 22 AND ud.UserType = 'Passenger' AND ud.TotalTime > 0 AND DATE(ud.Pdatetime) != '2018-03-11' GROUP BY HOUR(Ptime),Deviceid,Pid); */

/*
INSERT INTO call_agencies_2 ('','livpure_2',3,'Steffi_11',SELECT (livpure_2.id) FROM livpure_2 WHERE livpure_2.status != 3 LIMIT 100,'Bengaluru',10,10,20,20,20,20,0,2018-07-24);
*/

/*
INSERT INTO call_agencies_2 (id,brandname,admin_id,agentname,brand_id,city,notinterested,notreachable,callback,collectfeedback,calledbyagent,escalatefeedback,status,created_date)
VALUES ('','livpure_2',3,'Steffi_11',SELECT livpure_2.id FROM livpure_2 WHERE livpure_2.status != 3 LIMIT 100,'Bengaluru',10,10,20,20,20,20,0,2018-07-24)
*/

//echo "<br><pre>";print_r($sql);die;

?>
 