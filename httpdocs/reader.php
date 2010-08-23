<?

if ($_GET['project'] == 'search') {
	include 'search.php';
	exit;
}
$IsReader = true;
$IsProject = true;
$TrackPage = 0;
$ComicName = $_GET['project'];
$ComicDir = substr($ComicName,0,1);

$ProjectName = $_GET['project'];
$ProjectDir = substr($ComicName,0,1);

$Section = ucfirst(strtolower($_GET['section']));
if ($Section == '') $Section = 'Pages';
$Pagetracking = $Section;
$PFDIRECTORY = 'panelflow';
$TrackPage = 0;

$PageTitle = 'W3VOLT | '.$ProjectName.' - Reader -';

if ($_GET['episode'] != '') 
	$PageTitle .= ' EP '.$_GET['episode'];
if ($_GET['chapter'] != '') 
	$PageTitle .= ' CH '.$_GET['chapter'];
if ($_GET['page'] != '') 
	$PageTitle .= ' PG '.$_GET['page'];

include 'includes/init.php';

include_once('includes/project_functions.php');

include_once('includes/header_template_new.php');
include $IncludesDirectory.$PFDIRECTORY.'/templates/common/includes/project_template_inc.php';
if ($_GET['episode'] != '') 
			$EpisodeQuery ='___episode___'. $_GET['episode'];
		else 
			$EpisodeQuery ='';
// Comic Header
//include $IncludesDirectory.$PFDIRECTORY.'/templates/common/includes/comic_header_template.php';
?>
<style>
#reader_container {
height:100%;
width:100%;
min-height:100%;
} 

</style>
	<script language="javascript">
			function onFlashCommand( cmd, param )
			{
				//alert( cmd + " : " + param );
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
					
				}
			}

		
		
		</script>







  <table cellpadding="0" cellspacing="0" border="0" id="reader_container">


<tr>
   		<? if (($_SESSION['IsPro'] == 1) || ($_SESSION['ProInvite'] == 1)) {
				$_SESSION['noads'] = 1;
				$FlashHeight = 61;
		?>
		<td valign="top" bgcolor="#1a5793" style="padding:5px; color:#FFFFFF;">
			<? include 'includes/site_menu_popup_inc.php';?>
    
		</td> 
		</tr>
        <tr>
        <? } else {
			$_SESSION['noads'] = 0;
			$FlashHeight = 90;?>
			<td width="<? echo $SideMenuWidth;?>" valign="top" id="sidebar_div" >
			<? include 'includes/site_menu_inc.php';?>
    
		</td> 
		<? }?>
		
        <td  valign="top" align="center">  
       
<? if ((($_SESSION['readerstyle'] == 'flash') && ($_SESSION['currentreader'] == '')) || ($_SESSION['currentreader'] == 'flash')) { ?>
 <?  if ($_SESSION['noads'] == 0) {?><iframe src="/includes/reader_ad_inc.php" width="728" height="90" scrolling="no" frameborder="0" allowtransparency="true" name="adframe" id="adframe"></iframe><? }?>
	<div id="flashreader">

	</div>
<script type="text/javascript">

				   var so = new SWFObject('/flash/reader.swf','mpl','100%',(theHeight-<? echo $FlashHeight;?>),'9'); 
		
                  so.addParam('allowfullscreen','true'); 
                  so.addParam('allowscriptaccess','true'); 
				  so.addVariable('COMIC_URL','');
				  so.addVariable('DATA_URL','http://www.w3volt.com/processing/get_comic_xml_v2.php?content=<? echo $ProjectName;?>___p___<? echo $_SESSION['flashpages'].$EpisodeQuery;?>___u___<? echo $_SESSION['userid'];?>');
				  so.addParam("wmode", "transparent");				  
				  so.write('flashreader'); 
                </script>
                <? /*
	<script type="text/javascript">
		var flashvars = { DATA_URL:"http://www.w3volt.com/processing/get_comic_xml.php?content=Stupid_Users" };
		var params = { "allowFullScreen":"true",
					"wmode":"window" };
		var attributes = { id:"flashreader" };			
		swfobject.embedSWF("/flash/reader.swf", "flashreader", "100%", "100%", "9.0.0", false, flashvars, params, attributes);
	</script>
	*/?>
	<!-- ON RESIZE -->
	<script type="text/javascript" src="http://www.w3volt.com/js/resize.js"></script>
	<? } else {?>

		
		<? if ($_GET['page'] == '') 
        	$Page = 1;
         else 
         	$Page = $_GET['page'];

		 ?>
     
    <iframe src="/read_project.php?project=<? echo $_GET['project'];?>&page=<? echo $Page.$EpisodeQuery;?>" frameborder="0" width=100% height=0 
  id="readerframe" name="readerframe" scrolling="no" allowtransparency="true"></iframe>


             
	
		<? }?>
        </td>
        
	</tr>
    
</table>
<?php include 'includes/footer_template_new.php';
$settings->close();
?>