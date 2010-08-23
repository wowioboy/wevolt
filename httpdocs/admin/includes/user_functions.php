<?php 
function Login($userid, $password) {
include 'db.class.php';
$loginDB = new DB();
//$query = "select salt from $usertable where email='$email' limit 1";
//$UserSalt = $loginDB->queryUniqueValue($query);
     // Using the salt, encrypt the given password to see if it
     // matches the one in the database
    // $encrypted_pass = md5(md5($password).$UserSalt);
	
   // $query = "select * from users where email='$email' and password='$encrypted_pass'";
   $query = "select * from users where Userid='$userid' and Password='$password'";
	$user = $loginDB->queryUniqueObject($query);
	$numrows = $loginDB->numRows();
    if ($numrows == 1)
    {
	if ($user['verified'] == 1) {
		$_SESSION['username'] = $user['Userid']; 
		$_SESSION['encrypt_username'] =  md5($user['Userid']);
		$_SESSION['usertype'] = $user['UserType'];
		$_SESSION['userid'] = $user['ID'];
	$msg = 'Logged';
	} else {
	 $msg = 'Not Verified';
	
	}
    }
    else
    {
      $msg = 'Not Logged';
    }
	
	return $msg;

}




function TestLogin($UserID, $password) {
include 'dbconfig.php';
 	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 	mysql_select_db ($userdb) or die ('Could not select database.');
     // Try and get the salt from the database using the username
     $query = "select salt from $usertable where encryptid='$UserID' limit 1";
 print $query;
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     // Using the salt, encrypt the given password to see if it
     // matches the one in the database
	
     $encrypted_pass = md5(md5($password).$user['salt']);
	
    $query = "select encryptid, username, email, avatar, realname,verified from $usertable where encryptid='$UserID' and password='$encrypted_pass'";
	

     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     $numrows = mysql_num_rows($result);
     // Now encrypt the data to be stored in the session
     // Store the data in the session
	
	//print
	
    if ($numrows == 1)
    {
	if ($user['verified'] == 1) {
		$msg = 'Logged';
	} else {
	 $msg = 'Not Verified';
	
	}
    }
    else
    {
      $msg = 'Not Logged';
    }
	
	return $msg;

}



if ($Action == 'logincrypt'){
 	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 	mysql_select_db ($userdb) or die ('Could not select database.');
     // Try and get the salt from the database using the username
     $query = "select salt from $usertable where email='$email' limit 1";
	 //	print $query."<br />";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     // Using the salt, encrypt the given password to see if it
     // matches the one in the database
     $encrypted_pass = md5($password.$user['salt']);

     // Try and get the user using the username & encrypted pass
    $query = "select encryptid, username, email, avatar, realname, verified from $usertable where email='$email' and password='$encrypted_pass'";
	//print $query;
	//print "MY QUESRY = select encryptid, username, email, avatar, realname from $usertable where email='$email' and password='$encrypted_pass'";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     $numrows = mysql_num_rows($result);

     // Now encrypt the data to be stored in the session
     // Store the data in the session
	
    $userid = $user['encryptid'];
	$useremail = $user['email'];
     if ($numrows == 1)
    {
	if ($user['verified'] == 1) {

	echo trim($userid);
	
	} else {
	 echo 'Not Verified';
	
	}
    }
    else
    {
        echo 'Not Logged';
    }

}

if ($Action == 'makecreator'){
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$query = "UPDATE $usertable SET iscreator=1 WHERE encryptid='$ID'";
$result = mysql_query($query);


}

