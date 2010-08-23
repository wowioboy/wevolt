<div align="left" class="usermenu2">
<? if ($loggedin == 1) { ?>
 Welcome, <? echo $_SESSION['username'];?>  [<a href="/logout.php">logout</a>]<br />
	<?	} else { ?>
	LOG IN HERE!
    
    <? }?></div> 