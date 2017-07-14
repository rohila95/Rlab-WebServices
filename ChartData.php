<?php
 header('Access-Control-Allow-Origin: *');
include 'DBfile.php';
$userid=$_REQUEST["userid"];
// echo $userid."\n";
define ('DB_USER', 'kumar');
define ('DB_PASSWORD', 'kumar');
define ('DB_HOST', 'handson-mysql');
define ('DB_NAME', 'LabBoard');
function getchartdata($userid)
{
		$today=Date("Y-m-d");
		$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD,DB_NAME)

		OR die ('Could not connect to MySQL: '.mysql_error());
		$prevdate=Date('Y-m-d', strtotime('-7 days'));
		$totalhours=array();
		$days=array();
		for($it=7;$it>=0;$it--)
		{
			$currDate=Date('Y-m-d', strtotime('-'.$it.' days'));
			// echo $currDate;
			$getLogSql="SELECT * FROM `availability_log` where userid=".$userid." and in_time like '%".$currDate."%'";
			$day=date( "D", strtotime('-'.$it.' days'));
			$days[]=$day;
			// echo $getLogSql;
			$result=$conn->query($getLogSql) ;
		 	$in_time= array();
		 	$out_time= array();
			if($result->num_rows>0)
			{
				while($row = $result->fetch_assoc())
				{
					$EventData1 = $row['in_time'];
					$EventData2 = $row['out_time'];

					$in_time[]=$EventData1;
					$out_time[]=$EventData2;
				}
			}
		 	$totalminutes=0;
			for($i=0; $i<count($in_time);$i++)
			{
				if($out_time[$i]==null){
					continue;
				}
				$intime_str = strtotime($in_time[$i]);
				$outtime_str = strtotime($out_time[$i]);
				$minutes = round(abs($outtime_str - $intime_str)/ 60,2);
				// echo $minutes;
				//$minutes_array[]=$minutes .PHP_EOL;
				$totalminutes=$totalminutes+$minutes;	
			}
			//echo $totalminutes .PHP_EOL;
			//echo "total minutes: $totalminutes  ";
		 	$hours = floor($totalminutes / 60) ;
		 	// echo $hours;
		 	$totalhours[]=$hours;
		}

		// $data1=array("xLabels"=>$days);
		// $data2=array("value"=>$totalhours);
		$data[]=$days;
		$data[]=$totalhours;
		return ($data);  
}   

// echo json_encode($totalhours);
// echo json_encode($days);




$sql1="Select role from userdetails where userid='".$userid."'";
$result1=$conn->query($sql1);
if($result1->num_rows>0)
{
	while($row1 = $result1->fetch_assoc())
	{
		$role=$row1['role'];
	}
}





if($role=="R.A")
{

	$value=array();
	$sql="select userid,username,status,image,mobile_image,lat,lon from userdetails  NATURAL join availability where userdetails.userid=availability.userid and role='R.A';";
	$result=$conn->query($sql);
	if($result->num_rows>0)
	{
	
		while($row = $result->fetch_assoc())
		{
			$testObj = $row;
	
			//$project= array();
			$projects_string="";
	
			$userid=$row['userid'];
			// $user=$userid;
			$chartdata=getchartdata($userid);
			//echo $userid;
			$sql1="SELECT * from works_on natural join projects where userid='".$userid."';";
			$result1=$conn->query($sql1);
			if($result1->num_rows>0)
			{
	
				while($row1 = $result1->fetch_assoc())
				{
					$project=$row1["project_name"];
					if($projects_string==""){
						$projects_string=$row1["project_name"];
					}
					else{
						$projects_string=$projects_string.', '.$row1["project_name"];
					}
				}
			}
			//echo $projects_string;
			//$testObj["projects"]=$project_id;
			$testObj["projects"]=$projects_string;
			$testObj["xLabels"]=$chartdata[0];
			$testObj["value"]=$chartdata[1];
			// getchartdata(1);
			$value[]=$testObj;
	
		}
	}
	$data=array("student_details"=>$value);
	echo json_encode($data);

}

else if($role=="T.A"){
	
	$value=array();
	$sql="select userid,username,status,image,mobile_image,lat,lon from userdetails  NATURAL join availability where userdetails.userid=availability.userid and role='T.A';";
	$result=$conn->query($sql);
	if($result->num_rows>0)
	{
	
		while($row = $result->fetch_assoc())
		{
			$testObj = $row;
	
			//$project= array();
			$projects_string="";
	
			$userid=$row['userid'];
			$chartdata=getchartdata($userid);
			//echo $userid;
			$sql1="SELECT * from works_on natural join projects where userid='".$userid."';";
			$result1=$conn->query($sql1);
			if($result1->num_rows>0)
			{
	
				while($row1 = $result1->fetch_assoc())
				{
					$project=$row1["project_name"];
					if($projects_string==""){
						$projects_string=$row1["project_name"];
					}
					else{
						$projects_string=$projects_string.', '.$row1["project_name"];
					}
				}
			}
			//echo $projects_string;
			//$testObj["projects"]=$project_id;
			$testObj["projects"]=$projects_string;
			$testObj["xLabels"]=$chartdata[0];
			$testObj["value"]=$chartdata[1];
			$value[]=$testObj;
	
		}
	}
	$data=array("student_details"=>$value);
	echo json_encode($data);
	
}
?>