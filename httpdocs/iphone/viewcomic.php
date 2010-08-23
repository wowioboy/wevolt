<?php include 'includes/init.php';?>
<?php include 'includes/favorites_inc.php';
include 'includes/dbconfig.php';
$ID = $_GET['comicid'];
$ComicID = $_GET['comicid']; 
$ComicName = $_GET['comicname'];
include 'includes/dbconfig.php';
$ComicDB = new DB();
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
 $query = "select * from $comicstable where SafeFolder='$ComicName'";
     $result = mysql_query($query);
     $comic = mysql_fetch_array($result);
     $Userid = $comic['userid'];
	 $ComicID = $comic['comiccrypt'];
	 $Title = $comic['title'];
	$Genre = stripslashes($comic['genre']);
 	 $Tags = stripslashes($comic['tags']);
	 $UpdateDay = substr($comic['PagesUpdated'], 5, 2); 
	 $UpdateMonth = substr($comic['PagesUpdated'], 8, 2); 
	 $UpdateYear = substr($comic['PagesUpdated'], 0, 4);
	 $Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 	 $Short = stripslashes($comic['short']);
 	 $Synopsis = stripslashes($comic['synopsis']);
 	 $Writer = $comic['writer'];
	 $Creator = $comic['creator'];
 	 $Artist = stripslashes($comic['artist']);
	 $Letterist = stripslashes($comic['letterist']);
	 $Url = stripslashes($comic['url']);
	 $Cover = stripslashes($comic['cover']);
	 $Pages = stripslashes($comic['pages']);
	 $Hosted = $comic['Hosted'];
	 
	 if ($Cover == "") {
	 $Cover ="/images/tempcover.jpg";
	 }
	 if ($Hosted == 1) {
				//	$Cover = 'http://www.needcomics.com/'.$Cover;
					$comicURL = $Url.'/';
				} else if (($Hosted == 2) && (substr($Cover,0,4) != 'http'))  {
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $Url;
				} else {
					$comicURL = $Url;
				}
				
	//print 'COVER = ' . $Cover;
	 $fileUrl = $Cover;
	$AgetHeaders = @get_headers($fileUrl);
	//if (preg_match("|200|", $AgetHeaders[0])) {
		// file exists
	//} else {
	// $Cover ="/images/tempcover.jpg";
	//}
	 if ($_POST['vote'] == 1){
 $query = "select votes from $comicstable where comiccrypt='$ComicID'";
 $result = mysql_query($query);
 $comicvotes = mysql_fetch_array($result);
 $Votes = $comicvotes['votes'];
 $Votes++;
 $query = "UPDATE $comicstable SET votes='$Votes' comiccrypt='$ComicID'";
 $result = mysql_query($query);
}

if ($_POST['favorite'] == 1){
addfavorite($ComicID,  $Userid, $_SESSION['userid']);
}

?>
<? include 'includes/header.php';?>
<script type="text/javascript" language="javascript">
function maintab()
	{		
			//Activate TR
	        document.getElementById("trinformation").style.display = 'none';
			//Change Style of Tab
			document.getElementById("infotab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trmain").style.display = '';
			//Change Style of Tab
			document.getElementById("maintab").className ='ActiveStyle';
			//DeActivate TR
			document.getElementById("trstats").style.display = 'none';
			//Change Style of Tab
			document.getElementById("statstab").className ='NonActiveStyle';
			//DeActivate TR
			
	}
	function informationtab()
	{		
			//Activate TR
	        document.getElementById("trinformation").style.display = '';
			//Change Style of Tab
			document.getElementById("infotab").className ='ActiveStyle';
			//DeActivate TR
			document.getElementById("trmain").style.display = 'none';
			//Change Style of Tab
			document.getElementById("maintab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trstats").style.display = 'none';
			//Change Style of Tab
			document.getElementById("statstab").className ='NonActiveStyle';
			//DeActivate TR
			
	}
	function statstab()
	{		
			//Activate TR
	        document.getElementById("trinformation").style.display = 'none';
			//Change Style of Tab
			document.getElementById("infotab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trmain").style.display = 'none';
			//Change Style of Tab
			document.getElementById("maintab").className ='NonActiveStyle';
			//DeActivate TR
			document.getElementById("trstats").style.display = '';
			//Change Style of Tab
			document.getElementById("statstab").className ='ActiveStyle';
			//DeActivate TR
			
	}
	
	</script>
<div id="topbar">

<table id="topmenu" cellpadding="0px" cellspacing="0px;">
		<tr>
			<td id="startbutton"></td>
			<td class="buttonfield"><a href="/iphone/index.php">
			<img alt="Home" src="/iphone/images/Home.png" /></a></td>
			<td id="buttonend"></td>
		</tr>
	</table>
    
        
	<div id="title">
		<img src="/iphone/images/pf_logo_sm.jpg" /></div>
