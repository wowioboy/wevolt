<?php 
set_time_limit(0);
//ini_set("max_execution_time","900");
//print ini_set("max_execution_time","900");
include 'includes/init.php';
include 'includes/image_resizer.php';
include 'includes/image_functions.php';

$ID = $_SESSION['userid'];

if (!isset($_SESSION['userid'])) {
header("location:/login.php?ref=/comic/import/");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
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
<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script type="text/javascript">
function clear_processing() {
	document.getElementById("processingdiv").style.display = 'none';
	document.getElementById("finishdiv").style.display = '';
}

function check_host() {
	 	var hosturl = document.getElementById("txtUrl").value;
		var found = 0;
		var drunkduck = hosturl.search(/drunkduck/);
		var smackjeeves = hosturl.search(/smackjeeves/);
		var comicspace = hosturl.search(/comicspace/);
		//alert('drunkduck = ' + drunkduck);
		//alert('smackjeeves = ' + smackjeeves);
		//alert('comicspace = ' + comicspace);
		if (drunkduck != -1) {
			document.PageForm.action='/comic/import/drunkduck/<? echo $_GET['id'];?>/';
			document.PageForm.submit();
		} else if (smackjeeves != -1) {
			document.PageForm.action='/comic/import/smackjeeves/<? echo $_GET['id'];?>/';
			document.PageForm.submit();
		} else if (comicspace != -1) {
			document.PageForm.action='/comic/import/comicspace/<? echo $_GET['id'];?>/';
			document.PageForm.submit();
		}
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
		document.PageForm.action='/comic/import/<? echo $_GET['id'];?>/';
		document.PageForm.submit();
	}

</script>
<title>PANEL FLOW - IMPORT PAGES</title>

</head>

<body>
<?php include 'includes/header_content.php';?>

     <div class='contentwrapper'>
<div style="padding-right:2px;">
<? if (((!isset($_GET['id'])) && (!isset($_POST['txtUrl']))) || ($_GET['id'] == '')) {
echo "<div class='pageheader'>Please Select which comic you would like to import pages into</div>";
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

	
	$comicString .= "<td valign='top' id='profilemodcontent'><div align='center'><div class='comictitlelist'>".stripslashes($row['title'])."</div><a href='/comic/import/".$row['SafeFolder']."/'>";
	
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
} else if (!isset($_POST['txtUrl'])) {?>
<div style="padding:30px;">
<div class="pageheader">Please Enter the full URL to the first page of your comic on either Drunk Duck, Comicspace or Smackjeeves. </div> 
<div class="spacer"></div>
<span style="font-size:12px;">NOTE: This will only work if you have the archive/select box showing on your comic pages. Also some SmackJeeves sites do not import correctly. If you run into an issue just shoot us an email <a href="/contact/">HERE</a> and we'll look into it. </span>
<div class="spacer"></div>
<form name="PageForm" method="post" action="/comic/import/<? echo $_GET['id'];?>/">
<input type="text" id='txtUrl' name="txtUrl" value="<? echo $_POST['txtUrl'];?>" style="width:300px">
<input type="button" value="GRAB PAGES" onclick="check_host();"></form></div>
<? } else if ((isset($_POST['txtUrl']))&&(isset($_GET['id'])) && (isset($_POST['txtPageList']))&& (!isset($_POST['reorder']))&& (!isset($_POST['process']))){

$images_url_array = explode('||',$_POST['txtPageList']);
$IdArray =  explode(',',$_POST['txtIDString']);
$Thumbarray =  explode(',',$_POST['txtThumbList']);
$randDirectory = $_POST['tempdir'];
//$IdArray = array_reverse($IdArray2);
//$Thumbarray = array_reverse($Thumbarray2);
//$images_url_array = array_reverse($images_url_array2);

?>
<form name="PageForm" method="post" action="/comic/import/process/<? echo $_GET['id'];?>/">

<div id='finishdiv' class="pageheader" style="padding:15px;">Below are the pages imported, please remove any unwanted pages and click FINISH IMPORT.
<div align="center" style="padding:5px;">
<input type="hidden" name="txtUrl" value="set" >
<input type="hidden" name="finish" value="1" >
<input type="hidden" name="txtComic" value="<? echo $_GET['id'];?>" >
<input type="hidden" name="txtSafeFolder" value="<? echo $_GET['id'];?>" id='txtSafeFolder'>
<input type="hidden" name="tempdir" value="<? echo $randDirectory;?>" >
<input type="submit" value="FINISH IMPORT"></div>
</div>
 <div id='projectimages' style="padding-left:5px;padding-right:5px;">
   <span style="font-size:14px;">  You can reorder your images by dragging into place, make sure you click HERE -> <input class="inspector" type="button" value="SAVE ORDER" onclick="junkdrawer.inspectListOrder('boxes','<? echo $_POST['tempdir'];?>','pages')"/> before deleting or continuing, or you will lose your order.<br />
 <br /><br />
<div class='warning'>If your images are reversed, click here:<input class="inspector" type="button" value="REVERSE ORDER" onclick="junkdrawer.reverseListOrder('boxes','<? echo $_POST['tempdir'];?>','pages')"/></div></span>
     <div id='imagelisting'>
<?php

$Count=0;
$Times=0;
$TimesCount = 0;
	$NewPages = '';
	$IDString = '';
	echo '<ul id="boxes">';
		foreach ($Thumbarray as $Thumb) {	
		$ThumbNameArray = explode('/',$Thumb);
		$ThumbName = $ThumbNameArray[4];
		$ImageArray = explode('/',$images_url_array[$Count]);
		$ImageName = $ImageArray[3];
				echo  "<li class=\"box\" id='box".$Count."'><span id=\"image".$Count."--".$ThumbName."--".$ImageName."\"></span><img src=\"/".$Thumb."\" vspace=\"3\" hspace=\"3\"><a href=\"javascript:void(0)\" onClick=\"deleteimage('image".$Count."');\">[delete]</a></li>";
				 if ($IDString == '') 
					$IDString =  'image'.$Count;
				else 
					$IDString .= ',image'.$Count;
		 			$Count++;
			}
			echo "</ul></div>";
			?>
</div>
<div style="clear: left;"><br/></div>
<input type="hidden" name="txtPages" value="<? echo $_POST['txtPageList'];?>" id='txtPages'>
<input type="hidden" name="txtThumbs" value="<? echo $_POST['txtThumbList'];?>" id='txtThumbs'>
<input type="hidden" name="txtIDs" value="<? echo $IDString;?>" id='IdString'>
<input type="hidden" name="reorder" value="1" />
</form>
<? } else {?>
<form name="PageForm" method="post" action="/comic/import/process/<? echo $_GET['id'];?>/">

<div id='finishdiv' class="pageheader" style="padding:15px;">Below are the pages imported, please remove any unwanted pages and click FINISH IMPORT.

<div align="center" style="padding:5px;">

<input type="hidden" name="txtUrl" value="<? echo $_POST['txtUrl'];?>" >
<input type="hidden" name="finish" value="1" >
<input type="hidden" name="txtSafeFolder" value="<? echo $_GET['id'];?>" id='txtSafeFolder'>
<input type="hidden" name="txtComic" value="<? echo $_GET['id'];?>" >
<input type="hidden" name="tempdir" value="<? echo $_POST['tempdir'];?>" >

<input type="submit" value="FINISH IMPORT"></div>
</div>

 <div id='projectimages' style="padding-left:5px;padding-right:5px;">
   <span style="font-size:14px;">  You can reorder your images by dragging into place, make sure you click HERE -> <input class="inspector" type="button" value="SAVE ORDER" onclick="junkdrawer.inspectListOrder('boxes','<? echo $_POST['tempdir'];?>','pages')"/> before deleting or continuing, or you will lose your order. <br /><br />

<div class='warning'>If your images are reversed, click here:<input class="inspector" type="button" value="REVERSE ORDER" onclick="junkdrawer.reverseListOrder('boxes','<? echo $_POST['tempdir'];?>','pages')"/></div></span>
     <div id='imagelisting'>
     <? 
	// echo 'MY THUMBS = ' . $_POST['txtThumbs'];
	 $ThumbArray = explode(',',$_POST['txtThumbs']);
	 $images_url_array = explode('||',$_POST['txtPages']);
	 
	 $Count = 0;
	 $IDString = '' ;
	 echo '<ul id="boxes">';
	foreach ($ThumbArray as $Thumb) {	
		$ThumbNameArray = explode('/',$Thumb);
		$ThumbName = $ThumbNameArray[4];
		$ImageArray = explode('/',$images_url_array[$Count]);
		$ImageName = $ImageArray[3];
				echo  "<li class=\"box\" id='box".$Count."'><span id=\"image".$Count."--".$ThumbName."--".$ImageName."\"></span><img src=\"/".$Thumb."\" vspace=\"3\" hspace=\"3\"><a href=\"javascript:void(0)\" onClick=\"deleteimage('image".$Count."');\">[delete]</a></li>";
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
<input type="hidden" name="txtPages" value="<? echo $_POST['txtPages'];?>" id='txtPages'>
<input type="hidden" name="txtThumbs" value="<? echo $_POST['txtThumbs'];?>" id='txtThumbs'>
<input type="hidden" name="txtIDs" value="<? echo  $IDString;?>" id='IdString'>
<input type="hidden" name="reorder" value="1" />
</form>
<? }?>

</div>
  </div>
  <?php include 'includes/footer_v2.php';?>

</body>
</html>

