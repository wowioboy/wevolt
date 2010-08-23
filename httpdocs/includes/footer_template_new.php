<script>
function reloadPage()
{
	window.location = '';
}

$(document).ready(function() {
	$('*[tooltip]').each(function() {
		var position = $(this).attr('tooltip_position');
		switch (position) {
			case 'right':
				tip = 'leftMiddle';
				target = 'rightMiddle';
				break;
			case 'left':
				tip = 'rightMiddle';
				target = 'leftMiddle';
				break;
			case 'top':
				tip = 'bottomMiddle';
				target = 'topMiddle';
				break;
			case 'bottom':
				tip = 'topMiddle';
				target = 'bottomMiddle';
				break;
			case 'topleft':
				tip = 'bottomRight';
				target = 'topLeft';
				break;
			case 'bottomleft':
				tip = 'topRight';
				target = 'bottomLeft';
				break;
			case 'bottomright':
				tip = 'topLeft';
				target = 'bottomRight';
				break;
			case 'topright':
			default:
				tip = 'bottomLeft';
				target = 'topRight';
		}
		$(this).qtip({
			content: $(this).attr('tooltip'),
			style: {
				name: 'blue',
				tip: tip,
				border: {
			width: 1,
	         radius: 2,
	         color: '#3a3a3a'
				}
			},
			position: {
		       corner: {
			   	   target: target,
			   	   tooltip: tip,
			   	   adjust: {
					  screen: true
			   	   }
	  	 	   }
			} 
		});
	});
});
</script>
<style>
.slide {
	display:inline-block;
	width:10px;
	height:10px;
	margin:2px;
	background-color:#fff;
	-webkit-border-radius:10px;
	-moz-border-radius: 10px;
	border-radius: 10px;
	border:solid 1px #999;
}
.activeSlide {
	background-color:#a5cbff;
}
.panel_top {
padding-left:5px;
padding-right:5px;
border-bottom: solid 1px #000;
height:20px;
background-color:#ccf;
background:
-webkit-gradient(
    linear,
    left bottom,
    left top,
    color-stop(0.1, rgb(182,215,244)),
    color-stop(0.9, rgb(247,247,247))
);
background:
-moz-linear-gradient(
    center bottom,
    rgb(182,215,244) 10%,
    rgb(247,247,247) 90%
);
filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFF, endColorstr=#b6d7f4);
-ms-filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#FFFFFF, endColorstr=#b6d7f4, GradientType=1);
-webkit-border-top-left-radius: 10px;
-webkit-border-top-right-radius: 10px;
-moz-border-radius-topleft: 10px;
-moz-border-radius-topright: 10px;
border-top-left-radius: 10px;
border-top-right-radius: 10px;
}
.panel_body {
background-color:#fff;
padding:4px;
-webkit-border-bottom-right-radius: 10px;
-webkit-border-bottom-left-radius: 10px;
-moz-border-radius-bottomright: 10px;
-moz-border-radius-bottomleft: 10px;
border-bottom-right-radius: 10px;
border-bottom-left-radius: 10px;
}
</style>
<!-- YUI LIBRARY --> 
<script type="text/javascript" src="http://yui.yahooapis.com/combo?2.8.0r4/build/yahoo-dom-event/yahoo-dom-event.js&2.8.0r4/build/event-mouseenter/event-mouseenter-min.js&2.8.0r4/build/container/container-min.js&2.8.0r4/build/animation/animation-min.js&2.8.0r4/build/menu/menu-min.js&2.8.0r4/build/element/element-min.js&2.8.0r4/build/carousel/carousel-min.js"></script>

<!-- STRING FUNCTIONS -->
<script type="text/javascript" src="http://www.wevolt.com/scripts/string_functions.js"></script>
<script type="text/javascript" src="http://www.wevolt.com/js/piroBox.1_2.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$().piroBox({
			my_speed: 600, //animation speed
			bg_alpha: 0.5, //background opacity
			radius: 4, //caption rounded corner
			scrollImage : false, // true == image follows the page, false == image remains in the same open position
			pirobox_next : 'piro_next', // Nav buttons -> piro_next == inside piroBox , piro_next_out == outside piroBox
			pirobox_prev : 'piro_prev',// Nav buttons -> piro_prev == inside piroBox , piro_prev_out == outside piroBox
			close_all : '.piro_close',// add class .piro_overlay(with comma)if you want overlay click close piroBox
			slideShow : '', // just delete slideshow between '' if you don't want it.
			slideSpeed : 4 //slideshow duration in seconds(3 to 6 Recommended)
	});
});
</script>

