<?php 
include $_SERVER['DOCUMENT_ROOT'].'/includes/init.php';
$db = new DB(PANELDB, PANELDBHOST, PANELDBUSER, PANELDBPASS);
if ($_POST['action'] == 'delete') {
	$id = $_POST['id'];
	$db->query("delete from calendar where id = '$id'");
} else {
	$start = date('Y-m-d H:i:s', $_REQUEST['start']);
	$end = date('Y-m-d H:i:s', $_REQUEST['end']);
	$userid = $_GET['userid'];
	$query = "select *
			  from calendar 
			  where user_id = '$userid' 
			  and deleted = '0'
			  and start <= '$end'";
	if ($type = $_REQUEST['type']) {
		if ($type != 'all') {
			$query .= " and type = '$type'";
		}
	}
	$query .= " and (start >= '$start'
			  or frequency = 'day' 
			  or frequency = 'week'
			  or frequency = 'month')";
	$results = $db->query($query);
	$events = array();
	$startDate = new DateTime($start);
	$endDate = new DateTime($end);
	$y = $startDate->format('Y');
	$m = $startDate->format('m');
	$endDate->modify('-1 day');
	if ($endDate->format('Y-m-d') != $startDate->format('Y-m-d')) {
		$endDate = new DateTime($end);
		$endDate->modify('-7 day');
		if ($endDate->format('Y-m-d') != $startDate->format('Y-m-d')) {
			$endDate = new DateTime($end);
			$endDate->modify('-1 month');
			if ($endDate->format('m') != $startDate->format('m')) {
				$m++;
				if ($m == 13) {
					$m = 1;
					$y++;
				}	
			}
		}
	}
	while ($row = mysql_fetch_assoc($results)) {
		$startDate = new DateTime($row['start']);
		$endDate = new DateTime($row['end']);
		$frequency = $row['frequency'];
		$weekDays = explode(',', $row['week_day']);
		$w = $row['week_number'];
		if (!$interval = $row['interval']) {
			$interval = 1;	
		}
		
		if ($frequency = $row['frequency']) {
			if ($row['custom']) {
				if ($frequency == 'month') {
					$startMonth = $startDate->format('m');
					$im = $m - $startMonth;
					if ($im % $interval == 0) {
				    	$newStart = clone $startDate;
				    	$newEnd = clone $endDate;
						$newStart->setDate($y, $m, $startDate->format('d'));
				    	$newEnd->setDate($y, $m, $endDate->format('d'));
				    	foreach ($weekDays as $dow) {
							$startClone = clone $newStart;
							$endClone = clone $newEnd;
							$date = new DateTime();
							$date->setDate($y, $m, 1);
							$n = $date->format('N');
							$t = $date->format('t');
							if ($n == $dow) {
								$n = 0;
							} elseif ($n < $dow) {
								$n = $dow - $n;
							} elseif ($n > $dow) {
								$n = 7 - $n + $dow;
							}
							$n += 7 * ($w - 1);
							while ($n > $t - 1) {
								$n -= 7;
							}
							$date->modify("+$n day");
							$d = (int) $date->format('d');
							$startDay = $startClone->format('d');
					    	if ($d < $startDay) {
					    		$n = $startDay - $d;
					    		$startClone->modify("-$n day");
					    		$endClone->modify("-$n day");
					    	} elseif ($d > $startDay) {
					    		$n = $d - $startDay;
					    		$startClone->modify("+$n day");
					    		$endClone->modify("+$n day");
					    	}
					    	if ($startClone->format('Y-m-d') >= $startDate->format('Y-m-d')) {
						    	$row['start'] = $startClone->format('Y-m-d H:i:s');
								$row['end'] = $endClone->format('Y-m-d H:i:s');
								$events[] = $row;
					    	}
				    	}
					}
				} elseif ($frequency == 'week') {
					$startDay = $startDate->format('N');
					foreach ($weekDays as $dow) {
						$startClone = clone $startDate;
						$endClone = clone $endDate;
						if ($startDay > $dow) {
							$n = $startDay - $dow;
							$startClone->modify("-$n day");
							$endClone->modify("-$n day");
						} elseif ($startDay < $dow) {
							$n = $dow - $startDay;
							$startClone->modify("+$n day");
							$endClone->modify("+$n day");
						}
						while ($startClone->format('Y-m-d') <= $end) {
							if ($startClone->format('Y-m-d') >= $startDate->format('Y-m-d')) {
								$row['start'] = $startClone->format('Y-m-d H:i:s');
								$row['end'] = $endClone->format('Y-m-d H:i:s');
								$events[] = $row;
							}
							$startClone->modify("+$interval week");
							$endClone->modify("+$interval week");
						}
					}
				}
			} else {
				$startClone = clone $startDate;
				$endClone = clone $endDate;
				while ($startClone->format('Y-m-d') <= $end) {
			    	if ($startClone->format('Y-m-d') >= $startDate->format('Y-m-d')) {
						$row['start'] = $startClone->format('Y-m-d H:i:s');
						$row['end'] = $endClone->format('Y-m-d H:i:s');
						$events[] = $row;
			    	}
					$startClone->modify("+$interval $frequency");
					$endClone->modify("+$interval $frequency");
				}
			}
		} else {
			$events[] = $row;
		}
	}
	echo json_encode($events);
}