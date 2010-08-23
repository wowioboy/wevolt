<?

class snapshot{
	
	// Variables for program Hypersnap
	var $snap_prog="hypersnap";
	var $snap_prog_path=array("hypersnap"=>"c:/programme/HyperSnap/HprSnap.exe");
	var $snap_prog_param_save=array("hypersnap"=>"-save:[FILETYPE]:q[QUALITY] [FILENAME].[FILETYPE] -hidden");
	var $snap_prog_param_screen=array("hypersnap"=>"-snap:x[X]:y[Y]:w[WIDTH]:h[HEIGHT]");
	
	var $snap_x="0";
	var $snap_y="0";
	var $snap_width="";
	var $snap_height="";
	var $snap_quality="100";
	
	var $pic_width="";
	var $pic_height="";
	
	var $filetype="JPEG";
	var $filetypes=array("JPEG"=>"jpg","BMP"=>"bmp","GIF"=>"gif");
	
	var $jpeg_quality="70";
	
	var $filename="";
	
	var $errors=array();
	
	var $errorcodes_en=array(
	"001"=>"The filename have not been set",
	"002"=>"The snapshot width have not been set",
	"003"=>"The snapshot height have not been set"
	);
	
	function snapshot(){
	}
	
	function set_snap_prog($snap_programm){
		// Allowed programs=hypersnap
		$this->snap_prog=$snap_programm;
	}
	
	function set_snap_x($x){
		$this->snap_x=$x;
	}
	
	function set_snap_y($y){
		$this->snap_y=$y;
	}
	
	function set_snap_width($width){
		$this->snap_width=$width;
	}
	
	function set_snap_height($height){
		$this->snap_height=$height;
	}
	
	function set_filetype($filetype){
		// Allowed filetypes = JPEG, BMP, GIF
		$this->filetype=$filetype;
	}
	
	function set_file_name($filename){
		$this->filename=$filename;
	}
	
	function set_pic_width($width){
		$this->pic_width=$width;
	}
	
	function set_pic_height($height){
		$this->pic_height=$height;
	}
	
	function set_jpeg_quality($quality){
		$this->jpeg_quality=$quality;
	}
	
	function set_snap_jpeg_quality($quality){
		$this->snap_quality=$quality;
	}
	
	function shot(){
		// Checking for errors
		if($filename==""){
			$this->errors=array_merge($this->errors,array("001"));
		}
		if($this->snap_width==""){
			$this->errors=array_merge($this->errors,array("002"));
		}
		if($this->snap_height==""){
			$this->errors=array_merge($this->errors,array("003"));
		}
		
		// If errors occured
		if(count($this->errors)>1){
			return false;
			// If no errors occured
		}else{
			
			// Replacing filetype placeholders in param save string
			$param_save=preg_replace("[\[FILETYPE\]]",$this->filetypes[$this->filetype],$this->snap_prog_param_save[$this->snap_prog]);
			$param_save=preg_replace("[\[FILENAME\]]",$this->filename,$param_save);
			$param_save=preg_replace("[\[QUALITY\]]",$this->snap_quality,$param_save);
			
			// Creating new filename
			$filename=$this->filename.".".$this->filetypes[$this->filetype];
			
			// Replacing filetype placeholders in param screen string
			$param_screen=preg_replace("|\[X\]|",$this->snap_x,$this->snap_prog_param_screen[$this->snap_prog]);
			$param_screen=preg_replace("|\[Y\]|",$this->snap_y,$param_screen);
			$param_screen=preg_replace("|\[WIDTH\]|",$this->snap_width,$param_screen);
			$param_screen=preg_replace("|\[HEIGHT\]|",$this->snap_height,$param_screen);
			
			$exec=$this->snap_prog_path[$this->snap_prog]." ".$param_screen." ".$param_save;
			system($exec);
			
			if($this->pic_width!="" && $this->pic_height==""){		
				$source_pic = ImageCreateFromJPEG($filename);
				$width = ImageSX($source_pic);
				$height = ImageSY($source_pic);
				$scalefactor = $width/$this->pic_width;
				$height_new = $height/$scalefactor;
				$target_pic = ImageCreate($this->pic_width,$height_new);
				imagecopyresized($target_pic, $source_pic, 0, 0, 0, 0, $this->pic_width, $height_new, $width, $height);
				ImageJPEG($target_pic, $filename,$this->jpeg_quality);
				ImageDestroy($target_pic);
			}
			
			if($this->pic_height!="" && $this->pic_width==""){
				$source_pic = ImageCreateFromJPEG($filename);
				$width = ImageSX($source_pic);
				$height = ImageSY($source_pic);
				$scalefactor = $height/$this->pic_height;
				$width_new = $width/$scalefactor;
				$target_pic = ImageCreate($width_new,$this->pic_height);
				imagecopyresized($target_pic, $source_pic, 0, 0, 0, 0, $width_new, $this->pic_height, $width, $height);
				ImageJPEG($target_pic, $filename,$this->jpeg_quality);
				ImageDestroy($target_pic);				
			}
			
			if($this->pic_width!="" && $this->pic_height!=""){
				$source_pic = ImageCreateFromJPEG($filename);
				$width = ImageSX($source_pic);
				$height = ImageSY($source_pic);				
				$target_pic = ImageCreate($this->pic_width,$this->pic_height);
				imagecopyresized($target_pic, $source_pic, 0, 0, 0, 0, $this->pic_width, $this->pic_height, $width, $height);
				ImageJPEG($target_pic, $filename,$this->jpeg_quality);
				ImageDestroy($target_pic);				
			}
			if(is_file($filename)){
				return true;
			}else{
				return false;
			}
		}
	}
}
?>