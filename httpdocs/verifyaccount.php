<?php
include 'includes/init.php';
$PageTitle = 'wevolt | verify account';

$Authcode = $_GET['authcode'];
$ID = $_GET['id'];

if (isset($_GET['authcode'])){
     // Try and get the salt from the database using the username
     $query = "select encryptid, username, verified from users where encryptid='$ID'";
  	 $UserArray = $InitDB->queryUniqueObject($query);
	
	 
     $username = $UserArray->username;
   
    if ($username != '') {
		if ($UserArray->verified == 1) {
			$Message = "<div class=\"spacer\"></div><div class=\"spacer\"></div><b>Your account has already been verified.</b>";
		} else {
			
	// Try and get the salt from the database using the username
     $query = "UPDATE users set verified=1 where encryptid='$ID'";
     $InitDB->execute($query);
	 $Message = " <div style=\"width:400px;\" align='left'><div class=\"spacer\"></div><div class=\"spacer\"></div><b>Welcome back, ". $username . "!<br/></b><div class=\"spacer\"></div>
	
	 Your account has now been verified.<div class=\"spacer\"></div>You can now log in and start enjoying WEvolt.<div class=\"spacer\"></div>

Make sure you check out our <a href='http://www.wevolt.com/tutorials.php'>TUTORIALS</a> section under the MENU button over on the top left.<div class=\"spacer\"></div><div class=\spacer\"></div>


<strong>CREATORS:</strong> If you’re a creator you probably want to start a REvolt to make a new project to get your art online. The “RE” button on the left will get you started there.<div class=\"spacer\"></div>


<strong>FANS:</strong> If you just wanna use WEvolt for fun, then click on the“MY” button over on the left to start your MYvolt homepage to start collecting and sorting out all your favorite stuff online.<div class=\"spacer\"></div>


So buckle up, dive in and have fun! </div>"; 
		}
		
	} else {
		 $Message = '<div style="width:400px;" align="left"><div class="spacer"></div><div class="spacer"></div><b>Your Authorization Code does not match.<br/></b><div class="spacer"></div>
	
	Please try the link again or resend the authorization code by <a href="/resend.php">clicking here.</div>';
	
	}
	
}
include 'includes/header_template_new.php';
$Site->drawModuleCSS();
?>
<div align="left" style="font-style:italic">
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
        <div style="padding:10px;">
          <img src="http://www.wevolt.com/images/verification_header.png" />
        <div class="messageinfo_white" style="padding:10px; width:357px;" align="center">
         <? echo $Message;?>
         </div>
      </div></td>
  </tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>