#!/usr/bin/php -q
<?php 
include_once('/var/www/vhosts/wevolt.com/httpdocs/classes/defineThis.php');
include_once('/var/www/vhosts/wevolt.com/httpdocs/includes/db.class.php');
$link = mysql_connect(PANELDBHOST, PANELDBUSER, PANELDBPASS);
mysql_select_db(PANELDB,$link);
$CurrentDayRange = date('Y-m-d 00:00:00');
$today =date("Ymd", strtotime("-1 day"));
$HumanDate =date("m-d-Y", strtotime("-1 day"));
if (intval(date('d')) != 1){
		$query = 'SHOW COLUMNS FROM panel_panel.analytics_breakdown;';
		$results = mysql_query($query);
		//print $query;
		$query = "INSERT INTO panel_analytics.current_month(SELECT ";
		while ($row = mysql_fetch_array($results)) {
			if ($row[0] == 'ID') {
				$query .= 'NULL, ';
			} else {
				$query .= $row[0] . ', ';
			}
		} 
		$query = substr($query, 0, strlen($query) - 2);
		$query .= " FROM panel_panel.analytics_breakdown WHERE AnalyticDate<'$CurrentDayRange')";
		mysql_query($query);
		//print $query.'<br/>';
		$query ="delete from panel_panel.analytics_breakdown WHERE AnalyticDate<'$CurrentDayRange'";
		mysql_query($query);
		//print $query.'<br/>';
}
mysql_close($link);


$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$query = 'SELECT * from projects where installed=1 and Hosted=1 and  Published=1 order by title';
$db->query($query);
	
$Output = "DAILY PROJECT ANALAYTICS REPORT FOR ". $today."\r\n\r\n";
$header = "From: noreply@wevolt.com  <noreply@wevolt.com >\n";
$header .= "Reply-To: noreply@wevolt.com <noreply@wevolt.com>\n";
$header .= "X-Mailer: PHP/" . phpversion() . "\n";
$header .= "X-Priority: 1";
	$db2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);	
while ($line = $db->fetchNextObject()) {
		$ProjectID = $line->ProjectID;	
		//print 'ProjectID = ' .$ProjectID;
		$query = "SELECT r.*,p.hits as TotalHits, p.PagesUpdated as LastUpdated, p.title, p.cover, 
				  	(select count(*) from favorites as f where f.ProjectID=p.ProjectID) as TotalVolts,
				  	(SELECT distinct hits from analytics as a where a.ProjectID='$ProjectID' and a.date ='$today') as TodayHits,
					(SELECT count(*) from comic_pages as cp where cp.ComicID='$ProjectID') as TotalPages,
					(SELECT count(*) from pagecomments as pc where pc.comicid='$ProjectID') as TotalComments,
					(SELECT count(*) from likes as l where l.ProjectID='$ProjectID') as TotalLikes,
					(SELECT count(*) from pf_forum_boards as fb where fb.ProjectID='$ProjectID') as TotalForumBoards,
					(SELECT count(*) from pf_forum_messages as fm where fm.ProjectID='$ProjectID') as TotalForumMessages,
					(SELECT count(*) from pf_forum_topics as ft where ft.ProjectID='$ProjectID') as TotalForumTopics
					from rankings as r
					join projects as p on (r.ComicID=p.ProjectID)
					where r.ComicID='$ProjectID'";
								
		$RankArray = $db2->queryUniqueObject($query);
		if (trim($line->title) != '') {
		//print $query;
		$Output .= "PROJECT TITLE : ".$RankArray->title."\r\n";
		$Output .= "Last Updated : ".$RankArray->LastUpdated."\r\n";
		$Output .= "Today's Hits : ".$RankArray->TodayHits."\r\n";
		$Output .= "Total Hits : ".$RankArray->TotalHits."\r\n";
		$Output .= "Total Volts : ".$RankArray->TotalVolts."\r\n";
		$Output .= "Total Comments : ".$RankArray->TotalComments."\r\n";
		$Output .= "Total Likes : ".$RankArray->TotalLikes."\r\n";
		$Output .= "Total Pages : ".$RankArray->TotalPages."\r\n";
		$Output .= "Total Forum Boards : ".$RankArray->TotalForumBoards."\r\n";
		$Output .= "Total Forum Topics : ".$RankArray->TotalForumTopics."\r\n";
		$Output .= "Total Forum Messages : ".$RankArray->TotalForumMessages."\r\n";
		$Output .="\r\n";
		}
}		
	$db2->close();					
$db->close();
//print $Output;
mail('wevoltonline@gmail.com', 'Daily Project Analytics for '.$HumanDate,$Output, $header);
mail('theunlisted@gmail.com', 'Daily Project Analytics for '.$HumanDate,$Output, $header);
