<?php
 if(!isset($_SESSION)) {
    session_start();
  }

?>
<?php include '../includes/functions.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php if($styles) echo $styles; ?>
<script type="text/javascript" src="../scripts/swfobject.js"></script>
<?php if($scripts) echo $scripts; ?>
<LINK href="../css/pf_css.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PANEL FLOW - AVATAR CREATOR</title>
</head>

<body>
<div class="wrapper" align="center">

<table width="534" cellpadding="0" cellspacing="0" border="0"><tr>
<td background="../images/content_bg.gif" id="contentcell" style="background-repeat:repeat-y;"><div class="spacer"></div><div class="spacer"></div><div class="logo"><a href="../index.php"><img src="../images/logo.jpg"  border="0"/></a></div><div class="slug" align="right">THE FLASH <font color="#ffa66d">WEBCOMIC</font><br />CONTENT MANAGEMENT SYSTEM</div>
<div class="logindiv">
<div id="login">
		<strong>You need to upgrade your Flash Player <br /><a href="login.php"> CLICK HERE TO LOGIN </a></strong></div>
<script type="text/javascript">
		// <![CDATA[

		var so = new SWFObject("../login.swf", "images", "171", "66", "8.0.23", "#FFFFFF", true);
		<?php 
		if (is_authed()) { 
		$loggedin = 1;
		} else {
		$loggedin = 0;
		} ?>
	    so.addVariable('loggedin','<?php echo $loggedin;?>');
		so.write("login");

		// ]]>
	</script></div></td>
</tr>
  <tr>
    <td background="../images/content_bg.gif" id="contentcell" valign="top" style="background-repeat:repeat-y"><div class="menu">
      <div id="menu"> <strong>You need to upgrade your Flash Player</strong></div>
      <script type="text/javascript">
		// <![CDATA[

		var so = new SWFObject("../menu.swf", "menu", "500", "19", "8.0.23", "#FFFFFF", true);
		so.write("menu");

		// ]]>
	</script>
	<div class="spacer"></div>
	</td>
  </tr>
  <tr>
    <td height="30" background="../images/content_footer.gif" style="background-repeat:no-repeat"></td>
  </tr>
</table>
				
<div class="spacer"></div>		
</div>		



