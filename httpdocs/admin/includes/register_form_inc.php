
<?php if (isset($reg_error)) { ?>
There was an error: <?php echo $reg_error; ?>, please try again.
<?php } ?>
<form action="admin.php?a=users" method="post">
<input type="hidden" name="add" value="1" />
<table width="400" border="0" cellspacing="0" cellpadding="0">
<tr><td colspan="2"><div class="pageheader">CREATE A NEW USER</div><div class="spacer"></div></td></tr>
  <tr>
    <td width="142" class='inputname'>NAME:</td>
    <td width="258" align="left"><input type="text" size="30" maxlength="50" name="name"
<?php if (isset($_POST['name'])) { ?> value="<?php echo $_POST['name']; ?>" <?php } ?>/></td>
  </tr>
  <tr>
    <td align="left" class='inputname'><div class="spacer"></div>USERNAME:</td>
    <td align="left"><div class="spacer"></div><input type="text" size="30" maxlength="50" name="username"
<?php if (isset($_POST['username'])) { ?> value="<?php echo $_POST['username']; ?>" <?php } ?>/></td>
  </tr>
  <tr>
    <td class='inputname'><div class="spacer">PASSWORD:</div></td>
    <td align="left"><div class="spacer"></div><input type="password" size="20" maxlength="10" name="password" /></td>
  </tr>
  <tr>
    <td class='inputname'><div class="spacer"></div><b>CONFIRM PASSWORD: </b> </td>
    <td valign="top" align="left"><div class="spacer"></div><input type="password" size="20" maxlength="10" name="confirmpass" /></td>
  </tr>
  
   <tr>
    <td class='inputname'><div class="spacer"></div>
    <b>EMAIL: </b> </td>
    <td valign="top" align="left"><div class="spacer"></div><input type="password" size="20" maxlength="10" name="confirmpass" /></td>
  </tr>
  <tr>
    <td>USERTYPE</td>
    <td align="left"><input type="checkbox" name="txtUserType" id="txtUserType" value="5" />
    <span class='inputname'> 
ADMINISTRATOR</span><br />
<input type="checkbox" name="txtUserType" id="txtUserType" value="1" />
<span class='inputname'> CLIENT / USER
</span></td>
  </tr>
</table>
<div class="spacer"></div>

<INPUT TYPE="submit" name="btnsubmit"  value="CREATE ACCOUNT" />
</form>
