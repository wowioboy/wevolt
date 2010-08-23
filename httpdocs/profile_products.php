<?php include 'includes/init.php';?>
<?php include 'includes/comments_inc.php';?>
<?php include 'includes/favorites_inc.php';?>
<? 
include 'includes/dbconfig.php';
include 'includes/message_functions.php';?>
<?php 
//$_SESSION['username'] = 'SJ';
	//   $_SESSION['avatar'] = 'http://www.panelflow.com/users/rbr/avatars/rbr.jpg';
	  //  $_SESSION['email'] = 'seanmjordan@gmail.com';
		// $_SESSION['userid'] = '65b9eea669';
		 //$_SESSION['encrypted_email'] =  md5($_SESSION['email']);

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
	header("location:/profile/".$UserName."/");
} else if ($_GET['btnsubmit'] == 'No'){
	header("location:/profile/".$UserName."/");
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
include 'includes/dbconfig.php';

$query = "select * from messages where userid='$ID' and isread=0";
$Result = mysql_query ($query);
$nRows = mysql_num_rows($Result);
if ($nRows > 0) {
	$newMsg = "<div align='center' style='color:#ff0000;'>(".$nRows.") UNREAD</div>";
}

if ($_POST['editaccount'] == 1){
$Notify = $_POST['notify'];
$Comments = $_POST['profilecomments'];
$FaceID = $_POST['txtFace'];
$query = "UPDATE $usertable SET notify='$Notify',allowcomments='$Comments',FaceID='$FaceID' WHERE encryptid='$ID'";
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
	$query = "UPDATE $usertable SET music='$Music',location='$Location',books='$Books',hobbies='$Hobbies',realname='$Realname',website='$Website',about='$About',influences='$Influences',credits='$Credits',link1='$Link1', link2='$Link2',link3='$Link3', link4='$Link4',allowcomments='$AllowComments' WHERE encryptid='$ID'";
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
	 if (substr($Website,0,3) == 'www') {
	 	$Website = 'http://'.$Website;
	 }
	 $IsCreator = $user['iscreator'];
	 $Influences = $user['influences'];
	 $Credits = $user['credits'];
	 $Link1 = $user['link1'];
	 if (substr($Link1,0,3) == 'www') {
	 	$Link1 = 'http://'.$Link1;
	 }
	 $Link2 = $user['link2'];
	  if (substr($Link2,0,3) == 'www') {
	 	$Link2 = 'http://'.$Link2;
	 }
	 $Link3 = $user['link3'];
	  if (substr($Link3,0,3) == 'www') {
	 	$Link3 = 'http://'.$Link3;
	 }
	 $Link4 = $user['link4'];
	  if (substr($Link4,0,3) == 'www') {
	 	$Link4 = 'http://'.$Link4;
	 }
 	 $About = stripslashes($user['about']);
	 $AllowComments = $user['allowcomments'];
	 $HostedAccount = $user['HostedAccount'];
	 
	 //Build Product List
	 $query = "select * from products where UserID='$ID' and Published=1 ORDER BY Title DESC";
  	$result = mysql_query($query);
  	$nRows = mysql_num_rows($result);
	$Products = $nRows;
  	$counter =0;
  	$productString = "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr>";
  	for ($i=0; $i< $nRows; $i++){
   		$row = mysql_fetch_array($result);
		$productString .= "<td valign='top' id='profilemodcontent'><div align='center'><div class='comictitlelist'>".stripslashes($row['Title'])."</div><a href='/products/".$row['EncryptID']."/'><img src='".$row['ThumbSm']."' border='2' alt='LINK' style='border-color:#000000;'></a><div class='smspacer'></div><div class='moreinfo'><a href='/products/".$row['EncryptID']."/'><img src='/images/info.jpg' border='0'></a>";
	
		if ($ID == $_SESSION['userid']) { 
	
		$productString .= "<div class='smspacer'></div><a href='/products/edit/".$row['EncryptID']."/'><img src='images/edit.jpg' border='0'></a><div class='smspacer'></div><a href='/products/delete/".$row['EncryptID']."/'><img src='images/delete_btn.jpg' border='0'></a>";
		}
		if ($row['ProductType'] == 'pdf') {
			$SelectDB = new DB();
			$query= "SELECT Pages from products_attributes_pdf where ProductID ='". $row['EncryptID']."'";
			$TotalPages = $SelectDB->queryUniqueValue($query);
			$productString .="<div class='pages'>Pages: ".$TotalPages."</div>";
		}
		$productString .="</div><div class='lgspacer'></div></td>"; 
			 $counter++;
 				if ($counter == 3){
 					$productString .= "</tr><tr>";
 					$counter = 0;
 				}
	}
	 $productString .= "</tr></table>";
	$SelectDB->close();


	 
	 
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
$query = "select FriendID from friends where UserID='$ID' and Accepted=1 ORDER BY RAND() limit 8";
	//Create a PS_Pagination object
	//The paginate() function returns a mysql result set 
$friendString = "<table width='100%'><tr>";
$counter = 0;
$FriendArray = $friendDB->query($query);
$FriendCount = $friendDB->numRows();
while ($friend = $friendDB->fetchNextObject()) { 
$userDB = new DB($userdb,$userhost, $dbuser, $userpass);
$FriendID = $friend->FriendID;
$query ="SELECT username, avatar from users where encryptid='$FriendID'";
$UserArray = $userDB->queryUniqueObject($query);
 $friendString .= "<td valign='top' align='center'><div style='width:55px;'><div class='comictitlelist'>".$UserArray->username."</div><a href='/profile/".trim($UserArray->username)."/'><img src='".$UserArray->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a>";
 
 if ($UserArray->location != '') {
 
 $friendString .=" <br/><span class='joined'>from: <b>".$UserArray->location."</b></span>";
 
 }
 $friendString .="</div></td>";
 $counter++;
 if ($counter == 4){
 $comicString .= "</tr><tr>";
 $counter = 0;
 }
 }
 
 if ($FriendCount < 8) {
 	$SelectLimit = (8-$FriendCount);
 $query = "select UserID from friends where FriendID='$ID' and Accepted=1 ORDER BY RAND() limit $SelectLimit";

	//Create a PS_Pagination object
	//The paginate() function returns a mysql result set 
$counter = 0;
$FriendArray = $friendDB->query($query);
while ($friend = $friendDB->fetchNextObject()) { 
$userDB = new DB($userdb,$userhost, $dbuser, $userpass);
$FriendID = $friend->UserID;
$query ="SELECT username, avatar from users where encryptid='$FriendID'";
$UserArray = $userDB->queryUniqueObject($query);
 $friendString .= "<td valign='top' align='center'><div style='width:55px;'><div class='comictitlelist'>".$UserArray->username."</div><a href='/profile/".trim($UserArray->username)."/'><img src='".$UserArray->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a>";
 
 if ($UserArray->location != '') {
 
 $friendString .=" <br/><span class='joined'>from: <b>".$UserArray->location."</b></span>";
 
 }
 $friendString .="</div></td>";
 $counter++;
 if ($counter == 4){
 $comicString .= "</tr><tr>";
 $counter = 0;
 }
 }
 }
	//Display the full navigation in one go
	$friendString .= "</tr></table>";
	
$query ="SELECT * from messages where isread=0 and userid='$ID'";
$friendDB->query($query);
$NumMessages = $friendDB->numRows();

$MailMessage = '('.$NumMessages.') unread mail';

$friendDB->close();

	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<link href="/css/modal.css" rel="stylesheet" type="text/css">
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - PROFILE OF <? echo $Username; ?></title>
<script type="text/javascript">

		function revealModal(divID)
	{
		window.onscroll = function () { document.getElementById(divID).style.top = document.body.scrollTop; };
		document.getElementById(divID).style.display = "block";
		document.getElementById(divID).style.top = document.body.scrollTop;
	}
	
	function hideModal(divID)
	{
		document.getElementById(divID).style.display = "none";
	}
	
	function addFriend()
	{
	 	     <? if (isset($_GET['id'])) { 
			 	echo 'document.friendform.action = "/profile/'.$Username.'/";'; 
			 } else { 
				echo 'document.friendform.action = "/profile/'.$Username.'/";';
			}?>
			document.friendform.submit() 
			hideModal('friendModal');
			
		
	}
	
	function rolloveractive(tabid, divid) {
	var divstate = document.getElementById(divid).style.display;
	//alert('TABID = '+tabid+' and DIVID='+divid);
	//if (divstate == 'none') {
		//alert(divid+ 'state = hidden');
	//} else {
		//alert(divid+ 'state = active');
	//}
			if (document.getElementById(divid).style.display != '') {
			//alert('TABID = '+tabid+' and DIVID='+divid);
				document.getElementById(tabid).className ='profiletabhover';
			} 
	}
	function rolloverinactive(tabid, divid) {
			if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='profiletabinactive';
			} 
	}
	
	function comicstab()
	{
			document.getElementById("comicslist").style.display = '';
			document.getElementById("comicstab").className ='profiletabactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			<? if ($ID == $_SESSION['userid']) { ?>
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? }?>
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
	}
	function infotab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = '';
			document.getElementById("infotab").className ='profiletabactive';
			<? if ($ID == $_SESSION['userid']) { ?>
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? }?>
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
			
	}
	<? if ($ID == $_SESSION['userid']) { ?>
	function favstab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			document.getElementById("favslist").style.display = '';
			document.getElementById("favstab").className ='profiletabactive';
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
		
			
	}
	<? }?>
	<? if ($Products >0) { ?>
	function productstab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			document.getElementById("productslist").style.display = '';
			document.getElementById("productstab").className ='profiletabactive';
		
			
	}
	<? }?>
	</script>
