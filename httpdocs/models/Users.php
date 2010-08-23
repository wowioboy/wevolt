<?php
class Users
{
	const XP_INCREMENT = 2.6;
	public function addxp(&$db, $user, $xp = 10)
	{
		$rank = $this->getxp($db, $user);
		$rank->xp += $xp;
		$Output .= ' ADD XP AMOUNT ' . $xp.'<br/>';
		$query = "xp = '{$rank->xp}'";
		$Output .= ' rank->xp ' . $rank->xp.'<br/>';
		if ($rank->xp >= $rank->next_level) {
			$rank->level++;
			$query .= ", level = '{$rank->level}'";
		}
		$query = "update users set $query where (encryptid = '$user' || userid = '$user' || username = '$user')";
		$db->execute($query);
		$Output .= $query;
		return $Output;
	}
		
	public function getxp(&$db, $user)
	{
		$query = "select xp, level from users where (encryptid = '$user' || userid = '$user' || username = '$user')";
		$rank = $db->queryUniqueObject($query);
		$rank->next_level = (self::XP_INCREMENT * $rank->level) * 1000;
		$rank->percent = ($rank->xp - (($rank->level - 1) * Users::XP_INCREMENT * 1000)) / (self::XP_INCREMENT * 1000);
		return $rank;
	}
}