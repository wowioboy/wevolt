<? 
// SELECT SETTINGS FROM MODULE TABLE
$blogcatdb = new DB();
$query = "SELECT * from pf_blog_posts order by PublishDate";
$blogcatdb->query($query);
$blogcatString = "";	
$blogcatString = "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td>";
while ($line = $blogcatdb->fetchNextObject()) { 

		$blogcatString .= "<div class='cat_item_mod'><a href='index.php?a=blog&p=".$line->ID."' border='1' >".$line->Title."</a><span class='menubullet'>>></span>";
}

$blogcatString .=  "</td></tr></table>";
echo $blogcatString;
?>