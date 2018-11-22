<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
if(isset($_SESSION['admin_email_id'])){
	
	$admin_email_id		= $_SESSION['admin_email_id'];
	$admin_name			= $_SESSION['admin_name'];
	$admin_last_login	= $_SESSION['admin_last_login'];
	$ar_role_name  		= $_SESSION['ar_role_name'];
	$admin_phone_no  	= $_SESSION['admin_phone_no'];
	$ar_id  	        = $_SESSION['ar_id'];
	 
	require_once('controller/admin_controller.php');
	$control			= new admin();
	
	if(isset($_GET['brand_name']) && !empty($_GET['brand_name'])){
		$total_users_status 		= $control->get_dashboard_data_by_brand_status($_GET['brand_name']);
		$total_users_profile 		= $control->get_dashboard_data_by_brand_profile_type($_GET['brand_name']);
		$total_users_not_interested = $control->get_dashboard_data_by_brand_not_interested($_GET['brand_name']);
		
	}
	
?>

<!DOCTYPE html>

<html>

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
	
	<style>
	
	</style>
	
	<script src="js/jquery-2.1.1.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	
</head>

<body>
    <div id="wrapper">
		<?php include "header.php";?>
		
		<div id="" style="padding:20px;">
			<div class="dropdown profile-element"> 
			
				<?php if($_GET['brand_name'] == 'livpure') { ?>
					<span>
						<img alt="image" src="img/livpure.jpg" style="width:28%;margin-left:36%;margin-bottom:5%;"/>
					</span>
				<?php } else if($_GET['brand_name'] == 'zerob_consol1') { ?>
					<span>
						<img alt="image" src="img/livpure.jpg" style="width:28%;margin-left:36%;margin-bottom:5%;"/>
					</span>
				<?php } else if($_GET['brand_name'] == 'livpure_tn_kl') { ?>
					<span>
						<img alt="image" src="img/livpure.jpg" style="width:28%;margin-left:36%;margin-bottom:5%;"/>
					</span>
				<?php } else if($_GET['brand_name'] == 'bluestar_b2b') { ?>
					<span>
						<img alt="image" src="img/bluestar.png" style="width:28%;margin-left:36%;margin-bottom:5%;"/>
					</span>
				<?php } else if($_GET['brand_name'] == 'bluestar_b2c') { ?>
					<span>
						<img alt="image" src="img/bluestar.png" style="width:28%;margin-left:36%;margin-bottom:5%;"/>
					</span>
				<?php } else if($_GET['brand_name'] == 'livpure_ap'){ ?>
					<span>
						<img alt="image" src="img/livpure.jpg" style="width:28%;margin-left:36%;margin-bottom:5%;"/>
					</span>
				<?php } else if($_GET['brand_name'] == 'livpure_ts'){ ?>
					<span>
						<img alt="image" src="img/livpure.jpg" style="width:28%;margin-left:36%;margin-bottom:5%;"/>
					</span>
				<?php } else { ?>
					<span>
						<img alt="image" src="img/logo.png" style="width:28%;margin-left:30%;margin-bottom:5%;"/>
					</span>
				<?php } ?>
				
			</div>	
		</div>
		
		<div class="row" style="margin-left:35%;">
			<form id="dashboard_form" method="POST">
				<div class="row"  > 
					<div class="col-lg-3" style="margin-left:-3%">
						<label>Select your brand</label> 
						<select id="brand_name" class="form-control" name="brand_name">
							<option value="0">Select</option>
							<option value="livpure" <?php if($_GET['brand_name'] == 'livpure'){echo 'selected';} ?> >Livpure KA</option>
							<option value="zerob_consol1" <?php if($_GET['brand_name'] == 'zerob_consol1'){echo 'selected';} ?> >Zero B</option>
							<option value="livpure_tn_kl" <?php if($_GET['brand_name'] == 'livpure_tn_kl'){echo 'selected';} ?> >Livpure TN </option>						
							<option value="bluestar_b2b" <?php if($_GET['brand_name'] == 'bluestar_b2b'){echo 'selected';} ?> >Bluestar B2B</option>
							<option value="bluestar_b2c" <?php if($_GET['brand_name'] == 'bluestar_b2c'){echo 'selected';} ?> >Bluestar B2C</option>
							<option value="livpure_ap" <?php if($_GET['brand_name'] == 'livpure_ap'){echo 'selected';} ?> >Livpure AP</option>
							<option value="livpure_ts" <?php if($_GET['brand_name'] == 'livpure_ts'){echo 'selected';} ?> >Livpure TS</option>
						</select>
					</div>
					
					<div class="col-lg-2"  style="margin-top: 23px;">
						<input type="button" id="go_submit"  class="btn btn-info " value="Go" name="submit" >
					</div>
					
					<?php if($_GET['brand_name'] == 'livpure') { ?>
						<div class="col-lg-2" style="margin-top: 23px;margin-left: -7%;">
							<input type="button" id="customer_list"  class="btn btn-info " value="Dashboard" name="submit" onClick='window.open("brand_customers.php?customer_type=1")' >
						</div>
					<?php } else if($_GET['brand_name'] == 'zerob_consol1') { ?>
						<div class="col-lg-2" style="margin-top: 23px;margin-left: -7%;">
							<input type="button" id="customer_list"  class="btn btn-info " value="Dashboard" name="submit" onClick='window.open("brand_customers.php?customer_type=2")' >
						</div>
					<?php } else if($_GET['brand_name'] == 'livpure_tn_kl') { ?>
						<div class="col-lg-2" style="margin-top: 23px;margin-left: -7%;">
							<input type="button" id="customer_list"  class="btn btn-info " value="Dashboard" name="submit" onClick='window.open("brand_customers.php?customer_type=3")' >
						</div>
					<?php } else if($_GET['brand_name'] == 'bluestar_b2b') { ?>
						<div class="col-lg-2" style="margin-top: 23px;margin-left: -7%;">
							<input type="button" id="customer_list"  class="btn btn-info " value="Dashboard" name="submit" onClick='window.open("brand_customers.php?customer_type=4")' >
						</div>
					<?php } else if($_GET['brand_name'] == 'bluestar_b2c') { ?>
						<div class="col-lg-2" style="margin-top: 23px;margin-left: -7%;">
							<input type="button" id="customer_list"  class="btn btn-info " value="Dashboard" name="submit" onClick='window.open("brand_customers.php?customer_type=5")' >
						</div>
					<?php } else if($_GET['brand_name'] == 'livpure_ap') { ?>
						<div class="col-lg-2" style="margin-top: 23px;margin-left: -7%;">
							<input type="button" id="customer_list"  class="btn btn-info " value="Dashboard" name="submit" onClick='window.open("brand_customers.php?customer_type=6")' >
						</div>
					<?php } else if($_GET['brand_name'] == 'livpure_ts') { ?>		
						<div class="col-lg-2" style="margin-top: 23px;margin-left: -7%;">
							<input type="button" id="customer_list"  class="btn btn-info " value="Dashboard" name="submit" onClick='window.open("brand_customers.php?customer_type=7")' >
						</div>
					<?php } else { ?>
						<div class="col-lg-2" style="margin-top: 23px;">
							<input type="button" id="customer_list"  class="btn btn-info " value="Dashboard" name="submit" style="display:none;" >
						</div>
					<?php } ?>
					
				</div>
			</form>
		</div>
		
		
		<div id="container" style="height: 400px;padding:20px;"></div>
		<div id="container1" style="height: 400px;padding:20px;"></div>
		<div id="container2" style="height: 400px;padding:20px;"></div>
	
	</div>	
<script>

$('#go_submit').on('click',function(){
	var selected_brand = $( "#brand_name option:selected" ).val();
	location.href = '/movilo/admin-work/admin-panel/index.php?brand_name='+selected_brand+'';
});

</script>	

<script>

Highcharts.chart('container', {
	chart: {
		type: 'pie',
		options3d: {
			enabled: true,
			alpha: 45
		}
	},
	title: {
		text: 'Total Customers'
	},
	subtitle: {
		text: ''
	},
	plotOptions: {
		pie: {
			innerSize: 100,
			depth: 45
		}
	},
	series: [{
		name: 'Total customers',
		data: [
			['Customer requests (<?php echo $total_users_status['customer_requests']; ?>)', <?php echo $total_users_status['customer_requests']; ?>],
			['Not Interested (<?php echo $total_users_status['not_interested']; ?>)', <?php echo $total_users_status['not_interested']; ?>],
			['Request to reconnect (<?php echo $total_users_status['request_to_reconnect']; ?>)', <?php echo $total_users_status['request_to_reconnect']; ?>],
			['Requesting PM service (<?php echo $total_users_status['requesting_pm_service']; ?>)', <?php echo $total_users_status['requesting_pm_service']; ?>],
			['Not responsive (<?php echo $total_users_status['not_responsive']; ?>)', <?php echo $total_users_status['not_responsive']; ?>]
		]
	}]
});

</script>

<script>

Highcharts.chart('container1', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Profile Wise Customers'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: [
            'True Loyalists',
            'Acquaintences',
            'Strangers',
            'Poor Patrons',
            'Enthusiasts',
            'Admirers',
            'Benchwarmers',
            'Opportunists'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'No Of Customers'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="padding:0"><b>{point.y}</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [{
        name: '',
        data: [<?php echo $total_users_profile['true_loyalists']; ?>, <?php echo $total_users_profile['acquaintences']; ?>, <?php echo $total_users_profile['strangers']; ?>, <?php echo $total_users_profile['poor_patrons']; ?>, <?php echo $total_users_profile['enthusiasts']; ?>, <?php echo $total_users_profile['admirers']; ?>, <?php echo $total_users_profile['benchwarmers']; ?>, <?php echo $total_users_profile['opportunists']; ?>]

    }]
});

</script>

<script>	

Highcharts.chart('container2', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Not interested customer status'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        type: 'category'
    },
    yAxis: {
        title: {
            text: 'Total No of customers'
        }

    },
    legend: {
        enabled: false
    },
    plotOptions: {
        series: {
            borderWidth: 0,
            dataLabels: {}
        }
    },

    tooltip: {
        pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b><br/>'
    },

    "series": [
        {
            "colorByPoint": true,
            "data": [
				<?php foreach($total_users_not_interested as $key => $value){ ?>
					{
						"name": "<?php echo $key; ?>",
						"y": <?php echo $value; ?>,
					},
				<?php } ?>
            ]
        }
    ],
    
});

</script>
	
	 
               
<?php include "footer.php";?>

<?php
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
