<?php include 'includes/init.php';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - PURCHASE DOMAIN LICENSE</title>

</head>

<body>
<?php include 'includes/header_content.php';?>

<div class='contentwrapper'>
<div class="contenttext" style="height:300px; "align="left">
 <div class="featuresheader">PURCHASE ADDITIONAL DOMAIN LICENSE</div>
  <?php if ($loggedin == 1)  {?>
  <div class="featurelist"> <ul> 
          <li class="bullet" style="padding-bottom:3px;">If you have already purchased Panel Flow and would like to run the application on another domain, it's simple. Just purchase additional licenses below, 1 for each domain you would like to use Panel Flow on. 

          </ul>
      </div>
<div class="spacer"></div>
 <form action="start_processing.php" method="post">
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="66%" align="right" style="padding-right:5px;">Select Number Of Domains:</td>
<td width="34%"> <select name="txtQuanity"><option value='1 Domain'>1 Domain - $1.00</option>
<option value='2 Domains'>2 Domains - $2.00</option>
  <option value='3 Domains'>3 Domains - $3.00</option>
   <option value='4 Domains'>4 Domains - $4.00</option>
   <option value='5 Domains'>5 Domains - $5.00</option>
    </select></td></tr></table>

<input type="hidden" name="pro" value="1">
<input type="hidden" name="type" value="license">
<input type="hidden" name="start" value="1">
 <div align="center">
<input type="image" src="images/domain_license.gif" style="border:none;" border="0" name="submit" alt="">
</div>

</form>

  <div align="center"></div>
	<?php } else { ?>
	<div align="center" style="height:300px;padding-top:50px;">
	<b>You need to be Registered and logged in to purchase liceses. </b>
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

