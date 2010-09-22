#!/usr/bin/php -q
<? 

include_once('/var/www/vhosts/wevolt.com/httpdocs/classes/defineThis.php');
include '/var/www/vhosts/wevolt.com/httpdocs/includes/db.class.php';
$DB =  new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$DB2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$query = 'delete from rankings';
$DB->execute($query);
$today = date("Ymd"); 
$CurrentDayRange = date('Y-m-d 00:00:00');
$query = "SELECT c.votes, c.PagesUpdated, c.title, c.ProjectID, c.ProjectType, c.hits as TotalPageViews, 
(select count(*) from favorites as f where f.comicid = c.ProjectID) as TotalFavorites,
(select count(*) from follows as fw where (fw.follow_id = c.ProjectID and fw.type='project')) as TotalFans,
(select count(*)  from comic_pages as cp where cp.comicid = c.ProjectID and cp.PublishDate<='$CurrentDayRange') as TotalPages,
(select count(*)  from comic_downloads as cd where cd.comicid = c.ProjectID) as TotalDownloads,
(select count(*)  from pfw_blog_posts as b where b.ComicID = c.ProjectID) as TotalPosts,
(select count(*)  from characters as cc where cc.comicid = c.ProjectID) as TotalCharacters,
(select count(*)  from mobile_content as mc where mc.comicid = c.ProjectID) as TotalMobile,
(select count(*)  from pagecomments as pc where pc.comicid = c.ProjectID) as TotalComments,
(SELECT distinct hits from analytics as a where a.ProjectID=c.ProjectID and a.date ='$today') as TodayHits,
(select TO_DAYS(c.PagesUpdated) from projects as p2 where p2.ProjectID = c.ProjectID) as LastUpdate,
(SELECT count(*) from likes as l where l.ProjectID=c.ProjectID) as TotalLikes,
(SELECT count(*) from pagecomments as pcom where (pcom.comicid=c.ProjectID and pcom.creationdate>='$CurrentDayRange')) as TodayComments,
(SELECT count(*) from pf_forum_boards as fb where fb.ProjectID=c.ProjectID) as TotalForumBoards,
(SELECT count(*) from pf_forum_messages as fm where fm.ProjectID=c.ProjectID) as TotalForumMessages,
(SELECT count(*) from pf_forum_topics as ft where ft.ProjectID=c.ProjectID) as TotalForumTopics
from projects as c where c.published=1 and c.installed=1 and c.Hosted=1 and c.IsPublic=1 and c.ProjectType != 'forum' and ShowRanking=1 order by ((TotalFavorites + TotalDownloads + TotalMobile + TotalComments + (TotalPages/2)) + TotalPosts + TodayHits+TotalFans+TotalForumBoards+TotalForumTopics+TotalForumMessages+TotalLikes+TodayComments) desc";
$DB->query($query);
$count = 1;
print $query.'<br/>';
while ($comic = $DB->fetchNextObject()) { 
$ComicID = $comic->ProjectID;
$ProjecType = $comic->ProjectType;
print $comic->title.'<br/>';
if ($ComicID != '') {
$query = "INSERT into rankings (ComicID, Rank) values ('$ComicID','$count')";
$DB2->execute($query);
print $query.'<br/>';
$query = "UPDATE projects set Ranking='$count' where ProjectID='$ComicID'";
$DB2->execute($query);
print $query.'<br/>';
print '<br/>';
print '<br/>';
$count++;


}

}
$DB->close();
$DB2->close();
?>