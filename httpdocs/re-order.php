<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
/*margin and padding on body element
  can introduce errors in determining
  element position and are not recommended;
  we turn them off as a foundation for YUI
  CSS treatments. */
body {
	margin:0;
	padding:0;
}
</style>

<link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.8.0r4/build/fonts/fonts-min.css" />
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/animation/animation-min.js"></script>

<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/dragdrop/dragdrop-min.js"></script>


<!--begin custom header content for this example-->

<style type="text/css">

div.workarea { padding:10px; float:left }

ul.draglist { 
    position: relative;
    width: 200px; 
    height:240px;
    background: #f7f7f7;
    border: 1px solid gray;
    list-style: none;
    margin:0;
    padding:0;
}

ul.draglist li {
    margin: 1px;
    cursor: move;
    zoom: 1;
}

ul.draglist_alt { 
    position: relative;
    width: 200px; 
    list-style: none;
    margin:0;
    padding:0;
    /*
       The bottom padding provides the cushion that makes the empty 
       list targetable.  Alternatively, we could leave the padding 
       off by default, adding it when we detect that the list is empty.
    */
    padding-bottom:20px;
}

ul.draglist_alt li {
    margin: 1px;
    cursor: move; 
}



#user_actions { float: right; }

#updateBox_T {
background-color:#e9eef4;
height:15px;
}

#updateboxcontent {
	color:#000000;
	background-color:#e9eef4;
}

#updateBox_B {
background-color:#e9eef4;
height:15px;
 
}


#updateBox_TL{
	width:15px;
	height:15px; 
	background-image:url(/images/update_wrapper_TL.png);
	background-repeat:no-repeat;
}

#updateBox_TR{
	width:15px;
	height:15px; 
	background-image:url(/images/update_wrapper_TR.png);
	background-repeat:no-repeat;
}

#updateBox_BR{
	width:15px;
	height:15px; 
	background-image:url(/images/update_wrapper_BR.png);
	background-repeat:no-repeat;
}
#updateBox_BL{
	width:15px;
	height:15px; 
	background-image:url(/images/update_wrapper_BL.png);
	background-repeat:no-repeat;
}
</style>


<!--end custom header content for this example-->

</head>

<body>


<h1>Reordering a List</h1>

<div class="exampleIntro">
	<p>This example demonstrates how to create a list that can have the order changed with the <a href="http://developer.yahoo.com/yui/dragdrop/">Drag &amp; Drop Utility</a>.</p>
			
</div>

<!--BEGIN SOURCE CODE FOR EXAMPLE =============================== -->




<div class="workarea">
  <h3>List 2</h3>
  <ul id="ul2" class="draglist">
    <li class="list2" id="li2_1"><table border='0' cellspacing='0' cellpadding='0' width='173'>
 <tr>
 <td  id="updateBox_TL"></td>
 <td  id="updateBox_T"></td>
 <td  id="updateBox_TR"></td>
 </tr>
 <tr><td colspan="3" id="updateboxcontent"><img src="http://www.panelflow.com/users/matteblack/avatars/TPcolor.jpg" width="50" border="0"></td></tr>
  <tr>
 <td  id="updateBox_BL"></td>
 <td  id="updateBox_B"></td>
 <td  id="updateBox_BR"></td>
 </tr>
 </table></li>
    <li class="list2" id="li2_2"><table border='0' cellspacing='0' cellpadding='0' width='173'>
 <tr>
 <td  id="updateBox_TL"></td>
 <td  id="updateBox_T"></td>
 <td  id="updateBox_TR"></td>
 </tr>
 <tr><td colspan="3" id="updateboxcontent"><img src="http://www.panelflow.com/users/matteblack/avatars/TPcolor.jpg" width="50" border="0"></td></tr>
  <tr>
 <td  id="updateBox_BL"></td>
 <td  id="updateBox_B"></td>
 <td  id="updateBox_BR"></td>
 </tr>
 </table></li>
    <li class="list2" id="li2_3"><table border='0' cellspacing='0' cellpadding='0' width='173'>
 <tr>
 <td  id="updateBox_TL"></td>
 <td  id="updateBox_T"></td>
 <td  id="updateBox_TR"></td>
 </tr>
 <tr><td colspan="3" id="updateboxcontent" width="143"><img src="http://www.panelflow.com/users/matteblack/avatars/TPcolor.jpg" width="50" border="0"></td></tr>
  <tr>
 <td  id="updateBox_BL"></td>
 <td  id="updateBox_B"></td>
 <td  id="updateBox_BR"></td>
 </tr>
 </table></li>

  </ul>
