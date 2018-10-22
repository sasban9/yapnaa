<?php
session_start(); 
if(isset($_SESSION['admin_email_id'])){
	$admin_email_id		= $_SESSION['admin_email_id'];
	$admin_name			= $_SESSION['admin_name'];
	$admin_last_login	= $_SESSION['admin_last_login'];
    $ar_id  	        = $_SESSION['ar_id'];
	require_once('controller/admin_controller.php');
	$control			= new admin();	
	
	//echo '<pre>'.print_r($q_a);exit;
	
	if(isset($_POST['editAMCSubmit'])){
		//print_r($_POST);die;
		$paid_service=$_POST['paid_service'];
		$upgarde_product=$_POST['upgarde_product'];
		$paid_service_close_date=$_POST['paid_service_close_date'];
		$upgarde_product_date=$_POST['upgarde_product_date'];
		$paid_service_message=$_POST['paid_service_message'];
		$upgarde_product_message=$_POST['upgarde_product_message'];
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
		//print_r($_POST); die;
		$search 			= $_POST['search'];
		$action_taken_by 	= $_POST['action_taken_by'];
		$filter 			= $_POST['filter'];
		$filterByBrand 		= $_POST['filterByBrand'];
		$filterByAttempt 	= $_POST['filterByAttempt'];
		
		if(isset($_POST['fromDate']) && !empty($_POST['fromDate'])){
			$fromDate = date_format(date_create($_POST['fromDate']),"Y-m-d H:i:s");
		}
		else{
			$fromDate = "";
		}
		if(isset($_POST['toDate']) && !empty($_POST['toDate'])){
			$toDate = date_format(date_create($_POST['toDate'].' 23:59:59'),"Y-m-d H:i:s");
		}
		else{
			$toDate	=	"";
		}
		if(isset($_POST['yapnaaIdfm']) && !empty($_POST['yapnaaIdfm'])){
			$yapnaaIdfm = $_POST['yapnaaIdfm'];
		}
		else{
			$yapnaaIdfm = "";
		}
		if(isset($_POST['yapnaaIdto']) && !empty($_POST['yapnaaIdto'])){
			$yapnaaIdto = $_POST['yapnaaIdto'];
		}
		else{
			$yapnaaIdto	=	"";
		}
		if(isset($_POST['amc_fromDate']) && !empty($_POST['amc_fromDate'])){
			$amc_fromDate= date_format(date_create($_POST['amc_fromDate']),"d-m-Y");
		}
		else{
			$amc_fromDate=	"";
		}
		if(isset($_POST['amc_toDate']) && !empty($_POST['amc_toDate'])){
			$amc_toDate= date_format(date_create($_POST['amc_toDate']),"d-m-Y");
		}
		else{
			$amc_toDate=	"";
		}
		
		$get_amc_list = $control->get_brand_list($filterByAttempt,$action_taken_by,$search,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		//echo "<br><pre>"; print_r($get_amc_list); die;
		if(isset($_POST['da_downl']) || !empty($_POST['da_downl'])){
			$control->download_brand_list($filterByAttempt,$action_taken_by,$search,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
		}
	}
	
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
			
			<?php 
				if(isset($_GET['customer_type'])){
					switch($_GET['customer_type']){
						case 1:
						$customer='Livpure - KA';
						break;
						case 2:
						$customer='Zero B';
						break;
						case 3:
						$customer='Livpure - TN/KL';
						break;
						case 4:
						$customer='Bluestar B2B';
						break;
						case 5:
						$customer='Bluestar B2C';
						break;
					}
				}else{
					echo '<script>window.location.assign("index.php")</script>';
				}
			?>
				<h2><?php echo $customer; ?> Customer List</h2>
				<ol class="breadcrumb">
					<li>
						<a href="index.php">Home</a>
					</li>
					<li class="active">
						<strong><?php echo $customer; ?> Customer</strong>
					</li>
				</ol>
			</div>
			<div class="col-lg-2"></div>
        </div>         

		<div class="wrapper wrapper-content animated fadeInRight">
		
			<div class="row">
				<div class="col-lg-3">
					<input type="radio" id="newFilter" class="nFilter" name="newFilterCheck" value="New Filter" checked /> New Dashboard
					<input type="radio" id="oldFilter" class="nFilter" name="newFilterCheck" value="Old Filter" /> Old Dashboard
				</div><br>				
			</div>
			
			<br>
			 
			<div class="row"> </div><br>                
               
			<div class="row">
				<form id="form" method="POST" enctype="multipart/form-data">
				
                <div class="col-lg-3">
					<label>Search Keyword</label>
					<input type="text" id="searchBox" class="maincls form-control" value="<?php echo($_POST['search']==0)?$_POST['search']:"";?>"  maxlength="60" name="search" placeholder="Enter name, number or area">
				</div>
				<div class="col-lg-2 new" >
					<label>Filter By</label>
					<select id="filterByAttempt" class="form-control" name="filterByAttempt">
						<option value="0"<?php echo($_POST['filterByAttempt']==0)?"selected":"";?>>Filter</option>
						<option value="1" <?php echo($_POST['filterByAttempt']==1)?"selected":"";?>>Not Attempted Customer</option>						 
						
					</select>
				</div>
				<?php if($ar_id==1 || $ar_id==2 || $ar_id==5){?>
				 <div class="col-lg-2 new" >
					<label>Filter By</label> 
					<select id="filterByBrand" class="form-control" name="filterByBrand">
						<option value="0"<?php echo($_POST['filterByBrand']==0)?"selected":"";?>>Filter</option>
						<option value="1" <?php echo($_POST['filterByBrand']==1)?"selected":"";?>>Highly Engaged Customer</option>
						<option value="2"<?php echo($_POST['filterByBrand']==2)?"selected":"";?> >Engaged Customer</option>
						<option value="3" <?php echo($_POST['filterByBrand']==3)?"selected":"";?>>Partially Engaged </option>						
						<option value="4" <?php echo($_POST['filterByBrand']==4)?"selected":"";?>>Disengaged Customer</option>
					</select>
				</div>
				<?php }?>
                <div class="col-lg-2 old" style="display:none">
					<label>Filter By</label>
					<select  class="form-control" name="filter">
						<option value="0"<?php echo($_POST['filter']==0)?"selected":"";?>>Filter</option>
						<option value="1" <?php echo($_POST['filter']==1)?"selected":"";?>>Call Back</option>
						<option value="2"<?php echo($_POST['filter']==2)?"selected":"";?> >Not Interested</option>
						<option value="3" <?php echo($_POST['filter']==3)?"selected":"";?>>Appointment Set</option>
						<option value="5"<?php echo($_POST['filter']==5)?"selected":"";?> >Yapnaa Interested SMS Sent</option>
						<option value="6" <?php echo($_POST['filter']==6)?"selected":"";?>>Expiry SMS Sent</option>
						<option value="7" <?php echo($_POST['filter']==7)?"selected":"";?>>Yapnaa Registered</option>
						<option value="8" <?php echo($_POST['filter']==8)?"selected":"";?>>Renewed AMCs</option>
					</select>
				</div>
				<?php if($ar_id==1 || $ar_id==2){?>
				 <div class="col-lg-2">
					<label>Action By</label>
					<select  class="form-control" name="action_taken_by">
						<option value=""<?php echo(trim($_POST['action_taken_by'])=='')?"selected":"";?>>Filter</option>
						<option value="Jitesh" <?php echo(trim($_POST['action_taken_by'])=='Jitesh')?"selected":"";?>>Jitesh</option>
						<option value="Vineet"<?php echo(trim($_POST['action_taken_by'])=='Vineet')?"selected":"";?> >Vineet</option>
						<option value="Sriram" <?php echo(trim($_POST['action_taken_by'])=='Sriram')?"selected":"";?>>Sriram</option>
						<option value="Jalaja"<?php echo($_POST['action_taken_by']=='Jalaja')?"selected":"";?> >Jalaja</option>
						<option value="Harshal"<?php echo($_POST['action_taken_by']=='Harshal')?"selected":"";?> >Harshal</option>
					</select>
				</div>
					<?php }?>
			   
					
			</div>
			</br>
			<div class="row">
				<div class="col-lg-2 " >
					<label>From</label>
					<input type="text" class="form-control" placeholder="Yapnaa Id"  id="yapnaaIdfm" name="yapnaaIdfm" >
				</div>
				<div class="col-lg-2 " >
					<label>To</label>
					<input type="text" class="form-control"  placeholder="Yapnaa Id" id="yapnaaIdto" name="yapnaaIdto" >
				</div>
				<div class="col-lg-2 old" style="display:none;">
					<label>AMC From</label>
					<input type="date" class="form-control"  id="amc_fromDate" name="amc_fromDate" >
				</div>
				<div class="col-lg-2 old"  style="display:none;">
					<label>AMC To</label>
					<input type="date" class="form-control"  id="amc_toDate" name="amc_toDate" >
				</div>
					<div class="col-lg-2 "  > 
					<label class="new">Updated From</label>
					<label class="old" style="display:none">Last Call From</label>
					<input type="date" class="form-control" id="fromDate" name="fromDate" value="<?php echo(isset($_POST['fromDate']))?$_POST['fromDate']:"";?>">
				</div>
				<div class="col-lg-2"  >
					<label class="new">Updated To</label>
					<label class="old" style="display:none">Last Call To</label>
					<input type="date" class="form-control"  id="toDate" name="toDate" value="<?php echo(isset($_POST['toDate']))?$_POST['toDate']:"";?>">
				</div>
				<div class="col-lg-2"  style="margin-top: 23px;">
					<input type="submit"   class="btn btn-info " value="Search"  name="submit" >
				</div>
				<?php if($ar_id==1 || $ar_id==2 || $ar_id==5){?>
				<div class="col-sm-2"  style="margin-left: -86px;margin-top: 23px;">
					<input type="submit" id="da_downl" name="da_downl"  class="btn btn-info" value="Export">
				</div>
				<?php }?>
				<div class="col-lg-2">
					<input type="submit"   class="btn btn-info pull-right"  name="none" style="visibility:hidden;">
				</div>
				</form>
			</div>
		</div> 
	
        <div class="wrapper wrapper-content animated fadeInRight" style="margin-top: -30px;">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
				<!--form action="send-sms.php" method="POST"-->
				<form action="send-sms.php" method="POST">
                    <table class="table table-striped table-bordered table-hover dataTables-example" >
					<thead>
						<tr>
							<th><!--input type="checkbox" name="" id="selectAll" /--></th>
							<th>Yapnaa ID</th>
							<th><?php echo $customer; ?> ID</th>
							<th>Phone </th>
							
							<?php if($_GET['customer_type'] == 4 || $_GET['customer_type'] == 5){ ?>
								<th>Company Name</th>
							<?php }else{ ?>
								<th>Name</th>
							<?php } ?>
							
							<th>AMC From & To</th>
							<th>Last Call</th>
							<th>Last Action</th>
							<th>Last Comment/SMS</th>
							<th>Action</th> 
						</tr>
					</thead>
					
					<tbody>
					<?php $j=1;?>
					<?php 
						if(!empty($get_amc_list)){
							$numbers 			= array_column($get_amc_list,"PHONE1");
							$qust_map['qst'] 	= array_column($get_amc_list,"qust_map");
						}
						$qust_map = json_encode( $qust_map ); //convert array to a JSON string
						$qust_map = htmlspecialchars( $qust_map, ENT_QUOTES );
						
						for($i=0;$i<count($get_amc_list);$i++){ 
								
							date_default_timezone_set('Asia/Kolkata');
	
							$date 			= new DateTime();
							$lastdatecall 	= $get_amc_list[$i]['last_called'];
							$lastdatecall1 	= new DateTime($lastdatecall);
							$diff			= $date->diff($lastdatecall1);
															
							$date1 = strtotime(date_format(date_create($get_amc_list[$i]['last_called']),"d-m-Y"));
							$date2 = strtotime(date_format($date,"d-m-Y"));
							
							$datediff= (int)round(($date2 - $date1)/3600/24,0);
							
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
							<td 
								<?php 
									switch($get_amc_list[$i]['status']){
								
										case 0:
											echo $get_amc_list[$i]['CUSTOMERID'];
										break;
										
										case 1:
										//Asked to call back
											if(!$datediff <= 15){
												echo 'style="background-color:yellow;color:black;font-style:bold;"'.$get_amc_list[$i]['CUSTOMERID'];
											}
										break;
										
										case 2:
										//AMC Renewal
											if(!$datediff <= 15){
												echo 'style="background-color:red;color:white;font-style:bold;"'.$get_amc_list[$i]['CUSTOMERID'];
											}
										break;
										
										case 3:
										//Appointment set
											if(!$datediff <= 15){
												echo 'style="background-color:green;color:white;font-style:bold;"'.$get_amc_list[$i]['CUSTOMERID'];
											}
										break;
										
										case 4:
										//Registered in App
											if(!$datediff <= 15){
												echo 'style="background-color:orange;color:white;font-style:bold;"<i class="fa fa-thumbs-o-up" style="margin-right:3%;"></i>'.$get_amc_list[$i]['CUSTOMERID'];
											}
										break;
										
										case 5:
											echo 'style="background-color:yellow;color:black;font-style:bold;"'.$get_amc_list[$i]['CUSTOMERID'];
										break;
										
										case 6:
										//AMC Expiry SMS sent
											if(!$datediff <= 15){
												echo 'style="background-color:yellow;color:black;font-style:bold;"'.$get_amc_list[$i]['CUSTOMERID'];
											}
										break;
										
										case 7:
										//AMC REnewed
											echo 'style="background-color:yellow;color:black;font-style:bold;"'.$get_amc_list[$i]['CUSTOMERID'];
											
										break;
										case 8:
										//paid service
											echo 'style="background-color:yellow;color:black;font-style:bold;"'.$get_amc_list[$i]['CUSTOMERID'];
											
										break;
										case 9:
										//upgrade
											echo 'style="background-color:yellow;color:black;font-style:bold;"'.$get_amc_list[$i]['CUSTOMERID'];
											
										break;
										
										default:
											echo $get_amc_list[$i]['CUSTOMERID'];
										break;
									}
								?>>
									
							</td>
							
							<td><?php echo $get_amc_list[$i]['PHONE1']; ?>
								<!-- <?php if($ar_id==1 || $ar_id==2 || $ar_id==5){?>
									<button type="button" style="margin-right:2px;" class="btn btn-info pull-right actionBox" 
									data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" 
									data-mobile2="<?php echo $get_amc_list[$i]['PHONE2']; ?>" 
									data-id="<?php echo $get_amc_list[$i]['id']; ?>"
									data-contract="<?php echo $get_amc_list[$i]['CONTRACT_FROM']; ?>" 
									data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" 
									data-next-service-data="<?php echo $get_amc_list[$i]['next_service_date']; ?>" 
									data-last-service-data="<?php echo $get_amc_list[$i]['last_service_date']; ?>" 
									data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" 
									data-email="<?php echo $get_amc_list[$i]['email']; ?>" 
									data-address="<?php echo $get_amc_list[$i]['CUSTOMER_ADDRESS1']; ?>" 
									data-customerid="<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>"
									data-user-qm="<?php echo $qust_map; ?>"
									data-toggle="modal" data-target="#userQstM" title="Edit AMC Details">
									<i class="fa fa-eye"></i></button>	
								<?php } ?> -->
							</td>
							
							<?php if($_GET['customer_type'] == 4 || $_GET['customer_type'] == 5){ ?>
								<td><?php echo $get_amc_list[$i]['CUSTOMER_ADDRESS1']; ?></td>
							<?php }else{ ?>
								<td><?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?></td>
							<?php } ?>
							
							<td><?php echo (empty($get_amc_list[$i]['CONTRACT_FROM']) && empty($get_amc_list[$i]['CONTRACT_TO'])) ? '-' :($get_amc_list[$i]['CONTRACT_FROM']." to ".$get_amc_list[$i]['CONTRACT_TO']); ?></td>
							<td><?php echo ($get_amc_list[$i]['last_called'] == '0000-00-00 00:00:00') ? '-' : $get_amc_list[$i]['last_called']; ?></td> 
							<td><?php
							
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
							
							?></td> 
							<td><?php echo empty($get_amc_list[$i]['last_call_comment'])?$get_amc_list[$i]['last_sms_sent']:$get_amc_list[$i]['last_call_comment']; ?></td>
							
							<td>
							
							<!-- <button type="button" style="margin-right:2px;" class="btn btn-info pull-right actionBox" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-mobile2="<?php echo $get_amc_list[$i]['PHONE2']; ?>" data-id="<?php echo $get_amc_list[$i]['id']; ?>" data-contract="<?php echo $get_amc_list[$i]['CONTRACT_FROM']; ?>" data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-customerid="<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>" data-email="<?php echo $get_amc_list[$i]['email']; ?>" data-toggle="modal" data-target="#editAMC" title="Edit AMC Details"><i class="fa fa-pencil"></i></button> -->
							
							<?php if($_GET['customer_type'] == 4 ||$_GET['customer_type'] == 5) { ?>
								<!-- <button type="button"   
								style="margin-right:2px; width:38px" 
								class="custdatam btn btn-info pull-right actionBox" 
								onclick="custQA('<?php echo $get_amc_list[$i]['CUSTOMER_ADDRESS1']; ?>',<?php echo $get_amc_list[$i]['PHONE1']; ?>,'<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>')" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-mobile2="<?php echo $get_amc_list[$i]['PHONE2']; ?>"
								data-id="<?php echo $get_amc_list[$i]['id']; ?>" 
								data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_ADDRESS1']; ?>" data-email="<?php echo $get_amc_list[$i]['email']; ?>" data-customerid="<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>" data-toggle="modal" data-target="#myAction"><i class="fa fa-ellipsis-v"></i>
								</button> -->
								
								<button type="button" style="margin-right:2px; width:38px" class="custdatam btn btn-info pull-right actionBox" onclick="window.open('ajaxqa.php?customer_type=<?php echo $_GET['customer_type'];?>&brand_customer_id=<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>&user_phone=<?php echo $get_amc_list[$i]['PHONE1']; ?>&user_id=<?php echo $get_amc_list[$i]['id']; ?>')"><i class="fa fa-ellipsis-v"></i>
								</button>
								
							<?php } ?>
							<?php if($_GET['customer_type'] == 1 || $_GET['customer_type'] == 2 || $_GET['customer_type'] == 3) { ?>
								<!-- <button type="button"   
								style="margin-right:2px; width:38px" 
								class="custdatam btn btn-info pull-right actionBox" 
								onclick="custQA('<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>',<?php echo $get_amc_list[$i]['PHONE1']; ?>,'<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>')" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-mobile2="<?php echo $get_amc_list[$i]['PHONE2']; ?>"
								data-id="<?php echo $get_amc_list[$i]['id']; ?>" 
								data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-email="<?php echo $get_amc_list[$i]['email']; ?>" data-customerid="<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>" data-toggle="modal" data-target="#myAction"><i class="fa fa-ellipsis-v"></i>
								</button> -->
								
								<button type="button" style="margin-right:2px; width:38px" class="custdatam btn btn-info pull-right actionBox" onclick="window.open('ajaxqa.php?customer_type=<?php echo $_GET['customer_type'];?>&brand_customer_id=<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>&user_phone=<?php echo $get_amc_list[$i]['PHONE1']; ?>&user_id=<?php echo $get_amc_list[$i]['id']; ?>')"><i class="fa fa-ellipsis-v"></i>
								</button>
								
							<?php } ?>
														
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
        
<!-- Modal for admin view questions-->
<div class="modal fade" id="userQstM" role="dialog">
    <div class="modal-dialog  modal-lg"  style="width:80%;margin-right: 20%;margin-top: 2px;">
    
      <!-- Modal content-->
		<div class="modal-content">
        <div class="modal-body" style="padding: 20px 30px 0px 30px;" >
			<div class="row"  style="padding-bottom:10px;border-bottom: 1px solid #e5e5e5;">
				<button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="modal-title1">&nbsp;</h4>
			</div>
			
			<form method="post" id="form_amcDateSub">
				<div class="row">
				
					<div class="col-lg-3" style="border-right: 1px solid #e5e5e5;"> 
						<h4>CUSTOMER DETAILS</h4>
						<div class="row" style="margin-left: 3px;">
							<label>Name</label>
							<span class="maincls form-control" id="cust_name1"  name="cust_name1" style="border:none;padding-left: 0px;"></span>
						</div>
						<div class="row" style="margin-left: 3px;">
							<label>Customer ID</label>
							<span class="maincls form-control" id="cust_id"  name="cust_id" style="border:none;padding-left: 0px;"></span>
						</div>	
						<div class="row" style="margin-left: 3px;">
							<label><b>Customer Email Id</b></label>
							<span class="maincls form-control" id="cust_email1"  name="cust_email1" style="border:none;padding-left: 0px;"></span>
						</div>				 
						<div class="row" style="margin-left: 3px;">
							<label>Phone Number</label>
							<span  class="maincls form-control" id="phone11"  name="phone11" style="border:none;padding-left: 0px;"></span>
						</div>
						<div class="row" style="margin-left: 3px;">
							<label>Customer Address</label>
							<span class="maincls form-control" id="cust_address"  name="cust_address" style="border:none;padding-left: 0px;"></span>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 19px;">
							<label>Satisfaction Level</label>  
							<span class="maincls form-control" id=""  name="" style="border:none;padding-left: 0px;"></span>
						</div>
						<div class="row" style="margin-left: 3px;">
							<label>Loyality Index</label>
							<span class="maincls form-control" id=""  name="" style="border:none;padding-left: 0px;"></span>
						</div>
					</div>
					
					<div class="col-lg-3" style="border-right: 1px solid #e5e5e5;height:448px;"> 
						<h4>CUSTOMER SENTIMENT DATA</h4>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
						  <div class="col-md-9">1. Service by Brand</div><div id="service_bb"  class="col-md-3"></div> 
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
						 <div class="col-md-9">2. Under AMC</div><div id="service_amc"  class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
						<div class="col-md-9">3. Satisfied with timelines</div><div  id="service_st"   class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
						<div class="col-md-9">4. Satisfied with workmanship</div><div id="service_sw"   class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
						<div class="col-md-9">5. Likely to buy next product</div><div id="service_buy"  class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
						<div class="col-md-9">6. Refers product</div><div  id="service_pd"  class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
						<div class="col-md-9">7. Share knowledge</div><div id="service_kwd"  class="col-md-3"></div>
						</div>
					</div> 
					
					<div class="col-lg-3" style="border-right: 1px solid #e5e5e5;height:448px;"> 
						<h4>CUSTOMER ENGAGEMENT DATA</h4><br>
						<div class="row" style="margin-left: 3px;">
						  <div class="col-md-9">1. AMC Signed</div><div id="next_ser_dt" class="col-md-3"></div><br>
						  <div class="col-md-12">a) Next Service Date</div><br>
						  <div class="col-md-12"> 
							<input type="date" class="form-control"  id="next_service_date" name="next_service_date" style="width: 160px;height: 33px;" >
						  </div>
						</div>
						<div class="row" style="margin-left: 3px;">
						  <div class="col-md-12">b) Expiry Date</div><br><div class="col-md-12">
						  
						  <input type="date" class="form-control"  id="expiry_date" name="expiry_date" style="width: 160px;height: 33px;" >
						  </div>
						</div>
						<div class="row" style="margin-left: 3px;">
						  <br><div class="col-md-9">2. Paid Service.Last Service Date</div><div id="last_ser_dt" class="col-md-3"></div><br>
						  <div class="col-md-12"> 
						 <input type="date" class="form-control"  id="ls_ser_date" name="ls_ser_date" style="width: 160px;height: 33px;" >
						 </div>
						</div>
						<div class="row" style="margin-left: 3px;">
						   <div class="col-md-12"> 3. Not Interested Due to-</div> 
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 10px;"> 
						   <div class="col-md-9">a) Poor service</div><div id="poor_sr"  class="col-md-3"></div> 
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 10px;">
						  <div class="col-md-9">b) Cost reasons</div><div id="cust_res"  class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 10px;">
						  <div class="col-md-9">c) Not convenient</div><div id="not_conv"  class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 10px;">
						   <div class="col-md-9">d) Bad experience</div><div id="bad_exp"   class="col-md-3"></div>
						</div>
					</div>
					
					<div class="col-lg-3" >
						<h4>CONVERSION OPPORTUNITY</h4>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
							<div class="col-md-9">1. Service Request</div><div id="service_rec"  class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
							<div class="col-md-9">2. AMC Enquiry</div><div id="amc_enquery"  class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
							<div class="col-md-9">3. Upgrade Enquiry </div><div  id="upgrd"  class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
							<div class="col-md-9">4. Escalation</div><div  id="escl"  class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;">
							<div class="col-md-9">5. Note on AMC Details</div><div id="amcdetails"  class="col-md-3"></div>
						</div>
						<div class="row" style="margin-left: 3px;margin-top: 21px;"> 
							<div class="col-md-9">6. Note on Upgrade Offers</div><div  id="upgradeoffers"  class="col-md-3"></div>
						</div>
					</div>
					
				</div>
			</div>
			 <div class="modal-footer">
				
				<input type="button" id="amcDateSub" name="amcDateSub" class="btn btn-info pull left" data-toggle="modal" value="Save">
								
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</form>
        </div>
      </div>
      
    </div>
