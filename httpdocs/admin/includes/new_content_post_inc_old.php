<?php
include_once("init.php"); 
include("editor/fckeditor.php") ;
$CurrentDay = date('d');
$CurrentMonth = date('m');
$CurrentYear = date('Y');
$SectionID = $_GET['section'];
if ($SectionID != "") {
	$catContentString = "";
	$db = new DB();
	$query = "select * from categories where section='$SectionID' order by ID ASC";
	$db->query($query);
	$catContentString = "<select name='txtCategory' style='background-color:#FFFFFF; border:solid; 			border-width:1px; border-color:#FF6600; width:222px;'>";
	while ($line = $db->fetchNextObject()) { 
		$catContentString .= "<OPTION VALUE='".$line->ID."'";
		if ($line->IsDefault == 1) {
			$catContentString .= "selected";
		}
		$catContentString .= ">".$line->Title."</OPTION>";
	}
	$catContentString .= "</select>";
} else {
$catContentString = "Select Section First";
}
$secString = "";
$db = new DB();
$query = "select * from sections order by ID ASC";
$db->query($query);
$secString = "<select style='width:175px;' name='Sectionselect' onchange='window.location = this.options[this.selectedIndex].value; '><OPTION VALUE='admin.php?a=content&task=new&section='>Select Section</option>";
while ($line = $db->fetchNextObject()) { 

$secString .= "<OPTION VALUE='admin.php?a=content&task=new&section=".$line->ID."'";
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
    <td width="621" valign="top"><div class="smspacer"></div><? if ($SectionID != "") { ?>
PAGE TITLE:
<input type="text" name="txtTitle" style="width:300px;">

<div class="spacer"></div>
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.

$oFCKeditor = new FCKeditor('pf_post') ;
$oFCKeditor->BasePath	= '/editor/';
$oFCKeditor->Height = '650';
$oFCKeditor->Width = '765';
$oFCKeditor->Value		= $HtmlContent;
$oFCKeditor->Create() ;
?>

<div class="spacer"></div>
<input type="submit" value="SAVE PAGE" style="background-color:#FFFFFF; border:solid; border-width:1px; border-color:#FF6600;"><? }  else { echo "You need to select a section before you start creating your post";}?></td>
    <td width="384" valign="top" bgcolor="#a2b7b3" style="padding-left:5px;padding-top:5px; color:#000000;"><b>POST SETTINGS:</b>
      <div class="spacer"></div>
	   SECTION:<br />
       <? echo $secString; ?><div class="spacer"></div>
CATEGORY:<br />
<? echo $catContentString; ?><br />
<div class="spacer"></div>
	   SHOW TITLE:<br />
          <input type="radio" name="txtShowtitle" value="1" checked>
          Yes&nbsp;&nbsp;
          <input type="radio" name="txtShowtitle" value="0" >
          No<br />
          <br />
      PUBLISH:<br />
      <input type="radio" name="txtPublished" value="1" checked>
      Yes&nbsp;&nbsp;
      <input type="radio" name="txtPublished" value="0" >
      No<br />
      <br />
      </td>
  </tr>
</table>
<div class="spacer"></div>
<input type='hidden' name='txtSection' value='<? echo $SectionID; ?>'  />
</form>