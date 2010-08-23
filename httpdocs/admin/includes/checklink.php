<?php 

function checklink($link)
{
if(!($handle=@fopen($link,'r')))
	{
		return 'Not Found';
		//print "MY NOT FOUND!";
	} else {
	$content = file_get_contents($link);
	//print $link;
	fclose($handle);
	//print "MY CONTENT =" . $content."<br/>";
	if (trim($content) == 'Found') {
	return 'Found';
	}  else {
	//print 'Not Found';
	return 'Not Found';
	
	}
	
	
	}

}

//checklink('http://www.goodfridaycomic.com/urltest.php');

?>