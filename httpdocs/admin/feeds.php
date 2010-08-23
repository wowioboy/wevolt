<?php
include 'includes/db.class.php';
$RSSID = $_GET['id'];
require_once "syndication/rss.php";
require_once "XML/RSS.php";
$rss =& new XML_RSS($_SERVER['SERVER_NAME']."/syndication/rss.php?id=".$RSSID);
$rss->parse();

echo "<h1>From <a
href='http://".$_SERVER['SERVER_NAME']."'>My Blog</a></h1>\n"; echo "<ul>\n";

foreach ($rss->getItems() as $item) {
  echo "<li><a href=\"" . $item['link'] . "\">" . $item['headline'] . 
"</a></li>\n";
echo 'Published Date:'. $item['publishdate']."\n";
echo 'Author: '.$item['author'];
}
echo "</ul>\n";
?>
