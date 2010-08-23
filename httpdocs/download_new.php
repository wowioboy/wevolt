<?php include 'includes/init.php';


$PageTitle = ' | Subscribe to Panel Flow';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
 
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="<?php echo $SiteDescription ?>"></meta>
<meta name="keywords" content="Panel Flow, Content Management System,<?php echo $Keywords;?>"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><?php echo $SiteTitle; ?><?php echo $PageTitle; ?></title>

</head>

<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 
<div class='contentwrapper'>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" style="padding:10px;">All registered users can host a comic for <b>FREE</b> on Needcomics.com, but if you're looking for more features to offer to your readers, want to start a webcomics hub of your own, or want to host your comics on your own domain, then sign up for one of the PRO options below: </td>
     </tr>
   </table></div>
    
  <div align="center" style="padding-right:4px;">
    <div id="featured" class="featurediv">
		<strong>You need to upgrade your Flash Player</strong></div>
<script type="text/javascript">
		// <![CDATA[

		var so = new SWFObject("/flash/download_new.swf", "feature", "750", "425", "8.0.23",  true);
			so.write("featured");

		// ]]>
	</script>

	</div>
</div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>
</body>
</html>
