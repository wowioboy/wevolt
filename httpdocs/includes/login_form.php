<? session_start();?>
<div id="login_div" align="center">
<form action="http://www.wevolt.com/connectors/login_auth.php" method="post" style="padding:0px;">
<input type="text" value="EMAIL" name="email" style="width:125px; font-size:10px; height:12px;" onfocus="doClear(this);" onblur="setDefault(this);"/>&nbsp;<input type="password" name="userpass" value="PASSWORD" style="width:100px; font-size:10px; height:12px;" onfocus="doClear(this);" onblur="setDefault(this);"/>&nbsp;<input type="submit" value="LOGIN" style="font-size:10px; height:14px;"/><input type="hidden" value="'.$_SESSION['refurl'].'" name="refurl"></form>
<div class="spacer"></div></div>