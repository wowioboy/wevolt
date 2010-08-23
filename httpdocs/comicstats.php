<?php 
include 'includes/init.php';
$DB = new DB();
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

if (!isset($_SESSION['userid'])) {
	header("location:login.php");
}
include 'includes/favorites_inc.php';
?>
<?php
include 'includes/dbconfig.php';

if ((isset($_POST['y'])) && (isset($_POST['m']))) {

	if ($_POST['m'] == '00'){
		$ThisMonth = $_POST['y'].'-01-01 00:00:00';
		$Month = $_POST['y'].'-01-01 00:00:00';
		
		$DateQuery = " and AnalyticDate>='$ThisMonth'";
		
	} else {
		
		$ThisMonth = $_POST['y'].'-' .$_POST['m'].'-';
		if ($_POST['d'] != '') 
			$ThisMonth .= $_POST['d'];
		else 	
			$ThisMonth .= '01';
		$ThisMonth .= ' 00:00:00';
		
		
		$LastDay = lastDay($_POST['m'], $_POST['y']);
		$SearchStart =  $ThisMonth;
		if ($_POST['d'] != '') 
			$SearchEnd =  $SearchStart;
		else 
			$SearchEnd =  $LastDay.' 00:00:00';
		
		$DateQuery = " and AnalyticDate>='".$SearchStart."' and AnalyticDate<='".$SearchEnd."'";
	}
} else {

	$ThisMonth = date('Y-m').'-01 00:00:00';
	$DateQuery = " and AnalyticDate>='$ThisMonth'";
}



$CurrentMonth = date('m');
$CurrentDay = date('d');
$CurrentYear = date('Y');
	
if (($_POST['m'] != $CurrentMonth) &&($_POST['m'] != '')) {
	
	if ($_POST['y'] == '')
		$SelectYear = $CurrentYear;
	else
		$SelectYear = $_POST['y'];

	if ((intval($_POST['m']) < 2) && (intval($SelectYear)<=2010))
	$ViewsTable = 'panel_analytics.viewsbreakdown_prior_02_2010';
	else
	$ViewsTable = 'panel_analytics.viewsbreakdown_'.$_POST['m'].'_'.$SelectYear;

} else {
	$ViewsTable = 'panel_panel.viewsbreakdown';

}

if ($_POST['m'] =='00')
	$DisplayDate = 'Year of '. date('Y',strtotime($ThisMonth));	
else if ($_POST['d'] !='')
	$DisplayDate = date('F, jS Y',strtotime($ThisMonth));
else 
	$DisplayDate = date('F Y',strtotime($ThisMonth));

mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
$ID = $_GET['comicid'];
$ComicID = $_GET['comicid'];
if (($ComicID == '') && ($ID=='')) {
	$ComicFolder = $_GET['comic'];
	 $query = "select * from $comicstable where SafeFolder='$ComicFolder'";
} else {
 $query = "select * from $comicstable where comiccrypt='$ID'";
}

     $result = mysql_query($query);
     $comic = mysql_fetch_array($result);
     $CreatorID = $comic['userid'];
	 $ComicID = $comic['comiccrypt'];
	 $SafeFolder = $comic['SafeFolder'];
	 $ComicCreatorID = $comic['CreatorID'];
	 $Title = $comic['title'];
	$Genre = stripslashes($comic['genre']);
 	 $Tags = stripslashes($comic['tags']);
	 $UpdateDay = substr($comic['updated'], 5, 2); 
	 $UpdateMonth = substr($comic['updated'], 8, 2); 
	 $UpdateYear = substr($comic['updated'], 0, 4);
	 $Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 	 $Short = stripslashes($comic['short']);
 	 $Synopsis = stripslashes($comic['synopsis']);
 	 $Writer = $comic['writer'];
	 $Creator = $comic['creator'];
 	 $Artist = stripslashes($comic['artist']);
	 $Letterist = stripslashes($comic['letterist']);
	 $Url = stripslashes($comic['url']);
	 $Cover = stripslashes($comic['cover']);
	 $Pages = stripslashes($comic['pages']);
	 
	 
	 
	 if (($CreatorID == $_SESSION['userid']) || ($ComicCreatorID  == $_SESSION['userid']) || (in_array($_SESSION['userid'],$SiteAdmins))) { 
	 
	 $favquery = "select * from favorites where comicid='$ComicID'";
     $favresult = mysql_query($favquery);
  	 $TotalFavs = mysql_num_rows($favresult);
	 	 $today = date("Ymd");
	 $query = "select c.hits, c.votes,c.AppInstallation,c.SafeFolder
			   from comics as c 
			   where c.comiccrypt='$ComicID'";

	 $result = mysql_query($query);
	 $hitcount = mysql_fetch_array($result);
	
	 $Totalhits = $hitcount['hits'];
	 $TotalVotes = $hitcount['votes'];
	 $InstallID = $hitcount['AppInstallation'];
	  $query = "select * from Applications where ID='$InstallID'";
	 $result = mysql_query($query);
	 $AppArray = mysql_fetch_array($result);
	 $Domain = $AppArray['Domain'];
	 $PFInstallPath = substr($AppArray['PFPath'],0,strlen($AppArray['PFPath'])-1);
	 
	// $query = "select sum(hits) as hits, date from analytics where comicid='$ComicID' ".$DateQuery." group by date ORDER BY date DESC";
	 $query = "SELECT count(remote) as PageViewsViews, comicid, date FROM ".$ViewsTable." where comicid='$ComicID' ".$DateQuery." group by date order by date desc";
	
	 $result = mysql_query($query);
	 $nRows = mysql_num_rows($result);
	 $graphValues = "";
	 $graphLabels = "";
	  for ($i=0; $i< $nRows; $i++){
   	      $analytics = mysql_fetch_array($result);
		  if ($graphValues != "") {
		  $graphValues .= ',';
		  $graphLabels .= ',';
		  }
		   $graphValues .= $analytics['PageViewsViews'];
		  
		  $graphLabels .= substr($analytics['date'], 4, 2). '-'.substr($analytics['date'], 6, 2). '-'.substr($analytics['date'], 0, 4);
		 //$graphLabels .= $analytics['date'];
	       
		   if ($analytics['date'] == $today)  {  
		  	 $TodayHits = $analytics['PageViewsViews'];
		   }
		   $Day = substr($analytics['date'], 6, 2);
		   $Month = substr($analytics['date'], 4, 2);
		   $Lastweek = $Day - 7;
		   $LastMonth = $Month - 1;
		   if ($Lastweek < 1) {
		       $Lastweek = 30 + $Lastweek; 
		   }
		    if ($LastMonth < 1) {
		       $LastMonth = 12;
		   }
		   if ($analytics['date'] == $today)  {  
		  	 $TodayHits = $analytics['PageViewsViews'];
		   }
		 
	      }
			
		$query = "SELECT count(distinct remote) as UniqueViews, comicid, date FROM ".$ViewsTable." where comicid='$ComicID' ".$DateQuery." group by date order by date desc";
		
	 $result = mysql_query($query);
	 $nRows = mysql_num_rows($result);
	 //print "MY ROWS = " . $nRows;
	 $uniquegraphValues = "";
	 $uniquegraphLabels = "";
	  for ($i=0; $i< $nRows; $i++){
   	      $analytics = mysql_fetch_array($result);
		  if ($uniquegraphValues != "") {
		  $uniquegraphValues .= ',';
		  $uniquegraphLabels .= ',';
		  }
		   $uniquegraphValues .= $analytics['UniqueViews'];
		   $uniquegraphLabels .= substr($analytics['date'], 4, 2). '-'.substr($analytics['date'], 6, 2). '-'.substr($analytics['date'], 0, 4);
	
		   if ($analytics['date'] == $today)  {  
		  	 $TodayUniqueHits = $analytics['UniqueViews'];
		   }
		   $Day = substr($analytics['date'], 6, 2);
		   $Month = substr($analytics['date'], 4, 2);
		   $Lastweek = $Day - 7;
		   $LastMonth = $Month - 1;
		   if ($Lastweek < 1) {
		       $Lastweek = 30 + $Lastweek; 
		   }
		    if ($LastMonth < 1) {
		       $LastMonth = 12;
		   }
		  		 
	      }
	 //Graph
	include('includes/graphs.inc.php');
    $graph = new BAR_GRAPH($graphType);
  	$graph->values = $graphValues;
     $graph->labels = $graphLabels;
	 $graph->showValues = 2;
	$graph->barWidth = 20;
	$graph->barLength =1.6;
	$graph->labelSize = 12;
	$graph->absValuesSize = 12;
	$graph->percValuesSize = 12;
	$graph->graphPadding = 10;
	$graph->graphBGColor = "#";
	$graph->graphBorder = "";
	$graph->barColors = "#ffa66e";
	$graph->barBGColor = "#";
	$graph->barBorder = "1px outset black";
	$graph->labelColor = "#000000";
	$graph->labelBGColor = "#";
	$graph->labelBorder = "";
	$graph->absValuesColor = "#000000";
	$graph->absValuesBGColor = "#FFFFFF";
	$graph->absValuesBorder = "2px groove white";
	
	 $uniquegraph = new BAR_GRAPH($graphType);
  	$uniquegraph->values = $uniquegraphValues;
     $uniquegraph->labels = $uniquegraphLabels;
	 $uniquegraph->showValues = 2;
	$uniquegraph->barWidth = 20;
	$uniquegraph->barLength =1.6;
	$uniquegraph->labelSize = 12;
	$uniquegraph->absValuesSize = 12;
	$uniquegraph->percValuesSize = 12;
	$uniquegraph->graphPadding = 10;
	$uniquegraph->graphBGColor = "#";
	$uniquegraph->graphBorder = "";
	$uniquegraph->barColors = "#ff6f14";
	$uniquegraph->barBGColor = "#";
	$uniquegraph->barBorder = "1px outset black";
	$uniquegraph->labelColor = "#000000";
	$uniquegraph->labelBGColor = "#";
	$uniquegraph->labelBorder = "";
	$uniquegraph->absValuesColor = "#000000";
	$uniquegraph->absValuesBGColor = "#FFFFFF";
	$uniquegraph->absValuesBorder = "2px groove white";
	 
	  $query = "SELECT distinct Referal FROM ".$ViewsTable." where comicid='$ComicID' and Referal !='$Domain' ".$DateQuery." group by Referal order by Referal desc";
		
	 $result = mysql_query($query);
	 $nRows = mysql_num_rows($result);
	 $RefString = "";
	 
	  for ($i=0; $i< $nRows; $i++){
   	      $referal = mysql_fetch_array($result);
			
		  $ReferalArray= explode('/',$referal['Referal']);
		  $query = "SELECT count(*) from ".$ViewsTable." where Referal='".$referal['Referal']."' and comicid='$ComicID' ".$DateQuery;
				  $TotalRefs = $DB->queryUniqueValue($query);
		  $Referal = $ReferalArray[0];
		  $ComicName = $_GET['comic'];
	
			  if (($Referal != $Domain) && ($referal['Referal'] != ''))
			  		$RefString .= '<div>'.$referal['Referal'].' ('.$TotalRefs.')</div>';
			  else if (($ReferalArray[1] != $ComicName)  && ($ReferalArray[1] != $PFInstallPath) && ($referal['Referal'] != ''))
			  		$RefString .= '<div>'.$referal['Referal'].'('.$TotalRefs.')</div>';
			
		  
		 }
	 
	   
	} else {
	 header("Location:/index.php");
	 }
	 
	 $DB->close();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - COMIC STATS FOR <?php echo $Title;?></title>
 <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;sensor=false&amp;key=ABQIAAAA9AHcu8EJWKKN6mr5mUAbVRRD5uOMjGT8nW146dOxZGDXo-6N6xQQt78AxwrYg7O5W8InYY-HXlL9kA" type="text/javascript"></script>

    
	

    

