<? function LoginCrypt($email, $password, $userhost, $dbuser, $userpass, $userdb){

 	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 	mysql_select_db ($userdb) or die ('Could not select database.');
     // Try and get the salt from the database using the username
     $query = "select salt from users where email='$email' limit 1";
	// 	print $query."<br />";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
	// print "MY SALT = " . $user['salt'];
     // Using the salt, encrypt the given password to see if it
     // matches the one in the database
     $encrypted_pass = md5($password.$user['salt']);

     // Try and get the user using the username & encrypted pass
    $query = "select * from users where email='$email' and password='$encrypted_pass'";
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

	$ReturnValue =  trim($userid);
	
	} else {
	 $ReturnValue = 'Not Verified';
	
	}
    }
    else
    {
        $ReturnValue = 'Not Logged';
    }
	return $ReturnValue;

}
?>