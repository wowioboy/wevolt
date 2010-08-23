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
	$LastPage = 32;
	
if (trim($ContentQueryArray[3]) == 'episode')
	$EpisodeArray =@explode('-',$ContentQueryArray[4]);

$SeriesNum = $EpisodeArray[0];
if ($SeriesNum == '')
	$SeriesNum = 1;
$EpisodeNum = $EpisodeArray[1];
if ($EpisodeNum == '')
	$EpisodeNum = 1;
	
$PageLimit = '32';

if ($Offset == '') 
		$PageOffset .= '0';
else
	$PageOffset .= ($Offset * 32);
	
$CurrentDate = date('Y-m-d').' 00:00:00';
$ComicDir = substr($Content,0,1);
$query = "SELECT p.*, ps.ReaderCover, ps.ReaderBackground, ps.TocImg , ps.ReaderPageSetting
	      from panel_panel.projects as p 
		  join panel_panel.comic_settings as ps on p.ProjectID=ps.ProjectID
		  where p.SafeFolder='".$Content."' and p.ProjectType in ('comic','story','writing','gallery')";
		 // print $query.'<br/>';
		
$ProjectArray = $DB->queryUniqueObject($query);


$query = "select count(*) from Episodes where ProjectID = '".$ProjectArray->ProjectID."' and SeriesNum='$SeriesNum'";
$TotalEpisodes = $DB->queryUniqueValue($query);

								
$query = "select * from comic_pages where ComicID = '".$ProjectArray->ProjectID."' and PageType='pages' and PublishDate<='$CurrentDate' and SeriesNum='$SeriesNum' and EpisodeNum='$EpisodeNum' order by EpPosition";
$DB->query($query);

$NumPages = $DB->numRows();
$EpisodePageCount = 0;

$Count = 0;

$ChapterCount = 0;
$TotalPageCount=1;

