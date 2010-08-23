<?
$content = file_get_contents("http://www.panelflow.com/index.php");
$content_lowercase = strtolower($content);
$currpos = 0;
$endpos = strlen($content);
$newcontent = '';
$lastimgtag = 0;

do
{
	$imgStart = strpos($content_lowercase, '<img', $currpos);
	if ($imgStart === false) 
		break;
	else 
	{
		$imgEnd = strpos($content_lowercase, '>', $imgStart);
		$imageTag = substr($content, $imgStart, $imgEnd - $imgStart + 1);
		
		$newimgtag = CreateNewImgTag($imageTag);
		$newcontent .= substr($content, $lastimgtag, $imgStart - $lastimgtag);
		$newcontent .= $newimgtag;
		$lastimgtag = $imgEnd + 1;
		$currpos = $lastimgtag;
	}
} while ($currpos < $endpos);

echo $newcontent;

function CreateNewImgTag($imageTag)
{
	$imageTag_lowercase = strtolower($imageTag);
	$startpos = strpos($imageTag_lowercase, 'src=');
	if ($startpos > 0)
	{
		$containsdoublequot = false;
		$containssinglequot = false;		
		if ($imageTag_lowercase[$startpos + 4] == '"')
			$containsdoublequot = true;
		else if ($imageTag_lowercase[$startpos + 4] == "'")
			$containssinglequot = true;		
		
		if (($containsdoublequot) || ($containssinglequot))
			$startpos += 5;
		else
			$startpos += 4;
		
		if ($containsdoublequot)
			$endpos = strpos($imageTag_lowercase, '"', $startpos);
		else if ($containssinglequot)
			$endpos = strpos($imageTag_lowercase, "'", $startpos);
		else
			$endpos = strpos($imageTag_lowercase, " ", $startpos);
			
		$src = 	substr($imageTag, $startpos, $endpos - $startpos);
	}
	
	$startpos = strpos($imageTag_lowercase, 'alt=');
	if ($startpos > 0)
	{
		$containsdoublequot = false;
		$containssinglequot = false;		
		if ($imageTag_lowercase[$startpos + 4] == '"')
			$containsdoublequot = true;
		else if ($imageTag_lowercase[$startpos + 4] == "'")
			$containssinglequot = true;		
		
		if (($containsdoublequot) || ($containssinglequot))
			$startpos += 5;
		else
			$startpos += 4;
		
		if ($containsdoublequot)
			$endpos = strpos($imageTag_lowercase, '"', $startpos);
		else if ($containssinglequot)
			$endpos = strpos($imageTag_lowercase, "'", $startpos);
		else
			$endpos = strpos($imageTag_lowercase, " ", $startpos);
			
		$alt = 	substr($imageTag, $startpos, $endpos - $startpos);
	}
	
	$httpsrc = strpos($src, 'http://');
	if ($httpsrc === false) 
	{
		// this is a realtive path make it correct
	}
	
	list($width,$height)=getimagesize($src);
	if ($width > 800)
	{
		// need to wrap click img tag
	}
	
	$newImageTag = '<img src="' . $src . '" alt="' . $alt . '" />';
	return $newImageTag;
}

?>