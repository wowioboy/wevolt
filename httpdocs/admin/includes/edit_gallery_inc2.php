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

		if ($_GET['template'] == "") {
			$Template =  $line->Template;
		} else {
			$Template = $_GET['template']
		}
		if ($_GET['type'] == "") {
			$GalleryType = $line->Type;
		} else {
			$GalleryType = $_GET['type'];
		}
		$GalleryDisplay =  $line->GalleryDisplay;
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
    
	<td width="168" height="73" valign="top" bgcolor="#000000" class="contentbox"><div class='spacer'></div>GALLERY TYPE<br />
<select class='inputstyle'  onchange='window.location = this.options[this.selectedIndex].value; '><OPTION VALUE='no'>Select-</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=image' <? if ($GalleryType == 'image') { echo 'selected';}?>>Image Gallery</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=video' <? if ($GalleryType == 'video') { echo 'selected';}?>>Video Gallery</OPTION>
<OPTION VALUE='admin.php?a=gallery&id=<? echo $GalleryID; ?>&task=change&type=music' <? if ($GalleryType == 'music') { echo 'selected';}?>>Music Gallery</OPTION>
</select></td>

<td width="316" valign="top" bgcolor="#000000" class="contentbox"><div class='spacer'></div>
<? 
if (($GalleryType != "") && ($GalleryType != 'no'))  { ?>
SELECT TEMPLATE TYPE<br />
<? if ($GalleryType =='image') { ?>
<select class='inputstyle' onchange='window.location = this.options[this.selectedIndex].value; '>	<OPTION VALUE='0'>Select Type --</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=flash' <? if ($Template == 'flash') { echo 'selected';}?>>Flash Display with sliding Thumbnail scroller</OPTION>
<OPTION VALUE='admin.php?a=gallery&task=new&type=<? echo $GalleryType; ?>&template=java' <? if ($Template == 'java') { echo 'selected';}?>>HTML thumbnail browser / Pop up Lightbox Image</OPTION>
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
<? } ?></td>

	<td width="247" valign="top" bgcolor="#000000" class="contentbox"><div class='spacer'></div>
	<? if ($Template != "") { ?>
	SELECT CATEGORIES (optional)<br /> 
	<? echo $catString; }?>   </td>
	
	<td width="274" valign="top" bgcolor="#a2b7b3" class="contentbox" style="padding-right:5px;"><div class='spacer'></div><div align="center">
	  <input type='submit' name='btnsubmit' value='SAVE GALLERY' class='inputstyle'><div class="medspacer"></div>
	  <input type='submit' name='btnsubmit' value='DELETE GALLERY' class='inputstyle'>
	  </div></td>
   </tr>
   
   <? if (($GalleryType != "") && ($GalleryType != 'no'))  { ?>
    <tr>
	
    <td  valign="top" bgcolor="#000000" class="contentbox">GALLERY WIDTH <br />
(min = 550 / max = 1024)<br />
<input type="text" maxlength="4" name="txtWidth" value="<? echo $Width;?>"/><div class="medspacer"></div>
GALLERY HEIGHT <br />
(min = 300 / max = 1024)<br />
<input type="text" maxlength="4" name="txtHeight" value="<? echo $Height;?>"/></td>

	<td  valign="top" bgcolor="#000000" class="contentbox" style="padding-right:10px;">GALLERY TITLE (max = 1024)<br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/><div class="spacer"></div>GALLERY DISPLAY SETTINGS:<br />
<input type="radio" name="txtGalleryDisplay" value="flash" <? if (($GalleryDisplay == 'flash') || ($GalleryDisplay == "")) {echo 'checked'; }?> />FLASH<br />
[Flash Gallery with Scrolling Thumnail Bar]  <div class="spacer"></div>
<input type="radio" name="txtGalleryDisplay" value="java" <? if ($GalleryDisplay == 'java') {echo 'checked'; }?> />HTML TABLE<br />
HTML Thumbnail Table opens Large image into Lightbox</td>

	<td valign="top" bgcolor="#000000" class="contentbox">ALLOW COMMENTS:<br />
<input type="radio" name="txtComments" value="1" <? if (($Comments == 1) || ($Comments == "")) {echo 'checked'; }?> />Yes  <input type="radio" name="txtComments" value="0" <? if ($Comments == 0) {echo 'checked'; }?> />No</td>

<td width="274" valign="top" bgcolor="#a2b7b3"></td>
   </tr>
   <? } else { ?>
    <tr>
    
	<td valign="top" bgcolor="#000000" class="contentbox"></td>
	
	<td valign="top" bgcolor="#000000" class="contentbox"></td>
	
	<td valign="top" bgcolor="#000000" class="contentbox"></td>
	
	<td width="274" valign="top" bgcolor="#a2b7b3"></td>
   </tr>
   <? } ?>

 <? if ($ItemCount > 0)  { ?>
    <tr>
    <td colspan="3" valign="top" bgcolor="#000000" class="contentbox"><div class='spacer'></div><? echo $itemString; ?></td>
	<td width="274" valign="top" bgcolor="#a2b7b3" class="contentbox" style="padding-right:5px;" align="center"><div class='spacer'></div> <input type='submit' name='btnsubmit' value='EDIT ITEM' class='inputstyle'><div class="smspacer"></div>
	  <input type='submit' name='btnsubmit' value='DELETE ITEM' class='inputstyle'><div class="medspacer"></div><input type='submit' name='btnsubmit' value='UPLOAD CONTENT' class='inputstyle'></td>
   </tr>
   <? } ?>
</table>
<input type='hidden' name='txtType' value="<? echo $GalleryType;?>" />
<input type='hidden' name='txtTemplate' value="<? echo $Template;?>" />
<input type='hidden' name='txtGallery' value="<? echo $GalleryID;?>" />
<input type='hidden' name='txtEdit' value="1" />
</form>
<div class="spacer"></div>