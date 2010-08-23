<?php
include 'includes/db.class.php';
$RSSID = $_GET['feed'];
$db = new DB();
$query = "select * from rss where ID='$RSSID'";
$RSSSettings = $db->queryUniqueObject($query);


if ($RSSSettings->Application == 'blog') {
	$query = "select BlogTitle from pf_blog";
	$Title = $db->queryUniqueValue($query);
	$RSSCount = $RSSSettings->PostLimit;
	$Category = $RSSSettings->Category;
	if ($Category != 0) {
		$query = "select * from pf_blog_posts where category='$Category' order by PublishDate limit $RSSCount";
	} else {
		$query = "select * from pf_blog_posts order by PublishDate limit $RSSCount";
	}
	$TotalPages = 0;
	$db->query($query);
	$now = date("D, d M Y H:i:s T");
	$CurrentDate= date('D M j'); 
	$CurrentDay = date('d');
	$CurrentMonth = date('m');
	$CurrentYear = date('Y');
	$output = "<?xml version=\"1.0\"?>
            <rss version=\"2.0\"><channel>
                    <title>".$Title."</title>
                    <link>".$_SERVER['SERVER_NAME']."/rss.php?feed=".$RSSID."</link>
                    <description>".htmlentities($RSSSettings->Description)."</description>
                    <language>en-us</language>
                    <pubDate>$now</pubDate>
                    <lastBuildDate>$now</lastBuildDate>
                    <website>http://".$_SERVER['SERVER_NAME']."</website>
            ";
            
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
				$output .= "<item><headline>".htmlentities($line->Title)."</headline>
				<link>http://".htmlentities($_SERVER['SERVER_NAME']."/index.php?a=blog&p=".$PostID)."</link>
           		<author>".$line->Author."</author>
				<publishdate>".$line->PublishDate."</publishdate>
            	</item>";
			}
	}



}

$output .= "</channel></rss>";
header("Content-Type: application/rss+xml");
echo $output;
?>
