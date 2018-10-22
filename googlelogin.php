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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$googleEmail	= $_POST['email'];
	$name 			= $_POST['name'];	
	$googleId		= $_POST['user_id'];
	
	$query			= mysqli_query(connection(), "select * from users where user_social_id='$googleId'");
	$row 			= mysqli_fetch_array($query);
	
	if(!empty($row)){
		$_SESSION['name']	= $row['user_name'];
		$_SESSION['user_id']= $row['user_id'];
		$response 			= array('status' => true);
		echo json_encode($response);
	}
	else{
		$response   		= insertIntoDatabase($name,$googleId,$googleEmail);
		$response 			= array('status' => true);
		echo json_encode($response);
	}
		
	/* while ($row = mysqli_fetch_array($query)){
		$_SESSION['name']	= $row['user_name'];
		$_SESSION['user_id']= $row['user_id'];
	}
    //global $return;
    if(insertIntoDatabase($name,$googleId,$googleEmail)) {
        echo json_encode($return);
    } else {
        echo json_encode($return);
    } */
	
}

function insertIntoDatabase($name,$googleId,$googleEmail) {
    //global $return;
	$created_date 	= date('Y-m-d H:i:s');
	$sql1 			= "select * from users where user_social_id='$googleId'";
	$data			= mysqli_query(connection(), $sql1);
	
	if( $data->num_rows==0){
		$sql = "INSERT INTO users (user_name,user_social_id,user_email_id,user_login_type,user_created_date) VALUES ('$name','$googleId','$googleEmail',2,'$created_date')";
		$response  = (mysqli_query(connection(), $sql));
    }
	return $response;
    mysqli_close($con);
} 


?>