<?php
if ($_GET['name'] == 'facebook') 
	header("location:/facebook/index.php");
	
if (($_GET['name'] == 'mattjacobs') ||($_GET['name'] == 'matthewjacobs') ||($_GET['name'] == 'panelflow')||($_GET['name'] == 'mattj')||($_GET['name'] == 'mjacobs')||($_GET['name'] == 'theunlisted'))
	header("location:/matteblack/");

if (($_GET['name'] == 'jasonb') ||($_GET['name'] == 'jbadower') ||($_GET['name'] == 'grael23'))
	header("location:/jasonbadower/");

include 'includes/init.php';
include 'includes/message_functions.php';
include 'includes/w3volt_functions.php';

$Name = $_GET['name'];
$ProjectType = $_GET['type'];


$MainWindowIDs = array();
//if ($ProjectType == '') {

	$query = "select * from users where username='$Name'"; 
	$ItemArray = $InitDB->queryUniqueObject($query);
	$UserID = $ItemArray->encryptid;
	$Email =   $ItemArray->email;
	$FeedOfTitle = $ItemArray->username;
	$FeedThumb = $ItemArray->avatar;
	//print $query.'<br/>';
	//print $query.'<br/>';
	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.UserID='$UserID' and f.FeedType='w3'";
	$FeedArray = $InitDB->queryUniqueObject($query);

    $FeedID = $FeedArray->EncryptID;



if ($_GET['s'] == 'portfolio'){
	include_once('classes/gallery.php');
	$Gallery = new gallery();
	$PortfolioID = $Gallery->getPortfolioID($UserID);
}



if (($FeedID == '') && ($_SESSION['username'] == trim($_GET['name']))) {
	$NOW = date('Y-m-d h:i:s');
		$query = "INSERT into feed (Title, UserID, IsPublic, IsActive, CreatedDate, FeedType) values ('WEvolt page', '".$_SESSION['userid']."', 0, 1, '$NOW', 'w3')";
		$InitDB->execute($query);
		$query ="SELECT ID from feed WHERE UserID='".$_SESSION['userid']."' and CreatedDate='$NOW'";
		$NewID = $InitDB->queryUniqueValue($query);
		$Encryptid = substr(md5($NewID), 0, 12).dechex($NewID);
		$query = "UPDATE feed SET EncryptID='$Encryptid' WHERE ID='$NewID' and UserID='".$_SESSION['userid']."'";
		$InitDB->execute($query);
		$query = "INSERT into feed_settings (FeedID, TemplateID, Module1Title, Module2Title, Module3Title, Module4Title) values ('$Encryptid', '1', 'Window 1', 'Window 2','Window 3','Window 4')";
		$InitDB->execute($query);
		$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.UserID='$UserID' and f.FeedType='w3'";
		$FeedArray = $InitDB->queryUniqueObject($query);

    	$FeedID = $FeedArray->EncryptID;
		
}

if ($FeedID == '') 
	$NotSetup = 1;
else 
	$NotSetup=0;
//} else {
/*
	$query = "select * from projects where SafeTitle='$Name' and ContentType='$ProjectType'";
	$ItemArray = $DB->queryUniqueObject($query);
	$UserID = $UserArray->UserID;
	$ProjectID =  $UserArray->ProjectID;
	$FeedOfTitle = $ItemArray->SafeTitle;

	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.ProjectID='$ProjectID'";
	  
	$FeedArray = $DB->queryUniqueObject($query);
	
	
}*/



$query = "select count(*) from friends where (FriendID='$UserID' and UserID='".$_SESSION['userid']."') and Accepted=1 and FriendType='friend'";
$IsFriend = $InitDB->queryUniqueValue($query);
if ($IsFriend == 0) {
	$query = "select count(*) from friends where (FriendID='$UserID' and UserID='".$_SESSION['userid']."') and Accepted=0 and FriendType='friend'";
	$Requested = $InitDB->queryUniqueValue($query);
	$query = "select count(*) from follows where user_id='".$_SESSION['userid']."' and follow_id='$UserID' and type='user'";
	$IsFan = $InitDB->queryUniqueValue($query);
} else {
	$IsFan = 0;
}
if ($UserID == $_SESSION['userid'])
	$IsOwner = true;
else 
	$IsOwner = false;
