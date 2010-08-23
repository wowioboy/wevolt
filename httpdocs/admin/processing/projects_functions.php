<? 
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'CREATE') && ($_POST['sub'] == 'task')) {
	$projects = new DB();
	$Title = $_POST['txtTitle'];
	$Description = $_POST['txtDescription'];
	$Month = $_POST['txtMonth'];
	$Day = $_POST['txtDay'];
	$Priority = $_POST['txtPriority'];
	$NotifyLeader = $_POST['txtNotifyLeader'];
	$NotifyUsers = $_POST['txtNotifyUsers'];
	$RemindUsers = $_POST['txtRemindUsers'];
	if (strlen($_POST['txtMonth']) == 1) {
		$Month = '0'.$_POST['txtMonth'];
	} 
	if (strlen($_POST['txtDay']) == 1) {
		$Day = '0'.$_POST['txtDay'];
	} 
	
	$Deadline = $_POST['txtYear'].'-'. $Month.'-'. $Day;
	
	$Users = $_POST['txtTaskUsers'];
	if (is_array($Users))
	{
  	$TempUsers = '';
 	 foreach ($Users as $value) {
   	  if ($TempUsers != '')
   	   $TempUsers .= ',';
   	 $TempUsers .= $value;
 	 }
 	 $UserString = $TempUsers;
	}
	$Files = $_POST['txtTaskFiles'];
	if (is_array($Files))
	{
  	$TempFiles = '';
 	 foreach ($Files as $value) {
   	  if ($TempFiles != '')
   	   $TempFiles .= ',';
   	 $TempFiles .= $value;
 	 }
 	 $FilesString = $TempFiles;
	}
	$query = "INSERT into pf_projects_tasks (Title, Description, Users, ProjectID, Deadline,  Priority, Files, CreatedDate, NotifyLeader, NotifyUsers, RemindUsers) values ('$Title','$Description','$UserString','$ProjectID','$Deadline',$Priority,'$FilesString',NOW(),$NotifyLeader, $NotifyUsers, $RemindUsers)";
	$projects->query($query);
	$query = "SELECT ID from pf_projects_tasks where Title='$Title' and ProjectID='$ProjectID'";
	 $TaskID = $projects->queryUniqueValue($query);
	
	if ($NotifyUsers ==3) {
	 foreach ($Users as $value) {
   	 $query = "SELECT * from users where id='$value'";
	 $UserInfo = $projects->queryUniqueObject($query);
		 SendUserTaskAssignmentNotification($UserInfo->Name, $UserInfo->Email, $TaskID);
	}
	}
	
	if ($NotifyLeader ==3) {
	$query = "SELECT ProjectLeader from pf_projects where ID ='$ProjectID'";
	 $LeaderID = $projects->queryUniqueValue($query);
	 $query = "SELECT * from users where id='$LeaderID'";
	 $UserInfo = $projects->queryUniqueObject($query);
		 SendLeaderTaskAssignmentNotification($UserInfo->Name, $UserInfo->Email, $TaskID);
	}

}


//EDIT TASK
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'SAVE') && ($_POST['sub'] == 'task')) {
	$projects = new DB();
	$Title = $_POST['txtTitle'];
	$Description = $_POST['txtDescription'];
	$Month = $_POST['txtMonth'];
	$Day = $_POST['txtDay'];
	$NotifyLeader = $_POST['txtNotifyLeader'];
	$NotifyUsers = $_POST['txtNotifyUser'];
	$RemindUsers = $_POST['txtRemindUser'];
	$Priority = $_POST['txtPriority'];
	if (strlen($_POST['txtMonth']) == 1) {
		$Month = '0'.$_POST['txtMonth'];
	} 
	if (strlen($_POST['txtDay']) == 1) {
		$Day = '0'.$_POST['txtDay'];
	} 
	
	$Deadline = $_POST['txtYear'].'-'. $Month.'-'. $Day;
	$Users = $_POST['txtTaskUsers'];
	$Files = $_POST['txtFiles'];
	if (is_array($Files))
	{
  	$TempGroups = '';
 	 foreach ($Files as $value) {
   	  if ($TempGroups != '')
   	   $TempGroups .= ',';
   	 $TempGroups .= $value;
 	 }
 	 $FilesString = $TempGroups;
	}
	if (is_array($Users))
	{
  	$TempUsers = '';
 	 foreach ($Users as $value) {
   	  if ($TempUsers != '')
   	   $TempUsers .= ',';
   	 $TempUsers .= $value;
 	 }
 	 $UsersString = $TempUsers;
	}
	$query = "UPDATE pf_projects_tasks set title = '$Title', Description = '$Description',Deadline = '$Deadline',Priority = '$Priority',Users = '$UsersString',Files  = '$FilesString', NotifyLeader='$NotifyLeader', NotifyUsers='$NotifyUsers', RemindUsers='$RemindUsers' where id='$TaskID'";
	$projects->query($query);
}

