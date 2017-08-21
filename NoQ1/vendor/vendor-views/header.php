<?php
require_once("../../config/tab_config.php");
require_once("../../config/config.php");

require_once("../../model/model.php"); 
$obj_model	=	new model();
require_once('../../controller/vendor_controller.php'); 
$vendor_controller	=	new vendor_controller();


 
/* get_store_details_by_id*/
 $storeid						=	$_SESSION['b_store_id'];
 $get_store_details_by_id		=	$vendor_controller->get_store_details_by_id($storeid);  
// echo'<pre>';print_r( $get_store_details_by_id);
?>
<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>NoQ | Admin Dashboard</title>    
  <meta charset="utf-8" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="css/animate.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/font.css" type="text/css" />
  <link rel="stylesheet" href="js/calendar/bootstrap_calendar.css" type="text/css" />
  <link rel="stylesheet" href="css/app.css" type="text/css" />   
  <link rel="stylesheet" href="js/datatables/datatables.css" type="text/css"/>
  
  <script src="js/jquery.min.js"></script>
  <link rel="stylesheet" href="js/datatablesnew/jquery.dataTables.min.css" type="text/css" />
  <script src="js/datatablesnew/jquery.dataTables.min.js"></script>
  
  
  <!-- Data Table CSS -->
  <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
  <style>
	table.dataTable tr.odd td.sorting_1 {
		background-color: #F9F9F9;
	}
	table.dataTable tr.even td.sorting_1 {
		background-color: #fff;
	}
	</style>
  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
</head>

