	<?php
	
	include('config/config.php');
	
	if(isset($_POST['subs_name'])){
	
	$name = $_POST['subs_name'];
	$email  = $_POST['subs_email'];
	
	
	$sql="INSERT INTO `subs_newsletter`(`subs_name`, `subs_email`)
		VALUES ('$name', '$email')";
	
	//echo $sql;
		
	$res=mysqli_query($conn,$sql);
	 
	if($res){ 
		echo "1" ;
			}
		else{ 
			echo "0";
			}	
	}

?>