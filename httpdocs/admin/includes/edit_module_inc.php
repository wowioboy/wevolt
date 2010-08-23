<? 
$moduleDB = new DB();
$query = "select * from modules where id='$ModuleID'";
$moduleDB->query($query);
while ($line = $moduleDB->fetchNextObject()) { 
	$Title = $line->Title;
	$Application = $line->Application;
	$Sidebar = $line->Sidebar;
	$FrontPage = $line->FrontPage;
	$Published = $line->Published;
	$AppModuleID = $line->ModuleID;
	$ShowTitle = $line->ShowTitle;
}
if ($Application == 'gallery') {
	$query = "select * from pf_gallery_modules where id='$AppModuleID'";
	$ModuleSettings = $moduleDB->queryUniqueObject($query);
	$NumberOfRows = $ModuleSettings->NumberOfRows;
	$NumberOfCols = $ModuleSettings->NumberOfCols;
	$Galleries = $ModuleSettings->Galleries;
	$Categories = $ModuleSettings->Categories;
	$Random = $ModuleSettings->Random;
	
	// BUILD GALLERY CATEGORY LIST
	$catString = "";
	$query = "select * from pf_gallery_categories order by ID ASC";
	$moduleDB->query($query);
	$catString = "<select name='txtCategory[]' class='inputstyle' size='3' multiple='yes'>";
	while ($line = $moduleDB->fetchNextObject()) { 
		$catString .= "<OPTION VALUE='".$line->ID."'";
		if ($Category == $line->Category) {
			$catString .= "selected";
		}
		$catString .= ">".$line->Title."</OPTION>";
	}
	$catString .= "</select>";
//BUILD GALLERY LIST
$galleryString = "";
	$query = "select * from pf_gallery_galleries where type='image' order by ID ASC";
	$moduleDB->query($query);
	$galleryString = "<select name='txtGalleries[]' class='inputstyle' size='3' multiple='yes'>";
	while ($line = $moduleDB->fetchNextObject()) { 
	if ($GalleryID != $line->ID) {
		$galleryString .= "<OPTION VALUE='".$line->ID."'>".$line->Title."</OPTION>";
	}
	
	}
	$galleryString .= "</select>";
	
	// BUILD CURRENT AVAILABLE IMAGES
	
$query = "SELECT * from pf_gallery_content where InModule=1 order by ModuleAddedDate";
$moduleDB->query($query);
$TotalItems = $moduleDB->numRows();
$Count = 1;
$imageString = "";	
$Cols = 0;
$imageString = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr>";
while ($line = $moduleDB->fetchNextObject()) { 
	if ($Cols == 10) {
			$imageString .= "</tr><tr>";
			$Cols=0;
		}
		$imageString .= "<td class='listcell'><a href='".$line->GalleryImage."' rel='lightbox' border='1' ><img src='".$line->ThumbSm."' border='0'></td>";
		$Cols++;
}

$imageString .=  "</tr></table>";

	
}

if ($Application == 'store') {
	$query = "select * from pf_store_modules where id='$AppModuleID'";
	$ModuleSettings = $moduleDB->queryUniqueObject($query);
	$NumberOfRows = $ModuleSettings->NumberOfRows;
	$NumberOfCols = $ModuleSettings->NumberOfCols;
	$Categories = $ModuleSettings->Categories;
	$Random = $ModuleSettings->Random;
	
	
	// BUILD STORE CATEGORY LIST
	$catString = "";
	$query = "select * from pf_store_categories order by ID ASC";
	$moduleDB->query($query);
	$catString = "<select name='txtCategory[]' class='inputstyle' size='3' multiple='yes'>";
	while ($line = $moduleDB->fetchNextObject()) { 
		$catString .= "<OPTION VALUE='".$line->ID."'";
		if ($Category == $line->Category) {
			$catString .= "selected";
		}
		$catString .= ">".$line->Title."</OPTION>";
	}
	$catString .= "</select>";
	
}

?>

<form method='post' action='admin.php?a=modules'>
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
      EDIT MODULE</div>
<input type='submit' name='btnsubmit' value='SAVE MODULE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

    </td>
    <td class='adminContent' valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
 	
  <tr>
    <td  height="73" valign="top" class="contentbox">
