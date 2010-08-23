<?php 
set_time_limit(0);
include '../includes/db.class.php';
$DB = new DB();
$query = "SELECT * from viewsbreakdown where AnalyticDate='0000-00-00 00:00:00'";
$DB->query($query);
print $query .'<br/>';
while ($Comic = $DB->FetchNextObject()) {
	$ID = $Comic->ID;
	$Date = $Comic->date;
	$AnalyticDate = substr($Date,6,4).'-'.substr($Date,0,2).'-'.substr($Date,3,2).' 00:00:00';
	$RealDate = substr($Date,6,4).substr($Date,0,2).substr($Date,3,2);
	$DB2 = new DB();
	$query ="UPDATE viewsbreakdown set date='$RealDate', AnalyticDate = '$AnalyticDate' where ID='$ID'";
	$DB2->execute($query);
	print $query .'<br/>';
		
}

$DB->close();
$DB2->close();
?>


