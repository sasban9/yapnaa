<?php 

require_once("model/model.php");
$obj_model	=new	model;


class admin	{
	
	function __construct(){
		global $obj_model;
		global $tb;
		$this->model=& $obj_model;

	}
	function add_user(){
		date_default_timezone_set('Asia/Kolkata');
		$user_name						=	$_POST['user_name'];
		$user_email				        =	$_POST['user_email'];
		$user_pin					    =	rand(100, 9999);;
		$user_mobile					=	$_POST['user_mobile'];
		$user_created_date		        =	date("l jS \of F Y h:i:s A");
		$table							=	'users';
		
	
		
		
		$fields		=	'*';
		$condition 	=	"user_phone='".$user_mobile."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		// echo'<pre>';print_r($result);exit;
		if(empty($result)){
			$arr_input	=	array(
							'user_name'				        =>	$user_name,
							'user_email_id'					=>	$user_email,
							'user_created_date'			    =>	$user_created_date,
							'user_phone'				    =>	$user_mobile,
							'user_pin'				        =>	md5($user_pin),
							'user_login_type'               =>0,
							'user_address'                  =>'',
							'user_city'                     =>'',
							'user_area_pincode'             =>0,
							'user_gcm_id'                   =>'',
							'user_last_login'               =>'',
							'user_reg_verification_otp'     =>0,
							'user_forgot_otp'               =>0,
							'user_token'					=>rand(1000,9999999),
							'user_status'                   =>1
							);
			$result		=	$this->model->insert($table,$arr_input);
			$message    =   "Dear Customer,\n\nYour credentials is as below.Please download the Yapnaa App and login with the credentials.\n\nUsername: ".$user_mobile."\nPassword: ".$user_pin.".Link:-\n\n https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en";
			$subject    =   "Welcome to Yapnaa";
			$to         =   $user_email;
			$this->send_email($message,$subject,$to);
			$this->send_sms_to_new_user($user_mobile,$message);
			return $result;
			
		
		}else{
			return $result='';
		}
	}
	
	function AMCExpiry_7_Days(){
		$sql =	"SELECT * FROM  `zerob_consol1` WHERE DATE(  `CONTRACT_TO` ) = DATE_ADD( CURDATE( ) , INTERVAL 7 DAY ) ";
		$result		=	$this->model->data_query($sql);	
				
		foreach($result as $row){
			$d 				= 	new DateTime($row['CONTRACT_TO']);
			$expiry_date	=	$d->format('d-M-Y');
			$name 			=	!empty($row['CUSTOMER_NAME'])?$row['CUSTOMER_NAME']:"User";
			//print_r($row);echo "exp<br>".$expiry_date;die;
			$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		   <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			  <!--[if !mso]><!-->
			  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
			  <!--<![endif]-->
			  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
			  
				 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
			  <!--[if (gte mso 9)|(IE)]>
			  <style type="text/css">
				 table {border-collapse: collapse !important;}
			  </style>
			  <![endif]-->
		   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
		   

		   
		   
		   
		   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
			  <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
				 <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
					<tr>
					   <td width="100%">
						  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
							 <!--[if (gte mso 9)|(IE)]>
							 <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
								<tr>
								   <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
									  <![endif]--> 
									  <!-- ======= start main body ======= -->
									  <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
										 <tr>
											<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
											   <!-- ======= start header ======= -->
											   <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
												  <tr>
													 <td>
														<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
														   <tbody>
															  <tr>
																 <td align="center">
																	<center>
																	   <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
																		  <tbody>
																			 <tr>
																				<td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
																				   <!-- ======= start header ======= -->
																				   <table cellpadding="0" cellspacing="0" border="0" width="100%">
																					  <tr>
																						 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
																							<!--[if (gte mso 9)|(IE)]>
																							<table width="100%" style="border-spacing:0" >
																							   <tr>
																								  <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
																										<table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
																										   <tr>
																											  <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="http://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
																										   </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																								  <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
																										<table width="100%" style="border-spacing:0" bgcolor="#ffffff">
																										   <tr>
																											  <td>
																												 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
																													<tr>
																													   <td height="20">&nbsp;</td>
																													</tr>
																												 </table>
																											  </td>
																										   </tr>
																										  <tr>
									<td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
										<tbody><tr>
										  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
											  <tbody><tr>
												<td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="http://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="http://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											 <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											  </tr>
											</tbody></table></td>
										</tr>
									  </tbody></table></td>
								  </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																							   </tr>
																							</table>
																							<![endif]-->
																						 </td>
																					  </tr>
																					  <tr >
																						 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
																							<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
																							   <tr>
																								  <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																							   </tr>
																							</table>
																						 </td>
																					  </tr>
																					  <tr>
																					  </tr>
																				   </table>
																				</td>
																			 </tr>
																		  </tbody>
																	   </table>
																	</center>
																 </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end header ======= --> 
											   <!-- ======= start hero article ======= -->
											   <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="" style="padding-bottom:2%; padding-top:2%;">
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>Dear '.$name.',</b></p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Warm welcome from yapnna team.</p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">AMC for your ZeroB Water Filter expires on '.$expiry_date.', Please contact yapnaa to renew your AMC and continue to enjoy service benefits.</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">
														</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sincerely,</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sriram M.</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Support.Yapnna</p>
														<!-- START BUTTON -->
														<!-- END BUTTON -->
													 </td>
												  </tr>
											   </table>
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center">&nbsp;</td>
												  </tr>
											   </table>
											   <!-- ======= end hero article ======= --> 
											   <center >
												  <table bgcolor="#FFFFFF" width="100%">
													 <tr>
														<td>
														   <table>
															  <tr>
																 <td> &nbsp; &nbsp; <img src="http://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; www.yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="http://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; help@yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="http://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; +91 98452 856419</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
													 </tr>
												  </table>
											   </center>
											   <!-- ======= start divider ======= -->
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;"> &nbsp; </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center"> &nbsp; </td>
												  </tr>
											   </table>
											   <!-- ======= end divider ======= --> 

											</td>
										 </tr>
									  </table>
									  <!--[if (gte mso 9)|(IE)]>
								   </td>
								</tr>
							 </table>
							 <![endif]--> 
							 
							 
																	<!-- ======= start footer ======= -->
											   <table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
														   <tr>
															  <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"> &nbsp; </td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Global Pvt. Ltd.</b></font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After sales companion</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														  
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end footer ======= -->
						  </div>
					   </td>
					</tr>
				 </table>
			  </center>
		   </body>
		</html>

					';
					
				$headers 				= 'MIME-Version: 1.0'. "\r\n";
				$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
				$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
				$headers 			.= 'bcc: sriramm@moviloglobal.com'. "\r\n";
				$subject	=	"AMC Expiry for your ZeroB Water Filter";
				// Mail it
				mail($row['email'], $subject, $message,$headers);
			$sms_message	=	'AMC for your ZeroB Water Filter expires on '.$expiry_date.', Dowload Yapnaa App from http://bit.ly/2kkl44e and renew your AMC';
			$user_numbers	=	array();
			if(isset($row['PHONE1']) && !empty($row['PHONE1'])){
				$user_numbers[]	=	$row['PHONE1'];
			}
			if(isset($row['PHONE2']) && !empty($row['PHONE2'])){
				$user_numbers[]	=	$row['PHONE2'];
			}
			$this->send_bulk_sms($user_numbers,$sms_message);
				
		}
	}
	
