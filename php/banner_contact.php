	<?php
		
	include('config/config.php');
	
	if(isset($_POST['name'])){
	
	$name = $_POST['name'];
	$email  = $_POST['email'];
	$phone  = $_POST['phone'];
	
	$sql="INSERT INTO `banner_contact`(`name`, `email`, `phone`)
		VALUES ('$name', '$email', '$phone')";
	
	//echo $sql;
		
	$res=mysqli_query($conn,$sql);
	//echo $res;
	if($res){ 
			if (isset($_REQUEST['email']))  {

			$admin_email = "jitesh@jjbytes.com";
			$email       = $_REQUEST['email'];
			$subject     = 'Filled on Yapnaa Banner';
			$message     = "Name 	: $name

			Phone	: $phone

			Email	: $email

			Subject : $subject_user";

			//send email

			mail($admin_email, "$subject", $message, "From:" . $email);

			$message1 = "Thanks for making a request to us, we will contact you soon";

			//user

			mail($email, "$subject", $message1, "From:" . $email);

			}
		echo "1" ;
		}
		else{ 
			echo "0";
		}	
	}
?>