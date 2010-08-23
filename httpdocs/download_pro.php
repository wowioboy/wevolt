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
  The pro edition is ONE-TIME payment of $10, which will get you free updates and upgrades for the life of the product. The Pro edition also gives you access to the upcoming Panel Flow modules at a reduced cost. </p>
  <p>PANEL FLOW Pro will be available soon, check out some of the sample sites using it. <br />
    <br />
      <strong>Good Friday</strong> - <a href="http://www.goodfridaycomic.com">http://www.goodfridaycomic.com</a><br />
        <strong>Spam Kills</strong> -<a href="http://www.spamkills.com"> http://www.spamkills.com</a></p>
  <p>Even though the install is easy, please read the included install instructions to make to get you up an running quickly. </p>
  <p>If you have any problems or issues with the installation, you can consult our <a href="faq.php">F.A.Q</a>. or contact us at : <a href="mailto:support@panelflow.com">support@panelflow.com </a></p>
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

