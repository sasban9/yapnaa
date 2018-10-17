<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
if(isset($_SESSION['admin_email_id'])){
	
	$admin_email_id	= $_SESSION['admin_email_id'];
	$admin_name		= $_SESSION['admin_name'];
	$admin_last_login	= $_SESSION['admin_last_login'];
	$ar_role_name  	= $_SESSION['ar_role_name'];
	$admin_phone_no  	= $_SESSION['admin_phone_no'];
	$ar_id  	        = $_SESSION['ar_id'];
	 
	require_once('controller/admin_controller.php');
	$control	=	new admin();
	
	if(isset($_POST['fromDate']) && !empty($_POST['fromDate'])){ //echo "<br>in from";
		$fromDate = date_format(date_create($_POST['fromDate']),"Y-m-d H:i:s");
	}
	else{
		$fromDate = "";
	}
	
	if(isset($_POST['toDate']) && !empty($_POST['toDate'])){// echo "<br>in to";
		$toDate = date_format(date_create($_POST['toDate'].' 23:59:59'),"Y-m-d H:i:s");
	}
	else{
		$toDate = "";
	}
	
	$highlyengaged 		= $control->highlyengaged_customer("1",$fromDate,$toDate);
	//echo "<br><pre>"; print_r($highlyengaged); die;
	$highlyengageduser	=$highlyengaged[0]['users'];
	
	$engaged = $control->engaged_customer("1",$fromDate,$toDate);
	$engageduser=$engaged[0]['users'];
	
	$partialy_engaged = $control->partialy_engaged_customer("1",$fromDate,$toDate);
	$partialy_engageduser=$partialy_engaged[0]['users'];
	
	$disengaged = $control->disengaged_customer("1",$fromDate,$toDate);
	$disengageduser=$disengaged[0]['users'];
	
	$share_positive = $control->share_positive_experience_customer("1",$fromDate,$toDate);
	$sharepositive=$share_positive[0]['users'];
	
	$made_right_choice = $control->made_right_choice_customer("1",$fromDate,$toDate);
	$maderightchoice=$made_right_choice[0]['users'];
	
	$get_support_on_time = $control->get_support_on_time_customer("1",$fromDate,$toDate);
	$getsupportontime=$get_support_on_time[0]['users'];
    
	$willingness_to_refer = $control->willingness_to_refer_customer("1",$fromDate,$toDate);
	$willingnesstorefer=$willingness_to_refer[0]['users'];
    
	$attempt_to_gather_knowledge = $control->attempt_to_gather_knowledge_customer("1",$fromDate,$toDate);
	$attempttogatherknowledge=$attempt_to_gather_knowledge[0]['users'];
    
	$periodic_feedback_to = $control->periodic_feedback_to_customer("1",$fromDate,$toDate);
	$periodicfeedbackto=$periodic_feedback_to[0]['users'];
    
	$periodic_update = $control->periodic_update_customer("1",$fromDate,$toDate);
	 $periodicupdate=$periodic_update[0]['users'];	 
    
	$disengaged_under_AMC = $control->disengaged_under_AMC_customer("1",$fromDate,$toDate);
	 $disengagedunderAMC=$disengaged_under_AMC[0]['users'];
    
	$poor_service = $control->poor_service_customer("1",$fromDate,$toDate);
	 $poorservice=$poor_service[0]['users'];
    
	$negative_expirence = $control->negative_expirence_customer("1",$fromDate,$toDate);
	 $negativeexpirence=$negative_expirence[0]['users'];
    
	$will_call_when_required = $control->will_call_when_required_customer("1",$fromDate,$toDate);
	 $willcallwhenrequired=$will_call_when_required[0]['users'];
    
	$service_not_required = $control->service_not_required_customer("1",$fromDate,$toDate);
	 $servicenotrequired=$service_not_required[0]['users'];	
	 
	$highly_engaged_last_paid_service_6month = $control->highly_engaged_last_paid_service_6month_customer("1",$fromDate,$toDate);
	$highlyengagedlastpaidservice6month=$highly_engaged_last_paid_service_6month[0]['users'];
    $highly_engaged_last_paid_service_1year = $control->highly_engaged_last_paid_service_1year_customer("1",$fromDate,$toDate);
	$highlyengagedlastpaidservice1year=$highly_engaged_last_paid_service_1year[0]['users'];
	 
    $highly_engaged_under_AMC_yes = $control->highly_engaged_under_AMC_customer_yes("1",$fromDate,$toDate);
	 $highlyengagedunderAMCyes=$highly_engaged_under_AMC_yes[0]['users'];
	 $highly_engaged_under_AMC_no = $control->highly_engaged_under_AMC_customer_no("1",$fromDate,$toDate);
	$highlyengagedunderAMCno=$highly_engaged_under_AMC_no[0]['users']; 
	
    $highly_engaged_withtimeline_yes = $control->highly_engaged_withtimeline_customer_yes("1",$fromDate,$toDate);
	 $highlyengagedwithtimelineyes=$highly_engaged_withtimeline_yes[0]['users'];
    $highly_engaged_withtimeline_no = $control->highly_engaged_withtimeline_customer_no("1",$fromDate,$toDate);
	 $highlyengagedwithtimelineno=$highly_engaged_withtimeline_no[0]['users'];
	
    $highly_engaged_withquality_yes = $control->highly_engaged_withquality_customer_yes("1",$fromDate,$toDate);
	 $highlyengagedwithqualityyes=$highly_engaged_withquality_yes[0]['users'];
	$highly_engaged_withquality_no = $control->highly_engaged_withquality_customer_no("1",$fromDate,$toDate);
	 $highlyengagedwithqualityno=$highly_engaged_withquality_no[0]['users'];
	
    $highly_engaged_feedbackservice_yes = $control->highly_engaged_feedbackservice_customer_yes("1",$fromDate,$toDate);
	 $highlyengagedfeedbackserviceyes=$highly_engaged_feedbackservice_yes[0]['users'];
	$highly_engaged_feedbackservice_no = $control->highly_engaged_feedbackservice_customer_no("1",$fromDate,$toDate);
	 $highlyengagedfeedbackserviceno=$highly_engaged_feedbackservice_no[0]['users']; 
	 
    $highly_engaged_requiredservice_yes = $control->highly_engaged_requiredservice_customer_yes("1",$fromDate,$toDate);
	 $highlyengagedrequiredserviceyes=$highly_engaged_requiredservice_yes[0]['users'];
	$highly_engaged_requiredservice_no = $control->highly_engaged_requiredservice_customer_no("1",$fromDate,$toDate);
	 $highlyengagedrequiredserviceno=$highly_engaged_requiredservice_no[0]['users'];
	 
    $highly_engaged_requestAMC_yes = $control->highly_engaged_requestAMC_customer_yes("1",$fromDate,$toDate);
	 $highlyengagedrequestAMCyes=$highly_engaged_requestAMC_yes[0]['users'];
	$highly_engaged_requestAMC_no = $control->highly_engaged_requestAMC_customer_no("1",$fromDate,$toDate);
	 $highlyengagedrequestAMCno=$highly_engaged_requestAMC_no[0]['users']; 
	 
    $highly_engaged_wishUpgrade_yes = $control->highly_engaged_wishUpgrade_customer_yes("1",$fromDate,$toDate);
	 $highlyengagedwishUpgradeyes=$highly_engaged_wishUpgrade_yes[0]['users']; 
	$highly_engaged_wishUpgrade_no = $control->highly_engaged_wishUpgrade_customer_no("1",$fromDate,$toDate);
	 $highlyengagedwishUpgradeno=$highly_engaged_wishUpgrade_no[0]['users'];  
	 
	 $engaged_last_paid_service_6month = $control->engaged_last_paid_service_6month_customer("1",$fromDate,$toDate);
	 $engagedlastpaidservice6month=$engaged_last_paid_service_6month[0]['users'];
    $engaged_last_paid_service_1year = $control->engaged_last_paid_service_1year_customer("1",$fromDate,$toDate);
	 $engagedlastpaidservice1year=$engaged_last_paid_service_1year[0]['users'];
	 
    $engaged_under_AMC_yes = $control->engaged_under_AMC_customer_yes("1",$fromDate,$toDate);
	 $engagedunderAMCyes=$engaged_under_AMC_yes[0]['users'];
	$engaged_under_AMC_no = $control->engaged_under_AMC_customer_no("1",$fromDate,$toDate);
	 $engagedunderAMCno=$engaged_under_AMC_no[0]['users'];
	
    $engaged_withtimeline_yes = $control->engaged_withtimeline_customer_yes("1",$fromDate,$toDate);
	 $engagedwithtimelineyes=$engaged_withtimeline_yes[0]['users'];
    $engaged_withtimeline_no = $control->engaged_withtimeline_customer_no("1",$fromDate,$toDate);
	 $engagedwithtimelineno=$engaged_withtimeline_no[0]['users'];
	 
    $engaged_withquality_yes = $control->engaged_withquality_customer_yes("1",$fromDate,$toDate);
	 $engagedwithqualityyes=$engaged_withquality_yes[0]['users'];
	$engaged_withquality_no = $control->engaged_withquality_customer_no("1",$fromDate,$toDate);
	 $engagedwithqualityno=$engaged_withquality_no[0]['users'];
	 
    $engaged_feedbackservice_yes = $control->engaged_feedbackservice_customer_yes("1",$fromDate,$toDate);
	 $engagedfeedbackserviceyes=$engaged_feedbackservice_yes[0]['users'];
	$engaged_feedbackservice_no = $control->engaged_feedbackservice_customer_no("1",$fromDate,$toDate);
	 $engagedfeedbackserviceno=$engaged_feedbackservice_no[0]['users'];
	
    $engaged_requiredservice_yes = $control->engaged_requiredservice_customer_yes("1",$fromDate,$toDate);
	 $engagedrequiredserviceyes=$engaged_requiredservice_yes[0]['users'];
	$engaged_requiredservice_no = $control->engaged_requiredservice_customer_no("1",$fromDate,$toDate);
	 $engagedrequiredserviceno=$engaged_requiredservice_no[0]['users']; 
	  
    $engaged_requestAMC_yes = $control->engaged_requestAMC_customer_yes("1",$fromDate,$toDate);
	 $engagedrequestAMCyes=$engaged_requestAMC_yes[0]['users'];
	$engaged_requestAMC_no = $control->engaged_requestAMC_customer_no("1",$fromDate,$toDate);
	 $engagedrequestAMCno=$engaged_requestAMC_no[0]['users'];
	 
    $engaged_wishUpgrade_yes = $control->engaged_wishUpgrade_customer_yes("1",$fromDate,$toDate);
	 $engagedwishUpgradeyes=$engaged_wishUpgrade_yes[0]['users'];
	$engaged_wishUpgrade_no = $control->engaged_wishUpgrade_customer_no("1",$fromDate,$toDate);
	 $engagedwishUpgradeno=$engaged_wishUpgrade_no[0]['users']; 
    
     $partialy_engaged_last_paid_service_6month = $control->partialy_engaged_last_paid_service_6month_customer("1",$fromDate,$toDate);
	 $partialyengagedlastpaidservice6month=$partialy_engaged_last_paid_service_6month[0]['users'];
    $partialy_engaged_last_paid_service_1year = $control->partialy_engaged_last_paid_service_1year_customer("1",$fromDate,$toDate);
	 $partialyengagedlastpaidservice1year=$partialy_engaged_last_paid_service_1year[0]['users'];
	 
    $partialy_engaged_under_AMC_yes = $control->partialy_engaged_under_AMC_customer_yes("1",$fromDate,$toDate);
	 $partialyengagedunderAMCyes=$partialy_engaged_under_AMC_yes[0]['users'];
    $partialy_engaged_withtimeline_yes = $control->partialy_engaged_withtimeline_customer_yes("1",$fromDate,$toDate);
	 $partialyengagedwithtimelineyes=$partialy_engaged_withtimeline_yes[0]['users'];	 
    $partialy_engaged_withquality_yes = $control->partialy_engaged_withquality_customer_yes("1",$fromDate,$toDate);
	 $partialyengagedwithqualityyes=$partialy_engaged_withquality_yes[0]['users'];
    $partialy_engaged_feedbackservice_yes = $control->partialy_engaged_feedbackservice_customer_yes("1",$fromDate,$toDate);
	 $partialyengagedfeedbackserviceyes=$partialy_engaged_feedbackservice_yes[0]['users'];
    $partialy_engaged_requiredservice_yes = $control->partialy_engaged_requiredservice_customer_yes("1",$fromDate,$toDate);
	 $partialyengagedrequiredserviceyes=$partialy_engaged_requiredservice_yes[0]['users'];
    $partialy_engaged_requestAMC_yes = $control->partialy_engaged_requestAMC_customer_yes("1",$fromDate,$toDate);
	 $partialyengagedrequestAMCyes=$partialy_engaged_requestAMC_yes[0]['users'];
    $partialy_engaged_wishUpgrade_yes = $control->partialy_engaged_wishUpgrade_customer_yes("1",$fromDate,$toDate);
	 $partialyengagedwishUpgradeyes=$partialy_engaged_wishUpgrade_yes[0]['users'];
    
    $partialy_engaged_under_AMC_no = $control->partialy_engaged_under_AMC_customer_no("1",$fromDate,$toDate);
	 $partialyengagedunderAMCno=$partialy_engaged_under_AMC_no[0]['users'];
    $partialy_engaged_withtimeline_no = $control->partialy_engaged_withtimeline_customer_no("1",$fromDate,$toDate);
	 $partialyengagedwithtimelineno=$partialy_engaged_withtimeline_no[0]['users'];	 
    $partialy_engaged_withquality_no = $control->partialy_engaged_withquality_customer_no("1",$fromDate,$toDate);
	 $partialyengagedwithqualityno=$partialy_engaged_withquality_no[0]['users'];
    $partialy_engaged_feedbackservice_no = $control->partialy_engaged_feedbackservice_customer_no("1",$fromDate,$toDate);
	 $partialyengagedfeedbackserviceno=$partialy_engaged_feedbackservice_no[0]['users'];
    $partialy_engaged_requiredservice_no = $control->partialy_engaged_requiredservice_customer_no("1",$fromDate,$toDate);
	 $partialyengagedrequiredserviceno=$partialy_engaged_requiredservice_no[0]['users'];
    $partialy_engaged_requestAMC_no = $control->partialy_engaged_requestAMC_customer_no("1",$fromDate,$toDate);
	 $partialyengagedrequestAMCno=$partialy_engaged_requestAMC_no[0]['users'];
    $partialy_engaged_wishUpgrade_no = $control->partialy_engaged_wishUpgrade_customer_no("1",$fromDate,$toDate);
	 $partialyengagedwishUpgradeno=$partialy_engaged_wishUpgrade_no[0]['users'];	
	
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
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/highcharts-3d.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	
</head>

<body>
    <div id="wrapper">
		<?php include "header.php";?>
	   	<form id="form" method="POST" enctype="multipart/form-data">
		<div class="row"  > 
			<div class="col-lg-4 "  > 
			</div>
				<div class="col-lg-2 "  > 
					<label >From</label>
					
					<input type="date" class="form-control" id="fromDate" name="fromDate" value="<?php echo(isset($_POST['fromDate']))?$_POST['fromDate']:"";?>">
				</div>
				<div class="col-lg-2"  >			
					<label >To</label>
					<input type="date" class="form-control"  id="toDate" name="toDate" value="<?php echo(isset($_POST['toDate']))?$_POST['toDate']:"";?>">
				</div>
				<div class="col-lg-2"  style="margin-top: 23px;">
					<input type="submit" id="submit"  class="btn btn-info " value="Search"  name="submit" >
				</div>
				<div class="col-lg-2 "  > 
			</div>
	    </div>
		</form>
		<div class="row"  >
		   <div class="col-lg-12 "  > 
			</div> 
		</div>
		<div class="row"  >
		   <div class="col-lg-12 "  > 
			</div> 
		</div>
		<div class="row"  >
		   <div class="col-lg-12 "  > 
			</div> 
		</div>
		<div class="row"  >
		   <div class="col-lg-12 "  > 
			</div> 
		</div>
      <div id="container" style="height: 400px;padding:20px"></div>
	  <div id="container1" style=" height: 400px;padding:20px"></div>	  
	  <div id="container3" style=" height: 400px;padding:20px"></div>
	  <div id="container4" style=" height: 400px;padding:20px"></div> 
	  <div id="container5" style=" height: 400px;padding:20px"></div> 
	  <div id="container2" style=" height: 400px;padding:20px"></div>
	  <script>
/* pie chart  */	  
	Highcharts.chart('container', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'Contents Yapnaa Customers'
    },
   /*  subtitle: {
        text: '3D donut in Highcharts'
    }, */
    plotOptions: {
        pie: {
            innerSize: 100,
            depth: 45
			
        }
    },
	 colors: ['#20bf6b', '#0fb9b1', '#f7b731', '#fa8231'],
    series: [{
        name: 'Yapnaa Customers',
        data: [
            ['Highly Engaged Customers', <?php echo $highlyengageduser;?>],
            ['Engaged Customers', <?php echo $engageduser;?>],
            ['Partialy Engaged Customers', <?php echo $partialy_engageduser;?>],
            ['Disengaged Customers', <?php echo $disengageduser;?>]
            
        ]
    }]
});
/* bar graph for ownership experience */
      Highcharts.chart('container1', { 
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Customer Ownership Experience'
    },
    /* subtitle: {
        text: 'Source: <a href="https://en.wikipedia.org/wiki/World_population">Wikipedia.org</a>'
    }, */
    xAxis: {
        categories: ['Receive Periodic Updates', 'Periodic Feedback To Company', 'Attempt To Gather Knowledge', 'Willingness To Refer', 'Get Support On Time','Made Right Choice','Share Positive Experience'],
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Customers (numbers)',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: 'numbers'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
		showInLegend: false,
        name: 'Year 2018',
        data: [<?php echo $periodicupdate;?>,<?php echo $periodicfeedbackto;?>,<?php echo $attempttogatherknowledge;?>,<?php echo $willingnesstorefer;?>, <?php echo $getsupportontime;?>,<?php echo $maderightchoice;?>,<?php echo $sharepositive;?>]
    }/* , {
        name: 'Year 1900',
        data: [133, 156, 947, 408, 6]
    }, {
        name: 'Year 2000',
        data: [814, 841, 3714, 727, 31]
    }, {
        name: 'Year 2016',
        data: [1216, 1001, 4436, 738, 40]
    } */]
});
   /* bar graph for Disengaged Customers */
      Highcharts.chart('container2', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Disengaged Customers'
    },
   
    xAxis: {
        categories: ['Under AMC', 'Poor Service Experience', 'Negative Experience On Product', 'Will Call When Required', 'Service Not Required'],
        title: {
            text: null
        }
    }, 
    yAxis: {
        min: 0,
        title: {
            text: 'Customers (numbers)',
            align: 'high'
        },
        labels: {  
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: 'numbers'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),
        shadow: true
    }, 
    credits: {
        enabled: false
    },
	colors: ['#fa8231'],
    series: [{
		showInLegend: false,
        name: 'Year 2018',
        data: [<?php echo $disengagedunderAMC;?>,<?php echo $poorservice;?>,<?php echo $negativeexpirence;?>,<?php echo $willcallwhenrequired;?>, <?php echo $servicenotrequired;?>]
    }]
});
  /* bar graph for Highlyengaged Customers */   
	 Highcharts.chart('container3', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Highly Engaged Customers'
    },
    xAxis: {
        categories: ['Required Service','Request For AMC','Wish To Upgrade','No Feedback On Service','Satisfied With Quality','Satisfied With Timeline','Under AMC','Lastpaid Service <6 Months','Lastpaid Service <1 Year'],
      
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Customers (numbers)'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
	colors: ['#20bf6b','#000000'],
    series: [{
        name: 'Yes',
        data: [<?php echo $highlyengagedrequiredserviceyes;?>,<?php echo $highlyengagedrequestAMCyes;?>,<?php echo $highlyengagedwishUpgradeyes;?>,<?php echo $highlyengagedfeedbackserviceyes;?>,<?php echo $highlyengagedwithqualityyes;?>,<?php echo $highlyengagedwithtimelineyes;?>,<?php echo $highlyengagedunderAMCyes;?>,<?php echo $highlyengagedlastpaidservice6month;?>,<?php echo $highlyengagedlastpaidservice1year;?>]
    }, {
        name: 'No',
        data: [<?php echo $highlyengagedrequiredserviceno;?>,<?php echo $highlyengagedrequestAMCno;?>,<?php echo $highlyengagedwishUpgradeno;?>,<?php echo $highlyengagedfeedbackserviceno;?>,<?php echo $highlyengagedwithqualityno;?>,<?php echo $highlyengagedwithtimelineno;?>,<?php echo $highlyengagedunderAMCno;?>,0,0]
    }]
});
 /* bar graph for Engaged Customers */
    
	 Highcharts.chart('container4', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Engaged Customers'
    },
    xAxis: {
        categories: ['Required Service','Request For AMC','Wish To Upgrade','No Feedback On Service','Satisfied With Quality','Satisfied With Timeline','Under AMC','Lastpaid Service <6 Months','Lastpaid Service <1 Year'],
      
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Customers (numbers)'
        }
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
	colors: ['#0fb9b1','#000000'],  
    series: [{
        name: 'Yes',
        data: [<?php echo $engagedrequiredserviceyes;?>,<?php echo $engagedrequestAMCyes;?>,<?php echo $engagedwishUpgradeyes;?>,<?php echo $engagedfeedbackserviceyes;?>,<?php echo $engagedwithqualityyes;?>,<?php echo $engagedwithtimelineyes;?>,<?php echo $engagedunderAMCyes;?>,<?php echo $engagedlastpaidservice6month;?>,<?php echo $engagedlastpaidservice1year;?>]
    }, {
        name: 'No',
        data: [<?php echo $engagedrequiredserviceno;?>,<?php echo $engagedrequestAMCno;?>,<?php echo $engagedwishUpgrade;?>,<?php echo $engagedfeedbackserviceno;?>,<?php echo $engagedwithqualityno;?>,<?php echo $engagedwithtimelineno;?>,<?php echo $engagedunderAMCno;?>,0,0]
    }]
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
