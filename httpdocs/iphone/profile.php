<?php include 'includes/init.php';?>
<?php include 'includes/favorites_inc.php';?>
<? 
include 'includes/dbconfig.php';
include 'includes/message_functions.php';?>
<?php 


if ($_POST['deletefav'] == 1){
deletefavorite(trim($_POST['comicid']), trim($_POST['favid']), trim($_SESSION['userid']));
} 

if ($_POST['notify'] == 1){
NotifyFavorite($_POST['favid']);
} 

if ($_POST['stopnotify'] == 1){
RemoveNotify($_POST['favid']);
} 

function addfriend($UserID, $FriendID, $userhost, $dbuser,$userpass,$userdb)
{
$friendDB = new DB($userdb,$userhost, $dbuser, $userpass);
$query ="SELECT * from friends where UserID='$UserID' and FriendID = '$FriendID'";

$friendDB->query($query);
$Found == $friendDB->numRows();
if ($Found == 0) {
  $query ="SELECT * from friends where FriendID='$UserID' and FriendID = '$UserID'";
$friendDB->query($query);
$Found == $friendDB->numRows();
if ($Found == 0) {
  $query ="INSERT into friends (UserID, FriendID, Accepted) values ('$UserID', '$FriendID', 0)";
  $friendDB->query($query);
  
  $query ="SELECT ID from friends where UserID='$UserID' and FriendID = '$FriendID'";
  $FriendInvitationID = $friendDB->queryUniqueValue($query);
  $Subject = 'Friend Request';
  $Message = $_SESSION['username'] .' wants to add you as a friend. If you want to accept their request, please click this link <form action="acceptfriend.php" method="post"><input type="submit" name="buttonSubmit" value="ACCEPT REQUEST"><input type="submit" name="buttonSubmit" value="DECLINE REQUEST"><input type="hidden" name="requestid" value="'.$FriendInvitationID.'"></form>';
  SendMessage($FriendID, $_SESSION['username'], $_SESSION['userid'], $Subject, $Message);
  $friendDB->close();
}
}

}
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$UserName = $_GET['name'];
$PageTitle = $UserName.'\'s Profile';
if ($UserName == trim($_SESSION['username'])) {
	$ID = trim($_SESSION['userid']);
} else {
$query = "select encryptid from $usertable where username='$UserName'";
$result = mysql_query($query);
$user = mysql_fetch_array($result);
$ID = $user['encryptid'];
}




if ($_GET['btnsubmit'] == 'Yes') {
$UserID = $_SESSION['userid'];
$FriendID = $ID;
addfriend($UserID, $FriendID,$userhost, $dbuser,$userpass,$userdb);
	header("location:/iphone/profile/".$UserName."/");
} else if ($_GET['btnsubmit'] == 'No'){
	header("location:/iphone/profile/".$UserName."/");
}
$insertComment = $_POST['insert'];

if ($insertComment == '1'){
//print "MY FEEDBACK = " . $_POST['txtFeedback'];
//print "MY SESSION ID = " . trim($_SESSION['userid']);
CommentProfile(trim($_SESSION['username']), trim($_SESSION['userid']), $ID, $_POST['txtFeedback'], date('D M j'), $_SERVER['REMOTE_ADDR']);
} 

$deleteComment = $_POST['deletecomment'];
if ($deleteComment == '1'){
//print "MY FEEDBACK = " . $_POST['txtFeedback'];
//print "MY SESSION ID = " . trim($_SESSION['userid']);
DeleteProfileComment($_POST['commentid']);
} 

if ($_POST['deletefav'] == 1){
deletefavorite(trim($_POST['comicid']), trim($_POST['favid']), trim($_SESSION['userid']));
} 

$newMsg = "";
include_once( './includes/dbconfig.php');

