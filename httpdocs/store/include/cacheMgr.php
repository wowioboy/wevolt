<?php

class cacheMgr {

// how long is the cache lifetime - in seconds? 
var $cachelife = 7200;

/*
* Constructor 
*	- verifies that cache dir exists and is writeable
*	- sets up images and pages dirs
*	
*/
function __construct() {

	// verify that the cache dir exists andis writeable...
	if(!file_exists( 'c' )) {
		echo 'Cache directory "c" needs to be created for cache support to work';
		exit;
	}
	if(file_exists( 'c' ) && !is_writeable( 'c')) {
		echo  'Cache directory "c" exists, but is not writeable' ;
		exit;
	}
}

/*
* Checks to see if an image id is cached 
*
* @param $cacheid -  the image file to test - (ex: abcdefg.jpg)
*
* @return true if image exists in cache, false otherwise
*
*/
function is_image_cached( $cacheid ) {
	
	if( file_exists( 'c/' . $cacheid )) {
		
		$cachetime = time() - $this->cachelife;
		if(  filemtime( 'c/' . $cacheid ) < $cachetime ) {  // expired - blast it
			unlink( 'c/	'. $cacheid );
			return false;
		}
		return true;
	}
	return false;
}

/*
* Iterate over cached resources, removing any that have expired
*
* @return - true if the cache cleanup completes sucessfully
*
*/
function clean_cache( ) {

	// images first..
	$dh = opendir( 'c' );
	$cachetime = time() - $this->cachelife;
	
	while (false !== ($fname = readdir($dh) ) ) {
	
		if( is_dir( $fname )) continue;  // ignore '.' and '..'
		
		if( filemtime( 'c/'. $fname ) < $cachetime ) {  // expired -- blast it.
			unlink( 'c/'. $fname );
		}		
	}
	
	closedir( $dh );
		
	// now the rss cache file
	$dh = opendir( 'c' );
	$cachetime = time() - $this->cachelife;
	while (false !== ($fname = readdir($dh) ) ) {
	
		if( is_dir( $fname )) continue;  // ignore '.' and '..'
		
		if(strstr($fname, "rsscache" )) {
			unlink( 'c/'.$fname);	
		} 	
	
	}
	
	return true;
}

/*
* Set the lifetime of the cache (in seconds) 
*
* @param $lifetime - seconds to keep the cache alive (3600 = 1hr)
*
*/ 
function set_lifetime( $lifetime ) {
	$this->cachelife = $lifetime;
}

/*
* Get the lifetime of the cache (in seconds)
*
* @return $lifetime - returns the number of seconds to keep the cache alive (3600 = 1hr)
*
*/
function get_lifetime() {
	return $this->cachelife;
}


}


?>