</head>

<body>
<?php include 'includes/header_content.php';?>

     <div class='contentwrapper'>
<table width="683" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="262" valign="top" style="padding-left:5px;">
	
	<table width="243" cellpadding="0" cellspacing="0" border="0">
	  <tr><td width="126" valign="top" background="/images/profile_left.png" style="background-repeat:repeat-x;">
      <div class="imageName" align="center"><?php echo $Username; ?></div>
	<div class="spacer"></div>
	<?php if (isset($Location)) { ?>
	<div class="locationwrapper">
		<div class="comicinfo">LOCATION: </div> 
		<div class="infotext"><?php echo $Location; ?></div>
	</div>
    <?php } ?>
    <div class="locationwrapper" style="padding-top:10px;">
    <?php if (($ID != $_SESSION['userid']) && (isset($_SESSION['userid']))) { ?>
     <?php if (($Friend == 0) || ($Friend == '')) {?>
		<div class="infotext" align="center"><a href="javascript:revealModal('friendModal')">add to friends</a> </div>
     <? }?> 
        <div class="infotext" align="center"><a href='/newmessage.php?user=<? echo $UserName;?>'>send message</a> </div> 
        <? } ?>
        <? if ($ID == $_SESSION['userid']){  echo $MailMessage;}?>
	</div>	</td>
    <td background="/images/image_right.jpg" style="background-repeat:no-repeat; padding-top:5px;" height="115" width="117" valign="top" ><?php if (isset($Avatar)) { ?>
	<div align="center"><img src="<?php echo $Avatar; ?>"  border="1" /></div>
<?php } ?></td></tr> <?php if ($ID == $_SESSION['userid']) { ?><tr><td align="center" colspan='2'>
 
 <div id='control'><strong>You need to upgrade your Flash Player and turn on Javascript</div>
<script type="text/javascript">
		// <![CDATA[
		
		var so = new SWFObject("/control.swf", "images", "241", "58", "8.0.23", true);
		so.addParam("wmode", "transparent");
		so.write("control");

		// ]]>
	</script></td></tr> 
	
	<?php if (($HostedAccount == 1) || ($HostedAccount == 2)) { ?><tr><td align="center" colspan='2'>
 
 <div id='cms'><strong>You need to upgrade your Flash Player and turn on Javascript</div>
<script type="text/javascript">
		// <![CDATA[
		
		var so = new SWFObject("/cms_launch.swf", "cms", "241", "58", "8.0.23", true);
		so.addParam("wmode", "transparent");
		so.addVariable('userid','<?php echo trim($_SESSION['userid'])?>');
		so.write("cms");

		// ]]>
	</script></td></tr>  <? } ?> <? } ?></table>
	<div align="left">
 <table cellpadding="0" cellspacing="0" border="0"> <tr>

