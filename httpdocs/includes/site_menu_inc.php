<?php 
if ($_SESSION['IsPro'] == 1) {

include_once($_SERVER['DOCUMENT_ROOT'] . '/components/_drawers.php'); 
?>
<div style="position:relative;top:-8px;left:-10px;">
<?php
 $Site->drawMainNavPro();
$Site->drawUserPanelPro();
?>
<script>
$(document).ready(function() {
	 $("ul.sf-menu").superfish({ 
         animation: {height:'show'},   // slide-down effect without fade-in 
         delay:     1200               // 1.2 second delay on mouseout 
     }); 
});
</script>
<div id="drawerProHolder" style="position:relative;left:60px;bottom:8px;">
<?php 
$drawers = new Drawers;
$drawers->getDrawers(true);
?>
</div>  
</div> 


<? } else {
include_once($_SERVER['DOCUMENT_ROOT'] . '/components/_drawers.php'); 
include_once($_SERVER['DOCUMENT_ROOT'] . '/classes/site.php');
$Site = new site;
?>
<div>
<div style="height:10px;"></div>
<div style="height:5px;"></div>

<div align="center">
<? $Site->drawLogoMenu('mainpop');?>
</div>

<div align="center" style="color:#FFFFFF; padding-top:5px;">
<? if (!isset($_SESSION['username'])) $Site->drawLoginDiv();?> 
</div>


<!-- MAIN NAVIGATION -->
<div align="center" >
<? $Site->drawMainNav();?>
<div class="spacer"></div>
</div>


<!-- WELCOME  TAG -->
<? if (isset($_SESSION['username'])) $Site->showWelcome($_SESSION['username']);?>


<!--GET STARTED MODULE -->
<? if ($_SESSION['userid'] == '') {
$Site->drawGetStartedMod();?>
<div class="spacer"></div>
 <? }?>
              
<div align="center" id="navdiv">
<? if (isset($_SESSION['userid'])) {?>
	<?php $Site->drawUserLevel(); ?>
     <div class="spacer"></div>
      <? $Site->drawUserMenu();?>
    <div class="spacer"></div>
     <? $Site->drawDrawerMenu(1,4,'below');?>
    <? if ($SecondDrawer == 1) {?>
    <div class="spacer"></div>
    <? $Site->drawDrawerMenu(2,4,'below');?>
<? }?>
</div> 
<script>
$(document).ready(function() {
	 $("ul.sf-menu").superfish({ 
         animation: {height:'show'},   // slide-down effect without fade-in 
         delay:     1200               // 1.2 second delay on mouseout 
     }); 
});
</script>
<div id="drawerHolder">
<?php 
$drawers = new Drawers;
$drawers->getDrawers();
?>
<div class="spacer"></div>
</div>                  
<? }?>

<center>
<!--AD TAGS-->
<iframe src="" allowtransparency="true" width="300" height="250" frameborder="0" scrolling="no" id="left_ads" name="left_ads"></iframe>  <div class="spacer"></div>
<?php if (($Section == 'Pages') && ($_SESSION['userid'] != '')) {?>

<? } else {?>
<div style="width:284px;">
  <div class="panel_top">
    <div class="display:table;width:100%;">
      <div style="display:table-cell;width:284px;height:20px;text-align:right;vertical-align:middle;">
        <span id="lowernavs"></span>
      </div>
    </div>
  </div>
  <div class="panel_body" style="height:156px;">
    <?php  echo $Site->getSpotlight(); ?>
  </div>
</div>

<? }?>
</center>
<div>
</div>
</div>
<div style="margin-top:20px;">
<?php $Site->drawLegal();?>
</div>

<? }?>