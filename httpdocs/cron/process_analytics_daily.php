#!/usr/bin/php -q
<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php');
$link = mysql_connect(PANELDBHOST, PANELDBUSER, PANELDBPASS);
mysql_select_db(PANELDB,$link);
$CurrentDayRange = date('Y-m-d 00:00:00');
if (intval(date('d')) != 1){
		$query = 'SHOW COLUMNS FROM panel_panel.analytics_breakdown;';
		$results = mysql_query($query);
		//print $query;
		$query = "INSERT INTO panel_analytics.current_month(SELECT ";
		while ($row = mysql_fetch_array($results)) {
			if ($row[0] == 'ID') {
				$query .= 'NULL, ';
			} else {
				$query .= $row[0] . ', ';
			}
		} 
		$query = substr($query, 0, strlen($query) - 2);
		$query .= " FROM panel_panel.analytics_breakdown WHERE AnalyticDate<'$CurrentDayRange')";
		mysql_query($query);
		//print $query.'<br/>';
		$query ="delete from panel_panel.analytics_breakdown WHERE AnalyticDate<'$CurrentDayRange'";
		mysql_query($query);
		//print $query.'<br/>';
}
mysql_close($link);