if ($Action == 'get'){
 mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 mysql_select_db ($userdb) or die ('Could not select database.');
// print "MY ACTION = ". $Action."<br>";
 
 if ($item == 'profile'){
 $query = "SELECT * from $usertable where encryptid='$ID'";
 $result = mysql_query($query);
 $user = mysql_fetch_array($result);
 $values = array (
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
echo serialize ($values);


} 

else if ($item == 'email'){
 $query = "select email from $usertable where encryptid='$ID' limit 1";
 print "MY email QUESRY = " . $query ."<br/>";
 $result = mysql_query($query);
 $user = mysql_fetch_array($result);
 echo  $user['email'];
 
} 

else if ($item == 'username'){
 $query = "select username from $usertable where encryptid='$ID' limit 1";
  $result = mysql_query($query);
 $user = mysql_fetch_array($result);
  echo  $user['username'];
  
} 

else if ($item == 'avatar'){
 	$query = "select avatar from $usertable where encryptid='$ID' limit 1";
  	$result = mysql_query($query);
 	$user = mysql_fetch_array($result);
 	echo  $user['avatar'];
} 

else if ($item == 'id'){
 	$query = "select encryptid from $usertable where email='$email' limit 1";
 	 $result = mysql_query($query);
 	$user = mysql_fetch_array($result);
 	echo  $user['encryptid'];
	
} else if ($item == 'profilecomments'){
  	$query = "select comment, commentuser, commentuserid, date from usercomments where userid='$CreatorID' ORDER BY timestamp DESC";
  	$result = mysql_query($query);
  	$nRows = mysql_num_rows($result);
  	$bgcolor = '#FFFFFF';
   $rowcounter = 0;
   for ($i=0; $i< $nRows; $i++){
   		$row = mysql_fetch_array($result);
  		$UserID = $row['commentuserid'];
 		//print "MY USER ID = " .$UserID;
  		 $AvatarQuery = "SELECT avatar from $usertable where encryptid='$UserID'";
		 //print  "MY AVATAR QURY = " . $AvatarQuery."<br/><br/>";
  		 $Aresult = mysql_query($AvatarQuery);
   		 $userAvatar = mysql_fetch_array($Aresult);
		// echo "MY USER AVATAR = " .$userAvatar['avatar'];
  		echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'><tr><td width='50' rowspan='2' valign='top' bgcolor='".$bgcolor."'><img src='".$userAvatar['avatar']."' width='50' height='50' border='1'></td><td height='10' valign='top'style='padding-left:5px;' bgcolor='".$bgcolor."'><div>on <i>".$row['date']."</i></div><b>".$row['commentuser']."</b> said:</td></tr><tr><td valign='top' style='padding:5px;' bgcolor='".$bgcolor."'>".stripslashes($row['comment'])."</td></tr></table><div class='spacer'></div>";

			if ($rowcounter == 0) {
				$bgcolor = '#CCCCCC';
				$rowcounter = 1;
			} else {
				$bgcolor = '#FFFFFF';
				$rowcounter = 0;
			}
	}
  
  } else if ($item == 'pagecomments'){
  $query = "select id, comment, userid, commentdate, creationdate from pagecomments where pageid='$PageID' and comicid='$ComicID' ORDER BY creationdate DESC";
 //print  $query;
  $result = mysql_query($query);
  $nRows = mysql_num_rows($result);
  $bgcolor = '#FFFFFF';
$rowcounter = 0;
 if ($nRows>0) {
   for ($i=0; $i< $nRows; $i++){
   $row = mysql_fetch_array($result);
  $UserID = $row['userid'];
 // print "MY USER ID = " .$UserID;
   $AvatarQuery = "SELECT username, avatar from $usertable where encryptid='$UserID'";
   $Aresult = mysql_query($AvatarQuery);
   $userAvatar = mysql_fetch_array($Aresult);
  echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='50' rowspan='2' valign='top' bgcolor='".$bgcolor."'><img src='".$userAvatar['avatar']."' width='50' height='50' border='1'></td>
    <td height='10' valign='top'style='padding-left:5px;' bgcolor='".$bgcolor."'><div>on <i>".$row['commentdate']."</i></div><b>".$userAvatar['username']."</b> said:</td>
  </tr>
  <tr>
    <td valign='top' style='padding:5px;' bgcolor='".$bgcolor."'>".stripslashes($row['comment'])."</td>
  </tr>
</table><div class='spacer'></div>";

		if ($rowcounter == 0) {
			$bgcolor = '#CCCCCC';
			$rowcounter = 1;
		} else {
			$bgcolor = '#FFFFFF';
			$rowcounter = 0;
		}
  
  	}
	} else {
	echo "No Comments yet. Be the first to Comment!";
	
	}
	}else if ($item == 'admincomments'){
  $query = "select id, comment, userid, commentdate, creationdate from pagecomments where pageid='$PageID' and comicid='$ComicID' ORDER BY creationdate DESC";
 //print  $query;
  $result = mysql_query($query);
  $nRows = mysql_num_rows($result);
  $bgcolor = '#FFFFFF';
$rowcounter = 0;
 if ($nRows>0) {
   for ($i=0; $i< $nRows; $i++){
   $row = mysql_fetch_array($result);
  $UserID = $row['userid'];
 // print "MY USER ID = " .$UserID;
   $AvatarQuery = "SELECT username, avatar from $usertable where encryptid='$UserID'";
   $Aresult = mysql_query($AvatarQuery);
   $userAvatar = mysql_fetch_array($Aresult);
  echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='50' rowspan='2' valign='top' bgcolor='".$bgcolor."'><img src='".$userAvatar['avatar']."' width='50' height='50' border='1'></td>
    <td height='10' valign='top'style='padding-left:5px;' bgcolor='".$bgcolor."'><div>on <i>".$row['commentdate']."</i></div><b>".$userAvatar['username']."</b> said:</td>
  </tr>
  <tr>
    <td valign='top' style='padding:5px;' bgcolor='".$bgcolor."'>".stripslashes($row['comment'])."</td>
  </tr><tr><td><form method='POST' action='index.php?id=".$PageID."'>
	<input type='hidden' name='deletecomment' id='deletecomment' value='1'>
	<input type='hidden' name='commentid' id='commentid' value='".$row['id']."'>
	<input type='hidden' name='id' id='id' value='".$PageID."'>
	<input type='submit' value='DELETE' />
	</form></td></tr>
</table><div class='spacer'></div>";

		if ($rowcounter == 0) {
			$bgcolor = '#CCCCCC';
			$rowcounter = 1;
		} else {
			$bgcolor = '#FFFFFF';
			$rowcounter = 0;
		}
  
  	}
	} else {
	echo "No Comments yet. Be the first to Comment!";
	
	}
	}
   
}

if ($Action == 'avatar'){
 mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 mysql_select_db ($userdb) or die ('Could not select database.');
// print "MY ACTION = ". $Action."<br>";
 $query = "UPDATE $usertable SET avatar='$avatar' WHERE encryptid='$ID'";
 $result = mysql_query($query);
   
}

if ($Action == 'profilecomment'){

 mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 mysql_select_db ($userdb) or die ('Could not select database.');
     // Try and get the salt from the database using the username	 
     $query = "INSERT into usercomments (commentuser, commentuserid, userid, comment, date, site) values ('$CommentUser', '$CUserID','$CreatorID', '$Comment','$CommentDate', '$Site')";
         // Using the salt, encrypt the given password to see if it
     // matches the one in the database
     $result = mysql_query($query) or die ('Could Not Enter Comment');

}

if ($Action == 'pagecomment'){
	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 	mysql_select_db ($userdb) or die ('Could not select database.');
     // Try and get the salt from the database using the username	 
     $query = "INSERT into pagecomments (comicid, pageid, userid, comment, site, commentdate) values ('$ComicID', '$PageID','$ID','$Comment','$Site','$CommentDate')";
     $user = mysql_fetch_array($result);
	 //print $query;
     // Using the salt, encrypt the given password to see if it
     // matches the one in the database
     $result = mysql_query($query) or die ('Could Not Enter Comment');

}

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
     $query = "INSERT into $comicstable (userid, title, genre, url, thumb, cover, createdate, installed) values ('$ID', '$Comictitle','$Genres','$Comicurl','$Thumb','$Cover', '$Date','0')";
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

if ($Action == 'resetpass'){ 
 mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 mysql_select_db ($userdb) or die ('Could not select database.');
 $query = "SELECT username, email, encryptid, salt FROM $usertable WHERE email = '$email' LIMIT 1";
 print "MY PAS QUERY = " .  $query."<br/>";
 $result = mysql_query($query) or die ('Could Find user');
 $nRows = mysql_num_rows($result);
 $user = mysql_fetch_array($result);
 $UserEmail = $user['email'];
 $UserID = $user['encryptid'];
 $Salt = $user['salt'];
 if ($nRows < 1){
 echo 'Not Found';
 } else {
 
  $NewPassword = generatePassword();
//print "MY NEW NON ENCRYPTED PASS = " . $NewPassword;
    $to = $UserEmail;
	$subject = "Your New PANEL FLOW password";
	$body = "Hi, ".$user['username'].", your new Panel Flow Password is: ".$NewPassword."\n\nOnce you log in, please goto the Edit Profile section of your Profile and change your new password to something you will remember. \n\nIf you did not request this password reset, please send an email to : accounts@panelflow.com\n\nCheers! \nThe PF Team";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: Accounts@panelflow.com")) {
	
	//print "MY SALT = " . $Salt;
     // Now encrypt the password using that salt
     $encrypted = md5(md5($NewPassword).$Salt);	
	//print "MY ENCRYUPTED PASS = " . 
  $query = "UPDATE $usertable SET password = '$encrypted' WHERE encryptid='$UserID' and email='$UserEmail'";
 //print "MY PAS QUERY = " .  $query."<br/>";
  $result = mysql_query($query) or die ('Could not Update');
 } else {
  
 }
 
 }

}

