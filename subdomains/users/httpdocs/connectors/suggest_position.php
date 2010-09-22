<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$query = "select j.encrypt_id as JobID
		  from pf_job_positions as p 
		  join pf_jobs as j on j.id=p.job_id
		  where p.encrypt_id='".$_GET['id']."'"; 
$JobID = $DB->queryUniqueValue($query);
$DB->close();
$CloseWindow = 0;
$WEcount = 0;
$message = 'Hey!\n\n 
Hey check out this job post on WEvolt. I think it\'s perfect for you. \n\n

http://www.wevolt.com/jobs.php?view='.$JobID.'\n\n

'.$_SESSION['username'];

if (isset($_POST['submit'])) {
	//$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
	$WeVoltUsers = array();
	//if ($message = $_POST['message']) {
		$emails = false;
		foreach ($_POST['email'] as $email) {
			if ($email) {
				$CloseWindow = 1;
				$emails = true;
				mail($email, 'A friend suggets a job for you', $message, 'From: no-reply@wevolt.com');
			}
		}
		$error ='';	
		if ($WEcount > 0)
			$userstring .= '</div></table>'; 
			
		if (!$emails) {
			$error = 'please add your friend\'s email address.';
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
<div style="background-image:url(http://www.wevolt.com/images/!wizard_base.jpg); background-repeat:no-repeat; height:416px; width:624px;" align="center"> 
<div class="spacer"></div>
  <table width="608" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="592" align="center">
                                        <img src="http://www.wevolt.com/images/wizard_invite_header.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>

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
              <td class="messageinfo_white">Friend's Email</td>
              <td width="185"><input type="text" name="email[]" style="width:98%;" value="<?php echo $_POST['email'][0]; ?>" /></td>
            </tr>
           
          </table>
          </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
        </td>
        <td class="messageinfo_white"><div class="messageinfo_white" align="center">Personal Message</div>
        <table width="270" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="254" align="center">

        <div style="height:237px;width:250px; overflow:auto;" align="left">Hey!<div class="smspacer"></div>


Hey check out this job post on WEvolt. I think it's perfect for you. 


Anyway, maybe just check out my page at: http://www.wevolt.com/jobs.php?view=<? echo $JobID;?>/<div class="smspacer"></div>

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
      <input type="image" src="http://www.wevolt.com/images/wizard_send_btn.png" style="border:none;background:none;"/>&nbsp;&nbsp;<img src="http://www.wevolt.com/images/wiz_cancel_btn_2.png" onclick="parent.$.modal().close();" class="navbuttons"/>
      <input type="hidden" name="submit" value="1"/>
  </form>
  <? } else {
	  echo $userstring; }?>
  </div>
