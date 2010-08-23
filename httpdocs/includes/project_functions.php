<?php 

function CreateNewImgTag($imageTag)
{
	$imageTag_lowercase = strtolower($imageTag);
	$startpos = strpos($imageTag_lowercase, 'src=');
	if ($startpos > 0)
	{
		$containsdoublequot = false;
		$containssinglequot = false;		
		if ($imageTag_lowercase[$startpos + 4] == '"')
			$containsdoublequot = true;
		else if ($imageTag_lowercase[$startpos + 4] == "'")
			$containssinglequot = true;		
		
		if (($containsdoublequot) || ($containssinglequot))
			$startpos += 5;
		else
			$startpos += 4;
		
		if ($containsdoublequot)
			$endpos = strpos($imageTag_lowercase, '"', $startpos);
		else if ($containssinglequot)
			$endpos = strpos($imageTag_lowercase, "'", $startpos);
		else
			$endpos = strpos($imageTag_lowercase, " ", $startpos);
			
		$src = 	substr($imageTag, $startpos, $endpos - $startpos);
	}
	
	$startpos = strpos($imageTag_lowercase, 'alt=');
	if ($startpos > 0)
	{
		$containsdoublequot = false;
		$containssinglequot = false;		
		if ($imageTag_lowercase[$startpos + 4] == '"')
			$containsdoublequot = true;
		else if ($imageTag_lowercase[$startpos + 4] == "'")
			$containssinglequot = true;		
		
		if (($containsdoublequot) || ($containssinglequot))
			$startpos += 5;
		else
			$startpos += 4;
		
		if ($containsdoublequot)
			$endpos = strpos($imageTag_lowercase, '"', $startpos);
		else if ($containssinglequot)
			$endpos = strpos($imageTag_lowercase, "'", $startpos);
		else
			$endpos = strpos($imageTag_lowercase, " ", $startpos);
			
		$alt = 	substr($imageTag, $startpos, $endpos - $startpos);
	}
	
	$httpsrc = strpos($src, 'http://');
	if ($httpsrc === false) 
	{
		$FilenameArray = explode('/',$src);
		$ArrayLength = sizeof($FilenameArray);
		$NewSource = $FilenameArray[$ArrayLength-1];
		$NewPath = 'http://www.panelflow.com/comics/'.$FilenameArray[$ArrayLength-4].'/'.$FilenameArray[$ArrayLength-3].'/'.$FilenameArray[$ArrayLength-2].'/'.$FilenameArray[$ArrayLength-1];
		// this is a realtive path make it correct
		$src = $NewPath;
	}
	
	list($width,$height)=getimagesize($src);
	if ($width > 700)
	{
		$ImageWidth = "width='700'";// need to wrap click img tag
		$wrapper = '<center><a href="'.$src.'" rel="facebox">';
		$endwrapper = '</a></center>';
		$border ="style='border:#000000 1px solid;'";
	} else  {
			$ImageWidth = '';
	}
		
	
	$newImageTag = $wrapper.'<img src="' . $src . '" alt="' . $alt . '" '.$ImageWidth.' '.$border.'/>'.$endwrapper;
	return $newImageTag;
}
function setmodulehtml($Module,$Layout='') {
global $AuthorCommentString, $PageCommentString,$ComicSynopsisString, $LoginModuleString,$CommentBoxString,$UserModuleString,$ComicModuleString,$LinksModuleString, $ProductsModuleString, $MobileModuleString,$HomecomiccreditsString,$HomecomicsynopsisString,$HomeothercreatorcomicsString,$HomecharactersString,$HomestatusString,$HomeepisodesString,$HomelinksboxString,$HomeothercreatorcomicsString,$HomeauthcommString,$TwitterString,$TwitterString,$MenuOneString,$MenuTwoString,$StandardMenuOne,$StandardMenuTwo,$MenuOneLayout,$MenuTwoLayout,$MenuOneCustom,$MenuTwoCustom, $BlogModuleString,$HomedownloadsString,$CustomModuleCode,$LatestPageMod,$CharactersModuleString;

 switch ($Module) {

   		 		case 'authcom':
					return $AuthorCommentString;
					break;
				case 'twitter':
					return $TwitterString;
					break;
				case 'pagecom':
					return $PageCommentString;
					break;
    			case 'comicinfo':
					return $ComicModuleString;
					break;
				case 'comicsyn':
					return $ComicSynopsisString;
					break;
				case 'comform':
					return $CommentBoxString;
					break;
				case 'logform':
					return $LoginModuleString;
					break;
				case 'usermod':
					return $UserModuleString;
					break;
				case 'linksbox':
					return $LinksModuleString;
					break;	
				case 'products':
					return $ProductsModuleString;
					break;
				case 'mobile':
					return $MobileModuleString;
					break;	
				case 'comiccredits':
					return $HomecomiccreditsString;
					break;
				case 'comicsynopsis':
					return $HomecomicsynopsisString;
					break;		
				case 'characters':
					return $CharactersModuleString;
					
					
					break;	
				case 'othercreatorcomics':
					return $HomeothercreatorcomicsString;
					break;	
				case 'episodes':
					return $HomeepisodesString;
					break;	
				case 'status':
					return $HomestatusString;
					break;		
				case 'downloads':
					return $HomedownloadsString;
					break;
				case 'authcomm':
					return $AuthorCommentString;
					break;
				case 'blog':
					return $BlogModuleString;
					break;
				case 'latestpage':
					return $LatestPageMod;
					break;
				case 'menuone':
					$ReturnString = '';
					if (($MenuOneCustom == 1) && ($MenuOneLayout == $Layout)) 
						$ReturnString .= $MenuOneString;
					else if (($MenuOneCustom == 0) && ($MenuOneLayout == $Layout)) 
						$ReturnString .= $StandardMenuOne;
					return $ReturnString;
					break;
				case 'menutwo':
					$ReturnString = '';
					if (($MenuTwoCustom == 1) && ($MenuTwoLayout == $Layout)) 
						$ReturnString .= $MenuTwoString;
					else if (($MenuTwoCustom == 0) && ($MenuTwoLayout == $Layout)) 
						$ReturnString .= $StandardMenuTwo;
					return $ReturnString;
					break;
					
					case 'custommod':
					return $CustomModuleCode;
					break;
					
					
		}

}

