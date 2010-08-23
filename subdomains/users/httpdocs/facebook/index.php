<? 
// Copyright 2007 Facebook Corp.  All Rights Reserved. 
// 
// Application: W3VOLT
// File: 'index.php' 
//   This is a sample skeleton for your application. 
// 
include $_SERVER['DOCUMENT_ROOT'].'includes/init.php';
include $_SERVER['DOCUMENT_ROOT'].'includes/global_settings_inc.php';

require_once $_SERVER['DOCUMENT_ROOT'].'facebook-platform/php/facebook.php';


global $api_key,$secret;
$fb=new Facebook($api_key,$secret);
$fb_user=$fb->get_loggedin_user();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script> 
<script type="text/javascript"> 		
function initFB() {
FB.init("<? echo $api_key;?>", "/channel/xd_receiver.htm", {"ifUserConnected" : update_user_box});
}


function update_user_box() { 

var user_box = document.getElementById("user"); 
// add in some XFBML. note that we set useyou=false so it doesn't display "you" 

user_box.innerHTML = "<span>" + "<fb:profile-pic uid='loggedinuser' facebook-logo='true'></fb:profile-pic><br/>" + "<b>SUCCESS!</b> <br/>You are signed in with your Facebook account. You can now sync or import your Facebook profile with W3VOLT!<br/><br/>" + "</span><a href=\"/facebook/faceimport.php?a=sync\">CLICK HERE TO SYNC YOUR PROFLILE</a><br/>(this will replace all profile information in your W3VOLT profile with your Facebook info)<br/><br/><a href=\"/facebook/faceimport.php?a=import\">CLICK HERE TO IMPORT YOUR PROFLILE </a><br/>(this will append your Facebook information to the end of any current profile information in your W3VOLT profile)"; 
// because this is XFBML, we need to tell Facebook to re-process the document 
FB.XFBML.Host.parseDomTree(); 
 document.getElementById("status_perm").style.display=''; 



} 

 </script>
</head>
<body onload="initFB();">

<div id="comments_post" align="center"> 
<img src="http://www.wevolt.com/images/facebook_sync.png"/> <div style="height:10px;"></div>
<b>SYNC YOUR FACEBOOK PROFILE WITH W3VOLT!</b> <div id="user"><div style="height:10px;"></div>If you see your name below then you're already logged into Facebook, otherwise click the Facebook Connect button to get started. <div style="height:10px;"></div>
  <div style="height:10px;"></div>
 
<fb:login-button onlogin="update_user_box();"></fb:login-button> 
</div> 

<div id="status_perm" style="display:none;">
<? if (!$fb->api_client->users_hasAppPermission("status_update")){?>
  <fb:prompt-permission perms="status_update,read_stream,publish_stream,share_item,offline_access,create_event"> Grant permission for status updates </fb:prompt-permission><? }?>
  
  
  <? //$StatusStuff = $fb->api_client->call_method("facebook.status.get", array('uid'=>$fb_user, 'limit'=>'5')); 
  //	print_r($StatusStuff);
  ?>
</div>

</div> 



</body>
</html>
