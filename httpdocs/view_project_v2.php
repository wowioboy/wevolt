<?
if ($_GET['project'] == 'search') {
	include 'search.php';
	exit;
}
if ($_GET['project'] == 'forum') {
	$TargetName = 'wevolt';
	$TargetType = 'user';
	include 'forum.php';
	exit;
}
if ($_GET['project'] == 'tutorial') {
	include 'tutorials.php';
	exit;
}
if ($_GET['project'] == 'Get_Started') {
	include 'tutorials.php?tid=1';
	exit;
}
if ($_GET['project'] == 'facebook') {
	include 'facebook/index.php';
	exit;
}


$IsProject = true;
$ComicName = $_GET['project'];
$ComicDir = substr($ComicName,0,1);

$ProjectName = $_GET['project'];
$ProjectDir = substr($ComicName,0,1);

$ReaderUser = $_SESSION['userid'];
$ContentUrl = strtolower($_GET['section']);
$Section = ucfirst(strtolower($_GET['section']));
$TrackSection = $Section;
if ($Section == '') {
	$TrackSection = 'Home';
	$Section ='Home';
}
$TrackPage = 1;
$Pagetracking = $Section;
$PFDIRECTORY = 'panelflow';

include 'includes/init.php';
$InitDB->close();
$_SESSION['readerpage'] = 'norm';
$InLineReader = false;
if ($_GET['auth'] == 1) {
	$_SESSION['authage'] = 1;
	header("location:http://www.wevolt.com/".$ComicName."/");
}



$PageTitle .= $ComicTitle;
if ($TrackSection !='Home')
 $PageTitle .= ' - '.$TrackSection;
if ($TrackSection == 'Reader')
	$PageTitle .= ' - Page '.$Page.' - '.$ReaderPageTitle;

$Tracker = new tracker();
$Remote = $_SERVER['REMOTE_ADDR'];
$Referal = substr($_SERVER['HTTP_REFERER'],7,strlen($_SERVER['HTTP_REFERER'])-1);
$pos = strpos($Referal,'www.wevolt.com');
if($pos === false) {
	$pos = strpos($Referal,'users.wevolt.com');
	if($pos === false) {
		
	} else {
 		 $Referal = 'www.wevolt.com';
	}
} else {
 $Referal = 'www.wevolt.com';
}

if ($AdminUserID != $_SESSION['userid'])
$Output = $Tracker->insertPageView($ProjectID,$Pagetracking,$Remote,$_SESSION['userid'],$Referal,$_SESSION['reflink'],$_SESSION['IsPro'],$IsCMS);	
//if ($_SESSION['username'] == 'matteblack')
	//print 'OUTPUT = ' .$Output;
$BodyStyle = $ProjectTemplate->getBodyStyle();
include_once('includes/header_template_new.php');


$Site->drawModuleCSS();
// SET PROJECT STYLE
$ProjectTemplate->drawStyle();

$SeriesNum=$_GET['series'];
if ($SeriesNum == '')
	$SeriesNum = 1;
	
$EpisodeQuery ='___episode___'.$SeriesNum.'-';

if ($_GET['episode'] == '')
	$EpisodeQuery .='1';
else
	$EpisodeQuery .=$_GET['episode'];


?>
<script  src="http://www.wevolt.com/scripts/twitterjs.js" type="text/javascript"></script> 

<style>
#reader_container {
height:100%;
width:100%;
min-height:100%;
} 

