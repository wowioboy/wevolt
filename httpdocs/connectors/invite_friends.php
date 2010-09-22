<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';

$CloseWindow = 0;
$WEcount = 0;
$message = 'Hey!\n
I\'m chucking you an invite to check out my page on WEvolt.\n\n

WEvolt is basically two things:\n\n

1. A browser homepage in which anyone can store, share, schedule and organize their online entertainment. Sports, webcomics, videos, podcasts, blogs and news feeds are finally all in one place with reminders to go back so you never forget them again. Then categorize and post these links on your public page for your friends or fans to check out.\n\n

2. WEvolt is also an innovative online tool that allows artists working in any medium to upload, promote and monetize on their original content.\n\n

Anyway, maybe just check out my page at: http://users.wevolt.com/'.$_SESSION['username'].'/\n\n

Have a wander around the site and see what you think and maybe sign up for a free account.\n\n

Seeya online! Seeya on WEvolt!';

if (isset($_POST['submit'])) {
	$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
	$WeVoltUsers = array();
	//if ($message = $_POST['message']) {
		$emails = false;
		foreach ($_POST['email'] as $email) {
			if ($email) {
				$CloseWindow = 1;
				$emails = true;
				$query = "select encryptid, username, avatar from users where email='$email'";
				$UserArray = $DB->queryUniqueObject($query);
				
				
				if ($UserArray->username == '') {
					mail($email, 'You\'ve been invited to Wevolt!', $message, 'From: no-reply@wevolt.com');
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
					$query = "INSERT into userinvites 
								(UserID, InviteEmail, InviteCode, InviteDate) values
								('".$_SESSION['userid']."', '$email', '$authode', '".date('Y-m-d h:i:s')."')";
					$DB->query($query);
				} else {
						$WeVoltUsers[] = array(
											'Username'=>$UserArray->username,
											'Avatar'=>	$UserArray->avatar,
											'UserID'=>$UserArray->encryptid
											);
				}
			}
		}
		//print_r($WeVoltUsers);
		$error ='';	
		
		foreach($WeVoltUsers as $user) {
				$CloseWindow = 0;
				if ($WECount == 0)
					$userstring = '<div align="center" style="height:300px; overflow:auto;"><div class="spacer"></div><div class="messageinfo_white"><strong>Some of those people are already on WEvolt</strong></div><div class="spacer"></div><table width="250">';	
		
				$WEcount++;
				$userstring .= '<tr><td width="50" class="sender_name" style="padding:5px;"><a href="#" onclick="parent.window.location.href=\'http://users.wevolt.com/'.$user['Username'].'/\';"><img src="'.$user['Avatar'].'" width="50" style="border:1px #000000 solid;"></a></td><td ><div class="messageinfo_white">'.$user['Username'].'</div><div class="messageinfo_black">
<a href="#" onclick="parent.window.location.href=\'http://users.wevolt.com/'.$user['Username'].'/\';">Visit their WEvolt page <br />
to add as friend</a></div></td></tr>';
			
			
		}
		if ($WEcount > 0)
			$userstring .= '</div></table>'; 
			
		if (!$emails) {
			$error = 'please add at least one email address.';
		}
	//} else {
		//$error = 'no message was submitted. default message was reset.';
	//}
$DB->close();	
}

?>
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
parent.$.modal().close();
</script>
<? }?>
</script>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
  <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<div class="wizard_wrapper" align="center" style="height:416px; width:624px;">

                                        <img src="http://www.wevolt.com/images/headers/contacts_header.png" vspace="5"/>

  <? 
  if ($WEcount == 0) {?>
  <?php if ($error) : ?>
  <span style="color:#000;font-size:20px;"><?php echo $error; ?></span>
  <?php endif; ?>
 
  
  <form method="post" style="padding:0px; margin:0px;">
    <table cellspacing="5" cellpadding="0" border="0">
      <tr>
        <td valign="top"><div style="height:13px;"></div>
         <table width="270" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="254" align="center">
          <table cellspacing="3" cellpadding="0" border="0" width="100%">
            <tr>
              <td class="messageinfo_white">email 1:</td>
              <td width="185"><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][0]; ?>" /></td>
            </tr>
            <tr>
              <td class="messageinfo_white">email 2:</td>
              <td><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][1]; ?>" /></td>
            </tr>
            <tr>
              <td class="messageinfo_white">email 3:</td>
              <td><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][2]; ?>" /></td>
            </tr>
            <tr>
              <td class="messageinfo_white">email 4:</td>
              <td><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][3]; ?>" /></td>
            </tr>
            <tr>
              <td class="messageinfo_white">email 5:</td>
              <td><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][4]; ?>" /></td>
            </tr>
            <tr>
              <td class="messageinfo_white">email 6:</td>
              <td><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][5]; ?>" /></td>
            </tr>
            <tr>
              <td class="messageinfo_white">email 7:</td>
              <td><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][6]; ?>" /></td>
            </tr>
            <tr>
              <td class="messageinfo_white">email 8:</td>
              <td><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][7]; ?>" /></td>
            </tr>
            <tr>
              <td class="messageinfo_white">email 9:</td>
              <td><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][8]; ?>" /></td>
            </tr>
            <tr>
              <td class="messageinfo_white">email 10:</td>
              <td><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][9]; ?>" /></td>
            </tr>
          </table>
          </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
        </td>
        <td class="messageinfo_white"><div class="messageinfo_white" align="center">INVITE MESSAGE</div>
        <table width="270" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="254" align="center">

        <div style="height:237px;width:250px; overflow:auto;" align="left">Hey!<div class="smspacer"></div>


I'm chucking you an invite to check out my page on WEvolt.<div class="smspacer"></div>


WEvolt is basically two things:<div class="smspacer"></div>


1. A browser homepage in which anyone can store, share, schedule and organize their online entertainment. Sports, webcomics, videos, podcasts, blogs and news feeds are finally all in one place with reminders to go back so you never forget them again. Then categorize and post these links on your public page for your friends or fans to check out. <div class="smspacer"></div>

2. WEvolt is also an innovative online tool that allows artists working in any medium to upload, promote and monetize on their original content.<div class="smspacer"></div>


Anyway, maybe just check out my page at: http://users.wevolt.com/<? echo $_SESSION['username'];?>/<div class="smspacer"></div>


Have a wander around the site and see what you think and maybe sign up for a free account.<div class="smspacer"></div>


Seeya online! Seeya on WEvolt!
</div>
   </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
        </td>
      </tr>
      <tr>
        <td></td>
      </tr></table>
      <input type="image" src="http://www.wevolt.com/images/wizard_send_btn.png" style="border:none;background:none;"/>&nbsp;&nbsp;<img src="http://www.wevolt.com/images/wiz_cancel_btn_2.png" onclick="parent.$.modal().close();" class="navbuttons"/>
      <input type="hidden" name="submit" value="1"/>
  </form>
  <? } else {
	  echo $userstring; }?>
  </div>
