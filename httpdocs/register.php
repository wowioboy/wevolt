<?php 
include 'includes/init.php';
$PageTitle = 'register';
$TrackPage = 1;
$Finished = 0;
if ($_GET['a'] == 'pro') 
	$_SESSION['IsPro'] = 1; 
include 'includes/header_template_new.php';
$Site->drawModuleCSS();
     
?>

<? if (($_GET['r'] == 'success')&& ($_GET['a'] == 'pro')) {
	$query = "SELECT * from pf_subscriptions where UserID='".$_SESSION['userid']."' and (SubscriptionType ='hosted' or SubscriptionType ='fan')";
	$SubArray = $InitDB->queryUniqueObject($query);
	if ($SubArray->ID != '') {
			$SubType = $SubArray->SubscriptionType;
			$UserID = $SubArray->UserID;
			$query = "SELECT * from users where encryptid='$UserID'";
			$UserArray = $InitDB->queryUniqueObject($query);
		
			//$query = "UPDATE pf_subscriptions set Status='active' where ID='".$SubArray->ID."'";
			//$InitDB->execute($query);
			
			//$query = "UPDATE users set HostedAccount='1' where encryptid='".$_SESSION['userid']."'";
			//$InitDB->execute($query);
			//$ShowShares = 0;
		
			$query = "SELECT count(*) from subscription_shares where user_id='".$_SESSION['userid']."'";
			$Found = $InitDB->queryUniqueValue($query);
			$ShowShares = 1;
			
			
			
			
			/*
			$to = $_SESSION['email'];
			$SellerEmail = 'info@wevolt.com';
			
			$header = "From: NO-REPLY@wevolt.com  <NO-REPLY@wevolt.com >\n";
			$header .= "Reply-To: NO-REPLY@wevolt.com <NO-REPLY@wevolt.com>\n";
			$header .= "X-Mailer: PHP/" . phpversion() . "\n";
			$header .= "X-Priority: 1";
				
			$subject = "Your Pro Subscription is now active!";
			$SellerSubject ="A ".$SubType." subscription has processed";
			$Sellerbody = "A user has paid for a hosted subscription at WEvolt. No further action is needed.";
			$body = "Your Pro WEvolt subscription is now active. \n\nAny questions or concerns, you can send an email to: info@wevolt.com.";
			
			$Server = substr($_SERVER['SERVER_NAME'],4,strlen($_SERVER['SERVER_NAME'])-1);
			mail($to, $subject, $body, $header);
			mail($SellerEmail, $SellerSubject, $Sellerbody, $header); 
			include_once($_SERVER['DOCUMENT_ROOT'].'/models/Users.php');
			$XPMaker = new Users();
			$XPMaker->addxp($InitDB, $_SESSION['userid'], 2600);
			$query = "INSERT into suprise_codes_redeem (Code, UserID) values ('register_2600', '$UserID')"; 
			$InitDB->execute($query);	*/
		}
	
?>

<div align="left">
<table cellpadding="0" cellspacing="0" border="0"><tr>
<td valign="top" style="padding:5px; color:#FFFFFF;width:60px;"><? include 'includes/site_menu_popup_inc.php';?></td>
<td valign="top" align="center" background="http://www.wevolt.com/images/pro_signup_success.png" style="width:959px; height:768px; background-repeat:no-repeat; background-position:top left; padding-left:110px;">
<div style="height:400px;"></div>
<? if ($ShowShares == 1) {?>
<iframe src="/connectors/subscription_share.php" scrolling="no" allowtransparency="true" frameborder="no" style="width:800px; height:500px;" /></iframe>

<? }?>
</td>
</tr></table>

<? } else {?>
<div align="left">

<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <? if ($_SESSION['IsPro'] == 1) {
           $_SESSION['noads'] = 1;
		?>
    <td valign="top" style="padding:5px; color:#FFFFFF;width:60px;"><? include 'includes/site_menu_popup_inc.php';?></td>
    <? } else {?>
    <td width="<? echo $SideMenuWidth;?>" valign="top"><? include 'includes/site_menu_inc.php';?></td>
    <? }?>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding-left:10px;">
<?php 

if ($_POST['register'] == 1){
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
	if ($_POST['password'] != $_POST['confirmpass']) {
		$Error = 'Your Passwords do not match';
	} else if (($_POST['overage'] == '') || ((strtolower($_POST['overage']) != 'y') && (strtolower($_POST['overage']) != 'n'))) {
		$Error = 'Please enter a "Y" or "N" for Over 16';
	} else if ((strtolower($_POST['overage']) == 'y') && ($_POST['bdate'] == '')) {
		$Error = 'Please enter your Birthdate.';
	}else if (strtolower($_POST['overage']) == 'y') {
			$BDateArray = explode('-',$_POST['bdate']);
			if (strlen($_POST['bdate']) < 10)
				$Error = 'Please enter a Valid Birthdate (ex: 12-01-1980)';
			else if ((strlen($BDateArray[0]) < 2) || ((intval($BDateArray[0]) < 1) || (intval($BDateArray[0]) > 12)))
				$Error = 'Please enter a Valid Month for your Birthdate (ex: 12-01-1980)';
			else if ((strlen($BDateArray[1]) < 2) || ((intval($BDateArray[1]) < 1) || (intval($BDateArray[1]) > 31)))
				$Error = 'Please enter a Valid Day for your Birthdate (ex: 12-01-1980)';
			else if ((strlen($BDateArray[2]) < 4) || ((intval($BDateArray[2]) < 1930) || (intval($BDateArray[2]) > (intval(date('Y'))-7))))
				$Error = 'Please enter a Valid year for your Birthdate (ex: 12-01-1980)';
			else if (($_POST['authorizedate'] == '') || (strtolower($_POST['authorizedate']) == 'n')) 
				$Error = 'You must authorize WEvolt to use your entered date as your legal age.';
	} 
	if ($Error == '') {
		srand();
		$query = "SELECT count(*) FROM users where email='".$_POST['regemail']."'";
		$EmailExists = $InitDB->queryUniqueValue($query);
	
		if ($EmailExists > 0)
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
			$UserExists = $InitDB->queryUniqueValue($query);
			if ($UserExists > 0)
				$RegResult = 'User Exists';
			else
				$RegResult = 'Clear';
		}
		
		if ($RegResult == 'Clear') {
				$UsersDirectory = $_SERVER['DOCUMENT_ROOT'].'/users/';
				//$SubUsersDirectory = '/var/www/vhosts/wevolt.com/subdomains/users/httpdocs/users/';
								
				if(!is_dir($UsersDirectory. $Username)) { 
					@mkdir($UsersDirectory.$Username); chmod($UsersDirectory.$Username, 0777); 
				}
				//if(!is_dir($SubUsersDirectory. $Username)) { 
					//@mkdir($SubUsersDirectory.$Username); chmod($SubUsersDirectory.$Username, 0777); 
				//}
				
				
				if(!is_dir($UsersDirectory.$Username."/avatars")) { 
					@mkdir($UsersDirectory.$Username."/avatars"); chmod($UsersDirectory.$Username."/avatars", 0777); 
					@mkdir($UsersDirectory.$Username."/pdfs"); chmod($UsersDirectory.$Username."/pdfs", 0777); 
					@mkdir($UsersDirectory.$Username."/media"); chmod($UsersDirectory.$Username."/media", 0777); 
				}
				
			//	if(!is_dir($SubUsersDirectory.$Username."/avatars")) { 
				//	@mkdir($SubUsersDirectory.$Username."/avatars"); chmod($SubUsersDirectory.$Username."/avatars", 0777); 
				//	@mkdir($SubUsersDirectory.$Username."/pdfs"); chmod($SubUsersDirectory.$Username."/pdfs", 0777); 
				//}
				
				
				copy ($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.$Username."/avatars/index.html");
				copy ($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.$Username."/index.html");
				copy ($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.$Username."/pdfs/index.html");
				
				$time = date('Y-m-d H:i:s'); 
				if (trim(strtolower($_GET['gender'])) == 'm')
					$Avatar = 'tempavatar.jpg';
				else if (trim(strtolower($_GET['gender'])) == 'f')
					$Avatar = 'tempavatarF.jpg';
				else 
					$Avatar = 'tempavatar.jpg';
				$gif = file_get_contents('http://www.wevolt.com/images/'.$Avatar);
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
				$chars = "abcdefghijkmnopqrstuvwxyz023456789ABCDEFGHIJKLMNOPQRSTUV";
    			srand((double)microtime()*1000000);
    			$i = 0;
				$authode = '' ;
				while ($i <= 11) {
        				$num = rand() % 33;
       					$tmp = substr($chars, $num, 1);
       					 $authode = $authode . $tmp;
        				$i++;
				}
				
				$encrypted = md5(md5($password).$salt);
				$query = "INSERT into users (username, email, password, salt, avatar, joindate, verified,realname,overage,gender,birthdate,authcode) values ('".mysql_real_escape_string($Username)."', '".$_POST['regemail']."', '$encrypted', '$salt', '$Avatar','$time',0,'".mysql_real_escape_string($_POST['realname'])."','".strtolower($_POST['overage'])."','".strtolower($_POST['gender'])."','".strtolower($_POST['bdate'])."','".trim($authode)."')";
				$InitDB->execute($query);
				 
				$query = "SELECT userid FROM users WHERE username='".mysql_real_escape_string($Username)."' and email ='".$_POST['regemail']."'";
				$ID = $InitDB->queryUniqueValue($query);
				$Encryptid = substr(md5($ID), 0,12).dechex($ID);
				$UserClear = 0;
				$Inc = 5;
				while ($UserClear == 0) {
						$query = "SELECT count(*) from users where encryptid='$Encryptid'";
						$Found = $InitDB->queryUniqueValue($query);
						if ($Found == 1) {
							$Encryptid = substr(md5(($ID+$Inc)), 0, 12).dechex($ID+$Inc);
						} else {
							$query = "UPDATE users SET encryptid='$Encryptid' WHERE userid='$ID'";
							$InitDB->execute($query);
							$UserClear = 1;
							$UserID = $Encryptid;
						}
						$Inc++;
				}
	 		
				$query = "INSERT into users_settings (UserID) values ('$Encryptid')";
				$InitDB->execute($query);
				
				$copy = 'theunlisted@gmail.com';
				$to = $_POST['regemail'];
				
				$header = "From: NO-REPLY@wevolt.com  <NO-REPLY@wevolt.com >\n";
				$header .= "Reply-To: NO-REPLY@wevolt.com <NO-REPLY@wevolt.com>\n";
				$header .= "X-Mailer: PHP/" . phpversion() . "\n";
				$header .= "X-Priority: 1";
				
			   //Send Account Email			
				$subject = "Your new WEvolt User Account";
				$body = "Hi, ".$Username.", thank you for registering with WEvolt. We hope you enjoy your experience.\r\nFor your records your login information is as follows, you will use your EMAIL ACCOUNT to login in.\r\nUSERNAME: ".$Username."\r\nEMAIL: ".$_POST['regemail']."\r\nPASSWORD: ".$password."\r\nIf you have any questions feel free to contact us at : listenup@wevolt.com \r\nCheers! \r\nThe WEvolt Team";
				$body .= "\r\n---------------------------\r\n";
				//SEND USER EMAIL
				 mail($to, $subject, $body, $header);
				 //SEND COPY
				 mail($copy, $subject, $body, $header);
				
				//Send Verification Email
				$subject = "WEvolt Account Verification";
				$body = "Hi, ".$Username.", please click the following link to complete your account verification.\r\nAfter your account is verified you can create create projects, blogs, WE pages and more. \r\nVERIFICATION LINK : http://www.wevolt.com/verifyaccount.php?id=".$Encryptid."&authcode=".trim($authode)."\r\nIf clicking on the link does not work, copy the link and paste it into your browser. \r\nCheers! \r\nThe WEvolt Team";
				$body .= "\r\n---------------------------\r\n";
				 mail($to, $subject, $body, $header);
				 mail($copy, $subject, $body, $header);
				 
				//SEND NOTICE EMAIL
				$subject = "A new user has registered for an account";
				$body = "Hi, ".$Username.", at ".$_POST['regemail']." has registered for a new account";
				$body .= "\r\n---------------------------\r\n";
				mail($copy, $subject, $body, $header);
				$Finished = 1;
		}
	}
}
?>