function setheader($Module) {
global $AuthorCommentImage, $UserCommentsImage, $ComicInfoImage, $ComicSynopsisImage,$ComicSynopsisTitle,$ComicInfoTitle,$AuthorCommentTitle, $UserCommentsTitle,$LinksBoxTitle,$ProductsTitle, $ProductsImage, $MobileTitle, $MobileImage, $LinksBoxImage, $LinksBoxTitle, $ComicFolder,$TwitterTitle,$CustomModuleCode,$SafeFolder;
 switch ($Module) {
   		 		case 'authcom':
					$HeaderString = '<div id="AuthorComment">';
					if ($AuthorCommentImage == '') {
						if ($AuthorCommentTitle == '') {
							$HeaderString .='Author Notes';
						} else {
							$HeaderString .=$AuthorCommentTitle;
						}
					}
			
					$HeaderString .='</div>';
					return $HeaderString;
					break;
				case 'authcomm':
					$HeaderString = '<div id="AuthorComment">';
					if ($AuthorCommentImage == '') {
						if ($AuthorCommentTitle == '') {
							$HeaderString .='Author Notes';
						} else {
							$HeaderString .=$AuthorCommentTitle;
						}
					}
					$HeaderString .='</div>';
					return $HeaderString;
					break;
				case 'LatestPageMod':
					$HeaderString .= '<div class="globalheader">read the latest page</div>';
					return $HeaderString;
					break;
					
				case 'pagecom':
					$HeaderString = '<div id="UserComments">';
					if ($UserCommentsImage == '') {
						if ($UserCommentsTitle == '') {
							$HeaderString .='Comments';
						} else {
							$HeaderString .=$UserCommentsTitle;
						}
						
					}
					$HeaderString .='</div>';
					return $HeaderString;
					break;
    			case 'comicinfo':
					$HeaderString .= '<div id="ComicInfo">';
					if ($ComicInfoImage == '') {
						if ($ComicInfoTitle == '') {
							$HeaderString .='Comic Info';
						} else {
							$HeaderString .=$ComicInfoTitle;
						}
					}
					$HeaderString .='</div>';
					return $HeaderString;
					break;
				case 'comicsyn':
					$HeaderString .= '<div id="ComicSynopsis">';
					if ($ComicSynopsisImage == '') {
						if ($ComicSynopsisTitle == '') {
							$HeaderString .='Synopsis';
						} else {
							$HeaderString .=$ComicSynopsisTitle;
						}
					}
					$HeaderString .='</div>';
					return $HeaderString;
					break;
					
				case 'linksbox':
					$HeaderString .= '<div id="LinksBox">';

						if ($LinksBoxTitle == '') {
							$HeaderString .='Links';
						} else {
							$HeaderString .=$LinksBoxTitle;
						}
			
					$HeaderString .='</div>';
					return $HeaderString;
					break;	
				
				case 'products':
					$HeaderString .= '<div id="Products" class="globalheader">';

						if ($ProductsTitle == '') {
							$HeaderString .='Products';
						} else {
							$HeaderString .=$ProductsTitle;
						}
			
					$HeaderString .="&nbsp;&nbsp;[<span class='pagelinks'><a href='/".$SafeFolder."/products/' >SEE MORE</a></span>]</div>";
					return $HeaderString;
					break;	
				
				case 'mobile':
					$HeaderString .= '<div id="Mobile" class="globalheader">';

						if ($MobileTitle == '') {
							$HeaderString .='Mobile';
						} else {
							$HeaderString .=$MobileTitle;
						}
			
					$HeaderString .="&nbsp;&nbsp;[<span class='pagelinks'><a href='/".$SafeFolder."/mobile/' >SEE MORE</a></span>]</div>";
					return $HeaderString;
					break;
			
				case 'characters':
					$HeaderString .= '<div id="characters" class="globalheader">';

						if ($CharactersTitle == '') {
							$HeaderString .='Characters';
						} else {
							$HeaderString .=$CharactersTitle;
						}
			
					$HeaderString .="&nbsp;&nbsp;[<span class='pagelinks'><a href='/".$SafeFolder."/characters/' >SEE MORE</a></span>]</div>";
					return $HeaderString;
					break;
				case 'downloads':
					$HeaderString .= '<div id="Downloads" class="globalheader">';

						if ($DownloadsTitle == '') {
							$HeaderString .='Downloads';
						} else {
							$HeaderString .=$DownloadsTitle;
						}
			
					$HeaderString .="&nbsp;&nbsp;[<span class='pagelinks'><a href='/".$SafeFolder."/downloads/' >SEE MORE</a></span>]</div>";
					return $HeaderString;
					break;
				case 'othercreatorcomics':
					$HeaderString .= '<div id="Comics" class="globalheader">';

						if ($OtherComicsTitle == '') {
							$HeaderString .='Creator\'s Comics';
						} else {
							$HeaderString .=$OtherComicsTitle;
						}
			
					$HeaderString .='</div>';
					return $HeaderString;
					break;
				case 'comicsynopsis':
					$HeaderString .= '<div id="Synopsis" class="globalheader">';

						if ($SynopsisTitle == '') {
							$HeaderString .='Synopsis';
						} else {
							$HeaderString .=$SynopsisTitle;
						}
			
					$HeaderString .='</div>';
					return $HeaderString;
					break;
				case 'status':
					$HeaderString .= '<div id="Status" class="globalheader">';

						if ($StatusTitle == '') {
							$HeaderString .='Status';
						} else {
							$HeaderString .=$StatusTitle;
						}
			
					$HeaderString .='</div>';
					return $HeaderString;
					break;
					
				case 'comiccredits':
					$HeaderString .= '<div id="ComicCredits" class="globalheader">';

						if ($CreditsTitle == '') {
							$HeaderString .='Credits';
						} else {
							$HeaderString .=$CreditsTitle;
						}
			
					$HeaderString .='</div>';
					return $HeaderString;
					break;
					
				case 'episodes':
					$HeaderString .= '<div id="Episodes" class="globalheader">';

						if ($EpisodesTitle == '') {
							$HeaderString .='Episodes';
						} else {
							$HeaderString .=$EpisodesTitle;
						}
			
					$HeaderString .='</div>';
					return $HeaderString;
					break;
					
					case 'twitter':
					$HeaderString .= '<div id="Twitter" class="globalheader">';

						if ($TwitterTitle == '') {
							$HeaderString .='Twitter Updates';
						} else {
							$HeaderString .=$TwitterTitle;
						}
			
					$HeaderString .='</div>';
					return $HeaderString;
					break;
					case 'blog':
					$HeaderString .= '<div class="globalheader">';

						if ($BlogTitle == '') {
							$HeaderString .='Recent Blog Posts <span class="pagelinks">[<a href="/'.$SafeFolder.'/blog/">read blog</a>]';
						} else {
							$HeaderString .=$BlogTitle;
						}
			
					$HeaderString .='</div>';
					return $HeaderString;
					break;
					
				
					
		}

}


