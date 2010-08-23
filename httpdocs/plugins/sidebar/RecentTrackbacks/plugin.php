<?php
	/**
	* Most recent trackbacks widget.
	*
	* Alexander Palmo <apalmo at bigevilbrain dot com>
	*/
	
	class RecentTrackbacks extends Sidebar {
		var $plugin;
		
		/* ------ INITIALIZE ------ */
		
		function RecentTrackbacks () {
			$this->plugin = 'RecentTrackbacks';
			$this->loadPrefs();
		}
		
		/* ------ GETTERS & SETTERS ------ */
		
		function getTitle () {
			return $GLOBALS[ 'lang_string' ][ 'menu_most_recent_trackback' ];
		}
		
		function getContent () {
			$str = '';
			
			if ( $GLOBALS[ 'blog_config' ][ 'blog_trackback_enabled' ] ) {
				$str = get_most_recent_trackback();
			}
			
			return $str;
		}
	}
?>