	function AMC_Due_Remainder_Last(){
		$sql =	"SELECT * FROM  `zerob_consol1` WHERE DATE(  `CONTRACT_TO` ) = DATE_ADD( CURDATE( ) , INTERVAL 3 MONTH  ) ";
		$result		=	$this->model->data_query($sql);	
				
		foreach($result as $row){
			$d 				= 	new DateTime($row['CONTRACT_TO']);
			$expiry_date	=	$d->format('d-M-Y');
			$name 			=	!empty($row['CUSTOMER_NAME'])?$row['CUSTOMER_NAME']:"User";
			//print_r($row);echo "exp<br>".$expiry_date;die;
			$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		   <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			  <!--[if !mso]><!-->
			  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
			  <!--<![endif]-->
			  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
			  
				 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
			  <!--[if (gte mso 9)|(IE)]>
			  <style type="text/css">
				 table {border-collapse: collapse !important;}
			  </style>
			  <![endif]-->
		   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
		   

		   
		   
		   
		   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
			  <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
				 <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
					<tr>
					   <td width="100%">
						  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
							 <!--[if (gte mso 9)|(IE)]>
							 <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
								<tr>
								   <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
									  <![endif]--> 
									  <!-- ======= start main body ======= -->
									  <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
										 <tr>
											<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
											   <!-- ======= start header ======= -->
											   <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
												  <tr>
													 <td>
														<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
														   <tbody>
															  <tr>
																 <td align="center">
																	<center>
																	   <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
																		  <tbody>
																			 <tr>
																				<td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
																				   <!-- ======= start header ======= -->
																				   <table cellpadding="0" cellspacing="0" border="0" width="100%">
																					  <tr>
																						 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
																							<!--[if (gte mso 9)|(IE)]>
																							<table width="100%" style="border-spacing:0" >
																							   <tr>
																								  <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
																										<table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
																										   <tr>
																											  <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="http://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
																										   </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																								  <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
																										<table width="100%" style="border-spacing:0" bgcolor="#ffffff">
																										   <tr>
																											  <td>
																												 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
																													<tr>
																													   <td height="20">&nbsp;</td>
																													</tr>
																												 </table>
																											  </td>
																										   </tr>
																										  <tr>
									<td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
										<tbody><tr>
										  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
											  <tbody><tr>
												<td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="http://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="http://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											 <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											  </tr>
											</tbody></table></td>
										</tr>
									  </tbody></table></td>
								  </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																							   </tr>
																							</table>
																							<![endif]-->
																						 </td>
																					  </tr>
																					  <tr >
																						 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
																							<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
																							   <tr>
																								  <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																							   </tr>
																							</table>
																						 </td>
																					  </tr>
																					  <tr>
																					  </tr>
																				   </table>
																				</td>
																			 </tr>
																		  </tbody>
																	   </table>
																	</center>
																 </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end header ======= --> 
											   <!-- ======= start hero article ======= -->
											   <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="" style="padding-bottom:2%; padding-top:2%;">
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>Dear '.$name.',</b></p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Warm welcome from yapnna team.</p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">AMC for your ZeroB Water Filter expires on '.$expiry_date.', Please contact yapnaa to renew your AMC and continue to enjoy service benefits.</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">
														</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sincerely,</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sriram M.</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Support.Yapnna</p>
														<!-- START BUTTON -->
														<!-- END BUTTON -->
													 </td>
												  </tr>
											   </table>
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center">&nbsp;</td>
												  </tr>
											   </table>
											   <!-- ======= end hero article ======= --> 
											   <center >
												  <table bgcolor="#FFFFFF" width="100%">
													 <tr>
														<td>
														   <table>
															  <tr>
																 <td> &nbsp; &nbsp; <img src="http://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; www.yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="http://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; help@yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="http://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; +91 98452 856419</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
													 </tr>
												  </table>
											   </center>
											   <!-- ======= start divider ======= -->
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;"> &nbsp; </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center"> &nbsp; </td>
												  </tr>
											   </table>
											   <!-- ======= end divider ======= --> 

											</td>
										 </tr>
									  </table>
									  <!--[if (gte mso 9)|(IE)]>
								   </td>
								</tr>
							 </table>
							 <![endif]--> 
							 
							 
																	<!-- ======= start footer ======= -->
											   <table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
														   <tr>
															  <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"> &nbsp; </td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Global Pvt. Ltd.</b></font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After sales companion</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														  
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end footer ======= -->
						  </div>
					   </td>
					</tr>
				 </table>
			  </center>
		   </body>
		</html>

					';
					
				$headers 				= 'MIME-Version: 1.0'. "\r\n";
				$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
				$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
				$headers 			.= 'bcc: sriramm@moviloglobal.com'. "\r\n";
				$subject	=	"AMC Expiry for your ZeroB Water Filter";
				// Mail it
				mail($row['email'], $subject, $message,$headers);
			$sms_message	=	'AMC for your ZeroB Water Filter expires on '.$expiry_date.', Dowload Yapnaa App from http://bit.ly/2kkl44e and renew your AMC';
			$user_numbers	=	array();
			if(isset($row['PHONE1']) && !empty($row['PHONE1'])){
				$user_numbers[]	=	$row['PHONE1'];
			}
			if(isset($row['PHONE2']) && !empty($row['PHONE2'])){
				$user_numbers[]	=	$row['PHONE2'];
			}
			$this->send_bulk_sms($user_numbers,$sms_message);
				
		}
	}
	function AMC_Due_Remainder_Second(){
		$sql =	"SELECT * FROM  `zerob_consol1` WHERE DATE(  `CONTRACT_TO` ) = DATE_ADD( CURDATE( ) , INTERVAL 6 MONTH  ) ";
		$result		=	$this->model->data_query($sql);	
				
		foreach($result as $row){
			$d 				= 	new DateTime($row['CONTRACT_TO']);
			$expiry_date	=	$d->format('d-M-Y');
			$name 			=	!empty($row['CUSTOMER_NAME'])?$row['CUSTOMER_NAME']:"User";
			//print_r($row);echo "exp<br>".$expiry_date;die;
			$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		   <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			  <!--[if !mso]><!-->
			  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
			  <!--<![endif]-->
			  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
			  
				 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
			  <!--[if (gte mso 9)|(IE)]>
			  <style type="text/css">
				 table {border-collapse: collapse !important;}
			  </style>
			  <![endif]-->
		   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
		   

		   
		   
		   
		   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
			  <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
				 <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
					<tr>
					   <td width="100%">
						  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
							 <!--[if (gte mso 9)|(IE)]>
							 <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
								<tr>
								   <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
									  <![endif]--> 
									  <!-- ======= start main body ======= -->
									  <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
										 <tr>
											<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
											   <!-- ======= start header ======= -->
											   <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
												  <tr>
													 <td>
														<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
														   <tbody>
															  <tr>
																 <td align="center">
																	<center>
																	   <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
																		  <tbody>
																			 <tr>
																				<td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
																				   <!-- ======= start header ======= -->
																				   <table cellpadding="0" cellspacing="0" border="0" width="100%">
																					  <tr>
																						 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
																							<!--[if (gte mso 9)|(IE)]>
																							<table width="100%" style="border-spacing:0" >
																							   <tr>
																								  <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
																										<table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
																										   <tr>
																											  <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="http://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
																										   </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																								  <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
																										<table width="100%" style="border-spacing:0" bgcolor="#ffffff">
																										   <tr>
																											  <td>
																												 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
																													<tr>
																													   <td height="20">&nbsp;</td>
																													</tr>
																												 </table>
																											  </td>
																										   </tr>
																										  <tr>
									<td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
										<tbody><tr>
										  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
											  <tbody><tr>
												<td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="http://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="http://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											 <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											  </tr>
											</tbody></table></td>
										</tr>
									  </tbody></table></td>
								  </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																							   </tr>
																							</table>
																							<![endif]-->
																						 </td>
																					  </tr>
																					  <tr >
																						 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
																							<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
																							   <tr>
																								  <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																							   </tr>
																							</table>
																						 </td>
																					  </tr>
																					  <tr>
																					  </tr>
																				   </table>
																				</td>
																			 </tr>
																		  </tbody>
																	   </table>
																	</center>
																 </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end header ======= --> 
											   <!-- ======= start hero article ======= -->
											   <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="" style="padding-bottom:2%; padding-top:2%;">
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>Dear '.$name.',</b></p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Warm welcome from yapnna team.</p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">AMC for your ZeroB Water Filter expires on '.$expiry_date.', Please contact yapnaa to renew your AMC and continue to enjoy service benefits.</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">
														</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sincerely,</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sriram M.</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Support.Yapnna</p>
														<!-- START BUTTON -->
														<!-- END BUTTON -->
													 </td>
												  </tr>
											   </table>
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center">&nbsp;</td>
												  </tr>
											   </table>
											   <!-- ======= end hero article ======= --> 
											   <center >
												  <table bgcolor="#FFFFFF" width="100%">
													 <tr>
														<td>
														   <table>
															  <tr>
																 <td> &nbsp; &nbsp; <img src="http://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; www.yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="http://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; help@yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="http://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; +91 98452 856419</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
													 </tr>
												  </table>
											   </center>
											   <!-- ======= start divider ======= -->
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;"> &nbsp; </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center"> &nbsp; </td>
												  </tr>
											   </table>
											   <!-- ======= end divider ======= --> 

											</td>
										 </tr>
									  </table>
									  <!--[if (gte mso 9)|(IE)]>
								   </td>
								</tr>
							 </table>
							 <![endif]--> 
							 
							 
																	<!-- ======= start footer ======= -->
											   <table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
														   <tr>
															  <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"> &nbsp; </td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Global Pvt. Ltd.</b></font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After sales companion</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														  
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end footer ======= -->
						  </div>
					   </td>
					</tr>
				 </table>
			  </center>
		   </body>
		</html>

					';
					
				$headers 				= 'MIME-Version: 1.0'. "\r\n";
				$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
				$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
				$headers 			.= 'bcc: sriramm@moviloglobal.com'. "\r\n";
				$subject	=	"AMC Expiry for your ZeroB Water Filter";
				// Mail it
				mail($row['email'], $subject, $message,$headers);
			$sms_message	=	'AMC for your ZeroB Water Filter expires on '.$expiry_date.', Dowload Yapnaa App from http://bit.ly/2kkl44e and renew your AMC';
			$user_numbers	=	array();
			if(isset($row['PHONE1']) && !empty($row['PHONE1'])){
				$user_numbers[]	=	$row['PHONE1'];
			}
			if(isset($row['PHONE2']) && !empty($row['PHONE2'])){
				$user_numbers[]	=	$row['PHONE2'];
			}
			$this->send_bulk_sms($user_numbers,$sms_message);
				
		}
	}
	function AMC_Due_Remainder_First(){
		$sql =	"SELECT * FROM  `zerob_consol1` WHERE DATE(  `CONTRACT_TO` ) = DATE_ADD( CURDATE( ) , INTERVAL 9 MONTH  ) ";
		$result		=	$this->model->data_query($sql);	
				
		foreach($result as $row){
			$d 				= 	new DateTime($row['CONTRACT_TO']);
			$expiry_date	=	$d->format('d-M-Y');
			$name 			=	!empty($row['CUSTOMER_NAME'])?$row['CUSTOMER_NAME']:"User";
			//print_r($row);echo "exp<br>".$expiry_date;die;
			$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">
		   <head>
			  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			  <!--[if !mso]><!-->
			  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
			  <!--<![endif]-->
			  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
			  
				 <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
			  <!--[if (gte mso 9)|(IE)]>
			  <style type="text/css">
				 table {border-collapse: collapse !important;}
			  </style>
			  <![endif]-->
		   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
		   

		   
		   
		   
		   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
			  <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
				 <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
					<tr>
					   <td width="100%">
						  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
							 <!--[if (gte mso 9)|(IE)]>
							 <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
								<tr>
								   <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
									  <![endif]--> 
									  <!-- ======= start main body ======= -->
									  <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
										 <tr>
											<td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
											   <!-- ======= start header ======= -->
											   <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
												  <tr>
													 <td>
														<table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
														   <tbody>
															  <tr>
																 <td align="center">
																	<center>
																	   <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
																		  <tbody>
																			 <tr>
																				<td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
																				   <!-- ======= start header ======= -->
																				   <table cellpadding="0" cellspacing="0" border="0" width="100%">
																					  <tr>
																						 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
																							<!--[if (gte mso 9)|(IE)]>
																							<table width="100%" style="border-spacing:0" >
																							   <tr>
																								  <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
																										<table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
																										   <tr>
																											  <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="http://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
																										   </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																								  <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
																									 <![endif]-->
																									 <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
																										<table width="100%" style="border-spacing:0" bgcolor="#ffffff">
																										   <tr>
																											  <td>
																												 <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
																													<tr>
																													   <td height="20">&nbsp;</td>
																													</tr>
																												 </table>
																											  </td>
																										   </tr>
																										  <tr>
									<td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
										<tbody><tr>
										  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
											  <tbody><tr>
												<td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="http://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
												<td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="http://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											 <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
											  </tr>
											</tbody></table></td>
										</tr>
									  </tbody></table></td>
								  </tr>
																										</table>
																									 </div>
																									 <!--[if (gte mso 9)|(IE)]>
																								  </td>
																							   </tr>
																							</table>
																							<![endif]-->
																						 </td>
																					  </tr>
																					  <tr >
																						 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
																							<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
																							   <tr>
																								  <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
																							   </tr>
																							</table>
																						 </td>
																					  </tr>
																					  <tr>
																					  </tr>
																				   </table>
																				</td>
																			 </tr>
																		  </tbody>
																	   </table>
																	</center>
																 </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end header ======= --> 
											   <!-- ======= start hero article ======= -->
											   <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="" style="padding-bottom:2%; padding-top:2%;">
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>Dear '.$name.',</b></p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Warm welcome from yapnna team.</p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">AMC for your ZeroB Water Filter expires on '.$expiry_date.', Please contact yapnaa to renew your AMC and continue to enjoy service benefits.</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">
														</p>
														<br>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sincerely,</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b style="font-family:cursive">Sriram M.</b></p>
														<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;">Support.Yapnna</p>
														<!-- START BUTTON -->
														<!-- END BUTTON -->
													 </td>
												  </tr>
											   </table>
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center">&nbsp;</td>
												  </tr>
											   </table>
											   <!-- ======= end hero article ======= --> 
											   <center >
												  <table bgcolor="#FFFFFF" width="100%">
													 <tr>
														<td>
														   <table>
															  <tr>
																 <td> &nbsp; &nbsp; <img src="http://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; www.yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="http://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; help@yapnna.com</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
														<td>
														   <table>
															  <tr>
																 <td><img src="http://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
																 <td>
																	<p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> &nbsp; +91 98452 856419</b></p>
																 </td>
															  </tr>
														   </table>
														</td>
													 </tr>
												  </table>
											   </center>
											   <!-- ======= start divider ======= -->
											   <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
												  <tr>
													 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
														<table border="0" cellpadding="0" cellspacing="0" style="" align="left">
														   <tbody>
															  <tr>
																 <td height="20" width="30" style="font-size: 20px; line-height: 20px;"> &nbsp; </td>
															  </tr>
														   </tbody>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td align="center"> &nbsp; </td>
												  </tr>
											   </table>
											   <!-- ======= end divider ======= --> 

											</td>
										 </tr>
									  </table>
									  <!--[if (gte mso 9)|(IE)]>
								   </td>
								</tr>
							 </table>
							 <![endif]--> 
							 
							 
																	<!-- ======= start footer ======= -->
											   <table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
														   <tr>
															  <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;"> &nbsp; </td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Global Pvt. Ltd.</b></font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your After sales companion</font></td>
														   </tr>
														   <tr>
															  <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
														   </tr>
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														</table>
													 </td>
												  </tr>
												  <tr>
													 <td>
														<table width="100%" cellpadding="0" cellspacing="0" border="0">
														   <tr>
															  <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
														   </tr>
														  
														</table>
													 </td>
												  </tr>
											   </table>
											   <!-- ======= end footer ======= -->
						  </div>
					   </td>
					</tr>
				 </table>
			  </center>
		   </body>
		</html>

					';
					
				$headers 				= 'MIME-Version: 1.0'. "\r\n";
				$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
				$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
				$headers 			.= 'bcc: sriramm@moviloglobal.com'. "\r\n";
				$subject	=	"AMC Expiry for your ZeroB Water Filter";
				// Mail it
				mail($row['email'], $subject, $message,$headers);
			$sms_message	=	'AMC for your ZeroB Water Filter expires on '.$expiry_date.', Dowload Yapnaa App from http://bit.ly/2kkl44e and renew your AMC';
			$user_numbers	=	array();
			if(isset($row['PHONE1']) && !empty($row['PHONE1'])){
				$user_numbers[]	=	$row['PHONE1'];
			}
			if(isset($row['PHONE2']) && !empty($row['PHONE2'])){
				$user_numbers[]	=	$row['PHONE2'];
			}
			$this->send_bulk_sms($user_numbers,$sms_message);
				
		}
	}
	function admin_login_val($admin_email_id,$admin_password)
	{
		
		$result	=	$this->model->admin_login_val($admin_email_id,$admin_password);
		return $result;
	}
	
