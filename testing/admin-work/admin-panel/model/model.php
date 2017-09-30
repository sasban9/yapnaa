<?php
class model {
	
	function __Construct()
	{
		require_once("config/config.php");
	}
	
	
	/* To get All data*/
	function get_Detail_all($table_name)
	{
		$sql		=	"SELECT * FROM $table_name";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
		
	/* To get data based on conditions and specified fields with Order By*/
	function get_details_orderby($table,$fields,$orderby)
	{
		$sql = "SELECT $fields FROM $table order by $orderby Asc";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	

	/* To get data based on conditions Where id matches*/
	function get_details_by_id($table,$fields,$id)
	{

		$sql = "SELECT $fields FROM $table WHERE banner_id=".$id;
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
			
	/* To get data based on conditions and specified fields with Order By*/
	function get_details_orderby_desc($table,$fields,$orderby)
	{
		$sql = "SELECT $fields FROM $table order by $orderby Desc";
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
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
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
		 //echo $sql;exit;
		//unset($set);
		$qry	=	connection()->query($sql);
		return $qry;
		
	}
	
	
	
	function admin_login_val($admin_email_id,$admin_password)
	{
		/*$sql	=	"
		SELECT *
		FROM admin_login
		WHERE admin_email_id='$admin_email_id' AND admin_password='$admin_password'";*/
				$sql	="SELECT al.*,ar.ar_role_name 
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
				//print_r($ret);
			return $ret;
		}
	}
	
	
	
	
		
	/* Insert the data based on specified table name and columns */
	public function insert($table,$arr_input)
	{
		//$con=$this->connection();
		$values		=	array_values($arr_input);
		$keys		=	array_keys($arr_input);
		$fieldlist	=	"`".implode("`,`",$keys)."`";
		$values		=	"'".implode("','",$values)."'";	
		//$table		=	"` $table`";
		$sql		=	"INSERT INTO $table ($fieldlist) VALUES ($values)";	
		// echo $sql;exit;
		$con =	connection();
		$result	= mysqli_query($con,$sql) or die(mysqli_error($con));
		$id = mysqli_insert_id($con);
		// echo 	$id ;exit;
		// $result	=	connection()->query($sql);
		// print_r($result);exit;
		unset($fieldlist, $values);
		if($result){
			return $id;
		}	
		else{
			return FALSE;
		} 
		mysqli_free_result($result);
		$con->close();
	}
	
	
	
		
	/* Delete Row */
	function delete_row_data($table,$condition)
	{
		$sql = "DELETE FROM $table where $condition";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);		
		return $qry;
	}
	
	
	
		/* To get data based on conditions and specified fields */
	function get_Details_condition($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table where $condition";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			// print_r($ret);
		return $ret;
	}
	
	
	
	
		/*Get Booking Details (USER-Vajid) */
	function get_brand_product($table)
	{	
			$sql = "SELECT * 
				FROM brand_products as bp JOIN brands as b ON bp.product_brand_id	=	b.brand_id join product_category_list as pcl on pcl.p_category_id = bp.product_name";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
	
		/*Get Booking Details (USER-Vajid) */
	function get_brand_by_id($table,$fields,$condition)
	{	
			$sql = "SELECT * 
				FROM brand_products as bp JOIN brands as b ON bp.product_brand_id	=	b.brand_id join product_category_list as pcl on pcl.p_category_id = bp.product_name where $condition";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
	
	
		/*Get Booking Details (USER-Vajid) */
	function get_brand_product_list($table,$fields,$condition)
	{	
			$sql = "SELECT * 
				FROM brand_products as bp JOIN brands as b ON bp.product_brand_id	=	b.brand_id join product_category_list as pcl on pcl.p_category_id = bp.product_name where $condition";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	

	function get_Detail_user_added_products($table){
    	
    	$sel = "SELECT 	
    					u.user_id,
    					u.user_name,
    					pc.p_category_name,
    					b.brand_name,
    					up.up_serial_no,
    					up.up_dealer_name,
    					up.up_location

    					 FROM users_products up ,
    	 						users u,
    	 						brand_products bp,
    	 						brands b,
    	 						product_category_list pc
    	 		WHERE up.up_user_id=u.user_id AND
    	 	 	up.up_product_id=bp.product_id AND
    	 	 	bp.product_brand_id =b.brand_id AND bp.product_name=pc.p_category_id";

    	$qry	=	connection()->query($sel);
    	//print_r($sel);
    	$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;

    }
	
	
	
	
	
		//SRM Request List 
	function srm_request_list($table)
	{	
			// $sql = "SELECT * 
				// FROM $table  as srm JOIN users as u ON srm.srm_user_id	=	u.user_id join users_products as up on up.up_id=srm.srm_product_id JOIN brand_products AS bp on bp.product_id=up.up_product_id join brands as b on b.brand_id  = bp.product_brand_id  where srm.srm_status =0";
				
		// $sql = "SELECT * 
				// FROM $table  as srm JOIN users as u ON srm.srm_user_id	=	u.user_id join users_products as up on up.up_id=srm.srm_product_id JOIN brand_products AS bp on bp.product_id=up.up_product_id join brands as b on b.brand_id  = bp.product_brand_id ";
				
				
							
		// $sql = "SELECT * FROM $table  as srm JOIN users_products as up ON srm.srm_product_id	=	up.up_id  join users as u on  u.user_id= up.up_user_id join brand_products as bp on bp.product_id =up.up_product_id join brands as b on b.brand_id = bp.product_brand_id join product_category_list as pcl on pcl.p_category_id = bp.product_name";
		
		
							
		$sql = "SELECT * FROM $table  as srm JOIN brand_products as bp on srm.srm_product_id	=	bp.product_id join brands as b on b.brand_id = bp.product_brand_id join product_category_list as pcl on pcl.p_category_id = bp.product_name  join users as u on  u.user_id= srm.srm_user_id";
		
		
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
	
	
		//SRM Particular Request List
	function srm_request_list_particular_details($table,$fields,$condition)
	{	
			// $sql = "SELECT * FROM $table  as srm JOIN users as u ON srm.srm_user_id	=	u.user_id join users_products as up on up.up_id=srm.srm_product_id JOIN brand_products AS bp on bp.product_id=up.up_product_id join brands as b on b.brand_id  = bp.product_brand_id  where $condition";
			
			
			$sql = "SELECT * FROM $table  as srm JOIN users as u ON srm.srm_user_id	=	u.user_id join  brand_products AS bp on bp.product_id=srm.srm_product_id join brands as b on b.brand_id = bp.product_brand_id   where $condition";
			
			
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
	
	
	
	// Get User product List
	function get_particular_user_product_list($table,$fields,$condition)
	{	
			$sql = "SELECT * 
				FROM $table  as   bp  join brands as b on b.brand_id  = bp.product_brand_id join  product_category_list as pcl on pcl.p_category_id = bp.product_name where $condition ";
				 
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
	
	// Get User product List
	function get_faq_list($table)
	{	
			$sql = "SELECT brand_name, p_category_name, product_id
				FROM $table  as srm_q join brand_products as bp on bp.product_id= srm_q.srm_question_bp_id join brands as b on b.brand_id  = bp.product_brand_id join  product_category_list as pcl on pcl.p_category_id = bp.product_name  group by `srm_question_bp_id` ";
				 
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
	
	// Get User product List
	function get_faq_list_details($table,$condition)
	{	
			$sql = "SELECT *
				FROM $table  as srm_q join brand_products as bp on bp.product_id= srm_q.srm_question_bp_id join brands as b on b.brand_id  = bp.product_brand_id join  product_category_list as pcl on pcl.p_category_id = bp.product_name where $condition   ";
				 
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
	
	// Get User product List
	function get_faq_list_details_edit($table,$condition)
	{	
			$sql = "SELECT *
				FROM $table  as srm_q join brand_products as bp on bp.product_id= srm_q.srm_question_bp_id join brands as b on b.brand_id  = bp.product_brand_id join  product_category_list as pcl on pcl.p_category_id = bp.product_name where $condition   ";
				 
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
		// Get User product List
	function get_user_phone_list($table,$fields,$id)
	{	
		$sql = "SELECT * FROM $table WHERE user_phone LIKE  '%$id%' ORDER BY user_id ASC LIMIT 0, 10";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
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
	
	
	
	
	
	
	
	// Get User product List
	function get_amc_list($table,$fields,$condition)
	{	
			// $sql = "SELECT *  FROM $table  as   amc  join brand_products as bp on amc.amc_req_product_id	=	bp.product_id join brands as b on b.brand_id  = bp.product_brand_id join  product_category_list as pcl on pcl.p_category_id = bp.product_name join users as us on amc.amc_req_user_id	=	us.user_id";
		
		
		
		$sql = "SELECT * FROM `amc_requests` as amc 
									join  users_products as up 
										on up.up_id = amc.`amc_req_product_id`
									join brand_products as bp 
										on up.up_product_id	=	bp.product_id 
									join brands as b 
										on b.brand_id  = bp.product_brand_id 
									join  product_category_list as pcl 
										on pcl.p_category_id = bp.product_name 
									join users as us 
										on amc.amc_req_user_id	=	us.user_id";
				
				
				 
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
	// Get Zerob Customer List
	function get_zerob_list($param,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate )
	{	
	//echo $amc_fromDate;
	
			// $sql = "SELECT *  FROM $table  as   amc  join brand_products as bp on amc.amc_req_product_id	=	bp.product_id join brands as b on b.brand_id  = bp.product_brand_id join  product_category_list as pcl on pcl.p_category_id = bp.product_name join users as us on amc.amc_req_user_id	=	us.user_id";
		
		$condition = "";
		if($filter>0){
			$condition = " and status = $filter";
		}
		
		if($fromDate != null){
			$condition = " and last_called >= '$fromDate'";
		}
		if($toDate != null){
			$condition = " and last_called <= '$toDate'";
		}
		if($fromDate != null && $toDate != null){
			$condition = " and (last_called between '$fromDate' and '$toDate')";
		}
		if($amc_fromDate != null){
			$condition = " and STR_TO_DATE(CONTRACT_FROM,'%d-%m-%Y') >= '$amc_fromDate' ";
		}
		if($amc_toDate != null){
			$condition = " and STR_TO_DATE(CONTRACT_TO,'%d-%m-%Y') <= '$amc_toDate'";
		}
		if($amc_fromDate != null && $amc_toDate != null){
			$condition = " and (STR_TO_DATE(CONTRACT_FROM,'%d-%m-%Y') >= '$amc_fromDate' and STR_TO_DATE(CONTRACT_TO,'%d-%m-%Y') <='$amc_toDate')";
		}
		$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 ) AS users FROM zerob_consol1 zc where tag like '%$param%' ".$condition;
		
		
		
		if($filter == 7){
			$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1  or user_phone = zc.phone2) AS users FROM zerob_consol1 zc,users u where tag like '%$param%' and (u.user_phone = zc.PHONE1 OR u.user_phone = zc.PHONE2) ";
		}
				
		//echo 	$fromDate."==".$toDate."<br>"	 ;
		//echo $sql;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
	}
	
	
		/*Get get_amc_price_list */
	function get_amc_price_list($table)
	{	
			$sql = "SELECT * 
				FROM $table as amcprice JOIN brands as b ON amcprice.amc_price_brand_id	=	b.brand_id   join product_category_list as pcl on pcl.p_category_id = amcprice.amc_price_brand_name";
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