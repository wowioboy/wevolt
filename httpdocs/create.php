<?php 
if ($_GET['p'] == 'contact')
	header("Location:/contact.php");
	
include 'includes/init.php';

$PageTitle = 'wevolt | create';
$TrackPage = 1;
include 'includes/header_template_new.php';?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_modules_css.css">



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
 		<? if (!isset($_GET['t'])) {?>
        
        <? if ($_SESSION['userid'] == '') {?>
      <img src="http://www.wevolt.com/images/create_toon_not_logged.png" />
        <? } else {?>
       <img src="http://www.wevolt.com/images/create_logged.png" border="0" usemap="#CreateMap" />
<map name="CreateMap" id="CreateMap"><area shape="rect" coords="224,140,407,188" href="http://www.wevolt.com/r3volt/admin/?t=projects&a=new&type=blog" />
<area shape="rect" coords="221,250,401,298" href="http://www.wevolt.com/r3volt/admin/?t=projects&a=new&type=comic" />
<area shape="rect" coords="220,370,396,415" href="http://www.wevolt.com/r3volt/admin/?t=projects&a=new&type=writing" />
<area shape="rect" coords="263,553,367,582" href="http://www.wevolt.com/upgrade.php" />
</map>
        <? }?>
        
        
        
        <? } else {?>
			<? if ($_GET['t'] == 'comic') {?>
            <img src="/images/create_comic.png" border="0" usemap="#CreateMap" />
<map name="CreateMap" id="CreateMap">
  <area shape="rect" coords="224,140,407,188" href="http://www.wevolt.com/r3volt/admin/?t=projects&a=new&type=comic" />
<area shape="rect" coords="258,275,363,303" href="http://www.wevolt.com/create.php" />
</map>
            
            <? } else if ($_GET['t'] == 'personal') { ?>
            <img src="/images/create_comic.png" border="0" usemap="#CreateMap" />
<map name="CreateMap" id="CreateMap">
  <area shape="rect" coords="224,140,407,188" href="http://www.wevolt.com/r3volt/admin/?t=projects&a=new&type=blog" />
<area shape="rect" coords="258,275,363,303" href="http://www.wevolt.com/create.php" />
</map>
            
            <? } else if  ($_GET['t'] == 'writing') {  ?>
            <img src="/images/create_comic.png" border="0" usemap="#CreateMap" />
<map name="CreateMap" id="CreateMap">
  <area shape="rect" coords="224,140,407,188" href="http://www.wevolt.com/r3volt/admin/?t=projects&a=new&type=writing" />
<area shape="rect" coords="258,275,363,303" href="http://www.wevolt.com/create.php" />
</map>
            
             <? }?>
          
<? }?>		
                            
 </div></td>
  </tr>
</table>
</div>
<?php include 'includes/footer_template_new.php';?>
