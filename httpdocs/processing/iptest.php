<?php
include '../includes/db.class.php';

$DB = new DB();
include("../classes/geoipcity.inc");
include("../classes/geoipregionvars.php");

$gi = geoip_open("/var/www/vhosts/panelflow.com/httpdocs/classes/GeoLiteCity.dat",GEOIP_STANDARD);

$query = "SELECT * from viewsbreakdown where Latitude='' limit 10000";
$DB->query($query);

while ($view = $DB->FetchNextObject()) {
$record = geoip_record_by_addr($gi,$view->remote);
$CountryName = mysql_real_escape_string($record->country_name);
$RegionName = mysql_real_escape_string($GEOIP_REGION_NAME[$record->country_code][$record->region]);
$CityName =  mysql_real_escape_string($record->city);
$Latitude = $record->latitude;
$Longitude = $record->longitude;
$ViewID = $view->ID;

$query = "UPDATE viewsbreakdown set CountryName='$CountryName', RegionName='$RegionName',CityName='$CityName',Latitude='$Latitude', Longitude='$Longitude' where ID='$ViewID'";
$DB->execute($query);
print $query.'<br/>';
}
$DB->close();
geoip_close($gi);

?>
