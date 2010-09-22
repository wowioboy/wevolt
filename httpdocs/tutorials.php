<?php 
include 'includes/init.php';
include_once(CLASSES.'/site.php');
include_once(CLASSES.'/tutorial.php');
if ($_GET['tid'] == '')
	$TID = 1;
else 
	$TID = $_GET['tid'];
$Tutorial = new tutorial($TID);

$PageTitle = 'WEvolt | ';

if ($_GET['tid'] != '')
	$PageTitle .= $Tutorial->get_title();
else 
	$PageTitle .= 'tutorials';

if ($_GET['step'] != '')
	$PageTitle .= ' - Step '. $_GET['step'];
	 
$TrackPage = 1;

$Site = new site();

include_once('includes/pagetop_inc.php');
$Site->drawModuleCSS();
?>

<div align="left">
<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <? $Site->drawControlPanel('100%');?>
            </div>
        <? }?>
 <?  if ((($_SESSION['IsPro'] == 1) || ($_SESSION['ProInvite'] == 1) || ($_SESSION['IsSuperFan'] == 1)) && ($_SESSION['sidebar'] == 'closed')) {?>
 <div id="pronav">
                <? $Site->drawProNav('100%');?>
 </div>
 <? }?>       

	<table cellpadding="0" cellspacing="0" border="0" id="container" width="100%">

	<tr><? if (($_SESSION['IsPro'] == 1) || ($_SESSION['ProInvite'] == 1)) {
				$_SESSION['noads'] = 1;
			$FlashHeight = 1;
	} else {
			$_SESSION['noads'] = 0;
			$FlashHeight = 90;	
	} 
		?> 
        <? if ($_SESSION['sidebar'] == 'open') {?>
		<td valign="top" id="sidebar">
			<?  include 'includes/sidebar_inc.php';?>
		</td> 

        <? }?>
        <td  valign="top" align="center"  <? if ($_SESSION['sidebar'] == 'open') {?>rowspan="2"<? }?> valign="top">
        
		 <? 
	 if ($_SESSION['noads'] == 0) {?>

				  <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
           <? }?>
           <div style="padding:10px;">
          <div class="spacer"></div>

          		<? if ($TID == '') 
					$Tutotial->getTutorials();
				else 
					$Tutorial->buildStep($_GET['step']);?>
					

      	</div>
         
        </td></tr>
         <? if ($_SESSION['sidebar'] == 'open') {?><tr>
    <td id="sidebar_footer"></td>
  </tr>
  <? }?>
      </table>
		

</div>

<?php include 'includes/pagefooter_inc.php';

?>


