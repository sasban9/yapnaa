<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 



/* Get product List*/
$get_coupons_list	=	$admin_controller->get_coupons_list();  
 //echo'<pre>';print_r($get_coupons_list);exit;
if(isset($_POST['submit']))
{	
	$add_coupons	=	$admin_controller->add_coupons(); 
	//echo'<pre>';print_r($add_coupons);exit;
	if(!empty($add_coupons) and $add_coupons!="em"){
		echo '<script>alert("Coupon added successfully.")</script>';
		echo '<script>window.location.assign("coupons_list.php")</script>';
	}else if($add_coupons == "em"){
		echo '<script>alert("Coupon code already exists.")</script>';
		echo '<script>window.location.assign("coupons_list.php")</script>';
	} 
}


?>
      
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Coupons List</li>
              </ul> 
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-shopping-cart text-default"></i> Coupons List</a></li>  
						<li><a href="#main-category-list2" data-toggle="tab"><i class="fa fa-edit text-default"></i> Add Coupons</a></li>  
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
										<th width="20%">Coupon Code</th>
										<th width="20%">Coupon Type</th>
										<th width="25%">Coupon Amount</th>
										<th width="25%">Coupon Min Purchase Amount</th> 
										<!--th width="15%">Action</th-->
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($get_coupons_list);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><?php echo $get_coupons_list[$i]['coup_code']; ?></td>
											<?php if($get_coupons_list[$i]['coup_type']==1) {
											 	echo '<td>Percentage</td>';
											}else{
												echo '<td>Fixed</td>';
											} ?>
											<?php 
											if($get_coupons_list[$i]['coup_type']==1) {?>
										     	<td><?php echo $get_coupons_list[$i]['coup_amount'].'%'; ?></td>
										    <?php }else{ ?>
										    	<td><?php echo $get_coupons_list[$i]['coup_amount']; ?></td>
											<?php } ?>
											<td><?php echo $get_coupons_list[$i]['coup_pur_amt'];?></td>
										 
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
										  <label>Copon Code</label>  
										  <input type="text"  class="form-control" name="coup_code" data-required="true" placeholder="Enter Coupon Code" required>
										</div>
										 

										<div class="form-group">
										  	<label>Coupon Type</label>

										  		<div class="radio">
										  			<label> Percentage  <input  type="radio" name="coup_type" data-required="true" checked="checked" placeholder="Enter Coupon Type" value="1" required>
										        	</label>
										        </div>
										        <div class="radio">		
										        	<label> Fixed  <input  type="radio"  name="coup_type" data-required="true"  placeholder="Enter Coupon Type" value="2" required>
										        	</label>
										        </div>
										 
										</div>
										 
										<div class="form-group">
										  <label>Coupon Amount</label>  
										  <input type="text"  class="form-control" name="coup_amount" data-required="true" placeholder="Enter Coupon Code" required>
										</div>

										<div class="form-group">
										  <label>Minimum Purchase Amount</label>  
										  <input type="text"  class="form-control" name="coup_min_pur_amt" data-required="true" placeholder="Enter Coupon Code" required>
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
