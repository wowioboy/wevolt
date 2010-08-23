<?php include 'includes/init.php';

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
            $useDate = intval(date('d')); 
        } else {
		 $useDate = intval($useDate); 
		}
 		
             /* make day selector */ 
         $string .= "<SELECT NAME=" . $inName . ">\n"; 
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



$Action = $_GET['action'];
$UserID = $_SESSION['userid'];
$EventID = $_GET['id'];
$RePost = 0;
$DB = new DB();
$DB2 = new DB();
$query = "select * from users where encryptid='$UserID'"; 
$UserArray = $DB->queryUniqueObject($query);
$CloseWindow = 0 ;

if (($_SESSION['userid'] == '') || ($UserID != $_SESSION['userid']))
	$Auth = 0;
else 
	$Auth = 1;


if (($_POST['save'] =='1') && ($_GET['step'] == 'add_exit')) { 

		$Title = mysql_real_escape_string($_POST['txtName']);
		$Tagline = mysql_real_escape_string($_POST['txtTagline']);
		$Tags = mysql_real_escape_string($_POST['txtTags']);
		$Description = mysql_real_escape_string($_POST['txtDescription']);
		$Privacy = $_POST['txtPrivacy'];
		$UserID = $_SESSION['userid'];
		$CreateDate = date('Y-m-d h:i:s');
		$Thumb = $_POST['txtThumb'];
   		$Address = mysql_real_escape_string($_POST['txtAddress']);
		$City = mysql_real_escape_string($_POST['txtCity']);
		$State = mysql_real_escape_string($_POST['txtState']);
		$Zip = mysql_real_escape_string($_POST['txtZip']);
		$State = mysql_real_escape_string($_POST['txtState']);
		$StartTimeDate = $_POST['start_time_year'].'-'.$_POST['start_time_month'].'-'.$_POST['start_time_day'];
   	    $EndTimeDate = $_POST['end_time_year'].'-'.$_POST['end_time_month'].'-'.$_POST['end_time_day'];
		$StartTimeTime =  $_POST['start_time_hour'].':'.$_POST['start_time_min'];
		$EventDate = $StartTimeDate;
		$EventTime = $StartTimeTime;
		$Link = $_POST['txtLink'];
		$EventType = $_GET['type'];
		$ContentID = $_POST['ContentID'];
		$ContentType = $_POST['ContentType'];
		if (($_POST['start_time_ampm'] == 'pm') && ($_POST['start_time_hour'] != 12))
			$StartTimeTime = $_POST['start_time_hour'] + 12;
		else if (($_POST['start_time_ampm'] == 'am') && ($_POST['start_time_hour'] == 12))
			$StartTimeTime = '00';
		else 
			$StartTimeTime .= $_POST['start_time_hour'];

		$StartTimeTime .= ':'.$_POST['start_time_min'];
		
		if (($_POST['end_time_ampm'] == 'pm') && ($_POST['end_time_hour'] != 12))
			$EndTimeTime = $_POST['end_time_hour'] + 12;
		else if (($_POST['end_time_ampm'] == 'am') && ($_POST['end_time_hour'] == 12))
			$EndTimeTime = '00';
		else 
			$EndTimeTime .= $_POST['end_time_hour'];

		$EndTimeTime .= ':'.$_POST['end_time_min'];
		
		$EntryStart = $StartTimeDate. ' 00:00:00';
		$EntryEnd = $EndTimeDate. ' 00:00:00';
		if ($_POST['NoEnd'] == 1) 
			$EntryEnd = '0000-00-00 00:00:00';
		
		$Frequency =  $_POST['txtFrequency'];
		if ($Frequency != 'none')  {
			$DayOfWeek =  $_POST['dayofweek'];
			if (($Frequency != 'daily') && ($Frequency != 'weekly'))
				$DayofMonth =  $_POST['dayofmonth'];
			if (($Frequency != 'daily') && ($Frequency != 'weekly'))
				$WeekNumber =  $_POST['weeknumber'];
			$EventType = $_POST['EventType'];
		} else {
			$Frequency ='';
		}
		
		if ($Privacy == '')
			$Privacy = 'private';

		if ($_GET['task'] == 'new') {
		
			$query = "INSERT into pf_calendar (Title, Comment,EventDate, EventTime, UserID,ContentID,ContentType,EntryType,Frequency, DayofWeek,DayofMonth,WeekNumber, PrivacySetting, EntryStart,EntryEnd,CreatedDate) values ('$Title','$Tagline','$EventDate','$EventTime','$UserID','$ContentID', '$ContentType','$EventType','$Frequency','$DayOfWeek','$DayofMonth','$WeekNumber','$Privacy', '$EntryStart','$EntryEnd','$CreateDate')";
			$DB->execute($query);
			print $query.'<br/>';			
			$query = "SELECT ID from pf_calendar where CreatedDate='$CreateDate' and UserID='$UserID'";
			$CalID = $DB->queryUniqueValue($query);
			print $query.'<br/>';	
			
			if ($EventType == 'event'){		
				$query = "INSERT into pf_events (Name, Description, UserID,EventFrequency, FreqDay, FreqWeek,EventType,EventStart,EventEnd, StreetAddress, Website, City, State, Zip, Tags, CreatedDate,Thumb) values ('$Title','$Description','$UserID', '$Frequency', '$DayofWeek', '$WeekNumber','$EventType', '$EntryStart','$EntryEnd', '$Address', '$Link','$City', '$State', '$Zip', '$Tags','$CreateDate','$Thumb')";
				$DB->execute($query);
				print $query.'<br/>';	
				$query = "SELECT ID from pf_events where CreatedDate='$CreateDate' and UserID='$UserID'";
				$EventID = $DB->queryUniqueValue($query);
				print $query.'<br/>';		
				$query = "UPDATE pf_calendar set EventID='$EventID' where ID='$CalID'";
				$DB->execute($query);
				print $query.'<br/>';	
			}
		
			//header("Location:feed_wizard.php?".$TypeTarget."=".$TargetID."&module=".$ModuleID."&step=add");
		
		} else if ($_GET['task'] == 'edit') {
			
			$query = "UPDATE pf_calendar set Title='$Title', EventDate='$EventDate', EventTime='$EventTime', ContentID='$ContentID',ContentType='$ContentType',Frequency='$Frequency', DayofWeek='$DayofWeek',DayofMonth='$DayofMonth',WeekNumber='$WeekNumber', PrivacySetting='$Privacy', EntryStart='$EntryStart',EntryEnd='$EntryStart' where EventID ='$EventID'";
			$DB->execute($query);
			print $query.'<br/>';	
				if ($EventType == 'event'){		
					$query = "UPDATE pf_events  set Name='$Title', Description='$Description', EventFrequency='$Frequency', FreqDay='$DayofWeek', FreqWeek= '$WeekNumber',EventStart='$EntryStart',EventEnd='$EntryEnd', StreetAddress='$StreetAddress', Website='$Link', City='$City', State='$State', Zip='$Zip', Tags='$Tags' where ID ='$EventID'";
					$DB->execute($query);
					print $query.'<br/>';	
				}
		
		}
		//header("Location:/myvolt/".trim($_SESSION['username'])."/?t=calendar");
		$CloseWindow=1;
	
}

