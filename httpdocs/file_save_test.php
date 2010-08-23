<? 
echo getcwd();
$Localname = '/var/www/vhosts/panelflow.com/httpdocs/temp/layouer.jpg';

$gif = file_get_contents('http://www.panelflow.com/store/get_product_image.php?pid=186988472832766363&image=users/matteblack/merch/originals/446b8eb6362fa614597f93df8e44f854.jpg') or die('Could not grab the file');	         
				$fp  = fopen($LocalName, 'w+') or die('Could not create the file');
				fputs($fp, $gif) or die('Could not write to the file');
				fclose($fp);
				chmod($LocalName,0777);



?>