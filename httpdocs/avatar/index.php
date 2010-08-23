<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$PageTitle .= 'change avatar';
$TrackPage = 1;
include $_SERVER['DOCUMENT_ROOT'].'/includes/header_template_new.php';
$Site->drawModuleCSS();
 if ($_SESSION['IsPro'] == 1) {
           $_SESSION['noads'] = 1;
		} 
?>

<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <td valign="top" <? if ($_SESSION['IsPro'] == 1) {?>width="60"<? } else {?>width="<? echo $SideMenuWidth;?>"<? }?>><? include $_SERVER['DOCUMENT_ROOT'].'/includes/site_menu_inc.php';?></td>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id-"top_ads"></iframe></div>
      <? }?>
        <div style="padding:10px;">
        
		<form action="crop_image.php" method="post" name="imageUpload" id="imageUpload" enctype="multipart/form-data">
		<fieldset>
			<legend>UPLOAD IMAGE TO USER FOR AVATAR <max size 3mb> </legend>
			<input type="hidden" class="hidden" name="max_file_size" value="1000000" />
			<div class="file">
				<label for="image">Image</label>
				<input type="file" name="image" id="image" />
			</div>
		
			<div id="submit">
				<input class="submit" type="submit" name="submit" value="Upload" id="upload" />
			</div>
			<div class="hidden" id="wait">
				<img src="images/wait.gif" alt="Please wait..." />
			</div>
		</fieldset>
		</form>
        
      </div></td>
  </tr>
</table>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/includes/footer_template_new.php';?>
