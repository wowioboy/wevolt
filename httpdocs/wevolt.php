<?php 
if ($_GET['p'] == 'contact')
	header("Location:/contact.php");
	
include 'includes/init.php';
 if ($_SESSION['IsPro'] == 1) 
           $_SESSION['noads'] = 1;

$PageTitle = 'wevolt | about';
$TrackPage = 1;
include 'includes/header_template_new.php';
$Site->drawModuleCSS(); ?>

<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
  <td valign="top" <? if ($_SESSION['IsPro'] == 1) {?>style="padding:5px; color:#FFFFFF;width:60px;"<? } else {?>width="<? echo $SideMenuWidth;?>"<? }?>><? include 'includes/site_menu_inc.php';?></td>
      <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?> ><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        
        <div style="padding:10px;" ><img src="http://www.wevolt.com/images/wevolt_about.png" />
        <div class="spacer"></div> <div class="spacer"></div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/tutorial/?tid=1&step=1"><img src="http://www.wevolt.com/images/quick_tour.png" border="0" /></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/register.php"><img src="http://www.wevolt.com/images/sc_sign_up.png" border="0" /></a><div class="spacer"></div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/origin.php"><img src="http://www.wevolt.com/images/origin_story_btn.png" border="0" /></a></div> </td>
  </tr>
</table>
</div>
<?php include 'includes/footer_template_new.php';?>
