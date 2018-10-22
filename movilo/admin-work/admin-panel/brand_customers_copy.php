<?php
session_start(); 
if(isset($_SESSION['admin_email_id'])){
	$admin_email_id	= $_SESSION['admin_email_id'];
	$admin_name		= $_SESSION['admin_name'];
	$admin_last_login	= $_SESSION['admin_last_login'];
    $ar_id  	        = $_SESSION['ar_id'];
	require_once('controller/admin_controller.php');
	$control	=	new admin();	
	
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
	
	/*else{
		$get_amc_list = $control->get_zerob_list("");
	}*/
	
	// Get Sub Categories List
	
	//echo '<pre>';print_r($get_amc_list[0]['qust_map']); exit;
	
	
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
	
							/* $date = new DateTime("now");
							$date1 = strtotime(date_format(date_create($get_amc_list[$i]['last_called']),"d-m-Y"));
							$date2 = strtotime(date_format($date,"d-m-Y")); 
							$diff = date_diff(date_create($date),date_create($get_amc_list[$i]['last_called']));
							
							$datediff= (int)round(($date2 - $date1)/3600/24,0);
							$qust_map1= $get_amc_list[$i]['qust_map'];
							
							$PHONE1=$get_amc_list[$i]['PHONE1']; */
							
							
							$date 			= new DateTime();
							$lastdatecall 	= $get_amc_list[$i]['last_called'];
							$lastdatecall1 	= new DateTime($lastdatecall);
							$diff			= $date->diff($lastdatecall1);
							
							//$diff = date_diff(date_create($date),date_create($get_amc_list[$i]['last_called']));
															
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
							<td <?php 
											switch($get_amc_list[$i]['status']){
										
												case 0:
													echo ">".$get_amc_list[$i]['CUSTOMERID'];
												break;
												
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
														echo 'style="background-color:orange;color:white;font-style:bold;"><i class="fa fa-thumbs-o-up" style="margin-right:3%;"></i>'.$get_amc_list[$i]['CUSTOMERID'];
													}
												break;
												
												case 5:
													echo 'style="background-color:yellow;color:black;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
												break;
												
												case 6:
												//AMC Expiry SMS sent
													if(!$datediff <= 15){
														echo 'style="background-color:yellow;color:black;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													}
												break;
												
												case 7:
												//AMC REnewed
														echo 'style="background-color:yellow;color:black;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													
												break;
												case 8:
												//paid service
														echo 'style="background-color:yellow;color:black;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													
												break;
												case 9:
												//upgrade
														echo 'style="background-color:yellow;color:black;font-style:bold;">'.$get_amc_list[$i]['CUSTOMERID'];
													
												break;
												
												default:
													echo $get_amc_list[$i]['CUSTOMERID'];
												break;
											}
									?>
									
							</td>
							<td><?php echo $get_amc_list[$i]['PHONE1']; ?></a>
								<?php if($ar_id==1 || $ar_id==2 || $ar_id==5){?>
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
								<?php } ?>
							</td>
							
							<?php if($_GET['customer_type'] == 4 || $_GET['customer_type'] == 5){ ?>
								<td><?php echo $get_amc_list[$i]['CUSTOMER_ADDRESS1']; ?></td>
							<?php }else{ ?>
								<td><?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?></td>
							<?php } ?>
							
							<td><?php echo (empty($get_amc_list[$i]['CONTRACT_FROM']) && empty($get_amc_list[$i]['CONTRACT_TO'])) ? '-' :($get_amc_list[$i]['CONTRACT_FROM']." to ".$get_amc_list[$i]['CONTRACT_TO']); ?></td>
							<td><?php echo ($get_amc_list[$i]['last_called'] == '0000-00-00 00:00:00') ? '-' : $get_amc_list[$i]['last_called']; ?></td> 
							<td><?php
							//if($get_amc_list[$i]['users'] == null || empty($get_amc_list[$i]['users'])){
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
							/*}
							else{
								echo "Registered in App";
							}*/
								
							
							?></td> 
							<td><?php echo empty($get_amc_list[$i]['last_call_comment'])?$get_amc_list[$i]['last_sms_sent']:$get_amc_list[$i]['last_call_comment']; ?></td>
							<td><?php //if(!($datediff <= 15)){ ?>  
							<button type="button" style="margin-right:2px;" class="btn btn-info pull-right actionBox" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-mobile2="<?php echo $get_amc_list[$i]['PHONE2']; ?>" data-id="<?php echo $get_amc_list[$i]['id']; ?>" data-contract="<?php echo $get_amc_list[$i]['CONTRACT_FROM']; ?>" data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-customerid="<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>" data-email="<?php echo $get_amc_list[$i]['email']; ?>" data-toggle="modal" data-target="#editAMC" title="Edit AMC Details"><i class="fa fa-pencil"></i></button>
							
							<?php if($_GET['customer_type'] == 4 ||$_GET['customer_type'] == 5) { ?>
								<button type="button"   
								style="margin-right:2px; width:38px" 
								class="custdatam btn btn-info pull-right actionBox" 
								onclick="custQA('<?php echo $get_amc_list[$i]['CUSTOMER_ADDRESS1']; ?>',<?php echo $get_amc_list[$i]['PHONE1']; ?>,'<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>')" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-mobile2="<?php echo $get_amc_list[$i]['PHONE2']; ?>"
								data-id="<?php echo $get_amc_list[$i]['id']; ?>" 
								data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_ADDRESS1']; ?>" data-email="<?php echo $get_amc_list[$i]['email']; ?>" data-customerid="<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>" data-toggle="modal" data-target="#myAction"><i class="fa fa-ellipsis-v"></i>
								</button>
							<?php } ?>
							<?php if($_GET['customer_type'] == 1 || $_GET['customer_type'] == 2 || $_GET['customer_type'] == 3) { ?>
								<button type="button"   
								style="margin-right:2px; width:38px" 
								class="custdatam btn btn-info pull-right actionBox" 
								onclick="custQA('<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>',<?php echo $get_amc_list[$i]['PHONE1']; ?>,'<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>')" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-mobile2="<?php echo $get_amc_list[$i]['PHONE2']; ?>"
								data-id="<?php echo $get_amc_list[$i]['id']; ?>" 
								data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-email="<?php echo $get_amc_list[$i]['email']; ?>" data-customerid="<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>" data-toggle="modal" data-target="#myAction"><i class="fa fa-ellipsis-v"></i>
								</button>
							<?php } ?>
							
							
							
							<?php //}?></td>   
							 
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
        

<!-- Question and Answer Modal -->
<div class="modal fade" id="myAction" role="dialog">
    <div class="modal-dialog  modal-lg" style="width:80%;margin-right: 22%;margin-top: 2px;">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="modal-title">&nbsp;</h4>
			</div>
			
			<div class="modal-body">
				<div class="row" style="padding-bottom:10px;border-bottom: 1px solid #e5e5e5;">
					<div class="col-lg-5" style="border-right: 1px solid #e5e5e5;"> 
					
						<h4 id="serviceLavel"></h4>
						<label id="serviceByBrand" style="color:blue"></label></br>
						
						<br><label id="custQuistionId1" data-qid="1"></label><br>
						
							<div class="row"> 
								<div class="col-lg-4" >							
									<input type="radio" class="chk" id="ansq1" data-qid="1" value="" name="1"	> 
									<span id="sansq1"></span>								
								</div>
							 
								<div class="col-lg-4">   								
									<input type="radio" class="chk" id="ansq2" data-qid="1" value="" name="1"	> 
									<span id="sansq2"></span>									
								</div>
							 
								<div class="col-lg-4">						
									<input type="radio" class="chk" id="ansq3" data-qid="1" value="" name="1"	> 
									<span id="sansq3"></span>								
								</div>
							</div>
												
					 
						<br><label id="custQuistionId2" data-qid="2"></label><br>
						
							<div class="row"> 
								<div class="col-lg-4" >		
									<input type="radio" class="chk" id="ansq4" data-qid="2" value="" name="2"	> 
									<span id="sansq4"></span>	
								</div>
							 
								<div class="col-lg-4" >								
									<input type="radio" class="chk" id="ansq5" data-qid="2" value="" name="2"	> 
									<span id="sansq5"></span>
								</div>
							 
								<div class="col-lg-4" >						
									<input type="radio" class="chk" id="ansq6" data-qid="2" value="" name="2"	> 
									<span id="sansq6"></span>
								</div>
							</div>
												
					 
						<br><label id="custQuistionId3" data-qid="3"></label><br>
						
							<div class="row"> 
							 
									<div class="col-lg-4" >
																	
										<input type="radio" class="chk" id="ansq7" data-qid="3" value="" name="3"	> 
										 <span id="sansq7"></span>
										 </div>
								 
									<div class="col-lg-4" >
																	
										<input type="radio" class="chk" id="ansq8" data-qid="3" value="" name="3"	> 
										 <span id="sansq8"></span>
										 </div>
								 
									<div class="col-lg-4" >
																	
										<input type="radio" class="chk" id="ansq9" data-qid="3" value="" name="3"	> 
										 <span id="sansq9"></span>
										 </div>
														</div>
												
					 
						<br><label id="custQuistionId4" data-qid="4"></label><br>
						
							<div class="row"> 
							 
									<div class="col-lg-4" >
																	
										<input type="radio" class="chk" id="ansq10" data-qid="4" value="" name="4"	> 
										 <span id="sansq10"></span>
										 </div>
								 
									<div class="col-lg-4" >
																	
										<input type="radio" class="chk" id="ansq11" data-qid="4" value="" name="4"	> 
										 <span id="sansq11"></span>
										 </div>
								 
									<div class="col-lg-4" >
																	
										<input type="radio" class="chk" id="ansq12" data-qid="4" value="" name="4"	> 
										 <span id="sansq12"></span>
										 </div>
									</div>
												
					 
						<br><label id="custQuistionId5" data-qid="5"></label><br>
						
							<div class="row"> 
							 
									<div class="col-lg-4" >
																	
										<input type="radio" class="chk" id="ansq13" data-qid="5" value="" name="5"	> 
										 <span id="sansq13"></span>
										 </div>
								 
									<div class="col-lg-4" >
																	
										<input type="radio" class="chk" id="ansq14" data-qid="5" value="" name="5"	> 
										 <span id="sansq14"></span>
										 </div>
								 
									<div class="col-lg-4" >
																	
										<input type="radio" class="chk" id="ansq15" data-qid="5" value="" name="5"	> 
										 <span id="sansq15"></span>
										 </div>
									</div>
											
						</br><label id="sourceService" style="color:blue"></label></br>
											
					 
						<br><label id="custQuistionId6" data-qid="6"></label><br>
						
							<div class="row"> 
														
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq16" data-qid="6" value="" name="6"	> 
										 <span id="sansq16"></span>
										 </div>
														
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq17" data-qid="6" value="" name="6"	> 
										 <span id="sansq17"></span>
									</div>
														
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq18" data-qid="6" value="" name="6"	> 
										 <span id="sansq18"></span>
									</div>
							</div>
												
					 
						<br><label id="custQuistionId7" data-qid="7"></label><br>
						
							<div class="row"> 
														
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq19" data-qid="7" value="" name="7"	> 
										 <span id="sansq19"></span>
									</div>
														
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq20" data-qid="7" value="" name="7"	> 
										 <span id="sansq20"></span>
									</div>
														
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq21" data-qid="7" value="" name="7"	> 
										 <span id="sansq21"></span>
									</div>
							 </div>
							</br><label id="interestNot" style="color:blue"></label></br>
											
					 
						<br><label id="custQuistionId8" data-qid="8"></label><br>
						
							<div class="row"> 
									<div class="col-lg-5" > 
										<input type="radio" class="chk" id="ansq22" data-qid="8" value="" name="8"	> 
										 <span id="sansq22"></span>
									</div> 
									<div class="col-lg-5" > 
										<input type="radio" class="chk" id="ansq23" data-qid="8" value="" name="8"	> 
										 <span id="sansq23"></span>
									</div>
									<div class="col-lg-5" > 
										<input type="radio" class="chk" id="ansq24" data-qid="8" value="" name="8"	> 
										 <span id="sansq24"></span>
									</div>
									<div class="col-lg-5" > 
										<input type="radio" class="chk" id="ansq25" data-qid="8" value="" name="8"	> 
										 <span id="sansq25"></span>
									</div> 
							</div>
							
					</div>
					<div class="col-lg-4" style="padding-left: 29px;border-right: 1px solid #e5e5e5;height:650px"> 
									<h4 id="loyalityLevel"></h4>
						 <label id="ownerExperience" style="color:blue"></label></br> 
					 
							
					 
						<br><label id="custQuistionId9" data-qid="9"></label><br>
							<div class="row"> 
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq26" data-qid="9" value="" name="9"	> 
										 <span id="sansq26"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq27" data-qid="9" value="" name="9"	> 
										 <span id="sansq27"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq28" data-qid="9" value="" name="9"	> 
										 <span id="sansq28"></span>
									 </div>
								</div>
								 
							
					 
						<br><label id="custQuistionId10" data-qid="10"></label><br>
							<div class="row"> 
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq29" data-qid="10" value="" name="10"	> 
										 <span id="sansq29"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq30" data-qid="10" value="" name="10"	> 
										 <span id="sansq30"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq31" data-qid="10" value="" name="10"	> 
										 <span id="sansq31"></span>
									 </div>
								</div>
								 
							
					 
						<br><label id="custQuistionId11" data-qid="11"></label><br>
							<div class="row"> 
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq32" data-qid="11" value="" name="11"	> 
										 <span id="sansq32"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq33" data-qid="11" value="" name="11"	> 
										 <span id="sansq33"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq34" data-qid="11" value="" name="11"	> 
										 <span id="sansq34"></span>
									 </div>
													</div>
								 
							
					 
						<br><label id="custQuistionId12" data-qid="12"></label><br>
							<div class="row"> 
								  <div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq35" data-qid="12" value="" name="12"	> 
										 <span id="sansq35"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq36" data-qid="12" value="" name="12"	> 
										 <span id="sansq36"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq37" data-qid="12" value="" name="12"	> 
										 <span id="sansq37"></span>
									 </div>
							</div>
								 
							
					 
						<br><label id="custQuistionId13" data-qid="13"></label><br>
							<div class="row"> 
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq38" data-qid="13" value="" name="13"	> 
										 <span id="sansq38"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq39" data-qid="13" value="" name="13"	> 
										 <span id="sansq39"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq40" data-qid="13" value="" name="13"	> 
										 <span id="sansq40"></span>
									 </div>
								</div>
								 
							
					 
						<br><label id="custQuistionId14" data-qid="14"></label><br>
							<div class="row"> 
								  <div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq41" data-qid="14" value="" name="14"	> 
										 <span id="sansq41"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq42" data-qid="14" value="" name="14"	> 
										 <span id="sansq42"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq43" data-qid="14" value="" name="14"	> 
										 <span id="sansq43"></span>
									 </div>
								</div>
								 
							
					 
						<br><label id="custQuistionId15" data-qid="15"></label><br>
							<div class="row"> 
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq44" data-qid="15" value="" name="15"	> 
										 <span id="sansq44"></span>
									 </div>
									 <div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq45" data-qid="15" value="" name="15"	> 
										 <span id="sansq45"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq46" data-qid="15" value="" name="15"	> 
										 <span id="sansq46"></span>
									 </div>
								</div>
								 
							
					 
						<br><label id="custQuistionId16" data-qid="16"></label><br>
							<div class="row"> 
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq47" data-qid="16" value="" name="16"	> 
										 <span id="sansq47"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq48" data-qid="16" value="" name="16"	> 
										 <span id="sansq48"></span>
									 </div>
									<div class="col-lg-4" > 
										<input type="radio" class="chk" id="ansq49" data-qid="16" value="" name="16"	> 
										 <span id="sansq49"></span>
									 </div>
							</div>
						</div>
					<div class="col-lg-3" style="padding-left: 29px;"> 
									<h4 id="conversionOppLevel"></h4>
						 
											
					 
						<br><label id="custQuistionId17" data-qid="17"></label><br>
							<div class="row"> 
								  <div class="col-lg-3" > 
										<input type="radio" class="chk" id="ansq50" data-qid="17" value="" name="17"	> 
										 <span id="sansq50"></span>
									 </div>
									
									<div class="col-lg-3" > 
										<input type="radio" class="chk" id="ansq51" data-qid="17" value="" name="17"	> 
										 <span id="sansq51"></span>
									 </div>
									
																							
								<div class="controls    service_requested" hidden="hidden">
								<input size="16" style="margin-left: -18px;" type="text" value=""  class=" datetimepicker" name="service_requested_date" id="service_requested_date" parsley-trigger="change" required>
								</div>
												 
							</div>
														
					 
						<br><label id="custQuistionId18" data-qid="18"></label><br>
							<div class="row"> 
										<div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq52" data-qid="18" value="" name="18"	> 
											 <span id="sansq52"></span>
										 </div>
										 <div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq53" data-qid="18" value="" name="18"	> 
											 <span id="sansq53"></span>
										 </div>
									
								</div>
														
					 
						<br><label id="custQuistionId19" data-qid="19"></label><br>
							<div class="row"> 
										<div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq54" data-qid="19" value="" name="19"	> 
											 <span id="sansq54"></span>
										 </div>
										 <div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq55" data-qid="19" value="" name="19"	> 
											 <span id="sansq55"></span>
										 </div>
									
																						<div class="controls    amc_requested" hidden="hidden">
								<input size="16" style="margin-left: -18px;" type="text" value=""  class=" datetimepicker" name="amc_requested_date" id="amc_requested_date" parsley-trigger="change" required>
								</div>
									
															</div>
														
					 
						<br><label id="custQuistionId20" data-qid="20"></label><br>
							<div class="row"> 
									<div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq56" data-qid="20" value="" name="20"	> 
											 <span id="sansq56"></span>
										 </div>
										 <div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq57" data-qid="20" value="" name="20"	> 
											 <span id="sansq57"></span>
										 </div>
									
									</div>
														
					 
						<br><label id="custQuistionId21" data-qid="21"></label><br>
							<div class="row"> 
										<div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq58" data-qid="21" value="" name="21"	> 
											 <span id="sansq58"></span>
										 </div>
										 <div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq59" data-qid="21" value="" name="21"	> 
											 <span id="sansq59"></span>
										 </div>
									
										 <div class="controls   wish_upgrade" hidden="hidden">
											<input size="16" style="margin-left: -18px;" type="text" value=""  class=" datetimepicker" name="wish_upgrade_date" id="wish_upgrade_date" parsley-trigger="change" required>
										 </div>	
									
									</div>
														
					 
						<br><label id="custQuistionId22" data-qid="22"></label><br>
							<div class="row"> 
										<div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq60" data-qid="22" value="" name="22"	> 
											 <span id="sansq60"></span>
										 </div>
										 <div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq61" data-qid="22" value="" name="22"	> 
											 <span id="sansq61"></span>
										 </div>
									
								</div>
														
					 
						<br><label id="custQuistionId23" data-qid="23"></label><br>
							<div class="row"> 
										<div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq62" data-qid="23" value="" name="23"	> 
											 <span id="sansq62"></span>
										 </div>
										 <div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq63" data-qid="23" value="" name="23"	> 
											 <span id="sansq63"></span>
										 </div>
									
								</div>
														
					 
						<br><label id="custQuistionId24" data-qid="24"></label><br>
							<div class="row"> 
									<div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq64" data-qid="24" value="" name="24"	> 
											 <span id="sansq64"></span>
										 </div>
										 <div class="col-lg-3" > 
											<input type="radio" class="chk" id="ansq65" data-qid="24" value="" name="24"	> 
											 <span id="sansq65"></span>
										 </div>
									
																						<div class="controls    follow_up" hidden="hidden">
								<input size="16" style="margin-left: -18px;" type="text" value=""  class=" datetimepicker" name="follow_up_date" id="follow_up_date" parsley-trigger="change" required>
								
								</div>	
								</div>
												</div>
			   </div><br>
			   
				<div class="row">
					<div class="col-lg-2"> 
						<!--input type="datetime-local"  class="maincls form-control" id="appDate"  name="bdaytime" size=16 /-->
						<label>Appointment Time</label>
						<div class="controls input-append date form_datetime" data-date="2017-09-16T05:25:07Z" data-date-format="dd-mm-yyyy H:i" data-link-field="dtp_input1">
							<input size="16" type="text" value="" id="appDate"  name="bdaytime"  readonly>
							<span class="add-on"><i class="icon-remove"></i></span>
							<span class="add-on"><i class="icon-th"></i></span>
						</div>
					</div>
					<div class="col-lg-2"> 
						<button type="button" class="btn btn-success" id="appSMS" style="    margin-top: 16px;">
									<i class="fa fa-calendar" style="margin-right:3%;"></i>AMC Appt SMS &nbsp;</button>
					</div>
									
					<div class="col-lg-4"> 
						<label>AMC Expiry Msg</label><br>
						<input type="date"  class="maincls form-control" id="amcExp"  name="amcexp"/>
					</div>
					
					<div class="col-lg-4"> 
					<div class="row">
						<button type="button" class="btn btn-success" id="expirySMS" style="    margin-top: 16px;">
									<i class="fa fa-calendar" style="margin-right:3%;"></i>Send Reminder &nbsp;</button>
						<button type="button" id="callBack" class="btn btn-info" data-toggle="modal" data-target="#myAction" style="    margin-top: 16px;">
								<i class="fa fa-mail-reply" style="margin-right:3%;"></i>Call customer back, later</button>	
											
					</div>
				  </div>
				</div>
				
				<div class="line line-dashed line-lg pull-in"></div>
			
				<div class="row" >
					<div class="col-lg-4"> 
						<i class="fa fa-comments" style="margin-right:1%;"></i><label>Standard Comments:</label></br>
						<select id="std_comments" class="form-control" name="std_comments" style="width:405px">
						<option value="">Filter</option>
												<option value="Interested In Yapnaa And AMC">Interested In Yapnaa And AMC</option>
									
												<option value="Not Interested">Not Interested</option>
									
												<option value="Already In Contract">Already In Contract</option>
									
												<option value="Will Download The App But Not Intrested In AMC">Will Download The App But Not Intrested In AMC</option>
									
												<option value="Will Download The App AMC Already Taken">Will Download The App AMC Already Taken</option>
									
												<option value="Price High">Price High</option>
									
												<option value="Wrong Number">Wrong Number</option>
									
												<option value="Switched Off">Switched Off</option>
									
												<option value="Not Reachable">Not Reachable</option>
									
												<option value="Didn't Pick The Call">Didn't Pick The Call</option>
									
												<option value="Call Me Back">Call Me Back</option>
									
												<option value="Will Call Back">Will Call Back</option>
									
									 </select>	
					</div>	
					<div class="col-lg-4"> 
							<i class="fa fa-comments" style="margin-right:1%;"></i><label>Other Comments:</label></br>
							<textarea rows="1" cols="70" id="comments" class="maincls form-control"  ></textarea>
					</div>
					<div class="col-lg-2"> 
						<button type="button" class="btn btn-danger pull-left" data-toggle="modal" id="noInsterest" style="    margin-top: 16px;" data-target="#myAction">
										<i class="fa fa-microphone-slash" ></i>Customer Not Interested</button>
					</div>
					<div class="col-lg-2"> 
						<button type="button" class="btn btn-warning pull-left" id="general" style="    margin-top: 16px;"><i class="fa fa-bullhorn" ></i>Yapnaa Interested</button>
					</div>
				</div>
			
			</div>
			<div class="modal-footer" style="margin-bottom:8% !important;">
				<button type="button" id="cust_reply" name="cust_reply" class="btn btn-info" data-toggle="modal" data-target="#customer_reply">Save </button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>			
		</div>
      
    </div>	
</div>

<!-- Question and Answer Modal -->       

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
					<div class="col-lg-5"> </div>
					<div class="col-lg-5"> </div>
				</div>
				<div class="row">
					<div class="col-lg-3"> 
						<label>Current AMC Duration:</label>
					</div>
					<div class="col-lg-4"> 
						<label id="currentAMC"></label>
					</div>
				</div>
				<div class="line line-dashed line-lg pull-in"></div>
				<form action="" method="POST" id="amcform">
					<div class="row" style="margin-top:5%;margin-bottom:5%;">
							<div class="col-lg-3"> 
								<label>New AMC date</label>
							</div>
							<div class="col-lg-3"> 
								<input type="date"  class="maincls form-control" id="newAMCStart"  name="newAMCStart" />
							</div>
							<div class="col-lg-1"> 
								<label>to</label>
							</div>
						
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
						<div class="col-sm-3" ><textarea rows="6" cols="50" class="form-control" id="upgarde_product_message"  name="upgarde_product_message">Thank you for choosing Livpure. Let us know your experience after upgrading to a new model. <bitly link></textarea></div>			
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
					
					</div>
					<div class="modal-footer">
						<input type="submit" id="editAMCSubmit" name="editAMCSubmit" class="btn btn-info pull left" data-toggle="modal" data-target="#myAction">		
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
					
				</form>
				
			
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
			
			
			$("#amcDateSub").click(function(){
				confirm('Are you sure want change the AMC Date?') ? $('#form_amcDateSub').submit() : false;
				var custType			= <?php echo $_GET['customer_type'];?>;
				var id                  = sessionStorage.id;
				var amcExpDate          = $('#expiry_date').val();
				var amcServiceDate      = $('#next_service_date').val();
				var ls_ser_date         = $('#ls_ser_date').val();
			
				$.ajax({
					url:"smsActions.php?amcDateSave=submit",
					type:"POST",
					data:{id:id,amcExpDate:amcExpDate,amcServiceDate:amcServiceDate,custType:custType,ls_ser_date:ls_ser_date},
					success:function(response){
						alert('You have updated successfully');
						location.reload();
					},
					error:function(error){
						alert(JSON.stringify(error));
					}
				});
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
           
 		    $("#cust_reply").click(function(){
				
				if(custType != 4){
					$.ajax({
						url:"smsActions.php?sendSms",
						type:"POST",
						data:{number:custmobile,brandName:brandName,customername:namecust},
						success:function(response){
							console.log(response);
						},
						error:function(error){
							//alert(JSON.stringify(error));
						}    
					});	
				}
				
				$("input:radio[class=chk]:checked").each(function () {
					var quest = $(this).data("qid");	
					var ans = $(this).val();
					var callback=$("#comments").val();						
					var follow_up_date = $('#follow_up_date').val();	
					var wish_upgrade_date = $('#wish_upgrade_date').val();
					var amc_requested_date = $('#amc_requested_date').val();	
					var service_requested_date = $('#service_requested_date').val();						
					var mob=	custmobile;
					var customerid=	idcust;
					var customername=	namecust;						
					var brandId=custType; 
					  
					$.ajax({
						url:"smsActions.php?custResponse=submit",
						type:"POST",
						data:{callbackCust:callback,userQst:quest,answer:ans,number:mob,brandId:brandId,brandName:brandName,customerid:customerid,customername:customername,follow_up_date:follow_up_date,wish_upgrade_date:wish_upgrade_date,amc_requested_date:amc_requested_date,service_requested_date:service_requested_date},
						success:function(response){
							console.log(response);
						},
						error:function(error){
							//alert(JSON.stringify(error));
						}
					});  								
				});
					
				alert("Customer response saved successfully.");
				location.reload();
			});	
			
			
			$(document).ready(function() {
				$('#serviceLavel').empty();
				$('#loyalityLevel').empty(); 
				$('#conversionOppLevel').empty();
				$('#serviceByBrand').empty();
				$('#sourceService').empty();
				$('#interestNot').empty();
				$('#ownerExperience').empty();
				$('#custQuistionId1').empty();
				$('#custQuistionId2').empty();
				$('#custQuistionId3').empty();
				$('#custQuistionId4').empty();
				$('#custQuistionId5').empty();
				$('#custQuistionId6').empty();
				$('#custQuistionId7').empty();
				$('#custQuistionId8').empty();
				$('#custQuistionId9').empty();
				$('#custQuistionId10').empty();
				$('#custQuistionId11').empty();
				$('#custQuistionId12').empty();
				$('#custQuistionId13').empty();
				$('#custQuistionId14').empty();
				$('#custQuistionId15').empty();
				$('#custQuistionId16').empty();
				$('#custQuistionId17').empty();
				$('#custQuistionId18').empty();
				$('#custQuistionId19').empty();
				$('#custQuistionId20').empty();
				$('#custQuistionId21').empty();
				$('#custQuistionId22').empty();
				$('#custQuistionId23').empty();
				$('#custQuistionId24').empty();
				
				$.ajax({
					url:"smsActions.php?question",
					type:"POST",
					data:{customer_type:custType},
					success:function(response){
						var res=JSON.parse(response);
						var qstcustran=res;
						
						if(res){
							
							$('#serviceLavel').append(res[0].group_level);
							$('#loyalityLevel').append(res[8].group_level);
							$('#conversionOppLevel').append(res[16].group_level);
							$('#serviceByBrand').append('A)'+' '+res[1].group_id);	
							$('#sourceService').append('B)'+' '+res[3].group_id);	
							$('#interestNot').append('C)'+' '+res[8].group_id);	
							$('#ownerExperience').append('A)'+' '+res[10].group_id);	

							$("#custQuistionId1").append('1'+'.'+' '+res[0].questions);
							$("#custQuistionId2").append('2'+'.'+' '+res[1].questions);
							$("#custQuistionId3").append('3'+'.'+' '+res[2].questions);
							$("#custQuistionId4").append('4'+'.'+' '+res[3].questions);
							$("#custQuistionId5").append('5'+'.'+' '+res[4].questions);
							$("#custQuistionId6").append('1'+'.'+' '+res[5].questions);
							$("#custQuistionId7").append('2'+'.'+' '+res[6].questions);
							$("#custQuistionId8").append('1'+'.'+' '+res[7].questions);
							$("#custQuistionId9").append('1'+'.'+' '+res[8].questions);
							$("#custQuistionId10").append('2'+'.'+' '+res[9].questions);
							$("#custQuistionId11").append('3'+'.'+' '+res[10].questions);
							$("#custQuistionId12").append('4'+'.'+' '+res[11].questions);
							$("#custQuistionId13").append('5'+'.'+' '+res[12].questions);
							$("#custQuistionId14").append('6'+'.'+' '+res[13].questions);
							$("#custQuistionId15").append('7'+'.'+' '+res[14].questions);
							$("#custQuistionId16").append('8'+'.'+' '+res[15].questions);
							$("#custQuistionId17").append('1'+'.'+' '+res[16].questions);
							$("#custQuistionId18").append('2'+'.'+' '+res[17].questions);
							$("#custQuistionId19").append('3'+'.'+' '+res[18].questions);
							$("#custQuistionId20").append('4'+'.'+' '+res[19].questions);
							$("#custQuistionId21").append('5'+'.'+' '+res[20].questions);
							$("#custQuistionId22").append('6'+'.'+' '+res[21].questions);
							$("#custQuistionId23").append('7'+'.'+' '+res[22].questions);
							$("#custQuistionId24").append('8'+'.'+' '+res[23].questions);
											
						}
						
					},
					error:function(error){
						
						alert(JSON.stringify(error));
					}
				});
				
				
				$.ajax({
					url:"smsActions.php?answer",
					type:"POST",
					data:{customer_type:custType},
					success:function(response){
						var res=JSON.parse(response);
						
						if(res){
								$('#sansq1').html(res[2].answer_type);
								$('#ansq1').val(res[2].answer_type);
								$('#sansq2').html(res[1].answer_type);
								$('#ansq2').val(res[1].answer_type);
								$('#sansq3').html(res[6].answer_type);
								$('#ansq3').val(res[6].answer_type);
								$('#sansq4').html(res[13].answer_type);
								$('#ansq4').val(res[13].answer_type);
								$('#sansq5').html(res[5].answer_type);
								$('#ansq5').val(res[5].answer_type);
								$('#sansq6').html(res[6].answer_type);
								$('#ansq6').val(res[6].answer_type);
								$('#sansq7').html(res[13].answer_type);
								$('#ansq7').val(res[13].answer_type);
								$('#sansq8').html(res[5].answer_type);
								$('#ansq8').val(res[5].answer_type);
								$('#sansq9').html(res[6].answer_type);
								$('#ansq9').val(res[6].answer_type);	
								$('#sansq10').html(res[13].answer_type);
								$('#ansq10').val(res[13].answer_type);
								$('#sansq11').html(res[5].answer_type);
								$('#ansq11').val(res[5].answer_type);
								$('#sansq12').html(res[6].answer_type);
								$('#ansq12').val(res[6].answer_type);
								$('#sansq13').html(res[13].answer_type);
								$('#ansq13').val(res[13].answer_type);
								$('#sansq14').html(res[5].answer_type);
								$('#ansq14').val(res[5].answer_type);
								$('#sansq15').html(res[6].answer_type);
								$('#ansq15').val(res[6].answer_type);	
								$('#sansq16').html(res[13].answer_type);
								$('#ansq16').val(res[13].answer_type);
								$('#sansq17').html(res[5].answer_type);
								$('#ansq17').val(res[5].answer_type);
								$('#sansq18').html(res[6].answer_type);
								$('#ansq18').val(res[6].answer_type);	
								$('#sansq19').html(res[3].answer_type);
								$('#ansq19').val(res[3].answer_type);
								$('#sansq20').html(res[11].answer_type);
								$('#ansq20').val(res[11].answer_type);
								$('#sansq21').html(res[10].answer_type);
								$('#ansq21').val(res[10].answer_type);									
								$('#sansq22').html(res[8].answer_type);
								$('#ansq22').val(res[8].answer_type);	
								$('#sansq23').html(res[12].answer_type);
								$('#ansq23').val(res[12].answer_type);
								$('#sansq24').html(res[4].answer_type);
								$('#ansq24').val(res[4].answer_type);
								$('#sansq25').html(res[7].answer_type);
								$('#ansq25').val(res[7].answer_type);									
								$('#sansq26').html(res[13].answer_type);
								$('#ansq26').val(res[13].answer_type);
								$('#sansq27').html(res[5].answer_type);
								$('#ansq27').val(res[5].answer_type);
								$('#sansq28').html(res[9].answer_type);
								$('#ansq28').val(res[9].answer_type);									
								$('#sansq29').html(res[13].answer_type);
								$('#ansq29').val(res[13].answer_type);
								$('#sansq30').html(res[5].answer_type);
								$('#ansq30').val(res[5].answer_type);
								$('#sansq31').html(res[6].answer_type);
								$('#ansq31').val(res[6].answer_type);									
								$('#sansq32').html(res[13].answer_type);
								$('#ansq32').val(res[13].answer_type);
								$('#sansq33').html(res[5].answer_type);
								$('#ansq33').val(res[5].answer_type);
								$('#sansq34').html(res[9].answer_type);
								$('#ansq34').val(res[9].answer_type);
								$('#sansq35').html(res[13].answer_type);
								$('#ansq35').val(res[13].answer_type);
								$('#sansq36').html(res[5].answer_type);
								$('#ansq36').val(res[5].answer_type);
								$('#sansq37').html(res[9].answer_type);
								$('#ansq37').val(res[9].answer_type);
								$('#sansq38').html(res[13].answer_type);
								$('#ansq38').val(res[13].answer_type);
								$('#sansq39').html(res[5].answer_type);
								$('#ansq39').val(res[5].answer_type);
								$('#sansq40').html(res[9].answer_type);
								$('#ansq40').val(res[9].answer_type);
								$('#sansq41').html(res[13].answer_type);
								$('#ansq41').val(res[13].answer_type);
								$('#sansq42').html(res[5].answer_type);
								$('#ansq42').val(res[5].answer_type);
								$('#sansq43').html(res[9].answer_type);
								$('#ansq43').val(res[9].answer_type);
								$('#sansq44').html(res[13].answer_type);
								$('#ansq44').val(res[13].answer_type);
								$('#sansq45').html(res[5].answer_type);
								$('#ansq45').val(res[5].answer_type);
								$('#sansq46').html(res[9].answer_type);
								$('#ansq46').val(res[9].answer_type);
								$('#sansq47').html(res[13].answer_type);
								$('#ansq47').val(res[13].answer_type);
								$('#sansq48').html(res[5].answer_type);
								$('#ansq48').val(res[5].answer_type);
								$('#sansq49').html(res[6].answer_type);
								$('#ansq49').val(res[6].answer_type);
								$('#sansq50').html(res[13].answer_type);
								$('#ansq50').val(res[13].answer_type);
								$('#sansq51').html(res[5].answer_type);
								$('#ansq51').val(res[5].answer_type);
								$('#sansq52').html(res[13].answer_type);
								$('#ansq52').val(res[13].answer_type);
								$('#sansq53').html(res[5].answer_type);
								$('#ansq53').val(res[5].answer_type);
								$('#sansq54').html(res[13].answer_type);
								$('#ansq54').val(res[13].answer_type);
								$('#sansq55').html(res[5].answer_type);
								$('#ansq55').val(res[5].answer_type);
								$('#sansq56').html(res[13].answer_type);
								$('#ansq56').val(res[13].answer_type);
								$('#sansq57').html(res[5].answer_type);
								$('#ansq57').val(res[5].answer_type);
								$('#sansq58').html(res[13].answer_type);
								$('#ansq58').val(res[13].answer_type);
								$('#sansq59').html(res[5].answer_type);
								$('#ansq59').val(res[5].answer_type);
								$('#sansq60').html(res[13].answer_type);
								$('#ansq60').val(res[13].answer_type);
								$('#sansq61').html(res[5].answer_type);
								$('#ansq61').val(res[5].answer_type);
								$('#sansq62').html(res[13].answer_type);
								$('#ansq62').val(res[13].answer_type);
								$('#sansq63').html(res[5].answer_type);
								$('#ansq63').val(res[5].answer_type);
								$('#sansq64').html(res[13].answer_type);
								$('#ansq64').val(res[13].answer_type);
								$('#sansq65').html(res[5].answer_type);
								$('#ansq65').val(res[5].answer_type);									
						} 
						
					},
					error:function(error){
						
						alert(JSON.stringify(error));
					}
				});
				
			});
			i=0;
			function custQA(custName,phone,custmerid) {
				custmobile=phone;
				idcust=custmerid;
				namecust=custName;
				
				$.ajax({
					url:"smsActions.php?customerSavedResponce",
					type:"POST",
					data:{customer_type:custType,phone_no:phone},
					success:function(response){
						var res=JSON.parse(response);
													
						if(res){							
							for(var i=0;i<res.length;i++){
							
							   switch(res[i].qst_id){
								  case '1':
								  
									  if(res[i].answer=='Less than 6 months')
									  {											
										$("#ansq1").prop("checked", true);
									  } 
									  else if(res[i].answer=='Less than 1 year')  
									  {
										 $("#ansq2").prop("checked", true);
									  }
									  else if(res[i].answer=='Not sure')  
									  {
										 $("#ansq3").prop("checked", true);
									  }											  
										
								  break;
								  case '2':
									 if(res[i].answer=='Yes')
									  {											
										$("#ansq4").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq5").prop("checked", true);
									  }
									  else if(res[i].answer=='Not sure')  
									  {
										 $("#ansq6").prop("checked", true);
									  }
								   
								  break;
								  case '3':
									  if(res[i].answer=='Yes')
									  {											
										$("#ansq7").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq8").prop("checked", true);
									  }
									  else if(res[i].answer=='Not sure')  
									  {
										 $("#ansq9").prop("checked", true);
									  }

								  break;
								  case '4':
								   if(res[i].answer=='Yes')
									  {											
										$("#ansq10").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq11").prop("checked", true);
									  }
									  else if(res[i].answer=='Not sure')  
									  {
										 $("#ansq12").prop("checked", true);
									  }

								  break;
								  case '5':
									  if(res[i].answer=='Yes')
									  {											
										$("#ansq13").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq14").prop("checked", true);
									  }
									  else if(res[i].answer=='Not sure')  
									  {
										 $("#ansq15").prop("checked", true);
									  }
									 
								  break;
								  case '6':
									  if(res[i].answer=='Yes')
									  {											
										$("#ansq16").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq17").prop("checked", true);
									  }
									  else if(res[i].answer=='Not sure')  
									  {
										 $("#ansq18").prop("checked", true);
									  }
									   
								  break;
								  case '7':
									  if(res[i].answer=='Local shop')
									  {											
										$("#ansq19").prop("checked", true);
									  } 
									  else if(res[i].answer=='Through Online')  
									  {
										 $("#ansq20").prop("checked", true);
									  }
									  else if(res[i].answer=='Third party')  
									  {
										 $("#ansq21").prop("checked", true);
									  }
										 
								  break;
								  case '8':
								  if(res[i].answer=='Service not required')
									  {											
										$("#ansq22").prop("checked", true);
									  } 
									  else if(res[i].answer=='Will call when service needed')  
									  {
										 $("#ansq23").prop("checked", true);
									  }
									  else if(res[i].answer=='Negative product experience')  
									  {
										 $("#ansq24").prop("checked", true);
									  }
									  else if(res[i].answer=='Poor service experience')  
									  {
										 $("#ansq25").prop("checked", true);
									  }
								  
								  break;
								  case '9':
									   if(res[i].answer=='Yes')
									  {											
										$("#ansq26").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq27").prop("checked", true);
									  }
									  else if(res[i].answer=='Sometimes')  
									  {
										 $("#ansq28").prop("checked", true);
									  }
								   
								  break;
								  case '10':
									  if(res[i].answer=='Yes')
									  {											
										$("#ansq29").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq30").prop("checked", true);
									  }
									  else if(res[i].answer=='Not sure')  
									  {
										 $("#ansq31").prop("checked", true);
									  }
								  
								  break;
								  case '11':
									  if(res[i].answer=='Yes')
									  {											
										$("#ansq32").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq33").prop("checked", true);
									  }
									  else if(res[i].answer=='Sometimes')  
									  {
										 $("#ansq34").prop("checked", true);
									  }
								   
								  break;
								  case '12':
										if(res[i].answer=='Yes')
									  {											
										$("#ansq35").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq36").prop("checked", true);
									  }
									  else if(res[i].answer=='Sometimes')  
									  {
										 $("#ansq37").prop("checked", true);
									  }
									  
								  break;
								  case '13':
										 if(res[i].answer=='Yes')
									  {											
										$("#ansq38").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq39").prop("checked", true);
									  }
									  else if(res[i].answer=='Sometimes')  
									  {
										 $("#ansq40").prop("checked", true);
									  }
								 
								  break;
								  case '14':
										 if(res[i].answer=='Yes')
									  {											
										$("#ansq41").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq42").prop("checked", true);
									  }
									  else if(res[i].answer=='Sometimes')  
									  {
										 $("#ansq43").prop("checked", true);
									  }

								  break;
								  case '15':
										if(res[i].answer=='Yes')
									  {											
										$("#ansq44").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq45").prop("checked", true);
									  }
									  else if(res[i].answer=='Sometimes')  
									  {
										 $("#ansq46").prop("checked", true);
									  }
								 
								  break;
								  case '16':
									  if(res[i].answer=='Yes')
									  {											
										$("#ansq47").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq48").prop("checked", true);
									  }
									  else if(res[i].answer=='Not sure')  
									  {
										 $("#ansq49").prop("checked", true);
									  }
										
								  break;
								  case '17':
									  if(res[i].answer=='Yes')
									  {											
										$("#ansq50").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq51").prop("checked", true);
									  }

								  
								  break;
								  case '18':
									 if(res[i].answer=='Yes')
									  {											
										$("#ansq52").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq53").prop("checked", true);
									  }
								  
								  break;
								  case '19':
									  if(res[i].answer=='Yes')
									  {											
										$("#ansq54").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq55").prop("checked", true);
									  }
								  
								  break;
								  case '20':
								  if(res[i].answer=='Yes')
									  {											
										$("#ansq56").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq57").prop("checked", true);
									  }
								  
								  break;
								  case '21':
									 if(res[i].answer=='Yes')
									  {											
										$("#ansq58").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq59").prop("checked", true);
									  }
								 
								  break;
								  case '22':
									 if(res[i].answer=='Yes')
									  {											
										$("#ansq60").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq61").prop("checked", true);
									  }
								 
								  break;
								  case '23':
								  if(res[i].answer=='Yes')
									  {											
										$("#ansq62").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq63").prop("checked", true);
									  }
								  
								  break;
								  case '24':
									  if(res[i].answer=='Yes')
									  {											
										$("#ansq64").prop("checked", true);
									  } 
									  else if(res[i].answer=='No')  
									  {
										$("#ansq65").prop("checked", true);
									  }
								 
								  break;
								  
																  
							  }
							 
							}						  
						}
						
					},
					error:function(error){
						alert(JSON.stringify(error));
					}
				});
				
				<?php if(isset($_GET['customer_type'])){
					switch($_GET['customer_type']){
						case 1:?>
						$("#modal-title").html("Customer Name: "+custName+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+"Brand Name: "+'<?php echo $customer;?>');
						<?php break;
						case 2:?>
						$("#modal-title").html("Customer Name: "+custName+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+"Brand Name: "+'<?php echo $customer;?>');
						<?php break;
						case 3:?>
						$("#modal-title").html("Customer Name: "+custName+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+"Brand Name: "+'<?php echo $customer;?>');
						<?php break;
						case 4:?>
						$("#modal-title").html("Customer Name: "+custName+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+"Brand Name: "+'<?php echo $customer;?>');
						<?php break;
						case 5:?>
						$("#modal-title").html("Customer Name: "+custName+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+"Brand Name: "+'<?php echo $customer;?>');
						
					<?php	}
				}?>
		
			}
			
			
			$(".actionBox,userQstM").click(function(){
			
				var id = $(this).attr('data-id');
				var name = $(this).attr('data-name');
				var email = $(this).attr('data-email');
				var mobile = $(this).attr('data-mobile');
				var mobile2 = $(this).attr('data-mobile2');
				var expiry = $(this).attr('data-expiry');
				var amcFrom = $(this).attr('data-contract');
				var address = $(this).attr('data-address');
				var customerid = $(this).attr('data-customerid');
				var nextServiceDate = $(this).attr('data-next-service-data');
				var lastServiceDate = $(this).attr('data-last-service-data');
				
				if($('#service_amc').html()==''){
					$('#service_amc').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#service_bb').html()==''){
					$('#service_bb').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#ex_dt').html()==''){
					$('#ex_dt').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#last_ser_dt').html()==''){
					$('#last_ser_dt').prepend('<img height="20" width="30" src="images/circle.svg" />');
				} 
				if($('#next_ser_dt').html()==''){
					$('#next_ser_dt').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#next_ser_dt').html()==''){
					$('#next_ser_dt').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#service_st').html()==''){
					$('#service_st').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#service_sw').html()==''){
					$('#service_sw').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#service_buy').html()==''){
					$('#service_buy').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#service_pd').html()==''){
					$('#service_pd').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#service_rec').html()==''){
					$('#service_rec').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#amc_enquery').html()==''){
					$('#amc_enquery').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#upgrd').html()==''){
					$('#upgrd').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#escl').html()==''){
					$('#escl').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#amcdetails').html()==''){
					$('#amcdetails').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#upgradeoffers').html()==''){
					$('#upgradeoffers').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#service_kwd').html()==''){
					$('#service_kwd').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#bad_exp').html()==''){
					$('#bad_exp').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#poor_sr').html()==''){
					$('#poor_sr').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#not_conv').html()==''){
					$('#not_conv').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
			    if($('#cust_res').html()==''){
					$('#cust_res').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}
				if($('#bad_exp').html()==''){
					$('#bad_exp').prepend('<img height="20" width="30" src="images/circle.svg" />');
				}								
				
				$("#phone11").html(mobile);
				$("#phone21").html(mobile2);
				$("#cust_name1").html(name);
				$("#cust_email1").html(email);
				$("#cust_address").html(address);
				$("#cust_id").html(customerid);
				
				if(nextServiceDate){
					$("#next_service_date").val(nextServiceDate);
				}
				if(sessionStorage.lastServiceDate){
					$("#ls_ser_date").val(lastServiceDate);
				}
				if(sessionStorage.expiry){
					$("#expiry_date").val(expiry);
				}
				
				var questionId	= $('.chk:checked').attr('data-qid');
				var answer		= $('.chk:checked').val();
				
				//alert(questionId); alert(answer);
				
				for (i = 1; i < 5; i++) { 
					if($('input[name='+i+']:checked').attr("value")=='Yes' || $('input[name='+i+']:checked').attr("value")=='Less than 6 months' || $('input[name='+i+']:checked').attr("value")=='Less than 1 year'){
						$("#service_bb img:last-child").remove();
						$('#service_bb').prepend('<img height="20" width="30" src="images/yes.svg" />');
						break;
					}
					else if($('input[name='+i+']:checked').attr("value")=='No'){
						$("#service_bb img:last-child").remove();
						$('#service_bb').prepend('<img height="20" width="30" src="images/no.svg" />');
					}
				}
				
				if($('input[name='+1+']:checked').attr("value")){	
				      
					$("#last_ser_dt img:last-child").remove();
					switch($('input[name='+1+']:checked').attr("value")){
						case 'Not sure':	
							$('#last_ser_dt').prepend('<img height="20" width="30" src="images/not_sure.svg" />');					
						break;
						case 'Less than 6 months':
							$('#last_ser_dt').prepend('<img height="20" width="30" src="images/yes.svg" />');
						break;
						case 'Less than 1 year':
							$('#last_ser_dt').prepend('<img height="20" width="30" src="images/yes.svg" />');
						break;	
					}
						
				}
				
				if($('input[name='+2+']:checked').attr("value")){	
				     
					$("#next_ser_dt img:last-child").remove();
					$("#service_amc img:last-child").remove();
					switch($('input[name='+2+']:checked').attr("value")){
					
						case 'Not sure':	
							$('#next_ser_dt').prepend('<img height="20" width="30" src="images/not_sure.svg" />');					
							$('#service_amc').prepend('<img height="20" width="30" src="images/not_sure.svg" />');					
						break;
						case 'Yes':						
							$('#next_ser_dt').prepend('<img height="20" width="30" src="images/yes.svg" />');
							$('#service_amc').prepend('<img height="20" width="30" src="images/yes.svg" />');
						break;
						case 'No':
							$('#next_ser_dt').prepend('<img height="20" width="30" src="images/no.svg" />');
							$('#service_amc').prepend('<img height="20" width="30" src="images/no.svg" />');
						break;	
					}
						
				}
				
				if($('input[name='+3+']:checked').attr("value")){	
				     
					$("#service_st img:last-child").remove(); 
					switch($('input[name='+3+']:checked').attr("value")){
							
						case 'Not sure':	
							$('#service_st').prepend('<img height="20" width="30" src="images/not_sure.svg" />');					
						break;
						case 'Yes':
							$('#service_st').prepend('<img height="20" width="30" src="images/yes.svg" />');
						break;
						case 'No':
							$('#service_st').prepend('<img height="20" width="30" src="images/no.svg" />');
						break;	
					}
						
				}
					
				if($('input[name='+4+']:checked').attr("value")){	
				     
					$("#service_sw img:last-child").remove(); 
					switch($('input[name='+4+']:checked').attr("value")){
						case 'Not sure':	
							$('#service_sw').prepend('<img height="20" width="30" src="images/not_sure.svg" />');					
						break;
						case 'Yes':
							$('#service_sw').prepend('<img height="20" width="30" src="images/yes.svg" />');
						break;
						case 'No':
							$('#service_sw').prepend('<img height="20" width="30" src="images/no.svg" />');
						break;	
					}
						
				}
					
				if($('input[name='+16+']:checked').attr("value")){	
				     
					$("#service_buy img:last-child").remove();
					 
					switch($('input[name='+16+']:checked').attr("value")){
							//$("#last_ser_dt").last().remove();
						case 'Not sure':	
							$('#service_buy').prepend('<img height="20" width="30" src="images/not_sure.svg" />');					
												
						   
						break;
						case 'Yes':
						
							
						$('#service_buy').prepend('<img height="20" width="30" src="images/yes.svg" />');
						
					   break;
						case 'No':
					  
						 
							$('#service_buy').prepend('<img height="20" width="30" src="images/no.svg" />');
							
						break;	
						} 
						
					}
					
				if($('input[name='+12+']:checked').attr("value")){	
				 
					$("#service_pd img:last-child").remove();
				 
					switch($('input[name='+12+']:checked').attr("value")){ 
						//$("#last_ser_dt").last().remove();
					case 'Sometimes':	
						$('#service_pd').prepend('<img height="20" width="30" src="images/not_sure.svg" />');					
											
					   
					break;
					case 'Yes':
					
						
					$('#service_pd').prepend('<img height="20" width="30" src="images/yes.svg" />');
					
				   break;
					case 'No':
				  
					 
						$('#service_pd').prepend('<img height="20" width="30" src="images/no.svg" />');
						
					break;	
					} 
					
				}
				
				if($('input[name='+13+']:checked').attr("value")){	
				 
				  $("#service_kwd img:last-child").remove();
				 
				switch($('input[name='+13+']:checked').attr("value")){ 
						//$("#last_ser_dt").last().remove();
					case 'Sometimes':	
						$('#service_kwd').prepend('<img height="20" width="30" src="images/not_sure.svg" />');					
											
					   
					break;
					case 'Yes':
					
						
					$('#service_kwd').prepend('<img height="20" width="30" src="images/yes.svg" />');
					
				   break;
					case 'No':
				  
					 
						$('#service_kwd').prepend('<img height="20" width="30" src="images/no.svg" />');
						
					break;	
					} 
					 
				}
				
				if($('input[name='+8+']:checked').attr("value")){     
				 
				 
				switch($('input[name='+8+']:checked').attr("value")){ 
						//$("#last_ser_dt").last().remove();
					case 'Negative product experience':	
					   $("#bad_exp img:last-child").remove();
					   $('#bad_exp').prepend('<img height="20" width="30" src="images/yes.svg" />');	
											
					   
					break;
					case 'Poor service experience':
					
					$("#poor_sr img:last-child").remove();	
					$('#poor_sr').prepend('<img height="20" width="30" src="images/yes.svg" />');
					
				   break;
					case 'Service not required':
				  
					   $("#not_conv img:last-child").remove();
						$('#not_conv').prepend('<img height="20" width="30" src="images/yes.svg" />');
						
					break;	
				   case 'Will call when service needed':
				  
					   $("#cust_res img:last-child").remove();
						$('#cust_res').prepend('<img height="20" width="30" src="images/yes.svg" />');
						
					break;	  
					} 
					 
				}
				
				if($('input[name='+17+']:checked').attr("value")){
					if($('input[name='+17+']:checked').attr("value")=='Yes'){
						$("#service_rec img:last-child").remove();
						$('#service_rec').prepend('<img height="20" width="30" src="images/yes.svg" />');
					   
					}
					else{
						$("#service_rec img:last-child").remove();
						$('#service_rec').prepend('<img height="20" width="30" src="images/no.svg" />');
					} 
				}
					
				if($('input[name='+19+']:checked').attr("value")){
					if($('input[name='+19+']:checked').attr("value")=='Yes'){ 
						$("#amc_enquery img:last-child").remove();
						$('#amc_enquery').prepend('<img height="20" width="30" src="images/yes.svg" />');
					   
					}
					else{
						$("#amc_enquery img:last-child").remove();
						$('#amc_enquery').prepend('<img height="20" width="30" src="images/no.svg" />');
					} 
				}
				
				if($('input[name='+18+']:checked').attr("value")){
					if($('input[name='+18+']:checked').attr("value")=='Yes'){ 
						$("#amcdetails img:last-child").remove();
						$('#amcdetails').prepend('<img height="20" width="30" src="images/yes.svg" />');
					   
					}
					else{
						$("#amcdetails img:last-child").remove();
						$('#amcdetails').prepend('<img height="20" width="30" src="images/no.svg" />');
					} 
				}
				
				if($('input[name='+20+']:checked').attr("value")){
					if($('input[name='+20+']:checked').attr("value")=='Yes'){ 
						$("#upgradeoffers img:last-child").remove();
						$('#upgradeoffers').prepend('<img height="20" width="30" src="images/yes.svg" />');
					   
					}
					else{
						$("#upgradeoffers img:last-child").remove();
						$('#upgradeoffers').prepend('<img height="20" width="30" src="images/no.svg" />');
					} 
				}
				
				if( $('input[name='+21+']:checked').attr("value")){
					if($('input[name='+21+']:checked').attr("value")=='Yes'){
						$("#upgrd img:last-child").remove();
						$('#upgrd').prepend('<img height="20" width="30" src="images/yes.svg" />');
					   
					}
					else{
						$("#upgrd img:last-child").remove();
						$('#upgrd').prepend('<img height="20" width="30" src="images/no.svg" />');
					} 
				}
				
				if($('input[name='+23+']:checked').attr("value")){  
					if($('input[name='+23+']:checked').attr("value")=='Yes'){
						$("#escl img:last-child").remove();
						$('#escl').prepend('<img height="20" width="30" src="images/yes.svg" />');
					   
					}
					else{
						$("#escl img:last-child").remove();
						$('#escl').prepend('<img height="20" width="30" src="images/no.svg" />');
					} 
				}
				
				custQA(name,mobile,customerid);
				
			});
			
			
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
 