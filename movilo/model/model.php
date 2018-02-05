<?php
class model {

	function __Construct()
	{
		//parent::__construct();
		if(isset($_POST['value']))
		{
			$url_config	=	'config/config.php';
		}else{
			$url_config	=	'config/config.php';
		}
			require_once(__DIR__.'/../'.$url_config);
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
	
	
	
		/* To get data based on conditions and specified fields with Order By  Asc*/
	function get_details_condition_orderby_asc($table,$fields,$condition,$orderby)
	{
		$sql = "SELECT $fields FROM $table where $condition order by $orderby asc";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	
		/* To get data based on conditions and specified fields with Order By  Asc*/
	function get_banner_images($table,$fields,$condition,$orderby)
	{
		$sql = "SELECT $fields FROM $table where $condition order by $orderby asc limit 10";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	/* To get All data*/
	function get_Detail_all_order_by($table_name,$order_by)
	{
		$sql		=	"SELECT * FROM $table_name order by $order_by asc";
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
		//echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
		
	/* To get data based on conditions and specified fields */
	function get_Details_condition_order_by($table,$fields,$condition,$order_by)
	{
		$sql = "SELECT $fields FROM $table where $condition order by $order_by asc";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	/* Delete Row */
	function delete_row_data($table,$condition)
	{
		$sql = "DELETE FROM $table where $condition";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);		
		return $qry;
	}
	
	
	
	
	/* To get data based on conditions and specified fields */
	function user_srm_question_list($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table where $condition limit 10";
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
	
	
	
	
	/* To get data get_sub_category_list */
	function brand_product_list_by_category($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table as bp join brands as b on b.brand_id  =	bp.product_brand_id join product_category_list as pcl on pcl.p_category_id = bp.product_name  where $condition";
		
		
		// $sql = "SELECT $fields FROM $table where $condition";
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
	
	
	
	
	/* To get data get_sub_category_list */
	function user_product_list($table,$fields,$condition)
	{
		$sql = "SELECT CONCAT_WS(' ', `up_title`, `p_category_name`) AS product_title, up.* ,pcl.*, b.* FROM $table as up join brand_products as bp on bp.product_id = up.up_product_id JOIN product_category_list as pcl on pcl.p_category_id = bp.product_name join brands as b on b.brand_id = bp.product_brand_id where $condition";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	
	/* To get data get_sub_category_list */
	function user_srm_list($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table as srm join brand_products as bp on bp.product_id  =	srm.srm_product_id join product_category_list as pcl on pcl.p_category_id = bp.product_name  join brands as b on b.brand_id = bp.product_brand_id where $condition order by srm_id desc";
		
		
		// $sql = "SELECT $fields FROM $table where $condition";
		//echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	
	
	/* To get data get_sub_category_list */
	function product_list_depends_brand($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table as bp   join product_category_list as pcl on pcl.p_category_id = bp.product_name  join brands as b on b.brand_id = bp.product_brand_id where $condition"; 
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	
	/* To get data get_sub_category_list */
	function srm_details_particular_product($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table  as s   join brand_products as bp on bp.product_id = s.srm_product_id join product_category_list as pcl on pcl.p_category_id = bp.product_name  join brands as b on b.brand_id = bp.product_brand_id where $condition";  

		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	
		
		/*Get get_amc_price_list Details   */
	function get_amc_price_list($amc_price_table, $fields, $condition)
	{	
			$sql = "SELECT * 
				FROM $amc_price_table as amcprice JOIN brands as b ON amcprice.amc_price_brand_id	=	b.brand_id   join product_category_list as pcl on pcl.p_category_id = amcprice.amc_price_brand_name WHERE $condition";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
}