
<style type="text/css" media="screen">
    #top { 
	outline:none; 
	background-color:#<? echo $ControlBarBGColor;?>;
	}
	#bottomcontrols { 
	outline:none;
	display:block;  
	}
	#mpl {
	outline:none;
	display:block;  
	}
	
	#emailer {
	outline:none;
	display:block;  
	}
	
	#postcalendar {
	outline:none;
	display:block;  
	}
	
	#chardiv {
	outline:none;
	display:block;
	}
	
	#pfreader {
	outline:none;
	display:block;
	}
	#pagediv {
	outline:none;
	display:block;
	}
#bubble_tooltip{
	width:300px;
	position:absolute;
	display:none;
	z-index:3;
}

#bubble_tooltip .bubble_top{
	background-image: url('/<? echo $PFDIRECTORY;?>/images/bubble_top.png');
	background-repeat:no-repeat;
	height:16px;	
}
#bubble_tooltip .bubble_middle{
	background-image: url('/<? echo $PFDIRECTORY;?>/images/bubble_middle.png');
	background-repeat:repeat-y;	
	background-position:bottm left;
	padding-left:7px;
	padding-right:7px;
}
#bubble_tooltip .bubble_middle span{
	position:relative;
	top:-8px;
	font-family: Trebuchet MS, Lucida Sans Unicode, Arial, sans-serif;
	font-size:11px;
}
#bubble_tooltip .bubble_bottom{
	background-image: url('/<? echo $PFDIRECTORY;?>/images/bubble_bottom.png');
	background-repeat:no-repeat;
	background-repeat:no-repeat;	
	height:44px;
	position:relative;
	top:-6px;
}

.smalltext {
font-size:10px;
color:#000000;
padding-left:73px;
font-weight:bold; 
}
</style>

<style type="text/css">
#facebox .body {
  padding: 10px;
  background: #<? echo $ContentBoxBGColor;?>;
  width: 370px;
}

#facebox .b {
  background:url(/<? echo $PFDIRECTORY;?>/scripts/facebox/b.png);
}

#facebox .tl {
  background:url(/<? echo $PFDIRECTORY;?>/scripts/facebox/tl.png);
}

#facebox .tr {
  background:url(/<? echo $PFDIRECTORY;?>/scripts/facebox/tr.png);
}

#facebox .bl {
  background:url(/<? echo $PFDIRECTORY;?>/scripts/facebox/bl.png);
}

#facebox .br {
  background:url(/<? echo $PFDIRECTORY;?>/scripts/facebox/br.png);
} 



.tabactive {
height:12px;
background-color:#<? echo $GlobalTabActiveBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;
<? if ($GlobalTabActiveFontStyle != '') {
if ($GlobalTabActiveFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalTabActiveFontStyle == 'regular')  
	$StyleTag = 'font-style:normal;';
if ($GlobalTabActiveFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';
echo $StyleTag;	
	?>
<? }?>
font-size:<? echo $GlobalTabActiveFontSize;?>px;
width:100px;
color:#<? echo $GlobalTabActiveTextColor;?>;
}
.tabinactive { 
height:12px;
background-color:#<? echo $GlobalTabInActiveBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;
<? if ($GlobalTabInActiveFontStyle != '') {
if ($GlobalTabInActiveFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalTabInActiveFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalTabInActiveFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';
echo $StyleTag;	
	?>
<? }?>
font-size:<? echo $GlobalTabInActiveFontSize;?>px;
width:100px;
color:#<? echo $GlobalTabInActiveTextColor;?>;
}
.tabhover{
height:12px;
background-color:#<? echo $GlobalTabHoverBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;
<? if ($GlobalTabHoverFontStyle != '') {
if ($GlobalTabHoverFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalTabHoverFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalTabHoverFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';
echo $StyleTag;	
	?>
<? }?>
font-size:<? echo $GlobalTabHoverFontSize;?>px;
width:100px;
color:#<? echo $GlobalTabHoverTextColor;?>;
}

.peeltabactive {
height:10px;
background-color:#<? echo $GlobalTabActiveBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;

font-size:10px;
width:50px;
color:#<? echo $GlobalTabActiveTextColor;?>;
}
.peeltabinactive {
height:10px;
background-color:#<? echo $GlobalTabInActiveBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;
font-size:10px;
width:50px;
color:#<? echo $GlobalTabInActiveTextColor;?>;
}
.peeltabhover{
height:10px;
background-color:#<? echo $GlobalTabHoverBGColor;?>;
text-align:center;
padding:5px;
cursor:pointer;
font-size:10px;
width:50px;
color:#<? echo $GlobalTabHoverTextColor;?>;
}

#projectmodrightside { 
<? if ($ModRightSideImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModRightSideImage;?>);
background-repeat:repeat-y;
<? }?>
<? if ($ModRightSideBGColor != '') {?>
background-color:#<? echo $ModRightSideBGColor;?>;
<? } ?>
width: <? echo $CornerWidth;?>px;

}

#projectmodleftside {
<? if ($ModLeftSideImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModLeftSideImage;?>);
background-repeat:repeat-y;
<? }?>
<? if ($ModLeftSideBGColor != '') {?>
background-color:#<? echo $ModLeftSideBGColor;?>;
<? } ?>
width: <? echo $CornerWidth;?>px;
}

