<? if ($_GET['a']=='projects') {
	$AppSet = 1;
			if  ($_POST['btnsubmit'] == 'EDIT PROJECT') {
			if ($_POST['txtProject'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Project first');
					 </script>
			 <? 
			 include 'includes/projects_inc.php';
			 } else {
				include 'includes/edit_project_inc.php';
				}
			} else if  ($_POST['btnsubmit'] == 'NEW PROJECT') {
				include 'includes/new_project_inc.php';
			} else if  ($_POST['btnsubmit'] == 'DELETE PROJECT') {
				include 'includes/delete_project_inc.php';
			} else if  ($_POST['btnsubmit'] == 'EDIT TASK') {
			if ($_POST['txtTask'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Task first');
					 </script>
			 <? 
			 include 'includes/tasks_inc.php';
			 } else {
				include 'includes/edit_task_inc.php';
			}
			}else if  ($_POST['btnsubmit'] == 'DELETE TASK') {
			if ($_POST['txtTask'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Task first');
					 </script>
			 <? 
			 include 'includes/tasks_inc.php';
			 } else {
				include 'includes/delete_task_inc.php';
				}
			} else if  ($_POST['btnsubmit'] == 'DELETE FILE') {
				include 'includes/delete_project_file_inc.php';
			} else if  (($_POST['btnsubmit'] == 'EDIT FILE') || ($_POST['sub'] == 'file') && (isset($_GET['id'])))  {
				if ($FileID == '') {
					$FileID = $_GET['id'];
				}
				include 'includes/edit_projects_file_inc.php';
			}else if  ($_POST['btnsubmit'] == 'NEW TASK') {
			 	if ($_POST['txtProject'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Project first');
					 </script>
			 <? 
			 include 'includes/projects_inc.php';
			 } else {
					include 'includes/new_task_inc.php';
				}
			} else if (($_POST['btnsubmit'] == 'VIEW ACTIVE TASKS') || ($_POST['sub'] == 'task'))  {
				include 'includes/tasks_inc.php';
			}else if ($_POST['btnsubmit'] == 'UPLOAD FILE')  {
				include 'includes/upload_project_file_inc.php';
			}else if (($_POST['btnsubmit'] == 'VIEW FILES') || ($_POST['sub'] == 'file')|| ($_GET['sub'] == 'file')) {
				include 'includes/project_files_inc.php';
			}else if ($_POST['btnsubmit'] == 'EDIT USERS')  {
				include 'includes/projects_users_inc.php';
			}else if (($_POST['btnsubmit'] == 'EDIT GROUPS') || ($_POST['sub'] == 'group') || ($_GET['sub'] == 'group'))  {
				include 'includes/projects_groups_inc.php';
			}else if ($_POST['btnsubmit'] == 'NEW GROUP')  {
				include 'includes/new_projects_group_inc.php';
			}else if ($_POST['btnsubmit'] == 'EDIT GROUP')  {
				include 'includes/edit_projects_group_inc.php';
			}else if ($_POST['btnsubmit'] == 'DELETE GROUP')  {
				include 'includes/delete_projects_group_inc.php';
			}else if ($_POST['btnsubmit'] == 'IMPORT USER')  {
				include 'includes/new_projects_user_inc.php';
			}else if ($_POST['btnsubmit'] == 'NEW USER')  {
				include 'includes/system_user_import_inc.php';
			}else if ($_POST['btnsubmit'] == 'EDIT USER')  {
				include 'includes/edit_projects_user_inc.php';
			}else {
				include 'includes/projects_inc.php';
			}
		}
	 ?>
	