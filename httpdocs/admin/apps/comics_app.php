 <? // FAQ SECTION ?>
	<? if ($_GET['a']=='comics') {
	$AppSet = 1;
		 if (($_POST['btnsubmit'] == 'EDIT') || (isset($_GET['id']))) {
		 if ($ItemID == '') {
		 	$ItemID = $_GET['id'];
		 } 
		if ($ItemID == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You must select a comic first');
					 </script>
              <?  
			  include 'includes/comics_inc.php';
			  } else {
			include 'includes/edit_comic_inc.php';
			}
		} else if ($_POST['btnsubmit'] == 'DELETE') {
			include 'includes/delete_comic_inc.php';
		} else if ($_POST['btnsubmit'] == 'CREATE') {
			include 'includes/new_comic_inc.php';
		} else {
			include 'includes/comics_inc.php';
		} 
	} 
	
	?>