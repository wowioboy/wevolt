<?php include 'init.php';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - THE FLASH WEBCOMIC CMS</title>

</head>

<body>

<div class="wrapper" align="center">

<table width="534" cellpadding="0" cellspacing="0" border="0"><tr>
<td background="images/content_bg.gif" id="contentcell" style="background-repeat:repeat-y;"><div class="spacer"></div><div class="spacer"></div><div class="logo"><img src="images/logo.jpg" /></div><div class="slug" align="right">THE FLASH <font color="#ffa66d">WEBCOMIC</font><br />CONTENT MANAGEMENT SYSTEM</div><div class="logindiv">
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
		so.addVariable('username','<?php echo $_SESSION['username'];?>');
		so.write("login");

		// ]]>
	</script></div></td>
</tr>
  <tr>
    <td background="images/content_bg.gif" id="contentcell" valign="top" style="background-repeat:repeat-y"><div class="menu">
      <div id="menu"> <strong>You need to upgrade your Flash Player</strong></div>
      <script type="text/javascript">
		// <![CDATA[

		var so = new SWFObject("menu.swf", "menu", "500", "19", "8.0.23", "#FFFFFF", true);
		so.write("menu");

		// ]]>
	</script>
	<div class="spacer"></div>