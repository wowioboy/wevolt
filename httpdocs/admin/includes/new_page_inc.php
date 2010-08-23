<?php
include_once("init.php"); 
include("editor/fckeditor.php") ;
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
    <td width="187" class='adminSidebar' valign="top"><div class='adminSidebarHeader'><div style="height:7px;"></div> NEW STATIC PAGE</div><div class='spacer'></div>PAGE SETTINGS<br />
PUBLISH?
<input type="radio" name="txtPublished" value="1" checked>Yes&nbsp;&nbsp;<input type="radio" name="txtPublished" value="0" >No
     </div><div class='spacer'></div>
      <input type="submit" value="SAVE PAGE" id='submitstyle'>
    </td>
    <td class='adminContent' valign="top">
    
    
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top">
PAGE TITLE<br />

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
</form>