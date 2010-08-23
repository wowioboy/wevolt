<? //include_once("content.php") ?>
<? include_once("includes/wapprofile.php"); ?>
<?php 
  function GenerateImage($WAPProfile, $ID, $StreamIt)
  {
    if ($StreamIt)
    {
      header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0");
      header('Pragma: no-cache');
      header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
      header("Expires: " . gmdate("D, d M Y H:i:s", mktime(date("H") + 1,
                                                      $date["i"],
                                                      $date["s"],
                                                      $date["m"],
                                                      $date["d"],
                                                      $date["y"])) . " GMT");
    }
    $debug = false;
  
    $WallPaperWidth = $WAPProfile->ResolutionWidth;
    $WallPaperHeight = $WAPProfile->ResolutionHeight;
    $WallPaperType = $WAPProfile->ImageType;
    
    $WallPaperType = 'jpg';
        
    //$Content = new Content();
    //$FileName = $Content->GetFile($ID);
    $ItemDB = new DB();
	$query = "SELECT Image from mobile_content where EncryptID='$ID'";
	$Filename = "http://www.panelflow.com/".$ItemDB->queryUniqueValue($query);
	$ItemDB->close();
	
    if ($StreamIt)
    {
      if (!$debug)
      {
        switch ($WallPaperType)
        {
          case 'gif':
            header("Content-type: image/gif");
            break;
          case 'jpeg':
          case 'jpg':
            header("Content-type: image/jpeg");
            break;
          case 'png':
            header("Content-type: image/png");
            break;  
          default: 
            header("Content-type: image/bmp");
            break;
        } 
      }
    }
    header("Content-Length: ".filesize($FileName));
   // $ext = $Content->findexts(basename($FileName));
  	$ext = 'jpg';
    // Get new dimensions
    list($width_orig, $height_orig) = getimagesize($FileName);
    
    $ratio_orig = $width_orig/$height_orig;
    
    if ($WallPaperWidth/$WallPaperHeight > $ratio_orig) {
       $WallPaperWidth = $WallPaperHeight*$ratio_orig;
    } else {
       $WallPaperHeight = $WallPaperWidth/$ratio_orig;
    }
    
    // Resample
    $image_p = imagecreatetruecolor($WallPaperWidth, $WallPaperHeight);
    $image = imagecreatefromjpeg($FileName);
    imagecopyresampled($image_p, $image, 0, 0, 0, 0, $WallPaperWidth, $WallPaperHeight, $width_orig, $height_orig);
    
   
    if ($debug)
      echo $StreamIt . ' - ' . $WallPaperWidth . ' - ' .  $WallPaperHeight . ' - ' .  $WallPaperType . ' - ' . $width_orig  . ' - ' .  $height_orig;
    
    if (!$debug)
    {
      // Output 
      if ($StreamIt)
      {
        if($WallPaperType == 'jpg') imagejpeg($image_p, null, 100);
        if($WallPaperType == 'gif') imagegif($image_p); 
        if($WallPaperType == 'png') imagepng($image_p);
        if($WallPaperType == 'wbmp') imagewbmp($image_p);  
      }
      else
      {
        if($WallPaperType == 'jpg') imagejpeg($image_p, "./processed/$ID.jpg", 100);
        if($WallPaperType == 'gif') imagegif($image_p, "./processed/$ID.gif");
        if($WallPaperType == 'png') imagepng($image_p, "./processed/$ID.png");
        if($WallPaperType == 'wbmp') imagepwbmp($image_p, "./processed/$ID.wbmp");
      }
      imagedestroy($image_p);
      imagedestroy($image); 
    }
    
    $FileName = '';
    if (!$StreamIt)
    {
      if($WallPaperType == 'jpg') 
        $FileName = "$ID.jpg";
      if($WallPaperType == 'gif') 
        $FileName = "$ID.gif";
    }
    
    return $FileName;
  }
  
  function imagecreatefrombmp($filename)
  {
   //Ouverture du fichier en mode binaire
     if (! $f1 = fopen($filename,"rb")) return FALSE;
  
   //1 : Chargement des ent?tes FICHIER
     $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
     if ($FILE['file_type'] != 19778) return FALSE;
  
   //2 : Chargement des ent?tes BMP
     $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
                   '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
                   '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
     $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
     if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
     $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
     $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
     $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
     $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
     $BMP['decal'] = 4-(4*$BMP['decal']);
     if ($BMP['decal'] == 4) $BMP['decal'] = 0;
  
   //3 : Chargement des couleurs de la palette
     $PALETTE = array();
     if ($BMP['colors'] < 16777216)
     {
      $PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
     }
  
   //4 : Cr?ation de l'image
     $IMG = fread($f1,$BMP['size_bitmap']);
     $VIDE = chr(0);
  
     $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
     $P = 0;
     $Y = $BMP['height']-1;
     while ($Y >= 0)
     {
      $X=0;
      while ($X < $BMP['width'])
      {
       if ($BMP['bits_per_pixel'] == 24)
          $COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
       elseif ($BMP['bits_per_pixel'] == 16)
       {  
          $COLOR = unpack("n",substr($IMG,$P,2));
          $COLOR[1] = $PALETTE[$COLOR[1]+1];
       }
       elseif ($BMP['bits_per_pixel'] == 8)
       {  
          $COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
          $COLOR[1] = $PALETTE[$COLOR[1]+1];
       }
       elseif ($BMP['bits_per_pixel'] == 4)
       {
          $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
          if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
          $COLOR[1] = $PALETTE[$COLOR[1]+1];
       }
       elseif ($BMP['bits_per_pixel'] == 1)
       {
          $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
          if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
          elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
          elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
          elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
          elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
          elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
          elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
          elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
          $COLOR[1] = $PALETTE[$COLOR[1]+1];
       }
       else
          return FALSE;
       imagesetpixel($res,$X,$Y,$COLOR[1]);
       $X++;
       $P += $BMP['bytes_per_pixel'];
      }
      $Y--;
      $P+=$BMP['decal'];
     }
  
   //Fermeture du fichier
     fclose($f1);
  
   return $res;
  }
?>
