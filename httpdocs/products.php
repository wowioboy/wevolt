<?php include 'includes/init.php';?>
<?php include 'includes/dbconfig.php'; ?>
<?php include('includes/ps_pagination.php'); ?>

<?php 
if ($_GET['a'] == 'success') {
		$Message='<div class="pageheader">Thanks for your order!</div><div style="padding:15px; height:200px;">Your Payment has been recieved and will be processed shortly. Once your order is complete you will recieve an email with your confirmation.</div>';

} else if ($_GET['a'] == 'cancel') {
		$Message='<div class="pageheader" style="height:200px;padding-top:15px;" align="center">Your order has been cancelled</div>';

}

$Genre = $_GET['genre']; 
$search = $_GET['search'];
$genreString = $Genre;
 
$sort = $_GET['sort']; 
if ($sort == "") {
$sort = 4;
}

if ($sort == 1)
	$Listing = 'Title';
else if ($sort == 2)
	$Listing = 'Creation Date';
else if ($sort == 3)
	$Listing = 'Last Updated';
else if ($sort == 4)
	$Listing = 'Ranking';
	
$Results = 0;
$PageTitle = 'wevolt | store';
$TrackPage = 1;
include 'includes/header_template_new.php';?>
<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/standard_modules_css.css">

<div align="left">

