<? 

if (isset($_POST['galleryselected'])) {
	$GalleryID = $_POST['galleryselected'];
}

if (isset($_POST['catselected'])) {
	$CatID = $_POST['catselected'];
}


if (($GalleryID != '' ) && ($GalleryID != 0 )) {
$GalleryActive = 1;
}


if (($CatID != '' ) && ($CatID != 0 )) {
	$CatActive = 1;

}
$catString = "";
$db = new DB();
$query = "select * from pf_gallery_categories order by Title ASC";

$db->query($query);

$catString = "<select style='width:175px;' name='txtCat'><OPTION VALUE='0'>ALL</option>";

while ($line = $db->fetchNextObject()) { 

$catString .= "<OPTION VALUE='".$line->ID."'";

if ($CatID == $line->ID) {
$catString .= ' selected ';
};

$catString .=">".$line->Title."</OPTION>";

	}

$catString .= "</select>";

?>

<? $sectionString = "";



$query = "select * from pf_gallery_galleries order by Title ASC";

$db->query($query);

$galleryString = "<select style='width:175px;' name='txtGallery'><OPTION VALUE='0'>ALL</option>";

while ($line = $db->fetchNextObject()) { 
$galleryString .= "<OPTION VALUE='".$line->ID."'";
if ($GalleryID == $line->ID) {
$galleryString .= ' selected ';
};

$galleryString .=">".$line->Title."</OPTION>";

	}

$galleryString .= "</select>";

$contentString = "";
  $page = $_POST['page'];
  if (!isset($page))
    $page = 1;
  $itemsDB = new DB();
  
  if ($Search != ''){
  		$Keywords = $Search;
    	$query  = "SELECT * FROM pf_gallery_content " .
					"WHERE ";
					
	if ($GalleryActive == 1) {
	 	$query  .= " GalleryID=".$GalleryID;
		
	}
	
	if (($CatActive == 1)) {
		if ($GalleryActive == 1) {
	 		$query  .= " and category=".$CatID;
		} else {
	 	$query  .= " category=".$CatID;
		}
	}
	
	if (($CatActive == 1) || ($GalleryActive == 1 )) {
		 $query  .= " and title LIKE '%".$Keywords."%'";
		} else {
	 	$query  .= " title LIKE '%".$Keywords."%'";
		}		
	$query  .= 	" OR tags LIKE '%".$Keywords."%'";
	$query  .=	" ORDER BY title ASC";

  } else if ($GalleryActive == 1) {
 	 if ($CatActive == 1) {
   		$query  = "SELECT * FROM pf_gallery_content WHERE GalleryID='$GalleryID' and category ='$CatID' ORDER BY title ASC";
 	} else {
		$query  = "SELECT * FROM pf_gallery_content WHERE GalleryID='$GalleryID' ORDER BY title ASC";
	}
  }else if ($CatActive == 1) {
 	 if ($GalleryActive == 1) {
	 
   		$query  = "SELECT * FROM pf_gallery_content WHERE GalleryID='$GalleryID' and category =$CatID ORDER BY title ASC";
 	} else {
		$query  = "SELECT * FROM pf_gallery_content WHERE category=$CatID ORDER BY title ASC";
	}

  } else {
   $query = "select * from pf_gallery_content ORDER BY Title ASC";

  }
  
  $cnt = 0;
  $contentString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>TITLE</td><td class='tableheader'>GALLERY / CATEGORY</td><td class='tableheader'>INMODULE</td><td class='tableheader'>THUMB</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
    $itemsDB->query($query);
    while ($line = $itemsDB->fetchNextObject()) {      
      if (($cnt >= (($page-1)*10)) && ($cnt < ($page*10)))
      {
    		$contentString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtItem' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>";
$CatID = $line->Category;
$SectionID = $line->Section;
$GalleryID = $line->GalleryID;
	$db2 = new DB();
	$query = "select title from pf_gallery_galleries where id='$GalleryID'";
	$GalleryTitle = $db2->queryUniqueValue($query);
	$query = "select title from pf_gallery_categories where id='$CatID'";
	$CategoryTitle = $db2->queryUniqueValue($query);
	$contentString .= $GalleryTitle." / ".$CategoryTitle;

$contentString .= "</td><td class='listcell'>".$line->InModule."</td><td class='listcell'><a href='admin.php?a=gallery&sub=item&gallery=".$GalleryID."&id=".$line->ID."'><img src='".$line->ThumbSm."' border='1' style='border-color:#ffffff;'></a></td></tr>";
  	  }
  	 $cnt++;
  	}
    $itemsDB->close();
	$contentString .= "</table>";
  if ($cnt >= ($page*10)){
    $nextpage = true;
	}
  else{
    $nextpage = false;
	}
  if ($page > 1)
    $previouspage = true;
  else
    $previouspage = false;
	?>
