<? 
include 'includes/init.php';
include 'includes/dbconfig.php'
include 'includes/message_functions.php';
$RequestID = $_POST['requestid'];
$friendDB = new DB($userdb,$userhost, $dbuser, $userpass);
$query ="SELECT * from friends where ID = '$RequestID'";
$RequestArray = $friendDB->queryUniqueObject($query);
if ($_SESSION['userid'] == $RequestArray->FriendID) {
 $query ="UPDATE  friends set Accepted = 1 where ID='$RequestID'";
  $friendDB->query($query);
  $Subject = 'Friend Request Approval';
  $Message = '<a href="profile.php?id='.$_SESSION['userid'].'">'.$_SESSION['username'] .'</a> has accepted your friend request.';
  SendMessage($RequestArray->UserID, $_SESSION['username'], $_SESSION['userid'], $Subject, $Message);
  $friendDB->close();

}
?>