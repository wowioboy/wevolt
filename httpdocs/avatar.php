<?php 

$scripts = '	<script type="text/javascript" src="lib/prototype.js"></script>
	<script type="text/javascript" src="lib/scriptaculous.js"></script>
	<script type="text/javascript" src="lib/init_wait.js"></script>';

include 'avatarheader.php' ?>
<div class="content" align="center">
		<table width="400"><tr><td>
		<form action="crop_image.php" method="post" name="imageUpload" id="imageUpload" enctype="multipart/form-data">
		<fieldset>
			<div>UPLOAD IMAGE TO USER FOR AVATAR </div><div class="spacer"></div>
			<max size 3mb> 
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
		</td></tr></table></div>

 <!-- /info -->

<?php include 'footer.php' ?>
</div>