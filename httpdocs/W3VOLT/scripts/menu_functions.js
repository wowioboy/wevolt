// JavaScript Document
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