<? if ($_GET['a']=='menu') {
	$AppSet = 1;
			if (($_POST['btnsubmit'] == 'NEW') || ($_GET['action'] == 'new') || ($_POST['btnsubmit'] == 'CREATE NEW MENU')) {
				include 'includes/new_menu_inc.php';
			} else 
			if ($_POST['btnsubmit'] == 'DELETE') {
				$MenuID = $_POST['txtMenu'];
				if ($MenuID == "") { ?>
						 <script language="javascript" type="text/javascript">
								alert('You Must select a Menu Item first');
						 </script>
			 		<? 
					include 'includes/menu_inc.php';
			 		} else {
				include 'includes/delete_menu_inc.php';
				}
			} else 
			if (($_POST['btnsubmit'] == 'EDIT') || ($_GET['action'] == 'change')) {
				if ($_POST['btnsubmit'] == 'EDIT') {
					if ($_POST['txtMenu'] == "") { ?>
						 <script language="javascript" type="text/javascript">
								alert('You Must select a Menu first');
						 </script>
			 		<? 
					include 'includes/menu_inc.php';
			 		} else {
						include 'includes/edit_menu_inc.php';
					}
				} else {
					include 'includes/edit_menu_inc.php';
				}	
			} else 
			if ($_POST['btnsubmit'] == 'MOVE UP') {
					if ($_POST['txtMenu'] == "") { ?>
						 <script language="javascript" type="text/javascript">
								alert('You Must select a Menu first');
						 </script>
			 		<? }
					include 'includes/menu_inc.php';
			}else
			if ($_POST['btnsubmit'] == 'MOVE DOWN') {
					if ($_POST['txtMenu'] == "") { ?>
						 <script language="javascript" type="text/javascript">
								alert('You Must select a Menu first');
						 </script>
			 		<? }
					include 'includes/menu_inc.php';
			}else {
				include 'includes/menu_inc.php';
			}
	} ?>