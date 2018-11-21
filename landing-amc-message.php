<?php 
	
	require_once(__DIR__.'/'.'movilo/controller/user_controller.php');
	$obj_user = new users;
	
	switch($_GET['customer_type']) {
		case 1:
		$brand_name	= 'livpure';
		break;
		case 2:
		$brand_name	= 'zerob_consol1';
		break;
		case 3:
		$brand_name	= 'livpure_tn_kl';
		break;
		case 4:
		$brand_name	= 'bluestar_b2b';
		break;
		case 5:
		$brand_name	= 'bluestar_b2c';
		break;
	}
		
		
	if(isset($_POST['req_service_date'])){
		$req_service_date 			= $_POST['req_service_date'];
		$_POST['tm_message1'] 		= "Request a service date on ".$_POST['req_service_date']." ";
		$_POST['tm_created_date']	= date('Y-m-d H:i:s');
		$_POST 	 					= array_slice($_POST, 1);
		
		//echo "<br><pre>";print_r($_POST);die;
		//$response 					= $obj_user->insert_transaction_lifecycle_data($_POST);
		$response1 					= $obj_user->update_service_date_in_brand($req_service_date,$brand_name,$_POST['tm_brand_user_id']);
		if($response1){
			echo "<script>alert('Request Submitted Successfully')</script>";
		}else{
			echo "<script>alert('OOPS Something went wrong')</script>";
		}
		
	}
	
?>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
<link rel="shortcut icon" sizes="16x16" href="https://ssl.gstatic.com/docs/spreadsheets/forms/favicon_qp2.png">
<link rel="stylesheet" href="https://www.gstatic.com/_/freebird/_/ss/k=freebird.v.171fz58gdzfdt.L.W.O/d=1/rs=AMjVe6ja9l0i0FSQznSrC4qIbrcuWmqS4g" data-id="_cl">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700&subset=latin,vietnamese,latin-ext,cyrillic,greek,cyrillic-ext,greek-ext" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Product+Sans&subset=latin,vietnamese,latin-ext,cyrillic,greek,cyrillic-ext,greek-ext" rel="stylesheet" type="text/css">


<style>

	body, html {
	font-family: 'Roboto', sans-serif;
	text-rendering: optimizeLegibility !important;
	-webkit-font-smoothing: antialiased !important;
	color: #777;
	font-weight: 300;
	width: 100% !important;
	height: 100% !important;
}
h2 {
	margin: 0 0 20px 0;
	font-weight: 500;
	font-size: 34px;
	color: #333;
	text-transform: uppercase;
}
img.logo {
    max-width: 100px;
    display: block;
	height: 70px;
	margin-top: -30%;
}

