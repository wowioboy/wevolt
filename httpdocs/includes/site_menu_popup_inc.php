<?php 
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


