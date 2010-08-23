<?php 
include '../includes/dbconfig.php';
$Server = $_GET['server'];
$License = $_GET['l'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
 //print "MY ACTION = ". $Action."<br>";
 
$query = "SELECT * from pf_ads order by RAND() limit 1";
$result = mysql_query($query);
$ad = mysql_fetch_array($result);
$AdLink = $ad['Url'];
$AdCode = $ad['Code'];
$AdImage = $ad['Image'];
$AdFlash = $ad['Flash'];

if ($AdImage != '')
	$AdString ='<div align="center" style="padding-top:5px;"><a href="'.$AdLink.'"><img src="'.$AdImage.'" border="0"></a></div>';
else if ($AdCode != '')
	$AdString ='<div align="center">'.$AdCode.'</div>';
	
echo $AdString;

?>