<?
add_string_entry($PageTitle, $TrackPage);
$InitDB->close();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="http://www.w3volt.com/scripts/swfobject.js"></script>
<script language="javascript">AC_FL_RunContent = 0;</script>
<script src="http://www.w3volt.com//scripts/AC_RunActiveContent.js" language="javascript"></script>
<script type="text/javascript">

if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)))
{
location.href='http://www.w3volt.com/iphone/index.php';
}
 
</script> 
<script type="text/javascript" src="http://www.w3volt.com/scripts/jquery-1.2.3.pack.js"></script>
<script type="text/javascript" src="http://www.w3volt.com/scripts/lib/jquery.jcarousel.pack.js"></script>
<link rel="stylesheet" type="text/css" href="http://www.w3volt.com/scripts/lib/jquery.jcarousel.css" />

<link rel="stylesheet" type="text/css" href="http://www.w3volt.com/scripts/skins/tango/skin.css" />
<meta name="description" content="<? echo $SiteDescription;?>"></meta>
<meta name="keywords" content="<? echo $Keywords;?>"></meta>
<LINK href="http://www.w3volt.com/css/pf_css_new.css" rel="stylesheet" type="text/css">
<LINK href="http://www.w3volt.com/css/yui_css.css" rel="stylesheet" type="text/css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><? echo $PageTitle;?></title>


<script type="text/javascript">
/**
 * We use the initCallback callback
 * to assign functionality to the controls
 */
function mycarousel_initCallback(carousel) {
    jQuery('.jcarousel-control a').bind('click', function() {
        carousel.scroll(jQuery.jcarousel.intval(jQuery(this).text()));
        return false;
    });

    jQuery('.jcarousel-scroll select').bind('change', function() {
        carousel.options.scroll = jQuery.jcarousel.intval(this.options[this.selectedIndex].value);
        return false;
    });

    jQuery('#mycarousel-next').bind('click', function() {
        carousel.next();
        return false;
    });

    jQuery('#mycarousel-prev').bind('click', function() {
        carousel.prev();
        return false;
    });
};

// Ride the carousel...
jQuery(document).ready(function() {
    jQuery("#mycarousel").jcarousel({
        scroll: 1,
		visible: 6,
		start:<? echo $StringStart;?>,

        initCallback: mycarousel_initCallback,
        // This tells jCarousel NOT to autobuild prev/next buttons
        buttonNextHTML: null,
        buttonPrevHTML: null
    });
});

function roll_over(img_name, img_src)
   {
	if (document[img_name] != null)
  		 document[img_name].src = img_src;
  	else
  		 img_name.src = img_src;
   }

function resize_iframe(iframe) {
            var myWidth = 0, myHeight = 0;
            if( typeof( window.innerWidth ) == 'number' ) {
                //Non-IE
                myWidth = window.innerWidth;
                myHeight = window.innerHeight;
            } else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {
                //IE 6+ in 'standards compliant mode'
                myWidth = document.documentElement.clientWidth;
                myHeight = document.documentElement.clientHeight;
            } else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {
                //IE 4 compatible
                myWidth = document.body.clientWidth;
                myHeight = document.body.clientHeight;
            }
            
			

	//alert(iframe.height);
			//	alert(iframe.id);
				//alert( document.frames("readerframe").document.body.scrollHeight);
				
         //  var iNewHeight;
          // iNewHeight = parseInt(myHeight)-40;
			//var Scrollheight =  document.getElementById("readerframe").scrollHeight;
			//alert(Scrollheight);
          //  document.getElementById("readerframe").style.height = iNewHeight+'px'; 
			  //document.frames('irf1').document.body.scrollHeight
			 // iframe.height = document.frames("readerframe").document.body.scrollHeight;
  //	alert(iframe.height);
  
			
			//alert(document.getElementById("WgipIFrame").style.height);  
       }

        //-- see if there is already something on the onresize
        var tempOnresize = window.onresize; 
        //-- create our event handler
        window.onresize = function(){ 
            //-- if tempFunc is a function, try to call it
            if (typeof (tempOnresize) == "function"){ 
                try{ 
                    tempOnresize(); 
                } catch(e){} //--- if it errors, don't let it crash our script
            } 
            resize_iframe();
        }
