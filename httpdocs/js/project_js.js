// JavaScript Document<? if ($Section == 'Downloads')  {?>

function desktopstab() {

	if (document.getElementById("desktopstab")!= null) {
			document.getElementById("desktopsdiv").style.display ='';
			document.getElementById("desktopstab").className ='tabactive';
	}
		
	if (document.getElementById("coverstab")!= null) {
			document.getElementById("coversdiv").style.display = 'none';
			document.getElementById("coverstab").className ='tabinactive';
	}
if (document.getElementById("avatarstab") != null) {
	document.getElementById("avatarsdiv").style.display = 'none';
	document.getElementById("avatarstab").className ='tabinactive';
}

}
function coverstab() {
if (document.getElementById("desktopstab") != null) {
	document.getElementById("desktopsdiv").style.display = 'none';
	document.getElementById("desktopstab").className ='tabinactive';
}
if (document.getElementById("coverstab") != null) {
	document.getElementById("coversdiv").style.display = '';
	document.getElementById("coverstab").className ='tabactive';
}
if (document.getElementById("avatarstab") != null) {
	document.getElementById("avatarsdiv").style.display = 'none';
	document.getElementById("avatarstab").className ='tabinactive';
}
}

function avatarstab() {
if (document.getElementById("desktopstab") != null) {
	document.getElementById("desktopsdiv").style.display = 'none';
	document.getElementById("desktopstab").className ='tabinactive';
}
if (document.getElementById("coverstab") != null) {
	document.getElementById("coversdiv").style.display = 'none';
	document.getElementById("coverstab").className ='tabinactive';
}
if (document.getElementById("avatarstab") != null) {
	document.getElementById("avatarsdiv").style.display = '';
	document.getElementById("avatarstab").className ='tabactive';
}
}


function pdfstab() {

	if (document.getElementById("pdfstab")!= null) {
			document.getElementById("pdfsdiv").style.display ='';
			document.getElementById("pdfstab").className ='tabactive';
	}
		
	if (document.getElementById("printstab")!= null) {
			document.getElementById("printsdiv").style.display = 'none';
			document.getElementById("printstab").className ='tabinactive';
	}
	if (document.getElementById("bookstab") != null) {
		document.getElementById("booksdiv").style.display = 'none';
		document.getElementById("bookstab").className ='tabinactive';
	}
	if (document.getElementById("merchtab") != null) {
		document.getElementById("merchdiv").style.display = 'none';
		document.getElementById("merchtab").className ='tabinactive';
	}
	if (document.getElementById("digitaltab") != null) {
		document.getElementById("digitaldiv").style.display = 'none';
		document.getElementById("digitaltab").className ='tabinactive';
	}

}
function printstab() {
if (document.getElementById("pdfstab")!= null) {
			document.getElementById("pdfsdiv").style.display ='none';
			document.getElementById("pdfstab").className ='tabinactive';
	}
		
	if (document.getElementById("printstab")!= null) {
			document.getElementById("printsdiv").style.display = '';
			document.getElementById("printstab").className ='tabactive';
	}
	if (document.getElementById("bookstab") != null) {
		document.getElementById("booksdiv").style.display = 'none';
		document.getElementById("bookstab").className ='tabinactive';
	}
	if (document.getElementById("merchtab") != null) {
		document.getElementById("merchdiv").style.display = 'none';
		document.getElementById("merchtab").className ='tabinactive';
	}
	if (document.getElementById("digitaltab") != null) {
		document.getElementById("digitaldiv").style.display = 'none';
		document.getElementById("digitaltab").className ='tabinactive';
	}
}

