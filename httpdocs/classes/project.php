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
		
		
		function __construct($SafeFolder) {
			$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$QueryName = strtolower(str_replace(' ','_',$SafeFolder));
			$SafeFolder = str_replace(' ','_',$SafeFolder);
			$query = "SELECT p.*, u.username as AdminUser, u.email as AdminEmail, p.userid as AdminUserID , cr.realname as CreatorName, cr.Avatar as CreatorAvatar, cr.email as CreatorEmail
			          from projects as p
					  join users as u on u.encryptid=p.userid
					  join creators as cr on cr.ComicID=p.ProjectID
					  where (lower(p.SafeFolder)='".$QueryName."' or p.ProjectID='$SafeFolder')";
			$ProjectTableArray= $db->queryUniqueObject($query);
			//if ($_SESSION['username'] == 'matteblack')
				//print $query;
		//	echo 'QUERY = ' .  $query;
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
			$ComicDirArray = explode('/',$ProjectTableArray->HostedUrl);
			$ComicDir = $ComicDirArray[0];
			$this->ProjectArray = array (
									'ProjectID'=>$ProjectTableArray->ProjectID,
									'ProjectType'=>$ProjectTableArray->ProjectType,
									'SafeFolder'=> $this->SafeFolder,
									'ProjectDirectory'=> $ProjectTableArray->ProjectDirectory,
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
									'ComicDir'=> $ComicDir,
									'CreatorID'=> $ProjectTableArray->CreatorID,
									'AdminUserID'=> $ProjectTableArray->userid,
									'SafeFolder'=> $ProjectTableArray->SafeFolder,
									'DefaultReader'=>  $ProjectTableArray->ReaderType,
									'CopyRight'=>$ProjectTableArray->Copyright,
									'CharacterCount'=>$this->CharacterCount,
									'TodaysPage'=>$this->TodaysPage,
									'LatestPageThumb'=>$this->LatestPageThumb,
									'LatestPage'=>$this->LatestPage,
									'DownloadCount'=>$this->DownloadCount,
									'Thumb'=>$ProjectTableArray->thumb,
									'Rating'=>$ProjectTableArray->Rating,
									'MobileCount'=>$this->MobileCount
								);
		
			$this->AdminArray = array (
										'Name'=>$ProjectTableArray->AdminUser,
										'Email'=>$ProjectTableArray->AdminEmail,
										'UserID'=>$ProjectTableArray->AdminUserID
									);
		
			$this->CreatorArray = array (
											'Name'=>$ProjectTableArray->CreatorName,
											'Avatar'=>$ProjectTableArray->CreatorAvatar,
											'Email'=>$ProjectTableArray->CreatorEmail,
											'UserID'=>$ProjectTableArray->CreatorID
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
		 
		 public function getProjectRanking() {
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								$today = date("Ymd"); 
								$query = "SELECT r.*,p.hits as TotalHits, p.PagesUpdated as LastUpdated, p.cover, (select count(*) from favorites as f where f.ProjectID=p.ProjectID) as TotalVolts,
										  (SELECT distinct hits from analytics as a where a.ProjectID='".$this->ProjectID."' and a.date ='$today') as TodayHits,
										  (SELECT count(*) from comic_pages as cp where cp.ComicID='".$this->ProjectID."') as TotalPages,
										  (SELECT count(*) from pagecomments as pc where pc.comicid='".$this->ProjectID."') as TotalComments,
										  (SELECT count(*) from likes as l where l.ProjectID='".$this->ProjectID."') as TotalLikes
										  from rankings as r
										 join projects as p on (r.ComicID=p.ProjectID)
										 where r.ComicID='".$this->ProjectID."'";
										
								$this->RankArray = $db->queryUniqueObject($query);
								$db->close();
						
								return  $this->RankArray;
		}
		
		public function getReccomendations($Keywords, $Genres, $CreatorSays,$SafeFolder) { 
		
						//if ($_SESSION['username'] == 'matteblack') {
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								//$CreatorSays = 'ef575e881d8';
								$CreatorPicks = explode(',',$CreatorSays);
								$GenreArray = explode(',',$Genres);
								$TagArray = explode(',',$Keywords);
								$TotalGenres = sizeof($GenreArray);
								$TotalTags = sizeof($TagArray);
								$TotalPicks = sizeof($CreatorPicks);
								$CreatorSays = '';
								$SelectCount = 3;
								foreach ($CreatorPicks as $content) {
									if ($CreatorSays != '')
										$CreatorSays .= ',';
								
									$CreatorSays .= "'".$content."'";
							 
								}
								
								echo '<table>';
								if (($TotalPicks >0) && ($CreatorSays != "''") && ($CreatorSays != '')){
								 	$query .= "SELECT * from projects where ProjectID IN (".$CreatorSays.") limit $SelectCount";
									$db->query($query);
									while ($line = $db->fetchNextObject()) {
										$Ccount++;
									echo '<tr>';
									echo '<td align="right">';
										echo '<div class="sidebar_sub_nav">';
										echo '<a href="http://www.wevolt.com/'.$line->SafeFolder.'/">';
											echo $line->title;
										echo '</a>';
										echo '</div>';
									echo '</td>';
									echo '<td width="90" align="left">';
										echo '&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/'.$line->SafeFolder.'/"><img src="http://www.wevolt.com'.$line->thumb.'" border="0" width="30" height="30" tooltip="'.$line->synopsis.'" border="2" style="border:#000 solid 2px;"></a>';
									echo '</td>';
									echo '</tr>';
								}	
								
								}
								
								if (($CreatorSays != "''") && ($CreatorSays != ''))
									$SelectCount = $SelectCount - $TotalPicks;
								
								if ($SelectCount > 0) {
									$SELECT .= "SELECT *,
									(select count(*)  from pagecomments as pc where pc.comicid = p.ProjectID) as TotalComments,
									(select count(*) from comic_pages as cp where cp.comicid = p.ProjectID) as TotalPages,
									(select TO_DAYS(p.PagesUpdated) from projects as p2 where p2.ProjectID = p.ProjectID) as LastUpdate
									 from projects as p";	  
							
									$where = " where (";
									
									$Gcount=0;
									foreach ($GenreArray as $genre) {	
										if (trim($genre) != '') {	
												if ($Gcount == 0)
													$where .= '((';		
											if ($Gcount != 0) 	
											$where .= " or ";			
											$where .="p.genre LIKE '%".trim($genre)."%'";
											$Gcount++;
											
}
											
										}
							
									$KCount=0;
									
									foreach ($TagArray as $keyword) {
											
										if (((trim($keyword) != '') && (trim($keyword) != ' ')) && ($KCount <5)) {
											if (($Gcount == 0) && ($KCount == 0))
													$where .= '((';	
											else if (($Gcount>0) && ($KCount == 0))
												$where .= ' or ';	
											
											if ($KCount != 0)
												$where .=" or ";								
											$where .=" p.tags LIKE '%".trim(mysql_real_escape_string($keyword))."%'";
											//if (($KCount <= $TotalTags) && ($KCount != 0) &&($TagArray[$KCount+1] != ''))
												//$where .=" or ";
											$KCount++;
										}
									}
									if (($KCount >0) || ($Gcount > 0))
										$where .= ')  and ';
									$where .= "(p.Ranking<40 and p.Ranking>2)";
										if (($KCount >0) || ($Gcount > 0))
										$where .=")";
									$where .= " and p.installed = 1 and p.Published=1 and p.Hosted=1 and p.ShowRanking=1)"; 
									
									$where .= " and p.SafeFolder != '$SafeFolder'";  
	
									$ORDERBY .= " ORDER BY ((((((LastUpdate)*TotalPages/(p.Ranking))*(LastUpdate+(TotalComments*2)))))+(TotalPages))*LastUpdate DESC limit $SelectCount";
									
									$query = $SELECT .  $where . $ORDERBY; 
									$db->query($query);
									
									//print $query;
									
									while ($line = $db->fetchNextObject()) {
										echo '<tr>';
										echo '<td align="right">';
											echo '<div class="sidebar_sub_nav">';
											echo '<a href="http://www.wevolt.com/'.$line->SafeFolder.'/">';
												echo $line->title;
											echo '</a>';
											echo '</div>';
										echo '</td>';
										echo '<td width="90" align="left">';
											echo '&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/'.$line->SafeFolder.'/"><img src="http://www.wevolt.com'.$line->thumb.'" border="0" width="30" height="30" tooltip="'.$line->synopsis.'" border="2" style="border:#000 solid 2px;"></a>';
										echo '</td>';
										echo '</tr>';
									}
								}
								echo '</table>';
								$db->close();
						//}

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
		
		
		
		
		
		public function get_settings() {

				return $this->SettingsArray;
		}
		public function getSafeFolder() {

				return $this->SafeFolder;
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
		
		public function getReaderArray() {
				return $this->readerarray;
		
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
