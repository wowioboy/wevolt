<?php 
//ini_set('display_errors',2);
//error_reporting(E_ALL|E_STRICT);
include '../includes/init.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - Store</title>

</head>

<body>
<?php include '../includes/header_content.php';?>

     <div class='contentwrapper'>
<div class="contentdiv" style="height:300px; padding-right:25px;">
<? include "include/zstore.php"; ?> 
</div>
  </div>
  <?php 
    $showSorting = 'false';
	$gridCellSize = 'small';
	$showHowMany = '5';
	//$defaultSort = 'popularity';
	$gridCellSize = 'small';	
	$gridWidth = 500;

  include 'include/footer_v2.php';?>

</html>

