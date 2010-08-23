

<div align='center'>

    

      <div class="spacer"></div><div class="spacer"></div>

<?php if (isset($login_error)) { ?>

<b>There was an error: </b><br/><br/><?php echo $login_error; ?>

<?php } ?>

<form action="login.php" method="post">

<table width="20%" border="0" cellspacing="0" cellpadding="0">

  <tr>

    <td valign="top"  bgcolor="#000000" style="padding:5px;"><div class="header">OUTLAND CMS LOGIN</div>   <div class="spacer"></div>USERNAME:<br />
 <input type="text" size="30" maxlength="50" name="username"

<?php if (isset($_POST['username'])) { ?> value="<?php echo $_POST['username']; ?>" <?php } ?>/>

      <div class="spacer"></div></td>

  </tr>

  <tr>

    <td  bgcolor="#000000" style="padding:5px;">PASSWORD:<br />
<input type="password" size="30" maxlength="50"  name="userpass" /></td>

  </tr>

  <tr>

    <td colspan="2"   bgcolor="#000000" style="padding:5px; padding-left:150px;"><div class="spacer"></div><input type="submit" name="submit" value="Login" /></td>

    </tr>

</table>



</form>

</div>