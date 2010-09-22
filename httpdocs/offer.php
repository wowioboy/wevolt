<?php 
include 'includes/init.php';
$TrackPage = 0;
$ShowForm = true;
$SubmitSubscription = false;
if ($_SESSION['userid'] != '')
	header("location:index.php");
	
if ($_POST['login'] == 1) {
	$query ="SELECT sub_type from discount_code_subscriptions where code='".$_POST['promocode']."' and redeemed=0 and (expire_date='0000-00-00 00:00:00' or expire_date>='".date('Y-m-d')." 00:00:00')";
	$SubType = $InitDB->queryUniqueValue($query);
	//print $query.'<br/>';
	if ($SubType != '') {
		include 'classes/register.php';
		$register = new register();
		$regresult = $register->createAccount(trim($_POST['username']), $_POST['email'], $_POST['pass'], '', 'y', '', '','sdcc',1,0);
		if ((trim($regresult) != 'Email Exists') && (trim($regresult) != 'User Exists')) {
			$ShowForm = false;
			$MSG = '<div class="spacer"></div>Congrats!!<div class="spacer"></div>You have successfully created an account <div class="spacer"></div>You are now logged in to WEvolt.<div class="spacer"></div>';	
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
			
			$SubmitSubscription = true;
			$query ="UPDATE discount_code_subscriptions set redeemed=1, redeem_date='".date('Y-m-d h:i:s')."', user_id='".$_SESSION['userid']."' where code='".$_POST['promocode']."'";
			$InitDB->execute($query);
			//print $query.'<br/>';
		} else if (trim($regresult) != 'Email Exists'){
			$MSG = 'Sorry that email is already in our system.';
		}  else if (trim($regresult) != 'User Exists'){
			$MSG = 'Sorry that username is already taken, please choose another.';
		} 
		
	} else {
		
		$MSG = "Sorry that code has already been redeemed.";	
		
	}
	
	
}
$InitDB->close();

$PageTitle .='discount offer'; 
if ($_SESSION['IsPro'] == 1) 
    $_SESSION['noads'] = 1;
require_once('includes/pagetop_inc.php');
$Site->drawModuleCSS();
	
?>
<script language="JavaScript" type="text/javascript" src="http://www.wevolt.com/ajax/ajax_init.js"></script>
<style type="text/css">
/* <![CDATA[ */
textarea { clear: both; font-family: sans-serif; font-size: 1em; width: 275px;}
/* ]]> */
</style>



<script type="text/javascript">
function process_subscription() {
	
document.subform.action="/process_store.php"; 
document.subform.submit();
	
}
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
	  	alert('Please enter your email address');
	else if (document.getElementById("pass").value == '')
	  	alert('Please enter a password');
	else if (document.getElementById("valid_email").value == '0')
	  	alert('Please enter a valid email address');
	else if (document.getElementById("valid_name").value == '0')
	  	alert('Please enter a valid username');
	else if (document.getElementById("confirmpass").value == '')
	  	alert('Please confirm your password');
	else if (document.getElementById("confirmpass").value != document.getElementById("pass").value)
	  	alert('Your passwords don\'t match');
	else if (document.getElementById("promocode").value == '')
	  	alert('Enter your Promo Code');
	else 
		document.regform.submit();

}






</script>


<div align="center">
<table cellpadding="0" cellspacing="0" border="0" width="<? echo $TemplateWrapperWidth;?>">
  <tr>
    <td valign="top" align="center">
    <div class="content_bg">
		<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <?php $Site->drawControlPanel(); ?>
            </div>
        <? }?>
        <? if ($_SESSION['noads'] != 1) {?>
            <div id="ad_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;" align="center">
                <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
            </div>
        <?  }?>
       
       
        <div id="header_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;">
           <? $Site->drawHeaderWide();?>
        </div>
    </div>
    
     <div class="shadow_bg">
        	 <? $Site->drawSiteNavWide();?>
    </div>
    
   <div align="center">
   <div class="spacer"></div>
 <table>
                 <tr><td <? if ($ShowForm) {?>colspan="2"<? }?>></td></tr><tr><? if ($ShowForm) {?><td><img src="http://www.wevolt.com/images/offer_card.png" hspace="10"/></td><? }?><td>
                        <table width="300" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="284" align="center">
         <div class="spacer"></div><? echo $MSG;?>
        <? if ($SubmitSubscription) {?>
        <div class="messageinfo_warning" style="font-size:14px;">
        To start processing your subscription, click the button below: <div class="spacer"></div>This will take you to Paypal to set up your WEvolt subscription. <div class="spacer"></div>You <strong>WILL NOT</strong> be charged until your trial period is over, at which point you will start being billed the standard monthly rate if you don't cancel. 
</div><div class="spacer"></div>
        <img src="http://www.wevolt.com/images/sign_up_box.png" onclick="process_subscription();" class="navbuttons"/>
        
        <? }?>
                  

         
        
         <? if ($ShowForm) {?>
         Please enter a desired WEvolt username and your email and password below. <div class="spacer"></div>
         
         <form action="#" method="post" style="padding:0px;" id="regform" name="regform">

<table width="100%">

<tr><td class="messageinfo_white" width="200" align="right"  style="font-size:14px;">New WEvolt username:</td><td style="padding:3px;" align="left">
<input type="text" id="username" name="username" style="width:125px;" onfocus="doClear(this);" onblur="setDefault(this);"  onkeyup="checkUser(this.value);"/><div id="name_search"></div></td>
</tr>
<tr><td class="messageinfo_white" width="75" align="right"  style="font-size:14px;">Email:</td><td style="padding:3px;" align="left">
<input type="text" id="email" name="email" style="width:125px;" onfocus="doClear(this);" onblur="setDefault(this);" onkeyup="checkEmail(this.value);"/><div id="email_search"></div></td>
</tr>
<tr>
<td class="messageinfo_white" width="75" align="right" style="font-size:14px;">Password:</td><td style="padding:3px;" align="left">
<input type="password" id="pass" name="pass" style="width:125px;" onfocus="doClear(this);" onblur="setDefault(this);"/></td></tr>
<tr>
<td class="messageinfo_white" width="75" align="right" style="font-size:14px;">Confirm Password:</td><td style="padding:3px;" align="left">
<input type="password" id="confirmpass" name="confirmpass" style="width:125px;" onfocus="doClear(this);" onblur="setDefault(this);"/></td></tr>
<tr>
<td class="messageinfo_white" width="75" align="right" style="font-size:14px;">PROMO CODE:</td><td style="padding:3px;" align="left">
<input type="text" id="promocode" name="promocode" style="width:125px;" onfocus="doClear(this);" onblur="setDefault(this);"/></td></tr>
<tr>
<td class="messageinfo_white" width="75" align="right" style="font-size:14px;"></td><td style="padding:3px;" align="left"><img src="http://www.wevolt.com/images/sign_up_box.png" onclick="submit_form();" class="navbuttons"/></td></tr>
</table>
<input type="hidden" name="from" value="sdcc">
<input type="hidden" name="login" value="1">
<input type="hidden" name="valid_email" id="valid_email" value="0">
<input type="hidden" name="valid_name" id="valid_name" value="0">
<input type="hidden" name="login" value="1">
<input type="hidden" name="txtSubType" value="<? echo $_REQUEST['txtSubType'];?>">
<input type="hidden" name="type" value="hosted">
<input type="hidden" name="start" value="1">
</form>
<? }?>
                                       
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>    
                        </td>
                        </tr>
                        </table>                
  </div>

	</td>
  </tr>
 
</table>
</div>
  
<?php require_once('includes/pagefooter_inc.php'); ?>




