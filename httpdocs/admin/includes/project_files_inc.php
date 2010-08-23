<? 
if (isset($_POST['projectActive'])) {
	$ProjectID = $_POST['projectActive'];
}

if (isset($_POST['taskActive'])) {
	$TaskID = $_POST['catselected'];
}

if (isset($_POST['userActive'])) {
	$UserID = $_POST['userActive'];
}

if (($ProjectID != '' ) && ($ProjectID != 0 )) {
$ProjectActive = 1;
}



if (($TaskID != '' ) && ($TaskID != 0 )) {
	$TaskActive = 1;

}

if (($UserID != '' ) && ($UserID != 0 )) {
	$UserActive = 1;

}


$projectString = "";
$db = new DB();
$query = "select * from pf_projects order by Title ASC";

$db->query($query);

$projectString = "<select style='width:175px;' name='txtProject'><OPTION VALUE='0'>ALL</option>";

while ($line = $db->fetchNextObject()) { 

$projectString .= "<OPTION VALUE='".$line->ID."'";

if ($ProjectID == $line->ID) {
$projectString .= ' selected ';
};

$projectString .=">".$line->Title."</OPTION>";

	}

$projectString .= "</select>";

?>

<? $taskString = "";



$query = "select * from pf_projects_tasks order by Title ASC";

$db->query($query);

$taskString = "<select style='width:175px;' name='txtTask'><OPTION VALUE='0'>ALL</option>";

while ($line = $db->fetchNextObject()) { 
$taskString .= "<OPTION VALUE='".$line->ID."'";
if ($TaskID == $line->ID) {
$taskString .= ' selected ';
};

$taskString .=">".$line->Title."</OPTION>";

	}

$taskString .= "</select>";

$userString = "";



$query ="select Username, UserId from pf_projects_users order by Username";

$db->query($query);

$userString = "<select style='width:175px;' name='txtUser'><OPTION VALUE='0'>ALL</option>";

while ($line = $db->fetchNextObject()) { 
$userString .= "<OPTION VALUE='".$line->UserId."'";
if ($UserID == $line->UserId) {
$userString .= ' selected ';
};

$userString .=">".$line->Username."</OPTION>";

	}

$userString .= "</select>";


$contentString = "";
  $page = $_POST['page'];
  if (!isset($page))
    $page = 1;
  $itemsDB = new DB();
  
  if (($Search != '') && ($Search != 'enter keywords')){
  		$Keywords = $Search;
    	$query  = "SELECT * FROM pf_projects_files " .
					"WHERE ";
					
	if ($ProjectActive == 1) {
	 	$query  .= " ProjectID=".$ProjectID;
		
	}
	
	if ($TaskActive == 1) {
		if ($ProjectActive == 1) {
	 		$query  .= " and TaskID=".$TaskID;
		} else {
	 	$query  .= " TaskID=".$TaskID;
		}
	}
	
	if ($UserActive == 1) {
		if (($ProjectActive == 1) || ($TaskActive == 1)) {
	 		$query  .= " and UserID=".$UserID;
		} else {
	 	$query  .= " UserID=".$UserID;
		}
	}
	
	if (($TaskActive == 1) || ($ProjectActive == 1 ) || ($UserActive == 1)) {
		 $query  .= " and title LIKE '%".$Keywords."%'";
		} else {
	 	$query  .= " title LIKE '%".$Keywords."%'";
		}		
	$query  .= 	" OR description LIKE '%".$Keywords."%'";
	$query  .=	" ORDER BY title ASC";

  } else if ($ProjectActive == 1) {
 	 if (($TaskActive == 1) && ($UserActive == 1)) {
   		$query  = "SELECT * FROM pf_projects_files WHERE ProjectID=$ProjectID and TaskID =$TaskID and UserID =$UserID ORDER BY title ASC";
 	} else if (($TaskActive == 0) && ($UserActive == 1)) {
		$query  = "SELECT * FROM pf_projects_files WHERE ProjectID=$ProjectID and UserID =$UserID ORDER BY title ASC";
	} else if (($TaskActive == 1) && ($UserActive == 0)) {
		$query  = "SELECT * FROM pf_projects_files WHERE ProjectID=$ProjectID and TaskID =$TaskID ORDER BY title ASC";
	}else {
	$query  = "SELECT * FROM pf_projects_files WHERE ProjectID=$ProjectID ORDER BY title ASC";
	}
  }else if ($TaskActive == 1) {
 	 if (($ProjectActive == 1) && ($UserActive == 1)) {
   		$query  = "SELECT * FROM pf_projects_files WHERE ProjectID=$ProjectID and TaskID =$TaskID and UserID =$UserID ORDER BY title ASC";
 	} else if (($ProjectActive == 0) && ($UserActive == 1)) {
		$query  = "SELECT * FROM pf_projects_files WHERE TaskID=$TaskID and UserID =$UserID ORDER BY title ASC";
	} else if (($ProjectActive == 1) && ($UserActive == 0)) {
		$query  = "SELECT * FROM pf_projects_files WHERE ProjectID=$ProjectID and TaskID=$TaskID ORDER BY title ASC";
	}else {
	$query  = "SELECT * FROM pf_projects_files WHERE TaskID=$TaskID ORDER BY title ASC";
	}
  } else if ($UserActive == 1) {
 	 if (($ProjectActive == 1) && ($TaskActive == 1)) {
   		$query  = "SELECT * FROM pf_projects_files WHERE ProjectID=$ProjectID and TaskID =$TaskID and UserID =$UserID ORDER BY title ASC";
 	} else if (($ProjectActive == 0) && ($TaskActive == 1)) {
		$query  = "SELECT * FROM pf_projects_files WHERE TaskID=$TaskID and UserID =$UserID ORDER BY title ASC";
	} else if (($ProjectActive == 1) && ($TaskActive == 0)) {
		$query  = "SELECT * FROM pf_projects_files WHERE ProjectID=$ProjectID and UserID =$UserID ORDER BY title ASC";
	}else {
	$query  = "SELECT * FROM pf_projects_files WHERE  UserID =$UserID ORDER BY title ASC";
	}
  }else {
   $query  = "SELECT * FROM pf_projects_files ORDER BY title ASC";

  }
  
  $cnt = 0;
 $fileString = "<table width='100%' cellpadding='0' cellspacing='0' border='0'><tr><td width='3%' class='tableheader'></td><td class='tableheader' width='150'>FILE TITLE</td><td class='tableheader' width='50'>TYPE</td><td class='tableheader' width='140'>PROJECT</td><td class='tableheader'>UPLOADED BY</td><td class='tableheader'>UPLOADED DATE</td><td class='tableheader'>LINK</td></tr><tr><td colspan='7'>&nbsp;</td></tr>";
    $itemsDB->query($query);
    while ($line = $itemsDB->fetchNextObject()) {      
      if (($cnt >= (($page-1)*10)) && ($cnt < ($page*10)))
      {
    		if ($line->ReadOnly == 1) {
$fileString .= "<tr><td width='3%' align='left' class='listcell2'><input type='radio' name='txtFile' value='".$line->ID."'></td><td class='listcell2'>".$line->Title."</td><td class='listcell2'>".$line->Type."</td><td class='listcell2'>";
} else {
$fileString .= "<tr><td width='3%' align='left' class='listcell'><input type='radio' name='txtFile' value='".$line->ID."'></td><td class='listcell'>".$line->Title."</td><td class='listcell'>".$line->Type."</td><td class='listcell'>";
}
$ProjectID = $line->ProjectID;
$Project = new DB();
$ext = $line->Type;
$query = "select Title from pf_projects where ID='$ProjectID'";
$ProjectName = $Project->queryUniqueValue($query);
$UserID = $line->UserID;
$query = "select Username from pf_projects_users where UserId='$UserID'";
$UserName = $Project->queryUniqueValue($query);
if ($line->ReadOnly == 1) {
$fileString .=$ProjectName."</td><td class='listcell2'>".$UserName."</td><td class='listcell2'>".substr($line->CreatedDate,0,10)."</td><td class='listcell2'><a href='projects/media/".$line->Filename."' target='_blank'>[DOWNLOAD]</a>";
} else {
$fileString .=$ProjectName."</td><td class='listcell'>".$UserName."</td><td class='listcell'>".substr($line->CreatedDate,0,10)."</td><td class='listcell'><a href='projects/media/".$line->Filename."' target='_blank'>[DOWNLOAD]</a>";
}
if (($ext == 'jpg') || ($ext == 'JPEG') ||($ext == 'JPG') ||($ext == 'jpg') ||($ext == 'GIF') ||($ext == 'gif') ||($ext == 'png') ||($ext == 'PNG') ||($ext == 'bmp')) {
$fileString .="<div style='padding:3px; padding-left:12px;'>preview<div style=height:3px;'></div><a href='".$line->GalleryImage."' rel='lightbox'><img src='".$line->ThumbSm."'  border='1'></a></div>";
} 

$fileString .="</td></tr>";
  	  }
  	 $cnt++;
  	}
    $itemsDB->close();
	$fileString .= "</table>";
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
<form method='post' action='admin.php?a=projects' >
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
      PROJECT FILES</div>
