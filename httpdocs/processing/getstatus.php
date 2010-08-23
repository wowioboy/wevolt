<?php 
$userhost = 'localhost';
$dbuser = 'panel_panel';
$userpass ='pfout.08';
$userdb = 'panel_panel';
$Email = $_GET['email'];
$Username = $_GET['username'];
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
// print "MY ACTION = ". $Action."<br>";
if ($Username != '' ) {
 $query = "SELECT * from users where username='$Username' and verified=1";
} else if ($Email != '') {
 $query = "SELECT * from users where email='$Email' and verified=1";
}

 $result = mysql_query($query);
 $user = mysql_fetch_array($result);
 $num_rows = mysql_num_rows($result);
if ($num_rows == 0) {
	echo 'no';
} else {
$myValues = array ('Status' => trim($user['Status']));
echo serialize ($myValues);
}
//$myValues = array (
 //'username' => $user['username'],
 //'friendly' => 'db1',
 //'user' => 'root',
 //'pass' => 'temp'
//);

//echo serialize ($myValues);



?>


