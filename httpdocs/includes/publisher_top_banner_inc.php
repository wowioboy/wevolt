<? 
include $_SERVER['DOCUMENT_ROOT'].'/classes/defineThis.php';
include  $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';
$DB = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
$Project = $_GET['project'];
$query = "SELECT a.AdTag728
          from projects as p
		  join comic_settings as ps on ps.ComicID=p.ProjectID
		  join ad_tags as a on ps.tag_id=a.id
		  where p.SafeFolder='$Project'";
$AdTag = $DB->queryUniqueValue($query);

$DB->close(); 
if ($AdTag == '') {
	$AdTag = "<!-- AD TAG BEGINS: WeVolt(gr.wevolt) / pub2 / 728x90 -->
<script type=\"text/javascript\">
	var gr_ads_zone = 'pub2';
	var gr_ads_size = '728x90';
</script>
<script type=\"text/javascript\" src=\"http://a.giantrealm.com/gr.wevolt/a.js\"> 
</script>
<noscript>
	<a href=\"http://ans.giantrealm.com/click/gr.wevolt/pub2;tile=1;sz=728x90;ord=1234567890\">
		<img src=\"http://ans.giantrealm.com/img/gr.wevolt/pub2;tile=1;sz=728x90;ord=1234567890\" width=\"728\" height=\"90\" alt=\"advertisement\" />
	</a>
</noscript>
<!-- AD TAG ENDS: WeVolt / pub2 / 728x90 -->"	;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
body,html {
padding:0px;
margin:0px;
}
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<body>
<? echo $AdTag;?>
</body>
</html>