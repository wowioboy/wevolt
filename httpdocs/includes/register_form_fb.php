<?php if (isset($reg_error)) { ?>
There was an error: <?php echo $reg_error; ?>, please try again.
<?php } ?>
<form action="/connectors/facebook_auth.php" method="post">
<table width="300" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="84" valign="top">USERNAME</td>
    <td valign="top"><input type="text" size="30" maxlength="50" name="username"
<?php if (isset($_POST['username'])) { ?> value="<?php echo $_POST['username']; ?>" <?php } ?>/><div class="spacer"></div></td>
  </tr>
  <tr>
    <td valign="top">EMAIL</td>
    <td valign="top"> <input type="text" size="30" maxlength="50" name="email"
<?php if (isset($_POST['email'])) { ?> value="<?php echo $_POST['email']; ?>" <?php } ?>/> 
</td>
  </tr>
  <tr>
    <td valign="top">PASSWORD</td>
    <td valign="top"><input type="password" size="20" maxlength="15" name="password" /> (6-15 characters) <div class="spacer"></div></td>
  </tr>
  <tr>
    <td rowspan="2" valign="top">CONFIRM PASSWORD:</td>
    <td valign="top"><input type="password" size="20" maxlength="15" name="confirmpass" /><div class="spacer"></div></td>
  </tr>
  <tr>
    <td align="left">
<input type="submit" name="submit" value="Register!" />
</td>
  </tr>
  <tr>
    <td colspan="2"></td>
    </tr>
</table>
</form>