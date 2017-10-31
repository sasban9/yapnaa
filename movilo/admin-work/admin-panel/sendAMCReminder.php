<?php

require_once('controller/admin_controller.php');
$control	=	new admin();

$get_AMCExpiry_7_Days_list = $control->AMCExpiry_7_Days();


?>