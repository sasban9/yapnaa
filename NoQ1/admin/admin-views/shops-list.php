<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 

 
  
$arr_get_main_category_list			=	$admin_controller->get_main_category_list();  

//Deactive
if(isset($_POST['deactive']))
{	
	$deactive_business_store	=	$admin_controller->deactive_business_store();
	// print_r($update_main_category);exit;
	if(!empty($deactive_business_store)){
		echo '<script>alert("Business store deactivated successfully.")</script>';
		echo '<script>window.location.assign("shops-list.php")</script>';
	}
}



//Active
if(isset($_POST['activate']))
{	
	$activate_business_store	=	$admin_controller->activate_business_store();
	// print_r($update_main_category);exit;
	if(!empty($activate_business_store)){
		echo '<script>alert("Business store activated successfully.")</script>';
		echo '<script>window.location.assign("shops-list.php")</script>';
	} 
}

 
 
 
 //Active
if(isset($_POST['submit']))
{	
	$register_new_business_store	=	$admin_controller->register_new_business_store();
	// print_r($update_main_category);exit;
	$file = fopen("/var/www/html/6.txt","w");
				fwrite($file,json_encode($register_new_business_store));
				fclose($file);
	if(!empty($register_new_business_store)){
		if($register_new_business_store == 2 ){
			echo '<script>alert("Mobile number already registered, please try again with another number.")</script>';
		}
		else{
			echo '<script>alert("Business store activated successfully.")</script>';
			echo '<script>window.location.assign("shops-list.php")</script>';
		}
		
	} 
}