$query = "select * from messages where userid='$ID' and isread=0";
$Result = mysql_query ($query);
$nRows = mysql_num_rows($Result);
if ($nRows > 0) {
	$newMsg = "<div align='center' style='color:#ff0000;'>(".$nRows.") UNREAD</div>";
}

if ($_POST['editaccount'] == 1){
$Notify = $_POST['notify'];
$Comments = $_POST['profilecomments'];
$query = "UPDATE $usertable SET notify='$Notify' WHERE encryptid='$ID'";
$result = mysql_query($query);
$query = "UPDATE $usertable SET allowcomments='$Comments' WHERE encryptid='$ID'";
$result = mysql_query($query);
}

if ($_POST['edit'] == 1) {
 	$Music = addslashes($_POST['music']);
 	$Location = addslashes($_POST['userlocation']);
 	$Books = addslashes($_POST['books']);
	$Hobbies = addslashes($_POST['hobbies']);
 	$Realname = $_POST['realname'];
 	$Website= $_POST['website'];
 	$About = addslashes($_POST['about']);
    $Influences = addslashes($_POST['influences']);
	$Credits = addslashes($_POST['credits']);
	$Link1 = $_POST['link1'];
	$Link2 = $_POST['link2'];
	$Link3 = $_POST['link3'];
	$Link4 = $_POST['link4'];
	$AllowComments = $_POST['commentsallow'];
	$query = "UPDATE $usertable SET music='$Music' WHERE encryptid='$ID'";
 	$result = mysql_query($query);

 	$query = "UPDATE $usertable SET location='$Location' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
 
 	$query = "UPDATE $usertable SET books='$Books' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
 
 	$query = "UPDATE $usertable SET hobbies='$Hobbies' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
 
 	$query = "UPDATE $usertable SET realname='$Realname' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
 
 	$query = "UPDATE $usertable SET website='$Website' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
 
 	$query = "UPDATE $usertable SET about='$About' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
	
	$query = "UPDATE $usertable SET influences='$Influences' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
	
	$query = "UPDATE $usertable SET credits='$Credits' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
	
	$query = "UPDATE $usertable SET link1='$Link1' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
	
	$query = "UPDATE $usertable SET link2='$Link2' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
	
	$query = "UPDATE $usertable SET link3='$Link3' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
	
	$query = "UPDATE $usertable SET link4='$Link4' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
	
	$query = "UPDATE $usertable SET allowcomments='$AllowComments' WHERE encryptid='$ID'";
 	$result = mysql_query($query);
}
     $query = "select * from $usertable where encryptid='$ID'";
     $result = mysql_query($query);
     $user = mysql_fetch_array($result);
     $Username = $user['username'];
	 $Avatar = $user['avatar'];
	 $Music = stripslashes($user['music']);
 	 $Location = stripslashes($user['location']);
 	 $Books = stripslashes($user['books']);
	 $Hobbies = stripslashes($user['hobbies']);
 	 $Realname = $user['realname'];
 	 $Website= $user['website'];
	 $IsCreator = $user['iscreator'];
	 $Influences = $user['influences'];
	 $Credits = $user['credits'];
	 $Link1 = $user['link1'];
	 $Link2 = $user['link2'];
	 $Link3 = $user['link3'];
	 $Link4 = $user['link4'];
 	 $About = stripslashes($user['about']);
	 $AllowComments = $user['allowcomments'];
	 $HostedAccount = $user['HostedAccount'];
	 
	 if ($ID != $_SESSION['userid']) {
	 	$friendDB = new DB($userdb,$userhost, $dbuser, $userpass);	
		$FriendID = $ID;
		$UserID = trim($_SESSION['userid']); 
	    $query ="SELECT * from friends where UserID='$UserID' and FriendID = '$FriendID'";
	
			$friendDB->query($query);
			$Found = $friendDB->numRows();
			
if ($Found == 0) {
  $query ="SELECT * from friends where FriendID='$UserID' and UserID = '$FriendID'";

$friendDB->query($query);
$Found = $friendDB->numRows();

if ($Found == 0) {
$Friend = 0;

} else {
$Friend = 1;
}
} else {
$Friend = 1;
}
	 }



