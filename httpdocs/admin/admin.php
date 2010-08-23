<?  
//if (!file_exists('includes/config.php')) {
//if (!file_exists('install/index.php')) {
   //  header('Location: /noconfig.php');
	// } else {
	 
	// header('Location: install/index.php');
	// }
   // echo "The file $filename exists";
//}	
include_once("includes/init.php"); 
include("includes/email_functions.php"); 
$Pagetracking = 'admin'; 
$PageTitle = 'Admin'; 
$AppSet = 0;
if ($_SESSION['usertype'] < 2) {
	header("location:login.php");
}

//MENU FUNCTIONS
include 'processing/menu_functions.php';
//STATIC PAGES
include 'processing/page_functions.php';
//BLOG FUNCTIONS
include 'processing/blog_functions.php';
//PANEL FLOW CONTENT
include 'processing/content_functions.php';
//SITE SETTINGS
include 'processing/settings_functions.php';
//GALLERY SETTINGS
include 'processing/gallery_functions.php';
//MODULES 
include 'processing/modules_functions.php';
//RSS 
include 'processing/rss_functions.php';
//FAQ 
include 'processing/faq_functions.php';
//CREATE NEW USER
include 'processing/user_functions.php';
//COMICS
include 'processing/comics_functions.php';
//PROJECTS SECTION 
include 'processing/projects_functions.php';	
//STORE SECTION 
include 'processing/store_functions.php';
?>
<?php include 'includes/admin_header.php'; ?>
<div class="contentwrapper" align="center">
<? include 'includes/adminmenu.php';?>
<div class="contentwrapper">

