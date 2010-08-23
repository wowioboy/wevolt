<?php
	/**
	* Search box widget.
	*
	* Alexander Palmo <apalmo at bigevilbrain dot com>
	*/
	
	class Search extends Sidebar {
		var $plugin;
		
		/* ------ INITIALIZE ------ */
		
		function Search () {
			$this->plugin = 'Search';
			$this->loadPrefs();
		}
		
		/* ------ GETTERS & SETTERS ------ */
		
		function getTitle () {
			return $GLOBALS[ 'lang_string' ][ 'search_title' ];
		}
		
		function getContent () {
			$str = sprintf('<form method="get" action="search.php"><b>%s</b><input type="text" size="16" name="q" />&nbsp;<input type="submit" value="%s" /></form>', $GLOBALS[ 'lang_string' ][ 'search_title' ], $GLOBALS[ 'lang_string' ][ 'search_go' ] );
			return $str;
		}
	}
?>