//NEW PROJECT
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'CREATE')&& (!isset($_POST['sub']))) {
	$projects = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$Description = mysql_escape_string($_POST['txtDescription']);
	$Month = $_POST['txtMonth'];
	$Day = $_POST['txtDay'];
	$NotifyLeader = $_POST['txtNotifyLeader'];
	$RemindLeader = $_POST['txtRemindLeader'];
	if (strlen($_POST['txtMonth']) == 1) {
		$Month = '0'.$_POST['txtMonth'];
	} 
	if (strlen($_POST['txtDay']) == 1) {
		$Day = '0'.$_POST['txtDay'];
	} 
	
	$Deadline = $_POST['txtYear'].'-'. $Month.'-'. $Day;
	$ProjectLeader = $_POST['txtProjectLeader'];
	$Groups = $_POST['txtProjectGroups'];
	if (is_array($Groups))
	{
  	$TempGroups = '';
 	 foreach ($Groups as $value) {
   	  if ($TempGroups != '')
   	   $TempGroups .= ',';
   	 $TempGroups .= $value;
 	 }
 	 $GroupString = $TempGroups;
	}

	$query = "INSERT into pf_projects (Title, Description, ProjectLeader, Groups, Deadline, NotifyLeader, RemindLeader) values ('$Title','$Description','$ProjectLeader','$GroupString','$Deadline',$NotifyLeader, $RemindLeader)";
	$projects->query($query);
	//header("location:admin.php?a=menu");
	
	if ($NotifyLeader ==3) {
	 	$query = "SELECT * from users where id='$ProjectLeader'";
	 	$UserInfo = $projects->queryUniqueObject($query);
	  	SendLeaderProjectAssignmentNotification($UserInfo->Name, $UserInfo->Email, $TaskID);
	}
}

//DELETE FILE 
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'YES')&& ($_POST['sub'] == 'file')) {
	$files = new DB();
	$query = "select filename from pf_projects_files where id ='$FileID'";
	$Filename = $files->queryUniqueValue($query);
	$query = "delete from pf_projects_files where id ='$FileID'";
	$files->query($query);
	@unlink("projects/media/".$Filename);
	//header("location:admin.php?a=menu");
}

//EDIT FILE
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'SAVE') && ($_POST['sub'] == 'file')) {
	$projects = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$Description = mysql_escape_string($_POST['txtDescription']);
	$query = "UPDATE pf_projects_files set title = '$Title',Description = '$Description' where id='$FileID'";
	$projects->query($query);
}

//DELETE GROUP
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'YES')&& ($_POST['sub'] == 'group')) {
	$groups = new DB();
	$query = "delete from pf_projects_groups where id ='$GroupID'";
	$groups->query($query);
	//header("location:admin.php?a=menu");
}


//DELETE PROJECT TASK
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'YES')&& ($_POST['sub'] == 'task')) {
	$tasks = new DB();
	$query = "delete from pf_projects_tasks where id ='$TaskID'";
	$tasks->query($query);
	//header("location:admin.php?a=menu");
}

//DELETE PROJECT
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'YES') && ($_POST['sub'] == '')) {
	$tasks = new DB();
	$query = "delete from pf_projects where id ='$ProjectID'";
	$tasks->query($query);
	$query = "delete from pf_projects_tasks where projectid ='$ProjectID'";
	$tasks->query($query);
	//header("location:admin.php?a=menu");
}


