<?php
class model {
  
	
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
	
	function get_cart_details($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table where $condition ORDER BY user_cart_id DESC LIMIT 0 , 30";
		//echo $sql; exit;
		mysqli_set_charset('utf8');
		$qry	=	connection()->query($sql);
		
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		//echo "<pre>from here";echo json_encode($ret);die;
		return $ret;
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
	
	/* To get data with specified fields */
	function get_Detail_field($table,$fields)
	{
		$sql = "SELECT $fields FROM $table";
		//echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){

				$ret[]=$row;
               }
			
		return $ret;
	}
	 
	
	
	/* To get data with specified fields */
	function get_Detail_ORDER_BY($table,$fields)
	{
		$sql = "SELECT $fields FROM $table ORDER BY $fields";
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
	
	/* Update Row */
	function update_row_data($table,$condition)
	{
		$sql = "Update FROM $table where $condition";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);		
		return $qry;
	}
	 
	
	/* To get data based on conditions and specified fields */
	function get_all_details_condition($table,$fields,$condition)
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
	
	
	
	
	/* To get data based on conditions and specified fields */
	function get_row_details_condition($table,$fields,$condition)
	{
		$sql = "SELECT $fields FROM $table where $condition";
		//echo $sql; 
		$qry	=	connection()->query($sql);
		$ret=array();
		$row=mysqli_fetch_assoc($qry); 
		return $row;
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
	
	   
	   
	/* To get data based on conditions and specified fields with Order By*/
	function get_details_orderby_desc($table,$fields,$orderby)
	{
		$sql = "SELECT $fields FROM $table order by $orderby desc";
		// echo $sql;exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	
	/* To get data based on conditions and specified fields with Order By*/
	function get_details_condition_orderby($table,$fields,$condition,$orderby)
	{ 
		$sql = "SELECT $fields FROM $table where $condition order by $orderby desc";
		//echo $sql;exit;
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
		/* $file = fopen("/var/www/html/test.txt","w");
		fwrite($file,$sql);
		fclose($file);*/
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		return $ret;
	}
	 
	
	
	         
	/* Insert the data based on specified table name and columns */
	
	function insert($table,$arr_input)
	{

		$values	= array_values($arr_input);
		$keys	=	array_keys($arr_input);
		$fieldlist	= "`".implode("`,`",$keys)."`";
		$values	= "'".implode("','",$values)."'";	
		//$table	=	"` $table`";
		 $sql	=	"INSERT INTO $table ($fieldlist) VALUES ($values)";	
		//echo $sql; exit;
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
        
     
	 
	 
	 
	 	/* update the data based on specified table name and columns */
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
		//echo $sql;die; 
		unset($set);
		$qry	=	connection()->query($sql);
		return $qry;
		
	}
	             
				 
					
	/* To get data based on conditions and specified fields */
	function add_to_cart_user_cart_details($table_name, $fields, $condition)
	{
		$sql = "SELECT $fields FROM $table_name as uc join store_products as sp  on uc.user_cart_p_bar_code_id	=	sp.p_product_barcode_no where $condition order by user_cart_id desc";
		echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row  =   mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		//print_r($ret);exit;
		return $ret;
		
		
	}		 	
	

	/* To get cart data based on conditions and specified fields */
	function get_user_cart_details($table_name, $fields, $condition)
	{
		$sql = "SELECT $fields FROM $table_name as uc join store_products as sp  on uc.user_cart_p_bar_code_id	=	sp.p_product_barcode_no where $condition order by user_cart_id desc";
		//echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		if(mysqli_num_rows($result) < 1){
			while($row  =   mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
		}
		//print_r($ret);exit;
		return $ret;
		
		
	}
	
	/* To get data based on conditions and specified fields */
	function user_cart_details($table_name, $fields, $condition)
	{
		$sql = "SELECT * FROM $table_name as uc join store_products as sp  on uc.user_cart_p_bar_code_id = sp.p_product_barcode_no and uc.user_cart_store_ref_id = sp.p_b_store_id JOIN business_stores AS bs ON uc.user_cart_store_ref_id = bs.b_store_id where $condition   order by user_cart_id desc";
		//echo $sql; exit;
		
		$qry	=	connection()->query($sql);
		$ret=array();
		//mysqli_data_seek($qry,0);
		//print_r($qry);echo "<br>";
		
		while($row=mysqli_fetch_assoc($qry)){
				//print_r($row);
				$ret[]=$row;
		}
		
		return $ret;
		
		
	}
	
			 
	
	
	
	
			
	/* To get data based on conditions and specified fields */
	function user_cart_details_admin($table_name, $fields, $condition)
	{
		$sql = "SELECT * FROM $table_name as uc join store_products as sp  on uc.user_cart_p_bar_code_id	=	sp.p_product_barcode_no where $condition order by user_cart_id desc";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
		
		
	}
	
	
	
	/* To get data based on conditions and specified fields */
	function get_sub_category_list($table)
	{
		$sql = "SELECT * FROM $table as SC join main_category as MC  on SC.sc_ref_mc_id	=	MC.mc_id order by sc_id desc";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
		
		
	}
	
	
	 
				
	/* To get data based on conditions and specified fields */
	function get_business_store_list($table,$fields,$orderby)
	{
		$sql = "SELECT $fields FROM $table as lt   join sub_category as sc on sc.sc_id =lt.b_store_sc_id join main_category as mc on mc.mc_id = lt.b_store_mc_id    order by $orderby desc";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
		
		
	}

	
	
	/* To get data based on conditions and specified fields */
	function get_store_details_by_id($table_name,$fields,$condition)
	{
		$sql = "SELECT  $fields
		FROM $table_name as lt   join sub_category as sc on sc.sc_id =lt.b_store_sc_id join main_category as mc on mc.mc_id = lt.b_store_mc_id    where $condition ";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
		
		
	}
	
	
	
	
	
	
	
	
	
	/* To get data based on conditions and specified fields */
	function ticket_order_list($table_name, $fields, $condition)
	{
		$sql = "SELECT * FROM $table_name as tc join users as u  on u.user_id	=	tc.ticket_order_user_id where $condition order by ticket_order_id desc";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/*-----------------------------------Admin Panel---------------------------------------------------*/
	
	
	
	
	
		
	/* To get data based on conditions and specified fields */
	function get_tickets_list_admin($table_name, $fields, $condition)
	{
		$sql = "SELECT * FROM $table_name as tc join users as u  on u.user_id	=	tc.ticket_order_user_id join business_stores as bs on bs.b_store_id =tc.ticket_order_store_ref_id   order by ticket_order_id desc";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
		
		
	}
	
	
	
	
	
	
	
	
/*-----------------------------------Vendor Panel---------------------------------------------------*/
	
	
	
	
	
		
	/* To get data based on conditions and specified fields */
	function get_order_list_by_store_id($table_name,$fields,$condition,$orderby)
	{
		$sql = "SELECT * FROM $table_name as o
								join users as u
								on u.user_id=o.order_user_ref_id
								where  $condition  order by $orderby desc";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
		
		
	}
	
	
	
	
			
	/* To get data based on conditions and specified fields */
	function get_order_list_details_by_id($table_name,$fields,$condition,$orderby)
	{
		//echo $condition;
		//$sql = "SELECT * FROM $table_name as o join users as u  on u.user_id	=	o.order_user_ref_id join order_item_details as oi on o.order_id = oi.item_order_ref_id  join store_products as sp on sp.p_id = oi.item_order_item_ref_id where  $condition  order by $orderby desc";
		/*$sql = "SELECT 
			o.order_id,
			o.order_user_ref_id,
			u.user_id,
			sp.p_id,
			oi.item_order_item_ref_id 
			FROM orders as o
			join  users as u on u.user_id=o.order_user_ref_id 
			join order_item_details as oi on  u.user_id = oi.item_order_ref_user_id 
			join order_item_details as oid on  o.order_id = oid.item_order_ref_id
			join store_products as sp on sp.p_id = oi.item_order_item_ref_id 
			where o.order_id = 57 order by order_id desc";

			$sql = "SELECT  * FROM orders as o
			join  users as u on u.user_id=o.order_user_ref_id 
			join order_item_details as oi on  u.user_id = oi.item_order_ref_user_id
			join order_item_details as ois on  o.order_store_ref_id = ois.item_order_ref_store_id
			join store_products as sp on sp.p_id = oi.item_order_item_ref_id
			 
			where $condition order by $orderby desc";
			*/
		/* $sql = "SELECT  * FROM orders as o
			join  users as u on u.user_id=o.order_user_ref_id 
			join order_item_details as oi on  u.user_id = oi.item_order_ref_user_id
			join store_products as sp on sp.p_id = oi.item_order_item_ref_id and
			 o.order_store_ref_id = oi.item_order_ref_store_id
			order_store_ref_id 
			where $condition order by $orderby desc";
			$sql = "SELECT * FROM orders o,
		        users u,
		        order_item_details oi,
		        store_products sp WHERE u.user_id=o.order_user_ref_id and
		        u.user_id = oi.item_order_ref_user_id and 
		        o.order_id = oi.item_order_ref_id and
		        sp.p_id = oi.item_order_item_ref_id and
		         o.order_store_ref_id = oi.item_order_ref_store_id  and
		         $condition order by $orderby desc
        ";

        $sql = "SELECT * FROM orders o,
		        users u,
		        order_item_details oi,
		        store_products sp WHERE u.user_id=o.order_user_ref_id and
		        u.user_id = oi.item_order_ref_user_id and 
		        o.order_store_ref_id=oi.item_order_ref_store_id and
		        sp.p_id = oi.item_order_item_ref_id and
		         o.order_store_ref_id = oi.item_order_ref_store_id  and
		         $condition order by $orderby desc
        ";
         $sql = "SELECT * FROM orders o,
		        users u,
		        order_item_details oi,
		        store_products sp 
		        WHERE u.user_id=o.order_user_ref_id and
		        u.user_id = oi.item_order_ref_user_id and 
		        o.order_store_ref_id=oi.item_order_ref_store_id and
		        sp.p_id = oi.item_order_item_ref_id and
		        o.order_store_ref_id = oi.item_order_ref_store_id
		        and o.order_id=57  order by o.order_id desc
        ";

			*/
        /*
        $sql = "SELECT * FROM orders o,
		        users u,
		        order_item_details oi,
		        store_products sp 
		        WHERE u.user_id=o.order_user_ref_id and
		        u.user_id = oi.item_order_ref_user_id and 
		        o.order_store_ref_id=oi.item_order_ref_store_id and
		        sp.p_id = oi.item_order_item_ref_id and
		        o.order_store_ref_id = oi.item_order_ref_store_id
		        and o.order_id=$condition  order by o.order_id desc
        ";
        $sql = "SELECT * FROM  orders o,
         						users u,
         						order_item_details oi,
         						store_products sp 
         						WHERE u.user_id	=	o.order_user_ref_id and
         						o.order_store_ref_id = oi.item_order_ref_store_id and
         						o.order_id = oi.item_order_ref_id and
                                sp.p_product_barcode_no = oi.item_order_item_bar_code and
								o.order_id=$condition order by o.order_id desc";
        */
         $sql = "SELECT * FROM  orders o,
         						users u,
         						order_item_details oi,
         						store_products sp 
         						WHERE u.user_id	=	o.order_user_ref_id and
         						u.user_id = oi.item_order_ref_user_id and
         						o.order_store_ref_id = oi.item_order_ref_store_id and
         						o.order_id = oi.item_order_ref_id and
                                sp.p_product_barcode_no = oi.item_order_item_bar_code and
                                o.order_store_ref_id = oi.item_order_ref_store_id and
								o.order_id=$condition order by o.order_id desc";
        //print_r($sql);
        //die();
        /*
        $sql="SELECT 

        		o.*,
        		(SELECT user_id from users where user_id=o.order_user_ref_id) as user_id,


        		 FROM

        		 orders o WHERE o.order_id=57  order by o.order_id desc ";
        		 */

		 //echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
		
		
	}
	
	
	
	
	
	/*-----------------------------------User App---------------------------------------------------*/
	
			
	/* To get data based on conditions and specified fields */
	function business_category_list($user_latitude, $user_longitude)
	{
		// $sql = "SELECT *, 3956 * 2 * ASIN(SQRT( POWER(SIN(('.$user_latitude.' - bs.b_store_lat) * pi()/180 / 2), 2) +COS('.$user_latitude.'* pi()/180) * COS(bs.b_store_lat * pi()/180) * POWER(SIN(('.$user_longitude.' -bs.b_store_long) * pi()/180 / 2), 2) )) as distance   FROM `sub_category` as sc join  shop_cat_mapping as scm on scm.sc_mapping_subcat_ref_id = sc.sc_id join  business_stores as bs on scm.sc_mapping_shop_ref_id = bs.b_store_id  HAVING distance < 2  ORDER BY distance ASC";
		
		$sql = "SELECT *, 3956 * 2 * ASIN(SQRT( POWER(SIN(('".$user_latitude."' - bs.b_store_lat) * pi()/180 / 2), 2) +COS('".$user_latitude."'* pi()/180) * COS(bs.b_store_lat * pi()/180) * POWER(SIN(('".$user_longitude."' -bs.b_store_long) * pi()/180 / 2), 2) )) as distance   FROM `sub_category` as sc join  shop_cat_mapping as scm on scm.sc_mapping_subcat_ref_id = sc.sc_id join  business_stores as bs on scm.sc_mapping_shop_ref_id = bs.b_store_id  where bs.b_store_status =1 HAVING distance < 10  ORDER BY sc.sc_priority,distance ASC";
		
		//echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
		
		
	}
	
	function business_search_list($user_latitude, $user_longitude,$cond)
	{
		// $sql = "SELECT *, 3956 * 2 * ASIN(SQRT( POWER(SIN(('.$user_latitude.' - bs.b_store_lat) * pi()/180 / 2), 2) +COS('.$user_latitude.'* pi()/180) * COS(bs.b_store_lat * pi()/180) * POWER(SIN(('.$user_longitude.' -bs.b_store_long) * pi()/180 / 2), 2) )) as distance   FROM `sub_category` as sc join  shop_cat_mapping as scm on scm.sc_mapping_subcat_ref_id = sc.sc_id join  business_stores as bs on scm.sc_mapping_shop_ref_id = bs.b_store_id  HAVING distance < 2  ORDER BY distance ASC";
		
		$sql = "SELECT *, 3956 * 2 * ASIN(SQRT( POWER(SIN(('".$user_latitude."' - bs.b_store_lat) * pi()/180 / 2), 2) +COS('".$user_latitude."'* pi()/180) * COS(bs.b_store_lat * pi()/180) * POWER(SIN(('".$user_longitude."' -bs.b_store_long) * pi()/180 / 2), 2) )) as distance   FROM `sub_category` as sc join  shop_cat_mapping as scm on scm.sc_mapping_subcat_ref_id = sc.sc_id join  business_stores as bs on scm.sc_mapping_shop_ref_id = bs.b_store_id  where $cond HAVING distance < 10  ORDER BY sc.sc_priority,distance ASC";
		
		//echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;
		
		
	}
	
	
	
		/* To get data based on conditions and specified fields */
	function get_user_order_details_app($table_name, $fields, $condition)
	{  
		$sql = "SELECT * FROM $table_name  as o  JOIN business_stores AS bs ON bs.b_store_id = o.`order_store_ref_id`   JOIN  users AS u ON u.user_id = o.`order_user_ref_id` where  $condition  order by order_id desc"; 
		//$sql = "SELECT * FROM $table_name  as o  JOIN business_stores AS bs ON bs.b_store_id = o.`order_store_ref_id` JOIN  order_item_details AS oid ON oid.item_order_ref_id = o.`order_id` JOIN store_products as sp on sp.p_product_barcode_no=oid.item_order_item_bar_code  JOIN  users AS u ON u.user_id = o.`order_user_ref_id` where  $condition  order by order_id desc"; 
		//echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
		} 
		return $ret;
		
		
	}
	function get_checkout_order_details_app($table_name, $fields, $condition)
	{  
		//$sql = "SELECT * FROM $table_name  as o  JOIN business_stores AS bs ON bs.b_store_id = o.`order_store_ref_id`   JOIN  users AS u ON u.user_id = o.`order_user_ref_id` where  $condition  order by order_id desc"; 
		$sql = "SELECT * FROM $table_name  as o  JOIN business_stores AS bs ON bs.b_store_id = o.`order_store_ref_id` JOIN  order_item_details AS oid ON oid.item_order_ref_id = o.`order_id` JOIN store_products as sp on sp.p_product_barcode_no=oid.item_order_item_bar_code  JOIN  users AS u ON u.user_id = o.`order_user_ref_id` where  $condition  order by order_id desc"; 
		//echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
		} 
		return $ret;
		
		
	}
	function get_user_ticket_details_app($table_name, $fields, $condition)
	{  
		$sql = "SELECT * FROM $table_name  as t  JOIN business_stores AS bs ON bs.b_store_id = t.`ticket_order_store_ref_id`   JOIN  users AS u ON u.user_id = t.`ticket_order_user_id` where  $condition  order by ticket_order_id desc"; 
		//$sql = "SELECT * FROM $table_name  as o  JOIN business_stores AS bs ON bs.b_store_id = o.`order_store_ref_id` JOIN  order_item_details AS oid ON oid.item_order_ref_id = o.`order_id` JOIN store_tickets as st on st.st_id=oid.item_order_item_bar_code  JOIN  users AS u ON u.user_id = o.`order_user_ref_id` where  $condition  order by order_id desc"; 
		//echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
		} 
		return $ret;
		
		
	}
	