</div>  
  
<div class="modal fade" id="csv_yapana" role="dialog">
    <div class="modal-dialog  modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal-title">&nbsp;</h4>
        </div>
        <div class="modal-body">
			
         
			
		<form action="csv_file_up_yapnna.php" method="POST" enctype="multipart/form-data">
		 <input type="file" name="file" class="" >	
		<!--div class="col-lg-5"> 
        </div-->
        <div class="modal-footer">
			
			<input type="submit" id="up_csv" name="up_csv" class="btn btn-info pull left" data-toggle="modal">
							
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		</form>
        </div>
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
			case 4:
			var brandName='Bluestar B2B';
			break;
			case 5:
			var brandName='Bluestar B2C';
			break;
		}
		
		$("#custID").val($('.actionBox').attr('data-customerid'));
		$("#phone1").val($('.actionBox').attr('data-mobile'));
		$("#phone2").val($('.actionBox').attr('data-mobile2'));
		$("#cust_name").val($('.actionBox').attr('data-name'));
		$("#cust_email").val($('.actionBox').attr('data-email'));
		
		i=0;
		
		
		$("#callBack").click(function(){
			if($("#comments").val() == '' && $("#std_comments").find(":selected").val()==''){
				alert("Enter comments first!");
			}
			else{
				var custType=<?php echo $_GET['customer_type'];?>;
				var fncomment=$("#std_comments").find(":selected").val()+' '+$("#comments").val();
				$.ajax({
					url:"smsActions.php?callBack=submit",
					type:"POST",
					data:{id:sessionStorage.id,comment:fncomment,custType:custType},
					success:function(response){
						console.log(response);
						if(response){
							alert("Comment updated successfully.");
							location.reload();
						}
					},
					error:function(error){
						alert(JSON.stringify(error));
					}
				});
			}
		});
		
		
		$( "#amcform" ).submit(function( event ) { 
			var paidservice=$("input:checkbox[name=paid_service]:checked").val();
			var paid_service_close_date=$('#paid_service_close_date').val();
			var upgarde_product=$("input:checkbox[name=upgarde_product]:checked").val();
			var upgarde_product_date=$('#upgarde_product_date').val();
			if(paidservice==1 && paid_service_close_date ==''){
				  alert('Please select the date')
				  location.reload();
				  return false;		
			}
			if(upgarde_product==1 && upgarde_product_date ==''){
				  alert('Please select the date')
				  location.reload();
				  return false;
			}
			return true; 
		});
		
		
	</script>

    <!-- Page-Level Scripts -->
    
</body>
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
 