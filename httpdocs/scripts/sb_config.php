<?php

  // The Simple PHP Blog is released under the GNU Public License.
  //
  // You are free to use and modify the Simple PHP Blog. All changes
  // must be uploaded to SourceForge.net under Simple PHP Blog or
  // emailed to apalmo <at> bigevilbrain <dot> com

  // read_config ( )
  // write_config ( $blog_title, $blog_author, $blog_email, $blog_avatar, $blog_footer, $blog_language, $blog_entry_order, $blog_comment_order, $blog_enable_comments, $blog_max_entries, $blog_comments_popup, $comment_tags_allowed, $blog_enable_gzip_txt, $blog_enable_gzip_output, $blog_email_notification, $blog_send_pings, $blog_ping_urls, $blog_enable_voting, $blog_trackback_enabled, $blog_trackback_auto_discovery, $blog_enable_cache, $blog_enable_calendar, $blog_calendar_start, $blog_enable_title, $blog_enable_permalink, $blog_enable_stats, $blog_enable_lastcomments, $blog_enable_lastentries, $blog_enable_capcha_image )
  // write_metainfo ( $info_keywords, $info_description, $info_copyright )
  // write_theme ( $blog_theme )
  // read_theme ( )
  // write_colors ( $post_array, $user_file )
  // read_colors ( )

  // ----------------
  // Config Functions
  // ----------------

  /*
  function read_config() {
    // Read config information from file.
    
    // NOTE: strings.php can't be loaded until after read_config
    // is call so some default values are English. :(
    
    global $blog_config;
    $blog_config = array();
    
    // --------------
    // DEFAULT VALUES
    // --------------
    
    // config.txt
    $blog_config['blog_language'] = 'english';
    $blog_config['blog_title'] = 'No Title';
    $blog_config['blog_author'] = 'No Author';
    $blog_config['blog_email'] = 'email@myblog.com';
    $blog_config['blog_avatar'] = '';
    $blog_config['blog_footer'] = 'No Footer'; // $lang_string[ 'sb_default_footer' ];
    $blog_config['blog_entry_order'] = 'new_to_old';
    $blog_config['blog_comment_order'] = 'new_to_old';
    $blog_config['blog_enable_comments'] = 1;
    $blog_config['blog_max_entries'] = 5;
    $blog_config['blog_comments_popup'] = 1;
    $blog_config['comment_tags_allowed'] = explode(',', 'b,i,strong,em,url');
    $blog_config['blog_enable_gzip_txt'] = 0;
    $blog_config['blog_enable_gzip_output'] = 0;
    $blog_config['blog_email_notification'] = 0;
    $blog_config['blog_send_pings'] = 0;
    $blog_config['blog_ping_urls'] = '';
    $blog_config['blog_enable_voting'] = 1;
    $blog_config['blog_trackback_enabled'] = 0;
    $blog_config['blog_trackback_auto_discovery'] = 0;
    $blog_config['blog_enable_cache'] = 1;
    $blog_config['blog_enable_calendar'] = 1;
    $blog_config['blog_calendar_start'] = 'sunday';
    $blog_config['blog_enable_title'] = ;
    $blog_config['blog_enable_permalink'] = 1;
    $blog_config['blog_enable_stats'] = 1;
    $blog_config['blog_enable_lastcomments'] = 1;
    $blog_config['blog_enable_lastentries'] = 1;
    $blog_config['blog_enable_capcha'] = 1;
    $blog_config['blog_comment_days_expiry'] = 0;
    $blog_config['blog_enable_capcha_image'] = function_exists( 'imagecreate' );
    $blog_config['blog_enable_archives'] = 1;
    $blog_config['blog_enable_login'] = 1;
    $blog_config['blog_enable_counter'] = 1;
    $blog_config['blog_footer_counter'] = 1;
    $blog_config['blog_counter_hours'] = 24;
    $blog_config['blog_comments_moderation'] = 0;
    $blog_config['blog_search_top'] = 0;
    
    // metainfo.txt
    $blog_config['info_keywords'] = '';
    $blog_config['info_description'] = '';
    $blog_config['info_copyright'] = '';
    
    // blacklist.txt
    $blog_config['banned_address_list'] = '';
    
    // bannedwordlist.txt
    $blog_config['banned_word_list'] = '';
    
    // theme.txt
    global $blog_theme;
    $blog_config[ 'blog_theme' ] = 'default';
    $blog_theme = $blog_config[ 'blog_theme' ];
    
    // --------------
    // LOAD REAL DATA
    // --------------
    
    // config.txt
    $str = sb_read_file( CONFIG_DIR.'config.txt' );
    if ( $str ) {
      $arr = explode_with_keys($str);
      for ($arr as $key => $val) {
        $blog_config[$key] = $val;
      }
    }

    // metainfo.txt
    $str = sb_read_file( CONFIG_DIR.'metainfo.txt' );
    if ( $str ) {
      $arr = explode_with_keys($str);
      for ($arr as $key => $val) {
        $blog_config[$key] = $val;
      }
    }

    // blacklist.txt
    $str = sb_read_file( CONFIG_DIR.'blacklist.txt' );
    if ( $str ) {
      $blog_config[ 'banned_address_list' ] = $contents;
    }

    // bannedwordlist.txt
    $contents = sb_read_file( CONFIG_DIR.'bannedwordlist.txt' );
    if ( $contents ) {
      $blog_config[ 'banned_word_list' ] = $contents;
    }

    // theme.txt
    $contents = sb_read_file( CONFIG_DIR.'theme.txt' );
    if ( $contents ) {
      $blog_theme = $contents;
      $blog_config[ 'blog_theme' ] = $contents;
    }
    
    // -----
    // SETUP
    // -----
    
    require_once('themes/' . $blog_theme . '/themes.php');

    // Load colors
    read_colors();

    // Start GZIP Output
    if ( $blog_config[ 'blog_enable_gzip_output' ] ) {
      sb_gzoutput ();
    }
  }
  */

  function read_config ( ) {
    // Read config information from file.
    //
    global $blog_config;

    $blog_config = array();

    // LOAD CONFIG INFORMATION
    $contents = sb_read_file( CONFIG_DIR.'config.txt' );
    if ( $contents ) {
      $temp_configs = explode('|', $contents);
      $config_keys = array(   'blog_title',
                  'blog_author',
                  'blog_footer',
                  'blog_language',
                  'blog_entry_order',
                  'blog_comment_order',
                  'blog_enable_comments',
                  'blog_max_entries',
                  'blog_comments_popup',
                  'comment_tags_allowed',
                  'blog_email',
                  'blog_avatar',
                  'blog_enable_gzip_txt',
                  'blog_enable_gzip_output',
                  'blog_email_notification',
                  'blog_send_pings',
                  'blog_ping_urls',
                  'blog_enable_voting',
                  'blog_trackback_enabled',
                  'blog_trackback_auto_discovery',
                  'blog_enable_cache',
                  'blog_enable_calendar',
                  'blog_calendar_start',
                  'blog_enable_title',
                  'blog_enable_permalink',
                  'blog_enable_stats',
                  'blog_enable_lastcomments',
                  'blog_enable_lastentries',
                  'blog_enable_capcha',
                  'blog_comment_days_expiry',
                  'blog_enable_capcha_image',
                  'blog_enable_archives',
                  'blog_enable_login',
                  'blog_enable_counter',
                  'blog_footer_counter',
                  'blog_counter_hours',
                  'blog_comments_moderation',
                  'blog_search_top',
                  'blog_enable_static_block',
                  'static_block_options',
                  'static_block_border',
                  'blog_header_graphic',
									'blog_enable_start_category',
									'blog_enable_start_category_selection' );

      for ( $i = 0; $i < count( $temp_configs ); $i++ ) {
        $key = $config_keys[ $i ];
        $blog_config[ $key ] = $temp_configs[ $i ];
      }
    }

    // I've got a minor issue here. You have to set the language before you
    // can call strings.php. The strings file doesn't get called until after
    // read_config. So... I'm just putting in some english values here....

    if ( !isset( $blog_config[ 'blog_language' ] ) ) {
      $blog_config[ 'blog_language' ] = 'english';
    }

    if ( !isset( $blog_config[ 'blog_title' ] ) ) {
      $blog_config[ 'blog_title' ]= 'No Title';
    }

    if ( !isset( $blog_config[ 'blog_author' ] ) ) {
      $blog_config[ 'blog_author' ] = 'No Author';
    }

    if ( !isset( $blog_config[ 'blog_email' ] ) ) {
      $blog_config[ 'blog_email' ] = 'email@myblog.com';
    }

    if ( !isset( $blog_config[ 'blog_avatar' ] ) ) {
      $blog_config[ 'blog_avatar' ] = '';
    }
		
		if ( !isset( $blog_config[ 'blog_enable_start_category_selection' ] ) ) {
      $blog_config[ 'blog_enable_start_category_selection' ] = '';
    }
		
		if ( !isset( $blog_config[ 'blog_enable_start_category' ] ) ) {
      $blog_config[ 'blog_enable_start_category' ] = 0;
    }

    if ( !isset( $blog_config[ 'blog_header_graphic' ] ) ) {
      $blog_config[ 'blog_header_graphic' ] = '';
    }

    if ( !isset( $blog_config[ 'blog_footer' ] ) ) {
      $blog_config[ 'blog_footer' ] = 'No Footer';
    }

    if ( !isset( $blog_config[ 'blog_entry_order' ] ) ) {
      $blog_config[ 'blog_entry_order' ] = 'new_to_old';
    }

    if ( !isset( $blog_config[ 'blog_comment_order' ] ) ) {
      $blog_config[ 'blog_comment_order' ] = 'new_to_old';
    }

    if ( !isset( $blog_config[ 'blog_enable_comments' ] ) ) {
      $blog_config[ 'blog_enable_comments' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_max_entries' ] ) ) {
      $blog_config[ 'blog_max_entries' ] = 5;
    }

    if ( !isset( $blog_config[ 'blog_comments_popup' ] ) ) {
      $blog_config[ 'blog_comments_popup' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_enable_voting' ] ) ) {
      $blog_config[ 'blog_enable_voting' ] = 1;
    }

    if ( !isset( $blog_config[ 'comment_tags_allowed' ] ) ) {
      $blog_config[ 'comment_tags_allowed' ] = explode(',', 'b,i,strong,em,url');
    } else {
      $blog_config[ 'comment_tags_allowed' ] = explode(',', $blog_config[ 'comment_tags_allowed' ]);
    }

    if ( !isset( $blog_config[ 'blog_enable_gzip_txt' ] ) ) {
      $blog_config[ 'blog_enable_gzip_txt' ] = 0;
    }

    if ( !isset( $blog_config[ 'blog_enable_gzip_output' ] ) ) {
      $blog_config[ 'blog_enable_gzip_output' ] = 0;
    }

    if ( !isset( $blog_config[ 'blog_email_notification' ] ) ) {
      $blog_config[ 'blog_email_notification' ] = 0;
    }

    if ( !isset( $blog_config[ 'blog_send_pings' ] ) ) {
      $blog_config[ 'blog_send_pings' ] = 0;
    }

    if ( !isset( $blog_config[ 'blog_ping_urls' ] ) ) {
      $blog_config[ 'blog_ping_urls' ] = '';
    }

    if ( !isset( $blog_config[ 'blog_trackback_enabled' ] ) ) {
      $blog_config[ 'blog_trackback_enabled' ] = 0;
    }

    if ( !isset( $blog_config[ 'blog_trackback_auto_discovery' ] ) ) {
      $blog_config[ 'blog_trackback_auto_discovery' ] = 0;
    }

    if ( !isset( $blog_config[ 'blog_enable_cache' ] ) ) {
      $blog_config[ 'blog_enable_cache' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_enable_calendar' ] ) ) {
      $blog_config[ 'blog_enable_calendar' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_enable_archives' ] ) ) {
      $blog_config[ 'blog_enable_archives' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_search_top' ] ) ) {
      $blog_config[ 'blog_search_top' ] = 0;
    }

    if ( !isset( $blog_config[ 'blog_enable_static_block' ] ) ) {
      $blog_config[ 'blog_enable_static_block' ] = 0;
    }

    if ( !isset( $blog_config[ 'static_block_border' ] ) ) {
      $blog_config[ 'static_block_border' ] = 'border';
    }

    if ( !isset( $blog_config[ 'static_block_options' ] ) ) {
      $blog_config[ 'static_block_options' ] = '';
    }

    if ( !isset( $blog_config[ 'blog_enable_title' ] ) ) {
      $blog_config[ 'blog_enable_title' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_enable_permalink' ] ) ) {
      $blog_config[ 'blog_enable_permalink' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_enable_capcha' ] ) ) {
      $blog_config[ 'blog_enable_capcha' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_enable_stats' ] ) ) {
      $blog_config[ 'blog_enable_stats' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_enable_lastcomments' ] ) ) {
      $blog_config[ 'blog_enable_lastcomments' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_enable_lastentries' ] ) ) {
      $blog_config[ 'blog_enable_lastentries' ] = 1;
    }

    //'blog_calendar_start'
    if ( !isset( $blog_config[ 'blog_calendar_start' ] ) ) {
      $blog_config[ 'blog_calendar_start' ] = 'sunday';
    }

    if ( !isset( $blog_config[ 'blog_comment_days_expiry' ] ) ) {
      $blog_config[ 'blog_comment_days_expiry' ] = 0;
    }

    if ( !isset( $blog_config[ 'blog_enable_capcha_image' ] ) ) {
      $blog_config[ 'blog_enable_capcha_image' ] = function_exists( 'imagecreate' );
    }

    if ( !isset( $blog_config[ 'blog_enable_login' ] ) ) {
      $blog_config[ 'blog_enable_login' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_enable_counter' ] ) ) {
      $blog_config[ 'blog_enable_counter' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_footer_counter' ] ) ) {
      $blog_config[ 'blog_footer_counter' ] = 1;
    }

    if ( !isset( $blog_config[ 'blog_comments_moderation' ] ) ) {
      $blog_config[ 'blog_comments_moderation' ] = 0;
      }

    if ( !isset( $blog_config[ 'blog_counter_hours' ] ) ) {
      $blog_config[ 'blog_counter_hours' ] = 24;
    }

    // READ META-DATA INFORMATION
    $contents = sb_read_file( CONFIG_DIR.'metainfo.txt' );
    if ( $contents ) {
      $temp_configs = explode('|', $contents);
      $config_keys = array(   'info_keywords',
                  'info_description',
                  'info_copyright' );

      for ( $i = 0; $i < count( $temp_configs ); $i++ ) {
        $key = $config_keys[ $i ];
        $blog_config[ $key ] = $temp_configs[ $i ];
      }
    }

    if ( !isset( $blog_config[ 'info_keywords' ] ) ) {
      $blog_config[ 'info_keywords' ] = '';
    }

    if ( !isset( $blog_config[ 'info_description' ] ) ) {
      $blog_config[ 'info_description' ]= '';
    }

    if ( !isset( $blog_config[ 'info_copyright' ] ) ) {
      $blog_config[ 'info_copyright' ] = '';
    }


    $blog_config[ 'tracking_code' ] = read_trackingcode();
    $blog_config[ 'blog_footer_only' ] = $blog_config[ 'blog_footer' ];
    // Hack to put in Google Analytics, etc
    if ( isset( $blog_config[ 'tracking_code' ] ) ) {
    $blog_config[ 'blog_footer' ] .= $blog_config[ 'tracking_code' ];
    }

    // READ BLACKLIST
    $contents = sb_read_file( CONFIG_DIR.'blacklist.txt' );
    if ( $contents ) {
      $blog_config[ 'banned_address_list' ] = $contents;
    }

    if ( !isset( $blog_config[ 'banned_address_list' ] ) ) {
      $blog_config[ 'banned_address_list' ] = '';
    }

    // READ BANNED WORD LIST
    $contents = sb_read_file( CONFIG_DIR.'bannedwordlist.txt' );
    if ( $contents ) {
      $blog_config[ 'banned_word_list' ] = $contents;
    }

    if ( !isset( $blog_config[ 'banned_word_list' ] ) ) {
      $blog_config[ 'banned_word_list' ] = '';
    }

    // LOAD THEME
    global $blog_theme;
    $blog_theme = 'default';
    $contents = sb_read_file( CONFIG_DIR.'theme.txt' );
    if ( $contents ) {
      $blog_theme = $contents;
      $blog_config[ 'blog_theme' ] = $blog_theme;
    }
    require_once('themes/' . $blog_theme . '/themes.php');

    // LOAD COLORS
    read_colors();

    // Start GZIP Output
    if ( $blog_config[ 'blog_enable_gzip_output' ] ) {
      sb_gzoutput ();
    }
  }

  function write_config ( $blog_title, $blog_author, $blog_email, $blog_avatar, $blog_footer,
                          $blog_language, $blog_entry_order, $blog_comment_order, $blog_enable_comments,
                          $blog_max_entries, $blog_comments_popup, $comment_tags_allowed,
                          $blog_enable_gzip_txt, $blog_enable_gzip_output, $blog_email_notification,
                          $blog_send_pings, $blog_ping_urls, $blog_enable_voting, $blog_trackback_enabled,
                          $blog_trackback_auto_discovery, $blog_enable_cache, $blog_enable_calendar,
                          $blog_calendar_start, $blog_enable_title, $blog_enable_permalink, $blog_enable_stats,
                          $blog_enable_lastcomments, $blog_enable_lastentries, $blog_enable_capcha,
                          $blog_comment_days_expiry, $blog_enable_capcha_image, $blog_enable_archives,
                          $blog_enable_login, $blog_enable_counter, $blog_footer_counter, $blog_counter_hours,
                          $blog_comments_moderation, $blog_search_top, $blog_enable_static_block, $static_block_options,
                          $static_block_border, $blog_header_graphic, $blog_enable_start_category, $blog_enable_start_category_selection ) {
    // Save config information to file.
    //
    $array = array( clean_post_text( $blog_title ),
            clean_post_text( $blog_author ),
            clean_post_text( $blog_footer ),
            $blog_language,
            $blog_entry_order,
            $blog_comment_order,
            $blog_enable_comments,
            $blog_max_entries,
            $blog_comments_popup,
            $comment_tags_allowed,
            clean_post_text( $blog_email ),
            $blog_avatar,
            $blog_enable_gzip_txt,
            $blog_enable_gzip_output,
            $blog_email_notification,
            $blog_send_pings,
            clean_post_text( $blog_ping_urls ),
            $blog_enable_voting,
                $blog_trackback_enabled,
                $blog_trackback_auto_discovery,
            $blog_enable_cache,
            $blog_enable_calendar,
            $blog_calendar_start,
            $blog_enable_title,
            $blog_enable_permalink,
            $blog_enable_stats,
            $blog_enable_lastcomments,
            $blog_enable_lastentries,
            $blog_enable_capcha,
            $blog_comment_days_expiry,
            $blog_enable_capcha_image,
            $blog_enable_archives,
            $blog_enable_login,
            $blog_enable_counter,
            $blog_footer_counter,
            $blog_counter_hours,
            $blog_comments_moderation,
            $blog_search_top,
            $blog_enable_static_block,
            $static_block_options,
            $static_block_border,
            $blog_header_graphic,
						$blog_enable_start_category, 
						$blog_enable_start_category_selection );

		$str = implode('|', $array);

    if (!file_exists(CONFIG_DIR)) {
      $oldumask = umask(0);
      $ok = mkdir( CONFIG_DIR, 0777 );
      umask( $oldumask );
    }

    $filename = CONFIG_DIR.'config.txt';
    $result = sb_write_file( $filename, $str );

    $filename=CONFIG_DIR.'~blog_entry_listing.tmp';
    sb_delete_file( $filename );

    if ( $result ) {
      return ( true );
    } else {
      // Error:
      // Probably couldn't create file...
      return ( $filename );
    }
  }

  // ----------------
  // Meta Information
  // ----------------

  function write_metainfo ( $info_keywords, $info_description, $info_copyright, $tracking_code ) {
    // Save information to file.
    //
    $array = array( clean_post_text( $info_keywords ),
            clean_post_text( $info_description ),
            clean_post_text( $info_copyright ), );

    $str = implode('|', $array);

    if (!file_exists(CONFIG_DIR)) {
      $oldumask = umask(0);
      $ok = mkdir( CONFIG_DIR, 0777 );
      umask( $oldumask );
    }

    $filename = CONFIG_DIR.'metainfo.txt';
    $result = sb_write_file( $filename, $str );

    // OK now write the tracking code
    write_trackingcode( $tracking_code );

    if ( $result ) {
      return ( true );
    } else {
      // Error:
      // Probably couldn't create file...
      return ( $filename );
    }
  }

  // ----------------
  // Blacklist
  // ----------------

  function write_blacklist ( $address_list ) {
    // Save information to file.
    //
    if (!file_exists(CONFIG_DIR)) {
      $oldumask = umask(0);
      $ok = mkdir( CONFIG_DIR, 0777 );
      umask( $oldumask );
    }

    $filename = CONFIG_DIR.'blacklist.txt';
    $result = sb_write_file( $filename, $address_list );

    if ( $result ) {
      return ( true );
    } else {
      // Error:
      // Probably couldn't create file...
      return ( $filename );
    }
  }

  function write_bannedwordlist ( $banned_word_list ) {
    // Save information to file.
    //
    if (!file_exists(CONFIG_DIR)) {
      $oldumask = umask(0);
      $ok = mkdir( CONFIG_DIR, 0777 );
      umask( $oldumask );
    }

    $filename = CONFIG_DIR.'bannedwordlist.txt';
    $result = sb_write_file( $filename, $banned_word_list );

    if ( $result ) {
      return ( true );
    } else {
      // Error:
      // Probably couldn't create file...
      return ( $filename );
    }
  }

  function write_trackingcode ( $trackingcode ) {
    // Save information to file.
    //
    if (!file_exists(CONFIG_DIR)) {
      $oldumask = umask(0);
      $ok = mkdir( CONFIG_DIR, 0777 );
      umask( $oldumask );
    }


    $filename = CONFIG_DIR.'tracking_code.txt';
    $result = sb_write_file( $filename, $trackingcode );

    if ( $result ) {
      return ( true );
    } else {
      // Error:
      // Probably couldn't create file...
      return ( $filename );
    }
  }

  function read_trackingcode () {
    // Read information from file.
    //
    $trackingcode = '';
    $filename = CONFIG_DIR.'tracking_code.txt';
    if ( file_exists( $filename ) ) {
      $trackingcode = sb_read_file( $filename );
      $trackcode = sb_stripslashes( $trackingcode );
      return ($trackcode);
    }
  }

  function add_to_blacklist ( $new_address ) {
    // Save information to file.
    //
    if (!file_exists(CONFIG_DIR)) {
      $oldumask = umask(0);
      $ok = mkdir( CONFIG_DIR, 0777 );
      umask( $oldumask );
    }
    $filename = CONFIG_DIR.'blacklist.txt';
    $old_address_list = sb_read_file( $filename );


    $result = sb_write_file( $filename, trim( $new_address . chr(13) .$old_address_list  ) );

    if ( $result ) {
      return ( true );
    } else {
      // Error:
      // Probably couldn't create file...
      return ( $result );
    }
  }
  
  function get_installed_translations() {
    global $blog_config;
    
    $dir = 'languages/';  
    $translation_arr = array();;
    clearstatcache();
    
    if ( is_dir($dir) ) {
      $dhandle = opendir($dir);
      if ( $dhandle ) {
        $sub_dir = readdir( $dhandle );
        while ( $sub_dir ) {
          if ( is_dir( $dir . $sub_dir ) == true && $sub_dir != '.' && $sub_dir != '..' ) {
            $lang_dir = $sub_dir;
            $lang_name = sb_read_file( $dir . $sub_dir . '/id.txt' );
            if ( $lang_name ) {
              $lang_arr = array();
              $lang_arr['directory'] = $lang_dir;
              $lang_arr['name'] = $lang_name;
              
              array_push( $translation_arr, $lang_arr );
            }
          }
          $sub_dir = readdir( $dhandle );
        }
      }
      closedir( $dhandle );
    }
    
    return( $translation_arr );
  }
  
  function validate_language($temp_lang) {
    $translation_arr = get_installed_translations();
    $ok = false;
    for ($i=0; $i < count($translation_arr); $i++) {
      if ( $temp_lang === $translation_arr[$i]['directory'] ) {
        $ok = true;
        break;
      }
    }
    return( $ok );
  }

  // --------------
  // Theme Settings
  // --------------

  function write_theme ( $blog_theme ) {
    // Save theme information to file.
    //
    $array = array( clean_post_text( $blog_theme ) );

    $str = implode('|', $array);

    if (!file_exists(CONFIG_DIR)) {
      $oldumask = umask(0);
      $ok = mkdir(CONFIG_DIR, 0777 );
      umask($oldumask);
    }

    $filename = CONFIG_DIR.'theme.txt';
    $result = sb_write_file( $filename, $str );

    if ( $result ) {
      return ( true );
    } else {
      // Error:
      if ( file_exists( $filename ) ) {
        $str = 'Could not update file: '.$filename.'<br />';
      } else {
        $str = 'Could not create file: '.$filename.'<br />';
      }
      return ( $str );
    }
  }

  // ----------------------
  // Color Config Functions
  // ----------------------

  function write_colors ( $post_array, $user_file ) {
    // Save color information to file.
    //
    global $blog_theme;

    $str = implode('|', $post_array);

    if ( isset( $user_file ) ) {
      if (!file_exists(CONFIG_DIR.'schemes')) {
        $oldumask = umask(0);
        $ok = mkdir(CONFIG_DIR.'schemes', 0777 );
        umask($oldumask);
      }
      $custom_file = CONFIG_DIR.'schemes/' . $user_file . '.txt';
      $result = sb_write_file( $custom_file, $str );
    }

    $filename = CONFIG_DIR.'colors-' . $blog_theme . '.txt';
    $result = sb_write_file( $filename, $str );

    if ( $result ) {
      return ( true );
    } else {
      // Error:
      // Probably couldn't create file...
      return ( $filename );
    }
  }

  function read_colors ( ) {
    // Read color information from file.
    //
    global $user_colors, $blog_theme;
    $color_def = theme_default_colors();
    for ( $i = 0; $i < count( $color_def ); $i++ ) {
      $user_colors[ $color_def[$i][ 'id' ] ] = $color_def[$i][ 'default' ];
    }

    $filename = CONFIG_DIR.'colors-' . $blog_theme . '.txt';
    $result = sb_read_file( $filename );
    if ( $result ) {
      $saved_colors = explode('|', $result);
      for ( $i = 0; $i < count( $saved_colors ); $i = $i + 2 ) {
        $id = $saved_colors[$i];
        $color = $saved_colors[$i+1];
        $user_colors[ $id ] = $color;
      }
    }
  }

  function get_block_list () {
    // Create the right-hand block. Return array
    global $blog_content, $blog_subject, $blog_text, $blog_date, $user_colors, $logged_in;
    global $lang_string;

    // Read blocks file.
    $filename = CONFIG_DIR.'blocks.txt';
    $result = sb_read_file( $filename );

    $blocklist = array();
    if ( $result ) {
      $blocklist = explode('|', $result);
      for ( $i = 0; $i < count( $blocklist ); $i+=2 ) {
        $blocklist[ 'title' ] = blog_to_html( $blocklist[$i], false, false, false, true );
        $blocklist[ 'text' ] = blog_to_html( $blocklist[$i+1], false, false, false, true );
      }
    }
    return ( $blocklist );
  }
?>
