<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$query = "select j.encrypt_id as JobID
		  from pf_jobs_positions as p 
		  join pf_jobs as j on j.id=p.job_id
		  where p.encrypt_id='".$_GET['id']."'"; 
$JobID = $DB->queryUniqueValue($query);
$DB->close();
$CloseWindow = 0;
$WEcount = 0;
$message = "Hey!\r\n 
Hey check out this job post on WEvolt. I think it's perfect for you. \r\n\r\n

http://www.wevolt.com/jobs.php?view=".$JobID."\r\n";

if (isset($_POST['submit'])) {
	if ($_SESSION['userid'] == ''){
		$Sender = $_POST['sender'];
	}else{
		$Sender = $_SESSION['email'];
	}
		$emails = false;
		foreach ($_POST['email'] as $email) {
			if (($email) && ($Sender != '')) {
				$CloseWindow = 1;
				$emails = true;
				mail($email, 'A friend suggets a job for you', $message, 'From: '.$Sender);
			}
		}
		$error ='';	
			
		if (!$emails) {
			$error = 'please add your friend\'s email address.';
		}
		if ($Sender == '') {
			$error = 'You must enter your email address, or log in.';
		}
	
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
<div class="spacer"></div>

                                        <img src="http://www.wevolt.com/images/headers/suggest_friend_header.png" vspace="8"/>

  <? 
  if ($WEcount == 0) {?>
  <?php if ($error) : ?>
  <span style="color:#000;font-size:20px;"><?php echo $error; ?></span>
  <?php endif; ?>
 
  <div align="center">
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
              <td class="messageinfo_white">Friend's Email</td>
              <td width="185"  class="messageinfo_warning"><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][0]; ?>" /></td>
            </tr>
            <tr>
              <td class="messageinfo_white">Your Email</td>
              <td width="185" class="messageinfo_warning"><? if ($_SESSION['userid'] == '') {?><input type="text" name="sender" style="width:98%;" value="<?php echo $_REQUEST['sender']; ?>" /><? } else { echo $_SESSION['email'];}?></td>
            </tr>
          </table>
          </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
        </td>
        <td class="messageinfo_white" align="center">
         <input type="image" src="http://www.wevolt.com/images/cms/cms_grey_save_box.png" style="border:none;background:none;"/>&nbsp;&nbsp; <img src="http://www.wevolt.com/images/cms/cms_grey_cancel_box.png" onclick="parent.$.modal().close();" class="navbuttons"/>

        <table width="270" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="254" align="center">

        <div style="height:237px;width:250px; overflow:auto;" align="left">Hey!<div class="smspacer"></div>


Hey check out this job post on WEvolt. I think it's perfect for you. 


http://www.wevolt.com/jobs.php?view=<? echo $JobID;?>/<div class="smspacer"></div>

<? echo $_SESSION['username'];?>
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

                                     
     
      <input type="hidden" name="submit" value="1"/>
  </form>
  </div>
  <? } else {
	  echo $userstring; }?>
  </div>
