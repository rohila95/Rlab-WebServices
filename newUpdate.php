<?php
include 'DBfile.php';
header('Access-Control-Allow-Origin: *');
$userid=$_REQUEST['userid'];
$projname = $_REQUEST['projname'];
$update = $_REQUEST['update'];


$sql="SELECT * FROM `projects` where project_name='$projname'";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row = $result->fetch_assoc())
	{
			$projId=$row['project_id'];
	}

}
$timestamp = date('Y-m-d G:i:s');
$sql1="INSERT INTO `LabBoard`.`project_updates` (`id`, `userid`, `project_id`, `message`, `time_posted`) VALUES (NULL, '$userid', '$projId', '$update', '$timestamp')";
$result1=$conn->query($sql1); 

$data='data inserted successfully';

echo $sql1;
?>