<table cellpadding="0" cellspacing="0" border="0" <? if ($_SESSION['IsPro'] == 1) {?> width="100%"<? }?>>
  <tr>
    <? if ($_SESSION['IsPro'] == 1) {
$_SESSION['noads'] = 1;
		?>
    <td valign="top" bgcolor="#1a5793" style="padding:5px; color:#FFFFFF;"><? include 'includes/site_menu_popup_inc.php';?>
    </td>
  </tr>
  <tr>
    <? } else {?>
    <td width="<? echo $SideMenuWidth;?>" valign="top"><? include 'includes/site_menu_inc.php';?>
    </td>
    <? }?>
    <td  valign="top"  <? if ($_session['ispro'] == 1) {?>align="center"<? }?>><? if ($_SESSION['noads'] != 1) {?>
       <div style="padding-left:13px;"> <iframe src="/includes/top_banner_inc.php?home=1" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no"></iframe></div>
      <? }?>
       
        <div style="padding:10px;">
          
          <div class="spacer"></div>
            <table>
            <tr>
            <td>
    
            <table width="728" border="0" cellpadding="0" cellspacing="0" height="">
            <tr>
                <td id="modtopleft"></td>
                <td id="modtop" width="688" align="left"></td>
                <td id="modtopright" align="right" valign="top"></td>
            
            </tr>
            <tr>
            
                
                <td colspan="3" valign="top">
                
                        
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                
                <tr>
                
                <td id="modleftside"></td>
                <td class="boxcontent">
                
                
                <? if ($message == '') {?>
             <table width="95%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="158" valign="top" style="padding-left:15px;">
                <div class="pageheader">PRODUCTS</div>
                
            <div class="search" style="padding-left:6px;">
            <form name="form" action="/products/" method="get">
              <input type="text" size="18"  name="search" />
              <div align="center">
              <input type="submit" value="Search" />
              </div>
              </form>
            </div>
            <div class="infoheader"><img src="/images/radiobtn.jpg" />LISTING OPTIONS </div>
            <div class="spacer"></div> 
            <div class="genres">
            
            <div id="genres">
                    <strong>You need to upgrade your Flash Player </strong></div>
            <script type="text/javascript">
                    // <![CDATA[
            
                    var so = new SWFObject("/flash/genres.swf", "images", "100", "450", "8.0.23", "#FFFFFF", true);
                    so.addVariable('genreString','<?php echo $genreString;?>');
                     so.addVariable('sorttype','<?php echo $sort;?>');
                    so.write("genres");
            
                    // ]]>
                </script>
            </div>
            
            </td>
             <td width="575" valign="top">
                <div class="comiclist" align="left" style="padding:5px;">
                <div style="sectionheader">Listing by <? echo $Listing;?></div>
                
                <?php 
            
            $conn = mysql_connect($userhost, $dbuser,$userpass);
            mysql_select_db($userdb,$conn);
            if (((!isset($Genre)) && (!isset($search))) || ((isset($search)) && ($search == ""))){
            if ($sort == 1) {
                            $sql = "select si.ShortTitle, si.EncryptID as ItemID, simg.ThumbMd from pf_store_items as si
                                    join pf_store_images as simg on (simg.ItemID=si.EncryptID and simg.IsMain =1)
                                    where si.ComicID != '' and si.Active = 1 and si.PostProduct=1 ORDER BY si.ShortTitle ASC";
                            
                            } else if ($sort == 2) {
                            $sql = "select si.ShortTitle, si.EncryptID as ItemID, simg.ThumbMd from pf_store_items as si
                                    join pf_store_images as simg on (simg.ItemID=si.EncryptID and simg.IsMain =1)
                                    where si.ComicID != '' and si.Active = 1 and si.PostProduct=1 ORDER BY si.CreationDate DESC";
                            
                            } else if ($sort == 3) {
                            $sql = "select si.ShortTitle, si.EncryptID as ItemID, simg.ThumbMd from pf_store_items as si
                                    join pf_store_images as simg on (simg.ItemID=si.EncryptID and simg.IsMain =1)
                                    where si.ComicID != '' and si.Active = 1 and si.PostProduct=1 and  ORDER BY si.CreationDate DESC";
                            
                            } else  if ($sort == 4){
                                $sql = "select si.ShortTitle, si.EncryptID as ItemID, simg.ThumbMd from pf_store_items as si
                                    join pf_store_images as simg on (simg.ItemID=si.EncryptID and simg.IsMain =1)
                                    where si.ComicID != '' and si.Active = 1 and si.PostProduct=1 ORDER BY si.CreationDate DESC";
                            
                            }
            
            } else if (isset($Genre)) {
            
            $search = trim($Genre);
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
                            $sql = "SELECT * FROM comics " .
                                    "WHERE installed = 1 and genre LIKE '%".$keywords[$i]."%'".
                                    " and installed = 1 and Published = 1 ORDER BY title ASC";
                            
                            } else if ($sort == 2) {
                            $sql = "SELECT * FROM comics " .
                                    "WHERE installed = 1 and genre LIKE '%".$keywords[$i]."%'".
                                    " and installed = 1 and Published = 1 ORDER BY createdate DESC";
                            
                            } else if ($sort == 3) {
                            $sql = "SELECT * FROM comics " .
                                    "WHERE installed = 1 and Published = 1 and genre LIKE '%".$keywords[$i]."%'".
                                    "  ORDER BY updated DESC";
                            
                            } else  if ($sort == 4){
                                $sql = "select * from comics as c
                                    join rankings as r on c.comiccrypt=r.ComicID
                                    where c.installed = 1 and c.Published = 1 and c.genre LIKE '%".$keywords[$i]."%'".
                                    "ORDER BY r.ID ASC";
                            
                            }
                            }
                            }
                //Create a PS_Pagination object
            } else if ((isset($search)) && ($search != "")) {
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
                            $sql = "SELECT * FROM comics " .
                                    "WHERE installed = 1 and Published = 1 and (title LIKE '%".$keywords[$i]."%'".
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
                                ") ORDER BY title ASC";
                            
                            } else if ($sort == 2) {
                            $sql = "SELECT * FROM comics " .
                                    "WHERE installed = 1 and Published = 1 and (title LIKE '%".$keywords[$i]."%'".
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
                                ")  ORDER BY createdate DESC";
                            
                            } else if ($sort == 3) {
                            $sql = "SELECT * FROM comics " .
                                    "WHERE installed = 1 and Published = 1 and (title LIKE '%".$keywords[$i]."%'".
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
                                ") ORDER BY updated DESC";
                            
                            }else if ($sort == 4) {
                            $sql = "SELECT * FROM comics as c
                                join rankings as r on c.comiccrypt=r.ComicID
                                WHERE c.installed = 1 and c.Published = 1 and (c.title LIKE '%".$keywords[$i]."%'
                                 OR c.creator LIKE '%".$keywords[$i]."%'
                                 OR c.writer LIKE '%".$keywords[$i]."%'
                                 OR c.artist LIKE '%".$keywords[$i]."%'
                                 OR c.colorist LIKE '%".$keywords[$i]."%'
                                 OR c.letterist LIKE '%".$keywords[$i]."%'
                                 OR c.synopsis LIKE '%".$keywords[$i]."%'
                                 OR c.short LIKE '%".$keywords[$i]."%'
                                 OR c.url LIKE '%".$keywords[$i]."%'
                                 OR c.artist LIKE '%".$keywords[$i]."%'
                                 OR c.tags LIKE '%".$keywords[$i]."%'
                                 OR c.genre LIKE '%".$keywords[$i]."%'
                                 ) ORDER BY r.ID ASC";
                            
                            }
                                    
                            }
                        }
                //Create a PS_Pagination object
                foreach($keywords as $value) {
                            print "$value ";
                        }		
            }
            $pager = new PS_Pagination($conn,$sql,12,5);
            
                //The paginate() function returns a mysql result set 
                        $rs = $pager->paginate();
                        
                        echo "<table width='100%'><tr>";
                        $counter = 0;
                        while($row = mysql_fetch_assoc($rs)) {
                        $Results = 1;			
                        
                                echo "<td valign='top' width='150'><div align='center'><div class='comictitlelist'>".stripslashes($row['ShortTitle'])."</div><a href='/products/".$row['ItemID']."/'>";
                            echo "<img src='/".$row['ThumbMd']."' border='2' alt='LINK' style='border-color:#000000;' width='100' height='134'>";
                        echo "</a><div class='smspacer'></div><div class='moreinfo'><a href='/products/".$row['ItemID']."/'><img src='/images/info.jpg' border='0'></a></div></td>"; 
                         $counter++;
                            if ($counter == 4){
                                echo "</tr><tr>";
                                $counter = 0;
                            }
                        }
                //Display the full navigation in one go
                echo "</tr></table>";
                //echo $comicString;
            if ($Results == 1) {
            
                echo "<div class='pagination'>".$pager->renderFullNav()."</div>";
                
                }
            if ($Results == 0) {
                
                echo "<div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div align='center' style='font-weight:bold;'>There are no products that fit your search.</div>";
                
                
                }
            
            ?> 
                </div>
            <? }?>
                </td>
                <td id="modrightside"></td>
                </tr>
                <tr>
                <td id="modbottomleft"></td>
                <td id="modbottom"></td>
                <td id="modbottomright"></td>
            </tr>
                </table>
                
                </td>
            </tr>
            
            
            
            </table>
                
            </td>
            </tr>
            </table>

        </div>

<?php include 'includes/footer_template_new.php';?>


