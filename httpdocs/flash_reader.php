<? $ComicName = str_replace("_"," ",$_GET['name']);
$_SESSION['flashpages'] = 1;
$FlashHeight = 1;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>WEvolt | <? echo $ComicName;?> - dBook Reader</title>
<script type="text/javascript" src="http://www.wevolt.com/js/swfobject.js"></script>
<style type="text/javascript">

body, html {
padding:0px;
margin:0px;
}
</style>

</head>

<body bgcolor="#000000">
	<div id="flashreader"></div>
 
        <script type="text/javascript">
		var theWidth, theHeight;
// Window dimensions:
if (window.innerWidth) {
   theWidth=window.innerWidth;
}
else if (document.documentElement && document.documentElement.clientWidth) {
   theWidth=document.documentElement.clientWidth;
}
else if (document.body) {
theWidth=document.body.clientWidth;
}
if (window.innerHeight) {
theHeight=window.innerHeight;
}
else if (document.documentElement && document.documentElement.clientHeight) {
theHeight=document.documentElement.clientHeight;
}
else if (document.body) {
theHeight=document.body.clientHeight;
}

			var flashvars = {};
			flashvars.COMIC_URL = "";
			flashvars.DATA_URL = "http://www.wevolt.com/connectors/get_demo_pages_xml.php?content=<? echo $_GET['name'];?>___p___<? echo $_SESSION['flashpages'].$EpisodeQuery;?>___u___<? echo $_SESSION['userid'];?>___off___<? if ($_GET['part'] == '') echo '0'; else echo ($_GET['part']);?>___c___<? echo $_GET['chapter'];?>";
			var params = {};
				params.quality = "best";
				params.wmode = "transparent";
				params.allowfullscreen = "false";
				params.allowscriptaccess = "always";
			var attributes = {};
				attributes.id = "flashreader";
			swfobject.embedSWF("/flash/reader.swf", "flashreader", "100%", (theHeight-<? echo $FlashHeight;?>), "9.0.0", "/panelflow/flash/expressInstall.swf", flashvars, params, attributes);
		</script>
             
	<!-- ON RESIZE -->
	<script type="text/javascript" src="http://www.wevolt.com/js/resize.js"></script>

</body>
</html>
