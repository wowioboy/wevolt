<?php
  // ---------------
  // INITIALIZE PAGE
  // ---------------
  require_once('scripts/sb_functions.php');
  global $logged_in;
  $logged_in = logged_in( false, true );
  
  read_config();
  
  require_once('languages/' . $blog_config[ 'blog_language' ] . '/strings.php');
  sb_language( 'static' );
  
  // ---------------
  // POST PROCESSING
  // ---------------
  
  $redirect = true;
  if ( array_key_exists( 'page', $_GET ) ) {    
    $redirect = false;
  }
  
  if ( $redirect === true ) {
    redirect_to_url( 'index.php' );
  }
  
  global $entry_array;
  $static_page = urldecode( $_GET[ 'page' ] );
  $static_page = preg_replace( '/(\s|\\\|\/|%|#)/', '_', $static_page );
  $entry_array = read_static_entry( $static_page, $logged_in );
  
  // ------------
  // PAGE CONTENT
  // ------------
  function page_content() {
    global $lang_string, $logged_in, $entry_array;
    
    echo( theme_staticentry( $entry_array, $logged_in ) );
  }
  
  // ----
  // HTML
  // ----
?>
  <?php echo( get_init_code() ); ?>
  <?php require_once('themes/' . $blog_theme . '/user_style.php'); ?>
  
  <title><?php echo($blog_config[ 'blog_title' ]); ?> - <?php echo( $entry_array[ 'subject' ] ); ?></title>
</head>
  <?php 
    // ------------
    // BEGIN OUTPUT
    // ------------
    theme_pagelayout();
  ?>
</html>
