<? include 'includes/init.php'; 
$TrackPage = 1;
$DB = new DB();

include_once("classes/search_pagination.php");  // include main class filw which creates pages
$pagination    =    new pagination();  

$query = "SELECT * from user_searches where UserID='".$_SESSION['userid']."' order by CreatedDate";
$DB->query($query);
$SavedSearchSelect = '<select name="txtSavedSearch" onchange="window.location = this.options[this.selectedIndex].value; " style="width:130px;"><option value="">saved searches</option>';
while ($line = $DB->FetchNextObject()) {
$SavedSearchSelect .= '<option value="/search/'.$line->QueryString.'">'.$line->Title.'</option>'; 

 
}
$SavedSearchSelect .='</select>';

?>
<?php 


$ContentSearch = '';
$GenreSearch = '';
$TagSearch= '';

if (($_GET['content'] == '') && (isset($_GET['t'])))
	$SearchContentArray = array($_GET['t']);
else
	$SearchContentArray = explode(',',$_GET['content']);


$SearchSubContentArray = explode(',',$_GET['sub']);
if ($SearchSubContentArray == null)
	$SearchSubContentArray = array();
$SearchCreatorArray = explode(',',$_GET['creator']);
$SearchGenreArray = explode(',',$_GET['genre']);
$SearchTagsArray = explode(',',$_GET['keywords']);
foreach ($SearchContentArray as $content) {
	if ($ContentSearch != '')
		$ContentSearch .= ',';

 	$ContentSearch .= "'".$content."'";
 
}


foreach ($SearchSubContentArray as $content) {
	if ($SubContentSearch != '')
		$SubContentSearch .= ',';

 	$SubContentSearch .= "'".$content."'";
 
}
if (isset($_GET['t']))
	$ContentSearch ="'".$_GET['t']."'";
foreach ($SearchGenreArray as $genre) {
	if ($GenreSearch != '')
		$GenreSearch .= ',';
 	$GenreSearch .= "'".$genre."'";
}
foreach ($SearchTagsArray as $tag) {
	if ($TagSearch != '')
		$TagSearch .= ',';
 	$TagSearch .= "'".$tag."'";
}
//$Genre = $_GET['genre']; 
$search = $_GET['keywords'];
//$genreString = $Genre;
 
$sort = $_GET['sort']; 
if ($sort == "") {
$sort = 'rank';
}

if ($sort == 'alpha')
	$Listing = 'Title';
else if ($sort == 'new')
	$Listing = 'Creation Date';
else if ($sort == 'updated')
	$Listing = 'Last Updated';
else if ($sort == 'rank')
	$Listing = 'Ranking';
	
$Results = 0;

$QueryString = '';
$TabQuery = '';
$RunQuery = 0;

if ((isset($_GET['keywords'])) && ($_GET['keywords'] != 'enter keywords')) {
	$TabQuery .= '&keywords='.$_GET['keywords'];
	$RunQuery = 1;
	}

if ($_GET['sort'] != '') {
		$TabQuery .='&sort='.$_GET['sort'];
		$RunQuery = 1;
}

if ($_GET['filters'] != '') {
		$TabQuery .='&filters='.$_GET['filters'];
		$RunQuery = 1;
}

if ($_GET['content'] != '') {
		$QueryString .='&content='.$_GET['content'];
		$RunQuery = 1;
}
if ($_GET['sub'] != '') {
		$QueryString .='&sub='.$_GET['sub'];
		$RunQuery = 1;
}
if ($_GET['t'] != '') {
		$QueryString .='&t='.$_GET['t'];
		$RunQuery = 1;
}

if ($_GET['tags'] != '') {
		$TabQuery .='&tags='.$_GET['tags'];
		$RunQuery = 1;
}

if ($_GET['genre'] != '') {
		$TabQuery .='&genre='.$_GET['genre'];
		$RunQuery = 1;
}
$QueryString .= $TabQuery;

$NumItemsPerPage = $UserResultsNumber;
$NumItemsPerPage = $_GET['c'];
if ($NumItemsPerPage == '')
	$NumItemsPerPage = 16;