$friendDB = new DB($userdb,$userhost, $dbuser, $userpass);
$query = "select FriendID from friends where UserID='$ID' and Accepted=1 ORDER BY Created DESC";
	//Create a PS_Pagination object
	//The paginate() function returns a mysql result set 
$friendString = "<table width='100%'><tr>";
$counter = 0;
$FriendArray = $friendDB->query($query);
while ($friend = $friendDB->fetchNextObject()) { 
$userDB = new DB($userdb,$userhost, $dbuser, $userpass);
$FriendID = $friend->FriendID;
$query ="SELECT username, avatar from users where encryptid='$FriendID'";
$UserArray = $userDB->queryUniqueObject($query);
 $friendString .= "<td valign='top' align='center'><div style='width:110px;'><div class='comictitlelist'>".$UserArray->username."</div><a href='/profile/".trim($UserArray->username)."/'><img src='".$UserArray->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='100' height='100'></a>";
 
 if ($UserArray->location != '') {
 
 $friendString .=" <br/><span class='joined'>from: <b>".$UserArray->location."</b></span>";
 
 }
 $friendString .="</div></td>";
 $counter++;
 if ($counter == 3){
 $comicString .= "</tr><tr>";
 $counter = 0;
 }
 }
 $query = "select UserID from friends where FriendID='$ID' and Accepted=1 ORDER BY Created DESC";

	//Create a PS_Pagination object
	//The paginate() function returns a mysql result set 
$counter = 0;
$FriendArray = $friendDB->query($query);
while ($friend = $friendDB->fetchNextObject()) { 
$userDB = new DB($userdb,$userhost, $dbuser, $userpass);
$FriendID = $friend->UserID;
$query ="SELECT username, avatar from users where encryptid='$FriendID'";
$UserArray = $userDB->queryUniqueObject($query);
 $friendString .= "<td valign='top' align='center'><div style='width:110px;'><div class='comictitlelist'>".$UserArray->username."</div><a href='/iphone/profile/".trim($UserArray->username)."/'><img src='".$UserArray->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='100' height='100'></a>";
 
 if ($UserArray->location != '') {
 
 $friendString .=" <br/><span class='joined'>from: <b>".$UserArray->location."</b></span>";
 
 }
 $friendString .="</div></td>";
 $counter++;
 if ($counter == 3){
 $comicString .= "</tr><tr>";
 $counter = 0;
 }
 }
	//Display the full navigation in one go
	$friendString .= "</tr></table>";
	
$query ="SELECT * from messages where isread=0 and userid='$ID'";
$friendDB->query($query);
$NumMessages = $friendDB->numRows();

$MailMessage = '('.$NumMessages.') unread mail';

$friendDB->close();
$favDB = new DB();
$comicDB = new DB();
$favString = "<table width='100%'><tr>";
 $counter = 0;
