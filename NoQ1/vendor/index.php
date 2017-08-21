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
      <section class="panel panel-default bg-white m-t-lg" id="loginscreen">
        <header class="panel-heading text-center">
          <strong>Sign in</strong>
        </header>
        <form name="check_vendor_login" id="check_vendor_login" method="POST" class="panel-body wrapper-lg">
		 <div id="err_login"></div>
          <div class="form-group">
            <label class="control-label">Email Id</label>
           <!-- <input type="text" placeholder="99********" name="vendor_mobile_no"   value="8970124084" class="form-control input-lg"    data-type="phone" data-required="true" maxlength ="10" onchange="validate_phonenumber(this);" placeholder="Enter Mobile Number" oninput="if(value.length>10)value=value.slice(0,10)" onkeyup="this.value=this.value.replace(/[^\d]/,'')" required>-->
		   <input type="text" placeholder="vendor@gmail.com" name="vendor_mobile_no"   value="vajidattar.jjbytes@gmail.com" class="form-control input-lg"  />
          </div>
          <div class="form-group">
            <label class="control-label">Password</label>
            <input type="password" id="inputPassword" placeholder="Password" name="vendor_password"   value="1234" class="form-control input-lg" data-required="true"   required>
          </div>   
		  
		    <a href="forgot-password.php" class="pull-right m-t-xs"><small>Forgot password?</small></a>
			<input id="submit" onclick="myFunction()" type="submit" name="vendor_login" class="btn btn-success"  value="Sign in"> 
		  
		   
          <div class="line line-dashed"></div>
          <p class="text-muted text-center"><small>You have not registred your shop? </small></p>
          <a href="register.php" class="btn btn-info btn-block">Register now !!</a>
        </form>
      </section>
	  
	  
	  
	  
	  <!--OTP verification-->
	  <section class="panel panel-default bg-white m-t-lg" id="otpverification">
        <header class="panel-heading text-center">
          <strong>Account verification</strong>
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
  <!-- footer  -->
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
    $('#check_vendor_login').submit(function(e){
      e.preventDefault();
      var fd = new FormData(jQuery("#check_vendor_login")[0]); 
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
              $("#err_login").html('<p style="color:#f20808;margin-bottom: 10px;text-align:center"><b>Invlaid mobile no or password</b></p>'); 
            }else if(response.message == "Not verifed"){ 
				$("#loginscreen").hide();  
				$("#otpverification").show();  
				$("#confirm_OTP").val(response.otp); 
				$("#confirm_mobile").val(response.mobile_no);  
				$('#vendor_mobi').html(response.mobile_no);  
            }else{
				window.location.assign("vendor-views/index.php");
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
				  console.log(response);
				  // return false; 
				  // alert(response.message);
				  if(response =="Invalid"){
					  $("#err_login").html('<p style="color:#f20808;margin-bottom: 10px;text-align:center"><b>Something went wrong. Please try again...</b></p>'); 
					}else{
						$("#check_vendor_otp").hide();   
						$("#verify_success").html('<p style="color:green;margin-bottom: 10px;text-align:center"><b>Account verified successfully. <a href="index.php">Please Login </a></b></p>'); 
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