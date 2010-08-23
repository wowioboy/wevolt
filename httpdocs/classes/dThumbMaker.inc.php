<?
// Version: 2.4 (14/12/2006)
// - Added methods 'flip', 'flipV', 'flipH' and 'rotate90'
// Version: 2.31 (02/09/2006)
// - Added methods 'getWidth', 'getHeight' and 'getIm'
// Version: 2.3  (01/07/2006)
// - Added methods 'addBorder', 'crop' and 'cropCenter'
// Version: 2.21 (06/09/2005)
// - Fixed argument 'opacity' in watermark: If argument is given, the GIF or PNG transparency won't work.
// Version: 2.2 (28/08/2005)
// - Added support to BMP and WBMP images
// - Added argument 'opacity' to addWaterMark
// - Added method makeCaricature
// - If build(NULL) the raw image stream will be output directly.

/***************************************************************
	dThumbMaker 2.4
	
	Easily resample an incoming file
	Release date: 06/09/2005
	Author: Alexandre Tedeschi (d)
	Email:  alexandrebr AT gmail DOT com
	
Methods:
° getVersion
° loadFile - Returns TRUE on success, STRING otherwise
° getWidth, getHeight, getIm
° resizeMaxSize, resizeExactSize, addWaterMark, addBorder, crop, cropCenter, makeCaricature
° flip, flipV, flipH, rotate90
° createBackup, restoreBackup
° build - Returns TRUE on success, FALSE otherwise
***************************************************************/

class dThumbMaker{
	Function getVersion(){
		return "2.4";
	}
	var $info;
	var $backup;
	
	Function dThumbMaker($origFilename=false){
		if($origFilename)
			$this->loadFile($origFilename);
	}
	Function __destruct(){ /** Need to be manually called if PHP<5 **/
		@imagedestroy($this->info['im']);
		@imagedestroy($this->backup['im']);
	}
	Function loadFile($origFilename){
		if(!file_exists($origFilename)){
			return "Imagem não encontrada ou não acessível.";
		}
		$this->info['origFilename'] = $origFilename;
		$this->info['origSize']     = @getimagesize($origFilename);
		switch($this->info['origSize'][2]){
			case 1  /*gif*/ : $this->info['im'] = imagecreatefromgif ($origFilename); break;
			case 2  /*jpg*/ : $this->info['im'] = imagecreatefromjpeg($origFilename); break;
			case 3  /*png*/ : $this->info['im'] = imagecreatefrompng ($origFilename); break;
			case 6  /*bmp*/ : $this->info['im'] = imagecreatefrombmp ($origFilename); break;
			case 15 /*wbmp*/: $this->info['im'] = imagecreatefromwbmp($origFilename); break;
			default:
				return "A imagem precisa estar no formato GIF, JPG, PNG, BMP ou WBMP.";
		}
		$this->backup = false;
		return true;
	}
	
	Function getWidth(){  // Returns image width
		return $this->info['origSize'][0];
	}
	Function getHeight(){ // Returns image height
		return $this->info['origSize'][1];
	}
	Function &getIm(){    // Returns image handler
		return $this->info['im'];
	}
	
