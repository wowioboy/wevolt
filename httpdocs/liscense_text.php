<? function randomPrefix($length)
{
$random= "";

srand((double)microtime()*1000000);

$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
$data .= "0FGH45OP89";

for($i = 0; $i < $length; $i++)
{
$random .= substr($data, (rand()%(strlen($data))), 1);
}

return $random;
}
echo randomPrefix(15); 
echo "<br>";
$b = uniqid ($data);
echo $b;
echo "<br>";

//creates a unique ID with a random number as a prefix - more secure than a static prefix
$c = uniqid ($data,true);
echo $c;
echo "<br>";

//this md5 encrypts the username from above, so its ready to be stored in your database
$md5c = md5($c);
echo $md5c;
?> 