	// Admin Password Update
	function admin_password_update($email_id,$password)
	{
		$table		=	'admin_login';
		$set_array	=	array(
						'admin_password'=> $password
						);
		$condition 	=	"admin_email_id='".$email_id."'";				
		$result	=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	/*Last Login Time date update*/
	function admin_logout($admin_email_id)
	{
		$table		=	'admin_login';
		date_default_timezone_set('Asia/Kolkata');
		$date	=	date("F Y h:i:s A");
		$set_array	=	array(
						'admin_last_login'=> $date
						);
		$condition 	=	"admin_email_id='".$admin_email_id."'";				
		$result	=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
		
	
	
	/*Add the faq*/
	function add_faq()
	{
		date_default_timezone_set('Asia/Kolkata');
		$brdnadid				=	$_POST['brdnadid'];
		$bp_id					=	$_POST['bp_id'];
		$faq					=	$_POST['faq'];
		$opt1					=	$_POST['opt1'];
		$opt2					=	$_POST['opt2'];
		$opt3					=	$_POST['opt2'];
		$opt4					=	$_POST['opt4'];
		$type					=	$_POST['type'];
		$j						=	1;
		for($i=0; $i<count($faq);$i++){
			$srm_question_c_date		=	date("Y-m-d H:i:s");
			$table						=	'srm_questions';

			$arr_input	=	array(
							'srm_question_bp_id'			=>	$bp_id,
							'srm_questions'					=>	$faq[$i],
							'srm_question_opt1'				=>	$opt1[$i],
							'srm_question_opt2'				=>  $opt2[$i],
							'srm_question_opt3'				=>	$opt3[$i],
							'srm_question_opt4'				=>	$opt4[$i],
							'srm_question_type'				=>	$type[$i],
							'srm_question_c_date'			=>	$srm_question_c_date,
							'srm_questions_nos'				=>	$j,
							);
			$result		=	$this->model->insert($table,$arr_input);
			$j++;
		}
		
			return $result;
	}
	
	
	
	
	//Get Faq Information by id
	function get_faq_list()
	{
		$table		=	'srm_questions';	
		$result		=	$this->model->get_faq_list($table);
		return $result;
	}
	
	
	
	//Get Faq deatils Information by id
	function get_faq_list_details($id)
	{
		$table		=	'srm_questions';	
		$condition	=	"srm_question_bp_id	=	$id";
		$result		=	$this->model->get_faq_list_details($table,$condition);
		return $result;
	}
	
	
		
	//Get Faq deatils Information by id
	function get_faq_list_details_edit($id)
	{
		$table		=	'srm_questions';	
		$condition	=	"srm_question_id	=	$id";
		$result		=	$this->model->get_faq_list_details_edit($table,$condition);
		return $result;
	}
	
	
	
	
		/* update_brand update*/
	function update_faq()
	{
		$table		=	'srm_questions';
		$srm_q_id	=	$_POST['id'];
		$faq		=	$_POST['faq'];
		$opt1		=	$_POST['opt1'];
		$opt2		=	$_POST['opt2'];
		$opt3		=	$_POST['opt3'];
		$opt4		=	$_POST['opt4'];
		$type		=	$_POST['type'];
		$set_array	=	array(
						'srm_questions'		=> $faq,
						'srm_question_opt1'	=> $opt1,
						'srm_question_opt2'	=> $opt2,
						'srm_question_opt3'	=> $opt3,
						'srm_question_opt4'	=> $opt4, 
						'srm_question_type'	=> $type, 
						);
		$condition 	=	"srm_question_id='".$srm_q_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	function sent_notifications($user_gcm_arr,$message,$subject){
		
		
        
        $url = 'https://android.googleapis.com/gcm/send';
		
        $fields = array(
		            'registration_ids' => $user_gcm_arr,
		            'data' => array("title" => $subject, "message"=> $message,"id"=>"")
		        );
				
		define("GOOGLE_API_KEY", "AIzaSyDfjQepXPy2GltXwE5ob-h8vw1o5w3pzls"); 
		       
	   $headers = array(
		            'Authorization: key='.GOOGLE_API_KEY,
		            'Content-Type: application/json'
		        );

		$ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL, $url);
		    curl_setopt($ch, CURLOPT_POST, true);
		    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

		$result = curl_exec($ch);
		curl_close($ch);
		       
		        if ($result === FALSE) {
		            die('Curl failed: ' . curl_error($ch));
		        }
				else{
					curl_close($ch);
					return $result;
				} 
	}
	
	
	function send_bulk_sms($user_numbers,$message){ 
		date_default_timezone_set('Asia/Kolkata');
		$today = date("Y-m-d H:i:s");
		if($user_numbers){
			for($i=0;$i<count($user_numbers);$i++){
				if($user_numbers[$i]){
					$ch = curl_init();
					$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_numbers[$i])."&message=".urlencode("".$message."");
					curl_setopt( $ch,CURLOPT_URL, $url );
					curl_setopt( $ch,CURLOPT_POST, false ); 
					curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
					curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
					$result = curl_exec($ch );
					curl_close( $ch );
				}
			}	
		}		
		else{
			return 0;
		}
	}
	function get_standard_comments()
	{
		$table="yapnaa_standard_amc_comment";
		$result		=	$this->model->get_Detail_all($table);
		return $result;
	}
	
	function updateAMC($admin_id,$start,$expire,$custID,$comments,$closedBy,$phone1,$phone2)
	{
		$google_feedback_link="https://goo.gl/forms/D1HvGtyi68EVl11l2";
		$table		=	'zerob_consol1';
		$admin_name		= $_SESSION['admin_name'];
		$ar_id  	        = $_SESSION['ar_id'];
		$set_array	=	array(
							'amc_updated_by'		=> $admin_id,
							'CONTRACT_TO'		    => $expire,
							'CONTRACT_FROM'		    => $start,
							'CONTRACT_BY'		    => $closedBy,
							'last_call_comment'	    => $comments,
							'action_taken_by'	    => $admin_name,
							'action_taken_by_id'    => $ar_id,
							'status'			    =>	"7"
						);
		
		$condition 	=	"id='".$custID."'";				
		$update_zerob_result		=	$this->model->update($table,$set_array,$condition);
		
		
		$table		=	'users';
		$condition 	=	"user_phone=".$phone1." OR user_phone=".$phone2;	
	    $fields		=	'*';
				
		$result1	=	$this->model->get_Details_condition($table,$fields,$condition);		
		
		if($result1){
		
			$sql 		= "SELECT * FROM `users_products` up WHERE `up_product_id` =1 AND up.up_user_id =  ".$result1[0]['user_id']." order by up_created_date asc";
			
			$result		=	$this->model->data_query($sql);
		
			if($result){
				//If the zerob water filter is added, update the AMC date and send notification
				$table			=	"users_products";
				$set_array		=	array('up_warranty_start_date' => $start,'up_warranty_end_date'=>$expire,'up_amc_from_date'  => $start,'up_amc_to_date' =>$expire);
				$condition		=	"up_id = ".$result[0]['up_id'];
				$update_result	=	$this->model->update($table,$set_array,$condition);
				
				//echo json_encode($update_result);die;
				//$message = "AMC for your ZeroB has been updated from ".$start." to ".$expire;
				$username=$result1[0]['user_name'];
				if($username !=NULL)
				{
				$condition_msg="Hi $username,\n\nGreeting from yapnaa!\n\n";
				}
				else
				{
				$condition_msg="Greeting from yapnaa!,\n\n";	
				}
				$message = "<pre>".$condition_msg."Thank you for signing AMC. Kindly share your feedback on our services in the link below :-\n\n".$google_feedback_link.'</pre>';
				$subject = "AMC for your ZeroB Water Filter has been updated";
				
				$not_status = $this->sent_notifications(array($result1[0]['user_gcm_id']),$message,$subject);
				//print_r($not_status);die;
				$to=$result1[0]['user_email_id'];
				$this->send_email($message,$subject,$to);
				return 1;
			}
			else{
				
				$condition 			=	"id='".$custID."'";				
				$zerob_result		=	$this->model->get_Details_condition($table,'*',$condition);
				
				//Add product and send notification
				$prod_details	=		array(
											"up_user_id"				=>		$result1[0]['user_id'],
											"up_product_id"				=>		1,
											"up_amc_from_date"			=>		$start,
											"up_amc_to_date"			=>		$expire,
											"up_warranty_start_date"	=>		$start,
											"up_warranty_end_date"		=>		$expire,
											"up_serial_no"				=>		$zerob_result[0]['PRODUCT_SLNO'],
											"up_date_of_purchase"		=>		$zerob_result[0]['INSTALLATION_DATE'],
											"up_amc"					=>		"Yes",
											"up_product_title"			=>		"ZeroB Water Filter"
								);
				//echo "Here";die;
				$prod_id	=	$this->add_user_product($prod_details);
				$username=$result1[0]['user_name'];
				if($username !=NULL)
				{
				$condition_msg="Hi $username,\n\nGreeting from yapnaa!\n\n";
				}
				else
				{
				$condition_msg="Greeting from yapnaa!,\n\n";	
				}
				$message = "<pre>".$condition_msg."Thank you for signing AMC. Kindly share your feedback on our services in the link below :-\n\n".$google_feedback_link.'</pre>';
				$subject	=	"AMC for your ZeroB Water Filter has been updated";
				
				$not_status = $this->sent_notifications(array($result1[0]['user_gcm_id']),$message,$subject);
				$to=$result1[0]['user_email_id'];
				$this->send_email($message,$subject,$to);
				return 1;
			}
		}
		else{
			$number = array($phone1);
			$message = 'AMC for your ZeroB Water Filter has been updated. Download the Yapnaa app http://bit.ly/2kkl44e to maintain services, AMC and bills for your electronic products.';
			$get_amc_list = $this->send_bulk_sms($number,$message);
			return 1;
		}
		return 0;
	}
	
	function add_user_product($prod_deatils){
		$table		=	"users_products";//print_r($prod_deatils);die;
		$result		=	$this->model->insert($table,$prod_deatils);
		if($result){
			return $result;
		}
		return 0;
	}
	
		/*Delete the faq*/
	function del_faq()
	{
		$table		=	'srm_questions';
		$srm_q_id	=	$_POST['id'];
		$condition	=	"srm_question_id='$srm_q_id'";
		$res		=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	/*Add the add_brand*/
	function add_brand()
	{
		date_default_timezone_set('Asia/Kolkata');
		$brand					=	$_POST['brand'];
		$priority				=	$_POST['priority'];
		$brand_created_date		=	date("l jS \of F Y h:i:s A");
		$table					=	'brands';
		$add_icon				=	'';
		if(!empty($_FILES['icon']['tmp_name']))
			{ 
				// echo "hi";exit;
				$filename = basename($_FILES['icon']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				$now = new DateTime();
				$times = $now->getTimestamp();
				$target = "../../brand-icon/"; 
				//Determine the path to which we want to save this file
				$newname = $target.$times.'-'.$filename;
				$newname1 = $times.'-'.$filename;
				//echo $newname;exit;
				//Check if the file with the same name is already exists on the server
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['icon']['tmp_name'],$newname))) {
							$add_icon=$newname1;
						}else{
							$message	=	"Could not move the file!";
						}
					} 
			}
		
