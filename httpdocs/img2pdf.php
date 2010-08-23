<? 
$randName = md5(rand() * time());

$Directory = '8cf0ac6bb5368f55091beee94776d132';
$convertString = "convert imported/temp/".$Directory."/*.jpg imported/temp/".$Directory."/".$randName.".pdf";
exec($convertString);

//$convertString = "convert imported/temp/8cf0ac6bb5368f55091beee94776d132/*.jpg imported/temp/convertest.pdf";
//exec($convertString);
		
		?> 