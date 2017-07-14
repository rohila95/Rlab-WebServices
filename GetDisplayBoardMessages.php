<?php
include 'DBfile.php';
include_once 'PushNotifications.php' ;
header('Access-Control-Allow-Origin: *');
//$userid = $_REQUEST['userid'];
$value= array();
$sql="SELECT * from display_board";
$result=$conn->query($sql);
if($result->num_rows>0)
{

	while($row = $result->fetch_assoc())
	{
		$value[]=$row;
	}
}
$msg_payload = array (
		'mtitle' => 'Test push notification title',
		'mdesc' => 'Test push notification body',
);

/* $regId ='d6xWsRS66eQ:APA91bFCSj0y9aenNSHWa4JNvQeH5K84_jkUMlIRvnCUrDKHQ6iCYjWQ5kS86HoCxetjdp3iJRY_ljBHioUxATCLPkIb3eHxRnbxDNJQX-EG_CJ3lA0-GDhG6K_uyXANVQtoWpkSN50b';
$pushnotification= new PushNotifications();

$pushnotification->android($msg_payload, $regId); */

$data=array("value"=>$value);
echo json_encode($data);
?>  