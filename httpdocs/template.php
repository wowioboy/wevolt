<?php
  // Standard SPHPBlog Setup
  // -------------------
  
  // Load/Include Functions
  require_once('scripts/sb_functions.php');
  
  /*
    Check Login (See scripts/sb_login.php for details)
    ---------
    logged_in( false, true );   <-- Anyone can view this page.
    logged_in( true, true );  <-- Redirects to index.php if you are NOT logged in.
  */
  global $logged_in;
  $logged_in = logged_in( true, true );
  
  /*
    Read Configuration (See scripts/sb_config.php for details.)
    --------------
    Loads values into $blog_config global associative array.
  */
  read_config();
  
  /*
    Load/Define Language Strings
    ----------------------
    In most cases you won't be adding new strings
    to the strings.php file unless you are developing
    something for release.
  */
  require_once('languages/' . $blog_config[ 'blog_language' ] . '/strings.php');
  sb_language( 'index' );
  
  // -------------
  // POST PROCESSING
  // -------------
  
  /*
    Validate your GET and POST data here...
  */
  
  // -----------
  // PAGE CONTENT
  // -----------
  
  /*
    Page Content
    ----------
    Your actual page content will go INSIDE the
    page_content() function below. This function gets
    called from inside the theme_pagelayout() function
    at the bottom of this file...
  */
  
  function page_content() {
    /*
      Page Content
      ----------
      If you want your content to be wrapped inside the normal
      "Entry" box, then use the $entry_array associative array
      to pass your content to the theme_staticentry() function
      located in themes/{theme_name}/themes.php
    */
    $entry_array = array();
    $entry_array[ 'subject' ] = 'Subject Line';
    $entry_array[ 'entry' ] = 'Body Content<br /><a href="http://www.google.com/">Google</a>';
    
    echo( theme_staticentry( $entry_array ) );
    
    // HTML Content
    // ----------
    // You can also break out of PHP here and use HTML:
    ?>
      Here is some raw HTML content...<br /><br />-- Alex.
    <?php 
    // ...now we're back in PHP and we're still inside
    // the page_content function...
  }
  
  // ----
  // HTML
  // ----
  
  /*
    Start HTML Page
    -------------
    You'll notice that some stuff is dynamically included
    in the HTML code. These include: charset, css style
    sheet from the theme, (an additional style that over
    write the default colors), and the page title.
  */
?>
  <?php echo( get_init_code() ); ?>
  <?php require_once('themes/' . $blog_theme . '/user_style.php'); ?>
  
  <title><?php echo($blog_config[ 'blog_title' ]); ?></title>
</head>
  <?php 
    /*
      Generate Page
      -----------
      The function below is what actually starts outputting all
      of the dynamic content. Including the <body> tags, the
      menus, the content, etc... This function calls the
      page_content() function above...
      
      Refer to themes/{theme_name}/themes.php for more details.
    */
    
    // BEGIN OUTPUT
    theme_pagelayout();
  ?>
</html>
