<? 
if ($GalleryID == "") {
	$GalleryID = $_GET['id'];
}
//GET GALLERY DETAILS
$db = new DB();
	$query = "select * from pf_gallery_galleries where id='$GalleryID'";
	$db->query($query);
	while ($line = $db->fetchNextObject()) { 
		$ThumbSize = $line->ThumbSize;
		$ThumbnailPlacement = $line->ThumbnailPlacement;
		$TopControl =  $line->TopControl;
		$BottomControl = $line->BottomControl;
		$Title =  $line->Title;
		$ThumbBrowserDirection =  $line->ThumbBrowserDirection;
		if ($_GET['template'] == "") {
			$Template =  $line->Template;
		} else {
			$Template = $_GET['template'];
		}
		if ($_GET['type'] == "") {
			$GalleryType = $line->Type;
		} else {
			$GalleryType = $_GET['type'];
		}
		$NumberOfRows =  $line->NumberOfRows;
		$GalleryDescription = $line->Description;
		$Height =  $line->Height;
		$Width =  $line->Width;
		$Comments =  $line->Comments;
		$Categories = explode(",", $line->Categories);
		$CatCount = sizeof($Categories);
	}

///GET GALLERY ITEMS
$itemString = "";
$db = new DB();
$query = "select * from pf_gallery_content where galleryid='$GalleryID'";
$db->query($query);
$itemString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'>ID</td><td class='tableheader' width='65px'>IMAGE</td><td class='tableheader'>ITEM TITLE</td><td class='tableheader'>DESCRIPTION</td><td class='tableheader'>CATEGORY</td></tr><tr><td colspan='5'>&nbsp;</td></tr>";
$ItemCount = $db->numRows();
while ($line = $db->fetchNextObject()) { 
	$Category = $line->Category;
	$db2 = new DB();
	$query = "SELECT title from pf_gallery_categories where id='$Category'";
	$CatTitle = $db2->queryUniqueValue($query);
	$itemString .= "<tr><td width='3%' align='left'><input type='radio' name='txtItem' value='".$line->ID."'></td><td width='65px' align='center'><img src='".$line->ThumbSm."' border='1' style='border-color:#ffffff;'></td><td>".$line->Title."</td><td>".$line->Description."</td><td>".$CatTitle."</td></tr><tr><td colspan='5' class='spacer'></td></tr>";
	}
$GalleryCount = $db->numRows();
$itemString .= "</table>";

//GET CATEGORIES
$catString = "";
	$query = "select * from pf_gallery_categories order by ID ASC";
	$db->query($query);
	$catString = "<select name='txtCategory' class='inputstyle' size='3' miltiple='yes'>";
	while ($line = $db->fetchNextObject()) { 
		$catString .= "<OPTION VALUE='".$line->ID."'";
		$i=0;
		while ($i <= $CatCount) {
			if ($Categories[$i] == $line->ID) {
				$catString .= ' selected';
			}
			$i++;
		}
		
		$catString .= ">".$line->Title."</OPTION>";
	}
	$catString .= "</select>";

?>

<form method='post' action='admin.php?a=gallery'>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr>
	<td valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;">
	GALLERY TYPE<br />
<select class='inputstyle'  onchange='window.location = this.options[this.selectedIndex].value; '><OPTION VALUE='no'>Select-</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=image' <? if ($GalleryType == 'image') { echo 'selected';}?>>Image Gallery</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=video' <? if ($GalleryType == 'video') { echo 'selected';}?>>Video Gallery</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=music' <? if ($GalleryType == 'music') { echo 'selected';}?>>Music Gallery</OPTION>
</select>
	</td>
	<td width="329" valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;">
	<? 
