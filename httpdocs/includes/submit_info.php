<?php



$db_host = 'localhost'; 

$db_user = 'outland_news';

$db_pass = 'kugtov.02';

$db_database = 'outland_news';


 
$Email = $_POST['email']; 

$Name = $_POST['emailname'];



// Connect to Mysql, select the correct database, and run the query which adds the data gathered from the form into the database

mysql_connect($db_host,$db_user,$db_pass) or die(mysql_error());

mysql_select_db($db_database) or die(mysql_error());

$add_all = "INSERT INTO newsletter values('$Email','$Name')";

mysql_query($add_all) or die(mysql_error());



echo "&success=1";



?>



<input type="hidden" name="Writer"  value="<?php echo $Email;?>"/>

<input type="hidden" name="Artist"  value="<?php echo $Name;?>"/>

