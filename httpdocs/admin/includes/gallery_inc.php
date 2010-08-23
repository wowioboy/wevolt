<? 
$menuString = "";
$db = new DB();
$query = "select * from pf_gallery_galleries";
$db->query($query);
$menuString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>GALLERY TITLE</td><td class='tableheader'>GALLERY TYPE</td><td class='tableheader'>NUMBER OF ITEMS</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
while ($line = $db->fetchNextObject()) { 
$menuString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtGallery' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>".$line->Type."</td><td class='listcell'>".$line->Items."</td></tr>";
	}
$GalleryCount = $db->numRows();
$menuString .= "</table>";
?>
<form method='post' action='admin.php?a=gallery'>
<table width='100%' border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contenttopleft"></td>
    <td  id='sidebartop'>&nbsp;</td>
    <td id='contenttop'>&nbsp;</td>
    <td id='contenttopright'>&nbsp;</td>
  </tr>
  <tr>
    <td id="contentleftside"></td>
    <td width="187" class='adminSidebar'><div class='adminSidebarHeader'><div style="height:7px;"></div>GALLERY</div>
     <div>	<? if ($GalleryCount > 0) { ?>CONTENT<br />

	<input type='submit' name='btnsubmit' value='UPLOAD CONTENT' id='submitstyle' style="text-align:left;"/><div class="inputspacer"></div><input type='submit' name='btnsubmit' value='LIST CONTENT' id='submitstyle' style="text-align:left;"/><div class="spacer"></div>
	<? } ?>GALLERIES<br />
<input type='submit' name='btnsubmit' value='NEW GALLERY' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT GALLERY' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE GALLERY' id='submitstyle' style="text-align:left;"><div class="spacer"></div>GALLERY CATEGORIES<br /> <input type='submit' name='btnsubmit' value='NEW CATEGORY' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT CATEGORIES' id='submitstyle' style="text-align:left;"></div></td>
    <td class='adminContent' valign="top"><? echo $menuString; ?></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
</form>
