<?
include("snapshot.class.php");

class url_snapshot extends snapshot{
	
	var $browser_type="NS6";
	
	var $browser=array(
		"NS6"=>array(
			"PATH"=>"c:/programme/Netscape/Netscape/netscp.exe",
			"SPACETOP"=>"141",
			"SPACEBOTTOM"=>"47",
			"SPACELEFT"=>"0",
			"SPACERIGHT"=>"17"
			)
		);
	
	
	var $url="";
	
	var $screen_width="";
	var $screen_height="";
	
	function url_snapshot($url){
		$this->url=$url;
	}
	
	function set_browser($type){
		// $type -> IE5 , NS6
		$this->browser_type=$type;
	}
	
	function set_screen_resolution($width,$height){
		$this->screen_width=$width;
		$this->screen_height=$height;
		
		$this->snap_width=$this->screen_width-($this->browser[$this->browser_type]["SPACELEFT"]+$this->browser[$this->browser_type]["SPACERIGHT"]);
		$this->snap_height=$this->screen_height-($this->browser[$this->browser_type]["SPACETOP"]+$this->browser[$this->browser_type]["SPACEBOTTOM"]);
		$this->snap_x=$this->browser[$this->browser_type]["SPACELEFT"];
		$this->snap_y=$this->browser[$this->browser_type]["SPACETOP"];
	}
	
	function shot_url(){
		$exec=$this->browser[$this->browser_type]["PATH"]." ".$this->url;
		
		system($exec);
		sleep(4);
		$this->shot();
	}
}
?>