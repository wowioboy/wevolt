<?php
  
  function CreateGCD($ID, $ContentType, $FileName, $FileSize, $URL)
  {
    if ($ContentType == 'image/jpg')
      $ContentType = 'image/jpeg';
      
    $myFile = './gcd/' . $ID . '.gcd';
    $fh = fopen($myFile, 'w+') or die("can't open file");
    fwrite($fh, "Content-Type: $ContentType\n");
    fwrite($fh, "Content-Name: $FileName\n");
    fwrite($fh, "Content-Version: 1.0\n");
    fwrite($fh, "Content-Vendor: PanelFlow.Com\n");
    fwrite($fh, "Content-URL: $URL\n");
    fwrite($fh, "Content-Size: $FileSize\n\n");
    
    fclose($fh);
    
    chmod($myFile, 0666 );
    
    return $ID . '.gcd';
  }
?>