while ($Comic = $DB->FetchNextObject()) {
	if ($Count == 0) {
		$query = "select us.*, s.ID as IsPro, f.ID as ProInvite
          from users_settings as us
		  left join pf_subscriptions as s on s.UserID=us.UserID and s.Status='active'
		  left join fan_invitations as f on (f.UserID=us.UserID and f.ProjectID = '".$Comic->ProjectID."' and f.Status='active')
		  where us.UserID ='$UserID'"; 
			$UserSettingsArray = $DB2->queryUniqueObject($query);

		if ($ProjectArray->ReaderBackground == '') {
			$ReaderBackground = 'http://www.wevolt.com/images/reader_bg.jpg';
			$BGStretch = 'RESIZE_STRETCH';
			$BGAlign = 'ALIGN_LEFT|ALIGN_TOP';
		}else{
			$ReaderBackground = $ProjectArray->ReaderBackground;
			$BGStretch = 'RESIZE_STRETCH_IF_LARGER';
			$BGAlign = 'ALIGN_LEFT|ALIGN_TOP';
		}
		
		if ($ProjectArray->TocImg == '')
			$TOCImg = 'http://www.wevolt.com/images/comic_toc_bkgrd.jpg';
		else
			$TOCImg =$ProjectArray->TocImg;
		
		if ($ProjectArray->ReaderCover == '')
			$CoverImage = 'http://www.wevolt.com'.$Comic->cover;
		else
			$CoverImage =$ProjectArray->ReaderCover;	

		$XML = '<data bg="'.$ReaderBackground.'" bg_mp3="'.$bgMP3.'" id="'.$Content.'" p="'.$Pages.'" bg_color="0x'.$ProjectArray->ReaderBGColor.'" bg_stretch_method="'.$BGStretch.'" bg_align_method="'.$BGAlign.'">';
		
		$XML .= '<!--buttons>ALL|PAGE_SPREAD|ZOOM|FULLSCREEN|PRINT|VOLUME|SHARE|HELP|BUYNOW|LOGO</buttons-->
		<reader_title>wevolt dbook</reader_title>
	<buttons>CONFIG|PAGE_SPREAD|ZOOM|FULLSCREEN|VOLUME|SHARE</buttons>
	<!--logo>test_comic/logo.png</logo-->';

$XML .= '<page>
		<title>Cover Page</title>
		<asset>'.$CoverImage.'</asset>
		<thumb>http://www.wevolt.com'.$ProjectArray->thumb.'</thumb>
	</page>';
	
	//<toc>
		//<thumb>'.$TOCImg.'</thumb>
	//</toc>';
	if ($EpisodeNum != 1) {
	$XML .= '<link>';
	$XML .= '<title>Previous Episode</title>';
	$XML .= '<asset>http://www.wevolt.com/images/prev_episode_jump.jpg</asset>';
	$XML .= '<thumb>http://www.wevolt.com/images/continue_thumb.jpg</thumb>';			
	$XML .= '<url target="_self">http://www.wevolt.com/'.$Content.'/reader/';
	if (($SeriesNum != 1) && ($SeriesNum != ''))
		$XML .= 'series/'.$SeriesNum.'/';
	$XML .= 'episode/'.($EpisodeNum-1).'/</url>';
	$XML .= '</link>';
					
}

	}

	if (($TotalPageCount >= $FirstPage ) && ($TotalPageCount <= $LastPage)) {
		$XML .= '<page>';
		$EpisodeTag = 'Episode '.$EpisodeNum.': ';
		if ($Comic->Chapter == 1) {
			$ChapterTag = ' Chapter '.$ChapterCount.': ';
					$ChapterCount++;
		} else {
			$ChapterTag = '';
		}
		$XML .= '<title>'.$EpisodeTag.$ChapterTag.$Comic->Title.'</title>';
		
		if (($UserSettingsArray->ProInvite > 0) || ($UserSettingsArray->IsPro > 0) && ($Comic->ProImage != '') && ($Comic->FileType !='flv') && ($Comic->FileType !='swf') && ($Comic->FileType !='mp3')) {
			$XML .= '<asset>http://www.wevolt.com/'.$Comic->ProImage.'</asset>
					 <thumb>http://www.wevolt.com/'.$Comic->ThumbSm.'</thumb>';
								
		} else {
			$XML .= '<asset>http://www.wevolt.com/'.$ProjectArray->ProjectDirectory.'/'.$ComicDir.'/'.$Content.'/images/pages/'.$Comic->Filename.'</asset>
					<thumb>http://www.wevolt.com/'.$Comic->ThumbSm.'</thumb>';
								
		}
		
								
		$XML .= '</page>';
		if ($Comic->FileType =='flv')
			$XML .= '<page></page>';

	}
	$TotalPageCount++;	

$Count++;
	
}
if ($NumPages > $LastPage) {
	$Part = ($LastPage+1).'-'.($LastPage+32);
	$XML .= '<link>';
	$XML .= '<title>Contine Reading</title>';
	$XML .= '<asset>http://www.wevolt.com/images/continue_reading.jpg</asset>';
	$XML .= '<thumb>http://www.wevolt.com/images/continue_thumb.jpg</thumb>';			
	$XML .= '<url target="_self">http://www.wevolt.com/'.$Content.'/reader/';
	if (($SeriesNum != 1) && ($SeriesNum != ''))
		$XML .= 'series/'.$SeriesNum.'/';
	$XML .= 'episode/'.$EpisodeNum.'/?part='.$Part.'</url>';
	$XML .= '</link>';
	
	
	
	
} else if ($EpisodeNum < $TotalEpisodes) {
	$XML .= '<link>';
	$XML .= '<title>Next Episode</title>';
	$XML .= '<asset>http://www.wevolt.com/images/continue_reading.jpg</asset>';
	$XML .= '<thumb>http://www.wevolt.com/images/continue_thumb.jpg</thumb>';			
	$XML .= '<url target="_self">http://www.wevolt.com/'.$Content.'/reader/';
	if (($SeriesNum != 1) && ($SeriesNum != ''))
		$XML .= 'series/'.$SeriesNum.'/';
	$XML .= 'episode/'.($EpisodeNum+1).'/</url>';
	$XML .= '</link>';
					
}
$XML .= '</data>';
$PrettyXML = formatXmlString($XML);
echo $PrettyXML;

$DB->close();
$DB2->close();
	
	
	
?>


