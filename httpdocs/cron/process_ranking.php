<? 
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';
$DB = new DB();
$DB2 = new DB();
$query = 'delete from rankings';
$DB->execute($query);
$query = "SELECT c.votes, c.PagesUpdated,c.pages, c.title, c.ProjectID, c.ProjectType, c.hits as TotalPageViews, 
(select count(*) from favorites as f where f.comicid = c.ProjectID) as TotalFavorites,
(select count(*)  from comic_pages as cp where cp.comicid = c.ProjectID) as TotalPages,
(select count(*)  from comic_downloads as cd where cd.comicid = c.ProjectID) as TotalDownloads,
(select count(*)  from pfw_blog_posts as b where b.ComicID = c.ProjectID) as TotalPosts,
(select count(*)  from characters as cc where cc.comicid = c.ProjectID) as TotalCharacters,
(select count(*)  from mobile_content as mc where mc.comicid = c.ProjectID) as TotalMobile,
(select count(*)  from pagecomments as pc where pc.comicid = c.ProjectID) as TotalComments
from projects as c where c.published=1 and c.installed=1 and c.Hosted=1 and c.ProjectType != 'forum' order by ((TotalFavorites + TotalDownloads + TotalMobile + TotalComments + (TotalPages*2) +(PagesUpdated*3)) + TotalPosts + (TotalPageViews /15)+c.pages) desc";
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