	function get_user_order_items_details_app($table_name, $fields, $condition)
	{  
		//$sql = "SELECT * FROM order_item_details as oi  join  store_products as sp on sp.p_id  = oi.item_order_item_ref_id  where  $condition  order by item_id ASC"; 
		$sql = "SELECT * FROM order_item_details as oi  join  store_products as sp on sp.p_id  = oi.item_order_item_ref_id  where  $condition  order by item_id ASC"; 
		//echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
		} 
		return $ret;
		
		
	}
	
	function get_user_ticket_items_details_app($table_name, $fields, $condition)
	{  
		//$sql = "SELECT * FROM order_item_details as oi  join  store_products as sp on sp.p_id  = oi.item_order_item_ref_id  where  $condition  order by item_id ASC"; 
		$sql = "SELECT * FROM ticket_order_item_details as toi  join  store_tickets as st on st.st_id  = toi.ticket_item_order_ticket_id  where  $condition  order by 	ticket_item_order_id ASC"; 
		//echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
		} 
		return $ret;
		
		
	}

	function all_user_cart_details_admin($table_name){
		/*
		$sql = "SELECT * FROM $table_name as uc
				join store_products as sp 
				on uc.user_cart_p_bar_code_id	=	sp.p_product_barcode_no 
				order by user_cart_id desc";
				*/
		$sql = "SELECT * FROM $table_name as uc
				join store_products as sp 
				on uc.user_cart_p_bar_code_id	=	sp.p_product_barcode_no 
				";
		// echo $sql; exit;
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;

	}

	function all_get_order_list_by_store_id($table_name){
		/*
		$sql = "SELECT * FROM $table_name as o
								join users as u
								on u.user_id=o.order_user_ref_id
								where  $condition  order by $orderby desc";
								*/

		$sql = "SELECT * FROM $table_name as o
								join users as u
								on u.user_id=o.order_user_ref_id
								";
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				$ret[]=$row;
			}
			//print_r($ret);exit;
		return $ret;						
		// echo $sql; exit;

	}

	function get_users_curentday_count($table_name){

		//$sel ="SELECT * FROM $table_name WHERE user_registration_date > DATE_SUB(NOW(), INTERVAL 1 DAY) ORDER BY user_id DESC";
		//print_r($sel);exit;
		$sel ="SELECT * FROM $table_name WHERE
		        DAY(user_registration_date)= DAY(NOW()) and
				MONTH(user_registration_date)  = MONTH(NOW()) and
				YEAR(user_registration_date)  = YEAR(NOW())
		   ";

		
		$qry	=	connection()->query($sel);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
			$ret[]=$row;
		}
		$result = count($ret);
			
		return $result;
	}
	
	function get_users_weekly_count($table_name){

		//$sel ="SELECT * FROM $table_name WHERE user_registration_date > DATE_SUB(NOW(), INTERVAL 1 WEEK) ORDER BY user_id DESC";
		$sel ="SELECT * FROM $table_name WHERE
		        WEEKOFYEAR(user_registration_date)= WEEKOFYEAR(NOW()) and
				MONTH(user_registration_date)  = MONTH(NOW()) and
				YEAR(user_registration_date)  = YEAR(NOW())
		   ";

		$qry	=	connection()->query($sel);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
			$ret[]=$row;
		}
		$result = count($ret);
		return $result;
	}

	function get_users_monthly_count($table_name){

		//$sel ="SELECT * FROM $table_name WHERE user_registration_date > DATE_SUB(NOW(), INTERVAL 1 MONTH) ORDER BY user_id DESC";
		$sel ="SELECT * FROM $table_name WHERE
				MONTH(user_registration_date)  = MONTH(NOW()) and
				YEAR(user_registration_date)  = YEAR(NOW())
		   ";

		$qry	=	connection()->query($sel);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
			$ret[]=$row;
		}
		$result = count($ret);
		return $result;
	}

	function get_users_yearly_count($table_name){
		$sel ="SELECT * FROM $table_name WHERE
				YEAR(user_registration_date)  = YEAR(NOW())
		   ";

		$qry	=	connection()->query($sel);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
			$ret[]=$row;
		}
		$result = count($ret);
		return $result;

	}
	function get_users_last_yearly_count($table_name){
		$sel ="SELECT * FROM $table_name WHERE
				YEAR(user_registration_date)  = (YEAR(NOW())-1)
		   ";

		$qry	=	connection()->query($sel);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
			$ret[]=$row;
		}
		$result = count($ret);
		return $result;

	}

	function all_order_sucess_list($table_name){
		//order_store_ref_id
		$sql = "SELECT * FROM $table_name as o
								join users as u
                                join business_stores as bs
								on u.user_id=o.order_user_ref_id and 
								bs.b_store_id =o.order_store_ref_id and
								 o.order_payment_status='Success'
								";
	    //print_r($sql);
	    //die();
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
			$ret[]=$row;
		}
			//print_r($ret);exit;
		return $ret;								

	}

	function get_all_product_sale_count($table_name,$pid){
		//echo $pid;
		//die();
		/*
		$sql = "SELECT * FROM  orders o,
         						users u,
         						order_item_details oi,
         						store_products sp 
         						WHERE u.user_id	=	o.order_user_ref_id and
         						u.user_id = oi.item_order_ref_user_id and
         						o.order_store_ref_id = oi.item_order_ref_store_id and
         						o.order_id = oi.item_order_ref_id and
                                sp.p_product_barcode_no = oi.item_order_item_bar_code and
                                o.order_store_ref_id = oi.item_order_ref_store_id and
								o.order_id=$condition order by o.order_id desc";	
		
		$sql = "SELECT * FROM $table_name as o
                                join store_products as sp
								on bs.b_store_id =o.order_store_ref_id and
								 o.order_payment_status='Success'
							";

		$sql = "SELECT * FROM   $table_name o,
         						order_item_details oi,
         						store_products sp 
         						WHERE sp.p_id=$pid and
         						o.order_id = oi.item_order_ref_id and
                                sp.p_product_barcode_no = oi.item_order_item_bar_code and
                                o.order_payment_status='Success'";
	
        $sql="SELECT order_no_of_items FROM orders o,
        					order_item_details oi,
        					store_products sp 
        					WHERE  o.order_id = oi.item_order_ref_id and
        					sp.p_id =oi.item_order_item_ref_id and
        					o.order_payment_status='Success'";
          */
        					/*
        $sql="SELECT sum(o.order_no_of_items) as total_pcount FROM
		        orders o,
		        order_item_details oi 
		        WHERE o.order_id = oi.item_order_ref_id and
		        oi.item_order_item_ref_id=$pid and
		        o.order_payment_status='Success'"; 
		        */	
		        
		$sql="SELECT SUM(order_no_of_items) as total_pcount FROM
		        orders
		        WHERE order_payment_status='Success'";         

	    //print_r($sql);
	    //die();
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				//$ret=$row;
			    //$items = +$row['order_no_of_items'];
				$ret[]=$row;
			}
		//$res = count($ret);	
		return $ret;	
	}

	function get_all_product_salecount(){
		/*
		 $sql="SELECT sum(o.order_no_of_items) as total_pcount FROM
		        orders o,
		        order_item_details oi 
		        WHERE o.order_id = oi.item_order_ref_id and
		        o.order_payment_status='Success'"; 

		 */	
		$sql="SELECT SUM(order_no_of_items) as total_pcount FROM
		        orders
		        WHERE order_payment_status='Success'";				                        						
	 
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				//$ret=$row;
			    //$items = +$row['order_no_of_items'];
				$ret=$row;
			}
		//$res = count($ret);	
		return $ret;

	}

	function get_all_order_list(){
		/*
		 $sql="SELECT *  FROM
		        orders o,
		        order_item_details oi 
		        WHERE o.order_id = oi.item_order_ref_id and
		        o.order_user_ref_id = oi.item_order_ref_user_id and
		        o.order_store_ref_id =oi.item_order_ref_store_id and
		        o.order_payment_status<>'Success'";
		        */
		 $sql="SELECT SUM(order_no_of_items) as total_pcount FROM
		        orders
		        WHERE order_payment_status='Pending' OR order_payment_status='Failure'";        

	    //print_r($sql);
	    //die();
		$qry	=	connection()->query($sql);
		$ret=array();
		while($row=mysqli_fetch_assoc($qry)){
				//$ret=$row;
			    //$items = +$row['order_no_of_items'];
				$ret=$row;
			}
		//$ret = count($ret);	
		return $ret;

	}
	
	
}