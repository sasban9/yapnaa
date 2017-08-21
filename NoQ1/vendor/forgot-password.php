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
          <strong>Forgot Password?</strong>
        </header>
        <form name="forgot_password" id="forgot_password" method="POST" class="panel-body wrapper-lg">
		 <div id="err_login"></div>
          <div class="form-group">
            <label class="control-label">Email Id</label>
           <!-- <input type="text" placeholder="99********" name="forgot_vendor_mobile_no"   value="8970124084" class="form-control input-lg"    data-type="phone" data-required="true" maxlength ="10" onchange="validate_phonenumber(this);" placeholder="Enter Mobile Number" oninput="if(value.length>10)value=value.slice(0,10)" onkeyup="this.value=this.value.replace(/[^\d]/,'')" required>-->
		   <input type="text" placeholder="99********" name="forgot_vendor_mobile_no"   value="vajidattar.jjbytes@gmail.com" class="form-control input-lg" >
          </div>
          
			<input id="submit" onclick="myFunction()" type="submit" name="vendor_login" class="btn btn-success"  value="Sign in"> 
		  
		   
          <div class="line line-dashed"></div> 
		  <a href="index.php" class="btn btn-info btn-block">Login</a>
        </form>
      </section>
	  
	  
	  
	  
	  <!--OTP verification-->
	  <section class="panel panel-default bg-white m-t-lg" id="otpverification">
        <header class="panel-heading text-center">
          <strong>OTP verification</strong>
        </header>
        <form name="check_vendor_otp" id="check_vendor_otp" method="POST"   class="panel-body wrapper-lg">
		 <div id="err_otp"></div>
         
          <div class="form-group">
            <label class="control-label" style="text-align:center">Verification code hasbeen sent to <span id="vendor_mobi" style="color:green"></span> number.</label>
            <input type="text"  placeholder="Enter OTP" name="forgot_OTP"    id="forgot_OTP" class="form-control input-lg" data-required="true" required>
            <input type="text"  name="confirm_OTP" id="confirm_OTP"    class="form-control input-lg" data-required="true" required>
            <input type="hidden"  name="confirm_mobile" id="confirm_mobile"    class="form-control input-lg" data-required="true" required>
          </div>   
		   <input id="submit"   type="submit" name="vendor_otp_check" class="btn btn-primary"  value="Verify"> 
		   
          <div class="line line-dashed"></div> 
          <a href="index.php" class="btn btn-default btn-block">Login</a>
        </form>
      </section>
	  
	  
	  
	  
	  
	  
	    
	  <!--Reset Password-->
	  <section class="panel panel-default bg-white m-t-lg" id="reset_password_screen">
        <header class="panel-heading text-center">
          <strong>Reset Your Password</strong>
        </header>
		
        <form name="reset_vendor_password" id="reset_vendor_password" method="POST"   class="panel-body wrapper-lg">
		 <div id="err_reset"></div>
         
          <div class="form-group"> 
            <input type="password"  placeholder="Enter Pasword" name="reset_password"    id="reset_password" class="form-control input-lg" data-required="true" required> 
            <input type="hidden"  name="reset_confirm_mobile" id="reset_confirm_mobile"    class="form-control input-lg" data-required="true" required>
          </div>   
		  
		  
		   <div class="form-group">  
            <input type="password"  placeholder="Enter Confirm password" name="conf_reset_password"    id="conf_reset_password" class="form-control input-lg" data-required="true" required>  
          </div> 
		  
		  
		   <input id="submit"   type="submit" name="vendor_otp_check" class="btn btn-primary"  value="Reset"> 
		   
          <div class="line line-dashed"></div> 
          <a href="index.php" class="btn btn-default btn-block">Login</a>
        </form> 
		
		
		<div id="reset_success"></div>
		
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
		$('#reset_password_screen').hide(); 
	});
	
	
	
	
    /*****  Login Screen check*****/ 
    $('#forgot_password').submit(function(e){
      e.preventDefault();
      var fd = new FormData(jQuery("#forgot_password")[0]); 
      $.ajax({
        type:'POST',
        url : 'check-vendor-login.php',
        data:fd,
        success : function(response){
          response = JSON.parse(response);
          console.log(response);
          // return false; 
		  // alert(response.message);
          if(response.message =="Invalid"){
              $("#err_login").html('<p style="color:#f20808;margin-bottom: 10px;text-align:center"><b>This mobile no is not registred with us.</b><br/><b style="color:green">Please Register...</b></p>'); 
            }else if(response.message == "Success"){ 
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
		 var entered_otp	=	$('#forgot_OTP').val(); 
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
						$("#loginscreen").hide();  
						$("#otpverification").hide();  
						$("#reset_password_screen").show();   
						$("#reset_confirm_mobile").val(response.mobile_no);  
						$('#vendor_mobi').html(response.mobile_no);  
					}
				},
				cache: false,
				contentType: false,
				processData: false 
			  }); 
		 
		 }
    });


	
	
	
	
	
	
    /*****  reset password*****/ 
    $('#reset_vendor_password').submit(function(e){
		 e.preventDefault();
		 var reset_password			=	$('#reset_password').val(); 
		 var conf_reset_password	=	$('#conf_reset_password').val(); 
		 var reset_confirm_mobile 	=	$('#reset_confirm_mobile').val();  
		 if(reset_password!=conf_reset_password){
			$("#err_reset").html('<p style="color:#f20808;margin-bottom: 10px;text-align:center"><b>Password Mismatch</b></p>'); 
		 } else{ 
			  var fd = new FormData(jQuery("#reset_vendor_password")[0]); 
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
					  $("#err_reset").html('<p style="color:#f20808;margin-bottom: 10px;text-align:center"><b>Something went wrong. Please try again...</b></p>'); 
					}else{ 
						$("#reset_vendor_password").hide();   
						$("#reset_success").html('<p style="color:green;margin-bottom: 10px;text-align:center"><b>Password changed successfully. <a href="index.php">Please Login </a></b></p>'); 
					}
				},
				cache: false,
				contentType: false,
				processData: false 
			  }); 
		 
		 }
    });

	</script>
</body>
</html>