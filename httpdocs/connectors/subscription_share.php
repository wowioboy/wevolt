<? 

include_once($_SERVER['DOCUMENT_ROOT'].'/includes/init.php');

if ($_POST['save'] == 1) {
	$query = "SELECT * from pf_subscriptions where UserID='".$_SESSION['userid']."' and (SubscriptionType ='hosted' or SubscriptionType ='fan') and Status='pending'";
	$SubArray = $InitDB->queryUniqueObject($query);	
	$SubID = $SubArray->ID;
	$SelectedProjects = @explode(',',$_POST['selectedprojects']);
	$RemovedProjects = @explode(',',$_POST['removedprojects']);	
	//print $_POST['selectedprojects'].'<br/>';
	
	foreach($SelectedProjects as $project) {
		if ($project != '') {
			$query = "SELECT count(*) from subscription_shares where user_id='".$_SESSION['userid']."' and project_id='".$project."' and subscription_id='$SubID'";	
			$Found = $InitDB->queryUniqueValue($query);
			if ($Found == 0) {
				$query = "INSERT into subscription_shares (user_id, project_id,created_date, subscription_id, status) values ('".$_SESSION['userid']."','".$project."',now(),'$SubID','active')";	
				$InitDB->execute($query);	
				//print $query.'<br/>';
			} else {
				$query = "UPDATE subscription_shares set status='active', created_date='".date('Y-m-d h:i:s')."' where user_id='".$_SESSION['userid']."' and project_id='".$project."' and subscription_id='$SubID'";	
				$InitDB->execute($query);	
				//print $query.'<br/>';
			}
		}
	}
	
	foreach($RemovedProjects as $project) {
		if ($project != '') {
			$query = "UPDATE subscription_shares set status='inactive', removed_date='".date('Y-m-d h:i:s')."' where user_id='".$_SESSION['userid']."' and project_id='".$project."' and subscription_id='$SubID'";	
			$InitDB->execute($query);	
		//	print $query.'<br/>';
		}
	}
}
$query = "SELECT ps.*, p.thumb, p.title
           from subscription_shares as ps
		   join projects as p on (ps.project_id=p.ProjectID and ProjectType != 'forum')
		    where ps.user_id='".$_SESSION['userid']."' and ps.status='active'";
$InitDB->query($query);
while ($line = $InitDB->fetchNextObject()) {
		if ($IDList == '')
			$IDList = $line->project_id;
		else
			$IDList .= ','.$line->project_id;
			
		$ProjectList .= '<img src="http://www.wevolt.com/'.$line->thumb.'" tooltip="'.$line->title.'" vspace="5" hspace="5" style="border:1px #000000 solid;" width="50" id="invite_'.$line->project_id.'" onclick="uninvite_user(\''.$line->project_id.'\',\'invite_'.$line->project_id.'\');" class="navbuttons">';
	
}
if ($ProjectList == '') 
	$ProjectList ='You have not assigned any projects.';
$TotalShares = $InitDB->numRows();
$AvailableShares = (2 - $TotalShares);

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Update Subscrioption Shares</title>
<meta http-equiv="content-language" content="en" /><meta name="language" content="en" />
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript" src="http://www.wevolt.com/ajax/ajax_init.js"></script>
<style type="text/css">
/* <![CDATA[ */
textarea { clear: both; font-family: sans-serif; font-size: 1em; width: 275px;}
/* ]]> */
</style>



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
	
	
	 var content =  document.modform.txtContent.value;

    var url="/connectors/getSearchResults.php";
    url=url+"?content="+content+"&keywords="+escape(keywords)+"&section=shares";
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
	if (keywords != '') 
   		 timer = window.setTimeout(display_data(keywords), 2000); // Set it for 2 seconds
    //Just leave the method and let the timer do the rest...
}

function submit_form() {
			
	if (document.getElementById("selectedprojects").value == '') 
		alert('Please atleast 1 project to support');
	else 
		document.modform.submit();

}

	
function set_content(title, contentid, contentlink, contentthumb,contenttype,description,tags) {
		
		var SelectedUsers = document.getElementById("selectedprojects").value;
		var AvailableShares = document.getElementById("availableshares").value;
		
		if (AvailableShares != 0) {
			
		
		
			var html;
			var formgood = 0;
			var userok = 1;
			var currentsetinvitesArray = SelectedUsers.split(',');
			var arLen=currentsetinvitesArray.length;
			
			for ( var i=0, len=arLen; i<len; ++i ){
				if (contentid == currentsetinvitesArray[i]) {
					userok = 0;
					
					alert('This project is already getting your support');
							break;	
				}
						
			}
			
		
		
			var newpass = '<a href="javascript:void(0);" onclick="remove_user(\''+contentid+'\',\''+contenttype+'\',\'userselected_'+contentid+'\');"><img src="'+contentthumb+'" vspace="5" hspace="5" style="border:2px #ff0000 solid;" width="50"  id="userselected_'+contentid+'"></a>';
		
			
			if (userok == 1) {
					
					if (SelectedUsers != '')
						SelectedUsers = SelectedUsers+','+contentid;
					else
						SelectedUsers = contentid;
				
					formgood = 1;
						
					html = document.getElementById("shares_div").innerHTML;
					if (AvailableShares == 2)
						html = '';	
					
					AvailableShares = (AvailableShares - 1);
					document.getElementById("availableshares").value = AvailableShares;
										
					document.getElementById("selectedprojects").value = SelectedUsers;
					
					var divtarget = 'shares_div';
				
					if (formgood == 1) {
						document.getElementById("save_projects").style.display='';
						html += newpass;
						document.getElementById(divtarget).innerHTML = html;
						if (document.getElementById("savealert") != null)
						document.getElementById("savealert").style.display = 'block';
					}
			}
		

		} else {
			alert('You already have two projects selected');
			
		}
}


