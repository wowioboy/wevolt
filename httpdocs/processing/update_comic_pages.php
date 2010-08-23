<?php 
include '../includes/db.class.php';
$DB = new DB();
 $query = "SELECT * from comics";
$DB->query($query);

while ($Comic = $DB->FetchNextObject()) {
	$ComicID = $Comic->comiccrypt;
	$ComicName = $Comic->title;
	print 'COMIC = '.$ComicName.'<br/>'; 
	$DB2 = new DB();
	$query = "SELECT * from comic_pages where ComicID='$ComicID' and PageType='pages'";
	$DB2->query($query);
	while ($Page = $DB2->FetchNextObject()) {
		$Datelive = $Page->Datelive;
		$PageID = $Page->EncryptPageID;
		$PublishDate = substr($Datelive,6,4).'-'. substr($Datelive,0,2).'-'. substr($Datelive,3,2).' 00:00:00';
		$query ="UPDATE comic_pages set PublishDate='$PublishDate' where EncryptPageID='$PageID'";
		$DB2->execute($query);
		print $query.'<br/>';
		$query ="UPDATE panel_need.comic_pages set PublishDate='$PublishDate' where EncryptPageID='$PageID'";
		$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}
	$query = "SELECT * from comic_pages where ComicID='$ComicID' and PageType='extras'";
	$DB2->query($query);
	while ($Page = $DB2->FetchNextObject()) {
		$Datelive = $Page->Datelive;
		$PageID = $Page->EncryptPageID;
		$PublishDate = substr($Datelive,6,4).'-'. substr($Datelive,0,2).'-'. substr($Datelive,3,2).' 00:00:00';
		$query ="UPDATE comic_pages set PublishDate='$PublishDate' where EncryptPageID='$PageID'";
		$DB2->execute($query);
		print $query.'<br/>';
		$query ="UPDATE panel_need.comic_pages set PublishDate='$PublishDate' where EncryptPageID='$PageID'";
		$DB2->execute($query);
		print $query.'<br/><br/>';
	
	
	}
	print '<br/><br/>';
	
}
$DB->close();
$DB2->close();
?>


