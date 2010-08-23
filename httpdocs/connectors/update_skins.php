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
$SkinCode = $_POST['s'];
$ContentType = $_POST['type'];
$StoryID = $_POST['c'];
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
	if ($ContentType == 'story')
	$query = "SELECT * from stories as c 
			  JOIN story_settings as cs on c.StoryID=cs.StoryID 
			  JOIN Applications as a on c.Appinstallation=a.ID 
			  JOIN template_skins as ts on ts.SkinCode=cs.Skin 
			  where c.StoryID ='$StoryID' and (c.userid='$UserID' or c.CreatorID='$UserID') and ts.SkinCode='$SkinCode' and ts.UserID='$UserID'";
	
	else
	$query = "SELECT * from comics as c 
			  JOIN comic_settings as cs on c.comiccrypt=cs.ComicID 
			  JOIN Applications as a on c.Appinstallation=a.ID 
			  JOIN template_skins as ts on ts.SkinCode=cs.Skin 
			  where c.comiccrypt ='$ComicID' and (c.userid='$UserID' or c.CreatorID='$UserID') and ts.SkinCode='$SkinCode' and ts.UserID='$UserID'";
			  
			  $comicsettings = $DB->queryUniqueObject($query);
 	//$result = mysql_query($query);
			if ($ContentType == 'story')
				$TargetID = $comicsettings->StoryID;
			else
				$TargetID = $comicsettings->comiccrypt;
				
	if ($TargetID != '') {
		$Authorized = 1;
	}
	//$Authorized = mysql_num_rows($result);
	//$Authorized = $DB->numRows();
	//$comicsettings = mysql_fetch_array($result);
	if ($Authorized == 0) {
	if ($ContentType == 'story')
		$query = "SELECT * from story_settings where StoryID ='$StoryID'";
	else
		$query = "SELECT * from comic_settings where ComicID ='$ComicID'";
		
			  $comic = $DB->queryUniqueObject($query);
	//	$UserEmail = $user['email'];
		if (($UserEmail == $comic->Assistant1) || ($UserEmail == $comic->Assistant2) || ($UserEmail == $comic->Assistant3)) {
			$Authorized = 1;
			if ($ContentType == 'story')
			$query = "SELECT * from stories as c 
			  JOIN story_settings as cs on c.StoryID=cs.StoryID 
			  JOIN Applications as a on c.Appinstallation=a.ID 
			  JOIN template_skins as ts on ts.SkinCode=cs.Skin 
			  where c.StoryID ='$StoryID' and ts.SkinCode='$SkinCode'";
			  else
			  $query = "SELECT * from comics as c 
			  JOIN comic_settings as cs on c.comiccrypt=cs.ComicID 
			  JOIN Applications as a on c.Appinstallation=a.ID 
			  JOIN template_skins as ts on ts.SkinCode=cs.Skin 
			  where c.comiccrypt ='$ComicID' and ts.SkinCode='$SkinCode'";
			  $comicsettings = $DB->queryUniqueObject($query);
			
		}
	}
	if ($Authorized == 0) {
		echo 'Not Authorized';
	} else {

		$myValues = array (
		'Description' => trim($comicsettings->Description),
		'Title' => trim($comicsettings->Title),
		'Published' => trim($comicsettings->Published),
		'GlobalSiteBGColor' => trim($comicsettings->GlobalSiteBGColor),
		'GlobalSiteImageRepeat' => trim($comicsettings->GlobalSiteImageRepeat),
		'GlobalSiteTextColor' => trim($comicsettings->GlobalSiteTextColor),
		'GlobalSiteFontSize' => trim($comicsettings->GlobalSiteFontSize),
		'GlobalSiteWidth' => trim($comicsettings->GlobalSiteWidth),
		'KeepWidth' => trim($comicsettings->KeepWidth),
		'ButtonBGColor' => trim($comicsettings->ButtonBGColor),
		'ButtonTextColor' => trim($comicsettings->ButtonTextColor),
		'ButtonFontSize' => trim($comicsettings->ButtonFontSize),
		'ButtonFontStyle' => trim($comicsettings->ButtonFontStyle),
		'FirstButtonBGColor' => trim($comicsettings->FirstButtonBGColor),
		'FirstButtonTextColor' => trim($comicsettings->FirstButtonTextColor),
		'NextButtonBGColor' => trim($comicsettings->NextButtonBGColor),
		'NextButtonTextColor' => trim($comicsettings->NextButtonTextColor),
		'BackButtonBGColor' => trim($comicsettings->BackButtonBGColor),
		'BackButtonTextColor' => trim($comicsettings->BackButtonTextColor),			
		'LastButtonBGColor' => trim($comicsettings->LastButtonBGColor),
		'LastButtonTextColor' => trim($comicsettings->LastButtonTextColor),
		'HomeButtonBGColor' => trim($comicsettings->HomeButtonBGColor),
		'HomeButtonTextColor' => trim($comicsettings->HomeButtonTextColor),
		'CreatorButtonBGColor' => trim($comicsettings->CreatorButtonBGColor),
		'CreatorButtonTextColor' => trim($comicsettings->CreatorButtonTextColor),
		'CharactersButtonBGColor' => trim($comicsettings->CharactersButtonBGColor),	
		'CharactersButtonTextColor' => trim($comicsettings->CharactersButtonTextColor),	
		'DownloadsButtonBGColor' => trim($comicsettings->DownloadsButtonBGColor),
		'DownloadsButtonTextColor' => trim($comicsettings->DownloadsButtonTextColor),
		'ExtrasButtonBGColor' => trim($comicsettings->ExtrasButtonBGColor),
		'ExtrasButtonTextColor' => trim($comicsettings->ExtrasButtonTextColor),
		'EpisodesButtonBGColor' => trim($comicsettings->EpisodesButtonBGColor),
		'EpisodesButtonTextColor' => trim($comicsettings->EpisodesButtonTextColor),
		'MobileButtonBGColor' => trim($comicsettings->MobileButtonBGColor),	
		'MobileButtonTextColor' => trim($comicsettings->MobileButtonTextColor),	
		'CreatorButtonBGColor' => trim($comicsettings->CreatorButtonBGColor),
		'CreatorButtonTextColor' => trim($comicsettings->CreatorButtonTextColor),
		'BlogButtonBGColor' => trim($comicsettings->BlogButtonBGColor),
		'BlogButtonTextColor' => trim($comicsettings->BlogButtonTextColor),
		'ProductsButtonBGColor' => trim($comicsettings->ProductsButtonBGColor),	
		'ProductsButtonTextColor' => trim($comicsettings->ProductsButtonTextColor),	
		'CommentButtonBGColor' => trim($comicsettings->CommentButtonBGColor),
		'CommentButtonTextColor' => trim($comicsettings->CommentButtonTextColor),
		'VoteButtonBGColor' => trim($comicsettings->VoteButtonBGColor),
		'VoteButtonTextColor' => trim($comicsettings->VoteButtonTextColor),
		'LogoutButtonBGColor' => trim($comicsettings->LogoutButtonBGColor),
		'LogoutButtonTextColor' => trim($comicsettings->LogoutButtonTextColor),
		'ModTopRightBGColor' => trim($comicsettings->ModTopRightBGColor),	
		'ModTopLeftBGColor' => trim($comicsettings->ModTopLeftBGColor),
		'ModBottomLeftBGColor' => trim($comicsettings->ModBottomLeftBGColor),	
		'ProductsButtonTextColor' => trim($comicsettings->ProductsButtonTextColor),	
		'ProductsButtonTextColor' => trim($comicsettings->ProductsButtonTextColor),	
		'ModBottomRightBGColor' => trim($comicsettings->ModBottomRightBGColor),
		'ModRightSideBGColor' => trim($comicsettings->ModRightSideBGColor),
		'ModLeftSideBGColor' => trim($comicsettings->ModLeftSideBGColor),
		'ModTopBGColor' => trim($comicsettings->ModTopBGColor),
		'ModBottomBGColor' => trim($comicsettings->ModBottomBGColor),
		'ContentBoxBGColor' => trim($comicsettings->ContentBoxBGColor),
		'ContentBoxImageRepeat' => trim($comicsettings->ContentBoxImageRepeat),	
		'ContentBoxTextColor' => trim($comicsettings->ContentBoxTextColor),
		'ContentBoxFontSize' => trim($comicsettings->ContentBoxFontSize),
		'ModuleSeparation' => trim($comicsettings->ModuleSeparation),
		'RightColumWidth' => trim($comicsettings->RightColumWidth),
		'LeftColumWidth' => trim($comicsettings->LeftColumWidth),
		'LogoutButtonTextColor' => trim($comicsettings->LogoutButtonTextColor),
		'ModTopRightBGColor' => trim($comicsettings->ModTopRightBGColor),	
		'ModTopLeftBGColor' => trim($comicsettings->ModTopLeftBGColor),
		'ModBottomLeftBGColor' => trim($comicsettings->ModBottomLeftBGColor),	
		'ModBottomRightBGColor' => trim($comicsettings->ModBottomRightBGColor),
		'ModRightSideBGColor' => trim($comicsettings->ModRightSideBGColor),
		'ModLeftSideBGColor' => trim($comicsettings->ModLeftSideBGColor),
		'ModTopBGColor' => trim($comicsettings->ModTopBGColor),
		'ModBottomBGColor' => trim($comicsettings->ModBottomBGColor), 
		'GlobalHeaderBGColor' => trim($comicsettings->GlobalHeaderBGColor),
		'GlobalHeaderImageRepeat' => trim($comicsettings->GlobalHeaderImageRepeat),	
		'GlobalHeaderTextColor' => trim($comicsettings->GlobalHeaderTextColor),
		'GlobalHeaderFontSize' => trim($comicsettings->GlobalHeaderFontSize),
		'GlobalHeaderFontStyle' => trim($comicsettings->GlobalHeaderFontStyle),
		'GlobalHeaderTextTransformation' => trim($comicsettings->GlobalHeaderTextTransformation),
		'FlashReaderStyle' => trim($comicsettings->FlashReaderStyle),
		'NavBarPlacement' => trim($comicsettings->NavBarPlacement),
		'NavBarAlignment' => trim($comicsettings->NavBarAlignment),
		'HeaderPlacement' => trim($comicsettings->HeaderPlacement),
		'LeftColumnWidth' => trim($comicsettings->LeftColumnWidth),
		'RightColumnWidth' => trim($comicsettings->RightColumnWidth),
		'AuthorCommentBGColor' => trim($comicsettings->AuthorCommentBGColor),
		'AuthorCommentImageRepeat' => trim($comicsettings->AuthorCommentImageRepeat),	
		'AuthorCommentTextColor' => trim($comicsettings->AuthorCommentTextColor),
		'AuthorCommentFontSize' => trim($comicsettings->AuthorCommentFontSize),	
		'AuthorCommentFontStyle' => trim($comicsettings->AuthorCommentFontStyle),	
		'ComicInfoBGColor' => trim($comicsettings->ComicInfoBGColor),
		'ComicInfoImageRepeat' => trim($comicsettings->ComicInfoImageRepeat),
		'ComicInfoTextColor' => trim($comicsettings->ComicInfoTextColor),
		'ComicInfoFontSize' => trim($comicsettings->ComicInfoFontSize),
		'ComicInfoFontStyle' => trim($comicsettings->ComicInfoFontStyle),
		'UserCommentsBGColor' => trim($comicsettings->UserCommentsBGColor),
		'UserCommentsImageRepeat' => trim($comicsettings->UserCommentsImageRepeat),	
		'UserCommentsTextColor' => trim($comicsettings->UserCommentsTextColor),
		'UserCommentsFontSize' => trim($comicsettings->UserCommentsFontSize),
		'UserCommentsFontStyle' => trim($comicsettings->UserCommentsFontStyle),
		'ComicSynopsisBGColor' => trim($comicsettings->ComicSynopsisBGColor),
		'ComicSynopsisImageRepeat' => trim($comicsettings->ComicSynopsisImageRepeat),
		'ComicSynopsisTextColor' => trim($comicsettings->ComicSynopsisTextColor),
		'ComicSynopsisFontSize' => trim($comicsettings->ComicSynopsisFontSize),
		'ComicSynopsisFontStyle' => trim($comicsettings->ComicSynopsisFontStyle),	
		'ControlBarImageRepeat' => trim($comicsettings->ControlBarImageRepeat),
		'ControlBarBGColor' => trim($comicsettings->ControlBarBGColor),	
		'ControlBarTextColor' => trim($comicsettings->ControlBarTextColor),	
		'ControlBarFontSize' => trim($comicsettings->ControlBarFontSize),
		'ControlBarFontStyle' => trim($comicsettings->ControlBarFontStyle),
		'ReaderButtonBGColor' => trim($comicsettings->ReaderButtonBGColor),
		'ReaderButtonAccentColor' => trim($comicsettings->ReaderButtonAccentColor),
		'GlobalSiteLinkTextColor' => trim($comicsettings->GlobalSiteLinkTextColor),
		'GlobalSiteLinkFontStyle' => trim($comicsettings->GlobalSiteLinkFontStyle),
		'GlobalSiteHoverTextColor' => trim($comicsettings->GlobalSiteHoverTextColor),
		'GlobalSiteHoverFontStyle' => trim($comicsettings->GlobalSiteHoverFontStyle),
		'GlobalSiteVisitedTextColor' => trim($comicsettings->GlobalSiteVisitedTextColor),
		'GlobalSiteVisitedFontStyle' => trim($comicsettings->GlobalSiteVisitedFontStyle),
		'GlobalButtonLinkTextColor' => trim($comicsettings->GlobalButtonLinkTextColor),
		'GlobalButtonLinkFontStyle' => trim($comicsettings->GlobalButtonLinkFontStyle),
		'GlobalButtonHoverTextColor' => trim($comicsettings->GlobalButtonHoverTextColor),
		'GlobalButtonHoverFontStyle' => trim($comicsettings->GlobalButtonHoverFontStyle),
		'GlobalButtonVisitedTextColor' => trim($comicsettings->GlobalButtonVisitedTextColor),
		'GlobalButtonVisitedFontStyle' => trim($comicsettings->GlobalButtonVisitedFontStyle),
		'GlobalTabInActiveBGColor' => trim($comicsettings->GlobalTabInActiveBGColor),
		'GlobalTabInActiveFontStyle' => trim($comicsettings->GlobalTabInActiveFontStyle),
		'GlobalTabInActiveTextColor' => trim($comicsettings->GlobalTabInActiveTextColor),
		'GlobalTabInActiveFontSize' => trim($comicsettings->GlobalTabInActiveFontSize),
		'GlobalTabActiveBGColor' => trim($comicsettings->GlobalTabActiveBGColor),
		'GlobalTabActiveFontStyle' => trim($comicsettings->GlobalTabActiveFontStyle),
		'GlobalTabActiveTextColor' => trim($comicsettings->GlobalTabActiveTextColor),
		'GlobalTabActiveFontSize' => trim($comicsettings->GlobalTabActiveFontSize),
		'GlobalTabHoverBGColor' => trim($comicsettings->GlobalTabHoverBGColor),
		'GlobalTabHoverFontStyle' => trim($comicsettings->GlobalTabHoverFontStyle),
		'GlobalTabHoverTextColor' => trim($comicsettings->GlobalTabHoverTextColor),
		'GlobalTabHoverFontSize' => trim($comicsettings->GlobalTabHoverFontSize),
		'CharacterReader' => trim($comicsettings->CharacterReader),
		'MobileContentBGColor' => trim($comicsettings->MobileContentBGColor),
		'MobileContentImageRepeat' => trim($comicsettings->MobileContentImageRepeat),
		'MobileContentTextColor' => trim($comicsettings->MobileContentTextColor),
		'MobileContentFontSize' => trim($comicsettings->MobileContentFontSize),
		'MobileContentFontStyle' => trim($comicsettings->MobileContentFontStyle),
		'ProductsBGColor' => trim($comicsettings->ProductsBGColor),
		'ProductsImageRepeat' => trim($comicsettings->ProductsImageRepeat),
		'ProductsTextColor' => trim($comicsettings->ProductsTextColor),
		'ProductsFontSize' => trim($comicsettings->ProductsFontSize),
		'ProductsFontStyle' => trim($comicsettings->ProductsFontStyle),
		'BubbleClose' => trim($comicsettings->BubbleClose),
		'BubbleOpen' => trim($comicsettings->BubbleOpen),
		'HotSpotBGColor' => trim($comicsettings->HotSpotBGColor),
		'PageBGColor' => trim($comicsettings->PageBGColor),
		'MenuOneType' =>$comicsettings->MenuOneType,
		'MenuOneLayout' =>$comicsettings->MenuOneLayout,
		'MenuOneCustom' =>$comicsettings->MenuOneCustom,
		'MenuTwoType' =>$comicsettings->MenuTwoType,
		'MenuTwoLayout' =>$comicsettings->MenuTwoLayout,
		'MenuTwoCustom' =>$comicsettings->MenuTwoCustom);
		
		echo serialize ($myValues);
	}
 } else {
 	echo 'Connection Failed!';
 }

?>