		$arr_input	=	array(
						'brand_name'				=>	$brand,
						'brand_created_date'		=>	$brand_created_date,
						'brand_icon'				=>	$add_icon,
						'brand_priority'			=>	$priority,
						'brand_status'				=>	1
						);
		$result		=	$this->model->insert($table,$arr_input);
		return $result;
	}
	
	
	
	
	
	
	
	
	//Get brands  Information by id
	function get_brand()
	{
		$table		=	'brands';	
		// $order_by	=	'brand_priority';	
		$fields		=	'*';
		$condition 	=	"brand_status='1'";				
		$result		=	$this->model->get_Details_condition($table,$fields,$condition);
		// $result	=	$this->model->get_Detail_all_order_by($table,$order_by);
		return $result;
	}
	
	
	
	
	
	/*Delete the brands*/
	function del_brand()
	{
		$table		=	'brands';
		$brand_id	=	$_POST['id'];
		$condition	=	"brand_id='$brand_id'";
		$res		=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	
	//Get brand  Information by id
	function get_brand_by_id($id)
	{
		$table		=	'brands';
		$fields		=	'*';
		$condition 	=	"brand_id='".$id."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		return $result;
	}
	function updateStatus($id,$comment,$status){
		date_default_timezone_set('Asia/Kolkata');
		$admin_name		= $_SESSION['admin_name'];
		$ar_id  	        = $_SESSION['ar_id'];
		$today = date("Y-m-d H:i:s");
		/*$user_table		    =	'users';
		$user_condition 	=	"user_phone='".$number."'";	
		$user_fields		=	'*';
				
		$user_result1	=	$this->model->get_Details_condition($user_table,$user_fields,$user_condition);	
		if($user_result1 !=NULL)
		{*/
		$set_array = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>$status,
						'last_sms_sent'=>'',
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id
					);
					
		$table		=	'zerob_consol1';
		$condition 	=	"id='".$id."'";	
	    $fields		=	'*';
				
		$result1	=	$this->model->get_Details_condition($table,$fields,$condition);				
		if($result1 !=NULL)
		{
		$result	=	$this->model->update($table,$set_array,$condition);
		}
		else
		{
			$set_array1 = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>$status,
						'last_sms_sent'=>'',
						'id'=>$id,
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id
					);
			$result	=	$this->model->insert($table,$set_array1);
		}
			if($result){
				return 1;
			 }
			 else{
				return 0;
			}
		/*}
		else{
			return 0;
		}*/
	}
	function zerob_appointment_sms($id,$apptDate,$number,$comment){ 
		date_default_timezone_set('Asia/Kolkata');
		$today = date("Y-m-d H:i:s");
		$message	=	"Thanks for confirming your appointment​ for AMC​ of ZeroB Water filter. We look forward to seeing you on ​".$apptDate;
		$user_number = array($number);
		$admin_name		= $_SESSION['admin_name'];
		  $ar_id  	        = $_SESSION['ar_id'];
		//$this->send_user_sms($user_number,$message,$id,$comment);
		
		$time = strtotime($apptDate);
		$newformat = date('Y-m-d H:i:S',$time);
		
		$set_array = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>3,
						'last_sms_sent'=>$message,
						'amc_appointment_datetime'=>$newformat,
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id
					);
					
		$table		=	'zerob_consol1';
		$condition 	=	"id='".$id."'";	
		$fields		=	'*';
				
		$result1	=	$this->model->get_Details_condition($table,$fields,$condition);		
		if($result1 !=NULL)
		{
			$result	=	$this->model->update($table,$set_array,$condition);
		}
		else
		{
			$set_array1 = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>3,
						'last_sms_sent'=>$message,
						'id'=>$id,
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id
					);
			$result	=	$this->model->insert($table,$set_array1);
		}
			if($result){
				return 1;
			  }
			  else{
				return 0;
			}
		/*}
		else{
			return 0;
		}*/
	}
	function zerob_appointment_expiry_sms($id,$apptDate,$number,$comment){ 
		date_default_timezone_set('Asia/Kolkata');
		$today = date("Y-m-d H:i:s");
		$message	=	"AMC for your ZeroB product is expiring on ​".$apptDate.". Register with Yapnaa and renew your AMC. http://bit.ly/2kkl44e";
		$user_number = array($number);
		$admin_name		= $_SESSION['admin_name'];
		 $ar_id  	        = $_SESSION['ar_id'];
		/*$user_table		    =	'users';
		$user_condition 	=	"user_phone='".$number."'";	
		$user_fields		=	'*';
				
		$user_result1	=	$this->model->get_Details_condition($user_table,$user_fields,$user_condition);	
		if($user_result1 !=NULL)
		{*/
		$this->send_user_sms($user_number,$message,$id,$comment);
		
		$set_array = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>6,
						'last_sms_sent'=>$message,
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id 
					);
					
		$table		=	'zerob_consol1';
		$condition 	=	"id='".$id."'";	
        $fields		=	'*';
		
		$result1	=	$this->model->get_Details_condition($table,$fields,$condition);		
		if($result1 !=NULL)
		{
		$result	=	$this->model->update($table,$set_array,$condition);
		}
		else
		{
			$set_array1 = array(
						'last_called'=>$today,
						'last_call_comment'=>$comment,
						'status'=>3,
						'last_sms_sent'=>$message,
						'id'=>$id,
						'action_taken_by'=>$admin_name,
						'action_taken_by_id'=>$ar_id 
					);
			$result	=	$this->model->insert($table,$set_array1);
		}
			if($result){
				return 1;
			 }
			 else{
				return 0;
			}
		/*}
		else{
			return 0;
		}*/
	}
	
	function send_user_sms($user_numbers,$message,$id,$comment=""){ 
		date_default_timezone_set('Asia/Kolkata');
		$today = date("Y-m-d H:i:s");
		$admin_name		= $_SESSION['admin_name'];
		 $ar_id  	        = $_SESSION['ar_id'];
		if($user_numbers){
			
			for($i=0;$i<count($user_numbers);$i++){
				if($user_numbers[$i]){
                  	//$get_user_list = $control->get_user_sms($user_sms[2],$subject,$message);
		              	$user_phone = $user_numbers[$i];
						$desc = $message;
						//$user_phone 				= 	$_POST['mobile'];
						//$desc 						= 	$_POST['desc'];
						$ch = curl_init();
						$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_phone)."&message=".urlencode("".$desc ."");
						curl_setopt( $ch,CURLOPT_URL, $url );
						curl_setopt( $ch,CURLOPT_POST, false ); 
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
						$result = curl_exec($ch );
						curl_close( $ch ); 
						/*if($ch){
							return 1;
						}*/
						/*$user_table		    =	'users';
						$user_condition 	=	"user_phone='".$number."'";	
						$user_fields		=	'*';
								
						$user_result1	=	$this->model->get_Details_condition($user_table,$user_fields,$user_condition);	
						if($user_result1 !=NULL)
						{*/
								$set_array = array(
								'last_called'=>$today,
								'last_call_comment'=>$comment,
								'status'=>5,
								'last_sms_sent'=>$message,
								'action_taken_by'=>$admin_name,
								'action_taken_by_id'=> $ar_id 
							);
								
							$table		=	'zerob_consol1';
							$condition 	=	"id='".$id[$i]."'";	
                            $fields		=	'*';							
							$result1	=	$this->model->get_Details_condition($table,$fields,$condition);		
								if($result1 !=NULL)
								{
								$result	=	$this->model->update($table,$set_array,$condition);
								}
								else
								{
									$set_array1 = array(
												'last_called'=>$today,
												'last_call_comment'=>$comment,
												'status'=>5,
												'last_sms_sent'=>$message,
												'action_taken_by'=>$admin_name,
								                'action_taken_by_id'=> $ar_id,
												'id'=>$id[$i]
											);
									$result	=	$this->model->insert($table,$set_array1);
								}
						//}
				}
			}	
		}		
		else{
			return 0;
		}
	}
	function send_sms_to_new_user($user_numbers,$message){ 
		date_default_timezone_set('Asia/Kolkata');
	
	   if($user_numbers){
	
			
			$ch = curl_init();
			$url = 'http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto='.urlencode($user_numbers).'&message='.urlencode($message);
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch );  
						
			
		}		
		
	}
	
	
	function get_user_sms($user_list,$subject,$message){
		//print_r($user_list);
		//die();
		for($i=0;$i<count($user_list);$i++){
              $user_sms = explode("|",$user_list[$i]);
              //print_r($user_sms);
              	if($user_sms[2]){
                  	//$get_user_list = $control->get_user_sms($user_sms[2],$subject,$message);
		              	$user_phone = $user_sms[2];
						$desc = $message;
						//$user_phone 				= 	$_POST['mobile'];
						//$desc 						= 	$_POST['desc'];
						$ch = curl_init();
						$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_phone)."&message=".urlencode("".$desc ."");
						curl_setopt( $ch,CURLOPT_URL, $url );
						curl_setopt( $ch,CURLOPT_POST, false ); 
						curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
						curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
						$result = curl_exec($ch );
						curl_close( $ch ); 

			        }
			   }
		
		 
		//if($result){
			//echo '1';
			//echo '<script>alert("sms sent successfully.")</script>';
		//}
		echo '<script>alert("sms sent successfully.")</script>';	   
		echo '<script>window.location.assign("user_notifications.php")</script>';
			 
	}

	function get_user_mail($user_list,$subject,$message){

		//echo 'tt';
		/*
		$to= 'hema.jjbytes@gmail.com';
				$subject		=	'testing';
				$message        =	'test';
	            mail($to, $subject, $message);
		*/

	    for($i=0;$i<count($user_list);$i++){
            $user_mail = explode("|",$user_list[$i]);
              //print_r($user_mail);
              //die();
	          if($user_mail[1]){
	              	$to 			= 	$user_mail[1];
					$subject		=	$subject;
					$message		=	'<html>
					<body>
					 <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
					<p>Hi,<strong>' . $user_full_name . '</strong></p>
					<p>'.$message.'</p>
				
					</table>
					</body>
					</html>';
				
						
			        $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
			        $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
			        $headers1 		.= 	"From:admin@gmail.com\r\n";
			        //mail($to, $subject, $message, $headers1);
			        if(mail($to, $subject, $message, $headers1)){
			        	$res =  "1";
			        }
	          }
        } 

      
    	if($res ==1){
          	echo '<script>alert("Mail sent successfully.")</script>';
          	echo '<script>window.location.assign("user_notifications.php")</script>';
      	}
          

        //echo '<script>alert("Mail sent successfully.")</script>';
        //echo '<script>window.location.assign("user_notifications.php")</script>';
		/*
		$to 			= 	"hema.jjbytes@gmail.com";
		$subject		=	$subject;
		$message		=	'<html>
		<body>
		 <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
		<p>Hi,<strong>' . $user_full_name . '</strong></p>
		<p>'.$message.'</p>
	
		</table>
		</body>
		</html>';
	
			
        $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
					
        $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
        $headers1 		.= 	"From:admin@gmail.com\r\n";
            mail($to, $subject, $message, $headers1);

        //if (mail($to, $subject, $message, $headers1)) {
				// return $user_reg_verification_otp;
        //}			//return $fields_reg;

        */
	} 

	function sent_noti_user($user_list,$message,$subject){
		
		for($i=0;$i<count($user_list);$i++){
            $user_gcm = explode("|",$user_list[$i]);
              //print_r($user_mail[1]);
              //die();
            if($user_gcm[3]){
                //$gcm = $this->sendMessageThroughGCM($user_gcm[3],$message);
            	$url = 'https://android.googleapis.com/gcm/send';
		        $fields = array(
		            'registration_ids' => array($user_gcm[3]),
		            'data' => array("title" => $subject, "message"=> $message,"id"=>"")
		        );
				/*echo '<pre>';print_r($fields);
				exit;*/	
				// Update your Google Cloud Messaging API Key 
				define("GOOGLE_API_KEY", "AIzaSyDfjQepXPy2GltXwE5ob-h8vw1o5w3pzls"); 
		        $headers = array(
		            'Authorization: key='.GOOGLE_API_KEY,
		            'Content-Type: application/json'
		        );
		        $ch = curl_init();
		        curl_setopt($ch, CURLOPT_URL, $url);
		        curl_setopt($ch, CURLOPT_POST, true);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		        $result = curl_exec($ch);
		        curl_close($ch);

		        print_r($result);
		       				
		        if ($result === FALSE) {
		            die('Curl failed: ' . curl_error($ch));
		        }
				// print_r($result);  exit;
		        curl_close($ch);
		        
		        

            }
			//return $result ;
        }
        echo '<script>alert('.$result.')</script>';

        //echo '<script>alert("Notification sent successfully.")</script>';
        //echo '<script>window.location.assign("user_notifications.php")</script>';	
	}
	
	/* update_brand update*/
	function update_brand()
	{
		$table		=	'brands';
		$brand_id	=	$_POST['id'];
		$brand		=	$_POST['brand'];
		$priority	=	$_POST['priority'];
		
		
		if(!empty($_FILES['icon']['tmp_name']))
		{ 
			// echo "hi";exit;
			$filename = basename($_FILES['icon']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$now = new DateTime();
			$times = $now->getTimestamp();
			$target = "../../brand-icon/"; 
			//Determine the path to which we want to save this file
			$newname = $target.$times.'-'.$filename;
			$newname1 = $times.'-'.$filename;
			//echo $newname;exit;
			//Check if the file with the same name is already exists on the server
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['icon']['tmp_name'],$newname))) {
						$add_icon=$newname1;
					}else{
						$message	=	"Could not move the file!";
					}
				}
		

		$set_array	=	array(
						'brand_name'		=> $brand,
						'brand_icon'		=> $add_icon,
						'brand_priority'	=> $priority,
						);

						
		}else{ 
		
			$set_array	=	array(
							'brand_name'		=> $brand,
							'brand_priority'	=> $priority,
							);
			
		}
		
		$condition 	=	"brand_id='".$brand_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
		
	}
	
	
	
	
	/* deactive_brand update*/
	function deactive_brand()
	{
		$table		=	'brands';
		$brand_id	=	$_POST['id']; 
		$set_array	=	array(
						'brand_status'=> 0
						);
		$condition 	=	"brand_id='".$brand_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
		
	/* active_brand update*/
	function active_brand()
	{
		$table		=	'brands';
		$brand_id	=	$_POST['id']; 
		$set_array	=	array(
						'brand_status'=> 1
						);
		$condition 	=	"brand_id='".$brand_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	/*Add the Category*/
	function add_category()
	{
		date_default_timezone_set('Asia/Kolkata');
		$category					=	$_POST['category'];
		$priority					=	$_POST['priority'];
		
		
		
		
		$table		=	'product_category_list';
		$fields		=	'*';
		$condition 	=	"p_category_name='".$category."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		
		if(empty($result)){
		
			if(!empty($_FILES['icon']['tmp_name']))
			{ 
				// echo "hi";exit;
				$filename = basename($_FILES['icon']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				$now = new DateTime();
				$times = $now->getTimestamp();
				$target = "../../product-icon/"; 
				//Determine the path to which we want to save this file
				$newname = $target.$times.'-'.$filename;
				$newname1 = $times.'-'.$filename;
				//echo $newname;exit;
				//Check if the file with the same name is already exists on the server
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['icon']['tmp_name'],$newname))) {
							$add_icon=$newname1;
						}else{
							$message	=	"Could not move the file!";
						}
					}
				
			}
			
			
			if(!empty($_FILES['icon2']['tmp_name']))
			{ 
				// echo "hi";exit;
				$filename = basename($_FILES['icon2']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1);
				$now = new DateTime();
				$times = $now->getTimestamp();
				$target = "../../product-icon/"; 
				//Determine the path to which we want to save this file
				$newname = $target.$times.'-'.$filename;
				$newname1 = $times.'-'.$filename;
				//echo $newname;exit;
				//Check if the file with the same name is already exists on the server
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['icon2']['tmp_name'],$newname))) {
							$medium_icon=$newname1;
						}else{
							$message	=	"Could not move the file!";
						}
					}
				
			}
			
			
			$category_created_date		=	date("l jS \of F Y h:i:s A");
			$table						=	'product_category_list';
			
			
			$arr_input	=	array(
								'p_category_name'				=>	$category,
								'p_category_c_date'				=>	$category_created_date,
								'p_category_icon_small'			=>	$add_icon,
								'p_category_icon_medium'		=>	$medium_icon,
								'p_category_priority'			=>	$priority,
							);
			$result		=	$this->model->insert($table,$arr_input);
			return $result;
		}else{
			return $result='';
		}
	}
	
	
	
	
	
	
	//Get Category
	function get_category()
	{
		$table		=	'product_category_list';	
		$oredr_by	=	'p_category_priority';	
		$fields		=	'*';
		// $condition 	=	"p_category_status='1'";				
		// $result		=	$this->model->get_Details_condition($table,$fields,$condition);
		$result	=	$this->model->get_Detail_all_order_by($table,$oredr_by);
		return $result;
	}
	
	
	
	
	
	
	
	
	/*Delete the Category*/
	function del_category()
	{
		$table			=	'product_category_list';
		$p_category_id	=	$_POST['id'];
		$condition		=	"p_category_id='$p_category_id'";
		$res			=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	
	
	
	//Get Category  Information by id
	function get_product_category_by_id($id)
	{
		$table		=	'product_category_list';
		$fields		=	'*';
		$condition 	=	"p_category_id='".$id."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		return $result;
	}
	
	
	
	
	
	/* Category update*/
	function update_category()
	{
			
		$table				=	'product_category_list';
		$p_category_id		=	$_POST['id'];
		$p_category_name	=	$_POST['p_category_name'];
	
		
		if(!empty($_FILES['icon']['tmp_name']))
				{ 
					// echo "hi";exit;
					$filename = basename($_FILES['icon']['name']);
					$ext = substr($filename, strrpos($filename, '.') + 1);
					$now = new DateTime();
					$times = $now->getTimestamp();
					$target = "../../product-icon/"; 
					//Determine the path to which we want to save this file
					$newname = $target.$times.'-'.$filename;
					$newname1 = $times.'-'.$filename;
					//echo $newname;exit;
					//Check if the file with the same name is already exists on the server
						if (!file_exists($newname)) {
						//Attempt to move the uploaded file to it's new place
							if ((move_uploaded_file($_FILES['icon']['tmp_name'],$newname))) {
								$add_icon=$newname1;
							}else{
								$message	=	"Could not move the file!";
							}
						}
						
						
						$condition 			=	"p_category_name='".$p_category_name."'";				
						$result				=	$this->model->get_Details_condition($table,$fields,$condition);
						if(empty($result)){
							$set_array	=	array(
									'p_category_name'				=>	$p_category_name,
									'p_category_icon_small'			=>	$add_icon,
									);
							$condition 			=	"p_category_id='".$p_category_id."'";				
							$result				=	$this->model->update($table,$set_array,$condition);
							// echo '<pre>';print_r($set_array);exit;
							return $result;
						}else{
							$set_array	=	array(
									'p_category_icon_small'			=>	$add_icon,
									);
							$condition 			=	"p_category_id='".$p_category_id."'";				
							$result				=	$this->model->update($table,$set_array,$condition);
							// echo '<pre>';print_r($set_array);exit;
							return $result;
						
						}
				}else{
				// echo "hello";exit;
					$fields				='*';
					$condition 			=	"p_category_name='".$p_category_name."'";				
					$result				=	$this->model->get_Details_condition($table,$fields,$condition);
					// echo '<pre>';print_r($result);exit;
					if(empty($result)){
							$set_array	=	array(
								'p_category_name'				=>	$p_category_name,
								);
							$condition 			=	"p_category_id='".$p_category_id."'";				
							$result				=	$this->model->update($table,$set_array,$condition);
							// echo '<pre>';print_r($set_array);exit;
							return $result;
						}else{
							return $result='';
						
						}
						
				}
				
				
		
	}
	
	
	
	
	
	
	/* deactive_category update*/
	function deactive_category()
	{
		$table			=	'product_category_list';
		$p_category_id	=	$_POST['id']; 
		$set_array		=	array(
							'p_category_status'=> 0
							);
		$condition 		=	"p_category_id='".$p_category_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	/* active_category update*/
	function active_category()
	{
		$table			=	'product_category_list';
		$p_category_id	=	$_POST['id']; 
		$set_array		=	array(
							'p_category_status'=> 1
							);
		$condition 		=	"p_category_id='".$p_category_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	
	/*Add the add_brand_product*/
	function add_brand_product()
	{
		date_default_timezone_set('Asia/Kolkata');
		$brdnadid						=	$_POST['brdnadid'];
		$brand_product_name				=	$_POST['brand_product_name'];
		$brand_product_created_date		=	date("l jS \of F Y h:i:s A");
		$table							=	'brand_products';
		
		
		$add_icon='';
		
		
		$fields		=	'*';
		$condition 	=	"product_name='".$brand_product_name."' and product_brand_id='".$brdnadid."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		// echo'<pre>';print_r($result);exit;
		if(empty($result)){
			$arr_input	=	array(
							'product_brand_id'				=>	$brdnadid,
							'product_name'					=>	$brand_product_name,
							'product_created_date'			=>	$brand_product_created_date,
							'product_status'				=>	1
							);
			$result		=	$this->model->insert($table,$arr_input);
			return $result;
			
		
		}else{
			return $result='';
		}
		
	}
	
	
	
			
	//Get get_brand_product 
	function get_brand_product()
	{
		$table		=	'brand_products';
		$result	=	$this->model->get_brand_product($table);
		return $result;
	}
	
	
	
	//Get brand  Information by id
	function get_brand_product_by_id($id)
	{
		$table		=	'brand_products';
		$fields		=	'*';
		$condition 	=	"product_id='".$id."'";				
		$result	=	$this->model->get_brand_by_id($table,$fields,$condition);
		return $result;
	}
	
	
	
	
	
	
	/* update_brand_product update*/
	function update_brand_product()
	{
		
		$id								=	$_POST['id'];
		$brdnadid						=	$_POST['brdnadid'];
		$brand_product_name				=	$_POST['brand_product_name'];
		$table							=	'brand_products';
		
		
		$add_icon='';
		
		$fields		=	'*';
		$condition 	=	"product_name='".$brand_product_name."' and product_brand_id='".$brdnadid."'";				
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		// echo'<pre>';print_r($result);exit;
		if(empty($result)){ 
					$set_array	=	array(
									'product_brand_id'				=>	$brdnadid,
									'product_name'					=>	$brand_product_name,
									'product_status'				=>	1
									);
				$condition 	=	"product_id='".$id."'";				
				$result		=	$this->model->update($table,$set_array,$condition);
				return $result;
				
		}else{
			return $result='';
		}
	}
	
	
	
	
	
	
	/* deactive_brand_products update*/
	function deactive_brand_products()
	{
		$table		=	'brand_products';
		$product_id	=	$_POST['id']; 
		$set_array	=	array(
						'product_status'=> 0
						);
		$condition 	=	"product_id='".$product_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
		
	/* active_brand_products update*/
	function active_brand_products()
	{
		$table		=	'brand_products';
		$product_id	=	$_POST['id']; 
		$set_array	=	array(
						'product_status'=> 1
						);
		$condition 	=	"product_id='".$product_id."'";				
		$result		=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
		
	/*Delete the brands*/
	function del_brand_product()
	{
		$table		=	'brand_products';
		$product_id	=	$_POST['id'];
		$condition	=	"product_id='$product_id'";
		$res		=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
		//Get get_user_list 
	function get_user_list()
	{
		
		$table		    =	'users';
		$order_by       =   'user_id';
		return $result	=	$this->model->get_Detail_all_order_by_desc($table,$order_by);
	}
		//Get get_filtered_user_list 
	function get_filtered_user_list($filter)
	{
		$table		=	'users';
		$fields		=	'*';
		if($filter == 0){
			 
		}
		else if($fil){
			$condition	=	'';
		}
				
	
		switch($filter){
			
			case 0:
			    $order_by       =   'user_id';
				return $result	=	$this->model->get_Detail_all_order_by_desc($table,$order_by);
			break;
			case 1:
				$condition		=	'user_phone IN ( SELECT phone1 FROM zerob_consol1 ) OR user_phone  IN ( SELECT phone2 FROM zerob_consol1 ) order by user_id desc';
				return $result	=	$this->model->get_Details_condition($table,$fields,$condition);
			break;
			case 2:
				$condition		=	'user_phone NOT IN ( SELECT phone1 FROM zerob_consol1 ) OR user_phone NOT  IN ( SELECT phone2 FROM zerob_consol1 ) order by user_id desc';
				return $result	=	$this->model->get_Details_condition($table,$fields,$condition);
			break;
		}
		//$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		return $result;
	}
	
	function get_user_added_products()
	{
		$table		=	'users_products';
		$result	=	$this->model->get_Detail_user_added_products($table);
		return $result;
	}
	
	
	
	
	// Get get_particular_user_details
	function get_particular_user_details($id)
	{
		$table		=	'users';
		$fields		=	'*';
		$condition 	=	"user_id='".$id."'";		
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		return $result;
	}
	
	
	
	
	// Get User product List
	function get_particular_user_product_list($id)
	{
		$table		=	'users_products';
		$fields		=	'*';
		$condition 	=	"up_user_id='".$id."'";		
		$result	=	$this->model->get_particular_user_product_list($table,$fields,$condition);
		return $result;
	}
	
	
	
	
	// Get User product List
	function get_particular_user_product_details($id)
	{
		$table		=	'brand_products';
		$fields		=	'*';
		$condition 	=	"product_id='".$id."'";		
		$result	=	$this->model->get_particular_user_product_list($table,$fields,$condition);
		return $result;
	}
	
	
	
	
	
	
	
	/* user_block update*/
	function user_block()
	{
		
		$user_id			=	$_POST['id'];
		$user_status		=	0;
		$table				=	'users';
		$set_array	=	array(
							'user_id'						=>	$user_id,
							'user_status'					=>	$user_status
							);
							
		// print_r($set_array);	exit;				
		$condition 			=	"user_id='".$user_id."'";				
		$result				=	$this->model->update($table,$set_array,$condition);
		return $result;
		
	}
	
	
    
	// user registartion
    function user_resgitartion($name,$mobile,$email)
    {

		$keys=array("abcdefghijklmnopqrstuvwxyz", "123456abcdefghijklmnopqrstuvwxyz");
		// print_r($keys[0]);
		// print_r($keys[1]);
		$pin = rand(1000,9999);
        $table 					= table();
		date_default_timezone_set('Asia/Kolkata');
        $user_name 					=	$name;
        $user_address 				= 	"";
        $user_phone 				= 	$mobile;
        $user_email_id 				= 	$email;
        $user_city           		= 	"";
        $user_pin		    		= 	md5($pin);
        $user_area_pincode			= 	"";
        $user_gcm_id      			= 	"";
        $user_login_device_type		= 	"";
        $app_key	      			= 	$_POST['app_key'];
        $app_secret      			= 	$_POST['app_secret'];
        $user_created_date 			= 	date('Y-m-d h:i:s');
        $user_last_login 			= 	date('Y-m-d h:i:s');
        $user_reg_verification_otp	= "";
        $user_token					= "";
		
		if(($keys[0]==$app_key) && ($keys[1]==$app_secret)){
			$res	=	1;
		}else{
			$res	=	0;
		}
		
		
		
		
        if ($res==1) {
            $table           = table();
            $table_user      = $table['tb1'];
            $fields_user     = '*';
            // $condition_user  = 'user_phone    = ' . "'" . $user_phone . "'" . ' OR user_email_id = ' . "'" . $user_email_id . "'";
            $condition_user  = 'user_phone    = ' . "'" . $user_phone . "'";
            $arr_result_test = $this->model->get_Details_condition($table_user, $fields_user, $condition_user);
            // print_r($arr_result_test);exit;
           
        }else{
			$arr_result_test=1;
		}
          // print_r($arr_result_test);exit;
        if (empty($arr_result_test)) {
          
            $fields_reg = array(
                'user_name' 				=> $user_name,
                'user_address' 				=> $user_address,
                'user_phone' 				=> $user_phone,
                'user_email_id' 			=> $user_email_id,
                'user_city' 				=> $user_city,
                'user_pin' 					=> $user_pin,
                'user_area_pincode' 		=> $user_area_pincode,
                'user_token' 				=> $user_token,
                'user_gcm_id' 				=> $user_gcm_id,
                'user_login_device'			=> $user_login_device_type,
                'user_reg_verification_otp'	=> $user_reg_verification_otp,
                'user_created_date' 		=> $user_created_date,
                'user_last_login' 			=> $user_last_login
            );
            
            // print_r($fields_reg);exit;
			
            $table_log_in = $table['tb1'];
            $arr_result   = $this->model->insert($table_log_in, $fields_reg);
			
			
			
			$ch = curl_init();
			$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_phone)."&message=You have been registered to Yapnaa, Use your mobile number with ".urlencode("".$user_reg_verification_otp ." as password.\n.");
			curl_setopt( $ch,CURLOPT_URL, $url );
			curl_setopt( $ch,CURLOPT_POST, false ); 
			curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
			$result = curl_exec($ch );
			curl_close( $ch ); 
			
			return $user_reg_verification_otp;
			
            
        }
    }
    
	
	/* user_block update*/
	function user_acitve()
	{
		
		$user_id			=	$_POST['id'];
		$user_status		=	1;
		$table				=	'users';
		$set_array	=	array(
							'user_id'						=>	$user_id,
							'user_status'					=>	$user_status
							);
							
		// print_r($set_array);	exit;				
		$condition 			=	"user_id='".$user_id."'";				
		$result				=	$this->model->update($table,$set_array,$condition);
		return $result;
		
	}
	
	
	
	//Get brand  Information by id
	function get_brand_product_list($id)
	{
		$table		=	'brand_products';
		$fields		=	'*';
		$condition 	=	"product_brand_id='".$id."'";		
		$result	=	$this->model->get_brand_product_list($table,$fields,$condition);
		return $result;
	}
	
	
	
	//SRM Request List
	function srm_request_list()
	{
		$table		=	'SRM';
		$result	=	$this->model->srm_request_list($table);
		return $result;
	}
	
	
	//SRM Request List
	function srm_request_list_particular_details($id)
	{
		$table		=	'SRM';
		$fields		=	'*';
		$condition 	=	"srm_id='".$id."'";		
		$result	=	$this->model->srm_request_list_particular_details($table,$fields,$condition);
		return $result;
	}
	
	
	
	
	function srm_request_mvq_convert()
	{
		
		$srm_id					=	$_POST['srm_id'];
		$mvq_admin_name			=	$_POST['mvq_admin_name'];
		$mvq_admin_phone_no		=	$_POST['mvq_admin_phone_no'];
		$mvq_execative_notes	=	$_POST['mvq_execative_notes'];
		$srm_status				=	$_POST['srm_status'];
		date_default_timezone_set('Asia/Kolkata');
		$MVQ_no_generated_date	=	date('Y-m-d h:i:s');
		$MVQ_No					=	rand(1000, 99999);
		$table					=	'SRM';
		$set_array	=	array(
							'srm_MVQ_no'					=>	$MVQ_No,	
							'srm_MVQ_execative_notes'		=>	$mvq_execative_notes,	
							'srm_MVQ_execative_number'		=>	$mvq_admin_phone_no,	
							'srm_MVQ_execative_name'		=>	$mvq_admin_name,	
							'srm_MVQ_no_generated_date'		=>	$MVQ_no_generated_date,
							'srm_status'					=>	$srm_status,
							);
							
		// echo '<pre>';print_r($set_array);	exit;			
 
		$condition 			=	"srm_id='".$srm_id."'";				
		$result				=	$this->model->update($table,$set_array,$condition);
		
		if($result){ 
			
			//get usr id
			$fields			=	'*';
			$condition 		=	"srm_id='".$srm_id."'";		
			$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
			$user_id		=	$result[0]['srm_user_id'];
			
			
			//get user gcm and device type
			$table_user		=	'users';
			$fields			=	'*';
			$condition 		=	"user_id='".$user_id."'";		
			$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
			$device_type	=	$result[0]['user_login_device']; 
			$user_gcm_id	=	$result[0]['user_gcm_id']; 
			// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
			// echo'<pre>';print_r($result);exit;
			
			
			
			if($srm_status==2){
			 
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}

			}elseif($srm_status==3){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"Assigning-Engineer";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
			
			}elseif($srm_status==5){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"Ticket-cancelled";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
			
			}elseif($srm_status==6){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
			
			}else{
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	'Ticket has been closed';
					$pushMessage['message']			 = 	"MVQ No Generated Successfully";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
			
			
			}
			
			
			if($device_type=='IOS'){ 
				return $result;
			}	
			
			
			
			
		}
		
	}
	
	
	
	
	
	
	
	function srm_request_take_action()
	{
		
		$srm_id						=	$_POST['srm_id'];
		$srm_take_action_E_name		=	$_POST['mvq_admin_name'];
		$srm_take_action_E_phone_no	=	$_POST['mvq_admin_phone_no'];
		$srm_take_action_E_notes	=	$_POST['mvq_execative_notes'];
		$srm_status					=	$_POST['srm_status'];
		date_default_timezone_set('Asia/Kolkata');
		$srm_take_action_c_date	=	date('Y-m-d h:i:s'); 
		$table					=	'SRM';
		$set_array	=	array( 
							'srm_take_action_E_notes'		=>	$srm_take_action_E_notes,	
							'srm_take_action_E_phone_no'	=>	$srm_take_action_E_phone_no,	
							'srm_take_action_E_name'		=>	$srm_take_action_E_name,	
							'srm_take_action_c_date'		=>	$srm_take_action_c_date,
							'srm_status'					=>	$srm_status,
							);
							
		// echo '<pre>';print_r($set_array);	exit;			
 
		$condition 			=	"srm_id='".$srm_id."'";				
		$result				=	$this->model->update($table,$set_array,$condition);
		
		if($result){ 
			
			//get usr id
			$fields			=	'*';
			$condition 		=	"srm_id='".$srm_id."'";		
			$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
			$user_id		=	$result[0]['srm_user_id'];
			$MVQ_No			=	$result[0]['srm_MVQ_no'];
			
			
			//get user gcm and device type
			$table_user		=	'users';
			$fields			=	'*';
			$condition 		=	"user_id='".$user_id."'";		
			$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
			$device_type	=	$result[0]['user_login_device']; 
			$user_gcm_id	=	$result[0]['user_gcm_id']; 
			// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
			// echo'<pre>';print_r($result);exit;
			
			
			
			if($srm_status==23){
			 
				if($device_type=='Android'){   
						$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
						$pushMessage['SRM_id']			 = 	$srm_id;
						$pushMessage['status']			 = 	$srm_status;
						//In-Progress-Assigning-Engineer
						$pushMessage['message']			 = 	"In-Progress-AE";
							if (isset($user_gcm_id) && isset($pushMessage)) {		
							$gcmRegIds  = array($user_gcm_id); 
							$message = array("msg" => $pushMessage);	
							$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
							// echo'<pre>';print_r($message);exit;  
							}
						return $result;
					}
					
				
				if($device_type=='IOS'){ 
					return $result;
				}	

				
			}elseif($srm_status==25){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					//In-Progress-Ticket-cancelled
					$pushMessage['message']			 = 	"In-Progress-TC";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				
				if($device_type=='IOS'){ 
					return $result;
				}	
			
			
			
			}elseif($srm_status==26){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	

			
			}elseif($srm_status==5){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					//In-Progress-Ticket-cancelled
					$pushMessage['message']			 = 	"In-Progress-TC";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				
				if($device_type=='IOS'){ 
					return $result;
				}	
			
			
			
			}elseif($srm_status==6){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	

			
			}elseif($srm_status==245){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-ASE-TC";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	

			
			}elseif($srm_status==246){
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-ASE-Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	

			
			}else{
			
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	'In-Progress-Ticket has been closed';
					$pushMessage['message']			 = 	"MVQ No Generated Successfully";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	
 
			
			}
			 
			
		}
		
	}
	
	
	
	
	function srm_request_assign_engineer()
	{
		$srm_id					=	$_POST['srm_id'];
		$brand_ticket_no		=	$_POST['brand_ticket_no'];
		$se_name				=	$_POST['se_name'];
		$se_phone				=	$_POST['se_phone'];
		$se_notes				=	$_POST['se_notes'];
		$se_visiting_date		=	$_POST['se_visiting_date'];
		$priority				=	$_POST['priority'];
		$srm_SE_assigner_name	=	$_POST['srm_SE_assigner_name'];
		$srm_SE_assigner_phone	=	$_POST['srm_SE_assigner_phone'];
		$srm_status				=	$_POST['srm_status'];
		date_default_timezone_set('Asia/Kolkata');
		$se_assigned_date		=	date('Y-m-d h:i:s');
		$table					=	'SRM';
		$set_array	=	array(
							'srm_brand_ticket_no'			=>	$brand_ticket_no,	
							'srm_SE_name'					=>	$se_name,	
							'srm_SE_number'					=>	$se_phone,	
							'srm_SE_notes'					=>	$se_notes,	
							'srm_SE_visit_date'				=>	$se_visiting_date,	
							'srm_priority'					=>	$priority,
							'srm_SE_assigner_name'			=>	$srm_SE_assigner_name,
							'srm_SE_assigner_phone'			=>	$srm_SE_assigner_phone,
							'srm_status'					=>	$srm_status,
							'srm_SE_assigned_date'			=>	$se_assigned_date,
							);
							
		// echo '<pre>';print_r($set_array);	exit;				
		$condition 			=	"srm_id='".$srm_id."'";				
		$result				=	$this->model->update($table,$set_array,$condition);
		// echo '<pre>';print_r($set_array);	exit;	
		if($result){ 
			
			//get usr id
			$fields			=	'*';
			$condition 		=	"srm_id='".$srm_id."'";		
			$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
			$user_id		=	$result[0]['srm_user_id'];
			$MVQ_No			=	$result[0]['srm_MVQ_no'];
			
			
			//get user gcm and device type
			$table_user		=	'users';
			$fields			=	'*';
			$condition 		=	"user_id='".$user_id."'";		
			$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
			$device_type	=	$result[0]['user_login_device']; 
			$user_gcm_id	=	$result[0]['user_gcm_id']; 
			// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
			// echo'<pre>';print_r($result);exit;
			
			
			
			if($srm_status==244){
			
				if($device_type=='Android'){    
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-SE-Assigned";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
					
				if($device_type=='IOS'){ 
					return $result;
				}	

			}
			
			
		if($srm_status==34){
			
				if($device_type=='Android'){    
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"SE-Assigned";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
					
				if($device_type=='IOS'){ 
					return $result;
				}	

			}
			
			
			
			
			
			
		}
		
	}
	
	
	
	
	
	function srm_ticket_close()
	{
		
		$srm_id					=	$_POST['srm_id'];
		$TC_admin_name			=	$_POST['mvq_admin_name'];
		$TC_admin_phone_no		=	$_POST['mvq_admin_phone_no'];
		$TC_execative_notes		=	$_POST['close_ticket_execative_notes']; 
		$srm_status				=	$_POST['srm_status']; 
		date_default_timezone_set('Asia/Kolkata');
		$TC_generated_date		=	date('Y-m-d h:i:s'); 
		$table					=	'SRM';
		
		
		if($srm_status==246) {
			$set_array	=	array( 
								'srm_TC_execative_notes'		=>	$TC_execative_notes,	
								'srm_TC_execative_number'		=>	$TC_admin_phone_no,	
								'srm_TC_execative_name'			=>	$TC_admin_name,	
								'srm_TC_no_generated_date'		=>	$TC_generated_date,
								'srm_status'					=>	$srm_status,
								);
								
			// echo '<pre>';print_r($set_array);	exit;			
	 
			$condition 			=	"srm_id='".$srm_id."'";				
			$result				=	$this->model->update($table,$set_array,$condition);
			
			if($result){ 
				
				//get usr id
				$fields			=	'*';
				$condition 		=	"srm_id='".$srm_id."'";		
				$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
				$user_id		=	$result[0]['srm_user_id'];
				$MVQ_No			=	$result[0]['srm_MVQ_no'];
				
				
				//get user gcm and device type
				$table_user		=	'users';
				$fields			=	'*';
				$condition 		=	"user_id='".$user_id."'";		
				$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
				$device_type	=	$result[0]['user_login_device']; 
				$user_gcm_id	=	$result[0]['user_gcm_id']; 
				// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
				// echo'<pre>';print_r($result);exit;
				
				
				
				
				if($device_type=='Android'){    
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status; 
					$pushMessage['message']			 = 	"In-Progress-ASE-Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}

				
				
				
				if($device_type=='IOS'){ 
					return $result;
				}	
				
				
				
				
			}
			
		}
		
		
		
		
		if($srm_status==245) {
			$set_array	=	array( 
							'srm_take_action_E_notes'		=>	$srm_take_action_E_notes,	
							'srm_take_action_E_phone_no'	=>	$srm_take_action_E_phone_no,	
							'srm_take_action_E_name'		=>	$srm_take_action_E_name,	
							'srm_take_action_c_date'		=>	$srm_take_action_c_date,
							'srm_status'					=>	$srm_status,
							);
								
			// echo '<pre>';print_r($set_array);	exit;			
	 
			$condition 			=	"srm_id='".$srm_id."'";				
			$result				=	$this->model->update($table,$set_array,$condition);
			
			if($result){ 
				
				//get usr id
				$fields			=	'*';
				$condition 		=	"srm_id='".$srm_id."'";		
				$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
				$user_id		=	$result[0]['srm_user_id'];
				$MVQ_No			=	$result[0]['srm_MVQ_no'];
				
				
				//get user gcm and device type
				$table_user		=	'users';
				$fields			=	'*';
				$condition 		=	"user_id='".$user_id."'";		
				$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
				$device_type	=	$result[0]['user_login_device']; 
				$user_gcm_id	=	$result[0]['user_gcm_id']; 
				// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
				// echo'<pre>';print_r($result);exit;
				
				
				
				
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"In-Progress-ASE-TC";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	
				
				
				
			}
			
		}
		
		
		
		
		
		
		
		
		
		
		if($srm_status==35) {
			$set_array	=	array( 
							'srm_take_action_E_notes'		=>	$srm_take_action_E_notes,	
							'srm_take_action_E_phone_no'	=>	$srm_take_action_E_phone_no,	
							'srm_take_action_E_name'		=>	$srm_take_action_E_name,	
							'srm_take_action_c_date'		=>	$srm_take_action_c_date,
							'srm_status'					=>	$srm_status,
							);
								
			// echo '<pre>';print_r($set_array);	exit;			
	 
			$condition 			=	"srm_id='".$srm_id."'";				
			$result				=	$this->model->update($table,$set_array,$condition);
			
			if($result){ 
				
				//get usr id
				$fields			=	'*';
				$condition 		=	"srm_id='".$srm_id."'";		
				$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
				$user_id		=	$result[0]['srm_user_id'];
				$MVQ_No			=	$result[0]['srm_MVQ_no'];
				
				
				//get user gcm and device type
				$table_user		=	'users';
				$fields			=	'*';
				$condition 		=	"user_id='".$user_id."'";		
				$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
				$device_type	=	$result[0]['user_login_device']; 
				$user_gcm_id	=	$result[0]['user_gcm_id']; 
				// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
				// echo'<pre>';print_r($result);exit;
				
				
				
				
				if($device_type=='Android'){   
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status;
					$pushMessage['message']			 = 	"ASE-TC";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}
				
				if($device_type=='IOS'){ 
					return $result;
				}	
				
				
				
			}
			
		}
		
		
		
		
		
		if($srm_status==36) {
			$set_array	=	array( 
								'srm_TC_execative_notes'		=>	$TC_execative_notes,	
								'srm_TC_execative_number'		=>	$TC_admin_phone_no,	
								'srm_TC_execative_name'			=>	$TC_admin_name,	
								'srm_TC_no_generated_date'		=>	$TC_generated_date,
								'srm_status'					=>	$srm_status,
								);
								
			// echo '<pre>';print_r($set_array);	exit;			
	 
			$condition 			=	"srm_id='".$srm_id."'";				
			$result				=	$this->model->update($table,$set_array,$condition);
			
			if($result){ 
				
				//get usr id
				$fields			=	'*';
				$condition 		=	"srm_id='".$srm_id."'";		
				$result			=	$this->model->get_Details_condition($table,$fields,$condition); 
				$user_id		=	$result[0]['srm_user_id'];
				$MVQ_No			=	$result[0]['srm_MVQ_no'];
				
				
				//get user gcm and device type
				$table_user		=	'users';
				$fields			=	'*';
				$condition 		=	"user_id='".$user_id."'";		
				$result			=	$this->model->get_Details_condition($table_user,$fields,$condition);
				$device_type	=	$result[0]['user_login_device']; 
				$user_gcm_id	=	$result[0]['user_gcm_id']; 
				// $user_gcm_id	=	'APA91bEwS52Uqd5w1KlVl4-bJZzuH2RsrB5S4_csK5ufbhgBcKZhf3z3Y8Gd6vKbgTiWSSl6bLhG4llZmlkBet_iXtJH2PBtowSPeQueNR8rk63ASxHzIGqn0bJS98uLG2QfvGHarVT9'; 
				// echo'<pre>';print_r($result);exit;
				
				
				
				
				if($device_type=='Android'){    
					$pushMessage['SRM_MVQ_No']		 = 	$MVQ_No;
					$pushMessage['SRM_id']			 = 	$srm_id;
					$pushMessage['status']			 = 	$srm_status; 
					$pushMessage['message']			 = 	"ASE-Ticket-closed";
						if (isset($user_gcm_id) && isset($pushMessage)) {		
						$gcmRegIds  = array($user_gcm_id); 
						$message = array("msg" => $pushMessage);	
						$pushStatus = $this->sendMessageThroughGCM($gcmRegIds, $message);
						// echo'<pre>';print_r($message);exit;  
						}
					return $result;
				}

				
				
				
				if($device_type=='IOS'){ 
					return $result;
				}	
				
				
				
				
			}
			
		}
		
		
		
		
		
	}
	
	
	
	
	function get_srm_que_ans_details($q_list,$a_list)
	{  
		switch($a_list){
					case 1:
							$table		=	'srm_questions';
							$fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt1,srm_question_type';
							$condition 	=	"srm_question_id='".$q_list."'";		
							$result	=	$this->model->get_Details_condition($table,$fields,$condition);
							return $result; 
							
					case 2:
							$table		=	'srm_questions';
							// $fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt1,srm_question_opt2,srm_question_type';
							
							$fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt2,srm_question_type';
							$condition 	=	"srm_question_id='".$q_list."'";		
							$result	=	$this->model->get_Details_condition($table,$fields,$condition);
							return $result; 
					
					case 3:
							$table		=	'srm_questions';
							// $fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt1,srm_question_opt2,srm_question_opt3,srm_question_type';
							
							$fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt3,srm_question_type';
							$condition 	=	"srm_question_id='".$q_list."'";		
							$result	=	$this->model->get_Details_condition($table,$fields,$condition);
							return $result; 
							
					case 4:
							$table		=	'srm_questions';
							// $fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt1,srm_question_opt2,srm_question_opt3,srm_question_opt4,srm_question_type';
							
							$fields		=	'srm_question_id,srm_question_bp_id,srm_questions,srm_question_opt4,srm_question_type';
							$condition 	=	"srm_question_id='".$q_list."'";		
							$result	=	$this->model->get_Details_condition($table,$fields,$condition);
							return $result; 
		 
		 
		 
		 
		}
	}
	
	
	
	function get_user_phone_list($id)
	{  
		$table		=	'users'; 
		$fields		=	'*'; 		
		$result	=	$this->model->get_user_phone_list($table,$fields,$id);
		return $result; 
							
							
	}
	
	
	//Get user details
	function get_user_details($id)
	{  
		$table		=	'users';  
		$fields		=	'*';
		$condition 	=	"user_phone='".$id."'";		
		$result	=	$this->model->get_Details_condition($table,$fields,$condition);
		return $result; 
							
							
	}
	
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// SRM Question list
	function user_srm_question_list($id)
    {
        $table						   	 =	'srm_questions';  
        $fields			   				 = 	'*'; 
		$condition		 				 = 	'srm_question_bp_id    ='.$id;
		$arr_log_in       				 = 	$this->model->user_srm_question_list($table, $fields, $condition);
		return $arr_log_in;
		// print_r($arr_log_in );

    }
	
	
	
			
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// SRM Question Answers
	function user_srm_question_answers($user_id,$p_id,$que,$ans)
    {
        $table	=	'SRM';  
		date_default_timezone_set('Asia/Kolkata');
		$srm_c_date 					 = 	date('Y-m-d h:i:s');
		$fields_reg = array(
					'srm_user_id' 				=> $user_id,
					'srm_questions' 			=> trim($que, ","),
					'srm_answers' 				=> trim($ans, ","),
					// 'srm_user_notes'			=> $user_srm_ans_notes,
					'srm_product_id'			=> $p_id,
					'srm_c_date' 				=> $srm_c_date
				); 
				// print_r($fields_reg);exit; 
		$arr_result   = $this->model->insert($table, $fields_reg);
		return $arr_result; 

    }
	
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// SRM Question list
	function get_amc_list($id)
    {
        $table						   	 =	'amc_requests';   
		$arr_log_in       				 = 	$this->model->get_amc_list($table, $fields, $condition);
		return $arr_log_in;
		// print_r($arr_log_in );

    }
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/	

		
/*----------------------------------------------------------------------------------------------------------------------*/		
	

	
	// SEARCH Customer
	function get_zerob_list($action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate)
    {
		//echo $tag." == filter: ".$filter." == from: ".$fromDate." == to: ".$toDate;
		$arr_log_in       				 = 	$this->model->get_zerob_list($action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate);
		return $arr_log_in;
		// print_r($arr_log_in );

    }
	// SEARCH Customer
	
	 function download_zerob_list($action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate)
    {
		$tag          = $_POST['tag'];
		$filter           = $_POST['filter'];
	  $fromDate           = $_POST['fromDate'];
		$toDate           = $_POST['toDate'];
		$amc_fromDate     = $_POST['amc_fromDate'];
		$amc_toDate       = $_POST['amc_toDate'];
		$arr_log_in       				 = 	$this->model->download_zerob_list($action_taken_by,$tag,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate);
		$this->download_csv_results($arr_log_in,"yapnaa.csv");
		
		exit;

    } 
	function download_csv_results($results, $name = NULL)
	{
		if( ! $name)
		{
			$name = md5(uniqid() . microtime(TRUE) . mt_rand()). '.csv';
		}

		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename='. $name);
		header('Pragma: no-cache');
		header("Expires: 0");

		$outstream = fopen("php://output", "w");

		foreach($results as $result)
		{
			fputcsv($outstream, $result);
		}

		fclose($outstream);
	}
	
		
/*----------------------------------------------------------------------------------------------------------------------*/			
	function add_banner()
	{ 
		$table_name  	  		=	 'banner_images';
		$banner_title			=	($_POST['banner_title']);
		$banner_created_by		=	($_POST['banner_created_by']); 
		$banner_priority		=	($_POST['banner_priority']); 
		$banner_for				=	($_POST['banner_for']); 
		$banner_screens_for		=	($_POST['banner_screens_for']); 
		$banner_url = ($_POST['banner_url']);
		
		$fields		    	= 	 'banner_title';
		$condition		  	= 	 'banner_title    = ' . "'" . $banner_title . "'";
		$arr_result		 	= 	 $this->model->get_Details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		
		if(empty($arr_result)){ 
			//Main category file to move in to folder
			if(!empty($_FILES['banner_image']['tmp_name']))
			{  
				$filename = basename($_FILES['banner_image']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1); 
				$target = "../../banner-images/"; 
				//Determine the path to which we want to save this file
				$now = new DateTime();
				$times = $now->getTimestamp();
				$newname = $target.$times.$mc_title.'.'.$ext;  	
				// $newname = $target.$mc_title.'.'.$ext;   
				// $newname = $target.$times.$mc_title.'.'.$ext;   
				//Check if the file with the same name is already exists on the server
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['banner_image']['tmp_name'],$newname))) {
						$banner_image	=	$times.$mc_title.'.'.$ext;
					}else{
						$message	=	"Could not move the file!";
					}
				}
				
			}
			 
			$arr_input	=	array(
							'banner_title'					=>	$banner_title,
							'banner_img'					=>	$banner_image, 
							'banner_c_date'					=>	$this->date, 
							'banner_priority'				=>	$banner_priority,
							'banner_status'					=>	1,
							'banner_for'					=>	$banner_for,
							'banner_screens_for'			=>	$banner_screens_for,
							'banner_url'                    =>	$banner_url
							);
			// echo'<pre>';print_r($arr_input);exit;
			$result				=	$this->model->insert($table_name,$arr_input);
			return $result=1;
		}else{
			return $result=2;
		}
	}

	function add_banner_edit($banner_id)
	{ 
		$table_name  	  		=	 'banner_images';
		$banner_title			=	($_POST['banner_title']);
		$banner_created_by		=	($_POST['banner_created_by']); 
		$banner_priority		=	($_POST['banner_priority']); 
		$banner_for				=	($_POST['banner_for']); 
		$banner_screens_for		=	($_POST['banner_screens_for']); 
		$banner_url = ($_POST['banner_url']);
		/*
		$fields		    	= 	 'banner_title';
		$condition		  	= 	 'banner_title    = ' . "'" . $banner_title . "'";
		$arr_result		 	= 	 $this->model->get_Details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		*/
		//if(empty($arr_result)){ 
			//Main category file to move in to folder
			if(!empty($_FILES['banner_image']['tmp_name']))
			{  
				$filename = basename($_FILES['banner_image']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1); 
				$target = "../../banner-images/"; 
				//Determine the path to which we want to save this file
				$now = new DateTime();
				$times = $now->getTimestamp();
				$newname = $target.$times.$mc_title.'.'.$ext;  	
				// $newname = $target.$mc_title.'.'.$ext;   
				// $newname = $target.$times.$mc_title.'.'.$ext;   
				//Check if the file with the same name is already exists on the server
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['banner_image']['tmp_name'],$newname))) {
						$banner_image	=	$times.$mc_title.'.'.$ext;
					}else{
						$message	=	"Could not move the file!";
					}
				}
				
			}
			if(!empty($_FILES['banner_image']['tmp_name']))
			{   
					$arr_input	=	array(
							'banner_title'					=>	$banner_title,
							'banner_img'					=>	$banner_image, 
							'banner_c_date'					=>	$this->date, 
							'banner_priority'				=>	$banner_priority,
							'banner_status'					=>	1,
							'banner_for'					=>	$banner_for,
							'banner_screens_for'			=>	$banner_screens_for,
							'banner_url'                    =>	$banner_url
							);
			}else{
				$arr_input	=	array(
							'banner_title'					=>	$banner_title,
							'banner_c_date'					=>	$this->date, 
							'banner_priority'				=>	$banner_priority,
							'banner_status'					=>	1,
							'banner_for'					=>	$banner_for,
							'banner_screens_for'			=>	$banner_screens_for,
							'banner_url'                    =>	$banner_url
							);
			}
			// echo'<pre>';print_r($arr_input);exit;
			//$result				=	$this->model->insert($table_name,$arr_input);
			$condition 	=	"banner_id	='".$banner_id."'";				
			$result		=	$this->model->update($table_name,$arr_input,$condition);
			return $result=1;
		//}else{
			//return $result=2;
		//}
	}
	

