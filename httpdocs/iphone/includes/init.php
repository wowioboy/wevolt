<?php
 if(!isset($_SESSION)) {
    session_start();
  }
srand();
// Include functions
include_once( 'functions.php' );
include_once('db.class.php');
$Version = '1-5';
$settings = new DB();
$query = "select * from settings";
$settings->query($query);
while ($setting = $settings->fetchNextObject()) { 
	$SiteTitle = $setting->SiteTitle;
	$Copyright = $setting->Copyright;
	$SiteDescription = $setting->Description;
	$Keywords = $setting->Keywords;
}
?>