<? 
function validateUrl($string)
{
 if (substr($string,0,4) != 'http') {
  $string = 'http://' . urlencode($string);
  if (!preg_match('/\.[a-zA-Z0-9]+/i', $string)) {
   $string .= '.com';
  }
 }
 return $string;
}

?>