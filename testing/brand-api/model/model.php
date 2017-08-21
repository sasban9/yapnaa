<?php
class model {

	function __Construct()
	{	if(isset($_POST['value']))
		{
			$url_config	=	'../config/config.php';
		}else{
			$url_config	=	'config/config.php';
		}
			require_once($url_config);
	}
	
	
	
	function insert($table,$arr_input)
	{

		$values	= array_values($arr_input);
		$keys	=	array_keys($arr_input);
		$fieldlist	= "`".implode("`,`",$keys)."`";
		$values	= "'".implode("','",$values)."'";	
		//$table	=	"` $table`";
		 $sql	=	"INSERT INTO $table ($fieldlist) VALUES ($values)";	
		 // echo $sql; exit;
		$con =	connection();
		$result	= mysqli_query($con,$sql) or die(mysqli_error($con));
		$id = mysqli_insert_id($con);
		//echo $result;exit;
		//echo $id;exit;
		unset($fieldlist, $values);
		if ($result)
		return $id;
		else 
		return FALSE; 

		mysqli_free_result($result);
		$con->close();
	}
	
	
	/* To get All data*/
	function get_Detail_all($table_name)
	{
		$sql		=	"SELECT * FROM $table_name";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	/* To get data based on conditions and specified fields */
	function get_Details_condition($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table where $condition";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	
	
	/* To get data get_sub_category_list */
	function brand_product_list($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table as bp join brands as b on bp.product_brand_id = b.brand_id  where $condition";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	
	
	
	/* To get data user wish list details*/
	function get_user_wish_list_details($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table as wl join jewelery_products as j on j.jewelery_products_id=wl.wish_list_p_id join main_category as mc on j.jewelery_products_ref_main_id=mc.main_category_id where $condition";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	
	
	
	/* To get data get_sub_category_list */
	function get_sub_category_list($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table as sc join main_category as mc on mc.main_category_id = sc.sub_category_ref_main_id  where $condition";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	//Update data
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
	
}