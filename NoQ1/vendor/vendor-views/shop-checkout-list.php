<?php
session_start(); 
if(isset($_SESSION['b_store_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 



/* Get product List*/
$get_business_store_checkout_users_list	=	$vendor_controller->get_business_store_checkout_users_list($_SESSION['b_store_id']);  
// echo'<pre>';print_r($get_business_store_checkout_users_list);exit;



   //Add prodcut
if(isset($_POST['submit']))
{	
	$add_store_product	=	$vendor_controller->add_store_checkout_user(); 
	if(!empty($add_store_product)){
		echo '<script>alert("User added successfully.")</script>';
		echo '<script>window.location.assign("shop-checkout-list.php")</script>';
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
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-shopping-cart text-default"></i> Checkout User List</a></li>  
						<li><a href="#main-category-list2" data-toggle="tab"><i class="fa fa-edit text-default"></i> Add Checkout Users</a></li>  
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
										<th width="20%">Name</th>
										<th width="20%">Mobile</th>
										<th width="25%">Email</th>
										<th width="25%">Status</th> 
										<!--th width="15%">Action</th-->
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($get_business_store_checkout_users_list);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><?php echo $get_business_store_checkout_users_list[$i]['cu_user_name']; ?></td>
											<td><?php echo $get_business_store_checkout_users_list[$i]['cu_user_mobile']; ?></td>
											<td><?php echo $get_business_store_checkout_users_list[$i]['cu_user_email']; ?></td>
											<td><?php echo $get_business_store_checkout_users_list[$i]['cu_user_status'] ? "Active" : "Inactive" ; ?></td>
										 
											 
											  
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
										  <label>Security Name</label>  
										  <input type="hidden"  class="form-control" name="cu_store_id" value="<?php echo $_SESSION['b_store_id'];?>"  data-required="true"   required>
										  <input type="text"  class="form-control" name="cu_security_name" data-required="true" placeholder="Enter Security Name" required>
										</div>
										 
										 
										<div class="form-group">
										  <label>Mobile Number</label>
										  <input  maxlength="10" pattern="\d*" type="text" class="form-control" name="cu_mobile" data-required="true"  placeholder="Enter Mobile Number" required>
										</div>
										
									   
										<div class="form-group">
										  <label>Email ID</label>
										  <input   type="email" class="form-control" name="cu_email" id="cu_email" data-required="true"  placeholder="Enter Email ID" >
										</div>
										
										<div class="form-group">
										  <label>Password</label>
										  <input type="password" class="form-control" name="cu_passowrd" data-required="true" placeholder="Enter Password" required>                        
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
 <script>
 $("#p_MRP").change(function() {
	$("#p_discount_price").val($(this).val());
 });
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
