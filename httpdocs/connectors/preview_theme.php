<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
include  $_SERVER['DOCUMENT_ROOT'].'/includes/content_functions.php';

$ReturnLink = $_GET['returnlink'];
$RePost = 0;
$UserID = $_SESSION['userid'];
$DB = new DB();
$ProjectID = $_GET['project'];

$Theme = $_GET['theme'];

function build_menus($theme,$project,$custom,$MenuLayout) {
global $DB, $PFDIRECTORY;
	if ($custom == 0) 
		$query = "select * from pf_themes_menus where ThemeID='$theme' and MenuParent=1 ORDER BY Parent, Position ASC";
	else
	$query = "select * from menu_links where ComicID='$project' and MenuParent=1 ORDER BY Parent, Position ASC";

	$DB->query($query);
	$String = '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>';				
	
	
	while ($line = $DB->fetchNextObject()) { 
		$ContentSection = ucfirst($line->ContentSection);
		$LinkType = $line->LinkType;
		$Button = $ContentSection.'ButtonImage';
		$ButtonRollOver = $ContentSection.'ButtonRolloverImage';
		$Url = $line->Url;
		$String .= '<td>';
		$String .= '<span id="'.$ContentSection.'Button" class="global_button">';
		
		if (${$Button} != '') {
			$LinkStuff .= '<img src="/'.${$Button}.'" id="'.$Button.'" alt="'.$line->Title.'" border="0"';
 			if (${$ButtonRollOver} != '') 
				$LinkStuff .= ' onMouseOver="swapimage(\''.$Button.'\',\''.${$ButtonRollOver}.'\')" onMouseOut="swapimage(\''.$Button.'\',\''.${$Button}.'\')"';
 					
			$LinkStuff .= '/>'; 
		} else {
			$LinkStuff .= $line->Title;
		}	
		$String .= '<a href="';
	
		if ($line->Target == '_blank')
			$TargetStuff = '_blank';
		else
			$TargetStuff='_parent';
				
		$String .= $Url.'" target="'.$TargetStuff.'">'.$LinkStuff.'</a>';
		$LinkStuff = '';
		$String .= '</span>';
		$String .= '</td>';
	
		if ($MenuLayout == 'vertical')
			$String .='</tr><tr>';
		
	}
		
	$String .='</tr></table>';
	
	return $String;
		
}


$query =  "SELECT ts.*,tsk.*,th.TemplateCode, th.SkinCode,t.HTMLCode, t.MenuLayout
			from pf_themes as th
			join templates as t on th.TemplateCode=t.TemplateCode
			join template_settings as ts on th.TemplateCode=ts.TemplateCode and th.ID=ts.ThemeID 
			join template_skins as tsk on th.SkinCode=tsk.SkinCode 
			where th.ID='".$_GET['theme']."'";

$TemplateArray = $DB->queryUniqueObject($query);
$TemplateHTML = $TemplateArray->HTMLCode;
$MenuLayout = $TemplateArray->MenuLayout;
$HeaderWidth = $TemplateArray->HeaderWidth;
if ($ProjectID == '')
	$Custom = 0;

	$HeaderHeight = $TemplateArray->HeaderHeight;
	$HeaderImage = $TemplateArray->HeaderImage;
	$HeaderBackground = $TemplateArray->HeaderBackground;
	$HeaderBackgroundRepeat = $TemplateArray->HeaderBackgroundRepeat;
	$HeaderContent = $TemplateArray->HeaderContent;
	$HeaderLink = $TemplateArray->HeaderLink;
	//print 'HEADER LINK = ' . $HeaderLink;
	$HeaderRollover = $TemplateArray->HeaderRollover;
	$HeaderAlign = 'text-align:'.$TemplateArray->HeaderAlign.';';
	$HeaderVAlign = 'vertical-alignment:'.$TemplateArray->HeaderVAlign.';';
	$HeaderBackgroundImagePosition = $TemplateArray->HeaderBackgroundImagePosition;
	$HeaderPadding = 'padding:'.$TemplateArray->HeaderPadding.';';

	if ($HeaderBackground != '')
		$HeaderBackground  ='background-image:url('.$HeaderBackground.');';	
	if ($HeaderBackgroundRepeat != '')
		$HeaderBackgroundRepeat  = 'background-repeat:'.$HeaderBackgroundRepeat.';';
	if ($HeaderBackgroundImagePosition != '')
		$HeaderBackgroundImagePosition  = 'background-position:'.$HeaderBackgroundImagePosition.';';

	$HeaderHeight  = 'height:'.$HeaderHeight.';';
	$HeaderWidth  = 'width:'.$HeaderWidth.';';
	
	if ($HeaderImage != '')
		$HeaderImage = '<img src="/'.$HeaderImage.'" border="0">';
	if ($HeaderLink != '')
		$HeaderImage = '<a href="'.$HeaderLink.'">'.$HeaderImage.'</a>';
	
	$HeaderContent  = $HeaderImage.$TemplateSettingsArray->HeaderContent;
	
	if ($HeaderContent == '')
		$HeaderContent = '<div style="height:10px;"></div>HEADER AREA<div style="height:10px;"></div></div>';
	$HeaderStyle =$HeaderWidth.$HeaderHeight.$HeaderBackground.$HeaderBackgroundRepeat.$HeaderBackgroundImagePosition.$HeaderAlign.$HeaderVAlign.$HeaderPadding;
	
	$MenuBackground = $TemplateArray->MenuBackground;
	$MenuBackgroundRepeat = $TemplateArray->MenuBackgroundRepeat;
	$MenuImage = $TemplateArray->MenuImage;
	$MenuHeight = $TemplateArray->MenuHeight;
	$MenuWidth = $TemplateArray->MenuWidth;
	$MenuContent = $TemplateArray->MenuContent;
	$MenuAlign = $TemplateArray->MenuAlign;
	$MenuVAlign = $TemplateArray->MenuVAlign;
	$MenuBackgroundImagePosition = $TemplateArray->MenuBackgroundImagePosition;
	
	$MenuAlign = 'text-align:'.$TemplateArray->MenuAlign.';';
	$MenuVAlign = 'vertical-alignment:'.$TemplateArray->MenuVAlign.';';
	$MenuBackgroundImagePosition = $TemplateArray->MenuBackgroundImagePosition;
	$MenuPadding = 'padding:'.$TemplateArray->MenuPadding.';';

	if ($MenuBackground != '')
		$MenuBackground  ='background-image:url('.$MenuBackground.');';	
	if ($MenuBackgroundRepeat != '')
		$MenuBackgroundRepeat  = 'background-repeat:'.$MenuBackgroundRepeat.';';
	if ($MenuBackgroundImagePosition != '')
		$MenuBackgroundImagePosition  = 'background-position:'.$MenuBackgroundImagePosition.';';

	$MenuHeight  = 'height:'.$MenuHeight.';';
	$MenuWidth  = 'width:'.$MenuWidth.';';

	$MenuContent  = $MenuContent;
	$MenuStyle =$MenuWidth.$MenuHeight.$MenuBackground.$MenuBackgroundRepeat.$MenuBackgroundImagePosition.$MenuAlign.$MenuVAlign.$MenuPadding;
	if ($MenuContent == '')
		$MenuContent = '<div style="height:10px;"></div>MENU AREA<div style="height:10px;"></div></div>';
	
	$ContentBackground = $TemplateArray->ContentBackground;
	$ContentBackgroundRepeat = $TemplateArray->ContentBackgroundRepeat;
	$ContentWidth = $TemplateArray->ContentWidth;
	$ContentHeight = $TemplateArray->ContentHeight;
	$ContentScroll = 'scroll:'.$TemplateArray->ContentScroll.';'; 
	$ContentAlign = $TemplateArray->ContentAlign;
	$ContentVAlign = $TemplateArray->ContentVAlign;
	$ContentBackgroundImagePosition = $TemplateArray->ContentBackgroundImagePosition;
	
	$ContentAlign = 'text-align:'.$TemplateArray->ContentAlign.';';
	$ContentVAlign = 'vertical-alignment:'.$TemplateArray->ContentVAlign.';';
	$ContentBackgroundImagePosition = $TemplateArray->ContentBackgroundImagePosition;
	$ContentPadding = 'padding:'.$TemplateArray->ContentPadding.';';

	if ($ContentBackground != '')
		$ContentBackground  ='background-image:url('.$ContentBackground.');';	
	if ($ContentBackgroundRepeat != '')
		$ContentBackgroundRepeat  = 'background-repeat:'.$ContentBackgroundRepeat.';';
	if ($ContentBackgroundImagePosition != '')
		$ContentBackgroundImagePosition  = 'background-position:'.$ContentBackgroundImagePosition.';';

	$ContentWidth  = 'height:'.$ContentWidth.';';
	$ContentHeight  = 'width:'.$ContentHeight.';';

	$ContentContent = '<img src="/templates/common/content_650x500.jpg">';
	$ContentStyle =$ContentWidth.$ContentHeight.$ContentBackground.$ContentBackgroundRepeat.$ContentBackgroundImagePosition.$ContentScroll.$ContentAlign.$ContentVAlign.$ContentPadding;
	
	
	$FooterImage = $TemplateArray->FooterImage;
	$FooterBackground = $TemplateArray->FooterBackground;
	$FooterBackgroundRepeat = $TemplateArray->FooterBackgroundRepeat;
	$FooterWidth = $TemplateArray->FooterWidth;
	$FooterHeight = $TemplateArray->FooterHeight; 
	$FooterContent = $TemplateArray->FooterContent;
	$FooterAlign = $TemplateArray->FooterAlign;
	$FooterVAlign = $TemplateArray->FooterVAlign;
	$FooterBackgroundImagePosition = $TemplateArray->FooterBackgroundImagePosition;
	$FooterAlign = 'text-align:'.$TemplateArray->FooterAlign.';';
	$FooterVAlign = 'vertical-alignment:'.$TemplateArray->FooterVAlign.';';
	$FooterPadding = 'padding:'.$TemplateArray->FooterPadding.';';
	if ($FooterImage != '')
		$FooterImage = '<img src="/'.$FooterImage.'" border="0">';
	
	if ($FooterBackground != '')
		$FooterBackground  ='background-image:url('.$FooterBackground.');';	
	if ($FooterBackgroundRepeat != '')
		$FooterBackgroundRepeat  = 'background-repeat:'.$FooterBackgroundRepeat.';';
	if ($FooterBackgroundImagePosition != '')
		$FooterBackgroundImagePosition  = 'background-position:'.$FooterBackgroundImagePosition.';';

	$FooterHeight  = 'height:'.$FooterHeight.';';
	$FooterWidth  = 'width:'.$FooterWidth.';';

	$FooterContent  = $FooterImage.$FooterContent;
	$FooterStyle =$FooterWidth.$FooterHeight.$FooterBackground.$FooterBackgroundRepeat.$FooterBackgroundImagePosition.$FooterVAlign.$FooterAlign.$FooterPadding;
