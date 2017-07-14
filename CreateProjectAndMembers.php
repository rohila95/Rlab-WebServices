<?php
include 'DBfile.php';
header('Access-Control-Allow-Origin: *');
$project_name = $_REQUEST['project_name'];
$professor_name= $_REQUEST['professor_name'];
$members=$_REQUEST['members'];
$owner=$_REQUEST["owner"];
$mem = explode(',',$members);


$sql1="select userid from userdetails where username='".$professor_name."' ";
$result1=$conn->query($sql1);
if($result1->num_rows>0)
{	
	    $row = $result1->fetch_assoc();
		$professor_id = $row['userid'];
}

$sql="Insert into projects(project_id,project_name,professor_id,owner) values(NULL,'".$project_name."','".$professor_id."','".$owner."')";
//echo $sql;
$result=$conn->query($sql);
$new_project_id=mysqli_insert_id($conn);

for($i=0;$i<sizeof($mem);$i++){
	$sql2="Insert into works_on(userid,project_id) values('".$mem[$i]."', '".$new_project_id."')";
	$result2=$conn->
	query($sql2);
		//echo "Inserted Successfully";
}  
$data='data inserted successfully';
echo json_encode($data);
?> 


