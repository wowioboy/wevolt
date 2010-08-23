<? 
$db = new DB();
$query = "select * from pf_gallery_galleries where id='$GalleryID'";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
$GalleryType = $line->Type;
}
?>
<div align="center">
<? if ($GalleryType == 'image') { ?>
<div id="imageuploader">

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
<form action="admin.php?a=gallery&task=editupload" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td><strong>Image Gallery File Upload </strong></td>
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
<input type="hidden" name="txtGallery" value="<? echo $GalleryID; ?>" >
</form>
</tr>
</table>
</div>

<script type="text/javascript"> 

    var so = new SWFObject('flash/upload_images.swf','upload','700','350','9');
	
		so.addParam('allowfullscreen','true'); 
        so.addParam('allowscriptaccess','true'); 
        so.addVariable('galleryID','<? echo $GalleryID; ?>');
        so.write('imageuploader'); 
</script>

<? } else if ($GalleryType == 'sound') { ?>
<div id="sounduploader">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
<form action="admin.php?a=gallery&task=editupload" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td><strong>Sound Gallery File Upload </strong></td>
</tr>
<tr>
<td>Select file
<input name="Filedata" type="file" id="Filedata" size="50" /><br />
<div class="spacer"></div></td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td align="center"><input type="submit" name="Submit" value="Upload" /></td>
</tr>
</table>
</td>
<input type="hidden" name="txtGallery" value="<? echo $GalleryID; ?>" >
</form>
</tr>
</table>
</div>

<script type="text/javascript"> 

    var so = new SWFObject('flash/upload_sounds.swf','upload','400','225','9');
	
		so.addParam('allowfullscreen','true'); 
        so.addParam('allowscriptaccess','true'); 
        so.addVariable('galleryID','<? echo $GalleryID; ?>');
        so.write('sounduploader'); 
</script>

<? } else if ($GalleryType == 'video') { ?>

<div id="videouploader">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1">
<tr>
<form action="admin.php?a=gallery&task=editupload" method="post" enctype="multipart/form-data" name="form1" id="form1">
<td>
<table width="100%" border="0" cellpadding="3" cellspacing="1">
<tr>
<td><strong>Video Gallery File Upload </strong></td>
</tr>
<tr>
<td>Select file
<input name="Filedata" type="file" id="Filedata" size="50" /><br />
<div class="spacer"></div></td>
</tr>
<tr>
<td>
</td>
</tr>
<tr>
<td align="center"><input type="submit" name="Submit" value="Upload" /></td>
</tr>
</table>
</td>
<input type="hidden" name="txtGallery" value="<? echo $GalleryID; ?>" >
</form>
</tr>
</table>
</div>

<script type="text/javascript"> 

    var so = new SWFObject('flash/upload_videos.swf','upload','400','225','9');
	
		so.addParam('allowfullscreen','true'); 
        so.addParam('allowscriptaccess','true'); 
        so.addVariable('galleryID','<? echo $GalleryID; ?>');
        so.write('videouploader'); 
</script>

<? } ?>
</div>