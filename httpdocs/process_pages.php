<?php 
set_time_limit(0);

//ini_set("max_execution_time","900");
//print ini_set("max_execution_time","900");
include 'includes/init.php';
include 'includes/image_resizer.php';
include 'includes/image_functions.php';
include 'classes/class_dirtool.php';
$ID = $_SESSION['userid'];

if (!isset($_SESSION['userid'])) {
	header("location:login.php?ref=import_pages.php?id=".$_GET['id']);
}
 $ImageArray = explode('||',$_POST['txtPages']);
 $TotalPages = sizeof($ImageArray);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<script type="text/javascript">
function clear_processing () {
	document.getElementById('processingdiv').style.display = 'none';
	document.getElementById('finisheddiv').style.display = '';
}
</script>
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Digital Publishing"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">


</script>
<title>PANEL FLOW - PROCESS PAGES</title>

</head>

<body>
<?php include 'includes/header_content.php';?>

     <div class='contentwrapper'>
<div style="padding-right:2px;">

<? if (isset($_POST['finish'])) {

	$Date = date('Y-m-d H:i:s'); 
	$Today = date('m-d-Y');
  $SafeFolder = $_GET['id'];
  $PageDB = new DB();
  $UserID = $_SESSION['userid'];
  $query = "select * from comics where SafeFolder='$SafeFolder'";
  $ComicArray = $PageDB->queryUniqueObject($query);
  $ComicURL = $ComicArray->url;
  $ComicID = $ComicArray->comiccrypt;
  $ComicFolder = $ComicArray->HostedUrl;
  $AppInstallID = $ComicArray->AppInstallation;
  $query = "SELECT * from Applications where ID ='$AppInstallID'";
  $ApplicationArray = $PageDB->queryUniqueObject($query);
  $ApplicationLink = "http://".$ApplicationArray->Domain."/".$ApplicationArray->PFPath;

?>
<div style="padding:15px; height:300px; padding-top:10px;" align="center" id='processingdiv'>
	<div class="pageheader" align="center">
    Processing your pages and importing them to your Panel Flow comic, depending on the number of pages and size of the images, this could take a few minutes
    </div> 
    
	<div class='spacer'></div>
	<div align="center">
		<img src="/images/processingbar.gif" />
		<div class="spacer"></div>
		<div style="font-size:14px;">
		<b>Number of Pages Processed</b>: [<span id='imagesprocessed' style='color:#339900;'></span> of <? echo $TotalPages;?>]
		</div>
	</div>
</div>

<div style="padding:15px; height:300px; padding-top:10px;display:none;" align="center" id='finisheddiv'>
	<div class="pageheader" align="center">
  Your Pages have been imported into your Panel Flow Comic. <div class="spacer"></div>
  Click <a href="/cms/edit/<? echo $_GET['id'];?>/">HERE</a> to return to the comic admin
    </div> 
	<div class='spacer'></div>
</div>

</div>
  </div>

  <?php include 'includes/footer_v2.php';?>
  <?

  $Count = 0;

   foreach ($ImageArray as $Page) {
  	$FileArray = explode('/',$Page);
	$FilesDirectory = $FileArray[2];
	$ext = substr(strrchr($Page, "."), 1);
	$randName = md5(rand() * time());
	$Filename = $randName . '.' . $ext;
	

		$FinalPageImage = 'comics/'.$ComicFolder .'/images/pages/'.$Filename;
		$IphoneSmImage = 'comics/'.$ComicFolder .'/iphone/images/pages/320/'.$Filename;
		$IphoneLgImage = 'comics/'.$ComicFolder .'/iphone/images/pages/480/'.$Filename;
	if ($width > 1024) {
		$convertString = "convert $Page -resize 1024 $FinalPageImage";
		exec($convertString);
		
	} else {
		copy($Page,$FinalPageImage);
	}
	list($width,$height)=getimagesize($FinalPageImage);
	$ImageDimensions = $width.'x'.$height;
	copy($Page,$FinalPageImage);
//Create Small Iphone Page
	$convertString = "convert $FinalPageImage -resize 320 $IphoneSmImage";
	exec($convertString);
//Create Large Iphone Page
	$convertString = "convert $FinalPageImage -resize 480 $IphoneLgImage";
	exec($convertString);
	$Page = 'comics/'.$ComicFolder .'/images/pages/'.$Filename;
	$image = new imageResizer($FinalPageImage);

		$Thumbsm = 'comics/'.$ComicFolder ."/images/pages/thumbs/".$randName . '_sm.' . $ext;
		$Thumbmd = 'comics/'.$ComicFolder ."/images/pages/thumbs/".$randName . '_md.' . $ext;
		$Thumblg = 'comics/'.$ComicFolder ."/images/pages/thumbs/".$randName . '_lg.' . $ext;
	
	$image->resize(110, 70, 110, 70);
	$image->save($Thumbsm, JPG);
	chmod($Thumbsm,0777);
	
	$image->resize(150, 200, 150, 200);
	$image->save($Thumbmd, JPG);
	chmod($Thumbmd,0777);

	$convertString = "convert $FinalPageImage -resize 480 -quality 60 $Thumblg";
	exec($convertString);
	chmod($Thumblg,0777);
	$query ="SELECT Position from comic_pages WHERE Position=(SELECT MAX(Position) FROM comic_pages where ComicID='$ComicID' and PageType='pages')";
	$NewPosition = $PageDB->queryUniqueValue($query);
	$NewPosition++;
	$Title = 'Page ' .$NewPosition; 

		$query = "INSERT into comic_pages(ComicID, Title, Comment, Image, ImageDimensions, Datelive, ThumbSm, ThumbMd, ThumbLg, Chapter, Episode, Filename, Position, UploadedBy,PageType) values ('$ComicID','$Title', '$Comment','$Filename','$ImageDimensions', '$Today','$Thumbsm','$Thumbmd','$Thumblg',0,0, '$Filename', $NewPosition,'$UserID','pages')";
		$PageDB->query($query);
		//print $query."<br/><br/>";
		$query ="SELECT pages from comics where comiccrypt='$ComicID'";
		$NumPages = $PageDB->queryUniqueValue($query);
		if (($NumPages == 0) ||($NumPages < 0)) {
			$NumPages = 1;
		} else {
			$NumPages++;
		}
		$query = "UPDATE comics SET pages='$NumPages', PagesUpdated='$Date' WHERE comiccrypt='$ComicID'";
		$PageDB->query($query);
		$query ="SELECT ID from comic_pages WHERE ComicID='$ComicID' and Position='$NewPosition' and PageType='pages'";
		$PageID = $PageDB->queryUniqueValue($query);

		$Encryptid = substr(md5($PageID), 0, 8).dechex($PageID);
		$query = "UPDATE comic_pages SET EncryptPageID='$Encryptid' WHERE ID='$PageID'";
		$PageDB->query($query);

		$Result = file_get_contents($ApplicationLink.'/connectors/import_comic.php?p='.$Encryptid.'&u='.$_SESSION['userid'].'&c='.$ComicID.'&image='.urlencode($Page));
	//	print 'my result = ' .$Result.';
	?>
     <script type="text/javascript" language="javascript">
		document.getElementById("imagesprocessed").innerHTML ='<? echo $Count;?>';
	</script>
    <?
	$Count++;
  }
?>
<script type="text/javascript" language="javascript">
	clear_processing();
</script>
<? 
$dir = new dirtool("./imported/temp/".$FilesDirectory);
$dir->delete();
$PageDB->close();
?>
  <? }?>

</body>
</html>

