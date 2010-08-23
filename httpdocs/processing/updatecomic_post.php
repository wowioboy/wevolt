<?php
include '../includes/dbconfig.php';
include '../includes/email_functions.php';
$ID = $_POST['userid'];
if ($ID == "" ) {
$ID = $_POST['id'];
}
$ComicID = $_POST['comicid'];
$Action = $_POST['action'];
$Pages = $_POST['pages'];
$Remote = $_POST['remote'];
$Page = $_POST['page'];
$Date = date('Y-m-d H:i:s'); 
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');

if ($Action == 'info') {
$query = "SELECT url FROM $comicstable WHERE comiccrypt='$ComicID'";
$result = mysql_query($query);
$user = mysql_fetch_array($result);
$Url = $user['url'];
$xml_file = $Url.'/xml/infoXML.xml';
  $comic = array();
  $g_elem = null;
  
  function startElement( $parser, $name, $attrs ) 
  {
  global $comic, $g_elem;
  if ( $name == 'COMIC' )$comic []= array();
  $g_elem = $name;
  }
  
  function endElement( $parser, $name ) 
  {
  global $g_elem;
  $g_elem = null;
  }
  
  function textData( $parser, $text )
  {
  global $comic, $g_elem;
  if ( $g_elem == 'TITLE' ||
  $g_elem == 'CREATOR' ||
  $g_elem == 'WRITER' ||
  $g_elem == 'ARTIST'||
  $g_elem == 'COLORIST'||
  $g_elem == 'LETTERIST'||
  $g_elem == 'SYNOPSIS'||
  $g_elem == 'TEXTCOLOR' ||
  $g_elem == 'MOVIECOLOR' ||
  $g_elem == 'BARCOLOR' ||
  $g_elem == 'TAGS' ||
  $g_elem == 'GENRE'||
  $g_elem == 'HEADERIMAGE')
  {$comic[ count($comic ) - 1 ][ $g_elem ] = $text;

  }
  }
  
  $parser = xml_parser_create();
  
  xml_set_element_handler( $parser, "startElement", "endElement" );
  xml_set_character_data_handler( $parser, "textData" );
  
  $f = fopen( $xml_file, 'r' );
  
  while( $data = fread( $f, 4096 ) )
  {
 // print $data;
  // $data = htmlspecialchars($data);
  //echo "<br><br>";
    //print html_entity_decode(htmlentities($data));
	//print html_entity_decode($data);
  xml_parse( $parser, $data );
  }
  
  xml_parser_free( $parser );
  
  foreach($comic as $book )
  {
  if ($book['TITLE'] != ""){
  $Title = $book['TITLE'];
  $query = "UPDATE $comicstable SET title='$Title' WHERE comiccrypt='$ComicID' AND userid='$ID'";
  $result = mysql_query($query);
 // print $query;
 // print "MY COMIC TITLE = " . $Title;
  }
   if ($book['CREATOR'] != ""){
  $Creator = htmlspecialchars($book['CREATOR']);
  $query = "UPDATE $comicstable SET creator='$Creator' WHERE comiccrypt='$ComicID' AND userid='$ID'";
  $result = mysql_query($query);
  }
   if ($book['WRITER'] != ""){
  $Writer = htmlspecialchars($book['WRITER']);
  $query = "UPDATE $comicstable SET writer='$Writer' WHERE comiccrypt='$ComicID' AND userid='$ID'";
  $result = mysql_query($query);
  }
  if ($book['ARTIST'] != ""){
  $Artist = $book['ARTIST'];
  $query = "UPDATE $comicstable SET artist='$Artist' WHERE comiccrypt='$ComicID' AND userid='$ID'";
  $result = mysql_query($query);
  }
  if ($book['COLORIST'] != ""){
  $Colorist = $book['COLORIST'];
  $query = "UPDATE $comicstable SET colorist='$Colorist' WHERE comiccrypt='$ComicID' AND userid='$ID'";
  $result = mysql_query($query);
  }
  if ($book['LETTERIST'] != ""){
  $Letterist = $book['LETTERIST'];
  $query = "UPDATE $comicstable SET letterist='$Letterist' WHERE comiccrypt='$ComicID' AND userid='$ID'";
  $result = mysql_query($query);
  }
  if ($book['SYNOPSIS'] != ""){
  $Synopsis = $book['SYNOPSIS'];
  $query = "UPDATE $comicstable SET synopsis='$Synopsis' WHERE comiccrypt='$ComicID' AND userid='$ID'";
  $result = mysql_query($query);
  }
  if ($book['TEXTCOLOR'] != ""){
  $TextColor = $book['TEXTCOLOR'];
  }
  if ($book['MOVIECOLOR'] != ""){
   $MovieColor = $book['MOVIECOLOR'];
  }
  if ($book['BARCOLOR'] != ""){
   $BarColor = $book['BARCOLOR'];
  }
  if ($book['TAGS'] != ""){
   $Tags = $book['TAGS'];
   $query = "UPDATE $comicstable SET tags='$Tags' WHERE comiccrypt='$ComicID' AND userid='$ID'";
   $result = mysql_query($query);
  }
  if ($book['GENRE'] != ""){
     $Genre = $book['GENRE'];
	 $query = "UPDATE $comicstable SET genre='$Genre' WHERE comiccrypt='$ComicID' AND userid='$ID'";
     $result = mysql_query($query);
  }
   if ($book['HEADERIMAGE'] != ""){
     $HeaderImage = $book['HEADERIMAGE'];
  }
  }

} 
if ($Action == 'pages') {
$query = "SELECT title, pages,url FROM $comicstable WHERE comiccrypt='$ComicID'";
//print $query;
$result = mysql_query($query);
$comic = mysql_fetch_array($result);
$Previous = $comic['pages'];
$ComicTitle = $comic['title'];
$Url = $comic['url'];
$query = "UPDATE $comicstable SET pages='$Pages', PagesUpdated='$Date' WHERE comiccrypt='$ComicID'";
//print $query;
//print "PREVIOUS = " .$Previous."<br/>";
$result = mysql_query($query);
if ($Previous < $Pages) {
    $query = "SELECT * from favorites WHERE comicid='$ComicID' and notify=1";
	//print $query;
	$result = mysql_query($query);
	$nRows = mysql_num_rows($result);
	$TodayDate = date("Y-m-d"); 
	$Today = strtotime($TodayDate); 
	for ($i=0; $i< $nRows; $i++){
   		$favs = mysql_fetch_array($result);
			$UserID = $favs['userid'];
			$LastDate = $favs['lastnotify'];
			//print "LAST NOTIFY = " . $LastDate;
			$LastNotification = strtotime($LastDate); 
			if (($LastNotification != $Today) || ($LastDate == "")) { 
				$query = "UPDATE favorites set lastnotify='$TodayDate' WHERE userid='$UserID' and comicid='$ComicID'";
				//print $query;
				$result = mysql_query($query);
				$query = "SELECT email from $usertable WHERE encryptid='$UserID'";
				$result = mysql_query($query);
				$user = mysql_fetch_array($result);
				$Email = $user['email'];
				SendFavoriteEmail($ComicTitle, $Url, $Email); 
			} else { 
					$valid = "no"; 
			}
			
			
		}
	
	}
}

