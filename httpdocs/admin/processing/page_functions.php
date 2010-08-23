<?
if (($_GET['a'] == 'pages') && ($_POST['btnsubmit'] == 'YES')) {
	$db = new DB();
	$query = "DELETE from pages where id='$PageID'";
	$db->query($query);
}
?>