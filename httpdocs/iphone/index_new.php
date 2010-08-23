<? include 'includes/init.php';
$PageTitle = 'Iphone Version';
?>
<? include 'includes/header.php';?>
 <div class="toolbar">
        <h1 id="pageTitle"></h1>
        <a id="backButton" class="button" href="#"></a>
        <a class="button" href="#searchForm">Search</a>
</div>
    
    <ul id="home" title="Panel Flow" selected="true">
        <li><a href="#news">news</a></li>
        <li><a href="#comics">comics</a></li>
         <li><a href="#creators">creators</a></li>
          <li><a href="#blog">blog</a></li>
           <li><a href="login.php" target="_self">Login</a></li>
        <li><a href="register.php" target="_self">register</a></li>
        <li>Nothing</li>
    </ul>
    <ul id="news" title="News">
        <li class="group">Recent News</li>
        <li><a href="#recent1">Panel Flow 1.5</a></li>
        <li><a href="#recent2">Iphone Version</a></li>
    </ul>
    <div id="recent1" class="panel" title="recent1">
        <h2>Panel Flow 1.5 Soon to be released!</h2>
    </div>
     <div id="recent2" class="panel" title="recent2">
        <h2>We're building a new Iphone version of the website. </h2>
    </div>
    
    <form id="searchForm" class="dialog" action="comics.php">
        <fieldset>
            <h1>Comic Search</h1>
            <a class="button leftButton" type="cancel">Cancel</a>
            <a class="button blueButton" type="submit">Search</a>
            
            <label>Keywords:</label>
            <input id="txtKeywords" type="text" name="txtKeywords"/>
            </fieldset>
    </form>

    <div id="settings" title="Settings" class="panel">
        <h2>Playback</h2>
        <fieldset>
            <div class="row">
                <label>Repeat</label>
                <div class="toggle" onclick=""><span class="thumb"></span><span class="toggleOn">ON</span><span class="toggleOff">OFF</span></div>
            </div>
            <div class="row">
                <label>Shuffle</label>
                <div class="toggle" onclick="" toggled="true"><span class="thumb"></span><span class="toggleOn">ON</span><span class="toggleOff">OFF</span></div>
            </div>
        </fieldset>
        
        <h2>User</h2>
        <fieldset>
            <div class="row">
                <label>Name</label>
                <input type="text" name="userName" value="johnappleseed"/>
            </div>
            <div class="row">
                <label>Password</label>
                <input type="password" name="password" value="delicious"/>
            </div>
            <div class="row">
                <label>Confirm</label>
                <input type="password" name="password" value="delicious"/>
            </div>
        </fieldset>
    </div>
    
<div id="topbar">
	<div id="title">
		</div>
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
