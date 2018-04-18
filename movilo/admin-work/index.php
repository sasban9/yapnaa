<?php	
error_reporting(E_ALL);
session_start();
require_once('controller/admin_controller.php');
$control	=	new admin();
$err_msg	=	'';
/* Login form submission*/
if(isset($_POST['admin_login']))
{
	$admin_email_id		=	$_POST['admin_email_id'];
	$admin_password		=	$_POST['admin_password'];
	
	$admin_password   =   md5($admin_password);
	$login_val	=	$control->admin_login_val($admin_email_id,$admin_password);
	
	
	
	// echo '<pre>';
	// print_r($login_val);exit;
	if(!empty($login_val)){
	
		$_SESSION['admin_name']				=	$login_val[0]['admin_name'];
		$_SESSION['admin_email_id']			=	$login_val[0]['admin_email_id'];
		$_SESSION['admin_last_login']		=	$login_val[0]['admin_last_login'];
		$_SESSION['admin_phone_no']			=	$login_val[0]['admin_phone_no'];
		$_SESSION['admin_address']			=	$login_val[0]['admin_address'];
		$_SESSION['ar_role_name']			=	$login_val[0]['ar_role_name'];
		$_SESSION['ar_id']			        =	$login_val[0]['ar_id'];
	}
	
	
	
	
	if(!empty($login_val)){
		switch($login_val[0]['admin_role_id'])
		  {
			case 1: 
					echo  '<script>window.location.assign("admin-panel/index.php"); </script>';
					break;
			  
			case 2: 
					echo  '<script>window.location.assign("admin-panel/index.php"); </script>';
					break;
			case 3: 
					echo  '<script>window.location.assign("admin-panel/index.php"); </script>';
					break;
			case 4: 
					echo  '<script>window.location.assign("admin-panel/index.php"); </script>';
					
				   break;
		    case 5: 
				echo  '<script>window.location.assign("admin-panel/index.php"); </script>';
					// echo  '<script>window.location.assign("buy/index.php"); </script>';break;
			// case 4: 
					// $email=$_SESSION['email'];
					// echo  '<script>window.location.assign("sell/index.php"); </script>';break;
			// case 5: 
					// $email=$_SESSION['email'];
					// echo  '<script>window.location.assign("BizEx-user/index.php"); </script>';break;
			// case 6: 
					// $email=$_SESSION['email'];
					// echo  '<script>window.location.assign("AddBizBuyUser/index.php"); </script>';break;
			// case 7: 
					// $email=$_SESSION['email'];
					// echo  '<script>window.location.assign("AddBizSellUser/index.php"); </script>';break;
					
		  }
	}
		else{
				$err_msg	=	"Login failed due to incorrect Password/Email-Id.";
			}
	
}
?>

<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:51:52 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="admin-panel/images/Yapnaa_logo-96x96.png">
    <title>Admin | Login</title>

    <link href="admin-panel/css/bootstrap.min.css" rel="stylesheet">
    <link href="admin-panel/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="admin-panel/css/animate.css" rel="stylesheet">
    <link href="admin-panel/css/style.css" rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
			<img src="admin-panel/img/logo.png" style="width:68%"/><br/><br/>
            <h3>Welcome to Movilo</h3>
            <p>Login in. To see it in action.</p>
			<?php if($err_msg){ echo '<span style="color:red">'.$err_msg.'</span>'; } ?><br/>
            <form class="m-t" role="form" method="POST">
                <div class="form-group">
                    <input type="email" class="form-control" name="admin_email_id" id="admin_email_id" placeholder="Email id*" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="admin_password" id="admin_password" class="form-control" placeholder="Password*" required="">
                </div>
                <input id="submit" onclick="myFunction()" type="submit" name="admin_login" class="btn btn-primary block full-width m-b"  value="Login">

               <!-- <a href="forgot-password.php"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="register.html">Create an account</a>-->
            </form>
			
              <p class="m-t"> <small>&copy; <?php echo date('Y');?> <a href="#">Movilo Networks Pvt. Ltd</a>. All Rights Reserved.</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="admin-panel/js/jquery-2.1.1.js"></script>
    <script src="admin-panel/js/bootstrap.min.js"></script>

<script>

function myFunction() {
	
var demo_email = $("#admin_email_id").val();
if ($.trim(demo_email) === '')
{
alert("Please Enter Your Email Id.");
$('#admin_email_id').val('');
$('#admin_email_id').focus();
 return false;
}

if (echeck(demo_email) === false) {

$('#admin_email_id').val('');
$('#admin_email_id').focus();
return false;
}
function echeck(str) {
var emailPat = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
if (!str.match(emailPat))
{
	alert("Please Enter a Valid E-mail ID.");
return false;
}
return true;
}


var demo_requirement = $("#admin_password").val();
if ($.trim(demo_requirement) === '')
{
alert("Please Enter Your Password.");
$('#admin_password').val('');
$('#admin_password').focus(); 
return false;
}

}
</script>

</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:51:52 GMT -->
</html>
