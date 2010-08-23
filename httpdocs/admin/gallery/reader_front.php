<?
if ($ThumbnailPlacement == 'top') {
	include 'thumb_bar.php'; 
}

if ($TopControl == 1) {
include 'top_bar.php'; 
}
?>
<div id="reader">You need to have your javascript turned on and make sure you have the latest version of Flash<a href="http://www.adobe.com/go/getflashplayer/" target="_blank">Player 9</a> or better installed.</div>

<script type="text/javascript"> 
    var so = new SWFObject('gallery/flash/gallery_image_reader_v6.swf','pfreader','<?php echo $Width;?>','<?php echo $Height;?>','9');             
				  so.addParam('allowfullscreen','true'); 
                  so.addParam('allowscriptaccess','true'); 
				  so.addVariable('pageimage','<?php echo $PageImage;?>');
				  so.addVariable('pagetitle','<?php echo addslashes($ContentTitle);?>');
				  so.addVariable('currentindex','<?php echo $CurrentIndex;?>');
                  so.write('reader'); 
</script>


