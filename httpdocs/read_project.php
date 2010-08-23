<?
$IsProject = true;
$ComicName = $_GET['project'];
$ComicDir = substr($ComicName,0,1);
$_SESSION['readerpage'] = 'inline';
$ProjectName = $_GET['project'];
$ProjectDir = substr($ComicName,0,1);
$ContentUrl = 'reader';

$PFDIRECTORY = 'panelflow';
if ($_SESSION['IsPro'] == 1)
	$ModuleWidth = '1000';
else 
	$ModuleWidth = '750';


include 'includes/init.php';
$Redirect = 'http://'.$_SERVER['SERVER_NAME'].'/'.$_GET['project'].'/reader/';

if ($_GET['episode'] != '')
	$Redirect .= 'episode/'.$_GET['episode'].'/';


$_SESSION['sharelink'] = $Redirect .'page/'.$_GET['page'].'/';

$Tracker = new tracker();
$Remote = $_SERVER['REMOTE_ADDR'];
$Referal = urlencode(substr($_SERVER['HTTP_REFERER'],7,strlen($_SERVER['HTTP_REFERER'])-1));
$Tracker->insertPageView($ProjectID,$Pagetracking,$Remote,$_SESSION['userid'],$Referal,$_SESSION['sharelink'],$_SESSION['IsPro'],$IsCMS);	 

if (($_SESSION['userid'] != '') && ($IsProject))
	$Tracker->insertUserReadLog($ProjectID,$_SESSION['userid'],$_SESSION['sharelink']); 
?>

<head>
<script type="text/javascript">

var SafeFolder = '<? echo $SafeFolder;?>';
	var NextPage = '<? echo $ContentSection->getNextPage();?>';
	var LastPage = '<? echo $ContentSection->getLastPage();?>';
	var PrevPage = '<? echo $ContentSection->getPrevPage();?>';
	var SkinCode = '<? echo $SkinCode;?>';
	var PFDIRECTORY = '<? echo $PFDIRECTORY;?>';
	var PrevPageImage = '<? echo $ContentSection->getPrevPageImage();?>';
	var NextPageImage = '<? echo $ContentSection->getNextPageImage();?>';

</script>
  


<script type="text/javascript" src="http://www.wevolt.com/js/swfobject.js"></script>
<script type="text/javascript" src="http://www.wevolt.com/js/project_js.js"></script>

 
<script type="text/javascript" src="/scripts/global_functions.js"></script>

<script type="text/javascript" src="/<? echo $PFDIRECTORY;?>/scripts/reader_functions_inline.js"></script>

<script src="/<? echo $PFDIRECTORY;?>/scripts/bubble-tooltip.js" type="text/javascript"></script>


<? flush();?>
<LINK href="http://www.wevolt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">

<? $BodyStyle = $ProjectTemplate->getBodyStyle();

	
// SET PROJECT STYLE
$ProjectTemplate->drawStyle();
//GET HOT SPOT BUBBLE SETTINGS
$BubbleArray = $ProjectTemplate->getBubbleSettings();

?>
<script type="text/javascript">
function GetElemPostion(xElement){

  var selectedPosX = 0;
  var selectedPosY = 0;
  var theElement = document.getElementById(xElement);
   
  while(theElement != null){
    selectedPosX += theElement.offsetLeft;
    selectedPosY += theElement.offsetTop;
    theElement = theElement.offsetParent;
	      
  }
   		      		      
  return selectedPosX + "," + selectedPosY;
  

}

function create_spot(asttop,asleft,count) {
		var iposition = GetElemPostion('finalpage');
		var dimarray = iposition.split(',');
		asttop = (parseInt(asttop) + parseInt(dimarray[1]));
		asleft = (parseInt(asleft) + parseInt(dimarray[0]));
		
		element = document.createElement("div");
		element.setAttribute("id","asterickloc_"+count);
		<? if ($BubbleArray['Image'] == '') {?>
		
		element.setAttribute("style", "background-color:#<? echo $BubbleArray['SpotColor'];?>;width:<? echo $BubbleArray['Width'];?>px;height:<? echo $BubbleArray['Height'];?>px;border:2px solid #000;position:absolute;top:"+asttop+"px;left:"+asleft+"px;cursor:default;");
		element.style.cssText ="background-color:#<? echo $BubbleArray['SpotColor'];?>;width:<? echo $BubbleArray['Width'];?>px;height:<? echo $BubbleArray['Height'];?>px;border:2px solid #000;position:absolute;top:"+asttop+"px;left:"+asleft+"px;cursor:default;z-index:100;";

		<? } else { ?>

				element.setAttribute("style", "background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $BubbleArray['Image'];?>);width:<? echo $BubbleArray['Width'];?>px;height:<? echo $BubbleArray['Height'];?>px;position:absolute;top:"+asttop+"px;left:"+asleft+"px;cursor:default;");
element.style.cssText ="background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $BubbleArray['Image'];?>);width:<? echo $HotSpotWidth;?>px;height:<? echo $BubbleArray['Height'];?>px;position:absolute;top:"+asttop+"px;left:"+asleft+"px;cursor:default;z-index:100;";
		<? }?>

		document.getElementById('pagereaderdiv').appendChild(element);
}

