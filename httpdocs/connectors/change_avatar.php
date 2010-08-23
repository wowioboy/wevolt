<?
 if(!isset($_SESSION)) {
    session_start();
  }
  
header('Content-type: text/html; charset=UTF-8');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: '.date('r'));
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Pragma: no-cache');
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';
$target_path = $_SERVER['DOCUMENT_ROOT']."/temp/";
$db = new DB();
?>
<style type="text/css">
body, html {
padding:0px;
margin:0px;

}
</style>
<?

	if ($_POST['change'] == 1) {	
		$target_path = $target_path . basename($_FILES['image']['name']);
		//print "Target Path = ". $target_path . basename($_FILES['image']['name']); 
		if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
				$Filename = basename( $_FILES['image']['name']);
				//print 'Filename = ' . $Filename .'<br/>';
				
				$file_extension = substr(strrchr($Filename, "."), 1);	
				$UserID = $_SESSION['userid'];
			
				$randName = md5(rand() * time());
				$UserName = trim($_SESSION['username']); 
					if(!is_dir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName)) 
							mkdir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName ."/", 0777); 
					if(!is_dir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName."/avatars")) 
							mkdir($_SERVER['DOCUMENT_ROOT']."/users/".$UserName ."/avatars/", 0777); 
					
			
			if (($file_extension == 'jpg') || ($file_extension == 'jpeg')|| ($file_extension == 'gif')|| ($file_extension == 'png')|| ($file_extension == 'jpg')) {
					$FileType = 'image';
					$originalimage = $_SERVER['DOCUMENT_ROOT']."/temp/".$Filename;
					$NewFilename = $randName.'.'.$file_extension;
					$TargetFile = 'users/'.$UserName .'/avatars/'.$randName.'.'.$file_extension;
					$convertString = "convert ".$originalimage." -resize 100 ".$_SERVER['DOCUMENT_ROOT']."/".$TargetFile;
					exec($convertString);
					chmod($_SERVER['DOCUMENT_ROOT']."/".$TargetFile,0777);
					$query = "UPDATE users set avatar = 'http://".$_SERVER['SERVER_NAME']."/".$TargetFile."' where encryptid='".$_SESSION['userid']."'";
					$db->execute($query);
					$Avatar = 'http://'.$_SERVER['SERVER_NAME'].'/'.$TargetFile;
					?> 		
		
			<? }?>
    
    <? }
	
	} else {
			$query = "SELECT avatar from users where encryptid='".$_SESSION['userid']."'";
			$Avatar = $db->queryUniqueValue($query);
	}
	
	$db->close(); ?>
<table cellspacing="5"><tr><td valign="top"><img src="<? echo $Avatar;?>" width="50" id="avatar_img" border="2"/></td><td class="messageinfo_white" valign="top">

		<form action="#" method="post" name="imageUpload" id="imageUpload" enctype="multipart/form-data">

			<input type="hidden" class="hidden" name="max_file_size" value="1000000" />
				<input type="file" name="image" id="image"/><br/>
                <input type="hidden" name="change" value="1" />
					<input class="submit" type="submit" name="submit" value="Upload" id="upload" />
	</form>
    </td></tr></table>
        
     