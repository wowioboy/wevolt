<? 
function truncStringLink($string, $limit, $break=" ", $pad="(view)",$Link) { 
// return with no change if string is shorter than $limit  
if(strlen($string) <= $limit) 

return $string; 

$string = substr($string, 0, $limit); 
if(false !== ($breakpoint = strrpos($string, $break))) { 

$string = substr($string, 0, $breakpoint);  

} 
return $string . '<a href="'.$Link.'">'.$pad.'</a>'; 

} 
?>