<td class="profiletabactive" align="left" id='friendstab'>FRIENDS</td><td class="profiletabinactive" align="right" id='browsetab'><a href='/profile/<? echo $UserName;?>/?s=friends' >[see all]</a></td>
</tr>
</table>
</div>

 <table border="0" cellpadding="0" cellspacing="0" width="240">
<tr>
<td id="profilemodcontent">

<?php echo $friendString; ?></td>
</tr>
</table>  <div class="spacer"></div>
<!-- Beginning of Project Wonderful ad code: -->
<!-- Ad box ID: 31783 -->
<script type="text/javascript">
<!--
var d=document;
d.projectwonderful_adbox_id = "31783";
d.projectwonderful_adbox_type = "6";
d.projectwonderful_foreground_color = "";
d.projectwonderful_background_color = "";
//-->
</script>
<script type="text/javascript" src="http://www.projectwonderful.com/ad_display.js"></script>
<noscript><map name="admap31783" id="admap31783"><area href="http://www.projectwonderful.com/out_nojs.php?r=0&amp;c=0&amp;id=31783&amp;type=6" shape="rect" coords="0,0,234,60" title="" alt="" target="_blank" /><area href="http://www.projectwonderful.com/out_nojs.php?r=1&amp;c=0&amp;id=31783&amp;type=6" shape="rect" coords="0,60,234,120" title="" alt="" target="_blank" /></map>
<table cellpadding="0" border="0" cellspacing="0" width="234" bgcolor="#ffffff"><tr><td><img src="http://www.projectwonderful.com/nojs.php?id=31783&amp;type=6" width="234" height="120" usemap="#admap31783" border="0" alt="" /></td></tr><tr><td bgcolor="#ffffff" colspan="1"><center>
</center></td></tr><tr><td colspan=1 valign="top" width=234 bgcolor="#000000" style="height:3px;font-size:1px;padding:0px;max-height:3px;"></td></tr></table>
</noscript>
<!-- End of Project Wonderful ad code. -->
</td>


    <td width="400" valign="top" align="right" style="padding-right:10px;">
    <div align="left" style="padding-left:4px;">
   <table cellpadding="0" cellspacing="0" border="0" width="386"> <tr>

