<? 

function getDimensions($object) 
{
 $widthRe = '/width[ ]*[:|=][ ]*[\'|"]?[ ]*\d+/i';
 $heightRe = '/height[ ]*[:|=][ ]*[\'|"]?[ ]*\d+/i';
 $digitRe = '/\d+/';
 preg_match($widthRe, $object, $width);
 preg_match($digitRe, $width[0], $width);
 preg_match($heightRe, $object, $height);
 preg_match($digitRe, $height[0], $height);
 $width = array_shift($width);
 $height = array_shift($height);
 return array('height' => $height, 'width' => $width);
}
$EmbedCode = '<object width="640" height="505"><param name="movie" value="http://www.youtube.com/v/6omZ5GsuGrI&hl=en_US&fs=1&"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/6omZ5GsuGrI&hl=en_US&fs=1&" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="505"></embed></object>';
$EmbedDimensions = getDimensions($EmbedCode);
$EmbedWidth = $EmbedDimensions['width'];
$EmbedHeight = $EmbedDimensions['height'];
print 'Width = ' . $EmbedWidth;
print_r($EmbedDimensions);

?>
