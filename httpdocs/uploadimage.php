<?php
//create the directory if doesn't exists (should have write permissons)
if(!is_dir("./users/avatars")) mkdir("./users/avatars", 0755); 
//move the uploaded file
move_uploaded_file($_FILES['Filedata']['tmp_name'], "./users/avatars/".$_FILES['Filedata']['name']);
chmod("./users/avatars/".$_FILES['Filedata']['name'], 0777);
?>