function trunc($phrase, $max_words)
{
   $phrase_array = explode(' ',$phrase);
   if(count($phrase_array) > $max_words && $max_words > 0)
      $phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...' ; 
   return $phrase;
}


if ($Action == 'changepass'){ 
    mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
    mysql_select_db ($userdb) or die ('Could not select database.');
    $query = "SELECT username, email, encryptid, salt FROM $usertable WHERE encryptid = '$ID' LIMIT 1";
 //print "MY PASS QUERY = " .  $query."<br/>";
   $result = mysql_query($query) or die ('Could Find user');
   $nRows = mysql_num_rows($result);
   $user = mysql_fetch_array($result);
   $UserEmail = $user['email'];
   $UserID = $user['encryptid'];
  // print "MY USER EMAIL = " .    $UserEmail . "<br/>";
   $Salt = $user['salt'];
  // print "MY NON ENCRYPTED PASS = " . $Newpass."<br/><br/>";
 if ($nRows < 1){
 echo 'Not Found';
 } else {
     $to = $UserEmail;
	$subject = "Your New PANEL FLOW password";
	$body = "Hi, ".$user['username'].", your new Panel Flow Password is: ".$Newpass."\n\n\nIf you did not request this password reset, please send an email to : accounts@panelflow.com\n\nCheers! \nThe PF Team";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: Accounts@panelflow.com")) {
	
	//print "MY SALT = " . $Salt."<br/>";
     // Now encrypt the password using that salt
     $encrypted = md5(md5($Newpass).$Salt);	
	//print "MY ENCRYUPTED PASS = " . $encrypted."<br/>";
  	$query = "UPDATE $usertable SET password = '$encrypted' WHERE encryptid='$UserID' AND email=" .
	      	 "'$UserEmail'";
			 
 // print "MY PASsssss QUERY = " .  $query."<br/>";
  $result = mysql_query($query) or die ('Could not Update');
 } else {
  echo "Mail Not Sent";
 } // End Mail Else
  
 
 
 } // End Password Changed

} // End Change Password Block

