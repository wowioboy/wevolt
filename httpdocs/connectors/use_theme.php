<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
include  $_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php';
include  $_SERVER['DOCUMENT_ROOT'].'/includes/file_functions.php';

$ReturnLink = $_GET['returnlink'];
$RePost = 0;
$UserID = $_SESSION['userid'];
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$ProjectID = $_GET['project'];
$Theme = $_GET['theme'];
if ($ProjectID == '')
	$ProjectID = $_POST['txtProject'];
if ($Theme == '')
	$Theme = $_POST['txtTheme'];
$CloseWindow = 0;

if (($_POST['install'] == 1) && ($ProjectID != '')) {

$query = "SELECT * from pf_themes where ID='$Theme'";
$ThemeArray = $DB->queryUniqueObject($query);
$SkinCode = $ThemeArray->SkinCode;
$TemplateCode = $ThemeArray->TemplateCode;

$query ="SELECT * from projects where ProjectID='$ProjectID'";
$ProjectArray = $DB->queryUniqueObject($query);

$query ="SELECT ID from project_skins WHERE ID=(SELECT MAX(ID) FROM project_skins)";
$MaxID = $DB->queryUniqueValue($query);
		if ($MaxID > 9) {
				if ($MaxID > 99) {
					if ($MaxID > 999) {
						if ($MaxID > 9999) {
							if ($MaxID > 99999) {
								if ($MaxID > 999999) {
									echo 'Not Able To Add Skin Too Many IDS';
								} else {
									$NewSkinCode = 'PFPSK-'.($MaxID+1);
								}
							} else {
								$NewSkinCode = 'PFPSK-0'.($MaxID+1);
							}
						} else {
							$NewSkinCode = 'PFPSK-00'.($MaxID+1);
						}
					} else {
						$NewSkinCode = 'PFPSK-000'.($MaxID+1);
						//print 'NewSkinCode' .$NewSkinCode;
					}
				} else {
					$NewSkinCode = 'PFPSK-0000'.($MaxID+1);
					//print 'NewSkinCode' .$NewSkinCode;
				}
			} else {
			
				$NewSkinCode = 'PFPSK-00000'.($MaxID+1);
				//print 'NewSkinCode' .$NewSkinCode;
			}
		
		$base_path = "templates/skins/".$SkinCode.'/images/';
		$query = 'SHOW COLUMNS FROM template_skins;';
		$results = mysql_query($query);
		$query ="INSERT INTO project_skins (Title, Description, ModTopRightImage, ModTopRightBGColor, ModTopLeftImage, ModTopLeftBGColor, ModBottomLeftImage, ModBottomLeftBGColor, ModBottomRightImage, ModBottomRightBGColor, ModRightSideImage, ModRightSideBGColor, ModLeftSideImage, ModLeftSideBGColor, ModTopImage, ModTopBGColor, ModBottomImage, ModBottomBGColor, ContentBoxImage, ContentBoxImageRepeat, ContentBoxBGColor, ContentBoxTextColor, ContentBoxFontSize, ContentBoxFontFamily, ContentBoxAlign, Corner, ModuleSeparation, LeftColumnWidth, RightColumnWidth, ControlBarImage, ControlBarImageRepeat, ControlBarBGColor, ControlBarTextColor, ControlBarFontSize, ControlBarFontStyle, ReaderButtonBGColor, ReaderButtonAccentColor, PageBGColor, GlobalSiteBGColor, GlobalSiteBGImage, GlobalSiteBGPosition, GlobalSiteImageRepeat, GlobalSiteTextColor, GlobalSiteFontSize, GlobalSiteWidth, KeepWidth, ButtonImage, ButtonBGColor, ButtonTextColor, ButtonImageRepeat, ButtonFontSize, ButtonFontStyle, ButtonFontFamily, CommentButtonImage, CommentButtonRolloverImage, CommentButtonBGColor, CommentButtonTextColor, VoteButtonImage, VoteButtonBGColor, VoteButtonTextColor, VoteButtonRolloverImage, LogoutButtonImage, LogoutButtonRolloverImage, LogoutButtonBGColor, LogoutButtonTextColor, FirstButtonImage, FirstButtonRolloverImage, FirstButtonBGColor, FirstButtonTextColor, NextButtonImage, NextButtonRolloverImage, NextButtonBGColor, NextButtonTextColor, BackButtonImage, BackButtonRolloverImage, BackButtonBGColor, BackButtonTextColor, LastButtonImage, LastButtonRolloverImage, LastButtonBGColor, LastButtonTextColor, HomeButtonImage, HomeButtonRolloverImage, HomeButtonBGColor, HomeButtonTextColor, CreatorButtonImage, CreatorButtonRolloverImage, CreatorButtonBGColor, CreatorButtonTextColor, CharactersButtonImage, CharactersButtonRolloverImage, CharactersButtonBGColor, CharactersButtonTextColor, DownloadsButtonImage, DownloadsButtonRolloverImage, DownloadsButtonBGColor, DownloadsButtonTextColor, ExtrasButtonImage, ExtrasButtonRolloverImage, ExtrasButtonBGColor, ExtrasButtonTextColor, EpisodesButtonImage, EpisodesButtonRolloverImage, EpisodesButtonBGColor, EpisodesButtonTextColor, MobileButtonImage, MobileButtonRolloverImage, MobileButtonBGColor, MobileButtonTextColor, ProductsButtonImage, ProductsButtonRolloverImage, ProductsButtonBGColor, ProductsButtonTextColor, GlobalHeaderImage, GlobalHeaderBGColor, GlobalHeaderImageRepeat, GlobalHeaderTextColor, GlobalHeaderFontSize, HeaderPlacement, AuthorCommentImage, AuthorCommentBGColor, AuthorCommentImageRepeat, AuthorCommentTextColor, AuthorCommentFontSize, AuthorCommentFontStyle, ComicInfoImage, ComicInfoBGColor, ComicInfoImageRepeat, ComicInfoTextColor, ComicInfoFontSize, ComicInfoFontStyle, UserCommentsImage, UserCommentsBGColor, UserCommentsImageRepeat, UserCommentsTextColor, UserCommentsFontSize, UserCommentsFontStyle, ComicSynopsisImage, ComicSynopsisBGColor, ComicSynopsisImageRepeat, ComicSynopsisTextColor, ComicSynopsisFontSize, ComicSynopsisFontStyle, GlobalHeaderFontStyle, GlobalHeaderFontFamily, GlobalSiteLinkTextColor, GlobalSiteLinkFontStyle, GlobalSiteHoverTextColor, GlobalSiteHoverFontStyle, GlobalSiteVisitedTextColor, GlobalSiteVisitedFontStyle, GlobalButtonLinkTextColor, GlobalButtonLinkFontStyle, GlobalButtonHoverTextColor, GlobalButtonHoverFontStyle, GlobalButtonVisitedTextColor, GlobalButtonVisitedFontStyle, GlobalTabActiveBGColor, GlobalTabActiveFontStyle, GlobalTabActiveTextColor, GlobalTabActiveFontSize, GlobalTabInActiveBGColor, GlobalTabInActiveFontStyle, GlobalTabInActiveTextColor, GlobalTabInActiveFontSize, GlobalTabHoverBGColor, GlobalTabHoverFontStyle, GlobalTabHoverTextColor, GlobalTabHoverFontSize, FlashReaderStyle, NavBarPlacement, NavBarAlignment, GlobalHeaderTextTransformation, CharacterReader, MobileContentImage, MobileContentBGColor, MobileContentImageRepeat, MobileContentTextColor, MobileContentFontSize, MobileContentFontStyle, ProductsImage, ProductsBGColor, ProductsImageRepeat, ProductsTextColor, ProductsFontSize, ProductsFontStyle, BubbleClose, BubbleOpen, HotSpotImage, HotSpotBGColor, LatestPageHeader, BlogButtonImage, BlogButtonBGColor, BlogButtonTextColor, BlogButtonRolloverImage) SELECT Title, Description, ModTopRightImage, ModTopRightBGColor, ModTopLeftImage, ModTopLeftBGColor, ModBottomLeftImage, ModBottomLeftBGColor, ModBottomRightImage, ModBottomRightBGColor, ModRightSideImage, ModRightSideBGColor, ModLeftSideImage, ModLeftSideBGColor, ModTopImage, ModTopBGColor, ModBottomImage, ModBottomBGColor, ContentBoxImage, ContentBoxImageRepeat, ContentBoxBGColor, ContentBoxTextColor, ContentBoxFontSize, ContentBoxFontFamily, ContentBoxAlign, Corner, ModuleSeparation, LeftColumnWidth, RightColumnWidth, ControlBarImage, ControlBarImageRepeat, ControlBarBGColor, ControlBarTextColor, ControlBarFontSize, ControlBarFontStyle, ReaderButtonBGColor, ReaderButtonAccentColor, PageBGColor, GlobalSiteBGColor, GlobalSiteBGImage, GlobalSiteBGPosition, GlobalSiteImageRepeat, GlobalSiteTextColor, GlobalSiteFontSize, GlobalSiteWidth, KeepWidth, ButtonImage, ButtonBGColor, ButtonTextColor, ButtonImageRepeat, ButtonFontSize, ButtonFontStyle, ButtonFontFamily, CommentButtonImage, CommentButtonRolloverImage, CommentButtonBGColor, CommentButtonTextColor, VoteButtonImage, VoteButtonBGColor, VoteButtonTextColor, VoteButtonRolloverImage, LogoutButtonImage, LogoutButtonRolloverImage, LogoutButtonBGColor, LogoutButtonTextColor, FirstButtonImage, FirstButtonRolloverImage, FirstButtonBGColor, FirstButtonTextColor, NextButtonImage, NextButtonRolloverImage, NextButtonBGColor, NextButtonTextColor, BackButtonImage, BackButtonRolloverImage, BackButtonBGColor, BackButtonTextColor, LastButtonImage, LastButtonRolloverImage, LastButtonBGColor, LastButtonTextColor, HomeButtonImage, HomeButtonRolloverImage, HomeButtonBGColor, HomeButtonTextColor, CreatorButtonImage, CreatorButtonRolloverImage, CreatorButtonBGColor, CreatorButtonTextColor, CharactersButtonImage, CharactersButtonRolloverImage, CharactersButtonBGColor, CharactersButtonTextColor, DownloadsButtonImage, DownloadsButtonRolloverImage, DownloadsButtonBGColor, DownloadsButtonTextColor, ExtrasButtonImage, ExtrasButtonRolloverImage, ExtrasButtonBGColor, ExtrasButtonTextColor, EpisodesButtonImage, EpisodesButtonRolloverImage, EpisodesButtonBGColor, EpisodesButtonTextColor, MobileButtonImage, MobileButtonRolloverImage, MobileButtonBGColor, MobileButtonTextColor, ProductsButtonImage, ProductsButtonRolloverImage, ProductsButtonBGColor, ProductsButtonTextColor, GlobalHeaderImage, GlobalHeaderBGColor, GlobalHeaderImageRepeat, GlobalHeaderTextColor, GlobalHeaderFontSize, HeaderPlacement, AuthorCommentImage, AuthorCommentBGColor, AuthorCommentImageRepeat, AuthorCommentTextColor, AuthorCommentFontSize, AuthorCommentFontStyle, ComicInfoImage, ComicInfoBGColor, ComicInfoImageRepeat, ComicInfoTextColor, ComicInfoFontSize, ComicInfoFontStyle, UserCommentsImage, UserCommentsBGColor, UserCommentsImageRepeat, UserCommentsTextColor, UserCommentsFontSize, UserCommentsFontStyle, ComicSynopsisImage, ComicSynopsisBGColor, ComicSynopsisImageRepeat, ComicSynopsisTextColor, ComicSynopsisFontSize, ComicSynopsisFontStyle, GlobalHeaderFontStyle, GlobalHeaderFontFamily, GlobalSiteLinkTextColor, GlobalSiteLinkFontStyle, GlobalSiteHoverTextColor, GlobalSiteHoverFontStyle, GlobalSiteVisitedTextColor, GlobalSiteVisitedFontStyle, GlobalButtonLinkTextColor, GlobalButtonLinkFontStyle, GlobalButtonHoverTextColor, GlobalButtonHoverFontStyle, GlobalButtonVisitedTextColor, GlobalButtonVisitedFontStyle, GlobalTabActiveBGColor, GlobalTabActiveFontStyle, GlobalTabActiveTextColor, GlobalTabActiveFontSize, GlobalTabInActiveBGColor, GlobalTabInActiveFontStyle, GlobalTabInActiveTextColor, GlobalTabInActiveFontSize, GlobalTabHoverBGColor, GlobalTabHoverFontStyle, GlobalTabHoverTextColor, GlobalTabHoverFontSize, FlashReaderStyle, NavBarPlacement, NavBarAlignment, GlobalHeaderTextTransformation, CharacterReader, MobileContentImage, MobileContentBGColor, MobileContentImageRepeat, MobileContentTextColor, MobileContentFontSize, MobileContentFontStyle, ProductsImage, ProductsBGColor, ProductsImageRepeat, ProductsTextColor, ProductsFontSize, ProductsFontStyle, BubbleClose, BubbleOpen, HotSpotImage, HotSpotBGColor, LatestPageHeader, BlogButtonImage, BlogButtonBGColor, BlogButtonTextColor, BlogButtonRolloverImage FROM template_skins WHERE SkinCode = '".$SkinCode."'";

		mysql_query($query);
		//print $query.'<br/><br/>';
		$new_id = mysql_insert_id();
		$query = "UPDATE project_skins set Title='".$ThemeArray->Title."', SkinCode='$NewSkinCode', UserID='".$_SESSION['userid']."', ThemeID='$Theme' WHERE ID='$new_id'";
		$DB->execute($query);
		//print $query.'<br/><br/>';
		$dirsource = $_SERVER['DOCUMENT_ROOT']."/templates/skins/".$SkinCode;
		$dirdest = $_SERVER['DOCUMENT_ROOT']."/templates/skins/".$NewSkinCode;
		COPY_RECURSIVE_DIRS($dirsource, $dirdest);
		
		$query ="UPDATE comic_settings set CurrentTheme='$Theme',Skin='$NewSkinCode', Template='$TemplateCode' where ProjectID='$ProjectID'";
		$DB->execute($query);
	//	print $query.'<br/><br/>';
		$query ="INSERT INTO template_settings (ThemeID, TemplateCode, TemplateWidth, HeaderImage, HeaderBackground, HeaderBackgroundRepeat, HeaderWidth, HeaderHeight, HeaderContent, HeaderLink, HeaderRollover, MenuAlign, MenuVAlign, MenuPadding, MenuBackgroundImagePosition, HeaderAlign, HeaderVAlign, HeaderPadding, HeaderBackgroundImagePosition, MenuBackground, MenuBackgroundRepeat, MenuHeight, MenuWidth, MenuContent, ContentAlign, ContentVAlign, ContentPadding, ContentBackgroundImagePosition, ContentBackground, ContentBackgroundRepeat, ContentWidth, ContentHeight, ContentScroll, FooterAlign, FooterVAlign, FooterPadding, FooterBackgroundImagePosition, FooterImage, FooterBackground, FooterBackgroundRepeat, FooterWidth, FooterHeight, FooterContent) SELECT ThemeID, TemplateCode, TemplateWidth, HeaderImage, HeaderBackground, HeaderBackgroundRepeat, HeaderWidth, HeaderHeight, HeaderContent, HeaderLink, HeaderRollover, MenuAlign, MenuVAlign, MenuPadding, MenuBackgroundImagePosition, HeaderAlign, HeaderVAlign, HeaderPadding, HeaderBackgroundImagePosition, MenuBackground, MenuBackgroundRepeat, MenuHeight, MenuWidth, MenuContent, ContentAlign, ContentVAlign, ContentPadding, ContentBackgroundImagePosition, ContentBackground, ContentBackgroundRepeat, ContentWidth, ContentHeight, ContentScroll, FooterAlign, FooterVAlign, FooterPadding, FooterBackgroundImagePosition, FooterImage, FooterBackground, FooterBackgroundRepeat, FooterWidth, FooterHeight, FooterContent from template_settings where ThemeID='$Theme' and TemplateCode='$TemplateCode' and ProjectID=''";
		mysql_query($query);
//	print $query.'<br/><br/>';
		$new_id = mysql_insert_id();
		$query = "UPDATE template_settings set ProjectID='$ProjectID' WHERE ID='$new_id'";
		$DB->execute($query);
	//	print $query.'<br/><br/>';	
		$CloseWindow = 1;

} else {

if ($ProjectID != '') {
$comicString = "<div align='center' style='padding:10px;' class='blue_text_med'><div style='height:10px;';></div>Are you sure you want to install this theme onto your project? <div style='height:10px;';></div>This will uninstall your current them and skin and the new settings will be installed.<div style='height:10px;';></div>
<img src='http://www.wevolt.com/images/save_btn.png' onclick=\"install_theme('".$Theme."','".$ProjectID."');\" class=\"navbuttons\" />     <img src='http://www.wevolt.com/images/cancel_btn.png' onclick='parent.$.modal().close();' class=\"navbuttons\"/></div>";

} else {
$query = "select * from projects where installed = 1 and (CreatorID ='$UserID' or userid='$UserID') and ProjectType !='forum' ORDER BY title ASC";
  $DB->query($query);
   $comicString = "<div style='height:400px; overflow:auto;'><table width='500'><tr>";
    while ($line = $DB->fetchNextObject()) {  
			$SafeFolder = $line->SafeFolder; 
			$ComicDir = $line->HostedUrl; 
 			$comicString .= "<td valign='top'><div align='center'><div class='comictitlelist'>".stripslashes($line->title)."</div><a href='#' onclick=\"
install_theme('".$Theme."','".$line->ProjectID."');\">";
				//$fileUrl = $line->thumb;
		    //	$AgetHeaders = @get_headers($fileUrl);
			//if (preg_match("|200|", $AgetHeaders[0])) {
				$comicString .="<img src='".$line->thumb."' border='2' alt='LINK' style='border-color:#000000;' width='100' height='134' vspace='2' hspace='3'>";
			//} else {
			 	//$comicString .="<img src='images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000;'>";
			//}
			$comicString .="</a></div></div><div align='center'>";

			
			$comicString .="</div></td>"; 
			 $counter++;
 				if ($counter == 4){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
 	   }


	$comicString .= "</tr></table></div>";
}
}
$DB->close();

?>
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
parent.$.modal().close();
</script>


<? }?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Install Theme</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://<? echo $_SERVER['SERVER_NAME'];?>/css/pf_css_new.css" rel="stylesheet" type="text/css">

<style type="text/css">


body, html {
padding:0px;
margin:0px;
background-color:#eeeeee;

}

</style>
<script type="text/javascript">

function install_theme(theme,project) {
	document.getElementById("txtProject").value = project;
	document.getElementById("txtTheme").value = theme;
	document.getElementById("install").value = 1;
	document.themeform.submit();

}

</script>
  
</head>
<body>
<center>
<div id="preview_wrapper">
<? if ($_POST['install'] == 1) { ?>
Please wait while your selected theme is installed on your project. Do not hit your back button or close this window. Once finished the window will close automaticlly. 
<? } else {?>

<? if ($ProjectID == '') {?>
Please select which project you would like to install this theme on<br>
<? }?>
<? echo $comicString;?>

<form name="themeform" id="themeform" method="post" action="#">
<input type="hidden" name="install" id="install" value="0">
<input type="hidden" name="txtProject" id="txtProject" >
<input type="hidden" name="txtTheme" id="txtTheme" >
</form>
<? }?>
</div>
</center>
</body>
</html>