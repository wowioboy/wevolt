<?php 

$Action = $_GET['action'];
$Item = $_GET['item'];
if ($Action == 'get') {
 if ($Item == 'host'){
  echo "localhost";
 } else if ($Item == 'db') {
 echo "outland_panel";
 }else if ($Item == 'pass') {
 echo "pfout.08";
 }else if ($Item == 'user') {
 echo "outland_panel";
 }

}

?>