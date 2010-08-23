<? 
	function addpageview($ComicID,$Pagetracking,$Remote,$RemoteID) {
	include '../includes/dbconfig.php';
	mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
	mysql_select_db ($userdb) or die ('Could not select database.');
	$today = date("Ymd"); 
	$AnalyticDate = date("Y-m-d 00:00:00"); 
	$query = "SELECT hits FROM $comicstable WHERE comiccrypt='$ComicID'";
	$result = mysql_query($query);
	$comic = mysql_fetch_array($result);
	$Hits = $comic['hits']; 
	$Hits++;
	$query = "SELECT id, hits from analytics where comicid='$ComicID' and date ='$today' limit 1";
	$result = mysql_query($query);
    $analytic = mysql_fetch_array($result);
    $numrows = mysql_num_rows($result);
	if ($numrows == 1) {
		$Todayhits = $analytic['hits'];
		$Todayhits++;
		$query = "UPDATE analytics set hits='$Todayhits' where comicid='$ComicID' and date='$today'";
		$result = mysql_query($query);
		//print $query;
	} else {
		$query = "INSERT into analytics (date, hits, comicid, page, remote,AnalyticDate) values ('$today', 1, '$ComicID','$Page','$Remote','$AnalyticDate')";
		$result = mysql_query($query);	
	}
	$query = "UPDATE $comicstable set hits='$Hits' where comiccrypt='$ComicID'";
 	$result = mysql_query($query);
	
	
	$query = "SELECT ID FROM analytics WHERE comicid='$ComicID' AND date='$today'";
//print $query;
$result = mysql_query($query);
$view = mysql_fetch_array($result);
$AnalyticID = $view['ID'];
	
	$query = "INSERT into viewsbreakdown (analyticid, comicid, date, page, remote, userid,AnalyticDate) values ('$AnalyticID','$ComicID','$today','$Page','$Remote','$ID','$AnalyticDate')";
		$result = mysql_query($query);	
	
}
?>