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
$myValues = array (
 'avatar' => trim($user['avatar']),
'location' => trim($user['location']),
 'username' => trim($user['username']),
  'realname' => trim($user['realname']),
 'about' => trim($user['about']),
 'music' => trim($user['music']),
 'books' => trim($user['books']),
 'influences' => trim($user['influences']),
 'credits' => trim($user['credits']),
 'hobbies' => trim($user['hobbies']),
 'link1' => trim($user['link1']),
 'link2' => trim($user['link2']),
 'link3' => trim($user['link3']),
 'link4' => trim($user['link4']),
 'website' => trim($user['website'])
);
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


