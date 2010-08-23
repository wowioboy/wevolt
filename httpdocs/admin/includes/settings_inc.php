<? 
$db = new DB();
$query = "select * from settings";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$SiteTitle = $line->SiteTitle;
	$FrontPage = $line->FrontPage;
	$MenuLayout = $line->MenuLayout;
	$Copyright = $line->Copyright;
	$Keywords = $line->Keywords;
	$Description = $line->Description;
}

//$query = "select * from pf_gallery";
//$db->query($query);
//while ($line = $db->fetchNextObject()) { 
//	$ResizeImage = $line->ResizeImage;
//	$ImageSize = $line->ImageSize;
//}

//$query = "select * from pf_store";
//$db->query($query);
//while ($line = $db->fetchNextObject()) { 
	//$StoreResizeImage = $line->ResizeImage;
	//$StoreImageSize = $line->ResizeSize;
	//$StoreTitle = $line->Title;
	//$StoreWidth = $line->MaxWidth;
	//$StoreHeight = $line->MaxHeight;
	//$BuyButton = $line->BuyButton;
	//$AddCart = $line->AddCart;
	//$ViewCart = $line->ViewCart;
	//$NumFeaturedItems = $line->NumFeaturedItems;
	//$ShowCategoryMenu = $line->ShowCategoryMenu;
	//$ShowFeaturedMenu = $line->ShowFeaturedMenu;
	//$ThankYou = $line->ThankYou;
	//$MerchantEmail = $line->PayPalEmail;
	//$ShowAddCart = $line->ShowAddCart;
	//$ShowViewCart = $line->ShowViewCart;
	
//}

$query = "select * from pf_blog";
$db->query($query);
while ($line = $db->fetchNextObject()) { 
	$BlogPosts = $line->NumberOfPosts;
	$BlogTitle = $line->BlogTitle;
	$AllowComments = $line->AllowComments;
	$ShowCalendar = $line->ShowCalendar;
	$ShowBlogRoll = $line->ShowBlogRoll;
	$ShowBlogRSS = $line->ShowBlogRSS;
}

$query = "select * from sidebar";
$SidebarSettings = $db->queryUniqueObject($query);
$SidebarLayout = $SidebarSettings->SidebarLayout;
$SidebarWidth = $SidebarSettings->Width;
$SidebarVisibile = $SidebarSettings->Published;
$SidebarBackgroundColor = $SidebarSettings->BackgroundColor;

$query = "select * from frontpage";
$FrontPageSettings = $db->queryUniqueObject($query);

$ContentModule = $FrontPageSettings->ContentModule;

	$ContentCategory = explode(",", $FrontPageSettings->ContentCategory);
	$ContentCatCount = sizeof($ContentCategory);
	$NumArticles = $FrontPageSettings->NumArticles;
	
	$StaticPageFront =$FrontPageSettings->StaticPageFront;
	$StaticPage = $FrontPageSettings->StaticPage;
	
	$BlogFront = $FrontPageSettings->BlogFront;
	$NumBlogPosts = $FrontPageSettings->NumBlogPosts;
	$BlogCategories = explode(",", $FrontPageSettings->BlogCategories);
	$BlogCatCount = sizeof($BlogCategories);
	
	$FrontGalleryVisible = $FrontPageSettings->FrontGalleryVisible;
	$FrontGallery = $FrontPageSettings->FrontGallery;

	//GET CONTENT CATEGORIES
	$contentcatString = "";
	$query = "select * from categories order by ID ASC";
	$db->query($query);
	$contentcatString = "<select name='txtContentCategory' class='inputstyle' size='3' multiple='yes'>";
	$contentcatString .= "<option value='0'>none</option>";
	while ($line = $db->fetchNextObject()) { 
		$contentcatString .= "<OPTION VALUE='".$line->ID."'";
		$i=0;
		while ($i <= $ContentCatCount) {
			if ($ContentCategory[$i] == $line->ID) {
				$contentcatString .= ' selected';
			}
			$i++;
		}
		
		$contentcatString .= ">".$line->Title."</OPTION>";
	}
	$contentcatString .= "</select>";
	
	//GET BLOG CATEGORIES
	$blogcatString = "";
	$query = "select * from pf_blog_categories order by ID ASC";
	$db->query($query);
	$blogcatString = "<select name='txtBlogCategory' class='inputstyle' size='3' multiple='yes'>";
	$blogcatString .= "<option value='0'>none</option>";
	
	while ($line = $db->fetchNextObject()) { 
		$blogcatString .= "<OPTION VALUE='".$line->ID."'";
		$i=0;
		while ($i <= $BlogCatCount) {
			if ($BlogCategories[$i] == $line->ID) {
				$blogcatString .= ' selected';
			}
			$i++;
		}
		
		$blogcatString .= ">".$line->Title."</OPTION>";
	}
	$blogcatString .= "</select>";
	
	//GET PAGES
	$pageString = "";
	$query = "select * from pages";
	$db->query($query);
	$pageString = "<select name='txtPage' class='inputstyle'>";
	while ($line = $db->fetchNextObject()) { 
		$pageString .= "<OPTION VALUE='".$line->ID."'";
		if ($Category == $line->Category) {
			$pageString .= "selected";
		}
		$pageString .= ">".$line->Title."</OPTION>";
	}
	$pageString .= "</select>";
	
	//$gallString = "";
	//$query = "select * from pf_gallery_galleries";
	//$db->query($query);
	//$gallString = "<select name='txtFrontGallery' class='inputstyle'>";
	//while ($line = $db->fetchNextObject()) { 
	//	$gallString .= "<OPTION VALUE='".$line->ID."'";
	///	if ($Category == $line->Category) {
		//	$gallString .= "selected";
		//}
	//	$gallString .= ">".$line->Title."</OPTION>";
	//}
	//$gallString .= "</select>";

