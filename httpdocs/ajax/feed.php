<?php 
require_once('../includes/db.class.php');
$db = new Danb();
$user = $_REQUEST['user'];
$query = "select u.content_id as id, u.link, p.thumb, us.username as user,  actiontype as action, u.actionsection as subject, p.title, i.time
from
(   select max(id) as 'i', max(if(live_date is not null and live_date > `date`, `live_date`, `date`)) as 'time'
    from updates
    where (actionsection = 'series' or actionsection = 'strip' or actionsection = 'page')
    and content_id is not null 
    and content_id != ''
    and if(live_date is not null and live_date != '0000-00-00 00:00:0000', live_date, date) <= now() 
    group by content_id
    order by time desc    
    limit 1
) as i
left join updates u 
on u.id = i.i 
left join users us 
on u.userid = us.encryptid 
left join projects p 
on u.content_id = p.projectid 
limit 1;";
$row = $db->fetchRow($query);
$thumb = 'http://www.wevolt.com' . $row['thumb'];
if (!is_array(@getimagesize($thumb))) {
	$thumb = "http://www.wevolt.com/images/no_thumb_project.jpg";	
}
$row['thumb'] = $thumb;
$date = new DateTime($row['time']);
$row['time'] = ($row['subject'] == 'page') ? $date->format('F jS, Y') : $date->format('F jS, Y @ g:i a');
if ($row['user'] != $user) {
	echo json_encode($row);
}