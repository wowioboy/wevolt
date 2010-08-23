<?php 
include_once('../includes/init.php'); 
$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

$id = $_GET['id'];
$type = $_REQUEST['type']; 
$updateid = $_REQUEST['update'];

switch ($type) {
	case 'project':
		$where = "and u.content_id = '$id'";
		break;
	case 'user':
		$where = "and u.content_id is null 
				  and u.userid = '$id'";
		break;
	default: 
}

$query = "select 
		  u.actiontype as action, 
		  u.actionsection as subject, 
		  ifnull(u.live_date, u.date) as date,
		  u.link, 
		  u.content_title as title
		  from updates u 
		  where u.link is not null 
		  $where 
		  and (u.live_date is null or u.live_date < now()) 
		  and u.id != '$updateid'
		  group by u.actiontype, u.actionsection
		  order by u.date desc 
		  limit 25";
$results = $db->fetchAll($query);
$db->close();
echo json_encode($results);