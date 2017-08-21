<?php 
 
class web_common_controller	{
	
	function __construct(){
		global $obj_model; 
		$this->model	=	& $obj_model; 
		date_default_timezone_set('Asia/Kolkata'); 
		global $date; 
		$date			=	date('Y-m-d H:i:s');
		$this->date		=	& $date; 
		
	}  
	
	 
	
}

?>