	Function resizeMaxSize($maxW, $maxH=false, $constraint=true){
		$origSize = &$this->info['origSize'];
		$im       = &$this->info['im'];
		$resizeByH = 
		$resizeByW = false;
		
		if($origSize[0] > $maxW && $maxW) $resizeByW = true;
		if($origSize[1] > $maxH && $maxH) $resizeByH = true;
		if($resizeByH && $resizeByW){
			$resizeByH = ($origSize[0]/$maxW<$origSize[1]/$maxH);
			$resizeByW = !$resizeByH;
		}
		if    ($resizeByW){
			if($constraint){
				$newW = $maxW;
				$newH = ($origSize[1]*$maxW)/$origSize[0];
			}
			else{
				$newW = $maxW;
				$newH = $origSize[1];
			}
		}
		elseif($resizeByH){
			if($constraint){
				$newW = ($origSize[0]*$maxH)/$origSize[1];
				$newH = $maxH;
			}
			else{
				$newW = $origSize[0];
				$newH = $maxH;
			}
		}
		else{
			$newW = $origSize[0];
			$newH = $origSize[1];
		}
		if($newW != $origSize[0] || $newH != $origSize[1]){
			$imN = imagecreatetruecolor($newW, $newH);
			imagecopyresampled($imN, $im, 0, 0, 0, 0, $newW, $newH, $origSize[0], $origSize[1]);
			imagedestroy($im);
			$this->info['im'] = $imN;
		}
		$this->info['origSize'][0] = $newW;
		$this->info['origSize'][1] = $newH;
		
		return true;
	}
	Function resizeExactSize($W, $H, $constraint=true){
		$im       = &$this->info['im'];
		$origSize = &$this->info['origSize'];
		if($W && $H){
			$newW = $W;
			$newH = $H;
		}
		elseif($W){
			if($constraint){
				$newW = $W;
				$newH = ($origSize[1]*$W)/$origSize[0];
			}
			else{
				$newW = $W;
				$newH = $origSize[1];
			}
		}
		elseif($H){
			if($constraint){
				$newW = ($origSize[0]*$H)/$origSize[1];
				$newH = $H;
			}
			else{
				$newW = $origSize[0];
				$newH = $H;
			}
		}
		if($newW != $origSize[0] || $newH != $origSize[1]){
			$imN = imagecreatetruecolor($newW, $newH);
			imagecopyresampled($imN, $im, 0, 0, 0, 0, $newW, $newH, $origSize[0], $origSize[1]);
			imagedestroy($im);
			$this->info['im'] = $imN;
		}
		$this->info['origSize'][0] = $newW;
		$this->info['origSize'][1] = $newH;
		
		return true;
	}
	Function crop($startX, $startY, $endX=false, $endY=false){
		$im       = &$this->info['im'];
		$origSize = &$this->info['origSize'];
		
		if($endX == false)
			$endX = $origSize[0]-$startX;
		
		if($endY == false)
			$endY = $origSize[1]-$startY;
		
		$width  = $endX-$startX;
		$height = $endY-$startY;
		
		$imN = imagecreatetruecolor($width, $height);
		imagecopy($imN, $im, 0, 0, $startX, $startY, $width, $height);
		imagedestroy($im);
		
		$this->info['im'] = $imN;
		$this->info['origSize'][0] = $width;
		$this->info['origSize'][1] = $height;
		
		return true;
	}
	Function cropCenter($width, $height, $moveX=0, $moveY=0){
		$origSize = &$this->info['origSize'];
		$centerX  = $origSize[0]/2;
		$centerY  = $origSize[1]/2;
		
		$topX = $centerX-$width/2;
		$topY = $centerY-$height/2;
		$endX = $centerX+$width/2;
		$endY = $centerY+$height/2;
		
		return $this->crop($topX+$moveX, $topY+$moveY, $endX+$moveX, $endY+$moveY);
	}
	Function flip($vertical=false){
		$origSize = &$this->info['origSize'];
		$im       = &$this->info['im'];
		
		$imN = imagecreatetruecolor($origSize[0], $origSize[1]);
		if($vertical)
			for($y = 0; $y <$origSize[1]; $y++)
				imagecopy($imN, $im, 0, $y, 0, $origSize[1] - $y - 1, $origSize[0], 1);
		else
			for($x = 0; $x < $origSize[0]; $x++)
				imagecopy($imN, $im, $x, 0, $origSize[0] - $x - 1, 0, 1, $origSize[1]);
		
		imagedestroy($im);
		$this->info['im'] = &$imN;
		return true;
	}
	Function flipV(){
		return $this->flip(true);
	}
	Function flipH(){
		return $this->flip();
	}
	Function rotate90($times=1){
		$origSize = &$this->info['origSize'];
		$im       = &$this->info['im'];
		$times    = ($times%4);
		if($times < 0)
			$times += 4;
		
		if($times == 1){     // 90º
			$newW = $origSize[1];
			$newH = $origSize[0];
			$imN  = imagecreatetruecolor($newW, $newH);
			
			for($x=0; $x<$newH; $x++)
				for($y=0; $y<$newW; $y++)
					imagecopy($imN, $im, $newW-$y-1, $x, $x, $y, 1, 1);
		}
		elseif($times == 2){ // 180º
			$this->flipH();
			$this->flipV();
			return true;
		}
		elseif($times == 3){ // 270º
			$newW = $origSize[1];
			$newH = $origSize[0];
			$imN  = imagecreatetruecolor($newW, $newH);
			
			for($x=0; $x<$newH; $x++)
				for($y=0; $y<$newW; $y++)
					imagecopy($imN, $im, $y, $newH-$x-1, $x, $y, 1, 1);
		}
		else{
			return true;
		}
		
		imagedestroy($im);
		$this->info['im'] = $imN;
		$this->info['origSize'][0] = $newW;
		$this->info['origSize'][1] = $newH;
		
		return true;
	}
	Function addBorder($fileName, $paddingX=0, $paddingY=0){
		$origSize = &$this->info['origSize'];
		$im       = &$this->info['im'];
		
		$origBSize = @getimagesize($fileName);
		switch($origBSize[2]){
			case 1  /*gif*/ : $imB = imagecreatefromgif ($fileName); break;
			case 2  /*jpg*/ : $imB = imagecreatefromjpeg($fileName); break;
			case 3  /*png*/ : $imB = imagecreatefrompng ($fileName); break;
			case 6  /*bmp*/ : $imB = imagecreatefrombmp ($fileName); break;
			case 15 /*wbmp*/: $imB = imagecreatefromwbmp($fileName); break;
			default:
				return "A borda precisa estar no formato GIF, JPG, PNG, BMP ou WBMP.";
		}
		imagecopyresampled($im, $imB, $paddingX, $paddingY, 0, 0, $origSize[0]-$paddingX, $origSize[1]-$paddingY, $origBSize[0], $origBSize[1]);
		imagedestroy($imB);
		return true;
	}
	Function addWaterMark($fileName, $posX=0, $posY=0, $invertido=true, $opacity=100){
		$origSize = &$this->info['origSize'];
		$im       = &$this->info['im'];
		$origWSize = @getimagesize($fileName);
		switch($origWSize[2]){
			case 1  /*gif*/ : $imW = imagecreatefromgif ($fileName); break;
			case 2  /*jpg*/ : $imW = imagecreatefromjpeg($fileName); break;
			case 3  /*png*/ : $imW = imagecreatefrompng ($fileName); break;
			case 6  /*bmp*/ : $imW = imagecreatefrombmp ($fileName); break;
			case 15 /*wbmp*/: $imW = imagecreatefromwbmp($fileName); break;
			default:
				return "A marca d'água precisa estar no formato GIF, JPG, PNG, BMP ou WBMP.";
		}
		if($invertido===true || (is_array($invertido)&&$invertido[0]))
			$posX = $origSize[0]-$origWSize[0]-$posX;
		if($invertido===true || (is_array($invertido)&&$invertido[1]))
			$posY = $origSize[1]-$origWSize[1]-$posY;
		
		($opacity != 100)?
			imagecopymerge($im, $imW, $posX, $posY, 0, 0, $origWSize[0], $origWSize[1], $opacity):
			imagecopy($im, $imW, $posX, $posY, 0, 0, $origWSize[0], $origWSize[1]);
		
		imagedestroy($imW);
		return true;
	}
	Function makeCaricature($colors=32, $opacity=70){
		$newim = imagecreatetruecolor($this->info['origSize'][0], $this->info['origSize'][1]);
		imagecopy($newim, $this->info['im'], 0, 0, 0, 0, $this->info['origSize'][0], $this->info['origSize'][1]);
		imagefilter($newim, IMG_FILTER_SMOOTH, 0);
		imagefilter($newim, IMG_FILTER_GAUSSIAN_BLUR);
		imagetruecolortopalette($newim, false, $colors);
		imagecopymerge($this->info['im'], $newim, 0, 0, 0, 0, $this->info['origSize'][0], $this->info['origSize'][1], $opacity);
		imagedestroy($newim);
		
		return true;
	}
	
