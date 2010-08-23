<?php include 'includes/init.php';
$PageTitle = ' | Comics Hosting';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?> <?php echo $PageTitle; ?></title>

</head>
<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 

<div class='contentwrapper'>
<div class="contenttext" align="left">
 <div class="featuresheader">PANEL FLOW PRO COMIC HOSTING</div>
  <?php if ($loggedin == 1)  {?>
  <div class="featurelist" style="font-size:12px;"> <ul> 
            <li class="bullet" style="padding-bottom:3px;">Quickly set up your own comics on our portal needcomics.com. 
          <li class="bullet" style="padding-bottom:3px;">Gain access to all the pro features of the CMS, as well as Beta Modules/Components and templates as they are released to the community. 
          <li class="bullet" style="padding-bottom:3px;">Run up to 5 Comics.
          <li class="bullet" style="padding-bottom:3px;">Assign Assistants and Creators to comics and let them manage their assigned comics.
           <li class="bullet" style="padding-bottom:3px;">Que pages to go live on a specific date and quickly move pages around. 
            <li class="bullet" style="padding-bottom:3px;">Upload extra content for your readers like Character Profiles, Wallpapers, Avatars and more.
            <li class="bullet" style="padding-bottom:3px;">Allow anyone with a Panel Flow account to log into your site to leave page comments.
            <li class="bullet" style="padding-bottom:3px;">Access to pagetracking tools to see how many people are reading your comic everyday.
            <li class="bullet" style="padding-bottom:3px;">Upload new modules to further enhance your comic and add features. <li class="bullet" style="padding-bottom:3px;">Get a say in the future upgrades to Panel Flow. All subscribers get to vote on features each month that they want to see the most. 
            <li class="bullet" style="padding-bottom:3px;"><b>NO RISK TRIAL!</b>
             <li class="bullet" style="padding-bottom:3px;"><b>SIGN UP NOW!</b>
       </ul>
        
</div>

 <form action="/store/start/" method="post">
<input type="hidden" name="type" value="hosted">
<input type="hidden" name="start" value="1">

<div align="center">
<select name="txtSubType"><option value='3'>$4/Month - With Ads on CMS</option>
<option value='4'>$6/Month - No Ads on CMS</option>

    </select>
    <div class="spacer"></div>
<input type="image" src="/images/hosted_comics_btn.png" style="border:none;" border="0" name="submit" alt="">
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

