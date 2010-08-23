<?php
include_once("init.php"); 
include("editor/fckeditor.php");
$PageID = $_POST['txtPage'];
$db = new DB();
$query = "select * from pages where id='$PageID' limit 1";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$Title = $line->Title;
	$Filename = $line->Filename;
	$Published= $line->Published;
}
$HtmlContent = file_get_contents('content/'.$Filename);

?>
<form action="write_page.php" method="post">

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
    EDIT STATIC PAGE</div>
      <div class='spacer'></div>PAGE SETTINGS<br />
PUBLISHED<input type="radio" name="txtPublished" value="1" <? if ($Published == 1) {echo 'checked';} ?>>Yes<input type="radio" name="txtPublished" value="0" <? if ($Published == 0) {echo 'checked';} ?>>No
     </div><div class='spacer'></div>
      <input type="submit" value="SAVE PAGE" id='submitstyle'> 
    </td>
    <td class='adminContent' valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
PAGE TITLE<br />

  <input type="text" name="txtTitle" class='inputstyle' value="<? echo $Title; ?>">

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
    </td>
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
<input type="hidden" name="txtPage" value="<? echo $PageID; ?>">
<input type="hidden" name="txtFilename" value="<? echo $Filename; ?>">
<input type="hidden" name="txtEdit" value="1">
</form>