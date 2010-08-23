<?php
// example of how to modify HTML contents
include($_SERVER['DOCUMENT_ROOT'].'/classes/simple_html_dom.php');
$Url = $_REQUEST['url'];
// get DOM from URL or file
$html = file_get_html($Url);
$MetaTags = get_meta_tags($Url);
$Description = $MetaTags['description'];
print 'Description = ' . $Description.'<br/>';

// remove all image
foreach($html->find('img') as $element) {
       $Source = $element->src;
	   list($width,$height)=getimagesize($Source);
	  	   
	   if (($width > 100) && ($height > 90)){
	   	    if (!in_array($Source,$ThumbArray)) {
				$ThumbArray[] = $Soure;
	   			echo '<img src="'.$Source.'" width="100" hspace="3" vspace="3" border="1"><br/>';
						
			}
	   
	   }
}

?>