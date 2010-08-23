<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$PageTitle = 'WEvolt | ';
$TrackPage = 1;
?>
<? 
include 'includes/dbconfig.php';
include 'includes/message_functions.php';
include 'includes/myvolt_functions.php';  
if ($_SESSION['userid'] == '')
	header("Location:http://users.wevolt.com/".$_GET['name']."/");

if (trim($_SESSION['username']) != $_GET['name'])
	header("Location:http://users.wevolt.com/".$_GET['name']."/");
	
$MyVolt = 1;?>
<?php 


if ($_SESSION['userid'] == 'd67d8ab427') {
//$_SESSION['username'] = 'fishcapades'; 
  // $_SESSION['avatar'] = 'http://www.wevolt.com/users/rbr/avatars/rbr.jpg';
	   //$_SESSION['email'] = 'laurel.shelleyreuss@gmail.com'; 
		/// $_SESSION['userid'] = 'a97da6296b';
		// $_SESSION['encrypted_email'] =  md5($_SESSION['email']);
}

//FRINEDS LIST

		$userDB =  new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
		$FriendList = array();
		$query = "select u.encryptid, u.username, u.avatar 
				  from friends f 
				  left join users u 
				  on u.encryptid = f.FriendID 
				  left join updates up 
				  on up.UserID = u.encryptid
				  where f.UserID='$ID' and Accepted = 1 and FriendType = 'friend' and IsW3viewer != 1 group by username order by $sort";
			//Create a PS_Pagination object
			//The paginate() function returns a mysql result set 
		
		$counter = 0;
		$FCount = 0;
		$InitDB->query($query);
		while ($friend = $InitDB->fetchNextObject()) {
			$FriendList[] = $friend->encryptid;
		}
		
		$query = "select u.encryptid, u.username, u.avatar 
				  from friends f 
				  left join users u 
				  on u.encryptid = f.UserID 
				  left join updates up 
				  on up.UserID = u.encryptid
				  where f.FriendID='$ID' and FriendType = 'fan' group by username order by $sort";
			//Create a PS_Pagination object
			//The paginate() function returns a mysql result set 
		
		$FriendArray = $InitDB->query($query);
		while ($friend = $InitDB->fetchNextObject()) { 
		
				 $FCount++;
		}
	
		$query = "select u.encryptid, u.username, u.avatar 
				  from friends f 
				  left join users u 
				  on u.encryptid = f.FriendID 
				  left join updates up 
				  on up.UserID = u.encryptid
				  where f.UserID='$ID' and FriendType = 'fan' group by username order by $sort";
			//Create a PS_Pagination object
	
		$FriendArray = $InitDB->query($query);
		while ($friend = $InitDB->fetchNextObject()) { 
		
			$FCount++;
		 }
		
		
		$query = "select u.encryptid, u.username, u.avatar 
				  from friends f 
				  left join users u 
				  on u.encryptid = f.FriendID 
				  left join updates up 
				  on up.UserID = u.encryptid
				  where f.UserID='$ID' and Accepted = 1 and FriendType = 'friend' and IsW3viewer = 1 group by username order by $sort";
			//Create a PS_Pagination object
			//The paginate() function returns a mysql result set 
	
		$FriendArray = $InitDB->query($query);
		while ($friend = $InitDB->fetchNextObject()) { 
			$FriendList[] = $friend->encryptid;
		
		 }
			
			

$PageTitle .= ' view event ' .$SubPageHeader;  

include 'includes/header_template_new.php';

$Site->drawUpdateCSS();
if ($_SESSION['IsPro'] == 1) 
           $_SESSION['noads'] = 1;

?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_myvolt_modules_css.css">

<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['noads'] == 1) {?> width="100%"<? }?>>
  <tr>
  
    <td valign="top"  <? if ($_SESSION['noads'] == 1) {?>style="padding:5px; color:#FFFFFF;width:60px;"<? } else {?> width="<? echo $SideMenuWidth;?>"<? }?>><? include   INCLUDES.'site_menu_inc.php';?></td>
     <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
         <center>
    
   <div class="sender_name">VIEW EVENT</div>
    	</center>
         </div>
            
 	</td>
	
</tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>
</div>

