<?php
session_start();
$user_name	= $_SESSION['name'];
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
.list li
{
justified-content:center;
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
							<div class="col-md-12" style="justify-content:center">
								<h1>Privacy Policy</h1>
							</div>
						</div>
					</div>
				</section>
				  <div class="container">
					<div class="row">
						<div class="col-md-12" style="justify-content:center; margin:auto;">
				 <ul class="list list-icons">
										<li style="font-size:18px;"><p>At, Movilo Networks Private Limited, a Company incorporated under the Companies Act 2013, having its registered office at # 6, First Floor, 21st Main Road, Near BDA complex, Banashankari 2nd Stage, Bangalore - 560070, India (Hereinafter referred to as “Company”, “we”, “our” or “us”), your privacy is of great importance to us. We understand that you entrust us with certain Personal Information (as defined below) to help us provide various services. In exchange for your trust, you expect and deserve our commitment to treat your information with respect and in accordance with the terms of this privacy policy (“Privacy Policy”).</p>

</li>
<li style="font-size:18px;"><p>In this Privacy Policy (“Policy”), we describe the information that we collect about you when you use and access www.yapnaa.com (the “Website”); the “Movilo Networks” technology platform accessible through desktops, mobile phones, smart phones and tablets (the “Application”) which offers an online marketplace connecting Registered Users (defined below) with “Service Providers” (defined below) and offering various Services as may be introduced by the Company from time to time (hereinafter “Website” and “Application” collectively referred to as “Yapnaa”) and how we use and disclose that information. The words “you” or “your” as used herein refer to all individuals and/or entities who have registered on the Yapnaa.com (Hereinafter “Registered Users”) accessing or using the Website, Application and Services offered therein for any reason.</p>
</li>
<li style="font-size:18px;"><p>If you have any questions or comments about the Privacy Policy, please contact us at info@Yapnaa.com. This Policy is incorporated into and is subject to the Company’s Terms of Use with Registered Users, which can be accessed at www.yapnaa.com / terms (Hereinafter “Terms”). Your use of the Yapnaa and/or Services offered thereunder and any personal information you provide on therein remains subject to the terms of the Privacy Policy and Terms.</p>
</li>
<li style="font-size:18px;"><p>BY ACCESSING OR USING THE WEBSITE, APPLICATION AND /OR SERVICES PROVIDED THEREIN, YOU ACKNOWLEDGE THAT YOU HAVE READ, UNDERSTOOD AND AGREE TO BE BOUND BY THIS PRIVACY POLICY AND OUR TERMS. IF YOU DO NOT AGREE TO THE TERMS OR PRIVACY POLICY DO NOT USE THE SERVICES</p>
</li>
<li style="font-size:18px;"><h6>1. YOUR PRIVACY - OUR COMMITMENT</h6>
<p>We recognize the importance of your personal privacy. Please read the following policy to understand how your Personal Information will be treated as you make full use of the Services offered through the Website and/or Application. Except as disclosed in this Privacy Policy or as otherwise authorized by you, we will not share your Personal Information with third parties for their marketing purposes. Your trust and confidence are our highest priority.</p>
</li>
<li style="font-size:18px;"><h6>2. DEFINITIONS</h6>
<p>As used in the Terms, the following terms shall have the meaning set forth below:</p>
</li>
<li style="font-size:18px; margin-left:30px;"><p>i. Effective Date means the Date on which You accept the Terms and Privacy Policy by starting to use the Services offered on the Software.</p>
</li>
<li style="font-size:18px; margin-left:30px;"><p>ii. Registered User means any user who can legally enter into an Agreement with the Company and who has either registered directly through the website, by downloading the Application, by sending product photographs via phone or through email to use the Services offered on the Software.</p>
</li>
<li style="font-size:18px; margin-left:30px;"><p>iii. Registered User Information means information regarding Registered Users such as personal information which includes their name, legal status, address, email address, mobile number, and non-personal information such as make of their mobile, information/documents pertaining to the product in respect of which they wish to avail Services etc.;</p>
</li>
<li style="font-size:18px; margin-left:30px;"><p>iv. Services mean and includes services provided by Service Providers who are connected with the Registered Users through the Yapnaa.com and offer services pertaining to products, such as repair of products, insurance, warranty confirmation and extension and such other services as Company may offer from time to time</p>
</li>
<li style="font-size:18px; margin-left:30px;"><p>v. Service Provider means and includes manufacturer's, third party service providers, registered with the Software who offer Services to Registered Users. The Yapnaa.com serves as a platform for connecting Registered Users with Service Providers who are independent professionals and are not employed by the Company or any of its affiliates.</p>
</li>
<li style="font-size:18px; margin-left:30px;"><p>vi. Service Provider Information means information pertaining to the name, address, qualification, experience, specialization, fees of the Service Provider, etc.</p>
</li>
<li style="font-size:18px; margin-left:30px;"><p>vii. All other capitalized terms shall have the meaning ascribed to them in the Other Terms.</p>
</li>
<li style="font-size:18px;"><h6>3. INFORMATION WE COLLECT</h6><br>
<p>I. Information Provided to Us:</p>
<p>We receive and store Personal Information (i.e. includes information that whether on its own or in combination with other information may be used to readily identify or contact you such as: name, address, email address, phone number etc.) and Non- Personal information provided by you when you set up an account upon registration (Account) and use the Website and/or Application, which for the purposes of this Privacy Policy, may include, but are not limited to:</p>
</li>
<li style="font-size:18px; margin-left:30px;"><p>i.	first and last name</p></li>
<li style="font-size:18px; margin-left:30px;"><p>ii. a home or other physical address</p></li>
<li style="font-size:18px; margin-left:30px;"><p>iii.	an email address or other contact information including mobile/landline numbers, whether at work or at home</p></li>
<li style="font-size:18px; margin-left:30px;"><p>iv. other personal information;</p></li>
<li style="font-size:18px; margin-left:30px;"><p>v.	demographic information (e.g., gender, age, political preference, education, race or ethnic origin, and other information relevant to user surveys and/or offers ) and (vi) information regarding your use of the Services available through the Website and/or Software including information such as information/documents pertaining to the products such as the photographs, invoices, warranty period, manufacturer information, services you require, issues with the product etc., the details that you post in your Account, reviews, or feedback, and any comments regarding the Software or Service Provider or discussions you post in any blog, chat room, or other correspondence on the Website or Application</p></li>
<li style="font-size:18px; margin-left:30px;"><p>vi. payment information such as credit card information, from you. You always have the option to not provide information by choosing not to use a particular service or feature. Importantly, we only collect Personal Information about you that we consider necessary for achieving this purpose and communicating with you about the Services being offered.</p></li>

<li style="font-size:18px;"><p><b>By continuing to use our Website and/or Software you are deemed to have read the Privacy Policy and understood the purpose for which your Personal or Non-Personal Information is being collected and how the same shall be used and granting your express consent to such purpose and use. If, at a later date, you wish to withdraw this consent, please send us an email at info@yapnaa.com
Information Collected Automatically:</b> When you use the Website and/or Application, we automatically receive and record information on our server logs from your browser or mobile, including but not limited to your hardware model, operating system version, unique device identifiers, and mobile network information including phone number, location, URL that you just came from (whether this URL is on our Website or not), which URL you next go to (whether this URL is on our Website or not), your computer browser information, IP address and cookie information. We treat this data as Non-Personal Information, except where we are required to do otherwise under applicable law.
</p>
</li>
<li style="font-size:18px;"><p><b>Data Collection Devices:</b>We use data collection devices such as cookies on certain pages of the Website and Application to help analyze our web page flow, measure promotional effectiveness, and promote trust and safety. Cookies are small files placed on the hard drive of your computer that assist us in providing the Services. We offer certain features that are only available through the use of a cookie. We also use cookies to allow you to enter your password less frequently during a session. Cookies can also help us provide information that is targeted to your interests. Most cookies are session cookies, meaning that they are automatically deleted from your hard drive at the end of a session. You are always free to decline our cookies if your browser permits, although in that case you may not be able to use certain features on the Website and you may be required to reenter your password more frequently during a session. Additionally you may encounter cookies or other similar devices on certain pages of the Website that are placed by third parties. For example, if you view a web page created by a user, there may be a cookie placed within that web page. We do not control the use of cookies by third parties.
</p>
</li>
<li style="font-size:18px;"><h6>4. USE OF INFORMATION COLLECTED</h6>
<p>Personal Information about Registered Users is an integral part of our business. We neither rent nor sell your Personal Information to anyone. We may share your Personal Information only as described in this Privacy Policy and related documents.</p>
</li>
<li style="font-size:18px; margin-left:30px;"><p><b>Use of Personal Information:</b></p>
</li>
<li style="font-size:18px; margin-left:30px;"><p>We will use and store Personal Information to deliver Services to you, including registering you for our Services, verifying your identity and authority to use our Services, and to otherwise enable you to use our Website, Software and our Services; to maintain, and improve our Services, including, for example, to facilitate payments, provide Services you request (and send related information), develop new features, provide customer support to Registered Users, develop safety features, authenticate users, and send updates and administrative messages, to market the Service and for the internal operational and administrative purposes of the Service, to process billing and payment, including sharing with third party payment gateways in connection with Website, Software and Services. If you send us personal correspondence, such as emails or letters, or if other users or third parties send us correspondence about your activities or postings on the Website or Software we may collect such information into a file specific to you. You agree that we may use Personal Information about you to improve our marketing and promotional efforts, to analyze Website and Software usage, improve the Website and Software content and Service offerings, and customize the Website and Software content, layout, and Services. These uses improve the Website and Software and better tailor it to meet your needs, so as to provide you with a smooth, efficient, safe and customized experience while using the Website and/or Software. You agree that we may use your Personal Information in the file we maintain about you, and other information we obtain from your current and past activities to: resolve disputes; troubleshoot problems; help promote safe trading; measure consumer interest in the Services provided by us; inform you about online and offline offers, services, and updates; customize your experience; detect and protect us against error, fraud and other criminal activity; enforce our Terms of Use; and as otherwise described to you at the time of collection.</p>
</li>
<li style="font-size:18px; margin-left:30px;"><p><b>Aggregate Information:</b>We will also use Personal Information and non-personally identifiable information and other information (including information from online and offline third party sources) to create aggregated data for analytical and other purposes.
We use this information to do internal research on your demographics, interests, and behavior to better understand, protect and serve You. This information is compiled and analyzed on an aggregated basis. Unless otherwise stated in this Privacy Policy, We only use this data in aggregate form. Non-personally identifiable information: We may freely use Non Personally Identifiable Information in connection with the Services offered through the Website and Application, including to administer the Services being offered thereunder, to understand how well the Service is working, to market the Services and other products and services, to develop aggregate, statistical information on usage of the Service and to generally improve the Service.</p>

</li>
<li style="font-size:18px; margin-left:30px;"><p><b>Email/SMS Communications:</b>If you create an account and provide your email address and telephone number, we will send you administrative and promotional emails and text messages. If you wish to opt out of promotional emails and text messages, you may do so by following the unsubscribe instructions in the email, opt out instructions in the text message or by editing your account settings. All Users receive administrative emails and text messages. From time to time, we may reveal general statistical information about our Website and Software through emails and messages.</p>
</li>
<li style="font-size:18px;"><h6>5. OUR DISCLOSURE OF YOUR INFORMATION</h6>
<p>We may also use your Personal Information to deliver information to you that, in some cases, are targeted to your interests, such as new services, rewards and promotions. The following are some circumstances under which and people to whom we would share your Information with from time-to-time:</p></li>
<li style="font-size:18px; margin-left:30px;"><p>Disclosure of Personal Information:</p></li>
<li style="font-size:18px;margin-left:30px;"><p><b>Registered Users:</b>We do not disclose your personal information such as email address, telephone number and mailing address to any third party for marketing purposes. Except as otherwise provided under this Privacy Policy, we will disclose your Personal Information to third parties only in the following limited circumstances:</p>
</li>
<li style="font-size:18px;margin-left:60px;"><p>i. if you use the Service through the Website and/or Application, we may disclose your Information to the Service Providers who have listed their Services on the Website and Software to respond to the service requests submitted by you on the Website and /or Application. For instance, we may share details of your Company name, Your name, phone number, address, details of the request, specifications, time lines, etc, and certain contact information (depending upon your location and applicable laws) to facilitate the Services, including promoting and marketing the Services of the Service Provider;</p>
</li>
<li style="font-size:18px;margin-left:60px;"><p>ii. to trusted partners who work on behalf of or with us under confidentiality agreements. These entities may use your Personal Information for performing services, administering promotions, analyzing data and usage of the Service through the Website and Application, processing credit card payments, operating the Service or providing support and maintenance services for the same or providing customer service.</p>
</li>
<li style="font-size:18px;margin-left:60px;"><p>iii. when we have your consent to otherwise share the information.</p>
</li>
<li style="font-size:18px;margin-left:30px;"><p><b>Non-Personally Identifiable Information:</b>We may disclose other Non-Personally Identifiable Information to third party advertisers and advertising agencies, partners, and other parties in order for us and such third parties to analyze (a) the performance of, to operate and improve the Services offered through the Website and Application, (b) the behavior of Registered Users and to target offers to Registered Users depending upon their requirements and (c) the behavior and ratings of Service Providers. We may also disclose, use or publish this information for promoting the Services offered under the Website and/or Application. These third parties are subject to confidentiality agreements with us and other legal restrictions that prohibit their use of the information we provide them for any other purpose except to facilitate the specific outsourced operation, unless you have explicitly agreed or given your prior permission to them for additional uses.</p>
</li>
<li style="font-size:18px;margin-left:30px;"><p><b>Network Operators:</b>Use of the Service provided through the Website and Application may involve use of the services of third party telecommunications carriers and service providers (such as the services of the carrier that provides cell phone service to you). Such carriers and service providers are not our contractors, and any information that a carrier collects in connection with your use of the Service provided through the Website and/or Application is not Personal Information and is not subject to this Privacy Policy. We are not responsible for the acts or omissions of telecommunications carriers or service providers.</p>
</li>
<li style="font-size:18px;margin-left:30px;"><p><b>Additional Disclosures:</b>Notwithstanding anything to the contrary in this Privacy Policy, We reserve the right to use or disclose Personal Information and any other information we collect in connection with the Service offered through the Website and/or Application (a) to any successor to our business, including as a result of any merger, acquisition, asset sale or similar transaction, (b) to any corporate affiliate of ours whose privacy practices are substantially similar to ours, (c) to any law enforcement, judicial authority, governmental or regulatory authority, to the extent required by law or legal process, or (d) if in our reasonable discretion, such use or disclosure is necessary to enforce or protect our legal rights or to protect third parties.</p>
</li>
<li style="font-size:18px;"><p><h6>6. Communications with Us or Through the Service:</h6>
<p>Any communication or material you transmit to us by email or otherwise, including any data, questions, comments, suggestions, or the like is, and will be treated as, non-confidential and nonproprietary. Except to the extent expressly covered by this policy, anything you transmit or post may be used by us for any purpose, including but not limited to, reproduction, disclosure, transmission, publication, broadcast and posting. Furthermore, you expressly agree that we are free to use any ideas, concepts, know how, or techniques contained in any communication you send to us without compensation and for any purpose whatsoever, including but not limited to, developing, manufacturing and marketing products and services using such information.
You should be aware that Personal Information which you voluntarily include and transmit online in a publicly accessible blog, chat room, social media platform or otherwise online, or that you share in an open forum such as an in person panel or survey, may be viewed and used by others without any restrictions. We are unable to control such uses of your Personal Information, and by using such services you assume the risk that the Personal Information provided by you may be viewed and used by third parties for any number of purposes.
</p></li>

<li style="font-size:18px;"><p><h6>7. ACCESS OR CHANGE YOUR PERSONAL INFORMATION</h6>
<p>You may review, correct, update or change your Account information at any time. To protect your privacy and security, we will verify your identity before granting access or making changes to your Personal Information. Your user ID and password are required in order to access your Account.</p></li>
<li style="font-size:18px;"><p><h6>8. OTHER WEBSITES</h6>
<p>Our Website may contain links to other websites. Please note that when you click on one of these links, you are entering another website over which we have no control and will bear no responsibility. Often these websites require you to enter your Personal Information. We encourage you to read the privacy statements on all such websites as their policies may differ from ours. You agree that we shall not be liable for any breach of your privacy of Personal Information or loss incurred by your use of these websites. We are not responsible for the privacy policies and/or practices on other sites. This Privacy Policy only governs information collected by us.</p></li>
<li style="font-size:18px;"><p><h6>9. ACCOUNT DELETION</h6>
<p>Should you ever decide to delete your Account, you may do so by clicking on the delete account link on your account settings page or by simply deleting the Application. If you terminate your Account, your profile, including your check-in history and any promotional offers you received, will be removed from the Website/Application and deleted from our servers. Because of the way we maintain our Website and/or Application, such deletion may not be immediate, and residual copies of your profile information or posts may remain on backup media for up to ninety (90) days.
Even after you remove information from your Account or profile, copies of that information may remain viewable elsewhere, to the extent it has been shared with others, it was otherwise distributed pursuant to your privacy settings, or it was copied or stored by other users. Removed and deleted information may remain on backup media for up to ninety (90) days prior to being deleted from our servers.
</p></li>
<li style="font-size:18px;"><p><h6>10. AMENDMENTS TO THE PRIVACY POLICY</h6>
<p>We may amend this Privacy Policy from time to time. Use of information we collect now is subject to the Privacy Policy in effect at the time such information is used. If we decide to change our Privacy Policy, we will post those changes on this page so that you are always aware of what information we collect, how we use it, and under what circumstances we disclose it. Any changes to our Privacy Policy will be communicated through our Website(s) at least ten (10) days in advance of implementation. Users are bound by any changes to the Privacy Policy when they continue to use the Website(s) and/or Application after such changes have been first posted.
</p></li>
<li style="font-size:18px;"><p><h6>11. CONTACTING US</h6>
<p>If you have any questions about this Privacy Policy or the privacy practices of this Website or Application you can contact us at info@yapnaa.com. We will make every effort to resolve your concerns.
</p></li>
<li style="font-size:18px;"><p><h6>12. ACCOUNT INFORMATION</h6>
<p>You may correct your account information at any time by logging into your Account. If you wish to cancel your Account, please email us at info@yapnaa.com. Please note that in some cases we may retain certain information about you as required by law, or for legitimate business purposes to the extent permitted by law. For instance, if you have a standing credit or debt on your account, or if we believe you have committed fraud or violated our Terms, we may seek to resolve the issue before deleting your information.
</p></li>
<li style="font-size:18px;"><p><h6>13. SECURITY OF PERSONAL INFORMATION</h6>
<p>We take reasonable security measures and procedures, and as specified by applicable law, to maintain appropriate physical, technical and administrative security to help prevent loss, misuse, or unauthorized access, disclosure or modification of Personal Information. While we take these reasonable efforts to safeguard your personal information, you acknowledge and agree that no system or transmission of data over the Internet or any other public network can be guaranteed to be 100% secure. You should take steps to protect against unauthorized access to your password, phone, and computer by, among other things, signing off after using a shared computer, choosing a robust password that nobody else knows or can easily guess, and keeping your log-in and password private. We are not responsible for the unauthorized use of your information or for any lost, stolen, compromised passwords, or for any activity on your Account via unauthorized password activity.
</p></li>
<li style="font-size:18px;"><p><h6>14. GRIEVANCE OFFICER</h6>
<p>In accordance with Information Technology Act 2008 and rules made there under, in case of grievances you can contact:

Movilo Networks Private Limited, # 6, First Floor, 21st Main Road, Near BDA complex, Banashankari 2nd Stage, Bangalore – 560070, 
Email: - info@yapnaa.com

</p></li>

<li style="font-size:18px;">
<p>In the event you wish to make a complaint regarding any violation of the provisions of the Privacy Policy, you may send a written complaint to the Grievance Officer, who shall redress the complaint within one (1) month. This Privacy Policy was last updated on January, 2018.</p></li>

<li style="font-size:18px;"><p><h6>15. CAMERA</h6>
<p>
Used for permissions that are associated with accessing the camera or capturing images from the device.
This permission allows this application to capture pictures in order for them to be to be saved securely in digilocker and be viewed by the same user when needed
</p>
</li>

<li style="font-size:18px;"><p><h6>16. Photos/Files</h6>
<p>
Uses one or more files on the device such as images, docx, pdf and doc the device's external storage
</p>
</li>

<li style="font-size:18px;"><p><b>COPYRIGHT © MOVILO NETWORKS PRIVATE LIMITED, 2018. ALL RIGHTS RESERVED</b></p>
</li>
</ul>
							

							<hr class="tall">
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