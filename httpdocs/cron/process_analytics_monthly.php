#!/usr/bin/php -q
<? 
include_once('/var/www/vhosts/wevolt.com/httpdocs/classes/defineThis.php');
include '/var/www/vhosts/wevolt.com/httpdocs/includes/db.class.php';
$DB =  new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

function lastDay($month, $year){
    $lastDay;
    $longMonths = array(1,3,5,7,8,10,12);    // Months that end in 31
    $shortMonths = array(4,6,9,11);            // Months that end in 30
    if(in_array($month,$longMonths))
        $lastDay=31;
    else if(in_array($month, $shortMonths))
        $lastDay=30;
    else if($month==2){                        // February, check for leap year
        if(date('L',mktime(0,0,0,1,1,$year))==1 )
            $lastDay = 29;
        else $lastDay =28;
    }
    return date('Y-m-d',mktime(0,0,0,$month,$lastDay,$year));
}

$CurrentYear = date('Y');
$CurrentMonth = date('m');

$LastMonth = date('m') - 1;
$SelectYear = date('Y');

if ($LastMonth == 0)
{
	$LastMonth = 12;
	$SelectYear = $SelectYear - 1;
}
if (strlen($LastMonth) <2) 
	$LastMonth ='0'.$LastMonth;
	

$LastMonthStart =  "$SelectYear-$LastMonth-01 00:00:00";
$LastMonthEnd =  lastDay($LastMonth, $SelectYear) . ' 00:00:00';

// PROCESS DAILY FIRST
$query = 'SHOW COLUMNS FROM panel_panel.analytics_breakdown;';
$results = mysql_query($query);
$query = "INSERT INTO panel_analytics.current_month(SELECT ";
while ($row = mysql_fetch_array($results)) {
		if ($row[0] == 'ID') {
			$query .= 'NULL, ';
		} else {
			$query .= $row[0] . ', ';
		}
} 
				
$query = substr($query, 0, strlen($query) - 2);
$query .= " FROM panel_panel.analytics_breakdown WHERE AnalyticDate='$LastMonthEnd')";
mysql_query($query);

$query ="delete from panel_panel.analytics_breakdown WHERE AnalyticDate='$LastMonthEnd'";
mysql_query($query);
		
//PROCESS MONTHLY
$query = "CREATE TABLE panel_analytics.viewsbreakdown_".$LastMonth."_".$SelectYear." SELECT * FROM panel_analytics.current_month WHERE (AnalyticDate>='$LastMonthStart' and AnalyticDate<='$LastMonthEnd')";
$DB->execute($query);
//print $query.'<br/>';

$query = "DELETE from panel_analytics.current_month where AnalyticDate<'".$CurrentYear."-".$CurrentMonth."-01 00:00:00'";
$DB->execute($query);
$DB->close();

?>