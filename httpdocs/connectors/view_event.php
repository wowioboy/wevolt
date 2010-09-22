<?php
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$DB2 = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

function statedropdown() {
$ARRAY_STATES		    = array();
$ARRAY_STATES["AL"]	= "Alabama";
$ARRAY_STATES["AK"]	= "Alaska";
$ARRAY_STATES["AZ"]	= "Arizona";
$ARRAY_STATES["AR"]	= "Arkansas";
$ARRAY_STATES["CA"]	= "California";
$ARRAY_STATES["CO"]	= "Colorado";
$ARRAY_STATES["CT"]	= "Connecticut";
$ARRAY_STATES["DE"]	= "Delaware";
$ARRAY_STATES["DC"]	= "District Of Columbia";
$ARRAY_STATES["FL"]	= "Florida";
$ARRAY_STATES["GA"]	= "Georgia";
$ARRAY_STATES["HI"]	= "Hawaii";
$ARRAY_STATES["ID"]	= "Idaho";
$ARRAY_STATES["IL"]	= "Illinois";
$ARRAY_STATES["IN"]	= "Indiana";
$ARRAY_STATES["IA"]	= "Iowa";
$ARRAY_STATES["KS"]	= "Kansas";
$ARRAY_STATES["KY"]	= "Kentucky";
$ARRAY_STATES["LA"]	= "Louisiana";
$ARRAY_STATES["ME"]	= "Maine";
$ARRAY_STATES["MD"]	= "Maryland";
$ARRAY_STATES["MA"]	= "Massachusetts";
$ARRAY_STATES["MI"]	= "Michigan";
$ARRAY_STATES["MN"]	= "Minnesota";
$ARRAY_STATES["MS"]	= "Mississippi";
$ARRAY_STATES["MO"]	= "Missouri";
$ARRAY_STATES["MT"]	= "Montana";
$ARRAY_STATES["NE"]	= "Nebraska";
$ARRAY_STATES["NV"]	= "Nevada";
$ARRAY_STATES["NH"]	= "New Hampshire";
$ARRAY_STATES["NJ"]	= "New Jersey";
$ARRAY_STATES["NM"]	= "New Mexico";
$ARRAY_STATES["NY"]	= "New York";
$ARRAY_STATES["NC"]	= "North Carolina";
$ARRAY_STATES["ND"]	= "North Dakota";
$ARRAY_STATES["OH"]	= "Ohio";
$ARRAY_STATES["OK"]	= "Oklahoma";
$ARRAY_STATES["OR"]	= "Oregon";
$ARRAY_STATES["PA"]	= "Pennsylvania";
$ARRAY_STATES["RI"]	= "Rhode Island";
$ARRAY_STATES["SC"]	= "South Carolina";
$ARRAY_STATES["SD"]	= "South Dakota";
$ARRAY_STATES["TN"]	= "Tennessee";
$ARRAY_STATES["TX"]	= "Texas";
$ARRAY_STATES["UT"]	= "Utah";
$ARRAY_STATES["VT"]	= "Vermont";
$ARRAY_STATES["VA"]	= "Virginia";
$ARRAY_STATES["WA"]	= "Washington";
$ARRAY_STATES["WV"]	= "West Virginia";
$ARRAY_STATES["WI"]	= "Wisconsin";
$ARRAY_STATES["WY"]	= "Wyoming";

foreach ($ARRAY_STATES as $value) {
    $StateString .= '<OPTION VALUE="'.$value.'">'.$value;
}

return $StateString;

}


