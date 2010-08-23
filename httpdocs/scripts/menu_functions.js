// JavaScript Document
            /*
                 Initialize and render the Menu when its elements are ready 
                 to be scripted.
            */

 
			
			function toggle_drawer(value,state,location) {
				
				var DrawerContainer = 'drawerdiv_'+value;
				var NumDrawerItems = document.getElementById('drawer_item_cnt_'+value).value;
				var ContainerHeight = 27 * (parseInt(NumDrawerItems)+1);
				var DrawerSet = '';

				document.getElementById("drawerclose").style.left = '400px';
				document.getElementById("drawerclose").style.top = '0px';
				document.getElementById("drawerclosetop").style.left = '0px';
				document.getElementById("drawerclosetop").style.top = '0px';
				
				if (location == 'below') {
					
					if ((value > 0) && (value <6)) 
							DrawerSet = 1;
					else if ((value > 5) && (value <11)) 
							DrawerSet = 2;
							
					var DrawerY = document.getElementById('drawer_set_'+DrawerSet).offsetTop+42;
					var DrawerX = document.getElementById('drawer_set_'+DrawerSet).offsetLeft+0;
									
					document.getElementById('drawers_full').style.left = DrawerX+'px';
					document.getElementById('drawers_full').style.top = DrawerY+'px';
					
				} else {
				
						if ((ContainerHeight + 607) > theHeight) {
							var heightvar = (607 - ((parseInt(NumDrawerItems)+1) * 17));
							document.getElementById('drawers_full').style.top = heightvar+'px';
						
						} else {
							document.getElementById('drawers_full').style.top = '630px';
						}
						
						document.getElementById('drawers_full').style.left = '70px';
				}
				document.getElementById('drawers_full').style.display='';
					document.getElementById("popclose").style.display = 'block';
		            document.getElementById("popclosetop").style.display = 'block';
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
					
					document.getElementById('drawerclose').style.display='none';
				    document.getElementById('drawerclosetop').style.display='none';
			}
			
