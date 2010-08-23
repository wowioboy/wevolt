<?php 
include '../includes/db.class.php';
include '../includes/content_function.php';
$DB = new DB();
$DB2 = new DB();
// CHARACTERS
/*
 $query = "SELECT c.HostedUrl, ch.*, u.encryptid as UserID from characters as ch
 		   join comics as c on ch.ComicID=c.comiccrypt
		   join users as u on c.userid=u.encryptid";
$DB->query($query);

while ($Comic = $DB->FetchNextObject()) {
	$ProjectID = $Comic->ComicID;
	$Title = mysql_real_escape_string($Comic->Name);
	print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	$Thumb = 'comics/'.$Comic->HostedUrl.'/'.$Comic->Thumb;
	$DB2 = new DB();
	$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$Comic->UserID."', '$Title', 'characters', '".$Comic->EncryptID."','".$Thumb."')"; 
			$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}

*/
/*
// DOWNLOADS

 $query = "SELECT p.HostedUrl, dl.*, u.encryptid as UserID from comic_downloads as dl
 		   join projects as p on dl.ComicID=p.comiccrypt
		   join users as u on p.userid=u.encryptid";
$DB->query($query);

while ($Comic = $DB->FetchNextObject()) {
	$ProjectID = $Comic->ComicID;
	$Title = mysql_real_escape_string($Comic->Name);
	print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	$Thumb = 'comics/'.$Comic->HostedUrl.'/'.$Comic->Thumb;
	$DB2 = new DB();
	$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$Comic->UserID."', '$Title', 'downloads', '".$Comic->EncryptID."','".$Thumb."')"; 
			$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}
*/
// MOBILE
/*
 $query = "SELECT p.HostedUrl, m.*, u.encryptid as UserID from mobile_content as m
 		   join projects as p on m.ComicID=p.comiccrypt
		   join users as u on p.userid=u.encryptid";
$DB->query($query);

while ($Comic = $DB->FetchNextObject()) {
	$ProjectID = $Comic->ComicID;
	$Title = mysql_real_escape_string($Comic->Title);
	print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	$Thumb = $Comic->Thumb;
	$DB2 = new DB();
	$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$Comic->UserID."', '$Title', 'mobile', '".$Comic->EncryptID."','".$Thumb."')"; 
			$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}
	
// COMIC PAGES

 $query = "SELECT p.HostedUrl,p.thumb as Thumb, bp.*, u.encryptid as UserID from pfw_blog_posts as bp
 		   join projects as p on bp.ComicID=p.comiccrypt
		   join users as u on p.userid=u.encryptid";
$DB->query($query);

while ($Comic = $DB->FetchNextObject()) {
	$ProjectID = $Comic->ComicID;
	$Title = mysql_real_escape_string($Comic->Title);
	$PageType = $Comic->PageType;
	print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	$Thumb = $Comic->Thumb;
	$DB2 = new DB();
	$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$Comic->UserID."', '$Title', 'blog post', '".$Comic->EncryptID."','".$Thumb."')"; 
			$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}



 $query = "SELECT p.HostedUrl,p.thumb as Thumb, cp.*, u.encryptid as UserID from comic_pages as cp
 		   join projects as p on cp.ComicID=p.comiccrypt
		   join users as u on p.userid=u.encryptid
		   where PageType='extras'";
$DB->query($query);

while ($Comic = $DB->FetchNextObject()) {
	$ProjectID = $Comic->ComicID;
	$Title = mysql_real_escape_string($Comic->Title);
	$PageType = $Comic->PageType;
	print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	$Thumb = $Comic->Thumb;
	$DB2 = new DB();
	$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$Comic->UserID."', '$Title', 'extras', '".$Comic->EncryptID."','".$Thumb."')"; 
			//$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}

 $query = "SELECT p.HostedUrl,p.thumb as Thumb, b.ProjectID as Project, b.*,b.ID as BoardID, u.encryptid as UserID, u.avatar
 		   from pf_forum_boards as b
 		   left join projects as p on (b.ProjectID=p.ProjectID and b.ProjectID != '')
		   join users as u on b.UserID=u.encryptid";
$DB->query($query);

while ($Comic = $DB->FetchNextObject()) {
	$ProjectID = $Comic->Project;
	$Title = mysql_real_escape_string($Comic->Title);
	$ContentType = 'forum_board';
	
	print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	if ($ProjectID == ''){
		$Thumb = $Comic->avatar;
		$SelectType = 'user';
	}else{
		$Thumb = $Comic->Thumb;
		$SelectType = 'project';
	}
	$UserID = $Comic->encryptid;
	$DB2 = new DB();
	$query = "INSERT into projects (ProjectID, userid, Title, ProjectType, Thumb, SelectType, Published) values ('$ProjectID', '".$Comic->UserID."', '$Title', 'forum','".$Thumb."','$SelectType', 1)"; 
			$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}

	//FORUM TOPICS
	/*
	
	 $query = "SELECT  p.SafeFolder, p.thumb,t.*, t.ID as TopicID, u.username, u.avatar, u.encryptid, u2.username as ForumOwner
 		   from pf_forum_topics as t
		   left join projects as p on (p.ProjectID=t.ProjectID and t.ProjectID != '')
		   join users as u on u.encryptid=t.PosterID
		   join users as u2 on u2.encryptid=t.UserID";
$DB2->query($query);
print $query;
while ($Comic = $DB2->FetchNextObject()) {
	$ProjectID = $Comic->ProjectID;
	$Title = mysql_real_escape_string($Comic->Subject);
	$ContentType = 'forum topic';
	
	print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	if ($ProjectID == '') {
		
		$Thumb = $Comic->avatar;
		$ContentLink ='http://www.w3volt.com/w3forum/'.$Comic->ForumOwner.'/?a=read&topic='.$Comic->TopicID;
		$UpdateType ='user';
		$ActionID = $Comic->PosterID;
		
	}else{
		$ContentLink ='http://www.w3volt.com/r3forum/'.$Comic->SafeFolder.'/?a=read&topic='.$Comic->TopicID;
		$Thumb = 'http://www.panelflow.com'. $Comic->Thumb;
		$UpdateType ='project';
		$ActionID = $ProjectID;
	}
	$UserID = $Comic->encryptid;
	$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$Comic->UserID."', '$Title', '$ContentType', '".$Comic->TopicID."','".$Thumb."')"; 
			$DB->execute($query);
		print $query.'<br/>';
			
			$NOW = date('Y-m-d h:i:s');
			$UDate = date('Y-m-d');
			$query = "INSERT into updates (ActionSection, ActionType, ActionID, UpdateType, UserID, Link, CreatedDate, UpdateDate) values ('$ContentType', 'started', '$ActionID', '$UpdateType', '".$Comic->UserID."','$ContentLink','$NOW','$UDate')";
					$DB->execute($query);
	
		print $query.'<br/><br/>';
	}
	
	
	//FORUM MESSAGES
	 $query = "SELECT  p.SafeFolder, p.thumb,m.*, t.ProjectID as Project, u.username, u.avatar, u.encryptid, u2.username as ForumOwner
 		   from pf_forum_messages as m
		   join pf_forum_topics as t on t.ID=m.TopicID
		   left join projects as p on (p.ProjectID=t.ProjectID and t.ProjectID != '')
		   join users as u on u.encryptid=m.PosterID
		   join users as u2 on u2.encryptid=m.UserID";
$DB2->query($query);
print $query;
while ($Comic = $DB2->FetchNextObject()) {
	$ProjectID = $Comic->Project;
	$Title = mysql_real_escape_string($Comic->Subject);
	$ContentType = 'forum post';
	
	print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	if ($ProjectID == '') {
		
		$Thumb = $Comic->avatar;
		$ContentLink ='http://www.w3volt.com/w3forum/'.$Comic->ForumOwner.'/?a=read&topic='.$Comic->TopicID.'&msg='.$Comic->ID;
		$UpdateType ='user';
		$ActionID = $Comic->PosterID;
		
	}else{
		$ContentLink ='http://www.w3volt.com/r3forum/'.$Comic->SafeFolder.'/?a=read&topic='.$Comic->TopicID.'&msg='.$Comic->ID;
		$Thumb = 'http://www.panelflow.com'. $Comic->Thumb;
		$UpdateType ='project';
		$ActionID = $ProjectID;
	}
	$UserID = $Comic->encryptid;
	$query = "INSERT into project_content (ProjectID, UserID, Title, ContentType, ContentID, Thumb) values ('$ProjectID', '".$Comic->UserID."', '$Title', '$ContentType', '".$Comic->ID."','".$Thumb."')"; 
			$DB->execute($query);
		print $query.'<br/>';

			$NOW = date('Y-m-d h:i:s');
			$UDate = date('Y-m-d');
			$query = "INSERT into updates (ActionSection, ActionType, ActionID, UpdateType, UserID, Link, CreatedDate, UpdateDate) values ('forum topic', 'replied to', '$ActionID', '$UpdateType', '".$Comic->UserID."','$ContentLink','$NOW','$UDate')";
					$DB->execute($query);
	
		print $query.'<br/><br/>';
	}
	
	
	
	 $query = "SELECT count(*), p.SafeFolder,p.thumb as Thumb, b.ComicID as Project, b.*, p.UserID, u.avatar
 		   from pfw_blog_posts as b
 		   left join projects as p on ((b.ProjectID=p.ProjectID and b.ProjectID != '') or (b.ComicID=p.ProjectID and b.ComicID != ''))
		   left join users as u on p.UserID=u.encryptid
		   where p.installed=1
		   group by b.ComicID ";
$DB->query($query);
print $query.'<br/>';
while ($Comic = $DB->FetchNextObject()) {
	$ProjectID = $Comic->Project;
	$Title = mysql_real_escape_string($Comic->Title);
	$ContentType = 'forum_board';
	
	print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	if ($ProjectID == ''){
		$Thumb = $Comic->avatar;
		$SelectType = 'user';
	}else{
		$Thumb = $Comic->Thumb;
		$SelectType = 'project';
	}
	$UserID = $Comic->encryptid;
	$DB2 = new DB();
	$query = "INSERT into projects (ProjectID, userid, Title, ProjectType, Thumb, SelectType, Published, SafeFolder) values ('$ProjectID', '".$Comic->UserID."', '$Title', 'blog','".$Thumb."','$SelectType', 1,'".$Comic->SafeFolder."')"; 
		$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}
*/
$DB->close();
$DB2->close();
?>


