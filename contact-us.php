<?php
session_start();
$user_name	= $_SESSION['name'];
require_once(__DIR__.'/'.'movilo/controller/user_controller.php');

	 $obj_search = new users;
	if(isset($_POST['email']) || !empty($_POST['email'])){
		//echo"here";
		 $obj_search->n_yapnaa_send_mail($_POST['name'],$_POST['email'],$_POST['subject'],$_POST['message']);
	} 
?>
<!DOCTYPE html>
<html>
   <head>
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-88944414-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-88944414-1');
</script>
      <!-- Basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <title>Yapnaa</title>
	 <link rel="shortcut icon" href="../images/yapnaa-fav.png" type="image/x-icon">
      <meta name="keywords" content="HTML5 Template" />
      <meta name="description" content="Yapnaa - Responsive HTML5 Template">
      <meta name="author" content="okler.net">
      <!-- Favicon -->
      <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
      <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
      <!-- Web Fonts  -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet" type="text/css">
      <!-- Vendor CSS -->
      <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="vendor/animate/animate.min.css">
      <link rel="stylesheet" href="vendor/simple-line-icons/css/simple-line-icons.min.css">
      <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.carousel.min.css">
      <link rel="stylesheet" href="vendor/owl.carousel/assets/owl.theme.default.min.css">
      <link rel="stylesheet" href="vendor/magnific-popup/magnific-popup.min.css">
      <!-- Theme CSS -->
      <link rel="stylesheet" href="css/theme.css">
      <link rel="stylesheet" href="css/theme-elements.css">
      <link rel="stylesheet" href="css/theme-blog.css">
      <link rel="stylesheet" href="css/theme-shop.css">
      <!-- Current Page CSS -->
      <link rel="stylesheet" href="vendor/rs-plugin/css/settings.css">
      <link rel="stylesheet" href="vendor/rs-plugin/css/layers.css">
      <link rel="stylesheet" href="vendor/rs-plugin/css/navigation.css">
      <!-- Skin CSS -->
      <link rel="stylesheet" href="css/skins/skin-app-landing.css">
      <!-- Demo CSS -->
      <link rel="stylesheet" href="css/demos/demo-app-landing.css">
      <!-- Theme Custom CSS -->
      <link rel="stylesheet" href="css/custom.css">
      <!-- Head Libs -->
      <script src="vendor/modernizr/modernizr.min.js"></script>
      <style>
	   @media (max-width: 768px) {
		  
		    .desktop{
			  
			  display:none !important;
			  
		  }
		  .new-sld-text{
		  display:none !important;
		  }
		 
	  } 
	  
	  @media (min-width: 768px) { 
		  
		  .mobile{
			  
			  display:none !important;
			  
		  }
		 
		  
	  }
         @media screen and (min-width: 920px) {
         .mobile {
         display:none;
         }
		 .footer-h2 h4
		 {
		 margin-bottom:25%  !important;
		 }
         }
		 
         @media screen and (max-width: 1199px) {
         .desktop {
         display:none;
         }
		 
		 h4.footer-h2
		 {
		 margin-bottom:6% !important;
		 }
         }
		  @media screen and (max-width: 767px) {
		  img.arrow{
		  margin-top:-4% !important;
		  }
		  }
		  @media screen and (min-width:767), screen and (max-width: 991px) {
		  div.service-options{
		  width:20% !important;
		  margin: 0 auto;
		  }
		 
		  }
		   @media screen and (max-width: 708px) {
		  div.service-options{
		  width:25% !important;
		  margin: 0 auto;
		  }
		  }
		  
		 
		 #how-it-work h4{
		 
		  font-size: 25px;
    margin-bottom: 5%;
		 
		 }
		 
		 .img-center{
		 
		 margin:0 auto;
		 }
		 
		 
		 .testimonial.testimonial-primary {
    background: #fff;
    padding: 3%;
    border-radius: 33px;
    border-bottom: 8px solid #ff6010;
}
	.footer-h2{
	font-size: 1.9em !important;
    font-weight: 600 !important;
    /*margin-bottom: 20px !important;*/
	font-family: GothamRoundedBook;
	    color: #000 !important;
		    margin-top: 16%;
	}	  