if ($Action == 'getpages') {
$query = "SELECT pages FROM $comicstable WHERE comiccrypt='$ComicID'";
//print $query;
$result = mysql_query($query);
$comic = mysql_fetch_array($result);
echo $comic['pages'];
}

if ($Action == 'tracking') {
 //Analytics
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
		print $query;
	} else {
		$query = "INSERT into analytics (date, hits, comicid, page, remote, AnalyticDate) values ('$today', 1, '$ComicID','$Page','$Remote','$AnalyticDate')";
		$result = mysql_query($query);	
	}
	$query = "UPDATE $comicstable set hits='$Hits' where comiccrypt='$ComicID'";
 	$result = mysql_query($query);
	
	
	$query = "SELECT ID FROM analytics WHERE comicid='$ComicID' AND date='$today'";
//print $query;
$result = mysql_query($query);
$view = mysql_fetch_array($result);
$AnalyticID = $view['ID'];

include("../classes/geoipcity.inc");
include("../classes/geoipregionvars.php");

$gi = geoip_open("/var/www/vhosts/panelflow.com/httpdocs/classes/GeoLiteCity.dat",GEOIP_STANDARD);

$record = geoip_record_by_addr($gi,$Remote);
$CountryName = $record->country_name;
$RegionName = $GEOIP_REGION_NAME[$record->country_code][$record->region];
$CityName =  $record->city;
$Latitude = $record->latitude;
$Longitude = $record->longitude;
geoip_close($gi);

	$query = "INSERT into viewsbreakdown (analyticid, comicid, date, page, remote, userid, CountryName, RegionName, CityName, Latitude, Longitude,AnalyticDate) values ('$AnalyticID','$ComicID','$today','$Page','$Remote','$ID','$CountryName', '$RegionName', '$CityName', '$Latitude', '$Longitude','$AnalyticDate')";
		$result = mysql_query($query);	
	
}
?>
