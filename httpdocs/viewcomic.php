<?php
if ($_GET['comicname'] == 'register') { 
	include 'register.php';
	$ShowLogin = false;
}else if ($_GET['comicname'] == 'login') { 
	include 'login.php';
	$ShowLogin = false;
} else if ($_GET['comicname'] == 'forgot') { 
	include 'forgot.php';
	$ShowLogin = false;
} else if ($_GET['comicname'] == 'blog') { 
	include 'blog.php';
	$ShowLogin = true;
} else if ($_GET['comicname'] == 'comics') { 
	include 'comics.php';
	$ShowLogin = true;
}else if ($_GET['comicname'] == 'creators') { 
	include 'creators.php';
	$ShowLogin = true;
} else if ($_GET['comicname'] == 'faq') { 
	include 'faq.php';
	$ShowLogin = true;
}else if ($_GET['comicname'] == 'contact') { 
	include 'contact.php';
	$ShowLogin = true;
} else if ($_GET['comicname'] == 'mobile') { 
	include 'mobile.php';
	$ShowLogin = true;
}else if ($_GET['comicname'] == 'products') { 
	include 'products.php';
	$ShowLogin = true;
}else if ($_GET['comicname'] == 'sendcontent') { 
	include 'send_to_mobile.php';
	$ShowLogin = false;
} else if ($_GET['comicname'] == 'sendcomplete') {
include 'sendcomplete.php';
$ShowLogin = false;
}else if ($_GET['comicname'] == 'download') { 
	header("location:/go/pro/");
}else {
include 'includes/init.php';
include 'includes/favorites_inc.php';
$DB = new DB();

?>
<?php 
$ID = $_GET['comicid'];
$ComicID = $_GET['comicid']; 
$SafeFolder = urldecode($_GET['comicname']);
$UserID = $_SESSION['userid'];
include 'includes/dbconfig.php';
$ComicDB = new DB();
mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
mysql_select_db ($userdb) or die ('Could not select database.');
 $query = "select c.*, u.encryptid, u.IsPublisher, u.PublisherURL, u.PublisherLogo, u.PublisherName,u.avatar, r.* from $comicstable as c
 			join rankings as r on r.ComicID=c.comiccrypt
			join users as u on u.encryptid=c.userid
			 where c.SafeFolder='$SafeFolder'";
     $result = mysql_query($query);
     $comic = mysql_fetch_array($result);

     $Userid = $comic['userid'];
	 
	 $ComicTitle = $comic['title'];
	 $CreatorID = $comic['CreatorID'];
	 $ComicID = $comic['comiccrypt'];
	 
	  $IsPublisher = $comic['IsPublisher'];
	  $PublisherURL = $comic['PublisherURL'];
	  $PublisherLogo = $comic['PublisherLogo'];
	  $PublisherName = $comic['PublisherName'];
	   $PublisherID = $comic['encryptid'];
	  $PublisherAvatar = $comic['avatar'];
	   
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
	 $Rank = $comic['Rank'];

	 if ($Cover == "") {
		 $Cover ="/images/tempcover.jpg";
	 }
	 	 
	 	if ( $Hosted == 1) {
				$fileUrl = $Cover;
				$Url = $Url.'/';
		} else {
				$fileUrl =$Cover;
		}
	$AgetHeaders = @get_headers($fileUrl);
	if (preg_match("|200|", $AgetHeaders[0])) {
		// file exists
	} else {
	 $Cover ="/images/tempcover.jpg";
	}
	 $Today = date('Y-m-d');
	 $query = "select ID from comic_votes where UserID='$UserID' and ComicID='$ComicID' and CreatedDate='$Today'";
	 $DB->query($query);
	 $AlreadyVoted  = $DB->numRows();
	 	 if ($_POST['vote'] == 1){
			
			if ($AlreadyVoted== 0) {
				$query = "INSERT into comic_votes (ComicID, UserID, CreatedDate) values ('$ComicID','$UserID','$Today')";
				$DB->execute($query);
				$query = "select votes from $comicstable where comiccrypt='$ComicID'";
 				$result = mysql_query($query);
 				$comicvotes = mysql_fetch_array($result);
				$Votes = $comicvotes['votes'];
 				$Votes++;
			
 				$query = "UPDATE $comicstable SET votes='$Votes' where comiccrypt='$ComicID'";
 				$result = mysql_query($query);
			} 
			
			
			
}

if ($_POST['favorite'] == 1){
addfavorite($ComicID,  $Userid, $_SESSION['userid']);
header("location:/".$SafeFolder."/");
}

$ComicTable ='';
if ($CreatorID == '')  {
 $query = "select * from $comicstable where title like '%$SafeFolder%' and Published=1";
  $DB->query($query);
 // print $query;
  $NumComicsResult = $DB->numRows();
  $ComicTable = "<table width='100%'><tr>";
			$counter = 0;
			while ($line = $DB->fetchNextObject()) {  
			$Results = 1;
			$UpdateDay = substr($line->PagesUpdated, 5, 2); 
			$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
			$UpdateYear = substr($line->PagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
 		
			
			if ($line->Hosted == 1) {
					$fileUrl = $line->thumb;
					$comicURL = $line->url.'/';
				} else if (($line->Hosted  == 2) && (substr($line->thumb,0,4) != 'http'))  {
					$fileUrl = 'http://www.panelflow.com'.$line->thumb;
					//print 'MY FILE URL = ' . $fileUrl."<br/>";
					$comicURL = $line->url;
				} else {
					$fileUrl = $line->thumb;
					$comicURL = $line->url;
				}
			
		
					$ComicTable .= "<td valign='top' width='150'><div align='center'><div class='comictitlelist'>".stripslashes($line->title)."</div><a href='/".$line->SafeFolder."/' >";
		    	$AgetHeaders = @get_headers($fileUrl);
			if (preg_match("|200|", $AgetHeaders[0])) {
				$ComicTable .=  "<img src='".$fileUrl."' border='2' alt='LINK' style='border-color:#000000;' width='100' height='134'>";
			} else {
			$ComicTable .=  "<img src='/images/tempcover_thumb.jpg' border='2' alt='LINK' style='border-color:#000000;'>";
			}
			$ComicTable .=  "</a><div class='smspacer'></div><div class='moreinfo'><a href='/".$line->SafeFolder."/'><img src='/images/info.jpg' border='0'></a><div class='updated'>updated: <b>".$Updated."</b></div><div class='pages'>Pages: ".$row['pages']."</div></div></td>"; 
			 $counter++;
 				if ($counter == 4){
 					$ComicTable .=  "</tr><tr>";
 					$counter = 0;
 				}
 			}
	//Display the full navigation in one go
	$ComicTable .=  "</tr></table>";

}




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<script type="text/javascript" src="/scripts/swfobject.js"></script>
<meta name="description" content="Flash Web Comic Content Management System"></meta>
<meta name="keywords" content="Webcomics, Comics, Flash"></meta>
<LINK href="/css/pf_css_new.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>PANEL FLOW | <?php echo $Title;?></title>

</head>

<?php include 'includes/header_template_new.php';?>

<div class="spacer"></div>
   <div><img src="/images/content_header_bg.png" /></div>

<div style="background-image:url(/images/content_background_new.png); background-repeat:repeat-y; width:943px;"> 
     <div class='contentwrapper'>
 <div align="center">
 
 <? if ($CreatorID != '') { ?> 
	<table width="626" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="354" valign="top">
	<div class="comictitle"> <?php echo $Title;?> </div>
	<div  class="menubar"><a href="<?php echo $Url;?>" target="blank"><?php echo $Url;?></a></div>
	<div class="comicinfo">last updated: <i> <?php echo $Updated;?></i></div>
	<div class="comicinfo">Pages: <?php echo $Pages;?></div>
    <div class="comicinfo">Comic Ranking: <?php echo $Rank;?></div><div class="spacer"></div>
    <div align="center"><a href="<?php echo $Url;?>" target="blank"><img src="<?php echo $fileUrl;?>" border="2" style='border-color:#000000;' ></a></div>
    <div class="spacer"></div>
   <div align="center"><a href="<?php echo $Url;?>" target="blank"><img src="/images/readnow.jpg" border="0" /></a><a href="<?php echo $Url;?>" target="blank"></a><? if ($Userid == $_SESSION['userid']) { ?>
   <div class="smspacer"></div><a href="/comicstats.php?comicid=<? echo $ComicID; ?>"><img src="/images/stats.png" border="0" /></a>
   <? } ?>
        <?php
  mysql_connect ($userhost, $dbuser,$userpass) or die ('Could not connect to the database.');
  mysql_select_db ($userdb) or die ('Could not select database.'); 
   if ($IsPublisher == 1) {?>
   <div class='spacer'></div><div><b>PUBLISHED BY: <? echo $PublisherName;?></b></div>
   <a href='http://<? echo $PublisherURL;?>' target="_blank"><img src='<? echo $PublisherAvatar;?>' border='2' style='border-color:#000000;'></a> <div class='spacer'></div>
   <? 
 	}
  $query = "select avatar, username,realname from $usertable where encryptid='$CreatorID'";
 $result = mysql_query($query);
 $user = mysql_fetch_array($result);
 $Username = stripslashes($user['username']);
 $Realname = stripslashes($user['realname']);
 $Avatar = $user['avatar'];
 echo "<div class='spacer'></div><div><b>CREATORS</b></div><table><tr><td align='center'><a href='/profile/".trim($Username)."/'><img src='".$Avatar."' border='2' style='border-color:#000000;'></a><br /><b>".$Realname."</b></td>";

 $query = "SELECT CreatorOne, CreatorTwo, CreatorThree from comic_settings where ComicID='$ComicID'";
 $CreatorArray = $DB->queryUniqueObject($query);
 $CreatorOne = $CreatorArray->CreatorOne;
 $CreatorTwo = $CreatorArray->CreatorTwo;
 $CreatorThree = $CreatorArray->CreatorThree;
 
$query = "SELECT Assistant1, Assistant2, Assistant3 from comic_settings where ComicID='$ComicID'";
 $AssistArray = $DB->queryUniqueObject($query); 
 $Assistant1 = $AssistArray->Assistant1;
 $Assistant2 = $AssistArray->Assistant2;
 $Assistant3 = $AssistArray->Assistant3;
 
 if ($CreatorOne != '') {
 	$query = "SELECT avatar,realname,username from users where email='$CreatorOne'";
  	$CrArray = $DB->queryUniqueObject($query);
	echo "<td align='center'><a href='/profile/".trim($CrArray->username)."/'><img src='".$CrArray->avatar."' border='2' style='border-color:#000000;' hspace='3' vspace='1'></a><br /><b>".$CrArray->realname."</b></td>";
 
 }
 if ($CreatorTwo != '') {
 	$query = "SELECT avatar,realname,username from users where email='$CreatorTwo'";
  	$CrArray = $DB->queryUniqueObject($query);
	echo "<td align='center'><a href='/profile/".trim($CrArray->username)."/'><img src='".$CrArray->avatar."' border='2' style='border-color:#000000;'  hspace='3' vspace='1'></a><br /><b>".$CrArray->realname."</b></td>";
 
 }
 if ($CreatorThree != '') {
 	$query = "SELECT avatar,realname,username from users where email='$CreatorThree'";
  	$CrArray = $DB->queryUniqueObject($query);
	echo "<td align='center'><a href='/profile/".trim($CrArray->username)."/'><img src='".$CrArray->avatar."' border='2' style='border-color:#000000;'  hspace='3' vspace='1'></a><br /><b>".$CrArray->realname."</b></td>";
 
 }

 echo '</tr></table>';
 

 if ( (($Assistant1 != '') && (!in_array($Assistant1,$CreatorArray))) && (($Assistant2 != '') && (!in_array($Assistant2,$CreatorArray))) && (($Assistant3 != '') && (!in_array($Assistant3,$CreatorArray)))) {
 echo "<div class='spacer'></div><div><b>ASSISTANTS</b></div><table><tr><td>";
 
 if ($Assistant1 != '') {
 	$query = "SELECT avatar,realname,username from users where email='$Assistant1'";
  	$CrArray = $DB->queryUniqueObject($query);
	echo "<td align='center'><a href='/profile/".trim($CrArray->username)."/'><img src='".$CrArray->avatar."' border='2' style='border-color:#000000;'  hspace='3' vspace='1'></a><br /><b>".$CrArray->realname."</b></td>";
 
 }
 
 
 if ($Assistant2 != '') {
 	$query = "SELECT avatar,realname,username from users where email='$Assistant2'";
  	$CrArray = $DB->queryUniqueObject($query);
	echo "<td align='center'><a href='/profile/".trim($CrArray->username)."/'><img src='".$CrArray->avatar."' border='2' style='border-color:#000000;'  hspace='3' vspace='1'></a><br /><b>".$CrArray->realname."</b></td>";
 
 }
 
  if ($Assistant3 != '') {
 	$query = "SELECT avatar,realname,username from users where email='$Assistant3'";
  	$CrArray = $DB->queryUniqueObject($query);
	echo "<td align='center'><a href='/profile/".trim($CrArray->username)."/'><img src='".$CrArray->avatar."' border='2' style='border-color:#000000;'  hspace='3' vspace='1'></a><br /><b>".$CrArray->realname."</b></td>";
 
 }
 echo '</tr></table>';
}
  ?>  
   </div>
  
   
   
   </td>


    <td  width="600" valign="top" align="right" style="padding-left:10px;">
	<?php  
if (is_authed()) { 

if ($Userid != $_SESSION['userid'])  {
echo "<div align='center'>";

if ($AlreadyVoted == 0) {
echo "<form method='POST' action='/".urlencode($SafeFolder)."/' style='margin:0px; padding:0px;'>
<input type='hidden' name='vote' id='vote' value='1'>
<input type='image' src='/images/vote.png' value='VOTE FOR THIS COMIC' style='border:none;background-color:#ffffff;' />
</form>";
} else {

echo '<div align="center">You can vote again on this comic tomorrow<div class="spacer"></div></div>';
}
}
$UserSessionID = trim($_SESSION['userid']);
$query = "select * from favorites where userid='$UserSessionID' and comicid='$ComicID'";
$ComicDB->query($query);
$Favorited = $ComicDB->numRows();
if ($Favorited ==0) {
echo "<div class='smspacer'></div><form method='POST'  action='/".urlencode($SafeFolder)."/' style='margin:0px; padding:0px;'>
<input type='hidden' name='favorite' id='favorite' value='1'>
<input type='image' src='/images/add_favorite.png' value='ADD TO FAVORITES' style='border:none;background-color:#ffffff;' />
</form>";
} else {
echo '<div class="smspacer"></div>This Comic is on your Favorites list';
}
echo '</div>';
}  else { ?>
<div align="center"  class="menubar"><a href="/login/">LOGIN TO VOTE FOR THIS COMIC</a></div>
<? }?>
<div class='lgspacer'></div>
<table border="0" cellpadding="0" cellspacing="0" width="450">
<tr>
<td id="profilemodtopleft"></td>
<td id="profilemodcenter" width="418">
<div class="profilemodheadertextsmall">COMIC INFO</div></td>
<td id="profilemodtopright"></td>
</tr>
<tr>
<td id="profilemodcontent" colspan='3'>

<?php if (isset($Creator)) { ?>
<div class="infoheader">CREATOR: </div>
<div class="infotext"><?php echo stripslashes($Creator); ?></div>
<div class="spacer"></div>
<?php } ?>

<?php if (isset($Writer)) { ?>
<div class="infoheader">WRITER: </div>
<div class="infotext"><?php echo $Writer; ?></div>
<div class="spacer"></div>
<?php } ?>


<?php if (isset($Artist)) { ?>
<div class="infoheader">ARTIST: </div>
<div class="infotext"><?php echo $Artist; ?></div>
<div class="spacer"></div>
<?php } ?>


<?php if (isset($Colorist)) { ?>
<div class="infoheader">COLORIST: </div>
<div class="infotext"><?php echo $Colorist; ?></div>
<div class="spacer"></div>
<?php } ?>

<?php if (isset($Letterist) && ($Letterist != "")) { ?>
<div class="infoheader">LETTERIST: </div>
<div class="infotext"><?php echo $Letterist; ?></div>
<div class="spacer"></div>
<?php } ?>

<?php if (isset($Synopsis)) { ?>
<div class="infoheader">SYNOPSIS: </div>
<div class="infotext"><?php echo $Synopsis; ?></div>
<div class="spacer"></div>
<?php } ?>

<?php if (isset($Genre)) { ?>
<div class="infoheader">GENRE: </div>
<div class="infotext"><?php echo $Genre; ?></div>
<div class="spacer"></div>
<?php } ?>


<?php if (isset($Tags)) { ?>
<div class="infoheader">TAGS: </div>
<div class="infotext"><?php echo $Tags; ?></div>
<div class="spacer"></div>
<?php } ?></td>
</tr>
</table>     <?
$query = "SELECT * from pf_store_items as si
					  join pf_store_images as sim on sim.ItemID=si.EncryptID
					  where si.ComicID='$ComicID' and sim.IsMain=1 order by si.ShortTitle";
					
				$DB->query($query);
				$NumOther = $DB->numRows();
				
				
				
				$Count = 0;
				if ($NumOther > 0) {?>
                <div class="spacer"></div>
                <table border="0" cellpadding="0" cellspacing="0" width="450">
<tr>
<td id="profilemodtopleft"></td>
<td id="profilemodcenter" width="418">
<div class="profilemodheadertextsmall">COMIC PRODUCTS</div></td>
<td id="profilemodtopright"></td>
</tr>
<tr>
<td id="profilemodcontent" colspan='3'>
<? 
					echo '<table cellpadding="0" cellspacing="0" border="0"><tr>';
				while($line= $DB->FetchNextObject()) {
				
					if (($line->ProductType == 'selfpdf') || ($line->ProductType == 'pdf') || ($line->ProductType == 'ebook'))
					$ProductCategory = 'E-Book';
					
					if (($line->ProductType == 'selfprint') || ($line->ProductType == 'podprint'))
					$ProductCategory = 'Print';
					
					
					if (($line->ProductType == 'selfbook') || ($line->ProductType == 'podbook'))
					$ProductCategory = 'Book';
					
					if (($line->ProductType == 'selfmerch') || ($line->ProductType == 'podmerch'))
					
					$ProductCategory = 'Merch';
					
						echo'<td width="200" align="center"><b>'.$line->ShortTitle.'</b><br><em>'.$ProductCategory.'</em><br>';
						echo '<a href="/'.$SafeFolder.'/products/'.$line->EncryptID.'/"><img src="/'.$line->ThumbSm.'" hspace="3" border="2" style="border:#000000 solid 1px;"></a></td>';
						$Count++;
						if ($Count ==3) {
							echo '</tr><tr>';
							$Count = 0;
						}
					}
					 
					 if ($Count < 3) {
						while($Count <3) {
						echo '<td></td>';
							$Count++;
						}
						echo '</tr>';
					 }
					echo '</table>';
					?>
                    
                    </td>
</tr>
</table>  
                    <?
				}
				//echo $OtherString;
				
		
?>

 <?
  if ($IsPublisher == 1) {
  $query = "SELECT * from comics where userid='$PublisherID' and comiccrypt!='$ComicID' and Published=1 and installed=1 order by RAND()";
 	} else {
$query = "SELECT * from comics where (userid='$CreatorID' or CreatorID='$CreatorID' or userid='$Userid' or CreatorID='$Userid') and comiccrypt!='$ComicID' and Published=1 and installed=1 order by RAND()";
					
			}	$DB->query($query);
				$NumOtherComics = $DB->numRows();
				$Count = 0;
				if ($NumOtherComics > 0) {?>
                <div class="spacer"></div>
                <table border="0" cellpadding="0" cellspacing="0" width="450">
<tr>
<td id="profilemodtopleft"></td>
<td id="profilemodcenter" width="418">
<div class="profilemodheadertextsmall">OTHER COMICS BY  <?
  if ($IsPublisher == 1) {?>PUBLISHER<? } else {?>CREATOR<? }?></div></td>
<td id="profilemodtopright"></td>
</tr>
<tr>
<td id="profilemodcontent" colspan='3'>
<? 
					echo '<table cellpadding="0" cellspacing="0" border="0"><tr>';
				while($line= $DB->FetchNextObject()) {
				
									
						echo '<td width="110" align="center"><b>'.stripslashes($line->title).'</b><br>';
						echo '<a href="/'.$line->SafeFolder.'/"><img src="'.$line->thumb.'" hspace="3" border="2" style="border:#000000 solid 1px;"></a></td>';
						$Count++;
						if ($Count ==4) {
							echo '</tr><tr>';
							$Count = 0;
						}
					}
					 
					 if ($Count < 4) {
						while($Count <4) {
						echo '<td></td>';
							$Count++;
						}
						echo '</tr>';
					 }
					echo '</table>';
					?>
                    
                    </td>
</tr>
</table>  
                    <?
				}
				//echo $OtherString;
				
				$DB->close();
?>

</td>
  </tr>
</table>
<?   $query = "SELECT * from links  where ComicID='$ComicID' and InternalLink=1";
 	$DB->query($query);
	$TotalBanners = $DB->numRows();
	$LinksString =' <div class="infoheader" align="left" style="border-bottom:#FF6600 1px solid; padding-bottom:3px;">COMIC BANNERS</div><div class="spacer"></div><div>';
	while ($link = $DB->fetchNextObject()) { 
		$LinksString .= "<img src='".$link->Image."' border='0'><div class='spacer'></div>";

	}
	$LinksString .= "</div>";
	if ($TotalBanners > 0) {?>
    <div class="spacer"></div>
    
   <? echo $LinksString;
    
     }?>

	<? } else {?>

   
    <?
	if ($NumComicsResult == 0){
		echo '<div style="height:300px;text-align:center;padding-top:25px;"><div class="pageheader">Ooops. We couldn\'t find that comic</div><div class="spacer"></div> You can browse the available comics [<a href="/comics/">here</a>]</div>';
	}else {?>
    
	 <div class="pageheader" style="padding-left:60px;">Ooops. We couldn't find that comic. Did you mean one of these?</div><div class="spacer"></div>
	<?
		echo $ComicTable;
	 }
	 }?>
	</div>
  </div>
     </div>
<div><img src="/images/content_footer_bg.png" /></div>
	  <?php include 'includes/footer_template_new.php';?>

</body>
</html>

<? } ?>