<script language="JavaScript">
  function nextpage()
  {
    document.getElementById('page').value = <? echo ($page+1); ?>;
    document.form1.submit();
  }
  
  function previouspage()
  {
    document.getElementById('page').value = <? echo ($page-1); ?>;
    document.form1.submit();
  }
</script>
<form method='post' action='admin.php?a=gallery&sub=item' >
<table width='100%' border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td id="contenttopleft"></td>

    <td  id='sidebartop'>&nbsp;</td>

    <td id='contenttop'>&nbsp;</td>

    <td id='contenttopright'>&nbsp;</td>

  </tr>

  <tr>

    <td id="contentleftside"></td>

    <td width="187" class='adminSidebar' valign="top"><div class='adminSidebarHeader'><div style="height:7px;"></div>

     GALLERY ITEMS</div>
    <div>
      <div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class="spacer"></div><input type='submit' name='btnsubmit' value='CHANGE IMAGE' id='submitstyle' style="text-align:left;">
<div class='inputspacer'></div>
</div>
    </div>
    <div class="spacer"></div>
<input type='text' name="searchtext" onFocus="doClear(this)" value='enter keywords'>
<div class='spacer'></div>SELECT CATEGORY<br />
<? echo $catString;?><div class='spacer'></div>
SELECT GALLERY<br />
<? echo $galleryString;?><div class='spacer'></div>
<input type='submit' value='SEARCH' onclick="this.form.submit()"/>
</td>

    <td class='adminContent' valign="top"> <div style="width:92%;" align="right"><? if ($Search != ''){ ?><span style='padding-right:200px;'> Searching for : <? echo $Search."&nbsp;&nbsp;<a href='admin.php?a=".$ApplicationType."'>[CLEAR SEARCH]</a></span>"; }?><b>TOTAL: </b>[<? echo (($page-1)*10+1) . " - " . ($page*10) . " of $cnt";?>]<br />
<? if ($previouspage) { ?>
     <a href="#" onclick="javascript: previouspage();">&lt;&lt; PREV</a>&nbsp;&nbsp;
      <? }  if ($nextpage) { ?>
     <a href="#" onclick="javascript: nextpage();">NEXT &gt;&gt;</a>
      <? } ?> </div>
     
     <? echo $contentString; ?>       
     <? if ($previouspage) { ?>
      <div style="float: left;"><a href="#" onclick="javascript: previouspage();">&lt;&lt; PREV</a></div>
      <? }  if ($nextpage) { ?>
      <div style="float: right;"><a href="#" onclick="javascript: nextpage();">NEXT &gt;&gt;</a></div>
      <? } ?>
        </td>

    <td id='contentrightside'>&nbsp;</td>

  </tr>

  <tr>

    <td id='contentbottomleft'>&nbsp;</td>

    <td id='sidebottom'>&nbsp;</td>

    <td id='contentbottom'>&nbsp;</td>

    <td id='contentbottomright'>&nbsp;</td>

  </tr>

</table>
</form>
 <form name="form1" action="#" method="post">
      <input type="hidden" name="page" id="page" value="" />
      <input type="hidden" name="searchtext" value="<? echo $Search; ?>" />
      
      
      <? if ($GalleryActive == 1) { ?>
      <input type="hidden" name="galleryselected" value="<? echo $GalleryID ?>" />
      <? } ?>
       <? if ($CatActive == 1) { ?>
      <input type="hidden" name="catselected" value="<? echo $CatID; ?>" />
      <? } ?>
  
 </form>