</script>


<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/yahoo-dom-event/yahoo-dom-event.js"></script>

<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/container/container-min.js"></script>
<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/combo?2.8.0r4/build/reset-fonts-grids/reset-fonts-grids.css">
<link rel="stylesheet" type="text/css" href="http://www.w3volt.com/css/w3volt_drawers_css.css">

<!-- Combo-handled YUI JS files: -->
<script type="text/javascript" src="http://yui.yahooapis.com/combo?2.8.0r4/build/yahoo-dom-event/yahoo-dom-event.js&2.8.0r4/build/animation/animation-min.js&2.8.0r4/build/container/container_core-min.js&2.8.0r4/build/menu/menu-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/dragdrop/dragdrop-min.js"></script>
<script type="text/javascript" src="http://www.w3volt.com/scripts/fancy_inputs.js"></script>
<link rel="stylesheet" type="text/css" href="http://www.w3volt.com/shadowbox/shadowbox.css">
<script type="text/javascript" src="http://www.w3volt.com/shadowbox/shadowbox.js"></script>


<script>

function attach_file( p_script_url ) {

      // create new script element, set its relative URL, and load it 
      script = document.createElement( 'script' );
      script.src = p_script_url; 
      document.getElementsByTagName( 'head' )[0].appendChild( script );
}




