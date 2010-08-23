<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$TrackPage = 1;
?>
<? 

include 'includes/message_functions.php';
include 'includes/myvolt_functions.php';  
if ($_SESSION['userid'] == '')
	header("Location:http://users.wevolt.com/".$_GET['name']."/");

if (trim($_SESSION['username']) != $_GET['name'])
	header("Location:http://users.wevolt.com/".$_GET['name']."/");
	
$MyVolt = 1;?>
<?php 
$UsersDirectory = $_SERVER['DOCUMENT_ROOT'].'/users/';
if(!is_dir($UsersDirectory. trim($_SESSION['username']))) { 
	@mkdir($UsersDirectory.trim($_SESSION['username'])); chmod($UsersDirectory.trim($_SESSION['username']), 0777); 
	@mkdir($UsersDirectory.trim($_SESSION['username'])."/avatars"); chmod($UsersDirectory.trim($_SESSION['username'])."/avatars", 0777);
	@mkdir($UsersDirectory.trim($_SESSION['username'])."/pdfs"); chmod($UsersDirectory.trim($_SESSION['username'])."/pdfs", 0777); 
	@mkdir($UsersDirectory.trim($_SESSION['username'])."/media"); chmod($UsersDirectory.trim($_SESSION['username'])."/media", 0777); 
				copy ($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.trim($_SESSION['username'])."/avatars/index.html");
				copy ($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.trim($_SESSION['username'])."/index.html");
				copy ($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.trim($_SESSION['username'])."/pdfs/index.html");
				copy ($_SERVER['DOCUMENT_ROOT']."/usersource/index_redirect.html",$UsersDirectory.trim($_SESSION['username'])."/media/index.html");
}

