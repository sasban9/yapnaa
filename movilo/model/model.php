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
		//echo $sql;exit;
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
		
		/*$sql 	= " SELECT CONCAT_WS(' ', `up_title`, `p_category_name`) AS product_title,if(up.up_serial_no=NULL,up_serial_no,'No Data') AS up_serial_no,if(up.up_product_title=NULL,up_product_title,'No Data') AS up_product_title,if(up.up_serial_no_image=NULL,up_serial_no_image,'No Data') AS up_serial_no_image,if(up.up_dealer_name=NULL,up_dealer_name,'No Data') AS up_dealer_name,if(up.up_date_of_purchase=NULL,up_date_of_purchase,'No Data') AS up_date_of_purchase,if(up.up_location=NULL,up_location,'No Data') AS up_location,if(up_amc=NULL,up_amc,'No Data') AS up_amc,if(up.up_amc_from_date=NULL,up_amc_from_date,'No Data') AS up_amc_from_date,if(up.up_amc_to_date=NULL,up_amc_to_date,'No Data') AS up_amc_to_date,if(up.up_warranty_start_date=NULL,up_warranty_start_date,'No Data') AS up_warranty_start_date,if(up.up_warranty_end_date=NULL,up_warranty_end_date,'No Data') AS up_warranty_end_date,if(up.up_guarantee_start_date=NULL,up_guarantee_start_date,'No Data') AS up_guarantee_start_date,if(up.up_guarantee_end_date=NULL,up_guarantee_end_date,'No Data') AS up_guarantee_end_date,if(up.up_title=NULL,up_title,'No Data') AS up_title,if(up.up_additional_info=NULL,up_additional_info,'No Data') AS up_additional_info,if(up.up_invoice_no=NULL,up_invoice_no,'No Data') AS up_invoice_no,if(up.up_invoice_image=NULL,up_invoice_image,'No Data') AS up_invoice_image,if(up.up_location_id=NULL,up_location_id,'No Data') AS up_location_id,if(up.up_owner_invoice_copy=NULL,up_owner_invoice_copy,'No Data') AS up_owner_invoice_copy,if(up.up_owner_invoice_no=NULL,up_owner_invoice_no,'No Data') AS up_owner_invoice_no,if(up.up_owner_manual=NULL,up_owner_manual,'No Data') AS up_owner_manual,if(up.up_owner_guarantee_document=NULL,up_owner_guarantee_document,'No Data') AS up_owner_guarantee_document,if(up.up_owner_warranty_document=NULL,up_owner_warranty_document,'No Data') AS up_owner_warranty_document,if(up.up_owner_email=NULL,up_owner_email,'No Data') AS up_owner_email,if(up.up_owner_address=NULL,up_owner_address,'No Data') AS up_owner_address,if(up.up_owner_purchase_date=NULL,up_owner_purchase_date,'No Data') AS up_owner_purchase_date,if(up.up_owner_purchase_city=NULL,up_owner_purchase_city,'No Data') AS up_owner_purchase_city,if(up.up_owner_purchase_pincode=NULL,up_owner_purchase_pincode,'No Data') AS up_owner_purchase_pincode,if(up.up_owner_retailer_name=NULL,up_owner_retailer_name,'No Data') AS up_owner_retailer_name,if(up.up_owner_retailer_code=NULL,up_owner_retailer_code,'No Data') AS up_owner_retailer_code,if(up.up_owner_retailer_number=NULL,up_owner_retailer_number,'No Data') AS up_owner_retailer_number,
		if(up.up_owner_warranty_start_date=NULL,up_owner_warranty_start_date,'No Data') AS up_owner_warranty_start_date,
		if(up.up_owner_warranty_end_date=NULL,up_owner_warranty_end_date,'No Data') AS up_owner_warranty_end_date,	
		if(up.up_owner_guarantee_start_date=NULL,up_owner_guarantee_start_date,'No Data') AS up_owner_guarantee_start_date,
		if(up.up_owner_guarantee_end_date=NULL,up_owner_guarantee_end_date,'No Data') AS up_owner_guarantee_end_date,
		if(pcl.p_category_id=NULL,p_category_id,'No Data') AS p_category_id,
		if(pcl.p_category_name=NULL,p_category_name,'No Data') AS p_category_name,
		if(pcl.p_category_icon_small=NULL,p_category_icon_small,'No Data') AS p_category_icon_small,
		if(pcl.p_category_icon_medium=NULL,p_category_icon_medium,'No Data') AS p_category_icon_medium,
		if(pcl.p_category_priority=NULL,p_category_priority,'No Data') AS p_category_priority,
		if(pcl.p_category_c_date=NULL,p_category_c_date,'No Data') AS p_category_c_date,
		if(pcl.p_category_m_date=NULL,p_category_m_date,'No Data') AS p_category_m_date,
		if(pcl.p_category_status=NULL,p_category_status,'No Data') AS p_category_status,
		if(b.brand_id=NULL,brand_id,'No Data') AS brand_id,
		if(b.brand_name=NULL,brand_name,'No Data') AS brand_name,
		if(b.brand_icon=NULL,brand_icon,'No Data') AS brand_icon,
		if(b.brand_priority=NULL,brand_priority,'No Data') AS brand_priority,
		if(b.brand_created_date=NULL,brand_created_date,'No Data') AS brand_created_date,
		if(b.brand_modified_date=NULL,brand_modified_date,'No Data') AS brand_modified_date,
		if(b.brand_status=NULL,brand_status,'No Data') AS brand_status,
		if(b.customer_care_phone1=NULL,customer_care_phone1,'No Data') AS customer_care_phone1,
		if(b.customer_care_phone2=NULL,customer_care_phone2,'No Data') AS customer_care_phone2,
		if(b.customer_email_id=NULL,customer_email_id,'No Data') AS customer_email_id,
		if(b.brand_url=NULL,brand_url,'No Data') AS brand_url
		
		FROM $table as up join brand_products as bp on bp.product_id = up.up_product_id JOIN product_category_list as pcl on pcl.p_category_id = bp.product_name join brands as b on b.brand_id = bp.product_brand_id where $condition ";*/
		
		//echo $sql; die;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
			$ret[]=$row;
		}
		//print_r($ret); die;
		if(!empty($ret)){
			if($ret[0]['up_title'] == ''){
				$ret[0]['up_title'] 					= $ret[0]['product_title'];
				$ret[0]['up_amc_from_date']	 			= '0000-00-00 00:00:00';
				$ret[0]['up_amc_to_date'] 				= '0000-00-00 00:00:00';
				$ret[0]['up_warranty_start_date'] 		= '0000-00-00 00:00:00';
				$ret[0]['up_warranty_end_date'] 		= '0000-00-00 00:00:00';
				
				return $ret;
			}
		}
		else{
			return array();
		}
		
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
	
		/*Get get product Details   */
	function get_product_id($user_id) 
	{	
			$sql = "SELECT brands.brand_name,brands.brand_id,(select p_category_id from product_category_list where  p_category_id =brand_products.product_name) as p_category_id,
			(select p_category_name from product_category_list where  p_category_id =brand_products.product_name) as product_name,
			users_products.up_product_id from users_products 
			inner join brand_products inner join brands  on   users_products.up_product_id=brand_products.product_id 
			and brand_products.product_brand_id =brands.brand_id  where users_products.up_user_id=$user_id";
//echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	/*Get get service Details   */
	function get_service_status($user_id) 
	{	
			$sql = "SELECT brands.brand_name,SRM.`srm_user_generated_date`,SRM.`srm_status`,SRM.type,
			(select p_category_name from product_category_list where  p_category_id =brand_products.product_name) as product_name
			 from users_products 
			inner join brand_products inner join brands  on   users_products.up_product_id=brand_products.product_id 
			and brand_products.product_brand_id =brands.brand_id  inner join SRM on SRM.srm_user_id=users_products.up_user_id and SRM.srm_product_id=users_products.up_product_id
where users_products.up_user_id=$user_id";
//echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
}