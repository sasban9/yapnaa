
<?php
session_start(); 
if(isset($_SESSION['admin_email_id']))
{
	 $admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];
      $ar_id  	        = $_SESSION['ar_id'];
	require_once('controller/admin_controller.php');
	$control	=	new admin();
	$question = $control->user_question_select();
	$answer = $control->user_answer_select();
	
	//echo '<pre>'.print_r($q_a);exit;
	
	if(isset($_POST['editAMCSubmit'])){
		//print_r($_POST);die;
		
		$get_amc_list = $control->updateAMC($_SESSION['admin_email_id'],$_POST['newAMCStart'],$_POST['newAMCEnd'],$_POST['custID'],$_POST['comments'],$_POST['closedBy'],$_POST['phone1'],$_POST['phone2'],$_POST['cust_name'],$_POST['cust_email']);
		if($get_amc_list){
			$_POST = array();
			echo "<script>alert('AMC Updated successfully');</script>";
		}
		else{
			$_POST = array();
			echo "<script>alert('Something went wrong');</script>";
		}
	}
	
	if(isset($_POST['search']) || !empty($_POST['search'])){
		
		$search = $_POST['search'];
		$action_taken_by = $_POST['action_taken_by'];
		$filter = $_POST['filter'];
		$filterByBrand = $_POST['filterByBrand'];
		if(isset($_POST['fromDate']) && !empty($_POST['fromDate'])){ //echo "<br>in from";
			$fromDate = date_format(date_create($_POST['fromDate']),"Y-m-d H:i:s");
		}
		else{
			$fromDate = "";
		}
		if(isset($_POST['toDate']) && !empty($_POST['toDate'])){// echo "<br>in to";
			$toDate = date_format(date_create($_POST['toDate'].' 23:59:59'),"Y-m-d H:i:s");
		}
		else{
			$toDate	=	"";
		}
		if(isset($_POST['amc_fromDate']) && !empty($_POST['amc_fromDate'])){// echo "<br>in to";
			$amc_fromDate= date_format(date_create($_POST['amc_fromDate']),"d-m-Y");
		}
		else{
			$amc_fromDate=	"";
		}
		if(isset($_POST['amc_toDate']) && !empty($_POST['amc_toDate'])){// echo "<br>in to";
			$amc_toDate= date_format(date_create($_POST['amc_toDate']),"d-m-Y");
		}
		else{
			$amc_toDate=	"";
		}
		
		//echo $fromDate."--".$toDate;die;
		//echo $date1;exit;
		$get_amc_list = $control->get_brand_list($action_taken_by,$search,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$filterByBrand);
		
		if(isset($_POST['da_downl']) || !empty($_POST['da_downl'])){
			$control->download_brand_list($action_taken_by,$search,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$filterByBrand);
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
				
				<?php if(isset($_GET['customer_type']))
				{
				switch($_GET['customer_type'])
						{
							case 1:
							$customer='Livpure';
							break;
							case 2:
							$customer='Zero B';
							break;
						}
				}else{
					
			        echo '<script>window.location.assign("index.php")</script>';
				}?>
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
                <div class="col-lg-2">
                 
                </div>
            </div>
           

		<div class="wrapper wrapper-content animated fadeInRight">
		
		   <div class="row">
		   <div class="col-lg-3">
		   <input type="radio" id="newFilter" class="nFilter" name="newFilterCheck" value="New Filter" checked /> New Filter
			<input type="radio" id="oldFilter" class="nFilter" name="newFilterCheck" value="Old Filter" /> Old Filter
			
				
			</div>	 
			</div><br>
		   <div class="row"> </div><br>                
               
			<div class="row">
				<form id="form" method="POST" enctype="multipart/form-data">
				
                <div class="col-lg-3">
					<label>Search Keyword</label>
					<input type="text" id="searchBox" class="maincls form-control" value="<?php echo($_POST['search']==0)?$_POST['search']:"";?>"  maxlength="60" name="search" placeholder="Enter name, number or area">
				</div>
				<?php if($ar_id==1 || $ar_id==2 || $ar_id==5){?>
				 <div class="col-lg-2 new" >
					<label>Filter By</label>
					<select id="filterByBrand" class="form-control" name="filterByBrand">
						<option value="0"<?php echo($_POST['filterByBrand']==0)?"selected":"";?>>Filter</option>
						<option value="1" <?php echo($_POST['filterByBrand']==1)?"selected":"";?>>Highly Engaged Customer</option>
						<option value="2"<?php echo($_POST['filterByBrand']==2)?"selected":"";?> >AMC And Upgrade Opportunity</option>
						<option value="3" <?php echo($_POST['filterByBrand']==3)?"selected":"";?>>Disinterested Customer</option>
						
					</select>
				</div>
				<?php }?>
                <div class="col-lg-2 old" style="display:none">
					<label>Filter By</label>
					<select id="filterBy" class="form-control" name="filter">
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
					<select id="filterBy" class="form-control" name="action_taken_by">
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
					<input type="submit" id="submit"  class="btn btn-info " value="Search"  name="submit" >
				</div>
				<?php if($ar_id==1 || $ar_id==2){?>
				<div class="col-sm-2"  style="margin-left: -86px;margin-top: 23px;">
					<input type="submit" id="da_downl" name="da_downl"  class="btn btn-info" value="Export">
				</div>
				<?php }?>
				<div class="col-lg-2">
					<input type="submit" id="submit"  class="btn btn-info pull-right"  name="none" style="visibility:hidden;">
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
							<th><?php echo $customer; ?> ID</th>
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
					<?php 
						$numbers = array_column($get_amc_list,"PHONE1");//print_r($numbers);die;
						$qust_map['qst'] = array_column($get_amc_list,"qust_map");
						$qust_map = json_encode( $qust_map ); //convert array to a JSON string
						$qust_map = htmlspecialchars( $qust_map, ENT_QUOTES );
						
					for($i=0;$i<count($get_amc_list);$i++){ 
								
							date_default_timezone_set('Asia/Kolkata');
	
							$date = new DateTime("now");
							$date1 = strtotime(date_format(date_create($get_amc_list[$i]['last_called']),"d-m-Y"));
							$date2 = strtotime(date_format($date,"d-m-Y")); 
							$diff = date_diff(date_create($date),date_create($get_amc_list[$i]['last_called']));
							
							//echo "<br>".$date1."--".$date2."--".$diff."<br>";
							$datediff= (int)round(($date2 - $date1)/3600/24,0);
							$qust_map1= $get_amc_list[$i]['qust_map'];
							//echo '<pre>';print_r($qust_map);
							//echo "Days".$datediff;
					?>
						<tr>
							<td><input id="individual_sms" type="checkbox" name="sms[]" value="<?php echo $get_amc_list[$i]['PHONE1'];?>" /></td>
							<td <?php //echo "status".$get_amc_list[$i]['status'];
									/*if($get_amc_list[$i]['users'] != null || !empty($get_amc_list[$i]['users'])){
											echo 'style="background-color:orange;color:white;font-style:bold;"><i class="fa fa-thumbs-o-up" style="margin-right:3%;"></i>Yapnaa Registered';
										}
									
									else{*/
											
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
												
												default:
													echo $get_amc_list[$i]['CUSTOMERID'];
												break;
											}
											/*if($datediff <= 15){ 
												echo "style='background-color:#23c6c8;color:white;'>";
											}*/
											
										//}
									
									?>
									
							</td>
							<td><?php echo $get_amc_list[$i]['PHONE1']; ?></a>
								<?php if($ar_id==1 || $ar_id==2 || $ar_id==5){?>
							<button type="button" style="margin-right:2px;" class="btn btn-info pull-right actionBox" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-mobile2="<?php echo $get_amc_list[$i]['PHONE2']; ?>" data-id="<?php echo $get_amc_list[$i]['id']; ?>" data-contract="<?php echo $get_amc_list[$i]['CONTRACT_FROM']; ?>" data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-next-service-data="<?php echo $get_amc_list[$i]['next_service_date']; ?>" data-last-service-data="<?php echo $get_amc_list[$i]['last_service_date']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-email="<?php echo $get_amc_list[$i]['email']; ?>" data-address="<?php echo $get_amc_list[$i]['CUSTOMER_ADDRESS1']; ?>" data-customerid="<?php echo $get_amc_list[$i]['CUSTOMERID']; ?>"
							data-user-qm="<?php echo $qust_map; ?>"
							
							
							data-toggle="modal" data-target="#userQstM" title="Edit AMC Details"><i class="fa fa-eye"></i></button>	
								<?php } ?>
							</td>
							<td><?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?></td>
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
										$time = strtotime($get_amc_list[$i]['amc_appointment_datetime']);
										echo "Appointment set - ".date('d-m-Y H:i',$time);
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
							/*}
							else{
								echo "Registered in App";
							}*/
								
							
							?></td> 
							<td><?php echo empty($get_amc_list[$i]['last_call_comment'])?$get_amc_list[$i]['last_sms_sent']:$get_amc_list[$i]['last_call_comment']; ?></td>
							<td><?php //if(!($datediff <= 15)){ ?>  
							<button type="button" style="margin-right:2px;" class="btn btn-info pull-right actionBox" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-mobile2="<?php echo $get_amc_list[$i]['PHONE2']; ?>" data-id="<?php echo $get_amc_list[$i]['id']; ?>" data-contract="<?php echo $get_amc_list[$i]['CONTRACT_FROM']; ?>" data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-email="<?php echo $get_amc_list[$i]['email']; ?>" data-toggle="modal" data-target="#editAMC" title="Edit AMC Details"><i class="fa fa-pencil"></i></button>
							
							<button type="button"  style="margin-right:2px; width:38px" class="btn btn-info pull-right actionBox" data-mobile="<?php echo $get_amc_list[$i]['PHONE1']; ?>" data-mobile2="<?php echo $get_amc_list[$i]['PHONE2']; ?>" data-id="<?php echo $get_amc_list[$i]['id']; ?>" data-expiry="<?php echo $get_amc_list[$i]['CONTRACT_TO']; ?>" data-name="<?php echo $get_amc_list[$i]['CUSTOMER_NAME']; ?>" data-email="<?php echo $get_amc_list[$i]['email']; ?>" data-toggle="modal" data-target="#myAction"><i class="fa fa-ellipsis-v"></i></button><?php //}?></td>   
							 
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
  <div class="modal fade" id="myAction" role="dialog">
    <div class="modal-dialog  modal-lg" style="width:80%;margin-right: 22%;margin-top: 2px;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal-title">Do something!</h4>
        </div>
        <div class="modal-body">

		   <div class="row" style="padding-bottom:10px;border-bottom: 1px solid #e5e5e5;">
				<div class="col-lg-5" style="border-right: 1px solid #e5e5e5;"> 
				
				<h4><?php for($i=0;$i<count($question);$i++){
					$k=0;
					if( $question[$i]["group_level"]=='SERVICE SATISFACTION LEVEL'){
					 echo $question[$i]["group_level"];
					 break;
				}}
					 ?></h4>
					<label style="color:blue"><?php for($i=0;$i<count($question);$i++){
					if( $question[$i]["group_id"]=='Service by brand'){
					 echo 'A)'.' '.$question[$i]["group_id"];
					 break;
				}}
					 ?></label></br>
				<?php 
				   
					for($i=0;$i<count($question);$i++){
						$answers	=	$question[$i]["answers"];
						if( $question[$i]["group_level"]=='SERVICE SATISFACTION LEVEL'){
					       if( $question[$i]["group_id"]=='Service by brand'){
							  foreach($qust_map1 as $qm){
								  if($qm['qst_id']==$question[$i]['id']){
									  $ans=$qm['answer'];
									  break;
								  }
							  }
							   
						?>
						
                 
					<br><label data-qid="<?php echo $question[$i]['id'];?>"><?php echo ($i+1).". ".$question[$i]['questions'];?></label><br>
					
						<div class="row"> 
						<?php   
                            					
							for($j=0;$j<count($answers);$j++){?>
								<div class="col-lg-4" >
                                   <?php ?>								
									<input type="radio" class="chk" id="<?php echo $question[$i]['id'];?>" data-qid="<?php echo $question[$i]['id'];?>" value="<?php echo $answers[$j]["answer_type"];?>" name="<?php echo $question[$i]['id'];?>" <?php echo ($ans==$answers[$j]["answer_type"])?'checked':'';?>  >
									
									
									
									<?php echo ' '.$answers[$j]["answer_type"];?>
								</div>
						<?php	} ?>
						</div>
					 <?php }}}?>
					
					</br><label style="color:blue"><?php for($i=0;$i<count($question);$i++){
					if( $question[$i]["group_id"]=='Source of service not known'){
					 echo 'B)'.' '.$question[$i]["group_id"];
					 break;
				}}
					 ?></label></br>
				<?php 
				 $k=1;
					for($i=0;$i<count($question);$i++){
						$answers	=	$question[$i]["answers"];
						
						if( $question[$i]["group_level"]=='SERVICE SATISFACTION LEVEL'){
							
					       if( $question[$i]["group_id"]=='Source of service not known'){
							  // $k=$i++;
							 foreach($qust_map1 as $qm){
								  if($qm['qst_id']==$question[$i]['id']){
									  $ans=$qm['answer'];
									  break;
								  }
							  } 
							
						?>
						
                 
					<br><label data-qid="<?php echo $question[$i]['id'];?>"><?php echo ($k++).". ".$question[$i]['questions'];?></label><br>
					
						<div class="row"> 
						<?php       
							for($j=0;$j<count($answers);$j++){  ?>
							
								<div class="col-lg-4" > 
									<input type="radio" class="chk" id="<?php echo $question[$i]['id'];?>" data-qid="<?php echo $question[$i]['id'];?>" value="<?php echo $answers[$j]["answer_type"];?>" name="<?php echo $question[$i]['id'];?>" <?php echo ($ans==$answers[$j]["answer_type"])?'checked':'';?> 
									>
									<?php echo ' '.$answers[$j]["answer_type"];?>
								</div>
						<?php	} ?>
						</div>
					<?php }}}?>
					</br><label style="color:blue"><?php for($i=0;$i<count($question);$i++){
					if( $question[$i]["group_id"]=='Not interested'){
					 echo 'C)'.' '.$question[$i]["group_id"];
					 break;
				}}
					 ?></label></br>
				<?php 
				 $k=1;
					for($i=0;$i<count($question);$i++){
						$answers	=	$question[$i]["answers"];
						if( $question[$i]["group_level"]=='SERVICE SATISFACTION LEVEL'){
							
					       if( $question[$i]["group_id"]=='Not interested'){
							foreach($qust_map1 as $qm){
								  if($qm['qst_id']==$question[$i]['id']){
									  $ans=$qm['answer'];
									  break;
								  }
							  }     
							 
						?>
						
                 
					<br><label data-qid="<?php echo $question[$i]['id'];?>"><?php echo ( $k++).". ".$question[$i]['questions'];?></label><br>
					
						<div class="row"> 
						<?php       
							for($j=0;$j<count($answers);$j++){?>
								<div class="col-lg-5"> 
									<input type="radio" class="chk" id="<?php echo $question[$i]['id'];?>" data-qid="<?php echo $question[$i]['id'];?>" value="<?php echo $answers[$j]["answer_type"];?>" name="<?php echo $question[$i]['id'];?>"
									<?php echo ($ans==$answers[$j]["answer_type"])?'checked':'';?>
									>
									
									<?php echo ' '.$answers[$j]["answer_type"];?>
								</div> 
						<?php	} ?>
						</div>
					<?php }}}?>	
				</div>
				<div class="col-lg-4" style="padding-left: 29px;border-right: 1px solid #e5e5e5;height:650px"> 
				<?php //echo '<pre>';print_r($question);?>
				<h4><?php for($i=0;$i<count($question);$i++){
					if( $question[$i]["group_level"]=='LOYALTY AND RETENTION INDEX'){
					 echo $question[$i]["group_level"];
					 break;
				}}
					 ?></h4>
					 <label style="color:blue"><?php for($i=0;$i<count($question);$i++){
					if( $question[$i]["group_id"]=='Ownership Experience'){
					 echo 'A)'.' '.$question[$i]["group_id"];
					 break;
				}}
					 ?></label></br>
				<?php 
				$k=1;
					for($i=0;$i<count($question);$i++){
						$answers	=	$question[$i]["answers"];
						if( $question[$i]["group_level"]=='LOYALTY AND RETENTION INDEX'){
					     foreach($qust_map1 as $qm){
								  if($qm['qst_id']==$question[$i]['id']){
									  $ans=$qm['answer'];
									  break;
								  }
							  } 
						?>
						
                 
					<br><label data-qid="<?php echo $question[$i]['id'];?>"><?php echo ($k++).". ".$question[$i]['questions'];?></label><br>
						<div class="row"> 
						<?php 
							for($j=0;$j<count($answers);$j++){?>
								<div class="col-lg-4" > 
									<input type="radio" class="chk" id="<?php echo $question[$i]['id'];?>" value="<?php echo $answers[$j]["answer_type"];?>" name="<?php echo $question[$i]['id'];?>" <?php echo ($ans==$answers[$j]["answer_type"])?'checked':'';?>>
									
									<?php echo ' '.$answers[$j]["answer_type"];?>
								</div>
						<?php	} ?>
						</div>
					<?php }}?>
				</div>
				<div class="col-lg-3" style="padding-left: 29px;"> 
				<?php //echo '<pre>';print_r($question);?>
				<h4><?php for($i=0;$i<count($question);$i++){
					if( $question[$i]["group_level"]=='CONVERSION OPPORTUNITY'){
					 echo $question[$i]["group_level"];
					 break;
				}}
					 ?></h4>
					 
				<?php 
				$k=1;
					for($i=0;$i<count($question);$i++){
						$answers	=	$question[$i]["answers"];
						if( $question[$i]["group_level"]=='CONVERSION OPPORTUNITY'){
					    foreach($qust_map1 as $qm){
								  if($qm['qst_id']==$question[$i]['id']){
									  $ans=$qm['answer'];
									  break;
								  }
							  } 
						?>
						
                 
					<br><br><label data-qid="<?php echo $question[$i]['id'];?>"><?php echo ($k++).". ".$question[$i]['questions'];?></label><br>
						<div class="row"> 
						<?php 
							for($j=0;$j<count($answers);$j++){?>
								<div class="col-lg-3"> 
									<input type="radio" class="chk" id="<?php echo $question[$i]['id'];?>" value="<?php echo $answers[$j]["answer_type"];?>" name="<?php echo $question[$i]['id'];?>" <?php echo ($ans==$answers[$j]["answer_type"])?'checked':'';?>>
									
									
									<?php echo ' '.$answers[$j]["answer_type"];?>
								</div>
						<?php	} ?>
						</div>
					<?php }}?>
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
			<?php foreach($std_comments as $std_in){?>
						<option value="<?php echo $std_in['comments'] ;?>"><?php echo $std_in['comments'] ;?></option>
						
			<?php } ?>
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
			<button type="button" class="btn btn-warning pull-left" id="general" style="    margin-top: 16px;">
									<i class="fa fa-bullhorn" ></i>Yapnaa Interested</button>
		</div>
		
		</div>
		<div class="row" >
			
		</div>
		
        </div>
        <div class="modal-footer" style="margin-bottom:8% !important;">
			<button type="button" id="cust_reply" name="cust_reply" class="btn btn-info" data-toggle="modal" data-target="#customer_reply">
							Save </button>
			
			
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
          <h4 class="modal-title" id="modal-title">Do something!</h4>
        </div>
        <div class="modal-body">
			 <div class="row" style="margin-top:2%;">
			<div class="col-lg-5"> 
				
			</div>
			
				<div class="col-lg-5"> 
				
			</div>
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
		<form action="" method="POST">
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
		</form>
        </div>
      </div>
      
    </div>
  </div>
  <!-- Modal for admin view questions-->
   <div class="modal fade" id="userQstM" role="dialog">
    <div class="modal-dialog  modal-lg"  style="width:80%;margin-right: 20%;margin-top: 2px;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <!--div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modal-title">Do something!</h4>
        </div-->
        <div class="modal-body" style="padding: 20px 30px 0px 30px;" >
		<div class="row"  style="padding-bottom:10px;border-bottom: 1px solid #e5e5e5;">
		
		    <button type="button" class="close pull-right" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="modal-title1"></h4>
			</div>
			<div class="row">
			<form method="post" id="form_amcDateSub">
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
					
				    <label>Satisfaction Lavel</label>
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
				  <span>1. Service by Brand<span id="service_bb"  style="padding-left:140px;line-height: 43px;"></span></span>
				</div>
				<div class="row" style="margin-left: 3px;">
				 <span>2. Under AMC<span id="service_amc"  style="padding-left: 172px;line-height: 43px;"></span></span>
				</div>
				<div class="row" style="margin-left: 3px;">
				<span>3. Satisfied with timelines<span id="service_st"  style="padding-left:109px;line-height: 43px;"></span></span>
				</div>
				<div class="row" style="margin-left: 3px;">
				<span>4. Satisfied with workmanship<span id="service_sw"  style="padding-left:83px;line-height: 43px;"></span></span>
				</div>
				<div class="row" style="margin-left: 3px;">
				<span>5. Likely to buy next product<span id="service_buy"  style="padding-left:92px;line-height: 43px;"></span></span>
				</div>
				<div class="row" style="margin-left: 3px;">
				<span>6. Refers product<span id="service_pd"  style="padding-left:154px;line-height: 43px;"></span></span>
				</div>
				<div class="row" style="margin-left: 3px;">
				<span>7. Share knowledge<span id="service_kwd"  style="padding-left:138px;line-height: 43px;"></span></span>
				</div>
				
				</div>
				
				<div class="col-lg-3" style="border-right: 1px solid #e5e5e5;height:448px;"> 
				<h4>CUSTOMER ENGAGEMENT DATA</h4><br>
				<div class="row" style="margin-left: 3px;">
				  <span>1. AMC Signed<span id="next_ser_dt" style="padding-left:166px"></span></span><br>
				  <span>a) Next Service Date</span><br>
				  <input type="date" class="form-control"  id="next_service_date" name="next_service_date" style="width: 160px;height: 33px;" >
				</div>
				<div class="row" style="margin-left: 3px;">
				  <span>b) Expiry Date</span><br>
				  
				  <input type="date" class="form-control"  id="expiry_date" name="expiry_date" style="width: 160px;height: 33px;" >
				</div>
				<div class="row" style="margin-left: 3px;">
				  <br><span>2. Paid Service.Last Service Date <span id="last_ser_dt" style="padding-left: 54px;"></span></span><br>
				  
				 <input type="date" class="form-control"  id="ls_ser_date" name="ls_ser_date" style="width: 160px;height: 33px;" >
				</div>
				<div class="row" style="margin-left: 3px;">
				  <br><span>3. Not Interested Due to-</span> 
				</div>
				<div class="row" style="margin-left: 3px;">
				  <span>a) Poor service<span id="poor_sr"  style="padding-left:165px;line-height: 29px;"></span></span> 
				</div>
				<div class="row" style="margin-left: 3px;">
				  <span>b) Cost reasons<span id="cust_res"  style="padding-left:161px;line-height: 29px;"></span></span>
				</div>
				<div class="row" style="margin-left: 3px;">
				  <span>c) Not convenient<span id="not_conv"  style="padding-left:151px;line-height: 29px;"></span></span>
				</div>
				<div class="row" style="margin-left: 3px;">
				  <span>d) Bad experience<span id="bad_exp"  style="padding-left:147px;line-height: 29px;"></span></span>
				</div>
				</div>
				<div class="col-lg-3" >
					<h4>CONVERSION OPPORTUNITY</h4>
					<div class="row" style="margin-left: 3px;">
						<span>1. Service request received<span id="service_rec"  style="padding-left:111px;line-height: 43px;"></span></span>
					</div>
					<div class="row" style="margin-left: 3px;">
						<span>2. AMC enquiry received<span id="amc_enquery"  style="padding-left:126px;line-height: 43px;"></span></span>
					</div>
					<div class="row" style="margin-left: 3px;">
						<span>3. Upgrade enquiry <span id="upgrd"  style="padding-left:154px;line-height: 43px;"></span></span>
					</div>
					<div class="row" style="margin-left: 3px;">
						<span>4. Escalation<span id="escl"  style="padding-left:194px;line-height: 43px;"></span></span>
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
          <h4 class="modal-title" id="modal-title">Do something!</h4>
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
    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
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
			/*$("#submit").click(function(){
				if$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate
			});*/
		  
			
            $('.dataTables-example').dataTable({
                responsive: true,
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
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
				var custType= <?php echo $_GET['customer_type'];?>;
				var id                  =	sessionStorage.id;
				var amcExpDate           =	$('#expiry_date').val();
				var amcServiceDate       =	$('#next_service_date').val();
				var ls_ser_date          =	$('#ls_ser_date').val();
			
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
			$("#cust_reply").click(function(){
				var custType= <?php echo $_GET['customer_type'];?>;
					 $("input:radio[class=chk]:checked").each(function () {
						var quest = $(this).attr("id");	
						var ans = $(this).val();
                        					
						
					    var mob=	sessionStorage.mobile;
						
						var brandId=1;
						var brandName=(custType==2)?'Zero B':'Livpure';  
						$.ajax({
							url:"smsActions.php?custResponse=submit",
							type:"POST",
							data:{userQst:quest,answer:ans,number:mob,brandId:brandId,brandName:brandName},
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
			$(".actionBox,editAMC").click(function(){
				sessionStorage.id = $(this).attr('data-id');
				sessionStorage.name = $(this).attr('data-name');
				sessionStorage.email = $(this).attr('data-email');
				sessionStorage.mobile = $(this).attr('data-mobile');
				sessionStorage.mobile2 = $(this).attr('data-mobile2');
				sessionStorage.expiry = $(this).attr('data-expiry');
				sessionStorage.amcFrom = $(this).attr('data-contract');

				$("#custID,.custID").val(sessionStorage.id);
				$("#phone1").val(sessionStorage.mobile);
				$("#phone2").val(sessionStorage.mobile2);
				$("#cust_name").val(sessionStorage.name);
				$("#cust_email").val(sessionStorage.email);
				
				var now = new Date(sessionStorage.expiry);
				var day = ("0" + now.getDate()).slice(-2);
				var month = ("0" + (now.getMonth() + 1)).slice(-2);
				var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
				
				// $("#newAMCStart").val(sessionStorage.amcFrom);
				// $("newAMCEnd").val(sessionStorage.expiry);
				if(sessionStorage.expiry != "" && sessionStorage.amcFrom != ""){
					$("#currentAMC").html($(this).attr('data-contract')+" to "+$(this).attr('data-expiry'));
				}
				else{
					$("#currentAMC").html("Not available");
				}
				
				
				//$('#datePicker').val(today);
				
				if(sessionStorage.expiry){
					$("#amcExp").val(today);
				}
				<?php if(isset($_GET['customer_type']))
				{
				switch($_GET['customer_type'])
						{
							case 1:?>
							$("#modal-title").html("Customer Name: "+sessionStorage.name+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+"Brand Name: "+'<?php echo $customer;?>');
							<?php break;
							case 2:?>
							$("#modal-title").html("Customer Name: "+sessionStorage.name+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+"Brand Name: "+'<?php echo $customer;?>');
							<?php 
							
							break;
						}
				}?>
				
				//$("#modal-title").html("Brand Name: "+'Zero-B');
			});
			$(".actionBox,userQstM").click(function(){
				sessionStorage.id = $(this).attr('data-id');
				sessionStorage.name = $(this).attr('data-name');
				sessionStorage.email = $(this).attr('data-email');
				sessionStorage.mobile = $(this).attr('data-mobile');
				sessionStorage.mobile2 = $(this).attr('data-mobile2');
				sessionStorage.expiry = $(this).attr('data-expiry');
				sessionStorage.amcFrom = $(this).attr('data-contract');
				sessionStorage.address = $(this).attr('data-address');
				sessionStorage.customerid = $(this).attr('data-customerid');
				sessionStorage.nextServiceDate = $(this).attr('data-next-service-data');
				sessionStorage.lastServiceDate = $(this).attr('data-last-service-data');
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
				
				
				$("#phone11").html(sessionStorage.mobile);
				$("#phone21").html(sessionStorage.mobile2);
				$("#cust_name1").html(sessionStorage.name);
				$("#cust_email1").html(sessionStorage.email);
				$("#cust_address").html(sessionStorage.address);
				$("#cust_id").html(sessionStorage.customerid);
				if(sessionStorage.nextServiceDate){
				$("#next_service_date").val(sessionStorage.nextServiceDate);
				}
				if(sessionStorage.lastServiceDate){
				$("#ls_ser_date").val(sessionStorage.lastServiceDate);
				}
				if(sessionStorage.expiry){
				$("#expiry_date").val(sessionStorage.expiry);
				}
				//alert(sessionStorage.nextServiceDate);
				
				var jsonData = JSON.parse($(this).attr('data-user-qm'));
				var questionId= $('.chk:checked').attr('data-qid');
				var answer= $('.chk:checked').val();
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
							//$("#last_ser_dt").last().remove();
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
							//$("#last_ser_dt").last().remove();
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
							//$("#last_ser_dt").last().remove();
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
							//$("#last_ser_dt").last().remove();
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
						
						if($('input[name='+18+']:checked').attr("value") ||  $('input[name='+19+']:checked').attr("value")){
						if($('input[name='+18+']:checked').attr("value")=='Yes' || $('input[name='+19+']:checked').attr("value")=='Yes'){ 
							$("#amc_enquery img:last-child").remove();
							$('#amc_enquery').prepend('<img height="20" width="30" src="images/yes.svg" />');
						   
						}
						else{
							$("#amc_enquery img:last-child").remove();
							$('#amc_enquery').prepend('<img height="20" width="30" src="images/no.svg" />');
						} 
						}
						if($('input[name='+20+']:checked').attr("value") || $('input[name='+21+']:checked').attr("value")){
						if($('input[name='+20+']:checked').attr("value")=='Yes' || $('input[name='+21+']:checked').attr("value")=='Yes'){
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
						
						<?php if(isset($_GET['customer_type']))
				{
				switch($_GET['customer_type'])
						{
							case 1:?>
							$("#modal-title1").html("Customer Name: "+sessionStorage.name+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+"Brand Name: "+'<?php echo $customer;?>');
							<?php break;
							case 2:?>
							$("#modal-title1").html("Customer Name: "+sessionStorage.name+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+'&nbsp'+"Brand Name: "+'<?php echo $customer;?>');
							<?php 
							
							break;
						}
				}?>
				
                
				
				
				
			
			
			});
			
			$("#appSMS").click(function(){
				var date = $("#appDate").val();
				if(date == ''){
					alert("Appointment Date and time is not entered!");
				}
				else{
					var custType=<?php echo $_GET['customer_type'];?>;
				var fncomment=$("#std_comments").find(":selected").val()+' '+$("#comments").val();
					$.ajax({
						url:"smsActions.php?appointmentDate="+date,
						type:"POST",
						data:{id:sessionStorage.id,number:sessionStorage.mobile,comment:fncomment,custType:custType},
						success:function(response){
							console.log(response);
							if(response){
								alert("SMS sent successfully.");
								location.reload();
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
					var custType=<?php echo $_GET['customer_type'];?>;
					var fncomment=$("#std_comments").find(":selected").val()+' '+$("#comments").val();
					$.ajax({
						url:"smsActions.php?expiryDate="+date,
						type:"POST",
						data:{id:sessionStorage.id,number:sessionStorage.mobile,comment:fncomment,custType:custType},
						success:function(response){
							console.log(response);
							if(response){
								alert("SMS sent successfully.");
								location.reload();
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					});
				}
			});
			
			$("#noInsterest").click(function(){
				if($("#comments").val() == ''  && $("#std_comments").find(":selected").val()==''){
					alert("Enter comments first!");
				}
				else{
					var custType=<?php echo $_GET['customer_type'];?>;
					var fncomment=$("#std_comments").find(":selected").val()+' '+$("#comments").val();
					$.ajax({
						url:"smsActions.php?notInterested=submit",
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
			
			$("#general").click(function(){ 
			       var custType=<?php echo $_GET['customer_type'];?>;
			       var fncomment=$("#std_comments").find(":selected").val()+' '+$("#comments").val();
					$.ajax({
						url:"smsActions.php?general=submit",
						type:"POST",
						data:{id:sessionStorage.id,number:sessionStorage.mobile,comment:fncomment,custType:custType},
						success:function(response){
							console.log(response);
							if(response){
								alert("SMS sent successfully.");
								location.reload();
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
