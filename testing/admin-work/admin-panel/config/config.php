<?php 
global $tb;
/* database connection */
	function connection(){
		$servername = "localhost";//host name 
		$username 	= "root"; //user name
		$password 	= "yapnaa";    //user password
		$database	= "movilogl_movilo"; //db name
		// Create connection
		$con = new mysqli($servername, $username, $password, $database);

		// Check connection
		if ($con->connect_error) {
			die("Connection failed: " . $con->connect_error);
		}
		return $con;
	}
	
	
				
				
	/* Base URL $arr_data[0] is having server name and $arr_data[1] have folder name*/
	$url=$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$arr_data   =   explode("/",$url);
	$base_url	= $arr_data[0]."/".$arr_data[1]."/".$arr_data[2]."/"; 
	
?>