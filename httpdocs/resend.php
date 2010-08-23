<?php 
include 'includes/init.php';
$PageTitle = 'wevolt | resend verification';
$TrackPage = 0;
include 'includes/header_template_new.php';
$Site->drawModuleCSS();
$ShowForm = 1;

//SUPRISE CODE
$_SESSION['suprise_code'] ='forget_40';
$_SESSION['suprise_redirect'] =$_SESSION['refurl'];
//include 'includes/functions.php';
if (isset($_POST['email'])) { 
	$ShowForm = 0;
	$emailresult = file_get_contents ('http://www.wevolt.com/processing/pfusers.php?action=resend&email='.$_POST['email']);
	//print "MY LOG RESULT = ". $emailresult."<br/>";
     if (trim($emailresult) == 'Sent') {
			$Message =  "An New email has been sent to your account with the authentication link.";
	     // print "MY LOG RESULT = ". $logresult."<br/>";
	 
     } else if (trim($emailresult) == 'Verified' ) {
	 	$Message =  "Your account has already been verified, there is no need to do it again. ";
	 } else {     //$myUsername = 'John';
		 $Message = "That email is not in our system. Please try again.";
		 $ShowForm = 1;
	}
}

?>
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
        <div style="padding:10px;">
             <div align="left"> <img src="http://www.wevolt.com/images/verification_header.png" /></div>
        <div class="messageinfo_white" style="padding-left:40px;" align="left">

     <div class="spacer"></div>
        <div class="spacer"></div>Need us to resend your account verification?<div class="spacer"></div>

That’s ok, we lose stuff all the time too... I mean, misplace stuff.&nbsp;&nbsp;<a href="http://www.wevolt.com/suprise_me.php"><span style="font-size:10px; font-style:italic; color:#0099FF;">well, Jason does anyway.</span></a><div class="spacer"></div>

So just enter the email you registered with below:<div class="spacer"></div>

</div>
<div align="center">

<form action="/resend.php" method="post">
 <div class="spacer"></div>
 <? $Site->drawStandardModuleTop('<img src="http://www.wevolt.com/images/verification_text.png">', 400, '', 12,'');?>
  <div class="messageinfo" align="center">
 <? echo $Message;?>

 <? if ($ShowForm == 1) {?>
&nbsp;&nbsp;&nbsp;<strong>EMAIL: </strong><input type="text" size="50" maxlength="100" name="email"
<?php if (isset($_POST['email'])) { ?> value="<?php echo $_POST['email']; ?>" <?php } ?>/><div class="spacer"></div>
 <? }?>
  </div>
       <? $Site->drawStandardModuleFooter();?>
       
    <? if ($ShowForm == 1) {?>
   <div class="spacer"></div> <input type="image" name="submit" src="http://www.wevolt.com/images/resend_btn.png" style="cursor:pointer; background:none; border:none;"/>
    <? }?>

</form>
</div>

      </div></td>
  </tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>
