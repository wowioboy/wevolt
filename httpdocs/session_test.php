<?php
ini_set('session.cookie_domain', '.w3volt.com');
session_start();

$_SESSION['test'] = 'testing';
?>
<a href="session_test2.php">PAGE</a>