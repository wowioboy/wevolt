<?php
/**
 * phMagick - Image manipulation with Image Magick
 *
 * @version		0.2
 * @author		Nuno Costa - sven@francodacosta.com
 * @copyright	Copyright (c) 2007
 * @license		GPL v3 - http://www.gnu.org/licenses/gpl-3.0.html
 * @link		http://www.francodacosta.com/imagemagick/phmagick
 * @since		Version 0.1
 */

/*
	20081010 - ontheFly() :: removed dependency of CONFIG class
			   (http://www.francodacosta.com/php/you-are-here-how-hard-can-it-be)
			   by adding setPhysicalPath() and setWebserverPath()
			 - bug:: fixed setImageQuality() not returning $this
			 - bug:: removed getHistory() extra return :$
*/


class phMagick{
    private $imageMagickPath = '';
    private $imageQuality = 80 ;
    
    private $originalFile = '';
    private $sourceFile = '';
    private $destinationFile = '';
    private $lastOutput = array();
    private $history = array();
    
    private $physicalPath = '';
    private $webPath = '';
    
/*********************************************
*		Private stuff
**********************************************/
	private function getBinary($binName){
        return $this->getImageMagickPath()  . $binName ;
    }
    
    private function execute($cmd){
        $ret = 100 ;
        $out = array();
    	exec($cmd,$out,$ret);
    	$this->setOutput( $out );
    	return $ret ;
    }
    
    private function setHistory($path){
    	$this->history[] = $path ;
    }
    
    private function clearHistory(){
    	unset ($this->history);
    	$this->history = array();
    }
    
    
/*********************************************
*		Get and Set
**********************************************/
     function setImageQuality($value){
        $this->imageQuality = intval($value);
        return $this;
    }
    
     function getImageQuality(){
        return $this->imageQuality;
    }
    
    //-----------------
     function setImageMagickPath ($path){
        
        if($path != '')
            if ( strpos($path, '/') < strlen($path))
                $path .= '/';
        
        $this->imageMagickPath = str_replace(' ','\ ',$path) ;
    }
    
     function getImageMagickPath (){
        return $this->imageMagickPath;
    }
    
    //-----------------
     function setSource ($path){
        $this->sourceFile = str_replace(' ','\ ',$path) ;
    }
    
     function getSource (){
        return $this->sourceFile ;
    }
    
    //-----------------
     function setDestination ($path){
        $path = str_replace(' ','\ ',$path) ;
        $this->destinationFile = $path ;
        return $this;
    }
    
     function getDestination (){
    	if( ($this->destinationFile == '')){
    		$source = $this->getSource() ;
    		$ext = end (explode('.', $source)) ;
    		$this->destinationFile = dirname($source) . '/' . md5(microtime()) . '.' . $ext;
    	}
        return $this->destinationFile ;
    }
    
    //-----------------
    /**
     * Set the site root's physical bath ex: /home/francodacosta/phMagick
     * @param $path
     */
    function setPhysicalPath($path){
        $this->physicalPath = $path ;
        return $this ;
    }
    /**
     * Set the site root's url ex: http://francodacosta.com/phMagick
     * @param $path
     */
    function setWebserverPath($url){
        $this->webPath = $url ;
    }
    
    //-----------------
    private function setOutput($out){
        $this->lastOutput = $out ;
    }
    
     function getOutput(){
        return $this->lastOutput;
    }
    
/*********************************************
*		The goodies ;)
**********************************************/
    
    /**
	 *  @param String: The full path for the image
	 *  @param String: The full path for the newlly created image
	 */
     function __construct($sourceFile='', $destinationFile=''){
		$this->originalFile = $sourceFile;
		$this->sourceFile = $sourceFile ;
		$this->destinationFile = $destinationFile;
		
    }
    