if (($GalleryType != "") && ($GalleryType != 'no'))  { ?>
SELECT TEMPLATE TYPE<br />
<? if ($GalleryType =='image') { ?>
<select class='inputstyle' onchange='window.location = this.options[this.selectedIndex].value; '>	<OPTION VALUE='0'>Select Type --</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=<? echo $GalleryType; ?>&template=flash' <? if ($Template == 'flash') { echo 'selected';}?>>Flash Display with sliding Thumbnail scroller</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=<? echo $GalleryType; ?>&template=java' <? if ($Template == 'java') { echo 'selected';}?>>HTML thumbnail browser / Pop up Lightbox Image</OPTION>
</select>
<? } else if ($GalleryType =='video') { ?>
<select class='inputstyle'  onchange='window.location = this.options[this.selectedIndex].value; '>	<OPTION VALUE='0'>Select -</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=<? echo $GalleryType; ?>&template=hb' <? if ($Template == 'hb') { echo 'selected';}?>>Horizontal Thumbnail Bar - Bottom</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=<? echo $GalleryType; ?>&template=ht' <? if ($Template == 'ht') { echo 'selected';}?>>Horizontal Thumbnail Bar - Top</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=<? echo $GalleryType; ?>&template=vl' <? if ($Template == 'vl') { echo 'selected';}?>>Vertical Thumbnail Bar - Left</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=<? echo $GalleryType; ?>&template=vr' <? if ($Template == 'vr') { echo 'selected';}?>>Vertical Thumbnail Bar - Right</OPTION>
</select>
<? } else if ($GalleryType =='music') { ?>
<select class='inputstyle'  onchange='window.location = this.options[this.selectedIndex].value; '>	<OPTION VALUE='0'>Select -</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=<? echo $GalleryType; ?>&template=hb' <? if ($Template == 'hb') { echo 'selected';}?>>Horizontal Thumbnail Bar - Bottom</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=<? echo $GalleryType; ?>&template=ht' <? if ($Template == 'ht') { echo 'selected';}?>>Horizontal Thumbnail Bar - Top</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=<? echo $GalleryType; ?>&template=vl' <? if ($Template == 'vl') { echo 'selected';}?>>Vertical Thumbnail Bar - Left</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=<? echo $GalleryType; ?>&template=vr' <? if ($Template == 'vr') { echo 'selected';}?>>Vertical Thumbnail Bar - Right</OPTION>
</select>
<? } ?>
<? } ?>
	</td>
	<td  valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;">ALLOW COMMENTS:<br />