if (($IsFriend == 0) || ($IsFriend == '')) {
	$IsFriend = false;
} else {
	$IsFriend = true;
}

if (($IsFan == 0) || ($IsFan == '')) {
	$IsFan = false;
} else {
	$IsFan = true;
}

if ($_GET['post'] != '') {
	//include_once($_SERVER['DOCUMENT_ROOT'].'/includes/comment_functions.php');
	$BlogOwner = $UserID;
	}
if ($_POST['insert'] == '1'){
	$Comment = new comment();
	if(($_SESSION['security_code'] == $_POST['security_code'] && !empty($_SESSION['security_code'] )) || ($_SESSION['userid'] == '')) {
		unset($_SESSION['security_code']);
		setcookie("seccode", "", time()+60*60*24*100, "/");
		if ($_POST['txtFeedback'] == ''){
			$_SESSION['commenterror'] = 'You need to enter a comment';
		} else if (($_SESSION['userid'] == '') && ($_POST['txtName'] == '')){
			$_SESSION['commenterror'] = 'Please enter a name';
		} else {
			if ($_SESSION['userid'] == '')
				$CommentUserID = 'none';
			else 
				$CommentUserID = trim($_SESSION['userid']);
			
			$CommentUsername = addslashes($_POST['txtName']);
		
			
				$Comment->blogComment($Section,$ProjectID, $_POST['targetid'], $CommentUserID, $_POST['txtFeedback'],$CommentUsername);?>
       
                 <script type="text/javascript">
					window.parent.location = 'http://users.wevolt.com/<? echo $_GET['name'];?>/?t=blog&post=<? echo $_GET['post'];?>';
                    </script>
		<?
			
		}
   } else {
		$_SESSION['commenterror'] = 'invalid security code. Try Again.';
   }
}

if (($_GET['tab'] == 'profile') || (($DefaultView=='profile') && ($_GET['tab'] == '')) || (($DefaultView=='') && ($_GET['tab'] == ''))) {
	if ($DefaultView == '')
		$DefaultView = 'profile';
            
	if ($_POST['edit'] == 1) {
		include 'includes/profile_edit_save_functions.php';
	}
		
		
		
		
	if (($_GET['tab'] == 'profile') || ($DefaultView == 'profile')) {
		//include 'includes/profile_edit_select_functions.php';
		
	}
}

if ($_GET['t'] == '')
	$SubTitle = 'wevolt page';
else 
	$SubTitle = $_GET['t'];
	
$PageTitle = 'wevolt | '.$FeedOfTitle.' - '.$SubTitle;
$FeedID = $FeedArray->EncryptID;


