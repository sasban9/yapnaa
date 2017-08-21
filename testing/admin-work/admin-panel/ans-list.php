<?php 
require_once('controller/admin_controller.php');
$control	=	new admin();
unset($_POST['ans'][0]);
// print_r($_POST['ans']); 
$user_id	=	$_POST['user_id'];
$p_id		=	 $_POST['p_id'];
$stack		=	array();
for($i=0;$i<=count($_POST['ans']);$i++){
	if($_POST['ans'][$i]){
		$ans		.=	$_POST['ans'][$i].',';	
	}else{
		if($i!=0){
			$ans		.=	(0).',';	
		}
	}
 array_push($stack,($i+1));
}
trim($ans, ","); 
array_pop($stack); 
$que	=	implode(',',$stack);
trim($que, ","); 
if($que){ 	
	$user_srm_question_answers = $control->user_srm_question_answers($user_id,$p_id,$que,$ans);
} 
if($user_srm_question_answers)
{	
	echo "1";
}else{	
	echo "0";
}
?>