	Function createBackup(){
		if($this->backup)
			imagedestroy($this->backup['im']);
		$this->backup = $this->info;
		$this->backup['im'] = imagecreatetruecolor($this->info['origSize'][0], $this->info['origSize'][1]);
		imagecopy($this->backup['im'], $this->info['im'], 0, 0, 0, 0, $this->info['origSize'][0], $this->info['origSize'][1]);
		return true;
	}
	Function restoreBackup(){
		imagedestroy($this->info['im']);
		$this->info = $this->backup;
		$this->info['im'] = imagecreatetruecolor($this->info['origSize'][0], $this->info['origSize'][1]);
		imagecopy($this->info['im'], $this->backup['im'], 0, 0, 0, 0, $this->info['origSize'][0], $this->info['origSize'][1]);
		return true;
	}
	
	Function build($output_filename=false, $output_as=false, $quality=80){
		$origSize = &$this->info['origSize'];
		$im       = &$this->info['im'];
		
		if($output_filename===false){
			// Output filename wasn't found, let's overwrite original file.
			$output_filename = $this->info['origFilename'];
		}
		
		// Try to auto-determine output format
		if(!$output_as)
			$output_as = ereg_replace(".*\.(.+)", "\\1", $output_filename);
		
		if    ($output_as == 'gif')  return imagegif ($im, $output_filename);
		elseif($output_as == 'png')  return imagepng ($im, $output_filename);
		elseif($output_as == 'wbmp') return imagewbmp($im, $output_filename);
		else /* default: jpeg     */ return imagejpeg($im, $output_filename, $quality);
	}
}