<td class="profiletabactive" align="left" width="25%" id='comicstab' onMouseOver="rolloveractive('comicstab','comicslist')" onMouseOut="rolloverinactive('comicstab','comicslist')" onclick="comicstab();">COMICS</td>
<td width="5"></td>
<td class="profiletabinactive" align="left" width="25%" id='infotab' onMouseOver="rolloveractive('infotab','userinfo')" onMouseOut="rolloverinactive('infotab','userinfo')" onclick="infotab();"> INFO</td>
<? if ($ID == $_SESSION['userid']) { ?>
<td width="5"></td>
<td class="profiletabinactive" align="left" width="25%" id='favstab' onMouseOver="rolloveractive('favstab','favslist')" onMouseOut="rolloverinactive('favstab','favslist')" onclick="favstab();">FAVORITES</td>
<? }?>
<? if ($Products > 0) { ?>
<td width="5"></td>
<td class="profiletabinactive" align="left" width="25%" id='productstab' onMouseOver="rolloveractive('productstab','productslist')" onMouseOut="rolloverinactive('productstab','productslist')" onclick="productstab();">PRODUCTS</td>
<? }?>
</tr>
</table>
</div>
    <? if ($IsCreator == 1) { ?>
<div id='userinfo' style="display:none;">	
<? } else {?>
<div id='userinfo'>	
<? }?>


	<table border="0" cellpadding="0" cellspacing="0" width="400">

