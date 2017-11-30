<?php
class model {
	
	function __Construct()
	{
		require_once("config/config.php");
	}
	
	
	/* Update the data based on specified table name and columns */
    function update($table,$set_array,$condition)
	{
		
		if (count($set_array) > 0) {
			foreach($set_array as $key=>$value){
					$key	=	"`".$key."`";
					$value = "'$value'";
					$updates[] = "$key = $value";
			}
		}
		$set 		= implode(', ', $updates);
		//$table		=	"` $table`";
		$sql="UPDATE $table SET $set WHERE $condition"; 
		// echo $sql;exit;
		unset($set);
		$qry	=	connection()->query($sql);
		return $qry;
		
	}
	
	
	
	function admin_login_val($admin_email_id,$admin_password)
	{
		/* $sql	=	"
		SELECT *
		FROM admin_login
		WHERE admin_email_id='$admin_email_id' AND admin_password='$admin_password'"; */
		$sql	="SELECT al.*,ar.ar_role_name,ar.ar_id 
		FROM admin_login al left join admin_role ar on ar.ar_id=al.admin_role_id
		WHERE al.admin_email_id =  '$admin_email_id'
		AND al.admin_password =  '$admin_password'";
		//echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		if(!empty($qry)){
			while($row=mysqli_fetch_assoc($qry)){
					$ret[]=$row;
				}
			//	print_r($ret);
			return $ret;
		}
	}
	
}