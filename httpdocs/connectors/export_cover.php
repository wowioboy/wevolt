<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$ComicID = $_POST['c'];
$ItemID = $_POST['p'];
$License = $_POST['l'];
$ConnectKey = $_POST['k'];
$UserID = $_POST['u'];
$Section = $_POST['s'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
 //print "MY ACTION = ". $Action."<br>";

$query = "SELECT * from users where encryptid ='$UserID' and ConnectKey='$ConnectKey'";
 $result = mysql_query($query);
 $Connected = mysql_num_rows($result);
 $user = mysql_fetch_array($result);
 //print 'MY CONNECTION CHECK KEY = ' . $query."<br/><br/>";
 if ($Connected == 1) {
 
 $query = "UPDATE users set ConnectKey='inactive' where encryptid ='$UserID'";
 $result = mysql_query($query);
 // print '= ' . $query."<br/><br/>";
 $query = "SELECT * from comics where comiccrypt ='$ComicID' and (userid='$UserID' or CreatorID='$UserID')";
 $result = mysql_query($query);
 $Authorized = mysql_num_rows($result);
 $comic = mysql_fetch_array($result);
  //print ' = ' . $query."<br/><br/>";
 $ComicFolder = $comic['HostedUrl'];
 $CreatorID = $comic['CreatorID'];
 
 $AppInstalltion = $comic['AppInstallation'];
	if ($Authorized == 0) {
		 $query = "SELECT * from comic_settings where ComicID ='$ComicID'";
 		 $result = mysql_query($query);
		  // print ' = ' . $query."<br/><br/>";
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
		//   print ' = ' . $query."<br/><br/>";
 		 $Authorized = mysql_num_rows($result);
	}
 	
	if ($Authorized == 0) {
		//echo 'Not Authorized';
	} else {
	
	$myValues = array (
 	 'image' =>  'comics/'.$ComicFolder.'/images/comiccover.jpg',
	 'thumb' =>  'comics/'.$ComicFolder.'/images/comicthumb.jpg',);
	echo serialize ($myValues);
		
	 }

} else {
echo 'Connection Failed!';
}
?>