<tr>
<td id="profilemodcontent" >
<?php 

if ((isset($About)) && ($About != '')) { ?>
<div class="profilemodheadertext">ABOUT</div>
<? 	echo  nl2br($About);
echo '<div class="spacer"></div>';
 }
 
 if ((isset($Website)) && ($Website != '')) {?>
 <div class="profilemodheadertext">PERSONAL WEBSITE</div>
 <a href="<?php echo $Website; ?>" target="_blank" style="color:#cb6720;"><?php echo $Website; ?></a>
 <div class='spacer'></div>
 <?php } 
 if (($Link1!='') || ($Link2!='') ||($Link3!='') ||($Link4!='')){ 
echo '<div class="profilemodheadertext">OTHER LINKS</div>';

} if ((isset($Link1)) && ($Link1 != '')) { ?>
<a href="<?php echo $Link1; ?>" target="_blank" style="color:#cb6720;"><?php echo $Link1; ?></a><br/>
<?php } ?>

<?php if ((isset($Link2))  && ($Link2 != '')){ ?>
<a href="<?php echo $Link2; ?>" target="_blank" style="color:#cb6720;"><?php echo $Link2; ?></a><br/>
<?php } ?>

<?php if ((isset($Link3))  && ($Link3 != '')){ ?>
<a href="<?php echo $Link3; ?>" target="_blank" style="color:#cb6720;"><?php echo $Link3; ?></a><br/>
<?php } ?>

<?php if ((isset($Link4)) && ($Link4 != '')) { ?>
<a href="<?php echo $Link4; ?>" target="_blank" style="color:#cb6720;"><?php echo $Link4; ?></a><br/>
<?php } 
if (($Link1!='') || ($Link2!='') ||($Link3!='') ||($Link4!='')){ 
echo '<div class="spacer"></div>';

}
   if (($Influences!='') && ($IsCreator == 1)) {?>
   <div class="profilemodheadertext">INFLUENCES</div>
   <?php echo nl2br(stripslashes($Influences));
   echo '<div class="spacer"></div>';
    ?>
  <? }
  	
	 if (($Credits!='') && ($IsCreator == 1)) {?>
   <div class="profilemodheadertext">CREDITS</div>
   <?php echo nl2br(stripslashes($Credits)); 
   		echo '<div class="spacer"></div>';
   ?>
  <? }
  	
	 if ($Books!='') {?>
       <div class="profilemodheadertext">FAVORITE BOOKS</div>
	 <?
	 	echo nl2br(stripslashes($Books));
		echo '<div class="spacer"></div>';
	 }
  		
		if ($Music!='') {
			echo '<div class="profilemodheadertext">FAVORITE MUSIC</div>';
			echo nl2br(stripslashes($Music));
			echo '<div class="spacer"></div>';
		}
		
		if ($Hobbies!='') {
			echo '<div class="profilemodheadertext">HOBBIES</div>';
			echo nl2br(stripslashes($Hobbies));
			echo '<div class="spacer"></div>';
		}
  ?></td>
</tr>
</table>

</div>

