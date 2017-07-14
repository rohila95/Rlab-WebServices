<?php
include 'DBfile.php';
header('Access-Control-Allow-Origin: *');
$project_name=$_REQUEST["project_name"];
//$professor_name=$_REQUEST["professor_name"];
//$username=$_REQUEST["username"];

$professor_id=$_REQUEST["professorid"];
$user_id=$_REQUEST["userid"];

$message=$_REQUEST["message"];
$project_students=array();
$project_students=$_REQUEST["students"];
//$professor_id = 0;
$isProfExists = FALSE;
$isProjInserted = FALSE;
$project_id = 0;
//$user_id = 0;
$temp = "Professor";
$isProjUpdated = FALSE;
$flag = FALSE;

//MARK
/* NEED TO MODULARIZE THE CODE....BUT JUST A TEMPORARY WORKAROUND */

if (count($project_students) != 0) {
    /*
	$getProfId = "select userid from userdetails where username='".$professor_name."' and role='".$temp."'";
	$result=$conn->query($getProfId);
	if($result->num_rows == 1)
	{

		while($row = $result->fetch_assoc())
		{
			$professor_id = $row["userid"];
			$isProfExists = TRUE;
		}

	} else {
		// Perform action
	}
	mysqli_free_result($result);
 	*/

    echo "prof id:".$professor_id;
	$insertProject = "";
	if (/*$isProfExists == TRUE*/$professor_id != 0 && $professor_id != null) {
		$insertProject = "insert into LabBoard.projects(project_name, professor_id) values('".$project_name."', '".$professor_id."')";
		//} else {
			//$insertProject = "insert into LabBoard.projects(project_name) values('".$project_name."')";
			//}
			echo "prof id:".$professor_id;
			$result=$conn->query($insertProject);
			if($conn->affected_rows == 1){
				echo  "Inserted into 'Projects' Successfully";
				$isProjInserted = TRUE;
				echo "prof id:".$professor_id;
			} else{
				echo "EXCEPTION - Insertion into 'Projects' Failed";
			}
			mysqli_free_result($result);

			if ($isProjInserted == TRUE) {
				$getProjId = "select max(project_id) as project_id from projects where project_id = (select project_id from projects where project_name='".$project_name."')";
				$result=$conn->query($getProjId);
				if($result->num_rows == 1)
				{

					while($row = $result->fetch_assoc())
					{
						$project_id = $row["project_id"];
					}

				} else {
					// Perform action
				} 
				mysqli_free_result($result);

				/*
				$getUserId = "select userid from userdetails where username='".$username."' and role in ('T.A','R.A')";
				$result=$conn->query($getUserId);
				if($result->num_rows == 1)
				{

					while($row = $result->fetch_assoc())
					{
						$user_id = $row["userid"];
						//echo "author".":".$user_id;
					}

				} else {
					// Perform action
				}
				mysqli_free_result($result);
				*/	


				$date = new DateTime();
				$newdate=$date->getTimestamp();
				$date->setTimestamp($newdate);
				$time=$date->format('Y-m-d H:i:s');

				$insProjUpdates = "insert into LabBoard.project_updates(`userid`, `project_id`, `message`) values('$user_id', '$project_id', '$message')"; //, '".$time."'";
				$result=$conn->query($insProjUpdates);
				if($conn->affected_rows == 1){
					echo  "Inserted into 'Project Updates' Successfully";
					$isProjUpdated = TRUE;
				} else{
					echo "EXCEPTION - Insertion into 'Project Updates' Failed";
					$delProj = "delete from projects where project_id = '".$project_id."'";
					$result=$conn->query($delProj);
					if($conn->affected_rows == 1){
						echo "EXCEPTION - ".$project_id." deleted for consistency";
					} else {
						echo "EXCEPTION - DB inconsistent. Delete ".$project_id." and all its dependencies manually";
					}
					mysqli_free_result($result);
				}
				mysqli_free_result($result);

				if ($isProjUpdated == TRUE) {
					echo $project_students;
					foreach ($project_students as $value) {
						$flag = TRUE;
						
						/*
						$member = 0;						
						$getUser = "select userid from userdetails where username='".$value."' and role in ('T.A','R.A')";
						$result=$conn->query($getUser);
						if($result->num_rows == 1)
						{
							while($row = $result->fetch_assoc())
							{
								$member = $row["userid"];
							}

						} else {
							// Perform action
						}
						mysqli_free_result($result);
						*/

						$member = $value;
						$time_spent = 0;
						$sql = "insert into works_on(userid, project_id, professor_id, time_spent) values('".$member."', '".$project_id."', '".$professor_id."', '".$time_spent."')";
						echo $member.",".$project_id.",".$professor_id.",".$time_spent;
						$result=$conn->query($sql);
						if($conn->affected_rows == 1){
							echo  "Inserted into 'WORKS_ON' Successfully";
						} else{
							echo "EXCEPTION - Insertion into 'WORKS_ON' Failed";
							$delProjUpdates = "delete from LabBoard.project_updates where project_id = '".$project_id."'";
							$result=$conn->query($delProjUpdates);
							if($conn->affected_rows == 1){
								echo "EXCEPTION - ".$project_id." deleted 'Project Updates' for consistency";
							} else {
								echo "EXCEPTION - DB inconsistent. Delete ".$project_id." from 'Project Updates' and all its dependencies manually";
							}
							mysqli_free_result($result);

							$delProj = "delete from LabBoard.projects where project_id = '".$project_id."'";
							$result=$conn->query($delProj);
							if($conn->affected_rows == 1){
								echo "EXCEPTION - ".$project_id." deleted 'Projects' for consistency";
							} else {
								echo "EXCEPTION - DB inconsistent. Delete ".$project_id." from 'Projects' and all its dependencies manually";
							}
							mysqli_free_result($result);

						}
						mysqli_free_result($result);
			
					}
		

					// NEED THE BELOW CONDITION WHEN SOMETHING MESSES UP WITH THE ARRAY $project_students
					if ($flag == FALSE) {
						$delProjUpdates = "delete from LabBoard.project_updates where project_id = '".$project_id."'";
						$result=$conn->query($delProjUpdates);
						if($conn->affected_rows == 1){
							echo "EXCEPTION - ".$project_id." deleted 'Project Updates' for consistency";
						} else {
							echo "EXCEPTION - DB inconsistent. Delete ".$project_id." from 'Project Updates' and all its dependencies manually";
						}
						mysqli_free_result($result);

						$delProj = "delete from LabBoard.projects where project_id = '".$project_id."'";
						$result=$conn->query($delProj);
						if($conn->affected_rows == 1){
							echo "EXCEPTION - ".$project_id." deleted 'Projects' for consistency";
						} else {
							echo "EXCEPTION - DB inconsistent. Delete ".$project_id." from 'Projects' and all its dependencies manually";
						}
						mysqli_free_result($result);
					}





				} else {
					echo "EXCEPTION - Project Not Updated";
				}
			} else {
				echo "EXCEPTION - Project Not Inserted";
			}
		} else {
			echo "EXCEPTION - Professor does not Exist";
		}
	} else {
		echo "EXCEPTION - Service not performed as there are no project members";
	}


?>