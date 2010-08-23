<?php
  include_once("includes/class.imagebrowser.php");
?>
<html>
<head>
    <title>TEST: ImageBrowser</title>
<body style="overflow:auto;">
<?php

  $MyBrowser = new ImageBrowser('images/gallery/images');
  //$MyBrowser->BackGroundColor = "#66CCFF";
  //$MyBrowser->ShowFilename = true;
  //$MyBrowser->ShowIndex = false;
  $MyBrowser->ShowBrowser();
?>
</body>
</html>