$where = '';
if ($RunQuery == 1) {
 
	$ResultArray = array();
	

				
	$SELECT = "SELECT u.username, u.avatar as UserThumb, vc.ProjectID, vc.UserID as VoltUser";
	
	if (($_GET['content'] != '') || (isset($_GET['t']))) 
		$SELECT .= ", p.Title as ProjectTitle, p.genre as genre, p.thumb as ProjectThumb, p.ProjectID as ProjectID, p.SafeFolder, p.ProjectType, p.userid as ProjectUser, p.installed, p.Published";
			
	if (in_array('blogs',$SearchContentArray)) 
		$SELECT .= ", b.Title as BlogTitle, b.thumb as BlogThumb";
	
	if (in_array('forum',$SearchContentArray)) 
		$SELECT .= ", f.Title as forumTitle, b.thumb as BlogThumb";
	
	//if (in_array('characters',$SearchSubContentArray)) 
		//$SELECT .= ", ch.Name as CharacterName, ch.thumb as CharThumb";
	
	//if (in_array('downloads',$SearchSubContentArray)) 	
		//$SELECT .= ", dl.Name as DownTitle, dl.thumb as DownThumb";

		$SELECT .= " from volt_content as vc";	  
	
	
	if (($_GET['content'] != '') || (isset($_GET['t']))) 
		$where = " where vc.ContentType IN (".$SubContentSearch.")";
		
		$JOIN .= "  JOIN projects as p on vc.ProjectID=p.ProjectID ";

	
	$JOIN .= " JOIN users as u on p.userid=u.encryptid";
	
	if (in_array('blogs',$SearchContentArray)) 
	        $JOIN .= " LEFT JOIN blogs as b on (b.UserID=u.encryptid or p.ProjectID=b.ProjectID)";
			
						
	if ((($_GET['content'] != '') || (isset($_GET['t']))) && (!isset($_GET['sub'])))
		$where = " where p.ProjectType IN (".$ContentSearch.")";
	
	

	if ($_GET['genre'] != '') {
		if ($where == '')  
			$where = " where ";
		else 
			$where .= ' and';
		$where .= " p.genre LIKE '%".$_GET['genre']."%'";
	}
				
	if ($_GET['keywords'] != '') {
		if ($where == '')  
			$where = " where ";
		else 
			$where .= ' and';
						
		$where .= " p.tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or p.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
		
		if (in_array('blogs',$SearchContentArray)) 
			$where .= " and b.Tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or b.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
	
	    if (in_array('forum',$SearchContentArray)) 
			$where .=  "and f.Tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or f.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
		
		if (in_array('blog',$SearchSubContentArray)) 
			$where .= " and bp.Tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or bp.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
			
		if (in_array('characters',$SearchSubContentArray)) 
			$where .= " and ch.Tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or ch.Name LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
			
		if (isset($_GET['sub']))
			$where .= " and pc.Tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or pc.Title LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
		
			
		if (in_array('downloads',$SearchSubContentArray)) 
			$where .= " and dl.Tags LIKE '%".mysql_real_escape_string($_GET['keywords'])."%' or dl.Name LIKE '%".mysql_real_escape_string($_GET['keywords'])."%'";
	
	
	}
	

		if ($where == '')  
			$where = " where ";
		else 
			$where .= ' and ';
		
		$where .= " p.installed = 1 and p.Published=1";
	
	//print_r($SearchContentArray);
	if ((in_array('comic',$SearchContentArray)) && (!isset($_GET['sub'])))
		$where .= " and p.pages>0";
	if ($_GET['sort'] == 'alpha') 
		$ORDERBY .= " ORDER BY p.title ASC";
	if ($_GET['sort'] == 'new')
		$ORDERBY .= " ORDER BY p.createdate DESC";
	if ($_GET['sort'] == 'updated')				
		$ORDERBY .= " ORDER BY p.PagesUpdated DESC";
	if ($_GET['sort'] == 'rank'){	
		$JOIN .= " JOIN rankings as r on p.comiccrypt=r.ComicID";
		$ORDERBY .= " ORDER BY r.ID ASC";
	}
	
	$SearchString =  "<table ><tr>";
	$counter = 0;
	//$LIMIT = ' LIMIT 160';
	$query = $SELECT . $JOIN . $where . $ORDERBY.$LIMIT;
	//print $query.'<br/>';
	$pagination->createPaging($query,$NumItemsPerPage);
	
	while($line=mysql_fetch_object($pagination->resultpage)) {
			$Results = 1;
			$UpdateDay = substr($line->PagesUpdated, 5, 2); 
			$UpdateMonth = substr($line->PagesUpdated, 8, 2); 
			$UpdateYear = substr($line->PagesUpdated, 0, 4);
			$Updated = $UpdateDay.".".$UpdateMonth.".".$UpdateYear;
			
			if ($line->ProjectThumb != ''){
				if (substr($line->ProjectThumb,0,4) != 'http') 
					$ProjectThumb = 'http://www.panelflow.com'.$line->ProjectThumb;
				else 
					$ProjectThumb =$line->ProjectThumb;
					
				$ProjectURL = 'http://www.w3volt.com/'.$line->SafeFolder.'/';
			} else if ($line->UserThumb != ''){
				$ProjectThumb  = $line->UserThumb;
				$ProjectURL = 'http://users.w3volt.com/'.trim($line->username).'/';
			} 
			
			if ($line->ProjectTitle != '')
				$ProjectTitle = $line->ProjectTitle;
			else
				$ProjectTitle = $line->username;
				
			$GenreArray = explode(',',$line->genre);
			$Genres = $GenreArray[0];
			if (trim($GenreArray[1]) != '')
				$Genres .= ', '.$GenreArray[1];
				
			if (isset($_GET['sub'])) {
			
				$ProjectThumb = 'http://www.panelflow.com/'.$line->ContentThumb;
				$HeaderTitle = stripslashes($line->ContentTitle);
				if ($line->ContentType == 'characters')
					$ProjectURL .= 'characters/';
			
			} else {
				$HeaderTitle = stripslashes($ProjectTitle);
			}
				$SearchString .= "<td valign='top' style='padding:3px;'><div><table border='0' cellspacing='0' cellpadding='0' width='160'><tr><td id=\"updateBox_TL\"></td><td id=\"updateBox_T\"></td><td id=\"updateBox_TR\"></td></tr><tr><td class=\"updateboxcontent\"></td><td valign='top' class=\"updateboxcontent\"><table width='100%'><tr><td width='55'><a href='#' onclick='parent.window.location=\"".$ProjectURL."\";return false;'><img src='/includes/round_images_inc.php?source=".$ProjectThumb."&radius=20&colour=e9eef4' border='0' alt='LINK' width='50' height='50'></a></td><td valign='top' ><div class='sender_name'>".$HeaderTitle."</div><div class='messageinfo' style='font-size:10px;'>".stripslashes($ProjectTitle)."</div></td></tr></table></td><td class=\"updateboxcontent\"></td></tr><tr><td id=\"updateBox_BL\"></td><td id=\"updateBox_B\"></td><td id=\"updateBox_BR\"></td></tr></table></div></td>";
				 $counter++;
					if ($counter == 2){
						$SearchString .= "</tr><tr>";
						$counter = 0;
					}
					
				
	 }
 
 	if ($counter < 2) {
					while($counter < 2) {
						$SearchString .= "<td></td>";
						$counter++;
					}
				
	}
 $SearchString .= "</tr></table>";
 
 }