if ($FooterContent == '')
		$FooterContent = '<div style="height:10px;"></div>FOOTER AREA<div style="height:10px;"></div></div>';
$MenuContent = build_menus($Theme,$ProjectID,$Custom,$MenuLayout);
				$TemplateHTML=str_replace("{HeaderStyle}",$HeaderStyle,$TemplateHTML);
				$TemplateHTML=str_replace("{HeaderContent}",$HeaderContent,$TemplateHTML);

				$TemplateHTML=str_replace("{MenuStyle}",$MenuStyle,$TemplateHTML);
				$TemplateHTML=str_replace("{MenuContent}",$MenuContent,$TemplateHTML);
				
				$TemplateHTML=str_replace("{ContentStyle}",$ContentStyle,$TemplateHTML);
				$TemplateHTML=str_replace("{ContentContent}",$ContentContent,$TemplateHTML);
				
				$TemplateHTML=str_replace("{FooterStyle}",$FooterStyle,$TemplateHTML);
				$TemplateHTML=str_replace("{FooterContent}",$FooterContent,$TemplateHTML);
				
				$TemplateHTML=str_replace("{TemplateStyle}",'',$TemplateHTML);
				
$TemplateWidth = $TemplateArray->TemplateWidth;
$BodyStyle = '';
				$GlobalSiteBGColor = $TemplateArray->GlobalSiteBGColor; 
				$GlobalSiteBGImage = $TemplateArray->GlobalSiteBGImage; 
				$GlobalSiteImageRepeat = $TemplateArray->GlobalSiteImageRepeat;
				$GlobalSiteTextColor = $TemplateArray->GlobalSiteTextColor;
				$GlobalSiteFontSize = $TemplateArray->GlobalSiteFontSize;
				$GlobalSiteWidth = $TemplateArray->GlobalSiteWidth;
				$KeepWidth = $TemplateArray->KeepWidth;  
				$GlobalSiteLinkTextColor = $TemplateArray->GlobalSiteLinkTextColor;  
				$GlobalSiteLinkFontStyle = $TemplateArray->GlobalSiteLinkFontStyle;  
				$GlobalSiteHoverTextColor = $TemplateArray->GlobalSiteHoverTextColor;  
				$GlobalSiteHoverFontStyle = $TemplateArray->GlobalSiteHoverFontStyle;  
				$GlobalSiteVisitedTextColor = $TemplateArray->GlobalSiteVisitedTextColor; 
				$GlobalSiteVisitedFontStyle = $TemplateArray->GlobalSiteVisitedFontStyle;
				$GlobalButtonLinkTextColor = $TemplateArray->GlobalButtonLinkTextColor;  
				$GlobalButtonLinkFontStyle = $TemplateArray->GlobalButtonLinkFontStyle;  
				$GlobalButtonHoverTextColor = $TemplateArray->GlobalButtonHoverTextColor;  
				$GlobalButtonHoverFontStyle = $TemplateArray->GlobalButtonHoverFontStyle;  
				$GlobalButtonVisitedTextColor = $TemplateArray->GlobalButtonVisitedTextColor; 
				$GlobalButtonVisitedFontStyle = $TemplateArray->GlobalButtonVisitedFontStyle; 
				  
				//Tab Active
				$GlobalTabActiveBGColor = $TemplateArray->GlobalTabActiveBGColor; 
				$GlobalTabActiveFontStyle = $TemplateArray->GlobalTabActiveFontStyle;
				$GlobalTabActiveTextColor = $TemplateArray->GlobalTabActiveTextColor;
				$GlobalTabActiveFontSize = $TemplateArray->GlobalTabActiveFontSize;
				//Tab InActive
				$GlobalTabInActiveBGColor = $TemplateArray->GlobalTabInActiveBGColor;
				$GlobalTabInActiveFontStyle = $TemplateArray->GlobalTabInActiveFontStyle;
				$GlobalTabInActiveTextColor = $TemplateArray->GlobalTabInActiveTextColor;
				$GlobalTabInActiveFontSize = $TemplateArray->GlobalTabInActiveFontSize;
				//Tab Hover
				$GlobalTabHoverBGColor = $TemplateArray->GlobalTabHoverBGColor;
				$GlobalTabHoverFontStyle = $TemplateArray->GlobalTabHoverFontStyle;
				$GlobalTabHoverTextColor = $TemplateArray->GlobalTabHoverTextColor;
				$GlobalTabHoverFontSize = $TemplateArray->GlobalTabHoverFontSize;
				
				if ($GlobalSiteBGImage != '') {
				$BodyStyle .= 'background-image:url(/templates/skins/'.$SkinCode.'/images/'.$GlobalSiteBGImage.');';
				$BodyStyle .= 'background-repeat:'.$GlobalSiteImageRepeat.';';
				}
				$BodyStyle .= 'color:#'.$GlobalSiteTextColor.';';
				$BodyStyle .= 'font-size:'.$GlobalSiteFontSize.'px;';
				$BodyStyle .= 'background-color:#'.$GlobalSiteBGColor.';';
			
				//BUTTONS
				$ButtonImage= $TemplateArray->ButtonImage;
				$ButtonBGColor= $TemplateArray->ButtonBGColor;
				$ButtonImageRepeat= $TemplateArray->ButtonImageRepeat;
				$ButtonTextColor= $TemplateArray->ButtonTextColor;
				$ButtonFontSize= $TemplateArray->ButtonFontSize;
				$ButtonFontStyle= $TemplateArray->ButtonFontStyle;
				
				$FirstButtonImage= $TemplateArray->FirstButtonImage;
				$FirstButtonRolloverImage= $TemplateArray->FirstButtonRolloverImage;
				$FirstButtonBGColor= $TemplateArray->FirstButtonBGColor;
				$FirstButtonTextColor= $TemplateArray->FirstButtonTextColor;
				
				$NextButtonImage= $TemplateArray->NextButtonImage;
				$NextButtonRolloverImage= $TemplateArray->NextButtonRolloverImage;
				$NextButtonBGColor= $TemplateArray->NextButtonBGColor;
				$NextButtonTextColor= $TemplateArray->NextButtonTextColor; 
				
				$BackButtonImage= $TemplateArray->BackButtonImage;
				$BackButtonRolloverImage= $TemplateArray->BackButtonRolloverImage;
				$BackButtonBGColor= $TemplateArray->BackButtonBGColor;
				$BackButtonTextColor= $TemplateArray->BackButtonTextColor;
				
				$LastButtonImage= $TemplateArray->LastButtonImage;
				$LastButtonRolloverImage= $TemplateArray->LastButtonRolloverImage;
				$LastButtonBGColor= $TemplateArray->LastButtonBGColor;
				$LastButtonTextColor= $TemplateArray->LastButtonTextColor;
				
				$HomeButtonImage= $TemplateArray->HomeButtonImage;  
				$HomeButtonRolloverImage= $TemplateArray->HomeButtonRolloverImage;
		
				$HomeButtonBGColor= $TemplateArray->HomeButtonBGColor;
				$HomeButtonTextColor= $TemplateArray->HomeButtonTextColor;
				
				$CreatorButtonImage= $TemplateArray->CreatorButtonImage;
				$CreatorButtonRolloverImage= $TemplateArray->CreatorButtonRolloverImage;
				$CreatorButtonBGColor= $TemplateArray->CreatorButtonBGColor;
				$CreatorButtonTextColor= $TemplateArray->CreatorButtonTextColor;
				
				$CharactersButtonImage=$TemplateArray->CharactersButtonImage;
				$CharactersButtonRolloverImage= $TemplateArray->CharactersButtonRolloverImage;
				$CharactersButtonBGColor= $TemplateArray->CharactersButtonBGColor;
				$CharactersButtonTextColor= $TemplateArray->CharactersButtonTextColor;
				
				$DownloadsButtonImage= $TemplateArray->DownloadsButtonImage;
				$DownloadsButtonRolloverImage= $TemplateArray->DownloadsButtonRolloverImage;
				$DownloadsButtonBGColor= $TemplateArray->DownloadsButtonBGColor;
				$DownloadsButtonTextColor= $TemplateArray->DownloadsButtonTextColor;
				
				$ExtrasButtonImage= $TemplateArray->ExtrasButtonImage;
				$ExtrasButtonRolloverImage= $TemplateArray->ExtrasButtonRolloverImage;
				$ExtrasButtonBGColor= $TemplateArray->ExtrasButtonBGColor;
				$ExtrasButtonTextColor= $TemplateArray->ExtrasButtonTextColor;
				
				$EpisodesButtonImage= $TemplateArray->EpisodesButtonImage;
				$EpisodesButtonRolloverImage= $TemplateArray->EpisodesButtonRolloverImage;
				$EpisodesButtonBGColor= $TemplateArray->EpisodesButtonBGColor; 
				$EpisodesButtonTextColor= $TemplateArray->EpisodesButtonTextColor;
				
				$MobileButtonImage= $TemplateArray->MobileButtonImage;
				$MobileButtonRolloverImage= $TemplateArray->MobileButtonRolloverImage;
				$MobileButtonBGColor= $TemplateArray->MobileButtonBGColor;
				$MobileButtonTextColor= $TemplateArray->MobileButtonTextColor;
				
				$ProductsButtonImage= $TemplateArray->ProductsButtonImage;
				$ProductsButtonRolloverImage= $TemplateArray->ProductsButtonRolloverImage;
				$ProductsButtonBGColor= $TemplateArray->ProductsButtonBGColor;
				$ProductsButtonTextColor= $TemplateArray->ProductsButtonTextColor;
				
				$CommentButtonImage= $TemplateArray->CommentButtonImage;
				$CommentButtonRolloverImage= $TemplateArray->CommentButtonRolloverImage;
				$CommentButtonBGColor= $TemplateArray->CommentButtonBGColor;
				$CommentButtonTextColor= $TemplateArray->CommentButtonTextColor;
				
				$VoteButtonImage= $TemplateArray->VoteButtonImage;
				$VoteButtonRolloverImage= $TemplateArray->VoteButtonRolloverImage;
				$VoteButtonBGColor= $TemplateArray->VoteButtonBGColor;
				$VoteButtonTextColor= $TemplateArray->VoteButtonTextColor;
				
				$LogoutButtonImage= $TemplateArray->LogoutButtonImage;
				$LogoutButtonRolloverImage= $TemplateArray->LogoutButtonRolloverImage;
				$LogoutButtonBGColor= $TemplateArray->LogoutButtonBGColor;
				$LogoutButtonTextColor= $TemplateArray->LogoutButtonTextColor;
				
				//CONTENT BOX
				$ModTopRightImage= $BaseSkinDir.$TemplateArray->ModTopRightImage;
				$ModTopRightBGColor= $TemplateArray->ModTopRightBGColor;
				$ModTopLeftImage= $BaseSkinDir.$TemplateArray->ModTopLeftImage;
				$ModTopLeftBGColor= $TemplateArray->ModTopLeftBGColor;
				$ModBottomLeftImage= $BaseSkinDir.$TemplateArray->ModBottomLeftImage;
				$ModBottomLeftBGColor= $TemplateArray->ModBottomLeftBGColor;
				$ModBottomRightImage= $BaseSkinDir.$TemplateArray->ModBottomRightImage;
				$ModBottomRightBGColor= $TemplateArray->ModBottomRightBGColor;
				$ModRightSideImage= $BaseSkinDir.$TemplateArray->ModRightSideImage;
				$ModRightSideBGColor= $TemplateArray->ModRightSideBGColor;
				$ModLeftSideImage= $BaseSkinDir.$TemplateArray->ModLeftSideImage;
				$ModLeftSideBGColor= $TemplateArray->ModLeftSideBGColor;
				$ModTopImage= $BaseSkinDir.$TemplateArray->ModTopImage; 
				$ModTopBGColor= $TemplateArray->ModTopBGColor;
				$ModBottomImage= $BaseSkinDir.$TemplateArray->ModBottomImage;
				$ModBottomBGColor= $TemplateArray->ModBottomBGColor;
				$ContentBoxImage= $BaseSkinDir.$TemplateArray->ContentBoxImage;
				$ContentBoxBGColor= $TemplateArray->ContentBoxBGColor;
				$ContentBoxImageRepeat= $TemplateArray->ContentBoxImageRepeat; 
				$ContentBoxTextColor= $TemplateArray->ContentBoxTextColor;
				$ContentBoxFontSize= $TemplateArray->ContentBoxFontSize;
				$ReaderCorner= $TemplateArray->Corner;
				if ($ReaderCorner == '') {
					$ReaderCorner = 'round';
				}
				$ModuleSeparation = $TemplateArray->ModuleSeparation;
				$RightColumnWidth = $TemplateArray->RightColumnWidth;
				$LeftColumnWidth = $TemplateArray->LeftColumnWidth;
				$HeaderPlacement = $TemplateArray->HeaderPlacement;
				//HEADERS
				$GlobalHeaderImage= $TemplateArray->GlobalHeaderImage;
				$GlobalHeaderBGColor= $TemplateArray->GlobalHeaderBGColor;
				$GlobalHeaderImageRepeat= $TemplateArray->GlobalHeaderImageRepeat; 
				$GlobalHeaderTextColor= $TemplateArray->GlobalHeaderTextColor;
				$GlobalHeaderFontSize= $TemplateArray->GlobalHeaderFontSize;
				$GlobalHeaderFontStyle= $TemplateArray->GlobalHeaderFontStyle;
				 $GlobalHeaderTextTransformation = $TemplateArray->GlobalHeaderTextTransformation;
				$FlashReaderStyle= $TemplateArray->FlashReaderStyle;
				$NavBarPlacement= $TemplateArray->NavBarPlacement; 
				$NavBarAlignment = $TemplateArray->NavBarAlignment;
				
				$AuthorCommentImage= $TemplateArray->AuthorCommentImage;
				$AuthorCommentBGColor= $TemplateArray->AuthorCommentBGColor;
				$AuthorCommentImageRepeat= $TemplateArray->AuthorCommentImageRepeat;
				$AuthorCommentTextColor= $TemplateArray->AuthorCommentTextColor;
				$AuthorCommentFontSize= $TemplateArray->AuthorCommentFontSize;
				$AuthorCommentFontStyle= $TemplateArray->AuthorCommentFontStyle;
				
				$MobileContentImage= $TemplateArray->MobileContentImage;
				$MobileContentBGColor= $TemplateArray->MobileContentBGColor;
				$MobileContentImageRepeat= $TemplateArray->MobileContentImageRepeat;
				$MobileContentTextColor= $TemplateArray->MobileContentTextColor;
				$MobileContentFontSize= $TemplateArray->MobileContentFontSize;
				$MobileContentFontStyle= $TemplateArray->MobileContentFontStyle;
				
				$ProductsImage= $TemplateArray->ProductsImage;
				$ProductsBGColor= $TemplateArray->ProductsBGColor;
				$ProductsImageRepeat= $TemplateArray->ProductsImageRepeat;
				$ProductsTextColor= $TemplateArray->ProductsTextColor;
				$ProductsFontSize= $TemplateArray->ProductsFontSize;
				$ProductsFontStyle= $TemplateArray->ProductsFontStyle;
				
				$ComicInfoImage= $TemplateArray->ComicInfoImage;
				$ComicInfoBGColor= $TemplateArray->ComicInfoBGColor;
				$ComicInfoImageRepeat= $TemplateArray->ComicInfoImageRepeat;
				$ComicInfoTextColor= $TemplateArray->ComicInfoTextColor;
				$ComicInfoFontSize= $TemplateArray->ComicInfoFontSize;
				$ComicInfoFontStyle= $TemplateArray->ComicInfoFontStyle;
				
				$UserCommentsImage= $TemplateArray->UserCommentsImage;
				$UserCommentsBGColor= $TemplateArray->UserCommentsBGColor;
				$UserCommentsImageRepeat= $TemplateArray->UserCommentsImageRepeat;
				$UserCommentsTextColor= $TemplateArray->UserCommentsTextColor;
				$UserCommentsFontSize= $TemplateArray->UserCommentsFontSize;
				$UserCommentsFontStyle= $TemplateArray->UserCommentsFontStyle;
				
				$ComicSynopsisImage= $TemplateArray->ComicSynopsisImage;
				$ComicSynopsisBGColor= $TemplateArray->ComicSynopsisBGColor;
				$ComicSynopsisImageRepeat= $TemplateArray->ComicSynopsisImageRepeat;
				$ComicSynopsisTextColor= $TemplateArray->ComicSynopsisTextColor;
				$ComicSynopsisFontSize= $TemplateArray->ComicSynopsisFontSize;
				$ComicSynopsisFontStyle= $TemplateArray->ComicSynopsisFontStyle;
				
				//PAGE READER
				$ControlBarImage= $TemplateArray->ControlBarImage;
				$ControlBarImageRepeat= $TemplateArray->ControlBarImageRepeat;
				$ControlBarBGColor= $TemplateArray->ControlBarBGColor;
				$BarColor = '0x'.$ControlBarBGColor;
				$ControlBarTextColor= $TemplateArray->ControlBarTextColor;
				$TextColor = '0x'.$ControlBarTextColor;
				$ControlBarFontSize = $TemplateArray->ControlBarFontSize;
				$ControlBarFontStyle = $TemplateArray->ControlBarFontStyle;
				$ReaderButtonBGColor = $TemplateArray->ReaderButtonBGColor;
				
				$CharacterReader = $TemplateArray->CharacterReader;
				
				//Bubble tip Settings
				$BubbleClose = $TemplateArray->BubbleClose;
				$BubbleOpen = $TemplateArray->BubbleOpen;
				$HotSpotImage = $TemplateArray->HotSpotImage; 
				$HotSpotBGColor = $TemplateArray->HotSpotBGColor;
				if ($HotSpotImage != '') {
				list($HotSpotWidth,$HotSpotHeight)=@getimagesize($_SERVER['SERVER_NAME'].'/templates/skins/'.$SkinCode.'/images/'.$TemplateArray->HotSpotImage);
				}else {
					$HotSpotHeight = 5;
					$HotSpotWidth = 5;
				}
				
				if ($ReaderButtonBGColor == '') {
					$ReaderButtonBGColor = 'ffbd72';
				}
				$ButtonColor = '0x'.$ReaderButtonBGColor;
				$ReaderButtonAccentColor = $TemplateArray->ReaderButtonAccentColor;
				if ($ReaderButtonAccentColor == '') {
					$ReaderButtonAccentColor = '000000';
				}
				$ArrowColor = '0x'.$ReaderButtonAccentColor;
				if ($TemplateArray->PageBGColor == '') {
					$PageBGColor = $BarColor;
				} else {
					$PageBGColor = $TemplateArray->PageBGColor; 
				}
				if ($ReaderCorner == 'round') {
					$MovieColor= '0x'.$GlobalSiteBGColor;
				} else {
					$MovieColor= $BarColor;
				}
				
				$BGcolor = $GlobalSiteBGColor;
				$Text = $TextColor; 
				list($CornerWidth,$CornerHeight)=@getimagesize($_SERVER['SERVER_NAME'].'/templates/skins/'.$SkinCode.'/images/'.$TemplateArray->ModTopLeftImage);
		
				if ($ControlBarImage != '') {
					list($ControlWidth,$ControlHeight)=@getimagesize($_SERVER['SERVER_NAME'].'/templates/skins/'.$SkinCode.'/images/'.$TemplateArray->ControlBarImage);
				}
				if ($CornerWidth == '') {
					$CornerWidth = '15';
				}
				
				if ($CornerHeight == '') {
					$CornerHeight = '15';
				}
				
				
