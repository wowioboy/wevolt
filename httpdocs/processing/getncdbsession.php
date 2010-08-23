<?php 
function randomPrefix($length)
{
$random= "";

srand((double)microtime()*1000000);

$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
$data .= "0FGH45OP89";

for($i = 0; $i < $length; $i++)
{
$random .= substr($data, (rand()%(strlen($data))), 1);
}

return $random;
}

$userhost = 'localhost';
$dbuser = 'outland_need';
$userpass ='need.08';
$userdb = 'outland_need';
$UserID = $_GET['user'];
$SessionID = randomPrefix(15); 
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');

$query = "INSERT into sessionxfer (UserID, SessionID) values ('$UserID', '$SessionID')"; 
 $result = mysql_query($query);
echo '&dbsession='.$SessionID;
?>