?>
<? if ($CloseWindow == 1) {?>
<script type="text/javascript">
//window.parent.location.href='http://users.w3volt.com/myvolt/<? echo trim($_SESSION['username']);?>/?t=calendar';
</script>
<? }?>
<LINK href="http://www.w3volt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/javascript" src="http://www.w3volt.com/ajax/ajax_init.js"></script>
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
   
    var url="http://www.w3volt.com/connectors/getSearchResults.php";
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
 


function rolloveractive(tabid, divid) {
	var divstate = document.getElementById(divid).style.display;
		if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='tabhover';
		} 
}

function rolloverinactive(tabid, divid) {
		if (document.getElementById(divid).style.display != '') {
			document.getElementById(tabid).className ='tabinactive';
		} 
}

function submit_form(step, task, type) {

		var formaction = 'event_wizard.php?step='+step+'&task='+task+'&type='+type;
	//	alert(formaction);
	document.modform.action = formaction; 
	document.modform.submit();

}

 function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
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
 <? if ($_GET['step'] == 2) {?>
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

</script>
<style type="text/css">
	<!--
#modrightside {
	width: 9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/right_side.png);
	background-repeat:repeat-y;
}

#modleftside {
	width: 9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/left_side.png);
	background-repeat:repeat-y;
}

#modtop {
	height:38px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_bar.png);
	background-repeat:repeat-x;
}

