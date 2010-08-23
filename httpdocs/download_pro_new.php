<?php include 'includes/init.php';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - DOWNLOAD PRO EDITION</title>

</head>

<body>
<?php include 'includes/header_content.php';?>

     <div class='contentwrapper'>
<div class="contenttext" align="left">
  <p><strong>DOWNLOAD PANEL FLOW</strong>- PRO EDITION <br />
  
  <?php if ($loggedin == 1)  {?>
 <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="892833">
<input type="image" src="https://www.paypal.com/en_US/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="">
<img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>

  <div align="center"></div>
	<?php } else { ?>
	<div align="center">
	<b>You need to be Registered and logged in to download. </b>
	</div>
	
	<?php }?>
  </div>
  </div>
  <?php include 'includes/footer_v2.php';?>
  <map name="Map" id="Map"><area shape="rect" coords="143,9,201,21" href="register.php" />
<area shape="rect" coords="223,7,258,23" href="login.php" />
<area shape="rect" coords="283,9,338,21" href="contact.php" />
<area shape="rect" coords="360,8,407,22" href="comics.php" />
<area shape="rect" coords="429,8,462,23" href="faq.php" />
<area shape="rect" coords="487,7,545,21" href="creators.php" />
<area shape="rect" coords="568,6,638,23" href="download.php" />
</map>
</body>
</html>

