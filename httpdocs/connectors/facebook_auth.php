<?
include_once( $_SERVER['DOCUMENT_ROOT'].'/includes/init.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/facebook_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/facebook-platform/php/facebook.php');

global $api_key,$secret;

$fb=new Facebook($api_key,$secret);
$fb_user=$fb->get_loggedin_user();
 try {   
         
$user_pic=$fb->api_client->users_getInfo($fb_user, array('pic_big'));  
    }
    catch (Exception $e) {
     
    }   


$query ="SELECT encryptid from users where FaceID='$fb_user'";
$UserID = $InitDB->queryUniqueValue($query);

if ($UserID == '') {
	$FaceAuth = false;
} else {
	$FaceAuth = true;
}

?>

<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
<script type="text/javascript" src="http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php"></script> 
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script type="text/javascript"> 		
function initFB() {
FB.init("<? echo $api_key;?>", "/channel/xd_receiver.htm", {"ifUserConnected" : update_user_box});
}


function update_user_box() { 
//window.location.href='/connectors/facebook_auth.php?r=<? //echo urlencode($_GET['r']);?>';

//var user_box = document.getElementById("user"); 
// add in some XFBML. note that we set useyou=false so it doesn't display "you" 
//attach_file('http://www.wevolt.com/connectors/facebook_auth.php');
//user_box.innerHTML = "<span>" + "<fb:profile-pic uid='loggedinuser' facebook-logo='true'></fb:profile-pic><br/>" + "<b>SUCCESS!</b> <br/>You are signed in with your Facebook account. You can now sync or import your Facebook profile with W3VOLT!<br/><br/>" + "</span><a href=\"/facebook/faceimport.php?a=sync\">CLICK HERE TO SYNC YOUR PROFLILE</a><br/>(this will replace all profile information in your W3VOLT profile with your Facebook info)<br/><br/><a href=\"/facebook/faceimport.php?a=import\">CLICK HERE TO IMPORT YOUR PROFLILE </a><br/>(this will append your Facebook information to the end of any current profile information in your W3VOLT profile)"; 
// because this is XFBML, we need to tell Facebook to re-process the document 
//FB.XFBML.Host.parseDomTree(); 
 //document.getElementById("status_perm").style.display=''; 
} 

 </script>
<style type="text/css">
body,html {
margin:0px;
padding:0px;
}

</style>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
</head>
<body onLoad="initFB();" <? if ($_GET['form'] == 'page') {?>style='background-image:url(http://www.wevolt.com/images/new_bg2.jpg);background-repeat:no-repeat;background-position:top left;background-color:#0e478a;'<? }?>>

<div style="background-image:url(http://www.wevolt.com/images/login_bg.jpg); width:314px; height:396px; padding:3px;">
<div align="center" class="messageinfo_warning">
 <? // if (!$fb->api_client->users_hasAppPermission("offline_access")){?>
 	<!--<fb:prompt-permission perms="offline_access,status_update,read_stream,publish_stream,share_item">Make sure you set your permissions</fb:prompt-permission>-->
 
 <? // } ?>
 <?
 if (!$FaceAuth) {?>
		<? include 'login_form_fb.php';
		} else {?>
      
		<div class="spacer"></div>
		<div align="center" class="messageinfo_warning">
		YOU ARE NOW LOGGED IN<br />
		<img src="<? echo $user_pic[0]['pic_big'];?>" width="100">
		</div>
		<script type="text/javascript">
		<? if ($_GET['form'] == 'page') {?>
		
		document.location.href='http://www.wevolt.com/connectors/login_auth.php?e=<? echo $UserID;?>&r=<? echo $_GET['r'];?>';
		<? } else {?>
		document.location.href='http://www.wevolt.com/connectors/login_auth_frame.php?e=<? echo $UserID;?>&r=<? echo $_GET['r'];?>&f=iframe';
		<? }?>
		
		</script>
		<? }?>
</div>

