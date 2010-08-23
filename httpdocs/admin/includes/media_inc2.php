<?php
        $handle = opendir ('images/content/');
        while (false !== ($file = readdir($handle))) {
            if($file != "." && $file != ".." && $file != basename(__FILE__)) {
                 echo '<img src="images/content/'.$file.'" width="100"/><br />'.$file.'<br />';
            }
        }
?>
