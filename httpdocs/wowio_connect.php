<?php 
include 'includes/init.php';
$PageTitle .= 'wowio user connect';
$TrackPage = 0;
$ShowForm = true;
if ($_SESSION['userid'] != '')
	header("location:index.php");
	
if ($_POST['login'] == 1) {
	require_once("includes/curl_http_client.php");
	$curl = @new Curl_HTTP_Client();
	$useragent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)";
	$curl->set_user_agent($useragent);
	$post_data = array('txtEmail' => $_POST['email'], 'txtPassword' => $_POST['pass']);
	$updateresult = @$curl->send_post_data("https://www.wowio.com/users/library/checklogon.asp", $post_data);
	unset($post_data);	
	if (trim($updateresult) == 'OK') {
		include 'classes/register.php';
		$register = new register();
	
		$regresult = $register->createAccount(trim($_POST['username']), $_POST['email'], $_POST['pass'], '', 'y', '', '','wowio',1,0);
		if ((trim($regresult) != 'Email Exists') && (trim($regresult) != 'User Exists')) {
			$ShowForm = false;
			$MSG = '<div class="spacer"></div>Congrats!!<div class="spacer"></div>You have successfully logged in and created a WEvolt account with the same email and password. <div class="spacer"></div>You are now logged in to WEvolt.<div class="spacer"></div><strong>NOTE:</strong> If you change your password on WOWIO, your WEvolt password will not change.';	
			$NOW = date('Y-m-d h:i:s');
			$query = "UPDATE users set LastLogin = '$NOW' where encryptid='".trim($regresult)."'";
			$InitDB->execute($query);
			$_SESSION['userid'] = trim($regresult);
			$_SESSION['email'] =  $_POST['email'];
			$_SESSION['lastlogin'] = $NOW;
			$_SESSION['encrypted_email'] =  md5( $_POST['email']);
			$_SESSION['username'] = $_POST['username'];
			
			$getUser = file_get_contents ('https://www.wevolt.com/processing/pfusers.php?action=get&item=avatar&id='.trim($_SESSION['userid']));
			$_SESSION['avatar'] = $getUser;
	
			setcookie("userid", $_SESSION['userid'], time()+60*60*24*100, "/", 'wevolt.com');	
			
		} else if (trim($regresult) != 'Email Exists'){
			$MSG = 'Sorry that email is already in our system.';
		}  else if (trim($regresult) != 'User Exists'){
			$MSG = 'Sorry that username is already taken, please choose another.';
		} 
		
	} else {
		
		$MSG = "Sorry could not log in to that Wowio account. Please check your fields and try again.";	
		
	}
	
	
}
$InitDB->close();
include 'includes/header_template_new.php';

$Site->drawModuleCSS();
 if ($_SESSION['IsPro'] == 1) {
           $_SESSION['noads'] = 1;
		} 

?>
<script language="JavaScript" type="text/javascript" src="http://www.wevolt.com/ajax/ajax_init.js"></script>
<style type="text/css">
/* <![CDATA[ */
textarea { clear: both; font-family: sans-serif; font-size: 1em; width: 275px;}
/* ]]> */
</style>



