<?php include_once 'db.class.php';?>
<?php


function user_register($Name, $UserID, $Email, $Password, $UserType) 
{
  $retVal = false;
  $db = new DB();
  $numrows = $db->countOf('users', "UserID='$UserID'");
  if ($numrows == 0)
  {
    $query = "INSERT into users (Name, Userid, Email, Password, UserType, IsActive, CreationDate) values (";
    $query .= "'" . mysql_real_escape_string($Name) . "', ";
    $query .= "'" . mysql_real_escape_string($UserID) . "', ";
	$query .= "'" . mysql_real_escape_string($Email) . "', ";
    $query .= "'" . mysql_real_escape_string($Password) . "', ";
    $query .= mysql_real_escape_string($UserType) . ", ";
    $query .= "1, Now())";
    $db->execute($query);
  	SendUserDetails($Email, $UserID, $Password, $_SERVER['SERVER_NAME']);
  	$retVal = true;
  }
  
  $db->close();
  
  return $retVal;	
}

function user_login($Username, $Password)
{
  $db = new DB();
  $query = "select Name, UserType, ID, Userid from users where Userid='$Username' and Password='$Password'";
  $db->query($query);
  $numrows = 0;
  while ($line = $db->fetchNextObject()) {   
     
    $_SESSION['usertype'] = $line->UserType;
    $_SESSION['name'] = $line->Name;
    $_SESSION['userid'] = $line->Userid;
	 $_SESSION['username'] = $line->Userid;
	$_SESSION['id'] = $line->ID;
	$numrows = 1;
  }
  $db->close();
  if ($numrows == 1)
  {
      return 'Correct';
  }
  else
  {
      return false;
  }
}

function user_logout()
{
     // End the session and unset all vars
     session_unset ();
     session_destroy ();
}

function is_authed()
{
     // Check if the encrypted username is the same
     // as the unencrypted one, if it is, it hasn't been changed
     if (isset($_SESSION['username']) && isset($_SESSION['usertype']))
     {
	     return true;
     }
     else
     {
          return false;
     }
}

?>