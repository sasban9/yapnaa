<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 


/* Main Category form submission*/
if(isset($_POST['submit']))
{   
	$arr_main_category_output	=	$admin_controller->add_main_category();  
	if($arr_main_category_output==1){	 
		echo '<script>alert("Main category added successfully.")</script>';
		echo '<script>window.location.assign("main-category-list.php")</script>';
	}elseif($arr_main_category_output==2){
		echo '<script>alert("Main category already added.")</script>';
		echo '<script>window.location.assign("main-category-list.php")</script>';
	}else{
		echo '<script>alert("Something went wrong.")</script>';
		echo '<script>window.location.assign("main-category-list.php")</script>';
	}
}

 
	  
	/* Main Category list*/
	$arr_get_main_category_list	=	$admin_controller->get_main_category_list();  
	// echo'<pre>';print_r($arr_get_main_category_list);exit;



	//Deactive
	if(isset($_POST['deactive']))
	{	
		$deactive_main_category	=	$admin_controller->deactive_main_category();
		// print_r($update_main_category);exit;
		if(!empty($deactive_main_category)){
			echo '<script>alert("Main category deactivated successfully.")</script>';
			echo '<script>window.location.assign("main-category-list.php")</script>';
		}
	}



	//Active
	if(isset($_POST['activate']))
	{	
		$activate_main_category	=	$admin_controller->activate_main_category();
		// print_r($update_main_category);exit;
		if(!empty($activate_main_category)){
			echo '<script>alert("Main category activated successfully.")</script>';
			echo '<script>window.location.assign("main-category-list.php")</script>';
		} 
	}



	//delete
	if(isset($_POST['delete']))
	{	
		$delete_main_category	=	$admin_controller->delete_main_category();
		// print_r($update_main_category);exit;
		if(!empty($delete_main_category)){
			echo '<script>alert("Main category deleted successfully.")</script>';
			echo '<script>window.location.assign("main-category-list.php")</script>';
		}
	}


	
 
?>
      
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Main Category List</li>
              </ul> 
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-columns text-default"></i> Main Category List</a></li> 
						<li><a href="#add-main-category" data-toggle="tab"><i class="fa fa-edit text-default"></i> Add Main Category  </a></li>
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
										<th width="20%">Main Category Title</th>
										<th width="25%">Main Priority</th> 
										<th width="25%">Main Category Img</th> 
										<th width="25%">Main Category Icon</th> 
										<th width="15%">Edit</th>
										<th width="25%">Action</th>
										<th width="15%">Delete</th>
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($arr_get_main_category_list);$i++){ ?>
										<tr>
											<td><?php echo  $j; ?></td>
											<td><?php echo $arr_get_main_category_list[$i]['mc_title']; ?></td>
											<td><?php echo $arr_get_main_category_list[$i]['mc_priority']; ?></td>
											
											
											<td><img src="images/main_category_images/<?php echo$arr_get_main_category_list[$i]['mc_image'];?>" class="img-circle" style="height:50px"></td> 
											
											<td><img src="images/main_category_icons/<?php echo$arr_get_main_category_list[$i]['mc_icon'];?>" class="img-circle" style="height:50px"></td> 
											
											 
											
											<td><a href="main-category-list-edit.php?id=<?php echo $arr_get_main_category_list[$i]['mc_id'];?>" class="pull-left" ><button class="edit_profile btn btn-info"><i class="fa fa-edit"></i> Edit</button></a></td>
											
											
											
											<?php if($arr_get_main_category_list[$i]['mc_status']==1){?>
											<td>
												<form id="form" method="POST">
													<input type="hidden" class="form-control" value="<?php echo $arr_get_main_category_list[$i]['mc_id']?>" name="id" required>	
													<button type="submit" name="deactive" class="btn btn-danger btn-s-xs" onclick="return confirm('Are you sure you want to deactivate this item?');" ><i class="fa fa-ban"></i> Deactivate</button>  
												</form>
											</td>
											<?php } else{ ?>
											<td>
												<form id="form" method="POST">
													<input type="hidden" class="form-control" value="<?php echo $arr_get_main_category_list[$i]['mc_id']?>" name="id" required>	
													<button type="submit" name="activate" class="btn btn-success btn-s-xs" onclick="return confirm('Are you sure you want to activate this item?');" ><i class="fa fa-check"></i> Activate</button>   
												</form>
											</td><?php } ?> 
											 
											 
											<td>
												<form id="form" method="POST">
													<input type="hidden" class="form-control" value="<?php echo $arr_get_main_category_list[$i]['mc_id']?>" name="id" required>	
													
													<input type="hidden" class="form-control" value="<?php echo $arr_get_main_category_list[$i]['mc_image']?>" name="mc_image" required>	
													
													
													<input type="hidden" class="form-control" value="<?php echo $arr_get_main_category_list[$i]['mc_icon']?>" name="mc_icon" required>	
													
													
													<button type="submit" name="delete" class="btn btn-danger btn-s-xs" onclick="return confirm('Are you sure you want to delte this item?');"><i class="fa fa-times"></i> Delete</button> 
												</form>
											</td> 
											
											
										</tr>
									<?php $j++; } ?>
									</tbody>
								  </table>
								</div>
							  </section>
						</div> 
						
						
						
						<div class="tab-pane fade" id="add-main-category">
							<div class="row">
								<div class="col-sm-6">
								  <form data-validate="parsley" method="POST" enctype="multipart/form-data">
									<section class="panel panel-default"> 
									  <div class="panel-body">
										<p class="text-muted">Please fill the information to continue</p>
										<div class="form-group">
										  <label>Main Category Name</label>
										  <input type="text" class="form-control" name="mc_title" placeholder="Enter Main Category Name" data-required="true">    									  
										</div>
										
										<div class="form-group">
										  <label>Main Category Icon</label><br/>
										  <input type="file" class="filestyle" name="mc_icon" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" data-required="true"  accept="image/x-png, image/gif, image/jpeg" onchange="validate_image(this);">                    
										</div> 
										
										
										
										<div class="form-group">
										  <label>Main Category Image</label><br/>
										  <input type="file" class="filestyle" name="mc_image" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" data-required="true"  accept="image/x-png, image/gif, image/jpeg" onchange="validate_image(this);">                    
										</div>
										
										<div class="form-group">
										  <label>Main Category Priority</label> 
											<select  class="form-control" data-required="true" name="mc_priority">
												<option value="">Priority</option>
												<option value="1">1</option>
												<option value="2">2</option>
												<option value="3">3</option>
												<option value="4">4</option>
												<option value="5">5</option>
												<option value="6">6</option>
												<option value="7">7</option>
												<option value="8">8</option>
												<option value="9">9</option>
												<option value="10">10</option>  
											</select>
										</div>
											

										
									  </div>
									  <footer class="panel-footer text-right bg-light lter">
										<button type="submit" name="submit" class="btn btn-success btn-s-xs">Submit</button>
									  </footer>
									</section>
								  </form>
								</div>  
							</div> 
						</div>
					  </div>
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
