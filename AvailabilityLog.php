<?php
header('Access-Control-Allow-Origin: *');
include 'DBfile.php';
$userid=$_REQUEST["userid"];
//$in_time=$_REQUEST['in_time']; 
//$out_time=$_REQUEST['out_time'];
$id=$_REQUEST['id'];
$availability=$_REQUEST['availability'];//action = available, not-avaialble
$action=$_REQUEST['action'];


//echo $id;
$date = new DateTime();
$newdate=$date->getTimestamp();
//echo $newdate;
 $date->setTimestamp($newdate);
 $time=$date->format('Y-m-d H:i:s');


 $queryString = "select * from availability_log where userid = '".$userid."' and id =(select max(id) as id from (select * from availability_log where userid = '".$userid."') temp)";
$allowPush = true;
$queryPush = "SELECT distinct U.deviceid from userdetails U";
$resultPush = $conn->query($queryPush);

$previousStatusSql = "SELECT * FROM `availability` where userid='".$userid."' ";
$resultPrevSt = $conn->query($previousStatusSql);
$previousStatus = "unknown";
if ($resultPrevSt->num_rows == 1) {
	while($row = $resultPrevSt->fetch_assoc())
		{	
			$previousStatus = $row["status"];
			echo "previous state: ".$previousStatus;
		}
}
mysqli_free_result($resultPrevSt);

$apsQuery="select userid,username,status,role,image,mobile_image from userdetails  NATURAL join availability where userdetails.userid = '".$userid."' and userdetails.userid=availability.userid";
$resultAPS = $conn->query($apsQuery);


 if($availability=="Yes"){
        echo "I AM HERE";
	 	if($action == "insert" && $previousStatus != "Yes") {
	 		echo " INSIDE INSERT";
	 		$result = $conn->query($queryString);
			if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{		
				
					if($row["out_time"] == NULL || $row["in_time"] == ".$time.") {
						$allowPush = false;
					}
				}
			}
			mysqli_free_result($result);
			
			if ($allowPush == true) {
		 		$sql="Insert into availability_log(id,userid,in_time,out_time) values(Null, '".$userid."','".$time."', Null);";
		 		//echo $sql;
		 		$result=$conn->query($sql);
		 		$last_id = $conn->insert_id;
		 		//$last_id["id"] = $conn->insert_id;
		 		//$data=array("Inserted_id"=>$last_id);
		 	
		 		$sql2 ="update `availability` set status='Yes' where userid='".$userid."' ";
		 		$result=$conn->query($sql2);
		 		echo "Inserted id:$last_id";

   /*****************************************/
			$dataAPS = array();
			    if ($resultAPS->num_rows == 1) {
				while($row = $resultAPS->fetch_assoc())
					{	
						$dataAPS = $row;
					}
				}
			    mysqli_free_result($resultAPS);

					if($resultPush->num_rows>0)
				{
					while($row = $resultPush->fetch_assoc())
					{	
						if ($row["deviceid"] != "abc") {
							sendNotification($row["deviceid"], $dataAPS);
						}
					}
				}

			 		//applePush();
		 	} else {
		 			echo "row not inserted as out_time is empty";
		 		}
		 	}
	/*****************************************/ 	
	 	elseif($action=="update"){

			if ($allowPush == true) {
		 		$sql1="UPDATE availability_log,(select max(id) as max_id from availability_log where userid='".$userid."') as q set out_time='".$time."' where id=q.max_id ";
		 		$result1=$conn->query($sql1);
		 		$changed_rows=$conn->affected_rows;
		 		if($changed_rows>=1){
		 			echo  "Updated Successfully";
		 		}
		 		else{
		 			echo "Updation Failed";
		 		}

   /*****************************************/
		if($resultPush->num_rows>0)
	{
		while($row = $resultPush->fetch_assoc())
		{	echo "while!";
			if ($row["deviceid"] != "abc") {
				sendNotification($row["deviceid"]);
			}
		}
	}

		 		//applePush();
	 		}
	    }
	 	/* else{
	 		echo "please enter valid details";
	 	} */
	 	
 }	
 	
