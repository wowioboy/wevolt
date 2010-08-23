<?php
	/**
	* Preferences menu widget.
	*
	* Alexander Palmo <apalmo at bigevilbrain dot com>
	*/
	
	class Preferences extends Sidebar {
		var $plugin;
		
		/* ------ INITIALIZE ------ */
		
		function Preferences () {
			$this->plugin = 'Preferences';
			$this->loadPrefs();
		}
		
		/* ------ GETTERS & SETTERS ------ */
		
		function getTitle () {
			return $GLOBALS[ 'lang_string' ][ 'menu_setup' ];
		}
		
		function getContent () {
			$str = '';
	
			if ( $GLOBALS[ 'logged_in' ] == true ) {
				$str = '';
				$str  .= '<a href="categories.php">' . $GLOBALS[ 'lang_string' ][ 'menu_categories' ] . '</a><br />';
				$str  .= '<a href="add_block.php">' . $GLOBALS[ 'lang_string' ][ 'menu_add_block' ] . '</a><br />';
				$str  .= '<a href="setup.php">' . $GLOBALS[ 'lang_string' ][ 'menu_setup' ] . '</a><br />';
				$str  .= '<a href="plugins.php">' . $GLOBALS[ 'lang_string' ][ 'menu_plugins' ] . '</a><br />';
				$str  .= '<a href="emoticons.php">' . $GLOBALS[ 'lang_string' ][ 'menu_emoticons' ] . '</a><br />';
				$str  .= '<a href="themes.php">' . $GLOBALS[ 'lang_string' ][ 'menu_themes' ] . '</a><br />';
				$str  .= '<a href="colors.php">' . $GLOBALS[ 'lang_string' ][ 'menu_colors' ] . '</a><br />';
				$str  .= '<a href="options.php">' . $GLOBALS[ 'lang_string' ][ 'menu_options' ] . '</a><br />';
				$str  .= '<a href="info.php">' . $GLOBALS[ 'lang_string' ][ 'menu_info' ] . '</a><br />';
				$str  .= '<hr />';
				$str  .= '<a href="moderation.php">' . $GLOBALS[ 'lang_string' ][ 'menu_moderation' ] . '</a><br />';
				if ( $GLOBALS[ 'blog_config' ][ 'blog_comments_moderation' ] ) {
					$str  .= '<a href="comments_moderation.php">' . $GLOBALS[ 'lang_string' ][ 'menu_commentmoderation' ] . ' (' . get_unmodded_count(1) . ')</a><br />';
				}
			}
			
			return $str;
		}
	}
?>