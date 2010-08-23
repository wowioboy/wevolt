<? if ($_GET['a']=='blog') {
	$AppSet = 1;
	    if ($_GET['sub'] == 'cat') {
			if ($_POST['btnsubmit'] == 'EDIT') {
			if ($_POST['txtCat'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Category first');
					 </script>
              <? 
			  include 'includes/blog_cats_inc.php';
			  } else {
					include 'includes/edit_blog_cat_inc.php';
				}
			}else 
			if ($_POST['btnsubmit'] == 'DELETE') {
					include 'includes/delete_blog_cat_inc.php';
			}else 
			if ($_POST['btnsubmit'] == 'NEW') {
					include 'includes/new_blog_cat_inc.php';
			}
		} else if ($_GET['sub'] == 'link') {
			if ($_POST['btnsubmit'] == 'EDIT') {
			if ($_POST['txtLink'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Link first');
					 </script>
              <? 
			  include 'includes/blog_links_inc.php';
			  } else {
					include 'includes/edit_blog_link_inc.php';
				}
			}else 
			if ($_POST['btnsubmit'] == 'DELETE') {
					include 'includes/delete_blog_link_inc.php';
			}else 
			if ($_POST['btnsubmit'] == 'NEW') {
					include 'includes/new_blog_link_inc.php';
			}
		}else {
		if (($_POST['btnsubmit'] == 'NEW')  || ($_POST['btnsubmit'] == 'NEW BLOG POST')) {
				include 'includes/new_blog_post_inc.php';
			} else 
			if (($_POST['btnsubmit'] == 'NEW CATEGORY')  || ($_POST['btnsubmit'] == 'CREATE BLOG CATEGORY')) {
					include 'includes/new_blog_cat_inc.php';
			}else 
			if (($_POST['btnsubmit'] == 'EDIT CATEGORIES') || ($_POST['sub'] == 'cat')) {
					include 'includes/blog_cats_inc.php';
			}else 
			if (($_POST['btnsubmit'] == 'EDIT LINKS') || ($_POST['sub'] == 'link')) {
					include 'includes/blog_links_inc.php';
			}else 
			if ($_POST['btnsubmit'] == 'NEW LINK') {
					include 'includes/new_blog_link_inc.php';
			} else 
			if ($_POST['btnsubmit'] == 'DELETE') {
					include 'includes/delete_blog_post_inc.php';
			} else 
			if ($_POST['btnsubmit'] == 'EDIT') {
			if ($_POST['txtPost'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Post first');
					 </script>
              <? 
			  include 'includes/blog_inc.php';
			  } else {
			include 'includes/edit_blog_post_inc.php';
			}
			} else {
				include 'includes/blog_inc.php';
			}
		
		}
			
	} ?>