elseif($availability=="No" && $previousStatus != "No"){
	echo "INSIDE NO";
	$result=$conn->query($queryString);
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{				
			if($row["out_time"] != NULL) {
				$allowPush = false;
			}
		}
	}
	mysqli_free_result($result);

	if ($allowPush == true) {
		$sql3 ="update `availability` set status='No' where userid='".$userid."' ";
		$result=$conn->query($sql3);
		
		$sql4 ="UPDATE availability_log,(select max(id) as max_id from availability_log where userid='".$userid."') as q set out_time='".$time."' where id=q.max_id ";
		$result=$conn->query($sql4);
		
		echo "Status changed";
        /*****************************************/

$dataAPS = array();
    if ($resultAPS->num_rows == 1) {
	while($row = $resultAPS->fetch_assoc())
		{	
			$dataAPS = $row;
		}
	}
    mysqli_free_result($resultAPS);

		if($resultPush->num_rows>0)
	{
		while($row = $resultPush->fetch_assoc())
		{	
			if ($row["deviceid"] != "abc") {
				sendNotification($row["deviceid"], $dataAPS);
			}
		}
	}

		if($resultPush->num_rows>0)
	{
		while($row = $resultPush->fetch_assoc())
		{	echo "while!";
			if ($row["deviceid"] != "abc") {
				sendNotification($row["deviceid"]);
			}
		}
	}
/*****************************************/
		//applePush();
	} else {
		echo "row not inserted as out_time is not empty";
	}	
} else {
	echo "row not inserted";
}	

mysqli_free_result($resultPush);
/*
function controlPush() {
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)
	OR die ('Could not connect to MySQL: '.mysql_error());
	$temp = true;
	if ($conn->connect_error)
	{
		die("Connection failed: " . $conn->connect_error);
	} else { 
		$result=$conn->query($queryString);
		if($result->num_rows>0)
		{
			while($row = $result->fetch_assoc())
			{
				
				if($availability == "Yes" && $action == "insert" && $row["out_time"] == NULL) {
					$temp = false; echo "heerr";
				} elseif($availability == "No" && $action == "update" && $row["out_time"] != NULL) {
					$temp = false;
				}
			}
		}
		mysqli_free_result($result);
	}
	return $temp;
}


function applePush() {
	$dataAPS = array();
    if ($resultAPS->num_rows == 1) {
	while($row = $resultAPS->fetch_assoc())
		{	
			$dataAPS = $row;
		}
	}
    mysqli_free_result($resultAPS);
	echo "hello apple!";
	echo $resultPush;
	if($resultPush->num_rows>0)
	{
		while($row = $resultPush->fetch_assoc())
		{	echo "while!";
			if ($row["deviceid"] != "abc") {
				sendNotification($row["deviceid"], $dataAPS);
			}
		}
	}
	mysqli_free_result($resultPush);
}
*/

function sendNotification($deviceToken, $dataAPS) {
	//$deviceToken =  '7B825AA7495C4477F1ED02F67D7AEFD5FB8FBFC98879CD55BE33489D6D0C4148'; //Rahul's iPhone
	$passphrase = '';
	echo $dataAPS["username"];
	$greet = "Welcome";
	if ($dataAPS["status"] == "No") {
		$greet = "Bye";
	}
	$message = $greet." ".$dataAPS["username"];
	$gateway = '';
	/*if ($production) {
    	$gateway = 'gateway.push.apple.com:2195';
	} else { 
    	$gateway = 'gateway.sandbox.push.apple.com:2195';
	}*/
    
	$ctx = stream_context_create();
	echo "Hello one";
	stream_context_set_option($ctx, 'ssl', 'local_cert', 'RLABCERTDEV.pem'); // Pem file to generated // openssl pkcs12 -in pushcert.p12 -out pushcert.pem -nodes -clcerts // .p12 private key generated from Apple Developer Account
	stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
	echo "hello 2";
	//$fp = stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); // production
	$fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx); // developement
	echo "<p>Connection Open</p>";
    if(!$fp){
  		  echo "<p>Failed to connect!<br />Error Number: " . $err . " <br />Code: " . $errstrn . "</p>";
	      return;
	} else {
          echo "<p>Sending notification!</p>";    
    }
	$body['aps'] = array(
	'alert' => $message,
	'data'  => $dataAPS,
	'sound' => 'default'
	); //,'extra1'=>'10','extra2'=>'value');
	$payload = json_encode($body);
	echo "hello 3";
	$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
	//var_dump($msg)
	stream_set_blocking($fp, 0);
	$result = fwrite($fp, $msg, strlen($msg));
	  if (!$result)
	            echo '<p>Message not delivered ' . PHP_EOL . '!</p>';
	        else
	            echo '<p>Message successfully delivered ' . PHP_EOL . '!</p>';
	fclose($fp);
}  
 

?>