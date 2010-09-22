<?php 
session_start();
include_once($_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php');
header('Content-Type: text/javascript' );
header('Pragma: no-cache');

$DB = new DB();
$DB2 = new DB();
$NOW = date('Y-m-d h:i:s');
$query = "SELECT * from comic_pages where InPortfolio=1";
  $DB->query($query);

while ($line = $DB->fetchNextObject()) {
	
	$ImageNameArray = explode('images/',$line->ThumbLg);
	$CreatedDate = date('Y-m-d H:i:s');
	$GalleryImage = $ImageNameArray[0].'images/pages/'.$line->Image;
	
	if ($line->ProImage != '')
		$GalleryPro = $line->ProImage;
	else 
		$GalleryPro = $GalleryImage;
	
	$query = "INSERT into pf_gallery_content (".
											  	"UserID,". 
												"Title,".  
												"Description,".  
											
												"Filename,".  
												"ThumbLg,". 
												"ThumbMd,". 
												"ThumbSm,".  
												"GalleryImage,".  
												"GalleryImagePro,". 
												"GalleryID,". 
												"CreatedDate,". 
												"InPortfolio,". 
												"PrivacySetting". 
											  ")".  
											  "values". 
											  "(". 
											  	"'d67d8ab427',". 
												"'".mysql_real_escape_string($line->Title)."',". 
												"'".mysql_real_escape_string($line->Comment)."',". 
												"'".mysql_real_escape_string($line->Filename)."',". 
												"'".mysql_real_escape_string($line->ThumbLg)."',". 
												"'".mysql_real_escape_string($line->ThumbMd)."',". 
												"'".mysql_real_escape_string($line->ThumbSm)."',". 
												"'".mysql_real_escape_string($GalleryImage)."',". 
												"'".mysql_real_escape_string($GalleryPro)."',". 
												"'b53b3a3d6ab90ce37',". 
												"'$CreatedDate',". 
												"1,". 
												"'public'". 
											  ")";
											  $DB2->execute($query); 
											  
											 print $query."<br><br>";
									
											$query ="SELECT ID from pf_gallery_content where CreatedDate='$CreatedDate' and Title='".mysql_real_escape_string($line->Title)."'";		
											$NewID = $DB2->queryUniqueValue($query);
											print $query."<br><br>";
											$Encryptid = substr(md5($NewID), 0, 15).dechex($NewID);
											$IdClear = 0;
											$Inc = 5;
											while ($IdClear == 0) {
												$query = "SELECT count(*) from pf_gallery_content where EncryptID='$Encryptid'";
												$Found = $DB2->queryUniqueValue($query);
													print $query."<br/><br/>";
												$output .= $query.'<br/>';
												if ($Found == 1) {
													$Encryptid = substr(md5(($NewID+$Inc)), 0, 15).dechex($NewID+$Inc);
												} else {
													$query = "UPDATE pf_gallery_content SET EncryptID='$Encryptid' WHERE ID='$NewID'";
													$DB2->execute($query);
														print $query.'<br/><br/>';
													$output .= $query.'<br/>';
													$IdClear = 1;
												}
												$Inc++;
											}
											
	
}
