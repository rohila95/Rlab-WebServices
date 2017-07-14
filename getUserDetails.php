<?php
include 'DBfile.php';
header('Access-Control-Allow-Origin: *');
$userid=$_REQUEST["userid"];
$role = "";

$sql1="Select role from userdetails where userid='".$userid."'";
$result1=$conn->query($sql1);
if($result1->num_rows>0)
{
	while($row1 = $result1->fetch_assoc())
	{
		$role=$row1['role'];
	}

}
mysqli_free_result($result1);


$getDetails = "select userid, username from userdetails where role='".$role."'";
$result=$conn->query($getDetails);
//if($role=="R.A")
//{
if($result->num_rows>0)
{
	while($row = $result->fetch_assoc())
	{
		$value=$row;
		$studentSet[] = $value;
	}
}

mysqli_free_result($result);
$getProf = "select userid, username from userdetails where role='"."Professor"."'";
$result=$conn->query($getProf);

if($result->num_rows>0)
{
	while($row = $result->fetch_assoc())
	{
		$value=$row;
		$profSet[] = $value;
	}
}
mysqli_free_result($result);

$data=array();
$data["students"] = $studentSet;
$data["professors"] = $profSet;
echo json_encode($data); 

?>