$query = "select distinct e.Blurb, e.ContentID, e.ContentType, e.CreatedDate, e.Comment, e.Target, e.Link, u.avatar, u.username, p.thumb as ProjectThumb, e.thumb as ExciteThumb
		 				 			 from excites as e
		 				 			 left join users as u on (e.ContentID=u.encryptid and e.ContentType='user')
						 			left join projects as p on (e.ContentID=p.ProjectID and ProjectID!='')
									where e.UserID='$UserID' order by e.CreatedDate DESC";
									$ExciteArray = $InitDB->queryUniqueObject($query);

	 $query = "select * from users_profile where UserID='$UserID'";
	 $where = " and ((PrivacySetting='public')";
	 if ($IsOwner) 
	 	$where .= " or (PrivacySetting ='friends') or (PrivacySetting ='fans') or (PrivacySetting ='private') ";
		
	 else if ($IsFriend)
	 	$where .= " or (PrivacySetting ='friends') or (PrivacySetting ='fans') ";
	 else if ($IsFan)
	 	$where .= " or (PrivacySetting ='fans') ";

	$where .=")";
	
	 $query .= $where ." order by InfoType, ID";
     $InitDB->query($query);
	 $LastType = '';
	
	 while ($profile = $InitDB->FetchNextObject()){
	 //	print $profile->RecordID.'<br/>';
		 switch($profile->RecordID) {
		 		case 'profile_blurb':
					  $ProfileBlurb = stripslashes($profile->LongComment);
					  $ProfileBlurbPrivacy = $profile->PrivacySetting;
					   $BasicInfo = true;
					  break;
				case 'sex':
					  $Sex = stripslashes($profile->LongComment);
					  $SexPrivacy = $profile->PrivacySetting;
					   $BasicInfo = true;
					  break;
				case 'about_me':
					  $About = stripslashes($profile->LongComment);
					  $AboutPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'hometown_location':
					  $HometownLocation = stripslashes($profile->LongComment);
					  $HometownLocationPrivacy = $profile->PrivacySetting;
					  $BasicInfo = true;
					  break;
				case 'current_location':
					  $Location = stripslashes($profile->LongComment);
					  $LocationPrivacy = $profile->PrivacySetting;
					   $BasicInfo = true;
					  break;
				case 'activities':
					  $Hobbies = stripslashes($profile->LongComment);
					  $HobbiesPrivacy = $profile->PrivacySetting;
					  $PersonalInfo = true;
					  break;
				case 'music':
					  $Music = stripslashes($profile->LongComment);
					  $MusicPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'movies':
					  $Movies = stripslashes($profile->LongComment);
					  $MoviesPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'books':
					  $Books = stripslashes($profile->LongComment);
					  $BooksPrivacy = $profile->PrivacySetting;
					  break;
				case 'tv':
					  $TVShows = stripslashes($profile->LongComment);
					  $TVShowsPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'interests':
					  $Interests = stripslashes($profile->LongComment);
					  $InterestsPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'website':
					  $Website = stripslashes($profile->LongComment);
					  $WebsitePrivacy = $profile->PrivacySetting;
					   $ContactInfo = true;
					  break;
				case 'profile_url':
					  $FaceUrl = stripslashes($profile->LongComment);
					  $FaceUrlPrivacy = $profile->PrivacySetting;
					  $ContactInfo = true;
					  break;
				case 'education_history':
					  $Education = stripslashes($profile->LongComment);
					  $EducationPrivacy = $profile->PrivacySetting;
					   $CreditsInfo = true;
					  break;
				case 'work_history':
					  $WorkHistory = stripslashes($profile->LongComment);
					  $WorkHistoryPrivacy = $profile->PrivacySetting;
					   $CreditsInfo = true;
					  
					  break;
				case 'twitter_name':
					  $TwitterName = stripslashes($profile->LongComment);
					  $TwitterNamePrivacy = $profile->PrivacySetting;
					   $ContactInfo = true;
					  break;
				case 'influences':
					  $Influences = stripslashes($profile->LongComment);
					  $InfluencesPrivacy = $profile->PrivacySetting;
					   $PersonalInfo = true;
					  break;
				case 'credits':
					  $Credits = stripslashes($profile->LongComment);
					  $CreditsPrivacy = $profile->PrivacySetting;
					  $CreditsInfo = true;
					  break;
				case 'phone':
					  $Phone = stripslashes($profile->LongComment);
					  $PhonePrivacy = $profile->PrivacySetting;
					  $ContactInfo = true;
					  break;
				case 'self_tags':
					  $SelfTags = stripslashes($profile->LongComment);
					  break;
				case 'birthday_date':
					  $Birthday = $profile->LongComment;
					  $BirthdayPrivacy = $profile->PrivacySetting;
					   $BasicInfo = true;
					  break;
				case 'screennames':
					  $ScreenNames = stripslashes($profile->LongComment);
					  $ScreenNamesPrivacy = $profile->PrivacySetting;
					   $ContactInfo = true;
					  break;

		 }
	 }
	 
	  if (($Birthday == '') || (strlen($Birthday) < 5)) 
	  	  $Birthdate = explode('-',$user->birthdate);
	 else
	 	  $Birthdate = explode('-',$Birthday);
	 $BirthdayDay =$Birthdate[1];
	 $BirthdayMonth =$Birthdate[0];
	 $BirthdayYear =$Birthdate[2];
	 
	 if ($Music == '')
	 	$Music = stripslashes($user->music);
		
	 if ($Location == '')
 		 $Location = stripslashes($user->location);
		 
 	 if ($Books == '')
		 $Books = stripslashes($user->books);
		 
 	 if ($Hobbies == '')
		 $Hobbies = stripslashes($user->hobbies);
		 
 	 if ($Website == '') 	 
	 	 $Website= $user->website;
	 if ($About == '')
	    $About = stripslashes($user->about);
	 if ($Influences == '')
	   $Influences = $user->influences;
	 if ($TwitterName == '')
		 $TwitterName  = $user->Twittername; 
	if ($Credits == '') 
	 	$Credits = stripslashes($user->credits);
	 	   
	 $Status = $user->Status;
	 $TwitterCount = $user->TwitterCount;
	
	 if (substr($Website,0,3) == 'www') {
	 	$Website = 'http://'.$Website;
	 }
		
	 $IsCreator = $user->iscreator;
	 
	 
	 $Link1 = $user->link1;
	 if (substr($Link1,0,3) == 'www') {
	 	$Link1 = 'http://'.$Link1;
	 }
	 $Link2 = $user->link2;
	  if (substr($Link2,0,3) == 'www') {
	 	$Link2 = 'http://'.$Link2;
	 }
	 $Link3 = $user->link3;
	  if (substr($Link3,0,3) == 'www') {
	 	$Link3 = 'http://'.$Link3;
	 }
	 $Link4 = $user->link4;
	  if (substr($Link4,0,3) == 'www') {
	 	$Link4 = 'http://'.$Link4;
	 }
 	 if ($Sex == '')
	 	$Sex = $user->gender;
		
	 $AllowComments = $user->allowcomments;
	 $HostedAccount = $user->HostedAccount;


