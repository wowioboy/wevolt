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

    $extracttext  = new ExtractTextBetweenTags();
 if ((!isset($_POST['submitlist'])) && (isset($_POST['txtUrl']))) {
 $ImportUrl = $_POST['txtUrl'];
$UrlArray1 = explode('http://www.comicspace.com/',$ImportUrl);
$UrlArray2 = explode('/',$UrlArray1[1]);
$UserString = $UrlArray2[0];
$text = file_get_contents($ImportUrl) or die('Could not grab the file');
 
    $optionlist = $extracttext->extract($text,'<select name="jump_state" onchange="MM_jumpMenu(\'parent\',this,0)">','</select>');
	$SelectPosition = strpos($optionlist, "</select>");
	$optionlist =  substr($optionlist, 0, $SelectPosition);
	
} else if ((isset($_POST['submitlist'])) && (isset($_POST['txtUrl']))) {?>
<div  style="padding:15px;">
<div class="pageheader">Processing your pages, please wait...</div> <div class='spacer'></div>
<div align="center"><img src="images/processingbar.gif" /><div class="spacer"></div>
<div >Number of Images Processed: <span id='imagesprocessed'></span></div>
</div>
</div>


<?
	$PageArray = explode(',',$_POST['txtList']);
	 $ImportUrl = $_POST['txtUrl'];
	$UrlArray1 = explode('http://www.comicspace.com/',$ImportUrl);
	$UrlArray2 = explode('/',$UrlArray1[1]);
	$UserString = $UrlArray2[0];
$randDirectory = md5(rand() * time());
if(!is_dir("imported/temp/".$randDirectory)) mkdir("imported/temp/".$randDirectory, 0755); 
if(!is_dir("imported/temp/".$randDirectory."/thumbs")) mkdir("imported/temp/".$randDirectory."/thumbs", 0755); 
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
				if (strlen($Count) == 2) {
				$FileName = 'page_'.$Count;
				$TimesCount = 0;
			} else if (strlen($Count) == 3) {
				$FileName = 'page__'.$Count;
			}else { 
				$FileName = 'page'.$Count;
			}
			$Count++;
				$gif = file_get_contents('http://'.trim($Image)) or die('Could not grab the file');
				if (exif_imagetype('http://'.trim($Image)) == IMAGETYPE_GIF) {
					 $ext = 'gif';
				} else if (exif_imagetype('http://'.trim($Image)) == IMAGETYPE_JPEG) {
					$ext = 'jpg';
				} else if (exif_imagetype('http://'.trim($Image)) == IMAGETYPE_PNG) {
					$ext = 'png';
				}
				//$randName = md5(rand() * time());
			//if(!is_dir("imported/temp/".$randDirectory)) mkdir("imported/temp/".$randDirectory, 0777); 
			//if(!is_dir("imported/temp/".$randDirectory."/thumbs")) mkdir("imported/temp/".$randDirectory."/thumbs", 0777); 
				$fp  = fopen('imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext, 'w+') or die('Could not create the file');
				fputs($fp, $gif) or die('Could not write to the file');
				fclose($fp);
				chmod('imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext,0777);
				$CurrentFile = 'imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext;
				list($width,$height)=getimagesize($CurrentFile);
				
				if ($width > 1024) {
					$convertString = "convert $CurrentFile -resize 1024 $CurrentFile";
					exec($convertString);	
				}
				if ($height > 1600) {
					$convertString = "convert $CurrentFile -resize x1600 $CurrentFile";
					exec($convertString);	
				}
				
				if ($NewPages == '') 
					$NewPages =  'imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext;
				else 
					$NewPages .= '||imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext;
				
				if ($IDString == '') 
					$IDString =  'image'.$Count;
				else 
					$IDString .= ',image'.$Count;
					
				
						
				$image = new imageResizer('imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext);
				$Thumbsm = 'imported/temp/'.$randDirectory.'/thumbs/'.$FileName.'_tb.jpg';
				$image->resize(100, 100,100, 100);
				$image->save($Thumbsm, JPG);
				chmod($Thumbsm,0777);
				
				if ($ThumbString == '') 
					$ThumbString =  $Thumbsm;
				else 
					$ThumbString .= ','.$Thumbsm;?>
                    <script type="text/javascript" language="javascript">
						document.getElementById("imagesprocessed").value ='<? echo $Count;?>';
					</script>
                    <?
					
	}
	
}
?>
    <form name="FinishForm" method="post" action="import_pages.php?id=<? echo $_GET['id'];?>" id="FinishForm">
    <input type="hidden" name="txtPageList" value="<? echo $NewPages;?>"/>
    <input type="hidden" name="txtThumbList" value="<? echo $ThumbString;?>"/>
    <input type="hidden" name="txtIDString" value="<? echo $IDString;?>"/>
    <input type="hidden" name="tempdir" value="<? echo $randDirectory;?>"/>
     <input type="hidden" name="txtUrl" value="set"/>
    </form>
    <script type="text/javascript" language="javascript">
		document.FinishForm.submit();
	</script> 
    <?
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
	document.PageForm.submit();
}
</script>
<? if ((!isset($_POST['submitlist'])) && (!isset($_POST['txtUrl']))) {?>
Please Enter the full URL to the first page of your comic on ComicSpace
<form name="PageForm" method="post" action="extract_comicspace.php">
<input type="text" name="txtUrl" value="" style="width:300px">
<input type="submit" value="GRAB PAGES"></form>
<? }?>


<? if ((!isset($_POST['submitlist'])) && (isset($_POST['txtUrl']))) {?>
<form name="PageForm" method="post" action="extract_comicspace.php">
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