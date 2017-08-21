<?php	
session_start(); 
error_reporting(E_ALL);  
require_once("../config/tab_config.php"); 
require_once("../config/config.php"); 


require_once("../model/model.php"); 
$obj_model	=	new model();

require_once('../controller/admin_controller.php'); 
$admin_controller = new admin;
$err_msg	=	'';

/* Login form submission*/
if(isset($_POST['admin_login']))
{  
	$login_val	=	$admin_controller->admin_login();  
	// echo '<pre>';
	// print_r($login_val);exit;
	if($login_val!=1 && $login_val !=''){
	
		$_SESSION['ad_id']					=	$login_val['sp_id'];
		$_SESSION['ad_name']				=	$login_val['sp_name'];
		$_SESSION['ad_email_id']			=	$login_val['sp_email_id'];
		$_SESSION['ad_mobile_no']			=	$login_val['sp_mobile_no'];
		$_SESSION['ad_role_id']				=	$login_val['sp_role_id'];
		$_SESSION['ad_registration_date']	=	$login_val['sp_registration_date'];
		$_SESSION['ad_last_login']			=	$login_val['sp_last_login'];
		$_SESSION['ad_status']				=	$login_val['sp_status'];  
		$_SESSION['ad_profile_img']			=	$login_val['sp_profile_pic'];  
	}
	
	
	
	
	if($login_val!=1 && $login_val !=''){
		switch($login_val['sp_role_id'])
		  {
			case 1: 
					echo  '<script>window.location.assign("admin-views/index.php"); </script>';
					break;
			  
			case 2: 
					echo  '<script>window.location.assign("admin-views/index.php"); </script>';
					break;
			// case 3: 
					// $email=$_SESSION['email'];
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
	}elseif($login_val==1){
		$err_msg	=	"Your account hasbeen blocked. Please contact admin";
	}else{
				$err_msg	=	"Login failed due to incorrect Password/Email-Id.";
			}
	
}
?>
<!DOCTYPE html>
<html lang="en" class="bg-dark">
<head>
  <meta charset="utf-8" />
  <title>NoQ | Admin Panel</title>  
  <link rel="stylesheet" href="admin-views/css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="admin-views/css/animate.css" type="text/css" />
  <link rel="stylesheet" href="admin-views/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="admin-views/css/font.css" type="text/css" />
  <link rel="stylesheet" href="admin-views/css/app.css" type="text/css" /> 
</head>
<body>
  <section id="content" class="m-t-lg wrapper-md animated fadeInUp">    
    <div class="container aside-xxl">
      <a class="navbar-brand block" href="index.html">NoQ</a>
      <section class="panel panel-default bg-white m-t-lg">
        <header class="panel-heading text-center">
          <strong>Sign in</strong>
        </header>
        <form method="POST" class="panel-body wrapper-lg">
		<?php if($err_msg){ echo '<span style="color:red">'.$err_msg.'</span>'; } ?><br/>
          <div class="form-group">
            <label class="control-label">Email</label>
            <input type="email" placeholder="test@example.com" name="admin_email_id"    value="vajidattar.jjbytes@gmail.com" class="form-control input-lg">
          </div>
          <div class="form-group">
            <label class="control-label">Password</label>
            <input type="password" id="inputPassword" placeholder="Password" name="admin_password"   value="admin"  class="form-control input-lg">
          </div>  
          <input id="submit" onclick="myFunction()" type="submit" name="admin_login" class="btn btn-primary block full-width m-b"  value="Sign in"> 
        </form>
      </section>
    </div>
  </section>
  <!-- footer -->
  <footer id="footer">
    <div class="text-center padder">
      <p>
        <small>Powered by - <a href="#" target="_blank">JJ Bytes Pvt Ltd</a>  &copy; <?php echo date('Y');?></small>
      </p>
    </div>
  </footer>
  <!-- / footer -->
  <script src="admin-views/js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="admin-views/js/bootstrap.js"></script>
  <!-- App -->
  <script src="admin-views/js/app.js"></script>
  <script src="admin-views/js/app.plugin.js"></script>
  <script src="jadmin-views/s/slimscroll/jquery.slimscroll.min.js"></script>
  
</body>
</html>