h3 {
	font-size: 22px;
	font-weight: 500;
	color: #333;
}
h4 {
	font-size: 24px;
	text-transform: uppercase;
	font-weight: 400;
	color: #333;
}
h5 {
	/*text-transform: uppercase;*/
	font-weight: 450;
	line-height: 20px;
}
p {
	font-size: 23px;
}
p.intro {
	margin: 12px 0 0;
	line-height: 24px;
}
a {
	color: #333;
	font-weight: 400;
}
a:hover, a:focus {
	text-decoration: none;
	color: #222;
}
ul, ol {
	list-style: none;
}
.clearfix:after {
	visibility: hidden;
	display: block;
	font-size: 0;
	content: " ";
	clear: both;
	height: 0;
}
.clearfix {
	display: inline-block;
}
* html .clearfix {
	height: 1%;
}
.clearfix {
	display: block;
}
ul, ol {
	padding: 0;
	webkit-padding: 0;
	moz-padding: 0;
}
hr {
	height: 4px;
	width: 70px;
	text-align: center;
	position: relative;
	background: #4F80FF;
	margin: 0 auto;
	margin-bottom: 20px;
	border: 0;
}
.btn:active, .btn.active {
	background-image: none;
	outline: 0;
	-webkit-box-shadow: none;
	box-shadow: none;
}
a:focus, .btn:focus, .btn:active:focus, .btn.active:focus, .btn.focus, .btn:active.focus, .btn.active.focus {
	outline: none;
	outline-offset: none;
}
/* Navigation */
#menu {
	padding: 20px;
	transition: all 0.8s;
}
#menu.navbar-default {
	background-color: rgba(248, 248, 248, 0);
	border-color: rgba(231, 231, 231, 0);
}
#menu a.navbar-brand {
	font-size: 22px;
	color: #eee;
	font-weight: 400;
	text-transform: uppercase;
	letter-spacing: 1px;
}
#menu.navbar-default .navbar-nav > li > a {
	text-transform: uppercase;
	color: #a7c44c;
	font-weight: 400;
	font-size: 15px;
	padding: 5px 0;
	border: 2px solid transparent;
	letter-spacing: 0.5px;
	margin: 10px 15px 0 15px;
}
#menu.navbar-default .navbar-nav > li > a:hover {
	color: #eee;
}
.on {
	background-color: #363636 !important;
	padding: 0 !important;
	padding: 10px 0 !important;
}
.navbar-default .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus {
	color: #eee !important;
	background-color: transparent;
}
.navbar-toggle {
	border-radius: 0;
}
.navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
	background-color: #a7c44c;
	border-color: #a7c44c;
}
.navbar-default .navbar-toggle:hover>.icon-bar {
	background-color: #FFF;
}
.section-title {
	margin-bottom: 17px;
}
.section-title p {
	font-size: 18px;
}
.btn-custom {
	text-transform: uppercase;
	color: #fff;
	text-shadow: 0 0 3px #859c3c;
	background-color: #4F80FF;
	border: 0;
	padding: 14px 20px;
	margin: 0;
	font-size: 17px;
	border-radius: 12px 0 12px 0;
	margin-top: 20px;
	transition: all 0.5s;
}
.btn-custom:hover, .btn-custom:focus, .btn-custom.focus, .btn-custom:active, .btn-custom.active {
	color: rgba(255,255,255,0.8);
	background-color: #94ae44;
}
/* Header Section */
.intro {
	display: table;
	width: 100%;
	padding: 0;
	/*background: url(img/bluestar-banner.jpg) no-repeat center bottom;*/
	background-color: #e5e5e5;
	-webkit-background-size: cover;
	-moz-background-size: cover;
	background-size: cover;
	-o-background-size: cover;
}
.intro .overlay {
	background: rgba(0,0,0,0.40);
}
.intro h1 {
	color: #fff;
	font-size: 68px;
	font-weight: 400;
	margin-top: 0;
	margin-bottom: 10px;
	letter-spacing: -1px;
}
.intro span {
	color: #a7c44c;
	font-weight: 600;
}
.intro p {
	color: #fff;
	font-size: 24px;
	font-weight: 300;
	margin-top: 10px;
	margin-bottom: 40px;
}
header .intro-text {
	padding-top: 300px;
	padding-bottom: 200px;
	text-align: center;
}