<body>
  <section class="vbox">
    <header class="bg-dark dk header navbar navbar-fixed-top-xs">
      <div class="navbar-header aside-md">
        <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen,open" data-target="#nav,html">
          <i class="fa fa-bars"></i>
        </a>
        <a href="#" class="navbar-brand" data-toggle="fullscreen"><img src="images/logo.png" class="m-r-sm">NoQ</a>
        <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user">
          <i class="fa fa-cog"></i>
        </a>
      </div>
		<ul class="nav navbar-nav hidden-xs">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle dker" data-toggle="dropdown">
            <i class="fa fa-building-o"></i> 
            <span class="font-bold">Activity</span>
          </a>
          <section class="dropdown-menu aside-xl on animated fadeInLeft no-borders lt">
            <div class="wrapper lter m-t-n-xs"> 
				 <a href="#" class="thumb pull-left m-r">
					<?php if($get_store_details_by_id[0]['b_store_image']){ ?>
					<img src="../../admin/admin-views/images/business_stores/<?php echo $get_store_details_by_id[0]['b_store_image'];?>" class="img-circle" style="height:40px">
					<?php } else{?>
					<img src="images/Qno-logo-png.png" class="img-circle" style="height:40px">				
					<?php }?>
				  </a>  
              <div class="clear">
                <a href="#"><span class="text-white font-bold"><?php echo$get_store_details_by_id[0]['b_store_owner_name'];?></a></span>
                <small class="block">  Shop Owner
				</small> 
              </div>
            </div>
            <div class="row m-l-none m-r-none m-b-n-xs text-center">
              <div class="col-xs-12">
                <div class="padder-v">
                  <span class="m-b-xs h4 block text-white">Last Login</span>
                  <small class="text-muted">
					  <?php if($get_store_details_by_id[0]['b_store_last_login']!=''){
						echo $get_store_details_by_id[0]['b_store_last_login'];
					  }else{
						echo "Just Logged In";
					  }?>
				  </small>
                </div>
              </div> 
            </div>
          </section>
        </li> 
      </ul> 
	  

      <ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user">
        <!--li class="hidden-xs">
          <a href="#" class="dropdown-toggle dk" data-toggle="dropdown">
            <i class="fa fa-bell"></i>
            <span class="badge badge-sm up bg-danger m-l-n-sm count">2</span>
          </a>
          <section class="dropdown-menu aside-xl">
            <section class="panel bg-white">
              <header class="panel-heading b-light bg-light">
                <strong>You have <span class="count">2</span> notifications</strong>
              </header>
              <div class="list-group list-group-alt animated fadeInRight">
                <a href="#" class="media list-group-item">
                  <span class="pull-left thumb-sm">
                    <img src="images/avatar.jpg" alt="John said" class="img-circle">
                  </span>
                  <span class="media-body block m-b-none">
                    Use awesome animate.css<br>
                    <small class="text-muted">10 minutes ago</small>
                  </span>
                </a> 
              </div>
              <footer class="panel-footer text-sm">
                <a href="#" class="pull-right"><i class="fa fa-cog"></i></a>
                <a href="#notes" data-toggle="class:show animated fadeInRight">See all the notifications</a>
              </footer>
            </section>
          </section>
        </li-->
         
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
				<span class="thumb-sm avatar pull-left">
				  <?php if($get_store_details_by_id[0]['b_store_image']){ ?>
				  <img src="../../admin/admin-views/images/business_stores/<?php echo $get_store_details_by_id[0]['b_store_image'];?>">
				  <?php } else{?>
				   <img src="images/Qno-logo-png.png">
				   <?php }?>
				</span>
            <?php echo $get_store_details_by_id[0]['b_store_owner_name'];?> <b class="caret"></b>
          </a> 
          <ul class="dropdown-menu animated fadeInRight">
            <span class="arrow top"></span> 
           <!-- <li>
              <a href="profile.php">Profile</a>
            </li>
            <li>
              <a href="#">
                <span class="badge bg-danger pull-right">3</span>
                Notifications
              </a>
            </li>
            <li>
              <a href="help.php">Help</a>
            </li>-->
            <li class="divider"></li>
            <li>
              <a href="logout.php" data-toggle="ajaxModal" >Logout</a>
            </li>
          </ul>
        </li>
      </ul>      
    </header>
    <section>
	
	
		  
	  
      <section class="hbox stretch"> 
        <aside class="bg-dark lter aside-md hidden-print" id="nav">          
          <section class="vbox"> 
            <section class="w-f scrollable">
              <div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="5px" data-color="#333333">
                
                <!-- nav -->
                <nav class="nav-primary hidden-xs">
                  <ul class="nav">
                    <li  class="active">
                      <a href="index.php"   class="active">
                        <i class="fa fa-home">
                          <b class="bg-danger"></b>
                        </i>
                        <span>Home</span>
                      </a>
                    </li>
					
					 
					 <?php if($get_store_details_by_id[0]['b_store_status']==1){?>
					 
					 	 <?php if($get_store_details_by_id[0]['b_store_business_type']==1){?>
						 
						 
							 	<li>
								  <a href="ticket-list.php" >  
									<i class="fa fa-edit">
									  <b class="bg-info"></b>
									</i>
									<span>Tickets </span>
								  </a>
								</li>
								
								<li>
								  <a href="shop-ticket-order-list.php" >  
									<i class="fa fa-tag">
									  <b class="bg-info"></b>
									</i>
									<span>Ticket Orders </span>
								  </a>
								</li>
								
								
								<li>
								  <a href="shop-order-list.php" >  
									<i class="fa fa-shopping-cart">
									  <b class="bg-info"></b>
									</i>
									<span>Orders </span>
								  </a>
								</li>
								
								
								
								<li>
								  <a href="service-tax.php" >  
									<i class="fa fa-tag">
									  <b class="bg-info"></b>
									</i>
									<span>Service Tax </span>
								  </a>
								</li>
								
								<li>
								  <a href="slider-img.php" >  
									<i class="fa fa-picture-o">
									  <b class="bg-info"></b>
									</i>
									<span>Slider Img </span>
								  </a>
								</li>
								
								
							<?php  } else { ?>
							
							
							
								<li>
								  <a href="shop-product-list.php" >  
									<i class="fa fa-edit">
									  <b class="bg-info"></b>
									</i>
									<span>Products </span>
								  </a>
								</li>
								
								
								<li>
								  <a href="shop-order-list.php" >  
									<i class="fa fa-shopping-cart">
									  <b class="bg-info"></b>
									</i>
									<span>Orders </span>
								  </a>
								</li>
								
								
								
								<li>
								  <a href="service-tax.php" >  
									<i class="fa fa-tag">
									  <b class="bg-info"></b>
									</i>
									<span>Service Tax </span>
								  </a>
								</li>
								
								
								<li>
								  <a href="shop-checkout-list.php" >  
									<i class="fa fa-tag">
									  <b class="bg-info"></b>
									</i>
									<span>Checkout Users</span>
								  </a>
								</li>
								
							<?php  } ?>
							
					<?php  } ?>  
					
					  
                  </ul>
                </nav>
                <!-- / nav -->
              </div>
            </section>
            
            <footer class="footer lt hidden-xs b-t b-dark">  
              <a href="#nav" data-toggle="class:nav-xs" class="pull-right btn btn-sm btn-dark btn-icon">
                <i class="fa fa-angle-left text"></i>
                <i class="fa fa-angle-right text-active"></i>
              </a> 
            </footer>
          </section>
        </aside>
		
		 
		  <!-- /.aside -->