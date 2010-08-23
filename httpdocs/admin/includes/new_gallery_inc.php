<? 
$GalleryType = $_GET['type'];
$Template = $_GET['template'];
$catString = "";
	$db = new DB();
	$query = "select * from pf_gallery_categories order by ID ASC";
	$db->query($query);
	$catString = "<select name='txtCategory' style='width:100%;' class='inputstyle' size='3' miltiple='yes'>";
	while ($line = $db->fetchNextObject()) { 
		$catString .= "<OPTION VALUE='".$line->ID."'>".$line->Title."</OPTION>";
	}
	$catString .= "</select>";

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
    <td width="187" class='adminSidebar'><div class='adminSidebarHeader'><div style="height:7px;"></div>
     NEW GALLERY</div>
<input type='submit' name='btnsubmit' value='CREATE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='CANCEL' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="172" height="73" valign="top"  class="contentbox">GALLERY TYPE<br />
<select class='inputstyle'  onchange='window.location = this.options[this.selectedIndex].value; '><OPTION VALUE='no'>Select-</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=image' <? if ($GalleryType == 'image') { echo 'selected';}?>>Image Gallery</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=video' <? if ($GalleryType == 'video') { echo 'selected';}?>>Video Gallery</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=music' <? if ($GalleryType == 'music') { echo 'selected';}?>>Music Gallery</OPTION>
</select></td><td width="329" valign="top"  class="contentbox">

