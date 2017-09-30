<?PHP


	function table()
	{
		$tb = array(
					'tb1'	=>	'users',
					'tb2'	=>	'brands',
					'tb3'	=>	'brand_products',
					'tb4'	=>	'users_products',
					'tb5'	=>	'product_category_list',
					'tb6'	=>	'srm_questions',
					'tb7'	=>	'user_srm_answers',
					'tb8'	=>	'SRM',
					'tb9'	=>	'user_feedback',
					'tb10'	=>	'amc_requests',
					'tb11'	=>	'banner_images',
					'tb12'	=>	'amc_price_list',
					'tb13'	=>	'apk_version'
					
					);
		return $tb;

	}

	/* Base URL $arr_data[0] is having server name and $arr_data[1] have folder name*/

	$url		=	$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

	$arr_data   =   explode("/",$url);

	$base_url	= $arr_data[0]."/".$arr_data[1]."/"; 

	

?>