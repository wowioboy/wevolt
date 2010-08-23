<?php 
include '../includes/db.class.php';
$Action = $_POST['action'];
$Image = $_POST['filename'];
$Sever = $_POST['server'];
$ComicID = $_POST['id'];
$Title = mysql_real_escape_string($_POST['title']);
$Type = $_POST['type'];
$AdminID = $_POST['adminid'];
$ItemID = $_POST['item'];

if(($Type == 'wallpaper') && ($Action == 'add')) {
$query = "SELECT userid from comics where comiccrypt='$ComicID'"; 
 $AdminUser = $db->queryUniqueValue($query);
 if($AdminID == $AdminUser) {
$arrayext = explode(".",$Image);
$ext = $arrayext[1];
$randName = substr(md5(rand() * time()),0,10);
$gif = file_get_contents('http://'.$Sever."/".$Image) or die('Could not grab the file');
$fp  = fopen('../mobile/wallpapers/'.$randName.".".$ext, 'w+') or die('Could not create the file');
fputs($fp, $gif) or die('Could not write to the file');
fclose($fp);
unset($gif);
$NewFilename = '../mobile/wallpapers/'.$randName.".".$ext;
$mobilethumb = '../mobile/wallpapers/'.$randName."_tb.".$ext;
$FinalWallpaper = 'mobile/wallpapers/'.$randName.".".$ext;
$FinalThumb = 'mobile/wallpapers/'.$randName."_tb.".$ext; 
$convertString = "convert $NewFilename -resize 100 $mobilethumb";
exec($convertString);
$db= new DB();

 $query = "INSERT into mobile_content (Title, ComicID, Image, Thumb) values ('$Title', '$ComicID', '$FinalWallpaper','$FinalThumb')";
 $db->query($query);
 $query = "SELECT ID from mobile_content where Image='$FinalWallpaper'";
 $ItemID = $db->queryUniqueValue($query);
  $Encryptid = substr(md5($ItemID), 0, 8).dechex($ItemID);
   $query = "UPDATE mobile_content set EncryptID ='$Encryptid' where ID='$ItemID'";
 $db->query($query);


$db->close();
 echo $Encryptid;
}
}
if(($Type == 'wallpaper') && ($Action == 'edit')) {
$arrayext = explode(".",$Image);
$ext = $arrayext[1];
$randName = substr(md5(rand() * time()),0,10);
$gif = file_get_contents('http://'.$Sever."/".$Image) or die('Could not grab the file');
$fp  = fopen('../mobile/wallpapers/'.$randName.".".$ext, 'w+') or die('Could not create the file');
fputs($fp, $gif) or die('Could not write to the file');
fclose($fp);
unset($gif);
$NewFilename = '../mobile/wallpapers/'.$randName.".".$ext;
$mobilethumb = '../mobile/wallpapers/'.$randName."_tb.".$ext;
$FinalWallpaper = 'mobile/wallpapers/'.$randName.".".$ext;
$FinalThumb = 'mobile/wallpapers/'.$randName."_tb.".$ext; 
$convertString = "convert $NewFilename -resize 100 $mobilethumb";
exec($convertString);
$db= new DB();
 $query = "UPDATE mobile_content set Title='$Title', Image='$FinalWallpaper', Thumb='$FinalThumb' where EncryptID='$ItemID'"; 
 $db->query($query);
 $db->close();
}
if(($Type == 'wallpaper') && ($Action == 'update')) {
$db= new DB();
 $query = "SELECT userid from comics where comiccrypt='$ComicID'"; 
 $AdminUser = $db->queryUniqueValue($query);
 if($AdminID == $AdminUser) {
 $query = "UPDATE mobile_content set Title='$Title' where EncryptID='$ItemID'"; 
 $db->query($query);
 }
 $db->close();
}

if(($Type == 'wallpaper') && ($Action == 'delete')) {
$db= new DB();
 $query = "SELECT userid from comics where comiccrypt='$ComicID'"; 
 $AdminUser = $db->queryUniqueValue($query);
 if($AdminID == $AdminUser) {
  $query = "DELETE from mobile_content where EncryptID='$ItemID'"; 
 	$db->query($query);
 }

 $db->close();
}
?>


