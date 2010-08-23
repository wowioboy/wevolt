<?

if ($_GET['project'] == 'search') {
	include 'search.php';
	exit;
}
$_SESSION['readerstyle'] = 'flash';
$IsProject = true;
$ComicName = $_GET['project'];
$ComicDir = substr($ComicName,0,1);

$ProjectName = $_GET['project'];
$ProjectDir = substr($ComicName,0,1);

$Section = ucfirst(strtolower($_GET['section']));
if ($Section == '') $Section = 'Pages';
$Pagetracking = $Section;
$PFDIRECTORY = 'panelflow';

include 'includes/init.php';

//include_once('includes/project_functions.php');
include_once('includes/header_template_new.php');
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
		<script type="text/javascript">
			function onFlashCommand( cmd, param )
			{
				//alert( cmd + " : " + param );
				switch( cmd )
				{
					case "pg_change":	
						alert( "Page changed: " + pararm );
					break;
					
					case "share":
						alert( "Share: " + param );
					break;
					
					case "help":
						alert( "Help" );
					break;
					
					case "buy_now":
						alert( "Buy now: " + param );
					break;
					
				}
			}
			
			
		</script>

  <table cellpadding="0" cellspacing="0" border="0" id="reader_container">

	<tr>
		<td width="<? echo $SideMenuWidth;?>" valign="top" <? if ($IsProject) {?>style="background-color:#185591;"
<? }?>>
			<? include 'includes/site_menu_inc.php';?>
		</td> 
		
        <td  valign="top" align="center">   <? include 'includes/banner_ad_inc.php'?>
<? if (($_SESSION['readerstyle'] == 'flash') || ($_SESSION['currentreader'] == 'flash')) { ?>
	<div id="flashreader">

	</div>
<script type="text/javascript">

				   var so = new SWFObject('/flash/reader.swf','mpl','100%',(theHeight-100),'9'); 
		
                  so.addParam('allowfullscreen','true'); 
                  so.addParam('allowscriptaccess','true'); 
				  so.addVariable('COMIC_URL','');
				  so.addVariable('DATA_URL','http://www.w3volt.com/processing/get_comic_xml.php?content=Stupid_Users');
				  so.addParam("wmode", "window");				  
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

		<? include 'includes/banner_ad_inc.php'?><br />

              <iframe src="/read_project.php?project=<? echo $_GET['project'];?>&page=<? echo $_GET['page'];?>" frameborder="0" width=100% height=0 
  id="readerframe" name="readerframe" 
  onload="resize_iframe(this);" scrolling="no"></iframe>
	
                



         
            
		<? }?>
        </td>
        
	</tr>
    
</table>
	</body>
</html>