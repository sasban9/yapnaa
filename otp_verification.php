<?php 
 session_start();
//error_reporting(E_ALL);
//ini_set("display_errors","On");
$user_mobile=$_SESSION['user_mobile'];
require_once(__DIR__.'/'.'movilo/controller/user_controller.php');

	 $obj_user = new users;
	if(isset($_POST['d_otp']) && !empty($_POST['d_otp'])){
		 $obj_user->n_yapnaa_otp_verification($_POST['d_otp']);
	}
	if(isset($_POST['resnd_otp']) && !empty($_POST['resnd_otp'])){
		 $obj_user->n_yapnaa_resendotp_verification($user_mobile);
	}
	?>
<html style="overflow-x: hidden;">
   <head>
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-88944414-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-88944414-1');
</script>
      <!-- Basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
text-align:center;
//padding-left:11px;
}
 @media (max-width: 768px) {
		    .body-css{
				 background-position:center center;background-color: #777;
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
.jj
{
	position:absolute;
	margin-top:250px;
	
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
.bg-box{
	
	
	    background-color: #f5f5f5db;
     margin-top: 30px;
     text-align: center;
    padding: 0px 10px 0px 0px;
    height: 500px;
    padding-top: 15px;
}



@media screen and (min-width: 980px) {


.inputBox{
	
	width:256px;
}

input.button {
    margin-left: -59%;
}
}

</style>
<body class="body-css">
<div class="row col-md-12" style="margin-left:5px; margin-right:5px;" >
<div class="col-sm-4"></div>
 <div class="col-md-4 bg-box" >
 <div class="col-sm-2"></div>
 <div class="col-sm-8">
 <div class="row" style="margin-right:18px !important;padding-top:88px">
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
			 <form action="" method="post" role="form" class="contactForm ">
                <div class="form-group ">
				<div class="row ">
				
					 <div class="col-sm-8 ">
						<div class="inputBox " style="margin-bottom:48px;">
						   <input type="text" name="d_otp" placeholder="Enter Opt Verification" class="input ">
						</div>
					 </div>
				 </div>
				 <!--div class="row ">
				
					 <div class="col-sm-8 ">
						<div class="inputBox  " style="width: 256px;margin-bottom:15px;">
						   <input type="password" name="d_password" placeholder="Password" class="input ">
						</div>
					 </div>
				 </div>
				 <div class="row ">
				
					 <div class="col-sm-8 ">
						<div class="inputBox ss " style="width: 256px;">
						   <input type="password" name="d_cpassword" placeholder="Confirm Password" class="input ">
						</div>
					 </div>
				 </div-->
       
                <div class="row ">
				   <div class="col-sm-4 ">
						<div class="inputBox dd ">
						   <input type="submit" name="resnd_otp" class="button " value="Resend Otp" style="border-radius:25px; background-color:#ff6010; width:150px; height:30px; color:white;border:none" >
						</div>
					 </div>
					 <div class="col-sm-2 " style="width: 21%;"></div>
					 <div class="col-sm-4 ">
						<div class="inputBox dd ">
						   <input type="submit" name="" class="button " value="submit" style="border-radius:25px; background-color:#ff6010; width:150px; height:30px; color:white;border:none">
						</div>
					 </div>
				 </div>
				</div>
				
		  </div>
		  
		  <!--div class="row ee">
				<div class="col-sm-2"></div>
					 <div class="col-sm-8">
					 <div class="as">
						 <a href="#" style="color:#63686d">Forgot Password?</a>
					 </div>
				 </div>
</div-->
<!--div class="row">
				<div class="col-sm-2"></div>
					 <div class="col-md-10 col-sm-8">
					 <div class="as">
					 
					 </div>
					  <div class="as">
					 <a href="#" scope="public_profile,email" style="margin-left: -32px; " onclick="Login()"> <img alt="Yapnaa" height="200" width="250"  style="margin-bottom:4px;" class="img-responsive img-center" src="img/facebookAsset 7.svg"></a>
					  <a  href="" id="google-login-button" class="google-login-button" style="text-align:center;margin-left: -32px;"><img  alt="Yapnaa" height="200" width="250" class="img-responsive img-center" src="img/googleAsset 8.svg"></a>
					 </div>
					 </div>
					 
					 
					 </div-->
					 <div class="row">
					 
				<!--<div class="col-sm-1"></div>-->
					 <!--div class="col-sm-12">
					 <div class="as">
					<h5><b>Already Have an Account?<a href="login.php"><span style="color:#ff6010"> Login</span></b></a></h5>
					
					 
					 
					 </div>
					 </div-->
					 </div>
					<div class="row col-md-12"></div>
					<div class="row col-md-12"></div>
					 </div>
					
		  
 
 
 </div>
 <!--div class="col-md-4 " style="background-color:#ff6010ba;
	margin-top: 30px; 
	height:567px; 
	padding-top:10px;min-width: 34%;">
 <div class="row">
 <div class="col-sm-6"></div>
 <div class="col-sm-3"><p style="color:#fcfffe;margin-left:-188px;;margin-top:7px;font-family: 'GothamRoundedLight'"  ><i class="fa fa-phone" aria-hidden="true"> +91-9845286419</i></p></div>
 <div class="col-sm-3"><p style="color:#fcfffe;margin-left: -77px;margin-top:7px;font-family: 'GothamRoundedLight'"><i class="fa fa-envelope" aria-hidden="true"> info@yapnaa.com</i></p></div>
 </div>
 <div class="row jj" >
 <p class="lead" style="padding-left:46px; color:white; font-family: 'GothamRoundedLight', sans-serif;">Your  <strong style="margin-bottom:20px; color:white;font-size: 24px;" >After Sales Companion</strong></p>
 <p class="sales lead" style="padding-left:46px; color:white; font-family: 'GothamRoundedLight', sans-serif;" >
 Yapnaa offers simple and intuitive mobile<br>
 
 interface to manage branded durables and<br>

 to connect with authorized service center<br>
 
 for support in the easiest way. 
 
 </div>
 
 
 

 
 
 </div-->
 <div class="col-sm-4"></div>
 </div>
 <div id="fb-root"></div>
</body>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="//connect.facebook.net/en_US/all.js#xfbml=1&appId=1490431951079031" id="facebook-jssdk"></script>
<script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};HandleGoogleApiLibrary()" onreadystatechange="if (this.readyState === 'complete') this.onload()"></script>
<script type="text/javascript" >
function HandleGoogleApiLibrary() {
gapi.load('client:auth2',  {
callback: function() {
gapi.client.init({
apiKey: 'Q3Ia0Rgpv7rKW7SikLgeolcQ',
clientId: '1037002184931-osjb0bcfml52hao4rmvd95c87vjnjpoi.apps.googleusercontent.com',
scope: 'https://www.googleapis.com/auth/plus.login'
}).then(
function(success) {

}, 
function(error) {

}
);
},
onerror: function() {

}
});
}

// Call login API on a click event
$('.google-login-button').on('click', function() {

// API call for Google login
gapi.auth2.getAuthInstance().signIn().then(
function(success) {


},
function(error) {

}
);
});

gapi.client.request({ path: 'https://www.googleapis.com/plus/v1/people/me' }).then(
function(success) {
var user_info = JSON.parse(success.body);
//console.log(user_info);
},
function(error) {

}
);


function statusChangeCallback(response) {
    console.log('statusChangeCallback');
    console.log(response);
    // The response object is returned with a status field that lets the
    // app know the current login status of the person.
    // Full docs on the response object can be found in the documentation
    // for FB.getLoginStatus().
    if (response.status === 'connected') {
        // Logged into your app and Facebook.
        testAPI();
    } else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        document.getElementById('status').innerHTML = 'Please log ' +
                'into this app.';
    } else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        document.getElementById('status').innerHTML = 'Please log ' +
                'into Facebook.';
    }
}