function remove_user(uid, type, element) {
	document.getElementById(element).style.display='none';
	var currentinvites = document.getElementById("selectedprojects").value;
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
			var AvailableShares = document.getElementById("availableshares").value;
			AvailableShares = (AvailableShares + 1);
			document.getElementById("availableshares").value = AvailableShares;
			document.getElementById("selectedcreators").value = currentinvites_temp;
			if (document.getElementById("savealert")!= null)
			document.getElementById("savealert").style.display = 'block';
}
function uninvite_user(uid, element) {
	var answer = confirm("Are you sure you want to remove this project from your subscription?");
	if (answer) {
		document.getElementById(element).style.display='none';
		var currentuninvites = document.getElementById("removedprojects").value;

		if (currentuninvites == '')
			currentuninvites = uid;
		else 
			currentuninvites = currentinvites +','+uid;
		document.getElementById("removedprojects").value = currentuninvites;
		
		if (document.getElementById("savealert") != null)
			document.getElementById("savealert").style.display = 'block';
			alert(document.getElementById("removedprojects").value);
		var AvailableShares = document.getElementById("availableshares").value;
		
			AvailableShares = (AvailableShares + 1);
		document.getElementById("availableshares").value = AvailableShares;
		
		
		document.getElementById("save_projects").style.display='';
		
			
	}
}


  function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
 }
 
 function setDefault(theText) 
{
     if (theText.value == "")
 {
         theText.value = theText.defaultValue;
     }
 }

</script>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
  <LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="modform" id="modform" method="post" action="#">
              
   <div>
                                         
<div style="height:10px;"></div>

                                       <table><tr><td valign="top">
                                        <table width="375" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="366" align="left" height="300">
                                      Type the name of a project that you'd like to support.
                                      <div class="messageinfo_warning" style="font-style:italic;">(creators, this cannot be your own project)</div>
<div id="searchupload"  style="font-size:12px;" class="messageinfo">
<div style="height:10px;"></div>

<table cellpadding="0" cellspacing="0" border="0" width="98%">
<tr>
<td><input type="text" style="width:98%;" id="txtSearch" name="txtSearch" value="Search for project" onFocus="doClear(this);" onBlur="setDefault(this);" onkeyup="checkIt(this.value);">
<div style="height:3px;"></div>
<select name="txtContent" id="txtContent" style="font-size:10px;">
<option  value="comic"> Comics / Projects</option>
<option  value="forum"> Forum Boards</option>
<option  value="blog"> Blogs</option>
</select>
<div style="height:3px;"></div>


</td>
</tr>
</table>

<div id="search_container" style="display:none;">
    <div class="messageinfo_yellow"><strong>SEARCH RESULTS</strong></div>
    <div style="height:3px;"></div>
    <div id="search_results" style="height:118px; overflow:auto;width:98%;"></div>
</div>
</div>


  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        </td><td valign="top"> <table width="375" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="366" align="left" height="300">
                         
                                       <div class="messageinfo_white" style="font-style:italic;">
You can do this step later in the 'SETTINGS' section of your MYvolt page and can change them monthly.</div>
<div style="height:10px;"></div>
<center><div class="messageinfo_white" id="save_projects" style="display:none;"><a href="javascript:void(0)" onclick="submit_form();"/>[SAVE SELECTION]</a> </div><div style="height:5px;"></div></center>
<div style="height:10px;"></div>
<div id="shares_div" class="messageinfo_white">Selected Projects / Creators
<div style="height:10px;"></div>
<div class="messageinfo_warning" align="center">
<? echo $ProjectList;?>
</div>

</div>
<div style="height:10px;"></div>
                                         </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                                        </td></tr></table>

</div>

<input type="hidden" name="save" value="1" />
<input type="hidden" name="selectedprojects" id="selectedprojects" value="<? echo $IDList;?>" />
<input type="hidden" name="availableshares" id="availableshares" value="<? echo $AvailableShares;?>" />
<input type="hidden" name="removedprojects" id="removedprojects" value="" />

</form>

</body>
</html>