$DB->close();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Preview Theme</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://<? echo $_SERVER['SERVER_NAME'];?>/css/pf_css_new.css" rel="stylesheet" type="text/css">

<style type="text/css">
#preview_wrapper {
<? echo $BodyStyle;?>

}

body, html {
padding:0px;
margin:0px;




}
.tabactive {
height:12px;
background-color:#<? echo $GlobalTabActiveBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;
<? if ($GlobalTabActiveFontStyle != '') {
if ($GlobalTabActiveFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalTabActiveFontStyle == 'regular')  
	$StyleTag = 'font-style:normal;';
if ($GlobalTabActiveFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';
echo $StyleTag;	
	?>
<? }?>
font-size:<? echo $GlobalTabActiveFontSize;?>px;
width:100px;
color:#<? echo $GlobalTabActiveTextColor;?>;
}
.tabinactive { 
height:12px;
background-color:#<? echo $GlobalTabInActiveBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;
<? if ($GlobalTabInActiveFontStyle != '') {
if ($GlobalTabInActiveFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalTabInActiveFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalTabInActiveFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';
echo $StyleTag;	
	?>
<? }?>
font-size:<? echo $GlobalTabInActiveFontSize;?>px;
width:100px;
color:#<? echo $GlobalTabInActiveTextColor;?>;
}
.tabhover{
height:12px;
background-color:#<? echo $GlobalTabHoverBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;
<? if ($GlobalTabHoverFontStyle != '') {
if ($GlobalTabHoverFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalTabHoverFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalTabHoverFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';
echo $StyleTag;	
	?>
<? }?>
font-size:<? echo $GlobalTabHoverFontSize;?>px;
width:100px;
color:#<? echo $GlobalTabHoverTextColor;?>;
}

.peeltabactive {
height:10px;
background-color:#<? echo $GlobalTabActiveBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;

font-size:10px;
width:50px;
color:#<? echo $GlobalTabActiveTextColor;?>;
}
.peeltabinactive {
height:10px;
background-color:#<? echo $GlobalTabInActiveBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;
font-size:10px;
width:50px;
color:#<? echo $GlobalTabInActiveTextColor;?>;
}
.peeltabhover{
height:10px;
background-color:#<? echo $GlobalTabHoverBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;
font-size:10px;
width:50px;
color:#<? echo $GlobalTabHoverTextColor;?>;
}

#modrightside { 
<? if ($ModRightSideImage != '') {?>
background-image:url(/<? echo $ModRightSideImage;?>);
background-repeat:repeat-y;
<? }?>
<? if ($ModRightSideBGColor != '') {?>
background-color:#<? echo $ModRightSideBGColor;?>;
<? } ?>
width: <? echo $CornerWidth;?>px;

}

#modleftside {
<? if ($ModLeftSideImage != '') {?>
background-image:url(/<? echo $ModLeftSideImage;?>);
background-repeat:repeat-y;
<? }?>
<? if ($ModLeftSideBGColor != '') {?>
background-color:#<? echo $ModLeftSideBGColor;?>;
<? } ?>
width: <? echo $CornerWidth;?>px;
}

#modtop {
<? if ($ModTopImage != '') {?>
background-image:url(/<? echo $ModTopImage;?>);
background-repeat:repeat-x;
<? }?>
<? if ($ModTopBGColor != '') {?>
background-color:#<? echo $ModTopBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
}

.boxcontent {
<? if ($ContentBoxImage != '') {?>
background-image:url(/<? echo $ContentBoxImage;?>);
background-repeat:<? echo $ContentBoxImageRepeat;?>;
<? }?>
<? if ($ContentBoxBGColor != '') {?>
background-color:#<? echo $ContentBoxBGColor;?>;
<? } else { ?>
background-color:#ffffff;
<? }?>
<? if ($ContentBoxTextColor != '') {?>
color:#<? echo $ContentBoxTextColor;?>;
<? } else {?>
color:#000000;
<? }?>
<? if ($ContentBoxFontSize != '') {?>
font-size:<? echo $ContentBoxFontSize;?>px;
<? } else {?>
font-size:12px;
<? }?>

}

#modbottom {
<? if ($ModBottomImage != '') {?>
background-image:url(/<? echo $ModBottomImage;?>);
background-repeat:repeat-x;
<? }?>
<? if ($ModBottomBGColor != '') {?>
background-color:#<? echo $ModBottomBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;

}

#modbottomleft{
<? if ($ModBottomLeftImage != '') {?>
background-image:url(/<? echo $ModBottomLeftImage;?>);
background-repeat:none;
<? }?>
<? if ($ModBottomLeftBGColor != '') {?>
background-color:#<? echo $ModBottomLeftBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#modtopleft{
<? if ($ModTopLeftImage != '') {?>
background-image:url(/<? echo $ModTopLeftImage;?>);
background-repeat:none;
<? }?>
<? if ($ModTopLeftBGColor != '') {?>
background-color:#<? echo $ModTopLeftBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#modtopright{
<? if ($ModTopRightImage != '') {?>
background-image:url(/<? echo $ModTopRightImage;?>);
background-repeat:none;
<? }?>
<? if ($ModTopRightBGColor != '') {?>
background-color:#<? echo $ModTopRightBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#modbottomright{
<? if ($ModBottomRightImage != '') {?>
background-image:url(/<? echo $ModBottomRightImage;?>);
background-repeat:none;
<? }?>
<? if ($ModBottomRightBGColor != '') {?>
background-color:#<? echo $ModBottomRightBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}



#bubblerightside { 
<? if ($ModRightSideImage != '') {?>
background-image:url(/<? echo $ModRightSideImage;?>);
background-repeat:repeat-y;
<? }?>
<? if ($ModRightSideBGColor != '') {?>
background-color:#<? echo $ModRightSideBGColor;?>;
<? } ?>
width: <? echo $CornerWidth;?>px;

}

#bubbleleftside {
<? if ($ModLeftSideImage != '') {?>
background-image:url(/<? echo $ModLeftSideImage;?>);
background-repeat:repeat-y;
<? }?>
<? if ($ModLeftSideBGColor != '') {?>
background-color:#<? echo $ModLeftSideBGColor;?>;
<? } ?>
width: <? echo $CornerWidth;?>px;
}

#bubbletop {
<? if ($ModTopImage != '') {?>
background-image:url(/<? echo $ModTopImage;?>);
background-repeat:repeat-x;
<? }?>
<? if ($ModTopBGColor != '') {?>
background-color:#<? echo $ModTopBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
}

#bubble_tooltip_content {
<? if ($ContentBoxImage != '') {?>
background-image:url(/<? echo $ContentBoxImage;?>);
background-repeat:<? echo $ContentBoxImageRepeat;?>;
<? }?>
<? if ($ContentBoxBGColor != '') {?>
background-color:#<? echo $ContentBoxBGColor;?>;
<? } else { ?>
background-color:#ffffff;
<? }?>
<? if ($ContentBoxTextColor != '') {?>
color:#<? echo $ContentBoxTextColor;?>;
<? } else {?>
color:#000000;
<? }?>
<? if ($ContentBoxFontSize != '') {?>
font-size:<? echo $ContentBoxFontSize;?>px;
<? } else {?>
font-size:12px;
<? }?>
}

#bubblebottom {
<? if ($ModBottomImage != '') {?>
background-image:url(/<? echo $ModBottomImage;?>);
background-repeat:repeat-x;
<? }?>
<? if ($ModBottomBGColor != '') {?>
background-color:#<? echo $ModBottomBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;

}

#bubblebottomleft{
<? if ($ModBottomLeftImage != '') {?>
background-image:url(/<? echo $ModBottomLeftImage;?>);
background-repeat:none;
<? }?>
<? if ($ModBottomLeftBGColor != '') {?>
background-color:#<? echo $ModBottomLeftBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#bubbletopleft{
<? if ($ModTopLeftImage != '') {?>
background-image:url(/<? echo $ModTopLeftImage;?>);
background-repeat:none;
<? }?>
<? if ($ModTopLeftBGColor != '') {?>
background-color:#<? echo $ModTopLeftBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#bubbletopright{
<? if ($ModTopRightImage != '') {?>
background-image:url(/<? echo $ModTopRightImage;?>);
background-repeat:none;
<? }?>
<? if ($ModTopRightBGColor != '') {?>
background-color:#<? echo $ModTopRightBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#bubblebottomright{
<? if ($ModBottomRightImage != '') {?>
background-image:url(/<? echo $ModBottomRightImage;?>);
background-repeat:none;
<? }?>
<? if ($ModBottomRightBGColor != '') {?>
background-color:#<? echo $ModBottomRightBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}


#ControlBar{

<? if ($ControlBarImage != '') {?>
background-image:url(/<? echo $ControlBarImage;?>);
background-repeat:<? echo $ControlBarImageRepeat;?>;
height:<? echo $ControlHeight;?>px;
<? }?>
background-color:#<? echo $ControlBarBGColor;?>;
<? if ($ControlBarFontSize != '') {?>
font-size:<? echo $ControlBarFontSize;?>px;
<? }?>
<? if ($ControlBarFontStyle != '') {
if ($ControlBarFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($ControlBarFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($ControlBarFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';
echo $StyleTag;	
	?>
<? }?>
}


#AuthorComment{

<? if (($AuthorCommentTextColor == 'global') || ($AuthorCommentTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $AuthorCommentTextColor;
?>
color:#<? echo $TextColor;?>;

text-transform:<? echo $GlobalHeaderTextTransformation;?>;
<? if (($AuthorCommentImage != '') || ($GlobalHeaderImage != '')) {
		 if ($AuthorCommentImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat; 
		} else {
			$CSSImage =$AuthorCommentImage;
			$CSSRepeat = $AuthorCommentImageRepeat;
		} 
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$CSSImage);
		
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($AuthorCommentBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($AuthorCommentBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$AuthorCommentBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($AuthorCommentFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($AuthorCommentFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$AuthorCommentFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? 


if (($AuthorCommentFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($AuthorCommentFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$AuthorCommentFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	

?>
<? echo $StyleTag;?>
<? }?>

}

#LinksBox {
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
		
padding:2px;
<? if ($GlobalHeaderImage != '') {
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$GlobalHeaderImage);
	if ($GlobalHeaderImageRepeat == 'none') 
			$GlobalHeaderImageRepeat = 'no-repeat';
?>
background-image:url(/<? echo $GlobalHeaderImage;?>);
background-repeat:<? echo $GlobalHeaderImageRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $GlobalHeaderBGColor;?>; 
font-size:<? echo $GlobalHeaderFontSize;?>px;
color:#<? echo $GlobalHeaderTextColor;?>;
<? 
$GlobalHeaderFontStyle;
	if ($GlobalHeaderFontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
	if ($GlobalHeaderFontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
	if ($GlobalHeaderFontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
}

.modheader{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
		
padding:2px;
<? if ($GlobalHeaderImage != '') {
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$GlobalHeaderImage);
			if ($GlobalHeaderImageRepeat == 'none') 
			$GlobalHeaderImageRepeat = 'no-repeat';
?>
background-image:url(/<? echo $GlobalHeaderImage;?>);
background-repeat:<? echo $GlobalHeaderImageRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $GlobalHeaderBGColor;?>; 
font-size:<? echo $GlobalHeaderFontSize;?>px;
text-align:left;
color:#<? echo $GlobalHeaderTextColor;?>;
<? 
	if ($GlobalHeaderFontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
	if ($GlobalHeaderFontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
	if ($GlobalHeaderFontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
}

#ComicSynopsis{
padding:3px;
<? if (($ComicSynopsisTextColor == 'global') || ($ComicSynopsisTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $ComicSynopsisTextColor;
?>
color:#<? echo $TextColor;?>;
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
<? if (($ComicSynopsisImage != '') || ($GlobalHeaderImage != '')) {
		 if ($ComicSynopsisImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$ComicSynopsisCommentImage;
			$CSSRepeat = $ComicSynopsisImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($ComicSynopsisBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($ComicSynopsisBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$ComicSynopsisBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($ComicSynopsisFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($ComicSynopsisFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$ComicSynopsisFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($ComicSynopsisFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($ComicSynopsisFontStyle == '') {
		 	$FontStyle = $GlobalHeaderFontStyle;
		} else {
			$FontStyle =$ComicSynopsisFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}

#ComicInfo{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($ComicInfoTextColor == 'global')  || ($ComicInfoTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $ComicInfoTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($ComicInfoImage != '') || ($GlobalHeaderImage != '')) {
		 if ($ComicInfoImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$ComicInfoImage;
			$CSSRepeat = $ComicInfoImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($ComicInfoBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($ComicInfoBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$ComicInfoBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($ComicInfoFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($ComicInfoFontSize == '') { 
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$ComicInfoFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($ComicInfoFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($ComicInfoFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$ComicInfoFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}		

#UserComments{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($UserCommentsTextColor == 'global')  || ($UserCommentsTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $UserCommentsTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($UserCommentsImage != '') || ($GlobalHeaderImage != '')) {
		 if ($UserCommentsImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$UserCommentsImage;
			$CSSRepeat = $UserCommentsImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($UserCommentsBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($UserCommentsBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$UserCommentsBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($UserCommentsFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($UserCommentsFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$UserCommentsFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($UserCommentsFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($UserCommentsFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$UserCommentsFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}			
	
#ComicSynopsis{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($ComicSynopsisTextColor == 'global') || ($ComicSynopsisTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $ComicSynopsisTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($ComicSynopsisImage != '') || ($GlobalHeaderImage != '')) {
		 if ($ComicSynopsisImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$ComicSynopsisImage;
			$CSSRepeat = $ComicSynopsisImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($ComicSynopsisBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($ComicSynopsisBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$ComicSynopsisBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($ComicSynopsisFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($ComicSynopsisFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$ComicSynopsisFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($ComicSynopsisFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($ComicSynopsisFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$ComicSynopsisFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}	

#Products{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($ProductsTextColor == 'global') || ($ProductsTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $ProductsTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($ProductsImage != '') || ($GlobalHeaderImage != '')) {
		 if ($ProductsImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$ProductsImage;
			$CSSRepeat = $ProductsImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($ProductsBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($ProductsBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$ProductsBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($ProductsFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($ProductsFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$ProductsFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($ProductsFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($ProductsFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$ProductsFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}	
	
#MobileContent{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($MobileContentTextColor == 'global') || ($MobileContentTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $MobileContentTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($MobileContentImage != '') || ($GlobalHeaderImage != '')) {
		 if ($MobileContentImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$MobileContentImage;
			$CSSRepeat = $MobileContentImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($MobileContentBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($MobileContentBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$MobileContentBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($MobileContentFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($MobileContentFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$MobileContentFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($MobileContentFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($MobileContentFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$MobileContentFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}	


	
#MobileContent{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($MobileContentTextColor == 'global') || ($MobileContentTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $MobileContentTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($MobileContentImage != '') || ($GlobalHeaderImage != '')) {
		 if ($MobileContentImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$MobileContentImage;
			$CSSRepeat = $MobileContentImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($MobileContentBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($MobileContentBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$MobileContentBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($MobileContentFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($MobileContentFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$MobileContentFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($MobileContentFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($MobileContentFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$MobileContentFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}	
.latestpageheader  {
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
color:#<? echo $GlobalHeaderTextColor;?>;
<? if ($GlobalHeaderImage != '') {
$CSSImage =$GlobalHeaderImage;
$CSSRepeat = $GlobalHeaderImageRepeat;
list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $ControlBarBGColor;?>;
font-size:<? echo $GlobalHeaderFontSize;?>px;
<?
	$FontStyle =$GlobalHeaderFontStyle;
	 if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>

}
.latestpageheader a:link{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
color:#<? echo $GlobalHeaderTextColor;?>;
<? if ($GlobalHeaderImage != '') {
$CSSImage =$GlobalHeaderImage;
$CSSRepeat = $GlobalHeaderImageRepeat;
list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $GlobalHeaderBGColor;?>;
font-size:<? echo $GlobalHeaderFontSize;?>px;
<?
	$FontStyle =$GlobalHeaderFontStyle;
	 if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>

}
.latestpageheader a:visited{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
color:#<? echo $GlobalHeaderTextColor;?>;
<? if ($GlobalHeaderImage != '') {
$CSSImage =$GlobalHeaderImage;
$CSSRepeat = $GlobalHeaderImageRepeat;
list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $GlobalHeaderBGColor;?>;
font-size:<? echo $GlobalHeaderFontSize;?>px;
<?
	$FontStyle =$GlobalHeaderFontStyle;
	 if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>

}

.blogtitle {
font-size:14px;
font-weight:bold;


}

.blogdate {
font-size:12px;
}
.globalheader{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
text-align:left;
color:#<? echo $GlobalHeaderTextColor;?>;
<? if ($GlobalHeaderImage != '') {
$CSSImage =$GlobalHeaderImage;
$CSSRepeat = $GlobalHeaderImageRepeat;
list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $GlobalHeaderBGColor;?>;
font-size:<? echo $GlobalHeaderFontSize;?>px;
<?
	$FontStyle =$GlobalHeaderFontStyle;
	 if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
}	
 
.global_button{
padding:3px;
<? if ($ButtonImage != '') {
		 	$CSSImage =$ButtonImage;
			$CSSRepeat = $ButtonImageRepeat;
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>

<? if ($ButtonBGColor != '') {
			$BgColor =$ButtonBGColor;
		
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if ($ButtonTextColor != '') {
			$TextColor =$ButtonTextColor;
		
?>
color:#<? echo $ButtonTextColor;?>;
<? }?>
<? if ($ButtonFontSize != '') {
			$FontSize =$ButtonFontSize;
		
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if ($ButtonFontStyle != '') {
		$FontStyle =$ButtonFontStyle;
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}

.global_button{
padding:3px;
<? if ($ButtonImage != '') {
		 	$CSSImage =$ButtonImage;
			$CSSRepeat = $ButtonImageRepeat;
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>

<? if ($ButtonBGColor != '') {
			$BgColor =$ButtonBGColor;
		
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if ($ButtonTextColor != '') {
			$TextColor =$ButtonTextColor;
		
?>
color:#<? echo $ButtonTextColor;?>;
<? }?>
<? if ($ButtonFontSize != '') {
			$FontSize =$ButtonFontSize;
		
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if ($ButtonFontStyle != '') {
		$FontStyle =$ButtonFontStyle;
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}		

#FirstButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($FirstButtonBGColor != '') { ?>
background-color:#<? echo $FirstButtonBGColor;?>;
<? }?>
<? if ($FirstButtonTextColor != '') { ?>
color:#<? echo $FirstButtonTextColor;?>;
<? }?>
}

#NextButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($NextButtonBGColor != '') { ?>
background-color:#<? echo $NextButtonBGColor;?>;
<? }?>
<? if ($NextButtonTextColor != '') { ?>
color:#<? echo $NextButtonTextColor;?>;
<? }?>
}

#BackButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($BackButtonBGColor != '') { ?>
background-color:#<? echo $BackButtonBGColor;?>;
<? }?>
<? if ($BackButtonTextColor != '') { ?>
color:#<? echo $BackButtonTextColor;?>;
<? }?>
}
#LastButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($LastButtonBGColor != '') { ?>
background-color:#<? echo $LastButtonBGColor;?>;
<? }?>
<? if ($LastButtonTextColor != '') { ?>
color:#<? echo $LastButtonTextColor;?>;
<? }?>
}	
#HomeButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($HomeButtonBGColor != '') { ?>
background-color:#<? echo $HomeButtonBGColor;?>;
<? }?>
<? if ($HomeButtonTextColor != '') { ?>
color:#<? echo $HomeButtonTextColor;?>;
<? }?>
}	
#CreatorButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($CreatorButtonBGColor != '') { ?>
background-color:#<? echo $CreatorButtonBGColor;?>;
<? }?>
<? if ($CreatorButtonTextColor != '') { ?>
color:#<? echo $CreatorButtonTextColor;?>;
<? }?>
}		
#CharactersButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($CharactersButtonBGColor != '') { ?>
background-color:#<? echo $CharactersButtonBGColor;?>;
<? }?>
<? if ($CharactersButtonTextColor != '') { ?>
color:#<? echo $CharactersButtonTextColor;?>;
<? }?>
}	

#DownloadsButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($DownloadsButtonBGColor != '') { ?>
background-color:#<? echo $DownloadsButtonBGColor;?>;
<? }?>
<? if ($DownloadsButtonTextColor != '') { ?>
color:#<? echo $DownloadsButtonTextColor;?>;
<? }?>
}		
#ExtrasButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($ExtrasButtonBGColor != '') { ?>
background-color:#<? echo $ExtrasButtonBGColor;?>;
<? }?>
<? if ($ExtrasButtonTextColor != '') { ?>
color:#<? echo $ExtrasButtonTextColor;?>;
<? }?>
}

#EpisodesButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($EpisodesButtonBGColor == '') { 
		$BGColor = $GlobalButtonBGColor;
		
	} else {
		$BGColor = $EpisodesButtonBGColor;
	}
?>
background-color:#<? echo $BGColor;?>;

<? if ($EpisodesButtonTextColor == '') {
		$Color = $GlobalButtonTextColor;
	} else {
		$Color = $EpisodesButtonTextColor;
	}

 ?>
color:#<? echo $Color;?>;

}
#MobileButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($MobileButtonBGColor != '') { ?>
background-color:#<? echo $MobileButtonBGColor;?>;
<? }?>
<? if ($MobileButtonTextColor != '') { ?>
color:#<? echo $MobileButtonTextColor;?>;
<? }?>
}		
#ProductsButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($ProductsButtonBGColor != '') { ?>
background-color:#<? echo $ProductsButtonBGColor;?>;
<? }?>
<? if ($ProductsButtonTextColor != '') { ?>
color:#<? echo $ProductsButtonTextColor;?>;
<? }?>
}	
		
#CommentButton{

<? if ($CommentButtonBGColor != '') { ?>
background-color:#<? echo $CommentButtonBGColor;?>;
<? }?>
<? if ($CommentButtonBGColor != '') { ?>
color:#<? echo $CommentButtonTextColor;?>;
<? }?>
}	
#VoteButton{

<? if ($VoteButtonBGColor != '') { ?>
background-color:#<? echo $VoteButtonBGColor;?>;
<? }?>
<? if ($VoteButtonTextColor != '') { ?>
color:#<? echo $VoteButtonTextColor;?>;
<? }?>
}			

#LogoutButton{

<? if ($LogoutButtonBGColor != '') { ?>
background-color:#<? echo $LogoutButtonBGColor;?>;
<? }?>
<? if ($LogoutButtonTextColor != '') { ?>
color:#<? echo $LogoutButtonTextColor;?>;
<? }?>
}			
.pagelinks {
<? 
if ($GlobalSiteLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalSiteLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalSiteLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalSiteLinkTextColor;?>;
}
.pagelinks a{
<? 
if ($GlobalSiteLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalSiteLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalSiteLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalSiteLinkTextColor;?>;
}
.pagelinks a:link{
	<? 
if ($GlobalSiteLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalSiteLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalSiteLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalSiteLinkTextColor;?>;
}
.pagelinks a:visited { 
<? 
if ($GlobalSiteVisitedFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalSiteVisitedFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;'; 
if ($GlobalSiteVisitedFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
color:#<?php echo $GlobalSiteVisitedTextColor;?>;
}
.pagelinks a:hover{
	<? 
if ($GlobalSiteHoverFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalSiteHoverFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalSiteHoverFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalSiteHoverTextColor;?>;
}

.buttonlinks {
<? 
if ($GlobalButtonLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalButtonLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalButtonLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalButtonLinkTextColor;?>;
}
.global_button a{
<? 
if ($GlobalButtonLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalButtonLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalButtonLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalButtonLinkTextColor;?>;
}
.global_button a:link{
	<? 
if ($GlobalButtonLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalButtonLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalButtonLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalButtonLinkTextColor;?>;
}
.global_button a:visited{ 
<? 
if ($GlobalButtonVisitedFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalButtonVisitedFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;'; 
if ($GlobalButtonVisitedFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
color:#<?php echo $GlobalButtonVisitedTextColor;?>;
}
.global_button a:hover{
	<? 
if ($GlobalButtonHoverFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalButtonHoverFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalButtonHoverFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalButtonHoverTextColor;?>;
}
-->
</style>
  
</head>
<body>
<center>
<div id="preview_wrapper" >
<? echo $TemplateHTML;?>
</div>
</center>
</body>
</html>