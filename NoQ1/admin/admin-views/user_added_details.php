<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 

//$user_id	=	$_REQUEST['user_id']; 




/* Get order List*/
$get_users_daily_count	=	$admin_controller->get_users_curentday_count();  

$get_users_weekly_count	=	$admin_controller->get_users_weekly_count(); 
//echo'<pre>';print_r($get_user_id_details);exit;

$get_users_monthly_count	=	$admin_controller->get_users_monthly_count();
//echo'<pre>';print_r($get_user_id_details);exit;

$get_users_yearly_count	=	$admin_controller->get_users_yearly_count(); 
$get_users_last_yearly_count = $admin_controller->get_users_last_yearly_count(); 

?>
      
    <section id="content">
        <section class="vbox">          
            <section class="scrollable padder">
              	<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                	<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                	<li class="active">User added details</li>
              	</ul> 

				<section class="scrollable wrapper">              
              		<div class="row">
				 		<div class="col-lg-10">
                  			
					  
					  
					   		<section class="panel panel-default"> 
							    <header class="panel-heading bg-success lt no-border">
								  <div class="clearfix"> 
									<div class="clear"> 
									  <small class="text-muted">
										<b>User adding Details</b>
									</small>
									</div>                
								  </div>
								</header>
						
                        		<ul class="list-group no-radius">
									<li class="list-group-item">
										
										<span class="label bg-primary"> Daily Count</span>
										<span class="pull-right">
										<?php echo $get_users_daily_count; ?></span>
										
		                            </li> 
						  
							
							
									<li class="list-group-item">
										
										<span class="label bg-primary"> (Current) weekly Count</span>
										<span class="pull-right"><?php echo $get_users_weekly_count; ?></span>
										
		                            </li> 
							
							
							   
								  	<li class="list-group-item">
										
										<span class="label bg-primary">(Current) Monthly Count</span>
										<span class="pull-right"><?php echo $get_users_monthly_count; ?></span>
										
		                            </li> 

		                            <li class="list-group-item">
										
										<span class="label bg-primary">(Current) Yearly Count</span>
										<span class="pull-right"><?php echo $get_users_yearly_count; ?></span>
										
		                            </li>
		                             <li class="list-group-item">
										
										<span class="label bg-primary">Last Yearly Count</span>
										<span class="pull-right"><?php echo $get_users_last_yearly_count; ?></span>
										
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