<?php
	/**
	* Categories widget.
	*
	* Alexander Palmo <apalmo at bigevilbrain dot com>
	*/
	
	class Categories extends Sidebar {
		var $plugin;
		
		/* ------ INITIALIZE ------ */
		
		function Categories () {
			$this->plugin = 'Categories';
			$this->loadPrefs();
		}
		
		/* ------ GETTERS & SETTERS ------ */
		
		function getTitle () {
			return $GLOBALS[ 'lang_string' ][ 'menu_categories' ];
		}
		
		function getContent () {
			$str = '';
			
			$catArray = get_category_array();
			if ( count($catArray) > 0) {
				for ( $i = 0; $i < count( $catArray ); $i++ ) {
					$id_number = $catArray[$i][0];
					$name_str = $catArray[$i][1];
					$space_count = $catArray[$i][2];
					for ( $j = 0; $j < $space_count; $j++ ) {
						// Indent the proper number of spaces...
						$str  .= '&nbsp;';
					}
					if ( $GLOBALS[ 'category' ] == $id_number ) {
						// This is the current viewing category...
						$str  .= $name_str;
					} else {
						$str  .= "<a href=\"index.php?category=" . $id_number . "\">" . $name_str . "</a>";
					}
					if ( $i == count( $catArray ) - 1 ) {
						// Last item...
						$str  .= "\n";
					} else {
						$str  .= "<br />\n";
					}
				}
			}
			
			return $str;
		}
	}
?>