<script type="text/javascript">

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 
 document.getElementById("search_results").innerHTML=xmlHttp.responseText;
 document.getElementById('search_container').style.display='';

 } 
}
function display_data(keywords,selecttype) {

    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null) {
        alert ("Your browser does not support AJAX!");
        return;
    }
    var url="/connectors/RegSearch.php";
    url=url+"?select="+selecttype+"&keywords="+escape(keywords);
	//alert(url);
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete") {
		
			if ((selecttype == 'email') && (xmlhttp.responseText == '1')){
			 	document.getElementById('email_search').innerHTML='<div style="color:#bf0404;">That email is already in our system.</div>';
				document.getElementById('valid_email').value=0;
			}else if ((selecttype == 'username') && (xmlhttp.responseText == '1')){
			 	document.getElementById('name_search').innerHTML='<div style="color:#bf0404;">Sorry that username is taken</div>';
				document.getElementById('valid_name').value=0;
			}else if ((selecttype == 'username') && (xmlhttp.responseText == '0')){
			 	document.getElementById('name_search').innerHTML='<div style="color:#24860a;">Username is Available</div>';
				document.getElementById('valid_name').value=1;
			} else if ((selecttype == 'email') && (xmlhttp.responseText == '0')){
			 	document.getElementById('valid_email').value=1;
				document.getElementById('email_search').innerHTML= '';
			}
          
        }
    }
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}	
var timer = null;
function checkUser(keywords) {
    if (timer) window.clearTimeout(timer); // If a timer has already been set, clear it
	if (keywords != '') 
    timer = window.setTimeout(display_data(keywords,'username'), 2000); // Set it for 2 seconds
    //Just leave the method and let the timer do the rest...
}
function checkEmail(keywords) {
    if (timer) window.clearTimeout(timer); // If a timer has already been set, clear it
	if (keywords != '') 
    timer = window.setTimeout(display_data(keywords,'email'), 7000); // Set it for 2 seconds
    //Just leave the method and let the timer do the rest...
}
function submit_form() {
			
	if (document.getElementById("username").value == '') 
		alert('Please Enter a Username to use on WEvolt');
	else if (document.getElementById("email").value == '')
	  	alert('Please enter your registered WOWIO email address');
	else if (document.getElementById("pass").value == '')
	  	alert('Please enter your registered WOWIO password');
	else if (document.getElementById("valid_email").value == '0')
	  	alert('Please enter a valid email address');
	else if (document.getElementById("valid_name").value == '0')
	  	alert('Please enter a valid username');
	else 
		document.regform.submit();

}






</script>
<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <td valign="top" <? if ($_SESSION['IsPro'] == 1) {?>width="60"<? } else {?>width="<? echo $SideMenuWidth;?>"<? }?>><? include 'includes/site_menu_inc.php';?></td>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;" align="left">
          <div class="spacer"></div>
          <img src="http://www.wevolt.com/images/wowio_to_wevolt_user.png" />  <div class="spacer"></div>
          <center> <div class="spacer"></div>
<table width="728"><tr><td class="messageinfo_white">
           <? echo '<b>'.$MSG.'</b>';?>
         <div class="spacer"></div>
         <? if ($ShowForm) {?>
       
         Please enter a desired WEvolt username and your WOWIO email and password below. <div class="spacer"></div>We will only check to make sure your account is valid. If so, a WEvolt account will be created with the same information. <div class="spacer"></div><div class="messageinfo_warning">You only need to do this once. If you already have a WEvolt account, just login to the left.<div class="spacer"></div></div>
         </td><td width="358" height="148" class="messageinfo_white" background="http://www.wevolt.com/images/rounded_box_white.png">
         <form action="#" method="post" style="padding:0px;" id="regform" name="regform">

<table width="100%">
<tr><td class="messageinfo_white" width="185" align="right"  style="font-size:14px;">New WEvolt username:</td><td style="padding:3px;" align="left">
<input type="text" id="username" name="username" style="width:125px;" onfocus="doClear(this);" onblur="setDefault(this);"  onkeyup="checkUser(this.value);"/><div id="name_search"></div></td>
</tr>
<tr><td class="messageinfo_white"  align="right"  style="font-size:14px;">WOWIO Email:</td><td style="padding:3px;" align="left">
<input type="text" id="email" name="email" style="width:125px;" onfocus="doClear(this);" onblur="setDefault(this);" onkeyup="checkEmail(this.value);"/><div id="email_search"></div></td>
</tr>
<tr>
<td class="messageinfo_white" align="right" style="font-size:14px;">WOWIO Password:</td><td style="padding:3px;" align="left">
<input type="pass" id="pass" name="pass" style="width:125px;" onfocus="doClear(this);" onblur="setDefault(this);"/></td></tr>
<tr>
<td class="messageinfo_white" width="75" align="right" style="font-size:14px;"></td><td style="padding:3px;" align="left"><img src="http://www.wevolt.com/images/login_btn_sq.jpg" onclick="submit_form();" class="navbuttons"/></td></tr>
</table>
<input type="hidden" name="from" value="wowio">
<input type="hidden" name="login" value="1">
<input type="hidden" name="valid_email" id="valid_email" value="0">
<input type="hidden" name="valid_name" id="valid_name" value="0">
<input type="hidden" name="login" value="1">
</form>
</td></tr></table>
</center>
<? }?>
                                               

      </div></td>
  </tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>

