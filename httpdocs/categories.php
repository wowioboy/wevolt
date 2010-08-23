<?php
  // ---------------
  // INITIALIZE PAGE
  // ---------------
  require_once('scripts/sb_functions.php');
  global $logged_in;
  $logged_in = logged_in( true, true );
  
  read_config();
  
  require_once('languages/' . $blog_config[ 'blog_language' ] . '/strings.php');
  sb_language( 'categories' );
  
  // ---------------
  // POST PROCESSING
  // ---------------
  if ( array_key_exists( 'category_list', $_POST ) ) {
    $catArray = phpValidate( $_POST[ 'category_list' ] );
    
    global $ok;
    $ok = false;
    if ($catArray !== false ) {
      if ($catArray === -1 ) {
        // Delete all categories.
        $ok = sb_delete_file( CONFIG_DIR.'categories.txt' );
      } else {
        $ok = write_categories( $catArray );
      }
    }
                
    if ( $ok === true ) { 
      redirect_to_url( 'index.php' );
    }
  }
  
  // PHP Validate results
  function phpValidate( $str ) {
    if ( $str == '' ) {
      // If the form is empty, then delete existing categories.
      return -1;
      
    } else {
      // Define the return character
      if ( strstr( $str, urldecode( '%0D%0A') ) !== false ) {
        // Windows
        $return_char = urldecode( '%0D%0A' );
      } else if ( strstr( $str, urldecode( '%0A' ) ) !== false ) {
        // Unix / Mac IE
        $return_char = urldecode( '%0A' );
      } else if ( strstr( $str, urldecode( '%0D' ) ) !== false ) {
        // Mac
        $return_char = urldecode( '%0D' );
      }
      
      // Split input into an array
      $input_arr = explode( $return_char, $str );
      if ( is_array( $input_arr ) == false ) {
        $input_arr = array( $str );
      }
      $valid_arr = Array();
      
      // Loop through the array, validate input.
      for ( $i=0; $i< count( $input_arr ); $i++ ) {
        $line_str = $input_arr[$i];
        if ( $line_str == '' ) {
          // Whoops! Empty Line. Skip it...
          continue;
        } else {
          // Search for the ID Number in parentheses... (###)
          $parentheses_start = strrpos( $line_str, '(' );
          $parentheses_end = strrpos( $line_str, ')' );
          if ( $parentheses_start === false || $parentheses_end === false || $parentheses_start >= $parentheses_end ) {
            // Whoops! parentheses missing...
            // echo( "Missing parentheses on line: " . $i . "\n\n" . $line_str . "<br />");
            return false;
          } else {
            // Grab ID
            $id_str = substr( $line_str, $parentheses_start+1, ( $parentheses_end - $parentheses_start - 1 ) );
            if ( $id_str == '' ) {
              // echo( "Missing 'Unique ID Number' on line: " . $i . "\n\n" . $line_str );
              return false;
            } else {
              $id_number = intVal( $id_str );
              if ( gettype( $id_number ) === 'integer' ) {
                // echo( "'" . $id_str . "' - '" . $id_number . "'<br />" );
              
                // So far so good... Now get rid of trailing spaces.
                $name_str = substr( $line_str, 0, $parentheses_start );
                while ( substr( $name_str, strlen( $name_str )-1, strlen( $name_str ) ) == ' ' ) {
                  $name_str = substr( $name_str, 0, strlen( $name_str ) - 1 );
                }
                
                // Count beginning spaces or &nbsp; characters...
                $space_count = 0;
                while ( substr( $name_str, 0, 1 ) == ' ' || substr( $name_str, 0, 1 ) == chr( 160 ) ) {
                  $name_str = substr( $name_str, 1, strlen( $name_str ) - 1 );
                  $space_count++;
                }
                
                if ( $name_str != '' ) {
                  // Okay, we've got all the parts...
                  $item_arr = Array( $id_number, clean_post_text( $name_str ), $space_count );
                  array_push( $valid_arr, $item_arr );
                  
                  // echo( "ID = ".$id_number.", NAME = '".$name_str."', DEPTH = ".$space_count."<br />" );
                } else {
                  // echo( "Missing 'Category Name' on line: " . $i . "\n\n" . $line_str );
                  return false;
                }
                
              } else {
                // echo( "'Unique ID' (" . $id_str . ") is not a number on line: " . $i . "\n\n" . $line_str );     
                return false;
              }
            }
          }
        }
      }
      
      // echo( "Success! " . count($valid_arr) . " categories validated!" );
      
      return $valid_arr;
    }
  }
  
  // ------------
  // PAGE CONTENT
  // ------------
  function page_content() {
    global $lang_string, $user_colors, $blog_config;
        
    // SUBJECT
    $entry_array = array();
    $entry_array[ 'subject' ] = $lang_string[ 'title' ];
    
    // PAGE CONTENT BEGIN
    ob_start(); ?>  
    
    <?php
      echo ( $lang_string[ 'instructions' ] . '<p />');
      echo ( '<b>' . $lang_string[ 'current_categories' ] . '</b><br />');
      
      $catArray = get_category_array();
      if ( count($catArray) > 0) {
        $str = '';
        for ( $i = 0; $i < count( $catArray ); $i++ ) {
          $id_number = $catArray[$i][0];
          $name_str = $catArray[$i][1];
          $space_count = $catArray[$i][2];
          for ( $j = 0; $j < $space_count; $j++ ) {
            $str  .= '&nbsp;';
          }
          $str  .= $name_str . ' (' . $id_number . ")<br />\n";
        }
        echo( $str );
      } else {
        echo( $lang_string[ 'no_categories_found' ] . '<br />' );
      }
    ?>
    
    
    <form action="categories.php" method="post" name="categories" id="categories" onsubmit="return validate(this)">
    <label for="category_list"><?php echo( $lang_string[ 'category_list' ] ); ?></label><br />
    <textarea style="width: <?php global $theme_vars; echo( $theme_vars[ 'max_image_width' ] ); ?>px;" id="category_list" name="category_list" rows="20" cols="50" autocomplete="OFF"><?php
      $catArray = get_category_array();
      if ( count($catArray) > 0) {
        $str = "";
        for ( $i = 0; $i < count( $catArray ); $i++ ) {
          $id_number = $catArray[$i][0];
          $name_str = $catArray[$i][1];
          $space_count = $catArray[$i][2];
          for ( $j = 0; $j < $space_count; $j++ ) {
            $str  .= ' ';
          }
          $str  .= $name_str . ' (' . $id_number . ")\n";
        }
        echo( $str );
      }
    ?></textarea><br />
      <br />
      <input type="button" class="bginput" value="<?php echo( $lang_string[ 'validate' ] ); ?>" onclick="validate(document.forms.categories);" />
      <input type="submit" name="submit" value="<?php echo( $lang_string[ 'submit_btn' ] ); ?>" />
    </form>
    
    <?php
    // PAGE CONTENT END
    $entry_array[ 'entry' ] = ob_get_clean();
    
    // THEME ENTRY
    echo( theme_staticentry( $entry_array ) );
  }
  
  // ----
  // HTML
  // ----
