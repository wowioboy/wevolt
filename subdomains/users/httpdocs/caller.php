<?php
include_once('classes/class.rssnews.php');
if($_GET['q']=="google")
{
	echo "<h1>Google News</h1><br>";
	$obj = new rssnews('google','');
}
if($_GET['q']=="bbc")
{
	echo "<h1>BBC News</h1><br>";
	$obj = new rssnews('bbc','');
}
if($_GET['q']=="reuters")
{
	echo "<h1>Reuters News</h1><br>";
	$obj = new rssnews('reuters','');
}
if($_GET['q']=="rediff")
{
	echo "<h1>Rediff News</h1><br>";
	$obj = new rssnews('rediff','');
}
if($_GET['q']=="cbr_news")
{
	echo "<h1>Comic Book Resources - NEWS</h1><br>";
	$obj = new rssnews('cbr_news','');
}
if($_GET['q']=="cbr_reviews")
{
	echo "<h1>Comic Book Resources - REVIEWS</h1><br>";
	$obj = new rssnews('cbr_reviews','');
}

if($_GET['q']=="cbr_previews")
{
	echo "<h1>Comic Book Resources - PREVIEWS</h1><br>";
	$obj = new rssnews('cbr_previews','');
}

if($_GET['q']=="cbr_pr")
{
	echo "<h1>Comic Book Resources - PRESS RELEASES</h1><br>";
	$obj = new rssnews('cbr_pr','');
}
if($_GET['q']=="brokenfrontier")
{
	echo "<h1>Broken Frontier</h1><br>";
	$obj = new rssnews('brokenfrontier','');
}

if($_GET['q']=="custom")
{
	$obj = new rssnews('custom',$_GET['link']);
}

?>