<?php
session_start(); 
if(isset($_SESSION['b_store_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 

 $storeid						=	$_SESSION['b_store_id'];
 $get_store_details_by_id		=	$vendor_controller->get_store_details_by_id($storeid); 
 // echo '<pre>';print_r($get_store_details_by_id);exit;
 
?>
      
        <section id="content">
          <section class="vbox">
            <header class="header bg-white b-b b-light">
              <p> <i class="fa fa-user"></i> Store Details    <span class="pull-right" style="padding-left:10px">  <a href="shop-list-details-edit.php?storeid=<?php echo $storeid;?>" target="_blank"><span class="label bg-primary"><i class="fa fa-edit"></i> Edit </span></a></span></p>  
            </header>
            <section class="scrollable wrapper">              
              <div class="row">
			   
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
								  <img src="../../admin/admin-views/images/business_stores/<?php echo $get_store_details_by_id[0]['b_store_image'];?>" class="img-circle">
								 <?php } else { ?>
								  <img src="images/Qno-logo-png.png" class="img-circle">
								 <?php } ?>
								</div>
							  </div>
							  <div class="h4 m-t m-b-xs"><?php echo $get_store_details_by_id[0]['b_store_name'];?> ( <small class="text-muted m-b"> <span style="color:green"> <?php echo $get_store_details_by_id[0]['b_store_unique_id'];?> )</span></small> </div>
							  
							  <p><small class="text-muted m-b">Owner Name: <span style="color:green"> <?php echo $get_store_details_by_id[0]['b_store_owner_name'];?></span></small></p>
							   
							  <p><small class="text-muted m-b">Main Category: <span style="color:green"> <?php echo $get_store_details_by_id[0]['mc_title'];?></span></small></p>
							  
							  <p><small class="text-muted m-b">Sub Category: <span style="color:green"> <?php echo $get_store_details_by_id[0]['sc_title'];?></span></small></p> 
							  
					 
							<a href="shop-qr-code-print.php?storeid=<?php echo $get_store_details_by_id[0]['b_store_unique_id'];?>" target="_blank"  class="btn btn-success" > <i class="fa fa-print"></i> <a/>
							  
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
