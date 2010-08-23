<?php 
include 'includes/init.php';

$InitDB->close();
$PageTitle .= 'become a SuperFan';
$TrackPage = 1;
include 'includes/header_template_new.php';
?>

<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <td valign="top" <? if ($_SESSION['IsPro'] == 1) {?>width="60"<? } else {?>width="<? echo $SideMenuWidth;?>"<? }?>><? include 'includes/site_menu_inc.php';?></td>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
          <div class="spacer"></div>
          <center>
         <img src="http://www.wevolt.com/images/super_fan_info.png" />
          <div class="spacer"></div> <div class="spacer"></div> <div class="spacer"></div> <div class="spacer"></div>
          <div><a href="http://www.wevolt.com/register.php?a=pro"><img src="http://www.wevolt.com/images/take_tour_btn.png" border="0"/></a>&nbsp;&nbsp;&nbsp;<a href="http://www.wevolt.com/register.php?a=pro&page=8"> <img src="http://www.wevolt.com/images/sign_me_up_icon.png" border="0"/></a></div>
        </center>
      </div></td>
  </tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>