<input type="radio" name="txtComments" value="1" <? if (($Comments == 1) || ($Comments == "")) {echo 'checked'; }?> />Yes  <br />
<input type="radio" name="txtComments" value="0" <? if ($Comments == 0) {echo 'checked'; }?> />No

	</td>
	</tr>
	<tr><td colspan="3"></td></tr>
	 <? if ($Template == 'flash')  { ?>
<tr><td valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;">
<b>FLASH GALLERY</b><br />
(min = 550 / max = 1024)<br />
<input type="text" maxlength="4" name="txtWidth" value="<? echo $Width;?>"/><div class="medspacer"></div>
GALLERY HEIGHT <br />
(min = 300 / max = 1024)<br />
<input type="text" maxlength="4" name="txtHeight" value="<? echo $Height;?>"/></td>
	<td valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;">GALLERY TITLE <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/><div class="spacer"></div>GALLERY DESCRIPTION <br />
<textarea class='inputstyle' name="txtDescription" cols="36"><? echo $GalleryDescription;?></textarea><div class='spacer'></div>	<? if ($Template != "") { ?>
	SELECT CATEGORIES (optional)<br /> 
	<? echo $catString; }?>  <div class="spacer"></div><div class="subsection_header">THUMBNAIL BROWSER SETTINGS</div><div class="spacer"></div>THUMBNAIL SIZE:<br /><input type="radio" name="txtThumbSize" value='50' <? if ($ThumbSize == 50) { echo 'selected'; }?> />SMALL (50 PIXELS 2x12) <br />
<input type="radio" name="txtThumbSize" value='100' <? if ($ThumbSize == 100) { echo 'checked'; }?> />LARGE (100 PIXELS 1x6)
<div class="spacer"></div><div class="subsection_header">THUMBNAIL BROWSER SCROLLING DIRECTION:</div>
<input type="radio" name="txtThumbBrowserDirection" value='vertical'  <? if (($ThumbBrowserDirection == 'vertical') || ($ThumbBrowserDirection == '')) { echo 'checked'; }?> />VERTICAL 

<input type="radio" name="txtThumbBrowserDirection" value='horizontal' <? if ($ThumbBrowserDirection == 'horizontal')  { echo 'checked'; }?> />HORIZONTAL <div class="spacer"></div><div class="subsection_header">THUMBNAIL BROWSER PLACEMENT:</div>
<input type="radio" name="txtThumbnailPlacement" value='top'  <? if ($ThumbnailPlacement == 'top') { echo 'checked'; }?>/>TOP 

<input type="radio" name="txtThumbnailPlacement" value='bottom' <? if (($ThumbnailPlacement == 'bottom')|| ($ThumbnailPlacement == '')) { echo 'checked'; }?> />BOTTOM <div class="spacer"></div><div class="subsection_header">CONTROL SETTINGS:</div>
SHOW TOP CONTROLS: <input type="radio" name="txtTopControl" value='1' <? if ($TopControl == 1) { echo 'checked'; }?> />YES  <input type="radio" name="txtTopControl" value='0' <? if ($TopControl == 0) { echo 'checked'; }?> />  NO<br />SHOW BOTTOM CONTROLS: <input type="radio" name="txtBottomControl" value='1' <? if ($BottomControl == 1) { echo 'checked'; }?>/>YES  <input type="radio" name="txtBottomControl" value='0'  <? if ($BottomControl == 0) { echo 'checked'; }?>/>  NO
 </td>
	<td  valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;"></td>
   </tr>
   <? } else if ($Template == 'java')  { ?>
    <tr>
    <td  valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;"><b>LIGHTBOX POP UP GALLERY</b><br /><div class="spacer"></div>GALLERY COLUMN SETTINGS<br />
<select class='inputstyle' name='txtColumn' checked>
<OPTION VALUE='1' <? if ($ThumbSize == 100) { echo 'selected'; }?>>1 - (6) 100 PIxel Thumbs</OPTION>
<OPTION VALUE='2' <? if ($ThumbSize == 50) { echo 'selected'; }?>>2 - (12) 50 PIxel Thumbs</OPTION>
</select><div class="spacer"></div>
# OF ROWS<br />
<select class='inputstyle' name='txtRows' checked>
<OPTION VALUE='2' <? if ($NumberOfRows == 2) { echo 'selected'; }?>>2 ROWS</OPTION>
<OPTION VALUE='3' <? if ($NumberOfRows == 3) { echo 'selected'; }?>>3 ROWS</OPTION>
<OPTION VALUE='4' <? if ($NumberOfRows == 4) { echo 'selected'; }?>>4 ROWS</OPTION>
<OPTION VALUE='5' <? if ($NumberOfRows == 5) { echo 'selected'; }?>>5 ROWS</OPTION>
<OPTION VALUE='6' <? if ($NumberOfRows == 6) { echo 'selected'; }?>>6 ROWS</OPTION>
<OPTION VALUE='7' <? if ($NumberOfRows == 7) { echo 'selected'; }?>>7 ROWS</OPTION>
<OPTION VALUE='12' <? if ($NumberOfRows == 8) { echo 'selected'; }?>>12 ROWS</OPTION>
</select>
</td>
	<td valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;">GALLERY TITLE <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/><div class="spacer"></div>GALLERY DESCRIPTION <br />
<textarea class='inputstyle' name="txtDescription" cols="36"><? echo $GalleryDescription;?></textarea><div class="spacer"></div><div class="subsection_header">NAVIGATION SETTINGS:</div><br />
SHOW TOP NAVIGATION: <input type="radio" name="txtTopControl" value='1' <? if ($TopControl == 1) { echo 'checked'; }?> />YES  <input type="radio" name="txtTopControl" value='0' <? if ($TopControl == 0) { echo 'checked'; }?> />  NO<br />SHOW BOTTOM NAVIGATION: <input type="radio" name="txtBottomControl" value='1' <? if ($BottomControl == 1) { echo 'checked'; }?>/>YES  <input type="radio" name="txtBottomControl" value='0'  <? if ($BottomControl == 0) { echo 'checked'; }?>/>  NO
 </td>
	<td valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;"></td>
   </tr>
   <? } ?>
   
   <? if ($ItemCount > 0)  { ?>
    <tr>
    <td colspan="3"  valign="top" bgcolor="#000000" class="contentbox" style="padding:5px;"><div class='spacer'></div><? echo $itemString; ?></td>
	 </tr>
   <? } ?>
   
	</table>
</td>

<td width="274" valign="top" bgcolor="#a2b7b3" class="contentbox" style="padding:5px;"><div class='spacer'></div><div align="center">
	  <input type='submit' name='btnsubmit' value='SAVE GALLERY' class='inputstyle'><div class="medspacer"></div>
	  <input type='submit' name='btnsubmit' value='DELETE GALLERY' class='inputstyle'>
	  </div><div class='spacer'></div> <input type='submit' name='btnsubmit' value='EDIT ITEM' class='inputstyle'><div class="smspacer"></div>
	  <input type='submit' name='btnsubmit' value='DELETE ITEM' class='inputstyle'><div class="medspacer"></div><input type='submit' name='btnsubmit' value='UPLOAD CONTENT' class='inputstyle'></td>

</tr></table>	

<input type='hidden' name='txtType' value="<? echo $GalleryType;?>" />
<input type='hidden' name='txtTemplate' value="<? echo $Template;?>" />
<input type='hidden' name='txtGallery' value="<? echo $GalleryID;?>" />
<input type='hidden' name='txtEdit' value="1" />
</form>
<div class="spacer"></div>