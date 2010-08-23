<?php 
include '/var/www/vhosts/panelflow.com/httpdocs/includes/db.class.php';
$DB = new DB();
$query = "SELECT distinct Email,avatar from panel_need.creators";
$DB->query($query);
print $query .'<br/>';
while ($Comic = $DB->FetchNextObject()) {
	$Email = $Comic->Email;
	$Avatar = $Comic->avatar;
	
	$DB2 = new DB();
	$query ="SELECT * from users where email='$Email'";
	$UserArray = $DB2->queryUniqueObject($query);
	print $query .'<br/>';
	$CurrentAvatar = $UserArray->avatar;
	print 'NEED AVATOR = ' . $Avatar.'<br/>';
	print 'PF AVATOR = ' . $CurrentAvatar.'<br/>';
	if (($Avatar != $CurrentAvatar) && ($CurrentAvatar!='')) {
		$query ="UPDATE panel_need.creators set avatar='$CurrentAvatar' where email='$Email'";
		$DB2->execute($query);
		print $query .'<br/><br/>';
	}	
}
$DB->close();
$DB2->close();
?>


