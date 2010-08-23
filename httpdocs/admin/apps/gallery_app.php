<? if ($_GET['a']=='gallery') {
	$AppSet = 1;
	    if ($_GET['sub'] == 'cat') {
			if ($_POST['btnsubmit'] == 'EDIT') {
				if ($_POST['txtCat'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Category first');
					 </script>
			 <? 
			 include 'includes/gallery_cats_inc.php';
			 } else {
					include 'includes/edit_gallery_cat_inc.php';
					}
			}else 
			if ($_POST['btnsubmit'] == 'DELETE') {
					include 'includes/delete_gallery_cat_inc.php';
			}else 
			if (($_POST['btnsubmit'] == 'NEW')  || ($_POST['btnsubmit'] == 'CREATE GALLERY CATEGORY')) {
					include 'includes/new_gallery_cat_inc.php';
			}
		} else if ($_GET['sub'] == 'item') {
			if (($_POST['btnsubmit'] == 'EDIT') || (isset($_GET['id']))) {
			if ($ItemID == '') {
			$ItemID = $_GET['id'];
			}
					include 'includes/edit_gallery_item_inc.php';
			}else 
			if ($_POST['btnsubmit'] == 'DELETE') {
					include 'includes/delete_gallery_item_inc.php';
			}else 
			if ($_GET['task'] == 'edit') {
					include 'includes/edit_gallery_item_inc.php';
			}else 
			if ($_POST['btnsubmit'] == 'NEW') {
					include 'includes/new_gallery_item_inc.php';
			} else 
			if ($_POST['btnsubmit'] == 'CHANGE IMAGE') {
					include 'includes/change_gallery_image_inc.php';
			} else {
				include 'includes/gallery_content_inc.php';
			}
		} else {
		if (($_POST['btnsubmit'] == 'NEW GALLERY') || ($_GET['task'] == 'new')  || ($_POST['btnsubmit'] == 'CREATE NEW GALLERY')) {
				include 'includes/new_gallery_inc.php';
			} else 
			if ($_POST['btnsubmit'] == 'NEW CATEGORY') {
					include 'includes/new_gallery_cat_inc.php';
			}else 
			if (($_POST['btnsubmit'] == 'EDIT CATEGORIES') || ($_POST['sub'] == 'cat')) {
					include 'includes/gallery_cats_inc.php';
			}else 
			if ($_POST['btnsubmit'] == 'DELETE GALLERY') {
					include 'includes/delete_gallery_inc.php';
			} else 
			if ($_POST['btnsubmit'] == 'LIST CONTENT') {
					include 'includes/gallery_content_inc.php';
			}else 
			if (($_POST['btnsubmit'] == 'EDIT GALLERY')  || ($_GET['task'] == 'change')) {
			if ($_POST['btnsubmit'] == 'EDIT GALLERY') {
				if ($_POST['txtGallery'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Gallery first');
					 </script>
            	  <? 
			 	 include 'includes/gallery_inc.php';
			 	 } else {
					include 'includes/edit_gallery_inc.php';
				 }
			} else {
				include 'includes/edit_gallery_inc.php';
			} 
			} else 
			if (($_POST['btnsubmit'] == 'UPLOAD CONTENT') || ($_POST['btnsubmit'] == 'UPLOAD ITEM')) {
				 if ($_POST['txtGallery'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Gallery first');
					 </script>
				 <?
				 include 'includes/gallery_inc.php';
				  } else {
			
				 	include 'includes/upload_gallery_items_inc.php';
				 }
			} else 
			if ($_GET['task'] == 'upload') {
				include 'includes/upload_gallery_items_inc.php';
			}else 
			if ($_GET['task'] == 'editupload') {
				include 'includes/edit_gallery_upload_inc.php';
			}else 
			if ($_POST['btnsubmit'] == 'DELETE ITEM') {
					include 'includes/delete_gallery_item_inc.php';
			}else 
			if ($_POST['btnsubmit'] == 'EDIT ITEM')  {
					include 'includes/edit_gallery_item_inc.php';
			} else 
			if ($_POST['btnsubmit'] == 'CHANGE IMAGE') {
					include 'includes/change_gallery_image_inc.php';
			}  else {
				include 'includes/gallery_inc.php';
			}
		
		}
			
	} ?>