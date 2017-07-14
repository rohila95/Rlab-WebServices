<?php
include 'DBfile.php';
header('Access-Control-Allow-Origin: *');
$userid = $_REQUEST['userid'];
/* echo 'hello';
echo $day=strtotime($time); */
$currentdate = date('m/d/Y');
//echo  $currentdate;

$day= date('l', strtotime( $currentdate));
$sql="SELECT userid,title,start_time,end_time FROM `event_details` join days where event_details.day=days.id and days.day='".$day."' and event_details.userid='".$userid."' ";
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