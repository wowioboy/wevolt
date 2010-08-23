<?php 

$local_file = "/public_html/panelflow/users/avatars/Matteblack.gif";
$remote_file = "http://www.spamkills.com/images/Matteblack.gif";

function copy_file($new_file, $file){
 
 $ch = curl_init ($file);
 $fp_curl = fopen($new_file, "w") or
 die("Unable to open $new_file for writing.\n");
 
 curl_setopt ($ch, CURLOPT_FILE, $fp_curl);
 curl_setopt ($ch, CURLOPT_FAILONERROR, true);
 curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);
 
 if (!curl_exec ($ch)) {
 print("Unable to fetch $file.\n");
 }
 curl_close ($ch);
 fclose ($fp_curl);
}  

copy_file($remote_file, $local_file);  

?>