YAHOO.namespace("w3volt.container");

		function init() {
			// Build overlay1 based on markup, initially hidden, fixed to the center of the viewport, and 300px wide
			YAHOO.w3volt.container.string = new YAHOO.widget.Overlay("string", { xy:[300,90],
																					  visible:false,
																					  width:"750px" } );
			YAHOO.w3volt.container.string.render();
			
			YAHOO.util.Event.addListener("showstring", "click", YAHOO.w3volt.container.string.show, YAHOO.w3volt.container.string, true);
			YAHOO.util.Event.addListener("hidestring", "click", YAHOO.w3volt.container.string.hide, YAHOO.w3volt.container.string, true);
	
			<? /*
			YAHOO.w3volt.container.drawers_full = new YAHOO.widget.Overlay("drawers_full", { xy:[40,525],
																					  visible:false,
																					 } );
			YAHOO.w3volt.container.drawers_full.render();
			
			YAHOO.util.Event.addListener("showdrawer1", "click", YAHOO.w3volt.container.drawers_full.show, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("hidedrawer1", "click", YAHOO.w3volt.container.drawers_full.hide, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("showdrawer2", "click", YAHOO.w3volt.container.drawers_full.show, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("hidedrawer2", "click", YAHOO.w3volt.container.drawers_full.hide, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("showdrawer3", "click", YAHOO.w3volt.container.drawers_full.show, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("hidedrawer3", "click", YAHOO.w3volt.container.drawers_full.hide, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("showdrawer4", "click", YAHOO.w3volt.container.drawers_full.show, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("hidedrawer4", "click", YAHOO.w3volt.container.drawers_full.hide, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("showdrawer5", "click", YAHOO.w3volt.container.drawers_full.show, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("hidedrawer5", "click", YAHOO.w3volt.container.drawers_full.hide, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("showdrawer6", "click", YAHOO.w3volt.container.drawers_full.show, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("hidedrawer6", "click", YAHOO.w3volt.container.drawers_full.hide, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("showdrawer7", "click", YAHOO.w3volt.container.drawers_full.show, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("hidedrawer7", "click", YAHOO.w3volt.container.drawers_full.hide, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("showdrawer8", "click", YAHOO.w3volt.container.drawers_full.show, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("hidedrawer8", "click", YAHOO.w3volt.container.drawers_full.hide, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("showdrawer9", "click", YAHOO.w3volt.container.drawers_full.show, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("hidedrawer9", "click", YAHOO.w3volt.container.drawers_full.hide, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("showdrawer10", "click", YAHOO.w3volt.container.drawers_full.show, YAHOO.w3volt.container.drawers_full, true);
			YAHOO.util.Event.addListener("hidedrawer10", "click", YAHOO.w3volt.container.drawers_full.hide, YAHOO.w3volt.container.drawers_full, true);
							

			*/?>
			<? //echo $DrawerOverlayInitString;?>
			
			
		
		}

		YAHOO.util.Event.addListener(window, "load", init);
		
		function toggle_string_button(value) {
				if (value == 'on'){
					document.getElementById("string_button_on").style.display = 'none';
						document.getElementById("string_button_off").style.display = '';
				}else{
					document.getElementById("string_button_on").style.display = '';
						document.getElementById("string_button_off").style.display = 'none';
				}
		}
		
		<? if ($MyVolt == 1) {?>
		(function() {

		var Dom = YAHOO.util.Dom;
		var Event = YAHOO.util.Event;
		var DDM = YAHOO.util.DragDropMgr;
        

//////////////////////////////////////////////////////////////////////////////
// example app
//////////////////////////////////////////////////////////////////////////////
YAHOO.w3volt.DDApp = {
    init: function() {

<!--
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

YAHOO.w3volt.DDList = function(id, sGroup, config) {

    YAHOO.w3volt.DDList.superclass.constructor.call(this, id, sGroup, config);

    this.logger = this.logger || YAHOO;
    var el = this.getDragEl();
    Dom.setStyle(el, "opacity", 0.67); // The proxy is slightly transparent
    
    this.goingUp = false;
    this.lastY = 0;
};

YAHOO.extend(YAHOO.w3volt.DDList, YAHOO.util.DDProxy, {

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
		//alert('auth = '+ this.Auth);
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
			attach_file( 'http://www.w3volt.com/processing/manage_friends.php?orig='+this.OriginalDiv+'&new='+this.CurrentDiv+'&userid=<? echo $_SESSION['userid'];?>&targetid='+this.SelectedID);
			
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

        // We are only concerned with list items, we ignore the dragover
        // notifications for the list.
	     NewArray = id.split('_');
		this.CurrentDiv = NewArray[0];
        // We are only concerned with list items, we ignore the dragover
        // notifications for the list.
		this.Auth = 1;
		//alert('CurrentDiv DIV ' + this.CurrentDiv);
		//alert('ORIGINAL DIV ' + this.OriginalDiv);
		<? /*
		if (this.CurrentDiv == '')
			this.Auth = 0;
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
		*/ ?>
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

Event.onDOMReady(YAHOO.w3volt.DDApp.init, YAHOO.example.DDApp, true);

})();
		<? }?>
	</script>

  <script type="text/javascript">

            /*
                 Initialize and render the Menu when its elements are ready 
                 to be scripted.
            */

            YAHOO.util.Event.onContentReady("drawer_container1", function () {
                
				var Menu1 = new YAHOO.widget.Menu(
                                    "drawer_container1", 
                                    {
                                        position: "static", 
                                        hidedelay: 750,
										
                                        lazyload: true, 
                                        effect: { 
                                            effect: YAHOO.widget.ContainerEffect.FADE,
                                            duration: 0.25
                                        } 
                                    }
                                );
				var Menu2 = new YAHOO.widget.Menu(
                                    "drawer_container2", 
                                    {
                                        position: "static", 
                                        hidedelay: 750,
                                        lazyload: true, 
                                        effect: { 
                                            effect: YAHOO.widget.ContainerEffect.FADE,
                                            duration: 0.25
                                        } 
                                    }
                                );
								
                Menu1.render();  
				Menu2.render();           
            
            });
			
			function toggle_drawer(value,state) {
				var DrawerContainer = 'drawerdiv_'+value;
				var NumDrawerItems = document.getElementById('drawer_item_cnt_'+value).value;
				var ContainerHeight = 27 * NumDrawerItems;
				
				if ((ContainerHeight + 630) > theHeight) {
					var heightvar = (630 - (NumDrawerItems * 17));
					document.getElementById('drawers_full').style.top = heightvar+'px';
				
				} else {
					document.getElementById('drawers_full').style.top = '630px';
				}
				
				document.getElementById('drawers_full').style.left = '300px';
  			
				document.getElementById('drawers_full').style.display='';
				
				if (state == 'on'){
					var CurrentDrawer = document.getElementById('CurrentDrawer').value;
					
					if (CurrentDrawer != '') {
						document.getElementById('drawer_'+CurrentDrawer+'_off').style.display='none';
						document.getElementById('drawer_'+CurrentDrawer+'_on').style.display='';
						document.getElementById('drawerdiv_'+CurrentDrawer).style.display='none';
					}
					document.getElementById('drawer_'+value+'_off').style.display='';
					document.getElementById('drawer_'+value+'_on').style.display='none';
					document.getElementById(DrawerContainer).style.display='';
					document.getElementById('CurrentDrawer').value = value;
					
				} else {
					document.getElementById('drawer_'+value+'_off').style.display='none';
					document.getElementById('drawer_'+value+'_on').style.display='';
					document.getElementById(DrawerContainer).style.display='none';
					document.getElementById('CurrentDrawer').value = '';
				}
					
				
			
			}
			function hide_drawer() {
				var CurrentDrawer = document.getElementById('CurrentDrawer').value;
					
					if (CurrentDrawer != '') {
						document.getElementById('drawer_'+CurrentDrawer+'_off').style.display='none';
						document.getElementById('drawer_'+CurrentDrawer+'_on').style.display='';
						document.getElementById('drawerdiv_'+CurrentDrawer).style.display='none';
						document.getElementById('CurrentDrawer').value = '';
					}
			
			}
			
function getXY(e)
{
  var posx = 0;
  var posy = 0;
  var mousePos = new Array();
 
  // Make sure event var is set
  if (!e) var e = window.event;
 
  // Get mouse position; IE & FF Compatibility!
  if (e.pageX || e.pageY)
  {
    posx = e.pageX;
    posy = e.pageY;
  }
  else if (e.clientX || e.clientY)
  {
    posx = e.clientX + document.body.scrollLeft
      + document.documentElement.scrollLeft;
    posy = e.clientY + document.body.scrollTop
      + document.documentElement.scrollTop;
  }
 
  // posx and posy contain the mouse pos; Return them both
 //mousePos[0] = posx;
  //mousePos[1] = posy;
document.getElementById("mousex").value = posx;
document.getElementById("mousey").value = posy;
//alert('Mouse x = ' + document.getElementById("mousex").value);
  return mousePos;
}
 
// Makes an object appear at mouse position
function mini_menu(itemtitle, itemlink, itemid, obj, value, element, e)
{
  // Get mouse position
  var currentMenu = document.getElementById("selectedMini").value;
 
  if ((currentMenu != '') && (currentMenu != element.id))
 	document.getElementById('popupmenu').style.display = 'none';
  	
   document.getElementById("selectedMini").value = element.id;
	
  
  var myPos = getXY(e);

//alert('Mouse x2 = ' + document.getElementById("mousex").value);


 if (obj == 'string') {
 		MarkStatus=document.getElementById('string_'+itemid).className;
	//	alert(MarkStatus);
		if (MarkStatus == 'marked') {
			status = 'UNMARK ITEM';
		
		} else {
			status = 'MARK ITEM';
		
		}
		document.getElementById("popupmenu").innerHTML = '<a href="'+itemlink+'">GOTO PAGE</a><br/><a href="#" onclick="hide_layer(\'popupmenu\', event);add_drawer_item(\'from_string\',\''+itemid+'\',\''+itemtitle+'\',\''+itemlink+'\');return false;">ADD TO DRAWER</a><br/><a href="#" onClick=\"add_volt(\''+itemid+'\',\'string_entry\',\'\',\'\');hide_layer(\'popupmenu\', event);return false;\">VOLT IT!</a><br/><a href="#" onClick=\"mark_page(\''+itemid+'\',\''+MarkStatus+'\');hide_layer(\'popupmenu\', event);return false;\">'+status+'</a><div style="height:5px;" onmouseover="hide_layer(\'popupmenu\',event);"></div>';
	obj = 'popupmenu';
 }
 

   
  // Set obj to mouse pos and make it visible
  if (document.getElementById(obj).style.display == '') {
  		document.getElementById(obj).style.display = 'none';

  }  else {
 
 		var mousex = document.getElementById("mousex").value
  		var mousey =document.getElementById("mousey").value;
  document.getElementById(obj).style.left = mousex + 'px';
  document.getElementById(obj).style.top = (parseInt(mousey) + 5)+ 'px';
  document.getElementById(obj).style.display = '';
//document.getElementById('string').style.display = 'none';

  }
}

function hide_layer(obj, e)
{
  document.getElementById(obj).style.display = 'none';
}

function mark_page(itemid,value) {

			attach_file( 'http://www.w3volt.com/processing/mark_page.php?id='+itemid+'&status='+value);

}

function add_drawer_item(refer,itemid,itemtitle,itemlink){

    var returnlink = escape('<? echo curPageURL();?>');
    // open a welcome message as soon as the window loads
	
  Shadowbox.open({
       content: 'http://www.w3volt.com/processing/add_drawer_item.php?refer='+refer+'&id='+itemid+'&title='+escape(itemtitle)+'&link='+escape(itemlink)+'&returnlink='+returnlink,
      player:     "iframe",
       title:      "",
     height:     100,
     width:      475
    });

};

function add_volt(itemid,refer, Subvariable1, Subvariable2){

    var returnlink = escape('<? echo curPageURL();?>');
    // open a welcome message as soon as the window loads
	
  Shadowbox.open({
       content: 'http://www.w3volt.com/processing/volt_item.php?refer='+refer+'&id='+itemid+'&var1='+escape(Subvariable1)+'&var2='+escape(Subvariable2)+'&returnlink='+returnlink,
      player:     "iframe",
       title:      "",
     height:     100,
     width:      475
    });

};


function close_wizard(value) {

   		Shadowbox.close();

}

 function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
 }
 
 function setDefault(theText) 
{
     if (theText.value == "")
 {
         theText.value = theText.defaultValue;
     }
 }
 
 function open_login() {
 	 document.getElementById('login_div').style.display = '';
 
 }
        </script>


<? if ($BodyStyle == '') {
	$BodyStyle = 'background-image:url(http://www.w3volt.com/images/bg.jpg);background-repeat:no-repeat;background-position:top left;background-color:#eef3f7;';
} else { 
$BodyStyle ='background-color:#000000;';

}?>
</head>

<body style=" <? echo $BodyStyle;?>" oncontextmenu='return false'>



<script type="text/javascript">
var theWidth, theHeight;
// Window dimensions:
if (window.innerWidth) {
   theWidth=window.innerWidth;
}
else if (document.documentElement && document.documentElement.clientWidth) {
   theWidth=document.documentElement.clientWidth;
}
else if (document.body) {
theWidth=document.body.clientWidth;
}
if (window.innerHeight) {
theHeight=window.innerHeight;
}
else if (document.documentElement && document.documentElement.clientHeight) {
theHeight=document.documentElement.clientHeight;
}
else if (document.body) {
theHeight=document.body.clientHeight;
}



</script>

        