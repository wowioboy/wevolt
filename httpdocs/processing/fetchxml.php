<?php 
$cachefolder="tempxml"; //path to cache directory. No trailing "/". Set dir permission to read/write!
$rssurl=$remote_file;

$localfile=$cachefolder. "/" . urlencode($rssurl); //Name cache file based on RSS URL

function fetchfeed(){
global $rssurl, $localfile;
$contents=file_get_contents($rssurl); //fetch RSS feed
$fp=fopen($localfile, "w");
fwrite($fp, $contents); //write contents of feed to cache file
fclose($fp);
}
fetchfeed();
?>