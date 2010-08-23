<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
include  $_SERVER['DOCUMENT_ROOT'].'/includes/facebook_config.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/facebook-platform/php/facebook.php';
global $api_key,$secret;
$fb=new Facebook($api_key,$secret);
$fb_user=$fb->get_loggedin_user();

$Pass = $_POST['userpass'];
$Ref = $_POST['refurl'];
if ($Ref == '')
	$Ref=$_GET['r'];
if ($Ref == '')
	$Ref=$_POST['r'];	
	
$From = $_POST['from'];
if ($From == '')
	$From = $_GET['f'];
	
$UserID = trim($_GET['e']);
if ($UserID == '')
	$UserID = $_POST['user'];
if ($UserID == '') 
	$UserID =  trim($_POST['e']);
	
$Action = $_POST['action'];


if ((isset($_POST['email'])) || ($UserID != '')) { 

	if ($_POST['email'] != '') {
					$query = "select salt from users where email='".$_POST['email']."'";
					$salt = $InitDB->queryUniqueValue($query);
		
				//	print 'SALT = ' . $salt.'<br/>';
				//	print 'PASS = ' . $_POST['userpass'].'<br/>';
					//print 'md5(_POST[serpass).salt = ' . md5($_POST['userpass']).$salt.'<br/>';
					$encrypted_pass = md5(md5($_POST['userpass']).$salt);
					$query = "select encryptid, username, email, avatar, realname, verified from users where email='".$_POST['email']."' and password='$encrypted_pass'";
					$user = $InitDB->queryUniqueObject($query);
			
				    $userid = $user->encryptid;
					$Useremail = $user->email;
					if ($userid != '') {
						if ($user->verified == 1){
							$logresult = trim($userid);
							if (($Action == 'fbconnect') &&($fb_user != '')) {
								$query="update users set FaceID='$fb_user' where encryptid='$userid'";
								$InitDB->query($query);
								
							}
						}else {
							$logresult = 'Not Verified';
						}
					} else {
					 	$logresult = 'Not Logged';
					}
					
				
	} else if (($UserID != '') && ($fb_user != '')) {
				
						$query = "select encryptid, username, email, avatar, realname, verified from users where encryptid='$UserID ' and FaceID='$fb_user'";
						$user = $InitDB->queryUniqueObject($query);
						$Useremail = $user->email;
						if ($Useremail != '') {
							if ($user->verified == 1)
								$logresult = trim($UserID);
							else 
								$logresult = 'Not Verified';
						} else {
						     $logresult = 'Not Logged';
						}
					//print $logresult;
	}

     if ((trim($logresult) != 'Not Logged') && (trim($logresult) != 'Not Verified')) {
	 		$NOW = date('Y-m-d h:i:s');
			$query = "UPDATE users set LastLogin = '$NOW' where encryptid='".trim($logresult)."'";
			$InitDB->execute($query);
			// unset($_SESSION);
			 $_SESSION['userid'] = trim($logresult);
			 $_SESSION['email'] = $Useremail;
			 $_SESSION['lastlogin'] = $NOW;
			 $_SESSION['encrypted_email'] =  md5($Useremail);
				
			$getUser = file_get_contents ('https://www.wevolt.com/processing/pfusers.php?action=get&item=username&id='.trim($_SESSION['userid']));
		
			$_SESSION['username'] = trim($getUser);
			$getUser = file_get_contents ('https://www.wevolt.com/processing/pfusers.php?action=get&item=avatar&id='.trim($_SESSION['userid']));
			$_SESSION['avatar'] = $getUser;
			
//			   if($_POST['txtRemember'] == 1){
					setcookie("userid", $_SESSION['userid'], time()+60*60*24*100, "/", 'wevolt.com');
//					setcookie("usercookie[email]", $_SESSION['email'], time()+60*60*24*100, "/", 'wevolt.com');
//					setcookie("usercookie[username]", $_SESSION['username'], time()+60*60*24*100, "/", 'wevolt.com');
//					setcookie("usercookie[password]", md5($Pass), time()+60*60*24*100, "/", 'wevolt.com');
//					setcookie("usercookie[cryptmail]", $_SESSION['encrypted_mail'], time()+60*60*24*100, "/", 'wevolt.com');
				//}
	
				// session_write_close();
			     $query = "SELECT ShowWelcome from users_settings where UserID='".trim($logresult)."'";
				 $ShowWelcome = $InitDB->queryUniqueValue($query);
				$_SESSION['showelcome'] =  $ShowWelcome;
			   if (($Ref != 'http://www.wevolt.com/')&&($Ref != 'http://www.wevolt.com/connectors/login_auth_frame.php') && ($Ref != '')) {
			   		 header("Location:".$Ref);
					
			   } else {	
			  //   print 'GOT HERE';
					if (($ShowWelcome == 1) || ($ShowWelcome == '')) {	
						header("Location:http://www.wevolt.com/welcome.php");
					}else{
					//  print 'GOT HERE';
					//print_r($_SESSION);
					//print 'REF URL = ' . 'Location:http://users.wevolt.com/myvolt/'.trim($_SESSION['username']).'/';
						header("Location:http://users.wevolt.com/myvolt/".trim($_SESSION['username'])."/");
					} 
					
			   }
			 
     } else if (trim($logresult) == 'Not Verified'){  
	 		$Error = 'Your Account is not yet verified';
	  		//$redirect = 'http://www.wevolt.com/login.php';
     } else if ($logresult == 'Not Logged'){  
	   				$Error = 'There was an error logging into your account. Please check your fields and try again.';
					//$redirect = 'http://www.wevolt.com/login.php';
			
     } else {
	 $Error = 'There was an error logging into your account. Please try again later. Sorry for the inconvenience.';
     	//$redirect = 'http://www.wevolt.com/login.php';
	 }
	
}

$PageTitle = 'wevolt | login';

?>

<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/header_template_new.php'; ?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_modules_css.css">
<div align="left">

<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
<tr>
<? if ($_SESSION['IsPro'] == 1) {
$_SESSION['noads'] = 1;
		?>
		<td valign="top" style="padding:5px; color:#FFFFFF;width:60px;">
			<? include $_SERVER['DOCUMENT_ROOT'].'/includes/site_menu_popup_inc.php';?>
		</td> 
	<? } else {?>
<td width="<? echo $SideMenuWidth;?>" valign="top">
	<? include $_SERVER['DOCUMENT_ROOT'].'/includes/site_menu_inc.php';?>
</td> 
<? }?>
 
<td  valign="top" align="center"><? if ($_SESSION['noads'] != 1) {?><iframe src="http://www.wevolt.com/includes/top_banner_inc.php" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no"></iframe> <? }?>

    <? ?>
    <div class="spacer"></div>
   <?php if ($redirect != '') { ?>
<script>
//window.location.href = '<?php //echo $redirect; ?>';
</script>
<?php }  else { ?>
<? echo $Error;?>
<? 
 
 $Form = 'page';
include $_SERVER['DOCUMENT_ROOT'].'/connectors/login_form.php';

}?>
    
 	</td>
	
</tr>
</table>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/footer_template_new.php';?>