if ($_SESSION['userid'] == 'd67d8ab427') {
//$_SESSION['username'] = 'fishcapades'; 
  // $_SESSION['avatar'] = 'http://www.wevolt.com/users/rbr/avatars/rbr.jpg';
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

//mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
//mysql_select_db ($userdb) or die ('Could not select database.');
$UserName = $_GET['name'];

$query = "select * from users where username='$UserName'";
$user = $InitDB->queryUniqueObject($query);
  
if ($UserName == trim($_SESSION['username'])) {
	$ID = trim($_SESSION['userid']);
	$UserID = $ID;
	$Email =   $_SESSION['email'];
	$FeedOfTitle = $_SESSION['username'];
	 $Username = $user->username;
     $Avatar = $user->avatar;

} else {
   header("Location:http://users.wevolt.com/".$_SESSION['username']."/");

}

/*
if ($_GET['btnsubmit'] == 'Yes') {
	$FriendID = $ID;
	addfriend($UserID, $FriendID,$userhost, $dbuser,$userpass,$userdb);
	header("location:/myvolt/".$UserName."/");
} else if ($_GET['btnsubmit'] == 'No'){
	header("location:/myvolt/".$UserName."/");
}
*/
$insertComment = $_POST['insert'];
$deleteComment = $_POST['deletecomment'];

if ($insertComment == '1')
	CommentProfile(trim($_SESSION['username']), trim($_SESSION['userid']), $ID, $_POST['txtFeedback'], date('D M j'), $_SERVER['REMOTE_ADDR']);

if ($deleteComment == '1')
	DeleteProfileComment($_POST['commentid']);

if ($_POST['deletefav'] == 1)
	deletefavorite(trim($_POST['comicid']), trim($_POST['favid']), trim($_SESSION['userid']));

$newMsg = "";
$query = "select count(*) from messages where userid='$ID' and isread=0";
$UnreadMSgs = $InitDB->queryUniqueValue($query);

if ($UnreadMSgs > 0)
	$newMsg = "<div align='center' style='color:#ff0000;'>(".$UnreadMSgs.") UNREAD</div>";


if ($_POST['savestatus'] == '1'){
	$StatusText = mysql_real_escape_string($_POST['txtStatus']);
	$UserID = $_SESSION['userid'];
	$query ="UPDATE users set Status='$StatusText' where encryptid='$UserID'";
	$InitDB->execute($query);
}

 

if ($_POST['edit'] == 1) {
	include 'includes/profile_edit_save_functions.php';
}
    
	
	
	
if ($_GET['t'] == 'profile') {
	include 'includes/profile_edit_select_functions.php';
	
}
////ACCOUNT SETTINGS
if ($_GET['t'] == 'settings') {
		
		$query ="SELECT * from pf_subscriptions where UserID='".$_SESSION['userid']."' and Status='active'";	 
		$InitDB->query($query);
		
		while ($purchase = $InitDB->fetchNextObject()) {
			$TypeID= $purchase->TypeID;
			if ($purchase->SubscriptionType == 'hosted')
				$SubType = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=payments%40wowio%2ecom">[cancel]</a>&nbsp;&nbsp;Pro Account - $5/month';
			else if ($purchase->SubscriptionType == 'store')
				$SubType = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_subscr-find&alias=payments%40wowio%2ecom">[cancel]</a>&nbsp;&nbsp;Store Component - $2/month';
			$purchaseString .='<div>'.$SubType.'</div>';
			
		}
		
		$query = "SELECT * from purchases where UserID='".$_SESSION['userid']."' and Completed = 0";	 
		$InitDB->query($query);
		while ($purchase = $InitDB->fetchNextObject()) { 
			$unfinishedpurchaseString .='<div>Purchase Type: '.$purchase->Type.' | Started Date = '.$purchase->Start.'</div>';
		}
		
		
		$query = "SELECT * from pf_subscription_types where ID='$TypeID'";
		$SubArray = $InitDB->queryUniqueObject($query);
		$SubscriptionName = $SubArray->Name;
		$SubDescription = $SubArray->Description;
		$SubPrice = $SubArray->Price;
		
		$query = "SELECT * from users_settings where UserID='".$_SESSION['userid']."'";
		$USettingsArray = $InitDB->queryUniqueObject($query);
		
		$query = "SELECT * from users_data where UserID='".$_SESSION['userid']."'";
		$UDataArray = $InitDB->queryUniqueObject($query);
}


//FRINEDS LIST
# accept or ignore a request
if ($requestAction = $_POST['request_action']) {
	$requestid = $_POST['requestid'];
	$query = "select * from friends where ID = '$requestid'";
	$friendEntry = $InitDB->queryUniqueObject($query);
	switch ($requestAction) {
		case 'accept':
			$query = "update friends set Accepted = '1', AcceptedDate = now(),FriendType='friend' where UserID = '{$friendEntry->UserID}' and FriendID = '{$friendEntry->FriendID}'";
			$InitDB->query($query);
			$query = "update friends set Accepted = '1', FriendType='friend', AcceptedDate = now() where UserID = '{$friendEntry->FriendID}' and FriendID = '{$friendEntry->UserID}'";
			$InitDB->query($query);
			break; 
		case 'ignore':
			$query = "update friends set FriendType = 'system' where UserID = '{$friendEntry->UserID}' and FriendID = '{$friendEntry->FriendID}'";
			$InitDB->query($query);
			$query = "update friends set FriendType = 'system' where UserID = '{$friendEntry->FriendID}' and FriendID = '{$friendEntry->UserID}'";
			$InitDB->query($query);
			break;
	}
}
if (($_GET['t'] == 'network') || ($_GET['t'] == 'feed')) {
		include 'includes/profile_network_feed_functions.php';
}
		
$query ="SELECT * from messages where isread=0 and userid='$ID'";
$InitDB->query($query);
$NumMessages = $InitDB->numRows();

$MailMessage = '('.$NumMessages.') unread mail';

if ($_GET['a'] == 'fbsync')
	$SubPageHeader = '- FB SYNC';
	
if ($_GET['t'] == 'profile')
	$SubPageHeader = '- PROFILE';
	
if ($_GET['t'] == 'network')
	$SubPageHeader = '- NETWORK';
	
if ($_GET['t'] == 'settings')
	$SubPageHeader = '- SETTINGS';
if ($_GET['t'] == 'feed')
	$SubPageHeader = '- FEED';
if ($_GET['t'] == 'volts')
	$SubPageHeader = '- VOLT MANAGER';
if ($_GET['t'] == 'forum')
	$SubPageHeader = '- FORUM';
if ($_GET['t'] == 'mailbox')
	$SubPageHeader = '- weMAIL';
if ($_GET['t'] == '')
	$SubPageHeader = '- DASH';


$PageTitle .= ' myvolt ' .$SubPageHeader;  

include 'includes/header_template_new.php';


$Site->drawUpdateCSS();
?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_myvolt_modules_css.css">



<script type="text/javascript">

	function rolloveractive(tabid, divid) {
	var divstate = document.getElementById(divid).style.display;
			if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='myvolttabhover';
			} 
	}
	function rolloverinactive(tabid, divid) {
			if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='myvolttabinactive';
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
			document.getElementById(TabArray[i]+'_menu').style.display = 'none';
			if (TabArray[i] != SelectedModule) {
				document.getElementById(TabArray[i]+'_div').style.display = 'none';
				document.getElementById(TabArray[i]+'_star').style.display = 'none';
			} else{
				document.getElementById(SelectedModule+'_div').style.display = '';
				document.getElementById(SelectedModule+'_star').style.display = '';
				
			}
			
		}
		
		
		
}


<? if (($_GET['t'] == 'groups') && ($_GET['a'] != '')) {?>

delete_group(value) {
	
	var answer = confirm('Are you sure you want to delete this group?');
	if (answer) {
		
		attach_file('http://www.wevolt.com/connectors/delete_user_group.php?gid='+value);
		document.location.href='/myvolt/<? echo $_SESSION['username'];?>/?t=groups';
	}	
	
}
<? }?>
	</script>
    
    <style type="text/css">

