<?php
session_start(); 
if(isset($_SESSION['b_store_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 



/* Get get_slider_img_list List*/
$get_slider_img_list	=	$vendor_controller->get_slider_img_list($_SESSION['b_store_id']);  
// echo'<pre>';print_r($get_slider_img_list);exit;



   //Add Ticket
if(isset($_POST['submit']))
{	
	$add_tickets	=	$vendor_controller->add_slider_img(); 
	if(!empty($add_tickets)){
		echo '<script>alert("Slider added successfully.")</script>';
		echo '<script>window.location.assign("slider-img.php")</script>';
	} 
}





//Deactive
if(isset($_POST['deactive']))
{	
	$deactive_slider_img	=	$vendor_controller->deactive_slider_img();
	// print_r($update_main_category);exit;
	if(!empty($deactive_slider_img)){
		echo '<script>alert("Slider image deactivated successfully.")</script>';
		echo '<script>window.location.assign("slider-img.php")</script>';
	}
}



//Active
if(isset($_POST['activate']))
{	
	$activate_slider_img	=	$vendor_controller->activate_slider_img();
	// print_r($update_main_category);exit;
	if(!empty($activate_slider_img)){
		echo '<script>alert("Slider image activated successfully.")</script>';
		echo '<script>window.location.assign("slider-img.php")</script>';
	} 
}

 


?>
      
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Slider Images</li>
              </ul> 
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-picture-o text-default"></i> Slider Images List</a></li>  
						<li><a href="#main-category-list2" data-toggle="tab"><i class="fa fa-edit text-default"></i> Add Slider Image</a></li>  
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
										<th width="20%">Action</th> 
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($get_slider_img_list);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><img src="../../admin/admin-views/images/store_slider_img/<?php echo $get_slider_img_list[$i]['bsslider_img'];?>" class="img-circle" style="height:100px"> </td>
											<td><?php echo $get_slider_img_list[$i]['bsslider_c_date']; ?></td> 
										 
											 <?php if($get_slider_img_list[$i]['bsslider_c_status']==1){?>
											<td>
												<form id="form" method="POST">
													<input type="hidden" class="form-control" value="<?php echo $get_slider_img_list[$i]['bsslider_id']?>" name="id" required>	
													<button type="submit" name="deactive" class="btn btn-danger btn-s-xs" onclick="return confirm('Are you sure you want to deactivate this image?');" ><i class="fa fa-ban"></i> Deactivate</button>  
												</form>
											</td>
										 
											<?php }else{ ?>
											<td>
												<form id="form" method="POST">
													<input type="hidden" class="form-control" value="<?php echo $get_slider_img_list[$i]['bsslider_id']?>" name="id" required>	
													<button type="submit" name="activate" class="btn btn-success btn-s-xs" onclick="return confirm('Are you sure you want to activate this image?');" ><i class="fa fa-check"></i> Activate</button>   
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
									   <input type="hidden"  class="form-control" name="store_tax_store_ref_id" value="<?php echo $_SESSION['b_store_id'];?>"  data-required="true"   required>
										<div class="form-group">
										  <label>Ticket Slider Image</label><br/>
										  <input type="file" class="filestyle" name="b_store_slider_image" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" data-required="true"  accept="image/x-png, image/gif, image/jpeg" onchange="validate_image(this);" data-required="true" >                    
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