footer li a {
    color: #000 !important;
    font-size: 14px;
    font-family: GothamRoundedLight;
    font-weight: bold;
}	

.txt p, .section-description{


    font-size: 16px;
    font-family: GothamRoundedLight;
	color:#000000;

}

.section-title{

    font-weight: bold;
    font-size: 32px;
	font-family: GothamRoundedbook;
	    margin-bottom: 2%;
}
.input-rounded{
border-radius: 20px;
    border: 1px solid #ff6010;
	    width: 80%;
		    margin-bottom: 5%;

}

.footer-btn{

background: #ff6010;
    border: 1px solid #ff6010;
    border-radius: 20px;
    width: 33%;
	color:#fff;

}
.button:hover {
  text-decoration: none;
  background-color: white;
  border-color: white;
  color: black;
}
.inputBox .input {
	color:#000;
}
.drop_down {
	display: block !important;
	box-shadow: none !important;
}
.fa-caret-down {
	position: absolute !important;
    top: 4px !important;
    left: 80px;
}
 .hover_color {
	 color: #404040 !important;
 }
	#dropdown_logout{position: absolute;
    left: 0px;
    font-style: normal;
    font-family: GothamRoundedBook;
    color: #fc7f2b;
    padding: 3px 0;
    width: 85px;
    text-align: left;
    height: 30px;
    overflow: hidden;
    margin-bottom: 4px;
    font-size: 18px;
    line-height: 1.44;}
      </style>
   </head>
   <body>
      <body data-spy="scroll" data-target=".header-nav-main nav" data-offset="65">
         <header id="header" class="header-narrow custom-header-style" data-plugin-options="{'stickyEnabled': false, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 1, 'stickySetTop': '1'}">
            <div class="header-body">
               <div class="header-container container">
                  <div class="header-row">
                     <div class="header-column">
                        <div class="header-logo">
                           <a href="index.php">
                           <img alt="Yapnaa" height="95" width="95" class="img-responsive desktop" src="/img/Yapnaa-logo.svg">
                           <img alt="Yapnaa" height="40" width="40" class="img-responsive mobile" style="margin-top:-1px" src="/img/Yapnaa-logo.svg">
                           </a>
                        </div>
                     </div>
                       <div class="header-column">
                        <div class="header-row">
                           <div class="header-nav header-nav-stripe" style=" ">
                              <button class="btn header-btn-collapse-nav" style="background-color: Transparent;background-repeat:no-repeat;border: none; cursor:pointer;overflow: hidden;outline:none;margin-right:10px;margin-top:-1px" data-toggle="collapse" data-target=".header-nav-main">
                              <i class="fa fa-bars"></i>
                              </button>
                              
                              <div class="header-nav-main header-nav-main-square header-nav-main-effect-1 header-nav-main-sub-effect-1 collapse">
                                 <nav>
                                    <ul class="nav nav-pills" id="mainNav">
                                       <li class="dropdown">
                                          <a  href="index.php">
                                          Home
                                          </a>
                                       </li>
                                       <li class="">
                                          <a href="about-us.php">
                                          About Yapnaa
                                          </a>
                                       </li>
                                       <li class="dropdown dropdown-mega">
                                          <a  href="careers.php">
                                          Careers
                                          </a>
                                       </li>
                                       <li class="dropdown ">
                                          <a href="http://yapnaa.com/blogs/">
                                          Blogs
                                          </a>
                                       </li>
                                      <li class="dropdown">
                                          <a href="contact-us.php">
                                          Contact
                                          </a>
                                        </li>
                                          <?php if(empty($user_name)){?>
										  <li class="dropdown mobile ">
                                          <a href="login.php"  class="mobile">
                                         Login
                                          </a>
                                         </li>
									   <?php }else{?>
									    <li class="dropdown mobile ">
                                         <a><?php echo ucfirst($user_name);?></a>
                                         </li>
										 <li class="dropdown mobile ">
                                         <a  href="/movilo/user-dashboard/dashboard.php" name="logout">My Dashboard</a>
                                         </li>
										 <li class="dropdown mobile ">
                                         <a  href="/movilo/user-dashboard/common-media.php?logout" name="logout">Logout</a>
                                         </li>
									   <?php }?>
                                       <li>
											<ul class="header-social-icons social-icons hidden-xs">
												 <?php if(!empty($user_name)){?>
												<li class="dropdown" style="box-shadow: none">
													<a href="#" class="dropdown-toggle" data-toggle="dropdown" style="background: none">
													  <span id="dropdown_logout"  title='Logout'><?php echo ucfirst($user_name);?></span>
													</a>
													<ul class="dropdown-menu" style="top:112%; left: -51px; min-width: 115px;padding-top: 0px; padding-bottom: 0px;">
													 <li style="box-shadow: none; display: block;border-bottom: 1px solid #eee;border-radius: inherit;margin: 0px;"><a class="hover_color" href="/movilo/user-dashboard/dashboard.php" name="logout"style="background: none; color: #838383 !important;padding:0px 13px;">My Dashboard</a></li>
													 <li style="box-shadow: none; display: block;border-bottom: 1px solid #eee;border-radius: inherit;margin: 0px;"><a class="hover_color" href="/movilo/user-dashboard/common-media.php?logout" name="logout"style="background: none; color: #838383 !important;padding:0px 13px;">Logout</a></li>
													</ul>
												</li>  
												  
												<?php }else{?>
												<a href="login.php" style="background-color:#fc7f2b; border:0; width:100px; border-radius:40px 40px;    font-family: GothamRoundedBook;     font-size: 14px;     margin-top: -4%;
													" class="btn btn-3d btn-primary btn-lg mr-xs mb-sm " >
												LOGIN</a>
												<?php }?>
											  
											</ul>
                                       </li>
                                    </ul>
                                 </nav>
                              </div>
                           </div>
                        </div>
                     </div>
					 
                  </div>
               </div>
            </div>
         </header>
         <div role="main" class="main">
		 <section class="page-header">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h1>Contact</h1>
							</div>
						</div>
					</div>
				</section>
				    <div class="container">

					<div class="row">
						<div class="col-md-6">

							<div class="alert alert-success hidden mt-lg" id="contactSuccess">
								<strong>Success!</strong> Your message has been sent to us.
							</div>

							<div class="alert alert-danger hidden mt-lg" id="contactError">
								<strong>Error!</strong> There was an error sending your message.
								<span class="font-size-xs mt-sm display-block" id="mailErrorMessage"></span>
							</div>

							<h2 class="mb-sm mt-sm"><strong></strong></h2>
							
							<form id="contactForm"  method="POST">
								<div class="row">
									<div class="form-group">
										<div class="col-md-6">
											<label>Your name *</label>
											<input type="text" value="" data-msg-required="Please enter your name." maxlength="100" class="form-control" name="name" id="name" required>
										</div>
										<div class="col-md-6">
											<label>Your email address *</label>
											<input type="email" value="" data-msg-required="Please enter your email address." data-msg-email="Please enter a valid email address." maxlength="100" class="form-control" name="email" id="email" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Subject</label>
											<input type="text" value="" data-msg-required="Please enter the subject." maxlength="100" class="form-control" name="subject" id="subject" required>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="form-group">
										<div class="col-md-12">
											<label>Message *</label>
											<textarea maxlength="5000" data-msg-required="Please enter your message." rows="10" class="form-control" name="message" id="message" required></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<input type="submit"  value="Send Message" class="btn btn-primary btn-lg mb-xlg" data-loading-text="Loading...">
									</div>
								</div>
							</form>
						</div>
						<div class="col-md-6">

							<h4 class="heading-primary mt-lg">Get in <strong>Touch</strong></h4>
							<p>Fill up the form for any queries.</p>

							<hr>

							<h4 class="heading-primary">The <strong>Office</strong></h4>
							<ul class="list list-icons list-icons-style-3 mt-xlg">
								<li><i class="fa fa-map-marker" style="font-size:16px !important;"></i> <strong>Address:</strong> # 6, First Floor,
