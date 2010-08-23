<? 
if ($ItemID == "") {
	$ItemID = $_GET['id'];
}
$db = new DB();
$query = "SELECT * from pf_gallery_content where id='$ItemID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->Title;
	$Description = $line->Description;
	$GalleryID = $line->GalleryID;
	$GalleryType = $line->Type;
	$ThumbSm = $line->ThumbSm;
	$ThumbLg = $line->ThumbLg;
	$Thumb50 = $line->Thumb50;
	$Thumb100 = $line->Thumb100;
	$Thumb200 = $line->Thumb200;
	$Thumb400 = $line->Thumb400;
	$ThumbCustom = $line->ThumbCustom;
	$Category = $line->Category;
	$InModule = $line->InModule;
}
$catString = "";
	$db = new DB();
	$query = "select * from pf_gallery_categories order by ID ASC";
	$db->query($query);
	$catString = "<select name='txtCategory' class='inputstyle'>";
	while ($line = $db->fetchNextObject()) { 
		$catString .= "<OPTION VALUE='".$line->ID."'";
		if ($Category == $line->Category) {
			$catString .= "selected";
		}
		$catString .= ">".$line->Title."</OPTION>";
	}
	$catString .= "</select>";

$galleryString = "";
	$query = "select * from pf_gallery_galleries where type='$GalleryType' order by ID ASC";
	$db->query($query);
	$galleryString = "<select name='txtGalleryInsert' class='inputstyle' size='3' multiple='yes'>";
	while ($line = $db->fetchNextObject()) { 
	if ($GalleryID != $line->ID) {
		$galleryString .= "<OPTION VALUE='".$line->ID."'>".$line->Title."</OPTION>";
	}
	
	}
	$galleryString .= "</select>";
	
	$query = "select GalleryThumb from pf_gallery_galleries where id='$GalleryID'";
	$GalleryThumb = $db->queryUniqueValue($query);
	if ($GalleryThumb == $ItemID) {
		$IsGalleryThumb = 1;
	} else {
		$IsGalleryThumb = 0;
	}
?>
<form method='post' action='admin.php?a=gallery&sub=item'>
<table width='100%' border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contenttopleft"></td>
    <td  id='sidebartop'>&nbsp;</td>
    <td id='contenttop'>&nbsp;</td>
    <td id='contenttopright'>&nbsp;</td>
  </tr>
  <tr>
    <td id="contentleftside"></td>
    <td width="187" class='adminSidebar' valign="top"><div class='adminSidebarHeader'><div style="height:7px;"></div>
      EDIT ITEM</div>
<input type='submit' name='btnsubmit' value='SAVE ITEM' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE ITEM' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='CHANGE IMAGE' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
	<td width="137" height="73" valign="top" class="contentbox"><div class="spacer"></div><br />
          <img src='<? echo $ThumbLg;?>' border=1 /></td>

	<td width="246" valign="top"  class="contentbox"><div class="spacer"></div>ITEM TITLE:<br />
<input type='text' name='txtTitle' value="<? echo $Title; ?>" /><div class="spacer"></div>

	ITEM CATEGORY<br /> 
	<? echo $catString; ?>   </td>	<td width="322" valign="top" class="contentbox"><div class="spacer"></div>
ITEM DESCRIPTION:<br />
<textarea name='txtDescription' class='inputstyle' /><? echo $Description; ?></textarea><div class="spacer"></div>

	ADD TO OTHER GALLERIES:<br /> 
	<? echo $galleryString; ?>   <div class='spacer'></div>
	MAKE THIS ITEM THE GALLERY THUMB:<br />
<input type="radio" name="txtGalleryThumb" value='1' <? if ($IsGalleryThumb == 1) { echo 'checked';} ?>/>YES <input type="radio" name="txtGalleryThumb" value='0' <? if ($IsGalleryThumb == 0) { echo 'checked';} ?>/>NO<div class='spacer'></div>
	SHOW THIS ITEM IN THE GALLERY MODULE:<br />
<input type="radio" name="txtInModule" value='1' <? if ($InModule == 1) { echo 'checked';} ?>/>YES <input type="radio" name="txtInModule" value='0' <? if ($InModule == 0) { echo 'checked';} ?>/>NO
</td>
   </tr>
    <tr>
    <td colspan="3"  valign="top" class="contentbox"><strong>THUMBS </strong><div class="spacer"></div>

<? if (($Thumb50 != "") && ($Thumb50 != "none")) { ?>
50 WIDE: <br /> 
<img src='<? echo $Thumb50; ?>' border='1'/> 
<div class="spacer"></div>
<? } ?>

<? if (($Thumb100 != "") && ($Thumb100 != "none")) { ?> 
100 WIDE: <br />
<img src='<? echo $Thumb100; ?>' border='1'/> 
<div class="spacer"></div>
<? } ?>

<? if (($Thumb200 != "") && ($Thumb200 != "none")) { ?> 
200 WIDE: <br />
<img src='<? echo $Thumb200; ?>' border='1'/> 
<div class="spacer"></div>
<? } ?>

<? if (($Thumb400 != "") && ($Thumb400 != "none")) { ?> 
400 WIDE: <br />
<img src='<? echo $Thumb400; ?>' border='1'/>
<div class="spacer"></div>
<? } ?>

<? if (($Thumb600 != "") && ($Thumb600 != "none")) { ?> 
600 WIDE: <br />
<img src='<? echo $Thumb600; ?>' border='1'/>
<div class="spacer"></div>
<? } ?>

<? if (($ThumbCustom != "") && ($ThumbCustom != "none")) { ?> 
CUSTOM THUMB<br />
<img src='<? echo $ThumbCustom; ?>' border='1'/>
<div class="spacer"></div>
<? } ?></td>

   </tr>
   </table></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
<input type='hidden' name='txtItem' value='<? echo $ItemID; ?>' />
<input type='hidden' name='txtGallery' value='<? echo $GalleryID; ?>' />
<input type='hidden' name='sub' value='item' />
</form>