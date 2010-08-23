<? include '../includes/db.class.php';

$DB = new DB();
$DB2 = new DB();
$query = 'SELECT * from users';
$DB->query($query);
while ($user = $DB->FetchNextObject()) {
		$UID = $user->encryptid;
		
		$query = "SELECT * from users_settings where UserID ='$UID'";
	    $DB2->query($query);
		$Found = $DB2->numRows();
		echo $query.'<br/>';
		if ($Found == 0) {
		
		
		$query = "INSERT into users_settings (UserID) values ('$UID')";
	$DB2->execute($query);
		echo $query.'<br/>';
		}
		

}