function convert_datetime($str) 
{

list($date, $time) = explode(' ', $str);
list($year, $month, $day) = explode('-', $date);
list($hour, $minute, $second) = explode(':', $time);

$timestamp = mktime($hour, $minute, $second, $month, $day, $year);

return $timestamp;
}
function hourmin($hid = "hour", $mid = "minute", $pid = "pm", $hval = "", $mval = "", $pval = "")
{
	if(empty($hval)) $hval = date("h");
	if(empty($mval)) $mval = date("i");
	if(empty($pval)) $pval = date("a");

	$hours = array(12, 1, 2, 3, 4, 5, 6, 7, 9, 10, 11);
	$out = "<td><select name='$hid' id='$hid'>";
	foreach($hours as $hour)
		if(intval($hval) == intval($hour)) $out .= "<option value='$hour' selected>$hour</option>";
		else $out .= "<option value='$hour'>$hour</option>";
	$out .= "</select></td>";

	$minutes = array("00","05", 10, 15, 20,25, 30,35,40, 45,50,55);
	$out .= "<td><select name='$mid' id='$mid'>";
	foreach($minutes as $minute)
		if(intval($mval) == intval($minute)) $out .= "<option value='$minute' selected>$minute</option>";
		else $out .= "<option value='$minute'>$minute</option>";
	$out .= "</select></td>";
	
	$out .= "<td><select name='$pid' id='$pid'>";
	$out .= "<option value='am'>am</option>";
	if($pval == "pm") $out .= "<option value='pm' selected>pm</option>";
	else $out .= "<option value='pm'>pm</option>";
	$out .= "</select></td>";
	
	return $out;
}

    function DateSelector($inName, $useDate='') 
    { 
        /* create array so we can name months */ 
        $monthName = array(1=> "January", "February", "March", 
            "April", "May", "June", "July", "August", 
            "September", "October", "November", "December"); 
 
        /* if date invalid or not supplied, use current time */ 
      
	    if($useDate == '') 
        { 
            $useDate = time(); 
        } else {
		 	$useDate = convert_datetime($useDate);
		}
 		
        /* make month selector */ 
        $string .= "<td><select name=" . $inName . "_month>\n"; 
        for($currentMonth = 1; $currentMonth <= 12; $currentMonth++) 
        { 
             $string .= "<OPTION VALUE=\""; 
			 if (strlen($currentMonth) <2)
			 	$string .= '0'.intval($currentMonth); 
            else 
			   $string .= intval($currentMonth); 
             $string .= "\""; 
            if(intval(date( "m", $useDate))==$currentMonth) 
            { 
                 $string .= " SELECTED"; 
            } 
             $string .= ">" . $monthName[$currentMonth] . "\n"; 
        } 
         $string .= "</SELECT></td>"; 
 
        /* make day selector */ 
         $string .= "<td><SELECT NAME=" . $inName . "_day>\n"; 
        for($currentDay=1; $currentDay <= 31; $currentDay++) 
        { 
             $string .= "<OPTION VALUE=\"";
			 
			  if (strlen($currentDay) <2)
			 	$string .= '0'.intval($currentDay); 
            else 
			   $string .= intval($currentDay); 
			 
			 
			 $string .="\""; 
            if(intval(date( "d", $useDate))==$currentDay) 
            { 
                 $string .= " SELECTED"; 
            } 
             $string .= ">$currentDay\n"; 
        } 
         $string .= "</SELECT></td>"; 
 
        /* make year selector */ 
         $string .= "<td><SELECT NAME=" . $inName . "_year>\n"; 
        $startYear = date( "Y", $useDate); 
        for($currentYear = $startYear; $currentYear <= $startYear+5;$currentYear++) 
        { 
             $string .= "<OPTION VALUE=\"$currentYear\""; 
            if(date( "Y", $useDate)==$currentYear) 
            { 
                 $string .= " SELECTED"; 
            } 
             $string .= ">$currentYear\n"; 
        } 
         $string .= "</SELECT></td>"; 
 return $string;
} 

 function DayDropdown($inName, $useDate='') 
    { 
      
	    if($useDate == '') 
        { 
            //$useDate = intval(date('d')); 
			$useDate = '0';
        } else {
		 $useDate = intval($useDate); 
		}
 		
             /* make day selector */ 
         $string .= "<SELECT NAME=" . $inName . ">\n"; 
		 $string .= "<option value='0'";
		 if ($useDate == '0')
		 	 $string .= "selected";
		$string .= ">--select--</option>";
        for($currentDay=1; $currentDay <= 31; $currentDay++) 
        { 
             $string .= "<OPTION VALUE=\"$currentDay\""; 
            if($useDate==$currentDay) 
            { 
                 $string .= " SELECTED"; 
            } 
             $string .= ">$currentDay\n"; 
        } 
         $string .= "</SELECT>"; 
 
        /* make year selector */ 
       
 return $string;
} 



$Action = $_REQUEST['action'];
$UserID = $_SESSION['userid'];
$EventID = $_REQUEST['id'];
$Auth = 0;