div.workarea { padding:10px; float:left }

ul.draglist { 
    position: relative;
    width: 200px; 
	height:232px;
    list-style: none;
    margin:0;
    padding:0;
	overflow:scroll;
}

ul.draglist li {

    cursor: move;
    zoom: 1;
}

ul.draglist_alt { 
    position: relative;
    width: 200px;  
    list-style: none;
    margin:0;
    padding:0;
    /*
       The bottom padding provides the cushion that makes the empty 
       list targetable.  Alternatively, we could leave the padding 
       off by default, adding it when we detect that the list is empty.
    */
padding-bottom:20px;
}

ul.draglist_alt li {
    margin: 0px;
    cursor: move; 
}
-->
</style>


<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
 <td valign="top"  <? if (($_SESSION['IsPro'] == 1) || ($_SESSION['ProInvite'] == 1)) {?>style="width:60px;"<? } else {?> width="<? echo $SideMenuWidth;?>" <? }?> id="sidebar_div">
			<? include 'includes/site_menu_inc.php';?>
    
		</td> 
   
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
         <center>
    
    <table width="721">
   
    <tr>
   <td style="background:url(http://www.wevolt.com/images/my_volt_bar.png); background-repeat:no-repeat; height:21px; width:721px;" align="center"><? if ($_GET['t'] != '') {?><a href='/myvolt/<? echo trim($_SESSION['username']);?>/'><img src="http://www.wevolt.com/images/myvolt_off.png" border="0" id="myvolt" onmouseover="roll_over(this, 'http://www.wevolt.com/images/myvolt_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/myvolt_off.png')"></a><? 
   } else {?><img src="http://www.wevolt.com/images/myvolt_on.png" border="0"><? }?><? if ($_GET['t'] != 'calendar') {?><a href='/myvolt/<? echo trim($_SESSION['username']);?>/?t=calendar'><img src="http://www.wevolt.com/images/calendar_off.png" border="0" id="cal" onmouseover="roll_over(this, 'http://www.wevolt.com/images/my_calendar_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/calendar_off.png')"></a><? } else {?><img src="http://www.wevolt.com/images/calendar_on.png" border="0"  /><? }?><? if ($_GET['t'] != 'mailbox') {?><a href='/myvolt/<? echo trim($_SESSION['username']);?>/?t=mailbox'><img src="http://www.wevolt.com/images/wemail_off.png" border="0" id="mail" onmouseover="roll_over(this, 'http://www.wevolt.com/images/wemail_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/wemail_off.png')"></a><? } else {?><img src="http://www.wevolt.com/images/wemail_on.png" border="0"  /><? }?><a href='http://www.wevolt.com/w3forum/<? echo trim($_SESSION['username']);?>/'><img src="http://www.wevolt.com/images/forum_off.png" border="0" id="forum" onmouseover="roll_over(this, 'http://www.wevolt.com/images/forum_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/forum_off.png')"></a><? if ($_GET['t'] != 'feed') {?><a href='http://www.wevolt.com/updates.php'><img src="http://www.wevolt.com/images/feed_off.png" border="0" id="feed" onmouseover="roll_over(this, 'http://www.wevolt.com/images/feed_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/feed_off.png')"></a><? } else {?><img src="http://www.wevolt.com/images/feed_on.png" border="0"  /><? }?><? if ($_GET['t'] != 'volts') {?><a href='/myvolt/<? echo trim($_SESSION['username']);?>/?t=volts'><img src="http://www.wevolt.com/images/volts_off.png" border="0" id="volt" onmouseover="roll_over(this, 'http://www.wevolt.com/images/volts_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/volts_off.png')"></a><? } else {?><img src="http://www.wevolt.com/images/volts_on.png" border="0"  /><? }?><? if ($_GET['t'] != 'network') {?><a href='/myvolt/<? echo trim($_SESSION['username']);?>/?t=network'><img src="http://www.wevolt.com/images/networks_off.png" border="0" id="network" onmouseover="roll_over(this, 'http://www.wevolt.com/images/networks_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/networks_off.png')"></a><? } else {?><img src="http://www.wevolt.com/images/networks_on.png" border="0"  /><? }?><? if ($_GET['t'] != 'profile') {?><a href='/myvolt/<? echo trim($_SESSION['username']);?>/?t=profile'><img src="http://www.wevolt.com/images/profile_off.png" border="0" id="profile" onmouseover="roll_over(this, 'http://www.wevolt.com/images/profile_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/profile_off.png')"></a><? } else {?><img src="http://www.wevolt.com/images/profile_on.png" border="0"  /><? }?><? if ($_GET['t'] != 'settings') {?><a href='/myvolt/<? echo trim($_SESSION['username']);?>/?t=settings'><img src="http://www.wevolt.com/images/settings_off.png" border="0" id="settings" onmouseover="roll_over(this, 'http://www.wevolt.com/images/settings_over.png')" onmouseout="roll_over(this, 'http://www.wevolt.com/images/settings_off.png')"></a><? } else {?><img src="http://www.wevolt.com/images/settings_on.png" border="0"  /><? }?>
   </td>
    </tr>

    </table>
    </center>
	<div class="spacer"></div>
    <div style="width:721px;">
    <?php if ($_GET['t'] == 'calendar') : ?>
      <table width="721" cellpadding="0" cellspacing="0" border="0">
           <tr>
             <td align="left" width="80" height="20" style="background-image:url(http://www.wevolt.com/images/myvolt_base_left.png); background-repeat:no-repeat; font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;color:#15528e;">
               &nbsp;&nbsp;&nbsp;&nbsp;CALENDAR<div style="height:1px;"></div>
             </td>
             <td style="background-image:url(http://www.wevolt.com/images/myvolt_base_bg.png); background-repeat:repeat-x;" width="600" align="right">
              
             </td>
             <td style="background-image:url(http://www.wevolt.com/images/myvolt_base_right.png); background-repeat:no-repeat; background-position:right;" width="21" align="left"></td>
           </tr>
         </table>
  <?php 
