<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$License = $_POST['l'];
$ConnectKey = $_POST['k'];
$UserID = $_POST['u'];
$ComicID = $_POST['c'];
$Template = $_POST['t'];
$AdSpace = $_POST['p'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');

$query = "SELECT * from users where encryptid ='$UserID' and ConnectKey='$ConnectKey'";
 $result = mysql_query($query);
 $Connected = mysql_num_rows($result);
 $user = mysql_fetch_array($result);
 //print $query.'<br/>';
 if ($Connected == 1) {
 
 $query = "UPDATE users set ConnectKey='inactive' where encryptid ='$UserID'";
 $result = mysql_query($query);
 
 $query = "SELECT * from comics where comiccrypt ='$ComicID' and (userid='$UserID' or CreatorID='$UserID')";
 $result = mysql_query($query);
 $Authorized = mysql_num_rows($result);
 $comic = mysql_fetch_array($result);
 $AppInstalltion = $comic['AppInstallation'];
	if ($Authorized == 0) {
		 $query = "SELECT * from comic_settings where ComicID ='$ComicID'";
 		 $result = mysql_query($query);
 		 $comicsettings = mysql_fetch_array($result);
		 $UserEmail = $user['email'];
		if (($UserEmail == $comicsettings['Assistant1']) || ($UserEmail == $comicsettings['Assistant2']) || ($UserEmail == $comicsettings['Assistant3'])) {
			$Authorized = 1;
			$query = "SELECT * from comics where comiccrypt ='$ComicID'";
 	 $result = mysql_query($query);
// print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 	$comic = mysql_fetch_array($result);
    $ComicFolder = $comic['HostedUrl'];
    $AppInstallation = $comic['AppInstallation'];
		}
	}
	
	if ($Authorized == 1) {
		 $query = "SELECT * from Applications where ID='$AppInstalltion' and LicenseID='$License'";
 		 $result = mysql_query($query);
 		 $Authorized = mysql_num_rows($result);
	}
 	
	if ($Authorized == 0) {
		echo 'Not Authorized';
	} else {
 		$query = "SELECT * from adspaces where ComicID ='$ComicID' and Template='$Template' and Position='$AdSpace'";
 		$result = mysql_query($query);
	 	$ad = mysql_fetch_array($result);
		echo $ad['AdCode'];
	}
} else {
 echo 'Connection Failed!';
}


?>


