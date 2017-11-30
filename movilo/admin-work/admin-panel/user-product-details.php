<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
if(isset($_SESSION['admin_email_id']))
{
	 $admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];

	require_once('controller/admin_controller.php');
	$control	=	new admin();
	
	
	// Get get_particular_user_details
	$id	=$_REQUEST['id'];
	$get_particular_user_product_details = $control->get_particular_user_product_details($id);
	// echo  '<pre>';
	// print_r($get_particular_user_product_details);
	
	
	
	
?>
<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:49:42 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" type="image/png" href="images/Yapnaa_logo-96x96.png">
    <title>Movilo | Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

</head>

<body>
    <div id="wrapper">
       <?php include "header.php";?>
        </div>
              
		<div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>User Product Details</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li>
                            <a href="users.php">Users List</a>
                        </li>
                        <li class="active">
                            <strong>User Product Details</strong>
                        </li>
                    </ol>
                </div>
            </div>
			
			
			<div class="wrapper wrapper-content animated fadeInRight">
				<div class="row">
					<div class="col-lg-6">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Product information</h5>
							</div>
							<div class="ibox-content">
								<table class="table table-striped table-bordered table-hover dataTables-example" >
										
									
									
									<tr>
									<td><p>Title </p></td>
									<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_title'])){
													echo $get_particular_user_product_details[0]['up_title'];
												}else{
													echo "NA";
												}?>
										</p>
									</td>
									</tr>
									
									
									
									
									<tr>
									<td><p>Product Name</p></td>
									<td> <p> <?php echo $get_particular_user_product_details[0]['p_category_name'];?></p></td>
									</tr>
									
									
									<tr>
									<td><p>Brand Name</p></td>
									<td> <p> <?php echo $get_particular_user_product_details[0]['brand_name'];?></p></td>
									</tr>
									
									
									
									<tr>
									<td><p> Serial No </p></td>
									<td> <p> <?php  echo $get_particular_user_product_details[0]['up_serial_no'];?></p></td>
									</tr>
									
									
									<tr>
									<td><p>Dealer Name </p></td>
									<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_dealer_name'])){
													echo $get_particular_user_product_details[0]['up_dealer_name'];
												}else{
													echo "NA";
												}?>
										</p>
									</td>
									</tr>
									
									
									
									<tr>
									<td><p>Date Of Purchase </p></td>
									<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_date_of_purchase'])){
													echo $get_particular_user_product_details[0]['up_date_of_purchase'];
												}else{
													echo "NA";
												}?>
										</p>
									</td>
									</tr>
									
									
									
									
									
									
									<tr>
									<td><p>Location </p></td>
									<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_location'])){
													echo $get_particular_user_product_details[0]['up_location'];
												}else{
													echo "NA";
												}?>
										</p>
									</td>
									</tr>
									
									
									<tr>
									<td><p>AMC </p></td>
									<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_amc'])){
													echo 'Form: '.$get_particular_user_product_details[0]['up_amc_from_date'].'<br/>';
													echo 'To: '.$get_particular_user_product_details[0]['up_amc_to_date'];
												}else{
													echo "NA";
												}?>
										</p>
									</td>
									</tr>
									
									
									
									<tr>
									<td><p>Warranty </p></td>
									<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_warranty_start_date'])){
													echo 'Form: '.$get_particular_user_product_details[0]['up_warranty_start_date'].'<br/>';
													echo 'To: '.$get_particular_user_product_details[0]['warranty_end_date'];
												}else{
													echo "NA";
												}?>
										</p>
									</td>
									</tr>
									
									
									
									<tr>
									<td><p>Guarantee </p></td>
									<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_garrenty_start_date'])){
													echo 'Form: '.$get_particular_user_product_details[0]['up_guarantee_start_date'].'<br/>';
													echo 'To: '.$get_particular_user_product_details[0]['up_guarantee_end_date'];
												}else{
													echo "NA";
												}?>
										</p>
									</td>
									</tr>
									
									
									<tr>
										<td><p>Additional Infomation </p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_additional_info'])){
														echo $get_particular_user_product_details[0]['up_additional_info'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
										
										
										
								</table>
							</div>
						</div>
					</div>
				
				
					<div class="col-lg-6">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Other Information</h5>
							</div>
							<div class="ibox-content">
							  <table class="table table-striped table-bordered table-hover dataTables-example">
										
										<tr>
										<td><p>Invoice No </p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_invoice_no'])){
														echo $get_particular_user_product_details[0]['up_invoice_no'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
											
										<tr>
										<td><p>Owner Email </p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_owner_email'])){
														echo $get_particular_user_product_details[0]['up_owner_email'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
										
											
										<tr>
										<td><p>Owner Adderss </p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_owner_address'])){
														echo $get_particular_user_product_details[0]['up_owner_address'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
										
											
										<tr>
										<td><p>Owner Purchase Date</p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_owner_purchase_date'])){
														echo $get_particular_user_product_details[0]['up_owner_purchase_date'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
										
											
										<tr>
										<td><p>Owner Purchase City</p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_owner_purchase_city'])){
														echo $get_particular_user_product_details[0]['up_owner_purchase_city'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
										
										<tr>
										<td><p>Owner Purchase Pincode</p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_owner_purchase_pincode'])){
														echo $get_particular_user_product_details[0]['up_owner_purchase_pincode'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
										
										
										
										<tr>
										<td><p>Owner Purchase Retailer Name</p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_owner_retailer_name'])){
														echo $get_particular_user_product_details[0]['up_owner_retailer_name'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
										
										
										<tr>
										<td><p>Owner Purchase Retailer Code</p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_owner_retailer_code'])){
														echo $get_particular_user_product_details[0]['up_owner_retailer_code'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
										
										
										
										<tr>
										<td><p>Owner Purchase Retailer Number</p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_owner_retailer_number'])){
														echo $get_particular_user_product_details[0]['up_owner_retailer_number'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
										
										
										<tr>
										<td><p>Owner Purchase Warranty </p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_owner_warranty_start_date'])){
														echo $get_particular_user_product_details[0]['up_owner_warranty_start_date'].'<br/>';
														echo $get_particular_user_product_details[0]['up_owner_warranty_end_date'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
										
										
										
										<tr>
										<td><p>Owner Purchase Guarantee </p></td>
										<td> <p> <?php if(!empty($get_particular_user_product_details[0]['up_owner_guarantee_start_date'])){
														echo $get_particular_user_product_details[0]['up_owner_guarantee_start_date'].'<br/>';
														echo $get_particular_user_product_details[0]['up_owner_guarantee_start_date'];
													}else{
														echo "NA";
													}?>
											</p>
										</td>
										</tr>
										
									
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		
		
		










		
                
               
<?php include "footer.php";?>

<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script>

function myFunction() {
	
var add_cat = $("#brand").val();
if ($.trim(add_cat) === '')
{
alert("Please Enter Brand Name.");
$('#brand').val('');
$('#brand').focus();
 return false;
}


}
</script>

<?php
}
else
{
?>
<script>
  window.location.assign("../index.php")
</script>
<?php
}
?>
