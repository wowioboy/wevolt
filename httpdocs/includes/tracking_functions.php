<? 

function getBrowser($userAgent) {
  // Create list of browsers with browser name as array key and user agent as value. 
	$browsers = array(
		'Opera' => 'Opera',
		'Mozilla Firefox'=> '(Firebird)|(Firefox)', // Use regular expressions as value to identify browser
		'Galeon' => 'Galeon',
		'Mozilla'=>'Gecko',
		'MyIE'=>'MyIE',
		'Lynx' => 'Lynx',
		'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
		'Konqueror'=>'Konqueror',
		'SearchBot' => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)',
		'Internet Explorer 7' => '(MSIE 7\.[0-9]+)',
		'Internet Explorer 6' => '(MSIE 6\.[0-9]+)',
		'Internet Explorer 5' => '(MSIE 5\.[0-9]+)',
		'Internet Explorer 4' => '(MSIE 4\.[0-9]+)',
	);

	foreach($browsers as $browser=>$pattern) { // Loop through $browsers array
    // Use regular expressions to check browser type
		if(eregi($pattern, $userAgent)) { // Check if a value in $browsers array matches current user agent.
			return $browser; // Browser was matched so return $browsers key
		}
	}
	return 'Unknown'; // Cannot find browser so return Unknown
}

function insertPageView($ProjectID,$Pagetracking,$Remote,$UserID,$Referal,$CurrentLink,$IsPro) {
 //Analytics
 global $InitDB;
 $browserType = getBrowser($_SERVER['HTTP_USER_AGENT']);
 if ($browserType != 'SearchBot') {
 if ($IsPro == '')
		$IsPro = 0;
 	include($_SERVER['DOCUMENT_ROOT']."/classes/geoipcity.inc");
	include($_SERVER['DOCUMENT_ROOT']."/classes/geoipregionvars.php");
	$today = date("Ymd"); 
	$AnalyticDate = date("Y-m-d 00:00:00"); 
	$CurrentTime = date("h:i:s");

	$query = "SELECT hits FROM projects WHERE ProjectID='$ProjectID'";
	$Hits = $InitDB->queryUniqueValue($query);
	$Output .= $query.'<br/>';	
	$Hits++;
	$query = "SELECT id, hits from analytics where ProjectID='$ProjectID' and date ='$today'";
	$analytic = $InitDB->queryUniqueObject($query);
	$Output .= $query.'<br/>';	
	if ($analytic->id != '') {
		$Todayhits = $analytic->hits;
		$Todayhits++;
		$query = "UPDATE analytics set hits='$Todayhits' where ProjectID='$ProjectID' and date='$today'";
		$InitDB->execute($query);
		$Output .= $query.'<br/>';	
		//print $query;
	} else {
		$query = "INSERT into analytics (date, hits, ProjectID, page, remote, AnalyticDate) values ('$today', 1, '$ProjectID','$Page','$Remote','$AnalyticDate')";
		$InitDB->execute($query);
		$Output .= $query.'<br/>';		
	}
	$query = "UPDATE comics set hits='$Hits' where comiccrypt='$ProjectID'";
 	$InitDB->execute($query);
	$Output .= $query.'<br/>';	
	$query = "UPDATE projects set hits='$Hits' where ProjectID='$ProjectID'";
 	$InitDB->execute($query);
	$Output .= $query.'<br/>';	
	
	
	$query = "SELECT ID FROM analytics WHERE ProjectID='$ProjectID' AND date='$today'";
	$AnalyticID = $InitDB->queryUniqueValue($query);
	$Output .= $query.'<br/>';	
	

	$gi = geoip_open($_SERVER['DOCUMENT_ROOT']."/classes/GeoLiteCity.dat",GEOIP_STANDARD);

	$record = geoip_record_by_addr($gi,$Remote);
	$CountryName = mysql_real_escape_string($record->country_name);
	$RegionName = mysql_real_escape_string($GEOIP_REGION_NAME[$record->country_code][$record->region]);
	$CityName =  mysql_real_escape_string($record->city);
	$Latitude = $record->latitude;
	$Longitude = $record->longitude;
	geoip_close($gi);
	
	$BaseRef = explode('/',$Referal);
	$Referal = $BaseRef[0];

	$query = "INSERT into analytics_breakdown (analyticid, ProjectID, date, page, remote, userid, CountryName, RegionName, CityName, Latitude, Longitude,Referal, AnalyticDate, Link, Browser, Time,ProView) values ('$AnalyticID','$ProjectID','$today','$Page','$Remote','$UserID','$CountryName', '$RegionName', '$CityName', '$Latitude', '$Longitude','$Referal', '$AnalyticDate','$CurrentLink','$browserType','$CurrentTime',$IsPro)";
	$InitDB->execute($query);	
	$Output .= $query.'<br/>';	
		
	return $Output;
}
} 

function insertUserReadLog($ProjectID,$UserID) {
 global $InitDB;
 $browserType = getBrowser($_SERVER['HTTP_USER_AGENT']);
 if ($browserType != 'SearchBot') {
 		$NOW = date('Y-m-d h:i:s');
		$query = "SELECT * from projects_read_log where ProjectID='$ProjectID' and UserID='$UserID'";
		$LogArray = $InitDB->queryUniqueObject($query);
		$Output .= $query.'<br/>';	
		if ($LogArray->ID == '') {
			 $query = "INSERT into projects_read_log (ProjectID, UserID, FirstVisit, LastVisit) values ('$ProjectID','$UserID','$NOW','$NOW')";
			 $InitDB->execute($query);
			 $Output .= $query.'<br/>';	
		} else {
			$TotalHits = $LogArray->TotalViews++;
			$query = "UPDATE projects_read_log set LastVisit ='$NOW', TotalViews='$TotalHits' where ProjectID='$ProjectID' and UserID='$UserID'";
			$InitDB->execute($query);
			$Output .= $query.'<br/>';	
		}
		return $Output;
	}
}
?>