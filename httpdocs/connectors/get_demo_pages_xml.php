<?php 
include $_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php';
include  $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$DB2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
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
$ContentArray = explode('?content=',$_GET['content']);

$ContentQueryArray = explode('___',$ContentArray[0]);

$Content =$ContentQueryArray[0];
$Pages =$ContentQueryArray[2];


if ((trim($ContentQueryArray[3]) == 'u') && ($ContentQueryArray[4] != 'off'))
	$UserID =$ContentQueryArray[4];
else 
	$UserID =$ContentQueryArray[6];
	
if (trim($ContentQueryArray[5]) == 'off') 
	$Offset =$ContentQueryArray[6];
else 
	$Offset =$ContentQueryArray[8];

$OffSetArray = explode('-',$Offset);
$FirstPage = $OffSetArray[0];	
$LastPage = $OffSetArray[1];	
	//print_r($ContentQueryArray);
if ($FirstPage == '')
	$FirstPage = 1;

if ($LastPage == '')
	$LastPage = 60;
	
if (trim($ContentQueryArray[3]) == 'episode')
	$Episode =$ContentQueryArray[4];

$PageLimit = '22';

if ($Offset == '') 
		$PageOffset .= '0';
else
	$PageOffset .= ($Offset * 60);
	
$CurrentDate = date('Y-m-d').' 00:00:00';
$ComicDir = substr($Content,0,1);
$query = "SELECT count(*)
		  from panel_panel.comic_pages as cp
	      join panel_panel.projects as p on cp.ComicID=p.ProjectID
		  where p.SafeFolder='".$Content."' and p.ProjectType in ('comic','story','writing','gallery') and cp.PageType='pages' and cp.Episode=1 and cp.PublishDate<='$CurrentDate'";
		// print $query.'<br/>';
$TotalEpisodes = $DB->queryUniqueValue($query);

$query = "SELECT distinct cp.*, p.*, ps.ReaderCover, ps.ReaderBackground, ps.TocImg , ps.ReaderPageSetting
		  from panel_panel.comic_pages as cp
	      join panel_panel.projects as p on cp.ComicID=p.ProjectID
		  join panel_panel.comic_settings as ps on cp.ComicID=ps.ProjectID
		  where p.SafeFolder='".$Content."' and p.ProjectType in ('comic','story','writing','gallery') and cp.PageType='pages' and cp.PublishDate<='$CurrentDate' order by cp.Position";
	
$DB->query($query);



$NumPages = $DB->numRows();
$EpisodePageCount = 0;

$Count = 0;
$EpisodeCount = 0;
$ChapterCount = 1;
$InEpisode = 0;
$Finish = 0;
$TotalPageCount=0;

