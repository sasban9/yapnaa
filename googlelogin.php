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
//print_r($_GET);die;
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	$name = $_GET['name'];	
	$googleId= $_GET['id'];
	 $query=mysqli_query(connection(), "select * from users where user_social_id='$googleId'");
	 while ($row = mysqli_fetch_array($query)){
			$_SESSION['name']=$row['user_name'];
			$_SESSION['user_id']=$row['user_id'];
	 }
	$googleEmail= $_GET['email'];
    global $return;
	
    if (insertIntoDatabase($name,$googleId,$googleEmail)) {
        //return "Data inserted successfully!";
        echo json_encode($return);
    } else {
        echo json_encode($return);
    }
}
function insertIntoDatabase($name,$googleId,$googleEmail) {
    // Function that inserts username, password and email defined by user into database
    global $return;
    //Connect to a database
    //include 'includes/database.php';
    // Sanitize inputs
	 $sql1 = "select * from users where user_social_id='$googleId'";
	 $data=mysqli_query(connection(), $sql1);
	 //print_r($data['num_rows']);
   if( $data->num_rows==0){
    //Insert fields into database
    $sql = "INSERT INTO users (user_name,user_social_id,user_email_id,user_login_type) VALUES ('$name','$googleId','$googleEmail',2)";
  (mysqli_query(connection(), $sql)); 
      
	
   }
    // close connection
    mysqli_close($con);
} 
?>