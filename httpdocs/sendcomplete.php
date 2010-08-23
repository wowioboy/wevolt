<?php 
include 'includes/global_settings_inc.php';
include 'includes/init.php';
$TrackPage = 0;
$PageTitle = 'wevolt | send success!'
?>

<?php include 'includes/header_template_new.php'; ?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_modules_css.css">

    
 
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

    <? ?>
<table width="750" border="0" cellpadding="0" cellspacing="0" height="">
                  <tbody>
                    <tr>
                      <td id="modtopleft"></td>
                      <td id="modtop" width="738" align="left">WEVOLT MOBILE</td>
                          
                      <td id="modtopright" align="right" valign="top"></td>
                    </tr>
                    <tr>
                      <td colspan="3" valign="top" style="padding-left:3px; padding-right:3px;"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tbody>
                            <tr>
                              <td id="modleftside"></td>
                              <td class="boxcontent">
                              <div class="pageheader">CONTENT SUCCESSFULLY SENT</div>
		<div style="padding:25px;">You will recieve a text message shortly with a link to download your wallpaper. You should recieve your text message shortly, depending on the carrier it could take from a few seconds to a few minutes.  </div>
				  <div class='spacer'></div><a href="/mobile.php">BACK TO MOBILE</a>
                  
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




		