    /**
     *	Resizes an image
     *
	 *  @param Mixed: The width of the image or '' to rezise porporcionallly to the height
	 *  @param Mixed: The height of the image or '' to rezise porporcionallly to the width
	 *  @param boolean: False: resizes the image to the exact porportions (aspect ration not preserved). True: preserves aspect ratio, only resises if image is bigger than specified measures
	 */
     function resize( $width, $height, $exactDimentions = false){
    	
        $modifier = $exactDimentions ? '!' : '>';
        
        //if $width or $height == 0 then we want to resize to fit one measure
		//if any of them is sent as 0 resize will fail because we are trying to resize to 0 px
		$width  = $width  == 0 ? '' : $width ;
		$height = $height == 0 ? '' : $height ;
		
        $cmd = $this->getBinary('convert');
        $cmd .=  ' -scale "'. $width .'x'. $height . $modifier ;
        //$cmd .=  ' -resize "'. $width .'x'. $height . $modifier ;
        $cmd .= '" -quality '. $this->getImageQuality() ;
        $cmd .= ' ' . $this->getSource() .' '. $this->getDestination();
    	
        
    	$this->execute($cmd);
    	$this->setSource($this->getDestination());
    	$this->setHistory($this->getDestination());
    	return  $this ;
    }
    
    
    /**
     * Creates a thumbnail of an image, if it doesn't exits
     *
     * Requires Config.php to convert path/url see http://www.francodacosta.com/php/you-are-here-how-hard-can-it-be
     *
     * @param String $imageUrl - The image Url
     * @param Mixed $width - String / Integer
     * @param Mixed $height - String / Integer
     * @param boolean: False: resizes the image to the exact porportions (aspect ration not preserved). True: preserves aspect ratio, only resises if image is bigger than specified measures
     *
     * @return String - the thumbnail URL
     */
    function onTheFly($imageUrl, $width, $height, $exactDimentions = false){

		
		//convert web path to physical
		$basePath = str_replace($this->webPath,$this->physicalPath, dirname($imageUrl) );
		$sourceFile = $basePath .'/'. basename($imageUrl); ;

		//naming the new thumbnail
		$thumbnailFile = $basePath . '/'.$width . '_' . $height . '_' . basename($imageUrl) ;
		
		$this->setSource($sourceFile);
		$this->setDestination($thumbnailFile);
		
		if (! file_exists($thumbnailFile)){
			$this->resize($width, $height, $exactDimentions);
		}
		
		if (! file_exists($thumbnailFile)){
		    //if there was an error, just use original file
			$thumbnailFile = $sourceFile;
		}
		
		//returning the thumbnail url
		return str_replace($this->physicalPath, $this->webPath, $thumbnailFile );
		
	}
	
	 function getDimentions(){
	    $cmd  = $this->getBinary('identify');
	    $cmd .= ' -format "%w,%h" ' . $this->getSource();
	    
	    $ret = $this->execute($cmd);
	    
    	if($ret == 0){
    		$out = $this->getOutput();
    		return explode(',', $out[0]);
    	}
	   return false ;
	    
	}
	
	/**
	 *
	 *	Darkens an image, defualt: 50%
	 *
	 * @param $imageFile String - Physical path of the umage file
	 * @param $newFile String - Physical path of the generated image
	 * @param $alphaValue Integer - 100: back , 0: original color (no change)
	 * @return boolean - True: success
	 */
	function darken($alphaValue = 50){
	    $percent = 100 - (int) $alphaValue;
	    
	    //get original file dimentions
	    
	    list ($width, $height) = $this->getDimentions();
	    
	    $cmd = $this->getBinary('composite');
        $cmd .=  ' -blend  ' . $percent . ' ';
        $cmd .= $this->getSource();
        $cmd .= ' -size '. $width .'x'. $height.' xc:black ';
        $cmd .= '-matte ' . $this->getDestination() ;
        
    	$this->execute($cmd);
    	$this->setSource($this->getDestination());
    	$this->setHistory($this->getDestination());
    	return  $this ;
	}
	
	/**
	 *
	 *	Brightens an image, defualt: 50%
	 *
	 * @param $imageFile String - Physical path of the umage file
	 * @param $newFile String - Physical path of the generated image
	 * @param $alphaValue Integer - 100: white , 0: original color (no change)
	 * @return boolean - True: success
	 */
	function brighten($alphaValue = 50){
	    
	    $percent = 100 - (int) $alphaValue;
	    
	    //get original file dimentions
	    
	    list ($width, $height) = $this->getDimentions();
	    
	    $cmd = $this->getBinary('composite');
        $cmd .=  ' -blend  ' . $percent . ' ';
        $cmd .= $this->getSource();
        $cmd .= ' -size '. $width .'x'. $height.' xc:white ';
        $cmd .= '-matte ' . $this->getDestination() ;
        
        $this->execute($cmd);
        $this->setSource($this->getDestination());
        $this->setHistory($this->getDestination());
    	return  $this ;
	}
	
	
	/**
	 *
	 * Joins severall imagens in one tab strip
	 *
	 * @param $paths Array of Strings - the paths of the images to join
	 */
	function tabStrip( Array $paths = null){
		if( is_null($paths) ) {
			$paths = $this->getHistory(phMagickHistory::returnArray);
		}
	    $cmd  = $this->getBinary('montage');
	    $cmd .= ' -geometry x+0+0 -tile x1 ';
	    $cmd .= implode(' ', $paths);
	    $cmd .= ' ' . $this->getDestination() ;
	    
	    $this->execute($cmd);
	    $this->setSource($this->getDestination());
	    $this->setHistory($this->getDestination());
    	return  $this ;
	}