function build_template ($Html, $Section) {
global $AuthorCommentString, $PageCommentString,$ComicSynopsisString, $LoginModuleString,$CommentBoxString,$UserModuleString,$ComicModuleString,$LinksModuleString, $ProductsModuleString, $MobileModuleString,$HomecomiccreditsString,$HomecomicsynopsisString,$HomeothercreatorcomicsString,$HomecharactersString,$HomestatusString,$HomeepisodesString,$HomelinksboxString,$HomeothercreatorcomicsString,$HomeauthcommString,$TwitterString,$MenuOneString,$MenuTwoString,$StandardMenuOne,$StandardMenuTwo,$MenuOneLayout,$MenuTwoLayout,$MenuOneCustom,$MenuTwoCustom, $BlogModuleString,$PreloaderString, $MenuOneString, $MenuTwoString,$PositionFiveAdCode,$PositionOneAdCode,$PositionTwoAdCode,$PositionThreeAdCode,$PositionFourAdCode,$PageReader,$UpdateBox,$NextPage,$PrevPage,$lastpage,$ComicFolder,$BlogReaderString,$MainCreatorProfileString,$DownloadsString, $ProductsString,$MobileString,$CharactersPlayerString,$CharactersString,$EpisodesTemplateString,$ContactTemplateString,$SidebarString,$HomedownloadsString,$ArchivesString,$CustomModuleCode,$LinksString,$CharactersCustom,
$CharactersHTML,$CreditsCustom,$CreditsHTML,$DownloadsCustom,$DownloadsHTML,$EpisodesCustom,$EpisodesHTML;

$ModuleTop = '<table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td id="modtopleft"></td><td id="modtop"></td><td id="modtopright"></td></tr><tr><td id="modleftside"></td><td class="boxcontent" valign="top">';
$ModuleBottom = '</td><td id="modrightside"></td></tr><tr><td id="modbottomleft"></td><td id="modbottom"></td><td id="modbottomright"></td></tr></table>';

$String = $Html;
if (($Section == 'Pages') || ($Section == 'Extras')){
	$String=str_replace("{content}",$PageReader,$String);
}else if ($Section == 'Products'){
	$String=str_replace("{content}",$ProductsString,$String);
}else if ($Section == 'Mobile'){
	$String=str_replace("{content}",$MobileString,$String);
}else if ($Section == 'Downloads'){
	if ($DownloadsCustom == 1) 
		$String=str_replace("{content}",$DownloadsHTML,$String);
	else
		$String=str_replace("{content}",$DownloadsString,$String);
}else if ($Section == 'Creator'){
	if ($CreditsCustom == 1) 
		$String=str_replace("{content}",$CreditsHTML,$String);	
	else
		$String=str_replace("{content}",$MainCreatorProfileString,$String);	
}else if ($Section == 'Episodes'){
	if ($EpisodesCustom == 1) 
		$String=str_replace("{content}",$EpisodesHTML,$String);
	else
		$String=str_replace("{content}",$EpisodesTemplateString,$String);
}else if ($Section == 'Contact'){
	$String=str_replace("{content}",$ContactTemplateString,$String);
}else if ($Section == 'Characters'){
	if ($CharactersCustom == 1) 
		$String=str_replace("{content}",$CharactersHTML,$String);	
	else
		$String=str_replace("{content}",$CharactersString.$CharactersPlayerString,$String);		
}else if ($Section == 'Blog'){
	$String=str_replace("{content}",$BlogReaderString,$String);	
}else if ($Section == 'Archives'){
	$String=str_replace("{content}",$ArchivesString,$String);	
}else if ($Section == 'Links'){
	$String=str_replace("{content}",$LinksString,$String);

}
$String=str_replace("{menuone}",$MenuOneString,$String); 
if (($Section == 'Pages') || ($Section == 'Extras'))
	$String=str_replace("{menutwo}",$MenuTwoString,$String); 
else 
	$String=str_replace("{menutwo}",'',$String); 
	
$String=str_replace("{UPDATE_BOX}",$UpdateBox,$String); 
$String=str_replace("{first_page}",'/'.$ComicFolder.'/page/1/',$String); 
$String=str_replace("{next_page}",'/'.$ComicFolder.'/page/'.$NextPage.'/',$String); 
$String=str_replace("{last_page}",'/'.$ComicFolder.'/page/'.$lastpage.'/',$String); 
$String=str_replace("{previous_page}",'/'.$ComicFolder.'/page/'.$PrevPage.'/',$String); 

$String=str_replace("{downloads}",$ModuleTop.setheader('downloads').$HomedownloadsString.$ModuleBottom ,$String); 

$String=str_replace("{custommod}",$ModuleTop.$CustomModuleCode.$ModuleBottom ,$String); 
$String=str_replace("{characters}",$ModuleTop.setheader('characters').$HomecharactersString.$ModuleBottom,$String); 
$String=str_replace("{status}",$ModuleTop.setheader('status').$HomestatusString.$ModuleBottom,$String); 
if (($Section == 'Pages') || ($Section == 'extras')) {
$String=str_replace("{synopsis}",$ModuleTop.setheader('comicsynopsis').$ComicSynopsisString.$ModuleBottom,$String);

$String=str_replace("{pagecomments}",$ModuleTop.setheader('pagecom').$PageCommentString.$ModuleBottom,$String); 
$String=str_replace("{authorcomment}",$ModuleTop.setheader('authcomm').$AuthorCommentString.$ModuleBottom,$String);
$String=str_replace("{commentbox}",$ModuleTop.$CommentBoxString.$ModuleBottom,$String);  
$String=str_replace("{comiccredits}",$ModuleTop.setheader('comicinfo').$ComicModuleString.$ModuleBottom,$String); 	
} else {
$String=str_replace("{synopsis}",'',$String); 
$String=str_replace("{pagecomments}",'',$String);
$String=str_replace("{authorcomment}",'',$String);
$String=str_replace("{commentbox}",'',$String);
$String=str_replace("{comiccredits}",'',$String);
}
$String=str_replace("{login}",$ModuleTop.$LoginModuleString.$ModuleBottom,$String); 	

$String=str_replace("{twitter}",$ModuleTop.setheader('twitter').$TwitterString.$ModuleBottom,$String); 
$String=str_replace("{linksbox}",$ModuleTop.setheader('linksbox').$LinksModuleString.$ModuleBottom,$String); 

$String=str_replace("{products}",$ModuleTop.setheader('products').$ProductsModuleString.$ModuleBottom,$String); 
$String=str_replace("{mobile}",$ModuleTop.setheader('mobile').$MobileModuleString.$ModuleBottom,$String); 
$String=str_replace("{othercomics}",$ModuleTop.setheader('othercreatorcomics').$HomeothercreatorcomicsString.$ModuleBottom,$String); 

if ($Section == 'Blog') {
	$String=str_replace("{blogsidebar}",$ModuleTop.$SidebarString.$ModuleBottom,$String); 
	$String=str_replace("{blog}",'',$String);
}else {
	$String=str_replace("{blog}",$ModuleTop.setheader('blog').$BlogModuleString.$ModuleBottom,$String); 
}	

$String=str_replace("{moduletop}",$ModuleTop,$String); 
$String=str_replace("{modulebottom}",$ModuleBottom,$String); 
return $String;

}

$PagePosition = $_GET['page'];
$PageID = $_GET['id'];
if ($PageID == "") {
	$PageID = $_POST['id'];
}
if ($PageID == "undefined") {
$PageID = "";
}


$CurrentDate = date('Y-m-d').' 00:00:00';