function findPos(obj) {
	var curleft = curtop = 0;
		if (obj.offsetParent) {
			do {
				curleft += obj.offsetLeft;
				curtop += obj.offsetTop;
			} while (obj = obj.offsetParent);
		}
		return [curleft,curtop];
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
  var MenuType = '';
  var currentMenu = document.getElementById("selectedMini").value;
 
  if ((currentMenu != '') && (currentMenu != element.id))
 		document.getElementById('popupmenu').style.display = 'none';
  	
   document.getElementById("selectedMini").value = element.id;
	
  
  var myPos = getXY(e);

//alert('Mouse x2 = ' + document.getElementById("mousex").value);

	var xadjust = '';
	var yadjust = '';
	 if (obj == 'string') {
 		var MarkStatus=document.getElementById('string_'+itemid).className;
	//	alert(MarkStatus);
		if (MarkStatus == 'marked') {
			status = 'UNMARK ITEM';
		
		} else {
			status = 'MARK ITEM';
		
		}
		//<a href="#" onClick=\"add_volt(\''+itemid+'\',\'string_entry\',\'\',\'\');hide_layer(\'popupmenu\', event);return false;\">VOLT IT!</a><br/>
		document.getElementById("popupmenu").innerHTML = '<a href="'+itemlink+'">GOTO PAGE</a><br/><a href="#" onclick="hide_layer(\'popupmenu\', event);add_drawer_item(\'from_string\',\''+itemid+'\',\''+escape(itemtitle)+'\',\''+itemlink+'\');return false;">ADD TO DRAWER</a><br/><a href="#" onClick=\"mark_page(\''+itemid+'\',\''+MarkStatus+'\');hide_layer(\'popupmenu\', event);return false;\">'+status+'</a><div style="height:5px;" onmouseover="hide_layer(\'popupmenu\',event);"></div>';
	obj = 'popupmenu';

	
		 } else  if (obj == 'search') {
		document.getElementById("popupmenu").innerHTML = '<table><tr><td onmouseover="hide_layer(\'popupmenu\', event);" width="2"></td><td align="center"><a href="'+itemlink+'">LINK</a><br/><a href="#" onclick="hide_layer(\'popupmenu\', event);add_drawer_item(\'from_search\',\''+itemid+'\',\''+escape(itemtitle)+'\',\''+itemlink+'\');return false;">ADD TO DRAWER</a><br/><a href="#" onClick=\"add_volt(\''+itemid+'\',\'project\',\'choose\',\'\');hide_layer(\'popupmenu\', event);return false;\">VOLT IT!</a></td><td onmouseover="hide_layer(\'popupmenu\', event);" width="2"></td></tr></table><div style="height:5px;" onmouseover="hide_layer(\'popupmenu\',event);"></div>';
			var xadjust = 300;
			obj = 'popupmenu';
 		} else  if (obj == 'volt') {
		document.getElementById("popupmenu").innerHTML = '<table><tr><td onmouseover="hide_layer(\'popupmenu\', event);" width="2"></td><td align="center"><a href="'+itemlink+'">LINK</a><br/><a href="#" onclick="hide_layer(\'popupmenu\', event);add_drawer_item(\'from_volt\',\''+itemid+'\',\''+escape(itemtitle)+'\',\''+itemlink+'\');return false;">ADD TO DRAWER</a><br/><a href="#" onClick=\"add_feed_item(\''+itemid+'\',\'project\',\'wevolt\');hide_layer(\'popupmenu\', event);return false;\">POST TO W3VOLT</a><br/><a href="#" onClick=\"remove_volt(\''+itemid+'\');hide_layer(\'popupmenu\', event);return false;\">DELETE</a></td><td onmouseover="hide_layer(\'popupmenu\', event);" width="2"></td></tr></table><div style="height:5px;" onmouseover="hide_layer(\'popupmenu\',event);"></div>';
		var xadjust = 300;
		var yadjust = 150;
	obj = 'popupmenu';
		 } else if ((obj == 'main') || (obj == 'main_not_logged')){
		document.getElementById("mainpop").innerHTML = '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td onmouseover="hide_layer(\'mainpop\', event);" width="8">&nbsp;</td><td background="http://www.wevolt.com/images/sub_menu_bg_no_cap.png" style="width:255px; height:189px; padding-top:35px; background-repeat:no-repeat;" valign="top"><div style="padding-left:30px;"><div style="float:left; width:100px;text-align:left;"><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/register.php?a=pro">GO PRO</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/w3forum/wevolt/">FORUM</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/blog.php">BLOG</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/tutorials.php">TUTORIALS</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/register.php">REGISTER</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/mobile.php">MOBILE</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/studio.php">STUDIO</a></div><div style="float:right; width:100px;text-align:left;"><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/wevolt.php">ABOUT</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/contact.php">CONTACT</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://store.wevolt.com/">STORE</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://calendar.wevolt.com/">CALENDAR</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/search/">WESEARCH</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://users.wevolt.com/matteblack/">MATT</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://users.wevolt.com/jasonbadower/">JASON</a></div></div></td><td onmouseover="hide_layer(\'mainpop\', event);">&nbsp;</td></tr><tr><td onmouseover="hide_layer(\'mainpop\', event);" height="350" colspan="3">&nbsp;</td></tr></table>';
	if (obj == 'main_not_logged'){
	var yadjust = 150;
	var xadjust = 17;
	}else{
	var yadjust = 150;
	var xadjust = 17;
	}
	obj = 'mainpop';

	
	
		 } else if (obj == 'main_pro') {
		document.getElementById("mainpop").innerHTML = '<table width="500" border="0" cellspacing="0" cellpadding="0"><tr><td onmouseover="hide_layer(\'mainpop\', event);" height="85" colspan="3">&nbsp;</td></tr><tr><td width="37">&nbsp;</td><td background="http://www.wevolt.com/images/sub_menu_bg.png" style="width:255px; height:201px; padding-top:35px; background-repeat:no-repeat;" valign="top"><div style="padding-left:30px;"><div style="float:left; width:100px;text-align:left;"><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/w3forum/wevolt/">FORUM</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/blog.php">BLOG</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/tutorials.php">TUTORIALS</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/mobile.php">MOBILE</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/studio.php">STUDIO</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/create.php">CREATE</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/what.php">SAY WHAT?</a></div><div style="float:right; width:100px;text-align:left;"><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/wevolt.php">ABOUT</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/contact.php">CONTACT</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://store.wevolt.com/">STORE</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://calendar.wevolt.com/">CALENDAR</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://www.wevolt.com/search/">WESEARCH</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://users.wevolt.com/matteblack/">MATT</a><br/><img src="http://www.wevolt.com/images/menu_yellow_dopt.png">&nbsp;<a href="http://users.wevolt.com/jasonbadower/">JASON</a></div></div></td><td onmouseover="hide_layer(\'mainpop\', event);">&nbsp;</td></tr><tr><td onmouseover="hide_layer(\'mainpop\', event);" height="350" colspan="3">&nbsp;</td></tr></table>';
	obj = 'mainpop';
	var yadjust = -15;
	var xadjust = 32;
		 } else if (obj == 'myvolt') {
				MenuType = 'myvolt';
					obj = itemtitle;
 		} else if (obj == 'wevolt') {
				MenuType = 'wevolt';
					obj = itemtitle;
 		}
 

   
  // Set obj to mouse pos and make it visible
  if (document.getElementById(obj).style.display == '') {
	  try {
  		document.getElementById(obj).style.display = 'none';
	  } catch (e) {
	  }

  }  else {

 		var mousex = document.getElementById("mousex").value;
  		var mousey =document.getElementById("mousey").value;
		
		var adjustedx = (parseInt(mousex) + xadjust);
		var adjustedy = (parseInt(mousey) + yadjust);
	//	alert('x = ' +mousex);
		//alert('adx = ' +adjustedx);
		//alert(mousey);
		
		if (obj == 'mainpop') {
			document.getElementById(obj).style.left = parseInt(xadjust)+ 'px';	
		  document.getElementById(obj).style.top = parseInt(yadjust)+ 'px';	
			
		} else if (MenuType == 'myvolt') {
			 	document.getElementById(obj).style.left = (parseInt(adjustedx) - 20)  + 'px';
		 		document.getElementById(obj).style.top = (parseInt(adjustedy)-10)+ 'px';	
		} else if (MenuType == 'wevolt') {
			 	document.getElementById(obj).style.left = (parseInt(adjustedx) - 20)  + 'px';
		 		document.getElementById(obj).style.top = (parseInt(adjustedy)-10)+ 'px';	
		} else {
				var positionarray = findPos(document.getElementById('string_'+itemid));
				document.getElementById(obj).style.left = (parseInt(positionarray[0])+90)  + 'px';
		  		document.getElementById(obj).style.top = (parseInt(positionarray[1])-4)  + 'px';
				document.getElementById("popclose").style.left = (parseInt(positionarray[0])+195)  + 'px';
				document.getElementById("popclose").style.top = '0px';
				document.getElementById("popclosetop").style.left = '0px';
				document.getElementById("popclosetop").style.top = (parseInt(positionarray[1])-23)  + 'px';
				document.getElementById("popclosebottom").style.left = '0px';
				document.getElementById("popclosebottom").style.top = (parseInt(positionarray[1])+45)  + 'px';
		}
 
		document.getElementById(obj).style.display = 'block';
		document.getElementById("popclose").style.display = 'block';
		document.getElementById("popclosetop").style.display = 'block';
		document.getElementById("popclosebottom").style.display = 'block';
		document.getElementById(obj).style.zIndex = 99;
  }
  	
}

function close_popup() {
	
	hide_layer('popupmenu', '');
	hide_layer('popclose', '');
	hide_layer('popclosetop', '');
	hide_layer('popclosebottom', '');
	
	
}

function hide_layer(obj, e)
{
	if (obj) {
		document.getElementById(obj).style.display = 'none';
	}
}

function mark_page(itemid,value) {

			attach_file( 'http://www.wevolt.com/processing/mark_page.php?id='+itemid+'&status='+value);

}
 function show_user_menu(value) {
				
				 	document.getElementById(value).style.top = '60px';
					document.getElementById(value).style.left = '0px';
					document.getElementById(value).style.display='';
			}
			function hide_user_menu(value) {
				document.getElementById(value).style.display='none';
			}
	 function show_ranking() {
				
				 	document.getElementById("ranking_div").style.top = '270px';
					document.getElementById("ranking_div").style.left = '63px';
					document.getElementById("ranking_div").style.display='';
			}	
			
			 function show_user_panel() {
				
				 	document.getElementById("user_panel").style.top = '360px';
					document.getElementById("user_panel").style.left = '70px';
					document.getElementById("user_panel").style.display='';
			}		