<? include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php');
$TrackPage = 0;

if ($_POST['save'] == 1) {
	$SelectedUsers = $_POST['currentinvites'];	
	$InviteUserList = $_POST['currentsetinvites'];
	
	if ($_POST['action'] == 'new') {
		$query = "INSERT into user_groups (UserID, Title, Description, GroupUsers) values ('".$_SESSION['userid']."','".mysql_real_escape_string($_POST['txtTitle'])."', '".mysql_real_escape_string($_POST['txtDescription'])."', '".$_POST['currentinvites']."')";
		$InitDB->execute($query);
	//	print $query;
	} else if ($_POST['action'] == 'edit') {
		$UserGroupList = $InviteUserList;
		if ($UserGroupList == '')
			$UserGroupList = $SelectedUsers;
		else if ($SelectedUsers != '')
			$UserGroupList .= ','.$SelectedUsers;
		$query = "UPDATE user_groups set Title='".mysql_real_escape_string($_POST['txtTitle'])."', Description='".mysql_real_escape_string($_POST['txtDescription'])."', GroupUsers ='$UserGroupList' where UserID='".$_SESSION['userid']."' and ID='".$_POST['gid']."'";
		$InitDB->execute($query);
		
	}
	?>
    <script type="text/javascript">
	parent.document.location.href="/myvolt/<? echo $_SESSION['username'];?>/?t=groups";
	</script>
    
    <? 
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="http://www.wevolt.com/ajax/ajax_init.js"></script>
<script language="JavaScript" type="text/javascript" src="http://www.wevolt.com/scripts/global_functions.js"></script>
<script type="text/javascript">

function stateChanged() 
{ 
if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 
 document.getElementById("search_results").innerHTML=xmlHttp.responseText;
 document.getElementById('search_container').style.display='';

 } 
}
function display_data(keywords) {

    xmlhttp=GetXmlHttpObject();
    if (xmlhttp==null) {
        alert ("Your browser does not support AJAX!");
        return;
    }
	var section ='groups';
	var content = 'groups';
	 var url="/connectors/getUserResults.php";
	
    url=url+"?content="+content+"&keywords="+escape(keywords)+"&section="+section;
	
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 || xmlhttp.readyState=="complete") {
            document.getElementById('search_results').innerHTML=xmlhttp.responseText;
			document.getElementById('search_container').style.display='';
        }
    }
    xmlhttp.open("GET",url,true);
    xmlhttp.send(null);
}	
var timer = null;
function checkIt(keywords) {

    if (timer) window.clearTimeout(timer); // If a timer has already been set, clear it
    timer = window.setTimeout(display_data(keywords), 2000); // Set it for 2 seconds
    //Just leave the method and let the timer do the rest...
}

var itemnum = 1;
function set_user(username, avatar, type,uid) {
	var html;
	var formgood = 0;
	var userok = 1;
	itemnum = itemnum+1;
	
	var newpass = '<a href="javascript:void(0);" onclick="remove_user(\''+uid+'\',\''+type+'\',\'userselected_'+itemnum+'\');"><img src="'+avatar+'" tooltip="'+username+'" vspace="5" hspace="5" style="border:2px #ff0000 solid;" width="50" height="50" id="userselected_'+itemnum+'"></a>';
	
	var currentinvites = document.getElementById("currentinvites").value;
	var currentinvitesArray = currentinvites.split(',');
	var currentsetinvites = document.getElementById("currentsetinvites").value;
	var currentsetinvitesArray = currentsetinvites.split(',');
    var arLen=currentsetinvitesArray.length;
	
	for ( var i=0, len=arLen; i<len; ++i ){
			if (uid == currentsetinvitesArray[i]) {
				userok = 0;
				alert('This user is already in the group');
				break;	
			}
					
	}
	var arLen=currentinvitesArray.length;
	for ( var i=0, len=arLen; i<len; ++i ){
		if (uid == currentinvitesArray[i]) {
			userok = 0;
			alert('This user is already selected to be in the group');
			break;	
		}
					
	}
	
	if (userok == 1) {
		formgood = 1;
					
		html = document.getElementById("invites_div").innerHTML;
						
		if (currentinvites == '')
			currentinvites = uid;
		else 
			currentinvites +=','+uid;
		
		document.getElementById("currentinvites").value = currentinvites;
						
		var divtarget = 'invites_div';
		
		if (formgood == 1) {
			html += newpass;
			document.getElementById(divtarget).innerHTML = html;
			document.getElementById("savealert").style.display = 'block';
		}
	}
		
}

function remove_user(uid, type, element) {
	document.getElementById(element).style.display='none';
	var currentinvites = document.getElementById("currentinvites").value;
	var currentinvitesArray = currentinvites.split(',');
	var currentinvites_temp;
	var arLen=currentinvitesArray.length;
		for ( var i=0, len=arLen; i<len; ++i ){
			if (uid != currentinvitesArray[i]) {
				if (currentinvites_temp == '')
					currentinvites_temp = currentinvitesArray[i];
				else 
					currentinvites_temp +=','+currentinvitesArray[i];
			}
					
		}
	document.getElementById("currentinvites").value = currentinvites_temp;
	document.getElementById("savealert").style.display = 'block';
}

