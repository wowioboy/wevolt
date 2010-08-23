<script type="text/javascript">
<? 
echo 'var json=[];';
include_once ('../includes/dbconfig.php');
$query = "SELECT distinct Latitude, Longitude FROM viewsbreakdown where comicid='$ComicID' and Latitude != '' and Longitude != '' limit 500";
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
		//print $query;
	 $result = mysql_query($query);
	 $count = 0;
        $nRows = mysql_num_rows($result);
        for ($i=0; $i< $nRows; $i++){
   	      $analytics = mysql_fetch_array($result); 
		  
		  echo 'json[0]={\'id\':'.$i.', \'lat\':'.$analytics['Latitude'].', \'lng\':'.$analytics['Longitude'].'};'; 		

} ?>
</script>