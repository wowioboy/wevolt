<? 
// Copyright 2007 Facebook Corp.  All Rights Reserved. 
// 
// Application: W3VOLT
// File: 'index.php' 
//   This is a sample skeleton for your application. 
// 
include '/var/www/vhosts/w3volt.com/subdomains/users/httpdocs/includes/init.php';
include '/var/www/vhosts/w3volt.com/subdomains/users/httpdocs/includes/global_settings_inc.php';

require_once '/var/www/vhosts/w3volt.com/subdomains/users/httpdocs/facebook-platform/php/facebook.php';


global $api_key,$secret;
$fb=new Facebook($api_key,$secret);
$fb_user=$fb->get_loggedin_user();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml"> 
<head>
<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script> 

</head>
<body> 
<div id="comments_post" align="center"> 
<img src="http://www.w3volt.com/images/facebook_sync.png"/> <div style="height:10px;"></div>
<? if (!$fb->api_client->users_hasAppPermission("status_update")){?>
  <fb:prompt-permission perms="status_update,read_stream,publish_stream,share_item"> Grant permission for status updates </fb:prompt-permission>
  
  
  <? //$StatusStuff = $fb->api_client->call_method("facebook.status.get", array('uid'=>$fb_user, 'limit'=>'5')); 
  //	print_r($StatusStuff);
 } else { ?>
 <b>UPDATE YOUR FACEBOOK STATUS HERE!</b> <div id="user"><div style="height:10px;"></div><div style="height:10px;"></div>
<? } ?>
  <div style="height:10px;"></div>
 
<fb:login-button onlogin="update_user_box();"></fb:login-button> </div> 

<?
if(isset($_POST['status']))
{
    $fb->api_client->users_setStatus($_POST['status']);
    echo "<p>Your status has been updated</p>";
}
?>
<div id="statusdiv">
    <form method="POST">
        Please update your status:<br/>
        <input type="text" name="status" /> <br/>
        <input type="submit" value="change status" />
    </form>
</div>

</body>
</html>
