	<?php
		
	include('config/config.php');
	//echo "came here";
	if(isset($_POST['name'])){
	
	$name = $_POST['name'];
	$email  = $_POST['email'];
	$phone  = $_POST['phone'];
	$subject  = $_POST['subject'];
	$comment  = $_POST['comments'];
	
	
	$sql="INSERT INTO `data`(`name`, `email`, `phone`,`subject`, `comment`)
		VALUES ('$name', '$email', '$phone','$subject', '$comment')";
	
	//echo $sql;
		
	$res=mysqli_query($conn,$sql);
	 
	if($res){ 
			if (isset($_REQUEST['email']))  {

			$admin_email = "vineet@moviloglobal.com,kapil@jjbytes.com,jitesh@jjbytes.com,faizan.jjbytes@gmail.com,sriramm@moviloglobal.com";
			$email       = $_REQUEST['email'];
			$subject     = 'Form filled on Yapnaa';
			$message     = "Name 	: $name

Phone	: $phone

Email	: $email

Subject : $subject

Comment : $comment";

			//send email

			mail($admin_email, "$subject", $message, "From:" . $email);

			$message1     = "Thanks for making a request to us, we will contact you soon";

			//user

			mail($email, "$subject", $message1, "From:" . $admin_email);

			}
		echo "1" ;
			}
		else{ 
			echo "0";
			}	
	}
?>