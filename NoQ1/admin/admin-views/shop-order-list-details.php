<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 


$order_id	=	$_REQUEST['order_id']; 




/* Get order List*/
$get_order_list_by_store_id	=	$admin_controller->get_order_list_details_by_id($order_id);  
//echo'<pre>';print_r($get_order_list_by_store_id);exit;




   //Add prodcut
if(isset($_POST['submit']))
{	
	$add_store_product	=	$admin_controller->add_store_product(); 
	if(!empty($add_store_product)){
		echo '<script>alert("Product added successfully.")</script>';
		echo '<script>window.location.assign("shop-product-list.php")</script>';
	} 
}



?>
      
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Shop List</li>
              </ul> 
			  
				<section class="scrollable wrapper">              
              <div class="row">
				 <div class="col-lg-6">
                  <section class="panel panel-default"> 
					<div class="panel-body">
                      <div class="clearfix text-center m-t">
                        <div class="inline">
                          <div class="easypiechart" data-percent="100" data-line-width="5" data-bar-color="#4cc0c1" data-track-Color="#f5f5f5" data-scale-Color="false" data-size="130" data-line-cap='butt' data-animate="1000">
                            <div class="thumb-lg"> 
								<img src="images/default_profile.png" class="img-circle">  
                            </div>
                          </div> 
                          <small class="text-muted m-b">
						  <?php echo $get_order_list_by_store_id[0]['user_first_name'].' '. $get_order_list_by_store_id[$i]['user_last_name']; ?>
						</small>
                        </div>                      
                      </div>
                    </div>
					  <footer class="panel-footer bg-info text-center">
						  <div class="row pull-out">
							<div class="col-xs-6">
							  <div class="padder-v">
								<span class="m-b-xs h5 block text-white">Email </span>
								<small class="text-muted">	<?php echo $get_order_list_by_store_id[0]['user_email_id']; ?></small>
							  </div>
							</div>
							<div class="col-xs-6 dk">
							  <div class="padder-v">
								<span class="m-b-xs h5 block text-white">Phone Number </span>
								<small class="text-muted"><?php echo $get_order_list_by_store_id[0]['user_mobile_no']; ?></small>
							  </div>
							</div> 
						  </div>
						</footer>
					  </section>
					  
					  
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
								<?php if($get_order_list_by_store_id[0]['user_gender']){?>
								<span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['user_gender'];?></span>
								<?php } else{ ?>
								<span class="pull-right" style="color:red">Not Avialable</span></span>
								<?php } ?>
								<span class="label bg-primary"><i class="fa fa-user"></i></span>
								Gendar
                            </li> 
						  
							
							
							<li class="list-group-item">
								<?php if($get_order_list_by_store_id[0]['user_registration_date']){?>
								<span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['user_registration_date'];?></span>
								<?php } else{ ?>
								<span class="pull-right" style="color:red">Not Avialable</span></span>
								<?php } ?>
								<span class="label bg-primary"><i class="fa fa-calendar"></i></span>
								Registred Date
                            </li> 
							
							
							   
						  <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['user_zip_code']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['user_zip_code'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-rupee"></i></span>
							Pincode
							</li> 
						  
						  
						   <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['user_city']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['user_city'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-building-o"></i></span>
							 City
                          </li> 
						  
						    
						  
                        </ul> 
                      </section>
					  
					  
					</div>
					
					
					
					
					
					
					
					
                    <div class="col-sm-6">                  
                      <section class="panel panel-default"> 
					    <header class="panel-heading bg-success lt no-border">
						  <div class="clearfix"> 
							<div class="clear"> 
							  <small class="text-muted">
								Order Details
							</small>
							</div>                
						  </div>
						</header>
						
                        <ul class="list-group no-radius">
							<li class="list-group-item">
								<?php if($get_order_list_by_store_id[0]['order_id']){?>
								<span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_id'];?></span>
								<?php } else{ ?>
								<span class="pull-right" style="color:red">Not Avialable</span></span>
								<?php } ?>
								<span class="label bg-primary"><i class="fa fa-tag"></i></span>
								Order Id
                            </li> 
						  
							
							
							<li class="list-group-item">
								<?php if($get_order_list_by_store_id[0]['order_tracking_number']){?>
								<span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_tracking_number'];?></span>
								<?php } else{ ?>
								<span class="pull-right" style="color:red">Not Avialable</span></span>
								<?php } ?>
								<span class="label bg-primary"><i class="fa fa-tag"></i></span>
								Order Tracking No
                            </li> 
							
							
							   
						  <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['order_service_tax_amt']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_service_tax_amt'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-rupee"></i></span>
							   Service Tax Amount
                          </li> 
						  
						  
						   <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['order_grand_total']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_grand_total'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-rupee"></i></span>
							  Grand Total
                          </li> 
						  
						   
						   <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['order_payment_status']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_payment_status'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-rupee"></i></span>
							  Payment Status
                          </li> 
						  
						  
						  
						  
						  <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['order_created_date']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_created_date'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
							  Order created Date
                          </li> 
						  
						  
						  <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['order_no_of_items']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_no_of_items'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
							 No Of Items 
                          </li> 
						  
						  
						  
						  
						   <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['order_transaction_id']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_transaction_id'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-tag"></i></span>
							Transcation Id
                          </li> 
						  
						  
						  
						  
						  
						    
						  
						   <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['order_transaction_date']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_transaction_date'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-calendar"></i></span>
							Transcation Date
                          </li> 
						  
						  
						  
						  
						  
						   <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['order_transaction_response']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_transaction_response'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-tag"></i></span>
							Transcation Response
                          </li> 
						  
						  
						  
						   <li class="list-group-item">
						    <?php if($get_order_list_by_store_id[0]['order_transaction_type']){?>
                            <span class="pull-right"> <?php echo $get_order_list_by_store_id[0]['order_transaction_type'];?></span>
							<?php } else{ ?>
							<span class="pull-right" style="color:red">Not Avialable</span></span>
							<?php } ?>
                            <span class="label bg-primary"><i class="fa fa-tag"></i></span>
							Transcation Type
                          </li> 
						  
						  
                        </ul> 
                      </section>
                    </div>
					
					
					
					 
					
					  
						  
						 </div> 
                  </div>
                </div> 
              </div>  
            </section> 
			
			
			
			
			
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-shopping-cart text-default"></i> Order Item List</a></li>   
					  </ul> 
                    </header>  
					<div class="panel-body">
					  <div class="tab-content">          
						<div class="tab-pane fade active in" id="main-category-list"> 
							<section class="panel panel-default"> 
								<div class="table-responsive">
								 <table class="table table-striped m-b-none" id="mc_table">
									<thead>
									  <tr>
										<th width="20%">Sl.No</th>
										<th width="20%">Product Title</th>
										<th width="20%">No Of Qty</th>
										<th width="25%">Item Per Price</th>  
										<th width="25%">Discount Amt</th>  
										<th width="25%">Total Discount</th>  
										<th width="20%">Grand Total</th> 
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($get_order_list_by_store_id);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td>   
											<td><?php echo $get_order_list_by_store_id[$i]['p_product_title']; ?></td>  
											<td><?php echo $get_order_list_by_store_id[$i]['item_order_item_qty']; ?></td>  
											<td><?php echo $get_order_list_by_store_id[$i]['item_order_item_per_price']; ?></td>
											<td><?php echo $get_order_list_by_store_id[$i]['item_order_discount_per_item']; ?></td>
											<td><?php echo $get_order_list_by_store_id[$i]['item_order_discount_amt']; ?></td>
											<td><?php echo $get_order_list_by_store_id[$i]['item_order_total_amt']; ?></td>  
										 
											 
											  
										</tr>
									<?php $j++; } ?>
									</tbody>
								  </table>
								</div>
							  </section>
						</div>  
						
						
						
						 
					  </section>
					</div>   
               </section>
            </section>
          </section> 
        </section> 
      </section>
    </section>
  </section>

<?php include "footer.php";?>
 <script>
 $("#p_discount").change(function() {
	var p_MRP				=	$("#p_MRP").val();
	var p_discount			=	$("#p_discount").val();
	var p_discount_price	=	p_MRP	-	p_discount;
	// alert(p_discount_price);
	$("#p_discount_price").val(p_discount_price);
}); 
</script>
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
