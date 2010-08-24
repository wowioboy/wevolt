<?php 
require_once('../includes/db.class.php');
if ($search = $_REQUEST['search']) {
	$search = '%' . str_replace(' ', '%', $search) . '%';
	$query = "select 'comic' as type, title as name, thumb 
			  from projects 
			  where projects.title like '$search' or projects.tags like '$search' 
			  union 
			  select 'user' as type, username as name, avatar as thumb 
			  from users 
			  where users.username like '$search' 
			  limit 10";
	$results = Danb::getInstance()->fetchAll($query);
	echo json_encode($results);
}
?>