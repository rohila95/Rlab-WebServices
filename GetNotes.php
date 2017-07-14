<?php
include 'DBfile.php';
header('Access-Control-Allow-Origin: *');
$userid=$_REQUEST["userid"];

$sql="Select role from userdetails where userid='".$userid."'";
$result=$conn->query($sql);
if($result->num_rows>0)
{

	while($row = $result->fetch_assoc())
	{
		$role=$row['role'];
	}

}
$sql1= "select userid,id,title,description from notes where role='".$role."' ";
$result1=$conn->query($sql1);
if($result1->num_rows>0)
{
		while($row1 = $result1->fetch_assoc())
		{
			$EventData = $row1;
			$value[]=$EventData;
		}	
} 
$data=array("notes_data"=>$value);
if(!empty($value)){
	
	echo json_encode($data);
}
else{
	echo "Exception-No notes to display.";
}

?>