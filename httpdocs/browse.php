<? 
require_once('includes/init.php');
include 'classes/browse_search.php';
$search = new search();
if ($_GET['content'] == 'comic')
	$PageTitle .= 'comics listing';
$TrackPage = 1;
require_once('includes/pagetop_inc.php');
$Site->drawModuleCSS();

$SearchGenreArray = explode(',',$_GET['genre']);
if ($SearchGenreArray == null)
	$SearchGenreArray  = array();
foreach ($SearchGenreArray as $genre) {
	if ($GenreSearch != '')
		$GenreSearch .= ',';
 	$GenreSearch .= "'".$genre."'";
}

?>
<script type="text/javascript">
function do_search(sortvalue) {
	var Keywords = document.getElementById('content_search').value;
	var SortValue = sortvalue.id;
	if (Keywords == 'enter keywords')
		Keywords = '';
	if (SortValue == null){
		SortValue = '';
		//alert(SortValue);
	}	
	var Content = '';
	var Genre = '';
	
	var QueryString = '';

	for(i=0; i<document.searchForm.elements.length; i++){
			
		if ((document.searchForm.elements[i].name.indexOf('sort') == 0) && (document.searchForm.elements[i].checked == 1)){
		
			Sort = document.searchForm.elements[i].value;
		}
		
		if ((document.searchForm.elements[i].name.indexOf('content') == 0) && (document.searchForm.elements[i].checked == 1)){
			if (Content != '')
				Content += ',';
			Content += document.searchForm.elements[i].value;
		}
		
		if ((document.searchForm.elements[i].name.indexOf('genre') == 0) && (document.searchForm.elements[i].checked == 1)){
			if (Genre != '')
				Genre += ',';
			Genre += document.searchForm.elements[i].value;
		}
		
		
		
	}
	
	if ((Keywords != '') && (Keywords != 'enter keywords'))
		QueryString += '?keywords='+escape(Keywords);
	//alert('content = ' + Content);
	if (Content != '') {
		if (QueryString == '')
			QueryString +='?';
		else
			QueryString += '&';
		
		QueryString  += 'content='+escape(Content);
	
	}
	

	//alert('got here');
	if (Genre != '') {
		if (QueryString == '')
			QueryString +='?';
		else
			QueryString += '&';
		
		QueryString  += 'genre='+escape(Genre);
	
	}
	

	if (SortValue != ''){
		if (QueryString == '')
			QueryString +='?';
		else
			QueryString += '&';
		
		QueryString  += 'sort='+escape(SortValue);
	//alert('String' + QueryString);
	}
	
	window.location = '/browse.php'+QueryString;	
	//var QueryString = ?
}
</script>

