<?php 
   $DEBUG=true;
  
 if ($DEBUG) {
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL ^ E_NOTICE);

}
include '../includes/db.class.php';
$db = new DB();
	$query = "SELECT * from comics where installed=1 and Published=1 order by title";
	$db->query($query);
		//print $query;
	while ($comic = $db->fetchNextObject()) { 
			//$ComicXML .='<comicid>'.$comic->comiccrypt.'</comicid>';
			$ComicXML .= $comic->title.','.$comic->writer.','.$comic->artist.','.$comic->colorist.','.$comic->tags.','.$comic->genre.','.$comic->tags;
		
		}
$db->close();
echo $ComicXML;
?>


