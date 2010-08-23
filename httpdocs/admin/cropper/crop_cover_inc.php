<div class="content" align="center">
		<table width="400"><tr><td>
		<form action="cropcover.php" method="post" name="imageUpload" id="imageUpload" enctype="multipart/form-data">

			<div>UPLOAD IMAGE TO USE FOR YOUR COMIC THUMB.</div>
		<div class="spacer"></div>
		
			<input type="hidden" class="hidden" name="max_file_size" value="1000000" />
			<div class="file">
				<label for="image">Image</label>
				<input type="file" name="image" id="image" />
			</div>
		
			<div id="submit">
				<input class="submit" type="submit" name="submit" value="Upload" id="upload" />
			</div>
			<div class="hidden" id="wait">
				<img src="/images/wait.gif" alt="Please wait..." />
			</div>
		
		</form>
		</td></tr></table></div>