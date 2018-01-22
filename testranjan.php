<?php 
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
	$facebookId= $_GET['id'];
    global $return;
	
    if (insertIntoDatabase($name,$facebookId)) {
        //return "Data inserted successfully!";
        echo json_encode($return);
    } else {
        echo json_encode($return);
    }
}
function insertIntoDatabase($name,$facebookId) {
    // Function that inserts username, password and email defined by user into database
    global $return;
    //Connect to a database
    //include 'includes/database.php';
    // Sanitize inputs
	 $sql1 = "select * from users where user_social_id='$facebookId'";
   if((mysqli_query(connection(), $sql1))==NULL){
    //Insert fields into database
    $sql = "INSERT INTO users (user_name,user_social_id) VALUES ('$name','$facebookId')";
  (mysqli_query(connection(), $sql));
   }
    // close connection
    mysqli_close($con);
} 
?>