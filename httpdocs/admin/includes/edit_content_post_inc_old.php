<?php
include_once("init.php"); 
include("editor/fckeditor.php") ;
$SectionID = $_GET['section'];
$PostID = $_POST['txtPost'];
if ($PostID == "") {
$PostID = $_GET['id'];
}
$db = new DB();
$query = "select * from content where id='$PostID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Filename = $line->Filename;
	$Title = $line->Title;
	$ShowTitle = $line->ShowTitle;
	$Published = $line->Published;
	$CatID = $line->Category;
	if ($_GET['section'] == "") {
		$SectionID = $line->Section;
	}
}
$HtmlContent = file_get_contents('content/posts/'.$Filename);

if ($SectionID != "") {
	$catString = "";
	$db = new DB();
	$query = "select * from categories where section='$SectionID' order by ID ASC";
	$db->query($query);
	$catString = "<select name='txtCategory' style='background-color:#FFFFFF; border:solid; 			border-width:1px; border-color:#FF6600; width:222px;'>";
	while ($line = $db->fetchNextObject()) { 
		$catString .= "<OPTION VALUE='".$line->ID."'";
		if ($line->IsDefault == 1) {
			$catString .= "selected";
		}
		$catString .= ">".$line->Title."</OPTION>";
	}
	$catString .= "</select>";
} else {
$catString = "<select name='txtCategory' style='background-color:#FFFFFF; border:solid; 			border-width:1px; border-color:#FF6600; width:222px;'><option value='0'>SELECT SECTION FIRST</option>";
}
$secString = "";
$db = new DB();
$query = "select * from sections order by ID ASC";
$db->query($query);
$secString = "<select style='width:175px;' onchange='window.location = this.options[this.selectedIndex].value; '>";
while ($line = $db->fetchNextObject()) { 

$secString .= "<OPTION VALUE='admin.php?a=content&task=change&id=".$PostID."&section=".$line->ID."'";
if ($line->ID == $SectionID) {
$secString .= "selected";
}
$secString .= ">".$line->Title."</OPTION>";
	}
$secString .= "</select>";
?>

<form action="write_content_post.php" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="621" valign="top"><div class="smspacer"></div>
POST TITLE:
<input type="text" name="txtTitle" style="width:300px;" value="<? echo $Title; ?>">

<div class="spacer"></div>
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.

$oFCKeditor = new FCKeditor('pf_post') ;
$oFCKeditor->BasePath	= '/editor/';
$oFCKeditor->Height = '400';
$oFCKeditor->Width = '550';
$oFCKeditor->Value		= $HtmlContent;
$oFCKeditor->Create() ;
?>

<div class="spacer"></div>
<input type="submit" value="SAVE PAGE" style="background-color:#FFFFFF; border:solid; border-width:1px; border-color:#FF6600;"> </td>
    <td width="384" valign="top" bgcolor="#a2b7b3" style="padding-left:5px;padding-top:5px; color:#000000;"><b>POST SETTINGS:</b>
      <div class="spacer"></div>
	   SECTION (this will reload page, make sure you save your changes before changing section):<br />
       <? echo $secString; ?><br />
CATEGORY:<br />
<? echo $catString; ?><br />
<br />
	   SHOW TITLE:<br />
          <input type="radio" name="txtShowtitle" value="1" <? if ($ShowTitle == 1) { echo 'checked';} ?>>
          Yes&nbsp;&nbsp;
          <input type="radio" name="txtShowtitle" value="0" <? if ($ShowTitle == 0) { echo 'checked';} ?> >
          No<br />
          <br />
      PUBLISH:<br />
      <input type="radio" name="txtPublished" value="1"  <? if ($Published == 1) { echo 'checked';} ?>>
      Yes&nbsp;&nbsp;
      <input type="radio" name="txtPublished" value="0"  <? if ($Published == 0) { echo 'checked';} ?>>
      No<br />
      <br />
      </td>
  </tr>
</table>
<div class="spacer"></div>
<input type="hidden" name="txtPost" value="<? echo $PostID; ?>">
<input type="hidden" name="txtFilename" value="<? echo $Filename; ?>">
<input type="hidden" name="txtSection" value="<? echo $SectionID; ?>">
<input type="hidden" name="txtEdit" value="1">
</form>