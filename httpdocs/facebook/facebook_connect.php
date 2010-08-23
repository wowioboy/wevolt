<? 
include '/var/www/vhosts/w3volt.com/subdomains/users/httpdocs/includes/init.php';
include '/var/www/vhosts/w3volt.com/subdomains/users/httpdocs/includes/global_settings_inc.php';

require_once '/var/www/vhosts/w3volt.com/subdomains/users/httpdocs/facebook-platform/php/facebook.php';


global $api_key,$secret;
$fb=new Facebook($api_key,$secret);
$fb_user=$fb->get_loggedin_user();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="http://static.new.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php" type="text/javascript"></script>

</head>

<body onload="initFB();">
<?php
     if($fb_user) {
          echo('<fb:profile-pic class="fb_profile_pic_rendered FB_ElementReady"' .
          'facebook-logo="true" size="square" uid="' . $fb_user . '"></fb:profile-pic>');
     }
 ?>

You can import your Facebook profile into W3Volt to fill out your profile information. 
<a href="facebook_auth.php">LOGIN HERE</a>
<script type="text/javascript">
function initFB() {
	FB_RequireFeatures(["XFBML"], function(){
		FB.init("<? echo $api_key;?>", "/channel/xd_receiver.htm");
	});}
</script>

</body>
</html>