<? if (isset($_SESSION['userid'])) {

			if ($_GET['t'] == 'network') {?>
				<script  language="javascript" src="http://yui.yahooapis.com/2.8.0r4/build/dragdrop/dragdrop-min.js"></script>
					<? if ($MyVolt == 1){?>
					<script type="text/javascript">
						(function() {
				
						var Dom = YAHOO.util.Dom;
						var Event = YAHOO.util.Event;
						var DDM = YAHOO.util.DragDropMgr;
					  
					//////////////////////////////////////////////////////////////////////////////
					// example app
					//////////////////////////////////////////////////////////////////////////////
					YAHOO.example.DDApp = {
						init: function() {
					
					
							 new YAHOO.util.DDTarget("friends");
							 new YAHOO.util.DDTarget("w3vers");
							 new YAHOO.util.DDTarget("fans");
							 new YAHOO.util.DDTarget("celebs");
							<? echo $DropStringInit;?>
						  
					
							Event.on("showButton", "click", this.showOrder);
							Event.on("switchButton", "click", this.switchStyles);
						},
					
						showOrder: function() {
							var parseList = function(ul, title) {
								var items = ul.getElementsByTagName("li");
								var out = title + ": ";
								for (i=0;i<items.length;i=i+1) {
									out += items[i].id + " ";
								}
								return out;
							};
					
							var ul1=Dom.get("ul1"), ul2=Dom.get("ul2");
							alert(parseList(ul1, "List 1") + "\n" + parseList(ul2, "List 2"));
					
						},
					
						switchStyles: function() {
							Dom.get("ul1").className = "draglist_alt";
							Dom.get("ul2").className = "draglist_alt";
						}
					};
					
					//////////////////////////////////////////////////////////////////////////////
					// custom drag and drop implementation
					//////////////////////////////////////////////////////////////////////////////
					
						YAHOO.example.DDList = function(id, sGroup, config) {
						
							YAHOO.example.DDList.superclass.constructor.call(this, id, sGroup, config);
						
							this.logger = this.logger || YAHOO;
							var el = this.getDragEl();
							Dom.setStyle(el, "opacity", 0.67); // The proxy is slightly transparent
							
							this.goingUp = false;
							this.lastY = 0;
						};
						
						YAHOO.extend(YAHOO.example.DDList, YAHOO.util.DDProxy, {
						
							startDrag: function(x, y) {
								this.logger.log(this.id + " startDrag");
								
								// make the proxy look like the source element
								var dragEl = this.getDragEl();
								var clickEl = this.getEl();
								Dom.setStyle(clickEl, "visibility", "hidden");
								//this.oldElement = document.getElementById("friends_container").innerHTML;
								dragEl.innerHTML = clickEl.innerHTML;
								this.SelectedElement = clickEl.id;
								Dom.setStyle(dragEl, "color", Dom.getStyle(clickEl, "color"));
								Dom.setStyle(dragEl, "backgroundColor", Dom.getStyle(clickEl, "backgroundColor"));
								Dom.setStyle(dragEl, "border", "2px solid gray");
								OriginalArray = this.SelectedElement.split('_');
								this.OriginalDiv = OriginalArray[0];
								this.SelectedID = OriginalArray[1];
								//alert('hello ' +  this.OriginalDiv);
								//alert('starting');
							},
						
							endDrag: function(e) {
						
								var srcEl = this.getEl();
								var proxy = this.getDragEl();
						
						
								// Show the proxy element and animate it to the src element's location
								Dom.setStyle(proxy, "visibility", "");
								var a = new YAHOO.util.Motion( 
									proxy, { 
										points: { 
											to: Dom.getXY(srcEl)
										}
									}, 
									0.2, 
									YAHOO.util.Easing.easeOut 
								)
								
								var proxyid = proxy.id;
								var thisid = this.id;
						
								// Hide the proxy and show the source element when finished with the animation
								a.onComplete.subscribe(function() {
										Dom.setStyle(proxyid, "visibility", "hidden");
										Dom.setStyle(thisid, "visibility", "");
									});
								a.animate();
							
							},
						
							onDragDrop: function(e, id) {
								NewArray = id.split('_');
								this.CurrentDiv = NewArray[0];
								
								// We are only concerned with list items, we ignore the dragover
								// notifications for the list.
								this.Auth = 1;
								//alert('CurrentDiv DIV ' + this.CurrentDiv);
								//alert('ORIGINAL DIV ' + this.OriginalDiv);
								if ((this.OriginalDiv == 'friends') && (this.CurrentDiv == 'celebs')) {
									this.Auth = 0;
									//alert('friends Not allowed to be celebs' );
								}
								if ((this.OriginalDiv == 'fans') && (this.CurrentDiv == 'celebs')) {
									this.Auth = 0;
									//alert('Fans Are Not allowed to be celebs' );
								}
								if ((this.OriginalDiv == 'celebs') && (this.CurrentDiv == 'fans')) {
									this.Auth = 0;
									//alert('celebs Not allowed to be fans' );
								}
								if ((this.OriginalDiv == 'fans') && (this.CurrentDiv == 'w3vers')) {
									this.Auth = 0;
									//alert('fans Not allowed to be w3vers' );
								}
								if ((this.OriginalDiv == 'w3vers') && (this.CurrentDiv == 'fans')) {
									this.Auth = 0;
									//alert('w3vers Not allowed to be fans' );
								}
						
								//alert(DDM.interactionInfo.drop.length);
								//alert('Original Div = ' + this.OriginalDiv);
								//alert('Target Div = ' + this.CurrentDiv);
								
									
								// If there is one drop interaction, the li was dropped either on the list,
								// or it was dropped on the current location of the source element.
								if (DDM.interactionInfo.drop.length === 1) {
						
									// The position of the cursor at the time of the drop (YAHOO.util.Point)
									var pt = DDM.interactionInfo.point; 
						
									// The region occupied by the source element at the time of the drop
									var region = DDM.interactionInfo.sourceRegion; 
									//alert(id);
									// Check to see if we are over the source element's location.  We will
									// append to the bottom of the list once we are sure it was a drop in
									// the negative space (the area of the list without any list items)
								   if (this.Auth == 1) {
									if (!region.intersect(pt)) {
										var destEl = Dom.get(id);
										var destDD = DDM.getDDById(id);
										//alert(destDD);
										destEl.appendChild(this.getEl());
										destDD.isEmpty = false;
										DDM.refreshCache();
									}
									attach_file( '/processing/manage_friends.php?orig='+this.OriginalDiv+'&new='+this.CurrentDiv+'&userid=<? echo $_SESSION['userid'];?>&targetid='+this.SelectedID);
									
									} 
						
								}
								
							},
						
							onDrag: function(e) {
						
								// Keep track of the direction of the drag for use during onDragOver
								var y = Event.getPageY(e);
						
								if (y < this.lastY) {
									this.goingUp = true;
								} else if (y > this.lastY) {
									this.goingUp = false;
								}
						
								this.lastY = y;
							},
							
							
						
							onDragOver: function(e, id) {
							
								var srcEl = this.getEl();
								var destEl = Dom.get(id);
						
								 NewArray = id.split('_');
								this.CurrentDiv = NewArray[0];
						
								this.Auth = 1;
						
								
								if ((destEl.nodeName.toLowerCase() == "li") &&  (this.Auth == 1)) {
									var orig_p = srcEl.parentNode;
									var p = destEl.parentNode;
						
									if (this.goingUp) {
										p.insertBefore(srcEl, destEl); // insert above
									} else {
										p.insertBefore(srcEl, destEl.nextSibling); // insert below
									}
									
						
									DDM.refreshCache();
								}
								
							}
						});
						
						Event.onDOMReady(YAHOO.example.DDApp.init, YAHOO.example.DDApp, true);
						
						})();
						</script>
						<? }?>
			<? }?>
	
	<script type="text/javascript">
	function string_init() 
	{
		var x = 898;
		var y = 28;
		
			// Build overlay1 based on markup, initially hidden, fixed to the center of the viewport, and 300px wide
			YAHOO.wevolt.container.string = new YAHOO.widget.Overlay("string", { xy:[x,y],
																					  visible:false,
																					  width:"109px" } );
			YAHOO.wevolt.container.string.render();
			YAHOO.util.Event.addListener("showstring", "click", YAHOO.wevolt.container.string.show, YAHOO.wevolt.container.string, true);
			YAHOO.util.Event.addListener("hidestring", "click", YAHOO.wevolt.container.string.hide, YAHOO.wevolt.container.string, true);
			YAHOO.util.Event.addListener("hidestringpanel", "mouseenter", YAHOO.wevolt.container.string.hide, YAHOO.wevolt.container.string, true);	
	}


	//STRING 
	YAHOO.namespace("wevolt.container");
    YAHOO.util.Event.addListener(window, "load", string_init);
	
<? 

	if ($AvailDrawers > 0) { ?>
    YAHOO.util.Event.onContentReady("drawers_full", function () {
				
	<? $IDCount = 1;
		while ($IDCount <= $AvailDrawers) {?>
           var Drawer<? echo $IDCount;?> = new YAHOO.widget.Menu("drawer_container<? echo $IDCount;?>", { 
                                                        position: "static", 
                                                        hidedelay:  750, 
                                                        lazyload: true });
               
                Drawer<? echo $IDCount;?>.render();            
            
				
				<? 
				$IDCount++;
				}?>
			
				});
	<? }?>
	
</script>	
<? }?>
<script>
$(document).ready(function(){	
	$("#slider").cycle({
		fx: 'fade',
		timeout: 7000,
		pauseOnPagerHover: true,
		speed: 800,
		pager: '#LateNav'
	});
	$("#spotlight_container").cycle({
		fx: 'fade',
		speed: 800,
		random:   true,
		<? if ($IsProject) {?>
		timeout:  0,
		<? } else {?>
		timeout: 5000,
		<? }?>
		pager: '#lowernavs'
	});
});

