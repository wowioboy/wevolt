<? if (is_authed()) { 
		$loggedin = 1;
		} else {
		$loggedin = 0;
		} ?>


    
      <? // Iphone Redirect
$Agent = $_SERVER['HTTP_USER_AGENT'];
$AgentTest = substr($Agent,13,2);
if ($AgentTest != 'iP'){
header("location:/index.php");
} 


?>
<?php include 'init.php';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="css/pf_css_iphone.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW - <? echo $PageTitle;?></title>
</head>

<body>