<? if ($Application == 'gallery') { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="289" valign="top" style="padding:5px;">	MODULE TITLE: <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/>

<div class="spacer"></div>
<? if ($AppModuleID == 1) { ?>
THUMB COLUMNS<br />
<select name="txtCols">
<option value='2' <? if ($NumberOfCols == 2) { echo 'selected';}?>>2</option>
<option value='3' <? if ($NumberOfCols == 3) { echo 'selected';}?>>3</option>
<option value='4' <? if ($NumberOfCols == 4) { echo 'selected';}?>>4</option>
<option value='5' <? if ($NumberOfCols == 5) { echo 'selected';}?>>5</option>
<option value='6' <? if ($NumberOfCols == 6) { echo 'selected';}?>>6</option>
</select>
<div class="spacer"></div>
THUMB ROWS<br />
<select name="txtRows">
<option value='1' <? if ($NumberOfRows == 1) { echo 'selected';}?>>1</option>
<option value='2' <? if ($NumberOfRows == 2) { echo 'selected';}?>>2</option>
<option value='3' <? if ($NumberOfRows == 3) { echo 'selected';}?>>3</option>
<option value='4' <? if ($NumberOfRows == 4) { echo 'selected';}?>>4</option>
<option value='5' <? if ($NumberOfRows == 5) { echo 'selected';}?>>5</option>
<option value='6' <? if ($NumberOfRows == 6) { echo 'selected';}?>>6</option>
</select>
 
<? } ?>
</td>
    <td width="390" valign="top" style="padding:5px;">RANDOM SELECT AVAILABLE THUMBS?<br />
[this setting will override images you've selected]<br />
<input type="radio" name="txtRandom" value="1"  <? if ($Random == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtRandom" value="0" <? if ($Random == 0) { echo 'checked';}?> />NO
<div class='spacer'></div>CHOOSE GALLERIES FOR RANDOM CONTENT<br />
<? echo $galleryString;?><div class="spacer"></div>CHOOSE CATEGORIES TO PULL CONTENT<br />
<? echo $catString;?></td>
    <td width="158" valign="top" class="contentbox" style="padding:5px;">SHOW TITLE:<br />
<input type="radio" name="txtShowTitle" value="1"  <? if ($ShowTitle == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtShowTitle" value="0" <? if ($ShowTitle == 0) { echo 'checked';}?> />NO<div class="spacer"></div>SHOW IN SIDEBAR:<br />
<input type="radio" name="txtSidebar" value="1"  <? if ($Sidebar == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtSidebar" value="0" <? if ($Sidebar == 0) { echo 'checked';}?> />NO<div class="spacer"></div>SHOW IN FRONTPAGE:<br />
<input type="radio" name="txtFrontpage" value="1"  <? if ($FrontPage == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtFrontpage" value="0" <? if ($FrontPage == 0) { echo 'checked';}?> />NO<div class="spacer"></div>MODULE PUBLISHED:<br />
<input type="radio" name="txtPublish" value="1"  <? if ($Published == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtPublish" value="0" <? if ($Published == 0) { echo 'checked';}?> />NO</td></tr><tr><td colspan='3'>CURRENT IMAGES ASSIGNED TO MODULE<br />
<? echo $imageString;?></td></tr></table>
<? } ?>	


<? if ($Application == 'content') { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="289" valign="top" style="padding:5px;">	MODULE TITLE: <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/>
</td>
    <td width="158" valign="top"  class="contentbox" style="padding:5px;">SHOW TITLE:<br />
<input type="radio" name="txtShowTitle" value="1"  <? if ($ShowTitle == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtShowTitle" value="0" <? if ($ShowTitle == 0) { echo 'checked';}?> />NO<div class="spacer"></div>SHOW IN SIDEBAR:<br />
<input type="radio" name="txtSidebar" value="1"  <? if ($Sidebar == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtSidebar" value="0" <? if ($Sidebar == 0) { echo 'checked';}?> />NO<div class="spacer"></div>SHOW IN FRONTPAGE:<br />
<input type="radio" name="txtFrontpage" value="1"  <? if ($FrontPage == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtFrontpage" value="0" <? if ($FrontPage == 0) { echo 'checked';}?> />NO<div class="spacer"></div>MODULE PUBLISHED:<br />
<input type="radio" name="txtPublish" value="1"  <? if ($Published == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtPublish" value="0" <? if ($Published == 0) { echo 'checked';}?> />NO</td></tr></table>
<? } ?>	

<? if ($Application == 'blog') { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="509" valign="top" style="padding:5px;">	MODULE TITLE: <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/>
</td>
    <td width="275"  valign="top" class="contentbox" style="padding:5px;">SHOW TITLE:<br />
<input type="radio" name="txtShowTitle" value="1"  <? if ($ShowTitle == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtShowTitle" value="0" <? if ($ShowTitle == 0) { echo 'checked';}?> />NO<div class="spacer"></div>SHOW IN SIDEBAR:<br />
<input type="radio" name="txtSidebar" value="1"  <? if ($Sidebar == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtSidebar" value="0" <? if ($Sidebar == 0) { echo 'checked';}?> />NO

<div class="spacer"></div>SHOW IN FRONTPAGE:<br />
<input type="radio" name="txtFrontpage" value="1"  <? if ($FrontPage == 1) { echo 'checked ';}?>/>YES 
<input type="radio" name="txtFrontpage" value="0" <? if ($FrontPage == 0) { echo 'checked ';}?> />NO

<div class="spacer"></div>MODULE PUBLISHED:<br />
<input type="radio" name="txtPublish" value="1"  <? if ($Published == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtPublish" value="0" <? if ($Published == 0) { echo 'checked';}?> />NO</td></tr></table>
<? } ?>	

<? if ($Application == 'store') { ?>
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="289" valign="top" style="padding:5px;">	MODULE TITLE: <br />
<input type="text" class='inputstyle' name="txtTitle" value="<? echo $Title;?>"/>

<div class="spacer"></div>
<? if ($AppModuleID == 1) { ?>
THUMB COLUMNS<br />
<select name="txtCols">
<option value='2' <? if ($NumberOfCols == 2) { echo 'selected';}?>>2</option>
<option value='3' <? if ($NumberOfCols == 3) { echo 'selected';}?>>3</option>
<option value='4' <? if ($NumberOfCols == 4) { echo 'selected';}?>>4</option>
<option value='5' <? if ($NumberOfCols == 5) { echo 'selected';}?>>5</option>
<option value='6' <? if ($NumberOfCols == 6) { echo 'selected';}?>>6</option>
</select>
<div class="spacer"></div>
THUMB ROWS<br />
<select name="txtRows">
<option value='1' <? if ($NumberOfRows == 1) { echo 'selected';}?>>1</option>
<option value='2' <? if ($NumberOfRows == 2) { echo 'selected';}?>>2</option>
<option value='3' <? if ($NumberOfRows == 3) { echo 'selected';}?>>3</option>
<option value='4' <? if ($NumberOfRows == 4) { echo 'selected';}?>>4</option>
<option value='5' <? if ($NumberOfRows == 5) { echo 'selected';}?>>5</option>
<option value='6' <? if ($NumberOfRows == 6) { echo 'selected';}?>>6</option>
</select>
 
<? } ?>
</td>
    <td width="390" valign="top" style="padding:5px;">RANDOM SELECT FEATURED ITEMS?<br />
[this setting will override images you've selected]<br />
<input type="radio" name="txtRandom" value="1"  <? if ($Random == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtRandom" value="0" <? if ($Random == 0) { echo 'checked';}?> />NO
<div class="spacer"></div>CHOOSE CATEGORIES TO PULL ITEMS<br />
<? echo $catString;?></td>
    <td width="158" valign="top" class="contentbox" style="padding:5px;">SHOW TITLE:<br />
<input type="radio" name="txtShowTitle" value="1"  <? if ($ShowTitle == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtShowTitle" value="0" <? if ($ShowTitle == 0) { echo 'checked';}?> />NO<div class="spacer"></div>SHOW IN SIDEBAR:<br />
<input type="radio" name="txtSidebar" value="1"  <? if ($Sidebar == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtSidebar" value="0" <? if ($Sidebar == 0) { echo 'checked';}?> />NO<div class="spacer"></div>SHOW IN FRONTPAGE:<br />
<input type="radio" name="txtFrontpage" value="1"  <? if ($FrontPage == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtFrontpage" value="0" <? if ($FrontPage == 0) { echo 'checked';}?> />NO<div class="spacer"></div>MODULE PUBLISHED:<br />
<input type="radio" name="txtPublish" value="1"  <? if ($Published == 1) { echo 'checked';}?>/>YES <input type="radio" name="txtPublish" value="0" <? if ($Published == 0) { echo 'checked';}?> />NO</td></tr></table>
<? } ?>	

</td>
	
	
  </tr>
    <tr>
    <td valign="top" class="contentbox"></td>
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
<input type="hidden" name="txtModule" value="<? echo $ModuleID; ?>" />
<input type="hidden" name="txtApp" value="<? echo $Application; ?>" />
<input type="hidden" name="txtAppModule" value="<? echo $AppModuleID; ?>" />
</form>