#projectmodtop {
<? if ($ModTopImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModTopImage;?>);
background-repeat:repeat-x;
<? }?>
<? if ($ModTopBGColor != '') {?>
background-color:#<? echo $ModTopBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
}

.projectboxcontent {
<? if ($ContentBoxImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ContentBoxImage;?>);
background-repeat:<? echo $ContentBoxImageRepeat;?>;
<? }?>
<? if ($ContentBoxBGColor != '') {?>
background-color:#<? echo $ContentBoxBGColor;?>;
<? } else { ?>
background-color:#ffffff;
<? }?>
<? if ($ContentBoxTextColor != '') {?>
color:#<? echo $ContentBoxTextColor;?>;
<? } else {?>
color:#000000;
<? }?>
<? if ($ContentBoxFontSize != '') {?>
font-size:<? echo $ContentBoxFontSize;?>px;
<? } else {?>
font-size:12px;
<? }?>

}

#projectmodbottom {
<? if ($ModBottomImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModBottomImage;?>);
background-repeat:repeat-x;
<? }?>
<? if ($ModBottomBGColor != '') {?>
background-color:#<? echo $ModBottomBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;

}

#projectmodbottomleft{
<? if ($ModBottomLeftImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModBottomLeftImage;?>);
background-repeat:none;
<? }?>
<? if ($ModBottomLeftBGColor != '') {?>
background-color:#<? echo $ModBottomLeftBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#projectmodtopleft{
<? if ($ModTopLeftImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModTopLeftImage;?>);
background-repeat:none;
<? }?>
<? if ($ModTopLeftBGColor != '') {?>
background-color:#<? echo $ModTopLeftBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px; 
} 

#projectmodtopright{
<? if ($ModTopRightImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModTopRightImage;?>);
background-repeat:none;
<? }?>
<? if ($ModTopRightBGColor != '') {?>
background-color:#<? echo $ModTopRightBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#projectmodbottomright{
<? if ($ModBottomRightImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModBottomRightImage;?>);
background-repeat:none;
<? }?>
<? if ($ModBottomRightBGColor != '') {?>
background-color:#<? echo $ModBottomRightBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}



#bubblerightside { 
<? if ($ModRightSideImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModRightSideImage;?>);
background-repeat:repeat-y;
<? }?>
<? if ($ModRightSideBGColor != '') {?>
background-color:#<? echo $ModRightSideBGColor;?>;
<? } ?>
width: <? echo $CornerWidth;?>px;

}

#bubbleleftside {
<? if ($ModLeftSideImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModLeftSideImage;?>);
background-repeat:repeat-y;
<? }?>
<? if ($ModLeftSideBGColor != '') {?>
background-color:#<? echo $ModLeftSideBGColor;?>;
<? } ?>
width: <? echo $CornerWidth;?>px;
}