if ($view = $_REQUEST['view']) {
	if ($view == 'week') {
		$view = 'agendaWeek';
	} elseif ($view == 'day') {
		$view = 'agendaDay';
	}
} else {
	$view = 'month';
}
if (!$date = $_REQUEST['date']) {
	$date = date('Y-m-d');
}
$date = explode('-', $date);
$year = $date[0];
$month = $date[1]-1;
$day = $date[2];  
  ?>
    <script>
$(document).ready(function() {
	var eventArray = new Array();
	$('#calendar').fullCalendar({
		theme: true,
		header: {
			left:   'prev,next today add edit trash',
	    	center: 'title',
	    	right:  'sort month,basicWeek,basicDay'
		},
		defaultView: '<?php echo $view; ?>',
		year: '<?php echo $year; ?>',
		month: '<?php echo $month; ?>',
		date: '<?php echo $day; ?>',
		allDayDefault: false,
		userid: '<? echo $_SESSION['userid'];?>',
		events: '/ajax/events.php',
		eventRender: function(event, element, view) {
			var html = '<a  href="javascript:void(0)" onclick="view_event(\'view\',\''+event.id+'\');">';
			element.attr('eventid', event.id);
			element.attr('encryptid', event.encrypt_id);
			element.addClass(event.type);
			if (view.name == 'month') {
				if ( event.thumb ) {
					html += '<img src="' + event.thumb + '" width="25" height="25" />';
				} else {
					html += '<div style="font-size:10px;"><b><i>' + event.title + '</i></b></div>';
				}
			} else if (view.name == 'basicWeek') {
				if ( event.thumb ) {
					html += '<div><img src="' + event.thumb + '" width="50" height="50" /></div>';
				}
			    html += '<div><span style="font-size:10px;">' + $.fullCalendar.formatDate(event.start, 'h:mm tt');
				if (event.end) {
					html += ' - ' + $.fullCalendar.formatDate(event.end, 'h:mm tt');
				}
				html += '</span></div><div style="font-size:10px;">';
				html += '<b><i>' + event.title + '</i></b>';
				html += '</div>';
			}else if (view.name == 'basicDay') {
				html += '<table cellspacing="0" cellpadding="0"><tr>';
				if ( event.thumb ) {
					html += '<td width="50" valign="top"><div><img src="' + event.thumb + '" width="40" height="40" hspace="5"/></div></td>';
				}
				html += '<td width="150" valign="top" style="background-color:#e5e5e5; border:1px #666666 solid; padding:2px;overflow:hidden;height:40px;"><div style="overflow:hidden;height:40px;">';
				html += '<div style="font-size:10px;"><b><i>' + event.title + '</i></b></div></div></td></tr></table>';
			}
			html += '</a>';
			element.html(html);
	    },
		eventAfterRender: function(event, element, view) {
	    	element.draggable({
				revert: true,
				helper: 'clone',
				appendTo: 'body',
				opacity: .5
			});
			if (view.name == 'month') {
				element.qtip({
					content: '<div>' + $.fullCalendar.formatDate(event.start, 'h:mm tt') + ' - ' + event.type + '</div><hr /><div><b><i>' + event.title + '</i></b></div><div>' + event.description + '</div>',
					position: {
						target: 'mouse',
						adjust: {
							screen: true
						}
					},
					style: {
						name: 'blue'
					}
				});
			} else if (view.name == 'basicWeek') {
				element.qtip({
					content: '<div>' + event.type + '</div><hr /><div>' + event.description + '</div>',
					position: {
						target: 'mouse',
						adjust: {
							screen: true
						}
					},
					style: {
						name: 'blue'
					}
				});
			} else if (view.name == 'basicDay') {
				element.qtip({
					content: '<div>' + event.type + '</div><hr /><div>' + event.description + '</div>',
					position: {
						target: 'mouse',
						adjust: {
							screen: true
						}
					},
					style: {
						name: 'blue'
					}
				});
			
			}
	    }
	});
	$('#calendar_selector').change(function(value){
		$('#calendar').fullCalendar('type', $(this).val()); 
		$('#calendar').fullCalendar('refetchEvents');
	});
	$('#cal_add_button').click(function(){
		open_event_wizard('add');
	});
	$('#cal_trash_button').qtip({
		content: 'Drag events here to delete them.',
		position: {
			target: 'mouse',
			adjust: {
				screen: true
			}
		},
		style: {
			name: 'blue'
		}
	});
	$('#cal_edit_button').qtip({
		content: 'Drag events here to edit them.',
		position: {
			target: 'mouse',
			adjust: {
				screen: true
			}
		},
		style: {
			name: 'blue'
		}
	});
	$('#cal_trash_button').droppable({
		tolerance: 'pointer',
		over: function() {
			$(this).attr('src', 'http://www.wevolt.com/images/silk/trash_on.png');
		},
		out: function() {
			$(this).attr('src', 'http://www.wevolt.com/images/silk/trash_off.png');
		},
		drop: function(event, ui) {
			var ans = confirm('are you sure you want to delete this event?');
			if (ans) {
				$.post('/ajax/events.php', {action: 'delete', id: ui.draggable.attr('eventid')}, function() {
					$('#calendar').fullCalendar('refetchEvents');
				});
			}
			$(this).attr('src', 'http://www.wevolt.com/images/silk/trash_off.png');
		}
	});
	$('#cal_edit_button').droppable({
		tolerance: 'pointer',
		over: function() {
			$(this).attr('src', 'http://www.wevolt.com/images/silk/edit_on.png');
		},
		out: function() {
			$(this).attr('src', 'http://www.wevolt.com/images/silk/edit_off.png');
		},
		drop: function(event, ui) {
			$(this).attr('src', 'http://www.wevolt.com/images/silk/edit_off.png');
			open_event_wizard('edit', ui.draggable.attr('encryptid'));
		}
	});
});
</script>
<div id="calendar"></div>
    <?php endif; ?>
    <div id="myvolt_div" <? if (isset($_GET['t'])) {?>style="display:none;"<? }?>>
    
    <? 
	
