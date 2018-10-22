<?php 
session_start();
function connection(){
	$servername = "localhost";//host name 
	$username 	= "root"; //user name
	$password 	= "M0v!Lo@987";    //user password
	$database	= "movilogl_movilo"; //db name
	// Create connection
	 $con = new mysqli($servername, $username, $password, $database);

	// Check connection
	if ($con->connect_error) {
		die("Connection failed: " . $con->connect_error);
	}
	
	 return $con;
} 

//print_r($_POST);die;


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$facebookEmail	= $_POST['email'];
	$name 			= $_POST['name'];	
	$facebookId		= $_POST['user_id'];
	
	$query			= mysqli_query(connection(), "select * from users where user_social_id='$facebookId'");
	$row 			= mysqli_fetch_array($query);
	
	if(!empty($row)){
		$_SESSION['name']	= $row['user_name'];
		$_SESSION['user_id']= $row['user_id'];
		$response 			= array('status' => true);
		echo json_encode($response);
	}
	else{
		$response   		= insertIntoDatabase($name,$facebookId,$facebookEmail);
		$response 			= array('status' => true);
		echo json_encode($response);
	}
	
}

function insertIntoDatabase($name,$facebookId,$facebookEmail) {
    //global $return;
	$created_date 	= date('Y-m-d H:i:s');
	$sql1 			= "select * from users where user_social_id='$facebookId'";
	$data			= mysqli_query(connection(), $sql1);
	
	if( $data->num_rows==0){
		$sql = "INSERT INTO users (user_name,user_social_id,user_email_id,user_login_type,user_created_date) VALUES ('$name','$facebookId','$facebookEmail',2,'$created_date')";
		$response  = (mysqli_query(connection(), $sql));
    }
	return $response;
    mysqli_close($con);
} 



?>