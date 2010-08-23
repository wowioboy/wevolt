<? 
$db = new DB();
$where ='';
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


$query = "select max(u.id) as `id`
		  from updates u 
		  $join  
		  where u.actionsection in $actions 
		  and $content 
		  and u.userid != '$userid' 
		  and (u.live_date is null or u.live_date < now())
		  $where 
		  group by $group			  
		  order by id desc
		  limit 5";
$results = @$db->fetchCol($query);
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
$db->close();
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
   // if ($type == 'project') {
    	$thumb = 'http://www.wevolt.com' . $thumb;
    //}
    if (!is_array(@getimagesize($thumb))) {
		$thumb = "/images/no_thumb_project.jpg";	
	}
    $following = $row['following'];
    $link = $row['link'];
    $action = $row['action'];
    $subject = $row['subject'];
    $title = stripslashes($row['title']);
    $username = $row['username'];
  ?>
  <table id="<?php echo $subjectId . '_' . $type . '_' . $filter; ?>">
    <tr>
    <?php if ($_SESSION['userid']) : ?> 
     <td width="17"  valign="top"><a href="javascript:void(0)" onclick="follow_content('<?php echo $subjectId; ?>','project','follow_<?php echo $subjectId; ?>');">	
	<img src="http://www.wevolt.com/images/vert_sm_follow.png" id="follow_<?php echo $subjectId; ?>" border="0">
	</a>
    </td>
    <?php endif; ?>
      <td style="width:34px;" valign="top" align="right">
        <?php if ($thumb) : ?><img src="<?php echo $thumb; ?>" width="34" height="34" />
        <?php endif; ?>
      </td>
      <td valign="top">
        <table width="100%">
          <tr>
            <td valign="top">
	           <div class="feed_title"><a href="http://users.wevolt.com/<?php echo $username; ?>/"><?php if ($subject == 'series' || $subject == 'strip') : ?>
                <?php echo $username; ?>
              <?php else: ?>
  	            <?php echo $name; ?>
              <?php endif; ?></a></div>
            </td>
           </tr>
          <tr>
            <td valign="top" >
            <div class="feed_text">
              <?php if ($subject == 'excite') : ?>
              <a href="<?php echo $link; ?>" target="_blank"><?php echo $title; ?></a>
           
              <?php echo "\"$comment\""; ?>
              <?php else: ?>
              <?php 
                echo $action;
                echo ($title) ? ' ' . $subject . ': ' : ''; 
              ?> 
             
             
              <a href="<?php echo $link; ?>"><?php echo ($title) ? $title : $subject; ?></a>
			  </div>
              <div class="feed_date">
			  <?php echo ($subject == 'page') ? $date->format('F jS, Y') : $date->format('F jS, Y @ g:i a'); ?>
              <?php endif; ?>
              </div>
            </td>
           
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php endforeach; ?>
<?php else: ?>
No recent updates.
<?php endif; ?>
</div>