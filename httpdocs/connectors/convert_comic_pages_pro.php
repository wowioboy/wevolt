 <? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 $db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 
 $query = "SELECT cp.*,c.HostedUrl
           from comic_pages as cp
		   join comics as c on cp.ComicID=c.comiccrypt
		   where cp.ComicID != '' and cp.EncryptPageID!= '' and cp.ProImage='' order by cp.ComicID";
 $db->query($query);
  while ($Comic = $db->fetchNextObject()) { 
 		
		$CurrentComic = $Comic->ComicID;
    	$query = "UPDATE comic_pages set ProImage='comics/".$Comic->HostedUrl."/images/pages/".$Comic->Image."' where EncryptPageID='".$Comic->EncryptPageID."'";
		$db->execute($query);
		print $query.'<br/>';
		
 /*
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
							$XML .= '<asset>http://www.wevolt.com/comics/'.$ComicDir.'/'.$Content.'/images/pages/'.$Comic->Filename.'</asset>
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
				*/
  }
 ?>