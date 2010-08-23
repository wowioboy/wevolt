<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$ComicID = $_POST['c'];
$ItemID = $_POST['p'];
$UserID = $_POST['u'];
$Section = $_POST['s'];
$License = $_POST['l'];
$ConnectKey = $_POST['k'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
 //print "MY ACTION = ". $Action."<br>";

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
		 $ComicFolder = $comic['HostedUrl'];
		 $CreatorID = $comic['CreatorID'];
		 $AppInstalltion = $comic['AppInstallation'];
			if ($Authorized == 0) {
				 $query = "SELECT * from comic_settings where ComicID ='$ComicID'";
				 $result = mysql_query($query);
				 $comicsettings = mysql_fetch_array($result);
				 $UserEmail = $user['email'];
				if (($UserEmail == $comicsettings['Assistant1']) || ($UserEmail == $comicsettings['Assistant2']) || ($UserEmail == $comicsettings['Assistant3'])) {
					$Authorized = 1;
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
				$query = "SELECT * from users where encryptid ='$CreatorID'";
				$result = mysql_query($query);
				$page = mysql_fetch_array($result);
				$myValues = array (
				'avatar' => trim($page['avatar']),
				'location' => trim($page['location']),
				'username' => trim($page['realname']),
				'about' => trim($page['about']),
				'music' =>  trim($page['music']),
				'books' =>  trim($page['books']),
				'influences' =>  trim($page['influences']),
				'credits' =>  trim($page['credits']),
				'hobbies' =>  trim($page['hobbies']),
				'link1' =>  trim($page['link1']),
				'link2' =>  trim($page['link2']),
				'link3' =>  trim($page['link3']),
				'link4' =>  trim($page['link4']),
				'email' =>  trim($page['email']),
				'cid' =>  trim($page['encryptid']),
				'website' => trim($page['website']));
				echo serialize ($myValues);
		
		 }
 } else {
	 echo 'Connection Failed';
 }
?>