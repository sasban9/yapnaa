<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
if(isset($_SESSION['ad_email_id']))
{
	require_once("header.php"); 
   $admin_email_id  = $_SESSION['ad_email_id'];
   $admin_name    = $_SESSION['admin_name'];
   $admin_last_login  = $_SESSION['admin_last_login'];

  //require_once('controller/admin_controller.php');
  //$control  = new admin();
  
	$control  = $admin_controller;

  $get_user_list = $control->get_user_list();
  
    /*if(isset($_POST['mail'])){
           //print_r($_POST['select_user']);

          $subject = isset($_POST['user_subject']) ? $_POST['user_subject'] : '' ;
          $message = isset($_POST['user_message']) ? $_POST['user_subject'] : '';
          $user_list = isset($_POST['select_user']) ? $_POST['select_user'] : '';
          if(!empty($subject) && !empty($message) && !empty($user_list)){
              $get_user_list1 = $control->get_user_mail($user_list,$subject,$message);
          }  
      }*/

      if(isset($_POST['notification'])){
          $subject = isset($_POST['user_subject']) ? $_POST['user_subject'] : '' ;
          $message = isset($_POST['user_message']) ? $_POST['user_message'] : ''; 
          $user_list = isset($_POST['select_user']) ? $_POST['select_user'] : '';

          if($subject && $message && $user_list){
              $get_user_list1 = $control->sent_noti_user($user_list,$message,$subject);
			  if($get_user_list1 == false){
				  echo "<script>alert('There was a problem in sending one or more notifications.');</script>";
			  }
			  else{
				  echo "<script>alert('Notification sent succesfully.');</script>";
			  }
          }
        
      }

     /* if(isset($_POST['sms'])){
          $user_list = isset($_POST['select_user']) ? $_POST['select_user'] : '';
          $subject = isset($_POST['user_subject']) ? $_POST['user_subject'] : '' ;
          $message = isset($_POST['user_message']) ? $_POST['user_message'] : '';

          if($subject && $message && $user_list){
              $get_user_list1 = $control->get_user_sms($user_list,$subject,$message);
          }


          
      }*/
?>
<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:49:42 GMT -->
<!--head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>NoQ | Dashboard</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <link href="js/plugins/gritter/jquery.gritter.css" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="css/bootstrap-multiselect.css" type="text/css">  

</head-->

<body>
    <div id="wrapper"> 

        </div>

    <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>User List</h2>
                    <ol class="breadcrumb">
                        <li>
                            <a href="index.php">Home</a>
                        </li>
                        <li class="active">
                            <strong>User List</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">

                </div>
            </div>
            
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                    <!------------------------------------------>
                    <form id="form" method="POST" enctype="multipart/form-data">
                        <fieldset class="form-horizontal">

                            <div class="form-group">
                                <label class="col-sm-2 control-label">TO: </label>
                                <div class="col-sm-10">
                                <!--<input type="text" class="form-control" name="select_user" id="select_user" placeholder="Select User"   data-required="true">    
                                -->
                                 <select class="form-control select_user" name="select_user[]"  id="example-enableClickableOptGroups-disabled" multiple="multiple" required>
                                    <?php
                                      for($i=0;$i<count($get_user_list);$i++)
                                      {
                                          if( !empty($get_user_list[$i]['user_first_name']) && !empty($get_user_list[$i]['user_email_id'])){
                  
                                               echo "<option value='".$get_user_list[$i]['user_gcm_id']."'>".$get_user_list[$i]['user_first_name']."</option>";
                              
                                          }
                                      }
                                     ?>
                                </select>

                                </div>
                            </div>


                            
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Subject:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="user_subject" id="user_subject" required>    
                                 </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-2 control-label">Message:</label>
                                <div class="col-sm-10">
                                <textarea id="user_message" name="user_message" class="form-control" required></textarea>
                                </div>
                            </div>

                            <!--div class="form-group">
                                <label class="col-sm-2 control-label">type:</label>
                                <div class="col-sm-10">
                                <textarea id="user_message" name="type" class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">id:</label>
                                <div class="col-sm-10">
                                <textarea id="user_message" name="id" class="form-control" required></textarea>
                                </div>
                            </div-->
                            <div class="form-group">
                                <div class="col-sm-2 control-label"><input id="notification"  type="submit" name="notification" class="btn btn-info pull-right"  value="Send Notification" onclick="myFunction()"></div>
                            </div>
                          </fieldset>
                      </form>
 <!------------------------------------------>
                    </div>
                </div>
            </div>
            </div>
        </div>
        

               
<?php include "footer.php";?>

    <!-- Mainly scripts -->
    <script src="js/jquery-2.1.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/plugins/jeditable/jquery.jeditable.js"></script>

    <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <script>
      function myFunction() {
  
          var user_email = $(".select_user").val();
          if ($.trim(user_email) == '')
          {
              alert("Please Select Email id");
              $('.select_user').val('');
              $('.select_user').focus();
               return false;
          }
        

          var user_subject = $("#user_subject").val();
          if ($.trim(user_subject) == '')
          {
              alert("Please Enter the subject");
              $('#user_subject').val('');
              $('#user_subject').focus();
               return false;
          }

          var user_message = $("#user_message").val();
          if ($.trim(user_message) === '')
          {
          alert("Please Enter the Message.");
          $('#user_message').val('');
          $('#user_message').focus();
           return false;
          }

      }

    </script>

   <!---------------------------->
   

      
        <script type="text/javascript" src="js/bootstrap-3.3.2.min.js"></script>

      
        <script type="text/javascript" src="js/bootstrap-multiselect.js"></script>


   <!---------------------------->
    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function() {
            $('.dataTables-example').dataTable({
                responsive: true,
                "tableTools": {
                    "sSwfPath": "js/plugins/dataTables/swf/copy_csv_xls_pdf.swf"
                }
            });


        });


    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#example-enableClickableOptGroups-disabled').multiselect({
                enableClickableOptGroups: true,
                enableCollapsibleOptGroups: true,
                enableFiltering: true,
                includeSelectAllOption: true
            });
        });
    </script>

   
</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.0/table_data_tables.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 24 Apr 2015 10:53:35 GMT -->
</html>

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
