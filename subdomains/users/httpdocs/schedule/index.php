<? 
ini_set('session.cookie_domain', '.wevolt.com');
 if(!isset($_SESSION)) { 
    session_start();
  }

?>
<link href='http://www.w3volt.com/schedule/style/blue/style.css' rel='stylesheet' type='text/css' />
<script  language="javascript" src="http://www.w3volt.com/scripts/global_functions.js"></script>
<script language="javascript">
function toggle_update_div(value) {

	//alert(value);
	
	//if (document.getElementById('update_div_'+value) == null)
	//	alert ('NOT FOUND');
	//else 
	//	alert("FOUND");
	if (document.getElementById('update_div_'+value).style.display == '') {
		document.getElementById('update_div_'+value).style.display = 'none';
		document.getElementById('update_control_'+value).innerHTML = 'VIEW';
	} else {
		document.getElementById('update_div_'+value).style.display = '';
		document.getElementById('update_control_'+value).innerHTML = 'HIDE';
	
	}

}


</script>
   
</head>

<body>
<center>

<?php
    
    ## +---------------------------------------------------------------------------+
    ## | 1. Creating & Calling:                                                    | 
    ## +---------------------------------------------------------------------------+
    // include calendar class and other files
    require_once("inc/connection.inc.php");
	 require_once("../includes/db.class.php");
    require_once("calendar.class.php");
    $DB = new DB();
	$DB2 = new DB();
	$DB3 = new DB();
    ## *** create calendar object
    $objCalendar = new Calendar();
    ## *** show debug info - false|true
    $objCalendar->Debug(false);
    ## +---------------------------------------------------------------------------+
    ## | 2. General Settings:                                                      | 
    ## +---------------------------------------------------------------------------+
    ## *** set form submission type: "get" or "post"
    /// $objCalendar->SetSubmissionType("post");
    ## *** get current timezone
    /// echo $objCalendar->GetCurrentTimeZone();
    ## *** set timezone
    ## *** (list of supported Timezones - http://us3.php.net/manual/en/timezones.php)
    $objCalendar->SetTimeZone("America/Los_Angeles");    
    ## *** set week day name length - "short" or "long"
    $objCalendar->SetWeekDayNameLength("long");
    ## *** set start day of week: from 1 (Sanday) to 7 (Saturday)
    $objCalendar->SetWeekStartedDay("1");
    ## *** define showing a week number of year
    $objCalendar->ShowWeekNumberOfYear(true);
    ## *** define caching parameters:
    ## *** 1st - allow caching or not, 2nd - caching lifetime in minutes
    $objCalendar->SetCachingParameters(false, 15);
    ## *** define all caching pages
    /// $objCalendar->DeleteCache();

    ## +---------------------------------------------------------------------------+
    ## | 3. Visual Settings:                                                       | 
    ## +---------------------------------------------------------------------------+
    ## *** set CSS style: "green"|"blue" - default
    $objCalendar->SetCssStyle("blue");
    ## *** set Add Event form type: "floating"|"popup" - default
    $objCalendar->SetAddEventFormType("floating");
    ## *** set calendar width and height
    $objCalendar->SetCalendarDimensions("458px", "650px");
    ## *** set default calendar view - "daily"|"weekly"|"monthly"|"yearly"
    $objCalendar->SetDefaultView("daily");
    ## *** set Sunday color - true|false
    $objCalendar->SetSundayColor(true);    
    ## *** define time format - 24|AM/PM
    $objCalendar->SetTimeFormat("12");    
    ## *** set calendar caption
    $objCalendar->SetCaption("W3VOLT");

    ## +---------------------------------------------------------------------------+
    ## | 4. Draw Calendar:                                                         | 
    ## +---------------------------------------------------------------------------+
	?>
    <table border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="my_volt_frame_TL"><img src="http://www.w3volt.com/images/my_volt_frame_TL.png" /></td> 

	<td id="my_volt_frame_T" background="http://www.w3volt.com/images/my_volt_frame_T.png" style="background-repeat:repeat-x;"></td>
	<td id="my_volt_frame_TR"><img src="http://www.w3volt.com/images/my_volt_frame_TR.png" /></td>
    </tr>
    <tr>
    <td id="my_volt_frame_L" background="http://www.w3volt.com/images/my_volt_frame_L.png" style="background-repeat:repeat-y;"></td>
	<td class="voltframecontent" valign="top" bgcolor="#FFFFFF">
  
    
    <?
    $objCalendar->Show($DB,$DB2, $DB3);
    
?>


</td>
   <td id="my_volt_frame_L" background="http://www.w3volt.com/images/my_volt_frame_R.png" style="background-repeat:repeat-y;"></td>
 </tr>
<tr>
	<td id="my_volt_frame_BL"><img src="http://www.w3volt.com/images/my_volt_frame_BL.png" /></td> 

	<td id="my_volt_frame_B" background="http://www.w3volt.com/images/my_volt_frame_B.png" style="background-repeat:repeat-x;"></td>
	<td id="my_volt_frame_BR"><img src="http://www.w3volt.com/images/my_volt_frame_BR.png" /></td>
    </tr>
 
</table>


</center>
<script type="text/javascript">
 parent.document.getElementById("readerframe").style.height = (document.body.scrollHeight)+'px' ;

//alert(document.body.scrollHeight);
</script>
</body>
</html>
