<?php
ini_set('session.cookie_domain', '.w3volt.com');
session_start();
  $DEBUG=true;
  
 if ($DEBUG) {
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
error_reporting(E_ALL ^ E_NOTICE);

}
if (isset($_SESSION['test']))
{
	echo $_SESSION['test'];
}
else
{
	echo "session variable was not set";
}

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

phpinfo();
?>
<a href="session_test.php">PAGE</a>
