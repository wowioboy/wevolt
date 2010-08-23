<?php
include_once('classes/class.rssnews.php');
if($_GET['q']=="google")
{
	echo "<h1>Google News</h1><br>";
	$obj = new rssnews('google');
}
if($_GET['q']=="bbc")
{
	echo "<h1>BBC News</h1><br>";
	$obj = new rssnews('bbc');
}
if($_GET['q']=="reuters")
{
	echo "<h1>Reuters News</h1><br>";
	$obj = new rssnews('reuters');
}
if($_GET['q']=="rediff")
{
	echo "<h1>Rediff News</h1><br>";
	$obj = new rssnews('rediff');
}
if($_GET['q']=="toi")
{
	echo "<h1>The Times Of India </h1><br>";
	$obj = new rssnews('toi');
}
if($_GET['q']=="hindu")
{
	echo "<h1>The Hindu</h1><br>";
	$obj = new rssnews('hindu');
}
if($_GET['q']=="pk")
{
	echo "<h1>Prabhat Khabar</h1><br>";
	$obj = new rssnews('pk');
}
if($_GET['q']=="et")
{
	echo "<h1>Economic Times</h1><br>";
	$obj = new rssnews('et');
}
?>