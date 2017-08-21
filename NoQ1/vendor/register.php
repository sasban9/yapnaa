<?php
session_start();
require_once("../config/tab_config.php");
require_once("../config/config.php");

require_once("../model/model.php"); 
$obj_model	=	new model();
require_once('../controller/vendor_controller.php'); 
$vendor_controller	=	new vendor_controller();


$arr_get_main_category_list			=	$vendor_controller->get_main_category_list(); 
// echo '<pre>';
// print_r($arr_get_main_category_list);   
?>
<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
  <meta charset="utf-8" />
  <title>NOQ | Vendor Panel</title>  
  <link rel="stylesheet" href="vendor-views/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="vendor-views/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="vendor-views/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="vendor-views/css/font.css" type="text/css" />
  <link rel="stylesheet" href="vendor-views/css/app.css" type="text/css" /> 
</head>
<body>
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xxl">
     <!-- <a class="navbar-brand block">Nammuru Vendor</a>-->
      <section class="panel panel-default bg-white m-t-lg" id="loginscreen">
        <header class="panel-heading text-center">
          <strong>New Registartion</strong>
        </header>
        <form name="store_registartion" id="store_registartion" method="POST" class="panel-body wrapper-lg">
		 <div id="err_login"></div> 
		  	<div class="form-group">
			  <label>Main Category Name</label>
				<select id="mc_id" class="maincls form-control" name="mc_id" required>
					<option value="">Select Shop Category</option>
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
			  <label>Store Name</label>  
			  <input type="text"   class="form-control" name="reg_store_name" value="ABCD" data-required="true" placeholder="Enter Store Name">
			</div>
			 
			
			
		  <div class="form-group">
            <label class="control-label">Store Owner Name</label>
            <input type="text" id="inputPassword" placeholder="Store Owner Name" name="reg_b_store_owner_name"    value="ABCD Owner"  class="form-control" data-required="true"   required>
          </div>   
		  
		  
		  <div class="form-group">
            <label class="control-label">Email Id</label>
            <input type="text" placeholder="admin@gmail.com" name="reg_b_store_email"   class="form-control"  required>
          </div>
		  
		  
		  
          <div class="form-group">
            <label class="control-label">Mobile No</label>
            <input type="text" placeholder="99********" name="reg_b_store_mobile_no"   class="form-control"   data-type="phone" data-required="true" maxlength ="10" onchange="validate_phonenumber(this);" placeholder="Enter Mobile Number" oninput="if(value.length>10)value=value.slice(0,10)" onkeyup="this.value=this.value.replace(/[^\d]/,'')" required>
          </div>
		  
		  
          <div class="form-group">
            <label class="control-label">Password</label>
            <input type="password" id="inputPassword" placeholder="Password" name="reg_b_store_password"  value=""  class="form-control" data-required="true"   required>
          </div>   
		  
		  
		  <div class="form-group">
            <label class="control-label">Confirm Password</label>
            <input type="password" id="inputPassword" placeholder="Confirm Password" name="reg_conf_b_store_password"    value=""    class="form-control" data-required="true"   required>
          </div> 
		  
		  
		   
			<input id="submit" onclick="myFunction()" type="submit" name="vendor_login" class="btn btn-success btn-block"  value="Register"> 
		  
		   
          <div class="line line-dashed"></div> 
          <a href="index.php">Login</a>
        </form>
      </section>
	  
	  
	  
	  
	  <!--OTP verification-->
	  <section class="panel panel-default bg-white m-t-lg" id="otpverification">
        <header class="panel-heading text-center">
          <strong>Mobile Number verification</strong>
        </header>
        <form name="check_vendor_otp" id="check_vendor_otp" method="POST"   class="panel-body wrapper-lg">
		 <div id="err_otp"></div>
         
          <div class="form-group">
            <label class="control-label" style="text-align:center">Verification code hasbeen sent to <span id="vendor_mobi" style="color:green"></span> number.</label>
            <input type="text"  placeholder="Enter OTP" name="OTP"    id="otp" class="form-control input-lg" data-required="true" required>
            <input type="text"  name="confirm_OTP" id="confirm_OTP"    class="form-control input-lg" data-required="true" required>
            <input type="hidden"  name="confirm_mobile" id="confirm_mobile"    class="form-control input-lg" data-required="true" required>
          </div>   
		   <input id="submit"   type="submit" name="vendor_otp_check" class="btn btn-success"  value="Verify"> 
		   
          <div class="line line-dashed"></div> 
          <a href="index.php" class="btn btn-info btn-block">Login</a>
        </form>
		
		<div id="verify_success"></div>
		
		
      </section>
	  
	  
	  
    </div>
  </section>
  <!-- footer   -->
   <footer id="footer">
    <div class="text-center padder">
      <p>
        <small>Powered by - <a href="#" target="_blank">JJ Bytes Pvt Ltd</a>  &copy; <?php echo date('Y');?></small>
      </p>
    </div>
  </footer>
  <script src="vendor-views/js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="vendor-views/js/bootstrap.js"></script>
  <!-- App -->
  <script src="vendor-views/js/app.js"></script>
  <script src="vendor-views/js/app.plugin.js"></script>
  <script src="vendor-views/s/slimscroll/jquery.slimscroll.min.js"></script>
  <script>
  /*****  Hide OPT Screen On Load****/ 
 
	 $( document ).ready(function() {
		$('#otpverification').hide(); 
	});
	
	
	
	
    /*****  Login Screen check*****/ 
    $('#store_registartion').submit(function(e){
      e.preventDefault();
      var fd = new FormData(jQuery("#store_registartion")[0]); 
      $.ajax({
        type:'POST',
        url : 'check-vendor-login.php',
        data:fd,
        success : function(response){
          response = JSON.parse(response);
          console.log(response);
          // return false; 
		  // alert(response.message);
          if(response.message =="Already registered"){
              $("#err_login").html('<p style="color:#f20808;margin-bottom: 10px;text-align:center"><b>You are already registered. Please Login...</b></p>'); 
            }else { 
				$("#loginscreen").hide();  
				$("#otpverification").show();  
				$("#confirm_OTP").val(response.otp); 
				$("#confirm_mobile").val(response.mobile_no);  
				$('#vendor_mobi').html(response.mobile_no);  
            } 
        },
        cache: false,
        contentType: false,
        processData: false 
      }); 
    });

	
	
	
	
	
	
	
	
    /*****  OTP Verify Screen check*****/ 
    $('#check_vendor_otp').submit(function(e){
		 e.preventDefault();
		 var entered_otp	=	$('#otp').val(); 
		 var confirm_otp 	=	$('#confirm_OTP').val(); 
		 var confirm_mobile =	$('#confirm_mobile').val(); 
		 if(entered_otp!=confirm_otp){
			$("#err_otp").html('<p style="color:#f20808;margin-bottom: 10px;text-align:center"><b>OTP Mismatch</b></p>'); 
		 } else{ 
			  var fd = new FormData(jQuery("#check_vendor_otp")[0]); 
			  $.ajax({
				type:'POST',
				url : 'check-vendor-login.php',
				data:fd,
				success : function(response){
				  response = JSON.parse(response);
				  console.log(response);
				  // return false; 
				  // alert(response.message);
				  if(response =="Invalid"){
					  $("#err_login").html('<p style="color:#f20808;margin-bottom: 10px;text-align:center"><b>Something went wrong. Please try again...</b></p>'); 
					}else{
						$("#check_vendor_otp").hide();   
						$("#verify_success").html('<p style="color:green;margin-bottom: 10px;text-align:center"><b>Mobile number verified successfully. <a href="index.php">Please Login </a></b></p>'); 
					}
				},
				cache: false,
				contentType: false,
				processData: false 
			  }); 
		 
		 }
    });


	
	</script>
	
	
	
	
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




</body>
</html>