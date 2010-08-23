<?php
function getExtension($file) {
  $pos = strrpos($file, '.');
  if(!$pos) {
    return 'Unknown Filetype';
  }
  $str = substr($file, $pos, strlen($file));
  return $str;
}

$ext = getExtension($HTTP_POST_FILES['ufile']['name'][0]);
switch($ext) {
  case 'jpg' :
  	$Filename = strtotime("now").".jpg";  
    break;
  case 'gif' :
    $Filename = strtotime("now").".gif";  
    break;
  case 'png' :
    $Filename = strtotime("now").".png";  
    break;
  case 'jpeg' :
    $Filename = strtotime("now").".jpg";  
    break;
  case 'bmp' :
    $Filename = strtotime("now").".bmp";  
    break;
  case 'mp3' :
    $Filename = strtotime("now").".mp3";  
    break;
  case 'flv' :
    $Filename = strtotime("now").".flv";  
    break;
  case 'swf' :
    $Filename = strtotime("now").".swf";  
    break;
}
//set where you want to store files
//in this example we keep file in folder upload
//$HTTP_POST_FILES['ufile']['name']; = upload file name
//for example upload file name cartoon.gif . $path will be upload/cartoon.gif
$path1= "gallery/images/".case 'bmp' :
    $filename = strtotime("now").".bmp";  
    break;;
//$path2= "gallery/images/".$HTTP_POST_FILES['ufile']['name'][1];
//$path3= "gallery/images/".$HTTP_POST_FILES['ufile']['name'][2];

//copy file to where you want to store file
copy($HTTP_POST_FILES['ufile']['tmp_name'][0], $path1);
//copy($HTTP_POST_FILES['ufile']['tmp_name'][1], $path2);
//copy($HTTP_POST_FILES['ufile']['tmp_name'][2], $path3);

//$HTTP_POST_FILES['ufile']['name'] = file name
//$HTTP_POST_FILES['ufile']['size'] = file size
//$HTTP_POST_FILES['ufile']['type'] = type of file

///////////////////////////////////////////////////////

// Use this code to display the error or success.

$filesize1=$HTTP_POST_FILES['ufile']['size'][0];
//$filesize2=$HTTP_POST_FILES['ufile']['size'][1];
//$filesize3=$HTTP_POST_FILES['ufile']['size'][2];

if($filesize1 != 0)
{
$Width50 = $_POST['txtWidth50'];
$Width100 = $_POST['txtWidth100'];
$Width200 = $_POST['txtWidth200'];
$Width400 = $_POST['txtWidth400'];
$WidthCustom = $_POST['txtWidthCustom'];
$Crop = $_POST['txtCrop'];
echo "We have recieved your files";
}

else {
echo "ERROR.....";
}

//////////////////////////////////////////////

// What files that have a problem? (if found)

if($filesize1==0) {
echo "There're something error in your first file";
echo "<BR />";
}

if($filesize2==0) {
echo "There're something error in your second file";
echo "<BR />";
}

if($filesize3==0) {
echo "There're something error in your third file";
echo "<BR />";
}

?>

 