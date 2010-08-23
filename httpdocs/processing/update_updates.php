<? include '../includes/db.class.php';

$DB = new DB();
$DB2 = new DB();
$query = 'SELECT * from updates';
$DB->query($query);
while ($update = $DB->FetchNextObject()) {
		$Udate = date('Y-m-d',strtotime($update->CreatedDate));
		$UID = $update->ID;
		
		$query = "UPDATE updates set UpdateDate = '$Udate' where ID='$UID'";
	$DB->execute($query);
		echo $query.'<br/>';
		
		

}