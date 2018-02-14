<?php 

$Values= unserialize(urldecode($_GET['vals']));
//print_r($Values);exit;
require_once(__DIR__.'/'.'movilo/controller/user_controller.php');
$obj_user = new users;
$brandcategory=$obj_user->brand_category_list();
if(isset($_POST['search_query']) && !empty($_POST['search_query'])){
	
	 $brands_list=$obj_user->search_result($_POST['search_query']);
     
}
  
  
/* $search_res=$obj_user->search_result1($b);
foreach($search_res as $a){
	  print_r($a);
  } */
?>


<!DOCTYPE html>
<html>
   <head>
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
      <!--link rel="stylesheet" href="css/theme-shop.css"-->
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
	  @media (max-width: 600px){
			#searchForm {
				 display: block; 
			}
	  }
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
	  .thumb-info-social-icons a {
	         padding-left: 6px !important;
			 padding-top: 2px !important;
	  }
	  @media (min-width: 768px){
		
		.lead {
			font-size: 18px !important;
		}}
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

/* make sidebar nav vertical */ 
@media (min-width: 768px) {
  .sidebar-nav .navbar .navbar-collapse {
    background-color: #fff;	  
    padding: 0;
    max-height: none;
  }
  .sidebar-nav .navbar ul {
    float: none;
    display: block;
  }
  .sidebar-nav .navbar li {
    float: none;
    display: block;
  }
  .sidebar-nav .navbar li a {
    padding-top: 12px;
    padding-bottom: 12px;
  }
}
.fa-rotate-90 {
    -webkit-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -ms-transform: rotate(90deg);
    -o-transform: rotate(90deg);
    transform: rotate(90deg);
}
.container1 {
				    padding-right: 0px !important;
					padding-left: 0px !important;
			}
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
                           <div class="header-nav header-nav-stripe" style="    margin-right: -38px;">
                              <button class="btn header-btn-collapse-nav" style="background-color: Transparent;background-repeat:no-repeat;border: none; cursor:pointer;overflow: hidden;outline:none;margin-right:10px;margin-top:-1px" data-toggle="collapse" data-target=".header-nav-main">
                              <i class="fa fa-bars"></i>
                              </button>
                              <ul class="header-social-icons social-icons hidden-xs">
							  <a href="login.php" style="background-color:#fc7f2b; border:0; width:100px; border-radius:40px 40px;    font-family: GothamRoundedBook;     font-size: 14px;     margin-top: -4%;
                                    " class="btn btn-3d btn-primary btn-lg mr-xs mb-sm " >
                                LOGIN</a>
                              </ul>
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


										  <li class="dropdown mobile">
                                          <a href="login.php"  class="mobile">
                                         Login
                                          </a>
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
							<div class="col-md-6">
							  <form id="searchForm" action="#" method="post" novalidate="novalidate">
								<div class="input-group">
                                 <input type="text" style="
                                    height: 48px;
                                    border-top: 2px solid #fc7f2b;
                                    border-left: 2px solid #fc7f2b;
                                    border-bottom: 2px solid #fc7f2b;
                                    border-top-left-radius: 15px;
                                    border-bottom-left-radius: 15px;
                                    " class="form-control" name="search_query" id="search_query" placeholder="Search brands, service center,customer care..." required="" aria-required="true">
                                 <span class="input-group-btn">
                                 <button class="btn btn-default " style="
                                    height: 48px;
                                    border-top: 2px solid #fc7f2b;
                                    border-right: 2px solid #fc7f2b;
                                    border-bottom: 2px solid #fc7f2b;
                                    border-left: none;
                                    border-top-right-radius: 15px;
                                    border-bottom-right-radius: 15px;
									position: relative;
									margin: 0px -6px 29px -2px;
                                    " type="submit"><i style="color: #fc7f2b;
                                    font-size: 27px;" class="fa fa-search"></i></button>
                                 </span>
                              </div>
							  </form>
							</div>
							<div class="col-md-6">
								<div >
								<h3 style="color:#fff" hidden>Search result for</h3>
								</div>
								</div>
						</div>
					</div>
				</section>
				    
				</div>
            
           
           <div class="col-md-12"> 
			<div class="container">
		<div class="row">
		  <div class="col-sm-3">
			<!--div class="sidebar-nav">
			  <div class="navbar navbar-default" role="navigation">
				<div class="navbar-header">
				  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				  </button>
				  <span class="visible-xs navbar-brand">Sidebar menu</span>
				</div>
				<!--div class="navbar-collapse collapse sidebar-navbar-collapse">
				  <ul class="nav navbar-nav" >
				   <li  ><a  href="#" ><h4>Filter Out Your search</h2></a></li>
				   <?php foreach($brandcategory as $brand){?>
					<li ><a href="#" ><?php echo $brand['p_category_name']; ?></a></li>
				   <?php }?>
					
				  </ul>
				</div--><!--/.nav-collapse -->
			 <!-- </div>-->
			</div>
		  </div>
  <div class="col-sm-9">
   <div class="container " style="padding-right:0px;padding-left:0px;">
   <?php foreach ($Values as $key=>$value){?>
	<div class="row" style="padding:10px">
	
		<div class="col-sm-5" style="background-color:#fff;padding: 10px;">	<div class=" col-sm-5 moreDetails">
				  <ul class="address">
					  <li><i class="fa fa-tag fa-rotate-90" style="color:#ff6010;font-size:1.2em !important;padding: 3px;"></i><span><h4><b><?php echo $value['brand_name']; ?></b></h4></span></li>
					  <li><a href="<?php echo $value['brand_url']; ?>" style="decoration:none" target="_blank"><i class="fa fa-globe" style="color:#ff6010;font-size:1.2em !important;padding: 3px;"></i><span><?php echo $value['brand_url']; ?></span></a></li>
					<?php if($value['customer_email_id']){?> <li><a href="mailto:<?php echo $value['customer_email_id']; ?>" style="decoration:none"><i class="fa fa-envelope" style="color:#ff6010;font-size:1.2em !important;padding: 3px;"></i><span ><?php echo $value['customer_email_id']; ?></span></a></li><?php }?>
					 <li><i class="fa fa-phone" style="color:#ff6010;font-size:1.2em !important;padding: 3px;"></i><span><?php echo $value['customer_care_phone1'].','.$value['customer_care_phone2']; ?></span></li>			 
					
				  </ul>
				 
             </div>
			 <div class=" col-sm-3 moreDetails"></div>
			<div class=" col-sm-1">
			  <span><img  height="50" width="130" style="/*margin-top: 9px;margin-left: 132px;*/"src="movilo/brand-icon/<?php echo $value['brand_icon']; ?>"/></span>
			 </div>
		</div>
		 
	
	</div>
	<?php }?>
   </div>
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
                                 <li><i class="fa fa-phone" style="color:#ff6010;font-size:1.2em !important;padding: 3px;"></i><span>+91 63600 98824</span></li>
                              </ul>
                           </div>
							
						</div>
						<div class="col-lg-3">
							<h4 class="footer-h2" style="margin-top: 8%; margin-bottom: 20%;">Useful Links</h4>
							
							<div class="moreDetails">
						   <ul class="list list-icons list-icons-sm">
						   
										<li> <a href="readmore.php" style="text-decoration:none;font-size:16px;" target="_blank">Why us?</a></li>
										<li> <a href="about-us.php#yapnaa_team" style="font-size:16px;font-size:1.2em !important;" target="_blank">About Team</a></li>
										<li> <a href="for-partners.php" style="font-size:16px;font-size:1.2em !important;" target="_blank">For Partners</a></li>
										<li> <a href="contact-us.php" style="font-size:16px;font-size:1.2em !important;" target="_blank">Contact us</a></li>
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
         <script src="vendor/jquery.validation/jquery.validation.min.js"></script>
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
		  $('ul li').click(function(){
    $('li').removeClass("active");
    $(this).addClass("active");
});
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