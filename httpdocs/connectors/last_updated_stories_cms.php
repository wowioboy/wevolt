<?php 
   $DEBUG=false;
  
 if ($DEBUG) {
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL ^ E_NOTICE);

}
$Token = $_GET['t'];
include '../includes/db.class.php';
$db = new DB();
$db2 = new DB();
	
	$query = "select * from stories as c where c.installed = 1 and c.Published = 1 and c.CMSToken='$Token' ORDER BY c.PagesUpdated DESC";
	$db->query($query);
	
	$myValues = array();
	$count = 0;
	$Today = date('Y-m-d h:m:s');
	while ($comic = $db->fetchNextObject()) { 
	
	$StoryID = $comic->StoryID;
	$query = "select PublishDate from pfw_blog_posts where PublishDate<='$Today' and StoryID='$StoryID' order by PublishDate DESC";
	$BlogUpdated = $db2->queryUniqueValue($query);
		
	$myValues[$count]['Title'] = stripslashes($comic->title);
	
	if (substr($comic->thumb,0,4) != 'http')
		 $ComicThumb = 'http://www.panelflow.com'. $comic->thumb;
	else 
	     $ComicThumb = $comic->thumb;
	

	if ($comic->Hosted == 1) {
			$fileUrl = 'http://www.panelflow.com'.$comic->thumb;
			$comicURL = $comic->url.'/';
	} else if (($comic->Hosted == 2) && (substr($comic->thumb,0,4) != 'http'))  {
			$fileUrl = 'http://www.panelflow.com'.$comic->thumb;
			$comicURL = $comic->url;
   } else {
			$fileUrl = $comic->thumb;
			$comicURL = $comic->url;
	}
	$myValues[$count] = array('Title'=>stripslashes($comic->title),'Url'=>$comicURL,'Thumb'=>$ComicThumb,'Updated'=>$comic->PagesUpdated,'PFID'=>$comic->SafeFolder,'BlogUpdated'=>$BlogUpdated);
	$count++;
		}

$db->close();
$db2->close();
echo serialize ($myValues);
?>


