<?php
include 'includes/init.php';
if (is_authed()) { 
		$loggedin = 1;
		} else {
		$loggedin = 0;
		} 
		if ($loggedin == 0) {
		header("location:index.php");
		}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php if($styles) echo $styles; ?>
<script type="text/javascript" src="scripts/swfobject.js"></script>
<?php if($scripts) echo $scripts; ?>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PANEL FLOW - AVATAR CREATOR</title>
</head>

<body>
<div class="wrapper" align="center">
<table width="778" cellpadding="0" cellspacing="0" border="0"><tr>
<td background="images/content_header.jpg" height="50" style="background-repeat:no-repeat;"></td>
</tr>
  <tr>
    <td background="images/content_background.jpg" id="contentcell" valign="top" style="background-repeat:repeat-y">
 <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>

<td valign="top">
<div id="login" align="center">
		<strong>You need to upgrade your Flash Player <br /><a href="login.php"> CLICK HERE TO LOGIN </a></strong></div>
<script type="text/javascript">


		var so = new SWFObject("/logo_v42.swf", "images", "223", "180", "8.0.23", true);
	     so.addVariable('loggedin','<?php echo $loggedin;?>');
		so.addVariable('username','<?php echo trim($_SESSION['username'])?>');
		so.addParam("wmode", "transparent");
		so.write("login");


	</script></td><td>&nbsp;</td>
</tr>
</table>



 <img src="images/logged_menu.jpg" border="0" usemap="#loggedMap" />

<div class='spacer'></div>
</td>
  </tr>
  <tr>
    <td background="images/content_footer.jpg" height="50" style="background-repeat:no-repeat"></td>
  </tr>
</table>
		
<div class="spacer"></div>		
</div>		

<map name="loggedMap">
  <area shape="rect" coords="134,6,199,21" href="/profile/<? echo trim($_SESSION['username']);?>/" /><area shape="rect" coords="221,7,276,21" href="/contact.php" /><area shape="rect" coords="297,8,348,21" href="/comics.php" /><area shape="rect" coords="366,6,402,20" href="/faq.php" /><area shape="rect" coords="424,8,485,21" href="/creators.php" /><area shape="rect" coords="508,8,576,21" href="/download.php" /><area shape="rect" coords="595,6,636,21" href="/blog.php" />
</map>