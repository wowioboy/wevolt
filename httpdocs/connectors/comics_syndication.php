<?php 
   $DEBUG=false;
  
 if ($DEBUG) {
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL ^ E_NOTICE);

}
include '../includes/db.class.php';
$db = new DB();
	$query = "select * from comics as c
						join rankings as r on c.comiccrypt=r.ComicID
				        where c.installed = 1 and c.Published = 1 ORDER BY r.ID ASC";
	$db->query($query);
		//print $query;
	$ComicXML = '<comics>';

	while ($comic = $db->fetchNextObject()) { 
	
	if (substr($comic->thumb,0,4) != 'http')
		 $ComicThumb = 'http://www.panelflow.com'. $comic->thumb;
	else 
	     $ComicThumb = $comic->thumb;
		 
			$ComicXML .= '<comic>';
			//$ComicXML .='<comicid>'.$comic->comiccrypt.'</comicid>';
			$ComicXML .='<title>'.addslashes($comic->title).'</title>';
			$ComicXML .='<writer>'.addslashes($comic->writer).'</writer>';
			$ComicXML .='<thumbnail>'.$ComicThumb.'</thumbnail>';
			$ComicXML .='<comiclink>'.$comic->SafeFolder.'</comiclink>';
			$ComicXML .= '</comic>';	
					
		}
$ComicXML .= '</comics>';
$db->close();
echo '&contentxml='.$ComicXML;
?>


