<?php
session_start(); 
if(isset($_SESSION['b_store_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 



/* Get Ticket List*/
$get_tickets_list	=	$vendor_controller->get_tickets_list($_SESSION['b_store_id']);  
// echo'<pre>';print_r($get_tickets_list);exit;

 

//Deactive
if(isset($_POST['deactive']))
{	
	$deactive_business_store	=	$vendor_controller->deactive_ticket();
	// print_r($update_main_category);exit;
	if(!empty($deactive_business_store)){
		echo '<script>alert("Ticket type deactivated successfully.")</script>';
		echo '<script>window.location.assign("ticket-list.php")</script>';
	}
}


//Add ticket
if(isset($_POST['submit']))
{	
	$deactive_business_store	=	$vendor_controller->add_tickets();
	// print_r($update_main_category);exit;
	if(!empty($deactive_business_store)){
		echo '<script>alert("Ticket added successfully.")</script>';
		echo '<script>window.location.assign("ticket-list.php")</script>';
	}
}


//Active
if(isset($_POST['activate']))
{	
	$activate_business_store	=	$vendor_controller->activate_ticket();
	// print_r($update_main_category);exit;
	if(!empty($activate_business_store)){
		echo '<script>alert("Ticket type activated successfully.")</script>';
		echo '<script>window.location.assign("ticket-list.php")</script>';
	} 
}

 
 
?>
      
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Ticket List</li>
              </ul> 
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-shopping-cart text-default"></i> Ticket List</a></li>  
						<li><a href="#main-category-list2" data-toggle="tab"><i class="fa fa-edit text-default"></i> Add Ticket</a></li>  
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
										<th width="20%">Ticket Title</th>
										<th width="20%">Ticket Price</th>
										<th width="15%">Description</th> 
										<th width="25%">SKU's</th>   
										<th width="25%">Action</th>   
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($get_tickets_list);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><?php echo $get_tickets_list[$i]['st_ticket_title']; ?></td>
											<td><?php echo $get_tickets_list[$i]['st_ticket_price']; ?></td>
											<td><?php echo $get_tickets_list[$i]['st_short_description']; ?></td>
											<td><?php echo $get_tickets_list[$i]['st_ticket_sku']; ?></td> 
										 
											 
											<?php if($get_tickets_list[$i]['st_status']==1){?>
											<td>
												<form id="form" method="POST">
													<input type="hidden" class="form-control" value="<?php echo $get_tickets_list[$i]['st_id']?>" name="id" required>	
													<button type="submit" name="deactive" class="btn btn-danger btn-s-xs" onclick="return confirm('Are you sure you want to deactivate this Store?');" ><i class="fa fa-ban"></i> Deactivate</button>  
												</form>
											</td> 
											<?php }else{ ?>
											<td>
												<form id="form" method="POST">
													<input type="hidden" class="form-control" value="<?php echo $get_tickets_list[$i]['st_id']?>" name="id" required>	
													<button type="submit" name="activate" class="btn btn-success btn-s-xs" onclick="return confirm('Are you sure you want to activate this Store?');" ><i class="fa fa-check"></i> Activate</button>   
												</form>
											</td><?php } ?> 
											  
										</tr>
									<?php $j++; } ?>
									</tbody>
								  </table>
								</div>
							  </section>
						</div>  
						
						
						
						
						<div class="tab-pane fade in" id="main-category-list2"> 
							<section class="panel panel-default"> 
							<div class="panel-body">
							  <div class="row">
							  <form role="form" method="POST" enctype="multipart/form-data" data-validate="parsley">
								<div class="col-sm-6">
									<div class="panel-body">   
										 <div class="form-group">
										  <label>Ticket Title</label>  
										  <input type="hidden"  class="form-control" name="st_store_ref_id" value="<?php echo $_SESSION['b_store_id'];?>"  data-required="true"   required>
										  <input type="text"  class="form-control" name="st_ticket_title" data-required="true" placeholder="Enter Ticket Title" required>
										</div>
										 
										 
										<div class="form-group">
										  <label>Ticket Price</label>
										  <input   type="text" class="form-control" name="st_ticket_price" data-required="true"  placeholder="Enter Ticket Price" required>
										</div>
									 
										<div class="form-group">
										  <label>Ticket  Description</label>
										  <textarea class="form-control" name="st_short_description" data-required="true" placeholder="Enter Ticket Short Description" required> </textarea>
										</div> 
										
										
										<div class="form-group">
										  <label>Ticket SKU's</label>
										  <input type="text" class="form-control" name="st_ticket_sku" data-required="true" placeholder="Enter Ticket  SKU's" required>                        
										</div>
										  <div class="form-group">
										  <div>
											<button type="submit" name="submit" class="btn btn-primary">Add</button>
										  </div>
										</div>
									</div> 
								</div>
								
							
								 
								</div> 
							</form>
						  </div> 
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