/*
//TWITTER MODULE 
<div align="left" style="padding-right:10px;">
    <? if ($Twittername != '') {?>
    <div id="twitter_div" style="width:100%; padding-right:10px;">
<div class="sidebar-title">Twitter Updates</div>
<div id="twitter_update_list"></div>
<div class="menubar"><a href="http://twitter.com/<? echo $Twittername;?>" id="twitter-link" style="display:block;text-align:right;">follow me on Twitter</a></div>
<div class="spacer"></div>
</div>
*/	 

$TrackPage = 1;

if ($IsFriend)
	$FriendStatus = 'Friend';
else if ($IsFan)
	$FriendStatus = 'Following';
else if ($Requested > 0)
	$FriendStatus = 'Requested';
else if (!$IsOwner)
	$FriendStatus = 'Add';
else 
	$FriendStatus = '';

$InitDB->close();

if ($DefaultView == '')
	$DefaultView = 'profile';
?>

<?php include_once('includes/pagetop_inc.php');
$Tracker = new tracker();
$Remote = $_SERVER['REMOTE_ADDR'];
$IsUser = true;
$Referal = urlencode(substr($_SERVER['HTTP_REFERER'],7,strlen($_SERVER['HTTP_REFERER'])-1));
$Tracker->insertPageView($UserID,$Pagetracking,$Remote,$_SESSION['userid'],$Referal,$_SESSION['returnlink'],$_SESSION['IsPro'],$IsCMS,$IsUser);	

//$Site->drawModuleCSS();?>
<script 
  src="http://www.wevolt.com/scripts/twitterjs.js"
  type="text/javascript">
</script>

