<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
if (!isset($_POST['currentpass'])) {  

 $error = "Please enter your current password and new password below";

} else if ($_POST['newpass'] == $_POST['confirm']){
	$logresult = file_get_contents('https://www.wevolt.com/processing/pfusers.php?action=logincrypt&email='.$_SESSION['email'].'&pass='.md5($_POST['currentpass']));
   if (trim($logresult) != 'Not Logged') {
	$changeresult = file_get_contents ('https://www.wevolt.com/processing/pfusers.php?action=changepass&id='.trim($_SESSION['userid']).'&n='.$_POST['newpass']);
    $error = "An Email has been sent to your account with your new password for your records. ";
  
	} else {  
	   $error = "That is not your current password";
	  
     } 
} else {

     $error = "Your Passwords do not match.";
	 
}
echo $error;
include $_SERVER['DOCUMENT_ROOT'].'/includes/newpass_form.inc.php'; 
?>