<? if ($_GET['a']=='store') {
	$AppSet = 1;
	    if ($_GET['sub'] == 'cat') {
			if ($_POST['btnsubmit'] == 'EDIT') {
				if ($_POST['txtCat'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Category first');
					 </script>
			 <? 
			 include 'includes/store_cats_inc.php';
			 	} else {
					include 'includes/edit_store_cat_inc.php';
				}
			}else if ($_POST['btnsubmit'] == 'DELETE') {
					include 'includes/delete_store_cat_inc.php';
			}else if (($_POST['btnsubmit'] == 'NEW')  || ($_POST['btnsubmit'] == 'CREATE STORE CATEGORY')) {
					include 'includes/new_store_cat_inc.php';
			} else {
			include 'includes/store_cats_inc.php';
			}
		} else if ($_GET['sub'] == 'item') {
			if (($_POST['btnsubmit'] == 'EDIT') || (isset($_GET['id']))) {
				if ($ItemID == '') {
				$ItemID = $_GET['id'];
				}
					include 'includes/edit_store_item_inc.php';
			}else if ($_POST['btnsubmit'] == 'DELETE') {
					include 'includes/delete_store_item_inc.php';
			}else if ($_GET['task'] == 'edit') {
					include 'includes/edit_store_item_inc.php';
			}else if ($_POST['btnsubmit'] == 'NEW') {
					include 'includes/upload_store_item_inc.php';
			} else {
			include 'includes/store_inc.php';
			}
		} else if ($_POST['btnsubmit'] == 'EDIT CATEGORIES') {
					include 'includes/store_cats_inc.php';
			}else if ($_POST['btnsubmit'] == 'NEW CATEGORY') {
					include 'includes/new_store_cat_inc.php';
			}else if ($_POST['btnsubmit'] == 'CHANGE IMAGE') {
					include 'includes/change_store_image_inc.php';
			}else if ($_POST['btnsubmit'] == 'NEW ITEM') {
					include 'includes/upload_store_item_inc.php';
			} else if (($_POST['btnsubmit'] == 'EDIT ITEM') || (isset($_GET['id']))) {
			if ($ItemID == '') {
				$ItemID = $_GET['id'];
				}
					include 'includes/edit_store_item_inc.php';
			} else if ($_POST['btnsubmit'] == 'DELETE ITEM') {
					include 'includes/delete_store_item_inc.php';
			}else {
			include 'includes/store_inc.php';
		
		}			
	} ?>