if ($Results == 0)
	$SearchString .=  "<div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div class='spacer'></div><div align='center' style='font-weight:bold;'>There are no comics that fit your search.</div>";
?>
<LINK href="http://www.w3volt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://www.w3volt.com/scripts/fancy_inputs.js"></script>
<script type="text/javascript">
function expand_div(value) {
	ValueArray = value.split('_');
	
	var divstate = document.getElementById(value).style.display;
	if (divstate == '') {
		document.getElementById(value).style.display = 'none';
		document.getElementById(ValueArray[0]+'_arrow').src ='http://www.w3volt.com/images/search_arrow_closed.jpg';
	}else{
		document.getElementById(value).style.display = '';
		document.getElementById(ValueArray[0]+'_arrow').src ='http://www.w3volt.com/images/search_arrow_open.jpg';
	}

}


function do_search(sortvalue) {
	var Keywords = document.getElementById('keywords').value;
	var SortValue = sortvalue.id;
	
	if (SortValue == null){
		SortValue = '';
		//alert(SortValue);
	}	
	var Content = '';
	var Genre = '';
	var Creator = '';
	var QueryString = '';
	var Sub = '';
	for(i=0; i<document.searchForm.elements.length; i++){
		
		if ((document.searchForm.elements[i].name.indexOf('content') == 0) && (document.searchForm.elements[i].checked == 1)){
			if (Content != '')
				Content += ',';
			Content += document.searchForm.elements[i].value;
		}
		if ((document.searchForm.elements[i].name.indexOf('sub') == 0) && (document.searchForm.elements[i].checked == 1)){
			if (Sub != '')
				Sub += ',';
			Sub += document.searchForm.elements[i].value;
		}
		
		if ((document.searchForm.elements[i].name.indexOf('sort') == 0) && (document.searchForm.elements[i].checked == 1)){
		
			Sort = document.searchForm.elements[i].value;
		}
		
		if ((document.searchForm.elements[i].name.indexOf('genre') == 0) && (document.searchForm.elements[i].checked == 1)){
			if (Genre != '')
				Genre += ',';
			Genre += document.searchForm.elements[i].value;
		}
		
		if ((document.searchForm.elements[i].name.indexOf('creator') == 0) && (document.searchForm.elements[i].checked == 1)){
			if (Creator != '')
				Creator += ',';
			Creator += document.searchForm.elements[i].value;
		}
		
	}
	
	
	if ((Keywords != '') && (Keywords != 'enter keywords'))
		QueryString += '?keywords='+Keywords;
	//alert('content = ' + Content);
	if (Content != '') {
		if (QueryString == '')
			QueryString +='?';
		else
			QueryString += '&';
		
		QueryString  += 'content='+escape(Content);
	
	}
	
	if (Sub != '') {
		if (QueryString == '')
			QueryString +='?';
		else
			QueryString += '&';
		
		QueryString  += 'sub='+escape(Sub);
	
	}
	
	var TabSelect = '<? echo $_GET['t'];?>';
	
	if (TabSelect != ''){
	
		if (QueryString == '')
			QueryString +='?';
		else
			QueryString += '&';
		
		QueryString  += 't=<? echo $_GET['t'];?>';
	}	
	//alert('got here');
	if (Genre != '') {
		if (QueryString == '')
			QueryString +='?';
		else
			QueryString += '&';
		
		QueryString  += 'genre='+escape(Genre);
	
	}
	
	
	if (Creator != '') {
		if (QueryString == '')
			QueryString +='?';
		else
			QueryString += '&';
		
		QueryString  += 'creator='+escape(Creator);
	
	}	
	
	if (SortValue != ''){
		if (QueryString == '')
			QueryString +='?';
		else
			QueryString += '&';
		
		QueryString  += 'sort='+escape(SortValue);
	//alert('String' + QueryString);
	}
	
	window.location = '/get_search.php'+QueryString;	
	//var QueryString = ?


}
</script>
<style type="text/css">
	<!--
