<?php 

if(isset($_REQUEST['id'])){
	
	include 'php/config.php';
	
	$bill_id	=	$_REQUEST['id'];
	//echo "reached here";
	$sql="SELECT b.id,c.id as cust_id,c.name,c.location,c.contact,c.email,b.BoP,b.date,b.file,b.samount as amount,b.sfine as fine,b.sweight,b.sbill FROM bills b,customers c where b.customer_id = c.id and b.id=$bill_id";
	
	$ret = array();
	$result = mysqli_query($connection, $sql);
	if (mysqli_num_rows($result) > 0) {
		
		while($row = mysqli_fetch_assoc($result)) {
			$ret= $row;
		}
	}
	else {
		echo 0;
	}
	//echo "<pre>";
	$details = array();
	if($ret){
		$sql="SELECT * FROM detailed_bills where bill_id=$bill_id";
		
		$result = mysqli_query($connection, $sql);
		if (mysqli_num_rows($result) > 0) {
			
			while($row = mysqli_fetch_assoc($result)) {
				$details[] = $row;
			}
		}
		else {
			echo 0;
		}
		
	}
	
	//print_r($ret);print_r($details);
	mysqli_close($connection);
}


?>

<!DOCTYPE html>
<html lang="en" class="app">
<head>
  <meta charset="utf-8" />
  <title>Prithvi Billing</title>
  <meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" /> 
  <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
  <link rel="stylesheet" href="css/animate.css" type="text/css" />
  <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="css/font.css" type="text/css" />
  <link rel="stylesheet" href="js/calendar/bootstrap_calendar.css" type="text/css" />
  <link rel="stylesheet" href="css/app.css" type="text/css" />
  
  <!--[if lt IE 9]>
    <script src="js/ie/html5shiv.js"></script>
    <script src="js/ie/respond.min.js"></script>
    <script src="js/ie/excanvas.js"></script>
  <![endif]-->
  
  <style>
  	.totals{
  		width:155px;
  		font-weight:bold;
  		text-align:left;
  	}
  
  </style>
</head>
<body>
  <section class="vbox">
	<?php include("header.php");?>
    <section>
      <section class="hbox stretch">
        <?php include("leftmenu.php");?>
        <!-- /.aside -->
        
        
        
        <section id="content">
           <section class="vbox" style="margin-top:-50px;font-size:10px !important;">
            <section class="scrollable padder">
             <section class="panel panel-default"-->
                
                
               <div class="row" id="extras1" align="center"><img src="images/shree.png" width="25px" height="25px"/></div>
			   <div class="row" id="extras2" align="center"><label>Estimate</label></div> 
              <div class="row" id="billTable">
                <div class="col-sm-12" >
                  <section class="panel panel-default">
                    <table class="table table-striped m-b-none" style="overflow:hidden !important;">
                      <!--thead>
                        <tr>
                          <th>Name</th>
                          <th>Location</th>                    
                          <th>Phone Number</th>
                          <th>Bill No.</th>
                          <th>Date</th>
                        </tr>
                      </thead-->
                      <tbody>
                        <tr>                    
                          <td>
                            <?php echo 'Bill No:'.$ret['id'];?>
                          </td>
                          <td><?php echo $ret['name'].', '.$ret['location'];?></td>
                          <!--td>
                            <?php echo $ret['contact'];?>
                          </td-->
                          	<td>
                          	<?php 
								$date = date_format(date_create($ret['date']),"d-m-Y");
								echo $date;
							?>
                          	</td>
                        </tr>
              
                      </tbody>
                    </table>
                  </section>
                </div>
              </div>
             
                
                <div class="table-responsive" align="center">
                  <table class="table table-striped b-t b-light">
                    <thead>
                      <tr>
                        <th width="20">Sl.</th>
                        <th>Desc</th>
                        <th>Qty</th>
                        <th>MC</th>
                        <th>Charge</th>
                        <th>Rate</th>
                        <th>Fine</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    	for($i=0;$i<count($details);$i++){
                    	    
                    	echo "

								 <tr>
			                        <td>".($i+1).".</td>
			                        <td>".$details[$i]['desc']."</td>
			                        <td>".$details[$i]['qty']."".strtolower($details[$i]['qty_type'])."</td>
			                        <td>".$details[$i]['mc']."</td>
			                        <td>".$details[$i]['charge']."</td>
			                        <td>".$details[$i]['rate']."</td>
			                        <td>".$details[$i]['fine']."</td>
			                        <td>".$details[$i]['amount']."</td>
			                      </tr>



							";
                    }
                    ?>
                    </tbody>
                  </table>
                </div>
               
              	<br>
                <div class="row" style="float: right">
                <div class="col-sm-12" >
                  <section class="panel panel-default">
                    <table class="table table-striped m-b-none">
                      <thead>
                        <tr>                   
                          <th></th>
                          <th>Fine</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                        <td class="totals">Total</td>                    
                          <td class="totals" id="fine"><?php echo $ret['fine']?></td>
                          <td class="totals" id="amount"><?php echo $ret['amount']?> </td>
                         
                        </tr>
              			<tr>
                        <td class="totals">Previous Balance</td>                    
                          <td class="totals" id="oldFine">Fine</td>
                          <td class="totals" id="oldAmt">Amount </td>
                         
                        </tr>
                        <tr>
                        <td class="totals">Final Balance</td>                    
                          <td class="totals" id="finalFine">Fine</td>
                          <td class="totals" id="finalAmt">Amount </td>
                         
                        </tr>
                        
                      </tbody>
                    </table>
                  </section>
                </div>
              </div>
              
              
              
            </section>
               <div class="row">
             
            <a href="" id="whatsapp" target="_new"  class="btn btn-success whatsapp"><i style="margin-right: 2px;"  class="fa fa-whatsapp"></i>Whatsapp 	</a>
            <a href="" id="print" target="_new" class="btn btn-success print"><i style="margin-left: 2px;" class="fa fa-print"></i>Print</a>
          
               
               </div>
            </section>
          <a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
        </section>
                     
        
        
      </section> </section>
    </section>
  </section>
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.js"></script>
  
  
<script src="src/js/defaultAction.js"></script>
<script src="src/js/Home.js"></script>