</div>

<div class="workarea">
  <h3>List 2</h3>
  <ul id="ul3" class="draglist">
    <li class="list3" id="li3_1"><table border='0' cellspacing='0' cellpadding='0' width='173'>
 <tr>
 <td  id="updateBox_TL"></td>
 <td  id="updateBox_T"></td>
 <td  id="updateBox_TR"></td>
 </tr>
 <tr><td colspan="3" id="updateboxcontent">list 2, item 1</td></tr>
  <tr>
 <td  id="updateBox_BL"></td>
 <td  id="updateBox_B"></td>
 <td  id="updateBox_BR"></td>
 </tr>
 </table></li>
    <li class="list3" id="li3_2"><table border='0' cellspacing='0' cellpadding='0' width='173'>
 <tr>
 <td  id="updateBox_TL"></td>
 <td  id="updateBox_T"></td>
 <td  id="updateBox_TR"></td>
 </tr>
 <tr><td colspan="3" id="updateboxcontent">list 2, item 1</td></tr>
  <tr>
 <td  id="updateBox_BL"></td>
 <td  id="updateBox_B"></td>
 <td  id="updateBox_BR"></td>
 </tr>
 </table></li>
    <li class="list3" id="li3_3"><table border='0' cellspacing='0' cellpadding='0' width='173'>
 <tr>
 <td  id="updateBox_TL"></td>
 <td  id="updateBox_T"></td>
 <td  id="updateBox_TR"></td>
 </tr>
 <tr>
 <td id="updateboxcontent"></td><td id="updateboxcontent"><img src="http://www.panelflow.com/users/matteblack/avatars/TPcolor.jpg" width="50" border="0"></td><td id="updateboxcontent"></td></tr>
  <tr>
 <td  id="updateBox_BL"></td>
 <td  id="updateBox_B"></td>
 <td  id="updateBox_BR"></td>
 </tr>
 </table></li>

  </ul>
</div>
<table border='0' cellspacing='0' cellpadding='0'>
 <tr>
 <td  id="updateBox_TL"></td>
 <td  id="updateBox_T"></td>
 <td  id="updateBox_TR"></td>
 </tr>
 <tr><td id="updateboxcontent"></td><td id="updateboxcontent" ><img src="http://www.panelflow.com/users/matteblack/avatars/TPcolor.jpg" width="50" border="0"></td><td id="updateboxcontent"></td></tr>
  <tr>
 <td  id="updateBox_BL"></td>
 <td  id="updateBox_B"></td>
 <td  id="updateBox_BR"></td>
 </tr>
 </table>
<div id="user_actions">
  <input type="button" id="showButton" value="Show Current Order" />
  <input type="button" id="switchButton" value="Remove List Background" />
</div>

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

        var rows=3,cols=3,i,j;
        for (i=1;i<cols+1;i=i+1) {
            new YAHOO.util.DDTarget("ul"+i);
        }

        for (i=1;i<cols+1;i=i+1) {
            for (j=1;j<rows+1;j=j+1) {
                new YAHOO.example.DDList("li" + i + "_" + j);
            }
        }

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

        dragEl.innerHTML = clickEl.innerHTML;

        Dom.setStyle(dragEl, "color", Dom.getStyle(clickEl, "color"));
        Dom.setStyle(dragEl, "backgroundColor", Dom.getStyle(clickEl, "backgroundColor"));
        Dom.setStyle(dragEl, "border", "2px solid gray");
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
		alert('dropped');
    },

    onDragDrop: function(e, id) {

        // If there is one drop interaction, the li was dropped either on the list,
        // or it was dropped on the current location of the source element.
        if (DDM.interactionInfo.drop.length === 1) {

            // The position of the cursor at the time of the drop (YAHOO.util.Point)
            var pt = DDM.interactionInfo.point; 

            // The region occupied by the source element at the time of the drop
            var region = DDM.interactionInfo.sourceRegion; 

            // Check to see if we are over the source element's location.  We will
            // append to the bottom of the list once we are sure it was a drop in
            // the negative space (the area of the list without any list items)
            if (!region.intersect(pt)) {
                var destEl = Dom.get(id);
                var destDD = DDM.getDDById(id);
                destEl.appendChild(this.getEl());
                destDD.isEmpty = false;
                DDM.refreshCache();
            }

        }
		//alert('starting');
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
        if (destEl.nodeName.toLowerCase() == "li") {
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

</body>
</html>