#modrightside {
	width: 9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/right_side.png);
	background-repeat:repeat-y;
}

#modleftside {
	width: 9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/left_side.png);
	background-repeat:repeat-y;
}

#modtop {
	height:38px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_bar.png);
	background-repeat:repeat-x;
}

.boxcontent {
	color:#000000;
	background-color:#FFFFFF;
}

#modbottom {
	height:9px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_bar.png);
	background-repeat:repeat-x;
}

#modbottomleft{
	width:9px;
	height:9px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_left.png);
	background-repeat:no-repeat;
}

#modtopleft{
	width:9px;
	height:38px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_left.png);
	background-repeat:no-repeat;
}

#modtopright{
	width:31px;
	height:38px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/top_right.png);
	background-repeat:no-repeat;
}

#modbottomright{
	width:31px;
	height:9px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/bottom_right.png);
	background-repeat:no-repeat;
}
#updateBox_T {
background-color:#e9eef4;
height:8px;
}

.updateboxcontent {
	color:#000000;
	background-color:#e9eef4;
}

#updateBox_B {
background-color:#e9eef4;
height:8px;
 
}


#updateBox_TL{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com/images/update_wrapper_TL.png);
	background-repeat:no-repeat;
}

#updateBox_TR{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com/images/update_wrapper_TR.png);
	background-repeat:no-repeat;
}

#updateBox_BR{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com/images/update_wrapper_BR.png);
	background-repeat:no-repeat;
}
#updateBox_BL{
	width:8px;
	height:8px; 
	background-image:url(http://www.w3volt.com/images/update_wrapper_BL.png);
	background-repeat:no-repeat;
}

.spacer {
height:10px;
}

#searchrightside {
	width: 30px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/my_volt_R_yellow.png);
	background-repeat:repeat-y;
}

#searchleftside {
	width: 14px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/my_volt_L_yellow.png);
	background-repeat:repeat-y;
}

#searchtop {
	height:52px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/my_search_T_yellow.png);
	background-repeat:repeat-x;
}

.boxcontent {
	color:#000000;
	background-color:#FFFFFF;
}

#searchbottom {
	height:11px;
	background-image:url(http://www.w3volt.com/templates/modules/standard/my_volt_B_yellow.png);
	background-repeat:repeat-x;
}

#searchbottomleft{
	width:14px;
	height:11px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/my_volt_BL_yellow.png);
	background-repeat:no-repeat;
}

#searchtopleft{
	width:14px;
	height:52px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/my_search_TL_yellow.png);
	background-repeat:no-repeat;
}

#searchtopright{
	width:31px;
	height:52px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/my_search_TR_yellow.png);
	background-repeat:no-repeat;
}

#searchbottomright{
	width:31px;
	height:11px; 
	background-image:url(http://www.w3volt.com/templates/modules/standard/my_volt_BR_yellow.png);
	background-repeat:no-repeat;
}


.tabactive {
height:12px;
background-color:#f58434;
text-align:center;
padding:5px;
cursor:pointer;
font-weight:bold;
font-size:12px;
}
.tabinactive {
height:12px;
background-color:#dc762f;
text-align:center;
padding:5px;
cursor:pointer;
color:#FFFFFF;
font-size:12px;
}
.tabhover{
height:12px;
background-color:#ffab6f;
color:#000000;
text-align:center;
padding:5px;
cursor:pointer;
font-size:12px;
}

-->
</style>

 <form name='searchForm' id='searchForm' onSubmit='return false'>
        <div class="spacer"></div>
        
        <table height="650" border="0" cellspacing="0" cellpadding="0">
<tr>
	<td id="searchtopleft"></td>

	<td id="searchtop" valign="bottom">
	
	<table border="0" cellpadding="0" cellspacing="0">
	  <tbody>
	    <tr>
	      <td  style="padding-bottom:5px;"><img src="http://www.w3volt.com/images/w3search_logo.png" /></td><td width="5"></td>
	      <td valign="bottom"><img id="all_tab" <? if ($_GET['t'] != ''){?>src="http://www.w3volt.com/images/search_all_tab_inactive.png" onclick="window.location='/get_search.php<? echo $TabQuery;?>';" onmouseover="this.src='http://www.w3volt.com/images/search_all_tab_active.png'" onmouseout="roll_over(this, 'http://www.w3volt.com/images/search_all_tab_inactive.png')" <? } else {?>src="http://www.w3volt.com/images/search_all_tab_active.png"<? }?> class="navbuttons" vspace="1" /></td>
