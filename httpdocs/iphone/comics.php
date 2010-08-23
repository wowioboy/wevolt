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
$sort = 3;
}




$NumPerPage = 10;
$PageTitle = 'Comics Listing';
$Results = 0;
echo "<table width='100%'><tr>";
	 $settings = new DB();
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
				
				if ($sort == 1) {
				$query = "SELECT * FROM comics " .
						"WHERE installed = 1 and published = 1 and title LIKE '%".$keywords[$i]."%'".
					" OR creator LIKE '%".$keywords[$i]."%'" .
					" OR writer LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR colorist LIKE '%".$keywords[$i]."%'" .
					" OR letterist LIKE '%".$keywords[$i]."%'" .
					" OR synopsis LIKE '%".$keywords[$i]."%'" .
					" OR short LIKE '%".$keywords[$i]."%'" .
					" OR url LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR tags LIKE '%".$keywords[$i]."%'" .
					" OR genre LIKE '%".$keywords[$i]."%'" .
					" ORDER BY title ASC";
				
				} else if ($sort == 2) {
				$query = "SELECT * FROM comics " .
						"WHERE installed = 1 and and published = 1 and title LIKE '%".$keywords[$i]."%'".
					" OR creator LIKE '%".$keywords[$i]."%'" .
					" OR writer LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR colorist LIKE '%".$keywords[$i]."%'" .
					" OR letterist LIKE '%".$keywords[$i]."%'" .
					" OR synopsis LIKE '%".$keywords[$i]."%'" .
					" OR short LIKE '%".$keywords[$i]."%'" .
					" OR url LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR tags LIKE '%".$keywords[$i]."%'" .
					" OR genre LIKE '%".$keywords[$i]."%'" .
					"  ORDER BY PagesUpdated DESC";
				 
				} else if ($sort == 3) {
				$query = "SELECT * FROM comics " .
						"WHERE installed = 1 and published = 1 and title LIKE '%".$keywords[$i]."%'".
					" OR creator LIKE '%".$keywords[$i]."%'" .
					" OR writer LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR colorist LIKE '%".$keywords[$i]."%'" .
					" OR letterist LIKE '%".$keywords[$i]."%'" .
					" OR synopsis LIKE '%".$keywords[$i]."%'" .
					" OR short LIKE '%".$keywords[$i]."%'" .
					" OR url LIKE '%".$keywords[$i]."%'" .
					" OR artist LIKE '%".$keywords[$i]."%'" .
					" OR tags LIKE '%".$keywords[$i]."%'" .
					" OR genre LIKE '%".$keywords[$i]."%'" .
					" ORDER BY PagesUpdated DESC";
				
				}
						
				}
			}	
} else {
$query = "select * from comics where installed=1 and published = 1 order by PagesUpdated DESC";
}
		$comicString = "<table width='100%'><tr>";
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
               $UpdateDay = substr($content->PagesUpdated, 5, 2); 
				$UpdateMonth = substr($content->PagesUpdated, 8, 2); 
				$UpdateYear = substr($content->PagesUpdated, 0, 4);
				$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 				$comicString .= "<td valign='top' width='150'><div align='center'><a href='/iphone/".urlencode($content->SafeFolder)."/'>";
			
				
				if ($content->Hosted == 1) {
					$fileUrl = 'http://www.panelflow.com/'.$content->thumb;
					$comicURL = $content->url.'/';
				} else if (($content->Hosted == 2) && (substr($content->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.panelflow.com/'.$content->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $content->url;
				} else {
					$fileUrl = $content->thumb;
					$comicURL = $content->url;
				}
		    	//$AgetHeaders = @get_headers($fileUrl);
			//if (preg_match("|200|", $AgetHeaders[0])) {
				$comicString .= "<img src='".$fileUrl."' alt='LINK'  style='border:#000000 2px solid; width:60px; height:80px;'>";
			//} else {
			// $comicString .= "<img src='images/tempcover_thumb.jpg'  alt='LINK' style='border:#000000 2px solid;width:60px; height:80px;'>";
			//}
			$comicString .= "</a><div class='comictitlelist'>".stripslashes($content->title)."</div><div class='smspacer'></div><div class='moreinfo'><div class='updated'>updated: <b>".$Updated."</b></div><div class='pages'>Pages: ".$content->pages."</div></div></td>"; 
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
			<td class="buttonfield"> <a href="comics.php?<? echo $PageQS; ?>&amp;<? echo $InitFieldsQS; ?>&amp;page=<? echo $Page - 1; ?>">Prev</a></td>
            <? }?>
			<td id="buttonend"></td>
		</tr>
	</table>
     <? if ($NextPage) { ?>
	<table id="toprightmenu" cellpadding="0px" cellspacing="0px;">
		<tr>
			<td id="buttonbegin"></td>
			<td class="buttonfield"><a href="imagelist.html"><a href="comics.php?<? echo $PageQS; ?>&amp;<? echo $InitFieldsQS; ?>&amp;page=<? echo $Page + 1; ?>">Next</a></td>
			<td id="buttonstartright"></td>
		</tr>
	</table>
    <? }?>
        
	<div id="title">
		<img src="images/pf_logo_sm.jpg" /></div>
</div>
<div id="content">
	
	<ul class="textbox">
		<li class="writehere">search the comics database<form method="post" action="#"><input type='text' name='txtSearch' style="width:95%"/><input type="submit" name='btnSubmit' value='search' style="width:100%" /></form></li>
			</ul>
       <div class="graytitle">
		Comics Listing</div>     
    <ul class="textbox">
		<li class="writehere">
     <? echo $comicString;?>
	</li></ul>     
            
	<div class="graytitle">
		Menu </div>
	<ul class="menu">
			<li><a href="creators.php"><img alt="" src="images/creator.png" /><span class="menuname">Creators</span><span class="arrow"></span></a></li>
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
