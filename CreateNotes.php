<?php
include 'DBfile.php';
header('Access-Control-Allow-Origin: *');
$userid=$_REQUEST['userid'];
$title = $_REQUEST['title'];
$description = $_REQUEST['description'];
echo 'In notes';
echo $userid;
echo "    ";
echo $title;
echo $description;

$sql="Select role from userdetails where userid='".$userid."'";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row = $result->fetch_assoc())
	{
			$role=$row['role'];
	}

}

$sql1="Insert into notes(userid,role,title,description) values('".$userid."','".$role."','".$title."' ,'".$description."')";
$result1=$conn->query($sql1); 

$data='data inserted successfully';

echo $sql1;
?>