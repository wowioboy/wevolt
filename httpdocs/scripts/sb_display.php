<?php

  // The Simple PHP Blog is released under the GNU Public License.
  //
  // You are free to use and modify the Simple PHP Blog. All changes
  // must be uploaded to SourceForge.net under Simple PHP Blog or
  // emailed to apalmo <at> bigevilbrain <dot> com

  // read_entries ( $m, $y, $d, $logged_in, $start_entry, $category )
  // get_latest_entry ()
  // blog_entry_listing ()
  // entry_exists ( $y, $m, $entry )                 
  // preview_entry ( $blog_subject, $blog_text, $tb_ping, $temp_relatedlink, $timestamp )
  // preview_static_entry ( $blog_subject, $blog_text )
  // read_entry_from_file ( $entry_id )

  // ----------------------
  // Blog Display Functions
  // ----------------------
  function in_arrayr($needle, $haystack) {
    if ( is_array($haystack) ) {
      // haystack is array
      foreach ($haystack as $value) {
        if (is_array($needle)) {
          // needle is array
          foreach ($needle as $needle_val) {
            $result = in_arrayr($needle_val, $value);
            if ( $result ) {
              return true;
            }
          }
        } else if (is_array($value)) {
          // value is array
          $result = in_arrayr($needle, $value);
          if ( $result ) {
            return true;
          }
        } elseif ($needle == $value) {
          return true;
        } else {
          return false;
        }
       }
    } else {
      // haystack is not array
      if (is_array($needle)) {
        // needle is array
        foreach ($needle as $needle_val) {
          $result = in_arrayr($needle_val, $haystack);
          if ( $result ) {
            return true;
          }
        }
      } else {
        // needle is not array
        if ( $needle == $haystack ) {
          return true;
        } else {
          return false;
        }
      }
    }
  }

  function read_entries ( $m, $y, $d, $logged_in, $start_entry, $category, $is_permalink=false ) {
    // Read entries by month, year and/or day. Generate HTML output.
    //
    // Used for the main Index page.
    global $lang_string, $blog_config, $user_colors, $theme_vars;

    $entry_file_array = blog_entry_listing();

    // Loop through the $entry_file_array looking for the
    // first match. Note that $d could be NULL in which
    // case we get the first entry for the month.
    //
    // This is fine because this is actually what we
    // are looking for anyway.
    //
    // I'm just using a brute force method, I'm sure there
    // are better ways to do this... :)
    if ( $start_entry != NULL ) {
      $look_for = $start_entry;
    } else {
      // 'dummy' entry name...
      $look_for = 'entry' . $y . $m . $d;
    }

    $entry_index = 0;
    for ( $i = 0; $i < count( $entry_file_array ); $i++ ) {
      if ( $look_for == substr( $entry_file_array[ $i ], 0, strlen( $look_for ) ) ) {
        // MATCH!
        $entry_index = $i;
        break;
      }
    }

    $blog_max_entries = $blog_config[ 'blog_max_entries' ];
    if ($is_permalink) {
      $blog_max_entries = 1;
    }

    // Grab the next X number of entries
    $file_array = array();
    if ( isset( $category ) ) {
      // Filter Entries by Category
      //
      // Unfortunately we actually have to open up the file
      // and read it to figure out what category the entry
      // belongs to. I think we should probably start saving
      // an index file of all the entries and categories.
      // I'm sure it would be faster when blogs start to have
      // to 1000's of entries.
      //

      $cat_sub_arr = get_sub_categories($category);
      array_push( $cat_sub_arr, $category );

      for ( $i = $entry_index; $i < count( $entry_file_array ); $i++ ) {
        list( $entry_filename, $year_dir, $month_dir ) = explode( '|', $entry_file_array[ $i ] );
        $blog_entry_data = blog_entry_to_array( CONTENT_DIR . $year_dir . '/' . $month_dir . '/' . $entry_filename );
        if ( array_key_exists( 'CATEGORIES', $blog_entry_data ) ) {
          $cat_array = explode( ',', $blog_entry_data[ 'CATEGORIES' ] );

          if ( in_arrayr( $cat_array, $cat_sub_arr ) ) {
            array_push( $file_array, $entry_file_array[ $i ] );
            // Look for +1 entries (for the next button...)
            if ( count( $file_array ) >= $blog_max_entries + 1 ) {
              break;
            }
          }
          /*
          for ( $j=0; $j < count($cat_array); $j++ ) {
            if ( $cat_array[ $j ] == $category ) {
              array_push( $file_array, $entry_file_array[ $i ] );
              // Look for +1 entries (for the next button...)
              if ( count( $file_array ) >= $blog_max_entries + 1 ) {
                // We've found all X entries.
                // Break out of the "j" and the "i" loops.
                break 2;
              } else {
                // We've added this entry to the list,
                // we don't want to accidently add the
                // entry again. (This is mainly here
                // for future expansion if we start
                // doing searches for multiple categories
                // at the same time...)
                break 1;
              }
            }
          }
          */
        }
      }

      // Store info for next and previous links...
      if ( count( $file_array ) > $blog_max_entries ) {
        $next_entry = array_pop( $file_array );
      } else {
        $next_entry = NULL;
      }

      // Now we have to search backwards...
      if ( $entry_index == 0 ) {
        $previous_entry = NULL;
      } else {
        $previous_file_array = array();
        for ( $i = $entry_index; $i >= 0; $i-- ) {
          list( $entry_filename, $year_dir, $month_dir ) = explode( '|', $entry_file_array[ $i ] );
          $blog_entry_data = blog_entry_to_array( CONTENT_DIR . $year_dir . '/' . $month_dir . '/' . $entry_filename );
          if ( array_key_exists( 'CATEGORIES', $blog_entry_data ) ) {
            $cat_array = explode( ',', $blog_entry_data[ 'CATEGORIES' ] );
            for ( $j=0; $j < count($cat_array); $j++ ) {
              if ( $cat_array[ $j ] == $category ) {
                array_push( $previous_file_array, $entry_file_array[ $i ] );
                // Look for +1 entries (for the next button...)
                if ( count( $previous_file_array ) >= $blog_max_entries + 1) {
                  // We've found all X entries.
                  // Break out of the "j" and the "i" loops.
                  break 2;
                } else {
                  // We've added this entry to the list,
                  // we don't want to accidently add the
                  // entry again. (This is mainly here
                  // for future expansion if we start
                  // doing searches for multiple categories
                  // at the same time...)
                  break 1;
                }
              }
            }
          }
        }

        $previous_entry = $previous_file_array[ count( $previous_file_array ) - 1 ];

        list( $entry_filename, $year_dir, $month_dir ) = explode( '|', $previous_entry );
        $entry = sb_strip_extension( $entry_filename );

        // Previous entry and current start entry are the same.
        if ( $entry == $start_entry ) {
          $previous_entry = NULL;
        }
      }
    } else {
      // No Filtering
      for ( $i = $entry_index; $i < min( ( $blog_max_entries + $entry_index ), count( $entry_file_array ) ); $i++ ) {
        array_push( $file_array, $entry_file_array[ $i ] );
      }

      // Store info for next and previous links...
      if ( $entry_index + $blog_max_entries < count( $entry_file_array ) ) {
        $next_entry = $entry_file_array[ $entry_index + $blog_max_entries ];
      } else {
        $next_entry = NULL;
      }

      $previous_entry = NULL;
      if ( $entry_index > 0 ) {
        if ( $entry_index - $blog_max_entries > 0 ) {
          $previous_entry = $entry_file_array[ $entry_index - $blog_max_entries ];
        } else {
          $previous_entry = $entry_file_array[ 0 ];
        }
      }
    }

    // Read entry files
    $contents = array();
    for ( $i = 0; $i < count( $file_array ); $i++ ) {
      list( $entry_filename, $year_dir, $month_dir ) = explode( '|', $file_array[ $i ] );
      array_push( $contents, array(   'entry' => $entry_filename,
                      'year' => $year_dir,
                      'month' => $month_dir ) );
    }

    // Flip entry order
    if ( $blog_config[ 'blog_entry_order' ] == 'old_to_new' ) {
      $contents = array_reverse( $contents );
    }

    $blog_content = '';
    $port = ':' . $_SERVER[ 'SERVER_PORT'];
    if ($port == ':80') {
      $port = '';
    }
    if ( $contents ) {
      if ( ( dirname($_SERVER[ 'PHP_SELF' ]) == '\\' || dirname($_SERVER[ 'PHP_SELF' ]) == '/' ) ) {
        // Hosted at root.
        $base_permalink_url = 'http://'.$_SERVER[ 'HTTP_HOST' ].$port.'/';
      } else {
        // Hosted in sub-directory.
        $base_permalink_url = 'http://'.$_SERVER[ 'HTTP_HOST' ].$port.dirname($_SERVER[ 'PHP_SELF' ]).'/';
      }

      // I'm putting this check in here for people who have made
      // custom themes before I added these values...
      global $theme_vars;
      if ( is_array( $theme_vars ) ) {
        if ( isset( $theme_vars[ 'popup_window' ][ 'width' ] ) === false ) {
          $theme_vars[ 'popup_window' ][ 'width' ] = 500;
        }
        if ( isset( $theme_vars[ 'popup_window' ][ 'height' ] ) === false ) {
          $theme_vars[ 'popup_window' ][ 'height' ] = 500;
        }
        if ( isset( $theme_vars[ 'options'][ 'disallow_colors' ] ) === false ) {
          $theme_vars[ 'options'][ 'disallow_colors' ] = 0;
        }
      } else {
        $theme_vars = array();
        $theme_vars[ 'popup_window' ][ 'width' ] = 500;
        $theme_vars[ 'popup_window' ][ 'height' ] = 500;
        $theme_vars[ 'options'][ 'disallow_colors' ] = 0;
      }

      for ( $i = 0; $i <= count( $contents ) - 1; $i++ ) {
        // Read and Parse Blog Entry
        $blog_entry_data = blog_entry_to_array( CONTENT_DIR . $contents[$i][ 'year' ] . '/' . $contents[$i][ 'month' ] . '/' . $contents[$i][ 'entry' ] );

        $entry_array = array();

        // Subject / Date
        // blog_to_html( $str, $comment_mode, $strip_all_tags, $add_no_follow=false, $emoticon_replace=false )
        $entry_array[ 'subject' ] = blog_to_html( $blog_entry_data[ 'SUBJECT' ], false, false, false, true );
        $entry_array[ 'date' ] = blog_to_html( format_date( $blog_entry_data[ 'DATE' ] ), false, false );
        $entry_array[ 'date_numeric_day' ] = blog_to_html( format_date_class( $blog_entry_data[ 'DATE' ],'NUMDAY' ), false, false );
        $entry_array[ 'date_numeric_month' ] = blog_to_html( format_date_class( $blog_entry_data[ 'DATE' ],'NUMMONTH' ), false, false );
        $entry_array[ 'date_numeric_year' ] = blog_to_html( format_date_class( $blog_entry_data[ 'DATE' ],'NUMYEAR' ), false, false );
        $entry_array[ 'date_alpha_month' ] = blog_to_html( format_date_class( $blog_entry_data[ 'DATE' ],'ALPHAMONTH' ), false, false );
        $entry_array[ 'date_numeric_time' ] = blog_to_html( format_date_class( $blog_entry_data[ 'DATE' ],'TIMENORMAL' ), false, false );
        $entry_array[ 'date_suffix_day' ] = blog_to_html( format_date_class( $blog_entry_data[ 'DATE' ],'SUFFIXDAY' ), false, false );

        // Categories
        if ( array_key_exists( 'CATEGORIES', $blog_entry_data ) ) {
          $temp_cat_array = explode( ',', $blog_entry_data[ 'CATEGORIES' ] );
          $temp_cat_names = Array();
          for ( $j = 0; $j < count( $temp_cat_array ); $j++ ) {
            array_push( $temp_cat_names, get_category_by_id ( $temp_cat_array[$j] ) );
          }
          $entry_array[ 'categories' ] = $temp_cat_names;
          $entry_array[ 'categories_id'] = $temp_cat_array;
        }

        // Read More link
        if ( array_key_exists( 'relatedlink', $blog_entry_data ) ) {
        $entry_array[ 'relatedlink' ][ 'name' ] = $lang_string[ 'sb_relatedlink' ];
        $entry_array[ 'relatedlink' ][ 'url' ] = $blog_entry_data[ 'relatedlink' ];
        }

        // Author edit and delete
        $entry = sb_strip_extension( $contents[$i][ 'entry' ] );
        $y = sb_strip_extension( $contents[$i][ 'year' ] );
        $m = sb_strip_extension( $contents[$i][ 'month' ] );
        //$blog_entry_data[ 'CREATEDBY' ]
        $admin = $_SESSION[ 'fulladmin' ];
        if ( (( $logged_in == true ) and ( $admin == 'yes' )) or
           (( $logged_in == true) and ( $admin == 'no' ) and ( CheckUserSecurity( $_SESSION[ 'username' ], 'EDIT' ) == true ) and ( $blog_entry_data[ 'CREATEDBY' ] != $_SESSION[ 'username' ]) ) or
           (( $logged_in == true) and ( $admin == 'no' ) and ( $blog_entry_data[ 'CREATEDBY' ] == $_SESSION[ 'username' ]) ))
        {
          $entry_array[ 'edit' ][ 'name' ] = $lang_string[ 'sb_edit' ];
          $entry_array[ 'edit' ][ 'url' ] = 'preview_cgi.php?y='.$y.'&amp;m='.$m.'&amp;entry='.$entry;
        }

        if ( (( $logged_in == true ) and ( $admin == 'yes' )) or
           (( $logged_in == true) and ( $admin == 'no' ) and ( CheckUserSecurity( $_SESSION[ 'username' ], 'DEL' ) == true ) ))
        {
          $entry_array[ 'delete' ][ 'name' ] = $lang_string[ 'sb_delete' ];
          $entry_array[ 'delete' ][ 'url' ] = 'delete.php?y='.$y.'&amp;m='.$m.'&amp;entry='.$entry;
        }

        $entry_array[ 'permalink' ][ 'name' ] = $lang_string[ 'sb_permalink' ];
        $entry_array[ 'permalink' ][ 'url' ] = $base_permalink_url . 'index.php?entry=' . $entry;

        // // blog_to_html( $str, $comment_mode, $strip_all_tags, $add_no_follow=false, $emoticon_replace=false )
        $entry_array[ 'entry' ] = blog_to_html( $blog_entry_data[ 'CONTENT' ], false, false, false, true ) . '<br clear="all" />';

        // Comments link and count
        $comment_trackback_base = CONTENT_DIR.$y.'/'.$m.'/'.$entry.'/';
        $comment_path = $comment_trackback_base.'comments/';
        $comment_array = sb_folder_listing( $comment_path, array( '.txt', '.gz' ) );

        // This is not a real count if some of the items haven't been modded yet...
        if ( $blog_config[ 'blog_enable_comments' ] == true ) {
          if ( $logged_in == true ) {
            $comment_count = count( $comment_array );
          } else if ( $blog_config[ 'blog_comments_moderation' ] != true ) {
            $comment_count = count( $comment_array );
          } else {
            // Cycle through the comments if there are some and find out how many are modded
            if ( count( $comment_array ) != 0) {
              $comment_count = count( $comment_array ) - get_entry_unmodded_count($y, $m, $entry);
            } else {
              $comment_count = 0;
            }
          }
        } else {
          $comment_count = 0;
        }

        // Trackbacks link and count
        $trackback_path = $comment_trackback_base.'trackbacks/';
        $trackback_array = sb_folder_listing( $trackback_path, array( '.txt', '.gz' ) );
        $trackback_count = count( $trackback_array );

        // Read view counter file
        $view_counter = 0;
        $view_array = sb_folder_listing( $comment_trackback_base, array( '.txt' ) );
        if ( in_array( 'view_counter.txt', $view_array ) ) {
          $view_counter = intval( sb_read_file( $comment_trackback_base . 'view_counter.txt' ) );
        }

        // Entry Rating
        if ( $blog_config[ 'blog_enable_voting' ] == true ) {
          $rating_array = read_rating( $y, $m, $entry );
          if ( $rating_array ) {
            $points = $rating_array[ 'points' ];
            $votes = $rating_array[ 'votes' ];
            $rating = $points / $votes / 5;
          } else {
            $points = 0;
            $votes = 0;
            $rating = 0;
          }

          global $blog_theme;
          $str = '';
          for ( $star_number = 1; $star_number <= 5; $star_number++ ) {
            $temp_ratio = ( $star_number / 5 );
            if ( $rating >= ( $temp_ratio - .2 ) && $rating < ( $temp_ratio - .1 ) ) {
              $star_image = 'no_star.png';
            } else if ( $rating >= ( $temp_ratio - .1 ) && $rating < $temp_ratio ) {
              $star_image = 'half_star.png';
            } else if ( $rating >= $temp_ratio ) {
              $star_image = 'full_star.png';
            } else {
              $star_image = 'no_star.png';
            }
            $str  .= '<a rel="nofollow" href="rate_cgi.php?y=' . $y . '&amp;m=' . $m . '&amp;entry=' . $entry . '&amp;rating=' . $star_number . '" title="' . $lang_string[ 'sb_rate_entry_btn' ] . '"><img src="themes/' . $blog_theme . '/images/stars/' . $star_image . '" alt="" border="0" /></a>';
          }
          $entry_array[ 'stars_nototals' ] = $str;
          $str  .= ' ( ' . round( $rating * 5, 1 ) . ' / ' . $votes . ' )';
          $entry_array[ 'stars' ] = $str;
        }

        // Has to be populated regardless - used by the more tag
        if ( $blog_config[ 'blog_comments_popup' ] == 1 ) {
          $entry_array[ 'comment' ][ 'url' ] = 'javascript:openpopup(\'comments.php?y='.$y.'&amp;m='.$m.'&amp;entry='.$entry.'\','.$theme_vars[ 'popup_window' ][ 'width' ].','.$theme_vars[ 'popup_window' ][ 'height' ].',true)';
        } else {
          $entry_array[ 'comment' ][ 'url' ] = 'comments.php?y='.$y.'&amp;m='.$m.'&amp;entry='.$entry;
        }

        // Comments / Read - will show regardless of comments being enabled
        if ( $blog_config[ 'blog_enable_comments' ] == true ) {
          $commenttext = $lang_string[ 'sb_comment_btn' ];
          $commentplural = $lang_string[ 'sb_comments_plural_btn' ];
          $comment = $lang_string[ 'sb_add_comment_btn' ];
        } else {
          $commenttext = $lang_string[ 'sb_comment_view' ];
          $commentplural = $lang_string['sb_comments_plural_view'];
          $comment = $lang_string['sb_read_entry_btn'];
        }

        // Add comment buttons
        if ( $comment_count == 0) {
          // [ add comment ]
          $entry_array[ 'comment' ][ 'name' ] = $comment;
        } else if ( $comment_count == 1) {
          // [ 1 comment ] (In Russian the number should come last.)
          if ( $lang_string[ 'sb_comment_btn_number_first' ] == true ) {
            $entry_array[ 'comment' ][ 'name' ] = $comment_count . ' ' . $commenttext;
          } else {
            $entry_array[ 'comment' ][ 'name' ] = $commenttext . ' ' . $comment_count;
          }
        } else {
          // [ n comments ] (In Russian the number should come last.)
          if ( $lang_string[ 'sb_comments_plural_btn_number_first' ] == true ) {
            $entry_array[ 'comment' ][ 'name' ] = $comment_count . ' ' . $commentplural;
          } else {
            $entry_array[ 'comment' ][ 'name' ] = $commentplural . ' ' . $comment_count;
          }
        }

        $entry_array[ 'comment' ][ 'comment_count' ] = $comment_count;

        // Add view counter
        if ( $view_counter > 0 ) {
          if ( $view_counter == 1) {
            $entry_array[ 'comment' ][ 'count' ] = $lang_string[ 'sb_view_counter_pre' ] . $view_counter . $lang_string[ 'sb_view_counter_post' ];
          } else {
            $entry_array[ 'comment' ][ 'count' ] = $lang_string[ 'sb_view_counter_plural_pre' ] . $view_counter . $lang_string[ 'sb_view_counter_plural_post' ];
          }
        }

        $entry_array[ 'entry' ] = replace_more_tag ( $entry_array[ 'entry' ] , false, $entry_array[ 'comment' ][ 'url' ] );

        // Trackback
        if ( $blog_config[ 'blog_trackback_enabled' ] == true ) {
          if ( $blog_config[ 'blog_comments_popup' ] == 1 ) {
            $entry_array[ 'trackback' ][ 'url' ] = 'javascript:openpopup(\'trackback.php?y='.$y.'&amp;m='.$m.'&amp;entry='.$entry.'&amp;__mode=html\','.$theme_vars[ 'popup_window' ][ 'width' ].','.$theme_vars[ 'popup_window' ][ 'height' ].',true)';
          } else {
            $entry_array[ 'trackback' ][ 'url' ] = 'trackback.php?y='.$y.'&amp;m='.$m.'&amp;entry='.$entry.'&amp;__mode=html';
          }

          $entry_array[ 'trackback' ][ 'ping_url' ] = $base_permalink_url . 'trackback.php?y='.$y.'&amp;m='.$m.'&amp;entry='.$entry;

          // [ n trackbacks ] (In Russian the number should come last.)
          if ( $lang_string[ 'sb_comment_btn_number_first' ] == true ) {
            $entry_array[ 'trackback' ][ 'name' ] = $trackback_count . ' ' . $lang_string[ 'sb_trackback' ];
          } else {
            $entry_array[ 'trackback' ][ 'name' ] = $lang_string[ 'sb_trackback' ] . ' ' . $trackback_count;
          }
        }

        // New 0.4.8
        if ( array_key_exists( 'IP-ADDRESS', $blog_entry_data ) ) {
          $entry_array[ 'ip-address' ] = $blog_entry_data[ 'IP-ADDRESS' ];
        }

        if ( array_key_exists( 'CREATEDBY', $blog_entry_data ) ) {
          $entry_array[ 'createdby' ][ 'text' ] = $lang_string[ 'sb_postedby' ] . ' ' . Get_Fullname( $blog_entry_data[ 'CREATEDBY' ] );
          $entry_array[ 'createdby' ][ 'name' ] = Get_Fullname( $blog_entry_data[ 'CREATEDBY' ] );
          $entry_array[ 'avatarurl' ] = Get_AvatarUrl( $blog_entry_data[ 'CREATEDBY' ] ); 
        }

        $entry_array[ 'count' ] = $i;
        $entry_array[ 'maxcount' ] = count( $contents ) - 1;
        $entry_array[ 'logged_in' ] = $logged_in;
        $entry_array[ 'id' ] = $entry;

          $blog_content  .= theme_blogentry( $entry_array );
      }
    }

    $blog_content  .= '<br />';

    // Figure out page count - need this first for the First and Last links
    $pages_array = array();
    $current_page = 0;
    for ( $p = 0; $p < count( $entry_file_array ); $p += $blog_config[ 'blog_max_entries' ] ) {
      array_push( $pages_array, $entry_file_array[ $p ] );
      if ($entry_index >= $p && $entry_index < $p + $blog_config[ 'blog_max_entries' ]) {
        $current_page = count($pages_array)-1;
      }
    }

    $blog_content  .= '<center><b>';

    // Display First link if we are not on the first page
    if ($current_page > 0) {
      list( $entry_filename, $year_dir, $month_dir ) = explode( '|', $pages_array[0] );
      $blog_content  .= '<span><a href="index.php?m=' . $month_dir . '&amp;y=' . $year_dir . '&amp;d=' . $d . '&amp;entry=' . sb_strip_extension( $entry_filename );
      $blog_content  .= '">&#60;&#60;' . $lang_string['nav_first'] . '&#32;&#32;</a></span>';
    }

    // Display Back lin if required
    if ( $previous_entry != NULL ) {
      list( $entry_filename, $year_dir, $month_dir ) = explode( '|', $previous_entry );
      $d = substr( $entry_filename, 9, 2 );
      $blog_content  .= '<span><a href="index.php?m=' . $month_dir . '&amp;y=' . $year_dir . '&amp;d=' . $d . '&amp;entry=' . sb_strip_extension( $entry_filename );
      if ( $category != NULL ) {
        $blog_content  .= '&amp;category=' . $category;
      }
      $blog_content  .= '"> &#60;' . $lang_string[ 'nav_back' ] . '&#32;&#32;</a></span> ';
    }

    // Display page count
    $pagestoshow = 10;
    if (count($pages_array) > 0) {
      $blog_content .= '<span>|&#32;';

      $startpage = $current_page;

      // Test to see if we need to show previous pages in order to show all of the current visible pages
      $remainingpages = (count($pages_array) - $current_page);
      if ( $remainingpages < $pagestoshow ) {
        $startpage = $current_page - ($pagestoshow - $remainingpages);
      }
      if ( $startpage < 0 ) { $startpage = 0; }

      for ( $p = $startpage; $p < count( $pages_array ); $p++ ) {
        list( $entry_filename, $year_dir, $month_dir ) = explode( '|', $pages_array[$p] );
        $d = substr( $entry_filename, 9, 2 );

        // Only show a limited number of page links at the bottom
        if ( $pagestoshow < 1 ) { Break; }

        if ($current_page == $p) {
          $blog_content  .= ($p + 1) . ' | ';
        } else {
          $blog_content  .= '<a href="index.php?m=' . $month_dir . '&amp;y=' . $year_dir . '&amp;d=' . $d . '&amp;entry=' . sb_strip_extension( $entry_filename );
          if ( $category != NULL ) {
            $blog_content  .= '&amp;category=' . $category;
          }
          $blog_content  .= '">' . ($p + 1) . '</a>&#32;|&#32;';
        }
        $pagestoshow = $pagestoshow - 1;
      }
      $blog_content .= '</span>';
    }

    if ( $next_entry != NULL ) {
      list( $entry_filename, $year_dir, $month_dir ) = explode( '|', $next_entry );
      $d = substr( $entry_filename, 9, 2 );
      $blog_content  .= ' <span><a href="index.php?m=' . $month_dir . '&amp;y=' . $year_dir . '&amp;d=' . $d . '&amp;entry=' . sb_strip_extension( $entry_filename );
      if ( $category != NULL ) {
        $blog_content  .= '&amp;category=' . $category;
      }
      $blog_content  .= '">' . $lang_string[ 'nav_next' ] . '&#62;&#32;&#32;</a></span> ';
    }

    // Display Last link if we are not on the last page
    if ( $next_entry != NULL ) {
      list( $entry_filename, $year_dir, $month_dir ) = explode( '|', $pages_array[count($pages_array)-1] );
      $blog_content  .= '<span><a href="index.php?m=' . $month_dir . '&amp;y=' . $year_dir . '&amp;d=' . $d . '&amp;entry=' . sb_strip_extension( $entry_filename );
      $blog_content  .= '">&#32;&#32;' . $lang_string['nav_last'] . '&#62;&#62;</a></span>';
    }
    $blog_content  .= '</center></b><br />';

    // Check for intervening static entries to be shown before current entries...

    // 2) Selected block (with or without border ie using CSS - without border handy for those with wide ads)
    if ( $blog_config[ 'blog_enable_static_block' ] == true ) {
    $entry_array = array();
    $spec_block = get_specific_block( $blog_config[ 'static_block_options' ] );
      if ( is_array( $spec_block ) ) {
        $entry_array[ 'entry' ] = $spec_block[ 'text' ];
        $entry_array[ 'subject' ] = $spec_block[ 'title' ];
        $bordertype = $blog_config[ 'static_block_border' ];
        if ( $bordertype == 'noborder' ) {
          $blog_content = theme_genericentry( $entry_array, 'clear' ) . $blog_content;
        } else {
          $blog_content = theme_blogentry( $entry_array ) . $blog_content;
        }
      }
    }

    // 1) Search box
    if ( $blog_config[ 'blog_search_top' ] == true ) {
      $entry_array = array();
      $search = array();
      $search = menu_search_field_horiz();
      $entry_array[ 'entry' ] = $search[ 'content' ];
      $blog_content = theme_genericentry( $entry_array, 'solid' ) . $blog_content;
    }

    return $blog_content;
  }

  function get_specific_block ( $title ) {
    // Create the right-hand block. Return single entry
    global $blog_content, $blog_subject, $blog_text, $blog_date, $user_colors, $logged_in;
    global $lang_string;

    // Read blocks file.
    $filename = CONFIG_DIR.'blocks.txt';
    $result = sb_read_file( $filename );

    // Match against title - nothing else to match against (no keys used)
    // Append new blocks.
    $block = array();
    if ( $result ) {
      $array = explode('|', $result);
      for ( $i = 0; $i < count( $array ); $i+=2 ) {
        $block[ 'title' ] = blog_to_html( $array[$i], false, false, false, true );
        $block[ 'text' ] = blog_to_html( $array[$i+1], false, false, false, true );
        if ( $block[ 'title' ] == $title ) {
          return ( $block );
        }
      }
    }
  }

  function get_fullname( $username ) {
    global $lang_string;

    // admin only
    if ( $username == 'admin' ) {
      $fullname = $lang_string['sb_admin'];
      return ( $fullname );
    }

    // Go to the users database and get the user name
    if ( $username == '' ) {
      $fullname = $lang_string['sb_admin'];
      return ( $fullname );
    } else {
      $pfile = fopen(CONFIG_DIR."users.php","a+");
      rewind($pfile);
      while (!feof($pfile)) {
        $line = fgets($pfile);
        $tmp = explode('|', $line);
        if ( $tmp[1] == $username ) {
          $fullname = $tmp[0];
          fclose($pfile);
          return ( $fullname );
        }
      }
    }
    fclose($pfile);
    return ( $lang_string['sb_admin'] );
  }

  function get_avatarurl( $username ) {
    // Go to the users database and get the user name
    if ( $username != '' ) {
      $pfile = fopen(CONFIG_DIR."users.php","a+");
      rewind($pfile);
      while (!feof($pfile)) {
        $line = fgets($pfile);
        $tmp = explode('|', $line);
        if ( $tmp[1] == $username ) {
          $avatarurl = $tmp[3];
          fclose($pfile);
          return ( $avatarurl );
        }
      }
    }
    if (isset($pfile)) {
      fclose($pfile);}
  }

  function CheckUserSecurity( $username, $type ) {
    // Go to the users database and get the user name
    if ( $username != '' ) {
      $answer = false;
      $pfile = fopen(CONFIG_DIR."users.php","a+");
      rewind($pfile);
      while (!feof($pfile)) {
        $line = fgets($pfile);
        $tmp = explode('|', $line);
        if ( $tmp[1] == $username ) {
          if ( ($type == 'MOD') and ($tmp[6] == 'Y')) {
            $answer = true;
          } elseif ( ($type == 'DEL') and ($tmp[7] == 'Y