#bubbletop {
<? if ($ModTopImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModTopImage;?>);
background-repeat:repeat-x;
<? }?>
<? if ($ModTopBGColor != '') {?>
background-color:#<? echo $ModTopBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
}

#bubble_tooltip_content {
<? if ($ContentBoxImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ContentBoxImage;?>);
background-repeat:<? echo $ContentBoxImageRepeat;?>;
<? }?>
<? if ($ContentBoxBGColor != '') {?>
background-color:#<? echo $ContentBoxBGColor;?>;
<? } else { ?>
background-color:#ffffff;
<? }?>
<? if ($ContentBoxTextColor != '') {?>
color:#<? echo $ContentBoxTextColor;?>;
<? } else {?>
color:#000000;
<? }?>
<? if ($ContentBoxFontSize != '') {?>
font-size:<? echo $ContentBoxFontSize;?>px;
<? } else {?>
font-size:12px;
<? }?>
}

#bubblebottom {
<? if ($ModBottomImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModBottomImage;?>);
background-repeat:repeat-x;
<? }?>
<? if ($ModBottomBGColor != '') {?>
background-color:#<? echo $ModBottomBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;

}

#bubblebottomleft{
<? if ($ModBottomLeftImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModBottomLeftImage;?>);
background-repeat:none;
<? }?>
<? if ($ModBottomLeftBGColor != '') {?>
background-color:#<? echo $ModBottomLeftBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#bubbletopleft{
<? if ($ModTopLeftImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModTopLeftImage;?>);
background-repeat:none;
<? }?>
<? if ($ModTopLeftBGColor != '') {?>
background-color:#<? echo $ModTopLeftBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#bubbletopright{
<? if ($ModTopRightImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModTopRightImage;?>);
background-repeat:none;
<? }?>
<? if ($ModTopRightBGColor != '') {?>
background-color:#<? echo $ModTopRightBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}

#bubblebottomright{
<? if ($ModBottomRightImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ModBottomRightImage;?>);
background-repeat:none;
<? }?>
<? if ($ModBottomRightBGColor != '') {?>
background-color:#<? echo $ModBottomRightBGColor;?>;
<? } ?>
height:<? echo $CornerHeight;?>px;
width:<? echo $CornerWidth;?>px;
}


#ControlBar{

