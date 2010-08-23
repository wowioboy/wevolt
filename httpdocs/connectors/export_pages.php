<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$ComicID = $_POST['c'];
$PageID = $_POST['p'];
$License = $_POST['l'];
$ConnectKey = $_POST['k'];
$UserID = $_POST['u'];
$Section = $_POST['s'];
$Sub = $_POST['sub'];
$Today = date('Ymd');
$Type = $_POST['t'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$query = "SELECT * from users where encryptid ='$UserID' and ConnectKey='$ConnectKey'";
$result = mysql_query($query);
//print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
$Connected = mysql_num_rows($result);
$user = mysql_fetch_array($result);
if ($Connected == 1) {
 if ($Sub != 'Batch') {
 	$query = "UPDATE users set ConnectKey='inactive' where encryptid ='$UserID'";
 	$result = mysql_query($query);
	//print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 }
 $query = "SELECT * from comics where comiccrypt ='$ComicID' and (userid='$UserID' or CreatorID='$UserID')";
 $result = mysql_query($query);
// print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 $Authorized = mysql_num_rows($result);
 $comic = mysql_fetch_array($result);
 $ComicFolder = $comic['HostedUrl'];
 $AppInstallation = $comic['AppInstallation'];
 if ($Authorized == 0) {
	$query = "SELECT * from comic_settings where ComicID ='$ComicID'";
 	$result = mysql_query($query);
	//print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
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
	 $query = "SELECT * from Applications where ID='$AppInstallation' and LicenseID='$License'";
 	 $result = mysql_query($query);
	// print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 	 $Authorized = mysql_num_rows($result);
 }
 	
 if ($Authorized == 0) {
		echo 'Not Authorized';
 } else {
 if (($Type == 'pages') || ($Type == 'extras')) {
 		$query = "SELECT * from comic_pages where EncryptPageID ='$PageID'";
 		$result = mysql_query($query);
	//	print 'EXPORT PAGES : ' . $query.'<br/><br/><br/>';
 		$page = mysql_fetch_array($result);
		$myValues = array (
		'title' => trim($page['Title']),
		'comment' => trim($page['Comment']),
		'filename' => trim($page['Image']),
		'imagedimensions' => trim($page['ImageDimensions']),
		'datelive' => trim($page['Datelive']),
		'thumbsm' => trim($page['ThumbSm']),
		'thumbmd' => trim($page['ThumbMd']),
		'thumblg' => trim($page['ThumbLg']),
		'chapter' => trim($page['Chapter']),
		'episode' => trim($page['Episode']),
		'episodedesc' => trim($page['EpisodeDesc']),
		'episodewriter' => trim($page['EpisodeWriter']),
		'episodecolorist' => trim($page['EpisodeColorist']),
		'episodeartist' => trim($page['EpisodeArtist']),
		'episodeletterer' => trim($page['EpisodeLetterer']),
		'PublishDate' => trim($page['PublishDate']),
		'pagetype' => trim($page['PageType']),
		'position' => trim($page['Position']),
		'pageimage' => trim('comics/'.$ComicFolder.'/images/pages/'.$page['Filename']));
		echo serialize ($myValues);
	} else if ($Sub != 'peel'){
		$query = "SELECT * from comic_pages where ParentPage ='$PageID' and PageType='$Type'";
 		$result = mysql_query($query);
 		$page = mysql_fetch_array($result);
		$myValues = array (
		'filename' => trim($page['Image']),
		'imagedimensions' => trim($page['ImageDimensions']),
		'thumbsm' => trim($page['ThumbSm']),
		'thumbmd' => trim($page['ThumbMd']),
		'thumblg' => trim($page['ThumbLg']),
		'pagetype' => trim($page['PageType']),
		'pageimage' => trim('comics/'.$ComicFolder.'/images/pages/'.$page['Filename']));
		echo serialize ($myValues);
	} else if ($Sub == 'peel') {
		echo 'Authorized';
	}
	
	}
} else {
 echo 'Connection Failed!';
}


?>


