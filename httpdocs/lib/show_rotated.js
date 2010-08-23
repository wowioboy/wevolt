Event.observe(window, 'load', function() { 
	$('rotatedImages').hide();
	link = document.createElement("a");
	link.setAttribute("href","#");
	link.setAttribute("id","showRotated")
	linkText = document.createTextNode("Show rotated images");
	link.appendChild(linkText);
	paragraph = document.createElement("p");
	paragraph.setAttribute("id","showRotatedImages");
	paragraph.appendChild(link);
	document.getElementsByTagName("body")[0].appendChild(paragraph);
	
	Event.observe($('showRotated'), 'click', function(){
		$('rotatedImages').show();
		$('showRotated').hide();
		return false;
		});
	
	});