function build_menus($theme,$project,$custom,$MenuLayout) {
global $InitDB, $PFDIRECTORY, $SafeFolder, $NextPage, $lastpage, $PrevPage;



	if ($custom == 0) 
		$query = "select * from pf_themes_menus where ThemeID='$theme' and MenuParent=1 ORDER BY Parent, Position ASC";
	else
		$query = "select * from menu_links where ComicID='$project' and MenuParent=1 ORDER BY Parent, Position ASC";

	$InitDB->query($query);
	$NumLinks = $InitDB->numRows();
	//print $query;
	if ($NumLinks > 0) {
	$String = '<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr>';				
	
	
	while ($line = $InitDB->fetchNextObject()) { 
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
		
	//	print 'Section = ' . $line->ContentSection;
		if ($line->ContentSection == 'home'){
			$Url = '/'.$SafeFolder.'/';
		}else if ($line->LinkType == 'section'){
			$Url = '/'.$SafeFolder.'/'.$Url.'/';
		}else if ($line->LinkType == 'page')	{
			if ($Url == '{FirstPage}')
				$Url = '/'.$SafeFolder.'/reader/page/1/';
			else if ($Url == '{NextPage}')
				$Url = '/'.$SafeFolder.'/reader/page/'.$NextPage.'/';
			else if ($Url == '{PrevPage}')
				$Url = '/'.$SafeFolder.'/reader/page/'.$PrevPage.'/';
			else if ($Url == '{LastPage}')
				$Url = '/'.$SafeFolder.'/reader/page/'.$lastpage.'/';
		}
		$String .= $Url.'" target="'.$TargetStuff.'">'.$LinkStuff.'</a>';
		$LinkStuff = '';
		$String .= '</span>';
		$String .= '</td>';
	
		if ($MenuLayout == 'vertical')
			$String .='</tr><tr>';
		
	}
		
	$String .='</tr></table>';
	}
	return $String;
		
}
		
		$Version = 'Pro1-6';
		$config = array();
		$GetTwitter = 0;
		
		$query = "SELECT * from projects where SafeFolder='$ComicName'";
		$ProjectTableArray= $InitDB->queryUniqueObject($query);

		$ProjectID = $ProjectTableArray->ProjectID;
		if ($ProjectID == '')
			$ProjectID = $ProjectTableArray->comiccrypt;
		$ProjectType = $ProjectTableArray->ProjectType;
		$ComicID = $ProjectID;
		$_SESSION['viewingproject'] = $ProjectID;
		
		
		
		if ($ProjectType == 'comic') {
			$query = "SELECT * from comics where comiccrypt='$ProjectID'";
			$ProjectArray= $InitDB->queryUniqueObject($query);
		
			$BaseComicDirectory = '/comics/'.$ComicDir.'/'.$ComicName.'/';
			
			$query = "SELECT * from comic_settings where ComicID='$ProjectID'";
			$SettingArray= $InitDB->queryUniqueObject($query);
		
			$ComicTitle = stripslashes($ProjectArray->title);
			$Creator = $ProjectArray->creator;
			$Writer = $ProjectArray->writer;
			$Artist = $ProjectArray->artist;
			$Colorist = $ProjectArray->colorist;
			$Letterist = $ProjectArray->letterist;
			$Synopsis = $ProjectArray->synopsis;
			$Tags = $ProjectArray->tags;
			$Genre = $ProjectArray->genre;
			$ComicFolder = $ProjectArray->url;
			$RealComicCreator = $ProjectArray->CreatorID;
			$SafeFolder = $ProjectArray->SafeFolder;
			$ProjectTitle = $ComicTitle;
			$DefaultReader =  $ProjectArray->ReaderType;
		
			$CopyRight =$ProjectArray->Copyright; 
		
		}
		
		
		//GET CONTENT SECTION 
		if ($ContentUrl == '') {
		$query = "select * from content_section where ProjectID='$ProjectID' and TemplateSection='home'"; 
		$SectionArray = $InitDB->queryUniqueObject($query);
		$Col1Width = $SectionArray->Variable1;
		$Col2Width = $SectionArray->Variable2;
		
		} else {
		
		$query = "select * from content_section where ProjectID='$ProjectID' and LOWER(Title)='$ContentUrl'";
		$SectionArray = $InitDB->queryUniqueObject($query);
		$Section = ucfirst($SectionArray->TemplateSection);
		if ($Section == 'Reader')
			$Section = 'Pages';
		}
		$ContentTemplate = $SectionArray->Template;
		
		if (($SectionArray->IsCustom == 1) || ($SectionArray->Template == 'custom'))
	   	 	$CustomSection = 1;
		else
			$CustomSection = 0;
		
		$CustomSectionContent = $SectionArray->HTMLCode;
		//GET PROJECT ADMIN INFO
		$query = "SELECT * from users where encryptid='".$ProjectArray->userid."'";
		$AdminUserArray= $InitDB->queryUniqueObject($query);
		$AdminUser = $AdminUserArray->username;
		$AdminEmail = $AdminUserArray->email;
		$CreatorID = $AdminUserArray->encryptid;
		
		//GET CREATOR INFO
		$query = "select realname,Email, Avatar from creators where ComicID = '$ProjectID'";
		$CreatorArray = $InitDB->queryUniqueObject($query);
		$CreatorName = $CreatorArray->realname;
		$Avatar =$CreatorArray->Avatar;
		$CreatorEmail =$CreatorArray->Email;
			
		//INITITALIZE PROJECT SETTINGS
		$ContactSetting = $SettingArray->Contact;
		$CommentSetting = $SettingArray->AllowComments;
		$PublicComments = $SettingArray->AllowPublicComents;
		$ArchiveSetting = $SettingArray->ShowArchive;
		$CalendarSetting = $SettingArray->ShowCalendar;
		$ChapterSetting = $SettingArray->ShowChapter;
		$EpisodeSetting = $SettingArray->ShowEpisode;
		$Assistant1 = $SettingArray->Assistant1;
		$Assistant2 = $SettingArray->Assistant2; 
		$Assistant3 = $SettingArray->Assistant3;  
		$TEMPLATE = $SettingArray->Template;
		$ReaderType = $SettingArray->ReaderType;
		$SkinCode = $SettingArray->Skin;
		$MenuOneLayout = $SettingArray->MenuOneLayout;
		$MenuOneType = $SettingArray->MenuOneType;
		$MenuOneCustom = $SettingArray->MenuOneCustom;
		$CurrentTheme = $SettingArray->CurrentTheme;
		if ($CurrentTheme == '')
			$CurrentTheme = 1;

	
		$query =  "SELECT ts.*,tsk.*, t.HTMLCode, t.MenuLayout
			from pf_themes as th
			join templates as t on th.TemplateCode=t.TemplateCode
			join template_settings as ts on ('$TEMPLATE'=ts.TemplateCode and th.ID=ts.ThemeID and ProjectID='$ProjectID')
			join project_skins as tsk on '$SkinCode'=tsk.SkinCode 
			where th.ID='$CurrentTheme'";
		$TemplateArray = $InitDB->queryUniqueObject($query);
		
		if ($TemplateArray->ID == '') {
		$query =  "SELECT ts.*,tsk.*, t.HTMLCode, t.MenuLayout
			from pf_themes as th
			join templates as t on th.TemplateCode=t.TemplateCode
			join template_settings as ts on ('TPL-001'=ts.TemplateCode and th.ID=ts.ThemeID)
			join template_skins as tsk on '$SkinCode'=tsk.SkinCode 
			where th.ID='$CurrentTheme'";
		$TemplateArray = $InitDB->queryUniqueObject($query);
		
		}
		

		$TemplateHTML = $TemplateArray->HTMLCode;
		$MenuLayout = $TemplateArray->MenuLayout;
		$TemplateWidth = $TemplateArray->TemplateWidth;
		if ($TemplateWidth == '')
			$TemplateWidth = '100%';
	
		$HeaderWidth = $TemplateArray->HeaderWidth;
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
		else 
			$HeaderImage = '<a href="http://www.wevolt.com/'.$SafeFolder.'/">'.$HeaderImage.'</a>';
		
		$HeaderContent  = $HeaderImage.$TemplateSettingsArray->HeaderContent;
		$HeaderStyle =$HeaderWidth.$HeaderHeight.$HeaderBackground.$HeaderBackgroundRepeat.$HeaderBackgroundImagePosition.$HeaderAlign.$HeaderVAlign.$HeaderPadding;
		
		$MenuBackground = $TemplateArray->MenuBackground;
		$MenuBackgroundRepeat = $TemplateArray->MenuBackgroundRepeat;
		$MenuImage = $TemplateArray->MenuImage;
		$MenuHeight = $TemplateArray->MenuHeight;
		$MenuWidth = $TemplateArray->MenuWidth;
		
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
		
		$MenuContent = build_menus($CurrentTheme,$ProjectID,$MenuOneCustom,$MenuLayout);
		if ($MenuContent == '')
			$MenuContent = $TemplateArray->MenuContent;
		else
			$MenuContent .= $TemplateArray->MenuContent;
			
		$MenuStyle =$MenuWidth.$MenuHeight.$MenuBackground.$MenuBackgroundRepeat.$MenuBackgroundImagePosition.$MenuAlign.$MenuVAlign.$MenuPadding;
		
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
		
	
		//HARD CODE TEMPLATE
		$TEMPLATE = 'TPL-001';
		
		$UpdateScheduleArray = explode(',',$SettingArray->UpdateSchedule);
		$ScheduleString == '';
		$StringSet = 0;
		if (in_array('mon',$UpdateScheduleArray)) {
			$ScheduleString .= 'Monday';
			$StringSet = 1;
		}
		
		if (in_array('tues',$UpdateScheduleArray)) {
			if ($StringSet == 1)
				$ScheduleString .= ', ';
			$ScheduleString .= 'Tuesday';
			$StringSet = 1;
		}
		
		if (in_array('wed',$UpdateScheduleArray)) {
			if ($StringSet == 1)
				$ScheduleString .= ', ';
			$ScheduleString .= 'Wednesday';
			$StringSet = 1;
		}
		
		if (in_array('thur',$UpdateScheduleArray)) {
			if ($StringSet == 1)
				$ScheduleString .= ', ';
			$ScheduleString .= 'Thursday';
			$StringSet = 1;
		}
		
		if (in_array('fri',$UpdateScheduleArray)) {
			if ($StringSet == 1)
				$ScheduleString .= ', ';
			$ScheduleString .= 'Friday';
			$StringSet = 1;
		}
		
		if (in_array('sat',$UpdateScheduleArray)) {
			if ($StringSet == 1)
				$ScheduleString .= ', ';
			$ScheduleString .= 'Saturday';
			$StringSet = 1;
		}
		
		if (in_array('sun',$UpdateScheduleArray)) {
			if ($StringSet == 1)
				$ScheduleString .= ', ';
			$ScheduleString .= 'Sunday';
		}
		 
		$query = "SELECT * from project_skins where SkinCode='$SkinCode'";
		$SkinArray= $InitDB->queryUniqueObject($query);
		$BodyStyle = '';
				//SITE
		$GlobalSiteBGColor = $SkinArray->GlobalSiteBGColor;
		$GlobalSiteBGImage = $SkinArray->GlobalSiteBGImage;
		$GlobalSiteImageRepeat = $SkinArray->GlobalSiteImageRepeat;
		$GlobalSiteTextColor = $SkinArray->GlobalSiteTextColor;
		$GlobalSiteFontSize = $SkinArray->GlobalSiteFontSize;
		$GlobalSiteBGPosition = $SkinArray->GlobalSiteBGPosition;
		
	
		//BUTTONS
		$ButtonImage= $SkinArray->ButtonImage;
		$ButtonBGColor= $SkinArray->ButtonBGColor;
		$ButtonImageRepeat= $SkinArray->ButtonImageRepeat;
		$ButtonTextColor= $SkinArray->ButtonTextColor;
		$ButtonFontSize= $SkinArray->ButtonFontSize;
		$ButtonFontStyle= $SkinArray->ButtonFontStyle;
		$ButtonFontFamily = $SkinArray->ButtonFontFamily;
		$ButtonAlign = $SkinArray->ButtonAlign;
		$ButtonPaddingArray = explode(' ',$SkinArray->ButtonPadding);
		$ButtonPaddingTop = $ButtonPaddingArray[0];
		$ButtonPaddingRight = $ButtonPaddingArray[1];
		$ButtonPaddingBottom = $ButtonPaddingArray[2];
		$ButtonPaddingLeft = $ButtonPaddingArray[3];
		
		$FirstButtonImage= $SkinArray->FirstButtonImage;
		$FirstButtonRolloverImage= $SkinArray->FirstButtonRolloverImage;
		$FirstButtonBGColor= $SkinArray->FirstButtonBGColor;
		$FirstButtonTextColor= $SkinArray->FirstButtonTextColor;
		
		$NextButtonImage= $SkinArray->NextButtonImage;
		$NextButtonRolloverImage= $SkinArray->NextButtonRolloverImage;
		$NextButtonBGColor= $SkinArray->NextButtonBGColor;
		$NextButtonTextColor= $SkinArray->NextButtonTextColor;
		
		$BackButtonImage= $SkinArray->BackButtonImage;
		$BackButtonRolloverImage= $SkinArray->BackButtonRolloverImage;
		$BackButtonBGColor= $SkinArray->BackButtonBGColor;
		$BackButtonTextColor= $SkinArray->BackButtonTextColor;
		
		$LatestPageHeader = $SkinArray->LatestPageHeader;
		
		$LastButtonImage= $SkinArray->LastButtonImage;
		$LastButtonRolloverImage= $SkinArray->LastButtonRolloverImage;
		$LastButtonBGColor= $SkinArray->LastButtonBGColor;
		$LastButtonTextColor= $SkinArray->LastButtonTextColor;
		
				
		//CONTENT BOX
		if ($SkinArray->ModTopRightImage != '') 
			$ModTopRightImage= $BaseSkinDir.$SkinArray->ModTopRightImage;
		$ModTopRightBGColor= $SkinArray->ModTopRightBGColor;

		if ($SkinArray->ModTopLeftImage != '') 
			$ModTopLeftImage= $BaseSkinDir.$SkinArray->ModTopLeftImage;
		$ModTopLeftBGColor= $SkinArray->ModTopLeftBGColor;
		
		if ($SkinArray->ModBottomLeftImage != '') 
			$ModBottomLeftImage= $BaseSkinDir.$SkinArray->ModBottomLeftImage;
		$ModBottomLeftBGColor= $SkinArray->ModBottomLeftBGColor;
		
		if ($SkinArray->ModBottomRightImage != '') 
			$ModBottomRightImage= $BaseSkinDir.$SkinArray->ModBottomRightImage;
		$ModBottomRightBGColor= $SkinArray->ModBottomRightBGColor;
		
		if ($SkinArray->ModRightSideImage != '') 
			$ModRightSideImage= $BaseSkinDir.$SkinArray->ModRightSideImage;
		$ModRightSideBGColor= $SkinArray->ModRightSideBGColor;
		
		if ($SkinArray->ModLeftSideImage != '') 
			$ModLeftSideImage= $BaseSkinDir.$SkinArray->ModLeftSideImage;
		$ModLeftSideBGColor= $SkinArray->ModLeftSideBGColor;
		
		if ($SkinArray->ModTopImage != '') 
			$ModTopImage= $BaseSkinDir.$SkinArray->ModTopImage;
		$ModTopBGColor= $SkinArray->ModTopBGColor;
		
		if ($SkinArray->ModBottomImage != '') 
			$ModBottomImage= $BaseSkinDir.$SkinArray->ModBottomImage;
		$ModBottomBGColor= $SkinArray->ModBottomBGColor;
		
		if ($SkinArray->ContentBoxImage != '') 
			$ContentBoxImage= $BaseSkinDir.$SkinArray->ContentBoxImage;
		$ContentBoxBGColor= $SkinArray->ContentBoxBGColor;
		$ContentBoxImageRepeat= $SkinArray->ContentBoxImageRepeat;
		$ContentBoxTextColor= $SkinArray->ContentBoxTextColor;
		$ContentBoxFontSize= $SkinArray->ContentBoxFontSize;
		$Corner= $SkinArray->Corner;
		$ModuleSeparation = $SkinArray->ModuleSeparation;
		$RightColumnWidth = $SkinArray->RightColumnWidth;
		$LeftColumnWidth = $SkinArray->LeftColumnWidth;
		
		//HEADERS
		$GlobalHeaderImage= $SkinArray->GlobalHeaderImage;
		$GlobalHeaderBGColor= $SkinArray->GlobalHeaderBGColor;
		$GlobalHeaderImageRepeat= $SkinArray->GlobalHeaderImageRepeat;
		$GlobalHeaderTextColor= $SkinArray->GlobalHeaderTextColor;
		$GlobalHeaderFontSize= $SkinArray->GlobalHeaderFontSize;
		$GlobalHeaderFontStyle= $SkinArray->GlobalHeaderFontStyle;
		$GlobalHeaderFontStyle= $SkinArray->GlobalHeaderFontStyle;
		$HeaderPlacement = $SkinArray->HeaderPlacement;
		$GlobalHeaderFontFamily = $SkinAarray->GlobalHeaderFontFamily;
		$query = "SELECT GlobalHeaderTextTransformation from project_skins where SkinCode='$SkinCode'";
		$GlobalHeaderTextTransformation =  $InitDB->queryUniqueValue($query);
		$AuthorCommentImage= $SkinArray->AuthorCommentImage;
		$AuthorCommentBGColor= $SkinArray->AuthorCommentBGColor;
		$AuthorCommentImageRepeat= $SkinArray->AuthorCommentImageRepeat;
		$AuthorCommentTextColor= $SkinArray->AuthorCommentTextColor;
		$AuthorCommentFontSize= $SkinArray->AuthorCommentFontSize;
		$AuthorCommentFontStyle= $SkinArray->AuthorCommentFontStyle;
		
		$ComicInfoImage= $SkinArray->ComicInfoImage;
		$ComicInfoBGColor= $SkinArray->ComicInfoBGColor;
		$ComicInfoImageRepeat= $SkinArray->ComicInfoImageRepeat;
		$ComicInfoTextColor= $SkinArray->ComicInfoTextColor;
		$ComicInfoFontSize= $SkinArray->ComicInfoFontSize;
		$ComicInfoFontStyle= $SkinArray->ComicInfoFontStyle;
		
		$UserCommentsImage= $SkinArray->UserCommentsImage;
		$UserCommentsBGColor= $SkinArray->UserCommentsBGColor;
		$UserCommentsImageRepeat= $SkinArray->UserCommentsImageRepeat;
		$UserCommentsTextColor= $SkinArray->UserCommentsTextColor;
		$UserCommentsFontSize= $SkinArray->UserCommentsFontSize;
		$UserCommentsFontStyle= $SkinArray->UserCommentsFontStyle;
		
		$MobileContentImage= $SkinArray->MobileContentImage;
		$MobileContentBGColor= $SkinArray->MobileContentBGColor;
		$MobileContentImageRepeat= $SkinArray->MobileContentImageRepeat;
		$MobileContentTextColor= $SkinArray->MobileContentTextColor;
		$MobileContentFontSize= $SkinArray->MobileContentFontSize;
		$MobileContentFontStyle= $SkinArray->MobileContentFontStyle;
		
		$ProductsImage= $SkinArray->ProductsImage;
		$ProductsBGColor= $SkinArray->ProductsBGColor;
		$ProductsImageRepeat= $SkinArray->ProductsImageRepeat;
		$ProductsTextColor= $SkinArray->ProductsTextColor;
		$ProductsFontSize= $SkinArray->ProductsFontSize;
		$ProductsFontStyle= $SkinArray->ProductsFontStyle;
		
		$ComicSynopsisImage= $SkinArray->ComicSynopsisImage;
		$ComicSynopsisBGColor= $SkinArray->ComicSynopsisBGColor;
		$ComicSynopsisImageRepeat= $SkinArray->ComicSynopsisImageRepeat;
		$ComicSynopsisTextColor= $SkinArray->ComicSynopsisTextColor;
		$ComicSynopsisFontSize= $SkinArray->ComicSynopsisFontSize;
		$ComicSynopsisFontStyle= $SkinArray->ComicSynopsisFontStyle;
		
		//PAGE READER
		$ControlBarImage= $SkinArray->ControlBarImage;
		$ControlBarImageRepeat= $SkinArray->ControlBarImageRepeat;
		$ControlBarBGColor= $SkinArray->ControlBarBGColor;
		$ControlBarTextColor= $SkinArray->ControlBarTextColor;
		$ControlBarFontSize = $SkinArray->ControlBarFontSize;
		$ControlBarFontStyle = $SkinArray->ControlBarFontStyle;
		$ReaderButtonBGColor = $SkinArray->ReaderButtonBGColor;
		$ReaderButtonAccentColor = $SkinArray->ReaderButtonAccentColor;
		$PageBGColor = $SkinArray->PageBGColor;
		$NavBarPlacement= $SkinArray->NavBarPlacement;
		$NavBarAlignment= $SkinArray->NavBarAlignment;
		$FlashReaderStyle= $SkinArray->FlashReaderStyle;
		
		//HotSpot Settings
		$BubbleClose = $SkinArray->BubbleClose;
		$BubbleOpen = $SkinArray->BubbleOpen;
		$HotSpotImage = $SkinArray->HotSpotImage;
		$HotSpotBGColor = $SkinArray->HotSpotBGColor;
		
		//CHARACTERS
		$CharacterReader = $SkinArray->CharacterReader;
		
			$GlobalSiteWidth = $TemplateWidth;
			$KeepWidth= 1;
			$GlobalSiteLinkTextColor= $SkinArray->GlobalSiteLinkTextColor;
			$GlobalSiteLinkFontStyle= $SkinArray->GlobalSiteLinkFontStyle;
			$GlobalSiteHoverTextColor= $SkinArray->GlobalSiteHoverTextColor;
			$GlobalSiteHoverFontStyle= $SkinArray->GlobalSiteHoverFontStyle;
			$GlobalSiteVisitedTextColor= $SkinArray->GlobalSiteVisitedTextColor;
			$GlobalSiteVisitedFontStyle= $SkinArray->GlobalSiteVisitedFontStyle;
			$GlobalButtonLinkTextColor= $SkinArray->GlobalButtonLinkTextColor;
			$GlobalButtonLinkFontStyle= $SkinArray->GlobalButtonLinkFontStyle;
			$GlobalButtonHoverTextColor= $SkinArray->GlobalButtonHoverTextColor;
			$GlobalButtonHoverFontStyle= $SkinArray->GlobalButtonHoverFontStyle;
			$GlobalButtonVisitedTextColor= $SkinArray->GlobalButtonVisitedTextColor;
			$GlobalButtonVisitedFontStyle= $SkinArray->GlobalButtonVisitedFontStyle;
			
			$GlobalTabInActiveBGColor= $SkinArray->GlobalTabInActiveBGColor;
			$GlobalTabInActiveFontStyle= $SkinArray->GlobalTabInActiveFontStyle;
			$GlobalTabInActiveTextColor= $SkinArray->GlobalTabInActiveTextColor;
			$GlobalTabInActiveFontSize= $SkinArray->GlobalTabInActiveFontSize;
			
			$GlobalTabActiveBGColor= $SkinArray->GlobalTabActiveBGColor;
			$GlobalTabActiveFontStyle= $SkinArray->GlobalTabActiveFontStyle;
			$GlobalTabActiveTextColor= $SkinArray->GlobalTabActiveTextColor;
			$GlobalTabActiveFontSize= $SkinArray->GlobalTabActiveFontSize;
			
			$GlobalTabHoverBGColor= $SkinArray->GlobalTabHoverBGColor;
			$GlobalTabHoverFontStyle= $SkinArray->GlobalTabHoverFontStyle;
			$GlobalTabHoverTextColor= $SkinArray->GlobalTabHoverTextColor;
			$GlobalTabHoverFontSize= $SkinArray->GlobalTabHoverFontSize;
				
				if ($GlobalSiteBGImage != '') {
					$BodyStyle .= 'background-image:url(http://www.wevolt.com/templates/skins/'.$SkinCode.'/images/'.$GlobalSiteBGImage.');';
					$BodyStyle .= 'background-repeat:'.$GlobalSiteImageRepeat.';';
				}
				$BodyStyle .= 'color:#'.$GlobalSiteTextColor.';';
				$BodyStyle .= 'font-size:'.$GlobalSiteFontSize.'px;';
				$BodyStyle .= 'background-color:#'.$GlobalSiteBGColor.';';
			
								
				$CharacterReader = $SkinArray->CharacterReader;
				
				//Bubble tip Settings
				$BubbleClose = $SkinArray->BubbleClose;
				$BubbleOpen = $SkinArray->BubbleOpen;
				$HotSpotImage = $SkinArray->HotSpotImage; 
				$HotSpotBGColor = $SkinArray->HotSpotBGColor;
				if ($HotSpotImage != '') {
				list($HotSpotWidth,$HotSpotHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$SkinCode.'/images/'.$SkinArray->HotSpotImage);
				}else {
					$HotSpotHeight = 5;
					$HotSpotWidth = 5;
				}
				
				if ($ReaderButtonBGColor == '') {
					$ReaderButtonBGColor = 'ffbd72';
				}
				$ButtonColor = '0x'.$ReaderButtonBGColor;
				$ReaderButtonAccentColor = $SkinArray->ReaderButtonAccentColor;
				if ($ReaderButtonAccentColor == '') {
					$ReaderButtonAccentColor = '000000';
				}
				$ArrowColor = '0x'.$ReaderButtonAccentColor;
				if ($SkinArray->PageBGColor == '') {
					$PageBGColor = $BarColor;
				} else {
					$PageBGColor = $SkinArray->PageBGColor; 
				}
				if ($ReaderCorner == 'round') {
					$MovieColor= '0x'.$GlobalSiteBGColor;
				} else {
					$MovieColor= $BarColor;
				}
				
				$BGcolor = $GlobalSiteBGColor;
				$Text = $TextColor; 
				list($CornerWidth,$CornerHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$SkinCode.'/images/'.$SkinArray->ModTopLeftImage);
		
				if ($ControlBarImage != '') {
					list($ControlWidth,$ControlHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/templates/skins/'.$SkinCode.'/images/'.$SkinArray->ControlBarImage);
				}
				if ($CornerWidth == '') {
					$CornerWidth = '15';
				}
				
				if ($CornerHeight == '') {
					$CornerHeight = '15';
				}
				
						
		
				$LeftColumModuleOrder = array();
				$RightColumModuleOrder = array();
				
				if ($Section == 'Home') {
					$query = "SELECT * from pf_modules where ComicID='$ProjectID' and Homepage=1 and IsPublished=1 and Placement='left' order by Position";
						$InitDB->query($query);
				}  else {
					$query = "SELECT * from pf_modules where ComicID='$ProjectID' and IsPublished=1 and Homepage=0 and Placement='left' order by Position";
						$InitDB->query($query);
				}
				
				if ($InitDB->numRows() == 0) {
					$LeftColumModuleOrder[] = 'LatestPageMod';
					$LeftColumModuleOrder[] = 'authcomm';
					
				}
				
			
				while ($line = $InitDB->fetchNextObject()) {
						if (($line->ModuleCode != 'menuone')&&($line->ModuleCode != 'menutwo')) 
						$LeftColumModuleOrder[] = $line->ModuleCode;
					
						if ($line->ModuleCode == 'twitter') {
							$Twittername = $line->CustomVar1;
							$TweetCount = $line->CustomVar2;
							$FollowLink = $line->CustomVar3;
							if ($Twittername == '')	
								$GetTwitter = 1;
						
						}
						if ($line->ModuleCode == 'custommod') {
							$CustomModuleCode = stripslashes($line->HTMLCode);
						
						}
				}
				
	
				if ($Section == 'Home') {
					$query = "SELECT * from pf_modules where ComicID='$ProjectID' and Homepage=1 and IsPublished=1 and Placement='right' order by Position";
						$InitDB->query($query);
				}  else {
					$query = "SELECT * from pf_modules where ComicID='$ProjectID' and IsPublished=1 and Homepage=0 and Placement='right' order by Position";
						$InitDB->query($query);
				}
				
				if ($InitDB->numRows() == 0) {
					$RightColumModuleOrder[] = 'comicsynopsis';
					$RightColumModuleOrder[] = 'comiccredits';
					
				}
			
				while ($line = $InitDB->fetchNextObject()) {
				if (($line->ModuleCode != 'menuone')&&($line->ModuleCode != 'menutwo')) 
						$RightColumModuleOrder[] = $line->ModuleCode; 
						if ($line->ModuleCode == 'twitter') {
							$Twittername = $line->CustomVar1;
							$TweetCount = $line->CustomVar2;
							$FollowLink = $line->CustomVar3;
							if ($Twittername == '')	
								$GetTwitter = 1;
						
						}
						
						if ($line->ModuleCode == 'custommod') {
							$CustomModuleCode = stripslashes($line->HTMLCode);
							
						}
				}	
				
				if ($HomepageActive == 0) {
				 	 $HomepageActive = 1;
				 }
				 
				 $HomeModuleArray = array();	
				 if (($Homepage == 1) && ($HomepageType == 'custom')) {	
					
					$query = "SELECT * from pf_modules where ComicID='$ProjectID' and IsPublished=1 and Homepage=1";
					$InitDB->query($query);
						while ($line = $settings->fetchNextObject()) {
							$HomeModuleArray[] = $line->ModuleCode;
					}	
				 
				 
				 } else {
				 		$HomepageType = 'standard';
				 }
		
		if ($GetTwitter == 1) 
			$Twittername = @file_get_contents ('https://www.panelflow.com/connectors/user_info.php?a=twitter&u='.$CreatorID.'&l='.$key);

		if ($_SESSION['email'] == $AdminEmail){
			 $_SESSION['usertype'] = '1';
		} else if (($_SESSION['email'] == $Assistant1)|| ($_SESSION['email'] == $Assistant2) || ($_SESSION['email'] == $Assistant3) || ($_SESSION['email'] == $CreatorEmail)) {
		$_SESSION['usertype'] = '2';
		$_SESSION['comicassist'] = $ComicID;
		} else {
		$_SESSION['usertype'] = '0';
		}
		
		if ($_SESSION['email'] == "") {
		$_SESSION['usertype'] = '0';
		} 



$query = "select count(*) from characters where ComicID = '$ComicID'";
$Characters = $InitDB->queryUniqueValue($query);
//print $query.'<br/>';
$query = "select count(*) from comic_pages where ComicID = '$ComicID' and PageType='pages' and PublishDate='$CurrentDate'";
$TodayPage = $InitDB->queryUniqueValue($query);

$query = "select ThumbLg from comic_pages where ComicID='$ComicID' and PublishDate<='$CurrentDate' order by PublishDate DESC";
$LatestPageThumb = $InitDB->queryUniqueValue($query);

$query = "select PublishDate from comic_pages where ComicID = '$ComicID' and PageType='pages' and PublishDate<='$CurrentDate' order by PublishDate DESC";
$LatestPage =  date('m.d.y',strtotime($InitDB->queryUniqueValue($query)));

$query = "select count(*) from comic_pages where ComicID = '$ComicID' and PageType='extras' and PublishDate='$CurrentDate'";
$TodayExtra = $InitDB->queryUniqueValue($query);

$query = "select count(*) from comic_downloads where ComicID = '$ComicID'";
$Downloads = $InitDB->queryUniqueValue($query);

$query = "select count(*) from comic_pages where PageType='extras' and ComicID = '$ComicID'";
$Extras =  $InitDB->queryUniqueValue($query);
 
$query = "select count(*) from mobile_content where ComicID = '$ComicID'";
$MobileContent=  $InitDB->queryUniqueValue($query);


$Links = '0';
//print $query.'<br/>';
if ($Characters > 0)
	$Characters = 1;

if ($Downloads > 0) 
	$Downloads = 1;

if ($Extras > 0) 
	$Extras = 1;

if ($Products > 0) 
	$Products = 1;

if ($MobileContent > 0) 
	$MobileContent = 1;

$Links = 0;
if ($Links >0)
	$Links = 1;

include $_SERVER['DOCUMENT_ROOT'].'/'.$PFDIRECTORY.'/templates/common/includes/favorites_inc.php'; 
include $_SERVER['DOCUMENT_ROOT'].'/'.$PFDIRECTORY.'/templates/common/includes/comment_inc.php';
include $_SERVER['DOCUMENT_ROOT'].'/'.$PFDIRECTORY.'/templates/common/includes/links_inc.php';
 
$story_array = array(); 
$counter = 0;

	$query = "select * from comic_pages where ComicID = '$ComicID' and PageType='pages' and PublishDate<='$CurrentDate' order by Position";
	$InitDB->query($query);
	$LatestPageCount = 1;
	$EpisodeCount = 0;
	$ChapterCount = 1;
	$InEpisode = 0;
	$LatestEpisode = 0;
	$EpisodePart = 1;
	while ($setting = $InitDB->fetchNextObject()) { 
		$LatestPageCount++;
		$story_array[$counter]->image = $setting->Image;
		$story_array[$counter]->id = $setting->EncryptPageID;
		$story_array[$counter]->comment = $setting->Comment;
		$story_array[$counter]->imgheight =$setting->ImageDimensions;
		$story_array[$counter]->title = $setting->Title;
		$story_array[$counter]->active = 1;
		$story_array[$counter]->datelive = $setting->Datelive;
		$story_array[$counter]->thumbsm = $setting->ThumbSm;
		$story_array[$counter]->thumbmd = $setting->ThumbMd;
		$story_array[$counter]->ThumbLg = $setting->ThumbLg;
		$story_array[$counter]->chapter = $setting->Chapter;
		$story_array[$counter]->episode =  $setting->Episode;
		$story_array[$counter]->EpisodeDesc =  $setting->EpisodeDesc;
		$story_array[$counter]->EpisodeWriter =  $setting->EpisodeWriter;
		$story_array[$counter]->EpisodeArtist =  $setting->EpisodeArtist;
		$story_array[$counter]->EpisodeColorist =  $setting->EpisodeColorist;
		$story_array[$counter]->EpisodeLetterer =  $setting->EpisodeLetterer;
		$story_array[$counter]->filename = $setting->Filename;
		$story_array[$counter]->position = $setting->Position;
		$story_array[$counter]->FileType = $setting->FileType;
		$story_array[$counter]->MediaFile = $setting->Filename;
		$counter++;
		if (($setting->Episode == 0) && ($InEpisode == 1)) {
			if ($LatestPageCount > 60) {
				$EpisodePart++;
				$LatestPageCount = 1;
			}	
		} else if (($setting->Episode == 1) && ($InEpisode == 0)) {
				$LatestEpisode++;	
				$LatestPageCount = 1;
		} else 	if (($setting->Episode == 0) && ($InEpisode == 0)) {
			if ($LatestPageCount > 60) {
				$EpisodePart++;
				$LatestPageCount = 1;
			}	
		}
		//print 'LATEST PAGE COUNT = ' .$LatestPageCount.' <br/>';	
	
		
	}			
	$PageLimit = 60;
	$PageCap = $EpisodePart*60;
	$PageFirst = (($EpisodePart*60) - 60);
	$PagesPagination = ((($EpisodePart*60) - 60)+1).'-'. $EpisodePart*60;
	include  $IncludesDirectory.$PFDIRECTORY.'/templates/common/includes/datecheck.php'; 
	
	
	if ($Section == 'Pages')  {	
		if ($PageID != '') {
			$query = "select Image from comic_pages where PageType='pencils' and ComicID = '$ComicID' and ParentPage='$PageID'";
			$PeelOne = $InitDB->queryUniqueValue($query);
			
			$query = "select Image from comic_pages where PageType='inks' and ComicID = '$ComicID' and ParentPage='$PageID'";
			$PeelTwo = $InitDB->queryUniqueValue($query);
			
			$query = "select Image from comic_pages where PageType='colors' and ComicID = '$ComicID' and ParentPage='$PageID'";
			$PeelThree = $InitDB->queryUniqueValue($query);
			
			$query = "select Image from comic_pages where PageType='script' and ComicID = '$ComicID' and ParentPage='$PageID'";
			$PeelFour = $InitDB->queryUniqueValue($query);
			
			if ($PeelFour != '') {
				$ScriptFileName = explode('.',$PeelFour);
				$ScriptPDF = $ScriptFileName[0].'.pdf';
				$ScriptHTML = $ScriptFileName[0].'.html';
			}
			$query = "SELECT count(*) as NumLikes, (SELECT count(*) from likes where (ContentID='$PageID' and ProjectID='$ComicID' and ContentType='project_page' and UserID='".$_SESSION['userid']."')) as UserLiked
			          from likes where ContentID='$PageID' and ProjectID='$ComicID' and ContentType='project_page'";
			$LikeArray = $InitDB->queryUniqueObject($query);
			$NumLikes = $LikeArray->NumLikes;
			$UserLiked = $LikeArray->UserLiked;
	
		  
			
			$query = "select * from pf_hotspots where ComicID = '$ComicID' and PageID='$PageID'";
			$InitDB->query($query);
			$AstArray = array();
			$MapArray = array();
			$PopupCodeArray = array();
			while ($hotspot = $InitDB->FetchNextObject()){
				$AstArray[] = $hotspot->AsterickCoords;
				$MapArray[] = $hotspot->HotSpotCoords;
				$PopupCodeArray[] = $hotspot->HTMLCode;
			}
			
		}
	}


$insertComment = $_POST['insert'];
$DeleteComment = $_POST['deletecomment'];
$ProfileComment = $_POST['profilecomment'];

//INSERT POFILE COMMENT
if ($ProfileComment == '1'){
	CommentProfile($_SESSION['username'], $_SESSION['userid'], $CreatorID, $_POST['txtFeedback'], date('D M j'), $_SERVER['REMOTE_ADDR']);
} 

//DELETE COMMENT
if ($DeleteComment == '1'){
	if ($Section == 'Blog')
		deleteComment('Blog',$ComicID, $_POST['id'], $_POST['commentid'],$db_database,$db_host, $db_user, $db_pass);
	else 
		deleteComment('Pages',$ComicID, $PageID, $_POST['commentid'],$db_database,$db_host, $db_user, $db_pass);?>
		 <script type="text/javascript">
			window.parent.location = 'http://www.wevolt.com/<? echo $SafeFolder;?>/reader/<? if ($_GET['episode'] != '') echo 'episode/'.$_GET['episode'].'/';?>page/<? echo $_GET['page'];?>/';
				
			
			</script>
<? }
//INSERT PAGE COMMENT
if ($insertComment == '1'){

 if(($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] )) || ($_SESSION['userid'] == '')) {
		unset($_SESSION['security_code']);
		setcookie("seccode", "", time()+60*60*24*100, "/");
		if ($_POST['txtFeedback'] == ''){
			$CommentError = 'You need to enter a comment';
		} else if (($_SESSION['userid'] == '') && ($_POST['txtName'] == '')){
			$CommentError = 'Please enter a name';
			
		} else {
		
		if ($_SESSION['userid'] == '')
			$CommentUserID = 'none';
		else 
			$CommentUserID = trim($_SESSION['userid']);
			
		$CommentUsername = addslashes($_POST['txtName']);
		
		if ($Section == 'Blog') {
			BlogComment($Section,$ComicID, $_POST['id'], $CommentUserID, $_POST['txtFeedback'],$db_database,$db_host, $db_user, $db_pass);
			
			 // header("location:/".$ComicFolder."/blog/".$_POST['id'].'/');
		
		} else {
			Comment($Section,$ComicID, $PageID, $CommentUserID, $_POST['txtFeedback'],$db_database,$db_host, $db_user, $db_pass);?>
            <script type="text/javascript">
			window.parent.location = 'http://www.wevolt.com/<? echo $SafeFolder;?>/reader/<? if ($_GET['episode'] != '') echo 'episode/'.$_GET['episode'].'/';?>page/<? echo $_GET['page'];?>/';
				
			
			</script>
            
            
            <?
			
			//if ($Section=='Extras')
			  // header("location:/".$ComicFolder."/reader/extras/page/".$_POST['position'].'/');
			//else 
			  //  header("location:".$ComicFolder."/reader/page/".$_POST['position'].'/');
		}
			
		}
   } else {
	$CommentError = 'invalid security code. Try Again.';
   }
}

//ADD FAV
if ($_POST['addfav'] == 1) 
	addfavorite($ComicID, $CreatorID, trim($_SESSION['userid']));



?>