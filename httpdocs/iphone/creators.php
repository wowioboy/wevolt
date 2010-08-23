<?php 
include 'includes/init.php';
include 'includes/dbconfig.php';  
$PageTitle = ' | Comics Listing';
$Page = $_GET['page'];
$search = $_POST['txtSearch'];
if ($Page == "")
  $Page = '1';
$Genre = $_GET['genre']; 
$genreString = $Genre;
 
$sort = $_GET['sort']; 
if ($sort == "") {
$sort = 1;
}

 if ($Genre == ""){
$query = "select encryptid, username, date, avatar, location from $usertable where iscreator=1 ORDER BY username DESC";
} else {
$query = "SELECT encryptid, username, date, avatar,location  FROM $usertable WHERE username LIKE '%$Name%' and iscreator=1 ORDER BY title DESC";
}
 if ((isset($search)) && ($search != "")) {
			$search = trim($search);
			$search = preg_replace('/\s+/', ' ', $search);

			//seperate multiple keywords into array space delimited
			$keywords = explode(" ", $search);

			//Clean empty arrays so they don't get every row as result
			$keywords = array_diff($keywords, array(""));

			//Set the MySQL query
			if ($search == NULL or $search == '%'){
			} else {
				for ($i=0; $i<count($keywords); $i++) {
				
				$query = "SELECT * FROM users WHERE username LIKE '%".$keywords[$i]."%' or location LIKE '%".$keywords[$i]."%' and iscreator=1 ORDER BY username DESC";
				
				}
						
				}
			} else {
$query = "select * from users where iscreator=1  ORDER BY username DESC";
}

$NumPerPage = 10;
$PageTitle = 'Creators Listing';
$Results = 0;
$comicString = "<table width='100%'><tr>";
	 $settings = new DB();
	
	//$query = "select encryptid, username, date, avatar, location from $usertable where iscreator=1 ORDER BY username DESC";
	$settings->query($query);
	 $Count = 0;
       $KeyCount = 0; 
	   $counter = 0;
			$Results = 1;
       $NextPage = false;
    	while ($content = $settings->fetchNextObject()) { 
          $Count++;
		  // print "MY count = " .  $Count;
		    //print "MY Page = " .  $Page;
          if (( $Count > (($Page-1) * $NumPerPage)) && 
              ( $Count < ($Page * $NumPerPage))){ 
              
                $KeyCount++; // print "MY comiccrypt = " . $content->comiccrypt;
               $UpdateDay = substr($content->joindate, 5, 2); 
				$UpdateMonth = substr($content->joindate, 8, 2); 
				$UpdateYear = substr($content->joindate, 0, 4);
				$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 				$comicString .= "<td valign='top' align='center'><div style='width:100px;'><div class='comictitlelist'>".$content->username."</div><a href=/iphone/profile/".$content->username."/><img src='".$content->avatar."' border='2' alt='LINK' style='border-color:#000000;' width='75' height='75'></a>";
				
		if ($content->location != '') {
 				$comicString .= "<br/><span class='updated'>".$content->location."</span>";
 
 		}
 		$comicString .= "</div></td>";
 		$counter++;
 		if ($counter == 3){
 			$comicString .= "</tr><tr>";
	 		$counter = 0;
 		}
 			}
			 if ($Count == ($Page * $NumPerPage)) {
              $NextPage = true;
              break;
          }
	//Display the full navigation in one go
}
	$comicString .= "</tr></table>";
?>
<? include 'includes/header.php';?>
<div id="topbar">

<table id="topmenu" cellpadding="0px" cellspacing="0px;">
		<tr>
			<td id="startbutton"></td>
			<td class="buttonfield"><a href="index.php">
			<img alt="Home" src="images/Home.png" /></a></td>
             <? if ($Page != '1') { ?>
			<td class="buttonlink"></td>
			<td class="buttonfield"> <a href="creators.php?<? echo $PageQS; ?>&amp;<? echo $InitFieldsQS; ?>&amp;page=<? echo $Page - 1; ?>">Prev</a></td>
            <? }?>
			<td id="buttonend"></td>
		</tr>
	</table>
     <? if ($NextPage) { ?>
	<table id="toprightmenu" cellpadding="0px" cellspacing="0px;">
		<tr>
			<td id="buttonbegin"></td>
			<td class="buttonfield"><a href="imagelist.html"><a href="creators.php?<? echo $PageQS; ?>&amp;<? echo $InitFieldsQS; ?>&amp;page=<? echo $Page + 1; ?>">Next</a></td>
			<td id="buttonstartright"></td>
		</tr>
	</table>
    <? }?>
        
	<div id="title">
		<img src="images/pf_logo_sm.jpg" /></div>
</div>
<div id="content">
	
	<ul class="textbox">
		<li class="writehere">search the creator database
		  <form method="post" action="#"><input type='text' name='txtSearch' style="width:95%"/><input type="submit" name='btnSubmit' value='search' style="width:100%" /></form></li>
			</ul>
       <div class="graytitle">
		Creator Listing</div>     
     <table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td>
     <? echo $comicString;?>
	</td></tr></table>       
            
	<div class="graytitle">
		Menu </div>
	<ul class="menu">
			<li><a href="comics.php"><img alt="" src="images/comic.png" /><span class="menuname">Comics</span><span class="arrow"></span></a></li>
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
