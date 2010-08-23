<?php 
include '../includes/dbconfig.php';
include 'checklink.php';
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


function generatePassword ($length = 8)
{

  // start with a blank password
  $NewPass = "";

  // define possible characters
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 

    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($NewPass, $char)) { 
      $NewPass .= $char;
      $i++;
    }

  }

  // done!
  return $NewPass;

}



function generate_salt ()
{
     // Declare $salt
     $salt = '';

     // And create it with random chars
     for ($i = 0; $i < 3; $i++)
     {
          $salt .= chr(rand(35, 126));
     }
          return $salt;
}

if ($Action == 'register'){
	srand();
	
//	print "DATABASE HOST = ".$userhost."<br>";
	//print "DATABASE HOST = ".$dbuser."<br>";
	//print "DATABASE HOST = ".$userpass."<br>";
	//print "DATABASE HOST = ".$userdb."<br>";
	//print "DATABASE table = ".$usertable."<br>";
	
 mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 mysql_select_db ($userdb) or die ('Could not select database.');
$Result = mysql_query ("SELECT email FROM $usertable");

//$qResult = mysql_query ("SELECT * FROM comments ORDER BY id DESC");
$nRows = mysql_num_rows($Result);
//print "THE NUMBER OF ROWS is " . $nRows;
for ($i=0; $i< $nRows; $i++){
	$row = mysql_fetch_array($Result);
	if ($row['email'] == $email) {
			//echo 'Sorry that email already exists in our database, if you forgot your password please send and email to <a href="mailto:connectme@outlandentertainment.com">connectme@outlandentertainment.com</a>. <br>Otherwise please try again with another email. <a href="register.php">CLICK HERE</a> to try again.';
			$RegResult = 'Email Exists';
			//print "MY REGRESULT " .$RegResult."\n\n\n\n\n";
			$i = $nRows;
	} else $RegResult = 'Clear';
}


$Result = mysql_query ("SELECT username FROM $usertable");
$nRows = mysql_num_rows($Result);
	for ($i=0; $i< $nRows; $i++){
	$row = mysql_fetch_array($Result);
	if ($row['username'] == $username) {
		 $RegResult = 'User Exists';
	 $i = $nRows;
	} else if ($RegResult != 'Email Exists') {
	//print "MY FUCKING REGRESULT AFTER A CLEAR EMAIL AND USER NAME = " . $RegResult;
	$RegResult = 'Clear';
	};

}
if ($RegResult == 'Clear'){
$time = date('Y-m-d H:i:s'); 
     $salt = generate_salt();
     // Now encrypt the password using that salt
     $encrypted = md5(md5($password).$salt);
     // And lastly, store the information in the database

     $query = "INSERT into $usertable (username, email, password, type, salt, avatar, realname, overage, birthdate, gender, joindate, referral,notify) values ('$username', '$email', '$encrypted', '0', '$salt', '$avatar', '$realname','$Overage','$Birthdate','$Gender','$time', '$Ref','$Notify')";
	 
	// print $query;
	 // print "MY USER =".$username;
	//  print "MY email =".$email;
	 //   print "MY encrypted =".$encrypted;
      mysql_query ($query) or die ('No Good');
	  $query = "SELECT userid FROM $usertable WHERE username='$username' and email ='$email'";
	  $result = mysql_query($query);
	  $user = mysql_fetch_array($result);
	  $ID = $user['userid'];
	  $Encryptid = substr(md5($ID), 0, 8).dechex($ID);
	  $query = "UPDATE $usertable SET encryptid='$Encryptid' WHERE userid='$ID'";
	 // print "MY QUERY = " . $query;
	  $result = mysql_query($query);
	  
   			$chars = "abcdefghijkmnopqrstuvwxyz023456789ABCDEFGHIJKLMNOPQRSTUV";

    		srand((double)microtime()*1000000);

    		$i = 0;

    		$authode = '' ;



   		 while ($i <= 11) {

        $num = rand() % 33;

        $tmp = substr($chars, $num, 1);

        $authode = $authode . $tmp;

        $i++;
		}

  $query = "UPDATE $usertable SET authcode ='$authode' WHERE userid='$ID'";
	 // print "MY QUERY = " . $query;
  mysql_query($query);

// setup the forum account
  $query = "INSERT into panel_forum.smfmembers (memberName, dateRegistered, posts, ID_GROUP, lngfile, lastLogin, realname, instantMessages,  unreadMessages,  buddy_list,  pm_ignore_list,  messageLabels,  passwd,  emailAddress,  personalText,  gender,  birthdate,  websiteTitle,  websiteUrl,  location,  ICQ,  AIM,  YIM,  MSN,  hideEmail,  showOnline,  timeFormat,  signature,  timeOffset,  avatar,  pm_email_notify,  karmaBad,  karmaGood,  usertitle,  notifyAnnouncements,  notifyOnce, notifySendBody,  notifyTypes,  memberIP,  memberIP2,  secretQuestion,  secretAnswer,  ID_THEME,  is_activated,  validation_code,  ID_MSG_LAST_VISIT,  additionalGroups,  smileySet,  ID_POST_GROUP,  totalTimeLoggedIn,  passwordSalt)   values ('$username', '$time', 0, 0, '', '$time', '$realname', 0, 0, '', '', '', '$encrypted','$email', '', 0, '0001-01-01', '', '', '', '', '', '', '', 1, 1, '', '', 0, '$avatar', 1, 0,0, '', 1, 1, 0, 2, '', '', '', '', 0, 1, '', 1, '','', 4, 0, '$salt')";
	 //print "MY QUERY = " . $query;
  mysql_query ($query);
  $query = "SELECT ID_MEMBER FROM panel_forum.smfmembers  WHERE memberName='$username' and emailAddress ='$email'";
  $result = mysql_query($query);
  $user = mysql_fetch_array($result);
  $ForumID = $user['ID_MEMBER'];

  $query = "INSERT into panel_forum.smfmembers_panelusers (userid, ID_MEMBER) VALUES('$ID', '$ForumID')";
  mysql_query ($query);
  
	$header = "From: NO-REPLY@panelflow.com  <NO-REPLY@panelflow.com >\n";
	$header .= "Reply-To: NO-REPLY@panelflow.com <NO-REPLY@panelflow.com>\n";
	$header .= "X-Mailer: PHP/" . phpversion() . "\n";
	$header .= "X-Priority: 1";
	
//Send Account Email
	$to = $email;
	$subject = "Your new PANEL FLOW User Account";
	$body = "Hi, ".$username.", thank you for registering with Panel Flow. We hope you enjoy your  experience.\n\nFor your records your login information is as follows, you will use your EMAIL ACCOUNT to login in on all Panel Flow Comic sites.\n\nUSERNAME: ".$username."\nEMAIL: ".$email."\nPASSWORD: ".$password."\n\nIf you have any questions feel free to contact us at : info@panelflow.com \n\nCheers! \nThe PF Team";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, $header)) {
  
 } else {
  
 }
 
     $to = 'info@panelflow.com';
	 $copy = 'theunlisted@gmail.com';
	$subject = "A new user has registered for an account";
	$body = "Hi, ".$username.", at ".$email." has registered for a new account";
	$body .= "\n\n---------------------------\n";
   mail($to, $subject, $body, $header);
    mail($copy, $subject, $body, $header);
	
	

 //Send Verification Email
	$to = $email;
	$subject = "PANEL FLOW Account Verification";
	$body = "Hi, ".$username.", please click the following link to complete your account verification.\n\nAfter your account is verified you can leave comments on comics and create your own.\n\nVERIFICATION LINK : http://www.panelflow.com/verifyaccount.php?id=".$Encryptid."&authcode=".trim($authode)."\n\nIf clicking on the link does not work, copy the link and paste it into your browser. \n\nCheers! \nThe PF Team";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, $header)) {
 } else {
  
 }
 
 
} 

