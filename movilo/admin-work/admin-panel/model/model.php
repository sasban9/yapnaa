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
	
	/* To run custom data query*/
	function data_query($sql){
		
		$qry	= connection()->query($sql);	//print_r($qry);exit;
		$ret	= array();
		while($row = mysqli_fetch_assoc($qry)){
			$ret[]=$row;
		}
		//echo json_encode($ret);exit;
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
	/* To get All data order by desc*/
	function get_Detail_all_order_by_desc($table_name,$order_by)
	{
		$sql		=	"SELECT * FROM $table_name order by $order_by desc";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	
	
	/* Update the data based on specified table name and columns */
    function update($table,$set_array,$condition){
		
		if (count($set_array) > 0) {
			foreach($set_array as $key=>$value){
					$key	=	"`".$key."`";
					$value = "'$value'";
					$updates[] = "$key = $value";
			}
		}
		$set 		= implode(', ', $updates);
		$sql		= "UPDATE $table SET $set WHERE $condition"; 
		
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
		echo $sql;exit;
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
		//echo $sql;exit;
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
		//echo $sql;
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
		
		
							
		$sql = "SELECT * FROM $table  as srm JOIN brand_products as bp on srm.srm_product_id	=	bp.product_id join brands as b on b.brand_id = bp.product_brand_id join product_category_list as pcl on pcl.p_category_id = bp.product_name  join users as u on  u.user_id= srm.srm_user_id order by srm.srm_user_generated_date desc";
		
		
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
	
	function get_particular_user_product_list($table,$fields,$condition)
	{	
	       $sql = "SELECT * FROM $table  AS up JOIN brand_products AS bp ON bp.product_id = up.up_product_id JOIN brands AS b ON b.brand_id = bp.product_brand_id JOIN product_category_list AS pcl ON pcl.p_category_id = bp.product_name where $condition ";
			
				 
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
	function get_particular_user_product_details($table,$fields,$condition)
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
										on amc.amc_req_user_id	=	us.user_id order by amc.amc_req_c_date desc";
				
				
				 
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
	function get_zerob_list($action_taken_by,$param,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate )
	{	
	//echo $action_taken_by;die;
	//echo $amc_fromDate;
	
			// $sql = "SELECT *  FROM $table  as   amc  join brand_products as bp on amc.amc_req_product_id	=	bp.product_id join brands as b on b.brand_id  = bp.product_brand_id join  product_category_list as pcl on pcl.p_category_id = bp.product_name join users as us on amc.amc_req_user_id	=	us.user_id";
		
		$columns = "id,last_service_date,next_service_date,CUSTOMERID,CUSTOMER_NAME,CUSTOMER_ADDRESS1,CUSTOMER_ADDRESS2,CUSTOMER_ADDRESS3,CUSTOMER_AREA,CUSTOMER_PINCODE,PHONE1,PHONE2,CUSTOMER_CONTACT_NOS1,CUSTOMER_CONTACT_NOS2,email,PRODUCT,PRODUCT_SLNO,INSTALLATION_DATE,IW,IC,CONTRACT_FROM,CONTRACT_TO,CONTRACT_TYPE,CONTRACT_BY,tag,amc_updated_by,last_called,last_call_comment,last_sms_sent,status";
		
		$condition = "";
		if($filter>0){
			$condition = " and status = $filter";
		}
		if($action_taken_by != null){
			$action_taken_by="and action_taken_by like '%$action_taken_by%'";
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
		
		$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users FROM zerob_consol1 zc where tag like '%$param%' ".$condition." ".$action_taken_by." order by last_called desc";
				
		if($filter == 7){
			$sql = "SELECT ".$columns." ,  user_phone FROM zerob_consol1 zc,users u where tag like '%$param%' ".$action_taken_by." and (u.user_phone = zc.PHONE1 OR u.user_phone = zc.PHONE2) ";
		}
		
		//echo $sql;die;
		$qry	=	connection()->query($sql);		
		$ret=array();
		
		while($row=mysqli_fetch_assoc($qry)){
			$user_phone=$row['PHONE1'];
			  $qry1	=	connection()->query("SELECT distinct yq.questions,um.qst_id,um.answer FROM user_question_aws_mapping um left join yapnaa_questions yq on um.qst_id=yq.id  where um.user_phone=$user_phone "); 
			  while($row1=mysqli_fetch_assoc($qry1)){
			  $ret1[]=$row1;
			  }
			   $row['qust_map']=$ret1;
				$ret[]=$row;
			}
			//echo '<pre>';print_r($ret);exit;
		return $ret;
	}
	// Get brand Customer List
	function get_brand_cust_list($filterByAttempt,$action_taken_by,$param,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto){	
		
		$columns = "id,last_service_date,next_service_date,CUSTOMERID,CUSTOMER_NAME,CUSTOMER_ADDRESS1,CUSTOMER_ADDRESS2,CUSTOMER_ADDRESS3,CUSTOMER_AREA,CUSTOMER_PINCODE,PHONE1,PHONE2,CUSTOMER_CONTACT_NOS1,CUSTOMER_CONTACT_NOS2,email,PRODUCT,PRODUCT_SLNO,INSTALLATION_DATE,IW,IC,CONTRACT_FROM,CONTRACT_TO,CONTRACT_TYPE,CONTRACT_BY,tag,amc_updated_by,last_called,last_call_comment,last_sms_sent,status";
		
		$condition = ""; 
		
		if($filter>0){
			$condition = " and status = $filter";
		}
		if($action_taken_by != null){
			$action_taken_by="and action_taken_by like '%$action_taken_by%'";
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
		if($yapnaaIdfm != null){
			$condition = " and zc.id >= '$yapnaaIdfm'";
		}
		if($yapnaaIdto != null){
			$condition = " and zc.id <= '$yapnaaIdto'";
		}
		if($yapnaaIdfm != null && $yapnaaIdto != null){
			$condition = " and (zc.id between '$yapnaaIdfm' and '$yapnaaIdto')";
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
		
		if($filterByAttempt != null || $filterByAttempt != ''){
			$condition = " and zc.status = ".$filterByAttempt." ";
		} 
				
		$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users FROM $table zc where tag like '%$param%' ".$condition." ".$action_taken_by." order by last_called desc"; 
		
		if($filter == 7){
			$sql = "SELECT ".$columns." ,  user_phone FROM $table zc,users u where tag like '%$param%' ".$action_taken_by." and (u.user_phone = zc.PHONE1 OR u.user_phone = zc.PHONE2) ";
		}
		
		switch($filterByBrand){
			case 0:
			$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID)
			AS users FROM $table zc where tag like '%$param%' ".$condition." ".$action_taken_by." ";
			break;
			case 1:
			$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users FROM $table zc where tag like '%$param%' ".$condition." ".$action_taken_by." and zc.customet_type=1 ";
			break;
			case 2:
			$sql = "SELECT *,
			(SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 
			GROUP by zc.CUSTOMERID) AS users FROM $table zc where 
			tag like '%$param%' ".$condition." ".$action_taken_by." 
			and zc.customet_type=2			
			 "; 
			 
			break;
			case 3:
			$sql = "SELECT *, 
			(SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 
			GROUP by zc.CUSTOMERID) AS users FROM $table zc 
			where tag like '%$param%' ".$condition." ".$action_taken_by." 
			and zc.customet_type=3";
			break;
			 
			case 4:
			$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users FROM $table zc where tag like '%$param%' ".$condition." ".$action_taken_by." and zc.customet_type=4 ";
			break;
		} 
		
		$qry	=	connection()->query($sql);
		/* if($filterByAttempt==1){
			$sql = "SELECT *, 
			(SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 
			GROUP by zc.CUSTOMERID) AS users FROM $table zc where 
			zc.customet_type=0 limit 0,100";
			
			$qry	=	connection()->query($sql);
				
		}*/
		
		//echo $sql;die;
		$ret		= array();
		$row		= mysqli_fetch_all($qry,MYSQLI_ASSOC);
		return $row; 
	}
	
	function download_zerob_list($action_taken_by,$param,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate )
	{	
	//echo $amc_fromDate;
	
			// $sql = "SELECT *  FROM $table  as   amc  join brand_products as bp on amc.amc_req_product_id	=	bp.product_id join brands as b on b.brand_id  = bp.product_brand_id join  product_category_list as pcl on pcl.p_category_id = bp.product_name join users as us on amc.amc_req_user_id	=	us.user_id";
		
		$columns = "id ,CUSTOMERID,CUSTOMER_NAME,CUSTOMER_ADDRESS1,CUSTOMER_ADDRESS2,CUSTOMER_ADDRESS3,CUSTOMER_AREA,CUSTOMER_PINCODE,PHONE1,PHONE2,CUSTOMER_CONTACT_NOS1,CUSTOMER_CONTACT_NOS2,email,PRODUCT,PRODUCT_SLNO,INSTALLATION_DATE,IW,IC,CONTRACT_FROM,CONTRACT_TO,CONTRACT_TYPE,CONTRACT_BY,tag,amc_updated_by,last_called,last_call_comment,last_sms_sent,status";
		
		$condition = "";
		if($filter>0){
			$condition = " and status = $filter";
		}
		if($action_taken_by != null){
			$action_taken_by="and action_taken_by like '%$action_taken_by%'";
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
		$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 ) AS users FROM zerob_consol1 zc where tag like '%$param%' ".$condition." ".$action_taken_by."order by last_called desc";
		
		
		if($filter == 7){
			//$sql = "SELECT ".$columns.", (SELECT user_phone FROM users WHERE user_phone = zc.phone1  or user_phone = zc.phone2) AS users FROM zerob_consol1 zc,users u where tag like '%$param%' and (u.user_phone = zc.PHONE1 OR u.user_phone = zc.PHONE2) ";
			
			$sql = "SELECT ".$columns." ,  user_phone FROM zerob_consol1 zc,users u where tag like '%$param%' ".$action_taken_by." and (u.user_phone = zc.PHONE1 OR u.user_phone = zc.PHONE2) ";
			
			//$sql = "SELECT ".$columns.", (SELECT user_phone FROM users WHERE user_phone = zc.phone1  or user_phone = zc.phone2) AS users FROM zerob_consol1 zc where tag like '%$param%'  order by last_called asc";
		}
		
		//echo 	$fromDate."==".$toDate."<br>"	 ;
		//echo $sql;die;
		$qry	=	connection()->query($sql);
		$ret=array();
		//print_r(mysqli_fetch_assoc($qry));die;
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			
		return $ret;
	}
	function download_brand_list($filterByAttempt,$action_taken_by,$param,$filter,$fromDate,$toDate,$amc_fromDate,$amc_toDate,$table,$filterByBrand,$yapnaaIdfm,$yapnaaIdto)
	{	
	    $columns = "id,last_service_date,next_service_date,CUSTOMERID,CUSTOMER_NAME,CUSTOMER_ADDRESS1,CUSTOMER_ADDRESS2,CUSTOMER_ADDRESS3,CUSTOMER_AREA,CUSTOMER_PINCODE,PHONE1,PHONE2,CUSTOMER_CONTACT_NOS1,CUSTOMER_CONTACT_NOS2,email,PRODUCT,PRODUCT_SLNO,INSTALLATION_DATE,IW,IC,CONTRACT_FROM,CONTRACT_TO,CONTRACT_TYPE,CONTRACT_BY,tag,amc_updated_by,last_called,last_call_comment,last_sms_sent,status";
		
		$condition = ""; 
		
		if($filter>0){
			$condition = " and status = $filter";
		}
		if($action_taken_by != null){
			$action_taken_by="and action_taken_by like '%$action_taken_by%'";
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
		if($yapnaaIdfm != null){
			
			$condition = " and zc.id >= '$yapnaaIdfm'";
			
		}
		if($yapnaaIdto != null){
			
			
			$condition = " and zc.id <= '$yapnaaIdto'";
			
		}
		if($yapnaaIdfm != null && $yapnaaIdto != null){
			
			$condition = " and (zc.id between '$yapnaaIdfm' and '$yapnaaIdto')";
			
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
		$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users FROM $table zc where tag like '%$param%' ".$condition." ".$action_taken_by." order by last_called desc"; 
		
		
		if($filter == 7){
			
			$sql = "SELECT ".$columns." ,  user_phone FROM $table zc,users u where tag like '%$param%' ".$action_taken_by." and (u.user_phone = zc.PHONE1 OR u.user_phone = zc.PHONE2) ";
			
		}
		
		switch($filterByBrand){
			case 0:
			$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID)
			AS users FROM $table zc where tag like '%$param%' ".$condition." ".$action_taken_by." ";
			break;
			case 1:
			$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users FROM $table zc where tag like '%$param%' ".$condition." ".$action_taken_by." and zc.customet_type=1 ";
			break;
			case 2:
			$sql = "SELECT *,
			(SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 
			GROUP by zc.CUSTOMERID) AS users FROM $table zc where 
			tag like '%$param%' ".$condition." ".$action_taken_by." 
			and zc.customet_type=2			
			 "; 
			 
			break;
			case 3:
			$sql = "SELECT *, 
			(SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 
			GROUP by zc.CUSTOMERID) AS users FROM $table zc 
			where tag like '%$param%' ".$condition." ".$action_taken_by." 
			and zc.customet_type=3";
			break;
			 
			case 4:
			$sql = "SELECT *, (SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 GROUP by zc.CUSTOMERID) AS users 
								FROM $table zc where tag like '%$param%' ".$condition." ".$action_taken_by." 
					and zc.customet_type=4
                  "; 
			 
			
			
			break;
		} 
       //echo $sql;exit;
		$qry	=	connection()->query($sql);
		if($filterByAttempt==1){
			
		 $sql = "SELECT *, 
		(SELECT user_phone FROM users WHERE user_phone = zc.phone1 or user_phone = zc.phone2 
		GROUP by zc.CUSTOMERID) AS users FROM $table zc where 
		 zc.customet_type=0 limit 0,100";
		
		$qry	=	connection()->query($sql);
				
		}	
		$ret=array();
		$row=mysqli_fetch_all($qry,MYSQLI_ASSOC);
		
		return $row; 
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
	
	
	
	/* By Suman */
	
	// Get Data from brand table for call-agencies
	function getDataFromMasterTableByCondition($brandname,$total,$status){
		$current_date = date('Y-m-d');
		if($status == 'new-data'){
			$sql 		= "SELECT ".$brandname.".id,tag,PHONE1 FROM ".$brandname." WHERE ".$brandname.".id NOT IN (SELECT customer_id FROM daily_call_schedule_2 WHERE DATE(created_date) = '".$current_date."') AND ".$brandname.".status = 0 ORDER BY ".$brandname.".id DESC LIMIT ".$total." ";
		}
		if($status == 'escalation-related'){
			$sql 		= "SELECT ".$brandname.".id,tag,PHONE1 FROM ".$brandname." WHERE ".$brandname.".id NOT IN (SELECT customer_id FROM daily_call_schedule_2 WHERE DATE(created_date) = '".$current_date."') AND ".$brandname.".status IN (16,17,18) ORDER BY ".$brandname.".id DESC LIMIT ".$total." ";
		}
		if($status == 'no-response'){
			$sql 		= "SELECT ".$brandname.".id,tag,PHONE1 FROM ".$brandname." WHERE ".$brandname.".id NOT IN (SELECT customer_id FROM daily_call_schedule_2 WHERE DATE(created_date) = '".$current_date."') AND ".$brandname.".status = 12 ORDER BY ".$brandname.".id DESC LIMIT ".$total." ";
		}
		if($status == 'not-reachable'){
			$sql 		= "SELECT ".$brandname.".id,tag,PHONE1 FROM ".$brandname." WHERE ".$brandname.".id NOT IN (SELECT customer_id FROM daily_call_schedule_2 WHERE DATE(created_date) = '".$current_date."') AND ".$brandname.".status = 13 ORDER BY ".$brandname.".id DESC LIMIT ".$total." ";
		}
		if($status == 'call-back'){
			$sql 		= "SELECT ".$brandname.".id,tag,PHONE1 FROM ".$brandname." WHERE ".$brandname.".id NOT IN (SELECT customer_id FROM daily_call_schedule_2 WHERE DATE(created_date) = '".$current_date."') AND ".$brandname.".status = 1 ORDER BY ".$brandname.".id DESC LIMIT ".$total." ";
		}
		if($status == 'not-interested'){
			$sql 		= "SELECT ".$brandname.".id,tag,PHONE1 FROM ".$brandname." WHERE ".$brandname.".id NOT IN (SELECT customer_id FROM daily_call_schedule_2 WHERE DATE(created_date) = '".$current_date."') AND ".$brandname.".status = 2 ORDER BY ".$brandname.".id DESC LIMIT ".$total." ";
		}
		
		//echo $sql;die;
		$qry		= connection()->query($sql);
		$ret		= array();
		
		$row		= mysqli_fetch_all($qry,MYSQLI_ASSOC);
		
		$ret 		= array();
		$ret1 		= array();
		if(!empty($row)){
			foreach($row as $key => $value){
				$ret['id']  = $value['id'];
				$ret['tag'] = $value['tag'];
				$ret['PHONE1'] = $value['PHONE1'];
				$ret1[]		= $ret;
			}
		}else{
			$ret1 	= array();
		}
		//echo "<br><pre>"; print_r($ret1); die;
		return $ret1; 
	}
	
	function get_brand_name($admin_id){
		$sql 		= "SELECT ca.brandname FROM daily_call_schedule_2 ca WHERE ca.admin_id = ".$admin_id." GROUP BY ca.brandname ";
		$qry		= connection()->query($sql);
		$row		= mysqli_fetch_all($qry,MYSQLI_ASSOC);
		
		$ret 		= array();
		foreach($row as $key => $value){
			$ret[]  = $value['brandname'];
		}
		return $ret;
	}
	
	function get_amc_list_from_brand_and_call($search,$fromDate,$toDate,$admin_id,$join_table_name){
		$condition 			= "";
		
		if($search != null){
			$condition 		.= " and bn.tag like '%$search%' "; 
		}
		if($fromDate != null && $toDate != null){
			$condition 		.= " and DATE(ca.created_date) BETWEEN '$fromDate' AND '$todate' ";
		}
		
		$sql 				= "SELECT ca.brandname,ca.id AS call_id,ca.created_date,bn.* FROM daily_call_schedule_2 ca LEFT JOIN ".$join_table_name." bn ON ca.customer_id = bn.id where ca.admin_id = ".$admin_id." AND ca.status = 0 AND bn.status IN (0,1,13,14) AND ca.brandname = '".$join_table_name."' ".$condition." ";
		//echo $sql;
		$qry				= connection()->query($sql);
		$ret 				= array();
		while($row=mysqli_fetch_assoc($qry)){
			$ret[]=$row;
		}
		//echo '<br><pre>'.print_r($ret);die;
		return $ret;
	}
	
	function get_filtered_amc_list_from_brand_and_call($search,$fromDate,$toDate,$admin_id,$join_table_name){
		$condition 			= "";
		//print_r($join_table_name); die;
		if($search != null){
			$condition 		.= " and bn.tag like '%$search%' "; 
			//$sql 			= "SELECT ca.brandname,bn.* FROM daily_call_schedule_2 ca LEFT JOIN ".$join_table_name." bn ON ca.customer_id = bn.id where ca.admin_id = ".$admin_id." AND bn.status IN (0,1,13,14) AND ca.brandname = '".$join_table_name."' ".$condition." ";
			
			/* $sql			 =	"SELECT ca.brandname,bn.* FROM daily_call_schedule_2 ca LEFT JOIN ".$join_table_name[0]." bn ON ca.customer_id = bn.id where ca.admin_id = ".$admin_id." AND bn.status IN (0,1,13,14) AND ca.brandname = '".$join_table_name[0]."' ".$condition."  
				UNION ALL
			SELECT ca.brandname,bn.* FROM daily_call_schedule_2 ca LEFT JOIN ".$join_table_name[1]." bn ON ca.customer_id = bn.id where ca.admin_id = ".$admin_id." AND bn.status IN (0,1,13,14) AND ca.brandname = '".$join_table_name[1]."' ".$condition."  
				UNION ALL
			SELECT ca.brandname,bn.* FROM daily_call_schedule_2 ca LEFT JOIN ".$join_table_name[2]." bn ON ca.customer_id = bn.id where ca.admin_id = ".$admin_id." AND bn.status IN (0,1,13,14) AND ca.brandname = '".$join_table_name[2]."' ".$condition."
				UNION ALL
			SELECT ca.brandname,bn.* FROM daily_call_schedule_2 ca LEFT JOIN ".$join_table_name[3]." bn ON ca.customer_id = bn.id where ca.admin_id = ".$admin_id." AND bn.status IN (0,1,13,14) AND ca.brandname = '".$join_table_name[3]."' ".$condition."
			"; */
			
		}
		
		if($fromDate != null && $toDate != null){
			$condition 		.= " and DATE(ca.created_date) BETWEEN '$fromDate' AND '$todate' ";
			$sql 			= "SELECT ca.brandname,ca.id AS call_id,ca.created_date,bn.* FROM daily_call_schedule_2 ca LEFT JOIN ".$join_table_name." bn ON ca.customer_id = bn.id where ca.admin_id = ".$admin_id." AND ca.status = 0 AND bn.status IN (0,1,13,14) AND ca.brandname = '".$join_table_name."' ".$condition." ";
		}
		
		$qry				= connection()->query($sql);
		$ret 				= array();
		while($row=mysqli_fetch_assoc($qry)){
			$ret[]=$row;
		}
		//echo '<br><pre>'.print_r($ret);die;
		return $ret;
	}
	
	
	function get_q_a($brand,$user_id){
		//$sql 				= "SELECT qa.* FROM question_and_answer qa WHERE qa.brand = '".$brand."' ";echo $sql;
		
		$sql 				= "SELECT qa.*,(SELECT cqa.cqa_answer  FROM customer_question_answer cqa where cqa.cqa_qid=qa.qa_id AND cqa.cqa_user_id = ".$user_id." ) AS answer_given,(SELECT CONCAT_WS('_', 'qa', cqa.cqa_answer) FROM customer_question_answer cqa where cqa.cqa_qid=qa.qa_id AND cqa.cqa_user_id = ".$user_id." ) AS answer_weightage,
		(SELECT cqa.cqa_weightage FROM customer_question_answer cqa where cqa.cqa_qid=qa.qa_id AND cqa.cqa_user_id = ".$user_id." ) AS weightage FROM question_and_answer qa WHERE qa.qa_brand = '".$brand."' ";
		
		$qry				= connection()->query($sql);
		$row				= mysqli_fetch_all($qry,MYSQLI_ASSOC);
		
		return $row;
	}
	
	function insert_data_query($data1,$insert_data,$sql,$user_phone){
		if(empty($insert_data)){
			$insert_data	= 'insert into customer_question_answer(cqa_user_id,cqa_brand_customer_id,cqa_qid,cqa_answer,cqa_brand_id,cqa_brand_name,cqa_user_phone,cqa_weightage,cqa_created_date) values("'.$data1['user_id'].'","'.$data1['brand_customer_id'].'","'.$data1['qid'].'","'.$data1['answer'].'","'.$data1['brand_id'].'","'.$data1['brand_name'].'","'.$data1['user_phone'].'","'.$data1['weightage'].'","'.$data1['created_date'].'")';
		}
		else{
			$insert_data	.=	",('".$data1['user_id']."','".$data1['brand_customer_id']."','".$data1['qid']."','".$data1['answer']."','".$data1['brand_id']."','".$data1['brand_name']."','".$data1['user_phone']."','".$data1['weightage']."','".$data1['created_date']."')";
		}
		//echo $insert_data;die;
		$qry				= connection()->query($insert_data);
		return $qry;
	}
	
	function update_data_query($data1,$insert_data,$user_id){
		if(empty($insert_data)){
			$update_qry 	= "UPDATE customer_question_answer SET cqa_user_id = '".$data1['user_id']."' , cqa_brand_customer_id = '".$data1['brand_customer_id']."' , cqa_qid = '".$data1['qid']."' , cqa_answer = '".$data1['answer']."' , cqa_brand_id = '".$data1['brand_id']."' , cqa_brand_name = '".$data1['brand_name']."' , cqa_user_phone = '".$data1['user_phone']."' , cqa_weightage = '".$data1['weightage']."' , cqa_updated_date = '".$data1['updated_date']."' WHERE cqa_qid = ".$data1['qid']." AND cqa_user_id = ".$user_id." ";
			
		}
		$qry				= connection()->query($update_qry);
		return $qry;
	}
	
	function check_duplicate_data_for_QA($value3,$user_phone){
		$table				= 'customer_question_answer';
		$sql				= "SELECT * FROM ".$table." y where y.user_phone = ".$user_phone." and y.qst_id=".$value3['qid']." ";
		$qry				= connection()->query($sql);
		$row				= mysqli_fetch_all($qry,MYSQLI_ASSOC);
		return $row;
	}
	
	function get_qa_ids_of_customer($customer_type,$user_id){
		$sql 				= "SELECT CONCAT_WS('_', 'qid', cqa.cqa_qid) AS qid FROM customer_question_answer cqa WHERE cqa.cqa_user_id = ".$user_id." AND cqa.cqa_brand_id = ".$customer_type." ";

		$qry				= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			$qidArr			= array();
			foreach($row as $key => $value){
				$qidArr[]	= $value['qid'];		 
			}
			//print_r($qidArr); die;
			return $qidArr;
		}
		else{
			return array();
		}
		
	}
	
	function get_brand_details_of_customer($customer_type,$user_id){
		switch($customer_type) {
			case 1:
			$brand_name	= 'livpure';
			break;
			case 2:
			$brand_name	= 'zerob_consol1';
			break;
			case 3:
			$brand_name	= 'livpure_tn_kl';
			break;
			case 4:
			$brand_name	= 'bluestar_b2b';
			break;
			case 5:
			$brand_name	= 'bluestar_b2c';
			break;
			
			case 6:
			$brand_name	= 'livpure_ap';
			break;
			case 7:
			$brand_name	= 'livpure_ts';
			break;
		}
		
		//$sql 				= "SELECT b.CUSTOMERID,b.CUSTOMER_NAME,b.CUSTOMER_AREA,b.PHONE1,b.PRODUCT,b.PRODUCT_SLNO,b.email,b.status FROM ".$brand_name." b WHERE b.id = ".$user_id." ";
		
		$sql 				= "SELECT b.* FROM ".$brand_name." b WHERE b.id = ".$user_id." ";
		
		$qry				= connection()->query($sql);
		$row				= mysqli_fetch_assoc($qry);
		return $row;
	}
	
	
	function delete_QA_data_by_userid($customer_type,$user_id){
		$sql 				= "DELETE FROM customer_question_answer WHERE cqa_user_id = ".$user_id." AND cqa_brand_id = ".$customer_type." ";
		
		$qry				= connection()->query($sql);		
		return $qry;
	}
	

	
	/* LIFE CYCLE PROCESS STARTS HERE */
	
	function transaction_lifecycle($table){
		//$sql 				= "SELECT id,CUSTOMERID,CUSTOMER_NAME,PHONE1 FROM ".$table." br WHERE br.status = 7 AND br.CONTRACT_BY = 'Yapnaa' AND CURDATE() = DATE( DATE_ADD(updated_on, INTERVAL 2 DAY )) ";
		
		$sql 				= "SELECT id,CUSTOMERID,CUSTOMER_NAME,PHONE1,profile_type FROM ".$table." br WHERE br.status = 7 AND br.CONTRACT_BY = 'Yapnaa' AND CURDATE() = DATE( DATE_ADD(updated_on, INTERVAL 0 DAY )) ";
		$qry				= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			return $row;
		}
		else{
			return array();
		}
	}
	
	
	function promotional_message(){
		//$sql 				= "SELECT tm_id,tm_brand_user_phone FROM timeline tm WHERE tm.tm_lifecycle_experience > 5 AND CURDATE() = DATE( DATE_ADD(tm_created_date, INTERVAL 30 DAY ))";
		$sql 				= "SELECT tm_id,tm_brand_user_phone FROM timeline tm WHERE tm.tm_lifecycle_experience > 5 AND CURDATE() = DATE( DATE_ADD(tm_created_date, INTERVAL 0 DAY ))";
		$qry				= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			return $row;
		}
		else{
			return array();
		}
		
	}
	
	
	function productchange_lifecycle($table){
		//$sql 				= "SELECT id,CUSTOMERID,CUSTOMER_NAME,PHONE1 FROM ".$table." br WHERE br.status = 10 AND CURDATE() = DATE( DATE_ADD(updated_on, INTERVAL 7 DAY )) ";
		$sql 				= "SELECT id,CUSTOMERID,CUSTOMER_NAME,PHONE1,profile_type FROM ".$table." br WHERE br.status = 10 AND CURDATE() = DATE( DATE_ADD(updated_on, INTERVAL 0 DAY )) ";
		
		$qry				= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			return $row;
		}
		else{
			return array();
		}
	}
	
	
	function escalation_lifecycle($table){
		//$sql 				= "SELECT id,CUSTOMERID,CUSTOMER_NAME,PHONE1 FROM ".$table." br WHERE br.status IN (16,17,18) AND CURDATE() = DATE( DATE_ADD(updated_on, INTERVAL 3 DAY )) ";
		$sql 				= "SELECT id,CUSTOMERID,CUSTOMER_NAME,PHONE1,profile_type FROM ".$table." br WHERE br.status IN (16,17,18) AND CURDATE() = DATE( DATE_ADD(updated_on, INTERVAL 0 DAY )) ";
		
		$qry				= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			return $row;
		}
		else{
			return array();
		}
	}
	
	
	function amc_message($table){
		//$sql 				= "SELECT id,CUSTOMERID,CUSTOMER_NAME,PHONE1 FROM ".$table." br WHERE br.status = 7 AND br.CONTRACT_FROM != '' AND CURDATE() = DATE( DATE_ADD(CONTRACT_FROM, INTERVAL 120 DAY )) ";
		$sql 				= "SELECT id,CUSTOMERID,CUSTOMER_NAME,PHONE1,profile_type FROM ".$table." br WHERE br.status = 7 AND br.CONTRACT_FROM != '' AND CURDATE() = DATE( DATE_ADD(CONTRACT_FROM, INTERVAL 0 DAY )) ";
		
		$qry				= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			return $row;
		}
		else{
			return array();
		}
	}
	
	function get_timeline_detail_of_customer($customer_type,$user_id){
		$sql 				= "SELECT tl.* FROM timeline tl WHERE tl.tm_brand_user_id = ".$user_id." AND tl.tm_brand_id = ".$customer_type." ";
		
		$qry				= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			return $row;
		}
		else{
			return array();
		}
		
	}
	
	
	function get_existing_profile_status_of_customer($brand,$user_id){
		$sql 				= "SELECT br.profile_type FROM ".$brand." br WHERE br.id = ".$user_id."  ";
		$qry				= connection()->query($sql);
		$row				= mysqli_fetch_assoc($qry);
		if(!empty($row['profile_type'])){
			return $row;
		}else{
			return array('profile_type' => 'New');
		}
		
	}
	
	
	function get_profile_history_data($brand,$user_id,$tm_id){
		$sql 				= "SELECT qa.*,(SELECT ph.ph_answer  FROM profile_history ph where ph.ph_qid=qa.qa_id AND ph.ph_user_id = ".$user_id."  AND ph.ph_timeline_id = ".$tm_id." ) AS answer_given,(SELECT CONCAT_WS('_', 'qa', ph.ph_answer) FROM profile_history ph where ph.ph_qid=qa.qa_id AND ph.ph_user_id = ".$user_id." AND ph.ph_timeline_id = ".$tm_id." ) AS answer_weightage,(SELECT ph.ph_weightage FROM profile_history ph where ph.ph_qid=qa.qa_id AND ph.ph_user_id = ".$user_id."  AND ph.ph_timeline_id = ".$tm_id." ) AS weightage,(SELECT ph.ph_customer_name FROM profile_history ph where ph.ph_qid=qa.qa_id AND ph.ph_user_id = ".$user_id."  AND ph.ph_timeline_id = ".$tm_id." ) AS ph_customer_name,(SELECT ph.ph_email FROM profile_history ph where ph.ph_qid=qa.qa_id AND ph.ph_user_id = ".$user_id."  AND ph.ph_timeline_id = ".$tm_id." ) AS ph_email,(SELECT ph.ph_customer_area FROM profile_history ph where ph.ph_qid=qa.qa_id AND ph.ph_user_id = ".$user_id."  AND ph.ph_timeline_id = ".$tm_id." ) AS ph_customer_area FROM question_and_answer qa WHERE qa.qa_brand = '".$brand."' ";
		
		$qry				= connection()->query($sql);
		$row				= mysqli_fetch_all($qry,MYSQLI_ASSOC);
		return $row;
	}
	
	
	function promotional_welcome_sms($table){
		if($table == 'livpure' || 'livpure_tn_kl' || 'livpure_ts' || 'livpure_ap'){
			$sql 				= "SELECT br.id,br.CUSTOMERID,br.CUSTOMER_NAME,br.PHONE1,br.profile_type FROM daily_call_schedule_2 dc LEFT JOIN ".$table." br ON dc.customer_id = br.id WHERE dc.brandname = '".$table."' AND br.status = 0 AND  CURDATE() = DATE( DATE_ADD(br.updated_on, INTERVAL 0 DAY )) ";
		}
		if($table == 'bluestar_b2b' || 'bluestar_b2c'){
			$sql 				= "SELECT br.id,br.CUSTOMERID,br.CUSTOMER_NAME,br.PHONE1,br.profile_type FROM daily_call_schedule_2 dc LEFT JOIN ".$table." br ON dc.customer_id = br.id WHERE dc.brandname = '".$table."' AND br.status = 0 AND CURDATE() = DATE( DATE_ADD(br.updated_on, INTERVAL 0 DAY )) ";
		}
		if($table == 'zerob_consol1'){
			$sql 				= "SELECT br.id,br.CUSTOMERID,br.CUSTOMER_NAME,br.PHONE1,br.profile_type FROM daily_call_schedule_2 dc LEFT JOIN ".$table." br ON dc.customer_id = br.id WHERE dc.brandname = '".$table."' AND br.status = 0 AND CURDATE() = DATE( DATE_ADD(br.updated_on, INTERVAL 5 DAY )) ";
		}
		//print_r($sql); die;
		$qry				= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			return $row;
		}
		else{
			return array();
		}
	}	
	
	
	function amc_cron($table){
		if($table == 'livpure' || 'livpure_tn_kl' || 'livpure_ts' || 'livpure_ap'){
			$sql 				= "SELECT br.id,br.CUSTOMERID,br.CUSTOMER_NAME,br.PHONE1,br.profile_type FROM ".$table." br WHERE br.status != 0 AND  CURDATE() = DATE( DATE_ADD(br.updated_on, INTERVAL 15 DAY )) ";
		}
		if($table == 'bluestar_b2b' || 'bluestar_b2c'){
			$sql 				= "SELECT br.id,br.CUSTOMERID,br.CUSTOMER_NAME,br.PHONE1,br.profile_type FROM ".$table." br WHERE br.status != 0 AND  CURDATE() = DATE( DATE_ADD(br.updated_on, INTERVAL 15 DAY )) ";
		}
		if($table == 'zerob_consol1'){
			$sql 				= "SELECT br.id,br.CUSTOMERID,br.CUSTOMER_NAME,br.PHONE1,br.profile_type FROM ".$table." br WHERE br.status != 0 AND  CURDATE() = DATE( DATE_ADD(br.updated_on, INTERVAL 15 DAY )) ";
		}
		
		$qry				= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			return $row;
		}
		else{
			return array();
		}
	}	
	
	
	// Function for dahboard pie chart
	function get_dashboard_data_by_brand_status($table){
		$sql  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 15 ";
		$qry	= connection()->query($sql);
		$row	= mysqli_fetch_assoc($qry);
		$customer_requests 		= $row['total_user'];
		
		$sql1  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 2 ";
		$qry1	= connection()->query($sql1);
		$row1	= mysqli_fetch_assoc($qry1);
		$not_interested 		= $row1['total_user'];
		
		$sql2  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 1 OR br.status = 14 ";
		$qry2	= connection()->query($sql2);
		$row2	= mysqli_fetch_assoc($qry2);
		$request_to_reconnect 	= $row2['total_user'];
		
		$sql3  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 19 ";
		$qry3	= connection()->query($sql3);
		$row3	= mysqli_fetch_assoc($qry3);
		$requesting_pm_service 	= $row3['total_user'];
		
		$sql4 = "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 12 OR br.status = 13 OR br.status = 20 ";
		$qry4	= connection()->query($sql4);
		$row4	= mysqli_fetch_assoc($qry4);
		$not_responsive 		= $row4['total_user'];
	
		$return_arr 	= array(
								'customer_requests' 	=> $customer_requests,
								'not_interested' 		=> $not_interested,
								'request_to_reconnect' 	=> $request_to_reconnect,
								'requesting_pm_service' => $requesting_pm_service,
								'not_responsive' 		=> $not_responsive
								);
								
		return $return_arr;						
	}
	
	
	function get_dashboard_data_by_brand_profile_type($table){
		$sql  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.profile_type = 'True Loyalists' ";
		$qry	= connection()->query($sql);
		$row	= mysqli_fetch_assoc($qry);
		$true_loyalists 		= $row['total_user'];
		
		$sql1  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.profile_type = 'Acquaintences' ";
		$qry1	= connection()->query($sql1);
		$row1	= mysqli_fetch_assoc($qry1);
		$acquaintences 			= $row1['total_user'];
		
		$sql2  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.profile_type = 'Strangers' ";
		$qry2	= connection()->query($sql2);
		$row2	= mysqli_fetch_assoc($qry2);
		$strangers 				= $row2['total_user'];
		
		$sql3  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.profile_type = 'Poor Patrons' ";
		$qry3	= connection()->query($sql3);
		$row3	= mysqli_fetch_assoc($qry3);
		$poor_patrons 			= $row3['total_user'];
		
		$sql4 = "SELECT count(id) AS total_user FROM ".$table." br WHERE br.profile_type = 'Enthusiasts' ";
		$qry4	= connection()->query($sql4);
		$row4	= mysqli_fetch_assoc($qry4);
		$enthusiasts 			= $row4['total_user'];
		
		$sql5 = "SELECT count(id) AS total_user FROM ".$table." br WHERE br.profile_type = 'Admirers' ";
		$qry5	= connection()->query($sql5);
		$row5	= mysqli_fetch_assoc($qry5);
		$admirers 				= $row5['total_user'];
		
		$sql6 = "SELECT count(id) AS total_user FROM ".$table." br WHERE br.profile_type = 'Benchwarmers' ";
		$qry6	= connection()->query($sql6);
		$row6	= mysqli_fetch_assoc($qry6);
		$benchwarmers 			= $row6['total_user'];
		
		$sql7 = "SELECT count(id) AS total_user FROM ".$table." br WHERE br.profile_type = 'Opportunists' ";
		$qry7	= connection()->query($sql7);
		$row7	= mysqli_fetch_assoc($qry7);
		$opportunists 			= $row7['total_user'];
		
		$return_arr 	= array(
								'true_loyalists' => $true_loyalists,
								'acquaintences'  => $acquaintences,
								'strangers' 	 => $strangers,
								'poor_patrons' 	 => $poor_patrons,
								'enthusiasts' 	 => $enthusiasts,
								'admirers' 		 => $admirers,
								'benchwarmers' 	 => $benchwarmers,
								'opportunists' 	 => $opportunists
								);
								
		return $return_arr;						
	}
	
	
	function get_dashboard_data_by_brand_not_interested($table){
		$sql  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 2 AND br.not_interested_reason = 1 ";
		$qry	= connection()->query($sql);
		$row	= mysqli_fetch_assoc($qry);
		$dissatisfied_with_service 					= $row['total_user'];
		
		$sql1  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 2 AND br.not_interested_reason = 2 ";
		$qry1	= connection()->query($sql1);
		$row1	= mysqli_fetch_assoc($qry1);
		$unreliable_support_after_taking_contract 	= $row1['total_user'];
		
		$sql2  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 2 AND br.not_interested_reason = 3 ";
		$qry2	= connection()->query($sql2);
		$row2	= mysqli_fetch_assoc($qry2);
		$technician_do_not_respond 					= $row2['total_user'];
		
		$sql3  	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 2 AND br.not_interested_reason = 4 ";
		$qry3	= connection()->query($sql3);
		$row3	= mysqli_fetch_assoc($qry3);
		$price_high 								= $row3['total_user'];
		
		$sql4 	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 2 AND br.not_interested_reason = 5 ";
		$qry4	= connection()->query($sql4);
		$row4	= mysqli_fetch_assoc($qry4);
		$no_value_for_money 						= $row4['total_user'];
		
		$sql5 	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 2 AND br.not_interested_reason = 6 ";
		$qry5	= connection()->query($sql5);
		$row5	= mysqli_fetch_assoc($qry5);
		$escalation_but_problem_exist  				= $row5['total_user'];
		
		$sql6 	= "SELECT count(id) AS total_user FROM ".$table." br WHERE br.status = 2 AND br.not_interested_reason = 7 ";
		$qry6	= connection()->query($sql6);
		$row6	= mysqli_fetch_assoc($qry6);
		$will_decide_later 							= $row6['total_user'];
		
		$return_arr 	= array(
								'dissatisfied_with_service' 				=> $dissatisfied_with_service,
								'unreliable_support_after_taking_contract'  => $unreliable_support_after_taking_contract,
								'technician_do_not_respond' 	 			=> $technician_do_not_respond,
								'price_high' 	 							=> $price_high,
								'no_value_for_money' 	 					=> $no_value_for_money,
								'escalation_but_problem_exist' 		 		=> $escalation_but_problem_exist,
								'will_decide_later' 	 					=> $will_decide_later
								);
								
		return $return_arr;						
	}
	
	
	// By Suman and for telecaller
	function get_telecaller_list(){
		$sql  	= "SELECT al.admin_id,al.admin_name,al.admin_email_id FROM admin_login al WHERE al.admin_role_id = 3 ";
		$qry	= connection()->query($sql);
		$row	= mysqli_fetch_all($qry,MYSQLI_ASSOC);
		return $row;			
	}
	
	
	function get_qa_data($brand,$user_id){
		$sql 	= "SELECT ym.id AS mapping_id,ym.answer_id,yq.id AS question_id,yq.questions,yq.group_level,yq.parent_group_level,yq.brand,ya.answer_type,ya.answer_weightage, (SELECT cqa.answer_id FROM customer_question_answer_1 WHERE cqa.question_id = question_id AND cqa.user_id = ".$user_id.") AS answer_given FROM yap_mapping_1 ym LEFT JOIN yapnaa_questions_1 yq ON ym.question_id = yq.id LEFT JOIN yapnaa_answers_1 ya ON ym.answer_id = ya.id LEFT JOIN customer_question_answer_1 cqa ON cqa.question_id = yq.id WHERE yq.brand = ".$brand." ";
		
		//echo $sql; die;
		$qry	= connection()->query($sql);
		$row	= mysqli_fetch_all($qry,MYSQLI_ASSOC);
		return $row;
	}
	
	function get_question_ids_of_customer($brand_id,$user_id){
		$sql 				= "SELECT cqa.question_id AS qid FROM customer_question_answer_1 cqa WHERE cqa.user_id = ".$user_id." AND cqa.brand_id = ".$brand_id." ";

		$qry				= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			$qidArr			= array();
			foreach($row as $key => $value){
				$qidArr[]	= $value['qid'];		 
			}
			return $qidArr;
		}
		else{
			return array();
		}
	}
	
	function update_q_a($data,$user_id){
		$update_qry 	= "UPDATE customer_question_answer_1 SET user_id = '".$data['user_id']."' , question_id = '".$data['question_id']."' , answer_id = '".$data['answer_id']."' , brand_id = '".$data['brand_id']."' , updated_date = '".$data['updated_date']."' WHERE question_id = ".$data['question_id']." AND user_id = ".$user_id." AND brand_id = ".$data['brand_id']." ";
		$qry			= connection()->query($update_qry);
		return $qry;
	}
	
	
	function get_answer_weightage_of_customer($brand_id,$user_id){
		$sql 			= "SELECT cqa.question_id,cqa.answer_id,yq.parent_group_level,ya.answer_weightage FROM customer_question_answer_1 cqa LEFT JOIN yapnaa_questions_1 yq ON cqa.question_id = yq.id LEFT JOIN yapnaa_answers_1 ya ON cqa.answer_id = ya.id WHERE cqa.user_id = ".$user_id." AND cqa.brand_id =".$brand_id." ";
		
		$qry			= connection()->query($sql);
		if(!empty($qry)){
			$row			= mysqli_fetch_all($qry,MYSQLI_ASSOC);
			return $row;
		}
		else{
			return array();
		}	
	}
	
	
	function show_profile_history($brand,$user_id,$tm_id){
		
		$sql 	= "SELECT ph.ph_qid,ph.ph_answer AS answer_given,ph.ph_customer_name,ph.ph_email,ph.ph_customer_area,yq.parent_group_level,yq.group_level,ya.answer_type,ya.answer_weightage FROM profile_history ph LEFT JOIN yapnaa_questions_1 yq ON ph.ph_qid = yq.id LEFT JOIN yapnaa_answers_1 ya ON ph.ph_answer = ya.id WHERE ph.ph_user_id = ".$user_id." AND ph.ph_timeline_id = ".$tm_id." AND ph.ph_brand_id =".$brand." ";
		
		$qry	= connection()->query($sql);
		$row	= mysqli_fetch_all($qry,MYSQLI_ASSOC);
		return $row;
	}
	
	function get_profile_popup_data($brand,$user_id){
		$sql 	= "SELECT yq.id,ya.answer_type FROM customer_question_answer_1 cqa LEFT JOIN yapnaa_answers_1 ya ON cqa.answer_id = ya.id LEFT JOIN yapnaa_questions_1 yq ON cqa.question_id = yq.id WHERE yq.id IN (2,3,5,6,7,8,11,12,13,14,15,16,17) AND cqa.user_id = ".$user_id." AND cqa.brand_id = ".$brand."  ORDER BY yq.id ASC ";
		
		$qry	= connection()->query($sql);
		$row	= mysqli_fetch_all($qry,MYSQLI_ASSOC);
		return $row;
	}

	
	
	
	
	
}