<input type='submit' name='btnsubmit' value='UPLOAD FILE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='EDIT FILE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
<input type='submit' name='btnsubmit' value='DELETE FILE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div></div>
    </div>
    <div class="spacer"></div>SEARCH FILES<br />

<input type='text' name="searchtext" onFocus="doClear(this)" value='enter keywords'>
<div class='spacer'></div>SELECT PROJECT<br />
<? echo $projectString;?><div class='spacer'></div>
SELECT TASK<br />
<? echo $taskString;?><div class='spacer'></div>SELECT USER<br />
<? echo $userString;?><div class='spacer'></div>
<input type='submit' value='SEARCH' onclick="this.form.submit()"/>
</td>

    <td class='adminContent' valign="top"> <div style="width:92%;" align="right"><? if ($Search != ''){ ?><span style='padding-right:200px;'> Searching for : <? echo $Search."&nbsp;&nbsp;<a href='admin.php?a=".$ApplicationType."&sub=file'>[CLEAR SEARCH]</a></span>"; }?><b>TOTAL: </b>[<? echo (($page-1)*10+1) . " - " . ($page*10) . " of $cnt";?>]<br />
<? if ($previouspage) { ?>
     <a href="#" onclick="javascript: previouspage();">&lt;&lt; PREV</a>&nbsp;&nbsp;
      <? }  if ($nextpage) { ?>
     <a href="#" onclick="javascript: nextpage();">NEXT &gt;&gt;</a>
      <? } ?> </div>
     
     <? echo $fileString; ?>       
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
 <input type="hidden" name="sub" value="file" />
</form>
 <form name="form1" action="#" method="post">
      <input type="hidden" name="page" id="page" value="" />
      <input type="hidden" name="searchtext" value="<? echo $Search; ?>" />
      
       <input type="hidden" name="sub" value="file" />
      <? if ($ProjectActive == 1) { ?>
      <input type="hidden" name="projectActive" value="<? echo $ProjectID ?>" />
      <? } ?>
       <? if ($TaskActive == 1) { ?>
      <input type="hidden" name="taskActive" value="<? echo $TaskID; ?>" />
      <? } ?>
        <? if ($UserActive == 1) { ?>
      <input type="hidden" name="userActive" value="<? echo $UserID; ?>" />
      <? } ?>
  
 </form>
