
  <script src="js/jquery.min.js"></script>
  <!-- Bootstrap -->
  <script src="js/bootstrap.js"></script>
  <!-- App -->
  <script src="js/app.js"></script>
  <script src="js/app.plugin.js"></script>
  <script src="js/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="js/charts/easypiechart/jquery.easy-pie-chart.js"></script>sparkline

    <!-- Custom and plugin javascript -->
    <script src="js/inspinia.js"></script>
    <script src="js/plugins/pace/pace.min.js"></script>
    <!-- jQuery UI -->
    <script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- GITTER -->
    <script src="js/plugins/gritter/jquery.gritter.min.js"></script>	
  <script src="js/charts/sparkline/jquery.sparkline.min.js"></script>
  <script src="js/charts/flot/jquery.flot.min.js"></script>
  <script src="js/charts/flot/jquery.flot.tooltip.min.js"></script>
  <script src="js/charts/flot/jquery.flot.resize.js"></script>
  <script src="js/charts/flot/jquery.flot.grow.js"></script>
  <script src="js/charts/flot/demo.js"></script>

  
    <!-- Peity -->
    <script src="js/plugins/peity/jquery.peity.min.js"></script>
    <script src="js/demo/peity-demo.js"></script>
  <script src="js/calendar/bootstrap_calendar.js"></script>
  <script src="js/calendar/demo.js"></script>

    <!-- Sparkline demo data  -->
    <script src="js/demo/sparkline-demo.js"></script>
  <script src="js/sortable/jquery.sortable.js"></script>
	<!-- ChartJS-->
    <script src="js/plugins/chartJs/Chart.min.js"></script>
  <!-- datatables -->
  <script src="js/datatables/jquery.dataTables.min.js"></script>
  
 <!-- Form validation -->
 <script src="js/parsley/parsley.min.js"></script>
 <script src="js/parsley/parsley.extend.js"></script>
 <!-- file input -->  
 <script src="js/file-input/bootstrap-filestyle.min.js"></script>

 
    <!-- Toastr -->
    <script src="js/plugins/toastr/toastr.min.js"></script>
 <!-- data Table Working -->
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
  
      <!-- Data Tables -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <script src="js/plugins/dataTables/dataTables.responsive.js"></script>
    <script src="js/plugins/dataTables/dataTables.tableTools.min.js"></script>

    <script src="js/plugins/peity/jquery.peity.min.js"></script>

  <script>
$(document).ready(function(){
    $('#mc_table').DataTable();
});
</script>
 
<script> 
var _validFileExtensions = [".jpg",".png",".gif",".jpeg"];
var _validFileExtensions1 = ["*.jpg","*.png","*.gif","*.jpeg"];    
function validate_image(oInput) {
	if (oInput.type == "file") {
	var size = oInput.files[0].size;
		if(size >= 5242880)
				{
				alert("The File Size Is More Than 5MB. Please Choose A File Of Size 5MB or Less.");
				oInput.value = "";
				}
		var sFileName = oInput.value;
		 if (sFileName.length > 0) {
			var blnValid = false;
			for (var j = 0; j < _validFileExtensions.length; j++) {
				var sCurExtension = _validFileExtensions[j];
				if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
					blnValid = true;
					break;
				}
			}
			 
			if (!blnValid) {
				alert("Sorry, " + sFileName + " file type is invalid. Allowed extensions are: " + _validFileExtensions1.join(", "));
				oInput.value = "";
				return false;
			}
		}
	}
	return true;
}
</script>
</body>
</html>