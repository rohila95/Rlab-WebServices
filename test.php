<?php
include 'DBfile.php';


$sql="SELECT * from userdetails";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	while($row = $result->fetch_assoc())
	{
		$EventData = $row;
		$value[]=$EventData;
	}
}
$data=array("event_details"=>$value);
echo json_encode($data);
?>