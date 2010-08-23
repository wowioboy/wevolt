<?php include 'includes/init.php';?>
<?php include 'includes/comments_inc.php';?>
<?php include 'includes/favorites_inc.php';?>
<? 
include 'includes/dbconfig.php';
include 'includes/message_functions.php';?>
<?php 

if ($_SESSION['userid'] == 'd67d8ab427') {
//$_SESSION['username'] = 'fishcapades';
  // $_SESSION['avatar'] = 'http://www.panelflow.com/users/rbr/avatars/rbr.jpg';
	   //$_SESSION['email'] = 'laurel.shelleyreuss@gmail.com';
		/// $_SESSION['userid'] = 'a97da6296b';
		// $_SESSION['encrypted_email'] =  md5($_SESSION['email']);
}
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
				  $Message = $_SESSION['username'] .' wants to add you as a friend. If you want to accept their request, please click this link <form action="/acceptfriend.php" method="post"><input type="submit" name="buttonSubmit" value="ACCEPT REQUEST"><input type="submit" name="buttonSubmit" value="DECLINE REQUEST"><input type="hidden" name="requestid" value="'.$FriendInvitationID.'"></form>';
				  SendMessage($FriendID, $_SESSION['username'], $_SESSION['userid'], $Subject, $Message);
				  $friendDB->close();
			}
	}

}

function getWaitingOrders($UserID)
{
	global $userdb,$userhost, $dbuser, $userpass;
	$DB = new DB($userdb,$userhost, $dbuser, $userpass);
	

	$query ="SELECT oi. * , o. * , pi. *
FROM tbl_order_item AS oi
JOIN pf_store_items AS pi ON pi.EncryptID = oi.pd_id
JOIN pf_store_images pii ON pi.EncryptID = pii.ItemID
JOIN tbl_order AS o ON o.od_id = oi.od_id
WHERE pi.UserID = '$UserID'
AND od_status = 'paid' and oi.Complete=1 and pi.ShippingOption=0";
	
	$DB->query($query);
	$Found = $DB->numRows();
	$DB->close();
	return $Found;
	

}

function getNewOrders($UserID)
{
	global $userdb,$userhost, $dbuser, $userpass;
	$DB = new DB($userdb,$userhost, $dbuser, $userpass);
	

	$query ="SELECT oi. * , o. * , pi. *
FROM tbl_order_item AS oi
JOIN pf_store_items AS pi ON pi.EncryptID = oi.pd_id
JOIN pf_store_images pii ON pi.EncryptID = pii.ItemID
JOIN tbl_order AS o ON o.od_id = oi.od_id
WHERE pi.UserID = '$UserID'
AND o.od_status = 'paid' and o.IsRead=0";
	
	$DB->query($query);
	$Found = $DB->numRows();
	$DB->close();
	return $Found;
	

}

function getorders($UserID)
{
	global $userdb,$userhost, $dbuser, $userpass;
	$DB = new DB($userdb,$userhost, $dbuser, $userpass);
	

	$query ="SELECT oi. * , o. * , pi. *
FROM tbl_order_item AS oi
JOIN pf_store_items AS pi ON pi.EncryptID = oi.pd_id
JOIN pf_store_images pii ON pi.EncryptID = pii.ItemID
JOIN tbl_order AS o ON o.od_id = oi.od_id
WHERE pi.UserID = '$UserID'
AND od_status = 'paid'";
	
	$DB->query($query);
	$Found = $DB->numRows();
	$DB->close();
	return $Found;
	

}

mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$UserName = $_GET['name'];

