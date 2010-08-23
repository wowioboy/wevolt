<?php include 'includes/init.php';?>
<? if	(!isset($_SESSION['email'])) {
		header("location:index.php");
		} ?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - CHANGE PASSWORD</title>

</head>

<?php include 'includes/header_template_new.php';?>
<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 

     <div class='contentwrapper'>
 <div class="contentdiv"><?php
//include 'includes/functions.php';
if (!isset($_POST['currentpass'])) {  

include 'includes/newpass_form.inc.php'; 

} else if ($_POST['newpass'] == $_POST['confirm']){
  $logresult = file_get_contents ('https://www.panelflow.com/processing/pfusers.php?action=login&email='.$_SESSION['email'].'&pass='.$_POST['currentpass']);
 //  print  "http://www.panelflow.com/processing/pfusers.php?action=login&email=".$_SESSION['email']."&pass=".$_POST['currentpass'];
   if ($logresult != 'Not Logged') {
	$changeresult = file_get_contents ('https://www.panelflow.com/processing/pfusers.php?action=changepass&id='.trim($_SESSION['userid']).'&newpass='.$_POST['newpass']);
	//print "MY change RESULT = ". $changeresult."<br/>";
    
	 echo "An Email has been sent to your account with your new password for your records. ";
	     // print "MY LOG RESULT = ". $logresult."<br/>";
  
	} else {     //$myUsername = 'John';

	   $error = "That is not your current password";
	   include 'includes/newpass_form.inc.php';
	  
         echo "</div></td></tr><tr><td height='30' background='images/content_footer.gif' style='background-repeat:no-repeat'>&nbsp;</td></tr></table></div>";
		  exit();	
         		  
     } 
} else {
     $error = "Your Passwords do not match.";
	   include 'includes/newpass_form.inc.php';
 echo "</div></td></tr><tr><td height='30' background='images/content_footer.gif' style='background-repeat:no-repeat'>&nbsp;</td></tr></table></div>";
		  exit();	

}

?></div>
  </div>
  
</div>
  <div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>
 
</body>
</html>

