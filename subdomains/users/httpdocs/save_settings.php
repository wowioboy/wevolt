<? 
include_once ('includes/init.php');
if ($_POST['editaccount'] == 1){
 $d = new DB();
	$Notify = $_POST['notify'];
	$Comments = $_POST['profilecomments'];
	$ReaderStyle = $_POST['txtReaderStyle'];
	$FlashPages = $_POST['txtFlashPages'];
	$ToolTips = $_POST['tooltips'];
	
	$Welcome = $_POST['txtWelcome'];
	$WorkForHire = $_POST['txtWorkForHire'];
	$MainService = $_POST['txtMainService'];
	$Rates = mysql_real_escape_string($_POST['txtRates']);
	$OtherServices = mysql_real_escape_string($_POST['txtOtherServices']);
	$IsStudio = $_POST['txtIsStudio'];

	
	$query = "UPDATE users_settings SET NotifySystemUpdates='$Notify',ToolTips='$ToolTips',AllowComments='$Comments',ReaderStyle='$ReaderStyle', FlashPages='$FlashPages', ShowWelcome='$Welcome' WHERE UserID='".$_SESSION['userid']."'";
	$d->execute($query);
	
	$query = "SELECT count(*) from users_data where UserID='".$_SESSION['userid']."'";
	$Found = $d->queryUniqueValue($query);
	if ($Found == 0) {
		$query ="INSERT into users_data (UserID, MainService, WorkForHire, Rates, OtherServices, IsStudio) values ('".$_SESSION['userid']."', '$MainService', '$WorkForHire', '$Rates', '$OtherServices', '$IsStudio')";
		$d->execute($query);

	} else {
		$query = "UPDATE users_data SET MainService='$MainService',WorkForHire='$WorkForHire',Rates='$Rates',OtherServices='$OtherServices', IsStudio='$IsStudio' WHERE UserID='".$_SESSION['userid']."'";
		$d->execute($query);
	
	}

$d->close();
header("Location:http://users.wevolt.com/myvolt/".$_SESSION['username']."/");
}
?>
