<?php 
//include 'checklink.php';

$Filename = $_POST['txtFilename']; 

	$link = '../temp/'.$Filename;

if (file_exists($link)) {
    echo '&fileresult=Found';
} else {
    echo '&fileresult=Not found';
}






//checklink('http://www.goodfridaycomic.com/urltest.php');

?>