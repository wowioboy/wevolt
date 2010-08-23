<? if ((isset($_POST['add'])) && ($_GET['a'] == 'users'))
{
  	// Check if any of the fields are missing
     if (empty($_POST['txtRealName']) || empty($_POST['txtUserName']) || empty($_POST['txtUserType']) || empty($_POST['txtEmail']) || empty($_POST['txtPassword']) || empty($_POST['txtConfirmPassword']))
     {
          // Reshow the form with an error
          $reg_error = 'One or more fields missing';
     }

     // Check if the passwords match
     if (($reg_error == '') && ($_POST['txtPassword'] != $_POST['txtConfirmPassword']))
     {
          // Reshow the form with an error
          $reg_error = 'Your passwords do not match';
     }
        $Usertype = $_POST['txtUserType'];
        
     if ($reg_error == '')
     {
       // Everything is ok, register
	
       if (!user_register ($_POST['txtRealName'], $_POST['txtUserName'], $_POST['txtEmail'], $_POST['txtPassword'], $_POST['txtUserType']))
       {
            // Reshow the form with an error
            $reg_error = 'A matching username already exists.';
	}
       else
       {
            //header( "Location: admin.php?a=users") ;
       }
    }
}

//EDIT USER
if (($_POST['btnsubmit'] == 'SAVE') && ($_GET['a'] == 'users')) {
	$userDB = new DB();
	$RealName = $_POST['txtRealName'];
	$UserName = $_POST['txtUserName'];
	$Email = $_POST['txtEmail'];
	$UserType = $_POST['txtUserType'];
	$Password = $_POST['txtPassword'];
	$ConfirmPass = $_POST['txtConfirmPassword'];
	$query = "update users set name='$RealName', userid='$UserName', email='$Email', usertype='$UserType' where id='$UserID'";
	$userDB->query($query);
	if ($Password != "") {
			if ($Password == $ConfirmPass) {
				$query = "update users set password='$Password' where id='$UserID'";
				$userDB->query($query);
			}
	}

}

//DELETE USER
if (($_POST['btnsubmit'] == 'YES') && ($_GET['a'] == 'users')) {
	$userDB = new DB();
	$query = "delete from users where id='$UserID'";
	$userDB->query($query);
	

}
?>