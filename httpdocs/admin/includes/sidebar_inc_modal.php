<?
$ModuleDB = new DB();
if ($Application == 'blog') {
		if ($ShowBlogRSS == 1) {
		echo "<div class='rss'><a href='feeds.php?id=1' target='_blank'><img src='../images/rss.gif' border='0'></a></div>";
		}
}
if ($Application == 'store') {
 	if ($ShowCategoryMenu == 1) {
		$catmenuString = "<div class='menuheader'>CATEGORIES</div><div class='storemenu'>";
		$query = "select * from pf_store_categories order by Title";
		$ModuleDB->query($query);
		while ($line = $ModuleDB->fetchNextObject()) { 
			$catmenuString .= "<a href='store.php?cat=".$line->ID."' class='storemenulink'>".$line->Title."</a><br/>";
		}
		$catmenuString .="</div>";
		echo $catmenuString;
		
	}

	 if ($ShowFeaturedMenu == 1) {
  		if ($ShowCategoryMenu == 1) { 
  			echo "<div class='spacer'></div>";
  		}
 		 if ((isset($_GET['id'])) || (isset($_GET['item']))){
			$featuredmenuString = "<div class='menuheader'>FEATURED ITEMS</div><div class='storemenu'>";
			$query = "select * from pf_store_items where IsFeatured=1 order by Title limit $NumFeaturedItems";
			$ModuleDB->query($query);
			while ($line = $ModuleDB->fetchNextObject()) { 
				$featuredmenuString .= "<a href='store.php?item=".$line->ID."' class='storemenulink'>".$line->Title."</a><br/>";
			}
			$featuredmenuString .="</div>";
			echo $featuredmenuString;		
		}
	}
} else {
		$query = "select * from modules where published=1 and sidebar=1 order by Position";
		$ModuleDB->query($query);
		while ($line = $ModuleDB->fetchNextObject()) { 
			$ModuleApplication = $line->Application;
			$ModuleID = $line->ModuleID;
			$ModuleTitle = $line->Title;
			$ShowTitle = $line->ShowTitle;
			$ShowOnFrontPage = $line->FrontPage;

			 if (($ModuleApplication == 'gallery') && ($ModuleID == 1)  && ($Application != 'blog')) {
			 	if ($ShowOnFrontPage == 0) {
					if ($CurrentPage != 'front') {
						if ($ShowTitle == 1) {
							echo "<div class='moduletitle'>".$ModuleTitle."</div>";
						}
				 		include 'modules/gallery_image_mod.php'; 
					 	echo "<div class='spacer'></div>";
					}
				} else {
						if ($ShowTitle == 1) {
							echo "<div class='moduletitle'>".$ModuleTitle."</div>";
						}
				 		include 'modules/gallery_image_mod.php'; 
					 	echo "<div class='spacer'></div>";
				}
			}
		//	if (($ModuleApplication == 'content') && ($ModuleID == 1)) { 
			 	//include 'modules/post_calendar.php'; 
			//} 
			if (($ModuleApplication == 'store') && ($ModuleID == 1) && ($Application != 'blog')) { 
				if ($ShowOnFrontPage == 0) {
					if ($CurrentPage != 'front') {
						if ($ShowTitle == 1) {
							echo "<div class='moduletitle'>".$ModuleTitle."</div>";
						}
				 		include 'modules/store_featured.php'; 
					 	echo "<div class='spacer'></div>";
					}
				} else {
						if ($ShowTitle == 1) {
							echo "<div class='moduletitle'>".$ModuleTitle."</div>";
						}
				 		include 'modules/store_featured.php'; 
					 	echo "<div class='spacer'></div>";
				}
			} 
			if (($ModuleApplication == 'blog') && ($ModuleID == 1)) { 
				if ($ShowOnFrontPage == 0) {
					if ($CurrentPage != 'front') {
						if ($ShowTitle == 1) {
							echo "<div class='moduletitle'>".$ModuleTitle."</div>";
						}
				 		include 'modules/post_calendar.php'; 
					 	echo "<div class='spacer'></div>";
					}
				} else {
						if ($ShowTitle == 1) {
							echo "<div class='moduletitle'>".$ModuleTitle."</div>";
						}
				 		include 'modules/post_calendar.php'; 
					 	echo "<div class='spacer'></div>";
				}
			} 
		}
		
		if ($Application == 'blog') {
					$query = "select ShowBlogRoll from pf_blog";
			//print $query;
			$ShowBlogRoll = $ModuleDB->queryUniqueValue($query);
			if ($ShowBlogRoll == 1) {
				$query = "select * from pf_blog_links order by Title";
				$ModuleDB->query($query);
				echo '<div class="blogroll"><div class="moduletitle">BLOG ROLL</div>';
				while ($line = $ModuleDB->fetchNextObject()) { 
				echo '<div class="linktitle"><a href="'.$line->Url.'" target="_blank">'.$line->Title.'</a></div><div class="linkdescription">'.$line->Description.'</div><div style="height:3px"></div>';
			
				}
				echo '</div>';
			
			}
			
			
			if (isset($_GET['p'])) {
				if ($AllowBlogComments == 1) { ?>
                
                 <div class='moduletitle'><a href="javascript:revealModal('commentBox')">[CLICK HERE TO COMMENT]</a></div>
                
                
 <div id="commentBox">
    <div class="commentBoxBackground">
    </div>
    <div class="commentBoxContainer">
        <div class="commentBoxmodal">
            <div class="commentBoxmodalTop"><a href="javascript:hideModal('commentBox')">Close Form [X]</a></div>
            <div class="commentBoxmodalBody">
				<p align="center"><strong>Enter your Comment Below</strong><br /><br />
					   <div class='modulewrapper'>
               <form method="POST" action="index.php?a=blog&p=<?php echo $_GET['p']; ?>">
				<table bgcolor="#CCCCCC" width="450" height="210" style="padding:10px;">
				<tr><td height="159" valign="top"><textarea rows="6" style="width:100%" name="txtComment" id="txtComment"><? echo $_POST['txtComment'];?></textarea><div class='spacer'></div>    				
			<input type='text' name='txtName' class='inputstyle' onFocus="doClear(this)" value='<? if ($_POST['txtName']=='') { echo 'enter a name'; } else { echo $_POST['txtName']; }?>'/><div class='spacer'></div><div align="center">
<img src="captcha/CaptchaSecurityImages.php?width=100&height=40&characters=5" border='2'/>
		<label for="security_code"></label>
		<br />
<input id="security_code" name="security_code" type="text" class='inputstyle' style='width:100px; background-color:#99FFFF;' onFocus="doClear(this)" value='enter code'/></div>
</td></tr>
				<tr><td valign="top"><? if ($CommentError != '') { echo "<font style='color:red'>".$CommentError."</font><div class='spacer'></div>";} ?><input type="submit" value="Submit Comment" class='inputstyle'></td></tr>    
				</table>
                <input type="hidden" name="insert" id="insert" value="1">
				</form></div>
                                      
            </div>
          </div>
    </div>
</div>
		<? }
			} 
			
			}
			
			}?> 
