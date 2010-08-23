<?php include 'includes/init.php';?>
<?php
 
include 'includes/dbconfig.php';
$Authcode = $_GET['authcode'];
$ID = $_GET['id'];

if ((isset($_GET['authcode']){
 	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 	mysql_select_db ($userdb) or die ('Could not select database.');
     // Try and get the salt from the database using the username
     $query = "select encryptid, username from $usertable where encryptid='$ID' " .
	  		  "and authcode='$Authcode' limit 1";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     $numrows = mysql_num_rows($result);

     // Now encrypt the data to be stored in the session
     // Store the data in the session
	
    $userid = $user['encryptid'];
	$useremail = $user['email'];
    if ($numrows == 1) {
		if ($user['verified'] == 1) {
			echo "Your account has already been verified";
		} else {
			echo trim($userid);
		}
		
	} else {
		 echo 'Your Authorization Code does not match. Please try the link again or resend the authorization code by <a href="resend.php">clicking here.';
	
	}
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - ACCOUNT VERIFICATION</title>

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
<div class="contentdiv">


</div>
	</td>
  </tr>
  <tr>
    <td height="30" background="images/content_footer.gif" style="background-repeat:no-repeat">&nbsp;</td>
  </tr>
</table>
				
	
</div>		
</body>
</html>


