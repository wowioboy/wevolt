<?php 
include '../includes/db.class.php';
$DB = new DB();
 $query = "SELECT * from comics";
$DB->query($query);
while ($Comic = $DB->FetchNextObject()) {
	$ComicID = $Comic->comiccrypt;
	$DB2 = new DB();
	$ComicName = $Comic->title;
	print 'COMIC = ' . $ComicName.'<br/>';

	$query ="SELECT count(*) from pf_modules where ModuleCode='custommod' and ComicID='$ComicID' and Homepage='0'";
	$Found = $DB2->queryUniqueValue($query);
	if ($Found == 0) {
	$query = "INSERT INTO pf_modules (Title, ModuleCode, ComicID, Position, Placement, IsPublished) VALUES ('Custom', 'custommod', '$ComicID', 16, 'left',0)";
		$DB2->execute($query);
		print $query.'<br/>';
	}
	$query ="SELECT count(*) from panel_need.pf_modules where ModuleCode='custommod' and ComicID='$ComicID' and Homepage='0'";
	$Found = $DB2->queryUniqueValue($query);
	if ($Found == 0) {
		$query = "INSERT INTO panel_need.pf_modules (Title, ModuleCode, ComicID, Position, Placement, IsPublished) VALUES ('Custom', 'custommod', '$ComicID', 16, 'left',0)";
		$DB2->execute($query);
		print $query.'<br/>';
		
		print '<br/>';
	}
	/*
	$query ="SELECT count(*) from pf_modules where ModuleCode='menutwo' and ComicID='$ComicID' and Homepage='0'";
	$Found = $DB2->queryUniqueValue($query);
	if ($Found == 0) {
	$query = "INSERT INTO pf_modules (Title, ModuleCode, ComicID, Position, Placement, IsPublished) VALUES ('Menu Two', 'menutwo', '$ComicID', 14, 'left',0)";
		$DB2->execute($query);
		print $query.'<br/>';
	}
	$query ="SELECT count(*) from panel_need.pf_modules where ModuleCode='menuone' and ComicID='$ComicID' and Homepage='0'";
	$Found = $DB2->queryUniqueValue($query);
	if ($Found == 0) {
		$query = "INSERT INTO panel_need.pf_modules (Title, ModuleCode, ComicID, Position, Placement, IsPublished) VALUES ('Menu Two', 'menutwo', '$ComicID', 14, 'left',0)";
		$DB2->execute($query);
		print $query.'<br/>';
	}
*/
}
$DB->close();
$DB2->close();
?>