if(!function_exists('imagecreatefrombmp')){
	/*********************************************/
	/*    --- Adquirida no Manual do PHP ---     */
	/* Fonction: ImageCreateFromBMP              */
	/* Author:   DHKold                          */
	/* Contact:  admin@dhkold.com                */
	/* Date:     The 15th of June 2005           */
	/* Version:  2.0B                            */
	/*********************************************/
	function imagecreatefrombmp($filename){
		if(!($f1 = fopen($filename, "rb")))
			return false;
		
		//1 : Chargement des entêtes FICHIER
		$FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
		if($FILE['file_type'] != 19778)
			return false;
		
		//2 : Chargement des entêtes BMP
		$BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
		'/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
		'/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
		$BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
		if($BMP['size_bitmap'] == 0)
			$BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
		
		$BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
		$BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
		$BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
		$BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
		$BMP['decal'] = 4-(4*$BMP['decal']);
		if ($BMP['decal'] == 4)
			$BMP['decal'] = 0;
		
		//3 : Chargement des couleurs de la palette
		$PALETTE = array();
		if ($BMP['colors'] < 16777216)
			$PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
		
		//4 : Création de l'image
		$IMG = fread($f1,$BMP['size_bitmap']);
		$VIDE = chr(0);
		
		$res = imagecreatetruecolor($BMP['width'],$BMP['height']);
		$P = 0;
		$Y = $BMP['height']-1;
		while ($Y >= 0){
			$X=0;
			while ($X < $BMP['width']){
				if ($BMP['bits_per_pixel'] == 24)
					$COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
				elseif ($BMP['bits_per_pixel'] == 16){ 
					$COLOR = unpack("n",substr($IMG,$P,2));
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				}
				elseif ($BMP['bits_per_pixel'] == 8){ 
					$COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				}
				elseif ($BMP['bits_per_pixel'] == 4){
					$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
					if (($P*2)%2 == 0)
						$COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				}
				elseif ($BMP['bits_per_pixel'] == 1){
					$COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
						if (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
					elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
					elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
					elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
					elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8 )>>3;
					elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4 )>>2;
					elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2 )>>1;
					elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1 );
					$COLOR[1] = $PALETTE[$COLOR[1]+1];
				}
				else
					return false;
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
}





