<?php 
include_once('../includes/init.php'); 
$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);

$userid = $_SESSION['userid'];
$range = $_GET['range'];

$queries = array();
if ($range == 'today') {
	// get everything for today 
	$queries[] = "select * 
				  from calendar 
				  where user_id = '$userid' 
				  and curdate() = date(start)";
	// get non custom repeating days 
	$queries[] = "select * 
				  from calendar 
				  where user_id = '$userid' 
				  and date(start) <= curdate()
				  and frequency = 'day'
				  and custom != '1' 
				  and mod(datediff(now(), start), `interval`) = 0";
	// get non custom repeating weeks 
	$queries[] = "select * 
				  from calendar 
				  where user_id = '$userid' 
				  and date(start) <= curdate()
				  and frequency = 'week'
				  and custom != '1' 
				  and ceil(mod(datediff(now(), start) / 7, `interval`)) = 0";
	// get non custom repeating months 
	$queries[] = "select * 
				  from calendar 
				  where user_id = '$userid' 
				  and date(start) <= curdate()
				  and frequency = 'month'
				  and custom != '1' 
				  and mod(period_diff(date_format(now(), '%Y%m'), date_format(start, '%Y%m')), `interval`) = 0 
				  and day(start) = day(now())";
	// get custom weeks 
	$queries[] = "select * 
				  from calendar 
				  where user_id = '$userid' 
				  and date(start) <= curdate()
				  and frequency = 'week' 
				  and custom = '1'
				  and week_day like concat('%', weekday(now()) + 1, '%') 
				  and mod(abs(weekofyear(now()) - weekofyear(start)), `interval`) = 0";
	// get custom months
	$queries[] = "select * 
				  from calendar 
				  where user_id = '$userid' 
				  and date(start) <= curdate()
				  and frequency = 'month'
				  and custom = '1'
				  and week_day like concat('%', weekday(now()) + 1, '%') 
				  and if (dayofweek(now()) < dayofweek(concat(date_format(now(), '%Y-%m-'), '01')), ceil(day(now()) / 7), ceil(day(now()) / 7 + 1)) = week_number 
				  and mod(period_diff(date_format(now(), '%Y%m'), date_format(start, '%Y%m')), `interval`) = 0";
} else if ($range == 'week') {
	$date = new DateTime();
	$interval = $date->format('N') - 1;
	$date->modify("-$interval day");
	for ($i = 0; $i < 7; $i++) {
		$dateString = $date->format('Y-m-d');
		$queries[] = "select * 
				      from calendar 
				      where user_id = '$userid' 
				      and '$dateString' = date(start)";
		// get non custom repeating days 
		$queries[] = "select * 
					  from calendar 
					  where user_id = '$userid' 
					  and date(start) <= '$dateString'
					  and frequency = 'day'
					  and custom != '1' 
					  and mod(datediff('$dateString', start), `interval`) = 0";
		// get non custom repeating weeks 
		$queries[] = "select * 
					  from calendar 
					  where user_id = '$userid' 
					  and date(start) <= '$dateString'
					  and frequency = 'week'
					  and custom != '1' 
					  and ceil(mod(datediff('$dateString', start) / 7, `interval`)) = 0";
		// get non custom repeating months 
		$queries[] = "select * 
					  from calendar 
					  where user_id = '$userid' 
					  and date(start) <= '$dateString'
					  and frequency = 'month'
					  and custom != '1' 
					  and mod(period_diff(date_format('$dateString', '%Y%m'), date_format(start, '%Y%m')), `interval`) = 0 
					  and day(start) = day('$dateString')";
		// get custom weeks 
		$queries[] = "select * 
					  from calendar 
					  where user_id = '$userid' 
					  and date(start) <= '$dateString'
					  and frequency = 'week' 
					  and custom = '1'
					  and week_day like concat('%', weekday('$dateString') + 1, '%') 
					  and mod(abs(weekofyear('$dateString') - weekofyear(start)), `interval`) = 0";
		// get custom months
		$queries[] = "select * 
					  from calendar 
					  where user_id = '$userid' 
					  and date(start) <= '$dateString'
					  and frequency = 'month'
					  and custom = '1'
					  and week_day like concat('%', weekday('$dateString') + 1, '%') 
					  and if (dayofweek('$dateString') < dayofweek(concat(date_format('$dateString', '%Y-%m-'), '01')), ceil(day('$dateString') / 7), ceil(day('$dateString') / 7 + 1)) = week_number 
					  and mod(period_diff(date_format('$dateString', '%Y%m'), date_format(start, '%Y%m')), `interval`) = 0";
		$date->modify('+1 day');	
	}
}
$query = implode(' union ', $queries);
$events = @$db->fetchAll($query);
?>
<div align="left">
<?php if (!empty($events)) : ?>
<?php foreach ($events as $row) : ?>
  <?php 
    $title = $row['title'];
    if ($title && strlen($title) > 25) {
    	$title = substr($title, 0, 25) . '...';
    }
    $thumb = $row['thumb'];
//    $link = $row['url'];
    $type = $row['type'];
    $id = $row['id'];
    $encryptId = $row['encrypt_id'];
    $date = new DateTime($row['start']); 
    $date = $date->format('F jS, Y @ g:i a'); 
  ?>
  <table class="update">
    <tr>
      <td style="width:50px;" valign="middle">
        <?php if ($thumb) : ?>
        <img src="<?php echo $thumb; ?>" width="50" height="50" />
        <?php endif; ?>
      </td>
      <td>
        <table width="100%">
          <tr>
            <td>
              <b><?php echo $type; ?></b>
            </td>
            <td align="right">
              <a href="javascript:open_event_wizard('edit', '<?php echo $encryptId; ?>');">
                <img style="border:none;" src="http://www.wevolt.com/images/silk/edit_off.png" />
              </a>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <a href="javascript:view_event('view', '<?php echo $id; ?>');"><?php echo $title; ?></a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
<?php endforeach; ?>
<?php else: ?>
There are no events right now.
<?php endif; ?>
</div>