?>
  <?php echo( get_init_code() ); ?>
  <?php require_once('themes/' . $blog_theme . '/user_style.php'); ?>
  
  <script type="text/javascript">
    <!--
    function validate(theform) {
      if (theform.category_list.value == "" ) {
        // If the form is empty, then delete existing categories
        return true;
        
      } else {
        str = theform.category_list.value;
        
        // Define the return character
        if ( str.indexOf( unescape("%0D%0A") ) != -1 ) {
          // Windows
          return_char = unescape("%0D%0A");
        } else if ( str.indexOf( unescape("%0A") ) != -1 ) {
          // Unix / Mac IE
          return_char = unescape("%0A");
        } else if ( str.indexOf( unescape("%0D") ) != -1 ) {
          // Mac
          return_char = unescape("%0D");
        }
        
        // Split input into an array
        input_arr = str.split( return_char );
        valid_arr = Array();
          
        // Loop through the array, validate input.
        for ( i=0; i<input_arr.length; i++ ) {
          line_str = input_arr[i];
          if ( line_str == "" ) {
            // Whoops! Empty Line. Skip it...
            continue;
          } else {
            // Search for the ID Number in parentheses... (###)
            parentheses_start = line_str.lastIndexOf("(");
            parentheses_end = line_str.lastIndexOf(")");
            if ( parentheses_start == -1 || parentheses_end == -1 || parentheses_start >= parentheses_end ) {
              // Whoops! parentheses missing...
              alert( "Missing parentheses on line: " + (i+1) + "\n\n" + line_str );
              return false;
            } else {
              // Grab ID
              id_str = line_str.slice( parentheses_start+1, parentheses_end );
              if ( id_str == "" ) {
                alert( "Missing 'Unique ID Number' on line: " + (i+1) + "\n\n" + line_str );
                return false;
              } else {
                id_number = parseInt( id_str, 10 );
                if ( typeof id_number == "number" && isNaN(id_number) == false ) {
                
                  // So far so good... Now get rid of trailing spaces.
                  name_str = line_str.slice( 0, parentheses_start );
                  while ( name_str.charAt( name_str.length-1 ) == " " ) {
                    name_str .= substring( 0, name_str.length-1 );
                  }
                  
                  // Count beginning spaces or &nbsp; characters...
                  space_count = 0;
                  while ( name_str.charAt( 0 ) == " " ||  name_str.charCodeAt( 0 ) == 160 ) {
                    name_str .= substring( 1, name_str.length );
                    space_count++;
                  }
                  
                  if ( name_str != "" ) {
                    // Okay, we've got all the parts...
                    item_arr = Array( id_number, name_str, space_count );
                    valid_arr[valid_arr.length] = item_arr;
                    
                    // alert( id_number + " - " + name_str + " - " + space_count );
                  } else {
                    alert( "Missing 'Category Name' on line: " + (i+1) + "\n\n" + line_str );
                    return false;
                  }
                  
                } else {
                  alert( "'Unique ID' (" + id_str + ") is not a number on line: " + (i+1) + "\n\n" + line_str );      
                  return false;
                }
              }
            }
          }
        }
        alert( "Success! " + (valid_arr.length) + " categories validated!" );
        
        return true;
      }
    }
    //-->
  </script>
  <title><?php echo( $blog_config[ 'blog_title' ] ); ?> - <?php echo( $lang_string[ 'title' ] ); ?></title>
</head>
  <?php 
    // ------------
    // BEGIN OUTPUT
    // ------------
    theme_pagelayout();
  ?>
</html>