<? if ($ControlBarImage != '') {?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $ControlBarImage;?>);
background-repeat:<? echo $ControlBarImageRepeat;?>;
height:<? echo $ControlHeight;?>px;
<? }?>
background-color:#<? echo $ControlBarBGColor;?>;
<? if ($ControlBarFontSize != '') {?>
font-size:<? echo $ControlBarFontSize;?>px;
<? }?>
<? if ($ControlBarFontStyle != '') {
if ($ControlBarFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($ControlBarFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($ControlBarFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';
echo $StyleTag;	
	?>
<? }?>
}


#AuthorComment{

<? if (($AuthorCommentTextColor == 'global') || ($AuthorCommentTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $AuthorCommentTextColor;
?>
color:#<? echo $TextColor;?>;

text-transform:<? echo $GlobalHeaderTextTransformation;?>;
<? if (($AuthorCommentImage != '') || ($GlobalHeaderImage != '')) {
		 if ($AuthorCommentImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat; 
		} else {
			$CSSImage =$AuthorCommentImage;
			$CSSRepeat = $AuthorCommentImageRepeat;
		} 
		list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
		
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($AuthorCommentBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($AuthorCommentBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$AuthorCommentBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($AuthorCommentFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($AuthorCommentFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$AuthorCommentFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? 


if (($AuthorCommentFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($AuthorCommentFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$AuthorCommentFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	

?>
<? echo $StyleTag;?>
<? }?>

}

#LinksBox {
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
		
padding:2px;
<? if ($GlobalHeaderImage != '') {
		list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$GlobalHeaderImage);
	if ($GlobalHeaderImageRepeat == 'none') 
			$GlobalHeaderImageRepeat = 'no-repeat';
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $GlobalHeaderImage;?>);
background-repeat:<? echo $GlobalHeaderImageRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $GlobalHeaderBGColor;?>; 
font-size:<? echo $GlobalHeaderFontSize;?>px;
color:#<? echo $GlobalHeaderTextColor;?>;
<? 
$GlobalHeaderFontStyle;
	if ($GlobalHeaderFontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
	if ($GlobalHeaderFontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
	if ($GlobalHeaderFontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
}

.modheader{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
		
padding:2px;
<? if ($GlobalHeaderImage != '') {
		list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$GlobalHeaderImage);
			if ($GlobalHeaderImageRepeat == 'none') 
			$GlobalHeaderImageRepeat = 'no-repeat';
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $GlobalHeaderImage;?>);
background-repeat:<? echo $GlobalHeaderImageRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $GlobalHeaderBGColor;?>; 
font-size:<? echo $GlobalHeaderFontSize;?>px;
text-align:left;
color:#<? echo $GlobalHeaderTextColor;?>;
<? 
	if ($GlobalHeaderFontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
	if ($GlobalHeaderFontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
	if ($GlobalHeaderFontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
}

#ComicSynopsis{
padding:3px;
<? if (($ComicSynopsisTextColor == 'global') || ($ComicSynopsisTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $ComicSynopsisTextColor;
?>
color:#<? echo $TextColor;?>;
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
<? if (($ComicSynopsisImage != '') || ($GlobalHeaderImage != '')) {
		 if ($ComicSynopsisImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$ComicSynopsisCommentImage;
			$CSSRepeat = $ComicSynopsisImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($ComicSynopsisBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($ComicSynopsisBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$ComicSynopsisBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($ComicSynopsisFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($ComicSynopsisFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$ComicSynopsisFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($ComicSynopsisFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($ComicSynopsisFontStyle == '') {
		 	$FontStyle = $GlobalHeaderFontStyle;
		} else {
			$FontStyle =$ComicSynopsisFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}

#ComicInfo{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($ComicInfoTextColor == 'global')  || ($ComicInfoTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $ComicInfoTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($ComicInfoImage != '') || ($GlobalHeaderImage != '')) {
		 if ($ComicInfoImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$ComicInfoImage;
			$CSSRepeat = $ComicInfoImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($ComicInfoBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($ComicInfoBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$ComicInfoBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($ComicInfoFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($ComicInfoFontSize == '') { 
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$ComicInfoFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($ComicInfoFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($ComicInfoFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$ComicInfoFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}		

#UserComments{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($UserCommentsTextColor == 'global')  || ($UserCommentsTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $UserCommentsTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($UserCommentsImage != '') || ($GlobalHeaderImage != '')) {
		 if ($UserCommentsImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$UserCommentsImage;
			$CSSRepeat = $UserCommentsImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($UserCommentsBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($UserCommentsBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$UserCommentsBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($UserCommentsFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($UserCommentsFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$UserCommentsFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($UserCommentsFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($UserCommentsFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$UserCommentsFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}			
	
#ComicSynopsis{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($ComicSynopsisTextColor == 'global') || ($ComicSynopsisTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $ComicSynopsisTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($ComicSynopsisImage != '') || ($GlobalHeaderImage != '')) {
		 if ($ComicSynopsisImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$ComicSynopsisImage;
			$CSSRepeat = $ComicSynopsisImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($ComicSynopsisBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($ComicSynopsisBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$ComicSynopsisBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($ComicSynopsisFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($ComicSynopsisFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$ComicSynopsisFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($ComicSynopsisFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($ComicSynopsisFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$ComicSynopsisFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}	

#Products{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($ProductsTextColor == 'global') || ($ProductsTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $ProductsTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($ProductsImage != '') || ($GlobalHeaderImage != '')) {
		 if ($ProductsImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$ProductsImage;
			$CSSRepeat = $ProductsImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($ProductsBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($ProductsBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$ProductsBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($ProductsFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($ProductsFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$ProductsFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($ProductsFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($ProductsFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$ProductsFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}	
	
#MobileContent{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($MobileContentTextColor == 'global') || ($MobileContentTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $MobileContentTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($MobileContentImage != '') || ($GlobalHeaderImage != '')) {
		 if ($MobileContentImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$MobileContentImage;
			$CSSRepeat = $MobileContentImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($MobileContentBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($MobileContentBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$MobileContentBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($MobileContentFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($MobileContentFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$MobileContentFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($MobileContentFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($MobileContentFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$MobileContentFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}	


	
#MobileContent{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
<? if (($MobileContentTextColor == 'global') || ($MobileContentTextColor == ''))
	$TextColor = $GlobalHeaderTextColor;
  else 
  	$TextColor = $MobileContentTextColor;
?>
color:#<? echo $TextColor;?>;
<? if (($MobileContentImage != '') || ($GlobalHeaderImage != '')) {
		 if ($MobileContentImage == '') {
		 	$CSSImage =$GlobalHeaderImage;
			$CSSRepeat = $GlobalHeaderImageRepeat;
		} else {
			$CSSImage =$MobileContentImage;
			$CSSRepeat = $MobileContentImageRepeat;
		} 
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
<? if (($MobileContentBGColor != '') || ($GlobalHeaderBGColor != '')) {
		 if ($MobileContentBGColor == '') {
		 	$BgColor =$GlobalHeaderBGColor;

		} else {
			$BgColor =$MobileContentBGColor;
		} 
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if (($MobileContentFontSize != '') || ($GlobalHeaderFontSize != '')) {
		 if ($MobileContentFontSize == '') {
		 	$FontSize =$GlobalHeaderFontSize;

		} else {
			$FontSize =$MobileContentFontSize;
		} 
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if (($MobileContentFontStyle != '') || ($GlobalHeaderFontStyle != '')) {
		 if ($MobileContentFontStyle == '') {
		 	$FontStyle =$GlobalHeaderFontStyle;
		} else {
			$FontStyle =$MobileContentFontStyle;
		} 
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}	
.latestpageheader  {
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
color:#<? echo $GlobalHeaderTextColor;?>;
<? if ($GlobalHeaderImage != '') {
$CSSImage =$GlobalHeaderImage;
$CSSRepeat = $GlobalHeaderImageRepeat;
list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $ControlBarBGColor;?>;
font-size:<? echo $GlobalHeaderFontSize;?>px;
<?
	$FontStyle =$GlobalHeaderFontStyle;
	 if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>

}
.latestpageheader a:link{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
color:#<? echo $GlobalHeaderTextColor;?>;
<? if ($GlobalHeaderImage != '') {
$CSSImage =$GlobalHeaderImage;
$CSSRepeat = $GlobalHeaderImageRepeat;
list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>

background-color:#<? echo $GlobalHeaderBGColor;?>;
font-size:<? echo $GlobalHeaderFontSize;?>px;
<?
	$FontStyle =$GlobalHeaderFontStyle;
	 if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>

}
.latestpageheader a:visited{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
color:#<? echo $GlobalHeaderTextColor;?>;
<? if ($GlobalHeaderImage != '') {
$CSSImage =$GlobalHeaderImage;
$CSSRepeat = $GlobalHeaderImageRepeat;
list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $GlobalHeaderBGColor;?>;
font-size:<? echo $GlobalHeaderFontSize;?>px;
<?
	$FontStyle =$GlobalHeaderFontStyle;
	 if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>

}

.blogtitle {
font-size:14px;
font-weight:bold;


}

.blogdate {
font-size:12px;
}
.globalheader{
text-transform:<? echo $GlobalHeaderTextTransformation;?>;
padding:3px;
text-align:left;
color:#<? echo $GlobalHeaderTextColor;?>;
<? if ($GlobalHeaderImage != '') {
$CSSImage =$GlobalHeaderImage;
$CSSRepeat = $GlobalHeaderImageRepeat;
list($HeaderWidth,$HeaderHeight)=@getimagesize($PFDIRECTORY.'/templates/skins/'.$SkinCode.'/images/'.$CSSImage);
?>
background-image:url(/templates/skins/<? echo $SkinCode;?>/images/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>
background-color:#<? echo $GlobalHeaderBGColor;?>;
font-size:<? echo $GlobalHeaderFontSize;?>px;
<?
	$FontStyle =$GlobalHeaderFontStyle;
	 if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
}	
 
.global_button{
padding:3px;
<? if ($ButtonImage != '') {
		 	$CSSImage =$ButtonImage;
			$CSSRepeat = $ButtonImageRepeat;
		if ($CSSRepeat == 'none') 
			$CSSRepeat = 'no-repeat';
		list($HeaderWidth,$HeaderHeight)=@getimagesize($_SERVER['DOCUMENT_ROOT'].'/'.$CSSImage);
?>
background-image:url(/<? echo $CSSImage;?>);
background-repeat:<? echo $CSSRepeat;?>;
height:<? echo $HeaderHeight;?>px;
<? }?>

<? if ($ButtonBGColor != '') {
			$BgColor =$ButtonBGColor;
		
?>
background-color:#<? echo $BgColor;?>;
<? }?>
<? if ($ButtonTextColor != '') {
			$TextColor =$ButtonTextColor;
		
?>
color:#<? echo $ButtonTextColor;?>;
<? }?>
<? if ($ButtonFontSize != '') {
			$FontSize =$ButtonFontSize;
		
?>
font-size:<? echo $FontSize;?>px;
<? }?>
<? if ($ButtonFontStyle != '') {
		$FontStyle =$ButtonFontStyle;
		if ($FontStyle == 'bold') 
			$StyleTag = 'font-weight:bold;';
		if ($FontStyle == 'regular') 
			$StyleTag = 'font-style:normal;';
		if ($FontStyle == 'underline') 
			$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
<? }?>

}		

#FirstButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($FirstButtonBGColor != '') { ?>
background-color:#<? echo $FirstButtonBGColor;?>;
<? }?>
<? if ($FirstButtonTextColor != '') { ?>
color:#<? echo $FirstButtonTextColor;?>;
<? }?>
}

#NextButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($NextButtonBGColor != '') { ?>
background-color:#<? echo $NextButtonBGColor;?>;
<? }?>
<? if ($NextButtonTextColor != '') { ?>
color:#<? echo $NextButtonTextColor;?>;
<? }?>
}

#BackButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($BackButtonBGColor != '') { ?>
background-color:#<? echo $BackButtonBGColor;?>;
<? }?>
<? if ($BackButtonTextColor != '') { ?>
color:#<? echo $BackButtonTextColor;?>;
<? }?>
}
#LastButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($LastButtonBGColor != '') { ?>
background-color:#<? echo $LastButtonBGColor;?>;
<? }?>
<? if ($LastButtonTextColor != '') { ?>
color:#<? echo $LastButtonTextColor;?>;
<? }?>
}	
<? /*
#HomeButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($HomeButtonBGColor != '') { ?>
background-color:#<? echo $HomeButtonBGColor;?>;
<? }?>
<? if ($HomeButtonTextColor != '') { ?>
color:#<? echo $HomeButtonTextColor;?>;
<? }?>
}	
#CreatorButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($CreatorButtonBGColor != '') { ?>
background-color:#<? echo $CreatorButtonBGColor;?>;
<? }?>
<? if ($CreatorButtonTextColor != '') { ?>
color:#<? echo $CreatorButtonTextColor;?>;
<? }?>
}		
#CharactersButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($CharactersButtonBGColor != '') { ?>
background-color:#<? echo $CharactersButtonBGColor;?>;
<? }?>
<? if ($CharactersButtonTextColor != '') { ?>
color:#<? echo $CharactersButtonTextColor;?>;
<? }?>
}	

#DownloadsButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($DownloadsButtonBGColor != '') { ?>
background-color:#<? echo $DownloadsButtonBGColor;?>;
<? }?>
<? if ($DownloadsButtonTextColor != '') { ?>
color:#<? echo $DownloadsButtonTextColor;?>;
<? }?>
}		
#ExtrasButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($ExtrasButtonBGColor != '') { ?>
background-color:#<? echo $ExtrasButtonBGColor;?>;
<? }?>
<? if ($ExtrasButtonTextColor != '') { ?>
color:#<? echo $ExtrasButtonTextColor;?>;
<? }?>
}

#EpisodesButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($EpisodesButtonBGColor == '') { 
		$BGColor = $GlobalButtonBGColor;
		
	} else {
		$BGColor = $EpisodesButtonBGColor;
	}
?>
background-color:#<? echo $BGColor;?>;

<? if ($EpisodesButtonTextColor == '') {
		$Color = $GlobalButtonTextColor;
	} else {
		$Color = $EpisodesButtonTextColor;
	}

 ?>
color:#<? echo $Color;?>;

}
#MobileButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($MobileButtonBGColor != '') { ?>
background-color:#<? echo $MobileButtonBGColor;?>;
<? }?>
<? if ($MobileButtonTextColor != '') { ?>
color:#<? echo $MobileButtonTextColor;?>;
<? }?>
}		
#ProductsButton{
<? if ($HomeButtonImage == '') {?>padding:5px;<? }?>
<? if ($ProductsButtonBGColor != '') { ?>
background-color:#<? echo $ProductsButtonBGColor;?>;
<? }?>
<? if ($ProductsButtonTextColor != '') { ?>
color:#<? echo $ProductsButtonTextColor;?>;
<? }?>
}	
		
#CommentButton{

<? if ($CommentButtonBGColor != '') { ?>
background-color:#<? echo $CommentButtonBGColor;?>;
<? }?>
<? if ($CommentButtonBGColor != '') { ?>
color:#<? echo $CommentButtonTextColor;?>;
<? }?>
}	
#VoteButton{

<? if ($VoteButtonBGColor != '') { ?>
background-color:#<? echo $VoteButtonBGColor;?>;
<? }?>
<? if ($VoteButtonTextColor != '') { ?>
color:#<? echo $VoteButtonTextColor;?>;
<? }?>
}			

#LogoutButton{

<? if ($LogoutButtonBGColor != '') { ?>
background-color:#<? echo $LogoutButtonBGColor;?>;
<? }?>
<? if ($LogoutButtonTextColor != '') { ?>
color:#<? echo $LogoutButtonTextColor;?>;
<? }?>
}

*/?>			
.pagelinks {
<? 
if ($GlobalSiteLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalSiteLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalSiteLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalSiteLinkTextColor;?>;
}
.pagelinks a{
<? 
if ($GlobalSiteLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalSiteLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalSiteLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalSiteLinkTextColor;?>;
}
.pagelinks a:link{
	<? 
if ($GlobalSiteLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalSiteLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalSiteLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalSiteLinkTextColor;?>;
}
.pagelinks a:visited { 
<? 
if ($GlobalSiteVisitedFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalSiteVisitedFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;'; 
if ($GlobalSiteVisitedFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
color:#<?php echo $GlobalSiteVisitedTextColor;?>;
}
.pagelinks a:hover{
	<? 
if ($GlobalSiteHoverFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalSiteHoverFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalSiteHoverFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalSiteHoverTextColor;?>;
}

.buttonlinks {
<? 
if ($GlobalButtonLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalButtonLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalButtonLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalButtonLinkTextColor;?>;
}
.global_button a{
<? 
if ($GlobalButtonLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalButtonLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalButtonLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $ButtonTextColor;?>;
}
.global_button a:link{
	<? 
if ($GlobalButtonLinkFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalButtonLinkFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalButtonLinkFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $ButtonTextColor;?>;
}
.global_button a:visited{ 
<? 
if ($GlobalButtonVisitedFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalButtonVisitedFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;'; 
if ($GlobalButtonVisitedFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
color:#<?php echo $GlobalButtonVisitedTextColor;?>;
}
.global_button a:hover{
	<? 
if ($GlobalButtonHoverFontStyle == 'bold') 
	$StyleTag = 'font-weight:bold;';
if ($GlobalButtonHoverFontStyle == 'regular') 
	$StyleTag = 'font-style:normal;';
if ($GlobalButtonHoverFontStyle == 'underline') 
	$StyleTag = 'text-decoration:underline;';	
?>
<? echo $StyleTag;?>
	color:#<?php echo $GlobalButtonHoverTextColor;?>;
}
</style>