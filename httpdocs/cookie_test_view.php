<?
//test2.php
include("classes/session.class.php");

$s = new Session();
echo $s->get("userid"); //27
?> 
