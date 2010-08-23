<?
 if(!isset($_SESSION)) {
    session_start();
  }
   $DEBUG=true;
  
 if ($DEBUG) {
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL ^ E_NOTICE);

}
header('Content-type: text/html; charset=UTF-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';

$target_path = $_SERVER['DOCUMENT_ROOT']."/temp/";
?>
<style type="text/css">
body, html {
background-color:#000000;
padding:0px;
margin:0px;

}
</style>
<div style="color:#ffffff;">


<?
	$target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
	//print "Target Path = ". $target_path . basename( $_FILES['uploadedfile']['name']); 
	if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
			$Filename = basename( $_FILES['uploadedfile']['name']);
			//print 'Filename = ' . $Filename .'<br/>';
			
			$file_extension = substr(strrchr($Filename, "."), 1);	
			$UserID = $_SESSION['userid'];
			$db = new DB();
			$randName = md5(rand() * time());
			$UserName = trim($_SESSION['username']); 
				if(!is_dir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName)) 
						mkdir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName ."/", 0777); 
				if(!is_dir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName."/media")) 
						mkdir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName ."/media/", 0777); 
				if(!is_dir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName."/media/images")) 
					mkdir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName ."/media/images", 0777); 
				if(!is_dir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName."/media/images/thumbs")) 
					mkdir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName ."/media/images/thumbs/", 0777); 
		  
		$FileOk = 1;
		
		if (($file_extension == 'jpg') || ($file_extension == 'jpeg')|| ($file_extension == 'gif')|| ($file_extension == 'png')|| ($file_extension == 'jpg')) {
				$FileType = 'image';
				$originalimage = $_SERVER['DOCUMENT_ROOT']."/temp/".$Filename;
				$NewFilename = $randName.'.'.$file_extension;
				$TargetFile = 'users/'.$UserName .'/media/images/'.$randName.'.'.$file_extension;
				copy($originalimage,$_SERVER['DOCUMENT_ROOT']."/".$TargetFile);
				//$OriginalFileName = explode('.',$Filename);
				list($Width,$Height)=getimagesize($_SERVER['DOCUMENT_ROOT']."/".$TargetFile);
				//if ($file_extension != 'bmp') {
					//new ImageConverter("../comics/".$ComicDirectory ."/media/".$Filename,'jpg');
					//$ConvertedImage = "../comics/".$ComicDirectory ."/media/".$OriginalFileName[0].'.jpg';
				//} else {
					//$ConvertedImage = "../comics/".$ComicDirectory ."/media/".$Filename;
				//}
				//$TargetFile = $ConvertedImage;
				//print "MY NEW FILE IMAGE = " . $TargetFile;

				//unlink($originalimage);
		
				
		
		//PF SYSTEM THUMBS
		
				$Thumb = "users/".$UserName ."/media/images/thumbs/".$randName . "_sm." . "jpg";
				$NewThumb= "/".$Thumb;
				if ($_GET['uploadaction'] == 'user_thumb') {
						$convertString = "convert ".$_SERVER['DOCUMENT_ROOT']."/".$TargetFile." -resize 200 -quality 60 ".$_SERVER['DOCUMENT_ROOT']."/".$Thumb;
						exec($convertString);
						print $convertString.'<br/>';
						
				} else {
					$convertString = "convert ".$_SERVER['DOCUMENT_ROOT']."/".$TargetFile." -resize 50 -quality 60 ".$_SERVER['DOCUMENT_ROOT']."/".$Thumb;
					exec($convertString);
					//print $convertString.'<br/>';
					//$image = new imageResizer($DocRoot.$TargetFile);
				//	$image->resize(50, 50, 50, 50);
				//	$image->save(DocRoot.$Thumb, JPG);
					
					//$image = null;
					//print 'THUMB = ' . $Thumb;
				}
				
				chmod($_SERVER['DOCUMENT_ROOT']."/".$Thumb,0777);
				
				
			} else {
				if (($file_extension == 'zip') || ($file_extension == 'pdf'))
					$FileType='download';
				else if ($file_extension == 'swf')
					$FileType='media';
				else if ($file_extension == 'flv')
					$FileType='media';
				else if ($file_extension == 'css')
					$FileType='webdocs';
				else 
					$FileOk = 0;	
					
				$originalfile = $_SERVER['DOCUMENT_ROOT']."/temp/".$Filename;
				$TargetFile = 'users/'.$UserName .'/media/'. $NewFilename;
				
				//$Filename = $randName.'.'.$file_extension;
				if ($FileOk == 1)
					copy($originalfile,$_SERVER['DOCUMENT_ROOT']."/".$TargetFile);
				//unlink($originalfile);					
			}
			
			
			
			if ($FileOk == 1) {
				chmod($_SERVER['DOCUMENT_ROOT']."/".$TargetFile,0777);
				$TargetFile =  'users/'.$UserName .'/media/images/'.$NewFilename;
				//print 'TARGET FILE = ' . $TargetFile;
				$query = "INSERT into pf_media (Filename, WorldID, FileType, Thumb, UploadBy, Height, Width, Hidden, Server) values ('$TargetFile','','$FileType','$Thumb','$UserID','$Height','$Width',1, '".$_SERVER['SERVER_NAME']."')";
				$db->query($query);
				//print $query.'<br/>';
				$query ="SELECT ID from pf_media WHERE UploadBy='$UserID' and Filename='$TargetFile'";
				$PageID = $db->queryUniqueValue($query);
				//print $query.'<br/>';
				$Encryptid = substr(md5($PageID), 0, 8).dechex($PageID);
				$query = "UPDATE pf_media SET EncryptID='$Encryptid' WHERE ID='$PageID'";
				$db->query($query);	
			//print $query.'<br/>';
					
			}
			 
} else {
    	echo "There was an error uploading the file, please try again!<br/><input type='button' onclick='document.location.href=\"/includes/media_upload_inc.php?compact=yes&transparent=1&uploadaction=user_thumb\";' value='GO BACK'>";
}
		

		?> 		
		<script language="javascript" type="text/javascript">

		window.parent.document.getElementById("txtThumb").value = 'http://<? echo $_SERVER['SERVER_NAME'];?>/<? echo $Thumb;?>';
		window.parent.document.getElementById("itemthumb").src = 'http:///<? echo $_SERVER['SERVER_NAME'];?><? echo $NewThumb;?>';
	//	alert('NEW THUMB SOURCE = ' +'http:///www.wevolt.com<?// echo $NewThumb;?>' );
		window.parent.document.getElementById("thumbselect").style.display = 'none';
		window.parent.document.getElementById("thumbdisplay").style.display = '';
		document.location.href = '/includes/media_upload_inc.php?compact=yes&transparent=1&uploadaction=user_thumb';
		
		</script>
	<? $db->close(); ?>
	
</div>