<td width="4"></td><td align="left" valign="bottom"><img id="comics_tab" <? if ($_GET['t'] != 'comic'){?>src="http://www.w3volt.com/images/search_comics_tab_inactive.png" onClick="window.location='/get_search.php?t=comic<? echo $TabQuery;?>';" onMouseOver="roll_over(this, 'http://www.w3volt.com/images/search_comics_tab_active.png')" onMouseOut="roll_over(this, 'http://www.w3volt.com/images/search_comics_tab_inactive.png')" <? } else {?>src="http://www.w3volt.com/images/search_comics_tab_active.png"<? }?> class="navbuttons" vspace="1" /></td>

<td width="2"></td><td align="left" valign="bottom"><img id="blogs_tab" <? if ($_GET['t'] != 'blogs'){?>src="http://www.w3volt.com/images/search_blogs_tab_inactive.png" onClick="window.location='/get_search.php?t=blogs<? echo $TabQuery;?>';" onMouseOver="roll_over(this, 'http://www.w3volt.com/images/search_blogs_tab_active.png')" onMouseOut="roll_over(this, 'http://www.w3volt.com/images/search_blogs_tab_inactive.png')" <? } else {?>src="http://www.w3volt.com/images/search_blogs_tab_active.png"<? }?> class="navbuttons" vspace="1" /></td>

<td width="2"></td><td align="left" valign="bottom"><img id="forums_tab" <? if ($_GET['t'] != 'forums'){?>src="http://www.w3volt.com/images/search_forums_tab_inactive.png" onClick="window.location='/get_search.php?t=forums<? echo $TabQuery;?>';" onMouseOver="roll_over(this, 'http://www.w3volt.com/images/search_forums_tab_active.png')" onMouseOut="roll_over(this, 'http://www.w3volt.com/images/search_forums_tab_inactive.png')" <? } else {?>src="http://www.w3volt.com/images/search_forums_tab_active.png"<? }?> class="navbuttons" vspace="1" /></td><td width="5"></td><td align="left" valign="bottom"><div style="height:3px;"></div><img id="movies_tab" <? if ($_GET['t'] != 'movies'){?>src="http://www.w3volt.com/images/search_movies_tab_inactive.png" vspace="1" /><? }?></td>
<td width="2"></td><td  align="left" valign="bottom"><img id="music_tab" <? if ($_GET['t'] != 'music'){?>src="http://www.w3volt.com/images/search_music_tab_inactive.png" vspace="1" /><? }?></td></tr></table>
<div class="spacer"></div>  <div style="height:4px;"></div> 
</td>
<td id="searchtopright" valign="top" align="right"></td>

</tr>
<tr>
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">	
	<tr> 
	<td id="searchleftside"></td>
	<td class="boxcontent" valign="top">

        <table><tr>
        <td  valign="top" style="padding-left:5px;" width="170">
   
     
      <div class="spacer"></div>
         <table border="0" cellspacing="0" cellpadding="0" width="165">
<tr>
	<td id="modtopleft"></td>

	<td id="modtop" align="left"><img src="http://www.w3volt.com/images/search_filters_header.jpg" /><div style="height:5px;"></div></td><td id="modtopright" valign="top" align="right"><a href="#"><img src="http://www.w3volt.com/templates/modules/standard/volt_sm.png" hspace="3" vspace="3" border="0"></a></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
    
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