<? if ($IsCreator == 1) { ?>
<div id='comicslist'>
<? } else {?>
<div id='comicslist' style="display:none;">
<? }?>
<?php if ($IsCreator == 1) {    
$query = "select * from comics where (CreatorID='$ID' or userid='$ID') and installed=1 ORDER BY title DESC";
//print $query;
  $result = mysql_query($query);
  $nRows = mysql_num_rows($result);
  $counter =0;
  $comicString = "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr>";
   for ($i=0; $i< $nRows; $i++){
   	$row = mysql_fetch_array($result);
	$UpdateDay = substr($row['PagesUpdated'], 5, 2); 
			$UpdateMonth = substr($row['PagesUpdated'], 8, 2); 
			$UpdateYear = substr($row['PagesUpdated'], 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;

	
	$comicString .= "<td valign='top' id='profilemodcontent'><div align='center'><div class='comictitlelist'>".stripslashes($row['title'])."</div><a href='".$row['url']."' target='blank'>";
	
	if ($row['Hosted'] == 1) {
	 $fileUrl = 'http://www.needcomics.com'.$row['thumb'];
	} else {
	 $fileUrl = $row['thumb'];
	}

		    	$AgetHeaders = @get_headers($fileUrl);
			if (preg_match("|200|", $AgetHeaders[0])) {
				$comicString .="<img src='".$fileUrl."' border='2' alt='LINK' style='border-color:#000000;' width='100' height='134'>";
			} else {
			 $comicString .="<img src='/images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000;'>";
			}
	
	
	$comicString .="</a><div class='smspacer'></div><div class='moreinfo'><a href='/".urlencode($row['title'])."/'><img src='/images/info.jpg' border='0'></a>";
	
	if ($ID == $_SESSION['userid']) { 
	
	$comicString .= "<div class='smspacer'></div><a href='/comicstats.php?comicid=".$row['comiccrypt']."'><img src='/images/stats.jpg' border='0'></a>";
	}
	
	$comicString .="<div class='updated'>updated: <b>".$Updated."</b></div><div class='pages'>Pages: ".$row['pages']."</div></div><div class='lgspacer'></div></td>"; 
			 $counter++;
 				if ($counter == 3){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
	}
	 $comicString .= "</tr></table>";
	
} else {
	$comicString .= 'There are currently no active comics for this user.';
}


?>
<table border="0" cellpadding="0" cellspacing="0" width="400">

<tr>
<td id="profilemodcontent" ><?  echo $comicString;?>
</td>
</tr>
</table>

</div>


<div id='productslist' style="display:none;">
<table border="0" cellpadding="0" cellspacing="0" width="400">

<tr>
<td id="profilemodcontent" ><?  echo $productString;?>
</td>
</tr>
</table>



</div>


<div id='favslist' style="display:none;">
<?php  
if ($ID == $_SESSION['userid']) { 
  $counter =0;
$query = "SELECT * FROM $favtable WHERE userid='$ID'";
$result = mysql_query($query);
$nRows = mysql_num_rows($result);
$Count = 1;
  $comicString = "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr>";
 for ($i=0; $i< $nRows; $i++){
   		$row = mysql_fetch_array($result);
	    $query = "SELECT distinct comiccrypt, thumb, title, url, short, updated FROM comics WHERE " .
		         "comiccrypt='".$row['comicid']."' LIMIT 1";
			//print $query;
        $comicresult = mysql_query($query);
		$ComicsArray = mysql_fetch_array( $comicresult);
		$Updated = substr($ComicsArray['updated'], 0, 10);
  	 	$comicString .= "<td valign='top' width='100'><b>".$ComicsArray['title']."</b><br />updated: <br/><b>".$Updated."</b><br />
<a href='".$ComicsArray['url']."' target='blank'><img src='".$ComicsArray['thumb']."' border='2' alt='LINK' style='border-color:#000000;'></a><div class='smspacer'></div><div style='padding-left:6px;'><a href='/".$ComicsArray['title']."/'><img src='/images/info.jpg' border='0'></a><br />
<a href='".$ComicsArray['url']."' target='blank'><img src='/images/read_small.jpg' border='0'></a><br />

   <form method='POST' action='/profile/".$_SESSION['username']."/'>
	<input type='hidden' name='deletefav' id='deletefav' value='1'>
	<input type='hidden' name='favid' id='favid' value='".$row['favid']."'>
	<input type='hidden' name='comicid' id='comicid' value='".$row['comicid']."'>
	<input type='image' src='/images/delete_lg.jpg' value='DELETE' style='border:none;'/>
	</form><form method='POST' action='/profile/".$_SESSION['username']."/'><input type='hidden' name='favid' id='favid' value='".$row['favid']."'>";
	
	if ($row['notify'] == 1) {
		$comicString .= "<input type='hidden' name='stopnotify' id='stopnotify' value='1'><input type='image' src='/images/nonotify.jpg' value='notify' style='border:none;' /></form></div></td>";
	} else {
		$comicString .= "<input type='hidden' name='notify' id='notify' value='1'><input type='image' src='/images/notify_me.jpg' value='notify' style='border:none;' /></form></div></td>";
	}
		
	}
	 $counter++;
 			if ($counter == 4){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
	
	 $comicString .= "</tr></table>";
	 //echo $comicString; 
	 if ($nRows == 0 ){
	 
	 echo "<div class='favs'>You have not added any favorites yet</div>";
	 
	 }
	 
	 
	 
	 } 
	
?>
<table border="0" cellpadding="0" cellspacing="0" width="400">

<tr>
<td id="profilemodcontent" ><?  echo $comicString;?>
</td>
</tr>
</table>

</div>

<div class="spacer"></div>


<? if ($AllowComments == 1) {?>
<table border="0" cellpadding="0" cellspacing="0" width="400">

<tr>
<td id="profilemodcontent" ><div class="comicinfo">COMMENTS</div>
<div class="spacer"></div>
<? 
if ($ID == $_SESSION['userid']) { 
$String = GetProfileCommentsAdmin($ID);
echo $String;
} else {
$String =  GetProfileComments($ID);
echo $String;
}

if (is_authed()) { 
echo "<div class='comicinfo'>LEAVE A COMMENT</div><form method='POST' action='/profile/".$UserName."'>
<textarea rows='5' cols='26' name='txtFeedback' id='txtFeedback'></textarea>
<input type='hidden' name='insert' id='insert' value='1'>
<input type='submit' value='Submit Comment' />
</form>";
 } ?>
 </td>
</tr>
</table>
<? } ?>


</td>
  </tr>
</table>
  </div>
  <?php include 'includes/footer_v2.php';?>
  <map name="Map" id="Map"><area shape="rect" coords="143,9,201,21" href="register.php" />
<area shape="rect" coords="223,7,258,23" href="login.php" />
<area shape="rect" coords="283,9,338,21" href="contact.php" />
<area shape="rect" coords="360,8,407,22" href="comics.php" />
<area shape="rect" coords="429,8,462,23" href="faq.php" />
<area shape="rect" coords="487,7,545,21" href="creators.php" />
<area shape="rect" coords="568,6,638,23" href="download.php" />
</map>

<div id="friendModal">
    <div class="modalBackground">
    </div>
    <div class="modalContainer">
        <div class="modal">
            <div class="modalTop"><b>FRIEND REQUEST</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:hideModal('friendModal')">[X]</a></div>
            <div class="modalBody">
            <div align="center">
            <form name="friendform">
				<p align="center" style="font-size:14px;">Are you <b>sure</b> you want to Add as a friend? <div class='spacer'></div>A request will be sent to them to accept the invitation.</p><br /><br />
					<input type="submit" name="btnsubmit" value="Yes" onClick="javascript:addfriend();"><div class='spacer'></div>
<input type="submit" name="btnsubmit" value="NO" onClick="javascript:hideModal('friendModal');">
<input type="hidden" name="friendid" value="<? echo $ID;?>" />
</form>

				</div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

