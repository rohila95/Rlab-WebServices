<?php

include 'DBfile.php';
header('Access-Control-Allow-Origin: *');
$userid=$_REQUEST["userid"];
$date=$_REQUEST["date"];

$timestamp = strtotime($date);
$day = date('l', $timestamp);
//var_dump($day);


$sql="select id from days where day='".$day."' ";
$result=$conn->query($sql);
if($result->num_rows>0)
{
		$row = $result->fetch_assoc();
		$day_id = $row['id'];
}

$sql1="select start_time, end_time, description from student_schedule where userid='".$userid."' and day_id='".$day_id."'";
$result1=$conn->query($sql1);
if($result1->num_rows>0)
{
	while($row1 = $result1->fetch_assoc())
	{
		
		$EventData["in_time"] = $row1['start_time'];
		$EventData["out_time"]= $row1['end_time'];
		$EventData["description"]=$row1['description'];
		$value1[]=$EventData;
	}
} 
$data1=array("schedule_data"=>$value1);


$sql2="SELECT in_time,out_time FROM `availability_log` where in_time like '".$date."%' and  userid='".$userid."' ";
$result2=$conn->query($sql2);
if($result2->num_rows>0)
{
	while($row2 = $result2->fetch_assoc())
	{

		$EventData1["in_time"] = $row2['in_time'];
		$EventData1["out_time"]= $row2['out_time'];
		$EventData1["description"]=null;
		$value2[]=$EventData1;
	}
} 
$data2=array("availability_data"=>$value2);
$data=$data1+$data2;
//$data=array("student_details"=>$value);
echo json_encode($data);



















/* 
include 'DBfile.php';
header('Access-Control-Allow-Origin: *');
$userid=$_REQUEST["userid"];
$date=$_REQUEST["date"];

$timestamp = strtotime($date);
$day = date('l', $timestamp);
//var_dump($day);


$sql="select id from days where day='".$day."' ";
$result=$conn->query($sql);
if($result->num_rows>0)
{
	$row = $result->fetch_assoc();
	$day_id = $row['id'];
}

$sql1="select start_time, end_time, description from student_schedule where userid='".$userid."' and day_id='".$day_id."'";
$result1=$conn->query($sql1);
if($result1->num_rows>0)
{
	while($row1 = $result1->fetch_assoc())
	{

		$EventData = $row1['start_time'];
		$value1[]=$EventData;
	}
}
$data1=array("schedule_data"=>$value1);


$sql2="SELECT in_time,out_time FROM `availability_log` where in_time like '".$date."%' and  userid='".$userid."' ";
$result2=$conn->query($sql2);
if($result2->num_rows>0)
{
	while($row2 = $result2->fetch_assoc())
	{

		$EventData = $row2;
		$value2[]=$EventData;
	}
}
$data2=array("availability_data"=>$value2);
$data=$data1+$data2;
//$data=array("student_details"=>$value);
echo json_encode($data); */
?>