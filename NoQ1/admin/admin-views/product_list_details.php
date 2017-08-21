<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 

$product_id	=	isset($_REQUEST['p_id']) ? $_REQUEST['p_id']:''; 

//echo $product_id;


/* Get order List*/
$get_all_product_sale_count	=	$admin_controller->get_all_product_sale_count($product_id);  
//$get_all_product_sale_store_count	=	$admin_controller->get_all_product_sale_store_count();  
//$get_all_product_current_day_count	=	$admin_controller->get_all_product_current_day_count(); 

//print_r($get_all_product_sale_count);
?>
      
    <section id="content">
        <section class="vbox">          
            <section class="scrollable padder">
              	<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                	<li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                	<li class="active">Project list details</li>
              	</ul> 

				<section class="scrollable wrapper">              
              		<div class="row">
				 		<div class="col-lg-10">
                  			
					  
					  
					   		<section class="panel panel-default"> 
							    <header class="panel-heading bg-success lt no-border">
								  <div class="clearfix"> 
									<div class="clear"> 
									  <small class="text-muted">
										<b>Product sale count Details</b>
									</small>
									</div>                
								  </div>
								</header>
						
                        		<ul class="list-group no-radius">
									<li class="list-group-item">
										
										<span class="label bg-primary">Total Sale count</span>
										<span class="pull-right">
										<?php if($get_all_product_sale_count['total_pcount']){ ?>
										<?php echo $get_all_product_sale_count['total_pcount']; ?></span>
										<?php }else{ ?>
										<?php echo 'Not sale'; ?>	
										<?php } ?>
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