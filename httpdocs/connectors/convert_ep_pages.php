 <? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 $db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $db2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $query = "SELECT cp.* from comic_pages as cp
 where PageType='pages' and comicid='598b3e711dc' order by ID,EpisodeNum";
 $db->query($query);
 $LastComic = '';
 $InEpisode = 0;
 $LastEpisode = '';
 $EpisodeCount = 0;
 $Position = 1;
 $EpPosition = 1;
 while ($Comic = $db->fetchNextObject()) {  
		 $CurrentComic = $Comic->ComicID;
		 if ($CurrentComic != $LastComic) {
			 print 'Comic = ' .$Comic->Title. '<br/>';
		 	$LastComic = $CurrentComic;
			$NewComic = true;
		 } else {
			$NewComic = false; 
		 } 
		 $CurrentEpisode = $Comic->EpisodeNum;
		
		if (($CurrentEpisode != $LastEpisode) || ($NewComic == true))  {
			  print 'Current EP = ' .$CurrentEpisode. '<br/>';
			$EpPosition = 1;	
			$LastEpisode = $CurrentEpisode;
		}
		$query = "UPDATE comic_pages set EpPosition='$EpPosition', Position='$Position' where EncryptPageID='".$Comic->EncryptPageID."' and ComicID='$CurrentComic'";
		$db2->execute($query);
		print $query.'<br/>';
		$EpPosition++;
		$Position++;
		
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