<script type="text/javascript">
function twitterCallback2(twitters) {
  		var statusHTML = [];
  		for (var i=0; i<twitters.length; i++){
    		var username = twitters[i].user.screen_name;
			var status = twitters[i].text.replace(/((https?|s?ftp|ssh)\:\/\/[^"\s\<\>]*[^.,;'">\:\s\<\>\)\]\!])/g, 		function(url) {
		  return '<a href="'+url+'">'+url+'</a>';
		}).replace(/\B@([_a-z0-9]+)/ig, 
		
		function(reply) {
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



function mod_tab(value) {
	//alert(value);
   //GRAB CURRENT GROUP ID OF SELECTED DROPDOWN
	var moduletarget= value.split('-');
	var ModuleParent = moduletarget[0];
	
	var SelectedModule = moduletarget[1];
	//document.getElementById(ModuleParent+'_menu').innerHTML = document.getElementById(SelectedModule+'_menu_wrapper').innerHTML;
	
	var ModuleList = document.getElementById(ModuleParent+'_tabs').value;
	var TabArray = ModuleList.split(',');
	
		for(i=0; i<TabArray.length; i++){
			//alert('MODULE ID' + TabArray[i]);
			
			if (TabArray[i] != SelectedModule) {
				document.getElementById(TabArray[i]+'_div').style.display = 'none';
				document.getElementById(TabArray[i]+'_star').style.display = 'none';
				
			} else{
				document.getElementById(SelectedModule+'_div').style.display = '';
				document.getElementById(SelectedModule+'_star').style.display = '';
				
			}
			
		}

}

function show_menu(value) {
	document.getElementById(value).style.display = '';
			
}
function follow(ProjectID,UserID,Type) {
 
	attach_file('http://www.wevolt.com/connectors/follow_content.php?fid='+ProjectID+'&type='+Type); 
	document.getElementById("follow_project_div").innerHTML = '<img src="<? echo $_SESSION['avatar'];?>" width="50" height="50" border="2">';
	
}
</script>

<div align="left">
<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <? $Site->drawControlPanel('100%');?>
            </div>
        <? }?>
 <?  if ((($_SESSION['IsPro'] == 1) || ($_SESSION['ProInvite'] == 1) || ($_SESSION['IsSuperFan'] == 1)) && ($_SESSION['sidebar'] == 'closed')) {?>
 <div id="pronav">
                <? $Site->drawProNav('100%');?>
 </div>
 <? }?>       

	<table cellpadding="0" cellspacing="0" border="0" id="container" width="100%">

	<tr><? if (($_SESSION['IsPro'] == 1) || ($_SESSION['ProInvite'] == 1)) {
				$_SESSION['noads'] = 1;
			$FlashHeight = 1;
	} else {
			$_SESSION['noads'] = 0;
			$FlashHeight = 90;	
	} 
		?> 
        <? if ($_SESSION['sidebar'] == 'open') {?>
		<td valign="top" id="sidebar">
			<?  include 'includes/sidebar_inc.php';?>
		</td> 

        <? }?>
        <td  valign="top" align="<? if ($_SESSION['sidebar'] == 'open') {?>left<? } else {?>center<? }?>"  <? if ($_SESSION['sidebar'] == 'open') {?>rowspan="2"<? }?> valign="top">
        
        
		 <? 
	 if ($_SESSION['noads'] == 0) {?>

				  <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
           <? }?>
           <div class="spacer"></div>
         <table width="<? echo $_SESSION['contentwidth'];?>" cellpadding="0" cellspacing="0">
         	<tr>
                 <td colspan="2" bgcolor="#fff" >
                 <? $Site->drawMyvoltNav($_SESSION['contentwidth'],$FeedOfTitle,$FeedThumb);?>
                   <div style="padding:10px;">
                    <table width="100%">
                        <tr>
                            <td width="100">
                            <? if (($_GET['tab'] == 'profile') || (($_GET['tab'] == '') && ($DefaultView=='profile'))) {?>
                            <img src="http://www.wevolt.com/images/about_header.png" />
                            <? }?>
                            </td>
                            <td align="left">&nbsp;<div id="save_alert" style="display:none;"><img src="http://www.wevolt.com/images/save_yellow_box.png" class="navbuttons" /></div></td>
                            <td width="50" align="right">
                            <img src="http://www.wevolt.com/images/excite_header.png" /><br />
                            <div class="small_blue_links">
                            <a href="/<? echo $FeedOfTitle;?>/?tab=excites">archives</a>&nbsp;<a href="javascript:void(0)" onclick="update_excite('');">edit</a>
                            </div>
                            </td>
                            <td width="280">
                            <? include 'modules/excite_single.php';?>
                            </td>
                        </tr>
                    </table>
                   <div class="spacer"></div>
					<div id="myvolt_content">
                     <? if (($_GET['tab'] == 'profile') || (($_GET['tab'] == '') && ($DefaultView=='profile'))) {
                                     if ($_GET['a'] == 'fbsync') {?>
                                     <center>
									 	<iframe src="http://www.wevolt.com/facebook/sync.php" frameborder="0" width="700" height="680" scrolling="no"></iframe>
                                        </center>
									<? } else {
								    	include 'includes/myvolt_about_inc.php';
									 }
                                }?>
                                
                    
                    </div>
                                 
                  </div>
                </td>
        	</tr>
            <tr>
                <td class="white_foot_left">&nbsp;</td>
                <td class="white_foot_right">&nbsp;</td>
            </tr>
        </table>
        
        
		</td>
        
	</tr>
    
     <? if ($_SESSION['sidebar'] == 'open') {?><tr>
    <td id="sidebar_footer"></td>
  </tr>
  <? }?>
  
</table>

</div>

<?php include 'includes/pagefooter_inc.php';

?>



