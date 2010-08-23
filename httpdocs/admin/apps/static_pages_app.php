<? if ($_GET['a']=='pages') {
	$AppSet = 1;
			if (($_POST['btnsubmit'] == 'NEW')  || ($_POST['btnsubmit'] == 'CREATE STATIC PAGE')) {
				include 'includes/new_page_inc.php';
			} else 
			if ($_POST['btnsubmit'] == 'DELETE') {
					include 'includes/delete_page_inc.php';
			} else 
			if (($_POST['btnsubmit'] == 'EDIT') || (isset($_GET['id']))) {
				if ($_POST['txtPage'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Page first');
					 </script>
			 <? 
			 include 'includes/pages_inc.php';
			 } else {
			include 'includes/edit_page_inc.php';
			}
			} else {
				include 'includes/pages_inc.php';
			}
	} ?>