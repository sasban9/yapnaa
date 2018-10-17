<?php 
 session_start(); 
if(isset($_SESSION['admin_email_id'])){
	$admin_email_id	= $_SESSION['admin_email_id'];
	 $admin_name		= $_SESSION['admin_name'];
	 $admin_last_login	= $_SESSION['admin_last_login'];
	require_once('controller/admin_controller.php');
	$control	=	new admin();
	$postdata = file_get_contents("php://input");
    $request = json_decode($postdata);
	$custType = $request->custType;
	$search =  $request->searchBox;
	$action_taken_by = $request->action_taken_by;
	$filter = $request->filter;
	$filterByBrand = $request->filterByBrand;
	$filterByAttempt = $request->filterByAttempt;
		if(isset($request->fromDate) && !empty($request->fromDate)){ //echo "<br>in from";
			$fromDate = date_format(date_create($request->fromDate),"Y-m-d H:i:s");
		}
		else{
			$fromDate = "";
		}
		if(isset($request->toDate) && !empty($request->toDate)){// echo "<br>in to";
			$toDate = date_format(date_create($request->toDate.' 23:59:59'),"Y-m-d H:i:s");
		}
		else{
			$toDate	=	"";
		}
		if(isset($request->yapnaaIdfm) && !empty($request->yapnaaIdfm)){ //echo "<br>in from";
			$yapnaaIdfm = $request->yapnaaIdfm;
		}
		else{
			$yapnaaIdfm = "";
		}
		if(isset($request->yapnaaIdto) && !empty($request->yapnaaIdto)){// echo "<br>in to";
			$yapnaaIdto = $request->yapnaaIdto;
		}
		else{
			$yapnaaIdto	=	"";
		}
		if(isset($request->amc_fromDate) && !empty($request->amc_fromDate)){// echo "<br>in to";
			$amc_fromDate= date_format(date_create($request->amc_fromDate),"d-m-Y");
		}
		else{
			$amc_fromDate=	"";
		}
		if(isset($request->amc_toDate) && !empty($request->amc_toDate)){// echo "<br>in to";
			$amc_toDate= date_format(date_create($request->amc_toDate),"d-m-Y");
		}
		else{
			$amc_toDate=	"";
		}
	$get_amc_list = $control->get_brand_list1111111($filterByAttempt,$action_taken_by,$search,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$filterByBrand,$yapnaaIdfm,$yapnaaIdto);
	$json = json_encode($get_amc_list); 
	echo $json; 
	exit;
}
else
{
?>
<script>
  window.location.assign("../index.php");
</script>
<?php 
}
?>