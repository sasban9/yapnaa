<html>
<body>
<form  method="post" enctype="multipart/form-data">
    <label for="file">Filename:</label>
    <input type="file" name="file" id="file" />
	<input type="text" name="up_csv" hidden="hidden"> 
    <input type="submit" name="submit" value="Submit" />
</form>
</body>
</html>
<?php 
require_once("config/config.php");

if (isset($_POST['up_csv'])) 
	{
		
		  $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
			if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
				
				if(is_uploaded_file($_FILES['file']['tmp_name'])){
					
					//open uploaded csv file with read only mode
					$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
					$line    = array();
					while(!feof($csvFile)){
							$line[] = fgetcsv($csvFile);
						}
						//print_r($line);exit;
						for($i=0;$i<count($line);$i++){
						switch($line[$i][5]){
							case 'Taken AMC':
							$line[$i][5]='Yes';
							$prevResult7 = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and qst_id=2");
							if($prevResult7->num_rows > 0){
								//update member data
								
								 connection()->query("UPDATE user_question_aws_mapping SET answer = '".$line[$i][5]."' where qst_id=2 and user_phone='".$line[$i][3]."'"); 
							}else{
								//"insert member data into database"
								connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('2','".$line[$i][3]."','".$line[$i][5]."','livpure','1','now()')");
							}
							break;
							case 'Interested':
							$line[$i][5]='Yes';
							$prevResult8 = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and (qst_id=18 or qst_id=19)");
							if($prevResult8->num_rows > 0){
								//update member data								
								 connection()->query("UPDATE user_question_aws_mapping SET answer = '".$line[$i][5]."' where qst_id=18 and  qst_id=19 and user_phone='".$line[$i][3]."'"); 
							}else{
								//"insert member data into database"
								connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('18','".$line[$i][3]."','".$line[$i][5]."','livpure','1','now()')");
								connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('19','".$line[$i][3]."','".$line[$i][5]."','livpure','1','now()')");
							}
							$prevResult13 = connection()->query("SELECT id FROM livpure WHERE PHONE1 = '".$line[$i][3]."' and last_call_comment=''");
							if($prevResult13->num_rows > 0){ 
								//update member data
								$apponintment='Service Appointment -'.$line[$i][4];
								 connection()->query("UPDATE livpure SET last_call_comment = '".$apponintment.",'req_service_date='".$line[$i][4]."',status=3 where  PHONE1='".$line[$i][3]."'"); 
							}
							break;
							case 'Paid service':
							$line[$i][5]='Yes';
							$prevResult9 = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and qst_id=17");
							if($prevResult9->num_rows > 0){
								//update member data								
								 connection()->query("UPDATE user_question_aws_mapping SET answer = '".$line[$i][5]."' where qst_id=17 and user_phone='".$line[$i][3]."'"); 
							}else{
								//"insert member data into database"
								connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('17','".$line[$i][3]."','".$line[$i][5]."','livpure','1','now()')");
							}
							$prevResult12 = connection()->query("SELECT id FROM livpure WHERE PHONE1 = '".$line[$i][3]."' and last_call_comment=''");
							if($prevResult12->num_rows > 0){ 
								//update member data
								$apponintment='AMC Appointment -'.$line[$i][4]; 
								 connection()->query("UPDATE livpure SET last_call_comment = '".$apponintment."',req_amc_date='".$line[$i][4]."',status=3 where  PHONE1='".$line[$i][3]."'"); 
							}
							break;
							case 'Call back':
							$line[$i][5]='Call back';
							$prevResult11 = connection()->query("SELECT id FROM livpure WHERE PHONE1 = '".$line[$i][3]."' and last_call_comment=''");
							if($prevResult11->num_rows > 0){ 
								//update member data								
								 connection()->query("UPDATE livpure SET last_call_comment = '".$line[$i][5]."',status=1 where  PHONE1='".$line[$i][3]."'"); 
							}
							break;
							case 'Upgrade':							
							$apponintment='Upgrade Appointment -'.$line[$i][4];
							$prevResult14 = connection()->query("SELECT id FROM livpure WHERE PHONE1 = '".$line[$i][3]."' and last_call_comment=''");
							if($prevResult14->num_rows > 0){ 
								//update member data								
								 connection()->query("UPDATE livpure SET last_call_comment = '".$apponintment.",'req_upgrade_date='".$line[$i][4]."',,status=3 where  PHONE1='".$line[$i][3]."'"); 
							}
							break;
							case 'Not interested':
							$line[$i][5]='Service not required';
							$prevResult10 = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and qst_id=8");
							if($prevResult10->num_rows > 0){
								//update member data								
								 connection()->query("UPDATE user_question_aws_mapping SET answer = '".$line[$i][5]."' where qst_id=8 and user_phone='".$line[$i][3]."'"); 
							}else{
								//"insert member data into database"
								connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('8','".$line[$i][3]."','".$line[$i][5]."','livpure','1','now()')");
							}
							break;	
						}
						if($line[$i][5] !='Call back'){
						$line[$i][7]=($line[$i][7]=='Yes')?$line[$i][7]:'No';
						$line[$i][8]=($line[$i][8]=='Yes')?$line[$i][8]:'No';						
						$line[$i][11]=($line[$i][11]=='Yes')?$line[$i][11]:'No';
						}else{
							$line[$i][7]='';
							$line[$i][8]='';
							$line[$i][11]='';
						}
						//check whether member already exists in database with same email
						$prevResult = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and qst_id=1");
						$prevResult1 = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and qst_id=3");
						$prevResult2 = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and qst_id=4");
						$prevResult3 = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and qst_id=2");
						$prevResult4 = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and qst_id=12");
						$prevResult5 = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and qst_id=7");
						$prevResult6 = connection()->query("SELECT id FROM user_question_aws_mapping WHERE user_phone = '".$line[$i][3]."' and qst_id=19");
						if($prevResult->num_rows > 0){
							//update member data
							
							 connection()->query("UPDATE user_question_aws_mapping SET answer = '".$line[$i][6]."' where qst_id=1 and user_phone='".$line[$i][3]."'"); 
						}else{
							//"insert member data into database"
							connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('1','".$line[$i][3]."','".$line[$i][6]."','livpure','1','now()')");
						}
						if($prevResult1->num_rows > 0 || $prevResult2->num_rows > 0){
							//update member data
							 connection()->query("UPDATE user_question_aws_mapping SET answer = '".$line[$i][7]."' where qst_id=3 and qst_id=4 and  user_phone='".$line[$i][3]."'"); 
						}else{
							//"insert member data into database"
							connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('3','".$line[$i][3]."','".$line[$i][7]."','livpure','1','now()')");
							connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('4','".$line[$i][3]."','".$line[$i][7]."','livpure','1','now()')");
						}
						if($prevResult3->num_rows > 0 ){
							//update member data
							 connection()->query("UPDATE user_question_aws_mapping SET answer = '".$line[$i][8]."' where qst_id=2 and  user_phone='".$line[$i][3]."'"); 
						}else{
							//"insert member data into database"
							connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('2','".$line[$i][3]."','".$line[$i][8]."','livpure','1','now()')");
							
						}
						if($prevResult4->num_rows > 0 ){
							//update member data
							 connection()->query("UPDATE user_question_aws_mapping SET answer = '".$line[$i][11]."' where qst_id=12 and  user_phone='".$line[$i][3]."'"); 
						}else{
							//"insert member data into database"
							connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('12','".$line[$i][3]."','".$line[$i][11]."','livpure','1','now()')");
							
						}
						if($prevResult5->num_rows > 0 ){
							//update member data
							 connection()->query("UPDATE user_question_aws_mapping SET answer = '".$line[$i][9]."' where qst_id=7 and  user_phone='".$line[$i][3]."'"); 
						}else{
							//"insert member data into database"
							connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('7','".$line[$i][3]."','".$line[$i][9]."','livpure','1','now()')");
							
						}
						if($prevResult6->num_rows > 0 ){
							//update member data
							 connection()->query("UPDATE user_question_aws_mapping SET answer = '".$line[$i][10]."' where qst_id=19 and  user_phone='".$line[$i][3]."'"); 
						}else{
							//"insert member data into database"
							connection()->query("INSERT INTO `user_question_aws_mapping`(`qst_id`, `user_phone`, `answer`, `brand_name`, `brand_id`, `date`) VALUES ('19','".$line[$i][3]."','".$line[$i][10]."','livpure','1','now()')");
							
						}
					}
					
					
					//close opened csv file
					fclose($csvFile);
					$qstring = '?status=succ'; 
				}else{
					$qstring = '?status=err';
				}
			}else{
				$qstring = '?status=invalid_file';
			}
		

		//redirect to the listing page 
	    echo '<script>alert("CSV Uploaded Successfully.")</script>';
		
	}
	
	?>