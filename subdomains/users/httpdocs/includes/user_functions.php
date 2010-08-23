<? 
function getUserInfo($UserID,$ProjectID) {
global $InitDB;
$query = "select us.*, s.ID as IsPro, f.ID as ProInvite
          from users_settings as us
		  left join pf_subscriptions as s on s.UserID=us.UserID and s.Status='active'
		  left join fan_invitations as f on (f.UserID=us.UserID and f.ProjectID = '$ProjectID' and f.Status='active')
		  
		  where us.UserID ='$UserID'"; 
$UserSettingsArray = $InitDB->queryUniqueObject($query);


$_SESSION['readerstyle'] = $UserSettingsArray->ReaderStyle;
$_SESSION['flashpages'] = $UserSettingsArray->FlashPages;

if ($UserSettingsArray->IsPro > 0)
	$_SESSION['IsPro'] = 1;
else
	$_SESSION['IsPro'] = 0;
	
if (($UserSettingsArray->ProInvite > 0) && ($UserSettingsArray->ProInvite != ''))
	$_SESSION['ProInvite'] = 1;
else
	$_SESSION['ProInvite'] = 0;

if ($_SESSION['readerstyle'] == '') {
	$_SESSION['readerstyle'] = 'flash';
	$_SESSION['flashpages'] = '2';

}

return $UserSettingsArray;

}




?>