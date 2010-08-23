<?php
  // ---------------
  // INITIALIZE PAGE
  // ---------------
  require_once('scripts/sb_functions.php');
  global $logged_in;
  $logged_in = logged_in( false, true );
  
  read_config();
  
  require_once('languages/' . $blog_config[ 'blog_language' ] . '/strings.php');
  sb_language( 'rating' );
  
  // ---------------
  // POST PROCESSING
  // ---------------
  if ( array_key_exists( 'y', $_GET ) && array_key_exists( 'm', $_GET ) && array_key_exists( 'entry', $_GET ) && array_key_exists( 'rating', $_GET ) ) {
    $rating = intval( $_GET[ 'rating' ] );
    if ( $rating >= 1 && $rating <= 5 ) {   
      if ( strpos( $_GET[ 'y' ], array( '/', '.', '\\', '%' ) ) === false && strlen( $_GET[ 'y' ] ) == 2 &&
          strpos( $_GET[ 'm' ], array( '/', '.', '\\', '%' ) ) === false && strlen( $_GET[ 'm' ] ) == 2 &&
          strpos( $_GET[ 'entry' ], array( '/', '.', '\\', '%' ) ) === false && strlen( $_GET[ 'entry' ] ) == 18 ) {
        $y = $_GET[ 'y' ];
        $m = $_GET[ 'm' ];
        $entry = $_GET[ 'entry' ];
        if ( entry_exists( $y, $m, $entry ) ) {
          write_rating( $y, $m, $entry, $rating );
        }
      }
    }
  }
  
  // Even if it failed to store the vote, we still want to return to the home page.
  $ok = true;
  if ( $ok === true ) {
    redirect_to_url( 'index.php' );
  }
  
  // ------------
  // PAGE CONTENT
  // ------------
  function page_content() {
    global $lang_string, $blog_config, $ok;
    
    // SUBJECT
    $entry_array = array();
    $entry_array[ 'subject' ] = $lang_string[ 'title' ];
    
    // PAGE CONTENT BEGIN
    ob_start();
    
    if ( $ok !== true ) {
      echo( $lang_string[ 'error' ] . $ok . '<p />' );
    } else {
      echo( $lang_string[ 'success' ] . '<p />' );
    }
    echo( '<a href="index.php">' . $lang_string[ 'home' ] . '</a>' );
    
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
  
  <title><?php echo($blog_config[ 'blog_title' ]); ?> - <?php echo( $lang_string[ 'title' ] ); ?></title>
</head>
  <?php 
    // ------------
    // BEGIN OUTPUT
    // ------------
    theme_pagelayout();
  ?>
</html>
