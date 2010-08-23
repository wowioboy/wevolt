<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$Key = $_GET['key'];
$UserID = $_GET['userid'];
$Domain =$_GET['domain'];
$Version = $_GET['version'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$Action = $_GET['action'];

if ($Action == 'add') {
	$query = "SELECT * from Applications where Domain='$Domain' and LicenseID='$Key'";
 	$result = mysql_query($query);
 	$Found = mysql_num_rows($result);
 	if ($Found == 1) {
 		$query = "UPDATE Applications set InstallDate= NOW() where Domain='$Domain' and LicenseID='$Key'";
 		$result = mysql_query($query);
 	} else {
		$query = "INSERT into Applications (UserID, LicenseID, Domain, Version) values ('$UserID','$Key','$Domain','$Version')";
 		$result = mysql_query($query);
	 }
} else if ($Action == 'check') {
	$query = "SELECT * from Applications where Domain='$Domain' and LicenseID='$Key'";
 	$result = mysql_query($query);
 	$Found = mysql_num_rows($result);
	if ($Found == 1) {
 		echo 'Verified';
 	} else {
		echo 'Not Verified';
 	}
} else {
// print "MY ACTION = ". $Action."<br>";
 	$query = "SELECT * from licenses where UserID='$UserID' and LicenseID='$Key'";
 	$result = mysql_query($query);
 	$KeyArray = mysql_fetch_array($result);
 	$num_rows = mysql_num_rows($result);
	if ($num_rows == 0) {
		echo 'Not Verified';
	} else {
		$NumDomains = $KeyArray['DomainsPurchased'];
 		$query = "SELECT * from Applications where UserID='$UserID' and LicenseID='$Key'";
 		$result = mysql_query($query);
 		$ActiveApps = mysql_num_rows($result);
		if ($ActiveApps < $NumDomains) {
			echo 'Verified';
		} else {
			echo 'Exceeded';
	
		}
 	}
}
?>


