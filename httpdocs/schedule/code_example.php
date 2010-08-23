<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>W3VOLT SCHEDULE</title>
</head>

<body>
<center>

<?php
    
    ## +---------------------------------------------------------------------------+
    ## | 1. Creating & Calling:                                                    | 
    ## +---------------------------------------------------------------------------+
    // include calendar class and other files
    require_once("inc/connection.inc.php");
    require_once("calendar.class.php");
    
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
    $objCalendar->SetCalendarDimensions("800px", "500px");
    ## *** set default calendar view - "daily"|"weekly"|"monthly"|"yearly"
    $objCalendar->SetDefaultView("daily");
    ## *** set Sunday color - true|false
    $objCalendar->SetSundayColor(true);    
    ## *** define time format - 24|AM/PM
    $objCalendar->SetTimeFormat("24");    
    ## *** set calendar caption
    $objCalendar->SetCaption("W3VOLT");

    ## +---------------------------------------------------------------------------+
    ## | 4. Draw Calendar:                                                         | 
    ## +---------------------------------------------------------------------------+
    $objCalendar->Show();
    
?>
</center>
</body>
</html>