while ($Comic = $DB->FetchNextObject()) {
	if ($Count == 0) {
	
		$query = "select us.*, s.ID as IsPro, f.ID as ProInvite
          from users_settings as us
		  left join pf_subscriptions as s on s.UserID=us.UserID and s.Status='active'
		  left join fan_invitations as f on (f.UserID=us.UserID and f.ProjectID = '".$Comic->ProjectID."' and f.Status='active')
		  where us.UserID ='$UserID'"; 
		 
			$UserSettingsArray = $DB2->queryUniqueObject($query);

		if ($Comic->ReaderBackground == '') {
			$ReaderBackground = 'http://www.wevolt.com/images/reader_bg.jpg';
			$BGStretch = 'RESIZE_STRETCH';
			$BGAlign = 'ALIGN_LEFT|ALIGN_TOP';
		}else{
			$ReaderBackground = $Comic->ReaderBackground;
			$BGStretch = 'RESIZE_RESIZE_NORESIZE';
			$BGAlign = 'ALIGN_LEFT|ALIGN_TOP';
		}
			
		if ($Comic->TocImg == '')
			$TOCImg = 'http://www.wevolt.com/images/comic_toc_bkgrd.jpg';
		else
			$TOCImg =$Comic->TocImg;
		
		if ($Comic->ReaderCover == '')
			$CoverImage = 'http://www.wevolt.com'.$Comic->cover;
		else
			$CoverImage =$Comic->ReaderCover;	
		
		$XML = '<data bg="'.$ReaderBackground.'" bg_mp3="'.$bgMP3.'" id="'.$Content.'" p="'.$Pages.'" bg_color="0x'.$Comic->ReaderBGColor.'" bg_stretch_method="'.$BGStretch.'" bg_align_method="'.$BGAlign.'">';
		
			
		$XML .= '<!--buttons>ALL|PAGE_SPREAD|ZOOM|FULLSCREEN|PRINT|VOLUME|SHARE|HELP|BUYNOW|LOGO</buttons-->
		<reader_title>WEvolt dbook</reader_title>
	<buttons>ZOOM|FULLSCREEN|VOLUME</buttons>
	<!--logo>test_comic/logo.png</logo-->';

//$XML .= '<page>
		//<title>Cover Page</title>
		//<asset>'.$CoverImage.'</asset>
		//<thumb>http://www.wevolt.com'.$Comic->thumb.'</thumb>
	//</page>';
	
	//<toc>
		//<thumb>'.$TOCImg.'</thumb>
	//</toc>';
	
	}

	if ($Finish == 0) {
				//print 'MY EPISODE SEARCH = ' . $Episode.'<br/>';
			//	print 'EPISODE COUNT = ' . $EpisodeCount.'<br/>';
			if (($Comic->Episode == 1) && ($InEpisode == 1) && ($Episode != '')) {
					$Finish = 1;	
					if ($Episode < $TotalEpisodes) {
						$XML .= '<link>';
						$XML .= '<title>Next Episode</title>';
						$XML .= '<asset>http://www.wevolt.com/images/continue_reading.jpg</asset>';
						$XML .= '<thumb>http://www.wevolt.com/images/continue_thumb.jpg</thumb>';
						
						$XML .= '<url>http://www.wevolt.com/'.$Content.'/reader/episode/'.($Episode+1).'/</url>';
						$XML .= '</link>';
					
					}
			} else if (($Comic->Episode == 1) && ($InEpisode == 0) && ($Episode != '')) {
						$EpisodeCount++;
						$TotalPageCount = 0;	
						
					//	print 'WRONG EPISODE -- MOVING ON <br/>';				
			} else if ($Episode != '') {	
				
				if ($Episode == $EpisodeCount) {
					$InEpisode = 1;	
							if (($TotalPageCount >= $FirstPage ) && ($TotalPageCount <= $LastPage)) {
						$XML .= '<page>';
						if ($Comic->Episode == 1)
							$EpisodeTag = 'Episode '.$EpisodeCount.': ';
						else 
							$EpisodeTag = '';
						$XML .= '<title>'.$EpisodeTag.$Comic->Title.'</title>';
						if (($UserSettingsArray->ProInvite > 0) || ($UserSettingsArray->IsPro > 0)) {
							$XML .= '<asset>http://www.wevolt.com/'.$Comic->ProImage.'</asset>
								<thumb>http://www.wevolt.com/'.$Comic->ThumbMd.'</thumb>';
								
						} else {
							$XML .= '<asset>http://www.wevolt.com/comics/'.$ComicDir.'/'.$Content.'/images/pages/'.$Comic->Filename.'</asset>
								<thumb>http://www.wevolt.com/'.$Comic->ThumbMd.'</thumb>';
								
						}
								
						$XML .= '</page>';
						
						//if (($Comic->Episode == 1) || ($Pages == 1) ||  ($Comic->FileType == 'flv') ||  ($Comic->ReaderPageSetting == 1) )
							//$XML .= '<page></page>';
					}
					$TotalPageCount++;	
				
				}
			
			} else {
				
				if (($TotalPageCount >= $FirstPage ) && ($TotalPageCount <= $LastPage)) {
					
				$XML .= '<page>
				<title>';
				if ($Comic->Chapter == 1) {
					$XML .= 'Chapter '.$ChapterCount.': ';
					$ChapterCount++;
				}
				$XML .= $Comic->Title.'</title>';
				
					if (($UserSettingsArray->ProInvite > 0) || ($UserSettingsArray->IsPro > 0)) {
								$XML .= '<asset>http://www.wevolt.com/'.$Comic->ProImage.'</asset>
								<thumb>http://www.wevolt.com/'.$Comic->ThumbMd.'</thumb>';
								
								} else {
								$XML .= '<asset>http://www.wevolt.com/comics/'.$ComicDir.'/'.$Content.'/images/pages/'.$Comic->Filename.'</asset>
								<thumb>http://www.wevolt.com/'.$Comic->ThumbMd.'</thumb>';
								
								}
						$XML .= '</page>';
			/*
				if ($Pages == 1) 
					$XML .='<page></page>';
				else if ($Comic->Chapter == 1) 
					$XML .='<page></page>';
				else if ($Comic->Episode == 1)
					$XML .='<page></page>';
				else if ($Comic->FileType == 'flv') 
					$XML .='<page></page>';
				else if ($Comic->FullSpread == 1) 
					$XML .='<page></page>';	
				else if ($Comic->ReaderPageSetting == 1)
					$XML .='<page></page>';	
					
				*/
		   }
		    	$TotalPageCount++;	
		   }
		  
		/*
		
			$TotalPageCount++;	
*/
	}
$Count++;
	
}
$XML .= '</data>';
$PrettyXML = formatXmlString($XML);
echo $PrettyXML;

$DB->close();
$DB2->close();
	
	
	
?>


