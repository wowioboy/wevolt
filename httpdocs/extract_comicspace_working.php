
<? 
function FetchPage($path)
{
$file = fopen($path, "r"); 

if (!$file)
{
exit("The was a connection error!");
} 
$data = '';

while (!feof($file))
{
// Extract the data from the file / url
$data .= fgets($file, 1024);
}
return $data;
}
?>
<?php
   require_once("includes/ExtractTextBetweenTags.class.php");
    $extracttext  = new ExtractTextBetweenTags();
 if ((!isset($_POST['submitlist'])) && (isset($_POST['txtUrl']))) {
 $ImportUrl = $_POST['txtUrl'];
$UrlArray1 = explode('http://www.comicspace.com/',$ImportUrl);
$UrlArray2 = explode('/',$UrlArray1[1]);
$UserString = $UrlArray2[0];
$text = file_get_contents($ImportUrl) or die('Could not grab the file');
$SelectStart = strpos($text, '<select name="jump_state" onchange="MM_jumpMenu(\'parent\',this,0)">');
$text = substr($text, $SelectStart, strlen($text));
$SelectStart = strpos($text, '<select name="jump_state" onchange="MM_jumpMenu(\'parent\',this,0)">');
$SelectStop = strpos($text, '</select>');
$text = substr($text, $SelectStart,($SelectStop+9));
$optionlist = $extracttext->extract($text,'<select name="jump_state" onchange="MM_jumpMenu(\'parent\',this,0)">','</select>');
	
} else if ((isset($_POST['submitlist'])) && (isset($_POST['txtUrl']))) {
	$PageArray = explode(',',$_POST['txtList']);
	 $ImportUrl = $_POST['txtUrl'];
	$UrlArray1 = explode('http://www.comicspace.com/',$ImportUrl);
	$UrlArray2 = explode('/',$UrlArray1[1]);
	$UserString = $UrlArray2[0];
	foreach ($PageArray as $page) {
		$url = 'http://www.comicspace.com/'.$page;
		$string = FetchPage($url);
		$PageTitleArray = explode('ComicSpace -',$extracttext->extract($string,"<title>",'</title>'));
		$PageTitle = explode('/',$PageTitleArray[1]);
		//echo "MY TITLE = " . $PageTitle[1];
	// Regex that extracts the images (full tag)
		$image_regex_src_url = '/<img[^>]*'.'src=["|\'](.*)["|\']/Ui';

		preg_match_all($image_regex_src_url, $string, $out, PREG_PATTERN_ORDER);

		$img_tag_array = $out[0];
		// Regex for SRC Value
		$image_regex_src_url = '/<img[^>]*'.'src=["|\'](.*)["|\']/Ui';

		preg_match_all($image_regex_src_url, $string, $out, PREG_PATTERN_ORDER);

		$images_url_array = $out[1];
		foreach ($images_url_array as $Image) {
			 $UploadedFound = strpos($Image, "uploaded");
			 $UserFound = strpos($Image, $UserString);
			if (($UploadedFound) && ($UserFound)) {
				print "Found!\n";
				$gif = file_get_contents('http://www.comicspace.com/'.$Image) or die('Could not grab the file');
				if (exif_imagetype('http://www.comicspace.com/'.$Image) == IMAGETYPE_GIF) {
					 $ext = 'gif';
				} else if (exif_imagetype('http://www.comicspace.com/'.$Image) == IMAGETYPE_JPEG) {
					$ext = 'jpg';
				} else if (exif_imagetype('http://www.comicspace.com/'.$Image) == IMAGETYPE_PNG) {
					$ext = 'png';
				}
				$randName = md5(rand() * time());
				$fp  = fopen('imported/temp/'.$randName.'.'.$ext, 'w+') or die('Could not create the file');
				fputs($fp, $gif) or die('Could not write to the file');
				fclose($fp);
				chmod('imported/temp/'.$randName.'.'.$ext,0777);
			}
	}
}
}
?>


<script type="text/javascript" language="javascript">
function getOptions() {
	var PageString = '';
	for(var i = 1; i < pagelist.options.length; i++) {
		if (i == 1) {
			PageString = pagelist.options[i].value;
		} else {
			PageString = PageString +','+pagelist.options[i].value;
		}
	}
	document.getElementById('PageHolder').value = PageString;
	//document.PageForm.submit();
}
</script>
<? if ((!isset($_POST['submitlist'])) && (!isset($_POST['txtUrl']))) {?>
Please Enter the full URL to the first page of your comic on ComicSpace
<form name="PageForm" method="post" action="extract_comicspace_working.php">
<input type="text" name="txtUrl" value="" style="width:300px">
<input type="submit" value="GRAB PAGES"></form>
<? }?>


<? if ((!isset($_POST['submitlist'])) && (isset($_POST['txtUrl']))) {?>
<form name="PageForm" method="post" action="extract_comicspace_working.php">
<select id='pagelist' name='pagelist'>
<? echo $optionlist;?>
</select>
<input type="hidden" value="" name="txtList" id="PageHolder">
<input type="hidden" value="1" name="submitlist">
<input type="hidden" value="<? echo $_POST['txtUrl'];?>" name="txtUrl">
<script type="text/javascript" language="javascript">
getOptions();
</script>

<? }?>