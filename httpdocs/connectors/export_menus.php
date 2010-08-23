<?php 
include '../includes/db.class.php';
//$userhost = 'localhost';
//$dbuser = 'panel_panel';
//$userpass ='pfout.08';
//$userdb = 'panel_panel';
$ComicID = $_POST['c'];
$License = $_POST['l'];
$ConnectKey = $_POST['k'];
$UserID = $_POST['u'];
$MenuID = $_POST['m'];
$ContentType = $_POST['t'];


//mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
//mysql_select_db ($userdb) or die ('Could not select database.');
$DB = new DB();
$query = "SELECT email from users where encryptid ='$UserID' and ConnectKey='$ConnectKey'";
//$result = mysql_query($query);
$UserEmail = $DB->queryUniqueValue($query);
//$Connected =$DB->numRows();
//$Connected = mysql_num_rows($result);
//$user = mysql_fetch_array($result);

if ($UserEmail != '') {

 	$query = "UPDATE users set ConnectKey='inactive' where encryptid ='$UserID'";
 	//$result = mysql_query($query);
	$DB->execute($query);
	if ($ContentType != 'story')
	$query = "SELECT * from comics as c 
			  JOIN comic_settings as cs on c.comiccrypt=cs.ComicID 
			  JOIN Applications as a on c.Appinstallation=a.ID 
			  JOIN menu_links as ml on ml.ComicID=c.comiccrypt 
			  where c.comiccrypt ='$ComicID' and (c.userid='$UserID' or c.CreatorID='$UserID') and ml.EncryptID='$MenuID'";
	else
	$query = "SELECT * from stories as c 
			  JOIN story_settings as cs on c.StoryID=cs.StoryID 
			  JOIN Applications as a on c.Appinstallation=a.ID 
			  JOIN menu_links as ml on ml.StoryID=c.StoryID 
			  where c.StoryID ='$ComicID' and (c.userid='$UserID' or c.CreatorID='$UserID') and ml.EncryptID='$MenuID'";
			  $comicsettings = $DB->queryUniqueObject($query);
			 
 	//$result = mysql_query($query);
	if ($ContentType != 'story'){
		if ($comicsettings->comiccrypt != '')
			$Authorized = 1;
	
	}else{
		if ($comicsettings->StoryID != '')
			$Authorized = 1;
	}
	//$Authorized = mysql_num_rows($result);
	//$Authorized = $DB->numRows();
	//$comicsettings = mysql_fetch_array($result);
	if ($Authorized == 0) {
		if ($ContentType != 'story')
		$query = "SELECT * from comic_settings where ComicID ='$ComicID'";
		else
		$query = "SELECT * from story_settings where StoryID ='$ComicID'";
			  $comic = $DB->queryUniqueObject($query);
		
	//	$UserEmail = $user['email'];
		if (($UserEmail == $comic->Assistant1) || ($UserEmail == $comic->Assistant2) || ($UserEmail == $comic->Assistant3)) {
			$Authorized = 1;
				if ($ContentType != 'story')
			$query = "SELECT * from comics as c 
			  JOIN comic_settings as cs on c.comiccrypt=cs.ComicID 
			  JOIN Applications as a on c.Appinstallation=a.ID 
			  JOIN menu_links as ml on ml.ComicID=c.comiccrypt 
			  where c.comiccrypt ='$ComicID' and (c.userid='$UserID' or c.CreatorID='$UserID') and ml.EncryptID='$MenuID' and ts.UserID='$UserID'";
			  else
			  $query = "SELECT * from stories as c 
			  JOIN story_settings as cs on c.StoryID=cs.StoryID 
			  JOIN Applications as a on c.Appinstallation=a.ID 
			  JOIN menu_links as ml on ml.StoryID=c.StoryID 
			  where c.StoryID ='$ComicID' and (c.userid='$UserID' or c.CreatorID='$UserID') and ml.EncryptID='$MenuID' and ts.UserID='$UserID'";
			 
			  $comicsettings = $DB->queryUniqueObject($query);
			
		}
	}
	if ($Authorized == 0) {
		echo 'Not Authorized';
	} else {

		$myValues = array (
		'Title' => trim($comicsettings->Title),
		'Url' => trim($comicsettings->Url),
		'LinkType' => trim($comicsettings->LinkType),
		'IsPublished' => trim($comicsettings->IsPublished),
		'Parent' => trim($comicsettings->Parent),
		'Position' => trim($comicsettings->Position),
		'ButtonImage' => trim($comicsettings->ButtonImage),
		'RolloverButtonImage' => trim($comicsettings->RolloverButtonImage),
		'MenuParent' => trim($comicsettings->MenuParent),
		'target' => trim($comicsettings->target));
		echo serialize ($myValues);
	}
 } else {
 	echo 'Connection Failed!';
 }

?>


