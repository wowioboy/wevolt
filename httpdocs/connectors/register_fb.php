<?php 
include_once( $_SERVER['DOCUMENT_ROOT'].'/includes/init.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/facebook_config.php');
require_once ($_SERVER['DOCUMENT_ROOT'].'/facebook-platform/php/facebook.php');

global $api_key,$secret;
$fb=new Facebook($api_key,$secret);
$fb_user=$fb->get_loggedin_user();
function generatePassword ($length = 8)
{

  // start with a blank password
  $NewPass = "";

  // define possible characters
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($NewPass, $char)) { 
      $NewPass .= $char;
      $i++;
    }

  }
  return $NewPass;

}

function generate_salt ()
{
     // Declare $salt
     $salt = '';

     // And create it with random chars
     for ($i = 0; $i < 3; $i++)
     {
          $salt .= chr(rand(35, 126));
     }
          return $salt;
}

?>
<style type="text/css">
body,html {
margin:0px;
padding:0px;
}

</style>
 <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<div style="background-image:url(http://www.wevolt.com/images/login_bg.jpg); width:314px; height:396px; padding:3px;">
</div>
<?
flush();
if ($_POST['register'] == 1){
	srand();
	$query = "SELECT count(*) FROM users where email='".$_POST['regemail']."'";
	$Found = $InitDB->queryUniqueValue($query);

	if ($Found > 0)
		$RegResult = 'Email Exists';
	else
		$RegResult = 'Clear';

	$Username = str_replace(" ", "_", trim($_POST['username']));
	$Username = str_replace("'", "", $Username);
	$Username = str_replace('"', "", $Username);
	$Username = str_replace("/", "", $Username);
	$Username = str_replace("&", "", $Username);
	
	if ($RegResult == 'Clear') {
		$query = "SELECT count(*) FROM users where lower(username)='".mysql_real_escape_string(trim(strtolower($Username)))."'";
		$Found = $InitDB->queryUniqueValue($query);
		if ($Found > 0)
			$RegResult = 'User Exists';
		else
			$RegResult = 'Clear';
	}
	
	if ($RegResult == 'Clear') {
			$UsersDirectory = $_SERVER['DOCUMENT_ROOT'].'/users/';
		
			if(!is_dir($UsersDirectory. $Username)) { 
				@mkdir($UsersDirectory.$Username); chmod($UsersDirectory.$Username, 0777); 
			}

			if(!is_dir($UsersDirectory.$Username."/avatars")) { 
				@mkdir($UsersDirectory.$Username."/avatars"); chmod($UsersDirectory.$Username."/avatars", 0777); 
				@mkdir($UsersDirectory.$Username."/pdfs"); chmod($UsersDirectory.$Username."/pdfs", 0777); 
			}
			copy ($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.$Username."/avatars/index.html");
			copy ($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.$Username."/index.html");
			copy ($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.$Username."/pdfs/index.html");
			$time = date('Y-m-d H:i:s'); 
			$Avatar = $_POST['avatar'];
			$gif = file_get_contents($Avatar);
			$LocalAvatar = $UsersDirectory.$Username.'/avatars/'.$Username.'_'.date('Y-m-d-H-i-s').'.jpg';
			$fp  = fopen($LocalAvatar, 'w+') or die('Could not create the file');
			fputs($fp, $gif) or die('Could not write to the file');
			fclose($fp);
			chmod($LocalAvatar,0777);
			$Avatar = 'http://www.wevolt.com/users/'.$Username.'/avatars/'.$Username.'_'.date('Y-m-d-H-i-s').'.jpg';
			
   			$salt = generate_salt();
			$salt = str_replace("'", "!", $salt);
			if ($_POST['password'] == ''){
					$password = generatePassword(8);
			} else {
				
				$password = $_POST['password'];
			}
     		$encrypted = md5(md5($password).$salt);
     		$query = "INSERT into users (username, email, password, salt, avatar, joindate, verified,FaceID) values ('".mysql_real_escape_string($Username)."', '".$_POST['regemail']."', '$encrypted', '$salt', '$Avatar','$time',1,'$fb_user')";
			$InitDB->execute($query);
			
			$query = "SELECT userid FROM users WHERE username='".mysql_real_escape_string($Username)."' and email ='".$_POST['regemail']."'";
	 	  	$ID = $InitDB->queryUniqueValue($query);
	  		$Encryptid = substr(md5($ID), 0, 12).dechex($ID);
			$UserClear = 0;
			while ($UserClear == 0) {
					$query = "SELECT count(*) from users where encryptid='$Encryptid'";
					$Found = $InitDB->queryUniqueValue($query);
					if ($Found == 1) {
						$Encryptid = substr(md5(($ID+5)), 0, 12).dechex($ID+5);
					} else {
						$query = "UPDATE users SET encryptid='$Encryptid' WHERE userid='$ID'";
						$InitDB->execute($query);
						$UserClear = 1;
						$UserID = $Encryptid;
					}
			}
	 		
			$query = "INSERT into users_settings (UserID) values ('$Encryptid')";
			$InitDB->execute($query);
			
			$header = "From: NO-REPLY@wevolt.com  <NO-REPLY@wevolt.com >\n";
			$header .= "Reply-To: NO-REPLY@wevolt.com <NO-REPLY@wevolt.com>\n";
			$header .= "X-Mailer: PHP/" . phpversion() . "\n";
			$header .= "X-Priority: 1";
			
		//Send Account Email
			$to = $email;
			$subject = "Your new WEvolt User Account";
			$body = "Hi, ".$Username.", thank you for registering with WEvolt. We hope you enjoy your experience.\n\nFor your records your login information is as follows, you will use your EMAIL ACCOUNT to login in.\r\nUSERNAME: ".$Username."\r\nEMAIL: ".$_POST['regemail']."\r\nPASSWORD: ".$password."\r\nIf you have any questions feel free to contact us at : info@wevolt.com \r\nCheers! \r\nThe WEvolt Team";
			$body .= "\r\n---------------------------\n";
			 mail($to, $subject, $body, $header);
		
			$to = 'info@wevolt.com';
			$copy = 'theunlisted@gmail.com';
			$subject = "A new user has registered for an account";
			$body = "Hi, ".$Username.", at ".$_POST['regemail']." has registered for a new account";
			$body .= "\r\n---------------------------\n";
			mail($to, $subject, $body, $header);
			mail($copy, $subject, $body, $header);
	}

}


if ($RegResult == 'Clear') { ?>
<script type="text/javascript">
document.location.href='http://www.wevolt.com/connectors/login_auth_frame.php?e=<? echo $UserID;?>&r=<? echo urlencode($_POST['refurl']);?>&f=iframe';
</script>
<? } else {
if ($RegResult == 'Email Exists')
	$queryString = '&u='.trim($_POST['username']).'&a=reg';
else if ($RegResult == 'User Exists')
	$queryString = '&e='.$_POST['regemail'].'&a=reg';

?>
<script type="text/javascript">
document.location.href='http://www.wevolt.com/connectors/facebook_auth.php?error=<? echo urlencode($RegResult);?><? echo $queryString;?>&r=<? echo urlencode($_POST['refurl']);?>&f=iframe';
</script>
<? } ?>
