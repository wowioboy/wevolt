/*
Copyright (c) 2005 Tim Taylor Consulting <http://tool-man.org/>

Permission is hereby granted, free of charge, to any person obtaining a
copy of this software and associated documentation files (the "Software"),
to deal in the Software without restriction, including without limitation
the rights to use, copy, modify, merge, publish, distribute, sublicense,
and/or sell copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included
in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
IN THE SOFTWARE.
*/

var ToolMan = {
	events : function() {
		if (!ToolMan._eventsFactory) throw "ToolMan Events module isn't loaded";
		return ToolMan._eventsFactory
	},

	css : function() {
		if (!ToolMan._cssFactory) throw "ToolMan CSS module isn't loaded";
		return ToolMan._cssFactory
	},

	coordinates : function() {
		if (!ToolMan._coordinatesFactory) throw "ToolMan Coordinates module isn't loaded";
		return ToolMan._coordinatesFactory
	},

	drag : function() {
		if (!ToolMan._dragFactory) throw "ToolMan Drag module isn't loaded";
		return ToolMan._dragFactory
	},

	dragsort : function() {
		if (!ToolMan._dragsortFactory) throw "ToolMan DragSort module isn't loaded";
		return ToolMan._dragsortFactory
	},

	helpers : function() {
		return ToolMan._helpers
	},

	cookies : function() {
		if (!ToolMan._cookieOven) throw "ToolMan Cookie module isn't loaded";
		return ToolMan._cookieOven
	},

	junkdrawer : function() {
		return ToolMan._junkdrawer
	}

}

ToolMan._helpers = {
	map : function(array, func) {
		for (var i = 0, n = array.length; i < n; i++) func(array[i])
	},

	nextItem : function(item, nodeName) {
		if (item == null) return
		var next = item.nextSibling
		while (next != null) {
			if (next.nodeName == nodeName) return next
			next = next.nextSibling
		}
		return null
	},

	previousItem : function(item, nodeName) {
		var previous = item.previousSibling
		while (previous != null) {
			if (previous.nodeName == nodeName) return previous
			previous = previous.previousSibling
		}
		return null
	},

	moveBefore : function(item1, item2) {
		var parent = item1.parentNode
		parent.removeChild(item1)
		parent.insertBefore(item1, item2)
	},

	moveAfter : function(item1, item2) {
		var parent = item1.parentNode
		parent.removeChild(item1)
		parent.insertBefore(item1, item2 ? item2.nextSibling : null)
	}
}

/** 
 * scripts without a proper home
 *
 * stuff here is subject to change unapologetically and without warning
 */
