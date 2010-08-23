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
	$catContentString = "<select name='txtCategory' style='width:100%;' class='inputstyle'>";
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
$secString = "<select class='inputstyle' style='width:100%;' name='Sectionselect' onchange='window.location = this.options[this.selectedIndex].value; '><OPTION VALUE='admin.php?a=content&task=new&section='>Select Section</option>";
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
      NEW POST</div>
<b>POST SETTINGS:</b>
      <div class="spacer"></div>
	   SECTION<br />
	   (save your changes before changing section):<br />
       <? echo $secString; ?><br /><div class='spacer'></div>
CATEGORY<br />
<? echo $catContentString; ?><br />
<br />
     SHOW TITLE<br />
          <input type="radio" name="txtShowtitle" value="1" <? if ($ShowTitle == 1) { echo 'checked';} ?>>
          Yes&nbsp;&nbsp;
          <input type="radio" name="txtShowtitle" value="0" <? if ($ShowTitle == 0) { echo 'checked';} ?> >
          No<br />
          <br />
      PUBLISH<br />
      <input type="radio" name="txtPublished" value="1"  <? if ($Published == 1) { echo 'checked';} ?>>
      Yes&nbsp;&nbsp;
      <input type="radio" name="txtPublished" value="0"  <? if ($Published == 0) { echo 'checked';} ?>>
      No<br /><div class='spacer'></div>
      <input type="submit" value="SAVE PAGE" id='submitstyle'> 
    </td>
    <td class='adminContent' valign="top">
    
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top"><? if ($SectionID != "") { ?>
PAGE TITLE:
<input type="text" name="txtTitle" class='inputstyle'>

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
<? }  else { echo "<div class='spacer'></div><div class='warning'>You need to select a section before you start creating your post</div>";}?>
<br />
      <br />      </td>
    </tr>
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
<input type="hidden" name="txtPost" value="<? echo $PostID; ?>">
<input type="hidden" name="txtFilename" value="<? echo $Filename; ?>">
<input type="hidden" name="txtSection" value="<? echo $SectionID; ?>">
</form>