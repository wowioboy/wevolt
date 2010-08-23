<? $db = new DB();
$query = "SELECT Title from pf_store_items where id='$ItemID'";
$Title = $db->queryUniqueValue($query);
?>

<table width='100%' border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td id="contenttopleft"></td>
    <td  id='sidebartop'>&nbsp;</td>
    <td id='contenttop'>&nbsp;</td>
    <td id='contenttopright'>&nbsp;</td>
  </tr>
  <tr>
    <td id="contentleftside"></td>
    <td width="187" class='adminSidebar'><div class='adminSidebarHeader'><div style="height:7px;"></div>
      CHANGE IMAGE</div>
    </td>
    <td class='adminContent' valign="top">
<div align="center">

<div id="imageuploader">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
<form action="upload_gallery_image.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td><strong>Store Image File Upload </strong></td>
</tr>
<tr>
<td>Select file
<input name="Filedata" type="file" id="Filedata" size="50" /><br />
<div class="spacer"></div></td>
</tr>
<tr>
<td><p>Select the Width of the Thumbnails you want to create:<br />
      <input type="radio" name="txtWidth50" value="50" />
  50 Pixels wide<br />
  
      <input type="radio" name="txtWidth100" value="100" />
  100 Pixels wide<br />
  
      <input type="radio" name="txtWidth200" value="200" />
  200 Pixels wide<br />
  
      <input type="radio" name="txtWidth400" value="400" />
  400 Pixels wide<br />
  <input type="radio" name="txtWidth400" value="400" />
  Custom Width
  <input type="text" name="txtWidthCustom" maxlength="3"  style="height:15px;width:50px;" /> 
  (enter width) 
</p>
  <div class="spacer"></div>
Do you want to Crop your image after uploading?<br />
<input type="radio" name="txtCrop" value="1" /> YES

</td>
</tr>
<tr>
<td align="center"><input type="submit" name="Submit" value="Upload" /></td>
</tr>
</table>
</td>
<input type="hidden" name="txtItem" value="<? echo $ItemID; ?>" >
</form>
</tr>
</table>
</div>

<script type="text/javascript"> 

    var so = new SWFObject('flash/upload_store.swf','upload','700','350','9');
	
		so.addParam('allowfullscreen','true'); 
        so.addParam('allowscriptaccess','true'); 
        so.addVariable('itemID','<? echo $ItemID; ?>');
		 so.addVariable('titlename','<? echo $Title; ?>');
		 so.addVariable('changeimage','1');
        so.write('imageuploader'); 
</script>


</div></td>
    <td id='contentrightside'>&nbsp;</td>
  </tr>
  <tr>
    <td id='contentbottomleft'>&nbsp;</td>
    <td id='sidebottom'>&nbsp;</td>
    <td id='contentbottom'>&nbsp;</td>
    <td id='contentbottomright'>&nbsp;</td>
  </tr>
</table>
