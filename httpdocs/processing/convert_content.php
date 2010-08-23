<?  function CreateConversion($UserID, $ContentType, $File, $RingtoneStart, $RingtoneDuration)
    {
      $FileType = mime_content_type($File);
      $BaseFileName = basename($File);
      $Filename_Minus_Ext= substr($BaseFileName, 0, strrpos($BaseFileName, '.'));
                
      switch($ContentType)
      { 
        case 1:
          $MoveFileDir = $this->MAIN_DIR . 'user_files/' . $UserID . "/jpg";
          
          if (!file_exists($MoveFileDir))
          {
            mkdir($MoveFileDir, 0777 );
          }
          
          $size = GetImageSize($File);
          $width = $size[0];
            
          if (($FileType == "img/jpg") || ($FileType == "img/jpeg") || ($FileType == "image/jpg") || ($FileType == "image/jpeg"))
          {
            if (($width == 650) && ($height == 650)) 
            {
              copy ($File, $MoveFileDir . '/' . $Filename_Minus_Ext . '.jpg'); 
              chmod($MoveFileDir . '/' . $Filename_Minus_Ext . '.jpg', 0666);
            }
            else
            {
              $convertString = "convert " . $File . ' -resize 650x650 ' . $MoveFileDir . '/' . $Filename_Minus_Ext . '.jpg';  
              exec($convertString);
            }   
          }
          else
          {
            //echo $BaseFileName . ' - ' . $FileType . '<br />';
            if (($FileType == "img/gif") || ($FileType == "image/gif"))
            {
              
              $convertString = 'convert ' . $File  . '[0] -resize 650x650 ' . $MoveFileDir . '/' . $Filename_Minus_Ext . '.jpg';
              //echo $convertString . '<br />';  
              exec($convertString);
            }
            else
            {
              $convertString = 'convert ' . $File  . ' -resize 650x650 ' . $MoveFileDir . '/' . $Filename_Minus_Ext . '.jpg';
              //echo $convertString . '<br />';  
              exec($convertString);
            }
            chmod($MoveFileDir . '/' . $Filename_Minus_Ext . '.jpg', 0666); 
          }
          break;
         case 2:
          $MoveFileDir = $this->MAIN_DIR . 'user_files/' . $UserID . "/flv";
        
          if (!file_exists($MoveFileDir))
          {
            mkdir($MoveFileDir, 0777 );
          }
          
          if ($FileType == "video/x-flv")
          {
            copy ($FileName, $MoveFileDir . '/' . $Filename_Minus_Ext . '.flv'); 
            chmod($MoveFileDir . '/' . $Filename_Minus_Ext . '.flv', 0666);   
          }
          else
          {
            if (file_exists($MoveFileDir . '/' . $Filename_Minus_Ext . '.flv'))
            {
              unlink($MoveFileDir . '/' . $Filename_Minus_Ext . '.flv');
            }
          
            $convertString = '/usr/bin/ffmpeg -i ' . $File . ' ' . $MoveFileDir . '/' . $Filename_Minus_Ext . '.flv';  
			// ****  need to fix the duration ***
            //echo $convertString . '<br />';
            exec($convertString);
            
            chmod($MoveFileDir . '/' . $Filename_Minus_Ext . '.flv', 0666);   
          }
          
          $MoveFileDir = $this->MAIN_DIR . 'user_files/' . $UserID . "/3gp";
        
          if (!file_exists($MoveFileDir))
          {
            mkdir($MoveFileDir, 0777 );
          }
          
          if ($FileType == "video/3gpp")
          {
            copy ($FileName, $MoveFileDir . '/' . $Filename_Minus_Ext . '.3gp'); 
            chmod($MoveFileDir . '/' . $Filename_Minus_Ext . '.3gp', 0666);   
          }
          else
          {
            if (file_exists($MoveFileDir . '/' . $Filename_Minus_Ext . '.3gp'))
            {
              unlink($MoveFileDir . '/' . $Filename_Minus_Ext . '.3gp');
            }
            //$convertString = '/usr/bin/ffmpeg -i ' . $File . ' ' . $MoveFileDir . '/' . $Filename_Minus_Ext . '.3gp';
            $convertString = '/usr/bin/ffmpeg -i ' . $File . ' -ab 8 -ac 1 -ar 8000 -vcodec h263 -s qcif -r 10 ' . $MoveFileDir . '/' . $Filename_Minus_Ext . '.3gp';  
			// need to fix start and duration ******
            //echo $convertString . '<br />';
            exec($convertString);
            
            chmod($MoveFileDir . '/' . $Filename_Minus_Ext . '.3gp', 0666);   
          }
          break;
         case 3:
         case 4:
         case 5:
          $MoveFileDir = $this->MAIN_DIR . 'user_files/' . $UserID . "/mp3";
        
          if (!file_exists($MoveFileDir))
          {
            mkdir($MoveFileDir, 0777 );
          }
          
          if ($FileType == "audio/mp3")
          {
            copy ($FileName, $MoveFileDir . '/' . $Filename_Minus_Ext . '.mp3'); 
            chmod($MoveFileDir . '/' . $Filename_Minus_Ext . '.mp3', 0666);   
          }
          else
          {
            if (file_exists($MoveFileDir . '/' . $Filename_Minus_Ext . '.mp3'))
            {
              unlink($MoveFileDir . '/' . $Filename_Minus_Ext . '.mp3');
            }
			if ($RingtoneDuration == '0')
	            $convertString = '/usr/bin/ffmpeg -i ' . $File . ' ' . $MoveFileDir . '/' . $Filename_Minus_Ext . '.mp3';  
			else
				$convertString = "/usr/bin/ffmpeg -i " . $File . ' -ab 32k -ss ' . $RingtoneStart . ' -t ' . $RingtoneDuration . ' ' . $MoveFileDir . '/' . $Filename_Minus_Ext . '.mp3'; 
            //echo $convertString . '<br />';
            exec($convertString);
            
            chmod($MoveFileDir . '/' . $Filename_Minus_Ext . '.mp3', 0666);   
          }
          break;
      }
    }
    
    public function CreateVideoThumbnail($videofilename)
    {
      //define('FFMPEG_BINARY', 'C:\ffmpeg\ffmpeg');
      define('FFMPEG_BINARY', '/usr/bin/ffmpeg');
      define('OS_WINDOWS', false);
      
      require_once $_SERVER['DOCUMENT_ROOT'].'/classes/ffmpeg.php';
          	
    	// 	start ffmpeg class
    	$ffmpeg = new ffmpeg();
    	
      // 	set ffmpeg class to run silently
    	$ffmpeg->on_error_die = FALSE;
    	
    	// 		get the filename parts
  		$filename = basename($videofilename);
  		$filename_minus_ext = substr($filename, 0, strrpos($filename, '.'));
  		
  // 		set the input file
      $ok = $ffmpeg->setInputFile($this->TempDirectory.$videofilename);
  // 		check the return value in-case of error
  		if(!$ok)
  		{
  // 			if there was an error then get it 
  			//echo '<b>'. print_r($ffmpeg->getErrors())."</b><br />\r\n";
  			$ffmpeg->reset();
  		}
  		
  // 		set the output dimensions
   		$ffmpeg->setVideoOutputDimensions(134, 100);
  		
  // 		extract a thumbnail from eight seconds into the video
  		$ffmpeg->extractFrame('00:00:08');
  		  		  
  // 		set the output details
  		$ok = $ffmpeg->setOutput($this->TempThumbnailDirectory,  $filename_minus_ext.'-%d.jpg', TRUE);
  // 		check the return value in-case of error
  		if(!$ok)
  		{
  // 			if there was an error then get it
       	$ffmpeg->reset();
  		}
  		
  // 		execute the ffmpeg command
  		$result = $ffmpeg->execute(TRUE);
  		
  // 		get the last command given
   		$command = $ffmpeg->getLastCommand();
   		
   		  // 		check the return value in-case of error
  		if(!$result)
  		{
  // 			if there was an error then get it 
  			//echo '<b>'. print_r($ffmpeg->getLastError()) . "</b><br />\r\n";
  		}
  		
  	 	//	reset 
  		$ffmpeg->reset();
		
		  $ThumbNail = $filename_minus_ext.'-1.jpg';
		 
		  return $ThumbNail;
    }
?>