if ($Action == 'delete') {

	if ($item == 'pagecomment') {

 		mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
    	mysql_select_db ($userdb) or die ('Could not select database.');
   		$query = "DELETE from pagecomments WHERE id ='$CommentID' and comicid='$ComicID' and " .	
				 "pageid='$PageID'";
			 	
//print "MY PASS QUERY = " .  $query."<br/>";
   		$result = mysql_query($query) or die ('Could Find user');


	} // End Page Comment Block
	
	
	if ($item == 'favorite') {

 		mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
    	mysql_select_db ($userdb) or die ('Could not select database.');
   		
		$query = "DELETE from $favtable WHERE favid='$FavID' and comicid='$ComicID'";
   		
		$result = mysql_query($query) or die ('Could Find user');
        print $query ;

	} // End Favorite Block



} // End Delete Block


if ($Action == 'add') {

	if ($item == 'favorite') {

 		mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
    	mysql_select_db ($userdb) or die ('Could not select database.');
   		
		$query = "INSERT into $favtable (comicid, creatorid, userid)" .  
			 	 "values ('$ComicID', '$CreatorID','$ID')";
   		
		$result = mysql_query($query) or die ('Could Find user');


	} // End Favorite Block


} // End Add Block


if ($Action == 'update') {

	if ($item == 'favorite') {

 		mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
    	mysql_select_db ($userdb) or die ('Could not select database.');
   		
		$query = "INSERT into $favtable (comicid, creatorid, userid)" .  
			 	 "values ('$ComicID', '$CreatorID','$ID')";
   		
		$result = mysql_query($query) or die ('Could Find user');


	} // End Favorite Block


} // End Add Block

function Resend($email){
        include 'dbconfig.php';
 		mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 		mysql_select_db ($userdb) or die ('Could not select database.');
		$Result = mysql_query ("SELECT encryptid, username, verified FROM $usertable WHERE email='$email'");
		$user = mysql_fetch_array($Result);
		if ($user['verified'] == 1) {
		$Msg = 'Verified';
		} else {
		$Msg = SendVerifyEmail($email);
		}
return $Msg;
} // End Add Block


if ($Action == 'comicinstalled') {
	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
    mysql_select_db ($userdb) or die ('Could not select database.');
    $query = "UPDATE $comicstable set installed=1 WHERE comiccrypt ='$ComicID'";
	//print   $query;
	$result = mysql_query($query) or die ('Could Not Enter Comic');
}

?>


