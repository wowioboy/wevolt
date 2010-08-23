<? 
include 'includes/init.php';
include 'includes/image_resizer.php';
include 'includes/image_functions.php';
$db = new DB();
$IsImage = 0;
$Filename = $_POST['txtFilename'];
$Title = $_POST['txtTitle'];
$ProjectID = $_POST['txtProject'];
$FileID = $_POST['txtFile'];
$UserID = $_POST['txtUser'];
$ReadOnly = $_POST['txtReadOnly'];
$Description = $_POST['txtDescription'];
$Source_dir = 'temp/';
$DestinationDir = 'projects/media/';
//print "MY PROJECT ID = " .$ProjectID;
$ext = substr(strrchr($Filename, "."), 1);
$OriginalFile = $Source_dir.$Filename;
$FilenameArray = explode('.',$Filename);
$NewFileTitle = strtotime("now");
// make the random file name
//$randName = md5(rand() * time());
//$randName = rand(10,99);

//$NewFileTitle = str_replace(' ', '_', $Filename);
//$NewFileTitle = str_replace('&', 'and', $NewFileTitle);
//$NewFileTitle = str_replace(',', '', $NewFileTitle);

// and now we have the unique file name for the upload file
$NewFilePath = $Source_dir . $NewFileTitle. '.' . $ext;
copy($OriginalFile, $NewFilePath);
//print "I COPY $OriginalFile to $NewFilePath";
$Filename = $NewFileTitle. '.' . $ext;
$DestinationFile = $DestinationDir.$Filename;
copy($NewFilePath, $DestinationFile );
chmod($DestinationFile,0777);

if (($ext == 'jpg') || ($ext == 'JPEG') ||($ext == 'JPG') ||($ext == 'jpg') ||($ext == 'GIF') ||($ext == 'gif') ||($ext == 'png') ||($ext == 'PNG') ||($ext == 'bmp')) {
$IsImage = 1;
$image = new imageResizer($DestinationFile);
$Thumbsm = "projects/thumbs/".$NewFileTitle. '_sm.' . $ext;
	$image->resize(50, 50, 50, 50);
	$image->save($Thumbsm, JPG);
	chmod($Thumbsm,0777);
	$Thumblg = "projects/thumbs/".$NewFileTitle.  '_lg.' . $ext;
	$image->resize(150, 150, 150, 150);
	$image->save($Thumblg, JPG);
	chmod($Thumblg,0777);
	$Itemimage = "projects/images/".$NewFileTitle. '.'. $ext;
	$image->resize(600, 500, 600, 500);
	$image->save($Itemimage, JPG);
	chmod($Itemimage,0777);
}
@unlink($OriginalFile);
@unlink($NewFilePath);

if ($_POST['txtChange'] == 1) {
	$UserID = $_SESSION['id'];

	if ($IsImage == 1) {
		$query = "UPDATE pf_projects_files set Filename='$Filename',Type='$ext',UserID='$UserID', ThumbSm='$Thumbsm', ThumbLg='$Thumblg', GalleryImage='$Itemimage', ReadOnly = '$ReadOnly' where id='$FileID'";

	} else {
	$query = "UPDATE pf_projects_files set Filename='$Filename',Type='$ext',UserID='$UserID' where id='$FileID'";
	}
	$db->query($query);
	header("location:admin.php?a=projects&sub=file&id=".$FileID);
} else {

if ($IsImage == 1) {
$query = "INSERT into pf_projects_files (Title, Description, Filename, ThumbSm, ThumbLg, GalleryImage, Type, ProjectID, UserID, ReadOnly) values ('$Title', '$Description','$Filename', '$Thumbsm', '$Thumblg','$Itemimage', '$ext','$ProjectID','$UserID',$ReadOnly)";
} else {
$query = "INSERT into pf_projects_files (Title, Description, Filename, Type, ProjectID, UserID, ReadOnly) values ('$Title', '$Description','$Filename','$ext','$ProjectID','$UserID', $ReadOnly)";
}
$db->query($query);
header("location:admin.php?a=projects&sub=file");
}
?>