/* Contact Section */
#contact {
	padding: 40px 0 60px 0;
	background: #F6F6F6;
}
#contact form {
	padding: 30px 0;
}
#contact h3 {
	text-transform: uppercase;
	font-size: 20px;
	font-weight: 400;
	color: #555;
}
#contact .text-danger {
	color: #cc0033;
	text-align: left;
}
label {
	font-size: 12px;
	font-weight: 400;
	font-family: 'Open Sans', sans-serif;
	float: left;
}
#contact .form-control {
	display: block;
	width: 100%;
	padding: 6px 12px;
	font-size: 16px;
	line-height: 1.42857143;
	color: #444;
	background-color: #fff;
	background-image: none;
	border: 1px solid #ddd;
	border-radius: 0;
	-webkit-box-shadow: none;
	box-shadow: none;
	-webkit-transition: none;
	-o-transition: none;
	transition: none;
}
#contact .form-control:focus {
	border-color: #999;
	outline: 0;
	-webkit-box-shadow: transparent;
	box-shadow: transparent;
}
.form-control::-webkit-input-placeholder {
color: #777;
}
.form-control:-moz-placeholder {
color: #777;
}
.form-control::-moz-placeholder {
color: #777;
}
.form-control:-ms-input-placeholder {
color: #777;
}
#contact .contact-item {
	margin: 20px 0 40px 0;
}
#contact .contact-item span {
	font-weight: 400;
	color: #aaa;
	text-transform: uppercase;
	margin-bottom: 6px;
	display: inline-block;
}
#contact .contact-item p {
	font-size: 16px;
}
/* Footer Section*/
#footer {
	background: #333;
	padding: 50px 0 20px 0;
}
#footer .social {
	margin-bottom: 50px;
}
#footer .social ul li {
	display: inline-block;
	margin: 0 20px;
}
#footer .social i.fa {
	font-size: 26px;
	padding: 4px;
	color: #a7c44c;
	transition: all 0.3s;
}
#footer .social i.fa:hover {
	color: #eee;
}
#footer p {
	font-size: 15px;
}
#footer a {
	color: #999;
}
#footer a:hover {
	color: #a7c44c;
}

	
.mysvg {
  display: block;
  text-indent: -9999px;
  width: 200px;
  height: 200px;
  
}

 .h5 {
    font-size: 18px;
 }

@media (max-width: 768px) {
	
	.unsatisfied {
		margin-left:0px !important;
		margin-top: 10px !important;
	}
	
	.hunsatisfied {
		margin-left:34px !important;
		margin-top: 10px !important;
	}
	
	.your-companion {
		margin-top: 30px !important;
	}
	
	#register_here {
		/*margin-left:18%;*/
	}
	
	.intro h1 {
		font-size:42px;
	}
	
}

</style>

<script src="vendor/jquery/jquery.min.js"></script>     
</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

<nav id="menu" class="navbar navbar-default navbar-fixed-top">
  <div class="container"> 
    <div class="navbar-header">
      <a class="navbar-brand page-scroll" href="#">
	  <img src="img/Yapnaa-logo.svg" class="logo">
	  </a> </div>
  </div>
</nav>
<!-- Header -->
<header id="header">
  <div class="intro">
    <div class="overlay">
      <div class="container" style="height: 100px;">
        <div class="row">
          
        </div>
      </div>
    </div>
  </div>
</header>

<!-- Contact Section -->
<div id="contact">
	<div class="container">
		<form action="" name="sentMessage" id="contactForm" method="POST">
			<div class="row">
				<div class="form-group">
				  <div class="col-md-3">
					<h5>What is the overall experience of brand ?</h5></br>
					<input type="date" class="maincls form-control" id="req_service_date"  name="req_service_date" />
				  </div>
				</div>
			</div>
			
			<input type="hidden" name="tm_lifecycle_type" value="amc_message" />
			<input type="hidden" name="tm_brand_user_id" value="<?php echo $_GET['user_id'];?>" />
			<input type="hidden" name="tm_brand_customer_id" value="<?php echo $_GET['brand_customer_id'];?>" />
			<input type="hidden" name="tm_brand_id" value="<?php echo $_GET['customer_type'];?>" />
			<input type="hidden" name="tm_brand_user_phone" value="<?php echo $_GET['user_phone'];?>" />
			<input type="hidden" name="tm_brand_name" value="<?php echo $brand_name;?>" />
			
			<div id="success"></div>
			<button type="submit" class="btn btn-custom btn-lg">SUBMIT</button>
		</form>
	</div>
</div>

<div id="footer">
	<div class="container text-center">
		<div><p>&copy; 2018 <a href="http://yapnaa.com">Yapnaa</a>. All rights reserved.</p></div>
	</div>
</div>

</body>


</html>