<div align="center">
<table cellpadding="0" cellspacing="0" border="0" width="<? echo $TemplateWrapperWidth;?>">
  <tr>
    <td valign="top" align="center">
    <div class="content_bg">
		<? if ($_SESSION['userid'] != '') {?>
            <div id="controlnav">
                <?php $Site->drawControlPanel(); ?>
            </div>
        <? }?>
        <? if ($_SESSION['noads'] != 1) {?>
            <div id="ad_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;" align="center">
                <iframe src="" allowtransparency="true" width="728" height="90" frameborder="0" scrolling="no" name="top_ads" id="top_ads"></iframe>
            </div>
        <?  }?>
       
       
        <div id="header_div" style="background-color:#FFF;width:<? echo $SiteTemplateWidth;?>px;">
           <? $Site->drawHeaderWide();?>
        </div>
    </div>
    
     <div class="shadow_bg">
        	 <? $Site->drawSiteNavWide();?>
    </div>
    
     <div class="content_bg" id="content_wrapper">
         <!--Content Begin -->
         <div class="spacer"></div>
         <table cellspacing="0" cellpadding="0" width="<? echo $SiteTemplateWidth;?>">
             <tr>
                <td valign="top" style="padding-left:10px;" width="300">
                 <form name='searchForm' id='searchForm' onSubmit='return false' style="padding:0px;">
                     <table width="100%" cellspacing="10">
                         <tr>
                            <td > 
                            <img src="http://www.wevolt.com/images/headers/comics_header.png" />&nbsp;&nbsp;&nbsp;
                            </td>
                         </tr>
                       
                        
                        <tr>
                            <td>
                            <input type="checkbox" class="styled" value="comic" name="content_3" id="content_3" <? if (($_GET['content'] == 'comic') || ($_GET['content'] == '')) echo 'checked';?>/> Comics
                            <div class="spacer"></div>
                            <table width="100%"><tr>
                            <td width="80%"><input type="text" name="content_search" id="content_search" value="enter keywords" onFocus="doClear(this);" onBlur="setDefault(this);"  style="width:98%;"/>
                            </td>
                            <td><img src="http://www.wevolt.com/images/job_search_btn.jpg" class="navbuttons" onclick="do_search(this)"/>
                            </td>
                            </tr>
                            </table>
                          <div class="spacer"></div>
                           
                            GENRES
                             <div class="spacer"></div>
                            <table width="90%">
                	<tr>
                		<td> <input type="checkbox" id="genre_1" name="genre_1" class="styled"  value="Comedy" <? if (in_array('Comedy',$SearchGenreArray)) echo 'checked';?> /></td>
                    	<td class="search_colum">Comedy</td>
             
                		<td><input type="checkbox" id="genre_2" name="genre_2" class="styled" value="Fantasy" <? if (in_array('Fantasy',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Fantasy</td>
                    </tr>
                    
                    <tr>
                		<td> <input type="checkbox" id="genre_3" name="genre_3"  class="styled" value="Horror" <? if (in_array('Horror',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Horror</td>
               
                		<td><input type="checkbox" id="genre_4" name="genre_4"  class="styled" value="Sci-Fi" <? if (in_array('Sci-Fi',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">SciFi</td>
                    </tr>
                    
                    <tr>
                		<td> <input type="checkbox" id="genre_5" name="genre_5"  class="styled" value="Parody" <? if (in_array('Parody',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Parody</td>
                   		<td> <input type="checkbox" id="genre_6" name="genre_6"  class="styled" value="Drama"<? if (in_array('Drama',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Drama</td>
                    </tr>
                    
                    <tr>
                		<td><input type="checkbox" id="genre_7" name="genre_7"  class="styled" value="Western" <? if (in_array('Western',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Western</td>
                   
                		<td> <input type="checkbox" id="genre_8" name="genre_8"  class="styled" value="Action" <? if (in_array('Action',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Action</td>
                    </tr>
                    
                     <tr>
                		<td><input type="checkbox" id="genre_9" name="genre_9"  class="styled" value="Realism" <? if (in_array('Realism',$SearchGenreArray)) echo 'checked';?>/></td>
                  <td class="search_colum">Realism</td>
                		<td><input type="checkbox" id="genre_10" name="genre_10"  class="styled" value="Noir" <? if (in_array('Noir',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Noir</td>
                    </tr>
                    
                    <tr>
                		<td><input type="checkbox" id="genre_11" name="genre_11"  class="styled" value="Adventure" <? if (in_array('Adventure',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Adventure</td>
                 
                		<td><input type="checkbox" id="genre_12" name="genre_12" class="styled" value="Superhero" <? if (in_array('Superhero',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Superhero</td>
                    </tr>
                    
                    <tr>
                		<td><input type="checkbox" id="genre_13" name="genre_13"  class="styled" value="Thriller" <? if (in_array('Thriller',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Thriller</td>
                   
                		<td><input type="checkbox" id="genre_14" name="genre_14"  class="styled" value="Mystery" <? if (in_array('Mystery',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Mystery</td>
                    </tr>
                    
                    <tr>
                		<td><input type="checkbox" id="genre_15" name="genre_15"  class="styled" value="Romance" <? if (in_array('Romance',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">Romance</td>
                  
                		<td> <input type="checkbox" id="genre_16" name="genre_16"  class="styled" value="War" <? if (in_array('War',$SearchGenreArray)) echo 'checked';?>/></td>
                    	<td class="search_colum">War</td>
                    </tr>
                 </table>
                 <div class="spacer"></div>
                 SORT BY: <div class="spacer"></div>
                
                              <table width="90%">
                	<tr>
                		<td> <input type="radio" id="alpha" name="sort"  value="alpha" <? if ($_GET['sort'] == 'alpha') echo 'checked';?> onChange="do_search(this)" style="border:none;"/></td>
                    	<td class="search_colum">Alphabetical</td>
                    </tr>
                    <tr>
                		<td><input type="radio" id="new" name="sort" value="new" <? if ($_GET['sort'] == 'new') echo 'checked';?> onChange="do_search(this)" style="border:none;"/></td>
                    	<td class="search_colum">Newest</td>
                    </tr>
                    <tr>
                		<td><input type="radio" id="updated" name="sort"  value="updated" <? if ($_GET['sort'] == 'updated') echo 'checked';?> onChange="do_search(this)" style="border:none;"/></td>
                    	<td class="search_colum">Last Updated</td>
                    </tr>
                    <tr>
                		<td><input type="radio" id="rank" name="sort"  value="rank" <? if (($_GET['sort'] == 'rank') || ($_GET['sort'] == '')) echo 'checked';?> onChange="do_search(this)" style="border:none;"/></td>
                    	<td class="search_colum">Ranking</td>
                    </tr>
                   
                 </table>
                            </td>
                        </tr>
                 
                    </table>
                 </form>
               
                <!-- LEFT AD BOX -->
                 <? if ($_SESSION['noads'] != 1) {?>
                <div id="left_ad_div" style="background-color:#FFF;width:300px;" align="center">
                  <? $Site->drawVideoBoxAd();?>
                </div>
                 <?  }?>
                 
                </td>
                        
                <td valign="top" style="padding-left:10px;padding-top:20px;">
                <? 
	
                        echo $search->getSearch($_GET['content'],$_GET['genre'],$_GET['keywords'],$_GET['sort'],$_GET['filter']);
                   ?>
                </td>
            
            </tr>
         </table>       
    <!--Content End -->
    </div>

	</td>
  </tr>
  <tr>
      <td style="background-image:url(http://www.wevolt.com/images/bottom_frame_no_blue.png); background-repeat:no-repeat;width:1058px;height:12px;">
      </td>
  </tr>
</table>
</div>
  
<?php require_once('includes/pagefooter_inc.php'); ?>


