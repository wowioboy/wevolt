<? 

if (isset($_POST['genreselected'])) {
	$GenreID = $_POST['genreselected'];
}

if (isset($_POST['creatorselected'])) {
	$CreatorID = $_POST['creatorselected'];
}


if (($GenreID != '' ) && ($GenreID != 0 )) {
$GenreActive = 1;
}


if (($CreatorID != '' ) && ($CreatorID != 0 )) {
	$CreatorActive = 1;

}
$genreString = "";
$db = new DB();
$query = "select * from genres order by Title ASC";

$db->query($query);

$genreString = "<select style='width:175px;' name='txtGenre'><OPTION VALUE='0'>ALL</option>";

while ($line = $db->fetchNextObject()) { 

$genreString .= "<OPTION VALUE='".$line->ID."'";

if ($CreatorID == $line->ID) {
$genreString .= ' selected ';
};

$genreString .=">".$line->Title."</OPTION>";

	}

$genreString .= "</select>";

?>

<? $creatorString = "";



$query = "select * from users where iscreator=1 order by username ASC";

$db->query($query);

$creatorString = "<select style='width:175px;' name='txtUser'><OPTION VALUE='0'>ALL</option>";

while ($line = $db->fetchNextObject()) { 
$creatorString .= "<OPTION VALUE='".$line->ID."'";
if ($GenreID == $line->ID) {
$creatorString .= ' selected ';
};

$creatorString .=">".$line->username."</OPTION>";

	}

$creatorString .= "</select>";

$contentString = "";
  $page = $_POST['page'];
  if (!isset($page))
    $page = 1;
  $itemsDB = new DB();
  
  if ($Search != ''){
  		$Keywords = $Search;
    	$query  = "SELECT * FROM comics " .
					"WHERE ";
					
	if ($GenreActive == 1) {
	 	$query  .= " genre=".$GenreID;
		
	}
	
	if (($CreatorActive == 1)) {
		if ($GenreActive == 1) {
	 		$query  .= " and creatorid=".$CreatorID;
		} else {
	 	$query  .= " creatorid=".$CreatorID;
		}
	}
	
	if (($CreatorActive == 1) || ($GenreActive == 1 )) {
		 $query  .= " and title LIKE '%".$Keywords."%'";
		} else {
	 	$query  .= " title LIKE '%".$Keywords."%'";
		}		
	$query  .= 	" OR tags LIKE '%".$Keywords."%'";
	$query  .=	" ORDER BY title ASC";

  } else if ($GenreActive == 1) {
 	 if ($CreatorActive == 1) {
   		$query  = "SELECT * FROM comics WHERE genre='$GenreID' and creatorid ='$CreatorID' ORDER BY title ASC";
 	} else {
		$query  = "SELECT * FROM comics WHERE GenreID='$GenreID' ORDER BY title ASC";
	}
  }else if ($CreatorActive == 1) {
 	 if ($GenreActive == 1) {
	 
   		$query  = "SELECT * FROM comics WHERE GenreID='$GenreID' and creatorid =$CreatorID ORDER BY title ASC";
 	} else {
		$query  = "SELECT * FROM comics WHERE creatorid=$CreatorID ORDER BY title ASC";
	}

  } else {
   $query = "select * from comics ORDER BY title ASC";

  }
  
  $cnt = 0;
  $contentString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>TITLE</td><td class='tableheader'>GENRE</td><td class='tableheader'>CREATOR</td><td class='tableheader'>THUMB</td></tr><tr><td colspan='4'>&nbsp;</td></tr>";
    $itemsDB->query($query);
    while ($line = $itemsDB->fetchNextObject()) {      
      if (($cnt >= (($page-1)*10)) && ($cnt < ($page*10)))
      {
    		$contentString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtItem' value='".$line->comiccrypt."'></td><td class='listcell'>".$line->title."</td><td class='listcell'>";
$CreatorID = $line->CreatorID;
$GenreID = $line->genre;
	$db2 = new DB();
	$query = "select username from users where encryptid='$CreatorID'";
	$CreatorName = $db2->queryUniqueValue($query);
	$contentString .= $line->genre;

$contentString .= "</td><td class='listcell'>".$CreatorName."</td><td class='listcell'><a href='admin.php?a=comics&id=".$line->comiccrypt."'><img src='".$line->thumb."' border='1' style='border-color:#ffffff;'></a></td></tr>";
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
<form method='post' action='admin.php?a=comics' >
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

     COMICS</div>
    <div>
      <div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class="spacer"></div><input type='submit' name='btnsubmit' value='CHANGE IMAGE' id='submitstyle' style="text-align:left;">
<div class='inputspacer'></div>
</div>
    </div>
    <div class="spacer"></div>
<input type='text' name="searchtext" onFocus="doClear(this)" value='enter keywords'>
<div class='spacer'></div>
SELECT GENRE<br />
<? echo $genreString;?><div class='spacer'></div>
SELECT CREATOR<br />
<? echo $creatorString;?><div class='spacer'></div>
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
      
      
      <? if ($GenreActive == 1) { ?>
      <input type="hidden" name="genreselected" value="<? echo $GenreID ?>" />
      <? } ?>
       <? if ($CreatorActive == 1) { ?>
      <input type="hidden" name="creatorselected" value="<? echo $CreatorID; ?>" />
      <? } ?>
  
 </form>
