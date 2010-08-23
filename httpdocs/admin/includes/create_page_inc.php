<?php
include_once("init.php"); 
include("editor/fckeditor.php") ;
?>
<form action="write_page.php" method="post"><div class="spacer"></div>
PAGE TITLE:
<input type="text" name="txtTitle" style="width:400px;">&nbsp;&nbsp;&nbsp;
PUBLISH?&nbsp;
<input type="radio" name="txtPublished" value="1" checked>Yes&nbsp;&nbsp;<input type="radio" name="txtPublished" value="0" >No
<div class="spacer"></div>
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.

$oFCKeditor = new FCKeditor('pf_post') ;
$oFCKeditor->BasePath	= '/editor/';
$oFCKeditor->Height = '400';
$oFCKeditor->Width = '787';
$oFCKeditor->Value		= '' ;
$oFCKeditor->Create() ;
?>
</div>
		<div class="spacer"></div>
<input type="submit" value="SAVE PAGE" style="background-color:#FFFFFF; border:solid; border-width:1px; border-color:#FF6600;">
<div class="spacer"></div>
</form>