$query = "select * from users where encryptid='$UserID'"; 
$UserArray = $DB->queryUniqueObject($query);

$CloseWindow = 0;

$query = "select c.*,pc.promo_code, pc.xp 
          from calendar as c
		  left join promotion_codes as pc on pc.cal_id=c.id 
			 where c.id=".$_GET['id'];
$EventArray = $DB->queryUniqueObject($query);




$SelectedAccess = explode(',',$EventArray->selected_access);

if ($SelectedAccess == null)
	$SelectedAccess = array();

$query = "select count(*) from friends where (FriendID='".$EventArray->user_id."' and UserID='".$_SESSION['userid']."') and Accepted=1 and FriendType='friend'";
$IsFriend = $DB->queryUniqueValue($query);
if ($IsFriend == 0) {
	$query = "select count(*) from friends where (FriendID='".$EventArray->user_id."' and UserID='".$_SESSION['userid']."') and Accepted=0 and FriendType='friend'";
	$Requested = $DB->queryUniqueValue($query);
	$query = "select count(*) from friends where (FriendID='".$EventArray->user_id."' and UserID='".$_SESSION['userid']."') and ((FriendType='fan') or (PreviousType='fan' and Accepted=0 and FriendType='friend'))";
	$IsFan = $DB->queryUniqueValue($query);
} else {
	$IsFan = 0;
}
if ($EventArray->user_id == $_SESSION['userid'])
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
$Privacy = $EventArray->privacy_setting;
$query = "select count(*) from pf_events_invitations where CalID='".$_GET['id']."' and UserID='".$_SESSION['userid']."'";
$UserInvited = $DB->queryUniqueValue($query);
if ($IsOwner) {
	$Auth = 1;	
} else if ($Privacy == 'public'){ 
	$Auth = 1;	
}else if (($Privacy == 'friends') && (($IsFriend) || ($IsOwner))){
	$Auth = 1;
}else if (($Privacy == 'fans') && (($IsFriend) || ($IsOwner)|| ($IsFan))){
	$Auth = 1;	
}else if ($Privacy == 'groups'){
	$SelectedGroups = @explode(',',$EventArray->selected_groups);
	if ($SelectedGroups == null)
		 $SelectedGroups = array();
	foreach($SelectedGroups as $group) {
		$query = "SELECT GroupUsers from user_groups where ID='$group'";
		$GroupUsers = $DB->queryUniqueValue($query);
		$GroupUserArray = @explode(',',$GroupUsers);
		if ($GroupUserArray == null)
		 	$GroupUserArray = array();
		if (in_array($_SESSION['userid'],$GroupUserArray)) {
			$Auth = 1;	
			break;
		}
	}	
}else if (($Privacy == 'invites') && ($UserInvited>0)){
	$Auth = 1;
}
if ($IsOwner) {
	$Auth = 1;	
} else if ($Privacy == 'public'){ 
	$Auth = 1;	
}else if (($Privacy == 'friends') && (($IsFriend) || ($IsOwner))){
	$Auth = 1;
}else if (($Privacy == 'fans') && (($IsFriend) || ($IsOwner)|| ($IsFan))){
	$Auth = 1;	
}else if ($Privacy == 'groups'){
	$SelectedGroups = @explode(',',$EventArray->selected_groups);
	if ($SelectedGroups == null)
		 $SelectedGroups = array();
	foreach($SelectedGroups as $group) {
		$query = "SELECT GroupUsers from user_groups where ID='$group'";
		$GroupUsers = $DB->queryUniqueValue($query);
		$GroupUserArray = @explode(',',$GroupUsers);
		if ($GroupUserArray == null)
		 	$GroupUserArray = array();
		if (in_array($_SESSION['userid'],$GroupUserArray)) {
			$Auth = 1;	
			break;
		}
	}	
}

