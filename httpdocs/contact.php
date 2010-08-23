<?php 
include 'includes/init.php';
$TrackPage = 1;
$PageTitle =' wevolt | contact'; 
if ($_SESSION['IsPro'] == 1) 
    $_SESSION['noads'] = 1;

 include 'includes/header_template_new.php';
$Site->drawModuleCSS(); ?>

<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
<tr>
    <td valign="top" <? if ($_SESSION['IsPro'] == 1) {?>style="padding:5px; color:#FFFFFF;width:60px;"<? } else {?>width="<? echo $SideMenuWidth;?>"<? }?>><? include 'includes/site_menu_inc.php';?></td>

<td  valign="top" align="center"><? if ($_SESSION['noads'] != 1) {?><div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div><? }?>

<div align="center">
<div class="spacer"></div>
                           <img src="http://www.wevolt.com/images/contact_header.png">
                           <div class="spacer"></div>
                           <img src="http://www.wevolt.com//images/contact_info.png" />
                           <div class="spacer"></div>
                           <img src="http://www.wevolt.com/images/contact_boxes.gif" border="0" usemap="#Map">
<map name="Map" id="Map">
<area shape="rect" coords="16,62,204,93" href="mailto:listenup@wevolt.com" />
<area shape="rect" coords="17,232,207,261" href="mailto:twoheads@wevolt.com" />
<area shape="rect" coords="379,88,572,114" href="mailto:letsrock@wevolt.com" /><area shape="rect" coords="380,235,572,263" href="mailto:hailmary@wevolt.com" />
<area shape="rect" coords="174,377,510,414" href="http://store.wevolt.com">
<area shape="rect" coords="171,426,497,473" href="http://www.wevolt.com/studio.php">
<area shape="rect" coords="171,486,498,521" href="http://www.wevolt.com/mobile.php">
</map>
                           <div class="spacer"></div>                   
  </div>
 	</td>
</tr>
</table>

<?php include 'includes/footer_template_new.php';?>


