<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title> PF DATABASE DUMP</title>
</head>

<body>
<h2>
  
 PF DATABASE DUMP</h2>
<p>
<?php
set_time_limit(0);
 include("/var/www/vhosts/w3volt.com/httpdocs/classes/mysql.export.php");
 $e = new export_mysql('localhost', 'panel_panel', 'pfout.08', 'panel_panel');//instance class
 $e->exportAll('/var/www/vhosts/w3volt.com/httpdocs/db_backup/pf_db_dump_all_'.date('Y-m-d').'.sql',true);//export all (structure and value) and zipped
 echo("Export All (structure and value) and compress to pf_db_dump_all_".date('Y-m-d').".zip <br />");
 
 $e->exportStructure('/var/www/vhosts/w3volt.com/httpdocs/db_backup/pf_db_dump_struct_'.date('Y-m-d').'.sql',true);//export only structure and zipped
 echo("Export structure and compress to pf_db_dump_struct_".date('Y-m-d').".zip <br />");
 
// $e->exportValue('/var/www/vhosts/w3volt.com/httpdocs/db_backup/pf_db_dump_value_'.date('Y-m-d').'.sql',true);//export value and zipped
 //echo("Export value)and compress to pf_db_dump_value_".date('Y-m-d').".zip <br />");
 
 
 
?>
</p>
</body>
</html> 