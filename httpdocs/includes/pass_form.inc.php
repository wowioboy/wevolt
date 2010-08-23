<?php if (isset($found_error)) { 
echo $found_error; 
 } ?>
<form action="forgot.php" method="post">
<table width="366" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="112"> </td>
    <td width="254" align="left">ENTER THE EMAIL ASSOCIATED WITH YOUR PANEL FLOW ACCOUNT : <br /><br />

<input type="text" size="30" maxlength="60" name="email"
<?php if (isset($_POST['email'])) { ?> value="<?php echo $_POST['email']; ?>" <?php } ?>/></td>
  </tr>
   <tr>
    <td align="right">

</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><div class="spacer"></div><input type="submit" name="submit" value="Request Password" /></td>
    </tr>
</table>
</form>