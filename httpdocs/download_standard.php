<?php include 'includes/init.php';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - DOWNLOAD STANDARD</title>

</head>

<body>
<?php include 'includes/header_content.php';?>

     <div class='contentwrapper'>
<div class="contenttext" align="left">
  <p><strong>DOWNLOAD PANEL FLOW</strong>- STANDARD EDITION <br />
  
  <?php if ($loggedin == 1)  {?>
  You can upgrade at any time from the Standard Edition to the pro edition if you decide you want the extended features. </p>
  <p>Even though the install is easy, please read the included install instructions to make to get you up an running quickly. </p>
  <div align="center">
    <table width="210" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="210"><a href="download_std.php" target="_blank"><img src="images/standard_dl.gif"  border="0" /></a></td>
          </tr>
      </table>
    </div>
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

