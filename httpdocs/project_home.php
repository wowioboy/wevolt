<?
include 'includes/init.php';
include 'includes/panelflow/includes/project_init.php';

$ComicName = $_GET['comicname'];
$ComicDir = substr($ComicName,0,1);

include_once("comics/".$ComicDir."/".$ComicName."/index.php");
?>