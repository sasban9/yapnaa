<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
if(isset($_SESSION['admin_email_id']))
{
	 $admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];

	require_once('controller/admin_controller.php');
	$control	=	new admin();
	
 
	
	
	//send sms
	if(isset($_POST['submit']))
	{		
	
		$user_phone 				= 	$_POST['mobile'];
		$desc 						= 	$_POST['desc'];
		$ch = curl_init();
		$url = "http://nimbusit.co.in/api/swsendSingle.asp?username=t1jjbytes&password=62134339&sender=YAPNAA&sendto=".urlencode($user_phone)."&message=".urlencode("".$desc ."");
		curl_setopt( $ch,CURLOPT_URL, $url );
		curl_setopt( $ch,CURLOPT_POST, false ); 
		curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false ); 
		$result = curl_exec($ch );
		curl_close( $ch ); 
		 
			echo '<script>alert("sms sent successfully.")</script>';
			echo '<script>window.location.assign("send-sms.php")</script>'; 
	}
	
	  
	
	
?>
<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:49:42 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Movilo | Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
       <?php include "header.php";?>
        </div>
              
		<div class="row wrapper border-bottom white-bg page-heading">
			<div class="col-lg-10">
				<h2>Send SMS</h2>
				<ol class="breadcrumb">
					<li>
						<a href="index.php">Home</a>
					</li>
					<li class="active">
						<strong>Send SMS</strong>
					</li>
				</ol>
			</div>
			<div class="col-lg-2">

			</div>
		</div>	  


		
		<div class="row">
            <div class="col-lg-12">
                <div class="wrapper wrapper-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox float-e-margins">
                                    <div class="ibox-content">
										<div class="media-body">
										   <div class="row m-t-sm">
												<div class="col-lg-12">
													<div class="panel blank-panel">
														<div class="panel-heading">
															<div class="panel-options">
																<ul class="nav nav-tabs">
																	<li class="active"><a href="#tab-1" data-toggle="tab"> Send SMS</a></li> 
																</ul>
															</div>
														</div>

														<div class="panel-body">

															<div class="tab-content">
																<div class="tab-pane active" id="tab-1"> 
																
																	<form id="form" method="POST" enctype="multipart/form-data">
																			<fieldset class="form-horizontal">
																				<div class="form-group"><label class="col-sm-2 control-label">Mobile No:</label>
																					<div class="col-sm-10">
																					<input type="number" class="form-control" name="mobile" id="mobile" required maxlength="10">	
																					</div>
																				</div>
																				
																				 
																				
																				
																				
																				<div class="form-group">
																					<label class="col-sm-2 control-label">Message:</label>
																					<div class="col-sm-10">
																						 <textarea name="desc" id="desc" class="form-control" required ></textarea>
																					</div>
																				</div>
																				
																				 
																				
																				<input id="submit" onclick="myFunction()" type="submit" name="submit" class="btn btn-info pull-right"  value="Send">
																			</fieldset>
																	</form>
																	
																	
																	
																</div>
															 
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
		
                
               
<?php include "footer.php";?>

<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script>

function myFunction() {
	
var add_cat = $("#mobile").val();
if ($.trim(add_cat) === '')
{
alert("Please Enter Mobile No.");
$('#mobile').val('');
$('#mobile').focus();
 return false;
}


var add_cat = $("#desc").val();
if ($.trim(add_cat) === '')
{
alert("Please Enter Message to send.");
$('#desc').val('');
$('#desc').focus();
 return false;
}

}
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
