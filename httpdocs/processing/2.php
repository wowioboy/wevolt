<?php 
$userhost = 'localhost';
$dbuser = 'outland_panel';
$userpass ='pfout.08';
$userdb = 'outland_panel';
$ID = '22';
 mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 mysql_select_db ($userdb) or die ('Could not select database.');
// print "MY ACTION = ". $Action."<br>";
 $query = "SELECT * from users where userid='$ID'";
 $result = mysql_query($query);
 $user = mysql_fetch_array($result);
 
 $users = $user['username'];

//$myValues = array (
 //'username' => $user['username'],
 //'friendly' => 'db1',
 //'user' => 'root',
 //'pass' => 'temp'
//);

//echo serialize ($myValues);

$myValues = array (
 'avatar' => trim($user['avatar']),
'location' => trim($user['location']),
 'username' => trim($user['username']),
 'about' => trim($user['about']),
 'movies' => trim($user['movies']),
 'books' => trim($user['books']),
 'influences' => trim($user['influences']),
 'credits' => trim($user['credits']),
 'hobbies' => trim($user['hobbies']),
 'link1' => trim($user['link1']),
 'link2' => trim($user['link2']),
 'link3' => trim($user['link3']),
 'link4' => trim($user['link4']),
 'website' => 'website'
);
echo serialize ($myValues);

?>


