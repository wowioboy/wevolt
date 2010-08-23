<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
        "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8">
        <title>Example: Website Left Nav With Submenus Built From Markup (YUI Library)</title>
        
        <!-- Standard reset, fonts and grids -->

        <link rel="stylesheet" type="text/css" href="http://developer.yahoo.com/yui/build/reset-fonts-grids/reset-fonts-grids.css">
 

        <!-- CSS for Menu -->

        <link rel="stylesheet" type="text/css" href="http://developer.yahoo.com/yui/build/menu/assets/skins/sam/menu.css"> 


        <!-- Page-specific styles -->

        <style type="text/css">

            div.yui-b p {
            
                margin: 0 0 .5em 0;
                color: #999;
            
            }
            
            div.yui-b p strong {
            
                font-weight: bold;
                color: #000;
            
            }
            
            div.yui-b p em {

                color: #000;
            
            }            
            
            h1 {

                font-weight: bold;
                margin: 0 0 1em 0;
                padding: .25em .5em;
                background-color: #ccc;

            }

            #productsandservices {
                
                position: static;
                
            }


			/*
				For IE 6: trigger "haslayout" for the anchor elements in the root Menu by 
				setting the "zoom" property to 1.  This ensures that the selected state of 
				MenuItems doesn't get dropped when the user mouses off of the text node of 
				the anchor element that represents a MenuItem's text label.
			*/

			#productsandservices .yuimenuitemlabel {
			
				_zoom: 1;
			
			}

			#productsandservices .yuimenu .yuimenuitemlabel {

				_zoom: normal;

			}

        </style>


        <!-- Dependency source files -->

  <script type="text/javascript" src="http://yui.yahooapis.com/combo?2.8.0r4/build/yahoo-dom-event/yahoo-dom-event.js&2.8.0r4/build/event-mouseenter/event-mouseenter-min.js&2.8.0r4/build/container/container-min.js&2.8.0r4/build/animation/animation-min.js&2.8.0r4/build/menu/menu-min.js&2.8.0r4/build/element/element-min.js&2.8.0r4/build/carousel/carousel-min.js"></script>


        <!-- Page-specific script -->

        <script type="text/javascript">

            /*
                 Initialize and render the Menu when its elements are ready 
                 to be scripted.
            */
            
            YAHOO.util.Event.onContentReady("productsandservices", function () {
            
                /*
                     Instantiate a Menu:  The first argument passed to the 
                     constructor is the id of the element in the page 
                     representing the Menu; the second is an object literal 
                     of configuration properties.
                */

                var oMenu = new YAHOO.widget.Menu("productsandservices", { 
                                                        position: "static", 
                                                        hidedelay:  750, 
                                                        lazyload: true });
            
                /*
                     Call the "render" method with no arguments since the 
                     markup for this Menu instance is already exists in the page.
                */
            
                oMenu.render();            
            
            });

        </script>

    </head>

                                       
    <body class="yui-skin-sam" id="yahoo-com">
        <div id="doc" class="yui-t1">
            <div id="bd">
                <div class="yui-b">
                      
                          <? /*<div id="productsandservices" class="yuimenu">
						           <div class="bd">
                                        <ul class="first-of-type">
                                              <li class="yuimenuitem first-of-type"><li class="yuimenuitem"><a class="yuimenuitemlabel" href="index.php">Profile</a></li><a class="yuimenuitemlabel" href="#drawer_1-0">Comics</a><div id="#drawer_1-0" class="yuimenu">

                                        <div class="bd">
                                        <ul><li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://www.w3volt.com/comics/">Sub</a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://users.wevolt.com/matteblack/?t=feed">Matteblack - Feed</a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="/index.php"> Homepage2</a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://www.w3volt.com/Snakors_Plaza/">Snakor's Pizza</a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://www.w3volt.com/The_Rioteer/">The Rioteer</a></li></ul>
                                         </div>
                                        </div>      
                                       </li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="/index.php">Stupid Users - Homepage</a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="/index.php">Stupid Users </a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://www.w3volt.com/view_feed.php?name=matteblack">Matteblack - Feed</a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="/index.php">Homepage</a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://www.w3volt.com/Peyote_Highway/">Peyote Highway</a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://www.w3volt.com/Big_Trouble_In_Little_China/">Big Trouble In Little China</a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://www.w3volt.com/The_Rioteer/">Rioteer</a></li><li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://www.wevolt.com/WMD/reader/">Wevolt | Wmd - Reader</a></li><a class="yuimenuitemlabel" href="#drawer_1-1">Stuff</a><div id="#drawer_1-1" class="yuimenu">

                                        <div class="bd">
                                        <ul><li class="yuimenuitem"><a class="yuimenuitemlabel" href="studff.php">More Stuff</a></li></ul>
                                         </div>
                                        </div>      
                                       </li></ul></div></div>*/?>
                      
                      
                      
                       <div id="productsandservices" class="yuimenu">
                            <div class="bd">
                            
                                <ul class="first-of-type">
                                <li class="yuimenuitem"><a class="yuimenuitemlabel" href="index.php">Profile</a></li>
                                    <li class="yuimenuitem first-of-type"><a class="yuimenuitemlabel" href="#communication">Communication</a>
										                
                                        <div id="communication" class="yuimenu">
                                            <div class="bd">
                                                <ul>

                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://360.yahoo.com">360&#176;</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://alerts.yahoo.com">Alerts</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://avatars.yahoo.com">Avatars</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://groups.yahoo.com">Groups</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://promo.yahoo.com/broadband/">Internet Access</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">PIM</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://members.yahoo.com">Member Directory</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://messenger.yahoo.com">Messenger</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://mobile.yahoo.com">Mobile</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://www.flickr.com">Flickr Photo Sharing</a></li>

                                                </ul>
                                            </div>
                                        </div>      
                                    
                                    </li>
                                    
                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://shopping.yahoo.com">Shopping</a>
               							 
                                        <div id="shopping" class="yuimenu">
                                            <div class="bd">                    
                                                <ul>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://auctions.shopping.yahoo.com">Auctions</a></li>

                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://autos.yahoo.com">Autos</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://classifieds.yahoo.com">Classifieds</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://shopping.yahoo.com/b:Flowers%20%26%20Gifts:20146735">Flowers &#38; Gifts</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://realestate.yahoo.com">Real Estate</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://travel.yahoo.com">Travel</a></li>

                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://wallet.yahoo.com">Wallet</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://yp.yahoo.com">Yellow Pages</a></li>
                                                </ul>
                                            </div>
                                        </div>                    
                                    
                                    </li>
                                    
                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://entertainment.yahoo.com">Entertainment</a>
                
                                        <div id="entertainment" class="yuimenu">

                                            <div class="bd">                    
                                                <ul>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://fantasysports.yahoo.com">Fantasy Sports</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://games.yahoo.com">Games</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://www.yahooligans.com">Kids</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://music.yahoo.com">Music</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://movies.yahoo.com">Movies</a></li>

                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://music.yahoo.com/launchcast">Radio</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://travel.yahoo.com">Travel</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://tv.yahoo.com">TV</a></li>
                                                </ul>                    
                                            </div>
                                        </div>                                        
                                    
                                    </li>
                                    
                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="#">Information</a>
										
                
                                        <div id="information" class="yuimenu">
                                            <div class="bd">                                        
                                                <ul>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://downloads.yahoo.com">Downloads</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://finance.yahoo.com">Finance</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://health.yahoo.com">Health</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://local.yahoo.com">Local</a></li>

                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://maps.yahoo.com">Maps &#38; Directions</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://my.yahoo.com">My Yahoo!</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://news.yahoo.com">News</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://search.yahoo.com">Search</a></li>
                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://smallbusiness.yahoo.com">Small Business</a></li>

                                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="http://weather.yahoo.com">Weather</a></li>
                                                </ul>                    
                                            </div>
                                        </div>                                        
                                    
                                    </li>
                                    
                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="index.php">Profile</a></li>
                                    <li class="yuimenuitem"><a class="yuimenuitemlabel" href="index.php">Profile</a></li>
                                    
                                </ul> 
                                           
                            </div>
                        </div>
                </div>
                <!-- end: secondary column from outer template -->

            </div>
         </div>
        
    </body>
</html><!-- p4.ydn.sp1.yahoo.com compressed/chunked Fri May 21 16:42:14 PDT 2010 -->
