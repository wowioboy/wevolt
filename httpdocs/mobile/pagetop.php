<?php


if (($BrowserTypeDetect == "xhtml") || ($BrowserTypeDetect == "html")) { 
echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD xHTML Basic 1.0//EN" "http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
      <title><? echo $Brand; ?></title>
      <link rel="stylesheet" href="<? echo $MobileCSS; ?>" type="text/css" />
    </head>
    <body>
      <p>
      <img src="/images/mycolts.jpg" alt="COLTS - Sprint" /></p>
        
<?  } else if ($BrowserTypeDetect == "wml") { 
echo "<?xml version=\"1.0\"?>"; ?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.2//EN" "http://www.wapforum.org/DTD/wml12.dtd" >
 <wml>
    <card id="main" title="<? echo $Brand; ?>&nbsp;Mobile">
      <p><img src="/images/pf_logo.jpg" alt="Ad" /><br />
      <img src="/images/spacer.gif" alt="" /><br />
      <img src="/images/<? echo $SiteImageSize; ?>/bzheader_<? echo $SiteImageSize; ?>.gif" alt="COLTS" /></p>
<? } else { 
echo "<?xml version=\"1.0\"?>"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
  <html> 
    <head>
      <title><? echo $Brand; ?>&nbsp;Mobile</title>
      <link rel="stylesheet" href="<? echo $MobileCSS; ?>" type="text/css" />
    </head>
    <body>
      <p><img src="/images/pf_logo.jpg" alt="Ad" /><br />
      <img src="/images/spacer.gif" alt="" /><br />
      <p><img src="/images/<? echo $SiteImageSize; ?>/bzheader_<? echo $SiteImageSize; ?>.gif" alt="Bound Zero" /></p>
<? } ?>

