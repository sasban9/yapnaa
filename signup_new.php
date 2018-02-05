<?php 
/* error_reporting(E_ALL);
ini_set("display_errors","On"); */

require_once(__DIR__.'/'.'movilo/controller/user_controller.php');

	 $obj_search = new users;
	if(isset($_POST['d_mobile']) || !empty($_POST['d_mobile'])){
		 $obj_search->n_yapnaa_signup($_POST['d_mobile'],$_POST['d_password']);
	}
	?>
<html style="overflow-x: hidden;">
 <head>
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

.inputBox{
	
	width:256px;
}

input.button {
    margin-left: -36%;
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
			 <form action="" method="post" role="form" class="contactForm ">
                <div class="form-group ">
				<div class="row ">
				
					 <div class="col-sm-8 ">
						<div class="inputBox " style="margin-bottom:15px;">
						   <input type="text" name="d_mobile" placeholder="Mobile" class="input " required>
						</div>
					 </div>
				 </div>
				 <div class="row ">
				
					 <div class="col-sm-8 ">
						<div class="inputBox  " style="margin-bottom:15px;">
						   <input type="password" id="d_password" name="d_password" placeholder="Password" class="input " required>
						</div>
					 </div>
				 </div>
				 <div class="row ">
				
					 <div class="col-sm-8 ">
						<div class="inputBox ss " style="">
						   <input type="password" id="d_cpassword" name="d_cpassword" placeholder="Confirm Password" class="input " required>
						   <span id='message'></span>
						</div>
					 </div>
				 </div>
       
                <div class="row ">
				<div class="col-sm-2 "></div>
					 <div class="col-sm-8 ">
						<div class="inputBox dd ">
						   <input type="submit" name="" class="button " value="submit" style="border-radius:25px; background-color:#ff6010; width:150px; height:30px; color:white;border:none">
						</div>
					 </div>
				 </div>
				</div>
				
		  </div>
	
		  
		  
		  
					 <div class="row">
					 
				
					 <div class="col-sm-12">
					 <div class="as">
					<h5><b>Already Have an Account?<a href="login.php"><span style="color:#ff6010"> Login</span></b></a></h5>
					
					 
					 
					 </div>
					 </div>
					 </div>
					<div class="row col-md-12"></div>
					<div class="row col-md-12"></div>
					 </div>
					
		  
 
 
 </div>
 <div class="col-md-4  bg-box" >
	
	
	
	<div class="row" style="    margin-top: 3%;">
	
	<div class="col-xs-6"><p style="color:#fcfffe;font-family: 'GothamRoundedLight'"  ><i class="fa fa-phone" aria-hidden="true"> +91-9845286419</i></p></div>
	<div class="col-xs-6"><p style="color:#fcfffe;font-family: 'GothamRoundedLight'"><i class="fa fa-envelope" aria-hidden="true"> info@yapnaa.com</i></p></div>
	
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
<script type="text/javascript" src="//connect.facebook.net/en_US/all.js#xfbml=1&appId=1490431951079031" id="facebook-jssdk"></script>
<script src="http://code.jquery.com/jquery-1.11.0.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" async defer src="https://apis.google.com/js/api.js" onload="this.onload=function(){};HandleGoogleApiLibrary()" onreadystatechange="if (this.readyState === 'complete') this.onload()"></script>
<script type="text/javascript" >
$('#d_password, #d_cpassword').on('keyup', function () {
  if ($('#d_password').val() == $('#d_cpassword').val()) {
    $('#message').html('Matching').css('color', 'green');
  } else 
    $('#message').html('Not Matching').css('color', 'red');
});

</script>

</html>

