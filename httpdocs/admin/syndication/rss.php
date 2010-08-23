<?php
$FeedID = $_GET['id'];
//include '../includes/db.class.php';
$db = new DB();
$query = "select * from rss where ID='$FeedID'";
$now = date("D, d M Y H:i:s T");
$RSSSettings = $db->queryUniqueObject($query);
	$RSSCount = $RSSSettings->PostLimit;
	$Category = $RSSSettings->Category;
	$RssTitle = htmlentities($RSSSettings->Title);
	$RssDescription = htmlentities($RSSSettings->Description);
	$output = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?><rss version=\"2.0\" xmlns:media=\"http://search.yahoo.com/mrss/\"><channel><title>".$RssTitle."</title><link>http://".$_SERVER['SERVER_NAME']."</link><description>".$RssDescription."</description><pubDate>$now</pubDate>";
	
if ($RSSSettings->Application == 'blog') {
	$query = "select BlogTitle from pf_blog";
	$Title = $db->queryUniqueValue($query);
	if ($Category != 0) {
		$query = "select * from pf_blog_posts where category='$Category' order by PublishDate limit $RSSCount";
	} else {
		$query = "select * from pf_blog_posts order by PublishDate limit $RSSCount";
	}
	$TotalPages = 0;
	$db->query($query);
	
	$CurrentDate= date('D M j'); 
	$CurrentDay = date('d');
	$CurrentMonth = date('m');
	$CurrentYear = date('Y');
	
	while ($line = $db->fetchNextObject()) { 
			$Title = $line->Title;
			$PageTitle = $Title;
			$Filename = $line->Filename;
			$Author = 		$line->Author;
			$PublishDate = 	$line->PublishDate;
			$PostID = $line->ID;
			$idSafe =0;
 			$Date = $line->datelive;
			$PageDay = substr($PublishDate, 3, 2); 
			$PageMonth = substr($PublishDate, 0, 2); 
			$PageYear = substr($PublishDate, 6, 4);
			if ($PageYear<$CurrentYear) {
							//print "SAFE ID = " .$SafeID."<br/>";
				$idSafe = 1; 
				$TotalPages++;
		   	} else if ($PageYear == $CurrentYear) {
						if ($PageMonth<$CurrentMonth) {
									//print "SAFE ID = " .$SafeID."<br/>"; 
							$idSafe = 1; 
							 $TotalPages++;
						   } else if ($PageMonth == $CurrentMonth) {
									if ($PageDay<=$CurrentDay) {
											//print "SAFE ID = " .$SafeID."<br/>"; 
										$idSafe = 1; 
										$TotalPages++;
			        				} // End If
						   	} // End PageMonth
		   	}
				//print "MY IDSAFE = " . $idSafe."<br/>";
			if ($idSafe == 1) {
				$output .= "<item><title>".htmlentities($line->Title)."</title>
				<link>http://".htmlentities($_SERVER['SERVER_NAME']."/index.php?a=blog&p=".$PostID)."</link>
				<description></description>
           		<author>".$line->Author."</author>
				<pubdate>".$line->PublishDate."</pubdate>
            	</item>";
			}
	}



} else if ($RSSSettings->Application == 'gallery') {
	//$Title = $db->queryUniqueValue($query);
	if ($Category != 0) {
		$query = "select * from pf_gallery_content where category='$Category' order by CreationDate ASC limit $RSSCount";
	} else {
		$query = "select * from pf_gallery_content order by CreationDate ASC limit $RSSCount";
	}
	$db->query($query);
		while ($line = $db->fetchNextObject()) { 
			$Title = $line->Title;
			$ImageID = $line->ID;
			$Description = $line->Description;
			$SmallThumb = "http://".$_SERVER['SERVER_NAME']."/".$line->ThumbLg;
			$output .= "<item><title>".htmlentities($line->Title)."</title>
				<link>http://".htmlentities($_SERVER['SERVER_NAME']."/index.php?a=gallery&item=".$ImageID)."</link>
				<description>".$Description."</description>
           		 <enclosure url=\"".$SmallThumb."\" type=\"image/jpeg\"/>
				 <media:thumbnail url=\"".$SmallThumb."\" width=\"75\" height=\"50\" />
				<author></author>
				<pubdate>".$line->CreationDate."</pubdate>
            	</item>";
				
				}
}

$output .= "</channel></rss>";
header("Content-Type: application/rss+xml");
echo $output;
?>



