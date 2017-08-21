<?PHP


	function table()
	{
		$tb = array(
					'tb1'	=>	'brand_products',
					);
		return $tb;

	}

	/* Base URL $arr_data[0] is having server name and $arr_data[1] have folder name*/

	$url		=	$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];

	$arr_data   =   explode("/",$url);

	$base_url	= $arr_data[0]."/".$arr_data[1]."/"; 

	

?>