 <? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 $db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $db2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $query = "SELECT * from comic_pages where ComicID = '598b3e711dc' and PageType='pages' order by ComicID, Position ";
 $db->query($query);
 $LastComic = '';
 $InEpisode = 0;
 $LastEpisode == '';
 $EpisodeCount = 0;
 $Position = 0;
 while ($Comic = $db->fetchNextObject()) { 
 		
		 $CurrentComic = $Comic->ComicID;
		  if ($LastComic != $CurrentComic) {
		  		 $query = "SELECT count(*) from comic_pages where Episode = 1 and ComicID='".$Comic->ComicID."'";
				 $TotalEpisodes = $db->queryUniqueValue($query);
		 		print '<br/><br/>-----------Comic = ' . $Comic->ComicID.'-------------<br/>';
				 print 'TOTAL EPISODES = ' . $TotalEpisodes.'<br/>';
				 $Position = 1;
				 if ($TotalEpisodes == 0) {
				 	 $query = "INSERT into Episodes (ProjectID, Title, EpisodeNum, Description, ThumbSm, ThumbMd, ThumbLg) values ('".$Comic->ComicID."','".mysql_real_escape_string($Comic->Title)."','1','".mysql_real_escape_string($Comic->Comment)."','".$Comic->ThumbSm."','".$Comic->ThumbMd."','".$Comic->ThumbLg."')";
				     $db2->execute($query);
					 print $query.'<br/>';
					 $IsEpisode = 1;
				 } else if (($TotalEpisodes == 1) && ($Comic->Episode == 0) && ($Position == 1)){
				 		 $query = "INSERT into Episodes (ProjectID, Title, EpisodeNum, Description, ThumbSm, ThumbMd, ThumbLg) values ('".$Comic->ComicID."','".mysql_real_escape_string($Comic->Title)."','1','".mysql_real_escape_string($Comic->Comment)."','".$Comic->ThumbSm."','".$Comic->ThumbMd."','".$Comic->ThumbLg."')";
				    $db2->execute($query);
					 print $query.'<br/>';
					 $IsEpisode = 1;
				 } else {
				 	$IsEpisode = 0;
				 }
				$LastComic = $CurrentComic;
		 		$EpisodeCount = 0;
		} else {
			$Position++;
		}
		
		 if (($Comic->Episode == 1) || ($IsEpisode == 1)){
		 		
				$EpisodeCount++;
				if ($IsEpisode == 0) {
				 $query = "INSERT into Episodes (ProjectID, Title,EpisodeNum, Description, ThumbSm, ThumbMd, ThumbLg) values ('".$Comic->ComicID."','".mysql_real_escape_string($Comic->Title)."','$EpisodeCount','".mysql_real_escape_string($Comic->Comment)."','".$Comic->ThumbSm."','".$Comic->ThumbMd."','".$Comic->ThumbLg."')";
				  $db2->execute($query);
				   print $query.'<br/>';
				 }
				$IsEpisode = 0;
		 	
			print '<br/>----------START EPISODE '.$EpisodeCount.'-----<br/>';
			
		}
 		print 'Position = ' . $Comic->Position.'<br/>';
		print 'New Position = ' . $Position.'<br/>';
		$query = "UPDATE comic_pages set EpisodeNum='".$EpisodeCount."', Position='$Position' where EncryptPageID='".$Comic->EncryptPageID."'";
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