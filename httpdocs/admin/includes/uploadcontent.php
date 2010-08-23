<?php
//create the directory if doesn't exists (should have write permissons)
if(!is_dir("../temp")) mkdir("../temp", 0755); 
//move the uploaded file

$NewFile = $_FILES['Filedata']['name'];
//$NewFileTitle = str_replace('&', 'and', $NewFile);

move_uploaded_file($_FILES['Filedata']['tmp_name'], "../temp/".$NewFile);
chmod("../temp/".$NewFile, 0777);
?>