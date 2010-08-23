<?php include 'includes/init.php';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - SIGN UP FOR WEBCOMIC HOSTING WITH PANEL FLOW</title>

</head>

<body>
<?php include 'includes/header_content.php';?>

<div class='contentwrapper'>
<div class="contenttext" style="height:300px; "align="left">
 <div class="featuresheader">SIGN UP FOR WEBCOMIC HOSTING WITH PANEL FLOW</div>
  <?php if ($loggedin == 1)  {?>
  <div class="featurelist"> <ul> 
          <li class="bullet" style="padding-bottom:3px;">Create Up to 4 Comics using the Full Featured Panel Flow Pro Application. For the full feature list click <a href='features.php'>HERE</a> 
          <li class="bullet" style="padding-bottom:3px;">Comics will be hosted on needcomics.com/yourcomicname.
           <li class="bullet" style="padding-bottom:3px;">Easily customize the look and feel of your comic.
          <li class="bullet" style="padding-bottom:3px;">Gain access to new templates and modules before they are available for public download.
          <li class="bullet" style="padding-bottom:3px;">Start a new blog with a free personal blog on needcomics.com
           <li class="bullet" style="padding-bottom:3px;">Join the community and find new creators and fans to get your work out there.<li class="bullet" style="padding-bottom:3px;">Choose from $3/month to sign up for hosting with ads (this will place a small ad undernearth your comic page. Or you can sign up for $4/month to have all ads removed.
            <li class="bullet" style="padding-bottom:3px;">Get a say in the future upgrades to Panel Flow. All subscribers get to vote on features each month that they want to see the most. 
            <li class="bullet" style="padding-bottom:3px;"><li class="bullet" style="padding-bottom:3px;"><b>NO RISK 7 DAY TRIAL!</b>
            <li class="bullet" style="padding-bottom:3px;"><li class="bullet" style="padding-bottom:3px;"><b>SIGN UP NOW TO LOCK IN PRICING!</b>
            
          </ul>
</div>
<div class="spacer"></div> 
 <form action="start_processing.php" method="post">
<input type="hidden" name="pro" value="1">
<input type="hidden" name="type" value="hosted">
<input type="hidden" name="start" value="1">
<table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td width="64%" align="right" style="padding-right:5px;">Select Hosting Option:</td>
<td width="36%"> <select name="txtQuanity"><option value='With Ads'>$4/Month - With Ads</option>
<option value='No Ads'>$6/Month - No Ads</option>

    </select></td></tr></table>
<div align="center">

<input type="image" src="images/hosted_comics.gif" style="border:none;" border="0" name="submit" alt="">
</div>

</form>

  <div align="center"></div>
	<?php } else { ?>
	<div align="center" style="height:300px;padding-top:50px;">
	<b>You need to be Registered and logged in to download. </b>
	</div>
	
	<?php }?>
  </div>
  </div>
  <?php include 'includes/footer_v2.php';?>

</body>
</html>

