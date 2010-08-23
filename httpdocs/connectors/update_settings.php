<? 
include '../includes/db.class.php';
$ComicID = $_POST['c'];
$StoryID = $_POST['c'];
$License = $_POST['l'];
$ConnectKey = $_POST['k'];
$UserID = $_POST['u'];
$ContentType = $_POST['t'];


$DB = new DB();
$query = "SELECT email from users where encryptid ='$UserID' and ConnectKey='$ConnectKey'";
$UserEmail = $DB->queryUniqueValue($query);

if ($UserEmail != '') {
 	$query = "UPDATE users set ConnectKey='inactive' where encryptid ='$UserID'";
	$DB->execute($query);
	if ($ContentType == 'story')
		$query = "SELECT * from stories as c 
			  JOIN story_settings as cs on c.StoryID=cs.StoryID 
			  where c.StoryID ='$StoryID' and (c.userid='$UserID' or c.CreatorID='$UserID')";
	
	else
	$query = "SELECT * from comics as c 
			  JOIN comic_settings as cs on c.comiccrypt=cs.ComicID 
			  where c.comiccrypt ='$ComicID' and (c.userid='$UserID' or c.CreatorID='$UserID')";
			  $comicsettings = $DB->queryUniqueObject($query);
	if ($comicsettings->comiccrypt != '') {
		$Authorized = 1;
	}
	
	if ($Authorized == 0) {
		if (($UserEmail == $comicsettings->Assistant1) || ($UserEmail == $comicsettings->Assistant2) || ($UserEmail == $comicsettings->Assistant3)) {
			$Authorized = 1;
			if ($ContentType == 'story')
				$query = "SELECT * from stories as c 
			  JOIN story_settings as cs on c.StoryID=cs.StoryID 
			  where c.StoryID ='$StoryID'";
			else
			$query = "SELECT * from comics as c 
			  JOIN comic_settings as cs on c.comiccrypt=cs.ComicID 
			  where c.comiccrypt ='$ComicID'";
			  $comicsettings = $DB->queryUniqueObject($query);
		}
	}
 	
	if ($Authorized == 0) {
		echo 'Not Authorized';
	} else {
		$myValues = array (
	 'contact' => trim($comicsettings->Contact),
	 'allowcomments' => trim($comicsettings->AllowComments),
	 'publiccomments' => trim($comicsettings->AllowPublicComents),
	 
	 'archive' => trim($comicsettings->ShowArchive),
	 'chapter' => trim($comicsettings->ShowChapter),
	 'ShowSchedule' => trim($comicsettings->ShowSchedule),
	 'episode' => trim($comicsettings->ShowEpisode),
	 'calendar' => trim($comicsettings->ShowCalendar),
	 'biosetting' => trim($comicsettings->BioSetting),
	 'assistant1' => trim($comicsettings->Assistant1),
	 'assistant2' => trim($comicsettings->Assistant2),
	 'assistant3' => trim($comicsettings->Assistant3),
	 'template' => trim($comicsettings->Template),
	  'HomepageActive' => trim($comicsettings->HomepageActive),
	 'HomepageType' => trim($comicsettings->HomepageType),
	 'HomepageHTML' => trim($comicsettings->HomepageHTML),
	 'readertype' => trim($comicsettings->ReaderType));
	echo serialize ($myValues);
	}
	
 } else {
 	echo 'Connection Failed!';
 }

?>


