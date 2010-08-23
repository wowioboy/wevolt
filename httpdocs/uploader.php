<?
header('Content-type: text/html; charset=UTF-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
$target_path = "temp/";
$ResizeWidth = $_POST['txtResizeWidth'];
?>
<style type="text/css">
body, html {
background-color:#ffffff;
padding:0px;
margin:0px;

}
</style>
<div style="background-color:#ffffff; color:#000000;"><?
if ($_POST['fileurl'] != '') {
	$Image = $_POST['fileurl'];
	$gif = file_get_contents($Image) or die('Could not grab the file');
			if (exif_imagetype($Image) == IMAGETYPE_GIF) {
				$ext = 'gif';
			} else if (exif_imagetype($Image) == IMAGETYPE_JPEG) {
				$ext = 'jpg';
			} else if (exif_imagetype($Image) == IMAGETYPE_PNG) {
				$ext = 'png';
			}
			$randName = md5(rand() * time());
			$fp  = fopen('temp/'.$randName.'.'.$ext, 'w+') or die('Could not create the file');
			fputs($fp, $gif) or die('Could not write to the file');
			fclose($fp);
			chmod('temp/'.$randName.'.'.$ext,0777);
			$Filename = $randName.'.'.$ext;
			
			if ($ResizeWidth != '') {
				$convertString = "convert temp/$Filename -resize $ResizeWidth temp/$Filename";
				exec($convertString);
				chmod('temp/'.$Filename,0777);
			}
			
			
			$Thumb = 'temp/thumbs/'.$randName.'.'.$ext;
			$convertString = "convert temp/$Filename -resize 470 -quality 60 $Thumb";
			exec($convertString);
			chmod($Thumb,0777);
			?>
			<script type="text/javascript">
			<? if (isset($_GET['type'])) {
				if ($_GET['type'] =='pencils') { ?>
					window.parent.document.getElementById("txtPeelOneFilename").value = '<? echo $Filename;?>';
					window.parent.document.getElementById("peeloneimage").src = '/temp/thumbs/<? echo $Filename;?>';
						
				<? } else if ($_GET['type'] =='colors') { ?>
					window.parent.document.getElementById("txtPeelThreeFilename").value = '<? echo $Filename;?>';
					window.parent.document.getElementById("peelthreeimage").src = '/temp/thumbs/<? echo $Filename;?>';
				<? } else if ($_GET['type'] =='inks') { ?>
					window.parent.document.getElementById("txtPeelTwoFilename").value = '<? echo $Filename;?>';
					window.parent.document.getElementById("peeltwoimage").src = '/temp/thumbs/<? echo $Filename;?>';
				<? } ?>
				
				
			<? } else {?>
				window.parent.document.getElementById("txtFilename").value = '<? echo $Filename;?>';
				window.parent.document.getElementById("pageimage").src = '/temp/thumbs/<? echo $Filename;?>';
				
			<? }?>
				alert('Your image Has Been Processed, you will need to still save your changes for the new page to take effect');
				
				
				<? if (isset($_GET['type'])) {?>
					document.location.href = '/pf_16_core/includes/file_upload_inc.php?type=<? echo $_GET['type'];?>&compact=<? echo $_GET['compact'];?>';
				<? } else { ?>
					document.location.href = '/pf_16_core/includes/file_upload_inc.php?compact=<? echo $_GET['compact'];?>';
				<? }?> 
				
</script>
            
            <?
} else {
	$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
	//print "Target Path = ". $target_path . basename( $_FILES['uploadedfile']['name']); 
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
	
		$Filename = basename( $_FILES['uploadedfile']['name']);
		if (exif_imagetype($target_path) == IMAGETYPE_GIF) {
				$ext = 'gif';
			} else if (exif_imagetype($target_path) == IMAGETYPE_JPEG) {
				$ext = 'jpg';
			} else if (exif_imagetype($target_path) == IMAGETYPE_PNG) {
				$ext = 'png';
			}
		
		$randName = md5(rand() * time());
		copy('temp/'.$Filename, 'temp/'.$randName.'.'.$ext);
		chmod('temp/'.$randName.'.'.$ext,0777);
		unlink($target_path);
		$Filename = $randName.'.'.$ext;
		
		if ($ResizeWidth != '') {
				$convertString = "convert temp/$Filename -resize $ResizeWidth temp/$Filename";
				exec($convertString);
				chmod('temp/'.$Filename,0777);
		}
		$Thumb = 'temp/thumbs/'.$randName.'.'.$ext;
		 if ($_GET['type'] =='store') {
		 $convertString = "convert temp/$Filename -resize 150 -quality 60 $Thumb";
		 } else  if ($_GET['type'] =='rgbanner') {
		 $convertString = "convert temp/$Filename -resize 200 -quality 60 $Thumb";
		 } else {
		$convertString = "convert temp/$Filename -resize 350 -quality 60 $Thumb";
		}
		exec($convertString);
		//print $convertString;
		chmod($Thumb,0777);
		?>
<script type="text/javascript">
			
			//alert(window.parent.document.getElementById("pageimage").src);
		<? if ($_GET['type'] != '') {
				if ($_GET['type'] =='pencils') { ?>
					window.parent.document.getElementById("txtPeelOneFilename").value = '<? echo $Filename;?>';
					window.parent.document.getElementById("pencilsdiv").innerHTML = '<img src=\"/temp/thumbs/<? echo $Filename;?>\" id=\"peeloneimage\">';
					//window.parent.document.getElementById("peeloneimage").src = '/pf_16_core/temp/thumbs/<? //echo $Filename;?>';
				<? } else if ($_GET['type'] =='colors') { ?>
					window.parent.document.getElementById("txtPeelThreeFilename").value = '<? echo $Filename;?>';
					window.parent.document.getElementById("colorsdiv").innerHTML = '<img src=\"/temp/thumbs/<? echo $Filename;?>\" id=\"peeltwoimage\">';
					//window.parent.document.getElementById("peelthreeimage").src = '/pf_16_core/temp/thumbs/<? //echo $Filename;?>';
				<? } else if ($_GET['type'] =='inks') { ?>
					window.parent.document.getElementById("txtPeelTwoFilename").value = '<? echo $Filename;?>';
					window.parent.document.getElementById("inksdiv").innerHTML = '<img src=\"/temp/thumbs/<? echo $Filename;?>\" id=\"peelthreeimage\">';
					//window.parent.document.getElementById("peeltwoimage").src = '/pf_16_core/temp/thumbs/<? //echo $Filename;?>';
				<? } else if ($_GET['type'] =='store') { ?>
					window.parent.document.getElementById("txtThumb").value = '<? echo $Filename;?>';
					window.parent.document.getElementById("currentthumb").innerHTML = '<img src=\"/temp/thumbs/<? echo $Filename;?>\">';
					window.parent.document.getElementById("savealert").innerHTML = '<div style=\"padding:5px;\">You have unsaved changes, you must click save for these changes to take effect.</div>';
					document.location.href = '/pf_16_core/includes/store_thumb_upload_inc.php?itemid=<? echo $_SESSION['itemid'];?>';
					//window.parent.document.getElementById("peeltwoimage").src = '/pf_16_core/temp/thumbs/<? //echo $Filename;?>';
				<? } else if ($_GET['type']=='rgbanner') {?>
					window.parent.document.getElementById("txtFilename").value = '<? echo $Filename;?>';
					window.parent.document.getElementById("pageimage").src = '/temp/thumbs/<? echo $Filename;?>';		
				<? } ?>				
		<? } else {?>
					<? if ($_GET['s'] == 'menu') {
										if ($_GET['action'] == 'button') {?>
								window.parent.document.menuform.txtButtonFilename.value = '<? echo $Filename;?>';
								parent.document.getElementById("buttonimage").src = '/temp/<? echo $Filename;?>';
							<? } else if ($_GET['action'] == 'rollover') {?>
							//window.parent.document.menuform.txtRollFilename.value
								window.parent.document.menuform.txtRollFilename.value = '<? echo $Filename;?>';
						   		parent.document.getElementById("rollimage").src = '/temp/<? echo $Filename;?>';
							<? }?> 
					<? } else {?>
						window.parent.document.getElementById("txtFilename").value = '<? echo $Filename;?>';
						window.parent.document.getElementById("pageimage").src = '/temp/thumbs/<? echo $Filename;?>';	
						//alert(window.parent.document.getElementById("txtFilename").value);
						//alert('THE FILE = ' + window.parent.document.getElementById("pageimage").src);	
					<? }?>
		<? }?>
		<? if ($_GET['type'] != 'store'){?>
			<? if ($_GET['s'] != 'menu') { ?>
				window.parent.document.getElementById("savealert").innerHTML = '<div style=\"padding:5px;\">Your new image has been changed, you will need to still save your changes to take effect</div>';
				<? }?>
			<? if (($_GET['type'] != '') && ($_GET['type'] != 'store')) {?>
						document.location.href = '/pf_16_core/includes/file_upload_inc.php?type=<? echo $_GET['type'];?>&compact=<? echo $_GET['compact'];?>';
			<? } else if ($_GET['type'] == '') { 
					if ($_GET['s'] == 'menu') { ?>
						parent.document.getElementById("savealert").innerHTML = '<div style=\"padding:5px;\ width="300px;">Your Menu has changed, you will need to save your changes to take effect</div>';
						<? if ($_GET['action'] == 'button') {?>
								parent.imageupload.location.href = 'includes/file_upload_inc.php?s=menu&a=button';
						<? } else if ($_GET['action'] == 'rollover') {?>
								parent.rollupload.location.href = 'includes/file_upload_inc.php?s=menu&a=rollover';
							
						<? }?>	
									
					<? } else {?>
						document.location.href = '/pf_16_core/includes/file_upload_inc.php?compact=<? echo $_GET['compact'];?>';
					<? }?>
					
			<? }?> 
		
	<? }?>
				
</script>
            
            <?
	} else{
    	echo "There was an error uploading the file, please try again!<br/><input type='button' onclick='document.location.href=\"/pf_16_core/includes/file_upload_inc.php?compact=".$_GET['compact']."&type=".$_GET['type']."\";' value='GO BACK'>";
	}

}
?>
</div>