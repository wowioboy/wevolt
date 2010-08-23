<?php 
include 'includes/global_settings_inc.php';


include 'includes/init.php';?>
<? 
include 'includes/dbconfig.php';
include 'includes/message_functions.php';
$PageTitle = 'wevolt | studio';
?>

<?php include 'includes/header_template_new.php'; ?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_modules_css.css">


<script type="text/javascript">

	function rolloveractive(tabid, divid) {
	var divstate = document.getElementById(divid).style.display;
			if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='myvolttabhover';
			} 
	}
	function rolloverinactive(tabid, divid) {
			if (document.getElementById(divid).style.display != '') {
				document.getElementById(tabid).className ='myvolttabinactive';
			} 
	}
	

	</script>
    
    <style type="text/css">

#updateBox_T {
background-color:#e9eef4;
height:8px;
}

.updateboxcontent {
	color:#000000;
	background-color:#e9eef4;
}

#updateBox_B {
background-color:#e9eef4;
height:8px;
 
}


#updateBox_TL{
	width:8px;
	height:8px; 
	background-image:url(http://www.wevolt.com/images/update_wrapper_TL.png);
	background-repeat:no-repeat;
}
 
#updateBox_TR{
	width:8px;
	height:8px; 
	background-image:url(http://www.wevolt.com/images/update_wrapper_TR.png);
	background-repeat:no-repeat;
}

#updateBox_BR{
	width:8px;
	height:8px; 
	background-image:url(http://www.wevolt.com/images/update_wrapper_BR.png);
	background-repeat:no-repeat;
}
#updateBox_BL{
	width:8px;
	height:8px; 
	background-image:url(http://www.wevolt.com/images/update_wrapper_BL.png);
	background-repeat:no-repeat;
}

.linkthumb {
border:2px #000000 solid;

}
</style>


<div align="left">

<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
<tr>
<? if ($_SESSION['IsPro'] == 1) {
$_SESSION['noads'] = 1;
		?>
		<td valign="top" style="padding:5px; color:#FFFFFF;width:60px;">
			<? include 'includes/site_menu_popup_inc.php';?>
		</td> 
	<? } else {?>
<td width="<? echo $SideMenuWidth;?>" valign="top">
	<? include 'includes/site_menu_inc.php';?>
</td> 
<? }?>

<td  valign="top" align="center"><? if ($_SESSION['noads'] != 1) {?><iframe src="http://www.wevolt.com/includes/top_banner_inc.php" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no"></iframe> <? }?>
 <div class="spacer"></div> 	
    <? ?>
<table width="750" border="0" cellpadding="0" cellspacing="0" height="">
                  <tbody>
                    <tr>
                      <td id="modtopleft"></td> 
                      <td id="modtop" width="738" align="left">WELCOME TO WEVOLT</td>
                          
                      <td id="modtopright" align="right" valign="top"></td> 
                    </tr>
                    <tr>
                      <td colspan="3" valign="top" style="padding-left:3px; padding-right:3px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                              <td id="modleftside"></td>
                              <td class="boxcontent">
                      <div class="spacer"></div> 	  <div class="spacer"></div> 	
                  This is your welcome screen where you can jump to sections of the site that we think you might be interested in. We'll also post news/announcements here as well as on the homepage. <br>
<br>
You can turn this page off in your settings section which will take you straight to your myvolt on login. <br>
<br>
WHAT DO YOU WANT TO DO? <br>
<br>
<? if ($_SESSION['userid'] != '') {?>
<a href="http://users.wevolt.com/myvolt/<? echo $_SESSION['username'];?>/">MANAGE MYVOLTs</a> <br>
<a href="http://users.wevolt.com/<? echo $_SESSION['username'];?>/">PROMOTE STUFF ON WEVOLT</a> <br>
<a href="http://www.wevolt.com/r3volt/admin/">CREATE STUFF!</a> <br><br>
<br>

<? }?>
<a href="http://www.wevolt.com/comics.php">BROWSE COMICS</a> <br>
<a href="http://www.wevolt.com/search/">SEARCH WEVOLT!</a> <br>
<a href="http://www.wevolt.com/">CHECK OUT UPDATES ON HOMEPAGE</a> <br>
<a href="http://www.wevolt.com/forum/">VISIT THE WEVOLT FORUM</a> <br>
</td>
                        <td id="modrightside"></td>
                            </tr>
                            <tr>
                      <td id="modbottomleft"></td>
                      <td id="modbottom"></td>
                      <td id="modbottomright"></td>
                    </tr>
                          </tbody>
                      </table>


    
 	</td>
	
</tr>
</table>
</div>

<?php include 'includes/footer_template_new.php';?>




