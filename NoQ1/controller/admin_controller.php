<?php 
 class admin	{
	
	function __construct(){
		global $obj_model; 
		$this->model	=	& $obj_model; 
		date_default_timezone_set('Asia/Kolkata'); 
		global $date; 
		$date			=	date('Y-m-d H:i:s');
		$this->date		=	& $date; 
		
	}
	
	
	function admin_login()
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb0'];
		$admin_email_id		=	 addcslashes($_POST['admin_email_id'], "'");
		$admin_password		=	 md5($_POST['admin_password']); 
		$fields		    	= 	 '*';
		$condition		  	= 	 'sp_password    = ' . "'" . $admin_password . "'" . ' AND sp_email_id = ' . "'" . $admin_email_id . "'";
		$arr_result_test 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result_test);
		if($arr_result_test){
				$condition		  	= 	 'sp_password    = ' . "'" . $admin_password . "'" . ' AND sp_email_id = ' . "'" . $admin_email_id . "'". ' AND sp_status = 1';
				$arr_result_test 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition); 
				
				// echo'<pre>';print_r($arr_result_test);exit;
				if($arr_result_test['sp_status']==1){
					return $arr_result_test;
					// echo'<pre>';print_r($arr_result_test);exit;
				}else{
					return $arr_result_test='1';
					// echo'<pre>';print_r($arr_result_test);exit;
				}
		}else{ 
			return $arr_result_test=''; 
		}
	}
	
	
	
	/*Last Login Time date update*/
	function admin_logout($ad_id)
	{
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb0'];
		$set_array			=	array(
									'sp_last_login'=> $this->date
								);
		// echo'<pre>';print_r($set_array);exit;
		$condition 			=	"sp_id	=	'".$ad_id."'";				
		$result				=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}	
	
	 
	
	
	//adding Main category
	
	function add_main_category()
	{
		
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb1'];
		$mc_title			=	addcslashes($_POST['mc_title'], "'");
		$mc_priority		=	($_POST['mc_priority']); 
		
		
		$fields		    	= 	 'mc_title';
		$condition		  	= 	 'mc_title    = ' . "'" . $mc_title . "'";
		$arr_result		 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		
		if(empty($arr_result)){ 
			//Main category file to move in to folder
			if(!empty($_FILES['mc_image']['tmp_name']))
			{  
				$filename = basename($_FILES['mc_image']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1); 
				$target = "../../admin/admin-views/images/main_category_images/"; 
				//Determine the path to which we want to save this file
				$now = new DateTime();
				$times = $now->getTimestamp();
				$newname = $target.$times.'.'.$ext;  	 
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['mc_image']['tmp_name'],$newname))) {
						$file_name	=	$times.'.'.$ext;
					}else{
						$message	=	"Could not move the file!";
					}
				}
				
			}
			 
			 
			if(!empty($_FILES['mc_icon']['tmp_name']))
			{  
				$filename = basename($_FILES['mc_icon']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1); 
				$target = "../../admin/admin-views/images/main_category_icons/"; 
				//Determine the path to which we want to save this file
				$now = new DateTime();
				$times = $now->getTimestamp();
				$newname = $target.$times.'.'.$ext;  	 
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['mc_icon']['tmp_name'],$newname))) {
						$file_icon	=	$times.'.'.$ext;
					}else{
						$message	=	"Could not move the file!";
					}
				}
				
			}
			
			
			$arr_input	=	array(
							'mc_title'						=>	$mc_title,
							'mc_image'						=>	$file_name, 
							'mc_icon'						=>	$file_icon, 
							'mc_priority'					=>	$mc_priority, 
							'mc_c_date'						=>	$this->date, 
							'mc_status'						=>	1, 
							);
			// echo'<pre>';print_r($arr_input);exit;
			$result				=	$this->model->insert($table_name,$arr_input);
			return $result=1;
		}else{
			return $result=2;
		}
	}
	
	
	
	function get_user_mail($user_list,$subject,$message){

		//echo 'tt';
		/*
		$to= 'hema.jjbytes@gmail.com';
				$subject		=	'testing';
				$message        =	'test';
	            mail($to, $subject, $message);
		*/

	    for($i=0;$i<count($user_list);$i++){
            $user_mail = explode("|",$user_list[$i]);
              //print_r($user_mail);
              //die();
	          if($user_mail[1]){
	              	$to 			= 	$user_mail[1];
					$subject		=	$subject;
					$message		=	'<html>
					<body>
					 <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
					<p>Hi,<strong>' . $user_full_name . '</strong></p>
					<p>'.$message.'</p>
				
					</table>
					</body>
					</html>';
				
						
			        $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
			        $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
			        $headers1 		.= 	"From:admin@gmail.com\r\n";
			        //mail($to, $subject, $message, $headers1);
			        if(mail($to, $subject, $message, $headers1)){
			        	$res =  "1";
			        }
	          }
        } 

      
    	if($res ==1){
          	echo '<script>alert("Mail sent successfully.")</script>';
          	echo '<script>window.location.assign("user_notifications.php")</script>';
      	}
          

	} 

	function sent_noti_user($user_list,$message,$subject){
		
		  	$url = 'https://fcm.googleapis.com/fcm/send';
		  	//$url = 'https://android.googleapis.com/gcm/send';
		  	//$token ="APA91bHFOK3wM8gPSwhw2Y0xrUjy6KgERu2uazBj2Lju4Nb-mPHhPE21g8DJOdQ67aUpFCklViVjg0ADFMHFf_jrUCgQkwyzQvOuVfgbyqkIbPJtO5N9mBb88BwYyCrW9UCaef_csf37";
		    //$token1 =array("APA91bHFOK3wM8gPSwhw2Y0xrUjy6KgERu2uazBj2Lju4Nb-mPHhPE21g8DJOdQ67aUpFCklViVjg0ADFMHFf_jrUCgQkwyzQvOuVfgbyqkIbPJtO5N9mBb88BwYyCrW9UCaef_csf37");
			
			
		/*	{
type:order / general / store / ticket-store,
id: order id in case of orders / null or 0 in case of general / store id in case of store / ticket-store id in case of ticketing
title: New offer on Fresh Buy
Message: Purchase 2 colgate cibaca and get one vim bar free
}
*/
		//print_r($user_list);die();
		$payload = array("type"=>"general","id"=>"0","title"=>$subject,"message"=>$message);
		//$payload	=	 "{'type':'general','id':'test','title':'test','message':'mess'}";
		        $fields = array(
		            'registration_ids' => $user_list,
		            'data' =>$payload
		        );
		      
				/*
				$fields = array(
		            'registration_ids' => array("APA91bEz59FEaokVE1G3DfMl_aIkT0sGpYyuq9Ojgc0FQ3H_2qFAcUTBqn8sbVt8k2ieLkRVG2fU6X1zFwnhAJ8jfW9dG0GkrKIb4Mekiusyj0HSWogA4XktQFYcIXOyYjWHa8qv03l0"),
		            'data' => array('msg'=>"testing")
		        );
		        */
			/*
			$fields = array(
            	'to' => json_encode($token1),
            	'notification' => array('title' => 'Working Good', 'body' => 'That is all we want'),
            	'data' => array('message' => "testing notification")
        	);
        	*/
				//echo '<pre>';
				//print_r($fields);
				//exit;	
				// Update your Google Cloud Messaging API Key 
				//define("GOOGLE_API_KEY", "AIzaSyAInPAdZ7X6YThaHkkQvWhWp3c8qePWOtI"); 
				
				define("GOOGLE_API_KEY", "AIzaSyAS1FOpHcQATfRO_Jl6b4uESvZ_HW5F7kA");
		        $headers = array(
		            'Authorization: key='. GOOGLE_API_KEY,
		            'Content-Type: application/json'
		        );
		        $ch = curl_init();
		        curl_setopt($ch, CURLOPT_URL, $url);
		        curl_setopt($ch, CURLOPT_POST, true);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		        $result = curl_exec($ch);
		        curl_close($ch);

		       echo "<br><br><br><br><br><br>";
			   echo $result;
				$result = json_decode( $result);
				if ($result["success"] != 1 ){
					return false;
				}
				else{
					return true;
				}
				
		        /*				
		        if ($result === FALSE) {
		            die('Curl failed: ' . curl_error($ch));
		        }
				// print_r($result);  exit;
		        curl_close($ch);
		        return $result ;
		        */	


		/*************************************/
		/*for($i=0;$i<count($user_list);$i++){
            $user_gcm = explode("|",$user_list[$i]);
              //print_r($user_mail[1]);
              //die();
            if($user_gcm[3]){
                //$gcm = $this->sendMessageThroughGCM($user_gcm[3],$message);
            	$url = 'https://android.googleapis.com/gcm/send';
		        $fields = array(
		            'registration_ids' => array($user_gcm[3]),
		            'data' => array("msg" => $message)
		        );
				//echo '<pre>';print_r($fields);
				//exit;	
				// Update your Google Cloud Messaging API Key 
				define("GOOGLE_API_KEY", "AIzaSyAS1FOpHcQATfRO_Jl6b4uESvZ_HW5F7kA"); 
		        $headers = array(
		            'Authorization: key='.GOOGLE_API_KEY,
		            'Content-Type: application/json'
		        );
		        $ch = curl_init();
		        curl_setopt($ch, CURLOPT_URL, $url);
		        curl_setopt($ch, CURLOPT_POST, true);
		        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
		        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		        $result = curl_exec($ch);
		        curl_close($ch);

		    }
        }*/
        //echo '<script>alert('.$result.')</script>';

        //echo '<script>alert("Notification sent successfully.")</script>';
        //echo '<script>window.location.assign("user_notifications.php")</script>';	
	}
	
	 
	
		//Get get_user_list 
	function get_user_list()
	{
		$table		=	'users';
		$result	=	$this->model->get_Detail_all($table);
		
		return $result;
	}
	
	
	
	
	function get_main_category_list()
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb1']; 
		$fields	     		=	 '*'; 
		$orderby	     	=	 'mc_id'; 
		$condition	     	=	 'mc_status	=	1 || mc_status	=	0'; 
		$arr_result			= 	 $this->model->get_details_condition_orderby($table_name,$fields,$condition,$orderby);
		// print_r($arr_result_test);exit;
		return $arr_result;
	}
	
	
	
	
	
	
	/* deactive_main_category update*/
	function deactive_main_category()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb1']; 
		$mc_id				=	$_POST['id']; 
		$set_array			=	array(
									'mc_status'		=> 	0
								);
		// print_r($set_array);exit;
		$condition 	=	"mc_id	='".$mc_id."'";				
		$result		=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	
		
	
	/* activate_main_category update*/
	function activate_main_category()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb1']; 
		$mc_id				=	$_POST['id']; 
		$set_array			=	array(
									'mc_status'		=> 1
								);
		// print_r($set_array);exit;
		$condition 	=	"mc_id	='".$mc_id."'";				
		$result		=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	/*Delete the main_category*/
	function delete_main_category()
	{
		$table           	= 	table();
		$mc_id				=	$_POST['id']; 
		$mc_image			=	$_POST['mc_image']; 
		$mc_icon			=	$_POST['mc_icon']; 
		$mc_image			=   '../../admin/admin-views/images/main_category_images/'.$_POST['mc_image'];
		unlink($mc_image);
		$mc_icon			=   '../../admin/admin-views/images/main_category_icons/'.$_POST['mc_icon'];
		unlink($mc_icon);
		$condition			=	"mc_id='$mc_id'";
		$res				=	$this->model->delete_row_data($table_name,$condition);
		return $res;
	}
	
	
	
	
	
	
	//Editing fetch main category details
	function get_main_category_perticular_details_by_id($ad_rest_ref_id)
    {
        $table                 =      table();
        $table_name      	   =     $table['tb1']; 
        $fields                =     '*'; 
        $condition             =     "mc_id    ='".$ad_rest_ref_id."'";        
        $arr_result            =      $this->model->get_all_details_condition($table_name,$fields,$condition);
        // print_r($arr_result);exit;
        return $arr_result;
    }
	
	
	
	
	
	//Update fetch main category details
	function update_main_category()
    {
        
        $table               	=      table();
        $table_name           	=     $table['tb1'];
        $mc_id                	=    ($_POST['id']); 
        $mc_title            	=    addcslashes($_POST['mc_title'], "'");
        $mc_image_name         	=    ($_POST['mc_image_name']); 
        $mc_icon_name         	=    ($_POST['mc_icon_name']); 
        $mc_priority         	=    ($_POST['mc_priority']); 
         
         // echo'<pre>';print_r($arr_input);exit;
         
		$fields                 =      'mc_title';
		$condition              =      'mc_title    = ' . "'" . $mc_title . "'";
		$arr_result             =      $this->model->get_row_details_condition($table_name, $fields, $condition);
	 
       

    //Main category file to move in to folder
		if(!empty($_FILES['mc_icon']['tmp_name']))
		{  
			$filename = basename($_FILES['mc_icon']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1); 
			$target = "../../admin/admin-views/images/main_category_icons/"; 
			//Determine the path to which we want to save this file
			$now = new DateTime();
			$times = $now->getTimestamp();
			$newname = $target.$times.'.'.$ext;      
			if (!file_exists($newname)) {
			//Attempt to move the uploaded file to it's new place
				if ((move_uploaded_file($_FILES['mc_icon']['tmp_name'],$newname))) {
					$file_icon    =    $times.'.'.$ext;
					$path="../../admin/admin-views/images/main_category_icons/".$mc_icon_name;
                    unlink($path);
				}else{
					$message    =    "Could not move the file!";
				}
			}

		}			
          //Main category file to move in to folder
		if(!empty($_FILES['mc_image']['tmp_name']))
		{  
			$filename = basename($_FILES['mc_image']['name']);
			$ext = substr($filename, strrpos($filename, '.') + 1); 
			$target = "../../admin/admin-views/images/main_category_images/"; 
			//Determine the path to which we want to save this file
			$now = new DateTime();
			$times = $now->getTimestamp();
			$newname = $target.$times.'.'.$ext;   
			if (!file_exists($newname)) {
			//Attempt to move the uploaded file to it's new place
				if ((move_uploaded_file($_FILES['mc_image']['tmp_name'],$newname))) {
					$file_name    =    $times.'.'.$ext;
					$path="../../admin/admin-views/images/main_category_images/".$mc_image_name;
                    unlink($path);
				}else{
					$message    =    "Could not move the file!";
				}
			}
		if(empty($arr_result)){
			$arr_input    =    array(
						'mc_title'                        =>    $mc_title,
						'mc_image'                        =>    $file_name, 
						'mc_priority'					  =>	$mc_priority, 
						'mc_icon'            	          =>    $file_icon,    
						); 
		 }else{
			 $arr_input    =    array(
						'mc_image'                        =>    $file_name,    
						'mc_icon'            	          =>    $file_icon,    
						); 
			
		 }
	 
		
		// echo'<pre>';print_r($arr_input);exit;
		
		$condition     			=    "mc_id    ='".$mc_id."'";    
		$result                 =    $this->model->update($table_name,$arr_input,$condition);
		return $result=1;
		
		}else{
		 if(empty($arr_result)){
			  $arr_input    =    array(
						'mc_title'                        =>    $mc_title,  
						'mc_priority'					  =>	$mc_priority,     
						'mc_icon'            	          =>    $file_icon, 
						);
			
		 }else{
			   return $result=2;
		 }
			
		// echo'<pre>';print_r($arr_input);exit;
		
		$condition    		   =    "mc_id    ='".$mc_id."'";    
		$result                =    $this->model->update($table_name,$arr_input,$condition);
		return $result=1;
		}
             
            
         
    }
	
 
	
	
	
	
	function add_sub_category()
	{
		
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb2'];
		$mc_id				=	($_POST['mc_id']);
		$sc_title			=	addcslashes($_POST['sc_title'], "'");
		$sc_priority		=	addcslashes($_POST['sc_priority'], "'");
		
		
		$fields		    	= 	 'sc_title';
		$condition		  	= 	 'sc_title    = ' . "'" . $sc_title . "'";
		$arr_result		 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		
		if(empty($arr_result)){ 
			//Main category file to move in to folder
			if(!empty($_FILES['sc_image']['tmp_name']))
			{  
				$filename = basename($_FILES['sc_image']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1); 
				$target = "../../admin/admin-views/images/sub_category_images/"; 
				//Determine the path to which we want to save this file 
				$now = new DateTime();
				$times = $now->getTimestamp();
				$newname = $target.$times.'.'.$ext;    
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['sc_image']['tmp_name'],$newname))) {
						$file_name	=	$times.'.'.$ext;
					}else{
						$message	=	"Could not move the file!";
					}
				}
				
			}
			 
			$arr_input	=	array(
							'sc_title'						=>	$sc_title,
							'sc_image'						=>	$file_name, 
							'sc_priority'					=>	$sc_priority, 
							'sc_ref_mc_id'					=>	$mc_id, 
							'sc_c_date'						=>	$this->date, 
							);
			// echo'<pre>';print_r($arr_input);exit;
			$result				=	$this->model->insert($table_name,$arr_input);
			return $result=1;
		}else{
			return $result=2;
		}
	}
	
	
	
	
	
		
	function get_sub_category_list()
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb2']; 
		$arr_result			= 	 $this->model->get_sub_category_list($table_name);
		// print_r($arr_result);exit;
		return $arr_result;
	}
	
	
	
	/* deactive_sub_category update*/
	function deactive_sub_category()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb2']; 
		$sc_id				=	$_POST['id']; 
		$set_array			=	array(
									'sc_status'		=> 	0
								);
		// print_r($set_array);exit;
		$condition 	=	"sc_id	='".$sc_id."'";				
		$result		=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	
		
	
	/* activate_main_category update*/
	function activate_sub_category()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb2']; 
		$sc_id				=	$_POST['id']; 
		$set_array			=	array(
									'sc_status'		=> 1
								);
		// print_r($set_array);exit;
		$condition 	=	"sc_id	='".$sc_id."'";				
		$result		=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	/*Delete the main_category*/
	function delete_sub_category()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb2']; 
		$sc_id				=	$_POST['id']; 
		$mc_image			=	$_POST['mc_image']; 
		$mc_image			=   '../../admin/admin-views/images/sub_category_images/'.$_POST['mc_image']; 
		unlink($mc_image);
		$condition			=	"sc_id='$sc_id'";
		$res				=	$this->model->delete_row_data($table_name,$condition); 
		return $res;
	}
	
	
	
	
	function get_sub_category_list_depends_on_mc($id)
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb2']; 
		$fields     		=	 '*'; 
		$condition 			=	 "sc_ref_mc_id 	='".$id."'";		
		$arr_result			= 	 $this->model->get_sub_category_list_by_rest($table_name,$fields,$condition);
		// print_r($arr_result);exit;
		return $arr_result;
	}
	
	
	
			
	function get_sub_category_by_id($id)
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb2']; 
		$fields     		=	 '*'; 
		$condition 			=	 "sc_id	='".$id."'";		
		$arr_result			= 	 $this->model->get_sub_category_list_by_rest($table_name,$fields,$condition);
		// print_r($arr_result);exit;
		return $arr_result;
	}
	
	
	
		
	
	
	function update_sub_category(){
		
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb2'];
		$sc_id				=	($_POST['sc_id']);  
		$sc_title			=	($_POST['sc_title']); ; 
		$mc_image_name		=	($_POST['mc_image_name']); 
		$sc_priority		=	($_POST['sc_priority']); 
		
		  // echo'<pre>';print_r($arr_input);exit;
		 
			$fields		    	= 	 'sc_title';
		    $condition		  	= 	 'sc_title    = ' . "'" . $sc_title . "'";
		    $arr_result		 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);
		 // echo'<pre>';print_r($arr_result);exit;
		
		  //Main category file to move in to folder
			if(!empty($_FILES['sc_image']['tmp_name']))
			{  
				$filename = basename($_FILES['sc_image']['name']);
				$ext = substr($filename, strrpos($filename, '.') + 1); 
				$target = "../../admin/admin-views/images/sub_category_images/"; 
				//Determine the path to which we want to save this file
				$now = new DateTime();
				$times = $now->getTimestamp();
				$newname = $target.$times.'.'.$ext;  
				if (!file_exists($newname)) {
				//Attempt to move the uploaded file to it's new place
					if ((move_uploaded_file($_FILES['sc_image']['tmp_name'],$newname))) {
						$file_name	=	$times.'.'.$ext;
					    $path="../../admin/admin-views/images/sub_category_images/".$mc_image_name;
					    unlink($path);
					}else{
						$message	=	"Could not move the file!";
					}
				}
			if(empty($arr_result)){
				$arr_input	=	array( 
							'sc_title'						=>	$sc_title,
							'sc_image'						=>	$file_name,  
							'sc_priority'					=>	$sc_priority, 
							); 
		     }else{
				 $arr_input	=	array( 
							'sc_image'						=>	$file_name,  
							'sc_priority'					=>	$sc_priority, 
							); 
				
			 }
		   
			$condition 	=	"sc_id	='".$sc_id."'";	
			$result				=	$this->model->update($table_name,$arr_input,$condition);
			return $result=1;
			
			}else{
			 if(empty($arr_result)){
				  $arr_input	=	array( 
							'sc_title'						=>	$sc_title, 
							'sc_priority'					=>	$sc_priority, 
							); 
				$condition 	=	"sc_id	='".$sc_id."'";	
				$result				=	$this->model->update($table_name,$arr_input,$condition);
				return $result=1;
		     }else{
				   $arr_input	=	array( 
							'sc_title'						=>	$sc_title, 
							'sc_priority'					=>	$sc_priority, 
							); 
				$condition 	=	"sc_id	='".$sc_id."'";	
				$result				=	$this->model->update($table_name,$arr_input,$condition);
				return $result;
			 }
			 
			}
			  
			
		 
	}
	
		 
	
	
	//Get Shop List
	function get_business_store_list()
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb3']; 
		$fields	     		=	 '*'; 
		$orderby	     	=	 'b_store_id'; 
		$arr_result			= 	 $this->model->get_business_store_list($table_name,$fields,$orderby); 
		// print_r($arr_result_test);exit;
		return $arr_result;
	}
	
	
	
	
	
	
	/* deactive_business_store update*/
	function deactive_business_store()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb3']; 
		$mc_id				=	$_POST['id']; 
		$set_array			=	array(
									'b_store_status'		=> 	0
								);
		// print_r($set_array);exit;
		$condition 			=	"b_store_id	='".$mc_id."'";				
		$result				=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	
		
		
	
	/* activate_business_store update*/
	function activate_business_store()
	{
		$table           	= 	table();
		$table_name     	=	$table['tb3']; 
		$mc_id				=	$_POST['id']; 
		$set_array			=	array(
									'b_store_status'		=> 1
								);
		// print_r($set_array);exit;
		$condition 			=	"b_store_id	='".$mc_id."'";				
		$result				=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	 
	
	
	  
	
	
	
				
	/* get_user_details_by_id update*/
	function get_store_details_by_id($storeid)
	{
		$table           	= 	table(); 
		$table_name     	=	 $table['tb3'];  
		$fields		    	= 	 '*';
		$condition		  	= 	 'b_store_id    = ' . "'" . $storeid . "'";
		$arr_result_test 	= 	 $this->model->get_store_details_by_id($table_name, $fields, $condition);
		return $arr_result_test;
	}
	
	
	
	
	function get_sub_category_by_mc_id($id)
	{
		
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb2'];  
		$fields		    	= 	 '*';
		$condition			= 	'sc_ref_mc_id    = ' . "'" . $id . "'" . ' AND sc_status = 1'; 
		$arr_result		 	= 	 $this->model->get_all_details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		return $arr_result;
	}
	
	
	
	
	
	
	
	
	
	
	
	
	//Adding Business Store 
	function register_new_business_store()
	{
		
		$table           				= 	 table();
		$table_name  	  				=	 $table['tb3'];
		$b_store_reg_by					=	 addcslashes($_POST['store_reg_by'], "'"); 
		$b_store_name					=	 addcslashes($_POST['store_name'], "'"); 
		$b_store_owner_name				=	 addcslashes($_POST['store_owner_name'], "'"); 
		$b_store_mobile_no				=	 addcslashes($_POST['store_mobile_no'], "'"); 
		$b_store_landline				=	 addcslashes($_POST['store_landline_no'], "'"); 
		$b_store_email					=	 addcslashes($_POST['store_email'], "'"); 
		$b_store_description			=	 addcslashes($_POST['store_description'], "'"); 
		$b_store_address1				=	 addcslashes($_POST['store_address1'], "'"); 
		$b_store_address2				=	 addcslashes($_POST['store_address2'], "'"); 
		$b_store_area					=	 addcslashes($_POST['store_area'], "'"); 
		$b_store_landmark				=	 addcslashes($_POST['store_landmark'], "'"); 
		$b_store_city					=	 addcslashes($_POST['store_city'], "'"); 
		$b_store_state					=	 addcslashes($_POST['store_state'], "'"); 
		$b_store_country				=	 addcslashes($_POST['store_country'], "'"); 
		$b_store_zip					=	 addcslashes($_POST['store_zip'], "'"); 
		$b_store_mobile_no_verified		=	 addcslashes($_POST['store_mobile_verified'], "'"); 
		$b_store_email_verified			=	 addcslashes($_POST['store_email_verified'], "'"); 
		$b_store_has_delivery			=	 addcslashes($_POST['store_delivery'], "'"); 
		$b_store_mc_id					=	 addcslashes($_POST['mc_id'], "'"); 
		$b_store_sc_id					=	 addcslashes($_POST['sub_category_id'], "'"); 
		$b_store_document_prof			=	 addcslashes($_POST['store_document'], "'"); 
		$b_store_lat					=	 addcslashes($_POST['store_latitude'], "'"); 
		$b_store_long					=	 addcslashes($_POST['store_longitude'], "'"); 
		$b_store_working_days			=	 implode(",",$_POST['store_working_days']);   
		$b_store_working_hours_from_time=	 addcslashes($_POST['store_working_hours_from_time'], "'"); 
		$b_store_working_hours_end_time	=	 addcslashes($_POST['store_working_hours_end_time'], "'"); 
		$b_store_reg_device				=	 addcslashes($_POST['store_reg_device'], "'"); 
		$b_store_priority				=	 addcslashes($_POST['store_priority'], "'"); 
		$b_store_class					=	 addcslashes($_POST['store_class'], "'"); 
		$b_store_business_type			=	 addcslashes($_POST['b_store_business_type'], "'"); 
		
		
		
		$fields		    	= 	 'b_store_mobile_no';
		$condition		  	= 	 'b_store_mobile_no    = ' . "'" . $b_store_mobile_no . "'";
		$arr_result		 	= 	 $this->model->get_row_details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		

		
		if(empty($arr_result)){   
		
		
				if(!empty($_FILES['b_store_image']['tmp_name']))
				{  
					$filename = basename($_FILES['b_store_image']['name']);
					$ext = substr($filename, strrpos($filename, '.') + 1); 
					$target = "../../admin/admin-views/images/business_stores/"; 
					//Determine the path to which we want to save this file
					$now = new DateTime();
					$times = $now->getTimestamp();
					$newname = $target.$times.'.'.$ext;      
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['b_store_image']['tmp_name'],$newname))) {
							$b_store_image    =    $times.'.'.$ext; 
							
						}else{
							$message    =    "Could not move the file!";
						}
					}

				}	
					
			$password			=	'1234';		
			$set_array			=	array(  
									'b_store_name' 						=> $b_store_name,
									'b_store_owner_name' 				=> $b_store_owner_name,
									'b_store_password' 					=> md5($password),
									'b_store_email' 					=> $b_store_email, 
									'b_store_description'				=> $b_store_description, 
									'b_store_mobile_no'					=> $b_store_mobile_no,   
									'b_store_landline'					=> $b_store_landline,    
									'b_store_address1'					=> $b_store_address1,       
									'b_store_address2'					=> $b_store_address2,       
									'b_store_area'						=> $b_store_area,       
									'b_store_landmark'					=> $b_store_landmark,       
									'b_store_city'						=> $b_store_city,       
									'b_store_state'						=> $b_store_state,       
									'b_store_country'					=> $b_store_country,       
									'b_store_zip'						=> $b_store_zip,       
									'b_store_mobile_no_verified'		=> $b_store_mobile_no_verified,      
									'b_store_email_verified'			=> $b_store_email_verified,     
									'b_store_has_delivery'				=> $b_store_has_delivery,     
									'b_store_mc_id'						=> $b_store_mc_id,     
									'b_store_sc_id'						=> $b_store_sc_id,      
									'b_store_document_prof'				=> $b_store_document_prof,      
									'b_store_lat'						=> $b_store_lat,      
									'b_store_long'						=> $b_store_long,      
									'b_store_working_days'				=> $b_store_working_days,      
									'b_store_working_hours_from_time'	=> $b_store_working_hours_from_time,      
									'b_store_working_hours_end_time'	=> $b_store_working_hours_end_time,       
									'b_store_priority'					=> $b_store_priority,      
									'b_store_category_class'			=> $b_store_class,        
									'b_store_reg_by'					=> $b_store_reg_by,      
									'b_store_reg_device'				=> $b_store_reg_device,      
									'b_store_image'						=> @$b_store_image,      
									'b_store_business_type'				=> $b_store_business_type,      
									'b_store_status'					=> 1,      
									'b_store_registration_date'			=>	$this->date,     
									   
								);
			// echo'<pre>';print_r($set_array);exit;
	
			
			$result				=	$this->model->insert($table_name,$set_array);
			
			if($result){ 
				$mc_id				=	$result; 
				$set_array			=	array(
											'b_store_unique_id'		=> "BSV".$result
										); 
				$condition 			=	"b_store_id	='".$result."'";				
				$result				=	$this->model->update($table_name,$set_array,$condition);
				
			}
			
			
			
			
			
			// E-Mail To User
			$to 			= 	$b_store_email;
			$subject		=	"Registration done succesfully.";
			$message		=	'<html>
									<body>
										<table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
											<p>Mobile No:,<strong>' . $b_store_mobile_no . '</strong></p>
											<p> Thank you for registring with us.</p>
											<p>Password: <strong>' . $password . '</strong></p>
										</table>
									</body>
								</html>';
	
			
            $headers1 		= 	"MIME-Version: 1.0" . "\r\n";
					
            $headers1 		.= 	"Content-type:text/html;charset=iso-8859-1" . "\r\n";
            
            $headers1 		.= 	"From:admin@gmail.com\r\n";
            
            if (mail($to, $subject, $message, $headers1)) {
				$file = fopen("/var/www/html/5.txt","w");
				fwrite($file,"email send");
				fclose($file);
				return $fields_reg;
            }			
			
			return $fields_reg;
			
			
			
			return $result=1;
		}else{
			return $result=2;
		}
	}
	
	
	
	
	
	/* update_business_store update*/
	function update_business_store()
	{
		$table           				= 	table();
		$table_name     				=	$table['tb3']; 
		$b_store_id						=	$_POST['store_id']; 
		$b_store_name					=	$_POST['store_name'];  
		$b_store_owner_name				=	$_POST['store_owner_name'];  
		$b_store_mobile_no				=	$_POST['store_mobile_no'];  
		$b_store_landline				=	$_POST['store_landline_no'];  
		$b_store_email					=	$_POST['store_email'];  
		$b_store_description			=	$_POST['store_description'];  
		$b_store_address1				=	$_POST['store_address'];   
		$b_store_address2				=	$_POST['store_address2']; 
		$b_store_area					=	$_POST['store_area']; 
		$b_store_landmark				=	$_POST['store_landmark']; 
		$b_store_city					=	$_POST['store_city']; 
		$b_store_state					=	$_POST['store_state']; 
		$b_store_country				=	$_POST['store_country']; 
		$b_store_zip					=	$_POST['store_zip']; 
		$b_store_mobile_no_verified		=	$_POST['store_mobile_verified'];  
		$b_store_email_verified			=	$_POST['store_email_verified'];  
		$b_store_has_delivery			=	$_POST['store_delivery'];  
		$b_store_mc_id					=	$_POST['mc_id'];  
		$b_store_sc_id					=	$_POST['sub_category_id'];   
		$b_store_document_prof			=	$_POST['store_document'];  
		$b_store_lat					=	$_POST['store_latitude'];  
		$b_store_long					=	$_POST['store_longitude'];  
		$b_store_working_days			=	implode(",",$_POST['store_working_days']);   
		$b_store_working_hours_from_time=	$_POST['store_working_hours_from_time'];  
		$b_store_working_hours_end_time	=	$_POST['store_working_hours_end_time'];  
		$b_store_priority				=	$_POST['store_priority1'];   
		$store_class					=	$_POST['store_class'];   
		
			if(!empty($_FILES['b_store_image']['tmp_name']))
				{  
					$filename = basename($_FILES['b_store_image']['name']);
					$ext = substr($filename, strrpos($filename, '.') + 1); 
					$target = "../../admin/admin-views/images/business_stores/"; 
					//Determine the path to which we want to save this file
					$now = new DateTime();
					$times = $now->getTimestamp();
					$newname = $target.$times.'.'.$ext;      
					if (!file_exists($newname)) {
					//Attempt to move the uploaded file to it's new place
						if ((move_uploaded_file($_FILES['b_store_image']['tmp_name'],$newname))) {
							$b_store_image    =    $times.'.'.$ext; 
							
						}else{
							$message    =    "Could not move the file!";
						}
					}

				}	
		
		$set_array		=	array(  
								'b_store_name' 						=> $b_store_name,
								'b_store_owner_name' 				=> $b_store_owner_name,
								'b_store_email' 					=> $b_store_email, 
								'b_store_description'				=> $b_store_description, 
								'b_store_mobile_no'					=> $b_store_mobile_no,   
								'b_store_landline'					=> $b_store_landline,    
								'b_store_address1'					=> $b_store_address1,       
								'b_store_address2'					=> $b_store_address2,       
								'b_store_area'						=> $b_store_area,       
								'b_store_landmark'					=> $b_store_landmark,       
								'b_store_city'						=> $b_store_city,       
								'b_store_state'						=> $b_store_state,       
								'b_store_country'					=> $b_store_country,           
								'b_store_zip'						=> $b_store_zip,       
								'b_store_mobile_no_verified'		=> $b_store_mobile_no_verified,      
								'b_store_email_verified'			=> $b_store_email_verified,     
								'b_store_has_delivery'				=> $b_store_has_delivery,     
								'b_store_mc_id'						=> $b_store_mc_id,     
								'b_store_sc_id'						=> $b_store_sc_id,      
								'b_store_document_prof'				=> $b_store_document_prof,      
								'b_store_lat'						=> $b_store_lat,      
								'b_store_long'						=> $b_store_long,      
								'b_store_working_days'				=> $b_store_working_days,      
								'b_store_working_hours_from_time'	=> $b_store_working_hours_from_time,      
								'b_store_working_hours_end_time'	=> $b_store_working_hours_end_time,   
								'b_store_priority'					=> $b_store_priority,   
								'b_store_image'						=> $b_store_image 
								   
							);
		// echo '<pre>';print_r($set_array);exit;
		$condition 			=	"b_store_id	='".$b_store_id."'";				
		$result				=	$this->model->update($table_name,$set_array,$condition);
		return $result;
	}
	
	
	
	
	
	
	 
	
	
		
	
	
					
	function get_tickets_list_admin($b_store_id)
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb10'];   
		$fields				= 	 "*"; 
		$condition		  	= 	 'ticket_order_store_ref_id    = ' . "'" . $b_store_id . "'";
		$arr_result_test 	= 	 $this->model->get_tickets_list_admin($table_name, $fields, $condition);
		return $arr_result_test; 
	}
	
	
	
	
	
	 
	
	
	function users_list($id)
	{
		
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb7'];  
		$fields		    	= 	 '*';
		$condition			= 	'user_status =0 or user_status = 1'; 
		$arr_result		 	= 	 $this->model->get_all_details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		return $arr_result;
	}

	function all_user_cart_details_admin()
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb5'];   
		$fields				= 	 "*"; 
		//$condition		  	= 	 'user_cart_store_ref_id    = ' . "'" . $b_store_id . "'";
		//$arr_result_test 	= 	 $this->model->all_user_cart_details_admin($table_name, $fields);
		$arr_result_test 	= 	 $this->model->all_user_cart_details_admin($table_name);
		return $arr_result_test; 
	}
	
	function all_get_order_list_by_store_id()
	{
		
		$table           	= 	 table();
		$table_name     	=	 $table['tb13'];    
		$fields		    	= 	 '*';
		//$condition		  	= 	 'order_store_ref_id    = ' . "'" . $b_store_id . "'";
		$orderby		  	= 	 'order_id';
		//$arr_result_test 	= 	 $this->model->all_get_order_list_by_store_id($table_name,$fields,$condition,$orderby); 
		$arr_result_test 	= 	 $this->model->all_get_order_list_by_store_id($table_name); 
		
		return $arr_result_test; 
	}

	function get_order_list_details_by_id($order_id)
	{
		$table           	= 	 table();
		$table_name     	=	 $table['tb13'];    
		$fields		    	= 	 '*';
		//$condition		  	= 	 'o.order_id    = ' .$order_id;
		$condition		  	= 	 $order_id;
		$orderby		  	= 	 'order_id';
		$arr_result_test 	= 	 $this->model->get_order_list_details_by_id($table_name,$fields,$condition,$orderby); 
		return $arr_result_test; 
	}

	function get_user_details($uid){

		$table           	= 	 table();
		$table_name  	  	=	 $table['tb7'];  
		$fields		    	= 	 '*';
		$condition			= 	'user_id='.$uid; 
		$arr_result		 	= 	 $this->model->get_Details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		return $arr_result;

	}

	function get_users_curentday_count(){

		$table           	= 	 table();
		$table_name  	  	=	 $table['tb7'];  
		$arr_result		 	= 	 $this->model->get_users_curentday_count($table_name);
		return $arr_result;

	}

	function get_users_weekly_count(){

		$table           	= 	 table();
		$table_name  	  	=	 $table['tb7'];  
		$arr_result		 	= 	 $this->model->get_users_weekly_count($table_name);
		return $arr_result;

	}

	function get_users_monthly_count(){

		$table           	= 	 table();
		$table_name  	  	=	 $table['tb7'];  
		$arr_result		 	= 	 $this->model->get_users_monthly_count($table_name);
		return $arr_result;

	}
	
	function get_users_yearly_count(){

		$table           	= 	 table();
		$table_name  	  	=	 $table['tb7'];  
		$arr_result		 	= 	 $this->model->get_users_yearly_count($table_name);
		return $arr_result;

	}
	function get_users_last_yearly_count(){
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb7'];  
		$arr_result		 	= 	 $this->model->get_users_last_yearly_count($table_name);
		return $arr_result;
	}

	function all_success_order_list(){
		$table           	= 	 table();
		$table_name     	=	 $table['tb13']; 
		$arr_result		 	= 	 $this->model->all_order_sucess_list($table_name);
		return $arr_result; 

	}
	
	function get_all_product_list(){
		/*
		$table           	= 	 table();
		$table_name     	=	 $table['tb13']; 
		$arr_result		 	= 	 $this->model->all_product_sucess_list($table_name);
		return $arr_result; 
		*/
		$table           	= 	 table();
		$table_name     	=	 $table['tb4']; 
		$arr_result_test 	= 	 $this->model->get_Detail_all($table_name);
		return $arr_result_test;

	}

	function get_all_product_sale_count($pid){
		//echo $pid;
		//die();
		$table           	= 	 table();
		$table_name     	=	 $table['tb13']; 
		$arr_result		 	= 	 $this->model->get_all_product_sale_count($table_name,$pid);
		return $arr_result;

	}

	function get_all_product_salecount(){
		$table           	= 	 table();
		$table_name     	=	 $table['tb13']; 
		$arr_result		 	= 	 $this->model->get_all_product_salecount();
		return $arr_result;
	}
	 
	function get_coupons_list(){
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb16']; 
		$arr_result		 	= 	 $this->model->get_Detail_all($table_name);
		// echo'<pre>';print_r($arr_result);exit;
		return $arr_result;
	}
	
	/*
	function coupon_already_exists($c_code){
		$table           	= 	 table();
		$table_name  	  	=	 $table['tb16'];  
		$fields		    	= 	'coup_code';
		$condition			= 	'coup_code='.$c_code; 
		$arr_result		 	= 	 $this->model->get_Details_condition($table_name, $fields, $condition);
		// echo'<pre>';print_r($arr_result);exit;
		$result  = count($arr_result);
		return $result;
	}
	*/

	function add_coupons(){
		$table           	= table();
		$table_name     	= $table['tb16'];
		$coup_code  		= $_POST['coup_code'];
		$coup_type  		= $_POST['coup_type'];
		$coup_amount 		= $_POST['coup_amount'];
		$coup_min_pur_amt 	= $_POST['coup_min_pur_amt'];

		//
	 
		$fields		    	= 	'coup_code';
		$condition			= 	'coup_code="'.$coup_code.'"'; 
		$arr_result		 	= 	 $this->model->get_Details_condition($table_name, $fields, $condition);
		 //echo'<pre>';print_r($arr_result);exit;
		$result  = count($arr_result);
		if($result >0){
           $result_list = "em";
		}else{


           $coup_list = array(
	           	'coup_code'		=> $coup_code,
	           	'coup_type'		=> $coup_type,
	           	'coup_amount'	=> $coup_amount,
	           	'coup_pur_amt'	=> $coup_min_pur_amt
           	);

			$result_list				=	$this->model->insert($table_name,$coup_list); 
	    }
		//print_r($result);
           //die();
		return $result_list; 
	}

	function add_store_product()
	{ 
		$table           	= 	 table();
		$table_name     	=	 $table['tb4'];
		  
		$p_b_store_id					=	$_POST['p_b_store_id'];  
		$p_product_title				=	$_POST['p_product_title'];  
		$p_brand_id						=	$_POST['p_brand_id'];  
		$p_MRP							=	$_POST['p_MRP'];  
		$p_discount						=	$_POST['p_discount'];  
		$p_discount_price				=	$_POST['p_discount_price'];  
		$p_product_description			=	$_POST['p_product_description'];  
		$p_short_description			=	$_POST['p_short_description'];  
		$p_product_barcode_no			=	$_POST['p_product_barcode_no'];  
		$p_SKU							=	$_POST['p_SKU'];  
		
		$set_array			=	array(
									'p_b_store_id'						=> $p_b_store_id,
									'p_product_title'					=> $p_product_title,
									'p_brand_id'						=> $p_brand_id,
									'p_MRP'								=> $p_MRP,
									'p_discount_percentage'				=> $p_discount,
									'p_discount_price'					=> $p_discount_price,
									'p_product_description'				=> $p_product_description,
									'p_short_description'				=> $p_short_description,
									'p_product_barcode_no'				=> $p_product_barcode_no,
									'p_SKU'								=> $p_SKU,
									'p_status'							=> 1,
									'p_c_date'							=> $this->date,     
								); 
								
		// print_r($set_array);exit;						
								
		$result				=	$this->model->insert($table_name,$set_array);  	
		return $result;  
	}


	function get_all_order_list(){
		$table           	= 	 table();
		$table_name     	=	 $table['tb13']; 
		$arr_result		 	= 	 $this->model->get_all_order_list();
		return $arr_result;


	}
	 
}

?>