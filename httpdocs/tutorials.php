<?php 
if ($_GET['p'] == 'contact')
	header("Location:/contact.php");
include 'includes/init.php';
include_once(CLASSES.'/site.php');
include_once(CLASSES.'/tutorial.php');
if ($_GET['tid'] == '')
	$TID = 1;
else 
	$TID = $_GET['tid'];
$Tutorial = new tutorial($TID);

$PageTitle = 'wevolt | ';

if ($_GET['tid'] != '')
	$PageTitle .= $Tutorial->get_title();
else 
	$PageTitle .= 'tutorials';

if ($_GET['step'] != '')
	$PageTitle .= ' - Step '. $_GET['step'];
	 
$TrackPage = 1;

$Site = new site();

include 'includes/header_template_new.php';
$Site->drawModuleCSS();
?>
<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <? if ($_SESSION['IsPro'] == 1) {
           $_SESSION['noads'] = 1;
		?>
    <td valign="top" style="padding:5px; color:#FFFFFF;width:60px;"><? include 'includes/site_menu_popup_inc.php';?></td>
    <? } else {?>
    <td width="<? echo $SideMenuWidth;?>" valign="top"><? include 'includes/site_menu_inc.php';?></td>
    <? }?>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
          <div class="spacer"></div>

          		<? if ($TID == '') 
					$Tutotial->getTutorials();
				else 
					$Tutorial->buildStep($_GET['step']);?>
					

      	</div>
    </td>
  </tr>
</table>
</div>
<?php include 'includes/footer_template_new.php';?>

