<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">



<head>



<script type="text/javascript" src="scripts/swfobject.js"></script>

<script type="text/javascript" src="js/prototype.js"></script>

<script type="text/javascript" src="js/scriptaculous.js"></script>

<script type="text/javascript" src="js/lightbox.js"></script>
<script language="Javascript">
 <!--

 function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
 }
 //-->
 </script>
<link rel="stylesheet" type="text/css" href="editor/images/style.css" />
<!-- jQuery -->
<script type="text/javascript" src="editor/jquery.pack.js"></script>
<!-- markItUp! -->
<script type="text/javascript" src="editor/markitup/jquery.markitup.pack.js"></script>
<!-- markItUp! toolbar settings -->
<script type="text/javascript" src="editor/markitup/sets/html/set.js"></script>
<!-- markItUp! skin -->
<link rel="stylesheet" type="text/css" href="editor/markitup/skins/markitup/style.css" />
<!--  markItUp! toolbar skin -->
<link rel="stylesheet" type="text/css" href="editor/markitup/sets/html/style.css" />
<meta name="description" content="<?php echo $Description ?>"></meta>

<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>, <?php echo $Creator;?>"></meta>

<LINK href="css/pf_admin.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?> - <?php echo $PageTitle; ?></title>

</head>

<body>

<div class="wrapper" align="center">
<table width='995' cellpadding="0" cellspacing="0" border="0"><tr><td background="images/header.jpg" width='995' height='49' valign="middle" align="right" style="padding-right:10px;"><? if ($Page != 'login') {?>Welcome, <? echo $_SESSION['username'];?> | <a href='/index.php' target="_blank">VIEW SITE</a> | <a href='logout.php'>LOGOUT</a><? } ?></td></tr></table>
