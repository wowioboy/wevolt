<?php 
set_time_limit(0);
//ini_set("max_execution_time","900");
//print ini_set("max_execution_time","900");
include 'includes/init.php';
include 'includes/image_resizer.php';
include 'includes/image_functions.php';
$ID = $_SESSION['userid'];

if (!isset($_SESSION['userid'])) {
header("location:login.php?ref=create_pdf.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?  if ((isset($_POST['txtUrl']))&&(isset($_GET['comicid']))){?>
 <link rel="stylesheet" type="text/css" href="/common/common.css"/>
<link rel="stylesheet" type="text/css" href="/common/lists.css"/>


<script language="JavaScript" type="text/javascript" src="/source/org/tool-man/core.js"></script>
<script language="JavaScript" type="text/javascript" src="/source/org/tool-man/events.js"></script>
<script language="JavaScript" type="text/javascript" src="/source/org/tool-man/css.js"></script>
<script language="JavaScript" type="text/javascript" src="/source/org/tool-man/coordinates.js"></script>
<script language="JavaScript" type="text/javascript" src="/source/org/tool-man/drag.js"></script>
<script language="JavaScript" type="text/javascript" src="/source/org/tool-man/dragsort.js"></script>
<script language="JavaScript" type="text/javascript" src="/source/org/tool-man/cookies.js"></script>

<script language="JavaScript" type="text/javascript">
	var dragsort = ToolMan.dragsort()
	var junkdrawer = ToolMan.junkdrawer()

	window.onload = function() {
		junkdrawer.restoreListOrder("boxes")
		dragsort.makeListSortable(document.getElementById("boxes"),
				saveOrder)
	}
	function refreshboxes() {
		junkdrawer.restoreListOrder("boxes")
		dragsort.makeListSortable(document.getElementById("boxes"),
				saveOrder)
	}

	function verticalOnly(item) {
		item.toolManDragGroup.verticalOnly()
	}

	function speak(id, what) {
		var element = document.getElementById(id);
		element.innerHTML = 'Clicked ' + what;
	}

	function saveOrder(item) {
		var group = item.toolManDragGroup
		var list = group.element.parentNode
		var id = list.getAttribute("id")
		if (id == null) return
		group.register('dragend', function() {
			ToolMan.cookies().set("list-" + id, 
					junkdrawer.serializeList(list), 365)
		})
	}


</script>
<? }?>
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">
function clear_processing() {
document.getElementById("processingdiv").style.display = 'none';
document.getElementById("finishdiv").style.display = '';

}

function clear_converting() {

		document.getElementById("converting").style.display = 'none';

}
function deleteimage(value) {
	if (confirm("Are you Sure you want to delete this Page?"))
		var Idnum = value.split("image");
		//alert(value);
		var CurrentIdString = document.getElementById("IdString").value;
		var CurrentImageString = document.getElementById("txtPages").value;
		var CurrentThumbString = document.getElementById("txtThumbs").value;
		var CurrentImages = CurrentImageString.split("||");
		var CurrentThumbs = CurrentThumbString.split(",");
		//alert( CurrentIdString);
		var CurrentIDs = CurrentIdString.split(",");
		
	//alert('current id string = ' + CurrentIdString);
	  // alert('CurrentImageString = ' + CurrentImageString);
		var NewIDString = '';
		var NewImageString = '';
		var NewThumbString = '';
		for (i=0;i<CurrentIDs.length;i++) {
	//	alert(CurrentIDs[i]);
		//alert(value);
			if (CurrentIDs[i] != value) {
				if (NewIDString == '') 
					NewIDString = CurrentIDs[i];
				else 
					NewIDString = NewIDString + ',' + CurrentIDs[i];
			} else {
				IDIndex = i;
			}
					
		}
	//alert(NewIDString);
		for (i=0;i<CurrentImages.length;i++) {
			if (IDIndex != i) {
				if (NewImageString == '') 
					NewImageString = CurrentImages[i];
				else 
					NewImageString = NewImageString + '||' + CurrentImages[i];
			}
					
		}
		
		for (i=0;i<CurrentThumbs.length;i++) {
			if (IDIndex != i) {
				if (NewThumbString == '') 
					NewThumbString = CurrentThumbs[i];
				else 
					NewThumbString = NewThumbString + ',' + CurrentThumbs[i];
			}
					
		}
		document.getElementById("IdString").value = NewIDString;
		document.getElementById("txtPages").value = NewImageString;
		document.getElementById("txtThumbs").value = NewThumbString;
		//alert(NewImageString);
		document.PageForm.action='create_pdf.php?comicid=<? echo $_GET['comicid'];?>';
		document.PageForm.submit();
	}

</script>
<title>PANEL FLOW - CREATE A PDF</title>

</head>

<body>
<?php include 'includes/header_content.php';?>

     <div class='contentwrapper'>
<div style="padding-right:2px;">

<? 

if (isset($_POST['reorder'])) {

$pdfDB = new DB();
$TotalArray = explode('||',$_POST['txtPages']);
$NumPages = sizeof($TotalArray);
unset($TotalArray);
$query = "UPDATE products_incomplete set TotalPages='$NumPages', ThumbList='".$_POST['txtThumbs']."', PageList='".$_POST['txtPages']."' where TempDirectory='".$_POST['tempdir']."'";
$pdfDB->query($query);
$pdfDB->close();
}


if ((!isset($_GET['comicid'])) && (!isset($_POST['txtUrl']))) {
echo "<div class='pageheader'>Please Select which comic you would like to create a PDF from</div>";
$query = "select * from comics where (CreatorID='$ID' or userid='$ID') and installed=1 ORDER BY title DESC";
//print $query;
  $result = mysql_query($query);
  $nRows = mysql_num_rows($result);
  $counter =0;
  $comicString = "<table width='99%' cellspacing='0' cellpadding='0' border='0'><tr>";
   for ($i=0; $i< $nRows; $i++){
   	$row = mysql_fetch_array($result);
	$UpdateDay = substr($row['PagesUpdated'], 5, 2); 
			$UpdateMonth = substr($row['PagesUpdated'], 8, 2); 
			$UpdateYear = substr($row['PagesUpdated'], 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;

	
	$comicString .= "<td valign='top' id='profilemodcontent'><div align='center'><div class='comictitlelist'>".stripslashes($row['title'])."</div><a href='create_pdf.php?comicid=".$row['comiccrypt']."'>";
	
	if ($row['Hosted'] == 1) {
	 $fileUrl = 'http://www.needcomics.com'.$row['thumb'];
	} else {
	 $fileUrl = $row['thumb'];
	}

		    	$AgetHeaders = @get_headers($fileUrl);
			if (preg_match("|200|", $AgetHeaders[0])) {
				$comicString .="<img src='".$fileUrl."' border='2' alt='LINK' style='border-color:#000000;' width='100' height='134'>";
			} else {
			 $comicString .="<img src='/images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000;'>";
			}
	
	
	$comicString .="</a><div class='smspacer'></div>";
	
		
	$comicString .="<div class='pages'>Pages: ".$row['pages']."</div></div><div class='lgspacer'></div></td>"; 
			 $counter++;
 				if ($counter == 5){
 					$comicString .= "</tr><tr>";
 					$counter = 0;
 				}
	}
		if ($counter < 5){
 					while($counter < 5) {
					$comicString .= "<td id='profilemodcontent'></td>";
					$counter++;
					}
 				}
	 $comicString .= "</tr></table>";
	echo  $comicString;
} else if (!isset($_POST['txtUrl'])) {?>
<div style="padding:30px;">
<div class="pageheader">Please Enter the full URL to your Panel Flow Install Directory.</div> <span style="font-size:12px;">This should be were the Panel Flow Application is installed on your server, not the path to your comic. (http://www.mydomain.com/panelflowdirectory/)</span>
<div class="spacer"></div>
<form name="PageForm" method="post" action="create_pdf.php?comicid=<? echo $_GET['comicid'];?>">
<input type="text" name="txtUrl" value="" style="width:300px">
<input type="submit" value="GRAB PAGES"></form></div>
<? } else if ((isset($_POST['txtUrl']))&&(isset($_GET['comicid'])) && (!isset($_POST['reorder']))){?>

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

<div id='processingdiv' style="padding-left:40px;padding-right:25px; padding-top:10px;">
<div class="pageheader">Processing your pages, please wait...</div> <div class='spacer'></div>
<div align="center"><img src="images/processingbar.gif" /><div class="spacer"></div></div>
</div>


<? $randDirectory = md5(rand() * time());
if(!is_dir("imported/temp/".$randDirectory)) mkdir("imported/temp/".$randDirectory, 0755); 
if(!is_dir("imported/temp/".$randDirectory."/thumbs")) mkdir("imported/temp/".$randDirectory."/thumbs", 0755); 
			
?>
<? 
$ImportUrl = $_POST['txtUrl'];
$PageList = file_get_contents($ImportUrl.'export_pages.php?comicid='.$_GET['comicid']);
$images_url_array = explode('||',$PageList);?>
<form name="PageForm" method="post" action="process_pdf.php?comicid=<? echo $_GET['comicid'];?>">

<div id='finishdiv' class="pageheader" style="display:none;padding-left:40px;padding-right:30px;padding-top:5px;">Below are the pages imported, please remove any unwanted pages and click COMPILE PDF.

<div align="center" style="padding:5px;">

<input type="hidden" name="txtUrl" value="<? echo $_POST['txtUrl'];?>" >
<input type="hidden" name="finish" value="1" >
<input type="hidden" name="txtComic" value="<? echo $_GET['comicid'];?>" >
<input type="hidden" name="tempdir" value="<? echo $randDirectory;?>" >
<input type="submit" value="COMPILE PDF"></div>
</div>
<div class='spacer'></div>
 <div id='projectimages' align="center">
   <span style="font-size:14px;">  You can reorder your images by dragging into place, when finished, click -> </span><input class="inspector" type="button" value="SAVE ORDER" onclick="junkdrawer.inspectListOrder('boxes','<? echo $randDirectory;?>','pdf')"/> 
     <div id='imagelisting'>
<?php

$Count=0;
$Times=0;
$TimesCount = 0;
	$NewPages = '';
	$IDString = '';
	echo '<ul id="boxes">';
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
				$fp  = fopen('imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext, 'w+') or die('Could not create the file');
				fputs($fp, $gif) or die('Could not write to the file');
				fclose($fp);
				chmod('imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext,0777);
				$CurrentFile = 'imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext;
				list($width,$height)=getimagesize($CurrentFile);
				
				if ($width > 800) {
					$convertString = "convert $CurrentFile -resize 800 $CurrentFile";
					exec($convertString);	
				}
				if ($height > 1214) {
					$convertString = "convert $CurrentFile -resize x1214 $CurrentFile";
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
					$ThumbString .= ','.$Thumbsm;
					
				$ThumbNameArray = explode('/',$Thumbsm);
	 			$ThumbName = $ThumbNameArray[4];
	 			$ImageArray = explode('/',$CurrentFile);
	 			$ImageName = $ImageArray[3];	
				
				echo  "<li class=\"box\" id='box".$Count."'><span id=\"image".$Count."--".$ThumbName."--".$ImageName."\"></span><img src=\"".$Thumbsm."\" vspace=\"3\" hspace=\"3\"><div style='height:3px;'></div><a href=\"javascript:void(0)\" onClick=\"deleteimage('image".$Count."');\">[delete]</a></li>";
			}
			echo "</ul>";
			
			$pdfDB = new DB();
			$query = "INSERT into products_incomplete (UserID, ComicID, TotalPages, TempDirectory, ThumbList, PageList) values ('".$_GET['comicid']."','".$_SESSION['userid']."','$Count','$randDirectory','$ThumbString;','$NewPages')";
			$pdfDB->query($query);
			$pdfDB->close();
			?>
            <script type="text/javascript">
			clear_processing();
            </script>

</div>
</div>
<div style="clear: left;"><br/></div>
<input type="hidden" name="txtPages" value="<? echo $NewPages;?>" id='txtPages'>
<input type="hidden" name="txtThumbs" value="<? echo $ThumbString;?>" id='txtThumbs'>
<input type="hidden" name="txtIDs" value="<? echo $IDString;?>" id='IdString'>
<input type="hidden" name="reorder" value="1" />

<input type="hidden" name="txtTotalPages" value="<? echo ($Count-1);?>" />
</form>
<? } else {?>

<form name="PageForm" method="post" action="process_pdf.php?comicid=<? echo $_GET['comicid'];?>">

<div id='finishdiv' class="pageheader" style="padding-left:40px;padding-right:30px;padding-top:5px;">Below are the pages imported, please remove any unwanted pages and click COMPILE PDF.

<div align="center" style="padding:5px;">

<input type="hidden" name="txtUrl" value="<? echo $_POST['txtUrl'];?>" >
<input type="hidden" name="finish" value="1" >
<input type="hidden" name="txtComic" value="<? echo $_GET['comicid'];?>" id='txtComic' >
<input type="hidden" name="tempdir" value="<? echo $_POST['tempdir'];?>" >

<input type="submit" value="COMPILE PDF"></div>
</div>
<div class='spacer'></div>
 <div id='projectimages' align="center">
   <span style="font-size:14px;">  You can reorder your images by dragging into place, when finished, click -> </span><input class="inspector" type="button" value="SAVE ORDER" onclick="junkdrawer.inspectListOrder('boxes','<? echo $_POST['tempdir'];?>','pdf')"/> 
     <div id='imagelisting'>
     <? 
	 $ThumbArray = explode(',',$_POST['txtThumbs']);
	 $ImageArray = explode('||',$_POST['txtPages']);
	 $Count = 0;
	 $IDString = 0 ;
	 echo '<ul id="boxes">';
	 foreach ($ThumbArray as $thumb) {
	 	$ThumbNameArray = explode('/',$thumb);
	 	$ThumbName = $ThumbNameArray[4];
	 	$ImageNameArray = explode('/',$ImageArray[$Count]);
	 	$ImageName = $ImageNameArray[3];
	 	echo  "<li class=\"box\" id='box".$Count."'><span id=\"image".$Count."--".$ThumbName."--".$ImageName."\"></span><img src=\"".$thumb."\" vspace=\"3\" hspace=\"3\"><div style='height:3px;'></div><a href=\"javascript:void(0)\" onClick=\"deleteimage('image".$Count."');\">[delete]</a></li>";
	 if ($IDString == '') 
			$IDString =  'image'.$Count;
	else 
		$IDString .= ',image'.$Count;
		 $Count++;
	 }
	 	echo '</ul>';
	 
	 ?>
     </div>
</div>
<div style="clear: left;"><br/></div>
<input type="hidden" name="txtTotalPages" value="<? echo ($Count-1);?>" />
<input type="hidden" name="txtPages" value="<? echo $_POST['txtPages'];?>" id='txtPages'>
<input type="hidden" name="txtThumbs" value="<? echo $_POST['txtThumbs'];?>" id='txtThumbs'>
<input type="hidden" name="txtIDs" value="<? echo  $IDString;?>" id='IdString'>
<input type="hidden" name="reorder" value="1" />
<input type="hidden" name="txtEdit" value="<? $_POST['txtEdit'];?>" />
<input type="hidden" name="txtProductID" value="<? $_POST['txtProductID'];?>" />
</form>
<? }?>

</div>
  </div>
  <?php include 'includes/footer_v2.php';?>

</body>
</html>

