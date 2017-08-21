<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 


 
/* Get Ticket List*/
$ticket_order_list	=	$admin_controller->get_tickets_list_admin();  
// echo'<pre>';print_r($get_tickets_list);exit;

 
 
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
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-tag text-default"></i> Ticket Order List</a></li>   
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
										<th width="15%">Sl.No</th>
										<th width="20%">User Name</th>
										<th width="25%">User Mobile No</th>  
										<th width="25%">Store Name</th>  
										<th width="20%">Total</th>
										<th width="25%">Tax</th>
										<th width="25%">Grand Total</th> 
										<th width="20%">Types</th> 
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($ticket_order_list);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><?php echo $ticket_order_list[$i]['user_first_name']." ".$ticket_order_list[$i]['user_last_name']; ?></td>  
											<td><?php echo $ticket_order_list[$i]['user_mobile_no']; ?></td>
											<td><a href="shop-list-details.php?storeid=<?php echo $get_business_store_list[$i]['b_store_id'];?>" target="_blank" style="color:green"><?php echo $ticket_order_list[$i]['b_store_name']; ?></a></td>
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
