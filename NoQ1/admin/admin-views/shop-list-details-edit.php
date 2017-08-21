<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 

  
$arr_get_main_category_list			=	$admin_controller->get_main_category_list();  


/* get_store_details_by_id*/
 $storeid						=	$_REQUEST['storeid'];
 $get_store_details_by_id		=	$admin_controller->get_store_details_by_id($storeid);  
 // echo '<pre>';
// print_r($get_store_details_by_id);exit;
  // print_r($_SESSION);
  
  
  
/* get_store_details_by_id form submission*/
if(isset($_POST['submit']))
{   
	$update_business_store	=	$admin_controller->update_business_store();  
	if(!empty($update_business_store)){	 
		echo '<script>alert("Busniess store updated successfully.");</script>';?>
		<script>
		var storeid	=	<?php echo $storeid;?>;
		window.location.assign("shop-list-details.php?storeid="+storeid);
		</script>';
		<?php
	}
}


?>
      
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Store Details </li>
                <li class="active">Edit Store Details </li>
              </ul> 
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-edit text-default"></i>Edit Store Details </a></li> 
						 
					  </ul> 
                    </header>
					<div class="form-group" style="align:center;">
						<img src="images/business_stores/<?php echo $get_store_details_by_id[0]['b_store_image'];?>" />
					</div>					
					<div class="panel-body">
					  <div class="tab-content">          
						<div class="tab-pane fade active in" id="main-category-list"> 
							<section class="panel panel-default"> 
							<div class="panel-body">
							  <div class="row">
							  <form role="form" method="POST" enctype="multipart/form-data" data-validate="parsley">
								<div class="col-sm-6">
									<div class="panel-body"> 
										  <input type="hidden" value="<?php echo $_GET['storeid']; ?>" name="store_id" id="store_id" >
										  <input type="hidden" value="<?php echo $_SESSION['ad_id']; ?>" name="invoice_approved_by" id="invoice_approved_by" >
									  
											 <div class="form-group">
											  <label>Store Name</label>  
											  <input type="text" value="<?php echo $get_store_details_by_id[0]['b_store_name']; ?>" class="form-control" name="store_name" data-required="true" placeholder="Enter Store Name">
											</div>
											 
											
											<div class="form-group">
											  <label>Store Unique Id</label>
											  <input value="<?php echo $get_store_details_by_id[0]['b_store_unique_id']; ?>" type="text" class="form-control" name="store_uniq_id"  readonly>
											</div>
											<div class="form-group">
											  <label>Store Owner Name</label>
											  <input value="<?php echo $get_store_details_by_id[0]['b_store_owner_name']; ?>" type="text" class="form-control" name="store_owner_name"  placeholder="Enter Owner Name">
											</div>
											<div class="form-group">
											  <label>Mobile Number</label>
											  <input type="text" value="<?php echo $get_store_details_by_id[0]['b_store_mobile_no']; ?>" class="form-control" name="store_mobile_no" data-type="phone" data-required="true" maxlength ="10" onchange="validate_phonenumber(this);" placeholder="Enter Mobile Number" oninput="if(value.length>10)value=value.slice(0,10)" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
											</div>
											<div class="form-group">
											  <label>Store Landline Number</label>
											  <input value="<?php echo $get_store_details_by_id[0]['b_store_landline']; ?>" type="text" class="form-control" name="store_landline_no"   placeholder="Enter Landline Number">
											</div>
											<div class="form-group">
											  <label>Email Address</label>
											  <input type="email" value="<?php echo $get_store_details_by_id[0]['b_store_email']; ?>" name="store_email" class="form-control"  placeholder="Enter Email address">
											</div>
											
											<div class="form-group">
											  <label>Store Description</label>
											  <textarea class="form-control" name="store_description" data-required="true" placeholder="Enter Store Description"><?php echo $get_store_details_by_id[0]['b_store_description']; ?></textarea>
											</div>
											<div class="form-group">
											  <label>Store Address</label>
											  <textarea class="form-control" name="store_address" placeholder="Enter Store Address"><?php echo $get_store_details_by_id[0]['b_store_address1']; ?></textarea>                      
											</div>  
									 
											 <div class="form-group">
												  <label>Store Address2</label>
												  <textarea class="form-control" name="store_address2" placeholder="Enter Store Address2"><?php echo $get_store_details_by_id[0]['b_store_address2']; ?></textarea>                      
												</div>
												<div class="form-group">
												  <label>Store Area</label>
												  <textarea class="form-control" name="store_area" placeholder="Enter Store Area"><?php echo $get_store_details_by_id[0]['b_store_area']; ?></textarea> 
												</div>
												
												<div class="form-group">
												  <label>Store Landmark</label>
												  <textarea class="form-control" name="store_landmark" placeholder="Enter Store Landmark"><?php echo $get_store_details_by_id[0]['b_store_landmark']; ?></textarea>                      
												</div>
												
												<div class="form-group">
												  <label>Store City</label>
												  <input type="text" class="form-control" name="store_city" value="<?php echo $get_store_details_by_id[0]['b_store_city']; ?>" data-required="true" placeholder="Enter Store City">                        
												</div>
												
												<div class="form-group">
												  <label>Store State</label>
												  <input type="text" class="form-control" name="store_state" value="<?php echo $get_store_details_by_id[0]['b_store_state']; ?>" data-required="true" placeholder="Enter Store State">                        
												</div>
												
												<div class="form-group">
												  <label>Store Country</label>
												  <input type="text" class="form-control" name="store_country" data-required="true"value="<?php echo $get_store_details_by_id[0]['b_store_country']; ?>"  placeholder="Enter Store Country">                        
												</div>
																						
												<div class="form-group">
												  <label>Store Zip</label>
												  <input type="text" value="<?php echo $get_store_details_by_id[0]['b_store_zip']; ?>" class="form-control" name ="store_zip"  placeholder="Enter Store Zipcode">                        
												</div> 
												
												
										</div> 
								</div>
							
								
								
								
								<div class="col-sm-6">
									<div class="panel-body">  
												
											
											  
											<div class="form-group">
											  <label>Mobile Verifed</label>
												<select   class="maincls form-control" name="store_mobile_verified"  >
													<option value="0" <?php if($get_store_details_by_id[0]['b_store_mobile_no_verified']=="0"){ echo "selected"; } ?>>No</option>
													<option value="1" <?php if($get_store_details_by_id[0]['b_store_mobile_no_verified']=="1"){ echo "selected"; } ?>>Yes</option> 
												</select> 										  
											</div>
											
											
											<div class="form-group">
											  <label>Email Verifed</label>
												<select   class="maincls form-control" name="store_email_verified"  >
													<option value="0" <?php if($get_store_details_by_id[0]['b_store_email_verified']=="0"){ echo "selected"; } ?>>No</option>
													<option value="1" <?php if($get_store_details_by_id[0]['b_store_email_verified']=="1"){ echo "selected"; } ?>>Yes</option> 
												</select> 										  
											</div>
											
										
											
									
											<div class="form-group">
												<label>Store Opens At</label>
											  <div>
												<select name="store_working_hours_from_time"  class="form-control">
												  <option value="<?php echo $get_store_details_by_id[0]['b_store_working_hours_from_time'];?>"><?php echo$get_store_details_by_id[0]['b_store_working_hours_from_time'];?></option>
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
													   <option value="<?php echo $get_store_details_by_id[0]['b_store_working_hours_end_time'];?>"><?php echo$get_store_details_by_id[0]['b_store_working_hours_end_time'];?></option>
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
													<option value="0" <?php if($get_store_details_by_id[0]['b_store_has_delivery']=="0"){ echo "selected"; } ?>>No</option>
													<option value="1" <?php if($get_store_details_by_id[0]['b_store_has_delivery']=="1"){ echo "selected"; } ?>>Yes</option> 
												</select> 										  
											</div>
											
											
											
											<div class="form-group">
											  <label>Main Category Name</label>
												<select id="mc_id" class="maincls form-control" name="mc_id" required>
													<option value="<?php echo $get_store_details_by_id[0]['mc_id']; ?>"><?php echo $get_store_details_by_id[0]['mc_title']; ?>
													</option>
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
													<option value="<?php echo $get_store_details_by_id[0]['sc_id']; ?>"><?php echo $get_store_details_by_id[0]['sc_title']; ?></option>
												</select> 									  
											</div> 
											 
											 
											 
											 
											  
											<div class="form-group">
											  <label>Store Document Collected </label>
											  <input type="text" value="<?php echo $get_store_details_by_id[0]['b_store_document_prof']; ?>" class="form-control" name ="store_document"  placeholder="Enter Store Document Name And ID">                        
											</div> 
											
											
											<div class="form-group">
											  <label>Store Latitude </label>
											  <input type="text" value="<?php echo $get_store_details_by_id[0]['b_store_lat']; ?>" class="form-control" name ="store_latitude"  placeholder="Enter Store Latitude">                        
											</div> 
											
											
											<div class="form-group">
											  <label>Store Longitude </label>
											  <input type="text" value="<?php echo $get_store_details_by_id[0]['b_store_long']; ?>" class="form-control" name ="store_longitude"  placeholder="Enter Store Longitude">                        
											</div> 
											
											
											
											
										<div class="form-group"> <?php $arr_work=explode(",",$get_store_details_by_id[0]['b_store_working_days']);  ?>
											  <label>Store Working Days</label><br/>
												<label class="checkbox-inline"> 
												  <input type="checkbox" name="store_working_days[]" value="1" <?php if(in_array(1,$arr_work)){  echo "checked";  } ?>> Sunday
												</label>
												<label class="checkbox-inline">
												  <input type="checkbox" name="store_working_days[]" value="2" <?php if(in_array(2,$arr_work)){  echo "checked";  } ?>> Monday
												</label>
												<label class="checkbox-inline">
												  <input type="checkbox" name="store_working_days[]" value="3" <?php if(in_array(3,$arr_work)){ echo "checked"; } ?>> Tuesday
												</label>  
												<label class="checkbox-inline">
												  <input type="checkbox" name="store_working_days[]" value="4" <?php if(in_array(4,$arr_work)){ echo "checked";  } ?>> Wednesday
												</label><br/>
												<label class="checkbox-inline">
												  <input type="checkbox" name="store_working_days[]" value="5" <?php if(in_array(5,$arr_work)){ echo "checked"; } ?>> Thursday
												</label>
												<label class="checkbox-inline">
												  <input type="checkbox" name="store_working_days[]" value="6" <?php if(in_array(6,$arr_work)){ echo "checked"; } ?>> 
												  Friday
												</label> 
												<label class="checkbox-inline">
												  <input type="checkbox" name="store_working_days[]" value="7" <?php if(in_array(7,$arr_work)){ echo "checked"; } ?> > Saturday
												</label> 
											</div>
									
									
											
											 <div class="form-group">
											  <label>Store Reg By</label>
												<select   class="maincls form-control" name="store_reg_by">
													<option value="1" <?php if($get_store_details_by_id[0]['b_store_reg_by']=="1"){ echo "selected"; } ?>>IOS</option>
													<option value="2" <?php if($get_store_details_by_id[0]['b_store_reg_by']=="2"){ echo "selected"; } ?>>Android</option> 
													<option value="3" <?php if($get_store_details_by_id[0]['b_store_reg_by']=="3"){ echo "selected"; } ?>>Website</option> 
													<option value="4" <?php if($get_store_details_by_id[0]['b_store_reg_by']=="4"){ echo "selected"; } ?>>Executive</option> 
												</select> 										  
											</div>
											
											
											
											<div class="form-group">
											<label>Store Pririty</label>
											  <select name="store_priority1"  class="form-control">
												   <option value="<?php echo $get_store_details_by_id[0]['b_store_priority'];?>"><?php echo$get_store_details_by_id[0]['b_store_priority'];?></option>
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
												   <option value="<?php echo $get_store_details_by_id[0]['b_store_category_class'];?>"><?php echo$get_store_details_by_id[0]['b_store_category_class'];?></option>
													  <option value="A">A</option>  
													  <option value="B">B</option>  
													  <option value="C">C</option>  
													  <option value="D">D</option>  
													  <option value="E">E</option>  
													  <option value="F">F</option>   
												</select> 
											</div>
											
												
												
											
										
										<div class="form-group">
										  <label>Store Image</label><br/>
										  <input type="file" class="filestyle" name="b_store_image" data-icon="false" data-classButton="btn btn-default" data-classInput="form-control inline input-s"  accept="image/x-png, image/gif, image/jpeg" onchange="validate_image(this);" >                    
										</div> 
										
											
												
									<!--		<div class="form-group">
											   <label>Adv Start Date</label>
												<input type="text"  class="form-control form-control2"   value="<?php echo $get_store_details_by_id[0]['b_store_adv_start_date']; ?>" id="store_adv_start_date" name="store_adv_start_date" placeholder="DD/MM/YYY" required="">                
											</div> 
											
											<div class="form-group">
											   <label>Adv End Date</label>
												<input type="text"  class="form-control form-control2"  value="<?php echo $get_store_details_by_id[0]['b_store_adv_end_date']; ?>"  id="store_adv_end_date" name="store_adv_end_date" placeholder="DD/MM/YYY" required="">                
											</div> 
											
											
											<div class="form-group">
											<label>Store Class</label>
											  <select name="store_class"  class="form-control">
												   <option value="<?php echo $get_store_details_by_id[0]['b_store_category_class'];?>"><?php echo$get_store_details_by_id[0]['b_store_category_class'];?></option>
													  <option value="A">A</option>  
													  <option value="B">B</option>  
													  <option value="C">C</option>  
													  <option value="D">D</option>  
													  <option value="E">E</option>  
													  <option value="F">F</option>   
												</select> 
											</div>
											
											
											
											<div class="form-group">
											   <label>Amount Paid</label>
												<input type="text"    class="form-control form-control2"  value="<?php echo $get_store_details_by_id[0]['b_store_paid_amount'];?>" id="store_amt_paid" name="store_amt_paid" placeholder="Amount Paid" required="">                
											</div> 
											
											
											<div class="form-group">
											   <label>Invoice No</label>
												<input type="text"   class="form-control form-control2" value="<?php echo $get_store_details_by_id[0]['b_store_invoice_no'];?>"  id="store_invoice_no" name="store_invoice_no" placeholder="invoice No" required="">                
											</div> 
											
											 
											<div class="form-group">
											   <label>Invoice Genrated Date</label>
												<input type="text"  value="<?php echo $get_store_details_by_id[0]['b_store_invoice_generated_date'];?>"  class="form-control form-control2"  id="store_invoice_gen_date" name="store_invoice_gen_date" placeholder="DD/MM/YYY" required="">                
											</div>  -->
											
											
											<div class="form-group">
											  <div>
												<button type="submit" name="submit" class="btn btn-primary">Update</button>
											  </div>
											</div>
								</div>
								
								
							</div>
							 
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
$( "#d_id" ).change(function() {
	var val = $(this).val(); 
		$.ajax({
		  type: 'POST',
		  url: "get-city.php",
		  //data: 'id='+val,
		  data: {id: val},
		  success: function(data){
			  // alert(data);
			$('#c_id').html(data);
			// document.location.href = 'booking.php';
		  }
		});	 
});
	   
</script>

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
