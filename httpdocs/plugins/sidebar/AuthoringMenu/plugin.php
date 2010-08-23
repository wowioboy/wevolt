<?php
	/**
	* Authoring menu widget.
	*
	* Alexander Palmo <apalmo at bigevilbrain dot com>
	*/
	
	class AuthoringMenu extends Sidebar {
		var $plugin;
		
		/* ------ INITIALIZE ------ */
		
		function AuthoringMenu () {
			$this->plugin = 'AuthoringMenu';
			$this->loadPrefs();
		}
		
		/* ------ GETTERS & SETTERS ------ */
		
		function getTitle () {
			return $GLOBALS[ 'lang_string' ][ 'menu_menu' ];
		}
		
		function getContent () {
			$str = '';
	
			if ( $GLOBALS[ 'logged_in' ] == true ) {
				$str .= '<a href="add.php">' . $GLOBALS[ 'lang_string' ][ 'menu_add' ] . '</a><br />';
				$str .= '<a href="add_static.php">' . $GLOBALS[ 'lang_string' ][ 'menu_add_static' ] . '</a><br />';
				$str .= '<a href="upload_img.php">' . $GLOBALS[ 'lang_string' ][ 'menu_upload' ] . '</a>';
			}
			
			return $str;
		}
	}
?>