if ($Auth == 1) {	
if ($EventArray->type == 'promotion') {
	$query = "SELECT count(*) from promotion_codes_redeem where promo_code='".$EventArray->promo_code."' and user_id='".$_SESSION['userid']."'";
	$CodeRedeemed = $InitDB->queryUniqueValue($query);	
}

$Redirect = 0;
if (($_POST['promo_claim'] == 1) &&(trim($_POST['txtPromoCode']) == $EventArray->promo_code)) {
	$PromoCode = $_POST['txtPromoCode'];
	$PromoRedir = $_POST['txtPromoDir'];
	if ($CodeRedeemed == 0) {
		$query = "INSERT into promotion_codes_redeem (user_id, promo_code, created_date) values ('".$_SESSION['userid']."', '$PromoCode',now())";	
		$InitDB->execute($query);
		include_once($_SERVER['DOCUMENT_ROOT'].'/models/Users.php');
		$XPMaker = new Users();
		$output = $XPMaker->addxp($InitDB, $_SESSION['userid'], $EventArray->xp);
		$Redirect = 1;
	}
	
	
}			  
	$query = "select count(*) from pf_events_invitations where CalID=".$_GET['id'];
	$TotalInvites = $DB->queryUniqueValue($query);
	$query = "select count(*) from likes where ContentType='cal_entry'  and ContentID='".$_GET['id']."'";
	$TotalLikes = $DB->queryUniqueValue($query);
	$query = "select count(*) from likes where ContentType='cal_entry'  and UserID='".$_SESSION['userid']."' and ContentID='".$_GET['id']."'";
	$UserLiked = $DB->queryUniqueValue($query);
								  
	 if ($TotalInvites > 0) {
		$query = "select Status from pf_events_invitations where CalID=".$_GET['id']." and UserID='".$_SESSION['userid']."'";
		$Status = $DB->queryUniqueValue($query);
		$query = "SELECT u.username, u.avatar,u.encryptid, f.Status
				 from pf_events_invitations as f 
				 join users as u on f.UserID=u.encryptid 
				 where f.CalID='".$_GET['id']."' and f.Status !='attending'";
		$InitDB->query($query);
		while ($line = $InitDB->fetchNextObject()) {
				$InviteList .= '<img src="'.$line->avatar.'" tooltip="'.$line->username.': '.$line->Status.'" vspace="5" hspace="5" style="border:1px #000000 solid;" width="25" height="25" id="super_'.$line->encryptid.'" tooltip="'.$line->username.'">';	
		}
		$query = "select Status from pf_events_invitations where CalID=".$_GET['id']." and UserID='".$_SESSION['userid']."'";
		$Status = $DB->queryUniqueValue($query);
		$query = "SELECT u.username, u.avatar,u.encryptid, f.Status
				  from pf_events_invitations as f 
				  join users as u on f.UserID=u.encryptid 
				  where f.CalID='".$_GET['id']."' and f.Status='attending'";
		$InitDB->query($query);
		while ($line = $InitDB->fetchNextObject()) {
				$AttendingList .= '<img src="'.$line->avatar.'" tooltip="'.$line->username.'" vspace="5" hspace="5" style="border:1px #000000 solid;" width="25" height="25" id="super_'.$line->encryptid.'">';								
		}
											
	 }
}

 if ($Redirect == 1) { ?>
<script type="text/javascript">
	parent.document.location.href='<? echo $PromoRedir;?>';
	</script>
<? }?>
<style type="text/css">
body,html {
margin:0px;
padding:0px;

}

</style>
<script>
function closeWindow() 
{
	var href = parent.window.location.href;
	href = href.split('#');
	href = href[0];
	parent.window.location = href;
}

$(document).ready(function(){
	
});

<?php if ($CloseWindow == 1) : ?>
closeWindow();
<?php endif; ?> 


</script>
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<link href="http://www.wevolt.com/css/cupertino/jquery-ui-1.8.1.custom.css" rel="stylesheet" /> 
<script src="http://www.wevolt.com/js/jquery-1.4.2.min.js"></script> 
<script src="http://www.wevolt.com/js/jquery-ui-1.8.1.custom.min.js"></script> 
<script src="http://www.wevolt.com/scripts/jquery.qtip-1.0.0-rc3.js?cache=2010-06-27 03:38:13"></script>
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
	
	for (var i=0; i < document.modform.txtContent.length; i++){
  		 if (document.modform.txtContent[i].checked){
     		 var content = document.modform.txtContent[i].value;
     	 }
   }
   
    var url="/connectors/getSearchResults.php";
    url=url+"?content="+content+"&keywords="+escape(keywords);
	
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


