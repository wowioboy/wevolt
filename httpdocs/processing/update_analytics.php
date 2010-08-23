<?php 
include '../includes/db.class.php';
$DB = new DB();
$query = "SELECT * from analytics";
$DB->query($query);
print $query .'<br/>';
while ($Comic = $DB->FetchNextObject()) {
	$ID = $Comic->ID;
	$Date = $Comic->date;
	$AnalyticDate = substr($Date,0,4).'-'.substr($Date,4,2).'-'.substr($Date,6,2).' 00:00:00';
	
	$DB2 = new DB();
	$query ="UPDATE analytics set AnalyticDate = '$AnalyticDate' where ID='$ID'";
	$DB2->execute($query);
	print $query .'<br/>';
		

	
}
$DB->close();
$DB2->close();
?>


