<?  
include_once("includes/init.php"); 
include 'processing/index_functions.php';
?>
<?php include 'includes/header.php'; ?>
<div class="spacer"></div>	

<div class="contentwrapper" align="center">

<table width="<? echo $SiteWidth;?>" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td id="header" bgcolor="#000000" valign="middle" align="center"><img src="images/tyler_header.jpg" /></td>
  </tr>
  <tr>
  <td id="content" bgcolor="#FFFFFF" style="padding:10px;">
	<? //MENU TABLE?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  		<tr>
    	<td valign="middle" id="topmenu">
		<? 
		include 'apps/menu_display.php';
		?></td>
  		</tr>
	</table> 

<div class="contentwrapper" style="background-color:#a2b7b3;">
<? include 'includes/body_content_inc.php';?>
</div>

	</td>
 	</tr>
  	<tr>
    <td id="footer">&nbsp;</td>
  	</tr>
</table>

</div>			
<?php include 'includes/footer.php'; ?>	