<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 
/* Get order List*/
$get_all_success_order_list	=	$admin_controller->all_success_order_list();  

//print_r($get_all_success_order_list);
//die();
?>
<style>
tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
.dataTables_wrapper input{
	width:100px;
}    
</style>     
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Sales List</li>
              </ul> <?php 
              //echo $_SESSION['ad_name'];
              //echo $_SESSION['ad_email_id']; ?>
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-shopping-cart text-default"></i>Sales List</a></li>   
					  </ul> 
                    </header>  
					<div class="panel-body">
					  <div class="tab-content">          
						<div class="tab-pane fade active in" id="main-category-list"> 
							<section class="panel panel-default"> 
								<div class="table-responsive">
								 <table class="table table-striped m-b-none display" id="sales_table">
									<thead>
									  <tr>
										<th width="20%">Sl.No</th>
										<th width="20%">User Name</th>
										<th width="20%">Mobile</th>
										<th width="20%">Store Name</th>
										<th width="20%">Store Owner Name</th>
										<th width="20%">Area</th>
										<th width="25%">State</th> 
										<th width="20%">Grand Total</th> 
										<th width="20%">Payment Status</th> 
									  </tr>
									</thead>
									<tfoot>
						            <tr>
						            	<th></th>
						                <th>User Name</th>
						                <th>Mobile</th>
						                <th>Store Name</th>
						                <th>Store owner</th>
						                <th>Area</th>
						                <th>State</th>
						                <th>Grand Total</th>
						                <th>Payment Status</th> 
										
						            </tr>
						        </tfoot>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($get_all_success_order_list);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><?php echo $get_all_success_order_list[$i]['user_first_name'].' '.$get_all_success_order_list[$i]['user_last_name']; ?></td>  
											<td><?php echo $get_all_success_order_list[$i]['user_mobile_no']; ?></td>
											<td><?php echo $get_all_success_order_list[$i]['b_store_name']; ?></td>
											<td><?php echo $get_all_success_order_list[$i]['b_store_owner_name']; ?></td>  
											<td><?php echo $get_all_success_order_list[$i]['user_area']; ?></td>  
											<td><?php echo $get_all_success_order_list[$i]['user_state']; ?></td>  
											<td><?php echo $get_all_success_order_list[$i]['order_grand_total']; ?></td> 
											<td><?php echo $get_all_success_order_list[$i]['order_payment_status']; ?></td>
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
 <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> 
 <script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#sales_table tfoot th').each( function () {
        var title = $(this).text();
       
        if(title){
         	$(this).html( '<input type="text" placeholder="'+title+'" />' );
        }
    } );
 
    // DataTable
    var table = $('#sales_table').DataTable();
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
        	//if(this.value){
	            if ( that.search() !== this.value ) {
	                that
	                    .search( this.value )
	                    .draw();
	            }
	        //}
        } );
    } );
} );
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
