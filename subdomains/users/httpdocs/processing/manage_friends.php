<?php 
header( 'Content-Type: text/javascript' );
$NoTrack = 1;
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';

$DB = new DB();

$UserID = $_GET['userid'];
$TargetID = $_GET['targetid'];
$Orig = $_GET['orig'];
$Target = $_GET['new'];
//print_r($_GET);
//print_r($_SESSION);
if (($_SESSION['userid'] != '') && ($UserID == $_SESSION['userid'])) {

	$Auth = 1;
		//alert('CurrentDiv DIV ' + this.CurrentDiv);
		//alert('ORIGINAL DIV ' + this.OriginalDiv);
		if (($Orig == 'friends') && ($Target == 'celebs')) {
			$Auth = 0;
			//alert('friends Not allowed to be celebs' );
		}
		if (($Orig == 'fans') && ($Target == 'celebs')) {
		$Auth = 0;
			//alert('Fans Are Not allowed to be celebs' );
		}
		if (($Orig== 'celebs') && ($Target == 'fans')) {
			$Auth = 0;
			//alert('celebs Not allowed to be fans' );
		}
		if (($Orig == 'fans') && ($Target == 'w3vers')) {
			$Auth = 0;
			//alert('fans Not allowed to be w3vers' );
		}
		if (($Orig == 'w3vers') && ($Target== 'fans')) {
			$Auth = 0;
			//alert('w3vers Not allowed to be fans' );
		}
		//print 'AUTH = ' .$Auth.'<br/>';
		if ($Auth == 1) {
				$query ="SELECT * from friends where UserID='$UserID' and FriendID='$TargetID'";
				$UserArray = $DB->queryUniqueObject($query);
			//	print $query.'<br/>';
				if ($UserArray->ID == '') {
					$query ="SELECT * from friends where UserID='$TargetID' and FriendID='$UserID'";
					$UserArray = $DB->queryUniqueObject($query);
				}
				$FriendRowID = $UserArray->ID;
				if ($Target == 'fans')
					$query ="UPDATE friends set FriendType='fan' where ID='$FriendRowID'";
				if (($Target == 'friends') && ($Orig != 'w3vers'))	
					$query ="UPDATE friends set FriendType='friend' where ID='$FriendRowID'";
				if ($Target == 'w3vers')
					$query ="UPDATE friends set IsW3viewer='1' where ID='$FriendRowID'";
				if (($Target == 'frieds') && ($Orig == 'w3vers'))	
					$query ="UPDATE friends set IsW3viewer='0' where ID='$FriendRowID'";
					
				$DB->execute($query);
				
			//	print $query.'<br/>';
		}
	
}
$DB->close();
?>
