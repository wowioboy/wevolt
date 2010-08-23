<?php
 $RSSID = $_GET['id'];
// Make sure SimplePie is included. You may need to change this to match the location of simplepie.inc.
require_once('simplepie/simplepie.inc');
 
// We'll process this feed with all of the default options.
$feed = new SimplePie('http://'.$_SERVER['SERVER_NAME'].'/syndication/rss.php?id='.$RSSID);
 
// This makes sure that the content is sent to the browser as text/html and the UTF-8 character set (since we didn't change it).
$feed->handle_content_type();
 
// Let's begin our XHTML webpage code.  The DOCTYPE is supposed to be the very first thing, so we'll keep it on the same line as the closing-PHP tag.
?>

<?php
//include 'includes/db.class.php';

//require_once "syndication/rss.php";
//require_once "XML/RSS.php";
//$rss =& new XML_RSS($_SERVER['SERVER_NAME']."/syndication/rss.php?id=".$RSSID);
//$rss->parse();

//echo "<h1>From <a
//href='http://".$_SERVER['SERVER_NAME']."'>My Blog</a></h1>\n"; echo "<ul>\n";

//foreach ($rss->getItems() as $item) {
 // echo "<li><a href=\"" . $item['link'] . "\">" . $item['headline'] . 
//"</a></li>\n";
//echo 'Published Date:'. $item['publishdate']."\n";
//echo 'Author: '.$item['author'];
//}
//echo "</ul>\n";
///?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
        "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
 
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<title>Sample SimplePie Page</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>
 
	<div class="header">
		<h1><a href="<?php echo $feed->get_permalink(); ?>"><?php echo $feed->get_title(); ?></a></h1>
		<p><?php echo $feed->get_description(); ?></p>
	</div>
 
	<?php
	/*
	Here, we'll loop through all of the items in the feed, and $item represents the current item in the loop.
	*/
	foreach ($feed->get_items() as $item):
	?>
 
		<div class="item">
			<h2><a href="<?php echo $item->get_permalink(); ?>"><?php echo $item->get_title(); ?></a></h2>
			<p><?php echo $item->get_description(); ?></p>
			<p><small>Posted on <?php echo $item->get_date('j F Y | g:i a'); ?></small></p>
		</div>
 
	<?php endforeach; ?>