<?php 
session_start();  
if(isset($_SESSION['ad_email_id'])) 
{	 
error_reporting(E_ALL);  
//Header File
require_once("header.php");  
$arr_get_main_category_list	=	$admin_controller->get_main_category_perticular_details_by_id($_GET['id']);  

/* Main Category form submission*/
if(isset($_POST['submit']))
{   
	$arr_main_category_output	=	$admin_controller->update_main_category();  
	if($arr_main_category_output==1){	 
		echo '<script>alert("Main category updated successfully.")</script>';
		echo '<script>window.location.assign("main-category-list.php")</script>';
	}elseif($arr_main_category_output==2){
		echo '<script>alert("Main category already updated.")</script>';
		echo '<script>window.location.assign("main-category-list.php")</script>';
	}else{
		echo '<script>alert("Something went wrong.")</script>';
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
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-edit text-default"></i> Edit Main Category List</a></li>  
					  </ul> 
                    </header> 
 
						
						
						<div class="tab-pane fade active in" id="add-main-category">
							<div class="row">
								<div class="col-sm-6">
								   <form data-validate="parsley" method="POST" enctype="multipart/form-data">
										<section class="panel panel-default"> 
										  <div class="panel-body">
											<p class="text-muted">Please fill the information to continue</p>
											<div class="form-group">
											  <label>Main Category Name</label>
											  <input type="text" class="form-control" value="<?php echo $arr_get_main_category_list[0]['mc_title']; ?>" name="mc_title" placeholder="Enter Main Category Name" data-required="true">    
											<input type="hidden" name="id" value="<?php echo $_GET['id'];?>"> 
											</div>
											<div class="form-group">
											  <label>Main Category Image</label><br/>
											  
											   <input type="hidden" class="form-control" value="<?php echo $arr_get_main_category_list[0]['mc_image']; ?>" name="mc_image_name" placeholder="Enter Main Category Name" data-required="true">   
											   
											   
											 <!-- <input type="file" class="filestyle" id="imgInp" name="mc_image" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" data-required="true"  accept="image/x-png, image/gif, image/jpeg" onchange="validate_image(this);">    -->
											<input type="file" accept="image/*" onchange="loadFile(event)" name="mc_image"><br/>
											<img id="output" src="images/main_category_images/<?php echo$arr_get_main_category_list[0]['mc_image'];?>" class="img-circle" style="height:100px" alt="Main Category Image"/>
											
											<script>
											  var loadFile = function(event) {
												var output = document.getElementById('output');
												output.src = URL.createObjectURL(event.target.files[0]);
											  };
											</script>  
											
											</div> 
											
											
											
											<div class="form-group">
											  <label>Main Category Icon</label><br/>
											  
											   <input type="hidden" class="form-control" value="<?php echo $arr_get_main_category_list[0]['mc_icon']; ?>" name="mc_icon_name" placeholder="Enter Main Category Name" data-required="true">   
											   
											    
												<input type="file" accept="image/*" onchange="loadFile1(event)" name="mc_icon"><br/>
												<img id="output1" src="images/main_category_icons/<?php echo$arr_get_main_category_list[0]['mc_icon'];?>" class="img-circle" style="height:100px" alt="Main Category Image"/>
												
												<script>
												  var loadFile1 = function(event) {
													var output = document.getElementById('output1');
													output.src = URL.createObjectURL(event.target.files[0]);
												  };
												</script>  
											
											</div> 
											
											
											
													
										<div class="form-group">
                                          <label>Main Category  Priority</label>  										
                                          <select  class="form-control" data-required="true" name="mc_priority">
                                             <option value="1" <?php if($arr_get_main_category_list[0]['mc_priority']==1){ echo "selected"; } ?> >1</option>
                                             <option value="2" <?php if($arr_get_main_category_list[0]['mc_priority']==2){ echo "selected"; } ?>>2</option>
                                             <option value="3" <?php if($arr_get_main_category_list[0]['mc_priority']==3){ echo "selected"; } ?>>3</option>
                                             <option value="4" <?php if($arr_get_main_category_list[0]['mc_priority']==4){ echo "selected"; } ?>>4</option>
                                             <option value="5" <?php if($arr_get_main_category_list[0]['mc_priority']==5){ echo "selected"; } ?>>5</option>
                                             <option value="6" <?php if($arr_get_main_category_list[0]['mc_priority']==6){ echo "selected"; } ?>>6</option>
                                             <option value="7" <?php if($arr_get_main_category_list[0]['mc_priority']==7){ echo "selected"; } ?>>7</option>
                                             <option value="8" <?php if($arr_get_main_category_list[0]['mc_priority']==8){ echo "selected"; } ?>>8</option>
                                             <option value="9" <?php if($arr_get_main_category_list[0]['mc_priority']==9){ echo "selected"; } ?>>9</option>
                                             <option value="10" <?php if($arr_get_main_category_list[0]['mc_priority']==10){ echo "selected"; } ?>>10</option>
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
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#imgInp").change(function(){
        //readURL(this);
		alert('hi');
    });
</script>

<script>
  window.location.assign("../index.php")
</script>
<?php
}
?>