21st Main Road, 
Near BDA complex,<br> Banashankari 2nd Stage, 
Bangalore - 560070</li>
								<!--li><i class="fa fa-phone" style="font-size:16px !important;"></i> <strong>Phone:</strong>+91 63600 98824</li-->
								<li><i class="fa fa-envelope" style="font-size:16px !important;"></i> <strong>Email:</strong> <a href="mailto:info@yapnaa.com">info@yapnaa.com</a></li>
							</ul>

							<hr>

							<h4 class="heading-primary">Business <strong>Hours</strong></h4>
							<ul class="list list-icons list-dark mt-xlg">
								<li><i class="fa fa-clock-o" style="font-size:18px !important;top: 3px !important;"></i> Monday - Saturday - 10am to 7pm</li>
								
							</ul>

						</div>

					</div>

				</div>
					
				</div>
				
				
            
           
            
			
			
			
			
			
			
            
	  
	  
	  
	  
	  <footer id="footer" class="light">
				<div class="container">
					<div class="row">
						
						<div class="col-lg-3">
							   
								<img src="/img/Yapnaa-logo.svg"  class="img-responsive img-left" height="70" width="70">
								<br>
								<div class="moreDetails">
                              <ul class="address">
                                   <li><i class="fa fa-map-marker" style="color:#ff6010;font-size:1.2em !important;padding: 3px;"></i><span>Movilo Networks Pvt Ltd<br> # 6, First Floor,<br> 21st Main Road, <br>Near BDA complex, Banashankari 2nd Stage, <br>Bangalore - 560070</span></li>
                                 <li><a href="mailto:info@yapnaa.com" style="decoration:none"><i class="fa fa-envelope" style="color:#ff6010;font-size:1.2em !important;padding: 3px;"></i><span>info@yapnaa.com</span></a></li>
                                 <!--li><i class="fa fa-phone" style="color:#ff6010;font-size:1.2em !important;padding: 3px;"></i><span>+91 63600 98824</span></li-->
                              </ul>
                           </div>
							
						</div>
						<div class="col-lg-3">
							<h4 class="footer-h2" style="margin-top: 8%; margin-bottom: 20%;">Useful Links</h4>
							
							<div class="moreDetails">
						   <ul class="list list-icons list-icons-sm">
						   
										<li> <a href="readmore.php" style="text-decoration:none;font-size:16px;" target="_blank">Why us?</a></li>
										<li> <a href="about-us.php#yapnaa_team" style="font-size:16px;" target="_blank">About Team</a></li>
										<li> <a href="for-partners.php" style="font-size:16px;" target="_blank">For Partners</a></li>
										<li> <a href="contact-us.php" style="font-size:16px;" target="_blank">Contact us</a></li>
										<li><a href="terms-condition.php" style="font-size:16px;" target="_blank">Terms of Use</a></li>
										<li> <a href="privacy-policy.php" style="font-size:16px;" target="_blank">Privacy Policy</a></li>
									</ul>
						   
                             
                           </div>
							</div>
						<div class="col-lg-4">
							
								<h4 class="footer-h2" style="margin-top: 5.5%; margin-bottom:16%">Subscribe Newsletter</h4>
								<div class="moreDetails">
								<input type="text" Placeholder="Name" class="form-control input-rounded news-name" id="inputRounded" style="    margin-bottom: 2%;" >
								<input type="email" Placeholder="Email ID" class="form-control input-rounded news-email" id="inputRounded" >
							<button type="button" class="btn footer-btn mb-2 news-latter">Submit</button>
						</div>
						</div>
						<div class="col-lg-2">
							<h4 class="footer-h2" style="margin-top:11%; margin-bottom:35%;">Follow Us</h4>
						<div class="moreDetails">
                              <ul class="adress" id="jk">
                                  <li><a href="https://www.facebook.com/yapnaa/" target="_blank"><i class="fa fa-facebook-square"  style="font-size:32px; color:#3b5998"></i></a></li>
								 <li><a href="https://twitter.com/yapnaa" target="_blank"><i class="fa fa-twitter-square"  style="font-size:32px; color: #33CCFF"></i></a></li>
								  <li><a href="https://www.linkedin.com/company/yapnaa" target="_blank"><i class="fa fa-linkedin-square"  style="font-size:32px; color: #4875B4"></i></a></li>
								 
								  </ul>
                                </div>
						  
						 <a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en" target="_blank"> <img src="/img/Footer/google-play-badge.svg" height="60" width="140"></a>
						</div>
					</div>
				</div>
				<div class="footer-copyright desktop" >
				
					
						<div class="row center desktop" style="line-height:0px">
							
							<div class="col-lg-12 desktop">
							    
								<p class="desktop" style="line-height:0px;">© Copyright 2018. All Rights Reserved.<a href="privacy-policy.php" style="text-decoration:none;color:#fc7f2b"> Movilo Networks Pvt. Ltd</a></p>
								<p class="desktop" style="line-height:0px;">&nbsp;</p>
							</div>
							
						</div>
					<div class="row center desktop" style="line-height:0px">
							
							<div class="col-lg-12 desktop" style="line-height:0px">
								
								<p class="desktop" style="line-height:0px;">Developed by <a href="http://developeronrent.com" style="text-decoration:none;color:#fff">Developer On Rent</a></p> 
								 
							</div>
							
						</div>
				</div>
				
				<div class="footer-copyright mobile" style="margin-bottom:-10px" >
				
					
						<div class="row center mobile" style="line-height:0px">
							
							<div class="col-lg-12 mobile">
							    <p class="mobile"style="line-height:0px">&nbsp;</p>
								
								<p class="mobile" style="line-height:0px">© Copyright 2018. All Rights Reserved.<p class="mobile"><a href="privacy-policy.php" style="text-decoration:none;color:#fc7f2b"> Movilo Networks Pvt. Ltd</a></p></p>
							</div>
							
						</div>
					<div class="row center mobile" style="line-height:0px">
							
							<div class="col-lg-12 mobile" style="line-height:0px">
								
								<p class="mobile" style="line-height:0px;margin-top: -4px;margin-bottom: -15px;">Developed by <a href="http://developeronrent.com" style="text-decoration:none;color:#fff">Developer On Rent</a></p> 
								<p class="mobile">&nbsp;</p> 
							</div>
							
						</div>
				</div>
			</footer>
	  
	  
	  
	  
	  
	  
         <!-- Vendor -->
         <script src="vendor/jquery/jquery.min.js"></script>
         <script src="vendor/jquery.appear/jquery.appear.min.js"></script>
         <script src="vendor/jquery.easing/jquery.easing.min.js"></script>
         <script src="vendor/jquery-cookie/jquery-cookie.min.js"></script>
         <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
         <script src="vendor/common/common.min.js"></script>
         <!--script src="vendor/jquery.validation/jquery.validation.min.js"></script-->
         <script src="vendor/jquery.easy-pie-chart/jquery.easy-pie-chart.min.js"></script>
         <script src="vendor/jquery.gmap/jquery.gmap.min.js"></script>
         <script src="vendor/jquery.lazyload/jquery.lazyload.min.js"></script>
         <script src="vendor/isotope/jquery.isotope.min.js"></script>
         <script src="vendor/owl.carousel/owl.carousel.min.js"></script>
         <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
         <script src="vendor/vide/vide.min.js"></script>
         <!-- Theme Base, Components and Settings -->
         <script src="js/theme.js"></script>
         <!-- Current Page Vendor and Views -->
         <script src="vendor/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
         <script src="vendor/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
         <!-- Current Page Vendor and Views -->
         <script src="js/views/view.contact.js"></script>
         <!-- Demo -->
         <script src="js/demos/demo-app-landing.js"></script>
         <!-- Theme Custom -->
         <script src="js/custom.js"></script>
         <!-- Theme Initialization Files -->
         <script src="js/theme.init.js"></script>
		  <script>
		 $('.news-latter').click(function(){
				var name=$('.news-name').val();
				var email=$('.news-email').val();
				if(!email || !name){
					alert('please provide name and email id');
					return false;
				}
				  $.ajax({
						url: "new_customer_engagment.php?news_later=submit", //This is the page where you will handle your SQL insert
						type:"POST",
						data:{name:name,email:email},
						success:function(response){
							console.log(response);
							if(response){
								alert("Thank you for subscribing Newsletter.");
								location.reload();
							}
						},
						error:function(error){
							alert(JSON.stringify(error));
						}
					}); 
				
			});
		 </script>
         <!-- Google Analytics: Change UA-XXXXX-X to be your site's ID. Go to http://www.google.com/analytics/ for more information.
            <script>
            	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            
            	ga('create', 'UA-12345678-1', 'auto');
            	ga('send', 'pageview');
            </script>
             -->
        
   </body>
</html>