//EDIT PROJECT
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'SAVE') && (!isset($_POST['sub']))) {
	$projects = new DB();
	
	$Title = mysql_escape_string($_POST['txtTitle']);
	$Description = mysql_escape_string($_POST['txtDescription']);
	$Month = $_POST['txtMonth'];
	$Day = $_POST['txtDay'];
	$Groups = $_POST['txtProjectGroups'];
	$NotifyLeader = $_POST['txtNotifyLeader'];
	$RemindLeader = $_POST['txtRemindLeader'];
if (is_array($Groups))
{
  $TempGroups = '';
  foreach ($Groups as $value) {
     if ($TempGroups != '')
      $TempGroups .= ',';
    $TempGroups .= $value;
  }
  $GroupString = $TempGroups;
}


	if (strlen($_POST['txtMonth']) == 1) {
		$Month = '0'.$_POST['txtMonth'];
	} 
	if (strlen($_POST['txtDay']) == 1) {
		$Day = '0'.$_POST['txtDay'];
	} 
	
	$Deadline = $_POST['txtYear'].'-'. $Month.'-'. $Day;
	$ProjectLeader = $_POST['txtProjectLeader'];
	$query = "UPDATE pf_projects set title = '$Title',Description = '$Description',Deadline = '$Deadline',Groups = '$GroupString' ,ProjectLeader = '$ProjectLeader',NotifyLeader='$NotifyLeader', RemindLeader='$RemindLeader' where id='$ProjectID'";
	$projects->query($query);
	

	}
	//NEW GROUP
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'CREATE') && ($_POST['sub'] == 'group')) {
	$groups = new DB();
	$Title = mysql_escape_string($_POST['txtTitle']);
	$Description = mysql_escape_string($_POST['txtDescription']);
	$Read = $_POST['txtRead'];
	$UploadFiles = $_POST['txtUpload'];
	$DownloadFiles = $_POST['txtDownload'];
	$ChangeFiles = $_POST['txtChangeFiles'];
	$CreateProjects = $_POST['txtCreateProjects'];
	$EditProjects = $_POST['txtEditProjects'];
	$DeleteProjects = $_POST['txtDeleteProjects'];
	$CreateTasks = $_POST['txtCreateTasks'];
	$EditTasks = $_POST['txtEditTasks'];
	$DeleteTasks = $_POST['txtDeleteTasks'];
	$AddUsers = $_POST['txtAddUsers'];
	$EditUsers = $_POST['txtEditUsers'];
	$DeleteUsers = $_POST['txtDeleteUsers'];
	$CreateGroups = $_POST['txtCreateGroups'];
	$EditGroups = $_POST['txtEditGroups'];
	$DeleteGroups = $_POST['txtDeleteGroups'];
	$UpdateTasks = $_POST['txtUpdateTasks'];
	$Projects = $_POST['txtProjects'];
	if ($UploadFiles == '')
		$UploadFiles = 0;
	if ($DownloadFiles == '')
		$DownloadFiles = 0;	
	if ($ChangeFiles == '')
		$ChangeFiles = 0;	
	if ($CreateProjects == '')
		$CreateProjects = 0;
	if ($EditProjects == '')
		$EditProjects = 0;	
	if ($DeleteProjects == '')
		$DeleteProjects = 0;
	if ($CreateTasks == '')
		$CreateTasks = 0;
	if ($EditTasks == '')
		$EditTasks = 0;	
	if ($DeleteTasks == '')
		$DeleteTasks = 0;	
	if ($AddUsers == '')
		$AddUsers = 0;
	if ($EditUsers == '')
		$EditUsers = 0;	
	if ($DeleteUsers == '')
		$DeleteUsers = 0;
	if ($CreateGroups == '')
		$CreateGroups = 0;
	if ($EditGroups == '')
		$EditGroups = 0;	
	if ($DeleteGroups == '')
		$DeleteGroups = 0;	
	if ($UpdateTasks == '')
		$UpdateTasks = 0;	
	if (is_array($Projects))
	{
  	$TempProjects = '';
 	 foreach ($Projects as $value) {
   	  if ($TempProjects != '')
   	   $TempProjects .= ',';
   	 $TempProjects .= $value;
 	 }
 	 $ProjectString = $TempProjects;
	}
	$Users = $_POST['txtUsers'];
	if (is_array($Users))
	{
  	$TempUsers = '';
 	 foreach ($Users as $value) {
   	  if ($TempUsers != '')
   	   $TempUsers .= ',';
   	 $TempUsers .= $value;
 	 }
 	 $UserString = $TempUsers;
	}
	$query = "INSERT into pf_projects_groups (Title, Description, Users, ReadPermission, UploadFiles, DownloadFiles, ChangeFiles, CreateProjects, EditProjects, DeleteProjects,CreateTasks, EditTasks, UpdateTasks, DeleteTasks, AddUsers, EditUsers, DeleteUsers, CreateGroups, EditGroups, DeleteGroups) values ('$Title','$Description','$UserString',$Read,$UploadFiles,$DownloadFiles,$ChangeFiles,$CreateProjects,$EditProjects,$DeleteProjects,$CreateTasks,$EditTasks, $UpdateTasks, $DeleteTasks,$AddUsers,$EditUsers,$DeleteUsers,$CreateGroups,$EditGroups,$DeleteGroups)";
	$groups->query($query);
}

