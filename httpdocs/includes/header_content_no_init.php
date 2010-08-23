
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
      
<? if ($loggedin == 1) { ?>
 <img src="/images/logged_menu.jpg" border="0" usemap="#loggedMap" />
	<?	} else { ?>
 <img src="/images/menu_image.gif" border="0" usemap="#Map" />
	<?	} ?>

    
     <div class='spacer'></div>