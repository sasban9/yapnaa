<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{	
error_reporting(E_ALL);  
//Header File
require_once("header.php"); 


 
/* Get Ticket List*/
$users_list	=	$admin_controller->users_list();  
// echo'<pre>';print_r($users_list);exit;

 
 
?>
      
        <section id="content">
          <section class="vbox">          
            <section class="scrollable padder">
              <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                <li class="active">Users List</li>
              </ul> 
				 <section class="panel panel-default" id="progressbar">
                    <header class="panel-heading"> 
                      <ul class="nav nav-tabs"> 
						<li class="active"><a href="#main-category-list" data-toggle="tab"><i class="fa fa-users text-default"></i> Users List</a></li>   
					  </ul> 
                    </header>  
					<div class="panel-body">
					  <div class="tab-content">          
						<div class="tab-pane fade active in" id="main-category-list"> 
							<section class="panel panel-default"> 
								<div class="table-responsive">
								  <table class="table table-striped m-b-none" id="mc_table">
									<thead>
									  <tr>
										<th width="15%">Sl.No</th>
										<th width="20%">User Name</th>
										<th width="25%">User Mobile No</th>  
										<th width="25%">Email</th>  
										<th width="20%">DOB</th>
										<th width="25%">Gender</th> 
										<th width="25%">Reg Date</th>
										<th width="25%">Details</th> 
									  </tr>
									</thead>
									<tbody>
									<?php $j=1;?>
									<?php for($i=0;$i<count($users_list);$i++){  ?>
										<tr>
											<td><?php echo  $j; ?></td> 
											<td><?php echo $users_list[$i]['user_first_name']." ".$users_list[$i]['user_last_name']; ?></td>  
											<td><?php echo $users_list[$i]['user_mobile_no']; ?></td>
											<td><?php echo $users_list[$i]['user_email_id']; ?></td> 
											<td><?php echo $users_list[$i]['user_dob']; ?></td>
											<td><?php echo $users_list[$i]['user_gender']; ?></td> 
											<td><?php echo $users_list[$i]['user_registration_date']; ?></td> 
										 	<td><a href="user_details.php?user_id=<?php echo $users_list[$i]['user_id']; ?>" target="_blank">View Details</td> 
										 </tr>
									<?php $j++; } ?>
									</tbody>
								  </table>
								</div>
							  </section>
						</div>  
						
						 
               </section>
            </section>
          </section> 
        </section>  
		
		
		
		
		 
      </section>
    </section>
  </section>

<?php include "footer.php";?>

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