<table width="995" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%" valign="top" >
	
	<? // MENU SECTION  
	include 'apps/menu_app.php';
	?>
    
	<? // STATIC PAGES  
	include 'apps/static_pages_app.php';
	?>
		<? // BLOG SECTION 
		include 'apps/blog_app.php';
	?>
	<? // COMICS SECTION 
		include 'apps/comics_app.php';
	?>
	<? // CONTENT SECTION 
	include 'apps/content_app.php';
	?>
    
     <? // PROJECTS SECTION 
	 include 'apps/projects_app.php';
	 ?>
	<? // GALLERY SECTION 
	include 'apps/gallery_app.php';
	?>
    <? // STORE SECTION 
		include 'apps/store_app.php';
	?>
     <? // STORE SECTION 
		include 'apps/faq_app.php';
	?>
	
	
	<? // MEDIA SECTION ?>
	<? if ($_GET['a']=='media') {
	$AppSet = 1;
				include 'includes/media_inc.php';
	} ?>
	

	
	<? // SETTINGS SECTION ?>
	<? if (($_GET['a']=='settings') || (isset($_POST['txtButton']))) {
	$AppSet = 1;
				include 'includes/settings_inc.php';
	} ?>
	
	<? // USERS SECTION ?>
	<? if ($_GET['a']=='users') {
	$AppSet = 1;
		 if ($_POST['btnsubmit'] == 'NEW USER') {
			include 'includes/new_user_inc.php';
		} else if ($_POST['btnsubmit'] == 'EDIT USER') {
		if ($_POST['txtUser'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a User first');
					 </script>
              <? 
			  include 'includes/users_inc.php';
			  } else {
			include 'includes/edit_user_inc.php';
			}
		} else if ($_POST['btnsubmit'] == 'DELETE USER') {
			include 'includes/delete_user_inc.php';
		} else if ($reg_error == "") {
			include 'includes/users_inc.php';
		} else {
			include 'includes/new_user_inc.php';
		} 
	} 
	
	?>
	
	<? // MODULE SECTION ?>
	<? if ($_GET['a']=='modules') {
	$AppSet = 1;
			if  ($_POST['btnsubmit'] == 'EDIT MODULE') {
			if ($_POST['txtModule'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must select a Module first');
					 </script>
              <? 
			  include 'includes/module_inc.php';
			  } else {
				include 'includes/edit_module_inc.php';
				}
			} else {
				include 'includes/module_inc.php';
			}
		}
		
	 ?>
	 
			<? // RSS SECTION ?>
	<? if ($_GET['a']=='rss') {
	$AppSet = 1;
			if  ($_POST['btnsubmit'] == 'EDIT RSS FEED') {
			if ($_POST['txtRss'] == "") { ?>
					 <script language="javascript" type="text/javascript">
							alert('You Must Select an RSS Feed First');
					 </script>
              <? 
			  include 'includes/rss_inc.php';
			  } else {
				include 'includes/edit_rss_inc.php';
				}
			} else {
				include 'includes/rss_inc.php';
			}
		}
		
	 ?>
	 
	
    
    <? if ($AppSet == 0) { ?><div style="height:40px;"></div><div class='welcome'>SELECT ONE OF THE MENU ITEMS ABOVE OR ONE OF THE QUICK LINKS BELOW</div><div class='spacer'></div><div class='spacer'></div>
    
      <div class='spacer'></div><div class='dashheader'>MENU</div><div class="dashbuttons">
    <form method="post" action="admin.php?a=menu">
    <table width="300" cellpadding="0" cellspacing="0" border="0"><tr><td>
    <input type='submit' name='btnsubmit' value='CREATE NEW MENU' id='submitstyle' style="text-align:left;">
    <div class="inputspacer"></div>
    <input type='submit' name='btnsubmit' value='LIST MENU ITEMS' id='submitstyle' style="text-align:left;">
    </div></td></tr></table>
    </form> 
    
    <div class='spacer'></div>

    <div class='dashheader'>SITE CONTENT</div>
    <div class="dashbuttons">
    <form method="post" action="admin.php?a=content">
    <table width="300" cellpadding="0" cellspacing="0" border="0"><tr><td>
    <input type='submit' name='btnsubmit' value='POST NEW CONTENT' id='submitstyle' style="text-align:left;">
    <div class="inputspacer"></div>
    <input type='submit' name='btnsubmit' value='CREATE CONTENT SECTION' id='submitstyle' style="text-align:left;">
    <div class="inputspacer"></div>
    <input type='submit' name='btnsubmit' value='CREATE CONTENT CATEGORY' id='submitstyle' style="text-align:left;">
    <div class="inputspacer"></div>
    <input type='submit' name='btnsubmit' value='LIST CONTENT' id='submitstyle' style="text-align:left;">
    </div>
    </td></tr></table>
    </form> 
    
    <div class='spacer'></div>

    <div class='dashheader'>STATIC PAGES</div>
    <div class="dashbuttons">
    <form method="post" action="admin.php?a=pages">
    <table width="300" cellpadding="0" cellspacing="0" border="0"><tr><td>
    <input type='submit' name='btnsubmit' value='CREATE STATIC PAGE' id='submitstyle' style="text-align:left;">
    <div class="inputspacer"></div>
    <input type='submit' name='btnsubmit' value='LIST PAGES' id='submitstyle' style="text-align:left;">
    </div>
    </td></tr></table>
    </form> 
    
      <div class='spacer'></div>

    <div class='dashheader'>GALLERY</div>
    <div class="dashbuttons">
    <form method="post" action="admin.php?a=blog">
    <table width="300" cellpadding="0" cellspacing="0" border="0"><tr><td>
    <input type='submit' name='btnsubmit' value='NEW BLOG POST' id='submitstyle' style="text-align:left;">
    <div class="inputspacer"></div>
    <input type='submit' name='btnsubmit' value='CREATE BLOG CATEGORY' id='submitstyle' style="text-align:left;">
    <div class="inputspacer"></div>
    <input type='submit' name='btnsubmit' value='LIST BLOG POSTS' id='submitstyle' style="text-align:left;">
    </div>
    </td></tr></table>
    </form> 
    
   <div class='spacer'></div>

    <div class='dashheader'>GALLERY</div>
    <div class="dashbuttons">
    <form method="post" action="admin.php?a=gallery">
    <table width="300" cellpadding="0" cellspacing="0" border="0"><tr><td>
    <input type='submit' name='btnsubmit' value='CREATE NEW GALLERY' id='submitstyle' style="text-align:left;">
    <div class="inputspacer"></div>
    <input type='submit' name='btnsubmit' value='CREATE GALLERY CATEGORY' id='submitstyle' style="text-align:left;">
    <div class="inputspacer"></div>
    <input type='submit' name='btnsubmit' value='LIST GALLERIES' id='submitstyle' style="text-align:left;">
    </div>
    </td></tr></table>
    </form> 
         

<? } ?>
	
	</td>
  </tr>
</table>
</div>
</div>			
<?php include 'includes/footer.php'; ?>	