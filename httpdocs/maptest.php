<? include 'includes/dbconfig.php';
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title>MarkerClusterer Example </title>
    <script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAA9AHcu8EJWKKN6mr5mUAbVRRI9cD3-wiBOpTR2sSvGBU01ofm1xR58K6Rwlu7snoDOChZSfOH0nWK9Q&sensor=false" type="text/javascript"></script>
    
	<script type="text/javascript" src="/scripts/markerclusterer.js"></script>

    <script type="text/javascript">
      function initialize() {
        if(GBrowserIsCompatible()) {
          var map = new GMap2(document.getElementById('map'));
		  var bounds = new GLatLngBounds();
          map.setCenter(new GLatLng(0, 0), 5);
          map.addControl(new GLargeMapControl());
          var icon = new GIcon(G_DEFAULT_ICON);
          icon.image = "http://chart.apis.google.com/chart?cht=mm&chs=24x32&chco=FFFFFF,008CFF,000000&ext=.png";
          var markers = [];
		  
		  <? $query = "SELECT distinct Latitude, Longitude FROM viewsbreakdown where comicid='0584ce56180' and Latitude != '' and Longitude != ''";
		//print $query;
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
  </head>
  <body onload="initialize()" onunload="GUnload()">
    <h3>A simple example of MarkerClusterer (100 markers)</h3>
    <p><a href="">Packed</a>&nbsp;|&nbsp;<a href="">Unpacked</a> version of the script.</p>

    <div id="map" style="width:600px;height:400px;"></div>
  </body>
</html>
