<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class content extends project{
		var $Section;
		var $Col2Width;
		var $Col1Width;
		var $ContentTemplate;
		var $CustomSectionContent;
		var $SectionArray;
		
		function __construct($ContentUrl, $ProjectID) {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			if ($ContentUrl == '') 
				$query = "select * from content_section where ProjectID='$ProjectID' and TemplateSection='home'"; 
			 else 
				$query = "select * from content_section where ProjectID='$ProjectID' and LOWER(Title)='$ContentUrl'";

			$Array = $db->queryUniqueObject($query);
			$this->Section = ucfirst($Array->TemplateSection);
			if ($this->Section == 'Reader')
				$this->Section = 'Pages';
			
			$this->Col1Width = $Array->Variable1;
			$this->Col2Width = $Array->Variable2;
			$this->Col3Width = $Array->Variable3;
			$this->ContentTemplate = $Array->Template;
			
			if (($Array->IsCustom == 1) || ($Array->Template == 'custom'))
				$this->CustomSection = 1;
			else
				$this->CustomSection = 0;
			
			$this->CustomSectionContent = $Array->HTMLCode;
				
			$this->SectionArray = array (
									'Section'=>$this->Section,
									'Template'=>$this->ContentTemplate,
									'CustomSection'=> $this->CustomSection,
									'CustomContent'=> stripslashes($this->CustomSectionContent),
									'Variable1'=> $Array->Variable1,		
									'Variable2'=> $Array->Variable2							
								);
			unset($Array);
			$db->close();
							
		 }
		 
		 public function setCurrentPosition($PagePosition) {
			$this->PagePosition = $PagePosition;
		}
		public function setPageID($PageID) {
			$this->PageID = $PageID;
		}
		public function getPages() { 
				$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
				
				$this->TotalReaderPages = 0;
				$CurrentDate = date('Y-m-d 00:00:00');
				$query = "select * from comic_pages where ComicID = '".$this->ProjectID."' and PageType='pages' and PublishDate<='$CurrentDate' order by Position";
				$db->query($query);
				$this->TotalReaderPages = $db->numRows();
				if ($this->PagePosition == '')	
					$this->PagePosition = $this->TotalReaderPages;
					
				while ($setting = $db->fetchNextObject()) { 
						$this->LatestPageCount++;
						$this->readerarray[]->image = $setting->Image;
						$this->readerarray[]->id = $setting->EncryptPageID;
						$this->readerarray[]->comment = $setting->Comment; 
						$this->readerarray[]->imgheight =$setting->ImageDimensions;
						$this->readerarray[]->title = $setting->Title;
						$this->readerarray[]->active = 1;
						$this->readerarray[]->datelive = $setting->Datelive;
						$this->readerarray[]->thumbsm = $setting->ThumbSm;
						$this->readerarray[]->thumbmd = $setting->ThumbMd;
						$this->readerarray[]->ThumbLg = $setting->ThumbLg;
						$this->readerarray[]->chapter = $setting->Chapter;
						$this->readerarray[]->episode =  $setting->Episode;
						$this->readerarray[]->EpisodeDesc =  $setting->EpisodeDesc;
						$this->readerarray[]->EpisodeWriter =  $setting->EpisodeWriter;
						$this->readerarray[]->EpisodeArtist =  $setting->EpisodeArtist;
						$this->readerarray[]->EpisodeColorist =  $setting->EpisodeColorist;
						$this->readerarray[]->EpisodeLetterer =  $setting->EpisodeLetterer;
						$this->readerarray[]->filename = $setting->Filename;
						$this->readerarray[]->position = $setting->Position;
						$this->readerarray[]->FileType = $setting->FileType;
						$this->readerarray[]->MediaFile = $setting->Filename;
						
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
				
				$this->PageID = 			$this->readerarray[$this->CurrentIndex]->id;
				$this->AuthorComment = 		$this->readerarray[$this->CurrentIndex]->Comment;
				$this->EpisodeDesc = 		$this->readerarray[$this->CurrentIndex]->EpisodeDesc;
				$this->EpisodeWriter = 		$this->readerarray[$this->CurrentIndex]->EpisodeWriter;
				$this->EpisodeArtist = 		$this->readerarray[$this->CurrentIndex]->EpisodeArtist;
				$this->EpisodeColorist = 	$this->readerarray[$this->CurrentIndex]->EpisodeColorist;
				$this->EpisodeLetterer = 	$this->readerarray[$this->CurrentIndex]->EpisodeLetterer;
				$this->Image = 				$this->readerarray[$this->CurrentIndex]->image;
				$this->Title = 				$this->readerarray[$this->CurrentIndex]->title;
				$this->FileType = 			$this->readerarray[$this->CurrentIndex]->FileType;
				$this->MediaFile = 			$this->readerarray[$this->CurrentIndex]->filename;
				$this->ImageHeight = 		$this->readerarray[$this->CurrentIndex]->imgheight;	

				if ($this->CurrentIndex != ($this->TotalReaderPages-1)) {
				  	  $this->NextPage = 	$this->readerarray[$this->CurrentIndex+1]->position;
					  $this->NextPageImage = $this->readerarray[$this->CurrentIndex+1]->image;
				 } else {
				  		$this->NextPage = 	$PagePosition;
						$this->NextPageImage = $this->readerarray[$this->CurrentIndex]->image;
				 }
							
				 if ($this->CurrentIndex > 0) {
				     $this->PrevPage = $this->readerarray[$this->CurrentIndex-1]->position;
					 $this->PrevPageImage = $this->readerarray[$this->CurrentIndex-1]->image;
				  } else { 
					$this->PrevPage = $this->PagePosition;
				  }		
						
		}
		
		public function buildArchivesDropdown() {
						$boxString = '<form id="jumpbox" action="#" method="get">ARCHIVES<br/>';
						$ArchiveDropDown ='<select id="dropdown" style="width:100%;" name="url" onchange="window.location = this.options[this.selectedIndex].value;"> ';
						$TotalPages = 0;

						for ($k=0; $k< $this->TotalReaderPages; $k++){
							if ($this->readerarray[$k]->episode == 1) {
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
								$ArchiveDropDown .= "page/".$this->readerarray[$k]->position."/'";
								if ($this->readerarray[$k]->id==$this->PageID) {
					    				$FoundPage = 1;
										$ArchiveDropDown.= 'selected'; 
								} 
				
								$ArchiveDropDown .="><b>EPISODE </b>".$EpisodeCount." - ".$this->readerarray[$k]->title."</option>";
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
								$episodeString .= "page/".$this->readerarray[$k]->position."/'";
								$episodeString .= "><img src='/".$this->readerarray[$k]->ThumbLg."' border='2' style='border-color:#000000'></a></td><td valign='top' style='padding-left:5px; padding-right:5px;' class='contentbox' id='episodetd_".$EpisodeCount."'><font color='#".$ContentBoxTextColor."'>EPISODE ".$EpisodeCount."</font></div><div class='pagelinks'><div class='episodetitle'><a href='/".$SafeFolder."/inlinereader/page/".$this->readerarray[$k]->position."/'>".$this->readerarray[$k]->title."</a></div></div><div class='spacer'></div><font color='#".$ContentBoxTextColor."' style='font-size:".$ContentBoxFontSize."px;'>".$this->readerarray[$k]->EpisodeDesc."<div class='spacer'></div>";
								
								if ($this->readerarray[$k]->EpisodeWriter != '') {
										$episodeString .= "Script: ".$this->readerarray[$k]->EpisodeWriter."<br/>";
										$EpisodeWriterTemp = $this->readerarray[$k]->EpisodeWriter;
								}
								if ($this->readerarray[$k]->EpisodeArtist != ''){
									$episodeString .= "Art: ".$this->readerarray[$k]->EpisodeArtist."<br/>";
									$EpisodeArtistTemp = $this->readerarray[$k]->EpisodeArtist;
								}
								if ($this->readerarray[$k]->EpisodeColorist != ''){
									$episodeString .= "Colors: ".$this->readerarray[$k]->EpisodeColorist."<br/>";
									$EpisodeColoristTemp = $this->readerarray[$k]->EpisodeColorist;
								}
								if ($this->readerarray[$k]->EpisodeLetterer != ''){
									$episodeString .= "Lettering: ".$this->readerarray[$k]->EpisodeLetterer."<br/>";
									$EpisodeLettererTemp = $this->readerarray[$k]->EpisodeLetterer;
								}
								$episodeString .= "</font></td></tr></table></div>";
							    $ChapterCount = 1;
					  			$ChapterPageCount = 1;
							}
							if ($this->readerarray[$k]->episode != 1) {
								if ($this->readerarray[$k]->chapter == 1) {
									if ($Inchapter == 1) 
			  	 						$ChapterPageCount = 1;
									$ArchiveDropDown .= "<option style='background-color:#fce4aa;' value='/".$this->SafeFolder."/inlinereader/page/".$this->readerarray[$k]->position."/'";
									if ($this->readerarray[$k]->id==$PageID) {
										$FoundPage = 1;
										if ($InEpisode == 1) {
											$Writer = $EpisodeWriterTemp;
											$Artist = $EpisodeArtistTemp;
											$Colorist = $EpisodeColoristTemp;
											$Letterist = $EpisodeLettererTemp;
										}
										$ArchiveDropDown .= 'selected'; 
									} 
									$ArchiveDropDown .= "><b>CHAPTER </b>".$ChapterCount." - ".$this->readerarray[$k]->title."</option>";  
									if ($InEpisode == 1)
										$ChapterString .= "<div class='modheader'>Chapter ".$ChapterCount."</div>
															<div class='pagelinks'><a href='/".$this->SafeFolder."/inlinereader/page/".$this->readerarray[$k]->position."/'>
															".$this->readerarray[$k]->title."</a></div><div class='smspacer'></div>";
						

									$Inchapter = 1;
									$ChapterCount++;
							} else {
			 					if ($Inchapter == 1) {
									$ArchiveDropDown .= "<option style='background-color:#fce4aa;' value='/".$this->SafeFolder."/inlinereader/page/".$this->readerarray[$k]->position."/'";
									if ($this->readerarray[$k]->id==$PageID) {
										$FoundPage = 1;
										$ArchiveDropDown .= 'selected'; 
									} 
									$ArchiveDropDown .= ">&nbsp;&nbsp;&nbsp;Page ".$ChapterPageCount." - ".$this->readerarray[$k]->title."</option>";
									$ChapterPageCount++;
								} else {
									$ArchiveDropDown .= "<option style='background-color:#fce4aa;' value='/".$this->SafeFolder."/inlinereader/page/".$this->readerarray[$k]->position."/'";
									if ($this->readerarray[$k]->id==$PageID) {
										$FoundPage = 1;
										$ArchiveDropDown .= 'selected'; 
									} 
									$ArchiveDropDown .= ">-> ".$this->readerarray[$k]->title."</option>";
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
		 
		public function get_content_info() {

				return $this->SectionArray;
		}
		
		public function get_custom_content() {

				return $this->SectionArray['CustomContent'];
		}
		public function iscustom_section() {

				return $this->SectionArray['CustomSection'];
		}
		public function get_section() {

				return $this->SectionArray['Section'];
		}
		public function get_content_template() {

				return $this->SectionArray['Template'];
		}
		
		


	}




?>