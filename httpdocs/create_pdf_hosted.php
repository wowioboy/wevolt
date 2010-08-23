<?php 
set_time_limit(0);

//ini_set("max_execution_time","900");
//print ini_set("max_execution_time","900");
include 'includes/init.php';
include 'includes/image_resizer.php';
include 'includes/image_functions.php';
$ID = $_SESSION['userid'];
$_SESSION['uploadtype'] = 'pdf';
 
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

if (!isset($_SESSION['userid'])) {
header("location:login.php?ref=/create/pdf/");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<?  if ((isset($_GET['comic']))){
$PdfDB = new DB();
$SafeFolder = $_GET['comic'];
$query = "SELECT * from comics where SafeFolder ='$SafeFolder'";
$ComicArray = $PdfDB->queryUniqueObject($query);


$ComicID = $ComicArray->comiccrypt;
$ComicTitle = stripslashes($ComicArray->title);
$CreatorID = $ComicArray->CreatorID;
$ComicTags = stripslashes($ComicArray->tags);
$Synopsis = stripslashes($ComicArray->synopsis);
$Genre = $ComicArray->genre;
$Artist = $ComicArray->artist;
$Writer = $ComicArray->writer;
$Creator = $ComicArray->creator;
$HostedUrl = $ComicArray->HostedUrl;

$query = "SELECT * from comic_settings where ComicID ='$ComicID'";
$ComicSettingsArray = $PdfDB->queryUniqueObject($query);

$ComicFormat = $ComicSettingsArray->ComicFormat;

$PdfDB->close();
$randDirectory = $_POST['tempdir'];
$_SESSION['pdftempdirectory'] =$randDirectory;
?>

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
	function show_pricing() {
	if (document.getElementById("pricingdiv") != null)
		document.getElementById("pricingdiv").style.display = '';
	}

	function hide_pricing() {
	if (document.getElementById("pricingdiv") != null)
		document.getElementById("pricingdiv").style.display = 'none';
	}

	function hide_price_input() {
	if (document.getElementById("priceinputdiv") != null)
		document.getElementById("priceinputdiv").style.display = 'none';
		document.getElementById("txtPrice").value = '';

	}

	function show_price_input() {
	if (document.getElementById("priceinputdiv") != null)
		document.getElementById("priceinputdiv").style.display = '';

	}


</script>
<? }?>
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">
function clear_processing() {
	document.getElementById("processingdiv").style.display = 'none';
	document.getElementById("finishdiv").style.display = '';
	document.getElementById("tabtable").style.display = '';
	document.getElementById("savediv").style.display = '';
	
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
		document.PageForm.action='/create/pdf/<? echo $SafeFolder;?>/';
		document.PageForm.submit();
	}

	function infotab()
	{//alert(	document.getElementById("txtInfoClicked").value);
			document.getElementById("bookinfo").style.display = '';
			document.getElementById("infotab").className ='profiletabactive';
			document.getElementById("uploaddiv").style.display = 'none';
			document.getElementById("uploadtab").className ='profiletabinactive';
			document.getElementById("projectimages").style.display = 'none';
			document.getElementById("finishdiv").style.display = 'none';
			document.getElementById("pagestab").className ='profiletabinactive';
			document.getElementById("txtInfoClicked").value = 1;
			//alert(	document.getElementById("txtInfoClicked").value);
	}
	function uploadtab()
	{
			document.getElementById("bookinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			document.getElementById("uploaddiv").style.display = '';
			document.getElementById("uploadtab").className ='profiletabactive';
			document.getElementById("projectimages").style.display = 'none';
			document.getElementById("finishdiv").style.display = 'none';
			document.getElementById("pagestab").className ='profiletabinactive';
	}

	function pagestab()
	{
			document.getElementById("bookinfo").style.display = 'none';
			document.getElementById("infotab").className ='profiletabinactive';
			document.getElementById("uploaddiv").style.display = 'none';
			document.getElementById("uploadtab").className ='profiletabinactive';
			document.getElementById("projectimages").style.display = '';
			document.getElementById("pagestab").className ='profiletabactive';
			document.getElementById("finishdiv").style.display = '';
	}
	
	function rolloveractive(tabid, divid) {
		var divstate = document.getElementById(divid).style.display;
			if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='tabhover';
			} 
	}
	function rolloverinactive(tabid, divid) {
			if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='profiletabinactive';
			} 
	}
	
	function finishrollover() {
				document.getElementById("finishtab").className ='finishtabhover';

	}
	function finishrollout() {
				document.getElementById("finishtab").className ='finishtab';
	}

	function finish_pdf() {
	//alert(	document.getElementById("txtInfoClicked").value);
		document.PageForm.submit();
	}

