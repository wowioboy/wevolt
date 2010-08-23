<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/yahoo-dom-event/yahoo-dom-event.js"></script>
<script src="http://yui.yahooapis.com/2.8.0r4/build/event-mouseenter/event-mouseenter-min.js" ></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/container/container-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/animation/animation-min.js"></script>
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/menu/menu-min.js"></script>
<script src="http://yui.yahooapis.com/2.8.0r4/build/element/element-min.js"></script> 
<script type="text/javascript" src="http://yui.yahooapis.com/2.8.0r4/build/carousel/carousel-min.js"></script>

<link rel="stylesheet" type="text/css" href="http://www.wevolt.com/css/spotlight_css.css"> 

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script type="text/javascript">
 (function () {
        var carousel;
                
        YAHOO.util.Event.onDOMReady(function (ev) {
            var carousel    = new YAHOO.widget.Carousel("spotlight_container", {
                        isCircular: true, numVisible: 1,
						autoPlayInterval: 10000,

                });
document.getElementById('spotlight_container').style.display = '';
            carousel.render(); // get ready for rendering the widget

           carousel.startAutoPlay();
   // display the widget
			
        });
    })();


</script>
</head>

<body class="yui-skin-wevolt">
<div style="height: 160px;">
 <div id="spotlight_container">
        <ol id="spot_carousel">
            <li class="item"><div class="spacer"></div><table><tbody><tr><td valign="top"><img src="http://www.panelflow.com/comics/W/Wight_And_Associates/images/comicthumb.jpg"></td><td style="padding-left: 5px; padding-right: 2px;" valign="top"><div class="sender_name">Wight And Associates</div><div class="messageinfo">What do you get when you mix lawyers and the Devil? A thrilling race for souls as an aging lawyer tries to win his back. <br><a href="http://www.w3volt.com/Wight_And_Associates/">CHECK IT OUT</a></div></td></tr></tbody></table></li><li class="item"><div class="spacer"></div><table><tbody><tr><td valign="top"><img src="http://www.panelflow.com/users/matteblack/avatars/TPcolor.jpg"></td><td style="padding-left: 5px; padding-right: 2px;" valign="top"><div class="sender_name">Panel Flow to W3Volt</div><div class="messageinfo">Check out Matt's W3volt page and keep track of the man behind Panel Flow and how it became W3VOLT!<br><a href="http://users.w3volt.com/matteblack/">CHECK IT OUT</a></div></td></tr></tbody></table></li>      
        </ol>

          
    </div>
  
<div><img src="http://www.wevolt.com/images/spot_footer.png"></div>
</div>

</body>
</html>
