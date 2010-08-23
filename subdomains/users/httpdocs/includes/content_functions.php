<? 
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
	 include_once(INCLUDES.'/db.class.php');
function insertUpdate($ActionSection, $ActionType, $ActionID, $UpdateType, $UserID,$Link,$ContentID='',$ContentTitle='') {
		 $DB=new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
	 
			$NOW = date('Y-m-d h:i:s');
			$UDate = date('Y-m-d');
			$query = "INSERT into updates (ActionSection, ActionType, ActionID, UpdateType, UserID, Link,content_id,live_date,content_title) values ('$ActionSection', '$ActionType', '$ActionID', '$UpdateType', '$UserID','$Link','$ContentID','$LiveDate','".mysql_real_escape_string($ContentTitle)."')";
			$DB->execute($query);
			$Output = $query;
			$DB->close();
return $Output;


}

function InsertProjectContent($Action, $ProjectID, $ContentID, $ContentType, $UserID, $Tags='') {
 		 $DB=new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

	if ($ProjectID == '') {
		$query = "SELECT * from users where encryptid='$UserID'";
	$UserArray = $DB->queryUniqueObject($query);
	$ContentThumb = $UserArray->avatar;

	$UpdateType = 'user';
						
	} else {
	
		$query = "SELECT * from projects where ProjectID='$ProjectID'";
	$ProjectArray = $DB->queryUniqueObject($query);
	$HostedUrl = $ProjectArray->HostedUrl;
	$SafeFolder = $ProjectArray->SafeFolder;
	$ContentThumb = $ProjectArray->Thumb;
	$ProjectDirectory = $ProjectArray->ProjectDirectory;

		$UpdateType = 'project';
	}
		
		if (($Action == 'add')||($Action == 'new')||($Action == 'replied')) {
			
			if (($ContentType == 'pages') || ($ContentType == 'pencils')|| ($ContentType == 'inks')|| ($ContentType == 'letters')|| ($ContentType == 'colors')|| ($ContentType == 'script')|| ($ContentType == 'extras')){
					$query = "SELECT * from comic_pages where EncryptPageID='$ContentID' and ComicID='$ProjectID'";
					$ContentArray = $DB->queryUniqueObject($query);
					//print $query.'<br/>';
					$ContentTitle =  mysql_real_escape_string($ContentArray->Title);
					$ContentThumb = $ContentArray->ThumbMd;
					$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$_SESSION['userid']."', '$ContentTitle', '$ContentType', '$ContentID','$ContentThumb')";
					$DB->execute($query);
					//print $query.'<br/>';
					insertUpdate('page', 'posted', $ContentID, 'project', $UserID,'http://'.$_SERVER['SERVER_NAME'].'/'.$SafeFolder.'/reader/page/'.$ContentArray->Position.'/',$ProjectID,$ContentArray->Title);
			} else if (($ContentType == 'image gallery') || ($ContentType == 'video gallery') || ($ContentType == 'media gallery')|| ($ContentType == 'music gallery')|| ($ContentType == 'sound gallery')){
					$query = "SELECT * from pf_galleries where EncryptID='$ContentID' and ProjectID='$ProjectID'";
					$ContentArray = $DB->queryUniqueObject($query);
				//	print $query.'<br/>';
					$ContentTitle =  mysql_real_escape_string($ContentArray->Title);
				    $query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$_SESSION['userid']."', '$ContentTitle', '$ContentType', '$ContentID','$ContentThumb')";
					$DB->execute($query);
				//	print $query.'<br/>';
					insertUpdate($ContentType, 'created', $ContentID, 'project', $UserID,'http://'.$_SERVER['SERVER_NAME'].'/'.$SafeFolder.'/gallery/?gid='.$ContentID,$ProjectID,$ContentArray->Title);
			} else if ($ContentType == 'gallery content'){
					$query = "SELECT * from pf_gallery_content where EncryptID='$ContentID' and ProjectID='$ProjectID'";
					$ContentArray = $DB->queryUniqueObject($query);
				//	print $query.'<br/>';
					$ContentTitle =  mysql_real_escape_string($ContentArray->Title);
				    $query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$_SESSION['userid']."', '$ContentTitle', '$ContentType', '$ContentID','$ContentThumb')";
					$DB->execute($query);
				//	print $query.'<br/>';
					insertUpdate($ContentType, 'added', $ContentID, 'project', $UserID,'http://'.$_SERVER['SERVER_NAME'].'/'.$SafeFolder.'/gallery/?item='.$ContentID.'&gid='.$ContentArray->GalleryID,$ProjectID,$ContentArray->Title);
			} else if ($ContentType == 'characters') {
					$query = "SELECT * from characters where EncryptID='$ContentID' and (ComicID='$ProjectID' or ProjectID = '$ProjectID')";
					$ContentArray = $DB->queryUniqueObject($query);
					$ContentTitle =  mysql_real_escape_string($ContentArray->Name);
					$ContentThumb =  $ProjectDirectory.'/'.$HostedUrl.'/'.$ContentArray->Thumb;
					$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$_SESSION['userid']."', '$ContentTitle', '$ContentType', '$ContentID','$ContentThumb')";
					$DB->execute($query);
					insertUpdate('characters', 'posted', $ContentID, 'project', $UserID,'http://'.$_SERVER['SERVER_NAME'].'/'.$SafeFolder.'/characters/',$ProjectID,$ContentArray->Name);

			} else if ($ContentType == 'downloads') {
					$query = "SELECT * from comic_downloads where EncryptID='$ContentID' and (ComicID='$ProjectID' or ProjectID = '$ProjectID')";
					$ContentArray = $DB->queryUniqueObject($query);
					$ContentTitle =  mysql_real_escape_string($ContentArray->Name);
					$ContentThumb = $ProjectDirectory.'/'.$HostedUrl.'/'.$ContentArray->Thumb;
					$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$_SESSION['userid']."', '$ContentTitle', '$ContentType', '$ContentID','$ContentThumb')";
					$DB->execute($query);
					insertUpdate('downloads', 'posted', $ContentID, 'project', $UserID,'http://'.$_SERVER['SERVER_NAME'].'/'.$SafeFolder.'/downloads/',$ProjectID,$ContentArray->Name);
					
			} else if ($ContentType == 'mobile') {
					$query = "SELECT * from mobile_content where EncryptID='$ContentID' and (ComicID='$ProjectID' or ProjectID = '$ProjectID')";
					$ContentArray = $DB->queryUniqueObject($query);
					$ContentTitle =  mysql_real_escape_string($ContentArray->Name);
					$ContentThumb = $ContentArray->Thumb;
					$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$_SESSION['userid']."', '$ContentTitle', '$ContentType', '$ContentID','$ContentThumb')";
					$DBDB>execute($query);
				//	print $query.'<br/>';
					insertUpdate('mobile wallpaper', 'posted', $ContentID, 'project', $UserID,'http://'.$_SERVER['SERVER_NAME'].'/'.$SafeFolder.'/mobile/',$ProjectID,$ContentArray->Name);
			} else if ($ContentType == 'blog post') {
					$query = "SELECT bp.*,p.Thumb from pfw_blog_posts as bp
							  JOIN projects as p on p.ProjectID=(bp.ProjectID or bp.ComicID)
							  where bp.EncryptID='$ContentID' and (bp.ComicID='$ProjectID' or bp.ProjectID = '$ProjectID')";
					$ContentArray = $DB->queryUniqueObject($query);
				//	print $query.'<br/>';
					$ContentTitle =  mysql_real_escape_string($ContentArray->Title);
					
					$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$_SESSION['userid']."', '$ContentTitle', '$ContentType', '$ContentID','$ContentThumb')";
					$DB->execute($query);
					//print $query.'<br/>';
					insertUpdate('blog', 'posted', $ContentID, 'project', $UserID,'http://'.$_SERVER['SERVER_NAME'].'/'.$SafeFolder.'/blog/?post='.$ContentID,$ProjectID,$ContentArray->Title);
			
			} else if ($ContentType == 'forum topic') {
					
					$query = "SELECT t.*, u.username, p.Thumb from pf_forum_topics as t
							 left JOIN projects as p on p.ProjectID=t.ProjectID
							 join users as u on t.UserID=u.encryptid
							  where t.ID='$ContentID'";
							  
					if ($UpdateType == 'project'){
							$query .= "and t.ProjectID = '$ProjectID'";
							$UpdateContentID = $ProjectID;
					}else if ($UpdateType == 'user'){
							$query .= "and t.PosterID = '$UserID'";	
							$UpdateContentID = '';	
					}
					$ContentArray = $DB->queryUniqueObject($query);
				//	print $query.'<br/>';
					$ContentTitle =  mysql_real_escape_string($ContentArray->Subject);
						$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb,Tags) values ('$ProjectID', '".$_SESSION['userid']."', '".mysql_real_escape_string($ContentTitle)."', '$ContentType', '$ContentID','$ContentThumb','".mysql_real_escape_string($Tags)."')";
					$DB->execute($query);
					print $query.'<br/>';
					if ($UpdateType == 'project')
						$ContentLink = 'http://'.$_SERVER['SERVER_NAME'].'/'.$SafeFolder.'/forum/?a=read&topic='.$ContentArray->ID;
					else
						$ContentLink = 'http://users.wevolt.com/'.trim($ContentArray->username).'/forum/?a=read&topic='.$ContentArray->ID;
						
					insertUpdate('forum topic', 'started', $ContentID, $UpdateType, $_SESSION['userid'], $ContentLink,$UpdateContentID,$ContentArray->Subject);
					
			}else if ($ContentType == 'forum post') {
				
					$query = "SELECT m.*, p.Thumb from pf_forum_messages as m
							  left JOIN projects as p on p.ProjectID=m.ProjectID
							  
							  where m.ID='$ContentID' ";
							  
					if ($UpdateType == 'project'){
							$query.= "and m.ProjectID = '$ProjectID'";
							$UpdateContentID = $UserID;	
					}else if ($UpdateType == 'user'){
							$query.= "and m.UserID = '$UserID'";
							$UpdateContentID = '';	
					}
					$ContentArray = $DB->queryUniqueObject($query);
					//print $query.'<br/>';
					$ContentTitle =  mysql_real_escape_string($ContentArray->Subject);
				
					$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$_SESSION['userid']."', '$ContentTitle', '$ContentType', '$ContentID','$ContentThumb')";
					$DB->execute($query);
				//	print $query;
					if ($UpdateType == 'project')
						$ContentLink = 'http://'.$_SERVER['SERVER_NAME'].'/'.$SafeFolder.'/forum/?a=read&topic='.$ContentArray->TopicID.'&msg='.$ContentArray->ID;
					else
						$ContentLink = 'http://users.wevolt.com/'.trim($UserArray->username).'/forum/?a=read&topic='.$ContentArray->TopicID.'&msg='.$ContentArray->ID;
					//	print $query.'<br/>';
					insertUpdate('forum topic', 'replied to', $ContentID, $UpdateType, $UserID,$ContentLink,$UpdateContentID,$ContentArray->Subject);
					
			} else if ($ContentType == 'forum board') {
					$query = "SELECT b.*,p.Thumb from pf_forum_boards as b
							  left JOIN projects as p on p.ProjectID=b.ProjectID
							  where b.EncryptID='$ContentID'";
							  
					if ($UpdateType == 'project'){
							$query .= "and b.ProjectID = '$ProjectID'";
							$UpdateContentID = $ProjectID;	
					}else if ($UpdateType == 'user'){
							$query.= "and b.UserID = '$UserID'";	
							$UpdateContentID = '';	
					}
					$ContentArray = $DB->queryUniqueObject($query);
					//print $query.'<br/>';
					$ContentTitle =  mysql_real_escape_string($ContentArray->Title);
					$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$_SESSION['userid']."', '$ContentTitle', '$ContentType', '$ContentID','$ContentThumb')";
					$DB->execute($query);
					//print $query.'<br/>';
					if ($UpdateType == 'project')
						$ContentLink = 'http://'.$_SERVER['SERVER_NAME'].'/'.$SafeFolder.'/forum/?a=read&board='.$ContentArray->ID;
					else
						$ContentLink = 'http://users.wevolt.com/'.trim($UserArray->username).'/forum/?a=read&board='.$ContentArray->ID;
						
					insertUpdate('forum board', 'created', $ContentID, 	$UpdateType, $UserID,$ContentLink,$UpdateContentID,$ContentArray->Title);
			}
				$DB->close();
		} else if ($Action == 'delete') {
			 $DB=new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
			$query = "DELETE from project_content where ContentID='$ContentID' and ProjectID = '$ProjectID'";
			$DB->execute($query);
			//print $query.'<br/>';
				$DB->close();
		}

}
?>