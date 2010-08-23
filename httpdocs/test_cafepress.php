<?
//'http://open-api.cafepress.com/authentication.getUserToken.cp?v=3&appKey=px37mdu7cfwk3fstd4qrrwsx&email=glenn@boundzero.com&password=bummer'
//$ch = curl_init('http://open-api.cafepress.com/authentication.getLoginToken.cp?appKey=px37mdu7cfwk3fstd4qrrwsx');   
// Login
$appKey = "px37mdu7cfwk3fstd4qrrwsx"; // mine
//$appKey = "sfquxh7kj9uspc9p4hyguqdq"; // matt's
//$appKey = "77888c76-60ac-44f1-8e88-207bc5a81234";
echo  "test";
$ch = curl_init("http://open-api.cafepress.com/authentication.getUserToken.cp?v=3&appKey=$appKey&email=matt@outlandentertainment.com&password=baegtobar09");   
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$postResult = curl_exec($ch); 
//echo 'here: ' . $postResult;
curl_close($ch);
flush();

//$userKey = simplexml_load_string($postResult);
$xmlDom = new DOMDocument();
$xmlDom->loadXML($postResult);

$x = $xmlDom->documentElement;
foreach ($x->childNodes AS $item)
{
	$userKey =  $item->nodeValue . "<br />";
}
/*
$url = "http://upload.cafepress.com/image.upload.cp?appKey=$appKey&userToken=$userKey&folder=Images&cpFile1=forward_mail.gif";
//echo $postResult . ' - ' . $userKey . "<br />";
*/
//upload file
//simulates <input type="file" name="file_name">
//$postData[ 'cpFile1' ] = "@" . realpath (".") . "/images/forward_mail.gif";
//$postData[ 'appKey' ] = $appKey;
//$postData[ 'userToken' ] = $userKey;
//$postData[ 'folder' ] = 'Images';


$url = "http://upload.cafepress.com/upload.htm?appKey=$appKey&userToken=$userKey&folder=Images";
//$url = "http://upload.cafepress.com/image.upload.cp?appKey=$appKey&userToken=$userKey&folder=Images&v=3";
$url = "http://upload.cafepress.com/image.upload.cp?appKey=$appKey&userToken=$userKey&folder=test&v=3";
//$tmpfname = realpath (".") . "/images/forward_mail.gif";
$tmpfname = realpath (".") . "/images/forward_mail.gif";
	
$post = array(        
	"cpFile1"=>"@$tmpfname",    
	"appKey"=>$appKey,    
	"userToken"=>$userKey,    
	"folder"=>'test',
	"v"=>'3'
	
	//"goto"=>'http://www.panelflow.com'
);
var_dump($post);
$ch = curl_init();
//curl_setopt($ch, CURLOPT_HEADER, 1);    
//curl_setopt($ch, CURLOPT_VERBOSE, 1);    
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
curl_setopt($ch, CURLOPT_URL, $url);

  
//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible;)");    
curl_setopt($ch, CURLOPT_POST, 1);  
//seems no need to tell it enctype='multipart/data' it already knows
curl_setopt($ch, CURLOPT_POSTFIELDS, $post );

$response = curl_exec( $ch );
if (curl_errno($ch)) {
print curl_error($ch);
}

curl_close($ch);
echo "response: " . $response;
exit;

?>