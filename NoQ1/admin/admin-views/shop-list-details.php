<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 

 $storeid						=	$_REQUEST['storeid'];
 $get_store_details_by_id		=	$admin_controller->get_store_details_by_id($storeid); 
 // echo '<pre>';print_r($get_store_details_by_id);exit;
 
 
  
/* get_business_store_enquiries*/
// $get_business_store_enquiries	=	$admin_controller->get_business_store_enquiries();  
// echo'<pre>';print_r($get_business_store_enquiries);exit;


?>
        <section id="content">
          <section class="vbox">
            <header class="header bg-white b-b b-light">
              <p> <i class="fa fa-user"></i> Store Details    <span class="pull-right" style="padding-left:10px">  <a href="shop-list-details-edit.php?storeid=<?php echo $storeid;?>" target="_blank"><span class="label bg-primary"><i class="fa fa-edit"></i> Edit </span></a></span></p>  
            </header>
            <section class="scrollable wrapper">              
              <div class="row">
			  
			  <?php 
				date_default_timezone_set ("Asia/Calcutta");  
				$b_store_adv_start_date			= 	date('d-M-Y h:m:s');   
				// echo  $get_store_details_by_id[0]['b_store_adv_end_date'];
				// $b_store_adv_end_date			=	explode('/',$get_store_details_by_id[0]['b_store_adv_end_date']);   

				// $b_store_adv_start_date			= 	date('d-M-Y h:m:s'); 
				// $startTimeStamp 				= 	strtotime($b_store_adv_start_date);  	 
				// $endTimeStamp 					= strtotime((implode("/",array_reverse($b_store_adv_end_date))));

				// $timeDiff = abs($endTimeStamp - $startTimeStamp);

				// $numberDays = $timeDiff/86400;  // 86400 seconds in one day 
				 // $numberDays = intval($numberDays);
				// if($numberDays <=30 && $numberDays !=0 && $numberDays >=0) 
				// {  ?>
			 <!-- <div class="col-lg-12">
                  <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      Expire Validation
                    </header>
                    <ul class="list-group"> 
                      <li class="list-group-item"> 
                        <div class="progress progress-sm progress-striped  active">
                          <div class="progress-bar progress-bar-danger" data-toggle="tooltip" data-original-title="30%"style="width: <?php echo $numberDays*3.33;?>%"></div> 
                        </div> 
						<h5>Store account will expire after <span style="color:red"><?php echo $numberDays;?></span> days.</h5>
                      </li> 
                    </ul>
                  </section>
                </div>-->
				<?php// }?>
				
				
				
				
				<?php /*if($numberDays ==0 || $numberDays <=0) 
				{  
					$res = $admin_controller->get_store_expires_by_id($storeid); 
				?>
				
				<div class="col-lg-12">
                  <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                    Store account hasbeen exipred
                    </header>
                    <ul class="list-group"> 
                      <li class="list-group-item"> 
                         <div class="alert alert-danger"> 
							<i class="fa fa-ban-circle"></i><strong>Oh snap!</strong> Hi store account hasbeen exipred. Please call to store owner for renewal</a>.
						  </div> 
                      </li> 
                    </ul>
                  </section>
                </div>
				<?php } */?>
				
				
				 
				
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-lg-6">
					  <section class="panel panel-default">
						<div class="panel-body">
						  <div class="clearfix text-center m-t">
							<div class="inline">
							  <div class="easypiechart" data-percent="100" data-line-width="5" data-bar-color="#4cc0c1" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="130" data-line-cap='butt' data-animate="1000">
								<div class="thumb-lg">
								<?php if($get_store_details_by_id[0]['b_store_image']){ ?>
								  <img src="images/business_stores/<?php echo $get_store_details_by_id[0]['b_store_image'];?>" class="img-circle">
								 <?php } else { ?>
								  <img src="images/logo.png" class="img-circle">
								 <?php } ?>
								</div>
							  </div>
							  <div class="h4 m-t m-b-xs"><?php echo $get_store_details_by_id[0]['b_store_name'];?> ( <small class="text-muted m-b"> <span style="color:green"> <?php echo $get_store_details_by_id[0]['b_store_unique_id'];?> )</span></small> </div>
							  
							  <p><small class="text-muted m-b">Owner Name: <span style="color:green"> <?php echo $get_store_details_by_id[0]['b_store_owner_name'];?></span></small></p>
							   
							  <p><small class="text-muted m-b">Main Category: <span style="color:green"> <?php echo $get_store_details_by_id[0]['mc_title'];?></span></small></p>
							  
							  <p><small class="text-muted m-b">Sub Category: <span style="color:green"> <?php echo $get_store_details_by_id[0]['sc_title'];?></span></small></p> 
							  
						<!--	  <p><small class="text-muted m-b">No day's to account expire: <span style="color:green"> <?php echo $numberDays;?> Day's</span></small></p>-->
							   
							  
							</div>                      
						  </div>
						</div>
						<footer class="panel-footer bg-info text-center">
						  <div class="row pull-out">
							<div class="col-xs-6">
							  <div class="padder-v">
								<span class="m-b-xs h4 block text-white"><i class="fa fa-mobile"></i> Mobile</span>
								<small class="text-muted"><?php echo $get_store_details_by_id[0]['b_store_mobile_no'];?></small>
							  </div>
							</div>
							<div class="col-xs-6 dk">
							  <div class="padder-v">
								<span class="m-b-xs h4 block text-white"><i class="fa fa-envelope-o"></i> Email</span>
								<small class="text-muted"><?php if($get_store_details_by_id[0]['b_store_email']){?><?php echo $get_store_details_by_id[0]['b_store_email']; } else { echo '<span style="color:red">Not Avialable</span>'; }?></small>
							  </div>
							</div> 
						  </div>
						</footer>
					  </section>
					</div>
                    <div class="col-sm-6">                  
                      <section class="panel panel-default"> 
					 <?php if($get_store_details_by_id[0]['b_store_status']==1){?>
						<header class="panel-heading bg-success  lt no-border">
                          <div class="clearfix"> 
                            <div class="clear">
                              <div class="h3 m-t-xs m-b-xs text-white">
								Verified user
                                <i class="fa fa-circle text-white pull-right text-xs m-t-sm"></i>
                              </div> 
                            </div>                
                          </div>
                        </header>
						
						<?php } else{ ?>
						
						<header class="panel-heading bg-danger lt no-border">
                          <div class="clearfix"> 
                            <div class="clear">
                              <div class="h3 m-t-xs m-b-xs text-white">
                               Not verified user
                                <i class="fa fa-circle text-white pull-right text-xs m-t-sm"></i>
                              </div> 
                            </div>                
                          </div>
                        </header>
						
						<?php } ?>
						
                        <ul class="list-group no-radius">
                           <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_landline']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_landline'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-user"></i></span>
							Landline
                          </li> 
						  <li class="list-group-item">
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_registration_date'];?></span>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
                            Registration Date
                          </li> 
                          <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_last_login']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_last_login'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
							Last Login
                          </li>  
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_zip']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_zip'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-map-marker"></i></span>
							Zipcode
                          </li>
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_no_viewers']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_no_viewers'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-eye"></i></span>
							No's Of Viewers
                          </li>
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_working_days']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_working_days'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
							Working Days
                          </li> 
						   <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_working_hours_from_time']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_working_hours_from_time'].'-'.$get_store_details_by_id[0]['b_store_working_hours_end_time'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
							Open Time & Close Time
                          </li>   
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_has_delivery']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_has_delivery'];?></span>
							<?php } else{ ?>
							<span class="pull-right">  No</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-shopping-cart"></i></span>
							Has Home Delivery?
                          </li> 
                        </ul>
						<br/><br/>
                      </section>
                    </div>
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					
					<div class="col-lg-6">
					  <section class="panel panel-default">
                        <div class="panel-body"> 
                            <div class="clear">
                             <?php if($get_store_details_by_id[0]['b_store_description']){?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-comment"></i> Description </span></span></p> <br/>
						    <p> <span class="pull-left"> <?php echo $get_store_details_by_id[0]['b_store_description'];?></span></p> 
							<?php } else{ ?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Description </span></span></p> <br/>
						    <p> <span class="pull-left" style="color:red">  Not Availble</span></p>  
							<?php } ?>
                          </div>
						  
						   <hr/>

						   <div class="clear">
                             <?php if($get_store_details_by_id[0]['b_store_address1']){?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Address </span></span></p> <br/>
						    <p> <span class="pull-left"> <?php echo $get_store_details_by_id[0]['b_store_address1'];?></span></p> 
							<?php } else{ ?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Address </span></span></p> <br/>
						    <p> <span class="pull-left" style="color:red">  Not Availble</span></p>  
							<?php } ?>
                          </div>
						  <hr/>
						  
						  
						  
						  <div class="clear">
                             <?php if($get_store_details_by_id[0]['b_store_address2']){?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Address - 2 </span></span></p> <br/>
						    <p> <span class="pull-left"> <?php echo $get_store_details_by_id[0]['b_store_address2'];?></span></p> 
							<?php } else{ ?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Address - 2 </span></span></p> <br/>
						    <p> <span class="pull-left" style="color:red">  Not Availble</span></p>  
							<?php } ?>
                          </div>
						  <hr/>
						  
						  
						  
						    
						  <div class="clear">
                             <?php if($get_store_details_by_id[0]['b_store_area']){?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Area </span></span></p> <br/>
						    <p> <span class="pull-left"> <?php echo $get_store_details_by_id[0]['b_store_area'];?></span></p> 
							<?php } else{ ?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Area </span></span></p> <br/>
						    <p> <span class="pull-left" style="color:red">  Not Availble</span></p>  
							<?php } ?>
                          </div>
						  <hr/>
						  
						  
						      
						  <div class="clear">
                             <?php if($get_store_details_by_id[0]['b_store_landmark']){?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Landmark </span></span></p> <br/>
						    <p> <span class="pull-left"> <?php echo $get_store_details_by_id[0]['b_store_landmark'];?></span></p> 
							<?php } else{ ?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Landmark </span></span></p> <br/>
						    <p> <span class="pull-left" style="color:red">  Not Availble</span></p>  
							<?php } ?>
                          </div>
						  <hr/>
						  
						  
						  
						
						   
						   
						  
						 <div class="clear">
                             <?php if($get_store_details_by_id[0]['b_store_city']){?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> City Name</span></span></p> <br/>
						    <p> <span class="pull-left"> <?php echo $get_store_details_by_id[0]['b_store_city'];?></span></p> 
							<?php } else{ ?>
							<p> <span class="pull-left">  <span class="label bg-primary"> <i class="fa fa-map-marker"></i>    City Name</span></span></p> <br/>
						    <p> <span class="pull-left"  style="color:red">  Not Availble</span></p> 
							<?php } ?>
                          </div>
						   <hr/>
						  
						   <div class="clear">
                             <?php if($get_store_details_by_id[0]['b_store_state']){?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> State Name </span></span></p> <br/>
						    <p> <span class="pull-left"> <?php echo $get_store_details_by_id[0]['b_store_state'];?></span></p> 
							<?php } else{ ?> 
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> State Name</span></span></p> <br/>
						    <p> <span class="pull-left"  style="color:red">  Not Availble</span></p> 
							<?php } ?>
                          </div>
						   
						   <hr/>
						     
						   <div class="clear">
                             <?php if($get_store_details_by_id[0]['b_store_country']){?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Country</span></span></p> <br/>
						    <p> <span class="pull-left"> <?php echo $get_store_details_by_id[0]['b_store_country'];?></span></p> 
							<?php } else{ ?> 
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Country</span></span></p> <br/>
						    <p> <span class="pull-left"  style="color:red">  Not Availble</span></p> 
							<?php } ?>
                          </div>
						  
						   <hr/>
						    
						   <div class="clear">
                             <?php if($get_store_details_by_id[0]['b_store_zip']){?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Zip Code </span></span></p> <br/>
						    <p> <span class="pull-left"> <?php echo $get_store_details_by_id[0]['b_store_zip'];?></span></p> 
							<?php } else{ ?> 
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-map-marker"></i> Zip Code</span></span></p> <br/>
						    <p> <span class="pull-left"  style="color:red">  Not Availble</span></p> 
							<?php } ?>
                          </div>
						  
						  
                        </div>
                      </section> 
					  
					<!--  <section class="panel panel-default">
                        <div class="panel-body"> 
                          <div class="clear">
                             <?php if($get_store_details_by_id[0]['b_store_invoice_approved_by']){?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-rupee"></i> Invoice Approved By </span></span></p> <br/>
						    <p> <span class="pull-left"> <?php echo $get_store_details_by_id[0]['b_store_invoice_approved_by'];?></span></p> 
							<?php } else{ ?>
							<p> <span class="pull-left">  <span class="label bg-primary"><i class="fa fa-rupee"></i> Invoice Approved By </span></span></p> <br/>
						    <p> <span class="pull-left" style="color:red">  Not Availble</span></p>  
							<?php } ?>
                          </div> 
                        </div>
                      </section> 
					  -->
					  
					</div>
					
					
					
					
					
					
					 <div class="col-sm-6">                  
                      <section class="panel panel-default">  
                        <ul class="list-group no-radius">
                           <li class="list-group-item">
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_registration_date'];?></span>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
                            Registration Date
                          </li> 
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_m_date']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_m_date'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
							Data Modified Date
                          </li>  
                         <!-- <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_adv_start_date']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_adv_start_date'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
							Start Date
                          </li>  
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_adv_end_date']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_adv_end_date'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
							End Date
                          </li>
						  
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_paid_amount']){?>
                            <span class="pull-right"> <i class="fa fa-rupee"></i> <?php echo $get_store_details_by_id[0]['b_store_paid_amount'];?>  /-</span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-rupee"></i></span>
							Amount Paid
                          </li>
						 <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_invoice_no']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_invoice_no'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-file"></i></span>
							Invoice No
                          </li> 
						  
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_invoice_generated_date']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_invoice_generated_date'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
							Invoice Created Date
                          </li> 
						  
						  
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_executive_id']){?>
                            <span class="pull-right"><a href="executive-list-details.php?exeid=<?php echo $get_store_details_by_id[0]['b_store_executive_id'];?>" target="_blank" style="color:green"> <?php echo $get_store_details_by_id[0]['b_store_executive_id'];?></a></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-group"></i></span>
							Executive Id
                          </li> -->
						   
						   
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_category_class']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_category_class'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-tag"></i></span>
							Category Class
                          </li> 
						   
						   
						  <li class="list-group-item">
						    <?php if($get_store_details_by_id[0]['b_store_document_prof']){?>
                            <span class="pull-right"> <?php echo $get_store_details_by_id[0]['b_store_document_prof'];?></span>
							<?php } else{ ?>
							<span class="pull-right"  style="color:red">  Not Availble</span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-file"></i></span>
							Document Proof
                          </li> 
						   
						   
						   
                        </ul>
                      </section>
                    </div>
					 
					 
					 
					 
					 
					 <!--
					  <div class="col-sm-12">   
						<section class="panel panel-default"> 
							<div class="table-responsive">
							 <table class="table table-striped m-b-none" id="mc_table">
								<thead>
								  <tr>
									<th width="20%">Sl.No</th>
									<th width="20%">User Name</th>
									<th width="25%">Mobile No</th>
									<th width="20%">Subject</th>
									<th width="25%">Message</th> 
									<th width="15%">Reg Date</th>  
									<th width="15%">Sent By</th>  
								  </tr>
								</thead>
								<tbody>
								<?php $j=1;?>
								<?php for($i=0;$i<count($get_business_store_enquiries);$i++){ 
									if($get_business_store_enquiries[$i]['user_quote_ref_shop_id']==$storeid){  ?>
									<tr>
										<td><?php echo  $j; ?></td> 
										<td><?php if($get_business_store_enquiries[$i]['user_quote_sent_by']==2){  ?>
											<a href="user-details.php?userid=<?php echo $get_business_store_enquiries[$i]['user_quote_ref_user_id'];?> " style='color:green' target="_blank"><?php echo $get_business_store_enquiries[$i]['user_quote_full_name'];?></a><?php  }else{ 
												echo $get_business_store_enquiries[$i]['user_quote_full_name']; 
										} ?></td> 
										
										<td><?php echo $get_business_store_enquiries[$i]['user_quote_mobile_no']; ?></td> 
										<td><?php echo $get_business_store_enquiries[$i]['user_quote_subject']; ?></td> 
										<td><?php echo $get_business_store_enquiries[$i]['user_quote_message']; ?></td>  
										<td><?php echo $get_business_store_enquiries[$i]['user_quote_c_date']; ?></td> 
										<td><?php if($get_business_store_enquiries[$i]['user_quote_sent_by']==2){ echo "App";}else{
										echo "Website";
										} ?></td> 
										
										
										 
										  
									</tr>
								<?php $j++; } } ?>
								</tbody>
							  </table>
							</div>
						  </section> 
						 </div> 
                  </div>
                </div> 
              </div>  
            </section> 
          </section>
		  
		  -->
		  
		  
		  
		  
		  
		  
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section> 
      </section>
    </section>
  </section>

<?php include "footer.php";?>


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
