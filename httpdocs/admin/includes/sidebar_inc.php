<?
$ModuleDB = new DB();
if ($Application == 'blog') {
		if ($ShowBlogRSS == 1) {
		echo "<div class='rss'><a href='feeds.php?id=1' target='_blank'><img src='../images/rss.gif' border='0'></a></div>";
		}
}
if ($Application == 'store') {
	include 'modules/store_recent_mod.php';

 	if ($ShowCategoryMenu == 1) {
		$catmenuString = "<div class='moduletitle'>Categories</div><div class='storemenu'>";
		$query = "select * from pf_store_categories order by Title";
		$ModuleDB->query($query);
		while ($line = $ModuleDB->fetchNextObject()) { 
		$catmenuString .= "<div class='cat_item_mod'><a href='store.php?cat=".$line->ID."' class='storemenulink'>".$line->Title."</a><span class='menubullet'>>></span></div>";
		}
		$catmenuString .="</div>";
		echo $catmenuString;
		
	}

	 if ($ShowFeaturedMenu == 1) {
  		if ($ShowCategoryMenu == 1) { 
  			echo "<div class='spacer'></div>";
  		}
 		 if ((isset($_GET['id'])) || (isset($_GET['item']))){
			$featuredmenuString = "<div class='moduletitle'>Featured Items</div>";
			$query = "select * from pf_store_items where IsFeatured=1 order by Title limit $NumFeaturedItems";
			$ModuleDB->query($query);
			while ($line = $ModuleDB->fetchNextObject()) { 
				$featuredmenuString .= "<div class='cat_item_mod'><a href='store.php?item=".$line->ID."' class='storemenulink'>".$line->Title."</a></div>";
			}
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
			
			if (($ModuleApplication == 'blog') && ($ModuleID == 2)) { 
				if ($ShowOnFrontPage == 0) {
					if ($CurrentPage != 'front') {
						if ($ShowTitle == 1) {
							echo "<div class='moduletitle'>".$ModuleTitle."</div>";
						}
				 		include 'modules/blog_category_mod.php'; 
					 	echo "<div class='spacer'></div>";
					}
				} else {
						if ($ShowTitle == 1) {
							echo "<div class='moduletitle'>".$ModuleTitle."</div>";
						}
				 		include 'modules/blog_category_mod.php'; 
					 	echo "<div class='spacer'></div>";
				}
			}
			if (($ModuleApplication == 'blog') && ($ModuleID == 3)) { 
				if ($ShowOnFrontPage == 0) {
					if ($CurrentPage != 'front') {
						if ($ShowTitle == 1) {
							echo "<div class='moduletitle'>".$ModuleTitle."</div>";
						}
				 		include 'modules/blog_recent_mod.php'; 
					 	echo "<div class='spacer'></div>";
					}
				} else {
						if ($ShowTitle == 1) {
							echo "<div class='moduletitle'>".$ModuleTitle."</div>";
						}
				 		include 'modules/blog_recent_mod.php'; 
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
				echo '<div class="moduletitle"><div class="moduletitle">Blog Roll</div>';
				while ($line = $ModuleDB->fetchNextObject()) { 
				echo '<div class="cat_item_mod"><a href="'.$line->Url.'" target="_blank">'.$line->Title.'</a></div><div class="linkdescription">'.$line->Description.'</div><div style="height:3px"></div>';
			
				}
				echo '</div>';
			
			}
			
			
			if (isset($_GET['p'])) {
				if ($AllowBlogComments == 1) { ?>
                
                 <div class='moduletitle'>leave a comment:</a></div>
       		   <div class='modulewrapper'>
               <form method="POST" action="index.php?a=blog&p=<?php echo $_GET['p']; ?>">
				<table bgcolor="#CCCCCC" width="200" height="210" style="padding-right:10px;padding-left:6px;">
				<tr><td >
                <input type='text' name='txtName' class='inputstyle' style="width:98%;" onFocus="doClear(this)" value='<? if ($_POST['txtName']=='') { echo 'enter a name'; } else { echo $_POST['txtName']; }?>'/><div class='spacer'></div>
                <textarea rows="6" style="width:98%" name="txtComment" class='inputstyle' onFocus="doClear(this)" id="txtComment"><? if ($_POST['txtComment']=='') { echo 'enter a comment'; } else { echo $_POST['txtComment']; }?></textarea><div class='spacer'></div>    				
			<div align="center">
<img src="captcha/CaptchaSecurityImages.php?width=100&height=40&characters=5" border='2'/>
		<label for="security_code"></label>
		<br />
<input id="security_code" name="security_code" type="text" class='inputstyle' style='width:100px; background-color:#99FFFF;' onFocus="doClear(this)" value='enter code'/></div>
</td></tr>
				<tr><td ><? if ($CommentError != '') { echo "<font style='color:red'>".$CommentError."</font><div class='spacer'></div>";} ?><input type="submit" value="Submit Comment" class='inputstyle'></td></tr>    
				</table>
                <input type="hidden" name="insert" id="insert" value="1">
				</form></div>
        <? }
			} 
			
			}
			
			}
			
		echo '<div class="moduletitle">Copyright</div><div class="cat_item_mod">All content posted on this website remains the copyrighted property of the original poster unless stated otherwise and may not be reproduced without permission.</div>';
			
			?> 
