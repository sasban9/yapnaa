<?php 
global $tb;
/* database connection */
	function connection(){
		
		
		// $servername = "localhost";//host name 
		// $username 	= "movilogl_NoQ"; //user name
		// $password 	= "adminNoQ123";   //user password
		// $database	= "movilogl_NoQ"; //db name
	 
	 
		$servername = "localhost";//host name 
		$username 	= "root"; //user name
		$password 	= "M0v!Lo@987";    //user password
		$database	= "movilogl_NoQ"; //db name
		
		
		
		
		// Create connection
		$con = new mysqli($servername, $username, $password, $database);

		// Check connection
		if ($con->connect_error) {
			die("Connection failed: " . $con->connect_error);
		}
		return $con;
	}
	
	 
?>