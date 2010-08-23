<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class project {
		var $Title;
		var $Creator;
		var $Writer;
		var $Artist;
		var $Letterist;
		var $Synopsis;
		var $Genre;
		var $ComicFolder;
		var $SafeFolder;
		var $DefaultReader;
		var $Tags;
		var $CopyRight;	
		var $ProjectID;
		var $ProjectType;
		var $AdminUser;
		var $AdminEmail;
		var $CreatorID;
		var $CreatorName;
		var $Avatar;
		var $CreatorEmail;
		var $ContactSetting;
		var $CommentSetting;
		var $PublicComments;
		var $ArchiveSetting;
		var $CalendarSetting;
		var $EpisodeSetting;
		var $Assistant1;
		var $Assistant2;
		var $Assistant3;
		var $TEMPLATE;
		var $ReaderType;
		var $SkinCode;
		var $MenuOneLayout;
		var $MenuOneType;
		var $MenuOneCustom;
		var $CurrentTheme;
		var $AdminArray;
		var $CreatorArray;
		var $SettingsArray;
		var $CharacterCount;
		var $DownloadCount;
		var $ProductCount;
		var $MobileCount;
		var $TodaysPage;
		var $LatestPageThumb;
		var $LatestPage;
		var $CurrentDate;
		var $ProjectArray;
		var $LatestPageCount = 0;
		var $EpisodeCount = 0;
		var $ChapterCount = 1;
		var $InEpisode = 0;
		var $LatestEpisode = 0;
		var $EpisodePart = 1;
		var $TotalReaderPages;
		var $PagePosition;
		var $PageID;
		var $PageLikes;
		
		function __construct($SafeFolder) {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query = "SELECT p.*, u.username as AdminUser, u.email as AdminEmail, cr.realname as CreatorName, cr.Avatar as CreatorAvatar, cr.email as CreatorEmail
			          from projects as p
					  join users as u on u.encryptid=p.userid
					  join creators as cr on cr.ComicID=p.ProjectID
					  where p.SafeFolder='$SafeFolder'";


			
			$ProjectTableArray= $db->queryUniqueObject($query);
				
			$this->CurrentDate  = date('Y-m-d').' 00:00:00';
			$this->ProjectID = $ProjectTableArray->ProjectID;
			if ($this->ProjectID == '')
				$this->ProjectID = $ProjectTableArray->comiccrypt;
			
			$query = "select count(*) from characters where ComicID = '".$this->ProjectID."'";
			$this->CharacterCount = $db->queryUniqueValue($query);

			$query = "select count(*) from comic_pages where ComicID = '".$this->ProjectID."' and PageType='pages' and PublishDate='".$this->CurrentDate."'";
			$this->TodaysPage = $db->queryUniqueValue($query);
			
			$query = "select ThumbLg from comic_pages where ComicID='".$this->ProjectID."' and PublishDate<='".$this->CurrentDate."' order by PublishDate DESC";
			$this->LatestPageThumb = $db->queryUniqueValue($query);
					
			$query = "select PublishDate from comic_pages where ComicID = '".$this->ProjectID."' and PageType='pages' and PublishDate<='".$this->CurrentDate."' order by PublishDate DESC";
			$this->LatestPage =  date('m.d.y',strtotime($db->queryUniqueValue($query)));
			
			$query = "select count(*) from comic_downloads where ComicID = '".$this->ProjectID."'";
			$this->DownloadCount = $db->queryUniqueValue($query);
		
			$query = "select count(*) from mobile_content where ComicID = '".$this->ProjectID."'";
			$this->MobileCount=  $db->queryUniqueValue($query);
		
			$this->ProjectArray = array (
									'ProjectID'=>$ProjectTableArray->ProjectID,
									'ProjectType'=>$ProjectTableArray->ProjectType,
									'SafeFolder'=> $this->SafeFolder,
									'Title'=> stripslashes($ProjectTableArray->title),
									'Creator'=> $ProjectTableArray->creator,
									'Writer'=> $ProjectTableArray->writer,
									'Artist'=> $ProjectTableArray->artist,
									'Colorist'=> $ProjectTableArray->colorist,
									'Letterist'=> $ProjectTableArray->letterist,
									'Synopsis'=> $ProjectTableArray->synopsis,
									'Tags'=> $ProjectTableArray->tags,
									'Genre'=> $ProjectTableArray->genre,
									'ComicFolder'=> $ProjectTableArray->url,
									'CreatorID'=> $ProjectTableArray->CreatorID,
									'SafeFolder'=> $ProjectTableArray->SafeFolder,
									'DefaultReader'=>  $ProjectTableArray->ReaderType,
									'CopyRight'=>$ProjectTableArray->Copyright,
									'CharacterCount'=>$this->CharacterCount,
									'TodaysPage'=>$this->TodaysPage,
									'LatestPageThumb'=>$this->LatestPageThumb,
									'LatestPage'=>$this->LatestPage,
									'DownloadCount'=>$this->DownloadCount,
									'Thumb'=>$ProjectTableArray->thumb,
									'MobileCount'=>$this->MobileCount
								);
		
			
			$this->AdminArray = array (
										'Name'=>$this->AdminUser,
										'Email'=>$this->AdminEmail,
										'UserID'=>$this->AdminUserID
									);
			$this->CreatorArray = array (
											'Name'=>$this->CreatorName,
											'Avatar'=>$this->CreatorAvatar,
											'Email'=>$this->CreatorEmail,
											'UserID'=>$this->CreatorID
										);
			
			$query = "SELECT * from comic_settings where ComicID='".$this->ProjectID."'";
			$this->SettingsArray = $db->queryUniqueObject($query);
			
			$this->AssistantArray = array(
											'1'=>$this->SettingsArray->Assistant1,
											'2'=>$this->SettingsArray->Assistant2,
											'3'=>$this->SettingsArray->Assistant3
										);
			
			
			
			unset($ProjectTableArray);
			$db->close();
							
		 }
		 
		public function CreateNewImgTag($imageTag) {
				$imageTag_lowercase = strtolower($imageTag);
				$startpos = strpos($imageTag_lowercase, 'src=');
				if ($startpos > 0) {
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
					$NewPath = 'http://www.wevolt.com/comics/'.$FilenameArray[$ArrayLength-4].'/'.$FilenameArray[$ArrayLength-3].'/'.$FilenameArray[$ArrayLength-2].'/'.$FilenameArray[$ArrayLength-1];
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
		
		
		public function getModules($Section,$Placement) {
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				$ModuleOrder = array();
				if ($Section == 'Home') 
					$query = "SELECT * from pf_modules where ComicID='".$this->ProjectID."' and Homepage=1 and IsPublished=1 and Placement='$Placement' order by Position";
				else
					$query = "SELECT * from pf_modules where ComicID='".$this->ProjectID."' and IsPublished=1 and Homepage=0 and Placement='$Placement' order by Position";
				$db->query($query);
				$TotalMods = $db->numRows();
				
				if (( $TotalMods == 0) && ($Placement == 'left')) {
					$ModuleOrder[] = 'LatestPageMod';
					$ModuleOrder[] = 'authcomm';
				} else if (( $TotalMods == 0) && ($Placement == 'right')) {
					$ModuleOrder[] = 'comicsynopsis';
					$ModuleOrder[] = 'comiccredits';
				
				}
				while ($line = $db->fetchNextObject()) {
						if (($line->ModuleCode != 'menuone')&&($line->ModuleCode != 'menutwo')) 
							$ModuleOrder[] = $line->ModuleCode;
					
						if ($line->ModuleCode == 'twitter') {
							$Twittername = $line->CustomVar1;
							$TweetCount = $line->CustomVar2;
							$FollowLink = $line->CustomVar3;
							if ($Twittername == '')	
								$GetTwitter = 1;
						
						}
						if ($line->ModuleCode == 'custommod')
							$CustomModuleCode = stripslashes($line->HTMLCode);
						
				}
				$db->close();
				return $ModuleOrder;

		}
		
		public function setCurrentPosition($PagePosition) {
			$this->PagePosition = $PagePosition;
		}
		public function setPageID($PageID) {
			$this->PageID = $PageID;
		}
		public function getPages() {
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				$story_array = array(); 
				$this->TotalReaderPages = 0;
				$CurrentDate = date('Y-m-d 00:00:00');
				$query = "select * from comic_pages where ComicID = '".$this->ProjectID."' and PageType='pages' and PublishDate<='$CurrentDate' order by Position";
				$db->query($query);
				$this->TotalReaderPages = $db->numRows();
				if ($this->PagePosition == '')	
					$this->PagePosition = $this->TotalReaderPages;
					
				while ($setting = $db->fetchNextObject()) { 
						$this->LatestPageCount++;
						$story_array[]->image = $setting->Image;
						$story_array[]->id = $setting->EncryptPageID;
						$story_array[]->comment = $setting->Comment;
						$story_array[]->imgheight =$setting->ImageDimensions;
						$story_array[]->title = $setting->Title;
						$story_array[]->active = 1;
						$story_array[]->datelive = $setting->Datelive;
						$story_array[]->thumbsm = $setting->ThumbSm;
						$story_array[]->thumbmd = $setting->ThumbMd;
						$story_array[]->ThumbLg = $setting->ThumbLg;
						$story_array[]->chapter = $setting->Chapter;
						$story_array[]->episode =  $setting->Episode;
						$story_array[]->EpisodeDesc =  $setting->EpisodeDesc;
						$story_array[]->EpisodeWriter =  $setting->EpisodeWriter;
						$story_array[]->EpisodeArtist =  $setting->EpisodeArtist;
						$story_array[]->EpisodeColorist =  $setting->EpisodeColorist;
						$story_array[]->EpisodeLetterer =  $setting->EpisodeLetterer;
						$story_array[]->filename = $setting->Filename;
						$story_array[]->position = $setting->Position;
						$story_array[]->FileType = $setting->FileType;
						$story_array[]->MediaFile = $setting->Filename;
						
						if ($setting->Position == $this->PagePosition) 
							$this->CurrentIndex =($this->LatestPageCount-1);
							
						if (($setting->Episode == 0) && ($InEpisode == 1)) {
							if ($this->LatestPageCount > 60) {
								$this->EpisodePart++;
								$this->LatestPageCount = 1;
							}	
						} else if (($setting->Episode == 1) && ($this->InEpisode == 0)) {
								$this->LatestEpisode++;	
								$this->LatestPageCount = 1;
						} else 	if (($setting->Episode == 0) && ($this->InEpisode == 0)) {
							if ($LatestPageCount > 60) {
								$this->EpisodePart++;
								$this->LatestPageCount = 1;
							}	
						}	
		
				}	
				
				$this->PageID = 			$story_array[$this->CurrentIndex]->id;
				$this->AuthorComment = 		$story_array[$this->CurrentIndex]->Comment;
				$this->EpisodeDesc = 		$story_array[$this->CurrentIndex]->EpisodeDesc;
				$this->EpisodeWriter = 		$story_array[$this->CurrentIndex]->EpisodeWriter;
				$this->EpisodeArtist = 		$story_array[$this->CurrentIndex]->EpisodeArtist;
				$this->EpisodeColorist = 	$story_array[$this->CurrentIndex]->EpisodeColorist;
				$this->EpisodeLetterer = 	$story_array[$this->CurrentIndex]->EpisodeLetterer;
				$this->Image = 				$story_array[$this->CurrentIndex]->image;
				$this->Title = 				$story_array[$this->CurrentIndex]->title;
				$this->FileType = 			$story_array[$this->CurrentIndex]->FileType;
				$this->MediaFile = 			$story_array[$this->CurrentIndex]->filename;
				$this->ImageHeight = 		$story_array[$this->CurrentIndex]->imgheight;	

				if ($this->CurrentIndex != ($this->TotalReaderPages-1)) {
				  	  $this->NextPage = 	$story_array[$this->CurrentIndex+1]->position;
					  $this->NextPageImage = $story_array[$this->CurrentIndex+1]->image;
				 } else {
				  		$this->NextPage = 	$PagePosition;
						$this->NextPageImage = $story_array[$this->CurrentIndex]->image;
				 }
							
				 if ($this->CurrentIndex > 0) {
				     $this->PrevPage = $story_array[$this->CurrentIndex-1]->position;
					 $this->PrevPageImage = $story_array[$this->CurrentIndex-1]->image;
				  } else { 
					$this->PrevPage = $this->PagePosition;
				  }		
						
		}
		
		public function buildArchivesDropdown() {
						$boxString = '<form id="jumpbox" action="#" method="get">ARCHIVES<br/>';
						$ArchiveDropDown ='<select id="dropdown" style="width:100%;" name="url" onchange="window.location = this.options[this.selectedIndex].value;"> ';
						$TotalPages = 0;

						for ($k=0; $k< $this->TotalReaderPages; $k++){
							if ($story_array[$k]->episode == 1) {
								if (($InEpisode == 1) && ($FoundPage != 1)) {
									$ChapterString = '<table cellspacing="0" cellpadding="0" border="0" width="100%"><tr><td valign="top">';
								} else if ($InEpisode == 1){
									$InEpisode = 0;
								} else {
									$InEpisode = 1;
								}
			   					$EpisodeCount++;
								$ArchiveDropDown .= "<option style='background-color:#8cc2ff;' value='/";
								$ArchiveDropDown .= $SafeFolder.'/inlinereader/';
								$ArchiveDropDown .= "page/".$story_array[$k]->position."/'";
								if ($story_array[$k]->id==$this->PageID) {
					    				$FoundPage = 1;
										$ArchiveDropDown.= 'selected'; 
								} 
				
								$ArchiveDropDown .="><b>EPISODE </b>".$EpisodeCount." - ".$story_array[$k]->title."</option>";
								$episodeString .= "<div id='episodediv_".$EpisodeCount."'";
								$episodeselectString .= "<td id='episodetab_".$EpisodeCount."' onclick='episodetab_".$EpisodeCount."();' class='"; 
								if ($EpisodeCount > 1) {
									$episodeString .= "style='display:none;'";
									$episodeselectString  .= "tabinactive'";
						
								} else {
									$episodeselectString  .= "tabactive'";
								}
								$episodeselectString .= ">EPISODE ".$EpisodeCount."</td><td width='5'></td>";
					
								$episodeString .= "><table cellpadding='0' cellspacing='0' border='0'><tr><td valign='top' class='contentbox'><a href='/";
								$episodeString .= $SafeFolder.'/inlinereader/';
								$episodeString .= "page/".$story_array[$k]->position."/'";
								$episodeString .= "><img src='/".$story_array[$k]->ThumbLg."' border='2' style='border-color:#000000'></a></td><td valign='top' style='padding-left:5px; padding-right:5px;' class='contentbox' id='episodetd_".$EpisodeCount."'><font color='#".$ContentBoxTextColor."'>EPISODE ".$EpisodeCount."</font></div><div class='pagelinks'><div class='episodetitle'><a href='/".$SafeFolder."/inlinereader/page/".$story_array[$k]->position."/'>".$story_array[$k]->title."</a></div></div><div class='spacer'></div><font color='#".$ContentBoxTextColor."' style='font-size:".$ContentBoxFontSize."px;'>".$story_array[$k]->EpisodeDesc."<div class='spacer'></div>";
								
								if ($story_array[$k]->EpisodeWriter != '') {
										$episodeString .= "Script: ".$story_array[$k]->EpisodeWriter."<br/>";
										$EpisodeWriterTemp = $story_array[$k]->EpisodeWriter;
								}
								if ($story_array[$k]->EpisodeArtist != ''){
									$episodeString .= "Art: ".$story_array[$k]->EpisodeArtist."<br/>";
									$EpisodeArtistTemp = $story_array[$k]->EpisodeArtist;
								}
								if ($story_array[$k]->EpisodeColorist != ''){
									$episodeString .= "Colors: ".$story_array[$k]->EpisodeColorist."<br/>";
									$EpisodeColoristTemp = $story_array[$k]->EpisodeColorist;
								}
								if ($story_array[$k]->EpisodeLetterer != ''){
									$episodeString .= "Lettering: ".$story_array[$k]->EpisodeLetterer."<br/>";
									$EpisodeLettererTemp = $story_array[$k]->EpisodeLetterer;
								}
								$episodeString .= "</font></td></tr></table></div>";
							    $ChapterCount = 1;
					  			$ChapterPageCount = 1;
							}
							if ($story_array[$k]->episode != 1) {
								if ($story_array[$k]->chapter == 1) {
									if ($Inchapter == 1) 
			  	 						$ChapterPageCount = 1;
									$ArchiveDropDown .= "<option style='background-color:#fce4aa;' value='/".$this->SafeFolder."/inlinereader/page/".$story_array[$k]->position."/'";
									if ($story_array[$k]->id==$PageID) {
										$FoundPage = 1;
										if ($InEpisode == 1) {
											$Writer = $EpisodeWriterTemp;
											$Artist = $EpisodeArtistTemp;
											$Colorist = $EpisodeColoristTemp;
											$Letterist = $EpisodeLettererTemp;
										}
										$ArchiveDropDown .= 'selected'; 
									} 
									$ArchiveDropDown .= "><b>CHAPTER </b>".$ChapterCount." - ".$story_array[$k]->title."</option>";  
									if ($InEpisode == 1)
										$ChapterString .= "<div class='modheader'>Chapter ".$ChapterCount."</div>
															<div class='pagelinks'><a href='/".$this->SafeFolder."/inlinereader/page/".$story_array[$k]->position."/'>
															".$story_array[$k]->title."</a></div><div class='smspacer'></div>";
						

									$Inchapter = 1;
									$ChapterCount++;
							} else {
			 					if ($Inchapter == 1) {
									$ArchiveDropDown .= "<option style='background-color:#fce4aa;' value='/".$this->SafeFolder."/inlinereader/page/".$story_array[$k]->position."/'";
									if ($story_array[$k]->id==$PageID) {
										$FoundPage = 1;
										$ArchiveDropDown .= 'selected'; 
									} 
									$ArchiveDropDown .= ">&nbsp;&nbsp;&nbsp;Page ".$ChapterPageCount." - ".$story_array[$k]->title."</option>";
									$ChapterPageCount++;
								} else {
									$ArchiveDropDown .= "<option style='background-color:#fce4aa;' value='/".$this->SafeFolder."/inlinereader/page/".$story_array[$k]->position."/'";
									if ($story_array[$k]->id==$PageID) {
										$FoundPage = 1;
										$ArchiveDropDown .= 'selected'; 
									} 
									$ArchiveDropDown .= ">-> ".$story_array[$k]->title."</option>";
								}
			
							}
						}
				} // end for

				$ArchiveDropDown .='</select>';
				$boxString .= $ArchiveDropDown.'</select><input type="hidden" name="url" value="index.php?id=" /> </form>';

		}
		
		public function getPagePeels() {
						$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
						
						$query = "select Image from comic_pages where PageType='pencils' and ComicID = '".$this->ProjectID."' and ParentPage='".$this->PageID."'";
						$PeelOne = $db->queryUniqueValue($query);
						
						$query = "select Image from comic_pages where PageType='inks' and ComicID = '".$this->ProjectID."' and ParentPage='".$this->PageID."'";
						$PeelTwo = $db->queryUniqueValue($query);
						
						$query = "select Image from comic_pages where PageType='colors' and ComicID = '".$this->ProjectID."' and ParentPage='".$this->PageID."'";
						$PeelThree = $db->queryUniqueValue($query);
						
						$query = "select Image from comic_pages where PageType='script' and ComicID = '".$this->ProjectID."' and ParentPage='".$this->PageID."'";
						$PeelFour = $db->queryUniqueValue($query);
						
						if ($PeelFour != '') {
							$ScriptFileName = explode('.',$PeelFour);
							$ScriptPDF = $ScriptFileName[0].'.pdf';
							$ScriptHTML = $ScriptFileName[0].'.html';
						}
						
						$this->PagePeels = array(
												'pencils'=>$PeelOne,
												'inks'=>$PeelTwo,
												'colors'=>$PeelThree,
												'script'=>$PeelFour, 
												'scriptfile'=>$ScriptFileName,
												'scriptpdf'=>$ScriptPDF,
												'scripthtml'=>$ScriptHTML
											);
						$db->close();
		}
		
		public function getPageHotspots () {
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
		
				$query = "select * from pf_hotspots where ComicID = '".$this->ProjectID."' and PageID='".$this->PageID."'";
						$db->query($query);
						unset($this->PageHotSpots);
						$this->PageHotSpots = array(array());
						
						while ($hotspot = $db->FetchNextObject()){
							$this->PageHotSpots[] = array (
														   'AsterickCoords'=>$hotspot->AsterickCoords,
														   'MapCoords'=>$hotspot->HotSpotCoords,
														   'Content'=>$hotspot->HTMLCode
															);
						}
				
				$db->close();		
				return $this->PageHotSopts();
						
		}
		
		public function getPageLikes() {
					$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
					$query = "SELECT count(*) as NumLikes, 
						 (SELECT count(*) from likes where (ContentID='".$this->ProjectID."' and ProjectID='".$this->ProjectID."' and ContentType='project_page' and UserID='".$_SESSION['userid']."')) as UserLiked
						 from likes 
						 where ContentID='".$this->PageID."' and ProjectID='".$this->ProjectID."' and ContentType='project_page'";
						$LikeArray = $db->queryUniqueObject($query);
						$this->PageLikes = array('Total'=>$LikeArray->NumLike, 'UserLiked'=>$LikeArray->UserLiked);
						$db->close();
						return $this->PageLikes;
						
		
		}
		public function get_settings() {

				return $this->SettingsArray;
		}
		
		public function get_project_info() {

				return $this->ProjectArray;
		}
		
		public function get_assistants() {
				return $this->AssistantArray;
		}
	
		public function get_title() {
					return $this->Title;
		}
		public function get_projectID() {
					return $this->ProjectID;
		}
		public function get_project_type() {
		
					return $this->ProjectArray['ProjectType'];
		}
		public function get_creator() {

					return $this->Title;
		}
		public function get_creator_info() {
					return $this->CreatorArray;
		}
		public function get_admin_info() {
					return $this->AdminArray;
		}
		
		public function get_writer() {
					return $this->Writer;
		}
		public function get_artist() {
					return $this->Artist;
		}
		public function get_colorist() {
					return $this->Colorist;
		}
		public function get_letterist() {
					return $this->Letterist;
		}
		public function get_synopsis() {
					return $this->Synopsis;
		}
		
		public function get_tags() {
					return $this->Tags;
		}
		public function get_genre() {
					return $this->Genre;
		}
		public function get_folder() {
					return $this->ComicFolder;
		}
		public function get_creatorID() {
					return $this->CreatorID;
		}
		public function get_default_reader() {
					return $this->DefaultReader;
		}
		public function get_copyright() {
					return $this->CopyRight;
		}
		
		public function getUpdateSchedule() {
					$UpdateScheduleArray = explode(',',$this->SettingsArray->UpdateSchedule);
					$ScheduleString == '';
					$StringSet = 0;
					if (in_array('mon',$this->SettingsArray)) {
						$ScheduleString .= 'Monday';
						$StringSet = 1;
					}
					
					if (in_array('tues',$this->SettingsArray)) {
						if ($StringSet == 1)
							$ScheduleString .= ', ';
						$ScheduleString .= 'Tuesday';
						$StringSet = 1;
					}
					
					if (in_array('wed',$this->SettingsArray)) {
						if ($StringSet == 1)
							$ScheduleString .= ', ';
						$ScheduleString .= 'Wednesday';
						$StringSet = 1;
					}
					
					if (in_array('thur',$this->SettingsArray)) {
						if ($StringSet == 1)
							$ScheduleString .= ', ';
						$ScheduleString .= 'Thursday';
						$StringSet = 1;
					}
					
					if (in_array('fri',$this->SettingsArray)) {
						if ($StringSet == 1)
							$ScheduleString .= ', ';
						$ScheduleString .= 'Friday';
						$StringSet = 1;
					}
					
					if (in_array('sat',$this->SettingsArray)) {
						if ($StringSet == 1)
							$ScheduleString .= ', ';
						$ScheduleString .= 'Saturday';
						$StringSet = 1;
					}
					
					if (in_array('sun',$this->SettingsArray)) {
						if ($StringSet == 1)
							$ScheduleString .= ', ';
						$ScheduleString .= 'Sunday';
					}
				
				return $ScheduleString;
		
		}


	}




?>