<?php
session_start();
$user_name	= $_SESSION['name'];
require_once(__DIR__.'/'.'movilo/controller/user_controller.php');
$obj_user = new users;
	
		 $brandcategory=$obj_user->brand_category_list();
		 $brands_list=$obj_user->n_brand_list();
		// print_r($brands_list);
if(isset($_POST['search_query']) && !empty($_POST['search_query'])){
	
	 $brands_list=$obj_user->search_result($_POST['search_query']);
     
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
      <meta name="description" content="Yapnaa - Your After Sales Companion">
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
      <link href="css/themify-icons.css" rel="stylesheet">
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
	  .textarea.input{
	  color: #795548;
	  }
	  .unclickable{
	  display:none
	  }
	  .unclickable .unclickableMask {
	  display:none
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
         <header id="header" class="header-narrow header-semi-transparent header-transparent-sticky-deactive custom-header-style" data-plugin-options="{'stickyEnabled': false, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 1, 'stickySetTop': '1'}">
            <div class="header-body" >
               <div class="header-container container">
                  <div class="header-row">
                     <div class="header-column">
                        <div class="header-logo">
                           <a href="index.php">
                           <img alt="Yapnaa" height="95" width="95" class="img-responsive desktop" src="/img/Yapnaa-logo.svg"> 
                           <img alt="Yapnaa" height="40" width="40" class="img-responsive mobile" style="margin-top:-1px"  src="/img/Yapnaa-logo.svg">
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
		 
            <div class="slider-container rev_slider_wrapper">
			 <!--div class="mobile" style="margin-bottom:7px"></div-->
               <div id="revolutionSlider" class="slider rev_slider" data-plugin-revolution-slider data-plugin-options="{'delay':4000, 'gridwidth': 1170, 'gridheight': 637, 'disableProgressBar': 'on','bullets':'true'}">
                  <ul >
                     <li data-transition="fade" data-slotamount="7" data-masterspeed="100">
			
                        <img src="img/slider/slide1.jpg"  
                           alt=""
                           data-bgposition="center center" 
                            
                           data-bgrepeat="no-repeat" 
						   data-start="100"
                           class="rev-slidebg">
						  
						   <!-- desktop-->
                        <div class="tp-caption desktop"
						
                           data-x="17"
                           data-y="280"
                           data-start="100"
						   
                           >
                           <h1 class="text-color-light desktop" style="line-height:50px;"> Reach out to Brands for<br> any grievance</h1>
						   
						  
						   
						   
                        </div>
                        

						
                        <div class="tp-caption bottom-label desktop"
                           data-x="15"
                           data-y="390"
                           data-start="100"
						   
                           ><span  class="text-color-light font-weight-semibold mb-xlg desktop">Escalate your problem  and share grievances   </span>
                        </div>
						
						
                      <div class="tp-caption bottom-label desktop"
                           data-x="15"
                           data-y="420"
                           data-start="100"
						   
                           ><span  class="text-color-light font-weight-semibold mb-xlg desktop">directly with
senior management of a brand for quick response.  </span>
                        </div>
						<!-- mobile-->
						<div class="tp-caption mobile"
						
                           data-x="1"
                           data-y="240"
                           data-start="100"
						   
                           >
                           <p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">Reach out to Brands</p><p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">for any grievance</p>
						   
						  
						   
						   
                        </div>
                        
                     </li>
                     <li data-transition="fade" data-slotamount="7" data-masterspeed="100">
                        <img src="img/slider/slide-2.jpg"  
                           alt=""
                           data-bgposition="center center" 
                           
                           data-bgrepeat="no-repeat" 
                           class="rev-slidebg">
						   <!--mobile-->
                        <div class="tp-caption mobile"
                           data-x="12"
                           data-y="240"
                           data-start="100" 
						  
                         >
						 
                           <p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">Preserve Bills and</p><p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">Warranty on Cloud</p>
                        </div>
                       
                        <!-- desktop-->
						<div class="tp-caption desktop"
                           data-x="17"
                           data-y="280"
                           data-start="100"	  
						  
                         >
						 
                           <h1 class="text-color-light desktop" style="line-height:50px;">Preserve Bills and Warranty<br> on Cloud  </h1>
                        </div>
                        <div class="tp-caption bottom-label desktop"
                           data-x="15"
                           data-y="360"
                           data-start="100"
						  
                          >
						  <span class="text-color-light font-weight-semibold mb-xlg desktop"><br><br>No more burden of storing hard copies of bills, 
<br>
warranty cards and documents.</span>
                        </div>
                     </li>
                     <li data-transition="fade" data-slotamount="7" data-masterspeed="100">
                        <img src="img/slider/slide-3.jpg"  
                           alt=""
                           data-bgposition="center center" 
                          
                           data-bgrepeat="no-repeat" 
                           class="rev-slidebg">
						   <!--desktop-->
                        <div class="tp-caption desktop"
                           data-x="17"
                           data-y="280"
                           data-start="1"
                          >
                           <h1 class="text-color-light desktop" style="line-height:50px;">Get Warranty Alerts of<br> your product on time</h1>
                        </div>
                        <div class="tp-caption bottom-label desktop"
                           data-x="15"
                           data-y="360"
                           data-start="1"
                           ><span class="text-color-light font-weight-semibold mb-xlg desktop"><br><br>Get rid of remembering product warranty, <br>
instead receive timely alerts before expiry date.</span>
                        </div>
						 <!--mobile-->
						
                       
						
						 <div class="tp-caption mobile"
                           data-x="12"
                           data-y="250"
                           data-start="100" 
						  
                         >
						 
                           <p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">Get Warranty Alerts </p><p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">of your product </p><p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">on time</p>
                        </div>
                       
                      
                     </li>
                     <li data-transition="fade" data-slotamount="7" data-masterspeed="100">
                        <img src="img/slider/slide-4.jpg"  
                           alt=""
                           data-bgposition="center center" 
                           
                           data-bgrepeat="no-repeat" 
                           class="rev-slidebg">
						   <!-- desktop-->
                        <div class="tp-caption desktop"
                           data-x="17"
                           data-y="280"
                           data-start="1"
                           >
                           <h1 class="text-color-light desktop" style="line-height:50px;">Request Branded Service of<br>any durable on single tap</h1>
                        </div>
                        <div class="tp-caption bottom-label desktop"
                           data-x="15"
                           data-y="360"
                           data-start="1"
                           ><span class="text-color-light font-weight-semibold mb-xlg desktop"><br><br>Add product once and request support
<br> from any brand using single tap.
</span>
                        </div>
						
						 <!-- mobile-->
                        
						<div class="tp-caption mobile"
                           data-x="12"
                           data-y="250"
                           data-start="100" 
						  
                         >
						 
                           <p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">Request Branded</p><p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">Service of any</p><p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">durable on </p><p class="text-color-light mobile" style="line-height:10px; font-size:20px;text-align:left;padding-left:13px">single tap</p>
                        </div>
                    
                      
                     </li>
                  </ul>
				  
				  
				  
				  
				  <div class="tp-static-layers" style="width:100%; height:100%; overflow:hidden">
 
    <!-- BEGIN STATIC LAYER -->
    <div class="tp-static-layer tp-caption tp-resizeme largewhitebg" 
 
        data-startslide="0" 
        data-endslide="99"
		
		
 
        data-frames='[{"delay": 500, "speed": 300, "from": "opacity: 0", "to": "opacity: 1"}, 
                      {"delay": "wait", "speed": 300, "to": "opacity: 0"}]' 
 
         data-x="-5"
                           data-y="460" 
        data-hoffset="0" 
        data-voffset="0" 
        data-width="['auto']"
        data-height="['auto']"
 
    > 
	
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                           
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
    <!-- END STATIC LAYER -->
 
</div>
				  
				  
               </div>
            </div>
            <section id="how-it-work" class="section background-color-light m-none">
               <div class="container">
			   <div class="row center group-mb" style="margin-bottom: 3%;">
                     <div class="col-sm-12">
                       
	
                           
                           <form id="searchForm1" action="#" method="post" novalidate="novalidate">
                              <div class="input-group " style="margin-top: -21px;" >
                                 <input type="text" style="
								    width:255px;
                                    height: 39px;
                                    border-top: 2px solid #fc7f2b;
                                    border-left: 2px solid #fc7f2b;
                                    border-bottom: 2px solid #fc7f2b;
                                    border-top-left-radius: 15px;
                                    border-bottom-left-radius: 15px;
                                    " class="form-control mobi " name="search_query" id="search_query" placeholder="Search brands, service center, customer care..." required="" aria-required="true">
                                 <span class="input-group-btn">
                                 <button class="btn btn-default mobi1 " style="
                                    height: 39px;
                                    border-top: 2px solid #fc7f2b;
                                    border-right: 2px solid #fc7f2b;
                                    border-bottom: 2px solid #fc7f2b;
                                    border-left: none;
                                    border-top-right-radius: 15px;
                                    border-bottom-right-radius: 15px;
									position: relative;
									margin: 0px 113px 29px -2px;
                                    " type="submit"><i style="color: #fc7f2b;
                                    font-size: 27px;" class="fa fa-search"></i></button>
                                 </span>
                              </div>
                           </form>
						   
						
						 
                     </div>
					<marquee behavior="scroll" direction="left"><img src="/img/superstartup_yapnaa.png" style="height: 22px;margin-top: -6px;"  alt="Natural" /><span style="font-style: italic;font-size: 16px;"><b>"Team Yapnaa awarded as winners for the most promising startups in all over Asia at the SuperStartups Summit 2018 - for the crème de la crème of the Asian startup world."</b><span></marquee>
					
                  </div>
				   	
                  <div class="row" style="    margin-bottom: 3%;">	
                     <div class="col-sm-12 desktop">
                        <h2 style="font-weight:bold; font-size:32px;">How Yapnaa helps you?</h2>
                     </div>
					 <div class="col-xs-12 mobile">
                        <h2 style="font-weight:bold; font-size:27px;text-align:center" >How Yapnaa helps you?</h2>
                     </div>
                  </div>
                  <div class="row" >
                     <div class="col-sm-6">
                         <div class="row">
                           <div class="col-sm-3">
                              <img src="img/customer-brand.svg" class="img-responsive img-center" height="100" width="100">
                           </div>
                           <div class="col-sm-6">
                              <h4>Connect to Brands</h4>
                              <p>Register your appliances in Yapnaa. This helps to organize and track the products to connect easily with brands. <a href="login.php" style="text-decoration:none;color:#fc7f2b">Read More</a></p>
                           </div>
                          <div class="col-sm-3"></div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="row">
                           <div class="col-sm-3">
                              <img src="img/section-2/single-tap-support.svg" class="img-responsive img-center" height="100" width="100">
                           </div>
                           <div class="col-sm-6">
                              <h4>Single Tap Support</h4>
                              <p>Simplified access to all details of products and services. Yapnaa provides the flexibility to manage the key aspects of service interactions with brands. <a href="readmore.php" style="text-decoration:none;color:#fc7f2b">Read More</a>
 </p>
                           </div>
						    <div class="col-sm-3"></div>
                        </div>
                     </div>
                  </div>
				  
				  <br>
                  <div class="row">
                     <div class="col-sm-6">
                        <div class="row">
                           <div class="col-sm-3">
                              <img src="img/section-2/monitor-warranty.svg" class="img-responsive img-center" height="100" width="100">
                           </div>
                           <div class="col-sm-6">
                              <h4>Get Warranty Alert</h4>
                              <p>Optimizing end-to-end service fulfillment and execution to deliver superior customer service and increase product uptime. <a href="login.php" style="text-decoration:none;color:#fc7f2b">Read More</a></p>
                           </div>
                          <div class="col-sm-3"></div>
                        </div>
                     </div>
                     <div class="col-sm-6">
                        <div class="row">
                           <div class="col-sm-3">
                              <img src="img/section-2/product-advisory.svg" class=" img-responsive img-center" height="100" width="100">
                           </div>
                           <div class="col-sm-6">
                              <h4>Ask Product Expert</h4>
                              <p>Consumers can get quick and easy access to warranty, support, accessories, knowledge base and service plans.</p>
                           </div>
                          <div class="col-sm-3"></div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
            <section id="about" style="background: #f9fafc;   border-bottom: 2px solid #fc7f2b;">
               <div class="container">
                  <div class="row about-container">
                     <div class="col-sm-6 ">
					 
					 
					 <img src="img/request.png" class="img-responsive img-center" style="margin-top: -10%;">
                        
						
						  <div class="col-sm-1 "></div>
						<div class="col-sm-10 ">
						<div class="formBox">
                           <form method="post" id="ser_request">
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="inputBox">
                                       <select class="input" id="brand_type" name="brand_type" required>
									    <option value="" disabled selected>Select product type</option>
									     <?php foreach($brandcategory as $brand){?>
                                          <option value="<?php echo $brand['p_category_id']; ?>"><?php echo $brand['p_category_name']; ?></option>
										 <?php }?>
                                          
                                       </select>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="inputBox">
                                       <select class="input" id="brand_name" name="brand_name" required>
									    <option value="" disabled selected>Select brand name</option>
									   <?php foreach($brands_list as $brandname){?>
                                          <option value="<?php echo $brandname['brand_id'];?>"><?php echo $brandname['brand_name'];?></option>
										   <?php }?>
                                         
                                       </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-12">
                                    <div class="inputBox">
                                       <!--select class="input  ">
                                          <option value="volvo">Issue Type</option>
                                          <option value="saab">Service</option>
                                          <option value="mercedes">AMC</option>
                                          <option value="audi">Product</option>
                                       </select-->
									   <textarea class="input" name="issue_type" id="issue_type" maxlength="250" required>
									   Enter issue type.....
									   </textarea>
									   <input type="text" id="yp_user" value="<?php echo $user_name;?>" hidden>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-sm-6">
                                    <div class="inputBox ">
                                       <input type="text" id="ser_name" name="ser_name" placeholder="Name" class="input" required>
                                    </div>
                                 </div>
                                 <div class="col-sm-6">
                                    <div class="inputBox">
                                       <input type="text" id="ser_phone" name="ser_phone"  placeholder="Phone Number" class="input" required>
                                    </div>
                                 </div>
                              </div>
                              <br>
                              <div class="row">
							   <div class="col-sm-3"></div>
                                 <div class="col-sm-4">
                                    <input type="button"  id="service_req" name="" class="btn footer-btn mb-2" style="min-width:125px !important; " value="Submit Request" >
                                 </div>
								 <div class="col-sm-4"></div>
                              </div>
                           </form>
                        </div> </div>
						
						 <div class="col-sm-1 "></div>
                     </div>
                     <div class="col-sm-6 " style="    margin-top: 7%;">
                        <h2 class="desktop" style="font-weight:bold;     font-size: 32px;">Raise a service request</h2>
                        <h2 class="mobile" style="font-weight:bold;     font-size: 28px;     margin-top: 19%;">Raise a service request</h2>
                        <p><span class="text-color-light font-weight-semibold mb-xlg desktop">Submit your product issue and service requests for brands,<br>authorized centers and support engineers to attend to it.</span>
						<span class="text-color-light font-weight-semibold mb-xlg mobile" >Submit your product issue and service requests for brands, authorized centers and support engineers to attend to it.</span>
						</p>
                       
                          <a href="https://play.google.com/store/apps/details?id=movilo.com.developeronrent&hl=en">
						    <img src="/img/Footer/google-play-badge.svg" height=140 width=140>
						  </a>
					   </div>
                  </div>
               </div>
            </section>
            <div id="showcase">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12">
                        <p class="cta-text desktop"> Don't just take word for it; read other's views and how they are getting
 </p><p class="cta-text desktop">quick solutions from brands directly.</p>
                        <p class="cta-text mobile" style="   margin-bottom: 17%;font-size:20px;text-align:left;line-height:30px"> Don't just take word for it; read other's views and how they are getting
 quick solutions from brands directly.</p>
                        <div class="owl-carousel owl-theme" id="blog" style="    margin-top: 6%;">
                           <div class="formBox" style="padding: 9%;border-radius: 14px;">
                              <!-- <h4> Yapnaa as a platform enables to connect better with brands and delivers a proactive service.</h4> -->
							            <a class="twitter-timeline"  href="https://twitter.com/hashtag/Yapnaa" data-widget-id="956412608411660288">#Yapnaa Tweets</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
          
                              
                           </div>
                           <div class="formBox" style="padding: 9%;border-radius: 14px;">
								<a class="twitter-timeline" data-width="350" data-height="250" data-link-color="#FF691F" href="https://twitter.com/Livpurewater?ref_src=twsrc%5Etfw">Tweets by Livpurewater</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
                           </div>
                           <div class="formBox" style="padding: 9%;border-radius: 14px;">
                              <!-- <h4> Yapnaa offers us the flexibility and control to manage various aspects of product monitoring.</h4> -->
                         <a class="twitter-timeline"  href="https://twitter.com/hashtag/Yapnaa" data-widget-id="956412608411660288">#Yapnaa Tweets</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                           </div>
                           <!-- <div class="formBox" style="padding: 9%;border-radius: 14px;">
                              
                           <a class="twitter-timeline"  href="https://twitter.com/hashtag/Yapnaa" data-widget-id="956412608411660288">#Yapnaa Tweets</a>
            <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
			
                           </div> -->
                           <!--div class="formBox" style="padding: 9%;border-radius: 14px;">
                              <h4> Dont just take word for it; read what your neighbours</h4>
                              <h5 style="font-size: 20px;margin-top: 4%;color: #ff6010; text-decoration: underline;">On Twitter</h5>
                           </div>
                           <div class="formBox" style="padding: 9%;border-radius: 14px;">
                              <h4> Dont just take word for it; read what your neighbours</h4>
                              <h5 style="font-size: 20px;margin-top: 4%;color: #ff6010; text-decoration: underline;">On Facebook</h5>
                           </div>
                           <div class="formBox" style="padding: 9%;border-radius: 14px;">
                              <h4> Dont just take word for it; read what your neighbours</h4>
                              <h5 style="font-size: 20px;margin-top: 4%;color: #ff6010; text-decoration: underline;">On Twitter</h5>
                           </div-->
                        </div>
                     </div>
                  </div>
               </div>
            </div>
			
			
			
			
			
			
				<div class="desktop" style=" padding: 6%; background: #fff;"></div>
			
			
			
			
			
			 <section id="" style="background: #f9fafc;    border-bottom: 2px solid #fc7f2b;">
               <div class="container">
                  <div class="row about-container">
				  
				  
				   <div class="col-sm-6 " style="    margin-top: 7%;     margin-bottom: 14%;">
                        <h2 class="desktop"style="font-weight:bold;     font-size: 32px;">Direct Escalation to Brands</h2>
                        <h2 class="mobile"style="font-weight:bold;     font-size: 27px;">Direct Escalation to Brands</h2>
                        <p><span class="text-color-light font-weight-semibold mb-xlg desktop">Share your grievance, issue and problem with management<br>of brand directly. Know status of your issues and get quick solution.</span>
						<span class="text-color-light font-weight-semibold mb-xlg mobile">Share your grievance, issue and problem with management <br>of brand directly. Know status of your issues and get quick solution.</span></p>
                       
					   </div>
				  
				  
				  
				  
				  
				  
				  
				  
				  
                     <div class="col-sm-6 ">
					 
					 
					 <img src="img/request3.png" class="img-responsive img-center" style="margin-top: -10%;">
                        
						
						  <div class="col-sm-1 "></div>
						<div class="col-sm-10 ">
						<div class="formBox">
                           <form id="socialMedia" method="POST">
                            
                              <div class="row">
                                 <div class="col-sm-12">
                                    <div class="inputBox">
									
									<textarea rows="4" id="fb_message" name="fb_message" cols="50" placeholder="Start Typing Here" class="input  textarea"></textarea>
									
                                       
                                    </div>
                                 </div>
                              </div>
                              
                              <br>
                              <div class="row">
							   <div class="col-sm-2"></div>
                                 <div  data-href="https://developers.facebook.com/docs/plugins/" data-layout="button_count" data-size="small" data-mobile-iframe="true" class="col-sm-8 center fb-share-button">
                                    <button type="button" class=" btn " style="min-width: 93px; background: #1da1f3;color: #fff;" onClick="getTwitLogin()" ><i class="fa fa-twitter" style="color: #fff;"></i> Tweet</button>
									<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"><button type="button" class=" btn " onClick="post_on_wall();" style="min-width: 93px; background: #4867aa;color: #fff;" ><i class="fa fa-facebook" style="color: #fff;"></i> Post</button></a>
											
											 
									  </div>
								 
								 <div id="fb-root" class="col-sm-2"></div>
                              </div>
                           </form>
                        </div> </div>
						
						 <div class="col-sm-1 "></div>
                     </div>
                    
                  </div>
               </div>
            </section>
			 <section id="services">
               <div class="container">
                  <div class="section-header">
                     <h2 class="section-title">Without Yapnaa</h2>
                     <!--<p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>-->
                  </div>
				  
				  
				  <!-- for Mobile -->
				  
				  
				  <div class="row mobile">
				   <div class="col-xs-12"><p class="text-color-light font-weight-100 mb-xlg">&nbsp;</p></div>
				   <div class="col-xs-6">
				  <img src="img/icon-1.svg" class="img-responsive img-center" height="50" width="50">
				                <p style="line-height:0px">&nbsp;</p>
								<p class="text-color-light font-weight-100 mb-xlg">Your device <br/> has an issue</p>
				  
				  </div>
				   <div class="col-xs-6">
				  <img src="img/icon-2.svg" class="img-responsive img-center" height="50" width="50">
				                <p style="line-height:0px">&nbsp;</p>
								<p class="text-color-light font-weight-100 mb-xlg">Search contacts
<br>of service center</p>
				  
				  </div>
				  
				  
				  
				  
				  <div class="col-xs-6">
				  <img src="img/icon-3.svg" class="img-responsive img-center" height="50" width="50">
				                <p style="line-height:0px">&nbsp;</p>
								<p class="text-color-light font-weight-100 mb-xlg">Wait for a longtime
<br>to get connected</p>
				  
				  </div>
				  
				  <div class="col-xs-6">
				  <img src="img/icon-4.svg" class="img-responsive img-center" height="50" width="50">
				                <p style="line-height:0px">&nbsp;</p>
								<p class="text-color-light font-weight-100 mb-xlg">Hoggle with <br>customer care</p>
				  
				  </div>
				  
				  
				  <div class="col-xs-12">
				  <img src="img/icon-5.svg" height="50" width="50">
				                <p style="line-height:0px">&nbsp;</p>
								<p class="text-color-light font-weight-100 mb-xlg">Response satisfactory&nbsp;or&nbsp;<br>unsatisfactory</p>
				  
				  </div>
				  
				  
				  
				  
				  
				  </div>
				  
				  
				  
				  <!-- for Desktop -->
				  
				  
                  <div class="row txt desktop" id="kk" >
				   <div class="col-md-1">
					 </div>
				    <!--<div class="col-sm-1"></div>-->
                     <div class="col-md-2 service-options">
						<div class="row">
						 <div class="col-md-2">
					 </div>
							<div class="col-md-8">
								<img src="img/icon-1.svg" height="50" width="50">
								<p class="text-color-light font-weight-semibold mb-xlg">Your device <br>has an issue</p>
                         
							</div>
							<div class="col-md-2">
								<img src="img/arrow.svg" height="50" width="50" style="    margin-top: 50%;">
								
							 </div>
						</div>
					</div>
                     <div class="col-md-2 service-options">
						<div class="row">
						 <div class="col-md-2">
					 </div>
							<div class="col-md-8">
								<img src="img/icon-2.svg" height="50" width="50">
								<p class="text-color-light font-weight-semibold mb-xlg">Search contacts
<br>of service center</p>
                         
							</div>
							<div class="col-md-2">
								<img src="img/arrow.svg" height="50" width="50" style="    margin-top: 50%;">
								
							 </div>
						</div>
					</div>
                     <div class="col-md-2 service-options">
						<div class="row">
						 <div class="col-md-2">
					 </div>
							<div class="col-md-8">
								<img src="img/icon-3.svg" height="50" width="50">
								<p class="text-color-light font-weight-semibold mb-xlg">Wait for a longtime
<br>to get connected</p>
                         
							</div>
							<div class="col-md-2">
								<img src="img/arrow.svg" height="50" width="50" style="    margin-top: 50%;">
								
							 </div>
						</div>
					</div>
                     <div class="col-md-2 service-options">
						<div class="row">
						 <div class="col-md-2">
					 </div>
							<div class="col-md-8">
								<img src="img/icon-4.svg" height="50" width="50">
								<p class="text-color-light font-weight-semibold mb-xlg">Hoggle with <br>customer care</p>
                         
							</div>
							<div class="col-md-2">
								<img src="img/arrow.svg" height="50" width="50" style="    margin-top: 50%;">
								
							 </div>
						</div>
					</div>
                     <div class="col-md-2 service-options">
						<div class="row">
						 <div class="col-md-2">
					 </div>
							<div class="col-md-8">
								<img src="img/icon-5.svg" height="50" width="50">
								<p class="text-color-light font-weight-semibold mb-xlg">Response satisfactory&nbsp;or<br>unsatisfactory</p>
                         
							</div>
						</div>
					</div>
					 <div class="col-md-2">
					 </div>
					 </div>
					  <div class="row smg">
                     <div class="section-header">
                        <h3 class="section-title" id="sect">With Yapnaa</h3>
						
                       <!-- <p class="section-description">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque</p>-->
                     </div>
					 
					 <!-- fror mobile-->
					 <div class="row mobile">
					 <div class="col-xs-12"><p class="text-color-light font-weight-100 mb-xlg">&nbsp;</p></div>
				   <div class="col-xs-12">
				  <img src="img/icon-1.svg" class="img-responsive img-center" height="50" width="50">
				                  <p style="line-height:0px">&nbsp;</p>
								  <p class="text-color-light font-weight-100 mb-xlg services-text">Your device <br>has an issue
				  
				  </div>
				   <div class="col-xs-12">
				  <img src="img/icon-6.svg" class="img-responsive img-center" height="50" width="50">
				                <p style="line-height:0px">&nbsp;</p>
								<p class="text-color-light font-weight-100 mb-xlg">Raise a<br>service request on Yapnaa
                            
                           </p>
				  
				  </div>
				  
				  
				  
				  
				  <div class="col-xs-12">
				  <img src="img/icon-7.svg" class="img-responsive img-center" height="50" width="50">
				                 <p style="line-height:0px">&nbsp;</p>
								 <p class="text-color-light font-weight-100 mb-xlg" style="line-height:0px">Connect to brands quickly and get</p>
                              <p class="text-color-light font-weight-100 mb-xlg" style="line-height:0px">
							  your product serviced in time 
                           </p>
				  
				  </div>
				  
				  </div>
				  <!-- desktop-->
                     <div class="row txt desktop" id="ll">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-2 service-options">
                           <img src="img/icon-1.svg" height="50" width="50">
                           <p class="text-color-light font-weight-semibold mb-xlg services-text">Your device <br>has an issue
                             
                           </p>
                        </div>
						 <div class="col-sm-1"><img class="arrow" src="img/arrow.svg" height="50" width="50" style="    margin-top: 50%;"></div>
                        <div class="col-sm-2 service-options">
                           <img src="img/icon-6.svg" height="50" width="50">
                           <p class="text-color-light font-weight-semibold mb-xlg">Raise a<br>service request on Yapnaa
                            
                           </p>
                        </div>
						
						 <div class="col-sm-1"><img class="arrow" src="img/arrow.svg" height="50" width="50" style="    margin-top: 50%;"></div>
                        <div class="col-sm-2 service-options">
                           <img src="img/icon-7.svg" height="50" width="50" >
                           <p class="text-color-light font-weight-semibold mb-xlg">Connect to brands quickly and get<br>your product serviced in time 
                              
                           </p>
                        </div>
						
						 <div class="col-sm-2"></div>
                     </div>
                  </div>
            </section>
			
			
			
			
			
			
			
		
			
			
			
			
			
			
			
           
			
			
			
			
			
			
			
			
			
			
			
            <div style="padding-top: 4%; padding-bottom: 4%;">
               <div class="container">
                  <div class="row">
                     <div class="col-sm-12 ">
                        <h2 class="desktop" style="font-weight:bold;     font-size: 32px; text-align:center;">Customer Feedback</h2>
                        <h2 class="mobile" style="font-weight:bold;     font-size: 27px; text-align:center;">Customer Feedback</h2>
						<p style="font-size: 18px; font-family: GothamRoundedBook;text-align:center;">Help us to improve your experience with Yapnaa</p>
						<p style="text-align:center;"><a href="https://goo.gl/forms/0YUYkYfJOZCQ9swr2" class="btn footer-btn mb-2" style="width:125px !important;" >Share feedback</a></p>
                        <!-- <div class="owl-carousel owl-theme" id="testimonial" >
                           <div class="testimonial testimonial-primary">
                              <blockquote>
                                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat.</p>
                              </blockquote>
                              <h5 style="margin-left:50px;">Sanjana rao</h5>
                              <p style="margin-left:50px;">Business Women</p>
                           </div>
                           <div class="testimonial testimonial-primary">
                              <blockquote>
                                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat.</p>
                              </blockquote>
                              <h5 style="margin-left:50px;">Sanjana rao</h5>
                              <p style="margin-left:50px;">Business Women</p>
                           </div>
                           <div class="testimonial testimonial-primary">
                              <blockquote>
                                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat.</p>
                              </blockquote>
                              <h5 style="margin-left:50px;">Sanjana rao</h5>
                              <p style="margin-left:50px;">Business Women</p>
                           </div>
                           <div class="testimonial testimonial-primary">
                              <blockquote>
                                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat.</p>
                              </blockquote>
                              <h5 style="margin-left:50px;">Sanjana rao</h5>
                              <p style="margin-left:50px;">Business Women</p>
                           </div>
                           <div class="testimonial testimonial-primary">
                              <blockquote>
                                 <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula est, in consequat.</p>
                              </blockquote>
                              <h5 style="margin-left:50px;">Sanjana rao</h5>
                              <p style="margin-left:50px;">Business Women</p>
                           </div>
                        </div> -->
                     </div>
                  </div>
               </div>
            </div>
            <section id="nnn">
               <div class="row">
                  <div class="col-sm-2"></div>
                  <div class="col-sm-8">
                     <div class="row center">
                        <div class="counters center">
                           <div class="col-md-4 col-sm-6">
                              <div class="counter center">
                                 <strong data-to="10000" data-append="+" style="color:white; padding-bottom:15px;">0</strong>
                                 <label style="color:white;line-height:25px;">Customers<br> On Yapnaa</label>
                              </div>
                           </div>
                           <div class="col-md-4 col-sm-6">
                              <div class="counter">
                                 <strong data-to="580" data-append="+" style="color:white; padding-bottom:15px;">0</strong>
                                 <label style="color:white; line-height:25px;" >Product<br> Registrations</label>
                              </div>
                           </div>
                           <div class="col-md-4 col-sm-6">
                              <div class="counter">
                                 <strong data-to="450" data-append="+"  style="color:white; padding-bottom:15px;">0</strong>
                                 <label style="color:white;line-height:25px;">Issues<br>Resolved</label>
                              </div>
                           </div>
                          <!-- <div class="col-md-3 col-sm-6">
                              <div class="counter">
                                 <strong data-to="600" data-append="+" style="color:white; padding-bottom:15px;">0</strong>
                                 <label style="color:white; line-height:25px;">High<br>Score</label>
                              </div>
                           </div
                        </div>
                     </div>-->
                  </div>
				  </div>
				  </div>
                  <div class="col-md-2"></div>
               
            </section>
            
	  
	  
	  
	  
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
         <script>
		 $( "a.twitter-timeline" ).scrollLeft( 300 );
		if (window.matchMedia('(max-width: 600px)').matches)
			{
			$('#how-it-work h4').css({'text-align':'center'}).css({'margin-top':'23px'});
			}
            $("#blog").owlCarousel({
             items: 3,
             dots: true,
            autopay:true,
            margin: 20,
             responsive:{
                 0:{
                     items:1,
                     mouseDrag: true,
                     touchDrag: true
                 },
                 480:{
                     items:1,
                     mouseDrag: true,
                     touchDrag: true
                 },
                 750:{
                     items:2,
                     mouseDrag: true,
                     touchDrag: true
                 },
                 1000:{
                     items:3,
                     dots: true,
                     nav: false,
                     mouseDrag: true,
                     touchDrag: true,
            autoplay: true,
            autoplayTimeout: 3000
                 }
             }
            });
            
            
            
             $("#testimonial").owlCarousel({
             items: 3,
             dots: true,
            autopay:true,
            margin: 20,
             responsive:{
                 0:{
                     items:1,
                     mouseDrag: true,
                     touchDrag: true
                 },
                 480:{
                     items:1,
                     mouseDrag: true,
                     touchDrag: true
                 },
                 750:{
                     items:2,
                     mouseDrag: true,
                     touchDrag: true
                 },
                 1000:{
                     items:3,
                     dots: true,
                     nav: false,
                     mouseDrag: true,
                     touchDrag: true,
            autoplay: true,
            autoplayTimeout: 3000
                 }
             }
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
  $( "#revolutionSlider" ).mouseover(function() {
                   $('#revolutionSlider').revpause();
              }); 
		 $( "#revolutionSlider" ).mouseout(function() {		
              
                  $('#revolutionSlider').revresume();
             }); 
 //for twiter
function getTwitLogin(){
var fbuser =sessionStorage.facebookUser;
var fb_message   =$("#fb_message").val();
var uType='twit';
if((fbuser) )
	{
		var socialuser=fbuser;
	}
   else if($("#yp_user").val().length !=0){
		
		var socialuser=$("#yp_user").val();
	}
	else{
		var socialuser='';
	}
 $.ajax({
		url: "new_customer_engagment.php?socialmediatweet=submit", //This is the page where you will handle your SQL insert
		type:"POST",
		data:{user:socialuser,msg:fb_message,userType:uType},
		success:function(response){
			console.log(response);
			if(response){
				//alert("Service request raised successfully.");
				location.reload();
			}
		},
		error:function(error){
			alert(JSON.stringify(error));
		}
	}); 
 
 var textToTweet = '@yapnaa'+' '+document.getElementById('fb_message').value;
 if (textToTweet.length > 140) {
 alert('Tweet should be less than 140 Chars');
 }
 else {
 var twtLink = 'http://twitter.com/home?status=' +encodeURIComponent(textToTweet);
 window.open(twtLink,'_blank');
 }
 
}

//$( document ).ready(function() {
	$('.header-social-icons').css('cursor','pointer');
	
	if(sessionStorage.facebookUser !=undefined){
	

	}
$('.header-social-icons p').attr("title",'Logout');	
	$('.header-social-icons p').click(function(){
	confirm("Are you sure to logout?")?window.location.assign("index.php"):false;
	 
	
	 sessionStorage.clear();
	//sessionStorage.facebookUserId.destroySession();
   });
//});
$( "#service_req" ).click(function() {
	//alert($("#yp_user").val().length);
	
	var brandType=$("#brand_type").find(":selected").val();
	var fbuser =sessionStorage.facebookUser;
	//alert(fbuser);//var yp_user =$("#yp_user").val();
	if((fbuser) )
	{
		var socialuser=fbuser;
	}
   else if($("#yp_user").val().length !=0){
		
		var socialuser=$("#yp_user").val();
	}
	else{
		var socialuser='';
	}
	
	var brandName=$("#brand_name").find(":selected").val();
	var issueType=$("#issue_type").val();
	var serName=$("#ser_name").val();
	var serPhone=$("#ser_phone").val();
	if(!serName || !serPhone ){
		alert('Please fill all the fields');
		return false;
	}
	
	//alert(brandType+''+socialuser+''+brandName+''+issueType+''+serName+''+serPhone);
   $.ajax({
		url: "new_customer_engagment.php?service_req=submit", //This is the page where you will handle your SQL insert
		type:"POST",
		data:{user:socialuser,custName:serName,brandInfo:brandType,brand:brandName,issue:issueType,custPhone:serPhone},
		success:function(response){
			console.log(response);
			if(response){
				
				alert("Service request raised successfully.");
				$('#ser_request').trigger("reset");
			}
		},
		error:function(error){
			alert(JSON.stringify(error));
		}
	}); 
	
});
function post_on_wall(){
var fbuser =sessionStorage.facebookUser;
var fb_message   =$("#fb_message").val();
var uType='facebook';
if((fbuser) )
	{
		var socialuser=fbuser;
	}
   else if($("#yp_user").val().length !=0){
		
		var socialuser=$("#yp_user").val();
	}
	else{
		var socialuser='';
	}
    $.ajax({
		url: "new_customer_engagment.php?socialmediaface=submit", //This is the page where you will handle your SQL insert
		type:"POST",
		data:{user:socialuser,msg:fb_message,userType:uType},
		success:function(response){
			console.log(response);
			if(response){
				//alert("Service request raised successfully.");
				location.reload();
			}
		},
		error:function(error){
			alert(JSON.stringify(error));
		}
	}); 
}
      </script>
   </body>
</html>