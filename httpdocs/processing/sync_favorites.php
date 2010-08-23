<?php 
include '../includes/db.class.php';
$DB = new DB();

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
	
	*/
	
	 $query = "SELECT * from favorites";
$DB->query($query);

while ($Comic = $DB->FetchNextObject()) {
	$ProjectID = $Comic->comicid;
	//$Title = mysql_real_escape_string($Comic->Title);
	$FavID = $Comic->favid;
	//print 'TITLE = '.$Title.'<br/>';
	//$ComicDir = substr($Comic->ProjectTitle,); 
	//$Thumb = $Comic->Thumb;
	$DB2 = new DB();
	$query = "UPDATE favorites set ProjectID='$ProjectID', ContentType='comic' where favid='$FavID'"; 
			$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}
$DB->close();
$DB2->close();
?>