	/**
	 * Draws an image with the submited string, usefull for water marks
	 *
	 * @param $text String - the text to draw an image from
	 * @param $format phMagickTextObject - the text configuration
	 */
	function fromString($text, phMagickTextObject $format){
		
		$cmd  = $this->getBinary('convert');

		if ($format->background !== false)
			$cmd .= ' -background "' . $format->background . '"';
			
		if ($format->color !== false)
			$cmd .= ' -fill "' . $format->color . '"' ;
			
		if ($format->font !== false)
			$cmd .= ' -font ' . $format->font ;
		
		if ($format->fontSize !== false)
			$cmd .= ' -pointsize ' . $format->fontSize ;
			
		$cmd .= ' label:"'. $text .'"';
		$cmd .= ' ' . $this->getDestination();
		
		$this->execute($cmd);
		$this->setSource($this->getDestination());
		$this->setHistory($this->getDestination());
    	return  $this ;
	}
	
	/**
	 * Add's an watermark to an image
	 *
	 * @param $watermarkImage String - Image path
	 * @param $gravity phMagickGravity - The placement of the watermark
	 * @param $transparency Integer - 1 to 100 the tranparency of the watermark (100 = opaque)
	 */
	function watermark($watermarkImage, $gravity, $transparency = 50){
		//composite -gravity SouthEast watermark.png original-image.png output-image.png
		$cmd   = $this->getBinary('composite');
		$cmd .= ' -dissolve ' . $transparency ;
		$cmd .= ' -gravity ' . $gravity ;
		$cmd .= ' ' . $watermarkImage ;
		$cmd .= ' ' . $this->getSource() ;
		$cmd .= ' ' . $this->getDestination() ;
		
		$this->execute($cmd);
		$this->setSource($this->getDestination());
		$this->setHistory($this->getDestination());
    	return  $this ;
	}
	
	/**
	 * Rotates an image X degrees
	 *
	 * @param $degrees Integer
	 */
	function rotate ($degrees){
		$cmd   = $this->getBinary('convert');
		$cmd .= ' -rotate ' . $degrees ;
		$cmd .= ' ' . $this->getSource() ;
		$cmd .= ' ' . $this->getDestination() ;
		
		$this->execute($cmd);
		$this->setSource($this->getDestination());
		$this->setHistory($this->getDestination());
    	return  $this ;
	}
	
	/**
	 * Flips the image vericaly
	 * @return unknown_type
	 */
	function flipVertical(){
		$cmd  = $this->getBinary('convert');
		$cmd .= ' -flip ' ;
		$cmd .= ' ' . $this->getSource() ;
		$cmd .= ' ' . $this->getDestination() ;
		
		$this->execute($cmd);
		$this->setSource($this->getDestination());
		$this->setHistory($this->getDestination());
    	return  $this ;
	}
	
	/**
	 * Flips the image horizonaly
	 * @return unknown_type
	 */
	function flipHorizontal(){
		$cmd  = $this->getBinary('convert');
		$cmd .= ' -flop ' ;
		$cmd .= ' ' . $this->getSource() ;
		$cmd .= ' ' . $this->getDestination() ;
		
		$this->execute($cmd);
		$this->setSource($this->getDestination());
		$this->setHistory($this->getDestination());
    	return  $this ;
	}
	