function uninvite_user(uid, element) {
	var answer = confirm("Are you sure you want to remove this person from the group?");
	if (answer) {
		document.getElementById(element).style.display='none';
		var currentinvites = document.getElementById("currentsetinvites").value;
		var currentinvitesArray = currentinvites.split(',');
		var currentinvites_temp = '';
		var arLen=currentinvitesArray.length;
		for ( var i=0, len=arLen; i<len; ++i ){
			if (uid != currentinvitesArray[i]) {
				
				if (currentinvites_temp == '')
					currentinvites_temp = currentinvitesArray[i];
				else 
					currentinvites_temp +=','+currentinvitesArray[i];
			}
					
		}
	document.getElementById("currentsetinvites").value = currentinvites_temp;
	
	document.getElementById("savealert").style.display = 'block';
	}
}


</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<? 
if ($_GET['a'] == 'edit') {
$query = "SELECT g.* from user_groups as g  where ID='".$_GET['gid']."'";
$GroupArray = $InitDB->queryUniqueObject($query);
$GroupUsers = @explode(',',$GroupArray->GroupUsers);
	if ($GroupUsers == null)
		$GroupUsers = array();
	$TotalUsers = sizeof($GroupUsers);
	$CurrentGroupUsers = '';
	foreach($GroupUsers as $line) {
		$query = "SELECT u.username, u.avatar,u.encryptid from users as u where u.encryptid='".$line."'";
		$UserData = $InitDB->queryUniqueObject($query);
		if ($CurrentGroupUsers == '')
			$CurrentGroupUsers = $UserData->encryptid;
		else
			$CurrentGroupUsers .= ','.$UserData->encryptid;
			
		$UserList .= '<img src="'.$UserData->avatar.'" tooltip="'.$UserData->username.'" vspace="5" hspace="5" style="border:1px #000000 solid;" width="50" height="50" id="invite_'.$UserData->encryptid.'" onclick="uninvite_user(\''.$UserData->encryptid.'\',\'invite_'.$UserData->encryptid.'\');" class="navbuttons">';

		
		
	}
	
if ($CurrentGroupUsers == '')
	$UserList = 'You haven\'t added any users to this group. <br/>';	
}
?>
<body>
      <form method="post" action="#">  
<div class="spacer"></div>
             <div align="center">           
              
   <div>
   <div id="savealert" class="messageinfo_warning" style="display:none; font-size:14px;">You must SAVE for your changes to take effect<div style="height:5px;"></div></div>
<table><tr><td valign="top"> 

                                        <table width="300" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="284" align="center">
                               

  <div class="messageinfo_white">GROUP USERS<br />
Title:<br />
<input type="text" name="txtTitle" value="<? echo $GroupArray->Title;?>" style="width:100%"/><br />
Description:<br />
<textarea  name="txtDescription" style="width:100%; height:25px;"><? echo $GroupArray->Description;?></textarea>
  </div>
  <div class="spacer"></div>
<div class="messageinfo_warning">Type a WEvolt friend's email or username below:</div>

<table cellpadding="0" cellspacing="0" border="0" width="98%">
<tr>
<td><input type="text" style="width:98%;" id="txtSearch" name="txtSearch" value="username or email" onFocus="doClear(this);" onBlur="setDefault(this);" onkeyup="checkIt(this.value);">
<div style="display:none;">
<div style="height:3px;"></div>
<select name="txtContent" id="txtContent" style="font-size:10px;">
<option  value="wevolt_users"> WEvolt users</option>
<option  value="email"> Search for email</option>
</select>
<div style="height:3px;"></div>
</div>

</td>
</tr>
</table>

<div id="search_container" style="display:none;"><div class="messageinfo_yellow"><strong>SEARCH RESULTS</strong></div><div style="height:3px;"></div>
<div id="search_results" style="height:220px; overflow:auto;width:98%;"></div></div>
</div>


  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>

                        
                                        
                                        </td>
                                        <td></td>
                                        <td valign="top">
                                     
                                          <table width="330" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="314" align="center">
                                        <input type="submit" value="SAVE" />&nbsp;&nbsp; <input type="button" value="CANCEL" onclick="parent.window.location.href='/myvolt/<? echo $_SESSION['username'];?>/?t=groups';" />
                                        <div class="messageinfo_warning">User List</div>
                                        <div id="invites_div" style="height:280px; width:300px; overflow:auto;">
                                        
                                        <? echo $UserList;?>
                                        </div>
                                       
                                        </td><td class="wizardboxcontent"></td>
                
                                        </tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
                                        <td id="wizardBox_BR"></td>
                                        </tr></tbody></table>
                                                        
                                        
                                        </td>
                                      </tr></table>

<input type="hidden" name="save" value="1" />
<input type="hidden" name="currentinvites" id="currentinvites" value="" />
<input type="hidden" name="currentuninvites" id="currentuninvites" value="" />
<input type="hidden" name="currentsetinvites" id="currentsetinvites" value="<? echo $CurrentGroupUsers;?>" />
<input type="hidden" name="action" value="<? echo $_GET['a'];?>" />
<input type="hidden" name="gid" value="<? echo $_GET['gid'];?>" />
</div>



</div>
</form>
</body>
</html>
