<?
set_time_limit(0);
 if(!isset($_SESSION)) {
    session_start();
  }
include 'includes/db.class.php';
$BreakDB = new DB();
$PDFID = $_GET['bookid'];
$query = "SELECT * from products where EncryptID='$PDFID'";
$BookArray = $BreakDB->queryUniqueObject($query);
$ComicID = $BookArray->ComicID;
$UserID = $BookArray->UserID;
$ProductFileArray = explode('/',$BookArray->ProductFile);
$ProductFile = $ProductFileArray[3];
$query = "SELECT TotalPages from products_incomplete where ProductID='$PDFID'";
$TotalPages = $BreakDB->queryUniqueValue($query);
if (!isset($_SESSION['userid'])) {
	header("location:login.php");
}
if ($_SESSION['userid'] != $UserID) {
	header("location:/profile/".trim($_SESSION['username']));
}

include 'includes/image_resizer.php';
include 'includes/image_functions.php';
$imagetypes = array("image/jpeg", "image/gif");
function getImages($dir) { global $imagetypes; 
# array to hold return value 
$retval = array(); 
# add trailing slash if missing 
if(substr($dir, -1) != "/") $dir .= "/"; 
# full server path to directory  
$fulldir = "{$_SERVER['DOCUMENT_ROOT']}/$dir"; $d = @dir($fulldir) or die("getImages: Failed opening directory $dir for reading"); while(false !== ($entry = $d->read())) { 
# skip hidden files 

	if($entry[0] == ".") continue; 
# check for image files 
	$f = @escapeshellarg("$fulldir$entry"); 
	if(in_array($mimetype = trim( `file -bi $f` ), $imagetypes)) { 
		$retval[] = array( "file" => "/$dir$entry", "size" => getimagesize("$fulldir$entry") ); 

	}
} $d->close(); 
sort($retval);
return $retval; 

}
$randDirectory = md5(rand() * time());
$User = trim($_SESSION['username']);
//$User ='matteblack';
if(!is_dir("users/".$User."/pdfs/".$randDirectory)) mkdir("users/".$User."/pdfs/".$randDirectory, 0755); 
if(!is_dir("imported/temp/".$randDirectory)) mkdir("imported/temp/".$randDirectory, 0755); 
if(!is_dir("imported/temp/".$randDirectory."/thumbs")) mkdir("imported/temp/".$randDirectory."/thumbs", 0755); 

chdir('users/'.$User.'/pdfs/'.$randDirectory);
//echo getcwd();

$ImageName = 'page%03d.jpg';
//$pdfName = '../e22b75e6b90b63761699490ff7bbe632.pdf';
$pdfName = '../'.$ProductFile;
?>

    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head> 
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PANEL FLOW - EDIT E-BOOK</title>
<script type="text/javascript">
function submitform () {
	document.pdfform.submit();
}

</script>
</head>

<body>
<?php include 'includes/header_content_no_init.php';?>

     <div class='contentwrapper'>
<div style="padding-right:2px;">

<div style="padding-left:40px;padding-right:25px; padding-top:10px;" align="center">


<div id='processingdiv'>
	<div class="pageheader">Retrieving your E-BOOK...please wait</div> 
    <div class='spacer'></div>
    <div align="center">
        <img src="images/processingbar.gif" />
        <div class="spacer"></div>
    </div>
</div>

<div id='extractdiv' style="display:none;">
    <div class="pageheader">Extracting the current pages...please wait</div> 
    <div class='spacer'></div>
    <div align="center">
        <img src="images/processingbar.gif" />
    <div class="spacer"></div>
    <b>Number of Pages Processed</b>: [<span id='imagesprocessed' style='color:#339900;'>0</span> of <? echo $TotalPages;?>]
</div>
    </div>





</div>

</div>
  </div>
  <?php include 'includes/footer_noads.php';?>


<form method="post" action="create_pdf.php?comicid=<? echo $ComicID;?>" name="pdfform">
<input type="hidden" name="txtUrl" value="set" >
<?
$convertString = "convert -quality 100 $pdfName $ImageName";
$NewPages = '';
$ThumbString = '';
exec($convertString);
?>
<script type="text/javascript">
		document.getElementById("processingdiv").style.display ='none';
		document.getElementById("extractdiv").style.display ='';
</script>
<?	
//print $convertString;
chdir('/home/panel/public_html');
//echo getcwd();
$images = getImages('users/'.$User.'/pdfs/'.$randDirectory); 
//natsort($images);
$Count = 0;
	  foreach($images as $img) { 
	   	$FileArray = explode(".", basename($img['file']));
	  	$Filename = $FileArray[0];
		//print 'MY FILE = ' . basename($img['file'])."<br/>";
rename('users/'.$User.'/pdfs/'.$randDirectory.'/'.basename($img['file']),"imported/temp/".$randDirectory.'/'.basename($img['file']));
		chmod("imported/temp/".$randDirectory."/".basename($img['file']),0777);
		$image = new imageResizer("imported/temp/".$randDirectory.'/'.basename($img['file']));
		$Thumbsm = 'imported/temp/'.$randDirectory.'/thumbs/'.$Filename.'_tb.jpg';
		$image->resize(100, 100,100, 100);
		$image->save($Thumbsm, JPG);
		chmod($Thumbsm,0777);
		//print $Thumbsm."<br/>";
		if ($NewPages == '') 
			$NewPages =  "imported/temp/".$randDirectory."/".basename($img['file']);
		else 
			$NewPages .= "||imported/temp/".$randDirectory."/".basename($img['file']);
				
		if ($ThumbString == '') 
			$ThumbString =  $Thumbsm;
		else 
			$ThumbString .= ','.$Thumbsm;
			$Count++;
		?>
         <script type="text/javascript" language="javascript">
			document.getElementById("imagesprocessed").innerHTML ='<? echo $Count;?>';
		</script>
        <?
	}?>

<input type="hidden" name="txtComic" value="<? echo $ComicID?>" id='txtComic' >
<input type="hidden" name="tempdir" value="<? echo $randDirectory;?>" >
<input type="hidden" name="txtPages" value="<? echo $NewPages;?>" id='txtPages'>
<input type="hidden" name="txtThumbs" value="<? echo $ThumbString;?>" id='txtThumbs'>
<input type="hidden" name="reorder" value="1" />
<input type="hidden" name="txtEdit" value="1" />
<input type="hidden" name="txtProductID" value="<? echo $PDFID;?>" />
</form>
<script type="text/javascript">
submitform();
</script>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-4728151-3");
pageTracker._trackPageview();
</script>
</body>
</html>