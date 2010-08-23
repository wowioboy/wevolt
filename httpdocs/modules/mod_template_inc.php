<? 
$db = new DB();
$ModString = '';
if ($Content == 'comics') {
	$query = 'SELECT * from comics where NeedFeatured = 1 limit 5';
	$db->query($query);
	while ($line = $db->fetchNextObject()) { 
		$ModString .= '<img src="'.$line->thumb.'"><br/>'.$line->title.'<br/>';
	}

}
	

echo $ModString;

?>