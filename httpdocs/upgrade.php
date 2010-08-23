<?php 
header("Location:/register.php?a=pro");

include 'includes/init.php';
$PageTitle = 'wevolt | upgrade';
$TrackPage = 1;
include 'includes/header_template_new.php';?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_modules_css.css">



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
		
		
		<?php /*

if (!isset($_POST['email']))
{?>
<div id="register">
		<strong><?php include 'includes/register_form.inc.php';?></div>
<script type="text/javascript">
		// <![CDATA[
		var so = new SWFObject("/flash/regMain.swf", "register", "400", "350", "8.0.23", "#ffffff", true);
		so.addVariable('ref','<?php echo $Referral;?>');
		so.write("register");

		// ]]>
	</script>	 
<?php 
 
}
else
{     // Everything is ok, register
$TempUsername = $_POST['username'];
$Usernamereplace = trim(preg_replace('/\s+/', '', $TempUsername));
$result = file_get_contents ('http://www.panelflow.com/processing/pfusers.php?action=register&email='.urlencode($_POST['email']).'&pass='.$_POST['password']."&username=".urlencode($Usernamereplace)."&overage=".$_POST['overage']."&birthdate=".urlencode($_POST['birthdate'])."&notify=".$_POST['notify']."&gender=".$_POST['gender']."&realname=".urlencode($_POST['realname'])."&ref=".urlencode(trim($_POST['ref'])));

if (trim($result) == 'Clear'){
include 'includes/dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$email = $_POST['email'];
$query = "select encryptid, username, avatar from $usertable where email='$email'";
$result = mysql_query($query);
$user = mysql_fetch_array($result);
$Avatar = $user['avatar'];
$Username = trim($user['username']);
if(!is_dir("users/". $Username)) { 
@mkdir("users/".$Username); chmod("users/".$Username, 0777); 
}

if(!is_dir("users/".$Username."/avatars")) { 

@mkdir("users/".$Username."/avatars"); chmod("users/".$Username."/avatars", 0777); 
@mkdir("users/".$Username."/pdfs"); chmod("users/".$Username."/pdfs", 0777); 
}
@copy ("usersource/index_redirect.html","users/".$Username."/avatars/index.html");
@copy ("usersource/index_redirect.html","users/".$Username."/index.html");
@copy ("usersource/index_redirect.html","users/".$Username."/pdfs/index.html");
 
     echo '<div class="spacer"></div><div class="spacer"></div><div align="center">';
	 
	 echo '<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" align="left" width="120">Your current Avatar: <br/><img src="'.$Avatar.'" border="2" > <br/>you can change this after you verify</td>
    <td valign="middle"><div class="content" align="left">Welcome,<b> '.$Username.'</b><br> Thank you for registering on our site, after you have verified your account you can leave comments on all Panel Flow Webcomics sites and create your own comics. <div class="spacer"></div><br>Two emails have just been sent to <b>'.$email.'</b> with all your PANEL FLOW information and the account verification link. Please keep it for your records.</div></td>
  </tr>
</table></div>';
	 
} else if  (trim($result) == 'Email Exists') { 

$regError = 'Sorry that email already exists in our database';
?>

<div id="register">
		<strong><?php include 'includes/register_form.inc.php';?></div>
<script type="text/javascript">
		// <![CDATA[ 
		var so = new SWFObject("/flash/regMain.swf", "images", "400", "350", "8.0.23", "#ffffff", true);
		so.addVariable('username','<?php echo $_POST['username'];?>');
		so.addVariable('gender','<?php echo $_POST['gender'];?>');
		so.addVariable('birthdate','<?php echo $_POST['birthdate'];?>');
		so.addVariable('logerror','<?php echo $regError;?>');
		so.addVariable('overage','<?php echo $_POST['overage'];?>');
		so.addVariable('realname','<?php echo $_POST['realname'];?>');
		so.addVariable('notify','<?php echo $_POST['notify'];?>');
		so.write("register");

		// ]]>
	</script>	 
<?php 
} else if  (trim($result) == 'User Exists') { 

$regError = 'Sorry that Username already exists. Try another.';
?>

<div id="register">
		<strong><?php include 'includes/register_form.inc.php';?></div>
<script type="text/javascript">
		// <![CDATA[
		var so = new SWFObject("/flash/regMain.swf", "images", "400", "350", "8.0.23", "#ffffff", true);
		so.addVariable('email','<?php echo $_POST['email'];?>');
		so.addVariable('gender','<?php echo $_POST['gender'];?>');
		so.addVariable('birthdate','<?php echo $_POST['birthdate'];?>');
		so.addVariable('logerror','<?php echo $regError;?>');
		so.addVariable('overage','<?php echo $_POST['overage'];?>');
		so.addVariable('realname','<?php echo $_POST['realname'];?>');
		so.addVariable('notify','<?php echo $_POST['notify'];?>');
		so.write("register");

		// ]]>
	</script>	 
<?php 
}

}
*/
?>

<table width="750" border="0" cellpadding="0" cellspacing="0" height="">
                  <tbody>
                    <tr>
                      <td id="modtopleft"></td>
                      <td id="modtop" width="738" align="left">WEVOLT UPGRADE ACCOUNT</td>
                          
                      <td id="modtopright" align="right" valign="top"></td>
                    </tr>
                    <tr>
                      <td colspan="3" valign="top" style="padding-left:3px; padding-right:3px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                              <td id="modleftside"></td>
                              <td class="boxcontent">
                               Even though you can still experience and enjoy content on wevolt without even needing to log in or subscribe to a pro account, there are all kinds of awesome benefits if you do.<br>
<br>
 Check out the list below to see all the advantages of getting a Pro wevolt Account. <br>

<br>
<ol>
<li> NO ADs! That's right, when you have a pro account, we get rid of all the ads on the site. Not only does this give you more landscape to enjoy content, but you never have to see another ad again! Plus, just by getting a pro account and reading the projects you love, you will be sharing some of the subscription with the creators. So everyone wins!</li><br>

<li>Customize your wevolt/myvolt page. You will gain access to all kinds of new templates and features for your wevolt and myvolt pages that standard users don't have. </li><br>

<li>Enhance the reading ecperience. Not only do you lose ads, but when you read a project you will be viewing content at a much bigger size. </li><br>

<li>Create unlimited REVOLT pages. Standard users can only host one project on wevolt, but with a pro account you can do as many as you want. </li><br>

<li>Unlock premium CMS features. You will have instant access to even more tools and features to bring your project to life and give it your own unique style. </li>
</ol>
                             </td>
                              <td id="modrightside"></td>
                            </tr>
                            <tr>
                      <td id="modbottomleft"></td>
                      <td id="modbottom"></td>
                      <td id="modbottomright"></td>
                    </tr>
                          </tbody>
                      </table>

 </div></td>
  </tr>
</table>
</div>
<?php include 'includes/footer_template_new.php';?>
