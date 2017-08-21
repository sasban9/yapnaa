							  
<?php
require_once('controller/admin_controller.php');
if(isset($_POST['id'])){
	$id		=	$_POST['id'];
	$control	=	new admin();
	
	
	
	// Get get_brand List
	$get_brand_product_list = $control->get_brand_product_list($id);
	// print(count($get_brand_product_list));
	// echo '<pre>';print_r($get_brand_product_list);
	echo "<option value =''>Choose Your Service</option>";
	foreach($get_brand_product_list as $val){
		 $product_id=$val['product_id'];
		 $product_name=$val['p_category_name'];
		 
		echo "<option value ='$product_id'>$product_name</option>";
	}
	
	
	
}

?>