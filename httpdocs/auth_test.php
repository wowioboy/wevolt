<? 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';

$query ="SELECT p.userid, p.CreatorID, cs.Assistant1, cs.Assistant2, cs.Assistant3, cs.CreatorOne, cs. CreatorTwo, cs.CreatorThree
         from projects as p
		 join comic_settings as cs on cs.ComicID=p.ProjectID 
		 where p.ProjectID='".$_SESSION['sessionproject']."'";
		 print $query;
$ProjectArray = $InitDB->queryUniqueObject($query);

if (
		($ProjectArray->userid == $_SESSION['userid']) || 
		($ProjectArray->CreatorID == $_SESSION['userid']) || 
		(($ProjectArray->Assistant1 == $_SESSION['userid'])||($ProjectArray->Assistant1 == trim($_SESSION['username']))) ||
		(($ProjectArray->Assistant2 == $_SESSION['userid'])||($ProjectArray->Assistant2 == trim($_SESSION['username']))) ||
		(($ProjectArray->Assistant3 == $_SESSION['userid'])||($ProjectArray->Assistant3 == trim($_SESSION['username'])))
	)
	$Auth = 1;
else
	$Auth = 0;
	
unset($ProjectArray);

if ($Auth == 1) {	
print 'AUTH!';
}
?>