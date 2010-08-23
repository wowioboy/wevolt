<? 
include 'includes/dbconfig.php';
include 'processing/checklink.php';
$email = $_GET['email'];
$password = $_GET['pass'];
$Ref = $_GET['ref'];
$Newpass = $_GET['newpass'];
$Action = $_GET['action'];
$username = $_GET['username'];
$realname = $_GET['realname'];
$Site = $_GET['site']; 
$item = $_GET['item'];
$FavID = $_GET['favid'];
$ID = $_GET['id'];
$Version = $_GET['version'];
if ($ID == ""){
$ID = $_GET['userid'];
}
$ComicID = $_GET['comicid'];
$PageID = $_GET['pageid'];
$avatar = $_GET['avatar'];
$CommentUser = $_GET['commentuser'];
$CUserID = $_GET['cuserid'];
$Comment = $_GET['comment'];
$CreatorID = $_GET['creatorid'];
$CommentDate = $_GET['commentdate'];
$CommentID = $_GET['commentid'];
$Gender = $_GET['gender'];
$Overage = $_GET['overage'];
$Birthdate = $_GET['birthdate'];
$Comictitle = $_GET['comictitle'];
$Comicurl = $_GET['comicurl'];
$Genres = $_GET['genres'];
$Notify = $_GET['notify'];
if ($avatar == ""){

if (($Gender == 'm') || ($Gender =='M')) {
$avatar = "http://www.panelflow.com/users/avatars/tempavatar.jpg";
}else if (($Gender == 'f') || ($Gender =='F')) {
$avatar = "http://www.panelflow.com/users/avatars/tempavatarF.jpg";
} else {

$avatar = "http://www.panelflow.com/users/avatars/tempavatar.jpg";
}
}
$RegResult = "";
if ($Action == 'comic'){

 	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 	mysql_select_db ($userdb) or die ('Could not select database.');
	
	$Result = mysql_query ("SELECT url, title FROM $comicstable");

//$qResult = mysql_query ("SELECT * FROM comments ORDER BY id DESC");
$nRows = mysql_num_rows($Result);
//print "THE NUMBER OF ROWS is " . $nRows;
for ($i=0; $i< $nRows; $i++){
	$row = mysql_fetch_array($Result);
	if ($row['title'] == $Comictitle) {
			//echo 'Sorry that email already exists in our database, if you forgot your password please send and email to <a href="mailto:connectme@outlandentertainment.com">connectme@outlandentertainment.com</a>. <br>Otherwise please try again with another email. <a href="register.php">CLICK HERE</a> to try again.';
			$ComicResult = 'Comic Exists';
			//print "MY REGRESULT " .$RegResult."\n\n\n\n\n";
			$i = $nRows;
	} else $ComicResult = 'Clear';
}

//print "THE NUMBER OF ROWS is " . $nRows;
for ($i=0; $i< $nRows; $i++){
	$row = mysql_fetch_array($Result);
	if ($row['url'] == $Comicurl) {
			//echo 'Sorry that email already exists in our database, if you forgot your password please send and email to <a href="mailto:connectme@outlandentertainment.com">connectme@outlandentertainment.com</a>. <br>Otherwise please try again with another email. <a href="register.php">CLICK HERE</a> to try again.';
			$ComicResult = 'Url Exists';
			//print "MY REGRESULT " .$RegResult."\n\n\n\n\n";
			$i = $nRows;
	} else if ($ComicResult != 'Comic Exists') {
	   $ComicResult = 'Clear';
	}
}


$content = checklink($Comicurl."/urltest.php");

//print $Comicurl."/urltest.php";
//print "MY CONTENT = " . $content;
if (trim($content) == 'Not Found')  {
//print "I WENT IN HERE";
	$ComicResult = 'Not Found';
//print "MY COMIC RESULT HERE = ". $ComicResult."<br/>";
} else if (($ComicResult != 'Comic Exists') && ($ComicResult != 'Url Exists')&& ($ComicResult != 'Not Found')) {
  $ComicResult = 'Clear';
}

//print "MY COMIC RESULT = " . $ComicResult."<br/>";

if ($ComicResult == 'Clear') {
     // Try and get the salt from the database using the username	 
	 $Date = date('Y-m-d H:i:s'); 
	 $Thumb = $Comicurl . "/images/comicthumb.jpg";
	 $Cover = $Comicurl . "/images/comiccover.jpg";
     $query = "INSERT into $comicstable (userid, title, genre, url, thumb, cover, createdate, installed, version, CreatorID) values ('$ID', '$Comictitle','$Genres','$Comicurl','$Thumb','$Cover', '$Date','0','$Version','$ID')";
	//print "MY QUERY = INSERT into ".$comicstable." (userid, title, url, createdate) values ('$ID', '$Comictitle','$Comicurl', '$Date')";
	 $result = mysql_query($query) or die ('Could Not Enter Comic');
     // Using the salt, encrypt the given password to see if it
     // matches the one in the database
     $query = "SELECT comicid FROM $comicstable WHERE title = '$Comictitle' AND userid = '$ID' LIMIT 1";
	//print   $query;
	 $result = mysql_query($query) or die ('Could Not Enter Comic');
	 $comic = mysql_fetch_array($result);
	 $ComicID = $comic['comicid'];
	// print "MY COMIC ID = " .$ComicID. "<br/>";
	 $Encryptid = substr(md5($ComicID), 0, 8).dechex($ComicID);
	 $query = "UPDATE $comicstable SET comiccrypt='$Encryptid' WHERE comicid='$ComicID'";
	// print $query;
	 // print "MY QUERY = " . $query;
	  $result = mysql_query($query);
	  $ComicResult = $Encryptid;
	  
} 
 echo $ComicResult;
}



