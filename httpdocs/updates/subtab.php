<?php 
$filter = $_GET['filter'];
?>
<script>
$(document).ready(function(){
	$('#<?php echo $filter; ?>_subtabs').tabs();
});
</script>
<div id="<?php echo $filter; ?>_subtabs">
  <ul>
    <?php if ($filter == 'calendar') : ?>
     <li><a href="/updates/calendar-view.php?range=today"><span>Today</span></a></li>
    <li><a href="/updates/calendar-view.php?range=week"><span>This Week</span></a></li>
    <?php else : ?>
    <li><a href="/updates/view.php?type=project&filter=<?php echo $filter; ?>"><span>Projects</span></a></li>
    <li><a href="/updates/view.php?type=user&filter=<?php echo $filter; ?>"><span>Users</span></a></li>
    <?php endif; ?>
  </ul>
</div>