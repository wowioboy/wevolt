 <? 
 include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
 include_once(INCLUDES.'/db.class.php');
 $db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $db2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
 $db3 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$query = "SELECT * from users";
	 $db->query($query);
	 print $query.'<br/>';
	
	 while ($line = $db->fetchNextObject()) {
		   $UserID = $line->encryptid;
			$query = "SELECT * from friends where FriendID='$UserID' and friendtype='friend'";
			print $query.'<br/>';
			$db2->query($query);
			while ($user = $db2->fetchNextObject()) {
					$query = "SELECT count(*) from friends where UserID='$UserID' and FriendID='".$user->UserID."' and friendtype='friend'";
					$Found = $db3->queryUniqueValue($query);
					print $query.'<br/>';
					if ($Found ==0) {
						$query = "INSERT into friends (UserID, FriendID, Accepted, FriendType) values ('$UserID', '".$user->UserID."', 1, 'friend')";	
						 $db3->execute($query);
					}
					print $query.'<br/>';
			}
	}
 ?>