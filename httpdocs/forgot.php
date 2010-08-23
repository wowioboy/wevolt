<?php include 'includes/init.php';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - FORGOT PASSWORD</title>

</head>

<body>

<div class="wrapper" align="center">

<table width="534" cellpadding="0" cellspacing="0" border="0"><tr>
<td background="images/content_bg.gif" id="contentcell" style="background-repeat:repeat-y;"><div class="spacer"></div><div class="spacer"></div><div class="logo"><a href="index.php"><img src="images/logo.jpg" border="0" /></a></div>
<div class="slug" align="right">THE FLASH <font color="#ffa66d">WEBCOMIC</font><br />CONTENT MANAGEMENT SYSTEM</div><div class="logindiv">
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
		so.write("menu");

		// ]]>
	</script>
	<div class="spacer"></div>
<div class="contentdiv"><?php
//include 'includes/functions.php';
if (!isset($_POST['email']))
{  include 'includes/pass_form.inc.php'; } 
else
{

$emailresult = file_get_contents ('http://www.panelflow.com/processing/pfusers.php?action=resetpass&email='.$_POST['email']);
//print "MY LOG RESULT = ". $emailresult."<br/>";
     if ($emailresult != 'Not Found')
     {
	 echo "An Email has been sent to your account with your new password. Once you get your new password you can reset your password in the 'Edit Profile' section of your profile";
	     // print "MY LOG RESULT = ". $logresult."<br/>";
	 
     }
     else
	 
     {     //$myUsername = 'John';

	   $found_error = "That email is not in our system. Please try again.";
	   include 'includes/pass_form.inc.php';
	  
         echo "</div></td></tr><tr><td height='30' background='images/content_footer.gif' style='background-repeat:no-repeat'>&nbsp;</td></tr></table></div>";
		  exit();	
         		  
     }
}

?></div>
	</td>
  </tr>
  <tr>
    <td height="30" background="images/content_footer.gif" style="background-repeat:no-repeat">&nbsp;</td>
  </tr>
</table>
				
	
</div>		
</body>
</html>


