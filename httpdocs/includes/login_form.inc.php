<?php if (isset($login_error)) { ?>
There was an error: <?php echo $login_error; ?>, please try again.
<?php } ?>
<form action="login.php" method="post">
<table width="366" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="112"> EMAIL : </td>
    <td width="254"><input type="text" size="20" maxlength="50" name="email"
<?php if (isset($_POST['email'])) { ?> value="<?php echo $_POST['email']; ?>" <?php } ?>/></td>
  </tr>
  <tr>
    <td>PASSWORD:</td>
    <td> <input type="password" size="20" maxlength="10" name="userpass" /></td>
  </tr>
  <tr>
    <td align="right">

</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><div class="spacer"></div><input type="submit" name="submit" value="Login" /></td>
    </tr>
</table>
</form>