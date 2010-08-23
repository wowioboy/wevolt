<? include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php'; 
if ($_GET['keywords'] != '') {
	if (strlen($_GET['keywords']) < 5) {
		$result = '<div style="color:#ff2d1d;">Code MUST be minimum 5 Alphanumeric letters</div>';
	} else if (ereg("[^A-Za-z0-9]",$_GET['keywords'])) {
		$result = '<div style="color:#ff2d1d;">Only letters and numbers can be used</div>';
	} else {
		
		$query = "SELECT count(*) from promotion_codes where promo_code='".mysql_real_escape_string($_GET['keywords'])."'";
		$Found = $InitDB->queryUniqueValue($query);
		if ($Found > 0)
			$result = '<div style="color:#ff2d1d;">Not Available</div>';
		else
			
			$result = '<div style="color:#3eaf00;">Code Available</div>';
	}
}
  
 echo $result;
?>