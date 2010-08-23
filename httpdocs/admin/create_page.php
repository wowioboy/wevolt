<?php
include("editor/fckeditor.php") ;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
	<head>
		<title>CREATE PAGE</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<meta name="robots" content="noindex, nofollow">
		<link href="css/pf_edit.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
<form action="write_page.php" method="post" target="_blank">
<?php
// Automatically calculates the editor base path based on the _samples directory.
// This is usefull only for these samples. A real application should use something like this:
// $oFCKeditor->BasePath = '/fckeditor/' ;	// '/fckeditor/' is the default value.

$oFCKeditor = new FCKeditor('pf_post') ;
$oFCKeditor->BasePath	= '/editor/';
$oFCKeditor->Height = '400';
$oFCKeditor->Width = '550';
$oFCKeditor->Value		= '' ;
$oFCKeditor->Create() ;
?>
		<br>
<input type="submit" value="SAVE PAGE" style="background-color:#FFFFFF; border:solid; border-width:1px; border-color:#FF6600;">
		</form>
	</body>
</html>
