<div align="center"><form action="/resend.php" method="post">
ENTER THE EMAIL YOU REGISTERED WITH: <div class="spacer"></div>
<strong>EMAIL: </strong><input type="text" size="30" maxlength="60" name="email"
<?php if (isset($_POST['email'])) { ?> value="<?php echo $_POST['email']; ?>" <?php } ?>/><div class="spacer"></div>
  <input type="submit" name="submit" value="Resend Verification Email" style="cursor:pointer;"/>
  
</form>
</div>