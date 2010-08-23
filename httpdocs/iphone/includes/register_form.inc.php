<?php if ($Error != '') { ?><div style="padding:5px; color:#FF0000;">
There was an error: <?php echo $Error; ?>
</div><div style="height:5px;"></div>
<?php } ?>
<form action="register.php" method="post">
<table border="0" cellspacing="0" cellpadding="0" width="95%">
  <tr>
    <td  valign="top">USERNAME</td>
    <td valign="top"><input type="text" size="25" maxlength="50" name="username"
<?php if (isset($_POST['username'])) { ?> value="<?php echo $_POST['username']; ?>" <?php } ?>/><div class="spacer"></div></td>
  </tr>
   <tr>
    <td  valign="top">REAL NAME</td><td>
  <input type="text" size="25" maxlength="50" name="realname"
<?php if (isset($_POST['realname'])) { ?> value="<?php echo $_POST['realname']; ?>" <?php } ?>/><div class="spacer"></div></td>
  </tr>
  <tr>
    <td valign="top">EMAIL</td>
    <td valign="top"> <input type="text" size="25" maxlength="50" name="email"
<?php if (isset($_POST['email'])) { ?> value="<?php echo $_POST['email']; ?>" <?php } ?>/> 
      <br />
      (You will use your email to log in on all Panel Flow Sites)<br /><br /></td>
  </tr>
  <tr>
    <td valign="top">PASSWORD</td>
    <td valign="top"><input type="password" size="15" maxlength="15" name="password" />
      <div class="spacer"></div></td>
  </tr>
  <tr>
    <td valign="top">CONFIRM:</td>
    <td valign="top"><input type="password" size="15" maxlength="15" name="confirmpass" /><div class="spacer"></div></td>
  </tr>
   
 
   <tr>
    <td valign="top">OVER 13?</td>
    <td valign="top"><input type="radio" name="txtOver" value="1" <? if ($_POST['txtOver']=='1') echo 'checked';?>/>Yes&nbsp;&nbsp;<input type="radio" name="txtOver" value="0" <? if ($_POST['txtOver']=='0') echo 'checked';?>/>No <div class="spacer"></div></td>
  </tr>
  
   <tr>
    <td valign="top"></td>
    <td valign="top"><div style="height:3px;"></div>IF  'yes' enter DOB?<br />
<input type="text" name="txtdate" <?php if (isset($_POST['txtdate'])) { ?> value="<?php echo $_POST['txtdate']; ?>" <?php } ?> /> <br />
<font style="font-size:10px;">MM-DD-YYYY </font><div class="spacer"></div></td>
  </tr>
   <tr>
    <td valign="top">GENDER</td>
    <td valign="top"><input type="radio" name="txtGender" value="m" <? if ($_POST['txtGender']=='m') echo 'checked';?>/>M&nbsp;&nbsp;<input type="radio" name="txtGender" value="f"  <? if ($_POST['txtGender']=='f') echo 'checked';?>/>F <div class="spacer"></div></td>
  </tr>
   <tr>
    <td colspan="2" align="left">
<input type="submit" name="submit" style="width:100%;" value="Finish Registration!" />
<input type="hidden" name="txtRegister" value='1'/></td>
   </tr>
  <tr>
    <td colspan="2"></td>
    </tr>
</table>
</form>