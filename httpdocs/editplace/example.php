<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Edit-in-Place with Ajax</title>

	<link href="editinplace.css" rel="Stylesheet" type="text/css" />
	<script src="/lib/prototype.js" type="text/javascript"></script>
	<script src="editinplace.js" type="text/javascript"></script>
</head>

<body>
	<h1>Edit-in-Place with Ajax</h1>
	<?php
	
	$codeToBeEdited = file_get_contents('text.txt');	
	$codeToBeEdited2 = file_get_contents('text2.txt');	
	
	$idName1 = 'desc'; 
	$idName2 = 'desc2';


	require_once('AjaxEditInPlace.inc.php');

	$ajaxEditInPlace = new AjaxEditInPlace($codeToBeEdited, 'showText');
	echo $ajaxEditInPlace->getEditInPlaceCode($idName1);

	$ajaxEditInPlace = new AjaxEditInPlace($codeToBeEdited2, 'showText');
	echo $ajaxEditInPlace->getEditInPlaceCode($idName2);

	?>
	
</body>
</html>