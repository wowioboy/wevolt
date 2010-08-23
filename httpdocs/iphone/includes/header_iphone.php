<?php include 'init.php';?>


<? if (is_authed()) { 
		$loggedin = 1;
		} else {
		$loggedin = 0;
		} ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">  
<link rel="apple-touch-icon" href="images/template/engage.png"/>  
<LINK href="css/pf_css_iphone.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - <? echo $PageTitle;?></title>
<script language="Javascript">
 <!--

 function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
 }
 </script>

	<script type="text/javascript" src="scripts/orientation.js"></script>
	<script type="text/javascript">
		window.addEventListener("load", function() { setTimeout(loaded, 100) }, false);
	
		function loaded() {
			document.getElementById("page_wrapper").style.visibility = "visible";
			window.scrollTo(0, 1); // pan to the bottom, hides the location bar
		}
	</script>
</head>

<body onorientationchange="updateOrientation();">  

