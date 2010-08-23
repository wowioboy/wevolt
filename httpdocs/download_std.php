<? include 'includes/init.php';?>
<? include 'includes/dbconfig.php'; 
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$Remote = $_SERVER['REMOTE_ADDR'];
$UserID = $_SESSION['userid'];
$query = "INSERT into downloads (ipaddress, userid, version) values ('$Remote', '$UserID', '$Version')";
mysql_query ($query) or die ('No Good');
header("Location:/getdownload.php");
?>