ToolMan._junkdrawer = {
	serializeList : function(list) {
		var items = list.getElementsByTagName("span")
		var array = new Array()
		for (var i = 0, n = items.length; i < n; i++) {
			var item = items[i]

			array.push(ToolMan.junkdrawer()._identifier(item))
		}
		return array.join('|')
	},

	inspectListOrder : function(id, directory, app) {
		string = ToolMan.junkdrawer().serializeList(document.getElementById(id));
		
		//alert('string ' + string);
		var IDs = string.split('|');
	//	alert('LENGTH = ' +IDs.length);
		var tempIDstring = '';
		var tempThumbstring = '';
		var tempImagestring = '';
		for (var i = 0, n = IDs.length; i < n; i++) {
			var itemID = IDs[i];
			var OrderElements = itemID.split('--');
			
			//alert('ID = ' + OrderElements[0]);
			//alert('Thumb' + OrderElements[1]);
			//alert('IMAGE = ' + OrderElements[2]);
			if (tempIDstring == '') {
				tempIDstring = OrderElements[0];
			
			} else {
				tempIDstring = tempIDstring+','+OrderElements[0];
			}
			
			
			if (tempThumbstring== '') {
				tempThumbstring = 'imported/temp/'+directory+'/thumbs/'+OrderElements[1];
			} else {
				tempThumbstring = tempThumbstring+','+'imported/temp/'+directory+'/thumbs/'+OrderElements[1];
			}
			
			if (tempImagestring == '') {
				tempImagestring = 'imported/temp/'+directory+'/'+OrderElements[2];
			} else {
				tempImagestring = tempImagestring+'||imported/temp/'+directory+'/'+OrderElements[2];
			}
			
			
		}
		
		//alert(tempIDstring);
		//alert(tempThumbstring);
		//alert(tempImagestring);
		document.getElementById("IdString").value = tempIDstring;
		document.getElementById("txtPages").value = tempImagestring;
		document.getElementById("txtThumbs").value = tempThumbstring;
		//alert(document.getElementById("IdString").value);
	//alert(document.getElementById("txtPages").value);
	//alert(document.getElementById("txtThumbs").value);
		//var mytag = document.getElementsByTagName('body')[0];//or 'head'
		//var script= document.createElement('script');
		//script.type = 'text/javascript';
		//script.setAttribute('language', 'javascript');
		//script.src = '/save_order.php?idstring='+string;
		//mytag.appendChild(script); 
		if (app == 'pdf') {
			ComicID = document.getElementById("txtSafeFolder").value;
			document.PageForm.action='/create/pdf/'+ComicID+'/';
			document.PageForm.submit();
		} else {
			alert('Order saved!');	
		}
		
	},
	
	reverseListOrder : function(id, directory, app) {
		string = ToolMan.junkdrawer().serializeList(document.getElementById(id));
		
		//alert('string ' + string);
		var IDs = string.split('|');
		var tempIDstring = '';
		var tempThumbstring = '';
		var tempImagestring = '';
		var length = IDs.length-1;
		//alert('LENGTH = ' +length);
		for (var i = length, n = 0; i >= n; i--) {
			//alert(i);
			var itemID = IDs[i];
			var OrderElements = itemID.split('--');
			//	alert('Order elements array size = ' + OrderElements.length);
		//	alert('ID = ' + OrderElements[0]);
			//alert('Thumb' + OrderElements[1]);
			//alert('IMAGE = ' + OrderElements[2]);
			if (tempIDstring == '') {
				tempIDstring = OrderElements[0];
			
			} else {
				tempIDstring = tempIDstring+','+OrderElements[0];
			}
			
			
			if (tempThumbstring== '') {
				tempThumbstring = 'imported/temp/'+directory+'/thumbs/'+OrderElements[1];
			} else {
				tempThumbstring = tempThumbstring+','+'imported/temp/'+directory+'/thumbs/'+OrderElements[1];
			}
			
			if (tempImagestring == '') {
				tempImagestring = 'imported/temp/'+directory+'/'+OrderElements[2];
			} else {
				tempImagestring = tempImagestring+'||imported/temp/'+directory+'/'+OrderElements[2];
			}
			
			
		}
		
		//alert(tempIDstring);
		//alert(tempThumbstring);
		//alert(tempImagestring);
		document.getElementById("IdString").value = tempIDstring;
		document.getElementById("txtPages").value = tempImagestring;
		document.getElementById("txtThumbs").value = tempThumbstring;
		var SafeFolder = document.getElementById("txtSafeFolder").value;
		document.PageForm.action='/comic/import/'+SafeFolder+'/';
		document.PageForm.submit();
		//alert(document.getElementById("IdString").value);
	//alert(document.getElementById("txtPages").value);
	//alert(document.getElementById("txtThumbs").value);
		//var mytag = document.getElementsByTagName('body')[0];//or 'head'
		//var script= document.createElement('script');
		//script.type = 'text/javascript';
		//script.setAttribute('language', 'javascript');
		//script.src = '/save_order.php?idstring='+string;
		//mytag.appendChild(script); 
		
			alert('Order reversed!');	
		
		
	},

	restoreListOrder : function(listID) {
		var list = document.getElementById(listID)
		if (list == null) return

		var cookie = ToolMan.cookies().get("list-" + listID)
		if (!cookie) return;

		var IDs = cookie.split('|')
		var items = ToolMan.junkdrawer()._itemsByID(list)

		for (var i = 0, n = IDs.length; i < n; i++) {
			var itemID = IDs[i]
			if (itemID in items) {
				var item = items[itemID]
				list.removeChild(item)
				list.insertBefore(item, null)
			}
		}
	},

	_identifier : function(item) {
		var trim = ToolMan.junkdrawer().trim
		var identifier

		identifier = trim(item.getAttribute("id"))
		if (identifier != null && identifier.length > 0) return identifier;
		
		identifier = trim(item.getAttribute("itemID"))
		if (identifier != null && identifier.length > 0) return identifier;
		
		// FIXME: strip out special chars or make this an MD5 hash or something
		return trim(item.innerHTML)
	},

	_itemsByID : function(list) {
		var array = new Array()
		var items = list.getElementsByTagName('li')
		for (var i = 0, n = items.length; i < n; i++) {
			var item = items[i]
			array[ToolMan.junkdrawer()._identifier(item)] = item
		}
		return array
	},

	trim : function(text) {
		if (text == null) return null
		return text.replace(/^(\s+)?(.*\S)(\s+)?$/, '$2')
	}
}
