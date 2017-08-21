<?php
 
   phpinfo();
  
      $ToEmail = 'vajidattar.jjbytes@gmail.com';
      $EmailSubject = 'Site contact form '; 
      $mailheader = "From: admin@gmail.com\r\n";   
      $mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
      $MESSAGE_BODY = "Name: Vajid<br>"; 
      $MESSAGE_BODY .= "Email: v@gmail.com<br>";  
      if(mail($ToEmail, $EmailSubject, $MESSAGE_BODY, $mailheader))
      {
      echo "<script>alert('Mail was sent !');</script>"; 
      }
      else
      {
      echo "<script>alert('Mail was not sent. Please try again later');</script>";
      } 
	 
	  
?>