// This function is called when someone finishes with the Login
// Button.  See the onlogin handler attached to it in the sample
// code below.
function checkLoginState() {
    FB.getLoginStatus(function (response) {
        statusChangeCallback(response);
    });
}

window.fbAsyncInit = function () {
    FB.init({
        appId: '1490431951079031',
        cookie: true, // enable cookies to allow the server to access 
        // the session
        xfbml: true, // parse social plugins on this page
        version: 'v2.2' // use version 2.2
    });

    // Now that we've initialized the JavaScript SDK, we call 
    // FB.getLoginStatus().  This function gets the state of the
    // person visiting this page and can return one of three states to
    // the callback you provide.  They can be:
    //
    // 1. Logged into your app ('connected')
    // 2. Logged into Facebook, but not your app ('not_authorized')
    // 3. Not logged into Facebook and can't tell if they are logged into
    //    your app or not.
    //
    // These three cases are handled in the callback function.

    FB.getLoginStatus(function (response) {
        statusChangeCallback(response);
    });

};

// Load the SDK asynchronously
(function (d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id))
        return;
    js = d.createElement(s);
    js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

// Here we run a very simple test of the Graph API after login is
// successful.  See statusChangeCallback() for when this call is made.
function testAPI() {
    console.log('Welcome!  Fetching your information.... ');
    FB.api('/me', function (response) {
        console.log(JSON.stringify(response));
        console.log('Successful login for: ' + response.name);
        document.getElementById('status').innerHTML =
                'Thanks for logging in, ' + response.name + '!';
    });
}

function Login()
{
    FB.login(function(response) {
       if (response.authResponse) 
       {
	  // alert(response);
            getUserInfo();
        } else 
        {
         console.log('User cancelled login or did not fully authorize.');
        }
     },{scope: 'email,user_photos,user_videos'});
}

function Logout()
{
    FB.logout(function(){document.location.reload();});
}

function getPhoto()
{
    FB.api('/me/picture?type=normal', function(response) {
        var str="<br/><b>Pic</b> : <img src='"+response.data.url+"'/>";
        document.getElementById("status").innerHTML+=str;
    });
}

function getUserInfo() {
//alert('here');
    FB.api('/me', function(response) {
	//console.log(response);
    //var str="<b>Name</b> : "+response.name+"<br>";
   // str +="<b>Link: </b>"+response.link+"<br>";
  //  str +="<b>Username:</b> "+response.username+"<br>";
 //   str +="<b>id: </b>"+response.id+"<br>";
  //  str +="<b>Email:</b> "+response.email+"<br>";
  //  str +="<b>Age range:</b> "+response.age_range+"<br>";
  //  str +="<b>First Name:</b> "+response.first_name+"<br>";
   // str +="<b>Last Name:</b> "+response.last_name+"<br>";


       // document.getElementById("status").innerHTML=str;
        var username_fb = 'name=' +response.name+'&id='+response.id;
		//alert(response.name);
    //alert(username_fb);
        $.ajax({
            url: "facebooklogin.php", //This is the page where you will handle your SQL insert
            type: "get",
            data: username_fb, //The data your sending to some-page.php
			beforeSend: function(){console.log(username_fb);},
            success: function(){
			   alert('Successfully logged in !');
			   sessionStorage.facebookUser = response.name;
			   
			    window.location.assign("index.php");
                //console.log("AJAX request was successfull");
            },
            error:function(xhr,status,response){
			    alert('Failed to logged in !');
               // console.log("AJAX request was a failure"+xhr.status);
            }
        });
    });
}
</script>

</html>

