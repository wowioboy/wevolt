<? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 
	class cms {	

			var $AdminUser;
			var $OwnerID;
			var $AdminEmail;
			var $AdminUserID;
			var $ProjectInfoArray;
			var $ProjectType; 
			var $ProjectID;
			var $SafeFolder;
			var $ExternalUrl;
		
			function __construct($Project='') {
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								$this->AdminArray = array (
										'Name'=>$_SESSION['username'],
										'Email'=>$_SESSION['email'],
										'UserID'=>$_SESSION['userid']
									);
								$this->AdminUser = $_SESSION['username'];
								$this->AdminEmail = $_SESSION['email'];
								$this->AdminUserID = $_SESSION['userid'];
								
								if ($Project != '') {														
									$query = "SELECT c.*, cs.*, cr.*, th.ProjectTheme
													FROM projects as c 
													JOIN comic_settings as cs on c.ProjectID=cs.ComicID 
													JOIN creators as cr on c.ProjectID=cr.ComicID
													JOIN Applications as a on c.AppInstallation=a.ID
												    left join pf_themes as th on th.ID=cs.CurrentTheme
													left JOIN project_skins as ts on ts.SkinCode=cs.Skin  
													WHERE c.SafeFolder='$Project'";

									$this->ProjectInfoArray = $db->queryUniqueObject($query);
								
									if ($this->ProjectInfoArray->ProjectID == '') {
											$query = "SELECT c.*, cs.*, cr.*, th.ProjectTheme
													FROM projects as c 
													JOIN comic_settings as cs on c.ProjectID=cs.ComicID 
													JOIN creators as cr on c.ProjectID=cr.ComicID
													JOIN Applications as a on c.AppInstallation=a.ID 
													left join pf_themes as th on th.ID=cs.CurrentTheme
													left JOIN project_skins as ts on ts.SkinCode=cs.Skin 
													WHERE c.ProjectID='$Project'";
											$this->ProjectInfoArray = $db->queryUniqueObject($query);
									
									}
									
									$this->ProjectID = $this->ProjectInfoArray->ProjectID;
									
									$this->ProjectType = $this->ProjectInfoArray->ProjectType;
									$this->SafeFolder = $this->ProjectInfoArray->SafeFolder;
									$this->OwnerID = $this->ProjectInfoArray->userid;
									$this->IsProjectTheme = $this->ProjectInfoArray->ProjectTheme;
									$_SESSION['basefolder'] = $this->ProjectInfoArray->ProjectDirectory;
									$_SESSION['sessionproject'] = $this->ProjectInfoArray->ProjectID;
									$_SESSION['projectfolder'] = $this->ProjectInfoArray->HostedUrl;
									$_SESSION['projecttype'] =$this->ProjectType;
									$_SESSION['safefolder'] = $this->SafeFolder;
									$_SESSION['isprojecttheme'] = $this->ProjectInfoArray->ProjectTheme;
									$_SESSION['projectcover'] = 'http://www.wevolt.com'.$this->ProjectInfoArray->cover;	
									$_SESSION['projectthumb'] = 'http://www.wevolt.com'.$this->ProjectInfoArray->thumb;	
									if ($this->ProjectInfoArray->Hosted == 1)
										$this->ExternalUrl .= '/';
											
									if ($_SESSION['email'] == $this->ProjectInfoArray->Email)
										$_SESSION['comicassist'] =$this->ProjectInfoArray->ProjectID;
								}
									$db->close();
						}
						
						public function getProjectRanking() {
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								$today = date("Ymd"); 
								$query = "SELECT r.*,p.hits as TotalHits, p.cover, (select count(*) from favorites as f where f.ProjectID=p.ProjectID) as TotalVolts,
										  (SELECT hits from analytics as a where a.ProjectID='".$this->ProjectID."' and a.date ='$today') as TodayHits,
										  (SELECT count(*) from comic_pages as cp where cp.ComicID='".$this->ProjectID."') as TotalPages,
										  (SELECT count(*) from pagecomments as pc where pc.comicid='".$this->ProjectID."') as TotalComments,
										  (SELECT count(*) from likes as l where l.ProjectID='".$this->ProjectID."') as TotalLikes
										  from rankings as r
										 join projects as p on (r.ComicID=p.ProjectID)
										 where r.ComicID='".$this->ProjectID."'";
										
								$this->RankArray = $db->queryUniqueObject($query);
								$db->close();
							//if ($_SESSION['username'] == 'matteblack')
								//print $query;
								return  $this->RankArray;
						
						}
						public function getCreatorProjects() {
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								$CreatorComics = array ();
								$query = "select ProjectID, title, ProjectType from projects where ((userid='".$this->AdminUserID."' or CreatorID='".$this->AdminUserID."') and ( ProjectType='comic' or ProjectType='writing' or ProjectType='blog' or ProjectType='portfolio')) ";
								
								$db->query($query);
								$numComics = $db->numRows();
 								while ($setting = $db->fetchNextObject()) { 
									$CreatorComics[] = $setting->ProjectID;
								}
								$db->close();
								return $CreatorComics;
						}
						
						public function getAssistantProjects() {
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								$AssistantComics = array ();
								$query = "select ComicID from comic_settings where Assistant1='".$this->AdminEmail."' or '".$this->AdminEmail."' or '".$this->AdminEmail."'";
								$db->query($query);
								//print $query;
								$numassistantComics = $db->numRows();
								while ($setting = $db->fetchNextObject()) { 
										$AssistantComics[] = $setting->ComicID;
								}
								$db->close();
								return $AssistantComics;
						}
						
						public function  getLatestComment($ThumbSize='75') {
							
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								 $BlogComment = 0;
								$query = "select c.*,u.username,u.avatar, cp.ThumbMd, cp.SeriesNum, cp.EpisodeNum, cp.EpPosition, cp.title
								          from pagecomments as c
										  join users as u on c.userid=u.encryptid
										  join comic_pages as cp on c.pageid=cp.EncryptPageID
										  where c.comicid='".$this->ProjectID."'
										  order by c.creationdate desc";
								$LastComment = $db->queryUniqueObject($query);
								if ($LastComment->pageid == '') {
										$query = "select c.*,u.username,u.avatar
								          from blogcomments as c
										  join users as u on c.UserID=u.encryptid
										   join pfw_blog_posts as cp on c.PostID=cp.EncryptID
										  where c.ComicID='".$this->ProjectID."'
										  order by c.creationdate desc";
										  $BlogComment = 1;
								$LastComment = $db->queryUniqueObject($query);
								}
								
								if ($LastComment->creationdate == '') {
									echo 'No Recent Comments';	
									
								} else {
									
								echo '<table cellspacing="5"><tr>';
								echo '<td valign="top" align="center">';
								echo $LastComment->username;
								echo '<br/><img src="'.$LastComment->avatar.'" border="1" width="'.$ThumbSize.'">';
								echo '</td>';
								echo '<td valign="top">';
								echo '<em>'.$LastComment->commentdate.'</em>';
								echo '<div class="mdspacer"></div>';
								echo $LastComment->comment;
								echo '<td>';
								echo '</tr>';
								echo '</table>';

								}
							
								$db->close();
						}
						
						public function getCmsProjectInfo() {
					
								return $this->ProjectInfoArray;
						}
						
						public function getAdminInfo() {
						
								return $this->AdminArray;
														
						}
						
						public function strictify ( $string ) {
      							 $fixed = htmlspecialchars( $string, ENT_QUOTES );
      							 $trans_array = array();
       							for ($i=127; $i<255; $i++) {
          							 $trans_array[chr($i)] = "&#" . $i . ";";
      							 }
      							 $really_fixed = strtr($fixed, $trans_array);
      							 return $really_fixed;
						}
						
						public function drawCreatorProjectsList() {
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 								$query = "select * from projects 
										  where installed = 1 and Hosted=1 and (CreatorID ='".$this->AdminUserID."' or userid='".$this->AdminUserID."') and ProjectType !='forum' 
										  ORDER BY title ASC";
							  	$string = "<table cellspacing=\"10\"><tr>";
    						    $db->query($query);
							//	print $query;
								$counter = 0;
								$TotalComics = $db->numRows();
							//	print 'Total projects = ' . $TotalComics;
   							  	while ($line = $db->fetchNextObject()) {  
									$UpdateDay = substr($line->PagesUpdated, 5, 2); 
									$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
									$UpdateYear = substr($line->PagesUpdated, 0, 4);
									$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
									$SafeFolder = $line->SafeFolder; 
									$ComicDir = $line->HostedUrl; 
									$string .= '<td valign="top"><table width="216" border="0" cellpadding="0" cellspacing="0"><tr>
										<td id="grey_cmsBox_TL"></td>
										<td id="grey_cmsBox_T"></td>
										<td id="grey_cmsBox_TR"></td></tr>
										<tr><td class="grey_cmsBox_L" background="http://www.wevolt.com/images/cms/grey_cms_box_L.png" width="8"></td>
										<td class="grey_cmsboxcontent" valign="top" width="200" align="left">';
									
									$string .= '<div><b>'.stripslashes($line->title).'</b></div>';
									
									$string .='<div style="border-bottom:dotted 1px #bababa;"></div>';
									
									$string .='<table cellspacing="4"><tr><td>';
									$string .='<a href="/cms/edit/'.$SafeFolder.'/"><img src="'.$line->thumb.'" border="2" alt="LINK" style="border-color:#000000;" width="100" height="100" vspace="2" hspace="3"></a><br/>';
 									$string .= "PROJECT TYPE:<br/>".$line->ProjectType;
									$string .='</td><td valign="top">';
									$string .="<div class='updated'>last updated: <br /><b>".$Updated."</b></div>";
									$string .='<div>';
									$string .='<a href="/cms/edit/'.$SafeFolder.'/"><img src="http://www.wevolt.com/images/cms/cms_edit_icon.png" border="0" vspace="5" tooltip="EDIT this project" tooltip_position="right"></a><br/>';
									$string .='<img src="http://www.wevolt.com/images/cms/analytics_btn.png" onclick="window.location=\'/cms/edit/'.$line->SafeFolder.'/?tab=analytics\';" class="navbuttons" vspace="5" tooltip="VIEW analytics" tooltip_position="right"><br/>';
									
									if ($line->userid == $this->AdminUserID) {
										$AdminRights = true;
										$string .='<img src="http://www.wevolt.com/images/cms/cms_delete_btn.png" tooltip="DELETE this project" tooltip_position="right" onclick="delete_project(\''.$line->ProjectID.'\');" class="navbuttons" vspace="5"><br/>';
									}
									$string .="</div>"; 
									$string .='</td></tr></table>';
									
									$string .= '</td><td class="grey_cmsBox_R" background="http://www.wevolt.com/images/cms/grey_cms_box_R.png" width="8"></td>

												</tr><tr><td id="grey_cmsBox_BL"></td><td id="grey_cmsBox_B"></td>
												<td id="grey_cmsBox_BR"></td>
												</tr></table></td>';
												
			 						$counter++;
 									if ($counter == 3){
 										$string .= "</tr><tr>";
 										$counter = 0;
 									}

    							}
								
								while (($counter < 3) && ($counter != 0)) {
									$string .= "<td></td>";
									$counter++;
									
								}
								$string .= "</tr><table>";
								
								//print 'string = ' . $string;
									
								$db->close();
								if ($AdminRights) {
									$string .= "<form method='post' action='/cms/admin/?t=projects' name='deleteform' id='deleteform'>";
									$string .= "<input type='hidden' name='txtComic' id='txtComic'>";
									$string .= "<input type='hidden' name='deleteconfirm' id='deleteconfirm' value='0'>";
									$string .= "</form>";
								}
								return $string;
						}
						
					
						public function drawAssistantProjectsList() {
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
									$query = "SELECT cs.ComicID, c.* from comic_settings as cs 
		  								  join projects as c on cs.ComicID=c.ProjectID
		  								  where (cs.Assistant1='".$this->AdminEmail."' or cs.Assistant2='".$this->AdminEmail."' or cs.Assistant3='".$this->AdminEmail."') 
										  and (c.ProjectType !='forum' and c.ProjectType != 'blog') 
										  order by c.ProjectType";
							  	$string = "<table cellspacing=\"10\"><tr>";
    						    $db->query($query);
							//	print $query;
								$TotalComics = $db->numRows();
							//	print 'Total projects = ' . $TotalComics;
   							  	while ($line = $db->fetchNextObject()) {  
									$UpdateDay = substr($line->PagesUpdated, 5, 2); 
									$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
									$UpdateYear = substr($line->PagesUpdated, 0, 4);
									$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
									$SafeFolder = $line->SafeFolder; 
									$ComicDir = $line->HostedUrl; 
									$string .= '<td valign="top"><table width="216" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="grey_cmsBox_TL"></td>
										<td id="grey_cmsBox_T"></td>
										<td id="grey_cmsBox_TR"></td></tr>
										<tr><td class="grey_cmsBox_L" background="http://www.wevolt.com/images/cms/grey_cms_box_L.png" width="8"></td>
										<td class="grey_cmsboxcontent" valign="top" width="200" align="left">';
									
									$string .= '<div>'.stripslashes($line->title).'</div>';
									
									$string .='<div style="border-bottom:dotted 1px #bababa;"></div>';
									
									$string .='<table cellspacing="4"><tr><td>';
									$string .='<a href="/cms/edit/'.$SafeFolder.'/"><img src="'.$line->thumb.'" border="2" alt="LINK" style="border-color:#000000;" width="100" height="100" vspace="2" hspace="3"></a><br/>';
 									$string .= "PROJECT TYPE:<br/>".$line->ProjectType;
									$string .='</td><td valign="top">';
									$string .="<div class='updated'>last updated: <br /><b>".$Updated."</b></div>";
									$string .='<div>';
									$string .='<a href="/cms/edit/'.$SafeFolder.'/"><img src="http://www.wevolt.com/images/cms/cms_edit_icon.png" border="0" vspace="5" tooltip="EDIT this project" tooltip_position="right"></a><br/>';
									$string .='<img src="http://www.wevolt.com/images/cms/analytics_btn.png" onclick="window.location=\'/cms/edit/'.$line->SafeFolder.'/?tab=analytics\';" class="navbuttons" vspace="5" tooltip="VIEW analytics" tooltip_position="right"><br/>';
									
									
									$string .="</div>"; 
									$string .='</td></tr></table>';
									
									$string .= '</td><td class="grey_cmsBox_R" background="http://www.wevolt.com/images/cms/grey_cms_box_R.png" width="8"></td>

												</tr><tr><td id="grey_cmsBox_BL"></td><td id="grey_cmsBox_B"></td>
												<td id="grey_cmsBox_BR"></td>
												</tr></tbody></table></td>';
												
			 						$counter++;
 									if ($counter == 3){
 										$string .= "</tr><tr>";
 										$counter = 0;
 									}

    							}
								
								while (($counter < 3) && ($counter != 0)) {
									$string .= "<td></td>";
									$counter++;
									
								}
								$string .= "</tr><table>";
								
								//print 'string = ' . $string;
									
								$db->close();
								return $string;
						}
						
						public function getInstalledSections() {
								$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
								$AssistantComics = array ();
								$query = "SELECT TemplateSection from content_section where ProjectID='".$this->ProjectID."'";
								$InstalledSections = array();
								$db->query($query);
								
   							  	while ($line = $db->fetchNextObject()) {  
										$InstalledSections[] =  $line->TemplateSection;
    							}
							
								$db->close();
								return $InstalledSections;
						}
						
						

	}

?>