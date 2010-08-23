<? 
include 'includes/init.php';
include ('classes/project.php');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
Class Test
<? 

$Project = new project('Stupid_Users');
$ProjectSettings = $Project->get_settings();
print 'MY id = ' . $Project->get_projectID().'<br/>';
print 'MY type = ' . $Project->get_project_type().'<br/>';

?>


</body>
</html>
