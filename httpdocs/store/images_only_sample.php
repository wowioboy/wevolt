<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <title>Zazzle Store Builder: Sample page with images only</title>
  	<link id="ext_css" rel="stylesheet" type="text/css" href="css/zstore.css"/>
  </head>
<body>
<h1 class="sampleTitle">Sample page with images only</h1>

<?php

// configure Zazzle Store Builder display
$_GET['showPagination'] = 'false';
$_GET['showSorting'] = 'false';
$_GET['showProductDescription'] = 'false';
$_GET['showByLine'] = 'false';
$_GET['showProductTitle'] = 'false';
$_GET['showProductPrice'] = 'false';
$_GET['gridCellSize'] = 'small';
$_GET['showHowMany'] = '100';

include "include/zstore.php";

?>
</body>
</html>