?>

<form method="post" action="admin.php?a=settings" >
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
    SITE SETTINGS
    </div>
    <div><input type='submit' name='btnsubmit' value='SAVE' id='submitstyle' style="text-align:left;"><div class='inputspacer'></div>
    <input type='submit' name='btnsubmit' value='CANCEL' id='submitstyle' style="text-align:left;"></div></td>
    <td class='adminContent' valign="top">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="46%" valign="top" style="padding:10px;" class='listcell'><div class="section_header">GLOBAL SETTINGS </div><div class="spacer"></div>SITE TITLE:<br>
<input type="text" name="txtSiteTitle" class='inputstyle' value="<? echo $SiteTitle; ?>">
<div class="spacer"></div>SITE COPYRIGHT:<br>
<input type="text" name="txtCopyright" class='inputstyle' value="<? echo $Copyright; ?>"><div class="spacer"></div>
MENU LAYOUT:<br>
<input type="radio" name="txtMenuLayout" value="1" <? if ($MenuLayout==1) { echo "checked";} ?>>Horizontal&nbsp;<input type="radio" name="txtMenuLayout" value="2" <? if ($MenuLayout==2) { echo "checked";} ?>>Vertical<div class="spacer"></div>SITE DESCRIPTION: <br />
<textarea name='txtDescription' class="inputstyle" cols="34"><? echo $Description;?></textarea><div class="spacer"></div>META KEYWORDS: <br />
[seperate with a comma]<br />
<textarea name='txtKeywords' class="inputstyle" cols="34"><? echo $Keywords;?></textarea><div class="spacer"></div><hr />
<div class="section_header">GALLERY SETTINGS </div><br />

Always Resize Large Images?<br />
<input type="radio" name="txtResizeImage" value="1" <? if ($ResizeImage==1) { echo "checked";} ?>>Yes
&nbsp;<input type="radio" name="txtResizeImage" value="0" <? if ($ResizeImage==0) { echo "checked";} ?>>No
<br />Maxium Image Size<br />
<input type="text" name="txtImageSize" value="<? if ($ImageSize == "") { echo '1024';} else { echo $ImageSize;} ?>">
<div class="spacer"></div><hr />
<div class="section_header">STORE SETTINGS </div><br />STORE TITLE:
  <br />
  <input type="text" name="txtStoreTitle" value="<? echo $StoreTitle; ?>">
<br />HOW MANY FEATURED ITEMS TO SHOW ON STORE FRONTPAGE?
  <br /> 
 <input type="text" name="txtNumFeaturedItems" value="<? if ($NumFeaturedItems == '') {echo '6';} else { echo $NumFeaturedItems;} ?>"><br />
SHOW CATEGORY MENU IN SIDEBAR?
  <br />
 <input type="radio" name="txtCategoryMenu" value="1" <? if ($ShowCategoryMenu==1) { echo "checked";} ?>>Yes
&nbsp;<input type="radio" name="txtCategoryMenu" value="0" <? if ($ShowCategoryMenu==0) { echo "checked";} ?>>No
<br />
SHOW FEATURED ITEMS IN SIDEBAR?
  <br />
 <input type="radio" name="txtFeaturedMenu" value="1" <? if ($ShowFeaturedMenu==1) { echo "checked";} ?>>Yes
&nbsp;<input type="radio" name="txtFeaturedMenu" value="0" <? if ($ShowFeaturedMenu==0) { echo "checked";} ?>>No
<br />PayPalEmail
Email Associated with PayPal Merchant Account to:<br />
<input type="text" name="txtMerchantEmail" value="<? echo $MerchantEmail; ?>"><br />
Thank You Message after purchase:<br />
<textarea name="txtThankYou" style="width:100%; height:75px;"><? echo $ThankYou;?></textarea><br />