if ($UserName == trim($_SESSION['username'])) {
	$ID = trim($_SESSION['userid']);
} else {
$query = "select encryptid,email from $usertable where username='$UserName'";
$result = mysql_query($query);
$user = mysql_fetch_array($result);
$ID = $user['encryptid'];
$CEmail =  $user['email'];
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
$Twittername = mysql_real_escape_string($_POST['Twittername']);
$TwitterCount = $_POST['TwitterCount'];
$query = "UPDATE $usertable SET notify='$Notify',allowcomments='$Comments',FaceID='$FaceID', TwitterCount='$TwitterCount', Twittername='$Twittername' WHERE encryptid='$ID'";
$result = mysql_query($query);


}
if ($_POST['savestatus'] == '1'){
$UpdateDB = new DB();
$StatusText = mysql_real_escape_string($_POST['txtStatus']);
$UserID = $_SESSION['userid'];
$query ="UPDATE users set Status='$StatusText' where encryptid='$UserID'";
$UpdateDB->execute($query);
$UpdateDB->close();
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
	 $Status = $user['Status'];
	 $TwitterCount = $user['TwitterCount'];
	 $Twittername  = $user['Twittername']; 
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
	 $SelectDB = new DB();
	 $query = "select * from products where UserID='$ID' and Published=1 ORDER BY Title DESC";
  	$result = mysql_query($query);
  	$nRows = mysql_num_rows($result);
	$Products = $nRows;
  	$counter =0;
  	$productString = "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr>";
  	for ($i=0; $i< $nRows; $i++){
   		$row = mysql_fetch_array($result);
		$productString .= "<td valign='top' id='profilemodcontent'><div align='center'><div class='comictitlelist'>".stripslashes($row['Title'])."</div><a href='/products/".$row['EncryptID']."/'><img src='/".$row['ThumbSm']."' border='2' alt='LINK' style='border-color:#000000;'></a><div class='smspacer'></div><div class='moreinfo'><a href='/products/".$row['EncryptID']."/'><img src='/images/info.jpg' border='0'></a>";
	
		if ($ID == $_SESSION['userid']) { 
	
		$productString .= "<div class='smspacer'></div><a href='/products/edit/".$row['EncryptID']."/'><img src='/images/edit.jpg' border='0'></a><div class='smspacer'></div><a href='/products/delete/".$row['EncryptID']."/'><img src='/images/delete_btn.jpg' border='0'></a>";
		}
		if ($row['ProductType'] == 'pdf') {
			
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
$query = "select FriendID from friends where UserID='$ID' and Accepted=1 ORDER BY RAND() limit 16";
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
 $friendString .= "<td valign='top' align='center'><div style='width:55px;'><a href='/profile/".trim($UserArray->username)."/'><img src='".$UserArray->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a>";
 
 if ($UserArray->location != '') {
 
 $friendString .=" <br/><span class='joined'>from: <b>".$UserArray->location."</b></span>";
 
 }
 $friendString .="</div></td>";
 $counter++;
 if ($counter == 4){
 	$friendString .= "</tr><tr>";
	 $counter = 0;
 }
 }
 
if ($FriendCount < 16) {
 	$SelectLimit = (16-$FriendCount);
 	$query = "select UserID from friends where FriendID='$ID' and Accepted=1 ORDER BY RAND() limit $SelectLimit";

	//Create a PS_Pagination object
	//The paginate() function returns a mysql result set 
	$FriendArray = $friendDB->query($query);
	while ($friend = $friendDB->fetchNextObject()) { 
		$userDB = new DB($userdb,$userhost, $dbuser, $userpass);
		$FriendID = $friend->UserID;
		$query ="SELECT username, avatar from users where encryptid='$FriendID'";
		$UserArray = $userDB->queryUniqueObject($query);
 		$friendString .= "<td valign='top' align='center'><div style='width:55px;'><a href='/profile/".trim($UserArray->username)."/'><img src='".$UserArray->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='50' height='50'></a>";
 
 		if ($UserArray->location != '') {
 			$friendString .=" <br/><span class='joined'>from: <b>".$UserArray->location."</b></span>";
 		}
		 $friendString .="</div></td>";
 		$counter++;
	 	if ($counter == 4){
 			$friendString .= "</tr><tr>";
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

if (($HostedAccount > 1) && ($ID == $_SESSION['userid'])) {
	$query ="SELECT * from pf_subscriptions where UserID='$ID' and Status='active' and SubscriptionType='application'";
	$friendDB->query($query);
	$Applications = $friendDB->numRows();
	if ($Application > 0) {
		$query = "SELECT TimesDownloaded from licenses where UserID='$UserID'";
		$TimesDownloaded = $buyDB->queryUniqueValue($query);
	}
}


$friendDB->close();

	$PageTitle = 'W3VOLT | '.$Username.' - MYVOLT';  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<link href="/css/modal.css" rel="stylesheet" type="text/css">
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script src="/lib/prototype.js" type="text/javascript"></script>
<script src="/lib/editinplace.js" type="text/javascript"></script>
<? require_once('classes/AjaxEditInPlace.inc.php');?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title><? echo $PageTitle;?></title>
<script type="text/javascript">

function twitterCallback2(twitters) {
  var statusHTML = [];
  for (var i=0; i<twitters.length; i++){
    var username = twitters[i].user.screen_name;
    var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, function(url) {
      return '<a href="'+url+'">'+url+'</a>';
    }).replace(/\B@([_a-z0-9]+)/ig, function(reply) {
      return  reply.charAt(0)+'<a href="http://twitter.com/'+reply.substring(1)+'">'+reply.substring(1)+'</a>';
    });
    statusHTML.push('<div style="padding-right:10px;"><div style="padding-top:5px;padding-bottom:5px;border-bottom:1px solid #000000;"><span style="color:#000000;">'+status+'</span><span class="menubar"> <em><a style="font-size:85%" href="http://twitter.com/'+username+'/statuses/'+twitters[i].id+'">'+relative_time(twitters[i].created_at)+'</a></em></span></div></div>');
  }
  document.getElementById('twitter_update_list').innerHTML = statusHTML.join('');
}

function relative_time(time_value) {
  var values = time_value.split(" ");
  time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
  var parsed_date = Date.parse(time_value);
  var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
  var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
  delta = delta + (relative_to.getTimezoneOffset() * 60);

  if (delta < 60) {
    return 'less than a minute ago';
  } else if(delta < 120) {
    return 'about a minute ago';
  } else if(delta < (60*60)) {
    return (parseInt(delta / 60)).toString() + ' minutes ago';
  } else if(delta < (120*60)) {
    return 'about an hour ago';
  } else if(delta < (24*60*60)) {
    return 'about ' + (parseInt(delta / 3600)).toString() + ' hours ago';
  } else if(delta < (48*60*60)) {
    return '1 day ago';
  } else {
    return (parseInt(delta / 86400)).toString() + ' days ago';
  }
}

function attach_file( p_script_url ) {
        script = document.createElement( 'script' );
      script.src = p_script_url; 
      document.getElementsByTagName( 'head' )[0].appendChild( script );
}


function editstatus(action) {
		if (action == 'save') {
			document.getElementById('StatusForm').submit();
			//var statustxt = document.getElementById('txtStatus').value;
			//var notetext = document.getElementById('txtNote').value;
			//attach_file( 'includes/savestatus.php?&text='+escape(statustxt)+'&id=<? //echo $_SESSION['userid'];?>');
			//alert('includes/savestatus.php?&text='+escape(statustxt)+'&id=<? //echo $_SESSION['userid'];?>');
			//document.getElementById('currentstatus').innerHTML = statustxt;
			//document.getElementById('statusedit').style.display= 'none';
			
		} else {
			document.getElementById('statusedit').style.display= 'none';
		}
}
function showstatus() {

	document.getElementById('statusedit').style.display = '';
}


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
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
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
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
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
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
			
	}
	
	function appstab()
	{
			document.getElementById("comicslist").style.display = 'none';
			document.getElementById("comicstab").className ='profiletabinactive';
			document.getElementById("userinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? if ($Products >0) { ?>
			document.getElementById("productslist").style.display = 'none';
			document.getElementById("productstab").className ='profiletabinactive';
			<? }?>
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = '';
			document.getElementById("appstab").className ='profiletabactive';
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
			<? if ($ID == $_SESSION['userid']) { ?>
			document.getElementById("favslist").style.display = 'none';
			document.getElementById("favstab").className ='profiletabinactive';
			<? if ($Applications > 0) { ?>
			document.getElementById("appslist").style.display = 'none';
			document.getElementById("appstab").className ='profiletabinactive';
			<? }?>
			<? }?>
			document.getElementById("productslist").style.display = '';
			document.getElementById("productstab").className ='profiletabactive';
		
			
	}
	<? }?>
	</script>
</head>


<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>

 
<table cellpadding="0" cellspacing="0" border="0" width="100%">

	<tr>
		<td width="<? echo $SideMenuWidth;?>" valign="top">
			<? include 'includes/site_menu_inc.php';?>
		</td> 
		
        <td  valign="top">
        
        <table width="700" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="280" valign="top" style="padding-left:5px;padding-right:10px;">
	
    <div class="content_modheader" align="left" style="padding-left:10px;"><?php echo $Username; ?></div>
<table width="269" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td id="content_modtopleft"></td>
							<td id="content_modtop"></td>
							<td id="content_modtopright"></td>
						</tr>
						<tr>
							<td id="content_modleftside"></td>
							<td class="content_boxcontent" width="217" valign="top">
								
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  								<tr>
    								<td width="205" valign="top" id="profileinfo">
										
										<div class="spacer"></div>
											<?php if (isset($Location)) { ?>
													<div class="comicinfo">LOCATION: </div> 
		<div class="infotext"><?php echo $Location; ?></div>
											
										<? } ?>
														 <div class="locationwrapper" style="padding-top:10px;">
    <?php if (($ID != $_SESSION['userid']) && (isset($_SESSION['userid']))) { ?>
     <?php if (($Friend == 0) || ($Friend == '')) {?>
		<div class="infotext" align="center"><a href="javascript:revealModal('friendModal')">add to friends</a> </div>
     <? }?> 
        <div class="infotext" align="center"><a href='/newmessage.php?user=<? echo $UserName;?>'>send message</a> </div> 
        <? } ?>
        <? if ($ID == $_SESSION['userid']){  echo $MailMessage;}?>
	</div></td>
								<td height="115" width="115" valign="middle">

		<div align="center"><img src="<?php echo $Avatar; ?>"  border="1" /></div>
</td>
		</tr>
		</table>
		</td>
						<td id="content_modrightside"></td>
						</tr>
						<tr><td id="content_modbottomleft"></td>
						<td id="content_modbottom"></td>
						<td id="content_modbottomright"></td>
						</tr></table>
    
  <div class="spacer"></div>
   <? 
	if (($_SESSION['userid'] == $ID) && ($Status == '') && ($IsCreator == 1)) {?>
	<div class="status"><em>What are you working on? </em><span class="menubar"><a href="#" onclick="showstatus();return false;">[edit]</a></span><div class="spacer"></div>
<div id='currentstatus'><? echo $Status;?></div></div>
   
	<? } 
	
	if (($IsCreator == 1) && ($Status != '')) {?>
       <em> Currently working on: </em><? if ($_SESSION['userid'] == $ID){ ?><span class="menubar"><a href="#" onclick="showstatus();">[edit]</a></span><? }?>
       <div id='currentstatus'><? echo $Status;?></div>
    
    <? }?> 
     <div id='statusedit' style="display:none;"><form method="post" action="/profile/<? echo trim($_SESSION['username']);?>/" id="StatusForm" name= "StatusForm"><textarea style="width:100%; height:30px;" name="txtStatus" id='txtStatus'></textarea>
    <input type="button" value="SAVE" onclick="editstatus('save');" />&nbsp;&nbsp;<input type="button" value="CANCEL" onclick="editstatus('cancel');" /><input type="hidden" name="savestatus" value="1" /></form></div>
    <div class="spacer"></div>  
    
    <? if ($ID == $_SESSION['userid']){ ?>  
<table cellpadding="0" cellspacing="0" border="0">
<tr><td align="center" >

 <div id='control'><strong>You need to upgrade your Flash Player and turn on Javascript</div>
<script type="text/javascript">
		// <![CDATA[
		
		var so = new SWFObject("/control.swf", "images", "241", "58", "8.0.23", true);
		so.addParam("wmode", "transparent");
		so.write("control");

		// ]]>
	</script></td></tr> 
	
	<tr><td align="center"> 
<? //if (($_SESSION['userid'] == 'd67d8ab427') || ($_SESSION['userid'] == '7e7757b1a6')|| ($_SESSION['userid'] == '8f53295ab3')) {?> 
<a href="/cms/admin/"><img src="/images/comic_cms.png" border="0" vspace="5"/></a><? //}

$NewOrders = getNewOrders($ID);
$WaitingOrders = getWaitingOrders($ID);

if ($NewOrders > 0) {
echo '<a href="/store/orders/">You have ('.$NewOrders.') new orders</a><div class="spacer"></div>';
}
if ($WaitingOrders > 0) {
echo '<a href="/store/orders/">You have ('.$WaitingOrders.') orders needing attention</a><div class="spacer"></div>';
}

$AllOrders = getorders($ID);
if ($AllOrders > 0) {
echo '<a href="/store/orders/?a=archive"><img src="/images/view_orders.png" border="0"></a><div class="spacer"></div>';
}

?>



</td></tr>   </table> <? } ?>


	<div align="left" style="padding-right:10px;">
    <? if ($Twittername != '') {?>
    <div id="twitter_div" style="width:100%; padding-right:10px;">
<div class="sidebar-title">Twitter Updates</div>
<div id="twitter_update_list"></div>
<div class="menubar"><a href="http://twitter.com/<? echo $Twittername;?>" id="twitter-link" style="display:block;text-align:right;">follow me on Twitter</a></div>
<div class="spacer"></div>
</div>


<? }?>


 <table cellpadding="0" cellspacing="0" border="0"> <tr>

<td class="profiletabinactive" align="left" id='friendstab'>FRIENDS</td><td class="menubar" align="right" id='browsetab'><!--<a href='/profile/<? //echo $UserName;?>/?s=friends' >[see all]</a>--></td>
</tr>
</table>
</div>

 <table border="0" cellpadding="0" cellspacing="0" width="240">
<tr>
<td id="profilemodcontent">

<?php if ($FriendCount == 0) echo '<div class="favs">No Friends Added Yet</div>'; else echo $friendString; ?></td>
</tr>
</table>  <div class="spacer"></div>

</td>


    <td width="531" valign="top" align="right" style="padding-right:10px;">
    <div align="left" style="padding-left:4px;">
    
   
   <table cellpadding="0" cellspacing="0" border="0"<? if ($Products > 0) { ?>width="386"<? } else {?>width="368"<? }?>> <tr>

<td class="profiletabactive" align="left" <? if ($Products > 0) { ?>width="25%"<? }?> id='comicstab' onMouseOver="rolloveractive('comicstab','comicslist')" onMouseOut="rolloverinactive('comicstab','comicslist')" onclick="comicstab();">COMICS</td>
<td width="5"></td>
<td class="profiletabinactive" align="left" <? if ($Products > 0) { ?>width="25%"<? }?> id='infotab' onMouseOver="rolloveractive('infotab','userinfo')" onMouseOut="rolloverinactive('infotab','userinfo')" onclick="infotab();"> INFO</td>
<? if ($ID == $_SESSION['userid']) { ?>
<td width="5"></td>
<td class="profiletabinactive" align="left" <? if ($Products > 0) { ?>width="25%"<? }?> id='favstab' onMouseOver="rolloveractive('favstab','favslist')" onMouseOut="rolloverinactive('favstab','favslist')" onclick="favstab();">FAVORITES</td>
<? }?>
<? if ($Products > 0) { ?>
<td width="5"></td>
<td class="profiletabinactive" align="left" <? if ($Products > 0) { ?>width="25%"<? }?> id='productstab' onMouseOver="rolloveractive('productstab','productslist')" onMouseOut="rolloverinactive('productstab','productslist')" onclick="productstab();">PRODUCTS</td>
<? }?>
<? if ($Applications > 0) { ?>
<td width="5"></td>
<td class="profiletabinactive" align="left" <? if ($Applications > 0) { ?>width="25%"<? }?> id='appstab' onMouseOver="rolloveractive('appstab','appslist')" onMouseOut="rolloverinactive('appstab','appslist')" onclick="appstab();">APPS</td>
<? }?>
</tr>
</table>
</div>

<div id='userinfo' style="display:none;">	
	<table border="0" cellpadding="0" cellspacing="0" width="525">

<tr>
<td id="profilemodcontent" >
<?php 
$InfoSet = 0;

if ((isset($About)) && ($About != '')) { ?>
<div class="profilemodheadertext">ABOUT</div>
<? 	echo  nl2br($About);
echo '<div class="spacer"></div>';
 }
 
 if ((isset($Website)) && ($Website != '')) {
 $InfoSet = 1;
 ?>
 <div class="profilemodheadertext">PERSONAL WEBSITE</div>
 <a href="<?php echo $Website; ?>" target="_blank" style="color:#cb6720;"><?php echo $Website; ?></a>
 <div class='spacer'></div>
 <?php } 
 if (($Link1!='') || ($Link2!='') ||($Link3!='') ||($Link4!='')){ 
  $InfoSet = 1;
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
   if (($Influences!='') && ($IsCreator == 1)) {
    $InfoSet = 1;
   ?>
   <div class="profilemodheadertext">INFLUENCES</div>
   <?php echo nl2br(stripslashes($Influences));
   echo '<div class="spacer"></div>';
    ?>
  <? }
  	
	 if (($Credits!='') && ($IsCreator == 1)) {
	  $InfoSet = 1;
	 ?>
   <div class="profilemodheadertext">CREDITS</div>
   <?php echo nl2br(stripslashes($Credits)); 
   		echo '<div class="spacer"></div>';
   ?>
  <? }
  	
	 if ($Books!='') {
	  $InfoSet = 1;
	 ?>
       <div class="profilemodheadertext">FAVORITE BOOKS</div>
	 <?
	 	echo nl2br(stripslashes($Books));
		echo '<div class="spacer"></div>';
	 }
  		
		if ($Music!='') {
		 $InfoSet = 1;
			echo '<div class="profilemodheadertext">FAVORITE MUSIC</div>';
			echo nl2br(stripslashes($Music));
			echo '<div class="spacer"></div>';
		}
		
		if ($Hobbies!='') {
		 $InfoSet = 1;
			echo '<div class="profilemodheadertext">HOBBIES</div>';
			echo nl2br(stripslashes($Hobbies));
			echo '<div class="spacer"></div>';
		}
		
		if ($InfoSet == 0) {?>
        
        	<div class="favs" style="text-align:center;padding-top:25px;height:200px;">No profile information added.</div>
        
        <? }?>
</td>
</tr>
</table>

</div>


<div id='comicslist'>

<?php
/*
$query = "select DISTINCT cs.ComicID, c.* 
          from comic_settings as cs on cs.ComicID=c.comiccrypt
		
			  join  comics as c where (c.CreatorID='$ID' or c.userid='$ID' or cs.CreatorOne='$CSessionEmail' or cs.CreatorTwo='$CSessionEmail' or cs.CreatorTwo='$CSessionEmail') and c.installed=1 ORDER BY c.title DESC";
else 
	$query = "select DISTINCT cs.ComicID, c.* 
	          from comic_settings as cs on cs.ComicID=c.comiccrypt
		
			  join comics as c where (c.CreatorID='$ID' or c.userid='$ID' or cs.CreatorOne='$CEmail' or cs.CreatorTwo='$CEmail' or cs.CreatorTwo='$CEmail') and c.installed=1,c.Published=1 ORDER BY c.title DESC";
print $query;*/
$CSessionEmail = $_SESSION['email'];



if ($_SESSION['userid'] == $ID) 
$query =  "SELECT DISTINCT cs. * , c. *
FROM comics AS c
JOIN comic_settings AS cs ON cs.ComicID = c.comiccrypt
WHERE (
c.CreatorID = '$ID'
OR c.userid = '$ID'
OR cs.CreatorOne = '$CSessionEmail'
OR cs.CreatorTwo = '$CSessionEmail'
OR cs.CreatorTwo = '$CSessionEmail'
)
AND c.installed =1
ORDER BY c.title DESC";
else 
	$query = "SELECT DISTINCT cs. * , c. *
FROM comics AS c
JOIN comic_settings AS cs ON cs.ComicID = c.comiccrypt
WHERE (
c.CreatorID = '$ID'
OR c.userid = '$ID'
OR cs.CreatorOne = '$CEmail'
OR cs.CreatorTwo = '$CEmail'
OR cs.CreatorTwo = '$CEmail'
)
AND c.installed =1 and c.Published=1
ORDER BY c.title DESC";


if ($_SESSION['userid'] == 'a97da6296b') {
//print $query;
}

  $result = mysql_query($query);
  $numberComics = mysql_num_rows($result);
  $counter =0;
  $comicString = "<table width='100%' cellspacing='0' cellpadding='0' border='0'><tr>";
   for ($i=0; $i< $numberComics; $i++){
   	$row = mysql_fetch_array($result);
	$UpdateDay = substr($row['PagesUpdated'], 5, 2); 
			$UpdateMonth = substr($row['PagesUpdated'], 8, 2); 
			$UpdateYear = substr($row['PagesUpdated'], 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
			
			if ($row['Hosted'] == 1) {
					$fileUrl = $row['thumb'];
					$comicURL = $row['url'].'/';
				} else if (($row['Hosted'] == 2) && (substr($row['thumb'],0,4) != 'http'))  {
					$fileUrl = $row['thumb'];
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $row['url'];
				} else {
					$fileUrl = $row['thumb'];
					$comicURL = $row['url'];
				}
	
	$comicString .= "<td valign='top' id='profilemodcontent'><div align='center'><div class='comictitlelist'>".stripslashes($row['title'])."</div><a href='".$comicURL."' target='blank'>";
	
			

		    	//$AgetHeaders = @get_headers($fileUrl);
			//if (preg_match("|200|", $AgetHeaders[0])) {
				$comicString .="<img src='".$fileUrl."' border='2' alt='LINK' style='border:1px solid #000000;' width='100' height='134'>";
			//} else {
			// $comicString .="<img src='/images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000;'>";
			//}
	
	
	$comicString .="</a><div class='smspacer'></div><div class='moreinfo'><a href='/".$row['SafeFolder']."/'><img src='/images/info.png' border='0'></a>";
	
	if ($ID == $_SESSION['userid']) { 
	
	$comicString .= "<div class='smspacer'></div><a href='/".$row['SafeFolder']."/stats/'><img src='/images/stats2.png' border='0'></a>";
	}
	
	$comicString .="<div class='updated'>updated: <b>".$Updated."</b></div><div class='pages'>Pages: ".$row['pages']."</div></div><div class='lgspacer'></div></td>"; 
			 $counter++;
 				if ($counter == 4){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
	}
	 $comicString .= "</tr></table>";
	 
	 if ($numberComics == 0) {
	 		$comicString = "<div class='favs' style='text-align:center;padding-top:25px;height:200px;'>There are currently no active comics for this user</div>";
	 }

?>
<table border="0" cellpadding="0" cellspacing="0" width="525">

<tr>
<td id="profilemodcontent" >
<? if (($numberComics == 0) && ($ID == $_SESSION['userid']))  {?><div align="center" style="height:200px;"><div class="spacer"></div>
You have not created any comics yet.<div class="spacer"></div><a href="/cms/create/" ><img src="/pf_16_core/images/start_new.jpg" border="0"/></a>
 
</div>
<? } else {?>

<?  echo $comicString;?>
<? } ?>
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


<div id='appslist' style="display:none;">
<table border="0" cellpadding="0" cellspacing="0" width="400">

<tr>
<td id="profilemodcontent" >
<div style="font-size:14px;">Panel Flow Pro Client [<a href="/download_pro_client.php">download</a>]</div>
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
	    $query = "SELECT * FROM comics WHERE " .
		         "comiccrypt='".$row['comicid']."' LIMIT 1";
		        $comicresult = mysql_query($query);
		$ComicsArray = mysql_fetch_array( $comicresult);
		$Updated = substr($ComicsArray['updated'], 0, 10);
		
		
		if ($ComicsArray['Hosted'] == 1) {
					$fileUrl = $ComicsArray['thumb'];
					$comicURL = $ComicsArray['url'].'/';
				} else if (($ComicsArray['Hosted'] == 2) && (substr($ComicsArray['thumb'],0,4) != 'http'))  {
					$fileUrl = 'http://www.panelflow.com'.$ComicsArray['thumb'];
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $ComicsArray['url'];
				} else {
					$fileUrl = $ComicsArray['thumb'];
					$comicURL = $ComicsArray['url'];
				}
  	 	$comicString .= "<td valign='top' width='100'><b>".$ComicsArray['title']."</b><br />updated: <br/><b>".$Updated."</b><br />
<a href='".$comicURL."' target='blank'><img src='".$fileUrl."' height='120' width='100' border='2' alt='LINK' style='border-color:#000000;'></a><div class='smspacer'></div><div style='padding-left:6px;'>
<a href='".$comicURL."' target='blank'><img src='/images/read_small.png' border='0'></a><br /><a href='/".$ComicsArray['SafeFolder']."/'><img src='/images/info.png' border='0'></a><br />

   <form method='POST' action='/profile/".$_SESSION['username']."/'>
	<input type='hidden' name='deletefav' id='deletefav' value='1'>
	<input type='hidden' name='favid' id='favid' value='".$row['favid']."'>
	<input type='hidden' name='comicid' id='comicid' value='".$row['SafeFolder']."'>
	<input type='image' src='/images/delete.png' value='DELETE' style='border:none;background-color:#e5e5e5;'/>
	</form><form method='POST' action='/profile/".$_SESSION['username']."/'><input type='hidden' name='favid' id='favid' value='".$row['favid']."'>";
	
	if ($row['notify'] == 1) {
		$comicString .= "<input type='hidden' name='stopnotify' id='stopnotify' value='1'><input type='image' src='/images/nonotify.jpg' value='notify' style='border:none;' /></form></div></td>";
	} else {
		$comicString .= "<input type='hidden' name='notify' id='notify' value='1'><input type='image' src='/images/notify_me.png' value='notify' style='border:none;background-color:#e5e5e5;' /></form></div></td>";
	}
	 $counter++;
	
 			if ($counter == 4){
 					$comicString .= "</tr><tr><td colspan='3' height='10'></td></tr><tr>";
 					$counter = 0;
 				}
		
	}
		if ($counter < 4) {
			while ($counter < 4) {
				$comicString .= "<td></td>";
				$counter++;
			}
			$comicString .= "</tr>";
		}
	
	 $comicString .= "</table>";
	 //echo $comicString; 
	 if ($nRows == 0 ){
	 
	$comicString = "<div class='favs' style='text-align:center;padding-top:25px;height:200px;'>You have not added any favorites yet</div>";
	 
	 }
	 
	 
	 
	 } 
	
?>
<table border="0" cellpadding="0" cellspacing="0" width="525">

<tr>
<td id="profilemodcontent" >

<?  echo $comicString;?>
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
echo "<div class='comicinfo'>LEAVE A COMMENT</div><form method='POST' action='/profile/".$UserName."/'>
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
			
            


	  <?php include 'includes/footer_template_new.php';?>

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
<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<? echo $Twittername;?>.json?callback=twitterCallback2&amp;count=<? echo $TwitterCount;?>"></script>
</body>
</html>