echo $RegResult;
	
}

if ($Action == 'login'){
 	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 	mysql_select_db ($userdb) or die ('Could not select database.');
     // Try and get the salt from the database using the username
     $query = "select salt from $usertable where email='$email' limit 1";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     // Using the salt, encrypt the given password to see if it
     // matches the one in the database
     $encrypted_pass = md5(md5($password).$user['salt']);
	 
	 //print "MY PASSWORD = " . $password ."<br/>";

     // Try and get the user using the username & encrypted pass
    $query = "select encryptid, username, email, avatar, realname,verified from $usertable where email='$email' and password='$encrypted_pass'";
	//print $query;
	
	
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     $numrows = mysql_num_rows($result);

     // Now encrypt the data to be stored in the session
     // Store the data in the session
	
    $userid = $user['encryptid'];
	$useremail = $user['email'];
	
	//print
	
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
if ($email == '') {
$query = "UPDATE $usertable SET iscreator=1 WHERE encryptid='$ID'";
} else {
$query = "UPDATE $usertable SET iscreator=1 WHERE email='$email'";
}

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
// print "MY email QUESRY = " . $query ."<br/>";
 $result = mysql_query($query);
 $user = mysql_fetch_array($result);
 echo  $user['email'];
 
} 

else if ($item == 'username'){
if ($email == '') {
 $query = "select username from $usertable where encryptid='$ID' limit 1";
} else {
 $query = "select username from $usertable where email='$email' limit 1";
}
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
	} else if ($item == 'admincomments'){
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
  echo "<form method='POST' action='index.php?id=".$PageID."'>
  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='50' rowspan='2' valign='top' bgcolor='".$bgcolor."'><input type='image' src='../images/delete.jpg' style='border:none;' value='DELETE' /><br />
<img src='".$userAvatar['avatar']."' width='50' height='50' border='1'></td>
    <td height='10' valign='top'style='padding-left:5px;' bgcolor='".$bgcolor."'><div>on <i>".$row['commentdate']."</i></div><b>".$userAvatar['username']."</b> said:</td>
  </tr>
  <tr>
    <td valign='top' style='padding:5px;' bgcolor='".$bgcolor."'>".stripslashes($row['comment'])."</td>
  </tr><tr><td valign='top'>
  
	<input type='hidden' name='deletecomment' id='deletecomment' value='1'>
	<input type='hidden' name='commentid' id='commentid' value='".$row['id']."'>
	<input type='hidden' name='id' id='id' value='".$PageID."'>
	
	</td></tr>
</table></form><div class='spacer'></div>";

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
	} else if ($item == 'adminprofilecomments'){
 $query = "select comment, commentuser, commentuserid, date from usercomments where userid='$CreatorID' ORDER BY timestamp DESC";
 //print  $query;
  $result = mysql_query($query);
  $nRows = mysql_num_rows($result);
  $bgcolor = '#FFFFFF';
$rowcounter = 0;
 if ($nRows>0) {
   for ($i=0; $i< $nRows; $i++){
   $row = mysql_fetch_array($result);
   	$UserID = $row['commentuserid'];
 		//print "MY USER ID = " .$UserID;
  	$AvatarQuery = "SELECT avatar from $usertable where encryptid='$UserID'";
 // print "MY USER ID = " .$UserID;
   $Aresult = mysql_query($AvatarQuery);
   $userAvatar = mysql_fetch_array($Aresult);
  echo "<form method='POST' action='index.php?id=".$PageID."'>
  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='50' rowspan='2' valign='top' bgcolor='".$bgcolor."'><input type='image' src='../images/delete.jpg' style='border:none;' value='DELETE' /><br />
<img src='".$userAvatar['avatar']."' width='50' height='50' border='1'></td>
    <td height='10' valign='top'style='padding-left:5px;' bgcolor='".$bgcolor."'><div>on <i>".$row['commentdate']."</i></div><b>".$userAvatar['username']."</b> said:</td>
  </tr>
  <tr>
    <td valign='top' style='padding:5px;' bgcolor='".$bgcolor."'>".stripslashes($row['comment'])."</td>
  </tr><tr><td valign='top'>
  
	<input type='hidden' name='deletecomment' id='deletecomment' value='1'>
	<input type='hidden' name='commentid' id='commentid' value='".$row['id']."'>
	</td></tr>
</table></form><div class='spacer'></div>";

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
 if (substr($avatar,0,7) != 'http://') {
 $avatar = 'http://'.$avatar;
 }
// print "MY ACTION = ". $Action."<br>";
if (isset($_GET['email'])) {
	$Email = $_GET['email'];
 	$query = "UPDATE $usertable SET avatar='$avatar' WHERE email='$Email'";
} else {
 	$query = "UPDATE $usertable SET avatar='$avatar' WHERE encryptid='$ID'";
}
print $query;
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

$Comicurl = 'http://'.$Comicurl;
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
$Comicurl = 'http://'.$Comicurl;
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
$Comicurl = 'http://'.$Comicurl;
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


if ($Action == 'resetpass'){ 
 mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 mysql_select_db ($userdb) or die ('Could not select database.');
 $query = "SELECT username, email, encryptid, salt FROM $usertable WHERE email = '$email' LIMIT 1";

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
	$subject = "Your New WEvolt password";
	$body = "Hi, ".$user['username'].", your new WEvolt is: ".$NewPassword."\n\nOnce you log in, please goto the SETTINGS section of your MYvolt and change your new password to something you will remember. \n\nIf you did not request this password reset, please send an email to : NO-REPLY@wevolt.com\n\nCheers! \nThe WEvolt Team";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: NO-REPLY@wevolt.com")) {
	
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
   $Newpass = $_GET['n'];
  // print "MY USER EMAIL = " .    $UserEmail . "<br/>";
   $Salt = $user['salt'];
  // print "MY NON ENCRYPTED PASS = " . $Newpass."<br/><br/>";
 if ($nRows < 1){
 echo 'Not Found';
 } else {
     $to = $UserEmail;
	$subject = "Your new WEvolt password";
	$body = "Hi, ".$user['username'].", your new WEvolt Password is: ".$Newpass."\n\n\nIf you did not request this password reset, please send an email to : listenup@wevolt.com\n\nCheers! \nThe WEvolt Team";
	$body .= "\n\n---------------------------\n";
    if (mail($to, $subject, $body, "From: NO-REPLY@wevolt.com")) {
	
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
       // print $query ;

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


if ($Action == 'resend') {
 		mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 		mysql_select_db ($userdb) or die ('Could not select database.');
		$Result = mysql_query ("SELECT encryptid, username,verified FROM $usertable WHERE email='$email'");
		$user = mysql_fetch_array($Result);
		
		if ($user['verified'] != 1) {
			$ID = $user['encryptid'];
			$Username =  $user['username'];
			$chars = "abcdefghijkmnopqrstuvwxyz023456789ABCDEFGHIJKLMNOPQRSTUV";
			srand((double)microtime()*1000000);
			$i = 0;
			$authode = '';
				while ($i <= 11) {

       					$num = rand() % 33;

        				$tmp = substr($chars, $num, 1);

        				$authode = $authode . $tmp;

        				$i++;
				}

			$query = "UPDATE $usertable SET authcode ='$authode' WHERE encryptid='$ID'";
	 // print "MY QUERY = " . $query;
  			$result = mysql_query($query);
	  
//Send Account Email

 //Send Verification Email
			$to = $email;
			$subject = "PANEL FLOW Account Verification";
			$body = "Hi, ".$Username.", please click the following link to complete your account verification.\n\nAfter your account is verified you can leave comments on comics and create your own.\n\nVERIFICATION LINK : http://www.panelflow.com/verifyaccount.php?id=".$ID."&authcode=".trim($authode)."\n\nIf clicking on the link does not work, copy the link and paste it into your browser. \n\n\Cheers! \nThe OE Team";
			$body .= "\n\n---------------------------\n";
    			if (mail($to, $subject, $body, "From: NO-REPLY@panelflow.com")) {
	
					echo 'Sent';
  
 				} else {
 
 					echo 'Not Sent';
  
 				}
				
	} else {
	
	echo 'Verified';
	
	}

} // End Add Block


if ($Action == 'comicinstalled') {
	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
    mysql_select_db ($userdb) or die ('Could not select database.');
    $query = "UPDATE $comicstable set installed=1 WHERE comiccrypt ='$ComicID'";
	//print   $query;
	$result = mysql_query($query) or die ('Could Not Enter Comic');
}

?>