	/**
	 *
	 * @param $width Integer
	 * @param $height Integer
	 * @param $top Integer - The Y coordinate for the left corner of the crop rectangule
	 * @param $left Integer - The X coordinate for the left corner of the crop rectangule
	 * @param $gravity phMagickGravity - The initial placement of the crop rectangule
	 * @return unknown_type
	 */
	function crop($width, $height, $top = 0, $left = 0, $gravity = 'center'){
		$cmd  = $this->getBinary('convert');
		$cmd .= ' ' . $this->getSource() ;

		if (($gravity != '')|| ($gravity != phMagickGravity::None) )  $cmd .= ' -gravity ' . $gravity ;

		$cmd .= ' -crop ' . (int)$width . 'x'.(int)$height ;
		$cmd .= '+' . $left.'+'.$top;
		$cmd .= ' ' . $this->getDestination() ;
		
		$this->execute($cmd);
		$this->setSource($this->getDestination());
		$this->setHistory($this->getDestination());
    	return  $this ;
	}
	
	/**
	 * Convert's the image to grayscale
	 */
	function toGrayScale(){
		$cmd  = $this->getBinary('convert');
		$cmd .= ' ' . $this->getSource() ;
		$cmd .= ' -colorspace Gray  ';
		$cmd .= ' ' . $this->getDestination() ;
		
		$this->execute($cmd);
		$this->setSource($this->getDestination());
		$this->setHistory($this->getDestination());
    	return  $this ;
	}
	
	/**
	 * Inverts the image colors
	 */
	function invert(){
		$cmd  = $this->getBinary('convert');
		$cmd .= ' ' . $this->getSource() ;
		$cmd .= ' -negate ';
		$cmd .= ' ' . $this->getDestination() ;
		
		$this->execute($cmd);
		$this->setSource($this->getDestination());
		$this->setHistory($this->getDestination());
    	return  $this ;
	}
	
	 function getHistory( $type = Null ){
		switch ($type){
			
			case phMagickHistory::returnCsv:
				return explode(',', array_unique($this->history));
				break;
				
			default:
			case phMagickHistory::returnArray :
				return array_unique($this->history) ;
				break;
				
		}
	}
	
	 function clear($clearTempFiles = 2){
		//clears history and destnation
		//removes any files used in history ;
		
		if($clearTempFiles > 0){
			if ($clearTempFiles == phMagickClear::keepLastFile) {
			// the last file in history will be kept
			// usually the last file is the result
				array_pop($this->history);
			}
			foreach($this->getHistory(phMagickHistory::returnArray) as $file){
				@unlink($file);
			}
		}
		
		$this->setDestination('');
		$this->clearHistory();
		
		return $this ;
	}
	
	 function copy($newFileName = ''){
		//emulates copy of destination file, so we can performs actions on a new file without changing the current one
		//sets orig = destination and set dest to $newFileName
		$this->setSource($this->getDestination());
		$this->setDestination($newFileName);
		
		return $this;
	}
	
	 function restart($newFileName = ''){
		//emulates copy of source file, so we can performs actions on a new file without changing the current one
		//baicly sets orig to the original file set at startup and set dest to $newFileName
		$this->setSource($this->originalFile);
		$this->setDestination($newFileName);
		
		return $this;
	}
	
    
}

/*********************************************
*		Auxiliar classes / objects / values
**********************************************/

class phMagickTextObject {
	private $fontSize =false;
	private $font = false;
	
	private $color = false;
	private $background = false;
	
	function fontSize($i){
	    $this->fontSize = $i ;
	    return $this;
	}
	    
	function font($i){
	    $this->font = $i ;
	    return $this;
	}
	
	function color($i){
	    $this->color = $i ;
	    return $this;
	}
	
	function background($i){
	    $this->background = $i ;
	    return $this;
	}
	
	function __get($var){
	    return $this->$var ;
	}
}

class phMagickGravity{
	const None 		= 'None' ;
	const Center	= 'Center' ;
	const East		= 'East' ;
	const Forget	= 'Forget' ;
	const NorthEast	= 'NorthEast' ;
	const North		= 'North' ;
	const NorthWest	= 'NorthWest' ;
	const SouthEast	= 'SouthEast' ;
	const South		= 'South' ;
	const SouthWest	= 'SouthWest' ;
	const West		= 'West' ;
	
	private function __construct(){}
}

class phMagickHistory{
	const returnArray = 0 ;
	const returnCsv   = 1 ;
	
	private function __construct(){}
}

class phMagickClear {
	const keepAllFiles  = 0;
	const deletAllFiles = 1;
	const keepLastFile  = 2;
	
	private function __construct(){}
}




































?>