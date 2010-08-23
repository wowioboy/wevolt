<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$StoryID = $_POST['c'];
$ItemID = $_POST['p'];
$UserID = $_POST['u'];
$Section = $_POST['s'];
$License = $_POST['l'];
$ConnectKey = $_POST['k'];


mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
// print "MY ACTION = ". $Action."<br>";
$query = "SELECT * from users where encryptid ='$UserID' and ConnectKey='$ConnectKey'";
 $result = mysql_query($query);
 $Connected = mysql_num_rows($result);
 $user = mysql_fetch_array($result);
 
 if ($Connected == 1) {
 
 $query = "UPDATE users set ConnectKey='inactive' where encryptid ='$UserID'";
 $result = mysql_query($query);
 
 $query = "SELECT * from stories where StoryID ='$StoryID' and (userid='$UserID' or CreatorID='$UserID')";
 $result = mysql_query($query);
 $Authorized = mysql_num_rows($result);
 $comic = mysql_fetch_array($result);
 $AppInstalltion = $comic['AppInstallation'];
	if ($Authorized == 0) {
		 $query = "SELECT * from story_settings where StoryID ='$StoryID'";
 		 $result = mysql_query($query);
 		 $comicsettings = mysql_fetch_array($result);
		 $UserEmail = $user['email'];
		if (($UserEmail == $comicsettings['Assistant1']) || ($UserEmail == $comicsettings['Assistant2']) || ($UserEmail == $comicsettings['Assistant3'])) {
			$Authorized = 1;
			$query = "SELECT * from stories where StoryID ='$StoryID'";
 	 $result = mysql_query($query);
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
				$query = "SELECT * from story_pages where EncryptPageID='$ItemID' and StoryID='$StoryID'";
				$result = mysql_query($query);
				$post = mysql_fetch_array($result);
				
				$myValues = array (
				'PublishDate' => trim($post['PublishDate']),
				'Title' => trim($post['Title']),
				'Position' => trim($post['Position']),
				'Episode' => trim($post['Episode']),
				'Chapter' => trim($post['Chapter']),
				'Filename' => trim($post['Filename']));
	
		echo serialize ($myValues);
}
} else {
 echo 'Connection Failed!';
}

?>


