<?php session_start();
require_once('../controller/user_controller.php');
$obj_user = new users;
$produtcat=  $obj_user->get_product_cat_list();
$dl_user_id=$_SESSION['user_id']; 
if(isset($_POST['fileName'])){
	//print_r($_POST);die;
	$extension = end(explode(".", $_FILES['file_name']['name']));
    if($extension=='pdf'){
		$dl_doc_type=1;
	}
	else if($extension=='doc' || $extension=='docx' || $extension=='docs'){
		$dl_doc_type=2;
	}
	else if($extension=='jpg' || $extension=='png' || $extension=='gif' || $extension=='jpeg'){
		$dl_doc_type=3;
	}
	else{
		echo "<script>alert('The Document type is not accepted. Please provide pdf,doc,docs,docx,jpg,png,gif,
jpeg')</script>";
        echo "<script>window.location.assign('digi-locker.php')</script>";
	}
	$dl_product_type_id=$_POST['dl_product_type_id'];
	$_SESSION['dl_product_type_id']=$_POST['dl_product_type_id'];
	
	$dl_product_id='';
	$dl_doc_name=$_POST['fileName'];
    $produtcat=  $obj_user->upload_digilocker_dashboard($dl_product_type_id,$dl_user_id,$dl_doc_type,$dl_product_id,$dl_doc_name);
	
		
		//echo "<script>location.reload(true)</script>";
			
}

if(isset($_POST['saveProfile'])){
	
	$myproduct=  $obj_user->update_user_profile_dashboard();
	if($myproduct !=NULL)
	{
		echo '<script>alert("Your profile has been updated successfully. Please do re-login to apply the changes! ")</script>';
		 
	}
}
?>
<!doctype html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      
     <link rel="shortcut icon" href="../../images/yapnaa-fav.png" type="image/x-icon">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
      <title>Service Request</title>
      <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
      <meta name="viewport" content="width=device-width" />
      <!-- Bootstrap core CSS     -->
      <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
      <!-- Animation library for notifications   -->
      <link href="assets/css/animate.min.css" rel="stylesheet"/>
      <!--  Paper Dashboard core CSS    -->
      <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>
      <!--  Fonts and icons     -->
      <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
      <link href="assets/css/themify-icons.css" rel="stylesheet">
   </head>
   <style>
   .pointer {cursor: pointer;}
   .save{
	background-color: #5740c9 !important;
    border-color: #5740c9 !important;
}
   .sidebar .nav p, .off-canvas-sidebar .nav p {
	            font-size:15px !important;
			    text-transform:none !important;
		  }	