</head>

<?php include 'includes/header_template_new.php';?>
<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 

     <div class='contentwrapper'>
     <a name="top" id="top"></a>
 <table width="95%" border="0" cellspacing="0" cellpadding="0">
  <tr>

    <td  width="248" valign="top" align="right" style="padding-left:10px;">
	<div class="pageheader" align="left">COMIC STATS FOR <?php echo $Title;?></div><div class="medspacer"></div>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="207" class="infoheader" style="padding-left:10px;">TODAY'S HITS </td>
        <td width="295" class="infotext" align="left"><? echo $TodayHits; ?></td>
      </tr>
       <tr>
        <td width="207" class="infoheader" style="padding-left:10px;">TODAY'S UNIQUE HITS </td>
        <td width="295" class="infotext" align="left"><? echo $TodayUniqueHits; ?></td>
      </tr>
      <tr>
        <td colspan="2" class="smspacer"></td>
      </tr>
	   <tr>
        <td class="infoheader" style="padding-left:10px;">TOTAL PAGE HITS: </td>
        <td class="infotext" align="left"><? echo $Totalhits; ?></td>
      </tr>
	   <tr>
        <td colspan="2" class="smspacer"></td>
      </tr>
	   <tr>
        <td class="infoheader" style="padding-left:10px;">USERS FAVORITED COMIC: </td>
        <td class="infotext" align="left"><? echo $TotalFavs; ?></td>
      </tr>
	  <tr>
        <td colspan="2" class="smspacer"></td>
      </tr>
	   <tr>
        <td class="infoheader" style="padding-left:10px;">TOTAL VOTES: </td>
        <td class="infotext" align="left"><? echo $TotalVotes; ?></td>
      </tr>
	    <tr>
        <td class="usermenu" style="padding-left:10px;">[<a href="#referal">VIEW REFERRING SITES</a>]</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    <div class="spacer"></div>
     <div class="infoheader" align="left" style="border-bottom:#FF6600 1px solid; padding-bottom:3px;">STATISTICS DATE: <? echo $DisplayDate;?></div>
     <div align="left">
     <form action="/<? echo $ComicFolder;?>/stats/" method="post">
     <table><tr><td width="60">
     Year: <select name="y">
     <option value="2010" <? if (($_POST['y'] == '2010') || (!isset($_POST['y']))) echo 'selected';?>>2010</option>
      <option value="2009" <? if ($_POST['y'] == '2009')?>>2009</option>
     <option value="2008" <? if ($_POST['y'] == '2008') echo 'selected';?>>2008</option> 
     </select>&nbsp;&nbsp;</td><td width="105">Month: <select name="m">
     <option value="01" <? if (($_POST['m'] == '01') || ((!isset($_POST['m'])) && ($CurrentMonth == '01'))) echo 'selected';?>>January</option>
     <option value="02" <? if (($_POST['m'] == '02') || ((!isset($_POST['m'])) && ($CurrentMonth == '02'))) echo 'selected';?>>February</option>
     <option value="03" <? if (($_POST['m'] == '03') || ((!isset($_POST['m'])) && ($CurrentMonth == '03'))) echo 'selected';?>>March</option>
     <option value="04" <? if (($_POST['m'] == '04') || ((!isset($_POST['m'])) && ($CurrentMonth == '04'))) echo 'selected';?>>April</option>
     <option value="05" <? if (($_POST['m'] == '05') || ((!isset($_POST['m'])) && ($CurrentMonth == '05'))) echo 'selected';?>>May</option>
     <option value="06" <? if (($_POST['m'] == '06') || ((!isset($_POST['m'])) && ($CurrentMonth == '06'))) echo 'selected';?>>June</option>
     <option value="07" <? if (($_POST['m'] == '07') || ((!isset($_POST['m'])) && ($CurrentMonth == '07'))) echo 'selected';?>>July</option>
     <option value="08" <? if (($_POST['m'] == '08') || ((!isset($_POST['m'])) && ($CurrentMonth == '08'))) echo 'selected';?>>August</option>
     <option value="09" <? if (($_POST['m'] == '09') || ((!isset($_POST['m'])) && ($CurrentMonth == '09'))) echo 'selected';?>>September</option>
     <option value="10" <? if (($_POST['m'] == '10') || ((!isset($_POST['m'])) && ($CurrentMonth == '10'))) echo 'selected';?>>October</option>
    <option value="11" <? if (($_POST['m'] == '11') || ((!isset($_POST['m'])) && ($CurrentMonth == '11'))) echo 'selected';?>>November</option>
    <option value="12" <? if (($_POST['m'] == '12') || ((!isset($_POST['m'])) && ($CurrentMonth == '12'))) echo 'selected';?>>December</option>
    <option value="00" <? if ($_POST['m'] == '00') echo 'selected';?>>FULL YEAR</option>
     
     </select>&nbsp;&nbsp;</td>
       <td width="100">Day: <select name="d">
         <option value="" <? if ($_POST['d'] == '') echo 'selected';?>>--select--</option>
     <option value="01" <? if (($_POST['d'] == '01')) echo 'selected';?>>01</option>
     <option value="02" <? if (($_POST['d'] == '02')) echo 'selected';?>>02</option>
     <option value="03" <? if (($_POST['d'] == '03')) echo 'selected';?>>03</option>
     <option value="04" <? if (($_POST['d'] == '04')) echo 'selected';?>>04</option>
     <option value="05" <? if (($_POST['d'] == '05')) echo 'selected';?>>05</option>
     <option value="06" <? if (($_POST['d'] == '06')) echo 'selected';?>>06</option>
     <option value="07" <? if (($_POST['d'] == '07')) echo 'selected';?>>07</option>
     <option value="08" <? if (($_POST['d'] == '08')) echo 'selected';?>>08</option>
     <option value="09" <? if (($_POST['d'] == '09')) echo 'selected';?>>09</option>
     <option value="10" <? if (($_POST['d'] == '10')) echo 'selected';?>>10</option>
    <option value="11" <? if (($_POST['d'] == '11')) echo 'selected';?>>11</option>
    <option value="12" <? if (($_POST['d'] == '12')) echo 'selected';?>>12</option>
     <option value="13" <? if (($_POST['d'] == '13')) echo 'selected';?>>13</option>
     <option value="14" <? if (($_POST['d'] == '14')) echo 'selected';?>>14</option>
     <option value="15" <? if (($_POST['d'] == '15')) echo 'selected';?>>15</option>
     <option value="16" <? if (($_POST['d'] == '16')) echo 'selected';?>>16</option>
     <option value="17" <? if (($_POST['d'] == '17')) echo 'selected';?>>17</option>
     <option value="18" <? if (($_POST['d'] == '18')) echo 'selected';?>>18</option>
     <option value="19" <? if (($_POST['d'] == '19')) echo 'selected';?>>19</option>
     <option value="20" <? if (($_POST['d'] == '20')) echo 'selected';?>>20</option>
     <option value="21" <? if (($_POST['d'] == '21')) echo 'selected';?>>21</option>
     <option value="22" <? if (($_POST['d'] == '22')) echo 'selected';?>>22</option>
    <option value="23" <? if (($_POST['d'] == '23')) echo 'selected';?>>23</option>
    <option value="24" <? if (($_POST['d'] == '24')) echo 'selected';?>>24</option>
     <option value="25" <? if (($_POST['d'] == '25')) echo 'selected';?>>25</option>
     <option value="26" <? if (($_POST['d'] == '26')) echo 'selected';?>>26</option>
     <option value="27" <? if (($_POST['d'] == '27')) echo 'selected';?>>27</option>
     <option value="28" <? if (($_POST['d'] == '28')) echo 'selected';?>>28</option>
     <option value="29" <? if (($_POST['d'] == '29')) echo 'selected';?>>29</option>
     <option value="30" <? if (($_POST['d'] == '30')) echo 'selected';?>>30</option>
     <option value="31" <? if (($_POST['d'] == '31')) echo 'selected';?>>31</option>
     </select>&nbsp;&nbsp;</td>
   <td ><input type="submit" value="SUBMIT" name="submit"/></td>
     <? if (isset($_POST['submit'])) {?><td><input type="button" value="RESET" name="button" onclick="window.location='/<? echo $SafeFolder;?>/stats/';"/></td><? }?>
     
     </tr></table>
     </form>
     </div>
    <div class="spacer"></div>

    
   <div class="infoheader" align="left" style="border-bottom:#FF6600 1px solid; padding-bottom:3px;">READER LOCATIONS:</div>
   <div align="center">
    <div id="map" style="width: 675px; height: 400px;"><div style="padding:100px;text-align:center">LOADING YOUR READER MAP<br />