if ($ID == $_SESSION['userid']) {
	$query = "SELECT * FROM favorites WHERE userid='$ID'";
	$favDB->query($query);
	while ($fav = $favDB->fetchNextObject()) { 
 		$query = "SELECT * FROM comics WHERE comiccrypt='".$fav->comicid."'";
			//print $query;
       $ComicsArray = $comicDB->queryUniqueObject($query);
		$UpdateDay = substr( $ComicsArrayPagesUpdated, 5, 2); 
			$UpdateMonth = substr( $ComicsArrayPagesUpdated, 8, 2); 
			$UpdateYear = substr( $ComicsArrayPagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
  	 	$favString .= "<td valign='top' width='100'><b>".$ComicsArray->title."</b><br />updated: <br/><b>".$Updated."</b><br />
<a href='/iphone/".$ComicsArray->title."/'><img src='".$ComicsArray->thumb."' border='2' alt='LINK' style='border-color:#000000; '></a><div class='spacer'></div><div style='padding-left:6px;'><a href='/".$ComicsArray->title."/'><img src='/images/info.jpg' border='0'></a><br /><a href='".$ComicsArray->url."' target='blank'><img src='/images/read_small.jpg' border='0'></a><br /></div></td>";
	 $counter++;
 			if ($counter == 2){
 					$favString .= "</tr><tr>";
 					$counter = 0;
 				}
	}
	 $favString .= "</tr></table>";

} // End IF
$friendDB->close();
$favDB->close();
$comicDB->close();
if ($IsCreator == 1) {    
$query = "select * from comics where CreatorID='$ID' and installed = 1 ORDER BY title DESC";
//print $query;
  $result = mysql_query($query);
  $nRows = mysql_num_rows($result);
  $counter =0;
  $comicString = "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr><td colspan='2><img src='/images/my_comics.png'></td></tr><tr>";
   for ($i=0; $i< $nRows; $i++){
   	$row = mysql_fetch_array($result);
	$UpdateDay = substr($row['PagesUpdated'], 5, 2); 
			$UpdateMonth = substr($row['PagesUpdated'], 8, 2); 
			$UpdateYear = substr($row['PagesUpdated'], 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;

	
	$comicString .= "<td valign='top' id='profilemodcontent'><div align='center'><div class='comictitlelist'>".stripslashes($row['title'])."</div><a href='/iphone/".$row['title']."/'>";
	
	 $fileUrl = $row['thumb'];
		    	$AgetHeaders = @get_headers($fileUrl);
			if (preg_match("|200|", $AgetHeaders[0])) {
				$comicString .="<img src='".$row['thumb']."' border='2' alt='LINK' style='border-color:#000000; width:60px; height:80px;'>";
			} else {
			 $comicString .="<img src='/images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000; width:60px; height:80px;'>";
			}	
	$comicString .="</a><div class='updated'>updated: <b>".$Updated."</b></div><div class='pages'>Pages: ".$row['pages']."</div></div></td>"; 
			 $counter++;
 				if ($counter == 3){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
	}
	 $comicString .= "</tr></table>";
	
}


	 
?>
<? include 'includes/header.php';?>
<script type="text/javascript" language="javascript">
function informationtab()
	{		
			//Activate TR
	        document.getElementById("trinformation").style.display = '';
			//Change Style of Tab
			document.getElementById("infotab").className ='ActiveStyle';
			//DeActivate TR
			document.getElementById("trcomics").style.display = 'none';
			//Change Style of Tab
			document.getElementById("comicstab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trfriends").style.display = 'none';
			//Change Style of Tab
			document.getElementById("friendstab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trfavs").style.display = 'none';
			//Change Style of Tab
			document.getElementById("favstab").className ='NonActiveStyle';					
	}
	function comicstab()
	{		
			//Activate TR
	        document.getElementById("trinformation").style.display = 'none';
			//Change Style of Tab
			document.getElementById("infotab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trcomics").style.display = '';
			//Change Style of Tab
			document.getElementById("comicstab").className ='ActiveStyle';
			//DeActivate TR
			document.getElementById("trfriends").style.display = 'none';
			//Change Style of Tab
			document.getElementById("friendstab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trfavs").style.display = 'none';
			//Change Style of Tab
			document.getElementById("favstab").className ='NonActiveStyle';					
	}
	function friendstab()
	{		
			//Activate TR
	        document.getElementById("trinformation").style.display = 'none';
			//Change Style of Tab
			document.getElementById("infotab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trcomics").style.display = 'none';
			//Change Style of Tab
			document.getElementById("comicstab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trfriends").style.display = '';
			//Change Style of Tab
			document.getElementById("friendstab").className ='ActiveStyle';
			//DeActivate TR
			document.getElementById("trfavs").style.display = 'none';
			//Change Style of Tab
			document.getElementById("favstab").className ='NonActiveStyle';					
	}
	function favstab()
	{		
			//Activate TR
	        document.getElementById("trinformation").style.display = 'none';
			//Change Style of Tab
			document.getElementById("infotab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trcomics").style.display = 'none';
			//Change Style of Tab
			document.getElementById("comicstab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trfriends").style.display = 'none';
			//Change Style of Tab
			document.getElementById("friendstab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trfavs").style.display = '';
			//Change Style of Tab
			document.getElementById("favstab").className ='ActiveStyle';					
	}
	</script>
<div id="topbar">

<table id="topmenu" cellpadding="0px" cellspacing="0px;">
		<tr>
			<td id="startbutton"></td>
			<td class="buttonfield"><a href="/iphone/index.php">
			<img alt="Home" src="/iphone/images/Home.png" /></a></td>
           
			<td id="buttonend"></td>
		</tr>
	</table>        
	<div id="title">
		<img src="/iphone/images/pf_logo_sm.jpg" /></div>
</div>
 <table width='100%' cellspacing=0 cellpadding=0 border=0>
  		<tr>
    	<td width='25%' id='infotab' class='ActiveStyle' height="30" onClick="informationtab()">Info</td>
    	<td  width='25%'id='comicstab' class='NonActiveStyle' height="30" onClick="comicstab()" >Comics</td>
    	<td width='25%' id='friendstab' class='NonActiveStyle' height="30" onClick="friendstab()">Friends</td>
        <? if ($ID == $_SESSION['userid']) { ?>
    	<td width='25%' id='favstab' class='NonActiveStyle' height="30" onClick="favstab()">Favs</td>
        <? }?>
    	</tr>
        </table>
<div id="content">
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" style="padding-left:5px;">
    
      
	
    <div id='trinformation'>
	<div align="center"><table cellpadding="0" cellspacing="0" border="0">
      <tr><td width="126" valign="top" background="/images/profile_left.png" style="background-repeat:repeat-x;">
      <div class="imageName" align="center"><?php echo $Username; ?></div>
	<div class="spacer"></div>
	<?php if (isset($Location)) { ?>
	<div class="locationwrapper">
		<div class="comicinfo">LOCATION: </div> 
		<div class="infotext"><?php echo $Location; ?></div>
	</div>
    <?php } ?>
    <div class="locationwrapper" style="padding-top:20px;">
    <?php if (($ID != $_SESSION['userid']) && (isset($_SESSION['userid']))) { ?>
     <?php if (($Friend == 0) || ($Friend == '')) {?>
		<div class="infotext" align="center"><a href="javascript:revealModal('friendModal')">add to friends</a> </div>
     <? }?> 
        <div class="infotext"><a href='/newmessage.php?user=<? echo $UserName;?>'>send message</a> </div> 
        <? } ?>
        <? if ($ID == $_SESSION['userid']){  echo '<div class="infotext">'. $MailMessage.'</div>';}?>
	</div>	</td>
    <td background="/images/image_right.jpg" style="background-repeat:no-repeat; padding-top:5px;" height="115" width="117" valign="top" ><?php if (isset($Avatar)) { ?>
	<div align="center"><img src="<?php echo $Avatar; ?>"  border="1" /></div>
<?php } ?></td></tr> 
	</table></div>
    <ul class="textbox">
		<?php if ((isset($About)) && ($About != '')) { ?>
		<li class="writehere"><strong>ABOUT</strong><br/><?php echo  nl2br($About); ?></li>
        <? }?>
        <?php if ((isset($Website)) && ($Website != '')) { ?>
		<li class="writehere"><strong>WEBSITE</strong><br/><a href="<?php echo $Website; ?>" target="_blank" style="color:#cb6720;"><?php echo $Website; ?></a></li>
        <? }?>
        
<?php  if (($Link1!='') || ($Link2!='') ||($Link3!='') ||($Link4!='')){ ?>
<li class="writehere"><strong>OTHER LINKS</strong><br/>

<?php if ($Link1!='') { ?>
<a href="<?php echo $Link1; ?>" target="_blank" style="color:#cb6720;"><?php echo $Link1; ?></a><br/>
<?php } ?>

<?php if ($Link2!='') { ?>
<a href="<?php echo $Link2; ?>" target="_blank" style="color:#cb6720;"><?php echo $Link2; ?></a><br/>
<?php } ?>

<?php if ($Link3!='') { ?>
<a href="<?php echo $Link3; ?>" target="_blank" style="color:#cb6720;"><?php echo $Link3; ?></a><br/>
<?php } ?>

<?php if ($Link4!='') { ?>
<a href="<?php echo $Link4; ?>" target="_blank" style="color:#cb6720;"><?php echo $Link4; ?></a><br/>
<?php }?> </li><? } ?>
 <?php if (($Influences!='') && ($IsCreator == 1)) { ?> 
		<li class="writehere"><strong>INFLUENCES</strong><br/><?php echo nl2br(stripslashes($Influences)); ?></li>
        <? }?>
        <?php  if (($Credits!='') && ($IsCreator == 1)) { ?>
		<li class="writehere"><strong>CREDITS</strong><br/><?php echo nl2br(stripslashes($Credits)); ?></li>
        <? }?>
          <?php if ($Books!='') { ?>
		<li class="writehere"><strong>BOOKS</strong><br/><?php echo nl2br(stripslashes($Books)); ?></li>
        <? }?>
         <?php if ($Music!='') { ?>
		<li class="writehere"><strong>MUSIC</strong><br/><?php echo nl2br(stripslashes($Music)); ?></li>
        <? }?>
     <?php if ($Hobbies!='') { ?>
		<li class="writehere"><strong>HOBBIES</strong><br/><?php echo nl2br(stripslashes($Hobbies)); ?></li>
        <? }?>
    
</ul>
	</div>

<div id='trcomics' style="display:none;"><ul class="textbox">
<li class="writehere">
<?php 
 echo $comicString;
?></li></ul>
</div>

<div id='trfriends' style="display:none;">
<ul class="textbox">
<li class="writehere">FRIENDS<br />
<?php echo $friendString; ?></li>
</ul>
</div>
<div id='trfavs' style="display:none;">
<ul class="textbox">
<li class="writehere">MY FAVORITES<br /><?php echo $favString; ?>
</li>
</ul>
</div>

</td>
  </tr>

</table>
<?php if ($ID == $_SESSION['userid']) { ?>
<div class="graytitle">
		User Controls </div>
	<ul class="menu">
    <li><a href="/iphone/accountsettings.php"><span class="menuname">Account Settings</span><span class="arrow"></span></a></li>
			
	</ul>
	
</div>
<? } ?>
	<div class="graytitle">
		Menu </div>
	<ul class="menu">
    <li><a href="comics.php"><img alt="" src="/iphone/images/comic.png" /><span class="menuname">Comics</span><span class="arrow"></span></a></li>
			<li><a href="creators.php"><img alt="" src="/iphone/images/creator.png" /><span class="menuname">Creators</span><span class="arrow"></span></a></li>
        <? if (loggedin == 1) { ?>
		<li><a href="/profile/<? echo $Username;?>/"><img alt="" src="thumbs/help.png" /><span class="menuname">My Profile</span><span class="arrow"></span></a></li>
        <? }?>
          <? if (loggedin != 1) { ?>
        <li><a href="login.php"><span class="menuname">Login</span><span class="arrow"></span></a></li>
        <li><a href="register.php"><span class="menuname">Free Registration</span><span class="arrow"></span></a></li>
        <? }?>
	</ul>
	
</div>
<? include 'includes/footer.php';?>