.boxcontent {
	color:#000000;
	background-color:#FFFFFF;
}

#modbottom {
	height:9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_bar.png);
	background-repeat:repeat-x;
}

#modbottomleft{
	width:9px;
	height:9px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_left.png);
	background-repeat:no-repeat;
}

#modtopleft{
	width:9px;
	height:38px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_left.png);
	background-repeat:no-repeat;
}

#modtopright{
	width:31px;
	height:38px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_right.png);
	background-repeat:no-repeat;
}

#modbottomright{
	width:31px;
	height:9px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_right.png);
	background-repeat:no-repeat;
}


.tabactive {
height:12px;
background-color:#f58434;
text-align:center;
padding:5px;
cursor:pointer;
font-weight:bold;
font-size:12px;
}
.tabinactive {
height:12px;
background-color:#dc762f;
text-align:center;
padding:5px;
cursor:pointer;
color:#FFFFFF;
font-size:12px;
}
.tabhover{
height:12px;
background-color:#ffab6f;
color:#000000;
text-align:center;
padding:5px;
cursor:pointer;
font-size:12px;
}

-->
</style>


                       
                        <div style="background-image:url(http://www.w3volt.com/images/wizard_bg.jpg); background-repeat:no-repeat; background-position:top left;width:725px; height:628px;" align="left"><img src="http://www.w3volt.com/images/wizard_volt.jpg" /><img src="http://www.w3volt.com/images/wizard_edit.jpg" /><img src="http://www.w3volt.com/images/wizard_info.jpg" />
                                    
                     <div style="height:420px;width:560px; padding-left:10px; padding-right:25px;" align="left">
                           <form name="modform" id="modform" method="post">
                            <? if (!isset($_GET['step'])){ ?>
             
<div align="center" style="padding-right:100px; padding-top:25px;">
What type of Item would you like to create? <br />
 <input type="button" onClick="submit_form('1','new','event');" value="CREATE AN EVENT" /><br />

 <input type="button" onClick="submit_form('1','new','reminder');" value="CREATE A REMINDER" /><br />
 <input type="button" onClick="submit_form('1','new','promo');" value="CREATE A PROMOTION" /><br />
  <input type="button" onClick="submit_form('1','new','todo');" value="CREATE A TO DO" /><br />
    <input type="button" onClick="submit_form('2','new','notify');" value="CREATE AN UPDATE NOTIFICATION" /><br />

</div>
                                     
                            <? } else if ($_GET['step'] == 1) {?>
                            <div class="spacer"></div>
                            <div style="padding-left:20px;">
                            <? if ($_GET['type'] == 'reminder') {?>
                             <input type="button" onClick="submit_form('add_exit','<? echo $_GET['task'];?>','<? echo $_GET['type'];?>');" value="CREATE REMINDER" />
                             <input type="hidden" name="save" value="1" />
                            <? } else {?>
                            <input type="button" onClick="submit_form('2','<? echo $_GET['task'];?>','<? echo $_GET['type'];?>');" value="NEXT -> ADD DETAILS" />
                            <? }?>
<table width="500">

<tr>
<td class="sender_name">Title:<small>(required)</small></td>
<td><input id="txtName" name="txtName" style="width:100%;" value="" type="text"></td>
</tr>

<? if (($_GET['type'] == 'todo') || ($_GET['type'] == 'reminder')|| ($_GET['type'] == 'promo')) {?>
<tr>
<td class="sender_name">Comment / Tagline:</td>
<td><input id="txtTagline" name="txtTagline" style="width:100%;" value="" type="text"></td>
</tr>
<? }?>
<? if ($_GET['type'] == 'event') {?>
<tr>
<td class="sender_name">Location:</td>
<td class="messageinfo"><input id="txtLocation" name="txtLocation" style="width:100%;" type="text"> <a onclick="document.getElementById('addressdiv').style.display='';">Add a Street Address</a></td>
</tr>
<tr id="addressdiv" style="display:none;">
<td colspan="2">

<table width="500">
<tr><td class="sender_name">Street Address</td>
<td class="messageinfo"><input id="txtAddress" name="txtAddress" style="width:100%;" value="" type="text"></td>
</tr>
<tr><td class="sender_name">City</td>
<td class="messageinfo"><input id="txtCity" name="txtCity" style="width:100%;" value="" type="text"></td>
</tr>
<tr><td class="sender_name">State</td>
<td class="messageinfo">
<? $StateString = statedropdown();?>
<SELECT ID='txtState' NAME='txtState' STYLE='WIDTH:100%;'>
          <? if ($state != '') { echo str_replace($state . '"', $_POST['txtState'] . '" selected', $StateString); } else { echo $StateString;} ?> 
        </SELECT></td>
</tr>
<tr><td class="sender_name">Zip</td>
<td class="messageinfo"><input id="txtZip" name="txtZip" style="width:100px;" value="" type="text"></td>
</tr>
</table>

</td>
</tr>
<? }?>
<tr><td colspan="2">
<table width="100%"><tr><td><td class="sender_name" width="100">Start Time</td>

<? 

if (($_POST['start_time_month'] != '') && ($_POST['start_time_day'] != '') && ($_POST['start_time_year'] != ''))
	$SelectedDate = $_POST['start_time_year'].'-'.$_POST['start_time_month'].'-'.$_POST['start_time_day'].' 00:00:00';
else 
	$SelectedDate = '';
	
echo DateSelector('start_time',$SelectedDate) ;?>

<td class="messageinfo">at</td>

<? 

if ($_POST['start_time_hour'] == '')
	$HourSelect = date('h');
else 
	$HourSelect = $_POST['start_time_hour'];
	
if ($_POST['start_time_min'] == '')
	$MinSelect = date('m');
else 
	$MinSelect = $_POST['start_time_min'];
	
if ($_POST['start_time_ampm'] == '')
	$AMPMSelect ='pm';
else 
	$AMPMSelect = $_POST['start_time_ampm'];
	
echo hourmin("start_time_hour", "start_time_min", "start_time_ampm", $HourSelect, $MinSelect, $AMPMSelect);?>
</tr></table>
</td>

</tr>
<tr><td colspan="2"><? if ($_GET['type'] != 'promo'){?><span class="messageinfo">&nbsp;&nbsp;<span id="endset"><a href="#" onclick="toggleEnd('on');">-Set No End-</a></span><span id="noendset" style="display:none;"><a href="#" onclick="toggleEnd('off');">-Set End-</a> This event will repeat until cancelled.</span></span><? }?>
<table width="100%"  id='endtr'><tr><td><td width="100"><span class="sender_name">End Time</span> </td>
<? 

if (($_POST['end_time_month'] != '') && ($_POST['end_time_day'] != '') && ($_POST['end_time_year'] != ''))
	$SelectedDate = $_POST['end_time_year'].'-'.$_POST['end_time_month'].'-'.$_POST['end_time_day'].' 00:00:00';
else 
	$SelectedDate = '';
	
echo DateSelector('end_time',$SelectedDate) ;?>
<td class="messageinfo">at</td>
<? 
if ($_POST['end_time_hour'] == '')
	$HourSelect = date('h');
else 
	$HourSelect = $_POST['end_time_hour'];
	
if ($_POST['end_time_min'] == '')
	$MinSelect = date('m');
else 
	$MinSelect = $_POST['end_time_min'];
	
if ($_POST['end_time_ampm'] == '')
	$AMPMSelect ='pm';
else 
	$AMPMSelect = $_POST['end_time_ampm'];
	
echo hourmin("end_time_hour", "end_time_min", "end_time_ampm", $HourSelect, $MinSelect, $AMPMSelect);?>
</tr></table>
</td>

</tr>
<tr><td class="sender_name">Select Frequency

</td>
<td class="messageinfo"><input type="radio" name="txtFrequency" value="none" onchange="freq_select('none');" checked/> One Time<br />
<input type="radio" name="txtFrequency" value="daily" onchange="freq_select('daily');"/> Daily<br />
<input type="radio" name="txtFrequency" value="weekly" onchange="freq_select('weekly');"/> Weekly<br />
<input type="radio" name="txtFrequency" value="monthly" onchange="freq_select('monthly');"/> Monthly</td>
</tr>
<tr id="monthheader1" style="display:none;"><td colspan="2"  class="messageinfo">Select Week Number and Day of Week</td></tr>
<tr id="weeknumber" style="display:none;"><td class="sender_name">Week Number

</td>
<td><select name="weeknumber">
<option value='1' <? if ($_POST['weeknumber'] == '1') echo 'selected';?>>1st Week</option>
<option value='2' <? if ($_POST['weeknumber'] == '2') echo 'selected';?>>2nd Week</option>
<option value='3' <? if ($_POST['weeknumber'] == '3') echo 'selected';?>>3rd Week</option>
<option value='4' <? if ($_POST['weeknumber'] == '4') echo 'selected';?>>4th Week</option>
<option value='5' <? if ($_POST['weeknumber'] == '5') echo 'selected';?>>5th Week</option>
</select>
</td>
</tr>
<tr id="dayofweek" style="display:none;"><td class="sender_name">Day of Week

</td>
<td><select name="dayofweek">
<option value='Mon' <? if ($_POST['dayofweek'] == 'Mon') echo 'selected';?>>Monday</option>
<option value='Tues' <? if ($_POST['dayofweek'] == 'Tues') echo 'selected';?>>Tuesday</option>
<option value='Wed' <? if ($_POST['dayofweek'] == 'Wed') echo 'selected';?>>Wednesday</option>
<option value='Thurs' <? if ($_POST['dayofweek'] == 'Thurs') echo 'selected';?>>Thursday</option>
<option value='Fri' <? if ($_POST['dayofweek'] == 'Fri') echo 'selected';?>>Friday</option>
<option value='Sat' <? if ($_POST['dayofweek'] == 'Sat') echo 'selected';?>>Saturday</option>
<option value='Sun' <? if ($_POST['dayofweek'] == 'Sun') echo 'selected';?>>Sunday</option>
</select></td>
</tr>
<tr id="monthheader2" style="display:none;"><td colspan="2" class="messageinfo">OR Select Day of Month</td></tr>
<tr id="dayofmonth" style="display:none;"><td class="sender_name">Day of Month

</td>
<td>
<? echo DayDropdown('dayofmonth',$_POST['dayofmonth']) ;?>
</td>
</tr>

<? if (($_GET['type'] == 'event') || ($_GET['type'] == 'promo')) {?>
<tr><td class="sender_name">Privacy Setting</td>
<td class="messageinfo"><select name="txtPrivacy">
<option value="public" <? if ($Privacy == 'public') echo 'selected';?>>Public Event (will appear on public calendar)</option>
<option value="friends"  <? if ($Privacy == 'friends') echo 'selected';?>>Friends Only (Friends will see this item)</option>
<option value="fans" <? if ($Privacy == 'fans') echo 'selected';?> >Fans (Friends and Fans will see this item)</option>
<option value="private" <? if ($Privacy == 'private') echo 'selected';?> >Private (Only you can see this)</option></select>
</td>
</tr>
<? } ?> 

</table>

                            </div>                                  
                             <? } else if ($_GET['step'] == 2){
							  include 'includes/event_details_form_inc.php';
							   } else if ($_GET['step'] == 3) {
							   include 'includes/event_invitation_form_inc.php';
							    } ?>
                               
                                </div>
                                 
                               
      <? if ($_GET['step'] != 1) {?>
      <input type="hidden" name="txtName" value="<? if ($_POST['txtName'] != '') echo $_POST['txtName']; else if ($_POST['Name'] != '')echo $_POST['Name'];?>">
      <input type="hidden" name="txtTagline" value="<? if ($_POST['txtTagline'] != '') echo $_POST['txtTagline'];?>">
      <input type="hidden" name="txtAddress" value="<? if ($_POST['txtAddress'] != '') echo $_POST['txtAddress'];?>">
      <input type="hidden" name="txtCity" value="<? if ($_POST['txtCity'] != '') echo $_POST['txtCity'];?>">
     
      <input type="hidden" name="txtZip" value="<? if ($_POST['txtZip'] != '') echo $_POST['txtZip'];?>">
      <input type="hidden" name="txtState" value="<? if ($_POST['txtState'] != '') echo $_POST['txtState'];?>">
      <input type="hidden" name="start_time_month" value="<? if ($_POST['start_time_month'] != '') echo $_POST['start_time_month'];?>">
      <input type="hidden" name="start_time_day" value="<? if ($_POST['start_time_day'] != '') echo $_POST['start_time_day'];?>">
      <input type="hidden" name="start_time_year" value="<? if ($_POST['start_time_year'] != '') echo $_POST['start_time_year'];?>">
      <input type="hidden" name="start_time_hour" value="<? if ($_POST['start_time_hour'] != '') echo $_POST['start_time_hour'];?>">
      <input type="hidden" name="start_time_min" value="<? if ($_POST['start_time_min'] != '') echo $_POST['start_time_min'];?>">
      <input type="hidden" name="start_time_ampm" value="<? if ($_POST['start_time_ampm'] != '') echo $_POST['start_time_ampm'];?>">
      <input type="hidden" name="end_time_month" value="<? if ($_POST['end_time_month'] != '') echo $_POST['end_time_month'];?>">
      <input type="hidden" name="end_time_day" value="<? if ($_POST['end_time_day'] != '') echo $_POST['end_time_day'];?>">
      
      <input type="hidden" name="start_time_day" value="<? if ($_POST['start_time_day'] != '') echo $_POST['start_time_day'];?>">
      <input type="hidden" name="end_time_year" value="<? if ($_POST['end_time_year'] != '') echo $_POST['end_time_year'];?>">
      <input type="hidden" name="end_time_hour" value="<? if ($_POST['end_time_hour'] != '') echo $_POST['end_time_hour'];?>">
      <input type="hidden" name="end_time_min" value="<? if ($_POST['end_time_min'] != '') echo $_POST['end_time_min'];?>">
      <input type="hidden" name="end_time_ampm" value="<? if ($_POST['end_time_ampm'] != '') echo $_POST['end_time_ampm'];?>">
      <input type="hidden" name="txtPrivacy" value="<? if ($_POST['txtPrivacy'] != '') echo $_POST['txtPrivacy'];?>">
      <input type="hidden" name="txtFrequency" value="<? if ($_POST['txtFrequency'] != '') echo $_POST['txtFrequency'];?>">
      <input type="hidden" name="dayofweek" value="<? if ($_POST['dayofweek'] != '') echo $_POST['dayofweek'];?>">
      <input type="hidden" name="dayofmonth" value="<? if ($_POST['dayofmonth'] != '') echo $_POST['dayofmonth'];?>">
      <input type="hidden" name="weeknumber" value="<? if ($_POST['weeknumber'] != '') echo $_POST['weeknumber'];?>">
     <? }?>                          
	 <? if ($_GET['step'] != 2) {?>
     	<input type="hidden" name="txtDescription" value="<? if ($_POST['txtDescription'] != '') echo $_POST['txtDescription'];?>">
		<input type="hidden" name="txtTags" value="<? if ($_POST['txtTags'] != '') echo $_POST['txtTags']; ?>">
     <? }?>
                                

<input type="hidden" id ="EventType" name="EventType" value="<? if ($_GET['type'] != '') echo $_GET['type'];?>">
<input type="hidden" id ="task" name="task" value="<? if ($_GET['task'] != '') echo $_GET['task'];?>">
<input type="hidden" name="RefTitle" value="<? if ($_GET['title'] != '') echo $_GET['title']; else if ($_POST['RefTitle'] != '')echo $_POST['RefTitle'];?>">
<input type="hidden" name="ContentID" id="ContentID" value="<? if ($_GET['content'] != '') echo $_GET['content']; else if ($_POST['ContentID'] != '')echo $_POST['ContentID'];?>">
<input type="hidden" name="ContentType" id="ContentType" value="<? if ($_POST['ContentType'] != '')echo $_POST['ContentType'];?>">
<input type="hidden" name="Link" value="<? if ($_GET['link'] != '') echo $_GET['link']; else if ($_POST['Link'] != '')echo $_POST['Link'];?>">
 <input type="hidden" name="NoEnd" id="NoEnd" value="<? if ($_POST['NoEnd'] != '') echo $_POST['NoEnd'];?>">
</form>
     
              
<?php include 'includes/footer_template_new.php';?>
