<?php
include 'DBfile.php';
header('Access-Control-Allow-Origin: *');

$userid=$_REQUEST["userid"];

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
			$value[]=$testObj;
	
		}
	}
	$data=array("student_details"=>$value);
	echo json_encode($data);
	
}



//$rlrobj->set_result("StudentDetails", "hello");
//$details=$rlrobj->get_result();


/* $data=array("projectid"=>$project_id);
echo json_encode($data); */
?> 