function bookstab() {
if (document.getElementById("pdfstab")!= null) {
			document.getElementById("pdfsdiv").style.display ='none';
			document.getElementById("pdfstab").className ='tabinactive';
	}
		
	if (document.getElementById("printstab")!= null) {
			document.getElementById("printsdiv").style.display = 'none';
			document.getElementById("printstab").className ='tabinactive';
	}
	if (document.getElementById("bookstab") != null) {
		document.getElementById("booksdiv").style.display = '';
		document.getElementById("bookstab").className ='tabactive';
	}
	if (document.getElementById("merchtab") != null) {
		document.getElementById("merchdiv").style.display = 'none';
		document.getElementById("merchtab").className ='tabinactive';
	}
	if (document.getElementById("digitaltab") != null) {
		document.getElementById("digitaldiv").style.display = 'none';
		document.getElementById("digitaltab").className ='tabinactive';
	}
}

function merchtab() {

	if (document.getElementById("pdfstab")!= null) {
		document.getElementById("pdfsdiv").style.display ='none';
		document.getElementById("pdfstab").className ='tabinactive';
	}
		
	if (document.getElementById("printstab")!= null) {
		document.getElementById("printsdiv").style.display = 'none';
		document.getElementById("printstab").className ='tabinactive';
	}
	
	if (document.getElementById("bookstab") != null) {
		document.getElementById("booksdiv").style.display = 'none';
		document.getElementById("bookstab").className ='tabinactive';
	}
	if (document.getElementById("merchtab") != null) {
		document.getElementById("merchdiv").style.display = '';
		document.getElementById("merchtab").className ='tabactive';
	}
	
	if (document.getElementById("digitaltab") != null) {
		document.getElementById("digitaldiv").style.display = 'none';
		document.getElementById("digitaltab").className ='tabinactive';
	}
}
function digitaltab() {
	if (document.getElementById("pdfstab")!= null) {
		document.getElementById("pdfsdiv").style.display ='none';
		document.getElementById("pdfstab").className ='tabinactive';
	}
		
	if (document.getElementById("printstab")!= null) {
		document.getElementById("printsdiv").style.display = 'none';
		document.getElementById("printstab").className ='tabinactive';
	}
	if (document.getElementById("bookstab") != null) {
		document.getElementById("booksdiv").style.display = 'none';
		document.getElementById("bookstab").className ='tabinactive';
	}
	if (document.getElementById("merchtab") != null) {
		document.getElementById("merchdiv").style.display = 'none';
		document.getElementById("merchtab").className ='tabinactive';
	}
	if (document.getElementById("digitaltab") != null) {
		document.getElementById("digitaldiv").style.display = '';
		document.getElementById("digitaltab").className ='tabactive';
	}
}


function wallpaperstab() {

	if (document.getElementById("wallpaperstab")!= null) {
			document.getElementById("wallpapersdiv").style.display ='';
			document.getElementById("wallpaperstab").className ='tabactive';
	}
		
	if (document.getElementById("tonestab")!= null) {
			document.getElementById("tonesdiv").style.display = 'none';
			document.getElementById("tonestab").className ='tabinactive';
	}
	

}
function tonestab() {
	if (document.getElementById("wallpaperstab")!= null) {
			document.getElementById("wallpapersdiv").style.display ='none';
			document.getElementById("wallpaperstab").className ='tabinactive';
	}
		
	if (document.getElementById("tonestab")!= null) {
			document.getElementById("tonesdiv").style.display = '';
			document.getElementById("tonestab").className ='tabactive';
	}
}



function roll_over(img_name, img_src)
   {
   document[img_name].src = img_src;
   }
   
function GetElementPostion(xElement){

  var selectedPosX = 0;
  var selectedPosY = 0;
  var theElement = document.getElementById(xElement);
     // alert(xElement);        
  while(theElement != null){
    selectedPosX += theElement.offsetLeft;
    selectedPosY += theElement.offsetTop;
    theElement = theElement.offsetParent;
  }
      // alert('X='+ selectedPosX);               		      		      
  return selectedPosX + "," + selectedPosY;
  

}

