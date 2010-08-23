 <? // FAQ SECTION ?>
	<? if ($_GET['a']=='faq') {
	$AppSet = 1;
		 if ($_POST['btnsubmit'] == 'NEW') {
			include 'includes/new_faq_inc.php';
		} else if ($_POST['btnsubmit'] == 'EDIT') {
		if ($_POST['txtItem'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You must select an item first');
					 </script>
              <?  
			  include 'includes/faq_inc.php';
			  } else {
			include 'includes/edit_faq_inc.php';
			}
		} else if ($_POST['btnsubmit'] == 'DELETE') {
			include 'includes/delete_faq_inc.php';
		} else if ($reg_error == "") {
			include 'includes/faq_inc.php';
		} else {
			include 'includes/new_faq_inc.php';
		} 
	} 
	
	?>