<? if (is_authed()) { 
		$loggedin = 1;
		} else {
		$loggedin = 0;
		} ?>
        
        <script type="text/javascript">

if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)))
{
location.href='iphone/index.php';
}

</script> 
<div class="wrapper" align="center">

<table width="778" cellpadding="0" cellspacing="0" border="0"><tr>
<td background="/images/content_header.jpg" height="50" style="background-repeat:no-repeat;"></td>
</tr>
  <tr>
    <td background="/images/content_background.jpg" id="contentcell" valign="top" style="background-repeat:repeat-y">
   
    <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr>
<td valign="top"><div id="login" align="center">
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
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td><? if ($loggedin == 1) { ?>
 <div align="right" class="usermenu">Welcome, <? echo $_SESSION['username'];?>  [<a href="/logout.php">logout</a>]&nbsp;&nbsp;[<a href="/cms/admin/">LAUNCH COMIC ADMIN</a>]</div>     
	<?	} else { 
	
	if (!$ShowLogin) {?>

    <div align="right" style="padding-right:41px; padding-bottom:3px;"">
    <div id="login2">
		<strong>You need to upgrade your Flash Player <br /><a href="/login.php"> CLICK HERE TO LOGIN </a></strong></div>
<script type="text/javascript">
		// <![CDATA[

		var so = new SWFObject("/flash/login_inline.swf", "images", "382", "20", "8.0.23", true);
		so.write("login2");

		// ]]>
	</script>
    </div>
	<?	}} ?></td></tr>
<tr>
<td class="menubar" background="/images/menu_bg.jpg" align='center'><? if ($loggedin == 1) { ?>
<a href="/profile/<? echo trim($_SESSION['username']);?>/">PROFILE</a><? } else {?>
<a href="/register/">REGISTER</a><? }?>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/comics/" />COMICS</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/creators/" />CREATORS</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/faq/" />FAQ</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/go/pro/" />DOWNLOAD</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/blog/" />BLOG</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/mobile/" />MOBILE</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="http://forum.panelflow.com/Sources/lguser.php" />FORUM</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="/contact/" />CONTACT</a>
</td>
</tr>
</table>

    
     <div class='spacer'></div>