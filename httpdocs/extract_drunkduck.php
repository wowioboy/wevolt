<? 
set_time_limit(0);
include 'includes/init.php';
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


<head>
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - IMPORT PAGES</title>

</head>

<body>
<?php include 'includes/header_content.php';?>
<?php
include 'includes/image_resizer.php';
include 'includes/image_functions.php';
   require_once("includes/ExtractTextBetweenTags.class.php");
    $extracttext  = new ExtractTextBetweenTags();
 if ((!isset($_POST['submitlist'])) && (isset($_POST['txtUrl']))) {
 $ImportUrl = $_POST['txtUrl'];
$UrlArray1 = explode('http://www.drunkduck.com/',$ImportUrl);
$UrlArray2 = explode('/',$UrlArray1[1]);
$UserString = $UrlArray2[0];

} else if ((isset($_POST['submitlist'])) && (isset($_POST['txtUrl']))) {?>
<div style="padding-left:40px; padding-right:25px; height:300px; padding-top:10px;" align="center">

<div class="pageheader">Processing your pages, please wait...</div> 
<div class='spacer'></div>
<span style="font-size:12px;">Depending on the number of pages and size of images this could take several minutes</span>
<div class='spacer'></div>
<span style="font-size:12px;">COMIC URL: <? echo $_POST['txtUrl'];?></span>
<div class="spacer"></div>
<div align="center"><img src="/images/processingbar.gif" />
<div class="spacer"></div>
<div style="font-size:14px;"><b>Number of Pages Processed</b>: [<span id='imagesprocessed' style='color:#339900;'></span>]
</div>
</div>
</div>
  <?php include 'includes/footer_v2.php';?>
<?
	$PageArray = explode(',',$_POST['txtList']);
$ImportUrl = $_POST['txtUrl'];
$UrlArray1 = explode('http://www.drunkduck.com/',$ImportUrl);
$UrlArray2 = explode('/',$UrlArray1[1]);
$UserString = $UrlArray2[0];
$randDirectory = md5(rand() * time());
if(!is_dir("imported/temp/".$randDirectory)) mkdir("imported/temp/".$randDirectory, 0755); 
if(!is_dir("imported/temp/".$randDirectory."/thumbs")) mkdir("imported/temp/".$randDirectory."/thumbs", 0755); 
	foreach ($PageArray as $page) {
		$url = 'http://www.drunkduck.com/'.$UserString.'/index.php?p='.$page;
		$string = FetchPage($url);
		//print "MY URL = " .$url; 
    	$PageTitle = explode(':',$extracttext->extract($string,"<title>",'</title>'));
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
		 	 $UploadedFound = strpos($Image, "pages");
			 $ServerFound = strpos($Image, "comics.drunkduck.com");
			 $UserFound = strpos($Image, $UserString);
			if (($UploadedFound == true) && ($UserFound == true) && ($ServerFound  == true)){
				if (strlen($Count) == 2) {
					$FileName = 'page_'.$Count;
					$TimesCount = 0;
				} else if (strlen($Count) == 3) {
					$FileName = 'page__'.$Count;
				}else { 
					$FileName = 'page'.$Count;
				}
				$Count++;
				
				$gif = file_get_contents($Image) or die('Could not grab the file');
				if (exif_imagetype($Image) == IMAGETYPE_GIF) {
					 $ext = 'gif';
				} else if (exif_imagetype($Image) == IMAGETYPE_JPEG) {
					$ext = 'jpg';
				} else if (exif_imagetype($Image) == IMAGETYPE_PNG) {
					$ext = 'png';
				}
				
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
						document.getElementById("imagesprocessed").innerHTML ='<? echo $Count;?>';
					</script>
                    <?
					
		}
	}
	
}
?>
    <form name="FinishForm" method="post" action="/comic/import/<? echo $_GET['id'];?>/" id="FinishForm">
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


<? if ((!isset($_POST['submitlist'])) && (!isset($_POST['txtUrl']))) {?>
Please Enter the full URL to the <b> FIRST PAGE</b> of your comic on DrunkDuck<br>
ex: http://www.drunkduck.com/mycomic/index.php?p=512066
<form name="PageForm" method="post" action="/comic/import/drunkduck/<? echo $_GET['id'];?>/">
<input type="text" name="txtUrl" value="" style="width:300px">
<input type="submit" value="GRAB PAGES"></form>
<? }?>


<? if ((!isset($_POST['submitlist'])) && (isset($_POST['txtUrl']))) {?>
<script type="text/javascript" language="javascript">
function getOptions() {
	var PageString = '';
	if (document.getElementById('pagelist') != null) {
		for(var i = 1; i < document.PageForm.pagelist.options.length; i++) {
		if (i == 1) {
			PageString = document.PageForm.pagelist.options[i].value;
		} else {
			PageString = PageString +','+document.PageForm.pagelist.options[i].value;
		}
	}
	
	document.getElementById('PageHolder').value = PageString;
	document.PageForm.submit();
	}
	
}
</script>

<div  style="padding-left:40px; padding-right:25px; height:300px; padding-top:10px;" align="center">
<div class="pageheader">BUILDING PAGE LIST</div>
<div class="spacer"></div>
Please Wait...
<div class="spacer"></div>
<img src="/images/processingbar.gif" />
</div>

  <?php include 'includes/footer_v2.php';?>
  <? 
$text = file_get_contents($ImportUrl) or die('Could not grab the file');
$optionlist = $extracttext->extract($text,"<SELECT NAME='p' STYLE='WIDTH:100%;' onChange=\"return jump(this);\">",'</SELECT>');
?>
<div style="display:none;">
<form name="PageForm" method="post" action="/comic/import/drunkduck/<? echo $_GET['id'];?>/">
<select id='pagelist' name='pagelist'>
<? echo $optionlist;?>
</select>
<input type="hidden" value="" name="txtList" id="PageHolder">
<input type="hidden" value="1" name="submitlist">
<input type="hidden" value="<? echo $_POST['txtUrl'];?>" name="txtUrl">
</form>
</div>
<script type="text/javascript" language="javascript">
getOptions();
</script>

<? }?>
 

</body>
</html>

