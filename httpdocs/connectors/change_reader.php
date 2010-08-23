<?php 
session_start();
header( 'Content-Type: text/javascript' );
$_SESSION['currentreader'] = $_GET['style'];
$ReUrl =  $_GET['ref'];

if ($_GET['style'] == 'flash')	{
	$_SESSION['readerpage'] = ($_GET['page']+1);
	$ReUrlArray = explode('page',$ReUrl);
	$ReUrl = $ReUrlArray[0].'#/'.$_SESSION['readerpage'];
} else {
	$Page = ($_GET['page']-1);
	if ($Page <1)
		$Page = 1;
	$ReUrl .= 'page/'.$Page.'/';
}

?>
parent.window.location = '<? echo $ReUrl;?>';