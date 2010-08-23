<?php
function get_dpi_x($filename){
		list($width,$height)=getimagesize($filename);
        $a = fopen($filename,'r');
		$string = fread($a,20);
		fclose($a);
   		$data = bin2hex(substr($string,14,4));
    	$x = substr($data,0,4);
	//print 'MY y = ' . $y; 
    return hexdec($x);

}
function get_dpi_y($filename){
	
        $a = fopen($filename,'r');
		$string = fread($a,20);
		fclose($a);
   		$data = bin2hex(substr($string,14,4));
    	$y = substr($data,4,4);
	//print 'MY y = ' . $y; 
    return hexdec($y);

}

function get_print_width($width,$dpi) {
		$Inches = $width/$dpi;
		
		return $Inches;
}

function get_print_height($height,$dpi) {
		$Inches = $height/$dpi;

		return $Inches;
}
// output the result:

//$ArrayNew = get_dpi('gf1.jpg'));
$filename = 'users/matteblack/prints/originals/Ink.jpg';
list($width,$height)=getimagesize($filename);
$x = get_dpi_x($filename);
$y = get_dpi_y($filename);
$Width = get_print_width($filename);
    // get the value of byte 14th up to 18th
    
	print 'IMAGE filename = '. $filename.'<br/>';
	print 'IMAGE DPI = '. $x.'<br/>';
	print 'IMAGE HEIGHT PIXELS = '. $height.'<br/>';
	print 'IMAGE WIDTH PIXELS = '. $width.'<br/>';
	print 'IMAGE HEIGHT(IN) = '.get_print_height($height,$y) .'<br/>';
	print 'IMAGE WIDTH(IN) = '.get_print_width($width,$x)  .'<br/>';
	

?>