<img src="/pf_16_core/images/processingbar.gif" /></div></div> 
 	
    <noscript><b>JavaScript must be enabled in order for you to use Google Maps.</b> 
      However, it seems JavaScript is either disabled or not supported by your browser. 
      To view Google Maps, enable JavaScript by changing your browser options, and then 
      try again.
    </noscript>
    </div>
    <div class="spacer"></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign='top' style="padding-left:5px;" align="left"><div class="infoheader" style="border-bottom:#FF6600 1px solid; padding-bottom:3px;">PAGEVIEW STATISTICS</div> <div class="spacer"></div>
    <table cellpadding="0" cellspacing="0" border="0" width="100%" style="border:#999999 1px solid;">
    <tr><td align="left"><div class="infoheader">Pageviews</div></td><td><div class="infoheader">Unique Visitors</div> </td>
    <tr><td width="50%">

    
<? if ($Totalhits != 0)  { 
		echo $graph->create();
	} else { 
		echo "NO PAGE VIEW DATA AVALABLE YET";
	} ?>
    </td><td align="left" width="50%">
   
    <? if ($Totalhits != 0)  { 
		echo $uniquegraph->create();
	} else { 
		echo "NO PAGE VIEW DATA AVALABLE YET";
	} ?>
    </td></tr></table>
    </td>
   
  </tr>
