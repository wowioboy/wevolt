<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$ComicID = $_POST['c'];
$License = $_POST['l'];
$ConnectKey = $_POST['k'];
$UserID = $_POST['u'];
$ContentType = $_GET['t'];


mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');

$query = "SELECT * from users where encryptid ='$UserID' and ConnectKey='$ConnectKey'";
 $result = mysql_query($query);
 $Connected = mysql_num_rows($result);
 $user = mysql_fetch_array($result);
 
 if ($Connected == 1) {
 	//$query = "UPDATE users set ConnectKey='inactive' where encryptid ='$UserID'";
 	//$result = mysql_query($query);
	if ($ContentType != 'story')
		$query = "SELECT * from comics where comiccrypt ='$ComicID' and (userid='$UserID' or CreatorID='$UserID')";
 	else
		$query = "SELECT * from stories where StoryID ='$ComicID' and (userid='$UserID' or CreatorID='$UserID')";
	$result = mysql_query($query);
	$Authorized = mysql_num_rows($result);
	 $comic = mysql_fetch_array($result);
 $AppInstallation = $comic['AppInstallation'];
 	if ($ContentType != 'story')
		$query = "SELECT * from comic_settings where ComicID ='$ComicID'";
	else
		$query = "SELECT * from story_settings where StoryID ='$ComicID'";
 	$result = mysql_query($query);
	
 	$comicsettings = mysql_fetch_array($result);
	
	if ($Authorized == 0) {
		$UserEmail = $user['email'];
		if (($UserEmail == $comicsettings['Assistant1']) || ($UserEmail == $comicsettings['Assistant2']) || ($UserEmail == $comicsettings['Assistant3'])) {
			$Authorized = 1;
		}
	}
	
	if ($Authorized == 1) {
		 $query = "SELECT * from Applications where ID='$AppInstallation' and LicenseID='$License'";
 		 $result = mysql_query($query);
 		 $Authorized = mysql_num_rows($result);
	}
 	
	if ($Authorized == 0) {
		echo 'Not Authorized';
	} else {
	if ($ContentType != 'story')
		$query = "SELECT Assistant1,Assistant2, Assistant3 from comic_settings where ComicID ='$ComicID'";
 	else
		$query = "SELECT Assistant1,Assistant2, Assistant3 from story_settings where StoryID ='$ComicID'";
	$result = mysql_query($query);
 	$comicsettings = mysql_fetch_array($result);
	
	$assistantstring = '';
	
	foreach ($comicsettings as $Assistant) {
		$query = "SELECT encryptid from users where email='$Assistant'";
 		$result = mysql_query($query);
		$assistant = mysql_fetch_array($result);

		if ($assistant['encryptid'] != '') {
		if ($assistantstring == '') {
				$assistantstring = $assistant['encryptid'];
		} else {
				$assistantstring .= ','.$assistant['encryptid'];
		}
	}
		
	}
		
	echo $assistantstring;
	}
	
 } else {
 	echo 'Connection Failed!';
 }

?>