if ($Action == 'checkcomictitle'){
 	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 	mysql_select_db ($userdb) or die ('Could not select database.');
	$Result = mysql_query ("SELECT url, title FROM $comicstable");
//$qResult = mysql_query ("SELECT * FROM comments ORDER BY id DESC");
$nRows = mysql_num_rows($Result);
//print "THE NUMBER OF ROWS is " . $nRows;
for ($i=0; $i< $nRows; $i++){
	$row = mysql_fetch_array($Result);
	if ($row['title'] == $Comictitle) {
			//echo 'Sorry that email already exists in our database, if you forgot your password please send and email to <a href="mailto:connectme@outlandentertainment.com">connectme@outlandentertainment.com</a>. <br>Otherwise please try again with another email. <a href="register.php">CLICK HERE</a> to try again.';
			$ComicResult = 'Comic Exists';
			//print "MY REGRESULT " .$RegResult."\n\n\n\n\n";
			$i = $nRows;
	} else $ComicResult = 'Clear';
}
 echo $ComicResult;
}

if ($Action == 'checkcomicurl'){
 	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 	mysql_select_db ($userdb) or die ('Could not select database.');
	$Result = mysql_query ("SELECT url FROM $comicstable");
//$qResult = mysql_query ("SELECT * FROM comments ORDER BY id DESC");
$nRows = mysql_num_rows($Result);
//print "THE NUMBER OF ROWS is " . $nRows;
for ($i=0; $i< $nRows; $i++){
	$row = mysql_fetch_array($Result);
	if ($row['url'] == $Comicurl) {
			//echo 'Sorry that email already exists in our database, if you forgot your password please send and email to <a href="mailto:connectme@outlandentertainment.com">connectme@outlandentertainment.com</a>. <br>Otherwise please try again with another email. <a href="register.php">CLICK HERE</a> to try again.';
			$ComicResult = 'Url Exists';
			//print "MY REGRESULT " .$RegResult."\n\n\n\n\n";
			$i = $nRows;
	} else if ($ComicResult != 'Comic Exists') {
	   $ComicResult = 'Clear';
	}
}

 echo $ComicResult;
}


if ($Action == 'testcomicurl'){
 $content = checklink($Comicurl."/urltest.php");
// print $Comicurl."/urltest.php";
if (trim($content) == 'Not Found')  {
//print "I WENT IN HERE";
	$ComicResult = 'Not Found';
	} else {
		$ComicResult = 'Found';
	}
 echo $ComicResult;
}
?>