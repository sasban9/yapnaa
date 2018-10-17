<?php 
   /* error_reporting(E_ALL);
   ini_set("display_errors","On"); */
   
   require_once(__DIR__.'/'.'movilo/controller/user_controller.php');
   
   	$obj_search = new users;
   	if(isset($_POST['d_mobile']) || !empty($_POST['d_mobile'])){
   		 $obj_search->n_yapnaa_login($_POST['d_mobile'],$_POST['d_password']);
   	}
   	?>
<!DOCTYPE html>
<html style="overflow-x: hidden;">
   <head>
      <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-88944414-1"></script>
         <script>
           window.dataLayer = window.dataLayer || [];
           function gtag(){dataLayer.push(arguments);}
           gtag('js', new Date());
         
           gtag('config', 'UA-88944414-1');
         </script> -->
      <!-- Basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
	  <meta name="google-signin-scope" content="profile email">
	  <meta name="google-signin-client_id" content="526013006609-l7ak4o1q6rdqhhovb97bclh94tgdl9qi.apps.googleusercontent.com">
      <title>Yapnaa</title>
      <link rel="shortcut icon" href="../images/yapnaa-fav.png" type="image/x-icon">
      <meta name="description" content="Yapnaa - Your After Sales Companion">
      <meta name="author" content="okler.net">
      <!-- Favicon -->
      <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
      <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
   </head>
   
   <style>
      ::-webkit-input-placeholder {
      font-size: 14px;
      }
      @media (max-width: 768px) {
      .body-css{
      background-position:center center;background-color: #777;
      }
      .bg-box{
      display:none !important;
      }
      .desktop{
      display:none !important;
      }
      .mobile img{
      padding-left: 41px;
      }
      } 
      @media (min-width: 768px){
      .body-css{
      background-image: url('img/Background.jpg'); background-position:center center;
      }
      .lead {
      font-size: 17px !important; 
      }
      .mobile{
      display:none !important;
      }
      }
      .sales{
      margin-top:-5px;
      margin-bottom:30px;
      color:white;
      padding-left:15px;
      font-family: 'Montserrat', sans-serif;
      }
      .inputBox .inputText{
      position: absolute;
      line-height: 50px;
      transition: .5s;
      opacity: .5;
      }
      .ss{
      margin-bottom:54px;
      }
      .dd{
      margin-bottom:20px;
      }
      .inputBox .input{
      position: relative;
      width: 100%;
      color: #795548;
      font-size: 16px;
      height: 50px;
      background: transparent;
      border: none;
      outline: none;
      border-bottom: 1px solid #c7c8c9;
      }
      .ee{
      margin-bottom:5px;
      }
      .as{
      margin-bottom:13px;
      }
      @media screen and (min-width: 980px) {
      .jj
      {
      position:absolute;
      margin-top:250px;
      }
      .btn-c{
      margin-left: -32px;
      }
      .bg-box{
      background-color: #ff6010ba;
      margin-top: 30px;
      height: 567px;
      padding-top: 10px;
      min-width: 34%;
      }
      .lead{
      padding-left:46px;
      }
      }
      @media screen and (max-width: 980px) {
      .jj
      {
      position:absolute;
      margin-top:50px;
      }
      .bg-box{
      background-color: #ff6010ba;
      margin-top: 30px;
      height: 284px;
      padding-top: 2%;
      margin-bottom: 6%;
      min-width: 34%
      }
      .lead{
      padding-left: 3%;
      padding-right: 0% !important;
      }
      }
      .focus .inputText{
      transform: translateY(-30px);
      font-size: 18px;
      opacity: 1;
      color: #00bcd4;
      }
      carousel-inner.item a img, .carousel-inner.item img, .img-responsive, .thumbnail a img, .thumbnail img {
      display: inline;
      }
   </style>
   
   <body class="body-css">
      <div class="row col-md-12" style="margin-left:5px; margin-right:5px;" >
         <div class="col-sm-2"></div>
         <div class="col-md-4" style="background-color: #f5f5f5db;margin-top: 29px;text-align:center; padding:0px 10px 0px 0px; height:567px; padding-top:15px; ">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
               <div class="row" style="margin-right:18px !important;">
                  <div class="col-sm-4"></div>
                  <div class="col-sm-6">
                     <div class="asd desktop" style="margin-bottom: 37px;">
                        <a href="index.php">
                        <img alt="Yapnaa" height="95" width="95" class="img-responsive img-center desktop" src="img/Yapnaa-logo.svg">
                        </a>
                     </div>
                     <div class="asd mobile" style="margin-bottom: 37px;">
                        <a href="index.php">
                        <img alt="Yapnaa" height="95" width="95" class="img-responsive img-center mobile" src="img/Yapnaa-logo.svg">
                        </a>
                     </div>
                     <div class="col-sm-2"></div>
                  </div>
               </div>
               <!-- desktop-->
               <div class="form ">
                  <form  method="post" role="form" class="contactForm ">
                  <div class="form-group ">
                     <div class="row ">
                        <div class="col-sm-8 ">
                           <div class="inputBox " style="width: 256px;margin-bottom:15px;">
                              <input type="text" id="d_mobile" name="d_mobile" placeholder="Mobile" class="input " required>
                           </div>
                        </div>
                     </div>
                     <div class="row ">
                        <div class="col-sm-8 ">
                           <div class="inputBox ss " style="width: 256px;">
                              <input type="password" id="d_password" name="d_password" placeholder="Password" class="input " required>
                           </div>
                        </div>
                     </div>
                     <div class="row ">
                        <div class="col-sm-2 "></div>
                        <div class="col-sm-8 ">
                           <div class="inputBox dd ">
                              <input type="submit" name="" class="button " value="Login" style="border-radius:25px; background-color:#ff6010; width:150px; height:30px; color:white;border:none">
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row ee">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-8">
                     <div class="as">
                        <a href="forgotpassword.php" style="color:#63686d">Forgot Password?</a>
                     </div>
                  </div>
               </div>
               
			   <div class="row">
                  <div class="col-sm-2"></div>
                  <div class="col-md-10 col-sm-8">
                     <div class="as"></div>
                     <div class="as">
						
                        <!-- <a href="#" scope="public_profile,email" class="btn-c" onclick="Login()" id="fbLink"> <img alt="Yapnaa" height="200" width="250"  style="margin-bottom:4px;" class="img-responsive img-center" src="img/facebookAsset 7.svg"></a> -->
                        
						<!-- <a href="" id="google-login-button" class="google-login-button btn-c" style="text-align:center;" data-onsuccess="onSignIn"><img  alt="Yapnaa" height="200" width="250" class="img-responsive img-center" src="img/googleAsset 8.svg"></a> -->
						
						<a href="javascript:void(0);" scope="public_profile,email" class="btn-c" onclick="fbLogin()"> <img alt="Yapnaa" height="200" width="250"  style="margin-bottom:4px;" class="img-responsive img-center" src="img/facebookAsset 7.svg"></a>
						
						<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>

                     </div>
                  </div>
               </div>
               <div class="row">
                  <!--<div class="col-sm-1"></div>-->
                  <div class="col-sm-12">
                     <div class="as">
                        <h5><b>New Here?<a href="signup_new.php"><span style="color:#ff6010"> Create an Account</span></b></a></h5>
                     </div>
                  </div>
               </div>
               <div class="row col-md-12"></div>
               <div class="row col-md-12"></div>
            </div>
         </div>
         <div class="col-md-4  bg-box" >
            <div class="row" style="    margin-top: 3%;">
               <div class="col-xs-6"></div>
               <div class="col-xs-6">
                  <p style="color:#fcfffe;font-family: 'GothamRoundedLight'"><i class="fa fa-envelope" aria-hidden="true"> info@yapnaa.com</i></p>
               </div>
            </div>
            <div class="row jj" >
               <p class="lead" style=" color:white; font-family: 'GothamRoundedLight', sans-serif;">Your  <strong style="margin-bottom:20px; color:white;font-size: 24px;" >After Sales Companion</strong></p>
               <p class="sales lead" style="color:white; font-family: 'GothamRoundedLight', sans-serif;" >
                  Yapnaa offers simple and intuitive mobile<br>
                  interface to manage branded durables and<br>
                  to connect with authorized service center<br>
                  for support in the easiest way. 
            </div>
         </div>
         <div class="col-sm-2"></div>
      </div>
      <div id="fb-root"></div>
   </body>
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   <script src="https://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
   <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
      
   <script type="text/javascript" src="//connect.facebook.net/en_US/all.js#xfbml=1&appId=1977703235808225" id="facebook-jssdk"></script>
   
   <script src="https://apis.google.com/js/platform.js" async defer></script>

   