if (!isset($_GET['t'])) {

	//print $query.'<br/>';
	$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.UserID='$UserID' and f.FeedType='my'";
	$FeedArray = $InitDB->queryUniqueObject($query);

    $FeedID = $FeedArray->EncryptID;

if ($FeedID == '') {
	$NOW = date('Y-m-d h:i:s');
		$query = "INSERT into feed (Title, UserID, IsPublic, IsActive, CreatedDate, FeedType) values ('My Volt', '".$_SESSION['userid']."', 0, 1, '$NOW', 'my')";
		$InitDB->execute($query);
		$query ="SELECT ID from feed WHERE UserID='".$_SESSION['userid']."' and CreatedDate='$NOW'";
		$NewID = $InitDB->queryUniqueValue($query);
		$Encryptid = substr(md5($NewID), 0, 12).dechex($NewID);
		$query = "UPDATE feed SET EncryptID='$Encryptid' WHERE ID='$NewID' and UserID='".$_SESSION['userid']."'";
		$InitDB->execute($query);
		$query = "INSERT into feed_settings (FeedID, TemplateID, Module1Title, Module2Title) values ('$Encryptid', '3', 'Excite', 'Headlines')";
		$InitDB->execute($query);
		$query = "SELECT f.Title as FeedTitle, f.Thumb as FeedThumb, ft.HtmlLayout, f.EncryptID from feed as f 
			  join feed_settings as fs on f.EncryptID=fs.FeedID
			  join feed_templates as ft on ft.ID=fs.TemplateID 
			  where f.UserID='$UserID' and f.FeedType='my'";
		$FeedArray = $InitDB->queryUniqueObject($query);

    	$FeedID = $FeedArray->EncryptID;
		
}
$FeedTemplate = $FeedArray->HtmlLayout;
$TotalLength = strlen($FeedTemplate);
$CurrentPosition = 0;
$WorkingString = $FeedTemplate;
	
$StillGoing = true;
$CellIDArray = array();
$MainWindowIDs = array();
while ($StillGoing) {
			$StartPosition = strpos($WorkingString, "id=\"");
			$TempString = substr($WorkingString,$StartPosition+4, $TotalLength-1);
			$WalkingPosition = 0; 
			$EndPosition = strpos($TempString, "\">");
			$CellID = substr($TempString,$WalkingPosition, $EndPosition);
			if ($CellID != '')
			$CellIDArray[] = $CellID;
			$CurrentPosition = $EndPosition;
			$WorkingString = substr($TempString,$EndPosition,$TotalLength-1);
			$NewLength = strlen($WorkingString);
			if ($NewLength < 36)
				$StillGoing = false;
			
}


$query = "SELECT * from feed_settings where FeedID='$FeedID'";
$SettingsArray = $InitDB->queryUniqueObject($query);

$TemplateID = $SettingsArray->TemplateID;	
$query = "SELECT * from feed_templates where ID='$TemplateID'";
$TemplateArray = $InitDB->queryUniqueObject($query);


$ModuleTitleArray = array(array(
								'Title'=>$SettingsArray->Module1Title,
								'Width'=>$TemplateArray->Mod1Width,
								'Height'=>$TemplateArray->Mod1Height,
								'Template'=>$TemplateArray->Mod1Template,
								'Tabs'=>$TemplateArray->Mod1Tabs),
							array(
								'Title'=>$SettingsArray->Module2Title,
								'Width'=>$TemplateArray->Mod2Width,
								'Height'=>$TemplateArray->Mod2Height,
								'Template'=>$TemplateArray->Mod2Template,
								'Tabs'=>$TemplateArray->Mod2Tabs),
							array(
								'Title'=>$SettingsArray->Module3Title,
								'Width'=>$TemplateArray->Mod3Width,
								'Height'=>$TemplateArray->Mod3Height,
								'Template'=>$TemplateArray->Mod3Template,
								'Tabs'=>$TemplateArray->Mod3Tabs),
							array(
								'Title'=>$SettingsArray->Module4Title,
								'Width'=>$TemplateArray->Mod4Width,
								'Height'=>$TemplateArray->Mod4Height,
								'Template'=>$TemplateArray->Mod4Template,
								'Tabs'=>$TemplateArray->Mod4Tabs),
							array(
								'Title'=>$SettingsArray->Module5Title,
								'Width'=>$TemplateArray->Mod5Width,
								'Height'=>$TemplateArray->Mod5Height,
								'Template'=>$TemplateArray->Mod5Template,
								'Tabs'=>$TemplateArray->Mod5Tabs),
							array(
								'Title'=>$SettingsArray->Module6Title,
								'Width'=>$TemplateArray->Mod6Width,
								'Height'=>$TemplateArray->Mod6Height,
								'Template'=>$TemplateArray->Mod6Template,
								'Tabs'=>$TemplateArray->Mod6Tabs),
							array(
								'Title'=>$SettingsArray->Module7Title,
								'Width'=>$TemplateArray->Mod7Width,
								'Height'=>$TemplateArray->Mod7Height,
								'Template'=>$TemplateArray->Mod7Template,
								'Tabs'=>$TemplateArray->Mod7Tabs),
							array(
								'Title'=>$SettingsArray->Module8Title,
								'Width'=>$TemplateArray->Mod8Width,
								'Height'=>$TemplateArray->Mod8Height,
								'Template'=>$TemplateArray->Mod8Template,
								'Tabs'=>$TemplateArray->Mod8Tabs)
					);

$ModuleIndex=0;

foreach ($CellIDArray as $Cell) {

		$CellString = '';
				$CellString .= build_cell($line->Title,$line->ModuleTemplate, $line->EncryptID, $FeedID, $UserID, $Cell, $line->SortVariable,$line->ContentVariable, $line->SearchVariable, $line->SearchTags, $line->Variable1, $line->Variable2, $line->Variable3, $line->Custom, $line->NumberVariable, $line->ThumbSize);
		
		$FeedTemplate=str_replace("{".$Cell."}","<div style='padding-left:10px;padding-right:10px;'>".$CellString."</div>",$FeedTemplate);
		$FeedTemplate=str_replace("{".$Cell."Width}",$ModuleTitleArray[$ModuleIndex]['Width'],$FeedTemplate);
				
		$FeedTemplate=str_replace("{".$Cell."Height}",$ModuleTitleArray[$ModuleIndex]['Height'],$FeedTemplate);
		$ModuleIndex++;


}


}
	
	?>
     <? if (!isset($_GET['t'])) {?>
        <? echo $FeedTemplate;?>
    <? }?>
    </div>
    
    
    <div id="feed_div" <? if ($_GET['t'] != 'feed') {?>style="display:none;"<? }?> align="center">
     <? if ($_GET['t'] == 'feed') {?>
   <? echo $updateString;?>	
      <? }?>
    </div>
    
    <div id="volts_div" <? if ($_GET['t'] != 'volts') {?>style="display:none;"<? }?> align="center">
    <? if ($_GET['t'] == 'volts') {?>
    <iframe src="/get_volts.php" width="770" height="725" frameborder="0" scrolling="no" allowtransparency="yes"></iframe>						 
    <? }?>
    </div>
    
     <div id="mail_div" <? if ($_GET['t'] != 'mailbox') {?>style="display:none;"<? }?> align="center">
     <? if ($_GET['t'] == 'mailbox') {?>
    <iframe src="/mailbox.php" width="675" height="605" frameborder="0" scrolling="no" allowtransparency="yes"></iframe>			
    <? }?>
    </div>
  
     <div id="forum_div" <? if ($_GET['t'] != 'forum') {?>style="display:none;"<? }?> align="center">
       <? if ($_GET['t'] == 'forum') {?>
    <iframe src="http://www.wevolt.com/forum/inline_index.php?user=<? echo $_GET['name'];?>&frame=true" width="800" height="850" frameborder="0" scrolling="auto" id="forumframe" name="forumframe" allowtransparency="yes"></iframe>						 <? }?>
    
    </div>
    
      <div id="profile_div" <? if ($_GET['t'] != 'profile') {?>style="display:none;"<? }?> align="center">
      <? if ($_GET['t'] == 'profile') {?>
  <? include 'includes/profile_inc.php';}?>
  
    
    </div>
    <? if ($_GET['t']=='groups') { ?>

	<table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                                        <img src="http://www.wevolt.com/images/wizard_groups_title.png" vspace="8"/>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
	<div class="spacer"></div>
  <div style="width:592px; text-align:right;" class="messageinfo_white"><? if (($_GET['a'] == 'new')||($_GET['a'] == 'edit')){?><a href="/myvolt/<? echo $_SESSION['username'];?>/?t=groups">[LIST GROUPS]</a><? } else { echo 'LIST GROUPS';}?>&nbsp;&nbsp;<? if (($_GET['a'] != 'new')&&($_GET['a'] != 'edit')){?><a href="/myvolt/<? echo $_SESSION['username'];?>/?t=groups&a=new">[NEW]</a><? } else if ($_GET['a'] == 'edit'){ echo 'EDIT GROUP';} else { echo 'NEW GROUP';}?></div>

                                          <? if (($_GET['a'] == 'new')||($_GET['a'] == 'edit')) {?>
											  
											<iframe src="/includes/edit_groups_inc.php?a=<? echo $_GET['a'];?>&gid=<? echo $_GET['gid'];?>" width="700" height="500" allowtransparency="true" style="border:none;" scrolling="no"></iframe>
											 <?   } else {?>
                                             		<table width="592" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="576" align="center">
                                        <? $query = "select  * from user_groups where UserID='".$_SESSION['userid']."'"; 
											$InitDB->query($query);

											echo '<table width="100%" cellpadding="5" cellspacing="10"><tr>';
											echo '<td ><strong>TITLE</strong></td><td class="messageinfo_white" width="200"><strong>DESCRIPTION</strong></td><td class="messageinfo_white" width="75"><strong>USERS</strong></td><td class="messageinfo_white" width="100"><strong>ACTIONS</strong></td></tr>';
											while($line = $InitDB->fetchNextObject()) {
												echo '<tr><td valign="top" class="messageinfo_white"><b>';
												echo $line->Title;
												echo '</b></td>';
												echo '<td width="200" class="messageinfo_white">';
												echo $line->Description;
												echo '</td>';
												
												$GroupUsers = @explode(',',$line->GroupUsers);
												if ($GroupUsers == null)
													$GroupUsers = array();
												$TotalUsers = sizeof($GroupUsers);
												echo '<td width="75" class="messageinfo_warning">';
												echo $TotalUsers . ' user';
												if ($TotalUsers != 1)
													echo 's';
												echo '</td>';
												echo '<td class="messageinfo_white" width="100">';
												echo '<a href="/myvolt/'.$_SESSION['username'].'/?t=groups&a=edit&gid='.$line->ID.'">EDIT</a>&nbsp;&nbsp;<a href="javascript:void(0)" onClick="delete_group(\''.$line->ID.'\');">DELETE</a>';
												echo '</td>';
												echo '</tr>';
											}
											echo '</table>';?>
                                            
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                                            <? }?>

                        
	
<? } ?>
     <div id="settings_div" <? if ($_GET['t'] != 'settings') {?>style="display:none;"<? }?> align="center">
     <table width="721" cellpadding="0" cellspacing="0" border="0">
           <tr>
             <td align="left" width="80" height="20" style="background-image:url(http://www.wevolt.com/images/myvolt_base_left.png); background-repeat:no-repeat; font-size:11px; font-family:Verdana, Arial, Helvetica, sans-serif; font-weight:bold;color:#15528e;">
               &nbsp;&nbsp;&nbsp;&nbsp;SETTINGS<div style="height:1px;"></div>
             </td>
             <td style="background-image:url(http://www.wevolt.com/images/myvolt_base_bg.png); background-repeat:repeat-x;" width="600" align="right">
              
             </td>
             <td style="background-image:url(http://www.wevolt.com/images/myvolt_base_right.png); background-repeat:no-repeat; background-position:right;" width="21" align="left"></td>
           </tr>
         </table>
     <? if ($_GET['t'] == 'settings') {?>
  <? include 'includes/account_settings_inc.php';}?>
    
    </div>
  
    
    
    <div id="networks_div" <? if ($_GET['t'] != 'network') {?>style="display:none;"<? }?>>
    
     <? if ($_GET['t'] == 'network') {?>
     <img src="http://www.wevolt.com/images/networks_base.png" />
     
    <table cellpadding="0" cellspacing="0" border="0"><tr>
   <td valign="top" colspan="5" style="padding:10px; color:#FFF;">
   <table width="100%"><tr><td width="150"><form id="sortform" method="post">
 
   Sort by:&nbsp;
   <select name="network_sort" id="network_sort" onchange="$('#sortform').submit();">
     <option value="username" <?php echo ($_POST['network_sort'] == 'username') ? 'selected' : ''; ?>>Alphabetical</option>
     <option value="Created" <?php echo ($_POST['network_sort'] == 'Created') ? 'selected' : ''; ?>>Added Date</option>
     <option value="CreatedDate" <?php echo ($_POST['network_sort'] == 'CreatedDate') ? 'selected' : ''; ?>>Updates</option>
   </select>
   </span>
   </form>
   </td><td class="messageinfo_white" style="padding-left:10px; padding-top:8px;" align="right"><a href="/myvolt/<? echo $_SESSION['username'];?>/?t=groups"><img src="http://www.wevolt.com/images/manage_groups.png" border="0"/></a>&nbsp;&nbsp;<a href="javascript:void(0)" onclick="invite_friends();"><img src="http://www.wevolt.com/images/INVITE_off.png" border="0"/></a>&nbsp;&nbsp;</td></tr></table>
   </td></tr>
   <tr><td valign="top">
   
   
  <table border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="modtopleft"></td>

	<td id="modtop" width="199"><img src="http://www.wevolt.com/images/friends_header.png" /></td><td id="modtopright" valign="top" align="right"></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

	<? echo $friendString;?>
	</td>
	<td id="modrightside"></td>

	</tr>
    <tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
	</table>
	
	</td>
</tr>


</table>

	</td>
    <td width="10"></td>
   <td> 
 	<table border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td id="modtopleft"></td>

			<td id="modtop" width="199"><img src="http://www.wevolt.com/images/weviewers_header.png" /></td><td id="modtopright" valign="top" align="right"></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

	<? echo $w3viewString;?>
	</td>
	<td id="modrightside"></td>

	</tr>
    <tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
	</table>
	
	</td>
</tr>


</table>
    </td>
   <td rowspan="3" width="10"></td> <td rowspan="3" >
   
   <table border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td id="fatmodtopleft"></td>

			<td id="fatmodtop" width="199"><select name="requests_select" id="requests_select"><option value="requests">requests</option></select></td><td id="fatmodtopright" valign="top" align="right"></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

	 <div style="height:537px;width:230px;overflow:auto;" align="center">
     <?php echo $RequestString; ?>
     </div>
	</td>
	<td id="modrightside"></td>

	</tr><tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
	</table>
	
	</td>
    </tr>
    </table></td>
   </tr>
   <tr>
   <td height="10" colspan="3">
   </td>
   </tr>
   <tr>
   <td valign="top">
     <table border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td id="modtopleft"></td>

			<td id="modtop" width="199"><img src="http://www.wevolt.com/images/fans_header.png" /></td><td id="modtopright" valign="top" align="right"></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

	 <? echo $fanString;?>
	</td>
	<td id="modrightside"></td>

	</tr>
    <tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
	</table>
	
	</td>
</tr>


</table>


  </td>
   <td width="10"></td>
   <td valign="top">
    	<table border="0" cellspacing="0" cellpadding="0">
        <tr>
			<td id="modtopleft"></td>

			<td id="modtop" width="199"><img src="http://www.wevolt.com/images/celebrities_header.png" /></td><td id="modtopright" valign="top" align="right"></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

	   <? echo $celebString;?>
	</td>
	<td id="modrightside"></td>

	</tr><tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
	</table>
	
	</td>
</tr>


</table>

</td>
  </tr>


</table></td>
   </tr></table>
<? }?>


    		</center>
            </div>
            
 	</td>
	
</tr>
</table>
</div>
<? 
/*
$wCount = 0;
if ($CellIDArray == null)
	$CellIDArray = array();
foreach ($CellIDArray as $Cell) {?>

	
		<script type="text/javascript">
			document.getElementById('<? echo $Cell;?>_menu').innerHTML = document.getElementById('<? echo $MainWindowIDs[$wCount];?>_menu_wrapper').innerHTML;
		</script>
		
		



<? $wCount++;} */?>

<?php include 'includes/footer_template_new.php';
$InitDB->close();?>
</div>

