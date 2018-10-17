<?php session_start();
if(isset($_SESSION['user_id'])){
require_once('../controller/user_controller.php');
$obj_user = new users;
$brandcategory=$obj_user->brand_category_list();
$brands_list=$obj_user->n_brand_list();
if(isset($_POST['message']) || !empty($_POST['message'])){
		//echo"here";
		
		
		 $obj_user->n_yapnaa_feedback($_SESSION['user_id'],$_POST['message'],$_POST['yapnaarate']);
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
      <title>Feedback</title>
      <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
      <meta name="viewport" content="width=device-width" />
      <!-- Bootstrap core CSS     -->
      <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
      <!-- Animation library for notifications   -->
      <link href="assets/css/animate.min.css" rel="stylesheet"/>
      <!--  Paper Dashboard core CSS    -->
      <link href="assets/css/paper-dashboard.css" rel="stylesheet"/>
      <!--  Fonts and icons     -->
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
      <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
      <link href="assets/css/themify-icons.css" rel="stylesheet">
   </head>
   <style>
.sidebar .nav p, .off-canvas-sidebar .nav p {
	            font-size:15px !important;
			    text-transform:none !important;
		  }	
/*.star {
	
    visibility:hidden;
    font-size:30px;
    cursor:pointer;
}
.star:before {
   content: "\2606";
   position: absolute;
   visibility:visible;
}
.star:checked:before {
   content: "\2605";
   position: absolute;
}*/

/* Rating Star Widgets Style */
.rating-stars ul {
  list-style-type:none;
  padding:0;
  
  -moz-user-select:none;
  -webkit-user-select:none;
}
.rating-stars ul > li.star {
  display:inline-block;
  
}

/* Idle State of the stars */
.rating-stars ul > li.star > i.fa {
  font-size:2.5em; /* Change the size of the stars */
  color:#ccc; /* Color on idle state */
}

/* Hover state of the stars */
.rating-stars ul > li.star.hover > i.fa {
  color:#FFCC36;
}

/* Selected state of the stars */
.rating-stars ul > li.star.selected > i.fa {
  color:#FF912C;
}
.btn:hover {
   border-color: #ff6010 !important;
    color: #ffffff !important;
   background-color: #ff6010 !important;
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
                  <li>
                     <a href="digi-locker.php">
                        <img style="display:inline-block;" src="assets/img/dashboard/digilocker.svg" alt="Circle Image" height="25" width="25" class=" img-no-padding img-responsive">
                        <p style="padding-left: 15px;display:inline-block;">My digilocker</p>
                     </a>
                  </li>
                  <li >
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
                  <li class="active">
                     <a href="feedback.php">
                         <img style="display:inline-block;" src="assets/img/dashboard/feedback1.svg" alt="Circle Image" height="25" width="25" class=" img-no-padding img-responsive">
                       <p style="padding-left: 15px;display:inline-block;">Feedback</p>
                     </a>
                  </li>
                  <li >
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
                              <h4 class="title">Feedback</h4>
                           </div>
                           <div class="col-md-12" >
                              <div class="content" >
                                 <div class="row" style="text-align: center">
                                    <div class="col-md-12">
									<form method="post" id="contact_us">
                                       <div class="form-group" style="">
										<label  class="form-control" style="margin-bottom: -10px;">Rate your experience</label>										
						                <input class="yapnaarate "  name="yapnaarate" type="text" hidden="hidden"   />
											<section class='rating-widget'>
											  <!-- Rating Stars Box -->
											  <div class='rating-stars text-center'>
												<ul id='stars'>
												  <li class='star' title='Poor' data-value='1'>
													<i class='fa fa-star fa-fw'></i>
												  </li>
												  <li class='star' title='Fair' data-value='2'>
													<i class='fa fa-star fa-fw'></i>
												  </li>
												  <li class='star' title='Good' data-value='3'>
													<i class='fa fa-star fa-fw'></i>
												  </li>
												  <li class='star' title='Excellent' data-value='4'>
													<i class='fa fa-star fa-fw'></i>
												  </li>
												  <li class='star' title='WOW!!!' data-value='5'>
													<i class='fa fa-star fa-fw'></i>
												  </li>
												</ul>
											  </div>
											</section>
                                    </div>
                                   </div>
                                 </div> 
                                <div class="row">
                                    <div class="col-md-12">
									<div class="form-group" style="">
									</div>
								</div>
                               </div>	
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          
                                        <textarea rows="5" class="form-control border-input" placeholder="Any suggestion for improvement" value="Mike" name="message" id="message" maxlength="250" required></textarea>
                                        
									   
									   <input type="text" id="yp_user" value="<?php echo $_SESSION['name'];?>" hidden>
                                    
									   </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="text-center">
                                          <button type="submit"  id="feedback" class="mb-2 footer-btnbtn btn-info btn-fill btn-wd">Submit</button>
                                       </div>
									   </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-lg-4 col-md-5">
                        <div class="card">
                           <div class="content" style="    border: 1px solid #d8d1c9;">
                               <div class="row text-center">
                                 <div class="col-xs-7" style="border-right: 2px solid #d8d1c9;">
                                    <a href="#">
                                    <span style="font-size: 14px;"><i class="fa fa-envelope" style="color:#ff6010;font-size:1.2em !important;"></i> info@yapnaa.com</span>
                                    </a>
                                 </div>
                                 <div class="col-xs-5">
                                    <a href="#" onclick="alert('Coming soon!')">
                                    <span style="font-size: 14px;"><i class="fa fa-comment"></i>	Live chat</span>
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
											Mobile number:
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
	$(document).ready(function(){
  
  /* 1. Visualizing things on Hover - See next part for action on click */
  $('#stars li').on('mouseover', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
   
    // Now highlight all the stars that's not after the current hovered star
    $(this).parent().children('li.star').each(function(e){
      if (e < onStar) {
        $(this).addClass('hover');
      }
      else {
        $(this).removeClass('hover');
      }
    });
    
  }).on('mouseout', function(){
    $(this).parent().children('li.star').each(function(e){
      $(this).removeClass('hover');
    });
  });
  
  
  /* 2. Action to perform on click */
  $('#stars li').on('click', function(){
    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
    var stars = $(this).parent().children('li.star');
    
    for (i = 0; i < stars.length; i++) {
      $(stars[i]).removeClass('selected');
    }
    
    for (i = 0; i < onStar; i++) {
      $(stars[i]).addClass('selected');
    }
    
    // JUST RESPONSE (Not needed)
    var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
	$('.yapnaarate').val(ratingValue);
    var msg = "";
	
    if (ratingValue > 1) {
        msg = "Thanks! You rated this " + ratingValue + " stars.";
    }
    else {
        msg = "We will improve ourselves. You rated this " + ratingValue + " stars.";
    }
    responseMessage(msg);
    
  });
  
  
});


function responseMessage(msg) {
  $('.success-box').fadeIn(200);  
  
  $('.success-box div.text-message').html("<span>" + msg + "</span>");
}
   </script>
</html>
<?php }?>