</div>
 <table width='100%' cellspacing=0 cellpadding=0 border=0>
  		<tr>
    	<td width='25%' id='maintab' class='ActiveStyle' height="30" onClick="maintab()">Info</td>
    	<td  width='25%'id='infotab' class='NonActiveStyle' height="30" onClick="informationtab()" >Credits</td>
        <? if ($ID == $_SESSION['userid']) { ?>
    	<td width='25%' id='statstab' class='NonActiveStyle' height="30" onClick="statstab()">Stats</td>
           <? }?>     
    	</tr>
        </table>    
<div id="content">
<div id='trmain'>
<ul class="textbox">
<div style="padding:5px;">
<li><strong>TITLE:</strong> <?php echo $Title;?> 
</li>
<li><strong>URL: </strong><a href="<?php echo $comicURL;?>" target="blank"><?php echo $comicURL;?></a></li>
<li><strong>UPDATED: </strong><?php echo $Updated;?></li>
<li><strong>PAGES: </strong><?php echo $Pages;?></li>	

<li><table width="100%"><tr><td width="150"><a href="<?php echo $comicURL;?>" target="blank"><img src="<?php echo $Cover;?>" border="2" style='border-color:#000000; width:150px; height:200px;' ></a></td><td style="padding-left:2px;" valign="top"><a href="<?php echo $comicURL;?>" target="blank"><img src="/iphone/images/read_now.jpg" border="0" /></a><br/><br/><? if ($Userid == $_SESSION['userid']) { ?>
<a href="/comicstats.php?comicid=<? echo $ComicID; ?>"><img src="/images/stats.jpg" border="0" /></a><br/><br/>
   <? } ?><?php
  $query = "select avatar, username from users where encryptid='$Userid'";
     $user = $ComicDB->queryUniqueObject($query);
$Username = $user->username;
 $Avatar = $user->avatar;
 echo "<b>CREATOR:</b><br /><a href='/iphone/profile/".trim($Username)."/'><img src='".$Avatar."' border='2' style='border-color:#000000;' width='75' height='75'></a><br />";
    
  ?>  </td></tr></table></li>


        </div></ul>
        
        </div>
        
        <div id='trinformation' style="display:none;">
        <ul class="textbox">
   <?php if ($Creator != '') { ?>
   <li class="writehere"><strong>CREATOR</strong><br/><?php echo $Creator; ?></li>
   <? }?>
     <?php if ($Writer != '') { ?>
   <li class="writehere"><strong>WRITER</strong><br/><?php echo $Writer; ?></li>
   <? }?>
     <?php if ($Artist != '') { ?>
   <li class="writehere"><strong>Artist</strong><br/><?php echo $Artist; ?></li>
   <? }?>
     <?php if ($Colorist != '') { ?>
   <li class="writehere"><strong>Colorist</strong><br/><?php echo $Colorist; ?></li>
   <? }?>
     <?php if ($Letterist != '') { ?>
   <li class="writehere"><strong>Letterist</strong><br/><?php echo $Letterist; ?></li>
   <? }?>
     <?php if ($Synopsis != '') { ?>
   <li class="writehere"><strong>Synopsis</strong><br/><?php echo nl2br($Synopsis); ?></li>
   <? }?>
    <?php if ($Genre != '') { ?>
   <li class="writehere"><strong>Genre</strong><br/><?php echo nl2br($Genre); ?></li>
   <? }?>
      <?php if ($Tags != '') { ?>
   <li class="writehere"><strong>Tags</strong><br/><?php echo nl2br($Tags); ?></li>
   <? }?>
   </ul>
 	</div>
    
    <div id='trstats' style="display:none;"><ul class="textbox"> <li class="writehere"></li></ul></div>
<?php if ($ID == $_SESSION['userid']) { ?>
 

<div class="graytitle">
		Comic Controls </div>
	<ul class="menu">
    <li><a href="/iphone/comicstats.php?id=<? echo $ComicID;?>"><span class="menuname">Comic Stats</span><span class="arrow"></span></a></li>
			
	</ul>
	
</div>
<? } ?>
	<div class="graytitle">
		Menu </div>
	<ul class="menu">
    <li><a href="comics.php"><img alt="" src="/iphone/images/comic.png" /><span class="menuname">Comics</span><span class="arrow"></span></a></li>
			<li><a href="creators.php"><img alt="" src="/iphone/images/creator.png" /><span class="menuname">Creators</span><span class="arrow"></span></a></li>
        <? if (loggedin == 1) { ?>
		<li><a href="/profile/<? echo $Username;?>/"><img alt="" src="thumbs/help.png" /><span class="menuname">My Profile</span><span class="arrow"></span></a></li>
        <? }?>
          <? if (loggedin != 1) { ?>
        <li><a href="login.php"><span class="menuname">Login</span><span class="arrow"></span></a></li>
        <li><a href="register.php"><span class="menuname">Free Registration</span><span class="arrow"></span></a></li>
        <? }?>
	</ul>
	
</div>
<? include 'includes/footer.php';?>
