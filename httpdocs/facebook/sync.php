<? 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
include  $_SERVER['DOCUMENT_ROOT'].'/includes/facebook_config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/facebook-platform/php/facebook.php';

global $api_key,$secret;
$fb=new Facebook($api_key,$secret);
$fb_user=$fb->get_loggedin_user();
$user_pic=$fb->api_client->users_getInfo($fb_user, array('pic_big'));  

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script> 
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script type="text/javascript"> 		
function initFB() {
FB.init("<? echo $api_key;?>", "/channel/xd_receiver.htm", {"ifUserConnected" : update_user_box});
}


function update_user_box() { 

var user_box = document.getElementById("user"); 
// add in some XFBML. note that we set useyou=false so it doesn't display "you" 

user_box.innerHTML = "<fb:profile-pic uid='loggedinuser' facebook-logo='true' size='normal' width='100'></fb:profile-pic><div class='spacer'></div><em>SUCCESS!</em> <div class='spacer'></div>You are signed in with your Facebook account. <br/>You can now sync or import your Facebook profile with WEvolt!<div class='spacer'></div><img src='http://www.wevolt.com/images/import_box.png' border='0' usemap='#importMap' /><map name='importMap'><area shape='rect' coords='142,7,332,55' href='http://www.wevolt.com/facebook/faceimport.php?a=import'></map><div class='spacer'></div><div class='spacer'></div><img src='http://www.wevolt.com/images/sync_box.png' border='0' usemap='#syncMap' /><map name='syncMap'><area shape='rect' coords='142,7,332,55' href='http://www.wevolt.com/facebook/faceimport.php?a=sync'></map>"; 
// because this is XFBML, we need to tell Facebook to re-process the document 
FB.XFBML.Host.parseDomTree(); 
 document.getElementById("status_perm").style.display=''; 

<!--<br/><img src='http://www.wevolt.com/images/import_box.png' border='0' usemap='#importMap' /><map name='importMap'><area shape='rect' coords='142,7,332,55' href='http://www.wevolt.com/facebook/faceimport.php?a=import'></map><img src='http://www.wevolt.com/images/sync_box.png' border='0' usemap='#syncMap' /><map name='syncMap'><area shape='rect' coords='142,7,332,55' href='http://www.wevolt.com/facebook/faceimport.php?a=sync'></map>-->

} 

 </script>
</head>
<body onload="initFB();">

<div id="comments_post" align="center"> 
<img src="http://www.wevolt.com/images/sync_facebook.png"/> <div style="height:10px;"></div>
<div id="user" class="messageinfo_white"><div style="height:10px;"></div>If you see your name below then you're already logged into Facebook, otherwise click the Facebook Connect button to get started. <div style="height:10px;"></div>
  <div style="height:10px;"></div>
 
<fb:login-button onlogin="update_user_box();"></fb:login-button> 
</div> 

<div id="status_perm" style="display:none;">
<? /*if (!$fb->api_client->users_hasAppPermission("status_update")){?>
  <fb:prompt-permission perms="status_update,read_stream,publish_stream,share_item,offline_access,create_event"> Grant permission for status updates </fb:prompt-permission><? }?>
  
  
  <? //$StatusStuff = $fb->api_client->call_method("facebook.status.get", array('uid'=>$fb_user, 'limit'=>'5')); 
  //	print_r($StatusStuff);
  ?>
</div>
<? */?>

</div> 



</body>
</html>
