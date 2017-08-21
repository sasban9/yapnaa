<?php
session_start(); 
if(isset($_SESSION['b_store_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 



/* Get ticket_order_list List*/
$ticket_order_list	=	$vendor_controller->ticket_order_list($_SESSION['b_store_id']);  
// echo'<pre>';print_r($ticket_order_list);exit;



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
                <li class="active">Ticket Order List</li>
              </ul> 
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-tag text-default"></i>Ticket Order List</a></li>   
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
										<th width="25%">User Mobile No</th>  
										<th width="20%">Total</th>
										<th width="25%">Tax</th>
										<th width="25%">Grand Total</th> 
										<th width="15%">Ticket Types</th> 
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($ticket_order_list);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><?php echo $ticket_order_list[$i]['user_first_name']." ".$ticket_order_list[$i]['user_last_name']; ?></td>  
											<td><?php echo $ticket_order_list[$i]['user_mobile_no']; ?></td>
											<td><?php echo $ticket_order_list[$i]['ticket_order_total']; ?></td>
											<td><?php echo $ticket_order_list[$i]['ticket_order_service_tax_amt']; ?></td>
											<td><?php echo $ticket_order_list[$i]['ticket_order_grand_total']; ?></td>
											<td><?php echo $ticket_order_list[$i]['ticket_order_no_items']; ?></td> 
										 
											 
											  
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
