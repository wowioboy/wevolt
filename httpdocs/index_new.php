<?php include 'includes/init.php';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<? echo $SiteDescription;?>"></meta>
<meta name="keywords" content="<? echo $Keywords;?>"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - THE WEBCOMIC CMS COMMUNITY</title>
<style type="text/css">
<!--
.style1 {font-size: 14px}
-->
</style>
</head>


<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><div id="login">
		<strong>You need to upgrade your Flash Player <br /><a href="/register/"> CLICK HERE TO LOGIN </a></strong></div>
<script type="text/javascript">
		// <![CDATA[

		var so = new SWFObject("banner.swf", "images", "677", "292", "8.0.23", true);
		so.write("login");

		// ]]>
	</script></td>
   
  </tr>
    </table>
    <div class="spacer"></div>
   <table width="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
        <td>
                 <div style="padding-left:40px; padding-right:40px;" align="left"> 
              <span class="style1">NEWS:</span><br />
              <strong>FEATURES!</strong> check out the full feature list on our new forums! <a href="http://forum.panelflow.com/index.php?topic=5.0">VIEW FEATURES</a>. 
            
              <div class="spacer"></div><strong>PANEL FLOW RELEASED! All registered users can now use the CMS for free to host a comic. So start creating!</strong> <div class='spacer'></div>
            <strong>ARCANA WEBCOMCIS</strong> Panel Flow is now running Arcana Studios' new Webcomics Section. Check out the selection of weekly updated comics and let the creators know what you think! <a href='http://www.arcanacomics.com/pf_webcomicindex.php' target="_blank">ARCANA'S WEBCOMICS</a><div class='spacer'></div>
            </div>
             
              <div class='contentwrapper' align="center"><div class='spacer'></div>
              <div class="featuredheader" style="padding-left:25px; padding-bottom:10px;">FEATURED STORIES</div>
            <div id="featured" class="featurediv">
                    <strong>You need to upgrade your Flash Player</strong></div>
            <script type="text/javascript">
                    // <![CDATA[
            
                    var so = new SWFObject("/flash/featured_v4.swf", "feature", "620", "260", "8.0.23",  true);
                     so.addVariable('xmlfile','xml/featured.xml');
                    so.write("featured");
            
                    // ]]>
                </script>
            
                </div>
    	</td>
    	</tr>
    </table>
    </div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>

</body>
</html>
