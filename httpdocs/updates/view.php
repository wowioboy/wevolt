<?php 
include_once('../includes/init.php'); 
$db = new DB();

$userid = $_SESSION['userid'];
$type = $_REQUEST['type'];
$filter = $_REQUEST['filter'];

if ($type == 'project') {
	if ($filter == 'my') {
		$join = "inner join follows f on follow_id = u.content_id";
		$where = "and f.user_id = '$userid' 
				  and f.type = 'project'";
	} else if ($filter == 'friends') {
		$join = "inner join friends f on (f.userid = u.userid and f.friendid = '$userid') or (f.friendid = u.userid  and f.userid = '$userid')";
		$where = "and f.accepted = '1'";
	}
	$actions = "('series', 'strip')";
	$content = "(u.content_id is not null and u.content_id != '')";
	$group = 'u.content_id';
	$select = "p.title as name, 
			   p.thumb as thumb, 
			   u.content_id as subject_id,
			   us.username,";
	$followOn = "uu.follow_id = u.content_id and uu.type = 'project'"; 
	$otherJoin = "left join projects p on p.projectid = u.content_id"; 
	$otherWhere = 'p.title is not null';
} else {
	if ($filter == 'my') {
		$join = "inner join follows f on f.follow_id = u.userid";
		$where = "and f.user_id = '$userid' 
				  and f.type = 'user'";
	} else if ($filter == 'friends') {
		$join = "inner join friends f on (f.userid = u.userid and f.friendid = '$userid') or (f.friendid = u.userid  and f.userid = '$userid')";
		$where = "and f.accepted = '1'";
	}
	$actions = "('excite', 'window', 'promotion')";
	$content = "(u.content_id is null or u.content_id = '')";
	$group = 'u.userid';
	$select = "us.username as name,
			   us.avatar as thumb,
			   u.userid as subject_id,
			   ex.comment,";
	$followOn = "uu.follow_id = u.userid  and uu.type = 'user'";
//	$otherJoin = "left join users us on u.userid = us.encryptid";
	$otherWhere = 'us.username is not null';
}
$query = "select max(u.id) as `id`
		  from updates u 
		  $join  
		  where u.actionsection in $actions 
		  and $content 
		  and u.userid != '$userid' 
		  and (u.live_date is null or u.live_date < now())
		  $where 
		  group by $group			  
		  order by live_date desc, date desc
		  limit 25";
$results = @$db->fetchCol($query);
//var_dump($query);
$rows = array();
foreach ($results as $result) {
	$query = "select 
			  u.id, 
		  	  if (u.actionsection = 'excite', ex.link, u.link) as link, 
		      if (u.actionsection = 'excite', ex.blurb, u.content_title) as title,
		      u.date,
		      u.actiontype as action, 
		      u.actionsection as subject, 
		      if(u.live_date is null or u.live_date = '0000-00-00 00:00:00', u.date, u.live_date) as date,  
		      $select
		      uu.type as following 
		      from updates u 
		      left join excites ex on ex.userid = u.userid 
		      left join users us on u.userid = us.encryptid
		      left join follows uu on uu.user_id = '$userid' and $followOn 
		      $otherJoin
		      where u.id = '$result' 
		      and $otherWhere";
	$row = @$db->fetchRow($query);
	if ($row) {
		$rows[] = $row;
	}
}
?>
<div align="left">
<?php if (count($rows) > 0) : ?>
<?php foreach ($rows as $row) : ?>
  <?php 
    $date = new DateTime($row['date']); 
    $subjectId = $row['subject_id'];
    $id = $row['id'];
    $count = $row['count'];
    $name = $row['name'];
    $comment = $row['comment'];
    $thumb = $row['thumb'];
    if ($type == 'project') {
    	$thumb = 'http://www.wevolt.com' . $thumb;
    }
    if (!is_array(@getimagesize($thumb))) {
		$thumb = "/images/no_thumb_project.jpg";	
	}
    $following = $row['following'];
    $link = $row['link'];
    $action = $row['action'];
    $subject = $row['subject'];
    $title = stripslashes($row['title']);
    $username = $row['username'];
    if ($subject == 'series' || $subject == 'strip') {
    	$name = $username;
    } 
  ?>
  <table class="update" id="<?php echo $subjectId . '_' . $type . '_' . $filter; ?>">
    <tr>
      <td style="width:50px;" valign="top">
        <?php if ($thumb) : ?>
        <img src="<?php echo $thumb; ?>" width="50" height="50" />
        <?php endif; ?>
      </td>
      <td valign="top">
        <table width="100%">
          <tr>
            <td valign="middle">
	          <b>
	          <a style="color:#000;" href="http://users.wevolt.com/<?php echo $name; ?>/"><?php echo $name; ?></a>
	          </b>
            </td>
            <td align="right" valign="middle">
	  		  <?php if ($_SESSION['userid']) : ?>        
	              <button class="followButton" subjectid="<?php echo $subjectId; ?>" update_type="<?php echo $type; ?>" filter="<?php echo $filter; ?>">
	            <?php if ($following) : ?>
	              unfollow
	            <?php else: ?>
	              follow
	            <?php endif; ?>
	              </button>
	          <?php endif; ?>
            </td>
          </tr>
          <tr>
            <td valign="top">
              <?php if ($subject == 'excite') : ?>
              <a href="<?php echo $link; ?>" target="_blank"><?php echo $title; ?></a>
              <br />
              <?php echo "\"$comment\""; ?>
              <?php else: ?>
              <?php 
                echo $action;
                echo ($title) ? ' ' . $subject . ': ' : ''; 
              ?> 
              <a href="<?php echo $link; ?>"><?php echo ($title) ? $title : $subject; ?></a> - <?php echo ($subject == 'page') ? $date->format('F jS, Y') : $date->format('F jS, Y @ g:i a'); ?>
              <?php endif; ?>
            </td>
            <td align="right" valign="bottom">
	          <?php if ($filter == 'my' && $count > 1) : ?>
	            <a href="javascript:" class="expander" updateid="<?php echo $id; ?>" subjectid="<?php echo $subjectId; ?>" update_type="<?php echo $type; ?>" filter="<?php echo $filter; ?>">
	              more...
	            </a>
	          <?php endif; ?>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td colspan="2">
        <?php if ($filter == 'my') : ?>
          <div id="<?php echo "{$filter}_{$type}_{$subjectId}"; ?>" style="display:none;"></div>
        <?php endif; ?>
      </td>
    </tr>
  </table>
<?php endforeach; ?>
<?php else: ?>
No recent updates.
<?php endif; ?>
</div>