//NEW PROJECTS USER

if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'CREATE') && ($_POST['sub'] == 'user') ) {
	$groups = new DB();
	$Username = $_POST['txtUsername'];
	$UserType = $_POST['txtUserType'];
	$ProjectsUserType = $_POST['txtProjectsUserType'];
	$Groups = $_POST['txtProjectGroups'];
	if (is_array($Groups))
	{
  	$TempProjects = '';
 	 foreach ($Groups as $value) {
   	  if ($TempProjects != '')
   	   $TempProjects .= ',';
   	 $TempProjects .= $value;
 	 }
 	 $GroupString = $TempProjects;
	}
	$Users = $_POST['txtUsers'];
	$query = "INSERT into pf_projects_users(UserId, Username, Usertype, ProjectsUserType) values ('$UserID','$Username',$UserType,$ProjectsUserType)";
	$groups->query($query);
	SendProjectsUserDetails($Email, $Username, $_SERVER['SERVER_NAME']);
	$GroupCounter = 0;
	$UserGroups = explode(",", $GroupString);
	$NumGroups = sizeof($UserGroups);
		while ($GroupCounter < $NumGroups) {
				$NewGroupString = '';
				$GroupID = $UserGroups[$GroupCounter];
				$query = "Select Users from pf_projects_groups where id='$GroupID'";
				$CurrentUsersString = $groups->queryUniqueValue($query);
				if (strlen($CurrentUsersString ) >= 1) {
						$CurrentUsersString .= ','.$UserID;
				} else {
						$CurrentUsersString = $UserID;
				}
				$query = "update pf_projects_groups set users='$CurrentUsersString' where id='$GroupID'";
				$GroupCounter++;
		}
}


