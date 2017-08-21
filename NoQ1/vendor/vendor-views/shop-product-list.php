<?php
session_start(); 
if(isset($_SESSION['b_store_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 



/* Get product List*/
$get_business_store_product_list	=	$vendor_controller->get_business_store_product_list($_SESSION['b_store_id']);  
// echo'<pre>';print_r($get_business_store_product_list);exit;



   //Add prodcut
if(isset($_POST['submit']))
{	
	$add_store_product	=	$vendor_controller->add_store_product(); 
	if(!empty($add_store_product)){
		echo '<script>alert("Product added successfully.")</script>';
		echo '<script>window.location.assign("shop-product-list.php")</script>';
	} 
}



if(isset($_POST['pupload'])){
	$add_upload_product	=	$vendor_controller->add_upload_product($_SESSION['b_store_id']); 
	if(!empty($add_upload_product)){
		echo '<script>alert("Product added successfully.")</script>';
		//echo '<script>window.location.assign("shop-product-list.php")</script>';
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
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-shopping-cart text-default"></i> Product List</a></li>  
						<li><a href="#main-category-list2" data-toggle="tab"><i class="fa fa-edit text-default"></i> Add Product</a></li>
						<li><a href="#main-category-list3" data-toggle="tab"><i class="fa fa-edit text-default"></i>Product upload</a></li>  
											
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
										<th width="20%">Brand Name</th>
										<th width="25%">MRP</th>
										<th width="25%">Discount Amt</th> 
										<th width="15%">Discount Price</th>
										<th width="15%">Description</th> 
										<th width="15%">Short Desc</th> 
										<th width="25%">Barcode No</th>  
										<th width="25%">SKU's</th>  
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($get_business_store_product_list);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><?php echo $get_business_store_product_list[$i]['p_product_title']; ?></td>
											<td><?php echo $get_business_store_product_list[$i]['p_brand_id']; ?></td>
											<td><?php echo $get_business_store_product_list[$i]['p_MRP']; ?></td>
											<td><?php echo $get_business_store_product_list[$i]['p_discount_percentage']; ?></td>
											<td><?php echo $get_business_store_product_list[$i]['p_discount_price']; ?></td>
											<td><?php echo substr($get_business_store_product_list[$i]['p_product_description'],0,100); ?></td>
											<td><?php echo substr($get_business_store_product_list[$i]['p_short_description'],0,100); ?></td> 
											<td><?php echo $get_business_store_product_list[$i]['p_product_barcode_no']; ?></td>
											<td><?php echo $get_business_store_product_list[$i]['p_SKU']; ?></td>
										 
											 
											  
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
										  <label>Product Name</label>  
										  <input type="hidden"  class="form-control" name="p_b_store_id" value="<?php echo $_SESSION['b_store_id'];?>"  data-required="true"   required>
										  <input type="text"  class="form-control" name="p_product_title" data-required="true" placeholder="Enter Product Name" required>
										</div>
										 
										 
										<div class="form-group">
										  <label>Product Brand Name</label>
										  <input   type="text" class="form-control" name="p_brand_id" data-required="true"  placeholder="Enter Product Brand Name" required>
										</div>
										
									   
										<div class="form-group">
										  <label>Product MRP</label>
										  <input   type="text" class="form-control" name="p_MRP" id="p_MRP" data-required="true"  placeholder="Enter Product MRP" required>
										</div>
										
										
										<div class="form-group">
										  <label>Product Discount</label>
										  <input   type="text" class="form-control" name="p_discount" id="p_discount" value="0" data-required="true"  placeholder="Enter Product Discount" required>
										</div>
										
										
										
										<div class="form-group">
										  <label>Product Discount Price</label>
										  <input   type="text" class="form-control" name="p_discount_price" id="p_discount_price" value="0" data-required="true"  placeholder="Enter Product Discount Price" readonly required>
										</div>
										
										
										<div class="form-group">
										  <label>Product Description</label>
										  <textarea class="form-control" name="p_product_description" placeholder="Enter Product Address" required> </textarea> 
										</div>  
										
										
										<div class="form-group">
										  <label>Product Short Description</label>
										  <textarea class="form-control" name="p_short_description" data-required="true" placeholder="Enter Product Short Description" required> </textarea>
										</div>
										
										
										  
										 <div class="form-group">
										  <label>Product Barcode No</label>
										  <textarea class="form-control" name="p_product_barcode_no" placeholder="Enter Product Barcode No" required></textarea>                      
										</div>
										 
										<div class="form-group">
										  <label>Product SKU's</label>
										  <input type="text" class="form-control" name="p_SKU" data-required="true" placeholder="Enter Product  SKU's" required>                        
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
						
						<div class="tab-pane fade in" id="main-category-list3"> 
							<section class="panel panel-default"> 
								<div class="panel-body">
									<div class="row">
										<form role="form" method="POST" action="" enctype="multipart/form-data">
											Product Upload:
											<input type="file" name="file_name" id="product_upload" value="">
											<input type="submit" value="Upload" id="pupload" name="pupload" >
										</form>
									</div>
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
 
	// $("#p_MRP").change(function() {
		// $("#p_discount_price").val($(this).val());
	// });
	$(document).ready(function(){
		/* $("#p_MRP").change(function() {
			$("#p_discount_price").val($(this).val());
		});
		*/
		$("#p_discount").change(function() {
			var p_MRP				=	$("#p_MRP").val();
			var p_discount			=	$("#p_discount").val();
			var p_discount_price	=	p_MRP	-	p_discount;
			// alert(p_discount_price);
			$("#p_discount_price").val(p_discount_price);
		 });												
 
	});
</script>
<?php } ?>