Always Resize Large Images?<br />
<input type="radio" name="txtStoreResizeImage" value="1" <? if ($StoreResizeImage==1) { echo "checked";} ?>>Yes
&nbsp;<input type="radio" name="txtStoreResizeImage" value="0" <? if ($StoreResizeImage==0) { echo "checked";} ?>>No
<br />
Resize Large Images to:<br />
<input type="text" name="txtStoreResizeSize" value="<? if ($StoreImageSize == "") { echo '1024';} else { echo $StoreImageSize;} ?>"><br />
Store Gallery Image Width:<br />
<input type="text" name="txtStoreWidth" value="<? if ($StoreWidth == "") { echo '800';} else { echo $StoreWidth;} ?>"><br />
Store Gallery Image Height:<br />
<input type="text" name="txtStoreHeight" value="<? if ($StoreHeight == "") { echo '600';} else { echo $StoreHeight;} ?>">
<div class="spacer"></div>BUY BUTTON<br />
<? if ($BuyButton == '') { ?> <img src='https://www.paypal.com/en_US/i/btn/btn_paynow_SM.gif' ><? } else { ?><img src='<? echo $BuyButton;?>' /><? }?><div class='spacer'></div>
<div id='logoupload'>You need Flash and Javascript installed</div>
<script type="text/javascript"> 
    var so = new SWFObject('flash/buttons.swf','upload','300','100','9');
		so.addParam('allowfullscreen','true'); 
        so.addParam('allowscriptaccess','true'); 
		so.addVariable('buttontype','buy'); 
        so.write('logoupload'); 
</script><div class="spacer"></div>
Show Add Cart Button?<br />
<input type="radio" name="txtShowAddCart" value="1" <? if ($ShowAddCart==1) { echo "checked";} ?>>Yes
&nbsp;<input type="radio" name="txtShowAddCart" value="0" <? if ($ShowAddCart==0) { echo "checked";} ?>>No<br />
ADD TO CART BUTTON<br />
<? if ($AddCart == '') { ?> <img src='https://www.paypal.com/en_US/i/btn/btn_cart_LG.gif' ><? } else { ?><img src='<? echo $AddCart;?>' /><? }?><div class='spacer'></div>
<div id='addupload'>You need Flash and Javascript installed</div>
<script type="text/javascript"> 
    var so = new SWFObject('flash/buttons.swf','upload','300','100','9');
		so.addParam('allowfullscreen','true'); 
        so.addParam('allowscriptaccess','true'); 
		so.addVariable('buttontype','addcart'); 
        so.write('addupload'); 
</script><div class="spacer"></div>
Show View Cart Button?<br />
<input type="radio" name="txtShowViewCart" value="1" <? if ($ShowViewCart==1) { echo "checked";} ?>>Yes
&nbsp;<input type="radio" name="txtShowViewCart" value="0" <? if ($ShowViewCart==0) { echo "checked";} ?>>No<br />VIEW CART<br />
<? if ($ViewCart == '') { ?> <img src='https://www.paypal.com/en_US/i/btn/view_cart.gif' ><? } else { ?><img src='<? echo $ViewCart;?>' /><? }?><div class='spacer'></div>
<div id='viewupload'>You need Flash and Javascript installed</div>
<script type="text/javascript"> 
    var so = new SWFObject('flash/buttons.swf','upload','300','100','9');
		so.addParam('allowfullscreen','true'); 
        so.addParam('allowscriptaccess','true'); 
		so.addVariable('buttontype','viewcart'); 
        so.write('viewupload'); 
</script>
</td>
    <td width="54%" valign="top" style="padding:10px;" class='listcell'><div class="section_header">FRONTPAGE SETTINGS </div><div class="spacer"></div>
<div class="subsection_header">SHOW CONTENT MODULE </div>
<input type="radio" name="txtContentModule" value='1' <? if ($ContentModule==1) { echo "checked";} ?>>YES &nbsp;<input type="radio" name="txtContentModule"  value='0' <? if ($ContentModule==0) { echo "checked";} ?>>NO &nbsp;<div class="spacer"></div>
SELECT CONTENT CATEGORIES<br />
 [if none selected, module will pull from all published items]<br />
