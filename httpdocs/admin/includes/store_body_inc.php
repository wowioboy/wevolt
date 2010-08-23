
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  
<? 
// ADJUST THE CONTENT FRAME IF SIDEBAR IS ACTIVE
if (($Sidebar == 1) && (!isset($_GET['item']))){ ?>
<td width="<? echo $SiteWidth - $SidebarWidth; ?>" valign="top" bgcolor="#000000" class="contentwrapper">
<? } else{ ?>
<td width="100%" valign="top" bgcolor="#000000" class="contentwrapper">
<? }
	// DISPLAY PAGE / POST / NEWS / BLOG
	if ((isset($_GET['item'])) && (!isset($_GET['cat']))) { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td valign="top" ><img src='<? echo $ItemImage;?>' /></td><td valign="top" width="183"><div class='itemtitle'><? echo $Title;?><div class='spacer'></div><div class='itemdescription'><? echo $Description; ?></div><div class='spacer'></div><div class='itemprice'>PRICE: <? echo $Price;?></div><? include 'includes/buy_button_inc.php';?></td></tr></table>
<? } else {
	if ($_GET['a'] == 'thanks') {
		echo "<div class='thanksmessage'>".$ThankYou."</div>";
	} else  {
		echo $FeaturedString;
	}
}
	?>
</td>


<?   
//SHOW SIDEBAR
if (($Sidebar == 1) && (!isset($_GET['item']))){ ?>
	<td width="<? echo $SidebarWidth;?>" class='sidebar' valign="top" bgcolor="<? echo $SidebarBackgroundColor; ?>" align="center" style="padding:3px;">
	<? include 'includes/sidebar_inc.php';?>
	</td>
<? }  ?>

</tr>	
</table>