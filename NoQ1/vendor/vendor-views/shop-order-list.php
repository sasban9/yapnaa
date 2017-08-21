<?php
session_start(); 
if(isset($_SESSION['b_store_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 



/* Get product List*/
$user_cart_details_admin	=	$vendor_controller->user_cart_details_admin($_SESSION['b_store_id']);  
// echo'<pre>';print_r($user_cart_details_admin);exit;






/* Get order List*/
$get_order_list_by_store_id	=	$vendor_controller->get_order_list_by_store_id($_SESSION['b_store_id']);  
// echo'<pre>';print_r($get_order_list_by_store_id);exit;




   //Add prodcut
if(isset($_POST['submit']))
{	
	$add_store_product	=	$vendor_controller->add_store_product(); 
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
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-shopping-cart text-default"></i> Order List</a></li>   
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
										<th width="20%">User Name</th>
										<th width="20%">Mobile No</th>
										<th width="25%">Oder Id</th>  
										<th width="20%">Trcking No</th>
										<th width="20%">No's Items</th> 
										<th width="20%">Grand Total</th> 
										<th width="20%">Payment Status</th> 
										<th width="20%">Details</th> 
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($get_order_list_by_store_id);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><?php echo $get_order_list_by_store_id[$i]['user_first_name'].' '.$get_order_list_by_store_id[$i]['user_last_name']; ?></td>  
											<td><?php echo $get_order_list_by_store_id[$i]['user_mobile_no']; ?></td>  
											<td><?php echo $get_order_list_by_store_id[$i]['order_id']; ?></td>  
											<td><?php echo $get_order_list_by_store_id[$i]['order_tracking_number']; ?></td>
											<td><?php echo $get_order_list_by_store_id[$i]['order_no_of_items']; ?></td>
											<td><?php echo $get_order_list_by_store_id[$i]['order_grand_total']; ?></td> 
											<td><?php echo $get_order_list_by_store_id[$i]['order_payment_status']; ?></td> 
											<td><a href="shop-order-list-details.php?order_id=<?php echo $get_order_list_by_store_id[$i]['order_id']; ?>" target="_blank">View Details</td> 
										 
											 
											  
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
