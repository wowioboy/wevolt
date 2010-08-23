<? include 'includes/init.php';
$PageTitle = 'Iphone Version';
?>
<? include 'includes/header.php';?>

<div id="topbar">
	<div id="title">
		<img src="images/pf_logo_sm.jpg" /></div>
</div>
<div id="content">
	<div class="graytitle">
		Welcome to Panel Flow </div>
	<ul class="textbox">
		<li class="writehere"><span class="header">News</span>
		  <p>Panel Flow 1.5 soon to be released. </p>
			</ul>
	<div class="graytitle">
		Menu </div>
	<ul class="menu">
		<li><a href="comics.php"><img alt="" src="images/comic.png" /><span class="menuname">Browse Comics</span><span class="arrow"></span></a></li>
		<li><a href="creators.php"><img alt="" src="images/creator.png" /><span class="menuname">Creators</span><span class="arrow"></span></a></li>
        <? if (loggedin == 1) { ?>
		<li><a href="/profile/<? echo $Username;?>/"><img alt="" src="thumbs/help.png" /><span class="menuname">My Profile</span><span class="arrow"></span></a></li>
        <? }?>
        <li><a href="login.php"><span class="menuname">Login</span><span class="arrow"></span></a></li>
        <li><a href="register.php"><span class="menuname">Free Registration</span><span class="arrow"></span></a></li>
	</ul>
	
</div>
<? include 'includes/footer.php';?>
