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
	
	$brand_details 		= $obj_user->get_brand_details_of_customer($_GET['customer_type'],$_GET['user_id']);
	
	if(isset($_POST['tm_interaction'])){
		//echo "<br><pre>";print_r($_POST);die;
		$sliced_arr 			= array_slice($_POST, 0, -8, true);
				
		if(!empty($_POST['transaction_service_experience'])){
			foreach($sliced_arr as $key => $value){
				$tse_arr 		 	= explode("_",$value);
				$qid_arr 			= array();
				$qid_arr 			= $tse_arr[0];
				$qid_arr1[]			= $qid_arr;
				
				$get_cqa_data 		= $obj_user->get_question_answer_for_landing_page($_GET['user_id'],$tse_arr[0]);
				if(!empty($get_cqa_data)){
					$update_cqa 	= $obj_user->update_customer_question_answer($_GET['user_id'],$tse_arr);
				}else{
					$update_cqa 	= $obj_user->insert_customer_question_answer($_GET,$tse_arr,$brand_name);
				}
			}
			
			$qid_string				= implode(",",$qid_arr1);
			$previous_qsn_ans 		= $obj_user->get_answered_qsn_without_current_qsn($_GET['user_id'],$qid_string);			
			
			// Profile Things
		
			$getQA 					= $obj_user->getQA($_GET['customer_type'],$_GET['user_id']);
			$parent_group_result 	= array();
			foreach ($getQA as $key1 => $value1) {
				$parent_group 		= $value1['qa_parent_group_level'];
				if (!isset($parent_group_result[$parent_group])){ 
					$parent_group_result[$parent_group] = array();
				}
				$parent_group_result[$parent_group][] = $value1;
			}
			$group_subgroup_result 	= array();
			foreach($parent_group_result as $key2 => $value2){
				foreach($value2 as $key3 => $value3){
					$sub_parent_group 	= $value3['qa_group_level'];
					if (!isset($group_subgroup_result[$key2][$sub_parent_group])){ 
						$group_subgroup_result[$key2][$sub_parent_group] = array();
					}
					$group_subgroup_result[$key2][$sub_parent_group][] = $value3;
				}
			}
				
			$existing_profile_status 	= $obj_user->get_existing_profile_status_of_customer($brand_name,$_GET['user_id']);
			$existing_category  	 	= $existing_profile_status['profile_type'];
			include 'profile_calculation_out.php';
			$profile_cal 				= calculate_profile($group_subgroup_result); 
			$selling_customer_category	= $profile_cal['selling_customer_category'];
			
			$timeline_data		= array(
										'tm_brand_user_id' 		=> $_POST['tm_brand_user_id'],
										'tm_brand_customer_id' 	=> $_POST['tm_brand_customer_id'],
										'tm_brand_name' 		=> $brand_name,
										'tm_brand_id' 			=> $_POST['tm_brand_id'],
										'tm_brand_user_phone' 	=> $_POST['tm_brand_user_phone'],
										'tm_interaction' 		=> $_POST['tm_interaction'],
										'tm_interaction_type' 	=> $_POST['tm_interaction_type'],
										'tm_customer_comment' 	=> $_POST['transaction_comment'],
										'tm_movement_from' 		=> $existing_category,
										'tm_movement_to' 		=> $selling_customer_category,
										'tm_transaction_type' 	=> 'Customer feedback received',
										'tm_created_date' 		=> date('Y-m-d')
										);
			
			$response 			= $obj_user->insert_transaction_lifecycle_data($timeline_data);
			
			// Profile History Data Insertion
			
			foreach($sliced_arr as $key => $value4){
				$tse_arr 		 	= explode("_",$value4);
				$pfl_data 							= array();
				$pfl_data['ph_qid']					= $tse_arr[0];
				$pfl_data['ph_answer']				= $tse_arr[1];
				$pfl_data['ph_weightage']			= $tse_arr[2];
				//$pfl_data['ph_timeline_id']			= 100;//$response;
				$pfl_data['ph_timeline_id']			= $response;
				$pfl_data['ph_user_id']				= $_POST['tm_brand_user_id'];
				$pfl_data['ph_brand_id']			= $_POST['tm_brand_id'];
				$pfl_data['ph_user_phone']			= $_POST['tm_brand_user_phone'];
				$pfl_data['ph_brand_customer_id']  	= $_POST['tm_brand_customer_id'];
				$pfl_data['ph_brand_name']  		= $brand_name;
				$pfl_data['ph_created_date']  		= date('Y-m-d H:i:s');
				$pfl_data['ph_updated_date']  		= date('Y-m-d H:i:s');
				$pfl_data['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
				$pfl_data['ph_email']				= $brand_details['email'];
				$pfl_data['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
				
				$pfl_data1[] 						= $pfl_data;
			}
			foreach($previous_qsn_ans as $key3 => $value3){
				$pfl_data2 							= array();
				$pfl_data2['ph_qid']				= $value3['cqa_qid'];
				$pfl_data2['ph_answer']				= $value3['cqa_answer'];
				$pfl_data2['ph_weightage']			= $value3['cqa_weightage'];
				//$pfl_data2['ph_timeline_id']		= 100;//$response;
				$pfl_data2['ph_timeline_id']		= $response;
				$pfl_data2['ph_user_id']			= $_POST['tm_brand_user_id'];
				$pfl_data2['ph_brand_id']			= $_POST['tm_brand_id'];
				$pfl_data2['ph_user_phone']			= $_POST['tm_brand_user_phone'];
				$pfl_data2['ph_brand_customer_id']  = $_POST['tm_brand_customer_id'];
				$pfl_data2['ph_brand_name']  		= $brand_name;
				$pfl_data2['ph_created_date']  		= date('Y-m-d H:i:s');
				$pfl_data2['ph_updated_date']  		= date('Y-m-d H:i:s');
				$pfl_data2['ph_customer_name']		= $brand_details['CUSTOMER_NAME'];
				$pfl_data2['ph_email']				= $brand_details['email'];
				$pfl_data2['ph_customer_area']		= $brand_details['CUSTOMER_AREA'];
				
				$pfl_data3[] 						= $pfl_data2;
			}
			
			$merged_pfl_arr 						= array_merge($pfl_data1,$pfl_data3);
			foreach($merged_pfl_arr as $key5 => $value5){
				$ph_response						= $obj_user->insert_profile_history($value5);
			}
			
			// Update Profile-Type in Brand Table
			$set_array_brand = array('profile_type' => $selling_customer_category);
			$response2  = $obj_user->updateProfileInBrand($brand_name,$set_array_brand,$_POST['tm_brand_customer_id'],$_POST['tm_brand_user_id']);
									
		}
		 
		if($response){
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
        <div class="row"></div>
      </div>
    </div>
  </div>
</header>

<!-- Contact Section -->
<div id="contact">
  <div class="container">
    <div class="col-md-8">
      <form action="" name="sentMessage" id="contactForm" method="POST">
		
		<?php if($_GET['customer_type'] == 1) { ?>
        <div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>How satisfied are you with the quality of service provided by the technician ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="28_answer1_5_Very Satisfied" name="transaction_service_experience">Very Satisfied
				</label>
				<label class="radio-inline">
				  <input type="radio" value="28_answer2_4_Satisfied" name="transaction_service_experience">Satisfied
				</label>
				<label class="radio-inline">
				  <input type="radio" value="28_answer3_3_Neutral" name="transaction_service_experience">Neutral
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="28_answer4_2_Unsatisfied" name="transaction_service_experience">Unsatisfied
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="28_answer5_1_Very Unsatisfied" name="transaction_service_experience">Very Unsatisfied
				</label>
			  </div>
			</div>
	    </div>
		</br>
		<div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>How likley are you to recommned Bluestar product to your friend on scale of 5 ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="35_answer1_5_Definetly Yes" name="transaction_brand_experience">Definetly Yes
				</label>
				<label class="radio-inline">
				  <input type="radio" value="35_answer2_4_Probably Yes" name="transaction_brand_experience">Probably Yes
				</label>
				<label class="radio-inline">
				  <input type="radio" value="35_answer3_3_May or may Not" name="transaction_brand_experience">May or may Not
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="35_answer4_2_Probably Not" name="transaction_brand_experience">Probably Not
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="35_answer5_1_Definetily Not" name="transaction_brand_experience">Definetily Not
				</label>
			  </div>
			</div>
	    </div>
		</br>
		<div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>Do you often talk about positive and negative things about brands and products with your friends ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="38_answer1_1_Never" name="transaction_referal_experience">Never
				</label>
				<label class="radio-inline">
				  <input type="radio" value="38_answer2_2_Really" name="transaction_referal_experience">Really
				</label>
				<label class="radio-inline">
				  <input type="radio" value="38_answer3_3_Sometime" name="transaction_referal_experience">Sometime
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="38_answer4_4_Often" name="transaction_referal_experience">Often
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="38_answer5_5_Regularly" name="transaction_referal_experience">Regularly
				</label>
			  </div>
			</div>
	    </div>
		
		<?php } ?>
		
		<?php if($_GET['customer_type'] == 2) { ?>
        <div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>How satisfied are you with the quality of service provided by the technician ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="45_answer1_5_Very Satisfied" name="transaction_service_experience">Very Satisfied
				</label>
				<label class="radio-inline">
				  <input type="radio" value="45_answer2_4_Satisfied" name="transaction_service_experience">Satisfied
				</label>
				<label class="radio-inline">
				  <input type="radio" value="45_answer3_3_Neutral" name="transaction_service_experience">Neutral
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="45_answer4_2_Unsatisfied" name="transaction_service_experience">Unsatisfied
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="45_answer5_1_Very Unsatisfied" name="transaction_service_experience">Very Unsatisfied
				</label>
			  </div>
			</div>
	    </div>
		</br>
		<div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>How likley are you to recommned Bluestar product to your friend on scale of 5 ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="52_answer1_5_Definetly Yes" name="transaction_brand_experience">Definetly Yes
				</label>
				<label class="radio-inline">
				  <input type="radio" value="52_answer2_4_Probably Yes" name="transaction_brand_experience">Probably Yes
				</label>
				<label class="radio-inline">
				  <input type="radio" value="52_answer3_3_May or may Not" name="transaction_brand_experience">May or may Not
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="52_answer4_2_Probably Not" name="transaction_brand_experience">Probably Not
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="52_answer5_1_Definetily Not" name="transaction_brand_experience">Definetily Not
				</label>
			  </div>
			</div>
	    </div>
		</br>
		<div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>Do you often talk about positive and negative things about brands and products with your friends ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="55_answer1_1_Never" name="transaction_referal_experience">Never
				</label>
				<label class="radio-inline">
				  <input type="radio" value="55_answer2_2_Really" name="transaction_referal_experience">Really
				</label>
				<label class="radio-inline">
				  <input type="radio" value="55_answer3_3_Sometime" name="transaction_referal_experience">Sometime
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="55_answer4_4_Often" name="transaction_referal_experience">Often
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="55_answer5_5_Regularly" name="transaction_referal_experience">Regularly
				</label>
			  </div>
			</div>
	    </div>
		
		<?php } ?>
		
		<?php if($_GET['customer_type'] == 3) { ?>
        <div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>How satisfied are you with the quality of service provided by the technician ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="62_answer1_5_Very Satisfied" name="transaction_service_experience">Very Satisfied
				</label>
				<label class="radio-inline">
				  <input type="radio" value="62_answer2_4_Satisfied" name="transaction_service_experience">Satisfied
				</label>
				<label class="radio-inline">
				  <input type="radio" value="62_answer3_3_Neutral" name="transaction_service_experience">Neutral
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="62_answer4_2_Unsatisfied" name="transaction_service_experience">Unsatisfied
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="62_answer5_1_Very Unsatisfied" name="transaction_service_experience">Very Unsatisfied
				</label>
			  </div>
			</div>
	    </div>
		</br>
		<div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>How likley are you to recommned Bluestar product to your friend on scale of 5 ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="69_answer1_5_Definetly Yes" name="transaction_brand_experience">Definetly Yes
				</label>
				<label class="radio-inline">
				  <input type="radio" value="69_answer2_4_Probably Yes" name="transaction_brand_experience">Probably Yes
				</label>
				<label class="radio-inline">
				  <input type="radio" value="69_answer3_3_May or may Not" name="transaction_brand_experience">May or may Not
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="69_answer4_2_Probably Not" name="transaction_brand_experience">Probably Not
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="69_answer5_1_Definetily Not" name="transaction_brand_experience">Definetily Not
				</label>
			  </div>
			</div>
	    </div>
		</br>
		<div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>Do you often talk about positive and negative things about brands and products with your friends ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="72_answer1_1_Never" name="transaction_referal_experience">Never
				</label>
				<label class="radio-inline">
				  <input type="radio" value="72_answer2_2_Really" name="transaction_referal_experience">Really
				</label>
				<label class="radio-inline">
				  <input type="radio" value="72_answer3_3_Sometime" name="transaction_referal_experience">Sometime
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="72_answer4_4_Often" name="transaction_referal_experience">Often
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="72_answer5_5_Regularly" name="transaction_referal_experience">Regularly
				</label>
			  </div>
			</div>
	    </div>
		
		<?php } ?>
		
		<?php if($_GET['customer_type'] == 4) { ?>
        <div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>How satisfied are you with the quality of service provided by the technician ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="7_answer1_5_Very Satisfied" name="transaction_service_experience">Very Satisfied
				</label>
				<label class="radio-inline">
				  <input type="radio" value="7_answer2_4_Satisfied" name="transaction_service_experience">Satisfied
				</label>
				<label class="radio-inline">
				  <input type="radio" value="7_answer3_3_Neutral" name="transaction_service_experience">Neutral
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="7_answer4_2_Unsatisfied" name="transaction_service_experience">Unsatisfied
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="7_answer5_1_Very Unsatisfied" name="transaction_service_experience">Very Unsatisfied
				</label>
			  </div>
			</div>
	    </div>
		</br>
		<div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>How likley are you to recommned Bluestar product to your friend on scale of 5 ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="14_answer1_5_Definetly Yes" name="transaction_brand_experience">Definetly Yes
				</label>
				<label class="radio-inline">
				  <input type="radio" value="14_answer2_4_Probably Yes" name="transaction_brand_experience">Probably Yes
				</label>
				<label class="radio-inline">
				  <input type="radio" value="14_answer3_3_May or may Not" name="transaction_brand_experience">May or may Not
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="14_answer4_2_Probably Not" name="transaction_brand_experience">Probably Not
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="14_answer5_1_Definetily Not" name="transaction_brand_experience">Definetily Not
				</label>
			  </div>
			</div>
	    </div>
		</br>
		<div class="row">
			<div class="form-group">
			  <div class="col-md-12">
				<h5>Do you often talk about positive and negative things about brands and products with your friends ?</h5></br>
				<label class="radio-inline">
				  <input type="radio" value="17_answer1_1_Never" name="transaction_referal_experience">Never
				</label>
				<label class="radio-inline">
				  <input type="radio" value="17_answer2_2_Really" name="transaction_referal_experience">Really
				</label>
				<label class="radio-inline">
				  <input type="radio" value="17_answer3_3_Sometime" name="transaction_referal_experience">Sometime
				</label>
				<label class="radio-inline unsatisfied">
				  <input type="radio" value="17_answer4_4_Often" name="transaction_referal_experience">Often
				</label>
				<label class="radio-inline hunsatisfied">
				  <input type="radio" value="17_answer5_5_Regularly" name="transaction_referal_experience">Regularly
				</label>
			  </div>
			</div>
	    </div>
		
		<?php } ?>
		
		<?php if($_GET['customer_type'] == 5) { ?>
			<div class="row">
				<div class="form-group">
				  <div class="col-md-12">
					<h5>How satisfied are you with the quality of service provided by the technician ?</h5></br>
					<label class="radio-inline">
					  <input type="radio" value="79_answer1_5_Very Satisfied" name="transaction_service_experience">Very Satisfied
					</label>
					<label class="radio-inline">
					  <input type="radio" value="79_answer2_4_Satisfied" name="transaction_service_experience">Satisfied
					</label>
					<label class="radio-inline">
					  <input type="radio" value="79_answer3_3_Neutral" name="transaction_service_experience">Neutral
					</label>
					<label class="radio-inline unsatisfied">
					  <input type="radio" value="79_answer4_2_Unsatisfied" name="transaction_service_experience">Unsatisfied
					</label>
					<label class="radio-inline hunsatisfied">
					  <input type="radio" value="79_answer5_1_Very Unsatisfied" name="transaction_service_experience">Very Unsatisfied
					</label>
				  </div>
				</div>
			</div>
			</br>
			<div class="row">
				<div class="form-group">
				  <div class="col-md-12">
					<h5>How likley are you to recommned Bluestar product to your friend on scale of 5 ?</h5></br>
					<label class="radio-inline">
					  <input type="radio" value="86_answer1_5_Definetly Yes" name="transaction_brand_experience">Definetly Yes
					</label>
					<label class="radio-inline">
					  <input type="radio" value="86_answer2_4_Probably Yes" name="transaction_brand_experience">Probably Yes
					</label>
					<label class="radio-inline">
					  <input type="radio" value="86_answer3_3_May or may Not" name="transaction_brand_experience">May or may Not
					</label>
					<label class="radio-inline unsatisfied">
					  <input type="radio" value="86_answer4_2_Probably Not" name="transaction_brand_experience">Probably Not
					</label>
					<label class="radio-inline hunsatisfied">
					  <input type="radio" value="86_answer5_1_Definetily Not" name="transaction_brand_experience">Definetily Not
					</label>
				  </div>
				</div>
			</div>
			</br>
			<div class="row">
				<div class="form-group">
				  <div class="col-md-12">
					<h5>Do you often talk about positive and negative things about brands and products with your friends ?</h5></br>
					<label class="radio-inline">
					  <input type="radio" value="89_answer1_1_Never" name="transaction_referal_experience">Never
					</label>
					<label class="radio-inline">
					  <input type="radio" value="89_answer2_2_Really" name="transaction_referal_experience">Really
					</label>
					<label class="radio-inline">
					  <input type="radio" value="89_answer3_3_Sometime" name="transaction_referal_experience">Sometime
					</label>
					<label class="radio-inline unsatisfied">
					  <input type="radio" value="89_answer4_4_Often" name="transaction_referal_experience">Often
					</label>
					<label class="radio-inline hunsatisfied">
					  <input type="radio" value="89_answer5_5_Regularly" name="transaction_referal_experience">Regularly
					</label>
				  </div>
				</div>
			</div>
			
		<?php } ?>
		
		</br>
		
        <div class="form-group">
          <textarea id="transaction_comment" name="transaction_comment" class="form-control" rows="4" placeholder="Any valuable comment"></textarea>
          <p class="help-block text-danger"></p>
        </div>
		
		<input type="hidden" name="tm_interaction" value="Landing Page" />
		<input type="hidden" name="tm_interaction_type" value="15" />
		<input type="hidden" name="tm_brand_user_id" value="<?php echo $_GET['user_id'];?>" />
		<input type="hidden" name="tm_brand_customer_id" value="<?php echo $_GET['brand_customer_id'];?>" />
		<input type="hidden" name="tm_brand_id" value="<?php echo $_GET['customer_type'];?>" />
		<input type="hidden" name="tm_brand_user_phone" value="<?php echo $_GET['user_phone'];?>" />
		<input type="hidden" name="tm_brand_name" value="<?php echo $brand_name;?>" />
		
        <div id="success"></div>
        <button type="submit" class="btn btn-custom btn-lg">SUBMIT</button>
		
      </form>
    </div>
	
	<div class="col-md-4"></div>
	
  </div>
</div>

<div id="footer">
  <div class="container text-center">
    <div><p>&copy; 2018 <a href="http://yapnaa.com">Yapnaa</a>. All rights reserved.</p></div>
  </div>
</div>
</body>

</html>
