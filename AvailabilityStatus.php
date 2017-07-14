<?php
include 'DBfile.php';

//$userid = $_REQUEST['userid'];
$value=array();
$sql="SELECT * from availability";
$result=$conn->query($sql);
if($result->num_rows>0)
{

	while($row = $result->fetch_assoc())
	{
		$value[]=$row;
	}
}
$data=array("value"=>$value);
echo json_encode($data);
?>