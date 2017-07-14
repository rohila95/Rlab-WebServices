<?php
include 'DBfile.php';

$username=$_REQUEST['username'];
$password=$_REQUEST['password'];
$deviceid=$_REQUEST['deviceid']; 


$sql="SELECT U.userid,U.username,U.role,U.image,A.status,blm.beacon_major,blm.beacon_minor,blm.beacon_uuid from userdetails U, availability A,beacon_labMap blm where U.userid = A.userid and U.role=blm.role and U.username ='".$username."' and U.password='".$password."'";
$result=$conn->query($sql);

if($result->num_rows>0)
{
	
 	while($row = $result->fetch_assoc()) 
	 {
	 	$value=$row;
	 	if ($deviceid != $row["deviceid"]) {
	 		$queryString = "UPDATE userdetails set deviceid='".$deviceid."' where userid='".$row["userid"]."'";
	 		$result1=$conn->query($queryString);
	 	}
	 }

	 echo json_encode($value);
}
else 
	echo "Exception-Invalid User name/Password !"


//$row =mysqli_fetch_row($result);

//echo $row['userid'];
?>