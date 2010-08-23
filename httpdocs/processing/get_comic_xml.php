<?php 
include '../includes/db.class.php';
$DB = new DB();
function formatXmlString($xml) {  
  
  // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
  $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
  
  // now indent the tags
  $token      = strtok($xml, "\n");
  $result     = ''; // holds formatted version as it is built
  $pad        = 0; // initial indent
  $matches    = array(); // returns from preg_matches()
  
  // scan each line and adjust indent based on opening/closing tags
  while ($token !== false) : 
  
    // test for the various tag states
    
    // 1. open and closing tags on same line - no change
    if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) : 
      $indent=0;
    // 2. closing tag - outdent now
    elseif (preg_match('/^<\/\w/', $token, $matches)) :
      $pad--;
    // 3. opening tag - don't pad this one, only subsequent tags
    elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
      $indent=1;
    // 4. no indentation needed
    else :
      $indent = 0; 
    endif; 
    
    // pad the line with the required number of leading spaces
    $line    = str_pad($token, strlen($token)+$pad, ' ', STR_PAD_LEFT);
    $result .= $line . "\n"; // add to the cumulative result, with linefeed
    $token   = strtok("\n"); // get the next token
    $pad    += $indent; // update the pad size for subsequent lines    
  endwhile; 
  
  return $result;
  }
$CurrentDate = date('Y-m-d').' 00:00:00';
$ComicDir = substr($_GET['content'],0,1);
$query = "SELECT cp.*, c.* from panel_panel.comic_pages as cp
	      join panel_panel.comics as c on cp.ComicID=c.comiccrypt
		  where c.SafeFolder='".$_GET['content']."' and cp.PageType='pages' and cp.PublishDate<='$CurrentDate' order by cp.Position";
$DB->query($query);
$Count = 0;
$ChapterCount = 1;
$EpisodeCount = 1;
$InEpisode = 0;
$Finish = 0;
while ($Comic = $DB->FetchNextObject()) {
	if ($Count == 0) {
		$XML = '<data bg="http://images.barkit.gameriot.com/barkit/default/barkit_comic_bkgrd.jpg" id="'.$_GET['content'].'">

<page>
		<title>Cover Page</title>
		<asset>http://www.panelflow.com'.$Comic->cover.'</asset>
		<thumb>http://www.panelflow.com'.$Comic->thumb.'</thumb>
	</page>
	
	<toc>
		<thumb>http://www.w3volt.com/images/comic_toc_bkgrd.jpg</thumb>
	</toc>';
	
	}
	if ($Finish == 0) {
			if (($Comic->Episode == 1) && ($InEpisode == 1) && ($_GET['episode'] != '')) {
					$Finish = 1;
					
			} else if ($_GET['episode'] != '') {	
			
				if ($_GET['episode'] == $EpisodeCount) {
					$InEpisode = 1;		
					$XML .= '<page>';
					if ($Comic->Episode == 1)
						$EpisodeTag = 'Episode '.$EpisodeCount.': ';
					else 
						$EpisodeTag = '';
					$XML .= '<title>'.$EpisodeTag.$Comic->Title.'</title>
								<asset>http://www.panelflow.com/comics/'.$ComicDir.'/'.$_GET['content'].'/images/pages/'.$Comic->Filename.'</asset>
								<thumb>http://www.panelflow.com/'.$Comic->ThumbMd.'</thumb>
								</page>';
					if (($Comic->Episode == 1) || ($_GET['p'] == 1))
						$XML .= '<page></page>';
				} else {
					$EpisodeCount++;
				}
		
			} else {
				
				$XML .= '<page>
				<title>';
				if ($Comic->Chapter == 1) {
					$XML .= 'Chapter '.$ChapterCount.': ';
					$ChapterCount++;
				}
				$XML .= $Comic->Title.'</title>
						<asset>http://www.panelflow.com/comics/'.$ComicDir.'/'.$_GET['content'].'/images/pages/'.$Comic->Filename.'</asset>
						<thumb>http://www.panelflow.com/'.$Comic->ThumbMd.'</thumb>
						</page>';
			
				if ($_GET['p'] == 1) 
					$XML .='<page></page>';
				else if ($Comic->Chapter == 1) 
					$XML .='<page></page>';
				else if ($Comic->Episode == 1)
					$XML .='<page></page>';
				else if ($Comic->FileType == 'flv') 
					$XML .='<page></page>';
				
		   }
		/*
		
		
*/
	}
$Count++;
	
}
$XML .= '</data>';
$PrettyXML = formatXmlString($XML);
echo $PrettyXML;

$DB->close();

	
	
	
?>


