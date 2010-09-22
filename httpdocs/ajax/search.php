<?php 
require_once('../includes/db.class.php');
if ($search = $_REQUEST['search']) {
	$search = '%' . str_replace(' ', '%', $search) . '%';
	$query = "select 'comic' as type, title as name, thumb, genre as tag
			  from projects 
			  where (projects.title like '$search' or projects.tags like '$search')  and projects.installed = 1 and projects.Published=1 and projects.Hosted=1
			  union 
			  select 'user' as type, username as name, avatar as thumb, location as tag
			  from users 
			  where users.username like '$search' 
			  limit 10";
	$results = Danb::getInstance()->fetchAll($query);
	echo json_encode($results);
}
?> 