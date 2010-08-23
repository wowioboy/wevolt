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
					$query = "select salt from $usertable where email='$email' limit 1";
					$salt = $InitDB->queryUniqueValue($query);
					$encrypted_pass = md5(md5($password).$salt);
					$query = "select encryptid, username, email, avatar, realname, verified from users where email='$email' and password='$encrypted_pass'";
					$user = $InitDB->queryUniqueValue($query);
				    $userid = $user->encryptid;
					$useremail = $user->email;
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
						print $query;
						$useremail = $user->email;
						if ($useremail != '') {
							if ($user->verified == 1)
								$logresult = trim($UserID);
							else 
								$logresult = 'Not Verified';
						} else {
						     $logresult = 'Not Logged';
						}
					print $logresult;
	}
     if ((trim($logresult) != 'Not Logged') && (trim($logresult) != 'Not Verified')) {
	 		$NOW = date('Y-m-d h:m:s');
			$query = "UPDATE users set LastLogin = '$NOW' where encryptid='".trim($logresult)."'";
			$InitDB->execute($query);
			 $_SESSION['userid'] = trim($logresult);
			 $Useremail = $_POST['email']; 
			 $_SESSION['email'] = $Useremail;
			 $_SESSION['lastlogin'] = $NOW;
			 $_SESSION['encrypted_email'] =  md5($Useremail);
				
			$getUser = file_get_contents ('https://www.wevolt.com/processing/pfusers.php?action=get&item=username&id='.trim($_SESSION['userid']));
		
			$_SESSION['username'] = trim($getUser);
			$getUser = file_get_contents ('https://www.wevolt.com/processing/pfusers.php?action=get&item=avatar&id='.trim($_SESSION['userid']));
			$_SESSION['avatar'] = $getUser;
			//   if($_POST['txtRemember'] == 1){
					setcookie("cookmail", $_SESSION['email'], time()+60*60*24*100, "/");
					setcookie("cookname", $_SESSION['username'], time()+60*60*24*100, "/");
					setcookie("cookpass", md5($Pass), time()+60*60*24*100, "/");
					setcookie("cryptmail", $_SESSION['email'], time()+60*60*24*100, "/");
				//}
		
				 session_write_close();
			     $query = "SELECT ShowWelcome from users_settings where UserID='".trim($logresult)."'";
				 $ShowWelcome = $InitDB->queryUniqueValue($query);
					
			   if ($Ref != 'http://www.wevolt.com/') {
						
						if ($From == 'iframe'){
						?>
						<script type="text/javascript">
							parent.window.location.href='<? echo $Ref;?>';
						</script>
						<? } else {
							header("Location:".$Ref);
						}   	
			   } else {	
					if (($ShowWelcome == 1) || ($ShowWelcome == '')) {	
						if ($From == 'iframe'){
						?>
						<script type="text/javascript">
							parent.window.location.href='http://users.wevolt.com/welcome.php';
						</script>
						<? } else {
						header("Location:http://users.wevolt.com/welcome.php"); 
						}
						
					}else	{
						if ($From == 'iframe'){
						?>
						<script type="text/javascript">
							parent.window.location.href='http://users.wevolt.com/myvolt/<? echo trim($_SESSION['username']);?>/';
						</script>
						<? } else {
							header("Location:http://users.wevolt.com/myvolt/".trim($_SESSION['username'])."/");
						}
						
					} 
					
			   }
				exit();  
     } else if (trim($logresult) == 'Not Verified'){  
	  			if ($From == 'iframe'){
				?>
                <script type="text/javascript">
					//parent.window.location.href='http://www.wevolt.com/login.php';
				</script>
                <? } else {
					//header("Location:http://www.wevolt.com/login.php");
				}
		
     } else if ($logresult == 'Not Logged'){  
	   			if ($fb_user != '') {
					if ($From == 'iframe'){
					?>
					<script type="text/javascript">
					window.location.href='http://www.wevolt.com/connectors/login_form_fb.php';
					</script>
					<? } else {
						header("Location:http://www.wevolt.com/connectors/login_form_fb.php");
					}
				} else {
					if ($From == 'iframe'){
					?>
					<script type="text/javascript">
					parent.window.location.href='http://www.wevolt.com/login.php';
					</script>
					<? } else {
						header("Location:http://www.wevolt.com/login.php");
					}
				}
     } else {
				if ($From == 'iframe'){
				?>
                <script type="text/javascript">
					parent.window.location.href='http://www.wevolt.com/login.php';
				</script>
                <? } else {
					header("Location:http://www.wevolt.com/login.php");
					}
	 }
}

//print 'User Login = ' . $_SESSION['userid'];
?>