/* get_business_store_list*/
$get_business_store_list	=	$admin_controller->get_business_store_list();  
// echo'<pre>';print_r($get_business_store_list);exit;
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
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-shopping-cart text-default"></i> Shop List</a></li>  
						<li><a href="#main-category-list2" data-toggle="tab"><i class="fa fa-edit text-default"></i> Add Shop</a></li>  
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
										<th width="20%">Store Name</th>
										<th width="20%">Owner Name</th>
										<th width="25%">Mobile No</th>
										<th width="25%">Reg By</th> 
										<th width="15%">Sub Category</th>
										<th width="15%">Main Category</th> 
										<th width="15%">Reg Date</th> 
										<th width="25%">Action</th>
										<th width="25%">QR Code</th>
										<!--<th width="15%">Delete</th>-->
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($get_business_store_list);$i++){  
										date_default_timezone_set ("Asia/Calcutta");  
									 
										 ?>
										<tr>
											<td><?php echo  $j; ?></td>
											<td><a href="shop-list-details.php?storeid=<?php echo $get_business_store_list[$i]['b_store_id'];?>" target="_blank" style="color:green"><?php echo $get_business_store_list[$i]['b_store_name'].' ('.$get_business_store_list[$i]['b_store_unique_id'].')'; ?><a/></td>
											<td><?php echo $get_business_store_list[$i]['b_store_owner_name']; ?></td>
											
											<td><?php echo $get_business_store_list[$i]['b_store_mobile_no']; ?></td> 
											<td><?php echo $get_business_store_list[$i]['b_store_reg_by']; ?></td> 
											<td><?php echo $get_business_store_list[$i]['sc_title']; ?></td>
											<td><?php echo $get_business_store_list[$i]['mc_title']; ?></td> 
											
											<td><?php echo $get_business_store_list[$i]['b_store_registration_date']; ?></td> 
											
											
											<?php if($get_business_store_list[$i]['b_store_status']==1){?>
											<td>
												<form id="form" method="POST">
													<input type="hidden" class="form-control" value="<?php echo $get_business_store_list[$i]['b_store_id']?>" name="id" required>	
													<button type="submit" name="deactive" class="btn btn-danger btn-s-xs" onclick="return confirm('Are you sure you want to deactivate this Store?');" ><i class="fa fa-ban"></i> Deactivate</button>  
												</form>
											</td>
											<?php }  else if($get_business_store_list[$i]['b_store_status']==3){?>
											<td>
												<form id="form" method="POST">
													<input type="hidden" class="form-control" value="<?php echo $get_business_store_list[$i]['b_store_id']?>" name="id" required>	
													<button type="submit" name="deactive" class="btn btn-info btn-s-xs" onclick="return confirm('Are you sure you want to deactivate this Store?');" ><i class="fa fa-exclamation-triangle"></i> Expired</button>  
												</form>
											</td>
											<?php }else{ ?>
											<td>
												<form id="form" method="POST">
													<input type="hidden" class="form-control" value="<?php echo $get_business_store_list[$i]['b_store_id']?>" name="id" required>	
													<button type="submit" name="activate" class="btn btn-success btn-s-xs" onclick="return confirm('Are you sure you want to activate this Store?');" ><i class="fa fa-check"></i> Activate</button>   
												</form>
											</td><?php } ?> 
											 
											<td><a href="shop-qr-code-print.php?storeid=<?php echo $get_business_store_list[$i]['b_store_unique_id'];?>" target="_blank"  class="btn btn-success" > <i class="fa fa-print"></i> <a/></td>
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
									  <input type="hidden" value="<?php echo $_SESSION['ad_id']; ?>" name="store_reg_by" id="store_reg_by" >
								  
										 <div class="form-group">
										  <label>Store Name</label>  
										  <input type="text"  class="form-control" name="store_name" data-required="true" placeholder="Enter Store Name">
										</div>
										 
										 
										<div class="form-group">
										  <label>Store Owner Name</label>
										  <input   type="text" class="form-control" name="store_owner_name" data-required="true"  placeholder="Enter Owner Name">
										</div>
										
										<div class="form-group">
										  <label>Mobile Number</label>
										  <input type="text"  class="form-control" name="store_mobile_no" data-type="phone" data-required="true" maxlength ="10" onchange="validate_phonenumber(this);" placeholder="Enter Mobile Number" oninput="if(value.length>10)value=value.slice(0,10)" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
										</div>
										<div class="form-group">
										  <label>Store Landline Number</label>
										  <input   type="text" class="form-control" name="store_landline_no"   placeholder="Enter Landline Number">
										</div>
										
										<div class="form-group">
										  <label>Email Address</label>
										  <input type="email" name="store_email" class="form-control"  placeholder="Enter Email address">
										</div>
										
										<div class="form-group">
										  <label>Store Description</label>
										  <textarea class="form-control" name="store_description" data-required="true" placeholder="Enter Store Description"> </textarea>
										</div>
										<div class="form-group">
										  <label>Store Address</label>
										  <textarea class="form-control" name="store_address1" placeholder="Enter Store Address"> </textarea> 
										</div>  
										
										  
										 <div class="form-group">
										  <label>Store Address2</label>
										  <textarea class="form-control" name="store_address2" placeholder="Enter Store Address2"></textarea>                      
										</div>
										<div class="form-group">
										  <label>Store Area</label>
										  <textarea class="form-control" name="store_area" placeholder="Enter Store Area"></textarea> 
										</div>
										
										<div class="form-group">
										  <label>Store Landmark</label>
										  <textarea class="form-control" name="store_landmark" placeholder="Enter Store Landmark"></textarea>                      
										</div>
										
										<div class="form-group">
										  <label>Store City</label>
										  <input type="text" class="form-control" name="store_city" data-required="true" placeholder="Enter Store City">                        
										</div>
										
										<div class="form-group">
										  <label>Store State</label>
										  <input type="text" class="form-control" name="store_state" data-required="true" placeholder="Enter Store State">                        
										</div>
										
										<div class="form-group">
										  <label>Store Country</label>
										  <input type="text" class="form-control" name="store_country" data-required="true" placeholder="Enter Store Country">                        
										</div>
										 
										<div class="form-group">
										  <label>Store Zip</label>
										  <input type="text"  class="form-control" name ="store_zip"  placeholder="Enter Store Zipcode"> 
										</div>  
									</div> 
								</div>
							
								
								
								
								<div class="col-sm-6">
									<div class="panel-body">  
									
										<div class="form-group">
										  <label>Business Type</label>
											<select   class="maincls form-control" name="b_store_business_type" data-required="true"  >
												<option value="">Select Business Type</option>
												<option value="1">Booking</option>
												<option value="2">Ordering</option> 
											</select> 										  
										</div>
										
										
										
										<div class="form-group">
										  <label>Store Image</label><br/>
										  <input type="file" class="filestyle" name="b_store_image" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s" data-required="true"  accept="image/x-png, image/gif, image/jpeg" onchange="validate_image(this);" data-required="true" >                    
										</div> 
										
										
										
										
										<div class="form-group">
										  <label>Mobile Verifed</label>
											<select   class="maincls form-control" name="store_mobile_verified"  >
												<option value="0">No</option>
												<option value="1">Yes</option> 
											</select> 										  
										</div>
										
										
										<div class="form-group">
										  <label>Email Verifed</label>
											<select   class="maincls form-control" name="store_email_verified"  >
												<option value="0">No</option>
												<option value="1">Yes</option> 
											</select> 										  
										</div>
										
									
										
								
										<div class="form-group">
											<label>Store Opens At</label>
										  <div>
											<select name="store_working_hours_from_time"  class="form-control"> 
													  <option value="12:00 AM">12:00 AM</option>
													  <option value="1:00 AM">1:00 AM</option>
													  <option value="2:00 AM">2:00 AM</option>
													  <option value="3:00 AM">3:00 AM</option>
													  <option value="4:00 AM">4:00 AM</option>
													  <option value="5:00 AM">5:00 AM</option>
													  <option value="6:00 AM">6:00 AM</option>
													  <option value="7:00 AM">7:00 AM</option>
													  <option value="8:00 AM">8:00 AM</option>
													  <option value="9:00 AM">9:00 AM</option>
													  <option value="10:00 AM">10:00 AM</option>
													  <option value="11:00 AM">11:00 AM</option>
													  <option value="12:00 PM">12:00 PM</option>
													  <option value="1:00 PM">1:00 PM</option>
													  <option value="2:00 PM">2:00 PM</option>
													  <option value="3:00 PM">3:00 PM</option>
													  <option value="4:00 PM">4:00 PM</option>
													  <option value="5:00 PM">5:00 PM</option>
													  <option value="6:00 PM">6:00 PM</option>
													  <option value="7:00 PM">7:00 PM</option>
													  <option value="8:00 PM">8:00 PM</option>
													  <option value="9:00 PM">9:00 PM</option>
													  <option value="10:00 PM">10:00 PM</option>
													  <option value="11:00 PM">11:00 PM</option>
													  
													</select> 
										  </div>
										</div>
										
										
										
										<div class="form-group">
											<label>Store Closes At</label>
											  <select name="store_working_hours_end_time"  class="form-control"> 
													  <option value="12:00 AM">12:00 AM</option>
													  <option value="1:00 AM">1:00 AM</option>
													  <option value="2:00 AM">2:00 AM</option>
													  <option value="3:00 AM">3:00 AM</option>
													  <option value="4:00 AM">4:00 AM</option>
													  <option value="5:00 AM">5:00 AM</option>
													  <option value="6:00 AM">6:00 AM</option>
													  <option value="7:00 AM">7:00 AM</option>
													  <option value="8:00 AM">8:00 AM</option>
													  <option value="9:00 AM">9:00 AM</option>
													  <option value="10:00 AM">10:00 AM</option>
													  <option value="11:00 AM">11:00 AM</option>
													  <option value="12:00 PM">12:00 PM</option>
													  <option value="1:00 PM">1:00 PM</option>
													  <option value="2:00 PM">2:00 PM</option>
													  <option value="3:00 PM">3:00 PM</option>
													  <option value="4:00 PM">4:00 PM</option>
													  <option value="5:00 PM">5:00 PM</option>
													  <option value="6:00 PM">6:00 PM</option>
													  <option value="7:00 PM">7:00 PM</option>
													  <option value="8:00 PM">8:00 PM</option>
													  <option value="9:00 PM">9:00 PM</option>
													  <option value="10:00 PM">10:00 PM</option>
													  <option value="11:00 PM">11:00 PM</option>
												</select> 
											</div>	
										<div class="form-group">
										  <label>Has Home Delivery</label>
											<select   class="maincls form-control" name="store_delivery"  >
												<option value="0">No</option>
												<option value="1">Yes</option> 
											</select> 										  
										</div>
										
										
										
										<div class="form-group">
										  <label>Main Category Name</label>
											<select id="mc_id" class="maincls form-control" name="mc_id" required> 
												<?php  
													for($i=0;$i<count($arr_get_main_category_list);$i++){ 
													if($arr_get_main_category_list[$i]['mc_status']==1){
													?>
												<option value="<?php echo $arr_get_main_category_list[$i]['mc_id'];?>">
													<?php echo $arr_get_main_category_list[$i]['mc_title'];?>
												</option>
												<?php } }?>
											</select> 									  
										</div>
										
										
										
										
										<div class="form-group">
										  <label> Sub Category Name</label>
											<select class="maincls form-control" name="sub_category_id" id="sub_id" data-required="true">  
												<option value="">Select Sub Category</option>
											</select> 									  
										</div> 
										 
										 
										 
										 
										  
										<div class="form-group">
										  <label>Store Document Collected </label>
										  <input type="text"  class="form-control" name ="store_document"  placeholder="Enter Store Document Name And ID">                        
										</div> 
										
										
										<div class="form-group">
										  <label>Store Latitude </label>
										  <input type="text"   class="form-control" name ="store_latitude"  placeholder="Enter Store Latitude">                        
										</div> 
										
										
										<div class="form-group">
										  <label>Store Longitude </label>
										  <input type="text"   class="form-control" name ="store_longitude"  placeholder="Enter Store Longitude">                        
										</div> 
										
										
										
										
									<div class="form-group"> 
										  <label>Store Working Days</label><br/>
											<label class="checkbox-inline"> 
											  <input type="checkbox" name="store_working_days[]" value="1"> Sunday
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" name="store_working_days[]" value="2"> Monday
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" name="store_working_days[]" value="3"> Tuesday
											</label>  
											<label class="checkbox-inline">
											  <input type="checkbox" name="store_working_days[]" value="4"> Wednesday
											</label><br/>
											<label class="checkbox-inline">
											  <input type="checkbox" name="store_working_days[]" value="5"> Thursday
											</label>
											<label class="checkbox-inline">
											  <input type="checkbox" name="store_working_days[]" value="6"> 
											  Friday
											</label> 
											<label class="checkbox-inline">
											  <input type="checkbox" name="store_working_days[]" value="7"> Saturday
											</label> 
										</div>
								
								
										
										 <div class="form-group">
										  <label>Store Reg By</label>
											<select   class="maincls form-control" name="store_reg_device">
												<option value="">Select an option</option>
												<option value="1">IOS</option>
												<option value="2">Android</option> 
												<option value="3">Website</option> 
												<option value="4">Admin</option> 
											</select> 										  
										</div>
										
										
										
										<div class="form-group">
										<label>Store Pririty</label>
										  <select name="store_priority"  class="form-control"> 
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
										
									 
										
										
										<div class="form-group">
										<label>Store Class</label>
										  <select name="store_class"  class="form-control"> 
												  <option value="A">A</option>  
												  <option value="B">B</option>  
												  <option value="C">C</option>  
												  <option value="D">D</option>  
												  <option value="E">E</option>  
												  <option value="F">F</option>   
											</select> 
										</div>
										
										 
										
										<div class="form-group">
										  <div>
											<button type="submit" name="submit" class="btn btn-primary">Submit</button>
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
$( "#mc_id" ).change(function() {
	var val = $(this).val(); 
		$.ajax({
		  type: 'POST',
		  url: "get-sub-category-list.php",
		  //data: 'id='+val,
		  data: {id: val},
		  success: function(data){
			  // alert(data);
			$('#sub_id').html(data);
			// document.location.href = 'booking.php';
		  }
		});	 
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
