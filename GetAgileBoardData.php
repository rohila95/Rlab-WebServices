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

	$sql="SELECT d.project_name,e.username as professor_name,c.username,b.message,b.time_posted from (SELECT max(time_posted) as tp , project_id FROM `project_updates` group by project_id) as a NATURAL JOIN project_updates as b NATURAL join userdetails as c NATURAL join projects as d join userdetails as e on e.userid=d.professor_id where b.time_posted=a.tp and b.project_id = a.project_id and c.userid=b.userid and d.project_id=b.project_id and c.role='R.A' ORDER BY `a`.`project_id` ASC";
	$result=$conn->query($sql);
	if($result->num_rows>0)
	{
	
		while($row = $result->fetch_assoc())
		{
			$value=$row;
			$project_name=$row['project_name'];
			//echo $project_name;
			$sql1 ="SELECT username FROM works_on NATURAL join projects NATURAL join userdetails where project_name='".$project_name."'";
			$result1=$conn->query($sql1);
			$dymmy = false;
			//echo  "hello@@@@@@@@@@@@@@@@@@@";
			//echo $dymmy;
			//echo $result1->num_rows; 
			
			
				$project_Students=array();
				while($row1 = $result1->fetch_assoc())
				{
					$project_Students[]=$row1['username'];
				}
			
			$value["students"]=$project_Students;
			$set[]=$value;
		}
	}
	$data=array("agileboarddata"=>$set);
	echo json_encode($data); 
}
else if($role=="T.A"){
	
	
	$sql="SELECT d.project_name,e.username as professor_name,c.username,b.message,b.time_posted from  (SELECT max(time_posted) as tp , project_id FROM `project_updates` group by project_id) as a NATURAL JOIN  project_updates as b NATURAL join userdetails as c NATURAL join projects as d  join userdetails as e on e.userid=d.professor_id where b.time_posted=a.tp and b.project_id = a.project_id and c.userid=b.userid and d.project_id=b.project_id and c.role='T.A'
ORDER BY `a`.`project_id`    ASC";
	$result=$conn->query($sql);
	if($result->num_rows>0)
	{
	
		while($row = $result->fetch_assoc())
		{
			$value=$row;
			$professor_name=$row['professor_name'];
			//echo $professor_name;
			//echo $project_name;
			$sql1 ="SELECT username FROM works_on NATURAL join projects NATURAL join userdetails where project_name='".$professor_name."'";
			$result1=$conn->query($sql1);
			$dymmy = false;
			//echo  "hello@@@@@@@@@@@@@@@@@@@";
			//echo $dymmy;
			//echo $result1->num_rows;
	
	
			$project_Students=array();
			while($row1 = $result1->fetch_assoc())
			{
				$project_Students[]=$row1['username'];
			}
	
			$value["students"]=$project_Students;
			$set[]=$value;
		}
	}
	$data=array("agileboarddata"=>$set);
	echo json_encode($data);
	
	
}


?> 
