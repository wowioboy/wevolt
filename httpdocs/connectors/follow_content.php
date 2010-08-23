<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php');
header( 'Content-Type: text/javascript' );
$query ="SELECT count(*) from follows where follow_id='".$_GET['fid']."' and user_id='".$_SESSION['userid']."'";
					$Found = $InitDB->queryUniqueValue($query);
					if ($Found == 0) {
						$query = "INSERT into follows (user_id, follow_id, type, follow_date) values ('".$_SESSION['userid']."','".$_GET['fid']."','".$_GET['type']."',NOW())"; 
						$InitDB->execute($query);
					}
$InitDB->close();
	
?>
alert('You are now a fan');
