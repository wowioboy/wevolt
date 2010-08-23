<? 
$ItemID = $_GET['id'];
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
	$Thumb100 = $line->Thumb10;
	$Thumb200 = $line->Thumb20;
	$Thumb400 = $line->Thumb40;
	$ThumbCustom = $line->ThumbCustom;
	$Category = $line->Category;
}

$catString = "";
	$db = new DB();
	$query = "select * from pf_gallery_categories order by ID ASC";
	$db->query($query);
	$catString = "<select name='txtCategory' style='inputstyle'>";
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
	$galleryString = "<select name='txtGalleryInsert' class='inputstyle' size='3' miltiple='yes'>";
	while ($line = $db->fetchNextObject()) { 
		if ($GalleryID != $line->ID) {
			$galleryString .= "<OPTION VALUE='".$line->ID."'>".$line->Title."</OPTION>";
		}
	}
	$galleryString .= "</select>";
	
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
      FINISH UPLOAD</div>
<input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left;">
    </td>
    <td class='adminContent' valign="top">
   <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    
	<td width="150" height="100" valign="top"  class="contentbox"><div align="center">IMAGE:<br />
          <img src='<? echo $ThumbLg;?>' border=1 />
    </div></td>

	<td colspan="3" valign="top"  class="contentbox">

	ITEM CATEGORY<br /> 
	<? echo $catString; ?>   <div class="spacer"></div>ADD TO OTHER GALLERIES:<br /> 
	<? echo $galleryString; ?>	 <div align="center">
	  <div class="medspacer"></div>
	    <div class="medspacer"></div>
	    </div></td>	
  </tr>
   

    <tr>
	
    <td  valign="top" class="contentbox"></td>

	<td width="550"  valign="top"class="contentbox"></td>

	<td width="26" valign="top" class="contentbox"></td>

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
<input type='hidden' name='sub' value='item' />
</form>