<script type="text/javascript" >
	
	// Google login start	
	function onSignIn(googleUser) {
		var profile = googleUser.getBasicProfile();
		sendGoogleData(profile);
	};

	function sendGoogleData(profile) {
		var name 	= profile.getName();
		var email 	= profile.getEmail();
		var user_id = profile.getId();
		
		$.ajax({
			url: "googlelogin.php",
			type: "POST",
			dataType: "json",
			data: 'name='+name+'&email='+email+'&user_id='+user_id+' ',
			success: function(response){
				if(response.status == true){
					window.location.assign("movilo/user-dashboard/dashboard.php");
				}else{
					alert('OOPS Some error occured');
				}
			},
			error:function(xhr,status,response){
				
			}
		});
		
	}
    // Google login end

	
	// Facebook login start
	window.fbAsyncInit = function() {
		FB.init({
		  appId      : '1977703235808225',
		  cookie     : true,  
		  xfbml      : true,  
		  version    : 'v2.8' 
		});				
		
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				getFbUserData();
			}
		});
	};
	
	// Load the JavaScript SDK asynchronously
	(function(d, s, id) {
		var js, fjs 	= d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js 				= d.createElement(s); js.id = id;
		js.src 			= "//connect.facebook.net/en_US/sdk.js";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));

	// Facebook login with JavaScript SDK
	function fbLogin() {
		FB.login(function (response) {
			if (response.authResponse) {
				getFbUserData();
			} else {
				document.getElementById('status').innerHTML = 'User cancelled login or did not fully authorize.';
			}
		}, {scope: 'email'});
	}

	// Fetch the user profile data from facebook
	function getFbUserData(){
		FB.api('/me', {locale: 'en_US', fields: 'id,first_name,last_name,email,link,gender,locale,picture'},
		function (response) {
			sendFbData(response);
		});
	}

	// Logout from facebook
	function fbLogout() {
		FB.logout(function() {
			document.getElementById('fbLink').setAttribute("onclick","fbLogin()");
			document.getElementById('fbLink').innerHTML = '<img src="img/facebookAsset 7.svg"/>';
		});
	}
	
	function sendFbData(profile) {
		var name 	= profile.first_name + profile.last_name;
		var email 	= profile.email;
		var user_id = profile.id;
		
		$.ajax({
			url: "facebooklogin.php",
			type: "POST",
			dataType: "json",
			data: 'name='+name+'&email='+email+'&user_id='+user_id+' ',
			success: function(response){
				if(response.status == true){
					window.location.assign("movilo/user-dashboard/dashboard.php");
				}else{
					alert('OOPS Some error occured');
				}
			},
			error:function(xhr,status,response){
				
			}
		});
		
	}
	
	// Facebook login end
		

</script>


</html>