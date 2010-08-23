<? 
include $_SERVER['DOCUMENT_ROOT'].'/includes/db.class.php';
$DB = new DB();
$CurrentDayRange = date('Y-m-d 00:00:00');
$yesterdaystart=date("Y-m-d", time()-86400).' 00:00:00';
$yesterdayend=date("Y-m-d", time()-86400).' 23:59:59';

$query = "select count(*) from users";
$TotalUsers = $DB->queryUniqueValue($query);
print 'Total Users = ' . $TotalUsers.'<br/><br/>';

$query = "select count(*) from users where joindate>='".date("Y-m-d")." 00:00:00' and joindate<='".date("Y-m-d")." 23:59:59'";
$TotalNewUsers = $DB->queryUniqueValue($query);
print 'Total New Users Today = ' . $TotalNewUsers.'<br/><br/>';

$query = "select count(*) from users where joindate>='$yesterdaystart' and joindate<='$yesterdayend'";
$TotalNewUsers = $DB->queryUniqueValue($query);
print 'Total New Users on '.date("m/d/Y", time()-86400).' = ' . $TotalNewUsers.'<br/>';

$query = "select count(*) from users where joindate>='".date("Y-m-d", time()-172800)." 00:00:00' and joindate<='".date("Y-m-d", time()-172800)." 23:59:59'";
$TotalNewUsers = $DB->queryUniqueValue($query);
print 'Total New Users on '.date("m/d/Y", time()-172800).' = ' . $TotalNewUsers.'<br/>';

$query = "select count(*) from users where joindate>='".date("Y-m-d", time()-259200)." 00:00:00' and joindate<='".date("Y-m-d", time()-259200)." 23:59:59'";
$TotalNewUsers = $DB->queryUniqueValue($query);
print 'Total New Users on '.date("m/d/Y", time()-259200).' = ' . $TotalNewUsers.'<br/>';

$DB->close();
?>