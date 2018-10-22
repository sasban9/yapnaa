
<?php 
require_once("config/config.php");
if (isset($_POST['up_csv'])){
		
	$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');
	if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
		if(is_uploaded_file($_FILES['file']['tmp_name'])){
			
			//open uploaded csv file with read only mode
			$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
			$line    = array();
			
			while(!feof($csvFile)){
				$line[] = fgetcsv($csvFile);
			}
			//echo "<br><pre>";print_r($line);
			for($i=0;$i<count($line);$i++){
				if($line[$i][29] == 'NULL' || $line[$i][29] == ''){
					$line[$i][29] = '1970-01-01';
				}
				//check whether member already exists in database with same email
				$prevQuery = "SELECT id FROM zerob_consol1 WHERE PHONE1 = '".$line[$i][8]."'";
					
				$prevResult = connection()->query($prevQuery);
				if($prevResult->num_rows > 0){
					//update member data
					 $db->query("UPDATE zerob_consol1 SET CUSTOMERID = '".$line[$i][1]."',CUSTOMER_NAME='".$line[$i][2]."',CUSTOMER_ADDRESS1='".$line[$i][3]."',CUSTOMER_ADDRESS2='".$line[$i][4]."',CUSTOMER_ADDRESS3='".$line[$i][5]."',CUSTOMER_AREA='".$line[$i][6]."',CUSTOMER_PINCODE='".$line[$i][7]."',PHONE2='".$line[$i][9]."',CUSTOMER_CONTACT_NOS1='".$line[$i][10]."',CUSTOMER_CONTACT_NOS2='".$line[$i][11]."',email = '".$line[$i][12]."',PRODUCT = '".$line[$i][13]."',PRODUCT_SLNO = '".$line[$i][14]."',INSTALLATION_DATE='".$line[$i][15]."',IW='".$line[$i][16]."',IC='".$line[$i][17]."',CONTRACT_FROM='".$line[$i][18]."' ,CONTRACT_TO='".$line[$i][19]."',CONTRACT_TYPE='".$line[$i][20]."',CONTRACT_BY='".$line[$i][21]."',tag='".$line[$i][22]."',amc_updated_by='".$line[$i][23]."',last_called='".$line[$i][24]."',last_call_comment='".$line[$i][25]."',last_sms_sent='".$line[$i][26]."',amc_appointment_datetime='".$line[$i][27]."',status='".$line[$i][28]."' WHERE PHONE1='".$line[$i][8]."'"); 
				}else{
					//"insert member data into database"
					$sql="INSERT INTO zerob_consol1 ( `CUSTOMERID`, `CUSTOMER_NAME`, `CUSTOMER_ADDRESS1`, `CUSTOMER_ADDRESS2`, `CUSTOMER_ADDRESS3`, `CUSTOMER_AREA`, `CUSTOMER_PINCODE`, `PHONE1`, `PHONE2`, `CUSTOMER_CONTACT_NOS1`, `CUSTOMER_CONTACT_NOS2`, `email`, `PRODUCT`, `PRODUCT_SLNO`, `INSTALLATION_DATE`, `IW`, `IC`, `CONTRACT_FROM`, `CONTRACT_TO`,`next_service_date`, `last_service_date`, `CONTRACT_TYPE`, `CONTRACT_BY`, `tag`, `amc_updated_by`, `last_called`, `last_call_comment`, `last_sms_sent`, `amc_appointment_datetime`, `status`,`action_taken_by`,`action_taken_by_id`,`req_service_date`,`req_amc_date`,`req_upgrade_date`,`req_follow_up_date`,`highly_engaged`,`partialy_engaged`,`engaged`,`disinterested`,`mail_status`) VALUES ('".$line[$i][1]."','".$line[$i][2]."','".$line[$i][3]."','".$line[$i][4]."','".$line[$i][5]."','".$line[$i][6]."','".$line[$i][7]."','".$line[$i][8]."','".$line[$i][9]."','".$line[$i][10]."','".$line[$i][11]."','".$line[$i][12]."','".$line[$i][13]."','".$line[$i][14]."','".$line[$i][15]."','".$line[$i][16]."','".$line[$i][17]."','".$line[$i][18]."','".$line[$i][19]."','".$line[$i][20]."','".$line[$i][21]."','".$line[$i][22]."','".$line[$i][23]."','".$line[$i][24]."','".$line[$i][25]."','".$line[$i][26]."','".$line[$i][27]."','".$line[$i][28]."','".$line[$i][29]."','".$line[$i][30]."','".$line[$i][31]."','".$line[$i][32]."','".$line[$i][33]."','".$line[$i][34]."','".$line[$i][35]."','".$line[$i][36]."','".$line[$i][37]."','".$line[$i][38]."','".$line[$i][39]."','".$line[$i][40]."','".$line[$i][41]."')";
					
					//echo $sql; die;
					connection()->query($sql);
					
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
	echo '<script>window.location.assign("zerob_customers.php")</script>'; 

}
	
?>