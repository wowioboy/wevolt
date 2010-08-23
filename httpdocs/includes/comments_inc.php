<?php 
function CommentProfile($CommentUser, $CommentUserID, $CreatorID, $Comment, $time, $IP){
$Site = $_SERVER['SERVER_NAME'];
include 'dbconfig.php';
 mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 mysql_select_db ($userdb) or die ('Could not select database.');
     // Try and get the salt from the database using the username	 
 $query = "INSERT into usercomments (commentuser, commentuserid, userid, comment, date, site) values ('$CommentUser', '$CommentUserID','$CreatorID', '$Comment','$time', '$Site')";
 $result = mysql_query($query) or die ('Could Not Enter Comment');
 //print "MY QUESRY = " . $query;
     // Using the salt, encrypt the given password to see if it
     // matches the one in the database
   
	 
$insertComment = '0';

}

function DeleteProfileComment($CommentID) {
	include 'dbconfig.php';
 	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
 	mysql_select_db ($userdb) or die ('Could not select database.');
	$query = "DELETE from usercomments where commentid='$CommentID'";
	$result = mysql_query($query);
 	//print  $query;
}



function GetProfileComments($UserID) {
include 'dbconfig.php';
include('includes/ps_pagination.php');
$conn = mysql_connect($userhost, $dbuser,$userpass);
mysql_select_db($userdb,$conn);
$sql = "select comment, commentuser, commentuserid, date from usercomments where userid='$UserID' ORDER BY timestamp DESC";
	//Create a PS_Pagination object
$pager = new PS_Pagination($conn,$sql,5,3);
	//The paginate() function returns a mysql result set 
$rs = $pager->paginate();
$Profilestring = "<div class='pagination'>".$pager->renderFullNav()."</div>";
while($row = mysql_fetch_assoc($rs)) {
   $CommentUserID = $row['commentuserid'];
 // print "MY USER ID = " .$UserID;
   $AvatarQuery = "SELECT avatar from $usertable where encryptid='$CommentUserID'";
   $Aresult = mysql_query($AvatarQuery);
   $userAvatar = mysql_fetch_array($Aresult);
   if ($userAvatar['avatar'] == ""){
   $UserAvatar = "users/avatars/tempavatar.jpg";
   } else {
   $UserAvatar = $userAvatar['avatar'];
   
   }
  $Profilestring .= "<table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='50' rowspan='2' valign='top'><img src='".$UserAvatar."' width='50' height='50' border='1'></td>
    <td width='150' height='30' valign='top'style='padding-left:5px;'><div>on <i>".$row['date']."</i></div><b>".$row['commentuser']."</b> said:</td>
  </tr>
  <tr>
    <td valign='top' style='padding:5px;'>".stripslashes($row['comment'])."</td>
  </tr>
</table><hr><div class='spacer'></div>";
	}
	
	//Display the full navigation in one go
	$Profilestring .= "<div class='pagination'>".$pager->renderFullNav()."</div>";
	return $Profilestring;
}


function GetProfileCommentsAdmin($UserID) { 
include 'dbconfig.php';
global $Username;
$query = "select * from usercomments where userid='$UserID' ORDER BY timestamp DESC";
 //print  $query;
  $result = mysql_query($query);
  $nRows = mysql_num_rows($result);
  $bgcolor = '#FFFFFF';
  $ProfileString ="";
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
  $Profilestring .= "<form method='POST' action='/profile/".$Username."/'>
  <table width='100%' border='0' cellspacing='0' cellpadding='0'>
  <tr>
    <td width='50' rowspan='2' valign='top' bgcolor='".$bgcolor."'><input type='image' src='/images/delete.jpg' style='border:none;' value='DELETE' /><br />
<img src='".$userAvatar['avatar']."' width='50' height='50' border='1'></td>
    <td height='10' valign='top'style='padding-left:5px;' bgcolor='".$bgcolor."'><div>on <i>".$row['date']."</i></div><b>".$row['commentuser']."</b> said:</td>
  </tr>
  <tr>
    <td valign='top' style='padding:5px;' bgcolor='".$bgcolor."'>".stripslashes($row['comment'])."</td>
  </tr><tr><td valign='top'>
  
	<input type='hidden' name='deletecomment' id='deletecomment' value='1'>
	<input type='hidden' name='commentid' id='commentid' value='".$row['commentid']."'>
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
	 $Profilestring = "No Comments yet. Be the first to Comment!";
	
	}
	return $Profilestring;
	}
?>