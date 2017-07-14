<?php
include 'DBfile.php';
header('Access-Control-Allow-Origin: *');
$proj_name=$_REQUEST["projname"];

$sql="SELECT username,message,time_posted,id FROM `project_updates` , userdetails,projects where project_updates.userid=userdetails.userid and project_updates.project_id=projects.project_id and project_name='$proj_name' order by id desc";
// echo $sql;
$result=$conn->query($sql);
if($result->num_rows>0)
{

	while($row = $result->fetch_assoc())
	{
		$value[]=$row;
	}

}
$data=array("proj_updates"=>$value);
echo json_encode($data);
?>