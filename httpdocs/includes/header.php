<? if (is_authed()) { 
		$loggedin = 1;
		} else {
		$loggedin = 0;
		} ?>

<div class="wrapper" align="center">

<table width="534" cellpadding="0" cellspacing="0" border="0"><tr>
<td background="images/content_bg.gif" id="contentcell" style="background-repeat:repeat-y;"><div class="spacer"></div><div class="spacer"></div><div class="logo"><a href="index.php"><img src="images/logo.jpg" border="0" /></a></div><div class="slug" align="right">THE FLASH <font color="#ffa66d">WEBCOMIC</font><br />CONTENT MANAGEMENT SYSTEM<br />
 AND <font color="#ffa66d">COMMUNITY</font></div><div class="logindiv">
<div id="login">
		<strong>You need to upgrade your Flash Player <br /><a href="login.php"> CLICK HERE TO LOGIN </a></strong></div>
<script type="text/javascript">
		// <![CDATA[

		var so = new SWFObject("../login.swf", "images", "171", "80", "8.0.23", "#FFFFFF", true);
	    so.addVariable('loggedin','<?php echo $loggedin;?>');
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
		 so.addVariable('loggedin','<?php echo $loggedin;?>');
		so.write("menu");

		// ]]>
	</script>
	<div class="spacer"></div>