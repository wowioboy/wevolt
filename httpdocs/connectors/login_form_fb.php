<script type="text/javascript">
function simple_reg(action) {

	if (action == 'open'){
		document.getElementById("login_div").style.display = 'none';
		document.getElementById("register_div").style.display = 'block';
	}else{
		document.getElementById("login_div").style.display = '';
		document.getElementById("register_div").style.display = 'none';
	}
}

</script>

<?
if ($_GET['error'] != '')  {
	if ($_GET['error'] == 'Not Logged')
		$ErrorMessage = '<b>Sorry</b> there was an error logging into your account, Please try again.';
	else if ($_GET['error'] == 'Not Verified')
		$ErrorMessage = 'You need to still verify your account before using the site.';
	else if ($_GET['error'] == 'Email Exists')
		$ErrorMessage = '<b>Sorry</b> that email is already registered in our system.';
	else if ($_GET['error'] == 'User Exists')
		$ErrorMessage = '<b>Sorry</b> that Username is already registered in our system.';
}
	 ?>
<div id="user" class="messageinfo_white">

<div style="height:10px;"></div>
<table width="280"><tr><td valign="top" align="left"><img src="http://www.wevolt.com/images/connect_to_fb_header.png" />

<? /*<fb:profile-pic uid="<? echo $fb_user;?>" facebook-logo="false" linked="false" size="medium" width="50" height="50"></fb:profile-pic>*/?></td><td class="messageinfo_warning" style="padding:5px;" align="center" valign="top"  width="80"><img src="<? echo $user_pic[0]['pic_big'];?>" width="80">
</td></tr></table>

<div class="messageinfo_white" align="center">
<div style="height:5px;"></div>
<b>You will only need to do this once.</b>
</div>

<div id="login_div" align="center" class="messageinfo_white" <? if ($_GET['a'] == 'reg'){?>style="display:none;"<? }?>>
<div style="height:10px;"></div>
If you have a WEvolt account, log in below. <br />
<div style="height:10px;"></div>
<form action="http://www.wevolt.com/connectors/login_auth_frame.php" method="post" style="padding:0px;">
<table width="75%"><tr><td class="messageinfo_white" width="75" align="right"  style="font-size:14px;">Email:</td><td style="padding:3px;" align="left">
<input type="text" value="EMAIL" name="email" style="width:125px;" onfocus="doClear(this);" onblur="setDefault(this);"/></td>
</tr>
<tr>
<td class="messageinfo_white" width="75" align="right" style="font-size:14px;">Password:</td><td style="padding:3px;" align="left">
<input type="password" name="userpass" value="PASSWORD" style="width:125px;" onfocus="doClear(this);" onblur="setDefault(this);"/></td></tr>
<tr>
<td class="messageinfo_white" width="75" align="right" style="font-size:14px;"></td><td style="padding:3px;" align="left"><input type="image" src="http://www.wevolt.com/images/login_btn_sq.jpg" style="border:none;" /></td></tr>
</table>
<input type="hidden" name="from" value="<? echo $_GET['f'];?>">
<input type="hidden" name="refurl" value="<? echo $_GET['r'];?>" />
<input type="hidden" name="action" value="fbconnect">
</form>
<? echo '<div style="height:10px;"></div>'.$ErrorMessage;?>
<div style="height:10px;"></div>
If you don't have an account, <a href="#" onclick="simple_reg('open');">CLICK HERE</a> to <br />
quickly create one for FREE. 
</div>

<div id="register_div" align="center" <? if ($_GET['a'] != 'reg'){?>style="display:none;"<? }?>>
<div style="height:10px;"></div>
<div class="messageinfo_white" style="font-size:14px;">
<span style="color:#fdd700;">
Register using the form below.</span>
</div>
<form action="http://www.wevolt.com/connectors/register_fb.php" method="post">
<table width="75%"><tr><td class="messageinfo_white" width="75" align="right"  style="font-size:14px;">Username:</td><td style="padding:3px;">
<input type="text" size="28" maxlength="50" name="username"
<?php if (isset($_GET['u'])) { ?> value="<?php echo $_GET['u']; ?>" <?php } ?>/></td>
</tr>
<tr><td class="messageinfo_white" width="75" align="right"  style="font-size:14px;">Email:</td><td style="padding:3px;">
<input type="text" size="28" maxlength="50" name="regemail"
<?php if (isset($_GET['e'])) { ?> value="<?php echo $_GET['e']; ?>" <?php } ?>/> </td>
</tr>
  <tr><td colspan="2" class="messageinfo_white" style="padding:3px; font-style:italic; font-size:10px;">Password is optional, if you don't pick one now, we will email you one.</td></tr>

<tr>
<td class="messageinfo_white" width="75" align="right" style="font-size:14px;">Password:</td><td style="padding:3px;">
<input type="password" size="20" maxlength="15" name="password" /></td></tr>
<tr>
<td class="messageinfo_white" width="75" align="right" style="font-size:14px;">Confirm:</td><td style="padding:3px;">
<input type="password" size="20" maxlength="15" name="confirmpass" /></td></tr>
 <tr>
    <td align="center" colspan="2" style="padding:3px;">
<input type="submit" name="submit" value="Register!" style="background-color:#0066FF; color:#FFFFFF; cursor:pointer;"/>
</td>
  </tr>
</table>
<? echo '<div style="height:10px;"></div>'.$ErrorMessage;?>
<input type="hidden" name="face" value="<? echo $fb_user;?>" />
<input type="hidden" value="<? echo $_GET['r'];?>" name="refurl">
<input type="hidden" name="from" value="<? echo $_GET['f'];?>">
<input type="hidden" value="<? echo  $user_pic[0]['pic_big'];?>" name="avatar"> 
<input type="hidden" value="1" name="register">

</form>
</div>
</div>
