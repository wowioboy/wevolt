 <? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 $db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $SeriesNum=1;
 $ComicID='0584ce56180';
$query = "SELECT * from comic_pages where ComicID='$ComicID' and PageType='pages' and SeriesNum='$SeriesNum' order by SeriesNum, EpisodeNum, EpPosition";
	 $db->query($query);
	 print $query.'<br/>';
	 $ResetPos = 1;
	 while ($line = $db->fetchNextObject()) {
		   $SPageID = $line->EncryptPageID;
			$query = "update comic_pages set Position='$ResetPos' where ComicID='$ComicID' and EncryptPageID='$SPageID' and SeriesNum='$SeriesNum'";
			$db->execute($query);
			print $query.'<br/>';
			$ResetPos++;
	}
 ?>