</script>
<? if (($_SESSION['readerstyle'] == 'flash') && (($Section == 'Pages') ||($Section == 'Reader'))) { ?>
<iframe src="" scrolling="no" frameborder="0" allowtransparency="true" name="pgviewer" id="pgviewer" style="display:none;"></iframe>
<? if ($Twittername != '') {?>
<script type="text/javascript" src="http://twitter.com/statuses/user_timeline/<? echo $Twittername;?>.json?callback=twitterCallback2&amp;count=5"></script>
<? }?>
<? }?>
<? if ($CMSAdmin == 1) {?>

<script language="JavaScript">
  function nextpage(){
    document.getElementById('page').value = <? echo ($page+1); ?>;
    document.form1.submit();
  }
  
  function previouspage(){
    document.getElementById('page').value = <? echo ($page-1); ?>;
    document.form1.submit();
  }
  
  function removeTemplateImage(skintype) {
		
		attach_file( '/<? echo $PFDIRECTORY;?>/includes/remove_template_image.php?skincode=<? echo $SkinCode;?>&type='+skintype+'&project=<? echo $ProjectID;?>&theme=<? echo $_GET['themeid'];?>');
		
		}
  
  function check_key(value) {
  //alert(value);
  	if (value == 0) {
		document.getElementById('admindiv').style.display = 'none';
		document.getElementById('messagediv').style.display = '';
		//alert('got here');
	}
  
  }
   
  function revealModal(divID,type)
	{
	
		if (divID == 'uploadModal') {
			var SkinID = document.getElementById('SkinCode').value;
			document.getElementById('uploaderframe').src='/<? echo $PFDIRECTORY;?>/includes/skin_upload_inc.php?type='+type+'&skincode='+SkinID+'&comic=<? echo $ComicID;?>';
		} else if (divID == 'scriptModal') {
			document.getElementById('scriptframe').src='/<? echo $PFDIRECTORY;?>/script_write.php?pageid=<? echo $_GET['pageid'];?>&type=script';
		}
		window.onscroll = function () { document.getElementById(divID).style.top = document.body.scrollTop; };
		document.getElementById(divID).style.display = "block";
		document.getElementById(divID).style.top = document.body.scrollTop;
	}
	

	function rolloveractive(tabid, divid) { 
	var divstate = document.getElementById(divid).style.display;
	//alert('TABID = '+tabid+' and DIVID='+divid);
	//if (divstate == 'none') {
		//alert(divid+ 'state = hidden'); 
	//} else {
		//alert(divid+ 'state = active');
	//}
			if (document.getElementById(divid).style.display != '') {
			//alert('TABID = '+tabid+' and DIVID='+divid);
				document.getElementById(tabid).className ='profiletabhover';
			} 
	}
  
 <? if ($Section == 'modules') { ?>
 	sections = ['left','right'];
	function createLineItemSortables() {
		for(var i = 0; i < sections.length; i++) {
			Sortable.create(sections[i],{tag:'div',dropOnEmpty: true, containment: sections,only:'lineitem'});
		}
	}
	function destroyLineItemSortables() {
		for(var i = 0; i < sections.length; i++) {
			Sortable.destroy(sections[i]);
		}
	}
	function createGroupSortable() {
		Sortable.create('page',{tag:'div',only:'section',handle:'handle'});
	}
	/*
	Debug Functions for checking the group and item order
	*/
	function getGroupOrder() {
		var sections = document.getElementsByClassName('section');
		var alerttext = '';
		sections.each(function(section) {
			var sectionID = section.id;
			var order = Sortable.serialize(sectionID);
			if (sectionID == 'left') {
				document.getElementById("LeftColumnOrder").value = Sortable.sequence(section);
			}
			if (sectionID == 'right') {
				document.getElementById("RightColumnOrder").value = Sortable.sequence(section);
			}
		});
		document.SaveModules.submit();
		return false;
	}

 
 <? }?>

 
 <? if ($_GET['section'] =='products') {?>

function delete_product(value) {
var answer = confirm('Are you sure you want to delete this product, this cannot be undone');
	if (answer) {
 attach_file('/<? echo $PFDIRECTORY;?>/includes/delete_product.php?comic=<? echo $ComicID;?>&id='+value+'&user=<? echo $_SESSION['userid'];?>');
	}
}
 
 <? }?>
</script>

<script type="text/javascript" src="/<? echo $PFDIRECTORY;?>/scripts/jscolor.js"></script>
 <? if (($_GET['section'] =='products') || ($_GET['section'] == 'blog')) {?>
<script type='text/javascript' src='/<? echo $PFDIRECTORY;?>/scripts/1-6-3-prototype.js'></script>
<script type='text/javascript' src='<? echo $PFDIRECTORY;?>/scripts/1-8-2scriptaculous.js'></script>

<? }?>

<LINK href="/<? echo $PFDIRECTORY;?>/css/modal.css" rel="stylesheet" type="text/css">
<link href="/<? echo $PFDIRECTORY;?>/css/cal.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/<? echo $PFDIRECTORY;?>/scripts/cal.js"></script> 





<? }
flush();
 ?>
