<? if ($_GET['a']=='content') {
	$AppSet = 1;
	    if ($_GET['sub'] == 'cat') {
			if ($_POST['btnsubmit'] == 'EDIT') {
			if ($_POST['txtCat'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Category first');
					 </script>
              <? 
			  include 'includes/content_cats_inc.php';
			  } else {
					include 'includes/edit_content_cat_inc.php';
					}
			}else 
			if ($_POST['btnsubmit'] == 'DELETE') {
			if ($_POST['txtCat'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Category first');
					 </script>
              <? 
			  include 'includes/content_cats_inc.php';
			  } else {
					include 'includes/delete_content_cat_inc.php';
					}
			}else 
			if (($_POST['btnsubmit'] == 'NEW')  || ($_POST['btnsubmit'] == 'CREATE CONTENT CATEGORY'))  {
					include 'includes/new_content_cat_inc.php';
			} else {
				include 'includes/content_cats_inc.php';
			}
		} else 
		if ($_GET['sub'] == 'section') {
			if ($_POST['btnsubmit'] == 'EDIT') {
			if ($_POST['txtSection'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Section first');
					 </script>
              <? 
			  include 'includes/content_section_inc.php';
			  } else {
					include 'includes/edit_content_section_inc.php';
					}
			}else 
			if ($_POST['btnsubmit'] == 'DELETE') {
				if ($_POST['txtSection'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Section first');
					 </script>
              <? 
			  include 'includes/content_section_inc.php';
			  } else {
					include 'includes/delete_content_section_inc.php';
					}
			}else 
			if (($_POST['btnsubmit'] == 'NEW')  || ($_POST['btnsubmit'] == 'CREATE CONTENT SECTION')) {
					include 'includes/new_content_section_inc.php';
			}else {
				include 'includes/content_section_inc.php';
			}
		} else {
		if (($_POST['btnsubmit'] == 'NEW') || ($_GET['task'] == 'new')  || ($_POST['btnsubmit'] == 'POST NEW CONTENT')) {
				include 'includes/new_content_post_inc.php';
			} else 
			if ($_POST['btnsubmit'] == 'NEW CATEGORY') {
					include 'includes/new_content_cat_inc.php';
			}else 
			if (($_POST['btnsubmit'] == 'EDIT CATEGORIES') || ($_POST['sub'] == 'cat')) {
					include 'includes/content_cats_inc.php';
			}else 
			if ($_POST['btnsubmit'] == 'NEW SECTION') {
					include 'includes/new_content_section_inc.php';
			}else 
			if (($_POST['btnsubmit'] == 'EDIT SECTIONS') || ($_POST['sub'] == 'section')) {
					include 'includes/content_section_inc.php';
			}else 
			if ($_POST['btnsubmit'] == 'DELETE') {
			if ($_POST['txtPost'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Post first');
					 </script>
              		<? 
				 include 'includes/content_inc.php';
			  } else {
					include 'includes/delete_content_post_inc.php';
					}
			} else 
			if (($_POST['btnsubmit'] == 'EDIT') || ($_GET['task'] == 'change')) {
				if ($_POST['btnsubmit'] == 'EDIT') {
					if ($_POST['txtPost'] == "") { ?>
							 <script language="javascript" type="text/javascript">
									alert('You Must select a Post first');
							 </script>
              		<? 
			 		 include 'includes/content_inc.php';
			 		} else {
					include 'includes/edit_content_post_inc.php';
					}
				} else {
				include 'includes/edit_content_post_inc.php';
				}
			
			} else {
				include 'includes/content_inc.php';
			}
		
		}
			
	} ?>