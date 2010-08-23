<?php
$imagedata = file_get_contents("http://www.spamkills.com/images/Matteblack.gif");
$newfile = fopen("Matteblack.gif", "w");
fwrite($newfile, $imagedata);
fclose($newfile);
?>
