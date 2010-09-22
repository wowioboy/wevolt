<? 
include $_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php';
include  $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$chars = "1023456789ABCDEFGHIJKLMNOPQRSTUV";
$sub_type = $_GET['type'];
$redeemlink .= 'www.wevolt.com/offer.php';

$current=1;
$count = 50;
while ($current <= $count) {
	$i = 0;
	$authode = '' ;
	srand((double)microtime()*1000000);
	while ($i <= 7) {
			$num = rand() % 33;
			$tmp = substr($chars, $num, 1);
			$authode = $authode . $tmp;
			$i++;
	}
	$query = "SELECT count(*) from discount_code_subscriptions where code='$authcode'";
	$Found = $DB->queryUniqueValue($query);	
	if ($Found == 1)
		$authode .= '!';
	$query ="INSERT into discount_code_subscriptions (code, quanity, expire_date, sub_type) values ('$authode', 1, '".$_GET['expire']."','$sub_type')";
	$DB->execute($query);	
	print $query.'<br/>';
	$current++;	
	$output .= $authode."\r\n";
$output .= $redeemlink."\r\n";
$output .= "\r\n\r\n";
}


$newfile= $_SERVER['DOCUMENT_ROOT']."/exports/discount_code_endofyear_2010_".$sub_type.".txt";
$file = fopen ($newfile, "w");
fwrite($file, $output);
fclose ($file); 
chmod($newfile,0777);