</style><script type="text/javascript">
<? if ($_SESSION['userid'] != ''){?>

function bookmark_project() {

	attach_file('http://www.wevolt.com/connectors/bookmark_place.php?p=<? echo $Page;?>&e=<? echo $EpisodeNum;?>&s=<? echo $SeriesNum;?>'); 
	document.getElementById("add_bookmark").style.display = 'none';
	document.getElementById("clear_bookmark").style.display = '';
}
function remove_bookmark() {

	attach_file('http://www.wevolt.com/connectors/bookmark_place.php?a=clear'); 
	document.getElementById("add_bookmark").style.display = '';
	document.getElementById("clear_bookmark").style.display = 'none';
	
}
function follow(ProjectID,UserID,Type) {
 
	attach_file('http://www.wevolt.com/connectors/follow_content.php?fid='+ProjectID+'&type='+Type); 
	document.getElementById("follow_project_div").style.display = 'none';
	
}
<? }?>
function project_tab_active(tabid, divid) {
		var divstate = document.getElementById(divid).style.display;
		if (document.getElementById(divid).style.display != '') 
			document.getElementById(tabid).className ='tabactive';
}
 
function project_tab_inactive(tabid, divid) {
		if (document.getElementById(divid).style.display != '') 
			document.getElementById(tabid).className ='tabinactive';
}
</script>
<?

 if (($_SESSION['readerstyle'] == 'flash') && (($Section == 'Pages') ||($Section == 'Reader'))) { ?>

		<script language="javascript">
		
			<? if ($_SESSION['readerpage'] != '') {?>
				parent.location.hash = '/<? echo ($_SESSION['readerpage']+1);?>';
			<? $_SESSION['readerpage'] = '';?>
			<?  }?>
			
			var redirect = 'http://<? echo $_SERVER['SERVER_NAME'];?>/<? echo $SafeFolder;?>/reader/';
			
			var series = '<? echo $_GET['series'];?>';
			if (series == '')
				series = 1;
			if ((series != '') && (series != 1))
				redirect = redirect + 'series/'+series+'/';
			
			var episode = '<? echo $_GET['episode'];?>';
			if (episode == '')
				episode = 1;
			if (episode != '')
				redirect = redirect + 'episode/'+episode+'/';
			
		
			
			function onFlashCommand( cmd, param, page )
			{
				//	alert(cmd + ' ' + param + ' ' + page);
				switch( cmd )
				{
					case "pg_change":	
						x = top.frames['adframe'].location ='/includes/reader_ad_inc.php';
						v = top.frames['pgviewer'].location ='/includes/pageviewer.php';
					break;
					
					case "share":
					
							share_project('<? echo $ProjectID;?>',escape('<? echo  str_replace("_", " ", $ProjectName);?>'));
					break;
					
					case "help":
						alert( "Help" );
					break;
					
					case "buy_now":
					//	alert( "Buy now: " + param );
					break; 
					
					case "page_spread":
					
						loadComic(page);
					break;
					
					case "config": 
							reader_config('<? echo $ProjectName;?>',param,redirect,episode,series);
					break;
					
				}
				
			}

		function loadComic(page){
			<? if ($_SESSION['flashpages'] == 1) {?>
					var pages = 2;
			<? } else {?>
			
					var pages = 1; 
			<? }?> 
			
				attach_file('http://www.wevolt.com/connectors/change_page_layout.php?p='+pages+'&ref='+escape(redirect)+'&page='+page); 
				//swf.loadComic( "http://www.wevolt.com/processing/get_comic_xml_v2.php?content=<? //echo $ProjectName;?> );
			}
		
		</script>
<? }?>
<div align="left">
<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <? $Site->drawControlPanel();?>
            </div>
        <? }?>
       
