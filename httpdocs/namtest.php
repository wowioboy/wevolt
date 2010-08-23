<? 
//$ComicTitle = 'Test* and +(\'';
//preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, 3);

//if (preg_match ("/[*\+?{}.@`~#$%^();:<>=]/", $_POST['comictitle'])) 
	//echo 'YOu have bad characers';


$ComicFolder = "Test and  @ , sometime s I think I am";
//$pattern = '/[*\+?{}.@`)\'(~#$%^;:<>=]/';
$ComicFolder = preg_replace("/[*\+?{}.@`)\,'(~#$%^;:<>=]/","",$ComicFolder);
//echo 'MATCH = ' . preg_match($pattern, $subject);
//print_r($matches);
echo $ComicFolder;

?>