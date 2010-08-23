<?php include 'includes/init.php';
$PageTitle = ' | Domain Hosting';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?> - <?php echo $PageTitle; ?></title>

</head>
<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;">

<div class='contentwrapper'>
<div class="contenttext" align="left">
 <div class="featuresheader">PANEL FLOW PRO DOMAIN HOSTING</div>
  <?php if ($loggedin == 1)  {?>
  <div class="featurelist"> <ul> 
          <li class="bullet" style="padding-bottom:3px;">Create your own Webcomics hub, and manage unlimted comics from one central administration interface.
          <li class="bullet" style="padding-bottom:3px;">Start syndication your comic all across the web with a built in flash widget to mirrir your latest update, then links the reader back to your site to read more.
          <li class="bullet" style="padding-bottom:3px;">Easily switch styles and looks for your comics through a built in templating system. 
          <li class="bullet" style="padding-bottom:3px;">Assign Assistants and Creators to comics and let them manage their assigned comics.
           <li class="bullet" style="padding-bottom:3px;">Que pages to go live on a specific date and quickly move pages around. 
            <li class="bullet" style="padding-bottom:3px;">Upload extra content for your readers like Character Profiles, Wallpapers, Avatars and more.
            <li class="bullet" style="padding-bottom:3px;">Allow anyone with a Panel Flow account to log into your site to leave page comments.
            <li class="bullet" style="padding-bottom:3px;">Access to pagetracking tools to see how many people are reading your comic everyday.
            <li class="bullet" style="padding-bottom:3px;">Upload new modules to further enhance your comic and add features.
            <li class="bullet" style="padding-bottom:3px;">
          </ul>
          </li>
</div>
 <div class="featuresheader">HOSTING PACKAGE</div>
  <div class="featurelist"> <ul> 
   		 <li class="bullet" style="padding-bottom:3px;">Access to run the <strong>Panel Flow Pro CMS</strong> on unlimited domains
          <li class="bullet" style="padding-bottom:3px;">Includes Email (POP/IMAP and WEBMAIL)
          <li class="bullet" style="padding-bottom:3px;">Access to Fantastico Application installer
          <li class="bullet" style="padding-bottom:3px;">Cpanel Domain Administration
          <li class="bullet" style="padding-bottom:3px;">Addon Sub Domains
           <li class="bullet" style="padding-bottom:3px;">5gb Transfer / 5gb Hard Drive 
            
          </ul>
</div>
 <form action="/store/start/" method="post">
<input type="hidden" name="txtSubType" value="5">
<input type="hidden" name="type" value="domain">
<input type="hidden" name="start" value="1">
<? if (isset($_GET['error'])) { 
	if ($_GET['error'] == 1) {
	echo '<div style="padding-left:90px; font-size:12px;"><font color="red">You need to Enter a Domain</font><div class="spacer"></div></div>'; 
	} else if ($_GET['error'] == 2){
	echo '<div style="padding-left:90px; font-size:12px;"><font color="red">Please enter your domain as : domain.com, do not include the \'www\'</font><div class="spacer"></div></div>'; 
	}
	}
?>
<div style="padding-left:90px;">Enter the domain you would like to sign up <br />

<input type="text" name="txtDomain" style="width:250px;" />&nbsp;(ex: domain.com)</div>
<div class="spacer"></div>
<div align="center">
<input type="image" src="/images/domain_hosting_btn.png" style="border:none;" border="0" name="submit" alt="">
</div>

</form><div class="spacer"></div>
	<?php } else { ?>
	<div align="center" style="height:300px;padding-top:50px;">
	<b>You need to be Registered and logged in to sign up for this package</b>
	</div>
	<?php }?>
  </div>
  </div>
 </div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>
</body>
</html>