<? echo $contentcatString;?><div class="spacer"></div># of ARTICLES<br />
<input type="text" name="txtNumArticles" value="<? if ($NumArticles == "") { echo '5';} else { echo $NumArticles;} ?>"><hr /><div class="spacer"></div>
<div class="subsection_header">SHOW STATIC PAGE </div><br>
<input type="radio" name="txtStaticPageFront"  value='1'<? if ($StaticPageFront==1) { echo "checked";} ?>>YES &nbsp;<input type="radio" name="txtStaticPageFront"  value='0' <? if (($StaticPageFront==0) ||($StaticPageFront=='')) { echo "checked";} ?>>NO &nbsp;<div class="spacer"></div>
SELECT PAGE TO SHOW <br />
<? echo $pageString; ?><div class="spacer"></div>
<div class="subsection_header">MAKE BLOG FRONTPAGE:</div>
<input type="radio"  value='1' name="txtBlogFront" <? if ($BlogFront==1) { echo "checked";} ?>>YES &nbsp;<input type="radio"  value='0' name="txtBlogFront" <? if ($BlogFront==0) { echo "checked";} ?>>NO &nbsp;<div class="spacer"></div>
SELECT BLOG CATEGORIES<br />
 [if none selected, module will pull from all categories]<br />
<? echo $blogcatString;?><div class="spacer"></div># of POSTS<br />
<input type="text" name="txtNumBlogPosts" value="<? if ($NumBlogPosts == "") { echo '5';} else { echo $NumBlogPosts;} ?>"><div class="spacer"></div><div class="subsection_header">MAKE GALLERY FRONTPAGE:</div>
<input type="radio" name="txtGalleryFront"  value='1' <? if ($FrontGalleryVisible==1) { echo "checked";} ?>>YES &nbsp;<input type="radio" name="txtGalleryFront"   value='0' <? if ($FrontGalleryVisible==0) { echo "checked";} ?>>NO &nbsp;<div class="spacer"></div>SELECT GALLERY TO REPLACE FRONT PAGE:
<? echo	$gallString;?>
<hr/><div class="spacer"></div><div class="section_header">SIDEBAR SETTINGS </div><div class="spacer"></div>
SHOW SIDEBAR ON CONTENT PAGES?<br />
<input type="radio" name="txtSidebarVisible" value="1" <? if ($SidebarVisibile==1) { echo "checked";} ?> />Yes&nbsp;<input type="radio" name="txtSidebarVisible" value="0" <? if ($SidebarVisibile==0) { echo "checked";} ?> />
  No <div class="spacer"></div>
  SIDEBAR LAYOUT <br />
<input type="radio" name="txtSidebarLayout" value="l" <? if ($SidebarLayout=='l') { echo "checked";} ?> />
LEFT&nbsp;
<input type="radio" name="txtSidebarLayout" value="r" <? if ($SidebarLayout=='r') { echo "checked";} ?> />
  RIGHT<div class="spacer"></div>
SIDEBAR WIDTH:
  <br />
  <input type="text" name="txtSidebarWidth" value="<? echo $SidebarWidth; ?>"><div class="spacer"></div><hr/>
<div class="section_header">BLOG SETTINGS </div> <br />BLOG TITLE:
  <br />
  <input type="text" name="txtBlogTitle" value="<? echo $BlogTitle; ?>"><div class="spacer"></div><br />
  How Many Posts Per Page<br />
  <input type="text" name="txtBlogPosts" value="<? echo $BlogPosts; ?>">
    <br />
    <br /> 
  Show Calendar?
  <br />
  <input type="radio" name="txtShowCalendar" value="1" <? if ($ShowCalendar==1) { echo "checked";} ?> />
  Yes
  &nbsp;
  <input type="radio" name="txtShowCalendar" value="0" <? if ($ShowCalendar==0) { echo "checked";} ?> />
  No </p><div class='spacer'></div>
Allow Public Comments? <br />
  <input type="radio" name="txtAllowComments" value="1" <? if ($AllowComments==1) { echo "checked";} ?> />
  Yes
  &nbsp;
  <input type="radio" name="txtAllowComments" value="0" <? if ($AllowComments==0) { echo "checked";} ?> />
  No <div class='spacer'></div>
Show Blog Roll? <br />
  <input type="radio" name="txtShowBlogRoll" value="1" <? if ($ShowBlogRoll==1) { echo "checked";} ?> />
  Yes
  &nbsp;
  <input type="radio" name="txtShowBlogRoll" value="0" <? if ($ShowBlogRoll==0) { echo "checked";} ?> />
  No <div class='spacer'></div>
Show Blog RSS Feed? <br />
  <input type="radio" name="txtShowBlogRSS" value="1" <? if ($ShowBlogRSS==1) { echo "checked";} ?> />
  Yes
  &nbsp;
  <input type="radio" name="txtShowBlogRSS" value="0" <? if ($ShowBlogRSS==0) { echo "checked";} ?> />
  No <br /></td>
    </tr>
</table></td>
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