//EDIT GROUP 
if (($_GET['a'] == 'projects') && ($_POST['btnsubmit'] == 'SAVE') && ($_POST['sub'] == 'group')) {
	$groups = new DB();
	$GroupAlreadyActive == 0;
	$Title = $_POST['txtTitle'];
	$Description = $_POST['txtDescription'];
	$Read = $_POST['txtRead'];
	$Write = $_POST['txtWrite'];
	$Projects = $_POST['txtProjects'];
	$UploadFiles = $_POST['txtUpload'];
	$DownloadFiles = $_POST['txtDownload'];
	$ChangeFiles = $_POST['txtChangeFiles'];
	$CreateProjects = $_POST['txtCreateProjects'];
	$EditProjects = $_POST['txtEditProjects'];
	$DeleteProjects = $_POST['txtDeleteProjects'];
	$CreateTasks = $_POST['txtCreateTasks'];
	$EditTasks = $_POST['txtEditTasks'];
	$DeleteTasks = $_POST['txtDeleteTasks'];
	$AddUsers = $_POST['txtAddUsers'];
	$EditUsers = $_POST['txtEditUsers'];
	$DeleteUsers = $_POST['txtDeleteUsers'];
	$CreateGroups = $_POST['txtCreateGroups'];
	$EditGroups = $_POST['txtEditGroups'];
	$DeleteGroups = $_POST['txtDeleteGroups'];
	$UpdateTasks = $_POST['txtUpdateTasks'];
	if ($UpdateTasks == '')
		$UpdateTasks = 0;	
	if ($UploadFiles == '')
		$UploadFiles = 0;
	if ($DownloadFiles == '')
		$DownloadFiles = 0;	
	if ($ChangeFiles == '')
		$ChangeFiles = 0;	
	if ($CreateProjects == '')
		$CreateProjects = 0;
	if ($EditProjects == '')
		$EditProjects = 0;	
	if ($DeleteProjects == '')
		$DeleteProjects = 0;
	if ($CreateTasks == '')
		$CreateTasks = 0;
	if ($EditTasks == '')
		$EditTasks = 0;	
	if ($DeleteTasks == '')
		$DeleteTasks = 0;	
	if ($AddUsers == '')
		$AddUsers = 0;
	if ($EditUsers == '')
		$EditUsers = 0;	
	if ($DeleteUsers == '')
		$DeleteUsers = 0;
	if ($CreateGroups == '')
		$CreateGroups = 0;
	if ($EditGroups == '')
		$EditGroups = 0;	
	if ($DeleteGroups == '')
		$DeleteGroups = 0;	
	$PreviousProjectString = $_POST['txtCurrentProjectString'];
	$PreviousProjectArray = explode(",", $PreviousProjectString);
	$NumPreviousProjects = sizeof($PreviousProjectArray);
	//print "MY NUBER OF PREVIOUS PORJECTS = " . $NumPreviousProjects."<br/>";
	if (is_array($Projects)) {
  		$TempProjects = '';
 	 	foreach ($Projects as $value) {
   	 	 	if ($TempProjects != '')
   	   			$TempProjects .= ',';
   	 		$TempProjects .= $value;
		}
 	 	$ProjectString = $TempProjects;
	} if ($_POST['txtProjects']=='') {
		$ProjectString = '0';
	}
	$ProjectCounter = 0;	
	$RemoveProjectString = '';
	//print "PREVIOUS PROJECT STRING = " . $PreviousProjectString. "<br/>";
	//print "CURRENT PROJECT STRING = " . $ProjectString. "<br/>";
	if (strlen($PreviousProjectString) > strlen($ProjectString)) {
		while($ProjectCounter < $NumPreviousProjects) {
			$PreviousID = $PreviousProjectArray[$ProjectCounter];
			//print "MY PREVIOUS ID = " . $PreviousID. "<br/>";
			foreach ($Projects as $value) {
			$TestID = $value;
				if ($TestID == $PreviousID) {
					$RemoveID = 0;
				} else {
					$RemoveID = 1;
				}
			}
			if ($RemoveID == 1) {
				if (strlen($RemoveProjectString ) >= 1) {
						$RemoveProjectString .= ','.$PreviousID;
				} else {
						$RemoveProjectString = $PreviousID;
				}
			}
			$ProjectCounter++;
		}
	}
	//print "MY REMOVE STRING = " . $RemoveProjectString;

	$Users = $_POST['txtUsers'];
	
	if (is_array($Users)) {
  		$TempUsers = '';
 	 	foreach ($Users as $value) {
   	  		if ($TempUsers != '')
   	   			$TempUsers .= ',';
   	 	$TempUsers .= $value;
 	 	}
 	 	$UserString = $TempUsers;
	}
	$query = "UPDATE pf_projects_groups set Title='$Title', Description = '$Description', Users='$UserString', ReadPermission = '$Read', UploadFiles='$UploadFiles', DownloadFiles='$DownloadFiles', ChangeFiles='$ChangeFiles', CreateProjects='$CreateProjects', EditProjects='$EditProjects', DeleteProjects='$DeleteProjects', CreateTasks='$CreateTasks',EditTasks='$EditTasks', UpdateTasks ='$UpdateTasks', DeleteTasks='$DeleteTasks', AddUsers='$AddUsers', EditUsers='$EditUsers',DeleteUsers='$DeleteUsers',CreateGroups='$CreateGroups', EditGroups='$EditGroups', DeleteGroups='$DeleteGroups' where id='$GroupID'";
	$groups->query($query);
}?>