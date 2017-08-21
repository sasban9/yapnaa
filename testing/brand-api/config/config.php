<?php 
/* database connection */
	function connection(){
		$servername = "localhost";//host name 
		$username 	= "automobi_b_user"; //user name
		$password 	= "JJbytes@123";    //user password
		$database	= "automobi_brand"; //db name
		// Create connection
		$con = new mysqli($servername, $username, $password, $database);

		// Check connection
		if ($con->connect_error) {
			die("Connection failed: " . $con->connect_error);
		}
		return $con;
	}
	

?>