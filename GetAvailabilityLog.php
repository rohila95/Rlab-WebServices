<?php
 header('Access-Control-Allow-Origin: *');
include 'DBfile.php';
$userid=$_REQUEST["userid"];
//$date=$_REQUEST['date'];
//$from_date=$_REQUEST['from_date'];
//$to_date=$_REQUEST['to_date'];
$sql1="SELECT min(in_time) as min_in_time, max(in_time) as max_in_time from availability_log";
$result=$conn->query($sql1);
if($result->num_rows>0)
{
    $row1 = $result->fetch_assoc();
	$sql_in_time=$row1['min_in_time'];
	$sql_out_time=$row1['max_in_time'];
}
$from_date  = date('Y-m-d',strtotime($sql_in_time));
$to_date  = date('Y-m-d',strtotime($sql_out_time));

//echo $from_date  = date('Y-m-d',strtotime($sql_in_time));
//echo $to_date  = date('Y-m-d',strtotime($sql_out_time));
$current_date=$from_date;

 while ($current_date<=$to_date)
{ 
	/* $date_str = strtotime("+1 day", strtotime($current_date));
	$current_date=date("Y-m-d", $date_str); */
	//echo $current_date .PHP_EOL;
	
	$sql="SELECT * from availability_log where userid='".$userid."' and in_time like '".$current_date."%' ";
	//echo $sql .PHP_EOL;
	
 	$result=$conn->query($sql) ;
 	$in_time= array();
 	$out_time= array();
	if($result->num_rows>0)
	{
		while($row = $result->fetch_assoc())
		{
			$EventData1 = $row['in_time'];
			$EventData2 = $row['out_time'];
			$in_time[]=$EventData1;
			$out_time[]=$EventData2;
		}
	}
 	$totalminutes=0;
	for($i=0; $i<count($in_time);$i++)
	{
		if($out_time[$i]==null){
			continue;
		}
		$intime_str = strtotime($in_time[$i]);
		$outtime_str = strtotime($out_time[$i]);
		$minutes = round(abs($outtime_str - $intime_str)/ 60,2);
		//echo" minutes:$minutes  ".PHP_EOL;
		//$minutes_array[]=$minutes .PHP_EOL;
		$totalminutes=$totalminutes+$minutes;	
	}
	//echo $totalminutes .PHP_EOL;
	//echo "total minutes: $totalminutes  ";
 	$hours = floor($totalminutes / 60) .':'. floor($totalminutes -   floor($totalminutes / 60) * 60);
	//echo "hours: $hours ";
	$value["current_date"]=$current_date;
	$value["hours"]=floor($totalminutes /60);
	$value["minutes"]=floor($totalminutes - floor($totalminutes / 60) * 60); 
	$date_total_hours[]=$value;  
	
	$date_str = strtotime("+1 day", strtotime($current_date));
	$current_date=date("Y-m-d", $date_str);
}
usort($date_total_hours, function($a, $b) {
    return strtotime($b['current_date']) - strtotime($a['current_date']);
});
$data=array("total_time"=>$date_total_hours);
echo json_encode($data);     