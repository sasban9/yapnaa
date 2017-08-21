<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 


$user_id	=	$_REQUEST['user_id']; 




/* Get order List*/
$get_user_id_details	=	$admin_controller->get_user_details($user_id);  
//echo'<pre>';print_r($get_user_id_details);exit;

?>
      
    <section id="content">
        <section class="vbox">          
            <section class="scrollable padder">
              	<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                	<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                	<li class="active">User details</li>
              	</ul> 

				<section class="scrollable wrapper">              
              		<div class="row">
				 		<div class="col-lg-10">
                  			<section class="panel panel-default"> 
								<div class="panel-body">
                      				<div class="clearfix text-center m-t">
                        				<div class="inline">
                          					<div class="easypiechart" data-percent="100" data- line-width="5" data-bar-color="#4cc0c1" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="130" data-line-cap='butt' data-animate="1000">
                            					<div class="thumb-lg"> 
                            					    <?php 
                            					    	if($get_user_id_details[0]['user_profile_pic']) { 
                            					    	    echo '<img src="images/default_profile.png" class="img-circle">';		
                            					    	}else{?>
															<img src="images/default_profile.png" class="img-circle">  
                            							<?php } ?>
                            					</div>
                          					</div> 
                         					<small class="text-muted m-b">
						  					<?php echo $get_user_id_details[0]['user_first_name'].' '. $get_user_id_details[$i]['user_last_name']; ?>
											</small>
                        				</div>                      
                      				</div>
                    			</div>

					  			<footer class="panel-footer bg-info text-center">
						  			<div class="row pull-out">
										<div class="col-xs-6">
							  				<div class="padder-v">
												<span class="m-b-xs h5 block text-white">Email </span>
												<small class="text-muted">	<?php echo $get_user_id_details[0]['user_email_id']; ?></small>
							  				</div>
										</div>
										<div class="col-xs-6 dk">
							  				<div class="padder-v">
												<span class="m-b-xs h5 block text-white">Phone Number </span>
												<small class="text-muted"><?php echo $get_user_id_details[0]['user_mobile_no']; ?></small>
							  				</div>
										</div> 
						  			</div>
								</footer>
					  		</section><!--panel panel-default-->
					  
					  
					   		<section class="panel panel-default"> 
							    <header class="panel-heading bg-success lt no-border">
								  <div class="clearfix"> 
									<div class="clear"> 
									  <small class="text-muted">
										User Personal Details
									</small>
									</div>                
								  </div>
								</header>
						
                        		<ul class="list-group no-radius">
									<li class="list-group-item">
										<?php if($get_user_id_details[0]['user_gender']){?>
										<span class="pull-right"> <?php echo $get_user_id_details[0]['user_gender'];?></span>
										<?php } else{ ?>
										<span class="pull-right" style="color:red">Not Avialable</span></span>
										<?php } ?>
										<span class="label bg-primary"><i class="fa fa-user"></i></span>
										Gendar
		                            </li> 
						  
							
							
									<li class="list-group-item">
										<?php if($get_user_id_details[0]['user_registration_date']){?>
										<span class="pull-right"> <?php echo $get_user_id_details[0]['user_registration_date'];?></span>
										<?php } else{ ?>
										<span class="pull-right" style="color:red">Not Avialable</span></span>
										<?php } ?>
										<span class="label bg-primary"><i class="fa fa-calendar"></i></span>
										Registred Date
		                            </li> 
							
							
							   
								  	<li class="list-group-item">
									    <?php if($get_user_id_details[0]['user_zip_code']){?>
			                            <span class="pull-right"> <?php echo $get_user_id_details[0]['user_zip_code'];?></span>
										<?php } else{ ?>
										<span class="pull-right" style="color:red">Not Avialable</span></span>
										<?php } ?>
			                            <span class="label bg-primary"><i class="fa fa-rupee"></i></span>
										Pincode
									</li> 
						  
						  
								   	<li class="list-group-item">
									    <?php if($get_user_id_details[0]['user_city']){?>
			                            <span class="pull-right"> <?php echo $get_user_id_details[0]['user_city'];?></span>
										<?php } else{ ?>
										<span class="pull-right" style="color:red">Not Avialable</span></span>
										<?php } ?>
			                            <span class="label bg-primary"><i class="fa fa-building-o"></i></span>
										 City
		                          	</li> 
								  
						    
						  
                        		</ul> 
                      		</section><!--panel panel-default-->
					  
					  
					</div><!--col-lg-10-->
					</div> <!--row-->
                  <!--</div>
                </div> 
              </div>  -->
            </section> <!--scrollable wrapper--->
			
			
			
			
			
			<!--
					</div>   
               </section>-->
            </section>
          </section> 
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