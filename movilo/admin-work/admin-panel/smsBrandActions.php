<?php
require_once('controller/admin_controller.php');
	$control	=	new admin();
if(isset($_REQUEST['custResponse'])){
		
		$custType = $_REQUEST['custType']; 
		$userQst3 = $_REQUEST['userQst3']; 
		$userQst1 = $_REQUEST['userQst1'];
		switch($userQst1){ 
			case 1:			
		    $userQst1 ='No' ;
			break;
			case 2:
			$userQst1 ='No' ;
			break;
			case 3:
			$userQst1 ='Yes' ;
			break;
			case 4:
			$userQst1 ='Yes' ;
			break;
			case 5:
			$userQst1 ='Yes' ;
			break;
		}
		switch($userQst3){ 
			case 1:			
		    $userQst3 ='No' ;
			break;
			case 2:
			$userQst3 ='No' ;
			break;
			case 3:
			$userQst3 ='Yes' ;
			break;
			case 4:
			$userQst3 ='Yes' ;
			break;
			case 5:
			$userQst3 ='Yes' ;
			break;
		}
		$userQst2 = $_REQUEST['userQst2'];
		 
		
		
		$number = $_REQUEST['mobile'];
		$brandId = 1;
		$brandName = 'Livpure';
		$customerid =preg_replace('/[0-3]+/', '', $_REQUEST['mobile']);
		$customername = $_REQUEST['name'];
		$userQst= array("3","4","2","12");
		$answer= array("$userQst1","$userQst1","$userQst2","$userQst3");
		for($i=0;$i<count($userQst);$i++){
		$_list = $control->insertStatus1($userQst[$i],$answer[$i],$number,$brandId,$brandName,$customerid,$customername);
		}  
		 
	}
?>
