<?php 
header( 'Content-Type: text/javascript' );
include '../includes/init.php';
$DB = new DB();

if ($_GET['id'] == '')
	$EntryID = $_SESSION['currentStringID'];
else 
	$EntryID = $_GET['id'];
	
if ($_GET['status'] == '')
	$MarkStatus= $_SESSION['CurrentMarkStatus'];
else 
$MarkStatus = $_GET['status'];

if (($MarkStatus == 1) || ($MarkStatus == 'marked_2')){
	$NewStatus = 0 ;
	$Class = 'unmarked_2';
}else {
	$NewStatus = 1;
	$Class = 'marked_2';
}
if ($_SESSION['userid'] != '') {
	$query ="UPDATE string_entries set IsMarked='$NewStatus' where ID='$EntryID' and UserID='".$_SESSION['userid']."'";
	$DB->execute($query);
	$query = "SELECT se.LinkID,se.IsMarked,se.ID as EntryID, se.UserID, se.LastVisited, sl.* from string_entries as se
				  join string_links as sl on se.LinkID=sl.ID
				  where se.ID='$EntryID'";
	$StringArray = $DB->queryUniqueObject($query);
	
	if ($StringArray->IsMarked == 0)
		$Status = 'unmarked';
	else
		$Status = 'marked';
}
$DB->close();
?>
obj=document.getElementById('string_<? echo $EntryID;?>');

obj.className = '<? echo $Class;?>';