<div style="height:590px; overflow:auto;" align="left">
<input type="button" onClick="do_search('');" value="APPLY FILTERS"/>

    	<div id="content_filters_container">
            <div style="background-image:url(http://www.w3volt.com/images/search_sub_header_bg.png); background-repeat:no-repeat; height:17px;width:133px;font-size:12px;" align="left" >&nbsp;<a href="#" onClick="expand_div('content_filters');return false;"><img src="http://www.w3volt.com/images/search_arrow_<? if (($_GET['sub'] != '') || (isset($_GET['content']))) {?>open<? } else {?>closed<? }?>.jpg" hspace='2' class="navbuttons" border="0" id="content_arrow"/></a>CONTENT</div>
                
                <div id="content_filters" align="center" style="padding-top:5px; <? if (($_GET['sub'] != '') || (isset($_GET['content']))) {?>display:block;<? } else {?>display:none;<? }?>">
               <? if (!isset($_GET['t'])) {?>
                <table width="90%">
                	<tr>
                		<td><input type="checkbox" class="styled" value="art" name="content_1" id="content_1" <? if (in_array('art',$SearchContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Art</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="blog" name="content_2" id="content_2" <? if (in_array('blog',$SearchContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Blog</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="comic" name="content_3" id="content_3" <? if (in_array('comic',$SearchContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Comic</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="forum" name="content_4" id="content_4" <? if (in_array('forum',$SearchContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Forum</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="movies" name="content_5" id="content_5" <? if (in_array('movies',$SearchContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Movies</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="music" name="content_6" id="content_6" <? if (in_array('music',$SearchContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Music</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="tv" name="content_7" id="content_7" <? if (in_array('tv',$SearchContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">TV</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="writing" name="content_8" id="content_8" <? if (in_array('writing',$SearchContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Writing</td>
                    </tr>
                     <tr>
                		<td> <input type="checkbox" class="styled" value="tutorials" name="content_9" id="content_9" <? if (in_array('tutorials',$SearchContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Tutorials</td>
                    </tr>
                 </table>
				 <? } else if ($_GET['t'] == 'comic') {?>
				   <table width="90%">
                	<tr>
                		<td><input type="checkbox" class="styled" value="characters" name="sub_1" id="sub_1" <? if (in_array('characters',$SearchSubContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Characters</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="downloads" name="sub_2" id="sub_2" <? if (in_array('downloads',$SearchSubContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Downloads</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="mobile" name="sub_3" id="sub_3" <? if (in_array('mobile',$SearchSubContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Mobile</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="extras" name="sub_4" id=sub"sub_4" <? if (in_array('extras',$SearchSubContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Extras</td>
                    </tr>
					<tr>
                		<td><input type="checkbox" class="styled" value="pages" name="sub_4" id=sub"sub_4" <? if (in_array('pages',$SearchSubContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Pages</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" class="styled" value="blog post" name="sub_5" id="sub_5" <? if (in_array('blog post',$SearchSubContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Blog Posts</td>
                    </tr>
					  <tr>
                		<td><input type="checkbox" class="styled" value="forum" name="sub_6" id="sub_6" <? if (in_array('forum',$SearchSubContentArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Forum Threads</td>
                    </tr>
                   
                 </table>
				 
				 
				 
				 
				 <? }?>

         </div>
         
         </div>
         <div class="smspacer"></div>
    
         <!-- GENRE FILTERS -->
         <div id="genre_filters_container">
            <div style="background-image:url(http://www.w3volt.com/images/search_sub_header_bg.png); background-repeat:no-repeat; height:17px;width:133px;font-size:12px;"  align="left">&nbsp;<a href="#" onClick="expand_div('genre_filters');return false;"><img src="http://www.w3volt.com/images/search_arrow_<? if ($_GET['genre'] != '') {?>open<? } else {?>closed<? }?>.jpg" hspace='2' class="navbuttons" border="0" id="genre_arrow"/></a>GENRES</div>
            

                <div id="genre_filters" align="center" style="padding-top:5px; display:<? if ($_GET['genre'] != '') {?>block<? } else {?>none<? }?>;">
                <table width="90%">
                	<tr>
                		<td> <input type="checkbox" id="genre_1" name="genre_1" class="styled"  value="Comedy" <? if (in_array('Comedy',$SearchGenreArray)) echo 'checked';?> /></td>
                    	<td class="search_colum">Comedy</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="genre_2" name="genre_2" class="styled" value="Fantasy" <? if (in_array('Fantasy',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Fantasy</td>
                    </tr>
                    <tr>
                		<td> <input type="checkbox" id="genre_3" name="genre_3"  class="styled" value="Horror" <? if (in_array('Horror',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Horror</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="genre_4" name="genre_4"  class="styled" value="Sci-Fi" <? if (in_array('Sci-Fi',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">SciFi</td>
                    </tr>
                    <tr>
                		<td> <input type="checkbox" id="genre_5" name="genre_5"  class="styled" value="Parody" <? if (in_array('Parody',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Parody</td>
                    </tr>
                    <tr>
                		<td> <input type="checkbox" id="genre_6" name="genre_6"  class="styled" value="Drama"<? if (in_array('Drama',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Drama</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="genre_7" name="genre_7"  class="styled" value="Western" <? if (in_array('Western',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Western</td>
                    </tr>
                    <tr>
                		<td> <input type="checkbox" id="genre_8" name="genre_8"  class="styled" value="Action" <? if (in_array('Action',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Action</td>
                    </tr>
                     <tr>
                		<td><input type="checkbox" id="genre_9" name="genre_9"  class="styled" value="Realism" <? if (in_array('Realism',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Realism</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="genre_10" name="genre_10"  class="styled" value="Noir" <? if (in_array('Noir',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Noir</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="genre_11" name="genre_11"  class="styled" value="Adventure" <? if (in_array('Adventure',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Adventure</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="genre_12" name="genre_12" class="styled" value="Superhero" <? if (in_array('Superhero',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Superhero</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="genre_13" name="genre_13"  class="styled" value="Thriller" <? if (in_array('Thriller',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Thriller</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="genre_14" name="genre_14"  class="styled" value="Mystery" <? if (in_array('Mystery',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Mystery</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="genre_15" name="genre_15"  class="styled" value="Romance" <? if (in_array('Romance',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Romance</td>
                    </tr>
                    <tr>
                		<td> <input type="checkbox" id="genre_16" name="genre_16"  class="styled" value="War" <? if (in_array('War',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">War</td>
                    </tr>
                 </table>

         </div>
         
         </div>
         
         <div class="smspacer"></div>
         <!-- GENRE FILTERS -->
         <div id="creator_filters_container">
            <div style="background-image:url(http://www.w3volt.com/images/search_sub_header_bg.png); background-repeat:no-repeat; height:17px;width:133px;font-size:12px;" align="left">&nbsp;<a href="#" onClick="expand_div('creator_filters');return false;"><img src="http://www.w3volt.com/images/search_arrow_<? if ($_GET['user'] != '') {?>open<? } else {?>closed<? }?>.jpg" hspace='2' class="navbuttons" border="0" id="creator_arrow"/></a>CREATOR</div>
                
                <div id="creator_filters" align="center" style="padding-top:5px; display:<? if ($_GET['user'] != '') {?>block<? } else {?>none<? }?>;">
                <table width="90%">
                	<tr>
                		<td> <input type="checkbox" id="creator_1" class="styled" name="creator_1" value="users" <? if (in_array('users',$SearchCreatorArray)) echo 'checked';?> /></td>
                    	<td class="search_colum">Creators</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="creator_2" name="creator_2" class="styled" value="publishers" <? if (in_array('Publishers',$SearchCreatorArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Publishers</td>
                    </tr>                 
                 </table>

         </div>
         
         </div>
         
           <div class="spacer"></div>
          <div class="smspacer"></div>
         <!-- GENRE FILTERS -->
         <div id="keyword_filters_container">
            <div style="background-image:url(http://www.w3volt.com/images/search_sub_header_bg.png); background-repeat:no-repeat; height:17px;width:133px;font-size:12px;" align="left">&nbsp;<a href="#" onClick="expand_div('keyword_filters');return false;"><img src="http://www.w3volt.com/images/search_arrow_open.jpg" hspace='2' class="navbuttons" border="0" id="keyword_arrow"/></a>KEYWORDS</div>
                
                <div id="keyword_filters" align="left" style="padding-top:5px;">
                 <input type="text" name="keywords" id="keywords" value="enter keywords" onFocus="doClear(this);" onBlur="setDefault(this);"  style="width:130px;"/>
         </div>
         
         </div>
         
         
         <div class="smspacer"></div>
         <!-- GENRE FILTERS -->
         <div id="site_filters_container">
            <div style="background-image:url(http://www.w3volt.com/images/search_sub_header_bg.png); background-repeat:no-repeat; height:17px;width:133px;font-size:12px;" align="left">&nbsp;<a href="#" onClick="expand_div('site_filters');return false;"><img src="http://www.w3volt.com/images/search_arrow_<? if ($_GET['pull'] != '') {?>open<? } else {?>closed<? }?>.jpg" hspace='2' class="navbuttons" border="0" id="site_arrow"/></a>SITE SEARCHES</div>
                
                <div id="site_filters" align="center" style="padding-top:5px; display:<? if ($_GET['pull'] != '') {?>block<? } else {?>none<? }?>;">
                <table width="90%">
                	<tr>
                		<td> <input type="checkbox" id="site_1" class="styled" name="site_1" value="top100" <?php if (isset($_POST['site_1'])) { echo "checked"; }?> /></td>
                    	<td class="search_colum">Top 100</td>
                    </tr>
                    <tr>
                		<td><input type="checkbox" id="site_2" name="site_2" class="styled" value="new" <?php if (isset($_POST['site_2'])) { echo "checked"; }?>/></td>
                    	<td class="search_colum">New</td>
                    </tr> 
                     <tr>
                		<td><input type="checkbox" id="site_3" name="site_3" class="styled" value="featured" <?php if (isset($_POST['site_3'])) { echo "checked"; }?>/></td>
                    	<td class="search_colum">Featured</td>
                    </tr>                
                 </table>

         </div>
         
         </div>
         
              <div class="spacer"></div>
              
              <? echo $SavedSearchSelect;?>
         
</div>

	</td>
	<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
</tr>
 
<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
</table>
        </td>
        <td valign="top" style="padding-right:10px;padding-left:5px;">
          <div class="spacer"></div>
         <table border="0" cellspacing="0" cellpadding="0" width="170">
<tr>
	<td id="modtopleft"></td>

	<td id="modtop" align="left"><img src="http://www.w3volt.com/images/search_sort_header.jpg" /><div style="height:5px;"></div></td><td id="modtopright" valign="top" align="right"><a href="#"><img src="http://www.w3volt.com/templates/modules/standard/volt_sm.png" hspace="3" vspace="3" border="0"></a></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top">

<div style="height:590px; overflow:auto;" align="center">
<? if ((isset($_GET['t'])) || (isset($_GET['content']))) {?>
<div id="sort_filters_container">

            <div style="background-image:url(http://www.w3volt.com/images/search_sub_header_bg.png); background-repeat:no-repeat; height:17px;width:133px;font-size:12px;" align="left">&nbsp;<a href="#" onClick="expand_div('sort_filters');return false;"><img src="http://www.w3volt.com/images/search_arrow_open.jpg" hspace='2' class="navbuttons" border="0" id="genre_arrow"/></a>LIST BY</div>
            

                <div id="sort_filters" align="center" style="padding-top:5px;">
                <table width="90%">
                	<tr>
                		<td> <input type="radio" id="alpha" name="sort"  value="alpha" <? if ($_GET['sort'] == 'alpha') echo 'checked';?> onChange="do_search(this)"/></td>
                    	<td class="search_colum">Alphabetical</td>
                    </tr>
                    <tr>
                		<td><input type="radio" id="new" name="sort" value="new" <? if ($_GET['sort'] == 'new') echo 'checked';?> onChange="do_search(this)"/></td>
                    	<td class="search_colum">Newest</td>
                    </tr>
                    <tr>
                		<td><input type="radio" id="updated" name="sort"  value="updated" <? if ($_GET['sort'] == 'updated') echo 'checked';?> onChange="do_search(this)"/></td>
                    	<td class="search_colum">Last Updated</td>
                    </tr>
                    <tr>
                		<td><input type="radio" id="rank" name="sort"  value="rank" <? if (($_GET['sort'] == 'rank') || ($_GET['sort'] == '')) echo 'checked';?> onChange="do_search(this)"/></td>
                    	<td class="search_colum">Ranking</td>
                    </tr>
                   
                 </table>

   
			 </div>
			 
         </div>
		  <? } else {?>
		  		Start a search to bring up the sorting options.
		   <? }?>
         </div>
		
		 
		 
		

	</td>
	<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
</tr>

<tr>
	<td id="modbottomleft"></td>
	<td id="modbottom"></td>
	<td id="modbottomright"></td>
</tr>
</table>
        </td>
        <td valign="top">
  <div class="spacer"></div>
            <table border="0" cellspacing="0" cellpadding="0" width="370">
<tr>
	<td id="modtopleft"></td>

	<td id="modtop" align="left" valign="top" width="330"><div style="height:3px;"></div><img src="http://www.w3volt.com/images/search_results_header.jpg" /><img src="http://www.w3volt.com/images/search_save_search.jpg" /></td><td id="modtopright" valign="top" align="right" ><a href="#"><img src="http://www.w3volt.com/templates/modules/standard/volt_sm.png" hspace="3" vspace="3" border="0"></a></td>

</tr>
<tr>
	
	<td  valign="top" colspan="3">
	
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
	<td id="modleftside"></td>
	<td class="boxcontent" valign="top" align="center">

	<div class="pagelinksright" style="background-image:url(http://www.w3volt.com/images/search_results_bg.jpg); background-repeat:no-repeat;height:37px;width:324px; font-size:10px;" align="center"><? /*<font color="#FFFFFF">SHOW # [<a href="/search/?c=16<? echo $QueryString;?>">16</a>]&nbsp;[<a href="/search/?c=25<? echo $QueryString;?>">25</a>]&nbsp;[<a href="/search/?c=50<? echo $QueryString;?>">50</a>]&nbsp;[<a href="/search/?c=80<? echo $QueryString;?>">80</a>]</font> &nbsp;&nbsp; <? */?><div style="height:5px;"></div><? echo $pagination->displayPaging();?></div>
<div class="spacer"></div>
<? if ($Results == 0)
	echo '<div class="warning" style="padding-top:50px;">There are no results for your search.</div><div class="spacer"></div><div align="center"><a href="/cms/edit/'.$SafeFolder.'/?section='.$Section.'&a=new"><img src="/'.$PFDIRECTORY.'/images/create_new.png" border="0"></a></div><div style="height:250px;"></div>';
else{?><div style="height:500px; overflow:auto;" align="center"><?  echo $SearchString;?></div><? } ?>

<div class="spacer"></div>
<div class="pagelinksright" style="background-image:url(http://www.w3volt.com/images/search_results_bg.jpg); background-repeat:no-repeat;height:37px;width:324px;" align="center"><? /*<font color="#FFFFFF">SHOW # [<a href="/search/?c=16<? echo $QueryString;?>">16</a>]&nbsp;[<a href="/search/?c=25<? echo $QueryString;?>">25</a>]&nbsp;[<a href="/search/?c=50<? echo $QueryString;?>">50</a>]&nbsp;[<a href="/search/?c=80<? echo $QueryString;?>">80</a>]</font> &nbsp;&nbsp; <? */?><div style="height:5px;"></div><? echo $pagination->displayPaging();?></div>

	</td>
	<td id="modrightside"></td>

	</tr>
	</table>
	
	</td>
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
	<td id="searchrightside"></td>

	</tr> 
	</table>

</form>
	</td>
</tr>

<tr>
	<td id="searchbottomleft"></td>
	<td id="searchbottom"></td>
	<td id="searchbottomright"></td>
</tr>
</table>