<? 
$d2=mktime(date('Y-m-d h:i:s'));
$d1=mktime(0,0,0,1,2,2007);
echo 'DATE = ' . $d1;
echo "Hours difference = ".floor(($d2-$d1)/3600) . "<br>";
echo "Minutes difference = ".floor(($d2-$d1)/60) . "<br>";
echo "Seconds difference = " .($d2-$d1). "<br>";


echo "Month difference = ".floor(($d2-$d1)/2628000) . "<br>";
echo "Days difference = ".floor(($d2-$d1)/86400) . "<br>";
echo "Year difference = ".floor(($d2-$d1)/31536000) . "<br>";

?>