h6, .h6 {
text-transform:none !important;
}	
.card h6 {
font-size: 13px;

}
   </style>
   <body>
      <div class="wrapper">
         <div class="sidebar" data-background-color="white" data-active-color="danger">
            <!--
               Tip 1: you can change the color of the sidebar's background using: data-background-color="white | black"
               Tip 2: you can change the color of the active button using the data-active-color="primary | info | success | warning | danger"
               -->
            <div class="sidebar-wrapper">
               <div class="logo">
                  <a href="https://yapnaa.com" class="simple-text">
                  <img alt="Yapnaa" height="60" width="60" class="img-responsive " style="    margin: 0 auto;" src="https://yapnaa.com//img/Yapnaa-logo.svg">
                  </a>
               </div>
               <ul class="nav">
                  <li style="background: #384861;    padding-top: 1%;" class="hidden-xs">
                     <a style="color:#fff;" >
                       
					<img style="display:inline-block;" src="assets/img/dashboard/menu.svg" alt="Circle Image" height="25" width="25" class=" img-no-padding img-responsive">
                      <p style="padding-left: 15px;display:inline-block;">Menu</p>
                     </a>
                  </li>
                  <li >
                     <a href="dashboard.php">
                       <img style="display:inline-block;" src="assets/img/dashboard/dashboard.svg" alt="Circle Image" height="25" width="25" class=" img-no-padding img-responsive">
                       <p style="padding-left: 15px;display:inline-block;">Dashboard</p>
                     </a>
                  </li>
                  <li>
                     <a href="myproduct.php">
                        <img style="display:inline-block;" src="assets/img/dashboard/myproduct.svg" alt="Circle Image" height="25" width="25" class=" img-no-padding img-responsive">
                        <p style="padding-left: 15px;display:inline-block;">My Products</p>
                     </a>
                  </li>
                  <li class="active">
                     <a href="digi-locker.php" >
                        <img style="display:inline-block;" src="assets/img/dashboard/digilocker3.svg" alt="Circle Image" height="25" width="25" class=" img-no-padding img-responsive">
                        <p style="padding-left: 15px;display:inline-block;">My digilocker</p>
                     </a>
                  </li>
                  <li>
                     <a href="service-request.php">
                        <img style="display:inline-block;" src="assets/img/dashboard/service.svg" alt="Circle Image" height="25" width="25" class=" img-no-padding img-responsive">
                        <p style="padding-left: 15px;display:inline-block;">Service Request</p>
                     </a>
                  </li>
                  <li>
                     <a href="myticket.php">
                         <img style="display:inline-block;" src="assets/img/dashboard/ticket.svg" alt="Circle Image" height="25" width="25" class=" img-no-padding img-responsive">
                       <p style="padding-left: 15px;display:inline-block;">My Tickets</p>
                     </a>
                  </li>
                  <li>
                     <a href="feedback.php">
                         <img style="display:inline-block;" src="assets/img/dashboard/feedback.svg" alt="Circle Image" height="25" width="25" class=" img-no-padding img-responsive">
                       <p style="padding-left: 15px;display:inline-block;">Feedback</p>
                     </a>
                  </li>
                  <li>
                     <a href="contact-us.php">
                        <img style="display:inline-block;" src="assets/img/dashboard/contact.svg" alt="Circle Image" height="25" width="25" class=" img-no-padding img-responsive">
                       <p style="padding-left: 15px;display:inline-block;">Contact us</p>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
         <div class="main-panel">
            <nav class="navbar navbar-default" >
               <div class="container-fluid">
                  <div class="navbar-header">
                     <div class="col-xs-6">
                        <a href="https://yapnaa.com" class="simple-text hidden-lg hidden-md">
                        <img alt="Yapnaa" height="60" width="60" class="img-responsive "  src="https://yapnaa.com//img/Yapnaa-logo.svg">
                        </a>
                     </div>
                     <div class="col-xs-6">
                        <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                        </button>
                     </div>
                  </div>
                  <div class="collapse navbar-collapse">
                     <ul class="nav navbar-nav navbar-right"    >
                        <li>
						 <a href="https://yapnaa.com" style="height:0;margin:0; " >
                           <button class="btn btn-default btn-block" >Visit Website</button>
						   </a>
                        </li>
                        <li class="dropdown">
                           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              <i class="ti-user"></i>
                              <p><?php echo $_SESSION['name'];?></p>
                              <b class="caret"></b>
                           </a>
                           <ul class="dropdown-menu">
						       <li><a data-target="#myProfile" data-toggle="modal"  style="cursor:pointer" name="my profile">My Profile</a></li>
                               <li><a href="/movilo/user-dashboard/common-media.php?logout"  name="logout">Logout</a></li>
                           </ul>
                        </li>
                     </ul>
                  </div>
               </div>
            </nav>
            <div class="content">
               <div class="container-fluid">
                  <div class="row">
                     <div class="col-md-8">
                        <div class="card">
                           <div class="col-md-12">
                              <h4 class="title">Digilocker</h4>
                           </div>
						   
                           <div class="col-md-12" style="background:#f4f3ef;padding-bottom: 3%;">
                              <div class="content" >
                                 <?php foreach($produtcat as $product){
									 ?>
                                 <div class="col-md-3">
                                    <div class="avatar">
                                       <img onclick="brandList(<?php echo $product['p_category_id'];?>)" data-toggle="modal" src="../product-icon/<?php echo $product['p_category_icon_small'];?>" data-target="#myModal" alt="Circle Image" height="100" width="100" class="pointer img-no-padding img-responsive img-center">
								     </div>
                                    <h6 onclick="brandList(<?php echo $product['p_category_id'];?>)" class="title pointer text-center" data-toggle="modal" data-target="#myModal"><?php echo $product['p_category_name'];?></h6>
                                    <p style="text-align:center">
									<a href="digi-locker-product-details.php?cat=<?php echo $product['p_category_id'];?>&user=<?php echo $dl_user_id;?>"><input type="button" value="add"></a>
									</p>
                                 </div>
									 
									 <?php }?>
                              </div>
                           </div>
                           
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-5">
                        <div class="card">
                           <div class="content" style="    border: 1px solid #d8d1c9;">
                              <div class="row text-center">
                                  <div class="col-xs-6" style="border-right: 2px solid #d8d1c9;">
                                    <a href="#">
                                    <span style="font-size: 16px;"> Reach us<br>(info@yapnaa.com)</span>
                                    </a>
                                 </div>
                                 <div class="col-xs-6">
                                    <a href="#" onclick="alert('Coming soon!')">
                                    <span style="font-size: 20px;"><i class="fa fa-comment"></i>	Live chat</span>
                                    </a>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="card">
                           <div class="header">
                              <h4 class="title text-center">Useful Information</h4>
                           </div>
                           <div class="content" style="    border: 1px solid #d8d1c9;">
                              <ul class="list-unstyled team-members">
                                 <li>
                                    <div class="row">
                                       <div class="col-xs-3">
                                          <div class="avatar">
                                             <img src="assets/img/dashboard/amc_renual.svg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                          </div>
                                       </div>
                                       <div class="col-xs-9">
                                          AMC Renewal
                                          <br>
                                          <span class="text-muted"><small>Now renew service contract and extend warranty to secure your products.</small></span>
                                       </div>
                                    </div>
                                 </li>
                                 <li>
                                    <div class="row">
                                       <div class="col-xs-3">
                                          <div class="avatar">
                                             <img src="assets/img/dashboard/service_request.svg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                          </div>
                                       </div>
                                       <div class="col-xs-9">
                                          Service Request
                                          <br>
                                          <span class="text-muted"><small>Request authorized service now on  single tap. Just register your product once.</small></span>
                                       </div>
                                    </div>
                                 </li>
                                 <li>
                                    <div class="row">
                                       <div class="col-xs-3">
                                          <div class="avatar">
                                             <img src="assets/img/dashboard/digilocker2.svg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                          </div>
                                       </div>
                                       <div class="col-xs-9">
                                          Digilocker
                                          <br>
                                          <span class="text-muted"><small>Get rid of storing hard copies, invoices, warranty cards, use digilocker to save , secure and access your bills anytime, anywhere</small></span>
                                       </div>
                                    </div>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <footer class="footer">
               <div class="container-fluid">
                  <!--nav class="pull-left">
                     <ul>
                        <li>
                           <a href="#">
                           Home
                           </a>
                        </li>
                        <li>
                           <a href="#">
                           Blog
                           </a>
                        </li>
                        <li>
                           <a href="#">
                           Contact
                           </a>
                        </li>
                     </ul>
                  </nav-->
                  <div class="copyright pull-right">
                     &copy; <script>document.write(new Date().getFullYear())</script>. All Rights Reserved. Movilo Networks Pvt. Ltd.
                  </div>
               </div>
            </footer>
         </div>
      </div>
	  
	  <div id="myModal" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title">Digilocker!</h4>
				  </div>
				  <div class="modal-body">
				  <form action="" method="POST" enctype="multipart/form-data"> 
							 <div class="row">
							 <div class="col-md-12"> 
							  <div class="col-md-4">
									<label>Enter Title</label>
									<input type="text" id="fileName" style="max-width: 132px" name="fileName">
									<input hidden  type="text" id="dl_product_type_id" style="max-width: 132px" name="dl_product_type_id" required>
								</div>
							   <div class="col-md-4">
									<label>Product Type</label>
									<input type="file" id="file_name" style="max-width: 132px" name="file_name" required>
								</div>
								
							</div>
								
						</div> 
						<div class="modal-footer">
							<input type="submit" id="digilockerForm" name="digilockerForm" class="btn btn-default save" value="Save">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</form>
					</div>
				  
				  
				  
				</div>
              </div> 
			</div>
	  
	  	  		 <!--modal-->
		<div id="myProfile" class="modal fade" role="dialog">
			  <div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4 class="modal-title">Profile Details!</h4>
				  </div>
				  <div class="modal-body">
				  <form action="" method="POST"> 
							 <div class="row">
							 <div class="col-md-10">
							   <div class="col-md-10" >
									
										<div class="row">
											<span>
											Name:
											<?php if(!empty($_SESSION['name']) || $_SESSION['name'] !='' || $_SESSION['name'] !=NULL){
											  
											   echo $_SESSION['name'];
											   }else{  ?>
											   
											
											<input type="text" name="profile_name">
											<?php } ?>
											</span>
										</div>									
										<div class="row">
											<span>
											Phone nunber:
											 <?php if(!empty($_SESSION['user_phone']) || $_SESSION['user_phone'] !='' || $_SESSION['user_phone'] !=NULL){
											  
											   echo $_SESSION['user_phone'];
											    }else{ 
											   ?>
											  <input type="text" name="profile_phone_number"> 
											  <?php } ?>
											</span>
										</div>
										<div class="row">
											<span>
											Email Id:
											  <?php if(!empty($_SESSION['user_email_id']) || $_SESSION['user_email_id'] !='' || $_SESSION['user_email_id'] !=NULL){
											  
											   echo $_SESSION['user_email_id'];
											    }else{ 
											   ?>
											  <input type="text" name="profile_email_id"> 
											  <?php } ?>
											</span>
										</div>
										
									
								</div>
								
								
								
							</div>
								
						</div>
                     <div class="modal-footer">
					<?php if(empty($_SESSION['name']) || empty($_SESSION['user_phone']) || empty($_SESSION['user_email_id'])){?>
											  
						<input type="submit" id="saveProfile" name="saveProfile" class="btn btn-default save" value="save">
						<?php } ?>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>						
					</form>
					</div>
				  
				  
				  
				</div>
              </div> 
			</div>
	  
   </body>
   <!--   Core JS Files   -->
   <script src="assets/js/jquery-1.10.2.js" type="text/javascript"></script>
   <script src="assets/js/bootstrap.min.js" type="text/javascript"></script>
   <!--  Google Maps Plugin    -->
   <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
   <!-- Paper Dashboard Core javascript and methods for Demo purpose -->
   <script src="assets/js/paper-dashboard.js"></script>
   <script>
  
   function brandList(catId){
	   $('#dl_product_type_id').val(catId);
   }
   $( "#deleteProductForm" ).click(function() {
		 confirm("Are you sure!");
	      var del_up_id =$('#upId').html();
	      var del_user_id =<?php echo $_SESSION['user_id'];?>;
	      
		 
			$.ajax({
			url: "common-media.php?deleteProduct=submit", //This is the page where you will handle your SQL insert
			type:"POST",
			data:{del_user_id:del_user_id,del_up_id:del_up_id},
			success:function(response){
				alert("Product deleted successfully !");
				location.reload(true);
			},
			error:function(error){
				alert(JSON.stringify(error));
			}
		});  
     });
   </script>
</html>