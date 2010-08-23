<? 
function getUserInfo($UserID,$ProjectID) {
global $InitDB;
$query = "select us.*, (select count(*) from pf_subscriptions as s where s.UserID=us.UserID) as IsPro, (select count(*) from fan_invitations as f where (f.UserID=us.UserID and f.ProjectID = '$ProjectID' and f.Status='active')) as ProInvite 
          from users_settings as us
			  
		  where us.UserID ='$UserID'"; 

$UserSettingsArray = $InitDB->queryUniqueObject($query);



//print $query;
$_SESSION['readerstyle'] = $UserSettingsArray->ReaderStyle;
$_SESSION['tooltips'] = $UserSettingsArray->ToolTips;

if ($_SESSION['newflashpages'] != '') { 
	$_SESSION['flashpages'] = $_SESSION['newflashpages'];
	$_SESSION['newflashpages'] = '';
} else {	
	$_SESSION['flashpages'] = $UserSettingsArray->FlashPages;
}

if ($UserSettingsArray->IsPro > 0)
	$_SESSION['IsPro'] = 1;
else
	$_SESSION['IsPro'] = 0;
	
if (($UserSettingsArray->ProInvite > 0) && ($UserSettingsArray->ProInvite != ''))
	$_SESSION['ProInvite'] = 1;
else
	$_SESSION['ProInvite'] = 0;

return $UserSettingsArray;

}




?>