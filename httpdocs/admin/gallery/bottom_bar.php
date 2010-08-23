<div id="bottombar">You need to have your javascript turned on and make sure you have the latest version of Flash<a href="http://www.adobe.com/go/getflashplayer/" target="_blank">Player 9</a> or better installed.</div>
<script type="text/javascript"> 
    var so = new SWFObject('gallery/flash/gallery_bottom.swf','bottom','<?php echo $Width;?>','40','<?php echo '#'.$BGcolor;?>','9');                  
				  so.addParam('allowfullscreen','true'); 
                  so.addParam('allowscriptaccess','true'); 
                  so.addVariable('contenttotal','<?php echo $TotalContent;?>');
				  so.addVariable('idarray','<?php echo $IdArray;?>');
				  so.addVariable('galleryid','<?php echo $GalleryID;?>');
				  so.addVariable('pagetitle','<?php echo addslashes($ContentTitle);?>');
				  so.addVariable('currentindex','<?php echo $CurrentIndex;?>');
                  so.write('bottombar'); 
</script>
