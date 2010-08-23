<?php
  // ---------------
  // INITIALIZE PAGE
  // ---------------
  require_once('scripts/sb_functions.php');
  global $logged_in;
  $logged_in = logged_in( true, true );
  
  read_config();
  
  require_once('languages/' . $blog_config[ 'blog_language' ] . '/strings.php');
  sb_language( 'index' );
  
  // ---------------
  // POST PROCESSING
  // ---------------
  
  // ------------
  // PAGE CONTENT
  // ------------
  function page_content() {
  
    // SUBJECT
    $entry_array = array();
    $entry_array[ 'subject' ] = 'Downgrade';
    
    // PAGE CONTENT BEGIN
    ob_start();
    echo ( 'Deleted ' . delete_all_trackbacks() . ' trackback files...<p />');
    echo ( 'Moved ' . move_all_comment_files( false ) . ' comment files...');
    
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

  <title><?php echo($blog_config[ 'blog_title' ]); ?></title>
</head>
  <?php 
    // ------------
    // BEGIN OUTPUT
    // ------------
    theme_pagelayout();
  ?>
</html>
