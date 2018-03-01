
	<style>
		.dataTables_filter{
			float:right;
		}
		.nav-header {
        padding: 0px 52px !important;
    
       }
	</style>
<?php
session_start(); 
if(isset($_SESSION['admin_email_id']))
{
	 $admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];
	 $ar_role_name  	= $_SESSION['ar_role_name'];
	 $admin_phone_no  	= $_SESSION['admin_phone_no'];
	 $ar_id  	        = $_SESSION['ar_id'];
	require_once('controller/admin_controller.php');
}
?>
	<nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image"  src="img/logo.png" style="width:88%"/>
                             </span>
							<a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <!--span class="block m-t-xs"> <strong class="font-bold"><?php echo $admin_email_id;?></strong>
                             </span--> <span class="font-bold" style="margin-left:31px"><?php echo ucfirst($admin_name);?> <b class="caret"></b></span> </span> </a>
							<ul class="dropdown-menu animated fadeInRight m-t-xs">
								<li><a  data-toggle="modal" data-target="#myModal">Change Password</a></li>
								<li class="divider"></li>
								<li><a href="../logout.php">Logout</a></li>
							</ul>
                        </div>
						<?php switch($ar_id){
                               case 1:			?>
					<li>
                        <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    </li>
					<li>
                        <a href="users.php"><i class="fa fa-user"></i> User List</a>
                    </li>
					<li>
                        <a href="brand_customers.php?customer_type=2"><i class="fa fa-search"></i>  Zero B Data</a>
                    </li>
					<!--li>
                        <a href="zerob_customers.php"><i class="fa fa-search"></i> Search ZeroB Data</a>
                    </li-->
					<li>
                        <a href="brand_customers.php?customer_type=1"><i class="fa fa-search"></i>  Livpure Data</a>
                    </li>
					<li>
                        <a href="srm-list.php"><i class="fa fa-send"></i>SRM Requests</a>
                    </li>
					<li>
                        <a href="amc-requests.php"><i class="fa fa-clock-o"></i>AMC Requests</a>
                    </li>
					<li>
                        <a href="send-sms.php"><i class="fa fa-comments"></i> Send SMS</a>
                    </li>
					 <li>
                        <a href="user_notifications.php"><i class="fa fa-bell"></i>Notifications</a>
                    </li>
					 <li>
                        <a href="products-category.php"><i class="fa fa-th-list"></i> Category</a>
                    </li>
					<li>
                        <a href="brand-list.php"><i class="fa fa-edit"></i> Brand List</a>
                    </li>
                  
                    <li>
                        <a href="brand-products.php"><i class="fa fa-th-large"></i> Brand Products</a>
                    </li>
					

                    <li>
                        <a href="users_product.php"><i class="fa fa-user"></i>All users products</a>
                    </li>
					<li>
                        <a href="amc-price-list.php"><i class="fa fa-clock-o"></i>AMC Price List</a>
                    </li>
                    <li >
                      <a href="add-banner.php">
                        <i class="fa fa-picture-o">
                          <b class="bg-success"></b>
                        </i> 
                        <span>Banner Images</span>
                      </a> 
                    </li>
                    <li>
                        <a href="add-faq.php"><i class="fa fa-question"></i> Add FAQ's</a>
                    </li>
					
					<li>
                        <a href="apk-version-update.php"><i class="fa fa-android"></i>APK Version Update</a>
                    </li>
					
                   
						<?php break;
						case 2:?>
						
						<li>
                        <a href="index.php"><i class="fa fa-home"></i> Home</a>
                    </li>
					<li>
                        <a href="users.php"><i class="fa fa-user"></i> User List</a>
                    </li>
					<li>
                        <a href="brand_customers.php?customer_type=2"><i class="fa fa-search"></i>  Zero B Data</a>
                    </li>
					<!--li>
                        <a href="zerob_customers.php"><i class="fa fa-search"></i> Search ZeroB Data</a>
                    </li-->
					<li>
                        <a href="brand_customers.php?customer_type=1"><i class="fa fa-search"></i>  Livpure Data</a>
                    </li>
					<li>
                        <a href="srm-list.php"><i class="fa fa-send"></i>SRM Requests</a>
                    </li>
					<li>
                        <a href="amc-requests.php"><i class="fa fa-clock-o"></i>AMC Requests</a>
                    </li>
					<li>
                        <a href="send-sms.php"><i class="fa fa-comments"></i> Send SMS</a>
                    </li>
					 <li>
                         <a href="user_notifications.php"><i class="fa fa-bell"></i>Notifications</a>
                    </li>
					 <li>
                        <a href="products-category.php"><i class="fa fa-th-list"></i> Category</a>
                    </li>
					<li>
                        <a href="brand-list.php"><i class="fa fa-edit"></i> Brand List</a>
                    </li>
                  
                    <li>
                        <a href="brand-products.php"><i class="fa fa-th-large"></i> Brand Products</a>
                    </li>
					

                    <li>
                        <a href="users_product.php"><i class="fa fa-user"></i>All users products</a>
                    </li>
					<li>
                        <a href="amc-price-list.php"><i class="fa fa-clock-o"></i>AMC Price List</a>
                    </li>
                    <li >
                      <a href="add-banner.php">
                        <i class="fa fa-picture-o">
                          <b class="bg-success"></b>
                        </i> 
                        <span>Banner Images</span>
                      </a> 
                    </li>
                    <li>
                        <a href="add-faq.php"><i class="fa fa-question"></i> Add FAQ's</a>
                    </li>
					
					<li>
                        <a href="apk-version-update.php"><i class="fa fa-android"></i>APK Version Update</a>
                    </li>
						
						<?php
						break;
						case 3:?>
						
					<li>
                        <a href="send-sms.php"><i class="fa fa-comments"></i> Send SMS</a>
                    </li>
				
					<li>
                        <a href="brand_customers.php?customer_type=2"><i class="fa fa-search"></i>  Zero B Data</a>
                    </li>
					<!--li>
                        <a href="zerob_customers.php"><i class="fa fa-search"></i> Search ZeroB Data</a>
                    </li-->
					<li>
                        <a href="brand_customers.php?customer_type=1"><i class="fa fa-search"></i>  Livpure Data</a>
                    </li>
					
						<?php
						break;
						case 4:?>
						<li>
                       <a href="zerob_customers.php"><i class="fa fa-search"></i>  Zero B Data</a>
						</li>
						<!--li>
                        <a href="brand_customers.php?customer_type=1"><i class="fa fa-search"></i> Search Livpure Data</a>
                    </li-->
					 <?php
					break;
					case 5:?>
						
					
				    <li>
                        <a href="users.php"><i class="fa fa-user"></i> User List</a>
                    </li>
					<li>
                        <a href="brand_customers.php?customer_type=2"><i class="fa fa-search"></i>  Zero B Data</a>
                    </li>
					<!--li>
                        <a href="zerob_customers.php"><i class="fa fa-search"></i> Search ZeroB Data</a>
                    </li-->
					<li>
                        <a href="brand_customers.php?customer_type=1"><i class="fa fa-search"></i>  Livpure Data</a>
                    </li>
					<li>
                        <a href="srm-list.php"><i class="fa fa-send"></i>SRM Requests</a>
                    </li>
					<li>
                        <a href="amc-requests.php"><i class="fa fa-clock-o"></i>AMC Requests</a>
                    </li>
					<li>
                        <a href="send-sms.php"><i class="fa fa-comments"></i> Send SMS</a>
                    </li>
					
						<?php }?>
                    
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
			<ul class="nav navbar-top-links navbar-right">
                 <li>
                        <i class="fa fa-clock-o"></i> Last Login : <?php echo $admin_last_login;?>
                </li>
				<li>
                    <a href="../logout.php">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
                <li>
                    <a class="right-sidebar-toggle">
                        <i class="fa fa-tasks"></i>
                    </a>
                </li>
            </ul>

        </nav>
		
		
		
		<?php 
		
		if(isset($_POST['reset_password']))
		{
			$email_id		=	$_POST['email'];
			$password		=	$_POST['password'];
			$conf_password	=	$_POST['conf_password'];
			
			$password   =   md5($password);
			$login_val	=	$control->admin_password_update($email_id,$password);
			// print_r($login_val);exit;
			if(!empty($login_val)){
				echo '<script>alert("Password changed successfully.")</script>';
					echo '<script>window.location.assign("../logout.php")</script>';
			}
		}
		?>
		
		<div class="modal fade" id="myModal" role="dialog">
			<div class="modal-dialog modal-sm">
			
			  <!-- Modal content-->
			  <div class="modal-content">
				<div class="modal-header">
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				  <h4 class="modal-title">Change your password !</h4>
				</div>
				<div class="modal-body">
				 <form class="m-t" role="form" action="" method="POST">
					<div class="form-group">
						<input type="hidden" name="email" class="form-control" value="<?php echo $admin_email_id;?>" placeholder="Password" required="">
						<input type="password" name="password" id="password" class="form-control" placeholder="Password" required="">
					</div>
					<div class="form-group">
						<input type="password" name="conf_password" id="conf_password" class="form-control" placeholder="Confrim Password" required="">
					</div>
					<input id="submit" onclick="password_change()" type="submit" name="reset_password" class="btn btn-primary block full-width m-b"  value="Update">
				</form>
				</div>
			  </div>
			  
			</div>
		</div>
  
<script>

function password_change() {
	
var password = $("#password").val();
if ($.trim(password) === '')
{
alert("Please Enter password.");
$('#password').val('');
$('#password').focus();
 return false;
}

var conf_password = $("#conf_password").val();
if ($.trim(conf_password) === '')
{
alert("Please Enter Confirm password.");
$('#conf_password').val('');
$('#conf_password').focus();
 return false;
}


if (password != conf_password)
{
alert("Password Mismatch.");
$('#conf_password').val('');
$('#conf_password').focus();
return false;
}


}
</script>