<? 
if (($GalleryType != "") && ($GalleryType != 'no'))  { ?>
SELECT TEMPLATE TYPE<br />
<? if ($GalleryType =='image') { ?>
<select class='inputstyle' onchange='window.location = this.options[this.selectedIndex].value; '>	<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>'>Select Type --</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=flash' <? if ($Template == 'flash') { echo 'selected';}?>>Flash Display with sliding Thumbnail scroller</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=java' <? if ($Template == 'java') { echo 'selected';}?>>HTML thumbnail browser / Pop up Lightbox Image</OPTION>
</select>
<? } else if ($GalleryType =='video') { ?>
<select class='inputstyle'  onchange='window.location = this.options[this.selectedIndex].value; '>	<OPTION VALUE='0'>Select -</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=hb' <? if ($Template == 'hb') { echo 'selected';}?>>Horizontal Thumbnail Bar - Bottom</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=ht' <? if ($Template == 'ht') { echo 'selected';}?>>Horizontal Thumbnail Bar - Top</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=vl' <? if ($Template == 'vl') { echo 'selected';}?>>Vertical Thumbnail Bar - Left</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=vr' <? if ($Template == 'vr') { echo 'selected';}?>>Vertical Thumbnail Bar - Right</OPTION>
</select>
<? } else if ($GalleryType =='music') { ?>
<select class='inputstyle'  onchange='window.location = this.options[this.selectedIndex].value; '>	<OPTION VALUE='0'>Select -</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=hb' <? if ($Template == 'hb') { echo 'selected';}?>>Horizontal Thumbnail Bar - Bottom</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=ht' <? if ($Template == 'ht') { echo 'selected';}?>>Horizontal Thumbnail Bar - Top</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=vl' <? if ($Template == 'vl') { echo 'selected';}?>>Vertical Thumbnail Bar - Left</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=vr' <? if ($Template == 'vr') { echo 'selected';}?>>Vertical Thumbnail Bar - Right</OPTION>
</select>
<? } ?>
<? } ?></td>
	<td colspan="2" valign="top" class="contentbox">
	<? if ($Template != "") { ?>
	SELECT CATEGORIES (optional)<br /> 
	<? echo $catString; }?>   </td>
	</tr>
   
   <? if ($Template == 'flash')  { ?>
    <tr>
    <td rowspan="2" valign="top"  class="contentbox"><b>FLASH GALLERY</b><br />
(min = 550 / max = 1024)<br />
<input type="text" maxlength="4" name="txtWidth" value="<? echo $Width;?>"/><div class="medspacer"></div>
GALLERY HEIGHT <br />
(min = 300 / max = 1024)<br />
<input type="text" maxlength="4" name="txtHeight" value="<? echo $Height;?>"/></td>
	<td rowspan="2" valign="top" class="contentbox">GALLERY TITLE <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/><div class="spacer"></div>GALLERY DESCRIPTION <br />
<textarea class='inputstyle' name="txtDescription" style='width:100%;'><? echo $GalleryDescription;?></textarea><div class="spacer"></div>THUMBNAIL BROWSER SETTINGS<div class="spacer"></div>THUMBNAIL SIZE:<br /><input type="radio" name="txtThumbSize" value='50' />SMALL (50 PIXELS 2x12) <input type="radio" name="txtThumbSize" value='100' checked />LARGE (100 PIXELS 1x6)
<div class="spacer"></div>THUMBNAIL BROWSER PLACEMENT:<br />
<input type="radio" name="txtThumbnailPlacement" value='top' />TOP 
<input type="radio" name="txtThumbnailPlacement" value='bottom' checked />BOTTOM <div class="spacer"></div><div class="spacer"></div><div class="subsection_header">THUMBNAIL BROWSER SCROLLING DIRECTION:</div>
<input type="radio" name="txtThumbBrowserDirection" value='vertical' checked >/>VERTICAL 

<input type="radio" name="txtThumbBrowserDirection" value='horizontal' />HORIZONTAL <div class="spacer"></div>CONTROL SETTINGS:<br />
SHOW TOP CONTROLS: <input type="radio" name="txtTopControl" value='1' checked/>YES  <input type="radio" name="txtTopControl" value='0' />  NO<br />SHOW BOTTOM CONTROLS: <input type="radio" name="txtBottomControl" value='1' checked />YES  <input type="radio" name="txtBottomControl" value='0' />  NO </td>
	<td width="326" rowspan="2" valign="top"  class="contentbox">ALLOW COMMENTS:<br />
<input type="radio" name="txtComments" value="1" <? if (($Comments == 1) || ($Comments == "")) {echo 'checked'; }?> />Yes  <input type="radio" name="txtComments" value="0" <? if ($Comments == 0) {echo 'checked'; }?> />No</td>
	   </tr>
   <? } else if ($Template == 'java')  { ?>
    <tr>
    <td rowspan="2" valign="top" class="contentbox"><b>LIGHTBOX POP UP GALLERY</b><br /><div class="spacer"></div>GALLERY COLUMN SETTINGS<br />
<select class='inputstyle' name='txtColumn' checked>
<OPTION VALUE='1' selected>1 - (6) 100 PIxel Thumbs</OPTION>
<OPTION VALUE='2'>2 - (12) 50 PIxel Thumbs</OPTION>
</select><div class="spacer"></div>
# OF ROWS<br />
<select class='inputstyle' name='txtRows' checked>
<OPTION VALUE='2'>2 ROWS</OPTION>
<OPTION VALUE='3' selected>3 ROWS</OPTION>
<OPTION VALUE='4'>4 ROWS</OPTION>
<OPTION VALUE='5'>5 ROWS</OPTION>
<OPTION VALUE='6'>6 ROWS</OPTION>
<OPTION VALUE='7'>7 ROWS</OPTION>
<OPTION VALUE='12'>12 ROWS</OPTION>
</select></td>
	<td rowspan="2" valign="top" class="contentbox">GALLERY TITLE <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/><div class="spacer"></div>GALLERY DESCRIPTION <br />
<textarea class='inputstyle' name="txtDescription" style='width:100%;'><? echo $GalleryDescription;?></textarea><div class="spacer"></div>NAVIGATION SETTINGS:<br />
SHOW TOP NAVIGATION: <input type="radio" name="txtTopControl" value='1' checked />YES  <input type="radio" name="txtTopControl" value='0' />  NO<br />SHOW BOTTOM NAVIGATION: <input type="radio" name="txtBottomControl" value='1' checked />YES  <input type="radio" name="txtBottomControl" value='0' />  NO </td>
	<td rowspan="2" valign="top"  class="contentbox">ALLOW COMMENTS:<br />
<input type="radio" name="txtComments" value="1" <? if (($Comments == 1) || ($Comments == "")) {echo 'checked'; }?> />Yes  <input type="radio" name="txtComments" value="0" <? if ($Comments == 0) {echo 'checked'; }?> />No</td>
	   </tr>
   <? } ?>
</table>
</td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type='hidden' name='txtType' value="<? echo $GalleryType;?>" />
<input type='hidden' name='txtTemplate' value="<? echo $Template;?>" />
</form>