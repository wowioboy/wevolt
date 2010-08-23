<? 

if (isset($_POST['sectionselected'])) {
	$SectionID = $_POST['sectionselected'];
}

if (isset($_POST['catselected'])) {
	$CatID = $_POST['catselected'];
}


if (($SectionID != '' ) && ($SectionID != 0 )) {
$SectionActive = 1;
}


if (($CatID != '' ) && ($CatID != 0 )) {
	$CatActive = 1;

}
$catString = "";
$db = new DB();
$query = "select * from categories order by Title ASC";

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



$query = "select * from sections order by Title ASC";

$db->query($query);

$sectionString = "<select style='width:175px;' name='txtSection'><OPTION VALUE='0'>ALL</option>";

while ($line = $db->fetchNextObject()) { 
$sectionString .= "<OPTION VALUE='".$line->ID."'";
if ($SectionID == $line->ID) {
$sectionString .= ' selected ';
};

$sectionString .=">".$line->Title."</OPTION>";

	}

$sectionString .= "</select>";

$contentString = "";
  $page = $_POST['page'];
  if (!isset($page))
    $page = 1;
  $itemsDB = new DB();
  
  if ($Search != ''){
  		$Keywords = $Search;
    	$query  = "SELECT * FROM content " .
					"WHERE ";
					
	if ($SectionActive == 1) {
	 	$query  .= " section=".$SectionID;
		
	}
	
	if (($CatActive == 1)) {
		if ($SectionActive == 1) {
	 		$query  .= " and category=".$CatID;
		} else {
	 	$query  .= " category=".$CatID;
		}
	}
	
	if (($CatActive == 1) || ($SectionActive == 1 )) {
		 $query  .= " and title LIKE '%".$Keywords."%'";
		} else {
	 	$query  .= " title LIKE '%".$Keywords."%'";
		}		
	$query  .= 	" OR author LIKE '%".$Keywords."%'";
	$query  .= 	" OR intro LIKE '%".$Keywords."%'";
	$query  .= 	" OR tags LIKE '%".$Keywords."%'";
	$query  .=	" ORDER BY title ASC";

  } else if ($SectionActive == 1) {
 	 if ($CatActive == 1) {
   		$query  = "SELECT * FROM content WHERE section=$SectionID and category =$CatID ORDER BY title ASC";
 	} else {
		$query  = "SELECT * FROM content WHERE section=$SectionID ORDER BY title ASC";
	}
  }else if ($CatActive == 1) {
 	 if ($SectionActive == 1) {
	 
   		$query  = "SELECT * FROM content WHERE section=$SectionID and category =$CatID ORDER BY title ASC";
 	} else {
		$query  = "SELECT * FROM content WHERE category=$CatID ORDER BY title ASC";
	}

  } else {
   $query = "select * from content ORDER BY Title ASC";

  }
  
  $cnt = 0;
  $contentString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'>ID</td><td class='tableheader'>POST TITLE</td><td class='tableheader'>SECTION/CATEGORY</td><td class='tableheader'>PUBLISHED</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
    $itemsDB->query($query);
    while ($line = $itemsDB->fetchNextObject()) {      
      if (($cnt >= (($page-1)*10)) && ($cnt < ($page*10)))
      {
    		$contentString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtPost' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>";
$CatID = $line->Category;
$SectionID = $line->Section;
	$db2 = new DB();
	$query = "select title from sections where id='$SectionID'";
	$SectionTitle = $db2->queryUniqueValue($query);
	$query = "select title from categories where id='$CatID'";
	$CategoryTitle = $db2->queryUniqueValue($query);
	$contentString .= $SectionTitle." / ".$CategoryTitle;

$contentString .= "</td><td class='listcell'>".$line->Published."</td></tr>";
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
<form method='post' action='admin.php?a=content' >
<table width='100%' border="0" cellpadding="0" cellspacing="0">

  <tr>

    <td id="contenttopleft"></td>

    <td  id='sidebartop'>&nbsp;</td>

    <td id='contenttop'>&nbsp;</td>

    <td id='contenttopright'>&nbsp;</td>

  </tr>

  <tr>

    <td id="contentleftside"></td>

    <td width="187" class='adminSidebar'><div class='adminSidebarHeader'><div style="height:7px;"></div>

     NEWS / CONTENT</div>
    <div>POSTS<br />
<input type='submit' name='btnsubmit' value='NEW' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class="spacer"></div>SECTIONS:<br /><input type='submit' name='btnsubmit' value='NEW SECTION' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT SECTIONS' id='submitstyle' style="text-align:left;"><div class="spacer"></div>CATEGORIES:<br /> <input type='submit' name='btnsubmit' value='NEW CATEGORY' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT CATEGORIES' id='submitstyle' style="text-align:left;"></div>
    </div>
    <div class="spacer"></div>
<input type='text' name="searchtext" onFocus="doClear(this)" value='enter keywords'>
<div class='spacer'></div>SELECT CATEGORY<br />
<? echo $catString;?><div class='spacer'></div>
SELECT SECTION<br />
<? echo $sectionString;?><div class='spacer'></div>
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
      
      
      <? if ($SectionActive == 1) { ?>
      <input type="hidden" name="sectionselected" value="<? echo $SectionID ?>" />
      <? } ?>
       <? if ($CatActive == 1) { ?>
      <input type="hidden" name="catselected" value="<? echo $CatID; ?>" />
      <? } ?>
  
 </form>
