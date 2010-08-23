<? 

if (isset($_POST['supplierselected'])) {
	$SupplierID = $_POST['supplierselected'];
}

if (isset($_POST['catselected'])) {
	$CatID = $_POST['catselected'];
}


if (($SupplierID != '' ) && ($SupplierID != 0 )) {
$SupplierActive = 1;
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

<? $supplierString = "";



$query = "select * from suppliers order by Title ASC";

$db->query($query);

$supplierString = "<select style='width:175px;' name='txtSupplier'><OPTION VALUE='0'>ALL</option>";

while ($line = $db->fetchNextObject()) { 
$supplierString .= "<OPTION VALUE='".$line->ID."'";
if ($SupplierID == $line->ID) {
$supplierString .= ' selected ';
};

$supplierString .=">".$line->Title."</OPTION>";

	}

$supplierString .= "</select>";

$menuString = "";
  $page = $_POST['page'];
  if (!isset($page))
    $page = 1;
  $itemsDB = new DB();
  
  if ($Search != ''){
  		$Keywords = $Search;
    	$query  = "SELECT * FROM items " .
					"WHERE ";
					
	if ($SupplierActive == 1) {
	 	$query  .= " supplier=".$SupplierID;
		
	}
	
	if (($CatActive == 1)) {
		if ($SupplierActive == 1) {
	 		$query  .= " and category=".$CatID;
		} else {
	 	$query  .= " category=".$CatID;
		}
	}
	
	if (($CatActive == 1) || ($SupplierActive == 1 )) {
		 $query  .= " and title LIKE '%".$Keywords."%'";
		} else {
	 	$query  .= " title LIKE '%".$Keywords."%'";
		}		
	$query  .= 	" OR designer LIKE '%".$Keywords."%'";
	$query  .= 	" OR description LIKE '%".$Keywords."%'";
	$query  .=	" ORDER BY title ASC";

  } else if ($SupplierActive == 1) {
 	 if ($CatActive == 1) {
   		$query  = "SELECT * FROM items WHERE supplier=$SupplierID and category =$CatID ORDER BY title ASC";
 	} else {
		$query  = "SELECT * FROM items WHERE supplier=$SupplierID ORDER BY title ASC";
	}
  }else if ($CatActive == 1) {
 	 if ($SupplierActive == 1) {
	 
   		$query  = "SELECT * FROM items WHERE supplier=$SupplierID and category =$CatID ORDER BY title ASC";
 	} else {
		$query  = "SELECT * FROM items WHERE category=$CatID ORDER BY title ASC";
	}

  } else {
   $query = "select * from items ORDER BY Title ASC";

  }
  
  $cnt = 0;
  $menuString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader'>ITEM TITLE</td><td class='tableheader'>CATEGORY</td><td class='tableheader'>MANUFACTURER</td><td class='tableheader'>THUMB</td></tr><tr><td colspan='5'>&nbsp;</td></tr>";
    $itemsDB->query($query);
    while ($line = $itemsDB->fetchNextObject()) {      
      if (($cnt >= (($page-1)*10)) && ($cnt < ($page*10)))
      {
    		$menuString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtItem' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td>";

$CatID = $line->Category;
$db2 = new DB();
$query = "select title from categories where id='$CatID'";
$CatTitle = $db2->queryUniqueValue($query);
$SupplierID = $line->Supplier;
$query = "select title from suppliers where id='$SupplierID'";
$SupplierTitle = $db2->queryUniqueValue($query);

	$menuString .= "<td class='listcell'>".$CatTitle."</td><td class='listcell'>".$SupplierTitle."</td><td class='listcell'><img src='".$line->ThumbSm."' border='1'></td></tr>";
  	  }
  	 $cnt++;
  	}
    $itemsDB->close();
	$menuString .= "</table>";
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
<form method='post' action='admin.php?a=items' onSubmit="return false;">
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

      STORE ITEMS</div>
    <div>
<input type='submit' name='btnsubmit' value='NEW' id='submitstyle' style="text-align:left;" ><div class='inputspacer'></div>

<input type='submit' name='btnsubmit' value='EDIT' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

<input type='submit' name='btnsubmit' value='DELETE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>

<input type='submit' name='btnsubmit' value='CHANGE IMAGE' id='submitstyle' style="text-align:left;"></div><div class="spacer"></div>SEARCH<br />
<input type='text' name="searchtext" />
<div class='spacer'></div>SELECT CATEGORY<br />
<? echo $catString;?><div class='spacer'></div>SELECT MANUFACTUER<br />
<? echo $supplierString;?><div class='spacer'></div>
<input type='submit' value='SEARCH' onclick="this.form.submit()"/>
</td>

    <td class='adminContent' valign="top"> <div style="width:92%;" align="right"><? if ($Search != ''){ ?><span style='padding-right:200px;'> Searching for : <? echo $Search."&nbsp;&nbsp;<a href='admin.php?a=items'>[CLEAR SEARCH]</a></span>"; }?><b>TOTAL: </b>[<? echo (($page-1)*10+1) . " - " . ($page*10) . " of $cnt";?>]<br />
<? if ($previouspage) { ?>
     <a href="#" onclick="javascript: previouspage();">&lt;&lt; PREV</a>&nbsp;&nbsp;
      <? }  if ($nextpage) { ?>
     <a href="#" onclick="javascript: nextpage();">NEXT &gt;&gt;</a>
      <? } ?> </div>
     
     <? echo $menuString ?>       
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
      
      
      <? if ($SupplierActive == 1) { ?>
      <input type="hidden" name="supplierselected" value="<? echo $SupplierID ?>" />
      <? } ?>
       <? if ($CatActive == 1) { ?>
      <input type="hidden" name="catselected" value="<? echo $CatID; ?>" />
      <? } ?>
  
 </form>