<script src="src/js/AddBill.js"></script>
  
  
  <!-- App -->
  <script src="js/app.js"></script>
  <script src="js/app.plugin.js"></script>
  <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/charts/easypiechart/jquery.easy-pie-chart.js"></script>
  <script src="js/charts/sparkline/jquery.sparkline.min.js"></script>
  <script src="js/charts/flot/jquery.flot.min.js"></script>
  <script src="js/charts/flot/jquery.flot.tooltip.min.js"></script>
  <script src="js/charts/flot/jquery.flot.resize.js"></script>
  <script src="js/charts/flot/jquery.flot.grow.js"></script>

<!-- fuelux -->
<script src="js/fuelux/fuelux.js"></script>
<!-- datepicker -->
<script src="js/datepicker/bootstrap-datepicker.js"></script>
<!-- slider -->
<script src="js/slider/bootstrap-slider.js"></script>
<!-- file input -->  
<script src="js/file-input/bootstrap-filestyle.min.js"></script>
<!-- combodate -->
<script src="js/libs/moment.min.js"></script>
<script src="js/combodate/combodate.js"></script>
<!-- select2 -->
<script src="js/select2/select2.min.js"></script>
<!-- wysiwyg -->
<script src="js/wysiwyg/jquery.hotkeys.js"></script>
<script src="js/wysiwyg/bootstrap-wysiwyg.js"></script>
<!-- markdown -->
  <script src="js/calendar/bootstrap_calendar.js"></script>

  <script src="js/sortable/jquery.sortable.js"></script>
<script>
 num =1;
	$(document).ready(function(){

		$.ajax({
            type: "GET",
            url: "php/get_old_balance.php?table=bills&condition=customer_id=" + <?php echo $ret["cust_id"]?>,
            success: function (response) {
                response = JSON.parse(response);
                console.log(response);
                $("#oldFine").html(response.sfine - <?php echo $ret['fine'];?>);
                $("#oldAmt").html(response.samount - <?php echo $ret['amount'];?>);
                 $("#finalFine").html(response.sfine+parseInt($("#fine").html()));
                $("#finalAmt").html(response.samount+parseInt($("#amount").html()));


                var data = "Date: <?php echo $ret['date']?> ; Bill no: <?php echo $ret['id']?> \n Fine: <?php echo $ret['fine']?> ; Amount: <?php echo $ret['amount']?>\n\nPrevious Bal:\nFine:  "+$("#oldFine").html()+" ; Amount: "+$("#oldAmt").html()+"\n\nFinal Balance:\nFine: "+ $("#finalFine").html() + " ; Amount: "+ $("#finalAmt").html();
                $(".whatsapp").attr('href','https://api.whatsapp.com/send?phone=+919845357010&text='+encodeURIComponent(data));
            }
        });

		$(".print").click(function(){
			
			$('.print,.whatsapp').hide();
			window.print();
			$('.print,.whatsapp').show();
		});
	});


</script>
</body>
</html>