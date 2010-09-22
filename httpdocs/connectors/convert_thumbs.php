 <? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 $db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $db2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

 $query = "SELECT * from comic_pages where comicid='fe131d7fff'";
 $db->query($query);
 
 while ($Comic = $db->fetchNextObject()) { 
			$SmFileArray = explode('comics/O/Oliver_Peril/images/pages',$Comic->ThumbSm);
			$MdFileArray = explode('comics/O/Oliver_Peril/images/pages',$Comic->ThumbMd);
			$LgFileArray = explode('comics/O/Oliver_Peril/images/pages',$Comic->ThumbLg);
			
			$NewSmall = 'comics/O/Olive_Peril/images/pages'.$SmFileArray[1];
			$NewMed = 'comics/O/Olive_Peril/images/pages'.$MdFileArray[1];
			$NewLarge = 'comics/O/Olive_Peril/images/pages'.$LgFileArray[1];
			$PageID = $Comic->id;
			
			$query = "UPDATE comic_pages SET ThumbSm='$NewSmall', ThumbMd='$NewMed', ThumbLg='$NewLarge' where id='$PageID'";
			$db2->execute($query);
			print $query.'<br/>';
 }

 ?> 