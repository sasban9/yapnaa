

<?php

$servername = "localhost";
$username = "yapnaa-blogs";
$password = "yusuf@Bl0g$";
$dbname = "yapnaa-blogs";


    $phone 		= $_POST['phone'];
	
    $brandname 		= $_POST['brandname'];
	$product_type   = $_POST['product_type'];

	$description 		= $_POST['description'];
	
	

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO enquires (mobileNo, brandName, productType, description)
VALUES ('$phone' , '$brandname', '$product_type', '$description' )";

if ($conn->query($sql) === TRUE) {
    //echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();




	
	 $ToEmail = 'yusuf.jjbytes@gmail.com';
	  $Message = '<html><body style="font-family: century Gothic;font-size:14px;">'
                
                . '<table border="1" style="font-family: century Gothic;font-size:12px;border: 1px solid grey;"><tr>' 
                . '<td style="width:200px;border: 1px solid grey;padding:2px;">Phone </td><td style="border: 1px solid grey;max-width:600px;padding:2px;">' . $phone
                . '</td></tr><tr><td style="width:200px;border: 1px solid grey;padding:2px;">Brand Name: </td><td style="border: 1px solid grey;max-width:600px;padding:2px;">' . $brandname
                . '</td></tr><tr><td style="width:200px;border: 1px solid grey;padding:2px;">Product Type: </td><td style="border: 1px solid grey;max-width:600px;padding:2px;">' . $product_type
                . '</td></tr><tr><td style="width:200px;border: 1px solid grey;padding:2px;">Description: </td><td style="border: 1px solid grey;max-width:600px;padding:2px;">' . $description
                . '</td></tr>
				
				
				
				
				
				
				
				
				
				
				
				
				
				</table>'
                
                . '</body></html>';
        $Subject = " Website-Contact";
        $headers1 = "MIME-Version: 1.0" . "\r\n";

        $headers1 .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";

        $headers1 .= "From:$email\r\n";


        $mime_boundary = "==Multipart_Boundary_x" . md5(mt_rand()) . "x";

        $headers = "From:$email\r\n" .
                "MIME-Version: 1.0\r\n" .
                "Content-Type: multipart/mixed;\r\n" .
                " boundary=\"{$mime_boundary}\"";

        $Message = "This is a multi-part message in MIME format.\n\n" .
                "--{$mime_boundary}\n" .
                "Content-type:text/html;charset=iso-8859-1" . "\r\n" .
                "Content-Transfer-Encoding: 7bit\n\n" .
                $Message . "\n\n";
 

        $mime_boundary = "==Multipart_Boundary_x" . md5(mt_rand()) . "x";

        $head = "From:info@yapna.com\r\n" .
             
                "MIME-Version: 1.0\r\n" .
                "Content-Type: multipart/mixed;\r\n" .
                " boundary=\"{$mime_boundary}\"";

        $msgs = "This is a multi-part message in MIME format.\n\n" .
                "--{$mime_boundary}\n" .
                "Content-type:text/html;charset=iso-8859-1" . "\r\n" .
                "Content-Transfer-Encoding: 7bit\n\n" .
                $msgs . "\n\n";
			 if (mail($ToEmail, $Subject, $Message, $headers)) {
            if (mail($to, $sub1, $msgs, $head)) {
			
			
			echo '<script>alert("Thank you for contacting Vikram Hospital Website\n\n One of our representative will be in touch with you shortly based on the message you have shared.")</script>';
			echo '<script>window.location.assign("http://yapnaa.com/blogs")</script>';
			}else{
			echo '<script>alert("Thank you for contacting us\n\n One of our representative will be in touch with you with in 24 hours")</script>';
			echo '<script>window.location.assign("http://yapnaa.com/")</script>';
		
			
			}
			}




?>