</script>
<title>PANEL FLOW - CREATE A PDF</title>

</head>

<body>
<?php //include 'includes/header_content.php';?>

     <div class='contentwrapper'>
<div style="padding-right:2px;">

<? 

if (isset($_POST['reorder'])) {
$_SESSION['pdftempdirectory'] =$_POST['tempdir'];
	$pdfDB = new DB();
	$TotalArray = explode('||',$_POST['txtPages']);
	$NumPages = sizeof($TotalArray);
	unset($TotalArray);
	$query = "UPDATE products_incomplete set TotalPages='$NumPages', ThumbList='".$_POST['txtThumbs']."', PageList='".$_POST['txtPages']."' where TempDirectory='".$_POST['tempdir']."'";
	$pdfDB->query($query);
	$pdfDB->close();
}


if ((!isset($_GET['comic'])) && (!isset($_POST['txtUrl']))) {
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
			$comicString .= "<td valign='top' id='profilemodcontent'><div align='center'><div class='comictitlelist'>".stripslashes($row['title'])."</div><a href='/create/pdf/".$row['SafeFolder']."/'>";
	
			if ($row['Hosted'] == 1) {
					$fileUrl = 'http://www.needcomics.com/'.$row['thumb'];
				} else if (($row['Hosted'] == 2) && (substr($row['thumb'],0,4) != 'http'))  {
					$fileUrl = 'http://www.panelflow.com'.$row['thumb'];
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
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
} else {
	if ((isset($_GET['comic'])) && (!isset($_POST['reorder']))){?>
    <div id='processingdiv' style="padding-left:40px;padding-right:25px; padding-top:10px;">
	<div class="pageheader">Processing your pages, please wait...</div> <div class='spacer'></div>
	<div align="center"><img src="images/processingbar.gif" /><div class="spacer"></div></div>
	</div>
    <?
		 $randDirectory = md5(rand() * time());
		 $_SESSION['pdftempdirectory'] =$randDirectory;
		if(!is_dir("imported/temp/".$randDirectory)) mkdir("imported/temp/".$randDirectory, 0755); 
		if(!is_dir("imported/temp/".$randDirectory."/thumbs")) mkdir("imported/temp/".$randDirectory."/thumbs", 0755); 
		//$ImportUrl = $_POST['txtUrl'];
		//BUILD PAGE LIST FROM DATABASE;
		$PdfDB = new DB();
		$images_url_array = array();
		$query = "SELECT Image from comic_pages where ComicID ='$ComicID' and PageType='pages'";
		$PdfDB->query($query);
		  while ($line = $PdfDB->fetchNextObject()) {  
				$images_url_array[] = $line->Image;
		  } 
		$PdfDB->close();
		//$PageList = @file_get_contents($ImportUrl.'export_pages.php?comicid='.$_GET['comicid']);
		
	}
	
	
	?>
    <? if ((isset($_GET['comic'])) && (!isset($_POST['reorder']))){?>
    <div id='tabtable' style="display:none;">
    <? } else {?>
    <div id='tabtable'>
    <? }?>
 <table cellpadding="0" cellspacing="0" border="0" width="99%"> <tr>
<td class="profiletabactive" align="left" id='pagestab' onMouseOver="rolloveractive('pagestab','projectimages')" onMouseOut="rolloverinactive('pagestab','projectimages')" onclick="pagestab();">CURRENT PAGES</td>

<td width="5"></td>
<td class="profiletabinactive" align="left"id='uploadtab' onMouseOver="rolloveractive('uploadtab','uploaddiv')" onMouseOut="rolloverinactive('uploadtab','uploaddiv')" onclick="uploadtab();">ADD NEW PAGES</td>

<td width="5"></td>
<td class="profiletabinactive" align="left"  id='infotab' onMouseOver="rolloveractive('infotab','bookinfo')" onMouseOut="rolloverinactive('infotab','bookinfo')" onclick="infotab();"> CREDITS / FORMAT</td><td width="5"></td>
<td class="finishtab" align="left"  id='finishtab' onMouseOver="finishrollover()" onMouseOut="finishrollout()" onclick="finish_pdf();"> COMPILE PDF</td>

</tr>
</table>
</div>
<form name="PageForm" method="post" action="/process/pdf/<? echo $SafeFolder;?>/">
<? if ((isset($_GET['comic'])) && (!isset($_POST['reorder']))){?>
	<div id='finishdiv' class="stepheader" style="display:none; padding-left:30px;padding-right:30px;padding-top:5px;" align="center">
<? }else {?>
	<div id='finishdiv' class="stepheader" style="padding-left:30px;padding-right:30px;padding-top:5px;" align="center">
<? }?>Below are the current pages. You can remove, reposition or add new pages. When ready, fill out the CREDITS information and click COMPILE PDF.
<div align="center">

<input type="hidden" name="txtUrl" value="<? echo $_POST['txtUrl'];?>" >
<input type="hidden" name="finish" value="1" >
<input type="hidden" name="txtComic" value="<? echo $ComicID;?>" id='txtComic'>
<input type="hidden" name="txtSafeFolder" value="<? echo $_GET['comic'];?>" id='txtSafeFolder'>
<input type="hidden" name="tempdir" value="<? echo $randDirectory;?>" >
</div>
</div>
<div class='spacer'></div>
 <div id='projectimages' align="center">
 <? if ((isset($_GET['comic'])) && (!isset($_POST['reorder']))){?>
	<div id='savediv'  style="display:none; padding-left:30px;padding-right:30px;padding-top:5px;" align="center">
<? }else {?>
	<div id='savediv'  style="padding-left:30px;padding-right:30px;padding-top:5px;" align="center">
<? }?>
   <span style="font-size:14px;">  You can reorder your images by dragging into place, when finished, click -> </span><input class="inspector" type="button" value="SAVE ORDER" onclick="junkdrawer.inspectListOrder('boxes','<? echo $randDirectory;?>','pdf')"/> 
   </div>
     <div id='imagelisting'>
<?php
	if ((isset($_GET['comic'])) && (!isset($_POST['reorder']))){
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
			$_SESSION['pdf_nextpage'] = ($Count+1);
			
			
			if (exif_imagetype('comics/'.$HostedUrl.'/images/pages/'.trim($Image)) == IMAGETYPE_GIF) {
				 $ext = 'gif';
			} else if (exif_imagetype('comics/'.$HostedUrl.'/images/pages/'.trim($Image)) == IMAGETYPE_JPEG) {
				$ext = 'jpg';
			} else if (exif_imagetype('comics/'.$HostedUrl.'/images/pages/'.trim($Image)) == IMAGETYPE_PNG) {
				$ext = 'png';
			}
			copy('comics/'.$HostedUrl.'/images/pages/'.trim($Image),'imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext);
			///$fp  = fopen('imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext, 'w+') or die('Could not create the file');
			//fputs($fp, $gif) or die('Could not write to the file');
			//fclose($fp);
			chmod('imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext,0777);
			$CurrentFile = 'imported/temp/'.$randDirectory.'/'.$FileName.'.'.$ext;
			list($width,$height)=getimagesize($CurrentFile);
				
			// AD IN CHECK FOR COMIC FORMAT 
				
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
				
			echo  "<li class=\"box\" id='box".$Count."'><span id=\"image".$Count."--".$ThumbName."--".$ImageName."\"></span><img src=\"/".$Thumbsm."\" vspace=\"3\" hspace=\"3\"><div style='height:3px;'></div><a href=\"javascript:void(0)\" onClick=\"deleteimage('image".$Count."');\">[delete]</a></li>";
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
            <?
	} else {
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
	 	echo  "<li class=\"box\" id='box".$Count."'><span id=\"image".$Count."--".$ThumbName."--".$ImageName."\"></span><img src=\"/".$thumb."\" vspace=\"3\" hspace=\"3\"><div style='height:3px;'></div><a href=\"javascript:void(0)\" onClick=\"deleteimage('image".$Count."');\">[delete]</a></li>";
		 if ($IDString == '') 
				$IDString =  'image'.$Count;
		else 
			$IDString .= ',image'.$Count;
		
		$Count++;
	}
	echo '</ul>';	
	}
?>

</div>
</div>
<div style="clear: left;"><br/></div>
 <div id='uploaddiv' style="display:none;" align="center">
 <iframe id='loaderframe' name='loaderframe' height='400px' width="680" frameborder="no" scrolling="auto" src="/pdf_file_upload.php"></iframe>
 </div>
 
 <div id='bookinfo' style="display:none;">
 <div style="padding-left:40px; padding-right:25px;"> 
<div class="pageheader"> Enter your PDF's Credits/Information</div>
<table cellpadding="0" cellspacing="0" border="0">
<tr>
<td width="88"><b>CREATOR: </b></td>
<td width="488"><input type="text" style="width:300px;" name="txtAuthor" value="<? if (!isset($_POST['txtAuthor'])) { echo stripslashes($Creator); } else { echo $_POST['txtAuthor'];}?>"/></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>
<tr>
<td><strong>TITLE:</strong> </td>
<td><input type="text" style="width:300px;" name="txtTitle" value="<? if (!isset($_POST['txtTitle'])) { echo stripslashes($ComicTitle); } else { echo $_POST['txtTitle'];}?>"/></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>

<tr>
<td><strong>SUBJECT:</strong> </td>
<td><textarea name="txtSubject" style="width:300px;"><? if (!isset($_POST['txtSubject'])) { echo stripslashes($Genre); } else { echo $_POST['txtSubject'];}?></textarea></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>

<tr>
<td><strong>KEYWORDS: </strong></td>
<td><textarea name="txtKeywords" style="width:300px;"><? if (!isset($_POST['txtKeywords'])) { echo stripslashes($ComicTags); } else { echo $_POST['txtKeywords'];}?></textarea></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>
 <tr>
<td><strong>PDF LAYOUT:</strong> </td>
<td><select name="txtLayout">
<option value='p' <? if ($_POST['txtLayout'] == 'p') { echo 'selected'; }?>>Portrait</option>
<option value="l" <? if ($_POST['txtLayout'] == 'l') { echo 'selected'; }?>>Landscape</option></select></td>
</tr>
<tr><td colspan="2" height="10"></td></tr>
 <tr>
<td><strong>PDF SIZE:</strong> </td>
<td>
<select name="txtSize">
<option value='comic' <? if ($_POST['txtSize'] == 'comic') { echo 'selected'; }?>>Standard Comic</option>
<option value="digest" <? if ($_POST['txtSize'] == 'digest') { echo 'selected'; }?>>Digest Size</option>
</select></td>
</tr>

<tr><td colspan="2" height="10"></td></tr>
<tr>
<td colspan="2" height="10">Do you want to post this PDF to the Panel Flow Products list? : <input type="radio"  name="txtPost" value="1" <? if (($_POST['txtPost'] == 1) || ($_POST['txtPost'] == '')) echo 'checked';?> onClick="show_pricing();"/>Yes &nbsp;<input type="radio"  name="txtPost" value="0" onClick="hide_pricing();" <? if ($_POST['txtPost'] == 0) echo 'checked';?> />No &nbsp;
<div id='pricingdiv' <? if ($_POST['txtPost'] == 0) {?>style="display:none;"<? }?>>
   <div class="spacer"></div>
  Would you like to offer this PDF for sale? : <input type="radio"  name="txtPricing" value="1" <? if ($_POST['txtPrice'] != '') echo 'checked'; ?> onClick="show_price_input()"/>Yes &nbsp;<input type="radio"  name="txtPricing" value="0"  <? if ($_POST['txtPrice'] == '') echo 'checked'; ?>  onClick="hide_price_input()"/>No (Free)&nbsp;
  
  <div id="priceinputdiv"  <? if (($_POST['txtPricing'] == 0) || (!isset($_POST['txtPricing']))) {?>style="display:none;"<? }?>>
  Enter The Amount you would like to charge to download this E-Book: <input type="text"  style="width:100px;" name="txtPrice"  value="<? echo $_POST['txtPrice'];?>" id="txtPrice"/>
  <br /><br />

 <b> ***In order to sell products on PanelFlow.com, you will need to have filled out the Seller data and have an active Paypal account. If you have not filled out the Seller data, you will be prompted to do so on the next page. </b> </div>
   
   </div></td></tr> 

 </table>

</div>
 
 
 
 </div>
  <div id='finishingdiv' align="center" style="display:none;"></div>
<? if ((isset($_GET['comic'])) && (!isset($_POST['reorder']))){?>
<input type="hidden" name="txtPages" value="<? echo $NewPages;?>" id='txtPages'>
<input type="hidden" name="txtThumbs" value="<? echo $ThumbString;?>" id='txtThumbs'>
<? } else {?>
<input type="hidden" name="txtPages" value="<? echo $_POST['txtPages'];?>" id='txtPages'>
<input type="hidden" name="txtThumbs" value="<? echo $_POST['txtThumbs'];?>" id='txtThumbs'>
<? }?>
<input type="hidden" name="txtIDs" value="<? echo $IDString;?>" id='IdString'>
<input type="hidden" name="txtEdit" value="<? echo $_POST['txtEdit'];?>" />
<input type="hidden" name="txtProductID" value="<? echo $_POST['txtProductID'];?>" />
<input type="hidden" name="txtCount" value="<? echo $Count;?>" id='txtCount'/>

 <input type="hidden" value="<? if (isset($_POST['txtInfoClicked'])) echo $_POST['txtInfoClicked']; else echo '0';?>" name="txtInfoClicked" id="txtInfoClicked"/>
<input type="hidden" name="reorder" value="1" />
</form>
<? }?>

</div>
  </div>


</body>
</html>

