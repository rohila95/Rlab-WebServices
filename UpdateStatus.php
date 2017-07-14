<?php
include 'DBfile.php';
include 'PushNotifications.php';
header('Access-Control-Allow-Origin: *');

$userid = $_REQUEST['userid'];
$status= $_REQUEST['status'];
$sql="UPDATE availability set status='".$status."' where userid='".$userid."' ";
$result=$conn->query($sql);


$sql1="Select * from availability";
$result1=$conn->query($sql1);
if($result1->num_rows>0)
{

	while($row1 = $result1->fetch_assoc())
	{
		$value[]=$row1;
		
		
	}
}
$data=array("update_status"=>$value);
//echo json_encode($data);



$pn= new PushNotifications();
//$reg_id="d6xWsRS66eQ:APA91bFCSj0y9aenNSHWa4JNvQeH5K84_jkUMlIRvnCUrDKHQ6iCYjWQ5kS86HoCxetjdp3iJRY_ljBHioUxATCLPkIb3eHxRnbxDNJQX-EG_CJ3lA0-GDhG6K_uyXANVQtoWpkSN50b";
$reg_id="dRm63OxnT2E:APA91bGz0M2vbI6CqPm6OBFqCkCJs0mEnGKrZZk3faQgXHDR6r4xNU7ggza7XXjSpXc6lf_5T9xjfjz3BOIomzUmxXWHwU28FThj-v6_Pr1PQBo-xfgZGesJRXwheSWTd1Or_ZScLyi-";
$data1['mtitle']="khaidhino 150";
$data1['mdesc']="chiranjeevi 150th movie";
$pn->android($data1, $reg_id);
?>    