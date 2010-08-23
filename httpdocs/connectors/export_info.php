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
$Type = $_POST['t'];
	if ($Type != 'story')
	$TargetFolder = 'comics';
	else
	$TargetFolder = 'stories';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
 //print "MY ACTION = ". $Action."<br>";

$query = "SELECT * from users where encryptid ='$UserID' and ConnectKey='$ConnectKey'";
 $result = mysql_query($query);
 //print $query;
 $Connected = mysql_num_rows($result);
 $user = mysql_fetch_array($result);
// print $query."<br/><br/>";
 if ($Connected == 1) {
 
// $query = "UPDATE users set ConnectKey='inactive' where encryptid ='$UserID'";
// $result = mysql_query($query);
 //print $query."<br/><br/>";
 
 if ($Type != 'story')
 $query = "SELECT * from comics where comiccrypt ='$ComicID' and (userid='$UserID' or CreatorID='$UserID')";
 else 
 	$query = "SELECT * from stories where StoryID ='$ComicID' and (userid='$UserID' or CreatorID='$UserID')";
 $result = mysql_query($query);
 $Authorized = mysql_num_rows($result);
 $comic = mysql_fetch_array($result);
 //print $query."<br/><br/>";
 $ComicFolder = $comic['HostedUrl'];
 $CreatorID = $comic['CreatorID'];
 
  $AppInstalltion = $comic['AppInstallation'];
	if ($Authorized == 0) {
	if ($Type != 'story')
		 $query = "SELECT * from comic_settings where ComicID ='$ComicID'";
	else 
		 $query = "SELECT * from story_settings where StoryID ='$ComicID'";
 		 $result = mysql_query($query);
		// print $query."<br/><br/>";
 		 $comicsettings = mysql_fetch_array($result);
		 $UserEmail = $user['email'];
		if (($UserEmail == $comicsettings['Assistant1']) || ($UserEmail == $comicsettings['Assistant2']) || ($UserEmail == $comicsettings['Assistant3'])) {
			$Authorized = 1;
			if ($Type != 'story')
			$query = "SELECT * from comics where comiccrypt ='$ComicID'";
			else 
			$query = "SELECT * from stories where StoryID ='$ComicID'";
 	 $result = mysql_query($query);
// print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 	$comic = mysql_fetch_array($result);
    $ComicFolder = $comic['HostedUrl'];
    $AppInstallation = $comic['AppInstallation'];
	 $CreatorID = $comic['CreatorID'];
		}
	}
	
	if ($Authorized == 1) {
		 $query = "SELECT * from Applications where ID='$AppInstalltion' and LicenseID='$License'";
 		 $result = mysql_query($query);
		// print $query."<br/><br/>";
 		 $Authorized = mysql_num_rows($result);
	}
 	
	if ($Authorized == 0) {
		echo 'Not Authorized';
	} else {
	
		if ($Section == 'Creator') {
 		$query = "SELECT * from users where encryptid ='$CreatorID'";
 		$result = mysql_query($query);
		//print $query."<br/><br/>";
 		$user = mysql_fetch_array($result);
		$CreatorEmail = $user['email'];
		if ($Type != 'story')
		$query = "SELECT * from creators as cr 
				  join comic_settings as cs on cr.ComicID=cs.ComicID
				  where cr.Email ='$CreatorEmail' and cr.ComicID='$ComicID'";
		else 
		$query = "SELECT * from creators as cr 
				  join story_settings as cs on cr.StoryID=cs.StoryID
				  where cr.Email ='$CreatorEmail' and cr.StoryID='$ComicID'";
 		$result = mysql_query($query);
		//print $query."<br/><br/>";
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
		'CreatorOne' =>  trim($page['CreatorOne']),
		'CreatorTwo' =>  trim($page['CreatorTwo']),
		'CreatorThree' =>  trim($page['CreatorThree']),
		'website' => trim($page['website']));
		echo serialize ($myValues);
	} else if ($Section == 'Comic') {
		if ($Type != 'story')
			$query = "SELECT * from comic_settings where ComicID='$ComicID'";
		else 
			$query = "SELECT * from story_settings where StoryID='$ComicID'";
 		$result = mysql_query($query);
		//print $query."<br/><br/>";
 		$comicsettings = mysql_fetch_array($result);
		$myValues = array (
 		'writer' => trim($comic['writer']),
		'genre' => trim($comic['genre']),
		'tags' => trim($comic['tags']),
		'synopsis' => trim($comic['synopsis']),
		'creator' =>  trim($comic['creator']),
		'artist' =>  trim($comic['artist']),
		'letterist' =>  trim($comic['letterist']),
		'colorist' =>  trim($comic['colorist']),
		'comicformat' =>  trim($comicsettings['ComicFormat']),
		'updateschedule' =>  trim($comicsettings['UpdateSchedule']),
		'skincode'=>trim($comicsettings['Skin']),
		'copyright' =>  trim($comicsettings['Copyright']),
		'template' =>  trim($comicsettings['Template']),
		'header' =>  $TargetFolder.'/'.$ComicFolder.'/images/'.trim($comicsettings['Header']));
		echo serialize ($myValues);
		
	 } else if ($Section == 'Install') {
	 	if ($Type != 'story')
		$query = "SELECT * from comic_settings where ComicID='$ComicID'";
		else 
		$query = "SELECT * from story_settings where StoryID='$ComicID'";
 		$result = mysql_query($query);
	//	print $query."<br/><br/>";
 		$comicsettings = mysql_fetch_array($result);
		if ($Type != 'story')
		$query = "SELECT Position from adspaces where ComicID='$ComicID' and Template='".$comicsettings['Template']."'";
 		else
		$query = "SELECT Position from adspaces where StoryID='$ComicID' and Template='".$comicsettings['Template']."'";

		$result = mysql_query($query);
		//print $query."<br/><br/>";
		$numads = mysql_num_rows($result);
		// print 'NUMBER OF AD POSITIONS IN ARRAY = ' . $numads."<br/><br/>";
		$AdString = '';
		while($adposition = mysql_fetch_array($result)){
				if ($AdString == '') {
					$AdString = $adposition['Position'];
				} else {
					$AdString .= ','. $adposition['Position'];
				}
		}

		
		
		//print '<b>MY AD STRING ON EXPORT = ' . $AdString ."</b><br/><br/><br/>";
		$query = "SELECT * from users where encryptid ='$CreatorID'";
 		$result = mysql_query($query);
 		$userinfo = mysql_fetch_array($result);
		//print $query."<br/><br/>";
		$myValues = array (
 		'comicformat' =>  trim($comicsettings['ComicFormat']),
		'updateschedule' =>  trim($comicsettings['UpdateSchedule']),
		'genre' => trim($comic['genre']),
		'skincode'=>trim($comicsettings['Skin']),
		'creatoremail'=>trim($userinfo['email']),
		'adpositions' =>  trim($AdString),
		'template' =>  trim($comicsettings['Template']),
		'title' =>  trim($comic['title']),
		'safefolder' =>  trim($comic['SafeFolder']),
		'sitebg' =>  trim($comicsettings['SiteBg']),
		'avatar' => trim($userinfo['avatar']),
		'location' => trim($userinfo['location']),
		'username' => trim($userinfo['realname']),
		'about' => trim($userinfo['about']),
		'music' =>  trim($userinfo['music']),
		'books' =>  trim($userinfo['books']),
		'influences' =>  trim($userinfo['influences']),
		'credits' =>  trim($userinfo['credits']),
		'hobbies' =>  trim($userinfo['hobbies']),
		'link1' =>  trim($userinfo['link1']),
		'link2' =>  trim($userinfo['link2']),
		'link3' =>  trim($userinfo['link3']),
		'link4' =>  trim($userinfo['link4']),
		'website' => trim($userinfo['website']));
		echo serialize ($myValues);
		if ($Type != 'story')
		$query = "UPDATE comics set installed=1 where comiccrypt='$ComicID'";
		else
		$query = "UPDATE stories set installed=1 where StoryID='$ComicID'";
 		$result = mysql_query($query);
		
		//print $query."<br/><br/>";
	 }

 	}
} else {
echo 'Connection Failed!';
}
?>