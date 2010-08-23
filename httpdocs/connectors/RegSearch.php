<? 
include $_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php';
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$search = $_GET['keywords'];
$Select = $_GET['select'];

if ($_GET['keywords'] != '') {

	$SELECT = "SELECT  count(*) from users";	
	if ($Select == 'username')
		$where = " where username='".mysql_real_escape_string($_GET['keywords'])."'";
	else if ($Select == 'email')
		$where = " where email='".mysql_real_escape_string($_GET['keywords'])."'";
	$query = $SELECT . $where;
	$Found = $DB->queryUniqueValue($query);
	$DB->close();
	
	echo $Found;
}

 
?>