function submit_form(step, task, type) {

		var formaction = '/connectors/view_event.php?step='+step+'&task='+task+'&type='+type;
	//	alert(formaction);
	document.modform.action = formaction; 
	document.modform.submit();

}

  function toggleEnd(value) 
{

	if (value == 'on') {
		document.getElementById("NoEnd").value = 1;
		document.getElementById("endtr").style.display = 'none';
	
		document.getElementById("endset").style.display = 'none';
		document.getElementById("noendset").style.display = '';
		
	
	} else {
		document.getElementById("NoEnd").value = '';
		document.getElementById("endtr").style.display = '';
		document.getElementById("endset").style.display = '';
		document.getElementById("noendset").style.display = 'none';
	}
    
 }
 
 function setDefault(theText) 
{
     if (theText.value == "")
 {
         theText.value = theText.defaultValue;
     }
 }
 <? if ($_REQUEST['step'] == 2) {?>
function select_link(value) {

	if (value == 'search') {
		
		document.getElementById("searchupload").style.display = '';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favupload").style.display = 'none';
		
		if (document.getElementById("searchtab") != null)
			document.getElementById("searchtab").className ='tabactive';
		if (document.getElementById("urltab") != null)
			document.getElementById("urltab").className ='tabinactive';
		if (document.getElementById("mytab") != null)
			document.getElementById("mytab").className ='tabinactive';
		if (document.getElementById("favtab") != null)
			document.getElementById("favtab").className ='tabinactive';
		
		
	} else if (value == 'url') {
		document.getElementById("searchupload").style.display = 'none';
		document.getElementById("urlupload").style.display = '';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favupload").style.display = 'none';
		
		if (document.getElementById("searchtab") != null)
			document.getElementById("searchtab").className ='tabinactive';
		if (document.getElementById("urltab") != null)
			document.getElementById("urltab").className ='tabactive';
		if (document.getElementById("mytab") != null)
			document.getElementById("mytab").className ='tabinactive';
		if (document.getElementById("favtab") != null)
			document.getElementById("favtab").className ='tabinactive';
		
		
	} else if (value == 'my') {
	
		document.getElementById("searchupload").style.display = 'none';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("myupload").style.display = '';
		document.getElementById("favupload").style.display = 'none';
		
		if (document.getElementById("searchtab") != null)
			document.getElementById("searchtab").className ='tabinactive';
		if (document.getElementById("urltab") != null)
			document.getElementById("urltab").className ='tabinactive';
		if (document.getElementById("mytab") != null)
			document.getElementById("mytab").className ='tabactive';
		if (document.getElementById("favtab") != null)
			document.getElementById("favtab").className ='tabinactive';
	
		
		
	} else if (value == 'fav') {
		document.getElementById("searchupload").style.display = 'none';
		document.getElementById("urlupload").style.display = 'none';
		document.getElementById("myupload").style.display = 'none';
		document.getElementById("favupload").style.display = '';
		
		if (document.getElementById("searchtab") != null)
			document.getElementById("searchtab").className ='tabinactive';
		if (document.getElementById("urltab") != null)
			document.getElementById("urltab").className ='tabinactive';
		if (document.getElementById("mytab") != null)
			document.getElementById("mytab").className ='tabinactive';
		if (document.getElementById("favtab") != null)
			document.getElementById("favtab").className ='tabactive';
		
	}




}

function set_content(title,contentid,contenttype,contentthumb) {
		
		//ERROR FROM HERE SOMEWHERE
	
		document.getElementById("ContentType").value = contenttype;
		document.getElementById("ContentID").value = contentid;
	document.getElementById("changelink").style.display = 'none';
		document.getElementById("SelectedTitle").innerHTML = title;
		
			
			document.getElementById("thumbselect").style.display = 'none';
			document.getElementById("thumbdisplay").style.display = '';
			document.getElementById("itemthumb").src = contentthumb;
			document.getElementById("txtThumb").value = contentthumb;
			document.getElementById("search_results").innerHTML = '';
			document.getElementById("search_container").style.display = 'none';
			
		
}


 
<? }?>
function freq_select(value) {

if (value == 'weekly') {
	document.getElementById('dayofweek').style.display='';
	document.getElementById('dayofmonth').style.display='none';
	document.getElementById('monthheader1').style.display='none';
	document.getElementById('weeknumber').style.display='none';
	document.getElementById('monthheader2').style.display='none';
} else if (value == 'monthly') {
	document.getElementById('dayofweek').style.display='';
	document.getElementById('dayofmonth').style.display='';
	document.getElementById('weeknumber').style.display='';
	document.getElementById('monthheader1').style.display='';
	document.getElementById('monthheader2').style.display='';

} else {
	document.getElementById('dayofweek').style.display='none';
	document.getElementById('dayofmonth').style.display='none';
	document.getElementById('weeknumber').style.display='none';
	document.getElementById('monthheader1').style.display='none';
	document.getElementById('monthheader2').style.display='none';

}
}


