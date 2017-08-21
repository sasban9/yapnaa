<?php
session_start(); 
if(isset($_SESSION['b_store_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 



/* Get Ticket List*/
$get_service_tax_list	=	$vendor_controller->get_service_tax_list($_SESSION['b_store_id']);  
// echo'<pre>';print_r($get_service_tax_list);exit;



   //Add Ticket
if(isset($_POST['submit']))
{	
	$add_store_service_tax	=	$vendor_controller->add_store_service_tax(); 
	if(!empty($add_store_service_tax)){
		echo '<script>alert("Service tax added successfully.")</script>';
		echo '<script>window.location.assign("service-tax.php")</script>';
	} 
}



?>
      
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Service Tax</li>
              </ul> 
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-shopping-cart text-default"></i> Service Tax List</a></li>  
						<li><a href="#main-category-list2" data-toggle="tab"><i class="fa fa-edit text-default"></i> Add Service Tax</a></li>  
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
										<th width="20%">Serice Tax Title</th>
										<th width="20%">Serice Tax in % </th>
										<th width="15%">Description</th>  
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($get_service_tax_list);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><?php echo $get_service_tax_list[$i]['store_tax_title']; ?></td>
											<td><?php echo $get_service_tax_list[$i]['store_tax_percenatage']; ?></td>
											<td><?php echo $get_service_tax_list[$i]['store_tax_description']; ?></td> 
										 
											 
											  
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
										  <label>Service Tax Title</label>  
										  <input type="hidden"  class="form-control" name="store_tax_store_ref_id" value="<?php echo $_SESSION['b_store_id'];?>"  data-required="true"   required>
										  <input type="text"  class="form-control" name="store_tax_title" data-required="true" placeholder="Enter Service Tax Title" required>
										</div>
										 
										 
										<div class="form-group">
										  <label>Service Tax in %</label>
										  <input   type="text" class="form-control" name="store_tax_percenatage" data-required="true"  placeholder="Enter Service Tax In Percetage (%)" required>
										</div>
									 
										<div class="form-group">
										  <label>Service Tax  Description</label>
										  <textarea class="form-control" name="store_tax_description" data-required="true" placeholder="Enter Service Tax Description" required> </textarea>
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
