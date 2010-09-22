<?php 
include 'includes/init.php';
$TrackPage = 1;
$PageTitle .='contact'; 
if ($_SESSION['IsPro'] == 1) 
    $_SESSION['noads'] = 1;
require_once('includes/pagetop_inc.php');
$Site->drawModuleCSS();

?>

<div align="center">
<table cellpadding="0" cellspacing="0" border="0" width="<? echo $TemplateWrapperWidth;?>">
  <tr>
    <td valign="top" align="center">
    <div class="content_bg">
		<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <?php $Site->drawControlPanel(); ?>
            </div>
        <? }?>
        <? if ($_SESSION['noads'] != 1) {?>
            <div id="ad_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;" align="center">
                <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
            </div>
        <?  }?>
       
       
        <div id="header_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;">
           <? $Site->drawHeaderWide();?>
        </div>
    </div>
    
     <div class="shadow_bg">
        	 <? $Site->drawSiteNavWide();?>
    </div>
    
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
</div>
  
<?php require_once('includes/pagefooter_inc.php'); ?>



