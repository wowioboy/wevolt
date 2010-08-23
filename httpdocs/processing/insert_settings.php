<?php 
include '../includes/db.class.php';
$DB = new DB();
 $query = "SELECT * from comics";
$DB->query($query);
while ($Comic = $DB->FetchNextObject()) {
	$ComicID = $Comic->comiccrypt;
	$ComicName = $Comic->title;
	
	$DB2 = new DB();
	$query ="SELECT * from comic_settings where ComicID ='$ComicID'";
	$DB2->query($query);
	$Found = $DB2->numRows();
	if ($Found == 0) {
	print 'COMIC = ' . $ComicName.'<br/>';
		$query = "INSERT INTO comic_settings (ComicID) values ('$ComicID')";
	$DB2->execute($query);
	print $query.'<br/>';
	
	
	}
	
}
$DB->close();
$DB2->close();
?>


