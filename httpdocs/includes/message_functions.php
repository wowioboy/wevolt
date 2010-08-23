<? 

function DeleteMessage($MsgID) {
include 'dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$query = "DELETE from messages where ID ='$MsgID'";
$result = mysql_query($query);
}


function SendMessage($UserID, $SenderName, $SenderID, $Subject, $Message) {
$Time = date('D M j');
include 'dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$query = "INSERT into messages (userid, sendername, senderid, subject, message, date) values ('$UserID','$SenderName','$SenderID','$Subject','$Message','$Time')";
$result = mysql_query($query);

}

?>