<? include $_SERVER['DOCUMENT_ROOT'].'/includes/footer_ad_scripts.php';?>

<? $User->getString();?>
    
<? $Site->drawMenuExtras();?>
<? if ($ShowBeta) {?>
<script type="text/javascript">
//show_beta();
</script>

<? } ?> 

<? if (($IsProject) && ($_SESSION['readerstyle'] != 'flash')) {?>
<div id="page_preloader" style="display:none;">
<img src="http://www.wevolt.com/<? echo $ContentSection->getNextPageImage();?>" />
<img src="http://www.wevolt.com/<? echo $ContentSection->getPrevPageImage();?>" />
<script type="text/javascript">
window.location.hash = '<? echo str_replace("'", '',$ReaderPageTitle);?>';
</script>
</div>
<? }?>
<!-- Start Quantcast tag -->


<script type="text/javascript">

_qoptions={
qacct:"p-6fyMZKpQakqes"
};
</script>
<script type="text/javascript" src="http://edge.quantserve.com/quant.js"></script>
<noscript>
<img src="http://pixel.quantserve.com/pixel/p-6fyMZKpQakqes.gif" style="display: none;" border="0" height="1" width="1" alt="Quantcast"/>
</noscript>
<!-- End Quantcast tag -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-16793525-1']);
  _gaq.push(['_setDomainName', '.wevolt.com']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</body>
</html>