document.onmousedown=right;
document.onmouseup=right;
if (document.layers) window.captureEvents(Event.MOUSEDOWN);
if (document.layers) window.captureEvents(Event.MOUSEUP);
window.onmousedown=right;
window.onmouseup=right;



var sizeset = 0;

function show_reader() {
	if (sizeset == 2) {
		window.parent.document.getElementById('reader_div').style.display='block';
		window.parent.document.getElementById("readerframe").style.height = '<? echo $Height;?>px';
	}
}

function resize_frame() {
sizeset = 1;
window.parent.document.getElementById("readerframe").style.height = (document.body.scrollHeight+75)+'px';
}

function open_link(value) {
	if (value != '') {
		if (value == 'synopsis') {
		
			parent.jQuery.facebox('<div class="globalheader">synopsis</div><div class="projectboxcontent"><? echo addslashes($ContentSection->getProjectSynopsis());?></div>');
			
		} else if (value == 'credits') {
		    parent.jQuery.facebox('<div class="globalheader">credits</div><div class="projectboxcontent"><? echo addslashes($ContentSection->getCredits());?></div>');
		} else {
			parent.window.location = value;
		}	
	}
	document.getElementById('sectionSelect').selectedIndex = 0;

}
</script>
</head>
<body style="<? echo $BodyStyle;?>" onLoad="show_reader();">
<? if ($_SESSION['noads'] != 1) {?><center>
     <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe></center><div class="spacer"></div>
      <? } else {?>
      		<? if (($_SESSION['comicheader'] != '') && ($_SESSION['comicheader'] != 'templates/skins/PFSK-00001/images/header_800x90.jpg')) {?>
            	<div align="center"><a href="#" onClick="parent.window.location.href='http://www.wevolt.com/<? echo $SafeFolder;?>/';"><img src="http://www.wevolt.com/<? echo $_SESSION['comicheader'];?>" border="0"></a></div>
            <? }?>
<? }?>
			  <center> 
              
              
 				<? $ContentSection->drawReaderBar();
				?>
             
       
               <div class="spacer"></div>
               <? $ContentSection->drawReader();?>
                <? flush();?>
                
                 <div class="spacer"></div>
                 
                 
                 <div style="width:<? echo $ModuleWidth;?>px;">
                 <? echo $ContentSection->drawReaderModules($ModuleWidth);?>
                
                  </div>
                  
                 <div id="loaderdiv" style="display:none;">
                 <img src="<? echo $ContentSection->getPrevPageImage();?>">
                  <img src="<? echo  $ContentSection->getNextPageImage();?>">
                 </div>
                
</center>
<? flush();?>
<script type="text/javascript">
<? if ($ContentSection->getFileType() == 'flv') {?>
	var PlayerVars = {};
			PlayerVars.videofile = "<? echo $ContentSection->getVideoFile();?>";
			var params = {};
			params.quality = "best";
			params.wmode = "transparent";
			params.allowfullscreen = "false";
			params.allowscriptaccess = "always";
			var attributes = {};
			attributes.id = "pagereaderdiv";
			swfobject.embedSWF("/<? echo $PFDIRECTORY?>/flash/player.swf", "pagereaderdiv", "640", "480", "9.0.0", "/<? echo $PFDIRECTORY?>/flash/expressInstall.swf", PlayerVars, params, attributes);
<? } else if ($ContentSection->getFileType() == 'swf') {?>
			var PlayerVars = {};
			var params = {};
			params.quality = "best";
			params.wmode = "transparent";
			params.allowfullscreen = "false";
			params.allowscriptaccess = "always";
			var attributes = {};
			attributes.id = "pagereaderdiv";
			swfobject.embedSWF("<? echo $ContentSection->getFlashFile();?>", "pagereaderdiv", "<? echo $Width;?>", "<? echo $Height;?>", "9.0.0", "/<? echo $PFDIRECTORY?>/flash/expressInstall.swf", PlayerVars, params, attributes);
<? } ?> 
</script>
<?php 

// Comic Footer
include $PFDIRECTORY.'/templates/common/includes/comic_footer.php';
?>
<script type="text/javascript">
resize_frame();
</script>
<? include 'includes/footer_ad_scripts.php';?>
