<div id="thumbbar">You need to have your javascript turned on and make sure you have the latest version of Flash<a href="http://www.adobe.com/go/getflashplayer/" target="_blank">Player 9</a> or better installed.</div>
<script type="text/javascript"> 
<? if ($ThumbBrowserDirection == 'vertical') { ?>
    var so = new SWFObject('gallery/flash/thumb_browser.swf','thumbs','700','115','9');
<? } else if ($ThumbBrowserDirection == 'horizontal'){ ?>
	var so = new SWFObject('gallery/flash/thumb_browser_horiz.swf','thumbs','700','115','9');
<? }?>                  
				  so.addParam('allowfullscreen','true'); 
                  so.addParam('allowscriptaccess','true'); 
				  so.addVariable('contenttotal','<?php echo $TotalContent;?>');
                  so.addVariable('page','<?php echo $_GET['page'];?>');
				  so.addVariable('idarray','<?php echo $IdArray;?>');
				  so.addVariable('galleryid','<?php echo $GalleryID;?>');
				  so.addVariable('imagearray','<?php echo $ImageArray;?>');
                  so.write('thumbbar'); 
</script>