<center>
 <? if ($Finished == 1) {?>
        
                                    <img src="http://www.wevolt.com/images/registration_confirmation_header.png" /><br />
        <div style="background-image: url(images/registration_toon.png); background-repeat:no-repeat; height:624px;width:627px; background-position:bottom center" align="center" class="messageinfo_white"> <div class="spacer"></div>
        <strong>Welcome to WEvolt, <span class="messageinfo_warning"><? echo $Username;?>!</span></strong>
         <div class="spacer"></div>
        Thank you for registering on WEvolt.<br />
        
        Two emails have been sent to: <span class="messageinfo_warning"><? echo $_POST['regemail'];?></span>
         <div class="spacer"></div>
        One has all your WEvolt information, which<br />
        
        you should keep in your records.<br />
        
         <div class="spacer"></div>
        The other has the final instructions on<br />
        
        how to verify your account.  <div class="spacer"></div><Go check that
        
        email now to get started.<br />
        
                            </div>
                                      
<? } else {?>

		<? if ($_GET['a'] != 'pro') {?>
                <img src="http://www.wevolt.com/images/registration_header.png" />
                <div class="messageinfo_warning">
                <div class="spacer"></div><div class="spacer"></div>
                Please fill out all the YELLOW fields:
                <div class="spacer"></div>
                <? if ($EmailExists > 0) {?>
                    <div class="spacer"></div>
                    <div class="messageinfo_warning">Sorry that Email is already registered for an account. </div><div class="spacer"></div>
                    <div class="messageinfo_white" style="width:500px;">
                    If you need to reset your password you can go here <a href="http://www.wevolt.com/forgot.php">CHANGE PASSWORD</a></<br /><br />
                    
                    Or if you have already signed up for an invite please wait until you recieve your verificiation email to begin using your account. Please add accounts@wevolt.com as a truested source in your email program so it doesn't land in your junk folder. <br />
                    <br />
                    If you need to have you verification email sent again, visit this link: <a href="http://www.wevolt.com/forgot.php">RESEND VERIFICATION EMAIL</a></div>
                    
                    <div class="spacer"></div><div class="spacer"></div>
                
                <? } else if ($UserExists > 0) {?>
                    <div class="spacer"></div>
                    <div class="messageinfo_warning">Sorry that username is already taken. </div>
                    <div class="messageinfo_white" style="width:500px;">
                    Please select a new one and resubmit the form.
                    </div>
                    <div class="spacer"></div><div class="spacer"></div>
                
                <? } else if ($Error != '') {?>
                    <div class="spacer"></div>
                    <div class="messageinfo_warning"><? echo $Error;?></div>
                    <div class="spacer"></div>
                <? }?>
        
                </div>
                <form method="post" action="#">
                <? $Site->drawStandardModuleTop('<div style="height:5px;"></div><img src="http://www.wevolt.com/images/send_me_invite.png" />', 500, '', 12,'');?>
                <div style="padding:10px;">
        
                <table width="75%"><tr><td class="messageinfo" width="125" align="right"  style="font-size:14px;"><strong>Username:</strong></td><td style="padding:3px;" align="left">
                <input type="text" size="28" maxlength="50" name="username"
                <?php if ((isset($_POST['username'])) && (($UserExists ==0) ||($UserExists =='')))  { ?> value="<?php echo $_POST['username']; ?>" <?php } ?>/ style="background-color:#feeb7f; color:#000000;"></td>
                </tr>
                <tr><td class="messageinfo" width="125" align="right"  style="font-size:14px;"><strong>Real Name:</strong></td><td style="padding:3px;" align="left">
                <input type="text" size="28" maxlength="50" name="realname"
                <?php if (isset($_POST['realname'])) { ?> value="<?php echo $_POST['realname']; ?>" <?php } ?>/></td>
                </tr>
                <tr><td class="messageinfo" width="125" align="right"  style="font-size:14px;"><strong>Email:</strong></td><td style="padding:3px;" align="left">
                <input type="text" size="28" maxlength="50" name="regemail"
                <?php if ((isset($_POST['regemail'])) && (($EmailExists ==0) ||($EmailExists ==''))) { ?> value="<?php echo $_POST['regemail']; ?>" <?php } ?> style="background-color:#feeb7f; color:#000000;"/> </td>
                </tr>
                <tr>
                <td class="messageinfo" width="125" align="right" style="font-size:14px;"><strong>Password:</strong></td><td style="padding:3px;" align="left">
                <input type="password" size="20" maxlength="15" name="password" style="background-color:#feeb7f; color:#000000;"/></td></tr>
                <tr>
                <td class="messageinfo" width="125" align="right" style="font-size:14px;"><strong>Confirm:</strong></td><td style="padding:3px;" align="left">
                <input type="password" size="20" maxlength="15" name="confirmpass" style="background-color:#feeb7f; color:#000000;"/></td></tr>
                <tr>
                <td class="messageinfo" width="125" align="right" style="font-size:14px;"><strong>OVER 18?</strong></td><td style="padding:3px;" align="left">
                <input type="text" size="2" maxlength="1" name="overage" value="<?php if (isset($_POST['overage'])) echo $_POST['overage'];?>" style="background-color:#feeb7f; color:#000000;"/> (Y/N)</td></tr>
                <tr>
                <td class="messageinfo" width="125" align="right" style="font-size:14px;" colspan="2">If "Y" enter your birthdate:</td></tr>
                <tr>
                <td class="messageinfo" width="125" align="right" style="font-size:14px;"></td><td style="padding:3px;" align="left">
                <input type="text" size="8" maxlength="10" name="bdate" value="<?php if (isset($_POST['bdate'])) echo $_POST['bdate'];?>" /> (MM-DD-YYYY)</td></tr>
                 <tr>
                <td class="messageinfo" width="125" align="right" style="font-size:12px;">I authorize WEvolt to use this date of birth to enable me to view age-resitricted content</td><td style="padding:3px;" align="left">
                <input type="text" size="2" maxlength="1" name="authorizedate" value="<?php if (isset($_POST['authorizedate'])) echo $_POST['authorizedate'];?>" /> (Y/N)</td></tr>
                <tr>
                <td class="messageinfo" width="125" align="right" style="font-size:14px;"><strong>GENDER:</strong></td><td style="padding:3px;" align="left">
                <input type="text" size="2" maxlength="1" name="gender" value="<?php if (isset($_POST['gender'])) echo $_POST['gender'];?>" /> (M/F)</td></tr>
                </table>
                
                </div>
                  <? $Site->drawStandardModuleFooter();?>
                  <div class="spacer"></div>
                  <input type="hidden" name="register" value="1" />
                  <input type="image"  src="http://www.wevolt.com/images/register_btn_off.png" style="border:none; background:none;">
                  </form>
        <? } else {?>
        		
   <div align="left">
                <script type="text/javascript">
			   function start_subscription(type,sid) {
				   if (type == 'fan') {
					   document.getElementById("type").value = 'fan';
					   document.getElementById("SubType").value = sid;
				   } else if (type == 'pro') {
						document.getElementById("type").value = 'hosted';
						document.getElementById("SubType").value = sid;      
				   }
				   document.subform.submit();
			   }
			   
			   
			   </script> 
                 <? 
				 if (($_GET['page'] == '') || ($_GET['page'] == '1')){?>
                              <img src="http://www.wevolt.com/images/pro_tour_1.png" />
                    
                          <? }else if ($_GET['page'] == 2){?>
                              <img src="http://www.wevolt.com/images/pro_tour_2.jpg" />
                    
                          <? }else if ($_GET['page'] == 3){?>
                              <img src="http://www.wevolt.com/images/pro_tour_3.jpg" />
                     <div style="height:100px;"></div>
                           <? }else if ($_GET['page'] == 4){?>
                              <img src="http://www.wevolt.com/images/pro_tour_4.png" />
                     <div style="height:50px;"></div>
                           <? }else if ($_GET['page'] == 5){?>
                           
                              <img src="http://www.wevolt.com/images/pro_tour_5.png" />
                     <div style="height:100px;"></div>
                           <? }else if ($_GET['page'] == 6){?>
                              <img src="http://www.wevolt.com/images/pro_tour_6.png" />
                              <div style="height:200px;"></div>
                    
                           <? }else if ($_GET['page'] == 7){?>
                              <img src="http://www.wevolt.com/images/pro_tour_7.png" />
                      <div style="height:150px;"></div>
                          <? }else if (($_GET['page'] == 8) || ($_GET['page'] =='wowio')){
							  $query = "SELECT * from pf_subscriptions where UserID='".$_SESSION['userid']."' and SubscriptionType ='hosted' and Status='active'";
									$SubArray = $InitDB->queryUniqueObject($query);
									if ($SubArray->ID != '') { ?>
									<div class="messageinfo_warning">
									<div class="spacer"></div><div class="spacer"></div>
											Says here that you've already got a pro account, so no reason to get another one!<div class="spacer"></div><div class="spacer"></div> If you're looking for a way to cancel the subscription, look for the link in your <a href="http://users.wevolt.com/myvolt/<? echo $_SESSION['username'];?>/">MYvolt</a> settings under Subscriptions. 
											</div>
											<div style="height:600px;"></div>
									<? } else {?>
											  
								  <? if ($_GET['page'] == 'wowio') {?>
                                  <img src="http://www.wevolt.com/images/wowio_offer.png" border="0" usemap="#subMap">
<map name="subMap" id="subMap">
  <area shape="rect" coords="273,459,346,493" href="javascript:void(0)" onclick="pro_stuff();">
  <area shape="rect" coords="578,327,767,366" href="javascript:void(0)" onclick="start_subscription('pro','7');">
  <area shape="rect" coords="577,371,765,404" href="javascript:void(0)" onclick="start_subscription('pro','8');">
  <area shape="rect" coords="577,410,765,445" href="javascript:void(0)" onclick="start_subscription('pro','9');">
</map>
                                  
                                  
                                  <? } else {?>
												  <img src="http://www.wevolt.com/images/pro_tour_8.png" border="0" usemap="#subMap" />
					<map name="subMap" id="subMap">
					 <area shape="rect" coords="191,334,353,370" href="javascript:void(0);" onclick="start_subscription('fan','1');">
					  <area shape="rect" coords="190,377,353,411" href="javascript:void(0);" onclick="start_subscription('fan','2');">
					  <area shape="rect" coords="190,416,353,453" href="javascript:void(0);" onclick="start_subscription('fan','3');">
					  <area shape="rect" coords="590,333,779,372" href="javascript:void(0);" onclick="start_subscription('pro','4');">
					  <area shape="rect" coords="591,378,779,411" href="javascript:void(0);" onclick="start_subscription('pro','5');">
					  <area shape="rect" coords="592,418,780,453" href="javascript:void(0);" onclick="start_subscription('pro','6');">
					  
					  <area shape="rect" coords="217,395,455,497"   />
					  <area shape="rect" coords="594,414,856,479" href="javascript:void(0);" onclick="start_subscription('pro');" />
					</map>
											  
                        <form action="/process_store.php" method="post" id="subform" name="subform">
                        <input type="hidden" name="type" id="type" value="">
                        <input type="hidden" name="start" value="1">
                        <input type="hidden" name="txtSubType" id="SubType" value="">
                        </form>
                        <? }?>
                    <? }?>
                         <? }?>
                         <div align="left">
                         <table width="900"><tr><td width="25%" align="right">
                       <? if (($_GET['page'] != '1') && ($_GET['page'] != '')){?><a href="http://www.wevolt.com/register.php?a=pro&page=<? if ($_GET['page'] == '2') echo '1'; else if ($_GET['page'] == '3') echo '2'; else if ($_GET['page']=='4') echo '3';else if ($_GET['page']=='5') echo '4';else if ($_GET['page']=='6') echo '5';else if ($_GET['page']=='7') echo '6';else if ($_GET['page']=='8') echo '7';?>"><img src="http://www.wevolt.com/images/tut_prev.png" border="0"/></a><? }?>
                       </td><td width="50%" align="center">
                        <? if (($_GET['page'] == '1') || ($_GET['page'] == '')){?>
                        <img src="http://www.wevolt.com/images/tut_1.png" />
                        <? } else if ($_GET['page']== '2'){?>
                        <img src="http://www.wevolt.com/images/tut_2_footer.png" vspace="40"/>
                        <? } else if ($_GET['page']== '3'){?>
                        <img src="http://www.wevolt.com/images/tut_3_footer.png" vspace="40" />
                        <? } else if ($_GET['page']== '4'){?>
                        <img src="http://www.wevolt.com/images/tut_4_footer.png" vspace="40" />
                        <? } else if ($_GET['page']== '5'){?>
                        <img src="http://www.wevolt.com/images/tut_5_footer.png" vspace="40"/>
                         <? } else if ($_GET['page']== '6'){?>
                         <img src="http://www.wevolt.com/images/tut_6_footer.png" vspace="40" />
                        <? } else if ($_GET['page']== '7'){?>
                         <img src="http://www.wevolt.com/images/tut_7_footer.png" vspace="40" />
                        <? } else if ($_GET['page']== '8'){?>
                         <img src="http://www.wevolt.com/images/tut_8_footer.png" vspace="40"/>
                        <? }?>
                       </td>
                       <td width="25%" align="left">
                       <? if (($_GET['page'] != '8') && ($_GET['page'] != 'wowio') ){?><a href="http://www.wevolt.com/register.php?a=pro&page=<? if (($_GET['page'] == '1') || ($_GET['page'] == '')) echo '2'; else if ($_GET['page'] == '2') echo '3'; else if ($_GET['page']=='3') echo '4';else if ($_GET['page']=='4') echo '5';else if ($_GET['page']=='5') echo '6';else if ($_GET['page']=='6') echo '7';else if ($_GET['page']=='7') echo '8';?>"><img src="http://www.wevolt.com/images/tut_next.png" border="0"/></a><? }?>
                       </td></tr></table>
                        <div class="spacer"></div>
               			 </div>
            
                </div>
        <? }?>

  <? }?>                           

 </div></td>
  </tr>
</table>
</div>
<? }
?>
<?php include 'includes/footer_template_new.php';?>