function switch_creators(creatorID) {

		if (creatorID == 'main') {
			document.getElementById("maincreator_right").style.display = '';
			document.getElementById("maincreator_left").style.display = '';
			document.getElementById('maintab').className ='tabactive';
			
			if (document.getElementById("creatorone_left") != null) {
				document.getElementById("creatorone_right").style.display = 'none';
				document.getElementById("creatorone_left").style.display = 'none';
				document.getElementById('onetab').className ='tabinactive';
			}
			if (document.getElementById("creatortwo_left") != null) {
				document.getElementById("creatortwo_right").style.display = 'none';
				document.getElementById("creatortwo_left").style.display = 'none';
				document.getElementById('twotab').className ='tabinactive';
			}
			if (document.getElementById("creatorthree_left") != null) {
				document.getElementById("creatorthree_right").style.display = 'none';
				document.getElementById("creatorthree_left").style.display = 'none';
				document.getElementById('threetab').className ='tabinactive';
			}
		}
		
		if (creatorID == 'one') {
			document.getElementById("maincreator_right").style.display = 'none';
			document.getElementById("maincreator_left").style.display = 'none';
			document.getElementById('maintab').className ='tabinactive';
			

				document.getElementById("creatorone_right").style.display = '';
				document.getElementById("creatorone_left").style.display = '';
				document.getElementById('onetab').className ='tabactive';

			if (document.getElementById("creatortwo_left") != null) {
				document.getElementById("creatortwo_right").style.display = 'none';
				document.getElementById("creatortwo_left").style.display = 'none';
				document.getElementById('twotab').className ='tabinactive';
			}
			if (document.getElementById("creatorthree_left") != null) {
				document.getElementById("creatorthree_right").style.display = 'none';
				document.getElementById("creatorthree_left").style.display = 'none';
				document.getElementById('threetab').className ='tabinactive';
			}
		}
		if (creatorID == 'two') {
			document.getElementById("maincreator_right").style.display = 'none';
			document.getElementById("maincreator_left").style.display = 'none';
			document.getElementById('maintab').className ='tabinactive';
			
			if (document.getElementById("creatorone_left") != null) {
				document.getElementById("creatorone_right").style.display = 'none';
				document.getElementById("creatorone_left").style.display = 'none';
				document.getElementById('onetab').className ='tabinactive';
			}
			if (document.getElementById("creatortwo_left") != null) {
				document.getElementById("creatortwo_right").style.display = '';
				document.getElementById("creatortwo_left").style.display = '';
				document.getElementById('twotab').className ='tabactive';
			}
			
			if (document.getElementById("creatorthree_left") != null) {
				document.getElementById("creatorthree_right").style.display = 'none';
				document.getElementById("creatorthree_left").style.display = 'none';
				document.getElementById('threetab').className ='tabinactive';
			}
		}
		
		if (creatorID == 'three') {
				document.getElementById("maincreator_right").style.display = 'none';
				document.getElementById("maincreator_left").style.display = 'none';
				document.getElementById('maintab').className ='tabinactive';
			
			if (document.getElementById("creatorone_left") != null) {
				document.getElementById("creatorone_right").style.display = 'none';
				document.getElementById("creatorone_left").style.display = 'none';
				document.getElementById('onetab').className ='tabinactive';
			}
			if (document.getElementById("creatortwo_left") != null) {
				document.getElementById("creatortwo_right").style.display = 'none';
				document.getElementById("creatortwo_left").style.display = 'none';
				document.getElementById('twotab').className ='tabinactive';
			}
			
			if (document.getElementById("creatorthree_left") != null) {
				document.getElementById("creatorthree_right").style.display = '';
				document.getElementById("creatorthree_left").style.display = '';
				document.getElementById('threetab').className ='tabactive';
			}
		}

}	


function right(e) {
if (navigator.appName == 'Netscape' && 
(e.which == 3 || e.which == 2))
return false;
else if (navigator.appName == 'Microsoft Internet Explorer' && 
(event.button == 2 || event.button == 3)) {
//alert("Sorry, you do not have permission to right click.");
return false;
}
return true;
}

