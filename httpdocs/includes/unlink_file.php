<? 
$old = getcwd(); // Save the current directory
$Header = 'header33.jpg';
   	 	chdir('../temp');
    	unlink($Header);
    	chdir($old);
?>