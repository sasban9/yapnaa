<?php
	$dbhost = 'localhost';
	$dbuser = 'root';
	$dbpass = 'M0v!Lo@987';
	$dbname = 'movilogl_movilo';
   
    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
   
	   if(! $conn ) {
		  die('Could not connect: ' . mysqli_error());
	   }
	   else{
			// echo "conn";
	   }
?>