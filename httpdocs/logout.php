<?php
session_start(); 
session_destroy();
ini_set('session.cookie_domain', '.wevolt.com');

setcookie("userid", "", time()-60*60*24*100, "/", "wevolt.com");

header('Location: http://www.wevolt.com/');
	 
?>
