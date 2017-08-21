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
	$arr_add_sub_category_output	=	$admin_controller->update_sub_category();  
	if($arr_add_sub_category_output==1){	 
		echo '<script>alert("Sub category updated successfully.")</script>';
		echo '<script>window.location.assign("sub-category-list.php")</script>';
	}elseif($arr_add_sub_category_output==2){
		echo '<script>alert("Sub category already updated.")</script>';
		echo '<script>window.location.assign("sub-category-list.php")</script>';
	}else{
		echo '<script>alert("Something went wrong.")</script>';
		echo '<script>window.location.assign("sub-category-list.php")</script>';
	}
}
 
$arr_get_main_category_list	=	$admin_controller->get_main_category_list();   
$get_sub_category_list		=	$admin_controller->get_sub_category_by_id($_GET['id']);   
// echo'<pre>';print_r($get_sub_category_list); exit;
	 // print_r($get_sub_category_list); 
 

?>
      
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li><a href="sub-category-list.php"><i class="fa fa-columns"></i> Sub Category List</a></li> 
                <li class="active">Edit Sub Category</li>
              </ul> 
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-columns text-default"></i> Sub Category List</a></li> 
						</ul> 
                    </header>  
					<div class="panel-body">
					  <div class="tab-content">          
						<div class="tab-pane fade active in" id="main-category-list"> 
							<section class="panel panel-default"> 
								<div class="row">
								<div class="col-sm-6">
								  <form data-validate="parsley" method="POST" enctype="multipart/form-data">
									<section class="panel panel-default"> 
									  <div class="panel-body">
										<p class="text-muted">Please fill the information to continue</p>
										<div class="form-group"> 
										  <input type="hidden" name="sc_id" value="<?php echo $_GET['id'];?>"> 
										</div>
										
										<div class="form-group">
										  <label>Sub Category Name</label>
										  <input type="text" value="<?php echo $get_sub_category_list[0]['sc_title']; ?>" class="form-control" name="sc_title" placeholder="Enter Sub Category Name"  data-required="true">   
										   <input type="hidden" value="<?php echo $get_sub_category_list[0]['sc_title']; ?>" name="sc_title_hidden">
										</div>
										
										
										<div class="form-group">
										  <label>Sub Category Image</label><br/>
										 <input type="hidden" class="form-control" value="<?php echo $get_sub_category_list[0]['sc_image']; ?>" name="mc_image_name" placeholder="Enter Main Category Name" data-required="true">   
																	
										<?php if($get_sub_category_list[0]['sc_image']!=''){ ?>
										<img id="output" src="images/sub_category_images/<?php echo $get_sub_category_list[0]['sc_image'];?>" class="img-circle" style="height:50px" alt="Sub Category Image"/>
										<?php  } ?>
										<br/><br/>
										
										 <input type="file" accept="image/x-png, image/gif, image/jpeg" onchange="loadFile(event)" name="sc_image">
										<script>
										  var loadFile = function(event) {
											var output = document.getElementById('output');
											output.src = URL.createObjectURL(event.target.files[0]);
										  };
										  </script>  
										</div> 
										
										
										
										<div class="form-group">
                                          <label>Sub Category  Priority</label>  										
                                          <select  class="form-control" data-required="true" name="sc_priority">
                                             <option value="1" <?php if($get_sub_category_list[0]['sc_priority']==1){ echo "selected"; } ?> >1</option>
                                             <option value="2" <?php if($get_sub_category_list[0]['sc_priority']==2){ echo "selected"; } ?>>2</option>
                                             <option value="3" <?php if($get_sub_category_list[0]['sc_priority']==3){ echo "selected"; } ?>>3</option>
                                             <option value="4" <?php if($get_sub_category_list[0]['sc_priority']==4){ echo "selected"; } ?>>4</option>
                                             <option value="5" <?php if($get_sub_category_list[0]['sc_priority']==5){ echo "selected"; } ?>>5</option>
                                             <option value="6" <?php if($get_sub_category_list[0]['sc_priority']==6){ echo "selected"; } ?>>6</option>
                                             <option value="7" <?php if($get_sub_category_list[0]['sc_priority']==7){ echo "selected"; } ?>>7</option>
                                             <option value="8" <?php if($get_sub_category_list[0]['sc_priority']==8){ echo "selected"; } ?>>8</option>
                                             <option value="9" <?php if($get_sub_category_list[0]['sc_priority']==9){ echo "selected"; } ?>>9</option>
                                             <option value="10" <?php if($get_sub_category_list[0]['sc_priority']==10){ echo "selected"; } ?>>10</option>
                                          </select>
                                       </div>
									   
									   
									  </div>
									  <footer class="panel-footer text-right bg-light lter">
										<button type="submit" name="submit" class="btn btn-success btn-s-xs">Update</button>
									  </footer>
									</section>
								  </form>
								</div>  
							</div> 
							  </section>
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
  <script>
$(document).ready(function(){
    $('#mc_table').DataTable();
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
