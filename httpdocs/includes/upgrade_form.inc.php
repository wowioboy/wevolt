<?php if (isset($found_error)) { 
echo $found_error; 
 } ?>
<form action="upgrade.php" method="post">
<table width="366" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="70"> </td>
    <td width="296" align="left">ENTER THE EMAIL YOU REGISTERED WITH: <br />
      <br />

<input type="text" size="30" maxlength="60" name="email"
<?php if (isset($_POST['email'])) { ?> value="<?php echo $_POST['email']; ?>" <?php } ?>/></td>
  </tr>
   <tr>
    <td align="right">

</td>
  </tr>
  <tr>
    <td colspan="2" align="center"><div class="spacer"></div><input type="submit" name="submit" value="Upgrade Me" /></td>
    </tr>
</table>
</form>