</table>
<a name="referal" id="referal"></a>
<div align="left" style="padding-top:10px; border-bottom:#FF6600 1px solid; padding-bottom:3px;" class="infoheader">
REFERRING SITES <span class="usermenu">[<a href="#top">BACK TO TOP</a>]</span></div>
<div style="font-size:12px; padding-left:10px;" align="left">
<? echo $RefString;?>
</div>
</td></tr></table>
  </div>
 </div>
  <div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>
  <script type="text/javascript" src="/scripts/markerclusterer.js"></script>
  <script type="text/javascript">
      function showAddress() {
        if(GBrowserIsCompatible()) {
          var map = new GMap2(document.getElementById('map'));
		  
          map.setCenter(new GLatLng(0, 0), 5);
          map.addControl(new GLargeMapControl());
		  var bounds = new GLatLngBounds();
          var icon = new GIcon(G_DEFAULT_ICON);
          icon.image = "http://chart.apis.google.com/chart?cht=mm&chs=24x32&chco=FFFFFF,008CFF,000000&ext=.png";
          var markers = [];
		  
		  <? $query = "SELECT distinct Latitude, Longitude FROM ".$ViewsTable." where comicid='$ComicID' and Latitude != '' and Longitude != '' ".$DateQuery;
		
	 $result = mysql_query($query);
        $nRows = mysql_num_rows($result);
        for ($i=0; $i< $nRows; $i++){
   	      $analytics = mysql_fetch_array($result); ?>
		   var latlng = new GLatLng(<? echo $analytics['Latitude']; ?>, <? echo $analytics['Longitude']; ?>);
            var marker = new GMarker(latlng, {icon: icon});
            markers.push(marker);
		     // map.addOverlay(marker);
		     //bounds.extend(marker.getPoint());
	  <?	} ?>
		  
         //for (var i = 0; i < 100; ++i) {
           // var latlng = new GLatLng(data.photos[i].latitude, data.photos[i].longitude);
            //var marker = new GMarker(latlng, {icon: icon});
            //markers.push(marker);
          //}
          var markerCluster = new MarkerClusterer(map, markers);
		  if (map.getBoundsZoomLevel(bounds) < 5)  
      map.setZoom(map.getBoundsZoomLevel(bounds)); 
      map.setCenter(bounds.getCenter());
        }
      }
    </script>
<script type="text/javascript">
showAddress();

</script>

</body>
</html>

