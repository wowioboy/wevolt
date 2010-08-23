
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  
<? 
// ADJUST THE CONTENT FRAME IF SIDEBAR IS ACTIVE

if ((($Sidebar == 1) && ($_GET['a'] !='gallery') && ($FrontGalleryVisible ==0)) || ($_GET['a'] =='blog')|| ($_SERVER['PHP_SELF'] =='/store.php')) {

if ($SidebarLayout == 'r') { ?> 
<td width="<? echo $SiteWidth - $SidebarWidth; ?>" valign="top" bgcolor="#000000" class="contentwrapper"> <? 
	// DISPLAY PAGE / POST / NEWS / BLOG
	echo $HtmlContent; 
	?></td>
	<td width="<? echo $SidebarWidth;?>" class='sidebar' valign="top" bgcolor="<? echo $SidebarBackgroundColor; ?>" align="center" style="padding:3px;">
	<? include 'includes/sidebar_inc.php';?>
	</td>
<? } else if ($SidebarLayout == 'l'){ ?>
	<td width="<? echo $SidebarWidth;?>" class='sidebar' valign="top" bgcolor="<? echo $SidebarBackgroundColor; ?>" align="center" style="padding:3px;">
	<? include 'includes/sidebar_inc.php';?>
	</td>
    <td width="<? echo $SiteWidth - $SidebarWidth; ?>" valign="top" bgcolor="#000000" class="contentwrapper">
    <? 	
	
	// DISPLAY PAGE / POST / NEWS / BLOG
	echo $HtmlContent; 

	?>
    </td>
<? }?>
<? } else if (($_GET['a'] !='gallery')  && ($FrontGalleryVisible ==0)){ ?>
<td width="100%" valign="top" bgcolor="#000000" class="contentwrapper">
<? 
	// DISPLAY PAGE / POST / NEWS / BLOG
	echo $HtmlContent;
	
	?>
</td>
<? }?>
<? 
// GALLERY SECTION
if ($Application == 'gallery') { ?> 
    <td width="100%" valign="top" bgcolor="#000000" class="contentwrapper" align="center">
<?
       if ($Template == 'flash') {
		   	if ((isset($_GET['id'])) && (isset($_GET['item']))) {
				include 'gallery/reader_inc.php';
			} else if ((isset($_GET['id'])) && (!isset($_GET['item']))) {
				include 'gallery/reader_inc.php';
			} else if ((!isset($_GET['id'])) && (isset($_GET['item']))) {
				include 'gallery/reader_inc.php';
			} else {
				include 'gallery/all_galleries_inc.php';
			}
		} else  if ($Template == 'java') {
		   	if (isset($_GET['id'])) {
				include 'gallery/java_reader_inc.php';
			} else {
				include 'gallery/all_galleries_inc.php';
			}
		} else {
				include 'gallery/all_galleries_inc.php';
		}
		
?>
</td>
<? }

if ((!isset($_GET['p'])) && (!isset($_GET['a'])) && ($FrontGalleryVisible == 1)) { ?> 
    <td width="100%" valign="top" bgcolor="#000000" class="contentwrapper" align="center">
<?
       if ($Template == 'flash') {
		   		include 'gallery/reader_front.php';
		} else  if ($Template == 'java') {
			//include 'gallery/java_reader_inc.php';
		}
		
?>
</td>
<? }?>

</tr>	
</table>