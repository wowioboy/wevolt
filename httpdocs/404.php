<?php 
//ini_set('display_errors',2);
//error_reporting(E_ALL|E_STRICT);
include 'includes/init.php';
$PageTitle = 'wevolt | NOT FOUND';
$TrackPage = 0;
include 'includes/header_template_new.php';?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_modules_css.css">
<?php
 $DB = new DB();
include 'includes/dbconfig.php';
//$path = trim(str_replace("/", " ", $_SERVER[REQUEST_URI]));

$patharray = explode("/", $_SERVER['REDIRECT_URL']);
$PathSize = sizeof($patharray);
//print 'SIZE = ' . $PathSize;
//print '1 = ' . $patharray[0]."<br/>";
//print '2 = ' . $patharray[1];
if ($PathSize == 2) {
	$CheckComic = 1;
	$Searchterm = $patharray[1];
} else {
	$CheckComic = 0;

}

if ($CheckComic == 1) {
$ComicTable ='';

 $query = "select * from $comicstable where title like '%$Searchterm%' and Published=1";
  $DB->query($query);
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
					$fileUrl = 'http://www.needcomics.com/'.$line->thumb;
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
//$path = trim(explode("/", $_SERVER[REQUEST_URI]));

//$patharray = trim(explode(" ", $path));
//print 'MY PATH = ' . $patharray[2];
//$ATTEMPT = $_SERVER['REDIRECT_URL']; 
//$path = trim(explode("/", $_SERVER[REQUEST_URI]));
//$path = trim(str_replace("/", " ", $_SERVER[REQUEST_URI]));
//$patharray = trim(explode(" ", $path));
//print 'MY PATH = ' . $patharray[2];
//$path = explode("/", $ATTEMPT]);
//$ATTEMPT = $_SERVER[REQUEST_URI]; // "/comics/c/comics/c/casdf
//$PathSize = sizeof($patharray);

//if ($PathSize == 1) {
//print 'ATTEMPT = ' .$ATTEMPT ; 
	//header("location:/".$Path[0]."/"); 
//}

//mysql_close($link) ; 
  ?>
<div align="left">
<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <? if ($_SESSION['IsPro'] == 1) {
           $_SESSION['noads'] = 1;
		?>
    <td valign="top" style="padding:5px; color:#FFFFFF;width:60px;"><? include 'includes/site_menu_popup_inc.php';?></td>
    <? } else {?>
    <td width="<? echo $SideMenuWidth;?>" valign="top"><? include 'includes/site_menu_inc.php';?></td>
    <? }?>
    <td  valign="top"  <? if ($_SESSION['IsPro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
      
      <? }?>
        <div style="padding:10px;" align="center">
        <div class="spacer"></div>
        <div class="spacer"></div>
        <div class="spacer"></div>
        <div align="center" style="color:#FFFFFF; font-size:14px; font-weight:bold;">404 - PAGE NOT FOUND</div>
        
        <img src="/images/bailey_sm.jpg" />
         <div class='contentwrapper'>
<div class="contentdiv" style="height:300px; padding-right:25px;">
<div class="spacer"></div><div class="spacer"></div>
<div style="color:#FFFFFF;"> If you're trying to reach a comic, please make sure you have the '/' at the end of the comic name and a '_' for each space in the title. <br />
<br />
For instance: www.wevolt.com/My_Comic/ </div>
<div class="spacer"></div>
<? if ($NumComicsResult > 0) {?>
Were you looking for one of these comics? <div class="spacer"></div> <? echo $ComicTable;?>
<? }?>
</div>
  </div>
        </div>
        
     </td>
     </tr>
     </table>
     </div>
<?php include 'includes/footer_template_new.php';?>