/*----------------------------------------------------------------------------------------------------------------------*/	

	function get_banner_by_id($bid)
	{
		$table_name =	 'banner_images';
		$fields     =	 "*"; 
		$id    		=	 $bid;  
		$arr_result	= 	 $this->model->get_details_by_id($table_name,$fields,$id);
		// print_r($arr_result_test);exit;
		return $arr_result;
	}
	
	
/*----------------------------------------------------------------------------------------------------------------------*/	

		function get_banner_list()
	{
		$table_name  	  	=	 'banner_images';
		$fields     		=	 "*"; 
		$orderby    		=	 "banner_priority";  
		$arr_result			= 	 $this->model->get_details_orderby($table_name,$fields,$orderby);
		// print_r($arr_result_test);exit;
		return $arr_result;
	}
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/	


	/* deactive_banner update*/
	function deactive_banner()
	{
		$table_name  	  	=	 'banner_images';
		$banner_id			=	$_POST['id']; 
		$set_array			=	array(
									'banner_status'		=> 	0
								);
		// print_r($set_array);exit;
		$condition 	=	"banner_id	='".$banner_id."'";				
		$result		=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/	
	
	
	/* activate_banner update*/
	function activate_banner()
	{
		$table_name  	  	=	 'banner_images';
		$banner_id			=	$_POST['id']; 
		$set_array			=	array(
									'banner_status'		=> 1
								);
		// print_r($set_array);exit;
		$condition 	=	"banner_id	='".$banner_id."'";				
		$result		=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
/*----------------------------------------------------------------------------------------------------------------------*/	
	
	
	/* Edit update*/
	function edit_banner()
	{
		$table_name  	  	=	 'banner_images';
		$banner_id			=	$_POST['id']; 
		$set_array			=	array(
									'banner_status'		=> 1
								);
		// print_r($set_array);exit;
		$condition 	=	"banner_id	='".$banner_id."'";				
		$result		=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
		
		
/*----------------------------------------------------------------------------------------------------------------------*/	

	
	/*Delete the delete_banner*/
	function delete_banner()
	{
		$table_name  	  	=	 'banner_images';
		$banner_id			=	$_POST['id']; 
		$banner_img			=	$_POST['banner_img']; 
		$target 			= 	"../../view/images/banner-images/".$_POST['banner_img'];
		unlink($mc_image);
		$condition			=	"banner_id='$banner_id'";
		$res				=	$this->model->delete_row_data($table_name,$condition);
		return $res;;
	}
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/	

	
	
	
	/*Add the add_amc_price*/
	function add_amc_price()
	{
		date_default_timezone_set('Asia/Kolkata');
		$brdnadid						=	$_POST['brdnadid'];
		$brand_product_name				=	$_POST['brand_product_name'];
		$pname							=	$_POST['pname'];
		$servicecharge					=	$_POST['servicecharge'];
		$amccost						=	$_POST['amccost'];
		$acmccost						=	$_POST['acmccost']; 
		$table							=	'amc_price_list';
		
	  
		$arr_input	=	array(
						'amc_price_brand_id'				=>	$brdnadid,
						'amc_price_brand_name'				=>	$brand_product_name,
						'amc_price_p_name'					=>	$pname,
						'amc_price_service_charge'			=>	$servicecharge,
						'amc_price_amc_cost'				=>	$amccost,
						'amc_price_acmc_cost'				=>	$acmccost,
						'amc_pricelist_status'				=>	1  
						);
		// echo'<pre>';print_r($arr_input);exit;
		$result		=	$this->model->insert($table,$arr_input);
		return $result;
		
		
		 
		
	}
	
	
	
	
				
	//Get get_amc_price_list 
	function get_amc_price_list()
	{
		$table		=	'amc_price_list';
		$result	=	$this->model->get_amc_price_list($table);
		return $result;
	}

	
	
	
	
	
	
	/* deactive_amc_price update*/
	function deactive_amc_price()
	{
		$table			=	'amc_price_list';
		$amc_price_id	=	$_POST['id']; 
		$set_array		=	array(
							'amc_pricelist_status'=> 0
							);
		$condition 		=	"amc_price_id='".$amc_price_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	/* active_amc_price update*/
	function active_amc_price()
	{
		$table			=	'amc_price_list';
		$amc_price_id	=	$_POST['id']; 
		$set_array		=	array(
							'amc_pricelist_status'=> 1
							);
		$condition 		=	"amc_price_id='".$amc_price_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
		/*Delete the del_amc_price*/
	function del_amc_price()
	{
		$table			=	'amc_price_list';
		$amc_price_id	=	$_POST['id'];
		$condition		=	"amc_price_id='$amc_price_id'";
		$res			=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	
	
	
		
/*----------------------------------------------------------------------------------------------------------------------*/	

	
	
	
	/*Add the add_apk_version*/
	function add_apk_version()
	{ 
		$v_name							=	$_POST['v_name'];  
		$table							=	'apk_version';
		
		$set_array		=	array(
							'apk_version_status'=> 0
							);
		$condition 		=	"apk_version_status=0 or apk_version_status=1";				
		$result			=	$this->model->update($table,$set_array,$condition);
		
		if($result){
			$arr_input	=	array(	
							'apk_version_name'					=>	$v_name, 
							'apk_version_status'				=>	1  
							);
			// echo'<pre>';print_r($arr_input);exit;
			$result		=	$this->model->insert($table,$arr_input);
			return $result;
			
		}
		 
		
	}
	
	
	
	
	
	/*Add the add_apk_version*/
	function get_apk_version()
	{   
		$table		=	'apk_version';
		$fields		=	'*';
		$orderby	=	'apk_version_id';
		$result		=	$this->model->get_details_orderby_desc($table,$fields,$orderby);
		return $result;
			
		 
	}
	
	
	
	
	
	
	
	
	
	/* deactive_apk_version update*/
	function deactive_apk_version()
	{
		$table			=	'apk_version';
		$apk_version_id	=	$_POST['id']; 
		$set_array		=	array(
							'apk_version_status'=> 0
							);
		$condition 		=	"apk_version_id='".$apk_version_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
	/* active_apk_version update*/
	function active_apk_version()
	{
		$table			=	'apk_version';
		$apk_version_id	=	$_POST['id']; 
		$set_array		=	array(
							'apk_version_status'=> 1
							);
		$condition 		=	"apk_version_id='".$apk_version_id."'";				
		$result			=	$this->model->update($table,$set_array,$condition);
		return $result;
	}
	
	
	
	
		/*Delete the del_apk_version*/
	function del_apk_version()
	{
		$table			=	'apk_version';
		$apk_version_id	=	$_POST['id'];
		$condition		=	"apk_version_id='$apk_version_id'";
		$res			=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	
	
	//send sms
	function send_sms()
	{
		$table			=	'apk_version';
		$apk_version_id	=	$_POST['id'];
		$condition		=	"apk_version_id='$apk_version_id'";
		$res			=	$this->model->delete_row_data($table,$condition);
		return $res;;
	}
	
	
	
	
/*----------------------------------------------------------------------------------------------------------------------*/	

		
	
	// GCM Notification to user
	function sendMessageThroughGCM($gcmRegIds, $message) { 
		//Google cloud messaging GCM-API url
        $url = 'https://android.googleapis.com/gcm/send';
        $fields = array(
            'registration_ids' => $gcmRegIds,
            'data' => $message
        );
		// echo '<pre>';print_r($fields);exit;	
		// Update your Google Cloud Messaging API Key 
		define("GOOGLE_API_KEY", "AIzaSyAInPAdZ7X6YThaHkkQvWhWp3c8qePWOtI"); 	//user server key
	


        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);	
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);				
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
		// print_r($result);  exit;
        curl_close($ch);
        return $result ;
    }
	
	function send_email($text,$subject,$to){
		$message	=	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <!--[if !mso]><!-->
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!--<![endif]-->
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
	  
	     <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
      <!--[if (gte mso 9)|(IE)]>
      <style type="text/css">
         table {border-collapse: collapse !important;}
      </style>
      <![endif]-->
   <script type="text/javascript" src="https://gc.kis.v2.scr.kaspersky-labs.com/07F733F4-CC45-CA48-AAE8-118119D9AF18/main.js" charset="UTF-8"></script></head>
   

   
   
   
   <body style="Margin:0;padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;min-width:100%;background-color:#ececec;">
      <center class="wrapper" style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#ececec;">
         <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ececec;" bgcolor="#ececec;">
            <tr>
               <td width="100%">
                  <div class="webkit" style="width:650px;Margin:0 auto; background:#fff;">
                     <!--[if (gte mso 9)|(IE)]>
                     <table width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0" >
                        <tr>
                           <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                              <![endif]--> 
                              <!-- ======= start main body ======= -->
                              <table class="outer" align="center" cellpadding="0" cellspacing="0" border="0" style="border-spacing:0;Margin:0 auto;width:100%;max-width:600px;">
                                 <tr>
                                    <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">
                                       <!-- ======= start header ======= -->
                                       <table border="0" width="100%" cellpadding="0" cellspacing="0"  >
                                          <tr>
                                             <td>
                                                <table style="width:100%;" cellpadding="0" cellspacing="0" border="0">
                                                   <tbody>
                                                      <tr>
                                                         <td align="center">
                                                            <center>
                                                               <table border="0" align="center" width="100%" cellpadding="0" cellspacing="0" style="Margin: 0 auto;">
                                                                  <tbody>
                                                                     <tr>
                                                                        <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" bgcolor="#FFFFFF">
                                                                           <!-- ======= start header ======= -->
                                                                           <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                              <tr>
                                                                                 <td class="two-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;text-align:center;font-size:0;">
                                                                                    <!--[if (gte mso 9)|(IE)]>
                                                                                    <table width="100%" style="border-spacing:0" >
                                                                                       <tr>
                                                                                          <td width="20%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:110px;display:inline-block;vertical-align:top;">
                                                                                                <table class="contents" style="border-spacing:0; width:100%"  bgcolor="#ffffff" >
                                                                                                   <tr>
                                                                                                      <td style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" align="left"><a href="#" target="_blank"><img src="http://yapnaa.com/images/yapnaa-logo1.png" width="74" alt="" style="border-width:0; max-width:74px;height:auto; display:block" /></a></td>
                                                                                                   </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                          <td width="80%" valign="top" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;" >
                                                                                             <![endif]-->
                                                                                             <div class="column" style="width:100%;max-width:415px;display:inline-block;vertical-align:top;">
                                                                                                <table width="100%" style="border-spacing:0" bgcolor="#ffffff">
                                                                                                   <tr>
                                                                                                      <td>
                                                                                                         <table width="100%" border="0" cellspacing="0" cellpadding="0" class="hide">
                                                                                                            <tr>
                                                                                                               <td height="20">&nbsp;</td>
                                                                                                            </tr>
                                                                                                         </table>
                                                                                                      </td>
                                                                                                   </tr>
                                                                                                  <tr>
                            <td class="inner" style="padding-top: 0px;padding-bottom: 10px;padding-right: 0px;padding-left: 234px"><table class="contents" style="border-spacing:0; width:100%">
                                <tbody><tr>
                                  <td width="100%" align="center" valign="top" style="padding-top:10px"><table width="200" border="0" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td width="33" align="center"><a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"><img src="http://yapnaa.com/movilo/Images/googleplayAsset.png" alt="facebook" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                        <td width="34" align="center"><a href="https://www.facebook.com/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/FacebookAsset.png" alt="twitter" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                        <td width="33" align="center"><a href="https://twitter.com/yapnaa" target="_blank"><img src="http://yapnaa.com/movilo/Images/TwitterAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                     <td width="33" align="center"><a href="https://www.linkedin.com/company/yapnaa/" target="_blank"><img src="http://yapnaa.com/movilo/Images/LinkedinAsset.png" alt="linkedin" width="36" height="36" border="0" style="border-width:0; max-width:36px;height:auto; display:block; max-height:36px"></a></td>
                                      </tr>
                                    </tbody></table></td>
                                </tr>
                              </tbody></table></td>
                          </tr>
                                                                                                </table>
                                                                                             </div>
                                                                                             <!--[if (gte mso 9)|(IE)]>
                                                                                          </td>
                                                                                       </tr>
                                                                                    </table>
                                                                                    <![endif]-->
                                                                                 </td>
                                                                              </tr>
                                                                              <tr >
                                                                                 <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                                                    <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                                                       <tr>
                                                                                          <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                                                       </tr>
                                                                                    </table>
                                                                                 </td>
                                                                              </tr>
                                                                              <tr>
                                                                              </tr>
                                                                           </table>
                                                                        </td>
                                                                     </tr>
                                                                  </tbody>
                                                               </table>
                                                            </center>
                                                         </td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end header ======= --> 
                                       <!-- ======= start hero article ======= -->
                                       <table class="one-column" border="0" cellpadding="40" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="" style="padding-bottom:2%; padding-top:2%;">
                                                
												<p style="color:#666666; font-size:14px;  font-family: "Montserrat", sans-serif;"><b>'.$text.'</b></p>
                                                <!-- START BUTTON -->
                                                <!-- END BUTTON -->
                                             </td>
                                          </tr>
                                       </table>
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end hero article ======= --> 
                                       <center >
                                          <table bgcolor="#FFFFFF" width="100%">
                                             <tr>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td> <a href="http://www.yapnaa.com"><img src="http://yapnaa.com/movilo/Images/websiteAsset.png" width="32" height="30" border="0" ></a></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> www.yapnaa.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td><a href="http://help@yapnaa.com"><img src="http://yapnaa.com/movilo/Images/emailAsset.png"  width="32" height="25" border="0" ></a></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b> help@yapnaa.com</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                                <td>
                                                   <table>
                                                      <tr>
                                                         <td><img src="http://yapnaa.com/movilo/Images/CallAsset.png" width="32" height="28" border="0" ></td>
                                                         <td>
                                                            <p style="color:#5b5f65; font-size:12px;  font-family: "Montserrat", sans-serif;"> <b>  +91 98452 856419</b></p>
                                                         </td>
                                                      </tr>
                                                   </table>
                                                </td>
                                             </tr>
                                          </table>
                                       </center>
                                       <!-- ======= start divider ======= -->
                                       <table class="one-column" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-spacing:0" bgcolor="#FFFFFF">
                                          <tr>
                                             <td align="left" style="padding-left:40px;border-bottom:2px solid #9E9E9E;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="" align="left">
                                                   <tbody>
                                                      <tr>
                                                         <td height="20" width="30" style="font-size: 20px; line-height: 20px;">&nbsp;</td>
                                                      </tr>
                                                   </tbody>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td align="center">&nbsp;</td>
                                          </tr>
                                       </table>
                                       <!-- ======= end divider ======= --> 

                                    </td>
                                 </tr>
                              </table>
                              <!--[if (gte mso 9)|(IE)]>
                           </td>
                        </tr>
                     </table>
                     <![endif]--> 
					 
					 
					                                        <!-- ======= start footer ======= -->
                                       <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0"  bgcolor="#ffdfd0">
                                                   <tr>
                                                      <td height="20" align="center" bgcolor="#ffdfd0" class="one-column">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Copyright @ 2017</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center"><b>Movilo Networks Pvt. Ltd</b></font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:10px;padding-left:10px;"><font style="font-size:13px; text-decoration:none; color:#5b5f65; font-family: "Montserrat", sans-serif;; text-align:center">Your after sales companion</font></td>
                                                   </tr>
                                                   <tr>
                                                      <td align="center" bgcolor="#ffdfd0" class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;">&nbsp;</td>
                                                   </tr>
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents1" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                </table>
                                             </td>
                                          </tr>
                                          <tr>
                                             <td>
                                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                   <tr>
                                                      <td height="6" bgcolor="#ffdfd0" class="contents" style="width:100%; border-bottom-left-radius:10px; border-bottom-right-radius:10px"></td>
                                                   </tr>
                                                  
                                                </table>
                                             </td>
                                          </tr>
                                       </table>
                                       <!-- ======= end footer ======= -->
                  </div>
               </td>
            </tr>
         </table>
      </center>
   </body>
</html>

			';
			
		$headers 				= 'MIME-Version: 1.0'. "\r\n";
		$headers 			.= 'Content-type: text/html; charset=iso-8859-1'. "\r\n";	
		$headers 			.= 'From: Yapnaa Admin <noreply@yapnaa.com>'. "\r\n";
		
		//echo $subject;die;
		// Mail it
		mail($to, $subject, $message,$headers);
		
	}
	
	
	
	
}

?>