<img src="http://www.wevolt.com<? echo $ProjectThumb;?>" style="display:none;"/>

	<table cellpadding="0" cellspacing="0" border="0" id="reader_container">

	<tr><? if (($_SESSION['IsPro'] == 1) || ($_SESSION['ProInvite'] == 1)) {
				$_SESSION['noads'] = 1;
			$FlashHeight = 1;
	} else {
			$_SESSION['noads'] = 0;
			$FlashHeight = 90;	
	}
		?> 
		<td valign="top" >
			<?  include 'includes/site_menu_inc_v2.php';?>
		</td> 
        
        <td  valign="top" align="left">
        		
		 <? 
		 

		 if ($_SESSION['noads'] == 0) {
			if (($Section != 'Reader') && ($Section != 'Pages')) {?>
				  <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
           <? }?>
     
            
         <? }?>
            
			<? 
			
			if ((($_SESSION['overage'] == '') || (strtolower($_SESSION['overage']) == 'n')) && (($_SESSION['authage'] != 1) && ($Rating == 'a'))) {?><div class="spacer"></div>
           <img src="http://www.wevolt.com/images/age_warning.png" border="0" usemap="#ageMap" />
<map name="ageMap">
  <area shape="rect" coords="108,347,229,396" href="http://www.wevolt.com/">
  <area shape="rect" coords="399,348,520,396" href="http://www.wevolt.com/<? echo $SafeFolder;?>/?auth=1">
</map>
 
            <? } else {
			
			if (($Section == 'Reader') || ($Section == 'Pages')) {?>
           <? if (($_SESSION['readerstyle'] == 'flash')) { ?>
 <?  if ($_SESSION['noads'] == 0) {?>  <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe><? }?>
		<div id="flashreader">
			<a href="http://www.adobe.com/go/getflashplayer">
				<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
			</a>
		</div>
        
        <script type="text/javascript">
			var flashvars = {};
			flashvars.COMIC_URL = "";
			flashvars.DATA_URL = "http://www.wevolt.com/connectors/get_pages_xml.php?content=<? echo $ProjectName;?>___p___<? echo $_SESSION['flashpages'].$EpisodeQuery;?>___u___<? echo $_SESSION['userid'];?>___off___<? if ($_GET['part'] == '') echo '0'; else echo ($_GET['part']);?>___c___<? echo $_GET['chapter'];?>";
			var params = {};
				params.quality = "best";
				params.wmode = "transparent";
				params.allowfullscreen = "false";
				params.allowscriptaccess = "always";
			var attributes = {};
				attributes.id = "reader";
			swfobject.embedSWF("/flash/reader.swf", "flashreader", "100%", (theHeight-<? echo $FlashHeight;?>), "9.0.0", "/panelflow/flash/expressInstall.swf", flashvars, params, attributes);
		</script>
             
	<!-- ON RESIZE -->
	<script type="text/javascript" src="http://www.wevolt.com/js/resize.js"></script>
	<? } else {
		
		 ?>
        <? if (!$InLineReader) {
		


     
        if ($_SESSION['IsPro'] == 1)
	$ModuleWidth = '1000';
else 
	$ModuleWidth = '750';



$Redirect = 'http://'.$_SERVER['SERVER_NAME'].'/'.$_GET['project'].'/reader/';

if ($_GET['episode'] != '')
	$Redirect .= 'episode/'.$_GET['episode'].'/';


$_SESSION['sharelink'] = $Redirect .'page/'.$Page.'/';
 
if ($_SESSION['userid'] != ''){
	$Tracker->insertUserReadLog($ProjectID,$_SESSION['userid'],$_SESSION['sharelink']); 
	
	$Output = $Tracker->addPageviewXP($ProjectID,$_SESSION['userid'],$PageXP); 
	//if ($_SESSION['username'] == 'matteblack') {
	//	print 'PAGEXP = ' .$PageXP;
	//print $Output;
//	}
	}

?>


<script type="text/javascript">

var SafeFolder = '<? echo $SafeFolder;?>';
	var NextPage = '<? echo $ContentSection->getNextPage();?>';
	var LastPage = '<? echo $ContentSection->getLastPage();?>';
	var PrevPage = '<? echo $ContentSection->getPrevPage();?>';
	var SkinCode = '<? echo $SkinCode;?>';
	var PFDIRECTORY = '<? echo $PFDIRECTORY;?>';
	var PrevPageImage = '<? echo $ContentSection->getPrevPageImage();?>';
	var NextPageImage = '<? echo $ContentSection->getNextPageImage();?>';
	var EpisodeNum = '<? echo $ContentSection->EpisodeNum;?>';
	var SeriesNum = '<? echo $ContentSection->SeriesNum;?>';
	var NextEpisode = '<? echo $ContentSection->NextEpisode;?>';
	var PrevEpisode = '<? echo $ContentSection->PrevEpisode;?>';

</script>
  

<script type="text/javascript" src="http://www.wevolt.com/js/project_js.js"></script>


<script type="text/javascript" src="/<? echo $PFDIRECTORY;?>/scripts/reader_functions.js"></script>

<script src="/<? echo $PFDIRECTORY;?>/scripts/bubble-tooltip.js" type="text/javascript"></script>


<? flush();?>


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
		//window.parent.document.getElementById('reader_div').style.display='block';
		//window.parent.document.getElementById("readerframe").style.height = '<? //echo $Height;?>px';
	}
}

function resize_frame() {
sizeset = 1;
//document.getElementById("readerframe").style.height = (document.body.scrollHeight+75)+'px';
}

function open_link(value,user) {
	if (value != '') {
		var valuearray = value.split('||');
		var splitval = valuearray[0];
		//alert(valuearray[1]);
		if (splitval == 'synopsis') {
		<? $Description = preg_replace("/\r?\n/", "<br/>", $ContentSection->getProjectSynopsis());?> 
			jQuery.facebox('<div class="globalheader">synopsis</div><div class="projectboxcontent"><? echo addslashes($Description);?></div>');
			
		} else if (splitval == 'credits') {
		   jQuery.facebox('<div class="globalheader">credits</div><div class="projectboxcontent"><? echo addslashes($ContentSection->getCredits());?></div>');
		} else if (splitval == 'follow') {
		  attach_file('http://www.wevolt.com/connectors/follow_content.php?fid=<? echo $ProjectID;?>&type=project'); 
	      document.getElementById("follow_project_div").style.display = 'none';
		
		} else if (splitval == 'friend') {
		  network_wizard(user,'<? echo $_SESSION['userid'];?>','');
		
		} else {
			if (valuearray[1] == '_blank')
				window.open(splitval,"window");
				//alert(splitval);
			else 
				window.location = splitval;
		}	
	}
	document.getElementById('sectionSelect').selectedIndex = 0;

}
</script>

<? if ($_SESSION['noads'] != 1) {?><center>
     <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe></center><div class="spacer"></div>
      <? } else {?>
      		<? if (($_SESSION['comicheader'] != '') && ($_SESSION['comicheader'] != 'templates/skins/PFSK-00001/images/header_800x90.jpg')) {?>
            	<div align="center"><a href="http://www.wevolt.com/<? echo $SafeFolder;?>/"><img src="http://www.wevolt.com/<? echo $_SESSION['comicheader'];?>" border="0"></a></div>
            <? }?>
<? }?>
			  <center> 
              
              
 				<? $ContentSection->drawReaderBar();
				?>
             
       
               <div class="spacer"></div>
               <? $ContentSection->drawReader();?>
               <? flush();?>
                <div class="spacer"></div>
               <? $ContentSection->drawPageNav($ReaderTemplate);?>
              
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
        <? } else {?> 
     
   <? /* <iframe src="/read_project.php?project=<? echo $_GET['project'];?>&page=<? echo $Page;?>&episode=<? echo $_GET['episode'];?>" frameborder="0" width=100% height=0 
  id="readerframe" name="readerframe" scrolling="no" allowtransparency="true"></iframe>*/?>
  <? }?>
            <? }?>
            <? } else { ?>
            <script type="text/javascript">
			  jQuery(document).ready(function($) {
					   $('a[rel*=facebox]').facebox({
					 loading_image : '/panelflow/scripts/facebox/loading.gif',
					   close_image   : '/panelflow/scripts/facebox/closelabel.gif'
						 }) 
				})
								
			</script>
            <center>
			<? 
                echo $TemplateHTML;?>
                </center>
                 
            <? }?>
           <? }?>                  
		</td>
        
	</tr>
  
</table>

</div>

<?php include 'includes/footer_template_new.php';

?>