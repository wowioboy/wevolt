<?
$templateURL = 'http://www.zazzle.com/api/create/at-238957118906091327?rf=238957118906091327&ax=Linkover&pd='.$_GET['pid'].'&fwd=ProductPage&ed=true&image=';
$Image = $_GET['image'];
$imageURL = urlencode('http://www.panelflow.com/'.$Image);

$fullURL = $templateURL . $imageURL;

//echo $fullURL. '<br />';
//ini_set("user_agent", "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)");
//$html = file_get_contents($fullURL);

$html = url_get_contents($fullURL,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)", 'headers only', true, false);

$locationurls = getLocation($html);
//print_r($locationurls );
$html = url_get_contents($locationurls[1],"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322)", false, true, false, $locationurls[0]);
//echo $html;
//exit; 

$searchtext='<img id="page_productView-realview" src="';
$pos = strpos($html, $searchtext);
if ($pos===false)
 echo 'Could not find image URL';
else
{
	$pos += strlen($searchtext);
	$lastpos = strpos($html, '"', $pos+1);
	$productimageurl = substr($html, $pos, $lastpos - $pos);
	
	//echo 'imageurl: ' . $productimageurl . '<br />';
	
	//$path = substr($_SERVER['SCRIPT_FILENAME'], 0, strrpos($_SERVER['SCRIPT_FILENAME'], '/'));
	$path = '/var/www/vhosts/panelflow.com/httpdocs/temp';
	
	$filename = $_GET['target'];
//	$filename = basename($productimageurl);
	//$filename = "image.jpg";
	
	
	$contents = file_get_contents($productimageurl);
	$fp = fopen($path . '/' . $filename, 'w');
	fwrite($fp, $contents);
	fclose($fp);
	
	echo "<br /><img src='/temp/$filename' />";
	// now resize this bad boy

}

# url_get_contents function by Andy Langton: http://andylangton.co.uk/
function url_get_contents($url,$useragent='cURL',$headers=false,
$follow_redirects=false,$debug=false, $referer = '') {

# initialise the CURL library
$ch = curl_init();

curl_setopt($ch, CURLOPT_COOKIESESSION,1);
curl_setopt($ch, CURLOPT_COOKIEFILE, "cookiefile"); 
curl_setopt($ch, CURLOPT_COOKIEJAR, "cookiefile"); 


# specify the URL to be retrieved
curl_setopt($ch, CURLOPT_URL,$url);

# we want to get the contents of the URL and store it in a variable
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

# specify the useragent: this is a required courtesy to site owners
curl_setopt($ch, CURLOPT_USERAGENT, $useragent);

# ignore SSL errors
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

# return headers as requested
if ($headers==true){
curl_setopt($ch, CURLOPT_HEADER,1);
}

# only return headers
if ($headers=='headers only') {
curl_setopt($ch, CURLOPT_NOBODY ,1);
}

# follow redirects - note this is disabled by default in most PHP installs from 4.4.4 up
if ($follow_redirects==true) {
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); 
}

curl_setopt($s,CURLOPT_REFERER,$referer); 
# if debugging, return an array with CURL's debug info and the URL contents
if ($debug==true) {
$result['contents']=curl_exec($ch);
$result['info']=curl_getinfo($ch);
}

# otherwise just return the contents as a variable
else $result=curl_exec($ch);

//echo "Redirect<br />";
//print_r(curl_getinfo($ch,CURLINFO_EFFECTIVE_URL));
//echo "done<br />"


# free resources
curl_close($ch);

# send back the data
return $result;
}

function getLocation($data)
{
	$arrHeader = split("\n", $data);
	$cnt = 0;
	$val =  array();
	foreach($arrHeader as $values)
	{
		if (strpos($values, "Location:") !== false)
		{
			$val[] = trim(str_replace('Location: ' ,'', $values));
		}
	}
	return $val;
}
?>