function set_attendance(value) {
		var eventid = '<? echo $_GET['id'];?>';
		var answer = confirm('Are you sure you want to change your status to ' +value);
		if (answer) {
			
			attach_file('http://www.wevolt.com/connectors/event_attendance_processing.php?status='+value+'&id='+eventid);
		//	alert('http://www.wevolt.com/connectors/event_attendance_processing.php?status='+value+'&id='+eventid);
		document.location.href='/connectors/view_event.php?action=<? echo $_GET['action'];?>&id=<? echo $_GET['id'];?>';
		}
}
</script>

                       
                <div class="wizard_wrapper" align="center">
<div style="height:10px;"></div>
<div align="center">
<table width="608" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="592" align="center">
                                        <table width="100%"><tr><td width="125">
                             <? if (($EventArray->type == 'event') || ($EventArray->type == 'promotion')) {?>
                          
                              <table><tr>
                              
                             
                             <? 
							 	if ($_SESSION['userid'] != '')
                            	echo '<td><a href="javascript:void(0)" onClick="parent.new_wizard(\'excite\',\''.$EventArray->encrypt_id.'\',\'user\',\'cal_entry\');return false;"><img src="http://www.wevolt.com/images/reader_volt_btn.png" border="0" tooltip="Volt or Excite '.$EventArray->title.'" tooltip_position="bottomright"/></a></td>';
					 
							echo  '<td class="messageinfo_white"><span id="like_event_'.$_GET['id'].'">';
							if ($TotalLikes > 0 ) { 
								echo $TotalLikes .' like'; 
							if ($TotalLikes != 1) 
								echo 's';
							}
							echo '</span>';
							
							if (($UserLiked == 0) && ($_SESSION['userid'] != ''))
								echo '&nbsp;<span id="like_cell"><a href="javascript:void(0)" onClick="parent.like_content(\''.$_GET['id'].'\',\'cal_entry\',\'like_event_'.$_GET['id'].'\',\'http://www.wevolt.com/view_event.php?action=view&id='.$_GET['id'].'\',\'\');document.getElementById(\'like_cell\').innerHTML=\'you like this\';return false;"><img src="http://www.wevolt.com/images/reader_like_btn.png" border="0" tooltip="Like this event, boost it\'s rating!" tooltip_position="bottomright"/></a></span></td>';
												
				
							?>
                            
                            </tr></table>
                            <? }?>
                            
                            </td><td>
                                        <? if ($EventArray->type == 'event') {?>
                                        <img src="http://www.wevolt.com/images/wizards/event_title.png" vspace="8"/>
                                        <? } else if ($EventArray->type == 'reminder') {?>
                                         <img src="http://www.wevolt.com/images/wizard_reminder_title.png" vspace="8"/>
                                        
                                        <? }else if ($EventArray->type == 'promotion') {?>
                                         <img src="http://www.wevolt.com/images/wizard_promo_title.png" vspace="8"/>
                                        <? }else if ($EventArray->type == 'todo') {?>
                                         <img src="http://www.wevolt.com/images/wizard_todo_title.png" vspace="8"/>
                                        <? }?></td>
                                        </tr>
                                        </table>
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
                        <div class="spacer"></div>
                        </div>
 <?  if ($Auth == 1) {?>                    

                          <?   if ($_REQUEST['action'] == 'view') { 
						  
						 ?>
                 
 <div align="center">
<table><tr>

<? if ($EventArray->thumb != '') {?>
<td valign="top" align="center">
<? 

list($width, $height) = @getimagesize($EventArray->thumb); 	
if ($width > 100)
	$width=100; 
if ($height > 100)
	$height = 100;?><img src="<? echo $EventArray->thumb;?>" width="<? echo $width;?>" height="<? echo $height;?>" border="2"/></td>
		
		<? 
			$Width = 486;
		} else {
			$Width = 590;
			
		}?>
<td>
<script type="text/javascript">


</script>
<table width="<? echo $Width;?>" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="<? echo ($Width-16);?>" align="left">
<strong>Title:&nbsp;</strong><? echo $EventArray->title;?><br />
    <strong>Date:&nbsp;</strong><? echo  date('l, F d, Y', strtotime($EventArray->start));?><br />
    <? if (($EventArray->show_start_time == 1) || ($EventArray->show_end_time == 1)) {?>

<strong>Time:&nbsp;</strong><? if ($EventArray->show_start_time == 1) echo date('h:ia', strtotime($EventArray->start));?>
<? if ($EventArray->show_end_time == 1) {
	if ($EventArray->show_start_time == 1) 
		echo '-'; 
	echo date('h:ia', strtotime($EventArray->end));?>

<? }?>
<br />
<? }?>
  <? if (($EventArray->location != '') && ($EventArray->location != '0')) {?>
 <strong> Location:&nbsp;</strong><? echo $EventArray->location;?><br /> 
  <? }?> 
   <? if ($EventArray->address != '') {?>
 <strong> Street:&nbsp;</strong><? echo $EventArray->address;?><br /> 
  <? }?>
     <? if ($EventArray->city != '') {?>
 <strong> City:&nbsp;</strong><? echo $EventArray->city;?><br /> 
  <? }?>
   <? if ($EventArray->city != '') {?>
  <strong>Zip:&nbsp;</strong><? echo $EventArray->zip;?><br />
  <? }   
   if ($EventArray->type == 'promotion') {?>
   <div class="spacer"></div>

 <strong> Promo Code: </strong><span class="messageinfo_warning"><? echo $EventArray->promo_code;?></span><br />
 <? if ($CodeRedeemed == 1) {?>
 You have already recieved this promotion
 <? } else {?>
  <form method="post" action="#">Enter Promo Code<br />
  <input type="text" name="txtPromoCode" style="width:200px;"/>
<br />

  <input type="hidden" name="txtPromoDir" value="<? echo $EventArray->url;?>" />
  <input type="hidden" name="promo_claim" value="1" />
  <input type="submit" value="CLAIM" />
  </form>
  <? }?>
  <? } else {?>
  <? if (($EventArray->url != '') && ($EventArray->url != 'http://')){?>
  <div class="messageinfo_white"><a href="javascript:void(0)" onclick="parent.document.location.href='<? echo $EventArray->url;?>';"><strong>VIST LINK&nbsp;</strong></a></div>
  <? }?>    
  <? }?>
  <? 
	
  if ($EventArray->type == 'reminder') {?>
	  <? if ($EventArray->content_type == 'feed_item') {
		  	$query = "SELECT * from feed_items where UserID='$UserID' and EncryptID='$EventArray->content_id'";
			$ItemArray = $InitDB->queryUniqueObject($query);
			
			 if (($ItemArray->Link != '') && ($ItemArray->Link != 'http://')){?>
              <div class="messageinfo_white"><a href="javascript:void(0)" onclick="parent.document.location.href='<? echo $EventArray->Link;?>';"><strong>VIST LINK&nbsp;</strong></a></div>
 			 	
                
  			<? }?> 
     <? }?>                              
  <? }?>  
 </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td></tr></table>

<table><tr>
<td valign="top" class="messageinfo_white">
<? if (($TotalInvites > 0) && (($EventArray->show_list == '1') || ($IsOwner))) 
	$Width = 200;
	else  
		$Width = 590;
		?>
<table width="<? echo $Width;?>" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="<? echo ($Width-16);?>" align="left" style="padding:3px;">

<strong>DESCRIPTION</strong><br />
<div style="height:100px; width:<? echo ($Width-25);?>px; background-color:#FFF; color:#000; border:1px #666 solid; padding:3px; overflow:auto">
<? echo $EventArray->description;?>
</div>
<div  style="height:5px;"></div>
<? if ($EventArray->type != 'reminder') {?>
<strong>Privacy Level</strong>: <? echo $EventArray->privacy_setting;?><br />
<? }?>
<? if ($Status != '') {?>
<div  style="height:5px;"></div><div  style="height:5px;"></div>
<strong>Your Attendance</strong>:<br />
<select name="txtAttend" onchange="set_attendance(this.options[this.selectedIndex].value);">
<? if ($Status == 'invited'){?>
<option value="invited" selected>Not Repsonded</option>
<? }?>
<option value="attending" <? if ($Status == 'attending') echo ' selected';?>>Attending</option>
<option value="maybe attending" <? if ($Status == 'maybe attending') echo ' selected';?>>Maybe Attending</option>
<option value="not attending" <? if ($Status == 'not attending') echo ' selected';?>>Not Attending</option>
</select>
<div  style="height:5px;"></div>
<? }

?>
</td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td>
<? if (($TotalInvites > 0)  && (($EventArray->show_list == '1') ||($IsOwner))) {?><td valign="top">
<table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="<? echo (200-16);?>" align="left" style="padding:3px;">
                                        
<div style="border-bottom:solid 1px #FC0;">INVITE LIST<br /></div>
<div style="height:180px; overflow:auto;">
<? echo $InviteList;?>
</div>
  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td><? }?>
<? if (($TotalInvites > 0) && (($EventArray->show_list == '1') ||($IsOwner))) {?><td valign="top">
<table width="200" border="0" cellpadding="0" cellspacing="0"><tbody><tr>
										<td id="wizardBox_TL"></td>
										<td id="wizardBox_T"></td>
										<td id="wizardBox_TR"></td></tr>
										<tr><td class="wizardboxcontent"></td>
										<td class="wizardboxcontent" valign="top" width="<? echo (200-16);?>" align="left" style="padding:3px;">
<div style="border-bottom:solid 1px #FC0;">ATTENDING LIST<br /></div>
<div style="height:180px; overflow:auto;">
<? echo $AttendingList;?>
</div>
  </td><td class="wizardboxcontent"></td>

						</tr><tr><td id="wizardBox_BL"></td><td id="wizardBox_B"></td>
						<td id="wizardBox_BR"></td>
						</tr></tbody></table>
</td><? }?>
</tr></table>
<script type="text/javascript">

$(document).ready(function() {
$('*[tooltip]').each(function() {
		var position = $(this).attr('tooltip_position');
		switch (position) {
			case 'right':
				tip = 'leftMiddle';
				target = 'rightMiddle';
				break;
			case 'left':
				tip = 'rightMiddle';
				target = 'leftMiddle';
				break;
			case 'top':
				tip = 'bottomMiddle';
				target = 'topMiddle';
				break;
			case 'bottom':
				tip = 'topMiddle';
				target = 'bottomMiddle';
				break;
			case 'topleft':
				tip = 'bottomRight';
				target = 'topLeft';
				break;
			case 'bottomleft':
				tip = 'topRight';
				target = 'bottomLeft';
				break;
			case 'bottomright':
				tip = 'topLeft';
				target = 'bottomRight';
				break;
			case 'topright':
			default:
				tip = 'bottomLeft';
				target = 'topRight';
		}
		$(this).qtip({
			content: $(this).attr('tooltip'),
			style: {
				name: 'blue',
				tip: tip,
				border: {
			width: 1,
	         radius: 2,
	         color: '#3a3a3a'
				}
			},
			position: {
		       corner: {
			   	   target: target,
			   	   tooltip: tip,
			   	   adjust: {
					  screen: true
			   	   }
	  	 	   }
			} 
		});
	});
});

</script>
<? } else {?>
                          
                          You do not have access to view this event. <br />
The privacy of this event is set to <? echo $EventArray->privacy_setting;?>
                          
                          <? }?>

                            
<? /*                            
 <img src="http://www.wevolt.com/images/wizard_cancel_btn.png" onClick="closeWindow();" class="navbuttons"/>&nbsp;&nbsp; 
<img src="http://www.wevolt.com/images/wizard_back_btn.png" onClick="submit_form('1','<? echo $_REQUEST['task'];?>','');" class="navbuttons"/>&nbsp;&nbsp;
*/?>
<? }   else {?>
                          
                         <div class="messageinfo_warning"><div class="spacer"></div> <div class="spacer"></div><div class="spacer"></div>You do not have access to view this event. The privacy of this event is set to <? echo $EventArray->privacy_setting;?></div>
                          
                          <? }?>

           </div>             
                        
                       