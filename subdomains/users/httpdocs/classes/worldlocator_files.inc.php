<?

		$maps_dir			= "maps";
		$marks_dir			= "marks";
	
		// Define inside this array your maps.
		// Syntax: "<map internal name>" => array ("<map file name without extension>", "<map file extension>", <map width in pixels>, <map height in pixels>)
		// Be very careful with including new maps, because the map representation have to start exactly at latitude 90º and longitude -180º in the 0,0 pixels coordinates, and end at latitude -90º and longitude 180º at image's maximum width and height. If you do not so, the marker will not be placed correctly.
		$maps = array
		(
			"day"			=> array ("day",							"png",	750,	375),
			"night"			=> array ("night",							"png",	750,	375)
		);

		// Define inside this array your markers.
		// Syntax: "<mark internal name>" => array ("<mark file name without extension>", "<mark file extension>", <mark width in pixels>, <mark height in pixels>, <mark horizontal pixel offset>, <mark vertical pixel offset>)
		// The last two parameters indicates the center x,y position in pixels inside the mark image. For example, if you draw an arrow, this x,y will indicate the edge of the arrow.
		$marks = array
		(
			"circle"		=> array ("circle",							"png",	18,		18,		8,	8),
			"arrow"			=> array ("arrow",							"png",	26,		25,		7,	24)
		);

?>