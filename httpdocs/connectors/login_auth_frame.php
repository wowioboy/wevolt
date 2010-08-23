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
	
$From = $_POST['from'];
if ($From == '')
	$From = $_GET['f'];
	
$UserID = trim($_GET['e']);
if ($UserID == '')
	$UserID = $_POST['user'];
	
$Action = $_POST['action'];


if ((isset($_POST['email'])) || ($UserID != '')) { 

	if ($_POST['email'] != '') {
		
					$query = "select salt from users where email='".$_POST['email']."'";
					$salt = $InitDB->queryUniqueValue($query);
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

	}
	

     if ((trim($logresult) != 'Not Logged') && (trim($logresult) != 'Not Verified')) {
	 		$NOW = date('Y-m-d h:i:s');
			$query = "UPDATE users set LastLogin = '$NOW' where encryptid='".trim($logresult)."'";
			$InitDB->execute($query);
			 $_SESSION['userid'] = trim($logresult);
			 $_SESSION['email'] = $Useremail;
			 $_SESSION['lastlogin'] = $NOW;
			 $_SESSION['encrypted_email'] =  md5($Useremail);
				
			$getUser = file_get_contents ('https://www.wevolt.com/processing/pfusers.php?action=get&item=username&id='.trim($_SESSION['userid']));
		
			$_SESSION['username'] = trim($getUser);
			$getUser = file_get_contents ('https://www.wevolt.com/processing/pfusers.php?action=get&item=avatar&id='.trim($_SESSION['userid']));
			$_SESSION['avatar'] = $getUser;
			setcookie("userid", $_SESSION['userid'], time()+60*60*24*100, "/", 'wevolt.com');
			     $query = "SELECT ShowWelcome from users_settings where UserID='".trim($logresult)."'";
				 $ShowWelcome = $InitDB->queryUniqueValue($query);
				$_SESSION['showelcome'] =  $ShowWelcome;
			   if ($Ref != 'http://www.wevolt.com/') {
			   		$redirect = $Ref;
			   } else {	
					if (($ShowWelcome == 1) || ($ShowWelcome == '')) {	
						$redirect = 'http://www.wevolt.com/welcome.php';
					}else	{
						$redirect = 'http://users.wevolt.com/myvolt/' . trim($_SESSION['username']) . '/';
					} 
					
			   }
     } else if (trim($logresult) == 'Not Verified'){  
	  		$redirect = 'http://www.wevolt.com/login.php?error=not_verified';
     } else if ($logresult == 'Not Logged'){  
	   			
					$redirect = 'http://www.wevolt.com/login.php?error=not_logged';
			
     } else {
     	$redirect = 'http://www.wevolt.com/login.php';
	 }
	
}
?>

<style type="text/css">
body,html {
margin:0px;
padding:0px;
}

</style>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<div style="background-image:url(http://www.wevolt.com/images/login_bg.jpg); width:314px; height:396px; padding:3px;" class="messageinfo_white">
<div style="padding:10px;" class="messageinfo_warning">
<div class="spacer"></div><div style="height:50px;"></div>
<?  if (trim($logresult) == 'Not Verified'){  ?>
Sorry we could not log you in because your account has not been verified.
<? } else if ($logresult == 'Not Logged'){  ?>
There was an error, please try again. 
<? } else {?>
You are now logged in, if this window hasn't closed you can close it manually or just refresh your page. 
<? }?>
</div>
</div>
<?php if ($redirect != '') { ?>

<script>
parent.window.location.href = '<?php echo $redirect; ?>';
</script>

<?php }  ?>